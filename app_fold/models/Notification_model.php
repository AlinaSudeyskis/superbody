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

        $sel_data = $this->db->query('SELECT `n_type`, `n_text` FROM `notifications` ORDER BY `n_id`');

        if($sel_data !== false and 0 < $sel_data->num_rows())
        {
            $i = 1;
            foreach($sel_data->result() as $row)
            {
                $result['text'][$i] = $row->n_text;
                $result['type'][$i] = $row->n_type;

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
     * Выборка списка уведомлений для пользователей
     *
     * @return array
     */
    public function getListUsersNotifications()
    {
        $result = array();

        $sel_data = $this->db->query('SELECT `un_text`, `un_date`, `un_time` FROM `users_notifications` ORDER BY `un_id`');

        if($sel_data !== false and 0 < $sel_data->num_rows())
        {
            $i = 1;
            foreach($sel_data->result() as $row)
            {
                $result[$i]['text'] = $row->un_text;
                $result[$i]['time'] = mb_substr($row->un_time, 0, 5);

                setlocale(LC_ALL, 'ru_RU.UTF-8');
                $tmp_date = DateTime::createFromFormat('Y-m-d', $row->un_date);
                $un_date = ($row->un_date != '0000-00-00' and $tmp_date !== false)
                    ? $tmp_date->format('d.m.Y')
                    : '';
                $result[$i]['date'] = $un_date;

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
            $sel_data = $this->db->query('SELECT `n_text`, `n_type`, `n_name` FROM `notifications` WHERE `n_id`=? LIMIT 1', $notification_id);

            if($sel_data !== false and 1 == $sel_data->num_rows())
            {
                $row = $sel_data->row();

                $result['notification']['type'] = $row->n_type;
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
     * @param $type
     * @param $description
     * @param $admin_id
     * @param $date
     * @return bool
     */
    public function updateNotification($notification_id, $type, $description, $admin_id, $date)
    {
        $result = false;

        if(is_numeric($notification_id) and is_numeric($admin_id) and !empty($description) and !empty($type))
        {
            $up_data = $this->db->query('UPDATE `notifications` SET `n_type`=?, `n_text`=?, `n_admin_id`=?, `n_date`=? WHERE `n_id`=? LIMIT 1',
                array($type, $description, $admin_id, $date, $notification_id));

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
     * Выборка списка эл. писем
     *
     * @return array
     * @throws Exception
     */
    public function getListEmails()
    {
        $result = array('emails' => array());

        $sel_data = $this->db->query('
            SELECT `e_id`, `e_name`, `e_ea_id`, `e_subject`, `e_admin_id`, `e_date`, `ea_name`, `ea_email` 
            FROM `emails`
            LEFT JOIN `emails_addresses` ON `ea_id`=`e_ea_id`
            ORDER BY `e_id`');

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
                $result['emails'][$i]['date']     = parent::parseDatetime($row->e_date);

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
     * @throws Exception
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
     * @throws Exception
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
                $result['addresses'][$i]['date']     = parent::parseDatetime($row->date);

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
     * @throws Exception
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
            $result['address']['date']     = parent::parseDatetime($row->ea_date);
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
     * Выборка отправленных писем пользователям
     *
     * @return array
     * @throws Exception
     */
    public function getSentEmails()
    {
        $result = array();

        $sel_data = $this->db->query('SELECT `se_id`, `se_subject`, `se_text`, `se_whom_type`, `se_user_email`, `se_date` FROM `sent_emails`');
        if($sel_data !== false and 0 < $sel_data->num_rows())
        {
            $i = 0;
            foreach ($sel_data->result() as $row)
            {
                $result['sent_emails'][$i]['id']         = $row->se_id;
                $result['sent_emails'][$i]['subject']    = $row->se_subject;
                $result['sent_emails'][$i]['text']       = $row->se_text;
                $result['sent_emails'][$i]['whom_type']  = $row->se_whom_type;
                $result['sent_emails'][$i]['user_email'] = $row->se_user_email;

                setlocale(LC_ALL, 'ru_RU.UTF-8');
                $tmp_date = DateTime::createFromFormat('Y-m-d H:i:s', parent::parseDatetime($row->se_date));
                $sent_date = ($tmp_date !== false) ? $tmp_date->format('d.m.Y H:i') : '';
                $result['sent_emails'][$i]['date'] = $sent_date;

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
     * Сохранение данных эл. письма, отправляемого пользователям
     *
     * @param $email_from
     * @param $recipients
     * @param $selected_users
     * @param $subject
     * @param $text
     * @param $admin_id
     * @param $date
     * @return array
     */
    public function setUserEmail($email_from, $recipients, $selected_users, $subject, $text, $admin_id, $date)
    {
        $result = array('result' => false, 'users' => array(), 'sent_email_id' => null);

        $ins_data = $this->db->query('INSERT INTO `sent_emails`(`se_ea_id`, `se_subject`, `se_text`, `se_whom_type`, `se_admin_id`, `se_date`) 
            VALUES (?, ?, ?, ?, ?, ?)', array($email_from, $subject, $text, $recipients, $admin_id, $date));

        if($ins_data !== false and 1 == $this->db->affected_rows())
        {
            $sent_email_id = $this->db->insert_id();
            if($recipients == 'several')
            {
                $users_id = implode(", ", $selected_users);
                $sel_users = $this->db->query('SELECT `user_id`, `user_email` FROM `users` WHERE `user_id` IN ('.$users_id.')');
                if($sel_users !== false and 0 < $sel_users->num_rows())
                {
                    $i = 0;
                    foreach($sel_users->result() as $row)
                    {
                        if(!empty($row->user_email) and filter_var($row->user_email, FILTER_VALIDATE_EMAIL) !== false)
                        {
                            $result['users'][$i]['id'] = $row->user_id;
                            $result['users'][$i]['email'] = $row->user_email;

                            $ins_user_data = $this->db->query('INSERT INTO `sent_emails_users`(`seu_se_id`, `seu_u_id`, `seu_u_email`) VALUES(?, ?, ?)',
                                array($sent_email_id, $row->user_id, $row->user_email));
                            if($ins_user_data === false)
                            {
                                parent::logDbMessages(__METHOD__.':'.__LINE__);
                            }

                            $i++;
                        }
                    }
                    unset($row);
                }
                elseif($sel_users === false)
                {
                    parent::logDbMessages(__METHOD__.':'.__LINE__);
                }
            }
            elseif($recipients == 'all')
            {
                $sel_users = $this->db->query('SELECT `user_id`, `user_email`, `s_unsubscribe` FROM `users`
                    LEFT JOIN `subscription` ON `s_email`=`user_email`
                    WHERE `user_email` IS NOT NULL and `user_deleted`=0 and `user_type`=1 and `s_unsubscribe`=0');
                if($sel_users !== false and 0 < $sel_users->num_rows())
                {
                    $i = 0;
                    foreach($sel_users->result() as $row)
                    {
                        if(!empty($row->user_email) and filter_var($row->user_email, FILTER_VALIDATE_EMAIL) !== false)
                        {
                            $result['users'][$i]['id'] = $row->user_id;
                            $result['users'][$i]['email'] = $row->user_email;
                            $i++;
                        }
                    }
                    unset($row);
                }
                elseif($sel_users === false)
                {
                    parent::logDbMessages(__METHOD__.':'.__LINE__);
                }
            }

            $result['result'] = true;
            $result['sent_email_id'] = $sent_email_id;
        }
        elseif($ins_data === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Данные отправленного письма пользователю
     *
     * @param $email_id
     * @return array
     * @throws Exception
     */
    public function getSentEmail($email_id)
    {
        $result = array();

        $sel_data = $this->db->query('SELECT `se_id`, `se_ea_id`, `se_subject`, `se_text`, `se_whom_type`, `se_date` FROM `sent_emails` WHERE `se_id`=? LIMIT 1', $email_id);
        if($sel_data !== false and 0 < $sel_data->num_rows())
        {
            $row = $sel_data->row();

            $result['sent_email']['id']         = $row->se_id;
            $result['sent_email']['address_id'] = $row->se_ea_id;
            $result['sent_email']['subject']    = $row->se_subject;
            $result['sent_email']['text']       = $row->se_text;
            $result['sent_email']['whom_type']  = $row->se_whom_type;
            $result['sent_email']['users']      = array();

            setlocale(LC_ALL, 'ru_RU.UTF-8');
            $tmp_date = DateTime::createFromFormat('Y-m-d H:i:s', parent::parseDatetime($row->se_date));
            $sent_date = ($tmp_date !== false) ? $tmp_date->format('d.m.Y H:i') : '';
            $result['sent_email']['date'] = $sent_date;

            if($row->se_whom_type == 'several')
            {
                $sel_users = $this->db->query('
                    SELECT `seu_u_id`, `seu_u_email`, `user_name` 
                    FROM `sent_emails_users` 
                    LEFT JOIN `users` ON `user_id`=`seu_u_id`
                    WHERE `seu_se_id`=?', $email_id);
                if($sel_users !== false and 0 < $sel_users->num_rows())
                {
                    $i = 0;
                    foreach ($sel_users->result() as $row)
                    {
                        $result['sent_email']['users'][$i]['id'] = $row->seu_u_id;
                        $result['sent_email']['users'][$i]['email'] = $row->seu_u_email;
                        $result['sent_email']['users'][$i]['name'] = $row->user_name;
                        $i++;
                    }
                    unset($row);
                }
                elseif($sel_users === false)
                {
                    parent::logDbMessages(__METHOD__.':'.__LINE__);
                }
            }

        }
        elseif($sel_data === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Обработка данных эл. письма
     *
     * @param $row
     * @return array
     * @throws Exception
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
        $result['date']         = parent::parseDatetime($row->e_date);

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

    /**
     * Сохранение уведомления для пользователя
     *
     * @param $n_text
     * @param $n_date
     * @param $n_time
     * @param $users_group
     * @param $sel_users
     * @param $date
     * @return bool|int
     */
    public function setUserNotification($n_text, $n_date, $n_time, $users_group, $sel_users, $date)
    {
        $result = false;

        $ins_data = $this->db->query('INSERT INTO `users_notifications` (`un_text`, `un_date`, `un_time`, `un_users`, `un_update`) VALUES (?, ?, ?, ?, ?)',
            array($n_text, $n_date, $n_time, $users_group, $date));
        if($ins_data !== false and 1 == $this->db->affected_rows())
        {
            $n_id = $this->db->insert_id();

            self::setUsersNotificationsGroup($n_id, $sel_users, $date);

            $result = $n_id;
        }
        elseif($ins_data === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Выборка данных уведомления для пользователя
     *
     * @param $n_id
     * @return array
     */
    public function getUserNotification($n_id)
    {
        $result = array();

        $sel_data = $this->db->query('SELECT `un_text`, `un_date`, `un_time`, `un_users` FROM `users_notifications` WHERE `un_id`=? LIMIT 1', $n_id);

        if($sel_data !== false and 1 == $sel_data->num_rows())
        {
            $row = $sel_data->row();

            $result['notification']['text'] = $row->un_text;
            $result['notification']['date'] = $row->un_date;
            $result['notification']['time'] = $row->un_time;
            $result['notification']['users_group'] = $row->un_users;

            if($row->un_users == 'group')
            {
                $sel_users = $this->db->query('SELECT `ung_u_id`, `user_email`, `user_name`
                    FROM `users_notifications_group`
                    LEFT JOIN `users` ON `user_id`=`ung_u_id`
                    WHERE `ung_un_id`=?', $n_id);
                if($sel_users !== false and 0 < $sel_users->num_rows())
                {
                    $i = 0;
                    foreach ($sel_users->result() as $row)
                    {
                        $result['notification']['users'][$i]['id'] = $row->ung_u_id;
                        $result['notification']['users'][$i]['email'] = $row->user_email;
                        $result['notification']['users'][$i]['name'] = $row->user_name;

                        $result['notification']['users_ids'][$i] = $row->ung_u_id;

                        $i++;
                    }
                    unset($row);
                }
            }
        }

        return $result;
    }

    /**
     *
     *
     * @param $notification_id
     * @param $notif_text
     * @param $notif_date
     * @param $notif_time
     * @param $users_group
     * @param $sel_users
     * @param $date
     * @return bool
     */
    public function updateUserNotification($notification_id, $notif_text, $notif_date, $notif_time, $users_group, $sel_users, $date)
    {
        $result = false;

        $up_data = $this->db->query('UPDATE `users_notifications` SET `un_text`=?, `un_date`=?, `un_time`=?, `un_users`=?, `un_update`=? WHERE `un_id`=? LIMIT 1',
            array($notif_text, $notif_date, $notif_time, $users_group, $date, $notification_id));
        if($up_data !== false and 1 == $this->db->affected_rows())
        {
            $result = true;

            self::setUsersNotificationsGroup($notification_id, $sel_users, $date);
        }
        elseif($up_data === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Добавление, удаление прикрепленных поьзователей к уведомлению
     *
     * @param $notification_id
     * @param $selected_users
     * @param $date
     */
    public function setUsersNotificationsGroup($notification_id, $selected_users, $date)
    {
        if(is_array($selected_users['insert']) and !empty($selected_users['insert']))
        {
            $values = '';
            foreach($selected_users['insert'] as $user_id)
            {
                $values .= '('.$notification_id.', '.$user_id.', "'.$date.'"),';
            }

            $values = mb_substr($values, 0, -1);

            if(!empty($values))
            {
                $ins_data = $this->db->query('INSERT INTO `users_notifications_group` (`ung_un_id`, `ung_u_id`, `ung_update`) VALUES '.$values);
                if($ins_data === false)
                {
                    parent::logDbMessages(__METHOD__.':'.__LINE__);
                }
            }
        }
        if(is_array($selected_users['delete']) and !empty($selected_users['delete']))
        {
            $values = '';
            foreach($selected_users['delete'] as $user_id)
            {
                $values .= $user_id.',';
            }

            $values = mb_substr($values, 0, -1);

            if(!empty($values))
            {
                $del_data = $this->db->query('DELETE FROM `users_notifications_group` WHERE `ung_un_id`=? and `ung_u_id` IN ('.$values.') ', $notification_id);
                if($del_data === false)
                {
                    parent::logDbMessages(__METHOD__.':'.__LINE__);
                }
            }
        }
    }

    /**
     * Выборка непрочитанных уведомлений для пользователя
     *
     * @param $user_id
     * @param $date
     * @return array
     * @throws Exception
     */
    public function getUserNotifications($user_id, $date)
    {
        $result = array();

        $tmp_date = new DateTime(parent::parseDatetime($date));
        $today = ($tmp_date !== false) ? $tmp_date->format('Y-m-d') : '';

        $sel_data = $this->db->query('
            SELECT `un_id`, `un_text`, `un_date`, `un_time`, `un_users`, `unr_id`
            FROM `users_notifications`
            LEFT JOIN `users_notifications_group` ON `ung_un_id`=`un_id`
            LEFT JOIN `users_notifications_read` ON `unr_un_id`=`un_id` and `unr_u_id`=?
            WHERE (`un_users`="all" or `ung_u_id`=?) and `unr_id` IS NULL and `un_date`<=?
            GROUP BY `un_id`', array($user_id, $user_id, $today));

        if($sel_data !== false and 0 < $sel_data->num_rows())
        {
            $i = 0;
            foreach($sel_data->result() as $row)
            {
                $result['notifications'][$i]['id'] = $row->un_id;
                $result['notifications'][$i]['text'] = $row->un_text;
                $result['notifications'][$i]['date'] = $row->un_date;
                $result['notifications'][$i]['time'] = $row->un_time;

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
     * Сохранение уведомлений как прочитанные
     *
     * @param $user_id
     * @param $notifications_id
     * @param $date
     * @return array
     */
    public function setUserNotificationsRead($user_id, $notifications_id, $date)
    {
        $result = array();

        foreach ($notifications_id as $notif_id)
        {
            if(is_numeric($notif_id))
            {
                $sel_data = $this->db->query('SELECT `unr_id` FROM `users_notifications_read` WHERE `unr_u_id`=? and `unr_un_id`=? LIMIT 1', array($user_id, $notif_id));
                if($sel_data !== false and 0 == $sel_data->num_rows())
                {
                    $ins_data = $this->db->query('INSERT INTO `users_notifications_read` (`unr_u_id`, `unr_un_id`, `unr_update`) VALUES (?, ?, ?)', array($user_id, $notif_id, $date));
                    if($ins_data === false)
                    {
                        parent::logDbMessages(__METHOD__.':'.__LINE__);
                        $result['error_ids'][$notif_id] = 'Не сохранено';
                    }
                }
                elseif($sel_data === false)
                {
                    parent::logDbMessages(__METHOD__.':'.__LINE__);
                }
            }
            else
            {
                $result['error_ids'][$notif_id] = 'Некорректный тип данных';
            }
        }
        unset($notif_id);

        $result = (empty($result)) ? true : $result;

        return $result;
    }
}