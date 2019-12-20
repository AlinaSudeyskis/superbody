<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Coach class
 * 
 * Класс для работы с данными тренера
 *
 * @author Alina Sudeyskis <alina.sudeyskis@gmail.com>
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Coach extends CI_Controller
{
    /**
     * Coach constructor.
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->load->model('Coach_model');
        $this->load->model('User_model');
    }

    /**
     * АП. Вывод списка тренеров
     *
     * @return void
     */
    public function coaches()
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3 or $this->session->user['blocked'] == 1)
        {
            parent::pageNotFound($this->page_url);
        }

        $result = $this->Coach_model->getCoaches();

        // Объединенные данные страница
        $this->page_data['title']        = 'АП - Тренеры';
        $this->page_data['page_menu']    = 'users';
        $this->page_data['page_submenu'] = 'a_coaches';

        $this->load->view('header/header_admin', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('coach/coaches', $result);
        $this->load->view('footer/footer');
    }

    /**
     * Вывод списка тренеров для посльзователя
     *
     * @return void
     */
    public function publicCoaches()
    {
        $result = $this->Coach_model->getCoaches();

        // Объединенные данные страница
        $this->page_data['title']       = $this->page_data['metadata'][4]['title'];
        $this->page_data['keywords']    = $this->page_data['metadata'][4]['keywords'];
        $this->page_data['description'] = $this->page_data['metadata'][4]['description'];
        $this->page_data['page_menu'] = 'coaches';

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/secondary');
        $this->load->view('coach/public_coaches', $result);
        $this->load->view('footer/footer');
    }

    /**
     * Форма добавления и сохранение нового тренеров
     *
     * @return void
     */
    public function newCoach()
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3 or $this->session->user['blocked'] == 1)
        {
            parent::pageNotFound($this->page_url);
        }

        if ($this->input->post('bt_save_new_coach', true))
        {
            // Валидация E-mail
            $email         = null;
            $email_hash    = null;
            $password_hash = '';

            if (!empty($this->input->post('email', true))
                and filter_var($this->input->post('email', true), FILTER_VALIDATE_EMAIL))
            {
                $email      = $this->input->post('email', true);
                $email_hash = password_hash($this->input->post('email', true), PASSWORD_DEFAULT);
            }

            // Имя пользователя
            $name = mb_substr(strip_tags($this->input->post('name', true)), 0, 255);

            // Сохранение данных в БД
            if (!empty($email))
            {
                $result = $this->Coach_model->setNewCoach($email, $name, $password_hash, $email_hash, $this->date);

                if (is_numeric($result))
                {
                    // Отправка письма с активацией почты
                    $system_message['text']  = '<b><a href="https://superbody.pro/activate?e=' . $email . '&ac=' . $email_hash
                        . '" style="display: inline-block; width:100%; text-align:center; padding:0; margin:0">';
                    $system_message['text']  .= 'Активировать';
                    $system_message['text']  .= '</a></b>';

                    parent::sendEmail(17, $email, $system_message);

                    $coach_id = $result;
                    $path_avatar = '';

                    // Загрузка изображения на сервер
                    if(is_uploaded_file($_FILES['avatar_file']['tmp_name']))
                    {
                        $path = './user_files/'.$coach_id.'/avatar/';

                        if(!file_exists($path))
                        {
                            chdir('user_files');
                            if(!is_dir($coach_id))
                            {
                                mkdir($coach_id);
                            }
                            chmod($coach_id, 0777);
                            chdir($coach_id);
                            if(!is_dir('avatar'))
                            {
                                mkdir('avatar');
                            }
                            chmod('avatar', 0777);
                            chdir('avatar');
                            chdir('../../../');
                        }
                        $this->load->helper('file');

                        $path_image = parent::uploadImage('avatar_file', $_FILES['avatar_file']['type'], $path);
                        if(file_exists($path.$path_image))
                        {
                            if ($this->security->xss_clean($path.$path_image, TRUE) !== FALSE)
                            {
                                // файл прошел XSS тест
                                $path_avatar = $path.$path_image;
                            }
                            else
                            {
                                unlink($path);
                            }
                        }
                    }

                    if (!empty($path_avatar))
                    {
                        $this->Coach_model->setCoachAvatar($coach_id, $path_avatar);
                    }

                    // Сохранено
                    $this->session->set_tempdata('message', 10, 60);

                    header('Location: /administration/coach/' . $coach_id);
                }
                else
                {
                    if ($result == 'e1')
                    {
                        // Пользователь с таким E-mail существует
                        $this->session->set_tempdata('message', 1, 60);
                    }
                    elseif ($result == 'e2')
                    {
                        // Не удалось сохранить запись в БД
                        $this->session->set_tempdata('message', 2, 60);
                    }

                    header('Location: /administration/coach/new');
                }
            }
            else
            {
                // Некорректные данные
                $this->session->set_tempdata('message', 15, 60);

                header('Location: /administration/coach/new');
            }
        }

        // Объединенные данные страница
        $this->page_data['title']        = 'АП - Добавление тренера';
        $this->page_data['page_menu']    = 'users';
        $this->page_data['page_submenu'] = 'a_coaches';

        $this->load->view('header/header_admin', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('coach/new_coach');
        $this->load->view('footer/footer');
    }

    /**
     * Форма добавления и сохранение выбранных тренеров из пользователей
     *
     * @return void
     */
    public function newCoachOfTheUsers()
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3 or $this->session->user['blocked'] == 1) {
            parent::pageNotFound($this->page_url);
        }

        if ($this->input->post('bt_save_new_coaches', true)) {
            $users = array();
            if (!empty($this->input->post('users', true))) {
                $input_users = $this->input->post('users', true);
                $i = 0;
                foreach ($input_users as $key => $user) {
                    if (is_numeric($user)) {
                        $users[$i] = $user;

                        $i++;
                    }
                }
                unset($user);
            }
            $type = 2;

            // Изменение тип пользователя на администратор
            if (!empty($users))
            {
                foreach ($users as $user_id)
                {
                    $this->load->model('Administrator_model');
                    $result = $this->Administrator_model->changeUserType($user_id, $type, $this->date);

                    if ($result === true)
                    {
                        $this->load->model('User_model');
                        $result = $this->User_model->getUser($user_id);
                        $user_data = $result['user_data'];

                        $email = $user_data['email'];
                        // Отправление письма с данными администратора
                        $system_message['text']  = '';

                        parent::sendEmail(4, $email, $system_message);

                        // Сохранено
                        $this->session->set_tempdata('message', 83, 60);
                    }
                    else
                    {
                        // Не удалось изменить тип пользователя
                        $this->session->set_tempdata('message', 86, 60);
                    }
                }
                unset($user_id);
            }

            header('Location: /administration/coach/new/users');
        }

        // Объединенные данные страница
        $this->page_data['title']        = 'АП - Выбор тренера из пользователей';
        $this->page_data['page_menu']    = 'users';
        $this->page_data['page_submenu'] = 'a_coaches';

        $this->load->view('header/header_admin', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('coach/new_coach_ot_users');
        $this->load->view('footer/footer');
    }

    /**
     * АП. Форма редактирования и сохранение изменений настроек тренера
     *
     * @param $user_id
     * @param $page_type
     * @return void
     * @throws Exception
     */
    public function coachSettings($user_id, $page_type = 'settings')
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3 or $this->session->user['blocked'] == 1)
        {
            parent::pageNotFound($this->page_url);
        }

        $user = $this->Coach_model->getCoach($user_id);
        $user_data = $user['user_data'];

        if ($this->input->post('bt_save_user_settings', true) and is_numeric($user_id))
        {
            // Валидация E-mail
            if (!empty($this->input->post('email', true))
                && filter_var($this->input->post('email', true), FILTER_VALIDATE_EMAIL))
            {
                $email = $this->input->post('email', true);
            } else {
                $email = $user_data['user_email'];
            }

            // Данные пользователя
            $name          = mb_substr(strip_tags($this->input->post('name', true)), 0, 255);
            $special       = mb_substr(strip_tags($this->input->post('special', true)), 0, 255);
            $experience    = mb_substr(strip_tags($this->input->post('experience', true)), 0, 2);
            $titles_awards = mb_substr(strip_tags($this->input->post('titles_awards', true)), 0, 255);
            $about         = ($this->input->post('about', true)) ? mb_substr(strip_tags($this->input->post('about', true), '<span><p><br>'), 0, 700) : '';

            // Загрузка изображения на сервер
            $path_avatar = '.' . $user_data['user_image'];
            if(is_uploaded_file($_FILES['avatar_file']['tmp_name'])){
                $path = './user_files/'.$user_id.'/avatar/';

                if(!file_exists($path)){
                    chdir('user_files');
                    if(!is_dir($user_id)){
                        mkdir($user_id);
                    }
                    chmod($user_id, 0777);
                    chdir($user_id);
                    if(!is_dir('avatar')){
                        mkdir('avatar');
                    }
                    chmod('avatar', 0777);
                    chdir('avatar');
                    chdir('../../../');
                }
                $this->load->helper('file');
                //delete_files('./user_files/'.$this->user_id.'/avatar/');

                //print_r($path);
                $path_image = parent::uploadImage('avatar_file',$_FILES['avatar_file']['type'], $path);
                if(file_exists($path.$path_image)){
                    if ($this->security->xss_clean($path.$path_image, TRUE) !== FALSE) {
                        // файл прошел XSS тест
                        $path_avatar = $path.$path_image;
                    } else{
                        delete_files($path);
                    }
                }
            }

            // Сохранение данных в БД
            $result = $this->Coach_model->setCoachSettings($user_id, $email, $name, $path_avatar, $this->date);
            $this->Coach_model->setCoachData($user_id, $special, $experience, $titles_awards, $about, $this->date);

            if ($result === true) {
                // Сохранено
                $this->session->set_tempdata('message', 10, 60);
            } else {
                // Не сохранено
                $this->session->set_tempdata('message', 9, 60);
            }

            header('Location: /administration/coach/'.$user_id);
        }
        elseif ($this->input->post('bt_block_user', true) and is_numeric($user_id)) {
            $result = $this->Coach_model->blockCoach($user_id, $this->date);

            if ($result === true) {
                // Сохранено
                $this->session->set_tempdata('message', 16, 60);
            } else {
                // Не сохранено
                $this->session->set_tempdata('message', 17, 60);
            }

            header('Location: /administration/coach/'.$user_id);
        }
        elseif ($this->input->post('bt_unblock_user', true) and is_numeric($user_id)) {
            $result = $this->Coach_model->unblockCoach($user_id, $this->date);

            if ($result === true) {
                // Сохранено
                $this->session->set_tempdata('message', 18, 60);
            } else {
                // Не сохранено
                $this->session->set_tempdata('message', 19, 60);
            }

            header('Location: /administration/coach/'.$user_id);
        }
        elseif ($this->input->post('bt_change_user_type', true) and is_numeric($user_id))
        {
            $type = 1;
            $this->load->model('Administrator_model');
            $result = $this->Administrator_model->changeUserType($user_id, $type, $this->date);

            if ($result === true)
            {
                $result = $this->User_model->getUser($user_id);
                $user_data = $result['user_data'];

                $email = $user_data['email'];
                // Отправление письма
                $system_message['text']  = '';

                parent::sendEmail(5, $email, $system_message);

                // Сохранено. Тип Тренер изменен на тип Пользователя
                $this->session->set_tempdata('message', 85, 60);

                header('Location: /administration/user/'.$user_id);
            }
            else
            {
                // Не сохранено
                $this->session->set_tempdata('message', 86, 60);

                header('Location: /administration/coach/'.$user_id);
            }
        }
        elseif ($this->input->post('bt_delete_avatar', true)) {
            $res_del = $this->User_model->deleteUserAvatar($user_id);

            if ($res_del === false) {
                // Не сохранено
                $this->session->set_tempdata('message', 96, 60);
            } else {
                // Сохранено
                $this->session->set_tempdata('message', 10, 60);
            }
            header('Location: /administration/coach/'.$user_id);
        }
        elseif ($this->input->post('bt_save_data', true))
        {
            $user_data = $user['user_data'];
            $res_gb = false;
            $res_cd = false;

            // Пол
            $genders = array('male', 'female');
            $gender = (in_array($this->input->post('gender', true), $genders)) ? $this->input->post('gender', true) : '';

            // Дата рождения
            $b_day  = is_numeric($this->input->post('b_day', true)) ? $this->input->post('b_day', true) : '';
            $b_mon  = is_numeric($this->input->post('b_mon', true)) ? $this->input->post('b_mon', true) : '';
            $b_year = is_numeric($this->input->post('b_year', true)) ? $this->input->post('b_year', true) : '';
            $birthday = $b_day . '.' . $b_mon . '.' . $b_year;
            $date = DateTime::createFromFormat('d.m.Y', $birthday);
            $birthday = ($date !== false) ? $date->format('Y-m-d') : '';

            // Сохранение пола и даты рождения
            if ($gender != $user_data['user_gender'] or $birthday != $user_data['user_birthday'])
            {
                log_message('debug', $gender.' '.$birthday);
                $res_gb = $this->User_model->setUserGenderBd($user_id, $gender, $birthday, $this->date);
                log_message('debug', $res_gb);

                if ($res_gb === true and !empty($user_data['weight']))
                {
                    parent::calcBmiBmr($user_id, $user_data['weight']);
                }
            }

            // Информация о тренере
            // Специализация
            $special = ($this->input->post('special', true)) ? mb_substr(strip_tags($this->input->post('special', true)), 0, 255) : '';

            // Стаж работы
            $experience = (is_numeric($this->input->post('experience', true))) ? mb_substr($this->input->post('experience', true), 0, 2) : '';

            // Титулы и награды
            $title_awards = ($this->input->post('titles_awards', true)) ? mb_substr(strip_tags($this->input->post('titles_awards', true)), 0, 255) : '';

            // О себе
            $about = ($this->input->post('about', true)) ? mb_substr(strip_tags($this->input->post('about', true), '<span><p><br>'), 0, 700) : '';

            // Сохранение данных о тренере
            if ($special != $user_data['user_special'] or $experience != $user_data['user_experience']
                or $title_awards != $user_data['user_titles_awards'] or $about != $user_data['user_about'])
            {
                $res_cd = $this->Coach_model->setCoachData($user_id, $special, $experience, $title_awards, $about, $this->date);
            }

            if ($res_gb === false and $res_cd === true)
            {
                // Дата рождения и пол не сохранены
                $this->session->set_tempdata('message', 95, 60);
            }
            elseif ($res_gb === true and $res_cd === false)
            {
                // Информация о тренере не сохранена
                $this->session->set_tempdata('message', 78, 60);
            }
            elseif ($res_gb === true and $res_cd === true)
            {
                // Сохранено
                $this->session->set_tempdata('message', 10, 60);
            }
            elseif ($res_gb === false and $res_cd === false)
            {
                // Все личные данные не сохранены
                $this->session->set_tempdata('message', 187, 60);
            }

            header('Location: /administration/coach/'.$user_id.'/personal');
        }
        elseif ($this->input->post('bt_reset_password', true))
        {
            $email      = null;
            $email_hash = null;
            $idempotent = null;
            $today      = $this->date;
            $date_in_an_hour = null;

            // Валидация E-mail
            if (!empty($user_data['user_email'])
                && filter_var($user_data['user_email'], FILTER_VALIDATE_EMAIL))
            {
                $email      = $user_data['user_email'];
                $email_hash = password_hash($user_data['user_email'], PASSWORD_DEFAULT);
                $idempotent = password_hash($today, PASSWORD_DEFAULT);

                // Дата и время через час после сохранения данных о восстановлении пароля
                $tmp_date = new DateTime($today);
                $tmp_date->add(new DateInterval('PT1H'));
                $date_in_an_hour = $tmp_date->format('Y-m-d H:i:s');
            }

            // Сохранение данных в БД, отправка письма
            if (!empty($email))
            {
                $this->load->model('Authorization_model');
                $result_restore = $this->Authorization_model->setRestore($email, $email_hash, $idempotent, $today);

                if ($result_restore === true)
                {
                    // Отправление письма с указаниями по восстановлению пароля
                    $system_message['text']  = '<p>Обновить пароль Вы можете до ' . $date_in_an_hour . '</p> </br>';
                    $system_message['text']  .= '<b><a href="https://superbody.pro/restore?e=' . $email . '&ac=' . $email_hash . '&i=' . $idempotent
                        . '" style="display: inline-block; width:100%; text-align:center; padding:0; margin:0">';
                    $system_message['text']  .= 'Восстановить пароль';
                    $system_message['text']  .= '</a></b>';

                    $send_res = parent::sendEmail(3, $email, $system_message);

                    if($send_res === true)
                    {
                        // Письмо отправлено
                        $this->session->set_tempdata('message', 46, 60);
                    }

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

            header('Location: /administration/coach/'.$user_id);
        }
        elseif ($this->input->post('bt_on_behalf_login', true))
        {
            $this->load->model('Authorization_model');
            // Поиск тренера в БД
            $search_coach = $this->Authorization_model->authorizationOnBehalfUser($user_id);

            if ($search_coach !== false and is_array($search_coach))
            {
                // Завершение текущей сессии
                if ($this->session->user['auth_via'] == 'native')
                {
                    $this->Authorization_model->userLogout($this->session->user['id'], $this->date);
                }
                else
                {
                    $this->Authorization_model->userSocialLogout($this->session->user['auth_via'], $this->session->user['social_id'], $this->date);
                }

                // Создание новой сессии
                $user_image = (!empty($search_coach['user_image'])) ? $search_coach['user_image'] : $search_coach['user_soc_image'];

                parent::updateSession($search_coach['user_id'], $search_coach['user_email'], $search_coach['user_type'], $search_coach['user_blocked'],
                    $search_coach['user_name'], $search_coach['user_phone'], $user_image, '', 'native', 0, $this->date);

                // После успешной авторизации переход на страницу тренера
                header('Location: /profile/'.$search_coach['user_id']);
            }
            else
            {
                header('Location: /administration/coach/'.$user_id);
            }
        }
        elseif ($this->input->post('bt_delete_user', true))
        {
            $tmp_date = new DateTime($this->date);
            $in_a_month = ($tmp_date !== false) ? $tmp_date->add(new DateInterval('P30D')) : false;
            $delete_date = ($in_a_month !== false) ? $in_a_month->format('Y-m-d') : '';

            $up_d = $this->User_model->temporarilyDeleteUser($user_id, $this->user_id, $delete_date);

            if ($up_d['result'] === true)
            {
                // Отправка уведомления на почту пользователя
                parent::sendEmail(13, $up_d['user_email']);

                // Пользователь удален
                $this->session->set_tempdata('message', 179, 60);

                header('Location: /administration/users/archive/'.$user_id);
            }
            else
            {
                // Пользователь не удален
                $this->session->set_tempdata('message', 180, 60);

                header('Location: /administration/coach/'.$user_id);
            }
        }

        // Объединенные данные страница
        $this->page_data['title']         = 'АП - Редактирование данных тренера';
        $this->page_data['page_menu']     = 'users';
        $this->page_data['page_submenu']  = ($user_data['user_deleted'] == 1) ? 'a_users_archive' : 'a_coaches';
        $this->page_data['page_2submenu'] = ($page_type == 'settings') ? 'settings' : 'personal_data';

        $this->load->view('header/header_admin', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('coach/settings/coach_settings', $user);
        $this->load->view('footer/footer');
    }

    /**
     * Страница портфолио тренера.
     *
     * Загрузка, удаление фотографий
     *
     * @return void
     */
    public function coachPortfolio()
    {
        // Если пользователь не авторизован, переход на страницу авторизации
        if (empty($this->user_id) or $this->session->user['type'] != 2 or $this->session->user['blocked'] == 1)
        {
            parent::pageNotFound($this->page_url);
        }

        if ($this->input->post('bt_delete_portfolio_img'))
        {
            if (is_numeric($this->input->post('img_id', true)))
            {
                $path = '.' . strip_tags($this->input->post('img_path', true));

                $this->Coach_model->deletePortfolioImage($this->user_id, $this->input->post('img_id', true), $path);
            }
        }

        $result = $this->Coach_model->getCoachPortfolioData($this->user_id);

        // Объединенные данные страница
        $this->page_data['title'] = 'Портфолио';
        $this->page_data['page_menu'] = 'portfolio';

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/profile');
        $this->load->view('user/profile_line');
        $this->load->view('coach/portfolio/portfolio', $result);
        $this->load->view('footer/footer');
    }

    /**
     * Вывод записи портфолио
     *
     * @param int $post_id
     */
    public function portfolioPost($post_id)
    {
        // Если пользователь не авторизован, переход на страницу авторизации
        if (empty($this->user_id)) {
            header('Location: /login');
        }

        $post   = $this->Coach_model->getPortfolioPost($post_id);
        $user   = $this->Coach_model->getCoach($post['post']['coach_id'], $this->date);
        $result = array_merge($post, $user);

        // Объединенные данные страница
        $this->page_data['title'] = 'Портфолио';
        $this->page_data['page_menu'] = 'portfolio_post';

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/profile');
        $this->load->view('user/profile_line');
        $this->load->view('coach/portfolio/portfolio_post', $result);
        $this->load->view('footer/footer');
    }

    /**
     * Форма редактирования записи портфолио
     *
     * @param $post_id
     */
    public function editPortfolioPost($post_id)
    {
        // Если пользователь не авторизован, переход на страницу авторизации
        if (empty($this->user_id) or $this->session->user['type'] != 2 or $this->session->user['blocked'] == 1)
        {
            parent::pageNotFound($this->page_url);
        }

        $result   = $this->Coach_model->getCoachPortfolioPost($this->user_id, $post_id);
        $db_image = '.' . $result['post']['path'];
        $db_title = $result['post']['title'];
        $db_desc  = $result['post']['desc'];


        if ($this->input->post('bt_save_image', true))
        {
            $files_data = $db_image;

            if (is_uploaded_file($_FILES['portfolio_image']['tmp_name']))
            {
                $path = './user_files/'.$this->user_id.'/portfolio/';

                $path_image = parent::uploadImage('portfolio_image', $_FILES['portfolio_image']['type'], $path);

                if(file_exists($path.$path_image))
                {
                    if ($this->security->xss_clean($path.$path_image, TRUE) !== FALSE)
                    {
                        // файл прошел XSS тест
                        $files_data = $path.$path_image;

                        unlink($db_image);
                    }
                    else
                    {
                        unlink($path.$path_image);
                    }
                }
            }

            $title       = strip_tags(mb_substr($this->input->post('image_title', true), 0, 100));
            $description = strip_tags(mb_substr($this->input->post('image_description', true), 0, 255));

            if($db_image != $files_data or $db_title != $title or $db_desc != $description)
            {
                $res_save_image = $this->Coach_model->updateCoachPortfolio($this->user_id, $post_id, $files_data, $title, $description, $this->date);

                if ($res_save_image['image'] === true or $res_save_image['data'] === true)
                {
                    // Сохранено
                    $this->session->set_tempdata('message', 87, 60);
                }
                elseif ($res_save_image['image'] === false and $res_save_image['data'] === false)
                {
                    $this->session->set_tempdata('message', 90, 60);
                }
                elseif ($res_save_image['image'] === false and $res_save_image['data'] !== false)
                {
                    $this->session->set_tempdata('message', 88, 60);
                }
                elseif ($res_save_image['image'] !== false and $res_save_image['data'] === false)
                {
                    $this->session->set_tempdata('message', 89, 60);
                }
            }

            header('Location: /portfolio/post/' . $post_id);
        }
        elseif ($this->input->post('bt_del_post', true))
        {
            $res_del = $this->Coach_model->deleteCoachPortfolioPost($this->user_id, $post_id);

            if ($res_del === true)
            {
                unlink($db_image);

                $this->session->set_tempdata('message', 91, 60);
            }
            else
            {
                $this->session->set_tempdata('message', 92, 60);
            }

            header('Location: /portfolio');
        }

        $result = $this->Coach_model->getCoachPortfolioPost($this->user_id, $post_id);

        // Объединенные данные страница
        $this->page_data['title'] = 'Редактирование записи портфолио';
        $this->page_data['page_menu'] = 'portfolio';

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/profile');
        $this->load->view('user/profile_line');
        $this->load->view('coach/portfolio/form_edit', $result);
        $this->load->view('footer/footer');
    }

    /**
     * Форма добавления записи в портфолио
     */
    public function newPortfolioPost()
    {
        // Если пользователь не авторизован, переход на страницу авторизации
        if (empty($this->user_id) or $this->session->user['type'] != 2 or $this->session->user['blocked'] == 1)
        {
            parent::pageNotFound($this->page_url);
        }

        if ($this->input->post('bt_save_post', true))
        {
            $path = './user_files/'.$this->user_id.'/portfolio/';
            $files_data = '';

            if(!file_exists('./user_files/'.$this->user_id.'/portfolio/'))
            {
                chdir('user_files');
                if(!is_dir($this->user_id))
                {
                    mkdir($this->user_id);
                }
                chmod($this->user_id, 0777);
                chdir($this->user_id);
                if(!is_dir('portfolio'))
                {
                    mkdir('portfolio');
                }
                chmod('portfolio', 0777);
                chdir('portfolio');
                chdir('../../../');
            }

            $path_image = parent::uploadImage('portfolio_image', $_FILES['portfolio_image']['type'], $path);

            if(file_exists($path.$path_image))
            {
                if ($this->security->xss_clean($path.$path_image, TRUE) !== FALSE)
                {
                    // файл прошел XSS тест
                    $files_data = $path.$path_image;
                    $name = strip_tags(mb_substr($this->input->post('image_title', true), 0, 100));
                    $description = strip_tags(mb_substr($this->input->post('image_description', true), 0, 255));
                }
                else
                {
                    unlink($path.$path_image);
                }
            }

            if(!empty($files_data))
            {
                $res_ins = $this->Coach_model->setCoachPortfolioPost($this->user_id, $files_data, $name, $description, $this->date);

                if (is_numeric($res_ins))
                {
                    $this->session->set_tempdata('message', 10, 60);

                    header('Location: /portfolio/post/' . $res_ins);
                }
                else
                {
                    $this->session->set_tempdata('message', 94, 60);

                    header('Location: /portfolio/post/new');
                }
            }
            else
            {
                $this->session->set_tempdata('message', 94, 60);

                header('Location: /portfolio/post/new');
            }
        }

        // Объединенные данные страница
        $this->page_data['title'] = 'Добавление записи в портфолио';
        $this->page_data['page_menu'] = 'portfolio';

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/profile');
        $this->load->view('user/profile_line');
        $this->load->view('coach/portfolio/form_new');
        $this->load->view('footer/footer');
    }

    /**
     * АП. Портфолио тренера
     */
    public function coachesPortfolioPosts()
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3 or $this->session->user['blocked'] == 1)
        {
            parent::pageNotFound($this->page_url);
        }

        $result = $this->Coach_model->getCoachesPortfolioPosts();

        // Объединенные данные страница
        $this->page_data['title']     = 'АП - Портфолио тренера';
        $this->page_data['page_menu'] = 'coach_portfolio';

        $this->load->view('header/header_admin', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('coach/portfolio/coaches_portfolio_posts', $result);
        $this->load->view('footer/footer');
    }

    /**
     * АП. Страница редактирования/одобрения данных изображения портфолио тренера
     *
     * @param $post_id
     */
    public function coachesPortfolioPost($post_id)
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3 or $this->session->user['blocked'] == 1)
        {
            parent::pageNotFound($this->page_url);
        }

        $result = $this->Coach_model->getCoachesPortfolioPost($post_id);

        $db_title = $result['post']['title'];
        $db_desc  = $result['post']['desc'];

        if ($this->input->post('bt_save_image', true))
        {
            $title       = strip_tags(mb_substr($this->input->post('image_title', true), 0, 100));
            $description = strip_tags(mb_substr($this->input->post('image_description', true), 0, 255));

            if($db_title != $title or $db_desc != $description)
            {
                $res_save_image = $this->Coach_model->updateCoachesPortfolio($post_id, $title, $description, $this->date);

                if ($res_save_image === true)
                {
                    // Сохранено
                    $this->session->set_tempdata('message', 87, 60);
                }
                else
                {
                    $this->session->set_tempdata('message', 89, 60);
                }
            }

            header('Location: /administration/coaches/portfolio/' . $post_id);
        }
        elseif($this->input->post('bt_approval_post', true))
        {
            $res_block = $this->Coach_model->approvalCoachesPortfolio($post_id, 1, $this->date);

            if ($res_block === true)
            {
                // Сохранено
                $this->session->set_tempdata('message', 163, 60);
            }
            else
            {
                $this->session->set_tempdata('message', 165, 60);
            }

            header('Location: /administration/coaches/portfolio/' . $post_id);
        }
        elseif($this->input->post('bt_block_post', true))
        {
            $res_block = $this->Coach_model->approvalCoachesPortfolio($post_id, 0, $this->date);

            if ($res_block === true)
            {
                // Сохранено
                $this->session->set_tempdata('message', 164, 60);
            }
            else
            {
                $this->session->set_tempdata('message', 166, 60);
            }

            header('Location: /administration/coaches/portfolio/' . $post_id);
        }

        // Объединенные данные страница
        $this->page_data['title']     = 'АП - Портфолио тренера';
        $this->page_data['page_menu'] = 'coach_portfolio';

        $this->load->view('header/header_admin', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('coach/portfolio/coaches_portfolio_post', $result);
        $this->load->view('footer/footer');
    }

    /**
     * AJAX поиск тренеров
     *
     * @return void
     */
    public function searchCoaches()
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3 or $this->session->user['blocked'] == 1)
        {
            parent::pageNotFound($this->page_url);
        }

        $result['coaches'] = false;

        $search_text = !empty(mb_substr(strip_tags($this->input->post('search_text', true)), 0, 255)) 
            ? mb_substr(strip_tags($this->input->post('search_text', true)), 0, 255)
            : null;
        
        if (!empty($search_text)) {
            $result['coaches'] = $this->Coach_model->searchCoaches($search_text);
        }

        echo json_encode($result, JSON_NUMERIC_CHECK);
    }

    /**
     * Активность пользователей
     *
     * Список пользователей
     *
     * @return void
     */
    public function usersActivity()
    {
        // Если пользователь не авторизован, переход на страницу авторизации
        if (empty($this->user_id) or $this->session->user['type'] != 2 or $this->session->user['blocked'] == 1)
        {
            parent::pageNotFound($this->page_url);
        }

        $result = $this->Coach_model->getCoachClientsActivity($this->user_id);

        // Объединенные данные страница
        $this->page_data['title'] = 'Активность клиентов';
        $this->page_data['page_menu'] = 'activity';

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/profile');
        $this->load->view('user/profile_line');
        $this->load->view('coach/users_activity', $result);
        $this->load->view('footer/footer');
    }

    /**
     * Активность пользователя
     *
     * Вывод последних антропометрических данных, графика
     *
     * @param $user_id
     * @return void
     */
    public function userActivity($user_id)
    {
        // Если пользователь не авторизован, переход на страницу авторизации
        if (empty($this->user_id) or $this->session->user['type'] != 2 or $this->session->user['blocked'] == 1)
        {
            parent::pageNotFound($this->page_url);
        }

        $this->load->model('User_model');

        $attached_users_id = $this->Coach_model->getAttachedUsersId($this->user_id);

        $user_data         = array();
        $last_anthrop_data = array();
        $anthrop_data      = array();
        if (in_array($user_id, $attached_users_id['id']))
        {
            $user_data         = $this->User_model->getUser($user_id);
            $last_anthrop_data = $this->User_model->getLastAnthropometricData($user_id);
            $anthrop_data      = $this->User_model->getAnthropometricData($user_id);
        }
        $result = array_merge($last_anthrop_data, $anthrop_data, $user_data);

        // Объединенные данные страница
        $this->page_data['title'] = 'Активность клиентов';
        $this->page_data['page_menu'] = 'activity';

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/profile');
        $this->load->view('user/profile_line');
        $this->load->view('coach/user_activity', $result);
        $this->load->view('footer/footer');
    }

    /**
     * Курсы, прикрепленные к тренеру
     *
     * @return void
     */
    public function partner()
    {
        // Если пользователь не авторизован, переход на страницу авторизации
        if (empty($this->user_id) or $this->session->user['type'] != 2 or $this->session->user['blocked'] == 1)
        {
            parent::pageNotFound($this->page_url);
        }

        $this->load->model('Course_model');

        $result = $this->Course_model->getCoachCourses($this->user_id);

        // Объединенные данные страница
        $this->page_data['title'] = 'Партнерская программа - Курсы';
        $this->page_data['page_menu'] = 'partner';

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/profile');
        $this->load->view('user/profile_line');
        $this->load->view('course/partner_courses', $result);
        $this->load->view('footer/footer');
    }

    /**
     * Форма редактирования данных курса для тренера
     *
     * @param $course_id
     * @return void
     */
    public function partnerCourse($course_id)
    {
        // Если пользователь не авторизован, переход на страницу авторизации
        if (empty($this->user_id) or $this->session->user['type'] != 2 or $this->session->user['blocked'] == 1)
        {
            parent::pageNotFound($this->page_url);
        }

        $this->load->model('Course_model');
        
        $result = $this->Course_model->getPartnerCourse($course_id, $this->user_id);

        if ($this->input->post('bt_save_course', true)) {
            $discount = $this->input->post('coach_discount', true);
            $coach_discount = (is_numeric($discount) and $discount <= $result['course']['coach_percent'])
                ? $discount
                : 0;

            if ($coach_discount != $result['course']['coach_discount']) {
                $result_course = $this->Course_model->setPartnerCourseSettings($course_id, $this->user_id, $coach_discount, $this->date);

                if ($result_course === true) {
                    // Сохранено
                    $this->session->set_tempdata('message', 10, 60);
                } else {
                    // Не сохранено
                    $this->session->set_tempdata('message', 73, 60);
                }
            }

            header('Location: /partner/course/'.$course_id);
        }

        // Объединенные данные страница
        $this->page_data['title'] = 'Партнерская программа - Настройки курса';
        $this->page_data['page_menu'] = 'partner';

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/profile');
        $this->load->view('user/profile_line');
        $this->load->view('course/partner_course_settings', $result);
        $this->load->view('footer/footer');
    }

    public function coachPromocodes()
    {
        // Если пользователь не авторизован, переход на страницу авторизации
        if (empty($this->user_id) or $this->session->user['type'] != 2 or $this->session->user['blocked'] == 1)
        {
            parent::pageNotFound($this->page_url);
        }

        $this->load->model('Course_model');
        $result = $this->Course_model->getCoachPromocodes($this->user_id, $this->date);

        // Объединенные данные страница
        $this->page_data['title']     = 'Промокоды';
        $this->page_data['page_menu'] = 'c_promocodes';

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/profile');
        $this->load->view('user/profile_line');
        $this->load->view('promocodes/user_promocodes', $result);
        $this->load->view('footer/footer');
    }

    public function coachNewPromocode()
    {
        // Если пользователь не авторизован, переход на страницу авторизации
        if (empty($this->user_id) or $this->session->user['type'] != 2 or $this->session->user['blocked'] == 1)
        {
            parent::pageNotFound($this->page_url);
        }

        $this->load->model('Course_model');

        $coach_courses = $this->Course_model->getCoachCourses($this->user_id);

        if($this->input->post('bt_save_new_promocode', true))
        {
            $name           = $this->input->post('i_code_name', true);
            $desc           = $this->input->post('i_code_desc', true);
            $discount       = $this->input->post('i_code_discount', true);
            $discount_type  = 'percent';
            $rel_percent    = 0;
            $validity_type  = $this->input->post('s_pv_type', true);
            $date_start     = $this->input->post('i_validity_date_start', true);
            $date_end       = $this->input->post('i_validity_date_end', true);
            $use_type       = $this->input->post('s_ua_type', true);
            $ua_number      = $this->input->post('i_ua_number', true);
            $promocode      = $this->input->post('i_promocode', true);
            $courses        = '';
            $crs_group      = 'all';
            $crs_categories = '';

            $coach_course_id = (is_numeric($this->input->post('promo_coach_course', true))) ? $this->input->post('promo_coach_course', true) : null;
            $max_coach_percent = (!empty($coach_courses['coach_courses']) and !empty($coach_courses['coach_courses'][$coach_course_id]))
                ? $coach_courses['coach_courses'][$coach_course_id]['coach_percent'] : null;

            $courses[0] = (!empty($coach_course_id)) ? $coach_course_id : null;

            $discount = ($discount > $max_coach_percent) ? $max_coach_percent : $discount;

            $res_ins = parent::saveNewCoursePromocode($name, $desc, $discount, $discount_type, $rel_percent, $validity_type,
                $date_start, $date_end, $use_type, $ua_number, $promocode, $crs_group, $crs_categories, $courses, 0, $this->user_id);

            if (is_numeric($res_ins['promocode_id']) and $res_ins['error'] === false)
            {
                // Изменения сохранены
                $this->session->set_tempdata('message', 10, 60);
                header('Location: /profile/promocode/' . $res_ins['promocode_id']);
            }
            else
            {
                // Изменения не сохранены
                $this->session->set_tempdata('message', $res_ins['error'], 60);
                header('Location: /profile/promocode/new');
            }
        }

        // Объединенные данные страница
        $this->page_data['title']     = 'Промокоды';
        $this->page_data['page_menu'] = 'c_promocodes';

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/profile');
        $this->load->view('user/profile_line');
        $this->load->view('promocodes/user_new_promocode', $coach_courses);
        $this->load->view('footer/footer');
    }

    /**
     * @param $promocode_id
     */
    public function coachPromocode($promocode_id)
    {
        // Если пользователь не авторизован, переход на страницу авторизации
        if (empty($this->user_id) or $this->session->user['type'] != 2 or $this->session->user['blocked'] == 1)
        {
            parent::pageNotFound($this->page_url);
        }

        $this->load->model('Course_model');
        $coach_courses   = $this->Course_model->getCoachCourses($this->user_id);
        $coach_promocode = $this->Course_model->getCoachPromocode($this->user_id, $promocode_id, $this->date);
        $result = array_merge($coach_courses, $coach_promocode);

        if($this->input->post('bt_save_promocode', true))
        {
            $db_data = $coach_promocode['promocode'];

            $name          = mb_substr(strip_tags($this->input->post('i_code_name', true)), 0, 255);
            $desc          = mb_substr(strip_tags($this->input->post('i_code_desc', true)), 0, 255);
            $discount      = (is_numeric($this->input->post('i_code_discount', true))) ? $this->input->post('i_code_discount', true) : null;
            $discount_type = 'percent';
            $rel_percent   = 0;

            $validity_type = ($this->input->post('s_pv_type', true) == 'unlimited') ? 'unlimited' : 'date_range';
            $tmp_ds        = new DateTime($this->input->post('i_validity_date_start', true));
            $tmp_de        = new DateTime($this->input->post('i_validity_date_end', true));
            $pv_date_start = ($tmp_ds !== false and $validity_type == 'date_range') ? $tmp_ds->format('Y-m-d') : '';
            $pv_date_end   = ($tmp_de !== false and $validity_type == 'date_range') ? $tmp_de->format('Y-m-d') : '';

            $use_type  = ($this->input->post('s_ua_type', true) == 'unlimited') ? 'unlimited' : 'number';
            $ua_number = (is_numeric($this->input->post('i_ua_number', true)) and $use_type == 'number')
                ? $this->input->post('i_ua_number', true) : '';

            $generated_code = strtoupper(mb_substr(strip_tags($this->input->post('i_promocode', true)), 0, 25));

            $coach_course_id = (is_numeric($this->input->post('promo_coach_course', true))) ? $this->input->post('promo_coach_course', true) : null;
            $max_coach_percent = (!empty($coach_courses['coach_courses']) and !empty($coach_courses['coach_courses'][$coach_course_id]))
                ? $coach_courses['coach_courses'][$coach_course_id]['coach_percent'] : null;

            if(!empty($db_data['coach_course_id']) and $coach_course_id != $db_data['coach_course_id'])
            {
                $courses['update'][0] = $coach_course_id;
            }
            elseif(empty($db_data['coach_course_id'] and !empty($coach_course_id)))
            {
                $courses['insert'][0] = $coach_course_id;
            }

            $discount = ($discount > $max_coach_percent) ? $max_coach_percent : $discount;

            // Группы курсов, на которые распространяется промокод
            $pc_type = 'course';

            // Категории курсов, на которые распространяется промокод
            $crs_categories = '';

            if((!empty($discount) and $discount != $db_data['discount'])
                or (!empty($generated_code) and $generated_code != $db_data['code']) or $name != $db_data['name']
                or $desc != $db_data['description'] or $validity_type != $db_data['validity_type']
                or $pv_date_start != $db_data['pv_date_start'] or $pv_date_end != $db_data['pv_date_end']
                or $use_type != $db_data['use_type'] or $ua_number != $db_data['ua_number'])
            {
                $res_up = $this->Course_model->updateCoachPromocode($this->user_id, $promocode_id, $pc_type, $name, $desc, $discount, $discount_type,
                    $rel_percent, $validity_type, $pv_date_start, $pv_date_end, $use_type, $ua_number, $generated_code,
                    $crs_categories, $this->date);

                if ($res_up === true)
                {
                    // Изменения сохранены
                    $this->session->set_tempdata('message', 10, 60);
                }
                else
                {
                    // Изменения не сохранены
                    $this->session->set_tempdata('message', 145, 60);
                }
            }
            elseif($coach_course_id != $db_data['coach_course_id'])
            {
                $res_up = $this->Course_model->updatePromocodeCourses($promocode_id, $courses, 0, $this->date);

                if ($res_up === true)
                {
                    // Изменения сохранены
                    $this->session->set_tempdata('message', 10, 60);
                }
                else
                {
                    // Изменения не сохранены
                    $this->session->set_tempdata('message', 145, 60);
                }
            }

            header('Location: /profile/promocode/' . $promocode_id);
        }
        elseif($this->input->post('bt_block_promocode', true))
        {
            $up_data = $this->Course_model->blockPromocode($promocode_id, 1, 0, $this->user_id, $this->date);

            if ($up_data === true)
            {
                // Изменения сохранены
                $this->session->set_tempdata('message', 147, 60);
            }
            else
            {
                // Изменения не сохранены
                $this->session->set_tempdata('message', 145, 60);
            }
            header('Location: /profile/promocode/' . $promocode_id);
        }
        elseif($this->input->post('bt_unblock_promocode', true))
        {
            $up_data = $this->Course_model->blockPromocode($promocode_id, 0, 0, $this->user_id, $this->date);

            if ($up_data === true)
            {
                // Изменения сохранены
                $this->session->set_tempdata('message', 148, 60);
            }
            else
            {
                // Изменения не сохранены
                $this->session->set_tempdata('message', 145, 60);
            }
            header('Location: /profile/promocode/' . $promocode_id);
        }

        // Объединенные данные страница
        $this->page_data['title']     = 'Промокоды';
        $this->page_data['page_menu'] = 'c_promocodes';

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/profile');
        $this->load->view('user/profile_line');
        $this->load->view('promocodes/user_promocode', $result);
        $this->load->view('footer/footer');
    }
}