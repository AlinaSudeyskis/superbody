<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Authorization class
 *
 * Класс авторизации: регистрация, авторизация, выход из системы.
 *
 * @author Alina Sudeyskis <alina.sudeyskis@gmail.com>
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */

class Authorization extends CI_Controller
{
    /**
     * Authorization constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Authorization_model');
    }

    /**
     * Регистрация пользователя. Отправка письма для подтвержения регистрации.
     *
     * @return void
     */
    public function registration()
    {
        // Переадресация в случае, если пользователь уже авторизован
        if (!empty($this->user_id)) {
            header('Location: /');
        }

        // Проверка введенных данных и сохранение в БД
        if($this->input->post('bt_registry', true))
        {
            if ($this->input->post('cb_politics', true))
            {
                // Валидация E-mail
                $email = (!empty($this->input->post('email', true))  and filter_var($this->input->post('email', true), FILTER_VALIDATE_EMAIL))
                    ? $this->input->post('email', true)
                    : null;
                $email_hash = (!empty($email)) ? password_hash($email, PASSWORD_DEFAULT) : null;

                // Пароль
                $password         = $this->input->post('password', true);
                $password_confirm = $this->input->post('password_confirm', true);
                $password_hash    = null;

                // Хэширование пароля
                if (!empty($password) and $password === $password_confirm)
                {
                    $password_hash = password_hash($password, PASSWORD_DEFAULT);
                }

                // Сохранение данных в БД
                if (!empty($email) and !empty($password_hash))
                {
                    $result_registration = $this->Authorization_model->userRegistration($email, $password_hash, $email_hash, $this->date);

                    if (is_numeric($result_registration))
                    {
                        $reg_user_id = $result_registration;

                        // Отправка письма с активацией почты
                        $system_message['text']  = '<b><a href="https://superbody.pro/activate?e=' . $email . '&ac=' . $email_hash
                            . '" style="display: inline-block; width:100%; text-align:center; padding:0; margin:0">';
                        $system_message['text']  .= 'Активировать';
                        $system_message['text']  .= '</a></b>';

                        parent::sendEmail(17, $email, $system_message);

                        // Обновление данных сессии
                        $user_type = 1;
                        $user_blocked = 0;
                        $user_name = '';
                        $user_phone = '';
                        $user_image = '';
                        $access_token = '';
                        $user_soc_via = 'native';
                        $user_soc_id = 0;

                        parent::updateSession($reg_user_id, $email, $user_type, $user_blocked, $user_name, $user_phone,
                            $user_image, $access_token, $user_soc_via, $user_soc_id, $this->date);

                        // После успешной регистрации переход на страницу анкеты
                        header('Location: /questionnaire');
                    }
                    else
                    {
                        if ($result_registration == 'e1')
                        {
                            // Пользователь с таким E-mail существует
                            $this->session->set_tempdata('message', 1, 60);
                            header('Location: /registry');
                        }
                        else
                        {
                            // Не удалось сохранить запись в БД
                            $this->session->set_tempdata('message', 2, 60);
                            header('Location: /registry');
                        }
                    }
                }
                else
                {
                    // Не все поля для регистрации были заполнены
                    $this->session->set_tempdata('message', 8, 60);
                    header('Location: /registry');
                }
            }
            else
            {
                // Нет подтверждения использования персональных данных
                $this->session->set_tempdata('message', 128, 60);
                header('Location: /registry');
            }
        }
        elseif($this->input->post('bt_facebook_login', true) and $this->input->post('cb_politics', true))
        {
            self::facebookLogin();
        }
        elseif($this->input->post('bt_ok_login', true) and $this->input->post('cb_politics', true))
        {
            self::okLogin();
        }
        elseif($this->input->post('bt_vk_login', true) and $this->input->post('cb_politics', true))
        {
            self::vkLogin();
        }
        elseif($this->input->post('bt_insta_login', true) and $this->input->post('cb_politics', true))
        {
            self::instagramLogin();
        }

        // Объединенные данные страница
        $this->page_data['title'] = 'Регистрация';
        $this->page_data['page_menu'] = '';

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/secondary');
        $this->load->view('authorization/registration');
        $this->load->view('footer/footer');
    }

    /**
     * Авторизация пользователя
     *
     * @return void
     */
    public function login()
    {
        // Переадресация в случае, если пользователь уже авторизован
        if (!empty($this->user_id)) {
            header('Location: /');
        }

        $registration = false;
        $reg_data     = null;

        // Проверка введенных данных, поиск пользователя в БД
        if ($this->input->post('bt_login', true) and $this->input->post('cb_politics', true))
        {
            if ($this->input->post('cb_politics', true))
            {
                // Валидация E-mail
                $email = (!empty($this->input->post('email', true)) and filter_var($this->input->post('email', true), FILTER_VALIDATE_EMAIL))
                    ? $this->input->post('email', true)
                    : null;

                $password = $this->input->post('password', true);

                // Авторизация пользователя
                if (!empty($email) and !empty($password))
                {
                    $result = $this->Authorization_model->userAuthorization($email, $password, $this->date);

                    if (is_array($result))
                    {
                        $user_image = (!empty($result['user_image'])) ? $result['user_image'] : $result['user_soc_image'];

                        parent::updateSession($result['user_id'], $result['user_email'], $result['user_type'], $result['user_blocked'],
                            $result['user_name'], $result['user_phone'], $user_image, '', 'native', 0, $this->date);

                        // После успешной авторизации переход на страницу пользователя
                        header('Location: /profile/'.$result['user_id']);
                    }
                    elseif($result == 'error_password')
                    {
                        // Не верный E-mail или пароль
                        $this->session->set_tempdata('message', 7, 60);
                        header('Location: /login');
                    }
                    elseif($result == 'error_user')
                    {
                        $registration      = true;
                        $reg_data['email'] = $email;
                    }
                }
                else
                {
                    // Не корректный E-mail
                    $this->session->set_tempdata('message', 6, 60);
                    header('Location: /login');
                }
            }
            else
            {
                // Нет подтверждения использования персональных данных
                $this->session->set_tempdata('message', 128, 60);
                header('Location: /login');
            }
        }
        elseif($this->input->post('bt_facebook_login', true) and $this->input->post('cb_politics', true))
        {
            $email = (filter_var($this->input->post('email', true), FILTER_VALIDATE_EMAIL)) ? $this->input->post('email', true) : '';
            $return = $this->input->post('hi_return', true);

            self::facebookLogin($email, $return);
        }
        elseif($this->input->post('bt_ok_login', true) and $this->input->post('cb_politics', true))
        {
            $email = (filter_var($this->input->post('email', true), FILTER_VALIDATE_EMAIL)) ? $this->input->post('email', true) : '';
            $return = $this->input->post('hi_return', true);

            self::okLogin($email, $return);
        }
        elseif($this->input->post('bt_vk_login', true) and $this->input->post('cb_politics', true))
        {
            $email = (filter_var($this->input->post('email', true), FILTER_VALIDATE_EMAIL)) ? $this->input->post('email', true) : '';
            $return = $this->input->post('hi_return', true);

            self::vkLogin($email, $return);
        }
        elseif($this->input->post('bt_insta_login', true) and $this->input->post('cb_politics', true))
        {
            $email = (filter_var($this->input->post('email', true), FILTER_VALIDATE_EMAIL)) ? $this->input->post('email', true) : '';
            $return = $this->input->post('hi_return', true);

            self::instagramLogin($email, $return);
        }
        
        // Объединенные данные страница
        $this->page_data['title'] = 'Авторизация';

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/secondary');

        if($registration === false)
        {
            $this->load->view('authorization/login');
        }
        else
        {
            $this->load->view('authorization/registration', $reg_data);
        }

        $this->load->view('footer/footer');
    }

    /**
     * Выход из системы
     *
     * @return void
     */
    public function logout()
    {
        if ($this->session->user['auth_via'] == 'native')
        {
            $this->Authorization_model->userLogout($this->session->user['id'], $this->date);
        }
        else
        {
            $this->Authorization_model->userSocialLogout($this->session->user['auth_via'], $this->session->user['social_id'], $this->date);
        }

        $this->session->sess_destroy();
        header('Location: /');
    }

    /**
     * Активация пользователя
     *
     * @return void
     */
    public function userActivate()
    {
        $email         = (filter_var($this->input->get('e'), FILTER_VALIDATE_EMAIL)) ? $this->input->get('e') : null;
        $activate_code = strip_tags($this->input->get('ac'));

        $account = $this->Authorization_model->getUserAccountData($email, $activate_code);

        if (is_array($account) and $account['activated'] === true)
        {
            header('Location: /activated');
        }
        elseif($account === false)
        {
            parent::pageNotFound($this->page_url);
        }

        // Валидация E-mail
        if (!empty($email) and $this->input->post('bt_activate', true))
        {
            // Получение ID и код активации пользователя
            $result = $this->Authorization_model->getActivateCode($email);

            if ($result !== false)
            {
                $user_id            = $result['user_id'];
                $user_password      = $result['user_password'];
                $user_activate_code = $result['user_activate_code'];
                $password           = $this->input->post('i_password', true);
                $confirm_password   = $this->input->post('i_confirm_password', true);

                if (password_verify($email, $user_activate_code) and $activate_code == $user_activate_code)
                {
                    if ($password === $confirm_password and password_verify($password, $user_password))
                    {
                        // Активация пользователя
                        $res_activate = $this->Authorization_model->activateUser($user_id, $this->date);

                        if ($res_activate === true)
                        {
                            parent::sendPulseAddEmails($email);
                            // Аккаунт активирован.
                            $this->session->set_tempdata('message', 20, 60);
                            header('Location: /activated');
                        }
                        else
                        {
                            // Аккаунт не активирован.
                            $this->session->set_tempdata('message', 3, 60);

                            $url_data = array(
                                'e' => $this->input->get('e'),
                                'ac' => $this->input->get('ac')
                            );
                            header('Location: /activate?' . http_build_query($url_data));
                        }
                    }
                    else
                    {
                        // Пароли не совпадают.
                        $this->session->set_tempdata('message', 132, 60);

                        $url_data = array(
                            'e' => $this->input->get('e'),
                            'ac' => $this->input->get('ac')
                        );
                        header('Location: /activate?' . http_build_query($url_data));
                    }
                }
                else
                {
                    // Аккаунт не активирован. Неверный код активации.
                    $this->session->set_tempdata('message', 4, 60);

                    $url_data = array(
                        'e' => $this->input->get('e'),
                        'ac' => $this->input->get('ac')
                    );
                    header('Location: /activate?' . http_build_query($url_data));
                }
            }
            else
            {
                // Пользователь не найден
                $this->session->set_tempdata('message', 136, 60);

                $url_data = array(
                    'e' => $this->input->get('e'),
                    'ac' => $this->input->get('ac')
                );
                header('Location: /activate?' . http_build_query($url_data));
            }
        }
        elseif(empty($email))
        {
            // Не корректный E-mail
            $this->session->set_tempdata('message', 6, 60);

            $url_data = array(
                'e' => $this->input->get('e'),
                'ac' => $this->input->get('ac')
            );
            header('Location: /activate?' . http_build_query($url_data));
        }


        // Объединенные данные страница
        $this->page_data['title'] = 'Активация аккаунта';
        $this->page_data['page_menu'] = '';

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/secondary');
        $this->load->view('authorization/activate', $account);
        $this->load->view('footer/footer');
    }

    public function userActivated()
    {
        // Объединенные данные страница
        $this->page_data['title'] = 'Активация аккаунта';
        $this->page_data['page_menu'] = '';

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/secondary');
        $this->load->view('authorization/activated');
        $this->load->view('footer/footer');
    }

    /**
     * Восставновление пароля.
     *
     * Отправка письма пользователю с новым паролем
     *
     * @return void
     * @throws Exception
     */
    public function restorePassword()
    {
        // Переадресация в случае, если пользователь уже авторизован
        if (!empty($this->user_id)) {
            header('Location: /');
        }

        $restore_password = false;

        // Проверка введенных данных и сохранение в БД
        if($this->input->post('bt_restore', true))
        {
            $email      = null;
            $idempotent = null;
            $today      = $this->date;
            $date_in_an_hour = null;

            // Валидация E-mail
            if (!empty($this->input->post('email', true))
                && filter_var($this->input->post('email', true), FILTER_VALIDATE_EMAIL))
            {
                $email      = $this->input->post('email', true);
                $idempotent = password_hash($today, PASSWORD_DEFAULT);

                // Дата и время через час после сохранения данных о восстановлении пароля
                $tmp_date = new DateTime($today);
                $tmp_date->add(new DateInterval('PT1H'));
                $date_in_an_hour = $tmp_date->format('Y-m-d H:i:s');
            }

           /* // Генерация пароля
            $arr = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','r','s',
                't','u','v','x','y','z','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','R','S',
                'T','U','V','X','Y','Z','1','2','3','4','5','6','7','8','9','0','.',',','(',')','[',']','!','?',
                '&','^','%','@','*','$','<','>','/','|','+','-','{','}','`','~');
            $password = "";
            for($i = 0; $i < 8; $i++)
            {
                // Вычисляем случайный индекс массива
                $index = rand(0, count($arr) - 1);
                $password .= $arr[$index];
            }

            // Хэширование пароля
            if (!empty($password)) {
                $password_hash = password_hash($password, PASSWORD_DEFAULT);
            } else {
                $password_hash = null;
            }*/

            // Сохранение данных в БД, отправка письма
            if (!empty($email))
            {
                $result_restore = $this->Authorization_model->setRestore($email, $idempotent, $today);

                if ($result_restore === true)
                {
                    $user = $this->Authorization_model->getActivateCode($email);
                    $user_hash = $user['user_activate_code'];

                    // Отправление письма с указаниями по восстановлению пароля
                    $system_message['text']  = '<p>Обновить пароль Вы можете до ' . $date_in_an_hour . '</p> </br>';
                    $system_message['text']  .= '<b><a href="https://superbody.pro/restore?e=' . $email . '&ac=' . $user_hash . '&i=' . $idempotent
                        . '" style="display: inline-block; width:100%; text-align:center; padding:0; margin:0">';
                    $system_message['text']  .= 'Восстановить пароль';
                    $system_message['text']  .= '</a></b>';

                    parent::sendEmail(3, $email, $system_message);
                    
                    // Письмо отправлено
                    $this->session->set_tempdata('message', 46, 60);

                }
                else {
                    // Пользователь с таким E-mail не существует
                    $this->session->set_tempdata('message', 47, 60);
                }
            }
            else
            {
                // Не корректный E-mail
                $this->session->set_tempdata('message', 6, 60);
            }

            header('Location: /restore');
        }
        elseif(!empty($this->input->get('e', true)) and !empty($this->input->get('ac', true))
            and !empty($this->input->get('i', true)) and empty($this->input->post('bt_restore_password', true)))
        {
            $email      = filter_var($this->input->get('e', true), FILTER_VALIDATE_EMAIL) ? $this->input->get('e', true) : null;
            $code       = mb_substr(strip_tags($this->input->get('ac', true)), 0, 255);
            $idempotent = mb_substr(strip_tags($this->input->get('i', true)), 0, 255);

            if(!empty($email) and !empty($code) and !empty($idempotent) and password_verify($email, $code))
            {
                $result_restore = $this->Authorization_model->checkRestore($email, $code, $idempotent, $this->date);

                // Доступ к странице ввода нового пароля
                if($result_restore === true)
                {
                    $restore_password = true;
                }
            }
            else
            {
                parent::pageNotFound(__METHOD__ . ' ' . __LINE__ . ' ' . $this->page_url);
            }
        }
        elseif(!empty($this->input->get('e', true)) and !empty($this->input->get('ac', true))
            and !empty($this->input->get('i', true)) and $this->input->post('bt_restore_password', true))
        {
            $password           = $this->input->post('i_password', true);
            $confirm_password   = $this->input->post('i_confirm_password', true);

            $email      = filter_var($this->input->get('e', true), FILTER_VALIDATE_EMAIL) ? $this->input->get('e', true) : null;
            $code       = mb_substr(strip_tags($this->input->get('ac', true)), 0, 255);
            $idempotent = mb_substr(strip_tags($this->input->get('i', true)), 0, 255);

            if(!empty($email) and !empty($code) and !empty($idempotent) and password_verify($email, $code))
            {
                $result_restore = $this->Authorization_model->checkRestore($email, $code, $idempotent, $this->date);

                // Доступ к странице ввода нового пароля
                if($result_restore === true)
                {
                    $restore_password = true;
                }
            }

            if($password === $confirm_password and $restore_password === true)
            {
                $password_hash = password_hash($this->input->post('i_password', true), PASSWORD_DEFAULT);

                $up_pass = $this->Authorization_model->updatePassword($email, $code, $idempotent, $password_hash, $this->date);

                if($up_pass === true)
                {
                    // Пароль изменен
                    $this->session->set_tempdata('message', 133, 60);
                    header('Location: /');
                }
                else
                {
                    // Пароль не изменен
                    $this->session->set_tempdata('message', 48, 60);
                    header('Location: /restore');
                }
            }
            else
            {
                // Пароли не совпадают
                $this->session->set_tempdata('message', 132, 60);
                header('Location: /restore');
            }
        }

        // Объединенные данные страница
        $this->page_data['title'] = 'Восставновление пароля';
        $this->page_data['page_menu'] = '';

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/secondary');
        if($restore_password === true)
        {
            $this->load->view('authorization/new_password');
        }
        else
        {
            $this->load->view('authorization/restore_password');
        }
        $this->load->view('footer/footer');
    }

    public function blockAccount()
    {
        $email = $this->input->get('e');
        $activate_code = $this->input->get('ac');

        // Валидация E-mail
        /*if (!empty($email) and filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            // Получение ID и код активации пользователя
            $result = $this->Authorization_model->getActivateCode($email);

            if ($result !== false) {
                $user_id            = $result['user_id'];
                $user_activate_code = $result['user_activate_code'];

                // Активация пользователя
                if (password_verify($email, $user_activate_code) and $activate_code == $user_activate_code) {
                    $this->Authorization_model->activateUser($user_id);

                    // Аккаунт активирован.
                    $this->session->set_tempdata('message', 20, 60);
                } else {
                    // Аккаунт не активирован. Неверный код активации.
                    $this->session->set_tempdata('message', 4, 60);
                }
            } else {
                // Пользователь не найден
                $this->session->set_tempdata('message', 136, 60);
            }
        } else {
            // Не корректный E-mail
            $this->session->set_tempdata('message', 6, 60);
        }*/
    }

    /**
     * Подтверждение смены email
     * @param int $email_changed
     */
    public function confirmChangeEmail($email_changed = 0)
    {
        if (empty($this->user_id) or !is_numeric($this->user_id))
        {
            parent::pageNotFound($this->page_url);
        }

        if(!empty($this->input->get('e', true)) and !empty($this->input->get('ac', true)) and $email_changed == 0
            and !empty($this->input->get('i', true)) and empty($this->input->post('bt_confirm_change_email', true)))
        {
            $email      = filter_var($this->input->get('e', true), FILTER_VALIDATE_EMAIL) ? $this->input->get('e', true) : null;
            $code       = mb_substr(strip_tags($this->input->get('ac', true)), 0, 255);
            $idempotent = mb_substr(strip_tags($this->input->get('i', true)), 0, 255);

            if(!empty($email) and !empty($code) and !empty($idempotent) and password_verify($email, $code))
            {
                // Проверка наличия пользователя с такими данными
                $result_change = $this->Authorization_model->checkChangeEmail($email, $code, $idempotent);

                // Доступ к странице подтвердения изменения email
                if($result_change !== false)
                {
                    $result['current_email'] = $this->session->user['email'];
                    $result['new_email'] = $result_change;

                    // Объединенные данные страница
                    $this->page_data['title']     = 'Подтверждение изменения email';
                    $this->page_data['page_menu'] = '';

                    $this->load->view('header/header', $this->page_data);
                    $this->load->view('header/secondary');
                    $this->load->view('authorization/confirm_email', $result);
                    $this->load->view('footer/footer');
                }
            }
            else
            {
                parent::pageNotFound(__METHOD__ . ':' . __LINE__ . ' ' . $this->page_url);
            }
        }
        elseif(!empty($this->input->get('e', true)) and !empty($this->input->get('ac', true)) and $email_changed == 0
            and !empty($this->input->get('i', true)) and !empty($this->input->post('bt_confirm_change_email', true)))
        {
            $email      = filter_var($this->input->get('e', true), FILTER_VALIDATE_EMAIL) ? $this->input->get('e', true) : null;
            $code       = mb_substr(strip_tags($this->input->get('ac', true)), 0, 255);
            $idempotent = mb_substr(strip_tags($this->input->get('i', true)), 0, 255);

            if(!empty($email) and !empty($code) and !empty($idempotent))
            {
                // Проверка наличия пользователя с такими данными
                $result_change = $this->Authorization_model->checkChangeEmail($email, $code, $idempotent);

                // Смена email
                if($result_change !== false)
                {
                    $res_up = $this->Authorization_model->changeEmail($email, $this->date);
                    if($res_up !== false)
                    {
                        // Отправка письма с активацией новой почты
                        $system_message['text']  = '<b><a href="https://superbody.pro/activate?e=' . $res_up['new_email'] . '&ac=' . $res_up['email_code']
                            . '" style="display: inline-block; width:100%; text-align:center; padding:0; margin:0">';
                        $system_message['text']  .= 'Активировать';
                        $system_message['text']  .= '</a></b>';

                        parent::sendEmail(17, $res_up['new_email'], $system_message);

                        parent::sendPulseRemoveEmails($email);

                        // Обновление данных сессии
                        $user_data = array('user' => $this->session->user);

                        $user_data['user']['email'] = $res_up['new_email'];
                        $user_data['user']['date']  = $this->date;

                        $this->session->set_userdata($user_data);

                        header('Location: /email/changed');
                    }
                    else
                    {
                        // Email не изменен
                        $this->session->set_tempdata('message', 192, 60);

                        $url_data = array(
                            'e' => $this->input->get('e'),
                            'ac' => $this->input->get('ac'),
                            'i' => $this->input->get('i')
                        );
                        header('Location: /email/change?' . http_build_query($url_data));
                    }
                }
                else
                {
                    // Не корректные данные
                    $this->session->set_tempdata('message', 193, 60);

                    $url_data = array(
                        'e' => $this->input->get('e'),
                        'ac' => $this->input->get('ac'),
                        'i' => $this->input->get('i')
                    );
                    header('Location: /email/change?' . http_build_query($url_data));
                }
            }
            else
            {
                parent::pageNotFound(__METHOD__ . ':' . __LINE__ . ' ' . $this->page_url);
            }
        }
        elseif($email_changed == 1)
        {
            // Объединенные данные страница
            $this->page_data['title'] = 'Изменение email';
            $this->page_data['page_menu'] = '';

            $this->load->view('header/header', $this->page_data);
            $this->load->view('header/secondary');
            $this->load->view('authorization/email_changed');
            $this->load->view('footer/footer');
        }
        else
        {
            parent::pageNotFound(__METHOD__ . ':' . __LINE__ . ' ' . $this->page_url);
        }
    }

    /**
     * Подтверждение восстановление аккаунта
     * @param int $account_restored
     */
    public function restoreAccount($account_restored = 0)
    {
        if(!empty($this->input->get('e', true)) and !empty($this->input->get('ac', true)) and $account_restored == 0
            and !empty($this->input->get('i', true)) and empty($this->input->post('bt_confirm_restore_account', true)))
        {
            $email      = filter_var($this->input->get('e', true), FILTER_VALIDATE_EMAIL) ? $this->input->get('e', true) : null;
            $code       = mb_substr(strip_tags($this->input->get('ac', true)), 0, 255);
            $idempotent = mb_substr(strip_tags($this->input->get('i', true)), 0, 255);

            if(!empty($email) and !empty($code) and !empty($idempotent) and password_verify($email, $code))
            {
                // Проверка наличия пользователя с такими данными
                $result_change = $this->Authorization_model->checkRestoreAccount($email, $code, $idempotent);

                // Доступ к странице подтверждения
                if($result_change !== false)
                {
                    // Объединенные данные страница
                    $this->page_data['title']     = 'Подтверждение восстановление аккаунта';
                    $this->page_data['page_menu'] = '';

                    $this->load->view('header/header', $this->page_data);
                    $this->load->view('header/secondary');
                    $this->load->view('authorization/restore_account');
                    $this->load->view('footer/footer');
                }
            }
            else
            {
                parent::pageNotFound(__METHOD__ . ':' . __LINE__ . ' ' . $this->page_url);
            }
        }
        elseif(!empty($this->input->get('e', true)) and !empty($this->input->get('ac', true)) and $account_restored == 0
            and !empty($this->input->get('i', true)) and !empty($this->input->post('bt_confirm_restore_account', true)))
        {
            $email      = filter_var($this->input->get('e', true), FILTER_VALIDATE_EMAIL) ? $this->input->get('e', true) : null;
            $code       = mb_substr(strip_tags($this->input->get('ac', true)), 0, 255);
            $idempotent = mb_substr(strip_tags($this->input->get('i', true)), 0, 255);

            if(!empty($email) and !empty($code) and !empty($idempotent))
            {
                // Проверка наличия пользователя с такими данными
                $result_change = $this->Authorization_model->checkRestoreAccount($email, $code, $idempotent);

                // Смена email
                if($result_change === true)
                {
                    $res_up = $this->Authorization_model->restoreUserAccount($email, $this->date);
                    if($res_up === true)
                    {
                        // Отправка письма
                        parent::sendEmail(14, $email);

                        // Email не изменен
                        $this->session->set_tempdata('message', 195, 60);

                        header('Location: /account/restored');
                    }
                    else
                    {
                        // Email не изменен
                        $this->session->set_tempdata('message', 186, 60);

                        $url_data = array(
                            'e' => $this->input->get('e'),
                            'ac' => $this->input->get('ac'),
                            'i' => $this->input->get('i')
                        );
                        header('Location: /account/restore?' . http_build_query($url_data));
                    }
                }
                else
                {
                    // Не корректные данные
                    $this->session->set_tempdata('message', 115, 60);

                    $url_data = array(
                        'e' => $this->input->get('e'),
                        'ac' => $this->input->get('ac'),
                        'i' => $this->input->get('i')
                    );
                    header('Location: /account/restore?' . http_build_query($url_data));
                }
            }
            else
            {
                parent::pageNotFound(__METHOD__ . ':' . __LINE__ . ' ' . $this->page_url);
            }
        }
        elseif($account_restored == 1)
        {
            // Объединенные данные страница
            $this->page_data['title'] = 'Восстановление аккаунта';
            $this->page_data['page_menu'] = '';

            $this->load->view('header/header', $this->page_data);
            $this->load->view('header/secondary');
            $this->load->view('authorization/restored_account');
            $this->load->view('footer/footer');
        }
        else
        {
            parent::pageNotFound(__METHOD__ . ':' . __LINE__ . ' ' . $this->page_url);
        }
    }

    /**
     * Авторизация при помощи Instargram
     *
     * @param $email
     * @param $return
     */
    public function instagramLogin($email = '', $return = '')
    {
        // Instagram
        $url_authorize = 'https://api.instagram.com/oauth/authorize/';
        $url_token     = 'https://api.instagram.com/oauth/access_token';
        $client_id     = '39c0baec30bd477f9738b7630466661d';
        $client_secret = '1697413dde4f41a881516f97fce4d28a';
        $redirect_uri  = 'https://superbody.pro/instagram_login';
        $grant_type    = 'authorization_code';
        $scope         = array( 'basic' );
        $email         = (filter_var($this->input->post('email', true), FILTER_VALIDATE_EMAIL))
            ? $this->input->post('email', true)
            : $email;

        // Обработка ссылки для возврата
        if(empty($this->session->return_url))
        {
            // Данные POST или GET
            $return_data   = (!empty($this->input->post('hi_return', true))) ? $this->input->post('hi_return', true) : $this->input->get('hi_return', true);

            parent::setSessionReturnUrl($return_data, $return);

            $return      = $this->session->return_url;
            $fail_return = $this->session->fail_return_url;

            $user_data['input_email'] = $email;
            $this->session->set_userdata($user_data);
        }
        else
        {
            $return      = $this->session->return_url;
            $fail_return = $this->session->fail_return_url;
            $email       = (filter_var($this->session->input_email, FILTER_VALIDATE_EMAIL)) ? $this->session->input_email : $email;
        }

        //log_message('debug', __METHOD__ . ':' . __LINE__ . ' Session return url: ' . print_r($this->session->return_url, true));

        if ($this->input->post('bt_insta_login', true) or $this->input->post('bt_connect_instagram', true)) {
            header(
                sprintf(
                    'Location:https://api.instagram.com/oauth/authorize/?client_id=%s&redirect_uri=%s&response_type=code&scope=%s',
                    $client_id,
                    $redirect_uri,
                    implode( '+', $scope )
                )
            );
        }

        // Получен ответ от Instagram
        if ($this->input->get('code', true))
        {
            $myCurl = curl_init();
            curl_setopt_array($myCurl, array(
                CURLOPT_URL => $url_token,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_POSTFIELDS => http_build_query(array('client_id' => $client_id, 'client_secret' => $client_secret,
                    'grant_type' => $grant_type, 'redirect_uri' => $redirect_uri, 'code' => $this->input->get('code', true)))
            ));
            $response = curl_exec($myCurl);
            curl_close($myCurl);

            $resp_data = json_decode($response);

            if (!empty($resp_data->access_token))
            {
                log_message('debug', 'Instagram response ' . print_r($resp_data, true));
                $user_access_token = $resp_data->access_token;
                $expires_in        = 0;
                $expires_at        = 0;
                $issued_at         = 0;
                // Данные пользователя в соц. сети
                $user_soc_id      = $resp_data->user->id;
                $user_name        = $resp_data->user->full_name;
                $user_image       = $resp_data->user->profile_picture;
                $user_email       = (!empty($email)) ? $email : '';
                $user_birthday    = '';
                $user_gender      = '';
                $user_profile_url = (!empty($resp_data->user->username)) ? 'https://www.instagram.com/'.$resp_data->user->username : '';

                if (empty($this->session->user))
                {
                    //echo $resp_data->user->id;
                    // Сравнение данных соц. сети с данными БД -> авторизация (обновление данных) или регистрация
                    $result = $this->Authorization_model->validSocLoginId('instagram', $this->date, $user_access_token,
                        $user_soc_id, $expires_at, $issued_at, $expires_in, $user_email, $user_name, $user_image,
                        $user_birthday, $user_gender, $user_profile_url);

                    if (!empty($result['user']))
                    {
                        $user = $result['user'];

                        $user_image = (!empty($user['image'])) ? $user['image'] : $user['soc_image'];

                        parent::updateSession($user['id'], $user['email'], $user['type'], $user['blocked'], $user['name'],
                            $user['phone'], $user_image, $user['access_token'], $user['soc_via'], $user['soc_id'], $this->date);

                        $return = ($return == '/profile/' and !empty($this->session->user['id'])) ? $return . $this->session->user['id'] : $return;

                        parent::deleteSessionReturnUrl();

                        // Отправляем письмо с уведомлением об регистрации
                        if (!empty($user_email) and filter_var($user_email, FILTER_VALIDATE_EMAIL))
                        {
                            $system_message['text']  = '<b><a href="https://superbody.pro/" style="display: inline-block; width:100%; text-align:center; padding:0; margin:0">';
                            $system_message['text']  .= 'Перейти на сайт';
                            $system_message['text']  .= '</a></b>';

                            parent::sendEmail(2, $user_email, $system_message);
                        }

                        header('Location: ' . $return);
                    }
                    else
                    {
                        // Не удалось авторизоваться. Повторите попытку
                        $this->session->set_tempdata('message', 5, 60);

                        log_message('error', __METHOD__ . ':' . __LINE__ . ' Ошибка сохранения данных. $result:' . print_r($result, true));

                        parent::deleteSessionReturnUrl();

                        header('Location: ' . $fail_return);
                    }
                }
                else
                {
                    $result = $this->Authorization_model->connectSocial($this->user_id, 'instagram', $this->date, $user_access_token,
                        $user_soc_id, $user_profile_url, $expires_at, $issued_at, $expires_in);

                    if($result === true)
                    {
                        log_message('debug', __METHOD__ . ':' . __LINE__ . ' $return:' . print_r($return, true));

                        parent::deleteSessionReturnUrl();

                        header('Location: ' . $return);
                    }
                    else
                    {
                        // Не удалось присоединить соц. сеть
                        log_message('error', __METHOD__ . ':' . __LINE__ . ' Не удалось присоединить соц. сеть');

                        parent::deleteSessionReturnUrl();

                        header('Location: ' . $fail_return);
                    }
                }
            }
            else
            {
                // Не удалось получить доступ к данным. Повторите попытку
                $this->session->set_tempdata('message', 102, 60);

                log_message('error', __METHOD__ . ':' . __LINE__ . ' Ошибка авторизации. $resp_data:' . print_r($resp_data, true));

                parent::deleteSessionReturnUrl();

                header('Location: ' . $fail_return);
            }
        }
        elseif($this->input->get('error', true))
        {
            // Отказано в доступе
            $this->session->set_tempdata('message', 103, 60);

            log_message('error', __METHOD__ . ':' . __LINE__ . ' Ошибка авторизации. GET:' . print_r($this->input->get(), true));

            parent::deleteSessionReturnUrl();

            header('Location: ' . $fail_return);
        }
    }

    /**
     * Авторизация при помощи Vkontakte
     *
     * @param $email
     * @param $return
     */
    public function vkLogin($email = '', $return = '')
    {
        // Instagram
        $url_authorize = 'https://oauth.vk.com/authorize?v=5.73';
        $url_token     = 'https://oauth.vk.com/access_token?v=5.73';
        $client_id     = '6241173';
        $client_secret = 'sbeAsVwV4nZP57upZCrS';
        $redirect_uri  = 'https://superbody.pro/vk_login';
        $scope         = array( 'email', 'offline' );
        $email         = (filter_var($this->input->post('email', true), FILTER_VALIDATE_EMAIL))
            ? $this->input->post('email', true)
            : $email;

        // Обработка ссылки для возврата
        if(empty($this->session->return_url))
        {
            // Данные POST или GET
            $return_data   = (!empty($this->input->post('hi_return', true))) ? $this->input->post('hi_return', true) : $this->input->get('hi_return', true);

            parent::setSessionReturnUrl($return_data, $return);

            $return      = $this->session->return_url;
            $fail_return = $this->session->fail_return_url;

            $user_data['input_email'] = $email;
            $this->session->set_userdata($user_data);
        }
        else
        {
            $return      = $this->session->return_url;
            $fail_return = $this->session->fail_return_url;
            $email       = (filter_var($this->session->input_email, FILTER_VALIDATE_EMAIL)) ? $this->session->input_email : $email;
        }

        //log_message('debug', __METHOD__ . ':' . __LINE__ . ' Session return url: ' . print_r($this->session->return_url, true));

        if ($this->input->post('bt_vk_login', true) or $this->input->post('bt_connect_vk', true))
        {
            header(
                sprintf(
                    'Location:https://oauth.vk.com/authorize??v=5.73&client_id=%s&display=popup&redirect_uri=%s&scope=%s&response_type=code',
                    $client_id,
                    $redirect_uri,
                    implode( ',', $scope )
                )
            );
        }

        // Получен ответ от VK
        if (!empty($this->input->get('code', true)))
        {
            $myCurl = curl_init();
            curl_setopt_array($myCurl, array(
                CURLOPT_URL => $url_token,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_POSTFIELDS => http_build_query(array('client_id' => $client_id, 'client_secret' => $client_secret,
                    'redirect_uri' => $redirect_uri, 'code' => $this->input->get('code', true)))
            ));
            $response = curl_exec($myCurl);
            curl_close($myCurl);

            $resp_data = json_decode($response);

            // Получен ACCESS_TOKEN для дальнейшей работы
            if (!empty($resp_data->access_token))
            {
                // Данные пользователя в соц. сети
                $user_access_token = $resp_data->access_token;
                $expires_in        = $resp_data->expires_in;
                $expires_at        = 0;
                $issued_at         = 0;

                $user_soc_id    = $resp_data->user_id;
                $user_soc_email = !empty($email) ? $email : $resp_data->email;

                // Получение подробной информации о пользователе
                $myCurl = curl_init();
                curl_setopt_array($myCurl, array(
                    CURLOPT_URL => 'https://api.vk.com/method/users.get?v=5.73',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_POST => true,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_POSTFIELDS => http_build_query(array('user_ids' => $user_soc_id, 'access_token' => $user_access_token,
                        'fields' => 'id,first_name,last_name,screen_name,sex,bdate,photo_200'))
                ));
                $response = curl_exec($myCurl);
                curl_close($myCurl);
                $resp_info = json_decode($response);

                if (!empty($resp_info->response))
                {
                    //log_message('debug', __METHOD__ . ':' . __LINE__ . ' Данные ответа соц. сети. $resp_info:' . print_r($resp_info, true));

                    $user_soc_id     = $resp_info->response[0]->id;
                    $user_soc_name   = $resp_info->response[0]->last_name . ' ' . $resp_info->response[0]->first_name;
                    $user_soc_image  = is_file($resp_info->response[0]->photo_200) ? $resp_info->response[0]->photo_200 : '';
                    $user_soc_bd     = !empty($resp_info->response[0]->bdate) ? $resp_info->response[0]->bdate : '';
                    $user_soc_gender = !empty($resp_info->response[0]->sex) ? $resp_info->response[0]->sex : '';

                    //echo $user_name .' '. $user_image .' '. $user_bd .'<br/>';

                    if (empty($this->session->user))
                    {
                        // Сравнение данных соц. сети с данными БД -> авторизация (обновление данных) или регистрация
                        $result = $this->Authorization_model->validSocLoginId('vk', $this->date, $user_access_token,
                            $user_soc_id, $expires_at, $issued_at, $expires_in, $user_soc_email, $user_soc_name,
                            $user_soc_image, $user_soc_bd, $user_soc_gender);
                        //echo $user_id;
                        if (!empty($result['user']))
                        {
                            $user = $result['user'];

                            $user_image = (!empty($user['image'])) ? $user['image'] : $user['soc_image'];

                            parent::updateSession($user['id'], $user['email'], $user['type'], $user['blocked'], $user['name'],
                                $user['phone'], $user_image, $user['access_token'], $user['soc_via'], $user['soc_id'], $this->date);

                            $return = ($return == '/profile/' and !empty($this->session->user['id'])) ? $return . $this->session->user['id'] : $return;

                            parent::deleteSessionReturnUrl();

                            // Отправляем письмо с уведомлением об регистрации
                            if (!empty($user_soc_email) and filter_var($user_soc_email, FILTER_VALIDATE_EMAIL))
                            {
                                $system_message['text']  = '<b><a href="https://superbody.pro/" style="display: inline-block; width:100%; text-align:center; padding:0; margin:0">';
                                $system_message['text']  .= 'Перейти на сайт';
                                $system_message['text']  .= '</a></b>';

                                parent::sendEmail(2, $user_soc_email, $system_message);
                            }

                            header('Location: ' . $return);
                        }
                        else
                        {
                            // Не удалось авторизоваться. Повторите попытку
                            $this->session->set_tempdata('message', 5, 60);

                            log_message('error', __METHOD__ . ':' . __LINE__ . ' Ошибка сохранения данных. $result:' . print_r($result, true));

                            parent::deleteSessionReturnUrl();

                            header('Location: ' . $fail_return);
                        }
                    }
                    else
                    {
                        $result = $this->Authorization_model->connectSocial($this->user_id, 'vk', $this->date, $user_access_token,
                            $user_soc_id, '', $expires_at, $issued_at, $expires_in);

                        if($result === true)
                        {
                            log_message('debug', __METHOD__ . ':' . __LINE__ . ' $return:' . print_r($return, true));

                            parent::deleteSessionReturnUrl();

                            header('Location: ' . $return);
                        }
                        else
                        {
                            // Не удалось присоединить соц. сеть
                            log_message('error', __METHOD__ . ':' . __LINE__ . ' Не удалось присоединить соц. сеть');

                            parent::deleteSessionReturnUrl();

                            header('Location: ' . $fail_return);
                        }
                    }
                }
                else
                {
                    // Не удалось получить доступ к данным. Повторите попытку
                    $this->session->set_tempdata('message', 102, 60);

                    log_message('error', __METHOD__ . ':' . __LINE__ . ' Ошибка авторизации. $resp_info:' . print_r($resp_info, true));

                    parent::deleteSessionReturnUrl();

                    header('Location: ' . $fail_return);
                }
            }
            else
            {
                // Не удалось получить доступ к данным. Повторите попытку
                $this->session->set_tempdata('message', 102, 60);

                log_message('error', __METHOD__ . ':' . __LINE__ . ' Ошибка авторизации. $resp_data:' . print_r($resp_data, true));

                parent::deleteSessionReturnUrl();

                header('Location: ' . $fail_return);
            }
        }
        elseif($this->input->get('error', true))
        {
            // Отказано в доступе
            $this->session->set_tempdata('message', 103, 60);

            log_message('error', __METHOD__ . ':' . __LINE__ . ' Ошибка авторизации. GET:' . print_r($this->input->get(), true));

            parent::deleteSessionReturnUrl();

            header('Location: ' . $fail_return);
        }
    }

    /**
     * Авторизация при помощи Facebook
     *
     * @param $email
     * @param $return
     */
    public function facebookLogin($email = '', $return = '')
    {
        // Instagram
        $url_authorize   = 'https://www.facebook.com/v3.0/dialog/oauth';
        $url_token       = 'https://graph.facebook.com/v3.0/oauth/access_token';
        $url_debug_token = 'https://graph.facebook.com/v3.0/debug_token?';
        $client_id       = '817159398426245';
        $client_secret   = 'e9a5d05ef3fee31e53cedba7ff910d59';
        $redirect_uri    = 'https://superbody.pro/facebook_login';
        $scope           = array( 'public_profile', 'email' );
        $state           = uniqid('', true);
        $email           = (filter_var($this->input->post('email', true), FILTER_VALIDATE_EMAIL))
            ? $this->input->post('email', true)
            : $email;

        // Обработка ссылки для возврата
        if(empty($this->session->return_url))
        {
            // Данные POST или GET
            $return_data = (!empty($this->input->post('hi_return', true))) ? $this->input->post('hi_return', true) : $this->input->get('hi_return', true);

            parent::setSessionReturnUrl($return_data, $return);

            $return      = $this->session->return_url;
            $fail_return = $this->session->fail_return_url;

            $user_data['input_email'] = $email;
            $this->session->set_userdata($user_data);
        }
        else
        {
            $return      = $this->session->return_url;
            $fail_return = $this->session->fail_return_url;
            $email       = (filter_var($this->session->input_email, FILTER_VALIDATE_EMAIL)) ? $this->session->input_email : $email;
        }

        //log_message('debug', __METHOD__ . ':' . __LINE__ . ' Session return url: ' . print_r($this->session->return_url, true));

        if ($this->input->post('bt_facebook_login', true) or $this->input->post('bt_connect_facebook', true))
        {
            header(
                sprintf(
                    'Location:%s?client_id=%s&redirect_uri=%s&state=%s&response_type=code',
                    $url_authorize,
                    $client_id,
                    $redirect_uri,
                    $state,
                    implode( ',', $scope )
                )
            );
        }

        // Получен ответ от Facebook
        if ($this->input->get('code', true))
        {
            $myCurl = curl_init();
            curl_setopt_array($myCurl, array(
                CURLOPT_URL => $url_token,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_POSTFIELDS => http_build_query(array('client_id' => $client_id, 'client_secret' => $client_secret,
                    'redirect_uri' => $redirect_uri, 'code' => $this->input->get('code', true)))
            ));
            $response = curl_exec($myCurl);
            curl_close($myCurl);

            $resp_data = json_decode($response);

            if (!empty($resp_data->access_token))
            {
                $user_access_token = $resp_data->access_token;
                $expires_in        = $resp_data->expires_in;

                $fb_u_data = self::facebookUserData($url_token, $url_debug_token, $client_id, $client_secret,
                    $user_access_token, $expires_in);

                if (!empty($fb_u_data))
                {
                    // Сравнение данных соц. сети с данными БД -> авторизация (обновление данных) или регистрация
                    if (empty($this->session->user))
                    {
                        $fb_u_data['user_email'] = (!empty($email)) ? $email : $fb_u_data['user_email'];

                        $result = $this->Authorization_model->validSocLoginId('facebook', $this->date, $fb_u_data['user_access_token'],
                            $fb_u_data['user_soc_id'], $fb_u_data['expires_at'], $fb_u_data['issued_at'], $fb_u_data['expires_in'],
                            $fb_u_data['user_email'], $fb_u_data['user_name'], $fb_u_data['user_image'], $fb_u_data['user_birthday'],
                            $fb_u_data['user_gender'], $fb_u_data['user_profile_url']);

                        if (!empty($result['user']))
                        {
                            $user = $result['user'];

                            $user_image = (!empty($user['image'])) ? $user['image'] : $user['soc_image'];

                            parent::updateSession($user['id'], $user['email'], $user['type'], $user['blocked'], $user['name'],
                                $user['phone'], $user_image, $user['access_token'], $user['soc_via'], $user['soc_id'], $this->date);

                            $return = ($return == '/profile/' and !empty($this->session->user['id'])) ? $return . $this->session->user['id'] : $return;

                            parent::deleteSessionReturnUrl();

                            // Отправляем письмо с уведомлением об регистрации
                            if (!empty($fb_u_data['user_email']) and filter_var($fb_u_data['user_email'], FILTER_VALIDATE_EMAIL))
                            {
                                $system_message['text']  = '<b><a href="https://superbody.pro/" style="display: inline-block; width:100%; text-align:center; padding:0; margin:0">';
                                $system_message['text']  .= 'Перейти на сайт';
                                $system_message['text']  .= '</a></b>';

                                parent::sendEmail(2, $fb_u_data['user_email'], $system_message);
                            }

                            header('Location: ' . $return);
                        }
                        else
                        {
                            // Не удалось авторизоваться. Повторите попытку
                            $this->session->set_tempdata('message', 5, 60);

                            log_message('error', __METHOD__ . ':' . __LINE__ . ' Ошибка сохранения данных. $result:' . print_r($result, true));

                            parent::deleteSessionReturnUrl();

                            header('Location: ' . $fail_return);
                        }
                    }
                    else
                    {
                        $result = $this->Authorization_model->connectSocial($this->user_id, 'facebook', $this->date, $fb_u_data['user_access_token'],
                            $fb_u_data['user_soc_id'], $fb_u_data['user_profile_url'], $fb_u_data['expires_at'], $fb_u_data['issued_at'], $fb_u_data['expires_in']);

                        if($result === true)
                        {
                            //log_message('debug', __METHOD__ . ':' . __LINE__ . ' $return:' . print_r($return, true));

                            parent::deleteSessionReturnUrl();

                            header('Location: ' . $return);
                        }
                        else
                        {
                            // Не удалось присоединить соц. сеть
                            log_message('error', __METHOD__ . ':' . __LINE__ . ' Не удалось присоединить соц. сеть');

                            parent::deleteSessionReturnUrl();

                            header('Location: ' . $fail_return);
                        }
                    }
                }
                else
                {
                    log_message('error', __METHOD__ . ':' . __LINE__ . ' Ошибка авторизации. $fb_u_data:' . print_r($fb_u_data, true));

                    parent::deleteSessionReturnUrl();

                    header('Location: ' . $fail_return);
                }
            }
            else
            {
                // Не удалось получить доступ к данным. Повторите попытку
                $this->session->set_tempdata('message', 102, 60);

                log_message('error', __METHOD__ . ':' . __LINE__ . ' Ошибка авторизации. $resp_data:' . print_r($resp_data, true));

                parent::deleteSessionReturnUrl();

                header('Location: ' . $fail_return);
            }
        }
        elseif($this->input->get('error_code', true))
        {
            // Отказано в доступе
            $this->session->set_tempdata('message', 103, 60);

            log_message('error', __METHOD__ . ':' . __LINE__ . ' Ошибка авторизации. GET:' . print_r($this->input->get(), true));

            parent::deleteSessionReturnUrl();

            header('Location: ' . $fail_return);
        }
    }

    /**
     * Получение данных пользователя после подтверждения авторизации
     *
     * @param $url_token
     * @param $url_debug_token
     * @param $client_id
     * @param $client_secret
     * @param $user_access_token
     * @param $expires_in
     * @return array
     */
    protected function facebookUserData($url_token, $url_debug_token, $client_id, $client_secret, $user_access_token, $expires_in)
    {
        $result = array();

        // Маркет доступа приложения
        $myCurl3 = curl_init();
        curl_setopt_array($myCurl3, array(
            CURLOPT_URL => $url_token,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_POSTFIELDS => http_build_query(array('client_id' => $client_id, 'client_secret' => $client_secret,
                'grant_type' => 'client_credentials'))
        ));
        $response = curl_exec($myCurl3);
        curl_close($myCurl3);
        $resp_app_token = json_decode($response);

        // Проверка маркера доступа
        if (!empty($resp_app_token->access_token))
        {
            $myCurl4 = curl_init();
            curl_setopt_array($myCurl4, array(
                CURLOPT_URL => $url_debug_token . http_build_query(array('input_token' => $user_access_token,
                        'access_token' => $resp_app_token->access_token)),
                CURLOPT_HTTPGET => true,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FOLLOWLOCATION => true
            ));
            $response = curl_exec($myCurl4);
            curl_close($myCurl4);
            $resp_debug_token = json_decode($response);

            if (!empty($resp_debug_token->data) and $resp_debug_token->data->is_valid === true)
            {
                $result['user_soc_id']   = $resp_debug_token->data->user_id;
                $result['expires_at']    = $resp_debug_token->data->expires_at;
                $result['issued_at']     = $resp_debug_token->data->issued_at;
                $result['expires_in']    = $expires_in;
                $result['user_email']    = '';
                $result['user_name']     = '';
                $result['user_image']    = '';
                $result['user_birthday'] = '';
                $result['user_gender']   = '';
                $result['user_access_token'] = $user_access_token;

                $appsecret_proof = hash_hmac('sha256', $user_access_token, $client_secret);

                // Получение данный пользователя
                $myCurl2 = curl_init();
                curl_setopt_array($myCurl2, array(
                    CURLOPT_URL => 'https://graph.facebook.com/me',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_POST => true,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_POSTFIELDS => http_build_query(array('access_token' => $user_access_token,
                        'appsecret_proof' => $appsecret_proof, 'fields' => 'id,name,email,picture,link'))
                ));
                $response = curl_exec($myCurl2);
                curl_close($myCurl2);
                $resp_info = json_decode($response);

                log_message('debug', 'Facebook response ' . print_r($resp_info, true));
                if (!empty($resp_info->id))
                {
                    // Данные пользователя в соц. сети
                    $result['user_email']       = (!empty($resp_info->email)) ? $resp_info->email : '';
                    $result['user_name']        = (!empty($resp_info->name)) ? $resp_info->name : '';
                    $result['user_image']       = (!empty($resp_info->picture->data->url)) ? $resp_info->picture->data->url : '';
                    $result['user_birthday']    = '';
                    $result['user_gender']      = '';
                    $result['user_profile_url'] = (!empty($resp_info->link)) ? $resp_info->link : '';
                }
            }
        }

        return $result;
    }

    /**
     * Авторизация при помощи Odnoklasniki
     *
     * @param $email
     * @param $return
     */
    public function okLogin($email = '', $return = '')
    {
        // Instagram
        $url_authorize = 'https://connect.ok.ru/oauth/authorize';
        $url_token     = 'https://api.ok.ru/oauth/token.do';
        $client_id     = '1248728064';
        $app_key       = 'CBAFBPGLEBABABABA';
        $client_secret = '0208E5101B8E86CAAE8D3D36';
        $redirect_uri  = 'https://superbody.pro/ok_login';
        $grant_type    = 'authorization_code';
        $scope         = array( 'VALUABLE_ACCESS', 'GET_EMAIL' );
        $email         = (filter_var($this->input->post('email', true), FILTER_VALIDATE_EMAIL))
            ? $this->input->post('email', true)
            : $email;

        // Обработка ссылки для возврата
        if(empty($this->session->return_url))
        {
            // Данные POST или GET
            $return_data   = (!empty($this->input->post('hi_return', true))) ? $this->input->post('hi_return', true) : $this->input->get('hi_return', true);

            parent::setSessionReturnUrl($return_data, $return);

            $return      = $this->session->return_url;
            $fail_return = $this->session->fail_return_url;

            $user_data['input_email'] = $email;
            $this->session->set_userdata($user_data);
        }
        else
        {
            $return      = $this->session->return_url;
            $fail_return = $this->session->fail_return_url;
            $email       = (filter_var($this->session->input_email, FILTER_VALIDATE_EMAIL)) ? $this->session->input_email : $email;
        }

        //log_message('debug', __METHOD__ . ':' . __LINE__ . ' Session return url: ' . print_r($this->session->return_url, true));

        if ($this->input->post('bt_ok_login', true) or $this->input->post('bt_connect_ok', true))
        {
            header(
                sprintf(
                    'Location:%s?client_id=%s&redirect_uri=%s&scope=%s&response_type=code',
                    $url_authorize,
                    $client_id,
                    $redirect_uri,
                    implode( ';', $scope )
                )
            );
        }

        // Получен ответ от OK
        if ($this->input->get('code', true))
        {
            $myCurl = curl_init();
            curl_setopt_array($myCurl, array(
                CURLOPT_URL => $url_token,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_POSTFIELDS => http_build_query(array('client_id' => $client_id, 'client_secret' => $client_secret,
                    'redirect_uri' => $redirect_uri, 'code' => $this->input->get('code', true), 'grant_type' => $grant_type))
            ));
            $response = curl_exec($myCurl);
            curl_close($myCurl);

            $resp_data = json_decode($response);

            // Получен ACCESS_TOKEN для дальнейшей работы
            if (!empty($resp_data->access_token))
            {
                $user_access_token = $resp_data->access_token;
                $expires_in        = $resp_data->expires_in;

                $secret_key = md5($resp_data->access_token . $client_secret);
                $sig = mb_strtolower(md5('application_key=CBAFBPGLEBABABABAformat=jsonmethod=users.getCurrentUser' . $secret_key));

                // Получаем данные пользователя
                $myCurl = curl_init();
                curl_setopt_array($myCurl, array(
                    CURLOPT_URL => 'https://api.ok.ru/fb.do',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_POST => true,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_POSTFIELDS => http_build_query(array('application_key' => $app_key, 'format' => 'json',
                        'method' => 'users.getCurrentUser', 'sig' => $sig, 'access_token' => $user_access_token))
                ));
                $response = curl_exec($myCurl);
                curl_close($myCurl);

                $resp_info = json_decode($response);

                if (!empty($resp_info->uid))
                {
                    // Данные пользователя
                    $user_soc_id     = $resp_info->uid;
                    $expires_at      = 0;
                    $issued_at       = 0;
                    $user_soc_name   = (!empty($resp_info->name)) ? $resp_info->name : '';
                    $user_soc_email  = (!empty($email)) ? $email : $resp_info->email;
                    $user_soc_image  = (is_file($resp_info->pic_3)) ? $resp_info->pic_3 : '';
                    $user_soc_bd     = (!empty($resp_info->birthday)) ? $resp_info->birthday : '';
                    $user_soc_gender = (!empty($resp_info->gender)) ? $resp_info->gender : '';
                    $user_soc_url    = (!empty($resp_info->url_profile)) ? $resp_info->url_profile : '';

                    if (empty($this->session->user))
                    {

                        // Сравнение данных соц. сети с данными БД -> авторизация (обновление данных) или регистрация
                        $result = $this->Authorization_model->validSocLoginId('ok', $this->date, $user_access_token, $user_soc_id,
                            $expires_at, $issued_at, $expires_in, $user_soc_email, $user_soc_name, $user_soc_image,
                            $user_soc_bd, $user_soc_gender, $user_soc_url);

                        if (!empty($result['user']))
                        {
                            $user = $result['user'];

                            $user_image = (!empty($user['image'])) ? $user['image'] : $user['soc_image'];

                            parent::updateSession($user['id'], $user['email'], $user['type'], $user['blocked'], $user['name'],
                                $user['phone'], $user_image, $user['access_token'], $user['soc_via'], $user['soc_id'], $this->date);

                            $return = ($return == '/profile/' and !empty($this->session->user['id'])) ? $return . $this->session->user['id'] : $return;

                            parent::deleteSessionReturnUrl();

                            // Отправляем письмо с уведомлением об регистрации
                            if (!empty($user_soc_email) and filter_var($user_soc_email, FILTER_VALIDATE_EMAIL))
                            {
                                $system_message['text']  = '<b><a href="https://superbody.pro/" style="display: inline-block; width:100%; text-align:center; padding:0; margin:0">';
                                $system_message['text']  .= 'Перейти на сайт';
                                $system_message['text']  .= '</a></b>';

                                parent::sendEmail(2, $user_soc_email, $system_message);
                            }

                            header('Location: ' . $return);
                        }
                        else
                        {
                            // Не удалось авторизоваться. Повторите попытку
                            $this->session->set_tempdata('message', 5, 60);

                            log_message('error', __METHOD__ . ':' . __LINE__ . ' Ошибка сохранения данных. $result:' . print_r($result, true));

                            parent::deleteSessionReturnUrl();

                            header('Location: ' . $fail_return);
                        }
                    }
                    else
                    {
                        $result = $this->Authorization_model->connectSocial($this->user_id, 'ok', $this->date, $user_access_token,
                            $user_soc_id, $user_soc_url, $expires_at, $issued_at, $expires_in);

                        if($result === true)
                        {
                            log_message('debug', __METHOD__ . ':' . __LINE__ . ' $return:' . print_r($return, true));

                            parent::deleteSessionReturnUrl();

                            header('Location: ' . $return);
                        }
                        else
                        {
                            // Не удалось присоединить соц. сеть
                            log_message('error', __METHOD__ . ':' . __LINE__ . ' Не удалось присоединить соц. сеть');

                            parent::deleteSessionReturnUrl();

                            header('Location: ' . $fail_return);
                        }
                    }
                }
                elseif(!empty($resp_info->error_msg))
                {
                    // Не удалось получить доступ к данным. Повторите попытку
                    $this->session->set_tempdata('message', 102, 60);

                    log_message('debug', __METHOD__ . ':' . __LINE__ . ' Ошибка авторизации. $resp_info:' . print_r($resp_info, true));

                    parent::deleteSessionReturnUrl();

                    header('Location: ' . $fail_return);
                }
            }
            else
            {
                // Не удалось получить доступ к данным. Повторите попытку
                $this->session->set_tempdata('message', 102, 60);

                log_message('error', __METHOD__ . ':' . __LINE__ . ' Ошибка авторизации. $resp_data:' . print_r($resp_data, true));

                parent::deleteSessionReturnUrl();

                header('Location: ' . $fail_return);
            }
        }
        elseif($this->input->get('error', true))
        {
            // Отказано в доступе
            $this->session->set_tempdata('message', 103, 60);

            log_message('error', __METHOD__ . ':' . __LINE__ . ' Ошибка авторизации. GET:' . print_r($this->input->get(), true));

            parent::deleteSessionReturnUrl();

            header('Location: ' . $fail_return);
        }
    }
}