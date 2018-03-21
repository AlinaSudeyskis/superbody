<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use YandexCheckout\Client;

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
    const SHOPID = 188363;
    const SHOP_SECRET = 'live_yB_n1qwrD5q3SPgdu3EtwzINTrpL8Tmn7bFCYG-eBd4';
    const SCID = 715012;
    const TEST_SCID = 561490;

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
        $order_id       = is_numeric($this->input->get('oid', true)) ? $this->input->get('oid', true) : null;
        $total_amount   = is_numeric($this->input->get('amount', true)) ? $this->input->get('amount', true) : null;
        $payment_type   = strip_tags($this->input->get('type', true));
        $payment_option = strip_tags($this->input->get('option', true));

        log_message('debug', __METHOD__ . '. Response Payment data: '. $order_id . ' ' . $total_amount . ' '
            . $payment_type . ' ' . $payment_option);

        if (!empty($order_id) and !empty($total_amount) and !empty($payment_option))
        {
            // Создание платежа
            $response = self::createPayment($order_id, $total_amount, self::CURRENCY, self::PAYMENT_METHOD, $payment_option);

            if (!empty($response->_id)) {
                if ($response->_status == 'pending')
                {
                    $created_at = $response->_createdAt->_date . $response->_createdAt->_timezone;

                    // Сохранение данных оплаты в БД
                    $this->Payment_model->setNewOrderPayment($order_id, $response->_id, $response->_status, $total_amount,
                        self::CURRENCY, $created_at, $payment_option);

                    // Перенаправление пользователя на страницу оплаты
                    header('Location: ' . $response->_confirmation->confirmation_url);
                }
            }
        }
    }

    /**
     * Прием уведомлений от Яндекс.Касса
     */
    public function paymentNotifications()
    {
        $response = json_decode(file_get_contents("php://input"));

        if ($response->type == 'notification')
        {
            $payment = $response->object;

            // Подтверждение платежа или отмена
            if ($payment->status == 'waiting_for_capture')
            {
                if ($payment->paid === true)
                {
                    // Подтверждение платежа
                    self::capturePayment($payment->id, $payment->amount->value, $payment->amount->currency);
                }
            }

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

        header("HTTP/1.0 200 OK");
    }

    /**
     * Обновление данных о платеже в БД
     */
    public function paymentUpdate()
    {
        $payment_id           = strip_tags($this->input->get('pid', true));
        $payment_status       = strip_tags($this->input->get('ps', true));
        $payment_paid         = (strip_tags($this->input->get('pp', true)) == 'true') ? 1 : 0;
        $created_at           = strip_tags($this->input->get('pcr', true));
        $expires_at           = strip_tags($this->input->get('pe', true));
        $captured_at          = strip_tags($this->input->get('pc', true));
        $payment_method_id    = strip_tags($this->input->get('pmid', true));
        $payment_method_saved = (strip_tags($this->input->get('pms', true)) == 'true') ? 1 : 0;


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
                // Сохранение последующих платежей? если выбрана оплата, разделенная на несколько месяцев
                if (!empty($payment) and $payment['option'] == 'installments')
                {
                    // Выборка рекуррентных данных
                    $recurrent_data = $this->Course_model->getCourseRecurrentData($courses);
                    log_message('debug', __METHOD__ . __LINE__ . ' Course_model->getCourseRecurrentData: ' . print_r($recurrent_data, true));

                    // Сохранение последующих платежей
                    $this->Payment_model->setSubsequentPayments($payment['order_id'], self::PAYMENT_METHOD, $payment_method_id, $recurrent_data['courses'], $this->date);
                }

                // Прикрепление курса(ов) к пользователю
                $start_date = '';
                $end_date = '';
                $training_days = '';
                $user_couch = '';

                foreach($courses['courses'] as $course)
                {
                    $this->Course_model->setNewUserCourse($course['id'], $this->user_id, $start_date, $end_date, $training_days, $user_couch, $this->date);
                }

                // Изменение статуса заказа как "Выполненный"
                $this->Store_model->updateOrderStatus('', $payment_id, 1);
            }
        }
    }

    /**
     * Создание платежа
     *
     * @param int $order_id
     * @param float $value
     * @param string $currency
     * @param string $payment_type ('bank_card')
     * @param string $payment_option ('full_payment', 'installments')
     * @param string $payment_method_id
     * @return \YandexCheckout\Request\Payments\CreatePaymentResponse
     */
    public function createPayment($order_id, $value, $currency, $payment_type, $payment_option = '', $payment_method_id = '')
    {
        $idempotenceKey = uniqid('', true);
        $description    = 'Оплата заказа №' . $order_id;
        $return_url     = 'https://superbody.pro/ordering/' . $order_id;
        $save           = ($payment_option == 'installments') ? true : false;
        $method_id     = strip_tags($payment_method_id);

        $client = new Client();
        $client->setAuth(self::SHOPID, self::SHOP_SECRET);

        $response = $client->createPayment(
            array(
                'amount' => array(
                    'value' => $value,
                    'currency' => $currency
                ),
                'payment_method_data' => array(
                    'type' => $payment_type,
                ),
                'description' => $description,
                'confirmation' => array(
                    'type' => 'redirect',
                    'return_url' => $return_url,
                ),
                'save_payment_method' => $save,
                'payment_method_id' => $method_id,
            ),
            $idempotenceKey
        );

        return $response;
    }

    /**
     * Подтверждение платежа
     *
     * @param string $payment_id
     * @param float $value
     * @param string $currency
     */
    public function capturePayment($payment_id, $value, $currency)
    {
        $idempotenceKey = uniqid('', true);
        $client = new Client();
        $client->setAuth(self::SHOPID, self::SHOP_SECRET);

        // Подтверждение платежа
        $client->capturePayment(
            array(
                'amount' => array(
                    'value' => $value,
                    'currency' => $currency,
                ),
            ),
            $payment_id,
            $idempotenceKey
        );
    }

    /**
     * Отмена платежа
     *
     * @param string $payment_id
     */
    public function cancelPayment($payment_id)
    {
        $client = new Client();
        $client->setAuth(self::SHOPID, self::SHOP_SECRET);

        $client->cancelPayment(
            $payment_id,
            uniqid('', true)
        );
    }

    /**
     * Проверка наличия платежей на выполнение
     */
    public function verificationSubsequentPayments()
    {
        $subsequent = $this->Payment_model->getSubsequentPayments($this->date);

        if (!empty($subsequent['payments']))
        {
            foreach($subsequent['payments'] as $payment)
            {
                $response = self::createPayment($payment['order_id'], $payment['amount'], $payment['currency'], $payment['type'],
                    '', $payment['method_id']);

                if (!empty($response->_id))
                {
                    $created_at     = $response->_createdAt->_date . $response->_createdAt->_timezone;
                    $payment_method = $response->_payment_method;
                    $paid = ($response->_paid === true) ? 1 : 0;

                    // Сохранение данных оплаты в БД
                    $this->Payment_model->updateSubsequentPayment($payment['id'], $payment['order_id'], $response->_id,
                        $response->_status, $payment_method->_type, $paid, $created_at);
                }
                else{
                    log_message('debug', __METHOD__ . __LINE__ . ' empty $response->_id: ' . print_r($response, true));
                }
            }
            unset($payment);
        }
    }

    /* КОНЕЦ БЛОКА ФУНКЦИЙ ОПЛАТЫ */
}