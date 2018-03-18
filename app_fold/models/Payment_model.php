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
     * @return bool
     */
    public function setNewOrderPayment($order_id, $payment_id, $payment_status, $total_amount, $currency, $created_at)
    {
        $ins_data = $this->db->query('
            INSERT INTO `orders_payment` (`op_o_id`, `op_payment_id`, `op_status`, `op_amount`, `op_currency`, `op_created_at`) 
            VALUES (?, ?, ?, ?, ?, ?)',
            array($order_id, $payment_id, $payment_status, $total_amount, $currency, $created_at));
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
}