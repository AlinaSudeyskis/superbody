<?php

/**
 * Класс авторизации и регистрации пользователей
 *
 * @author Alina Sudeyskis <alina.sudeyskis@gmail.com>
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Authorization_model extends CI_Model
{
    /**
     * Регистрация пользователя в базе данных. Способ авторизации NATIVE
     *
     * @param string $email
     * @param string $password
     * @param string $email_hash
     * @param string $date
     * @param string $name
     * @return int|string ID пользователя или ошибку
     */
    public function userRegistration($email, $password, $email_hash, $date, $name = '')
    {
        $result = 'e2'; // Не удалось зарегестрировать E-mail

        $sel_user = $this->db->query('SELECT `user_id` FROM `users` WHERE `user_email`=? LIMIT 1', $email);
        
        if ($sel_user !== false and $sel_user->num_rows() == 0)
        {
            $ins_data = $this->db->query('
                INSERT INTO `users`
                  (`user_email`, `user_password`, `user_activate_code`, `user_date_reg`, `user_activate_date`, `user_date_update`, `user_name`, `user_auth_via`)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)', array($email, $password, $email_hash, $date, $date, $date, $name, 'native'));

            if ($ins_data !== false and $this->db->affected_rows() == 1)
            {
                $user_id = $this->db->insert_id();

                // Добавляем данные пользователя в таблицу анкеты
                $this->db->query('INSERT INTO `questionnaire` (`user_id`) VALUES (?)', $user_id);

                // Промокод для друга
                $i = 0;
                $existing_pc = array();
                $sel_pc = $this->db->query('SELECT `pc_code` FROM `promocodes`');
                if($sel_pc !== false and 0 < $sel_pc->num_rows())
                {
                    foreach ($sel_pc->result() as $row)
                    {
                        if(!empty($row->pc_code))
                        {
                            $existing_pc[$i] = $row->pc_code;
                            $i++;
                        }
                    }
                    unset($row);
                }
                elseif($sel_pc === false)
                {
                    parent::logDbMessages(__METHOD__.':'.__LINE__);
                }
                $sel_pff = $this->db->query('SELECT `pff_code` FROM `promocodes_for_friend`');
                if($sel_pff !== false and 0 < $sel_pff->num_rows())
                {
                    foreach ($sel_pff->result() as $row)
                    {
                        if(!empty($row->pff_code))
                        {
                            $existing_pc[$i] = $row->pff_code;
                            $i++;
                        }
                    }
                    unset($row);
                }
                elseif($sel_pff === false)
                {
                    parent::logDbMessages(__METHOD__.':'.__LINE__);
                }

                $promocode = '';
                //$promocode2 = 'BEIVYI';
                $words        = '0123456789QWERTYUIOPASDFGHJKLZXCVBNM';
                $max_position = strlen($words) - 1;
                $fl_cycle = false;
                for( $i = 1; $i <= 6; $i++ ) {
                    $position = floor ( rand(0,$max_position));
                    $promocode .= substr($words, $position, 1);

                    if($i == 6 and in_array($promocode, $existing_pc) and $fl_cycle === false)
                    {
                        $i = 0;
                        $fl_cycle = true;
                        $promocode = '';
                    }
                }
                $promocode = strtoupper($promocode);
                $this->db->query('INSERT INTO `promocodes_for_friend` (`pff_code`, `pff_u_id`, `pff_date_add`) VALUES(?, ?, ?)',
                    array($promocode, $user_id, $date));

                // Добавляем данные пользователя в таблицу подписчиков
                //$this->db->query('INSERT INTO `subscription` (`s_email`, `s_date`) VALUES (?, ?)', array($email, $date));
                
                return $user_id;
            }
            elseif($ins_data === false)
            {
                parent::logDbMessages(__METHOD__.':'.__LINE__);
            }
        }
        elseif($sel_user === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }
        else
        {
            $result = 'e1'; // Пользователь с таким E-mail уже зарегистрирован.
        }

        return $result;
    }

    /**
     * Получение кода активации и ID пользователя
     *
     * @param $email
     * @return bool
     */
    public function getActivateCode($email)
    {
        $sel_act_code = $this->db->query('
            SELECT `user_id`, `user_password`, `user_activate_code` 
            FROM `users` 
            WHERE `user_email`=? LIMIT 1', $email);

        if ($sel_act_code->num_rows() == 1)
        {
            $row = $sel_act_code->row();

            $result['user_id']            = $row->user_id;
            $result['user_password']      = $row->user_password;
            $result['user_activate_code'] = $row->user_activate_code;

            return $result;
        }
        else
        {
            return false;
        }
    }

    /**
     * Активация пользователя
     *
     * @param $user_id
     * @param $date
     * @return bool
     */
    public function activateUser($user_id, $date)
    {
        $result = false;

        $up_data = $this->db->query('UPDATE `users` SET `user_activated`=1, `user_activate_date`="0000-00-00 00:00:00", `user_date_update`=? 
          WHERE `user_id`=? LIMIT 1', array($date, $user_id));

        if ($up_data !== false and 1 == $this->db->affected_rows())
        {
            $sel_data = $this->db->query('SELECT `user_email` FROM `users` WHERE `user_id`=? LIMIT 1', $user_id);
            if($sel_data !== false and 1 == $sel_data->num_rows())
            {
                $row = $sel_data->row();
                $email = $row->user_email;

                // Добавляем данные пользователя в таблицу подписчиков
                $sel_sub = $this->db->query('SELECT `s_email` FROM `subscription`  WHERE `s_email`=? LIMIT 1', $email);
                if($sel_sub !== false and 0 == $sel_sub->num_rows())
                {
                    $this->db->query('INSERT INTO `subscription` (`s_email`, `s_date`) VALUES (?, ?)', array($email, $date));
                }
                elseif($sel_sub === false)
                {
                    parent::logDbMessages(__METHOD__.':'.__LINE__);
                }
            }
            elseif($sel_data === false)
            {
                parent::logDbMessages(__METHOD__.':'.__LINE__);
            }

            $result = true;
        }
        elseif($up_data === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Проверка активации аккаунта
     *
     * @param $email
     * @param $activate_code
     * @return bool
     */
    public function getUserAccountData($email, $activate_code)
    {
        $result = false;

        if (!empty($email) and !empty($activate_code))
        {
            $sel_account = $this->db->query('SELECT `user_activated` FROM `users` 
                WHERE `user_email`=? and `user_activate_code`=? LIMIT 1', array($email, $activate_code));

            if ($sel_account !== false and 1 == $sel_account->num_rows())
            {
                $row = $sel_account->row();

                $account['activated'] = ($row->user_activated == 1) ? true : false;

                //log_message('debug', __METHOD__ . ' ' . print_r($account, true));

                $result = $account;
            }
            elseif ($sel_account === false)
            {
                parent::logDbMessages(__METHOD__.':'.__LINE__);
            }
        }

        return $result;
    }

    /**
     * Регистрация и авторизация пользователя через соц. сети Facebook.
     *
     * @param int $social_id ID пользователя в соц. сети
     * @param string $email E-mail пользователя в соц. сети
     * @param string $name Имя пользователя в соц. сети
     * @param datetime $date Текущая дата и время
     * @return bool | int
     */
    public function loginViaFacebook($social_id, $email = '', $name = '', $date = '')
    {
        $sel_user = $this->db->query('
            SELECT `user_id`, `user_email`, `user_name`, `user_type`, `user_auth_via` 
            FROM `users` 
            WHERE `user_social_id`=? and `user_auth_via`="facebook.com" LIMIT 1', $social_id);

        if ($sel_user->num_rows() == 1) {
            $row = $sel_user->row();
            // Обновление данных сессии
            if (!empty($this->session->user)) {
                $user_data['user'] = $this->session->user;
                $user_data['user']['email'] = $email;
                $user_data['user']['social_id'] = $social_id;
                $user_data['user']['date_auth'] = $date;

                $this->session->set_userdata($user_data);
            }
            // Создание сессии
            else {
                $user_data = array (
                    "user" => array (
                        "id" => $row->user_id,
                        "email" => $row->user_email,
                        "name" => $row->user_name,
                        "type" => $row->user_type,
                        "auth_via" => $row->user_auth_via,
                        "social_id" => $social_id,
                        "date_auth" => $date
                    ),
                    "new_messages" => 0,
                    "new_fb_messages" => 0
                );

                $this->session->set_userdata($user_data);
            }

            return $row->user_id;
        } else {
            // Добавление пользователя в БД
            $this->db->query('
                INSERT INTO `users` 
                (`user_auth_via`, `user_social_id`, `user_activated`, `user_email`, `user_name`, `user_date_reg`, `user_date_update`)
                VALUES (?, ?, ?, ?, ?, ?, ?)',
                    array('facebook.com', $social_id, 1, $email, $name, $date, $date));

            if ($this->db->affected_rows() == 1) {
                // Обновление данных сессии
                $user_data = array (
                    "user" => array (
                        "id" => $this->db->insert_id(),
                        "email" => $email,
                        "name" => $name,
                        "type" => 1,
                        "social_id" => $social_id,
                        "date_auth" => $date
                    ),
                    "new_messages" => 0,
                    "new_fb_messages" => 0
                );

                $this->session->set_userdata($user_data);

                return $this->db->insert_id();
            } else {
                return false;
            }
        }
    }

    /**
     * Авторизация пользователя при помощи соц. сети
     *
     * @param string $soc Соц. сеть
     * @param string $date Текущая дата
     * @param string $access_token
     * @param int $user_soc_id ID пользователя в соц. сети
     * @param int $expires_at Срок истечения маркера доступа
     * @param int $issued_at Когда выдан маркер доступа
     * @param int $expires_in
     * @param string $user_soc_email Email пользователя в соц. сети
     * @param string $user_soc_name Имя пользователя в соц. сети
     * @param string $user_soc_image Изображение пользователя в соц. сети
     * @param string $user_soc_bd Дата рождения пользователя в соц. сети
     * @param string $user_soc_gender Пол пользователя в соц. сети
     * @param string $user_profile_url
     * @return array|bool
     */
    public function validSocLoginId($soc, $date, $access_token, $user_soc_id, $expires_at, $issued_at, $expires_in, $user_soc_email = '',
                                    $user_soc_name = '', $user_soc_image = '', $user_soc_bd = '', $user_soc_gender = '', $user_profile_url = '')
    {
        $result['registration'] = false;

        // Поиск пользователя по соц. сети и его ID в соц. сети
        $sel_user = $this->db->query('
            SELECT `us_u_id` FROM `users_social`
            WHERE `us_social`=? and `us_social_id`=? LIMIT 1', array($soc, $user_soc_id));

        // Если нашли, сверяем данные и авторизуем
        if ($sel_user !== false and 1 == $sel_user->num_rows())
        {
            $row = $sel_user->row();

            $result = self::userSocialAuthorization($row->us_u_id, $access_token, $expires_at, $issued_at, $expires_in, $soc, $user_soc_id,
                $user_soc_email, $user_soc_name, $user_soc_image, $user_soc_bd, $user_soc_gender, $user_profile_url, $date);
        }
        elseif($sel_user === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }
        else
        {
            // Поиск пользователя по email. Если нашли, добавляем соц. сеть и авторизуем.
            if (!empty($user_soc_email))
            {
                $sel_user = $this->db->query('SELECT `user_id` FROM `users` WHERE `user_email`=? LIMIT 1', $user_soc_email);

                // Если нашли, изменяем способ авторизации
                if ($sel_user !== false and 1 == $sel_user->num_rows())
                {
                    $row = $sel_user->row();

                    // Изменяем способ авторизации
                    $this->db->query('UPDATE `users` SET `user_auth_via`=? WHERE `user_email`=? LIMIT 1', array($soc, $user_soc_email));

                    // Прикрепляем соц. сеть к пользователю
                    self::setUserSocial($row->user_id, $soc, $user_soc_id, $user_soc_email, $user_soc_name, $user_soc_image,
                        $user_soc_bd, $user_soc_gender, $user_profile_url, $access_token, $expires_at, $issued_at, $expires_in, $date);

                    // Авторизуем пользователя
                    $result = self::userSocialAuthorization($row->user_id, $access_token, $expires_at, $issued_at, $expires_in, $soc, $user_soc_id,
                        $user_soc_email, $user_soc_name, $user_soc_image, $user_soc_bd, $user_soc_gender, $user_profile_url, $date);
                }
                elseif($sel_user === false)
                {
                    parent::logDbMessages(__METHOD__.':'.__LINE__);
                }
                // Регистрируем и авторизуем
                else {
                    $result = self::userSocialRegistration($access_token, $expires_at, $issued_at, $expires_in, $soc, $date,
                        $user_soc_id, $user_soc_email, $user_soc_name, $user_soc_image, $user_soc_bd, $user_soc_gender, $user_profile_url);
                    $result['registration'] = true;
                }
            }
            // Регистрируем и авторизуем
            else {
                $result = self::userSocialRegistration($access_token, $expires_at, $issued_at, $expires_in, $soc, $date,
                    $user_soc_id, $user_soc_email, $user_soc_name, $user_soc_image, $user_soc_bd, $user_soc_gender, $user_profile_url);
                $result['registration'] = true;
            }
        }

        return $result;
    }

    /**
     * Регистрация и авторизация пользователя, используя его данные из соц. сети
     *
     * @param string $access_token
     * @param string $expires_at
     * @param string $issued_at
     * @param string $expires_in
     * @param string $soc Соц. сеть
     * @param string $date Текущая дата
     * @param int $user_soc_id ID пользователя в соц. сети
     * @param string $user_soc_email Email пользователя в соц. сети
     * @param string $user_soc_name Имя пользователя в соц. сети
     * @param string $user_soc_image Изображение пользователя в соц. сети
     * @param string $user_soc_bd Дата рождения пользователя в соц. сети
     * @param string $user_soc_gender Пол пользователя в соц. сети
     * @param string $user_profile_url
     * @return array|bool
     */
    protected function userSocialRegistration ($access_token, $expires_at, $issued_at, $expires_in, $soc, $date, $user_soc_id,
                                               $user_soc_email = '', $user_soc_name = '', $user_soc_image = '',
                                               $user_soc_bd = '', $user_soc_gender = '', $user_profile_url = '')
    {
        $result = false;
        $user_soc_email = (!empty($user_soc_email)) ? $user_soc_email : '';

        $ins_data = $this->db->query('
            INSERT INTO `users` (`user_email`, `user_auth_via`, `user_name`, `user_soc_image`, `user_date_reg`, `user_activated`, 
              `user_date_update`) 
            VALUES (?, ?, ?, ?, ?, ?, ?)',
                array($user_soc_email, $soc, $user_soc_name, $user_soc_image, $date, 1, $date));

        if ($ins_data !== false and 1 == $this->db->affected_rows())
        {
            $user_id = $this->db->insert_id();

            // Добавление соц. сети
            self::setUserSocial($user_id, $soc, $user_soc_id, $user_soc_email, $user_soc_name, $user_soc_image,
                $user_soc_bd, $user_soc_gender, $user_profile_url, $access_token, $expires_at, $issued_at, $expires_in, $date);

            // Добавляем данные пользователя в таблицу анкеты
            $this->db->query('
                INSERT INTO `questionnaire` (`user_id`, `user_gender`, `user_birthday`, `user_date_update`) 
                VALUES (?, ?, ?, ?)', array($user_id, $user_soc_gender, $user_soc_bd, $date));

            // Добавляем данные пользователя в таблицу подписчиков
            if (!empty($user_soc_email))
            {
                $this->db->query('
                    INSERT INTO `subscription` (`s_email`, `s_name`, `s_date`) 
                    VALUES (?, ?, ?)', array($user_soc_email, $user_soc_name, $date));
            }

            // Авторизуем пользователя
            $result = self::userSocialAuthorization($user_id, $access_token, $expires_at, $issued_at, $expires_in, $soc, $user_soc_id,
                $user_soc_email, $user_soc_name, $user_soc_image, $user_soc_bd, $user_soc_gender, $user_profile_url, $date);
        }
        elseif($ins_data === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Создание/обновление сессии пользователя
     *
     * @param $user_id
     * @param $access_token
     * @param $expires_at
     * @param $issued_at
     * @param $expires_in
     * @param $user_soc_via
     * @param $user_soc_id
     * @param $user_soc_email
     * @param $user_soc_name
     * @param $user_soc_image
     * @param $user_soc_bd
     * @param $user_soc_gender
     * @param string $user_profile_url
     * @param $date
     * @return array
     */
    public function userSocialAuthorization($user_id, $access_token, $expires_at, $issued_at, $expires_in, $user_soc_via,
                                            $user_soc_id, $user_soc_email, $user_soc_name, $user_soc_image,
                                            $user_soc_bd, $user_soc_gender, $user_profile_url, $date)
    {
        $result = array();

        $sel_data = $this->db->query('SELECT `user_deleted` FROM `users` WHERE `user_id`=? LIMIT 1', $user_id);
        if($sel_data !== false and 1 == $sel_data->num_rows())
        {
            $row = $sel_data->row();
            $user_deleted = $row->user_deleted;
            unset($row);

            if($user_deleted == 0)
            {
                // Сохраняем состояние авторизации в БД
                $this->db->query('UPDATE `users` SET `user_login`=1, `user_date_update`=? WHERE `user_id`=? LIMIT 1', array($date, $user_id));

                // Обновление данных соц. сети
                $this->db->query('
                    UPDATE `users_social` SET `us_token`=?, `us_email`=?, `us_name`=?, `us_image`=?, `us_birthday`=?, 
                      `us_gender`=?, `us_url_profile`=?, `us_expires_at`=?, `us_issued_at`=?, `us_expires_in`=? 
                    WHERE `us_u_id`=? and `us_social`=? and `us_social_id`=? LIMIT 1',
                        array($access_token, $user_soc_email, $user_soc_name, $user_soc_image, $user_soc_bd, $user_soc_gender,
                            $user_profile_url, $expires_at, $issued_at, $expires_in, $user_id, $user_soc_via, $user_soc_id));

                // Выборка данных пользователя
                $sel_user = $this->db->query('
                    SELECT `user_email`, `user_type`, `user_blocked`, `user_name`, `user_phone`, `user_image`, `user_soc_image` 
                    FROM `users`
                    WHERE `user_id`=? LIMIT 1', $user_id);

                if ($sel_user !== false and 1 == $sel_user->num_rows())
                {
                    $row = $sel_user->row();

                    $result['user']['id']           = $user_id;
                    $result['user']['email']        = (!empty($row->user_email)) ? $row->user_email : $user_soc_email;
                    $result['user']['type']         = $row->user_type;
                    $result['user']['blocked']      = $row->user_blocked;
                    $result['user']['name']         = (!empty($row->user_name)) ? $row->user_name : $user_soc_name;
                    $result['user']['phone']        = $row->user_phone;
                    $result['user']['image']        = (!empty($row->user_image) and is_file($row->user_image)) ? mb_substr($row->user_image, 1) : '';
                    $result['user']['soc_image']    = '';
                    $result['user']['access_token'] = $access_token;
                    $result['user']['soc_via']      = $user_soc_via;
                    $result['user']['soc_id']       = $user_soc_id;

                    if(!empty($user_soc_image))
                    {
                        $Headers = @get_headers($user_soc_image);
                        if(strpos($Headers[0], '200'))
                        {
                            $result['user']['soc_image'] = $user_soc_image;
                        }
                    }
                }
                elseif($sel_user === false)
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
     * Авторизация пользователя. Проверка корректности email и пароля пользователя. Способ авторизации NATIVE
     *
     * Поиск пользователя в БД по E-mail.
     *
     * @param $email
     * @param $password
     * @param $date
     * @return array | bool
     */
    public function userAuthorization($email, $password, $date)
    {
        $sel_user = $this->db->query('
            SELECT `user_id`, `user_password`, `user_name`, `user_email`, `user_phone`, `user_type`, `user_blocked`, 
              `user_image`, `user_soc_image` 
            FROM `users` 
            WHERE `user_email`=? and `user_deleted`=0 LIMIT 1', $email);

        if ($sel_user !== false and 1 == $sel_user->num_rows())
        {
            $row = $sel_user->row();

            // Сравнение введенного пароля и хэш пароля из БД
            if (password_verify($password, $row->user_password))
            {
                $this->db->query('
                    UPDATE `users` SET `user_login`=1, `user_date_update`=? WHERE `user_email`=? LIMIT 1',  array($date, $email));

                $result['user_id']        = $row->user_id;
                $result['user_name']      = $row->user_name;
                $result['user_phone']     = $row->user_phone;
                $result['user_email']     = $row->user_email;
                $result['user_type']      = $row->user_type;
                $result['user_blocked']   = $row->user_blocked;
                $result['user_image']     = (!empty($row->user_image) and is_file($row->user_image)) ? mb_substr($row->user_image, 1) : '';
                $result['user_soc_image'] = '';

                if(!empty($row->user_soc_image))
                {
                    $Headers = @get_headers($row->user_soc_image);
                    if(strpos($Headers[0], '200'))
                    {
                        $result['user_soc_image'] = $row->user_soc_image;
                    }
                }

                return $result;
            }
            else
            {
                return 'error_password';
            }
        }
        elseif($sel_user === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
            return false;
        }
        else
        {
            return 'error_user';
        }
    }

    /**
     * Авторизация администратора от имени тренера.
     *
     * @param $coach_id
     * @return array | bool
     */
    public function authorizationOnBehalfCoach($coach_id)
    {
        $result = false;

        $sel_user = $this->db->query('
            SELECT `user_id`, `user_password`, `user_name`, `user_email`, `user_phone`, `user_type`, `user_blocked`, 
              `user_image`, `user_soc_image` 
            FROM `users` 
            WHERE `user_id`=? and `user_type`=2 LIMIT 1', $coach_id);

        if ($sel_user !== false and 1 == $sel_user->num_rows())
        {
            $row = $sel_user->row();

            $result['user_id']        = $row->user_id;
            $result['user_name']      = $row->user_name;
            $result['user_phone']     = $row->user_phone;
            $result['user_email']     = $row->user_email;
            $result['user_type']      = $row->user_type;
            $result['user_blocked']   = $row->user_blocked;
            $result['user_image']     = (!empty($row->user_image) and is_file($row->user_image)) ? mb_substr($row->user_image, 1) : '';
            $result['user_soc_image'] = '';

            if(!empty($row->user_soc_image))
            {
                $Headers = @get_headers($row->user_soc_image);
                if(strpos($Headers[0], '200'))
                {
                    $result['user_soc_image'] = $row->user_soc_image;
                }
            }
        }
        elseif($sel_user === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Сохранение нового пароля (восставновление пароля).
     * 
     * @param $email
     * @param $password
     * @param $date
     * @return bool
     */
    public function userRestorePassword($email, $password, $date)
    {
        $this->db->query('
            UPDATE `users` 
            SET `user_password`=?, `user_date_update`=?, `user_idempotent`="", `user_restore_date`="0000-00-00" 
            WHERE `user_email`=? LIMIT 1', array($password, $date, $email));

        if (1 == $this->db->affected_rows())
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * Добавление данных восстановления пароля
     *
     * @param $email
     * @param $idempotent
     * @param $today
     * @return bool
     */
    public function setRestore($email, $idempotent, $today)
    {
        $up_data = $this->db->query('UPDATE `users` SET `user_idempotent`=?, `user_restore_date`=? 
            WHERE `user_email`=? LIMIT 1', array($idempotent, $today, $email));

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
     * Проверка данных восстановления пароля
     *
     * @param $email
     * @param $code
     * @param $idempotent
     * @param $date
     * @return bool
     */
    public function checkRestore($email, $code, $idempotent, $date)
    {
        $sel_data = $this->db->query('SELECT `user_restore_date`, `user_idempotent` FROM `users` 
            WHERE `user_email`=? and `user_activate_code`=? and `user_idempotent`=? LIMIT 1',
                array($email, $code, $idempotent));

        if($sel_data !== false and 1 == $sel_data->num_rows())
        {
            $row = $sel_data->row();

            $datetime1 = new DateTime($date); // Текущая дата
            $datetime2 = new DateTime($row->user_restore_date); // Дата уставновления запроса на восстановления пароля
            $interval = $datetime1->diff($datetime2);

            // Разница во времени не должна превышать 60 минут
            if($interval->format('a') == 0 and $interval->format('h') == 0 and $interval->format('i') <= 59)
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        elseif($sel_data === false)
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
     * Обновление пароля пользователя
     *
     * @param string $email Email пользователя
     * @param string $code Код активации
     * @param string $idempotent Код идемпотентности
     * @param string $password_hash Хэш пароля
     * @param string $date Текущая дата
     * @return bool
     */
    public function updatePassword($email, $code, $idempotent, $password_hash, $date)
    {
        if(!empty($password_hash))
        {
            $up_data = $this->db->query('
                UPDATE `users` SET `user_password`=?, `user_restore_date`="", `user_idempotent`="", `user_date_update`=?
                WHERE `user_email`=? and `user_activate_code`=? and `user_idempotent`=? LIMIT 1',
                    array($password_hash, $date, $email, $code, $idempotent));

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
        else
        {
            return false;
        }
    }

    /**
     * Выход из аккаунта. Способ авторизации NATIVE
     *
     * @param $user_id
     * @param $date
     * @return bool
     */
    public function userLogout($user_id, $date)
    {
        $this->db->query('UPDATE `users` SET `user_login`=2, `user_date_update`=? WHERE `user_id`=? LIMIT 1', array($date, $user_id));

        if (1 == $this->db->affected_rows()) {
            return true;
        }
        else {
            return false;
        }
    }

    /**
     * Выход из аккаунта. Способ авторизации соц. сеть
     *
     * @param $user_soc
     * @param $user_soc_id
     * @param $date
     * @return bool
     */
    public function userSocialLogout($user_soc, $user_soc_id, $date)
    {
        $this->db->query('UPDATE `users` SET `user_login`=2, `user_date_update`=? 
            WHERE `user_auth_via`=? and `user_social_id`=? LIMIT 1', array($date, $user_soc, $user_soc_id));

        if (1 == $this->db->affected_rows()) {
            return true;
        }
        else {
            return false;
        }
    }

    /**
     * Проверка существования подключения в БД. В случае не нахождения, прикрепление к пользователю
     *
     * @param $user_id
     * @param $social
     * @param $date
     * @param $access_token
     * @param $social_id
     * @param $social_email
     * @param $social_name
     * @param $social_image
     * @param $social_bd
     * @param $social_gender
     * @param $social_url
     * @param $expires_at
     * @param $issued_at
     * @param $expires_in
     * @return bool
     */
    public function connectSocial($user_id, $social, $date, $access_token, $social_id, $social_email, $social_name,
                                  $social_image, $social_bd, $social_gender, $social_url, $expires_at, $issued_at, $expires_in)
    {
        $result = true;

        $sel_social = $this->db->query('
            SELECT `us_u_id` FROM `users_social` 
            WHERE `us_social`=? and `us_social_id`=? LIMIT 1', array($social, $social_id));

        if ($sel_social !== false and 0 == $sel_social->num_rows())
        {
            // Прикрепляем соц. сеть к пользователю
            $result = self::setUserSocial($user_id, $social, $social_id, $social_email, $social_name, $social_image, $social_bd,
                $social_gender, $social_url, $access_token, $expires_at, $issued_at, $expires_in, $date);
        }
        elseif($sel_social === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Прикрепление соц. сети к пользователю
     *
     * @param $user_id
     * @param $social
     * @param $social_id
     * @param $social_email
     * @param $social_name
     * @param $social_image
     * @param $social_bd
     * @param $social_gender
     * @param $social_url
     * @param $access_token
     * @param $expires_at
     * @param $issued_at
     * @param $expires_in
     * @param $date
     * @return bool
     */
    protected function setUserSocial($user_id, $social, $social_id, $social_email, $social_name, $social_image, $social_bd,
                                     $social_gender, $social_url, $access_token, $expires_at, $issued_at, $expires_in, $date)
    {
        $result = false;

        $sel_social = $this->db->query('SELECT `us_id` FROM `users_social` 
            WHERE `us_u_id`=? and `us_social`=? and `us_social_id`=? LIMIT 1', array($user_id, $social, $social_id));

        if($sel_social !== false and 0 == $sel_social->num_rows())
        {
            $ins_data = $this->db->query('
                INSERT INTO `users_social` (`us_u_id`, `us_social`, `us_social_id`, `us_email`, `us_name`, `us_image`, 
                    `us_birthday`, `us_gender`, `us_url_profile`, `us_token`, `us_expires_at`, `us_issued_at`, `us_expires_in`, `us_update`) 
                VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)',
                    array($user_id, $social, $social_id, $social_email, $social_name, $social_image, $social_bd,
                        $social_gender, $social_url, $access_token, $expires_at, $issued_at, $expires_in, $date));

            if ($ins_data !== false and 1 == $this->db->affected_rows())
            {
                $result = true;
            }
            elseif ($ins_data === false)
            {
                parent::logDbMessages(__METHOD__.':'.__LINE__);
            }
        }
        elseif($sel_social === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }
        else
        {
            $result = true;
        }

        return $result;
    }

    /**
     * Поиск email в БД
     *
     * @param $email
     * @param $name
     * @param $surname
     * @param $date
     * @return array
     */
    public function checkRegEmail($email, $name, $surname, $date)
    {
        $result = array('user_id' => null, 'new_user' => false);

        // Поиск email в БД
        $sel_email = $this->db->query('SELECT `user_email`, `user_name`, `user_id`, `user_auth_via` FROM `users` WHERE `user_email`=? LIMIT 1', $email);

        if($sel_email !== false and 1 == $sel_email->num_rows())
        {
            $row = $sel_email->row();

            // Возвращаем ID пользователя введенного email
            $result['user_id']   = $row->user_id;
            $result['user_name'] = $row->user_name;
            $result['auth_via']  = $row->user_auth_via;

            unset($row);
        }
        elseif($sel_email === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }
        // Если email не найден в БД, регистрируем
        else
        {
            // Генерация пароля
            $arr = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','r','s',
                't','u','v','x','y','z','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','R','S',
                'T','U','V','X','Y','Z','1','2','3','4','5','6','7','8','9','0','.',',','(',')','[',']','!','?',
                '&','^','%','@','*','$','<','>','/','|','+','-','{','}','`','~');
            $password = "";
            for($i = 0; $i < 8; $i++)
            {
                // Вычисляем случайный индекс массива
                $index = rand(0, count($arr) - 1);
                $password .= $arr[$index];
            }

            $password   = password_hash($password, PASSWORD_DEFAULT);
            $email_hash = password_hash($email, PASSWORD_DEFAULT);
            $name       = $name . ' ' . $surname;

            $user_id = self::userRegistration($email, $password, $email_hash, $date, $name);

            // Возвращаем ID нового пользователя
            $result['user_id']    = is_numeric($user_id) ? $user_id : null;
            $result['new_user']   = is_numeric($user_id) ? $user_id : false;
            $result['auth_via']   = is_numeric($user_id) ? 'native' : null;
            $result['email_hash'] = is_numeric($user_id) ? $email_hash : null;
        }

        return $result;
    }

    /**
     * Сохранение данных для смены email
     *
     * @param $user_id
     * @param $new_email
     * @param $idempotent
     * @param $date
     * @return bool
     */
    public function setUserChangeEmailData($user_id, $new_email, $idempotent, $date)
    {
        $result = false;

        if(is_numeric($user_id))
        {
            $res_check = self::checkEmail($new_email);
            if($res_check === false)
            {
                $up_data = $this->db->query('
                    UPDATE `users` 
                    SET `user_new_email`=?, `user_new_email_idempotent`=?, `user_date_update`=?, `user_new_email_date`=? 
                    WHERE `user_id`=? LIMIT 1', array($new_email, $idempotent, $date, $date, $user_id));

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

        return $result;
    }

    /**
     * Сохранение данных для смены email
     *
     * @param $user_id
     * @param $email
     * @param $email_hash
     * @param $date
     * @return bool
     */
    public function fillUserEmptyEmail($user_id, $email, $email_hash, $date)
    {
        $result = false;

        if(is_numeric($user_id))
        {
            $res_check = self::checkEmail($email);
            if($res_check === false)
            {
                $up_data = $this->db->query('
                    UPDATE `users` 
                    SET `user_email`=?, `user_activated`=0, `user_activate_code`=?, `user_date_update`=? 
                    WHERE `user_id`=? LIMIT 1', array($email, $email_hash, $date, $user_id));

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

        return $result;
    }

    /**
     * Проверка наличия пользователя с указанными данными для изменения email.
     *
     * @param $email
     * @param $code
     * @param $idempotent
     * @return bool|string
     */
    public function checkChangeEmail($email, $code, $idempotent)
    {
        $result = false;

        $sel_data = $this->db->query('SELECT `user_new_email`, `user_new_email_date` FROM `users` 
            WHERE `user_email`=? and `user_activate_code`=? and `user_new_email_idempotent`=? LIMIT 1',
            array($email, $code, $idempotent));

        if($sel_data !== false and 1 == $sel_data->num_rows())
        {
            $row = $sel_data->row();

            $check_email = self::checkEmail($row->user_new_email);
            if($check_email === false)
            {
                $result = $row->user_new_email;
            }
        }
        elseif($sel_data === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Проверка пользователя для повторного отправления письма по смене email
     *
     * @param $user_id
     * @param $date
     * @return bool
     */
    public function checkChangingEmail($user_id, $date)
    {
        $result = false;

        $sel_data = $this->db->query('SELECT `user_email`, `user_new_email`, `user_activate_code`, `user_new_email_date`, `user_new_email_idempotent` FROM `users` 
            WHERE `user_id`=? and `user_new_email_idempotent`<>"" and `user_new_email`<>"" LIMIT 1', $user_id);
        if($sel_data !== false and 1 == $sel_data->num_rows())
        {
            $row = $sel_data->row();

            $check_email = self::checkEmail($row->user_new_email);
            if($check_email === false)
            {
                $result['user_email']      = $row->user_email;
                $result['activate_code']   = $row->user_activate_code;
                $result['new_email_date']  = ($row->user_new_email_date != '0000-00-00 00:00:00') ? $row->user_new_email_date : '';
                $result['idempotent']      = $row->user_new_email_idempotent;

                $result['availability_send_email']      = true;
                $result['availability_send_email_date'] = null;

                if($row->user_new_email_date != '0000-00-00 00:00:00')
                {
                    $datetime1 = new DateTime($date);
                    $datetime2 = new DateTime($row->user_new_email_date);
                    $interval = $datetime1->diff($datetime2);

                    // Разница во времени не должна превышать 60 минут
                    if($interval->h == 0 and $interval->i <= 59)
                    {
                        $result['availability_send_email']      = false;
                        $result['availability_send_email_date'] = (59 - $interval->i) . ' мин.';
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

    /**
     * Проверка пользователя для повторного отправления письма по активации email
     *
     * @param $user_id
     * @param $date
     * @return bool
     */
    public function checkActivateEmail($user_id, $date)
    {
        $result = false;

        $sel_data = $this->db->query('SELECT `user_email`, `user_activate_code`, `user_activate_date` FROM `users` WHERE `user_id`=? and `user_activated`=0 LIMIT 1', $user_id);
        if($sel_data !== false and 1 == $sel_data->num_rows())
        {
            $row = $sel_data->row();

            $result['user_email']    = $row->user_email;
            $result['activate_code'] = $row->user_activate_code;
            $result['activate_date'] = ($row->user_activate_date != '0000-00-00 00:00:00') ? $row->user_activate_date : '';

            $result['availability_send_email']      = true;
            $result['availability_send_email_date'] = null;

            if($row->user_activate_date != '0000-00-00 00:00:00')
            {
                $datetime1 = new DateTime($date);
                $datetime2 = new DateTime($row->user_activate_date);
                $interval = $datetime1->diff($datetime2);

                // Разница во времени не должна превышать 60 минут
                if($interval->h == 0 and $interval->i <= 59)
                {
                    $result['availability_send_email']      = false;
                    $result['availability_send_email_date'] = (59 - $interval->i) . ' мин.';
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
     * Проверка наличия зарегистрированного пользователя с таким email в БД
     *
     * @param $email
     * @return bool
     */
    public function checkEmail($email)
    {
        $result = false;

        $sel_data = $this->db->query('SELECT `user_id` FROM `users` WHERE `user_email`=? LIMIT 1', $email);

        if($sel_data !== false and 1 == $sel_data->num_rows())
        {
            $result = true;
        }
        elseif($sel_data === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Изменение email пользователя
     *
     * @param $email
     * @param $date
     * @return bool
     */
    public function changeEmail($email, $date)
    {
        $result = false;

        $sel_data = $this->db->query('SELECT `user_id`, `user_new_email` FROM `users` WHERE `user_email`=? LIMIT 1', $email);

        if($sel_data !== false and 1 == $sel_data->num_rows())
        {
            $row        = $sel_data->row();
            $user_id    = $row->user_id;
            $new_email  = filter_var($row->user_new_email, FILTER_VALIDATE_EMAIL) ? $row->user_new_email : null;
            $email_hash = password_hash($new_email, PASSWORD_DEFAULT);

            if(!empty($new_email))
            {
                $up_data = $this->db->query('
                    UPDATE `users` 
                    SET `user_email`=?, `user_activate_code`=?, `user_date_update`=?, `user_new_email_date`="0000-00-00 00:00:00", `user_activated`=0, `user_new_email`="", `user_new_email_idempotent`="" 
                    WHERE `user_id`=? LIMIT 1', array($new_email, $email_hash, $date, $user_id));

                if($up_data !== false and 1 == $this->db->affected_rows())
                {
                    // Отметка, что пользователь отписался для этой почты
                    $unsub = $this->db->query('UPDATE `subscription` SET `s_unsubscribe`=1 WHERE `s_email`=? LIMIT 1', $email);
                    if($unsub === false)
                    {
                        parent::logDbMessages(__METHOD__.':'.__LINE__);
                    }

                    $result['new_email']  = $new_email;
                    $result['email_code'] = $email_hash;
                }
                elseif($up_data === false)
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
     * Проверка наличия пользователя с указанными данными для восстановление аккаунта.
     *
     * @param $email
     * @param $code
     * @param $idempotent
     * @return bool|string
     */
    public function checkRestoreAccount($email, $code, $idempotent)
    {
        $result = false;

        $sel_data = $this->db->query('SELECT `user_id` FROM `users` 
            WHERE `user_email`=? and `user_activate_code`=? and `user_restore_account_idempotent`=? LIMIT 1',
            array($email, $code, $idempotent));

        if($sel_data !== false and 1 == $sel_data->num_rows())
        {
            $result = true;
        }
        elseif($sel_data === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Восстановление пользователя из удаленных
     *
     * @param $user_email
     * @param $date
     * @return bool
     */
    public function restoreUserAccount($user_email, $date)
    {
        $result = false;

        $up_data = $this->db->query('
            UPDATE `users` 
            SET `user_date_update`=?, `user_deleted`=0, `user_delete_date`="0000-00-00", `user_delete_by`=0, 
                `user_restore_account_idempotent`=""
            WHERE `user_email`=? LIMIT 1', array($date, $user_email));

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
     * Сохранение даты последней отправки письма для подтверждения активации аккаунта
     *
     * @param $user_id
     * @param $date
     * @return bool
     */
    public function setResendingActivateEmailDate($user_id, $date)
    {
        $result = true;

        $up_data = $this->db->query('UPDATE `users` SET `user_activate_date`=? WHERE `user_id`=? LIMIT 1', array($date, $user_id));
        if($up_data === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
            $result = false;
        }

        return $result;
    }

    /**
     * Сохранение даты последней отправки письма пользователю для подтвержения изменения адреса почты
     *
     * @param $user_id
     * @param $date
     * @return bool
     */
    public function setResendingChangeEmailDate($user_id, $date)
    {
        $result = true;

        $up_data = $this->db->query('UPDATE `users` SET `user_new_email_date`=? WHERE `user_id`=? LIMIT 1', array($date, $user_id));
        if($up_data === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
            $result = false;
        }

        return $result;
    }
}