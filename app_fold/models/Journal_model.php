<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Класс Journal_model
 * 
 * Класс выборки, сохранения, измения данных статей, интервью, новостей
 *
 * @author Alina Sudeyskis <alina.sudeyskis@gmail.com>
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Journal_model extends CI_Model
{
    /**
     * Количество всех статей
     *
     * @return array
     */
    public function getECountArticles()
    {
        $result = array();

        $sel_count_articles = $this->db->query('
            SELECT COUNT(`j_id`) as `count_articles`
            FROM `journal`
            WHERE `j_type`=1');

        if ($sel_count_articles !== false and 1 == $sel_count_articles->num_rows()) 
        {
            $row = $sel_count_articles->row();
            $result['count_articles'] = $row->count_articles;
        }
        elseif ($sel_count_articles === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Количество не заблокированных статей
     *
     * @return array
     */
    public function getCountArticles()
    {
        $result = array();

        $sel_count_articles = $this->db->query('
            SELECT COUNT(`j_id`) as `count_articles`
            FROM `journal`
            WHERE `j_type`=1 and `j_blocked`=0');

        if ($sel_count_articles !== false and 1 == $sel_count_articles->num_rows()) 
        {
            $row = $sel_count_articles->row();
            $result['count_articles'] = $row->count_articles;
        }
        elseif ($sel_count_articles === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Выборка всех статей
     *
     * @return array
     */
    public function getEArticlesList()
    {
        $result = array();
        
        $sel_articles = $this->db->query('
            SELECT `j_id`, `j_name`, `j_image_path`, `j_short_description`, `j_full_description`, `j_author`, `j_source`, 
              `j_date_add`, `j_blocked`, `j_type`
            FROM `journal`
            WHERE `j_type`=1');
        
        if ($sel_articles !== false and 0 < $sel_articles->num_rows())
        {
            $i = 0;
            foreach ($sel_articles->result() as $row)
            {
                $result['articles'][$i] = self::parseJournalData($row);
                
                $i++;
            }
            unset($row);
        }
        elseif ($sel_articles === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }
        
        return $result;
    }

    /**
     * Сохранение новой записи
     *
     * @param int $type
     * @param string $name
     * @param string $images
     * @param string $short_desc
     * @param string $full_desc
     * @param string $author
     * @param string $source
     * @param datetime $date
     * @param int $user_id
     * @return bool
     */
    public function setNewJournalPost($type, $name, $images, $short_desc, $full_desc, $author, $source, $date, $user_id)
    {
        $up_data = $this->db->query('
            INSERT INTO `journal` (`j_type`, `j_name`, `j_image_path`, `j_short_description`, `j_full_description`, `j_author`, 
              `j_source`, `j_date_add`, `j_date_update`, `j_admin_id`) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)',
            array($type, $name, $images, $short_desc, $full_desc, $author, $source, $date, $date, $user_id));

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
     * Выборка данных статьи
     *
     * @param $post_id
     * @return array
     */
    public function getJournalPost($post_id)
    {
        $result = array();

        $sel_article = $this->db->query('
            SELECT `j_id`, `j_type`, `j_name`, `j_image_path`, `j_short_description`, `j_full_description`, `j_author`, 
              `j_source`, `j_date_add`, `j_blocked`
            FROM `journal`
            WHERE `j_id`=? LIMIT 1', $post_id);

        if ($sel_article !== false and 1 == $sel_article->num_rows()) 
        {
            $row = $sel_article->row();

            $result['post'] = self::parseJournalData($row);
        }
        elseif ($sel_article === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Изменение данных записи
     *
     * @param int $post_id
     * @param int $type
     * @param string $name
     * @param string $images
     * @param string $short_desc
     * @param string $full_desc
     * @param string $author
     * @param string $source
     * @param datetime $date
     * @param int $user_id
     * @return bool
     */
    public function setJournalPost($post_id, $type, $name, $images, $short_desc, $full_desc, $author, $source, $date, $user_id)
    {
        $up_data = $this->db->query('
            UPDATE `journal` 
            SET `j_type`=?, `j_name`=?, `j_image_path`=?, `j_short_description`=?, `j_full_description`=?, `j_author`=?, 
              `j_source`=?, `j_date_update`=?
            WHERE `j_id`=? LIMIT 1',
                array($type, $name, $images, $short_desc, $full_desc, $author, $source, $date, $post_id));

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
     * Выборка записей журнала, определенной категории
     *
     * @param int $type_id
     * @return array
     */
    public function getJournalPosts($type_id = 1)
    {
        $result = array();

        $sel_posts = $this->db->query('
            SELECT `j_id`, `j_name`, `j_image_path`, `j_short_description`, `j_full_description`, `j_author`, `j_source`, 
              `j_date_add`, `j_blocked`, `j_type`
            FROM `journal`
            WHERE `j_type`=?', $type_id);

        if ($sel_posts !== false and 0 < $sel_posts->num_rows()) 
        {
            $i = 0;
            foreach ($sel_posts->result() as $row) 
            {
                $result['posts'][$i] = self::parseJournalData($row);

                $i++;
            }
            unset($row);
        }
        elseif ($sel_posts === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Удаление изображения записи журнала
     *
     * @param $post_id
     * @param $image
     * @return bool
     */
    public function deleteImage($post_id, $image)
    {
        $sel_post = $this->db->query('SELECT `j_image_path` FROM `journal` WHERE `j_id`=? LIMIT 1', $post_id);

        if ($sel_post !== false and 1 == $sel_post->num_rows()) 
        {
            $row = $sel_post->row();

            $new_images = '';

            $images = explode(';', $row->j_image_path);
            foreach ($images as $img) 
            {
                if ($img = $image) 
                {
                    unlink($image);
                }
                else 
                {
                    $new_images .= $img.';';
                }
            }
            unset($img);

            if ($new_images != $row->j_image_path and !empty($row->j_image_path)) 
            {
                $up_data = $this->db->query('UPDATE `journal` SET `j_image_path`=? WHERE `j_id`=? LIMIT 1', array($new_images, $post_id));
                if ($up_data === false) 
                {
                    parent::logDbMessages(__METHOD__.':'.__LINE__);
                }
                $result = true;
            }
            else 
            {
                $result = 'not_found_image';
            }

        }
        elseif ($sel_post === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
            $result = 'SQL error';
        }
        else 
        {
            $result = 'not_found_post';
        }

        return $result;
    }

    /**
     * Выборка данных статьи
     *
     * @param $article_id
     * @return array
     */
    public function getEArticle($article_id)
    {
        $result = array();

        $sel_article = $this->db->query('
            SELECT `j_id`, `j_name`, `j_image_path`, `j_short_description`, `j_full_description`, `j_author`, `j_source`, 
              `j_date_add`, `j_blocked`, `j_type`
            FROM `journal`
            WHERE `j_id`=? and `j_type`=1 LIMIT 1', $article_id);

        if ($sel_article !== false and 1 == $sel_article->num_rows()) 
        {
            $row = $sel_article->row();
            
            $result['article'] = self::parseJournalData($row);
        }
        elseif ($sel_article === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Сохранение новой статьи
     *
     * @param string $name
     * @param string $image
     * @param string $short_desc
     * @param string $full_desc
     * @param string $author
     * @param string $source
     * @param datetime $date
     * @param int $user_id
     * @return bool
     */
    public function setNewArticle($name, $image, $short_desc, $full_desc, $author, $source, $date, $user_id)
    {
        $up_data = $this->db->query('
            INSERT INTO `journal` (`j_type`, `j_name`, `j_image_path`, `j_short_description`, `j_full_description`, `j_author`, 
              `j_source`, `j_date_add`, `j_date_update`, `j_admin_id`) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)',
                array(1, $name, $image, $short_desc, $full_desc, $author, $source, $date, $date, $user_id));
        
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
     * Сохранение изменений данных статьи
     *
     * @param int $article_id
     * @param string $name
     * @param string $image
     * @param string $short_desc
     * @param string $full_desc
     * @param string $author
     * @param string $source
     * @param datetime $date
     * @return bool
     */
    public function updateSettingsArticle($article_id, $name, $image, $short_desc, $full_desc, $author, $source, $date)
    {
        $up_data = $this->db->query('
            UPDATE `journal` 
            SET `j_name`=?, `j_image_path`=?, `j_short_description`=?, `j_full_description`=?, `j_author`=?, `j_source`=?, `j_date_update`=?
            WHERE `j_id`=? and `j_type`=1 LIMIT 1',
                array($name, $image, $short_desc, $full_desc, $author, $source, $date, $article_id));

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
     * Блокировка статьи
     *
     * @param $article_id
     * @param $date
     * @return bool
     */
    public function blockArticle($article_id, $date)
    {
        $up_data = $this->db->query('
            UPDATE `journal` 
            SET `j_blocked`=1, `j_date_update`=?
            WHERE `j_id`=? and `j_type`=1 LIMIT 1',
            array($date, $article_id));

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
     * Разблокировка статьи
     *
     * @param $article_id
     * @param $date
     * @return bool
     */
    public function unblockArticle($article_id, $date)
    {
        $up_data = $this->db->query('
            UPDATE `journal` 
            SET `j_blocked`=0, `j_date_update`=?
            WHERE `j_id`=? and `j_type`=1 LIMIT 1',
            array($date, $article_id));

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
     * Выборка всех не заблокированных статей
     *
     * @return array
     */
    public function getArticlesList()
    {
        $result = array();

        $sel_articles = $this->db->query('
            SELECT `j_id`, `j_name`, `j_image_path`, `j_short_description`, `j_full_description`, `j_author`, `j_source`, 
              `j_date_add`, `j_blocked`, `j_type`
            FROM `journal`
            WHERE `j_type`=1 and `j_blocked`=0');

        if ($sel_articles !== false and 0 < $sel_articles->num_rows())
        {
            $i = 0;
            foreach ($sel_articles->result() as $row)
            {
                $result['articles'][$i] = self::parseJournalData($row);

                $i++;
            }
            unset($row);
        }
        elseif ($sel_articles === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Выборка не заблокированной статьи
     *
     * @param $article_id
     * @return array
     */
    public function getArticle($article_id)
    {
        $result = array();

        $sel_article = $this->db->query('
            SELECT `j_id`, `j_name`, `j_image_path`, `j_short_description`, `j_full_description`, `j_author`, `j_source`, 
              `j_date_add`, `j_blocked`, `j_type`
            FROM `journal`
            WHERE `j_id`=? and `j_type`=1 and `j_blocked`=0 LIMIT 1', $article_id);

        if ($sel_article !== false and 1 == $sel_article->num_rows())
        {
            $row = $sel_article->row();

            $result['article'] = self::parseJournalData($row);
        }
        elseif ($sel_article === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Количество всех интервью
     *
     * @return array
     */
    public function getECountInterviews()
    {
        $result = array();

        $sel_count_interviews = $this->db->query('
            SELECT COUNT(`j_id`) as `count_interviews`
            FROM `journal`
            WHERE `j_type`=2');

        if ($sel_count_interviews !== false and 1 == $sel_count_interviews->num_rows())
        {
            $row = $sel_count_interviews->row();
            $result['count_interviews'] = $row->count_interviews;
        }
        elseif ($sel_count_interviews === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Количество не заблокированных интервью
     *
     * @return array
     */
    public function getCountInterviews()
    {
        $result = array();

        $sel_count_interviews = $this->db->query('
            SELECT COUNT(`j_id`) as `count_interviews`
            FROM `journal`
            WHERE `j_type`=2 and `j_blocked`=0');

        if ($sel_count_interviews !== false and 1 == $sel_count_interviews->num_rows())
        {
            $row = $sel_count_interviews->row();
            $result['count_interviews'] = $row->count_interviews;
        }
        elseif ($sel_count_interviews === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Выборка всех интервью
     *
     * @return array
     */
    public function getEInterviewsList()
    {
        $result = array();

        $sel_interviews = $this->db->query('
            SELECT `j_id`, `j_name`, `j_image_path`, `j_short_description`, `j_full_description`, `j_author`, `j_source`, 
              `j_date_add`, `j_blocked`, `j_type`
            FROM `journal`
            WHERE `j_type`=2');

        if ($sel_interviews !== false and 0 < $sel_interviews->num_rows())
        {
            $i = 0;
            foreach ($sel_interviews->result() as $row)
            {
                $result['interviews'][$i] = self::parseJournalData($row);

                $i++;
            }
            unset($row);
        }
        elseif ($sel_interviews === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Выборка данных интервью
     *
     * @param $interview_id
     * @return array
     */
    public function getEInterview($interview_id)
    {
        $result = array();

        $sel_article = $this->db->query('
            SELECT `j_id`, `j_name`, `j_image_path`, `j_short_description`, `j_full_description`, `j_author`, `j_source`, 
              `j_date_add`, `j_blocked`, `j_type`
            FROM `journal`
            WHERE `j_id`=? and `j_type`=2 LIMIT 1', $interview_id);

        if ($sel_article !== false and 1 == $sel_article->num_rows())
        {
            $row = $sel_article->row();

            $result['interview'] = self::parseJournalData($row);
        }
        elseif ($sel_article === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Сохранение нового интервью
     *
     * @param string $name
     * @param string $image
     * @param string $short_desc
     * @param string $full_desc
     * @param string $author
     * @param string $source
     * @param datetime $date
     * @param int $user_id
     * @return bool
     */
    public function setNewInterview($name, $image, $short_desc, $full_desc, $author, $source, $date, $user_id)
    {
        $up_data = $this->db->query('
            INSERT INTO `journal` (`j_type`, `j_name`, `j_image_path`, `j_short_description`, `j_full_description`, `j_author`, 
              `j_source`, `j_date_add`, `j_date_update`, `j_admin_id`) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)',
            array(2, $name, $image, $short_desc, $full_desc, $author, $source, $date, $date, $user_id));

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
     * Сохранение изменений данных интервью
     *
     * @param int $interview_id
     * @param string $name
     * @param string $image
     * @param string $short_desc
     * @param string $full_desc
     * @param string $author
     * @param string $source
     * @param datetime $date
     * @return bool
     */
    public function updateSettingsInterview($interview_id, $name, $image, $short_desc, $full_desc, $author, $source, $date)
    {
        $up_data = $this->db->query('
            UPDATE `journal` 
            SET `j_name`=?, `j_image_path`=?, `j_short_description`=?, `j_full_description`=?, `j_author`=?, `j_source`=?, `j_date_update`=?
            WHERE `j_id`=? and `j_type`=2 LIMIT 1',
            array($name, $image, $short_desc, $full_desc, $author, $source, $date, $interview_id));

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
     * Блокировка интервью
     *
     * @param $interview_id
     * @param $date
     * @return bool
     */
    public function blockInterview($interview_id, $date)
    {
        $up_data = $this->db->query('
            UPDATE `journal` 
            SET `j_blocked`=1, `j_date_update`=?
            WHERE `j_id`=? and `j_type`=2 LIMIT 1',
            array($date, $interview_id));

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
     * Разблокировка интервью
     *
     * @param $interview_id
     * @param $date
     * @return bool
     */
    public function unblockInterview($interview_id, $date)
    {
        $up_data = $this->db->query('
            UPDATE `journal` 
            SET `j_blocked`=0, `j_date_update`=?
            WHERE `j_id`=? and `j_type`=2 LIMIT 1',
            array($date, $interview_id));

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
     * Выборка не заблокированных интервью
     *
     * @return array
     */
    public function getInterviewsList()
    {
        $result = array();

        $sel_interviews = $this->db->query('
            SELECT `j_id`, `j_name`, `j_image_path`, `j_short_description`, `j_full_description`, `j_author`, `j_source`, 
              `j_date_add`, `j_blocked`, `j_type`
            FROM `journal`
            WHERE `j_type`=2 and `j_blocked`=0');

        if ($sel_interviews !== false and 0 < $sel_interviews->num_rows())
        {
            $i = 0;
            foreach ($sel_interviews->result() as $row)
            {
                $result['interviews'][$i] = self::parseJournalData($row);

                $i++;
            }
            unset($row);
        }
        elseif ($sel_interviews === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Выборка не заблокированного интервью
     *
     * @param $interview_id
     * @return array
     */
    public function getInterview($interview_id)
    {
        $result = array();

        $sel_article = $this->db->query('
            SELECT `j_id`, `j_name`, `j_image_path`, `j_short_description`, `j_full_description`, `j_author`, `j_source`, 
              `j_date_add`, `j_blocked`, `j_type`
            FROM `journal`
            WHERE `j_id`=? and `j_type`=2 and `j_blocked`=0 LIMIT 1', $interview_id);

        if ($sel_article !== false and 1 == $sel_article->num_rows())
        {
            $row = $sel_article->row();

            $result['interview'] = self::parseJournalData($row);
        }
        elseif ($sel_article === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }


    /**
     * Количество всех новостей
     *
     * @return array
     */
    public function getECountNews()
    {
        $result = array();

        $sel_count_news = $this->db->query('
            SELECT COUNT(`j_id`) as `count_news`
            FROM `journal`
            WHERE `j_type`=3');

        if ($sel_count_news !== false and 1 == $sel_count_news->num_rows())
        {
            $row = $sel_count_news->row();
            $result['count_news'] = $row->count_news;
        }
        elseif ($sel_count_news === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Количество не заблокированных новостей
     *
     * @return array
     */
    public function getCountNews()
    {
        $result = array();

        $sel_count_news = $this->db->query('
            SELECT COUNT(`j_id`) as `count_news`
            FROM `journal`
            WHERE `j_type`=3 and `j_blocked`=0');

        if ($sel_count_news !== false and 1 == $sel_count_news->num_rows())
        {
            $row = $sel_count_news->row();
            $result['count_news'] = $row->count_news;
        }
        elseif ($sel_count_news === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Выборка всех новостей
     *
     * @return array
     */
    public function getENewsList()
    {
        $result = array();

        $sel_news = $this->db->query('
            SELECT `j_id`, `j_name`, `j_image_path`, `j_short_description`, `j_full_description`, `j_author`, `j_source`, `j_date_add`
            FROM `journal`
            WHERE `j_type`=3');

        if ($sel_news !== false and 0 < $sel_news->num_rows())
        {
            $i = 0;
            foreach ($sel_news->result() as $row)
            {
                $result['news'][$i] = self::parseJournalData($row);

                $i++;
            }
            unset($row);
        }
        elseif ($sel_news === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Выборка данных новости
     *
     * @param $news_id
     * @return array
     */
    public function getENews($news_id)
    {
        $result = array();

        $sel_article = $this->db->query('
            SELECT `j_id`, `j_name`, `j_image_path`, `j_short_description`, `j_full_description`, `j_author`, `j_source`, `j_date_add`, `j_blocked`
            FROM `journal`
            WHERE `j_id`=? and `j_type`=3 LIMIT 1', $news_id);

        if ($sel_article !== false and 1 == $sel_article->num_rows())
        {
            $row = $sel_article->row();

            $result['news'] = self::parseJournalData($row);
        }
        elseif ($sel_article === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Сохранение новой новости
     *
     * @param string $name
     * @param string $image
     * @param string $short_desc
     * @param string $full_desc
     * @param string $author
     * @param string $source
     * @param datetime $date
     * @param int $user_id
     * @return bool
     */
    public function setNewNews($name, $image, $short_desc, $full_desc, $author, $source, $date, $user_id)
    {
        $up_data = $this->db->query('
            INSERT INTO `journal` (`j_type`, `j_name`, `j_image_path`, `j_short_description`, `j_full_description`, `j_author`, 
              `j_source`, `j_date_add`, `j_date_update`, `j_admin_id`) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)',
            array(3, $name, $image, $short_desc, $full_desc, $author, $source, $date, $date, $user_id));

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
     * Сохранение изменений данных новости
     *
     * @param int $news_id
     * @param string $name
     * @param string $image
     * @param string $short_desc
     * @param string $full_desc
     * @param string $author
     * @param string $source
     * @param datetime $date
     * @return bool
     */
    public function updateSettingsNews($news_id, $name, $image, $short_desc, $full_desc, $author, $source, $date)
    {
        $up_data = $this->db->query('
            UPDATE `journal` 
            SET `j_name`=?, `j_image_path`=?, `j_short_description`=?, `j_full_description`=?, `j_author`=?, `j_source`=?, `j_date_update`=?
            WHERE `j_id`=? and `j_type`=3 LIMIT 1',
            array($name, $image, $short_desc, $full_desc, $author, $source, $date, $news_id));

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
     * Блокировка новости
     *
     * @param $new_id
     * @param $date
     * @return bool
     */
    public function blockNews($new_id, $date)
    {
        $up_data = $this->db->query('
            UPDATE `journal` 
            SET `j_blocked`=1, `j_date_update`=?
            WHERE `j_id`=? and `j_type`=3 LIMIT 1',
            array($date, $new_id));

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
     * Разблокировка новости
     *
     * @param $new_id
     * @param $date
     * @return bool
     */
    public function unblockNews($new_id, $date)
    {
        $up_data = $this->db->query('
            UPDATE `journal` 
            SET `j_blocked`=0, `j_date_update`=?
            WHERE `j_id`=? and `j_type`=3 LIMIT 1',
            array($date, $new_id));

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
     * Выборка не заблокированных новостей
     *
     * @return array
     */
    public function getNewsList()
    {
        $result = array();

        $sel_news = $this->db->query('
            SELECT `j_id`, `j_name`, `j_image_path`, `j_short_description`, `j_full_description`, `j_author`, `j_source`, 
              `j_date_add`, `j_blocked`, `j_type`
            FROM `journal`
            WHERE `j_type`=3 and `j_blocked`=0');

        if ($sel_news !== false and 0 < $sel_news->num_rows())
        {
            $i = 0;
            foreach ($sel_news->result() as $row)
            {
                $result['news'][$i] = self::parseJournalData($row);

                $i++;
            }
            unset($row);
        }
        elseif ($sel_news === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Выборка не заблокированной новости
     *
     * @param $news_id
     * @return array
     */
    public function getNews($news_id)
    {
        $result = array();

        $sel_article = $this->db->query('
            SELECT `j_id`, `j_name`, `j_image_path`, `j_short_description`, `j_full_description`, `j_author`, `j_source`, 
              `j_date_add`, `j_blocked`, `j_type`
            FROM `journal`
            WHERE `j_id`=? and `j_type`=3 LIMIT 1', $news_id);

        if ($sel_article !== false and 1 == $sel_article->num_rows())
        {
            $row = $sel_article->row();

            $result['news'] = self::parseJournalData($row);
        }
        elseif ($sel_article === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Обработка данных полей из таблицы "Journal"
     *
     * @param $row
     * @return array
     */
    protected function parseJournalData($row)
    {
        $result = array();

        $types_name = array(1 => 'Статья', 2 => 'Интервью', 3 => 'Новость');

        $type_name = (!empty($row->j_type) and array_key_exists($row->j_type, $types_name)) ? $types_name[$row->j_type] : 'Статья';

        $result['id']         = $row->j_id;
        $result['name']       = !empty($row->j_name) ? $row->j_name : $type_name.' №'.$row->j_id;
        $result['image']      = '';
        $result['images']     = array();
        $result['short_desc'] = !empty($row->j_short_description) ? $row->j_short_description : null;
        $result['full_desc']  = !empty($row->j_full_description) ? $row->j_full_description : null;
        $result['author']     = !empty($row->j_author) ? $row->j_author : null;
        $result['source']     = !empty($row->j_source) ? $row->j_source : null;
        $result['blocked']    = !empty($row->j_blocked) ? $row->j_blocked : null;
        $result['type']       = !empty($row->j_type) ? $row->j_type : null;

        setlocale(LC_ALL, 'ru_RU.UTF-8');
        $tmp_date = DateTime::createFromFormat('Y-m-d H:i:s', $row->j_date_add);
        $journal_date = ($row->j_date_add != '0000-00-00 00:00:00' or $tmp_date !== false)
            ? strftime('%d.%m.%Y', strtotime($row->j_date_add))
            : '';
        $result['date'] = $journal_date;

        $images = !empty($row->j_image_path) ? explode(';', $row->j_image_path) : '';
        if (!empty($images))
        {
            $result['image'] = is_file($images[0]) ? mb_substr($images[0], 1) : '';

            $im = 0;
            foreach ($images as $image)
            {
                if (is_file($image))
                {
                    $result['images'][$im] = mb_substr($image, 1);

                    $im++;
                }
            }
            unset($image);
            unset($im);
        }

        return $result;
    }
}