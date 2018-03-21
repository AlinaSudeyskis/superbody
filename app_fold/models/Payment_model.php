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
     * @param string $payment_option (full_payment, installments)
     * @return bool
     */
    public function setNewOrderPayment($order_id, $payment_id, $payment_status, $total_amount, $currency, $created_at, $payment_option)
    {
        $ins_data = $this->db->query('
            INSERT INTO `orders_payment` (`op_o_id`, `op_payment_id`, `op_status`, `op_amount`, `op_currency`, `op_payment_options`, `op_created_at`) 
            VALUES (?, ?, ?, ?, ?, ?, ?)',
            array($order_id, $payment_id, $payment_status, $total_amount, $currency, $payment_option, $created_at));
        if ($ins_data !== false and 1 == $this->db->affected_rows())
        {
            return true;
        }
        elseif ($ins_data === false)
        {
            parent::logDbMessages(__METHOD__);
            return false;
        }
        else
        {
            return false;
        }
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
                return true;
            }
            elseif ($up_data === false)
            {
                parent::logDbMessages(__METHOD__);
                return false;
            }
            else
            {
                return false;
            }
        }
        elseif($sel_payment === false)
        {
            parent::logDbMessages(__METHOD__);

            return false;
        }
        else
        {
            return false;
        }
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

        $sel_data = $this->db->query('SELECT `op_o_id`, `op_payment_options` FROM `orders_payment` WHERE `op_payment_id`=? LIMIT 1', $payment_id);
        if($sel_data !== false and 1 == $sel_data->num_rows())
        {
            $row = $sel_data->row();

            $result['order_id'] = $row->op_o_id;
            $result['option']   = $row->op_payment_options;
        }
        elseif($sel_data === false)
        {
            parent::logDbMessages(__METHOD__);
        }

        return $result;
    }

    /**
     * Сохранение последующих платежей заказа
     *
     * @param $order_id
     * @param $payment_method
     * @param $payment_method_id
     * @param $recurrent_data
     * @param $date
     */
    public function setSubsequentPayments($order_id, $payment_method, $payment_method_id, $recurrent_data, $date)
    {
        if (!empty($recurrent_data))
        {
            foreach ($recurrent_data as $course)
            {
                if ($course['recurrent'] === true)
                {
                    $months = $course['recur_months'] - 1;
                    $following_date = $date;

                    // Цикл добавления будущих платежей
                    for($i = 1; $i <= $months; $i++)
                    {
                        $tmp_date = new DateTime($following_date);
                        $tmp_date->add(new DateInterval('P1M'));
                        $following_date = $tmp_date->format('Y-m-d H:i:s');

                        $ins_data = $this->db->query('
                            INSERT INTO `orders_payment` (`op_o_id`, `op_number`, `op_payment_type`, `op_amount`, `op_currency`, `op_payment_method_id`, `op_following_date`)
                            VALUES (?, ?, ?, ?, ?, ?, ?)',
                                array($order_id, $i, $payment_method, $course['recur_subsequent'], 'RUB', $payment_method_id, $following_date));
                        if($ins_data === false)
                        {
                            parent::logDbMessages(__METHOD__);
                        }
                    }
                }
            }
        }
    }

    /**
     * Выборка платежей, которые нужно провести
     *
     * @param $today
     * @return array
     */
    public function getSubsequentPayments($today)
    {
        $result = array();

        $sel_data = $this->db->query('
            SELECT `op_id`, `op_o_id`, `op_payment_type`, `op_amount`, `op_currency`, `op_payment_method_id` 
            FROM `orders_payment`
            WHERE `op_following_date`=? and `op_payment_method_id`<>""', $today);
        if($sel_data !== false and 0 < $sel_data->num_rows())
        {
            $i = 0;
            foreach($sel_data->result() as $row)
            {
                $result['payments'][$i]['id']        = $row->op_id;
                $result['payments'][$i]['order_id']  = $row->op_o_id;
                $result['payments'][$i]['type']      = $row->op_payment_type;
                $result['payments'][$i]['amount']    = $row->op_amount;
                $result['payments'][$i]['currency']  = $row->op_currency;
                $result['payments'][$i]['method_id'] = $row->op_payment_method_id;

                $i++;
            }
            unset($row);
        }
        elseif ($sel_data === false)
        {
            parent::logDbMessages(__METHOD__);
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
        if (is_numeric($subsequent_id))
        {
            $up_data = $this->db->query('
                UPDATE `orders_payment` 
                SET `op_payment_type`=?, `op_payment_id`=?, `op_status`=?, `op_paid`=?, `op_created_at`=?
                WHERE `op_id`=? and `op_o_id`=? LIMIT 1',
                    array($payment_method, $payment_id, $payment_status, $paid, $created_at, $subsequent_id, $order_id));
            if($up_data !== false and 1 == $up_data->num_rows())
            {
                return true;
            }
            elseif($up_data === false)
            {
                parent::logDbMessages(__METHOD__);
                return false;
            }
            else
            {
                return false;
            }
        }
        else
        {
            return false;
        }
    }
}