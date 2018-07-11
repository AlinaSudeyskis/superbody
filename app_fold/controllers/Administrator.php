<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Administration class
 * 
 * Класс для работы с данными администратора
 *
 * @author Alina Sudeyskis <alina.sudeyskis@gmail.com>
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Administrator extends CI_Controller
{
    /**
     * Administration constructor.
     */
    public function __construct()
    {
        parent::__construct();

        if (empty($this->user_id) or 3 != $this->session->user['type'] or $this->session->user['blocked'] == 1)
        {
            parent::pageNotFound($this->page_url);
        }

        $this->load->model('Administrator_model');
    }

    /**
     * Главная страница админ. панели
     *
     * @return void
     */
    public function index()
    {
        // Объединенные данные страница
        $this->page_data['title'] = 'Администраторская панель';
        $this->page_data['page_menu'] = '';

        $this->load->view('header/header_admin', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('admin/index');
        $this->load->view('footer/footer');
    }

    /**
     * Вывод списка администраторов
     *
     * @return void
     */
    public function admins()
    {
        $result['admins'] = $this->Administrator_model->getAdmins();

        // Объединенные данные страница
        $this->page_data['title'] = 'АП - Администраторы';
        $this->page_data['page_menu'] = 'admins';

        $this->load->view('header/header_admin', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('admin/admins', $result);
        $this->load->view('footer/footer');
    }

    /**
     * Форма добавления и сохранение нового администратора
     *
     * @return void
     */
    public function newAdmin()
    {
        if ($this->input->post('bt_save_new_admin', true)) {
            // Валидация E-mail
            $email         = null;
            $email_hash    = null;
            $password_hash = '';

            if (!empty($this->input->post('email', true))
                && filter_var($this->input->post('email', true), FILTER_VALIDATE_EMAIL))
            {
                $email      = $this->input->post('email', true);
                $email_hash = password_hash($this->input->post('email', true), PASSWORD_DEFAULT);
            }

            // Имя пользователя
            $name = mb_substr(strip_tags($this->input->post('name', true)), 0, 255);

            // Сохранение данных в БД
            if (!empty($email))
            {
                $result = $this->Administrator_model->setNewAdmin($email, $name, $password_hash, $email_hash, $this->date);

                if (is_numeric($result))
                {
                    // Отправление письма с данными администратора
                    $system_message['text']  = '<b><a href="https://superbody.pro/activate?e=' . $email . '&ac=' . $email_hash
                        . '" style="display: inline-block; width:100%; text-align:center; padding:0; margin:0">';
                    $system_message['text']  .= 'Подтвердить';
                    $system_message['text']  .= '</a></b>';

                    parent::sendEmail(1, $email, $system_message);

                    $admin_id    = $result;
                    $path_avatar = '';

                    // Загрузка изображения на сервер
                    if(is_uploaded_file($_FILES['avatar_file']['tmp_name']))
                    {
                        $path = './user_files/'.$admin_id.'/avatar/';

                        if(!file_exists($path))
                        {
                            chdir('user_files');
                            if(!is_dir($admin_id))
                            {
                                mkdir($admin_id);
                            }
                            chmod($admin_id, 0777);
                            chdir($admin_id);
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
                        $this->Administrator_model->setAdminAvatar($admin_id, $path_avatar);
                    }

                    // Сохранено
                    $this->session->set_tempdata('message', 10, 60);

                    header('Location: /administration/admin/' . $admin_id);
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

                    header('Location: /administration/admin/new');
                }
            }
            else
            {
                // Не удалось сохранить запись в БД
                $this->session->set_tempdata('message', 14, 60);

                header('Location: /administration/admin/new');
            }

        }

        // Объединенные данные страница
        $this->page_data['title'] = 'АП - Добавление администратора';
        $this->page_data['page_menu'] = 'admins';

        $this->load->view('header/header_admin', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('admin/new_admin');
        $this->load->view('footer/footer');
    }

    /**
     * Форма добавления и сохранение выбранных администраторов из пользователей
     *
     * @return void
     */
    public function newAdminOfTheUsers()
    {
        if ($this->input->post('bt_save_new_admins', true))
        {
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
            $type = 3;

            // Изменение тип пользователя на администратор
            if (!empty($users)) {
                foreach ($users as $user_id) {
                    $result = $this->Administrator_model->changeUserType($user_id, $type, $this->date);

                    if ($result === true) {
                        $this->load->model('User_model');
                        $result = $this->User_model->getUser($user_id);
                        $user_data = $result['user_data'];

                        // Отправка уведомления по email
                        $system_message['text'] = '';

                        parent::sendEmail(4, $user_data['email'], $system_message);

                        // Сохранено
                        $this->session->set_tempdata('message', 82, 60);
                    }
                    else {
                        // Не удалось изменить тип пользователя
                        $this->session->set_tempdata('message', 86, 60);
                    }
                }
                unset($user_id);
            }

            header('Location: /administration/admin/new/users');
        }

        // Объединенные данные страница
        $this->page_data['title'] = 'АП - Выбор администратора из пользователей';
        $this->page_data['page_menu'] = 'admins';

        $this->load->view('header/header_admin', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('admin/new_admin_of_users');
        $this->load->view('footer/footer');
    }

    /**
     * Форма редактирования и сохранение изменений настроек администратора
     *
     * @param $user_id
     * @return void
     */
    public function adminSettings($user_id)
    {
        $user = $this->Administrator_model->getAdmin($user_id);
        if (!empty($user['user_data']))
        {
            $this->load->model('User_model');
            $user = $this->User_model->getUserSettingsData($user_id);
        }

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

            // Имя пользователя
            $name = mb_substr(strip_tags($this->input->post('name', true)), 0, 255);

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
                //delete_files($path);

                //print_r($path);
                $path_image = parent::uploadImage('avatar_file', $_FILES['avatar_file']['type'], $path);
                if(file_exists($path.$path_image)){
                    if ($this->security->xss_clean($path.$path_image, TRUE) !== FALSE) {
                        // файл прошел XSS тест
                        $path_avatar = $path.$path_image;

                        if (!empty($user_data['user_image']) and is_file($user_data['user_image'])) {
                            unlink('.' . $user_data['user_image']);
                        }
                    } else{
                        unlink($path);
                    }
                }
            }

            // Сохранение данных в БД
            $result = $this->Administrator_model->setAdminSettings($user_id, $email, $name, $path_avatar, $this->date);

            if ($result === true) {
                // Сохранено
                $this->session->set_tempdata('message', 10, 60);
            } else {
                // Не сохранено
                $this->session->set_tempdata('message', 9, 60);
            }

            header('Location: /administration/admin/'.$user_id);
        }
        elseif ($this->input->post('bt_block_user', true) and is_numeric($user_id)) {
            $result = $this->Administrator_model->blockAdmin($user_id, $this->date);

            if ($result === true) {
                // Сохранено
                $this->session->set_tempdata('message', 16, 60);
            } else {
                // Не сохранено
                $this->session->set_tempdata('message', 17, 60);
            }
        }
        elseif ($this->input->post('bt_unblock_user', true) and is_numeric($user_id)) {
            $result = $this->Administrator_model->unblockAdmin($user_id, $this->date);

            if ($result === true) {
                // Сохранено
                $this->session->set_tempdata('message', 18, 60);
            } else {
                // Не сохранено
                $this->session->set_tempdata('message', 19, 60);
            }            
        }
        elseif ($this->input->post('bt_delete_user', true) and is_numeric($user_id)) {
            $type = 1;
            $result = $this->Administrator_model->changeUserType($user_id, $type, $this->date);

            if ($result === true) {
                $result = $this->User_model->getUser($user_id);
                $user_data = $result['user_data'];

                // Отправка уведомления по email
                $system_message['text'] = '';

                parent::sendEmail(5, $user_data['email'], $system_message);

                // Сохранено. Тип Администратора изменен на тип Пользователя
                $this->session->set_tempdata('message', 84, 60);

                header('Location: /administration/user/'.$user_id);
            } else {
                // Не сохранено
                $this->session->set_tempdata('message', 86, 60);
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
            header('Location: /administration/admin/'.$user_id);
        }
        elseif ($this->input->post('bt_save_data', true))
        {
            $res_gb = false;
            $res_cd = false;

            // Пол
            $gender = (0 == $this->input->post('gender', true)) ? 'male' : 'female';

            // Дата рождения
            $b_day  = is_numeric($this->input->post('b_day', true)) ? $this->input->post('b_day', true) : '';
            $b_mon  = is_numeric($this->input->post('b_mon', true)) ? $this->input->post('b_mon', true) : '';
            $b_year = is_numeric($this->input->post('b_year', true)) ? $this->input->post('b_year', true) : '';
            $birthday = $b_day . '.' . $b_mon . '.' . $b_year;
            $date = DateTime::createFromFormat('d.m.Y', $birthday);
            $birthday = ($date !== false) ? $date->format('Y-m-d') : '';

            $db_birthday = $user_data['user_b_day'] . '.' . $user_data['user_b_mon'] . '.' . $user_data['user_b_year'];
            $date = DateTime::createFromFormat('d.m.Y', $db_birthday);
            $db_birthday = ($date !== false) ? $date->format('Y-m-d') : '';

            // Сохранение пола и даты рождения
            if ($gender != $user_data['user_gender'] or $birthday != $db_birthday) {
                $res_gb = $this->User_model->setUserGenderBd($user_id, $gender, $birthday, $this->date);

                if ($res_gb === true and !empty($user_data['weight'])) {
                    parent::calcBmiBmr($user_id, $user_data['weight']);
                }
            }

            if ($res_gb === false) {
                // Дата рождения и пол не сохранены
                $this->session->set_tempdata('message', 96, 60);
            }
            elseif ($res_gb === true) {
                // Сохранено
                $this->session->set_tempdata('message', 10, 60);
            }

            header('Location: /administration/couch/'.$user_id);
        }

        // Объединенные данные страница
        $this->page_data['title'] = 'АП - Редактирование данных администратора';
        $this->page_data['page_menu'] = 'admins';

        $this->load->view('header/header_admin', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('admin/admin_settings', $user);
        $this->load->view('footer/footer');
    }

    /**
     * Подписчики
     *
     * @return void
     */
    public function sublist()
    {
        $result = $this->Administrator_model->getSublist();

        // Объединенные данные страница
        $this->page_data['title'] = 'АП - Подписчики';
        $this->page_data['page_menu'] = 'sublist';

        $this->load->view('header/header_admin', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('user/sublist_users', $result);
        $this->load->view('footer/footer');
    }

    /**
     * Информация о сайте
     *
     * @param string $page
     */
    public function siteInfo($page = '')
    {
        if (empty($this->user_id) or $this->session->user['type'] != 3)
        {
            parent::pageNotFound($this->page_url);
        }

        $result = null;

        if ($page == '')
        {
            $result = $this->Administrator_model->getSiteIndex();
            $this->page_data['page_submenu'] = 'index';
        }
        elseif ($page == 'header')
        {
            $result = $this->Administrator_model->getSiteHeader();
            $this->page_data['page_submenu'] = 'header';
        }
        elseif ($page == 'banner')
        {
            $this->page_data['page_submenu'] = 'banner';
            $result = $this->Administrator_model->getSiteBanners();
        }
        elseif ($page == 'about')
        {
            $result = $this->Administrator_model->getSiteAbout();
            $this->page_data['page_submenu'] = 'a_about';
        }
        elseif ($page == 'contacts')
        {
            $result = $this->Administrator_model->getSiteContacts();
            $this->page_data['page_submenu'] = 'a_contacts';
        }
        elseif ($page == 'auth')
        {
            $result = $this->Administrator_model->getSiteAuth();
            $this->page_data['page_submenu'] = 'a_auth';
        }

        // Сохранение изменений
        if ($this->input->post('bt_save_index', true))
        {
            $title = mb_substr(strip_tags($this->input->post('i_title', true)), 0, 40);
            $text  = mb_substr(strip_tags($this->input->post('i_text', true)), 0, 300);

            $result = $this->Administrator_model->setSiteIndex($title, $text, $this->date, $this->user_id);

            if ($result === true)
            {
                // Изменения сохранены
                $this->session->set_tempdata('message', 10, 60);
            }
            else
            {
                // Изменения не сохранены
                $this->session->set_tempdata('message', 111, 60);
            }

            header('Location: /administration/site');
        }
        elseif ($this->input->post('bt_save_header', true))
        {
            // Загрузка логотипа на сервер
            $logotype = '.' . $result['logotype'];
            if(is_uploaded_file($_FILES['logotype_file']['tmp_name'])){
                $path = './logo/';
                $this->load->helper('file');

                $path_image = parent::uploadImage('logotype_file', $_FILES['logotype_file']['type'], $path);
                if(is_file($path.$path_image))
                {
                    if ($this->security->xss_clean($path.$path_image, TRUE) !== FALSE)
                    {
                        // файл прошел XSS тест
                        $logotype = $path.$path_image;

                        if (is_file($result['logotype']))
                        {
                            unlink('.' . $result['logotype']);
                        }
                    }
                    else
                    {
                        unlink($path.$path_image);
                    }
                }
            }

            $agreement = mb_substr(strip_tags($this->input->post('agreement', true)), 0, 255);
            $private_policy = mb_substr(strip_tags($this->input->post('private_policy', true)), 0, 255);
            $personal_data = mb_substr(strip_tags($this->input->post('personal_data', true)), 0, 255);
            $rights = mb_substr(strip_tags($this->input->post('rights', true)), 0, 300);
            $footer = mb_substr(strip_tags($this->input->post('footer', true)), 0, 300);

            $soc_facebook  = mb_substr(strip_tags($this->input->post('soc_facebook', true)), 0, 255);
            $soc_twitter   = mb_substr(strip_tags($this->input->post('soc_twitter', true)), 0, 255);
            $soc_pinterest = mb_substr(strip_tags($this->input->post('soc_pinterest', true)), 0, 255);
            $soc_google    = mb_substr(strip_tags($this->input->post('soc_google', true)), 0, 255);
            $soc_tumblr    = mb_substr(strip_tags($this->input->post('soc_tumblr', true)), 0, 255);
            $soc_instagram = mb_substr(strip_tags($this->input->post('soc_instagram', true)), 0, 255);
            $soc_ok        = mb_substr(strip_tags($this->input->post('soc_ok', true)), 0, 255);
            $soc_vk        = mb_substr(strip_tags($this->input->post('soc_vk', true)), 0, 255);
            $soc_youtube   = mb_substr(strip_tags($this->input->post('soc_youtube', true)), 0, 255);

            $result = $this->Administrator_model->setSiteHeader($logotype, $agreement, $private_policy, $personal_data,
                $rights, $footer, $soc_facebook, $soc_twitter, $soc_pinterest, $soc_google, $soc_tumblr, $soc_instagram,
                $soc_ok, $soc_vk, $soc_youtube, $this->date, $this->user_id);

            if ($result === true) {
                // Изменения сохранены
                $this->session->set_tempdata('message', 10, 60);
            } else {
                // Изменения не сохранены
                $this->session->set_tempdata('message', 111, 60);
            }

            header('Location: /administration/site/header');
        }
        elseif ($this->input->post('bt_save_about', true))
        {
            $about = mb_substr(strip_tags($this->input->post('about_us', true), '<span><br/><b><i><p>'), 0, 5000);

            $result = $this->Administrator_model->setSiteAbout($about, $this->date, $this->user_id);

            if ($result === true) {
                // Изменения сохранены
                $this->session->set_tempdata('message', 10, 60);
            } else {
                // Изменения не сохранены
                $this->session->set_tempdata('message', 111, 60);
            }

            header('Location: /administration/site/about');
        }
        elseif ($this->input->post('bt_save_contacts', true))
        {
            $email = mb_substr(strip_tags($this->input->post('email', true)), 0, 255);
            $phone = mb_substr(strip_tags($this->input->post('phone', true)), 0, 255);
            $contacts_text1 = mb_substr(strip_tags($this->input->post('contacts_text1', true)), 0, 300);
            $contacts_text2 = mb_substr(strip_tags($this->input->post('contacts_text2', true)), 0, 300);

            $result = $this->Administrator_model->setSiteContacts($email, $phone, $contacts_text1, $contacts_text2, $this->date, $this->user_id);

            if ($result === true) {
                // Изменения сохранены
                $this->session->set_tempdata('message', 10, 60);
            } else {
                // Изменения не сохранены
                $this->session->set_tempdata('message', 111, 60);
            }

            header('Location: /administration/site/contacts');
        }
        elseif ($this->input->post('bt_save_auth', true))
        {
            $title_1 = mb_substr(strip_tags($this->input->post('i_title_1', true)), 0, 30);
            $title_2 = mb_substr(strip_tags($this->input->post('i_title_2', true)), 0, 30);
            $subtitle_1 = mb_substr(strip_tags($this->input->post('i_subtitle_1', true)), 0, 30);
            $subtitle_2 = mb_substr(strip_tags($this->input->post('i_subtitle_2', true)), 0, 30);
            $text_1 = mb_substr(strip_tags($this->input->post('ta_text_1', true)), 0, 150);
            $text_2 = mb_substr(strip_tags($this->input->post('ta_text_2', true)), 0, 150);
            $url_1 = mb_substr(strip_tags($this->input->post('i_url_1', true)), 0, 255);
            $url_2 = mb_substr(strip_tags($this->input->post('i_url_2', true)), 0, 255);
            $url_name_1 = mb_substr(strip_tags($this->input->post('i_url_name_1', true)), 0, 30);
            $url_name_2 = mb_substr(strip_tags($this->input->post('i_url_name_2', true)), 0, 15);

            $result = $this->Administrator_model->setSiteAuth($title_1, $title_2, $subtitle_1, $subtitle_2, $text_1,
                $text_2, $url_1, $url_2, $url_name_1, $url_name_2, $this->date, $this->user_id);

            if ($result === true)
            {
                // Изменения сохранены
                $this->session->set_tempdata('message', 10, 60);
            }
            else
            {
                // Изменения не сохранены
                $this->session->set_tempdata('message', 134, 60);
            }

            header('Location: /administration/site/auth');
        }

        // Объединенные данные страница
        $this->page_data['title'] = 'Информация о сайте - АП';
        $this->page_data['page_menu'] = 'site_info';

        $this->load->view('header/header_admin', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('site/info', $result);
        $this->load->view('footer/footer');
    }

    /**
     * Форма добавления нового баннера
     */
    public function newBanner()
    {
        if (empty($this->user_id) or $this->session->user['type'] != 3)
        {
            parent::pageNotFound($this->page_url);
        }

        if ($this->input->post('bt_save_banner'))
        {
            // Загрузка изображения на сервер
            $banner_img = '';
            if(is_uploaded_file($_FILES['banner_file']['tmp_name']))
            {
                $path = './banners/';
                $this->load->helper('file');

                $path_image = parent::uploadImage('banner_file', $_FILES['banner_file']['type'], $path);
                if(is_file($path.$path_image))
                {
                    if ($this->security->xss_clean($path.$path_image, TRUE) !== FALSE)
                    {
                        // файл прошел XSS тест
                        $banner_img = $path.$path_image;
                    }
                    else
                    {
                        unlink($path.$path_image);
                    }
                }
            }

            $banner_url = filter_var($this->input->post('banner_url', true), FILTER_VALIDATE_URL);

            if (!empty($banner_img))
            {
                $result = $this->Administrator_model->setNewBanner($banner_img, $banner_url, $this->user_id, $this->date);


                if (is_numeric($result))
                {
                    // Сохранено
                    $this->session->set_tempdata('message', 10, 60);

                    header('Location: /administration/site/banner/'.$result);
                }
                else
                {
                    // Не сохранено
                    $this->session->set_tempdata('message', 116, 60);

                    header('Location: /administration/site/banner/new');
                }
            }
            else
            {
                // Не сохранено
                $this->session->set_tempdata('message', 117, 60);

                header('Location: /administration/site/banner/new');
            }
        }

        // Объединенные данные страница
        $this->page_data['title'] = 'Новый баннер - АП';
        $this->page_data['page_menu'] = 'site_info';
        $this->page_data['page_submenu'] = 'banner';

        $this->load->view('header/header_admin', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('site/banner/new_banner');
        $this->load->view('footer/footer');
    }

    /**
     * Форма редактирования баннера
     * @param $banner_id
     */
    public function siteBanner($banner_id)
    {
        if (empty($this->user_id) or $this->session->user['type'] != 3)
        {
            parent::pageNotFound($this->page_url);
        }

        $result = $this->Administrator_model->getBanner($banner_id);

        if ($this->input->post('bt_save_banner', true))
        {
            // Загрузка изображения на сервер
            $banner_img = $result['banner']['image'];
            if(is_uploaded_file($_FILES['banner_file']['tmp_name'])){
                $path = './banners/';
                $this->load->helper('file');

                $path_image = parent::uploadImage('banner_file', $_FILES['banner_file']['type'], $path);
                if(is_file($path.$path_image))
                {
                    if ($this->security->xss_clean($path.$path_image, TRUE) !== FALSE)
                    {
                        // файл прошел XSS тест
                        $banner_img = $path.$path_image;

                        if (is_file($result['banner']['image']))
                        {
                            unlink('.' . $result['banner']['image']);
                        }
                    }
                    else
                    {
                        unlink($path.$path_image);
                    }
                }
            }

            $url = filter_var($this->input->post('banner_url', true), FILTER_VALIDATE_URL);
            $banner_url = $url != $result['banner']['url'] ? $url : $result['banner']['url'];

            if ((!empty($banner_img) and $result['banner']['image'] != $banner_img) or $banner_url != $result['banner']['url'])
            {
                $res_b = $this->Administrator_model->setNewBanner($banner_img, $banner_url, $this->user_id, $this->date);

                if ($res_b === true)
                {
                    // Сохранено
                    $this->session->set_tempdata('message', 10, 60);
                }
                else
                {
                    // Не сохранено
                    $this->session->set_tempdata('message', 116, 60);
                }
            }
            else
            {
                // Не сохранено
                $this->session->set_tempdata('message', 117, 60);
            }

            header('Location: /administration/site/banner/'.$banner_id);
        }
        elseif ($this->input->post('bt_block_banner', true))
        {
            $res_b = $this->Administrator_model->blockBanner($banner_id, $this->date);

            if ($res_b === true)
            {
                // Сохранено
                $this->session->set_tempdata('message', 10, 60);
            }
            else
            {
                // Не сохранено
                $this->session->set_tempdata('message', 118, 60);
            }

            header('Location: /administration/site/banner/'.$banner_id);
        }
        elseif ($this->input->post('bt_unblock_banner', true))
        {
            $res_b = $this->Administrator_model->unblockBanner($banner_id, $this->date);

            if ($res_b === true)
            {
                // Сохранено
                $this->session->set_tempdata('message', 10, 60);
            }
            else
            {
                // Не сохранено
                $this->session->set_tempdata('message', 119, 60);
            }

            header('Location: /administration/site/banner/'.$banner_id);
        }
        elseif ($this->input->post('bt_delete_banner', true))
        {
            if (is_file('.' . $result['banner']['image']))
            {
                unlink('.' . $result['banner']['image']);
            }

            $res_b = $this->Administrator_model->deleteBanner($banner_id);

            if ($res_b === true)
            {
                // Сохранено
                $this->session->set_tempdata('message', 10, 60);

                header('Location: /administration/site/banner');
            }
            else {
                // Не сохранено
                $this->session->set_tempdata('message', 119, 60);

                header('Location: /administration/site/banner/'.$banner_id);
            }
        }

        // Объединенные данные страница
        $this->page_data['title'] = 'Редактирование данных баннера - АП';
        $this->page_data['page_menu'] = 'site_info';
        $this->page_data['page_submenu'] = 'banner';

        $this->load->view('header/header_admin', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('site/banner/banner_settings', $result);
        $this->load->view('footer/footer');
    }
}