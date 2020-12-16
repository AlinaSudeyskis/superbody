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

    /**
     * Уведомления
     *
     * @param string $type
     */
    public function notifications($type = 'users')
    {
        $type = ($type == 'users' or $type == 'system') ? $type : null;
        $result = array();

        if (empty($this->user_id) or 3 != $this->session->user['type'] or $this->session->user['blocked'] == 1 or empty($type) )
        {
            parent::pageNotFound($this->page_url);
        }

        if($type == 'users')
        {
            $result['notifications'] = $this->Notification_model->getListUsersNotifications();
        }
        elseif($type == 'system')
        {
            $result['notifications'] = $this->Notification_model->getListNotifications();
        }

        // Объединенные данные страница
        $this->page_data['title'] = 'АП - Уведомления';
        $this->page_data['page_menu'] = 'notifications';
        $this->page_data['page_submenu'] = ($type == 'users') ? 'notif_users' : 'notif_system';

        $this->load->view('header/header_admin', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('notification/notifications', $result);
        $this->load->view('footer/footer');
    }

    /**
     * Форма редактирования данных уведомления
     *
     * @param string $notification_type
     * @param $notification_id
     */
    public function notification($notification_type, $notification_id)
    {
        if (empty($this->user_id) or 3 != $this->session->user['type'] or $this->session->user['blocked'] == 1)
        {
            parent::pageNotFound($this->page_url);
        }

        $notification_type = ($notification_type == 'system') ? 'system' : 'users';
        $result = array();

        if($notification_type == 'system')
        {
            $result = $this->Notification_model->getNotification($notification_id);
        }
        elseif($notification_type == 'users')
        {
            $result = $this->Notification_model->getUserNotification($notification_id);
        }

        if($this->input->post('bt_save_notification', true))
        {
            $types = array('error', 'info');

            $type        = (in_array($this->input->post('s_type', true), $types)) ? $this->input->post('s_type', true) : 'error';
            $description = mb_substr(strip_tags($this->input->post('ta_description', true)), 0, 100);

            if((!empty($description) and $description != $result['notification']['text']) or (!empty($type) and $type != $result['notification']['type']))
            {
                $res_up = $this->Notification_model->updateNotification($notification_id, $type, $description, $this->user_id, $this->date);

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
            else
            {
                // Не сохранено
                $this->session->set_tempdata('message', 212, 60);
            }

            header('Location: /administration/notification/' . $notification_id);
        }
        elseif($this->input->post('bt_save_user_notification', true))
        {
            $notif_db_data = $result['notification'];

            $notif_text = mb_substr($this->input->post('ta_text', true), 0, 65000);

            $i_date  = $this->input->post('i_date', true);
            $tm_date = DateTime::createFromFormat('Y-m-d', $i_date);
            $notif_date = ($i_date != '' and $tm_date !== false) ? $tm_date->format('Y-m-d') : '';

            $i_time  = $this->input->post('i_time', true);
            $tm_time = DateTime::createFromFormat('H:i', $i_time);
            $notif_time = ($i_time != '' and $tm_time !== false) ? $tm_time->format('H:i') : '';

            $users_group = ($this->input->post('s_users_group', true) == 'group') ? 'group' : 'all';
            $sel_users = array();

            if($users_group == 'group')
            {
                $i_users = $this->input->post('users', true);

                foreach($i_users as $i_user)
                {
                    if(is_numeric($i_user) and !in_array($i_user, $notif_db_data['users_ids']))
                    {
                        $sel_users['insert'][] = $i_user;
                    }
                }
                unset($i_user);

                $sel_users['delete'] = array_diff($notif_db_data['users_ids'], $i_users);
            }

            if($notif_db_data['text'] != $notif_text or $notif_db_data['date'] != $notif_date or $notif_db_data['time'] != $notif_time
                or $notif_db_data['users_group'] != $users_group)
            {

                $result = $this->Notification_model->updateUserNotification($notification_id, $notif_text, $notif_date, $notif_time, $users_group, $sel_users, $this->date);

                if(is_numeric($result))
                {
                    // Сохранено
                    $this->session->set_tempdata('message', 10, 60);
                }
                elseif($result === false)
                {
                    // Не сохранено
                    $this->session->set_tempdata('message', 212, 60);
                }

                header('Location: /administration/notification/users/'. $notification_id);
            }
        }

        // Объединенные данные страница
        $this->page_data['title'] = 'АП - Уведомления';
        $this->page_data['page_menu'] = 'notifications';
        $this->page_data['page_submenu'] = ($notification_type == 'users') ? 'notif_users' : 'notif_system';

        $this->load->view('header/header_admin', $this->page_data);
        $this->load->view('header/admin');
        if($notification_type == 'system')
        {
            $this->load->view('notification/notification_settings', $result);
        }
        elseif($notification_type == 'users')
        {
            $this->load->view('notification/user_notification_settings', $result);
        }
        $this->load->view('footer/footer');
    }

    /**
     * Форма добавления уведомления для пользователя
     */
    public function newUserNotification()
    {
        if (empty($this->user_id) or 3 != $this->session->user['type'] or $this->session->user['blocked'] == 1)
        {
            parent::pageNotFound($this->page_url);
        }

        if($this->input->post('bt_save_notification', true))
        {
            $notif_text = mb_substr($this->input->post('ta_text', true), 0, 65000);

            $i_date  = $this->input->post('i_date', true);
            $tm_date = DateTime::createFromFormat('Y-m-d', $i_date);
            $notif_date = ($i_date != '' and $tm_date !== false) ? $tm_date->format('Y-m-d') : '';

            $i_time  = $this->input->post('i_time', true);
            $tm_time = DateTime::createFromFormat('H:i', $i_time);
            $notif_time = ($i_time != '' and $tm_time !== false) ? $tm_time->format('H:i') : '';

            $users_group = ($this->input->post('s_users_group', true) == 'group') ? 'group' : 'all';
            $sel_users = array();

            if($users_group == 'group')
            {
                $i_users = $this->input->post('users', true);

                foreach($i_users as $i_user)
                {
                    if(is_numeric($i_user))
                    {
                        $sel_users['insert'][] = $i_user;
                    }
                }
                unset($i_user);
            }

            if(!empty($notif_text) and !empty($notif_date) and !empty($notif_time))
            {
                $result = $this->Notification_model->setUserNotification($notif_text, $notif_date, $notif_time, $users_group, $sel_users, $this->date);

                if(is_numeric($result))
                {
                    // Сохранено
                    $this->session->set_tempdata('message', 10, 60);
                    header('Location: /administration/notification/users/'. $result);
                }
                elseif($result === false)
                {
                    // Не сохранено
                    $this->session->set_tempdata('message', 212, 60);
                    header('Location: /administration/notification/users/new');
                }
            }
        }

        // Объединенные данные страница
        $this->page_data['title'] = 'АП - Уведомления';
        $this->page_data['page_menu'] = 'notifications';
        $this->page_data['page_submenu'] = 'notif_users';

        $this->load->view('header/header_admin', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('notification/new_user_notification');
        $this->load->view('footer/footer');
    }

    /**
     * Уведомления для пользозвателя
     */
    public function getUserNotifications()
    {
        $user_id = (is_numeric($this->input->get('user_id', true))) ? $this->input->get('user_id', true) : null;
        $result  = null;

        if(!empty($user_id))
        {
            $result = $this->Notification_model->getUserNotifications($user_id, $this->date);
        }
        else
        {
            $result['error'] = 'Некорректный ID пользователя';
        }

        echo json_encode($result, JSON_NUMERIC_CHECK);
    }

    /**
     * Сохранить уведомления для пользозвателя как прочитанные
     */
    public function setUserNotifications()
    {
        $user_id = (is_numeric($this->input->get('user_id', true))) ? $this->input->get('user_id', true) : null;
        $notifications_id = (is_array($this->input->get('notif_ids', true))) ? $this->input->get('notif_ids', true) : null;

        $result  = null;

        if(!empty($user_id) and !empty($notifications_id))
        {
            $result = $this->Notification_model->setUserNotificationsRead($user_id, $notifications_id, $this->date);
        }
        else
        {
            $result['error'] = 'Некорректный ID пользователя и/или ID уведомлений';
        }

        echo json_encode($result, JSON_NUMERIC_CHECK);
    }

    public function sendEmails()
    {
        if (empty($this->user_id) or 3 != $this->session->user['type'] or $this->session->user['blocked'] == 1)
        {
            parent::pageNotFound($this->page_url);
        }

        $addresses = $this->Notification_model->getListEmailsAddresses();

        if($this->input->post('bt_send_emails', true))
        {
            $email_from     = $this->input->post('s_email_address', true);
            $recipients     = ($this->input->post('s_recipient', true) == 'several') ? 'several' : 'all';
            $subject        = $this->input->post('email_subject', true);
            $text           = $this->input->post('email_text', true);
            $selected_users = array();

            if($recipients == 'several')
            {
                $selected_users = $this->input->post('users', true);
            }

            if(!empty($email_from) and !empty($recipients) and !empty($subject) and !empty($text))
            {
                $res_ins = $this->Notification_model->setUserEmail($email_from, $recipients, $selected_users, $subject, $text, $this->user_id, $this->date);

                if($res_ins['result'] === true)
                {
                    if(!empty($res_ins['users']))
                    {
                        $email_address = $this->Notification_model->getEmailAddress($email_from);
                        $email['text'] = $text;

                        $site_info  = $this->page_data['site_info'];

                        $headers   = "Content-type: text/html; charset=utf-8 \r\n";
                        $headers   .= "From: " . $email_address['address']['name'] . "<" . $email_address['address']['email'] . ">\r\n";
                        $headers   .= "Reply-To: " . $email_address['address']['email'] . "\r\n";

                        foreach($res_ins['users'] as $sel_user)
                        {
                            $recipient_email = $sel_user['email'];
                            $recipient_id = $sel_user['id'];
                            $email_to = "<".$sel_user['email'].">";

                            ob_start();
                            include('./app_fold/views/email/email_parts/full_page.php');
                            $message = ob_get_contents();
                            ob_end_clean();

                            mail($email_to, $subject, $message, $headers);
                        }
                    }

                    // Сохранено
                    $this->session->set_tempdata('message', 10, 60);

                    header('Location: /administration/sent/email/'.$res_ins['sent_email_id']);
                }
            }
            else
            {
                $this->session->set_tempdata('message', 29, 60);
                header('Location: /administration/send/email/new');
            }
        }

        // Объединенные данные страница
        $this->page_data['title']        = 'АП - Эл. письма';
        $this->page_data['page_menu']    = 'emails';
        $this->page_data['page_submenu'] = 'sent_emails';

        $this->load->view('header/header_admin', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('email/send_email', $addresses);
        $this->load->view('footer/footer');
    }

    public function sentEmails()
    {
        if (empty($this->user_id) or 3 != $this->session->user['type'] or $this->session->user['blocked'] == 1)
        {
            parent::pageNotFound($this->page_url);
        }

        $result = $this->Notification_model->getSentEmails();

        // Объединенные данные страница
        $this->page_data['title']        = 'АП - Эл. письма';
        $this->page_data['page_menu']    = 'emails';
        $this->page_data['page_submenu'] = 'sent_emails';

        $this->load->view('header/header_admin', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('email/sent_emails', $result);
        $this->load->view('footer/footer');
    }

    /**
     * @param $email_id
     */
    public function sentEmail($email_id)
    {
        if (empty($this->user_id) or 3 != $this->session->user['type'] or $this->session->user['blocked'] == 1)
        {
            parent::pageNotFound($this->page_url);
        }

        $email = $this->Notification_model->getSentEmail($email_id);
        $email_address = $this->Notification_model->getEmailAddress($email['sent_email']['address_id']);
        $result = array_merge($email, $email_address);

        // Объединенные данные страница
        $this->page_data['title']        = 'АП - Эл. письма';
        $this->page_data['page_menu']    = 'emails';
        $this->page_data['page_submenu'] = 'sent_emails';

        $this->load->view('header/header_admin', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('email/sent_email', $result);
        $this->load->view('footer/footer');
    }

    public function systemEmails()
    {
        if (empty($this->user_id) or 3 != $this->session->user['type'] or $this->session->user['blocked'] == 1)
        {
            parent::pageNotFound($this->page_url);
        }

        $result = $this->Notification_model->getListEmails();

        // Объединенные данные страница
        $this->page_data['title']        = 'АП - Эл. письма';
        $this->page_data['page_menu']    = 'emails';
        $this->page_data['page_submenu'] = 'system_emails';

        $this->load->view('header/header_admin', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('email/system_emails', $result);
        $this->load->view('footer/footer');
    }

    /**
     * Форма редактирования эл. писем
     *
     * @param $email_id
     */
    public function systemEmail($email_id)
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
        $this->page_data['page_submenu'] = 'system_emails';

        $this->load->view('header/header_admin', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('email/system_email_settings', $result);
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