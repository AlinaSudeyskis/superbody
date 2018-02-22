<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Класс Calendar
 *
 * Вывод календаря пользователя
 *
 * @author Alina Sudeyskis <alina.sudeyskis@gmail.com>
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Calendar extends CI_Controller
{
    /**
     * Calendar constructor.
     */
    public function __construct()
    {
        parent::__construct();
        
        // Если пользователь не авторизован, переход на страницу авторизации
        if (empty($this->user_id)) {
            header('Location: /login');
        }

    }
    
    public function getUserCalendar()
    {
        $this->load->model('User_model');
        $this->load->model('Course_model');

        /**
         * @var array $result Объединенные данные страницы
         * @var array $events Данные календаря
         */
        $result = array();
        $events = array();

        $training_time = $this->User_model->getUserTrainingTime($this->user_id); // Тренировочное время пользователя
        $result        = $this->Course_model->getUserCourses($this->user_id, $this->date, $training_time); // Выборка курсов пользователя


        // Объединенные данные страница
        $this->page_data['title'] = 'Календарь';
        $this->page_data['page_menu'] = 'calendar';

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/profile');
        $this->load->view('user/profile_line');
        $this->load->view('calendar/user_calendar', $result);
        $this->load->view('footer/footer');
    }
}