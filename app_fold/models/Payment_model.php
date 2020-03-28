<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Класс Payment_model
 *
 * Класс выбора, сохранения и изменения данных о платежах
 *
 * @author Alina Sudeyskis <alina.sudeyskis@gmail.com>
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Payment_model extends CI_Model
{
    /**
     * Добавление данных оплаты заказака
     *
     * @param int $order_id
     * @param string $payment_id
     * @param string $payment_status (pending, waiting_for_capture, succeeded, canceled)
     * @param float $total_amount
     * @param string $currency
     * @param string $created_at
     * @param string $payment_option (full_payment, partial_payment)
     * @param $payment_type
     * @param $customer_email
     * @param $customer_name
     * @param string $method_phone
     * @param string $method_login
     * @param $date
     * @return bool
     */
    public function setNewOrderPayment($order_id, $payment_id, $payment_status, $total_amount, $currency, $created_at,
                                       $payment_option, $payment_type, $customer_email, $customer_name, $method_phone = '',
                                       $method_login = '', $date = '')
    {
        $result = false;

        $ins_data = $this->db->query('
            INSERT INTO `orders_payment` (`op_o_id`, `op_customer_email`, `op_customer_name`, `op_payment_type`, `op_pt_phone`, `op_pt_login`, 
                                          `op_payment_id`, `op_status`, `op_amount`, `op_currency`, `op_payment_options`, `op_created_at`, `op_date_add`) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)',
                array($order_id, $customer_email, $customer_name, $payment_type, $method_phone, $method_login, $payment_id,
                    $payment_status, $total_amount, $currency, $payment_option, $created_at, $date));
        if ($ins_data !== false and 1 == $this->db->affected_rows())
        {
            $result = true;
        }
        elseif ($ins_data === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Изменение данных оплаты заказа
     *
     * @param int $order_id
     * @param string $payment_id
     * @param string $payment_status (pending, waiting_for_capture, succeeded, canceled)
     * @param bool $payment_paid
     * @param string $payment_created_at
     * @param string $payment_expires_at
     * @param string $payment_captured_at
     * @param string $payment_method_id
     * @param bool $payment_method_saved
     * @return bool
     */
    public function updatePaymentStatus($order_id, $payment_id, $payment_status, $payment_paid, $payment_created_at,
                                        $payment_expires_at, $payment_captured_at, $payment_method_id, $payment_method_saved)
    {
        $result = false;

        $sel_payment = $this->db->query('
            SELECT `op_status`, `op_paid`, `op_created_at`, `op_captured_at`, `op_expires_at`, `op_payment_method_id`,
                `op_payment_method_saved`
            FROM `orders_payment`
            WHERE `op_payment_id`=? LIMIT 1', $payment_id);

        if($sel_payment !== false and 1 == $sel_payment->num_rows())
        {
            $row = $sel_payment->row();

            $created_at  = (!empty($payment_created_at) and $payment_created_at != $row->op_created_at)
                ? $payment_created_at : $row->op_created_at;
            $expires_at  = (!empty($payment_expires_at) and $payment_expires_at != $row->op_expires_at)
                ? $payment_expires_at : $row->op_expires_at;
            $captured_at = (!empty($payment_captured_at) and $payment_captured_at != $row->op_captured_at)
                ? $payment_captured_at : $row->op_captured_at;

            $up_data = $this->db->query('
                UPDATE `orders_payment` 
                SET `op_status`=?, `op_paid`=?, `op_created_at`=?, `op_captured_at`=?, `op_expires_at`=?, `op_payment_method_id`=?, 
                  `op_payment_method_saved`=?
                WHERE `op_payment_id`=? LIMIT 1',
                array($payment_status, $payment_paid, $created_at, $captured_at, $expires_at, $payment_method_id,
                    $payment_method_saved, $payment_id));

            if ($up_data !== false and 1 == $this->db->affected_rows())
            {
                $result = true;
            }
            elseif ($up_data === false)
            {
                parent::logDbMessages(__METHOD__.':'.__LINE__);
            }
        }
        elseif($sel_payment === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Обновление статуса возврата платежа
     *
     * @param $payment_id
     * @param $refund_payment_id
     * @param $payment_status
     * @param $created_at
     * @return bool
     */
    public function updateRefundStatus($payment_id, $refund_payment_id, $payment_status, $created_at)
    {
        $result = false;

        $sel_payment = $this->db->query('
            SELECT `opr_payment_id`, `opr_refund_id`, `opr_refund_amount`, `opr_refund_status`, `opr_refund_description`, `opr_refund_created_at` 
            FROM `orders_payment_refund` 
            WHERE `opr_refund_id`=? and `opr_payment_id`=? LIMIT 1', array($payment_id, $refund_payment_id));

        if($sel_payment !== false and 1 == $sel_payment->num_rows())
        {
            $up_data = $this->db->query('UPDATE `orders_payment_refund` SET `opr_refund_status`=? WHERE `opr_refund_id`=? and `opr_payment_id`=? LIMIT 1',
                array($payment_status, $payment_id, $refund_payment_id));

            if ($up_data !== false and 1 == $this->db->affected_rows())
            {
                $result = true;
            }
            elseif ($up_data === false)
            {
                parent::logDbMessages(__METHOD__.':'.__LINE__);
            }
        }
        elseif($sel_payment === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Выборка данных платежа
     *
     * @param $payment_id
     * @return array
     */
    public function getOrderPayment($payment_id)
    {
        $result = array();

        $sel_data = $this->db->query('SELECT `op_o_id`, `op_customer_email`, `op_customer_name`, `op_payment_type`, `op_pt_login`, `op_pt_phone`, `op_payment_options` 
            FROM `orders_payment` WHERE `op_payment_id`=? LIMIT 1', $payment_id);
        if($sel_data !== false and 1 == $sel_data->num_rows())
        {
            $row = $sel_data->row();

            $result['order_id']       = $row->op_o_id;
            $result['customer_email'] = $row->op_customer_email;
            $result['customer_name']  = $row->op_customer_name;
            $result['option']         = $row->op_payment_options;
            $result['type']           = $row->op_payment_type;
            $result['login']          = $row->op_pt_login;
            $result['phone']          = $row->op_pt_phone;
        }
        elseif($sel_data === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Сохранение последующих платежей заказа
     *
     * @param $order_id
     * @param $customer_email
     * @param $customer_name
     * @param $payment_method
     * @param $login
     * @param $phone
     * @param $payment_method_id
     * @param $recurrent_data
     * @param $date
     * @throws Exception
     */
    public function setSubsequentPayments($order_id, $customer_email, $customer_name, $payment_method, $login, $phone, $payment_method_id, $recurrent_data, $date)
    {
        if (!empty($recurrent_data))
        {
            foreach ($recurrent_data as $course)
            {
                if ($course['recurrent'] === true)
                {
                    $months = $course['rec_months'] - 1;
                    $following_date = $date;

                    // Цикл добавления будущих платежей
                    if($months >= 1)
                    {
                        for($i = 1; $i <= $months; $i++)
                        {
                            $tmp_date = new DateTime($following_date);
                            $tmp_date->add(new DateInterval('P1M'));
                            $following_date = $tmp_date->format('Y-m-d');

                            $sel_data = $this->db->query('SELECT `op_o_id` FROM `orders_payment` 
                                WHERE `op_o_id`=? and `op_number`=? and `op_customer_email`=? and `op_customer_name`=? and
                                      `op_payment_type`=? and `op_pt_login`=? and `op_pt_phone`=? and `op_status`=? and 
                                      `op_amount`=? and `op_currency`=? and `op_payment_method_id`=? and `op_following_date`=? 
                                LIMIT 1',
                                    array($order_id, $i, $customer_email, $customer_name, $payment_method, $login,
                                        $phone, '', $course['rec_subsequent'], 'RUB', $payment_method_id, $following_date));
                            if($sel_data !== false and 0 == $sel_data->num_rows())
                            {
                                $ins_data = $this->db->query('
                                    INSERT INTO `orders_payment` (`op_o_id`, `op_number`, `op_customer_email`, `op_customer_name`, 
                                                                  `op_payment_type`, `op_pt_login`, `op_pt_phone`, `op_status`, `op_amount`, `op_currency`, 
                                                                  `op_payment_method_id`, `op_following_date`, `op_date_add`)
                                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)',
                                        array($order_id, $i, $customer_email, $customer_name, $payment_method, $login, $phone, '',
                                            $course['rec_subsequent'], 'RUB', $payment_method_id, $following_date, $date));
                                if($ins_data === false)
                                {
                                    parent::logDbMessages(__METHOD__.':'.__LINE__);
                                }
                            }
                            else
                            {
                                log_message('debug', __METHOD__.':'.__LINE__.' Subsequent payment already existed. Order_id: ' . $order_id . ' #' . $i . ' Payment_method_id: ' . $payment_method_id);
                            }
                        }
                    }
                    else
                    {
                        log_message('debug', __METHOD__.':'.__LINE__.' Not enough amount of the recurrent months: ' . $course['rec_months']);
                    }
                }
                else
                {
                    log_message('debug', __METHOD__.':'.__LINE__.' Impossibility of the recurrent payment: ' . $course['recurrent']);
                }
            }
        }
        else
        {
            log_message('debug', __METHOD__.':'.__LINE__.' : Empty recurrent data');
        }
    }

    /**
     * Выборка платежей, которые нужно провести.
     * Выборка платежей на текующаю дату и выборка отмененных платежей предыдущей недели.
     *
     * @param string $today Текущая дата
     * @param string $week_ago Дата неделю назад
     * @return array
     */
    public function getSubsequentPayments($today, $week_ago)
    {
        $result = array('payments' => array(), 'rejected_payments' => array());
        $i = 0;

        // Выборка текущих платежей для оплаты
        // Выборка не выполненных платежей
        $sel_data = $this->db->query('
            SELECT `op_id`, `op_o_id`, `op_customer_email`, `op_customer_name`, `op_payment_type`, `op_amount`, `op_currency`, 
                   `op_payment_method_id`, `op_payment_options`, `op_status`, `o_user_email`, `o_u_id`, `user_id`, `user_blocked`, `user_deleted` 
            FROM `orders_payment`
            LEFT JOIN `orders` ON `o_id`=`op_o_id`
            LEFT JOIN `users` ON `user_id`=`o_u_id`
            WHERE `op_payment_method_id`<>"" and `op_following_date`<>"0000-00-00" and `op_number`>0 and 
                  (`op_following_date`=? or (`op_following_date`<? and `op_following_date`>? and `op_status`="canceled"))',
                array($today, $today, $week_ago));
        if($sel_data !== false and 0 < $sel_data->num_rows())
        {
            foreach($sel_data->result() as $row)
            {
                if(is_numeric($row->user_id) and $row->user_blocked == 0 and $row->user_deleted == 0)
                {
                    $sel_first = $this->db->query('
                        SELECT `op_revoke_permission`, `op_status` 
                        FROM `orders_payment`
                        WHERE `op_payment_id`=? LIMIT 1', $row->op_payment_method_id);
                    if($sel_first !== false and 1 == $sel_first->num_rows())
                    {
                        $f_row = $sel_first->row();

                        if($f_row->op_revoke_permission == 0 and $f_row->op_status == 'succeeded')
                        {
                            $result['payments'][$i]['id']             = $row->op_id;
                            $result['payments'][$i]['order_id']       = $row->op_o_id;
                            $result['payments'][$i]['customer_email'] = $row->op_customer_email;
                            $result['payments'][$i]['customer_name']  = $row->op_customer_name;
                            $result['payments'][$i]['type']           = $row->op_payment_type;
                            $result['payments'][$i]['amount']         = $row->op_amount;
                            $result['payments'][$i]['currency']       = $row->op_currency;
                            $result['payments'][$i]['method_id']      = $row->op_payment_method_id;
                            $result['payments'][$i]['options']        = $row->op_payment_options;
                            $result['payments'][$i]['status']         = $row->op_status;
                            $result['payments'][$i]['user_email']     = $row->o_user_email;

                            $i++;
                        }
                    }
                    elseif ($sel_first === false)
                    {
                        parent::logDbMessages(__METHOD__.':'.__LINE__);
                    }
                }
            }
            unset($row);
        }
        elseif ($sel_data === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Обновление данных о платеже (автоматическое проведение, без участия пользователя)
     *
     * @param $subsequent_id
     * @param $order_id
     * @param $payment_id
     * @param $payment_status
     * @param $payment_method
     * @param $paid
     * @param $created_at
     * @return bool
     */
    public function updateSubsequentPayment($subsequent_id, $order_id, $payment_id, $payment_status, $payment_method, $paid, $created_at)
    {
        $result = false;

        if (is_numeric($subsequent_id))
        {
            $up_data = $this->db->query('
                UPDATE `orders_payment` 
                SET `op_payment_type`=?, `op_payment_id`=?, `op_status`=?, `op_paid`=?, `op_created_at`=?
                WHERE `op_id`=? and `op_o_id`=? LIMIT 1',
                    array($payment_method, $payment_id, $payment_status, $paid, $created_at, $subsequent_id, $order_id));

            if($up_data !== false and 1 == $this->db->affected_rows())
            {
                $result = true;
            }
            elseif($up_data === false)
            {
                parent::logDbMessages(__METHOD__.':'.__LINE__);
            }
        }

        return $result;
    }

    /**
     * Удаление последующих платежей, если последний платеж не прошел более недели назад
     *
     * @param $week_ago
     * @return bool
     */
    public function deleteCanceledPayments($week_ago)
    {
        $result = true;

        // Выборка платежей, не прошедших оплату неделю назад и более
        $sel_data = $this->db->query('
            SELECT `op_id`, `op_o_id`, `op_payment_type`, `op_amount`, `op_currency`, `op_payment_method_id`, `op_status` 
            FROM `orders_payment`
            WHERE `op_following_date`<? and `op_payment_method_id`<>"" and `op_status`="canceled"', $week_ago);

        if($sel_data !== false and 0 < $sel_data->num_rows())
        {
            $rows = $sel_data->result();
            $sel_data->free_result();

            // Удаление платежей
            foreach($rows as $row)
            {
                $order_id = $row->op_o_id;

                $del_data = $this->db->query('
                    DELETE FROM `orders_payment`
                    WHERE `op_o_id`=? and (`op_status`="canceled" or `op_status`="") and `op_payment_method_id`<>"" and `op_following_date`>=?',
                        array($order_id, $week_ago));

                if($del_data === false)
                {
                    parent::logDbMessages(__METHOD__.':'.__LINE__);
                    $result = false;
                }
            }
            unset($row);
        }
        elseif ($sel_data === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Выборка суммы оплаченных платежей
     *
     * @param $order_id
     * @param $course_id
     * @param $user_id
     * @param $bought_price
     * @param $date
     * @return float
     */
    public function getCourseResidualValue($order_id, $course_id, $user_id, $bought_price, $date)
    {
        $result = 0;

        if(is_numeric($order_id) and is_numeric($course_id) and is_numeric($user_id))
        {
            $paid_value = 0;

            $sel_payments = $this->db->query('
                SELECT `op_id`, `op_o_id`, `op_number`, `op_payment_type`, `op_payment_id`, `op_status`, `op_paid`, 
                  `op_created_at`, `op_captured_at`, `op_expires_at`, `op_amount`, `op_currency`, `op_payment_options`, 
                  `op_payment_method_saved`, `op_payment_method_id`, `op_following_date` 
                FROM `orders_payment`
                WHERE `op_o_id`=?', $order_id);

            if($sel_payments !== false and 0 < $sel_payments->num_rows())
            {
                foreach ($sel_payments->result() as $row)
                {
                    if($row->op_paid == 1)
                    {
                        $paid_value += $row->op_amount;
                    }
                }
                unset($row);
            }
            elseif($sel_payments === false)
            {
                parent::logDbMessages(__METHOD__.':'.__LINE__);
            }

            $result = $bought_price - $paid_value;
        }

        return $result;
    }

    /**
     * Выборка платежей пользователя, ожидающих подтверждения магазином
     *
     * @param $user_id
     * @param $user_email
     * @return array
     */
    public function getUserWaitingPayments($user_id, $user_email = '')
    {
        $result = array();

        $sel_data = $this->db->query('
            SELECT `o_id`, `o_u_id`, `o_user_email`, `op_payment_id`, `op_status`, `op_amount`, `op_currency` 
            FROM `orders`
            LEFT JOIN `orders_payment` ON `op_o_id`=`o_id`
            WHERE `o_u_id`=? and `op_status`="waiting_for_capture"', $user_id);
        if(!empty($user_email))
        {
            $this->db->where('o_user_email', $user_email);
        }
        if($sel_data !== false and 0 < $sel_data->num_rows())
        {
            $i = 0;
            foreach ($sel_data->result() as $row)
            {
                $result['waiting_payments'][$i]['id'] = $row->op_payment_id;
                $result['waiting_payments'][$i]['amount'] = $row->op_amount;
                $result['waiting_payments'][$i]['currency'] = $row->op_currency;

                $i++;
            }
            unset($row);
        }
        elseif ($sel_data === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }
}