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
        
        if ($sel_email !== false and 0 == $sel_email->num_rows()) {
            $ins_email = $this->db->query('
                INSERT INTO `subscription` (`s_email`, `s_name`, `s_date`)
                VALUES (?, ?, ?)', array($email, $name, $date));

            if ($ins_email !== false and 1 == $this->db->affected_rows()) {
                return true;
            }
            elseif ($ins_email === false) {
                parent::logDbMessages(__METHOD__);
                return false;
            }
            else {
                return 2;
            }
        }
        elseif ($sel_email === false) {
            parent::logDbMessages(__METHOD__);
            return false;
        }
        else {
            return 3;
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
              `si_about`, `si_contacts_text1`, `si_contacts_text2`
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
    }
}