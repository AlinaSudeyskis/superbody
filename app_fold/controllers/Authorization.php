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
                if (!empty($this->input->post('email', true))
                    && filter_var($this->input->post('email', true), FILTER_VALIDATE_EMAIL))
                {
                    $email      = $this->input->post('email', true);
                    $email_hash = password_hash($this->input->post('email', true), PASSWORD_DEFAULT);
                } else {
                    $email      = null;
                    $email_hash = null;
                }

                // Хэширование пароля
                if (!empty($this->input->post('password', true))) {
                    $password_hash = password_hash($this->input->post('password', true), PASSWORD_DEFAULT);
                } else {
                    $password_hash = null;
                }

                // Сохранение данных в БД
                if (!empty($email) and !empty($password_hash))
                {
                    $result_registration = $this->Authorization_model->userRegistration($email, $password_hash, $email_hash, $this->date);

                    if (is_numeric($result_registration)) {
                        $reg_user_id = $result_registration;

                        // Отправление письма о подтвержении регистрации пользователю
                        self::sendRegistrationEmail($email, $email_hash);

                        // Обновление данных сессии
                        parent::updateSession($reg_user_id, $email, 1, '', '', '', 'native', 0, $this->date);

                        // После успешной регистрации переход на страницу анкеты
                        header('Location: /questionnaire');
                    } else {
                        if ($result_registration == 'e1') {
                            // Пользователь с таким E-mail существует
                            $this->session->set_tempdata('message', 1, 60);
                        } elseif ($result_registration == 'e2') {
                            // Не удалось сохранить запись в БД
                            $this->session->set_tempdata('message', 2, 60);
                        }
                    }
                } else {
                    // Не все поля для регистрации были заполнены
                    $this->session->set_tempdata('message', 8, 60);
                }
            }
            else
            {
                // Нет подтверждения использования персональных данных
                $this->session->set_tempdata('message', 128, 60);
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

        // Проверка введенных данных, поиск пользователя в БД
        if ($this->input->post('bt_login', true) and $this->input->post('cb_politics', true)) {
            if ($this->input->post('cb_politics', true))
            {
                // Валидация E-mail
                if (!empty($this->input->post('email', true))
                    && filter_var($this->input->post('email', true), FILTER_VALIDATE_EMAIL))
                {
                    $email = $this->input->post('email', true);
                } else {
                    $email = null;
                }

                $password = $this->input->post('password', true);

                // Авторизация пользователя
                if (!empty($email)) {
                    $result = $this->Authorization_model->userAuthorization($email, $password, $this->date);

                    if ($result !== false) {
                        parent::updateSession($result['user_id'], $result['user_email'], $result['user_type'], $result['user_name'],
                            $result['user_image'], '', 'native', 0, $this->date);

                        // После успешной авторизации переход на страницу пользователя
                        header('Location: /profile/'.$result['user_id']);
                    } else {
                        // Не верный E-mail или пароль
                        $this->session->set_tempdata('message', 7, 60);
                        header('Location: /login');
                    }
                } else {
                    // Не корректный E-mail
                    $this->session->set_tempdata('message', 6, 60);
                    header('Location: /login');
                }
            }
            else
            {
                // Нет подтверждения использования персональных данных
                $this->session->set_tempdata('message', 128, 60);
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
        $this->page_data['title']      = 'Авторизация';
        $this->page_data['login_mess'] = $this->page_data['message'];
        $this->page_data['message']    = '';

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/secondary');
        $this->load->view('authorization/login');
        $this->load->view('footer/footer');
    }

    /**
     * Выход из системы
     *
     * @return void
     */
    public function logout()
    {
        if ($this->session->user['auth_via'] == 'native') {
            $this->Authorization_model->userLogout($this->session->user['id'], $this->date);
        }
        else {
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
        $email = $this->input->get('e');
        $activate_code = $this->input->get('ac');

        // Валидация E-mail
        if (!empty($email)
            and filter_var($email, FILTER_VALIDATE_EMAIL))
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
                $this->session->set_tempdata('message', 0, 60);
            }
        } else {
            // Не корректный E-mail
            $this->session->set_tempdata('message', 6, 60);
        }

        header('Location: /');
    }

    /**
     * Восставновление пароля.
     * 
     * Отправка письма пользователю с новым паролем
     *
     * @return void
     */
    public function restorePassword()
    {
        // Переадресация в случае, если пользователь уже авторизован
        if (!empty($this->user_id)) {
            header('Location: /');
        }

        // Проверка введенных данных и сохранение в БД
        if($this->input->post('bt_restore', true))
        {
            // Валидация E-mail
            if (!empty($this->input->post('email', true))
                && filter_var($this->input->post('email', true), FILTER_VALIDATE_EMAIL))
            {
                $email      = $this->input->post('email', true);
                $email_hash = password_hash($this->input->post('email', true), PASSWORD_DEFAULT);
            } else {
                $email = null;
            }

            // Генерация пароля
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
            }

            // Сохранение данных в БД
            if (!empty($email) and !empty($password_hash))
            {
                $result_restore_password = $this->Authorization_model->userRestorePassword($email, $password_hash, $this->date);

                if ($result_restore_password === true) {
                    // Отправление письма с новым паролем
                    $email_to  = "<$email>";

                    $subject   = "Восставновление пароля на сайте SuperBody";

                    $message   = '<p>Новый пароль для входа на сайт SuperBody: <b>' . $password . '</b></p>';

                    $headers   = "Content-type: text/html; charset=utf-8 \r\n";
                    $headers   .= "From: Support SuperBody.pro <info@superbody.pro>\r\n";
                    $headers   .= "Reply-To: info@superbody.pro\r\n";

                    mail($email_to, $subject, $message, $headers);
                    
                    // Письмо отправлено
                    $this->session->set_tempdata('message', 46, 60);
                } else {
                    // Пользователь с таким E-mail не существует
                    $this->session->set_tempdata('message', 47, 60);
                }
            } else {
                // Не корректный E-mail
                $this->session->set_tempdata('message', 6, 60);
            }

            header('Location: /restore');
        }

        // Объединенные данные страница
        $this->page_data['title'] = 'Восставновление пароля';
        $this->page_data['page_menu'] = '';

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/secondary');       
        $this->load->view('authorization/restore_password');        
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
                $this->session->set_tempdata('message', 0, 60);
            }
        } else {
            // Не корректный E-mail
            $this->session->set_tempdata('message', 6, 60);
        }*/
    }

    /**
     * Отправка email пользователю с ссылкой для подтверждения регистрации
     *
     * @param $user_email
     * @param $email_hash
     */
    protected function sendRegistrationEmail ($user_email, $email_hash)
    {
        // Отправление письма о подтвержении регистрации пользователю
        $email_to  = "<$user_email>";

        $subject   = "Подтвеждение регистрации на сайте SuperBody";

        $message   = '<p>Для подтверждения регистрации на сайте перейдите по ссылке</p> </br>';
        $message  .= '<b><a href="https://superbody.pro/activate?e=' . $user_email . '&ac=' . $email_hash . '">';
        $message  .= 'https://superbody.pro/activate?e=' . $user_email . '&ac=' . $email_hash;
        $message  .= '</a></b>';

        $headers   = "Content-type: text/html; charset=utf-8 \r\n";
        $headers   .= "From: Support Superbody.pro <info@superbody.pro>\r\n";
        $headers   .= "Reply-To: info@superbody.pro\r\n";

        mail($email_to, $subject, $message, $headers);
    }


    /**
     * Авторизация при помощи Instargram
     */
    public function instagramLogin()
    {
        // Instagram
        $url_authorize = 'https://api.instagram.com/oauth/authorize/';
        $url_token = 'https://api.instagram.com/oauth/access_token';
        $client_id = '39c0baec30bd477f9738b7630466661d';
        $client_secret = '1697413dde4f41a881516f97fce4d28a';
        $redirect_uri = 'https://superbody.pro/instagram_login';
        $grant_type = 'authorization_code';
        $scope = array( 'basic' );

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
                $user_access_token = $resp_data->access_token;
                $expires_in        = 0;
                $expires_at        = 0;
                $issued_at         = 0;
                // Данные пользователя в соц. сети
                $user_soc_id      = $resp_data->user->id;
                $user_name        = $resp_data->user->full_name;
                $user_image       = $resp_data->user->profile_picture;
                $user_email       = '';
                $user_birthday    = '';
                $user_gender      = '';
                $user_profile_url = (!empty($resp_data->user->user_name)) ? 'https://www.instagram.com/'.$resp_data->user->user_name : '';

                if (empty($this->session->user))
                {
                    //echo $resp_data->user->id;
                    // Сравнение данных соц. сети с данными БД -> авторизация (обновление данных) или регистрация
                    $result = $this->Authorization_model->validSocLoginId('instagram', $this->date, $user_access_token,
                        $user_soc_id, $expires_at, $issued_at, $expires_in, $user_email, $user_name, $user_image,
                        $user_birthday, $user_gender, $user_profile_url);

                    if (!empty($result['user']))
                    {
                        parent::updateSession($result['user']['id'], $result['user']['email'], $result['user']['type'],
                            $result['user']['name'], $result['user']['image'], $result['user']['access_token'], $result['user']['soc_via'], $result['user']['soc_id'], $this->date);

                        header('Location: /profile/'.$this->session->user['id']);
                    }
                    else
                    {
                        // Не удалось авторизоваться. Повторите попытку
                        $this->session->set_tempdata('message', 5, 60);

                        header('Location: /');
                    }
                }
                else
                {
                    $this->Authorization_model->connectSocial($this->user_id, 'instagram', $this->date, $user_access_token,
                        $user_soc_id, $expires_at, $issued_at, $expires_in);

                    header('Location: /settings');
                }
            }
            else
            {
                // Не удалось получить доступ к данным. Повторите попытку
                $this->session->set_tempdata('message', 102, 60);

                header('Location: /');
            }
        }
        elseif($this->input->get('error', true))
        {
            // Отказано в доступе
            $this->session->set_tempdata('message', 103, 60);

            header('Location: /');
        }
    }

    /**
     * Авторизация при помощи Vkontakte
     */
    public function vkLogin()
    {
        // Instagram
        $url_authorize = 'https://oauth.vk.com/authorize';
        $url_token = 'https://oauth.vk.com/access_token';
        $client_id = '6241173';
        $client_secret = 'sbeAsVwV4nZP57upZCrS';
        $redirect_uri = 'https://superbody.pro/vk_login';
        $scope = array( 'email', 'offline' );

        if ($this->input->post('bt_vk_login', true) or $this->input->post('bt_connect_vk', true))
        {
            header(
                sprintf(
                    'Location:https://oauth.vk.com/authorize?client_id=%s&display=popup&redirect_uri=%s&scope=%s&response_type=code&v=5.69',
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
                $user_soc_email = !empty($resp_data->email) ? $resp_data->email : '';

                // Получение подробной информации о пользователе
                $myCurl = curl_init();
                curl_setopt_array($myCurl, array(
                    CURLOPT_URL => 'https://api.vk.com/method/users.get',
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
                    $user_soc_id     = $resp_info->response[0]->uid;
                    $user_soc_name   = !empty($resp_info->response[0]->last_name) and !empty($resp_info->response[0]->first_name)
                        ? $resp_info->response[0]->last_name . ' ' . $resp_info->response[0]->first_name
                        : '';
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
                            parent::updateSession($result['user']['id'], $result['user']['email'], $result['user']['type'],
                                $result['user']['name'], $result['user']['image'], $result['user']['access_token'], $result['user']['soc_via'], $result['user']['soc_id'], $this->date);

                            header('Location: /profile/'.$this->session->user['id']);
                        }
                        else
                        {
                            // Не удалось авторизоваться. Повторите попытку
                            $this->session->set_tempdata('message', 5, 60);

                            header('Location: /');
                        }
                    }
                    else
                    {
                        $this->Authorization_model->connectSocial($this->user_id, 'vk', $this->date, $user_access_token,
                            $user_soc_id, $expires_at, $issued_at, $expires_in);

                        header('Location: /settings');
                    }
                }
                else
                {
                    // Не удалось получить доступ к данным. Повторите попытку
                    $this->session->set_tempdata('message', 102, 60);

                    header('Location: /');
                }
            }
            else
            {
                // Не удалось получить доступ к данным. Повторите попытку
                $this->session->set_tempdata('message', 102, 60);

                header('Location: /');
            }
        }
        elseif($this->input->get('error', true))
        {
            // Отказано в доступе
            $this->session->set_tempdata('message', 103, 60);

            header('Location: /');
        }
    }

    /**
     * Авторизация при помощи Facebook
     */
    public function facebookLogin()
    {
        // Instagram
        $url_authorize   = 'https://www.facebook.com/v2.12/dialog/oauth';
        $url_token       = 'https://graph.facebook.com/v2.12/oauth/access_token';
        $url_debug_token = 'https://graph.facebook.com/v2.12/debug_token?';
        $client_id       = '817159398426245';
        $client_secret   = 'e9a5d05ef3fee31e53cedba7ff910d59';
        $redirect_uri    = 'https://superbody.pro/facebook_login';
        $scope           = array( 'public_profile', 'email' );
        $state           = uniqid('', true);

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
                        $result = $this->Authorization_model->validSocLoginId('facebook', $this->date, $fb_u_data['user_access_token'],
                            $fb_u_data['user_soc_id'], $fb_u_data['expires_at'], $fb_u_data['issued_at'], $fb_u_data['expires_in'],
                            $fb_u_data['user_email'], $fb_u_data['user_name'], $fb_u_data['user_image'], $fb_u_data['user_birthday'],
                            $fb_u_data['user_gender'], $fb_u_data['user_profile_url']);

                        if (!empty($result['user']))
                        {
                            parent::updateSession($result['user']['id'], $result['user']['email'], $result['user']['type'],
                                $result['user']['name'], $result['user']['image'], $result['user']['access_token'],
                                $result['user']['soc_via'], $result['user']['soc_id'], $this->date);

                            header('Location: /profile/'.$this->session->user['id']);
                        }
                        else
                        {
                            // Не удалось авторизоваться. Повторите попытку
                            $this->session->set_tempdata('message', 5, 60);
                        }
                    }
                    else
                    {
                        $result = $this->Authorization_model->connectSocial($this->user_id, 'facebook', $this->date, $fb_u_data['user_access_token'],
                            $fb_u_data['user_soc_id'], $fb_u_data['expires_at'], $fb_u_data['issued_at'], $fb_u_data['expires_in']);

                        header('Location: /settings');
                    }
                }
                else
                {
                    log_message('debug', print_r($fb_u_data, true));
                    header('Location: /');
                }
            }
            else
            {
                // Не удалось получить доступ к данным. Повторите попытку
                $this->session->set_tempdata('message', 102, 60);

                log_message('debug', print_r($resp_data, true));
                header('Location: /');
            }
        }
        elseif($this->input->get('error', true))
        {
            // Отказано в доступе
            $this->session->set_tempdata('message', 103, 60);
            header('Location: /');
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

                if (!empty($resp_info->id))
                {
                    // Данные пользователя в соц. сети
                    $result['user_email']       = !empty($resp_info->email) ? $resp_info->email : '';
                    $result['user_name']        = !empty($resp_info->name) ? $resp_info->name : '';
                    $result['user_image']       = !empty($resp_info->picture->data->url) ? $resp_info->picture->data->url : '';
                    $result['user_birthday']    = '';
                    $result['user_gender']      = '';
                    $result['user_profile_url'] = !empty($resp_info->link) ? $resp_info->link : '';
                }
            }
        }

        return $result;
    }

    /**
     * Авторизация при помощи Odnoklasniki
     */
    public function okLogin()
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
                    $user_soc_name   = !empty($resp_info->name) ? $resp_info->name : '';
                    $user_soc_email  = !empty($resp_info->email) ? $resp_info->email : '';
                    $user_soc_image  = is_file($resp_info->pic_3) ? $resp_info->pic_3 : '';
                    $user_soc_bd     = !empty($resp_info->birthday) ? $resp_info->birthday : '';
                    $user_soc_gender = !empty($resp_info->gender) ? $resp_info->gender : '';
                    $user_soc_url    = !empty($resp_info->url_profile) ? $resp_info->url_profile : '';

                    if (empty($this->session->user))
                    {

                        // Сравнение данных соц. сети с данными БД -> авторизация (обновление данных) или регистрация
                        $result = $this->Authorization_model->validSocLoginId('ok', $this->date, $user_access_token, $user_soc_id,
                            $expires_at, $issued_at, $expires_in, $user_soc_email, $user_soc_name, $user_soc_image,
                            $user_soc_bd, $user_soc_gender, $user_soc_url);

                        if (!empty($result['user']))
                        {
                            parent::updateSession($result['user']['id'], $result['user']['email'], $result['user']['type'],
                                $result['user']['name'], $result['user']['image'], $result['user']['access_token'],
                                $result['user']['soc_via'], $result['user']['soc_id'], $this->date);

                            header('Location: /profile/'.$this->session->user['id']);
                        }
                        else
                        {
                            // Не удалось авторизоваться. Повторите попытку
                            $this->session->set_tempdata('message', 5, 60);

                            log_message('debug', 'OK validSocLoginId: '.print_r($result, true));

                            header('Location: /');
                        }
                    }
                    else
                    {
                        $this->Authorization_model->connectSocial($this->user_id, 'ok', $this->date, $user_access_token,
                            $user_soc_id, $expires_at, $issued_at, $expires_in);

                        header('Location: /settings');
                    }
                }
                elseif(!empty($resp_info->error_msg))
                {
                    // Не удалось получить доступ к данным. Повторите попытку
                    $this->session->set_tempdata('message', 102, 60);

                    log_message('debug', 'OK getCurrentUser: '.print_r($resp_info, true));

                    header('Location: /');
                }
            }
            else
            {
                // Не удалось получить доступ к данным. Повторите попытку
                $this->session->set_tempdata('message', 102, 60);
                log_message('debug', 'OK OAuth: '.print_r($resp_data, true));

                header('Location: /');
            }
        }
        elseif($this->input->get('error', true))
        {
            // Отказано в доступе
            $this->session->set_tempdata('message', 103, 60);

            header('Location: /');
        }
    }
}