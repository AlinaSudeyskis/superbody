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
        $order_id     = is_integer($this->input->get('oid', true)) ? $this->input->get('oid', true) : null;
        $total_amount = is_numeric($this->input->get('amount', true)) ? $this->input->get('amount', true) : null;
        $payment_type = is_numeric($this->input->get('type', true)) ? $this->input->get('type', true) : null;

        if (!empty($order_id) and !empty($total_amount))
        {
            // Создание платежа
            $response = $this->createPayment($order_id, $total_amount, self::CURRENCY, self::PAYMENT_METHOD);

            log_message('debug', __METHOD__ . '. Response Payment data: '. print_r($response, true));

            if (!empty($response->_id)) {
                if ($response->_status == 'pending')
                {
                    $created_at = $response->_createdAt->_date . $response->_createdAt->_timezone;

                    // Сохранение данных оплаты в БД
                    $this->Payment_model->setNewOrderPayment($order_id, $response->_id, $response->_status, $total_amount, self::CURRENCY, $created_at);

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

        log_message('debug', __METHOD__ . ' ' . print_r($response, true));

        if ($response->type == 'notification')
        {
            $payment = $response->object;

            // Подтверждение платежа или отмена
            if ($payment->status == 'waiting_for_capture')
            {
                if ($payment->paid === true)
                {
                    // Подтверждение платежа
                    $this->capturePayment($payment->id, $payment->amount->value, $payment->amount->currency);
                }
            }

            $url = 'https://superbody.pro/payment/update?pid=' . $payment->id . '&ps=' . $payment->status . '&pp=' .
                $payment->paid . '&pcr=' . $payment->created_at . '&pe=' . $payment->expires_at . '&pc=' . $payment->captured_at .
                '&pmid=' . $payment->payment_method->id . '&pms=' . $payment->payment_method->saved;

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
        $payment_paid         = strip_tags($this->input->get('pp', true));
        $created_at           = strip_tags($this->input->get('pcr', true));
        $expires_at           = strip_tags($this->input->get('pe', true));
        $captured_at          = strip_tags($this->input->get('pc', true));
        $payment_method_id    = strip_tags($this->input->get('pmid', true));
        $payment_method_saved = strip_tags($this->input->get('pms', true));

        // Обновление данных платежа
        $this->Payment_model->updatePaymentStatus('', $payment_id, $payment_status, $payment_paid, $created_at,
            $expires_at, $captured_at, $payment_method_id, $payment_method_saved);

        if ($payment_status == 'succeeded')
        {
            $this->load->model('Store_model');

            // Выборка курсов из заказа по номеру платежа
            $res_cour = $this->Store_model->getOrderCourses($payment_id);
            log_message('debug', __METHOD__ . ' Курсы заказа: ' . print_r($res_cour, true));

            // Прикрепление курса(ов) к пользователю
            if (!empty($res_cour['courses']))
            {
                $this->load->model('Course_model');

                $start_date = '';
                $end_date = '';
                $training_days = '';
                $user_couch = '';

                foreach($res_cour['courses'] as $course)
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
     * @return \YandexCheckout\Request\Payments\CreatePaymentResponse
     */
    public function createPayment($order_id, $value, $currency, $payment_type)
    {
        $idempotenceKey = uniqid('', true);
        $description    = 'Оплата заказа №' . $order_id;
        $return_url     = 'https://superbody.pro/ordering/' . $order_id;

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

    /* КОНЕЦ БЛОКА ФУНКЦИЙ ОПЛАТЫ */
}