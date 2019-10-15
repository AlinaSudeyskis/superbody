<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use YandexCheckout\Client;
use YandexCheckout\Request\Payments\CreatePaymentResponse;
use YandexCheckout\Request\Payments\Payment\CreateCaptureResponse;

/**
 * Класс Payment
 *
 * Класс для создания, проверки, обновления данных о платежах пользователя
 *
 * @author Alina Sudeyskis <alina.sudeyskis@gmail.com>
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Payment extends CI_Controller
{
    const CURRENCY = 'RUB';
    const PAYMENT_METHOD = 'bank_card';

    // LIVE
    const SHOPID = 618322;
    const SHOP_SECRET = 'live_2nfgVKxGM_SlkoxHTMP_ERbaAQnWTPqBTTujQEzY6gA';
    // TEST
    /*const SHOPID = 621847;
    const SHOP_SECRET = 'test_8DwS0C9xbKd91QI-h0QjNj5k2uDIJ03HncRmySb5s7k';*/

    /**
     * Payment constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Payment_model');
    }

    /* БЛОК ФУНКЦИЙ ОПЛАТЫ */

    /**
     * Формирование запроса на создание платежа Яндекс.Кассы
     */
    public function payment()
    {
        // Вариант оплаты (полный, разделить на месяцы)
        $options = array('full_payment', 'partial_payment');
        // Способ оплаты
        $methods = array('bank_card', 'yandex_money', 'sberbank', 'qiwi', 'webmoney', 'alfabank');
        // Способы оплаты с доп. данными (телефон)
        $phone_methods = array('qiwi', 'sberbank');
        // Способы оплаты с доп. данными (логин)
        $login_methods = array('alfabank');

        $order_id       = is_numeric($this->input->get('oid', true)) ? $this->input->get('oid', true) : null;
        $total_amount   = is_numeric($this->input->get('amount', true)) ? $this->input->get('amount', true) : null;
        $payment_option = (in_array($this->input->get('option', true), $options))
            ? $this->input->get('option', true)
            : 'full_payment';
        $payment_type   = (in_array($this->input->get('type', true), $methods) and $payment_option == 'full_payment')
            ? $this->input->get('type', true)
            : 'bank_card';

        // Данные для способа оплаты
        $phone        = is_numeric($this->input->get('phone', true)) ? $this->input->post('phone', true) : null;
        $method_phone = (in_array($payment_type, $phone_methods)) ? $phone : null;
        $login        = strip_tags($this->input->post('login', true));
        $method_login = (in_array($payment_type, $login_methods)) ? $login : null;

        $customer_email = $this->input->get('customer_email', true);
        $order_items    = $this->input->get('order_items', true);

        $return_url = $this->input->get('return_url', true);

        /*log_message('debug', __METHOD__ . ' ' . __LINE__ . '. Response Payment data: '. $order_id . ' ' . $total_amount . ' '
            . $payment_type . ' ' . $payment_option . ' ' . $method_phone . ' ' . $method_login);*/

        //log_message('debug', 'Order items: ' . print_r($order_items, true));

        if (!empty($order_id) and !empty($total_amount) and !empty($payment_option))
        {
            // Создание платежа
            $res_create = self::createPayment($order_id, $total_amount, self::CURRENCY, $payment_type, $payment_option, '',
                $method_phone, $method_login, $customer_email, $order_items);

            if (!empty($res_create['response']))
            {
                $response = $res_create['response'];

                if (!empty($response->_id))
                {
                    $created_at = $response->_createdAt->_date . $response->_createdAt->_timezone;

                    // Сохранение данных оплаты в БД
                    $this->Payment_model->setNewOrderPayment($order_id, $response->_id, $response->_status, $total_amount,
                        self::CURRENCY, $created_at, $payment_option, $payment_type, $method_phone, $method_login);

                    // Перенаправление пользователя на страницу оплаты
                    header('Location: ' . $response->_confirmation->confirmation_url);
                }
                else
                {
                    log_message('error', __METHOD__.':'.__LINE__);
                    $this->session->set_tempdata('message', 'Payment status error', 60);
                    header('Location: '.$return_url);
                }
            }
            elseif(!empty($res_create['error']))
            {
                log_message('error', __METHOD__.':'.__LINE__.' '.$res_create['error']);
                $this->session->set_tempdata('message', $res_create['error'], 60);
                header('Location: '.$return_url);
            }
            else
            {
                log_message('error', __METHOD__.':'.__LINE__);
                header('Location: '.$return_url);
            }
        }
        else
        {
            log_message('error', __METHOD__.':'.__LINE__);
            $this->session->set_tempdata('message', 'Order parameters error', 60);
            header('Location: '.$return_url);
        }
    }

    /**
     * Прием уведомлений от Яндекс.Касса
     */
    public function paymentNotifications()
    {
        $response = json_decode(file_get_contents("php://input"));
        //log_message('debug', __METHOD__.':'.__LINE__.' Response input:'. print_r($response, true));

        if ($response->type == 'notification')
        {
            $payment = $response->object;
            // Обновление данных платежа
            self::updatePaymentData($payment);

            // Подтверждение платежа
            if ($payment->status == 'waiting_for_capture')
            {
                if ($payment->paid === true)
                {
                    $this->load->model('Store_model');
                    // Проверка аккаунта пользователя на активацию
                    $check_account = $this->Store_model->checkPaymentAccount($payment->id);
                    if($check_account === true)
                    {
                        // Подтверждение платежа
                        $res_capture = self::capturePayment($payment->id, $payment->amount->value, $payment->amount->currency);
                        if(!empty($res_capture['response']))
                        {
                            $result = $res_capture['response'];

                            // Обновление данных платежа
                            self::updatePaymentData($result);
                        }
                        elseif(!empty($res_capture['error']))
                        {
                            log_message('error', __METHOD__.':'.__LINE__.' '.$payment->id.' '.$res_capture['error']);
                        }
                    }
                    else
                    {
                        log_message('error', __METHOD__.':'.__LINE__.' Check account = false '.$payment->id);
                    }
                }
                else
                {
                    log_message('error', __METHOD__.':'.__LINE__.' Payment paid != true '.$payment->id);
                }
            }
            else
            {
                log_message('error', __METHOD__.':'.__LINE__.' Payment status != waiting_for_capture '.$payment->id.' '.$payment->status);
            }
        }
        else
        {
            log_message('error', __METHOD__.':'.__LINE__.' Response type != notification '. print_r($response));
        }

        header("HTTP/1.0 200 OK");
    }

    /**
     * Обновление данных о платеже в БД
     * @throws Exception
     */
    public function paymentUpdate()
    {
        $payment_id           = strip_tags($this->input->get('pid', true));
        $payment_status       = strip_tags($this->input->get('ps', true));
        $payment_paid         = (strip_tags($this->input->get('pp', true)) == 'true') ? 1 : 0;
        $payment_method_id    = strip_tags($this->input->get('pmid', true));
        $payment_method_saved = (strip_tags($this->input->get('pms', true)) == 'true') ? 1 : 0;

        $pcr = $this->input->get('pcr', true);
        $pc  = $this->input->get('pc', true);
        $pe  = $this->input->get('pe', true);

        $created_at  = '';
        $captured_at = '';
        $expires_at  = '';

        // Дата создания платежа
        if(is_array($pcr) and !empty($pcr['date']))
        {
            $tmp_date = new DateTime($pcr['date']);
            $created_at = ($tmp_date !== false) ? $tmp_date->format('Y-m-d H:i:s') : '';
        }
        // Дата подверждения платежа
        if(is_array($pc) and !empty($pc['date']))
        {
            $tmp_date = new DateTime($pc['date']);
            $captured_at = ($tmp_date !== false) ? $tmp_date->format('Y-m-d H:i:s') : '';
        }
        // Дата окончания активности платежа
        if(is_array($pe) and !empty($pe['date']))
        {
            $tmp_date = new DateTime($pe['date']);
            $expires_at = ($tmp_date !== false) ? $tmp_date->format('Y-m-d H:i:s') : '';
        }

        if(!empty($payment_id))
        {
            // Обновление данных платежа
            $this->Payment_model->updatePaymentStatus('', $payment_id, $payment_status, $payment_paid, $created_at,
                $expires_at, $captured_at, $payment_method_id, $payment_method_saved);

            if ($payment_status == 'succeeded')
            {
                $this->load->model('Store_model');
                $this->load->model('Course_model');

                $payment = $this->Payment_model->getOrderPayment($payment_id);

                // Выборка курса заказа по номеру платежа
                $courses = $this->Store_model->getOrderCourses($payment_id);

                if (!empty($courses['courses']))
                {
                    $user_id = $courses['user_id'];

                    // Сохранение последующих платежей? если выбрана оплата, разделенная на несколько месяцев
                    if (!empty($payment) and $payment['option'] == 'partial_payment' and $payment_method_saved == 'true')
                    {
                        // Выборка рекуррентных данных
                        $recurrent_data = $this->Course_model->getCourseRecurrentData($courses);
                        //log_message('debug', __METHOD__ . __LINE__ . ' Course_model->getCourseRecurrentData: ' . print_r($recurrent_data, true));

                        // Сохранение последующих платежей
                        $this->Payment_model->setSubsequentPayments($payment['order_id'], self::PAYMENT_METHOD, $payment_method_id, $recurrent_data['courses'], $this->date);
                    }

                    // Прикрепление курса(ов) к пользователю
                    foreach($courses['courses'] as $course)
                    {
                        $start_date = '';
                        $end_date = '';
                        $training_days = '';
                        $user_coach = '';
                        $free_weeks = ($course['pc_discount_type'] == 'free_week') ? $course['pc_discount'] : 0;
                        $free_weeks_end_date = '';

                        // Даты начала и окончания курса
                        if($course['category'] == 'nutrition')
                        {
                            // Количество тренировок за курс
                            $count_workouts = $course['count_weeks'] * $course['count_days'];

                            $start_date = $this->date;

                            $tmp_date = new DateTime($start_date);
                            $tmp_date->add(new DateInterval("P" . $count_workouts . "D"));
                            $end_date = ($tmp_date !== false) ? $tmp_date->format('Y-m-d') : '';

                            if($free_weeks > 0)
                            {
                                $free_weeks_days = $free_weeks*7;
                                $tmp_date = new DateTime($start_date);
                                $tmp_date->add(new DateInterval("P" . $free_weeks_days . "D"));
                                $free_weeks_end_date = ($tmp_date !== false) ? $tmp_date->format('Y-m-d') : '';
                            }
                        }

                        $this->Course_model->setNewUserCourse($payment['order_id'], $course['id'], $user_id, $start_date, $end_date, $training_days, $user_coach, $free_weeks, $free_weeks_end_date, $this->date);
                    }

                    // Изменение статуса заказа как "Выполненный"
                    $this->Store_model->updateOrderStatus($payment['order_id'], $payment_id, 1);
                }
            }
        }
    }

    /**
     * Создание платежа
     *
     * @param int $order_id
     * @param float $value
     * @param string $currency
     * @param string $payment_type ('bank_card', 'yandex_money', 'sberbank', 'qiwi', 'webmoney', 'alfabank')
     * @param string $payment_option ('full_payment', 'partial_payment')
     * @param string $payment_method_id
     * @param int|string $method_phone
     * @param string $method_login
     * @param string $customer_email
     * @param array $order_items
     * @return array
     */
    public function createPayment($order_id, $value, $currency, $payment_type = 'bank_card', $payment_option = 'full_payment',
                                  $payment_method_id = '', $method_phone = '', $method_login = '', $customer_email = '', $order_items = array())
    {
        $result         = array('response' => false, 'error' => false);
        $external_types = array('sberbank', 'alfabank');
        $idempotenceKey = uniqid('', true);
        $description    = 'Оплата заказа №' . $order_id;
        $return_url     = 'https://superbody.pro/order/' . $order_id . '?return=true';
        $save           = ($payment_option == 'partial_payment') ? true : false;
        $method_id      = strip_tags($payment_method_id);
        $confirm_type   = (in_array($payment_type, $external_types)) ? 'external' : 'redirect';

        $client = new Client();
        $client->setAuth(self::SHOPID, self::SHOP_SECRET);

        $order_price = ($order_items['price'] > 0) ? $order_items['price'] : $order_items['rec_first_price'];

        try {
            $result['response'] = $client->createPayment(
                array(
                    'amount' => array(
                        'value' => $value,
                        'currency' => $currency,
                    ),
                    'receipt' => array(
                        'customer' => array(
                            'email' => $customer_email,
                        ),
                        'items' => array(
                            array(
                                'description' => $order_items['name'],
                                'quantity' => $order_items['cart_quantity'],
                                'amount' => $order_price,
                                'vat_code' => 1,
                                'payment_subject' => 'service',
                                'payment_mode' => $payment_option,
                            ),
                        ),
                    ),
                    'payment_method_data' => array(
                        'type' => $payment_type,
                        'login' => $method_login,
                        'phone' => $method_phone,
                    ),
                    'description' => $description,
                    'confirmation' => array(
                        'type' => $confirm_type,
                        'return_url' => $return_url,
                    ),
                    'save_payment_method' => $save,
                    'payment_method_id' => $method_id,
                ),
                $idempotenceKey
            );
        } catch (\YandexCheckout\Common\Exceptions\BadApiRequestException $e) {
            log_message('error', __METHOD__ . ' ' . $e->getMessage());
            $result['error'] = $e->getMessage();
        } catch (\YandexCheckout\Common\Exceptions\ForbiddenException $e) {
            log_message('error', __METHOD__ . ' ' . $e->getMessage());
            $result['error'] = $e->getMessage();
        } catch (\YandexCheckout\Common\Exceptions\InternalServerError $e) {
            log_message('error', __METHOD__ . ' ' . $e->getMessage());
            $result['error'] = $e->getMessage();
        } catch (\YandexCheckout\Common\Exceptions\NotFoundException $e) {
            log_message('error', __METHOD__ . ' ' . $e->getMessage());
            $result['error'] = $e->getMessage();
        } catch (\YandexCheckout\Common\Exceptions\ResponseProcessingException $e) {
            log_message('error', __METHOD__ . ' ' . $e->getMessage());
            $result['error'] = $e->getMessage();
        } catch (\YandexCheckout\Common\Exceptions\TooManyRequestsException $e) {
            log_message('error', __METHOD__ . ' ' . $e->getMessage());
            $result['error'] = $e->getMessage();
        } catch (\YandexCheckout\Common\Exceptions\UnauthorizedException $e) {
            log_message('error', __METHOD__ . ' ' . $e->getMessage());
            $result['error'] = $e->getMessage();
        } catch (\YandexCheckout\Common\Exceptions\ApiException $e) {
            log_message('error', __METHOD__ . ' ' . $e->getMessage());
            $result['error'] = $e->getMessage();
        } catch (Exception $e) {
            log_message('error', __METHOD__ . ' ' . $e->getMessage());
            $result['error'] = $e->getMessage();
        }

        return $result;
    }

    /**
     * Создание повторного платежа
     *
     * @param int $order_id
     * @param float $value
     * @param string $currency
     * @param string $payment_option ('full_payment', 'partial_payment')
     * @param string $payment_method_id
     * @param string $customer_email
     * @param array $order_items
     * @return array
     */
    public function createRepeatPayment($order_id, $value, $currency, $payment_option, $payment_method_id, $customer_email = '', $order_items = array())
    {
        $result         = array('response' => false, 'error' => false);
        $idempotenceKey = uniqid('', true);
        $description    = 'Оплата заказа №' . $order_id;
        $method_id      = strip_tags($payment_method_id);

        $client = new Client();
        $client->setAuth(self::SHOPID, self::SHOP_SECRET);

        $order_price = ($order_items['price'] > 0) ? $order_items['price'] : $order_items['rec_first_price'];

        try {
            $result['response'] = $client->createPayment(
                array(
                    'amount' => array(
                        'value' => $value,
                        'currency' => $currency,
                    ),
                    'receipt' => array(
                        'customer' => array(
                            'email' => $customer_email,
                        ),
                        'items' => array(
                            array(
                                'description' => $order_items['name'],
                                'quantity' => $order_items['cart_quantity'],
                                'amount' => $order_price,
                                'vat_code' => 1,
                                'payment_subject' => 'service',
                                'payment_mode' => $payment_option,
                            ),
                        ),
                    ),
                    'description' => $description,
                    'payment_method_id' => $method_id,
                ),
                $idempotenceKey
            );
        } catch (\YandexCheckout\Common\Exceptions\BadApiRequestException $e) {
            log_message('error', __METHOD__ . ' ' . $e->getMessage());
            $result['error'] = $e->getMessage();
        } catch (\YandexCheckout\Common\Exceptions\ForbiddenException $e) {
            log_message('error', __METHOD__ . ' ' . $e->getMessage());
            $result['error'] = $e->getMessage();
        } catch (\YandexCheckout\Common\Exceptions\InternalServerError $e) {
            log_message('error', __METHOD__ . ' ' . $e->getMessage());
            $result['error'] = $e->getMessage();
        } catch (\YandexCheckout\Common\Exceptions\NotFoundException $e) {
            log_message('error', __METHOD__ . ' ' . $e->getMessage());
            $result['error'] = $e->getMessage();
        } catch (\YandexCheckout\Common\Exceptions\ResponseProcessingException $e) {
            log_message('error', __METHOD__ . ' ' . $e->getMessage());
            $result['error'] = $e->getMessage();
        } catch (\YandexCheckout\Common\Exceptions\TooManyRequestsException $e) {
            log_message('error', __METHOD__ . ' ' . $e->getMessage());
            $result['error'] = $e->getMessage();
        } catch (\YandexCheckout\Common\Exceptions\UnauthorizedException $e) {
            log_message('error', __METHOD__ . ' ' . $e->getMessage());
            $result['error'] = $e->getMessage();
        } catch (\YandexCheckout\Common\Exceptions\ApiException $e) {
            log_message('error', __METHOD__ . ' ' . $e->getMessage());
            $result['error'] = $e->getMessage();
        } catch (Exception $e) {
            log_message('error', __METHOD__ . ' ' . $e->getMessage());
            $result['error'] = $e->getMessage();
        }

        return $result;
    }

    /**
     * Подтверждение платежа
     *
     * @param string $payment_id
     * @param $value
     * @param $currency
     * @return array|bool|CreateCaptureResponse
     */
    public function capturePayment($payment_id, $value, $currency)
    {
        $result         = array('response' => false, 'error' => false);
        $idempotenceKey = uniqid('', true);
        $client = new Client();
        $client->setAuth(self::SHOPID, self::SHOP_SECRET);

        // Подтверждение платежа
        try {
            $result['response'] = $client->capturePayment(
                array(
                    'amount' => array(
                        'value' => $value,
                        'currency' => $currency,
                    )
                    /*,
                    'receipt' => array(
                        'customer' => array(
                            'email' => $customer_email
                        ),
                        'items' => array(
                            'description' => $order_items['name'],
                            'quantity' => $order_items['cart_quantity'],
                            'amount' => $order_items['price'],
                            'vat_code' => 1,
                            'payment_subject' => 'service',
                            'payment_mode' => $payment_option
                        )
                    ),*/
                ),
                $payment_id,
                $idempotenceKey
            );
        }
        catch (\YandexCheckout\Common\Exceptions\BadApiRequestException $e) {
            log_message('error', __METHOD__ . ' ' . $e->getMessage());
            $result['error'] = $e->getMessage();
        }
        catch (\YandexCheckout\Common\Exceptions\ForbiddenException $e) {
            log_message('error', __METHOD__ . ' ' . $e->getMessage());
            $result['error'] = $e->getMessage();
        }
        catch (\YandexCheckout\Common\Exceptions\InternalServerError $e) {
            log_message('error', __METHOD__ . ' ' . $e->getMessage());
            $result['error'] = $e->getMessage();
        }
        catch (\YandexCheckout\Common\Exceptions\NotFoundException $e) {
            log_message('error', __METHOD__ . ' ' . $e->getMessage());
            $result['error'] = $e->getMessage();
        }
        catch (\YandexCheckout\Common\Exceptions\ResponseProcessingException $e) {
            log_message('error', __METHOD__ . ' ' . $e->getMessage());
            $result['error'] = $e->getMessage();
        }
        catch (\YandexCheckout\Common\Exceptions\TooManyRequestsException $e) {
            log_message('error', __METHOD__ . ' ' . $e->getMessage());
            $result['error'] = $e->getMessage();
        }
        catch (\YandexCheckout\Common\Exceptions\UnauthorizedException $e) {
            log_message('error', __METHOD__ . ' ' . $e->getMessage());
            $result['error'] = $e->getMessage();
        }
        catch (\YandexCheckout\Common\Exceptions\ApiException $e) {
            log_message('error', __METHOD__ . ' ' . $e->getMessage());
            $result['error'] = $e->getMessage();
        } catch (Exception $e) {
            log_message('error', __METHOD__ . ' ' . $e->getMessage());
            $result['error'] = $e->getMessage();
        }

        return $result;
    }

    /**
     * Отмена платежа
     *
     * @param string $payment_id
     * @return array
     */
    public function cancelPayment($payment_id)
    {
        $result = array('response' => false, 'error' => false);
        $client = new Client();
        $client->setAuth(self::SHOPID, self::SHOP_SECRET);

        try {
            $result['response'] = $client->cancelPayment(
                $payment_id,
                uniqid('', true)
            );
        } catch (\YandexCheckout\Common\Exceptions\BadApiRequestException $e) {
            log_message('error', __METHOD__ . ' ' . $e->getMessage());
            $result['error'] = $e->getMessage();
        } catch (\YandexCheckout\Common\Exceptions\ForbiddenException $e) {
            log_message('error', __METHOD__ . ' ' . $e->getMessage());
            $result['error'] = $e->getMessage();
        } catch (\YandexCheckout\Common\Exceptions\InternalServerError $e) {
            log_message('error', __METHOD__ . ' ' . $e->getMessage());
            $result['error'] = $e->getMessage();
        } catch (\YandexCheckout\Common\Exceptions\NotFoundException $e) {
            log_message('error', __METHOD__ . ' ' . $e->getMessage());
            $result['error'] = $e->getMessage();
        } catch (\YandexCheckout\Common\Exceptions\ResponseProcessingException $e) {
            log_message('error', __METHOD__ . ' ' . $e->getMessage());
            $result['error'] = $e->getMessage();
        } catch (\YandexCheckout\Common\Exceptions\TooManyRequestsException $e) {
            log_message('error', __METHOD__ . ' ' . $e->getMessage());
            $result['error'] = $e->getMessage();
        } catch (\YandexCheckout\Common\Exceptions\UnauthorizedException $e) {
            log_message('error', __METHOD__ . ' ' . $e->getMessage());
            $result['error'] = $e->getMessage();
        } catch (\YandexCheckout\Common\Exceptions\ApiException $e) {
            log_message('error', __METHOD__ . ' ' . $e->getMessage());
            $result['error'] = $e->getMessage();
        } catch (Exception $e) {
            log_message('error', __METHOD__ . ' ' . $e->getMessage());
            $result['error'] = $e->getMessage();
        }

        return $result;
    }

    /**
     * Проверка наличия платежей на выполнение
     * @throws Exception
     */
    public function verificationSubsequentPayments()
    {
        log_message('debug', __METHOD__.':'.__LINE__.' Script execution!');
        $tmp_date = new DateTime($this->date);
        // Текущая дата
        $today = $tmp_date->format('Y-m-d');
        // Дата неделю назад
        $tmp_date->sub(new DateInterval('P8D'));
        $week_ago = $tmp_date->format('Y-m-d');

        // Список платежей на выполнение
        $subsequent = $this->Payment_model->getSubsequentPayments($today, $week_ago);

        // Выполнение платежей
        if (!empty($subsequent['payments']))
        {
            foreach($subsequent['payments'] as $payment)
            {
                $this->load->model('Store_model');
                $order = $this->Store_model->getOrder($payment['order_id']);

                if(!empty($order))
                {
                    $order = $order['order'];
                    $products = array();
                    if(!empty($order['products']))
                    {
                        $i = 0;
                        foreach ($order['products'] as $product)
                        {
                            $products['products'][$i]['id'] = $product['course_id'];
                            $products['products'][$i]['name'] = $product['name'];
                            $products['products'][$i]['cart_quantity'] = $product['cart_quantity'];
                            $products['products'][$i]['price'] = $product['price'];
                            $products['products'][$i]['rec_first_price'] = $product['rec_first'];
                            $products['products'][$i]['rec_months'] = $product['rec_months'];
                            $products['products'][$i]['rec_subsequent'] = $product['rec_subseq'];
                            $products['products'][$i]['fc_price'] = $product['fc_price'];
                            $products['products'][$i]['discount_price'] = $product['discount_price'];
                            $products['products'][$i]['discount_fc_price'] = $product['discount_fc_price'];
                            $products['products'][$i]['promo_id'] = '';
                            $products['products'][$i]['promo_code'] = '';
                            $products['products'][$i]['promo_discount'] = '';
                            $products[$i]['promo_discount_type'] = '';

                            $i++;
                        }
                        unset($product);

                        // Создание запроса платежа и его выпонение
                        $res_create = self::createRepeatPayment($payment['order_id'], $payment['amount'], $payment['currency'], $payment['options'],
                            $payment['method_id'], $payment['user_email'], $products['products'][0]);

                        if(!empty($res_create['response']))
                        {
                            $response = $res_create['response'];
                            if(!empty($response->_id))
                            {
                                $created_at     = $response->_createdAt->_date . $response->_createdAt->_timezone;
                                $payment_method = $response->_payment_method;
                                $paid = ($response->_paid === true) ? 1 : 0;

                                // Сохранение данных оплаты в БД
                                $this->Payment_model->updateSubsequentPayment($payment['id'], $payment['order_id'], $response->_id,
                                    $response->_status, $payment_method->_type, $paid, $created_at);

                                // Заморозить курс
                                if($response->_status === 'canceled')
                                {
                                    $this->load->model('Course_model');
                                    $this->load->model('Store_model');

                                    $reason = 'payment_canceled';

                                    // Курсы заказа
                                    $order_courses = $this->Store_model->getOrderCourses('', $payment['op_id']);
                                    // Блокировка курсов
                                    $this->Course_model->blockUserOrderCourses($payment['op_id'], $order_courses['user_id'], $order_courses['courses'], $reason, $this->date);
                                }
                                // Разморозить курс
                                elseif($payment['status'] === 'canceled' and $response->_status === 'succeeded')
                                {
                                    $this->load->model('Course_model');
                                    $this->load->model('Store_model');

                                    $reason = 'payment_succeeded';

                                    // Курсы заказа
                                    $order_courses = $this->Store_model->getOrderCourses('', $payment['op_id']);
                                    // Блокировка курсов
                                    $this->Course_model->unblockUserOrderCourses($payment['op_id'], $order_courses['user_id'], $order_courses['courses'], $reason, $this->date);
                                }
                            }
                            else
                            {
                                log_message('debug', __METHOD__ . __LINE__ . ' empty $response->_id: ' . $payment['method_id'] . ' ' .print_r($res_create, true));
                            }
                        }
                        else
                        {
                            log_message('debug', __METHOD__ .':'. __LINE__ . ' Payment create error: ' . $payment['method_id'] . ' ' .print_r($payment, true) . ' ' .print_r($res_create, true));
                        }
                    }
                }
                else
                {
                    log_message('debug', __METHOD__.':'.__LINE__.' Order error: '. $payment['method_id'] . ' ' .print_r($order, true));
                }
            }
            unset($payment);
        }

        // Выборка и удаление платежей, не прошедшие успешную оплату в течении последней недели
        $this->Payment_model->deleteCanceledPayments($week_ago);
    }

    /**
     * Подтверждение платежей пользователя
     *
     * @param $payments
     */
    public function capturePayments($payments)
    {
        if(!empty($payments))
        {
            foreach ($payments as $payment)
            {
                // Подтверждение платежа
                $res_capture = self::capturePayment($payment['id'], $payment['amount'], $payment['currency']);
                // Обновление данных платежа
                self::updatePaymentData($res_capture);
            }
            unset($payment);
        }
        else
        {
            log_message('error', __METHOD__.':'.__LINE__. ' Empty array $payments');
        }
    }

    /**
     * Обновление данных платежа
     *
     * @param $payment
     */
    public function updatePaymentData($payment)
    {
        $payment_saved = ($payment->payment_method->saved === true) ? 'true' : 'false';
        $payment_paid  = ($payment->paid === true) ? 'true' : 'false';

        $payment_data = array(
            'pid' => $payment->id,
            'ps' => $payment->status,
            'pp' => $payment_paid,
            'pcr' => $payment->created_at,
            'pe' => $payment->expires_at,
            'pc' => $payment->captured_at,
            'pmid' => $payment->payment_method->id,
            'pms' => $payment_saved
        );

        $url = 'https://superbody.pro/payment/update?' . http_build_query($payment_data);

        $handle = fopen($url, "r");
        fclose($handle);
    }

    /**
     * Проверка наличия непотвержденных платежей пользователя
     */
    public function checkUserWaitingPayments()
    {
        $user_id    = (is_numeric($this->input->post('uid', true))) ? $this->input->post('uid', true) : null;
        $user_email = (filter_var($this->input->post('ue', true), FILTER_VALIDATE_EMAIL)) ? $this->input->post('ue', true) : null;

        if(!empty($user_id) and !empty($user_email))
        {
            $payments = $this->Payment_model->getUserWaitingPayments($user_id, $user_email);
            if(!empty($payments['waiting_payments']))
            {
                self::capturePayments($payments['waiting_payments']);
            }
            else
            {
                log_message('error', __METHOD__.':'.__LINE__. ' Empty payments: ' . print_r($payments, true));
            }
        }
        else
        {
            log_message('error', __METHOD__.':'.__LINE__. ' User data error: ' . $this->input->post('uid', true). ' ' .$this->input->post('ue', true));
        }
    }

    /* КОНЕЦ БЛОКА ФУНКЦИЙ ОПЛАТЫ */
}