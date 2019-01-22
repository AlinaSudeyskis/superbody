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
        $sel_user = $this->db->query('SELECT `user_id` FROM `users` WHERE `user_email`=? LIMIT 1', $email);
        
        if ($sel_user !== false and $sel_user->num_rows() == 0)
        {
            $this->db->query('
                INSERT INTO `users`
                  (`user_email`, `user_password`, `user_activate_code`, `user_date_reg`, `user_date_update`, `user_name`, `user_auth_via`)
                VALUES (?, ?, ?, ?, ?, ?, ?)', array($email, $password, $email_hash, $date, $date, $name, 'native'));

            if ($this->db->affected_rows() == 1)
            {
                $user_id = $this->db->insert_id();

                // Добавляем данные пользователя в таблицу анкеты
                $this->db->query('INSERT INTO `questionnaire` (`user_id`) VALUES (?)', $user_id);

                // Добавляем данные пользователя в таблицу подписчиков
                $this->db->query('INSERT INTO `subscription` (`s_email`, `s_date`) VALUES (?, ?)', array($email, $date));
                
                return $user_id;
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
     * Получение кода активации и ID пользователя
     *
     * @param $email
     * @return bool
     */
    public function getActivateCode($email)
    {
        $sel_act_code = $this->db->query('
            SELECT `user_id`, `user_activate_code` 
            FROM `users` 
            WHERE `user_email`=? LIMIT 1', $email);

        if ($sel_act_code->num_rows() == 1) {
            $row = $sel_act_code->row();

            $result['user_id']            = $row->user_id;
            $result['user_activate_code'] = $row->user_activate_code;

            return $result;
        } else {
            return false;
        }
    }

    /**
     * Активация пользователя
     *
     * @param $user_id
     * @param $password
     * @return bool
     */
    public function activateUser($user_id, $password)
    {
        $this->db->query('UPDATE `users` SET `user_activated`=1, `user_password`=? WHERE `user_id`=? LIMIT 1',
            array($password, $user_id));

        if ($this->db->affected_rows() == 1)
        {
            return true;
        }
        else
        {
            return false;
        }
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
        if (!empty($email) and !empty($activate_code))
        {
            $sel_account = $this->db->query('SELECT `user_activated` FROM `users` 
                WHERE `user_email`=? and `user_activate_code`=? LIMIT 1', array($email, $activate_code));

            if ($sel_account !== false and 1 == $sel_account->num_rows())
            {
                $row = $sel_account->row();

                $account['activated'] = ($row->user_activated == 1) ? true : false;

                log_message('debug', __METHOD__ . ' ' . print_r($account, true));

                return $account;
            }
            elseif ($sel_account === false)
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
     * @return bool|array
     */
    public function validSocLoginId($soc, $date, $access_token, $user_soc_id, $expires_at, $issued_at, $expires_in, $user_soc_email = '',
                                    $user_soc_name = '', $user_soc_image = '', $user_soc_bd = '', $user_soc_gender = '')
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

            $result = self::userSocialAuthorization($row->us_u_id, $access_token, $expires_at, $issued_at, $expires_in, $soc, $user_soc_id, $date);
        }
        else
        {
            // Поиск пользователя по email. Если нашли, добавляем соц. сеть и авторизуем.
            if (!empty($user_soc_email))
            {
                $sel_user = $this->db->query('SELECT `user_id` FROM `users` WHERE `user_email`=? LIMIT 1', $user_soc_email);

                // Если нашли, изменяем способ авторизации
                if (1 == $sel_user->num_rows())
                {
                    $row = $sel_user->row();

                    // Изменяем способ авторизации
                    $this->db->query('UPDATE `users` SET `user_auth_via`=? WHERE `user_email`=? LIMIT 1',
                        array($soc, $user_soc_email));

                    // Прикрепляем соц. сеть к пользователю
                    self::setUserSocial($row->user_id, $soc, $user_soc_id, $access_token, $expires_at, $issued_at, $expires_in, $date);

                    // Авторизуем пользователя
                    $result = self::userSocialAuthorization($row->user_id, $access_token, $expires_at, $issued_at, $expires_in, $soc, $user_soc_id, $date);
                }
                // Регистрируем и авторизуем
                else {
                    $result = self::userSocialRegistration($access_token, $expires_at, $issued_at, $expires_in, $soc, $date,
                        $user_soc_id, $user_soc_email, $user_soc_name, $user_soc_image, $user_soc_bd, $user_soc_gender);
                    $result['registration'] = true;
                }
            }
            // Регистрируем и авторизуем
            else {
                $result = self::userSocialRegistration($access_token, $expires_at, $issued_at, $expires_in, $soc, $date,
                    $user_soc_id, $user_soc_email, $user_soc_name, $user_soc_image, $user_soc_bd, $user_soc_gender);
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
     * @return bool|array
     */
    protected function userSocialRegistration ($access_token, $expires_at, $issued_at, $expires_in, $soc, $date, $user_soc_id,
                                               $user_soc_email = '', $user_soc_name = '', $user_soc_image = '',
                                               $user_soc_bd = '', $user_soc_gender = '')
    {
        $this->db->query('
            INSERT INTO `users` (`user_email`, `user_auth_via`, `user_name`, `user_soc_image`, `user_date_reg`, `user_activated`, 
              `user_date_update`) 
            VALUES (?, ?, ?, ?, ?, ?, ?)',
                array($user_soc_email, $soc, $user_soc_name, $user_soc_image, $date, 1, $date));

        if (1 == $this->db->affected_rows())
        {
            $user_id = $this->db->insert_id();

            // Добавление соц. сети
            $this->db->query('
                INSERT INTO `users_social` (`us_u_id`, `us_social`, `us_social_id`, `us_token`, `us_expires_at`, 
                    `us_issued_at`, `us_expires_in`, `us_update`) 
                VALUES(?, ?, ?, ?, ?, ?, ?, ?)',
                    array($user_id, $soc, $user_soc_id, $access_token, $expires_at, $issued_at, $expires_in, $date));

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
            $result = self::userSocialAuthorization($user_id, $access_token, $expires_at, $issued_at, $expires_in, $soc, $user_soc_id, $date);
        }
        else
        {
            $result = false;
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
     * @param $date
     * @return array
     */
    public function userSocialAuthorization($user_id, $access_token, $expires_at, $issued_at, $expires_in, $user_soc_via,
                                            $user_soc_id, $date)
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
                $this->db->query('UPDATE `users_social` SET `us_token`=?, `us_expires_at`=?, `us_issued_at`=?, `us_expires_in`=? 
                  WHERE `us_u_id`=? and `us_social`=? and `us_social_id`=? LIMIT 1',
                    array($access_token, $expires_at, $issued_at, $expires_in, $user_id, $user_soc_via, $user_soc_id));

                // Выборка данных пользователя
                $sel_user = $this->db->query('
                    SELECT `user_email`, `user_type`, `user_blocked`, `user_name`, `user_phone`, `user_image`, `user_soc_image` 
                    FROM `users`
                    WHERE `user_id`=? LIMIT 1', $user_id);

                if ($sel_user !== false and 1 == $sel_user->num_rows())
                {
                    $row = $sel_user->row();

                    $result['user']['id']           = $user_id;
                    $result['user']['email']        = $row->user_email;
                    $result['user']['type']         = $row->user_type;
                    $result['user']['blocked']      = $row->user_blocked;
                    $result['user']['name']         = $row->user_name;
                    $result['user']['phone']        = $row->user_phone;
                    $result['user']['image']        = is_file($row->user_image) ? mb_substr($row->user_image, 1) : '';
                    $result['user']['soc_image']    = '';
                    $result['user']['access_token'] = $access_token;
                    $result['user']['soc_via']      = $user_soc_via;
                    $result['user']['soc_id']       = $user_soc_id;

                    if(!empty($row->user_soc_image))
                    {
                        $Headers = @get_headers($row->user_soc_image);
                        if(strpos($Headers[0], '200'))
                        {
                            $result['user']['soc_image'] = $row->user_soc_image;
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
     * @param $couch_id
     * @return array | bool
     */
    public function authorizationOnBehalfCouch($couch_id)
    {
        $result = false;

        $sel_user = $this->db->query('
            SELECT `user_id`, `user_password`, `user_name`, `user_email`, `user_phone`, `user_type`, `user_blocked`, 
              `user_image`, `user_soc_image` 
            FROM `users` 
            WHERE `user_id`=? and `user_type`=2 LIMIT 1', $couch_id);

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
            SET `user_password`=?, `user_date_update`=? 
            WHERE `user_email`=? LIMIT 1', array($password, $date, $email));

        if (1 == $this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Добавление данных восстановления пароля
     *
     * @param $email
     * @param $email_hash
     * @param $idempotent
     * @param $today
     * @return bool
     */
    public function setRestore($email, $email_hash, $idempotent, $today)
    {
        $up_data = $this->db->query('UPDATE `users` SET `user_activate_code`=?, `user_idempotent`=?, `user_restore_date`=? 
            WHERE `user_email`=? LIMIT 1', array($email_hash, $idempotent, $today, $email));

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
     * @param $expires_at
     * @param $issued_at
     * @param $expires_in
     * @return bool
     */
    public function connectSocial($user_id, $social, $date, $access_token, $social_id, $expires_at, $issued_at, $expires_in)
    {
        $result = true;

        $sel_social = $this->db->query('
            SELECT `us_u_id` FROM `users_social` 
            WHERE `us_social`=? and `us_social_id`=? LIMIT 1', array($social, $social_id));

        if ($sel_social !== false and 0 == $sel_social->num_rows())
        {
            // Прикрепляем соц. сеть к пользователю
            $result = self::setUserSocial($user_id, $social, $social_id, $access_token, $expires_at, $issued_at, $expires_in, $date);
        }

        return $result;
    }

    /**
     * Прикрепление соц. сети к пользователю
     *
     * @param $user_id
     * @param $social
     * @param $social_id
     * @param $access_token
     * @param $expires_at
     * @param $issued_at
     * @param $expires_in
     * @param $date
     * @return bool
     */
    protected function setUserSocial($user_id, $social, $social_id, $access_token, $expires_at, $issued_at, $expires_in, $date)
    {
        $sel_social = $this->db->query('SELECT `us_id` FROM `users_social` 
            WHERE `us_u_id`=? and `us_social`=? and `us_social_id`=? LIMIT 1', array($user_id, $social, $social_id));

        if($sel_social !== false and 0 == $sel_social->num_rows())
        {
            $ins_data = $this->db->query('
                INSERT INTO `users_social` (`us_u_id`, `us_social`, `us_social_id`, `us_token`, `us_expires_at`, 
                    `us_issued_at`, `us_expires_in`, `us_update`) 
                VALUES(?, ?, ?, ?, ?, ?, ?, ?)',
                    array($user_id, $social, $social_id, $access_token, $expires_at, $issued_at, $expires_in, $date));

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
        elseif($sel_social === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
            return false;
        }
        else
        {
            return true;
        }
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
    public function checkEmail($email, $name, $surname, $date)
    {
        $result = array('user_id' => null, 'new_user' => false);

        // Поиск email в БД
        $sel_email = $this->db->query('SELECT `user_email`, `user_id`, `user_auth_via` FROM `users` WHERE `user_email`=? LIMIT 1', $email);

        if($sel_email !== false and 1 == $sel_email->num_rows())
        {
            $row = $sel_email->row();

            // Возвращаем ID пользователя введенного email
            $result['user_id']  = $row->user_id;
            $result['auth_via'] = $row->user_auth_via;

            unset($row);
        }
        elseif($sel_email === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }
        // Если email не найден в БД, регистрируем
        else
        {
            $password   = '';
            $email_hash = password_hash($email, PASSWORD_DEFAULT);
            $name       = $name . ' ' . $surname;

            $user_id = self::userRegistration($email, $password, $email_hash, $date, $name);

            // Возвращаем ID нового пользователя
            $result['user_id']  = is_numeric($user_id) ? $user_id : null;
            $result['new_user'] = is_numeric($user_id) ? $user_id : false;
            $result['auth_via'] = is_numeric($user_id) ? 'native' : null;
        }

        return $result;
    }
}