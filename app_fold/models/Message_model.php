<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Message_model
 *
 * Класс для работы с личными сообщениями и обратной связью
 *
 * @author Alina Sudeyskis <alina.sudeyskis@gmail.com>
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Message_model extends CI_Model
{
    /* БЛОК ФУНКЦИЙ СООБЩЕНИЙ ПОЛЬЗОВАТЕЛЕЙ */

    /**
     * Сохранение сообщения пользователя
     *
     * @param int $user_id ID пользователя
     * @param int $user_with ID пользователя с кем идет беседа
     * @param string $message_text Текст сообщения
     * @param $date
     * @return bool
     */
    public function setUserMessage($user_id, $user_with, $message_text, $date)
    {
        $conv_id = self::getConversationId($user_id, $user_with);

        if (empty($conv_id))
        {
            $conv_id = self::getNewConversationId();
        }

        $ins_data = $this->db->query('
            INSERT INTO `users_messages` (`um_from`, `um_whom`, `um_conv_id`, `um_text`, `um_date`) 
            VALUES (?, ?, ?, ?, ?)', array($user_id, $user_with, $conv_id, $message_text, $date));

        if ($ins_data !== false and 1 == $this->db->affected_rows()) {
            return true;
        }
        elseif($ins_data === false)
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
     * ID диалога
     *
     * @param int $user_id ID пользователя
     * @param int $user_with ID пользователя с которым ведется диалог
     * @return int
     */
    public function getConversationId($user_id, $user_with)
    {
        $result = null;

        // ID диалога
        $sel_mess = $this->db->query('
            SELECT `um_conv_id` FROM `users_messages` WHERE (`um_from`=? and `um_whom`=?) or (`um_from`=? and `um_whom`=?) 
            LIMIT 1', array($user_id, $user_with, $user_with, $user_id));

        if ($sel_mess !== false and 1 == $sel_mess->num_rows())
        {
            $row = $sel_mess->row();

            $result = $row->um_conv_id;

            unset($row);
            $sel_mess->free_result();
        }
        elseif($sel_mess === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Вычисление нового номера диалога сообщений для новой пары пользователей
     *
     * @return int
     */
    public function getNewConversationId()
    {
        $result = 1;

        $sel_last_conv = $this->db->query('SELECT `um_conv_id` FROM `users_messages` ORDER BY `um_conv_id` DESC LIMIT 1');
        if ($sel_last_conv !== false and 1 == $sel_last_conv->num_rows())
        {
            $row = $sel_last_conv->row();
            $result = $row->um_conv_id + 1;
            unset($row);
        }
        elseif($sel_last_conv === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Выборка списка последних диалогов пользователя
     *
     * @param $user_id
     * @param $user_with
     * @return array
     */
    public function getUserConversations($user_id, $user_with)
    {
        $result = array('user_conversations' => array(), 'user_new_conversation' => array());

        if(is_numeric($user_id) and is_numeric($user_with))
        {
            // Флаг обозначения, что пользователь с кем идет переписка не найден в списке диалогов
            $fl_user_with = false;

            $sel_mess = $this->db->query('
            SELECT `um_conv_id`, `um_from`, `um_whom`, `um_text`, `um_date`, `um_new`, `user_name`, `user_email`, `user_image` 
            FROM `users_messages` 
            LEFT JOIN `users`
              ON CASE 
                WHEN `um_from`=? 
                THEN `um_whom`=`user_id` 
                ELSE `um_from`=`user_id` 
                END
            WHERE `um_blocked`=0 and (`um_from`=? or `um_whom`=?) 
              and  `um_date` IN 
                (SELECT max(`um_date`) FROM `users_messages` GROUP BY `um_conv_id`)
            ORDER BY `um_date` DESC', array($user_id, $user_id, $user_id));

            if ($sel_mess !== false and 0 < $sel_mess->num_rows())
            {
                $i = 0;
                foreach ($sel_mess->result() as $row)
                {
                    if ($user_id == $row->um_from)
                    {
                        $result['user_conversations'][$i]['user_with']['id'] = $row->um_whom;
                    }
                    else
                    {
                        $result['user_conversations'][$i]['user_with']['id'] = $row->um_from;
                    }

                    if($result['user_conversations'][$i]['user_with']['id'] == $user_with)
                    {
                        $fl_user_with = true;
                    }

                    $result['user_conversations'][$i]['user_with']['name']  = !empty($row->user_name) ? $row->user_name : $row->user_email;
                    $result['user_conversations'][$i]['user_with']['image'] = mb_substr($row->user_image, 1);

                    $result['user_conversations'][$i]['from'] = $row->um_from;
                    $result['user_conversations'][$i]['text'] = $row->um_text;

                    setlocale(LC_ALL, 'ru_RU.UTF-8');
                    $date = DateTime::createFromFormat('Y-m-d H:i:s', $row->um_date);
                    $message_date = ($row->um_date != '0000-00-00 00:00:00' or $date !== false)
                        ? $date->format('d.m.Y')
                        : '';

                    $result['user_conversations'][$i]['date'] = $message_date;
                    $result['user_conversations'][$i]['new']  = ($row->um_whom == $user_id) ? $row->um_new : 0;

                    if (empty($result['user_conversations'][$i]['total_new']))
                    {
                        $result['user_conversations'][$i]['total_new'] = ($row->um_whom == $user_id) ? $row->um_new : 0;
                    }
                    else
                    {
                        $result['user_conversations'][$i]['total_new'] += ($row->um_whom == $user_id) ? $row->um_new : 0;
                    }

                    $i++;
                }
                unset($row);
                $sel_mess->free_result();
            }
            elseif($sel_mess === false)
            {
                parent::logDbMessages(__METHOD__.':'.__LINE__);
            }

            // Данные нового пользователя
            if($fl_user_with === false)
            {
                $sel_user = $this->db->query('
                SELECT `user_name`, `user_email`, `user_image` 
                FROM `users`
                WHERE `user_id`=? and `user_type`=2 LIMIT 1', $user_with);

                if($sel_user !== false and 1 == $sel_user->num_rows())
                {
                    $row = $sel_user->row();

                    $result['user_new_conversation']['user_with']['id']    = $user_with;
                    $result['user_new_conversation']['user_with']['name']  = !empty($row->user_name) ? $row->user_name : $row->user_email;
                    $result['user_new_conversation']['user_with']['image'] = mb_substr($row->user_image, 1);
                }
                elseif($sel_user === false)
                {
                    parent::logDbMessages(__METHOD__.':'.__LINE__);
                }
            }
        }

        return $result;
    }

    /**
     * Выборка сообщений диалога с пользователем
     *
     * @param int $user_id ID пользователя
     * @param int $user_with ID пользователя с кем идет переписка
     * @param string $date Текущая дата
     * @return array
     */
    public function getUserMessages($user_id, $user_with, $date)
    {
        $result = array('user_messages' => array(), 'user_with_blocked' => 0);

        if (is_numeric($user_id) and is_numeric($user_with))
        {
            // ID диалога
            $result['conv_id'] = self::getConversationId($user_id, $user_with);

            // Данные пользователя с кем ведется диалог
            $result['conv_with']['name'] = '';
            $sel_user_with = $this->db->query('SELECT `user_id`, `user_name`, `user_email`, `user_image` FROM `users` WHERE `user_id`=? and `user_type`=2 LIMIT 1', $user_with);

            if ($sel_user_with !== false and 1 == $sel_user_with->num_rows())
            {
                $row = $sel_user_with->row();

                $user_name = (!empty($row->user_name)) ? $row->user_name : $row->user_email;

                $result['conv_with']['name'] = (!empty($user_name)) ? $user_name : 'Собеседник №' . $row->user_id;
            }
            elseif($sel_user_with === false)
            {
                parent::logDbMessages(__METHOD__.':'.__LINE__);
            }
            unset($row);
            $sel_user_with->free_result();

            $sel_mess = $this->db->query('
                SELECT `um_from`, `um_whom`, `um_text`, `um_date`, `um_new`, `user_id`, `user_name`, `user_email`, `user_image`, `user_blocked` 
                FROM `users_messages` 
                LEFT JOIN `users` ON `um_from`=`user_id`
                WHERE `um_conv_id`=? and `um_blocked`=0', $result['conv_id']);

            if ($sel_mess !== false and 0 < $sel_mess->num_rows())
            {
                $i = 0;
                foreach ($sel_mess->result() as $row)
                {
                    $result['user_messages'][$i] = self::parseMessageData($row, $date);

                    if($row->user_id == $user_with and $row->user_blocked == 1)
                    {
                        $result['user_with_blocked'] = 1;
                    }

                    $i++;
                }
                unset($row);
            }
            elseif($sel_mess === false)
            {
                parent::logDbMessages(__METHOD__.':'.__LINE__);
            }
        }

        return $result;
    }

    /**
     * Выборка личных сообщений пользователей
     *
     * @return array
     */
    public function getMessages()
    {
        $result = array();

        $sel_messages = $this->db->query('
            SELECT `um_id`, `um_from`, `um_whom`, `um_text`, `um_date`, `um_new`, `um_blocked`, `user_name`, `user_email`, `user_image` 
            FROM `users_messages` 
            LEFT JOIN `users` ON `um_from`=`user_id`
            ORDER BY `um_date` DESC');

        if ($sel_messages !== false and 0 < $sel_messages->num_rows())
        {
            $i = 0;
            foreach ($sel_messages->result() as $row)
            {
                $result['messages'][$i]['id'] = $row->um_id;

                $result['messages'][$i]['user']['id']    = $row->um_from;
                $result['messages'][$i]['user']['name']  = !empty($row->user_name) ? $row->user_name : $row->user_email;
                $result['messages'][$i]['user']['image'] = !empty($row->user_image) ? mb_substr($row->user_image, 1) : '';

                $result['messages'][$i]['text'] = $row->um_text;

                setlocale(LC_ALL, 'ru_RU.UTF-8');
                $date = DateTime::createFromFormat('Y-m-d H:i:s', $row->um_date);
                $message_date = ($row->um_date != '0000-00-00 00:00:00' or $date !== false)
                    ? strftime('%d %B %G, %H:%M', strtotime($row->um_date))
                    : '';

                $result['messages'][$i]['date']    = $message_date;
                $result['messages'][$i]['blocked'] = $row->um_blocked;

                $i++;
            }
            unset($row);
        }
        elseif($sel_messages === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Выборка сообщения пользователя
     *
     * @param $message_id
     * @return array
     */
    public function getMessage($message_id)
    {
        $result = array();
        $sel_message = $this->db->query('
            SELECT `um_id`, `um_from`, `um_whom`, `um_text`, `um_date`, `um_blocked`, 
              `user_name`, `user_email`, `user_image` 
            FROM `users_messages` 
            LEFT JOIN `users`
              ON `um_from`=`user_id`
            WHERE `um_id`=? LIMIT 1', $message_id);

        if ($sel_message !== false and 1 == $sel_message->num_rows())
        {
            $row = $sel_message->row();

            $result['message']['id'] = $row->um_id;

            $result['message']['user']['id']    = $row->um_from;
            $result['message']['user']['name']  = !empty($row->user_name) ? $row->user_name : $row->user_email;
            $result['message']['user']['image'] = !empty($row->user_image) ? mb_substr($row->user_image, 1) : '';

            $result['message']['text'] = $row->um_text;

            setlocale(LC_ALL, 'ru_RU.UTF-8');
            $date = DateTime::createFromFormat('Y-m-d H:i:s', $row->um_date);
            $message_date = ($row->um_date != '0000-00-00 00:00:00' or $date !== false)
                ? strftime('%d %B %G, %H:%M', strtotime($row->um_date))
                : '';

            $result['message']['date']    = $message_date;
            $result['message']['blocked'] = $row->um_blocked;
        }
        elseif($sel_message === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Разблокировка сообщения
     *
     * @param $message_id
     * @param $date
     * @return bool
     */
    public function unblockMessage($message_id, $date)
    {
        $up_data = $this->db->query('UPDATE `users_messages` SET `um_blocked`=0 WHERE `um_id`=? LIMIT 1', $message_id);

        if ($up_data !== false and 1 == $this->db->affected_rows())
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

    /**
     * Блокировка сообщения
     *
     * @param $message_id
     * @param $date
     * @return bool
     */
    public function blockMessage($message_id, $date)
    {
        $up_data = $this->db->query('UPDATE `users_messages` SET `um_blocked`=1 WHERE `um_id`=? LIMIT 1', $message_id);

        if ($up_data !== false and 1 == $this->db->affected_rows()) {
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
     * Кол-во новых личных сообщений пользователя
     *
     * @param $user_id
     * @return int
     */
    public function getCountNewMessages($user_id)
    {
        $result = 0;

        if (is_numeric($user_id))
        {
            $sel_num_new = $this->db->query('SELECT COUNT(`um_id`) as `count_new` FROM `users_messages` WHERE `um_whom`=? and `um_new`=1', $user_id);

            if ($sel_num_new !== false and 1 == $sel_num_new->num_rows())
            {
                $row = $sel_num_new->row();
                $result = $row->count_new;
                unset($row);
            }
            elseif ($sel_num_new === false)
            {
                parent::logDbMessages(__METHOD__.':'.__LINE__);
            }
        }

        return $result;
    }

    /**
     * Обновления статусов сообщений как прочитанные в диалоге
     *
     * @param $user_id
     * @param $user_with
     * @return bool|int
     */
    public function updateReadingStatus($user_id, $user_with)
    {
        $up_data = $this->db->query('
          UPDATE `users_messages` SET `um_new`=0 WHERE `um_whom`=? and `um_from`=? and `um_new`=1', array($user_id, $user_with));

        if ($up_data !== false and 0 < $this->db->affected_rows())
        {
            $new_messages = $this->getCountNewMessages($user_id);

            return $new_messages;
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

    /* КОНЕЦ БЛОКА ФУНКЦИЙ СООБЩЕНИЙ ПОЛЬЗОВАТЕЛЕЙ */

    /* БЛОК ФУНКЦИЙ СООБЩЕНИЙ ОБРАТНОЙ СВЯЗИ */

    /**
     * Сохранение сообщения обратной связи
     *
     * @param int $user_id ID пользователя
     * @param string $user_name Имя пользователя
     * @param string $user_email E-mail пользователя
     * @param string $message_text Текст сообщения
     * @param $date
     * @return bool
     */
    public function setFeedbackMessage($user_id, $user_name, $user_email, $message_text, $date)
    {
        $user_id = (is_numeric($user_id)) ? $user_id : 0;
        $conv_id = $this->getFeedbackConvId($user_id, $user_email);

        $ins_data = $this->db->query('
            INSERT INTO `feedback` (`fb_conv_id`, `fb_user_id`, `fb_user_name`, `fb_user_email`, `fb_text`, `fb_date_add`) 
            VALUES (?, ?, ?, ?, ?, ?)',
                array($conv_id, $user_id, $user_name, $user_email, $message_text, $date));

        if ($ins_data !== false and 1 == $this->db->affected_rows())
        {
            return true;
        }
        elseif($ins_data === false)
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
     * Определение номера диалога обратной связи
     *
     * @param int|null $user_id
     * @param string|null $user_email
     * @return int
     */
    public function getFeedbackConvId($user_id = null, $user_email = null)
    {
        $result = null;

        // Определени ID диалога по ID или email пользователя
        if (!empty($user_email))
        {
            $sel_conv = $this->db->query('SELECT `fb_conv_id` FROM `feedback` WHERE `fb_user_email`=? LIMIT 1', $user_email);
            if ($sel_conv !== false and 1 == $sel_conv->num_rows())
            {
                $row = $sel_conv->row();
                $result = $row->fb_conv_id;
                unset($row);
            }
            elseif($sel_conv === false)
            {
                parent::logDbMessages(__METHOD__.':'.__LINE__);
            }
        }
        elseif (is_numeric($user_id))
        {
            $sel_conv = $this->db->query('SELECT `fb_conv_id` FROM `feedback` WHERE `fb_user_id`=? LIMIT 1', $user_id);
            if ($sel_conv !== false and 1 == $sel_conv->num_rows())
            {
                $row = $sel_conv->row();
                $result = $row->fb_conv_id;
                unset($row);
            }
            elseif($sel_conv === false)
            {
                parent::logDbMessages(__METHOD__.':'.__LINE__);
            }
        }

        // Вычисление нового ID
        if((empty($user_id) and empty($user_email)) or empty($result))
        {
            $sel_last_conv = $this->db->query('SELECT `fb_conv_id` FROM `feedback` ORDER BY `fb_conv_id` DESC LIMIT 1');
            if ($sel_last_conv !== false and 1 == $sel_last_conv->num_rows())
            {
                $row = $sel_last_conv->row();
                $result = $row->fb_conv_id + 1;
                unset($row);
            }
            elseif($sel_last_conv === false)
            {
                parent::logDbMessages(__METHOD__.':'.__LINE__);
            }
        }

        return $result;
    }

    /**
     * Список диалогов с пользователями обратной связи
     *
     * @return array
     */
    public function getFeedbackMessages()
    {
        $result = array();

        $sel_messages = $this->db->query('
            SELECT `t_fb`.`fb_conv_id`, `fb_user_id`, `fb_user_name`, `fb_user_email`, `fb_text`, `fb_date_add`, 
              `fb_admin_id`, `fb_new`, `fb_blocked`, `count_new`, `user_email` as `admin_email`, `user_name` as `admin_name`
            FROM `feedback` as `t_fb`
            LEFT JOIN 
              (SELECT SUM(`fb_new`) as `count_new`, `fb_conv_id` FROM `feedback` WHERE `fb_admin_id`=0 and `fb_new`=1 GROUP BY `fb_conv_id`) as `t_new`
              ON `t_fb`.`fb_conv_id` = `t_new`.`fb_conv_id`
            LEFT JOIN `users` ON `fb_admin_id`=`user_id`
            WHERE `fb_date_add` IN 
                (SELECT max(`fb_date_add`) FROM `feedback` GROUP BY `fb_conv_id`) 
            GROUP BY `t_fb`.`fb_conv_id`
            ORDER BY `t_fb`.`fb_date_add` DESC');

        if ($sel_messages !== false and 0 < $sel_messages->num_rows())
        {
            $i = 0;
            foreach ($sel_messages->result() as $row)
            {
                $result['fb_messages'][$i] = self::parseFeedbackData($row);

                $i++;
            }
            unset($row);
        }
        elseif ($sel_messages === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Сообщения диалога обратной связи с пользователем
     *
     * @param null|int $user_id ID пользователя
     * @param null|string $user_email E-mail пользователя
     * @param null|int $conv_id ID беседы
     * @param string $date Текущая дата
     * @return array
     */
    public function getFeedbackUserMessages($user_id = null, $user_email = null, $conv_id = null, $date = null)
    {
        $result = array('fb_user_messages' => array(), 'fb_conv_id' => '', 'fb_total_new' => 0);

        if (is_numeric($user_id) or !empty($user_email) or is_numeric($conv_id))
        {
            $total_new = 0;
            $sel_messages = null;
            $field = '`fb_conv_id`';
            $param = 0;

            // Поиск по ID пользователя
            if (is_numeric($user_id))
            {
                $field = '`fb_user_id`';
                $param = $user_id;
            }
            // Поиск по Email пользователя
            elseif (!empty($user_email))
            {
                $field = '`fb_user_email`';
                $param = $user_email;
            }
            // Поиск по ID беседы
            elseif (is_numeric($conv_id))
            {
                $field = '`fb_conv_id`';
                $param = $conv_id;
            }

            $sel_messages = $this->db->query('
                SELECT `fb_conv_id`, `fb_user_name`, `fb_user_email`, `fb_user_id`, `fb_text`, `fb_date_add`, `fb_admin_id`, 
                  `fb_new`, `user_name` as `admin_name`, `user_email` as `admin_email`
                FROM `feedback`
                LEFT JOIN `users` ON `fb_admin_id`=`user_id`
                WHERE ' . $field . '=?', $param);

            if ($sel_messages !== false and !empty($sel_messages) and 0 < $sel_messages->num_rows())
            {
                $i = 0;
                foreach ($sel_messages->result() as $row)
                {
                    $result['fb_conv_id'] = $row->fb_conv_id;
                    $result['fb_user_messages'][$i] = self::parseFeedbackData($row, $date);

                    $total_new += ($row->fb_admin_id == 0) ? $row->fb_new : 0;

                    $i++;
                }
                unset($row);

                $result['fb_total_new'] = $total_new;
            }
            elseif($sel_messages === false)
            {
                parent::logDbMessages(__METHOD__.':'.__LINE__);
            }

        }

        return $result;
    }

    /**
     * Сообщения диалога обратной связи для пользователя
     *
     * @param null|int $user_id ID пользователя
     * @param null|string $user_email E-mail пользователя
     * @param null|int $conv_id ID беседы
     * @param string $date Текущая дата
     * @return array
     */
    public function getUserFeedbackMessages($user_id = null, $user_email = null, $conv_id = null, $date = null)
    {
        $result = array('fb_user_messages' => array(), 'fb_conv_id' => '', 'fb_total_new' => 0);

        if (is_numeric($user_id) or !empty($user_email) or is_numeric($conv_id))
        {
            $total_new    = 0;
            $sel_messages = null;
            $field        = '`fb_conv_id`';
            $param        = 0;

            // Поиск по Email пользователя
            if (!empty($user_email))
            {
                $field = '`fb_user_email`';
                $param = $user_email;
            }
            // Поиск по ID пользователя
            elseif (is_numeric($user_id))
            {
                $field = '`fb_user_id`';
                $param = $user_id;
            }
            // Поиск по ID беседы
            elseif (is_numeric($conv_id))
            {
                $field = '`fb_conv_id`';
                $param = $conv_id;
            }

            $sel_messages = $this->db->query('
                SELECT `fb_conv_id`, `fb_user_name`, `fb_user_email`, `fb_user_id`, `fb_text`, `fb_date_add`, `fb_admin_id`, 
                  `fb_new`, `user_name` as `admin_name`, `user_email` as `admin_email`
                FROM `feedback`
                LEFT JOIN `users` ON `fb_admin_id`=`user_id`
                WHERE ' . $field . '=?', $param);

            if ($sel_messages !== false and !empty($sel_messages) and 0 < $sel_messages->num_rows())
            {
                $i = 0;
                foreach ($sel_messages->result() as $row)
                {
                    $result['fb_conv_id'] = $row->fb_conv_id;
                    $result['fb_user_messages'][$i] = self::parseFeedbackData($row, $date);

                    $total_new += ($row->fb_admin_id > 0) ? $row->fb_new : 0;

                    $i++;
                }
                unset($row);

                $result['fb_total_new'] = $total_new;
            }
            elseif($sel_messages === false)
            {
                parent::logDbMessages(__METHOD__.':'.__LINE__);
            }

        }

        return $result;
    }

    /**
     * Сообщения диалога обратной связи для пользователя
     *
     * @param null|int $user_id ID пользователя
     * @param null|string $user_email E-mail пользователя
     * @param null|int $conv_id ID беседы
     * @param string $date Текущая дата
     * @return array
     */
    public function getLastTwoUserFeedbackMessages($user_id = null, $user_email = null, $conv_id = null, $date = null)
    {
        $result = array('fb_user_messages' => array(), 'fb_conv_id' => '', 'fb_total_new' => 0);

        if (is_numeric($user_id) or !empty($user_email) or is_numeric($conv_id))
        {
            $total_new    = 0;
            $sel_messages = null;
            $field        = '`fb_conv_id`';
            $param        = 0;

            // Поиск по Email пользователя
            if (!empty($user_email))
            {
                $field = '`fb_user_email`';
                $param = $user_email;
            }
            // Поиск по ID пользователя
            elseif (is_numeric($user_id))
            {
                $field = '`fb_user_id`';
                $param = $user_id;
            }
            // Поиск по ID беседы
            elseif (is_numeric($conv_id))
            {
                $field = '`fb_conv_id`';
                $param = $conv_id;
            }

            $sel_messages = $this->db->query('
                SELECT `fb_conv_id`, `fb_user_name`, `fb_user_email`, `fb_user_id`, `fb_text`, `fb_date_add`, `fb_admin_id`, 
                  `fb_new`, `user_name` as `admin_name`, `user_email` as `admin_email`
                FROM `feedback`
                LEFT JOIN `users` ON `fb_admin_id`=`user_id`
                WHERE ' . $field . '=?
                ORDER BY `fb_date_add` DESC
                LIMIT 2', $param);

            if ($sel_messages !== false and !empty($sel_messages) and 0 < $sel_messages->num_rows())
            {
                $i = 0;
                foreach ($sel_messages->result() as $row)
                {
                    $result['fb_conv_id'] = $row->fb_conv_id;
                    $result['fb_user_messages'][$i] = self::parseFeedbackData($row, $date);

                    $total_new += ($row->fb_admin_id > 0) ? $row->fb_new : 0;

                    $i++;
                }
                unset($row);

                krsort($result['fb_user_messages']);
                $result['fb_total_new'] = $total_new;
            }
            elseif($sel_messages === false)
            {
                parent::logDbMessages(__METHOD__.':'.__LINE__);
            }

        }

        return $result;
    }

    /**
     * Список ID диалогов обратной связи пользователя
     *
     * @param string $user_email E-mail пользователя
     * @return array
     */
    public function getFeedbackUserConvId($user_email)
    {
        $result = array();

        $sel_conv_id = $this->db->query('SELECT `fb_conv_id` FROM `feedback` WHERE `fb_user_email`=? and `fb_conv_id`<>0
            GROUP BY `fb_conv_id` ORDER BY `fb_conv_id` DESC', $user_email);

        if ($sel_conv_id !== false and 0 < $sel_conv_id->num_rows())
        {
            $i = 0;
            foreach ($sel_conv_id->result() as $row)
            {
                $result['conv_id'][$i] = $row->fb_conv_id;

                $i++;
            }
            unset($row);
        }
        elseif($sel_conv_id === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Сохранение ответа администрации на письмо пользователя
     *
     * @param int $admin_id ID администратора
     * @param int $user_id ID пользователя
     * @param string $user_email E-mail пользователя
     * @param string $message_text Текст сообщения
     * @param int|null $conv_id ID диалога
     * @param $date
     * @return bool|array
     */
    public function setFeedbackAnswer($admin_id, $user_id = null, $user_email = null, $message_text, $conv_id = null, $date)
    {
        $user_name = '';

        $sel_fb_user = $this->db->query('
            SELECT `fb_conv_id`, `fb_user_id`, `fb_user_email`, `fb_user_name`
            FROM `feedback` 
            WHERE 
                CASE 
                    WHEN ? IS NOT NULL
                    THEN `fb_conv_id`=?
                    ELSE
                        CASE 
                            WHEN ? IS NOT NULL
                            THEN `fb_user_email`=? 
                            ELSE `fb_user_id`=? 
                        END 
                END
            LIMIT 1', array($conv_id, $conv_id, $user_email, $user_email, $user_id));

        if ($sel_fb_user !== false and 1 == $sel_fb_user->num_rows())
        {
            $row = $sel_fb_user->row();

            $conv_id    = $row->fb_conv_id; // Номер диалога с пользователем
            $user_id    = $row->fb_user_id;
            $user_email = $row->fb_user_email;
            $user_name  = $row->fb_user_name;

            unset($row);
        }
        elseif($sel_fb_user === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        if (!empty($conv_id) and is_numeric($conv_id))
        {
            $user_id    = is_numeric($user_id) ? $user_id : 0;
            $user_email = !empty($user_email) ? $user_email : '';

            $ins_data = $this->db->query('
                INSERT INTO `feedback` (`fb_conv_id`, `fb_admin_id`, `fb_user_email`, `fb_user_name`, `fb_user_id`, `fb_text`, `fb_date_add`) 
                VALUES (?, ?, ?, ?, ?, ?, ?)', array($conv_id, $admin_id, $user_email, $user_name, $user_id, $message_text, $date));

            if ($ins_data !== false and 1 == $this->db->affected_rows())
            {
                // Обновление статуса сообщения на прочитанный
                $this->db->query('UPDATE `feedback` SET `fb_read`=?, `fb_new`=0 
                    WHERE `fb_conv_id`=? and `fb_admin_id`=0 and `fb_new`=1', array($admin_id, $conv_id));

                // Выборка последних сообщений переписки для отправки на почту не зарегистрированного пользователя
                if($user_id == 0)
                {
                    $two_messages = self::getLastTwoUserFeedbackMessages($user_id, $user_email, $conv_id, $date);
                    return $two_messages;
                }

                return true;
            }
            elseif($ins_data === false)
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
     * Выборка сообщений пользователя определенного диалога
     *
     * @param string $user_email E-mail пользователя
     * @param int $conv_id ID диалога пользователя
     * @return array
     */
    public function getFeedbackUserConversation($user_email, $conv_id)
    {
        $result = array();
        $sel_messages = $this->db->query('
            SELECT `fb_conv_id`, `fb_user_name`, `fb_user_email`, `fb_text`, `fb_date_add`, `user_name`, `user_email`
            FROM `feedback`
            LEFT JOIN `users`
              ON `fb_admin_id`=`user_id`
            WHERE `fb_user_email`=? and `fb_conv_id`=?', array($user_email, $conv_id));

        if ($sel_messages !== false and 0 < $sel_messages->num_rows())
        {
            $i = 0;
            foreach ($sel_messages->result() as $row)
            {
                $result['fb_user_messages'][$i]['conv_id']    = $row->fb_conv_id;

                if (!empty($row->fb_user_name))
                {
                    $result['fb_user_messages'][$i]['user_email'] = $row->fb_user_email;
                    $result['fb_user_messages'][$i]['user_name']  = $row->fb_user_name;
                }
                else
                {
                    $result['fb_user_messages'][$i]['user_name'] = !empty($row->user_name) ? $row->user_name : $row->user_email;
                }

                $result['fb_user_messages'][$i]['text'] = mb_substr($row->fb_text, 0, 255);

                setlocale(LC_ALL, 'ru_RU.UTF-8');
                $date = DateTime::createFromFormat('Y-m-d H:i:s', $row->fb_date_add);
                $message_date = ($row->fb_date_add != '0000-00-00 00:00:00' or $date !== false)
                    ? strftime('%d %B %G, %H:%M', strtotime($row->fb_date_add))
                    : '';

                $result['fb_user_messages'][$i]['date'] = $message_date;

                $i++;
            }
            unset($row);
        }
        elseif($sel_messages === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Кол-во новых сообщений обратной связи пользователя
     *
     * @param $user_id
     * @param $user_email
     * @return int
     */
    public function getCountNewFeedbackMessages($user_id, $user_email)
    {
        $result = 0;
        $sel_num_new = null;

        if(is_numeric($user_id))
        {
            $sel_num_new = $this->db->query('SELECT COUNT(`fb_id`) as `count_new` FROM `feedback` 
                WHERE `fb_user_id`=? and `fb_new`=1 and `fb_admin_id`>0', $user_id);
        }
        elseif (!empty($user_email))
        {
            $sel_num_new = $this->db->query('SELECT COUNT(`fb_id`) as `count_new` FROM `feedback` 
                WHERE `fb_user_email`=? and `fb_new`=1 and `fb_admin_id`>0', $user_email);
        }

        if ($sel_num_new !== false and !empty($sel_num_new) and 1 == $sel_num_new->num_rows())
        {
            $row = $sel_num_new->row();
            $result = $row->count_new;
            unset($row);
        }
        elseif($sel_num_new === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * АП. Кол-во новых сообщений обратной связи.
     *
     * @return int
     */
    public function getAdminCountNewFeedbackMessages()
    {
        $result = 0;

        $sel_num_new = $this->db->query('SELECT COUNT(`fb_id`) as `count_new` FROM `feedback` 
            WHERE `fb_new`=1 and `fb_admin_id`=0
            GROUP BY `fb_user_email`');
        if ($sel_num_new !== false and 0 < $sel_num_new->num_rows())
        {
            foreach($sel_num_new->result() as $row)
            {
                $result++;
            }
            unset($row);
        }
        elseif($sel_num_new === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Обновления статусов сообщений обратной связи как прочитанные
     *
     * @param $user_email
     * @param $user_id
     * @return bool|int
     */
    public function updateFeedbackReadingStatus($user_email, $user_id)
    {
        $up_data = null;

        if (is_numeric($user_id))
        {
            $up_data = $this->db->query('UPDATE `feedback` SET `fb_new`=0 WHERE `fb_user_id`=? and `fb_new`=1 and `fb_admin_id`>0', $user_id);
        }
        elseif(!empty($user_email))
        {
            $up_data = $this->db->query('UPDATE `feedback` SET `fb_new`=0 WHERE `fb_user_email`=? and `fb_new`=1 and `fb_admin_id`>0', $user_email);
        }

        if ($up_data !== false and !empty($up_data) and 0 < $this->db->affected_rows())
        {
            $new_fb_messages = self::getCountNewFeedbackMessages($user_id, $user_email);

            return $new_fb_messages;
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
     * Отправка системного сообщения пользователю. В данном случае о возврате платежа
     *
     * @param $user_id
     * @param $admin_id
     * @param $date
     * @return bool
     */
    public function sendUserMessage($user_id, $admin_id, $date)
    {
        $sel_u_data = $this->db->query('SELECT `user_email`, `user_name` FROM `users` WHERE `user_id`=? LIMIT 1', $user_id);

        if ($sel_u_data !== false and 1 == $sel_u_data->num_rows())
        {
            $row = $sel_u_data->row();

            $conv_id = self::getFeedbackConvId($user_id);
            $text    = 'Здравствуйте, Вам был произведен возврат средств за услуги доступа к сайту Superbody.pro. на карту, с которой производилась оплата. '
                . 'Поступление денежных средств на Вашу карту произойдет в соответствии с регламентом возврата Вашего банка.';

            if (!empty($conv_id))
            {
                $send_message = $this->db->query('
                INSERT INTO `feedback`(`fb_conv_id`, `fb_user_name`, `fb_user_email`, `fb_user_id`, `fb_admin_id`, `fb_text`, `fb_new`, `fb_date_add`) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)', array($conv_id, $row->user_name, $row->user_email, $user_id, $admin_id, $text, 1, $date));

                if ($send_message !== false and 1 == $this->db->affected_rows())
                {
                    return true;
                }
                elseif($send_message === false)
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
        elseif ($sel_u_data === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
            return false;
        }
        else
        {
            return false;
        }
    }

    /* КОНЕЦ БЛОКА ФУНКЦИЙ СООБЩЕНИЙ ОБРАТНОЙ СВЯЗИ */

    /* БЛОК ОБРАБОТКИ ДАННЫХ СООБЩЕНИЙ */

    /**
     * Обработка данных сообщения
     *
     * @param object $row
     * @param string $date
     * @return array
     */
    public function parseMessageData($row, $date)
    {
        $result['user_from']['id']    = $row->um_from;
        $result['user_from']['name']  = !empty($row->user_name) ? $row->user_name : $row->user_email;
        $result['user_from']['image'] = mb_substr($row->user_image, 1);

        $result['text'] = $row->um_text;

        setlocale(LC_ALL, 'ru_RU.UTF-8');
        $tmp_date = DateTime::createFromFormat('Y-m-d H:i:s', $row->um_date);
        $message_date = ($row->um_date != '0000-00-00 00:00:00' and $tmp_date !== false)
            ? $tmp_date->format('d.m.Y')
            : '';
        $message_time = ($row->um_date != '0000-00-00 00:00:00' and $tmp_date !== false)
            ? $tmp_date->format('H:i')
            : '';
        $tmp_date = DateTime::createFromFormat('Y-m-d H:i:s', $date);
        $fl_date = ($tmp_date !== false and $tmp_date->format('d.m.Y') == $message_date) ? 1 : 0;

        $result['date']    = $message_date;
        $result['time']    = $message_time;
        $result['fl_date'] = $fl_date;
        $result['new']     = $row->um_new;

        return $result;
    }

    /**
     * Обработка данных обратной связи
     *
     * @param object $row
     * @param string $date
     * @return mixed
     */
    public function parseFeedbackData($row, $date = null)
    {
        $result['admin_id']   = $row->fb_admin_id;
        $result['user_id']    = $row->fb_user_id;
        $result['user_email'] = $row->fb_user_email;
        $result['user_name']  = 'Беседа №' . $row->fb_conv_id;
        $result['url']        = 'conv' . DIRECTORY_SEPARATOR . $row->fb_conv_id;

        // Данные администратора
        if ($row->fb_admin_id > 0)
        {
            $result['admin_name'] = !empty($row->admin_name) ? $row->admin_name : 'Администратор №' . $row->fb_admin_id;
        }

        // Данные пользователя
        if (!empty($row->fb_user_email))
        {
            $result['url']        = $row->fb_user_email;
            $result['user_name']  = !empty($row->fb_user_name) ? $row->fb_user_name : $row->fb_user_email;
            $result['user_email'] = $result['user_name'] == $row->fb_user_email ? '' : $row->fb_user_email;
        }
        elseif(!empty($row->fb_user_id))
        {
            $result['url']       = $row->fb_user_id;
            $result['user_name'] = !empty($row->fb_user_name) ? $row->fb_user_name : 'Пользователь №' . $row->fb_user_id;
        }

        $result['text'] = $row->fb_text;
        $result['new']  = $row->fb_new;

        setlocale(LC_ALL, 'ru_RU.UTF-8');
        $tmp_date = DateTime::createFromFormat('Y-m-d H:i:s', $row->fb_date_add);
        $message_date = ($row->fb_date_add != '0000-00-00 00:00:00' and $tmp_date !== false)
            ? $tmp_date->format('d.m.Y')
            : '';
        $message_time = ($row->fb_date_add != '0000-00-00 00:00:00' and $tmp_date !== false)
            ? $tmp_date->format('H:i')
            : '';

        $result['date'] = $message_date;
        $result['time'] = $message_time;

        if (!empty($date))
        {
            $tmp_date = DateTime::createFromFormat('Y-m-d H:i:s', $date);
            $fl_date = ($tmp_date !== false and $tmp_date->format('d.m.Y') == $message_date) ? 1 : 0;
            $result['fl_date'] = $fl_date;
        }

        $result['fb_new'] = (!empty($row->count_new)) ? parent::endingWords($row->count_new, 'сообщение', 'сообщений', 'сообщения') : '';

        return $result;
    }

    /* КОНЕЦ БЛОКА ОБРАБОТКИ ДАННЫХ СООБЩЕНИЙ */

    /* БЛОК ОБРАБОТКИ ДАННЫХ РАЗДЕЛА ВОПРОС - ОТВЕТ */

    /**
     * Выборка групп пользователей
     *
     * @return array
     */
    public function getQaUsersGroup()
    {
        $result = array();

        $sel_data = $this->db->query('SELECT `qaug_id`, `qaug_name` FROM `q_a_users_group`');
        if($sel_data !== false and 0 < $sel_data->num_rows())
        {
            $i = 0;
            foreach($sel_data->result() as $row)
            {
                $result['users_group'][$i]['id']   = $row->qaug_id;
                $result['users_group'][$i]['name'] = $row->qaug_name;

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
     * Выборка групп пользователей статьи
     *
     * @param $article_id
     * @param $count_ug
     * @return array
     */
    public function getQaArticleUsersGroups($article_id, $count_ug)
    {
        $result = array('users_group' => array());

        $sel_data = $this->db->query('SELECT `qag_id`, `qag_qa_id`, `qag_qaug_id`, `qag_admin_id`, `qag_date` 
            FROM `q_a_groups` 
            WHERE `qag_qa_id`=?', $article_id);
        if(!empty($count_ug))
        {
            $this->db->limit($count_ug);
        }
        if($sel_data !== false and 0 < $sel_data->num_rows())
        {
            $i = 0;
            foreach($sel_data->result() as $row)
            {
                $result['users_group'][$i] = $row->qag_qaug_id;

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
     * Сохранение нового раздела Вопрос - Ответ
     *
     * @param $section_name
     * @param $admin_id
     * @param $date
     * @return bool
     */
    public function setNewQaSection($section_name, $admin_id, $date)
    {
        $result = false;

        $ins_data = $this->db->query('INSERT INTO `q_a_sections`(`qas_name`, `qas_admin_id`, `qas_update`) VALUES (?, ?, ?)',
            array($section_name, $admin_id, $date));

        if($ins_data !== false and 1 == $this->db->affected_rows())
        {
            $result = $this->db->insert_id();
        }
        elseif($ins_data === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Выборка данных раздела
     *
     * @param $section_id
     * @return array
     */
    public function getQaSection($section_id)
    {
        $result = array();

        $sel_data = $this->db->query('SELECT `qas_id`, `qas_name`, `qas_blocked`, `qas_update`, `qas_admin_id` 
            FROM `q_a_sections` 
            WHERE `qas_id`=? LIMIT 1', $section_id);

        if($sel_data !== false and 1 == $sel_data->num_rows())
        {
            $row = $sel_data->row();

            $result['section']['id']       = $row->qas_id;
            $result['section']['name']     = $row->qas_name;
            $result['section']['blocked']  = $row->qas_blocked;
            $result['section']['update']   = $row->qas_update;
            $result['section']['admin_id'] = $row->qas_admin_id;
        }
        elseif($sel_data === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Сохранение данных раздела
     *
     * @param $section_id
     * @param $section_name
     * @param $admin_id
     * @param $date
     * @return bool
     */
    public function setQaSection($section_id, $section_name, $admin_id, $date)
    {
        $result = false;

        $up_data = $this->db->query('UPDATE `q_a_sections` SET `qas_name`=?, `qas_update`=?, `qas_admin_id`=? WHERE `qas_id`=? LIMIT 1',
            array($section_name, $date, $admin_id, $section_id));

        if($up_data !== false and 1 == $this->db->affected_rows())
        {
            $result = true;
        }
        elseif($up_data === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Блокировка раздела
     *
     * @param $section_id
     * @param $block_type
     * @param $admin_id
     * @param $date
     * @return bool
     */
    public function blockQaSection($section_id, $block_type, $admin_id, $date)
    {
        $result = false;

        $up_data = $this->db->query('UPDATE `q_a_sections` SET `qas_blocked`=?, `qas_update`=?, `qas_admin_id`=? WHERE `qas_id`=? LIMIT 1',
            array($block_type, $date, $admin_id, $section_id));

        if($up_data !== false and 1 == $this->db->affected_rows())
        {
            $result = true;
        }
        elseif($up_data === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Выборка разделов
     * @return array
     */
    public function getQaSections()
    {
        $result = array();

        $sel_data = $this->db->query('SELECT `qas_id`, `qas_name`, `qas_blocked`, `qas_update`, `qas_admin_id` FROM `q_a_sections`');

        if($sel_data !== false and 0 < $sel_data->num_rows())
        {
            $i = 0;
            foreach ($sel_data->result() as $row)
            {
                $result['sections'][$i]['id'] = $row->qas_id;
                $result['sections'][$i]['name'] = $row->qas_name;
                $result['sections'][$i]['blocked'] = $row->qas_bloked;
                $result['sections'][$i]['update'] = $row->qas_update;
                $result['sections'][$i]['admin_id'] = $row->qas_admin_id;

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
     * Сохранение данных подраздела
     *
     * @param $section_id
     * @param $subsection_name
     * @param $admin_id
     * @param $date
     * @return bool
     */
    public function setNewQaSubsection($section_id, $subsection_name, $admin_id, $date)
    {
        $result = false;

        $ins_data = $this->db->query('INSERT INTO `q_a_subsections`(`qass_qas_id`, `qass_name`, `qass_update`, `qass_admin_id`) 
            VALUES (?, ?, ?, ?)', array($section_id, $subsection_name, $date, $admin_id));

        if($ins_data !== false and 1 == $this->db->affected_rows())
        {
            $result = $this->db->insert_id();
        }
        elseif($ins_data === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Выборка данных подраздела
     *
     * @param $subsection_id
     * @return array
     */
    public function getQaSubsection($subsection_id)
    {
        $result = array();

        $sel_data = $this->db->query('SELECT `qass_id`, `qass_qas_id`, `qass_name`, `qass_blocked`, `qass_update`, `qass_admin_id` 
            FROM `q_a_subsections` WHERE `qass_id`=? LIMIT 1', $subsection_id);

        if($sel_data !== false and 1 == $sel_data->num_rows())
        {
            $row = $sel_data->row();

            $result['subsection']['id']         = $row->qass_id;
            $result['subsection']['section_id'] = $row->qass_qas_id;
            $result['subsection']['name']       = $row->qass_name;
            $result['subsection']['blocked']    = $row->qass_blocked;
            $result['subsection']['update']     = $row->qass_update;
            $result['subsection']['admin_id']   = $row->qass_admin_id;
        }
        elseif($sel_data === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Сохранение данных подраздела
     *
     * @param $subsection_id
     * @param $section_id
     * @param $subsection_name
     * @param $admin_id
     * @param $date
     * @return bool
     */
    public function setQaSubsection($subsection_id, $section_id, $subsection_name, $admin_id, $date)
    {
        $result = false;

        $up_data = $this->db->query('UPDATE `q_a_subsections` SET `qass_qas_id`=?, `qass_name`=?, `qass_update`=?, `qass_admin_id`=? 
            WHERE `qass_id`=? LIMIT 1', array($section_id, $subsection_name, $date, $admin_id, $subsection_id));

        if($up_data !== false and 1 == $this->db->affected_rows())
        {
            $result = true;
        }
        elseif($up_data === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Блокировка подраздела
     *
     * @param $subsection_id
     * @param $block_type
     * @param $admin_id
     * @param $date
     * @return bool
     */
    public function blockQaSubsection($subsection_id, $block_type, $admin_id, $date)
    {
        $result = false;

        $up_data = $this->db->query('UPDATE `q_a_subsections` SET `qass_blocked`=?, `qass_update`=?, `qass_admin_id`=? 
            WHERE `qass_id`=? LIMIT 1', array($block_type, $date, $admin_id, $subsection_id));

        if($up_data !== false and 1 == $this->db->affected_rows())
        {
            $result = true;
        }
        elseif($up_data === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Выборка подразделов раздела
     *
     * @param $section_id
     * @return array
     */
    public function getQaSectionSubsections($section_id)
    {
        $result = array();

        $sel_data = $this->db->query('SELECT `qass_id`, `qass_name`, `qass_blocked`, `qass_update`, `qass_admin_id` 
            FROM `q_a_subsections` WHERE `qass_qas_id`=?', $section_id);

        if($sel_data !== false and 0 < $sel_data->num_rows())
        {
            $i = 0;
            foreach ($sel_data->result() as $row)
            {
                $result['subsections'][$i]['id']       = $row->qass_id;
                $result['subsections'][$i]['name']     = $row->qass_name;
                $result['subsections'][$i]['blocked']  = $row->qass_blocked;
                $result['subsections'][$i]['update']   = $row->qass_update;
                $result['subsections'][$i]['admin_id'] = $row->qass_admin_id;

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
     * Выборка всех подразделов
     *
     * @return array
     */
    public function getQaSubsections()
    {
        $result = array();

        $sel_data = $this->db->query('SELECT `qass_id`, `qass_qas_id`, `qass_name`, `qass_blocked`, `qass_update`, `qass_admin_id` 
            FROM `q_a_subsections`');

        if($sel_data !== false and 0 < $sel_data->num_rows())
        {
            foreach ($sel_data->result() as $row)
            {
                $result['subsections'][$row->qass_qas_id][$row->qass_id]['id']       = $row->qass_id;
                $result['subsections'][$row->qass_qas_id][$row->qass_id]['name']     = $row->qass_name;
                $result['subsections'][$row->qass_qas_id][$row->qass_id]['blocked']  = $row->qass_blocked;
                $result['subsections'][$row->qass_qas_id][$row->qass_id]['update']   = $row->qass_update;
                $result['subsections'][$row->qass_qas_id][$row->qass_id]['admin_id'] = $row->qass_admin_id;
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
     * Сохранение новой статьи
     *
     * @param $section_id
     * @param $subsection_id
     * @param $user_group
     * @param $article_name
     * @param $article_text
     * @param $admin_id
     * @param $date
     * @return bool
     */
    public function setNewQaArticle($section_id, $subsection_id, $user_group, $article_name, $article_text, $admin_id, $date)
    {
        $result = false;

        $ins_data = $this->db->query('INSERT INTO `question_answer`(`qa_qas_id`, `qa_qass_id`, `qa_name`, `qa_text`, `qa_update`, `qa_admin_id`) 
            VALUES (?, ?, ?, ?, ?, ?)', array($section_id, $subsection_id, $article_name, $article_text, $date, $admin_id));

        if($ins_data !== false and 1 == $this->db->affected_rows())
        {
            $article_id = $this->db->insert_id();
            $result     = $article_id;

            self::updateQaArticleUsersGroups($article_id, $user_group, $admin_id, $date);
        }
        elseif($ins_data === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Выборка статьей
     * @param $count_ug
     * @return array
     */
    public function getQaArticles($count_ug)
    {
        $result = array();

        $sel_data = $this->db->query('SELECT `qa_id`, `qa_qass_id`, `qa_name`, `qa_blocked`, `qa_update`, `qa_admin_id` FROM `question_answer`');

        if($sel_data !== false and 0 < $sel_data->num_rows())
        {
            $i = 0;
            foreach ($sel_data->result() as $row)
            {
                $result['qa_articles'][$i] = self::parseQaData($row);

                $get_ug = self::getQaArticleUsersGroups($row->qa_id, $count_ug);
                $result['qa_articles'][$i]['users_group'] = $get_ug['users_group'];

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
     * Выборка данных статьи
     *
     * @param $article_id
     * @param $count_ug
     * @return array
     */
    public function getQaArticle($article_id, $count_ug)
    {
        $result = array();

        $sel_data = $this->db->query('SELECT `qa_id`, `qa_qas_id`, `qa_qass_id`, `qa_name`, `qa_text`, `qa_blocked`, `qa_update`, `qa_admin_id` 
            FROM `question_answer` WHERE `qa_id`=? LIMIT 1', $article_id);

        if($sel_data !== false and 1 == $sel_data->num_rows())
        {
            $row = $sel_data->row();

            $result['qa_article'] = self::parseQaData($row);

            $get_ug = self::getQaArticleUsersGroups($article_id, $count_ug);
            $result['qa_article']['users_group'] = $get_ug['users_group'];
        }
        elseif($sel_data === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Сохранение данных статьи
     *
     * @param $article_id
     * @param $section_id
     * @param $subsection_id
     * @param $user_group
     * @param $article_name
     * @param $article_text
     * @param $admin_id
     * @param $date
     * @return bool
     */
    public function setQaArticle($article_id, $section_id, $subsection_id, $user_group, $article_name, $article_text, $admin_id, $date)
    {
        $result = false;

        $up_data = $this->db->query('UPDATE `question_answer` SET `qa_qas_id`=?, `qa_qass_id`=?, `qa_name`=?, `qa_text`=?, `qa_update`=?, `qa_admin_id`=? 
            WHERE `qa_id`=? LIMIT 1', array($section_id, $subsection_id, $article_name, $article_text, $date, $admin_id, $article_id));

        if($up_data !== false and 1 == $this->db->affected_rows())
        {
            $result = true;

            self::updateQaArticleUsersGroups($article_id, $user_group, $admin_id, $date);
        }
        elseif($up_data === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Обновление данных групп пользователей статьи
     *
     * @param $article_id
     * @param $user_group
     * @param $admin_id
     * @param $date
     */
    protected function updateQaArticleUsersGroups($article_id, $user_group, $admin_id, $date)
    {
        if(!empty($user_group['insert']))
        {
            $value = '';
            foreach ($user_group['insert'] as $ug)
            {
                if (!empty($value))
                {
                    $value .= ', ';
                }
                $value .= '(' . $article_id .', "' . $ug . '", "' . $admin_id . '", "' . $date . '")';
            }
            unset($ug);

            if(!empty($value))
            {
                $ins_data = $this->db->query('INSERT INTO `q_a_groups`(`qag_qa_id`, `qag_qaug_id`, `qag_admin_id`, `qag_date`) 
                    VALUES '.$value);
                if($ins_data === false)
                {
                    parent::logDbMessages(__METHOD__.':'.__LINE__);
                }
            }
        }

        if(!empty($user_group['delete']))
        {
            $value = '';
            foreach ($user_group['delete'] as $ug)
            {
                if (!empty($value))
                {
                    $value .= ', ';
                }
                $value .= $ug;
            }
            unset($ug);

            if(!empty($value))
            {
                $del_data = $this->db->query('DELETE FROM `q_a_groups` WHERE `qag_qa_id`=? and `qag_qaug_id` IN ('.$value.')', $article_id);
                if($del_data === false)
                {
                    parent::logDbMessages(__METHOD__.':'.__LINE__);
                }
            }
        }
    }

    /**
     * Блокировка статьи
     *
     * @param $article_id
     * @param $block_type
     * @param $admin_id
     * @param $date
     * @return bool
     */
    public function blockQaArticle($article_id, $block_type, $admin_id, $date)
    {
        $result = false;

        $up_data = $this->db->query('UPDATE `question_answer` SET `qa_blocked`=?, `qa_update`=?, `qa_admin_id`=? 
            WHERE `qa_id`=? LIMIT 1', array($block_type, $date, $admin_id, $article_id));

        if($up_data !== false and 1 == $this->db->affected_rows())
        {
            $result = true;
        }
        elseif($up_data === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Выборка общедоступных разделов с подразделами
     *
     * @param $user_type
     * @return array
     */
    public function getPublicQaSections($user_type)
    {
        $result = array();

        $user_group = ' and `qag_qaug_id`=1';
        if($user_type == 'user')
        {
            $user_group = ' and (`qag_qaug_id`=1 or `qag_qaug_id`=2)';
        }
        elseif($user_type == 'coach')
        {
            $user_group = ' and (`qag_qaug_id`=1 or `qag_qaug_id`=3)';
        }
        elseif($user_type == 'admin')
        {
            $user_group = ' and (`qag_qaug_id`=1 or `qag_qaug_id`=4)';
        }

        $sel_data = $this->db->query('SELECT `qass_id`, `qass_qas_id`, `qass_name`, `qass_blocked`, `qas_name`, `qas_blocked`
            FROM `q_a_subsections` 
            LEFT JOIN `q_a_sections` ON `qas_id`=`qass_qas_id`
            WHERE `qass_blocked`=0 and `qas_blocked`=0');

        if($sel_data !== false and 0 < $sel_data->num_rows())
        {
            foreach ($sel_data->result() as $row)
            {
                $sel_articles = $this->db->query('SELECT COUNT(`qa_id`) as `count_articles`, `qag_qaug_id` FROM `question_answer`
                    LEFT JOIN `q_a_groups` ON `qag_qa_id`=`qa_id` 
                    WHERE `qa_qass_id`=? and `qa_blocked`=0' . $user_group, $row->qass_id);
                if($sel_articles !== false and 1 == $sel_articles->num_rows())
                {
                    $row2 = $sel_articles->row();
                    if($row2->count_articles > 0)
                    {
                        $result['sections'][$row->qass_qas_id]['name'] = $row->qas_name;
                        $result['sections'][$row->qass_qas_id]['subsections'][$row->qass_id]['name'] = $row->qass_name;
                    }
                }
                elseif($sel_articles === false)
                {
                    parent::logDbMessages(__METHOD__.':'.__LINE__);
                }
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
     * Выборка общедоступных подразделов раздела
     *
     * @param $section_id
     * @param $user_type
     * @return array
     */
    public function getPublicQaSection($section_id, $user_type)
    {
        $result = array();

        $user_group = ' and `qag_qaug_id`=1';
        if($user_type == 'user')
        {
            $user_group = ' and (`qag_qaug_id`=1 or `qag_qaug_id`=2)';
        }
        elseif($user_type == 'coach')
        {
            $user_group = ' and (`qag_qaug_id`=1 or `qag_qaug_id`=3)';
        }
        elseif($user_type == 'admin')
        {
            $user_group = ' and (`qag_qaug_id`=1 or `qag_qaug_id`=4)';
        }

        $sel_data = $this->db->query('SELECT `qass_id`, `qass_qas_id`, `qass_name`, `qas_name`, `qas_blocked` 
            FROM `q_a_subsections` 
            LEFT JOIN `q_a_sections` ON `qas_id`=`qass_qas_id`
            WHERE `qas_blocked`=0 and `qass_blocked`=0 and `qass_qas_id`=?', $section_id);

        if($sel_data !== false and 0 < $sel_data->num_rows())
        {
            $i = 0;
            foreach($sel_data->result() as $row)
            {
                $sel_articles = $this->db->query('SELECT COUNT(`qa_id`) as `count_articles`, `qag_qaug_id` FROM `question_answer` 
                    LEFT JOIN `q_a_groups` ON `qag_qa_id`=`qa_id`
                    WHERE `qa_qass_id`=? and `qa_blocked`=0' . $user_group, $row->qass_id);
                if($sel_articles !== false and 1 == $sel_articles->num_rows())
                {
                    $result['section']['id'] = $section_id;
                    $result['section']['name'] = $row->qas_name;
                    $result['section']['subsections'][$row->qass_id]['name'] = $row->qass_name;
                }
                elseif($sel_articles === false)
                {
                    parent::logDbMessages(__METHOD__.':'.__LINE__);
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
     * Выборка общедоступных статей подраздела
     *
     * @param $section_id
     * @param $subsection_id
     * @param $user_type
     * @return array
     */
    public function getPublicQaSubsection($section_id, $subsection_id, $user_type)
    {
        $result = array();

        $user_group = ' and `qag_qaug_id`=1';
        if($user_type == 'user')
        {
            $user_group = ' and (`qag_qaug_id`=1 or `qag_qaug_id`=2)';
        }
        elseif($user_type == 'coach')
        {
            $user_group = ' and (`qag_qaug_id`=1 or `qag_qaug_id`=3)';
        }
        elseif($user_type == 'admin')
        {
            $user_group = ' and (`qag_qaug_id`=1 or `qag_qaug_id`=4)';
        }

        $sel_data = $this->db->query('SELECT `qass_id`, `qass_name` FROM `q_a_subsections` 
            WHERE `qass_id`=? and `qass_qas_id`=? and `qass_blocked`=0 LIMIT 1', array($subsection_id, $section_id));

        if($sel_data !== false and 1 == $sel_data->num_rows())
        {
            $row = $sel_data->row();

            $result['subsection']['id']   = $row->qass_id;
            $result['subsection']['name'] = $row->qass_name;
        }
        elseif($sel_data === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Выборка общедоступных статей подраздела
     *
     * @param $section_id
     * @param $subsection_id
     * @param $user_type
     * @return array
     */
    public function getPublicQaSubsectionArticles($section_id, $subsection_id, $user_type)
    {
        $result = array();

        $user_group = ' and `qag_qaug_id`=1';
        if($user_type == 'user')
        {
            $user_group = ' and (`qag_qaug_id`=1 or `qag_qaug_id`=2)';
        }
        elseif($user_type == 'coach')
        {
            $user_group = ' and (`qag_qaug_id`=1 or `qag_qaug_id`=3)';
        }
        elseif($user_type == 'admin')
        {
            $user_group = ' and (`qag_qaug_id`=1 or `qag_qaug_id`=4)';
        }

        $sel_data = $this->db->query('SELECT `qa_id`, `qa_name`, `qag_qaug_id` 
            FROM `question_answer` 
            LEFT JOIN `q_a_groups` ON `qag_qa_id`=`qa_id`
            WHERE `qa_qas_id`=? and `qa_qass_id`=? and `qa_blocked`=0'.$user_group, array($section_id, $subsection_id));

        if($sel_data !== false and 0 < $sel_data->num_rows())
        {
            $i = 0;
            foreach($sel_data->result() as $row)
            {
                $result['articles'][$row->qa_id]['name'] = $row->qa_name;

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
     * Выборка данных общедоступной статьи
     *
     * @param $section_id
     * @param $subsection_id
     * @param $article_id
     * @param $user_type
     * @return array
     */
    public function getPublicQaArticle($section_id, $subsection_id, $article_id, $user_type)
    {
        $result = array();

        $user_group = ' and `qag_qaug_id`=1';
        if($user_type == 'user')
        {
            $user_group = ' and (`qag_qaug_id`=1 or `qag_qaug_id`=2)';
        }
        elseif($user_type == 'coach')
        {
            $user_group = ' and (`qag_qaug_id`=1 or `qag_qaug_id`=3)';
        }
        elseif($user_type == 'admin')
        {
            $user_group = ' and (`qag_qaug_id`=1 or `qag_qaug_id`=4)';
        }

        $sel_data = $this->db->query('SELECT `qa_id`, `qa_qas_id`, `qa_qass_id`, `qa_name`, `qa_text`, `qa_blocked`, `qa_update`, `qa_admin_id` 
            FROM `question_answer` 
            WHERE `qa_id`=? and `qa_qas_id`=? and `qa_qass_id`=? LIMIT 1', array($article_id, $section_id, $subsection_id));

        if($sel_data !== false and 1 == $sel_data->num_rows())
        {
            $row = $sel_data->row();

            $result['article'] = self::parseQaData($row);
        }
        elseif($sel_data === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Поиск по статьям
     *
     * @param $search
     * @param $user_type
     * @return bool
     */
    public function getPublicQaArticles($search, $user_type)
    {
        $result = false;

        $user_group = '`qag_qaug_id`=1';
        if($user_type == 'user')
        {
            $user_group = '(`qag_qaug_id`=1 or `qag_qaug_id`=2)';
        }
        elseif($user_type == 'coach')
        {
            $user_group = '(`qag_qaug_id`=1 or `qag_qaug_id`=3)';
        }
        elseif($user_type == 'admin')
        {
            $user_group = '(`qag_qaug_id`=1 or `qag_qaug_id`=4)';
        }

        $sel_data = $this->db->query('SELECT `qa_id`, `qa_name`, `qas_id`, `qas_name`, `qass_id`, `qass_name`, `qag_qaug_id` 
            FROM `question_answer` 
            LEFT JOIN `q_a_sections` ON `qas_id`=`qa_qas_id`
            LEFT JOIN `q_a_subsections` ON `qass_id`=`qa_qass_id`
            LEFT JOIN `q_a_groups` ON `qag_qa_id`=`qa_id`
            WHERE MATCH (`qa_name`, `qa_text`) AGAINST (? IN BOOLEAN MODE) and '.$user_group, $search);

        if($sel_data !== false and 0 < $sel_data->num_rows())
        {
            $i = 0;
            foreach($sel_data->result() as $row)
            {
                $result['search_qa_articles'][$row->qas_id]['name'] = $row->qas_name;
                $result['search_qa_articles'][$row->qas_id]['subsections'][$row->qass_id]['name'] = $row->qass_name;
                $result['search_qa_articles'][$row->qas_id]['subsections'][$row->qass_id]['articles'][$row->qa_id]['name'] = $row->qa_name;

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
     * Обработка данных статьи Вопрос - Ответ
     *
     * @param $row
     * @return array
     */
    protected function parseQaData($row)
    {
        $result = array();

        $result['id']            = $row->qa_id;
        $result['section_id']    = (!empty($row->qa_qas_id)) ? $row->qa_qas_id : null;
        $result['subsection_id'] = $row->qa_qass_id;
        $result['name']          = $row->qa_name;
        $result['text']          = (!empty($row->qa_text)) ? $row->qa_text : null;
        $result['blocked']       = $row->qa_blocked;
        $result['update']        = $row->qa_update;
        $result['admin_id']      = $row->qa_admin_id;
        $result['users_group']   = array();

        return $result;
    }

    /* КОНЕЦ БЛОКА ОБРАБОТКИ ДАННЫХ РАЗДЕЛА ВОПРОС - ОТВЕТ */

}