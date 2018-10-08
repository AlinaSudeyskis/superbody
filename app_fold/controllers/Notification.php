<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Notification class
 *
 * Класс для работы с данными уведомлений и почты
 *
 * @author Alina Sudeyskis <alina.sudeyskis@gmail.com>
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Notification extends CI_Controller
{
    /**
     * Notification constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Administrator_model');
    }

    public function notifications()
    {
        if (empty($this->user_id) or 3 != $this->session->user['type'] or $this->session->user['blocked'] == 1)
        {
            parent::pageNotFound($this->page_url);
        }

        $result['notifications'] = $this->Notification_model->getListNotifications();

        // Объединенные данные страница
        $this->page_data['title'] = 'АП - Уведомления';
        $this->page_data['page_menu'] = 'notifications';

        $this->load->view('header/header_admin', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('notification/notifications', $result);
        $this->load->view('footer/footer');
    }

    /**
     * Форма редактирования данных уведомления
     *
     * @param $notification_id
     */
    public function notification($notification_id)
    {
        if (empty($this->user_id) or 3 != $this->session->user['type'] or $this->session->user['blocked'] == 1)
        {
            parent::pageNotFound($this->page_url);
        }

        $result = $this->Notification_model->getNotification($notification_id);

        if($this->input->post('bt_save_notification', true))
        {
            $description = mb_substr(strip_tags($this->input->post('ta_description', true)), 0, 100);

            if(!empty($description) and $description != $result['notification']['text'])
            {
                $res_up = $this->Notification_model->updateNotification($notification_id, $description, $this->user_id, $this->date);

                if ($res_up === true)
                {
                    // Сохранено
                    $this->session->set_tempdata('message', 10, 60);
                }
                else
                {
                    // Не сохранено
                    $this->session->set_tempdata('message', 137, 60);
                }
            }

            header('Location: /administration/notification/' . $notification_id);
        }

        // Объединенные данные страница
        $this->page_data['title'] = 'АП - Уведомления';
        $this->page_data['page_menu'] = 'notifications';

        $this->load->view('header/header_admin', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('notification/notification_settings', $result);
        $this->load->view('footer/footer');
    }

    public function emails()
    {
        if (empty($this->user_id) or 3 != $this->session->user['type'] or $this->session->user['blocked'] == 1)
        {
            parent::pageNotFound($this->page_url);
        }

        $result = $this->Notification_model->getListEmails();

        // Объединенные данные страница
        $this->page_data['title']        = 'АП - Эл. письма';
        $this->page_data['page_menu']    = 'emails';
        $this->page_data['page_submenu'] = 'emails';

        $this->load->view('header/header_admin', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('email/emails', $result);
        $this->load->view('footer/footer');
    }

    /**
     * Форма редактирования эл. писем
     *
     * @param $email_id
     */
    public function email($email_id)
    {
        if (empty($this->user_id) or 3 != $this->session->user['type'] or $this->session->user['blocked'] == 1)
        {
            parent::pageNotFound($this->page_url);
        }

        $email_data = $this->Notification_model->getEmail($email_id);
        $addresses  = $this->Notification_model->getListEmailsAddresses();

        if($this->input->post('bt_save_email', true))
        {
            $e_data = $email_data['email'];

            // ID эл. адреса отправителя
            $address_id = is_numeric($this->input->post('s_email_address', true))
                ? $this->input->post('s_email_address', true)
                : $addresses['default_address'];

            // Тема
            $subject = mb_substr(strip_tags($this->input->post('email_subject', true)), 0, 255);

            // Текст письма
            $text = mb_substr(strip_tags($this->input->post('email_text', true), '<span><br/><b><i><p>'), 0, 2000);

            // Загрузка изображения на сервер
            $image = '.' . $email_data['email']['image'];
            if(is_uploaded_file($_FILES['email_image']['tmp_name']))
            {
                $path = './email_files/' . $email_id . '/';

                if(!file_exists($path))
                {
                    chdir('email_files');
                    if(!is_dir($email_id))
                    {
                        mkdir($email_id);
                    }
                    chmod($email_id, 0777);
                    chdir('../');
                }

                $this->load->helper('file');

                $path_image = parent::uploadImage('email_image', $_FILES['email_image']['type'], $path);

                if(file_exists($path.$path_image))
                {
                    if ($this->security->xss_clean($path.$path_image, TRUE) !== FALSE)
                    {
                        // файл прошел XSS тест
                        $image = $path . $path_image;

                        // Удаление предыдущего изображения
                        if (!empty($e_data['image']) and is_file($e_data['image']))
                        {
                            unlink('.' . $e_data['image']);
                        }
                    }
                    else
                    {
                        unlink($path);
                    }
                }
            }

            // Сохранение данных
            if($address_id != $e_data['ea_id'] or $subject != $e_data['subject'] or $text != $e_data['text']
                or (!empty($image) and $image != $e_data['image']))
            {
                $res_up = $this->Notification_model->updateEmailData($email_id, $address_id, $subject, $text, $image,
                    $this->user_id, $this->date);

                if ($res_up === true)
                {
                    // Сохранено
                    $this->session->set_tempdata('message', 10, 60);
                }
                else
                {
                    // Не сохранено
                    $this->session->set_tempdata('message', 139, 60);
                }
            }

            header('Location: /administration/email/' . $email_id);
        }

        $result = array_merge($email_data, $addresses);

        // Объединенные данные страница
        $this->page_data['title']        = 'АП - Эл. письма';
        $this->page_data['page_menu']    = 'emails';
        $this->page_data['page_submenu'] = 'emails';

        $this->load->view('header/header_admin', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('email/email_settings', $result);
        $this->load->view('footer/footer');
    }

    /**
     * Вывод сожержимого эл. письма
     *
     * @param null|int $email_id
     */
    public function emailSample($email_id = null)
    {
        $this->page_data['title'] = 'Предаварительный просмотр эл. письма';
        $result = $this->page_data;

        if(is_numeric($email_id))
        {
            $email_data = $this->Notification_model->getEmail($email_id);
            $menu_data  = array();
            if($email_id == 12)
            {
                $this->load->model('Course_model');
                $course_data = $this->Course_model->getUserCourseSettings(34, 4);
                $menu        = $this->Course_model->getUserNutritionMenu(34, 4, $this->date);
                $menu_data['system_message'] = array_merge($course_data, $menu);
            }
            $result = array_merge($result, $email_data, $menu_data);
        }

        $this->load->view('email/email_parts/full_page', $result);
    }

    public function emailsAddresses()
    {
        if (empty($this->user_id) or 3 != $this->session->user['type'] or $this->session->user['blocked'] == 1)
        {
            parent::pageNotFound($this->page_url);
        }

        $result = $this->Notification_model->getListEmailsAddresses();

        // Объединенные данные страница
        $this->page_data['title']        = 'АП - Эл. письма';
        $this->page_data['page_menu']    = 'emails';
        $this->page_data['page_submenu'] = 'emails_addresses';

        $this->load->view('header/header_admin', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('email/emails_addresses', $result);
        $this->load->view('footer/footer');
    }

    public function newEmailAddress()
    {
        if (empty($this->user_id) or 3 != $this->session->user['type'] or $this->session->user['blocked'] == 1)
        {
            parent::pageNotFound($this->page_url);
        }

        if($this->input->post('bt_save_address', true))
        {
            $e_name  = mb_substr(strip_tags($this->input->post('i_email_name', true)), 0, 255);
            $e_email = filter_var($this->input->post('email', true), FILTER_VALIDATE_EMAIL) ? $this->input->post('email', true) : null;
            $default = $this->input->post('cb_default', true) ? 1 : 0;

            if(!empty($e_email))
            {
                $res_up = $this->Notification_model->setNewEmailAddress($e_email, $e_name, $default, $this->user_id, $this->date);

                if (is_numeric($res_up))
                {
                    $email_id = $res_up;

                    // Сохранено
                    $this->session->set_tempdata('message', 10, 60);
                    header('Location: /administration/email/address/' . $email_id);
                }
                elseif($res_up === false)
                {
                    // Не сохранено
                    $this->session->set_tempdata('message', 138, 60);
                    header('Location: /administration/emails/addresses/new');
                }
            }

        }

        // Объединенные данные страница
        $this->page_data['title']        = 'АП - Добавление эл. адреса';
        $this->page_data['page_menu']    = 'emails';
        $this->page_data['page_submenu'] = 'emails_addresses';

        $this->load->view('header/header_admin', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('email/new_email_address');
        $this->load->view('footer/footer');
    }

    /**
     * Форма редактирования email адреса
     *
     * @param $email_id
     */
    public function emailAddress($email_id)
    {
        if (empty($this->user_id) or 3 != $this->session->user['type'] or $this->session->user['blocked'] == 1)
        {
            parent::pageNotFound($this->page_url);
        }

        $result = $this->Notification_model->getEmailAddress($email_id);

        if($this->input->post('bt_save_address', true))
        {
            $e_name  = mb_substr(strip_tags($this->input->post('i_email_name', true)), 0, 255);
            $e_email = filter_var($this->input->post('email', true), FILTER_VALIDATE_EMAIL) ? $this->input->post('email', true) : null;
            $default = $this->input->post('cb_default', true) ? 1 : 0;

            if(!empty($e_email) and ($e_name != $result['address']['name'] or $e_email != $result['address']['email']
                    or $default != $result['address']['default']))
            {
                $res_up = $this->Notification_model->updateEmailAddress($email_id, $e_name, $e_email, $default, $this->user_id, $this->date);

                if ($res_up === true)
                {
                    // Сохранено
                    $this->session->set_tempdata('message', 10, 60);
                }
                else
                {
                    // Не сохранено
                    $this->session->set_tempdata('message', 138, 60);
                }
            }

            header('Location: /administration/email/address/' . $email_id);
        }

        // Объединенные данные страница
        $this->page_data['title']        = 'АП - Эл. письма';
        $this->page_data['page_menu']    = 'emails';
        $this->page_data['page_submenu'] = 'emails_addresses';

        $this->load->view('header/header_admin', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('email/email_address_settings', $result);
        $this->load->view('footer/footer');
    }

    public function setToken()
    {
        $token = $this->input->post('token', true);

        if(!empty($token))
        {
            $user_id = (!empty($this->user_id) and is_numeric($this->user_id)) ? $this->user_id : 0;
            $this->Notification_model->setToken($token, $this->date, $user_id);
        }
    }

    public function sendBrowserNotifications()
    {
        /*$this->load->view('header/header_admin', $this->page_data);
        $this->load->view('header/admin');*/

        $url = 'https://fcm.googleapis.com/fcm/send';
        //$YOUR_API_KEY = 'AIzaSyAobMYxn_4_7n_KobO12m6ZKKhJmlTpLJ8'; // Server key
        //$YOUR_API_KEY = 'BL_k7Ds8BjXIPenTiw0FCJt_dPvJWXhsS8QSR78WJ9eYgqnyJL5YfTCYBt5VBd0Fju8XjzrWS4M3arnTSeGBWuo'; // Server key
        $YOUR_API_KEY = 'AAAAHtNiGgE:APA91bGe5uluRyYoZGUi5vzpFCnJz9EWPGW2MLDL6aixVMj4SLMZmGBHTR7FWvKGN5VLO9J_nQgQXgFdRg34LMm_6UgA1cFkAL6uPB7heE8hRGuRAfMSqb3d8k5yHFyLsOPL0YDimj_SpYmCcoqtQRT0kR-PgvVUDQ'; // Server key

        $tokens = $this->Notification_model->getTokens();

        $request_body = array(
            'notification' => array(
                'title' => 'Superbody.pro',
                'body' => 'Тест уведомления',
                'icon' => 'https://superbody.pro/logo/128.png',
                'click_action' => 'https://superbody.pro/',
            )
            , 'to' => 'eWmB72NDDsQ:APA91bG0OJxG7IGgIav45-vN4nd-ee2bgOu-ulhVRxbDTjEr72Q0CZtJU-Da9TonE5x_4R99XoeT0_oCe0U0BZUpO-RHq0Jj9Gvo7Zw4sDw1OSpMwJB2awL1IZgj7R45MYyMyFZB9EuR'
            /*, 'to' => '/topics/all'*/
        );
        /*if(!empty($tokens['tokens']) and count($tokens['tokens']) === 1)
        {
            $request_body['to'] = $tokens['tokens'][0];
        }
        elseif(!empty($tokens['tokens']))
        {
            foreach ($tokens['tokens'] as $token)
            {
                $request_body['registration_ids'][] = $token;
            }
            unset($token);
        }*/
        $fields = json_encode($request_body);

        $request_headers = [
            'Content-Type:application/json',
            'Authorization:key=' . $YOUR_API_KEY
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $request_headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        $response = curl_exec($ch);
        curl_close($ch);

        echo $response;

        /*$this->load->view('footer/footer');*/
    }
}