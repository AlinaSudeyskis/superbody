<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use YandexCheckout\Client;

/**
 * Default controller
 *
 * @author Alina Sudeyskis <alina.sudeyskis@gmail.com>
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Welcome extends CI_Controller
{
	/**
	 * Welcome constructor.
	 */
	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('Welcome_model');
	}

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
        // Добавление подписчика
        if ($this->input->post('bt_subscribe', true) and $this->input->post('cb_politics', true))
        {
            $email = filter_var($this->input->post('subscribe_email', true), FILTER_VALIDATE_EMAIL) ? $this->input->post('subscribe_email') : null;
            $name  = mb_substr(strip_tags($this->input->post('subscribe_name', true)), 0, 255);

            if (!empty($email))
            {
                $result = $this->Welcome_model->setNewSubscriber($email, $name, $this->date);

                if ($result === true)
                {
                    // Сохранено
                    $this->session->set_tempdata('message', 74, 60);

                    parent::checkEmail($email, $name);
                }
                elseif ($result == 2)
                {
                    // Не сохранено
                    $this->session->set_tempdata('message', 75, 60);
                }
                elseif ($result == 3)
                {
                    // Уже подписан
                    $this->session->set_tempdata('message', 77, 60);
                }
            }
            else
            {
                // Некорректный email
                $this->session->set_tempdata('message', 76, 60);                
            }

            header('Location: /');
        }
        elseif($this->input->post('bt_subscribe', true) and !$this->input->post('cb_politics', true))
        {
            // Checkbox политики не выбран
            $this->session->set_tempdata('message', 128, 60);

            header('Location: /');
        }

        $this->load->model('Course_model');
        $this->load->model('Couch_model');

        $courses = $this->Course_model->getAvailableCourses();
        $reviews = $this->Course_model->getAvaliableReviews();
        $couches = $this->Couch_model->getCouches();
        $video   = $this->Course_model->getAvaliablePromoVideo();
        $gallery = $this->Couch_model->getGallery();

        $result = array_merge($courses, $couches, $video, $gallery, $reviews);

        //print_r($couches);
        
        // Объединенные данные страница
        $this->page_data['title'] = 'Welcome!';
        $this->page_data['page_menu'] = 'index';

		$this->load->view('header/header', $this->page_data);
		$this->load->view('header/main');
		$this->load->view('welcome/welcome_message', $result);
		$this->load->view('footer/footer');
	}

    /**
     * О нас
     *
     * @return void
     */
    public function about()
    {
        $this->load->model('Couch_model');
        $result = $this->Couch_model->getCouches();

        // Объединенные данные страница
        $this->page_data['title'] = 'О нашем проекте';
        $this->page_data['page_menu'] = 'about';

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/secondary');
        $this->load->view('site/about', $result);
        $this->load->view('footer/footer');
    }

    /**
     * Контакты
     *
     * @return void
     */
    public function contacts()
    {
        $this->load->model('Couch_model');
        $gallery = $this->Couch_model->getGallery();
        $couches = $this->Couch_model->getCouches();
        $reviews = $this->Course_model->getAvaliableReviews();

        $result = array_merge($gallery, $couches, $reviews);

        // Объединенные данные страница
        $this->page_data['title'] = 'Контакты';
        $this->page_data['page_menu'] = 'contacts';

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/contacts');
        $this->load->view('site/contacts', $result);
        $this->load->view('footer/footer');
    }
}
