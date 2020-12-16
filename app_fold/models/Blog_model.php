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
     * @param $post_category_id
     * @param int $user_id
     * @param $post_poster_type
     * @param $post_poster
     * @param $post_video_type
     * @param $post_video
     * @param string $title
     * @param string $short_desc
     * @param $keywords
     * @param string $text
     * @param $delete_courses
     * @param $insert_courses
     * @param string $date
     * @return bool|int
     */
    public function setBlogPost($post_category_id, $user_id, $post_poster_type, $post_poster,
                    $post_video_type, $post_video, $title, $short_desc, $keywords, $text, $delete_courses, $insert_courses, $date)
    {
        $result = false;

        $ins_data = $this->db->query('
            INSERT INTO `coach_blog` (`cb_bc_id`, `cb_u_id`, `cb_poster_type`, `cb_poster`, `cb_post_title`, `cb_post_short_description`, 
                                      `cb_post_keywords`, `cb_post_video_type`, `cb_post_video_url`, `cb_post_text`,
                                      `cb_post_date_add`, `cb_post_date_update`)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', array($post_category_id, $user_id, $post_poster_type, $post_poster,
                $title, $short_desc, $keywords, $post_video_type, $post_video, $text, $date, $date));

        if ($ins_data !== false and 1 == $this->db->affected_rows())
        {
            $result = $this->db->insert_id();

            self::updateBlogPostCourses($result, $delete_courses, $insert_courses, $date);
        }
        elseif ($ins_data === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Получение записей блога тренера.
     *
     * Одобренные сообщения администрацией
     *
     * @param $user_id
     * @return array
     * @throws Exception
     */
    public function getCoachBlogPosts($user_id)
    {
        $result = array();

        $sel_blog = $this->db->query('
            SELECT `cb_id`, `cb_u_id`, `cb_poster_type`, `cb_poster`, `cb_post_title`, `cb_post_short_description`, `cb_post_keywords`, `cb_post_text`, `cb_post_date_add` 
            FROM `coach_blog` 
            WHERE `cb_u_id`=? ORDER BY `cb_post_date_add` DESC', $user_id);

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
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Выборка записи блога тренера
     * @param int $user_id ID тренера
     * @param int $post_id ID записи
     * @return array
     * @throws Exception
     */
    public function getCoachBlogPost($user_id, $post_id)
    {
        $result = array('post' => array());

        $sel_post = $this->db->query('
            SELECT `cb_id`, `cb_bc_id`, `cb_u_id`, `cb_poster_type`, `cb_poster`, `cb_post_title`, `cb_post_short_description`, 
                   `cb_post_keywords`, `cb_post_video_type`, `cb_post_video_url`, `cb_post_text`, `cb_post_approval`, `cb_post_date_add` 
            FROM `coach_blog`  
            WHERE `cb_id`=? and `cb_u_id`=? LIMIT 1', array($post_id, $user_id));

        if ($sel_post !== false and 1 == $sel_post->num_rows())
        {
            $row = $sel_post->row();

            $result['post'] = self::parseBlogPostData($row);

            $attached_courses = self::getBlogPostAttachedCourses($post_id);
            $result['post']['attached_courses_id'] = $attached_courses['attached_courses_id'];
            $result['post']['attached_courses'] = $attached_courses['attached_courses'];

            $comments = self::getBlogPostComments($post_id);
            $result['post']['comments'] = $comments['comments'];
        }
        elseif($sel_post === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
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
     * @param $post_keywords
     * @param $post_text
     * @param $date
     * @return bool
     */
    public function updateCoachBlogPost($user_id, $post_id, $post_title, $post_desc, $post_keywords, $post_text, $date)
    {
        $up_data = $this->db->query('
            UPDATE `coach_blog` 
            SET `cb_post_title`=?, `cb_post_short_description`=?, `cb_post_keywords`=?, `cb_post_text`=?, `cb_post_date_update`=? 
            WHERE `cb_id`=? and `cb_u_id`=? and `cb_post_approval`=0 LIMIT 1',
                array($post_title, $post_desc, $post_keywords, $post_text, $date, $post_id, $user_id));

        if ($up_data !== false and 1 == $this->db->affected_rows())
        {
            return true;
        }
        elseif ($up_data === false)
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
     * Получение одобренных записей блога.
     *
     * @param null $category_id
     * @param null $search
     * @param null $first_id
     * @param null $last_id
     * @return array
     * @throws Exception
     */
    public function getPublicBlogPosts($category_id = null, $search = null, $first_id = null, $last_id = null)
    {
        $result    = array('posts' => array(), 'first_id' => '', 'last_id' => '');
        $next_page = false;
        $prev_page = false;
        $limit     = 9; // (count_posts + 1)

        $query = 'SELECT `cb_id`, `cb_u_id`, `cb_bc_id`, `cb_poster_type`, `cb_poster`, `cb_post_title`, `cb_post_short_description`, 
            `cb_post_keywords`, `cb_post_date_add`, `user_name`, `user_email` ';
        $query .= 'FROM `coach_blog` ';
        $query .= 'LEFT JOIN `users` ON `cb_u_id`=`user_id` ';
        $query .= 'WHERE `cb_post_approval`=1 ';
        $query .= (is_numeric($category_id)) ? 'and `cb_bc_id`='.$category_id.' ' : '';
        $query .= (!empty($search)) ? 'and MATCH (`cb_post_title`, `cb_post_short_description`, `cb_post_text`) AGAINST ("+'.$search.'*" IN BOOLEAN MODE) ' : '';
        if(!empty($last_id))
        {
            $query .= "and `cb_id`<".$last_id.' ';
        }
        elseif(!empty($first_id))
        {
            $query .= "and `cb_id`>".$first_id.' ';
        }
        $query .= 'ORDER BY `cb_post_date_add` DESC ';
        $query .= (is_numeric($category_id)) ? 'LIMIT '.$limit : '';
        $sel_blog = $this->db->query($query);

        if ($sel_blog !== false and 0 < $sel_blog->num_rows())
        {
            $elements = $sel_blog->result();

            // Данные пагинации
            $pagination = parent::parsePagination('blog', $first_id, $last_id, $limit, $elements);
            $result['pagination'] = $pagination['pagination'];

            $elements = $pagination['elements'];
            $i = 0;
            foreach ($elements as $key => $row)
            {
                $result['posts'][$row->cb_bc_id][$i] = self::parseBlogPostData($row);
                $result['posts'][$row->cb_bc_id][$i]['user']['id']    = $row->cb_u_id;
                $result['posts'][$row->cb_bc_id][$i]['user']['name']  = !empty($row->user_name) ? $row->user_name : 'Тренер №'.$row->cb_u_id;

                $i++;
            }
            unset($row);
        }
        elseif ($sel_blog === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Получение одобренных записей блога тренера.
     *
     * Одобренные сообщения администрацией
     *
     * @param $user_id
     * @return array
     * @throws Exception
     */
    public function getPublicCoachBlogPosts($user_id)
    {
        $result = array();

        $sel_blog = $this->db->query('
            SELECT `cb_id`, `cb_u_id`, `cb_poster_type`, `cb_poster`, `cb_post_title`, `cb_post_short_description`, `cb_post_keywords`, `cb_post_text`, `cb_post_date_add`, `user_name`, `user_email` 
            FROM `coach_blog` 
            LEFT JOIN `users` ON `cb_u_id`=`user_id`
            WHERE `cb_u_id`=? and `cb_post_approval`=1 ORDER BY `cb_post_date_add` DESC', $user_id);

        if ($sel_blog !== false and 0 < $sel_blog->num_rows())
        {
            $i = 0;
            foreach ($sel_blog->result() as $row)
            {
                $result['posts'][$i] = self::parseBlogPostData($row);
                $result['post']['user']['id']   = $row->cb_u_id;
                $result['post']['user']['name'] = !empty($row->user_name) ? $row->user_name : 'Тренер №'.$row->cb_u_id;

                $i++;
            }
            unset($row);
        }
        elseif ($sel_blog === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Выборка одобренной записи блога тренера
     *
     * @param int $post_id ID записи
     * @return array
     * @throws Exception
     */
    public function getPublicBlogPost($post_id)
    {
        $result = array('post' => array());

        $sel_post = $this->db->query('
            SELECT `cb_id`, `cb_u_id`, `cb_poster_type`, `cb_poster`, `cb_post_video_type`, `cb_post_video_url`, `cb_post_title`, `cb_post_short_description`, 
                   `cb_post_keywords`, `cb_post_text`, `user_name`, `user_email` 
            FROM `coach_blog` 
            LEFT JOIN `users`
            ON `cb_u_id`=`user_id`
            WHERE `cb_id`=? and `cb_post_approval`=1 LIMIT 1', $post_id);

        if ($sel_post !== false and 1 == $sel_post->num_rows())
        {
            $row = $sel_post->row();

            $result['post'] = self::parseBlogPostData($row);
            $result['post']['user']['id']    = $row->cb_u_id;
            $result['post']['user']['name']  = (!empty($row->user_name)) ? $row->user_name : 'Автор';

            $attached_courses = self::getBlogPostAttachedCourses($post_id);
            $result['post']['attached_courses'] = $attached_courses['attached_courses_id'];

            $comments = self::getBlogPostComments($post_id);
            $result['post']['comments'] = $comments['comments'];
        }
        elseif ($sel_post === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
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
            parent::logDbMessages(__METHOD__.':'.__LINE__);
            return false;
        }
        else
        {
            return false;
        }
    }


    /* НАЧАЛО БЛОКА ОБРАБОТКАИ ДАННЫХ ЗАПИСЕЙ БЛОГОВ, КОММЕНТАРИЕВ И КАТЕГОРИЙ АП */


    /**
     * Выборка записей блогов
     *
     * @return array
     * @throws Exception
     */
    public function getBlogsPosts()
    {
        $result = array();
        
        $sel_blog_mess = $this->db->query('
            SELECT `cb_id`, `cb_u_id`, `cb_poster_type`, `cb_poster`, `cb_post_title`, `cb_post_short_description`, `cb_post_keywords`, `cb_post_text`, `cb_post_approval`, 
              `cb_post_date_add`, `user_name`, `user_email` 
            FROM `coach_blog` 
            LEFT JOIN `users` ON `cb_u_id`=`user_id`
            ORDER BY `cb_post_date_add` DESC');

        if ($sel_blog_mess !== false and 0 < $sel_blog_mess->num_rows())
        {
            $i = 0;
            foreach ($sel_blog_mess->result() as $row)
            {
                $result['posts'][$i] = self::parseBlogPostData($row);
                $result['posts'][$i]['user']['id']   = $row->cb_u_id;
                $result['posts'][$i]['user']['name'] = !empty($row->user_name) ? $row->user_name : $row->user_email;
                
                $i++;
            }
            unset($row);
        }
        elseif($sel_blog_mess === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }
        
        return $result;
    }

    /**
     * Получение данных записи блога
     *
     * @param $post_id
     * @return array
     * @throws Exception
     */
    public function getBlogPost($post_id)
    {
        $result = array();

        $sel_message = $this->db->query('
            SELECT `cb_id`, `cb_bc_id`, `cb_u_id`, `cb_poster_type`, `cb_poster`, `cb_post_title`, `cb_post_short_description`, 
                   `cb_post_keywords`, `cb_post_video_type`, `cb_post_video_url`, `cb_post_text`, `cb_post_approval`, `cb_post_date_add`, `user_name`, `user_email` 
            FROM `coach_blog` 
            LEFT JOIN `users`
            ON `cb_u_id`=`user_id`
            WHERE `cb_id`=? LIMIT 1', $post_id);

        if ($sel_message !== false and 1 == $sel_message->num_rows())
        {
            $row = $sel_message->row();

            $result['post'] = self::parseBlogPostData($row);
            $result['post']['user_id']   = $row->cb_u_id;
            $result['post']['user_name'] = !empty($row->user_name) ? $row->user_name : $row->user_email;

            $attached_courses = self::getBlogPostAttachedCourses($post_id);
            $result['post']['attached_courses_id'] = $attached_courses['attached_courses_id'];
            $result['post']['attached_courses'] = $attached_courses['attached_courses'];

            $comments = self::getBlogPostComments($post_id);
            $result['post']['comments'] = $comments['comments'];
        }
        elseif($sel_message === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Выборка комментариев записи блога
     *
     * @param $post_id
     * @return array
     * @throws Exception
     */
    public function getBlogPostComments($post_id)
    {
        $result = array('comments' => array());

        $sel_comments = $this->db->query('
              SELECT `bc_id`, `bc_u_id`, `bc_text`, `bc_approval`, `bc_date_update`, 
                `user_name`, `user_email`, `user_image` 
              FROM `blog_comments`
              LEFT JOIN `users`
                ON `bc_u_id`=`user_id`
              WHERE `bc_blog_id`=?', $post_id);

        if ($sel_comments !== false and 0 < $sel_comments->num_rows())
        {
            $i = 0;
            foreach ($sel_comments->result() as $row)
            {
                $result['comments'][$i]['id']         = $row->bc_id;
                $result['comments'][$i]['text']       = $row->bc_text;
                $result['comments'][$i]['approval']   = $row->bc_approval;
                $result['comments'][$i]['user_id']    = $row->bc_u_id;
                $result['comments'][$i]['user_name']  = !empty($row->user_name) ? $row->user_name : $row->user_email;
                $result['comments'][$i]['user_image'] = !empty($row->user_image) ? mb_substr($row->user_image, 1) : '';

                $date = DateTime::createFromFormat('Y-m-d H:i:s', parent::parseDatetime($row->bc_date_update));
                $comment_date = ($row->bc_date_update != '0000-00-00 00:00:00' or $date !== false)
                    ? strftime('%d %B %G, %H:%M', strtotime($row->bc_date_update))
                    : '';

                $result['comments'][$i]['date'] = $comment_date;

                $i++;
            }
            unset($row);
        }
        elseif ($sel_comments === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Выборка прикрепленных курсов к записи блога
     *
     * @param $post_id
     * @return array
     */
    public function getBlogPostAttachedCourses($post_id)
    {
        $result = array();

        $sel_courses = $this->db->query('
            SELECT `bcrs_crs_id`, `crs_name`, `crs_blocked`, `crs_archive`
            FROM `blog_courses`
            LEFT JOIN `courses` ON `crs_id`=`bcrs_crs_id`
            WHERE `bcrs_cb_id`=? and `crs_blocked`=0 and `crs_archive`=0', $post_id);
        if($sel_courses !== false and 0 < $sel_courses->num_rows())
        {
            $i = 0;
            foreach ($sel_courses->result() as $row)
            {
                $result['attached_courses_id'][$i] = $row->bcrs_crs_id;
                $result['attached_courses'][$i]['id'] = $row->bcrs_crs_id;
                $result['attached_courses'][$i]['name'] = $row->crs_name;

                $i++;
            }
            unset($row);
        }
        elseif($sel_courses === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Сохранение изменений записи блога
     *
     * @param $post_id
     * @param $post_category_id
     * @param $post_poster_type
     * @param $post_poster
     * @param $post_video_type
     * @param $post_video
     * @param $post_title
     * @param $post_desc
     * @param $post_keywords
     * @param $post_text
     * @param $delete_courses
     * @param $insert_courses
     * @param $date
     * @return bool
     */
    public function updateBlogPost($post_id, $post_category_id, $post_poster_type, $post_poster, $post_video_type, $post_video, $post_title, $post_desc,
                                   $post_keywords, $post_text, $delete_courses, $insert_courses, $date)
    {
        $result = false;

        $up_data = $this->db->query('
            UPDATE `coach_blog` 
            SET `cb_bc_id`=?, `cb_poster_type`=?, `cb_poster`=?, `cb_post_video_type`=?, `cb_post_video_url`=?, `cb_post_title`=?, `cb_post_short_description`=?, 
                `cb_post_keywords`=?, `cb_post_text`=?, `cb_post_date_update`=? 
            WHERE `cb_id`=? LIMIT 1',
                array($post_category_id, $post_poster_type, $post_poster, $post_video_type, $post_video, $post_title,
                    $post_desc, $post_keywords, $post_text, $date, $post_id));
        if ($up_data !== false and 1 == $this->db->affected_rows())
        {
            $result = true;

            self::updateBlogPostCourses($post_id, $delete_courses, $insert_courses, $date);
        }
        elseif ($up_data === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Обновление прикрепленных курсов записи блога
     *
     * @param $post_id
     * @param $delete_courses
     * @param $insert_courses
     * @param $date
     */
    public function updateBlogPostCourses($post_id, $delete_courses, $insert_courses, $date)
    {
        if(!empty($delete_courses))
        {
            $courses_id = implode(',', $delete_courses);
            $del_data = $this->db->query('DELETE FROM `blog_courses` WHERE `bcrs_cb_id`=? and `bcrs_crs_id` IN ('.$courses_id.')', $post_id);
            if($del_data === false)
            {
                parent::logDbMessages(__METHOD__.':'.__LINE__);
            }
        }

        if(!empty($insert_courses))
        {
            $courses_id = '';
            foreach($insert_courses as $crs_id)
            {
                $courses_id .= (!empty($courses_id)) ? ', ' : '';
                $courses_id .= '('.$post_id.', '.$crs_id.', "'.$date.'")';
            }

            $ins_data = $this->db->query('INSERT INTO `blog_courses` (`bcrs_cb_id`, `bcrs_crs_id`, `bcrs_update`) VALUES '.$courses_id);
            if($ins_data === false)
            {
                parent::logDbMessages(__METHOD__.':'.__LINE__);
            }
        }
    }

    /**
     * Удаление записи блога
     *
     * @param $post_id
     * @return bool
     */
    public function deleteBlogPost($post_id)
    {
        $result = false;

        $up_data = $this->db->query('DELETE FROM `coach_blog` WHERE `cb_id`=? LIMIT 1', $post_id);

        if ($up_data !== false and 1 == $this->db->affected_rows())
        {
            $result = true;
        }
        elseif ($up_data === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Одобрение записи блога
     *
     * @param $post_id
     * @param $date
     * @return bool
     */
    public function approvalBlogPost($post_id, $date)
    {
        $up_data = $this->db->query('UPDATE `coach_blog` SET `cb_post_approval`=1, `cb_post_date_update`=? WHERE `cb_id`=? LIMIT 1',
            array($date, $post_id));

        if ($up_data !== false and 1 == $this->db->affected_rows())
        {
            return true;
        }
        elseif ($up_data === false)
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
     * Блокировка записи блога
     *
     * @param $post_id
     * @param $date
     * @return bool
     */
    public function blockBlogPost($post_id, $date)
    {
        $up_data = $this->db->query('UPDATE `coach_blog` SET `cb_post_approval`=0, `cb_post_date_update`=? WHERE `cb_id`=? LIMIT 1',
            array($date, $post_id));

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
     * Выборка комментариев блогов
     *
     * @return array
     * @throws Exception
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
                $date = DateTime::createFromFormat('Y-m-d H:i:s', parent::parseDatetime($row->bc_date_add));
                $message_date = ($row->bc_date_add != '0000-00-00 00:00:00' or $date !== false)
                    ? strftime('%d %B %G, %H:%M', strtotime(parent::parseDatetime($row->bc_date_add)))
                    : '';

                $result['comments'][$i]['date'] = $message_date;

                $i++;
            }
            unset($row);
        }
        elseif($sel_blog_comments === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Получение данных сообщения блога
     *
     * @param $comment_id
     * @return array
     * @throws Exception
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
            $date = DateTime::createFromFormat('Y-m-d H:i:s', parent::parseDatetime($row->bc_date_add));
            $message_date = ($row->bc_date_add != '0000-00-00 00:00:00' and $date !== false)
                ? strftime('%d %B %G, %H:%M', strtotime(parent::parseDatetime($row->bc_date_add)))
                : '';

            $result['comment']['date'] = $message_date;
        }
        elseif($sel_message === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
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
            parent::logDbMessages(__METHOD__.':'.__LINE__);
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
            parent::logDbMessages(__METHOD__.':'.__LINE__);
            return false;
        }
        else
        {
            return false;
        }
    }


    /**
     * Выборка списка категорий блога
     *
     * @return array
     */
    public function getBlogsCategories()
    {
        $result = array();

        $sel_data = $this->db->query('SELECT `bc_id`, `bc_name`, `bc_image` FROM `blog_categories`');
        if($sel_data !== false and 0 < $sel_data->num_rows())
        {
            $i = 0;
            foreach($sel_data->result() as $row)
            {
                $result['blog_categories'][$row->bc_id]['id']    = $row->bc_id;
                $result['blog_categories'][$row->bc_id]['name']  = $row->bc_name;
                $result['blog_categories'][$row->bc_id]['image'] = (is_file($row->bc_image)) ? mb_substr($row->bc_image, 1) : '';

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
     * Выборка списка категорий блога, хотя бы с одной статьей
     *
     * @return array
     */
    public function getAvailableBlogsCategories()
    {
        $result = array();

        $sel_data = $this->db->query('SELECT `bc_id`, `bc_name`, `bc_image`, COUNT(`cb_id`) as `count_posts`, `cb_post_approval` 
            FROM `blog_categories`
            LEFT JOIN `coach_blog` ON `cb_bc_id`=`bc_id`
            WHERE `cb_post_approval`=1
            GROUP BY `bc_id`');
        if($sel_data !== false and 0 < $sel_data->num_rows())
        {
            $i = 0;
            foreach($sel_data->result() as $row)
            {
                if($row->count_posts > 0)
                {
                    $result['blog_categories'][$row->bc_id]['id']    = $row->bc_id;
                    $result['blog_categories'][$row->bc_id]['name']  = $row->bc_name;
                    $result['blog_categories'][$row->bc_id]['image'] = (is_file($row->bc_image)) ? mb_substr($row->bc_image, 1) : '';

                    $i++;
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
     * Выборка первых двух категорий (питание и рецепты)
     *
     * @return array
     */
    public function getBlogUserMealCategories()
    {
        $result = array();

        $sel_data = $this->db->query('SELECT `bc_id`, `bc_name` FROM `blog_categories` WHERE `bc_id`=1 or `bc_id`=2');
        if($sel_data !== false and 0 < $sel_data->num_rows())
        {
            $i = 0;
            foreach($sel_data->result() as $row)
            {
                $result['blog_categories'][$i]['id']   = $row->bc_id;
                $result['blog_categories'][$i]['name'] = $row->bc_name;

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
     * Выборка записей блога по категории
     *
     * @param $category_id
     * @return array
     * @throws Exception
     */
    public function getBlogCategoryPosts($category_id)
    {
        $result = array();

        $sel_blog_mess = $this->db->query('
            SELECT `cb_id`, `cb_u_id`, `cb_poster_type`, `cb_poster`, `cb_post_title`, `cb_post_short_description`, `cb_post_keywords`, `cb_post_text`, `cb_post_approval`, 
              `cb_post_date_add`, `user_name`, `user_email` 
            FROM `coach_blog` 
            LEFT JOIN `users` ON `cb_u_id`=`user_id`
            WHERE `cb_bc_id`=?
            ORDER BY `cb_post_date_add` DESC', $category_id);

        if ($sel_blog_mess !== false and 0 < $sel_blog_mess->num_rows())
        {
            $i = 0;
            foreach ($sel_blog_mess->result() as $row)
            {
                $result['posts'][$i] = self::parseBlogPostData($row);
                $result['posts'][$i]['user']['id']   = $row->cb_u_id;
                $result['posts'][$i]['user']['name'] = !empty($row->user_name) ? $row->user_name : $row->user_email;

                $i++;
            }
            unset($row);
        }
        elseif($sel_blog_mess === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Выборка данных категории блога
     *
     * @param $category_id
     * @return array
     */
    public function getBlogCategory($category_id)
    {
        $result = array();

        $sel_data = $this->db->query('SELECT `bc_id`, `bc_name`, `bc_image` FROM `blog_categories` WHERE `bc_id`=? LIMIT 1', $category_id);
        if($sel_data !== false and 1 == $sel_data->num_rows())
        {
            $row = $sel_data->row();

            $result['blog_category']['id']    = $row->bc_id;
            $result['blog_category']['name']  = $row->bc_name;
            $result['blog_category']['image'] = (is_file($row->bc_image)) ? mb_substr($row->bc_image, 1) : '';

            unset($row);
        }
        elseif($sel_data === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Сохранение категории блога
     *
     * @param $name
     * @param $category_image
     * @param $admin_id
     * @param $date
     * @return bool|int
     */
    public function setNewBlogCategory($name, $category_image, $admin_id, $date)
    {
        $result = false;

        $ins_data = $this->db->query('INSERT INTO `blog_categories` (`bc_name`, `bc_image`, `bc_admin_id`, `bc_update`) VALUES (?, ?, ?, ?)',
            array($name, $category_image, $admin_id, $date));
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
     * Обновление данных категории блога
     *
     * @param $category_id
     * @param $name
     * @param $category_image
     * @param $admin_id
     * @param $date
     * @return bool
     */
    public function updateBlogCategory($category_id, $name, $category_image, $admin_id, $date)
    {
        $result = false;

        $ins_data = $this->db->query('UPDATE `blog_categories` SET `bc_name`=?, `bc_image`=?, `bc_admin_id`=?, `bc_update`=? WHERE `bc_id`=? LIMIT 1',
            array($name, $category_image, $admin_id, $date, $category_id));
        if($ins_data !== false and 1 == $this->db->affected_rows())
        {
            $result = true;
        }
        elseif($ins_data === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Выборка данных кода "Поделиться в соцсетях"
     *
     * @return array
     */
    public function getBlogShare()
    {
        $result = array();

        $sel_data = $this->db->query('SELECT `si_blog_share_top`, `si_blog_share_bottom` FROM `site_info` WHERE `si_id`=1 LIMIT 1');
        if($sel_data !== false and 1 == $sel_data->num_rows())
        {
            $row = $sel_data->row();

            $result['blog_share_top'] = $row->si_blog_share_top;
            $result['blog_share_bottom'] = $row->si_blog_share_bottom;
        }
        elseif($sel_data === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Сохранение данных кода "Поделиться в соцсетях"
     *
     * @param $share_top
     * @param $share_bottom
     * @param $admin_id
     * @param $date
     * @return bool
     */
    public function updateBlogShare($share_top, $share_bottom, $admin_id, $date)
    {
        $result = false;

        $up_data = $this->db->query('UPDATE `site_info` SET `si_blog_share_top`=?, `si_blog_share_bottom`=?, `si_user_id`=?, `si_date`=? WHERE `si_id`=1 LIMIT 1',
            array($share_top, $share_bottom, $admin_id, $date));
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

    /* КОНЕЦ БЛОКА ОБРАБОТКИ ДАННЫХ ЗАПИСЕЙ БЛОГОВ, КОММЕНТАРИЕВ И КАТЕГОРИЙ АП */

    /* НАЧАЛО БЛОКА ФУНКЦИЙ ОБРАБОТКИ ДАННЫХ */

    /**
     * Обработка данных записи блога
     *
     * @param $row
     * @return array
     * @throws Exception
     */
    protected function parseBlogPostData($row)
    {
        $result = array();
        $poster_types = array('vimeo', 'youtube', 'image');

        $result['id']          = $row->cb_id;
        $result['category_id'] = (!empty($row->cb_bc_id)) ? $row->cb_bc_id : null;
        $result['poster_type'] = (!empty($row->cb_poster_type) and in_array($row->cb_poster_type, $poster_types)) ? $row->cb_poster_type : '';
        $result['poster']      = null;
        $result['video_type']  = (!empty($row->cb_post_video_type) and in_array($row->cb_post_video_type, $poster_types)) ? $row->cb_post_video_type : '';
        $result['video']       = (!empty($row->cb_post_video_url)) ? $row->cb_post_video_url : '';
        $result['title']       = (!empty($row->cb_post_title)) ? $row->cb_post_title : 'Статья №'.$row->cb_id;
        $result['short_desc']  = (!empty($row->cb_post_short_description)) ? $row->cb_post_short_description : null;
        $result['keywords']    = (!empty($row->cb_post_keywords)) ? $row->cb_post_keywords : null;
        $result['text']        = (!empty($row->cb_post_text))
            ? nl2br(parent::showBBcodes($row->cb_post_text))
            : null;
        $result['bbc_text']    = (!empty($row->cb_post_text)) ? $row->cb_post_text : null;
        $result['approval']    = (!empty($row->cb_post_approval)) ? $row->cb_post_approval : null;

        if (!empty($row->cb_post_date_add))
        {
            setlocale(LC_ALL, 'ru_RU.UTF-8');
            $date = DateTime::createFromFormat('Y-m-d H:i:s', parent::parseDatetime($row->cb_post_date_add));
            $message_date = ($row->cb_post_date_add != '0000-00-00 00:00:00' and $date !== false)
                ? strftime('%e %B %G', strtotime(parent::parseDatetime($row->cb_post_date_add)))
                : '';

            $result['date'] = $message_date;
            $result['date_add'] = $message_date;

        }

        if (!empty($row->cb_post_date_update))
        {
            setlocale(LC_ALL, 'ru_RU.UTF-8');
            $date = DateTime::createFromFormat('Y-m-d H:i:s', parent::parseDatetime($row->cb_post_date_update));
            $message_date = ($row->cb_post_date_update != '0000-00-00 00:00:00' and $date !== false)
                ? strftime('%d %B %G, %H:%M', strtotime(parent::parseDatetime($row->cb_post_date_update)))
                : '';

            $result['date_update'] = $message_date;
        }

        if(!empty($result['poster_type']))
        {
            $result['poster'] = ($row->cb_poster_type == 'image' and is_file($row->cb_poster))
                ? mb_substr($row->cb_poster, 1) : $row->cb_poster;
        }

        return $result;
    }

    /* КОНЕЦ БЛОКА ФУНКЦИЙ ОБРАБОТКИ ДАННЫХ */
}