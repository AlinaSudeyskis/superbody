<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Welcome class
 *
 * @author Alina Sudeyskis <alina.sudeyskis@gmail.com>
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */

class Welcome_model extends CI_Model
{
    /**
     * Сохранение E-mail в БД для подписки
     *
     * @param $email
     * @param $name
     * @param $date
     * @return bool
     */
    public function setNewSubscriber($email, $name, $date)
    {
        $sel_email = $this->db->query('SELECT `s_id` FROM `subscription` WHERE `s_email`=? LIMIT 1', $email);
        
        if ($sel_email !== false and 0 == $sel_email->num_rows())
        {
            $ins_email = $this->db->query('
                INSERT INTO `subscription` (`s_email`, `s_name`, `s_date`)
                VALUES (?, ?, ?)', array($email, $name, $date));

            if ($ins_email !== false and 1 == $this->db->affected_rows())
            {
                return true;
            }
            elseif ($ins_email === false)
            {
                parent::logDbMessages(__METHOD__);
                return false;
            }
            else
            {
                return 2;
            }
        }
        elseif ($sel_email === false)
        {
            parent::logDbMessages(__METHOD__);
            return false;
        }
        else {
            return 3;
        }
    }

    /**
     * Удаление email из подписчиков
     *
     * @param $email
     * @return bool
     */
    public function unsubscribeEmail($email)
    {
        $up_data = $this->db->query('UPDATE `subscription` SET `s_unsubscribe`=1 WHERE `s_email`=? LIMIT 1', $email);

        if($up_data !== false and 1 == $this->db->affected_rows())
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
              `si_about`, `si_contacts_text1`, `si_contacts_text2`, `si_auth_title1`, `si_auth_title2`, `si_auth_subtitle1`, 
              `si_auth_subtitle2`, `si_auth_text1`, `si_auth_text2`, `si_auth_url1`, `si_auth_url2`, `si_auth_url_name1`, 
              `si_auth_url_name2`
            FROM `site_info` LIMIT 1');

        if ($sel_info !== false and 1 == $sel_info->num_rows())
        {
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
            $result['about']          = parent::showBBcodes($row->si_about);
            $result['contacts_text1'] = $row->si_contacts_text1;
            $result['contacts_text2'] = $row->si_contacts_text2;
            $result['banners']        = array();
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

            $sel_banners = $this->db->query('
                SELECT `sb_image`, `sb_url` FROM `site_banners` WHERE `sb_blocked`=0');
            if ($sel_banners !== false and 0 < $sel_banners->num_rows())
            {
                $i = 0;
                foreach ($sel_banners->result() as $row)
                {
                    if (is_file($row->sb_image))
                    {
                        $result['banners'][$i]['image'] = mb_substr($row->sb_image, 1);
                        $result['banners'][$i]['url']   = $row->sb_url;

                        $i++;
                    }
                }
                unset($row);
            }
            elseif ($sel_banners === false)
            {
                parent::logDbMessages(__METHOD__);
            }
        }
        elseif ($sel_info === false)
        {
            parent::logDbMessages(__METHOD__);
        }

        return $result;
    }

    /**
     * Обновление БД
     *
     * @param $date
     */
    public function updateDatabase($date)
    {
        // 15.01.2018
        /*$this->db->query('
            CREATE TABLE `site_banners` ( 
              `sb_id` INT UNSIGNED NOT NULL AUTO_INCREMENT , 
              `sb_image` VARCHAR(255) NOT NULL , 
              `sb_url` VARCHAR(255) NOT NULL , 
              `sb_blocked` TINYINT(1) UNSIGNED NOT NULL , 
              `sb_u_id` INT UNSIGNED NOT NULL , 
              `sb_update` DATETIME NOT NULL , 
              PRIMARY KEY (`sb_id`)) ENGINE = MyISAM');

        $this->db->query('ALTER TABLE `site_banners` ADD INDEX `ix_sb_blocked`(`sb_blocked`)');

        $this->db->query('ALTER TABLE `video` ADD `video_crs_id` INT UNSIGNED NOT NULL AFTER `video_type`');
        $this->db->query('ALTER TABLE `video` ADD INDEX `ix_v_crs_id` (`video_crs_id`)');

        $this->db->query('
            CREATE TABLE `courses_reviews` ( 
              `cr_id` INT UNSIGNED NOT NULL AUTO_INCREMENT , 
              `cr_crs_id` INT UNSIGNED NOT NULL , 
              `cr_u_id` INT UNSIGNED NOT NULL , 
              `cr_review` VARCHAR(1000) NOT NULL , 
              `cr_approval` TINYINT(1) NOT NULL DEFAULT "0" , 
              `cr_date_add` DATETIME NOT NULL , 
              `cr_update` DATETIME NOT NULL , 
              PRIMARY KEY (`cr_id`), 
              INDEX `ix_cr_crs_u_id` (`cr_crs_id`, `cr_u_id`)) ENGINE = MyISAM');
        $this->db->query('ALTER TABLE `courses_reviews` ADD INDEX `ix_cr_id_crs_u_id`(`cr_id`, `cr_crs_id`, `cr_u_id`)');
        $this->db->query('ALTER TABLE `courses_reviews` ADD INDEX `ix_cr_crs_id`(`cr_crs_id`)');
        $this->db->query('ALTER TABLE `courses_reviews` ADD INDEX `ix_cr_id_crs_u_id_appr`(`cr_id`, `cr_crs_id`, `cr_u_id`, `cr_approval`)');
        $this->db->query('ALTER TABLE `courses_landing_pages` ADD `clp_block7_title` VARCHAR(50) NOT NULL AFTER `clp_block7_background`');
        $this->db->query('ALTER TABLE `landing_pages` ADD `lp_block7_title` VARCHAR(50) NOT NULL AFTER `lp_block7_background`');*/

        // 18.01.2018

        /*$this->db->query('ALTER TABLE `courses_landing_pages` ADD `clp_block2_button` VARCHAR(40) NOT NULL AFTER `clp_block2_text`');
        $this->db->query('ALTER TABLE `courses_landing_pages` ADD `clp_block4_button` VARCHAR(40) NOT NULL AFTER `clp_block4_r_subtitle`');
        $this->db->query('ALTER TABLE `courses_landing_pages` ADD `clp_block5_button` VARCHAR(40) NOT NULL AFTER `clp_block5_r_text`');
        $this->db->query('ALTER TABLE `courses_landing_pages` ADD `clp_block6_button` VARCHAR(40) NOT NULL AFTER `clp_block6_image`');
        $this->db->query('ALTER TABLE `courses_landing_pages` ADD `clp_block7_button` VARCHAR(40) NOT NULL AFTER `clp_block7_text`');
        $this->db->query('ALTER TABLE `courses_landing_pages` ADD `clp_block8_button` VARCHAR(40) NOT NULL AFTER `clp_block8_new_price`');
        $this->db->query('ALTER TABLE `landing_pages` ADD `lp_block2_button` VARCHAR(40) NOT NULL AFTER `lp_block2_text`');
        $this->db->query('ALTER TABLE `landing_pages` ADD `lp_block4_button` VARCHAR(40) NOT NULL AFTER `lp_block4_r_subtitle`');
        $this->db->query('ALTER TABLE `landing_pages` ADD `lp_block5_button` VARCHAR(40) NOT NULL AFTER `lp_block5_r_text`');
        $this->db->query('ALTER TABLE `landing_pages` ADD `lp_block6_button` VARCHAR(40) NOT NULL AFTER `lp_block6_image`');
        $this->db->query('ALTER TABLE `landing_pages` ADD `lp_block7_button` VARCHAR(40) NOT NULL AFTER `lp_block7_text`');
        $this->db->query('ALTER TABLE `landing_pages` ADD `lp_block8_button` VARCHAR(40) NOT NULL AFTER `lp_block8_new_price`');*/

        // 26.01.2018
        /*$password = password_hash('password_test', PASSWORD_DEFAULT);
        $this->db->query('
            INSERT INTO `users` (`user_email`, `user_password`, `user_type`, `user_activated`, `user_date_reg`, `user_date_update`)
            VALUES (?, ?, ?, ?, ?, ?)', array('test@superbody.pro', $password, 1, 1, $date, $date));

        $user_id = $this->db->insert_id();
        echo $user_id;

        // Добавляем данные пользователя в таблицу анкеты
        $this->db->query('INSERT INTO `questionnaire` (`user_id`) VALUES (?)', $user_id);*/

        // 09.02.2018
        /*$this->db->query('ALTER TABLE `site_info` ADD `si_policy` VARCHAR(255) NOT NULL AFTER `si_agreement`');
        $this->db->query('ALTER TABLE `site_info` ADD `si_personal_data` VARCHAR(255) NOT NULL AFTER `si_policy`');
        $this->db->query("ALTER TABLE `video` CHANGE `video_type` `video_type` TINYINT(1) UNSIGNED NOT NULL COMMENT '0 - без категории, 1 - промо, 2 – тренировки, 3 – инструктаж'");*/

        // 13.02.2018
        /*$this->db->query('ALTER TABLE `site_info` ADD `si_soc_ok` VARCHAR(25) NOT NULL AFTER `si_soc_rss`');
        $this->db->query('ALTER TABLE `site_info` ADD `si_soc_vk` VARCHAR(255) NOT NULL AFTER `si_soc_ok`');*/

        // 15.02.2018
        /*$this->db->query('UPDATE `landing_pages` SET `lp_html_page` = "landing/1/" WHERE`landing_pages`.`lp_id` = 1');
        $this->db->query('UPDATE `landing_pages` SET `lp_html_page` = "landing/2/" WHERE`landing_pages`.`lp_id` = 2');
        $this->db->query('ALTER TABLE `site_info` ADD `si_index_title` VARCHAR(40) NOT NULL AFTER `si_id`');
        $this->db->query('ALTER TABLE `site_info` ADD `si_index_text` VARCHAR(300) NOT NULL AFTER `si_index_title`');
        $this->db->query('ALTER TABLE `site_info` CHANGE `si_contacts` `si_contacts_text1` VARCHAR(300) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL');
        $this->db->query('ALTER TABLE `site_info` ADD `si_contacts_text2` VARCHAR(300) NOT NULL AFTER `si_contacts_text1`');
        $this->db->query('ALTER TABLE `site_info` ADD `si_logo` VARCHAR(255) NOT NULL AFTER `si_id`');
        $this->db->query('ALTER TABLE `site_info` ADD `si_soc_youtube` VARCHAR(255) NOT NULL AFTER `si_soc_vk`');*/

        // 16.02.2018
        /*$this->db->query('ALTER TABLE `users` CHANGE `user_auth_via` `user_auth_via` ENUM ("native","vk","facebook","ok","instagram") CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT "native"');
        $this->db->query('CREATE TABLE `users_social` (
            `us_id` INT UNSIGNED NOT NULL AUTO_INCREMENT , 
            `us_u_id` INT UNSIGNED NOT NULL , 
            `us_social` ENUM ("facebook", "instagram", "ok", "vk") NOT NULL , 
            `us_social_id` BIGINT UNSIGNED NOT NULL , 
            `us_token` TEXT NOT NULL ,
            `us_expires_at` INT UNSIGNED NOT NULL , 
            `us_issued_at` INT UNSIGNED NOT NULL,
            `us_update` DATETIME NOT NULL , 
            PRIMARY KEY (`us_id`)) ENGINE = MyISAM');
        $this->db->query('ALTER TABLE `users_social` ADD `us_expires_in` INT UNSIGNED NOT NULL AFTER `us_expires_at`');*/

        /*$this->db->query('DELETE FROM `users_social`');
        $sel_social = $this->db->query('SELECT * FROM `users_social`');
        $row = $sel_social->result();
        log_message('debug', print_r($row, true));*/

        // 20.02.2018
        //$this->db->query('ALTER TABLE `users_social` ADD `us_available` TINYINT(1) UNSIGNED NOT NULL DEFAULT "0" AFTER `us_social`');
        //$this->db->query('ALTER TABLE `users_social` ADD `us_url_profile` VARCHAR(255) NOT NULL AFTER `us_social_id`');

        // 02.03.2018
        //$this->db->query('DELETE FROM `users_courses` WHERE `uc_user_id`=? and `uc_course_id`=? LIMIT 1', array(4, 11));

        // 12.03.2018
        /*$this->db->query('CREATE TABLE `orders_payment` (
            `op_id` INT UNSIGNED NOT NULL AUTO_INCREMENT , 
            `op_o_id` INT UNSIGNED NOT NULL , 
            `op_payment_id` VARCHAR(50) NOT NULL , 
            `op_status` ENUM("waiting_for_capture","succeeded","canceled","pending") NOT NULL ,
            `op_paid` TINYINT(1) UNSIGNED NOT NULL , 
            `op_created_at` VARCHAR(24) NOT NULL , 
            `op_expires_at` VARCHAR(24) NOT NULL , 
            PRIMARY KEY (`op_id`), 
            INDEX `ix_op_payment_id` (`op_payment_id`)) ENGINE = MyISAM;');*/

        // 13.03.2018
        /*$this->db->query('ALTER TABLE `orders_payment`
          ADD `op_amount` DECIMAL(10,2) NOT NULL AFTER `op_expires_at`, 
          ADD `op_payment_method_saved` TINYINT(1) UNSIGNED NOT NULL AFTER `op_amount`, 
          ADD `op_payment_method_id` VARCHAR(50) NOT NULL AFTER `op_payment_method_saved`, 
          ADD `op_following_date` DATETIME NOT NULL AFTER `op_payment_method_id`');*/

        // 14.03.2018
        /*$this->db->query('ALTER TABLE `orders_payment` CHANGE `op_status` `op_status` ENUM("waiting_for_capture","succeeded","canceled","pending","") CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL');
        $this->db->query('ALTER TABLE `orders_payment` ADD `op_number` TINYINT(3) UNSIGNED NOT NULL AFTER `op_o_id`');*/

        // 16.03.2018
        //$this->db->query('ALTER TABLE `orders_payment` ADD `op_currency` VARCHAR(3) NOT NULL AFTER `op_amount`');
        //$this->db->query('ALTER TABLE `orders_payment` ADD `op_payment_type` VARCHAR(25) NOT NULL AFTER `op_number`');
        /*$this->db->query('ALTER TABLE `orders_payment` ADD `op_captured_at` VARCHAR(50) NOT NULL AFTER `op_created_at`');
        $this->db->query('ALTER TABLE `orders_payment` CHANGE `op_created_at` `op_created_at` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL, 
            CHANGE `op_expires_at` `op_expires_at` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL');*/

        // 18.03.2018
        /*$this->db->query('CREATE TABLE `orders_payment_refund` (
            `opr_id` INT UNSIGNED NOT NULL AUTO_INCREMENT , 
            `opr_payment_id` VARCHAR(50) NOT NULL , 
            `opr_refund_id` VARCHAR(50) NOT NULL , 
            `opr_refund_amount` DECIMAL(10,2) NOT NULL , 
            `opr_refund_status` ENUM("succeeded","canceled") NOT NULL , 
            `opr_refund_description` VARCHAR(255) NOT NULL , 
            `opr_refund_created_at` VARCHAR(50) NOT NULL , 
            PRIMARY KEY (`opr_id`)) ENGINE = MyISAM');*/

        // 19.03.2018
        //$this->db->query('ALTER TABLE `users_courses` ADD `uc_paused` TINYINT(1) NOT NULL AFTER `uc_blocked`');
        /*$this->db->query('ALTER TABLE `courses` ADD `crs_recurrent_price` DECIMAL(10,2) NOT NULL AFTER `crs_fitcoin_price`,
            ADD `crs_recurrent_months` TINYINT(2) UNSIGNED NOT NULL AFTER `crs_recurrent_price`,
            ADD `crs_recurrent_first` DECIMAL(10,2) NOT NULL AFTER `crs_recurrent_months`,
            ADD `crs_recurrent_subsequent` DECIMAL(10,2) NOT NULL AFTER `crs_recurrent_first`');*/

        // 20.03.2018
        /*$this->db->query('ALTER TABLE `orders_payment` ADD `op_payment_options` ENUM("full_payment","installments","") NOT NULL AFTER `op_currency`');
        $this->db->query('ALTER TABLE `orders_payment` CHANGE `op_following_date` `op_following_date` DATE NOT NULL');*/

        // 23.03.2018
        //$this->db->query('ALTER TABLE `feedback` ADD `fb_user_id` INT UNSIGNED NOT NULL AFTER `fb_user_email`');

        // 03.04.2018
        //$this->db->query('ALTER TABLE `users` ADD `user_idempotent` VARCHAR(255) NOT NULL AFTER `user_date_update`, ADD `user_restore_date` DATETIME NOT NULL AFTER `user_idempotent`');

        // 09.04.2018
        //$this->db->query('ALTER TABLE `users` ADD `user_phone` VARCHAR(50) NOT NULL AFTER `user_image`');

        // 11.04.2018
        /*$this->db->query('ALTER TABLE `site_info` ADD `si_auth_title1` VARCHAR(30) NOT NULL AFTER `si_contacts_text2`,
            ADD `si_auth_title2` VARCHAR(30) NOT NULL AFTER `si_auth_title1`, 
            ADD `si_auth_subtitle1` VARCHAR(30) NOT NULL AFTER `si_auth_title2`, 
            ADD `si_auth_subtitle2` VARCHAR(30) NOT NULL AFTER `si_auth_subtitle1`, 
            ADD `si_auth_text1` VARCHAR(150) NOT NULL AFTER `si_auth_subtitle2`, 
            ADD `si_auth_text2` VARCHAR(150) NOT NULL AFTER `si_auth_text1`, 
            ADD `si_auth_url1` VARCHAR(255) NOT NULL AFTER `si_auth_text2`, 
            ADD `si_auth_url2` VARCHAR(255) NOT NULL AFTER `si_auth_url1`, 
            ADD `si_auth_url_name1` VARCHAR(30) NOT NULL AFTER `si_auth_url2`, 
            ADD `si_auth_url_name2` VARCHAR(15) NOT NULL AFTER `si_auth_url_name1`');*/

        // 12.04.2018
        /*$this->db->query('UPDATE `categories` SET `cat_id` = "4" WHERE `categories`.`cat_id` = 3');
        $this->db->query('UPDATE `categories` SET `cat_id` = "3" WHERE `categories`.`cat_id` = 2');
        $this->db->query('UPDATE `categories` SET `cat_id` = "2" WHERE `categories`.`cat_id` = 1');
        $this->db->query('INSERT INTO `categories` (`cat_name`, `cat_description`, `cat_date_add`, `cat_date_update`, `cat_admin_id`) 
            VALUES (?, ?, ?, ?, ?)',
                array('Курсы', 'Вы знаете, что тренироваться нужно регулярно, но сбалансировать свое расписание бывает трудно.', '2018-04-12 10:58:02', '2018-04-12 10:58:02', 4));
        $this->db->query('UPDATE `categories` SET `cat_id` = "1" WHERE `categories`.`cat_id` = 5');*/

        /*$this->db->query('UPDATE `products_categories` SET `pc_cat_id`=4 WHERE `pc_cat_id`=3');
        $this->db->query('UPDATE `products_categories` SET `pc_cat_id`=3 WHERE `pc_cat_id`=2');
        $this->db->query('UPDATE `products_categories` SET `pc_cat_id`=2 WHERE `pc_cat_id`=1');
        $this->db->query('UPDATE `products_categories` SET `pc_cat_id`=1 WHERE `pc_cat_id`=0');*/

        // 16.04.2018
        //$this->db->query('ALTER TABLE `users` ADD `user_country_code` VARCHAR(5) NOT NULL AFTER `user_image`');
        //$this->db->query('ALTER TABLE `orders` ADD `o_user_country_code` VARCHAR(5) NOT NULL AFTER `o_user_email`');

        // 19.04.2018
        /*$this->db->query('
            CREATE TABLE `notifications` ( 
            `n_id` SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT ,
            `n_name` VARCHAR(255) NOT NULL,
            `n_text` VARCHAR(255) NOT NULL ,
            `n_admin_id` INT NOT NULL , 
            `n_date` DATETIME NOT NULL , 
            PRIMARY KEY (`n_id`)) ENGINE = MyISAM');


		$list_errors = array (
			"1" => "Ошибка! Пользователь с таким E-mail уже зарегистрирован.",
			"2" => "Ошибка! Не удалось зарегестрировать E-mail. Пожалуйста, повторите попытку.",
			"3" => "Ошибка! Не удалось активировать аккаунт. Пожалуйста, повторите попытку.",
			"4" => "Ошибка! Аккаунт не активирован. Неверный код активации.",
			"5" => "Ошибка! Не удалось авторизовать Вас. Пожалуйста, повторите попытку.",
			"6" => "Ошибка! Некорректный E-mail",
			"7" => "Ошибка! Неверный E-mail или пароль. Пожалуйста, повторите попытку.",
			"8" => "Ошибка! Проверьте, пожалуйста, корректность и заполните все поля регистрации.",
			"9" => "Ошибка! Изменения не были сохранены. Пожалуйста, повторите попытку.",
			"10" => "Сохранено!",
			"11" => "Ошибка! Не удалось сохранить имя. Пожалуйста, повторите попытку.",
			"12" => "Ошибка! Не удалось сохранить данные анкеты. Пожалуйста, повторите попытку.",
			"13" => "Ошибка! Не удалось сохранить антропометрические данные. Пожалуйста, повторите попытку.",
			"14" => "Ошибка! Не удалось сохранить нового администратора. Пожалуйста, повторите попытку.",
			"15" => "Ошибка! Не удалось сохранить нового тренера. Пожалуйста, повторите попытку.",
			"16" => "Аккаунт пользователя заблокирован!",
			"17" => "Ошибка! Пользователя не заблокирован. Пожалуйста, повторите попытку.",
			"18" => "Пользователь разблокирован.",
			"19" => "Ошибка! Пользователь не разблокирован. Пожалуйста, повторите попытку.",
			"20" => "Аккаунт активирован!",
			"21" => "Ошибка! Имя и данные анкеты не сохранены. Пожалуйста, повторите попытку.",
			"22" => "Ошибка! Имя и антропометрические данные не сохранены. Пожалуйста, повторите попытку.",
			"23" => "Ошибка! Данные анкеты и антропометрические данные не сохранены. Пожалуйста, повторите попытку.",
			"24" => "Ошибка! Имя, данные анкеты и антропометрические данные не сохранены. Пожалуйста, повторите попытку.",
			"25" => "Ошибка! Категория курса не сохраненв. Пожалуйста, повторите попытку.",
			"26" => "Ошибка! Прием пищи не сохранен. Пожалуйста, повторите попытку.",
			"27" => "Ошибка! Типа приема пищи не сохранен. Пожалуйста, повторите попытку.",
			"28" => "Ошибка! Новый курс не сохранен. Пожалуйста, повторите попытку.",
			"29" => "Ошибка! Проверьте, пожалуйста, корректность и заполните все поля.",
            "30" => "Ошибка! Курс не сохранен. Пожалуйста, повторите попытку.",
            "31" => "Ошибка! Расписание курса не сохранено. Пожалуйста, повторите попытку.",
            "32" => "Ошибка! Основные данные и расписание курса не сохранены. Пожалуйста, повторите попытку.",
            "33" => "Ошибка! Курс не заблокирован. Пожалуйста, повторите попытку.",
            "34" => "Ошибка! Курс не разблокирован. Пожалуйста, повторите попытку.",
            "35" => "Ошибка! Запись блога не одобрена. Пожалуйста, повторите попытку.",
            "36" => "Ошибка! Запись блога не заблокирована. Пожалуйста, повторите попытку.",
            "37" => "Ошибка! Комментарий блога не одобрен. Пожалуйста, повторите попытку.",
            "38" => "Ошибка! Комментарий блога не заблокирован. Пожалуйста, повторите попытку.",
            "39" => "Ошибка! Видео не сохранено. Пожалуйста, повторите попытку.",
            "40" => "Ошибка! Видео не загружено. Пожалуйста, повторите попытку.",
            "41" => "Ошибка! Настройки видео не сохранены. Пожалуйста, повторите попытку.",
            "42" => "Видео заблокировано.",
            "43" => "Ошибка! Видео не заблокировано. Пожалуйста, повторите попытку.",
            "44" => "Видео разблокировано.",
            "45" => "Ошибка! Видео не разблокировано. Пожалуйста, повторите попытку.",
            "46" => "На указанный Вами E-mail отправлено письмо с указаниями по смене пароля.",
            "47" => "Ошибка! Пользователь с таким E-mail не найден.",
            "48" => "Ошибка! Пароль не обновлен. Пожалуйста, повторите попытку.",
            "49" => "Ошибка! Сообщение не разблокировано. Пожалуйста, повторите попытку.",
            "50" => "Ошибка! Сообщение не заблокировано. Пожалуйста, повторите попытку.",
            "51" => "Ошибка! Сообщение не отправлено.",
            "52" => "Сообщение отправлено. Копия сообщения отправлена Вам на почту.",
            "53" => "Ошибка! Проверьте корректность E-mail пользователя.",
            "54" => "Сообщение отправлено. Копия диалога отправлена пользователю на почту.",
            "55" => "Курс добавлен в Ваш календарь.",
            "56" => "Ошибка! Курс не добавлен в Ваш календарь. Пожалуйста, повторите попытку.",
            "57" => "Ошибка! Выберите тренировочные дни.",
            "58" => "Ошибка! Статья не сохранена. Пожалуйста, повторите попытку.",
            "59" => "Ошибка! Интервью не сохранено. Пожалуйста, повторите попытку.",
            "60" => "Ошибка! Новость не сохранена. Пожалуйста, повторите попытку.",
            "61" => "Ошибка! Пожалуйста, проверьте корректность введенных данных в обязательных полях.",
            "62" => "Ошибка! Введите наименование категории.",
            "63" => "Ошибка! Категория не сохранена. Пожалуйста, повторите попытку.",
            "64" => "Ошибка! Категория не заблокирована. Пожалуйста, повторите попытку.",
            "65" => "Ошибка! Категория не разблокирована. Пожалуйста, повторите попытку.",
            "66" => "Ошибка! Товар не сохранен. Не все поля заполнены корректно.",
            "67" => "Ошибка! Товар не сохранен. Пожалуйста, повторите попытку.",
            "68" => "Ошибка! Товар не заблокирован. Пожалуйста, повторите попытку.",
            "69" => "Ошибка! Товар не разблокирован. Пожалуйста, повторите попытку.",
            "70" => "Ошибка! Изображение товара не сохранено. Пожалуйста, повторите попытку.",
            "71" => "Ошибка! Товар не добавлен в корзину. Пожалуйста, повторите попытку.",
            "72" => "Ошибка! Не все товары корзины удалось обновить. Пожалуйста, повторите попытку.",
            "73" => "Ошибка! Данные курса не сохранены. Пожалуйста, повторите попытку.",
            "74" => "Вы подписаны на новости.",
            "75" => "Ошибка! Не удалось добавить E-mail в подписчики. Пожалуйста, повторите попытку.",
            "76" => "Ошибка! Проверьте корректность введенных E-mail и имени.",
            "77" => "Вы уже подписаны на новости.",
            "78" => "",
            "79" => "Ошибка! Тренировочные дни не сохранены. Пожалуйста, повторите попытку.",
            "80" => "Ошибка! Курс не заморожен. Пожалуйста, повторите попытку.",
            "81" => "Ошибка! Тренировочные дни не изменены. Курс не заморожен. Пожалуйста, повторите попытку.",
            "82" => "Категория пользователя изменена с \"Пользователь\" на \"Администратор\".",
            "83" => "Категория пользователя изменена с \"Пользователь\" на \"Тренер\".",
            "84" => "Категория пользователя изменена с \"Администратор\" на \"Пользователь\".",
            "85" => "Категория пользователя изменена с \"Тренер\" на \"Пользователь\".",
            "86" => "Ошибка! Категория пользователя не изменена. Пожалуйста, повторите попытку.",
            "87" => "Изменения в портфолио сохранены.",
            "88" => "Ошибка! Не удалось измененить изображение портфолио. Пожалуйста, повторите попытку.",
            "89" => "Ошибка! Данные портфолио не сохранены. Пожалуйста, повторите попытку.",
            "90" => "Ошибка! Изображение и данные портфолио не сохранены. Пожалуйста, повторите попытку.",
            "91" => "Запись удалена из портфолио.",
            "92" => "Ошибка! Запись из портфолио не удалена. Пожалуйста, повторите попытку.",
            "93" => "Запись добавлена в портфолио.",
            "94" => "Ошибка! Запись из портфолио не добавлена. Пожалуйста, повторите попытку.",
            "95" => "Ошибка! Пол и дата рождения не сохранены. Пожалуйста, повторите попытку.",
            "96" => "Ошибка! Фото профиля не удалено. Пожалуйста, повторите попытку.",
            "97" => "Комментарий отправлен. В ближайшее время он пройдет проверку модератором.",
            "98" => "Ошибка! Комментарий не отправлен. Пожалуйста, повторите попытку.",
            "99" => "Ошибка! Landing page курса не активирован. Пожалуйста, повторите попытку.",
            "100" => "Ошибка! Landing page курса не деактивирован. Пожалуйста, повторите попытку.",
            "101" => "Ошибка! Заказ не оформлен. Пожалуйста, повторите попытку.",
            "102" => "Ошибка! Не удалось получить доступ к Вашим данным из социальной сети. Пожалуйста, повторите попытку.",
            "103" => "Ошибка! Отказано в доступе.",
            "104" => "Видео удалено.",
            "105" => "Ошибка! Видео не удалено. Пожалуйста, повторите попытку.",
            "106" => "Ошибка! Курс не удален. Курс куплен пользователем.",
            "107" => "Ошибка! Курс не удален. Пожалуйста, повторите попытку.",
            "108" => "Курс удален.",
            "109" => "Курс куплен.",
            "110" => "Ошибка! Курс не куплен. Пожалуйста, повторите попытку.",
            "111" => "Ошибка! Информация о сайте не сохранена. Пожалуйста, повторите попытку.",
            "112" => "Ошибка! Изменения Landing page курса не сохранены. Пожалуйста, повторите попытку.",
            "113" => "Запись добавлена в блог.",
            "114" => "Ошибка! Запись не была добавлен в блог. Пожалуйста, повторите попытку.",
            "115" => "Ошибка! Не корректные данные пользователя. Пожалуйста, повторите попытку.",
            "116" => "Ошибка! Баннер не сохранен. Пожалуйста, повторите попытку.",
            "117" => "Ошибка! Файл баннера не сохранен. Пожалуйста, повторите попытку.",
            "118" => "Ошибка! Баннер не заблокирован. Пожалуйста, повторите попытку.",
            "119" => "Ошибка! Баннер не разблокирован. Пожалуйста, повторите попытку.",
            "120" => "Ошибка! Баннер не удален. Пожалуйста, повторите попытку.",
            "121" => "Ошибка! Отзыв не сохранен. Пожалуйста, повторите попытку.",
            "122" => "Ошибка! Отзыв не сохранен. Пожалуйста, проверьте правильность ввода текста.",
            "123" => "Ошибка! Отзыв не удален. Пожалуйста, повторите попытку.",
            "124" => "Ошибка! Отзыв не одобрен. Пожалуйста, повторите попытку.",
            "125" => "Ошибка! Отзыв не отклонён. Пожалуйста, повторите попытку.",
            "126" => "Ошибка! Запись блога не удалена. Пожалуйста, повторите попытку.",
            "127" => "Ошибка! Запись блога не сохранена. Пожалуйста, повторите попытку.",
            "128" => "Ошибка! Вы не подтвердили согласие на обработку персональных данных.",
            "129" => "Ошибка! Изменения настроек соц. сетей не сохранены. Пожалуйста, повторите попытку.",
            "130" => "Ошибка! Не все данные курса сохранены.",
            "131" => "Сообщение отправлено.",
            "132" => "Ошибка! Пароли не совпадают. Пожалуйста, повторите попытку.",
            "133" => "Пароль успешно обновлен.",
            "134" => "Ошибка! Информация блока не сохранена. Пожалуйста, повторите попытку.",
            "135" => "Сообщение отправлено. Ожидайте ответа от администрации сайта.",
			"136" => "Ошибка! Пользователь не найден.",
			"137" => "Ошибка! Уведомление не изменено. Пожалуйста, повторите попытку.",
			"138" => "Ошибка! Данные email адреса не сохранены. Пожалуйста, повторите попытку.",
			"139" => "Ошибка! Данные email не сохранены. Пожалуйста, повторите попытку.",
			"140" => "Ошибка! Не удалось удалить email из подписчиков. Пожалуйста, повторите попытку.",
			"141" => "Email удален из подписчиков.",
			"142" => "Оплата заказа не прошла. До [date_attempts] будут выполняться повторные попытки оплаты. Курс заморожен.",
			"143" => "Курс заканчивается менее, чем через неделю.",
			"144" => "Оплата заказа не прошла. До [date_attempts] у Вас есть возможность купить курс по остаточной стоимости единым платежом на странице настроек курса. Курс заморожен.",
			"145" => "Ошибка! Не удалось сохранить данные промокода. Пожалуйста, повторите попытку.",
			"146" => "Ошибка! Некорректные данные скидки или промокода. Пожалуйста, повторите попытку.",
			"147" => "Промокод заблокирован.",
			"148" => "Промокод разблокирован.",
			"149" => "Ошибка! Не удалось сохранить данные курса продления. Пожалуйста, повторите попытку.",
			"150" => "Ошибка! Некорректные данные курса, промокода или кол-ва недель. Пожалуйста, повторите попытку.",
			"151" => "Курс продления заблокирован.",
			"152" => "Курс продления разблокирован.",
			"153" => "Последний раз Вы вводили параметры тела более двух недель назад.",
			"154" => "Курс завершен."
		);

        foreach($list_errors as $key => $error)
        {
            $this->db->query('INSERT INTO `notifications` (`n_id`, `n_name`, `n_text`, `n_admin_id`, `n_date`) VALUES (?, ?, ?, ?, ?)',
                array($key, $error, $error, 4, $date));
        }*/


        // 20.04.2018
        /*$this->db->query('CREATE TABLE `emails_addresses` (
            `ea_id` TINYINT UNSIGNED NOT NULL AUTO_INCREMENT ,
            `ea_name` VARCHAR(255) NOT NULL ,
            `ea_email` VARCHAR(255) NOT NULL ,
            `ea_default` TINYINT(1) NOT NULL ,
            `ea_admin_id` INT NOT NULL ,
            `ea_date` DATETIME NOT NULL ,
            PRIMARY KEY (`ea_id`)) ENGINE = MyISAM');

        $this->db->query('CREATE TABLE `emails` (
            `e_id` SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT ,
            `e_name` VARCHAR(255) NOT NULL ,
            `e_ea_id` TINYINT UNSIGNED NOT NULL ,
            `e_subject` VARCHAR(255) NOT NULL ,
            `e_text` VARCHAR (2000) NOT NULL ,
            `e_images` VARCHAR (500) NOT NULL ,
            `e_admin_id` INT UNSIGNED NOT NULL ,
            `e_date` DATETIME NOT NULL ,
            PRIMARY KEY (`e_id`)) ENGINE = MyISAM');

        $this->db->query("INSERT INTO `emails` (`e_name`, `e_ea_id`, `e_subject`, `e_text`, `e_images`, `e_admin_id`, `e_date`) VALUES ('Регистрация', '1', 'Подтверждение регистрации на сайте SuperBody', 'Для подтверждения регистрации на сайте перейдите по ссылке', '', '4', '2018-04-20 12:25:21')");*/


        // 26.04.2018
        /*$this->db->query("ALTER TABLE `users_courses` ADD `uc_blocked_date` DATETIME NOT NULL AFTER `uc_blocked`,
            ADD `uc_blocked_reason` ENUM('','payment_canceled','payment_refunded','payment_succeeded') NOT NULL AFTER `uc_blocked_date`");
        $this->db->query("ALTER TABLE `users_courses` ADD `uc_o_id` INT UNSIGNED NOT NULL AFTER `uc_user_id`");*/


        // 01.05.2018
        /*$this->db->query("CREATE TABLE `promocodes` (
            `pc_id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
            `pc_crs_id` INT UNSIGNED NOT NULL ,
            `pc_name` VARCHAR(255) NOT NULL ,
            `pc_description` VARCHAR(255) NOT NULL ,
            `pc_discount` INT NOT NULL ,
            `pc_period_validity_type` ENUM('unlimited','date_range') NOT NULL ,
            `pc_pv_date_start` DATE NOT NULL ,
            `pc_pv_date_end` DATE NOT NULL ,
            `pc_use_amount_type` ENUM('unlimited','number') NOT NULL ,
            `pc_ua_number` SMALLINT UNSIGNED NOT NULL ,
            `pc_code` VARCHAR(25) NOT NULL ,
            `pc_blocked` INT NOT NULL ,
            `pc_admin_id` INT NOT NULL ,
            `pc_date_add` DATETIME NOT NULL ,
            `pc_update` DATETIME NOT NULL ,
            PRIMARY KEY (`pc_id`), INDEX `ix_pc_crs_id` (`pc_crs_id`)) ENGINE = MyISAM;");

        $this->db->query("CREATE TABLE `promocodes_used` (
            `pcu_id` INT UNSIGNED NOT NULL ,
            `pcu_pc_id` INT UNSIGNED NOT NULL ,
            `pcu_date` DATETIME NOT NULL ,
            PRIMARY KEY (`pcu_id`), INDEX `ix_pcu_pc_id` (`pcu_pc_id`)) ENGINE = MyISAM;");*/

        // 03.05.2018
        /*$this->db->query("CREATE TABLE `courses_extends` (
            `ce_id` INT UNSIGNED NOT NULL AUTO_INCREMENT , 
            `ce_crs_id` INT UNSIGNED NOT NULL , 
            `ce_extend_crs_id` INT UNSIGNED NOT NULL , 
            `ce_pc_id` INT UNSIGNED NOT NULL , 
            `ce_weeks_after` TINYINT UNSIGNED NOT NULL , 
            `ce_blocked` TINYINT(1) NOT NULL , 
            `ce_admin_id` INT UNSIGNED NOT NULL , 
            `ce_date_add` DATETIME NOT NULL , 
            `ce_update` DATETIME NOT NULL , 
            PRIMARY KEY (`ce_id`), 
            INDEX `ix_ce_crs_id` (`ce_crs_id`),
            INDEX `ix_ce_extend_crs_id` (`ce_crs_id`, `ce_extend_crs_id`)) ENGINE = MyISAM");*/


        // 04.05.2018
        /*$this->db->query("UPDATE `categories` SET `cat_id` = '5' WHERE `categories`.`cat_id` = 4");
        $this->db->query("UPDATE `categories` SET `cat_id` = '4' WHERE `categories`.`cat_id` = 3");
        $this->db->query("UPDATE `categories` SET `cat_id` = '3' WHERE `categories`.`cat_id` = 2");
        $this->db->query("INSERT INTO `categories` (`cat_id`, `cat_name`, `cat_description`, `cat_blocked`, `cat_date_add`, `cat_date_update`, `cat_admin_id`) VALUES ('2', 'Курсы питания', 'Вы знаете, что тренироваться нужно регулярно, но сбалансировать свое расписание бывает трудно.', '0', '2018-04-12 10:47:22', '2018-04-25 08:17:52', '4');");
        $this->db->query("UPDATE `products_categories` SET `pc_cat_id` = '5' WHERE `pc_cat_id` = 4");
        $this->db->query("UPDATE `products_categories` SET `pc_cat_id` = '4' WHERE `pc_cat_id` = 3");
        $this->db->query("UPDATE `products_categories` SET `pc_cat_id` = '3' WHERE `pc_cat_id` = 2");
        $this->db->query("ALTER TABLE `users_courses` ADD `uc_ends_email` TINYINT(1) UNSIGNED NOT NULL AFTER `uc_pause_days`");*/

        // 08.05.2018
        /*$this->db->query("ALTER TABLE `promocodes` ADD `pc_category` ENUM('course','extend') NOT NULL DEFAULT 'course' AFTER `pc_crs_id`");
        $this->db->query("ALTER TABLE `promocodes_used` ADD `pcu_code` VARCHAR(25) NOT NULL AFTER `pcu_pc_id`");
        $this->db->query("ALTER TABLE `orders_users_cart` ADD `ouc_promocode_id` INT UNSIGNED NOT NULL AFTER `ouc_p_fitcoin_price`");

        $this->db->query("INSERT INTO `emails` (`e_name`, `e_ea_id`, `e_subject`, `e_text`, `e_images`, `e_admin_id`, `e_date`) VALUES ('Изменена категория пользователя на Администратор', '1', 'Ваш тип пользователя изменен', 'Ваш тип пользователя на сайте SuperBody изменен на Администратор.', '', '4', '2018-04-25 11:41:46')");
        $this->db->query("INSERT INTO `emails` (`e_name`, `e_ea_id`, `e_subject`, `e_text`, `e_images`, `e_admin_id`, `e_date`) VALUES ('Изменена категория пользователя на Пользователь', '1', 'Ваш тип пользователя изменен', 'Ваш тип пользователя на сайте SuperBody изменен на Пользователь.', '', '4', '2018-04-25 11:41:46')");
        $this->db->query("INSERT INTO `emails` (`e_name`, `e_ea_id`, `e_subject`, `e_text`, `e_images`, `e_admin_id`, `e_date`) VALUES ('Восставновление пароля', '1', 'Восставновление пароля на сайте SuperBody', 'Для ввода нового пароля перейдите по ссылке ниже.', '', '4', '2018-04-25 11:41:46')");
        $this->db->query("INSERT INTO `emails` (`e_name`, `e_ea_id`, `e_subject`, `e_text`, `e_images`, `e_admin_id`, `e_date`) VALUES ('Соц. регистрация', '1', 'Регистрация на сайте SuperBody', 'Вы зарегистрированны на сайте SuperBody.pro', '', '4', '2018-04-25 11:41:46')");
        $this->db->query("INSERT INTO `emails` (`e_name`, `e_ea_id`, `e_subject`, `e_text`, `e_images`, `e_admin_id`, `e_date`) VALUES ('Изменена категория пользователя на Тренер', '1', 'Ваш тип пользователя изменен', 'Ваш тип пользователя на сайте SuperBody изменен на Тренер.', '', '4', '2018-04-25 11:41:46')");
        $this->db->query("INSERT INTO `emails` (`e_name`, `e_ea_id`, `e_subject`, `e_text`, `e_images`, `e_admin_id`, `e_date`) VALUES ('Обратная связь', '1', 'Обратная связь SuperBody', '', '', '4', '2018-04-25 11:41:46')");
        $this->db->query("INSERT INTO `emails` (`e_name`, `e_ea_id`, `e_subject`, `e_text`, `e_images`, `e_admin_id`, `e_date`) VALUES ('Уведомление от обратной связи', '1', 'Пришел ответ от администрации сайта на Ваше сообщение в разделе \"Обратная связь\"', '', '', '4', '2018-04-25 11:41:46')");
        $this->db->query("INSERT INTO `emails` (`e_name`, `e_ea_id`, `e_subject`, `e_text`, `e_images`, `e_admin_id`, `e_date`) VALUES ('Изменение персональных данных', '1', 'Изменение персональных данных на сайте SuperBody', '', '', '4', '2018-04-25 11:41:46')");
        $this->db->query("INSERT INTO `emails` (`e_name`, `e_ea_id`, `e_subject`, `e_text`, `e_images`, `e_admin_id`, `e_date`) VALUES ('Уведомление 2 от обратной связи', '1', 'Сообщение отправлено. Ожидайте ответа от администрации сайта.', '', '', '4', '2018-04-25 11:41:46')");
        $this->db->query("INSERT INTO `emails` (`e_name`, `e_ea_id`, `e_subject`, `e_text`, `e_images`, `e_admin_id`, `e_date`) VALUES ('Курс заканчивается', '1', 'Курс заканчивается меньше, чем через неделю', '', '', '4', '2018-04-25 11:41:46')");*/
    }
}