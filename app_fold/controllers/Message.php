<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Message
 *
 * Класс для работы с личными сообщения и обратной связью
 *
 * @author Alina Sudeyskis <alina.sudeyskis@gmail.com>
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Message extends CI_Controller
{
    /**
     * Message constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Message_model');
    }

    /**
     * Сообщения диалога пользователя
     *
     * Вывод списка прикрепленных тренеров, список сообщений диалога, обратная связь
     *
     * @param int|string|null $user_with ID пользователя с кем идет переписка или Обратная связь
     * @return void
     */
    public function userConversation($user_with = null)
    {
        // Если пользователь не авторизован, переход на страницу авторизации
        if (empty($this->user_id)) {
            header('Location: /login');
        }

        $feedback = ($user_with == 'feedback') ? true : false;

        if ($this->input->post('bt_send_message', true))
        {
            $res_mess = null;

            $message_text = mb_substr(strip_tags($this->input->post('ta_message_text')), 0, 1000);

            if (is_numeric($user_with))
            {
                $res_mess = $this->Message_model->setUserMessage($this->user_id, $user_with, $message_text, $this->date);

                if ($res_mess === true)
                {
                    // Изменения сохранены
                    $this->session->set_tempdata('message', 131, 60);
                }
                elseif($res_mess === false)
                {
                    // Изменения не сохранены
                    $this->session->set_tempdata('message', 51, 60);
                }
            }
            elseif ($feedback === true)
            {
                $user_name  = mb_substr(strip_tags($this->session->user['name']), 0, 255);
                $user_email = filter_var($this->session->user['email'], FILTER_VALIDATE_EMAIL) ? $this->session->user['email'] : '';

                $res_fb_mess = $this->Message_model->setFeedbackMessage($this->user_id, $user_name, $user_email, $message_text, $this->date);

                if ($res_fb_mess === true)
                {
                    // Изменения сохранены
                    $this->session->set_tempdata('message', 52, 60);
                }
                elseif($res_fb_mess === false)
                {
                    // Изменения не сохранены
                    $this->session->set_tempdata('message', 51, 60);
                }
            }

            header('Location: /messages/' . $user_with);
        }

        $this->load->model('Couch_model');

        // Список сообщений диалога
        $conversations = $this->Message_model->getUserConversations($this->user_id, $user_with);
        $messages      = $this->Message_model->getUserMessages($this->user_id, $user_with, $this->date);
        $feedback_mess = $this->Message_model->getUserFeedbackMessages($this->user_id, $this->session->user['email'], null, $this->date);

        $result = array_merge($conversations, $messages, $feedback_mess);

        // Обновления состояния сообщения с нового на прочитаное
        if (is_numeric($user_with) and $this->session->new_messages > 0)
        {
            $count_new_messages = $this->Message_model->updateReadingStatus($this->user_id, $user_with);
            // Обновление данных сессии
            if ($count_new_messages !== false and $count_new_messages != $this->session->new_messages)
            {
                $this->session->set_userdata("new_messages", $count_new_messages);
                header('Location: /messages/'.$user_with);
            }
        }
        elseif($user_with == 'feedback' and $this->session->new_fb_messages > 0)
        {
            $count_new_messages = $this->Message_model->updateFeedbackReadingStatus($this->session->user['email'], $this->user_id);
            // Обновление данных сессии
            if ($count_new_messages !== false and $count_new_messages != $this->session->new_fb_messages)
            {
                $this->session->set_userdata("new_fb_messages", $count_new_messages);
                header('Location: /messages/'.$user_with);
            }
        }

        if ($this->session->user['type'] == 2)
        {
            // Список пользователей
            $result['attached_users'] = $this->Couch_model->getAttachedUsers($this->user_id);
        }
        else
        {
            // Список тренеров
            $result['attached_couches'] = $this->Couch_model->getAttachedCouches($this->user_id);
        }

        // Уведомления пользователя
        if($messages['user_with_blocked'] == 1)
        {
            $this->load->model('Notification_model');
            $notification = $this->Notification_model->getNotification(16);

            $this->page_data['user_notification']['blocked']['text'] = $notification['notification']['text'];
        }

        // Объединенные данные страница
        $this->page_data['title'] = 'Сообщения';
        $this->page_data['page_menu'] = 'messages';
        $this->page_data['user_with'] = $user_with;

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/profile');
        $this->load->view('user/profile_line');
        $this->load->view('messages/user_messages', $result);
        $this->load->view('footer/footer');
    }

    /**
     * АП. Личные сообщения пользователей
     *
     * @return void
     */
    public function messages()
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3 or $this->session->user['blocked'] == 1) {
            parent::pageNotFound($this->page_url);
        }

        // Объединенные данные страница
        $this->page_data['title'] = 'АП - Сообщения пользователей';
        $this->page_data['page_menu'] = 'messages';

        $result = $this->Message_model->getMessages();

        $this->load->view('header/header_admin', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('messages/messages', $result);
        $this->load->view('footer/footer');
    }

    /**
     * АП. Сообщение пользователя
     *
     * Разблокировка или блокировка сообщения администрацией
     *
     * @param $message_id
     * @return void
     */
    public function message($message_id)
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3 or $this->session->user['blocked'] == 1) {
            parent::pageNotFound($this->page_url);
        }

        if ($this->input->post('bt_unblock_message', true))
        {
            $result = $this->Message_model->unblockMessage($message_id, $this->date);

            if ($result === true)
            {
                // Изменения сохранены
                $this->session->set_tempdata('message', 10, 60);
            }
            else
            {
                // Изменения не сохранены
                $this->session->set_tempdata('message', 49, 60);
            }
            header('Location: /administration/message/'.$message_id);
        }
        elseif ($this->input->post('bt_block_message', true))
        {
            $result = $this->Message_model->blockMessage($message_id, $this->date);

            if ($result === true)
            {
                // Изменения сохранены
                $this->session->set_tempdata('message', 10, 60);
            }
            else
            {
                // Изменения не сохранены
                $this->session->set_tempdata('message', 50, 60);
            }
            header('Location: /administration/message/'.$message_id);
        }

        // Объединенные данные страница
        $this->page_data['title'] = 'АП - Редактирование данных сообщения пользователя';
        $this->page_data['page_menu'] = 'messages';

        $result = $this->Message_model->getMessage($message_id);

        $this->load->view('header/header_admin', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('messages/message', $result);
        $this->load->view('footer/footer');
    }


    /**
     * Форма обратной связи
     *
     * @return void
     */
    /*public function feedback()
    {
        if ($this->input->post('bt_send_message', true)) {
            $user_name    = mb_substr(strip_tags($this->input->post('i_name', true)), 0, 255);
            $user_email   = filter_var($this->input->post('i_email', true), FILTER_VALIDATE_EMAIL) ? $this->input->post('i_email', true) : null;
            $message_text = mb_substr(strip_tags($this->input->post('ta_message_text', true)), 0, 1000);

            if (!empty($user_name) and !empty($user_email) and !empty($message_text)) {
                $result = $this->Message_model->setFeedbackMessage($user_name, $user_email, $message_text, $this->date);

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
    }*/

    /**
     * АП. Сообщения обратной связи
     *
     * @return void
     */
    public function feedbackMessages()
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3 or $this->session->user['blocked'] == 1) {
            parent::pageNotFound($this->page_url);
        }

        $result = $this->Message_model->getFeedbackMessages();

        // Объединенные данные страница
        $this->page_data['title'] = 'АП - Сообщения обратной связи';
        $this->page_data['page_menu'] = 'feedback';

        $this->load->view('header/header_admin', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('messages/feedback_messages', $result);
        $this->load->view('footer/footer');
    }

    /**
     * АП. Сообщения диалога обратной связи с пользователем
     *
     * @param string|int $identification Идентификатор пользователя (email или ID)
     * @param string|int $conv_id ID беседы
     * @return void
     */
    public function feedbackUserMessages($identification = '', $conv_id = '')
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3 or $this->session->user['blocked'] == 1)
        {
            parent::pageNotFound($this->page_url);
        }

        if ($this->input->post('bt_send_message', true))
        {
            $text = mb_substr(strip_tags($this->input->post('ta_message_text', true)), 0, 1000);

            if (!empty($text))
            {
                if (!empty($conv_id) and is_numeric($conv_id))
                {
                    $result = $this->Message_model->setFeedbackAnswer($this->user_id, null, null, $text, $conv_id, $this->date);

                    if ($result === true)
                    {
                        // Изменения сохранены
                        $this->session->set_tempdata('message', 131, 60);
                    }
                    else
                    {
                        // Изменения не сохранены
                        $this->session->set_tempdata('message', 51, 60);
                    }
                    header('Location: /administration/feedback/conv/' . $conv_id);
                }
                if (!empty($identification) and is_numeric($identification))
                {
                    $result = $this->Message_model->setFeedbackAnswer($this->user_id, $identification, null, $text, null, $this->date);

                    if ($result === true)
                    {
                        // Изменения сохранены
                        $this->session->set_tempdata('message', 131, 60);
                    }
                    else
                    {
                        // Изменения не сохранены
                        $this->session->set_tempdata('message', 51, 60);
                    }
                    header('Location: /administration/feedback/' . $identification);
                }
                if (!empty($identification) and filter_var($identification, FILTER_VALIDATE_EMAIL))
                {
                    $result = $this->Message_model->setFeedbackAnswer($this->user_id, null, $identification, $text, null, $this->date);

                    // Отправление письма с копией сообщений обратной связи
                    if (is_array($result))
                    {
                        $system_message['text'] = '';

                        foreach ($result['fb_user_messages'] as $fb_message)
                        {
                            $system_message['text']  .=
                                '<div style="margin-bottom: 10px;">' .
                                '<div style="margin-left: 10px; padding-top: 2px; color: #b7b7b7;">' . $fb_message['date'] . ' ' . $fb_message['time'] . '</div>' .
                                '<div style="margin: 10px 0 0 20px;">' . nl2br($fb_message['text']) . '</div>' .
                                '</div>';
                        }

                        parent::sendEmail(7, $identification, $system_message);

                        // Изменения сохранены
                        $this->session->set_tempdata('message', 54, 60);
                    }
                    // Отправка уведомления о новом сообщении
                    elseif($result === true)
                    {
                        $system_message['text']  = '';

                        parent::sendEmail(8, $identification, $system_message);

                        // Изменения сохранены
                        $this->session->set_tempdata('message', 54, 60);
                    }
                    else
                    {
                        // Изменения не сохранены
                        $this->session->set_tempdata('message', 51, 60);
                    }
                    header('Location: /administration/feedback/' . $identification);
                }
            }
        }

        /**
         * @var array Сообщения диалога с пользователем
         */
        $result = array();

        // Сообщения диалога
        if (!empty($identification) and is_numeric($identification))
        {
            $result = $this->Message_model->getFeedbackUserMessages($identification);
        }
        elseif (!empty($identification) and filter_var($identification, FILTER_VALIDATE_EMAIL))
        {
            $result = $this->Message_model->getFeedbackUserMessages(null, $identification);
        }
        elseif(is_numeric($conv_id))
        {
            $result = $this->Message_model->getFeedbackUserMessages(null, null, $conv_id);
        }
        else
        {
            $this->session->set_tempdata('message', 53, 60);
            header('Location: /administration/feedback/');
        }

        // Объединенные данные страница
        $this->page_data['title'] = 'АП - Сообщения диалога обратной связи с пользователем';
        $this->page_data['page_menu'] = 'feedback';

        $this->load->view('header/header_admin', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('messages/feedback_user_messages', $result);
        $this->load->view('footer/footer');
    }

    /* БЛОК ОБРАБОТКИ ДАННЫХ РАЗДЕЛА ВОПРОС - ОТВЕТ */

    /**
     * Вывод списка статей Вопрос - Ответ
     */
    public function eQuestionAnswer()
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3 or $this->session->user['blocked'] == 1) {
            parent::pageNotFound($this->page_url);
        }

        $users_group = $this->Message_model->getQaUsersGroup();
        $count_ug    = count($users_group);
        $result = $this->Message_model->getQaArticles($count_ug);

        // Объединенные данные страница
        $this->page_data['title']        = 'АП - Вопрос - Ответ';
        $this->page_data['page_menu']    = 'question-answer';
        $this->page_data['page_submenu'] = 'qa_articles';
        $this->page_data['page_type']    = 'articles';

        $this->load->view('header/header_admin', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('question-answer/qa', $result);
        $this->load->view('footer/footer');
    }

    /**
     * Вывод формы добавления раздела Вопрос - Ответ
     */
    public function eQaNewSection()
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3 or $this->session->user['blocked'] == 1) {
            parent::pageNotFound($this->page_url);
        }

        if($this->input->post('bt_save_new_section', true))
        {
            $section_name = mb_substr(strip_tags($this->input->post('section_name', true)), 0, 255);

            if(!empty($section_name))
            {
                $res_ins = $this->Message_model->setNewQaSection($section_name, $this->user_id, $this->date);

                if($res_ins !== false and is_numeric($res_ins))
                {
                    // Изменения сохранены
                    $this->session->set_tempdata('message', 10, 60);

                    header('Location: /administration/question-answer/section/'.$res_ins);
                }
                else
                {
                    // Изменения не сохранены
                    $this->session->set_tempdata('message', 199, 60);

                    header('Location: /administration/question-answer/section/new');
                }
            }
            else
            {
                // Изменения не сохранены
                $this->session->set_tempdata('message', 199, 60);

                header('Location: /administration/question-answer/section/new');
            }
        }

        // Объединенные данные страница
        $this->page_data['title']        = 'АП - Вопрос - Ответ';
        $this->page_data['page_menu']    = 'question-answer';
        $this->page_data['page_submenu'] = 'qa_sections';
        $this->page_data['page_type']    = 'new_section';

        $this->load->view('header/header_admin', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('question-answer/qa');
        $this->load->view('footer/footer');
    }

    /**
     * Вывод формы редактирования раздела Вопрос - Ответ
     * @param $section_id
     */
    public function eQaSection($section_id)
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3 or $this->session->user['blocked'] == 1) {
            parent::pageNotFound($this->page_url);
        }

        $section = $this->Message_model->getQaSection($section_id);
        $subsections = $this->Message_model->getQaSectionSubsections($section_id);
        $result = array_merge($section, $subsections);

        if($this->input->post('bt_save_section', true))
        {
            $section_name = mb_substr(strip_tags($this->input->post('section_name', true)), 0, 255);

            if(!empty($section_name) and $section_name != $section['section']['name'])
            {
                $res_up = $this->Message_model->setQaSection($section_id, $section_name, $this->user_id, $this->date);

                if($res_up === true)
                {
                    // Изменения сохранены
                    $this->session->set_tempdata('message', 10, 60);
                }
                else
                {
                    // Изменения не сохранены
                    $this->session->set_tempdata('message', 199, 60);
                }
            }
            else
            {
                // Изменения не сохранены
                $this->session->set_tempdata('message', 199, 60);
            }

            header('Location: /administration/question-answer/section/' . $section_id);
        }
        elseif($this->input->post('bt_block_section', true))
        {
            $res_up = $this->Message_model->blockQaSection($section_id, 1, $this->user_id, $this->date);

            if($res_up === true)
            {
                // Изменения сохранены
                $this->session->set_tempdata('message', 10, 60);
            }
            else
            {
                // Изменения не сохранены
                $this->session->set_tempdata('message', 199, 60);
            }
            header('Location: /administration/question-answer/section/' . $section_id);
        }
        elseif($this->input->post('bt_unblock_section', true))
        {
            $res_up = $this->Message_model->blockQaSection($section_id, 0, $this->user_id, $this->date);

            if($res_up === true)
            {
                // Изменения сохранены
                $this->session->set_tempdata('message', 10, 60);
            }
            else
            {
                // Изменения не сохранены
                $this->session->set_tempdata('message', 199, 60);
            }
            header('Location: /administration/question-answer/section/' . $section_id);
        }

        // Объединенные данные страница
        $this->page_data['title']        = 'АП - Вопрос - Ответ';
        $this->page_data['page_menu']    = 'question-answer';
        $this->page_data['page_submenu'] = 'qa_sections';
        $this->page_data['page_type']    = 'section';

        $this->load->view('header/header_admin', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('question-answer/qa', $result);
        $this->load->view('footer/footer');
    }

    /**
     * Вывод списка разделов Вопрос - Ответ
     */
    public function eQaSections()
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3 or $this->session->user['blocked'] == 1) {
            parent::pageNotFound($this->page_url);
        }

        $sections = $this->Message_model->getQaSections();

        // Объединенные данные страница
        $this->page_data['title']        = 'АП - Вопрос - Ответ';
        $this->page_data['page_menu']    = 'question-answer';
        $this->page_data['page_submenu'] = 'qa_sections';
        $this->page_data['page_type']    = 'sections';

        $this->load->view('header/header_admin', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('question-answer/qa', $sections);
        $this->load->view('footer/footer');
    }

    /**
     * Вывод формы добавления подраздела Вопрос - Ответ
     */
    public function eQaNewSubsection()
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3 or $this->session->user['blocked'] == 1) {
            parent::pageNotFound($this->page_url);
        }

        $sections = $this->Message_model->getQaSections();

        if($this->input->post('bt_save_new_subsection', true))
        {
            $section_id = (is_numeric($this->input->post('s_section', true))) ? $this->input->post('s_section', true) : null;
            $sub_name   = mb_substr(strip_tags($this->input->post('subsection_name', true)), 0, 255);

            if(!empty($section_id) and !empty($sub_name))
            {
                $ins_res = $this->Message_model->setNewQaSubsection($section_id, $sub_name, $this->user_id, $this->date);

                if($ins_res !== false and is_numeric($ins_res))
                {
                    // Изменения сохранены
                    $this->session->set_tempdata('message', 10, 60);

                    header('Location: /administration/question-answer/subsection/'.$ins_res);
                }
                else
                {
                    // Изменения не сохранены
                    $this->session->set_tempdata('message', 200, 60);

                    header('Location: /administration/question-answer/subsection/new');
                }
            }
            else
            {
                // Изменения не сохранены
                $this->session->set_tempdata('message', 200, 60);

                header('Location: /administration/question-answer/subsection/new');
            }
        }

        // Объединенные данные страница
        $this->page_data['title']        = 'АП - Вопрос - Ответ';
        $this->page_data['page_menu']    = 'question-answer';
        $this->page_data['page_submenu'] = 'qa_sections';
        $this->page_data['page_type']    = 'new_subsection';

        $this->load->view('header/header_admin', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('question-answer/qa', $sections);
        $this->load->view('footer/footer');
    }

    /**
     * Вывод формы редактирования подраздела Вопрос - Ответ
     * @param $subsection_id
     */
    public function eQaSubsection($subsection_id)
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3 or $this->session->user['blocked'] == 1) {
            parent::pageNotFound($this->page_url);
        }

        $sections = $this->Message_model->getQaSections();
        $subsection = $this->Message_model->getQaSubsection($subsection_id);
        $result = array_merge($sections, $subsection);

        if($this->input->post('bt_save_subsection', true))
        {
            $section_id = (is_numeric($this->input->post('s_section', true))) ? $this->input->post('s_section', true) : null;
            $sub_name   = mb_substr(strip_tags($this->input->post('subsection_name', true)), 0, 255);

            if(!empty($section_id) and !empty($sub_name)
                and ($sub_name !== $subsection['subsection']['name'] or $section_id != $subsection['subsection']['section_id']))
            {
                $res_up = $this->Message_model->setQaSubsection($subsection_id, $section_id, $sub_name, $this->user_id, $this->date);

                if($res_up === true)
                {
                    // Изменения сохранены
                    $this->session->set_tempdata('message', 10, 60);
                }
                else
                {
                    // Изменения не сохранены
                    $this->session->set_tempdata('message', 200, 60);
                }
            }
            else
            {
                // Изменения не сохранены
                $this->session->set_tempdata('message', 200, 60);
            }
            header('Location: /administration/question-answer/subsection/' . $subsection_id);
        }
        elseif($this->input->post('bt_block_subsection', true))
        {
            $res_up = $this->Message_model->blockQaSubsection($subsection_id, 1, $this->user_id, $this->date);

            if($res_up === true)
            {
                // Изменения сохранены
                $this->session->set_tempdata('message', 10, 60);
            }
            else
            {
                // Изменения не сохранены
                $this->session->set_tempdata('message', 200, 60);
            }
            header('Location: /administration/question-answer/subsection/' . $subsection_id);
        }
        elseif($this->input->post('bt_unblock_subsection', true))
        {
            $res_up = $this->Message_model->blockQaSubsection($subsection_id, 0, $this->user_id, $this->date);

            if($res_up === true)
            {
                // Изменения сохранены
                $this->session->set_tempdata('message', 10, 60);
            }
            else
            {
                // Изменения не сохранены
                $this->session->set_tempdata('message', 200, 60);
            }
            header('Location: /administration/question-answer/subsection/' . $subsection_id);
        }

        // Объединенные данные страница
        $this->page_data['title']        = 'АП - Вопрос - Ответ';
        $this->page_data['page_menu']    = 'question-answer';
        $this->page_data['page_submenu'] = 'qa_sections';
        $this->page_data['page_type']    = 'subsection';

        $this->load->view('header/header_admin', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('question-answer/qa', $result);
        $this->load->view('footer/footer');
    }

    /**
     * Вывод формы добавления статьи Вопрос - Ответ
     */
    public function eQaNewArticle()
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3 or $this->session->user['blocked'] == 1) {
            parent::pageNotFound($this->page_url);
        }

        $sections    = $this->Message_model->getQaSections();
        $subsections = $this->Message_model->getQaSubsections();
        $users_group = $this->Message_model->getQaUsersGroup();
        $result = array_merge($sections, $subsections, $users_group);

        if($this->input->post('bt_save_new_article', true))
        {
            $section_id    = (is_numeric($this->input->post('s_section', true))) ? $this->input->post('s_section', true) : null;
            $subsection    = (!empty($this->input->post('s_subsection', true))) ? $this->input->post('s_subsection', true) : null;
            $subsection_id = (is_numeric($subsection[$section_id])) ? $subsection[$section_id] : null;
            $article_text  = strip_tags($this->input->post('qa_article_text'), '<p><br/><strong><em><img><span>');
            $article_name  = mb_substr(strip_tags($this->input->post('qa_name', true)), 0, 255);

            $cb_ug      = $this->input->post('cb_users_group');
            $user_group = null;
            if(!empty($cb_ug[1]))
            {
                $user_group['insert'] = array(1);
            }
            elseif(!empty($cb_ug))
            {
                $user_group['insert'] = $cb_ug;
            }

            if(!empty($section_id) and !empty($subsection_id) and !empty($article_text) and !empty($user_group) and !empty($article_name))
            {
                $ins_res = $this->Message_model->setNewQaArticle($section_id, $subsection_id, $user_group, $article_name, $article_text, $this->user_id, $this->date);

                if($ins_res !== false and is_numeric($ins_res))
                {
                    // Изменения сохранены
                    $this->session->set_tempdata('message', 10, 60);
                    header('Location: /administration/question-answer/' . $ins_res);
                }
                else
                {
                    // Изменения не сохранены
                    $this->session->set_tempdata('message', 201, 60);
                    header('Location: /administration/question-answer/new');
                }
            }
            else
            {
                // Изменения не сохранены
                $this->session->set_tempdata('message', 201, 60);
                header('Location: /administration/question-answer/new');
            }
        }

        // Объединенные данные страница
        $this->page_data['title']        = 'АП - Вопрос - Ответ';
        $this->page_data['page_menu']    = 'question-answer';
        $this->page_data['page_submenu'] = 'qa_articles';
        $this->page_data['page_type']    = 'new_article';

        $this->load->view('header/header_admin', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('question-answer/qa', $result);
        $this->load->view('footer/footer');
    }

    /**
     * Вывод формы редактирования данных статьи Вопрос - Ответ
     *
     * @param $article_id
     */
    public function eQaArticle($article_id)
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3 or $this->session->user['blocked'] == 1) {
            parent::pageNotFound($this->page_url);
        }

        $sections    = $this->Message_model->getQaSections();
        $subsections = $this->Message_model->getQaSubsections();
        $users_group = $this->Message_model->getQaUsersGroup();
        $count_ug    = count($users_group);
        $article     = $this->Message_model->getQaArticle($article_id, $count_ug);
        $result = array_merge($sections, $subsections, $article, $users_group);

        if($this->input->post('bt_save_article', true))
        {
            $db_data = $article['qa_article'];

            $section_id    = (is_numeric($this->input->post('s_section', true))) ? $this->input->post('s_section', true) : null;
            $subsection    = (!empty($this->input->post('s_subsection', true))) ? $this->input->post('s_subsection', true) : null;
            $subsection_id = (is_numeric($subsection[$section_id])) ? $subsection[$section_id] : null;
            $article_text  = strip_tags($this->input->post('qa_article_text'), '<p><br/><strong><em><img><span>');
            $article_name  = mb_substr(strip_tags($this->input->post('qa_name', true)), 0, 255);

            $cb_ug      = $this->input->post('cb_users_group');
            $user_group = null;
            if(!empty($cb_ug[1]))
            {
                $user_group = array(1);
            }
            elseif(!empty($cb_ug))
            {
                $user_group = $cb_ug;
            }
            // Сравнение с БД
            $save_ug['insert'] = array_diff($user_group, $db_data['users_group']);
            $save_ug['delete'] = array_diff($db_data['users_group'], $user_group);

            if(!empty($section_id) and !empty($subsection_id) and !empty($article_text) and !empty($save_ug) and !empty($article_name))
            {
                $res_up = $this->Message_model->setQaArticle($article_id, $section_id, $subsection_id, $save_ug, $article_name, $article_text, $this->user_id, $this->date);

                if($res_up === true)
                {
                    // Изменения сохранены
                    $this->session->set_tempdata('message', 10, 60);
                }
                else
                {
                    // Изменения не сохранены
                    $this->session->set_tempdata('message', 201, 60);
                }
            }
            else
            {
                // Изменения не сохранены
                $this->session->set_tempdata('message', 201, 60);
            }
            header('Location: /administration/question-answer/'.$article_id);
        }
        elseif($this->input->post('bt_block_article', true))
        {
            $res_up = $this->Message_model->blockQaArticle($article_id, 1, $this->user_id, $this->date);

            if($res_up === true)
            {
                // Изменения сохранены
                $this->session->set_tempdata('message', 10, 60);
            }
            else
            {
                // Изменения не сохранены
                $this->session->set_tempdata('message', 201, 60);
            }
            header('Location: /administration/question-answer/' . $article_id);
        }
        elseif($this->input->post('bt_unblock_article', true))
        {
            $res_up = $this->Message_model->blockQaArticle($article_id, 0, $this->user_id, $this->date);

            if($res_up === true)
            {
                // Изменения сохранены
                $this->session->set_tempdata('message', 10, 60);
            }
            else
            {
                // Изменения не сохранены
                $this->session->set_tempdata('message', 201, 60);
            }
            header('Location: /administration/question-answer/' . $article_id);
        }

        // Объединенные данные страница
        $this->page_data['title']        = 'АП - Вопрос - Ответ';
        $this->page_data['page_menu']    = 'question-answer';
        $this->page_data['page_submenu'] = 'qa_articles';
        $this->page_data['page_type']    = 'article';

        $this->load->view('header/header_admin', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('question-answer/qa', $result);
        $this->load->view('footer/footer');
    }

    /**
     * AJAX Загрузка изображений статьи
     */
    public function eQaUploadImage()
    {
        reset ($_FILES);
        $temp = current($_FILES);
        $_FILES['qa_file'] = $temp;
        //log_message('debug', print_r($temp, true));
        // Загрузка изображения на сервер
        if(is_uploaded_file($_FILES['qa_file']['tmp_name']))
        {
            $path = './qa_images/';
            $this->load->helper('file');

            $path_image = parent::uploadImage('qa_file', $temp['type'], $path);
            $full_path = $path.$path_image;
            if(file_exists($path.$path_image))
            {
                if ($this->security->xss_clean($full_path, TRUE) === FALSE)
                {
                    unlink($full_path);
                }
                else
                {
                    echo json_encode(array('location' => $path_image));
                }
            }
        }
    }

    /**
     * Вывод разделов и подразделов Вопрос - Ответ
     *
     * @return void
     */
    public function QaSections()
    {
        $users_types = array('user' => 1, 'couch' => 2, 'admin' => 3);
        $user_type = (!empty($this->session->user['type'])) ? array_search($this->session->user['type'], $users_types) : 'general';
        $result = $this->Message_model->getPublicQaSections($user_type);
        $result_search = false;

        if($this->input->post('bt_support_search', true))
        {
            $search = strip_tags($this->input->post('search', true));

            if(!empty($search))
            {
                $res_sel = $this->Message_model->getPublicQaArticles($search, $user_type);
                if($res_sel !== false)
                {
                    $result_search = true;
                    $result = $res_sel;
                }
            }
        }

        // Объединенные данные страница
        $this->page_data['title']         = $this->page_data['metadata'][12]['title'];
        $this->page_data['keywords']      = $this->page_data['metadata'][12]['keywords'];
        $this->page_data['description']   = $this->page_data['metadata'][12]['description'];
        $this->page_data['page_menu']     = 'question-answer';
        $this->page_data['page_submenu']  = 'sections';
        $this->page_data['result_search'] = $result_search;
        $this->page_data['search']        = (!empty($search)) ? $search : '';

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/secondary');
        $this->load->view('question-answer/public_qa', $result);
        $this->load->view('footer/footer');
    }

    /**
     * Вывод разделов и подразделов Вопрос - Ответ
     *
     * @param $section_id
     * @param $subsection_id
     * @return void
     */
    public function QaSection($section_id, $subsection_id)
    {
        $result = array();
        $users_types = array('user' => 1, 'couch' => 2, 'admin' => 3);
        $user_type = (!empty($this->session->user['type'])) ? array_search($this->session->user['type'], $users_types) : 'general';

        if(is_numeric($section_id) and empty($subsection_id))
        {
            $result = $this->Message_model->getPublicQaSection($section_id, $user_type);
        }
        elseif(is_numeric($section_id) and is_numeric($subsection_id))
        {
            $section    = $this->Message_model->getPublicQaSection($section_id, $user_type);
            $subsection = $this->Message_model->getPublicQaSubsection($section_id, $subsection_id, $user_type);
            $articles   = $this->Message_model->getPublicQaSubsectionArticles($section_id, $subsection_id, $user_type);
            $result     = array_merge($section, $subsection, $articles);
        }
        else
        {
            parent::pageNotFound($this->page_url);
        }

        // Объединенные данные страница
        $this->page_data['title']        = $this->page_data['metadata'][12]['title'];
        $this->page_data['keywords']     = $this->page_data['metadata'][12]['keywords'];
        $this->page_data['description']  = $this->page_data['metadata'][12]['description'];
        $this->page_data['page_menu']    = 'question-answer';
        $this->page_data['page_submenu'] = 'section';

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/secondary');
        $this->load->view('question-answer/public_qa', $result);
        $this->load->view('footer/footer');
    }

    /**
     * Вывод статьи Вопрос - Ответ
     *
     * @param $section_id
     * @param $subsection_id
     * @param $article_id
     * @return void
     */
    public function QaArticle($section_id, $subsection_id, $article_id)
    {
        $result = array();
        $users_types = array('user' => 1, 'couch' => 2, 'admin' => 3);
        $user_type = (!empty($this->session->user['type'])) ? array_search($this->session->user['type'], $users_types) : 'general';

        if(is_numeric($section_id) and is_numeric($subsection_id) and is_numeric($article_id))
        {
            $section    = $this->Message_model->getPublicQaSection($section_id, $user_type);
            $subsection = $this->Message_model->getPublicQaSubsection($section_id, $subsection_id, $user_type);
            $article    = $this->Message_model->getPublicQaArticle($section_id, $subsection_id, $article_id, $user_type);
            $result     = array_merge($section, $subsection, $article);
        }
        else
        {
            parent::pageNotFound($this->page_url);
        }

        // Объединенные данные страница
        $this->page_data['title']        = $this->page_data['metadata'][12]['title'];
        $this->page_data['keywords']     = $this->page_data['metadata'][12]['keywords'];
        $this->page_data['description']  = $this->page_data['metadata'][12]['description'];
        $this->page_data['page_menu']    = 'question-answer';
        $this->page_data['page_submenu'] = 'article';

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/secondary');
        $this->load->view('question-answer/public_qa', $result);
        $this->load->view('footer/footer');
    }
}