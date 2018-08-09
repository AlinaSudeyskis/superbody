<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User class
 *
 * Класс для работы с данными пользователя.
 * Занесение первичных данных анкеты, промежуточных данных прогресса
 *
 * @author Alina Sudeyskis <alina.sudeyskis@gmail.com>
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class User extends CI_Controller
{
    public $type_questionnaire = 0;

    /**
     * User constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->model('User_model');
    }

    /**
     * Страница пользователя.
     * Переход на определенную категорию пользователей
     *
     * @param $user_id
     * @return void
     */
    public function profile($user_id)
    {
        $user_id = (empty($user_id)) ? $this->user_id : $user_id;

        if (!is_numeric($user_id))
        {
            parent::pageNotFound($this->page_url);
        }

        // Страница пользователя или администратора
        if (!empty($this->user_id) and $this->user_id == $user_id and $this->session->user['type'] != 2)
        {
            self::userProfile($user_id);
        }
        // Страница тренера
        elseif (!empty($this->user_id) and $this->user_id == $user_id and $this->session->user['type'] == 2)
        {
            self::couchProfile($user_id);
        }
        // Просмотр страницы другого пользователя
        elseif (empty($this->user_id) or $this->user_id != $user_id)
        {
            self::outsiderProfile($user_id);
        }
    }

    /**
     * Страница пользователя
     *
     * @param $user_id
     * @return void
     */
    private function userProfile($user_id)
    {
        $this->load->model('Couch_model');
        $this->load->model('Blog_model');
        $this->load->model('Course_model');

        $title = !empty($this->session->user['name']) ? $this->session->user['name'] . ' - пользователь' : 'Страница пользователя' ;

        $u_training_time = $this->User_model->getUserTrainingTime($user_id); // Тренировочное время пользователя
        $user_courses    = $this->Course_model->getUserCourses($user_id, $this->date, 'active', $u_training_time); // Выборка курсов пользователя
        $course_notifs   = $this->Course_model->getUserCoursesNotifications($user_id, $this->date); // Выборка уведомлений курсов пользователя
        $anthrop_data    = $this->User_model->getAnthropometricData($user_id, $this->date); // Антропометрические данные пользователя
        $user_social     = $this->User_model->getUserSocial($user_id);
        $u_data          = $this->User_model->getUser($user_id);

        $result = array_merge($user_courses, $anthrop_data, $user_social, $u_data);

        $this->load->model('Notification_model');
        // Уведомления курсов
        if(!empty($course_notifs['notifications']))
        {
            foreach($course_notifs['notifications'] as $user_course_id => $course_notif)
            {
                foreach($course_notifs['notifications'][$user_course_id] as $code => $notif)
                {
                    $this->page_data['course_notification'][$user_course_id]['course_name'] = $notif['course_name'];
                    $this->page_data['course_notification'][$user_course_id]['course_id']   = $notif['course_id'];

                    // Оплата курса
                    if(is_numeric($code) and ($code == 142 or $code == 144))
                    {
                        $notification = $this->Notification_model->getNotification($code);
                        $pattern = '/\[date_attempts\]/';
                        $replacement = $notif['date_attempts'];

                        $this->page_data['course_notification'][$user_course_id]['course_blocked']['text'] = preg_replace($pattern, $replacement, $notification['notification']['text']);
                    }

                    // Завершение курса
                    if(is_numeric($code) and $code == 143)
                    {
                        $notification = $this->Notification_model->getNotification($code);

                        $this->page_data['course_notification'][$user_course_id]['course_ends']['text']           = $notification['notification']['text'];
                        $this->page_data['course_notification'][$user_course_id]['course_ends']['date_countdown'] = $notif['date_countdown'];
                        $this->page_data['course_notification'][$user_course_id]['course_ends']['extends']        = $notif['extends'];

                        if($notif['send_email'] === true)
                        {
                            $system_message['text'] = '<table border="0" cellpadding="0" cellspacing="0" style="margin:0; padding:0">'
                                . '<tr><td style="width:30%; padding:0; margin:0;" width="30%">';
                            $system_message['text'] .= '<a href="https://superbody.pro/profile/course/' . $notif['course_id'] . '" '
                                . 'style="text-transform: uppercase; font-weight: 300; font-size: 24px; line-height: 28px; '
                                . 'padding: 20px 0 20px 30px; margin:0; color: #72d0f4; text-decoration: none;">'
                                . $notif['course_name'] . '</a>';
                            $system_message['text'] .= '</td><td style="width:70%; padding:0; margin:0;" width="70%">';
                            $system_message['text'] .= '<p style="text-align: center; padding: 20px 15px; color: #606060; '
                                . 'font-weight: 300; border: none; white-space: normal; font-size: 18px; line-height: 22px;">'
                                . $notification['notification']['text'] . '</p>';
                            $system_message['text'] .= '</td></tr>';
                            // Курсы продления
                            if(!empty($notif['extends']))
                            {
                                $system_message['text'] .= '<tr><td style="width:100%; padding:0; margin:0;">ПРОДЛИТЕ КУРС ИЛИ КУПИТЕ НОВЫЙ:</td></tr>';
                                $system_message['text'] .= '<tr>';
                                    foreach($notif['extends'] as $extend)
                                    {
                                        $system_message['text'] .= '<td style="padding:0; margin:0;"><table>';
                                        $system_message['text'] .= '<tr><td style="width:100%; padding:0; margin:0;"><a href="https://superbody.pro/course/' . $extend['course_id'] . '" '
                                            . 'style="text-transform: uppercase; font-weight: 600; font-size: 16px; line-height: 28px; '
                                            . 'padding: 0; margin:0; color: #72d0f4; text-decoration: none;">'
                                            . $extend['course_name'] . '</a></td></tr>';
                                        $system_message['text'] .= '<tr><td style="width:100%; padding:0; margin:0; height: 25px;">' . $extend['promocode'] . '</td></tr>';
                                        $system_message['text'] .= '<tr><td style="width:100%; padding:0; margin:0; height: 25px;">';
                                            if(!empty($extend['new_price']))
                                            {
                                                $system_message['text'] .= '<s>' . $extend['price'] . ' руб.</s> ' . $extend['new_price'] . ' руб.';
                                            }
                                            else
                                            {
                                                $system_message['text'] .= $extend['price'] . ' руб.';
                                            }
                                        $system_message['text'] .= '</td></tr></table>';
                                        $system_message['text'] .= '</table></td>';
                                    }
                                    unset($extend);
                                $system_message['text'] .= '</tr>';
                            }

                            $system_message['text'] .= '</table>';

                            parent::sendEmail(11, $this->session->user['email'], $system_message);
                        }
                    }
                    // Курс завершен
                    elseif(is_numeric($code) and $code == 154)
                    {
                        $notification = $this->Notification_model->getNotification($code);

                        $this->page_data['course_notification'][$user_course_id]['course_finished']['text']    = $notification['notification']['text'];
                        $this->page_data['course_notification'][$user_course_id]['course_finished']['extends'] = $notif['extends'];
                    }
                }
            }
            unset($course_notif);
        }
        // Уведомления отображения курсов в календаре
        if($course_notifs['display_workout'] === true and $course_notifs['display_nutrition'] === true)
        {
            $notification = $this->Notification_model->getNotification(173);

            $this->page_data['display_courses']['text'] = $notification['notification']['text'];
        }
        elseif($course_notifs['display_workout'] === true)
        {
            $notification = $this->Notification_model->getNotification(172);

            $this->page_data['display_courses']['text'] = $notification['notification']['text'];
        }
        elseif($course_notifs['display_nutrition'] === true)
        {
            $notification = $this->Notification_model->getNotification(171);

            $this->page_data['display_courses']['text'] = $notification['notification']['text'];
        }
        // Уведомления пользователя
        // Пользователь заблокирован
        if($u_data['user_data']['user_blocked'] == 1)
        {
            $notification = $this->Notification_model->getNotification(16);

            $this->page_data['user_notification']['blocked']['text'] = $notification['notification']['text'];
        }
        // Пользователь вводил антропометрические данные более 2х недель назад
        if($anthrop_data['anthrop_notif'] === true)
        {
            $notification = $this->Notification_model->getNotification(153);

            $this->page_data['user_notification']['anthrop']['text'] = $notification['notification']['text'];
        }

        // Объединенные данные страница
        $this->page_data['title']     = $title;
        $this->page_data['page_menu'] = 'profile';

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/profile');
        $this->load->view('user/profile_line');
        $this->load->view('user/profile', $result);
        $this->load->view('footer/footer');
    }

    /**
     * Страница тренера
     *
     * @param $couch_id
     * @return void
     */
    private function couchProfile($couch_id)
    {
        $this->load->model('Couch_model');
        $this->load->model('Blog_model');
        $this->load->model('Course_model');

        // Отправка сообщений или комментариев
        if ($this->input->post('bt_send_message', true)) {
            $blog_message = mb_substr(strip_tags($this->input->post('message_text', true)), 0, 500);

            if (!empty($blog_message)) {
                $this->Blog_model->setBlogMessage($this->user_id, $blog_message, $this->date);
            }
        }
        elseif ($this->input->post('bt_send_comment', true)) {
            $comment_message = mb_substr(strip_tags($this->input->post('message_text', true)), 0, 500);

            if (!empty($comment_message) and is_numeric($this->input->post('blog_id', true))) {
                $this->Blog_model->setCommentMessage($this->user_id, $comment_message, $this->input->post('blog_id', true), $this->date);
            }
        }

        $portfolio   = $this->Couch_model->getCouchPortfolioData($couch_id);
        $posts       = $this->Blog_model->getCouchBlogPosts($couch_id);
        $clients     = $this->Couch_model->getCouchClientsActivity($couch_id);
        $c_data      = $this->Couch_model->getCouch($couch_id, $this->date);
        $user_social = $this->User_model->getUserSocial($this->user_id);

        $result = array_merge($portfolio, $posts, $clients, $c_data, $user_social);

        // Уведомления пользователя
        if($c_data['user_data']['user_blocked'] == 1)
        {
            $this->load->model('Notification_model');
            $notification = $this->Notification_model->getNotification(16);

            $this->page_data['user_notification']['blocked']['text'] = $notification['notification']['text'];
        }

        $title = !empty($this->session->user['name'])
            ? $this->session->user['name'] . ' - тренер'
            : 'Страница тренера' ;      

        // Объединенные данные страница
        $this->page_data['title'] = $title;
        $this->page_data['page_menu'] = 'profile';

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/profile');
        $this->load->view('user/profile_line');
        $this->load->view('couch/profile', $result);
        $this->load->view('footer/footer');
    }

    /**
     * Страница администратора
     * @param $admin_id
     */
    private function adminProfile($admin_id){}

    /**
     * Страница постороннего пользователя
     *
     * @param $user_id
     * @return void
     */
    private function outsiderProfile($user_id)
    {
        // Данные пользователя
        $user_data   = $this->User_model->getUser($user_id);
        $user_social = $this->User_model->getUserSocial($this->user_id);
        $result = array_merge($user_data, $user_social);

        // Страница тренера
        if ($result['user_data']['user_type'] == 2)
        {
            self::outsiderCouchProfile($user_id);
        }
        // Страница администратора
        elseif ($result['user_data']['user_type'] == 3)
        {
            self::outsiderAdminProfile($user_id);
        }
        // Страница пользователя
        elseif ($result['user_data']['user_type'] == 1)
        {
            self::outsiderUserProfile($user_id);
        }
        else
        {
            parent::pageNotFound($this->page_url);
        }

    }

    /**
     * Страница пользователя для других пользователей
     *
     * @param $user_id
     */
    public function outsiderUserProfile($user_id)
    {
        // Данные пользователя
        $result = $this->User_model->getUser($user_id);

        // Уведомления пользователя
        if($result['user_data']['user_blocked'] == 1)
        {
            $this->load->model('Notification_model');
            $notification = $this->Notification_model->getNotification(16);

            $this->page_data['user_notification']['blocked']['text'] = $notification['notification']['text'];
        }

        $title = !empty($result['user_data']['name']) ? $result['user_data']['name'] . ' - пользователь' : 'Страница пользователя' ;
        // Объединенные данные страница
        $this->page_data['title']     = $title;
        $this->page_data['page_menu'] = 'user_page';
        $this->page_data['outsider']  = true;

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/profile');
        $this->load->view('user/profile_line');
        $this->load->view('user/outsider_profile', $result);
        $this->load->view('footer/footer');
    }

    /**
     * Страница тренерп для других пользователей
     *
     * @param $couch_id
     */
    public function outsiderCouchProfile($couch_id)
    {
        $this->load->model('Couch_model');
        $this->load->model('Blog_model');
        $this->load->model('Course_model');

        // Отправка сообщений или комментариев
        if ($this->input->post('bt_send_message', true)) {
            $blog_message = mb_substr(strip_tags($this->input->post('message_text', true)), 0, 500);

            if (!empty($blog_message)) {
                $this->Blog_model->setBlogMessage($this->user_id, $blog_message, $this->date);
            }
        }
        elseif ($this->input->post('bt_send_comment', true)) {
            $comment_message = mb_substr(strip_tags($this->input->post('message_text', true)), 0, 500);

            if (!empty($comment_message) and is_numeric($this->input->post('blog_id', true))) {
                $this->Blog_model->setCommentMessage($this->user_id, $comment_message, $this->input->post('blog_id', true), $this->date);
            }
        }

        $portfolio = $this->Couch_model->getPublicCouchPortfolioData($couch_id);
        $posts     = $this->Blog_model->getPublicBlogPosts($couch_id);
        $user      = $this->Couch_model->getCouch($couch_id, $this->date);
        $result    = array_merge($portfolio, $posts, $user);

        // Уведомления пользователя
        if($user['user_data']['user_blocked'] == 1)
        {
            $this->load->model('Notification_model');
            $notification = $this->Notification_model->getNotification(16);

            $this->page_data['user_notification']['blocked']['text'] = $notification['notification']['text'];
        }

        $title = !empty($result['user_data']['user_name']) ? $result['user_data']['user_name'] . ' - тренер' : 'Страница тренера' ;
        // Объединенные данные страница
        $this->page_data['title']     = $title;
        $this->page_data['page_menu'] = 'user_page';
        $this->page_data['outsider']  = true;

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/profile');
        $this->load->view('user/profile_line');
        $this->load->view('couch/outsider_profile', $result);
        $this->load->view('footer/footer');
    }

    /**
     * Страница администратора для других пользователей
     *
     * @param $admin_id
     */
    public function outsiderAdminProfile($admin_id)
    {
        // Данные пользователя
        $result = $this->User_model->getUser($admin_id);

        // Уведомления пользователя
        if($result['user_data']['user_blocked'] == 1)
        {
            $this->load->model('Notification_model');
            $notification = $this->Notification_model->getNotification(16);

            $this->page_data['user_notification']['blocked']['text'] = $notification['notification']['text'];
        }

        $title = !empty($result['user_data']['name']) ? $result['user_data']['name'] . ' - администратор' : 'Страница администратора' ;
        // Объединенные данные страница
        $this->page_data['title']     = $title;
        $this->page_data['page_menu'] = 'user_page';
        $this->page_data['outsider']  = true;

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/profile');
        $this->load->view('user/profile_line');
        $this->load->view('admin/outsider_profile', $result);
        $this->load->view('footer/footer');
    }

    /**
     * Перенаправление на страницы редактирования личных данных пользователей, тренеров
     */
    public function settings()
    {
        if (!is_numeric($this->user_id)) {
            parent::pageNotFound($this->page_url);
        }

        // Получение данных пользователя из БД
        // Страница пользователя или администратора
        if (!empty($this->user_id) and $this->session->user['type'] != 2)
        {
            $user = $this->User_model->getUserSettingsData($this->user_id);
        }
        // Страница тренера
        elseif (!empty($this->user_id) and $this->session->user['type'] == 2)
        {
            $this->load->model('Couch_model');

            // Получение данных тренера из БД
            $user = $this->Couch_model->getCouch($this->user_id);
        }

        $user_data = (!empty($user)) ? $user['user_data'] : null;

        // Сохранение изменений данных
        if ($this->input->post('bt_save_settings', true))
        {
            // Валидация E-mail
            $email = (!empty($this->input->post('email', true)) and filter_var($this->input->post('email', true), FILTER_VALIDATE_EMAIL))
                    ? $this->input->post('email', true)
                    : $user_data['user_email'];

            // Имя пользователя
            $name = mb_substr(strip_tags($this->input->post('name', true)), 0, 255);

            // Пароль
            $password_hash    = $user_data['user_password_hash'];
            $old_password     = $this->input->post('old_password', true);
            $new_password     = $this->input->post('new_password', true);
            $confirm_password = $this->input->post('confirm_new_password', true);

            // Если заполнены все поля паролей
            if (!empty($old_password) and !empty($new_password) and !empty($confirm_password))
            {
                // Старый пароль соответвует действительности
                if (password_verify($old_password, $user_data['user_password_hash']))
                {
                    // Новый пароль подтвержден
                    if ($new_password == $confirm_password)
                    {
                        $password_hash = password_hash($new_password, PASSWORD_DEFAULT);
                    }
                }
            }

            // Телефон
            $code  = mb_substr(strip_tags($this->input->post('country', true)), 0, 2);
            $code  = (array_key_exists($code, $this->countries_codes)) ? $this->countries_codes[$code] : '';
            $phone = is_numeric($this->input->post('phone', true)) ? $this->input->post('phone', true) : '';

            // Загрузка изображения на сервер
            $path_avatar = '.' . $user_data['user_image'];
            $avatar      = '';
            if(is_uploaded_file($_FILES['avatar_file']['tmp_name'])){
                $path = './user_files/'.$this->user_id.'/avatar/';

                if(!file_exists($path)){
                    chdir('user_files');
                    if(!is_dir($this->user_id)){
                        mkdir($this->user_id);
                    }
                    chmod($this->user_id, 0777);
                    chdir($this->user_id);
                    if(!is_dir('avatar')){
                        mkdir('avatar');
                    }
                    chmod('avatar', 0777);
                    chdir('avatar');
                    chdir('../../../');
                }
                $this->load->helper('file');

                $path_image = parent::uploadImage('avatar_file',$_FILES['avatar_file']['type'], $path);
                if(file_exists($path.$path_image)){
                    if ($this->security->xss_clean($path.$path_image, TRUE) !== FALSE) {
                        // файл прошел XSS тест
                        $path_avatar = $path.$path_image;
                        $avatar = '/user_files/'.$this->user_id.'/avatar/'.$path_image;

                        if (!empty($user_data['user_image']) and is_file($user_data['user_image'])) {
                            unlink('.' . $user_data['user_image']);
                        }
                    } else{
                        unlink($path);
                    }
                }
            }

            // Сохранение данных в БД
            if (!empty($email) and ($email != $user_data['user_email'] or $name != $user_data['user_name'] or $phone != $user_data['user_phone']
                or $code != $user_data['user_country_code'] or $password_hash != $user_data['user_password_hash']
                or $avatar != $user_data['user_image']))
            {
                $result = $this->User_model->setUserSettingsData($this->user_id, $email, $name, $password_hash, $code, $phone, $path_avatar, $this->date);

                if ($result === false)
                {
                    // Изменения не были сохранены
                    $this->session->set_tempdata('message', 9, 60);
                }
                else
                {
                    // Обновление данных сессии
                    $user_data = array('user' => $this->session->user);

                    $user_data['user']['email'] = $email;
                    $user_data['user']['name']  = $name;
                    $user_data['user']['phone'] = $phone;
                    $user_data['user']['image'] = $avatar;
                    $user_data['user']['date']  = $this->date;

                    $this->session->set_userdata($user_data);

                    // Изменения сохранены
                    $this->session->set_tempdata('message', 10, 60);
                }
            }
            elseif(empty($email))
            {
                // Не корректный email
                $this->session->set_tempdata('message', 6, 60);
            }

            header('Location: /settings');
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
                $res_gb = $this->User_model->setUserGenderBd($this->user_id, $gender, $birthday, $this->date);

                if ($res_gb === true and !empty($user_data['weight'])) {
                    parent::calcBmiBmr($this->user_id, $user_data['weight']);
                }
            }

            // Информация о тренере
            if ($this->session->user['type'] == 2) {
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
                    or $title_awards != $user_data['user_titles_awards'] or $about != $user_data['user_about']) {
                    $res_cd = $this->Couch_model->setCouchData($this->user_id, $special, $experience, $title_awards, $about, $this->date);
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

            header('Location: /settings');
        }
        elseif ($this->input->post('bt_delete_avatar', true)) {
            $res_del = $this->User_model->deleteUserAvatar($this->user_id);

            if ($res_del === false) {
                // Не сохранено
                $this->session->set_tempdata('message', 96, 60);
            } else {
                // Обновление данных сессии
                $user_data = array('user' => $this->session->user);
                $user_data['user']['image'] = '';
                $this->session->set_userdata($user_data);

                // Сохранено
                $this->session->set_tempdata('message', 10, 60);
            }
            header('Location: /settings');
        }
        elseif ($this->input->post('bt_save_soc_available', true))
        {
            $cb_facebook = ($this->input->post('cb_facebook_available')) ? 1 : 0;
            $cb_ok = ($this->input->post('cb_ok_available')) ? 1 : 0;
            $cb_vk = ($this->input->post('cb_vk_available')) ? 1 : 0;
            $cb_instagram = ($this->input->post('cb_instagram_available')) ? 1 : 0;

            $res = $this->User_model->setUserSocialAvailable($this->user_id, $cb_facebook, $cb_vk, $cb_ok, $cb_instagram);

            if ($res === true)
            {
                // Сохранено
                $this->session->set_tempdata('message', 10, 60);
            }
            else
            {
                // Не сохранено
                $this->session->set_tempdata('message', 129, 60);
            }

            header('Location: /settings');
        }


        // Страница пользователя или администратора
        if (!empty($this->user_id) and $this->session->user['type'] != 2) {
            self::userSettings();
        }
        // Страница тренера
        elseif (!empty($this->user_id)  and $this->session->user['type'] == 2) {
            self::couchSettings();
        }
    }

    /**
     * Страница редактирования регистрационных данных пользователя
     *
     * @return void
     */
    public function userSettings()
    {
        // Получение данных пользователя из БД
        $user_data   = $this->User_model->getUserSettingsData($this->user_id);
        $user_social = $this->User_model->getUserSocial($this->user_id);

        $result = array_merge($user_data, $user_social);

        // Объединенные данные страница
        $this->page_data['title']        = 'Настройки';
        $this->page_data['page_menu']    = 'settings';

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/profile');
        $this->load->view('user/profile_line');

        if ($user_data !== false)
        {
            // Вывод страницы настроек пользователя
            $this->load->view('user/settings/settings', $result);
        }
        else
        {
            // Пользователь не найден
            $this->session->set_tempdata('message', 136, 60);
        }

        $this->load->view('footer/footer');
    }

    /**
     * Страница редактирования регистрационных данных тренера
     *
     * @return void
     */
    public function couchSettings()
    {
        // Получение данных пользователя из БД
        $user_data   = $this->Couch_model->getCouch($this->user_id);
        $user_social = $this->User_model->getUserSocial($this->user_id);

        $result = array_merge($user_data, $user_social);

        // Объединенные данные страница
        $this->page_data['title']        = 'Настройки';
        $this->page_data['page_menu']    = 'settings';

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/profile');
        $this->load->view('user/profile_line');

        if ($user_data !== false)
        {
            // Вывод страницы настроек пользователя
            $this->load->view('couch/settings/settings', $result);
        }
        else
        {
            // Пользователь не найден
            $this->session->set_tempdata('message', 136, 60);
        }

        $this->load->view('footer/footer');
    }

    /**
     * График антропометрических данных пользователя
     */
    public function progress()
    {
        if (!is_numeric($this->user_id))
        {
            parent::pageNotFound($this->page_url);
        }
        $result = $this->User_model->getAnthropometricData($this->user_id, $this->date); // Антропометрические данные пользователя

        // Объединенные данные страница
        $this->page_data['title'] = 'Прогресс';
        $this->page_data['page_menu'] = 'progress';

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/profile');
        $this->load->view('user/profile_line');
        $this->load->view('user/progress', $result);
        $this->load->view('footer/footer');

    }

    /**
     * Анкета пользователя
     *
     * @return void
     */
    public function userQuestionnaire()
    {
        // Если пользователь не авторизован, переход на страницу авторизации
        if (empty($this->user_id))
        {
            parent::pageNotFound($this->page_url);
        }

        // Валидация и сохранение данных анкеты в БД
        if ($this->input->post('bt_save_anthrop', true))
        {
            // Антропометрические данные
            // Вес
            $weight = is_numeric($this->input->post('weight', true)) ? $this->input->post('weight', true) : '';

            // Расчет и сохранение ИМТ и БСО
            parent::calcBmiBmr($this->user_id, $weight);

            // Обхват груди
            $chest = is_numeric($this->input->post('chest', true)) ? $this->input->post('chest', true) : '';

            // Обхват талии
            $waist = is_numeric($this->input->post('waist', true)) ? $this->input->post('waist', true) : '';

            // Обхвать ягодиц
            $buttocks = is_numeric($this->input->post('buttocks', true)) ? $this->input->post('buttocks', true) : '';

            // Обхвать боков
            $waist_sides = is_numeric($this->input->post('waist_sides', true)) ? $this->input->post('waist_sides', true) : '';

            // Обхвать левого бедра
            $left_hip = is_numeric($this->input->post('left_hip', true)) ? $this->input->post('left_hip', true) : '';

            // Обхвать правого бедра
            $right_hip = is_numeric($this->input->post('right_hip', true)) ? $this->input->post('right_hip', true) : '';

            // Обхвать левого бицепса
            $left_biceps = is_numeric($this->input->post('left_biceps', true)) ? $this->input->post('left_biceps', true) : '';

            // Обхвать правого бицепса
            $right_biceps = is_numeric($this->input->post('right_biceps', true)) ? $this->input->post('right_biceps', true) : '';

            $result_anthrop = $this->User_model->setAnthropometricData($this->user_id, $weight, $chest, $waist, $buttocks,
                $waist_sides, $left_hip, $right_hip, $left_biceps, $right_biceps, $this->date);

            //$this->session->set_userdata('type_questionnaire', 0);

            if ($result_anthrop === false) {
                // Не удалось сохранить
                $this->session->set_tempdata('message', 12, 60);
            } else {
                $email = $this->session->user['email'];
                $email_hash = password_hash($email, PASSWORD_DEFAULT);
                // Отправление уведомления об измениях в данных

                $system_message['text']  = '<p>В Вашем аккаунте были изменены данные:</p> </br></br>';
                $system_message['text'] .= '<p>Вес: ' . $weight . 'см</p> </br>';
                $system_message['text'] .= '<p>Обхват груди: ' . $chest . 'см</p> </br>';
                $system_message['text'] .= '<p>Обхват талии: ' . $waist . 'см</p> </br>';
                $system_message['text'] .= '<p>Обхвать ягодиц: ' . $buttocks . 'см</p> </br>';
                $system_message['text'] .= '<p>Обхвать боков: ' . $waist_sides . 'см</p> </br>';
                $system_message['text'] .= '<p>Обхвать левого бедра: ' . $left_hip . 'см</p> </br>';
                $system_message['text'] .= '<p>Обхвать правого бедра: ' . $right_hip . 'см</p> </br>';
                $system_message['text'] .= '<p>Обхвать левого бицепса: ' . $left_biceps . 'см</p> </br>';
                $system_message['text'] .= '<p>Обхвать правого бицепса: ' . $right_biceps . 'см</p> </br></br>';

                parent::sendEmail(10, $email, $system_message);

                // Сохрано
                $this->session->set_tempdata('message', 10, 60);
            }

            header('Location: /questionnaire');
        }
        if ($this->input->post('bt_save_physical_param', true))
        {
            // Пол
            $gender = (0 == $this->input->post('gender', true)) ? 'male' : 'female';

            // Дата рождения
            $b_day       = is_numeric($this->input->post('b_day', true)) ? $this->input->post('b_day', true) : '';
            $b_mon       = is_numeric($this->input->post('b_mon', true)) ? $this->input->post('b_mon', true) : '';
            $b_year      = is_numeric($this->input->post('b_year', true)) ? $this->input->post('b_year', true) : '';
            $birthday    = $b_day . '.' . $b_mon . '.' . $b_year;
            $date        = DateTime::createFromFormat('d.m.Y', $birthday);
            $birthday    = ($date !== false) ? $birthday : '';
            $db_birthday = ($date !== false) ? $date->format('Y-m-d') : '';

            // Рост
            $height = is_numeric($this->input->post('height', true)) ? $this->input->post('height', true) : '';

            // Вес
            $weight = is_numeric($this->input->post('weight', true)) ? $this->input->post('weight', true) : '';

            // Сохранение данных в БД
            $result_quest = $this->User_model->setPhysicalParam($this->user_id, $gender, $db_birthday, $height, $weight, $this->date);

            //$this->session->set_userdata('type_questionnaire', 1);

            if ($result_quest === false) {
                // Не удалось сохранить
                $this->session->set_tempdata('message', 12, 60);
            }
            else {
                $email = $this->session->user['email'];
                $email_hash = password_hash($email, PASSWORD_DEFAULT);
                // Отправление уведомления об измениях в данных
                $system_message['text']  = '<p>В Вашем аккаунте были изменены данные физических параметров:</p> </br></br>';
                $system_message['text'] .= '<p>Пол: ' . $gender . '</p> </br>';
                $system_message['text'] .= '<p>Дата рождения: ' . $birthday . '</p> </br>';
                $system_message['text'] .= '<p>Рост: ' . $height . 'см</p> </br>';
                $system_message['text'] .= '<p>Вес: ' . $weight . 'кг</p> </br>';

                parent::sendEmail(10, $email, $system_message);

                // Расчет и сохранение ИМТ и БСО
                parent::calcBmiBmr($this->user_id, $weight);

                // Сохрано
                $this->session->set_tempdata('message', 10, 60);
            }

            header('Location: /questionnaire');
        }
        if ($this->input->post('bt_save_physical_condition', true)) {
            // Физическое состояние
            $physical_condition = is_numeric($this->input->post('physical_condition', true)) ? $this->input->post('physical_condition', true) : '';

            // Пульс в покое
            $pulse = is_numeric($this->input->post('pulse', true)) ? $this->input->post('pulse', true) : '';

            // Цель занятий
            $training_goal = is_numeric($this->input->post('training_goal', true)) ? $this->input->post('training_goal', true) : '';

            // История тренировок
            $sports_history = mb_substr(strip_tags($this->input->post('sports_history', true)), 0, 1000);

            // Перечень травм и заболеваний
            $injuries_diseases = mb_substr(strip_tags($this->input->post('injuries_diseases', true)), 0, 1000);

            // Вредные привычки
            $bad_habits = mb_substr(strip_tags($this->input->post('bad_habits', true)), 0, 255);

            // Сохранение данных в БД
            $result_quest = $this->User_model->setPhysicalCondition($this->user_id, $physical_condition, $pulse, $sports_history,
                $injuries_diseases, $training_goal, $bad_habits, $this->date);

            //$this->session->set_userdata('type_questionnaire', 2);

            if ($result_quest === false) {
                // Не удалось сохранить
                $this->session->set_tempdata('message', 12, 60);
            }
            else {
                // Сохрано
                $this->session->set_tempdata('message', 10, 60);
            }

            header('Location: /questionnaire');
        }
        if ($this->input->post('bt_save_daily_regime', true)) {
            // Время бодрствования
            $minutes = mb_strlen($this->input->post('waking_from', true)) <= 2 ? ':00' : '';
            $d = DateTime::createFromFormat('H:i', $this->input->post('waking_from', true) . $minutes);
            $waking_from = ($d !== false) ? $this->input->post('waking_from', true) . $minutes : '';

            $minutes = mb_strlen($this->input->post('waking_to', true)) <= 2 ? ':00' : '';
            $d = DateTime::createFromFormat('H:i', $this->input->post('waking_to', true) . $minutes);
            $waking_to = ($d !== false) ? $this->input->post('waking_to', true) . $minutes : '';

            // Предпочтительно время тренировки
            $minutes = mb_strlen($this->input->post('training_time_from', true)) <= 2 ? ':00' : '';
            $d = DateTime::createFromFormat('H:i', $this->input->post('training_time_from', true) . $minutes);
            $training_time_from = ($d !== false) ? $this->input->post('training_time_from', true) . $minutes : '';

            $minutes = mb_strlen($this->input->post('training_time_to', true)) <= 2 ? ':00' : '';
            $d = DateTime::createFromFormat('H:i', $this->input->post('training_time_to', true) . $minutes);
            $training_time_to = ($d !== false) ? $this->input->post('training_time_to', true) . $minutes : '';

            // Количество основных приемов пищи
            $num_main_meals = is_numeric($this->input->post('num_main_meals', true)) ? $this->input->post('num_main_meals', true) : '';

            // Количество перекусов
            $num_snacks = is_numeric($this->input->post('num_snacks', true)) ? $this->input->post('num_snacks', true) : '';

            // Количество потребляемой воды
            $water_consumed = is_numeric($this->input->post('amount_water_consumed', true)) ? $this->input->post('amount_water_consumed', true) : '';

            // Количество потребляемой жидкости
            $fluid_intake = is_numeric($this->input->post('amount_fluid_intake', true)) ? $this->input->post('amount_fluid_intake', true) : '';

            // Сохранение данных в БД
            $result_quest = $this->User_model->setDailyRegime($this->user_id, $waking_from, $waking_to, $training_time_from,
                $training_time_to, $num_main_meals, $num_snacks, $water_consumed, $fluid_intake, $this->date);

            if ($result_quest === false) {
                // Не удалось сохранить
                $this->session->set_tempdata('message', 12, 60);
            } else {
                // Сохрано
                $this->session->set_tempdata('message', 10, 60);
            }

            //$this->session->set_userdata('type_questionnaire', 3);

            header('Location: /questionnaire');
        }

        // Получение данных анкеты из БД
        $user_quest_data     = $this->User_model->getQuestionnaireData($this->user_id);
        $user_anthrop_data   = $this->User_model->getLastAnthropometricData($this->user_id);
        $result['user_data'] = array_merge($user_quest_data['user_data'], $user_anthrop_data['user_data']);
        $result['user_name'] = $this->session->user['name'];

        // Объединенные данные страница
        $this->page_data['title']     = 'Анкета';
        $this->page_data['page_menu'] = 'questionnaire';

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/profile');
        $this->load->view('user/profile_line');
        // Вывод страницы настроек пользователя
        $this->load->view('user/questionnaire/questionnaire', $result);
        $this->load->view('footer/footer');
    }

    /**
     * Антропометрические данные. Изменение и сохранение.
     *
     * @return void
     */
    public function userAnthropometric()
    {
        // Если пользователь не авторизован, переход на страницу авторизации
        if (empty($this->user_id)) {
            header('Location: /login');
        }

        /**
         * @var array Антропометрические данные пользователя
         */
        $user_anthrop_data = array();

        // Сохранение антропометрических данных
        if ($this->input->post('bt_save_anthrop', true)) {
            // Антропометрические данные
            // Вес
            $weight = is_numeric($this->input->post('weight', true)) ? $this->input->post('weight', true) : '';

            // Расчет и сохранение ИМТ и БСО
            parent::calcBmiBmr($this->user_id, $weight);

            // Обхват груди
            $chest = is_numeric($this->input->post('chest', true)) ? $this->input->post('chest', true) : '';

            // Обхват талии
            $waist = is_numeric($this->input->post('waist', true)) ? $this->input->post('waist', true) : '';

            // Обхвать ягодиц
            $buttocks = is_numeric($this->input->post('buttocks', true)) ? $this->input->post('buttocks', true) : '';

            // Обхвать боков
            $waist_sides = is_numeric($this->input->post('waist_sides', true)) ? $this->input->post('waist_sides', true) : '';

            // Обхвать левого бедра
            $left_hip = is_numeric($this->input->post('left_hip', true)) ? $this->input->post('left_hip', true) : '';

            // Обхвать правого бедра
            $right_hip = is_numeric($this->input->post('right_hip', true)) ? $this->input->post('right_hip', true) : '';

            // Обхвать левого бицепса
            $left_biceps = is_numeric($this->input->post('left_biceps', true)) ? $this->input->post('left_biceps', true) : '';

            // Обхвать правого бицепса
            $right_biceps = is_numeric($this->input->post('right_biceps', true)) ? $this->input->post('right_biceps', true) : '';


            $result_anthrop = $this->User_model->setAnthropometricData($this->user_id, $weight, $chest, $waist,
                $buttocks, $waist_sides, $left_hip, $right_hip, $left_biceps, $right_biceps, $this->date);

            if ($result_anthrop === false) {
                // Не удалось сохранить
                $this->session->set_tempdata('message', 12, 60);
            } else {
                $email = $this->session->user['email'];
                $email_hash = password_hash($email, PASSWORD_DEFAULT);
                // Отправление уведомления об измениях в данных
                $system_message['text']   = '<p>В Вашем аккаунте были изменены данные:</p> </br></br>';
                $system_message['text']  .= '<p>Вес: ' . $weight . 'см</p> </br>';
                $system_message['text']  .= '<p>Обхват груди: ' . $chest . 'см</p> </br>';
                $system_message['text']  .= '<p>Обхват талии: ' . $waist . 'см</p> </br>';
                $system_message['text']  .= '<p>Обхвать ягодиц: ' . $buttocks . 'см</p> </br>';
                $system_message['text']  .= '<p>Обхвать боков: ' . $waist_sides . 'см</p> </br>';
                $system_message['text']  .= '<p>Обхвать левого бедра: ' . $left_hip . 'см</p> </br>';
                $system_message['text']  .= '<p>Обхвать правого бедра: ' . $right_hip . 'см</p> </br>';
                $system_message['text']  .= '<p>Обхвать левого бицепса: ' . $left_biceps . 'см</p> </br>';
                $system_message['text']  .= '<p>Обхвать правого бицепса: ' . $right_biceps . 'см</p> </br></br>';

                parent::sendEmail(10, $email, $system_message);

                // Сохрано
                $this->session->set_tempdata('message', 10, 60);
            }

            header('Location: /anthropometric');
        }

        // Получение данных анкеты из БД
        $user_anthrop_data = $this->User_model->getLastAnthropometricData($this->user_id);

        // Объединенные данные страница
        $this->page_data['title'] = 'Ввод параметров тела';
        $this->page_data['page_menu'] = 'anthropometric';

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/profile');
        $this->load->view('user/profile_line');
        $this->load->view('user/questionnaire/anthropometric', $user_anthrop_data);
        $this->load->view('footer/footer');
    }

    /**
     * Первичное заполнение данных анкеты, антропометрических данных и имени пользователя
     *
     * @return void
     */
    public function registrationQuestionnaire()
    {
        // Если пользователь не авторизован, переход на страницу авторизации
        if (empty($this->user_id)) {
            header('Location: /login');
        }

        // Валидация и сохранение данных анкеты в БД
        if ($this->input->post('bt_save_questionnaire', true)) {
            // Ошибки сохранения данных
            $name_error    = 0;
            $quest_error   = 0;
            $anthrop_error = 0;

            // Валидация данных
            // Имя пользователя
            $new_name = mb_substr(strip_tags($this->input->post('name', true)), 0, 255);
            $old_name = $this->session->user['name'];

            // Пол
            $gender = (0 == $this->input->post('gender', true)) ? 'male' : 'female';

            // Дата рождения
            $date = DateTime::createFromFormat('d.m.Y', $this->input->post('birthday', true));
            $birthday = ($date !== false) ? $date->format('Y-m-d') : '';

            // Рост
            $height = is_numeric($this->input->post('height', true)) ? $this->input->post('height', true) : '';

            // Вес
            $weight = is_numeric($this->input->post('weight', true)) ? $this->input->post('weight', true) : '';

            // Индекс массы тела
            if (!empty($height) and !empty($weight)) {
                $bmi = $weight / ($height/100)*2;
                $bmi = number_format($bmi, 2, '.', '');
            } else {
                $bmi = '';
            }

            // Базальная скорость обмена
            if (!empty($height) and !empty($weight) and !empty($birthday)) {
                $datetime = new DateTime($birthday);
                $interval = $datetime->diff(new DateTime(date("d-m-Y")));
                $age = $interval->format("%Y");

                if ('female' == $gender) {
                    if (30 > $bmi) {
                        $bmr = 655 + 9.6*$weight + 1.8*$height - 4.7*$age;
                    } else {
                        $bmr = 2.4*$weight + 9*$height - 4.7*$age - 65;
                    }
                } else {
                    if (30 > $bmi) {
                        $bmr = 66.5 + 13.7*$weight + 5*$height - 6.8*$age;
                    } else {
                        $bmr = 3.4*$weight + 15.3*$height - 6.8*$age - 691;
                    }
                }
                $bmr = round($bmr);
            } else {
                $bmr = '';
            }

            // Антропометрические данные
            // Обхват груди
            $chest = is_numeric($this->input->post('chest', true)) ? $this->input->post('chest', true) : '';

            // Обхват талии
            $waist = is_numeric($this->input->post('waist', true)) ? $this->input->post('waist', true) : '';

            // Обхвать ягодиц
            $buttocks = is_numeric($this->input->post('buttocks', true)) ? $this->input->post('buttocks', true) : '';

            // Обхвать боков
            $waist_sides = is_numeric($this->input->post('waist_sides', true)) ? $this->input->post('waist_sides', true) : '';

            // Обхвать левого бедра
            $left_hip = is_numeric($this->input->post('left_hip', true)) ? $this->input->post('left_hip', true) : '';

            // Обхвать правого бедра
            $right_hip = is_numeric($this->input->post('right_hip', true)) ? $this->input->post('right_hip', true) : '';

            // Обхвать левого бицепса
            $left_biceps = is_numeric($this->input->post('left_biceps', true)) ? $this->input->post('left_biceps', true) : '';

            // Обхвать правого бицепса
            $right_biceps = is_numeric($this->input->post('right_biceps', true)) ? $this->input->post('right_biceps', true) : '';

            // Физическое состояние
            $physical_condition = is_numeric($this->input->post('physical_condition', true)) ? $this->input->post('physical_condition', true) : '';

            // Пульс в покое
            $pulse = is_numeric($this->input->post('pulse', true)) ? $this->input->post('pulse', true) : '';

            // История тренировок
            $sports_history = mb_substr(strip_tags($this->input->post('sports_history', true)), 0, 1000);

            // Перечень травм и заболеваний
            $injuries_diseases = mb_substr(strip_tags($this->input->post('injuries_diseases', true)), 0, 1000);

            // Цель занятий
            $training_goal = is_numeric($this->input->post('training_goal', true)) ? $this->input->post('training_goal', true) : '';

            // Время бодрствования
            $d = DateTime::createFromFormat('H:i', $this->input->post('waking_from', true));
            $waking_from = ($d !== false) ? $this->input->post('waking_from', true) : '';

            $d = DateTime::createFromFormat('H:i', $this->input->post('waking_to', true));
            $waking_to = ($d !== false) ? $this->input->post('waking_to', true) : '';

            // Предпочтительно время тренировки
            $d = DateTime::createFromFormat('H:i', $this->input->post('training_time_from', true));
            $training_time_from = ($d !== false) ? $this->input->post('training_time_from', true) : '';

            $d = DateTime::createFromFormat('H:i', $this->input->post('training_time_to', true));
            $training_time_to = ($d !== false) ? $this->input->post('training_time_to', true) : '';

            // Колчиество основных приемов пищи
            $num_main_meals = is_numeric($this->input->post('num_main_meals', true)) ? $this->input->post('num_main_meals', true) : '';

            // Количество перекусов
            $num_snacks = is_numeric($this->input->post('num_snacks', true)) ? $this->input->post('num_snacks', true) : '';

            // Количество потребляемой воды
            $water_consumed = is_numeric($this->input->post('amount_water_consumed', true)) ? $this->input->post('amount_water_consumed', true) : '';

            // Количество потребляемой жидкости
            $fluid_intake = is_numeric($this->input->post('amount_fluid_intake', true)) ? $this->input->post('amount_fluid_intake', true) : '';

            // Вредные привычки
            $bad_habits = '';
            if (!empty($this->input->post('bad_habits', true))) {
                foreach ($this->input->post('bad_habits', true) as $bad_habit) {
                    $bad_habits .= $bad_habit . ',';
                }
                unset($bad_habit);
            }

            /*echo $gender.' '.$birthday.' '.$age.' '.$height.' '.$weight.' '.$bmi.' '.$bmr.' '.$chest.' '.$waist.' '.$buttocks.' '.$waist_sides.' '.$left_hip.' '.
            $right_hip.' '.$left_biceps.' '.$right_biceps.' '.$physical_condition.' '.$pulse.' '.$sports_history.' '.
            $injuries_diseases.' '.$training_goal.' '.$waking_from.' '.$waking_to.' '.$training_time_from.' '.$training_time_to.' '.
            $num_main_meals.' '.$num_snacks.' '.$water_consumed.' '.$fluid_intake.' '.$bad_habits.'<br/>';*/

            if (!empty($new_name) and $new_name != $old_name) {
                $result_name = $this->User_model->setUserName($this->user_id, $new_name, $this->date);

                if ($result_name === true) {
                    // Обновление данных сессии
                    $user_id = $this->session->user['id'];
                    $user_email = $this->session->user['email'];
                    $user_type = $this->session->user['type'];

                    $this->session->unset_userdata('user');

                    $user_data = array (
                        "user" => array (
                            "id" => $user_id,
                            "email" => $user_email,
                            "name" => $new_name,
                            "type" => $user_type,
                            "date_auth" => $this->date
                        )
                    );

                    $this->session->set_userdata($user_data);
                } else {
                    $name_error = 1;
                }
            }

            $result_quest = $this->User_model->setQuestionnaireData($this->user_id, $gender,
                $birthday, $height, $bmi, $bmr, $physical_condition, $pulse, $sports_history,
                $injuries_diseases, $training_goal, $waking_from, $waking_to, $training_time_from, $training_time_to,
                $num_main_meals, $num_snacks, $water_consumed, $fluid_intake, $bad_habits, $this->date);

            if ($result_quest === false) {
                $quest_error = 1;
            }

            if (0 != $weight and 0 != $chest and 0 != $waist and 0 != $buttocks and 0 != $waist_sides and
                0 != $left_hip and 0 != $right_hip and 0 != $left_biceps and 0 != $right_biceps)
            {
                $result_anthrop = $this->User_model->setAnthropometricData($this->user_id, $weight, $chest, $waist,
                    $buttocks, $waist_sides, $left_hip, $right_hip, $left_biceps, $right_biceps, $this->date);

                if ($result_anthrop === false) {
                    $anthrop_error = 1;
                }
            }

            // Не удалось сохранить
            if ($name_error == 1 or $quest_error == 1 or $anthrop_error == 1) {
                if ($name_error == 1 and $quest_error == 0 and $anthrop_error == 0) {
                    $this->session->set_tempdata('message', 11, 60);
                }
                elseif ($name_error == 0 and $quest_error == 1 and $anthrop_error == 0) {
                    $this->session->set_tempdata('message', 12, 60);
                }
                elseif ($name_error == 0 and $quest_error == 0 and $anthrop_error == 1) {
                    $this->session->set_tempdata('message', 13, 60);
                }
                elseif ($name_error == 1 and $quest_error == 1 and $anthrop_error == 0) {
                    $this->session->set_tempdata('message', 21, 60);
                }
                elseif ($name_error == 1 and $quest_error == 0 and $anthrop_error == 1) {
                    $this->session->set_tempdata('message', 22, 60);
                }
                elseif ($name_error == 0 and $quest_error == 1 and $anthrop_error == 1) {
                    $this->session->set_tempdata('message', 23, 60);
                }
                elseif ($name_error == 1 and $quest_error == 1 and $anthrop_error == 1) {
                    $this->session->set_tempdata('message', 24, 60);
                }
            } else {
                // Сохрано
                $this->session->set_tempdata('message', 10, 60);
            }
            header('Location: /');
        }

        // Объединенные данные страница
        $this->page_data['title'] = 'Анкета';

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/profile');
        $this->load->view('user/profile_line');

        if (!empty($this->user_id)) {
            // Вывод страницы настроек пользователя
            $this->load->view('user/questionnaire/registration_questionnaire');
        } else {
            // Пользователь не найден
            $this->session->set_tempdata('message', 136, 60);
        }

        $this->load->view('footer/footer');
    }

    /**
     * AJAX
     */
    public function getAnthropometricData()
    {
        $result = $this->User_model->getAnthropometricData($this->user_id, $this->date);

        echo json_encode($result, JSON_NUMERIC_CHECK);
    }

    /**
     * АП. Вывод списка пользователей
     *
     * @return void
     */
    public function users()
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3 or $this->session->user['blocked'] == 1) {
            parent::pageNotFound($this->page_url);
        }

        $result = $this->User_model->getUsersData();
        // Объединенные данные страница
        $this->page_data['title']        = 'АП - Пользователи';
        $this->page_data['page_menu']    = 'users';
        $this->page_data['page_submenu'] = 'a_users';

        $this->load->view('header/header_admin', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('user/users', $result);
        $this->load->view('footer/footer');
    }

    /**
     * АП. Форма редактирования и сохранение изменений настроек тренера
     *
     * @param $user_id
     * @param $page_type
     * @return void
     */
    public function userASettings($user_id, $page_type = 'settings')
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3 or $this->session->user['blocked'] == 1) {
            parent::pageNotFound($this->page_url);
        }

        $user = $this->User_model->getUserSettingsData($user_id);
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

            $password_hash = $user_data['user_password_hash'];

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
            $result = $this->User_model->setUserSettingsData($user_id, $email, $name, $password_hash, $path_avatar, $this->date);

            if ($result === true) {
                // Сохранено
                $this->session->set_tempdata('message', 10, 60);
            } else {
                // Не сохранено
                $this->session->set_tempdata('message', 9, 60);
            }

            header('Location: /administration/user/'.$user_id);
        }
        elseif ($this->input->post('bt_block_user', true) and is_numeric($user_id))
        {
            $result = $this->User_model->blockUser($user_id, $this->date);

            if ($result === true) {
                // Сохранено
                $this->session->set_tempdata('message', 16, 60);
            } else {
                // Не сохранено
                $this->session->set_tempdata('message', 17, 60);
            }
        }
        elseif ($this->input->post('bt_unblock_user', true) and is_numeric($user_id))
        {
            $result = $this->User_model->unblockUser($user_id, $this->date);

            if ($result === true) {
                // Сохранено
                $this->session->set_tempdata('message', 18, 60);
            } else {
                // Не сохранено
                $this->session->set_tempdata('message', 19, 60);
            }
        }
        elseif ($this->input->post('bt_delete_avatar', true))
        {
            $res_del = $this->User_model->deleteUserAvatar($user_id);

            if ($res_del === false) {
                // Не сохранено
                $this->session->set_tempdata('message', 96, 60);
            } else {
                // Сохранено
                $this->session->set_tempdata('message', 10, 60);
            }
            header('Location: /administration/user/'.$user_id);
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

            header('Location: /administration/user/'.$user_id);
        }
        elseif($this->input->post('bt_reset_password', true))
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

            header('Location: /administration/user/'.$user_id);
        }

        // Объединенные данные страница
        $this->page_data['title']         = 'АП - Редактирование данных пользователя';
        $this->page_data['page_menu']     = 'users';
        $this->page_data['page_submenu']  = 'a_users';
        $this->page_data['page_2submenu'] = $page_type == 'settings' ? 'settings' : 'personal_data';

        $this->load->view('header/header_admin', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('user/settings/user_settings', $user);
        $this->load->view('footer/footer');
    }

    /**
     * AJAX поиск пользователей
     *
     * @return void
     */
    public function searchUsers()
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3 or $this->session->user['blocked'] == 1) {
            parent::pageNotFound($this->page_url);
        }

        $result      = '';
        $search_text = !empty(mb_substr(strip_tags($this->input->post('search_text', true)), 0, 255))
            ? mb_substr(strip_tags($this->input->post('search_text', true)), 0, 255).'*'
            : null;

        if (!empty($search_text)) {
            $result = $this->User_model->searchUsers($search_text);
        }

        echo $result;
    }
}