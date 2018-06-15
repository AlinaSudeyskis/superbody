<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Класс User_model
 * 
 * Класс выборки, сохранения, изменения данных пользователя
 *
 * @author Alina Sudeyskis <alina.sudeyskis@gmail.com>
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class User_model extends CI_Model
{
    /**
     * Получение данных пользователя для определения его типа и соответствуещего вывода страницы
     *
     * @param $user_id
     * @return array
     */
    public function getUser($user_id)
    {
        $result = array('user_data' => array());
        
        $sel_user = $this->db->query('
            SELECT `user_id`, `user_type`, `user_name`, `user_email`, `user_image`, `user_blocked`
            FROM `users`
            WHERE `user_id`=? LIMIT 1', $user_id);
        
        if ($sel_user !== false and 1 == $sel_user->num_rows())
        {
            $row = $sel_user->row();
            
            $result['user_data']['id']    = $row->user_id; 
            $result['user_data']['name']  = !empty($row->user_name) ? $row->user_name : 'Пользователь';

            $split_name = !empty($row->user_name) ? explode(" ", $row->user_name) : '';
            $result['user_data']['split_name']['name']    = !empty($split_name[0]) ? $split_name[0] : 'Пользователь';
            $result['user_data']['split_name']['surname'] = !empty($split_name[1]) ? $split_name[1] : '';

            $result['user_data']['email'] = $row->user_email;
            $result['user_data']['type']  = $row->user_type;

            $result['user_data']['user_blocked'] = $row->user_blocked;

            $user_image = '';
            if (!empty($row->user_image)) {
                $user_image = $row->user_image;
                if (mb_substr($row->user_image, 0, 1) == '.' and is_file($row->user_image)) {
                    $user_image = mb_substr($row->user_image, 1);
                }
            }
            $result['user_data']['image'] = $user_image;
        }
        elseif ($sel_user === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }
        
        return $result;
    }
    
    /**
     * Получение данных пользователей
     *
     * @return array
     */
    public function getUsersData()
    {
        $result = null;
        
        $sel_data = $this->db->query('
            SELECT `user_id`, `user_name`, `user_email`, `user_password`, `user_image`, `user_blocked` 
            FROM `users` 
            WHERE `user_type`=1');

        if ($sel_data !== false and 0 < $sel_data->num_rows()) {
            $i = 0;
            foreach ($sel_data->result() as $row) {
                $result[$i]['user_id'] = $row->user_id;
                $result[$i]['user_name'] = !empty($row->user_name) ? $row->user_name : $row->user_email;
                $result[$i]['user_blocked'] = $row->user_blocked;

                $user_image = '';
                if (!empty($row->user_image)) {
                    $user_image = $row->user_image;
                    if (mb_substr($row->user_image, 0, 1) == '.' and is_file($row->user_image)) {
                        $user_image = mb_substr($row->user_image, 1);
                    }
                }
                $result[$i]['user_image'] = $user_image;
                
                $i++;
            }
        }
        elseif ($sel_data === false) {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }
        
        return $result;
    }

    /**
     * Получение данных настроек пользователя
     *
     * @param $user_id
     * @return bool|array
     */
    public function getUserSettingsData($user_id)
    {
        // Массив возвращаемых значений
        $result = array ( 'user_data' => array(
            'user_email' => '',
            'user_name' => '',
            'user_country_code' => '',
            'user_phone' => '',
            'user_image' => '',
            'user_blocked' => '',
            'user_type' => '',
            'user_password_hash' => '',
            'user_b_day' => '',
            'user_b_mon' => '',
            'user_b_year' => '',
            'user_birthday' => '',
            'user_gender' => '',
            'user_gender_eng' => '',
            'user_weight' => ''
        ));

        $sel_data = $this->db->query('
            SELECT `user_name`, `user_email`, `user_password`, `user_country_code`, `user_phone`, `user_image`, `user_blocked`, `user_type`, 
              `user_gender`, `user_birthday`
            FROM `users` 
            LEFT JOIN `questionnaire`
              ON `questionnaire`.`user_id`=`users`.`user_id`
            WHERE `users`.`user_id`=? LIMIT 1', $user_id);

        if ($sel_data !== false and 1 == $sel_data->num_rows())
        {
            $row = $sel_data->row();

            $result['user_data']['user_name']          = $row->user_name;
            $result['user_data']['user_email']         = $row->user_email;
            $result['user_data']['user_country_code']  = $row->user_country_code;
            $result['user_data']['user_phone']         = $row->user_phone;
            $result['user_data']['user_password_hash'] = $row->user_password;
            $result['user_data']['user_blocked']       = $row->user_blocked;
            $result['user_data']['user_type']          = $row->user_type;

            $user_image = '';
            if (!empty($row->user_image))
            {
                $user_image = $row->user_image;
                if (mb_substr($row->user_image, 0, 1) == '.' and is_file($row->user_image))
                {
                    $user_image = mb_substr($row->user_image, 1);
                }
            }
            $result['user_data']['user_image'] = $user_image;

            $date = DateTime::createFromFormat('Y-m-d', $row->user_birthday);
            $birthday = ($row->user_birthday != '0000-00-00' and $date !== false) ? $date->format('d.m.Y') : '';

            if (!empty($birthday)) {
                $b_day  = $date->format('d');
                $b_mon  = $date->format('m');
                $b_year = $date->format('Y');

                $result['user_data']['user_b_day']  = $b_day;
                $result['user_data']['user_b_mon']  = $b_mon;
                $result['user_data']['user_b_year'] = $b_year;
            }

            $result['user_data']['user_birthday']   = $birthday;
            $result['user_data']['user_gender']     = ($row->user_gender == 'female') ? 'Женщина' : 'Мужчина';
            $result['user_data']['user_gender_eng'] = ($row->user_gender == 'female') ? 'female' : 'male';

            $sel_weight = $this->db->query('
                SELECT `user_weight` FROM `anthropometric` WHERE `user_id`=? ORDER BY `user_date_add` DESC LIMIT 1', $user_id);

            if (1 == $sel_weight->num_rows())
            {
                $row2 = $sel_weight->row();

                $result['user_data']['user_weight'] = $row2->user_weight;
            }

            return $result;
        }
        elseif ($sel_data === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
            return false;
        }
        else
        {
            // Пользователь не найден
            return false;
        }
    }

    /**
     * Сохранение изменений регистрационных данных пользователя
     *
     * @param int $user_id ID пользователя
     * @param string $email E-mail пользователя
     * @param string $name Ф.И.О. пользователя
     * @param string $password_hash Хэш пароля
     * @param string $code Код страны
     * @param string $phone Телефон пользователя
     * @param string $path_avatar Путь к изображению пользователя
     * @param datetime $date Текущая дата
     * @return bool
     */
    public function setUserSettingsData($user_id, $email, $name, $password_hash, $code, $phone, $path_avatar, $date)
    {
        $up_data = $this->db->query('
            UPDATE `users` 
            SET `user_email`=?, `user_name`=?, `user_password`=?, `user_country_code`=?, `user_phone`=?, `user_image`=?, `user_date_update`=?
            WHERE `user_id`=? LIMIT 1', 
                array($email, $name, $password_hash, $code, $phone, $path_avatar, $date, $user_id));
        
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
     * Сохранение изменений пола и даты рождения пользователя
     *
     * @param int $user_id ID пользователя
     * @param string $gender Пол (female|male)
     * @param string $birthday Дата рождения
     * @param string $date Текущая дата
     * @return bool
     */
    public function setUserGenderBd($user_id, $gender, $birthday, $date)
    {
        $up_data = $this->db->query('
            UPDATE `questionnaire` 
            SET `user_gender`=?, `user_birthday`=?, `user_date_update`=?
            WHERE `user_id`=? LIMIT 1', array($gender, $birthday, $date, $user_id));

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
     * Список соц. сетей пользователя
     *
     * @param int $user_id
     * @return array
     */
    public function getUserSocial($user_id)
    {
        $result = array( 'user_social' => array(
            'facebook' => array('connect' => false, 'id' => null),
            'instagram' => array('connect' => false, 'id' => null),
            'ok' => array('connect' => false, 'id' => null),
            'vk' => array('connect' => false, 'id' => null)
        ));

        if (is_numeric($user_id))
        {
            $sel_social = $this->db->query('SELECT `us_social_id`, `us_social`, `us_available`, `us_url_profile` FROM `users_social` 
            WHERE `us_u_id`=? LIMIT 4', $user_id);

            if ($sel_social !== false and 0 < $sel_social->num_rows())
            {
                foreach($sel_social->result() as $row)
                {
                    $result['user_social'][$row->us_social]['connect']     = true;
                    $result['user_social'][$row->us_social]['available']   = $row->us_available;
                    $result['user_social'][$row->us_social]['profile_url'] = !empty($row->us_url_profile) ? $row->us_url_profile : '#';
                    $result['user_social'][$row->us_social]['id']          = $row->us_social_id;
                }
                unset($row);
            }
            elseif ($sel_social === false)
            {
                parent::logDbMessages(__METHOD__.':'.__LINE__);
            }
        }

        return $result;
    }

    /**
     * Сохранение настроек доступности соц. сетей пользователя
     *
     * @param $user_id
     * @param $cb_facebook
     * @param $cb_vk
     * @param $cb_ok
     * @param $cb_instagram
     * @return bool
     */
    public function setUserSocialAvailable($user_id, $cb_facebook, $cb_vk, $cb_ok, $cb_instagram)
    {
        $result = true;

        $sel_facebook = $this->db->query('
            SELECT `us_available` FROM `users_social` WHERE `us_u_id`=? and `us_social`="facebook"', $user_id);
        if ($sel_facebook !== false and 1 == $sel_facebook->num_rows())
        {
            $row = $sel_facebook->row();

            if ($row->us_available != $cb_facebook)
            {
                $this->db->query('UPDATE `users_social` SET `us_available`=? 
                    WHERE `us_u_id`=? and `us_social`="facebook" LIMIT 1', array($cb_facebook, $user_id));

                if (0 == $this->db->affected_rows())
                {
                    $result = false;
                }
            }
        }
        elseif($sel_facebook === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        $sel_vk = $this->db->query('
            SELECT `us_available` FROM `users_social` WHERE `us_u_id`=? and `us_social`="vk"', $user_id);
        if ($sel_vk !== false and 1 == $sel_vk->num_rows())
        {
            $row = $sel_vk->row();

            if ($row->us_available != $cb_vk)
            {
                $this->db->query('UPDATE `users_social` SET `us_available`=? 
                  WHERE `us_u_id`=? and `us_social`="vk" LIMIT 1', array($cb_vk, $user_id));

                if (0 == $this->db->affected_rows())
                {
                    $result = false;
                }
            }
        }
        elseif($sel_vk === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        $sel_ok = $this->db->query('
            SELECT `us_available` FROM `users_social` WHERE `us_u_id`=? and `us_social`="ok"', $user_id);
        if ($sel_ok !== false and 1 == $sel_ok->num_rows())
        {
            $row = $sel_ok->row();

            if ($row->us_available != $cb_ok)
            {
                $this->db->query('UPDATE `users_social` SET `us_available`=? 
                    WHERE `us_u_id`=? and `us_social`="ok" LIMIT 1', array($cb_ok, $user_id));

                if (0 == $this->db->affected_rows())
                {
                    $result = false;
                }
            }
        }
        elseif($sel_ok === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        $sel_instagram = $this->db->query('
            SELECT `us_available` FROM `users_social` WHERE `us_u_id`=? and `us_social`="instagram"', $user_id);
        if ($sel_instagram !== false and 1 == $sel_instagram->num_rows())
        {
            $row = $sel_instagram->row();

            if ($row->us_available != $cb_instagram)
            {

                $this->db->query('UPDATE `users_social` SET `us_available`=? 
                    WHERE `us_u_id`=? and `us_social`="instagram" LIMIT 1', array($cb_instagram, $user_id));

                if (0 == $this->db->affected_rows())
                {
                    $result = false;
                }
            }
        }
        elseif($sel_instagram === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Блокировка пользователя
     *
     * @param $user_id
     * @param $date
     * @return bool
     */
    public function blockUser($user_id, $date)
    {
        $up_data = $this->db->query('
            UPDATE `users` 
            SET `user_blocked`=1, `user_date_update`=? 
            WHERE `user_id`=? and `user_type`=1 LIMIT 1', array($date, $user_id));

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
     * Разблокировка пользователя
     *
     * @param $user_id
     * @param $date
     * @return bool
     */
    public function unblockUser($user_id, $date)
    {
        $up_data = $this->db->query('
            UPDATE `users` 
            SET `user_blocked`=0, `user_date_update`=? 
            WHERE `user_id`=? and `user_type`=1 LIMIT 1', array($date, $user_id));

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
     * Удаление аватара пользователя
     *
     * @param int $user_id
     * @return bool
     */
    public function deleteUserAvatar($user_id)
    {
        $sel_avatar = $this->db->query('SELECT `user_image` FROM `users` WHERE `user_id`=? LIMIT 1', $user_id);

        if ($sel_avatar !== false and 1 == $sel_avatar->num_rows())
        {
            $row = $sel_avatar->row();

            if (!empty($row->user_image))
            {
                if(is_file($row->user_image) and mb_substr($row->user_image, 0, 1) == '.')
                {
                    unlink($row->user_image);
                }

                $up_data = $this->db->query('UPDATE `users` SET `user_image`="" WHERE `user_id`=? LIMIT 1', $user_id);

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
            return true;
        }
        elseif ($sel_avatar === false)
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
     * Получение данных анкеты
     *
     * @param int $user_id
     * @return array
     */
    public function getQuestionnaireData($user_id)
    {
        // Массив возвращаемых значений
        $result = array (
            'user_gender' => '',
            'user_birthday' => '',
            'user_height' => '',
            'user_bmi' => '',
            'user_bmr' => '',
            'user_physical_condition' => '',
            'user_pulse' => '',
            'user_sports_history' => '',
            'user_injuries_diseases' => '',
            'user_training_goal' => '',
            'user_waking_from' => '',
            'user_waking_to' => '',
            'user_training_time_from' => '',
            'user_training_time_to' => '',
            'user_num_main_meals' => '',
            'user_num_snacks' => '',
            'user_water_consumed' => '',
            'user_fluid_intake' => '',
            'user_bad_habits' => '',
            'user_weight' => ''
        );

        $sel_data = $this->db->query('
            SELECT `user_gender`, `user_birthday`, `user_height`, `user_bmi`, `user_bmr`, 
                `user_physical_condition`, `user_pulse`, `user_sports_history`, `user_injuries_diseases`, 
                `user_training_goal`, `user_waking_from`, `user_waking_to`, `user_training_time_from`, 
                `user_training_time_to`, `user_num_main_meals`, `user_num_snacks`, `user_amount_water_consumed`, 
                `user_fluid_intake`, `user_bad_habits`
            FROM `questionnaire` 
            WHERE `user_id`=? LIMIT 1', $user_id);

        if ($sel_data !== false and 1 == $sel_data->num_rows())
        {
            $row = $sel_data->row();
            $date = DateTime::createFromFormat('Y-m-d', $row->user_birthday);
            $birthday = ($row->user_birthday != '0000-00-00' and $date !== false) ? $date->format('d.m.Y') : '';

            if (!empty($birthday)) {
                $b_day  = $date->format('d');
                $b_mon  = $date->format('m');
                $b_year = $date->format('Y');

                $result['user_b_day']  = $b_day;
                $result['user_b_mon']  = $b_mon;
                $result['user_b_year'] = $b_year;
            }

            $result['user_gender']             = $row->user_gender;
            $result['user_birthday']           = ($birthday != '0000-00-00') ? $birthday : '';
            $result['user_height']             = ($row->user_height != 0) ? $row->user_height : '';
            $result['user_bmi']                = $row->user_bmi;
            $result['user_bmr']                = $row->user_bmr;
            $result['user_physical_condition'] = $row->user_physical_condition;
            $result['user_pulse']              = ($row->user_pulse != 0) ? $row->user_pulse : '';
            $result['user_sports_history']     = $row->user_sports_history;
            $result['user_injuries_diseases']  = $row->user_injuries_diseases;
            $result['user_training_goal']      = $row->user_training_goal;
            $result['user_waking_from']        = ($row->user_waking_from != '00:00:00') ? mb_substr($row->user_waking_from, 0, 5) : '';
            $result['user_waking_to']          = ($row->user_waking_to != '00:00:00') ? mb_substr($row->user_waking_to, 0, 5) : '';
            $result['user_training_time_from'] = ($row->user_training_time_from != '00:00:00') ? mb_substr($row->user_training_time_from, 0, 5) : '';
            $result['user_training_time_to']   = ($row->user_training_time_to != '00:00:00') ? mb_substr($row->user_training_time_to, 0, 5) : '';
            $result['user_num_main_meals']     = ($row->user_num_main_meals != 0) ? $row->user_num_main_meals : '';
            $result['user_num_snacks']         = ($row->user_num_snacks != 0) ? $row->user_num_snacks : '';
            $result['user_water_consumed']     = ($row->user_amount_water_consumed != 0) ? $row->user_amount_water_consumed : '';
            $result['user_fluid_intake']       = ($row->user_fluid_intake != 0) ? $row->user_fluid_intake : '';
            $result['user_bad_habits']         = $row->user_bad_habits;

            $bmi_txt = '';
            if ($row->user_bmi <= 18.8) {
                $bmi_txt = '(дефицит массы тела)';
            }
            elseif ($row->user_bmi <= 25){
                $bmi_txt = '(норма веса)';
            }
            elseif ($row->user_bmi <= 30){
                $bmi_txt = '(излишек массы тела)';
            }
            elseif ($row->user_bmi <= 34.5){
                $bmi_txt = '(начальная степень ожирения)';
            }
            elseif ($row->user_bmi <= 40){
                $bmi_txt = '(средняя степень ожирения)';
            }
            elseif ($row->user_bmi > 40){
                $bmi_txt = '(ожирение высокой степени)';
            }

            $result['user_bmi_txt'] = $bmi_txt;

            $sel_anth_data = $this->db->query('
                SELECT `user_weight` 
                FROM `anthropometric` 
                WHERE `user_id`=? 
                ORDER BY `id` DESC
                LIMIT 1', $user_id);

            if ($sel_anth_data !== false and 1 == $sel_anth_data->num_rows())
            {
                $row = $sel_anth_data->row();

                $result['user_weight'] = $row->user_weight;
            }
            elseif ($sel_anth_data === false)
            {
                parent::logDbMessages(__METHOD__.':'.__LINE__);
            }
        }
        elseif ($sel_data === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Получение предпочтительного времени тренировок пользователя
     *
     * @param $user_id
     * @return array
     */
    public function getUserTrainingTime($user_id)
    {
        // Массив возвращаемых значений
        $result = array ();

        $sel_data = $this->db->query('
            SELECT `user_training_time_from`, `user_training_time_to`
            FROM `questionnaire` 
            WHERE `user_id`=? LIMIT 1', $user_id);

        if ($sel_data !== false and 1 == $sel_data->num_rows())
        {
            $row = $sel_data->row();
            
            $result['from'] = $row->user_training_time_from;
            $result['to']   = $row->user_training_time_to;
        }
        elseif ($sel_data === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }
        
        return $result;
    }

    /**
     * Получение последних антропометрических данных
     *
     * @param $user_id
     * @return array
     */
    public function getLastAnthropometricData($user_id)
    {
        // Массив возвращаемых значений
        $result = array (
            'user_weight' => '',
            'user_chest' => '',
            'user_waist' => '',
            'user_buttocks' => '',
            'user_waist_sides' => '',
            'user_right_hip' => '',
            'user_left_hip' => '',
            'user_right_biceps' => '',
            'user_left_biceps' => ''
        );

        $sel_anth_data = $this->db->query('
            SELECT `user_weight`, `user_circumference_chest`, `user_circumference_waist`, `user_circumference_buttocks`, 
                `user_circumference_waist_sides`, `user_circumference_right_hip`, `user_circumference_left_hip`, 
                `user_circumference_right_biceps`, `user_circumference_left_biceps`
            FROM `anthropometric` 
            WHERE `user_id`=? 
            ORDER BY `id` DESC
            LIMIT 1', $user_id);

        if ($sel_anth_data !== false and 1 == $sel_anth_data->num_rows())
        {
            $row = $sel_anth_data->row();

            $result['user_weight']       = $row->user_weight;
            $result['user_chest']        = $row->user_circumference_chest;
            $result['user_waist']        = $row->user_circumference_waist;
            $result['user_buttocks']     = $row->user_circumference_buttocks;
            $result['user_waist_sides']  = $row->user_circumference_waist_sides;
            $result['user_right_hip']    = $row->user_circumference_right_hip;
            $result['user_left_hip']     = $row->user_circumference_left_hip;
            $result['user_right_biceps'] = $row->user_circumference_right_biceps;
            $result['user_left_biceps']  = $row->user_circumference_left_biceps;
        }
        elseif ($sel_anth_data === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }
        
        return $result;
    }

    /**
     * Получение антропометрических данных
     *
     * @param $user_id
     * @param $today
     * @return array
     */
    public function getAnthropometricData($user_id, $today)
    {
        // Массив возвращаемых значений
        $result = array('anthropometric' => array(), 'min' => null, 'max' => null, 'anthrop_notif' => false);

        $sel_anth_data = $this->db->query('
            SELECT `user_weight`, `user_circumference_chest`, `user_circumference_waist`, `user_circumference_buttocks`, `user_date_add`
            FROM `anthropometric` 
            WHERE `user_id`=?', $user_id);

        if ($sel_anth_data !== false and 0 < $sel_anth_data->num_rows())
        {
            $i   = 0;
            $min = 0;
            $max = 0;
            $max_days = 0;
            foreach ($sel_anth_data->result() as $row)
            {
                //$today = DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));
                //$date = DateTime::createFromFormat('Y-m-d H:i:s', $row->user_date_add);

               // $interval = $today->diff($date);
                // Месяц в js начинается с нуля
                //$month = (($date->format('n') - 1) >= 0) ? ($date->format('n') - 1) : 11;
                //$datetime = $date->format('Y') . ', ' . $month . ', ' . $date->format('d');
                //$datetime = $date->format('Y-m-d H:i:s');
                //$datetime = $interval->format('%a');
                $date         = $row->user_date_add;
                $weight       = $row->user_weight;
                $chest        = $row->user_circumference_chest;
                $waist        = $row->user_circumference_waist;
                $buttocks     = $row->user_circumference_buttocks;

                /*$waist_sides  = $row->user_circumference_waist_sides;
                $right_hip    = $row->user_circumference_right_hip;
                $left_hip     = $row->user_circumference_left_hip;
                $right_biceps = $row->user_circumference_right_biceps;
                $left_biceps  = $row->user_circumference_left_biceps;*/

                $elements = array($weight, $chest, $waist, $buttocks);

                $result['anthropometric'][$i]['weight']   = $weight;
                $result['anthropometric'][$i]['chest']    = $chest;
                $result['anthropometric'][$i]['waist']    = $waist;
                $result['anthropometric'][$i]['buttocks'] = $buttocks;
                $result['anthropometric'][$i]['date'] = $date;

                if ($min == 0 or ($date < $min)) {
                    $min = $date;
                }

                if ($max == 0 or ($date > $max)) {
                    $max = $date;
                }


                /*$result['data'][$i]['waist_sides']  = $waist_sides;
                $result['data'][$i]['right_hip']    = $right_hip;
                $result['data'][$i]['left_hip']     = $left_hip;
                $result['data'][$i]['right_biceps'] = $right_biceps;
                $result['data'][$i]['left_biceps']  = $left_biceps;*/

                /*$max_element = !empty($elements) ? max($elements) : null;
                $min_element = !empty($elements) ? min($elements) : null;

                if (!empty($max_element) and (0 == $max or $max < $max_element)) {
                    $max = $max_element;
                }

                if (!empty($min_element) and (0 == $min or $min > $min_element)) {
                    $min = $min_element;
                }*/
                
                $i++;
            }
            unset($row);

            $min_date = DateTime::createFromFormat('Y-m-d H:i:s', $min);
            $min_date->sub(new DateInterval('P5D'));
            $max_date = DateTime::createFromFormat('Y-m-d H:i:s', $max);
            $max_date->add(new DateInterval('P5D'));

            $result['min'] = $min_date->format('Y-m-d H:i:s');
            $result['max'] = $max_date->format('Y-m-d H:i:s');

            // Уведомление пользователю если последний ввод данных был более 2х недель назад
            $tmp_date = new DateTime($today);
            $tmp_date->sub(new DateInterval('P14D'));
            if($result['max'] < $tmp_date->format('Y-m-d H:i:s'))
            {
                $result['anthrop_notif'] = true;
            }
        }
        elseif ($sel_anth_data === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Изменение данных анкеты. Физические параметры
     *
     * @param int $user_id
     * @param string $gender Пол (male|female) 
     * @param string $birthday Дата рождения 
     * @param int $height Рост
     * @param int $weight Вес
     * @param string $date
     * @return bool
     */
    public function setPhysicalParam($user_id, $gender, $birthday, $height, $weight, $date)
    {
        $up_data = $this->db->query('
            UPDATE `questionnaire` 
            SET `user_gender`=?, `user_birthday`=?, `user_height`=?, `user_date_update`=?
            WHERE `user_id`=? LIMIT 1',
                array($gender, $birthday, $height, $date, $user_id));

        if ($up_data !== false and 1 == $this->db->affected_rows())
        {
            $sel_last_anthrop = $this->db->query('
                SELECT `user_weight`, `user_circumference_chest`, `user_circumference_waist`, `user_circumference_buttocks`, 
                `user_circumference_waist_sides`, `user_circumference_right_hip`, `user_circumference_left_hip`, 
                `user_circumference_right_biceps`, `user_circumference_left_biceps`
                FROM `anthropometric`
                WHERE `user_id`=? ORDER BY `id` DESC LIMIT 1', $user_id);

            if (1 == $sel_last_anthrop->num_rows()) {
                $row = $sel_last_anthrop->row();

                $db_weight = $row->user_weight;

                if ($db_weight != $weight) {
                    $this->db->query('
                        INSERT INTO `anthropometric` (`user_id`, `user_weight`, `user_circumference_chest`, `user_circumference_waist`, 
                        `user_circumference_buttocks`, `user_circumference_waist_sides`, `user_circumference_right_hip`, 
                        `user_circumference_left_hip`, `user_circumference_right_biceps`, `user_circumference_left_biceps`, 
                        `user_date_add`)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)',
                        array($user_id, $weight, $row->user_circumference_chest, $row->user_circumference_waist,
                            $row->user_circumference_buttocks, $row->user_circumference_waist_sides, $row->user_circumference_right_hip,
                            $row->user_circumference_left_hip, $row->user_circumference_right_biceps,
                            $row->user_circumference_left_biceps, $date));
                }

                unset($row);
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
     * Изменение данных анкеты. Физическое состояние
     *
     * @param int $user_id
     * @param int $physical_condition Физическое состоние
     * @param int $pulse Пульс
     * @param string $sports_history История тренировок
     * @param string $injuries_diseases Травмы, болезни
     * @param int $training_goal Цель тренировок
     * @param string $bad_habits Вредные привычки
     * @param string $date
     * @return bool
     */
    public function setPhysicalCondition($user_id, $physical_condition, $pulse, $sports_history, $injuries_diseases,
                                         $training_goal, $bad_habits, $date)
    {
        $up_data = $this->db->query('
            UPDATE `questionnaire` 
            SET `user_physical_condition`=?, `user_pulse`=?, `user_sports_history`=?, `user_injuries_diseases`=?, 
                `user_training_goal`=?, `user_bad_habits`=?, `user_date_update`=?
            WHERE `user_id`=? LIMIT 1',
                array($physical_condition, $pulse, $sports_history, $injuries_diseases, $training_goal, $bad_habits, $date, $user_id));

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
     * Изменение данных анкеты. Режим дня
     *
     * @param int $user_id
     * @param string $waking_from Бодствование с
     * @param string $waking_to Бодрствование до
     * @param string $training_time_from Тренировка с
     * @param string $training_time_to Тренировка до
     * @param int $num_main_meals Количество основных приемов пищи
     * @param int $num_snacks Колчество перекусов
     * @param int $water_consumed Колчиество потребляемой воды
     * @param int $fluid_intake Количество потребляемой жидкости
     * @param string $date
     * @return bool
     */
    public function setDailyRegime($user_id, $waking_from, $waking_to, $training_time_from, $training_time_to,
                                   $num_main_meals, $num_snacks, $water_consumed, $fluid_intake, $date)
    {
        $up_data = $this->db->query('
            UPDATE `questionnaire` 
            SET `user_waking_from`=?, `user_waking_to`=?, `user_training_time_from`=?, 
                `user_training_time_to`=?, `user_num_main_meals`=?, `user_num_snacks`=?, `user_amount_water_consumed`=?, 
                `user_fluid_intake`=?, `user_date_update`=?
            WHERE `user_id`=? LIMIT 1',
                array($waking_from, $waking_to, $training_time_from, $training_time_to,
                    $num_main_meals, $num_snacks, $water_consumed, $fluid_intake, $date, $user_id));

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
     * Изменение имени пользователя
     *
     * @param int $user_id
     * @param string $new_name Новое имя
     * @param string $date
     * @return bool
     */
    public function setUserName($user_id, $new_name, $date)
    {
        $up_data = $this->db->query('UPDATE `users` SET `user_name`=?, `user_date_update`=? WHERE `user_id`=? LIMIT 1',
            array($new_name, $date, $user_id));

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
     * Добавление антропометрических данных
     *
     * @param int $user_id
     * @param float $weight Вес
     * @param int $chest Обхват груди
     * @param int $waist Обхват талии
     * @param int $buttocks Обхват ягодиц
     * @param int $waist_sides Обхват боков
     * @param int $left_hip Обхват левого бедра
     * @param int $right_hip Обхват правого бедра
     * @param int $left_biceps Обхват левого бицепса
     * @param int $right_biceps Обхват правого бицепса
     * @param string $date
     * @return bool
     */
    public function setAnthropometricData($user_id, $weight, $chest, $waist, $buttocks, $waist_sides, $left_hip, $right_hip,
                                               $left_biceps, $right_biceps, $date)
    {
        $up_data = $this->db->query('
            INSERT INTO `anthropometric` (`user_id`, `user_weight`, `user_circumference_chest`, `user_circumference_waist`, 
                `user_circumference_buttocks`, `user_circumference_waist_sides`, `user_circumference_left_hip`, 
                `user_circumference_right_hip`, `user_circumference_left_biceps`, `user_circumference_right_biceps`, 
                `user_date_add`) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)',
                array($user_id, $weight, $chest, $waist, $buttocks, $waist_sides, $left_hip, $right_hip, $left_biceps,
                    $right_biceps, $date));

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
     * Получение данных для вычисления ИМТ и БСО
     *
     * @param $user_id
     * @return array|bool
     */
    public function getDataForBmr($user_id)
    {
        $result = array(
            'height' => '',
            'weight' => '',
            'gender' => '',
            'birthday' => '',
            'bmi' => '',
            'bmr' => ''
        );
        
        $sel_data = $this->db->query('
            SELECT `user_height`, `user_gender`, `user_birthday`, `user_bmi`, `user_bmr` 
            FROM `questionnaire` 
            WHERE `user_id`=? LIMIT 1', $user_id);
        
        if ($sel_data !== false and 1 == $sel_data->num_rows())
        {
            $row = $sel_data->row();
            
            $result['height']   = $row->user_height;
            $result['gender']   = $row->user_gender;
            $result['birthday'] = $row->user_birthday;
            $result['bmi']      = $row->user_bmi;
            $result['bmr']      = $row->user_bmr;

            if ($row->user_bmi <= 18.8) {
                $bmi_txt = '(дефицит массы тела)';
            }
            elseif ($row->user_bmi <= 25){
                $bmi_txt = '(норма веса)';
            }
            elseif ($row->user_bmi <= 30){
                $bmi_txt = '(излишек массы тела)';
            }
            elseif ($row->user_bmi <= 34.5){
                $bmi_txt = '(начальная степень ожирения)';
            }
            elseif ($row->user_bmi <= 40){
                $bmi_txt = '(средняя степень ожирения)';
            }
            elseif ($row->user_bmi > 40){
                $bmi_txt = '(ожирение высокой степени)';
            }

            $result['bmi_txt'] = $bmi_txt;

            $sel_data->free_result();
            unset($row);

            $sel_weight = $this->db->query('
                SELECT `user_weight` FROM `anthropometric` WHERE `user_id`=? ORDER BY `user_date_add` DESC LIMIT 1', $user_id);

            if ($sel_weight !== false and 1 == $sel_weight->num_rows()) {
                $row = $sel_weight->row();

                $result['weight'] = $row->user_weight;
            }
            elseif ($sel_weight === false)
            {
                parent::logDbMessages(__METHOD__.':'.__LINE__);
            }
        }
        elseif ($sel_data === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }
        
        return $result;
    }

    /**
     * Сохранение данных ИМТ и БСО
     *
     * @param $user_id
     * @param $bmi
     * @param $bmr
     * @param $date
     * @return bool
     */
    public function setBmiBmr($user_id, $bmi, $bmr, $date)
    {
        $up_data = $this->db->query('UPDATE `questionnaire` SET `user_bmi`=?, `user_bmr`=?, `user_date_update`=? WHERE `user_id`=? LIMIT 1',
            array($bmi, $bmr, $date, $user_id));

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
     * AJAX. Поиск пользователей.
     *
     * @param $search_text
     * @return string
     */
    public function searchUsers($search_text)
    {
        $result = '';

        $sel_users = $this->db->query('
            SELECT `user_id`, `user_name`, `user_email`, `user_image` 
            FROM `users` 
            WHERE `user_type`=1 and MATCH (`user_email`, `user_name`) AGAINST (? IN BOOLEAN MODE)',
            $search_text);

        if ($sel_users !== false and 0 < $sel_users->num_rows())
        {
            foreach ($sel_users->result() as $row) {
                $user_name = !empty($row->user_name) ? $row->user_name : $row->user_email ;

                $image = '';
                if (!empty($row->user_image)) {
                    $image = $row->user_image;
                    if (mb_substr($row->user_image, 0, 1) == '.' and is_file($row->user_image)) {
                        $image = mb_substr($row->user_image, 1);
                    }
                }
                $user_image = !empty($image) ? '<img src="' . $image . '" alt="">' : '';

                $result .= '<div class="add_tren_item parent user" id="' . $row->user_id . '">
                        <div class="add_tov_img">' . $user_image . '</div>
                        <a href="/profile/' . $row->user_id . '" class="add_tov_cont add_tren_name">
                            <div class="add_tov_h">' . $user_name . '</div>
                        </a>
                    </div>';
            }
            unset($row);
        }
        elseif ($sel_users === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }
}