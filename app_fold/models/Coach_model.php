<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Класс Coach_model
 *
 * Класс вывода, сохранения, изменения данных тренера
 *
 * @author Alina Sudeyskis <alina.sudeyskis@gmail.com>
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Coach_model extends CI_Model
{
    /**
     * Добавление нового тренера
     *
     * @param string $email E-mail пользователя
     * @param string $name Полное имя пользователя
     * @param string $password_hash Хэш пароля
     * @param string $email_hash Хэш E-mail
     * @param datetime $date Текущая дата
     * @return bool
     */
    public function setNewCoach($email, $name, $password_hash, $email_hash, $date)
    {
        $sel_user = $this->db->query('SELECT `user_id` FROM `users` WHERE `user_email`=? LIMIT 1', $email);

        if ($sel_user !== false and 0 == $sel_user->num_rows())
        {
            $this->db->query('
                INSERT INTO `users` 
                    (`user_email`, `user_name`, `user_password`, `user_type`, `user_activated`, `user_activate_code`, `user_date_reg`, `user_date_update`)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)', array($email, $name, $password_hash, 2, 0, $email_hash, $date, $date));

            if (1 == $this->db->affected_rows())
            {
                $this->db->query('INSERT INTO `questionnaire` (`user_id`) VALUES (?)', $this->db->insert_id());
                $this->db->query('INSERT INTO `coach_data` (`cd_u_id`) VALUES (?)', $this->db->insert_id());

                return $this->db->insert_id();
            }
            else
            {
                return 'e2'; // Не удалось зарегестрировать E-mail
            }
        }
        elseif($sel_user === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
            return 'e2'; // Не удалось зарегестрировать E-mail
        }
        else
        {
            return 'e1'; // Пользователь с таким E-mail уже зарегистрирован.
        }
    }

    /**
     * Сохранение изображения администратора
     *
     * @param $user_id
     * @param $path_avatar
     * @return bool
     */
    public function setCoachAvatar($user_id, $path_avatar)
    {
        $result = false;

        if (is_numeric($user_id))
        {
            $up_data = $this->db->query('UPDATE `users` SET `user_image`=? WHERE `user_id`=? and `user_type`=2 LIMIT 1',
                array($path_avatar, $user_id));

            if($up_data !== false and 1 == $this->db->affected_rows())
            {
                $result = true;
            }
            elseif ($up_data === false)
            {
                parent::logDbMessages(__METHOD__.':'.__LINE__);
            }
        }

        return $result;
    }

    /**
     * Получение данных тренера
     *
     * @param int $user_id ID пользователя
     * @param string $today Текущая дата
     * @return array
     */
    public function getCoach($user_id, $today = null)
    {
        // Массив возвращаемых значений
        $result = array ( 'user_data' => array());

        if(is_numeric($user_id))
        {
            $sel_data = $this->db->query('
            SELECT `users`.`user_id`, `user_email`, `user_type`, `user_name`, `user_image`, `user_blocked`, 
              `user_password`, `user_deleted`, `user_delete_date`, `user_delete_by`, 
              `user_new_email`, `user_new_email_idempotent`, `user_activated`, `user_activate_code`, 
              `user_gender`, `user_birthday`, `user_country_code`, `user_phone`,
              `cd_specialization`, `cd_experience`, `cd_titles_awards`, `cd_about` 
            FROM `users` 
            LEFT JOIN `coach_data` ON `cd_u_id`=`users`.`user_id`
            LEFT JOIN `questionnaire` ON `questionnaire`.`user_id`=`users`.`user_id`
            WHERE `users`.`user_id`=? and `user_type`=2 and `user_deleted`=0 LIMIT 1', $user_id);

            if ($sel_data !== false and 1 == $sel_data->num_rows())
            {
                $row = $sel_data->row();

                $result['user_data'] = self::parseCoachData($row, $today);

                $coach_social = parent::getUserSocial($row->user_id);
                $result['user_social'] = $coach_social['user_social'];
            }
            elseif($sel_data === false)
            {
                parent::logDbMessages(__METHOD__.':'.__LINE__);
            }
        }


        return $result;
    }

    /**
     * Сохранение изменений данных тренера
     *
     * @param $user_id
     * @param $user_email
     * @param $user_name
     * @param $path_image
     * @param $date
     * @return bool
     */
    public function setCoachSettings($user_id, $user_email, $user_name, $path_image, $date)
    {
        $up_data = $this->db->query('
            UPDATE `users` 
            SET `user_email`=?, `user_name`=?, `user_image`=?, `user_date_update`=?
            WHERE `user_id`=? and `user_type`=2 LIMIT 1', array($user_email, $user_name, $path_image, $date, $user_id));

        if ($up_data !== false and 1 == $this->db->affected_rows())
        {
            $this->db->query('');
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
     * Сохранение изменений пола и даты рождения тренера
     *
     * @param int $user_id ID тренера
     * @param string $gender Пол (female|male)
     * @param string $birthday Дата рождения
     * @param string $date Текущая дата
     * @return bool
     */
    public function setCoachGenderBd($user_id, $gender, $birthday, $date)
    {
        $up_data = $this->db->query('
            UPDATE `questionnaire` 
            SET `user_gender`=?, `user_birthday`=?, `user_date_update`=?
            WHERE `user_id`=? LIMIT 1', array($gender, $birthday, $date, $user_id));

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
     * Сохранение изменений личных данных тренера
     *
     * @param int $user_id ID тренера
     * @param string $special Специализация
     * @param int $experience Стаж работы
     * @param string $title_awards Титулы и награды
     * @param string $about О себе
     * @param string $date Текущая дата
     * @return bool
     */
    public function setCoachData($user_id, $special, $experience, $title_awards, $about, $date)
    {
        $result = false;

        $sel_data = $this->db->query('SELECT `cd_u_id` FROM `coach_data` WHERE `cd_u_id`=? LIMIT 1', $user_id);
        if($sel_data !== false and 1 == $sel_data->num_rows())
        {
            $up_data = $this->db->query('
                UPDATE `coach_data` 
                SET `cd_specialization`=?, `cd_experience`=?, `cd_titles_awards`=?, `cd_about`=?, `cd_date_update`=?
                WHERE `cd_u_id`=? LIMIT 1', array($special, $experience, $title_awards, $about, $date, $user_id));

            if ($up_data !== false and 1 == $this->db->affected_rows())
            {
                $result = true;
            }
            elseif($up_data === false)
            {
                parent::logDbMessages(__METHOD__.':'.__LINE__);
            }
        }
        elseif($sel_data === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }
        else
        {
            $up_data = $this->db->query('
                INSERT INTO `coach_data` (`cd_u_id`, `cd_specialization`, `cd_experience`, `cd_titles_awards`, `cd_about`, `cd_date_update`)
                VALUES(?, ?, ?, ?, ?, ?)', array($user_id, $special, $experience, $title_awards, $about, $date));

            if ($up_data !== false and 1 == $this->db->affected_rows())
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
     * Получение списка тренеров
     *
     * @return array
     */
    public function getCoaches()
    {
        $result = array();

        $sel_coaches = $this->db->query('
            SELECT `user_name`, `user_email`, `user_id`, `user_image`, `cd_specialization`, `cd_titles_awards`, `cd_about` 
            FROM `users` 
            LEFT JOIN `coach_data` ON `cd_u_id`=`user_id`
            WHERE `user_type`=2 and `user_deleted`=0');

        if ($sel_coaches !== false and 0 < $sel_coaches->num_rows())
        {
            $i = 0;
            foreach ($sel_coaches->result() as $row)
            {
                $result['coaches'][$i]['id'] = $row->user_id;

                $user_name = explode(' ', $row->user_name);
                $result['coaches'][$i]['f_name']  = !empty($row->user_name) ? $row->user_name : $row->user_email;
                $result['coaches'][$i]['name']    = $user_name[0];
                $result['coaches'][$i]['surname'] = !empty($user_name[1]) ? $user_name[1] : '';
                
                $result['coaches'][$i]['image']         = is_file($row->user_image) ? mb_substr($row->user_image, 1) : '';
                $result['coaches'][$i]['special']       = $row->cd_specialization;
                $result['coaches'][$i]['titles_awards'] = $row->cd_titles_awards;
                $result['coaches'][$i]['bbc_about']     = !empty($row->cd_about) ? parent::showBBcodes($row->cd_about) : '';
                $result['coaches'][$i]['about']         = $row->cd_about;

                $coach_social = parent::getUserSocial($row->user_id);
                $result['coaches'][$i]['user_social'] = $coach_social['user_social'];

                $i++;
            }
        }
        elseif($sel_coaches === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Блокировка тренера
     *
     * @param $user_id
     * @param $date
     * @return bool
     */
    public function blockCoach($user_id, $date)
    {
        $up_data = $this->db->query('
            UPDATE `users` 
            SET `user_blocked`=1, `user_date_update`=? 
            WHERE `user_id`=? and `user_type`=2 LIMIT 1', array($date, $user_id));

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
     * Разблокировка тренера
     *
     * @param $user_id
     * @param $date
     * @return bool
     */
    public function unblockCoach($user_id, $date)
    {
        $up_data = $this->db->query('
            UPDATE `users` 
            SET `user_blocked`=0, `user_date_update`=? 
            WHERE `user_id`=? and `user_type`=2 LIMIT 1', array($date, $user_id));

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
     * Получение данных об изображениях портфолио тренера
     *
     * @param $user_id
     * @return array
     */
    public function getCoachPortfolioData($user_id)
    {
        $result = array('portfolio' => array());

        $sel_portfolio = $this->db->query('
            SELECT `cp_id`, `cp_image_title`, `cp_image_path`, `cp_image_description` FROM `coach_portfolio` WHERE `cp_u_id`=?', $user_id);

        if ($sel_portfolio !== false and 0 < $sel_portfolio->num_rows())
        {
            $i = 0;
            foreach ($sel_portfolio->result() as $row)
            {
                if (is_file($row->cp_image_path))
                {
                    $result['portfolio'][$i]['image_id']   = $row->cp_id;
                    $result['portfolio'][$i]['image_path'] = mb_substr($row->cp_image_path, 1);
                    $result['portfolio'][$i]['image_desc'] = mb_substr($row->cp_image_description, 0, 65);

                    $i++;
                }
            }
            unset($row);
        }
        elseif($sel_portfolio === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Получение данных об изображениях портфолио тренера
     *
     * @param $user_id
     * @return array
     */
    public function getPublicCoachPortfolioData($user_id)
    {
        $result = array('portfolio' => array());

        $sel_portfolio = $this->db->query('
            SELECT `cp_id`, `cp_image_title`, `cp_image_path`, `cp_image_description` FROM `coach_portfolio`
            WHERE `cp_u_id`=? and `cp_image_approval`=1', $user_id);

        if ($sel_portfolio !== false and 0 < $sel_portfolio->num_rows())
        {
            $i = 0;
            foreach ($sel_portfolio->result() as $row)
            {
                if (is_file($row->cp_image_path))
                {
                    $result['portfolio'][$i]['image_id']   = $row->cp_id;
                    $result['portfolio'][$i]['image_path'] = mb_substr($row->cp_image_path, 1);
                    $result['portfolio'][$i]['image_desc'] = mb_substr($row->cp_image_description, 0, 65);

                    $i++;
                }
            }
            unset($row);
        }
        elseif($sel_portfolio === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Выборка записи портфолио тренера
     *
     * @param int $user_id ID тренера
     * @param int $post_id ID записи
     * @return array
     */
    public function getCoachPortfolioPost($user_id, $post_id)
    {
        $result = array();

        $sel_post = $this->db->query('
            SELECT `cp_id`, `cp_image_title`, `cp_image_path`, `cp_image_description`, `cp_image_approval` 
            FROM `coach_portfolio` 
            WHERE `cp_u_id`=? and `cp_id`=?
            LIMIT 1', array($user_id, $post_id));

        if ($sel_post !== false and 1 == $sel_post->num_rows())
        {
            $row = $sel_post->row();

            $result['post']['id']    = $row->cp_id;
            $result['post']['title'] = !empty($row->cp_image_title) ? $row->cp_image_title : '';
            $result['post']['path']  = !empty($row->cp_image_path) ? mb_substr($row->cp_image_path, 1) : '';
            $result['post']['desc']  = $row->cp_image_description;
            $result['post']['approval'] = $row->cp_image_approval;
        }
        elseif($sel_post === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Выборка записи портфолио тренера
     *
     * @param int $post_id ID записи
     * @return array
     */
    public function getPortfolioPost($post_id)
    {
        $result = array();

        $sel_post = $this->db->query('
            SELECT `cp_id`, `cp_u_id`, `cp_image_title`, `cp_image_path`, `cp_image_description`, `cp_image_approval` 
            FROM `coach_portfolio` 
            WHERE `cp_id`=?
            LIMIT 1', array($post_id));

        if ($sel_post !== false and 1 == $sel_post->num_rows())
        {
            $row = $sel_post->row();

            $result['post']['id']       = $row->cp_id;
            $result['post']['coach_id'] = $row->cp_u_id;
            $result['post']['title']    = !empty($row->cp_image_title) ? $row->cp_image_title : '';
            $result['post']['path']     = !empty($row->cp_image_path) ? mb_substr($row->cp_image_path, 1) : '';
            $result['post']['desc']     = $row->cp_image_description;
            $result['post']['approval'] = $row->cp_image_approval;
        }
        elseif($sel_post === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Сохранение записи в портфолио
     *
     * @param int $user_id ID тренера
     * @param string $image Путь к изображению
     * @param string $title Заголовок
     * @param string $description Описание
     * @param string $date Дата
     * @return bool|int
     */
    public function setCoachPortfolioPost($user_id, $image, $title, $description, $date)
    {
        $up_data = $this->db->query('
            INSERT INTO `coach_portfolio` (`cp_u_id`, `cp_image_path`, `cp_image_title`, `cp_image_description`, `cp_date_add`, `cp_date_update`)
            VALUES (?, ?, ?, ?, ?, ?)', array($user_id, $image, $title, $description, $date, $date));

        if ($up_data !== false and 1 == $this->db->affected_rows())
        {
            return $this->db->insert_id();
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
     * Сохранение изменений портфолио тренера
     *
     * @param int $user_id ID тренера
     * @param int $post_id ID записи портфолио
     * @param string|null $image Путь к изображению
     * @param string|null $title Заголовок
     * @param string|null $description Описание
     * @param string $date Дата
     * @return array
     */
    public function updateCoachPortfolio($user_id, $post_id, $image = null, $title = null, $description = null, $date)
    {
        $result = array('image' => '', 'data' => '');

        if (!empty($image))
        {
            $up_data = $this->db->query('
                UPDATE `coach_portfolio`
                SET `cp_image_path`=?, `cp_date_update`=?
                WHERE `cp_u_id`=? and `cp_id`=? LIMIT 1', array($image, $date, $user_id, $post_id));

            if ($up_data !== false and 1 == $this->db->affected_rows())
            {
                $result['image'] = true;
            }
            elseif($up_data === false)
            {
                parent::logDbMessages(__METHOD__.':'.__LINE__);
            }
            else
            {
                $result['image'] = false;
            }
        }

        if (!empty($title) and !empty($description))
        {
            $up_data = $this->db->query('
                UPDATE `coach_portfolio`
                SET `cp_image_title`=?, `cp_image_description`=?, `cp_date_update`=?
                WHERE `cp_u_id`=? and `cp_id`=? LIMIT 1', array($title, $description, $date, $user_id, $post_id));

            if ($up_data !== false and 1 == $this->db->affected_rows())
            {
                $result['data'] = true;
            }
            elseif($up_data === false)
            {
                parent::logDbMessages(__METHOD__.':'.__LINE__);
            }
            else
            {
                $result['data'] = false;
            }
        }

        return $result;
    }

    /**
     * Удаление записи тренера из портфолио
     *
     * @param int $user_id ID тренера
     * @param int $post_id ID записи
     * @return bool
     */
    public function deleteCoachPortfolioPost($user_id, $post_id)
    {
        $up_data = $this->db->query('DELETE FROM `coach_portfolio` WHERE `cp_u_id`=? and `cp_id`=? LIMIT 1', array($user_id, $post_id));

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
     * Выборка активности клиентов
     *
     * @param $user_id
     * @return array
     */
    public function getCoachClientsActivity($user_id)
    {
        // Массив данных ою активности клиентов и общее кол-во клиентов
        $result = array('clients' => array(), 'number_clients' => 0);

        // Клиенты тренера
        $sel_users = $this->db->query('
            SELECT `uc_id`, `uc_course_id`, `uc_user_id`, `user_name`, `user_email`, `user_image` 
            FROM `users_courses` 
            LEFT JOIN `users` ON `uc_user_id`=`user_id`
            WHERE `uc_coach_id`=?', $user_id);

        if ($sel_users !== false and 0 < $sel_users->num_rows())
        {
            $i = 0;
            foreach ($sel_users->result() as $row)
            {
                $result['clients'][$i]['id']    = $row->uc_user_id;
                $result['clients'][$i]['uc_id'] = $row->uc_id;

                $result['clients'][$i]['course_id'] = $row->uc_course_id;

                $split_name = !empty($row->user_name) ? explode(" ", $row->user_name) : '';

                $result['clients'][$i]['split_name']['name']    = !empty($split_name[0]) ? $split_name[0] : $row->user_email;
                $result['clients'][$i]['split_name']['surname'] = !empty($split_name[1]) ? $split_name[1] : '';

                $result['clients'][$i]['image'] = is_file($row->user_image) ? mb_substr($row->user_image, 1) : null;

                $result['clients'][$i]['missed_workouts'] = 0;
                $result['clients'][$i]['missed_date']     = '';
                $result['clients'][$i]['workouts_done']   = 0;

                $i++;
            }
            unset($row);

            if (!empty($result['clients']))
            {
                // Общее кол-во клиентов
                $result['number_clients'] = parent::endingWords(count($result['clients']), 'клиент', 'клиентов', 'клиента');

                foreach ($result['clients'] as $key => $client)
                {
                    // Выборка пропущенных занятий клиента
                    $sel_missed_workouts = $this->db->query('
                        SELECT COUNT(`utw_status`) as `missed_workouts`, `utw_date` 
                        FROM `users_training_weeks`
                        WHERE `utw_uc_id`=? and `utw_status`="missed"', $client['uc_id']);

                    if ($sel_missed_workouts !== false and 1 == $sel_missed_workouts->num_rows())
                    {
                        $row = $sel_missed_workouts->row();

                        $result['clients'][$key]['missed_workouts'] = parent::endingWords($row->missed_workouts, '</span> пропущенное занятие.', '</span> пропущенных занятий.');

                        $date = DateTime::createFromFormat('Y-m-d', $row->utw_date);
                        $missed_date = ($row->utw_date != '0000-00-00' and $date !== false) ? $date->format('d.m.Y') : '';

                        $result['clients'][$key]['missed_date'] = $missed_date;
                    }
                    elseif($sel_missed_workouts === false)
                    {
                        parent::logDbMessages(__METHOD__.':'.__LINE__);
                    }

                    $sel_missed_workouts->free_result();

                    // Выборка данные курса и подсчет процента выполненных тренировок
                    $sel_course = $this->db->query('
                        SELECT `crs_count_weeks`, `crs_count_days` 
                        FROM `courses` 
                        WHERE `crs_id`=? LIMIT 1', $client['course_id']);

                    if ($sel_course !== false and 1 == $sel_course->num_rows())
                    {
                        $row = $sel_course->row();
                        // Общее кол-во тренировок курса
                        $total_workouts = $row->crs_count_weeks * $row->crs_count_days;

                        // Выборка кол-ва выполненных тренировок курса пользователем
                        $sel_done_workouts = $this->db->query('
                            SELECT COUNT(`utw_status`) as `workouts_done`
                            FROM `users_training_weeks`
                            WHERE `utw_uc_id`=? and `utw_status`="done"', $client['uc_id']);

                        if ($sel_done_workouts !== false and 1 == $sel_done_workouts->num_rows())
                        {
                            $row = $sel_done_workouts->row();

                            $result['clients'][$key]['workouts_done'] = ($row->workouts_done * 100) / $total_workouts;
                        }
                        elseif($sel_done_workouts === false)
                        {
                            parent::logDbMessages(__METHOD__.':'.__LINE__);
                        }
                    }
                    elseif($sel_course === false)
                    {
                        parent::logDbMessages(__METHOD__.':'.__LINE__);
                    }
                }
                unset($client);
            }
        }
        elseif($sel_users === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Поиск тренеров
     *
     * @param int|string $search_text
     * @return string|bool
     */
    public function searchCoaches($search_text)
    {
        $result = false;

        if (is_numeric($search_text))
        {
            $sel_coaches = $this->db->query('
                SELECT `user_id`, `user_name`, `user_email`, `user_image` 
                FROM `users` 
                WHERE `user_id`=? and `user_type`=2 LIMIT 1',
                    $search_text);
            if($sel_coaches === false)
            {
                parent::logDbMessages(__METHOD__.':'.__LINE__);
            }
        }
        else
        {
            $search_text = $search_text.'*';

            $sel_coaches = $this->db->query('
                SELECT `user_id`, `user_name`, `user_email`, `user_image` 
                FROM `users` 
                WHERE `user_type`=2 and MATCH (`user_email`, `user_name`) AGAINST (? IN BOOLEAN MODE)',
                    $search_text);
            if($sel_coaches === false)
            {
                parent::logDbMessages(__METHOD__.':'.__LINE__);
            }
        }

        if (0 < $sel_coaches->num_rows())
        {
            foreach ($sel_coaches->result() as $row)
            {
                $user_name = !empty($row->user_name) ? $row->user_name : $row->user_email ;
                $user_image = !empty($row->user_image) ? '<img src="' . mb_substr($row->user_image, 1) . '" alt="">' : '' ;

                $result .= '<div class="add_tov_item add_tren_item parent" id="' . $row->user_id . '">
                        <div class="add_tov_img">' . $user_image . '</div>
                        <a href="#" class="add_tov_cont add_tren_name">
                            <div class="add_tov_h">' . $user_name . '</div>
                        </a>
                    </div>';
            }
            unset($row);
        }
        else
        {
            $result = '<div class="not_found">Тренер не найден</div>';
        }

        return $result;
    }

    /**
     * Список прикрепленных тренеров к пользователю
     *
     * @param $user_id
     * @return array
     */
    public function getAttachedCoaches($user_id)
    {
        $result = array();

        if (is_numeric($user_id))
        {
            $sel_coaches = $this->db->query('
                SELECT `uc_coach_id`, `user_name`, `user_email`, `user_image` 
                FROM `users_courses` 
                LEFT JOIN `users` ON `uc_coach_id`=`user_id`
                WHERE `uc_user_id`=?', $user_id);

            if ($sel_coaches !== false and 0 < $sel_coaches->num_rows())
            {
                $i = 0;
                foreach ($sel_coaches->result() as $row) {
                    $result[$row->uc_coach_id]['id']    = $row->uc_coach_id;
                    $result[$row->uc_coach_id]['name']  = !empty($row->user_name) ? $row->user_name : $row->user_email;
                    $result[$row->uc_coach_id]['image'] = $row->user_image;

                    $i++;
                }
                unset($row);
            }
            elseif ($sel_coaches === false)
            {
                parent::logDbMessages(__METHOD__.':'.__LINE__);
            }
        }

        return $result;
    }

    /**
     * Список прикрепленных пользователей к тренеру
     *
     * @param $user_id
     * @return array
     */
    public function getAttachedUsers($user_id)
    {
        $result = array();

        $sel_users = $this->db->query('
            SELECT `uc_user_id`, `user_name`, `user_email`, `user_image` 
            FROM `users_courses` 
            LEFT JOIN `users` 
              ON `uc_user_id`=`user_id`
            WHERE `uc_coach_id`=?', $user_id);

        if ($sel_users !== false and 0 < $sel_users->num_rows())
        {
            $i = 0;
            foreach ($sel_users->result() as $row)
            {
                $result[$i]['id']    = $row->uc_user_id;
                $result[$i]['name']  = !empty($row->user_name) ? $row->user_name : $row->user_email;
                $result[$i]['image'] = $row->user_image;

                $i++;
            }
            unset($row);
        }
        elseif($sel_users === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * ID прикрепленных тренеров к пользователю
     *
     * @param $user_id
     * @return array
     */
    public function getAttachedCoachesId($user_id)
    {
        $result = array();

        $sel_coaches = $this->db->query('
            SELECT `uc_coach_id` 
            FROM `users_courses`
            WHERE `uc_user_id`=?', $user_id);

        if ($sel_coaches !== false and 0 < $sel_coaches->num_rows()) {
            $i = 0;
            foreach ($sel_coaches->result() as $row) {
                $result['id'][$i] = $row->uc_coach_id;

                $i++;
            }
            unset($row);
        }
        elseif($sel_coaches === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * ID прикрепленных пользователей к тренеру
     *
     * @param $user_id
     * @return array
     */
    public function getAttachedUsersId($user_id)
    {
        $result = array();

        $sel_users = $this->db->query('
            SELECT `uc_user_id` 
            FROM `users_courses`
            WHERE `uc_coach_id`=?', $user_id);

        if ($sel_users !== false and 0 < $sel_users->num_rows())
        {
            $i = 0;
            foreach ($sel_users->result() as $row)
            {
                $result['id'][$i] = $row->uc_user_id;

                $i++;
            }
            unset($row);
        }
        elseif($sel_users === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Выборка последних изображений из портфолио всех тренеров. Максимум 32
     *
     * @return array
     */
    public function getGallery()
    {
        $result = array('gallery' => array());

        $sel_images = $this->db->query('
            SELECT `cp_image_path`, `cp_image_title`, `cp_image_description`, `cp_id`
            FROM `coach_portfolio`
            WHERE `cp_image_approval`=1
            ORDER BY `cp_date_add` DESC
            LIMIT 32');
        if ($sel_images !== false and 0 < $sel_images->num_rows())
        {
            $i = 0;
            foreach ($sel_images->result() as $row)
            {
                if (is_file($row->cp_image_path))
                {
                    $result['gallery'][$i]['path']        = mb_substr($row->cp_image_path, 1);
                    $result['gallery'][$i]['title']       = $row->cp_image_title;
                    $result['gallery'][$i]['description'] = $row->cp_image_description;
                    $result['gallery'][$i]['post_id']     = $row->cp_id;

                    $i++;
                }
            }
            unset($row);
        }
        elseif($sel_images === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Изображения портфолио тренеров
     *
     * @return array
     */
    public function getCoachesPortfolioPosts()
    {
        $result = array('portfolio' => array());

        $sel_portfolio = $this->db->query('
            SELECT `cp_id`, `cp_image_title`, `cp_image_path`, `cp_image_description` FROM `coach_portfolio`');

        if ($sel_portfolio !== false and 0 < $sel_portfolio->num_rows())
        {
            $i = 0;
            foreach ($sel_portfolio->result() as $row)
            {
                if (is_file($row->cp_image_path))
                {
                    $result['portfolio'][$i]['image_id']   = $row->cp_id;
                    $result['portfolio'][$i]['image_path'] = mb_substr($row->cp_image_path, 1);
                    $result['portfolio'][$i]['image_desc'] = mb_substr($row->cp_image_description, 0, 65);

                    $i++;
                }
            }
            unset($row);
        }
        elseif($sel_portfolio === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Данные изображения портфолио тренера
     *
     * @return array
     */
    public function getCoachesPortfolioPost($post_id)
    {
        $result = array();

        $sel_post = $this->db->query('
            SELECT `cp_id`, `cp_image_title`, `cp_image_path`, `cp_image_description`, `cp_image_approval` 
            FROM `coach_portfolio` 
            WHERE `cp_id`=?
            LIMIT 1', array($post_id));

        if ($sel_post !== false and 1 == $sel_post->num_rows())
        {
            $row = $sel_post->row();

            $result['post']['id']       = $row->cp_id;
            $result['post']['title']    = !empty($row->cp_image_title) ? $row->cp_image_title : '';
            $result['post']['path']     = !empty($row->cp_image_path) ? mb_substr($row->cp_image_path, 1) : '';
            $result['post']['desc']     = $row->cp_image_description;
            $result['post']['approval'] = $row->cp_image_approval;
        }
        elseif($sel_post === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Сохранение изменений портфолио тренера
     *
     * @param int $user_id ID тренера
     * @param int $post_id ID записи портфолио
     * @param string|null $image Путь к изображению
     * @param string|null $title Заголовок
     * @param string|null $description Описание
     * @param string $date Дата
     * @return bool
     */
    public function updateCoachesPortfolio($post_id, $title = null, $description = null, $date)
    {
        $result = false;

        $up_data = $this->db->query('
            UPDATE `coach_portfolio`
            SET `cp_image_title`=?, `cp_image_description`=?, `cp_date_update`=?
            WHERE `cp_id`=? LIMIT 1', array($title, $description, $date, $post_id));

        if ($up_data !== false and 1 == $this->db->affected_rows())
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
     * Одобрение/блокировка записи портфолио тренера
     *
     * @param $post_id
     * @param $approval
     * @param $date
     * @return bool
     */
    public function approvalCoachesPortfolio($post_id, $approval, $date)
    {
        $result = false;

        $up_data = $this->db->query('
            UPDATE `coach_portfolio` SET `cp_image_approval`=?, `cp_date_update`=? WHERE `cp_id`=? LIMIT 1',
                array($approval, $date, $post_id));

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
     * Обработка данных тренера
     *
     * @param $row
     * @param $today
     * @return array
     */
    public function parseCoachData($row, $today = '')
    {
        $result['user_id']             = (!empty($row->user_id)) ? $row->user_id : '';
        $result['user_email']          = (!empty($row->user_email)) ? $row->user_email : '';
        $result['user_type']           = (!empty($row->user_type)) ? $row->user_type : '';
        $result['default_name']        = 'Страница тренера';
        $result['user_name']           = (!empty($row->user_name)) ? $row->user_name : '';
        $result['user_country_code']   = (!empty($row->user_country_code)) ? $row->user_country_code : '';
        $result['user_phone']          = (!empty($row->user_phone)) ? $row->user_phone : '';
        $result['user_image']          = (is_file($row->user_image)) ? mb_substr($row->user_image, 1) : '';
        $result['user_activated']      = (!empty($row->user_activated)) ? $row->user_activated : '';
        $result['user_activate_code']  = (!empty($row->user_activate_code)) ? $row->user_activate_code : '';
        $result['user_blocked']        = (!empty($row->user_blocked)) ? $row->user_blocked : '';
        $result['user_password']       = (!empty($row->user_password)) ? $row->user_password : '';
        $result['user_deleted']        = (!empty($row->user_deleted)) ? $row->user_deleted: 0;
        $result['user_delete_date']    = '';
        $result['user_delete_by']      = (!empty($row->user_delete_by)) ? $row->user_delete_by : 0;
        $result['user_new_email']      = (!empty($row->user_new_email)) ? $row->user_new_email : null;
        $result['user_ne_idempotent']  = (!empty($row->user_new_email_idempotent)) ? $row->user_new_email_idempotent : null;
        $result['user_changing_email'] = false;

        $split_name = (!empty($row->user_name)) ? explode(" ", $row->user_name) : '';
        $result['split_name']['name']    = !empty($split_name[0]) ? $split_name[0] : '';
        $result['split_name']['surname'] = !empty($split_name[1]) ? $split_name[1] : '';

        // Изменение email
        if(!empty($row->user_new_email) and !empty($row->user_new_email_idempotent))
        {
            $result['user_chaging_email'] = true;
        }

        $result['user_age']      = '';
        $result['user_b_day']    = '';
        $result['user_b_mon']    = '';
        $result['user_b_year']   = '';
        $result['user_birthday'] = (!empty($row->user_birthday) and $row->user_birthday != '0000-00-00') ? $row->user_birthday : '';
        if (!empty($today))
        {
            $bdate = DateTime::createFromFormat('Y-m-d', $row->user_birthday);
            $cdate = DateTime::createFromFormat('Y-m-d H:i:s', $today);

            $user_age = ($row->user_birthday != '0000-00-00' and $bdate !== false and $bdate->format('Y') != '0000')
                ? $cdate->diff($bdate)
                : '';

            if (!empty($user_age))
            {
                $age_string = parent::endingWords($user_age->format('%y'), 'год', 'лет', 'года');

                $result['user_age'] = $age_string;
            }
        }
        $date = DateTime::createFromFormat('Y-m-d', $row->user_birthday);
        $birthday = ($row->user_birthday != '0000-00-00' and $date !== false) ? $date->format('d.m.Y') : '';

        if (!empty($birthday))
        {
            $b_day  = $date->format('d');
            $b_mon  = $date->format('m');
            $b_year = $date->format('Y');

            $result['user_b_day']  = $b_day;
            $result['user_b_mon']  = $b_mon;
            $result['user_b_year'] = $b_year;
        }

        $result['user_gender']        = (!empty($row->user_gender) and $row->user_gender == 'female') ? 'Женщина' : 'Мужчина';
        $result['user_gender_eng']    = (!empty($row->user_gender) and $row->user_gender == 'female') ? 'female' : 'male';
        $result['user_gender_rus']    = (!empty($row->user_gender) and $row->user_gender == 'female') ? 'Женский' : 'Мужской';
        $result['user_special']       = (!empty($row->cd_specialization)) ? $row->cd_specialization : '';
        $result['user_experience']    = (!empty($row->cd_experience)) ? parent::endingWords($row->cd_experience, 'год', 'лет', 'года') : '';
        $result['user_experience_y']  = (!empty($row->cd_experience)) ? $row->cd_experience : '';
        $result['user_titles_awards'] = (!empty($row->cd_titles_awards)) ? $row->cd_titles_awards : '';
        $result['user_bbc_about']     = (!empty($row->cd_about)) ? nl2br(parent::showBBcodes($row->cd_about)) : '';
        $result['user_about']         = (!empty($row->cd_about)) ? $row->cd_about : '';

        return $result;
    }
}