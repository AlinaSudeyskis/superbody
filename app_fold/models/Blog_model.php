<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Blog_model
 *
 * Класс для работы с личными сообщениями, сообщениями блога, комментариями блога и обратной связью
 *
 * @author Alina Sudeyskis <alina.sudeyskis@gmail.com>
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Blog_model extends CI_Model
{
    /**
     * Сохранение сообщений блога тренера
     *
     * @param int $user_id
     * @param string $title
     * @param string $short_desc
     * @param string $text
     * @param string $date
     * @return bool|int
     */
    public function setBlogPost($user_id, $title, $short_desc, $text, $date)
    {
        $this->db->query('
            INSERT INTO `couch_blog` (`cb_u_id`, `cb_post_title`, `cb_post_short_description`, `cb_post_text`, 
              `cb_post_date_add`, `cb_post_date_update`)
            VALUES (?, ?, ?, ?, ?, ?)', array($user_id, $title, $short_desc, $text, $date, $date));

        if (1 == $this->db->affected_rows())
        {
            return $this->db->insert_id();
        }
        else
        {
            return false;
        }
    }

    /**
     * Получение записей блога тренера.
     *
     * Одобренные сообщения администрацией
     *
     * @param $user_id
     * @return array
     */
    public function getCouchBlogPosts($user_id)
    {
        $result = array();

        $sel_blog = $this->db->query('
            SELECT `cb_id`, `cb_u_id`, `cb_post_title`, `cb_post_short_description`, `cb_post_text`
            FROM `couch_blog` 
            WHERE `cb_u_id`=?', $user_id);

        if (0 < $sel_blog->num_rows())
        {
            $i = 0;
            foreach ($sel_blog->result() as $row)
            {
                $result['posts'][$i] = self::parseBlogPostData($row);

                $i++;
            }
            unset($row);
        }

        return $result;
    }

    /**
     * Выборка записи блога тренера
     * @param int $user_id ID тренера
     * @param int $post_id ID записи
     * @return array
     */
    public function getCouchBlogPost($user_id, $post_id)
    {
        $result = array('post' => array());

        $sel_post = $this->db->query('
            SELECT `cb_id`, `cb_u_id`, `cb_post_title`, `cb_post_short_description`, `cb_post_text`, `cb_post_approval` 
            FROM `couch_blog` 
            WHERE `cb_id`=? and `cb_u_id`=? LIMIT 1', array($post_id, $user_id));

        if ($sel_post !== false and 1 == $sel_post->num_rows())
        {
            $row = $sel_post->row();

            $result['post'] = self::parseBlogPostData($row);
            $result['post']['comments']   = array();

            // Выборка комментариев к записи блога тренера
            $sel_comments = $this->db->query('
                SELECT `bc_id`, `bc_text`, `bc_u_id`, `user_name`, `user_email`, `user_image`
                FROM `blog_comments`
                LEFT JOIN `users` 
                  ON `bc_u_id`=`user_id`
                WHERE `bc_blog_id`=? and `bc_approval`=1', $row->cb_id);

            if (0 < $sel_comments->num_rows()) {
                $i = 0;
                foreach ($sel_comments->result() as $row) {
                    $result['post']['comments'][$i]['id']      = $row->bc_id;
                    $result['post']['comments'][$i]['text']    = $row->bc_text;
                    $result['post']['comments'][$i]['u_id']    = $row->bc_u_id;
                    $result['post']['comments'][$i]['u_name']  = !empty($row->user_name) ? $row->user_name : $row->user_email;
                    $result['post']['comments'][$i]['u_image'] = !empty($row->user_image) ? mb_substr($row->user_image, 1) : '';

                    $i++;
                }
                unset($row);
            }
        }
        elseif($sel_post === false)
        {
            parent::logDbMessages(__METHOD__);
        }

        return $result;
    }

    /**
     * Сохранение изменений записи блога тренера
     *
     * @param $user_id
     * @param $post_id
     * @param $post_title
     * @param $post_desc
     * @param $post_text
     * @param $date
     * @return bool
     */
    public function updateCouchBlogPost($user_id, $post_id, $post_title, $post_desc, $post_text, $date)
    {
        $up_data = $this->db->query('
            UPDATE `couch_blog` 
            SET `cb_post_title`=?, `cb_post_short_description`=?, `cb_post_text`=?, `cb_post_date_update`=? 
            WHERE `cb_id`=? and `cb_u_id`=? and `cb_post_approval`=0 LIMIT 1',
                array($post_title, $post_desc, $post_text, $date, $post_id, $user_id));

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


    /**
     * Получение одобренных записей блога тренера.
     *
     * Одобренные сообщения администрацией
     *
     * @param $user_id
     * @return array
     */
    public function getPublicBlogPosts($user_id)
    {
        $result = array();

        $sel_blog = $this->db->query('
            SELECT `cb_id`, `cb_u_id`, `cb_post_title`, `cb_post_short_description`, `cb_post_text`, `user_name`, `user_email` 
            FROM `couch_blog` 
            LEFT JOIN `users`
            ON `cb_u_id`=`user_id`
            WHERE `cb_u_id`=? and `cb_post_approval`=1', $user_id);

        if (0 < $sel_blog->num_rows()) {
            $i = 0;
            foreach ($sel_blog->result() as $row) {
                $result['posts'][$i] = self::parseBlogPostData($row);
                $result['post']['user']['id']    = $row->cb_u_id;
                $result['post']['user']['name']  = !empty($row->user_name) ? $row->user_name : 'Пользователь №'.$row->cb_u_id;

                $i++;
            }
            unset($row);
        }

        return $result;
    }

    /**
     * Выборка одобренной записи блога тренера
     * @param int $post_id ID записи
     * @return array
     */
    public function getPublicBlogPost($post_id)
    {
        $result = array('post' => array());

        $sel_post = $this->db->query('
            SELECT `cb_id`, `cb_u_id`, `cb_post_title`, `cb_post_text`, `user_name`, `user_email` 
            FROM `couch_blog` 
            LEFT JOIN `users`
            ON `cb_u_id`=`user_id`
            WHERE `cb_id`=? and `cb_post_approval`=1 LIMIT 1', $post_id);

        if (1 == $sel_post->num_rows()) {
            $row = $sel_post->row();

            $result['post'] = self::parseBlogPostData($row);
            $result['post']['user']['id']    = $row->cb_u_id;
            $result['post']['user']['name']  = !empty($row->user_name) ? $row->user_name : 'Пользователь №'.$row->cb_u_id;
            $result['post']['comments']   = array();

            // Выборка комментариев к записи блога тренера
            $sel_comments = $this->db->query('
                SELECT `bc_id`, `bc_text`, `bc_u_id`, `user_name`, `user_email`, `user_image`
                FROM `blog_comments`
                LEFT JOIN `users` 
                  ON `bc_u_id`=`user_id`
                WHERE `bc_blog_id`=? and `bc_approval`=1', $row->cb_id);

            if (0 < $sel_comments->num_rows()) {
                $i = 0;
                foreach ($sel_comments->result() as $row) {
                    $result['post']['comments'][$i]['id']      = $row->bc_id;
                    $result['post']['comments'][$i]['text']    = $row->bc_text;
                    $result['post']['comments'][$i]['u_id']    = $row->bc_u_id;
                    $result['post']['comments'][$i]['u_name']  = !empty($row->user_name) ? $row->user_name : $row->user_email;
                    $result['post']['comments'][$i]['u_image'] = !empty($row->user_image) ? mb_substr($row->user_image, 1) : '';

                    $i++;
                }
                unset($row);
            }
        }

        return $result;
    }

    /**
     * Добавление комментария к записи блога тренера
     *
     * @param int $user_id ID пользователя отправившего комментарий
     * @param int $post_id ID записи блога
     * @param string $comment Текст комментария
     * @param string $date Текущая дата
     * @return bool
     */
    public function setBlogComment($user_id, $post_id, $comment, $date)
    {
        $this->db->query('
            INSERT INTO `blog_comments` (`bc_u_id`, `bc_blog_id`, `bc_text`, `bc_date_add`, `bc_date_update`)
            VALUES (?, ?, ?, ?, ?)', array($user_id, $post_id, $comment, $date, $date));

        if (1 == $this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }


    /* НАЧАЛО БЛОКА ОБРАБОТКАИ ДАННЫХ ЗАПИСЕЙ БЛОГОВ И КОММЕНТАРИЕВ АП */


    /**
     * Выборка записей блогов
     *
     * @return array
     */
    public function getBlogsPosts()
    {
        $result = array();
        
        $sel_blog_mess = $this->db->query('
            SELECT `cb_id`, `cb_u_id`, `cb_post_title`, `cb_post_short_description`, `cb_post_text`, `cb_post_approval`, 
              `cb_post_date_add`, `user_name`, `user_email` 
            FROM `couch_blog` 
            LEFT JOIN `users`
            ON `cb_u_id`=`user_id`');

        if ($sel_blog_mess !== false and 0 < $sel_blog_mess->num_rows()) {
            $i = 0;
            foreach ($sel_blog_mess->result() as $row) {
                $result['posts'][$i] = self::parseBlogPostData($row);
                $result['posts'][$i]['user_id']   = $row->cb_u_id;
                $result['posts'][$i]['user_name'] = !empty($row->user_name) ? $row->user_name : $row->user_email;
                
                $i++;
            }
            unset($row);
        }
        elseif($sel_blog_mess === false)
        {
            parent::logDbMessages(__METHOD__);
        }
        
        return $result;
    }

    /**
     * Получение данных записи блога
     *
     * @param $post_id
     * @return array
     */
    public function getBlogPost($post_id)
    {
        $result = array();

        $sel_message = $this->db->query('
            SELECT `cb_id`, `cb_u_id`, `cb_post_title`, `cb_post_short_description`, `cb_post_text`, `cb_post_approval`, 
              `cb_post_date_add`, `user_name`, `user_email` 
            FROM `couch_blog` 
            LEFT JOIN `users`
            ON `cb_u_id`=`user_id`
            WHERE `cb_id`=? LIMIT 1', $post_id);

        if ($sel_message !== false and 1 == $sel_message->num_rows())
        {
            $row = $sel_message->row();

            $result['post'] = self::parseBlogPostData($row);
            $result['post']['user_id']    = $row->cb_u_id;
            $result['post']['user_name']  = !empty($row->user_name) ? $row->user_name : $row->user_email;
            $result['post']['comments'] = array();

            $sel_comments = $this->db->query('
              SELECT `bc_id`, `bc_u_id`, `bc_text`, `bc_approval`, `bc_date_update`, 
                `user_name`, `user_email`, `user_image` 
              FROM `blog_comments`
              LEFT JOIN `users`
                ON `bc_u_id`=`user_id`
              WHERE `bc_blog_id`=?', $row->cb_id);

            if (0 < $sel_comments->num_rows()) {
                $i = 0;
                foreach ($sel_comments->result() as $row) {
                    $result['post']['comments'][$i]['id']         = $row->bc_id;
                    $result['post']['comments'][$i]['text']       = $row->bc_text;
                    $result['post']['comments'][$i]['approval']   = $row->bc_approval;
                    $result['post']['comments'][$i]['user_id']    = $row->bc_u_id;
                    $result['post']['comments'][$i]['user_name']  = !empty($row->user_name) ? $row->user_name : $row->user_email;
                    $result['post']['comments'][$i]['user_image'] = !empty($row->user_image) ? mb_substr($row->user_image, 1) : '';

                    $date = DateTime::createFromFormat('Y-m-d H:i:s', $row->bc_date_update);
                    $comment_date = ($row->bc_date_update != '0000-00-00 00:00:00' or $date !== false)
                        ? strftime('%d %B %G, %H:%M', strtotime($row->bc_date_update))
                        : '';

                    $result['post']['comments'][$i]['date'] = $comment_date;

                    $i++;
                }
                unset($row);
            }
        }
        elseif($sel_message === false)
        {
            parent::logDbMessages(__METHOD__);
        }

        return $result;
    }

    /**
     * Сохранение изменений записи блога
     *
     * @param $post_id
     * @param $post_title
     * @param $post_desc
     * @param $post_text
     * @param $date
     * @return bool
     */
    public function updateBlogPost($post_id, $post_title, $post_desc, $post_text, $date)
    {
        $up_data = $this->db->query('
            UPDATE `couch_blog` 
            SET `cb_post_title`=?, `cb_post_short_description`=?, `cb_post_text`=?, `cb_post_date_update`=? 
            WHERE `cb_id`=? LIMIT 1',
            array($post_title, $post_desc, $post_text, $date, $post_id));
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

    /**
     * Удаление записи блога
     *
     * @param $post_id
     * @return bool
     */
    /*public function deleteBlogPost($post_id)
    {
        $up_data = $this->db->query('DELETE FROM `couch_blog` WHERE `cb_id`=? LIMIT 1', $post_id);

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
    }*/

    /**
     * Одобрение записи блога
     *
     * @param $post_id
     * @param $date
     * @return bool
     */
    public function approvalBlogPost($post_id, $date)
    {
        $this->db->query('UPDATE `couch_blog` SET `cb_post_approval`=1, `cb_post_date_update`=? WHERE `cb_id`=? LIMIT 1',
            array($date, $post_id));

        if (1 == $this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Блокировка записи блога
     *
     * @param $post_id
     * @param $date
     * @return bool
     */
    public function blockBlogPost($post_id, $date)
    {
        $this->db->query('UPDATE `couch_blog` SET `cb_post_approval`=0, `cb_post_date_update`=? WHERE `cb_id`=? LIMIT 1',
            array($date, $post_id));

        if (1 == $this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }


    /**
     * Выборка комментариев блогов
     *
     * @return array
     */
    public function getBlogsComments()
    {
        $result = array();

        $sel_blog_comments = $this->db->query('
            SELECT `bc_id`, `bc_blog_id`, `bc_text`, `bc_approval`, `bc_date_add`, `bc_u_id`, 
              `user_name`, `user_email`, `user_image` 
            FROM `blog_comments` 
            LEFT JOIN `users`
              ON `bc_u_id`=`user_id`');

        if (0 < $sel_blog_comments->num_rows()) {
            $i = 0;
            foreach ($sel_blog_comments->result() as $row) {
                $result['comments'][$i]['id']         = $row->bc_id;
                $result['comments'][$i]['user_id']    = $row->bc_u_id;
                $result['comments'][$i]['user_name']  = !empty($row->user_name) ? $row->user_name : $row->user_email;
                $result['comments'][$i]['user_image'] = !empty($row->user_image) ? mb_substr($row->user_image, 1) : '';
                $result['comments'][$i]['blog_id']    = $row->bc_blog_id;
                $result['comments'][$i]['text']       = $row->bc_text;
                $result['comments'][$i]['approval']   = $row->bc_approval;

                setlocale(LC_ALL, 'ru_RU.UTF-8');
                $date = DateTime::createFromFormat('Y-m-d H:i:s', $row->bc_date_add);
                $message_date = ($row->bc_date_add != '0000-00-00 00:00:00' or $date !== false)
                    ? strftime('%d %B %G, %H:%M', strtotime($row->bc_date_add))
                    : '';

                $result['comments'][$i]['date'] = $message_date;

                $i++;
            }
            unset($row);
        }

        return $result;
    }

    /**
     * Получение данных сообщения блога
     *
     * @param $comment_id
     * @return array
     */
    public function getBlogComment($comment_id)
    {
        $result = array();

        $sel_message = $this->db->query('
            SELECT `bc_id`, `bc_blog_id`, `bc_text`, `bc_approval`, `bc_date_add`, `bc_u_id`, 
              `user_name`, `user_email`, `user_image` 
            FROM `blog_comments` 
            LEFT JOIN `users`
            ON `bc_u_id`=`user_id`
            WHERE `bc_id`=? LIMIT 1', $comment_id);

        if (1 == $sel_message->num_rows()) {
            $row = $sel_message->row();

            $result['comment']['id']         = $row->bc_id;
            $result['comment']['blog_id']    = $row->bc_blog_id;
            $result['comment']['user_id']    = $row->bc_u_id;
            $result['comment']['user_name']  = !empty($row->user_name) ? $row->user_name : $row->user_email;
            $result['comment']['user_image'] = !empty($row->user_image) ? mb_substr($row->user_image, 1) : '';
            $result['comment']['text']       = $row->bc_text;
            $result['comment']['approval']   = $row->bc_approval;

            setlocale(LC_ALL, 'ru_RU.UTF-8');
            $date = DateTime::createFromFormat('Y-m-d H:i:s', $row->bc_date_add);
            $message_date = ($row->bc_date_add != '0000-00-00 00:00:00' or $date !== false)
                ? strftime('%d %B %G, %H:%M', strtotime($row->bc_date_add))
                : '';

            $result['comment']['date'] = $message_date;
        }

        return $result;
    }

    /**
     * Одобрение комментария блога
     *
     * @param $comment_id
     * @param $date
     * @return bool
     */
    public function approvalComment($comment_id, $date)
    {
        $this->db->query('UPDATE `blog_comments` SET `bc_approval`=1, `bc_date_update`=? WHERE `bc_id`=? LIMIT 1',
            array($date, $comment_id));

        if (1 == $this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Блокировка комментария блога
     *
     * @param $comment_id
     * @param $date
     * @return bool
     */
    public function blockComment($comment_id, $date)
    {
        $this->db->query('UPDATE `blog_comments` SET `bc_approval`=0, `bc_date_update`=? WHERE `bc_id`=? LIMIT 1',
            array($date, $comment_id));

        if (1 == $this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }


    /* НАЧАЛО БЛОКА ОБРАБОТКАИ ДАННЫХ ЗАПИСЕЙ БЛОГОВ И КОММЕНТАРИЕВ АП */



    /**
     * Выборка списка последних диалогов пользователя
     *
     * @param $user_id
     * @return array
     */
    public function getUserConversations($user_id)
    {
        $result = array();

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

        if (0 < $sel_mess->num_rows()) {
            $i = 0;
            foreach ($sel_mess->result() as $row) {
                if ($user_id == $row->um_from) {
                    $result['user_conversations'][$i]['user_with']['id'] = $row->um_whom;
                } else {
                    $result['user_conversations'][$i]['user_with']['id'] = $row->um_from;
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

                if (empty($result['user_conversations'][$i]['total_new'])) {
                    $result['user_conversations'][$i]['total_new'] = ($row->um_whom == $user_id) ? $row->um_new : 0;
                }
                else {
                    $result['user_conversations'][$i]['total_new'] += ($row->um_whom == $user_id) ? $row->um_new : 0;
                }

                $i++;
            }
            unset($row);
            $sel_mess->free_result();
        }

        return $result;
    }

    /**
     * Выборка сообщений диалога с пользователем
     *
     * @param int $user_id ID пользователя
     * @param int $user_with ID пользователя с кем идет переписка
     * @param string $this_date Текущая дата
     * @return array
     */
    public function getUserMessages($user_id, $user_with, $date)
    {
        $result = array();

        // ID диалога
        $result['conv_id'] = self::getConversationId($user_id, $user_with);

        // Данные пользователя с кем ведется диалог
        $result['conv_with']['name'] = '';
        $sel_user_with = $this->db->query('
            SELECT `user_name`, `user_email`, `user_image` 
            FROM `users`
            WHERE `user_id`=? LIMIT 1', $user_with);

        if (1 == $sel_user_with->num_rows()) {
            $row = $sel_user_with->row();

            $result['conv_with']['name'] = !empty($row->user_name) ? $row->user_name : $row->user_email;
        }
        unset($row);
        $sel_user_with->free_result();

        $sel_mess = $this->db->query('
            SELECT `um_from`, `um_whom`, `um_text`, `um_date`, `um_new`, `user_name`, `user_email`, `user_image` 
            FROM `users_messages` 
            LEFT JOIN `users`
              ON `um_from`=`user_id`
            WHERE `um_conv_id`=? and `um_blocked`=0', $result['conv_id']);

        if (0 < $sel_mess->num_rows()) {
            $i = 0;
            foreach ($sel_mess->result() as $row) {

                $result['user_messages'][$i]['user_from']['id']    = $row->um_from;
                $result['user_messages'][$i]['user_from']['name']  = !empty($row->user_name) ? $row->user_name : $row->user_email;
                $result['user_messages'][$i]['user_from']['image'] = mb_substr($row->user_image, 1);

                $result['user_messages'][$i]['text'] = $row->um_text;

                setlocale(LC_ALL, 'ru_RU.UTF-8');
                $tmp_date = DateTime::createFromFormat('Y-m-d H:i:s', $row->um_date);
                $message_date = ($row->um_date != '0000-00-00 00:00:00' or $tmp_date !== false)
                    ? $tmp_date->format('d.m.Y')
                    : '';
                $message_time = ($row->um_date != '0000-00-00 00:00:00' or $tmp_date !== false)
                    ? $tmp_date->format('H:i')
                    : '';
                $tmp_date = DateTime::createFromFormat('Y-m-d H:i:s', $date);
                $fl_date = ($tmp_date !== false and $tmp_date->format('d.m.Y') == $message_date) ? 1 : 0;

                $result['user_messages'][$i]['date']    = $message_date;
                $result['user_messages'][$i]['time']    = $message_time;
                $result['user_messages'][$i]['fl_date'] = $fl_date;
                $result['user_messages'][$i]['new']     = $row->um_new;

                $i++;
            }
            unset($row);
        }

        return $result;
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
            SELECT `um_conv_id` 
            FROM `users_messages`
            WHERE (`um_from`=? and `um_whom`=?) or (`um_from`=? and `um_whom`=?) 
            LIMIT 1', array($user_id, $user_with, $user_with, $user_id));

        if (1 == $sel_mess->num_rows()) {
            $row = $sel_mess->row();

            $result = $row->um_conv_id;

            unset($row);
            $sel_mess->free_result();
        }

        return $result;
    }

    /**
     * Сохранение сообщения пользователя
     *
     * @param int $user_id ID пользователя
     * @param int $user_with ID пользователя с кем идет беседа
     * @param int $conv_id ID диалога
     * @param string $message_text Текст сообщения
     * @param $date
     * @return bool
     */
    public function setUserMessage($user_id, $user_with, $conv_id, $message_text, $date)
    {
        if (empty($conv_id)) {
            $sel_last_conv = $this->db->query('
                SELECT `um_conv_id`
                FROM `users_messages`
                ORDER BY `um_conv_id` DESC
                LIMIT 1');
            if (1 == $sel_last_conv->num_rows()) {
                $row = $sel_last_conv->row();
                $conv_id = $row->um_conv_id + 1;
            } else {
                $conv_id = 1;
            }
        }

        $this->db->query('
            INSERT INTO `users_messages` (`um_from`, `um_whom`, `um_conv_id`, `um_text`, `um_date`) 
            VALUES (?, ?, ?, ?, ?)', array($user_id, $user_with, $conv_id, $message_text, $date));

        if (1 == $this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
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
            LEFT JOIN `users`
              ON `um_from`=`user_id`
            ORDER BY `um_date` DESC');

        if (0 < $sel_messages->num_rows()) {
            $i = 0;
            foreach ($sel_messages->result() as $row) {
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

        if (1 == $sel_message->num_rows()) {
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
        $this->db->query('UPDATE `users_messages` SET `um_blocked`=0 WHERE `um_id`=? LIMIT 1',
            $message_id);

        if (1 == $this->db->affected_rows()) {
            return true;
        } else {
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
        $this->db->query('UPDATE `users_messages` SET `um_blocked`=1 WHERE `um_id`=? LIMIT 1',
            $message_id);

        if (1 == $this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Сохранение сообщения обратной связи
     *
     * @param string $user_name Имя пользователя
     * @param string $user_email E-mail пользователя
     * @param string $message_text Текст сообщения
     * @param $date
     * @return bool
     */
    public function setFeedbackMessage($user_name, $user_email, $message_text, $date)
    {
        $this->db->query('
            INSERT INTO `feedback` (`fb_user_name`, `fb_user_email`, `fb_text`, `fb_date_add`) 
            VALUES (?, ?, ?, ?)', array($user_name, $user_email, $message_text, $date));
        
        if (1 == $this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Список диалогов с пользователями обратной связи (сгруппированно по e-mail пользователей)
     *
     * @return array
     */
    public function getFeedbackMessages()
    {
        $result = array();
        $sel_messages = $this->db->query('
            SELECT `t_fb`.`fb_conv_id`, `t_fb`.`fb_user_name`, `t_fb`.`fb_user_email`, `t_fb`.`fb_text`, `t_fb`.`fb_date_add`, 
              `t_fb`.`fb_conv_id`, `t_fb`.`fb_admin_id`, `t_fb`.`fb_new`, `t_fb`.`fb_blocked`, `t_new`.`count_new`
            FROM `feedback` as `t_fb`
            LEFT JOIN 
              (SELECT COUNT(`fb_new`) as `count_new`, `fb_conv_id` FROM `feedback` WHERE `fb_admin_id`=0 GROUP BY `fb_conv_id`) as `t_new`
              ON `t_fb`.`fb_conv_id` = `t_new`.`fb_conv_id`
            WHERE `t_fb`.`fb_date_add` IN 
                (SELECT max(`fb_date_add`) FROM `feedback` GROUP BY `fb_conv_id`)
            ORDER BY `t_fb`.`fb_date_add` DESC');
        
        if (0 < $sel_messages->num_rows()) {
            $i = 0;
            foreach ($sel_messages->result() as $row) {
                $result['fb_messages'][$i]['user_email']  = $row->fb_user_email;
                $result['fb_messages'][$i]['user_name']   = $row->fb_user_name;

                $result['fb_messages'][$i]['text'] = $row->fb_text;

                setlocale(LC_ALL, 'ru_RU.UTF-8');
                $date = DateTime::createFromFormat('Y-m-d H:i:s', $row->fb_date_add);
                $message_date = ($row->fb_date_add != '0000-00-00 00:00:00' or $date !== false)
                    ? $date->format('d.m.Y')
                    : '';
                $message_time = ($row->fb_date_add != '0000-00-00 00:00:00' or $date !== false)
                    ? $date->format('H:i')
                    : '';

                $result['fb_messages'][$i]['date'] = $message_date;
                $result['fb_messages'][$i]['time'] = $message_time;
                $result['fb_messages'][$i]['new']  = $row->fb_new;

                $result['fb_messages'][$i]['total_new'] = parent::endingWords($row->count_new, 'сообщение', 'сообщений', 'сообщения');


                $i++;
            }
            unset($row);
        }
        
        return $result;
    }

    /**
     * Сообщения диалога обратной связи с пользователем 
     *
     * @param string $user_email E-mail пользователя 
     * @param string $date Текущая дата
     * @return array
     */
    public function getFeedbackUserMessages($user_email, $date = null)
    {
        $result = array('fb_user_messages' => array(), 'fb_conv_id' => '', 'fb_total_new' => 0);

        $total_new = 0;

        $sel_messages = $this->db->query('
            SELECT `fb_conv_id`, `fb_user_name`, `fb_user_email`, `fb_text`, `fb_date_add`, `fb_admin_id`, `fb_new`, 
              `user_name`, `user_email`
            FROM `feedback`
            LEFT JOIN `users`
              ON `fb_admin_id`=`user_id`
            WHERE `fb_user_email`=?', $user_email);

        if (0 < $sel_messages->num_rows()) {
            $i = 0;
            foreach ($sel_messages->result() as $row) {
                $result['fb_conv_id'] = $row->fb_conv_id;
                $result['fb_user_messages'][$i]['admin_id'] = $row->fb_admin_id;

                if (!empty($row->fb_admin_id == 0)) {
                    $result['fb_user_messages'][$i]['user_email'] = $row->fb_user_email;
                    $result['fb_user_messages'][$i]['user_name']  = !empty($row->fb_user_name) ? $row->fb_user_name : '';
                } else {
                    $result['fb_user_messages'][$i]['user_name'] = !empty($row->user_name) ? $row->user_name : $row->user_email;
                }
                
                $result['fb_user_messages'][$i]['text'] = $row->fb_text;

                setlocale(LC_ALL, 'ru_RU.UTF-8');
                $tmp_date = DateTime::createFromFormat('Y-m-d H:i:s', $row->fb_date_add);
                $message_date = ($row->fb_date_add != '0000-00-00 00:00:00' or $tmp_date !== false)
                    ? $tmp_date->format('d.m.Y')
                    : '';
                $message_time = ($row->fb_date_add != '0000-00-00 00:00:00' or $tmp_date !== false)
                    ? $tmp_date->format('H:i')
                    : '';
                $tmp_date = DateTime::createFromFormat('Y-m-d H:i:s', $date);
                $fl_date = ($tmp_date !== false and $tmp_date->format('d.m.Y') == $message_date) ? 1 : 0;

                $result['fb_user_messages'][$i]['date']    = $message_date;
                $result['fb_user_messages'][$i]['time']    = $message_time;
                $result['fb_user_messages'][$i]['fl_date'] = $fl_date;
                $result['fb_user_messages'][$i]['new']     = $row->fb_new;

                $total_new += $row->fb_admin_id > 0 ? $row->fb_new : 0;

                $i++;
            }
            unset($row);

            $result['fb_total_new'] = $total_new;
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

        $sel_conv_id = $this->db->query('
            SELECT `fb_conv_id`
            FROM `feedback`
            WHERE `fb_user_email`=? and `fb_conv_id`<>0
            GROUP BY `fb_conv_id`
            ORDER BY `fb_conv_id` DESC', $user_email);

        if (0 < $sel_conv_id->num_rows()) {
            $i = 0;
            foreach ($sel_conv_id->result() as $row) {
                $result['conv_id'][$i] = $row->fb_conv_id;

                $i++;
            }
            unset($row);
        }

        return $result;
    }

    /**
     * Сохранение ответа администрации на письмо пользователя
     *
     * @param int $admin_id ID администратора
     * @param string $user_email E-mail пользователя
     * @param string $message_text Текст сообщения
     * @param int|null $conv_id ID диалога
     * @param int $new_conv Идентификатор начала нового диалога с пользователем 
     * @param $date
     * @return bool|int
     */
    public function setFeedbackAnswer($admin_id, $user_email, $message_text, $conv_id, $date)
    {
        if (empty($conv_id)) {
            $sel_fb_user = $this->db->query('
                SELECT `fb_conv_id` FROM `feedback` WHERE `fb_user_email`=? LIMIT 1', $user_email);

            if (1 == $sel_fb_user->num_rows()) {
                $row = $sel_fb_user->row();

                $conv_id = $row->fb_conv_id; // Номер диалога с польователем
            }
            else {
                $sel_last_conv_id = $this->db->query('
                  SELECT `fb_conv_id` FROM `feedback` ORDER BY `fb_conv_id` DESC LIMIT 1');

                if (1 == $sel_last_conv_id->num_rows()) {
                    $row = $sel_last_conv_id->row();

                    $conv_id = $row->fb_conv_id + 1; // Новый номер диалога
                } else {
                    $conv_id = 0;
                }

            }
        }

        if (!empty($conv_id)) {
            $this->db->query('
            INSERT INTO `feedback` (`fb_conv_id`, `fb_admin_id`, `fb_user_email`, `fb_text`, `fb_date_add`) 
            VALUES (?, ?, ?, ?, ?)', array($conv_id, $admin_id, $user_email, $message_text, $date));

            if (1 == $this->db->affected_rows()) {
                return true;
            } else {
                return false;
            }
        }
        else {
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

        if (0 < $sel_messages->num_rows()) {
            $i = 0;
            foreach ($sel_messages->result() as $row) {
                $result['fb_user_messages'][$i]['conv_id']    = $row->fb_conv_id;
                
                if (!empty($row->fb_user_name)) {
                    $result['fb_user_messages'][$i]['user_email'] = $row->fb_user_email;
                    $result['fb_user_messages'][$i]['user_name']  = $row->fb_user_name;
                } else {
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

        return $result;
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
        
        $sel_num_new = $this->db->query('
            SELECT COUNT(`um_id`) as `count_new` FROM `users_messages` WHERE `um_whom`=? and `um_new`=1', $user_id);
        
        if ($sel_num_new !== false and 1 == $sel_num_new->num_rows()) {
            $row = $sel_num_new->row();            
            $result = $row->count_new;
            unset($row);
        }
        elseif ($sel_num_new === false)
        {
            parent::logDbMessages(__METHOD__);
        }
        
        return $result;
    }

    /**
     * Кол-во новых сообщений обратной связи пользователя
     *
     * @param $user_email
     * @return int
     */
    public function getCountNewFeedbackMessages($user_email)
    {
        $result = 0;

        if (!empty($user_email)) {
            $sel_num_new = $this->db->query('
                SELECT COUNT(`fb_id`) as `count_new` 
                FROM `feedback` 
                WHERE `fb_user_email`=? and `fb_new`=1 and `fb_admin_id`>0', $user_email);

            if (1 == $sel_num_new->num_rows()) {
                $row = $sel_num_new->row();
                $result = $row->count_new;
                unset($row);
            }
        }


        return $result;
    }

    /**
     * Обновления статусов сообщений как прочитанные в диалоге
     *
     * @param $user_id
     * @param $user_with
     * @param $user_email
     * @return bool|int
     */
    public function updateReadingStatus($user_id, $user_with, $user_email)
    {
        $this->db->query('
          UPDATE `users_messages` SET `um_new`=0 WHERE `um_whom`=? and `um_from`=? and `um_new`=1', array($user_id, $user_with));

        if (0 < $this->db->affected_rows()) {
            $new_messages    = $this->getCountNewMessages($user_id);
            $new_fb_messages = $this->getCountNewFeedbackMessages($user_email);

            $count_new_messages = $new_messages + $new_fb_messages;

            return $count_new_messages;
        } else {
            return false;
        }
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
        $this->db->query('
          UPDATE `feedback` SET `fb_new`=0 WHERE `fb_user_email`=? and `fb_new`=1 and `fb_admin_id`>0', $user_email);

        if (0 < $this->db->affected_rows()) {
            $new_messages    = $this->getCountNewMessages($user_id);
            $new_fb_messages = $this->getCountNewFeedbackMessages($user_email);

            $count_new_messages = $new_messages + $new_fb_messages;

            return $count_new_messages;
        } else {
            return false;
        }
    }

    /* НАЧАЛО БЛОКА ФУНКЦИЙ ОБРАБОТКИ ДАННЫХ */

    /**
     * Обработка данных записи блога
     *
     * @param $row
     * @return array
     */
    protected function parseBlogPostData($row)
    {
        $result = array();

        $result['id']         = $row->cb_id;
        $result['title']      = !empty($row->cb_post_title) ? $row->cb_post_title : null;
        $result['short_desc'] = !empty($row->cb_post_short_description) ? $row->cb_post_short_description : null;
        $result['text']       = !empty($row->cb_post_text) ? $row->cb_post_text : null;
        $result['approval']   = !empty($row->cb_post_approval) ? $row->cb_post_approval : null;

        if (!empty($row->cb_post_date_add))
        {
            setlocale(LC_ALL, 'ru_RU.UTF-8');
            $date = DateTime::createFromFormat('Y-m-d H:i:s', $row->cb_post_date_add);
            $message_date = ($row->cb_post_date_add != '0000-00-00 00:00:00' or $date !== false)
                ? strftime('%d %B %G, %H:%M', strtotime($row->cb_post_date_add))
                : '';

            $result['date'] = $message_date;
            $result['date_add'] = $message_date;

        }

        if (!empty($row->cb_post_date_update))
        {
            setlocale(LC_ALL, 'ru_RU.UTF-8');
            $date = DateTime::createFromFormat('Y-m-d H:i:s', $row->cb_post_date_update);
            $message_date = ($row->cb_post_date_update != '0000-00-00 00:00:00' or $date !== false)
                ? strftime('%d %B %G, %H:%M', strtotime($row->cb_post_date_update))
                : '';

            $result['date_update'] = $message_date;
        }

        return $result;
    }

    /* КОНЕЦ БЛОКА ФУНКЦИЙ ОБРАБОТКИ ДАННЫХ */
}