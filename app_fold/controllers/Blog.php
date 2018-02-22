<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Blog
 * 
 * Класс для работы с личными сообщения, сообщениями блога, комментариями и обратной связью
 *
 * @author Alina Sudeyskis <alina.sudeyskis@gmail.com>
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Blog extends CI_Controller
{
    /**
     * Blog constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Blog_model');
    }

    /**
     * Записи блога
     *
     * Вывод списка комментариев блога для одобрения или блокирования администрацией
     *
     * @return void
     */
    public function blogPosts()
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3) {
            show_404();
        }

        // Объединенные данные страница
        $this->page_data['title'] = 'АП - Сообщения блогов';
        $this->page_data['page_menu'] = 'blog_posts';
        
        $result = $this->Blog_model->getBlogsPosts();

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('blog/posts/blog_posts', $result);
        $this->load->view('footer/footer');
    }

    /**
     * Запись блога
     *
     * Одобрение или блокировка сообщения администрацией
     *
     * @param $post_id
     * @return void
     */
    public function blogPost($post_id)
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3) {
            show_404();
        }

        if($this->input->post('bt_save_post', true))
        {
            $post_title = mb_substr(strip_tags($this->input->post('post_title', true)), 0, 100);
            $post_desc  = mb_substr(strip_tags($this->input->post('post_short_desc', true)), 0, 255);
            $post_text  = mb_substr(strip_tags($this->input->post('post_text', true)), 0, 1000);

            $result = $this->Blog_model->updateBlogPost($post_id, $post_title, $post_desc, $post_text, $this->date);

            if ($result === true)
            {
                // Сохранено
                $this->session->set_tempdata('message', 10, 60);
            }
            else
            {
                // Не сохранено
                $this->session->set_tempdata('message', 127, 60);
            }

            header('Location: /administration/blog/post/' . $post_id);
        }
        elseif ($this->input->post('bt_approval_post', true))
        {
            $result = $this->Blog_model->approvalBlogPost($post_id, $this->date);

            if ($result === true)
            {
                // Изменения сохранены
                $this->session->set_tempdata('message', 10, 60);
            }
            else
            {
                // Изменения не сохранены
                $this->session->set_tempdata('message', 35, 60);
            }

            header('Location: /administration/blog/post/'.$post_id);
        }
        elseif ($this->input->post('bt_block_post', true))
        {
            $result = $this->Blog_model->blockBlogPost($post_id, $this->date);

            if ($result === true)
            {
                // Изменения сохранены
                $this->session->set_tempdata('message', 10, 60);
            }
            else
            {
                // Изменения не сохранены
                $this->session->set_tempdata('message', 36, 60);
            }

            header('Location: /administration/blog/post/'.$post_id);
        }
        /*elseif ($this->input->post('bt_delete_post', true))
        {
            $result = $this->Blog_model->deleteBlogPost($post_id);

            if ($result === true)
            {
                // Изменения сохранены
                $this->session->set_tempdata('message', 10, 60);

                header('Location: /administration/blog/posts/');
            }
            else
            {
                // Изменения не сохранены
                $this->session->set_tempdata('message', 126, 60);

                header('Location: /administration/blog/post/'.$post_id);
            }
        }*/
        
        // Объединенные данные страница
        $this->page_data['title'] = 'АП - Редактирование данных сообщения блога';
        $this->page_data['page_menu'] = 'blog_posts';
        
        $result = $this->Blog_model->getBlogPost($post_id);

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('blog/posts/blog_post', $result);
        $this->load->view('footer/footer');
    }

    /**
     * Комментарии блога
     *
     * Вывод списка комментариев блога для одобрения или блокирования администрацией
     *
     * @return void
     */
    public function blogComments()
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3) {
            show_404();
        }

        // Объединенные данные страница
        $this->page_data['title'] = 'АП - Комментарии блогов';
        $this->page_data['page_menu'] = 'blog_comments';
        
        $result = $this->Blog_model->getBlogsComments();

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('blog/posts/comments', $result);
        $this->load->view('footer/footer');
    }

    /**
     * Комментарий блога.
     *
     * Одобрение или блокировка комментария администрацией
     *
     * @param $comment_id
     * @return void
     */
    public function blogComment($comment_id)
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3) {
            show_404();
        }

        if ($this->input->post('bt_approval_comment', true)) {
            $result = $this->Blog_model->approvalComment($comment_id, $this->date);

            if ($result === true) {
                // Изменения сохранены
                $this->session->set_tempdata('message', 10, 60);
            } else {
                // Изменения не сохранены
                $this->session->set_tempdata('message', 35, 60);
            }
            header('Location: /administration/blog/comment/'.$comment_id);
        }
        elseif ($this->input->post('bt_block_comment', true)) {
            $result = $this->Blog_model->blockComment($comment_id, $this->date);

            if ($result === true) {
                // Изменения сохранены
                $this->session->set_tempdata('message', 10, 60);
            } else {
                // Изменения не сохранены
                $this->session->set_tempdata('message', 36, 60);
            }
            header('Location: /administration/blog/comment/'.$comment_id);
        }
        
        // Объединенные данные страница
        $this->page_data['title'] = 'АП - Редактирование данных комментария блога';
        $this->page_data['page_menu'] = 'blog_comments';
        
        $result = $this->Blog_model->getBlogComment($comment_id);

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('blog/posts/comment', $result);
        $this->load->view('footer/footer');
    }

    /**
     * Диалоги пользователя
     *
     * Вывод списка прикрепленных тренеров, список диалогов с последним сообщением, обратная связь
     *
     * @return void
     */
    public function userMessages()
    {
        // Если пользователь не авторизован, переход на страницу авторизации
        if (empty($this->user_id)) {
            header('Location: /login');
        }

        $this->load->model('Couch_model');
        
        // Список диалогов
        $result = $this->Blog_model->getUserConversations($this->user_id);

        /*$new_messages    = $this->Blog_model->getCountNewMessages($this->user_id);
        $new_fb_messages = $this->Blog_model->getCountNewFeedbackMessages($this->session->user['email']);

        if (!empty($result['num_new_messages'])) {
            // Обновление данных сессии
            $this->session->set_userdata("new_messages", $result['num_new_messages']);
        }*/

        if ($this->session->user['type'] == 2) {
            // Список пользователей
            $result['attached_users'] = $this->Couch_model->getAttachedUsers($this->user_id);
        } else {
            // Список тренеров
            $result['attached_couches'] = $this->Couch_model->getAttachedCouches($this->user_id);
        }

        // Объединенные данные страницы
        $this->page_data['title'] = 'Сообщения';
        $this->page_data['page_menu'] = 'messages';
        $this->page_data['user_with'] = '';

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/profile');
        $this->load->view('user/profile_line');
        $this->load->view('blog/messages/user_messages', $result);
        $this->load->view('footer/footer');
    }

    /**
     * Сообщения диалога пользователя
     *
     * Вывод списка прикрепленных тренеров, список сообщений диалога, обратная связь
     *
     * @param int|string $user_with ID пользователя с кем идет переписка или Обратная связь
     * @return void
     */
    public function userConversation($user_with)
    {
        // Если пользователь не авторизован, переход на страницу авторизации
        if (empty($this->user_id)) {
            header('Location: /login');
        }

        $feedback = false;

        $this->load->model('Couch_model');

        if (is_numeric($user_with)) {
            $conv_id = $this->Blog_model->getConversationId($this->user_id, $user_with);
        }
        elseif ($user_with == 'feedback') {
            $feedback = true;
        }
        
        if ($this->input->post('bt_send_message', true)) {
            $message_text = mb_substr(strip_tags($this->input->post('ta_message_text')), 0, 1000);

            if (!empty($conv_id)) {
                $this->Blog_model->setUserMessage($this->user_id, $user_with, $conv_id, $message_text, $this->date);
            }
            elseif ($feedback === true) {
                $user_name  = $this->session->user['name'];
                $user_email = $this->session->user['email'];
                $this->Blog_model->setFeedbackMessage($user_name, $user_email, $message_text, $this->date);
            }

            header('Location: /messages/' . $user_with);
        }

        // Список сообщений диалога
        $conversations = $this->Blog_model->getUserConversations($this->user_id);
        $messages      = is_numeric($user_with)
            ? $this->Blog_model->getUserMessages($this->user_id, $user_with, $this->date)
            : array('user_messages' => array());
        $feedback_mess = (!empty($this->session->user['email']) and $feedback === true)
            ? $this->Blog_model->getFeedbackUserMessages($this->session->user['email'], $this->date)
            : array('fb_user_messages' => array());

        $result = array_merge($conversations, $messages, $feedback_mess);

        // Обновления состояния сообщения с нового на прочитаное
        if (is_numeric($user_with) and $this->session_data['new_messages'] > 0) {
            $count_new_messages = $this->Blog_model->updateReadingStatus($this->user_id, $user_with, $this->session->user['email']);
            if ($count_new_messages !== false and $count_new_messages != $this->session_data['new_messages']) {
                // Обновление данных сессии
                $this->session->set_userdata("new_messages", $count_new_messages);
                header('Location: /messages/'.$user_with);
            }
        }
        elseif($user_with == 'feedback' and $this->session_data['new_fb_messages'] > 0) {
            $count_new_messages = $this->Blog_model->updateFeedbackReadingStatus($this->session->user['email'], $this->user_id);
            if ($count_new_messages !== false and $count_new_messages != $this->session_data['new_fb_messages']) {
                // Обновление данных сессии
                $this->session->set_userdata("new_fb_messages", $count_new_messages);
                header('Location: /messages/'.$user_with);
            }
        }

        if ($this->session->user['type'] == 2) {
            // Список пользователей
            $result['attached_users'] = $this->Couch_model->getAttachedUsers($this->user_id);
        } else {
            // Список тренеров
            $result['attached_couches'] = $this->Couch_model->getAttachedCouches($this->user_id);            
        }

        // Объединенные данные страница
        $this->page_data['title'] = 'Сообщения';
        $this->page_data['page_menu'] = 'messages';
        $this->page_data['user_with'] = $user_with;

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/profile');
        $this->load->view('user/profile_line');
        $this->load->view('blog/messages/user_messages', $result);
        $this->load->view('footer/footer');
    }

    /**
     * Личные сообщения
     *
     * @return void
     */
    public function messages()
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3) {
            show_404();
        }

        // Объединенные данные страница
        $this->page_data['title'] = 'АП - Сообщения пользователей';
        $this->page_data['page_menu'] = 'messages';

        $result = $this->Blog_model->getMessages();


        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('blog/messages/messages', $result);
        $this->load->view('footer/footer');
    }

    /**
     * Сообщение пользователя
     *
     * Разблокировка или блокировка сообщения администрацией
     *
     * @param $message_id
     * @return void
     */
    public function message($message_id)
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3) {
            show_404();
        }

        if ($this->input->post('bt_unblock_message', true)) {
            $result = $this->Blog_model->unblockMessage($message_id, $this->date);

            if ($result === true) {
                // Изменения сохранены
                $this->session->set_tempdata('message', 10, 60);
            } else {
                // Изменения не сохранены
                $this->session->set_tempdata('message', 49, 60);
            }
            header('Location: /administration/message/'.$message_id);
        }
        elseif ($this->input->post('bt_block_message', true)) {
            $result = $this->Blog_model->blockMessage($message_id, $this->date);

            if ($result === true) {
                // Изменения сохранены
                $this->session->set_tempdata('message', 10, 60);
            } else {
                // Изменения не сохранены
                $this->session->set_tempdata('message', 50, 60);
            }
            header('Location: /administration/message/'.$message_id);
        }

        // Объединенные данные страница
        $this->page_data['title'] = 'АП - Редактирование данных сообщения пользователя';
        $this->page_data['page_menu'] = 'messages';

        $result = $this->Blog_model->getMessage($message_id);

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('blog/messages/message', $result);
        $this->load->view('footer/footer');
    }

    /**
     * Форма обратной связи
     *
     * @return void
     */
    public function feedback()
    {
        if ($this->input->post('bt_send_message', true)) {
            $user_name    = mb_substr(strip_tags($this->input->post('i_name', true)), 0, 255);
            $user_email   = filter_var($this->input->post('i_email', true), FILTER_VALIDATE_EMAIL) ? $this->input->post('i_email', true) : null;
            $message_text = mb_substr(strip_tags($this->input->post('ta_message_text', true)), 0, 1000);

            if (!empty($user_name) and !empty($user_email) and !empty($message_text)) {
                $result = $this->Blog_model->setFeedbackMessage($user_name, $user_email, $message_text, $this->date);

                if ($result === true) {
                    // Отправление письма с копией сообщения обратной связи
                    $email_to = "<$user_email>";
                    $subject  = "Обраятная связь SuperBody";

                    $message  = 'Здравствуйте, ' . $user_name . '!<br/><br/>';
                    $message  .= 'Мы постараемся в ближайшее время ответить Вам на сообщение.<br/><br/>';
                    $message  .= '"' . nl2br($message_text) . '"';

                    $headers  = "Content-type: text/html; charset=utf-8 \r\n";
                    $headers  .= "From: Support SuperBody.pro <info@superbody.pro>\r\n";
                    $headers  .= "Reply-To: info@superbody.pro\r\n";

                    mail($email_to, $subject, $message, $headers);

                    // Изменения сохранены
                    $this->session->set_tempdata('message', 52, 60);
                } else {
                    // Изменения не сохранены
                    $this->session->set_tempdata('message', 51, 60);
                }
                header('Location: /feedback');
            }
        }

        // Объединенные данные страница
        $this->page_data['title'] = 'Обратная связь';
        $this->page_data['page_menu'] = 'feedback';

        $this->load->view('header/header', $this->page_data);
        $this->load->view('blog/feedback');
        $this->load->view('footer/footer');
    }

    /**
     * Сообщения обратной связи (сгруппированно по e-mail пользователей)
     *
     * @return void
     */
    public function feedbackMessages()
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3) {
            show_404();
        }

        $result = $this->Blog_model->getFeedbackMessages();

        // Объединенные данные страница
        $this->page_data['title'] = 'АП - Сообщения обратной связи';
        $this->page_data['page_menu'] = 'feedback';

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('blog/messages/feedback_messages', $result);
        $this->load->view('footer/footer');
    }

    /**
     * Сообщения диалога обратной связи с пользователем
     *
     * @param string $user_email E-mail пользователя
     * @return void
     */
    public function feedbackUserMessages($user_email)
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3) {
            show_404();
        }

        /**
         * @var array Сообщения диалога с пользователем
         */
        $result = array();

        if (filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
            $result = $this->Blog_model->getFeedbackUserMessages($user_email);
        } else {
            $this->session->set_tempdata('message', 53, 60);
            header('Location: /administration/feedback/');
        }

        if ($this->input->post('bt_send_message', true)) {
            $conv_id = $result['fb_conv_id'];

            $text = mb_substr(strip_tags($this->input->post('ta_message_text', true)), 0, 1000);

            if (filter_var($user_email, FILTER_VALIDATE_EMAIL) and !empty($text)) {
                $result = $this->Blog_model->setFeedbackAnswer($this->user_id, $user_email, $text, $conv_id, $this->date);

                if ($result === true) {
                    setlocale(LC_ALL, 'ru_RU.UTF-8');
                    $date = DateTime::createFromFormat('Y-m-d H:i:s', $this->date);
                    $message_date = ($this->date != '0000-00-00 00:00:00' or $date !== false)
                        ? $date->format('d.m.Y')
                        : '';
                    $message_time = ($this->date != '0000-00-00 00:00:00' or $date !== false)
                        ? $date->format('H:i')
                        : '';

                    // Отправление письма с копией сообщения обратной связи
                    $email_to = "<$user_email>";
                    $subject  = "Обраятная связь SuperBody";

                    $message_text  =
                            '<div style="margin-bottom: 10px;">' .
                            '<div style="margin-left: 10px; padding-top: 2px; color: #b7b7b7;">' . $message_date . ' ' . $message_time . '</div>' .
                            '<div style="margin: 10px 0 0 20px;">' . nl2br($text) . '</div>' .
                            '</div>';

                    $headers  = "Content-type: text/html; charset=utf-8 \r\n";
                    $headers  .= "From: Support Theoutlines.ru <support@theoutlines.ru>\r\n";
                    $headers  .= "Reply-To: support@theoutlines.ru\r\n";

                    mail($email_to, $subject, $message_text, $headers, '-fsupport@theoutlines.ru');

                    // Изменения сохранены
                    $this->session->set_tempdata('message', 54, 60);
                } else {
                    // Изменения не сохранены
                    $this->session->set_tempdata('message', 51, 60);
                }
                header('Location: /administration/feedback/'.$user_email);
            }
        }

        // Объединенные данные страница
        $this->page_data['title'] = 'АП - Сообщения диалога обратной связи с пользователем';
        $this->page_data['page_menu'] = 'feedback';

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('blog/messages/feedback_user_messages', $result);
        $this->load->view('footer/footer');
    }


    /**
     * Записи блога тренера
     */
    public function getCouchPosts()
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 2)
        {
            show_404();
        }

        // Объединенные данные страница
        $this->page_data['title'] = 'Блог';
        $this->page_data['page_menu'] = 'blog';

        $result = $this->Blog_model->getCouchBlogPosts($this->user_id);

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/profile');
        $this->load->view('user/profile_line');
        $this->load->view('blog/posts/user_posts', $result);
        $this->load->view('footer/footer');
    }

    /**
     * Запись блога тренера
     *
     * @param $post_id
     */
    public function getCouchPost($post_id)
    {
        if (empty($this->user_id) or $this->session->user['type'] != 2)
        {
            show_404();
        }

        if($this->input->post('bt_save_post', true))
        {
            $post_title = mb_substr(strip_tags($this->input->post('post_title', true)), 0, 100);
            $post_desc  = mb_substr(strip_tags($this->input->post('post_short_desc', true)), 0, 255);
            $post_text  = mb_substr(strip_tags($this->input->post('post_text', true)), 0, 1000);

            $result = $this->Blog_model->updateCouchBlogPost($this->user_id, $post_id, $post_title, $post_desc, $post_text, $this->date);

            if ($result === true)
            {
                // Сохранено
                $this->session->set_tempdata('message', 10, 60);
            }
            else
            {
                // Не сохранено
                $this->session->set_tempdata('message', 127, 60);
            }

            header('Location: /post/' . $post_id);
        }
        if ($this->input->post('bt_send_comment', true) and !empty($this->input->post('post_comment', true)))
        {
            $user_id      = $this->user_id;
            $post_comment = mb_substr(strip_tags($this->input->post('post_comment', true)), 0, 500);

            if (!empty($post_comment))
            {
                $res_send_comm = $this->Blog_model->setBlogComment($user_id, $post_id, $post_comment, $this->date);

                if ($res_send_comm === true)
                {
                    // Сохранено
                    $this->session->set_tempdata('message', 97, 60);
                }
                else
                {
                    // Не сохранено
                    $this->session->set_tempdata('message', 98, 60);
                }
            }

            header('Location: /post/' . $post_id);
        }

        $result = $this->Blog_model->getCouchBlogPost($this->user_id, $post_id);

        // Объединенные данные страница
        $this->page_data['title'] = 'Блог тренера';
        $this->page_data['page_menu'] = 'blog';

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/profile');
        $this->load->view('user/profile_line');
        $this->load->view('blog/posts/user_post', $result);
        $this->load->view('footer/footer');
    }

    /**
     * Запись блога
     *
     * @param $post_id
     */
    public function getPost($post_id)
    {
        if ($this->input->post('bt_send_comment', true) and !empty($this->input->post('post_comment', true)))
        {
            $user_id      = $this->user_id;
            $post_comment = mb_substr(strip_tags($this->input->post('post_comment', true)), 0, 500);

            if (!empty($post_comment))
            {
                $res_send_comm = $this->Blog_model->setBlogComment($user_id, $post_id, $post_comment, $this->date);

                if ($res_send_comm === true)
                {
                    // Сохранено
                    $this->session->set_tempdata('message', 97, 60);
                }
                else
                {
                    // Не сохранено
                    $this->session->set_tempdata('message', 98, 60);
                }
            }

            header('Location: /blog/' . $post_id);
        }

        $result = $this->Blog_model->getPublicBlogPost($post_id);

        // Объединенные данные страница
        $this->page_data['title'] = 'Блог тренера';
        $this->page_data['page_menu'] = 'blog';

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/profile');
        $this->load->view('user/profile_line');
        $this->load->view('blog/posts/post', $result);
        $this->load->view('footer/footer');
    }

    public function newCouchPost()
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 2)
        {
            show_404();
        }

        if ($this->input->post('bt_save_post', true))
        {
            $post_title = mb_substr(strip_tags($this->input->post('post_title', true)), 0, 100);
            $post_desc  = mb_substr(strip_tags($this->input->post('post_short_desc', true)), 0, 255);
            $post_text  = mb_substr(strip_tags($this->input->post('post_text', true)), 0, 1000);

            $result = $this->Blog_model->setBlogPost($this->user_id, $post_title, $post_desc, $post_text, $this->date);

            if ($result !== false) {
                $post_id = $result;

                // Сохранено
                $this->session->set_tempdata('message', 113, 60);

                header('Location: /post/' . $post_id);
            }
            else
            {
                // Не сохранено
                $this->session->set_tempdata('message', 114, 60);

                header('Location: /post/new');
            }
        }

        // Объединенные данные страница
        $this->page_data['title'] = 'Добавление записи блога';
        $this->page_data['page_menu'] = 'blog';

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/profile');
        $this->load->view('user/profile_line');
        $this->load->view('blog/posts/new_post');
        $this->load->view('footer/footer');
    }
}