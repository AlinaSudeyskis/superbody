<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Administration_model
 *
 * Класс вывода, сохранения, изменения данных пользователей, курсов и т.д.
 *
 * @author Alina Sudeyskis <alina.sudeyskis@gmail.com>
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Notification_model extends CI_Model
{
    /**
     * Выборка списка уведомлений о действия
     *
     * @return array
     */
    public function getListNotifications()
    {
        $result = array();

        $sel_data = $this->db->query('SELECT `n_text` FROM `notifications`');

        if($sel_data !== false and 0 < $sel_data->num_rows())
        {
            $i = 1;
            foreach($sel_data->result() as $row)
            {
                $result[$i] = $row->n_text;

                $i++;
            }
            unset($row);
        }
        elseif($sel_data === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Выборка данных уведомления
     *
     * @param $notification_id
     * @return bool
     */
    public function getNotification($notification_id)
    {
        $result = false;

        if(is_numeric($notification_id))
        {
            $sel_data = $this->db->query('SELECT `n_text`, `n_name` FROM `notifications` WHERE `n_id`=? LIMIT 1', $notification_id);

            if($sel_data !== false and 1 == $sel_data->num_rows())
            {
                $row = $sel_data->row();

                $result['notification']['text'] = $row->n_text;
                $result['notification']['name'] = $row->n_name;
            }
            elseif($sel_data === false)
            {
                parent::logDbMessages(__METHOD__.':'.__LINE__);
            }
        }

        return $result;
    }

    /**
     * Изменение данных уведомления
     *
     * @param $notification_id
     * @param $description
     * @param $admin_id
     * @param $date
     * @return bool
     */
    public function updateNotification($notification_id, $description, $admin_id, $date)
    {
        if(is_numeric($notification_id) and is_numeric($admin_id) and !empty($description))
        {
            $up_data = $this->db->query('UPDATE `notifications` SET `n_text`=?, `n_admin_id`=?, `n_date`=? WHERE `n_id`=? LIMIT 1',
                array($description, $admin_id, $date, $notification_id));

            if($up_data !== false and 1 == $this->db->affected_rows())
            {
                return true;
            }
            elseif($up_data === false)
            {
                parent::logDbMessages(__METHOD__.':'.__LINE__);
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

    /**
     * Выборка списка эл. писем
     *
     * @return array
     */
    public function getListEmails()
    {
        $result = array('emails' => array());

        $sel_data = $this->db->query('
            SELECT `e_id`, `e_name`, `e_ea_id`, `e_subject`, `e_admin_id`, `e_date`, `ea_name`, `ea_email` 
            FROM `emails`
            LEFT JOIN `emails_addresses` ON `ea_id`=`e_ea_id`');

        if($sel_data !== false and 0 < $sel_data->num_rows())
        {
            $i = 0;
            foreach ($sel_data->result() as $row)
            {
                $result['emails'][$i]['id']       = $row->e_id;
                $result['emails'][$i]['name']     = $row->e_name;
                $result['emails'][$i]['email']    = (!empty($row->ea_email)) ? $row->ea_name . ' [' . $row->ea_email . ']' : '';
                $result['emails'][$i]['subject']  = $row->e_subject;
                $result['emails'][$i]['admin_id'] = $row->e_admin_id;
                $result['emails'][$i]['date']     = $row->e_date;

                $i++;
            }
            unset($row);
        }
        elseif($sel_data === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Выборка данных эл. письма
     *
     * @param $email_id
     * @return array
     */
    public function getEmail($email_id)
    {
        $result = array('email' => array());

        $sel_data = $this->db->query('
            SELECT `e_id`, `e_name`, `e_ea_id`, `e_subject`, `e_text`, `e_images`, `e_admin_id`, `e_date`, `ea_name`, `ea_email`
            FROM `emails` 
            LEFT JOIN `emails_addresses` ON `ea_id`=`e_ea_id`
            WHERE `e_id`=? LIMIT 1', $email_id);

        if($sel_data !== false and 1 == $sel_data->num_rows())
        {
            $row = $sel_data->row();

            $result['email'] = self::parseEmailData($row);
        }
        elseif($sel_data === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }


        return $result;
    }

    /**
     * Обновление данных эл. письма
     *
     * @param $email_id
     * @param $address_id
     * @param $subject
     * @param $text
     * @param $image
     * @param $admin_id
     * @param $date
     * @return bool
     */
    public function updateEmailData($email_id, $address_id, $subject, $text, $image, $admin_id, $date)
    {
        $result = false;

        if(is_numeric($email_id))
        {
            $up_data = $this->db->query('
                UPDATE `emails` SET `e_ea_id`=?, `e_subject`=?, `e_text`=?, `e_images`=?, `e_admin_id`=?, `e_date`=?
                WHERE `e_id`=? LIMIT 1', array($address_id, $subject, $text, $image, $admin_id, $date, $email_id));

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
     * Выборка email адресов сайта
     *
     * @return array
     */
    public function getListEmailsAddresses()
    {
        $result = array('addresses' => array(), 'default_address' => null);

        $sel_data = $this->db->query('SELECT `ea_id`, `ea_name`, `ea_email`, `ea_default`, `ea_admin_id`, `ea_date` FROM `emails_addresses`');

        if($sel_data !== false and 0 < $sel_data->num_rows())
        {
            $i = 0;
            foreach ($sel_data->result() as $row)
            {
                $result['addresses'][$i]['id']       = $row->ea_id;
                $result['addresses'][$i]['name']     = $row->ea_name;
                $result['addresses'][$i]['email']    = $row->ea_email;
                $result['addresses'][$i]['default']  = $row->ea_default;
                $result['addresses'][$i]['admin_id'] = $row->ea_admin_id;
                $result['addresses'][$i]['date']     = $row->date;

                if($row->ea_default == 1)
                {
                    $result['default_address'] = $row->ea_id;
                }

                $i++;
            }
            unset($row);
        }
        elseif($sel_data === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Выборка данных email адреса
     *
     * @param $email_id
     * @return array
     */
    public function getEmailAddress($email_id)
    {
        $result = array('address' => array());

        $sel_data = $this->db->query('
            SELECT `ea_id`, `ea_name`, `ea_email`, `ea_default`, `ea_admin_id`, `ea_date` 
            FROM `emails_addresses` 
            WHERE `ea_id`=? LIMIT 1', $email_id);

        if($sel_data !== false and 1 == $sel_data->num_rows())
        {
            $row = $sel_data->row();

            $result['address']['id']       = $row->ea_id;
            $result['address']['name']     = $row->ea_name;
            $result['address']['email']    = $row->ea_email;
            $result['address']['default']  = $row->ea_default;
            $result['address']['admin_id'] = $row->ea_admin_id;
            $result['address']['date']     = $row->ea_date;
        }
        elseif($sel_data === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Обновление данные email адреса
     *
     * @param $email_id
     * @param $e_name
     * @param $e_email
     * @param $default
     * @param $admin_id
     * @param $date
     * @return bool
     */
    public function updateEmailAddress($email_id, $e_name, $e_email, $default, $admin_id, $date)
    {
        $up_data = $this->db->query('
            UPDATE `emails_addresses` SET `ea_name`=?, `ea_email`=?, `ea_default`=?, `ea_admin_id`=?, `ea_date`=?
            WHERE `ea_id`=? LIMIT 1', array($e_name, $e_email, $default, $admin_id, $date, $email_id));

        if($up_data !== false and 1 == $this->db->affected_rows())
        {
            if($default === 1)
            {
                // Изменение данных "по умолчанию" = 0 у всех эл. адресов, кроме текущего
                $up_data2 = $this->db->query('UPDATE `emails_addresses` SET `ea_default`=0 WHERE `ea_id`<>?', $email_id);

                if($up_data2 === false)
                {
                    parent::logDbMessages(__METHOD__.':'.__LINE__);
                }
            }

            return true;
        }
        elseif($up_data === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
            return false;
        }
        else
        {
            return false;
        }
    }

    /**
     * Сохранение нового эл. адреса
     *
     * @param $e_email
     * @param $e_name
     * @param $default
     * @param $admin_id
     * @param $date
     * @return bool
     */
    public function setNewEmailAddress($e_email, $e_name, $default, $admin_id, $date)
    {
        if(!empty($e_email))
        {
            $ins_data = $this->db->query('
                INSERT INTO `emails_addresses`(`ea_name`, `ea_email`, `ea_default`, `ea_admin_id`, `ea_date`) 
                VALUES (?, ?, ?, ?, ?)', array($e_name, $e_email, $default, $admin_id, $date));

            if($ins_data !== false and 1 == $this->db->affected_rows())
            {
                if($default === 1)
                {
                    // Изменение данных "по умолчанию" = 0 у всех эл. адресов, кроме текущего
                    $up_data = $this->db->query('UPDATE `emails_addresses` SET `ea_default`=0 WHERE `ea_id`<>?', $this->db->insert_id());

                    if($up_data === false)
                    {
                        parent::logDbMessages(__METHOD__.':'.__LINE__);
                    }
                }

                return $this->db->insert_id();
            }
            elseif($ins_data === false)
            {
                parent::logDbMessages(__METHOD__.':'.__LINE__);
            }
        }

        return false;
    }

    /**
     * Обработка данных эл. письма
     *
     * @param $row
     * @return array
     */
    public function parseEmailData($row)
    {
        $result = array();

        $result['id']           = $row->e_id;
        $result['name']         = $row->e_name;
        $result['ea_id']        = (!empty($row->e_ea_id)) ? $row->e_ea_id : '';
        $result['email']        = (!empty($row->ea_email)) ? $row->ea_name . ' [' . $row->ea_email . ']' : '';
        $result['sender_name']  = $row->ea_name;
        $result['sender_email'] = $row->ea_email;
        $result['subject']      = $row->e_subject;
        $result['text']         = ($row->e_text) ? parent::showBBcodes($row->e_text) : '';
        $result['image']        = (!empty($row->e_images)) ? mb_substr($row->e_images, 1) : '';
        $result['admin_id']     = $row->e_admin_id;
        $result['date']         = $row->e_date;

        return $result;
    }

    /**
     * Сохранение токена устройства в БД
     *
     * @param $token
     * @param $date
     * @param $user_id
     * @return bool
     */
    public function setToken($token, $date, $user_id = 0)
    {
        $result = false;

        $sel_data = $this->db->query('SELECT `nt_token`, `nt_u_id` FROM `notification_tokens` WHERE `nt_token`=? LIMIT 1', $token);

        if($sel_data !== false and 0 == $sel_data->num_rows())
        {
            $ins_data = $this->db->query('INSERT INTO `notification_tokens`(`nt_token`, `nt_date`, `nt_u_id`) VALUES (?, ?, ?)',
                array($token, $date, $user_id));
            if($ins_data === false)
            {
                parent::logDbMessages(__METHOD__.':'.__LINE__);
            }
        }
        elseif($sel_data === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Выборка всех токенов
     *
     * @return array
     */
    public function getTokens()
    {
        $result = array('tokens' => array());

        $sel_data = $this->db->query('SELECT `nt_token` FROM `notification_tokens` LIMIT 1000');
        if($sel_data !== false and 0 < $sel_data->num_rows())
        {
            $i = 0;
            foreach ($sel_data->result() as $row)
            {
                $result['tokens'][$i] = $row->nt_token;

                $i++;
            }
            unset($row);
        }
        elseif($sel_data === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }
}