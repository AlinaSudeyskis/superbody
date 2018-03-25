<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Blog_model
 *
 * Класс для работы с записями, комментариями блога
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
        $ins_data = $this->db->query('
            INSERT INTO `couch_blog` (`cb_u_id`, `cb_post_title`, `cb_post_short_description`, `cb_post_text`, 
              `cb_post_date_add`, `cb_post_date_update`)
            VALUES (?, ?, ?, ?, ?, ?)', array($user_id, $title, $short_desc, $text, $date, $date));

        if ($ins_data !== false and 1 == $this->db->affected_rows())
        {
            return $this->db->insert_id();
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

        if ($sel_blog !== false and 0 < $sel_blog->num_rows())
        {
            $i = 0;
            foreach ($sel_blog->result() as $row)
            {
                $result['posts'][$i] = self::parseBlogPostData($row);

                $i++;
            }
            unset($row);
        }
        elseif ($sel_blog === false)
        {
            parent::logDbMessages(__METHOD__);
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

        if ($sel_blog !== false and 0 < $sel_blog->num_rows()) {
            $i = 0;
            foreach ($sel_blog->result() as $row) {
                $result['posts'][$i] = self::parseBlogPostData($row);
                $result['post']['user']['id']    = $row->cb_u_id;
                $result['post']['user']['name']  = !empty($row->user_name) ? $row->user_name : 'Пользователь №'.$row->cb_u_id;

                $i++;
            }
            unset($row);
        }
        elseif ($sel_blog === false)
        {
            parent::logDbMessages(__METHOD__);
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

        if ($sel_post !== false and 1 == $sel_post->num_rows())
        {
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

            if ($sel_comments !== false and 0 < $sel_comments->num_rows())
            {
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
            elseif ($sel_comments === false)
            {
                parent::logDbMessages(__METHOD__);
            }
        }
        elseif ($sel_post === false)
        {
            parent::logDbMessages(__METHOD__);
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
        $ins_data = $this->db->query('
            INSERT INTO `blog_comments` (`bc_u_id`, `bc_blog_id`, `bc_text`, `bc_date_add`, `bc_date_update`)
            VALUES (?, ?, ?, ?, ?)', array($user_id, $post_id, $comment, $date, $date));

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

        if ($sel_blog_mess !== false and 0 < $sel_blog_mess->num_rows())
        {
            $i = 0;
            foreach ($sel_blog_mess->result() as $row)
            {
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

            if ($sel_comments !== false and 0 < $sel_comments->num_rows())
            {
                $i = 0;
                foreach ($sel_comments->result() as $row)
                {
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
            elseif ($sel_comments === false)
            {
                parent::logDbMessages(__METHOD__);
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
        $up_data = $this->db->query('UPDATE `couch_blog` SET `cb_post_approval`=1, `cb_post_date_update`=? WHERE `cb_id`=? LIMIT 1',
            array($date, $post_id));

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
     * Блокировка записи блога
     *
     * @param $post_id
     * @param $date
     * @return bool
     */
    public function blockBlogPost($post_id, $date)
    {
        $up_data = $this->db->query('UPDATE `couch_blog` SET `cb_post_approval`=0, `cb_post_date_update`=? WHERE `cb_id`=? LIMIT 1',
            array($date, $post_id));

        if ($up_data !== false and 1 == $this->db->affected_rows()) {
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

        if ($sel_blog_comments !== false and 0 < $sel_blog_comments->num_rows())
        {
            $i = 0;
            foreach ($sel_blog_comments->result() as $row)
            {
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
        elseif($sel_blog_comments === false)
        {
            parent::logDbMessages(__METHOD__);
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

        if ($sel_message !== false and 1 == $sel_message->num_rows())
        {
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
            $message_date = ($row->bc_date_add != '0000-00-00 00:00:00' and $date !== false)
                ? strftime('%d %B %G, %H:%M', strtotime($row->bc_date_add))
                : '';

            $result['comment']['date'] = $message_date;
        }
        elseif($sel_message === false)
        {
            parent::logDbMessages(__METHOD__);
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
        $up_data = $this->db->query('UPDATE `blog_comments` SET `bc_approval`=1, `bc_date_update`=? WHERE `bc_id`=? LIMIT 1',
            array($date, $comment_id));

        if ($up_data !== false and 1 == $this->db->affected_rows()) {
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

    /**
     * Блокировка комментария блога
     *
     * @param $comment_id
     * @param $date
     * @return bool
     */
    public function blockComment($comment_id, $date)
    {
        $up_data = $this->db->query('UPDATE `blog_comments` SET `bc_approval`=0, `bc_date_update`=? WHERE `bc_id`=? LIMIT 1',
            array($date, $comment_id));

        if ($up_data !== false and 1 == $this->db->affected_rows()) {
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

    /* КОНЕЦ БЛОКА ОБРАБОТКАИ ДАННЫХ ЗАПИСЕЙ БЛОГОВ И КОММЕНТАРИЕВ АП */

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