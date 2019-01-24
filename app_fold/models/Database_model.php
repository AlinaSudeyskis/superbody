<?php

/**
 * Created by Alina Sudeyskis (alina.sudeyskis@gmail.com).
 * Date: 04.07.2018 9:35
 */
class Database_model extends CI_Model
{
    /**
     * Обновление БД
     *
     * @param $date
     * @return bool
     */
    public function updateDatabase($date)
    {
        $result = false;

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
			"154" => "Курс завершен.",
			"154" => "Курс завершен.",
			"154" => "Курс завершен.",
			"154" => "Курс завершен.",
			"154" => "Курс завершен.",
			"154" => "Курс завершен.",
			"154" => "Курс завершен.",
			"154" => "Курс завершен.",
			"154" => "Курс завершен.",
			"154" => "Курс завершен.",
			"154" => "Курс завершен.",
			"154" => "Курс завершен.",
			"154" => "Курс завершен.",
			"154" => "Курс завершен.",
			"154" => "Курс завершен.",
			"154" => "Курс завершен.",
			"154" => "Курс завершен.",
			"154" => "Курс завершен.",
			"154" => "Курс завершен.",
			"154" => "Курс завершен.",
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
            PRIMARY KEY (`e_id`)) ENGINE = MyISAM');*/


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
        $this->db->query("ALTER TABLE `orders_users_cart` ADD `ouc_promocode_id` INT UNSIGNED NOT NULL AFTER `ouc_p_fitcoin_price`");*/


        // ------------------------------------------------------------------------------------------------------------

        // 14.05.2018
        /*$this->db->query("ALTER TABLE `promocodes_used` ADD `pcu_o_id` INT UNSIGNED NOT NULL AFTER `pcu_code`,
            ADD `pcu_p_id` INT UNSIGNED NOT NULL AFTER `pcu_o_id`,
            ADD `pcu_u_id` INT UNSIGNED NOT NULL AFTER `pcu_p_id`");*/

        // 15.05.2018
        /*$this->db->query("ALTER TABLE `courses` ADD `crs_category` ENUM('workout','nutrition') NOT NULL AFTER `crs_id`, ADD INDEX `ix_crs_category` (`crs_category`)");
        $this->db->query("UPDATE `courses` SET `crs_category`='workout'");
        $this->db->query("ALTER TABLE `ingestions` DROP `ing_type_id`");
        $this->db->query("ALTER TABLE `ingestions` CHANGE `time_additives` `ing_time_to` TIME NOT NULL");
        $this->db->query("ALTER TABLE `ingestions` CHANGE `ing_approval` `ing_blocked` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0'");
        $this->db->query("ALTER TABLE `ingestions` ADD `ing_admin_id` INT UNSIGNED NOT NULL AFTER `ing_blocked`");
        $this->db->query("INSERT INTO `notifications` (`n_name`, `n_text`, `n_admin_id`, `n_date`) VALUES ('Ошибка! Прием пищи не заблокирован. Пожалуйста, повторите попытку.', 'Ошибка! Прием пищи не заблокирован. Пожалуйста, повторите попытку.', '4', '2018-04-19 14:23:42')");
        $this->db->query("INSERT INTO `notifications` (`n_name`, `n_text`, `n_admin_id`, `n_date`) VALUES ('Ошибка! Прием пищи не разблокирован. Пожалуйста, повторите попытку.', 'Ошибка! Прием пищи не разблокирован. Пожалуйста, повторите попытку.', '4', '2018-04-19 14:23:42')");
        $this->db->query("INSERT INTO `notifications` (`n_name`, `n_text`, `n_admin_id`, `n_date`) VALUES ('Ошибка! Данные типа блюда не сохранены. Пожалуйста, повторите попытку.', 'Ошибка! Данные типа блюда не сохранены. Пожалуйста, повторите попытку.', '4', '2018-04-19 14:23:42')");
        $this->db->query("INSERT INTO `notifications` (`n_name`, `n_text`, `n_admin_id`, `n_date`) VALUES ('Ошибка! Данные блюда не сохранены. Пожалуйста, повторите попытку.', 'Ошибка! Данные блюда не сохранены. Пожалуйста, повторите попытку.', '4', '2018-04-19 14:23:42')");

        $this->db->query("CREATE TABLE `meals` (
            `ml_id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
            `ml_mt_id` TINYINT UNSIGNED NOT NULL ,
            `ml_name` VARCHAR(255) NOT NULL,
            `ml_images` VARCHAR(255) NOT NULL ,
            `ml_weight` SMALLINT UNSIGNED NOT NULL,
            `ml_proteins` SMALLINT UNSIGNED NOT NULL ,
            `ml_fats` SMALLINT UNSIGNED NOT NULL ,
            `ml_carbohydrates` SMALLINT UNSIGNED NOT NULL ,
            `ml_calories` SMALLINT UNSIGNED NOT NULL ,
            `ml_blocked` TINYINT(1) UNSIGNED NOT NULL ,
            `ml_admin_id` INT UNSIGNED NOT NULL ,
            `ml_update` DATETIME NOT NULL ,
            PRIMARY KEY (`ml_id`)) ENGINE = MyISAM");

        $this->db->query("CREATE TABLE `meals_types` (
            `mt_id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
            `mt_name` VARCHAR(255) NOT NULL ,
            `mt_blocked` TINYINT(1) UNSIGNED NOT NULL ,
            `mt_admin_id` INT UNSIGNED NOT NULL ,
            `mt_update` DATETIME NOT NULL ,
            PRIMARY KEY (`mt_id`)) ENGINE = MyISAM");*/


        // 16.05.2018
        /*$this->db->query("CREATE TABLE `ingredients` (
            `ingr_id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
            `ingr_ml_id` INT UNSIGNED NOT NULL ,
            `ingr_name` VARCHAR(255) NOT NULL ,
            `ingr_weight` SMALLINT UNSIGNED NOT NULL ,
            `ingr_proteins` SMALLINT UNSIGNED NOT NULL ,
            `ingr_fats` SMALLINT UNSIGNED NOT NULL ,
            `ingr_carbohydrates` SMALLINT UNSIGNED NOT NULL ,
            `ingr_calories` SMALLINT UNSIGNED NOT NULL ,
            `ingr_admin_id` INT UNSIGNED NOT NULL ,
            `ingr_update` DATETIME NOT NULL ,
            PRIMARY KEY (`ingr_id`), INDEX `ix_ingr_ml_id` (`ingr_ml_id`)) ENGINE = MyISAM");*/

        // 18.05.2018
        /*$this->db->query("ALTER TABLE `meals` ADD FULLTEXT `fix_ml_name` (`ml_name`)");
        $this->db->query("ALTER TABLE `meals` CHANGE `ml_name` `ml_name` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL");

        $this->db->query("CREATE TABLE `courses_ingestions` (
            `ci_id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
            `ci_crs_id` INT UNSIGNED NOT NULL ,
            `ci_ing_id` SMALLINT UNSIGNED NOT NULL ,
            `ci_ing_time_from` TIME NOT NULL ,
            `ci_ing_time_to` TIME NOT NULL ,
            `ci_admin_id` INT UNSIGNED NOT NULL ,
            `ci_update` DATETIME NOT NULL ,
            PRIMARY KEY (`ci_id`), INDEX `ic_ci_crs_id` (`ci_crs_id`)) ENGINE = MyISAM");

        $this->db->query("CREATE TABLE `courses_days_schedule` (
            `cds_id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
            `cds_crs_id` INT UNSIGNED NOT NULL ,
            `cds_day` SMALLINT UNSIGNED NOT NULL ,
            `cds_ci_id` INT UNSIGNED NOT NULL ,
            `cds_ml_id` INT UNSIGNED NOT NULL ,
            `cds_admin_id` INT UNSIGNED NOT NULL ,
            `cds_update` DATETIME NOT NULL ,
            PRIMARY KEY (`cds_id`), INDEX `ix_cds_crs_id` (`cds_crs_id`)) ENGINE = MyISAM");*/

        // 21.05.2018
        /*$this->db->query("CREATE TABLE `users_nutritions` (
            `un_id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
            `un_u_id` INT UNSIGNED NOT NULL ,
            `un_uc_id` INT UNSIGNED NOT NULL ,
            `un_cds_day` INT UNSIGNED NOT NULL ,
            `un_cds_ci_id` INT UNSIGNED NOT NULL ,
            `un_ml_id` INT UNSIGNED NOT NULL ,
            `un_date` DATE NOT NULL ,
            `un_update` DATETIME NOT NULL ,
            PRIMARY KEY (`un_id`), INDEX `ix_un_ucid_uid` (`un_uc_id`, `un_u_id`)) ENGINE = MyISAM");

        $this->db->query("ALTER TABLE `users_courses` CHANGE `uc_blocked_reason` `uc_blocked_reason` ENUM('','payment_refunded','payment_succeeded','payment_canceled') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL");
        */

        // 30.05.2018
        /*$this->db->query('CREATE TABLE `courses_attached` (
            `ca_id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
            `ca_crs_id` INT UNSIGNED NOT NULL ,
            `ca_attached_crs_id` INT UNSIGNED NOT NULL ,
            `ca_blocked` TINYINT(0) UNSIGNED NOT NULL ,
            `ca_admin_id` INT UNSIGNED NOT NULL ,
            `ca_date` DATETIME NOT NULL ,
            PRIMARY KEY (`ca_id`), INDEX `ix_ca_crs_id` (`ca_crs_id`)) ENGINE = MyISAM');

        $this->db->query('ALTER TABLE `users_courses` ADD `uc_attached_uc_id` INT UNSIGNED NOT NULL AFTER `uc_course_id`');
        */

        // 01.06.2018
        /*$this->db->query("ALTER TABLE `meals` ADD `ml_description` VARCHAR(2000) NOT NULL AFTER `ml_name`, ADD `ml_videos` TEXT NOT NULL AFTER `ml_description`");*/

        // 05.06.2018
        /*$this->db->query("CREATE TABLE `meals_videos` (
            `mv_id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
            `mv_ml_id` INT UNSIGNED NOT NULL ,
            `mv_video` VARCHAR(2000) NOT NULL ,
            `mv_admin_id` INT UNSIGNED NOT NULL ,
            `mv_update` DATETIME NOT NULL ,
            PRIMARY KEY (`mv_id`), INDEX `ix_mv_ml_id` (`mv_ml_id`)) ENGINE = MyISAM");

        $this->db->query("ALTER TABLE `meals` DROP `ml_videos`");
        $this->db->query("ALTER TABLE `meals` ADD `ml_ingredients` VARCHAR(2000) NOT NULL AFTER `ml_description`");
        */

        // 12.06.2018
        //$this->db->query("UPDATE `notifications` SET `n_name` = 'Ошибка! Категория курса не сохранена. Пожалуйста, повторите попытку.', `n_text` = 'Ошибка! Категория курса не сохранена. Пожалуйста, повторите попытку.' WHERE `notifications`.`n_id` = 25");

        // 13.06.2018
        /*$this->db->query("ALTER TABLE `meals` CHANGE `ml_weight` `ml_weight` DECIMAL(6,2) UNSIGNED NOT NULL,
            CHANGE `ml_proteins` `ml_proteins` DECIMAL(6,2) UNSIGNED NOT NULL,
            CHANGE `ml_fats` `ml_fats` DECIMAL(6,2) UNSIGNED NOT NULL,
            CHANGE `ml_carbohydrates` `ml_carbohydrates` DECIMAL(6,2) UNSIGNED NOT NULL,
            CHANGE `ml_calories` `ml_calories` DECIMAL(6,2) UNSIGNED NOT NULL");
        */

        // -------------------------------------------------------------------------------------------------------------

        // 25.06.2018
        //$this->db->query("ALTER TABLE `meals` ADD `ml_image` VARCHAR(255) NOT NULL AFTER `ml_images`");

        // 26.06.2018
        //$this->db->query("ALTER TABLE `users_courses` ADD `uc_display` TINYINT(1) UNSIGNED NOT NULL AFTER `uc_blocked_reason`");

        return $result;
    }

    /**
     * Обновление базы данных июль 2018
     *
     * @param $date
     * @return bool
     */
    public function updateDatabaseJuly2018($date)
    {
        $result = false;

        // -------------------------------------------------------------------------------------------------------------

        // 04.07.2018
        /*$this->db->query('DELETE FROM `emails`');
        $this->db->query('ALTER TABLE `emails` AUTO_INCREMENT=0');

        $this->db->query("INSERT INTO `emails` (`e_name`, `e_ea_id`, `e_subject`, `e_text`, `e_images`, `e_admin_id`, `e_date`) VALUES ('Регистрация', '1', 'Подтверждение регистрации на сайте SuperBody', 'Для подтверждения регистрации на сайте перейдите по ссылке', '', '4', '2018-04-20 12:25:21')");
        $this->db->query("INSERT INTO `emails` (`e_name`, `e_ea_id`, `e_subject`, `e_text`, `e_images`, `e_admin_id`, `e_date`) VALUES ('Соц. регистрация', '1', 'Регистрация на сайте SuperBody', 'Вы зарегистрированны на сайте SuperBody.pro', '', '4', '2018-04-25 11:41:46')");
        $this->db->query("INSERT INTO `emails` (`e_name`, `e_ea_id`, `e_subject`, `e_text`, `e_images`, `e_admin_id`, `e_date`) VALUES ('Восставновление пароля', '1', 'Восставновление пароля на сайте SuperBody', 'Для ввода нового пароля перейдите по ссылке ниже.', '', '4', '2018-04-25 11:41:46')");
        $this->db->query("INSERT INTO `emails` (`e_name`, `e_ea_id`, `e_subject`, `e_text`, `e_images`, `e_admin_id`, `e_date`) VALUES ('Изменена категория пользователя на Администратор', '1', 'Ваш тип пользователя изменен', 'Ваш тип пользователя на сайте SuperBody изменен на Администратор.', '', '4', '2018-04-25 11:41:46')");
        $this->db->query("INSERT INTO `emails` (`e_name`, `e_ea_id`, `e_subject`, `e_text`, `e_images`, `e_admin_id`, `e_date`) VALUES ('Изменена категория пользователя на Пользователь', '1', 'Ваш тип пользователя изменен', 'Ваш тип пользователя на сайте SuperBody изменен на Пользователь.', '', '4', '2018-04-25 11:41:46')");
        $this->db->query("INSERT INTO `emails` (`e_name`, `e_ea_id`, `e_subject`, `e_text`, `e_images`, `e_admin_id`, `e_date`) VALUES ('Изменена категория пользователя на Тренер', '1', 'Ваш тип пользователя изменен', 'Ваш тип пользователя на сайте SuperBody изменен на Тренер.', '', '4', '2018-04-25 11:41:46')");
        $this->db->query("INSERT INTO `emails` (`e_name`, `e_ea_id`, `e_subject`, `e_text`, `e_images`, `e_admin_id`, `e_date`) VALUES ('Обратная связь', '1', 'Обратная связь SuperBody', '', '', '4', '2018-04-25 11:41:46')");
        $this->db->query("INSERT INTO `emails` (`e_name`, `e_ea_id`, `e_subject`, `e_text`, `e_images`, `e_admin_id`, `e_date`) VALUES ('Уведомление от обратной связи', '1', 'Пришел ответ от администрации сайта на Ваше сообщение в разделе \"Обратная связь\"', '', '', '4', '2018-04-25 11:41:46')");
        $this->db->query("INSERT INTO `emails` (`e_name`, `e_ea_id`, `e_subject`, `e_text`, `e_images`, `e_admin_id`, `e_date`) VALUES ('Уведомление 2 от обратной связи', '1', 'Сообщение отправлено. Ожидайте ответа от администрации сайта.', '', '', '4', '2018-04-25 11:41:46')");
        $this->db->query("INSERT INTO `emails` (`e_name`, `e_ea_id`, `e_subject`, `e_text`, `e_images`, `e_admin_id`, `e_date`) VALUES ('Изменение персональных данных', '1', 'Изменение персональных данных на сайте SuperBody', '', '', '4', '2018-04-25 11:41:46')");
        $this->db->query("INSERT INTO `emails` (`e_name`, `e_ea_id`, `e_subject`, `e_text`, `e_images`, `e_admin_id`, `e_date`) VALUES ('Курс заканчивается', '1', 'Курс заканчивается меньше, чем через неделю', '', '', '4', '2018-04-25 11:41:46')");
        $this->db->query("INSERT INTO `emails` (`e_name`, `e_ea_id`, `e_subject`, `e_text`, `e_images`, `e_admin_id`, `e_date`) VALUES ('Меню на неделю', '1', 'Меню на неделю', '', '', '4', '2018-04-25 11:41:46')");*/

        // -------------------------------------------------------------------------------------------------------------

        // 06.07.2018
        $date = '2018-07-06 10:03:00';
        $fl_up_db = self::getDbUpdateData($date);
        if($fl_up_db === false)
        {
            $in_data = $this->db->query('CREATE TABLE `database_update` ( `db_id` INT UNSIGNED NOT NULL AUTO_INCREMENT , `db_date` DATETIME NOT NULL , PRIMARY KEY (`db_id`)) ENGINE = MyISAM;');

            $del_data = $this->db->query('DELETE FROM `notifications` WHERE `n_id`>=159');
            if($del_data === false)
            {
                parent::logDbMessages(__METHOD__.':'.__LINE__);
            }
            $up_data = $this->db->query('ALTER TABLE `notifications` AUTO_INCREMENT = 158;');
            if($up_data === false)
            {
                parent::logDbMessages(__METHOD__.':'.__LINE__);
            }
            $this->db->query("INSERT INTO `notifications` (`n_name`, `n_text`, `n_admin_id`, `n_date`) VALUES ('Ошибка! Некорректные данные курса питания или тренировки. Пожалуйста, повторите попытку.', 'Ошибка! Некорректные данные курса питания или тренировки. Пожалуйста, повторите попытку.', '4', '2018-04-19 14:23:42')");
            $this->db->query("INSERT INTO `notifications` (`n_name`, `n_text`, `n_admin_id`, `n_date`) VALUES ('Ошибка! Не удалось прикрепить курс. Пожалуйста, повторите попытку.', 'Ошибка! Не удалось прикрепить курс. Пожалуйста, повторите попытку.', '4', '2018-04-19 14:23:42')");
            $this->db->query("INSERT INTO `notifications` (`n_name`, `n_text`, `n_admin_id`, `n_date`) VALUES ('Ошибка! Прикрепленный курс не заблокирован. Пожалуйста, повторите попытку.', 'Ошибка! Прикрепленный курс не заблокирован. Пожалуйста, повторите попытку.', '4', '2018-04-19 14:23:42')");
            $this->db->query("INSERT INTO `notifications` (`n_name`, `n_text`, `n_admin_id`, `n_date`) VALUES ('Ошибка! Прикрепленный курс не разблокирован. Пожалуйста, повторите попытку.', 'Ошибка! Прикрепленный курс не разблокирован. Пожалуйста, повторите попытку.', '4', '2018-04-19 14:23:42')");

            $ins_data = $this->db->query("INSERT INTO `notifications` (`n_name`, `n_text`, `n_admin_id`, `n_date`) 
                VALUES ('Изображение портфолио тренера одобрено.', 'Изображение портфолио тренера одобрено.', '4', '2018-04-19 14:23:42'), 
                ('Изображение портфолио тренера заблокировано.', 'Изображение портфолио тренера заблокировано.', '4', '2018-04-19 14:23:42'),
                ('Ошибка! Изображение портфолио тренера не одобрено. Пожалуйста, повторите попытку.', 'Ошибка! Изображение портфолио тренера не одобрено.. Пожалуйста, повторите попытку.', '4', '2018-04-19 14:23:42'), 
                ('Ошибка! Изображение портфолио тренера не заблокировано. Пожалуйста, повторите попытку.', 'Ошибка! Изображение портфолио тренера не заблокировано. Пожалуйста, повторите попытку.', '4', '2018-04-19 14:23:42')");
            if($ins_data === false)
            {
                parent::logDbMessages(__METHOD__.':'.__LINE__);
            }
            $up_data = $this->db->query("UPDATE `notifications` SET `n_name` = 'Ошибка! Запись портфолио не добавлена. Пожалуйста, повторите попытку.', `n_text` = 'Ошибка! Запись портфолио не добавлена. Пожалуйста, повторите попытку.' WHERE `notifications`.`n_id` = 94");
            if($up_data === false)
            {
                parent::logDbMessages(__METHOD__.':'.__LINE__);
            }


            $result = true;

            self::setDbUpdate($date);
        }


        // 10.07.2018
        $date = '2018-07-10 10:03:00';
        $fl_up_db = self::getDbUpdateData($date);
        if($fl_up_db === false)
        {
            $this->db->query("ALTER TABLE `video` ADD `video_active` TINYINT(1) UNSIGNED NOT NULL AFTER `video_crs_id`");

            $result = true;

            self::setDbUpdate($date);
        }

        // 11.07.2018
        $date = '2018-07-11 10:13:00';
        $fl_up_db = self::getDbUpdateData($date);
        if($fl_up_db === false)
        {
            $this->db->query("ALTER TABLE `courses_days_schedule` DROP `cds_ml_mt_id`");

            $result = true;

            self::setDbUpdate($date);
        }

        $date = '2018-07-19 11:37:10';
        $fl_up_db = self::getDbUpdateData($date);
        if($fl_up_db === false)
        {
            $this->db->query("ALTER TABLE `site_info` ADD `si_auth_display` TINYINT(1) UNSIGNED NOT NULL AFTER `si_contacts_text2`");
            $this->db->query("ALTER TABLE `site_info` ADD `si_spec_display` TINYINT(1) UNSIGNED NOT NULL AFTER `si_auth_url_name2`, 
                ADD `si_spec_name` VARCHAR(18) NOT NULL AFTER `si_spec_display`, 
                ADD `si_spec_title` VARCHAR(24) NOT NULL AFTER `si_spec_name`, 
                ADD `si_spec_text` VARCHAR(100) NOT NULL AFTER `si_spec_title`, 
                ADD `si_spec_url` VARCHAR(255) NOT NULL AFTER `si_spec_text`, 
                ADD `si_spec_url_text` VARCHAR(7) NOT NULL AFTER `si_spec_url`");
            $this->db->query("ALTER TABLE `users` ADD `user_soc_image` VARCHAR(255) NOT NULL AFTER `user_image`");

            $result = true;

            self::setDbUpdate($date);
        }

        $date = '2018-07-30 11:32:10';
        $fl_up_db = self::getDbUpdateData($date);
        if($fl_up_db === false)
        {
            $this->db->query("ALTER TABLE `meals` CHANGE `ml_weight` `ml_weight` DECIMAL(6,2) UNSIGNED NOT NULL,
            CHANGE `ml_proteins` `ml_proteins` DECIMAL(6,2) UNSIGNED NOT NULL,
            CHANGE `ml_fats` `ml_fats` DECIMAL(6,2) UNSIGNED NOT NULL,
            CHANGE `ml_carbohydrates` `ml_carbohydrates` DECIMAL(6,2) UNSIGNED NOT NULL,
            CHANGE `ml_calories` `ml_calories` DECIMAL(6,2) UNSIGNED NOT NULL");
            $result .= $this->db->last_query() . '<br/>';

            $this->db->query("ALTER TABLE `meals` ADD `ml_description` VARCHAR(2000) NOT NULL AFTER `ml_name`, ADD `ml_videos` TEXT NOT NULL AFTER `ml_description`");
            $result .= $this->db->last_query() . '<br/>';

            $this->db->query("ALTER TABLE `meals` ADD FULLTEXT `fix_ml_name` (`ml_name`)");
            $result .= $this->db->last_query() . '<br/>';

            $this->db->query("ALTER TABLE `meals` CHANGE `ml_name` `ml_name` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL");
            $result .= $this->db->last_query() . '<br/>';

            self::setDbUpdate($date);
        }

        $date = '2018-07-30 12:32:10';
        $fl_up_db = self::getDbUpdateData($date);
        if($fl_up_db === false)
        {
            $this->db->query("INSERT INTO `notifications` (`n_id`, `n_name`, `n_text`, `n_admin_id`, `n_date`) VALUES (167, 'Ошибка! Файл Excel не прошел проверку. Пожалуйста, повторите попытку.', 'Ошибка! Файл Excel не прошел проверку. Пожалуйста, повторите попытку.', '4', '2018-04-19 14:23:42')");
            $result .= $this->db->last_query() . '<br/>';
            $this->db->query("INSERT INTO `notifications` (`n_id`, `n_name`, `n_text`, `n_admin_id`, `n_date`) VALUES (168, 'Все или часть данных из файла Excel не были сохранены.', 'Все или часть данных из файла Excel не были сохранены.', '4', '2018-04-19 14:23:42')");
            $result .= $this->db->last_query() . '<br/>';
            $this->db->query("INSERT INTO `notifications` (`n_id`, `n_name`, `n_text`, `n_admin_id`, `n_date`) VALUES (169, 'Ошибка! Не удалось считать данные из файла Excel. Пожалуйста, повторите попытку.', 'Ошибка! Не удалось считать данные из файла Excel. Пожалуйста, повторите попытку.', '4', '2018-04-19 14:23:42')");
            $result .= $this->db->last_query() . '<br/>';
            $this->db->query("INSERT INTO `notifications` (`n_id`, `n_name`, `n_text`, `n_admin_id`, `n_date`) VALUES (170, 'Ошибка! Не удалось загрузить файл Excel. Пожалуйста, повторите попытку.', 'Ошибка! Не удалось загрузить файл Excel. Пожалуйста, повторите попытку.', '4', '2018-04-19 14:23:42')");
            $result .= $this->db->last_query() . '<br/>';

            self::setDbUpdate($date);
        }

        $date = '2018-07-30 12:42:10';
        $fl_up_db = self::getDbUpdateData($date);
        if($fl_up_db === false)
        {
            $this->db->query("ALTER TABLE `meals` ADD `ml_ingredients` VARCHAR(2000) NOT NULL AFTER `ml_description`");
            $result .= $this->db->last_query() . '<br/>';

            self::setDbUpdate($date);
        }

        $date = '2018-07-30 13:00:10';
        $fl_up_db = self::getDbUpdateData($date);
        if($fl_up_db === false)
        {
            $this->db->query("CREATE TABLE `ingredients` (
                `ingr_id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
                `ingr_ml_id` INT UNSIGNED NOT NULL ,
                `ingr_name` VARCHAR(255) NOT NULL ,
                `ingr_weight` SMALLINT UNSIGNED NOT NULL ,
                `ingr_proteins` SMALLINT UNSIGNED NOT NULL ,
                `ingr_fats` SMALLINT UNSIGNED NOT NULL ,
                `ingr_carbohydrates` SMALLINT UNSIGNED NOT NULL ,
                `ingr_calories` SMALLINT UNSIGNED NOT NULL ,
                `ingr_admin_id` INT UNSIGNED NOT NULL ,
                `ingr_update` DATETIME NOT NULL ,
                PRIMARY KEY (`ingr_id`), INDEX `ix_ingr_ml_id` (`ingr_ml_id`)) ENGINE = MyISAM");

            $this->db->query("ALTER TABLE `meals` ADD FULLTEXT `fix_ml_name` (`ml_name`)");
            $this->db->query("ALTER TABLE `meals` CHANGE `ml_name` `ml_name` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL");

            $this->db->query("CREATE TABLE `courses_ingestions` (
                `ci_id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
                `ci_crs_id` INT UNSIGNED NOT NULL ,
                `ci_ing_id` SMALLINT UNSIGNED NOT NULL ,
                `ci_ing_time_from` TIME NOT NULL ,
                `ci_ing_time_to` TIME NOT NULL ,
                `ci_admin_id` INT UNSIGNED NOT NULL ,
                `ci_update` DATETIME NOT NULL ,
                PRIMARY KEY (`ci_id`), INDEX `ic_ci_crs_id` (`ci_crs_id`)) ENGINE = MyISAM");

            $this->db->query("CREATE TABLE `courses_days_schedule` (
                `cds_id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
                `cds_crs_id` INT UNSIGNED NOT NULL ,
                `cds_day` SMALLINT UNSIGNED NOT NULL ,
                `cds_ci_id` INT UNSIGNED NOT NULL ,
                `cds_ml_id` INT UNSIGNED NOT NULL ,
                `cds_admin_id` INT UNSIGNED NOT NULL ,
                `cds_update` DATETIME NOT NULL ,
                PRIMARY KEY (`cds_id`), INDEX `ix_cds_crs_id` (`cds_crs_id`)) ENGINE = MyISAM");

            $this->db->query("CREATE TABLE `users_nutritions` (
                `un_id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
                `un_u_id` INT UNSIGNED NOT NULL ,
                `un_uc_id` INT UNSIGNED NOT NULL ,
                `un_cds_day` INT UNSIGNED NOT NULL ,
                `un_cds_ci_id` INT UNSIGNED NOT NULL ,
                `un_ml_id` INT UNSIGNED NOT NULL ,
                `un_date` DATE NOT NULL ,
                `un_update` DATETIME NOT NULL ,
                PRIMARY KEY (`un_id`), INDEX `ix_un_ucid_uid` (`un_uc_id`, `un_u_id`)) ENGINE = MyISAM");

            $this->db->query("ALTER TABLE `users_courses` CHANGE `uc_blocked_reason` `uc_blocked_reason` ENUM('','payment_refunded','payment_succeeded','payment_canceled') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL");


            $this->db->query('CREATE TABLE `courses_attached` (
                `ca_id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
                `ca_crs_id` INT UNSIGNED NOT NULL ,
                `ca_attached_crs_id` INT UNSIGNED NOT NULL ,
                `ca_blocked` TINYINT(0) UNSIGNED NOT NULL ,
                `ca_admin_id` INT UNSIGNED NOT NULL ,
                `ca_date` DATETIME NOT NULL ,
                PRIMARY KEY (`ca_id`), INDEX `ix_ca_crs_id` (`ca_crs_id`)) ENGINE = MyISAM');

            $this->db->query('ALTER TABLE `users_courses` ADD `uc_attached_uc_id` INT UNSIGNED NOT NULL AFTER `uc_course_id`');

            $this->db->query("ALTER TABLE `meals` ADD `ml_description` VARCHAR(2000) NOT NULL AFTER `ml_name`, ADD `ml_videos` TEXT NOT NULL AFTER `ml_description`");
            $this->db->query("CREATE TABLE `meals_videos` (
                `mv_id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
                `mv_ml_id` INT UNSIGNED NOT NULL ,
                `mv_video` VARCHAR(2000) NOT NULL ,
                `mv_admin_id` INT UNSIGNED NOT NULL ,
                `mv_update` DATETIME NOT NULL ,
                PRIMARY KEY (`mv_id`), INDEX `ix_mv_ml_id` (`mv_ml_id`)) ENGINE = MyISAM");

            $this->db->query("ALTER TABLE `meals` DROP `ml_videos`");
            $this->db->query("ALTER TABLE `meals` ADD `ml_ingredients` VARCHAR(2000) NOT NULL AFTER `ml_description`");

            $this->db->query("UPDATE `notifications` SET `n_name` = 'Ошибка! Категория курса не сохранена. Пожалуйста, повторите попытку.', `n_text` = 'Ошибка! Категория курса не сохранена. Пожалуйста, повторите попытку.' WHERE `notifications`.`n_id` = 25");

            self::setDbUpdate($date);
        }

        $date = '2018-07-30 15:43:10';
        $fl_up_db = self::getDbUpdateData($date);
        if($fl_up_db === false) {
            $up_data = $this->db->query("ALTER TABLE `orders_payment` ADD `op_payment_type` VARCHAR(25) NOT NULL AFTER `op_number`");
            /*log_message('debug', print_r($up_data, true));*/

            self::setDbUpdate($date);
        }

        $date = '2018-07-30 18:05:10';
        $fl_up_db = self::getDbUpdateData($date);
        if($fl_up_db === false)
        {
            //$up_data = $this->db->query("TRUNCATE TABLE `meals`");

            self::setDbUpdate($date);
        }

        return $result;
    }

    /**
     * Обновление базы данных август 2018
     *
     * @param $date
     * @return bool
     */
    public function updateDatabaseAugust2018($date)
    {
        $result = false;

        $date = '2018-08-07 15:26:10';
        $fl_up_db = self::getDbUpdateData($date);
        if($fl_up_db === false)
        {
            $this->db->query("INSERT INTO `notifications` (`n_id`, `n_name`, `n_text`, `n_admin_id`, `n_date`) VALUES (171, 'Выберите курс питания для отображения в календаре.', 'Выберите курс питания для отображения в календаре.', '4', '2018-04-19 14:23:42')");
            $this->db->query("INSERT INTO `notifications` (`n_id`, `n_name`, `n_text`, `n_admin_id`, `n_date`) VALUES (172, 'Выберите курс тренировок для отображения в календаре.', 'Выберите курс тренировок для отображения в календаре.', '4', '2018-04-19 14:23:42')");
            $this->db->query("INSERT INTO `notifications` (`n_id`, `n_name`, `n_text`, `n_admin_id`, `n_date`) VALUES (173, 'Выберите курс тренировок и питания для отображения в календаре.', 'Выберите курс тренировок и питания для отображения в календаре.', '4', '2018-04-19 14:23:42')");

            self::setDbUpdate($date);
        }

        $date = '2018-08-24 8:26:10';
        $fl_up_db = self::getDbUpdateData($date);
        if($fl_up_db === false)
        {
            $this->db->query("CREATE TABLE `notification_tokens` ( 
                `nt_id` INT UNSIGNED NOT NULL AUTO_INCREMENT , 
                `nt_token` VARCHAR(255) NOT NULL , 
                `nt_u_id` INT UNSIGNED NOT NULL , 
                `nt_date` DATETIME NOT NULL , 
                PRIMARY KEY (`nt_id`), INDEX `ix_nt_u_id` (`nt_u_id`)) ENGINE = MyISAM;");

            self::setDbUpdate($date);
        }

        return $result;
    }

    /**
     * Обновление базы данных октябрь 2018
     *
     * @param $date
     * @return bool
     */
    public function updateDatabaseOctober2018($date)
    {
        $result = false;

        $date = '2018-10-05 13:44:45';
        $fl_up_db = self::getDbUpdateData($date);
        if($fl_up_db === false)
        {
            $this->db->query("ALTER TABLE `courses_landing_pages` CHANGE `clp_block6_advantages` `clp_block6_advantages` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL");

            self::setDbUpdate($date);
        }

        $date = '2018-10-09 12:04:14';
        $fl_up_db = self::getDbUpdateData($date);
        if($fl_up_db === false)
        {
            $this->db->query("ALTER TABLE `meals` ADD `ml_category_id` TINYINT(2) UNSIGNED NOT NULL DEFAULT '1' AFTER `ml_id`, ADD INDEX `ix_ml_category_id` (`ml_category_id`)");

            self::setDbUpdate($date);
        }

        $date = '2018-10-11 13:38:55';
        $fl_up_db = self::getDbUpdateData($date);
        if($fl_up_db === false)
        {
            $this->db->query("ALTER TABLE `ingredients` DROP `ingr_name`, DROP `ingr_proteins`, DROP `ingr_fats`, DROP `ingr_carbohydrates`, DROP `ingr_calories`");
            $this->db->query("ALTER TABLE `ingredients` ADD `ingr_attached_ml_id` INT UNSIGNED NOT NULL AFTER `ingr_ml_id`");
            $this->db->query("ALTER TABLE `ingredients` DROP INDEX `ix_ingr_ml_id`, ADD INDEX `ix_ingr_ml_id` (`ingr_ml_id`, `ingr_attached_ml_id`) USING BTREE");

            self::setDbUpdate($date);
        }

        $date = '2018-10-17 09:25:15';
        $fl_up_db = self::getDbUpdateData($date);
        if($fl_up_db === false)
        {
            $this->db->query("INSERT INTO `notifications` (`n_id`, `n_name`, `n_text`, `n_admin_id`, `n_date`) VALUES (174, 'Ошибка! Не указан Email отправителя.', 'Ошибка! Не указан Email отправителя.', '4', '2018-04-19 14:23:42')");
            $this->db->query("INSERT INTO `notifications` (`n_id`, `n_name`, `n_text`, `n_admin_id`, `n_date`) VALUES (175, 'Ошибка! Некорректный Email получателя.', 'Ошибка! Некорректный Email получателя.', '4', '2018-04-19 14:23:42')");

            self::setDbUpdate($date);
        }

        $date = '2018-10-17 10:33:38';
        $fl_up_db = self::getDbUpdateData($date);
        if($fl_up_db === false)
        {
            $this->db->query("
                UPDATE `notifications` 
                SET `n_name`='Ошибка! Email отправителя не указан или некорректен.', `n_text`='Ошибка! Email отправителя не указан или некорректен.'
                WHERE `n_id`=174 LIMIT 1");

            self::setDbUpdate($date);
        }

        return $result;
    }

    /**
     * Обновление базы данных ноябрь 2018
     *
     * @param $date
     * @return bool
     */
    public function updateDatabaseNovember2018()
    {
        $result = false;

        $date = '2018-11-09 14:57:10';
        $fl_up_db = self::getDbUpdateData($date);
        if($fl_up_db === false)
        {
            $this->db->query("
                CREATE TABLE `users_day_meals` ( 
                `udm_id` INT UNSIGNED NOT NULL AUTO_INCREMENT , 
                `udm_u_id` INT UNSIGNED NOT NULL , 
                `udm_ml_id` INT UNSIGNED NOT NULL , 
                `udm_ml_weight` DECIMAL(6,2) UNSIGNED NOT NULL , 
                `udm_datetime` DATETIME NOT NULL , 
                `udm_update` DATETIME NOT NULL , 
                PRIMARY KEY (`udm_id`), 
                INDEX `idx_udm_u_id` (`udm_u_id`), 
                INDEX `idx_udm_ml_id` (`udm_ml_id`), 
                INDEX `uidx_u_id_ml_id` (`udm_u_id`, `udm_ml_id`)) ENGINE = MyISAM");

            self::setDbUpdate($date);
        }

        $date = '2018-11-29 13:00:10';
        $fl_up_db = self::getDbUpdateData($date);
        if($fl_up_db === false)
        {
            $this->db->query("UPDATE `landing_pages` SET `lp_block6_image` = './landing/default/1/lp_img8.png' WHERE `landing_pages`.`lp_id` = 1");
			$this->db->query("UPDATE `landing_pages` SET `lp_block6_image` = './landing/default/1/lp_img8.png' WHERE `landing_pages`.`lp_id` = 2");

            self::setDbUpdate($date);
        }

        return $result;
    }

    /**
     * Обновление базы данных ноябрь 2018
     *
     * @param $date
     * @return bool
     */
    public function updateDatabaseDecember2018()
    {
        $result = false;

        $date = '2018-12-04 18:01:33';
        $fl_up_db = self::getDbUpdateData($date);
        if($fl_up_db === false)
        {
            $this->db->query("ALTER TABLE `courses_landing_pages` ADD `clp_block1_hide` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0' AFTER `clp_course_id`");
            $this->db->query("ALTER TABLE `courses_landing_pages` ADD `clp_block2_hide` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0' AFTER `clp_main_title`");
            $this->db->query("ALTER TABLE `courses_landing_pages` ADD `clp_block3_hide` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0' AFTER `clp_block2_button`");
            $this->db->query("ALTER TABLE `courses_landing_pages` ADD `clp_block4_hide` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0' AFTER `clp_block3_r_reviews`");
            $this->db->query("ALTER TABLE `courses_landing_pages` ADD `clp_block5_hide` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0' AFTER `clp_block4_button`");
            $this->db->query("ALTER TABLE `courses_landing_pages` ADD `clp_block6_hide` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0' AFTER `clp_block5_button`");
            $this->db->query("ALTER TABLE `courses_landing_pages` ADD `clp_block7_hide` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0' AFTER `clp_block6_button`");
            $this->db->query("ALTER TABLE `courses_landing_pages` ADD `clp_block8_hide` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0' AFTER `clp_block7_button`");

            self::setDbUpdate($date);
        }

        $date = '2018-12-06 12:48:33';
        $fl_up_db = self::getDbUpdateData($date);
        if($fl_up_db === false)
        {
            $this->db->query("ALTER TABLE `landing_pages` ADD `lp_block2_background_top` VARCHAR(255) NOT NULL AFTER `lp_block2_background`");
            $this->db->query("ALTER TABLE `courses_landing_pages` ADD `clp_block2_background_top` VARCHAR(255) NOT NULL DEFAULT 'default' AFTER `clp_block2_background`");
            $this->db->query("ALTER TABLE `courses_landing_pages` CHANGE `clp_slider_images` `clp_slider_images` VARCHAR(2000) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'default', 
  				CHANGE `clp_block2_background` `clp_block2_background` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'default', 
  				CHANGE `clp_block2_image` `clp_block2_image` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'default', 
  				CHANGE `clp_block3_background` `clp_block3_background` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'default', 
  				CHANGE `clp_block3_images` `clp_block3_images` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'default;default;', 
			    CHANGE `clp_block4_background` `clp_block4_background` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'default', 
			    CHANGE `clp_block4_image` `clp_block4_image` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'default', 
			    CHANGE `clp_block5_background` `clp_block5_background` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'default', 
			    CHANGE `clp_block5_images` `clp_block5_images` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'default;default;default;', 
			    CHANGE `clp_block6_background` `clp_block6_background` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'default', 
			    CHANGE `clp_block6_image` `clp_block6_image` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'default', 
			    CHANGE `clp_block7_background` `clp_block7_background` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'default', 
			    CHANGE `clp_block7_images` `clp_block7_images` VARCHAR(1000) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'default;default;default;default;', 
			    CHANGE `clp_block8_background` `clp_block8_background` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'default'");

            self::setDbUpdate($date);
        }

        $date = '2018-12-12 14:24:45';
        $fl_up_db = self::getDbUpdateData($date);
        if($fl_up_db === false)
        {
            $this->db->query("UPDATE `landing_pages` SET `lp_block2_background_top`='./landing/default/1/lp_block_bg1.png' WHERE `lp_id`=1 LIMIT 1");

            self::setDbUpdate($date);
        }

        $date = '2018-12-14 12:09:13';
        $fl_up_db = self::getDbUpdateData($date);
        if($fl_up_db === false)
        {
            $this->db->query("ALTER TABLE `courses_landing_pages` ADD `clp_block1_bg_color` VARCHAR(10) NOT NULL AFTER `clp_block1_hide`");
            $this->db->query("ALTER TABLE `courses_landing_pages` ADD `clp_block2_bg_color` VARCHAR(10) NOT NULL AFTER `clp_block2_hide`");
            $this->db->query("ALTER TABLE `courses_landing_pages` ADD `clp_block3_bg_color` VARCHAR(10) NOT NULL AFTER `clp_block3_hide`");
            $this->db->query("ALTER TABLE `courses_landing_pages` ADD `clp_block4_bg_color` VARCHAR(10) NOT NULL AFTER `clp_block4_hide`");
            $this->db->query("ALTER TABLE `courses_landing_pages` ADD `clp_block5_bg_color` VARCHAR(10) NOT NULL AFTER `clp_block5_hide`");
            $this->db->query("ALTER TABLE `courses_landing_pages` ADD `clp_block6_bg_color` VARCHAR(10) NOT NULL AFTER `clp_block6_hide`");
            $this->db->query("ALTER TABLE `courses_landing_pages` ADD `clp_block7_bg_color` VARCHAR(10) NOT NULL AFTER `clp_block7_hide`");
            $this->db->query("ALTER TABLE `courses_landing_pages` ADD `clp_block8_bg_color` VARCHAR(10) NOT NULL AFTER `clp_block8_hide`");

            $this->db->query("ALTER TABLE `courses_landing_pages` ADD `clp_slider_opacity` TINYINT(3) UNSIGNED NOT NULL AFTER `clp_slider_images`");
            $this->db->query("ALTER TABLE `courses_landing_pages` ADD `clp_block2_bg_opacity` TINYINT(3) UNSIGNED NOT NULL DEFAULT '1' AFTER `clp_block2_background_top`");
            $this->db->query("ALTER TABLE `courses_landing_pages` ADD `clp_block3_bg_opacity` TINYINT(3) UNSIGNED NOT NULL AFTER `clp_block3_background`");
            $this->db->query("ALTER TABLE `courses_landing_pages` ADD `clp_block4_bg_opacity` TINYINT(3) UNSIGNED NOT NULL AFTER `clp_block4_background`");
            $this->db->query("ALTER TABLE `courses_landing_pages` ADD `clp_block5_bg_opacity` TINYINT(3) UNSIGNED NOT NULL AFTER `clp_block5_background`");
            $this->db->query("ALTER TABLE `courses_landing_pages` ADD `clp_block6_bg_opacity` TINYINT(3) UNSIGNED NOT NULL AFTER `clp_block6_background`");
            $this->db->query("ALTER TABLE `courses_landing_pages` ADD `clp_block7_bg_opacity` TINYINT(3) UNSIGNED NOT NULL AFTER `clp_block7_background`");
            $this->db->query("ALTER TABLE `courses_landing_pages` ADD `clp_block8_bg_opacity` TINYINT(3) UNSIGNED NOT NULL AFTER `clp_block8_background`");

            self::setDbUpdate($date);
        }

        $date = '2018-12-14 13:01:27';
        $fl_up_db = self::getDbUpdateData($date);
        if($fl_up_db === false)
        {
            $this->db->query("ALTER TABLE `landing_pages` ADD `lp_block1_bg_color` VARCHAR(10) NOT NULL AFTER `lp_background`");
            $this->db->query("ALTER TABLE `landing_pages` ADD `lp_block2_bg_color` VARCHAR(10) NOT NULL AFTER `lp_main_title`");
            $this->db->query("ALTER TABLE `landing_pages` ADD `lp_block3_bg_color` VARCHAR(10) NOT NULL AFTER `lp_block2_button`");
            $this->db->query("ALTER TABLE `landing_pages` ADD `lp_block4_bg_color` VARCHAR(10) NOT NULL AFTER `lp_block3_r_reviews`");
            $this->db->query("ALTER TABLE `landing_pages` ADD `lp_block5_bg_color` VARCHAR(10) NOT NULL AFTER `lp_block4_button`");
            $this->db->query("ALTER TABLE `landing_pages` ADD `lp_block6_bg_color` VARCHAR(10) NOT NULL AFTER `lp_block5_button`");
            $this->db->query("ALTER TABLE `landing_pages` ADD `lp_block7_bg_color` VARCHAR(10) NOT NULL AFTER `lp_block6_button`");
            $this->db->query("ALTER TABLE `landing_pages` ADD `lp_block8_bg_color` VARCHAR(10) NOT NULL AFTER `lp_block7_button`");

            $this->db->query("ALTER TABLE `landing_pages` ADD `lp_slider_opacity` TINYINT(3) UNSIGNED NOT NULL AFTER `lp_slider_images`");
            $this->db->query("ALTER TABLE `landing_pages` ADD `lp_block2_bg_opacity` TINYINT(3) UNSIGNED NOT NULL DEFAULT '1' AFTER `lp_block2_background_top`");
            $this->db->query("ALTER TABLE `landing_pages` ADD `lp_block3_bg_opacity` TINYINT(3) UNSIGNED NOT NULL AFTER `lp_block3_background`");
            $this->db->query("ALTER TABLE `landing_pages` ADD `lp_block4_bg_opacity` TINYINT(3) UNSIGNED NOT NULL AFTER `lp_block4_background`");
            $this->db->query("ALTER TABLE `landing_pages` ADD `lp_block5_bg_opacity` TINYINT(3) UNSIGNED NOT NULL AFTER `lp_block5_background`");
            $this->db->query("ALTER TABLE `landing_pages` ADD `lp_block6_bg_opacity` TINYINT(3) UNSIGNED NOT NULL AFTER `lp_block6_background`");
            $this->db->query("ALTER TABLE `landing_pages` ADD `lp_block7_bg_opacity` TINYINT(3) UNSIGNED NOT NULL AFTER `lp_block7_background`");
            $this->db->query("ALTER TABLE `landing_pages` ADD `lp_block8_bg_opacity` TINYINT(3) UNSIGNED NOT NULL AFTER `lp_block8_background`");

            self::setDbUpdate($date);
        }


        $date = '2018-12-18 14:39:27';
        $fl_up_db = self::getDbUpdateData($date);
        if($fl_up_db === false)
        {
            $this->db->query("UPDATE `courses_landing_pages` SET `clp_block2_bg_color`=`clp_block2_background` WHERE LEFT(`clp_block2_background`, 1) = '#'");
            $this->db->query("UPDATE `courses_landing_pages` SET `clp_block3_bg_color`=`clp_block3_background` WHERE LEFT(`clp_block3_background`, 1) = '#'");
            $this->db->query("UPDATE `courses_landing_pages` SET `clp_block4_bg_color`=`clp_block4_background` WHERE LEFT(`clp_block4_background`, 1) = '#'");
            $this->db->query("UPDATE `courses_landing_pages` SET `clp_block5_bg_color`=`clp_block5_background` WHERE LEFT(`clp_block5_background`, 1) = '#'");
            $this->db->query("UPDATE `courses_landing_pages` SET `clp_block6_bg_color`=`clp_block6_background` WHERE LEFT(`clp_block6_background`, 1) = '#'");
            $this->db->query("UPDATE `courses_landing_pages` SET `clp_block7_bg_color`=`clp_block7_background` WHERE LEFT(`clp_block7_background`, 1) = '#'");
            $this->db->query("UPDATE `courses_landing_pages` SET `clp_block8_bg_color`=`clp_block8_background` WHERE LEFT(`clp_block8_background`, 1) = '#'");

            $this->db->query("UPDATE `landing_pages` SET `lp_block2_bg_color`=`lp_block2_background` WHERE LEFT(`lp_block2_background`, 1) = '#'");
            $this->db->query("UPDATE `landing_pages` SET `lp_block3_bg_color`=`lp_block3_background` WHERE LEFT(`lp_block3_background`, 1) = '#'");
            $this->db->query("UPDATE `landing_pages` SET `lp_block4_bg_color`=`lp_block4_background` WHERE LEFT(`lp_block4_background`, 1) = '#'");
            $this->db->query("UPDATE `landing_pages` SET `lp_block5_bg_color`=`lp_block5_background` WHERE LEFT(`lp_block5_background`, 1) = '#'");
            $this->db->query("UPDATE `landing_pages` SET `lp_block6_bg_color`=`lp_block6_background` WHERE LEFT(`lp_block6_background`, 1) = '#'");
            $this->db->query("UPDATE `landing_pages` SET `lp_block7_bg_color`=`lp_block7_background` WHERE LEFT(`lp_block7_background`, 1) = '#'");
            $this->db->query("UPDATE `landing_pages` SET `lp_block8_bg_color`=`lp_block8_background` WHERE LEFT(`lp_block8_background`, 1) = '#'");

            self::setDbUpdate($date);
        }

        $date = '2018-12-18 17:35:13';
        $fl_up_db = self::getDbUpdateData($date);
        if($fl_up_db === false)
        {
            $this->db->query("ALTER TABLE `courses_landing_pages` CHANGE `clp_slider_opacity` `clp_slider_opacity` DECIMAL(3,2) UNSIGNED NOT NULL, 
              CHANGE `clp_block2_bg_opacity` `clp_block2_bg_opacity` DECIMAL(3,2) UNSIGNED NOT NULL, 
              CHANGE `clp_block3_bg_opacity` `clp_block3_bg_opacity` DECIMAL(3,2) UNSIGNED NOT NULL, 
              CHANGE `clp_block4_bg_opacity` `clp_block4_bg_opacity` DECIMAL(3,2) UNSIGNED NOT NULL, 
              CHANGE `clp_block5_bg_opacity` `clp_block5_bg_opacity` DECIMAL(3,2) UNSIGNED NOT NULL, 
              CHANGE `clp_block6_bg_opacity` `clp_block6_bg_opacity` DECIMAL(3,2) UNSIGNED NOT NULL, 
              CHANGE `clp_block7_bg_opacity` `clp_block7_bg_opacity` DECIMAL(3,2) UNSIGNED NOT NULL, 
              CHANGE `clp_block8_bg_opacity` `clp_block8_bg_opacity` DECIMAL(3,2) UNSIGNED NOT NULL;");

            self::setDbUpdate($date);
        }

        $date = '2018-12-20 15:24:06';
        $fl_up_db = self::getDbUpdateData($date);
        if($fl_up_db === false)
        {
            $this->db->query("ALTER TABLE `courses_landing_pages` CHANGE `clp_block3_images` `clp_block3_image_1` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'default'");
            $this->db->query("ALTER TABLE `courses_landing_pages` ADD `clp_block3_image_2` VARCHAR(255) NOT NULL DEFAULT 'default' AFTER `clp_block3_image_1`");
            $this->db->query("ALTER TABLE `courses_landing_pages` CHANGE `clp_block5_images` `clp_block5_image_1` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'default'");
            $this->db->query("ALTER TABLE `courses_landing_pages` ADD `clp_block5_image_2` VARCHAR(255) NOT NULL DEFAULT 'default' AFTER `clp_block5_image_1`");
            $this->db->query("ALTER TABLE `courses_landing_pages` ADD `clp_block5_image_3` VARCHAR(255) NOT NULL DEFAULT 'default' AFTER `clp_block5_image_2`");
            $this->db->query("ALTER TABLE `courses_landing_pages` CHANGE `clp_block7_images` `clp_block7_image_1` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'default'");
            $this->db->query("ALTER TABLE `courses_landing_pages` ADD `clp_block7_image_2` VARCHAR(255) NOT NULL DEFAULT 'default' AFTER `clp_block7_image_1`");
            $this->db->query("ALTER TABLE `courses_landing_pages` ADD `clp_block7_image_3` VARCHAR(255) NOT NULL DEFAULT 'default' AFTER `clp_block7_image_2`");
            $this->db->query("ALTER TABLE `courses_landing_pages` ADD `clp_block7_image_4` VARCHAR(255) NOT NULL DEFAULT 'default' AFTER `clp_block7_image_3`");

            self::setDbUpdate($date);
        }

        $date = '2018-12-20 15:41:27';
        $fl_up_db = self::getDbUpdateData($date);
        if($fl_up_db === false)
        {
            $this->db->query("ALTER TABLE `landing_pages` CHANGE `lp_block3_images` `lp_block3_image_1` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'default'");
            $this->db->query("ALTER TABLE `landing_pages` ADD `lp_block3_image_2` VARCHAR(255) NOT NULL DEFAULT 'default' AFTER `lp_block3_image_1`");
            $this->db->query("ALTER TABLE `landing_pages` CHANGE `lp_block5_images` `lp_block5_image_1` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'default'");
            $this->db->query("ALTER TABLE `landing_pages` ADD `lp_block5_image_2` VARCHAR(255) NOT NULL DEFAULT 'default' AFTER `lp_block5_image_1`");
            $this->db->query("ALTER TABLE `landing_pages` ADD `lp_block5_image_3` VARCHAR(255) NOT NULL DEFAULT 'default' AFTER `lp_block5_image_2`");
            $this->db->query("ALTER TABLE `landing_pages` CHANGE `lp_block7_images` `lp_block7_image_1` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'default'");
            $this->db->query("ALTER TABLE `landing_pages` ADD `lp_block7_image_2` VARCHAR(255) NOT NULL DEFAULT 'default' AFTER `lp_block7_image_1`");
            $this->db->query("ALTER TABLE `landing_pages` ADD `lp_block7_image_3` VARCHAR(255) NOT NULL DEFAULT 'default' AFTER `lp_block7_image_2`");
            $this->db->query("ALTER TABLE `landing_pages` ADD `lp_block7_image_4` VARCHAR(255) NOT NULL DEFAULT 'default' AFTER `lp_block7_image_3`");

            $sel_data = $this->db->query('SELECT `clp_block3_image_1`, `clp_block5_image_1`, `clp_block7_image_1` FROM `courses_landing_pages`');
            if($sel_data !== false and 0 < $sel_data->num_rows())
            {
                foreach ($sel_data->result() as $row)
                {
                    $s_images_3 = explode(';', $row->clp_block3_image_1);
                    $s_images_5 = explode(';', $row->clp_block5_image_1);
                    $s_images_7 = explode(';', $row->clp_block7_image_1);

                    $this->db->query("UPDATE `courses_landing_pages` 
                        SET `clp_block3_image_1`=?, `clp_block3_image_2`=?, `clp_block5_image_1`=?, `clp_block5_image_2`=?, 
                            `clp_block5_image_3`=?, `clp_block7_image_1`=?, `clp_block7_image_2`=?, `clp_block7_image_3`=?, 
                            `clp_block7_image_4`=? 
                            WHERE `clp_id`=? LIMIT 1",
                        array($s_images_3[0], $s_images_3[1], $s_images_5[0], $s_images_5[1], $s_images_5[2],
                            $s_images_7[0], $s_images_7[1], $s_images_7[2], $s_images_7[3], $row->clp_id));

                }
                unset($row);
            }

            $sel_data = $this->db->query('SELECT `lp_block3_image_1`, `lp_block5_image_1`, `lp_block7_image_1` FROM `landing_pages`');
            if($sel_data !== false and 0 < $sel_data->num_rows())
            {
                foreach ($sel_data->result() as $row)
                {
                    $s_images_3 = explode(';', $row->lp_block3_image_1);
                    $s_images_5 = explode(';', $row->lp_block5_image_1);
                    $s_images_7 = explode(';', $row->lp_block7_image_1);

                    $this->db->query("UPDATE `landing_pages` 
                        SET `lp_block3_image_1`=?, `lp_block3_image_2`=?, `lp_block5_image_1`=?, `lp_block5_image_2`=?, 
                            `lp_block5_image_3`=?, `lp_block7_image_1`=?, `lp_block7_image_2`=?, `lp_block7_image_3`=?, 
                            `lp_block7_image_4`=? 
                            WHERE `lp_id`=? LIMIT 1",
                        array($s_images_3[0], $s_images_3[1], $s_images_5[0], $s_images_5[1], $s_images_5[2],
                            $s_images_7[0], $s_images_7[1], $s_images_7[2], $s_images_7[3], $row->clp_id));

                }
                unset($row);
            }

            self::setDbUpdate($date);
        }

        $date = '2018-12-20 19:53:15';
        $fl_up_db = self::getDbUpdateData($date);
        if($fl_up_db === false)
        {
            $sel_data = $this->db->query('SELECT `clp_id`, `clp_block3_image_1`, `clp_block5_image_1`, `clp_block7_image_1` FROM `courses_landing_pages`');
            if($sel_data !== false and 0 < $sel_data->num_rows())
            {
                foreach ($sel_data->result() as $row)
                {
                    $s_images_3 = explode(';', $row->clp_block3_image_1);
                    $s_images_5 = explode(';', $row->clp_block5_image_1);
                    $s_images_7 = explode(';', $row->clp_block7_image_1);

                    $this->db->query("UPDATE `courses_landing_pages` 
                        SET `clp_block3_image_1`=?, `clp_block3_image_2`=?, `clp_block5_image_1`=?, `clp_block5_image_2`=?, 
                            `clp_block5_image_3`=?, `clp_block7_image_1`=?, `clp_block7_image_2`=?, `clp_block7_image_3`=?, 
                            `clp_block7_image_4`=? 
                            WHERE `clp_id`=? LIMIT 1",
                        array($s_images_3[0], $s_images_3[1], $s_images_5[0], $s_images_5[1], $s_images_5[2],
                            $s_images_7[0], $s_images_7[1], $s_images_7[2], $s_images_7[3], $row->clp_id));

                }
                unset($row);
            }

            $sel_data = $this->db->query('SELECT `lp_id`, `lp_block3_image_1`, `lp_block5_image_1`, `lp_block7_image_1` FROM `landing_pages`');
            if($sel_data !== false and 0 < $sel_data->num_rows())
            {
                foreach ($sel_data->result() as $row)
                {
                    $s_images_3 = explode(';', $row->lp_block3_image_1);
                    $s_images_5 = explode(';', $row->lp_block5_image_1);
                    $s_images_7 = explode(';', $row->lp_block7_image_1);

                    $this->db->query("UPDATE `landing_pages` 
                        SET `lp_block3_image_1`=?, `lp_block3_image_2`=?, `lp_block5_image_1`=?, `lp_block5_image_2`=?, 
                            `lp_block5_image_3`=?, `lp_block7_image_1`=?, `lp_block7_image_2`=?, `lp_block7_image_3`=?, 
                            `lp_block7_image_4`=? 
                            WHERE `lp_id`=? LIMIT 1",
                        array($s_images_3[0], $s_images_3[1], $s_images_5[0], $s_images_5[1], $s_images_5[2],
                            $s_images_7[0], $s_images_7[1], $s_images_7[2], $s_images_7[3], $row->lp_id));

                }
                unset($row);
            }

            self::setDbUpdate($date);
        }

        $date = '2018-12-20 21:31:13';
        $fl_up_db = self::getDbUpdateData($date);
        if($fl_up_db === false)
        {
            $this->db->query("ALTER TABLE `landing_pages` CHANGE `lp_slider_opacity` `lp_slider_opacity` DECIMAL(3,2) UNSIGNED NOT NULL, 
              CHANGE `lp_block2_bg_opacity` `lp_block2_bg_opacity` DECIMAL(3,2) UNSIGNED NOT NULL, 
              CHANGE `lp_block3_bg_opacity` `lp_block3_bg_opacity` DECIMAL(3,2) UNSIGNED NOT NULL, 
              CHANGE `lp_block4_bg_opacity` `lp_block4_bg_opacity` DECIMAL(3,2) UNSIGNED NOT NULL, 
              CHANGE `lp_block5_bg_opacity` `lp_block5_bg_opacity` DECIMAL(3,2) UNSIGNED NOT NULL, 
              CHANGE `lp_block6_bg_opacity` `lp_block6_bg_opacity` DECIMAL(3,2) UNSIGNED NOT NULL, 
              CHANGE `lp_block7_bg_opacity` `lp_block7_bg_opacity` DECIMAL(3,2) UNSIGNED NOT NULL, 
              CHANGE `lp_block8_bg_opacity` `lp_block8_bg_opacity` DECIMAL(3,2) UNSIGNED NOT NULL;");

            $this->db->query("
                UPDATE `landing_pages` 
                SET `lp_block1_bg_color` = '#000', `lp_slider_opacity` = 0.4, `lp_block2_bg_color` = '#000', 
                    `lp_block2_bg_opacity` = 1, `lp_block3_bg_color` = '#000', `lp_block3_bg_opacity` = 0.4, 
                    `lp_block4_bg_color` = '#000', `lp_block4_bg_opacity` = 1, `lp_block5_bg_color` = '#fff', 
                    `lp_block5_bg_opacity` = 1, `lp_block6_bg_color` = '#000', `lp_block6_bg_opacity` = 0.4, 
                    `lp_block7_bg_color` = '#f3f3f3', `lp_block7_bg_opacity` = 1, `lp_block8_bg_color` = '#000', 
                    `lp_block8_bg_opacity` = 0.4 
                WHERE `landing_pages`.`lp_id` = 1");

            $this->db->query("
                UPDATE `landing_pages` 
                SET `lp_block1_bg_color` = '#000', `lp_slider_opacity` = 1, `lp_block2_bg_color` = '#181a1f', 
                    `lp_block2_bg_opacity` = 1, `lp_block3_bg_color` = '#000', `lp_block3_bg_opacity` = 0.4, 
                    `lp_block4_bg_color` = '#181a1f', `lp_block4_bg_opacity` = 1, `lp_block5_bg_color` = '#292d35', 
                    `lp_block5_bg_opacity` = 1, `lp_block6_bg_color` = '#000', `lp_block6_bg_opacity` = 0.2, 
                    `lp_block7_bg_color` = '#181a1f', `lp_block7_bg_opacity` = 1, `lp_block8_bg_color` = '#000', 
                    `lp_block8_bg_opacity` = 0.4 
                WHERE `landing_pages`.`lp_id` = 2");

            self::setDbUpdate($date);
        }

        $date = '2018-12-21 17:48:24';
        $fl_up_db = self::getDbUpdateData($date);
        if($fl_up_db === false)
        {
            $this->db->query("ALTER TABLE `courses_landing_pages` CHANGE `clp_block3_title` `clp_block3_title` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL, 
                CHANGE `clp_block3_subtitle` `clp_block3_subtitle` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL, 
                CHANGE `clp_block3_r_title` `clp_block3_r_title` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL, 
                CHANGE `clp_block3_r_subtitle` `clp_block3_r_subtitle` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL, 
                CHANGE `clp_block3_r_reviews` `clp_block3_r_reviews` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;");

            self::setDbUpdate($date);
        }

        $date = '2018-12-21 18:17:47';
        $fl_up_db = self::getDbUpdateData($date);
        if($fl_up_db === false)
        {
            $this->db->query("ALTER TABLE `courses_landing_pages` CHANGE `clp_block4_title` `clp_block4_title` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL, 
                CHANGE `clp_block4_subtitle` `clp_block4_subtitle` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL, 
                CHANGE `clp_block4_r_title` `clp_block4_r_title` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL, 
                CHANGE `clp_block4_r_subtitle` `clp_block4_r_subtitle` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;");

            self::setDbUpdate($date);
        }

        $date = '2018-12-25 17:19:14';
        $fl_up_db = self::getDbUpdateData($date);
        if($fl_up_db === false)
        {
            $this->db->query("CREATE TABLE `site_meta_tags` ( 
                `smt_id` INT UNSIGNED NOT NULL AUTO_INCREMENT , 
                `smt_page` VARCHAR(255) NOT NULL , 
                `smt_title` VARCHAR(255) NOT NULL , 
                `smt_keywords` VARCHAR(1000) NOT NULL , 
                `smt_description` VARCHAR(255) NOT NULL , 
                `smt_admin_id` INT UNSIGNED NOT NULL , 
                `smt_update` DATETIME NOT NULL , 
                PRIMARY KEY (`smt_id`)) ENGINE = MyISAM");

            $this->db->query("ALTER TABLE `products` 
                ADD `p_meta_description` VARCHAR(255) NOT NULL AFTER `p_full_description`, 
                ADD `p_meta_keywords` VARCHAR(1000) NOT NULL AFTER `p_meta_description`");

            $this->db->query("ALTER TABLE `courses` 
                ADD `crs_meta_description` VARCHAR(255) NOT NULL AFTER `crs_description`, 
                ADD `crs_meta_keywords` VARCHAR(1000) NOT NULL AFTER `crs_meta_description`");

            self::setDbUpdate($date);
        }

        $date = '2018-12-25 17:33:19';
        $fl_up_db = self::getDbUpdateData($date);
        if($fl_up_db === false)
        {
            $this->db->query("INSERT INTO `site_meta_tags` (`smt_id`, `smt_page`, `smt_admin_id`, `smt_update`) VALUES (1, 'Для всех', 4, '2018-12-25 17:33:19')");
            $this->db->query("INSERT INTO `site_meta_tags` (`smt_id`, `smt_page`, `smt_admin_id`, `smt_update`) VALUES (2, 'Главная', 4, '2018-12-25 17:33:19')");
            $this->db->query("INSERT INTO `site_meta_tags` (`smt_id`, `smt_page`, `smt_admin_id`, `smt_update`) VALUES (3, 'О нас', 4, '2018-12-25 17:33:19')");
            $this->db->query("INSERT INTO `site_meta_tags` (`smt_id`, `smt_page`, `smt_admin_id`, `smt_update`) VALUES (4, 'Тренеры', 4, '2018-12-25 17:33:19')");
            $this->db->query("INSERT INTO `site_meta_tags` (`smt_id`, `smt_page`, `smt_admin_id`, `smt_update`) VALUES (5, 'Курсы', 4, '2018-12-25 17:33:19')");
            $this->db->query("INSERT INTO `site_meta_tags` (`smt_id`, `smt_page`, `smt_admin_id`, `smt_update`) VALUES (6, 'Магазин', 4, '2018-12-25 17:33:19')");
            $this->db->query("INSERT INTO `site_meta_tags` (`smt_id`, `smt_page`, `smt_admin_id`, `smt_update`) VALUES (7, 'Контакты', 4, '2018-12-25 17:33:19')");
            $this->db->query("INSERT INTO `site_meta_tags` (`smt_id`, `smt_page`, `smt_admin_id`, `smt_update`) VALUES (8, 'Страница товаров', 4, '2018-12-25 17:33:19')");
            $this->db->query("INSERT INTO `site_meta_tags` (`smt_id`, `smt_page`, `smt_admin_id`, `smt_update`) VALUES (9, 'Страница категорий товаров', 4, '2018-12-25 17:33:19')");
            $this->db->query("INSERT INTO `site_meta_tags` (`smt_id`, `smt_page`, `smt_admin_id`, `smt_update`) VALUES (10, 'Страница оформления заказа', 4, '2018-12-25 17:33:19')");
            $this->db->query("INSERT INTO `site_meta_tags` (`smt_id`, `smt_page`, `smt_admin_id`, `smt_update`) VALUES (11, 'Корзина', 4, '2018-12-25 17:33:19')");

            self::setDbUpdate($date);
        }

        $date = '2018-12-26 13:13:27';
        $fl_up_db = self::getDbUpdateData($date);
        if($fl_up_db === false)
        {
            $this->db->query("INSERT INTO `notifications` (`n_id`, `n_name`, `n_text`, `n_admin_id`, `n_date`) VALUES ('176', 'Ошибка! Метаданные сайта не сохранены.', 'Ошибка! Метаданные сайта не сохранены.', 4, '2018-04-19 14:23:42')");

            self::setDbUpdate($date);
        }


        return $result;
    }

    /**
     * Обновление базы данных август 2018
     *
     * @param $date
     * @return bool
     */
    public function updateDatabaseJanuary2019($date)
    {
        $result = false;

        $date = '2019-01-10 16:39:10';
        $fl_up_db = self::getDbUpdateData($date);
        if($fl_up_db === false)
        {
            $this->db->query("INSERT INTO `notifications` (`n_id`, `n_name`, `n_text`, `n_admin_id`, `n_date`) VALUES (177, 'Категория удалена.', 'Категория удалена.', '4', '2018-04-19 14:23:42')");
            $this->db->query("INSERT INTO `notifications` (`n_id`, `n_name`, `n_text`, `n_admin_id`, `n_date`) VALUES (178, 'Ошибка! Категория не удалена.', 'Ошибка! Категория не удалена.', '4', '2018-04-19 14:23:42')");
            $this->db->query("INSERT INTO `categories`(`cat_id`, `cat_name`, `cat_description`, `cat_blocked`, `cat_date_add`, `cat_date_update`, `cat_admin_id`) VALUES (6, 'Без категории', '', 0, '2019-01-10', '2019-01-10', 4)");

            self::setDbUpdate($date);
        }

        $date = '2019-01-10 19:39:23';
        $fl_up_db = self::getDbUpdateData($date);
        if($fl_up_db === false)
        {
            $this->db->query("INSERT INTO `notifications` (`n_id`, `n_name`, `n_text`, `n_admin_id`, `n_date`) VALUES (179, 'Пользователь удален.', 'Пользователь удален.', '4', '2018-04-19 14:23:42')");
            $this->db->query("INSERT INTO `notifications` (`n_id`, `n_name`, `n_text`, `n_admin_id`, `n_date`) VALUES (180, 'Ошибка! Пользователь не удален.', 'Ошибка! Пользователь не удален.', '4', '2018-04-19 14:23:42')");

            self::setDbUpdate($date);
        }

        $date = '2019-01-11 10:44:17';
        $fl_up_db = self::getDbUpdateData($date);
        if($fl_up_db === false)
        {
            $this->db->query("ALTER TABLE `courses` ADD `crs_archive` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0' AFTER `crs_blocked`, ADD INDEX `ix_crs_archive` (`crs_archive`)");

            self::setDbUpdate($date);
        }

        $date = '2019-01-11 10:53:41';
        $fl_up_db = self::getDbUpdateData($date);
        if($fl_up_db === false)
        {
            $this->db->query("INSERT INTO `notifications` (`n_id`, `n_name`, `n_text`, `n_admin_id`, `n_date`) VALUES (181, 'Курс перенесен в архив.', 'Курс перенесен в архив.', '4', '2018-04-19 14:23:42')");
            $this->db->query("INSERT INTO `notifications` (`n_id`, `n_name`, `n_text`, `n_admin_id`, `n_date`) VALUES (182, 'Ошибка! Курс не перенесен в архив.', 'Ошибка! Курс не перенесен в архив.', '4', '2018-04-19 14:23:42')");
            $this->db->query("INSERT INTO `notifications` (`n_id`, `n_name`, `n_text`, `n_admin_id`, `n_date`) VALUES (183, 'Курс перенесен из архива в активные курсы.', 'Курс перенесен из архива в активные курсы.', '4', '2018-04-19 14:23:42')");
            $this->db->query("INSERT INTO `notifications` (`n_id`, `n_name`, `n_text`, `n_admin_id`, `n_date`) VALUES (184, 'Ошибка! Курс не перенесен из архива в активные курсы.', 'Ошибка! Курс не перенесен из архива в активные курсы.', '4', '2018-04-19 14:23:42')");

            self::setDbUpdate($date);
        }

        $date = '2019-01-15 12:07:11';
        $fl_up_db = self::getDbUpdateData($date);
        if($fl_up_db === false)
        {
            $this->db->query("ALTER TABLE `users` ADD `user_deleted` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0' AFTER `user_idempotent`, 
                ADD `user_delete_date` DATE NOT NULL AFTER `user_deleted`, 
                ADD `user_delete_by` INT(10) UNSIGNED NOT NULL AFTER `user_delete_date`, 
                ADD INDEX `ix_user_deleted` (`user_deleted`), 
                ADD INDEX `ixs_user_deleted_date` (`user_deleted`, `user_delete_date`);");

            self::setDbUpdate($date);
        }

        $date = '2019-01-17 10:23:34';
        $fl_up_db = self::getDbUpdateData($date);
        if($fl_up_db === false)
        {
            $this->db->query("INSERT INTO `notifications` (`n_id`, `n_name`, `n_text`, `n_admin_id`, `n_date`) VALUES (185, 'Пользователь восстановлен.', 'Пользователь восстановлен.', '4', '2018-04-19 14:23:42')");
            $this->db->query("INSERT INTO `notifications` (`n_id`, `n_name`, `n_text`, `n_admin_id`, `n_date`) VALUES (186, 'Ошибка! Пользователь не восстановлен из удаленных.', 'Ошибка! Пользователь не восстановлен из удаленных.', '4', '2018-04-19 14:23:42')");

            $this->db->query("INSERT INTO `emails` (`e_id`, `e_name`, `e_ea_id`, `e_subject`, `e_text`, `e_images`, `e_admin_id`, `e_date`) VALUES (13, 'Аккаунт удален', 1, 'Аккаунт удален с сайта SuperBody', 'Ваш аккаунт удален.В течении 30 дней Вы можете обратиться к администрации сайта, что бы восстановить аккаунт.', '', 4, '2018-04-25 11:41:46')");

            self::setDbUpdate($date);
        }

        $date = '2019-01-17 13:00:41';
        $fl_up_db = self::getDbUpdateData($date);
        if($fl_up_db === false)
        {
            $this->db->query("INSERT INTO `emails` (`e_id`, `e_name`, `e_ea_id`, `e_subject`, `e_text`, `e_images`, `e_admin_id`, `e_date`) VALUES (14, 'Аккаунт восстановлен', 1, 'Аккаунт восстановлен на сайте SuperBody', 'Ваш аккаунт восстановлен.', '', 4, '2018-04-25 11:41:46')");

            self::setDbUpdate($date);
        }

        $date = '2019-01-18 11:36:05';
        $fl_up_db = self::getDbUpdateData($date);
        if($fl_up_db === false)
        {
            $this->db->query("UPDATE `notifications` SET `n_name` = 'Ошибка! Информация о тренере не сохранена. Пожалуйста, повторите попытку.', `n_text` = 'Ошибка! Информация о тренере не сохранена. Пожалуйста, повторите попытку.' WHERE `notifications`.`n_id` = 78");
            $this->db->query("INSERT INTO `notifications` (`n_id`, `n_name`, `n_text`, `n_admin_id`, `n_date`) VALUES (187, 'Ошибка! Личные данные не сохранены. Пожалуйста, повторите попытку.', 'Ошибка! Личные данные не сохранены. Пожалуйста, повторите попытку.', 4, '2018-04-19 14:23:42')");

            self::setDbUpdate($date);
        }

        $date = '2019-01-21 10:51:12';
        $fl_up_db = self::getDbUpdateData($date);
        if($fl_up_db === false)
        {
            $this->db->query("ALTER TABLE `promocodes_used` ADD `pcu_o_id` INT UNSIGNED NOT NULL AFTER `pcu_code`,
                ADD `pcu_p_id` INT UNSIGNED NOT NULL AFTER `pcu_o_id`,
                ADD `pcu_u_id` INT UNSIGNED NOT NULL AFTER `pcu_p_id`");

            self::setDbUpdate($date);
        }

        $date = '2019-01-21 11:29:41';
        $fl_up_db = self::getDbUpdateData($date);
        if($fl_up_db === false)
        {
            $this->db->query("INSERT INTO `notifications` (`n_id`, `n_name`, `n_text`, `n_admin_id`, `n_date`) VALUES (188, 'Ошибка! Статут платежа не соответствует статусу ожидания подтвержения.', 'Ошибка! Статут платежа не соответствует статусу ожидания подтвержения.', 4, '2018-04-19 14:23:42')");
            $this->db->query("INSERT INTO `notifications` (`n_id`, `n_name`, `n_text`, `n_admin_id`, `n_date`) VALUES (189, 'Ошибка! Платеж не подтвержен.', 'Ошибка! Платеж не подтвержден.', 4, '2018-04-19 14:23:42')");

            self::setDbUpdate($date);
        }

        $date = '2019-01-22 10:36:41';
        $fl_up_db = self::getDbUpdateData($date);
        if($fl_up_db === false)
        {
            $this->db->query("ALTER TABLE `promocodes_used` ADD `pcu_discount` INT(11) UNSIGNED NOT NULL AFTER `pcu_code`");

            self::setDbUpdate($date);
        }

        $date = '2019-01-22 10:51:00';
        $fl_up_db = self::getDbUpdateData($date);
        if($fl_up_db === false)
        {
            $this->db->query('ALTER TABLE `promocodes_used` CHANGE `pcu_id` `pcu_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT');

            self::setDbUpdate($date);
        }

        $date = '2019-01-22 10:59:51';
        $fl_up_db = self::getDbUpdateData($date);
        if($fl_up_db === false)
        {
            $this->db->query("UPDATE `orders_payment` SET `op_status` = 'succeeded' WHERE `orders_payment`.`op_id` = 12");
            $this->db->query("UPDATE `orders_payment` SET `op_status` = 'succeeded' WHERE `orders_payment`.`op_id` = 13");

            self::setDbUpdate($date);
        }

        //$this->db->query("INSERT INTO `emails` (`e_id`, `e_name`, `e_ea_id`, `e_subject`, `e_text`, `e_images`, `e_admin_id`, `e_date`) VALUES (15, 'Курс куплен', 1, 'Курс куплен', 'Вы купили курс на сайте Superbody.pro. Настроить курс можно в личном кабинете.', '', 4, '2018-04-25 11:41:46')");


        return $result;
    }


    /**
     * Поиск даты обновления в БД
     *
     * @param $date
     * @return bool
     */
    public function getDbUpdateData($date)
    {
        $result = false;

        $sel_data = $this->db->query('SELECT `db_id` FROM `database_update` WHERE `db_date`=? LIMIT 1', $date);
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
     * Добавление даты обновления БД
     *
     * @param $date
     * @return bool
     */
    public function setDbUpdate($date)
    {
        $result = false;

        $ins_data = $this->db->query('INSERT INTO `database_update` (`db_date`) VALUES(?)', $date);
        if($ins_data === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }
        elseif($ins_data !== false and 1 == $this->db->affected_rows())
        {
            $result = true;
        }

        return $result;
    }

    /**
     * Выборка структуры таблицы
     *
     * @param $table
     * @return bool|array
     */
    public function showDataTable($table)
    {
        $result = false;

        $sel_data = $this->db->query('SELECT * FROM `'.$table.'`');
        if($sel_data !== false)
        {
            $result = $sel_data->result();
        }
        elseif($sel_data === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Выборка данных таблицы
     *
     * @param $table
     * @return bool|array
     */
    public function showTable($table)
    {
        $result = false;

        $sel_data = $this->db->query('DESCRIBE `'.$table.'`');
        if($sel_data !== false)
        {
            $result = $sel_data->result();
        }
        elseif($sel_data === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Выборка данных таблиц
     *
     * @return bool|array
     */
    public function showTables()
    {
        $result = false;

        $sel_data = $this->db->list_tables();
        if($sel_data !== false)
        {
            $result = $sel_data;
        }
        elseif($sel_data === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }

    /**
     * Выборка дат обновления БД
     *
     * @return bool|array
     */
    public function getUpdateDates()
    {
        $result = false;

        $sel_data = $this->db->query('SELECT `db_id`, `db_date` FROM `database_update` ORDER BY `db_date` DESC');
        if($sel_data !== false)
        {
            $result = $sel_data->result();
        }
        elseif($sel_data === false)
        {
            parent::logDbMessages(__METHOD__.':'.__LINE__);
        }

        return $result;
    }
}