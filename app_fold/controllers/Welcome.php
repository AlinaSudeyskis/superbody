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
        $this->page_data['title']       = $this->page_data['metadata'][2]['title'];
        $this->page_data['keywords']    = $this->page_data['metadata'][2]['keywords'];
        $this->page_data['description'] = $this->page_data['metadata'][2]['description'];
        $this->page_data['page_menu']   = 'index';

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
        $this->page_data['title']       = $this->page_data['metadata'][3]['title'];
        $this->page_data['keywords']    = $this->page_data['metadata'][3]['keywords'];
        $this->page_data['description'] = $this->page_data['metadata'][3]['description'];
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
        if($this->input->post('bt_send_message', true))
        {
            $email    = (filter_var($this->input->post('email'), FILTER_VALIDATE_EMAIL)) ? $this->input->post('email') : null;
            $name     = mb_substr(strip_tags($this->input->post('name', true)), 0, 255);
            $message  = mb_substr(strip_tags($this->input->post('message', true)), 0, 1000);
            $g_c_resp = $this->input->post('g-recaptcha-response', true);

            $myCurl = curl_init();
            curl_setopt_array($myCurl, array(
                CURLOPT_URL => 'https://www.google.com/recaptcha/api/siteverify',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_POSTFIELDS => http_build_query(array('secret' => '6LdyBmYUAAAAAM7E7voVemkU62C_BmqHZ7aNH20a',
                    'response' => $g_c_resp, 'remoteip' => $_SERVER['REMOTE_ADDR']))
            ));
            $response = curl_exec($myCurl);
            curl_close($myCurl);
            $resp_info = json_decode($response);

            if (!empty($email) and !empty($message) and $resp_info->success === true)
            {
                $this->load->model('Message_model');

                $user_id = null;
                $today   = $this->date;

                $res_send = $this->Message_model->setFeedbackMessage($user_id, $name, $email, $message, $today);

                if ($res_send === true)
                {
                    // Отправление письма с уведомление об ожидании ответа
                    $system_message['text']  = '';

                    parent::sendEmail(9, $email, $system_message);

                    // Сохранено
                    $this->session->set_tempdata('message', 135, 60);
                }
                else
                {
                    // Сохранено
                    $this->session->set_tempdata('message', 51, 60);
                }
            }
            else
            {
                // Сохранено
                $this->session->set_tempdata('message', 51, 60);
            }

            header('Location: /contacts');
        }

        $this->load->model('Couch_model');
        $gallery = $this->Couch_model->getGallery();
        $couches = $this->Couch_model->getCouches();
        $reviews = $this->Course_model->getAvaliableReviews();

        $result = array_merge($gallery, $couches, $reviews);

        // Объединенные данные страница
        $this->page_data['title']       = $this->page_data['metadata'][7]['title'];
        $this->page_data['keywords']    = $this->page_data['metadata'][7]['keywords'];
        $this->page_data['description'] = $this->page_data['metadata'][7]['description'];
        $this->page_data['page_menu'] = 'contacts';

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/contacts');
        $this->load->view('site/contacts', $result);
        $this->load->view('footer/footer');
    }

    public function unsubscribe()
    {
        $email = filter_var($this->input->get('email', true), FILTER_VALIDATE_EMAIL) ? $this->input->get('email') : null;

        if(!empty($email))
        {
            $res_up = $this->Welcome_model->unsubscribeEmail($email);

            if($res_up === true)
            {
                // Сохранено
                $info_code = 141;
            }
            else
            {
                // Не сохранено
                $info_code = 140;
            }
        }
        else
        {
            // Не коректный email
            $info_code = 6;
        }

        $this->load->model('Notification_model');
        $notification = (!empty($info_code) and is_numeric($info_code)) ? $this->Notification_model->getNotification($info_code) : '';

        // Объединенные данные страница
        $this->page_data['title']     = 'Подписка';
        $this->page_data['page_menu'] = '';

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/secondary');
        $this->load->view('authorization/unsubscribe', $notification);
        $this->load->view('footer/footer');
    }
}
