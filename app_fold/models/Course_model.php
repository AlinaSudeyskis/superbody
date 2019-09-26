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
            parent::logDbMessages(__METHOD__.':'.__LINE__);
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
            parent::logDbMessages(__METHOD__.':'.__LINE__);
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
            parent::logDbMessages(__METHOD__.':'.__LINE__);
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
            parent::logDbMessages(__METHOD__.':'.__LINE__);
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
                $result['course_types'][$row->ct_id]['id']   = $row->ct_id;
                $result['course_types'][$row->ct_id]['name'] = $row->ct_name;

                $i++;
            }
            unset($row);
        }
        elseif ($sel_types === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Выборка доступного типа курса
     *
     * @param $type_id
     * @return array
     */
    public function getAvailableCourseType($type_id)
    {
        // Результат
        $result = array();

        $sel_types = $this->db->query('SELECT `ct_id`, `ct_name` FROM `course_type` WHERE `ct_blocked`=0 and `ct_id`=? LIMIT 1', $type_id);

        if ($sel_types !== false and 0 < $sel_types->num_rows())
        {
            $i = 0;
            foreach ($sel_types->result() as $row)
            {
                $result['course_type'][$row->ct_id]['id']   = $row->ct_id;
                $result['course_type'][$row->ct_id]['name'] = $row->ct_name;

                $i++;
            }
            unset($row);
        }
        elseif ($sel_types === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
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
            parent::logDbMessages(__METHOD__.':'.__LINE__);
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
            parent::logDbMessages(__METHOD__.':'.__LINE__);
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
            parent::logDbMessages(__METHOD__.':'.__LINE__);
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
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /* КОНЕЦ БЛОКА ОБРАБОТКИ ДАННЫХ КАТЕГОРИИ ПРИЕМА ПИЩИ */


    /* НАЧАЛО БЛОКА ОБРАБОТКИ ДАННЫХ ПРИЕМА ПИЩИ */

    /**
     * Сохранение нового приема пищи
     *
     * @param string $name Наименование
     * @param string $time_from
     * @param string $time_to
     * @param int $admin_id
     * @param datetime $date Текущее время
     * @return bool|int
     */
    public function setNewIngestion($name, $time_from, $time_to, $admin_id, $date)
    {
        $up_data = $this->db->query('
            INSERT INTO `ingestions`(`ing_name`, `ing_time_from`, `ing_time_to`, `ing_admin_id`, `ing_date_add`, `ing_date_update`) 
            VALUES (?, ?, ?, ?, ?, ?)', array($name, $time_from, $time_to, $admin_id, $date, $date));

        if ($up_data !== false and 1 == $this->db->affected_rows())
        {
            return $this->db->insert_id();
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
     * Сохранение данных приема пищи
     *
     * @param int $ing_id ID приема пищи
     * @param string $time_from
     * @param string $time_to
     * @param int $admin_id
     * @param datetime $date Текущее время
     * @return bool
     */
    public function setIngestionSettings($ing_id, $name, $time_from, $time_to, $admin_id, $date)
    {
        $up_data = $this->db->query('
            UPDATE `ingestions` 
            SET `ing_name`=?, `ing_time_from`=?, `ing_time_to`=?, `ing_admin_id`=?, `ing_date_update`=? 
            WHERE `ing_id`=? LIMIT 1', array($name, $time_from, $time_to, $admin_id, $date, $ing_id));

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
     * Получение данных приема пищи
     *
     * @param int $ing_id ID приема пищи
     * @return array
     */
    public function getIngestion($ing_id)
    {
        $result = array();

        $sel_course_type = $this->db->query('
            SELECT `ing_name`, `ing_time_from`, `ing_time_to`, `ing_blocked` 
            FROM `ingestions` 
            WHERE `ing_id`=? LIMIT 1', $ing_id);

        if ($sel_course_type !== false and 1 == $sel_course_type->num_rows())
        {
            $row = $sel_course_type->row();

            $result['ingestion']['name']      = $row->ing_name;
            $result['ingestion']['time_from'] = $row->ing_time_from;
            $result['ingestion']['time_to']   = $row->ing_time_to;
            $result['ingestion']['blocked']   = $row->ing_blocked;
        }
        elseif ($sel_course_type === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
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
        $result = array('ingestions' => array());

        $sel_types = $this->db->query('SELECT `ing_id`, `ing_name`, `ing_time_from`, `ing_time_to` FROM `ingestions`');

        if ($sel_types !== false and 0 < $sel_types->num_rows())
        {
            $i = 0;
            foreach ($sel_types->result() as $row)
            {
                $time_from = mb_substr($row->ing_time_from, 0, 5);
                $time_to   = mb_substr($row->ing_time_to, 0, 5);

                $result['ingestions'][$i]['id']        = $row->ing_id;
                $result['ingestions'][$i]['name']      = $row->ing_name;
                $result['ingestions'][$i]['time_from'] = $time_from;
                $result['ingestions'][$i]['time_to']   = $time_to;

                $result['ingestions_id'][$i]             = $row->ing_id;
                $result['ingestions_from'][$row->ing_id] = $time_from;
                $result['ingestions_to'][$row->ing_id]   = $time_to;

                $i++;
            }
            unset($row);
        }
        elseif ($sel_types === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Блокировка/разблокировка приема пищи
     *
     * @param $ing_id
     * @param $block
     * @param $admin_id
     * @param $date
     * @return bool
     */
    public function blockIngestion($ing_id, $block, $admin_id, $date)
    {
        $up_data = $this->db->query('
            UPDATE `ingestions` SET `ing_blocked`=?, `ing_admin_id`=?, `ing_date_update`=?
            WHERE `ing_id`=? LIMIT 1', array($block, $admin_id, $date, $ing_id));

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

    /* КОНЕЦ БЛОКА ОБРАБОТКИ ДАННЫХ ПРИЕМА ПИЩИ */


    /* НАЧАЛО БЛОКА ОБРАБОТКИ ДАННЫХ БЛЮДА */

    /**
     * Выборка списка блюд
     *
     * @return array
     */
    public function getMeals()
    {
        $result = array('meals' => array());

        $sel_data = $this->db->query('SELECT `ml_id`, `ml_name` FROM `meals`');

        if($sel_data !== false and 0 < $sel_data->num_rows())
        {
            $i = 0;
            foreach($sel_data->result() as $row)
            {
                $result['meals'][$i] = self::parseMealData($row);

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
     * Сохранение нового блюда
     *
     * @param $category
     * @param $name
     * @param $description
     * @param $type
     * @param $videos
     * @param $ingredients
     * @param $ingredients_text
     * @param $total_weight
     * @param $total_proteins
     * @param $total_fats
     * @param $total_carbohydrates
     * @param $total_calories
     * @param $admin_id
     * @param $date
     * @return bool
     */
    public function setNewMeal($category, $name, $description, $type, $videos, $ingredients, $ingredients_text, $total_weight,
                               $total_proteins, $total_fats, $total_carbohydrates, $total_calories, $admin_id, $date)
    {
        $ins_data = $this->db->query('
            INSERT INTO `meals` (`ml_category_id`, `ml_mt_id`, `ml_name`, `ml_description`, `ml_ingredients`, `ml_weight`, 
              `ml_proteins`, `ml_fats`, `ml_carbohydrates`, `ml_calories`, `ml_admin_id`, `ml_update`) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)',
                array($category, $type, $name, $description, $ingredients_text, $total_weight, $total_proteins, $total_fats,
                    $total_carbohydrates, $total_calories, $admin_id, $date));

        if ($ins_data !== false and 1 == $this->db->affected_rows())
        {
            $meal_id = $this->db->insert_id();
            $images_path = './meals_files/' . $meal_id;

            // Сохранение пути к изображениям
            $up_data = $this->db->query('UPDATE `meals` SET `ml_images`=? WHERE `ml_id`=? LIMIT 1', array($images_path, $meal_id));

            if ($up_data === false)
            {
                parent::logDbMessages(__METHOD__.':'.__LINE__);
            }

            // Сохранение ингредиентов блюда
            if(!empty($ingredients))
            {
                self::setMealIngredients($meal_id, $ingredients, $admin_id, $date);
            }

            // Сохранение видео блюда
            if(!empty($videos))
            {
                self::setMealVideos($meal_id, $videos, $admin_id, $date);
            }

            return $meal_id;
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

    /**
     * Сохранение массива блюд с проверкой типа блюда
     *
     * @param $meals
     * @param $admin_id
     * @param $date
     * @return bool
     */
    public function setNewMeals($meals, $admin_id, $date)
    {
        $result = true;

        if(!empty($meals['meals']) and is_numeric($admin_id) and !empty($date))
        {
            foreach($meals['meals'] as $meal)
            {
                $sel_data = $this->db->query('SELECT `ml_id` FROM `meals` WHERE `ml_name`=? LIMIT 1', $meal['name']);
                if($sel_data !== false and 0 == $sel_data->num_rows())
                {

                    $type_id = self::checkMealType($meal['type'], $admin_id, $date);

                    $ins_data = $this->db->query('
                        INSERT INTO `meals` (`ml_mt_id`, `ml_name`, `ml_description`, `ml_image`, `ml_ingredients`, 
                          `ml_weight`, `ml_proteins`, `ml_fats`, `ml_carbohydrates`, `ml_calories`, `ml_admin_id`, `ml_update`) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)',
                            array($type_id, $meal['name'], $meal['description'], $meal['image'], $meal['ingredients'],
                                $meal['weight'], $meal['proteins'], $meal['fats'], $meal['carbohydrates'],
                                $meal['calories'], $admin_id, $date));
                    if($ins_data === false)
                    {
                        parent::logDbMessages(__METHOD__.':'.__LINE__);
                        $result = false;
                    }
                }
                elseif($sel_data === false)
                {
                    parent::logDbMessages(__METHOD__.':'.__LINE__);
                }
            }
            unset($meal);
        }

        return $result;
    }

    /**
     * Выборка данных блюда
     *
     * @param $meal_id
     * @return array
     */
    public function getMeal($meal_id)
    {
        $result = array('meal' => array());

        $sel_data = $this->db->query('
            SELECT `ml_id`, `ml_category_id`, `ml_mt_id`, `ml_name`, `ml_description`, `ml_ingredients`, `ml_images`, 
              `ml_image`, `ml_weight`, `ml_proteins`, `ml_fats`, `ml_carbohydrates`, `ml_calories`, `ml_blocked` 
            FROM `meals` WHERE `ml_id`=? LIMIT 1', $meal_id);

        if($sel_data !== false and 0 < $sel_data->num_rows())
        {
            $row = $sel_data->row();

            $result['meal'] = self::parseMealData($row);

            // Игредиенты блюда
            $ingredients = self::getMealIngredients($meal_id);

            // Видео блюда
            $videos = self::getMealVideos($meal_id);

            $result['meal'] = array_merge($result['meal'], $ingredients, $videos);

        }
        elseif($sel_data === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Сохранение изменений данных блюда
     *
     * @param $meal_id
     * @param $category
     * @param $name
     * @param $description
     * @param $type
     * @param $insert_videos
     * @param $insert_ingredients
     * @param $update_ingredients
     * @param $delete_ingredients
     * @param $ingredients_text
     * @param $total_weight
     * @param $total_proteins
     * @param $total_fats
     * @param $total_carbohydrates
     * @param $total_calories
     * @param $admin_id
     * @param $date
     * @return bool
     */
    public function updateMealSettings($meal_id, $category, $name, $description, $type, $insert_videos, $insert_ingredients,
                                       $update_ingredients, $delete_ingredients, $ingredients_text, $total_weight,
                                       $total_proteins, $total_fats, $total_carbohydrates, $total_calories, $admin_id, $date)
    {
        $result = false;

        if(is_numeric($meal_id))
        {
            $up_data = $this->db->query('
                UPDATE `meals` SET `ml_category_id`=?, `ml_mt_id`=?, `ml_name`=?, `ml_description`=?, `ml_ingredients`=?, 
                  `ml_weight`=?, `ml_proteins`=?, `ml_fats`=?, `ml_carbohydrates`=?, `ml_calories`=?, `ml_admin_id`=?, 
                  `ml_update`=? 
                WHERE `ml_id`=? LIMIT 1',
                    array($category, $type, $name, $description, $ingredients_text, $total_weight, $total_proteins,
                        $total_fats, $total_carbohydrates, $total_calories, $admin_id, $date, $meal_id));

            if($up_data !== false and 1 == $this->db->affected_rows())
            {
                if(!empty($insert_ingredients))
                {
                    self::setMealIngredients($meal_id, $insert_ingredients, $admin_id, $date);
                }
                if(!empty($update_ingredients))
                {
                    self::updateMealIngredients($meal_id, $update_ingredients, $admin_id, $date);
                }
                if(!empty($delete_ingredients))
                {
                    self::deleteMealIngredients($meal_id, $delete_ingredients);
                }
                if(!empty($insert_videos))
                {
                    self::setMealVideos($meal_id, $insert_videos, $admin_id, $date);
                }

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
     * Блокировка/разблокировка блюда
     *
     * @param $meal_id
     * @param $block
     * @param $admin_id
     * @param $date
     * @return bool
     */
    public function blockMeal($meal_id, $block, $admin_id, $date)
    {
        $up_data = $this->db->query('UPDATE `meals` SET `ml_blocked`=?, `ml_admin_id`=?, `ml_update`=? WHERE `ml_id`=? LIMIT 1',
            array($block, $admin_id, $date, $meal_id));

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

    /**
     * Добавление видео блюда
     *
     * @param $meal_id
     * @param $videos
     * @param $admin_id
     * @param $date
     * @return bool
     */
    public function setMealVideos($meal_id, $videos, $admin_id, $date)
    {
        $result = true;

        if(!empty($videos) and is_array($videos))
        {
            $values = '';
            foreach($videos as $video)
            {
                $values .= (!empty($values)) ? ', ' : '';

                $values .= '('.$meal_id.', "'.$video.'", '.$admin_id.', "'.$date.'")';
            }
            unset($video);

            if(!empty($values))
            {
                $ins_data = $this->db->query('INSERT INTO `meals_videos` (`mv_ml_id`, `mv_video`, `mv_admin_id`, `mv_update`)
                    VALUES ' . $values);
                if($ins_data === false)
                {
                    parent::logDbMessages(__METHOD__.':'.__LINE__);
                    $result = false;
                }
            }
        }

        return $result;
    }

    /**
     * Выборка видео блюда
     *
     * @param $meal_id
     * @return array
     */
    public function getMealVideos($meal_id)
    {
        $result = array('meal_videos' => array());

        $sel_data = $this->db->query('SELECT `mv_id`, `mv_video` FROM `meals_videos` WHERE `mv_ml_id`=?', $meal_id);

        if($sel_data !== false and 0 < $sel_data->num_rows())
        {
            $i = 0;
            foreach($sel_data->result() as $row)
            {
                $result['meal_videos'][$row->mv_id] = htmlspecialchars_decode($row->mv_video, ENT_QUOTES);

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
     * Удаление видео из списка видео блюда
     *
     * @param $meal_id
     * @param $video_id
     * @return bool
     */
    public function deleteMealVideo($meal_id, $video_id)
    {
        $result = true;

        $del_data = $this->db->query('DELETE FROM `meals_videos` WHERE `mv_id`=? and `mv_ml_id`=? LIMIT 1', array($video_id, $meal_id));

        if($del_data === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Выборка первого блюда приема пищи курса питания
     *
     * @param $course_id
     * @return array
     */
    public function getNutritionIngestionsFirstMeal($course_id)
    {
        $result = array('meal' => array());

        $sel_data = $this->db->query('
            SELECT `cds_day`, `cds_ci_id`, `cds_ml_id`,
             `ml_name`, `ml_weight`, `ml_proteins`, `ml_fats`, `ml_carbohydrates`, `ml_calories`
            FROM `courses_days_schedule`
             LEFT JOIN `meals` ON `ml_id`=`cds_ml_id`             
            WHERE `cds_crs_id`=?', $course_id);

        if($sel_data !== false and 0 < $sel_data->num_rows())
        {
            foreach($sel_data->result() as $row)
            {
                if(empty($result['meal'][$row->cds_day][$row->cds_ci_id]))
                {
                    $result['meal'][$row->cds_day][$row->cds_ci_id]['id']   = $row->cds_ml_id;
                    $result['meal'][$row->cds_day][$row->cds_ci_id]['name'] = $row->ml_name . ' [БЖУК - ' . $row->ml_proteins . ' '
                        . $row->ml_fats .  ' ' . $row->ml_carbohydrates . ' ' . $row->ml_caloreis . ']';
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
     * Выборка блюда курса питания
     *
     * @param $user_id
     * @param $un_id
     * @param $day
     * @param $ingestion
     * @param $meal_id
     * @return array
     */
    public function getUserNutritionMeal($user_id, $day, $ingestion, $un_id, $meal_id)
    {
        $result = array('meal' => array());

        if(is_numeric($user_id) and is_numeric($day) and is_numeric($ingestion) and is_numeric($un_id) and is_numeric($meal_id))
        {
            $sel_uc = $this->db->query('
                SELECT `un_id`, `un_date`, `uc_course_id`, `uc_user_id`
                FROM `users_nutritions`
                LEFT JOIN `users_courses` ON `uc_id`=`un_uc_id`
                WHERE `un_id`=? and `uc_user_id`=? LIMIT 1', array($un_id, $user_id));

            if($sel_uc !== false and 1 == $sel_uc->num_rows())
            {
                $row       = $sel_uc->row();
                $course_id = $row->uc_course_id;

                $fill_nutrition = self::getFillNutritionSchedule($course_id);

                // Выборка блюда по ID
                if(empty($meal_id))
                {
                    // Выборка блюда из меню курса
                    $meal_id = $fill_nutrition['fill_course_schedule'][$day][$ingestion];
                }

                // Блюдо
                $meal = self::getMeal($meal_id);
                // Игредиенты блюда
                $ingredients = self::getMealIngredients($meal_id);

                $result['meal'] = array_merge($meal['meal'], $ingredients);

                $result['duplicate_day'] = $fill_nutrition['duplicate_course_schedule'][$day][$ingestion]['day'];
                $result['duplicate_ing'] = $fill_nutrition['duplicate_course_schedule'][$day][$ingestion]['ing'];
                $result['un_date']       = $row->un_date;
                $result['un_id']         = $row->un_id;
            }
            elseif($sel_uc === false)
            {
                parent::logDbMessages(__METHOD__.':'.__LINE__);
            }
        }

        return $result;
    }

    /**
     * Выборка блюд приема пищи
     *
     * @param $user_id
     * @param $day
     * @param $ingestion
     * @param $un_id
     * @return array
     */
    public function getUserNutritionMeals($user_id, $day, $ingestion, $un_id)
    {
        $result = array('meals' => array());

        if(is_numeric($user_id) and is_numeric($day) and is_numeric($ingestion) and !empty($un_id))
        {
            // Данные курса питания пользователя
            $sel_uc = $this->db->query('
                SELECT `uc_course_id`, `un_uc_id`, `un_date`
                FROM `users_nutritions`
                LEFT JOIN `users_courses` ON `uc_id`=`un_uc_id`
                WHERE `un_id`=? and `uc_user_id`=? LIMIT 1', array($un_id, $user_id));

            if($sel_uc !== false and 1 == $sel_uc->num_rows())
            {
                $row       = $sel_uc->row();
                $course_id = $row->uc_course_id;
                $uc_id     = $row->un_uc_id;
                $nutr_date = $row->un_date;
                unset($row);

                $fill_nutrition = self::getFillNutritionSchedule($course_id);

                // Выборка блюд приема пищи курса питания пользователя
                $sel_meals = $this->db->query('
                    SELECT `un_id`, `un_ml_id`, `un_date`, `ml_name`, `ml_mt_id`, `mt_name` 
                    FROM `users_nutritions`
                    LEFT JOIN `meals` ON `ml_id`=`un_ml_id`
                    LEFT JOIN `meals_types` ON `mt_id`=`ml_mt_id`
                    WHERE `un_uc_id`=? and `un_cds_day`=? and `un_cds_ci_id`=?', array($uc_id, $day, $ingestion));
                if($sel_meals !== false and 0 < $sel_meals->num_rows())
                {
                    $images = array();
                    $image  = array();
                    $i = 0;
                    $im_i = 0;
                    foreach($sel_meals->result() as $row)
                    {
                        $meal = self::getMeal($row->un_ml_id);

                        $result['meals'][$row->ml_mt_id][$i] = $meal['meal'];
                        $result['meals'][$row->ml_mt_id][$i]['un_id'] = $row->un_id;
                        $result['meals'][$row->ml_mt_id][$i]['date'] = $row->un_date;

                        // Изображения блюд
                        if(!empty($meal['meal']['images']))
                        {
                            $fi = 0;
                            $full_images = array();
                            foreach($meal['meal']['images'] as $mim)
                            {
                                $full_images[$fi] = $meal['meal']['images_path'].'/'.$mim;
                                $fi++;
                            }
                            $images = array_merge_recursive($images, $full_images);
                        }
                        if(!empty($meal['meal']['image']))
                        {
                            $image[$im_i] = $meal['meal']['image'];
                            $im_i++;
                        }

                        $result['meals_types'][$row->ml_mt_id] = $row->mt_name;

                        $i++;
                    }
                    unset($row);
                }
                elseif($sel_meals === false)
                {
                    parent::logDbMessages(__METHOD__.':'.__LINE__);
                }

                $rand_image = '';
                // Выбор случайного изображения
                if(!empty($image))
                {
                    $rand_key = array_rand($image, 1);
                    $rand_image = $image[$rand_key];
                }
                elseif(!empty($images))
                {
                    $rand_key = array_rand($images, 1);
                    $rand_image = $images[$rand_key];
                }

                $result['duplicate_day'] = $fill_nutrition['duplicate_course_schedule'][$day][$ingestion]['day'];
                $result['duplicate_ing'] = $fill_nutrition['duplicate_course_schedule'][$day][$ingestion]['ing'];
                $result['un_date']       = $nutr_date;
                $result['image']         = $rand_image;
            }
            elseif($sel_uc === false)
            {
                parent::logDbMessages(__METHOD__.':'.__LINE__);
            }
        }

        return $result;
    }

    /**
     * Выборка блюд приема пищи определенного дня курса питания пользователя
     *
     * @param $user_id
     * @param $un_id
     * @param $day
     * @param $ingestion
     * @return array
     */
    public function getUserIngestionMeals($user_id, $un_id, $day, $ingestion)
    {
        $result = array('meals' => array());

        $sel_data = $this->db->query('
            SELECT `un_uc_id`, `uc_course_id`, `uc_user_id`, `ml_mt_id` 
            FROM `users_nutritions` 
            LEFT JOIN `users_courses` ON `uc_id`=`un_uc_id`
            LEFT JOIN `meals` ON `ml_id`=`un_ml_id`
            WHERE `un_id`=? and `uc_user_id`=? LIMIT 1', array($un_id, $user_id));

        if($sel_data !== false and 1 == $sel_data->num_rows())
        {
            $row = $sel_data->row();
            $course_id  = $row->uc_course_id;
            $ml_type_id = $row->ml_mt_id;
            unset($row);

            $schedule = self::getFillNutritionSchedule($course_id);
            $result['meals'] = $schedule['course_schedule'][$day][$ingestion][$ml_type_id];
        }
        elseif($sel_data === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Сохранение номера блюда курса питания пользователя
     *
     * @param $user_id
     * @param $day
     * @param $ingestion
     * @param $un_id
     * @param $meal_id
     * @param $date
     * @return bool
     */
    public function updateUserNutritionMeal($user_id, $day, $ingestion, $un_id, $meal_id, $date)
    {
        $result = false;

        $sel_data = $this->db->query('
            SELECT `un_uc_id`, `uc_user_id` 
            FROM `users_nutritions`
             LEFT JOIN `users_courses` ON `uc_id`=`un_uc_id`
            WHERE `un_id`=? and `uc_user_id`=? LIMIT 1', array($un_id, $user_id));

        if($sel_data !== false and 1 == $sel_data->num_rows())
        {
            $up_data = $this->db->query('
                UPDATE `users_nutritions` SET `un_ml_id`=?, `un_update`=? 
                WHERE `un_id`=? and `un_cds_day`=? and `un_cds_ci_id`=? LIMIT 1',
                    array($meal_id, $date, $un_id, $day, $ingestion));

            if($up_data !== false and 1 == $this->db->affected_rows())
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

        return $result;
    }

    /**
     * Ингредиенты блюда
     *
     * @param $meal_id
     * @return array
     */
    public function getMealIngredients($meal_id)
    {
        $result = array('ingredients' => array());

        $sel_data = $this->db->query('
            SELECT `ingr_id`, `ingr_attached_ml_id`, `ingr_weight`, `ml_name`, `ml_calories`, `ml_proteins`, `ml_fats`, `ml_carbohydrates` 
            FROM `ingredients`
            LEFT JOIN `meals` ON `ml_id`=`ingr_attached_ml_id` 
            WHERE `ingr_ml_id`=?', $meal_id);

        if($sel_data !== false and 0 < $sel_data->num_rows())
        {
            $i = 0;
            foreach($sel_data->result() as $row)
            {
                $result['ingredients'][$row->ingr_attached_ml_id]['id']            = $row->ingr_attached_ml_id;
                $result['ingredients'][$row->ingr_attached_ml_id]['name']          = $row->ml_name;
                $result['ingredients'][$row->ingr_attached_ml_id]['weight']        = $row->ingr_weight;
                $result['ingredients'][$row->ingr_attached_ml_id]['proteins']      = $row->ml_proteins;
                $result['ingredients'][$row->ingr_attached_ml_id]['fats']          = $row->ml_fats;
                $result['ingredients'][$row->ingr_attached_ml_id]['carbohydrates'] = $row->ml_carbohydrates;
                $result['ingredients'][$row->ingr_attached_ml_id]['calories']      = $row->ml_calories;

                $result['ingredients_id'][$row->ingr_attached_ml_id] = $row->ingr_attached_ml_id;

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
     * Добавление ингредиентов блюда
     *
     * @param $meal_id
     * @param array $ingredients
     * @param $admin_id
     * @param $date
     * @return bool
     */
    public function setMealIngredients($meal_id, $ingredients, $admin_id, $date)
    {
        $result = false;

        if(is_array($ingredients))
        {
            $values = '';
            $i = 0;
            foreach($ingredients as $ingr_id => $ingr_weight)
            {
                if($i > 0)
                {
                    $values .= ', ';
                }

                $values .= '('. $meal_id .', "'. $ingr_id .'", '. $ingr_weight .', '. $admin_id .', "'. $date .'")';

                $i++;
            }
            unset($ingr_weight);

            $ins_ingr = $this->db->query('
                INSERT INTO `ingredients` (`ingr_ml_id`, `ingr_attached_ml_id`, `ingr_weight`, `ingr_admin_id`, `ingr_update`) 
                VALUES ' . $values);

            if($ins_ingr !== false)
            {
                $result = true;
            }
            elseif($ins_ingr === false)
            {
                parent::logDbMessages(__METHOD__.':'.__LINE__);
            }
        }

        return $result;
    }

    /**
     * Обновление данных ингредиентов
     *
     * @param $meal_id
     * @param array $ingredients
     * @param $admin_id
     * @param $date
     * @return bool
     */
    public function updateMealIngredients($meal_id, $ingredients, $admin_id, $date)
    {
        $result = true;

        if(is_array($ingredients))
        {
            foreach($ingredients as $ingr_id => $ingr_weight)
            {
                $up_data = $this->db->query('
                    UPDATE `ingredients` SET `ingr_weight`=?, `ingr_admin_id`=?, `ingr_update`=?
                    WHERE `ingr_ml_id`=? and `ingr_attached_ml_id`=? LIMIT 1',
                        array($ingr_weight, $admin_id, $date, $meal_id, $ingr_id));

                if($up_data === false)
                {
                    parent::logDbMessages(__METHOD__.':'.__LINE__);
                    $result = false;
                }
            }
            unset($ingr_weight);
        }

        return $result;
    }

    /**
     * Удаление ингредиентов блюда
     *
     * @param $meal_id
     * @param array $ingredients
     * @return bool
     */
    public function deleteMealIngredients($meal_id, $ingredients)
    {
        $result = true;

        if(is_array($ingredients))
        {
            foreach($ingredients as $ingr_id => $ingr_weight)
            {
                $up_data = $this->db->query('DELETE FROM `ingredients` WHERE `ingr_ml_id`=? and `ingr_attached_ml_id`=? LIMIT 1',
                    array($meal_id, $ingr_id));

                if($up_data === false)
                {
                    parent::logDbMessages(__METHOD__.':'.__LINE__);
                    $result = false;
                }
            }
            unset($ingr_weight);
        }

        return $result;
    }

    /**
     * Список типов блюд
     *
     * @return array
     */
    public function getMealsTypes()
    {
        $result = array('meals_types' => array());

        $sel_data = $this->db->query('SELECT `mt_id`, `mt_name` FROM `meals_types`');

        if($sel_data !== false and 0 < $sel_data->num_rows())
        {
            $i = 0;
            foreach($sel_data->result() as $row)
            {
                $result['meals_types'][$i]['id']   = $row->mt_id;
                $result['meals_types'][$i]['name'] = $row->mt_name;

                $result['meals_types_id'][$i] = $row->mt_id;

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
     * Данные типа блюда
     *
     * @param $type_id
     * @return array
     */
    public function getMealsType($type_id)
    {
        $result = array('meals_type' => array());

        $sel_data = $this->db->query('SELECT `mt_id`, `mt_name`, `mt_blocked` FROM `meals_types` WHERE `mt_id`=? LIMIT 1', $type_id);

        if($sel_data !== false and 0 < $sel_data->num_rows())
        {
            $row = $sel_data->row();

            $result['meals_type']['id']      = $row->mt_id;
            $result['meals_type']['name']    = $row->mt_name;
            $result['meals_type']['blocked'] = $row->mt_blocked;
        }
        elseif($sel_data === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Сохранение нового типа блюда
     *
     * @param $name
     * @param $admin_id
     * @param $date
     * @return bool
     */
    public function setNewMealsType($name, $admin_id, $date)
    {
        $ins_data = $this->db->query('
            INSERT INTO `meals_types` (`mt_name`, `mt_admin_id`, `mt_update`) 
            VALUES (?, ?, ?)', array($name, $admin_id, $date));

        if ($ins_data !== false and 1 == $this->db->affected_rows())
        {
            return $this->db->insert_id();
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

    /**
     * Сохранение изменений данных типа блюда
     *
     * @param $type_id
     * @param $name
     * @param $admin_id
     * @param $date
     * @return bool
     */
    public function updateMealsType($type_id, $name, $admin_id, $date)
    {
        $up_data = $this->db->query('
            UPDATE `meals_types` 
            SET `mt_name`=?, `mt_admin_id`=?, `mt_update`=? 
            WHERE `mt_id`=? LIMIT 1', array($name, $admin_id, $date, $type_id));

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
     * Блокировка\разблокировка типа блюда
     *
     * @param $type_id
     * @param $block
     * @param $admin_id
     * @param $date
     * @return bool
     */
    public function blockMealsType($type_id, $block, $admin_id, $date)
    {
        $up_data = $this->db->query('
            UPDATE `meals_types` SET `mt_blocked`=?, `mt_admin_id`=?, `mt_update`=?
            WHERE `mt_id`=? LIMIT 1', array($block, $admin_id, $date, $type_id));

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

    /**
     * Поиск типа блюда по имени. Добавление нового типа блюда, в случае отсутствия
     *
     * @param $type_name
     * @param $admin_id
     * @param $date
     * @return bool|null
     */
    public function checkMealType($type_name, $admin_id, $date)
    {
        $result = null;

        $sel_data = $this->db->query('SELECT `mt_id` FROM `meals_types` WHERE `mt_name`=? LIMIT 1', $type_name);

        if($sel_data !== false and 1 == $sel_data->num_rows())
        {
            $row = $sel_data->row();
            $result = $row->mt_id;
        }
        elseif($sel_data === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }
        else
        {
            // Добавление нового типа блюда
            $result = self::setNewMealsType($type_name, $admin_id, $date);
        }

        return $result;
    }

    /**
     * Выборка категорий блюд курса питания
     *
     * @param $course_id
     * @return array
     */
    public function getNutritionMealsTypes($course_id)
    {
        $result = array('course_ml_types' => array());

        $sel_data = $this->db->query('
          SELECT `cds_id`, `ml_id`, `ml_mt_id`, `mt_id`, `mt_name` 
          FROM `courses_days_schedule`
          LEFT JOIN `meals` ON `ml_id`=`cds_ml_id`
          LEFT JOIN `meals_types` ON `mt_id`=`ml_mt_id`
          WHERE `cds_crs_id`=?
          GROUP BY `mt_id`', $course_id);

        if($sel_data !== false and 0 < $sel_data->num_rows())
        {
            $i = 0;
            foreach($sel_data->result() as $row)
            {
                $result['course_ml_types'][$i]['id']   = $row->mt_id;
                $result['course_ml_types'][$i]['name'] = $row->mt_name;

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
     * AJAX. Поиск блюд
     *
     * @param $search_text
     * @param $crs_day
     * @param $crs_ingestion
     * @return bool|string
     */
    public function searchMeals($search_text, $crs_day, $crs_ingestion)
    {
        $result = false;

        $search_text = $search_text.'*';
        $search_text = preg_replace_callback('/([^"]+)/',
            function ($matches) {
                return str_replace(' ', ' +', $matches[1]);
            }, $search_text);

        $sel_meals = $this->db->query('
            SELECT `ml_id`, `ml_mt_id`, `ml_name`, `ml_description`, `ml_weight`, `ml_proteins`, `ml_fats`, 
              `ml_carbohydrates`, `ml_calories`, `mt_name`
            FROM `meals`
            LEFT JOIN `meals_types` ON `mt_id`=`ml_mt_id`
            WHERE MATCH (`ml_name`) AGAINST (? IN BOOLEAN MODE) and `ml_blocked`=0', $search_text);

        if ($sel_meals !== false and 0 < $sel_meals->num_rows())
        {
            foreach ($sel_meals->result() as $row)
            {
                $result .= '
                    <div class="add_tren_item meal parent" data-day="' . $crs_day . '" data-meal-id="' . $row->ml_id . '" 
                        data-ingestion="' . $crs_ingestion . '" data-ml-type="' . $row->ml_mt_id . '" data-ml-name="' . $row->mt_name . '" 
                        data-meal-name="' . $row->ml_name . '" data-weight="' . $row->ml_weight . '" 
                        data-proteins="' . $row->ml_proteins . '" data-fats="' . $row->ml_fats . '" 
                        data-carbohydrates="' . $row->ml_carbohydrates . '" data-calories="' . $row->ml_calories . '">
                        <a href="/administration/meal/' . $row->ml_id . '" class="add_tov_cont add_tren_name">
                            <div class="add_tov_h">' . $row->ml_name . '</div>
                        </a>
                    </div>';
                /*$result .= '
                    <div class="parent kurs_cur_wrap">
                        <div class="kurs_block_h"></div>
                        <div id="meal-'. $crs_day .'-'. $crs_ingestion .'-'. $row->ml_id .'" class="add_tov_val_item parent">
                            <div class="add_kurs_val_video_wrap parent">
                                <a href="/administration/meal/'. $row->ml_id .'" class="add_tov_val_cont parent">
                                    <span class="add_tov_val_h">'. $row->ml_name .'</span>
                                    <span class="add_tov_val_sh">БЖУК - '. $row->ml_proteins .' '. $row->ml_fats .' '.
                                        $row->ml_carbohydrates .' '. $row->ml_calories .'</span>
                                </a>
                                <div class="del_tov"></div>
                            </div>
                            <input type="hidden" name="id_meal['. $crs_day .']['. $crs_ingestion .']['. $row->ml_id .']" value="" id="id-meal-'. $crs_day .'-'. $crs_ingestion .'-'. $row->ml_id .'"/>
                        </div>
                    </div>';*/
            }
            unset($row);
        }
        elseif ($sel_meals === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }
        else
        {
            $result = '<div class="not_found">Блюдо не найдено</div>';
        }

        return $result;
    }

    /**
     * AJAX. Поиск продуктов/ингредиентов
     *
     * @param $search_text
     * @return bool|string
     */
    public function searchIngredients($search_text)
    {
        $result = false;

        $search_text = $search_text.'*';
        $search_text = preg_replace_callback('/([^"]+)/',
            function ($matches) {
                return str_replace(' ', ' +', $matches[1]);
            }, $search_text);

        $sel_meals = $this->db->query('
            SELECT `ml_id`, `ml_mt_id`, `ml_name`, `ml_description`, `ml_weight`, `ml_proteins`, `ml_fats`, 
              `ml_carbohydrates`, `ml_calories`, `mt_name`
            FROM `meals`
            LEFT JOIN `meals_types` ON `mt_id`=`ml_mt_id`
            WHERE MATCH (`ml_name`) AGAINST (? IN BOOLEAN MODE) and `ml_category_id`=2 and `ml_blocked`=0', $search_text);

        if ($sel_meals !== false and 0 < $sel_meals->num_rows())
        {
            foreach ($sel_meals->result() as $row)
            {
                $result .= '
                    <div class="add_tren_item ingredient parent" data-meal-id="' . $row->ml_id . '" 
                        data-meal-name="' . $row->ml_name . '" data-weight="' . $row->ml_weight . '" 
                        data-proteins="' . $row->ml_proteins . '" data-fats="' . $row->ml_fats . '" 
                        data-carbohydrates="' . $row->ml_carbohydrates . '" data-calories="' . $row->ml_calories . '">
                        <a href="/administration/meal/' . $row->ml_id . '" class="add_tov_cont add_tren_name">
                            <div class="add_tov_h">' . $row->ml_name . '</div>
                        </a>
                    </div>';
            }
            unset($row);
        }
        elseif ($sel_meals === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }
        else
        {
            $result = '<div class="not_found">Блюдо не найдено</div>';
        }

        return $result;
    }

    /**
     * AJAX. Поиск по продуктам/ингредиентам/блюдам
     *
     * @param $search_text
     * @return bool
     */
    public function userSearchMeals($search_text)
    {
        $result = '';

        $search_text = $search_text.'*';
        $search_text = preg_replace_callback('/([^"]+)/',
            function ($matches) {
                return str_replace(' ', ' +', $matches[1]);
            }, $search_text);

        $sel_meals = $this->db->query('
            SELECT `ml_id`, `ml_mt_id`, `ml_name`, `ml_description`, `ml_weight`, `ml_proteins`, `ml_fats`, 
              `ml_carbohydrates`, `ml_calories`, `mt_name`
            FROM `meals`
            LEFT JOIN `meals_types` ON `mt_id`=`ml_mt_id`
            WHERE MATCH (`ml_name`) AGAINST (? IN BOOLEAN MODE) and `ml_blocked`=0', array($search_text));

        if($sel_meals !== false and 0 < $sel_meals->num_rows())
        {
            foreach($sel_meals->result() as $row)
            {
                $result .= '
                    <div class="add_tren_item ingredient parent" data-meal-id="' . $row->ml_id . '" 
                        data-meal-name="' . $row->ml_name . '" data-weight="' . $row->ml_weight . '" 
                        data-proteins="' . $row->ml_proteins . '" data-fats="' . $row->ml_fats . '" 
                        data-carbohydrates="' . $row->ml_carbohydrates . '" data-calories="' . $row->ml_calories . '">
                        <div class="add_tov_cont add_tren_name">
                            <div class="add_tov_h">' . $row->ml_name . '</div>
                        </div>
                    </div>';
            }
            unset($row);
        }
        elseif($sel_meals === false)
        {
            parent::logDbMessages(__METHOD__ . ':' . __LINE__);
        }
        else
        {
            $result = '<div class="not_found">Продукт/ингредиент/блюдо не найдены</div>';
        }

        return $result;
    }

    /**
     * Приемы пищи пользователя за последнюю неделю
     *
     * @param $user_id
     * @param $date
     *
     * @return array
     * @throws Exception
     */
    public function getLastWeekMeals($user_id, $date)
    {
        $result = array('user_meals' => array());

        $tmp_date = new DateTime($date);
        $tmp_date->sub(new DateInterval('P8D'));
        $week_ago = ($tmp_date !== false) ? $tmp_date->format('Y-m-d') : null;

        if(is_numeric($user_id) and !empty($week_ago))
        {
            $sel_data = $this->db->query('
                SELECT `udm_id`, `udm_u_id`, `udm_ml_id`, `udm_ml_weight`, `udm_datetime`, `udm_update`,
                  `ml_name`, `ml_calories`, `ml_proteins`, `ml_fats`, `ml_carbohydrates` 
                FROM `users_day_meals` 
                LEFT JOIN `meals` ON `ml_id`=`udm_ml_id`
                WHERE `udm_u_id`=? and `udm_datetime`>?
                ORDER BY `udm_datetime` DESC', array($user_id, $week_ago));
            if($sel_data !== false and 0 < $sel_data->num_rows())
            {
                $i = 0;
                foreach($sel_data->result() as $row)
                {
                    $result['user_meals'][$i] = self::parseUserMeals($row);

                    $i++;
                }
                unset($row);
            }
            elseif($sel_data === false)
            {
                parent::logDbMessages(__METHOD__.':'.__LINE__);
            }
        }

        return $result;
    }

    /**
     * Выборка приемов пищи пользователя на сегодня
     *
     * @param $user_id
     * @param $date
     *
     * @return array
     */
    public function getTodayUserMeal($user_id, $date)
    {
        $result = array('user_meal' => array(), 'today_meal_calories' => 0, 'today_meal_proteins' => 0,
            'today_meal_fats' => 0, 'today_meal_carbohydrates' => 0);

        $tmp_date = new DateTime($date);
        $today = ($tmp_date !== false) ? $tmp_date->format('Y-m-d') : null;

        if(is_numeric($user_id))
        {
            $sel_data = $this->db->query('
                SELECT `udm_id`, `udm_u_id`, `udm_ml_id`, `udm_ml_weight`, `udm_datetime`, `udm_update`,
                  `ml_name`, `ml_calories`, `ml_proteins`, `ml_fats`, `ml_carbohydrates` 
                FROM `users_day_meals` 
                LEFT JOIN `meals` ON `ml_id`=`udm_ml_id`
                WHERE `udm_u_id`=? and `udm_datetime`>?
                ORDER BY `udm_datetime` DESC', array($user_id, $today));
            if($sel_data !== false and 0 < $sel_data->num_rows())
            {
                $today_calories = 0;
                $today_proteins = 0;
                $today_fats = 0;
                $today_carbohydrates = 0;
                $i = 0;
                foreach($sel_data->result() as $row)
                {
                    $koef = $row->udm_ml_weight / 100;

                    $today_calories += $koef*$row->ml_calories;
                    $today_proteins += $koef*$row->ml_proteins;
                    $today_fats += $koef*$row->ml_fats;
                    $today_carbohydrates += $koef*$row->ml_carbohydrates;

                    $i++;
                }
                unset($row);
                $result['today_meal_calories'] = number_format($today_calories, 2, '.', '');
                $result['today_meal_proteins'] = number_format($today_proteins, 2, '.', '');
                $result['today_meal_fats'] = number_format($today_fats, 2, '.', '');
                $result['today_meal_carbohydrates'] = number_format($today_carbohydrates, 2, '.', '');
            }
            elseif($sel_data === false)
            {
                parent::logDbMessages(__METHOD__.':'.__LINE__);
            }
        }

        return $result;
    }

    /* КОНЕЦ БЛОКА ОБРАБОТКИ ДАННЫХ БЛЮДА */


    /* НАЧАЛО БЛОКА ОБРАБОТКИ ДАННЫХ КУРСА */

    /**
     * Выборка курсов.
     * Курсы тренировок, питания или архив.
     *
     * @param $category
     * @param $archive
     * @return array
     */
    public function getCourses($category = 'workout', $archive = 0)
    {
        $result['courses'] = array();
        
        $sel_courses = $this->db->query('
            SELECT `crs_id`, `crs_image`, `crs_name`, `crs_blocked`, `clp_id`, `clp_activated` 
            FROM `courses`
            LEFT JOIN `courses_landing_pages` ON `clp_course_id`=`crs_id`
            WHERE `crs_category`=? and `crs_archive`=?', array($category, $archive));
        
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
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }
        
        return $result;
    }

    /**
     * Выборка доступных (не заблокированных) для пользователей курсов
     *
     * @param $courses_category
     * @param $courses_type
     * @param null $first_id
     * @param null $last_id
     * @param null $promocode_data
     * @param null $coach_courses
     * @return array
     */
    public function getAvailableCourses($courses_category = null, $courses_type = null, $first_id = null, $last_id = null,
                                        $promocode_data = null, $coach_courses = null)
    {
        $result['courses'] = array();

        $and_crs_id = '';
        $limit      = 9;
        //echo $promocode_data['pc_type'].'<br/>';

        $categories = self::getAvailableCourseTypes();
        $result['courses_categories'] = $categories['course_types'];

        if(empty($promocode_data) or $promocode_data['pc_type'] == 'all' or $promocode_data['pc_type'] == 'workouts' or $promocode_data['pc_type'] == 'nutritions')
        {
            if(empty($courses_category) or $courses_category == 'workouts' or
                (!empty($promocode_data) and ($promocode_data['pc_type'] == 'all' or $promocode_data['pc_type'] == 'workouts')) or
                ($courses_category == 'workouts' and is_numeric($courses_type)))
            {
                if(is_array($coach_courses))
                {
                    $and_crs_id = ' and `crs_id` IN ('. implode(",", $coach_courses  ) .')';
                }

                if($courses_category == 'workouts' and is_numeric($courses_type))
                {
                    $category = self::getAvailableCourseType($courses_type);
                    $result['courses_categories'] = $category['course_type'];

                    $and_where = '';
                    // Если нажата "Следующая страница"
                    if (!empty($last_id))
                    {
                        $and_where = ' and `crs_id`<'.$last_id;
                    }
                    // Если нажата "Предыдущая страница"
                    elseif (!empty($first_id))
                    {
                        $and_where = ' and `crs_id`>'.$first_id;
                    }

                    $sel_courses = $this->db->query('
                        SELECT `crs_id`, `crs_name`, `crs_image`, `crs_description`, `crs_price`, `crs_recurrent_first`, `clp_id`, `clp_activated` 
                        FROM `courses` 
                        LEFT JOIN `courses_landing_pages` ON `clp_course_id`=`crs_id`
                        WHERE `crs_blocked`=0 and `crs_archive`=0 and `crs_type_id`=? and `crs_category`="workout"'.$and_where.' '.$and_crs_id.'
                        ORDER BY `crs_id` DESC
                        LIMIT ?', array($courses_type, $limit));

                    if ($sel_courses !== false and 0 < $sel_courses->num_rows())
                    {
                        $elements = $sel_courses->result();

                        // Данные пагинации
                        $pagination = parent::parsePagination('course', $first_id, $last_id, $limit, $elements);
                        $result['pagination'] = $pagination['pagination'];

                        $elements = $pagination['elements'];
                        $i = 0;
                        foreach ($elements as $key => $row)
                        {
                            $result['courses']['workouts'][$courses_type][$i] = self::parseCourseData($row);

                            // Тренеры курса
                            $coaches = self::getCourseCoaches($row->crs_id);
                            $result['courses']['workouts'][$courses_type][$i] = array_merge($result['courses']['workouts'][$courses_type][$i], $coaches);

                            $i++;
                        }
                        unset($row);
                    }
                    elseif ($sel_courses === false)
                    {
                        parent::logDbMessages(__METHOD__.':'.__LINE__);
                    }
                }
                elseif(!empty($categories))
                {
                    foreach($categories['course_types'] as $category)
                    {
                        $sel_courses = $this->db->query('
                        SELECT `crs_id`, `crs_name`, `crs_image`, `crs_description`, `crs_price`, `crs_recurrent_first`, `clp_id`, `clp_activated` 
                        FROM `courses` 
                        LEFT JOIN `courses_landing_pages` ON `clp_course_id`=`crs_id`
                        WHERE `crs_blocked`=0 and `crs_archive`=0 and `crs_type_id`=? and `crs_category`="workout" '.$and_crs_id.' 
                        LIMIT ?', array($category['id'], $limit));

                        if ($sel_courses !== false and 0 < $sel_courses->num_rows())
                        {
                            $i = 0;
                            foreach ($sel_courses->result() as $row)
                            {
                                $result['courses']['workouts'][$category['id']][$i] = self::parseCourseData($row);

                                // Тренеры курса
                                $coaches = self::getCourseCoaches($row->crs_id);
                                $result['courses']['workouts'][$category['id']][$i] = array_merge($result['courses']['workouts'][$category['id']][$i], $coaches);

                                $i++;
                            }
                            unset($row);
                        }
                        elseif ($sel_courses === false)
                        {
                            parent::logDbMessages(__METHOD__.':'.__LINE__);
                        }
                    }
                    unset($category);
                }
            }

            if(empty($courses_category) or $courses_category == 'nutritions' or
                (!empty($promocode_data) and ($promocode_data['pc_type'] == 'all' or $promocode_data['pc_type'] == 'nutritions')))
            {
                if(is_array($coach_courses))
                {
                    $and_crs_id = ' and `crs_id` IN ('. implode(",", $coach_courses  ) .')';
                }

                $sel_courses = $this->db->query('
                    SELECT `crs_id`, `crs_name`, `crs_image`, `crs_description`, `crs_price`, `crs_recurrent_first`, `clp_id`, `clp_activated` 
                    FROM `courses` 
                    LEFT JOIN `courses_landing_pages` ON `clp_course_id`=`crs_id`
                    WHERE `crs_blocked`=0 and `crs_archive`=0 and `crs_category`="nutrition" '.$and_crs_id.' LIMIT ?', $limit);

                if ($sel_courses !== false and 0 < $sel_courses->num_rows())
                {
                    $i = 0;
                    foreach ($sel_courses->result() as $row)
                    {
                        $result['courses']['nutritions'][$i] = self::parseCourseData($row);

                        // Тренеры курса
                        $coaches = self::getCourseCoaches($row->crs_id);
                        $result['courses']['nutritions'][$i] = array_merge($result['courses']['nutritions'][$i], $coaches);

                        $i++;
                    }
                    unset($row);
                }
                elseif ($sel_courses === false)
                {
                    parent::logDbMessages(__METHOD__.':'.__LINE__);
                }
            }

        }
        elseif(!empty($promocode_data) and ($promocode_data['pc_type'] == 'course' or $promocode_data['pc_type'] == 'courses' or $promocode_data['pc_type'] == 'categories'))
        {
            if($promocode_data['pc_type'] == 'categories' and is_array($promocode_data['crs_cats']))
            {
                foreach($promocode_data['crs_cats'] as $category)
                {
                    $sel_courses = $this->db->query('
                        SELECT `crs_id`, `crs_name`, `crs_image`, `crs_description`, `crs_price`, `crs_recurrent_first`, `clp_id`, `clp_activated` 
                        FROM `courses` 
                        LEFT JOIN `courses_landing_pages` ON `clp_course_id`=`crs_id`
                        WHERE `crs_blocked`=0 and `crs_archive`=0 and `crs_type_id`=? and `crs_category`="workout" 
                        LIMIT ?', array($category, $limit));

                    if ($sel_courses !== false and 0 < $sel_courses->num_rows())
                    {
                        $i = 0;
                        foreach ($sel_courses->result() as $row)
                        {
                            $result['courses']['workouts'][$category][$i] = self::parseCourseData($row);

                            // Тренеры курса
                            $coaches = self::getCourseCoaches($row->crs_id);
                            $result['courses']['workouts'][$category][$i] = array_merge($result['courses']['workouts'][$category][$i], $coaches);

                            $i++;
                        }
                        unset($row);
                    }
                    elseif ($sel_courses === false)
                    {
                        parent::logDbMessages(__METHOD__.':'.__LINE__);
                    }
                }
                unset($category);
            }
            elseif($promocode_data['pc_type'] == 'courses' or $promocode_data['pc_type'] == 'course')
            {
                $sel_courses = $this->db->query('
                    SELECT `pcc_crs_id`, `crs_id`, `crs_type_id`, `crs_name`, `crs_image`, `crs_description`, `crs_price`, `crs_recurrent_first`, `crs_blocked`, 
                           `crs_archive`, `clp_id`, `clp_activated` 
                    FROM `promocode_courses`
                    LEFT JOIN `courses` ON `crs_id`=`pcc_crs_id`
                    LEFT JOIN `courses_landing_pages` ON `clp_course_id`=`crs_id`
                    WHERE `pcc_pc_id`=? and `crs_blocked`=0 and `crs_archive`=0', $promocode_data['id']);

                if($promocode_data['pc_type'] == 'course')
                {
                    $this->db->limit(1);
                }

                if ($sel_courses !== false and 0 < $sel_courses->num_rows())
                {
                    $i = 0;
                    foreach ($sel_courses->result() as $row)
                    {
                        $result['courses']['workouts'][$row->crs_type_id][$i] = self::parseCourseData($row);

                        // Тренеры курса
                        $coaches = self::getCourseCoaches($row->crs_id);
                        $result['courses']['workouts'][$row->crs_type_id][$i] = array_merge($result['courses']['workouts'][$row->crs_type_id][$i], $coaches);

                        $i++;
                    }
                    unset($row);
                }
                elseif ($sel_courses === false)
                {
                    parent::logDbMessages(__METHOD__.':'.__LINE__);
                }

            }
        }

        return $result;
    }

    /**
     * Выборка списка тренеров, к которым прикреплен хотя бы один курс
     *
     * @return mixed
     */
    public function getAvailableCoursesCoaches()
    {
        $result['coaches'] = array();

        $sel_data = $this->db->query('
            SELECT `cc_coach_id`, `user_name`, `user_email`, `user_id`, `user_image`, `cd_specialization`, `cd_titles_awards`, `cd_about` 
            FROM `courses_coaches` 
            LEFT JOIN `users` ON `user_id`=`cc_coach_id`
            LEFT JOIN `coach_data` ON `cd_u_id`=`cc_coach_id`
            GROUP BY `cc_coach_id`');

        if ($sel_data !== false and 0 < $sel_data->num_rows())
        {
            $i = 0;
            foreach ($sel_data->result() as $row)
            {
                $result['coaches'][$i]['id']      = $row->user_id;

                $user_name = explode(' ', $row->user_name);
                $result['coaches'][$i]['f_name']  = !empty($row->user_name) ? $row->user_name : $row->user_email;
                $result['coaches'][$i]['name']    = $user_name[0];
                $result['coaches'][$i]['surname'] = !empty($user_name[1]) ? $user_name[1] : '';

                $result['coaches'][$i]['image']         = is_file($row->user_image) ? mb_substr($row->user_image, 1) : '';
                $result['coaches'][$i]['special']       = $row->cd_specialization;
                $result['coaches'][$i]['titles_awards'] = $row->cd_titles_awards;
                $result['coaches'][$i]['bbc_about']     = !empty($row->cd_about) ? parent::showBBcodes($row->cd_about) : '';
                $result['coaches'][$i]['about']         = $row->cd_about;

                $i++;
            }
        }
        elseif($sel_data === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Выборка курсов тренера
     *
     * @param $coach_id
     * @param $courses_category
     * @param $courses_type
     * @return array
     */
    public function getAvailableCoachCourses($coach_id, $courses_category = null, $courses_type = null)
    {
        $result = array('coach' => array(), 'courses' => array());

        $sel_coach = $this->db->query('
            SELECT `cc_coach_id`, `cc_course_id`, `user_name`, `user_id` 
            FROM `courses_coaches` 
            LEFT JOIN `users` ON `user_id`=`cc_coach_id`
            WHERE `cc_coach_id`=?', $coach_id);

        if($sel_coach !== false and 0 < $sel_coach->num_rows())
        {
            $i = 0;
            $coach_courses = null;

            foreach($sel_coach->result() as $row)
            {
                $result['coach']['id']   = $row->user_id;
                $result['coach']['name'] = (!empty($row->user_name)) ? $row->user_name : 'Тренер №'.$row->user_id;

                $coach_courses[$i] = $row->cc_course_id;

                $i++;
            }
            unset($row);

            $courses = self::getAvailableCourses($courses_category, $courses_type, null, null, null, $coach_courses);
            $result['courses'] = $courses['courses'];
            $result['courses_categories'] = $courses['courses_categories'];
        }

        return $result;
    }

    /**
     * Выборка доступных (не заблокированных) для пользователей курсов
     *
     * @param $courses_category
     * @return array
     */
    public function getLastAddedCourses($courses_category = null)
    {
        $result['courses'] = array();

        if($courses_category == 'workout' or $courses_category == 'nutrition')
        {
            $sel_courses = $this->db->query('
                SELECT `crs_id`, `crs_name`, `crs_image`, `crs_description`, `clp_id`, `clp_activated` 
                FROM `courses` 
                LEFT JOIN `courses_landing_pages` ON `clp_course_id`=`crs_id`
                WHERE `crs_blocked`=0 AND `crs_archive`=0 AND `crs_category`=? 
                ORDER BY `crs_id` DESC
                LIMIT 12', $courses_category);

            if ($sel_courses !== false and 0 < $sel_courses->num_rows())
            {
                $i = 0;
                foreach ($sel_courses->result() as $row)
                {
                    $result['courses'][$i] = self::parseCourseData($row);

                    // Тренеры курса
                    $coaches = self::getCourseCoaches($row->crs_id);
                    $result['courses'][$i] = array_merge($result['courses'][$i], $coaches);

                    $i++;
                }
                unset($row);
            }
            elseif ($sel_courses === false)
            {
                parent::logDbMessages(__METHOD__ . ':' . __LINE__);
            }
        }

        return $result;
    }

    /**
     * Выборка данных курса, доступного для пользователей курсов
     *
     * @param $course_id
     * @param $date
     * @return array
     */
    public function getAvailableCourse($course_id, $date = "")
    {
        $result['course'] = NULL;

        $sel_course = $this->db->query('
            SELECT `crs_id`, `crs_category`, `crs_image`, `crs_name`, `crs_description`, `crs_type_id`, `crs_count_weeks`, 
              `crs_count_days`, `crs_meta_description`, `crs_meta_keywords`, `crs_price`, `crs_recurrent_price`, 
              `crs_recurrent_months`, `crs_recurrent_first`, `crs_recurrent_subsequent`, 
              `crs_fitcoin_price`, `crs_count_rest`, `crs_blocked`, `clp_id`, `clp_activated`, `p_id`
            FROM `courses`
            LEFT JOIN `products` ON `p_course_id`=`crs_id`
            LEFT JOIN `courses_landing_pages` ON `clp_course_id`=`crs_id`
            WHERE `crs_id`=? and `crs_blocked`=0 and `crs_archive`=0 LIMIT 1', $course_id);

        if ($sel_course !== false and 1 == $sel_course->num_rows())
        {
            $row = $sel_course->row();

            $result['course'] = self::parseCourseData($row);

            // Скидка на курс от тренеров
            $discount = 0;

            $sel_course->free_result();

            if($row->crs_category == 'workout')
            {
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
                    parent::logDbMessages(__METHOD__.':'.__LINE__);
                }
                $sel_schedule->free_result();

                // Тренеры курса
                $sel_coaches = $this->db->query('
                    SELECT `cc_coach_id`, `cc_percent`, `cc_discount`, `user_name`, `user_email`
                    FROM `courses_coaches`
                    LEFT JOIN `users` ON `cc_coach_id`=`users`.`user_id`
                    WHERE `cc_course_id`=?', $course_id);

                if ($sel_coaches !== false and 0 < $sel_coaches->num_rows())
                {
                    $i = 0;
                    foreach ($sel_coaches->result() as $row)
                    {

                        $result['course']['coaches'][$i]['id']       = $row->cc_coach_id;
                        $result['course']['coaches'][$i]['name']     = !empty(($row->user_name)) ? $row->user_name : $row->user_email;
                        $result['course']['coaches'][$i]['percent']  = $row->cc_percent;
                        $result['course']['coaches'][$i]['discount'] = $row->cc_discount;

                        $discount += $row->cc_discount;

                        $i++;
                    }
                    unset($row);
                }
                elseif ($sel_coaches === false)
                {
                    parent::logDbMessages(__METHOD__.':'.__LINE__);
                }
                $sel_coaches->free_result();

            }

            // Вычисление новой цены на курс
            /*if ($discount > 0) {
                if (!empty($result['course']['price'])) {
                    $percent = $result['course']['price'] * $discount / 100;
                    $result['course']['new_price'] = number_format(($result['course']['price'] - $percent), 2, '.', '');
                }
                if (!empty($result['course']['fc_price'])) {
                    $percent = $result['course']['fc_price'] * $discount / 100;
                    $result['course']['new_fc_price'] = number_format(($result['course']['fc_price'] - $percent), 3, '.', '');
                }
            }*/

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
                parent::logDbMessages(__METHOD__.':'.__LINE__);
            }
            $sel_users->free_result();
            $result['course']['bought'] = $bought;

            // Наличие промокода курса
            $availability = false;
            // Поиск курса и промокода среди основных
            $sel_promo = self::getCoursePromocodes($course_id, $date);
            if(!empty($sel_promo))
            {
                foreach($sel_promo['promocodes'] as $promo)
                {
                    if($promo['active'] === true)
                    {
                        $availability = true;
                    }
                }
                unset($promo);
            }
            unset($sel_promo);
            // Проверяем наличие курса и активных промокодов среди курсов продления
            if($availability === false)
            {
                $sel_promo = self::getExtendCoursePromocodes($course_id, $date);
                if(!empty($sel_promo))
                {
                    foreach($sel_promo['promocodes'] as $promo)
                    {
                        if($promo['active'] === true)
                        {
                            $availability = true;
                        }
                    }
                    unset($promo);
                }
                unset($sel_promo);
            }
            $result['course']['promocode_availability'] = $availability;
        }
        elseif ($sel_course === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
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

        /*$del_data = $this->db->query('DELETE FROM `courses_training_weeks` WHERE `ctw_id`>=5677 and `ctw_id`<=6092');
        $del_data = $this->db->query('DELETE FROM `courses_training_weeks` WHERE `ctw_id`>=5469 and `ctw_id`<=5676');
        $del_data = $this->db->query('DELETE FROM `courses_training_weeks` WHERE `ctw_id`>=5310 and `ctw_id`<=5466');
        $del_data = $this->db->query('DELETE FROM `courses_training_weeks` WHERE `ctw_id`>=4059 and `ctw_id`<=4994');
        $del_data = $this->db->query('DELETE FROM `courses_training_weeks` WHERE `ctw_id`>=3747 and `ctw_id`<=3902');
        $del_data = $this->db->query('DELETE FROM `courses_training_weeks` WHERE `ctw_id`>=3275 and `ctw_id`<=3379');*/

        $sel_course = $this->db->query('
            SELECT `crs_id`, `crs_category`, `crs_image`, `crs_name`, `crs_description`, `crs_type_id`, `crs_count_weeks`,
              `crs_meta_keywords`, `crs_meta_description`, `crs_count_days`, `crs_price`, `crs_fitcoin_price`, 
              `crs_recurrent_price`, `crs_recurrent_months`, `crs_recurrent_first`, `crs_recurrent_subsequent`, 
              `crs_count_rest`, `crs_blocked`, `crs_archive`, `clp_id`, `clp_activated`
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
            if($row->crs_category == 'workout')
            {
                // Инструктаж
                $sel_instr = $this->db->query('
                    SELECT `video_id`, `video_name`, `video_path`, `video_poster`, `video_remove_url`
                    FROM `video`
                    WHERE `video_crs_id`=? and `video_type`=3 and `video_active`=1 LIMIT 1', $course_id);
                if ($sel_instr !== false and 1 == $sel_instr->num_rows())
                {
                    $row = $sel_instr->row();

                    $result['course']['instruction']['video_id']     = $row->video_id;
                    $result['course']['instruction']['video_name']   = $row->video_name;
                    $result['course']['instruction']['video_poster'] = is_file($row->video_poster) ? mb_substr($row->video_poster, 1) : '';
                    $result['course']['instruction']['video_path']   = is_file($row->video_path) ? mb_substr($row->video_path, 1) : '';
                    $result['course']['instruction']['video_remove'] = $row->video_remove_url;
                }
                elseif ($sel_instr === false)
                {
                    parent::logDbMessages(__METHOD__.':'.__LINE__);
                }
                $sel_instr->free_result();

                $schedule = self::getCourseSchedules($course_id);
                $result['course']['workouts']      = $schedule['workouts'];
                $result['course']['workouts_id']   = $schedule['workouts_id'];
                $result['course']['course_length'] = $schedule['course_length'];
            }
            /*elseif($row->crs_category == 'nutrition')
            {

            }*/

            // Тренеры курса
            $sel_coaches = $this->db->query('
                SELECT `cc_coach_id`, `cc_percent`, `cc_discount`, `user_name`, `user_email`
                FROM `courses_coaches`
                LEFT JOIN `users` ON `cc_coach_id`=`users`.`user_id`
                WHERE `cc_course_id`=?', $course_id);
            if ($sel_coaches !== false and 0 < $sel_coaches->num_rows())
            {
                $i = 0;
                foreach ($sel_coaches->result() as $row)
                {

                    $result['course']['coaches'][$i]['id']       = $row->cc_coach_id;
                    $result['course']['coaches'][$i]['name']     = !empty(($row->user_name)) ? $row->user_name : $row->user_email;
                    $result['course']['coaches'][$i]['percent']  = $row->cc_percent;
                    $result['course']['coaches'][$i]['discount'] = $row->cc_discount;

                    $discount += $row->cc_discount;

                    $i++;
                }
                unset($row);
            }
            elseif ($sel_coaches === false)
            {
                parent::logDbMessages(__METHOD__.':'.__LINE__);
            }
            $sel_coaches->free_result();

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
                parent::logDbMessages(__METHOD__.':'.__LINE__);
            }
            $sel_users->free_result();
            $result['course']['bought'] = $bought;
        }
        elseif ($sel_course === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
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
            SELECT `crs_id`, `crs_image`, `crs_name`, `crs_description`, `crs_price`, `clp_activated`
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
            $sel_coaches = $this->db->query('
                SELECT `cc_coach_id`, `cc_percent`, `cc_discount`, `user_name`, `user_email`
                FROM `courses_coaches`
                LEFT JOIN `users` ON `cc_coach_id`=`users`.`user_id`
                WHERE `cc_course_id`=?', $course_id);
            if ($sel_coaches !== false and 0 < $sel_coaches->num_rows())
            {
                $i = 0;
                foreach ($sel_coaches->result() as $row)
                {
                    $discount += $row->cc_discount;

                    $i++;
                }
                unset($row);
            }
            elseif ($sel_coaches === false)
            {
                parent::logDbMessages(__METHOD__.':'.__LINE__);
            }
            $sel_coaches->free_result();

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
            parent::logDbMessages(__METHOD__.':'.__LINE__);
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
                parent::logDbMessages(__METHOD__.':'.__LINE__);
            }

        }
        elseif ($sel_pid === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Сохранение нового курса
     *
     * @param string $course_category Категория курса (тренировки, питание)
     * @param string $name Наименование курса
     * @param string $description Описание курса
     * @param string $meta_description Metadata
     * @param string $meta_keywords Metadata
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
    public function setNewCourse($course_category, $name, $description, $meta_description, $meta_keywords, $price,
                                 $fc_price, $course_type, $count_weeks, $count_days, $count_rest, $user_id, $date)
    {
        $up_data = $this->db->query('
            INSERT INTO `courses` (`crs_category`, `crs_type_id`, `crs_name`, `crs_description`, `crs_meta_description`, 
                                   `crs_meta_keywords`, `crs_price`, `crs_fitcoin_price`, `crs_count_weeks`, 
                                   `crs_count_days`, `crs_count_rest`, `crs_admin_add`, `crs_date_add`, `crs_date_update`) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)',
                array($course_category, $course_type, $name, $description, $meta_description, $meta_keywords, $price,
                    $fc_price, $count_weeks, $count_days, $count_rest, $user_id, $date, $date));

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
                $category_id = ($course_category == 'workout') ? 1 : 2;

                // Категория товара
                $in_data2 = $this->db->query('
                    INSERT INTO `products_categories` (`pc_p_id`, `pc_cat_id`, `pc_date_update`, `pc_admin_id`)
                    VALUES (?, ?, ?, ?)', array($p_id, $category_id, $date, $user_id));
                if ($in_data2 === false)
                {
                    parent::logDbMessages(__METHOD__.':'.__LINE__);
                }
            }
            if ($up_data2 === false)
            {
                parent::logDbMessages(__METHOD__.':'.__LINE__);
            }

            // Создание Landing page курса
            $up_data3 = $this->db->query('INSERT INTO `courses_landing_pages`
              (`clp_course_id`, `clp_lp_id`, `clp_admin_id`, `clp_date_add`, `clp_date_update`) 
              VALUES (?, ?, ?, ?, ?)', array($course_id, 1, $user_id, $date, $date));

            if ($up_data3 === false)
            {
                parent::logDbMessages(__METHOD__.':'.__LINE__);
            }

            return $course_id;
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
            parent::logDbMessages(__METHOD__.':'.__LINE__);
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
     * @param string $image
     * @param string $name
     * @param string $description
     * @param string $meta_description
     * @param string $meta_keywords
     * @param float $price
     * @param float $fc_price
     * @param int $course_type
     * @param int $count_weeks
     * @param int $count_days
     * @param int $count_rest
     * @param datetime $date
     * @return bool
     */
    public function setCourseSettings($course_id, $image, $name, $description, $meta_description, $meta_keywords,
                                      $price, $fc_price, $course_type, $count_weeks, $count_days, $count_rest, $date)
    {
        $result = false;

        $up_data = $this->db->query('
          UPDATE `courses` 
          SET `crs_type_id`=?, `crs_image`=?, `crs_name`=?, `crs_description`=?, `crs_meta_description`=?, `crs_meta_keywords`=?, 
            `crs_price`=?, `crs_fitcoin_price`=?, `crs_count_weeks`=?, `crs_count_days`=?, `crs_count_rest`=?, `crs_date_update`=? 
          WHERE `crs_id`=? LIMIT 1',
            array($course_type, $image, $name, $description, $meta_description, $meta_keywords, $price, $fc_price,
                $count_weeks, $count_days, $count_rest, $date, $course_id));
        
        if ($up_data !== false and 1 == $this->db->affected_rows())
        {
            /*$up_data2 = $this->db->query('
                UPDATE `products` SET `p_name`=?, `p_full_description`=?, `p_price`=?, `p_fitcoin_price`=?, `p_date_update`=?
                WHERE `p_course_id`=? LIMIT 1', array($name, $description, $price, $fc_price, $date, $course_id));
            if ($up_data2 === false)
            {
                parent::logDbMessages(__METHOD__.':'.__LINE__);
            }*/

            $result = true;
        }
        elseif ($up_data === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
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
            parent::logDbMessages(__METHOD__.':'.__LINE__);
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
        $result = false;

        $up_data = $this->db->query('UPDATE `courses` SET `crs_blocked`=0, `crs_date_update`=? WHERE `crs_id`=? LIMIT 1',
            array($date, $course_id));

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
     * Сохранение данных рекуррентной цены курса
     *
     * @param int $course_id
     * @param float $recur_price
     * @param int $recur_months
     * @param float $recur_first
     * @param float $recur_subsequent
     * @param int $admin_id
     * @param string $date
     * @return bool
     */
    public function setCourseRecurrentPrice($course_id, $recur_price, $recur_months, $recur_first, $recur_subsequent, $admin_id, $date)
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
            parent::logDbMessages(__METHOD__.':'.__LINE__);
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
                        parent::logDbMessages(__METHOD__.':'.__LINE__);
                    }
                }
            }
            unset($course);
        }

        return $result;
    }

    /**
     * Категория курса (workout, nutrition)
     *
     * @param $course_id
     * @return null|string
     */
    public function getCourseCategory($course_id)
    {
        $result = null;

        $sel_course = $this->db->query('SELECT `crs_category` FROM `courses` WHERE `crs_id`=? LIMIT 1', $course_id);

        if($sel_course !== false and 1 == $sel_course->num_rows())
        {
            $row = $sel_course->row();

            $result = $row->crs_category;
        }
        elseif($sel_course === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Перенос курса в архив
     *
     * @param $course_id
     * @param $archive
     * @param $admin_id
     * @param $date
     * @return bool
     */
    public function archiveCourse($course_id, $archive = 1, $admin_id, $date)
    {
        $up_data = $this->db->query('
            UPDATE `courses` SET `crs_archive`=?, `crs_date_update`=? WHERE `crs_id`=? LIMIT 1',
                array($archive, $date, $course_id));

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
                $result['video_id'][$num_workout]       = $row->ctw_video_id;
            }
            unset($row);
        }
        elseif ($sel_schedule === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Выборка длительности курса
     *
     * @param $course_id
     * @return bool|array
     */
    public function getCourseLength($course_id)
    {
        $result = false;

        if(is_numeric($course_id))
        {
            $sel_data = $this->db->query('SELECT `crs_count_weeks`, `crs_count_days` FROM `courses` WHERE `crs_id`=? LIMIT 1', $course_id);

            if($sel_data !== false and 1 == $sel_data->num_rows())
            {
                $row = $sel_data->row();

                $result['count_weeks'] = $row->crs_count_weeks;
                $result['count_days']  = $row->crs_count_days;
            }
            elseif($sel_data === false)
            {
                parent::logDbMessages(__METHOD__.':'.__LINE__);
            }
        }

        return $result;
    }

    /**
     * Выборка тренировок курсов
     *
     * @param $course_id
     * @return array
     */
    public function getCourseSchedules($course_id)
    {
        $result = array('course_length' => array(), 'workouts' => array(), 'workouts_id' => array());

        $sel_schedule = $this->db->query('
            SELECT `ctw_num_workout`, `ctw_description`, `ctw_video_id`, `ctw_repeat_workout`, 
              `video_id`, `video_name`, `video_path`, `video_poster`, `video_remove_url`
            FROM `courses_training_weeks`
            LEFT JOIN `video` ON `video_id`=`ctw_video_id`
            WHERE `ctw_course_id`=? and `ctw_num_workout`>0
            ORDER BY `ctw_num_workout`', $course_id);
        if ($sel_schedule !== false and 0 < $sel_schedule->num_rows())
        {
            // Длительность курса
            $result['course_length'] = self::getCourseLength($course_id);

            foreach ($sel_schedule->result() as $row)
            {
                $num_workout = $row->ctw_num_workout;

                $result['workouts'][$num_workout]['repeat_workout'] = $row->ctw_repeat_workout;
                $result['workouts'][$num_workout]['description']    = $row->ctw_description;

                if ($row->ctw_repeat_workout > 0)
                {
                    $video_id       = $result['workouts'][$row->ctw_repeat_workout]['video_id'];
                    $video_name     = $result['workouts'][$row->ctw_repeat_workout]['video_name'];
                    $video_poster   = $result['workouts'][$row->ctw_repeat_workout]['video_poster'];
                    $video_path     = $result['workouts'][$row->ctw_repeat_workout]['video_path'];
                    $video_remove   = $result['workouts'][$row->ctw_repeat_workout]['video_remove'];
                }
                else
                {
                    $video_id       = $row->ctw_video_id;
                    $video_name     = $row->video_name;
                    $video_poster   = is_file($row->video_poster) ? mb_substr($row->video_poster, 1) : '';
                    $video_path     = is_file($row->video_path) ? mb_substr($row->video_path, 1) : '';
                    $video_remove   = $row->video_remove_url;
                }

                $result['workouts'][$num_workout]['video_id']       = (!empty($video_id)) ? $video_id : '';
                $result['workouts'][$num_workout]['video_name']     = $video_name;
                $result['workouts'][$num_workout]['video_poster']   = $video_poster;
                $result['workouts'][$num_workout]['video_path']     = $video_path;
                $result['workouts'][$num_workout]['video_remove']   = $video_remove;

                $result['workouts_id'][$num_workout] = $result['workouts'][$num_workout]['video_id'];
            }
            unset($row);
        }
        elseif ($sel_schedule === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
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
            foreach ($schedule['insert'] as $num_workout => $workout)
            {
                $sel_data = $this->db->query('SELECT `ctw_id` FROM `courses_training_weeks` WHERE `ctw_course_id`=? and `ctw_num_workout`=? LIMIT 1', array($course_id, $num_workout));
                if($sel_data !== false and 0 == $sel_data->num_rows())
                {
                    if (!empty($values)) {
                        $values .= ', ';
                    }

                    $values .= '(' . $course_id .', ' . $num_workout . ', "' . $workout['description'] . '", '
                        . $workout['video_id'] . ', ' . $workout['repeat_workout'] . ', "' . $user_id . '", "'
                        . $date . '", "' . $date . '")';
                }
                elseif($sel_data === false)
                {
                    parent::logDbMessages(__METHOD__.':'.__LINE__);
                }
            }
            unset($workout);

            if(!empty($values))
            {
                $up_data = $this->db->query('
                INSERT INTO `courses_training_weeks` 
                  (`ctw_course_id`, `ctw_num_workout`, `ctw_description`, `ctw_video_id`, `ctw_repeat_workout`, 
                  `ctw_admin_add`, `ctw_date_add`, `ctw_date_update`) 
                VALUES ' . $values);
                if ($up_data === false)
                {
                    parent::logDbMessages(__METHOD__.':'.__LINE__);
                }
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
                    parent::logDbMessages(__METHOD__.':'.__LINE__);
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
                parent::logDbMessages(__METHOD__.':'.__LINE__);
            }
        }

        return $result;
    }

    /**
     * Изменение id видео тренировки курса
     *
     * @param $course_id
     * @param $selected_trainings
     * @param $video_id
     * @param $date
     * @return bool
     */
    public function attachVideoToWorkouts($course_id, $selected_trainings, $video_id, $date)
    {
        $result = false;

        if(!empty($selected_trainings['update']))
        {
            $where_in = '';
            $i = 0;
            foreach($selected_trainings['update'] as $tr_id)
            {
                $where_in .= ($i == 0) ? $tr_id : ', ' . $tr_id;
                $i++;
            }
            unset($tr_id);

            $up_data = $this->db->query('
                UPDATE `courses_training_weeks` SET `ctw_video_id`=?, `ctw_date_update`=? 
                WHERE `ctw_course_id`=? and `ctw_num_workout` IN (' . $where_in . ')',
                    array($video_id, $date, $course_id));

            if($up_data !== false and 0 < $this->db->affected_rows())
            {
                $result = true;
            }
            elseif($up_data === false)
            {
                parent::logDbMessages(__METHOD__.':'.__LINE__);
            }
        }

        if($selected_trainings['delete'])
        {
            $where_in = '';
            $i = 0;
            foreach($selected_trainings['delete'] as $tr_id => $std)
            {
                $where_in .= ($i == 0) ? $tr_id : ', ' . $tr_id;
                $i++;
            }
            unset($std);

            $up_data = $this->db->query('
                UPDATE `courses_training_weeks` SET `ctw_video_id`=0, `ctw_date_update`=? 
                WHERE `ctw_course_id`=? and `ctw_num_workout` IN (' . $where_in . ')',
                    array($date, $course_id));

            if($up_data !== false and 0 < $this->db->affected_rows())
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

    /* КОНЕЦ БЛОКА ОБРАБОТКИ ДАННЫХ ТРЕНИРОВОК КУРСА */


    /* НАЧАЛО БЛОКА ОБРАБОТКИ ДАННЫХ РАСПИСАНИЯ КУРСА ПИТАНИЯ */

    /**
     * Добавление/обновление/удаление данных расписания курса питания
     *
     * @param $course_id
     * @param $schedule
     * @param $admin_id
     * @param $date
     * @return bool
     */
    public function setNutritionSchedule($course_id, $schedule, $admin_id, $date)
    {
        $result = true;

        // Добавление новых данных
        if (!empty($schedule['insert']))
        {
            $values = '';
            // Цикл дней
            foreach ($schedule['insert'] as $num_day => $day)
            {
                // Цикл приемов пищи
                foreach($day as $num_ing => $ingestion)
                {
                    // Цикл блюд
                    foreach($ingestion as $meal)
                    {
                        if (!empty($values))
                        {
                            $values .= ', ';
                        }

                        $values .= '(' . $course_id .', ' . $num_day . ', ' . $num_ing . ', ' . $meal . ', '
                            . $admin_id . ', "' . $date . '")';
                    }
                    unset($meal);
                }
                unset($ingestion);
            }
            unset($day);

            $ins_data = $this->db->query('
                INSERT INTO `courses_days_schedule`(`cds_crs_id`, `cds_day`, `cds_ci_id`, `cds_ml_id`, `cds_admin_id`, `cds_update`) 
                VALUES ' . $values);

            if ($ins_data === false)
            {
                parent::logDbMessages(__METHOD__.':'.__LINE__);
            }
        }

        // Удаление данных
        if (!empty($schedule['delete']))
        {
            // Цикл дней
            foreach ($schedule['delete'] as $num_day => $day)
            {
                // Цикл приемов пищи
                foreach($day as $num_ing => $ingestion)
                {
                    // Цикл блюд
                    foreach ($ingestion as $meal)
                    {
                        $up_data = $this->db->query('
                            DELETE FROM `courses_days_schedule` 
                            WHERE `cds_crs_id`=? AND `cds_day`=? AND `cds_ci_id`=? and `cds_ml_id`=? LIMIT 1',
                                array($course_id, $num_day, $num_ing, $meal));

                        if ($up_data === false) {
                            parent::logDbMessages(__METHOD__.':'.__LINE__);
                        }
                    }
                    unset($meal);
                }
                unset($ingestion);
            }
            unset($day);
        }

        return $result;
    }

    /**
     * Выборка расписания курса питания
     *
     * @param $course_id
     * @return array
     */
    public function getNutritionSchedule($course_id)
    {
        $result = array('course_schedule' => array(), 'schedule_days' => array());

        $sel_data = $this->db->query('
            SELECT `cds_id`, `cds_day`, `cds_ci_id`, `cds_ml_id` 
            FROM `courses_days_schedule`
            WHERE `cds_crs_id`=? ORDER BY `cds_day` ASC', $course_id);

        if($sel_data !== false and 0 < $sel_data->num_rows())
        {
            $i = 0;
            foreach($sel_data->result() as $row)
            {
                $sel_meal = (is_numeric($row->cds_ml_id) and $row->cds_ml_id > 0) ? self::getMeal($row->cds_ml_id) : array('meal' => array());
                $meal     = $sel_meal['meal'];

                $result['course_schedule'][$row->cds_day][$row->cds_ci_id][$meal['type_id']][$i] = $meal;
                $result['schedule_days'][$row->cds_day][$row->cds_ci_id][$meal['type_id']][$i]   = $row->cds_ml_id;

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
     * Добавление данных приемов пищи курса питания
     *
     * @param $course_id
     * @param $ingestions
     * @param $time_from
     * @param $time_to
     * @param $admin_id
     * @param $date
     * @return bool
     */
    public function setNutritionIngestions($course_id, $ingestions, $time_from, $time_to, $admin_id, $date)
    {
        $result = true;

        if(is_array($ingestions) and is_numeric($course_id))
        {
            foreach($ingestions as $key => $ingestion)
            {
                $ins_data = $this->db->query('
                    INSERT INTO `courses_ingestions` (`ci_crs_id`, `ci_ing_id`, `ci_ing_time_from`, `ci_ing_time_to`, `ci_admin_id`, `ci_update`) 
                    VALUES (?, ?, ?, ?, ?, ?)', array($course_id, $ingestion, $time_from[$key], $time_to[$key], $admin_id, $date));
                if($ins_data === false)
                {
                    parent::logDbMessages(__METHOD__.':'.__LINE__);
                    $result = false;
                }
            }
            unset($ingestion);
        }

        return $result;
    }

    /**
     * Выборка приемов пищи курса питания
     *
     * @param $course_id
     * @return array
     */
    public function getNutritionIngestions($course_id)
    {
        $result = array('course_ingestions' => array(), 'course_ingestions_id' => array());

        $sel_data = $this->db->query('
            SELECT `ci_ing_id`, `ci_ing_time_from`, `ci_ing_time_to` 
            FROM `courses_ingestions` 
            WHERE `ci_crs_id`=?', $course_id);

        if($sel_data !== false and 0 < $sel_data->num_rows())
        {
            $i = 0;
            foreach($sel_data->result() as $row)
            {
                $result['course_ingestions'][$i]['id']        = $row->ci_ing_id;
                $result['course_ingestions'][$i]['time_from'] = $row->ci_ing_time_from;
                $result['course_ingestions'][$i]['time_to']   = $row->ci_ing_time_to;

                $result['course_ingestions_id'][$i] = $row->ci_ing_id;

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
     * Добавление данных приемов пищи курса питания
     *
     * @param $course_id
     * @param $update_ingestions
     * @param $ingestions
     * @param $time_from
     * @param $time_to
     * @param $admin_id
     * @param $date
     * @return bool
     */
    public function updateNutritionIngestions($course_id, $update_ingestions, $ingestions, $time_from, $time_to, $admin_id, $date)
    {
        $result = true;

        if(!empty($update_ingestions['insert']))
        {
            foreach($update_ingestions['insert'] as $key => $ingestion)
            {
                $ins_data = $this->db->query('
                    INSERT INTO `courses_ingestions` (`ci_crs_id`, `ci_ing_id`, `ci_ing_time_from`, `ci_ing_time_to`, `ci_admin_id`, `ci_update`) 
                    VALUES (?, ?, ?, ?, ?, ?)',
                        array($course_id, $ingestion, $time_from[$key], $time_to[$key], $admin_id, $date));
                if($ins_data === false)
                {
                    parent::logDbMessages(__METHOD__.':'.__LINE__);
                    $result = false;
                }
            }
            unset($ingestion);
        }

        if(!empty($update_ingestions['update']))
        {
            foreach($update_ingestions['update'] as $key => $ingestion)
            {
                $up_data = $this->db->query('
                    UPDATE `courses_ingestions` SET `ci_ing_time_from`=?, `ci_ing_time_to`=?, `ci_admin_id`=?, `ci_update`=? 
                    WHERE `ci_crs_id`=? and `ci_ing_id`=? LIMIT 1',
                        array($time_from[$key], $time_to[$key], $admin_id, $date, $course_id, $ingestion));
                if($up_data === false)
                {
                    parent::logDbMessages(__METHOD__.':'.__LINE__);
                    $result = false;
                }
            }
            unset($ingestion);
        }

        if(!empty($update_ingestions['delete']))
        {
            foreach($update_ingestions['delete'] as $key => $ingestion)
            {
                $this->db->query('DELETE FROM `courses_ingestions` WHERE `ci_crs_id`=? and `ci_ing_id`=? LIMIT 1',
                    array($course_id, $ingestion));
            }
            unset($ingestion);
        }

        return $result;
    }

    /**
     * Выборка заполненного расписания курса питания
     *
     * @param $course_id
     * @return array
     */
    public function getFillNutritionSchedule($course_id)
    {
        $result = array('fill_course_schedule' => array(), 'course_schedule' => array(), 'schedule_days' => array());

        $course_data        = self::getCourse($course_id);
        $course_meals_types = self::getNutritionMealsTypes($course_id);
        $course_ingestions  = self::getNutritionIngestions($course_id);

        $total_days = $course_data['course']['count_weeks'] * $course_data['course']['count_days'];

        // Выборка расписания курса
        $sel_data = $this->db->query('
            SELECT `cds_id`, `cds_day`, `cds_ci_id`, `cds_ml_id`, `ml_mt_id` 
            FROM `courses_days_schedule`
            LEFT JOIN `meals` ON `ml_id`=`cds_ml_id`
            WHERE `cds_crs_id`=? ORDER BY `cds_day` ASC', $course_id);

        if($sel_data !== false and 0 < $sel_data->num_rows())
        {
            $i = 0;
            $meal = array();

            foreach($sel_data->result() as $row)
            {
                if(is_numeric($row->cds_ml_id) and $row->cds_ml_id > 0)
                {
                    $sel_meal = self::getMeal($row->cds_ml_id);
                    $meal     = $sel_meal['meal'];
                }

                $schedule[$row->cds_day][$row->cds_ci_id][$row->ml_mt_id][$i] = $meal;
                $result['schedule_days'][$row->cds_day][$row->cds_ci_id][$row->ml_mt_id][$i] = $row->cds_ml_id;

                $i++;
            }
            unset($row);

            // Заполнение пустых дней заполненными
            if(!empty($schedule))
            {
                $week_meals    = array();
                $day_meals     = array();
                $duplicate_day = false;
                $duplicate_ing = false;
                $rand_list     = array();
                $week          = 1;

                // Цикл по всем дня курса питания
                for($day = 1; $day <= $total_days; $day++)
                {
                    $orig_day = ($week > 1) ? ($day - (7 * ($week - 1))) : $day;

                    // Цикл по приемам пищи дня курса питания
                    foreach($course_ingestions['course_ingestions'] as $ci)
                    {
                        $i = 0;
                        // Заполнение пустых дней предыдущими введенными значениями
                        if(empty($day_meals))
                        {
                            $day_meals = $schedule[$day];
                        }
                        elseif(!empty($schedule[$day][$ci['id']]))
                        {
                            $day_meals[$ci['id']] = $schedule[$day][$ci['id']];
                        }

                        // Заполнение массива расписания на неделю. Её и дублировать в случае отсутствия данных
                        if(empty($week_meals) or (empty($week_meals[$day][$ci['id']]) and $day <= 7))
                        {
                            $week_meals[$day][$ci['id']] = (!empty($schedule[$day][$ci['id']])) ? $schedule[$day][$ci['id']] : $day_meals[$ci['id']];

                            $duplicate_day[$ci['id']] = $orig_day;
                            $duplicate_ing[$ci['id']] = $ci['id'];
                        }
                        elseif(!empty($schedule[$day][$ci['id']]))
                        {
                            $week_meals[$orig_day][$ci['id']] = $schedule[$day][$ci['id']];

                            $duplicate_day[$ci['id']] = $orig_day;
                            $duplicate_ing[$ci['id']] = $ci['id'];
                        }

                        // Цикл по категориям блюд
                        if(!empty($course_meals_types['course_ml_types']))
                        {
                            foreach($course_meals_types['course_ml_types'] as $ml_type)
                            {
                                if(!empty($week_meals[$orig_day][$ci['id']][$ml_type['id']]))
                                {
                                    // Массив блюд для случайного выбора
                                    if(empty($rand_list[$orig_day][$ci['id']][$ml_type['id']]))
                                    {
                                        $rand_list[$orig_day][$ci['id']][$ml_type['id']] = $week_meals[$orig_day][$ci['id']][$ml_type['id']];
                                    }
                                    // Выбор случайного ключа
                                    $rand_key = array_rand($rand_list[$orig_day][$ci['id']][$ml_type['id']]);
                                    //echo 'Rand list: <br/>'; print_r($rand_list[$orig_day][$ci['id']][$ml_type['id']]); echo '<br/>';
                                    // Удаляем сгенированный ключ
                                    unset($rand_list[$orig_day][$ci['id']][$ml_type['id']][$rand_key]);

                                    $result['fill_course_schedule'][$day][$ci['id']][$i]         = $week_meals[$orig_day][$ci['id']][$ml_type['id']][$rand_key];

                                    $i++;
                                }
                            }
                            unset($ml_type);
                        }
                        $result['course_schedule'][$day][$ci['id']]                  = $week_meals[$orig_day][$ci['id']];
                        $result['duplicate_course_schedule'][$day][$ci['id']]['day'] = $duplicate_day[$ci['id']];
                        $result['duplicate_course_schedule'][$day][$ci['id']]['ing'] = $duplicate_ing[$ci['id']];
                    }
                    unset($ci);

                    if($day % 7 == 0)
                    {
                        $week++;
                    }
                }
            }
        }
        elseif($sel_data === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /* КОНЕЦ БЛОКА ОБРАБОТКИ ДАННЫХ РАСПИСАНИЕ КУРСА ПИТАНИЯ */


    /* НАЧАЛО БЛОКА ОБРАБОТКИ ДАННЫХ ТРЕНЕРОВ КУРСА */

    /**
     * Выборка тренеров курса
     *
     * @param $course_id
     * @return array
     */
    public function getCourseCoaches($course_id)
    {
        $result = array('coaches' => array());

        if(is_numeric($course_id))
        {
            $sel_coaches = $this->db->query('
            SELECT `cc_coach_id`, `user_name`, `user_email`, `user_image`, `cd_specialization` 
            FROM `courses_coaches`
            LEFT JOIN `users` ON `cc_coach_id`=`user_id`
            LEFT JOIN `coach_data` ON `cd_u_id`=`user_id`
            WHERE `cc_course_id`=?', $course_id);

            if ($sel_coaches !== false and 0 < $sel_coaches->num_rows())
            {
                $i = 0;
                foreach ($sel_coaches->result() as $row) {
                    $result['coaches'][$i]['id']      = $row->cc_coach_id;
                    $result['coaches'][$i]['name']    = !empty($row->user_name) ? $row->user_name : 'Тренер #'.$row->cc_coach_id;
                    $result['coaches'][$i]['image']   = !empty($row->user_image) ? mb_substr($row->user_image, 1) : '';
                    $result['coaches'][$i]['special'] = $row->cd_specialization;

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
     * Выборка тренеров курса с установленным процентом
     *
     * @param $course_id
     * @return array
     */
    public function getCourseCoachesId($course_id)
    {
        $result = array();
        
        $sel_coaches = $this->db->query('
          SELECT `cc_coach_id`, `cc_percent` 
          FROM `courses_coaches` 
          WHERE `cc_course_id`=?', $course_id);
        
        if ($sel_coaches !== false and 0 < $sel_coaches->num_rows())
        {
            $i = 0;
            foreach ($sel_coaches->result() as $row)
            {
                $result['id'][$i]      = $row->cc_coach_id;
                $result['percent'][$i] = $row->cc_percent;
                
                $i++;
            }
            unset($row);
        }
        elseif ($sel_coaches === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }
        
        return $result;
    }

    /**
     * Обновление данных тренеров курса
     *
     * Добавление, обеовление, удаление тренеров курса
     *
     * @param int $course_id ID курса
     * @param array $coaches Массив тренеров
     * @param $date
     * @return bool
     */
    public function setCourseCoaches($course_id, $coaches, $date)
    {
        // Добавление новых тренеров
        if (!empty($coaches['insert'])) {
            $values = '';
            foreach ($coaches['insert'] as $coach_id => $percent) {
                if (empty($values)) {
                    $values = '(' . $course_id .', ' . $coach_id . ', ' . $percent . ', "' . $date . '", "' . $date . '")';
                } else {
                    $values .= ', (' . $course_id .', ' . $coach_id . ', ' . $percent . ', "' . $date . '", "' . $date . '")';
                }
            }
            unset($coach);

            $up_data = $this->db->query('
                INSERT INTO `courses_coaches` 
                  (`cc_course_id`, `cc_coach_id`, `cc_percent`, `cc_date_add`, `cc_date_update`) 
                VALUES ' . $values);
            if ($up_data === false)
            {
                parent::logDbMessages(__METHOD__.':'.__LINE__);
            }
        }

        // Обновление данных тренеров
        if (!empty($coaches['update'])) {
            foreach ($coaches['update'] as $coach_id => $percent) {
                $up_data = $this->db->query('
                  UPDATE `courses_coaches` 
                  SET `cc_percent`=?, `cc_date_update`=? 
                  WHERE `cc_course_id`=? and `cc_coach_id`=? LIMIT 1',
                    array($percent, $date, $course_id, $coach_id));
                if ($up_data === false)
                {
                    parent::logDbMessages(__METHOD__.':'.__LINE__);
                }
            }
            unset($coach);
        }

        // Удаление тренеров
        if (!empty($coaches['delete'])) {
            $coaches = implode($coaches['delete']);
            $up_data = $this->db->query('
                DELETE FROM `courses_coaches` WHERE `cc_course_id`=? and `cc_coach_id` IN (' . $coaches . ')', $course_id);
            if ($up_data === false)
            {
                parent::logDbMessages(__METHOD__.':'.__LINE__);
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
        $result = array('landing' => array());

        $sel_landing = $this->db->query('
            SELECT `clp_lp_id`, `clp_block1_hide`, `clp_slider_images`, `clp_main_title`, `clp_block1_bg_color`, `clp_slider_opacity`, 
              `clp_block2_hide`, `clp_block2_background`, `clp_block2_background_top`, `clp_block2_image`, `clp_block2_bg_color`, 
              `clp_block2_title`, `clp_block2_subtitle`, `clp_block2_text`, `clp_block2_button`, `clp_block2_bg_opacity`, 
              `clp_block3_hide`, `clp_block3_background`, `clp_block3_title`, `clp_block3_subtitle`, `clp_block3_image_1`,
              `clp_block3_image_2`, `clp_block3_r_title`, `clp_block3_r_subtitle`, `clp_block3_r_reviews`, `clp_block3_bg_color`, 
              `clp_block3_bg_opacity`, 
              `clp_block4_hide`, `clp_block4_background`, `clp_block4_title`, `clp_block4_subtitle`, `clp_block4_bg_color`, 
              `clp_block4_image`, `clp_block4_r_title`, `clp_block4_r_subtitle`, `clp_block4_button`, `clp_block4_bg_opacity`, 
              `clp_block5_hide`, `clp_block5_background`, `clp_block5_title`, `clp_block5_subtitle`, `clp_block5_text`, 
              `clp_block5_image_1`, `clp_block5_image_2`, `clp_block5_image_3`, `clp_block5_bg_color`, `clp_block5_bg_opacity`, 
              `clp_block5_r_title`, `clp_block5_r_subtitle`, `clp_block5_r_text`, `clp_block5_button`, 
              `clp_block6_hide`, `clp_block6_background`, `clp_block6_title`, `clp_block6_description`, `clp_block6_bg_color`, 
              `clp_block6_subtitle`, `clp_block6_advantages`, `clp_block6_image`, `clp_block6_button`, `clp_block6_bg_opacity`,
              `clp_block7_hide`, `clp_block7_background`, `clp_block7_title`, `clp_block7_image_1`, `clp_block7_image_2`, 
              `clp_block7_image_3`, `clp_block7_image_4`, `clp_block7_text`, `clp_block7_bg_color`, `clp_block7_bg_opacity`, 
              `clp_block8_hide`, `clp_block8_background`, `clp_block7_button`, `clp_block8_title`, `clp_block8_bg_color`, 
              `clp_block8_bg_opacity`, `clp_block8_description1`, `clp_block8_subtitle`, `clp_block8_description2`, 
              `clp_block8_old_price`, `clp_block8_new_price`, `clp_block8_button`,
              `lp_html_page`, `lp_background`, `lp_slider_images`, `lp_block2_background_top`, `lp_block2_background`, `lp_block2_image`, `lp_block3_background`, 
              `lp_block3_image_1`, `lp_block3_image_2`, `lp_block4_background`, `lp_block4_image`, `lp_block5_background`, 
              `lp_block5_image_1`, `lp_block5_image_2`, `lp_block5_image_3`, `lp_block6_background`, `lp_block6_image`, 
              `lp_block7_background`, `lp_block7_image_1`, `lp_block7_image_2`, `lp_block7_image_3`, `lp_block7_image_4`, 
              `lp_block8_background`,
              `lp_block1_bg_color`, `lp_slider_opacity`, `lp_block2_bg_color`, `lp_block2_bg_opacity`, `lp_block3_bg_color`, 
              `lp_block3_bg_opacity`, `lp_block4_bg_color`, `lp_block4_bg_opacity`, `lp_block5_bg_color`, `lp_block5_bg_opacity`, 
              `lp_block6_bg_color`, `lp_block6_bg_opacity`, `lp_block7_bg_color`, `lp_block7_bg_opacity`, `lp_block8_bg_color`, 
              `lp_block8_bg_opacity`
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
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Сохранение/изменение Landing page курса
     *
     * @param $course_id
     * @param $hide_block
     * @param $landing_style
     * @param $b1_bg_color
     * @param $b1_bg_opacity
     * @param $slider_images
     * @param $main_title_bbcode
     * @param $date
     * @return bool
     */
    public function setCourseLandingBlock1($course_id, $hide_block, $landing_style, $b1_bg_color, $b1_bg_opacity,
                                           $slider_images, $main_title_bbcode, $date)
    {
        $up_data = $this->db->query('
            UPDATE `courses_landing_pages` 
            SET `clp_block1_hide`=?, `clp_block1_bg_color`=?, `clp_slider_opacity`=?, `clp_lp_id`=?, `clp_slider_images`=?, 
                `clp_main_title`=?, `clp_date_update`=? 
            WHERE `clp_course_id`=? LIMIT 1',
                array($hide_block, $b1_bg_color, $b1_bg_opacity, $landing_style, $slider_images, $main_title_bbcode, $date, $course_id));

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
     * Сохранение/изменение Landing page курса
     *
     * @param $course_id
     * @param $hide_block
     * @param $b2_bg_top
     * @param $b2_bg_color
     * @param $b2_bg_opacity
     * @param $b2_bg
     * @param $b2_image
     * @param $b2_title
     * @param $b2_subtitle
     * @param $b2_text
     * @param $b2_button
     * @param $date
     * @return bool
     */
    public function setCourseLandingBlock2($course_id, $hide_block, $b2_bg_top, $b2_bg_color, $b2_bg_opacity, $b2_bg,
                                           $b2_image, $b2_title, $b2_subtitle, $b2_text, $b2_button, $date)
    {
        $up_data = $this->db->query('
            UPDATE `courses_landing_pages` 
            SET `clp_block2_hide`=?, `clp_block2_background_top`=?, `clp_block2_bg_color`=?, `clp_block2_bg_opacity`=?, 
                `clp_block2_background`=?, `clp_block2_image`=?, `clp_block2_title`=?, `clp_block2_subtitle`=?, 
                `clp_block2_text`=?, `clp_block2_button`=?, `clp_date_update`=? 
            WHERE `clp_course_id`=? LIMIT 1',
                array($hide_block, $b2_bg_top, $b2_bg_color, $b2_bg_opacity, $b2_bg, $b2_image, $b2_title, $b2_subtitle,
                    $b2_text, $b2_button, $date, $course_id));

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
     * Сохранение/изменение Landing page курса
     *
     * @param $course_id
     * @param $hide_block
     * @param $b3_bg_color
     * @param $b3_bg_opacity
     * @param $b3_bg
     * @param $b3_image_1
     * @param $b3_image_2
     * @param $b3_title
     * @param $b3_subtitle
     * @param $b3_r_title
     * @param $b3_r_subtitle
     * @param $b3_r_reviews
     * @param $date
     * @return bool
     */
    public function setCourseLandingBlock3($course_id, $hide_block, $b3_bg_color, $b3_bg_opacity, $b3_bg, $b3_image_1,
                                           $b3_image_2, $b3_title, $b3_subtitle, $b3_r_title, $b3_r_subtitle,
                                           $b3_r_reviews, $date)
    {
        $up_data = $this->db->query('
            UPDATE `courses_landing_pages` 
            SET `clp_block3_hide`=?, `clp_block3_bg_color`=?, `clp_block3_bg_opacity`=?, `clp_block3_background`=?, 
                `clp_block3_image_1`=?, `clp_block3_image_2`=?, `clp_block3_title`=?, `clp_block3_subtitle`=?, 
                `clp_block3_r_title`=?, `clp_block3_r_subtitle`=?, `clp_block3_r_reviews`=?, `clp_date_update`=? 
            WHERE `clp_course_id`=? LIMIT 1',
                array($hide_block, $b3_bg_color, $b3_bg_opacity, $b3_bg, $b3_image_1, $b3_image_2, $b3_title,
                    $b3_subtitle, $b3_r_title, $b3_r_subtitle, $b3_r_reviews, $date, $course_id));

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
     * Сохранение/изменение Landing page курса
     *
     * @param $course_id
     * @param $hide_block
     * @param $b4_bg_color
     * @param $b4_bg_opacity
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
    public function setCourseLandingBlock4($course_id, $hide_block, $b4_bg_color, $b4_bg_opacity, $b4_bg, $b4_image,
                                           $b4_title, $b4_subtitle, $b4_r_title, $b4_r_desc, $b4_button, $date)
    {
        $up_data = $this->db->query('
            UPDATE `courses_landing_pages` 
            SET `clp_block4_hide`=?, `clp_block4_bg_color`=?, `clp_block4_bg_opacity`=?, `clp_block4_background`=?, 
                `clp_block4_image`=?, `clp_block4_title`=?, `clp_block4_subtitle`=?, `clp_block4_r_title`=?, 
                `clp_block4_r_subtitle`=?, `clp_block4_button`=?, `clp_date_update`=? 
            WHERE `clp_course_id`=? LIMIT 1',
                array($hide_block, $b4_bg_color, $b4_bg_opacity, $b4_bg, $b4_image, $b4_title, $b4_subtitle, $b4_r_title,
                    $b4_r_desc, $b4_button, $date, $course_id));

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
     * Сохранение/изменение Landing page курса
     *
     * @param $course_id
     * @param $hide_block
     * @param $b5_bg_color
     * @param $b5_bg_opacity
     * @param $b5_bg
     * @param $b5_image_1
     * @param $b5_image_2
     * @param $b5_image_3
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
    public function setCourseLandingBlock5($course_id, $hide_block, $b5_bg_color, $b5_bg_opacity, $b5_bg, $b5_image_1,
                                           $b5_image_2, $b5_image_3, $b5_title, $b5_subtitle, $b5_text, $b5_r_title,
                                           $b5_r_subtitle, $b5_r_text, $b5_button, $date)
    {
        $up_data = $this->db->query('
            UPDATE `courses_landing_pages` 
            SET `clp_block5_hide`=?, `clp_block5_bg_color`=?, `clp_block5_bg_opacity`=?, `clp_block5_background`=?, 
                `clp_block5_image_1`=?, `clp_block5_image_2`=?, `clp_block5_image_3`=?, `clp_block5_title`=?, `clp_block5_subtitle`=?, `clp_block5_text`=?, 
                `clp_block5_r_title`=?, `clp_block5_r_subtitle`=?, `clp_block5_r_text`=?, `clp_block5_button`=?, 
                `clp_date_update`=? 
            WHERE `clp_course_id`=? LIMIT 1',
                array($hide_block, $b5_bg_color, $b5_bg_opacity, $b5_bg, $b5_image_1, $b5_image_2, $b5_image_3, $b5_title,
                    $b5_subtitle, $b5_text, $b5_r_title, $b5_r_subtitle, $b5_r_text, $b5_button, $date, $course_id));

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
     * Сохранение/изменение Landing page курса
     *
     * @param $course_id
     * @param $hide_block
     * @param $b6_bg_color
     * @param $b6_bg_opacity
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
    public function setCourseLandingBlock6($course_id, $hide_block, $b6_bg_color, $b6_bg_opacity, $b6_bg, $b6_image,
                                           $b6_title, $b6_desc, $b6_subtitle, $b6_advantages, $b6_button, $date)
    {
        $up_data = $this->db->query('
            UPDATE `courses_landing_pages` 
            SET `clp_block6_hide`=?, `clp_block6_bg_color`=?, `clp_block6_bg_opacity`=?, `clp_block6_background`=?, 
                `clp_block6_image`=?, `clp_block6_title`=?, `clp_block6_description`=?, `clp_block6_subtitle`=?, 
                `clp_block6_advantages`=?, `clp_block6_button`=?, `clp_date_update`=? 
            WHERE `clp_course_id`=? LIMIT 1',
                array($hide_block, $b6_bg_color, $b6_bg_opacity, $b6_bg, $b6_image, $b6_title, $b6_desc, $b6_subtitle, $b6_advantages, $b6_button,
                    $date, $course_id));

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
     * Сохранение/изменение Landing page курса. Блок 7
     *
     * @param $course_id
     * @param $hide_block
     * @param $b7_bg_color
     * @param $b7_bg_opacity
     * @param $b7_bg
     * @param $b7_title
     * @param $b7_image_1
     * @param $b7_image_2
     * @param $b7_image_3
     * @param $b7_image_4
     * @param $b7_texts
     * @param $b7_button
     * @param $date
     * @return bool
     */
    public function setCourseLandingBlock7($course_id, $hide_block, $b7_bg_color, $b7_bg_opacity, $b7_bg, $b7_title,
                                           $b7_image_1, $b7_image_2, $b7_image_3, $b7_image_4, $b7_texts, $b7_button, $date)
    {
        $up_data = $this->db->query('
            UPDATE `courses_landing_pages` 
            SET `clp_block7_hide`=?, `clp_block7_bg_color`=?, `clp_block7_bg_opacity`=?, `clp_block7_background`=?, 
                `clp_block7_title`=?, `clp_block7_image_1`=?, `clp_block7_image_2`=?, `clp_block7_image_3`=?, 
                `clp_block7_image_4`=?, `clp_block7_text`=?, `clp_block7_button`=?, `clp_date_update`=? 
            WHERE `clp_course_id`=? LIMIT 1',
                array($hide_block, $b7_bg_color, $b7_bg_opacity, $b7_bg, $b7_title, $b7_image_1, $b7_image_2, $b7_image_3,
                    $b7_image_4, $b7_texts, $b7_button, $date, $course_id));

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
     * Сохранение/изменение Landing page курса
     *
     * @param $course_id
     * @param $hide_block
     * @param $b8_bg_color
     * @param $b8_bg_opacity
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
    public function setCourseLandingBlock8($course_id, $hide_block, $b8_bg_color, $b8_bg_opacity, $b8_bg, $b8_title,
                                           $b8_desc1, $b8_subtitle, $b8_desc2, $b8_old_price, $b8_new_price, $b8_button,
                                           $date)
    {
        $up_data = $this->db->query('
            UPDATE `courses_landing_pages` 
            SET `clp_block8_hide`=?, `clp_block8_bg_color`=?, `clp_block8_bg_opacity`=?, `clp_block8_background`=?, 
                `clp_block8_title`=?, `clp_block8_description1`=?, `clp_block8_subtitle`=?, `clp_block8_description2`=?, 
                `clp_block8_old_price`=?, `clp_block8_new_price`=?, `clp_block8_button`=?, `clp_date_update`=? 
            WHERE `clp_course_id`=? LIMIT 1',
                array($hide_block, $b8_bg_color, $b8_bg_opacity, $b8_bg, $b8_title, $b8_desc1, $b8_subtitle,
                    $b8_desc2, $b8_old_price, $b8_new_price,
                    $b8_button, $date, $course_id));

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
     * Удаление файлов изображений landing страницы курса из БД
     *
     * @param $course_id
     * @param $block_id
     * @param $img_type
     * @param $img_id
     * @param $img_path
     * @return bool
     */
    public function deleteLandingImage($course_id, $block_id, $img_type, $img_id, $img_path)
    {
        $result = false;

        if($img_type == 'background' or $img_type == 'background_top' or $img_type == 'image')
        {
            $col_name = 'clp_block'.$block_id.'_'.$img_type.$img_id;

            $up_data = $this->db->query('UPDATE `courses_landing_pages` SET `'.$col_name.'`="not_default" WHERE `clp_course_id`=? LIMIT 1', $course_id);
            if($up_data !== false and 1 == $this->db->affected_rows())
            {
                $result = true;
            }
            elseif($up_data === false)
            {
                parent::logDbMessages(__METHOD__.':'.__LINE__);
            }
        }
        elseif($img_type == 'slider')
        {
            $sel_data = $this->db->query('SELECT `clp_slider_images` as `col_images` FROM `courses_landing_pages` WHERE `clp_course_id`=? LIMIT 1', $course_id);

            if($sel_data !== false and 1 == $sel_data->num_rows())
            {
                $row = $sel_data->row();

                if(!empty($row->col_images))
                {
                    $images      = explode(';', $row->col_images);
                    $save_images = array();

                    $i = 0;
                    foreach($images as $image)
                    {
                        if(!empty($image) and $image != $img_path)
                        {
                            $save_images[$i] = $image;
                            $i++;
                        }
                    }
                    unset($image);

                    if(!empty($save_images))
                    {
                        $save_images = implode(';', $save_images);
                    }
                    else
                    {
                        $save_images = 'default';
                    }

                    if($save_images != $row->col_images)
                    {
                        $up_data = $this->db->query('UPDATE `courses_landing_pages` SET `clp_slider_images`=? WHERE `clp_course_id`=? LIMIT 1',
                            array($save_images, $course_id));
                        if($up_data !== false and 1 == $this->db->affected_rows())
                        {
                            $result = true;
                        }
                        elseif($up_data === false)
                        {
                            parent::logDbMessages(__METHOD__.':'.__LINE__);
                        }
                    }
                }

                unset($row);
            }
            elseif($sel_data === false)
            {
                parent::logDbMessages(__METHOD__.':'.__LINE__);
            }
        }

        return $result;
    }

    /**
     * Выборка данных стандартных Landing page
     *
     * @param int $lp_id ID default landing page
     * @return array
     */
    public function getDefaultLandingPage($lp_id)
    {
        $result = array('landing' => array());

        $sel_landing = $this->db->query('
            SELECT `lp_html_page`, `lp_background`, `lp_slider_images`, `lp_main_title`, `lp_block2_background`, `lp_block2_background_top`, 
              `lp_block2_image`, `lp_block2_title`, `lp_block2_subtitle`, `lp_block2_text`, `lp_block2_button`,
              `lp_block3_background`, `lp_block3_title`, `lp_block3_subtitle`, `lp_block3_image_1`, `lp_block3_image_2`, 
              `lp_block3_r_title`, `lp_block3_r_subtitle`, `lp_block3_r_reviews`, `lp_block4_background`, `lp_block4_title`, 
              `lp_block4_subtitle`, `lp_block4_image`, `lp_block4_r_title`, `lp_block4_r_subtitle`, `lp_block4_button`,  
              `lp_block5_background`, `lp_block5_title`, `lp_block5_subtitle`,`lp_block5_text`, `lp_block5_image_1`, `lp_block5_image_2`, `lp_block5_image_3`, 
              `lp_block5_r_title`, `lp_block5_r_subtitle`, `lp_block5_r_text`, `lp_block5_button`,  
              `lp_block6_background`, `lp_block6_title`, `lp_block6_description`, `lp_block6_subtitle`, `lp_block6_advantages`, 
              `lp_block6_image`, `lp_block6_button`,  
              `lp_block7_background`, `lp_block7_title`, `lp_block7_image_1`, `lp_block7_image_2`, `lp_block7_image_3`, `lp_block7_image_4`, `lp_block7_text`, `lp_block7_button`,  
              `lp_block8_background`, `lp_block8_title`, `lp_block8_description1`, `lp_block8_subtitle`, 
              `lp_block8_description2`, `lp_block8_old_price`, `lp_block8_new_price`, `lp_block8_button`,
              `lp_block1_bg_color`, `lp_slider_opacity`, `lp_block2_bg_color`, `lp_block2_bg_opacity`, `lp_block3_bg_color`, 
              `lp_block3_bg_opacity`, `lp_block4_bg_color`, `lp_block4_bg_opacity`, `lp_block5_bg_color`, `lp_block5_bg_opacity`, 
              `lp_block6_bg_color`, `lp_block6_bg_opacity`, `lp_block7_bg_color`, `lp_block7_bg_opacity`, `lp_block8_bg_color`, 
              `lp_block8_bg_opacity`
            FROM `landing_pages`
            WHERE `lp_id`=? LIMIT 1', $lp_id);

        if ($sel_landing !== false and 1 == $sel_landing->num_rows())
        {
            $row = $sel_landing->row();

            // Путь к HTML странице landing page
            $result['landing']['html_page'] = $row->lp_html_page;

            // Вывод блоков
            $result['landing']['hide'] = false;
            $result['landing']['block2']['hide'] = false;
            $result['landing']['block3']['hide'] = false;
            $result['landing']['block4']['hide'] = false;
            $result['landing']['block5']['hide'] = false;
            $result['landing']['block6']['hide'] = false;
            $result['landing']['block7']['hide'] = false;
            $result['landing']['block8']['hide'] = false;

            // Фон страницы
            $result['landing']['bg'] = (is_file($row->lp_background))
                ? 'url(' . mb_substr($row->lp_background, 1) . ') top center repeat' : '';

            // Цвет фона блока
            $block1_bg_color = '';
            if(!empty($row->lp_block1_bg_color))
            {
                $f_l = mb_substr($row->lp_block1_bg_color, 0, 1);
                $rest_l = mb_substr($row->lp_block1_bg_color, 1, 6);

                $block1_bg_color = ($f_l == '#' and ctype_xdigit($rest_l)) ? $row->lp_block1_bg_color : '';
            }
            $result['landing']['bg_color'] = $block1_bg_color;

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
                        $result['landing']['slider_images'][$i] = (is_file($s_image)) ? mb_substr($s_image, 1) : '';

                        if (empty($result['landing']['slider_images'][$i]))
                        {
                            unset($result['landing']['slider_images'][$i]);
                        }

                        $i++;
                    }
                }
                unset($s_image);
            }

            // Прозрачность изображений слайдера
            $result['landing']['slider_opacity'] = (is_numeric($row->lp_slider_opacity) and $row->lp_slider_opacity > 0)
                ? $row->lp_slider_opacity : '';

            $result['landing']['main_title'] = $row->lp_main_title;

            // БЛОК 2
            // Цвет фона блока
            $block2_bg_color = '';
            if(!empty($row->lp_block2_bg_color))
            {
                $f_l = mb_substr($row->lp_block2_bg_color, 0, 1);
                $rest_l = mb_substr($row->lp_block2_bg_color, 1, 6);

                $block2_bg_color = ($f_l == '#' and ctype_xdigit($rest_l)) ? $row->lp_block2_bg_color : '';
            }
            $result['landing']['block2']['bg_color'] = $block2_bg_color;

            // Шапка фона блока
            $result['landing']['block2']['bg_top'] = (is_file($row->lp_block2_background_top))
                    ? 'url(' . mb_substr($row->lp_block2_background_top, 1) . ') top center no-repeat' : '';

            // Фон блока
            $result['landing']['block2']['bg'] = (is_file($row->lp_block2_background)) ?
                    'url(' . mb_substr($row->lp_block2_background, 1) . ') top center repeat' : '';

            // Прозрачность изображения фона
            $result['landing']['block2']['bg_opacity'] = (is_numeric($row->lp_block2_bg_opacity) and $row->lp_block2_bg_opacity > 0)
                ? $row->lp_block2_bg_opacity : '' ;

            // Изображение блока
            $result['landing']['block2']['image'] = (is_file($row->lp_block2_image))
                ? mb_substr($row->lp_block2_image, 1) : '';

            $result['landing']['block2']['title']    = $row->lp_block2_title;
            $result['landing']['block2']['subtitle'] = $row->lp_block2_subtitle;
            $result['landing']['block2']['text']     = $row->lp_block2_text;
            $result['landing']['block2']['button']   = strip_tags($row->lp_block2_button);

            // БЛОК 3
            // Цвет фона блока
            $block3_bg_color = '';
            if (!empty($row->lp_block3_bg_color))
            {
                $f_l = mb_substr($row->lp_block3_bg_color, 0, 1);
                $rest_l = mb_substr($row->lp_block3_bg_color, 1, 6);

                $block3_bg_color = ($f_l == '#' and ctype_xdigit($rest_l)) ? $row->lp_block3_bg_color : '';
            }
            $result['landing']['block3']['bg_color'] = $block3_bg_color;

            // Фон блока
            $result['landing']['block3']['bg'] = (is_file($row->lp_block3_background))
                ? 'url(' . mb_substr($row->lp_block3_background, 1) . ')' : '';

            // Прозрачность изображения фона
            $result['landing']['block3']['bg_opacity'] = (is_numeric($row->lp_block3_bg_opacity) and $row->lp_block3_bg_opacity > 0)
                ? $row->lp_block3_bg_opacity : '' ;


            $result['landing']['block3']['title']      = $row->lp_block3_title;
            $result['landing']['block3']['subtitle']   = $row->lp_block3_subtitle;
            $result['landing']['block3']['r_title']    = $row->lp_block3_r_title;
            $result['landing']['block3']['r_subtitle'] = $row->lp_block3_r_subtitle;
            $result['landing']['block3']['r_reviews']  = $row->lp_block3_r_reviews;

            // Изображения блока
            $result['landing']['block3']['image1'] = (is_file($row->lp_block3_image_1)) ? mb_substr($row->lp_block3_image_1, 1) : '';
            $result['landing']['block3']['image2'] = (is_file($row->lp_block3_image_2)) ? mb_substr($row->lp_block3_image_2, 1) : '';

            // БЛОК 4
            // Цвет фона блока
            $block4_bg_color = '';
            if(!empty($row->lp_block4_bg_color))
            {
                $f_l = mb_substr($row->lp_block4_bg_color, 0, 1);
                $rest_l = mb_substr($row->lp_block4_bg_color, 1, 6);

                $block4_bg_color = ($f_l == '#' and ctype_xdigit($rest_l)) ? $row->lp_block4_bg_color : '';
            }
            $result['landing']['block4']['bg_color'] = $block4_bg_color;

            // Фон блока
            $result['landing']['block4']['bg'] = (is_file($row->lp_block4_background))
                ? 'url(' . mb_substr($row->lp_block4_background, 1) . ')' : '';

            $result['landing']['block4']['title']    = $row->lp_block4_title;
            $result['landing']['block4']['subtitle'] = $row->lp_block4_subtitle;

            // Прозрачность изображения фона
            $result['landing']['block4']['bg_opacity'] = (is_numeric($row->lp_block4_bg_opacity) and $row->lp_block4_bg_opacity > 0)
                ? $row->lp_block4_bg_opacity : '' ;

            // Изображение блока
            $result['landing']['block4']['image'] = (is_file($row->lp_block4_image)) ? mb_substr($row->lp_block4_image, 1) : '';

            $result['landing']['block4']['r_title']    = $row->lp_block4_r_title;
            $result['landing']['block4']['r_subtitle'] = $row->lp_block4_r_subtitle;
            $result['landing']['block4']['button']     = strip_tags($row->lp_block4_button);

            // БЛОК 5
            // Цвет фона блока
            $block5_bg_color = '';
            if(!empty($row->lp_block5_bg_color))
            {
                $f_l = mb_substr($row->lp_block5_bg_color, 0, 1);
                $rest_l = mb_substr($row->lp_block5_bg_color, 1, 6);

                $block5_bg_color = ($f_l == '#' and ctype_xdigit($rest_l)) ? $row->lp_block5_bg_color : '';
            }
            $result['landing']['block5']['bg_color'] = $block5_bg_color;

            // Фон блока
            $result['landing']['block5']['bg'] = (is_file($row->lp_block5_background))
                ? 'url(' . mb_substr($row->lp_block5_background, 1) . ')' : '';

            // Прозрачность изображения фона
            $result['landing']['block5']['bg_opacity'] = (is_numeric($row->lp_block5_bg_opacity) and $row->lp_block5_bg_opacity > 0)
                ? $row->lp_block5_bg_opacity : '' ;

            $result['landing']['block5']['title']    = $row->lp_block5_title;
            $result['landing']['block5']['subtitle'] = $row->lp_block5_subtitle;
            $result['landing']['block5']['text']     = $row->lp_block5_text;
            $result['landing']['block5']['button']   = strip_tags($row->lp_block5_button);

            // Изображения блока
            $result['landing']['block5']['image1'] = is_file($row->lp_block5_image_1) ? mb_substr($row->lp_block5_image_1, 1) : '';
            $result['landing']['block5']['image2'] = is_file($row->lp_block5_image_2) ? mb_substr($row->lp_block5_image_2, 1) : '';
            $result['landing']['block5']['image3'] = is_file($row->lp_block5_image_3) ? mb_substr($row->lp_block5_image_3, 1) : '';

            $result['landing']['block5']['r_title']    = $row->lp_block5_r_title;
            $result['landing']['block5']['r_subtitle'] = $row->lp_block5_r_subtitle;
            $result['landing']['block5']['r_text']     = $row->lp_block5_r_text;

            // БЛОК 6
            // Цвет фона блока
            $block6_bg_color = '';
            if(!empty($row->lp_block6_bg_color))
            {
                $f_l = mb_substr($row->lp_block6_bg_color, 0, 1);
                $rest_l = mb_substr($row->lp_block6_bg_color, 1, 6);

                $block6_bg_color = ($f_l == '#' and ctype_xdigit($rest_l)) ? $row->lp_block6_bg_color : '';
            }
            $result['landing']['block6']['bg_color'] = $block6_bg_color;

            // Фон блока
            $result['landing']['block6']['bg'] = (is_file($row->lp_block6_background))
                ? 'url(' . mb_substr($row->lp_block6_background, 1) . ')' : '';

            // Прозрачность изображения фона
            $result['landing']['block6']['bg_opacity'] = (is_numeric($row->lp_block6_bg_opacity) and $row->lp_block6_bg_opacity > 0)
                ? $row->lp_block6_bg_opacity : '' ;

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
            $result['landing']['block6']['image'] = (is_file($row->lp_block6_image)) ? mb_substr($row->lp_block6_image, 1) : '';

            // БЛОК 7
            // Цвет фона блока
            $block7_bg_color = '';
            if(!empty($row->lp_block7_bg_color))
            {
                $f_l = mb_substr($row->lp_block7_bg_color, 0, 1);
                $rest_l = mb_substr($row->lp_block7_bg_color, 1, 6);

                $block7_bg_color = ($f_l == '#' and ctype_xdigit($rest_l)) ? $row->lp_block7_bg_color : '';
            }
            $result['landing']['block7']['bg_color'] = $block7_bg_color;

            // Фон блока
            $result['landing']['block7']['bg'] = (is_file($row->lp_block7_background))
                ? 'url(' . mb_substr($row->lp_block7_background, 1) . ')' : '';

            // Прозрачность изображения фона
            $result['landing']['block7']['bg_opacity'] = (is_numeric($row->lp_block7_bg_opacity) and $row->lp_block7_bg_opacity > 0)
                ? $row->lp_block7_bg_opacity : '';

            $result['landing']['block7']['title']  = $row->lp_block7_title;
            $result['landing']['block7']['button'] = strip_tags($row->lp_block7_button);

            // Изображения блока
            $result['landing']['block7']['image1'] = is_file($row->lp_block7_image_1) ? mb_substr($row->lp_block7_image_1, 1) : '';
            $result['landing']['block7']['image2'] = is_file($row->lp_block7_image_2) ? mb_substr($row->lp_block7_image_2, 1) : '';
            $result['landing']['block7']['image3'] = is_file($row->lp_block7_image_3) ? mb_substr($row->lp_block7_image_3, 1) : '';
            $result['landing']['block7']['image4'] = is_file($row->lp_block7_image_4) ? mb_substr($row->lp_block7_image_4, 1) : '';

            // Изображения блока
            $result['landing']['block7']['texts'] = '';
            if (!empty($row->lp_block7_text))
            {
                $texts = explode(';', $row->lp_block7_text);

                $i = 1;
                foreach ($texts as $text)
                {
                    if (!empty($text))
                    {
                        $result['landing']['block7']['texts'][$i] = $text;

                        $i++;
                    }
                }
                unset($text);
            }

            // БЛОК 8
            // Цвет фона блока
            $block8_bg_color = '';
            if(!empty($row->lp_block8_bg_color))
            {
                $f_l = mb_substr($row->lp_block8_bg_color, 0, 1);
                $rest_l = mb_substr($row->lp_block8_bg_color, 1, 6);

                $block8_bg_color = ($f_l == '#' and ctype_xdigit($rest_l)) ? $row->lp_block8_bg_color : '';
            }
            $result['landing']['block8']['bg_color'] = $block8_bg_color;

            // Фон блока
            $result['landing']['block8']['bg'] = (is_file($row->lp_block8_background))
                ? 'url(' . mb_substr($row->lp_block8_background, 1) . ')' : '';

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
            parent::logDbMessages(__METHOD__.':'.__LINE__);
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
        $result = array('landing' => array());

        $sel_landing = $this->db->query('
			SELECT `clp_block1_hide`, `clp_slider_images`, `clp_main_title`, 
              `clp_block2_hide`, `clp_block2_background_top`, `clp_block2_background`, `clp_block2_image`, `clp_block2_title`, 
              `clp_block2_subtitle`, `clp_block2_text`, `clp_block2_button`, 
              `clp_block3_hide`, `clp_block3_background`, `clp_block3_title`, `clp_block3_subtitle`, `clp_block3_image_1`, 
              `clp_block3_image_2`, `clp_block3_r_title`, `clp_block3_r_subtitle`, `clp_block3_r_reviews`, 
              `clp_block4_hide`, `clp_block4_background`, `clp_block4_title`, `clp_block4_subtitle`, 
              `clp_block4_image`, `clp_block4_r_title`, `clp_block4_r_subtitle`, `clp_block4_button`, 
              `clp_block5_hide`, `clp_block5_background`, `clp_block5_title`, `clp_block5_subtitle`, `clp_block5_text`, `clp_block5_image_1`, 
              `clp_block5_image_2`, `clp_block5_image_3`, `clp_block5_r_title`, `clp_block5_r_subtitle`, `clp_block5_r_text`, `clp_block5_button`, 
              `clp_block6_hide`, `clp_block6_background`, `clp_block6_title`, `clp_block6_description`, 
              `clp_block6_subtitle`, `clp_block6_advantages`, `clp_block6_image`, `clp_block6_button`,
              `clp_block7_hide`, `clp_block7_background`, `clp_block7_title`, `clp_block7_image_1`, `clp_block7_image_2`, 
              `clp_block7_image_3`, `clp_block7_image_4`, `clp_block7_text`, `clp_block7_button`,
              `clp_block8_hide`, `clp_block8_background`, `clp_block8_title`, `clp_block8_description1`, `clp_block8_subtitle`, 
              `clp_block8_description2`, `clp_block8_old_price`, `clp_block8_new_price`, `clp_block8_button`,
              `lp_html_page`, `lp_background`, `lp_slider_images`, `lp_block2_background_top`, `lp_block2_background`, `lp_block2_image`, `lp_block3_background`, 
              `lp_block3_image_1`, `lp_block3_image_2`, `lp_block4_background`, `lp_block4_image`, `lp_block5_background`, 
              `lp_block5_image_1`, `lp_block5_image_2`, `lp_block5_image_3`, 
              `lp_block6_background`, `lp_block6_image`, `lp_block7_background`, `lp_block7_image_1`, `lp_block7_image_2`, 
              `lp_block7_image_3`, `lp_block7_image_4`, `lp_block8_background`,
              `lp_block1_bg_color`, `lp_slider_opacity`, `lp_block2_bg_color`, `lp_block2_bg_opacity`, `lp_block3_bg_color`, 
              `lp_block3_bg_opacity`, `lp_block4_bg_color`, `lp_block4_bg_opacity`, `lp_block5_bg_color`, `lp_block5_bg_opacity`, 
              `lp_block6_bg_color`, `lp_block6_bg_opacity`, `lp_block7_bg_color`, `lp_block7_bg_opacity`, `lp_block8_bg_color`, 
              `lp_block8_bg_opacity`,                   
              `clp_block1_bg_color`, `clp_slider_opacity`, `clp_block2_bg_color`, `clp_block2_bg_opacity`, `clp_block3_bg_color`, 
              `clp_block3_bg_opacity`, `clp_block4_bg_color`, `clp_block4_bg_opacity`, `clp_block5_bg_color`, `clp_block5_bg_opacity`, 
              `clp_block6_bg_color`, `clp_block6_bg_opacity`, `clp_block7_bg_color`, `clp_block7_bg_opacity`, `clp_block8_bg_color`, 
              `clp_block8_bg_opacity`
            FROM `courses_landing_pages`
            LEFT JOIN `landing_pages` ON `lp_id`=`clp_lp_id`
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
            parent::logDbMessages(__METHOD__.':'.__LINE__);
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
            parent::logDbMessages(__METHOD__.':'.__LINE__);
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
            parent::logDbMessages(__METHOD__.':'.__LINE__);
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
            parent::logDbMessages(__METHOD__.':'.__LINE__);
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
            self::deleteCourseCoaches($course_id);

            // Удалить landing курса
            self::deleteCourseLanding($course_id);

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
            parent::logDbMessages(__METHOD__.':'.__LINE__);
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
            parent::logDbMessages(__METHOD__.':'.__LINE__);
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
    protected function deleteCourseCoaches($course_id)
    {
        $up_data = $this->db->query('DELETE FROM `courses_coaches` WHERE `cc_course_id`=?', $course_id);

        if ($up_data !== false and 0 < $this->db->affected_rows())
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
     * Удаление landing курса
     *
     * @param $course_id
     * @return bool
     */
    protected function deleteCourseLanding($course_id)
    {
        $sel_landing = $this->db->query('
            SELECT `clp_id`, `clp_slider_images`, `clp_block2_background`, `clp_block2_image`, `clp_block3_background`, 
              `clp_block3_image_1`, `clp_block3_image_2`, `clp_block4_background`, `clp_block4_image`, 
              `clp_block5_background`, `clp_block5_image_1`, `clp_block5_image_2`, `clp_block5_image_3`, `clp_block6_background`, 
              `clp_block6_image`, `clp_block7_background`, `clp_block7_image_1`, `clp_block7_image_2`, `clp_block7_image_3`, 
              `clp_block7_image_4`, `clp_block8_background` 
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
                if (!empty($row->clp_block2_background_top) and $row->clp_block2_background_top != 'default' and is_file($row->clp_block2_background_top)) {
                    unlink($row->clp_block2_background_top);
                }
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
                if (!empty($row->clp_block3_image_1) and $row->clp_block3_image_1 != 'default' and is_file($row->clp_block3_image_1)) {
                    unlink($row->clp_block3_image_1);
                }
                if (!empty($row->clp_block3_image_2) and $row->clp_block3_image_2 != 'default' and is_file($row->clp_block3_image_2)) {
                    unlink($row->clp_block3_image_2);
                }
                if (!empty($row->clp_block4_image) and $row->clp_block4_image != 'default' and is_file($row->clp_block4_image)) {
                    unlink($row->clp_block4_image);
                }
                if (!empty($row->clp_block5_image_1) and $row->clp_block5_image_1 != 'default' and is_file($row->clp_block5_image_1)) {
                    unlink($row->clp_block5_image_1);
                }
                if (!empty($row->clp_block5_image_2) and $row->clp_block5_image_2 != 'default' and is_file($row->clp_block5_image_2)) {
                    unlink($row->clp_block5_image_2);
                }
                if (!empty($row->clp_block5_image_3) and $row->clp_block5_image_3 != 'default' and is_file($row->clp_block5_image_3)) {
                    unlink($row->clp_block5_image_3);
                }
                if (!empty($row->clp_block6_image) and $row->clp_block6_image != 'default' and is_file($row->clp_block6_image)) {
                    unlink($row->clp_block6_image);
                }
                if (!empty($row->clp_block7_image_1) and $row->clp_block7_image_1 != 'default' and is_file($row->clp_block7_image_1)) {
                    unlink($row->clp_block7_image_1);
                }
                if (!empty($row->clp_block7_image_2) and $row->clp_block7_image_2 != 'default' and is_file($row->clp_block7_image_2)) {
                    unlink($row->clp_block7_image_2);
                }
                if (!empty($row->clp_block7_image_3) and $row->clp_block7_image_3 != 'default' and is_file($row->clp_block7_image_3)) {
                    unlink($row->clp_block7_image_3);
                }
                if (!empty($row->clp_block7_image_4) and $row->clp_block7_image_4 != 'default' and is_file($row->clp_block7_image_4)) {
                    unlink($row->clp_block7_image_4);
                }

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
        elseif ($sel_landing === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
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
            parent::logDbMessages(__METHOD__.':'.__LINE__);
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
            parent::logDbMessages(__METHOD__.':'.__LINE__);
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
            parent::logDbMessages(__METHOD__.':'.__LINE__);
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
            parent::logDbMessages(__METHOD__.':'.__LINE__);
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
            SELECT `video_id`, `video_name`, `video_poster`, `video_type`, `video_active` 
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
            parent::logDbMessages(__METHOD__.':'.__LINE__);
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
            SELECT `video_id`, `video_name`, `video_poster`, `video_type`, `video_active` 
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
            parent::logDbMessages(__METHOD__.':'.__LINE__);
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
            SELECT `video_id`, `video_name`, `video_poster`, `video_type`, `video_active` 
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
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Список видео курса категории "Инструктажи"
     *
     * @param $course_id
     * @return array
     */
    public function getCourseUncategorizedVideo($course_id)
    {
        $result = array();

        $sel_video = $this->db->query('
            SELECT `video_id`, `video_name`, `video_poster`, `video_type`, `video_active` 
            FROM `video`
            WHERE `video_crs_id`=? and `video_type`=0', $course_id);

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
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Активное видео курса категории "Инструктажи"
     *
     * @param $course_id
     * @return array
     */
    public function getActiveCourseInstructionVideo($course_id)
    {
        $result = array();

        $sel_video = $this->db->query('
            SELECT `video_id`, `video_name`, `video_poster`, `video_type`, `video_active` 
            FROM `video`
            WHERE `video_crs_id`=? and `video_type`=3 and `video_active`=1 LIMIT 1', $course_id);

        if ($sel_video !== false and 0 < $sel_video->num_rows())
        {
            $i = 0;
            foreach ($sel_video->result() as $row)
            {
                $result['video'] = self::parseVideoData($row);
                $result['video']['name'] = !empty($row->video_name) ? $row->video_name : $row->video_id;

                $i++;
            }
            unset($row);
        }
        elseif ($sel_video === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
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
            parent::logDbMessages(__METHOD__.':'.__LINE__);
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
            parent::logDbMessages(__METHOD__.':'.__LINE__);
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
            parent::logDbMessages(__METHOD__.':'.__LINE__);
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
            SELECT `video_id`, `video_name`, `video_path`, `video_poster`, `video_remove_url`, `video_crs_id`, `video_date_add`, 
              `crs_name`, `crs_blocked`
            FROM `video`
            LEFT JOIN `courses` ON `crs_id`=`video_crs_id`
            WHERE `video_blocked`=0 and `video_type`=1 and `video_crs_id`>0 and `crs_blocked`=0 and `video_active`=1
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
            parent::logDbMessages(__METHOD__.':'.__LINE__);
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

        if(!empty($video_id) and is_numeric($video_id))
        {
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
                parent::logDbMessages(__METHOD__.':'.__LINE__);
                $result = false;
            }
            else
            {
                $result = false;
            }
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
        $sel_user_courses = $this->db->query('
            SELECT `uc_id`, `uc_course_id`, `crs_name`, `crs_description`, `crs_image` 
            FROM `users_courses` 
            LEFT JOIN `courses` ON `crs_id`=`uc_course_id`
            WHERE `uc_user_id`=?', $user_id);
        if ($sel_user_courses !== false and 0 < $sel_user_courses->num_rows())
        {
            $i = 0;
            foreach($sel_user_courses->result() as $row)
            {
                // Выборка пользовательских данных о тренировке на сегодня
                $sel_today_workout = $this->db->query('
                    SELECT `utw_id`, `utw_uc_id`, `utw_workout`, `utw_crs_workout`, `utw_status`, `utw_date` 
                    FROM `users_training_weeks`
                    WHERE `utw_uc_id`=? and `utw_date`=? and `utw_status`<>"missed" LIMIT 1', array($row->uc_id, $today));

                if ($sel_today_workout !== false and 1 == $sel_today_workout->num_rows())
                {
                    $w_row = $sel_today_workout->row();

                    $result['workouts'][$i]['id']      = $w_row->utw_id;
                    $result['workouts'][$i]['workout'] = $w_row->utw_crs_workout;
                    $result['workouts'][$i]['done']    = ($w_row->utw_status == 'done') ? 1 : 0;

                    $result['workouts'][$i]['course']['id']          = $row->uc_course_id;
                    $result['workouts'][$i]['course']['image']       = (!empty($row->crs_image)) ? mb_substr($row->crs_image, 1) : '';
                    $result['workouts'][$i]['course']['name']        = $row->crs_name;
                    $result['workouts'][$i]['course']['description'] = $row->crs_description;

                    unset($w_row);
                    $i++;
                }
                elseif ($sel_today_workout === false)
                {
                    parent::logDbMessages(__METHOD__.':'.__LINE__);
                }

            }
            unset($row);

            // Данные тренировки и инструктажа курса
            if(!empty($result['workouts']))
            {
                foreach ($result['workouts'] as $key => $cw)
                {
                    // Данные тренировки курса
                    $sel_course_workout = $this->db->query('
                    SELECT `ctw_id`, `ctw_course_id`, `ctw_num_workout`, `ctw_description`, `ctw_video_id`, `ctw_repeat_workout` 
                    FROM `courses_training_weeks`
                    WHERE `ctw_course_id`=? and `ctw_num_workout`=? LIMIT 1', array($cw['course']['id'], $cw['workout']));

                    if ($sel_course_workout !== false and 1 == $sel_course_workout->num_rows())
                    {
                        $row = $sel_course_workout->row();

                        if ($row->ctw_repeat_workout > 0)
                        {
                            // Выборка ID видео повторяемой тренировки
                            $sel_repeat_workout = $this->db->query('
                            SELECT `ctw_video_id`, `ctw_description` 
                            FROM `courses_training_weeks`
                            WHERE `ctw_course_id`=? and `ctw_num_workout`=? LIMIT 1', array($cw['course']['id'], $row->ctw_repeat_workout));

                            if ($sel_repeat_workout !== false and 1 == $sel_repeat_workout->num_rows())
                            {
                                $row2 = $sel_repeat_workout->row();

                                $video_id = $row2->ctw_video_id;
                                $video_description = $row2->ctw_description;

                                unset($row2);
                            }
                            elseif ($sel_repeat_workout === false)
                            {
                                parent::logDbMessages(__METHOD__.':'.__LINE__);
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
                        parent::logDbMessages(__METHOD__.':'.__LINE__);
                    }

                    // Данные инструктажа тренировки
                    $instruction_video = self::getActiveCourseInstructionVideo($cw['course']['id']);
                    $result['workouts'][$key]['instruction'] = (!empty($instruction_video['video'])) ? $instruction_video['video']['id'] : '';
                }
                unset($cw);
            }
        }
        elseif ($sel_user_courses === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
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
          SELECT `utw_uc_id`, `utw_workout`, `utw_crs_workout`, `utw_status` 
          FROM `users_training_weeks`
          WHERE `utw_id`=? LIMIT 1', $workout_id);

        if ($sel_utw !== false and 1 == $sel_utw->num_rows())
        {
            $row = $sel_utw->row();

            $uc_id        = $row->utw_uc_id; // Уникальное ID курса и пользователя
            $workout_num  = $row->utw_crs_workout; // Номер тренировки курса
            $workout_done = ($row->utw_status == 'done') ? 1 : 0; // Выполнена ли тренировки

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
                            parent::logDbMessages(__METHOD__.':'.__LINE__);
                        }
                    }
                    unset($row);

                    // Данные инструктажа тренировки
                    $instruction_video = self::getActiveCourseInstructionVideo($course_id);
                    $instruction = (!empty($instruction_video['video'])) ? $instruction_video['video']['id'] : '';
                }
                elseif ($sel_ctw === false)
                {
                    parent::logDbMessages(__METHOD__.':'.__LINE__);
                }
            }
            elseif ($sel_uc === false)
            {
                parent::logDbMessages(__METHOD__.':'.__LINE__);
            }
        }
        elseif ($sel_utw === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
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
     * Определение соответствия ID видео и ID тренировки -> ID курса и ID пользователя
     *
     * @param int $user_id ID пользователя
     * @param int $workout_id Уникальное ID тренировки в таблице `utw_training_weeks` (`utw_id`)
     * @param int $video_id ID видео
     * @return bool|int
     */
    public function matchWorkoutInstructionVideo($user_id, $workout_id, $video_id)
    {
        $db_video_id     = null; // ID видео с БД
        $db_workout_desc = null; // Описание видео с БД
        $instruction     = null;
        $workout_done    = null;

        // Нахождение уникального ID курса, пользователя и номера тренировки курса
        $sel_utw = $this->db->query('
            SELECT `utw_uc_id`, `utw_workout`, `utw_crs_workout`, `uc_course_id`, `uc_user_id` 
            FROM `users_training_weeks`
            LEFT JOIN `users_courses` ON `uc_id`=`utw_uc_id`
            WHERE `utw_id`=? and `uc_user_id`=? LIMIT 1', array($workout_id, $user_id));

        if ($sel_utw !== false and 1 == $sel_utw->num_rows())
        {
            $row = $sel_utw->row();
            $course_id = $row->uc_course_id; // ID курса

            unset($row);
            $sel_utw->free_result();

            // Определение ID видео инструктажа для тренировки
            $sel_ctw = $this->db->query('
                SELECT `video_id` 
                FROM `video`
                WHERE `video_crs_id`=? and `video_id`=? LIMIT 1', array($course_id, $video_id));

            if ($sel_ctw !== false and 1 == $sel_ctw->num_rows())
            {
                $row = $sel_ctw->row();

                if ($row->video_id > 0)
                {
                    $db_video_id = $row->video_id;
                }
                unset($row);
            }
            elseif ($sel_ctw === false)
            {
                parent::logDbMessages(__METHOD__.':'.__LINE__);
            }
        }
        elseif ($sel_utw === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        if (!empty($db_video_id) and $video_id == $db_video_id)
        {
            $result['instruction_id'] = $video_id;

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
            parent::logDbMessages(__METHOD__.':'.__LINE__);
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
            parent::logDbMessages(__METHOD__.':'.__LINE__);
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
            parent::logDbMessages(__METHOD__.':'.__LINE__);
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
                parent::logDbMessages(__METHOD__.':'.__LINE__);
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

    /**
     * Активация видео курса
     *
     * @param $course_id
     * @param $video_id
     * @param $video_type
     * @param $display
     * @param $date
     * @return bool
     */
    public function activateCourseVideos($course_id, $video_id, $video_type, $date)
    {
        $result = false;
        $video_types = array(1 => 'promo', 2 => 'workouts', 3 => 'instructions');
        $type_id = array_search($video_type, $video_types);
        log_message('debug', $type_id);

        if(!empty($type_id))
        {
            $disact_data = $this->db->query('UPDATE `video` SET `video_active`=0, `video_date_update`=? WHERE `video_crs_id`=? and `video_type`=?',
                array($date, $course_id, $type_id));
            if($disact_data === false)
            {
                parent::logDbMessages(__METHOD__.':'.__LINE__);
            }

            $act_data = $this->db->query('UPDATE `video` SET `video_active`=1, `video_date_update`=? WHERE `video_id`=? and `video_crs_id`=? and `video_type`=? LIMIT 1',
                array($date, $video_id, $course_id, $type_id));
            if($act_data !== false and 1 == $this->db->affected_rows())
            {
                $result = true;
            }
            elseif($act_data === false)
            {
                parent::logDbMessages(__METHOD__.':'.__LINE__);
            }
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
     * @param string $courses_type
     * @param array|null $user_training_time
     * @return array
     * @throws Exception
     */
    public function getUserCourses($user_id, $date, $courses_type, $user_training_time = null)
    {
        $result = array(
            'courses' => array(),
            'events' => array(),
            'notifications' => array(),
            'blocked_courses' => array(),
            'available_workout' => false,
            'next_training' => null,
            'courses_percent_done' => false);

        // Проверка курсов на закончившиеся бесплатные недели
        self::checkUserCoursesFreeWeeks($user_id, $date);

        $color = array(42, 202, 242);
        // Флаг следующего тренировочного дня
        $next_training = false;
        $next_training_date = null;
        $ingestions = self::getIngestions();

        // Активные курсы
        if($courses_type == 'active' and is_numeric($user_id))
        {
            $tmp_date = new DateTime($date);
            $today    = $tmp_date->format('Y-m-d');
            $tmp_date->sub(new DateInterval('P7D'));
            // Дата неделю назад от текущей даты
            $week_ago = $tmp_date->format('Y-m-d');

            // Активные курсы
            $sel_courses = $this->db->query('
                SELECT `uc_id`, `uc_course_id`, `uc_coach_id`, `uc_days`, `uc_time`, `uc_date_start`, `uc_date_end`, `uc_blocked`, 
                    `uc_blocked_date`, `uc_blocked_reason`, `uc_paused`, `uc_pause_days`, `uc_display`, 
                    `crs_image`, `crs_name`, `crs_description`, `crs_count_weeks`, `crs_count_days`, `crs_category` 
                FROM `users_courses` 
                LEFT JOIN `courses` ON `uc_course_id`=`crs_id`
                WHERE `uc_user_id`=? and `uc_blocked`=0 and (`uc_date_end`>=? or `uc_date_end`="0000-00-00") 
                ORDER BY `uc_date_end` DESC', array($user_id, $today));

            if ($sel_courses !== false and 0 < $sel_courses->num_rows())
            {
                $i = 0;
                foreach ($sel_courses->result() as $row)
                {
                    $result['courses'][$i] = self::parseUserCourseData($row, $today);

                    /*
                    $tmp_date2 = new DateTime($row->uc_blocked_date);
                    $tmp_date2->add(new DateInterval('P28D'));
                    // Дата через 4 недели от даты блокировки
                    $next_three_weeks = $tmp_date2->format('Y-m-d');

                    // Не отображать курсы, которые заблокированы и 4 недели после блокировки прошли
                    if($row->uc_blocked == 1 and $next_three_weeks < $today and $row->uc_blocked_reason == 'payment_canceled')
                    {
                        unset($result['courses'][$i]);
                    }
                    */

                    $i++;
                }
                unset($row);
                unset($i);
                $sel_courses->free_result();

                // Тренеры курса
                foreach ($result['courses'] as $key => $course)
                {
                    $result['courses'][$key] = array_merge($result['courses'][$key], self::getCourseCoaches($course['course_id']));
                }
                unset($course);

                $ei = 0;
                // Паузы в тренировках и тренировки пользователя
                foreach ($result['courses'] as $key => $course)
                {
                    $parse_data = self::parseUserCourseWorkoutsData($course, $key, $color, $ei, $next_training, $next_training_date, $user_training_time, $ingestions, $date);

                    //print_r($parse_data); echo '<br/><br/>';

                    $result['courses'][$key]['pauses']       = (!empty($parse_data['pauses'])) ? $parse_data['pauses'] : array();
                    $result['courses'][$key]['workouts']     = (!empty($parse_data['workouts'])) ? $parse_data['workouts'] : array();
                    $result['courses'][$key]['nutritions']   = (!empty($parse_data['nutritions'])) ? $parse_data['nutritions'] : array();
                    $result['courses'][$key]['percent_done'] = (is_numeric($parse_data['percent_done'])) ? $parse_data['percent_done'] : null;
                    $result['courses'][$key]['color_done']   = (!empty($parse_data['color_done'])) ? $parse_data['color_done'] : null;

                    $result['courses_percent_done'] = (empty($result['courses_percent_done']) and is_numeric($parse_data['courses_percent_done'])) ? true : $result['courses_percent_done'];

                    $result['events'] = (!empty($parse_data['events'])) ? array_merge($result['events'], $parse_data['events']) : $result['events'];

                    $result['available_workout']  = (!empty($parse_data['available_workout'])) ? $parse_data['available_workout'] : $result['available_workout'];
                    $result['next_training']      = (!empty($parse_data['next_training'])) ? $parse_data['next_training'] : $result['next_training'];
                    $result['available_postpone'] = (!empty($parse_data['workouts'])) ? true : $result['available_postpone'];

                    $next_training = $parse_data['var_next_training'];
                    $next_training_date = $parse_data['var_next_training_date'];
                    $ei = $parse_data['var_ei'];
                    $color = $parse_data['var_color'];

                    //print_r($result); echo '<br/>';
                }
                unset($ei);
                unset($course);
            }
            elseif ($sel_courses === false)
            {
                parent::logDbMessages(__METHOD__.':'.__LINE__);
            }

            // Заблокированные курсы
            $sel_bl_courses = $this->db->query('
                SELECT `uc_id`, `uc_course_id`, `uc_coach_id`, `uc_days`, `uc_date_start`, `uc_date_end`, `uc_blocked`, 
                    `uc_blocked_date`, `uc_blocked_reason`, `uc_paused`, `uc_pause_days`, `uc_display`, 
                    `crs_image`, `crs_name`, `crs_description`, `crs_count_weeks`, `crs_count_days`, `crs_category` 
                FROM `users_courses` 
                LEFT JOIN `courses` ON `uc_course_id`=`crs_id`
                WHERE `uc_user_id`=? and `uc_blocked`=1', $user_id);
            if ($sel_bl_courses !== false and 0 < $sel_bl_courses->num_rows())
            {
                $tmp_date = new DateTime($date);
                $today    = $tmp_date->format('Y-m-d');
                $tmp_date->sub(new DateInterval('P7D'));
                // Дата неделю назад от текущей даты
                $week_ago = $tmp_date->format('Y-m-d');

                $i = 0;
                foreach ($sel_bl_courses->result() as $row)
                {
                    $result['blocked_courses'][$i] = self::parseUserCourseData($row, $today);

                    $i++;
                }
                unset($row);
                unset($i);
                $sel_bl_courses->free_result();

                // Тренеры курса
                foreach ($result['blocked_courses'] as $key => $bl_course)
                {
                    $result['blocked_courses'][$key] = array_merge($result['blocked_courses'][$key], self::getCourseCoaches($bl_course['course_id']));
                }
                unset($bl_course);

                $ei = 0;
                // Паузы в тренировках и тренировки пользователя
                foreach ($result['blocked_courses'] as $key => $bl_course)
                {
                    $parse_data = self::parseUserCourseWorkoutsData($bl_course, $key, $color, $ei, $next_training, $next_training_date, $user_training_time, $ingestions, $date);

                    //print_r($parse_data); echo '<br/><br/>';

                    $result['blocked_courses'][$key]['pauses']       = (!empty($parse_data['pauses'])) ? $parse_data['pauses'] : array();
                    $result['blocked_courses'][$key]['workouts']     = (!empty($parse_data['workouts'])) ? $parse_data['workouts'] : array();
                    $result['blocked_courses'][$key]['nutritions']   = (!empty($parse_data['nutritions'])) ? $parse_data['nutritions'] : array();
                    $result['blocked_courses'][$key]['percent_done'] = (is_numeric($parse_data['percent_done'])) ? $parse_data['percent_done'] : null;
                    $result['blocked_courses'][$key]['color_done']   = (!empty($parse_data['color_done'])) ? $parse_data['color_done'] : null;

                    $result['courses_percent_done'] = (empty($result['courses_percent_done']) and is_numeric($parse_data['courses_percent_done'])) ? true : $result['courses_percent_done'];

                    $result['events'] = (!empty($parse_data['events'])) ? array_merge($result['events'], $parse_data['events']) : $result['events'];

                    $result['available_workout'] = (!empty($parse_data['available_workout'])) ? $parse_data['available_workout'] : $result['available_workout'];
                    $result['next_training']     = (!empty($parse_data['next_training'])) ? $parse_data['next_training'] : $result['next_training'];

                    $next_training = $parse_data['var_next_training'];
                    $next_training_date = $parse_data['var_next_training_date'];
                    $ei = $parse_data['var_ei'];
                    $color = $parse_data['var_color'];
                }
                unset($ei);
                unset($course);
            }
            elseif ($sel_bl_courses === false)
            {
                parent::logDbMessages(__METHOD__.':'.__LINE__);
            }
        }
        // Завершенные курсы
        elseif($courses_type == 'finished' and is_numeric($user_id))
        {
            $tmp_date = new DateTime($date);
            $today    = $tmp_date->format('Y-m-d');

            $sel_courses = $this->db->query('
                SELECT `uc_id`, `uc_course_id`, `uc_coach_id`, `uc_days`, `uc_date_start`, `uc_date_end`, `uc_blocked`, 
                    `uc_blocked_date`, `uc_blocked_reason`, `uc_paused`, `uc_pause_days`, `uc_display`, 
                    `crs_image`, `crs_name`, `crs_description`, `crs_count_weeks`, `crs_count_days`, `crs_category` 
                FROM `users_courses` 
                LEFT JOIN `courses` ON `uc_course_id`=`crs_id`
                WHERE `uc_user_id`=? and `uc_blocked`=0 and `uc_date_end`<? and `uc_date_end`<>"0000-00-00"
                ORDER BY `uc_date_end` DESC', array($user_id, $today));

            if ($sel_courses !== false and 0 < $sel_courses->num_rows())
            {
                $i = 0;
                foreach ($sel_courses->result() as $row)
                {
                    $result['courses'][$i]['id']             = $row->uc_id;
                    $result['courses'][$i]['course_id']      = $row->uc_course_id;
                    $result['courses'][$i]['category']       = $row->crs_category;
                    $result['courses'][$i]['image']          = !empty($row->crs_image) ? mb_substr($row->crs_image, 1) : '';
                    $result['courses'][$i]['name']           = $row->crs_name;
                    $result['courses'][$i]['description']    = $row->crs_description;
                    $result['courses'][$i]['course_days']    = $row->crs_count_days;
                    $result['courses'][$i]['count_weeks']    = $row->crs_count_weeks;
                    $result['courses'][$i]['count_days']     = $row->crs_count_days;
                    $result['courses'][$i]['user_coach']     = $row->uc_coach_id;
                    $result['courses'][$i]['days']           = $row->uc_days != 0 ? str_split($row->uc_days) : null;
                    $result['courses'][$i]['date_start']     = $row->uc_date_start;
                    $result['courses'][$i]['date_end']       = $row->uc_date_end;
                    $result['courses'][$i]['blocked']        = $row->uc_blocked;
                    $result['courses'][$i]['blocked_reason'] = $row->uc_blocked_reason;
                    $result['courses'][$i]['blocked_date']   = $row->uc_blocked_date;
                    $result['courses'][$i]['paused']         = $row->uc_paused;
                    $result['courses'][$i]['pause_days']     = $row->uc_pause_days;
                    $result['courses'][$i]['display']        = $row->uc_display;
                    $result['courses'][$i]['finished']       = ($row->uc_date_end !== "0000-00-00" and $row->uc_date_end < $today) ? ' (Завершен)' : '';

                    $i++;
                }
                unset($row);
                unset($i);
                $sel_courses->free_result();

                // Тренеры курса
                foreach ($result['courses'] as $key => $course) {
                    $result['courses'][$key] = array_merge($result['courses'][$key], self::getCourseCoaches($course['course_id']));
                }
                unset($course);
            }
        }

        return $result;
    }

    /**
     * Обработка данных курса пользователя
     *
     * @param $row
     * @param $today
     * @return array
     */
    public function parseUserCourseData($row, $today)
    {
        $result['id']             = $row->uc_id;
        $result['course_id']      = $row->uc_course_id;
        $result['category']       = $row->crs_category;
        $result['image']          = (!empty($row->crs_image)) ? mb_substr($row->crs_image, 1) : '';
        $result['name']           = $row->crs_name;
        $result['description']    = $row->crs_description;
        $result['course_days']    = $row->crs_count_days;
        $result['count_weeks']    = $row->crs_count_weeks;
        $result['count_days']     = $row->crs_count_days;
        $result['user_coach']     = $row->uc_coach_id;
        $result['days']           = ($row->uc_days != 0) ? str_split($row->uc_days) : null;
        $result['time']           = (!empty($row->uc_time)) ? $row->uc_time : null;
        $result['date_start']     = $row->uc_date_start;
        $result['date_end']       = $row->uc_date_end;
        $result['blocked']        = $row->uc_blocked;
        $result['blocked_reason'] = $row->uc_blocked_reason;
        $result['blocked_date']   = $row->uc_blocked_date;
        $result['paused']         = $row->uc_paused;
        $result['pause_days']     = $row->uc_pause_days;
        $result['display']        = $row->uc_display;
        $result['finished']       = ($row->uc_date_end !== "0000-00-00" and $row->uc_date_end < $today) ? ' (Завершен)' : '';

        return $result;
    }

    /**
     * Обработка данных тренировок курса пользователя
     *
     * @param $course
     * @param $key
     * @param $color
     * @param $ei
     * @param $next_training
     * @param $next_training_date
     * @param $user_training_time
     * @param $ingestions
     * @param $date
     * @return mixed
     */
    public function parseUserCourseWorkoutsData($course, $key, $color, $ei, $next_training, $next_training_date, $user_training_time, $ingestions, $date)
    {
        $tmp_date   = DateTime::createFromFormat('Y-m-d H:i:s', $date);
        $today      = $tmp_date->format('Y-m-d');
        $workouts   = null;
        $nutritions = null;
        $pauses     = null;
        $events     = null;
        $percent_workouts_done = null;

        // Паузы тренировок
        $sel_course_pauses = $this->db->query('
            SELECT `ucp_pause_start`, `ucp_pause_end` 
            FROM `users_courses_pauses`
            WHERE `ucp_uc_id`=?', $course['id']);
        if ($sel_course_pauses !== false and 0 < $sel_course_pauses->num_rows())
        {
            $i = 0;
            foreach ($sel_course_pauses->result() as $row)
            {
                $pauses[$i]['start'] = $row->ucp_pause_start;
                $pauses[$i]['end']   = $row->ucp_pause_end;

                $i++;
            }
            unset($row);
            unset($i);
        }
        elseif ($sel_course_pauses === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        // !!! Если выбраны тренировочные дни, проверить тренировки, паузы
        if (is_array($course['days']) and $course['category'] == 'workout')
        {
            // Массив дней недели тренировок, выбранные пользователем
            $array_training_days = $course['days'];
            // Флаг начала отсчета дат после заморозки
            $set_start_date = true;
            //log_message('debug', 'Array training days: ' . print_r($array_training_days, true));

            // Добавление пропущенный тренировок в БД
            if($course['blocked'] == 0)
            {
                $up_missed = $this->db->query('UPDATE `users_training_weeks` SET `utw_status`="missed", `utw_date_update`=? 
                    WHERE `utw_uc_id`=? and `utw_date`<? and `utw_status`=""', array($date, $course['id'], $today));
                if($up_missed !== false and 0 < $this->db->affected_rows())
                {
                    // Изменение нумерации тренировок
                    $up_workouts = $this->db->query('UPDATE `users_training_weeks` SET `utw_crs_workout`=(`utw_crs_workout`-1), `utw_date_update`=? 
                        WHERE `utw_uc_id`=? and `utw_date`>=?', array($date, $course['id'], $today));
                    if($up_workouts === false)
                    {
                        parent::logDbMessages(__METHOD__.':'.__LINE__);
                    }
                }
                elseif($up_missed === false)
                {
                    parent::logDbMessages(__METHOD__.':'.__LINE__);
                }

                /*$sel_f_workout = $this->db->query('
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
                    //log_message('debug', 'Start missed date: ' . print_r($start_missed_date, true));

                    // Разница между датами
                    $datetime1   = new DateTime($today);
                    $datetime2   = new DateTime($start_missed_date);
                    $interval    = $datetime1->diff($datetime2);
                    $days_missed = $interval->format('%a');
                    //log_message('debug', 'Days missed: ' . print_r($days_missed, true));

                    $training_date = $start_missed_date;
                    for ($i = 0; $i <= $days_missed; $i++)
                    {
                        // Если дата тренировки меньше текущей, заносим как пропущенная. Иначе прерываем цикл
                        if ($training_date < $today)
                        {
                            // Сравнения номера дня недели с днями недели тренировок. Номер дня недели текущей тренировки
                            $current_num_day = date("N", strtotime($training_date));
                            // Новая дата пропущенной тренировки
                            $new_training_date = $training_date;
                            //log_message('debug', 'New training date: ' . print_r($new_training_date, true));

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
                                if ($new_training_date == $training_date)
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
                            //log_message('debug', 'New training date2: ' . print_r($new_training_date, true));

                            // Следующая дата
                            $tmp_date = new DateTime($new_training_date);
                            $tmp_date->add(new DateInterval('P1D'));
                            $training_date = $tmp_date->format('Y-m-d');
                            //log_message('debug', 'Next training date: ' . print_r($training_date, true));

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
                    //log_message('debug', 'Missed dates: ' . print_r($missed_dates, true));
                    if (!empty($missed_dates))
                    {
                        $value = '';
                        foreach ($missed_dates as $missed_date)
                        {
                            if (!empty($value))
                            {
                                $value .= ', ';
                            }
                            $value .= '(' . $course['id'] .', 1, 1, "' . $missed_date . '", "' . $date . '")';
                        }

                        if (!empty($value))
                        {
                            $up_data = $this->db->query('
                            INSERT INTO `users_training_weeks`
                                (`utw_uc_id`, `utw_workout`, `utw_duplicate`, `utw_date`, `utw_date_update`)
                            VALUES ' . $value);
                            if ($up_data === false)
                            {
                                parent::logDbMessages(__METHOD__.':'.__LINE__);
                            }
                        }
                    }

                    unset($row);
                }
                elseif ($sel_f_workout === false)
                {
                    parent::logDbMessages(__METHOD__.':'.__LINE__);
                }*/

                // Обработка тренировок, проверка на пропущенные занятия
                // Изменение дат будущих тренировок (смещение курса)
                /*$sel_workouts = $this->db->query('
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
                                        parent::logDbMessages(__METHOD__.':'.__LINE__);
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
                    parent::logDbMessages(__METHOD__.':'.__LINE__);
                }
                $sel_workouts->free_result();*/

                // Изменение окончания даты тренировок курса
                // Дата последней тренировки курса
                /*$sel_last_w_date = $this->db->query('
                SELECT `utw_uc_id`, `utw_date`
                FROM `users_training_weeks`
                WHERE `utw_duplicate`=0 and `utw_uc_id`=?
                ORDER BY `utw_date` DESC LIMIT 1', $course['id']);
                if ($sel_last_w_date !== false and 1 == $sel_last_w_date->num_rows())
                {
                    $row = $sel_last_w_date->row();
                    $last_w_date = $row->utw_date;

                    $up_data = $this->db->query('
                    UPDATE `users_courses` SET `uc_date_end`=?
                    WHERE `uc_id`=? and `uc_date_end`<? LIMIT 1', array($last_w_date, $course['id'], $last_w_date));
                    if ($up_data === false)
                    {
                        parent::logDbMessages(__METHOD__.':'.__LINE__);
                    }

                    unset($row);
                }
                elseif ($sel_last_w_date === false)
                {
                    parent::logDbMessages(__METHOD__.':'.__LINE__);
                }*/
            }

            // Выборка расписания тренировок
            $sel_workouts = $this->db->query('
                SELECT `utw_id`, `utw_uc_id`, `utw_workout`, `utw_crs_workout`, `utw_status`, `utw_date`, `utw_time`
                FROM `users_training_weeks`
                WHERE `utw_uc_id`=?
                ORDER BY `utw_date`', $course['id']);
            if ($sel_workouts !== false and 0 < $sel_workouts->num_rows())
            {
                $i = 0;
                $workouts_done = 0;
                $total_count_workouts = $course['count_weeks'] * $course['count_days'];
                foreach ($sel_workouts->result() as $row)
                {
                    $workouts[$i]['id']      = $row->utw_id;
                    $workouts[$i]['workout'] = $row->utw_crs_workout;
                    $workouts[$i]['done']    = ($row->utw_status == 'done') ? 1 : 0;
                    $workouts[$i]['missed']  = ($row->utw_status == 'missed') ? 1 : 0;
                    $workouts[$i]['date']    = $row->utw_date;
                    $workouts[$i]['time']    = ($row->utw_time != "00:00:00") ? $row->utw_time : null;

                    $workouts_done = ($row->utw_status == 'done') ? $workouts_done + 1 : $workouts_done;

                    $i++;
                }
                unset($row);
                unset($i);

                $percent_workouts_done = (is_numeric($workouts_done)) ? ($workouts_done * 100 / $total_count_workouts) : 0;

                $type_shade = ($key % 2 == 0 and $course['id'] % 2 == 1) ? 'lighter' : '';
                $rgb = self::different_shade($color, $type_shade);
                $color = $rgb;
                $color_workouts_done = $rgb;
            }
            elseif ($sel_workouts === false)
            {
                parent::logDbMessages(__METHOD__.':'.__LINE__);
            }
        }
        // Выборка расписания питания
        elseif($course['category'] == 'nutrition')
        {
            $sel_nutritions = $this->db->query('
                SELECT `un_id`, `un_cds_day`, `un_cds_ci_id`, `un_ml_id`, `un_date`, 
                  `ml_name`, `ml_weight`, `ml_proteins`, `ml_fats`, `ml_carbohydrates`, `ml_calories` 
                FROM `users_nutritions`
                LEFT JOIN `meals` ON `ml_id`=`un_ml_id`
                WHERE `un_uc_id`=?
                ORDER BY `un_date`', $course['id']);
            if ($sel_nutritions !== false and 0 < $sel_nutritions->num_rows())
            {
                $day = 0;
                $ingestion = 0;

                $i = 0;
                foreach ($sel_nutritions->result() as $row)
                {
                    if($day != $row->un_cds_day or $ingestion != $row->un_cds_ci_id)
                    {
                        $nutritions[$i]['id']        = $row->un_id;
                        $nutritions[$i]['day']       = $row->un_cds_day;
                        $nutritions[$i]['ingestion'] = $row->un_cds_ci_id;
                        $nutritions[$i]['meal_id']   = !empty($row->un_ml_id) ? $row->un_ml_id : null;
                        $nutritions[$i]['meal_name'] = $row->ml_name . ' [БЖУК - ' . $row->ml_proteins . ' '
                            . $row->ml_fats .  ' ' . $row->ml_carbohydrates . ' ' . $row->ml_caloreis . ']';
                        $nutritions[$i]['date']      = $row->un_date;
                        $nutritions[$i]['done']      = ($row->un_date < $today) ? 1 : 0;

                        $day = $row->un_cds_day;
                        $ingestion = $row->un_cds_ci_id;

                        $i++;
                    }
                }
                unset($row);
                unset($i);
            }
            elseif ($sel_nutritions === false)
            {
                parent::logDbMessages(__METHOD__.':'.__LINE__);
            }
        }

        // СОБЫТИЯ КАЛЕНДАРЯ
        if($course['display'] == 1)
        {
            // Паузы в курсе
            if (!empty($pauses) and !empty($course['days']))
            {
                foreach ($pauses as $pause)
                {
                    // Начало заморозки
                    $temp_date = DateTime::createFromFormat('Y-m-d H:i:s', $pause['start']);
                    $pause_start = $temp_date->format('Y-m-d');
                    // Окончание заморозки
                    $temp_date = DateTime::createFromFormat('Y-m-d H:i:s', $pause['end']);
                    $pause_end = $temp_date->format('Y-m-d');

                    if (empty($events) or $pause_start != $events[$ei - 1]['start'])
                    {
                        $events[$ei]['constraint'] = 'pause';
                        $events[$ei]['start']      = $pause_start;
                        $events[$ei]['end']        = $pause_end;
                        $events[$ei]['pause']      = true;
                        $events[$ei]['done']       = null;

                        $ei++;
                    }
                }
                unset($pause);
            }

            // Тренировки
            if (!empty($workouts) and !empty($course['days']))
            {
                // Флаг доступного тренировочного дня
                $available_training = false;

                // Данные курса тренировок
                $course_data  = self::getCourse($course['course_id']);

                $type_shade = ($key % 2 == 0) ? 'lighter' : '';
                $rgb = self::different_shade($color, $type_shade);
                $color = $rgb;

                foreach ($workouts as $workout)
                {
                    // Выполнено ли занятие
                    $w_done   = $workout['done'];
                    $w_date   = $workout['date'];
                    $w_time   = $workout['time'];
                    $w_missed = $workout['missed'];
                    $w_num    = $workout['workout'];

                    $events[$ei]['constraint']     = 'workout';
                    $events[$ei]['blocked']        = ($course['blocked'] == 1) ? 'true' : 'false';
                    $events[$ei]['workout_id']     = $workout['id'];
                    $events[$ei]['instruction_id'] = $course_data['course']['instruction']['video_id'];
                    $events[$ei]['color']          = 'rgba(' . $rgb[0] . ', ' . $rgb[1] . ', ' . $rgb[2] . ', 1)';
                    $events[$ei]['done']           = 'not_done';
                    $events[$ei]['missed']         = 'not_missed';
                    $events[$ei]['start']          = '';
                    $events[$ei]['end']            = '';

                    // Только одно видео доступно
                    if ($w_date < $today or $available_training === true)
                    {
                        $events[$ei]['id'] = '';
                    }
                    elseif ($w_date == $today and $available_training === false)
                    {
                        $events[$ei]['id'] = $course_data['course']['workouts'][$w_num]['video_id'];
                        $available_training = true;
                        $result['available_workout'] = true;
                    }

                    // Дата следующей тренировки
                    if($w_date >= $today and ($next_training === false or $w_date < $next_training_date))
                    {
                        setlocale(LC_ALL, 'ru_RU.UTF-8');
                        $tmp_w_date = DateTime::createFromFormat('Y-m-d', $w_date);
                        $week_day = ($tmp_w_date !== false) ? parent::RussianWeekday($tmp_w_date->format('D')) : '';
                        $week_day = (!empty($week_day)) ? $week_day . '., ' : '';
                        $next_w_date = ($tmp_w_date !== false)
                            ? $week_day . $tmp_w_date->format('j') . ' ' . parent::declensionRussianMonths($tmp_w_date->format('n'))
                            : '';

                        $result['next_training'] = $next_w_date;
                        $next_training = true;
                        $next_training_date = $w_date;
                    }

                    $events[$ei]['title'] = $course_data['course']['name'];
                    /*$events[$ei]['title'] = ($w_missed == 1)
                        ? 'Пропущенное занятие'
                        : $course_data['course']['name']; */
                    // $course_data['course']['workouts'][$w_num]['video_name']
                    if(!empty($w_time))
                    {
                        $events[$ei]['start'] = $w_date . 'T' . $w_time;
                    }
                    else
                    {
                        $events[$ei]['start'] = (!empty($user_training_time))
                            ? $w_date . 'T' . $user_training_time['from']
                            : $w_date;
                        $events[$ei]['end']   = (!empty($user_training_time))
                            ? $w_date . 'T' . $user_training_time['to']
                            : $w_date;
                    }

                    if ($w_done == 1)
                    {
                        $events[$ei]['done']  = 'done';
                        $events[$ei]['color'] = '#99e600'; // 147, 147, 147, 0.5 #91da00 rgba(159, 220, 39, 0.7)
                    }
                    elseif ($w_missed == 1)
                    {
                        $events[$ei]['missed'] = 'missed';
                        $events[$ei]['color'] = '#ff8c8c'; // #ff8c8c rgba(255, 159, 137, 0.5)
                    }

                    $ei++;
                }
                unset($workout);

                // Если есть активное видео на сегодня, то не выводить дату следующей тренировки
                if($available_training === true)
                {
                    $result['next_training'] = null;
                }
            }

            // Питание
            if(!empty($nutritions))
            {
                $course_ingestions = self::getNutritionIngestions($course['course_id']);
                $course_first_meal = self::getNutritionIngestionsFirstMeal($course['course_id']);

                $type_shade = $course['id'] % 2 == 0 ? 'lighter' : '';
                $rgb = self::different_shade($color, $type_shade);
                $color = $rgb;

                foreach ($nutritions as $nutrition)
                {
                    // Выполнено ли занятие
                    $w_done      = $nutrition['done'];
                    $w_date      = $nutrition['date'];
                    $w_day       = $nutrition['day'];
                    $w_ingestion = $nutrition['ingestion'];

                    $events[$ei]['constraint'] = 'nutrition';
                    $events[$ei]['blocked']    = ($course['blocked'] == 1) ? 'true' : 'false';
                    $events[$ei]['id']         = $nutrition['id'];
                    $events[$ei]['day']        = $w_day;
                    $events[$ei]['ingestion']  = $w_ingestion;
                    $events[$ei]['color']      = 'rgba(' . $rgb[0] . ', ' . $rgb[1] . ', ' . $rgb[2] . ', 1)';
                    $events[$ei]['done']       = 'not_done';
                    $events[$ei]['missed']     = 'not_missed';

                    if(!empty($nutrition['meal_id']))
                    {
                        $events[$ei]['ml_id'] = $nutrition['meal_id'];
                    }
                    else
                    {
                        $events[$ei]['ml_id'] = $course_first_meal['meal'][$w_day][$w_ingestion]['id'];
                    }

                    $ing_id  = (!empty($ingestions)) ? array_search($w_ingestion, $ingestions['ingestions_id']) : false;
                    $events[$ei]['title'] = ($ing_id !== false) ? $ingestions['ingestions'][$ing_id]['name'] : '';

                    // Дата и время события
                    $crs_ing_id  = (!empty($course_ingestions)) ? array_search($w_ingestion, $course_ingestions['course_ingestions_id']) : false;

                    $events[$ei]['start'] = ($crs_ing_id !== false)
                        ? $w_date . 'T' . $course_ingestions['course_ingestions'][$crs_ing_id]['time_from'] : $w_date;
                    $events[$ei]['end']   = ($crs_ing_id !== false)
                        ? $w_date . 'T' . $course_ingestions['course_ingestions'][$crs_ing_id]['time_to'] : $w_date;

                    if ($w_done == 1)
                    {
                        $events[$ei]['done']  = 'done';
                        $events[$ei]['color'] = 'rgba(147, 147, 147, 0.5)';
                    }


                    $ei++;
                }
                unset($nutrition);
            }
        }

        $result['pauses']       = (!empty($pauses)) ? $pauses : array();
        $result['workouts']     = (!empty($workouts)) ? $workouts : array();
        $result['nutritions']   = (!empty($nutritions)) ? $nutritions : array();
        $result['percent_done'] = (is_numeric($percent_workouts_done)) ? $percent_workouts_done : null;
        $result['color_done']   = (!empty($color_workouts_done)) ? $color_workouts_done[0].','.$color_workouts_done[1].','.$color_workouts_done[2] : null;
        $result['events']       = (!empty($events)) ? $events : array();

        $result['courses_percent_done'] = $percent_workouts_done;

        $result['var_next_training'] = $next_training;
        $result['var_next_training_date'] = $next_training_date;
        $result['var_ei'] = $ei;
        $result['var_color'] = $color;

        return $result;
    }

    /**
     * Проверка и блокировка курса пользователя, если бесплатные недели промокода закончились
     *
     * @param $user_id
     * @param $date
     * @return bool
     * @throws Exception
     */
    public function checkUserCoursesFreeWeeks($user_id, $date)
    {
        $result = true;

        $tmp_date   = new DateTime($date);
        $short_date = ($tmp_date !== false) ? $tmp_date->format('Y-m-d') : '';
        $reason     = 'free_weeks_over';

        $up_data = $this->db->query('UPDATE `users_courses` SET `uc_blocked`=1, `uc_blocked_date`=?, `uc_blocked_reason`=? 
            WHERE `uc_user_id`=? and `uc_blocked`=0 and `uc_free_weeks`>0 and `uc_free_weeks_end_date`<=? and `uc_free_weeks_end_date`<>"0000-00-00"',
                array($date, $reason, $user_id, $short_date));
        if($up_data === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
            $result = false;
        }

        return $result;
    }

    /**
     * Дата следующей тренировки
     *
     * @param $user_id
     * @param $date
     * @return array
     */
    public function getNextUserWorkout($user_id, $date)
    {
        $result = array('next_workout' => '', 'uc_id' => '');

        $tmp_date = new DateTime($date);
        $date = $tmp_date->format('Y-m-d');

        $sel_data = $this->db->query('
            SELECT `utw_date`, `uc_user_id`, `uc_id`, `uc_display`, `uc_blocked` 
            FROM `users_training_weeks`
             LEFT JOIN `users_courses` ON `uc_id`=`utw_uc_id`
            WHERE `uc_user_id`=? and `uc_blocked`=0 and `uc_display`=1 and `utw_date`>=? and `utw_status`=""
            ORDER BY `utw_date` ASC LIMIT 1', array($user_id, $date));
        if($sel_data !== false and 1 == $sel_data->num_rows())
        {
            $row = $sel_data->row();

            $next_w_date = 'Сегодня';
            if($row->utw_date !== $date)
            {
                setlocale(LC_ALL, 'ru_RU.UTF-8');
                $tmp_w_date = DateTime::createFromFormat('Y-m-d', $row->utw_date);
                $week_day = ($tmp_w_date !== false) ? parent::RussianWeekday($tmp_w_date->format('D')) : '';
                $week_day = (!empty($week_day)) ? $week_day . '., ' : '';
                $next_w_date = ($tmp_w_date !== false)
                    ? $week_day . $tmp_w_date->format('j') . ' ' . parent::declensionRussianMonths($tmp_w_date->format('n'))
                    : '';
            }

            $result['next_workout'] = $next_w_date;
            $result['uc_id']        = $row->uc_id;
        }
        elseif($sel_data === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Данные о тренировках этой недели всех активных курсов, выводимых в календарь
     *
     * @param $user_id
     * @param $today
     * @return array
     * @throws Exception
     */
    public function getUserCoursesWeekWorkouts($user_id, $today)
    {
        $result = array();

        $current_num_day = date("N", strtotime($today));
        $tmp_date        = new DateTime($today);
        $interval        = 7 - $current_num_day;
        $today           = ($tmp_date !== false) ? $tmp_date->format('Y-m-d') : false;
        $end_date        = ($tmp_date !== false) ? $tmp_date->add(new DateInterval('P'.$interval.'D'))->format('Y-m-d') : false;
        $start_date      = ($end_date !== false) ? $tmp_date->sub(new DateInterval('P6D'))->format('Y-m-d') : false;

        if(is_numeric($user_id) and $start_date and $end_date)
        {
            $sel_data = $this->db->query('
                SELECT `utw_id`, `utw_workout`, `utw_crs_workout`, `utw_status`, `utw_date`, `utw_time`, `uc_user_id`, `uc_course_id`, 
                  `uc_display`, `uc_id`, `uc_date_end`, `crs_name`, `crs_count_weeks`, `crs_count_days`, `crs_count_rest` 
                FROM `users_training_weeks`
                LEFT JOIN `users_courses` ON `uc_id`=`utw_uc_id`
                LEFT JOIN `courses` ON `crs_id`=`uc_course_id`
                WHERE `uc_user_id`=? and `uc_display`=1 and `uc_blocked`=0 and `uc_date_end`>=? and (`utw_date`>=? and `utw_date`<=?)
                LIMIT 7',
                    array($user_id, $today, $start_date, $end_date));
            if($sel_data !== false and 0 < $sel_data->num_rows())
            {
                $i = 0;
                foreach($sel_data->result() as $row)
                {
                    $num_day = date("N", strtotime($row->utw_date));

                    if($row->utw_status != 'done')
                    {
                        $result['tw_wo'][$row->uc_id]['available_days'][$i] = $num_day;
                    }

                    $result['tw_wo'][$row->uc_id]['crs_name']    = $row->crs_name;
                    $result['tw_wo'][$row->uc_id]['count_weeks'] = $row->crs_count_weeks;
                    $result['tw_wo'][$row->uc_id]['count_days']  = $row->crs_count_days;
                    $result['tw_wo'][$row->uc_id]['count_rest']  = $row->crs_count_rest;
                    $result['tw_wo'][$row->uc_id]['days'][$i]    = $num_day;
                    $result['tw_wo'][$row->uc_id]['missed']      = 0;
                    $result['tw_wo'][$row->uc_id]['wos'][$num_day]['num_day']   = $num_day;
                    $result['tw_wo'][$row->uc_id]['wos'][$num_day]['id']        = $row->utw_id;
                    $result['tw_wo'][$row->uc_id]['wos'][$num_day]['wo_id']     = $row->utw_workout;
                    $result['tw_wo'][$row->uc_id]['wos'][$num_day]['crs_wo_id'] = $row->utw_crs_workout;
                    $result['tw_wo'][$row->uc_id]['wos'][$num_day]['status']    = $row->utw_status;
                    $result['tw_wo'][$row->uc_id]['wos'][$num_day]['date']      = $row->utw_date;
                    $result['tw_wo'][$row->uc_id]['wos'][$num_day]['time']      = mb_substr($row->utw_time, 0, 5);
                    $result['tw_wo'][$row->uc_id]['wos'][$num_day]['update']    = false;

                    if($row->utw_status == 'missed')
                    {
                        $result['tw_wo'][$row->uc_id]['missed']++;
                    }

                    $i++;
                }
                unset($row);
            }
            elseif($sel_data === false)
            {
                parent::logDbMessages(__METHOD__.':'.__LINE__);
            }
        }

        return $result;
    }

    /**
     * Перенос тренировок курса текущей недели
     *
     * @param $user_id
     * @param $workouts
     * @param $date
     * @return bool
     */
    public function postponeUserCourseWeekWorkouts($user_id, $workouts, $date)
    {
        $result = true;

        if(is_numeric($user_id) and !empty($workouts['tw_wo']))
        {
            foreach ($workouts['tw_wo'] as $user_course_id => $crs)
            {
                foreach ($crs['wos'] as $day => $wo)
                {
                    if($wo['update'] === true)
                    {
                        $up_data = $this->db->query('
                            UPDATE `users_training_weeks` SET `utw_crs_workout`=?, `utw_date`=?, `utw_time`=?, `utw_status`=?, `utw_date_update`=? 
                            WHERE `utw_id`=? and `utw_uc_id`=? LIMIT 1',
                                array($wo['crs_wo_id'], $wo['date'], $wo['time'], $wo['status'], $date, $wo['id'], $user_course_id));
                        if($up_data === false)
                        {
                            parent::logDbMessages(__METHOD__.':'.__LINE__);
                            $result = false;
                        }
                    }
                }
                unset($wo);

                self::shiftUserCourseNumWorkouts($user_course_id);
            }
            unset($crs);
            unset($user_course_id);
        }

        return $result;
    }

    /**
     * Смещение номера тренировки курса пользователя
     *
     * @param $user_course_id
     * @return bool
     */
    public function shiftUserCourseNumWorkouts($user_course_id)
    {
        $result = true;

        $sel_data = $this->db->query('SELECT `utw_id`, `utw_crs_workout`, `utw_status`, `utw_date` 
            FROM `users_training_weeks` 
            WHERE `utw_uc_id`=? ORDER BY `utw_date` ASC', $user_course_id);
        if($sel_data !== false and 0 < $sel_data->num_rows())
        {
            $sel_data = $sel_data->result();
            foreach ($sel_data as $key => $row)
            {
                if($key > 0 and $sel_data[$key-1]->utw_status == '' and $row->utw_crs_workout == $sel_data[$key-1]->utw_crs_workout)
                {
                    $up_data = $this->db->query('UPDATE `users_training_weeks` SET `utw_crs_workout`=(`utw_crs_workout`+1) 
                        WHERE `utw_id`=? LIMIT 1', $row->utw_id);
                    if($up_data !== false and 1 == $this->db->affected_rows())
                    {
                        $sel_data[$key]->utw_crs_workout = $row->utw_crs_workout + 1;
                    }
                    if($up_data === false)
                    {
                        parent::logDbMessages(__METHOD__.':'.__LINE__);
                        $result = false;
                    }
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
     * Смещение расписания тренировок курса пользователя
     *
     * @param $user_id
     * @param $order_id
     * @param $course_id
     * @param $date
     * @return bool
     * @throws Exception
     */
    public function shiftUserCourseWorkouts($user_id, $order_id, $course_id, $date)
    {
        $result = false;
        $values = '';
        $new_course_end = '';

        $sel_data = $this->db->query('SELECT `uc_id`, `uc_days`, `uc_time` FROM `users_courses` WHERE `uc_user_id`=? and `uc_o_id`=? and `uc_course_id`=? LIMIT 1', array($user_id, $order_id, $course_id));
        if($sel_data !== false and 1 == $sel_data->num_rows())
        {
            $row = $sel_data->row();
            $user_course_id = $row->uc_id;
            $array_training_days = (!empty($row->uc_days)) ? str_split($row->uc_days) : null;
            $arr_training_times = array();
            $i_times = (!empty($row->uc_time)) ? explode(';', $row->uc_time) : null;
            if(!empty($array_training_days) and !empty($i_times))
            {
                foreach ($array_training_days as $key => $day)
                {
                    $arr_training_times[$day] = $i_times[$key];
                }
                unset($day);
            }
            unset($row);

            // Обновление дат тренировок
            $tmp_date = new DateTime($date);
            $today = ($tmp_date !== false) ? $tmp_date->format('Y-m-d') : null;
            unset($tmp_date);

            if($today)
            {
                // Первая не перенесенная тренировка
                $sel_one = $this->db->query('
                    SELECT `utw_id`, `utw_workout` FROM `users_training_weeks` WHERE `utw_uc_id`=? and `utw_date`<? and `utw_status`=""
                    ORDER BY `utw_workout` LIMIT 1', array($user_course_id, $today));
                if($sel_one !== false and 1 == $sel_one->num_rows())
                {
                    $row = $sel_one->row();
                    $first_wo = $row->utw_workout;
                    unset($row);

                    $sel_all = $this->db->query('
                        SELECT `utw_id`, `utw_workout`, `utw_date`, `utw_time` FROM `users_training_weeks` 
                        WHERE `utw_uc_id`=? and ((`utw_date`<? and `utw_status`="") or (`utw_date`>=? and `utw_status`=""))
                        ORDER BY `utw_workout`', array($user_course_id, $today, $today));
                    if($sel_all !== false and 0 < $sel_all->num_rows())
                    {
                        // Номер дня недели сегодня
                        $current_num_day = date("N", strtotime($today));

                        // Вычисление даты начала смещения курса
                        if (is_array($array_training_days) and !in_array($current_num_day, $array_training_days))
                        {
                            // Поиск большего номера дня недели и вычисление его даты
                            foreach ($array_training_days as $key => $training_day)
                            {
                                if ($training_day > $current_num_day)
                                {
                                    $diff_days = $training_day - $current_num_day;

                                    $tmp_date = new DateTime($today);
                                    $tmp_date->add(new DateInterval('P' . $diff_days . 'D'));
                                    $new_course_start = ($tmp_date !== false) ? $tmp_date->format('Y-m-d') : '';

                                    break;
                                }
                            }
                            unset($training_day);

                            // Если дата начала курса не вычислилась на предыдущем этапе, выбираем первый день недели тренировки
                            // пользователя и вычисляем её дату
                            if (empty($new_course_start))
                            {
                                // От 7 дней недели отнимаем день недели предыдущей тренировки и прибавляем день недели первой тренировки на неделе
                                $diff_days = 7 - $current_num_day + $array_training_days[0];
                                // Временная дата предыдущей тренивроки
                                $tem_date = new DateTime($today);
                                // Дата текущей тренировки, с учетом разницы между тренировками ( + $diff_days дней )
                                $tem_date->add(new DateInterval('P' . $diff_days . 'D'));

                                $new_course_start = ($tem_date !== false) ? $tem_date->format('Y-m-d') : $today;
                            }
                        }
                        else
                        {
                            $new_course_start = $today;
                        }

                        $training_date = $new_course_start;
                        $training_days = $array_training_days;
                        $count_days    = count($training_days);

                        // Смещение тренировок
                        foreach($sel_all->result() as $row)
                        {
                            if ($row->utw_workout == $first_wo)
                            {
                                // Время тренировки
                                $cur_num_week  = date('N', strtotime($training_date));
                                $training_time = (!empty($arr_training_times[$cur_num_week])) ? $arr_training_times[$cur_num_week] : '';

                                $values .= '(' . $row->utw_id . ', ' . $row->utw_workout . ', "' . $training_date . '", "' . $training_time . '", "' . $date . '")';

                                $up_data = $this->db->query('
                                    UPDATE `users_training_weeks` SET `utw_date`=?, `utw_time`=?, `utw_date_update`=? 
                                    WHERE `utw_id`=? LIMIT 1', array($training_date, $training_time, $date, $row->utw_id));
                                if($up_data === false)
                                {
                                    parent::logDbMessages(__METHOD__.':'.__LINE__);
                                }
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
                                    if ($key_num_week == ($count_days - 1))
                                    {
                                        // От 7 дней недели отнимаем день недели предыдущей тренировки и прибавляем день недели первой тренировки на неделе
                                        $diff_days = 7 - $training_days[$key_num_week] + $training_days[0];
                                    }
                                    else
                                    {
                                        // Разница между текущим номером недели тренировки и предыдущем.
                                        $diff_days = $training_days[$key_num_week+1] - $training_days[$key_num_week];
                                    }

                                    // Временная дата предыдущей тренивроки
                                    $tem_date = new DateTime($training_date);
                                    // Дата текущей тренировки, с учетом разницы между тренировками ( + $diff_days дней )
                                    $tem_date->add(new DateInterval('P' . abs($diff_days) . 'D'));
                                    $training_date = ($tem_date !== false) ? $tem_date->format('Y-m-d') : '';
                                    unset($tem_date);

                                    // Время тренировки
                                    $cur_num_week  = date('N', strtotime($training_date));
                                    $training_time = (!empty($arr_training_times[$cur_num_week])) ? $arr_training_times[$cur_num_week] : '';

                                    $values .= '(' . $row->utw_id . ', ' . $row->utw_workout . ', "' . $training_date . '", "' . $training_time . '", "' . $date . '")';

                                    $up_data = $this->db->query('
                                        UPDATE `users_training_weeks` SET `utw_date`=?, `utw_time`=?, `utw_date_update`=? 
                                        WHERE `utw_id`=? LIMIT 1', array($training_date, $training_time, $date, $row->utw_id));
                                    if($up_data === false)
                                    {
                                        parent::logDbMessages(__METHOD__.':'.__LINE__);
                                    }
                                }
                            }

                            $new_course_end = (empty($new_course_end) or $new_course_end < $training_date) ? $training_date : $new_course_end;
                        }
                        unset($row);
                        
                        // Сохранение новой даты окончания курса
                        if(!empty($new_course_end))
                        {
                            $up_data = $this->db->query('
                                UPDATE `users_courses` SET `uc_date_end`=? WHERE `uc_id`=? LIMIT 1', array($new_course_end, $user_course_id));
                            if($up_data === false)
                            {
                                parent::logDbMessages(__METHOD__.':'.__LINE__);
                            }
                        }

                        // Дата начала паузы курса
                        $course_pause_start = '';
                        $sel_date = $this->db->query('
                            SELECT `utw_date` FROM `users_training_weeks` 
                            WHERE `utw_uc_id`=? and `utw_date`<? and `utw_status`<>"" 
                            ORDER BY `utw_workout` DESC LIMIT 1',
                                array($user_course_id, $today));
                        if($sel_date !== false and 1 == $sel_date->num_rows())
                        {
                            $row = $sel_date->row();

                            $tmp_date = new DateTime($row->utw_date);
                            $tmp_date->add(new DateInterval('P1D'));
                            $course_pause_start = ($tmp_date !== false) ? $tmp_date->format('Y-m-d') : '';
                        }
                        elseif($sel_date === false)
                        {
                            parent::logDbMessages(__METHOD__.':'.__LINE__);
                        }

                        // Дата окончания паузы курса
                        $tmp_date = new DateTime($today);
                        $tmp_date->sub(new DateInterval('P1D'));
                        $course_pause_end = ($tmp_date !== false) ? $tmp_date->format('Y-m-d') : '';

                        // Сохранение паузы курса
                        if(!empty($course_pause_start) and !empty($course_pause_end))
                        {
                            $up_data = $this->db->query('
                                INSERT INTO `users_courses_pauses`(`ucp_uc_id`, `ucp_pause_start`, `ucp_pause_end`) VALUES (?, ?, ?)',
                                    array($user_course_id, $course_pause_start, $course_pause_end));
                            if($up_data === false)
                            {
                                parent::logDbMessages(__METHOD__.':'.__LINE__);
                            }
                        }
                    }
                    elseif($sel_all === false)
                    {
                        parent::logDbMessages(__METHOD__.':'.__LINE__);
                    }
                }
                elseif($sel_one === false)
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
     * Выборка уведомлений курсов пользователя
     *
     * @param int $user_id
     * @param string $date
     * @return array
     * @throws Exception
     */
    public function getUserCoursesNotifications($user_id, $date)
    {
        $result = array('notifications' => array(), 'display_workout' => true, 'display_nutrition' => true);

        // Замороженные курсы из-за не успешной оплаты
        $sel_courses = $this->db->query('
            SELECT `uc_id`, `uc_course_id`, `uc_blocked`, `uc_blocked_date`, `uc_blocked_reason`, `crs_name`
            FROM `users_courses` 
            LEFT JOIN `courses` ON `uc_course_id`=`crs_id`
            WHERE `uc_user_id`=? and `uc_blocked`=1 and `uc_blocked_reason`="payment_canceled"', $user_id);
        if ($sel_courses !== false and 0 < $sel_courses->num_rows())
        {
            $tmp_date = new DateTime($date);
            $today = $tmp_date->format('Y-m-d');
            $tmp_date->sub(new DateInterval('P7D'));
            // Дата неделю назад от текущей даты
            $week_ago = $tmp_date->format('Y-m-d');

            foreach ($sel_courses->result() as $row)
            {
                $tmp_date2 = new DateTime($row->uc_blocked_date);
                $tmp_date2->add(new DateInterval('P7D'));
                // Дата через неделю от даты блокировки
                $next_week = $tmp_date2->format('Y-m-d');

                $tmp_date2->add(new DateInterval('P21D'));
                // Дата через 4 недели от даты блокировки
                $next_three_weeks = $tmp_date2->format('Y-m-d');

                //echo $row->uc_blocked_date . ' ' . $today . ' ' . $week_ago . ' ' . $next_week . ' ' . $next_three_weeks . '<br/>';

                // Вывод уведомления в течении недели после первого безуспешного проведения оплаты
                if ($row->uc_blocked_date >= $week_ago and $next_week > $today)
                {
                    setlocale(LC_ALL, 'ru_RU.UTF-8');
                    $tmp_nw = DateTime::createFromFormat('Y-m-d', $next_week);
                    $tmp_nw = ($next_week != '0000-00-00' and $tmp_nw !== false)
                        ? strftime('%d %b %Gг.', strtotime($next_week))
                        : '';

                    $result['notifications'][$row->uc_id][142]['date_attempts'] = $tmp_nw;
                    $result['notifications'][$row->uc_id][142]['course_name']   = $row->crs_name;
                }
                // Вывод уведомления в течении 3х недель после первой недели блокировки
                elseif($row->uc_blocked_date < $week_ago and $next_three_weeks > $today)
                {
                    setlocale(LC_ALL, 'ru_RU.UTF-8');
                    $tmp_nw2 = DateTime::createFromFormat('Y-m-d', $next_three_weeks);
                    $tmp_nw2 = ($next_three_weeks != '0000-00-00' and $tmp_nw2 !== false)
                        ? strftime('%d %b %Gг.', strtotime($next_three_weeks))
                        : '';

                    $result['notifications'][$row->uc_id][144]['date_attempts'] = $tmp_nw2;
                    $result['notifications'][$row->uc_id][144]['course_name']   = $row->crs_name;
                }
            }
            unset($row);
        }
        elseif ($sel_courses === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        // Заблокированные курсы по окончании бесплатных недель
        $sel_courses = $this->db->query('
            SELECT `uc_id`, `uc_course_id`, `uc_o_id`, `uc_blocked`, `uc_blocked_date`, `uc_blocked_reason`, `crs_name`
            FROM `users_courses` 
            LEFT JOIN `courses` ON `uc_course_id`=`crs_id`
            WHERE `uc_user_id`=? and `uc_blocked`=1 and `uc_blocked_reason`="free_weeks_over"', $user_id);
        if ($sel_courses !== false and 0 < $sel_courses->num_rows())
        {
            foreach ($sel_courses->result() as $row)
            {
                $result['notifications'][$row->uc_id][204]['course_name'] = $row->crs_name;
                $result['notifications'][$row->uc_id][204]['uc_id']       = $row->uc_id;
                $result['notifications'][$row->uc_id][204]['course_id']   = $row->uc_course_id;
                $result['notifications'][$row->uc_id][204]['order_id']    = $row->uc_o_id;
            }
            unset($row);
        }
        elseif ($sel_courses === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        // Неначатые курсы (данные для старта курсов не заполены)
        $sel_non_started = $this->db->query('
            SELECT `uc_id`, `uc_course_id`, `crs_name`, `crs_category`, `crs_count_weeks`, `crs_count_days`, `crs_count_rest`
            FROM `users_courses` 
            LEFT JOIN `courses` ON `uc_course_id`=`crs_id`
            WHERE `uc_user_id`=? and `crs_category`="workout" and `uc_date_start`="0000-00-00" and `uc_date_end`="0000-00-00"',
                $user_id);
        if ($sel_non_started !== false and 0 < $sel_non_started->num_rows())
        {
            foreach ($sel_non_started->result() as $row)
            {
                $result['notifications'][$row->uc_id][203]['course_name']  = $row->crs_name;
                $result['notifications'][$row->uc_id][203]['uc_id']        = $row->uc_id;
                $result['notifications'][$row->uc_id][203]['course_id']    = $row->uc_course_id;
                $result['notifications'][$row->uc_id][203]['course_weeks'] = $row->crs_count_weeks;
                $result['notifications'][$row->uc_id][203]['course_days']  = $row->crs_count_days;
                $result['notifications'][$row->uc_id][203]['course_rest']  = $row->crs_count_rest;
            }
            unset($row);
        }
        elseif ($sel_non_started === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        // Курсы, которые заканчиваются через неделю или меньше + курсы продления
        $tmp_date = new DateTime($date);
        $today = $tmp_date->format('Y-m-d');
        $tmp_date->add(new DateInterval('P8D'));
        $next_week = $tmp_date->format('Y-m-d');

        $sel_courses2 = $this->db->query('
            SELECT `uc_id`, `uc_course_id`, `uc_date_end`, `uc_ends_email`, `crs_name`
            FROM `users_courses` 
            LEFT JOIN `courses` ON `uc_course_id`=`crs_id`
            WHERE `uc_user_id`=? and `uc_blocked`=0 and `uc_date_end`>=? and `uc_date_end`<?',
                array($user_id, $today, $next_week));
        if ($sel_courses2 !== false and 0 < $sel_courses2->num_rows())
        {
            foreach ($sel_courses2->result() as $row)
            {
                $tmp_date2 = new DateTime($row->uc_date_end);

                if($row->uc_date_end == $today)
                {
                    $tmp_date4      = new DateTime($row->uc_date_end);
                    $tmp_date4->add(new DateInterval("PT23H59M59S"));
                    $date_countdown = $tmp_date4->format('U')*1000;
                }
                else
                {
                    $date_countdown = $tmp_date2->format('U')*1000;
                }

                $result['notifications'][$row->uc_id][143]['date_countdown'] = $date_countdown;
                $result['notifications'][$row->uc_id][143]['course_name']    = $row->crs_name;
                $result['notifications'][$row->uc_id][143]['send_email']     = false;

                $sel_extends = self::getUserCourseExtends($row->uc_course_id, $date);

                if(!empty($sel_extends['extends']))
                {
                    $a = 0;
                    foreach($sel_extends['extends'] as $extend)
                    {
                        // Дата отсчета продления курса с промокодом
                        $tmp_date3   = new DateTime($row->uc_date_end);
                        $tmp_date3->add(new DateInterval('P' . ($extend['weeks_after']*7) . 'D'));
                        $edcd        = $tmp_date3->format('Y-m-d');

                        if($edcd == $today)
                        {
                            $tmp_date4      = new DateTime($edcd);
                            $tmp_date4->add(new DateInterval("PT23H59M59S"));
                            $ext_date_cd = $tmp_date4->format('U')*1000;
                        }
                        else
                        {
                            $ext_date_cd = $tmp_date3->format('U')*1000;
                        }

                        // Отображаем курс продления, если окончательная дата продления не наступила
                        if(!empty($ext_date_cd))
                        {
                            $result['notifications'][$row->uc_id][143]['extends'][$a]['course_id']      = $extend['extend_id'];
                            $result['notifications'][$row->uc_id][143]['extends'][$a]['course_name']    = $extend['course_name'];
                            $result['notifications'][$row->uc_id][143]['extends'][$a]['promocode']      = $extend['promocode'];
                            $result['notifications'][$row->uc_id][143]['extends'][$a]['price']          = $extend['course_price'];
                            $result['notifications'][$row->uc_id][143]['extends'][$a]['new_price']      = $extend['course_new_price'];
                            $result['notifications'][$row->uc_id][143]['extends'][$a]['date_countdown'] = $ext_date_cd;

                            $a++;
                        }
                    }
                    unset($extend);
                }
                unset($sel_extends);

                // Отправка email с уведомлением о заканчивающемся курсе
                if($row->uc_ends_email == 0)
                {
                    $result['notifications'][$row->uc_id][143]['send_email'] = true;

                    $this->db->query('UPDATE `users_courses` SET `uc_ends_email`=1 WHERE `uc_id`=? LIMIT 1', $row->uc_id);
                }
            }
            unset($row);
        }
        elseif ($sel_courses2 === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        // Курсы закончились + курсы продления (если кол-во недель для покупки не истекло)
        $sel_courses3 = $this->db->query('
            SELECT `uc_id`, `uc_course_id`, `uc_user_id`, `uc_date_end`, `crs_name`
            FROM `users_courses`
            LEFT JOIN `courses` ON `crs_id`=`uc_course_id`
            WHERE `uc_user_id`=? and `uc_blocked`=0 and `uc_date_end`<? and `uc_date_end`<>"0000-00-00"
            GROUP BY `uc_course_id`', array($user_id, $today));
        if($sel_courses3 !== false and 0 < $sel_courses3->num_rows())
        {
            $i = 0;

            foreach($sel_courses3->result() as $row)
            {
                // Данные курса
                $result['notifications'][$row->uc_id][154]['course_name'] = $row->crs_name;
                $result['notifications'][$row->uc_id][154]['course_id']   = $row->uc_course_id;
                $result['notifications'][$row->uc_id][154]['extends']     = array();

                $sel_extends = self::getUserCourseExtends($row->uc_course_id, $date);

                if(!empty($sel_extends['extends']))
                {
                    $a = 0;
                    foreach($sel_extends['extends'] as $extend)
                    {
                        // Дата отсчета продления курса с промокодом
                        $tmp_date3   = new DateTime($row->uc_date_end);
                        $tmp_date3->add(new DateInterval('P' . ($extend['weeks_after']*7) . 'D'));
                        $edcd        = $tmp_date3->format('Y-m-d');

                        if($edcd == $today)
                        {
                            $tmp_date4      = new DateTime($edcd);
                            $tmp_date4->add(new DateInterval("PT23H59M59S"));
                            $ext_date_cd = $tmp_date4->format('U')*1000;
                        }
                        else
                        {
                            $ext_date_cd = $tmp_date3->format('U')*1000;
                        }

                        // Отображаем курс продления, если окончательная дата продления не наступила
                        if(!empty($ext_date_cd))
                        {
                            $result['notifications'][$row->uc_id][154]['extends'][$a]['course_id']      = $extend['extend_id'];
                            $result['notifications'][$row->uc_id][154]['extends'][$a]['course_name']    = $extend['course_name'];
                            $result['notifications'][$row->uc_id][154]['extends'][$a]['promocode']      = $extend['promocode'];
                            $result['notifications'][$row->uc_id][154]['extends'][$a]['price']          = $extend['course_price'];
                            $result['notifications'][$row->uc_id][154]['extends'][$a]['new_price']      = $extend['course_new_price'];
                            $result['notifications'][$row->uc_id][154]['extends'][$a]['date_countdown'] = $ext_date_cd;

                            $a++;
                        }
                    }
                    unset($extend);
                }

                $i++;
            }
            unset($row2);
        }
        elseif($sel_courses3 === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        // Активные курсы тренировок, выбранные для вывода в календарь. Вывод уведомления, если нет выбранных курсов.
        $sel_display_workouts = $this->db->query('
            SELECT `uc_id`, `uc_display` FROM `users_courses`
            LEFT JOIN `courses` ON `crs_id`=`uc_course_id`
            WHERE `uc_user_id`=? and `uc_blocked`=0 and (`uc_date_end`>=? or `uc_date_end`="0000-00-00") 
              and `crs_category`="workout"',
                array($user_id, $today));
        if($sel_display_workouts !== false and 0 < $sel_display_workouts->num_rows())
        {
            foreach($sel_display_workouts->result() as $row)
            {
                if($row->uc_display == 1)
                {
                    $result['display_workout'] = false;
                    break;
                }
            }
            unset($row);
        }
        elseif($sel_display_workouts === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }
        else
        {
            $result['display_workout'] = false;
        }

        // Активные курсы питания, выбранные для вывода в календарь. Вывод уведомления, если нет выбранных курсов.
        $sel_display_nutritions = $this->db->query('
            SELECT `uc_id`, `uc_display` FROM `users_courses`
            LEFT JOIN `courses` ON `crs_id`=`uc_course_id`
            WHERE `uc_user_id`=? and `uc_blocked`=0 and (`uc_date_end`>=? or `uc_date_end`="0000-00-00") 
              and `crs_category`="nutrition"',
                array($user_id, $today));
        if($sel_display_nutritions !== false and 0 < $sel_display_nutritions->num_rows())
        {
            foreach($sel_display_workouts->result() as $row)
            {
                if($row->uc_display == 1)
                {
                    $result['display_nutrition'] = false;
                    break;
                }
            }
            unset($row);
        }
        elseif($sel_display_nutritions === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }
        else
        {
            $result['display_nutrition'] = false;
        }

        // Уведосление о пропущенной тренировке на этой неделе
        $current_num_day = date("N", strtotime($today));
        $tmp_date        = new DateTime($today);
        $interval        = 7 - $current_num_day;
        $this_sunday     = ($tmp_date !== false) ? $tmp_date->add(new DateInterval('P'.$interval.'D'))->format('Y-m-d') : false;
        $this_monday     = ($this_sunday !== false) ? $tmp_date->sub(new DateInterval('P6D'))->format('Y-m-d') : false;

        $sel_this_week = $this->db->query('
            SELECT `utw_id`, `utw_uc_id`, `uc_course_id`, `uc_user_id`, `crs_name` FROM `users_training_weeks`
            LEFT JOIN `users_courses` ON `uc_id`=`utw_uc_id`
            LEFT JOIN `courses` ON `crs_id`=`uc_course_id`
            WHERE `uc_user_id`=? and `utw_date`>=? and `utw_date`<? and `utw_status`="missed" and `uc_blocked`=0 LIMIT 1',
                array($user_id, $this_monday, $today));
        if($sel_this_week !== false and 1 == $sel_this_week->num_rows())
        {
            $row = $sel_this_week->row();

            $result['notifications'][$row->utw_uc_id][197]['course_name'] = $row->crs_name;
        }
        elseif($sel_this_week === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Выборка уведомлений курса пользователя
     *
     * @param int $user_course_id
     * @param int $user_id
     * @param string $date
     * @return array
     */
    public function getUserCourseNotifications($user_course_id, $user_id, $date)
    {
        $result = array('notifications' => array());

        $sel_course = $this->db->query('
            SELECT `uc_id`, `uc_course_id`, `uc_date_end`, `uc_blocked`, `uc_blocked_date`, `uc_blocked_reason`, `crs_name`
            FROM `users_courses` 
            LEFT JOIN `courses` ON `uc_course_id`=`crs_id`
            WHERE `uc_user_id`=? and `uc_id`=? LIMIT 1', array($user_id, $user_course_id));

        if ($sel_course !== false and 0 < $sel_course->num_rows())
        {
            $row      = $sel_course->row();
            $tmp_date = new DateTime($date);
            $today    = $tmp_date->format('Y-m-d');
            $tmp_date->sub(new DateInterval('P7D'));
            // Дата неделю назад от текущей даты
            $week_ago = $tmp_date->format('Y-m-d');

            $tmp_date2 = new DateTime($row->uc_blocked_date);
            $tmp_date2->add(new DateInterval('P7D'));
            // Дата через неделю от даты блокировки
            $next_week = $tmp_date2->format('Y-m-d');
            $tmp_date2->add(new DateInterval('P21D'));
            // Дата через 4 недели от даты блокировки
            $next_three_weeks = $tmp_date2->format('Y-m-d');

            // Вывод уведомления в течении недели после первого безуспешного проведения оплаты
            if ($row->uc_blocked == 1 and $row->uc_blocked_date >= $week_ago
                and $row->uc_blocked_reason == 'payment_canceled' and $next_week > $today)
            {
                setlocale(LC_ALL, 'ru_RU.UTF-8');
                $tmp_nw = DateTime::createFromFormat('Y-m-d', $next_week);
                $tmp_nw = ($next_week != '0000-00-00' and $tmp_nw !== false)
                    ? strftime('%d %b %Gг.', strtotime($next_week))
                    : '';

                $result['notifications'][$row->uc_course_id][142]['date_attempts'] = $tmp_nw;
                $result['notifications'][$row->uc_course_id][142]['course_name']   = $row->crs_name;
                $result['notifications'][$row->uc_course_id][142]['course_id']     = $row->uc_course_id;
            }
            // Вывод уведомления в течении 3х недель после первой недели блокировки
            elseif($row->uc_blocked == 1 and $row->uc_blocked_date < $week_ago and $next_three_weeks > $today)
            {
                setlocale(LC_ALL, 'ru_RU.UTF-8');
                $tmp_nw2 = DateTime::createFromFormat('Y-m-d', $next_three_weeks);
                $tmp_nw2 = ($next_three_weeks != '0000-00-00' and $tmp_nw2 !== false)
                    ? strftime('%d %b %Gг.', strtotime($next_three_weeks))
                    : '';

                $result['notifications'][$row->uc_course_id][144]['date_attempts'] = $tmp_nw2;
                $result['notifications'][$row->uc_course_id][144]['course_name']   = $row->crs_name;
                $result['notifications'][$row->uc_course_id][144]['course_id']     = $row->uc_course_id;
            }

            // Курс заканчивается через неделю или меньше
            $tmp_date3 = new DateTime($date);
            $tmp_date3->add(new DateInterval('P8D'));
            $next_week = $tmp_date3->format('Y-m-d');

            if($row->uc_date_end != '0000-00-00' and $row->uc_date_end >= $today and $row->uc_date_end < $next_week)
            {
                if($row->uc_date_end == $today)
                {
                    $tmp_date4      = new DateTime($row->uc_date_end);
                    $tmp_date4->add(new DateInterval("PT23H59M59S"));
                    $date_countdown = $tmp_date4->format('U')*1000;
                }
                else
                {
                    $tmp_date4      = new DateTime($row->uc_date_end);
                    $date_countdown = $tmp_date4->format('U')*1000;
                }

                $result['notifications'][$row->uc_course_id][143]['date_countdown'] = $date_countdown;
                $result['notifications'][$row->uc_course_id][143]['course_name']    = $row->crs_name;
                $result['notifications'][$row->uc_course_id][143]['course_id']      = $row->uc_course_id;
            }

            // Курс закончился
            if($row->uc_date_end != '0000-00-00' and $row->uc_date_end < $today)
            {
                // Данные курса
                $result['notifications'][$row->uc_id][154]['course_name'] = $row->crs_name;
                $result['notifications'][$row->uc_id][154]['course_id']   = $row->uc_course_id;
                $result['notifications'][$row->uc_id][154]['extends']     = array();

                $sel_extends = self::getUserCourseExtends($row->uc_course_id, $date);

                if(!empty($sel_extends['extends']))
                {
                    $a = 0;
                    foreach($sel_extends['extends'] as $extend)
                    {
                        // Дата отсчета продления курса с промокодом
                        $tmp_date3   = new DateTime($row->uc_date_end);
                        $tmp_date3->add(new DateInterval('P' . ($extend['weeks_after']*7) . 'D'));
                        $edcd        = $tmp_date3->format('Y-m-d');

                        if($edcd == $today)
                        {
                            $tmp_date4      = new DateTime($edcd);
                            $tmp_date4->add(new DateInterval("PT23H59M59S"));
                            $ext_date_cd = $tmp_date4->format('U')*1000;
                        }
                        else
                        {
                            $ext_date_cd = $tmp_date3->format('U')*1000;
                        }

                        // Отображаем курс продления, если окончательная дата продления не наступила
                        if(!empty($ext_date_cd))
                        {
                            $result['notifications'][$row->uc_id][154]['extends'][$a]['course_id']      = $extend['extend_id'];
                            $result['notifications'][$row->uc_id][154]['extends'][$a]['course_name']    = $extend['course_name'];
                            $result['notifications'][$row->uc_id][154]['extends'][$a]['promocode']      = $extend['promocode'];
                            $result['notifications'][$row->uc_id][154]['extends'][$a]['price']          = $extend['course_price'];
                            $result['notifications'][$row->uc_id][154]['extends'][$a]['new_price']      = $extend['course_new_price'];
                            $result['notifications'][$row->uc_id][154]['extends'][$a]['date_countdown'] = $ext_date_cd;

                            $a++;
                        }
                    }
                    unset($extend);
                }
            }

            unset($row);
        }
        elseif ($sel_course === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Вычисление новой даты тренировки на основе предыдущей даты тренировки
     *
     * @param $training_date
     * @param $array_training_days
     * @param $date
     * @param $utw_id
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

        if ($key_num_day !== false)
        {
            // Вычисление разницы между номерами дней недели
            // Если предыдущий день недели тренировки последний день недели, то
            if ($key_num_day == $last_t_day)
            {
                // От 7 дней недели отнимаем день недели предыдущей тренировки и прибавляем день недели первой тренировки на неделе
                $diff_days = 7 - $array_training_days[$key_num_day] + $array_training_days[0];
            }
            else
            {
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
                parent::logDbMessages(__METHOD__.':'.__LINE__);
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
        $percentageChange  = 60;
        $percentageChange2 = 25;

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
     * @param $user_course_id
     * @param $user_id
     * @param $date
     * @return array
     */
    public function getUserCourseSettings($user_course_id, $user_id, $date = null)
    {
        //self::deleteUsersCoursesInfo();
        $result = array('course' => array());

        $sel_course = $this->db->query('
            SELECT `uc_id`, `uc_o_id`, `uc_course_id`, `uc_coach_id`, `uc_date_start`, `uc_date_end`, `uc_days`, `uc_time`, `uc_blocked`, 
              `uc_blocked_date`, `uc_blocked_reason`, `uc_paused`, `uc_pause_days`, `crs_name`, `crs_description`, `crs_image`,
              `crs_count_weeks`, `crs_count_days`, `crs_price`, `crs_fitcoin_price`, `crs_count_rest`, `crs_category` 
            FROM `users_courses`
            LEFT JOIN `courses` ON `uc_course_id`=`crs_id`
            WHERE `uc_id`=? and `uc_user_id`=? LIMIT 1', array($user_course_id, $user_id));

        if ($sel_course !== false and 1 == $sel_course->num_rows())
        {
            $row = $sel_course->row();

            $tmp_d = new DateTime($date);
            $today = $tmp_d->format('Y-m-d');

            // Даты начала и окончания курса
            $t_date     = DateTime::createFromFormat('Y-m-d', $row->uc_date_start);
            $date_start = ($row->uc_date_start != '0000-00-00' and $t_date !== false) ? $t_date->format('d.m.Y') : '';
            $t_date     = DateTime::createFromFormat('Y-m-d', $row->uc_date_end);
            $date_end   = ($row->uc_date_end != '0000-00-00' and $t_date !== false) ? $t_date->format('d.m.Y') : '';

            $result['course']['id']               = $row->uc_id;
            $result['course']['order_id']         = $row->uc_o_id;
            $result['course']['course_id']        = $row->uc_course_id;
            $result['course']['coach_id']         = $row->uc_coach_id;
            $result['course']['training_days']    = $row->uc_days;
            $result['course']['days']             = (!empty($row->uc_days)) ? str_split($row->uc_days) : array();
            $result['course']['training_time']    = array();
            $result['course']['db_date_start']    = $row->uc_date_start;
            $result['course']['db_date_end']      = $row->uc_date_end;
            $result['course']['date_start']       = $date_start;
            $result['course']['date_end']         = $date_end;
            $result['course']['blocked']          = $row->uc_blocked;
            $result['course']['blocked_buy']      = false;
            $result['course']['paused']           = $row->uc_paused;
            $result['course']['pause_days']       = $row->uc_pause_days;
            $result['course']['pause_start']      = '';
            $result['course']['pause_end']        = '';
            $result['course']['category']         = $row->crs_category;
            $result['course']['name']             = $row->crs_name;
            $result['course']['description']      = $row->crs_description;
            $result['course']['image']            = (is_file($row->crs_image)) ? mb_substr($row->crs_image, 1) : '';
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
            $result['course']['finished']         = ($row->uc_date_end != '0000-00-00' and $row->uc_date_end < $today) ? true : false;
            $result['course']['attached_courses'] = array();

            // Время тренировок
            if(!empty($row->uc_time))
            {
                $training_times = array();
                $db_times = explode(';', $row->uc_time);
                foreach($result['course']['days'] as $key => $day)
                {
                    $training_times[$day] = (!empty($db_times[$key])) ? $db_times[$key] : '';
                }
                unset($day);

                $result['course']['training_time'] = $training_times;
            }

            // Блокировка курса и его покупка
            if(!empty($date))
            {
                $tmp_d->sub(new DateInterval('P7D'));
                // Дата неделю назад от текущей даты
                $week_ago = $tmp_d->format('Y-m-d');

                $tmp_date = new DateTime($row->uc_blocked_date);
                $tmp_date->add(new DateInterval('P28D'));
                // Дата через 4 недели от даты блокировки
                $next_three_weeks = $tmp_date->format('Y-m-d');

                if($row->uc_blocked == 1 and $row->uc_blocked_date < $week_ago and $next_three_weeks > $today)
                {
                    $result['course']['blocked_buy']    = true;
                    $result['course']['residual_value'] = 0;
                }
                // Прошло 4 недели, курс "удаляется" (не отображается)
                /*elseif($row->uc_blocked == 1 and $next_three_weeks < $today)
                {
                    unset($result);
                    $result = array();
                }*/
            }

            $sel_course->free_result();
            unset($row);

            if(!empty($result['course']))
            {
                // Тренеры курса
                $sel_coaches = $this->db->query('
                    SELECT `cc_coach_id`, `user_name`, `user_email` 
                    FROM `courses_coaches`
                    LEFT JOIN `users` ON `cc_coach_id`=`user_id`
                    WHERE `cc_course_id`=?', $result['course']['id']);
                if ($sel_coaches !== false and 0 < $sel_coaches->num_rows()) {
                    $i = 0;
                    foreach ($sel_coaches->result() as $row) {
                        $result['course']['coaches'][$i]['id']   = $row->cc_coach_id;
                        $result['course']['coaches'][$i]['name'] = !empty($row->user_name) ? $row->user_name : 'Тренер #'.$row->cc_coach_id;

                        $i++;
                    }
                    unset($row);
                }
                elseif ($sel_coaches === false)
                {
                    parent::logDbMessages(__METHOD__.':'.__LINE__);
                }

                // Текущие тренировочные дни
                $sel_training_days = $this->db->query('
                    SELECT `utw_uc_id`, `utw_workout`, `utw_status`, `utw_date`
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
                    foreach ($sel_training_days->result() as $row)
                    {
                        $result['course']['workouts'][$row->utw_workout]['date'] = $row->utw_date;
                        $result['course']['workouts'][$row->utw_workout]['done'] = ($row->utw_status == 'done') ? 1 : 0;

                        setlocale(LC_ALL, 'ru_RU.UTF-8');
                        $date = DateTime::createFromFormat('Y-m-d', $row->utw_date);
                        $date = ($row->utw_date != '0000-00-00' and $date !== false)
                            ? strftime('%d %b %Gг.', strtotime($row->utw_date))
                            : '';

                        if ($row->utw_date < $today and $row->utw_status == 'missed')
                        {
                            $d_o_l_m_w = $date;
                            $workouts_missed++;
                        }
                        elseif ($row->utw_date <= $today and $row->utw_status == 'done')
                        {
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
                    parent::logDbMessages(__METHOD__.':'.__LINE__);
                }
                $sel_training_days->free_result();

                // Паузы курса
                $sel_pauses = $this->db->query('
                    SELECT `ucp_pause_start`, `ucp_pause_end` FROM `users_courses_pauses`
                    WHERE `ucp_uc_id`=?
                    ORDER BY `ucp_id` DESC', $result['course']['id']);
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
                    parent::logDbMessages(__METHOD__.':'.__LINE__);
                }
                $sel_pauses->free_result();

                // Прикрепленный курсы питания, если их больше одного и если еще не выбран курс пользователем
                $check_attached = $this->db->query('SELECT `uc_id` FROM `users_courses` WHERE `uc_attached_uc_id`=? LIMIT 1', $result['course']['id']);
                if($check_attached !== false and 0 == $check_attached->num_rows())
                {
                    $sel_at = $this->db->query('
                        SELECT `ca_attached_crs_id`, `crs_name` 
                        FROM `courses_attached`
                        LEFT JOIN `courses` ON `crs_id`=`ca_attached_crs_id`
                        WHERE `ca_crs_id`=? and `ca_blocked`=0', $result['course']['course_id']);
                    if($sel_at !== false and 1 < $sel_at->num_rows())
                    {
                        $i = 0;
                        foreach($sel_at->result() as $row)
                        {
                            $result['course']['attached_courses'][$i]['course_id'] = $row->ca_attached_crs_id;
                            $result['course']['attached_courses'][$i]['name']      = $row->crs_name;

                            $i++;
                        }
                        unset($row);
                    }
                    elseif($sel_at === false)
                    {
                        parent::logDbMessages(__METHOD__.':'.__LINE__);
                    }
                    $sel_at->free_result();
                }
                elseif($check_attached === false)
                {
                    parent::logDbMessages(__METHOD__.':'.__LINE__);
                }
                $check_attached->free_result();
            }
        }
        elseif ($sel_course === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
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
     * @param int $user_course_id ID курса пользователя
     * @param int $user_id ID пользователя
     * @param int $coach_id ID выбранного тренера
     * @param $date
     * @return bool
     */
    public function setUserCourseCoach($user_course_id, $user_id, $coach_id, $date)
    {
        $up_data = $this->db->query('
            UPDATE `users_courses` SET `uc_coach_id`=?, `uc_date_update`=? 
            WHERE `uc_id`=? and `uc_user_id`=? LIMIT 1',
                array($coach_id, $date, $user_course_id, $user_id));

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
     * Сохранение купленного пользователем курса в БД
     *
     * @param int $order_id
     * @param int $course_id
     * @param int $user_id
     * @param string $start_date Начало курса
     * @param string $end_date Окончание курса
     * @param int $training_days Дни недели тренировок
     * @param int $user_coach ID тренера
     * @param int $free_weeks
     * @param string $free_weeks_end_date
     * @param $date
     * @return bool
     * @throws Exception
     */
    public function setNewUserCourse($order_id, $course_id, $user_id, $start_date, $end_date, $training_days, $user_coach, $free_weeks, $free_weeks_end_date, $date)
    {
        $result = false;

        if(is_numeric($order_id) and is_numeric($course_id) and is_numeric($user_id))
        {
            $course_category = self::getCourseCategory($course_id);

            $sel_user_course = $this->db->query('
                SELECT `uc_id` FROM `users_courses` 
                WHERE `uc_user_id`=? and `uc_o_id`=? and `uc_course_id`=? LIMIT 1', array($user_id, $order_id, $course_id));

            if($sel_user_course !== false and 0 == $sel_user_course->num_rows())
            {

                $sel_duplicates = $this->db->query('
                    SELECT `uc_id` FROM `users_courses` 
                    WHERE `uc_user_id`=? and `uc_course_id`=? and `uc_blocked`=0 and `uc_date_start`="0000-00-00" LIMIT 1', array($user_id, $course_id));
                if($sel_duplicates !== false and 0 == $sel_duplicates->num_rows())
                {
                    // Добавление нового курса
                    $up_data = $this->db->query('
                    INSERT INTO `users_courses` 
                      (`uc_o_id`, `uc_user_id`, `uc_course_id`, `uc_coach_id`, `uc_days`, `uc_date_start`, `uc_date_end`, `uc_free_weeks`, `uc_free_weeks_end_date`, `uc_date_update`) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)',
                        array($order_id, $user_id, $course_id, $user_coach, $training_days, $start_date, $end_date, $free_weeks, $free_weeks_end_date, $date));

                    /* Если курс успешно добавлен, то:
                     * - добавляем дни недели тренировок в другую таблицу (для вывода реальных дат тренировок при изменении дней недели тренировок пользователем)
                     * - добавляем каждую тренировку по отдельности в другую таблицу (для статистики выполненных тренировок)
                    */
                    if ($up_data !== false and 1 == $this->db->affected_rows())
                    {
                        // ID курса в таблице курсов пользователей
                        $uc_id = $this->db->insert_id();

                        if($course_category == 'workout')
                        {
                            // Добавляем дни недели тренировок
                            if (!empty($training_days))
                            {
                                $up_data = $this->db->query('
                                INSERT INTO `users_training_days` (`utd_uc_id`, `utd_days`, `utd_date_update`) 
                                VALUES (?, ?, ?)', array($uc_id, $training_days, $date));
                                if ($up_data === false)
                                {
                                    parent::logDbMessages(__METHOD__.':'.__LINE__);
                                }
                            }

                            // Проверка на существование прикрепленных курсов
                            $sel_attached = $this->db->query('
                            SELECT `ca_attached_crs_id`, `crs_count_weeks`, `crs_count_days` 
                            FROM `courses_attached`
                            LEFT JOIN `courses` ON `crs_id`=`ca_attached_crs_id`
                            WHERE `ca_crs_id`=? and `ca_blocked`=0', $course_id);
                            if($sel_attached !== false and 0 < $sel_attached->num_rows())
                            {
                                // Если курс один, прикрепляем.
                                if($sel_attached->num_rows() == 1)
                                {
                                    $row = $sel_attached->row();

                                    // Добавляем прикрепленный курс
                                    self::setAttachedCourseOfUserCourse($order_id, $user_id,  $row->ca_attached_crs_id, $uc_id, $user_coach, $training_days, $start_date, $end_date, $date);
                                }

                                /*$start_date = (empty($start_date)) ? $date : $start_date;

                                foreach($sel_attached->result() as $row)
                                {
                                    $count_nutritions = $row->crs_count_weeks * $row->crs_count_days;
                                    $tmp_date = new DateTime($start_date);
                                    $tmp_date->add(new DateInterval("P" . $count_nutritions . "D"));
                                    $end_date = ($tmp_date !== false) ? $tmp_date->format('Y-m-d') : '';

                                    // Добавляем прикрепленные курсы
                                    $ins_data = $this->db->query('
                                        INSERT INTO `users_courses`
                                          (`uc_o_id`, `uc_user_id`, `uc_course_id`, `uc_attached_uc_id`, `uc_coach_id`, `uc_days`, `uc_date_start`, `uc_date_end`, `uc_date_update`)
                                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)',
                                            array($order_id, $user_id, $row->ca_attached_crs_id, $uc_id, $user_coach, $training_days, $start_date, $end_date, $date));
                                    if($ins_data !== false and 1 == $this->db->affected_rows())
                                    {
                                        $nuc_id = $this->db->insert_id();

                                        // Сохранение расписания курса питания
                                        self::setUserNutritionSchedule($row->ca_attached_crs_id, $nuc_id, $start_date, $date);
                                    }
                                    elseif ($ins_data === false)
                                    {
                                        parent::logDbMessages(__METHOD__.':'.__LINE__);
                                    }
                                }
                                unset($row);*/
                            }
                            elseif($sel_attached === false)
                            {
                                parent::logDbMessages(__METHOD__.':'.__LINE__);
                            }
                        }
                        elseif($course_category == 'nutrition' and !empty($start_date))
                        {
                            // Сохранение расписания курса питания
                            self::setUserNutritionSchedule($course_id, $uc_id, $start_date, $date);
                        }

                        $result = $uc_id;
                    }
                }
                elseif($sel_duplicates === false)
                {
                    parent::logDbMessages(__METHOD__.':'.__LINE__);
                }
                else
                {
                    // Очистка заказа
                    self::cleanOrder($order_id, $user_id);
                }
            }
            elseif ($sel_user_course === false)
            {
                parent::logDbMessages(__METHOD__.':'.__LINE__);
            }
            else
            {
                $courses[0]['id'] = $course_id;
                $reason = 'payment_succeeded';
                // Разблокировка курса
                $result = self::unblockUserOrderCourses($order_id, $user_id, $courses, $reason, $date);
            }
        }

        return $result;
    }

    /**
     * Проверка наличия курса в использовании у пользователя
     *
     * @param $course_id
     * @param $user_id
     * @param $order_id
     * @param $date
     * @return bool
     * @throws Exception
     */
    public function checkUserCourse($course_id, $user_id, $order_id, $date)
    {
        $result = false;

        if(is_numeric($course_id) and is_numeric($user_id))
        {
            if(is_numeric($order_id))
            {
                $sel_duplicates = $this->db->query('
                    SELECT `uc_id` FROM `users_courses` 
                    WHERE `uc_user_id`=? and `uc_o_id`=? and `uc_course_id`=? LIMIT 1', array($user_id, $order_id, $course_id));
            }
            else
            {
                $tmp_date = new DateTime($date);
                $today = ($tmp_date !== false) ? $tmp_date->format('Y-m-d') : '';

                $sel_duplicates = $this->db->query('
                    SELECT `uc_id` FROM `users_courses` 
                    WHERE `uc_user_id`=? and `uc_course_id`=? and `uc_blocked`=0 and (`uc_date_start`="0000-00-00" or `uc_date_end`>?) LIMIT 1',
                        array($user_id, $course_id, $today));
            }

            if($sel_duplicates !== false and 0 == $sel_duplicates->num_rows())
            {
                $result = true;
            }
        }

        return $result;
    }

    /**
     * Добавление прикрепленного курса в каледарь пользователя
     *
     * @param $order_id
     * @param $user_id
     * @param $attached_course_id
     * @param $user_course_id
     * @param $coach
     * @param $training_days
     * @param $start_date
     * @param $end_date
     * @param $date
     * @return bool
     * @throws Exception
     */
    public function setAttachedCourseOfUserCourse($order_id, $user_id, $attached_course_id, $user_course_id, $coach,
                                                  $training_days, $start_date, $end_date, $date)
    {
        $result = false;

        $ins_data = $this->db->query('
            INSERT INTO `users_courses` 
              (`uc_o_id`, `uc_user_id`, `uc_course_id`, `uc_attached_uc_id`, `uc_coach_id`, `uc_days`, `uc_date_start`, `uc_date_end`, `uc_date_update`) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)',
                array($order_id, $user_id, $attached_course_id, $user_course_id, $coach, $training_days, $start_date, $end_date, $date));
        if($ins_data !== false and 1 == $this->db->affected_rows())
        {
            $nuc_id = $this->db->insert_id();

            if(!empty($start_date))
            {
                // Сохранение расписания курса питания
                self::setUserNutritionSchedule($attached_course_id, $nuc_id, $start_date, $date);
            }

            $result = true;
        }
        elseif ($ins_data === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Сохранение расписания курса питания
     *
     * @param int    $course_id ID курса
     * @param int    $uc_id ID курса пользователя
     * @param string $start_date Дата начала курса
     * @param string $date Текущая дата
     *
     * @throws Exception
     */
    public function setUserNutritionSchedule($course_id, $uc_id, $start_date, $date)
    {
        // Данные курса
        $course_data = self::getCourse($course_id);
        // Расписание питания
        $schedules = self::getFillNutritionSchedule($course_id);

        if(!empty($schedules))
        {
            $count_weeks = $course_data['course']['count_weeks'];
            $count_days  = $course_data['course']['count_days'];
            $total_days  = $count_weeks * $count_days;
            $values      = '';
            $event_date  = $start_date;

            // Цикл дней расписания питания (weeks * days)
            for($day_id = 1; $day_id <= $total_days; $day_id++)
            {
                if($day_id > 1)
                {
                    $tmp_date = new DateTime($event_date);
                    $tmp_date->add(new DateInterval("P1D"));
                    $event_date = ($tmp_date !== false) ? $tmp_date->format('Y-m-d') : $start_date;
                }

                if(!empty($schedules['fill_course_schedule'][$day_id]))
                {
                    foreach($schedules['fill_course_schedule'][$day_id] as $ing_id => $meal_type)
                    {
                        foreach($meal_type as $meal)
                        {
                            $meal_id = (is_numeric($meal['id'])) ? $meal['id'] : 0;

                            if(!empty($values))
                            {
                                $values .= ', ';
                            }

                            $values .= '(' . $uc_id . ', ' . $day_id . ', ' . $ing_id . ', ' . $meal_id . ', "' . $event_date . '", "' . $date . '")';
                        }
                        unset($meal);
                    }
                    unset($meal_type);
                }
            }

            if(!empty($values))
            {
                $ins_data = $this->db->query('
                    INSERT INTO `users_nutritions`(`un_uc_id`, `un_cds_day`, `un_cds_ci_id`, `un_ml_id`, `un_date`, `un_update`) 
                    VALUES ' . $values);

                if($ins_data === false)
                {
                    parent::logDbMessages(__METHOD__.':'.__LINE__);
                }
            }
        }
    }

    /**
     * Сохранение дней тренировок пользователя
     *
     * @param int $user_course_id ID курса и пользователя (Уникальное ID купленного курса в таблице users_courses)
     * @param int $training_days Дни тренировок (объединены в одну строку 147 (1 - Пн., 4 - Чт., 7 - Вс.))
     * @param $training_times
     * @param string $course_start Дата начала курса
     * @param string $course_end Дата окончания курса
     * @param $date
     * @return bool
     * @throws Exception
     * @internal param $training_time
     */
    public function setUserTrainingDays($user_course_id, $training_days, $training_times, $course_start, $course_end, $date)
    {
        $result = true;

        $free_weeks_end_date = '';

        $sel_fw = $this->db->query('SELECT `uc_free_weeks`, `uc_free_weeks_end_date` FROM `users_courses` WHERE `uc_id`=? LIMIT 1', $user_course_id);
        if($sel_fw !== false and 1 == $sel_fw->num_rows())
        {
            $row = $sel_fw->row();
            if($row->uc_free_weeks_end_date == '0000-00-00' and $row->uc_free_weeks > 0)
            {
                $free_weeks_days = $row->uc_free_weeks*7;
                $tmp_date = new DateTime($course_start);
                $tmp_date->add(new DateInterval("P" . $free_weeks_days . "D"));
                $free_weeks_end_date = ($tmp_date !== false) ? $tmp_date->format('Y-m-d') : '';
            }
        }
        elseif($sel_fw === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        $up_data = $this->db->query('
            INSERT INTO `users_training_days` (`utd_uc_id`, `utd_days`, `utd_date_update`) 
            VALUES (?, ?, ?)', array($user_course_id, $training_days, $date));
        if ($up_data === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        $up_data = $this->db->query('
            UPDATE `users_courses` SET `uc_date_start`=?, `uc_date_end`=?, `uc_days`=?, `uc_time`=?, `uc_free_weeks_end_date`=?, `uc_date_update`=?
            WHERE `uc_id`=? LIMIT 1',
                array($course_start, $course_end, $training_days, $training_times, $free_weeks_end_date, $date, $user_course_id));
        if ($up_data === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        // Проверка наличия прикрепленных курсов
        $sel_data = $this->db->query('SELECT `uc_id`, `uc_course_id` FROM `users_courses` WHERE `uc_attached_uc_id`=? LIMIT 1', $user_course_id);
        if($sel_data !== false and 1 == $sel_data->num_rows())
        {
            $row = $sel_data->row();
            $attached_course = self::getCourse($row->uc_course_id);

            // Сохранение старта курса. Вычисление окончания курса
            $count_weeks = $attached_course['course']['count_weeks'];
            $count_days  = $attached_course['course']['count_days'];
            $total_days  = $count_weeks * $count_days;
            $tmp_date = new DateTime($course_start);
            $tmp_date->add(new DateInterval("P".$total_days."D"));
            $attached_course_end = ($tmp_date !== false) ? $tmp_date->format('Y-m-d') : '';

            $up_a_data = $this->db->query('
                UPDATE `users_courses` SET `uc_date_start`=?, `uc_date_end`=?, `uc_date_update`=?
                WHERE `uc_id`=? LIMIT 1', array($course_start, $attached_course_end, $date, $row->uc_id));
            if($up_a_data !== false and 1 == $this->db->affected_rows())
            {
                // Сохранение расписания курса питания пользователя
                self::setUserNutritionSchedule($row->uc_course_id, $row->uc_id, $course_start, $date);
            }
            elseif ($up_a_data === false)
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
     * Сохранение времени тренировок
     *
     * @param $user_course_id
     * @param $training_times
     * @param $date
     * @return bool
     * @internal param $training_time
     */
    public function setUserTrainingTime($user_course_id, $training_times, $date)
    {
        $result = true;

        $up_data = $this->db->query('
            UPDATE `users_courses` SET `uc_time`=?, `uc_date_update`=? WHERE `uc_id`=? LIMIT 1',
                array($training_times, $date, $user_course_id));
        if ($up_data === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
            $result = false;
        }

        return $result;
    }

    /**
     * Сохранение изменения дат тренировок
     *
     * @param int $user_course_id ID курса и пользователя (Уникальное ID купленного курса в таблице users_courses)
     * @param array $update_workouts Массив тренировок, которые необходимо обновить
     * @param string $date Текущая дата
     * @return bool
     */
    public function updateDatesUserWorkouts($user_course_id, $update_workouts, $date)
    {
        $result = true;

        if(!empty($update_workouts))
        {
            foreach ($update_workouts as $num_workout => $workout)
            {
                $up_data = $this->db->query('
                    UPDATE `users_training_weeks` SET `utw_date`=?, `utw_date_update`=?
                    WHERE `utw_uc_id`=? and `utw_workout`=? LIMIT 1',
                        array($workout['date'], $date, $user_course_id, $num_workout));

                if ($up_data !== false and 1 != $this->db->affected_rows())
                {
                    $result = false;
                }
                elseif ($up_data === false)
                {
                    parent::logDbMessages(__METHOD__.':'.__LINE__);
                    $result = false;
                }
            }
            unset($workout);
        }

        return $result;
    }

    /**
     * Заморозка курса пользователя
     *
     * @param int $user_course_id ID курса и пользователя (Уникальное ID купленного курса в таблице users_courses)
     * @param $date_pause_to
     * @param string $course_end Дата окончания курса
     * @param $update_workouts
     * @param $date
     * @return bool
     */
    public function setUserCoursePause($user_course_id, $date_pause_to, $course_end, $update_workouts, $date)
    {
        $result = false;

        $ins_data = $this->db->query('
            INSERT INTO `users_courses_pauses` (`ucp_pause_start`, `ucp_pause_end`, `ucp_uc_id`) VALUES (?, ?, ?)',
                array($date, $date_pause_to, $user_course_id));

        if ($ins_data !== false and 1 == $this->db->affected_rows())
        {
            $up_data = $this->db->query('UPDATE `users_courses` SET `uc_paused`=1, `uc_date_update`=?, `uc_date_end`=?
                WHERE `uc_id`=?  LIMIT 1', array($date, $course_end, $user_course_id));
            if($up_data !== false and 1 == $this->db->affected_rows() and is_array($update_workouts))
            {
                self::updateDatesUserWorkouts($user_course_id, $update_workouts, $date);
            }
            elseif($up_data === false)
            {
                parent::logDbMessages(__METHOD__.':'.__LINE__);
            }

            $result = true;
        }
        elseif ($ins_data === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Разморозка курса пользователя
     *
     * @param int $user_course_id ID курса и пользователя (Уникальное ID купленного курса в таблице users_courses)
     * @param int $pause_days Общее количество дней заморозки
     * @param string $course_end Дата окончания курса
     * @param $date
     * @return bool
     */
    public function unsetUserCoursePause($user_course_id, $pause_days, $course_end,  $date)
    {
        $up_data = $this->db->query('UPDATE `users_courses_pauses` SET `ucp_pause_end`=? WHERE `ucp_uc_id`=? LIMIT 1',
            array($date, $user_course_id));

        if ($up_data !== false and 1 == $this->db->affected_rows())
        {
            $up_data = $this->db->query('
                UPDATE `users_courses` 
                SET `uc_paused`=0, `uc_pause_days`=?, `uc_date_update`=?, `uc_date_end`=?
                WHERE `uc_id`=?  LIMIT 1',
                    array($pause_days, $date, $course_end, $user_course_id));
            if ($up_data === false)
            {
                parent::logDbMessages(__METHOD__.':'.__LINE__);
            }

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
     * Добавление тренировок пользователя в БД
     *
     * @param int $uc_id ID курса пользователя (`uc_id` - `users_courses`)
     * @param string $start_date Дата начала тренировок
     * @param int $training_days Тренировочные дни пользователя
     * @param $arr_training_times
     * @param int $count_workouts Общее кол-во тренировок курса
     * @param int $count_days Кол-во тренировок курса в неделю
     * @param string $date Текущая дата
     * @return bool
     */
    public function setUserTrainingWeeks($uc_id, $start_date, $training_days, $arr_training_times, $count_workouts, $count_days, $date)
    {
        $result = true;
        // Определяем дату каждой тренировки
        $values        = '';
        $training_date = $start_date;
        $training_days = str_split($training_days); // Дни недели тренировок в массив
        $count_days    = count($training_days);

        for ($workout = 1; $workout <= $count_workouts; $workout++)
        {
            if ($workout == 1)
            {
                // Время тренировки
                $cur_num_week  = date('N', strtotime($training_date));
                $training_time = (!empty($arr_training_times[$cur_num_week])) ? $arr_training_times[$cur_num_week] : '';

                $values .= '(' . $uc_id . ', ' . $workout . ', ' . $workout . ', "' . $training_date . '", "' . $training_time . '", "' . $date . '")';
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
                    if ($key_num_week == ($count_days - 1))
                    {
                        // От 7 дней недели отнимаем день недели предыдущей тренировки и прибавляем день недели первой тренировки на неделе
                        $diff_days = 7 - $training_days[$key_num_week] + $training_days[0];
                    }
                    else
                    {
                        // Разница между текущим номером недели тренировки и предыдущем.
                        $diff_days = $training_days[$key_num_week+1] - $training_days[$key_num_week];
                    }

                    // Временная дата предыдущей тренивроки
                    $tem_date = new DateTime($training_date);
                    // Дата текущей тренировки, с учетом разницы между тренировками ( + $diff_days дней )
                    $tem_date->add(new DateInterval('P' . abs($diff_days) . 'D'));
                    $training_date = ($tem_date !== false) ? $tem_date->format('Y-m-d') : '';
                    unset($tem_date);

                    // Время тренировки
                    $cur_num_week  = date('N', strtotime($training_date));
                    $training_time = (!empty($arr_training_times[$cur_num_week])) ? $arr_training_times[$cur_num_week] : '';

                    $values .= ', (' . $uc_id . ', ' . $workout . ', ' . $workout . ', "' . $training_date . '", "' . $training_time . '", "' . $date . '")';
                }
            }
        }
        unset($workout);

        // Сохраняем каждую тренировку по отдельности
        if (!empty($values)) {
            $up_data = $this->db->query('
                INSERT INTO `users_training_weeks`
                  (`utw_uc_id`, `utw_workout`, `utw_crs_workout`, `utw_date`, `utw_time`, `utw_date_update`)
                VALUES ' . $values);
            if ($up_data === false)
            {
                parent::logDbMessages(__METHOD__.':'.__LINE__);
                $result = false;
            }
        }

        return $result;
    }

    /**
     * Изменение времени тренировок курса
     *
     * @param $user_course_id
     * @param $arr_training_times
     * @param $count_workouts
     * @param $date
     * @return bool
     */
    public function setUserTrainingWeeksTime($user_course_id, $arr_training_times, $count_workouts, $date)
    {
        $result = true;

        $sel_data = $this->db->query('SELECT `utw_id`, `utw_date` FROM `users_training_weeks` WHERE `utw_uc_id`=? LIMIT ?',
            array($user_course_id, $count_workouts));
        if($sel_data !== false and 0 < $sel_data->num_rows())
        {
            foreach($sel_data->result() as $row)
            {
                // Номер дня недели тренировки
                $day_num_week  = date('N', strtotime($row->utw_date));
                $training_time = (!empty($arr_training_times[$day_num_week])) ? $arr_training_times[$day_num_week] : '';

                if(!empty($training_time))
                {
                    $up_data = $this->db->query('UPDATE `users_training_weeks` SET `utw_time`=?, `utw_date_update`=? 
                        WHERE `utw_id`=? and `utw_status`="" and `utw_time`<>? LIMIT 1',
                            array($training_time, $date, $row->utw_id, $training_time));
                    if($up_data === false)
                    {
                        parent::logDbMessages(__METHOD__.':'.__LINE__);
                        $result = false;
                    }
                }
            }
            unset($row);
        }
        elseif($sel_data === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
            $result = false;
        }

        return $result;
    }

    /**
     * Сохранение дней и времени тренировок новых курсов пользователя
     *
     * @param $user_id
     * @param $training_days
     * @param $arr_training_times
     * @param $courses_start
     * @param $courses_end
     * @param $courses_weeks
     * @param $courses_days
     * @param $date
     * @return bool
     * @throws Exception
     * @internal param $training_times
     */
    public function setUserCoursesTrainingDays($user_id, $training_days, $arr_training_times, $courses_start, $courses_end, $courses_weeks, $courses_days, $date)
    {
        $result = true;
        if(!empty($training_days) and is_numeric($user_id))
        {
            foreach ($training_days as $uc_id => $days)
            {
                $training_times = implode(';', $arr_training_times[$uc_id]);

                // Сохранение дней тренировок пользователя
                self::setUserTrainingDays($uc_id, $days, $training_times, $courses_start[$uc_id], $courses_end[$uc_id], $date);

                // Добавление тренировок пользователя в БД
                $count_workouts = $courses_weeks[$uc_id] * $courses_days[$uc_id];
                self::setUserTrainingWeeks($uc_id, $courses_start[$uc_id], $days, $arr_training_times[$uc_id], $count_workouts, $courses_days[$uc_id], $date);
            }
            unset($days);
        }

        return $result;
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
            parent::logDbMessages(__METHOD__.':'.__LINE__);
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
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Выборка ID курсов пользователя
     *
     * @param $user_id
     * @param $date
     * @return array
     */
    public function getUserCoursesId($user_id, $date)
    {
        $result = array();

        $sel_courses = $this->db->query('
            SELECT `uc_id`, `uc_course_id`, `uc_date_end`, `uc_pause_days` 
            FROM `users_courses` 
            WHERE `uc_user_id`=? and `uc_blocked`=0 and `uc_date_end`>?', array($user_id, $date));

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
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Блокировка курсов пользователя
     *
     * @param int $order_id
     * @param int $user_id
     * @param array $courses
     * @param string $reason
     * @param string $date
     */
    public function blockUserOrderCourses($order_id, $user_id, $courses, $reason, $date)
    {
        if (!empty($courses))
        {
            foreach ($courses as $course)
            {
                $up_data = $this->db->query('
                    UPDATE `users_courses` SET `uc_blocked`=1, `uc_blocked_date`=?, `uc_blocked_reason`=? 
                    WHERE `uc_o_id`=? and `uc_user_id`=? LIMIT 1',
                        array($date, $reason, $order_id, $user_id));

                if ($up_data === false)
                {
                    parent::logDbMessages(__METHOD__.':'.__LINE__);
                }
            }
            unset($course);
        }
    }

    /**
     * Разблокировка курсов пользователя
     *
     * @param int $order_id
     * @param int $user_id
     * @param array $courses
     * @param string $reason
     * @param string $date
     * @throws Exception
     */
    public function unblockUserOrderCourses($order_id, $user_id, $courses, $reason, $date)
    {
        if (!empty($courses))
        {
            foreach ($courses as $course)
            {
                $sel_data = $this->db->query('SELECT `uc_blocked_reason` FROM `users_courses` WHERE `uc_o_id`=? and `uc_course_id`=? and `uc_user_id`=? LIMIT 1',
                    array($order_id, $course['id'], $user_id));
                if($sel_data !== false and 1 == $sel_data->num_rows())
                {
                    $row = $sel_data->row();
                    if($row->uc_blocked_reason == 'free_weeks_over')
                    {
                        $up_data = $this->db->query('
                            UPDATE `users_courses` SET `uc_blocked`=0, `uc_blocked_date`=?, `uc_blocked_reason`=?, `uc_free_weeks_end_date`="0000-00-00"  
                            WHERE `uc_o_id`=? and `uc_course_id`=? and `uc_user_id`=? LIMIT 1',
                                array($date, $reason, $order_id, $course['id'], $user_id));
                    }
                    else
                    {
                        $up_data = $this->db->query('
                            UPDATE `users_courses` SET `uc_blocked`=0, `uc_blocked_date`=?, `uc_blocked_reason`=?  
                            WHERE `uc_o_id`=? and `uc_course_id`=? and `uc_user_id`=? LIMIT 1',
                                array($date, $reason, $order_id, $course['id'], $user_id));
                    }

                    if($up_data !== false and 1 == $this->db->affected_rows())
                    {
                        // Проверка и смещение тренировок
                        self::shiftUserCourseWorkouts($user_id, $order_id, $course['id'], $date);
                    }
                    elseif ($up_data === false)
                    {
                        parent::logDbMessages(__METHOD__.':'.__LINE__);
                    }
                }
                elseif($sel_data === false)
                {
                    parent::logDbMessages(__METHOD__.':'.__LINE__);
                }
            }
            unset($course);
        }
    }

    /**
     * Проверка покупал ли пользователь курс
     *
     * @param $course_id
     * @param $user_id
     * @return array
     */
    public function checkToBoughtUserCourse($course_id, $user_id)
    {
        $result = array('bought' => false, 'date_end' => null);

        if(is_numeric($course_id) and is_numeric($user_id))
        {
            $sel_courses = $this->db->query('SELECT `uc_date_end` FROM `users_courses` WHERE `uc_user_id`=? and `uc_course_id`=?',
                array($user_id, $course_id));

            if($sel_courses !== false and 0 < $sel_courses->num_rows())
            {
                $i = 0;
                foreach($sel_courses->result() as $row)
                {
                    $result['bought'] = true;

                    if(empty($result['date_end']) or $result['date_end'] < $row->uc_date_end)
                    {
                        $result['date_end'] = $row->uc_date_end;
                    }

                    $i++;
                }
                unset($row);
            }
            elseif($sel_courses === false)
            {
                parent::logDbMessages(__METHOD__.':'.__LINE__);
            }
        }

        return $result;
    }

    /**
     * Выборка меню питания на неделю
     *
     * @param $user_course_id
     * @param $user_id
     * @param $date
     * @return array
     */
    public function getUserNutritionMenu($user_course_id, $user_id, $date)
    {
        $result = array('course_menu' => array());

        $tmp_date    = new DateTime($date);
        $cur_num_day = ((int) $tmp_date->format('N')); // +1
        $monday      = $tmp_date->sub(new DateInterval("P". $cur_num_day ."D"));
        $monday_date = $monday->format('Y-m-d');
        $sunday      = $tmp_date->add(new DateInterval("P8D")); // 9
        $sunday_date = $sunday->format('Y-m-d');

        if(is_numeric($user_course_id) and is_numeric($user_id))
        {
            $sel_data = $this->db->query('
                SELECT `un_cds_day`, `un_cds_ci_id`, `un_ml_id`, `un_date`, `uc_course_id`, `ml_mt_id`, `mt_name` 
                FROM `users_nutritions`
                LEFT JOIN `users_courses` ON `uc_id`=`un_uc_id`
                LEFT JOIN `meals` ON `ml_id`=`un_ml_id`
                LEFT JOIN `meals_types` ON `mt_id`=`ml_mt_id`
                WHERE `un_uc_id`=? and `un_date`>? and `un_date`<? 
                ORDER BY `un_date`, `un_cds_ci_id`',
                    array($user_course_id, $monday_date, $sunday_date));

            if($sel_data !== false and 0 < $sel_data->num_rows())
            {
                $ingestions  = self::getIngestions();
                $f_row       = $sel_data->row();
                $fill_course = self::getFillNutritionSchedule($f_row->uc_course_id);

                foreach($sel_data->result() as $row)
                {
                    $ing_id = array_search($row->un_cds_ci_id, $ingestions['ingestions_id']);

                    if($ing_id !== false)
                    {

                        $result['course_menu'][$row->un_date][$row->un_cds_ci_id]['name'] = $ingestions['ingestions'][$ing_id]['name'];
                        $result['course_menu'][$row->un_date][$row->un_cds_ci_id]['meal_category'][$row->ml_mt_id]['name'] = $row->mt_name;
                        $result['course_menu'][$row->un_date][$row->un_cds_ci_id]['meal_category'][$row->ml_mt_id]['meal'] = array();

                        if($row->un_ml_id > 0)
                        {
                            $meal_data = self::getMeal($row->un_ml_id);
                            $result['course_menu'][$row->un_date][$row->un_cds_ci_id]['meal_category'][$row->ml_mt_id]['meal'] = $meal_data['meal'];
                        }
                        else
                        {
                            $result['course_menu'][$row->un_date][$row->un_cds_ci_id]['meal_category'][$row->ml_mt_id]['meal'] = $fill_course['fill_course_schedule'][$row->un_cds_day][$row->un_cds_ci_id][$row->ml_mt_id];
                        }
                    }
                }
                unset($row);
            }
            elseif($sel_data === false)
            {
                parent::logDbMessages(__METHOD__.':'.__LINE__);
            }
        }

        return $result;
    }

    /**
     * Сохранение выбранного прикрепленного курса пользователем
     *
     * @param $user_course_id
     * @param $id_choosen_course
     * @param $user_id
     * @param $date
     * @return bool
     */
    public function attachUserCourse($user_course_id, $id_choosen_course, $user_id, $date)
    {
        $result = true;

        // Данные курса пользователя
        $sel_course = $this->db->query('SELECT `uc_course_id`, `uc_o_id`, `uc_date_start` FROM `users_courses` WHERE `uc_id`=? and `uc_user_id`=? LIMIT 1',
            array($user_course_id, $user_id));
        if($sel_course !== false and 1 == $sel_course->num_rows())
        {
            $row            = $sel_course->row();
            $course_id      = $row->uc_course_id;
            $order_id       = $row->uc_o_id;
            $uc_date_start  = ($row->uc_date_start != '0000-00-00') ? $row->uc_date_start : null;
            unset($row);

            // Проверка прикрепленного курса (сохранить, если курс доступен)
            $check_course = $this->db->query('
                SELECT `ca_attached_crs_id`, `crs_count_weeks`, `crs_count_days` 
                FROM `courses_attached` 
                LEFT JOIN `courses` ON `crs_id`=`ca_attached_crs_id`
                WHERE `ca_crs_id`=? and `ca_attached_crs_id`=? and `ca_blocked`=0 LIMIT 1',
                    array($course_id, $id_choosen_course));
            if($check_course !== false and 1 == $check_course->num_rows())
            {
                $start_date = '';
                $end_date   = '';

                // Высилить старт и окончание курса от текущей даты, если дата курса пользователя,
                // к которому прикреплен курс, уже вычислена
                if(!empty($uc_date_start))
                {
                    $row = $check_course->row();
                    $course_duration = $row->crs_count_weeks * $row->crs_count_days;
                    unset($row);

                    $tmp_date = new DateTime($date);
                    $start_date = ($tmp_date !== false) ? $tmp_date->format('Y-m-d') : '';
                    $tmp_date->add(new DateInterval("P".$course_duration."D"));
                    $end_date = ($tmp_date !== false) ? $tmp_date->format('Y-m-d') : '';
                }

                // Сохранение прикрепленного курса в календарь пользователя
                self::setAttachedCourseOfUserCourse($order_id, $user_id,  $id_choosen_course, $user_course_id, '', '', $start_date, $end_date, $date);
            }
            elseif($check_course === false)
            {
                parent::logDbMessages(__METHOD__.':'.__LINE__);
            }
        }
        elseif($sel_course === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Выбор курса тренировок для отображения в календарь
     *
     * @param $user_course_id
     * @param $display
     * @param $user_id
     * @param $date
     * @return bool
     */
    public function displayUserCourse($user_course_id, $display, $user_id, $date)
    {
        $result = false;

        if(is_numeric($user_course_id) and is_numeric($user_id))
        {
            $up_data = $this->db->query('
                UPDATE `users_courses` SET `uc_display`=?, `uc_date_update`=? 
                WHERE `uc_id`=? and `uc_user_id`=? LIMIT 1', array($display, $date, $user_course_id, $user_id));
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
     * Выбор курса питания для отображения в календарь
     *
     * @param $user_course_id
     * @param $display
     * @param $user_id
     * @param $date
     * @return bool
     */
    public function displayUserNutrition($user_course_id, $display, $user_id, $date)
    {
        $result = false;

        if(is_numeric($user_course_id) and is_numeric($user_id))
        {
            $sel_data = $this->db->query('
                SELECT `uc_id`, `crs_category` FROM `users_courses`
                LEFT JOIN `courses` ON `crs_id`=`uc_course_id`
                WHERE `uc_user_id`=? and `crs_category`="nutrition"', $user_id);
            if($sel_data !== false and 0 < $sel_data->num_rows())
            {
                $i = 0;
                foreach($sel_data->result() as $row)
                {
                    $nutritions[$i] = $row->uc_id;

                    $i++;
                }
                unset($row);

                if(!empty($nutritions))
                {
                    $courses = implode(",", $nutritions);

                    // Скрыть все курсы питания из календаря
                    $up_data = $this->db->query('
                        UPDATE `users_courses` SET `uc_display`=0, `uc_date_update`=? 
                        WHERE `uc_user_id`=? and `uc_id` IN (' . $courses . ')', array($date, $user_id));
                    if($up_data === false)
                    {
                        parent::logDbMessages(__METHOD__.':'.__LINE__);
                    }

                    // Отобразить выбранный курс питания в календаре
                    $up_data = $this->db->query('
                        UPDATE `users_courses` SET `uc_display`=1, `uc_date_update`=? 
                        WHERE `uc_id`=? and `uc_user_id`=? LIMIT 1', array($date, $user_course_id, $user_id));
                    if($up_data !== false and 1 == $this->db->affected_rows())
                    {
                        $result = true;
                    }
                    elseif($up_data === false)
                    {
                        parent::logDbMessages(__METHOD__.':'.__LINE__);
                    }
                }
            }
        }

        return $result;
    }

    /**
     * Выборка меню на неделю активного курса питания пользователей для отправки уведомления на почту
     *
     * @param $date
     * @return array
     */
    public function getUsersNutritionWeekMenu($date)
    {
        $result = array('users_week_menu' => array());

        $sel_courses = $this->db->query('
            SELECT `uc_id`, `uc_user_id`, `uc_course_id`, `uc_date_start`, `uc_date_end`, `uc_display`,
              `crs_category`, `user_email`, `s_unsubscribe`
            FROM `users_courses`
            LEFT JOIN `courses` ON `crs_id`=`uc_course_id`
            LEFT JOIN `users` ON `user_id`=`uc_user_id`
            LEFT JOIN `subscription` ON `s_email`=`user_email`
            WHERE `uc_display`=1 and `crs_category`="nutrition" and `s_unsubscribe`=0');

        if($sel_courses !== false and 0 < $sel_courses->num_rows())
        {
            //log_message('debug', __METHOD__.' '.print_r($sel_courses->result(), true));

            $i = 0;
            foreach($sel_courses->result() as $row)
            {
                $result['users_week_menu'][$i]['uc_id']      = $row->uc_id;
                $result['users_week_menu'][$i]['course_id']  = $row->uc_course_id;
                $result['users_week_menu'][$i]['user_id']    = $row->uc_user_id;
                $result['users_week_menu'][$i]['user_email'] = $row->user_email;
                $result['users_week_menu'][$i]['date_start'] = $row->uc_date_start;
                $result['users_week_menu'][$i]['date_end']   = $row->uc_date_end;

                $course = self::getUserCourseSettings($row->uc_id, $row->uc_user_id);
                $menu   = self::getUserNutritionMenu($row->uc_id, $row->uc_user_id, $date);

                $result['users_week_menu'][$i] = array_merge($result['users_week_menu'][$i], $menu, $course);

                $i++;
            }
            unset($row);

            //log_message('debug', __METHOD__.' '.print_r($result['users_week_menu'], true));
        }
        elseif($sel_courses === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /* КОНЕЦ БЛОКА ОБРАБОТКИ ДАННЫХ КУРСА ПОЛЬЗОВАТЕЛЕЙ */


    /* НАЧАЛО БЛОКА ОБРАБОТКИ ДАННЫХ ПРИЕМА ПИЩИ ПОЛЬЗОВАТЕЛЯ */

    /**
     * Сохранение данных приема пищи пользователя
     *
     * @param $user_id
     * @param $ingr_weights
     * @param $meal_datetime
     * @param $date
     *
     * @return bool
     */
    public function addNewUserMeal($user_id, $ingr_weights, $meal_datetime, $date)
    {
        $result = false;

        if(is_array($ingr_weights))
        {
            $values = '';
            foreach($ingr_weights as $ml_id => $weight)
            {
            	if(is_numeric($weight) and $weight > 0)
            	{
		            if(!empty($values))
		            {
			            $values .= ', ';
		            }

		            $values .= '(' . $user_id . ', ' . $ml_id . ', "' . $weight . '", "' . $meal_datetime. '", "' . $date . '")';
	            }
            }
            unset($ml_id);
            unset($weight);

            if(!empty($values))
            {
                $ins_data = $this->db->query('
                    INSERT INTO `users_day_meals`(`udm_u_id`, `udm_ml_id`, `udm_ml_weight`, `udm_datetime`, `udm_update`) 
                    VALUES ' . $values);

                if($ins_data !== false and 0 < $this->db->affected_rows())
                {
                    $result = true;
                }
                elseif($ins_data === false)
                {
                    parent::logDbMessages(__METHOD__.':'.__LINE__);
                }
            }
        }

        return $result;
    }

    /* КОНЕЦ БЛОКА ОБРАБОТКИ ДАННЫХ ПРИЕМА ПИЩИ ПОЛЬЗОВАТЕЛЯ */


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
            SELECT `cr_id`, `cr_review`, `cr_approval`, `cr_date_add`, `uc_id` 
            FROM `courses_reviews`
             LEFT JOIN `users_courses` ON `uc_course_id`=`cr_crs_id`
            WHERE `uc_id`=? and `cr_u_id`=?', array($course_id, $user_id));

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
            parent::logDbMessages(__METHOD__.':'.__LINE__);
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
            SELECT `cr_id`, `cr_review`, `cr_approval`, `cr_date_add`, `uc_id` 
            FROM `courses_reviews` 
             LEFT JOIN `users_courses` ON `uc_course_id`=`cr_crs_id`
            WHERE `cr_id`=? and `uc_id`=? and `cr_u_id`=? LIMIT 1', array($review_id, $course_id, $user_id));

        if ($sel_review !== false and 1 == $sel_review->num_rows())
        {
            $row = $sel_review->row();

            $result['review'] = self::parseCourseReviewData($row);
        }
        elseif ($sel_review === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Сохранение отзыва пользователя о курсе
     *
     * @param $user_course_id
     * @param $user_id
     * @param $review_text
     * @param $date
     * @return bool
     */
    public function setUserCourseReview($user_course_id, $user_id, $review_text, $date)
    {
        $result = false;

        if(is_numeric($user_course_id))
        {
            $up_data = $this->db->query('
            INSERT INTO `courses_reviews` (`cr_crs_id`, `cr_u_id`, `cr_review`, `cr_date_add`, `cr_update`) VALUES (?, ?, ?, ?, ?)',
                array($user_course_id, $user_id, $review_text, $date, $date));
            if ($up_data !== false and 1 == $this->db->affected_rows())
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
            parent::logDbMessages(__METHOD__.':'.__LINE__);
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
            parent::logDbMessages(__METHOD__.':'.__LINE__);
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
            parent::logDbMessages(__METHOD__.':'.__LINE__);
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
            parent::logDbMessages(__METHOD__.':'.__LINE__);
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
            parent::logDbMessages(__METHOD__.':'.__LINE__);
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
            parent::logDbMessages(__METHOD__.':'.__LINE__);
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
            parent::logDbMessages(__METHOD__.':'.__LINE__);
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
            parent::logDbMessages(__METHOD__.':'.__LINE__);
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
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /* КОНЕЦ БЛОКА ОБРАБОТКИ ДАННЫХ ОТЗЫВОВ О КУРСЕ */


    /* НАЧАЛО БЛОКА ОБРАБОТКИ ДАННЫХ ПРОМОКОДОВ КУРСА */

    /**
     * Выборка промокодов
     *
     * @param $date
     * @return array
     */
    public function getPromocodes($date)
    {
        $result = array('promocodes' => array());

        $sel_data = $this->db->query('
            SELECT `pc_id`, `pc_name`, `pc_description`, `pc_discount`, `pc_period_validity_type`, 
              `pc_pv_date_start`, `pc_pv_date_end`, `pc_use_amount_type`, `pc_ua_number`, `pc_code`, `pc_blocked`, 
              `pc_admin_id`, `pc_date_add`, `pc_update` 
            FROM `promocodes`');

        if($sel_data !== false and 0 < $sel_data->num_rows())
        {
            $i = 0;

            foreach($sel_data->result() as $row)
            {
                $result['promocodes'][$i] = self::parsePromocodeData($row, $date);

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
     * Выборка данных промокода курса
     *
     * @param $promocode_id
     * @param $date
     * @return array
     */
    public function getPromocode($promocode_id, $date)
    {
        $result = array('promocode' => array());

        $sel_data = $this->db->query('
            SELECT `pc_id`, `pc_type`, `pc_crs_cats`, `pc_name`, `pc_description`, `pc_discount`, `pc_discount_type`, `pc_relative_percent`, 
              `pc_period_validity_type`, `pc_pv_date_start`, `pc_pv_date_end`, `pc_use_amount_type`, `pc_ua_number`, 
              `pc_code`, `pc_blocked`, `pc_admin_id`, `pc_date_add`, `pc_update` 
            FROM `promocodes`
            WHERE `pc_id`=? LIMIT 1', $promocode_id);

        if($sel_data !== false and 1 == $sel_data->num_rows())
        {
            $row = $sel_data->row();

            $result['promocode'] = self::parsePromocodeData($row, $date);

            $promocode_courses = self::getPromocodeCourses($promocode_id, $row->pc_type);

            $result['promocode'] = array_merge($result['promocode'], $promocode_courses);
        }
        elseif($sel_data === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Выборка данных промокода для друга
     *
     * @return array
     */
    public function getPromocodeForFriend($user_id)
    {
        $result = array('pc_for_friend' => array());

        $sel_data = $this->db->query('
            SELECT `pc_name`, `pc_description`, `pc_discount`, `pc_discount_type`, `pc_relative_percent` 
            FROM `promocodes`
            WHERE `pc_id`=1 LIMIT 1');

        if($sel_data !== false and 1 == $sel_data->num_rows())
        {
            $row = $sel_data->row();

            $result['pc_for_friend'] = self::parsePromocodeData($row);

            $sel_pff = $this->db->query('SELECT `pff_code` FROM `promocodes_for_friend` WHERE `pff_u_id`=? LIMIT 1', $user_id);
            if($sel_pff !== false and 1 == $sel_pff->num_rows())
            {
                $row = $sel_pff->row();
                $result['pc_for_friend']['user_code'] = $row->pff_code;
            }
            elseif($sel_pff === false)
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
     * Сохранение проокода для друга
     *
     * @param $generated_code
     * @param $user_id
     * @param $date
     * @return bool
     */
    public function setNewFriendPromocode($generated_code, $user_id, $date)
    {
        $result = false;

        $ins_data = $this->db->query('
            INSERT INTO `promocodes_for_friend`(`pff_code`, `pff_u_id`, `pff_date_add`) 
            VALUES (?, ?, ?)', array($generated_code, $user_id, $date));

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
     * Выборка курсов промокода
     *
     * @param $promocode_id
     * @param $promocode_type
     * @return array
     */
    public function getPromocodeCourses($promocode_id, $promocode_type)
    {
        $result = array('courses' => array(), 'courses_ids' => array());

        $sel_data = $this->db->query('SELECT `pcc_pc_id`, `pcc_crs_id`, `pcc_update`, `pcc_admin_id`, `crs_name` 
            FROM `promocode_courses` 
            LEFT JOIN `courses` ON `crs_id`=`pcc_crs_id`
            WHERE `pcc_pc_id`=?', $promocode_id);
        if($promocode_type == 'course')
        {
            $this->db->limit(1);
        }
        if($sel_data !== false and 0 < $sel_data->num_rows())
        {
            $i = 0;
            foreach($sel_data->result() as $row)
            {
                $result['courses'][$i]['id']   = $row->pcc_crs_id;
                $result['courses'][$i]['name'] = $row->crs_name;

                $result['courses_ids'][$i] = $row->pcc_crs_id;

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
     * Добавление нового промокода курса
     *
     * @param $pc_type
     * @param $name
     * @param $desc
     * @param $discount
     * @param $discount_type
     * @param $rel_percent
     * @param $validity_type
     * @param $pv_date_start
     * @param $pv_date_end
     * @param $use_type
     * @param $ua_number
     * @param $promocode
     * @param $courses
     * @param $crs_categories
     * @param $coach_id
     * @param $admin_id
     * @param $date
     * @return bool|int
     * @internal param $course_id
     * @internal param $category
     */
    public function setNewPromocode($pc_type, $name, $desc, $discount, $discount_type, $rel_percent, $validity_type,
                                    $pv_date_start, $pv_date_end, $use_type, $ua_number, $promocode, $courses,
                                    $crs_categories, $coach_id, $admin_id, $date)
    {
        $result = false;

        $ins_data = $this->db->query('
            INSERT INTO `promocodes` (`pc_type`, `pc_crs_cats`, `pc_name`, `pc_description`, `pc_discount`, `pc_discount_type`, `pc_relative_percent`,
              `pc_period_validity_type`, `pc_pv_date_start`, `pc_pv_date_end`, `pc_use_amount_type`, `pc_ua_number`, 
              `pc_code`, `pc_coach_id`, `pc_admin_id`, `pc_date_add`, `pc_update`)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)',
                array($pc_type, $crs_categories, $name, $desc, $discount, $discount_type, $rel_percent, $validity_type,
                    $pv_date_start, $pv_date_end, $use_type, $ua_number, $promocode, $coach_id, $admin_id, $date, $date));

        if($ins_data !== false and 1 == $this->db->affected_rows())
        {
            $result = $this->db->insert_id();

            if(!empty($courses['insert']))
            {
                self::updatePromocodeCourses($result, $courses, $admin_id, $date);
            }
        }
        elseif($ins_data === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Обновление данных промокода курса
     *
     * @param $promocode_id
     * @param $pc_type
     * @param $name
     * @param $desc
     * @param $discount
     * @param $discount_type
     * @param $rel_percent
     * @param $validity_type
     * @param $pv_date_start
     * @param $pv_date_end
     * @param $use_type
     * @param $ua_number
     * @param $generated_code
     * @param $crs_categories
     * @param $admin_id
     * @param $date
     * @param int $coach_id
     * @return bool
     */
    public function updatePromocode($promocode_id, $pc_type, $name, $desc, $discount, $discount_type, $rel_percent,
                                    $validity_type, $pv_date_start, $pv_date_end, $use_type, $ua_number, $generated_code,
                                    $crs_categories, $admin_id, $date, $coach_id = 0)
    {
        $result = false;

        $up_data = $this->db->query('
            UPDATE `promocodes` SET `pc_type`=?, `pc_crs_cats`=?, `pc_name`=?, `pc_description`=?, `pc_discount`=?, `pc_discount_type`=?, 
              `pc_relative_percent`=?, `pc_period_validity_type`=?, `pc_pv_date_start`=?, `pc_pv_date_end`=?, 
              `pc_use_amount_type`=?, `pc_ua_number`=?, `pc_code`=?, `pc_coach_id`=?, `pc_admin_id`=?, `pc_update`=?
            WHERE `pc_id`=? LIMIT 1',
                array($pc_type, $crs_categories, $name, $desc, $discount, $discount_type, $rel_percent, $validity_type,
                    $pv_date_start, $pv_date_end, $use_type, $ua_number, $generated_code, $coach_id, $admin_id, $date, $promocode_id));

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
     * Обновление данных промокода курса
     *
     * @param int $coach_id
     * @param $promocode_id
     * @param $pc_type
     * @param $name
     * @param $desc
     * @param $discount
     * @param $discount_type
     * @param $rel_percent
     * @param $validity_type
     * @param $pv_date_start
     * @param $pv_date_end
     * @param $use_type
     * @param $ua_number
     * @param $generated_code
     * @param $crs_categories
     * @param $date
     * @return bool
     */
    public function updateCoachPromocode($coach_id, $promocode_id, $pc_type, $name, $desc, $discount, $discount_type, $rel_percent,
                                    $validity_type, $pv_date_start, $pv_date_end, $use_type, $ua_number, $generated_code,
                                    $crs_categories, $date)
    {
        $result = false;

        $up_data = $this->db->query('
            UPDATE `promocodes` SET `pc_type`=?, `pc_crs_cats`=?, `pc_name`=?, `pc_description`=?, `pc_discount`=?, `pc_discount_type`=?, 
              `pc_relative_percent`=?, `pc_period_validity_type`=?, `pc_pv_date_start`=?, `pc_pv_date_end`=?, 
              `pc_use_amount_type`=?, `pc_ua_number`=?, `pc_code`=?, `pc_update`=?
            WHERE `pc_id`=? and `pc_coach_id`=? LIMIT 1',
                array($pc_type, $crs_categories, $name, $desc, $discount, $discount_type, $rel_percent, $validity_type,
                    $pv_date_start, $pv_date_end, $use_type, $ua_number, $generated_code, $date, $promocode_id, $coach_id));

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
     * Обновление данных курсов промокода
     *
     * @param $promocode_id
     * @param $courses
     * @param $admin_id
     * @param $date
     * @return bool
     */
    public function updatePromocodeCourses($promocode_id, $courses, $admin_id, $date)
    {
        $result = true;

        if(!empty($courses['insert']))
        {
            foreach($courses['insert'] as $crs_id)
            {
                $ins_data = $this->db->query('INSERT INTO `promocode_courses`(`pcc_pc_id`, `pcc_crs_id`, `pcc_update`, `pcc_admin_id`) VALUES (?, ?, ?, ?)',
                    array($promocode_id, $crs_id, $date, $admin_id));
                if($ins_data === false)
                {
                    parent::logDbMessages(__METHOD__.':'.__LINE__);
                    $result = false;
                }
            }
            unset($crs_id);
        }

        if(!empty($courses['delete']))
        {
            foreach($courses['delete'] as $crs_id)
            {
                $ins_data = $this->db->query('DELETE FROM `promocode_courses` WHERE `pcc_pc_id`=? and `pcc_crs_id`=? LIMIT 1',
                    array($promocode_id, $crs_id));
                if($ins_data === false)
                {
                    parent::logDbMessages(__METHOD__.':'.__LINE__);
                    $result = false;
                }
            }
            unset($crs_id);
        }

        if(!empty($courses['update']))
        {
            foreach($courses['update'] as $crs_id)
            {
                $ins_data = $this->db->query('UPDATE `promocode_courses` SET `pcc_crs_id`=?, `pcc_update`=? WHERE `pcc_pc_id`=? LIMIT 1',
                    array($crs_id, $date, $promocode_id));
                if($ins_data === false)
                {
                    parent::logDbMessages(__METHOD__.':'.__LINE__);
                    $result = false;
                }
            }
            unset($crs_id);
        }

        return $result;
    }

    /**
     * Блокировка/разблокировка промокода курса
     *
     * @param $promocode_id
     * @param $block
     * @param $admin_id
     * @param $date
     * @param int $coach_id
     * @return bool
     */
    public function blockPromocode($promocode_id, $block, $admin_id, $date, $coach_id = 0)
    {
        $up_data = $this->db->query('
            UPDATE `promocodes` SET `pc_blocked`=?, `pc_admin_id`=?, `pc_update`=?, `pc_coach_id`=? WHERE `pc_id`=? LIMIT 1',
                array($block, $admin_id, $date, $coach_id, $promocode_id));

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

    /**
     * Подсчет кол-ва использования промокода
     *
     * @param $promocode_id
     * @return array
     */
    public function getPromocodeUsedAmount($promocode_id)
    {
        $result = array('used_amount' => 0);

        $sel_data = $this->db->query('SELECT COUNT(`pcu_pc_id`) as `used_amount` FROM `promocodes_used` WHERE `pcu_pc_id`=?', $promocode_id);

        if($sel_data !== false and 1 == $sel_data->num_rows())
        {
            $row = $sel_data->row();

            $result['used_amount'] = $row->used_amount;
        }
        elseif($sel_data === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Поиск промокода курса
     *
     * @param $course_id
     * @param $promocode
     * @param $user_id
     * @param $date
     * @return array
     */
    public function getAvailableCoursePromocode($course_id, $promocode, $user_id, $date)
    {
        $result = array('discount' => false, 'id' => null);

        if(is_numeric($course_id) and is_numeric($user_id) and !empty($promocode) and strlen($promocode) >=1 and strlen($promocode) <= 25)
        {
            // Поиск промокода
            $sel_promo_data = $this->db->query('
                SELECT `pc_id`, `pc_type`, `pc_crs_cats`, `pc_discount`, `pc_discount_type`, `pc_relative_percent`, 
                  `pc_period_validity_type`, `pc_pv_date_start`, `pc_pv_date_end`, `pc_use_amount_type`, 
                  `pc_ua_number`, `pc_blocked` 
                FROM `promocodes`
                WHERE `pc_code`=? LIMIT 1', $promocode);

            if($sel_promo_data !== false and 1 == $sel_promo_data->num_rows())
            {
                $row = $sel_promo_data->row();

                // Данные промокода
                $promocode_data = self::parsePromocodeData($row, $date);

                // Промокод активен
                if($promocode_data['active'] === true)
                {
                    if($row->pc_type == 'all')
                    {
                        $result['discount']      = $promocode_data['discount'];
                        $result['discount_type'] = $promocode_data['discount_type'];
                        $result['rel_percent']   = $promocode_data['relative_percent'];
                        $result['id']            = $promocode_data['id'];
                    }
                    elseif($row->pc_type == 'courses')
                    {
                        $sel_promo_courses = $this->db->query('
                            SELECT `pcc_pc_id`, `pcc_crs_id` FROM `promocode_courses` WHERE `pcc_crs_id`=? and `pcc_pc_id`=? LIMIT 1',
                            array($course_id, $row->pc_id));
                        if($sel_promo_courses !== false and 1 == $sel_promo_courses->num_rows())
                        {
                            $result['discount']      = $promocode_data['discount'];
                            $result['discount_type'] = $promocode_data['discount_type'];
                            $result['rel_percent']   = $promocode_data['relative_percent'];
                            $result['id']            = $promocode_data['id'];
                        }
                    }
                    else
                    {
                        $course_data = self::getAvailableCourse($course_id);

                        $pc_crs_cats = (!empty($row->pc_crs_cats)) ? explode(';', $row->pc_crs_cats) : '';

                        if(($row->pc_type == 'workouts' and $course_data['course']['category'] == 'workout')
                            or ($row->pc_type == 'nutritions' and $course_data['course']['category'] == 'nutrition')
                            or ($row->pc_type == 'categories' and in_array($course_data['course']['type'], $pc_crs_cats)))
                        {
                            $result['discount']      = $promocode_data['discount'];
                            $result['discount_type'] = $promocode_data['discount_type'];
                            $result['rel_percent']   = $promocode_data['relative_percent'];
                            $result['id']            = $promocode_data['id'];
                        }

                        unset($course_data);
                    }

                    // Если категория промокода основной курс, возвращаем данные скидки
                    /*if($promocode_data['category'] == 'course')
                    {
                        $result['discount'] = $promocode_data['discount'];
                        $result['id']       = $promocode_data['id'];
                    }
                    // Если категория промокода курсы продления, проверям курсы продления и покупал ли пользователь основной курс
                    elseif($promocode_data['category'] == 'extend')
                    {
                        $course_data = self::checkToBoughtUserCourse($row->pc_crs_id, $user_id);

                        if($course_data['bought'] === true)
                        {
                            $sel_extend = $this->db->query('SELECT `ce_weeks_after` FROM `courses_extends`
                                WHERE `ce_extend_crs_id`=? and `ce_pc_id`=? and `ce_blocked`=0 LIMIT 1',
                                    array($course_id, $promocode_data['id']));

                            if($sel_extend !== false and 1 == $sel_extend->num_rows())
                            {
                                $row2 = $sel_extend->row();

                                $tmp_date = new DateTime($date);
                                $today    = $tmp_date->format('Y-m-d');
                                $tmp_date2 = new DateTime($course_data['date_end']);
                                $tmp_date2->add(new DateInterval('P' . $row2->ce_weeks_after * 7 . 'D'));
                                $weeks_after = $tmp_date2->format('Y-m-d');

                                // Если срок покупки курса продления не истек, возвращаем данные скидки
                                if($today < $weeks_after)
                                {
                                    $result['discount'] = $promocode_data['discount'];
                                    $result['id']       = $promocode_data['id'];
                                }
                            }
                            elseif($sel_extend === false)
                            {
                                parent::logDbMessages(__METHOD__.':'.__LINE__);
                            }
                        }
                    }*/
                }

                // Промокод активен
                /*if($promocode_data['active'] === true and $row->pc_type == 'all')
                {

                    $result['discount'] = $promocode_data['discount'];
                    $result['discount_type'] = $promocode_data['discount_type'];
                    $result['id']       = $promocode_data['id'];

                    // Если категория промокода основной курс, возвращаем данные скидки
                    if($promocode_data['category'] == 'course')
                    {
                        $result['discount'] = $promocode_data['discount'];
                        $result['id']       = $promocode_data['id'];
                    }
                    // Если категория промокода курсы продления, проверям курсы продления и покупал ли пользователь основной курс
                    elseif($promocode_data['category'] == 'extend')
                    {
                        $course_data = self::checkToBoughtUserCourse($row->pc_crs_id, $user_id);

                        if($course_data['bought'] === true)
                        {
                            $sel_extend = $this->db->query('SELECT `ce_weeks_after` FROM `courses_extends` 
                                WHERE `ce_extend_crs_id`=? and `ce_pc_id`=? and `ce_blocked`=0 LIMIT 1',
                                    array($course_id, $promocode_data['id']));

                            if($sel_extend !== false and 1 == $sel_extend->num_rows())
                            {
                                $row2 = $sel_extend->row();

                                $tmp_date = new DateTime($date);
                                $today    = $tmp_date->format('Y-m-d');
                                $tmp_date2 = new DateTime($course_data['date_end']);
                                $tmp_date2->add(new DateInterval('P' . $row2->ce_weeks_after * 7 . 'D'));
                                $weeks_after = $tmp_date2->format('Y-m-d');

                                // Если срок покупки курса продления не истек, возвращаем данные скидки
                                if($today < $weeks_after)
                                {
                                    $result['discount'] = $promocode_data['discount'];
                                    $result['id']       = $promocode_data['id'];
                                }
                            }
                            elseif($sel_extend === false)
                            {
                                parent::logDbMessages(__METHOD__.':'.__LINE__);
                            }
                        }
                    }
                }*/

                unset($row);
            }
            elseif($sel_promo_data !== false and 0 == $sel_promo_data->num_rows())
            {
                $sel_promo_data = $this->db->query('
                    SELECT `pff_code`, `pc_id`, `pc_type`, `pc_discount`, `pc_discount_type`, `pc_relative_percent`, 
                      `pc_period_validity_type`, `pc_pv_date_start`, `pc_pv_date_end`, `pc_use_amount_type`, `pc_ua_number`, 
                      `pc_blocked` 
                    FROM `promocodes_for_friend` 
                    LEFT JOIN `promocodes` ON `pc_id`=1
                    WHERE `pff_code`=? LIMIT 1', $promocode);

                if($sel_promo_data !== false and 1 == $sel_promo_data->num_rows())
                {
                    $row = $sel_promo_data->row();

                    // Данные промокода
                    $promocode_data = self::parsePromocodeData($row, $date);

                    // Промокод активен
                    if ($promocode_data['active'] === true)
                    {
                        if ($row->pc_type == 'all')
                        {
                            $result['discount'] = $promocode_data['discount'];
                            $result['discount_type'] = $promocode_data['discount_type'];
                            $result['rel_percent'] = $promocode_data['relative_percent'];
                            $result['id'] = $promocode_data['id'];
                        }
                        else
                        {
                            $sel_promo_courses = $this->db->query('
                                SELECT `pcc_pc_id`, `pcc_crs_id` FROM `promocode_courses` WHERE `pcc_crs_id`=? AND `pcc_pc_id`=? LIMIT 1',
                                array($course_id, $row->pc_id));
                            if ($sel_promo_courses !== false and 1 == $sel_promo_courses->num_rows())
                            {
                                $result['discount'] = $promocode_data['discount'];
                                $result['discount_type'] = $promocode_data['discount_type'];
                                $result['rel_percent'] = $promocode_data['relative_percent'];
                                $result['id'] = $promocode_data['id'];
                            }
                        }
                    }

                    unset($row);
                }
                elseif($sel_promo_data === false)
                {
                    parent::logDbMessages(__METHOD__.':'.__LINE__);
                }
            }
            elseif($sel_promo_data === false)
            {
                parent::logDbMessages(__METHOD__.':'.__LINE__);
            }
        }

        return $result;
    }

    /**
     * Поиск промокода
     *
     * @param $promocode
     * @param $user_id
     * @param $date
     * @return array
     * @throws Exception
     */
    public function getAvailablePromocode($promocode, $user_id, $date)
    {
        $result = array('discount' => false, 'id' => null);

        if(!empty($promocode) and strlen($promocode) >=1 and strlen($promocode) <= 25)
        {
            // Поиск промокода
            $sel_promo_data = $this->db->query('
                SELECT `pc_id`, `pc_type`, `pc_crs_cats`, `pc_name`, `pc_description`, `pc_discount`, `pc_discount_type`, 
                  `pc_relative_percent`, `pc_period_validity_type`, `pc_pv_date_start`, `pc_pv_date_end`, 
                  `pc_use_amount_type`, `pc_ua_number`, `pc_blocked` 
                FROM `promocodes`
                WHERE `pc_code`=? LIMIT 1', $promocode);

            if($sel_promo_data !== false and 1 == $sel_promo_data->num_rows())
            {
                $row = $sel_promo_data->row();

                // Данные промокода
                $promocode_data = self::parsePromocodeData($row, $date);

                $result = self::parseCheckPromocodeData($promocode_data, $row);

                // Информация о курсе
                if($row->pc_type == 'course')
                {
                    $sel_data = $this->db->query('
                        SELECT `pcc_pc_id`, `pcc_crs_id`, `crs_id`, `crs_name` 
                        FROM `promocode_courses`
                        LEFT JOIN `courses` ON `crs_id`=`pcc_crs_id`
                        WHERE `pcc_pc_id`=? LIMIT 1', $row->pc_id);
                    if($sel_data !== false and 1 == $sel_data->num_rows())
                    {
                        $row = $sel_data->row();

                        $result['type']   = (!empty($row->crs_name)) ? $row->crs_name : 'Курс №'.$row->crs_id;
                        $result['crs_id'] = $row->crs_id;
                    }
                    elseif($sel_data === false)
                    {
                        parent::logDbMessages(__METHOD__.':'.__LINE__);
                    }
                }

                unset($row);
            }
            elseif($sel_promo_data === false)
            {
                parent::logDbMessages(__METHOD__.':'.__LINE__);
            }
            elseif($sel_promo_data !== false and 0 == $sel_promo_data->num_rows())
            {
                // Поиск промокода для друга
                $sel_promo_data = $this->db->query('
                    SELECT `pff_code`, `pc_id`, `pc_type`, `pc_crs_cats`, `pc_name`, `pc_description`, `pc_discount`, `pc_discount_type`, 
                       `pc_relative_percent`, `pc_period_validity_type`, `pc_pv_date_start`, `pc_pv_date_end`, 
                       `pc_use_amount_type`, `pc_ua_number`, `pc_blocked` 
                    FROM `promocodes_for_friend` 
                    LEFT JOIN `promocodes` ON `pc_id`=1
                    WHERE `pff_code`=? LIMIT 1', $promocode);

                if($sel_promo_data !== false and 1 == $sel_promo_data->num_rows())
                {
                    $row = $sel_promo_data->row();

                    // Данные промокода
                    $promocode_data = self::parsePromocodeData($row, $date);

                    $result = self::parseCheckPromocodeData($promocode_data, $row);

                    unset($row);
                }
                elseif($sel_promo_data === false)
                {
                    parent::logDbMessages(__METHOD__.':'.__LINE__);
                }
            }
        }

        return $result;
    }

    /**
     * Обработка данных проверки промокода
     *
     * @param $promocode_data
     * @param $row
     * @return mixed
     * @throws Exception
     */
    protected function parseCheckPromocodeData($promocode_data, $row)
    {
        $result['status']        = ($promocode_data['active'] === true) ? 'Активен' : 'Не активен';
        $result['name']          = $promocode_data['name'];
        $result['desc']          = $promocode_data['description'];
        $result['discount']      = $promocode_data['discount'];
        $result['discount_type'] = $promocode_data['discount_type'];
        $result['rel_percent']   = $promocode_data['relative_percent'];
        $result['id']            = $promocode_data['id'];

        // Период действия
        $tmp_date1 = new DateTime($row->pc_pv_date_start);
        $tmp_date2 = new DateTime($row->pc_pv_date_end);
        $pc_dates  = $tmp_date1->format('d.m.Y') . ' - ' . $tmp_date2->format('d.m.Y');
        $result['period'] = ($row->pc_period_validity_type == 'unlimited') ? 'Не ограничен' : $pc_dates;

        // Кол-во использований
        $result['use_amount'] = ($row->pc_use_amount_type == 'unlimited') ? 'Не ограничено' : $row->pc_ua_number;

        // Действует на
        $pc_types = array('Все курсы' => 'all', 'Курсы тренировок' => 'workouts', 'Курсы питания' => 'nutritions',
            'Категории курсов' => 'categories', 'Некоторые курсы' => 'courses', 'Курс' => 'course');
        $key_type          = array_search($row->pc_type, $pc_types);
        $result['type']    = (!empty($key_type)) ? $key_type : '';
        $result['pc_type'] = $row->pc_type;
        // Категории курсов
        $result['crs_cats'] = (!empty($row->pc_crs_cats)) ? explode(';', $row->pc_crs_cats) : '';

        return $result;
    }

    /**
     * Выборка промокодов для курса
     *
     * @param $course_id
     * @param $date
     * @return array
     */
    public function getCoursePromocodes($course_id, $date)
    {
        $result = array('promocodes' => array());
        $i = 0;
        $promocodes_all = array();

        $sel_data = $this->db->query('
            SELECT `pc_id`, `pc_name`, `pc_description`, `pc_discount`, `pc_period_validity_type`, 
              `pc_pv_date_start`, `pc_pv_date_end`, `pc_use_amount_type`, `pc_ua_number`, `pc_code`, `pc_blocked`, 
              `pc_admin_id`, `pc_date_add`, `pc_update` 
            FROM `promocodes`
            WHERE `pc_type`="all"');

        if($sel_data !== false and 0 < $sel_data->num_rows())
        {
            foreach($sel_data->result() as $row)
            {
                $result['promocodes'][$i] = self::parsePromocodeData($row, $date);

                $promocodes_all[$i] = $row->pc_id;

                $i++;
            }
            unset($row);
        }
        elseif($sel_data === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        $sel_data = $this->db->query('
            SELECT `pcc_pc_id`, `pcc_crs_id`, `pc_id`, `pc_name`, `pc_description`, `pc_discount`, `pc_period_validity_type`, 
              `pc_pv_date_start`, `pc_pv_date_end`, `pc_use_amount_type`, `pc_ua_number`, `pc_code`, `pc_blocked`, 
              `pc_admin_id`, `pc_date_add`, `pc_update` 
            FROM `promocode_courses` 
            LEFT JOIN `promocodes` ON `pc_id`=`pcc_pc_id`
            WHERE `pcc_crs_id`=?', $course_id);

        if($sel_data !== false and 0 < $sel_data->num_rows())
        {
            foreach($sel_data->result() as $row)
            {
                if(!in_array($row->pc_id, $promocodes_all))
                {
                    $result['promocodes'][$i] = self::parsePromocodeData($row, $date);
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
     * Выборка промокодов курса категории продления
     *
     * @param $course_id
     * @param $date
     * @return array
     */
    public function getCourseExtendPromocodes($course_id, $date)
    {
        $result = array('promocodes' => array());

        $sel_data = $this->db->query('
            SELECT `pc_id`, `pc_name`, `pc_description`, `pc_discount`, `pc_period_validity_type`, 
              `pc_pv_date_start`, `pc_pv_date_end`, `pc_use_amount_type`, `pc_ua_number`, `pc_code`, `pc_blocked`, 
              `pc_admin_id`, `pc_date_add`, `pc_update` 
            FROM `promocodes`', $course_id);

        if($sel_data !== false and 0 < $sel_data->num_rows())
        {
            $i = 0;

            foreach($sel_data->result() as $row)
            {
                $result['promocodes'][$i] = self::parsePromocodeData($row, $date);

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
     * Выборка промокодов курса продления
     *
     * @param $course_id
     * @param $date
     * @return array
     */
    public function getExtendCoursePromocodes($course_id, $date)
    {
        $result = array('promocodes' => array());

        $sel_data = $this->db->query('
            SELECT `ce_extend_crs_id`, `pc_id`, `pc_discount`, `pc_period_validity_type`, 
              `pc_pv_date_start`, `pc_pv_date_end`, `pc_use_amount_type`, `pc_ua_number`, `pc_blocked` 
            FROM `courses_extends`
              LEFT JOIN `promocodes` ON `pc_id`=`ce_pc_id`
            WHERE `ce_extend_crs_id`=?', $course_id);

        if($sel_data !== false and 0 < $sel_data->num_rows())
        {
            $i = 0;

            foreach($sel_data->result() as $row)
            {
                $result['promocodes'][$i] = self::parsePromocodeData($row, $date);

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
     * Выборка тренеров, кот. добавили промокод
     *
     * @return array
     */
    public function getCoachesPromocodes()
    {
        $result = array('promocodes' => array());

        $sel_data = $this->db->query('
            SELECT `pc_id`, `pc_coach_id`, `user_name`, `user_image`, `user_email` 
            FROM `promocodes`
            LEFT JOIN `users` ON `user_id`=`pc_coach_id`
            WHERE `pc_coach_id`>0
            GROUP BY `pc_coach_id`');

        if($sel_data !== false and 0 < $sel_data->num_rows())
        {
            $i = 0;

            foreach($sel_data->result() as $row)
            {
                $result['coaches'][$i]['id']      = $row->pc_coach_id;

                $user_name = explode(' ', $row->user_name);
                $result['coaches'][$i]['f_name']  = !empty($row->user_name) ? $row->user_name : $row->user_email;
                $result['coaches'][$i]['name']    = $user_name[0];
                $result['coaches'][$i]['surname'] = !empty($user_name[1]) ? $user_name[1] : '';

                $result['coaches'][$i]['image']         = is_file($row->user_image) ? mb_substr($row->user_image, 1) : '';

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
     * Выборка промокодов тренера
     *
     * @param $coach_id
     * @param $date
     * @return array
     */
    public function getCoachPromocodes($coach_id, $date)
    {
        $result = array('promocodes' => array());

        $sel_data = $this->db->query('
            SELECT `pc_id`, `pc_name`, `pc_description`, `pc_discount`, `pc_period_validity_type`, 
              `pc_pv_date_start`, `pc_pv_date_end`, `pc_use_amount_type`, `pc_ua_number`, `pc_code`, `pc_blocked`, 
              `pc_admin_id`, `pc_date_add`, `pc_update` 
            FROM `promocodes`
            WHERE `pc_coach_id`=?', $coach_id);

        if($sel_data !== false and 0 < $sel_data->num_rows())
        {
            $i = 0;

            foreach($sel_data->result() as $row)
            {
                $result['promocodes'][$i] = self::parsePromocodeData($row, $date);

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
     * Выборка данных промокода курса
     *
     * @param $coach_id
     * @param $promocode_id
     * @param $date
     * @return array
     */
    public function getCoachPromocode($coach_id, $promocode_id, $date)
    {
        $result = array('promocode' => array());

        $sel_data = $this->db->query('
            SELECT `pc_id`, `pc_type`, `pc_crs_cats`, `pc_name`, `pc_description`, `pc_discount`, `pc_discount_type`, `pc_relative_percent`, 
              `pc_period_validity_type`, `pc_pv_date_start`, `pc_pv_date_end`, `pc_use_amount_type`, `pc_ua_number`, 
              `pc_code`, `pc_blocked`, `pc_admin_id`, `pc_date_add`, `pc_update`, `pcc_crs_id`, `cc_percent` 
            FROM `promocodes`
            LEFT JOIN `promocode_courses` ON `pcc_pc_id`=`pc_id`
            LEFT JOIN `courses_coaches` ON `cc_coach_id`=`pc_coach_id` and `cc_course_id`=`pcc_crs_id`
            WHERE `pc_id`=? and `pc_coach_id`=? LIMIT 1', array($promocode_id, $coach_id));

        if($sel_data !== false and 1 == $sel_data->num_rows())
        {
            $row = $sel_data->row();

            $result['promocode'] = self::parsePromocodeData($row, $date);


            if(!empty($row->pcc_crs_id) and is_numeric($row->pcc_crs_id))
            {
                $result['promocode']['coach_course_id']   = $row->pcc_crs_id;
                $result['promocode']['coach_course_diff'] = $row->cc_percent - $row->pc_discount;
            }
        }
        elseif($sel_data === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /* КОНЕЦ БЛОКА ОБРАБОТКИ ДАННЫХ ПРОМОКОДОВ КУРСА */


    /* НАЧАЛО БЛОКА ОБРАБОТКИ ДАННЫХ КУРСА ПРОДЛЕНИЯ */

    /**
     * Выборка прикрепленных курсов продления
     *
     * @param $course_id
     * @return array
     */
    public function getCourseExtends($course_id)
    {
        $result = array('extends' => array());

        $sel_data = $this->db->query('
            SELECT `ce_id`, `ce_crs_id`, `ce_extend_crs_id`, `ce_pc_id`, `ce_weeks_after`, `ce_blocked`, `ce_admin_id`, 
              `ce_date_add`, `ce_update`, `crs_name` 
            FROM `courses_extends`
            LEFT JOIN `courses` ON `crs_id`=`ce_extend_crs_id`
            WHERE `ce_crs_id`=?', $course_id);

        if($sel_data !== false and 0 < $sel_data->num_rows())
        {
            $i = 0;

            foreach($sel_data->result() as $row)
            {
                $result['extends'][$i] = self::parseCourseExtendData($row);

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
     * Выборка данных прикрепленного курса продления
     *
     * @param $course_id
     * @param $extend_id
     * @param $date
     * @return array
     */
    public function getCourseExtend($course_id, $extend_id, $date)
    {
        $result = array('extend' => array());

        $sel_data = $this->db->query('
            SELECT `ce_id`, `ce_crs_id`, `ce_extend_crs_id`, `ce_pc_id`, `ce_weeks_after`, `ce_blocked`, `ce_admin_id`, 
              `ce_date_add`, `ce_update`, `crs_name`
            FROM `courses_extends`
            LEFT JOIN `courses` ON `crs_id`=`ce_extend_crs_id`
            WHERE `ce_crs_id`=? and `ce_extend_crs_id`=? LIMIT 1', array($course_id, $extend_id));

        if($sel_data !== false and 1 == $sel_data->num_rows())
        {
            $row = $sel_data->row();

            $result['extend'] = self::parseCourseExtendData($row);
        }
        elseif($sel_data === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Выборка списка курсов, которые можно прикрепить к курсу
     *
     * @param $course_id
     * @return array
     */
    public function getPotentiallyExtendCourses($course_id = null)
    {
        $result = array('potentially_extends' => array());

        if(is_numeric($course_id))
        {
            $i = 0;
            $ext_in[$i] = $course_id;

            $sel_ext = $this->db->query('SELECT `ce_extend_crs_id` FROM `courses_extends` WHERE `ce_crs_id`=?', $course_id);
            if($sel_ext !== false and 0 < $sel_ext->num_rows())
            {
                foreach($sel_ext->result() as $row)
                {
                    $i++;
                    $ext_in[$i] = $row->ce_extend_crs_id;
                }
                unset($row);
            }
            elseif($sel_ext === false)
            {
                parent::logDbMessages(__METHOD__.':'.__LINE__);
            }

            $ext_in = implode(',', $ext_in);

            $sel_data = $this->db->query('SELECT `crs_id`, `crs_name` FROM `courses` WHERE `crs_id` NOT IN ('.$ext_in.') and `crs_archive`=0');
        }
        else
        {
            $sel_data = $this->db->query('SELECT `crs_id`, `crs_name` FROM `courses` WHERE `crs_archive`=0');
        }

        if($sel_data !== false and 0 < $sel_data->num_rows())
        {
            $i = 0;

            foreach($sel_data->result() as $row)
            {
                $result['potentially_extends'][$i]['id']   = $row->crs_id;
                $result['potentially_extends'][$i]['name'] = $row->crs_name;

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
     * Добавление нового прикрепленного курса продления
     *
     * @param $course_id
     * @param $extend_crs_id
     * @param $promocode_id
     * @param $weeks_after
     * @param $admin_id
     * @param $date
     * @return bool
     */
    public function setNewExtendCourse($course_id, $extend_crs_id, $promocode_id, $weeks_after, $admin_id, $date)
    {
        $result = false;

        $ins_data = $this->db->query('
            INSERT INTO `courses_extends` (`ce_crs_id`, `ce_extend_crs_id`, `ce_pc_id`, `ce_weeks_after`, `ce_admin_id`, `ce_date_add`, `ce_update`) 
            VALUES (?, ?, ?, ?, ?, ?, ?)', array($course_id, $extend_crs_id, $promocode_id, $weeks_after, $admin_id, $date, $date));

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
     * Обновление данных прикрепленного курса продления
     *
     * @param $course_id
     * @param $extend_crs_id
     * @param $promocode_id
     * @param $weeks_after
     * @param $admin_id
     * @param $date
     * @return bool
     */
    public function updateExtendCourse($course_id, $extend_crs_id, $promocode_id, $weeks_after, $admin_id, $date)
    {
        $result = false;

        $up_data = $this->db->query('
            UPDATE `courses_extends` SET `ce_pc_id`=?, `ce_weeks_after`=?, `ce_admin_id`=?, `ce_update`=? 
            WHERE `ce_crs_id`=? and `ce_extend_crs_id`=? LIMIT 1', array($promocode_id, $weeks_after, $admin_id, $date, $course_id, $extend_crs_id));

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
     * Блокировка/разблокировка прикрепленного курса
     *
     * @param $extend_id
     * @param $course_id
     * @param $block
     * @param $admin_id
     * @param $date
     * @return bool
     */
    public function blockExtend($course_id, $extend_id, $block, $admin_id, $date)
    {
        $up_data = $this->db->query('
            UPDATE `courses_extends` SET `ce_blocked`=?, `ce_admin_id`=?, `ce_update`=? WHERE `ce_extend_crs_id`=? and `ce_crs_id`=? LIMIT 1',
                array($block, $admin_id, $date, $extend_id, $course_id));

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

    /**
     * Данные курса продления для отображения пользователю
     *
     * @param $course_id
     * @param $date
     * @return array
     */
    public function getUserCourseExtends($course_id, $date)
    {
        $result = array('extends' => array());

        $sel_extends = $this->db->query('
            SELECT `ce_extend_crs_id`, `ce_weeks_after`, `ce_pc_id`, `crs_name`, `crs_price`, 
                   `crs_blocked`, `crs_archive` 
            FROM `courses_extends`
            LEFT JOIN `courses` ON `crs_id`=`ce_extend_crs_id`
            WHERE `ce_crs_id`=? and `crs_blocked`=0 and `crs_archive`=0', $course_id);

        if($sel_extends !== false and 0 < $sel_extends->num_rows())
        {
            $i = 0;
            foreach($sel_extends->result() as $row)
            {
                $result['extends'][$i]['extend_id']        = $row->ce_extend_crs_id;
                $result['extends'][$i]['weeks_after']      = $row->ce_weeks_after;
                $result['extends'][$i]['promocode']        = null;
                $result['extends'][$i]['course_name']      = $row->crs_name;
                $result['extends'][$i]['course_price']     = $row->crs_price;
                $result['extends'][$i]['course_new_price'] = null;

                /*$sel_promocode = self::getCoursePromocode($course_id, $row->ce_pc_id, $date);

                if(!empty($sel_promocode['promocode']) and $sel_promocode['promocode']['active'] === true)
                {
                    $ext_crs_code      = $sel_promocode['promocode']['code'];
                    $ext_code_discount = $sel_promocode['promocode']['discount'];
                    $ext_crs_new_price = $row->crs_price - (($row->crs_price * $ext_code_discount) / 100);

                    $result['extends'][$i]['promocode']        = $ext_crs_code;
                    $result['extends'][$i]['course_new_price'] = money_format('%!.2n', $ext_crs_new_price);
                }*/

                $i++;
            }
            unset($row);
        }
        elseif($sel_extends === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /* КОНЕЦ БЛОКА ОБРАБОТКИ ДАННЫХ КУРСА ПРОДЛЕНИЯ */


    /* НАЧАЛО БЛОКА ОБРАБОТКИ ДАННЫХ ПРИКРЕПЛЕННЫХ КУРСОВ */

    /**
     * Выборка прикрепленных курсов курса
     *
     * @param $course_id
     * @return array
     */
    public function getCourseAttachedCourses($course_id)
    {
        $result = array('attached_courses' => array());

        $sel_data = $this->db->query('
            SELECT `ca_id`, `ca_attached_crs_id`, `ca_blocked`, `crs_name` 
            FROM `courses_attached` 
            LEFT JOIN `courses` ON `crs_id`=`ca_attached_crs_id`
            WHERE `ca_crs_id`=?', $course_id);

        if($sel_data !== false and 0 < $sel_data->num_rows())
        {
            $i = 0;
            foreach($sel_data->result() as $row)
            {
                $result['attached_courses'][$i] = self::parseAttachedCourseData($row);

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
     * Выборка доступных(не заблокированных) прикрепленных курсов курса
     *
     * @param $course_id
     * @return array
     */
    public function getUserCourseAttachedCourses($course_id)
    {
        $result = array('attached_courses' => array());

        $sel_data = $this->db->query('
            SELECT `ca_id`, `ca_attached_crs_id`, `crs_name` 
            FROM `courses_attached` 
            LEFT JOIN `courses` ON `crs_id`=`ca_attached_crs_id`
            WHERE `ca_crs_id`=? and `ca_blocked`=0', $course_id);

        if($sel_data !== false and 0 < $sel_data->num_rows())
        {
            $i = 0;
            foreach($sel_data->result() as $row)
            {
                $result['attached_courses'][$i] = self::parseAttachedCourseData($row);

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
     * Потенциальные курсы питания для прикрепления к курсу тренировок
     *
     * @param $course_id
     * @return array
     */
    public function getPotentiallyAttachedCourses($course_id)
    {
        $result = array('attach_courses' => array());
        $attached_courses = null;

        $sel_ca = $this->db->query('SELECT `ca_id`, `ca_attached_crs_id` FROM `courses_attached` WHERE `ca_crs_id`=?', $course_id);

        if($sel_ca !== false and 0 < $sel_ca->num_rows())
        {
            $i = 0;
            foreach($sel_ca->result() as $row)
            {
                $attached_courses[$i] = $row->ca_attached_crs_id;

                $i++;
            }
            unset($row);
            unset($i);
        }
        elseif($sel_ca === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        $sel_data = $this->db->query('SELECT `crs_id`, `crs_name` FROM `courses` WHERE `crs_category`="nutrition"');

        if($sel_data !== false and 0 < $sel_data->num_rows())
        {
            $i = 0;
            foreach($sel_data->result() as $row)
            {
                if(!is_array($attached_courses) or (is_array($attached_courses) and !in_array($row->crs_id, $attached_courses)))
                {
                    $result['attach_courses'][$i]['id']   = $row->crs_id;
                    $result['attach_courses'][$i]['name'] = $row->crs_name;
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
     * Прикрепление курса к курсу
     *
     * @param $course_id
     * @param $attach_crs_id
     * @param $admin_id
     * @param $date
     * @return bool
     */
    public function attachNewCourse($course_id, $attach_crs_id, $admin_id, $date)
    {
        $result = false;

        $ins_data = $this->db->query('
            INSERT INTO `courses_attached`(`ca_crs_id`, `ca_attached_crs_id`, `ca_admin_id`, `ca_date`) 
            VALUES (?, ?, ?, ?)', array($course_id, $attach_crs_id, $admin_id, $date));

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
     * Блокировка/разблокировка прикрепленного курса
     *
     * @param $course_id
     * @param $attached_id
     * @param $block
     * @param $admin_id
     * @param $date
     * @return bool
     */
    public function blockAttachedCourse($course_id, $attached_id, $block, $admin_id, $date)
    {
        $result = false;

        $up_data = $this->db->query('
            UPDATE `courses_attached` SET `ca_blocked`=?, `ca_admin_id`=?, `ca_date`=? 
            WHERE `ca_crs_id`=? and `ca_attached_crs_id`=? LIMIT 1', array($block, $admin_id, $date, $course_id, $attached_id));

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

    /* КОНЕЦ БЛОКА ОБРАБОТКИ ДАННЫХ ПРИКРЕПЛЕННЫХ КУРСОВ */


    /* НАЧАЛО БЛОКА ОБРАБОТКИ ДАННЫХ КУРСА ТРЕНЕРА */

    /**
     * Выборка курсов тренера
     *
     * @param $user_id
     * @return array
     */
    public function getCoachCourses($user_id)
    {
        $result = array('courses' => array(), 'max_coach_percent' => 0);

        $sel_courses = $this->db->query('
            SELECT `cc_id`, `cc_course_id`, `cc_coach_id`, `cc_percent`, `cc_discount`, `cc_date_add`, `cc_date_update`,
              `crs_id`, `crs_image`, `crs_name`, `crs_description`, `crs_price`, `crs_recurrent_first`
            FROM `courses_coaches`
            LEFT JOIN `courses` ON `crs_id`=`cc_course_id`
            WHERE `cc_coach_id`=? and `crs_blocked`=0 and `crs_archive`=0', $user_id);

        if ($sel_courses !== false and 0 < $sel_courses->num_rows())
        {
            $i = 0;

            foreach($sel_courses->result() as $row)
            {
                $result['courses'][$i] = self::parseCourseData($row);

                // Тренеры курса
                $coaches = self::getCourseCoaches($row->crs_id);
                $result['courses'][$i] = array_merge($result['courses'][$i], $coaches);

                $result['courses'][$i]['coach_percent']  = $row->cc_percent;
                $result['courses'][$i]['coach_discount'] = $row->cc_discount;

                $result['coach_courses'][$row->cc_course_id]['coach_percent'] = $row->cc_percent;
                $result['max_coach_percent'] = (empty($result['max_coach_percent']) or $row->cc_percent < $result['max_coach_percent']) ? $row->cc_percent : $result['max_coach_percent'];

                $i++;
            }
            unset($row);
        }
        elseif ($sel_courses === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Выборка курсов, которые прикреплены к тренеру
     *
     * @param $coach_id
     * @return array
     */
    public function getPartnerCourses($coach_id)
    {
        $result = array();

        $sel_courses = $this->db->query('
            SELECT `cc_course_id`, `crs_name` 
            FROM `courses_coaches` 
            LEFT JOIN `courses` ON `cc_course_id`=`crs_id`
            WHERE `cc_coach_id`=?', $coach_id);

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
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Выборка данных курса, прикрепленного к тренеру
     *
     * @param $course_id
     * @param $coach_id
     * @return array
     */
    public function getPartnerCourse($course_id, $coach_id)
    {
        $result = array();

        $sel_course = $this->db->query('
            SELECT `cc_course_id`, `cc_percent`, `cc_discount`, `crs_name`, `crs_description`, `crs_count_weeks`, 
              `crs_count_days`, `crs_price`, `crs_fitcoin_price` 
            FROM `courses_coaches`
            LEFT JOIN `courses` ON `cc_course_id`=`crs_id`
            WHERE `cc_course_id`=? and `cc_coach_id`=? LIMIT 1', array($course_id, $coach_id));

        if ($sel_course !== false and 1 == $sel_course->num_rows())
        {
            $row = $sel_course->row();

            $result['course']['id']             = $row->cc_course_id;
            $result['course']['coach_percent']  = $row->cc_percent;
            $result['course']['coach_discount'] = ($row->cc_discount == '0.00') ? 0 : $row->cc_discount;
            $result['course']['name']           = $row->crs_name;
            $result['course']['description']    = $row->crs_description;
            $result['course']['count_weeks']    = $row->crs_count_weeks;
            $result['course']['count_days']     = $row->crs_count_days;
            $result['course']['price']          = ($row->crs_price != '0.00') ? $row->crs_price : '';
            $result['course']['fc_price']       = ($row->crs_fitcoin_price != '0.00') ? $row->crs_fitcoin_price : '';
        }
        elseif ($sel_course === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Сохранение изменений дисконта тренера на курс
     *
     * @param $course_id
     * @param $coach_id
     * @param $coach_discount
     * @param $date
     * @return bool
     */
    public function setPartnerCourseSettings($course_id, $coach_id, $coach_discount, $date)
    {
        $up_data = $this->db->query('
            UPDATE `courses_coaches` SET `cc_discount`=?, `cc_date_update`=? 
            WHERE `cc_course_id`=? and `cc_coach_id`=? LIMIT 1',
                array($coach_discount, $date, $course_id, $coach_id));

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
                        <a href="/administration/course/'.$course_id.'/video/' . $row->video_id . '" class="add_tov_cont add_tren_name">
                            <div class="add_tov_h">' . $name . '</div>
                            <input type="hidden" value="'.$row->video_id.'" name="res-video_id" id="res-video-id"/>
                        </a>
                    </div>';
            }
            unset($row);
        }
        elseif ($sel_video === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
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
        $result = false;

        if(is_numeric($user_id) and is_numeric($workout_id))
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
                            UPDATE `users_training_weeks` SET `utw_status`="done", `utw_date_update`=? 
                            WHERE `utw_id`=? LIMIT 1', array($date, $workout_id));

                        if ($up_data !== false and 1 == $this->db->affected_rows())
                        {
                            $result = true;
                        }
                        elseif ($up_data === false)
                        {
                            parent::logDbMessages(__METHOD__.':'.__LINE__);
                        }
                    }
                    elseif ($sel_course === false)
                    {
                        parent::logDbMessages(__METHOD__.':'.__LINE__);
                    }
                }
            }
            elseif ($sel_workout === false)
            {
                parent::logDbMessages(__METHOD__.':'.__LINE__);
            }
        }

        return $result;
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

    /**
     * Поиск курсов
     *
     * @param $search_text
     * @param null $coach_id
     * @return bool|string
     */
    public function searchCourses($search_text, $coach_id = null)
    {
        $result = false;

        if(is_numeric($coach_id))
        {
            if (is_numeric($search_text))
            {
                $sel_data = $this->db->query('
                    SELECT `crs_id`, `crs_name`, `crs_category`, `cc_coach_id` 
                    FROM `courses`
                    LEFT JOIN `courses_coaches` ON `cc_course_id`=`crs_id`
                    WHERE `crs_id`=? and `cc_coach_id`=? and `crs_archive`=0', array($search_text, $coach_id));
            }
            else
            {
                $search_text = $search_text.'*';

                $sel_data = $this->db->query('
                    SELECT `crs_id`, `crs_name`, `crs_category`, `cc_coach_id` 
                    FROM `courses` 
                    LEFT JOIN `courses_coaches` ON `cc_course_id`=`crs_id`
                    WHERE MATCH (`crs_name`) AGAINST (? IN BOOLEAN MODE) and `cc_coach_id`=? and `crs_archive`=0',  array($search_text, $coach_id));
            }
        }
        else
        {
            if (is_numeric($search_text))
            {
                $sel_data = $this->db->query('SELECT `crs_id`, `crs_name`, `crs_category` FROM `courses` WHERE `crs_id`=? and `crs_archive`=0', $search_text);
            }
            else
            {
                $search_text = $search_text.'*';

                $sel_data = $this->db->query('SELECT `crs_id`, `crs_name`, `crs_category` FROM `courses` 
                WHERE MATCH (`crs_name`) AGAINST (? IN BOOLEAN MODE) and `crs_archive`=0', $search_text);
            }
        }

        if ($sel_data !== false and 0 < $sel_data->num_rows())
        {
            foreach ($sel_data->result() as $row)
            {
                $result .= '<div class="add_tren_item pc_course parent" id="pc-course-' . $row->crs_id . '" data-crsid="' . $row->crs_id . '">
                    <a href="#" class="add_tov_cont add_tren_name">
                        <div class="add_tov_h">' . $row->crs_name . '</div>
                    </a>
                </div>';
            }
            unset($row);
        }
        elseif ($sel_data === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }
        else
        {
            $result = '<div class="not_found">Курс не найден</div>';
        }

        return $result;

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

        $result['id']               = $row->crs_id;
        $result['category']         = (!empty($row->crs_category)) ? $row->crs_category : null;
        $result['image']            = (!empty($row->crs_image)) ? mb_substr($row->crs_image, 1) : null;
        $result['name']             = (!empty($row->crs_name)) ? $row->crs_name : null;
        $result['description']      = (!empty($row->crs_description)) ? $row->crs_description : null;
        $result['meta_description'] = (!empty($row->crs_meta_description)) ? $row->crs_meta_description : null;
        $result['meta_keywords']    = (!empty($row->crs_meta_keywords)) ? $row->crs_meta_keywords : null;
        $result['type']             = (!empty($row->crs_type_id)) ? $row->crs_type_id : null;
        $result['count_weeks']      = (!empty($row->crs_count_weeks)) ? $row->crs_count_weeks : null;
        $result['count_days']       = (!empty($row->crs_count_days)) ? $row->crs_count_days : null;
        $result['count_rest']       = (!empty($row->crs_count_rest)) ? $row->crs_count_rest : null;
        $result['blocked']          = (!empty($row->crs_blocked)) ? $row->crs_blocked : null;
        $result['archive']          = (!empty($row->crs_archive)) ? $row->crs_archive : null;

        $price = (!empty($row->crs_price) and $row->crs_price != '0.00') ? $row->crs_price : null;
        $result['price']            = (!empty($price) and round($price) == $price) ? round($price) : $price;
        $fc_price = (!empty($row->crs_fitcoin_price) and $row->crs_fitcoin_price != '0.00') ? $row->crs_fitcoin_price : null;
        $result['fc_price']         = (!empty($fc_price) and round($fc_price) == $fc_price) ? round($fc_price) : $fc_price;
        $result['db_price']         = (!empty($row->crs_price) and $row->crs_price != '0.00') ? $row->crs_price : null;
        $result['db_fc_price']      = (!empty($row->crs_fitcoin_price) and $row->crs_fitcoin_price != '0.00') ? $row->crs_fitcoin_price : null;

        $result['recur_months']        = (!empty($row->crs_recurrent_months) and $row->crs_recurrent_months != 0) ? $row->crs_recurrent_months : null;
        $recur_price = (!empty($row->crs_recurrent_price) and $row->crs_recurrent_price != '0.00') ? $row->crs_recurrent_price : null;
        $result['recur_price']         = (!empty($recur_price) and round($recur_price) == $recur_price) ? round($recur_price) : $recur_price;
        $recur_first = (!empty($row->crs_recurrent_first) and $row->crs_recurrent_first != '0.00') ? $row->crs_recurrent_first : null;
        $result['recur_first']         = (!empty($recur_first) and round($recur_first) == $recur_first) ? round($recur_first) : $recur_first;
        $recur_subsequent = (!empty($row->crs_recurrent_subsequent) and $row->crs_recurrent_subsequent != '0.00') ? $row->crs_recurrent_subsequent : null;
        $result['recur_subsequent']    = (!empty($recur_subsequent) and round($recur_subsequent) == $recur_subsequent) ? round($recur_subsequent) : $recur_subsequent;
        $result['db_recur_price']      = (!empty($row->crs_recurrent_price) and $row->crs_recurrent_price != '0.00') ? $row->crs_recurrent_price : null;
        $result['db_recur_first']      = (!empty($row->crs_recurrent_first) and $row->crs_recurrent_first != '0.00') ? $row->crs_recurrent_first : null;
        $result['db_recur_subsequent'] = (!empty($row->crs_recurrent_subsequent) and $row->crs_recurrent_subsequent != '0.00') ? $row->crs_recurrent_subsequent : null;

        $result['new_price']        = null;
        $result['new_fc_price']     = null;
        $result['bought']           = false;
        $result['p_id']             = (!empty($row->p_id)) ? $row->p_id : null;
        $result['recurrent']        = false;

        if (!empty($result['recur_months']) and !empty($result['recur_first'])
            and !empty($result['recur_subsequent']))
        {
            $result['recurrent'] = true;
        }

        $result['landing']['id']        = (!empty($row->clp_id) and $row->clp_activated == 'activate') ? $row->clp_id : null;
        $result['landing']['activated'] = (!empty($row->clp_activated)) ? $row->clp_activated : false;

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
            'html_page' => '', 'lp_id' => '', 'hide' => false, 'bg_color' => '', 'bg_color_orig' => '', 'bg' => '', 'slider_opacity' => '', 'slider_images' => array(), 'full_slider_images' => '', 'main_title' => '', 'slider_images_default' => true,
            'block2' => array('hide' => false, 'bg_color' => '', 'bg_color_orig' => '', 'bg_top' => '', 'bg' => '', 'bg_opacity' => '', 'image' => '', 'title' => '', 'subtitle' => '', 'text' => '', 'bg_top_default' => true, 'bg_default' => true, 'image_default' => true, 'button' => ''),
            'block3' => array('hide' => false, 'bg_color' => '', 'bg_color_orig' => '', 'bg' => '', 'bg_opacity' => '', 'title' => '', 'subtitle' => '', 'image1' => '', 'image2' => '', 'image1_orig' => '', 'image2_orig' => '', 'r_title' => '', 'r_subtitle' => '', 'r_reviews' => '', 'bg_default' => true, 'image1_default' => true, 'image2_default' => true),
            'block4' => array('hide' => false, 'bg_color' => '', 'bg_color_orig' => '', 'bg' => '', 'bg_opacity' => '', 'title' => '', 'subtitle' => '', 'image' => '', 'r_title' => '', 'r_subtitle' => '', 'bg_default' => true, 'image_default' => true, 'button' => ''),
            'block5' => array('hide' => false, 'bg_color' => '', 'bg_color_orig' => '', 'bg' => '', 'bg_opacity' => '', 'title' => '', 'subtitle' => '', 'text' => '', 'image1' => '', 'image2' => '', 'image3' => '', 'image1_orig' => '', 'image2_orig' => '', 'image3_orig' => '', 'r_title' => '', 'r_subtitle' => '', 'r_text' => '', 'bg_default' => true, 'image1_default' => true, 'image2_default' => true, 'image3_default' => true, 'button' => ''),
            'block6' => array('hide' => false, 'bg_color' => '', 'bg_color_orig' => '', 'bg' => '', 'bg_opacity' => '', 'title' => '', 'desc' => '', 'subtitle' => '', 'advantages' => array(), 'image' => '', 'bg_default' => true, 'image_default' => true, 'button' => ''),
            'block7' => array('hide' => false, 'bg_color' => '', 'bg_color_orig' => '', 'bg' => '', 'bg_opacity' => '', 'image1' => '', 'image2' => '', 'image3' => '', 'image4' => '', 'texts' => array(), 'bg_default' => true, 'image1_default' => true, 'image2_default' => true, 'image3_default' => true, 'image4_default' => true, 'button' => ''),
            'block8' => array('hide' => false, 'bg_color' => '', 'bg_color_orig' => '', 'bg' => '', 'bg_opacity' => '', 'title' => '', 'desc1' => '', 'subtitle' => '', 'desc2' => '', 'old_price' => '', 'new_price' => '', 'bg_default' => true, 'button' => '')
        );

        // Путь к HTML странице landing page
        $result['html_page'] = $row->lp_html_page;
        $result['lp_id']     = !empty($row->clp_lp_id) ? $row->clp_lp_id : '';

        // Скрыть блок 1
	    $result['hide'] = ($row->clp_block1_hide == 1) ? true : false;

        // Фон страницы
        $clp_background = '';
        if (!empty($row->lp_background)) {
            if (is_file($row->lp_background)) {
                $clp_background = 'url(' . mb_substr($row->lp_background, 1) . ') top center repeat';
            }
            elseif (mb_substr($row->lp_background, 0, 1) == '#') {
                $clp_background = $row->lp_background;
            }
        }
        $result['bg'] = $clp_background;

        // Цвет фона блока
        $block1_bg_color = '';
        if(!empty($row->clp_block1_bg_color))
        {
            $f_l = mb_substr($row->clp_block1_bg_color, 0, 1);
            $rest_l = mb_substr($row->clp_block1_bg_color, 1, 6);

            $block1_bg_color = ($f_l == '#' and ctype_xdigit($rest_l)) ? $row->clp_block1_bg_color : '';
        }
        elseif(!empty($row->lp_block1_bg_color))
        {
            $f_l = mb_substr($row->lp_block1_bg_color, 0, 1);
            $rest_l = mb_substr($row->lp_block1_bg_color, 1, 6);

            $block1_bg_color = ($f_l == '#' and ctype_xdigit($rest_l)) ? $row->lp_block1_bg_color : '';
        }
        $result['bg_color']      = $block1_bg_color;
        $result['bg_color_orig'] = $row->clp_block1_bg_color;

        // Изображения для слайдера страницы
        $result['slider_images'] = '';
        if (!empty($row->clp_slider_images) and $row->clp_slider_images != 'default')
        {
            $s_images = explode(';', $row->clp_slider_images);
            $result['slider_images_default'] = false;
            $result['full_slider_images']    = $row->clp_slider_images;
        }
        else
        {
            $s_images = explode(';', $row->lp_slider_images);
        }

        if (!empty($s_images))
        {
            $i = 0;
            foreach ($s_images as $s_image)
            {
                if (is_file($s_image))
                {
                    $result['slider_images'][$i] = mb_substr($s_image, 1);

                    $i++;
                }
            }
            unset($s_image);
        }

        // Прозрачность изображений слайдера
        $result['slider_opacity'] = (is_numeric($row->clp_slider_opacity) and $row->clp_slider_opacity > 0) ? $row->clp_slider_opacity : '';

        $result['main_title']     = parent::showBBcodes($row->clp_main_title);
        $result['bbc_main_title'] = $row->clp_main_title;

        // БЛОК 2
	    // Скрыть блок 2
	    $result['block2']['hide'] = ($row->clp_block2_hide == 1) ? true : false;

        // Цвет фона блока
        $block2_bg_color = '';
        if(!empty($row->clp_block2_bg_color))
        {
            $f_l = mb_substr($row->clp_block2_bg_color, 0, 1);
            $rest_l = mb_substr($row->clp_block2_bg_color, 1, 6);

            $block2_bg_color = ($f_l == '#' and ctype_xdigit($rest_l)) ? $row->clp_block2_bg_color : '';
        }
        elseif(!empty($row->lp_block2_bg_color))
        {
            $f_l = mb_substr($row->lp_block2_bg_color, 0, 1);
            $rest_l = mb_substr($row->lp_block2_bg_color, 1, 6);

            $block2_bg_color = ($f_l == '#' and ctype_xdigit($rest_l)) ? $row->lp_block2_bg_color : '';
        }
        $result['block2']['bg_color']      = $block2_bg_color;
        $result['block2']['bg_color_orig'] = $row->clp_block2_bg_color;

        // Изображение шапки фона блока
        if (!empty($row->clp_block2_background_top) and $row->clp_block2_background_top != 'default')
        {
            $result['block2']['bg_top_default'] = false;
            $block2_background_top = (is_file($row->clp_block2_background_top))
                ? 'url(' . mb_substr($row->clp_block2_background_top, 1) . ') top center no-repeat' : '';
        }
        else
        {
            $block2_background_top = (is_file($row->lp_block2_background_top))
                ? 'url(' . mb_substr($row->lp_block2_background_top, 1) . ') top center no-repeat' : '';
        }
        $result['block2']['bg_top']      = $block2_background_top;
        $result['block2']['bg_top_orig'] = $row->clp_block2_background_top;

        // Изображение фона блока
        if ($row->clp_block2_background != 'default')
        {
            $result['block2']['bg_default'] = false;
            $block2_background = (is_file($row->clp_block2_background))
                ? 'url(' . mb_substr($row->clp_block2_background, 1) . ') top center repeat' : '';
        }
        else
        {
            $block2_background = (is_file($row->lp_block2_background))
                ? 'url(' . mb_substr($row->lp_block2_background, 1) . ') top center repeat' : '';
        }
        $result['block2']['bg']      = $block2_background;
        $result['block2']['bg_orig'] = $row->clp_block2_background;

        // Прозрачность изображения фона
        $result['block2']['bg_opacity'] = (is_numeric($row->clp_block2_bg_opacity) and $row->clp_block2_bg_opacity > 0) ? $row->clp_block2_bg_opacity : '' ;

        // Изображение блока
        if ($row->clp_block2_image != 'default')
        {
            $result['block2']['image_default'] = false;
            $block2_image = $row->clp_block2_image;
        }
        else
        {
            $block2_image = $row->lp_block2_image;
        }
        $block2_image = (!empty($block2_image) and is_file($block2_image)) ? mb_substr($block2_image, 1) : '';
        $result['block2']['image']      = $block2_image;
        $result['block2']['image_orig'] = $row->clp_block2_image;

        $result['block2']['title']    = $row->clp_block2_title;
        $result['block2']['subtitle'] = $row->clp_block2_subtitle;
        $result['block2']['text']     = $row->clp_block2_text;
        $result['block2']['button']   = strip_tags($row->clp_block2_button);

        // БЛОК 3
	    // Скрыть блок 3
	    $result['block3']['hide'] = ($row->clp_block3_hide == 1) ? true : false;

        // Цвет фона блока
        $block3_bg_color = '';
        if (!empty($row->clp_block3_bg_color))
        {
            $f_l = mb_substr($row->clp_block3_bg_color, 0, 1);
            $rest_l = mb_substr($row->clp_block3_bg_color, 1, 6);

            $block3_bg_color = ($f_l == '#' and ctype_xdigit($rest_l)) ? $row->clp_block3_bg_color : '';
        }
        elseif (!empty($row->lp_block3_bg_color))
        {
            $f_l = mb_substr($row->lp_block3_bg_color, 0, 1);
            $rest_l = mb_substr($row->lp_block3_bg_color, 1, 6);

            $block3_bg_color = ($f_l == '#' and ctype_xdigit($rest_l)) ? $row->lp_block3_bg_color : '';
        }
        $result['block3']['bg_color']      = $block3_bg_color;
        $result['block3']['bg_color_orig'] = $row->clp_block3_bg_color;

        // Изображение фона блока
        if ($row->clp_block3_background != 'default')
        {
            $result['block3']['bg_default'] = false;
            $block3_background = (is_file($row->clp_block3_background))
                ? 'url(' . mb_substr($row->clp_block3_background, 1) . ')' : '';
        }
        else
        {
            $block3_background = (is_file($row->lp_block3_background))
                ? 'url(' . mb_substr($row->lp_block3_background, 1) . ')' : '';
        }
        $result['block3']['bg']      = $block3_background;
        $result['block3']['bg_orig'] = $row->clp_block3_background;

        // Прозрачность изображения фона
        $result['block3']['bg_opacity'] = (is_numeric($row->clp_block3_bg_opacity) and $row->clp_block3_bg_opacity > 0) ? $row->clp_block3_bg_opacity : '' ;

        $result['block3']['title']      = parent::showBBcodes($row->clp_block3_title);
        $result['block3']['subtitle']   = parent::showBBcodes($row->clp_block3_subtitle);
        $result['block3']['r_title']    = parent::showBBcodes($row->clp_block3_r_title);
        $result['block3']['r_subtitle'] = parent::showBBcodes($row->clp_block3_r_subtitle);
        $result['block3']['r_reviews']  = parent::showBBcodes($row->clp_block3_r_reviews);

        $result['block3']['bbc_title']      = $row->clp_block3_title;
        $result['block3']['bbc_subtitle']   = $row->clp_block3_subtitle;
        $result['block3']['bbc_r_title']    = $row->clp_block3_r_title;
        $result['block3']['bbc_r_subtitle'] = $row->clp_block3_r_subtitle;
        $result['block3']['bbc_r_reviews']  = $row->clp_block3_r_reviews;

        // Изображения блока
        $db_bl3_img1    = $row->clp_block3_image_1;
        $db_lp_bl3_img1 = $row->lp_block3_image_1;
        if ($db_bl3_img1 != 'default')
        {
            $block3_image_1_default = false;
            $block3_image_1 = (is_file($db_bl3_img1)) ? mb_substr($db_bl3_img1, 1) : '';
        }
        else
        {
            $block3_image_1_default = true;
            $block3_image_1 = (is_file($db_lp_bl3_img1)) ? mb_substr($db_lp_bl3_img1, 1) : '';
        }
        $result['block3']['image1']         = $block3_image_1;
        $result['block3']['image1_default'] = $block3_image_1_default;
        $result['block3']['image1_orig']    = $db_bl3_img1;

        $db_bl3_img2    = $row->clp_block3_image_2;
        $db_lp_bl3_img2 = $row->lp_block3_image_2;
        if ($db_bl3_img2 != 'default')
        {
            $block3_image_2_default = false;
            $block3_image_2 = (is_file($db_bl3_img2)) ? mb_substr($db_bl3_img2, 1) : '';
        }
        else
        {
            $block3_image_2_default = true;
            $block3_image_2 = (is_file($db_lp_bl3_img2)) ? mb_substr($db_lp_bl3_img2, 1) : '';
        }
        $result['block3']['image2']         = $block3_image_2;
        $result['block3']['image2_default'] = $block3_image_2_default;
        $result['block3']['image2_orig']    = $db_bl3_img2;


        // БЛОК 4
	    // Скрыть блок 4
	    $result['block4']['hide'] = ($row->clp_block4_hide == 1) ? true : false;

        // Цвет фона блока
        $block4_bg_color = '';
        if(!empty($row->clp_block4_bg_color))
        {
            $f_l = mb_substr($row->clp_block4_bg_color, 0, 1);
            $rest_l = mb_substr($row->clp_block4_bg_color, 1, 6);

            $block4_bg_color = ($f_l == '#' and ctype_xdigit($rest_l)) ? $row->clp_block4_bg_color : '';
        }
        elseif(!empty($row->lp_block4_bg_color))
        {
            $f_l = mb_substr($row->lp_block4_bg_color, 0, 1);
            $rest_l = mb_substr($row->lp_block4_bg_color, 1, 6);

            $block4_bg_color = ($f_l == '#' and ctype_xdigit($rest_l)) ? $row->lp_block4_bg_color : '';
        }
        $result['block4']['bg_color']      = $block4_bg_color;
        $result['block4']['bg_color_orig'] = $row->clp_block4_bg_color;

        // Изображение фона блока
        if ($row->clp_block4_background != 'default')
        {
            $result['block4']['bg_default'] = false;
            $block4_background = (is_file($row->clp_block4_background))
                ? 'url(' . mb_substr($row->clp_block4_background, 1) . ')' : '';
        }
        else
        {
            $block4_background = (is_file($row->lp_block4_background))
                ? 'url(' . mb_substr($row->lp_block4_background, 1) . ')' : '';
        }
        $result['block4']['bg']      = $block4_background;
        $result['block4']['bg_orig'] = $row->clp_block4_background;

        // Прозрачность изображения фона
        $result['block4']['bg_opacity'] = (is_numeric($row->clp_block4_bg_opacity) and $row->clp_block4_bg_opacity > 0) ? $row->clp_block4_bg_opacity : '' ;

        $result['block4']['bbc_title']    = $row->clp_block4_title;
        $result['block4']['bbc_subtitle'] = $row->clp_block4_subtitle;

        $result['block4']['title']    = parent::showBBcodes($row->clp_block4_title);
        $result['block4']['subtitle'] = parent::showBBcodes($row->clp_block4_subtitle);
        $result['block4']['button']   = strip_tags($row->clp_block4_button);

        // Изображение блока
        if ($row->clp_block4_image != 'default')
        {
            $result['block4']['image_default'] = false;
            $block4_image = is_file($row->clp_block4_image) ? mb_substr($row->clp_block4_image, 1) : '';
        }
        else
        {
            $block4_image = is_file($row->lp_block4_image) ? mb_substr($row->lp_block4_image, 1) : '';
        }
        $result['block4']['image']      = $block4_image;
        $result['block4']['image_orig'] = $row->clp_block4_image;

        $result['block4']['bbc_r_title']    = $row->clp_block4_r_title;
        $result['block4']['bbc_r_subtitle'] = $row->clp_block4_r_subtitle;

        $result['block4']['r_title']    = parent::showBBcodes($row->clp_block4_r_title);
        $result['block4']['r_subtitle'] = parent::showBBcodes($row->clp_block4_r_subtitle);

        // БЛОК 5
	    // Скрыть блок 5
	    $result['block5']['hide'] = ($row->clp_block5_hide == 1) ? true : false;

        // Цвет фона блока
        $block5_bg_color = '';
        if(!empty($row->clp_block5_bg_color))
        {
            $f_l = mb_substr($row->clp_block5_bg_color, 0, 1);
            $rest_l = mb_substr($row->clp_block5_bg_color, 1, 6);

            $block5_bg_color = ($f_l == '#' and ctype_xdigit($rest_l)) ? $row->clp_block5_bg_color : '';
        }
        elseif(!empty($row->lp_block5_bg_color))
        {
            $f_l = mb_substr($row->lp_block5_bg_color, 0, 1);
            $rest_l = mb_substr($row->lp_block5_bg_color, 1, 6);

            $block5_bg_color = ($f_l == '#' and ctype_xdigit($rest_l)) ? $row->lp_block5_bg_color : '';
        }
        $result['block5']['bg_color']      = $block5_bg_color;
        $result['block5']['bg_color_orig'] = $row->clp_block5_bg_color;

        // Изображение фона блока
        if ($row->clp_block5_background != 'default')
        {
            $result['block5']['bg_default'] = false;
            $block5_background = (is_file($row->clp_block5_background))
                ? 'url(' . mb_substr($row->clp_block5_background, 1) . ')' : '';
        }
        else
        {
            $block5_background = (is_file($row->lp_block5_background))
                ? 'url(' . mb_substr($row->lp_block5_background, 1) . ')' : '';
        }
        $result['block5']['bg']      = $block5_background;
        $result['block5']['bg_orig'] = $row->clp_block5_background;

        // Прозрачность изображения фона
        $result['block5']['bg_opacity'] = (is_numeric($row->clp_block5_bg_opacity) and $row->clp_block5_bg_opacity > 0) ? $row->clp_block5_bg_opacity : '' ;

        $result['block5']['title']    = $row->clp_block5_title;
        $result['block5']['subtitle'] = $row->clp_block5_subtitle;
        $result['block5']['text']     = $row->clp_block5_text;

        // Изображения блока
        $db_bl5_img1    = $row->clp_block5_image_1;
        $db_lp_bl5_img1 = $row->lp_block5_image_1;
        if ($db_bl5_img1 != 'default')
        {
            $block5_image_1_default = false;
            $block5_image_1 = (is_file($db_bl5_img1)) ? mb_substr($db_bl5_img1, 1) : '';
        }
        else
        {
            $block5_image_1_default = true;
            $block5_image_1 = (is_file($db_lp_bl5_img1)) ? mb_substr($db_lp_bl5_img1, 1) : '';
        }
        $result['block5']['image1']         = $block5_image_1;
        $result['block5']['image1_default'] = $block5_image_1_default;
        $result['block5']['image1_orig']    = $db_bl5_img1;

        $db_bl5_img2    = $row->clp_block5_image_2;
        $db_lp_bl5_img2 = $row->lp_block5_image_2;
        if ($db_bl5_img2 != 'default')
        {
            $block5_image_2_default = false;
            $block5_image_2 = (is_file($db_bl5_img2)) ? mb_substr($db_bl5_img2, 1) : '';
        }
        else
        {
            $block5_image_2_default = true;
            $block5_image_2 = (is_file($db_lp_bl5_img2)) ? mb_substr($db_lp_bl5_img2, 1) : '';
        }
        $result['block5']['image2']         = $block5_image_2;
        $result['block5']['image2_default'] = $block5_image_2_default;
        $result['block5']['image2_orig']    = $db_bl5_img2;

        $db_bl5_img3    = $row->clp_block5_image_3;
        $db_lp_bl5_img3 = $row->lp_block5_image_3;
        if ($db_bl5_img3 != 'default')
        {
            $block5_image_3_default = false;
            $block5_image_3 = (is_file($db_bl5_img3)) ? mb_substr($db_bl5_img3, 1) : '';
        }
        else
        {
            $block5_image_3_default = true;
            $block5_image_3 = (is_file($db_lp_bl5_img3)) ? mb_substr($db_lp_bl5_img3, 1) : '';
        }
        $result['block5']['image3']        = $block5_image_3;
        $result['block5']['image3_default'] = $block5_image_3_default;
        $result['block5']['image3_orig']    = $db_bl5_img3;

        $result['block5']['r_title']    = $row->clp_block5_r_title;
        $result['block5']['r_subtitle'] = $row->clp_block5_r_subtitle;
        $result['block5']['r_text']     = $row->clp_block5_r_text;
        $result['block5']['button']     = strip_tags($row->clp_block5_button);

        // БЛОК 6
	    // Скрыть блок 6
	    $result['block6']['hide'] = ($row->clp_block6_hide == 1) ? true : false;

        // Цвет фона блока
        $block6_bg_color = '';
        if(!empty($row->clp_block6_bg_color))
        {
            $f_l = mb_substr($row->clp_block6_bg_color, 0, 1);
            $rest_l = mb_substr($row->clp_block6_bg_color, 1, 6);

            $block6_bg_color = ($f_l == '#' and ctype_xdigit($rest_l)) ? $row->clp_block6_bg_color : '';
        }
        elseif(!empty($row->lp_block6_bg_color))
        {
            $f_l = mb_substr($row->lp_block6_bg_color, 0, 1);
            $rest_l = mb_substr($row->lp_block6_bg_color, 1, 6);

            $block6_bg_color = ($f_l == '#' and ctype_xdigit($rest_l)) ? $row->lp_block6_bg_color : '';
        }
        $result['block6']['bg_color']      = $block6_bg_color;
        $result['block6']['bg_color_orig'] = $row->clp_block6_bg_color;

        // Изображение фона блока
        if ($row->clp_block6_background != 'default')
        {
            $result['block6']['bg_default'] = false;
            $block6_background = (is_file($row->clp_block6_background))
                ? 'url(' . mb_substr($row->clp_block6_background, 1) . ')' : '';
        }
        else
        {
            $block6_background = (is_file($row->lp_block6_background))
                ? 'url(' . mb_substr($row->lp_block6_background, 1) . ')' : '';
        }
        $result['block6']['bg'] = $block6_background;
        $result['block6']['bg_orig'] = $row->clp_block6_background;

        // Прозрачность изображения фона
        $result['block6']['bg_opacity'] = (is_numeric($row->clp_block6_bg_opacity) and $row->clp_block6_bg_opacity > 0) ? $row->clp_block6_bg_opacity : '' ;

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
        if ($row->clp_block6_image != 'default')
        {
            $result['block6']['image_default'] = false;
            $block6_image = is_file($row->clp_block6_image) ? mb_substr($row->clp_block6_image, 1) : '';
        }
        else
        {
            $block6_image = is_file($row->lp_block6_image) ? mb_substr($row->lp_block6_image, 1) : '';
        }
        $result['block6']['image']      = $block6_image;
        $result['block6']['image_orig'] = $row->clp_block6_image;

        // БЛОК 7
	    // Скрыть блок 7
	    $result['block7']['hide'] = ($row->clp_block7_hide == 1) ? true : false;

        // Цвет фона блока
        $block7_bg_color = '';
        if(!empty($row->clp_block7_bg_color))
        {
            $f_l = mb_substr($row->clp_block7_bg_color, 0, 1);
            $rest_l = mb_substr($row->clp_block7_bg_color, 1, 6);

            $block7_bg_color = ($f_l == '#' and ctype_xdigit($rest_l)) ? $row->clp_block7_bg_color : '';
        }
        elseif(!empty($row->lp_block7_bg_color))
        {
            $f_l = mb_substr($row->lp_block7_bg_color, 0, 1);
            $rest_l = mb_substr($row->lp_block7_bg_color, 1, 6);

            $block7_bg_color = ($f_l == '#' and ctype_xdigit($rest_l)) ? $row->lp_block7_bg_color : '';
        }
        $result['block7']['bg_color']      = $block7_bg_color;
        $result['block7']['bg_color_orig'] = $row->clp_block7_bg_color;

        // Изображение фона блока
        if ($row->clp_block7_background != 'default')
        {
            $result['block7']['bg_default'] = false;
            $block7_background = (is_file($row->clp_block7_background))
                ? 'url(' . mb_substr($row->clp_block7_background, 1) . ')' : '';
        }
        else
        {
            $block7_background = (is_file($row->lp_block7_background))
                ? 'url(' . mb_substr($row->lp_block7_background, 1) . ')' : '';
        }
        $result['block7']['bg']      = $block7_background;
        $result['block7']['bg_orig'] = $row->clp_block7_background;

        // Прозрачность изображения фона
        $result['block7']['bg_opacity'] = (is_numeric($row->clp_block7_bg_opacity) and $row->clp_block7_bg_opacity > 0) ? $row->clp_block7_bg_opacity : '' ;

        $result['block7']['title']  = $row->clp_block7_title;
        $result['block7']['button'] = strip_tags($row->clp_block7_button);

        // Изображения блока
        if ($row->clp_block7_image_1 != 'default')
        {
            $block7_image_1_default = false;
            $block7_image_1 = (is_file($row->clp_block7_image_1)) ? mb_substr($row->clp_block7_image_1, 1) : '';
        }
        else
        {
            $block7_image_1_default = true;
            $block7_image_1 = (is_file($row->lp_block7_image_1)) ? mb_substr($row->lp_block7_image_1, 1) : '';
        }
        $result['block7']['image1']        = $block7_image_1;
        $result['block7']['image1_default'] = $block7_image_1_default;
        $result['block7']['image1_orig']    = $row->clp_block7_image_1;

        if ($row->clp_block7_image_2 != 'default')
        {
            $block7_image_2_default = false;
            $block7_image_2 = (is_file($row->clp_block7_image_2)) ? mb_substr($row->clp_block7_image_2, 1) : '';
        }
        else
        {
            $block7_image_2_default = true;
            $block7_image_2 = (is_file($row->lp_block7_image_2)) ? mb_substr($row->lp_block7_image_2, 1) : '';
        }
        $result['block7']['image2']        = $block7_image_2;
        $result['block7']['image2_default'] = $block7_image_2_default;
        $result['block7']['image2_orig']    = $row->clp_block7_image_2;

        if ($row->clp_block7_image_3 != 'default')
        {
            $block7_image_3_default = false;
            $block7_image_3 = (is_file($row->clp_block7_image_3)) ? mb_substr($row->clp_block7_image_3, 1) : '';
        }
        else
        {
            $block7_image_3_default = true;
            $block7_image_3 = (is_file($row->lp_block7_image_3)) ? mb_substr($row->lp_block7_image_3, 1) : '';
        }
        $result['block7']['image3']        = $block7_image_3;
        $result['block7']['image3_default'] = $block7_image_3_default;
        $result['block7']['image3_orig']    = $row->clp_block7_image_3;

        if ($row->clp_block7_image_4 != 'default')
        {
            $block7_image_4_default = false;
            $block7_image_4 = (is_file($row->clp_block7_image_4)) ? mb_substr($row->clp_block7_image_4, 1) : '';
        }
        else
        {
            $block7_image_4_default = true;
            $block7_image_4 = (is_file($row->lp_block7_image_4)) ? mb_substr($row->lp_block7_image_4, 1) : '';
        }
        $result['block7']['image4']        = $block7_image_4;
        $result['block7']['image4_default'] = $block7_image_4_default;
        $result['block7']['image4_orig']    = $row->clp_block7_image_4;

        // Текст блока
        $result['block7']['texts'] = '';
        if (!empty($row->clp_block7_text))
        {
            $texts = explode(';', $row->clp_block7_text);

            $i = 1;
            foreach ($texts as $text)
            {
                $result['block7']['texts'][$i] = $text;

                $i++;
            }
            unset($text);
        }

        // БЛОК 8
	    // Скрыть блок 8
	    $result['block8']['hide'] = ($row->clp_block8_hide == 1) ? true : false;

        // Цвет фона блока
        $block8_bg_color = '';
        if(!empty($row->clp_block8_bg_color))
        {
            $f_l = mb_substr($row->clp_block8_bg_color, 0, 1);
            $rest_l = mb_substr($row->clp_block8_bg_color, 1, 6);

            $block8_bg_color = ($f_l == '#' and ctype_xdigit($rest_l)) ? $row->clp_block8_bg_color : '';
        }
        elseif(!empty($row->lp_block8_bg_color))
        {
            $f_l = mb_substr($row->lp_block8_bg_color, 0, 1);
            $rest_l = mb_substr($row->lp_block8_bg_color, 1, 6);

            $block8_bg_color = ($f_l == '#' and ctype_xdigit($rest_l)) ? $row->lp_block8_bg_color : '';
        }
        $result['block8']['bg_color']      = $block8_bg_color;
        $result['block8']['bg_color_orig'] = $row->clp_block8_bg_color;

        // Изображение фона блока
        if ($row->clp_block8_background != 'default')
        {
            $result['block8']['bg_default'] = false;
            $block8_background = (is_file($row->clp_block8_background)) ? 'url(' . mb_substr($row->clp_block8_background, 1) . ')' : '';
        }
        else
        {
            $block8_background = (is_file($row->lp_block8_background)) ? 'url(' . mb_substr($row->lp_block8_background, 1) . ')' : '';
        }
        $result['block8']['bg'] = $block8_background;
        $result['block8']['bg_orig'] = $row->clp_block8_background;

        // Прозрачность изображения фона
        $result['block8']['bg_opacity'] = (is_numeric($row->clp_block8_bg_opacity) and $row->clp_block8_bg_opacity > 0) ? $row->clp_block8_bg_opacity : '' ;

        $result['block8']['title']     = $row->clp_block8_title;
        $result['block8']['desc1']     = $row->clp_block8_description1;
        $result['block8']['subtitle']  = $row->clp_block8_subtitle;
        $result['block8']['desc2']     = $row->clp_block8_description2;
        $result['block8']['old_price'] = ($row->clp_block8_old_price > 0) ? $row->clp_block8_old_price : null;
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
        $result['active']      = !empty($row->video_active) ? $row->video_active : 0;
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
        $this->db->query('UPDATE `users_courses` SET `uc_coach_id`=?,`uc_days`=?,`uc_date_start`=?,`uc_date_end`=?,
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

    /**
     * Обработка данных промокода
     *
     * @param $row
     * @param $date
     * @return mixed
     */
    protected function parsePromocodeData($row, $date = null)
    {
        $result['id']                 = $row->pc_id;
        $result['type']               = (!empty($row->pc_type)) ? $row->pc_type : null;
        $result['courses_categories'] = (!empty($row->pc_crs_cats)) ? explode(';', $row->pc_crs_cats) : null;
        $result['crs_cats']           = (!empty($row->pc_crs_cats)) ? $row->pc_crs_cats : null;
        $result['name']               = (!empty($row->pc_name)) ? $row->pc_name : 'Промокод №'.$row->pc_id;
        $result['description']        = $row->pc_description;
        $result['discount']           = $row->pc_discount;
        $result['discount_type']      = $row->pc_discount_type;
        $types = array('%' => 'percent', ' руб.' => 'currency', ' бесплат. нед.' => 'free_week');
        $result['dt_unit']            = array_search($row->pc_discount_type, $types);
        $result['relative_percent']   = $row->pc_relative_percent;
        $result['validity_type']      = $row->pc_period_validity_type;
        $result['pv_date_start']      = $row->pc_pv_date_start;
        $result['pv_date_end']        = $row->pc_pv_date_end;
        $result['use_type']           = $row->pc_use_amount_type;
        $result['ua_number']          = $row->pc_ua_number;
        $result['code']               = $row->pc_code;
        $result['blocked']            = $row->pc_blocked;
        $result['admin_id']           = $row->pc_admin_id;
        $result['date_add']           = $row->pc_date_add;
        $result['update']             = $row->pc_update;
        $result['active']             = false;
        $result['active_string']      = 'Не активен';
        $result['courses']            = array();

        if(!empty($date))
        {
            $tmp_date = new DateTime($date);
            $today = $tmp_date->format('Y-m-d');

            if($row->pc_blocked == 0 and ($row->pc_period_validity_type == 'unlimited'
                or (!empty($row->pc_pv_date_end) and $row->pc_pv_date_end != '0000-00-00' and $row->pc_pv_date_end >= $today)))
            {
                $result['active']        = true;
                $result['active_string'] = 'Активен';
            }
        }
        else
        {
            $result['active']        = null;
            $result['active_string'] = '';
        }

        return $result;
    }

    /**
     * Обработка данных прикрепленных курсов продления
     *
     * @param $row
     * @return mixed
     */
    protected function parseCourseExtendData($row)
    {
        $result['id']           = $row->ce_id;
        $result['course_id']    = $row->ce_crs_id;
        $result['extend_id']    = $row->ce_extend_crs_id;
        $result['extend_name']  = $row->crs_name;
        $result['promocode_id'] = $row->ce_pc_id;
        $result['weeks_after']  = $row->ce_weeks_after;
        $result['blocked']      = $row->ce_blocked;
        $result['admin_id']     = $row->ce_admin_id;
        $result['date_add']     = $row->ce_date_add;
        $result['update']       = $row->ce_update;

        return $result;
    }

    /**
     * Обработка данных блюда
     *
     * @param $row
     * @return mixed
     */
    protected function parseMealData($row)
    {
        $result['id']               = (!empty($row->ml_id)) ? $row->ml_id : null;
        $result['category_id']      = (!empty($row->ml_category_id)) ? $row->ml_category_id : null;
        $result['type_id']          = (!empty($row->ml_mt_id)) ? $row->ml_mt_id : null;
        $result['name']             = (!empty($row->ml_name)) ? $row->ml_name : null;
        $result['description']      = (!empty($row->ml_description)) ? nl2br($row->ml_description) : null;
        $result['ingredients_text'] = (!empty($row->ml_ingredients)) ? nl2br($row->ml_ingredients) : null;
        $result['images_path']      = (!empty($row->ml_images)) ? mb_substr($row->ml_images, 1) : null;
        $result['images']           = (!empty($row->ml_images)) ? array_diff(scandir($row->ml_images), array('..', '.')) : null;
        $result['image']            = null;
        $result['weight']           = (!empty($row->ml_weight)) ? number_format($row->ml_weight, 2, '.', '') : null;
        $result['proteins']         = (!empty($row->ml_proteins)) ? number_format($row->ml_proteins, 2, '.', '') : null;
        $result['fats']             = (!empty($row->ml_fats)) ? number_format($row->ml_fats, 2, '.', ''): null;
        $result['carbohydrates']    = (!empty($row->ml_carbohydrates)) ? number_format($row->ml_carbohydrates, 2, '.', '') : null;
        $result['calories']         = (!empty($row->ml_calories)) ? number_format($row->ml_calories, 2, '.', '') : null;
        $result['blocked']          = (!empty($row->ml_blocked)) ? $row->ml_blocked : null;
        $result['ingredients']      = array();
        $result['meal_videos']      = array();

        // Поиск изображения в папке meals_img
        if(!empty($row->ml_image))
        {
            $meals_img = array_diff(scandir('./meals_img'), array('..', '.'));
            if(!empty($meals_img))
            {
                foreach($meals_img as $img)
                {
                    $path_parts = pathinfo($img);
                    if($path_parts['filename'] == $row->ml_image)
                    {
                        $result['image'] = '/meals_img/'.$img;
                        break;
                    }
                }
                unset($img);
            }
        }

        return $result;
    }

    /**
     * Обработка данных прикрепленного курса
     *
     * @param $row
     * @return mixed
     */
    protected function parseAttachedCourseData($row)
    {
        $result['id']          = (!empty($row->ca_id)) ? $row->ca_id : null;
        $result['attached_id'] = (!empty($row->ca_attached_crs_id)) ? $row->ca_attached_crs_id : null;
        $result['name']        = (!empty($row->crs_name)) ? $row->crs_name : null;
        $result['blocked']     = (!empty($row->ca_blocked)) ? $row->ca_blocked : null;

        return $result;
    }

    /**
     * Обработка данные приемов пищи пользователя
     *
     * @param $row
     *
     * @return array
     */
    protected function parseUserMeals($row)
    {
        $result = array('id' => '', 'u_id' => '', 'ml_id' => '', 'ml_weight' => '', 'datetime' => '', 'update' => '',
            'meal_date' => '', 'meal_date_details' => '');

        $result['id']        = (!empty($row->udm_id)) ? $row->udm_id : null;
        $result['u_id']      = (!empty($row->udm_u_id)) ? $row->udm_u_id : null;
        $result['ml_id']     = (!empty($row->udm_ml_id)) ? $row->udm_ml_id : null;
        $result['ml_name']   = (!empty($row->ml_name)) ? $row->ml_name : null;
        $result['ml_weight'] = (!empty($row->udm_ml_weight)) ? $row->udm_ml_weight : null;
        $result['datetime']  = (!empty($row->udm_datetime)) ? $row->udm_datetime : null;
        $result['update']    = (!empty($row->udm_update)) ? $row->udm_update : null;

        if(!empty($row->udm_datetime))
        {
            $tmp_dt = new DateTime($row->udm_datetime);
            setlocale(LC_ALL, 'ru_RU.UTF-8');
            $tmp_nd = ($tmp_dt !== false) ? strftime('%d %b %Gг.', strtotime($row->udm_datetime)) : false;
            $result['meal_date'] = ($tmp_dt !== false) ? $tmp_dt->format('Y-m-d') : null;
            $result['meal_time'] = ($tmp_dt !== false) ? $tmp_dt->format('H:i') : null;
            $result['meal_date_details'] = ($tmp_nd !== false) ? $tmp_nd : null;
        }

        $result['ml_calories']      = (!empty($row->ml_calories)) ? $row->ml_calories : null;
        $result['ml_proteins']      = (!empty($row->ml_proteins)) ? $row->ml_proteins : null;
        $result['ml_fats']          = (!empty($row->ml_fats)) ? $row->ml_fats : null;
        $result['ml_carbohydrates'] = (!empty($row->ml_carbohydrates)) ? $row->ml_carbohydrates : null;

        return $result;
    }

    /* КОНЕЦ БЛОКА ФУНКЦИЙ ОБРАБОТКИ ДАННЫХ */
}