<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Couch class
 * 
 * Класс для работы с данными тренера
 *
 * @author Alina Sudeyskis <alina.sudeyskis@gmail.com>
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Couch extends CI_Controller
{
    /**
     * Couch constructor.
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->load->model('Couch_model');
    }

    /**
     * Вывод списка тренеров в АП
     *
     * @return void
     */
    public function couches()
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3) {
            show_404();
        }

        $result = $this->Couch_model->getCouches();

        // Объединенные данные страница
        $this->page_data['title'] = 'АП - Тренеры';
        $this->page_data['page_menu'] = 'a_couches';

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('couch/couches', $result);
        $this->load->view('footer/footer');
    }

    /**
     * Вывод списка тренеров для посльзователя
     *
     * @return void
     */
    public function publicCouches()
    {
        $result = $this->Couch_model->getCouches();

        // Объединенные данные страница
        $this->page_data['title'] = 'Тренеры';
        $this->page_data['page_menu'] = 'couches';

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/secondary');
        $this->load->view('couch/public_couches', $result);
        $this->load->view('footer/footer');
    }

    /**
     * Форма добавления и сохранение нового тренеров
     *
     * @return void
     */
    public function newCouch()
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3) {
            show_404();
        }

        if ($this->input->post('bt_save_new_couch', true)) {
            // Валидация E-mail
            $email      = null;
            $email_hash = null;
            if (!empty($this->input->post('email', true))
                && filter_var($this->input->post('email', true), FILTER_VALIDATE_EMAIL))
            {
                $email      = $this->input->post('email', true);
                $email_hash = password_hash($this->input->post('email', true), PASSWORD_DEFAULT);
            }

            // Имя пользователя
            $name = mb_substr(strip_tags($this->input->post('name', true)), 0, 255);

            $arr = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','r','s',
                't','u','v','x','y','z','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','R','S',
                'T','U','V','X','Y','Z','1','2','3','4','5','6','7','8','9','0','.',',','(',')','[',']','!','?',
                '&','^','%','@','*','$','<','>','/','|','+','-','{','}','`','~');
            // Генерируем 8мизначный пароль
            $password = "";
            for($i = 0; $i < 8; $i++)
            {
                // Вычисляем случайный индекс массива
                $index = rand(0, count($arr) - 1);
                $password .= $arr[$index];
            }

            // Хэш пароля
            $password_hash = !empty($password) ? password_hash($password, PASSWORD_DEFAULT) : null;

            // Сохранение данных в БД
            if (!empty($email) and !empty($password))
            {
                $result = $this->Couch_model->setNewCouch($email, $name, $password_hash, $email_hash, $this->date);

                if (is_numeric($result))
                {
                    $couch_id = $result;
                    // Отправление письма с данными администратора
                    $email_to  = "<$email>";

                    $subject   = "Регистрации на сайте SuperBody";

                    $message   = "<p>Ваши данные для авторизации на сайте SuperBody:</p> 
                    <p>E-mail: $email</p> 
                    <p>Пароль: $password</p>";

                    $headers   = "Content-type: text/html; charset=utf-8 \r\n";
                    $headers   .= "From: Support SuperBody.pro <info@superbody.pro>\r\n";
                    $headers   .= "Reply-To: info@superbody.pro\r\n";

                    mail($email_to, $subject, $message, $headers);

                    // Сохранено
                    $this->session->set_tempdata('message', 10, 60);

                    header('Location: /administration/couch/' . $couch_id);
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

                    header('Location: /administration/couch/new');
                }
            }
        }
        else
        {
            // Некорректные данные
            $this->session->set_tempdata('message', 15, 60);

            header('Location: /administration/couch/new');
        }

        // Объединенные данные страница
        $this->page_data['title'] = 'АП - Добавление тренера';
        $this->page_data['page_menu'] = 'couches';

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('couch/new_couch');
        $this->load->view('footer/footer');
    }

    /**
     * Форма добавления и сохранение выбранных тренеров из пользователей
     *
     * @return void
     */
    public function newCouchOfTheUsers()
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3) {
            show_404();
        }

        if ($this->input->post('bt_save_new_couches', true)) {
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
            if (!empty($users)) {
                foreach ($users as $user_id) {
                    $this->load->model('Administrator_model');
                    $result = $this->Administrator_model->changeUserType($user_id, $type, $this->date);

                    if ($result === true) {
                        $this->load->model('User_model');
                        $result = $this->User_model->getUser($user_id);
                        $user_data = $result['user_data'];

                        $email = $user_data['email'];
                        // Отправление письма с данными администратора
                        $email_to  = "<$email>";

                        $subject   = "Изменение данных пользователя. SuperBody";

                        $message   = "<p>Ваш тип пользователя на сайте SuperBody изменен на Тренер.</p>";

                        $headers   = "Content-type: text/html; charset=utf-8 \r\n";
                        $headers   .= "From: Support SuperBody.pro <info@superbody.pro>\r\n";
                        $headers   .= "Reply-To: info@superbody.pro\r\n";

                        mail($email_to, $subject, $message, $headers);

                        // Сохранено
                        $this->session->set_tempdata('message', 83, 60);
                    }
                    else {
                        // Не удалось изменить тип пользователя
                        $this->session->set_tempdata('message', 86, 60);
                    }
                }
                unset($user_id);
            }

            header('Location: /administration/couch/new/users');
        }

        // Объединенные данные страница
        $this->page_data['title'] = 'АП - Выбор тренера из пользователей';
        $this->page_data['page_menu'] = 'couches';

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('couch/new_couch_ot_users');
        $this->load->view('footer/footer');
    }

    /**
     * Форма редактирования и сохранение изменений настроек тренера
     *
     * @param $user_id
     * @return void
     */
    public function couchSettings($user_id)
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3) {
            show_404();
        }

        $user_data = $this->Couch_model->getCouch($user_id);

        if ($this->input->post('bt_save_user_settings', true) and is_numeric($user_id))
        {
            $user_data = $this->Couch_model->getCouch($user_id);

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
            $result = $this->Couch_model->setCouchSettings($user_id, $email, $name, $path_avatar, $this->date);
            $this->Couch_model->setCouchData($user_id, $special, $experience, $titles_awards, $about, $this->date);

            if ($result === true) {
                // Сохранено
                $this->session->set_tempdata('message', 10, 60);
            } else {
                // Не сохранено
                $this->session->set_tempdata('message', 9, 60);
            }

            header('Location: /administration/couch/'.$user_id);
        }
        elseif ($this->input->post('bt_block_user', true) and is_numeric($user_id)) {
            $result = $this->Couch_model->blockCouch($user_id, $this->date);

            if ($result === true) {
                // Сохранено
                $this->session->set_tempdata('message', 16, 60);
            } else {
                // Не сохранено
                $this->session->set_tempdata('message', 17, 60);
            }
        }
        elseif ($this->input->post('bt_unblock_user', true) and is_numeric($user_id)) {
            $result = $this->Couch_model->unblockCouch($user_id, $this->date);

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
            $this->load->model('Administrator_model');
            $result = $this->Administrator_model->changeUserType($user_id, $type, $this->date);

            if ($result === true) {
                $result = $this->User_model->getUser($user_id);
                $user_data = $result['user_data'];

                $email = $user_data['email'];
                // Отправление письма с данными администратора
                $email_to  = "<$email>";

                $subject   = "Изменение данных пользователя. SuperBody";

                $message   = "<p>Ваш тип пользователя на сайте SuperBody изменен на Пользователь.</p>";

                $headers   = "Content-type: text/html; charset=utf-8 \r\n";
                $headers   .= "From: Support SuperBody.pro <info@superbody.pro>\r\n";
                $headers   .= "Reply-To: info@superbody.pro\r\n";

                mail($email_to, $subject, $message, $headers);

                // Сохранено. Тип Тренер изменен на тип Пользователя
                $this->session->set_tempdata('message', 85, 60);

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
            header('Location: /administration/couch/'.$user_id);
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
            $b_year = is_numeric($this->input->post('b_year', true)) ? $this->input->post('b_year', true) : 0000;
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
                $res_cd = $this->Couch_model->setCouchData($user_id, $special, $experience, $title_awards, $about, $this->date);
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
        $this->page_data['title'] = 'АП - Редактирование данных тренера';
        $this->page_data['page_menu'] = 'a_couches';

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('couch/settings/couch_settings', $user_data);
        $this->load->view('footer/footer');
    }

    /**
     * Страница портфолио тренера.
     *
     * Загрузка, удаление фотографий
     *
     * @return void
     */
    public function couchPortfolio()
    {
        // Если пользователь не авторизован, переход на страницу авторизации
        if (empty($this->user_id) or $this->session->user['type'] != 2)
        {
            show_404($this->page_url);
        }

        if ($this->input->post('bt_save_images', true)) {
            $path = './user_files/'.$this->user_id.'/portfolio/';
            $files_data = array();
            $temp_files = $_FILES;

            if(!file_exists('./user_files/'.$this->user_id.'/portfolio/')){
                chdir('user_files');
                if(!is_dir($this->user_id)){
                    mkdir($this->user_id);
                }
                chmod($this->user_id, 0777);
                chdir($this->user_id);
                if(!is_dir('portfolio')){
                    mkdir('portfolio');
                }
                chmod('portfolio', 0777);
                chdir('portfolio');
                chdir('../../../');
            }

            $i = 0;
            foreach ($temp_files['portfolio_images']['name'] as $name){

                $_FILES['portfolio_images'] = array (
                    'name'=>$temp_files['portfolio_images']['name'][$i],
                    'type'=>$temp_files['portfolio_images']['type'][$i],
                    'tmp_name'=>$temp_files['portfolio_images']['tmp_name'][$i],
                    'error'=>$temp_files['portfolio_images']['error'][$i],
                    'size'=>$temp_files['portfolio_images']['size'][$i]);

                $path_image = parent::uploadImage('portfolio_images', $_FILES['portfolio_images']['type'], $path);

                if(file_exists('./user_files/'.$this->user_id.'/portfolio/'.$path_image)){
                    if ($this->security->xss_clean('./user_files/'.$this->user_id.'/portfolio/'.$path_image, TRUE) !== FALSE) {
                        // файл прошел XSS тест
                        $files_data[] = './user_files/'.$this->user_id.'/portfolio/'.$path_image;

                    } else{
                        unlink('./user_files/'.$this->user_id.'/portfolio/'.$path_image);
                        /*$image = pathinfo($path_image);
                        $mini_image = $image['filename'].'_thumb.'.$image['extension'];
                        if(file_exists('./user_files/'.$this->user_id.'/portfolio/'.$mini_image)){
                            unlink('./user_files/'.$this->user_id.'/portfolio/'.$mini_image);
                        }*/
                    }
                }
                $i++;
            }
            if(!empty($files_data)){
                $this->Couch_model->setCouchPortfolio($this->user_id, $files_data, $this->date);
            }
        }
        elseif ($this->input->post('bt_delete_portfolio_img')) {
            if (is_numeric($this->input->post('img_id', true))) {
                $path = '.' . strip_tags($this->input->post('img_path', true));

                $this->Couch_model->deletePortfolioImage($this->user_id, $this->input->post('img_id', true), $path);
            }
        }

        $result = $this->Couch_model->getCouchPortfolioData($this->user_id);

        // Объединенные данные страница
        $this->page_data['title'] = 'Портфолио';
        $this->page_data['page_menu'] = 'portfolio';

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/profile');
        $this->load->view('user/profile_line');
        $this->load->view('couch/portfolio/portfolio', $result);
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

        $result = $this->Couch_model->getPortfolioPost($post_id);

        // Объединенные данные страница
        $this->page_data['title'] = 'Портфолио';
        $this->page_data['page_menu'] = 'portfolio_post';

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/profile');
        $this->load->view('user/profile_line');
        $this->load->view('couch/portfolio/portfolio_post', $result);
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
        if (empty($this->user_id) or $this->session->user['type'] != 2) {
            show_404($this->page_url);
        }

        $result   = $this->Couch_model->getCouchPortfolioPost($this->user_id, $post_id);
        $db_image = '.' . $result['post']['path'];
        $db_title = $result['post']['title'];
        $db_desc  = $result['post']['desc'];


        if ($this->input->post('bt_save_image', true)) {
            $files_data = '';

            if (is_uploaded_file($_FILES['portfolio_image']['tmp_name'])) {
                $path = './user_files/'.$this->user_id.'/portfolio/';

                $path_image = parent::uploadImage('portfolio_image', $_FILES['portfolio_image']['type'], $path);

                if(file_exists('./user_files/'.$this->user_id.'/portfolio/'.$path_image)){
                    if ($this->security->xss_clean('./user_files/'.$this->user_id.'/portfolio/'.$path_image, TRUE) !== FALSE) {
                        // файл прошел XSS тест
                        $files_data = './user_files/'.$this->user_id.'/portfolio/'.$path_image;

                        unlink($db_image);

                    } else{
                        unlink('./user_files/'.$this->user_id.'/portfolio/'.$path_image);
                    }
                }
            }

            $title       = strip_tags(mb_substr($this->input->post('image_title', true), 0, 100));
            $title       = ($db_title != $title) ? $title : null;
            $description = strip_tags(mb_substr($this->input->post('image_description', true), 0, 255));
            $description = ($db_desc != $description) ? $description : null;


            $res_save_image = $this->Couch_model->updateCouchPortfolio($this->user_id, $post_id, $files_data, $title, $description, $this->date);

            if ($res_save_image['image'] === true or $res_save_image['data'] === true) {
                // Сохранено
                $this->session->set_tempdata('message', 87, 60);
            } elseif ($res_save_image['image'] === false and $res_save_image['data'] === false) {
                $this->session->set_tempdata('message', 90, 60);
            } elseif ($res_save_image['image'] === false and $res_save_image['data'] !== false) {
                $this->session->set_tempdata('message', 88, 60);
            } elseif ($res_save_image['image'] !== false and $res_save_image['data'] === false) {
                $this->session->set_tempdata('message', 89, 60);
            }

            header('Location: /portfolio/post/' . $post_id);
        }
        elseif ($this->input->post('bt_del_post', true)) {
            $res_del = $this->Couch_model->deleteCouchPortfolioPost($this->user_id, $post_id);

            if ($res_del === true) {
                unlink($db_image);

                $this->session->set_tempdata('message', 91, 60);
            } else {
                $this->session->set_tempdata('message', 92, 60);
            }

            header('Location: /portfolio');
        }

        $result = $this->Couch_model->getCouchPortfolioPost($this->user_id, $post_id);

        // Объединенные данные страница
        $this->page_data['title'] = 'Редактирование записи портфолио';
        $this->page_data['page_menu'] = 'portfolio';

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/profile');
        $this->load->view('user/profile_line');
        $this->load->view('couch/portfolio/form_edit', $result);
        $this->load->view('footer/footer');
    }

    /**
     * Форма добавления записи в портфолио
     */
    public function newPortfolioPost()
    {
        // Если пользователь не авторизован, переход на страницу авторизации
        if (empty($this->user_id) or $this->session->user['type'] != 2) {
            show_404($this->page_url);
        }

        if ($this->input->post('bt_save_post', true)) {
            $path = './user_files/'.$this->user_id.'/portfolio/';
            $files_data = array();

            if(!file_exists('./user_files/'.$this->user_id.'/portfolio/')){
                chdir('user_files');
                if(!is_dir($this->user_id)){
                    mkdir($this->user_id);
                }
                chmod($this->user_id, 0777);
                chdir($this->user_id);
                if(!is_dir('portfolio')){
                    mkdir('portfolio');
                }
                chmod('portfolio', 0777);
                chdir('portfolio');
                chdir('../../../');
            }

            $path_image = parent::uploadImage('portfolio_image', $_FILES['portfolio_image']['type'], $path);

            if(file_exists('./user_files/'.$this->user_id.'/portfolio/'.$path_image)){
                if ($this->security->xss_clean('./user_files/'.$this->user_id.'/portfolio/'.$path_image, TRUE) !== FALSE) {
                    // файл прошел XSS тест
                    $files_data = './user_files/'.$this->user_id.'/portfolio/'.$path_image;
                    $name = strip_tags(mb_substr($this->input->post('image_title', true), 0, 100));
                    $description = strip_tags(mb_substr($this->input->post('image_description', true), 0, 255));

                } else{
                    unlink('./user_files/'.$this->user_id.'/portfolio/'.$path_image);
                    /*$image = pathinfo($path_image);
                    $mini_image = $image['filename'].'_thumb.'.$image['extension'];
                    if(file_exists('./user_files/'.$this->user_id.'/portfolio/'.$mini_image)){
                        unlink('./user_files/'.$this->user_id.'/portfolio/'.$mini_image);
                    }*/
                }
            }

            if(!empty($files_data)){
                $res_ins = $this->Couch_model->setCouchPortfolioPost($this->user_id, $files_data, $name, $description, $this->date);

                if (is_numeric($res_ins)) {
                    $this->session->set_tempdata('message', 93, 60);

                    header('Location: /portfolio/post/' . $res_ins);
                } else {
                    $this->session->set_tempdata('message', 94, 60);

                    header('Location: /portfolio/');
                }
            }
        }

        // Объединенные данные страница
        $this->page_data['title'] = 'Добавление записи в портфолио';
        $this->page_data['page_menu'] = 'portfolio';

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/profile');
        $this->load->view('user/profile_line');
        $this->load->view('couch/portfolio/form_new');
        $this->load->view('footer/footer');
    }

    /**
     * AJAX поиск тренеров
     *
     * @return void
     */
    public function searchCouches()
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3) {
            show_404();
        }

        $result['couches'] = false;

        $search_text = !empty(mb_substr(strip_tags($this->input->post('search_text', true)), 0, 255)) 
            ? mb_substr(strip_tags($this->input->post('search_text', true)), 0, 255)
            : null;
        
        if (!empty($search_text)) {
            $result['couches'] = $this->Couch_model->searchCouches($search_text);
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
        if (empty($this->user_id) or $this->session->user['type'] != 2)
        {
            show_404($this->page_url);
        }

        $result = $this->Couch_model->getCouchClientsActivity($this->user_id);

        // Объединенные данные страница
        $this->page_data['title'] = 'Активность клиентов';
        $this->page_data['page_menu'] = 'activity';

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/profile');
        $this->load->view('user/profile_line');
        $this->load->view('couch/users_activity', $result);
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
        if (empty($this->user_id) or $this->session->user['type'] != 2)
        {
            show_404($this->page_url);
        }

        $this->load->model('User_model');

        $attached_users_id = $this->Couch_model->getAttachedUsersId($this->user_id);
        
        if (in_array($user_id, $attached_users_id['id'])) {
            $user_data         = $this->User_model->getUser($user_id);
            $last_anthrop_data = $this->User_model->getLastAnthropometricData($user_id);
            $anthrop_data      = $this->User_model->getAnthropometricData($user_id);
            
            $result = array_merge($last_anthrop_data, $anthrop_data, $user_data);
        }

        // Объединенные данные страница
        $this->page_data['title'] = 'Активность клиентов';
        $this->page_data['page_menu'] = 'activity';

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/profile');
        $this->load->view('user/profile_line');
        $this->load->view('couch/user_activity', $result);
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
        if (empty($this->user_id) or $this->session->user['type'] != 2)
        {
            show_404($this->page_url);
        }

        $this->load->model('Course_model');

        $result = $this->Course_model->getCouchCourses($this->user_id);

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
        if (empty($this->user_id)) {
            header('Location: /login');
        }

        $this->load->model('Course_model');
        
        $result = $this->Course_model->getPartnerCourse($course_id, $this->user_id);

        if ($this->input->post('bt_save_course', true)) {
            $discount = $this->input->post('couch_discount', true);
            $couch_discount = (is_numeric($discount) and $discount <= $result['course']['couch_percent'])
                ? $discount
                : 0;

            if ($couch_discount != $result['course']['couch_discount']) {
                $result_course = $this->Course_model->setPartnerCourseSettings($course_id, $this->user_id, $couch_discount, $this->date);

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
}