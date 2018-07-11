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
}