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

        if (empty($this->user_id) or 3 != $this->session->user['type'] or $this->session->user['blocked'] == 1 or $this->user_id != 4)
        {
            parent::pageNotFound($this->page_url);
        }

        $this->load->model('Database_model');
    }

    /**
     * Добавление таблиц
     *
     * @return void
     */
    public function createTables()
    {
        if (empty($this->user_id) or 3 != $this->session->user['type'] or $this->session->user['blocked'] == 1)
        {
            parent::pageNotFound($this->page_url);
        }

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
        //$up_data = $this->Database_model->updateDatabaseJuly2018($this->date);
        //$up_data = $this->Database_model->updateDatabaseAugust2018($this->date);
        //$up_data = $this->Database_model->updateDatabaseOctober2018($this->date);
        //$up_data = $this->Database_model->updateDatabaseNovember2018($this->date);
        //$up_data = $this->Database_model->updateDatabaseDecember2018($this->date);
        //$up_data = $this->Database_model->updateDatabaseJanuary2019($this->date);
        //$up_data = $this->Database_model->updateDatabaseFebruary2019($this->date);
        //$up_data = $this->Database_model->updateDatabaseMarch2019($this->date);
        //$up_data = $this->Database_model->updateDatabaseApril2019($this->date);
        //$up_data = $this->Database_model->updateDatabaseMay2019($this->date);
        //$up_data = $this->Database_model->updateDatabaseJune2019($this->date);
        //$up_data = $this->Database_model->updateDatabaseJuly2019($this->date);
        //$up_data = $this->Database_model->updateDatabaseAugust2019($this->date);
        //$up_data = $this->Database_model->updateDatabaseSeptember2019($this->date);
        //$up_data = $this->Database_model->updateDatabaseOctober2019($this->date);
        //$up_data = $this->Database_model->updateDatabaseNovember2019($this->date);
        //$up_data = $this->Database_model->updateDatabaseDecember2019($this->date);
        //$up_data = $this->Database_model->updateDatabaseJanuary2020($this->date);
        //$up_data = $this->Database_model->updateDatabaseFebruary2020($this->date);
        $up_data = $this->Database_model->updateDatabaseMarch2020($this->date);
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
        $this->load->view('admin/db_index', $result);
        $this->load->view('footer/footer');
    }

    /**
     * Просмотр Таблицы
     *
     * @param $table
     */
    public function showTable($table)
    {
        $result['table_data'] = $this->Database_model->showTable($table);

        // Объединенные данные страница
        $this->page_data['title']        = 'АП - База данных';
        $this->page_data['page_menu']    = '';

        $this->load->view('header/header_admin', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('admin/db_index', $result);
        $this->load->view('footer/footer');
    }

    /**
     * Просмотр данных Таблицы
     *
     * @param $table
     * @param null $limit
     * @param null $offset
     */
    public function showDataTable($table, $limit = null, $offset = null)
    {
        $result['table_info'] = $this->Database_model->showDataTable($table, $limit, $offset);

        // Объединенные данные страница
        $this->page_data['title']        = 'АП - База данных';
        $this->page_data['page_menu']    = '';

        $this->load->view('header/header_admin', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('admin/db_index', $result);
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
        $this->load->view('admin/db_index', $result);
        $this->load->view('footer/footer');
    }

    public function brokenUsersCourses()
    {
        $this->load->model('Course_model');
        //$this->Course_model->getBrokenUsersCourses($this->date);
    }

    public function brokenUsersOrders()
    {
        $this->load->model('Store_model');
        $this->Store_model->getBrokenUsersOrders($this->date);
    }
}