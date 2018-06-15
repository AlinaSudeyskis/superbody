<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Administration_model
 * 
 * Класс вывода, сохранения, изменения данных пользователей, курсов и т.д.
 * 
 * @author Alina Sudeyskis <alina.sudeyskis@gmail.com>
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Administrator_model extends CI_Model
{
    /**
     * Добавление нового администратора
     *
     * @param string $email E-mail пользователя
     * @param string $name Полное имя пользователя
     * @param string $password_hash Хэш пароля
     * @param string $email_hash Хэш E-mail
     * @param datetime $date Текущая дата
     * @return bool
     */
    public function setNewAdmin($email, $name, $password_hash, $email_hash, $date)
    {
        $sel_user = $this->db->query('SELECT `user_id` FROM `users` WHERE `user_email`=? LIMIT 1', $email);

        if ($sel_user !== false and 0 == $sel_user->num_rows())
        {
            $this->db->query('
                INSERT INTO `users` 
                    (`user_email`, `user_name`, `user_password`, `user_type`, `user_activated`, `user_activate_code`, `user_date_reg`, `user_date_update`)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)', array($email, $name, $password_hash, 3, 0, $email_hash, $date, $date));

            if (1 == $this->db->affected_rows())
            {
                $this->db->query('INSERT INTO `questionnaire` (`user_id`) VALUES (?)', $this->db->insert_id());
                
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
    public function setAdminAvatar($user_id, $path_avatar)
    {
        $result = false;

        if (is_numeric($user_id))
        {
            $up_data = $this->db->query('UPDATE `users` SET `user_image`=? WHERE `user_id`=? and `user_type`=3 LIMIT 1',
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
     * Изменение типа пользователя
     *
     * @param int $user_id
     * @param int $type Тип пользователя (1 - пользователь, 2 - тренер, 3 - администратор)
     * @param string $date
     * @return bool|array
     */
    public function changeUserType($user_id, $type, $date)
    {
        $this->db->query('
            UPDATE `users` SET `user_type`=?, `user_date_update`=? 
            WHERE `user_id`=? LIMIT 1', array($type, $date, $user_id));
        
        if (1 == $this->db->affected_rows()) {
            if ($type == 2) {
                $this->db->query('INSERT INTO `couch_data` (`cd_u_id`) VALUES (?)', $user_id);
            }

            return true;
        } else {
            return false;
        }
    }

    /**
     * Получение данных пользователя
     *
     * @param $user_id
     * @return array
     */
    public function getAdmin($user_id)
    {
        // Результат
        $result = array('user_data' => array());

        $sel_admin = $this->db->query('
            SELECT `user_email`, `user_name`, `user_image`, `user_blocked` 
            FROM `users` 
            WHERE `user_id`=? and `user_type`=3 LIMIT 1', $user_id);

        if (1 == $sel_admin->num_rows()) {
            $row = $sel_admin->row();

            $result['user_data']['user_email']   = $row->user_email;
            $result['user_data']['user_name']    = $row->user_name;
            $result['user_data']['user_image']   = is_file($row->user_image) ? mb_substr($row->user_image, 1) : '';
            $result['user_data']['user_blocked'] = $row->user_blocked;
        }

        return $result;
    }

    /**
     * Сохранение изменений данных администратора
     *
     * @param $user_id
     * @param $user_email
     * @param $user_name
     * @param $path_image
     * @param $date
     * @return bool
     */
    public function setAdminSettings($user_id, $user_email, $user_name, $path_image, $date)
    {
        $this->db->query('
            UPDATE `users` 
            SET `user_email`=?, `user_name`=?, `user_image`=?, `user_date_update`=?
            WHERE `user_id`=? and `user_type`=3 LIMIT 1', array($user_email, $user_name, $path_image, $date, $user_id));

        if (1 == $this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Получение списка администраторов
     *
     * @return array
     */
    public function getAdmins()
    {
        $result = array();
        $sel_couches = $this->db->query('
          SELECT `user_name`, `user_email`, `user_id`, `user_image` 
          FROM `users` WHERE `user_type`=3');

        if ($sel_couches->num_rows() > 0) {
            $i = 0;
            foreach ($sel_couches->result() as $row) {
                $result[$i]['id']    = $row->user_id;
                $result[$i]['name']  = !empty($row->user_name) ? $row->user_name : $row->user_email;
                $result[$i]['image'] = !empty($row->user_image) ? mb_substr($row->user_image, 1) : '';

                $i++;
            }
        }

        return $result;
    }

    /**
     * Блокировка администратора
     *
     * @param $user_id
     * @param $date
     * @return bool
     */
    public function blockAdmin($user_id, $date)
    {
        $this->db->query('
            UPDATE `users` 
            SET `user_blocked`=1, `user_date_update`=? 
            WHERE `user_id`=? and `user_type`=3 LIMIT 1', array($date, $user_id));

        if (1 == $this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Разблокировка администратора
     *
     * @param $user_id
     * @param $date
     * @return bool
     */
    public function unblockAdmin($user_id, $date)
    {
        $this->db->query('
            UPDATE `users` 
            SET `user_blocked`=0, `user_date_update`=? 
            WHERE `user_id`=? and `user_type`=3 LIMIT 1', array($date, $user_id));

        if (1 == $this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Список подписчиков
     *
     * @return mixed
     */
    public function getSublist()
    {
        $result = array();
        
        $sel_users = $this->db->query('SELECT `s_email`, `s_name`, `s_unsubscribe` FROM `subscription`');

        if (0 < $sel_users->num_rows()) {
            $i = 0;
            foreach ($sel_users->result() as $row) {
                $result['users'][$i]['email']       = $row->s_email;
                $result['users'][$i]['name']        = $row->s_name;
                $result['users'][$i]['unsubscribe'] = $row->s_unsubscribe;

                $i++;
            }
            unset($row);

            $result['count_users'] = $i;
        }

        return $result;
    }

    /**
     * Выборка данных сайта
     *
     * @return bool
     */
    public function getSiteInfo()
    {
        $result = false;

        $sel_info = $this->db->query('
            SELECT `si_id`, `si_logo`, `si_index_title`, `si_index_text`, `si_soc_facebook`, `si_soc_twitter`, `si_soc_pinteres`, 
              `si_soc_google_plus`, `si_soc_tumblr`, `si_soc_instagram`, `si_soc_ok`, `si_soc_vk`, `si_soc_youtube`, 
              `si_phone`, `si_email`, `si_rights`, `si_agreement`, `si_policy`, `si_personal_data`, `si_footer`, 
              `si_about`, `si_contacts_text1`, `si_contacts_text2`, `si_user_id`, `si_date` 
            FROM `site_info` LIMIT 1');

        if ($sel_info !== false and 1 == $sel_info->num_rows()) {
            $row = $sel_info->row();

            $result['si_id']          = $row->si_id;
            $result['logotype']       = is_file($row->si_logo) ? mb_substr($row->si_logo, 1) : null;
            $result['index_title']    = $row->si_index_title;
            $result['index_text']     = $row->si_index_text;
            $result['soc_facebook']   = $row->si_soc_facebook;
            $result['soc_twitter']    = $row->si_soc_twitter;
            $result['soc_pinterest']  = $row->si_soc_pinterest;
            $result['soc_google_p']   = $row->si_soc_google_plus;
            $result['soc_tumblr']     = $row->si_soc_tumblr;
            $result['soc_instagram']  = $row->si_soc_instagram;
            $result['soc_ok']         = $row->si_soc_ok;
            $result['soc_vk']         = $row->si_soc_vk;
            $result['soc_youtube']    = $row->si_soc_youtube;
            $result['phone']          = $row->si_phone;
            $result['email']          = $row->si_email;
            $result['rights']         = $row->si_rights;
            $result['agreement']      = $row->si_agreement;
            $result['private_policy'] = $row->si_policy;
            $result['personal_data']  = $row->si_personal_data;
            $result['footer']         = $row->si_footer;
            $result['about']          = $row->si_about;
            $result['contacts_text1'] = $row->si_contacts_text1;
            $result['contacts_text2'] = $row->si_contacts_text2;
        }
        elseif ($sel_info === false) {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Выборка данных заголовка главной страницы сайта
     *
     * @return bool
     */
    public function getSiteIndex()
    {
        $result = false;

        $sel_info = $this->db->query('
            SELECT `si_id`, `si_index_title`, `si_index_text`, `si_user_id`, `si_date` 
            FROM `site_info` LIMIT 1');

        if ($sel_info !== false and 1 == $sel_info->num_rows()) {
            $row = $sel_info->row();

            $result['si_id']       = $row->si_id;
            $result['index_title'] = $row->si_index_title;
            $result['index_text']  = $row->si_index_text;
        }
        elseif ($sel_info === false) {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Выборка данных шапки и футера сайта
     *
     * @return bool
     */
    public function getSiteHeader()
    {
        $result = false;

        $sel_info = $this->db->query('
            SELECT `si_id`, `si_logo`, `si_soc_facebook`, `si_soc_twitter`, `si_soc_pinteres`, `si_soc_google_plus`, `si_soc_tumblr`, 
              `si_soc_instagram`, `si_soc_ok`, `si_soc_vk`, `si_soc_youtube`, `si_rights`, `si_agreement`, `si_policy`, `si_personal_data`, `si_footer`, 
              `si_user_id`, `si_date` 
            FROM `site_info` LIMIT 1');

        if ($sel_info !== false and 1 == $sel_info->num_rows()) {
            $row = $sel_info->row();

            $result['si_id']          = $row->si_id;
            $result['logotype']       = is_file($row->si_logo) ? mb_substr($row->si_logo, 1) : null;
            $result['soc_facebook']   = $row->si_soc_facebook;
            $result['soc_twitter']    = $row->si_soc_twitter;
            $result['soc_pinterest']  = $row->si_soc_pinterest;
            $result['soc_google_p']   = $row->si_soc_google_plus;
            $result['soc_tumblr']     = $row->si_soc_tumblr;
            $result['soc_instagram']  = $row->si_soc_instagram;
            $result['soc_ok']         = $row->si_soc_ok;
            $result['soc_vk']         = $row->si_soc_vk;
            $result['soc_youtube']    = $row->si_soc_youtube;
            $result['rights']         = $row->si_rights;
            $result['agreement']      = $row->si_agreement;
            $result['private_policy'] = $row->si_policy;
            $result['personal_data']  = $row->si_personal_data;
            $result['footer']         = $row->si_footer;
        }
        elseif ($sel_info === false) {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Выборка данных "О нас" сайта
     *
     * @return bool
     */
    public function getSiteAbout()
    {
        $result = false;

        $sel_info = $this->db->query('
            SELECT `si_id`, `si_about`, `si_user_id`, `si_date` 
            FROM `site_info` LIMIT 1');

        if ($sel_info !== false and 1 == $sel_info->num_rows()) {
            $row = $sel_info->row();

            $result['si_id'] = $row->si_id;
            $result['about'] = parent::showBBcodes($row->si_about);
        }
        elseif ($sel_info === false) {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Выборка данных "Контакты" сайта
     *
     * @return bool
     */
    public function getSiteContacts()
    {
        $result = false;

        $sel_info = $this->db->query('
            SELECT `si_id`, `si_phone`, `si_email`, `si_contacts_text1`, `si_contacts_text2`, `si_user_id`, `si_date` 
            FROM `site_info` LIMIT 1');

        if ($sel_info !== false and 1 == $sel_info->num_rows())
        {
            $row = $sel_info->row();

            $result['si_id']          = $row->si_id;
            $result['phone']          = $row->si_phone;
            $result['email']          = $row->si_email;
            $result['contacts_text1'] = $row->si_contacts_text1;
            $result['contacts_text2'] = $row->si_contacts_text2;
        }
        elseif ($sel_info === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Выборка данных блока авторизации
     *
     * @return bool|array
     */
    public function getSiteAuth()
    {
        $result = false;

        $sel_info = $this->db->query('
            SELECT `si_id`, `si_auth_title1`, `si_auth_title2`, `si_auth_subtitle1`, `si_auth_subtitle2`, `si_auth_text1`, 
              `si_auth_text2`, `si_auth_url1`, `si_auth_url2`, `si_auth_url_name1`, `si_auth_url_name2` 
            FROM `site_info` LIMIT 1');

        if ($sel_info !== false and 1 == $sel_info->num_rows())
        {
            $row = $sel_info->row();

            $result['si_id']          = $row->si_id;
            $result['auth_title1']    = $row->si_auth_title1;
            $result['auth_title2']    = $row->si_auth_title2;
            $result['auth_subtitle1'] = $row->si_auth_subtitle1;
            $result['auth_subtitle2'] = $row->si_auth_subtitle2;
            $result['auth_text1']     = $row->si_auth_text1;
            $result['auth_text2']     = $row->si_auth_text2;
            $result['auth_url1']      = $row->si_auth_url1;
            $result['auth_url2']      = $row->si_auth_url2;
            $result['auth_url_name1'] = $row->si_auth_url_name1;
            $result['auth_url_name2'] = $row->si_auth_url_name2;
        }
        elseif ($sel_info === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Выборка баннеров сайта
     *
     * @return bool
     */
    public function getSiteBanners()
    {
        $result = false;

        $sel_banners = $this->db->query('
            SELECT `sb_id`, `sb_image`, `sb_url`, `sb_blocked`
            FROM `site_banners`');

        if ($sel_banners !== false and 0 < $sel_banners->num_rows())
        {
            $i = 0;
            foreach($sel_banners->result() as $row)
            {
                $result['banners'][$i]['id'] = $row->sb_id;
                $result['banners'][$i]['image'] = is_file($row->sb_image) ? mb_substr($row->sb_image, 1) : '';
                $result['banners'][$i]['url'] = $row->sb_url;
                $result['banners'][$i]['blocked'] = $row->sb_blocked;

                $i++;
            }
            unset($row);
        }
        elseif ($sel_banners === false) {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Сохранение данных о сайте
     *
     * @param $logotype
     * @param $agreement
     * @param $private_policy
     * @param $personal_data
     * @param $rights
     * @param $footer
     * @param $soc_facebook
     * @param $soc_twitter
     * @param $soc_pinterest
     * @param $soc_google
     * @param $soc_tumblr
     * @param $soc_instagram
     * @param $soc_ok
     * @param $soc_vk
     * @param $soc_youtube
     * @param $date
     * @param $user_id
     * @return bool
     */
    public function setSiteHeader($logotype, $agreement, $private_policy, $personal_data, $rights, $footer, $soc_facebook,
                                  $soc_twitter, $soc_pinterest, $soc_google, $soc_tumblr, $soc_instagram, $soc_ok,
                                  $soc_vk, $soc_youtube, $date, $user_id)
    {
        $up_info = $this->db->query('
            UPDATE `site_info` 
            SET `si_logo`=?, `si_soc_facebook`=?, `si_soc_twitter`=?, `si_soc_pinteres`=?, `si_soc_google_plus`=?, `si_soc_tumblr`=?, 
              `si_soc_instagram`=?, `si_soc_ok`=?, `si_soc_vk`=?, `si_soc_youtube`=?, `si_rights`=?, `si_agreement`=?, 
              `si_policy`=?, `si_personal_data`=?, `si_footer`=?, `si_user_id`=?, `si_date`=? 
            WHERE `si_id`=? LIMIT 1',
            array($logotype, $soc_facebook, $soc_twitter, $soc_pinterest, $soc_google, $soc_tumblr, $soc_instagram, $soc_ok, $soc_vk,
                $soc_youtube, $rights, $agreement, $private_policy, $personal_data, $footer, $user_id, $date, 1));

        if ($up_info !== false and 1 == $this->db->affected_rows()) {
            return true;
        }
        elseif ($up_info === false) {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
            return false;
        }
        else {
            return false;
        }
    }

    /**
     * Сохранение данных о сайте
     *
     * @param $title
     * @param $text
     * @param $date
     * @param $user_id
     * @return bool
     */
    public function setSiteIndex($title, $text, $date, $user_id)
    {
        $up_info = $this->db->query('
            UPDATE `site_info` 
            SET `si_index_title`=?, `si_index_text`=?, `si_user_id`=?, `si_date`=? 
            WHERE `si_id`=? LIMIT 1',
            array($title, $text, $user_id, $date, 1));

        if ($up_info !== false and 1 == $this->db->affected_rows()) {
            return true;
        }
        elseif ($up_info === false) {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
            return false;
        }
        else {
            return false;
        }
    }

    /**
     * Сохранение данных о сайте
     *
     * @param $about
     * @param $date
     * @param $user_id
     * @return bool
     */
    public function setSiteAbout($about, $date, $user_id)
    {
        $up_info = $this->db->query('
            UPDATE `site_info` 
            SET `si_about`=?, `si_user_id`=?, `si_date`=? 
            WHERE `si_id`=? LIMIT 1',
            array($about, $user_id, $date, 1));

        if ($up_info !== false and 1 == $this->db->affected_rows()) {
            return true;
        }
        elseif ($up_info === false) {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
            return false;
        }
        else {
            return false;
        }
    }

    /**
     * Сохранение данных о сайте
     *
     * @param $email
     * @param $phone
     * @param $contacts_text1
     * @param $contacts_text2
     * @param $date
     * @param $user_id
     * @return bool
     */
    public function setSiteContacts($email, $phone, $contacts_text1, $contacts_text2, $date, $user_id)
    {
        $up_info = $this->db->query('
            UPDATE `site_info` 
            SET `si_email`=?, `si_phone`=?, `si_contacts_text1`=?, `si_contacts_text2`=?, `si_user_id`=?, `si_date`=? 
            WHERE `si_id`=? LIMIT 1',
            array($email, $phone, $contacts_text1, $contacts_text2, $user_id, $date, 1));

        if ($up_info !== false and 1 == $this->db->affected_rows()) {
            return true;
        }
        elseif ($up_info === false) {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
            return false;
        }
        else {
            return false;
        }
    }

    /**
     * Сохранение изменений данных о блоке авторизации
     *
     * @param $title_1
     * @param $title_2
     * @param $subtitle_1
     * @param $subtitle_2
     * @param $text_1
     * @param $text_2
     * @param $url_1
     * @param $url_2
     * @param $url_name_1
     * @param $url_name_2
     * @param $date
     * @param $user_id
     * @return bool
     */
    public function setSiteAuth($title_1, $title_2, $subtitle_1, $subtitle_2, $text_1, $text_2, $url_1, $url_2,
                                $url_name_1, $url_name_2, $date, $user_id)
    {
        $up_info = $this->db->query('
            UPDATE `site_info` SET `si_auth_title1`=?, `si_auth_title2`=?, `si_auth_subtitle1`=?, `si_auth_subtitle2`=?,
              `si_auth_text1`=?,`si_auth_text2`=?,`si_auth_url1`=?,`si_auth_url2`=?,`si_auth_url_name1`=?,
              `si_auth_url_name2`=?,`si_user_id`=?,`si_date`=? 
            WHERE `si_id`=? LIMIT 1',
                array($title_1, $title_2, $subtitle_1, $subtitle_2, $text_1, $text_2, $url_1, $url_2, $url_name_1,
                    $url_name_2, $user_id, $date, 1));

        if ($up_info !== false and 1 == $this->db->affected_rows()) {
            return true;
        }
        elseif ($up_info === false) {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
            return false;
        }
        else {
            return false;
        }
    }

    /**
     * Сохранение нового баннера
     *
     * @param $banner_image
     * @param $banner_url
     * @param $user_id
     * @param $date
     * @return bool
     */
    public function setNewBanner($banner_image, $banner_url, $user_id, $date)
    {
        $up_data = $this->db->query('
            INSERT INTO `site_banners` (`sb_image`, `sb_url`, `sb_u_id`, `sb_update`) VALUES (?, ?, ?, ?)',
                array($banner_image, $banner_url, $user_id, $date));

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
     * Сохранение изменений баннера
     *
     * @param $banner_id
     * @param $banner_image
     * @param $banner_url
     * @param $user_id
     * @param $date
     * @return bool
     */
    public function setBannerSettings($banner_id, $banner_image, $banner_url, $user_id, $date)
    {
        $up_data = $this->db->query('
            UPDATE `site_banners` SET `sb_image`=?, `sb_url`=?, `sb_update`=? WHERE `sb_id`=? LIMIT 1',
            array($banner_image, $banner_url, $date, $banner_id));

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
     * Выборка баннера
     *
     * @param $banner_id
     * @return bool
     */
    public function getBanner($banner_id)
    {
        $result = false;

        $sel_banner = $this->db->query('
            SELECT `sb_id`, `sb_image`, `sb_url`, `sb_u_id`, `sb_update`, `sb_blocked` 
            FROM `site_banners` 
            WHERE `sb_id`=? LIMIT 1', $banner_id);

        if ($sel_banner !== false and 1 == $sel_banner->num_rows())
        {
            $row = $sel_banner->row();

            $result['banner']['id']      = $row->sb_id;
            $result['banner']['image']   = is_file($row->sb_image) ? mb_substr($row->sb_image, 1) : '';
            $result['banner']['url']     = $row->sb_url;
            $result['banner']['blocked'] = $row->sb_blocked;
            $result['banner']['date']    = $row->sb_update;
        }
        elseif ($sel_banner === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
            $result = false;
        }
        else
        {
            $result = false;
        }

        return $result;
    }

    /**
     * Блокировка баннера
     *
     * @param $banner_id
     * @param $date
     * @return bool
     */
    public function blockBanner($banner_id, $date)
    {
        $up_data = $this->db->query('UPDATE `site_banners` SET `sb_blocked`=1, `sb_update`=? WHERE `sb_id`=? LIMIT 1',
            array($date, $banner_id));

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
     * Разблокировка баннера
     *
     * @param $banner_id
     * @param $date
     * @return bool
     */
    public function unblockBanner($banner_id, $date)
    {
        $up_data = $this->db->query('UPDATE `site_banners` SET `sb_blocked`=0, `sb_update`=? WHERE `sb_id`=? LIMIT 1',
            array($date, $banner_id));

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
     * Удаление баннера
     *
     * @param $banner_id
     * @return bool
     */
    public function deleteBanner($banner_id)
    {
        $up_data = $this->db->query('DELETE FROM `site_banners` WHERE `sb_id`=? LIMIT 1', $banner_id);

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
}