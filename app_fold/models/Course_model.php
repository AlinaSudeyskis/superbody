<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Класс Course_model
 * 
 * Класс выбора, сохранения и добавления данных курса
 *
 * @author Alina Sudeyskis <alina.sudeyskis@gmail.com>
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Course_model extends CI_Model
{
    /* НАЧАЛО БЛОКА ОБРАБОТКИ ДАННЫХ КАТЕГОРИИ КУРСА */

    /**
     * Сохранение нового типа курса
     *
     * @param $name
     * @param $date
     * @return bool
     */
    public function setNewCourseType($name, $date)
    {
        $up_data = $this->db->query('
            INSERT INTO `course_type` (`ct_name`, `ct_date_add`, `ct_date_update`) 
            VALUES (?, ?, ?)', array($name, $date, $date));

        if ($up_data !== false and 1 == $this->db->affected_rows())
        {
            return $this->db->insert_id();
        }
        elseif ($up_data === false)
        {
            parent::logDbMessages(__METHOD__);
            return false;
        }
        else {
            return false;
        }
    }

    /**
     * Сохранение данных типа курса
     *
     * @param $type_id
     * @param $name
     * @param $date
     * @return bool
     */
    public function setCourseTypeSettings($type_id, $name, $date)
    {
        $up_data = $this->db->query('UPDATE `course_type` SET `ct_name`=?, `ct_date_update`=? WHERE `ct_id`=? LIMIT 1',
            array($name, $date, $type_id));

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
     * Получение данных типа курса
     *
     * @param $type_id
     * @return array
     */
    public function getCourseType($type_id)
    {
        // Результат
        $result = array('type_name' => '');

        $sel_course_type = $this->db->query('SELECT `ct_name` FROM `course_type` WHERE `ct_id`=? LIMIT 1', $type_id);

        if ($sel_course_type !== false and 1 == $sel_course_type->num_rows())
        {
            $row = $sel_course_type->row();

            $result['type_name'] = $row->ct_name;
        }
        elseif ($sel_course_type === false)
        {
            parent::logDbMessages(__METHOD__);
        }

        return $result;
    }

    /**
     * Выборка последних добавленных типов курсов
     *
     * @return array
     */
    public function getCourseTypes()
    {
        // Результат
        $result = array();

        $sel_types = $this->db->query('SELECT `ct_id`, `ct_name` FROM `course_type` ORDER BY `ct_date_update` DESC');

        if ($sel_types !== false and 0 < $sel_types->num_rows())
        {
            $i = 0;
            foreach ($sel_types->result() as $row)
            {
                $result['types'][$i]['id'] = $row->ct_id;
                $result['types'][$i]['name'] = $row->ct_name;
                
                $result['types_id'][$i] = $row->ct_id;
                
                $i++;
            }
            unset($row);
        }
        elseif ($sel_types === false)
        {
            parent::logDbMessages(__METHOD__);
        }

        return $result;
    }

    /**
     * Выборка доступных типов курсов
     *
     * @return array
     */
    public function getAvailableCourseTypes()
    {
        // Результат
        $result = array();

        $sel_types = $this->db->query('
          SELECT `ct_id`, `ct_name` FROM `course_type` 
          WHERE `ct_blocked`=0 
          ORDER BY `ct_name` DESC');

        if ($sel_types !== false and 0 < $sel_types->num_rows())
        {
            $i = 0;
            foreach ($sel_types->result() as $row)
            {
                $result['course_types'][$i]['id']   = $row->ct_id;
                $result['course_types'][$i]['name'] = $row->ct_name;

                $i++;
            }
            unset($row);
        }
        elseif ($sel_types === false)
        {
            parent::logDbMessages(__METHOD__);
        }

        return $result;
    }

    /* КОНЕЦ БЛОКА ОБРАБОТКИ ДАННЫХ КАТЕГОРИИ КУРСА */


    /* НАЧАЛО БЛОКА ОБРАБОТКИ ДАННЫХ КАТЕГОРИИ ПРИМА ПИЩИ */

    /**
     * Сохранение нового типа приема пищи
     *
     * @param $name
     * @param $date
     * @return bool
     */
    public function setNewIngestionType($name, $date)
    {
        $up_data = $this->db->query('
            INSERT INTO `ingestions_type` (`it_name`, `it_date_add`, `it_date_update`) 
            VALUES (?, ?, ?)', array($name, $date, $date));

        if ($up_data !== false and 1 == $this->db->affected_rows())
        {
            return $this->db->insert_id();
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
     * Сохранение данных типа приема пищи
     *
     * @param $type_id
     * @param $name
     * @param $date
     * @return bool
     */
    public function setIngestionTypeSettings($type_id, $name, $date)
    {
        $up_data = $this->db->query('UPDATE `ingestions_type` SET `it_name`=?, `it_date_update`=? WHERE `it_id`=? LIMIT 1',
            array($name, $date, $type_id));

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
     * Получение данных типа приема пищи
     *
     * @param $type_id
     * @return array
     */
    public function getIngestionType($type_id)
    {
        // Результат
        $result = array('type_name' => '');

        $sel_course_type = $this->db->query('SELECT `it_name` FROM `ingestions_type` WHERE `it_id`=? LIMIT 1', $type_id);

        if ($sel_course_type !== false and 1 == $sel_course_type->num_rows())
        {
            $row = $sel_course_type->row();

            $result['type_name'] = $row->it_name;
        }
        elseif ($sel_course_type === false)
        {
            parent::logDbMessages(__METHOD__);
        }

        return $result;
    }

    /**
     * Выборка последних добавленных типов приема пищи
     *
     * @return array
     */
    public function getIngestionTypes()
    {
        // Результат
        $result = array();

        $sel_types = $this->db->query('SELECT `it_id`, `it_name` FROM `ingestions_type` ORDER BY `it_date_update` DESC');

        if ($sel_types !== false and 0 < $sel_types->num_rows())
        {
            $i = 0;
            foreach ($sel_types->result() as $row)
            {
                $result['types'][$i]['id'] = $row->it_id;
                $result['types'][$i]['name'] = $row->it_name;

                $i++;
            }
            unset($row);
        }
        elseif ($sel_types === false)
        {
            parent::logDbMessages(__METHOD__);
        }

        return $result;
    }

    /* КОНЕЦ БЛОКА ОБРАБОТКИ ДАННЫХ КАТЕГОРИИ ПРИЕМА ПИЩИ */


    /* НАЧАЛО БЛОКА ОБРАБОТКИ ДАННЫХ ПРИЕМА ПИЩИ */

    /**
     * Сохранение нового приема пищи
     *
     * @param string $name Наименование
     * @param int $type_id Тип приема пищи
     * @param string $time_additives Время приема добавок
     * @param datetime $date Текущее время
     * @return bool
     */
    public function setNewIngestion($name, $type_id, $time_additives, $date)
    {
        $up_data = $this->db->query('
            INSERT INTO `ingestions` (`ing_name`, `ing_type_id`, `time_additives`, `ing_date_add`, `ing_date_update`) 
            VALUES (?, ?, ?, ?, ?)', array($name, $type_id, $time_additives, $date, $date));

        if ($up_data !== false and 1 == $this->db->affected_rows())
        {
            return $this->db->insert_id();
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
     * Сохранение данных приема пищи
     *
     * @param int $ing_id ID приема пищи
     * @param string $name Наименование
     * @param int $type_id Тип приема пищи
     * @param string $time_additives Время приема добавок
     * @param datetime $date Текущее время
     * @return bool
     */
    public function setIngestionSettings($ing_id, $name, $type_id, $time_additives, $date)
    {
        $up_data = $this->db->query('
            UPDATE `ingestions` 
            SET `ing_name`=?, `ing_type_id`=?, `time_additives`=?, `ing_date_update`=? 
            WHERE `ing_id`=? LIMIT 1', array($name, $type_id, $time_additives, $date, $ing_id));

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
     * Получение данных приема пищи
     *
     * @param int $ing_id ID приема пищи
     * @return array
     */
    public function getIngestion($ing_id)
    {
        // Результат
        $result = array();

        $sel_course_type = $this->db->query('
            SELECT `ing_name`, `ing_type_id`, `time_additives` 
            FROM `ingestions` 
            WHERE `ing_id`=? LIMIT 1', $ing_id);

        if ($sel_course_type !== false and 1 == $sel_course_type->num_rows())
        {
            $row = $sel_course_type->row();

            $result['ing_name']       = $row->ing_name;
            $result['ing_type_id']    = $row->ing_type_id;
            $result['before_after']   = 'after';
            $result['time_additives'] = $row->time_additives;

            if ('-' == mb_substr($row->time_additives, 0, 1))
            {
                $result['before_after'] = 'before';
                $result['time_additives'] = mb_substr($row->time_additives, 1);
            }
        }
        elseif ($sel_course_type === false)
        {
            parent::logDbMessages(__METHOD__);
        }

        return $result;
    }

    /**
     * Выборка последних добавленных приемов пищи
     *
     * @return array
     */
    public function getIngestions()
    {
        // Результат
        $result = array();

        $sel_types = $this->db->query('SELECT `ing_id`, `ing_name` FROM `ingestions` ORDER BY `ing_date_update` DESC');

        if ($sel_types !== false and 0 < $sel_types->num_rows())
        {
            $i = 0;
            foreach ($sel_types->result() as $row)
            {
                $result['ingestions'][$i]['id'] = $row->ing_id;
                $result['ingestions'][$i]['name'] = $row->ing_name;

                $i++;
            }
            unset($row);
        }
        elseif ($sel_types === false)
        {
            parent::logDbMessages(__METHOD__);
        }

        return $result;
    }

    /* КОНЕЦ БЛОКА ОБРАБОТКИ ДАННЫХ ПРИЕМА ПИЩИ */


    /* НАЧАЛО БЛОКА ОБРАБОТКИ ДАННЫХ КУРСА */

    /**
     * Выборка всех курсов
     *
     * @return array
     */
    public function getCourses()
    {
        $result['courses'] = array();
        
        $sel_courses = $this->db->query('
            SELECT `crs_id`, `crs_image`, `crs_name`, `clp_id`, `clp_activated` 
            FROM `courses`
            LEFT JOIN `courses_landing_pages` ON `clp_course_id`=`crs_id`');
        
        if ($sel_courses !== false and 0 < $sel_courses->num_rows())
        {
            $i = 0;
            foreach ($sel_courses->result() as $row)
            {
                $result['courses'][$i] = self::parseCourseData($row);

                $i++;
            }
            unset($row);
        }
        elseif ($sel_courses === false)
        {
            parent::logDbMessages(__METHOD__);
        }
        
        return $result;
    }

    /**
     * Выборка доступных (не заблокированных) для пользователей курсов
     *
     * @return array
     */
    public function getAvailableCourses()
    {
        $result['courses'] = array();

        $sel_courses = $this->db->query('
            SELECT `crs_id`, `crs_name`, `crs_image`, `crs_description`, `clp_id`, `clp_activated` 
            FROM `courses` 
            LEFT JOIN `courses_landing_pages` ON `clp_course_id`=`crs_id`
            WHERE `crs_blocked`=0 LIMIT 12');

        if ($sel_courses !== false and 0 < $sel_courses->num_rows())
        {
            $i = 0;
            foreach ($sel_courses->result() as $row)
            {
                $result['courses'][$i] = self::parseCourseData($row);

                // Тренеры курса
                $couches = self::getCourseCouches($row->crs_id);
                $result['courses'][$i] = array_merge($result['courses'][$i], $couches);

                $i++;
            }
            unset($row);
        }
        elseif ($sel_courses === false)
        {
            parent::logDbMessages(__METHOD__);
        }

        return $result;
    }

    /**
     * Выборка данных курса, доступного для пользователей курсов
     *
     * @param $course_id
     * @return array
     */
    public function getAvailableCourse($course_id)
    {
        $result['course'] = NULL;

        $sel_course = $this->db->query('
            SELECT `crs_id`, `crs_image`, `crs_name`, `crs_description`, `crs_type_id`, `crs_count_weeks`, `crs_count_days`, 
              `crs_price`, `crs_recurrent_price`, `crs_recurrent_months`, `crs_recurrent_first`, `crs_recurrent_subsequent`, 
              `crs_fitcoin_price`, `crs_count_rest`, `crs_blocked`, `clp_id`, `clp_activated`, `p_id`
            FROM `courses`
            LEFT JOIN `products` ON `p_course_id`=`crs_id`
            LEFT JOIN `courses_landing_pages` ON `clp_course_id`=`crs_id`
            WHERE `crs_id`=? and `crs_blocked`=0 LIMIT 1', $course_id);

        if ($sel_course !== false and 1 == $sel_course->num_rows())
        {
            $row = $sel_course->row();

            $result['course'] = self::parseCourseData($row);

            // Скидка на курс от тренеров
            $discount = 0;

            $sel_course->free_result();

            // Расписание курса (недели, дни, видео)
            $sel_schedule = $this->db->query('
                SELECT `ctw_num_workout`, `ctw_description`, `ctw_video_id`, `ctw_repeat_workout`, 
                  `video_name`, `video_path`, `video_poster`, `video_remove_url`
                FROM `courses_training_weeks`
                LEFT JOIN `video` ON `video_id`=`ctw_video_id`
                WHERE `ctw_course_id`=?
                ORDER BY `ctw_num_workout`', $course_id);
            if ($sel_schedule !== false and 0 < $sel_schedule->num_rows())
            {
                foreach ($sel_schedule->result() as $row)
                {
                    $num_workout = $row->ctw_num_workout;

                    $result['course']['workouts'][$num_workout]['repeat_workout'] = $row->ctw_repeat_workout;
                    $result['course']['workouts'][$num_workout]['description']    = $row->ctw_description;

                    if ($row->ctw_repeat_workout > 0)
                    {
                        $video_id       = $result['course']['workouts'][$row->ctw_repeat_workout]['video_id'];
                        $video_name     = $result['course']['workouts'][$row->ctw_repeat_workout]['video_name'];
                        $video_poster   = $result['course']['workouts'][$row->ctw_repeat_workout]['video_poster'];
                        $video_path     = $result['course']['workouts'][$row->ctw_repeat_workout]['video_path'];
                        $video_remove   = $result['course']['workouts'][$row->ctw_repeat_workout]['video_remove'];
                    }
                    else
                    {
                        $video_id       = $row->ctw_video_id;
                        $video_name     = $row->video_name;
                        $video_poster   = mb_substr($row->video_poster, 1);
                        $video_path     = mb_substr($row->video_path, 1);
                        $video_remove   = $row->video_remove_url;
                    }

                    $result['course']['workouts'][$num_workout]['video_id']       = $video_id;
                    $result['course']['workouts'][$num_workout]['video_name']     = $video_name;
                    $result['course']['workouts'][$num_workout]['video_poster']   = $video_poster;
                    $result['course']['workouts'][$num_workout]['video_path']     = $video_path;
                    $result['course']['workouts'][$num_workout]['video_remove']   = $video_remove;

                }
                unset($row);
            }
            elseif ($sel_schedule === false)
            {
                parent::logDbMessages(__METHOD__);
            }
            $sel_schedule->free_result();

            // Тренеры курса
            $sel_couches = $this->db->query('
                SELECT `cc_couch_id`, `cc_percent`, `cc_discount`, `user_name`, `user_email`
                FROM `courses_couches`
                LEFT JOIN `users` ON `cc_couch_id`=`users`.`user_id`
                WHERE `cc_course_id`=?', $course_id);
            if ($sel_couches !== false and 0 < $sel_couches->num_rows())
            {
                $i = 0;
                foreach ($sel_couches->result() as $row)
                {

                    $result['course']['couches'][$i]['id']       = $row->cc_couch_id;
                    $result['course']['couches'][$i]['name']     = !empty(($row->user_name)) ? $row->user_name : $row->user_email;
                    $result['course']['couches'][$i]['percent']  = $row->cc_percent;
                    $result['course']['couches'][$i]['discount'] = $row->cc_discount;

                    $discount += $row->cc_discount;

                    $i++;
                }
                unset($row);
            }
            elseif ($sel_couches === false)
            {
                parent::logDbMessages(__METHOD__);
            }
            $sel_couches->free_result();

            // Вычисление новой цены на курс
            if ($discount > 0) {
                if (!empty($result['course']['price'])) {
                    $percent = $result['course']['price'] * $discount / 100;
                    $result['course']['new_price'] = number_format(($result['course']['price'] - $percent), 2, '.', '');
                }
                if (!empty($result['course']['fc_price'])) {
                    $percent = $result['course']['fc_price'] * $discount / 100;
                    $result['course']['new_fc_price'] = number_format(($result['course']['fc_price'] - $percent), 3, '.', '');
                }
            }

            // Проверка, покупал ли кто-то курс
            $bought = false;
            $sel_users = $this->db->query('
                SELECT COUNT(`uc_user_id`) as `count_users` FROM `users_courses` WHERE `uc_course_id`=?', $course_id);
            if ($sel_users !== false and 1 == $sel_users->num_rows())
            {
                $row = $sel_users->row();

                if (0 < $row->count_users)
                {
                    $bought = true;
                }
            }
            elseif ($sel_users === false)
            {
                parent::logDbMessages(__METHOD__);
            }
            $sel_users->free_result();
            $result['course']['bought'] = $bought;
        }
        elseif ($sel_course === false)
        {
            parent::logDbMessages(__METHOD__);
        }

        return $result;
    }

    /**
     * Выборка данных курса
     *
     * @param $course_id
     * @return array
     */
    public function getCourse($course_id)
    {
        $result['course'] = array();

        $sel_course = $this->db->query('
            SELECT `crs_id`, `crs_image`, `crs_name`, `crs_description`, `crs_type_id`, `crs_count_weeks`, `crs_count_days`, 
              `crs_price`, `crs_fitcoin_price`, `crs_recurrent_price`, `crs_recurrent_months`, `crs_recurrent_first`, 
              `crs_recurrent_subsequent`, `crs_count_rest`, `crs_blocked`, `clp_id`, `clp_activated`
            FROM `courses`
            LEFT JOIN `courses_landing_pages` ON `clp_course_id`=`crs_id`
            WHERE `crs_id`=? LIMIT 1', $course_id);

        if ($sel_course !== false and 1 == $sel_course->num_rows())
        {
            $row = $sel_course->row();

            $result['course'] = self::parseCourseData($row);

            // Скидка на курс от тренеров
            $discount = 0;

            $sel_course->free_result();

            // Расписание курса (недели, дни, видео)
            $sel_schedule = $this->db->query('
                SELECT `ctw_num_workout`, `ctw_description`, `ctw_video_id`, `ctw_repeat_workout`, 
                  `video_name`, `video_path`, `video_poster`, `video_remove_url`
                FROM `courses_training_weeks`
                LEFT JOIN `video` ON `video_id`=`ctw_video_id`
                WHERE `ctw_course_id`=?
                ORDER BY `ctw_num_workout`
                LIMIT 336', $course_id);
            if ($sel_schedule !== false and 0 < $sel_schedule->num_rows())
            {
                foreach ($sel_schedule->result() as $row)
                {
                    $num_workout = $row->ctw_num_workout;

                    if ($num_workout == 0)
                    {
                        $result['course']['instruction']['video_id']     = $row->ctw_video_id;
                        $result['course']['instruction']['video_name']   = $row->video_name;
                        $result['course']['instruction']['video_poster'] = is_file($row->video_poster) ? mb_substr($row->video_poster, 1) : '';
                        $result['course']['instruction']['video_path']   = is_file($row->video_path) ? mb_substr($row->video_path, 1) : '';
                        $result['course']['instruction']['video_remove'] = $row->video_remove_url;
                    }
                    else
                    {
                        $result['course']['workouts'][$num_workout]['repeat_workout'] = $row->ctw_repeat_workout;
                        $result['course']['workouts'][$num_workout]['description']    = $row->ctw_description;

                        if ($row->ctw_repeat_workout > 0)
                        {
                            $video_id       = $result['course']['workouts'][$row->ctw_repeat_workout]['video_id'];
                            $video_name     = $result['course']['workouts'][$row->ctw_repeat_workout]['video_name'];
                            $video_poster   = $result['course']['workouts'][$row->ctw_repeat_workout]['video_poster'];
                            $video_path     = $result['course']['workouts'][$row->ctw_repeat_workout]['video_path'];
                            $video_remove   = $result['course']['workouts'][$row->ctw_repeat_workout]['video_remove'];
                        }
                        else
                        {
                            $video_id       = $row->ctw_video_id;
                            $video_name     = $row->video_name;
                            $video_poster   = is_file($row->video_poster) ? mb_substr($row->video_poster, 1) : '';
                            $video_path     = is_file($row->video_path) ? mb_substr($row->video_path, 1) : '';
                            $video_remove   = $row->video_remove_url;
                        }

                        $result['course']['workouts'][$num_workout]['video_id']       = $video_id;
                        $result['course']['workouts'][$num_workout]['video_name']     = $video_name;
                        $result['course']['workouts'][$num_workout]['video_poster']   = $video_poster;
                        $result['course']['workouts'][$num_workout]['video_path']     = $video_path;
                        $result['course']['workouts'][$num_workout]['video_remove']   = $video_remove;
                    }
                }
                unset($row);
            }
            elseif ($sel_schedule === false)
            {
                parent::logDbMessages(__METHOD__);
            }
            $sel_schedule->free_result();

            // Тренеры курса
            $sel_couches = $this->db->query('
                SELECT `cc_couch_id`, `cc_percent`, `cc_discount`, `user_name`, `user_email`
                FROM `courses_couches`
                LEFT JOIN `users` ON `cc_couch_id`=`users`.`user_id`
                WHERE `cc_course_id`=?', $course_id);
            if ($sel_couches !== false and 0 < $sel_couches->num_rows())
            {
                $i = 0;
                foreach ($sel_couches->result() as $row)
                {

                    $result['course']['couches'][$i]['id']       = $row->cc_couch_id;
                    $result['course']['couches'][$i]['name']     = !empty(($row->user_name)) ? $row->user_name : $row->user_email;
                    $result['course']['couches'][$i]['percent']  = $row->cc_percent;
                    $result['course']['couches'][$i]['discount'] = $row->cc_discount;

                    $discount += $row->cc_discount;

                    $i++;
                }
                unset($row);
            }
            elseif ($sel_couches === false)
            {
                parent::logDbMessages(__METHOD__);
            }
            $sel_couches->free_result();

            // Вычисление новой цены на курс
            if ($discount > 0) {
                if (!empty($result['course']['price'])) {
                    $percent = $result['course']['price'] * $discount / 100;
                    $result['course']['new_price'] = number_format(($result['course']['price'] - $percent), 2, '.', '');
                }
                if (!empty($result['course']['fc_price'])) {
                    $percent = $result['course']['fc_price'] * $discount / 100;
                    $result['course']['new_fc_price'] = number_format(($result['course']['fc_price'] - $percent), 3, '.', '');
                }
            }

            // Проверка, покупал ли кто-то курс
            $bought = false;
            $sel_users = $this->db->query('
                SELECT COUNT(`uc_user_id`) as `count_users` FROM `users_courses` WHERE `uc_course_id`=?', $course_id);
            if ($sel_users !== false and 1 == $sel_users->num_rows())
            {
                $row = $sel_users->row();

                if (0 < $row->count_users)
                {
                    $bought = true;
                }
            }
            elseif ($sel_users === false)
            {
                parent::logDbMessages(__METHOD__);
            }
            $sel_users->free_result();
            $result['course']['bought'] = $bought;
        }
        elseif ($sel_course === false)
        {
            parent::logDbMessages(__METHOD__);
        }

        return $result;
    }

    /**
     * Краткие данные о курсе
     *
     * @param $course_id
     * @return mixed
     */
    public function getShortCourse($course_id)
    {
        $result['course'] = NULL;

        $sel_course = $this->db->query('
            SELECT `crs_id`, `crs_image`, `crs_name`, `crs_description`
            FROM `courses`
            LEFT JOIN `courses_landing_pages` ON `clp_course_id`=`crs_id`
            WHERE `crs_id`=? LIMIT 1', $course_id);

        if ($sel_course !== false and 1 == $sel_course->num_rows())
        {
            $row = $sel_course->row();

            $result['course'] = self::parseCourseData($row);

            // Скидка на курс от тренеров
            $discount = 0;

            $sel_course->free_result();

            // Скидки тренеров курса
            $sel_couches = $this->db->query('
                SELECT `cc_couch_id`, `cc_percent`, `cc_discount`, `user_name`, `user_email`
                FROM `courses_couches`
                LEFT JOIN `users` ON `cc_couch_id`=`users`.`user_id`
                WHERE `cc_course_id`=?', $course_id);
            if ($sel_couches !== false and 0 < $sel_couches->num_rows())
            {
                $i = 0;
                foreach ($sel_couches->result() as $row)
                {
                    $discount += $row->cc_discount;

                    $i++;
                }
                unset($row);
            }
            elseif ($sel_couches === false)
            {
                parent::logDbMessages(__METHOD__);
            }
            $sel_couches->free_result();

            // Вычисление новой цены на курс
            if ($discount > 0) {
                if (!empty($result['course']['price'])) {
                    $percent = $result['course']['price'] * $discount / 100;
                    $result['course']['new_price'] = number_format(($result['course']['price'] - $percent), 2, '.', '');
                }
                if (!empty($result['course']['fc_price'])) {
                    $percent = $result['course']['fc_price'] * $discount / 100;
                    $result['course']['new_fc_price'] = number_format(($result['course']['fc_price'] - $percent), 3, '.', '');
                }
            }
        }
        elseif ($sel_course === false)
        {
            parent::logDbMessages(__METHOD__);
        }

        return $result;
    }

    /**
     * Выборка статистических данных курса
     *
     * @param $course_id
     * @return array
     */
    public function getStatistics($course_id)
    {
        $result = array();

        $sel_pid = $this->db->query('
          SELECT `p_id`, `p_course_id`
          FROM `products`
          WHERE `p_course_id`=? LIMIT 1', $course_id);

        if ($sel_pid !== false and 1 == $sel_pid->num_rows())
        {
            $row = $sel_pid->row();
            $course_pid = $row->p_id;
            unset($row);

            $sel_data = $this->db->query('
              SELECT `ouc_u_id`, `ouc_p_price`, `ouc_p_fitcoin_price`
              FROM `orders_users_cart`
              WHERE `ouc_p_id`=?', $course_pid);
            if ($sel_data !== false and 0 < $sel_data->num_rows())
            {
                $count_users = 0;
                $count_price = 0;
                $i = 0;
                foreach($sel_data->result() as $row)
                {
                    $count_users++;
                    $count_price += $row->ouc_p_price;

                    $i++;
                }
                unset($row);

                $result['statistics']['count_users'] = $count_users;
                $result['statistics']['count_price'] = $count_price;
            }
            elseif($sel_data === false)
            {
                parent::logDbMessages(__METHOD__);
            }

        }
        elseif ($sel_pid === false)
        {
            parent::logDbMessages(__METHOD__);
        }

        return $result;
    }

    /**
     * Сохранение нового курса
     *
     * @param string $name Наименование курса
     * @param string $description Описание курса
     * @param float $price Стоимость курса
     * @param float $fc_price Стоимость курса
     * @param int $course_type Тип курса
     * @param int $count_weeks Длительность курса. Количество недель
     * @param int $count_days Количество дней тренировок в неделю
     * @param int $count_rest Отдых между тренировками (дн.)
     * @param int $user_id Пользователь добавивший курс
     * @param string $date
     * @return bool
     */
    public function setNewCourse($name, $description, $price, $fc_price, $course_type, $count_weeks, $count_days, $count_rest,
                                 $user_id, $date)
    {
        $up_data = $this->db->query('
            INSERT INTO `courses` (`crs_type_id`, `crs_name`, `crs_description`, `crs_price`, `crs_fitcoin_price`, `crs_count_weeks`, 
              `crs_count_days`, `crs_count_rest`, `crs_admin_add`, `crs_date_add`, `crs_date_update`) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)',
            array($course_type, $name, $description, $price, $fc_price, $count_weeks, $count_days, $count_rest, $user_id, $date, $date));

        if ($up_data !== false and 1 == $this->db->affected_rows())
        {
            $course_id = $this->db->insert_id();

            // Сохранение курса как товара в интернет-магазине
            $up_data2 = $this->db->query('
              INSERT INTO `products` 
                (`p_course_id`, `p_date_add`, `p_date_update`, `p_admin_id`) 
                VALUES (?, ?, ?, ?)', array($course_id, $date, $date, $user_id));
            if ($up_data2 !== false and 1 == $this->db->affected_rows())
            {
                $p_id = $this->db->insert_id();

                // Категория товара
                $in_data2 = $this->db->query('
                    INSERT INTO `products_categories` (`pc_p_id`, `pc_cat_id`, `pc_date_update`, `pc_admin_id`)
                    VALUES (?, ?, ?, ?)', array($p_id, 0, $date, $user_id));
                if ($in_data2 === false)
                {
                    parent::logDbMessages(__METHOD__);
                }
            }
            if ($up_data2 === false)
            {
                parent::logDbMessages(__METHOD__);
            }

            // Создание Landing page курса
            $up_data3 = $this->db->query('INSERT INTO `courses_landing_pages`
              (`clp_course_id`, `clp_lp_id`, `clp_slider_images`, `clp_block2_background`, `clp_block2_image`,  
              `clp_block3_background`, `clp_block3_images`, `clp_block4_background`, `clp_block4_image`,  
              `clp_block5_background`, `clp_block5_images`, `clp_block6_background`, `clp_block6_image`, 
              `clp_block7_background`, `clp_block8_background`, `clp_block8_title`, 
              `clp_admin_id`, `clp_date_add`, `clp_date_update`) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)',
                array($course_id, 1, 'default', 'default', 'default', 'default', 'default;default;', 'default', 'default',
                    'default', 'default;default;default;', 'default', 'default', 'default', 'default;default;',
                    'default', $user_id, $date, $date));

            if ($up_data3 === false)
            {
                parent::logDbMessages(__METHOD__);
            }

            return $course_id;
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
     * Сохранение изображения нового курса
     *
     * @param int $course_id
     * @param string $image
     * @return bool
     */
    public function setCourseImage($course_id, $image)
    {
        $up_data = $this->db->query('UPDATE `courses` SET `crs_image`=? WHERE `crs_id`=? LIMIT 1', array($image, $course_id));

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
     * Сохранение изменений данных курса
     *
     * @param int $course_id
     * @param string|null $image
     * @param string $name
     * @param string $description
     * @param float $price
     * @param float|null $fc_price
     * @param int $course_type
     * @param int $count_weeks
     * @param int $count_days
     * @param int $count_rest
     * @param datetime $date
     * @return bool
     */
    public function setCourseSettings($course_id, $image = null, $name, $description, $price, $fc_price = null, $course_type, $count_weeks, $count_days,
                                      $count_rest, $date)
    {
        $up_data = $this->db->query('
          UPDATE `courses` SET `crs_type_id`=?, `crs_image`=?, `crs_name`=?, `crs_description`=?, `crs_price`=?, `crs_fitcoin_price`=?,
            `crs_count_weeks`=?, `crs_count_days`=?, `crs_count_rest`=?, `crs_date_update`=? 
          WHERE `crs_id`=? LIMIT 1', array($course_type, $image, $name, $description, $price, $fc_price, $count_weeks, $count_days,
            $count_rest, $date, $course_id));
        
        if ($up_data !== false and 1 == $this->db->affected_rows())
        {
            $up_data2 = $this->db->query('
                UPDATE `products` SET `p_name`=?, `p_full_description`=?, `p_price`=?, `p_fitcoin_price`=?, `p_date_update`=?
                WHERE `p_course_id`=? LIMIT 1', array($name, $description, $price, $fc_price, $date, $course_id));
            if ($up_data2 === false)
            {
                parent::logDbMessages(__METHOD__);
            }

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
     * Блокировка курса
     *
     * @param $course_id
     * @param $date
     * @return bool
     */
    public function blockCourse($course_id, $date)
    {
        $up_data = $this->db->query('UPDATE `courses` SET `crs_blocked`=1, `crs_date_update`=? WHERE `crs_id`=? LIMIT 1',
            array($date, $course_id));

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
     * Разблокировка курса
     *
     * @param $course_id
     * @param $date
     * @return bool
     */
    public function unblockCourse($course_id, $date)
    {
        $up_data = $this->db->query('UPDATE `courses` SET `crs_blocked`=0, `crs_date_update`=? WHERE `crs_id`=? LIMIT 1',
            array($date, $course_id));

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
     * Сохранение данных рекуррентной цены курса
     *
     * @param int $course_id
     * @param float $recur_price
     * @param int $recur_months
     * @param float $recur_first
     * @param float $recur_subsequent
     * @param string $date
     * @return bool
     */
    public function setCourseRecurrentPrice($course_id, $recur_price, $recur_months, $recur_first, $recur_subsequent, $date)
    {
        $up_data = $this->db->query('UPDATE `courses` 
            SET `crs_recurrent_price`=?, `crs_recurrent_months`=?, `crs_recurrent_first`=?, `crs_recurrent_subsequent`=?, `crs_date_update`=?
            WHERE `crs_id`=? LIMIT 1',
            array($recur_price, $recur_months, $recur_first, $recur_subsequent, $date, $course_id));

        if ($up_data !== false and 1 == $this->db->affected_rows())
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

    /**
     * Получение рекуррентных данных курсов
     *
     * @param array $courses
     * @return array
     */
    public function getCourseRecurrentData($courses)
    {
        $result = array();

        if(!empty($courses))
        {
            $i = 0;
            foreach ($courses as $course)
            {
                if (is_numeric($course['id']))
                {
                    $sel_data = $this->db->query('
                        SELECT `crs_recurrent_price`, `crs_recurrent_months`, `crs_recurrent_first`, `crs_recurrent_subsequent`
                        FROM `courses`
                        WHERE `crs_id`=? LIMIT 1', $course['id']);
                    if($sel_data !== false and 1 == $sel_data->num_rows())
                    {
                        $row = $sel_data->row();

                        $result['courses'][$i]['recur_price']   = (!empty($row->crs_recurrent_price) and $row->crs_recurrent_price != '0.00') ? $row->crs_recurrent_price : null;
                        $result['courses'][$i]['recur_months']  = (!empty($row->crs_recurrent_months) and $row->crs_recurrent_months != 0) ? $row->crs_recurrent_months : null;
                        $result['courses'][$i]['recur_first']   = (!empty($row->crs_recurrent_first) and $row->crs_recurrent_first != '0.00') ? $row->crs_recurrent_first : null;
                        $result['courses'][$i]['recur_subsequent'] = (!empty($row->crs_recurrent_subsequent) and $row->crs_recurrent_subsequent != '0.00') ? $row->crs_recurrent_subsequent : null;
                        $result['courses'][$i]['recurrent']     = false;

                        if (!empty($result['courses'][$i]['recur_price']) and !empty($result['courses'][$i]['recur_months'])
                            and !empty($result['courses'][$i]['recur_first']) and !empty($result['courses'][$i]['recur_subsequent']))
                        {
                            $result['courses'][$i]['recurrent'] = true;
                        }

                        $i++;
                        unset($row);
                    }
                    elseif($sel_data)
                    {
                        parent::logDbMessages(__METHOD__);
                    }
                }
            }
            unset($course);
        }

        return $result;
    }

    /* КОНЕЦ БЛОКА ОБРАБОТКИ ДАННЫХ КУРСА */


    /* НАЧАЛО БЛОКА ОБРАБОТКИ ДАННЫХ ТРЕНИРОВОК КУРСА */

    /**
     * Выборка тренировок курса (для сравнения с данными изменения курса)
     *
     * @param $course_id
     * @return array
     */
    public function getCourseSchedule($course_id)
    {
        $result = array();

        $sel_schedule = $this->db->query('
            SELECT `ctw_num_workout`, `ctw_description`, `ctw_video_id`, `ctw_repeat_workout`
            FROM `courses_training_weeks`
            WHERE `ctw_course_id`=?', $course_id);

        if ($sel_schedule !== false and 0 < $sel_schedule->num_rows())
        {
            foreach ($sel_schedule->result() as $row)
            {
                $num_workout = $row->ctw_num_workout;

                $result['num_workout'][$num_workout]    = $row->ctw_num_workout;
                $result['repeat_workout'][$num_workout] = $row->ctw_repeat_workout;
                $result['description'][$num_workout]    = $row->ctw_description;

                $video_id = $row->ctw_repeat_workout > 0 ? $result['video_id'][$row->ctw_repeat_workout] : $row->ctw_video_id;

                $result['video_id'][$num_workout] = $video_id;
            }
            unset($row);
        }
        elseif ($sel_schedule === false)
        {
            parent::logDbMessages(__METHOD__);
        }

        return $result;
    }

    /**
     * Изменение и/или добавление расписания курса
     *
     * @param int $course_id Курс ID
     * @param array $schedule Расписание
     * @param int $user_id ID администратора
     * @param $date
     * @return bool
     */
    public function setCourseSchedule($course_id, $schedule, $user_id, $date)
    {
        $result = true;

        // Добавление новых тренировок
        if (!empty($schedule['insert'])) {
            $values = '';
            foreach ($schedule['insert'] as $num_workout => $workout) {
                if (!empty($values)) {
                    $values .= ', ';
                }

                $values .= '(' . $course_id .', ' . $num_workout . ', "' . $workout['description'] . '", '
                    . $workout['video_id'] . ', ' . $workout['repeat_workout'] . ', "' . $user_id . '", "'
                    . $date . '", "' . $date . '")';
            }
            unset($workout);

            $up_data = $this->db->query('
                INSERT INTO `courses_training_weeks` 
                  (`ctw_course_id`, `ctw_num_workout`, `ctw_description`, `ctw_video_id`, `ctw_repeat_workout`, 
                  `ctw_admin_add`, `ctw_date_add`, `ctw_date_update`) 
                VALUES ' . $values);
            if ($up_data === false)
            {
                parent::logDbMessages(__METHOD__);
            }
        }

        // Изменение данных тренировок
        if (!empty($schedule['update'])) {
            foreach ($schedule['update'] as $num_workout => $workout) {
                $up_data = $this->db->query('
                    UPDATE `courses_training_weeks` 
                    SET `ctw_video_id`=?, `ctw_repeat_workout`=?, `ctw_description`=?, `ctw_date_update`=?
                    WHERE `ctw_course_id`=? and `ctw_num_workout`=? LIMIT 1',
                        array($workout['video_id'], $workout['repeat_workout'], $workout['description'], $date, $course_id, $num_workout));
                if ($up_data === false)
                {
                    parent::logDbMessages(__METHOD__);
                }
            }
            unset($workout);
        }

        // Удаление тренировок
        if (!empty($schedule['delete'])) {
            $workouts = implode(",", $schedule['delete']);
            $up_data = $this->db->query('
                DELETE FROM `courses_training_weeks` WHERE `ctw_course_id`=? and `ctw_num_workout` IN (' . $workouts . ')', $course_id);
            if ($up_data === false)
            {
                parent::logDbMessages(__METHOD__);
            }
        }

        return $result;
    }

    /* КОНЕЦ БЛОКА ОБРАБОТКИ ДАННЫХ ТРЕНИРОВОК КУРСА */


    /* НАЧАЛО БЛОКА ОБРАБОТКИ ДАННЫХ ТРЕНЕРОВ КУРСА */

    /**
     * Выборка тренеров курса
     *
     * @param $course_id
     * @return array
     */
    public function getCourseCouches($course_id)
    {
        $result = array('couches' => array());

        $sel_couches = $this->db->query('
                SELECT `cc_couch_id`, `user_name`, `user_email`, `user_image`, `cd_specialization` 
                FROM `courses_couches`
                LEFT JOIN `users` ON `cc_couch_id`=`user_id`
                LEFT JOIN `couch_data` ON `cd_u_id`=`user_id`
                WHERE `cc_course_id`=?', $course_id);

        if ($sel_couches !== false and 0 < $sel_couches->num_rows())
        {
            $i = 0;
            foreach ($sel_couches->result() as $row) {
                $result['couches'][$i]['id']      = $row->cc_couch_id;
                $result['couches'][$i]['name']    = !empty($row->user_name) ? $row->user_name : $row->user_email;
                $result['couches'][$i]['image']   = !empty($row->user_image) ? mb_substr($row->user_image, 1) : '';
                $result['couches'][$i]['special'] = $row->cd_specialization;

                $i++;
            }
            unset($row);
        }
        elseif ($sel_couches === false)
        {
            parent::logDbMessages(__METHOD__);
        }
        else
        {
            $result['couches'] = null;
        }

        return $result;
    }

    /**
     * Выборка тренеров курса с установленным процентом
     *
     * @param $course_id
     * @return array
     */
    public function getCourseCouchesId($course_id)
    {
        $result = array();
        
        $sel_couches = $this->db->query('
          SELECT `cc_couch_id`, `cc_percent` 
          FROM `courses_couches` 
          WHERE `cc_course_id`=?', $course_id);
        
        if ($sel_couches !== false and 0 < $sel_couches->num_rows())
        {
            $i = 0;
            foreach ($sel_couches->result() as $row)
            {
                $result['id'][$i]      = $row->cc_couch_id;
                $result['percent'][$i] = $row->cc_percent;
                
                $i++;
            }
            unset($row);
        }
        elseif ($sel_couches === false)
        {
            parent::logDbMessages(__METHOD__);
        }
        
        return $result;
    }

    /**
     * Обновление данных тренеров курса
     *
     * Добавление, обеовление, удаление тренеров курса
     *
     * @param int $course_id ID курса
     * @param array $couches Массив тренеров
     * @param $date
     * @return bool
     */
    public function setCourseCouches($course_id, $couches, $date)
    {
        // Добавление новых тренеров
        if (!empty($couches['insert'])) {
            $values = '';
            foreach ($couches['insert'] as $couch_id => $percent) {
                if (empty($values)) {
                    $values = '(' . $course_id .', ' . $couch_id . ', ' . $percent . ', "' . $date . '", "' . $date . '")';
                } else {
                    $values .= ', (' . $course_id .', ' . $couch_id . ', ' . $percent . ', "' . $date . '", "' . $date . '")';
                }
            }
            unset($couch);

            $up_data = $this->db->query('
                INSERT INTO `courses_couches` 
                  (`cc_course_id`, `cc_couch_id`, `cc_percent`, `cc_date_add`, `cc_date_update`) 
                VALUES ' . $values);
            if ($up_data === false)
            {
                parent::logDbMessages(__METHOD__);
            }
        }

        // Обновление данных тренеров
        if (!empty($couches['update'])) {
            foreach ($couches['update'] as $couch_id => $percent) {
                $up_data = $this->db->query('
                  UPDATE `courses_couches` 
                  SET `cc_percent`=?, `cc_date_update`=? 
                  WHERE `cc_course_id`=? and `cc_couch_id`=? LIMIT 1',
                    array($percent, $date, $course_id, $couch_id));
                if ($up_data === false)
                {
                    parent::logDbMessages(__METHOD__);
                }
            }
            unset($couch);
        }

        // Удаление тренеров
        if (!empty($couches['delete'])) {
            $couches = implode($couches['delete']);
            $up_data = $this->db->query('
                DELETE FROM `courses_couches` WHERE `cc_course_id`=? and `cc_couch_id` IN (' . $couches . ')', $course_id);
            if ($up_data === false)
            {
                parent::logDbMessages(__METHOD__);
            }
        }

        return true;
    }

    /* КОНЕЦ БЛОКА ОБРАБОТКИ ДАННЫХ ТРЕНЕРОВ КУРСА */


    /* НАЧАЛО БЛОКА ОБРАБОТКИ ДАННЫХ LANDING PAGE КУРСА */

    /**
     * Выборка Landing page курса
     *
     * @param int $course_id ID курса
     * @return array
     */
    public function getCourseLandingPage($course_id)
    {
        $result = array(
            'landing' => array('html_page' => '', 'lp_id' => '', 'bg' => '', 'slider_images' => array(), 'main_title' => '', 'slider_images_default' => true,
                'block2' => array('bg' => '', 'bg_orig' => '', 'image' => '', 'title' => '', 'subtitle' => '', 'text' => '', 'bg_default' => true, 'image_default' => true, 'button' => ''),
                'block3' => array('bg' => '', 'bg_orig' => '', 'title' => '', 'subtitle' => '', 'images' => array(), 'r_title' => '', 'r_subtitle' => '', 'r_reviews' => '', 'bg_default' => true, 'image1_default' => true, 'image2_default' => true),
                'block4' => array('bg' => '', 'bg_orig' => '', 'title' => '', 'subtitle' => '', 'image' => '', 'r_title' => '', 'r_subtitle' => '', 'bg_default' => true, 'image_default' => true, 'button' => ''),
                'block5' => array('bg' => '', 'bg_orig' => '', 'title' => '', 'subtitle' => '', 'text' => '', 'images' => array(), 'r_title' => '', 'r_subtitle' => '', 'r_text' => '', 'bg_default' => true, 'image1_default' => true, 'image2_default' => true, 'image3_default' => true, 'button' => ''),
                'block6' => array('bg' => '', 'bg_orig' => '', 'title' => '', 'desc' => '', 'subtitle' => '', 'advantages' => array(), 'image' => '', 'bg_default' => true, 'image_default' => true, 'button' => ''),
                'block7' => array('bg' => '', 'bg_orig' => '', 'title' => '', 'images' => array(), 'texts' => array(), 'bg_default' => true, 'images_default' => true, 'button' => ''),
                'block8' => array('bg' => '', 'bg_orig' => '', 'title' => '', 'desc1' => '', 'subtitle' => '', 'desc2' => '', 'old_price' => '', 'new_price' => '', 'bg_default' => true, 'button' => '')
            )
        );

        $sel_landing = $this->db->query('
            SELECT `clp_lp_id`, `clp_slider_images`, `clp_main_title`, `clp_block2_background`, 
              `clp_block2_image`, `clp_block2_title`, `clp_block2_subtitle`, `clp_block2_text`, `clp_block2_button`, 
              `clp_block3_background`, `clp_block3_title`, `clp_block3_subtitle`, `clp_block3_images`, `clp_block3_r_title`, 
              `clp_block3_r_subtitle`, `clp_block3_r_reviews`, `clp_block4_background`, `clp_block4_title`, 
              `clp_block4_subtitle`, `clp_block4_image`, `clp_block4_r_title`, `clp_block4_r_subtitle`, `clp_block4_button`, 
              `clp_block5_background`, `clp_block5_title`, `clp_block5_subtitle`, `clp_block5_text`, `clp_block5_images`, 
              `clp_block5_r_title`, `clp_block5_r_subtitle`, `clp_block5_r_text`, `clp_block5_button`, 
              `clp_block6_background`, `clp_block6_title`, `clp_block6_description`, `clp_block6_subtitle`, 
              `clp_block6_advantages`, `clp_block6_image`, `clp_block6_button`, `clp_block7_background`, `clp_block7_title`, 
              `clp_block7_images`, `clp_block7_text`, `clp_block8_background`, `clp_block7_button`, 
              `clp_block8_title`, `clp_block8_description1`, `clp_block8_subtitle`, `clp_block8_description2`, `clp_block8_old_price`, 
              `clp_block8_new_price`, `clp_block8_button`,
              `lp_html_page`, `lp_background`, `lp_slider_images`, `lp_block2_background`, `lp_block2_image`, `lp_block3_background`, 
              `lp_block3_images`, `lp_block4_background`, `lp_block4_image`, `lp_block5_background`, `lp_block5_images`, 
              `lp_block6_background`, `lp_block6_image`, `lp_block7_background`, `lp_block7_images`, `lp_block8_background`
            FROM `courses_landing_pages`
            LEFT JOIN `landing_pages`
              ON `lp_id`=`clp_lp_id`
            WHERE `clp_course_id`=? LIMIT 1', $course_id);

        if ($sel_landing !== false and 1 == $sel_landing->num_rows())
        {
            $row = $sel_landing->row();

            // Путь к HTML странице landing page
            $result['landing'] = self::parseLandingData($row);
        }
        elseif ($sel_landing === false)
        {
            parent::logDbMessages(__METHOD__);
        }

        return $result;
    }

    /**
     * Сохранение/изменение Landing page курса
     *
     * @param $course_id
     * @param $landing_style
     * @param $slider_images
     * @param $main_title_bbcode
     * @param $b2_bg
     * @param $b2_image
     * @param $b2_title
     * @param $b2_subtitle
     * @param $b2_text
     * @param $b2_button
     * @param $b3_bg
     * @param $b3_images
     * @param $b3_title
     * @param $b3_subtitle
     * @param $b3_r_title
     * @param $b3_r_subtitle
     * @param $b3_r_reviews
     * @param $b4_bg
     * @param $b4_image
     * @param $b4_title
     * @param $b4_subtitle
     * @param $b4_r_title
     * @param $b4_r_desc
     * @param $b4_button
     * @param $b5_bg
     * @param $b5_images
     * @param $b5_title
     * @param $b5_subtitle
     * @param $b5_text
     * @param $b5_r_title
     * @param $b5_r_subtitle
     * @param $b5_r_text
     * @param $b5_button
     * @param $b6_bg
     * @param $b6_image
     * @param $b6_title
     * @param $b6_desc
     * @param $b6_subtitle
     * @param $b6_advantages
     * @param $b6_button
     * @param $b7_bg
     * @param $b7_title
     * @param $b7_images
     * @param $b7_texts
     * @param $b7_button
     * @param $b8_bg
     * @param $b8_title
     * @param $b8_desc1
     * @param $b8_subtitle
     * @param $b8_desc2
     * @param $b8_old_price
     * @param $b8_new_price
     * @param $b8_button
     * @param $date
     * @return bool
     */
    public function setCourseLandingPage($course_id, $landing_style, $slider_images, $main_title_bbcode,
                                         $b2_bg, $b2_image, $b2_title, $b2_subtitle, $b2_text, $b2_button,
                                         $b3_bg, $b3_images, $b3_title, $b3_subtitle, $b3_r_title, $b3_r_subtitle, $b3_r_reviews,
                                         $b4_bg, $b4_image, $b4_title, $b4_subtitle, $b4_r_title, $b4_r_desc, $b4_button,
                                         $b5_bg, $b5_images, $b5_title, $b5_subtitle, $b5_text, $b5_r_title, $b5_r_subtitle, $b5_r_text, $b5_button,
                                         $b6_bg, $b6_image, $b6_title, $b6_desc, $b6_subtitle, $b6_advantages, $b6_button,
                                         $b7_bg, $b7_title, $b7_images, $b7_texts, $b7_button,
                                         $b8_bg, $b8_title, $b8_desc1, $b8_subtitle, $b8_desc2, $b8_old_price, $b8_new_price, $b8_button, $date)
    {
        $up_data = $this->db->query('
            UPDATE `courses_landing_pages` 
            SET `clp_lp_id`=?, `clp_slider_images`=?, `clp_main_title`=?, `clp_block2_background`=?, 
            `clp_block2_image`=?, `clp_block2_title`=?, `clp_block2_subtitle`=?, `clp_block2_text`=?, `clp_block2_button`=?, 
            `clp_block3_background`=?, `clp_block3_images`=?, `clp_block3_title`=?, `clp_block3_subtitle`=?, `clp_block3_r_title`=?, 
            `clp_block3_r_subtitle`=?, `clp_block3_r_reviews`=?, 
            `clp_block4_background`=?, `clp_block4_image`=?, `clp_block4_title`=?, `clp_block4_subtitle`=?, `clp_block4_r_title`=?, 
            `clp_block4_r_subtitle`=?, `clp_block4_button`=?, 
            `clp_block5_background`=?, `clp_block5_images`=?, `clp_block5_title`=?, `clp_block5_subtitle`=?, `clp_block5_text`=?, 
            `clp_block5_r_title`=?, `clp_block5_r_subtitle`=?, `clp_block5_r_text`=?, `clp_block5_button`=?, 
            `clp_block6_background`=?, `clp_block6_image`=?, `clp_block6_title`=?, `clp_block6_description`=?, `clp_block6_subtitle`=?, 
            `clp_block6_advantages`=?, `clp_block6_button`=?, 
            `clp_block7_background`=?, `clp_block7_title`=?, `clp_block7_images`=?, `clp_block7_text`=?, `clp_block7_button`=?, 
            `clp_block8_background`=?, `clp_block8_title`=?, `clp_block8_description1`=?, `clp_block8_subtitle`=?, 
            `clp_block8_description2`=?, `clp_block8_old_price`=?, `clp_block8_new_price`=?, `clp_block8_button`=?, 
            `clp_date_update`=? 
            WHERE `clp_course_id`=? LIMIT 1',
                array($landing_style, $slider_images, $main_title_bbcode,
                        $b2_bg, $b2_image, $b2_title, $b2_subtitle, $b2_text, $b2_button,
                        $b3_bg, $b3_images, $b3_title, $b3_subtitle, $b3_r_title, $b3_r_subtitle, $b3_r_reviews,
                        $b4_bg, $b4_image, $b4_title, $b4_subtitle, $b4_r_title, $b4_r_desc, $b4_button,
                        $b5_bg, $b5_images, $b5_title, $b5_subtitle, $b5_text, $b5_r_title, $b5_r_subtitle, $b5_r_text, $b5_button,
                        $b6_bg, $b6_image, $b6_title, $b6_desc, $b6_subtitle, $b6_advantages, $b6_button,
                        $b7_bg, $b7_title, $b7_images, $b7_texts, $b7_button,
                        $b8_bg, $b8_title, $b8_desc1, $b8_subtitle, $b8_desc2, $b8_old_price, $b8_new_price, $b8_button,
                        $date, $course_id));

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
     * Сохранение/изменение Landing page курса
     *
     * @param $course_id
     * @param $landing_style
     * @param $slider_images
     * @param $main_title_bbcode
     * @param $date
     * @return bool
     */
    public function setCourseLandingBlock1($course_id, $landing_style, $slider_images, $main_title_bbcode, $date)
    {
        $up_data = $this->db->query('
            UPDATE `courses_landing_pages` 
            SET `clp_lp_id`=?, `clp_slider_images`=?, `clp_main_title`=?, `clp_date_update`=? 
            WHERE `clp_course_id`=? LIMIT 1',
                array($landing_style, $slider_images, $main_title_bbcode, $date, $course_id));

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
     * Сохранение/изменение Landing page курса
     *
     * @param $course_id
     * @param $landing_style
     * @param $b2_bg
     * @param $b2_image
     * @param $b2_title
     * @param $b2_subtitle
     * @param $b2_text
     * @param $b2_button
     * @param $date
     * @return bool
     */
    public function setCourseLandingBlock2($course_id, $landing_style, $b2_bg, $b2_image, $b2_title, $b2_subtitle,
                                           $b2_text, $b2_button, $date)
    {
        $up_data = $this->db->query('
            UPDATE `courses_landing_pages` 
            SET `clp_lp_id`=?, `clp_block2_background`=?, `clp_block2_image`=?, `clp_block2_title`=?, 
            `clp_block2_subtitle`=?, `clp_block2_text`=?, `clp_block2_button`=?, `clp_date_update`=? 
            WHERE `clp_course_id`=? LIMIT 1',
                array($landing_style, $b2_bg, $b2_image, $b2_title, $b2_subtitle, $b2_text, $b2_button, $date, $course_id));

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
     * Сохранение/изменение Landing page курса
     *
     * @param $course_id
     * @param $landing_style
     * @param $b3_bg
     * @param $b3_images
     * @param $b3_title
     * @param $b3_subtitle
     * @param $b3_r_title
     * @param $b3_r_subtitle
     * @param $b3_r_reviews
     * @param $date
     * @return bool
     */
    public function setCourseLandingBlock3($course_id, $landing_style, $b3_bg, $b3_images, $b3_title, $b3_subtitle,
                                           $b3_r_title, $b3_r_subtitle, $b3_r_reviews, $date)
    {
        $up_data = $this->db->query('
            UPDATE `courses_landing_pages` 
            SET `clp_lp_id`=?, `clp_block3_background`=?, `clp_block3_images`=?, `clp_block3_title`=?, `clp_block3_subtitle`=?, `clp_block3_r_title`=?, 
            `clp_block3_r_subtitle`=?, `clp_block3_r_reviews`=?, `clp_date_update`=? 
            WHERE `clp_course_id`=? LIMIT 1',
                array($landing_style, $b3_bg, $b3_images, $b3_title, $b3_subtitle, $b3_r_title, $b3_r_subtitle, $b3_r_reviews,
                $date, $course_id));

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
     * Сохранение/изменение Landing page курса
     *
     * @param $course_id
     * @param $landing_style
     * @param $b4_bg
     * @param $b4_image
     * @param $b4_title
     * @param $b4_subtitle
     * @param $b4_r_title
     * @param $b4_r_desc
     * @param $b4_button
     * @param $date
     * @return bool
     */
    public function setCourseLandingBlock4($course_id, $landing_style, $b4_bg, $b4_image, $b4_title, $b4_subtitle,
                                           $b4_r_title, $b4_r_desc, $b4_button, $date)
    {
        $up_data = $this->db->query('
            UPDATE `courses_landing_pages` 
            SET `clp_lp_id`=?, `clp_block4_background`=?, `clp_block4_image`=?, `clp_block4_title`=?, 
            `clp_block4_subtitle`=?, `clp_block4_r_title`=?, `clp_block4_r_subtitle`=?, `clp_block4_button`=?, `clp_date_update`=? 
            WHERE `clp_course_id`=? LIMIT 1',
                array($landing_style, $b4_bg, $b4_image, $b4_title, $b4_subtitle, $b4_r_title, $b4_r_desc, $b4_button,
                    $date, $course_id));

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
     * Сохранение/изменение Landing page курса
     *
     * @param $course_id
     * @param $landing_style
     * @param $b5_bg
     * @param $b5_images
     * @param $b5_title
     * @param $b5_subtitle
     * @param $b5_text
     * @param $b5_r_title
     * @param $b5_r_subtitle
     * @param $b5_r_text
     * @param $b5_button
     * @param $date
     * @return bool
     */
    public function setCourseLandingBlock5($course_id, $landing_style, $b5_bg, $b5_images, $b5_title, $b5_subtitle,
                                           $b5_text, $b5_r_title, $b5_r_subtitle, $b5_r_text, $b5_button, $date)
    {
        $up_data = $this->db->query('
            UPDATE `courses_landing_pages` 
            SET `clp_lp_id`=?, `clp_block5_background`=?, `clp_block5_images`=?, `clp_block5_title`=?, 
            `clp_block5_subtitle`=?, `clp_block5_text`=?, `clp_block5_r_title`=?, `clp_block5_r_subtitle`=?, 
            `clp_block5_r_text`=?, `clp_block5_button`=?, `clp_date_update`=? 
            WHERE `clp_course_id`=? LIMIT 1',
                array($landing_style, $b5_bg, $b5_images, $b5_title, $b5_subtitle, $b5_text, $b5_r_title,
                    $b5_r_subtitle, $b5_r_text, $b5_button, $date, $course_id));

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
     * Сохранение/изменение Landing page курса
     *
     * @param $course_id
     * @param $landing_style
     * @param $b6_bg
     * @param $b6_image
     * @param $b6_title
     * @param $b6_desc
     * @param $b6_subtitle
     * @param $b6_advantages
     * @param $b6_button
     * @param $date
     * @return bool
     */
    public function setCourseLandingBlock6($course_id, $landing_style, $b6_bg, $b6_image, $b6_title, $b6_desc,
                                           $b6_subtitle, $b6_advantages, $b6_button, $date)
    {
        $up_data = $this->db->query('
            UPDATE `courses_landing_pages` 
            SET `clp_lp_id`=?, `clp_block6_background`=?, `clp_block6_image`=?, `clp_block6_title`=?, 
            `clp_block6_description`=?, `clp_block6_subtitle`=?, `clp_block6_advantages`=?, `clp_block6_button`=?, `clp_date_update`=? 
            WHERE `clp_course_id`=? LIMIT 1',
                array($landing_style, $b6_bg, $b6_image, $b6_title, $b6_desc, $b6_subtitle, $b6_advantages, $b6_button,
                    $date, $course_id));

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
     * Сохранение/изменение Landing page курса
     *
     * @param $course_id
     * @param $landing_style
     * @param $slider_images
     * @param $main_title_bbcode
     * @param $b2_bg
     * @param $b2_image
     * @param $b2_title
     * @param $b2_subtitle
     * @param $b2_text
     * @param $b2_button
     * @param $b3_bg
     * @param $b3_images
     * @param $b3_title
     * @param $b3_subtitle
     * @param $b3_r_title
     * @param $b3_r_subtitle
     * @param $b3_r_reviews
     * @param $b4_bg
     * @param $b4_image
     * @param $b4_title
     * @param $b4_subtitle
     * @param $b4_r_title
     * @param $b4_r_desc
     * @param $b4_button
     * @param $b5_bg
     * @param $b5_images
     * @param $b5_title
     * @param $b5_subtitle
     * @param $b5_text
     * @param $b5_r_title
     * @param $b5_r_subtitle
     * @param $b5_r_text
     * @param $b5_button
     * @param $b6_bg
     * @param $b6_image
     * @param $b6_title
     * @param $b6_desc
     * @param $b6_subtitle
     * @param $b6_advantages
     * @param $b6_button
     * @param $b7_bg
     * @param $b7_title
     * @param $b7_images
     * @param $b7_texts
     * @param $b7_button
     * @param $b8_bg
     * @param $b8_title
     * @param $b8_desc1
     * @param $b8_subtitle
     * @param $b8_desc2
     * @param $b8_old_price
     * @param $b8_new_price
     * @param $b8_button
     * @param $admin_id
     * @param $date
     * @return bool
     */
    public function setCourseLandingBlock7($course_id, $landing_style, $b7_bg, $b7_title, $b7_images, $b7_texts,
                                           $b7_button, $date)
    {
        $up_data = $this->db->query('
            UPDATE `courses_landing_pages` 
            SET `clp_lp_id`=?, `clp_block7_background`=?, `clp_block7_title`=?, `clp_block7_images`=?, `clp_block7_text`=?, 
            `clp_block7_button`=?, `clp_date_update`=? 
            WHERE `clp_course_id`=? LIMIT 1',
                array($landing_style, $b7_bg, $b7_title, $b7_images, $b7_texts, $b7_button, $date, $course_id));

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
     * Сохранение/изменение Landing page курса
     *
     * @param $course_id
     * @param $landing_style
     * @param $b8_bg
     * @param $b8_title
     * @param $b8_desc1
     * @param $b8_subtitle
     * @param $b8_desc2
     * @param $b8_old_price
     * @param $b8_new_price
     * @param $b8_button
     * @param $date
     * @return bool
     */
    public function setCourseLandingBlock8($course_id, $landing_style, $b8_bg, $b8_title, $b8_desc1, $b8_subtitle,
                                           $b8_desc2, $b8_old_price, $b8_new_price, $b8_button, $date)
    {
        $up_data = $this->db->query('
            UPDATE `courses_landing_pages` 
            SET `clp_lp_id`=?, `clp_block8_background`=?, `clp_block8_title`=?, `clp_block8_description1`=?, `clp_block8_subtitle`=?, 
            `clp_block8_description2`=?, `clp_block8_old_price`=?, `clp_block8_new_price`=?, `clp_block8_button`=?, 
            `clp_date_update`=? 
            WHERE `clp_course_id`=? LIMIT 1',
                array($landing_style, $b8_bg, $b8_title, $b8_desc1, $b8_subtitle, $b8_desc2, $b8_old_price, $b8_new_price,
                    $b8_button, $date, $course_id));

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
     * Выборка данных стандартных Landing page
     *
     * @param int $lp_id ID default landing page
     * @return array
     */
    public function getDefaultLandingPage($lp_id)
    {
        $result = array(
            'landing' => array('html_page' => '', 'bg' => '', 'slider_images' => '', 'main_title' => '',
                'block2' => array('bg' => '', 'image' => '', 'title' => '', 'subtitle' => '', 'text' => '', 'button' => ''),
                'block3' => array('bg' => '', 'title' => '', 'subtitle' => '', 'images' => '', 'r_title' => '', 'r_subtitle' => '', 'r_reviews' => ''),
                'block4' => array('bg' => '', 'title' => '', 'subtitle' => '', 'image' => '', 'r_title' => '', 'r_subtitle' => '', 'button' => ''),
                'block5' => array('title' => '', 'subtitle' => '', 'text' => '', 'images' => '', 'r_title' => '', 'r_subtitle' => '', 'r_text' => '', 'button' => ''),
                'block6' => array('bg' => '', 'title' => '', 'desc' => '', 'subtitle' => '', 'advantages' => '', 'image' => '', 'button' => ''),
                'block7' => array('title' => '', 'images' => '', 'text' => '', 'button' => ''),
                'block8' => array('bg' => '', 'title' => '', 'desc1' => '', 'subtitle' => '', 'desc2' => '', 'old_price' => '', 'new_price' => '', 'button' => '')
            )
        );

        $sel_landing = $this->db->query('
            SELECT `lp_html_page`, `lp_background`, `lp_slider_images`, `lp_main_title`, `lp_block2_background`, 
              `lp_block2_image`, `lp_block2_title`, `lp_block2_subtitle`, `lp_block2_text`, `lp_block2_button`,
              `lp_block3_background`, `lp_block3_title`, `lp_block3_subtitle`, `lp_block3_images`, `lp_block3_r_title`, `lp_block3_r_subtitle`, 
              `lp_block3_r_reviews`, `lp_block4_background`, `lp_block4_title`, `lp_block4_subtitle`, `lp_block4_image`, 
              `lp_block4_r_title`, `lp_block4_r_subtitle`, `lp_block4_button`,  
              `lp_block5_background`, `lp_block5_title`, `lp_block5_subtitle`,`lp_block5_text`, `lp_block5_images`, 
              `lp_block5_r_title`, `lp_block5_r_subtitle`, `lp_block5_r_text`, `lp_block5_button`,  
              `lp_block6_background`, `lp_block6_title`, `lp_block6_description`, `lp_block6_subtitle`, `lp_block6_advantages`, 
              `lp_block6_image`, `lp_block6_button`,  
              `lp_block7_background`, `lp_block7_title`, `lp_block7_images`, `lp_block7_text`, `lp_block7_button`,  
              `lp_block8_background`, `lp_block8_title`, `lp_block8_description1`, `lp_block8_subtitle`, 
              `lp_block8_description2`, `lp_block8_old_price`, `lp_block8_new_price`, `lp_block8_button`
            FROM `landing_pages`
            WHERE `lp_id`=? LIMIT 1', $lp_id);

        if ($sel_landing !== false and 1 == $sel_landing->num_rows())
        {
            $row = $sel_landing->row();

            // Путь к HTML странице landing page
            $result['landing']['html_page'] = $row->lp_html_page;

            // Фон страницы
            $lp_background = '';
            if (!empty($row->lp_background))
            {
                if (is_file($row->lp_background))
                {
                    $lp_background = 'background: url(' . mb_substr($row->lp_background, 1) . ') top center repeat;';
                }
                elseif (mb_substr($row->lp_background, 0, 1) == '#')
                {
                    $lp_background = 'background: ' . $row->lp_background . ';';
                }
            }
            $result['landing']['bg'] = $lp_background;

            // Изображения для слайдера страницы
            $result['landing']['slider_images'] = '';
            if (!empty($row->lp_slider_images))
            {
                $s_images = explode(';', $row->lp_slider_images);

                $i = 0;
                foreach ($s_images as $s_image)
                {
                    if (!empty($s_image))
                    {
                        $result['landing']['slider_images'][$i] = is_file($s_image) ? mb_substr($s_image, 1) : '';

                        if (empty($result['landing']['slider_images'][$i]))
                        {
                            unset($result['landing']['slider_images'][$i]);
                        }

                        $i++;
                    }
                }
                unset($s_image);
            }

            $result['landing']['main_title'] = $row->lp_main_title;

            // БЛОК 2
            // Фон блока
            $block_background = '';
            if (!empty($row->lp_block2_background))
            {
                if (is_file($row->lp_block2_background))
                {
                    $block_background = 'background: url(' . mb_substr($row->lp_block2_background, 1) . ') top center repeat;';
                }
                elseif (mb_substr($row->lp_block2_background, 0, 1) == '#')
                {
                    $block_background = 'background: ' . $row->lp_block2_background . ';';
                }
            }
            $result['landing']['block2']['bg'] = $block_background;

            // Изображение блока
            $block_image = '';
            if (!empty($row->lp_block2_image))
            {
                if (is_file($row->lp_block2_image))
                {
                    $block_image = mb_substr($row->lp_block2_image, 1);
                }
                elseif (mb_substr($row->lp_block2_image, 0, 1) == '#')
                {
                    $block_image = $row->lp_block2_image;
                }
            }
            $result['landing']['block2']['image'] = $block_image;

            $result['landing']['block2']['title']    = $row->lp_block2_title;
            $result['landing']['block2']['subtitle'] = $row->lp_block2_subtitle;
            $result['landing']['block2']['text']     = $row->lp_block2_text;
            $result['landing']['block2']['button']   = strip_tags($row->lp_block2_button);

            // БЛОК 3
            // Фон блока
            $block_background = '';
            if (!empty($row->lp_block3_background))
            {
                if (is_file($row->lp_block3_background))
                {
                    $block_background = 'background-image: url(' . mb_substr($row->lp_block3_background, 1) . ')';
                }
                elseif (mb_substr($row->lp_block3_background, 0, 1) == '#')
                {
                    $block_background = 'background: ' . $row->lp_block3_background . ';';
                }
            }
            $result['landing']['block3']['bg'] = $block_background;

            $result['landing']['block3']['title']      = $row->lp_block3_title;
            $result['landing']['block3']['subtitle']   = $row->lp_block3_subtitle;
            $result['landing']['block3']['r_title']    = $row->lp_block3_r_title;
            $result['landing']['block3']['r_subtitle'] = $row->lp_block3_r_subtitle;
            $result['landing']['block3']['r_reviews']  = $row->lp_block3_r_reviews;

            // Изображения блока
            $result['landing']['block3']['images'] = '';
            if (!empty($row->lp_block3_images))
            {
                $s_images = explode(';', $row->lp_block3_images);

                $i = 0;
                foreach ($s_images as $s_image)
                {
                    if (!empty($s_image))
                    {
                        $result['landing']['block3']['images'][$i] = is_file($s_image) ? mb_substr($s_image, 1) : '';

                        if (empty($result['landing']['block3']['images'][$i]))
                        {
                            unset($result['landing']['block3']['images'][$i]);
                        }

                        $i++;
                    }
                }
                unset($s_image);
            }

            // БЛОК 4
            // Фон блока
            $block_background = '';
            if (!empty($row->lp_block4_background))
            {
                if (is_file($row->lp_block4_background))
                {
                    $block_background = 'background-image: url(' . mb_substr($row->lp_block4_background, 1) . ');';
                }
                elseif (mb_substr($row->lp_block4_background, 0, 1) == '#')
                {
                    $block_background = 'background: ' . $row->lp_block4_background . ';';
                }
            }
            $result['landing']['block4']['bg'] = $block_background;

            $result['landing']['block4']['title']    = $row->lp_block4_title;
            $result['landing']['block4']['subtitle'] = $row->lp_block4_subtitle;

            // Изображение блока
            $block_image = '';
            if (!empty($row->lp_block4_image))
            {
                if (is_file($row->lp_block4_image))
                {
                    $block_image = mb_substr($row->lp_block4_image, 1);
                }
                elseif (mb_substr($row->lp_block4_image, 0, 1) == '#')
                {
                    $block_image = $row->lp_block4_image;
                }
            }
            $result['landing']['block4']['image'] = $block_image;

            $result['landing']['block4']['r_title']    = $row->lp_block4_r_title;
            $result['landing']['block4']['r_subtitle'] = $row->lp_block4_r_subtitle;
            $result['landing']['block4']['button']     = strip_tags($row->lp_block4_button);

            // БЛОК 5
            // Фон блока
            $block_background = '';
            if (!empty($row->lp_block5_background))
            {
                if (is_file($row->lp_block5_background))
                {
                    $block_background = 'background-image: url(' . mb_substr($row->lp_block5_background, 1) . ')';
                }
                elseif (mb_substr($row->lp_block5_background, 0, 1) == '#')
                {
                    $block_background = 'background: ' . $row->lp_block5_background . ';';
                }
            }
            $result['landing']['block5']['bg'] = $block_background;

            $result['landing']['block5']['title']    = $row->lp_block5_title;
            $result['landing']['block5']['subtitle'] = $row->lp_block5_subtitle;
            $result['landing']['block5']['text']     = $row->lp_block5_text;
            $result['landing']['block5']['button']   = strip_tags($row->lp_block5_button);

            // Изображения блока
            $result['landing']['block5']['images'] = '';
            if (!empty($row->lp_block5_images))
            {
                $s_images = explode(';', $row->lp_block5_images);

                $i = 0;
                foreach ($s_images as $s_image)
                {
                    if (!empty($s_image))
                    {
                        $result['landing']['block5']['images'][$i] = is_file($s_image) ? mb_substr($s_image, 1) : '';

                        if (empty($result['landing']['block5']['images'][$i]))
                        {
                            unset($result['landing']['block5']['images'][$i]);
                        }

                        $i++;
                    }
                }
                unset($s_image);
            }

            $result['landing']['block5']['r_title']    = $row->lp_block5_r_title;
            $result['landing']['block5']['r_subtitle'] = $row->lp_block5_r_subtitle;
            $result['landing']['block5']['r_text']     = $row->lp_block5_r_text;

            // БЛОК 6
            // Фон блока
            $block_background = '';
            if (!empty($row->lp_block6_background))
            {
                if (is_file($row->lp_block6_background))
                {
                    $block_background = 'background-image: url(' . mb_substr($row->lp_block6_background, 1) . ')';
                }
                elseif (mb_substr($row->lp_block6_background, 0, 1) == '#')
                {
                    $block_background = 'background: ' . $row->lp_block6_background . ';';
                }
            }
            $result['landing']['block6']['bg'] = $block_background;

            $result['landing']['block6']['title']    = $row->lp_block6_title;
            $result['landing']['block6']['desc']     = $row->lp_block6_description;
            $result['landing']['block6']['subtitle'] = $row->lp_block6_subtitle;
            $result['landing']['block6']['button']   = strip_tags($row->lp_block6_button);

            // Преимущества блока
            $result['landing']['block6']['advantages'] = '';
            if (!empty($row->lp_block6_advantages))
            {
                $advantages = explode(';', $row->lp_block6_advantages);

                $i = 0;
                foreach ($advantages as $advantage)
                {
                    if (!empty($advantage))
                    {
                        $result['landing']['block6']['advantages'][$i] = $advantage;

                        $i++;
                    }
                }
                unset($advantage);
            }

            // Изображение блока
            $block_image = '';
            if (!empty($row->lp_block6_image))
            {
                if (is_file($row->lp_block6_image))
                {
                    $block_image = mb_substr($row->lp_block6_image, 1);
                }
                elseif (mb_substr($row->lp_block6_image, 0, 1) == '#')
                {
                    $block_image = $row->lp_block6_image;
                }
            }
            $result['landing']['block6']['image'] = $block_image;

            // БЛОК 7
            // Фон блока
            $block_background = '';
            if (!empty($row->lp_block7_background))
            {
                if (is_file($row->lp_block7_background))
                {
                    $block_background = 'background-image: url(' . mb_substr($row->lp_block7_background, 1) . ')';
                }
                elseif (mb_substr($row->lp_block7_background, 0, 1) == '#')
                {
                    $block_background = 'background: ' . $row->lp_block7_background . ';';
                }
            }
            $result['landing']['block7']['bg']     = $block_background;
            $result['landing']['block7']['title']  = $row->lp_block7_title;
            $result['landing']['block7']['button'] = strip_tags($row->lp_block7_button);

            // Изображения блока
            $result['landing']['block7']['images'] = '';
            if (!empty($row->lp_block7_images))
            {
                $s_images = explode(';', $row->lp_block7_images);

                $i = 0;
                foreach ($s_images as $s_image)
                {
                    if (!empty($s_image))
                    {
                        $result['landing']['block7']['images'][$i] = is_file($s_image) ? mb_substr($s_image, 1) : '';

                        if (empty($result['landing']['block7']['images'][$i]))
                        {
                            unset($result['landing']['block7']['images'][$i]);
                        }

                        $i++;
                    }
                }
                unset($s_image);
            }

            // Изображения блока
            $result['landing']['block7']['texts'] = '';
            if (!empty($row->lp_block7_text))
            {
                $texts = explode(';', $row->lp_block7_text);

                $i = 0;
                foreach ($texts as $text)
                {
                    if (!empty($text))
                    {
                        $result['landing']['block7']['texts'][$i] = $text;

                        if (empty($result['landing']['block7']['images'][$i]))
                        {
                            unset($result['landing']['block7']['texts'][$i]);
                        }

                        $i++;
                    }
                }
                unset($text);
            }

            // БЛОК 8
            // Фон блока
            $block_background = '';
            if (!empty($row->lp_block8_background))
            {
                if (is_file($row->lp_block8_background))
                {
                    $block_background = 'background-image: url(' . mb_substr($row->lp_block8_background, 1) . ');';
                }
                elseif (mb_substr($row->lp_block8_background, 0, 1) == '#')
                {
                    $block_background = 'background: ' . $row->lp_block8_background . ';';
                }
            }
            $result['landing']['block8']['bg'] = $block_background;

            $result['landing']['block8']['title']     = $row->lp_block8_title;
            $result['landing']['block8']['desc1']     = $row->lp_block8_description1;
            $result['landing']['block8']['subtitle']  = $row->lp_block8_subtitle;
            $result['landing']['block8']['desc2']     = $row->lp_block8_description2;
            $result['landing']['block8']['old_price'] = $row->lp_block8_old_price;
            $result['landing']['block8']['new_price'] = $row->lp_block8_new_price;
            $result['landing']['block8']['button']    = strip_tags($row->lp_block8_button);
        }
        elseif ($sel_landing === false)
        {
            parent::logDbMessages(__METHOD__);
        }

        return $result;
    }

    /**
     * Выборка данных активного Landing page курса
     *
     * @param int $course_id ID курса
     * @return array
     */
    public function getLandingPage($course_id)
    {
        $result = array(
            'landing' => array('html_page' => '', 'bg' => '', 'slider_images' => '', 'main_title' => '',
                'block2' => array('bg' => '', 'image' => '', 'title' => '', 'subtitle' => '', 'text' => '', 'button' => ''),
                'block3' => array('bg' => '', 'title' => '', 'subtitle' => '', 'images' => '', 'r_title' => '', 'r_subtitle' => '', 'r_reviews' => ''),
                'block4' => array('bg' => '', 'title' => '', 'subtitle' => '', 'image' => '', 'r_title' => '', 'r_subtitle' => '', 'button' => ''),
                'block5' => array('bg' => '', 'title' => '', 'subtitle' => '', 'text' => '', 'images' => '', 'r_title' => '', 'r_subtitle' => '', 'r_text' => '', 'button' => ''),
                'block6' => array('bg' => '', 'title' => '', 'desc' => '', 'subtitle' => '', 'advantages' => '', 'image' => '', 'button' => ''),
                'block7' => array('bg' => '', 'title' => '', 'images' => '', 'text' => '', 'button' => ''),
                'block8' => array('bg' => '', 'title' => '', 'desc1' => '', 'subtitle' => '', 'desc2' => '', 'old_price' => '', 'new_price' => '', 'button' => '')
            )
        );

        $sel_landing = $this->db->query('
            SELECT `clp_slider_images`, `clp_main_title`, `clp_block2_background`, 
              `clp_block2_image`, `clp_block2_title`, `clp_block2_subtitle`, `clp_block2_text`, `clp_block2_button`, 
              `clp_block3_background`, `clp_block3_title`, `clp_block3_subtitle`, `clp_block3_images`, `clp_block3_r_title`, 
              `clp_block3_r_subtitle`, `clp_block3_r_reviews`, 
              `clp_block4_background`, `clp_block4_title`, `clp_block4_subtitle`, `clp_block4_image`, `clp_block4_r_title`, 
              `clp_block4_r_subtitle`, `clp_block4_button`,  
              `clp_block5_background`, `clp_block5_title`, `clp_block5_subtitle`, `clp_block5_text`, `clp_block5_images`, 
              `clp_block5_r_title`, `clp_block5_r_subtitle`, `clp_block5_r_text`, `clp_block5_button`,  
              `clp_block6_background`, `clp_block6_title`, `clp_block6_description`, `clp_block6_subtitle`, `clp_block6_advantages`, 
              `clp_block6_image`, `clp_block6_button`,  
              `clp_block7_background`, `clp_block7_title`, `clp_block7_images`, `clp_block7_text`, `clp_block7_button`, 
              `clp_block8_background`, `clp_block8_title`, `clp_block8_description1`, `clp_block8_subtitle`, 
              `clp_block8_description2`, `clp_block8_old_price`, `clp_block8_new_price`, `clp_block8_button`,  
              `lp_html_page`, `lp_background`, `lp_slider_images`, `lp_block2_background`, `lp_block2_image`, `lp_block3_background`, 
              `lp_block3_images`, `lp_block4_background`, `lp_block4_image`, `lp_block5_background`, `lp_block5_images`, 
              `lp_block6_background`, `lp_block6_image`, `lp_block7_background`, `lp_block7_images`, `lp_block8_background`
            FROM `courses_landing_pages`
            LEFT JOIN `landing_pages`
              ON `lp_id`=`clp_lp_id`
            WHERE `clp_course_id`=? and `clp_activated`="activate" LIMIT 1', $course_id);

        if ($sel_landing !== false and 1 == $sel_landing->num_rows())
        {
            $row = $sel_landing->row();

            // Путь к HTML странице landing page
            $result['landing'] = self::parseLandingData($row);
        }

        return $result;
    }

    /**
     * Выборка списка типов Landing pages
     * @return array
     */
    public function getLandingPagesList()
    {
        $result = array('landing_list' => array(), 'landings_id' => array());

        $sel_landings = $this->db->query('SELECT `lp_id`, `lp_name`FROM `landing_pages`');

        if ($sel_landings !== false and 0 < $sel_landings->num_rows())
        {
            $i = 0;
            foreach ($sel_landings->result() as $row)
            {
                $result['landings_list'][$i]['id']   = $row->lp_id;
                $result['landings_list'][$i]['name'] = $row->lp_name;

                $result['landings_id'][$i] = $row->lp_id;

                $i++;
            }
        }
        elseif ($sel_landings === false)
        {
            parent::logDbMessages(__METHOD__);
        }

        return $result;
    }

    /**
     * Активация Landing page курса
     * @param $course_id
     * @param $date
     * @return bool
     */
    public function activateCourseLandingPage($course_id, $date)
    {
        $up_data = $this->db->query('
            UPDATE `courses_landing_pages` 
            SET `clp_activated` = "activate", `clp_date_update`=? 
            WHERE `clp_course_id`=? LIMIT 1', array($date, $course_id));

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
     * Деактивация Landing page курса
     * @param $course_id
     * @param $date
     * @return bool
     */
    public function deactivateCourseLandingPage($course_id, $date)
    {
        $up_data = $this->db->query('
            UPDATE `courses_landing_pages` 
            SET `clp_activated` = "deactivate", `clp_date_update`=? 
            WHERE `clp_course_id`=? LIMIT 1', array($date, $course_id));

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

    /* КОНЕЦ БЛОКА ОБРАБОТКИ ДАННЫХ LANDING PAGE КУРСА */

    /* БЛОК УДАЛЕНИЯ КУРСА */

    /**
     * Удаление курса
     *
     * @param $course_id
     * @return bool
     */
    public function deleteCourse($course_id)
    {
        $sel_course = $this->db->query('SELECT `crs_image` FROM `courses` WHERE `crs_id`=? LIMIT 1', $course_id);
        if ($sel_course !== false and 1 == $sel_course->num_rows())
        {
            $row = $sel_course->row();

            // Удаление изображения курса
            if (!empty($row->crs_image) and is_file($row->crs_image))
            {
                unlink($row->crs_image);
            }
        }
        elseif ($sel_course === false)
        {
            parent::logDbMessages(__METHOD__);
            return false;
        }

        // Удаление курса
        $up_data = $this->db->query('DELETE FROM `courses` WHERE `crs_id`=? LIMIT 1', $course_id);

        if ($up_data !== false and 1 == $this->db->affected_rows())
        {
            // Удалить курс как товар
            self::deleteCourseProduct($course_id);

            // Удалить тренировки курса
            self::deleteCourseWorkouts($course_id);

            // Удалить прикреплённых тренеров к курсу
            self::deleteCourseCouches($course_id);

            // Удалить landing курса
            self::deleteCourseLanding($course_id);

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
     * Удаление курса из таблицы товаров
     *
     * @param $course_id
     * @return bool
     */
    protected function deleteCourseProduct($course_id)
    {
        $up_data = $this->db->query('DELETE FROM `products` WHERE `p_course_id`=? LIMIT 1', $course_id);

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
     * Удаление тренировок курса
     *
     * @param $course_id
     * @return bool
     */
    protected function deleteCourseWorkouts($course_id)
    {
        $up_data = $this->db->query('DELETE FROM `courses_training_weeks` WHERE `ctw_course_id`=?', $course_id);

        if ($up_data !== false and 0 < $this->db->affected_rows())
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
     * Удаление прекрепленных к курс тренеров
     *
     * @param $course_id
     * @return bool
     */
    protected function deleteCourseCouches($course_id)
    {
        $up_data = $this->db->query('DELETE FROM `courses_couches` WHERE `cc_course_id`=?', $course_id);

        if ($up_data !== false and 0 < $this->db->affected_rows())
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
     * Удаление landing курса
     *
     * @param $course_id
     * @return bool
     */
    protected function deleteCourseLanding($course_id)
    {
        $sel_landing = $this->db->query('
            SELECT `clp_id`, `clp_slider_images`, `clp_block2_background`, `clp_block2_image`, `clp_block3_background`, 
              `clp_block3_images`, `clp_block4_background`, `clp_block4_image`, `clp_block5_background`, `clp_block5_images`, 
              `clp_block6_background`, `clp_block6_image`, `clp_block7_background`, `clp_block7_images`, `clp_block8_background` 
            FROM `courses_landing_pages` 
            WHERE `clp_course_id`=? LIMIT 1', $course_id);

        if ($sel_landing !== false and 1 == $sel_landing->num_rows())
        {
            $row = $sel_landing->row();

            $up_data = $this->db->query('DELETE FROM `courses_landing_pages` WHERE `clp_course_id` LIMIT 1', $course_id);

            if ($up_data !== false and 1 == $this->db->affected_rows())
            {
                // Удаление изображений слайдера
                if (!empty($row->clp_slider_images) and $row->clp_slider_images != 'default') {
                    $s_images = explode(';', $row->clp_slider_images);

                    foreach ($s_images as $image) {
                        if (is_file($image)) {
                            unlink($image);
                        }
                    }
                    unset($image);
                }

                // Удаление фоновых изображений блоков
                if (!empty($row->clp_block2_background) and $row->clp_block2_background != 'default' and is_file($row->clp_block2_background)) {
                    unlink($row->clp_block2_background);
                }
                if (!empty($row->clp_block3_background) and $row->clp_block3_background != 'default' and is_file($row->clp_block3_background)) {
                    unlink($row->clp_block3_background);
                }
                if (!empty($row->clp_block4_background) and $row->clp_block4_background != 'default' and is_file($row->clp_block4_background)) {
                    unlink($row->clp_block4_background);
                }
                if (!empty($row->clp_block5_background) and $row->clp_block5_background != 'default' and is_file($row->clp_block5_background)) {
                    unlink($row->clp_block5_background);
                }
                if (!empty($row->clp_block6_background) and $row->clp_block6_background != 'default' and is_file($row->clp_block6_background)) {
                    unlink($row->clp_block6_background);
                }
                if (!empty($row->clp_block7_background) and $row->clp_block7_background != 'default' and is_file($row->clp_block7_background)) {
                    unlink($row->clp_block7_background);
                }
                if (!empty($row->clp_block8_background) and $row->clp_block8_background != 'default' and is_file($row->clp_block8_background)) {
                    unlink($row->clp_block8_background);
                }

                // Удаление изображений блоков
                if (!empty($row->clp_block2_image) and $row->clp_block2_image != 'default' and is_file($row->clp_block2_image)) {
                    unlink($row->clp_block2_image);
                }
                if (!empty($row->clp_block3_images)) {
                    $s_images = explode(';', $row->clp_block3_images);

                    foreach ($s_images as $image) {
                        if ($image != 'default' and is_file($image)) {
                            unlink($image);
                        }
                    }
                    unset($image);
                }
                if (!empty($row->clp_block4_image) and $row->clp_block4_image != 'default' and is_file($row->clp_block4_image)) {
                    unlink($row->clp_block4_image);
                }
                if (!empty($row->clp_block5_images)) {
                    $s_images = explode(';', $row->clp_block5_images);

                    foreach ($s_images as $image) {
                        if ($image != 'default' and is_file($image)) {
                            unlink($image);
                        }
                    }
                    unset($image);
                }
                if (!empty($row->clp_block6_image) and $row->clp_block6_image != 'default' and is_file($row->clp_block6_image)) {
                    unlink($row->clp_block6_image);
                }
                if (!empty($row->clp_block7_images)) {
                    $s_images = explode(';', $row->clp_block7_images);

                    foreach ($s_images as $image) {
                        if ($image != 'default' and is_file($image)) {
                            unlink($image);
                        }
                    }
                    unset($image);
                }

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
        elseif ($sel_landing === false)
        {
            parent::logDbMessages(__METHOD__);
            return false;
        }
        else
        {
            return false;
        }
    }

    /* КОНЕЦ БЛОКА УДАЛЕНИЯ КУРСА */


    /* БЛОК ФУНКЦИЙ ДЛЯ РАБОТЫ С ВИДЕО */

    /**
     * Сохранение данных о видео в БД
     *
     * @param int $type Категория видео
     * @param int $course_id Id курса
     * @param string $name Наименование видео
     * @param string $path_file Путь к файлу видео
     * @param string $poster Постер к видео
     * @param string $remove_url URL видео на другом сервере
     * @param int $user_id ID пользователя, добавивший видео
     * @param datetime $date
     * @return bool|int
     */
    public function setNewVideo($type, $course_id, $name, $path_file, $poster, $remove_url, $user_id, $date)
    {
        $up_data = $this->db->query('
            INSERT INTO `video` (`video_type`, `video_crs_id`, `video_name`, `video_path`, `video_poster`, `video_remove_url`, 
              `video_user_add`, `video_date_add`, `video_date_update`) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)',
                array($type, $course_id, $name, $path_file, $poster, $remove_url, $user_id, $date, $date));

        if ($up_data !== false and 1 == $this->db->affected_rows())
        {
            return $this->db->insert_id();
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
     * Получение списка видео
     *
     * @return array
     */
    public function getPromoVideo()
    {
        $result = array();

        $sel_video = $this->db->query('
            SELECT `video_id`, `video_name`, `video_poster`, `video_type` 
            FROM `video`
            WHERE `video_type`=1');

        if ($sel_video !== false and 0 < $sel_video->num_rows())
        {
            $i = 0;
            foreach ($sel_video->result() as $row)
            {
                $result['video'][$i] = self::parseVideoData($row);
                $result['video'][$i]['name'] = !empty($row->video_name) ? $row->video_name : $row->video_id;

                $i++;
            }
            unset($row);
        }
        elseif ($sel_video === false)
        {
            parent::logDbMessages(__METHOD__);
        }
        
        return $result;
    }

    /**
     * Получение списка курсов, к которым прикреплены видео тренировок
     *
     * @return array
     */
    public function getVideoCourses()
    {
        $result = array();

        $sel_video = $this->db->query('
            SELECT `video_crs_id`, `crs_name`, `crs_image` 
            FROM `video`
            LEFT JOIN `courses` ON `crs_id`=`video_crs_id`
            WHERE `video_crs_id`>0 and `video_type`=2
            GROUP BY `video_crs_id`');

        if ($sel_video !== false and 0 < $sel_video->num_rows())
        {
            $i = 0;
            foreach ($sel_video->result() as $row)
            {
                $result['courses'][$i]['id']    = $row->video_crs_id;
                $result['courses'][$i]['name']  = !empty($row->crs_name) ? $row->crs_name : 'Курс №' . $row->video_crs_id;
                $result['courses'][$i]['image'] = is_file($row->crs_image) ? mb_substr($row->crs_image, 1) : '';

                $i++;
            }
            unset($row);
        }
        elseif ($sel_video === false)
        {
            parent::logDbMessages(__METHOD__);
        }

        return $result;
    }

    /**
     * Получение списка видео курса
     *
     * @param $course_id
     * @return array
     */
    public function getCourseVideo($course_id)
    {
        $result = array();

        $sel_video = $this->db->query('
            SELECT `video_id`, `video_name`, `video_poster`, `video_type` 
            FROM `video`
            WHERE `video_crs_id`=? and `video_type`=2', $course_id);

        if ($sel_video !== false and 0 < $sel_video->num_rows())
        {
            $i = 0;
            foreach ($sel_video->result() as $row)
            {
                $result['video'][$i] = self::parseVideoData($row);
                $result['video'][$i]['name'] = !empty($row->video_name) ? $row->video_name : $row->video_id;

                $i++;
            }
            unset($row);
        }
        elseif ($sel_video === false)
        {
            parent::logDbMessages(__METHOD__);
        }

        return $result;
    }

    /**
     * Список видео курса категории "Промо"
     *
     * @param $course_id
     * @return array
     */
    public function getCoursePromoVideo($course_id)
    {
        $result = array();

        $sel_video = $this->db->query('
            SELECT `video_id`, `video_name`, `video_poster`, `video_type` 
            FROM `video`
            WHERE `video_crs_id`=? and `video_type`=1', $course_id);

        if ($sel_video !== false and 0 < $sel_video->num_rows())
        {
            $i = 0;
            foreach ($sel_video->result() as $row)
            {
                $result['video'][$i] = self::parseVideoData($row);
                $result['video'][$i]['name'] = !empty($row->video_name) ? $row->video_name : $row->video_id;

                $i++;
            }
            unset($row);
        }
        elseif ($sel_video === false)
        {
            parent::logDbMessages(__METHOD__);
        }

        return $result;
    }

    /**
     * Список видео курса категории "Тренировки"
     *
     * @param $course_id
     * @return array
     */
    public function getCourseWorkoutVideo($course_id)
    {
        $result = array();

        $sel_video = $this->db->query('
            SELECT `video_id`, `video_name`, `video_poster`, `video_type` 
            FROM `video`
            WHERE `video_crs_id`=? and `video_type`=2', $course_id);

        if ($sel_video !== false and 0 < $sel_video->num_rows())
        {
            $i = 0;
            foreach ($sel_video->result() as $row)
            {
                $result['video'][$i] = self::parseVideoData($row);
                $result['video'][$i]['name'] = !empty($row->video_name) ? $row->video_name : $row->video_id;

                $i++;
            }
            unset($row);
        }
        elseif ($sel_video === false)
        {
            parent::logDbMessages(__METHOD__);
        }

        return $result;
    }

    /**
     * Список видео курса категории "Инструктажи"
     *
     * @param $course_id
     * @return array
     */
    public function getCourseInstructionsVideo($course_id)
    {
        $result = array();

        $sel_video = $this->db->query('
            SELECT `video_id`, `video_name`, `video_poster`, `video_type` 
            FROM `video`
            WHERE `video_crs_id`=? and `video_type`=3', $course_id);

        if ($sel_video !== false and 0 < $sel_video->num_rows())
        {
            $i = 0;
            foreach ($sel_video->result() as $row)
            {
                $result['video'][$i] = self::parseVideoData($row);
                $result['video'][$i]['name'] = !empty($row->video_name) ? $row->video_name : $row->video_id;

                $i++;
            }
            unset($row);
        }
        elseif ($sel_video === false)
        {
            parent::logDbMessages(__METHOD__);
        }

        return $result;
    }

    /**
     * Выборка данных видео курса
     *
     * @param $course_id
     * @param $video_id
     * @return array|bool
     */
    public function getCourseVideoData($course_id, $video_id)
    {
        $result = array();

        $sel_video = $this->db->query('
            SELECT `video_id`, `video_type`, `video_crs_id`, `video_name`, `video_remove_url`, `video_poster`, `video_path`, `video_blocked` 
            FROM `video`
            WHERE `video_crs_id`=? and `video_id`=? LIMIT 1', array($course_id, $video_id));

        if ($sel_video !== false and 1 == $sel_video->num_rows())
        {
            $row = $sel_video->row();

            $result['video'] = self::parseVideoData($row);
        }
        elseif ($sel_video === false)
        {
            parent::logDbMessages(__METHOD__);
            $result = false;
        }
        else
        {
            $result = false;
        }

        return $result;
    }

    /**
     * Получение списка видео без категории
     *
     * @return array
     */
    public function getUncategorizedVideo()
    {
        $result = array();

        $sel_video = $this->db->query('
            SELECT `video_id`, `video_name`, `video_poster`, `video_type` 
            FROM `video`
            WHERE `video_type`=0');

        if ($sel_video !== false and 0 < $sel_video->num_rows())
        {
            $i = 0;
            foreach ($sel_video->result() as $row)
            {
                $result['video'][$i] = self::parseVideoData($row);
                $result['video'][$i]['name'] = !empty($row->video_name) ? $row->video_name : $row->video_id;

                $i++;
            }
            unset($row);
        }
        elseif ($sel_video === false)
        {
            parent::logDbMessages(__METHOD__);
        }

        return $result;
    }

    /**
     * Получение списка видео категории "Инструктажи"
     *
     * @return array
     */
    public function getInstructionsVideo()
    {
        $result = array();

        $sel_video = $this->db->query('
            SELECT `video_id`, `video_name`, `video_poster`, `video_type` 
            FROM `video`
            WHERE `video_type`=3');

        if ($sel_video !== false and 0 < $sel_video->num_rows())
        {
            $i = 0;
            foreach ($sel_video->result() as $row)
            {
                $result['video'][$i] = self::parseVideoData($row);
                $result['video'][$i]['name'] = !empty($row->video_name) ? $row->video_name : $row->video_id;

                $i++;
            }
            unset($row);
        }
        elseif ($sel_video === false)
        {
            parent::logDbMessages(__METHOD__);
        }

        return $result;
    }

    /**
     * Выборка промо роликов курсов для вывода на главной странице сайта
     *
     * @return array
     */
    public function getAvaliablePromoVideo()
    {
        $result = array();

        $sel_video = $this->db->query('
            SELECT `video_id`, `video_name`, `video_path`, `video_poster`, `video_remove_url`, `video_crs_id`, 
              `crs_name`, `crs_blocked`
            FROM `video`
            LEFT JOIN `courses` ON `crs_id`=`video_crs_id`
            WHERE `video_blocked`=0 and `video_type`=1 and `video_crs_id`>0 and `crs_blocked`=0
            GROUP BY `video_crs_id`
            ORDER BY `video_date_add` DESC');

        if ($sel_video !== false and 0 < $sel_video->num_rows())
        {
            $i = 0;
            foreach ($sel_video->result() as $row)
            {
                $result['video'][$i] = self::parseVideoData($row);

                $i++;
            }
            unset($row);
        }
        elseif ($sel_video === false)
        {
            parent::logDbMessages(__METHOD__);
        }

        return $result;
    }

    /**
     * Получение данных видео
     *
     * @param int $video_id
     * @return array
     */
    public function getVideo($video_id)
    {
        $result = array();

        $video_id = (int) $video_id;

        $sel_video = $this->db->query('
            SELECT `video_id`, `video_type`, `video_crs_id`, `video_name`, `video_remove_url`, `video_poster`, `video_path`, `video_blocked` 
            FROM `video`
            WHERE `video_id`=? LIMIT 1', $video_id);

        if ($sel_video !== false and 1 == $sel_video->num_rows())
        {
            $row = $sel_video->row();

            $result['video'] = self::parseVideoData($row);
        }
        elseif ($sel_video === false)
        {
            parent::logDbMessages(__METHOD__);
            $result = false;
        }
        else
        {
            $result = false;
        }

        return $result;
    }

    /**
     * Получение данных видео тренивроки
     *
     * @param int $user_id
     * @param string $date
     * @return bool|array
     */
    public function getWorkoutVideo($user_id, $date)
    {
        $result = false;

        $tmp_date = DateTime::createFromFormat('Y-m-d H:i:s', $date);
        $today    = $tmp_date->format('Y-m-d');
        $video_id = 0;
        $video_description = '';

        // Выборка пользовательских курсов
        $sel_user_courses = $this->db->query('SELECT `uc_id`, `uc_course_id` FROM `users_courses` WHERE `uc_user_id`=?', $user_id);
        if ($sel_user_courses !== false and 0 < $sel_user_courses->num_rows())
        {
            $i = 0;
            foreach($sel_user_courses->result() as $row)
            {

                // Выборка пользовательских данных о тренировке на сегодня
                $sel_today_workout = $this->db->query('
                    SELECT `utw_uc_id`, `utw_workout`, `utw_duplicate`, `utw_done`, `utw_date` 
                    FROM `users_training_weeks`
                    WHERE `utw_uc_id`=? and `utw_date`=? and `utw_duplicate`=0 LIMIT 1', array($row->uc_id, $today));

                if ($sel_today_workout !== false and 1 == $sel_today_workout->num_rows())
                {
                    $w_row = $sel_today_workout->row();

                    $result['workouts'][$i]['course']  = $row->uc_course_id;
                    $result['workouts'][$i]['workout'] = $w_row->utw_workout;
                    $result['workouts'][$i]['done']    = $w_row->utw_done;

                    unset($w_row);
                }
                elseif ($sel_today_workout === false)
                {
                    parent::logDbMessages(__METHOD__);
                }

                $i++;
            }
            unset($row);

            // Данные тренировки и инструктажа курса
            foreach ($result['workouts'] as $key => $cw)
            {
                // Данные тренировки курса
                $sel_course_workout = $this->db->query('
                    SELECT `ctw_id`, `ctw_course_id`, `ctw_num_workout`, `ctw_description`, `ctw_video_id`, `ctw_repeat_workout` 
                    FROM `courses_training_weeks`
                    WHERE `ctw_course_id`=? and `ctw_num_workout`=? LIMIT 1', array($cw['course'], $cw['workout']));

                if ($sel_course_workout !== false and 1 == $sel_course_workout->num_rows())
                {
                    $row = $sel_course_workout->row();

                    if ($row->ctw_repeat_workout > 0)
                    {
                        // Выборка ID видео повторяемой тренировки
                        $sel_repeat_workout = $this->db->query('
                            SELECT `ctw_video_id`, `ctw_description` 
                            FROM `courses_training_weeks`
                            WHERE `ctw_course_id`=? and `ctw_num_workout`=? LIMIT 1', array($cw['course'], $row->ctw_repeat_workout));

                        if ($sel_repeat_workout !== false and 1 == $sel_repeat_workout->num_rows())
                        {
                            $row2 = $sel_repeat_workout->row();

                            $video_id = $row2->ctw_video_id;
                            $video_description = $row2->ctw_description;

                            unset($row2);
                        }
                        elseif ($sel_repeat_workout === false)
                        {
                            parent::logDbMessages(__METHOD__);
                        }
                    }
                    else
                    {
                        $video_id = $row->ctw_video_id;
                        $video_description = $row->ctw_description;
                    }
                    unset($row);

                    $result['workouts'][$key]['video_id'] = $video_id;
                    $result['workouts'][$key]['description'] = $video_description;
                }
                elseif ($sel_course_workout === false)
                {
                    parent::logDbMessages(__METHOD__);
                }

                // Данные инструктажа тренировки
                $sel_instruction = $this->db->query('
                    SELECT `ctw_video_id` 
                    FROM `courses_training_weeks`
                    WHERE `ctw_course_id`=? and `ctw_num_workout`=0 LIMIT 1', $cw['course']);

                if ($sel_instruction !== false and 1 == $sel_instruction->num_rows())
                {
                    $row = $sel_instruction->row();

                    $result['workouts'][$key]['instruction'] = $row->ctw_video_id;

                    unset($row);
                }
                elseif ($sel_instruction === false)
                {
                    parent::logDbMessages(__METHOD__);
                }
            }
            unset($cw);
        }
        elseif ($sel_user_courses === false)
        {
            parent::logDbMessages(__METHOD__);
        }

        return $result;
    }

    /**
     * Определение соответствия ID видео и ID тренировки -> ID курса и ID пользователя
     *
     * @param int $user_id ID пользователя
     * @param int $workout_id Уникальное ID тренировки в таблице `utw_training_weeks` (`utw_id`)
     * @param int $video_id ID видео
     * @return bool|int
     */
    public function matchWorkoutVideo($user_id, $workout_id, $video_id)
    {
        $db_video_id     = null; // ID видео с БД
        $db_workout_desc = null; // Описание видео с БД
        $instruction     = null;
        $workout_done    = null;

        // Нахождение уникального ID курса, пользователя и номера тренировки курса
        $sel_utw = $this->db->query('
          SELECT `utw_uc_id`, `utw_workout`, `utw_done` 
          FROM `users_training_weeks`
          WHERE `utw_id`=? LIMIT 1', $workout_id);

        if ($sel_utw !== false and 1 == $sel_utw->num_rows())
        {
            $row = $sel_utw->row();

            $uc_id        = $row->utw_uc_id; // Уникальное ID курса и пользователя
            $workout_num  = $row->utw_workout; // Номер тренировки курса
            $workout_done = $row->utw_done; // Выполнена ли тренировки

            unset($row);
            $sel_utw->free_result();

            // Определение ID курса
            $sel_uc = $this->db->query('
              SELECT `uc_course_id` 
              FROM `users_courses` 
              WHERE `uc_id`=? and `uc_user_id`=? LIMIT 1', array($uc_id, $user_id));

            if ($sel_uc !== false and 1 == $sel_uc->num_rows())
            {
                $row = $sel_uc->row();

                $course_id = $row->uc_course_id; // ID курса

                unset($row);
                $sel_uc->free_result();

                // Определение ID видео для тренировки
                $sel_ctw = $this->db->query('
                    SELECT `ctw_num_workout`, `ctw_video_id`, `ctw_repeat_workout`, `ctw_description` 
                    FROM `courses_training_weeks`
                    WHERE `ctw_course_id`=? and `ctw_num_workout`=? LIMIT 1', array($course_id, $workout_num));

                if ($sel_ctw !== false and 1 == $sel_ctw->num_rows())
                {
                    $row = $sel_ctw->row();

                    if ($row->ctw_repeat_workout == 0 and $row->ctw_video_id > 0)
                    {
                        $db_video_id     = $row->ctw_video_id;
                        $db_workout_desc = $row->ctw_description;
                    }
                    elseif ($row->ctw_repeat_workout > 0 and $row->ctw_video_id == 0)
                    {
                        $sel_repeat_workout = $this->db->query('
                            SELECT `ctw_num_workout`, `ctw_video_id`, `ctw_repeat_workout`, `ctw_description` 
                            FROM `courses_training_weeks`
                            WHERE `ctw_course_id`=? and `ctw_num_workout`=? LIMIT 1', array($course_id, $row->ctw_repeat_workout));

                        if ($sel_repeat_workout !== false and 1 == $sel_repeat_workout->num_rows())
                        {
                            $row2 = $sel_repeat_workout->row();

                            $db_video_id     = $row2->ctw_video_id;
                            $db_workout_desc = $row2->ctw_description;

                            unset($row2);
                        }
                        elseif ($sel_repeat_workout === false)
                        {
                            parent::logDbMessages(__METHOD__);
                        }
                    }
                    unset($row);

                    // Данные инструктажа тренировки
                    $sel_instruction = $this->db->query('
                        SELECT `ctw_video_id` 
                        FROM `courses_training_weeks`
                        WHERE `ctw_course_id`=? and `ctw_num_workout`=0 LIMIT 1', $course_id);

                    if ($sel_instruction !== false and 1 == $sel_instruction->num_rows())
                    {
                        $row = $sel_instruction->row();

                        $instruction = $row->ctw_video_id;

                        unset($row);
                    }
                    elseif ($sel_instruction === false)
                    {
                        parent::logDbMessages(__METHOD__);
                    }
                }
                elseif ($sel_ctw === false)
                {
                    parent::logDbMessages(__METHOD__);
                }
            }
            elseif ($sel_uc === false)
            {
                parent::logDbMessages(__METHOD__);
            }
        }
        elseif ($sel_utw === false)
        {
            parent::logDbMessages(__METHOD__);
        }

        if (!empty($db_video_id) and $video_id == $db_video_id)
        {
            $result['workout']['video_id']    = $video_id;
            $result['workout']['done']        = $workout_done;
            $result['workout']['description'] = $db_workout_desc;
            $result['workout']['instruction'] = $instruction;

            return $result;
        }
        else
        {
            return false;
        }
    }

    /**
     * Сохранение данных о видео в БД
     *
     * @param int $video_id
     * @param int $type Категория видео
     * @param int $course_id ID курса
     * @param string $video_path Путь к файлу видео
     * @param string $name Наименование видео
     * @param string $poster_path Постер к видео
     * @param string $remove_url URL видео на другом сервере
     * @param int $user_id ID пользователя, добавивший видео
     * @param datetime $date
     * @return bool
     */
    public function setVideoSettings($video_id, $type, $course_id, $video_path, $name, $poster_path, $remove_url, $user_id, $date)
    {
        $up_data = $this->db->query('
            UPDATE `video` 
            SET `video_type`=?, `video_crs_id`=?, `video_name`=?, `video_path`=?, `video_poster`=?, `video_remove_url`=?, `video_date_update`=? 
            WHERE `video_id`=? LIMIT 1', array($type, $course_id, $name, $video_path, $poster_path, $remove_url, $date, $video_id));

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
     * Блокировка видео
     *
     * @param $video_id
     * @param $date
     * @return bool
     */
    public function blockVideo($video_id, $date)
    {
        $up_data = $this->db->query('
            UPDATE `video` 
            SET `video_blocked`=1, `video_date_update`=? 
            WHERE `video_id`=? LIMIT 1', array($date, $video_id));

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
     * Разблокировка видео
     *
     * @param $video_id
     * @param $date
     * @return bool
     */
    public function unblockVideo($video_id, $date)
    {
        $up_data = $this->db->query('
            UPDATE `video` 
            SET `video_blocked`=0, `video_date_update`=? 
            WHERE `video_id`=? LIMIT 1', array($date, $video_id));

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
     * Удаление данных видео
     *
     * @param $video_id
     * @return bool
     */
    public function deleteVideo($video_id)
    {
        $result = true;

        $data = self::getVideo($video_id);

        if (!empty($data)) {

            $up_data = $this->db->query('DELETE FROM `video` WHERE `video_id`=? LIMIT 1', $video_id);

            if ($up_data !== false and 1 == $this->db->affected_rows())
            {
                if (!empty($data['video']['poster']))
                {
                    unlink('.' . $data['video']['poster']);
                }
                if (!empty($data['video']['video']))
                {
                    unlink('.' . $data['video']['video']);
                }
            }
            elseif ($up_data === false)
            {
                parent::logDbMessages(__METHOD__);
                $result = false;
            }
            else
            {
                $result = false;
            }
        }
        else
        {
            $result = false;
        }

        return $result;
    }

    /* КОНЕЦ БЛОКА ФУНКЦИЙ ДЛЯ РАБОТЫ С ВИДЕО */


    /* НАЧАЛО БЛОКА ОБРАБОТКИ ДАННЫХ КУРСА ПОЛЬЗОВАТЕЛЕЙ */

    /**
     * Выборка курсов пользователя
     *
     * @param int $user_id
     * @param string $date
     * @param array|null $user_training_time
     * @return array
     */
    public function getUserCourses($user_id, $date, $user_training_time = null)
    {
        $result = array('courses' => array(), 'events' => array());

        $sel_courses = $this->db->query('
            SELECT `uc_id`, `uc_course_id`, `uc_couch_id`, `uc_days`, `uc_date_start`, `uc_date_end`, `uc_blocked`, 
                `uc_paused`, `uc_pause_days`, `crs_image`, `crs_name`, `crs_description`, `crs_count_weeks`, `crs_count_days` 
            FROM `users_courses` 
            LEFT JOIN `courses` ON `uc_course_id`=`crs_id`
            WHERE `uc_user_id`=? and `uc_blocked`=0', $user_id);

        if ($sel_courses !== false and 0 < $sel_courses->num_rows())
        {
            $i = 0;
            foreach ($sel_courses->result() as $row)
            {
                $result['courses'][$i]['id']          = $row->uc_id;
                $result['courses'][$i]['course_id']   = $row->uc_course_id;
                $result['courses'][$i]['image']       = !empty($row->crs_image) ? mb_substr($row->crs_image, 1) : '';
                $result['courses'][$i]['name']        = $row->crs_name;
                $result['courses'][$i]['description'] = $row->crs_description;
                $result['courses'][$i]['course_days'] = $row->crs_count_days;
                $result['courses'][$i]['count_weeks'] = $row->crs_count_weeks;
                $result['courses'][$i]['count_days']  = $row->crs_count_days;
                $result['courses'][$i]['user_couch']  = $row->uc_couch_id;
                $result['courses'][$i]['days']        = $row->uc_days != 0 ? str_split($row->uc_days) : null;
                $result['courses'][$i]['date_start']  = $row->uc_date_start;
                $result['courses'][$i]['date_end']    = $row->uc_date_end;
                $result['courses'][$i]['blocked']     = $row->uc_blocked;
                $result['courses'][$i]['paused']      = $row->uc_paused;
                $result['courses'][$i]['pause_days']  = $row->uc_pause_days;

                $i++;
            }
            unset($row);
            unset($i);
            $sel_courses->free_result();

            // Тренеры курса
            foreach ($result['courses'] as $key => $course)
            {
                $result['courses'][$key] = array_merge($result['courses'][$key], self::getCourseCouches($course['course_id']));
            }

            // Паузы в тренировках и тренировки пользователя
            $ei = 0;
            $color = array(42, 202, 242);
            foreach ($result['courses'] as $key => $course)
            {
                $tmp_date = DateTime::createFromFormat('Y-m-d H:i:s', $date);
                $today    = $tmp_date->format('Y-m-d');
                $workouts = null;
                $pauses   = null;
                $events   = null;

                // Если выбраны тренировочные дни, проверить тренировки, паузы
                if (is_array($course['days']))
                {
                    // Массив дней недели тренировок, выбранные пользователем
                    $array_training_days = $course['days'];
                    // Флаг начала отсчета дат после заморозки
                    $set_start_date = true;

                    // Паузы тренировок
                    $sel_course_pauses = $this->db->query('
                        SELECT `ucp_pause_start`, `ucp_pause_end` 
                        FROM `users_courses_pauses`
                        WHERE `ucp_uc_id`=?', $course['id']);
                    if ($sel_course_pauses !== false and 0 < $sel_course_pauses->num_rows()) {
                        $i = 0;
                        foreach ($sel_course_pauses->result() as $row) {
                            $pauses[$i]['start'] = $row->ucp_pause_start;
                            $pauses[$i]['end']   = $row->ucp_pause_end;

                            $i++;
                        }
                        unset($row);
                        unset($i);
                    }
                    elseif ($sel_course_pauses === false)
                    {
                        parent::logDbMessages(__METHOD__);
                    }

                    // Определение даты первой тренировки, которая уже будет считаться пропущенной
                    // Добавление пропущенный тренировок в БД
                    $sel_f_workout = $this->db->query('
                        SELECT `utw_id`, `utw_uc_id`, `utw_workout`, `utw_done`, `utw_date`
                        FROM `users_training_weeks`
                        WHERE `utw_uc_id`=? and `utw_date`<? and `utw_done`=0 and `utw_duplicate`=0
                        ORDER BY `utw_date` ASC
                        LIMIT 1', array($course['id'], $today));
                    if ($sel_f_workout !== false and 1 == $sel_f_workout->num_rows())
                    {
                        $row = $sel_f_workout->row();

                        $start_missed_date = $row->utw_date;
                        $missed_dates = array(); // Массив дат пропущенных дней тренировок

                        // Разница между датами
                        $datetime1   = new DateTime($today);
                        $datetime2   = new DateTime($start_missed_date);
                        $interval    = $datetime1->diff($datetime2);
                        $days_missed = $interval->format('%a');

                        $training_date = $start_missed_date;
                        for ($i = 0; $i <= $days_missed; $i++)
                        {
                            // Если дата пропущенной тренировки меньше текущей, иначе прерываем цикл
                            if ($training_date < $today)
                            {
                                // Сравнения номера дня недели с днями недели тренировок. Номер дня недели текущей тренировки
                                $current_num_day = date("N", strtotime($training_date));
                                // Новая дата пропущенной тренировки
                                $new_training_date = $training_date;

                                // Если текущий номер дня недели не присутствует в массиве выбранных тренировочных дней неделе,
                                // то вычисляем дату следующего дня недели тренировки.
                                if (!in_array($current_num_day, $array_training_days))
                                {
                                    // Поиск большего номера дня недели
                                    foreach ($array_training_days as $training_day)
                                    {
                                        if ($training_day > $current_num_day)
                                        {
                                            $diff_days = $training_day - $current_num_day;

                                            $tmp_date = DateTime::createFromFormat('Y-m-d', $training_date);
                                            $tmp_date->add(new DateInterval('P' . $diff_days . 'D'));
                                            $new_training_date = ($tmp_date !== false) ? $tmp_date->format('Y-m-d') : $training_date;
                                            break;
                                        }
                                    }
                                    unset($training_day);

                                    // Если дата тренировки осталась не измененной, выбираем первый день недели тренировки
                                    // пользователя и вычисляем её дату
                                    if ($new_training_date >= $training_date)
                                    {
                                        // От 7 дней недели отнимаем день недели предыдущей тренировки и прибавляем день недели первой тренировки на неделе
                                        $diff_days = 7 - $current_num_day + $array_training_days[0];

                                        // Временная дата предыдущей тренивроки
                                        $tem_date = new DateTime($training_date);

                                        // Дата текущей тренировки, с учетом разницы между тренировками ( + $diff_days дней )
                                        $tem_date->add(new DateInterval('P' . $diff_days . 'D'));

                                        $new_training_date = $tem_date->format('Y-m-d');
                                    }
                                }

                                // Следующая дата
                                $tmp_date = new DateTime($new_training_date);
                                $tmp_date->add(new DateInterval('P1D'));
                                $training_date = $tmp_date->format('Y-m-d');

                                if ($new_training_date < $today)
                                {
                                    $missed_dates[$i] = $new_training_date;
                                }
                                else
                                {
                                    break;
                                }
                            }
                            else
                            {
                                break;
                            }
                        }

                        // Добавляем пропущенные тренировки курса
                        /*print_r($missed_dates); echo '<br/>';*/
                        if (!empty($missed_dates)) {
                            $value = '';
                            foreach ($missed_dates as $missed_date) {
                                if (!empty($value)) {
                                    $value .= ', ';
                                }
                                $value .= '(' . $course['id'] .', 1, 1, "' . $missed_date . '", "' . $date . '")';
                            }

                            if (!empty($value)) {
                                $up_data = $this->db->query('
                                INSERT INTO `users_training_weeks`
                                    (`utw_uc_id`, `utw_workout`, `utw_duplicate`, `utw_date`, `utw_date_update`)
                                VALUES ' . $value);
                                if ($up_data === false)
                                {
                                    parent::logDbMessages(__METHOD__);
                                }
                            }
                        }

                        unset($row);
                    }
                    elseif ($sel_f_workout === false)
                    {
                        parent::logDbMessages(__METHOD__);
                    }

                    // Обработка тренировок, проверка на пропущенные занятия
                    // Изменение дат будущих тренировок (смещение курса)
                    $sel_workouts = $this->db->query('
                        SELECT `utw_id`, `utw_uc_id`, `utw_workout`, `utw_done`, `utw_date`
                        FROM `users_training_weeks`
                        WHERE `utw_uc_id`=? and `utw_duplicate`=0
                        ORDER BY `utw_date` ASC', $course['id']);
                    if ($sel_workouts !== false and 0 < $sel_workouts->num_rows())
                    {
                        $i = 0;

                        $training_date = $today;
                        $next_workout  = false; // Флаг продолжения вычисления новых дат тренировок
                        $update_date   = false; // Флаг обновления даты тренировки

                        foreach ($sel_workouts->result() as $row)
                        {
                            $new_training_date = null; // Новая дата тренировки

                            // Обновление дат тренировок
                            if ($today > $row->utw_date and $row->utw_done == 0)
                            {
                                // Сравнения номера дня недели с днями недели тренировок
                                $current_num_day = date("N", strtotime($training_date));

                                // Изменение даты первой пропущенной тренировки.
                                if ($next_workout === false)
                                {
                                    // Если текущий номер дня недели не присутствует в массиве выбранных тренировочных дней неделе,
                                    // то вычисляем дату следующего дня недели тренировки.
                                    if (!in_array($current_num_day, $array_training_days))
                                    {
                                        // Поиск большего номера дня недели и вычисление его новой даты
                                        foreach ($array_training_days as $key => $training_day)
                                        {
                                            if ($training_day > $current_num_day)
                                            {
                                                $diff_days = $training_day - $current_num_day;

                                                $tmp_date = DateTime::createFromFormat('Y-m-d', $training_date);
                                                $tmp_date->add(new DateInterval('P' . $diff_days . 'D'));
                                                $new_training_date = ($tmp_date !== false) ? $tmp_date->format('Y-m-d') : null;
                                                break;
                                            }
                                        }
                                        unset($training_day);

                                        // Если новая дата тренировки не вычислена, выбираем первый день недели тренировки
                                        // пользователя и вычисляем её дату
                                        if (empty($new_training_date))
                                        {
                                            // От 7 дней недели отнимаем день недели предыдущей тренировки и прибавляем день недели первой тренировки на неделе
                                            $diff_days = 7 - $current_num_day + $array_training_days[0];
                                            // Временная дата предыдущей тренивроки
                                            $tem_date = new DateTime($training_date);
                                            // Дата текущей тренировки, с учетом разницы между тренировками ( + $diff_days дней )
                                            $tem_date->add(new DateInterval('P' . $diff_days . 'D'));

                                            $new_training_date = ($tem_date !== false) ? $tem_date->format('Y-m-d') : null;
                                        }
                                    }
                                    else
                                    {
                                        $new_training_date = $training_date;
                                    }

                                    // Если новая дата тренировки вычислена, обновляем дату в БД
                                    if (!empty($new_training_date))
                                    {
                                        $next_workout = true;
                                        $training_date = $new_training_date;

                                        $up_data = $this->db->query('
                                            UPDATE `users_training_weeks` SET `utw_date`=?, `utw_date_update`=?
                                            WHERE `utw_id`=? LIMIT 1', array($new_training_date, $date, $row->utw_id));
                                        if ($up_data === false)
                                        {
                                            parent::logDbMessages(__METHOD__);
                                        }

                                    }
                                }
                                // Изменение дат остальных тренировок
                                elseif ($next_workout === true)
                                {
                                    $new_training_date = self::setNewDateOfPrev($training_date, $array_training_days, $date, $row->utw_id);

                                    if (!empty($new_training_date))
                                    {
                                        $training_date = $new_training_date;
                                    }
                                }
                            }
                            // Изменение дат остальных тренировок
                            elseif ($next_workout === true)
                            {
                                $new_training_date = self::setNewDateOfPrev($training_date, $array_training_days, $date, $row->utw_id);

                                if (!empty($new_training_date))
                                {
                                    $training_date = $new_training_date;
                                }
                            }

                            $i++;
                        }
                        unset($row);
                        unset($i);
                    }
                    elseif ($sel_workouts === false)
                    {
                        parent::logDbMessages(__METHOD__);
                    }
                    $sel_workouts->free_result();

                    // Изменение окончания даты тренировок курса
                    // Дата последней тренировки курса
                    $sel_last_w_date = $this->db->query('
                        SELECT `utw_uc_id`, `utw_date` 
                        FROM `users_training_weeks`
                        WHERE `utw_duplicate`=0
                        ORDER BY `utw_date` DESC LIMIT 1');
                    if ($sel_last_w_date !== false and 1 == $sel_last_w_date->num_rows())
                    {
                        $row = $sel_last_w_date->row();
                        $last_w_date = $row->utw_date;

                        $up_data = $this->db->query('
                            UPDATE `users_courses` SET `uc_date_end`=? 
                            WHERE `uc_id`=? and `uc_date_end`<? LIMIT 1', array($last_w_date, $course['id'], $last_w_date));
                        if ($up_data === false)
                        {
                            parent::logDbMessages(__METHOD__);
                        }

                        unset($row);
                    }
                    elseif ($sel_last_w_date === false)
                    {
                        parent::logDbMessages(__METHOD__);
                    }

                    // Выборка расписания тренировок
                    $sel_workouts = $this->db->query('
                        SELECT `utw_id`, `utw_uc_id`, `utw_workout`, `utw_done`, `utw_duplicate`, `utw_date`
                        FROM `users_training_weeks`
                        WHERE `utw_uc_id`=?
                        ORDER BY `utw_date` ASC', $course['id']);
                    if ($sel_workouts !== false and 0 < $sel_workouts->num_rows())
                    {
                        $i = 0;
                        foreach ($sel_workouts->result() as $row)
                        {
                            $workouts[$i]['id']        = $row->utw_id;
                            $workouts[$i]['workout']   = $row->utw_workout;
                            $workouts[$i]['done']      = $row->utw_done;
                            $workouts[$i]['duplicate'] = $row->utw_duplicate;
                            $workouts[$i]['date']      = $row->utw_date;

                            $i++;
                        }
                        unset($row);
                        unset($i);
                    }
                    elseif ($sel_workouts === false)
                    {
                        parent::logDbMessages(__METHOD__);
                    }
                }

                // СОБЫТИЯ КАЛЕНДАРЯ
                $course_data  = self::getCourse($course['course_id']);
                // Флаг доступного тренировочного дня
                $available_training = false;

                // Паузы в курсе
                if (!empty($pauses) and !empty($course['days'])) {
                    foreach ($pauses as $pause) {
                        // Начало заморозки
                        $temp_date = DateTime::createFromFormat('Y-m-d H:i:s', $pause['start']);
                        $pause_start = $temp_date->format('Y-m-d');
                        // Окончание заморозки
                        $temp_date = DateTime::createFromFormat('Y-m-d H:i:s', $pause['end']);
                        $pause_end = $temp_date->format('Y-m-d');

                        if (empty($events) or $pause_start != $events[$ei - 1]['start']) {
                            $events[$ei]['start'] = $pause_start;
                            $events[$ei]['end']   = $pause_end;
                            $events[$ei]['pause'] = true;
                            $events[$ei]['done']  = null;

                            $ei++;
                        }
                    }
                    unset($pause);
                }
                if (!empty($workouts) and !empty($course['days']))
                {
                    $type_shade = $course['id'] % 2 == 0 ? 'lighter' : '';
                    $rgb = self::different_shade($color, $type_shade);
                    $color = $rgb;

                    foreach ($workouts as $workout)
                    {
                        // Выполнено ли занятие
                        $w_done      = $workout['done'];
                        $w_date      = $workout['date'];
                        $w_duplicate = $workout['duplicate'];
                        $w_num       = $workout['workout'];

                        $events[$ei]['workout_id'] = $workout['id'];
                        $events[$ei]['color']      = 'rgba(' . $rgb[0] . ', ' . $rgb[1] . ', ' . $rgb[2] . ', 1)';
                        $events[$ei]['done']       = 'not_done';
                        $events[$ei]['missed']     = 'not_missed';

                        // Только одно видео доступно
                        if ($w_date < $today or $available_training === true)
                        {
                            $events[$ei]['id'] = '';
                        }
                        elseif ($w_date == $today and $available_training === false)
                        {
                            $events[$ei]['id'] = $course_data['course']['workouts'][$w_num]['video_id'];
                            $available_training = true;
                        }

                        $events[$ei]['title'] = ($w_duplicate == 1)
                            ? 'Пропущенное занятие'
                            : $course_data['course']['workouts'][$w_num]['video_name'];
                        $events[$ei]['start'] = !empty($user_training_time)
                            ? $w_date . 'T' . $user_training_time['from']
                            : $w_date;
                        $events[$ei]['end']   = !empty($user_training_time)
                            ? $w_date . 'T' . $user_training_time['to']
                            : $w_date;

                        if ($w_done == 1)
                        {
                            $events[$ei]['done']  = 'done';
                            $events[$ei]['color'] = 'rgba(147, 147, 147, 0.5)';
                        }

                        if ($w_duplicate == 1)
                        {
                            $events[$ei]['missed'] = 'missed';
                            $events[$ei]['color'] = 'rgba(255, 159, 137, 0.5)';
                        }


                        $ei++;
                    }
                    unset($workout);
                }

                $result['courses'][$key]['pauses']   = !empty($pauses) ? $pauses : array();
                $result['courses'][$key]['workouts'] = !empty($workouts) ? $workouts : array();

                $result['events'] = !empty($events) ? array_merge($result['events'], $events) : $result['events'];
            }
            unset($ei);
            unset($course);
        }
        elseif ($sel_courses === false)
        {
            parent::logDbMessages(__METHOD__);
        }

        return $result;
    }

    /**
     * Вычисление новой даты тренировки на основе предыдущей даты тренировки
     *
     * @param $training_date
     * @param $array_training_days
     * @return string|bool
     */
    protected function setNewDateOfPrev($training_date, $array_training_days, $date, $utw_id)
    {
        $new_training_date = null;

        // Номер дня недели предыдущей тренировки
        $prev_num_day = date('N', strtotime($training_date));
        $key_num_day  = array_search($prev_num_day, $array_training_days);

        // Последний выбранный день недели тренировки пользователем
        $a_t_d = $array_training_days;
        end($a_t_d);
        $last_t_day = key($a_t_d);

        if ($key_num_day !== false) {
            // Вычисление разницы между номерами дней недели
            // Если предыдущий день недели тренировки последний день недели, то
            if ($key_num_day == $last_t_day) {
                // От 7 дней недели отнимаем день недели предыдущей тренировки и прибавляем день недели первой тренировки на неделе
                $diff_days = 7 - $array_training_days[$key_num_day] + $array_training_days[0];
            }
            else {
                // Разница между текущим номером недели тренировки и предыдущем.
                $diff_days = $array_training_days[$key_num_day+1] - $array_training_days[$key_num_day];
            }

            // Временная дата предыдущей тренивроки
            $tem_date = new DateTime($training_date);
            // Дата текущей тренировки, с учетом разницы между тренировками ( + $diff_days дней )
            $tem_date->add(new DateInterval('P' . $diff_days . 'D'));
            $new_training_date = ($tem_date !== false) ? $tem_date->format('Y-m-d') : null;

            unset($tem_date);
        }

        if (!empty($new_training_date))
        {
            $up_data = $this->db->query('
                UPDATE `users_training_weeks` SET `utw_date`=?, `utw_date_update`=?
                WHERE `utw_id`=? LIMIT 1', array($new_training_date, $date, $utw_id));
            if ($up_data === false)
            {
                parent::logDbMessages(__METHOD__);
            }

        }

        return $new_training_date;
    }

    /**
     * Новый оттенок цвета
     *
     * @param $rgb
     * @param $type
     * @return array
     */
    protected function different_shade($rgb, $type = '')
    {
        $newShade = array();
        $percentageChange  = 15;
        $percentageChange2 = 30;

        if($type == 'lighter')
        {
            $newShade = array(
                (255-(255-$rgb[0]) + $percentageChange2),
                (255-(255-$rgb[1]) + $percentageChange2),
                (255-(255-$rgb[2]) + $percentageChange2)
            );
        } else {
            $newShade = array(
                ($rgb[0] - $percentageChange),
                ($rgb[1] - $percentageChange),
                ($rgb[2] - $percentageChange)
            );
        }

        return $newShade;
    }

    /**
     * Выборка данных курса пользователя
     *
     * @param $course_id
     * @param $user_id
     * @return array
     */
    public function getUserCourseSettings($course_id, $user_id)
    {
        //self::deleteUsersCoursesInfo();
        $result = array();

        $sel_course = $this->db->query('
            SELECT `uc_id`, `uc_course_id`, `uc_couch_id`, `uc_date_start`, `uc_date_end`, `uc_days`, `uc_blocked`, 
              `uc_paused`, `uc_pause_days`, `crs_name`, `crs_description`, `crs_count_weeks`, 
              `crs_count_days`, `crs_price`, `crs_fitcoin_price`, `crs_count_rest` 
            FROM `users_courses`
            LEFT JOIN `courses` ON `uc_course_id`=`crs_id`
            WHERE `uc_course_id`=? and `uc_user_id`=? LIMIT 1', array($course_id, $user_id));

        if ($sel_course !== false and 1 == $sel_course->num_rows())
        {
            $row = $sel_course->row();

            // Даты начала и окончания курса
            $date       = DateTime::createFromFormat('Y-m-d', $row->uc_date_start);
            $date_start = ($row->uc_date_start != '0000-00-00' and $date !== false) ? $date->format('d.m.Y') : '';
            $date       = DateTime::createFromFormat('Y-m-d', $row->uc_date_end);
            $date_end   = ($row->uc_date_end != '0000-00-00' and $date !== false) ? $date->format('d.m.Y') : '';

            $result['course']['id']               = $row->uc_id;
            $result['course']['course_id']        = $row->uc_course_id;
            $result['course']['couch_id']         = $row->uc_couch_id;
            $result['course']['training_days']    = $row->uc_days;
            $result['course']['days']             = !empty($row->uc_days) ? str_split($row->uc_days) : array();
            $result['course']['db_date_start']    = $row->uc_date_start;
            $result['course']['db_date_end']      = $row->uc_date_end;
            $result['course']['date_start']       = $date_start;
            $result['course']['date_end']         = $date_end;
            $result['course']['blocked']          = $row->uc_blocked;
            $result['course']['paused']           = $row->uc_paused;
            $result['course']['pause_days']       = $row->uc_pause_days;
            $result['course']['pause_start']      = '';
            $result['course']['pause_end']        = '';
            $result['course']['name']             = $row->crs_name;
            $result['course']['description']      = $row->crs_description;
            $result['course']['count_weeks']      = $row->crs_count_weeks;
            $result['course']['count_days']       = $row->crs_count_days;
            $result['course']['count_rest']       = $row->crs_count_rest;
            $result['course']['price']            = ($row->crs_price != '0.00') ? $row->crs_price : '';
            $result['course']['fc_price']         = ($row->crs_fitcoin_price != '0.00') ? $row->crs_fitcoin_price : '';
            $result['course']['workouts']         = array();
            $result['course']['date_last_missed'] = '';
            $result['course']['workouts_missed']  = 0;
            $result['course']['workouts_passed']  = 0;
            $result['course']['pauses']           = array();

            $sel_course->free_result();
            unset($row);

            // Тренеры курса
            $sel_couches = $this->db->query('
                SELECT `cc_couch_id`, `user_name`, `user_email` 
                FROM `courses_couches`
                LEFT JOIN `users` ON `cc_couch_id`=`user_id`
                WHERE `cc_course_id`=?', $course_id);
            if ($sel_couches !== false and 0 < $sel_couches->num_rows()) {
                $i = 0;
                foreach ($sel_couches->result() as $row) {
                    $result['course']['couches'][$i]['id']   = $row->cc_couch_id;
                    $result['course']['couches'][$i]['name'] = !empty($row->user_name) ? $row->user_name : $row->user_email;
                    
                    $i++;
                }
                unset($row);
            }
            elseif ($sel_couches === false)
            {
                parent::logDbMessages(__METHOD__);
            }

            // Текущие тренировочные дни
            $sel_training_days = $this->db->query('
                SELECT `utw_uc_id`, `utw_workout`, `utw_done`, `utw_date`
                FROM `users_training_weeks`
                WHERE `utw_uc_id`=?
                ORDER BY `utw_date`', $result['course']['id']);

            if ($sel_training_days !== false and 0 < $sel_training_days->num_rows())
            {
                $today           = date('Y-m-d');
                $d_o_l_m_w       = ''; // Дата последней пропущенной тренировки (date_of_last_missed_workout)
                $workouts_missed = 0; // Общее кол-во пропущенных тренировок
                $workouts_passed = 0; // Общее кол-во выполненных тренировок

                $i = 0;
                foreach ($sel_training_days->result() as $row) {
                    $result['course']['workouts'][$row->utw_workout]['date'] = $row->utw_date;
                    $result['course']['workouts'][$row->utw_workout]['done'] = $row->utw_done;

                    setlocale(LC_ALL, 'ru_RU.UTF-8');
                    $date = DateTime::createFromFormat('Y-m-d', $row->utw_date);
                    $date = ($row->utw_date != '0000-00-00' and $date !== false)
                        ? strftime('%d %b %Gг.', strtotime($row->utw_date))
                        : '';

                    if ($row->utw_date < $today and $row->utw_done == 0) {
                        $d_o_l_m_w = $date;
                        $workouts_missed++;
                    }
                    elseif ($row->utw_date <= $today and $row->utw_done == 1) {
                        $workouts_passed++;
                    }

                    $i++;
                }
                unset($row);

                $result['course']['date_last_missed'] = $d_o_l_m_w;
                $result['course']['workouts_missed']  = $workouts_missed;
                $result['course']['workouts_passed']  = $workouts_passed;
            }
            elseif ($sel_training_days === false)
            {
                parent::logDbMessages(__METHOD__);
            }
            $sel_training_days->free_result();

            // Паузы курса
            $sel_pauses = $this->db->query('
              SELECT `ucp_pause_start`, `ucp_pause_end` FROM `users_courses_pauses`
              WHERE `ucp_uc_id`=?
               ORDER BY `ucp_id` DESC', $course_id);
            if ($sel_pauses !== false and 0 < $sel_pauses->num_rows()) {
                $i = 0;
                foreach ($sel_pauses->result() as $row)
                {
                    if ($i == 0) {
                        $result['course']['pause_start'] = $row->ucp_pause_start;
                        $result['course']['pause_end']   = $row->ucp_pause_end;
                    }

                    $result['course']['pauses'][$i]['start'] = $row->ucp_pause_start;
                    $result['course']['pauses'][$i]['end']   = $row->ucp_pause_end;

                    $i++;
                }
                unset($row);
            }
            elseif ($sel_pauses === false)
            {
                parent::logDbMessages(__METHOD__);
            }
            $sel_pauses->free_result();
        }
        elseif ($sel_course === false)
        {
            parent::logDbMessages(__METHOD__);
        }
        
        return $result;
    }

    /**
     * Количество пройденных пользователем тренировок курса
     *
     * @param $user_id
     * @param $courses
     * @return mixed
     */
    public function getUserPassedWorkouts($user_id, $courses)
    {
        $result['courses'] = array();

        if (!empty($user_id) and !empty($courses))
        {
            $i = 0;
            foreach ($courses as $course)
            {
                $data = self::getUserCourseSettings($course['id'], $user_id);

                $result['courses'][$i]['id'] = $course['id'];
                $result['courses'][$i]['name'] = $data['course']['name'];
                $result['courses'][$i]['workouts_passed'] = $data['course']['workouts_passed'];

                // Стоимость выполненных тренировок
                $workout_price = $data['course']['price'] / ($data['course']['count_weeks'] * $data['course']['count_days']);
                $passed_price  = $workout_price * $data['course']['workouts_passed'];

                $result['courses'][$i]['passed_price'] = $passed_price;

                $i++;
            }
            unset($course);
        }

        return $result;
    }

    /**
     * Сохранение выбранного тренера курса пользователя
     *
     * @param int $course_id ID курса
     * @param int $user_id ID пользователя
     * @param int $couch_id ID выбранного тренера
     * @param $date
     * @return bool
     */
    public function setUserCourseCouch($course_id, $user_id, $couch_id, $date)
    {
        $up_data = $this->db->query('
            UPDATE `users_courses` SET `uc_couch_id`=?, `uc_date_update`=? 
            WHERE `uc_course_id`=? and `uc_user_id`=? LIMIT 1',
                array($couch_id, $date, $course_id, $user_id));

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
     * Сохранение купленного пользователем курса в БД
     *
     * @param int $course_id
     * @param int $user_id
     * @param string $start_date Начало курса
     * @param string $end_date Окончание курса
     * @param int $training_days Дни недели тренировок
     * @param int $user_couch ID тренера
     * @param $date
     * @return bool
     */
    public function setNewUserCourse($course_id, $user_id, $start_date, $end_date, $training_days, $user_couch, $date)
    {
        $up_data = $this->db->query('
            INSERT INTO `users_courses` 
              (`uc_user_id`, `uc_course_id`, `uc_couch_id`, `uc_days`, `uc_date_start`, `uc_date_end`, `uc_date_update`) 
            VALUES (?, ?, ?, ?, ?, ?, ?)',
                array($user_id, $course_id, $user_couch, $training_days, $start_date, $end_date, $date));

        /* Если курс успешно добавлен, то:
         * - добавляем дни недели тренировок в другую таблицу (для вывода реальных дат тренировок при изменении дней недели тренировок пользователем)
         * - добавляем каждую тренировку по отдельности в другую таблицу (для статистики выполненных тренировок)
        */
        if ($up_data !== false and 1 == $this->db->affected_rows())
        {
            // ID курса в таблице курсов пользователей
            $uc_id = $this->db->insert_id();

            // Добавляем дни недели тренировок
            if (!empty($training_days))
            {
                $up_data = $this->db->query('
                    INSERT INTO `users_training_days` (`utd_uc_id`, `utd_days`, `utd_date_update`) 
                    VALUES (?, ?, ?)', array($uc_id, $training_days, $date));
                if ($up_data === false)
                {
                    parent::logDbMessages(__METHOD__);
                }
            }

            return $uc_id;
        }
        else
        {
            return false;
        }
    }

    /**
     * Сохранение дней тренировок пользователя
     *
     * @param int $course_id ID курса и пользователя (Уникальное ID купленного курса в таблице users_courses)
     * @param int $training_days Дни тренировок (объединены в одну строку 147 (1 - Пн., 4 - Чт., 7 - Вс.))
     * @param string $course_start Дата начала курса
     * @param string $course_end Дата окончания курса
     * @param $date
     * @return bool
     */
    public function setUserTrainingDays($course_id, $training_days, $course_start, $course_end, $date)
    {
        $up_data = $this->db->query('
            INSERT INTO `users_training_days` (`utd_uc_id`, `utd_days`, `utd_date_update`) 
            VALUES (?, ?, ?)', array($course_id, $training_days, $date));

        if ($up_data !== false and 1 == $this->db->affected_rows())
        {
            $up_data = $this->db->query('
                UPDATE `users_courses` SET `uc_date_start`=?, `uc_date_end`=?, `uc_days`=?, `uc_date_update`=?
                WHERE `uc_id`=? LIMIT 1',
                    array($course_start, $course_end, $training_days, $date, $course_id));
            if ($up_data === false)
            {
                parent::logDbMessages(__METHOD__);
            }

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
     * Сохранение изменения дат тренировок
     *
     * @param int $course_id ID курса и пользователя (Уникальное ID купленного курса в таблице users_courses)
     * @param array $update_workouts Массив тренировок, которые необходимо обновить
     * @param string $date Текущая дата
     * @return bool
     */
    public function updateDatesUserWorkouts($course_id, $update_workouts, $date)
    {
        $result = true;
        foreach ($update_workouts as $num_workout => $workout) {
            $up_data = $this->db->query('
              UPDATE `users_training_weeks` SET `utw_date`=?, `utw_date_update`=?
              WHERE `utw_uc_id`=? and `utw_workout`=? LIMIT 1',
                array($workout['date'], $date, $course_id, $num_workout));

            if ($up_data !== false and 1 != $this->db->affected_rows())
            {
                $result = false;
            }
            elseif ($up_data === false)
            {
                parent::logDbMessages(__METHOD__);
                $result = false;
            }
        }
        unset($workout);

        return $result;
    }

    /**
     * Заморозка курса пользователя
     *
     * @param int $course_id ID курса и пользователя (Уникальное ID купленного курса в таблице users_courses)
     * @param $date_pause_to
     * @param string $course_end Дата окончания курса
     * @param $date
     * @return bool
     */
    public function setUserCoursePause($course_id, $date_pause_to, $course_end, $date)
    {
        $up_data = $this->db->query('
            INSERT INTO `users_courses_pauses` (`ucp_pause_start`, `ucp_pause_end`, `ucp_uc_id`)
            VALUES (?, ?, ?)',
                array($date, $date_pause_to, $course_id));

        if ($up_data !== false and 1 == $this->db->affected_rows())
        {
            $this->db->query('
                UPDATE `users_courses` 
                SET `uc_paused`=1, `uc_date_update`=?, `uc_date_end`=?
                WHERE `uc_id`=?  LIMIT 1',
                    array($date, $course_end, $course_id));

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
     * Разморозка курса пользователя
     *
     * @param int $course_id ID курса и пользователя (Уникальное ID купленного курса в таблице users_courses)
     * @param int $pause_days Общее количество дней заморозки
     * @param string $course_end Дата окончания курса
     * @param $date
     * @return bool
     */
    public function unsetUserCoursePause($course_id, $pause_days, $course_end,  $date)
    {
        $up_data = $this->db->query('
            UPDATE `users_courses_pauses`
            SET `ucp_pause_end`=?
            WHERE `ucp_uc_id`=?
            LIMIT 1', array($date, $course_id));

        if ($up_data !== false and 1 == $this->db->affected_rows())
        {
            $up_data = $this->db->query('
                UPDATE `users_courses` 
                SET `uc_paused`=0, `uc_pause_days`=?, `uc_date_update`=?, `uc_date_end`=?
                WHERE `uc_id`=?  LIMIT 1',
                array($pause_days, $date, $course_end, $course_id));
            if ($up_data === false)
            {
                parent::logDbMessages(__METHOD__);
            }

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
     * Добавление тренировок пользователя в БД
     *
     * @param int $uc_id ID курса пользователя (`uc_id` - `users_courses`)
     * @param string $start_date Дата начала тренировок
     * @param int $training_days Тренировочные дни пользователя
     * @param int $count_workouts Общее кол-во тренировок курса
     * @param int $count_days Кол-во тренировок курса в неделю
     * @param string $date Текущая дата
     * @return bool
     */
    public function setUserTrainingWeeks($uc_id, $start_date, $training_days, $count_workouts, $count_days, $date)
    {
        // Определяем дату каждой тренировки
        $values        = '';
        $training_date = $start_date;
        $training_days = str_split($training_days); // Дни недели тренировок в массив
        $count_days    = count($training_days);

        for ($workout = 1; $workout <= $count_workouts; $workout++) {
            if ($workout == 1)
            {
                $values = '(' . $uc_id . ', ' . $workout . ', "' . $training_date . '", "' . $date . '")';
            }
            else
            {
                // Номер дня недели предыдущей тренировки
                $prev_num_week = date('N', strtotime($training_date));
                $key_num_week  = array_search($prev_num_week, $training_days);
                if ($key_num_week !== false)
                {
                    // Вычисление разницы между номерами дней недели
                    // Если предыдущий день недели тренировки последний день недели, то
                    if ($key_num_week == $count_days-1)
                    {
                        // От 7 дней недели отнимаем день недели предыдущей тренировки и прибавляем день недели первой тренировки на неделе
                        $diff_days = 7-$training_days[$key_num_week]+$training_days[0];
                    }
                    else
                    {
                        // Разница между текущим номером недели тренировки и предыдущем.
                        $diff_days = $training_days[$key_num_week+1]-$training_days[$key_num_week];
                    }

                    // Временная дата предыдущей тренивроки
                    $tem_date = new DateTime($training_date);
                    // Дата текущей тренировки, с учетом разницы между тренировками ( + $diff_days дней )
                    $tem_date->add(new DateInterval('P' . abs($diff_days) . 'D'));
                    $training_date = ($tem_date !== false) ? $tem_date->format('Y-m-d') : '';

                    unset($tem_date);

                    $values .= ', (' . $uc_id . ', ' . $workout . ', "' . $training_date . '", "' . $date . '")';
                }
            }
        }
        unset($workout);

        // Сохраняем каждую тренировку по отдельности
        if (!empty($values)) {
            $up_data = $this->db->query('
                INSERT INTO `users_training_weeks`
                  (`utw_uc_id`, `utw_workout`, `utw_date`, `utw_date_update`)
                VALUES '.$values);
            if ($up_data !== false and 0 < $this->db->affected_rows()) {
                return true;
            }
            elseif ($up_data === false)
            {
                parent::logDbMessages(__METHOD__);
                return false;
            }
            else {
                return false;
            }
        }
        else {
            return false;
        }
    }

    /**
     * ID пользователей курса
     *
     * @param $course_id
     * @return array
     */
    public function getCourseUsersId($course_id)
    {
        $result = array();

        $sel_users = $this->db->query('SELECT `uc_user_id` FROM `users_courses` WHERE `uc_course_id`=? and `uc_blocked`=0', $course_id);

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
        elseif ($sel_users === false)
        {
            parent::logDbMessages(__METHOD__);
        }

        return $result;
    }

    /**
     * Список пользователей курса
     *
     * @param $course_id
     * @return array
     */
    public function getCourseUsers($course_id)
    {
        $result = array();

        $sel_users = $this->db->query('
            SELECT `uc_user_id`, `user_name`, `user_email`, `user_image` 
            FROM `users_courses` 
            LEFT JOIN `users` ON `uc_user_id`=`user_id`
            WHERE `uc_course_id`=? and `uc_blocked`=0', $course_id);

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
        elseif ($sel_users === false)
        {
            parent::logDbMessages(__METHOD__);
        }

        return $result;
    }

    /**
     * Выборка ID курсов пользователя
     *
     * @param $user_id
     * @return array
     */
    public function getUserCoursesId($user_id)
    {
        $result = array();

        $sel_courses = $this->db->query('
            SELECT `uc_id`, `uc_course_id`, `uc_date_end`, `uc_pause_days` 
            FROM `users_courses` 
            WHERE `uc_user_id`=? and `uc_blocked`=0', $user_id);

        if ($sel_courses !== false and 0 < $sel_courses->num_rows())
        {
            $i = 0;
            foreach ($sel_courses->result() as $row)
            {
                $result['courses_id'][$i] = $row->uc_course_id;

                $i++;
            }
            unset($row);
        }
        elseif ($sel_courses === false)
        {
            parent::logDbMessages(__METHOD__);
        }

        return $result;
    }

    /**
     * Блокировка курсов пользователя
     *
     * @param int $user_id
     * @param array $courses
     */
    public function blockUserOrderCourses($user_id, $courses)
    {
        if (!empty($courses))
        {
            foreach ($courses as $course)
            {
                $up_data = $this->db->query('
                    UPDATE `users_courses` SET `uc_blocked`=1 
                    WHERE `uc_user_id`=? and `uc_course_id`=? LIMIT 1', array($user_id, $course['id']));

                if ($up_data === false)
                {
                    parent::logDbMessages(__METHOD__);
                }
            }
            unset($course);
        }
    }

    /* КОНЕЦ БЛОКА ОБРАБОТКИ ДАННЫХ КУРСА ПОЛЬЗОВАТЕЛЕЙ */


    /* НАЧАЛО БЛОКА ОБРАБОТКИ ДАННЫХ ОТЗЫВОВ О КУРСЕ */

    /**
     * Выборка отзывов пользователя о курсе
     *
     * @param $course_id
     * @param $user_id
     * @return array
     */
    public function getUserCourseReviews($course_id, $user_id)
    {
        $result = array();

        $sel_reviews = $this->db->query('
            SELECT `cr_id`, `cr_review`, `cr_approval`, `cr_date_add` 
            FROM `courses_reviews` 
            WHERE `cr_crs_id`=? and `cr_u_id`=?', array($course_id, $user_id));

        if ($sel_reviews !== false and 0 < $sel_reviews->num_rows())
        {
            $i = 0;
            foreach($sel_reviews->result() as $row)
            {
                $result['reviews'][$i] = self::parseCourseReviewData($row);

                $i++;
            }
            unset($row);
        }
        elseif ($sel_reviews === false)
        {
            parent::logDbMessages(__METHOD__);
        }

        return $result;
    }

    /**
     * Выборка данных отзыва курса пользователя
     *
     * @param $review_id
     * @param $course_id
     * @param $user_id
     * @return array
     */
    public function getUserCourseReview($course_id, $user_id, $review_id)
    {
        $result = array();

        $sel_review = $this->db->query('
            SELECT `cr_id`, `cr_review`, `cr_approval`, `cr_date_add` 
            FROM `courses_reviews` 
            WHERE `cr_id`=? and `cr_crs_id`=? and `cr_u_id`=? LIMIT 1', array($review_id, $course_id, $user_id));

        if ($sel_review !== false and 1 == $sel_review->num_rows())
        {
            $row = $sel_review->row();

            $result['review'] = self::parseCourseReviewData($row);
        }
        elseif ($sel_review === false)
        {
            parent::logDbMessages(__METHOD__);
        }

        return $result;
    }

    /**
     * Сохранение отзыва пользователя о курсе
     *
     * @param $course_id
     * @param $user_id
     * @param $review_text
     * @param $date
     * @return bool
     */
    public function setUserCourseReview($course_id, $user_id, $review_text, $date)
    {
        $up_data = $this->db->query('
            INSERT INTO `courses_reviews` (`cr_crs_id`, `cr_u_id`, `cr_review`, `cr_date_add`, `cr_update`) VALUES (?, ?, ?, ?, ?)',
                array($course_id, $user_id, $review_text, $date, $date));
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
     * Сохранение изменений отзыва пользователя о курсе
     *
     * @param $course_id
     * @param $user_id
     * @param $review_id
     * @param $review_text
     * @param $date
     * @return bool
     */
    public function updateUserCourseReview($course_id, $user_id, $review_id, $review_text, $date)
    {
        $up_data = $this->db->query('
            UPDATE `courses_reviews` SET `cr_review`=?, `cr_date_add`=? 
            WHERE `cr_id`=? and `cr_crs_id`=? and `cr_u_id`=? and `cr_approval`=0 LIMIT 1',
                array($review_text, $date, $review_id, $course_id, $user_id));
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
     * Удаление отзыва пользователя о курсе
     *
     * @param $course_id
     * @param $user_id
     * @param $review_id
     * @return bool
     */
    public function deleteUserCourseReview($course_id, $user_id, $review_id)
    {
        $up_data = $this->db->query('
            DELETE FROM `courses_reviews` WHERE `cr_id`=? and `cr_crs_id`=? and `cr_u_id`=? and `cr_approval`=0 LIMIT 1',
                array($review_id, $course_id, $user_id));
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
     * Выборка отзовов курса
     *
     * @param $course_id
     * @return array
     */
    public function getCourseReviews($course_id)
    {
        $result = array();

        $sel_reviews = $this->db->query('
            SELECT `cr_id`, `cr_review`, `cr_approval`, `cr_update`, `cr_u_id`, `user_name`, `user_email` 
            FROM `courses_reviews`
            LEFT JOIN `users` ON `cr_u_id`=`user_id`
            WHERE `cr_crs_id`=?', $course_id);
        if ($sel_reviews !== false and 0 < $sel_reviews->num_rows())
        {
            $i = 0;
            foreach($sel_reviews->result() as $row)
            {
                $result['reviews'][$i] = self::parseCourseReviewData($row);
                $result['reviews'][$i]['user']['id']   = $row->cr_u_id;
                $result['reviews'][$i]['user']['name'] = !empty($row->user_name) ? $row->user_name : $row->user_email;

                $i++;
            }
            unset($row);
        }
        elseif ($sel_reviews === false)
        {
            parent::logDbMessages(__METHOD__);
        }

        return $result;
    }

    /**
     * Выборка отзова о курса
     *
     * @param $course_id
     * @param $review_id
     * @return array
     */
    public function getCourseReview($course_id, $review_id)
    {
        $result = array();

        $sel_review = $this->db->query('
            SELECT `cr_id`, `cr_review`, `cr_approval`, `cr_update`, `cr_u_id`, `user_name`, `user_email` 
            FROM `courses_reviews`
            LEFT JOIN `users` ON `cr_u_id`=`user_id`
            WHERE `cr_id`=? and `cr_crs_id`=? LIMIT 1', array($review_id, $course_id));
        if ($sel_review !== false and 1 == $sel_review->num_rows())
        {
            $row = $sel_review->row();

            $result['review'] = self::parseCourseReviewData($row);
            $result['review']['user']['id']   = $row->cr_u_id;
            $result['review']['user']['name'] = !empty($row->user_name) ? $row->user_name : $row->user_email;

        }
        elseif ($sel_review === false)
        {
            parent::logDbMessages(__METHOD__);
        }

        return $result;
    }

    /**
     * Сохранение изменений отзыва о курсе
     *
     * @param $course_id
     * @param $review_id
     * @param $review_text
     * @param $date
     * @return bool
     */
    public function updateCourseReview($course_id, $review_id, $review_text, $date)
    {
        $up_data = $this->db->query('
            UPDATE `courses_reviews` SET `cr_review`=?, `cr_update`=? 
            WHERE `cr_id`=? and `cr_crs_id`=? LIMIT 1',
            array($review_text, $date, $review_id, $course_id));
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
     * Одобрение отзыва о курсе
     *
     * @param $course_id
     * @param $review_id
     * @param $date
     * @return bool
     */
    public function approvalCourseReview($course_id, $review_id, $date)
    {
        $up_data = $this->db->query('
            UPDATE `courses_reviews` SET `cr_approval`=1, `cr_update`=? 
            WHERE `cr_id`=? and `cr_crs_id`=? LIMIT 1',
            array($date, $review_id, $course_id));
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
     * Отклонение отзыва о курсе
     *
     * @param $course_id
     * @param $review_id
     * @param $date
     * @return bool
     */
    public function rejectCourseReview($course_id, $review_id, $date)
    {
        $up_data = $this->db->query('
            UPDATE `courses_reviews` SET `cr_approval`=0, `cr_update`=? 
            WHERE `cr_id`=? and `cr_crs_id`=? LIMIT 1',
            array($date, $review_id, $course_id));
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
     * Удаление отзыва пользователя о курсе
     *
     * @param $course_id
     * @param $review_id
     * @return bool
     */
    public function deleteCourseReview($course_id, $review_id)
    {
        $up_data = $this->db->query('
            DELETE FROM `courses_reviews` WHERE `cr_id`=? and `cr_crs_id`=? LIMIT 1',
            array($review_id, $course_id));
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
     * Выборка одобренных отзывов о курсе
     *
     * @return array
     */
    public function getAvaliableReviews()
    {
        $result = array();
        $sel_reviews = $this->db->query('
            SELECT `cr_id`, `cr_crs_id`, `cr_u_id`, `cr_review`, `cr_approval`, `cr_date_add`, 
              `user_name`, `user_email`, `user_image` 
            FROM `courses_reviews` 
            LEFT JOIN `users` ON `cr_u_id`=`user_id`
            WHERE `cr_approval`=1
            ORDER BY `cr_update` DESC LIMIT 3');

        if ($sel_reviews !== false and 0 < $sel_reviews->num_rows())
        {
            $i = 0;
            foreach($sel_reviews->result() as $row)
            {
                $result['reviews'][$i] = self::parseCourseReviewData($row);
                $result['reviews'][$i]['user']['id']    = $row->cr_u_id;
                $result['reviews'][$i]['user']['name']  = !empty($row->user_name) ? $row->user_name : 'Пользователь №'.$row->cr_u_id;
                $result['reviews'][$i]['user']['image'] = is_file($row->user_image) ? mb_substr($row->user_image, 1) : '';

                $i++;
            }
            unset($row);
        }
        elseif($sel_reviews === false)
        {
            parent::logDbMessages(__METHOD__);
        }

        return $result;
    }

    /* КОНЕЦ БЛОКА ОБРАБОТКИ ДАННЫХ ОТЗЫВОВ О КУРСЕ */


    /* НАЧАЛО БЛОКА ОБРАБОТКИ ДАННЫХ КУРСА ТРЕНЕРА */

    /**
     * Выборка курсов тренера
     *
     * @param $user_id
     * @return array
     */
    public function getCouchCourses($user_id)
    {
        $result = array('courses' => array());

        $sel_courses = $this->db->query('
            SELECT `cc_id`, `cc_course_id`, `cc_couch_id`, `cc_percent`, `cc_discount`, `cc_date_add`, `cc_date_update`,
              `crs_image`, `crs_name`, `crs_description`
            FROM `courses_couches`
            LEFT JOIN `courses` ON `crs_id`=`cc_course_id`
            WHERE `cc_couch_id`=?', $user_id);

        if ($sel_courses !== false and 0 < $sel_courses->num_rows())
        {
            $i = 0;

            foreach($sel_courses->result() as $row)
            {
                $result['courses'][$i]['course_id'] = $row->cc_course_id;
                $result['courses'][$i]['name']      = $row->crs_name;
                $result['courses'][$i]['image']     = !empty($row->crs_image) ? mb_substr($row->crs_image, 1) : '';
                $result['courses'][$i]['desc']      = $row->crs_description;

                $result['courses'][$i]['couch_percent']  = $row->cc_course_id;
                $result['courses'][$i]['couch_discount'] = $row->cc_course_id;

                $i++;
            }
            unset($row);

            // Тренеры курса
            foreach ($result['courses'] as $key => $course)
            {
                $result['courses'][$key] = array_merge($result['courses'][$key], self::getCourseCouches($course['course_id']));
            }
        }
        elseif ($sel_courses === false)
        {
            parent::logDbMessages(__METHOD__);
        }

        return $result;
    }

    /**
     * Выборка курсов, которые прикреплены к тренеру
     *
     * @param $couch_id
     * @return array
     */
    public function getPartnerCourses($couch_id)
    {
        $result = array();

        $sel_courses = $this->db->query('
            SELECT `cc_course_id`, `crs_name` 
            FROM `courses_couches` 
            LEFT JOIN `courses` ON `cc_course_id`=`crs_id`
            WHERE `cc_couch_id`=?', $couch_id);

        if ($sel_courses !== false and 0 < $sel_courses->num_rows())
        {
            $i = 0;
            foreach ($sel_courses->result() as $row)
            {
                $result['courses'][$i]['id']       = $row->cc_course_id;
                $result['courses'][$i]['name']     = $row->crs_name;

                $i++;
            }
            unset($row);
        }
        elseif ($sel_courses === false)
        {
            parent::logDbMessages(__METHOD__);
        }

        return $result;
    }

    /**
     * Выборка данных курса, прикрепленного к тренеру
     *
     * @param $course_id
     * @param $couch_id
     * @return array
     */
    public function getPartnerCourse($course_id, $couch_id)
    {
        $result = array();

        $sel_course = $this->db->query('
            SELECT `cc_course_id`, `cc_percent`, `cc_discount`, `crs_name`, `crs_description`, `crs_count_weeks`, 
              `crs_count_days`, `crs_price`, `crs_fitcoin_price` 
            FROM `courses_couches`
            LEFT JOIN `courses` ON `cc_course_id`=`crs_id`
            WHERE `cc_course_id`=? and `cc_couch_id`=? LIMIT 1', array($course_id, $couch_id));

        if ($sel_course !== false and 1 == $sel_course->num_rows())
        {
            $row = $sel_course->row();

            $result['course']['id']             = $row->cc_course_id;
            $result['course']['couch_percent']  = $row->cc_percent;
            $result['course']['couch_discount'] = ($row->cc_discount == '0.00') ? 0 : $row->cc_discount;
            $result['course']['name']           = $row->crs_name;
            $result['course']['description']    = $row->crs_description;
            $result['course']['count_weeks']    = $row->crs_count_weeks;
            $result['course']['count_days']     = $row->crs_count_days;
            $result['course']['price']          = ($row->crs_price != '0.00') ? $row->crs_price : '';
            $result['course']['fc_price']       = ($row->crs_fitcoin_price != '0.00') ? $row->crs_fitcoin_price : '';
        }
        elseif ($sel_course === false)
        {
            parent::logDbMessages(__METHOD__);
        }

        return $result;
    }

    /**
     * Сохранение изменений дисконта тренера на курс
     *
     * @param $course_id
     * @param $couch_id
     * @param $couch_discount
     * @param $date
     * @return bool
     */
    public function setPartnerCourseSettings($course_id, $couch_id, $couch_discount, $date)
    {
        $up_data = $this->db->query('
            UPDATE `courses_couches` SET `cc_discount`=?, `cc_date_update`=? 
            WHERE `cc_course_id`=? and `cc_couch_id`=? LIMIT 1',
                array($couch_discount, $date, $course_id, $couch_id));

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

    /* КОНЕЦ БЛОКА ОБРАБОТКИ ДАННЫХ КУРСА ТРЕНЕРА */


    /**
     * AJAX. Поиск видео
     *
     * @param $course_id
     * @param $search_text
     * @return bool|string
     */
    public function searchVideo($course_id, $search_text)
    {
        $result = false;

        if (is_numeric($search_text)) {
            $sel_video = $this->db->query('
                SELECT `video_id`, `video_name`, `video_poster`, `video_path`  
                FROM `video` 
                WHERE `video_id`=? and `video_blocked`=0 and `video_crs_id`=?', array($search_text, $course_id));
        } else {
            $search_text = $search_text.'*';

            $sel_video = $this->db->query('
                SELECT `video_id`, `video_name`, `video_poster`, `video_path` 
                FROM `video` 
                WHERE MATCH (`video_name`) AGAINST (? IN BOOLEAN MODE) and `video_blocked`=0 and `video_crs_id`=?', array($search_text, $course_id));
        }

        if ($sel_video !== false and 0 < $sel_video->num_rows())
        {
            foreach ($sel_video->result() as $row)
            {
                $poster = is_file($row->video_poster) ? mb_substr($row->video_poster, 1) : '';
                $video  = is_file($row->video_path) ? mb_substr($row->video_path, 1) : '';
                $name   = !empty($row->video_name) ? $row->video_name : 'Видео №'.$row->video_id;

                $result .= '                    
                    <div class="add_tren_item video parent" id="' . $row->video_id . '" data-poster-link="' . $poster . '" data-video-link="' . $video . '" data-video-desk="' . $row->video_name . '">
                        <div class="add_tov_img"><img src="' . $poster . '" alt=""></div>
                        <a href="/administration/video/' . $row->video_id . '" class="add_tov_cont add_tren_name">
                            <div class="add_tov_h">' . $name . '</div>
                            <input type="hidden" value="'.$row->video_id.'" name="res-video_id" id="res-video-id"/>
                        </a>
                    </div>';
            }
            unset($row);
        }
        elseif ($sel_video === false)
        {
            parent::logDbMessages(__METHOD__);
        }
        else
        {
            $result = '<div class="not_found">Видео не найдено</div>';
        }

        return $result;
    }

    /**
     * AJAX. Сохранение прогресса тренировки (выполнено)
     *
     * @param int $user_id
     * @param int $workout_id Уникальное ID тренировки в таблице `users_training_weeks`
     * @param string $date Текущая дата
     * @return bool
     */
    public function setWorkoutDone($user_id, $workout_id, $date)
    {
        $sel_workout = $this->db->query('SELECT `utw_uc_id`, `utw_date` FROM `users_training_weeks` WHERE `utw_id`=? LIMIT 1', $workout_id);

        if ($sel_workout !== false and 1 == $sel_workout->num_rows())
        {
            $row = $sel_workout->row();
            
            $uc_id        = $row->utw_uc_id;
            $workout_date = $row->utw_date;
            
            if ($workout_date == $date)
            {
                $sel_course = $this->db->query('
                  SELECT `uc_course_id` FROM `users_courses` WHERE `uc_id`=? and `uc_user_id`=? LIMIT 1', array($uc_id, $user_id));

                if ($sel_course !== false and 1 == $sel_course->num_rows())
                {
                    $up_data = $this->db->query('
                      UPDATE `users_training_weeks` SET `utw_done`=1, `utw_date_update`=? 
                      WHERE `utw_id`=? LIMIT 1', array($date, $workout_id));

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
                elseif ($sel_course === false)
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
        elseif ($sel_workout === false)
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
     * Изменение данных о тренировках курса.
     * Если тренировка была пропущена, то создается её дубликат, а курс смещается (изменяются даты будущих тренировок)
     *
     * @param $user_id
     * @param $date
     * @return void
     */
    public function updateUserCourseData($user_id, $date)
    {
        
    }


    /* НАЧАЛО БЛОКА ФУНКЦИЙ ОБРАБОТКИ ДАННЫХ */

    /**
     * Обработка данных курса
     *
     * @param $row
     * @return array
     */
    protected function parseCourseData($row)
    {
        $result = array();

        $result['id']            = $row->crs_id;
        $result['image']         = !empty($row->crs_image) ? mb_substr($row->crs_image, 1) : null;
        $result['name']          = !empty($row->crs_name) ? $row->crs_name : null;
        $result['description']   = !empty($row->crs_description) ? $row->crs_description : null;
        $result['type']          = !empty($row->crs_type_id) ? $row->crs_type_id : null;
        $result['count_weeks']   = !empty($row->crs_count_weeks) ? $row->crs_count_weeks : null;
        $result['count_days']    = !empty($row->crs_count_days) ? $row->crs_count_days : null;
        $result['count_rest']    = !empty($row->crs_count_rest) ? $row->crs_count_rest : null;
        $result['blocked']       = !empty($row->crs_blocked) ? $row->crs_blocked : null;
        $result['price']         = (!empty($row->crs_price) and $row->crs_price != '0.00') ? $row->crs_price : null;
        $result['fc_price']      = (!empty($row->crs_fitcoin_price) and $row->crs_fitcoin_price != '0.00') ? $row->crs_fitcoin_price : null;
        $result['recur_price']   = (!empty($row->crs_recurrent_price) and $row->crs_recurrent_price != '0.00') ? $row->crs_recurrent_price : null;
        $result['recur_months']  = (!empty($row->crs_recurrent_months) and $row->crs_recurrent_months != 0) ? $row->crs_recurrent_months : null;
        $result['recur_first']   = (!empty($row->crs_recurrent_first) and $row->crs_recurrent_first != '0.00') ? $row->crs_recurrent_first : null;
        $result['recur_subsequent'] = (!empty($row->crs_recurrent_subsequent) and $row->crs_recurrent_subsequent != '0.00') ? $row->crs_recurrent_subsequent : null;
        $result['new_price']     = null;
        $result['new_fc_price']  = null;
        $result['bought']        = false;
        $result['p_id']          = !empty($row->p_id) ? $row->p_id : null;
        $result['recurrent']     = false;

        if (!empty($result['recur_price']) and !empty($result['recur_months']) and !empty($result['recur_first'])
            and !empty($result['recur_subsequent']))
        {
            $result['recurrent'] = true;
        }

        $result['landing']['id']        = (!empty($row->clp_id) and $row->clp_activated == 'activate') ? $row->clp_id : null;
        $result['landing']['activated'] = !empty($row->clp_activated) ? $row->clp_activated : false;

        return $result;
    }

    /**
     * Обработка данных Landing page
     *
     * @param $row
     * @return array
     */
    protected function parseLandingData($row)
    {
        $result = array(
            'html_page' => '', 'lp_id' => '', 'bg' => '', 'slider_images' => array(), 'main_title' => '', 'slider_images_default' => true,
            'block2' => array('bg' => '', 'image' => '', 'title' => '', 'subtitle' => '', 'text' => '', 'bg_default' => true, 'image_default' => true, 'button' => ''),
            'block3' => array('bg' => '', 'title' => '', 'subtitle' => '', 'images' => array(), 'r_title' => '', 'r_subtitle' => '', 'r_reviews' => '', 'bg_default' => true, 'image1_default' => true, 'image2_default' => true),
            'block4' => array('bg' => '', 'title' => '', 'subtitle' => '', 'image' => '', 'r_title' => '', 'r_subtitle' => '', 'bg_default' => true, 'image_default' => true, 'button' => ''),
            'block5' => array('bg' => '', 'title' => '', 'subtitle' => '', 'text' => '', 'images' => array(), 'r_title' => '', 'r_subtitle' => '', 'r_text' => '', 'bg_default' => true, 'image1_default' => true, 'image2_default' => true, 'image3_default' => true, 'button' => ''),
            'block6' => array('bg' => '', 'title' => '', 'desc' => '', 'subtitle' => '', 'advantages' => array(), 'image' => '', 'bg_default' => true, 'image_default' => true, 'button' => ''),
            'block7' => array('bg' => '', 'images' => array(), 'texts' => array(), 'bg_default' => true, 'images_default' => true, 'button' => ''),
            'block8' => array('bg' => '', 'title' => '', 'desc1' => '', 'subtitle' => '', 'desc2' => '', 'old_price' => '', 'new_price' => '', 'bg_default' => true, 'button' => '')
        );

        // Путь к HTML странице landing page
        $result['html_page'] = $row->lp_html_page;
        $result['lp_id']     = !empty($row->clp_lp_id) ? $row->clp_lp_id : '';

        // Фон страницы
        $clp_background = '';
        if (!empty($row->lp_background)) {
            if (is_file($row->lp_background)) {
                $clp_background = 'background: url(' . mb_substr($row->lp_background, 1) . ') top center repeat;';
            }
            elseif (mb_substr($row->lp_background, 0, 1) == '#') {
                $clp_background = 'background: ' . $row->lp_background . ';';
            }
        }
        $result['bg'] = $clp_background;

        // Изображения для слайдера страницы
        $result['slider_images'] = '';
        if (!empty($row->clp_slider_images) and $row->clp_slider_images != 'default')
        {
            $s_images = explode(';', $row->clp_slider_images);
        }
        elseif ($row->clp_slider_images == 'default')
        {
            $s_images = explode(';', $row->lp_slider_images);
        }
        else {$s_images = '';}

        if (!empty($s_images))
        {
            $i = 0;
            foreach ($s_images as $s_image)
            {
                $result['slider_images'][$i] = is_file($s_image) ? mb_substr($s_image, 1) : '';

                if (empty($result['slider_images'][$i]))
                {
                    unset($result['slider_images'][$i]);
                }

                $i++;
            }
            unset($s_image);
        }

        $result['main_title']     = parent::showBBcodes($row->clp_main_title);
        $result['bbc_main_title'] = $row->clp_main_title;

        // БЛОК 2
        // Фон блока
        if (!empty($row->clp_block2_background) and $row->clp_block2_background != 'default')
        {
            $result['block2']['bg_default'] = false;
            $block2_background = $row->clp_block2_background;
        }
        elseif ($row->clp_block2_background == 'default')
        {
            $block2_background = $row->lp_block2_background;
        }
        else {$block2_background = '';}

        if (!empty($block2_background)) {
            if (is_file($block2_background)) {
                $block2_background = 'background: url(' . mb_substr($block2_background, 1) . ') top center repeat;';
            }
            elseif (mb_substr($block2_background, 0, 1) == '#') {
                $block2_background = 'background: ' . $block2_background . ';';
            }
        }
        $result['block2']['bg']      = $block2_background;
        $result['block2']['bg_orig'] = $row->clp_block2_background;

        // Изображение блока
        if (!empty($row->clp_block2_image) and $row->clp_block2_image != 'default')
        {
            $result['block2']['image_default'] = false;
            $block2_image = $row->clp_block2_image;
        }
        elseif ($row->clp_block2_image == 'default')
        {
            $block2_image = $row->lp_block2_image;
        }
        else {$block2_image = '';}

        $block2_image = (!empty($block2_image) and is_file($block2_image)) ? mb_substr($block2_image, 1) : '';
        $result['block2']['image']      = $block2_image;
        $result['block2']['image_orig'] = $row->clp_block2_image;

        $result['block2']['title']    = $row->clp_block2_title;
        $result['block2']['subtitle'] = $row->clp_block2_subtitle;
        $result['block2']['text']     = $row->clp_block2_text;
        $result['block2']['button']   = strip_tags($row->clp_block2_button);

        // БЛОК 3
        // Фон блока
        if (!empty($row->clp_block3_background) and $row->clp_block3_background != 'default')
        {
            $result['block3']['bg_default'] = false;
            $block3_background = $row->clp_block3_background;
        }
        elseif ($row->clp_block3_background == 'default')
        {
            $block3_background = $row->lp_block3_background;
        }
        else {$block3_background = '';}

        if (!empty($block3_background))
        {
            if (is_file($block3_background))
            {
                $block3_background = 'background-image: url(' . mb_substr($block3_background, 1) . ');';
            }
            elseif (mb_substr($block3_background, 0, 1) == '#')
            {
                $block3_background = 'background: ' . $block3_background . ';';
            }
        }
        $result['block3']['bg']      = $block3_background;
        $result['block3']['bg_orig'] = $row->clp_block3_background;

        $result['block3']['title']      = $row->clp_block3_title;
        $result['block3']['subtitle']   = $row->clp_block3_subtitle;
        $result['block3']['r_title']    = $row->clp_block3_r_title;
        $result['block3']['r_subtitle'] = $row->clp_block3_r_subtitle;
        $result['block3']['r_reviews']  = $row->clp_block3_r_reviews;

        // Изображения блока
        $result['block3']['images'] = '';
        if (!empty($row->clp_block3_images))
        {
            $clp_images = explode(';', $row->clp_block3_images);
            $lp_images = explode(';', $row->lp_block3_images);

            $i = 0;
            foreach ($clp_images as $key => $s_image)
            {
                if (!empty($s_image) and $s_image != 'default')
                {
                    $result['block3']['images'][$i]         = is_file($s_image) ? mb_substr($s_image, 1) : '';
                    $result['block3']['images_default'][$i] = false;
                    $result['block3']['images_orig'][$i]    = $s_image;

                    if (empty($result['block3']['images'][$i]))
                    {
                        unset($result['block3']['images'][$i]);
                        $result['block3']['images_default'][$i] = true;
                    }

                    $i++;
                }
                elseif($s_image == 'default')
                {
                    $result['block3']['images'][$i]         = is_file($lp_images[$key]) ? mb_substr($lp_images[$key], 1) : '';
                    $result['block3']['images_default'][$i] = true;
                    $result['block3']['images_orig'][$i]    = $s_image;

                    $i++;
                }
            }
            unset($s_images);
        }

        // БЛОК 4
        // Фон блока
        if (!empty($row->clp_block4_background) and $row->clp_block4_background != 'default')
        {
            $result['block4']['bg_default'] = false;
            $block4_background = $row->clp_block4_background;
        }
        elseif ($row->clp_block4_background == 'default') {
            $block4_background = $row->lp_block4_background;
        }
        else {$block4_background = '';}

        if (!empty($block4_background)) {
            if (is_file($block4_background)) {
                $block4_background = 'background-image: url(' . mb_substr($block4_background, 1) . ');';
            }
            elseif (mb_substr($block4_background, 0, 1) == '#') {
                $block4_background = 'background: ' . $block4_background . ';';
            }
        }
        $result['block4']['bg']      = $block4_background;
        $result['block4']['bg_orig'] = $row->clp_block4_background;

        $result['block4']['title']    = $row->clp_block4_title;
        $result['block4']['subtitle'] = $row->clp_block4_subtitle;
        $result['block4']['button']   = strip_tags($row->clp_block4_button);

        // Изображение блока
        $block4_image = '';
        if (!empty($row->clp_block4_image) and $row->clp_block4_image != 'default')
        {
            $result['block4']['image_default'] = false;
            $block4_image = is_file($row->clp_block4_image) ? mb_substr($row->clp_block4_image, 1) : '';
        }
        elseif ($row->clp_block4_image == 'default')
        {
            $block4_image = is_file($row->lp_block4_image) ? mb_substr($row->lp_block4_image, 1) : '';
        }
        $result['block4']['image']      = $block4_image;
        $result['block4']['image_orig'] = $row->clp_block4_image;

        $result['block4']['r_title']    = $row->clp_block4_r_title;
        $result['block4']['r_subtitle'] = $row->clp_block4_r_subtitle;

        // БЛОК 5
        // Фон блока
        if (!empty($row->clp_block5_background) and $row->clp_block5_background != 'default')
        {
            $result['block5']['bg_default'] = false;
            $block5_background = $row->clp_block5_background;
        }
        elseif ($row->clp_block5_background == 'default')
        {
            $block5_background = $row->lp_block5_background;
        }
        else {$block5_background = '';}

        if (!empty($block5_background))
        {
            if (is_file($block5_background))
            {
                $block5_background  = 'background-image: url(' . mb_substr($block5_background, 1) . ')';
            }
            elseif (mb_substr($block5_background, 0, 1) == '#')
            {
                $block5_background  = 'background: ' . $block5_background . ';';
            }
        }
        $result['block5']['bg']      = $block5_background;
        $result['block5']['bg_orig'] = $row->clp_block5_background;

        $result['block5']['title']    = $row->clp_block5_title;
        $result['block5']['subtitle'] = $row->clp_block5_subtitle;
        $result['block5']['text']     = $row->clp_block5_text;

        // Изображения блока
        if (!empty($row->clp_block5_images))
        {
            $clp_images = explode(';', $row->clp_block5_images);
            $lp_images = explode(';', $row->lp_block5_images);

            if (!empty($clp_images))
            {
                $i = 0;
                foreach ($clp_images as $key => $s_image)
                {
                    if (!empty($s_image) and $s_image != 'default')
                    {
                        $result['block5']['images'][$i]         = is_file($s_image) ? mb_substr($s_image, 1) : '';
                        $result['block5']['images_default'][$i] = false;
                        $result['block5']['images_orig'][$i]    = $s_image;

                        if (empty($result['block5']['images'][$i]))
                        {
                            unset($result['block5']['images'][$i]);
                            $result['block5']['images_default'][$i] = true;
                        }

                        $i++;
                    }
                    elseif($s_image == 'default')
                    {
                        $result['block5']['images'][$i]         = is_file($lp_images[$key]) ? mb_substr($lp_images[$key], 1) : '';
                        $result['block5']['images_default'][$i] = true;
                        $result['block5']['images_orig'][$i]    = $s_image;

                        $i++;
                    }
                }
                unset($s_image);
            }
        }

        $result['block5']['r_title']    = $row->clp_block5_r_title;
        $result['block5']['r_subtitle'] = $row->clp_block5_r_subtitle;
        $result['block5']['r_text']     = $row->clp_block5_r_text;
        $result['block5']['button']     = strip_tags($row->clp_block5_button);

        // БЛОК 6
        // Фон блока
        if (!empty($row->clp_block6_background) and $row->clp_block6_background != 'default')
        {
            $result['block6']['bg_default'] = false;
            $block6_background = $row->clp_block6_background;
        }
        elseif ($row->clp_block6_background == 'default')
        {
            $block6_background = $row->lp_block6_background;
        }
        else {$block6_background = '';}

        if (!empty($block6_background))
        {
            if (is_file($block6_background))
            {
                $block6_background = 'background-image: url(' . mb_substr($block6_background, 1) . ')';
            }
            elseif (mb_substr($block6_background, 0, 1) == '#')
            {
                $block6_background = 'background: ' . $block6_background . ';';
            }
        }
        $result['block6']['bg'] = $block6_background;
        $result['block6']['bg_orig'] = $row->clp_block6_background;

        $result['block6']['title']    = $row->clp_block6_title;
        $result['block6']['desc']     = $row->clp_block6_description;
        $result['block6']['subtitle'] = $row->clp_block6_subtitle;
        $result['block6']['button']   = strip_tags($row->clp_block6_button);

        // Преимущества блока
        $result['block6']['advantages'] = '';
        if (!empty($row->clp_block6_advantages))
        {
            $advantages = explode(';', $row->clp_block6_advantages);

            $i = 0;
            foreach ($advantages as $advantage)
            {
                if (!empty($advantage))
                {
                    $result['block6']['advantages'][$i] = $advantage;

                    $i++;
                }
            }
            unset($advantage);
        }

        // Изображение блока
        $block6_image = '';
        if (!empty($row->clp_block6_image) and $row->clp_block6_image != 'default')
        {
            $result['block6']['image_default'] = false;
            $block6_image = is_file($row->clp_block6_image) ? mb_substr($row->clp_block6_image, 1) : '';
        }
        elseif ($row->clp_block6_image == 'default')
        {
            $block6_image = is_file($row->lp_block6_image) ? mb_substr($row->lp_block6_image, 1) : '';
        }
        $result['block6']['image']      = $block6_image;
        $result['block6']['image_orig'] = $row->clp_block6_image;

        // БЛОК 7
        // Фон блока
        if (!empty($row->clp_block7_background) and $row->clp_block7_background != 'default')
        {
            $result['block7']['bg_default'] = false;
            $block7_background = $row->clp_block7_background;
        }
        elseif ($row->clp_block7_background == 'default')
        {
            $block7_background = $row->lp_block7_background;
        }
        else {$block7_background = '';}

        if (!empty($block7_background))
        {
            if (is_file($block7_background))
            {
                $block7_background = 'background-image: url(' . mb_substr($block7_background, 1) . ');';
            }
            elseif (mb_substr($block7_background, 0, 1) == '#')
            {
                $block7_background = 'background: ' . $block7_background . ';';
            }
        }
        $result['block7']['bg']      = $block7_background;
        $result['block7']['bg_orig'] = $row->clp_block7_background;

        $result['block7']['title']  = $row->clp_block7_title;
        $result['block7']['button'] = strip_tags($row->clp_block7_button);

        // Изображения блока
        if (!empty($row->clp_block7_images))
        {
            $clp_images = explode(';', $row->clp_block7_images);
            $lp_images = explode(';', $row->lp_block7_images);
            $b7_images_default = true;

            $i = 0;
            foreach ($clp_images as $key => $s_image)
            {
                if (!empty($s_image))
                {
                    $result['block7']['images_orig'][$i] = $s_image;

                    if ($s_image == 'default' and $i <= 3)
                    {
                        $result['block7']['images'][$i] = is_file($lp_images[$key]) ? mb_substr($lp_images[$key], 1) : '';
                    }
                    else
                    {
                        $result['block7']['images'][$i] = is_file($s_image) ? mb_substr($s_image, 1) : 'default';
                    }

                    if ($b7_images_default === true and $i <= 3 and $s_image != 'default')
                    {
                        $result['block7']['images_default'] = false;
                        $b7_images_default = false;
                    }

                    $i++;
                }
            }
            unset($s_image);
        }

        // Текст блока
        $result['block7']['texts'] = '';
        if (!empty($row->clp_block7_text))
        {
            $texts = explode(';', $row->clp_block7_text);

            $i = 0;
            foreach ($texts as $text)
            {
                if (!empty($text))
                {
                    $result['block7']['texts'][$i] = $text;

                    if (empty($result['block7']['images'][$i]))
                    {
                        unset($result['block7']['texts'][$i]);
                    }

                    $i++;
                }
            }
            unset($text);
        }

        // БЛОК 8
        // Фон блока
        if (!empty($row->clp_block8_background) and $row->clp_block8_background != 'default')
        {
            $result['block8']['bg_default'] = false;
            $block8_background = $row->clp_block8_background;
        }
        elseif ($row->clp_block8_background == 'default')
        {
            $block8_background = $row->lp_block8_background;
        }
        else {$block8_background = '';}

        if (!empty($block8_background))
        {
            if (is_file($block8_background))
            {
                $block8_background = 'background-image: url(' . mb_substr($block8_background, 1) . ')';
            }
            elseif (mb_substr($block8_background, 0, 1) == '#')
            {
                $block8_background = 'background: ' . $block8_background . ';';
            }
        }
        $result['block8']['bg'] = $block8_background;
        $result['block8']['bg_orig'] = $row->clp_block8_background;

        $result['block8']['title']     = $row->clp_block8_title;
        $result['block8']['desc1']     = $row->clp_block8_description1;
        $result['block8']['subtitle']  = $row->clp_block8_subtitle;
        $result['block8']['desc2']     = $row->clp_block8_description2;
        $result['block8']['old_price'] = $row->clp_block8_old_price;
        $result['block8']['new_price'] = $row->clp_block8_new_price;
        $result['block8']['button']    = strip_tags($row->clp_block8_button);

        return $result;
    }

    /**
     * Обработка данных видео
     *
     * @param $row
     * @return array
     */
    protected function parseVideoData($row)
    {
        $result = array();

        $result['id']          = $row->video_id;
        $result['type']        = !empty($row->video_type) ? $row->video_type : null;
        $result['name']        = !empty($row->video_name) ? $row->video_name : null;
        $result['remove_url']  = !empty($row->video_remove_url) ? $row->video_remove_url : null;
        $result['poster']      = (!empty($row->video_poster) and is_file($row->video_poster)) ? mb_substr($row->video_poster, 1) : null;
        $result['video']       = (!empty($row->video_path) and is_file($row->video_path)) ? mb_substr($row->video_path, 1) : null;
        $result['blocked']     = !empty($row->video_blocked) ? $row->video_blocked : null;
        $result['course_id']   = !empty($row->video_crs_id) ? $row->video_crs_id : null;
        $result['course_name'] = !empty($row->crs_name) ? $row->crs_name : null;

        return $result;
    }

    /**
     * Удаление всей информации по курсам пользователей
     */
    protected function deleteUsersCoursesInfo()
    {
        $this->db->query('UPDATE `users_courses` SET `uc_couch_id`=?,`uc_days`=?,`uc_date_start`=?,`uc_date_end`=?,
            `uc_blocked`=?,`uc_pause_days`=?',
            array(0, 0, '0000-00-00', '0000-00-00', 0, 0));
        $this->db->query('DELETE FROM `users_courses_pauses`');
        $this->db->query('DELETE FROM `users_training_days`');
        $this->db->query('DELETE FROM `users_training_weeks`');
    }

    /**
     * Обработка данных отзыва курса
     *
     * @param $row
     * @return mixed
     */
    protected function parseCourseReviewData($row)
    {
        $result['id']        = $row->cr_id;
        $result['course_id'] = !empty($row->cr_crs_id) ? $row->cr_crs_id : null;
        $result['user_id']   = !empty($row->cr_u_id) ? $row->cr_u_id : null;
        $result['text']      = !empty($row->cr_review) ? $row->cr_review : null;
        $result['approval']  = !empty($row->cr_approval) ? $row->cr_approval : null;

        setlocale(LC_ALL, 'ru_RU.UTF-8');
        if (!empty($row->cr_date_add))
        {
            $date = DateTime::createFromFormat('Y-m-d H:i:s', $row->cr_date_add);
            $date_add = ($row->cr_date_add != '0000-00-00 00:00:00' and $date !== false)
                ? strftime('%d %B %G', strtotime($row->cr_date_add))
                : '';

            $message_date = ($row->cr_date_add != '0000-00-00 00:00:00' or $date !== false)
                ? $date->format('d.m.Y')
                : '';
            $message_time = ($row->cr_date_add != '0000-00-00 00:00:00' or $date !== false)
                ? $date->format('H:i')
                : '';

            $result['date_add'] = $date_add;
            $result['date']     = $message_date;
            $result['time']     = $message_time;
        }
        if (!empty($row->cr_update))
        {
            $date = DateTime::createFromFormat('Y-m-d H:i:s', $row->cr_update);
            $date_update = ($row->cr_update != '0000-00-00 00:00:00' and $date !== false)
                ? strftime('%d %B %G, %H:%M', strtotime($row->cr_update))
                : '';

            $message_date = ($row->cr_update != '0000-00-00 00:00:00' or $date !== false)
                ? $date->format('d.m.Y')
                : '';
            $message_time = ($row->cr_update != '0000-00-00 00:00:00' or $date !== false)
                ? $date->format('H:i')
                : '';

            $result['date_update'] = $date_update;
            $result['date']     = $message_date;
            $result['time']     = $message_time;
        }

        return $result;
    }

    /* КОНЕЦ БЛОКА ФУНКЦИЙ ОБРАБОТКИ ДАННЫХ */
}