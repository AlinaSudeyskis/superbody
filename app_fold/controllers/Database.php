<?php

/**
 * Создание, редактирование и удаление таблиц, столбцов базы данных
 *
 * @author Alina Sudeyskis <alina.sudeyskis@gmail.com>
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Database extends CI_Controller
{
    /**
     * Database constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Database_model');
    }

    /**
     * Добавление таблиц
     *
     * @return void
     */
    public function createTables()
    {
        $users = "CREATE TABLE `alinas1f_sb`.`users` ( 
              `user_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY, 
              `user_email` VARCHAR(255) NOT NULL , 
              `user_password` VARCHAR(255) NOT NULL , 
              `user_auth_via` ENUM('native','vk.com','facebook.com','linkedin.com','ok.ru') NOT NULL DEFAULT 'native' , 
              `user_social_id` BIGINT(19) UNSIGNED NOT NULL , 
              `user_name` VARCHAR(255) NOT NULL , 
              `user_type` TINYINT(1) UNSIGNED NOT NULL DEFAULT '1' ,
              `user_date_reg` DATETIME NOT NULL ,
              `user_activated` TINYINT(1) NOT NULL DEFAULT '0',
              `user_date_auth` DATETIME NOT NULL ,
              INDEX `ix_user_email` (`user_email`) ,
              INDEX `ix_user_type` (`user_type`)
              ) ENGINE = MyISAM;";

        $this->db->query($users);
    }

    // Обновление БД
    public function updateDatabase()
    {
        // Обновление БД
        $up_data = $this->Database_model->updateDatabaseJuly2018($this->date);
        if($up_data !== false)
        {
            // Сохранено
            $this->session->set_tempdata('message', 10, 60);

            header('Location: /administration/update/database');
        }
        $result['update_dates'] = $this->Database_model->getUpdateDates();

        // Объединенные данные страница
        $this->page_data['title']        = 'АП - База данных';
        $this->page_data['page_menu']    = '';

        $this->load->view('header/header_admin', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('admin/index', $result);
        $this->load->view('footer/footer');
    }

    // Просмотр Таблицы
    public function showTable()
    {
        $result['table_data'] = $this->Database_model->showTable('courses_attached');

        // Объединенные данные страница
        $this->page_data['title']        = 'АП - База данных';
        $this->page_data['page_menu']    = '';

        $this->load->view('header/header_admin', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('admin/index', $result);
        $this->load->view('footer/footer');
    }

    // Просмотр Таблиц
    public function showTables()
    {
        $result['tables_data'] = $this->Database_model->showTables();

        // Объединенные данные страница
        $this->page_data['title']        = 'АП - База данных';
        $this->page_data['page_menu']    = '';

        $this->load->view('header/header_admin', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('admin/index', $result);
        $this->load->view('footer/footer');
    }
}