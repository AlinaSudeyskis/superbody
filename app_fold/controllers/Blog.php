<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Blog
 * 
 * Класс для работы с записями и комментариями блога
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
     * АП. Список записей блога
     *
     * @return void
     */
    public function blogPosts()
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3 or $this->session->user['blocked'] == 1) {
            parent::pageNotFound($this->page_url);
        }

        // Объединенные данные страница
        $this->page_data['title']        = 'АП - Записи блога';
        $this->page_data['page_menu']    = 'a_blog';
        $this->page_data['page_submenu'] = 'blog_posts';

        $result = $this->Blog_model->getBlogsPosts();

        $this->load->view('header/header_admin', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('blog/blog_posts', $result);
        $this->load->view('footer/footer');
    }

    /**
     * АП. Запись блога
     *
     * Одобрение или блокировка записи администрацией
     *
     * @param $post_id
     * @return void
     */
    public function blogPost($post_id)
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3 or $this->session->user['blocked'] == 1) {
            parent::pageNotFound($this->page_url);
        }

        $result = $this->Blog_model->getBlogPost($post_id);

        if($this->input->post('bt_save_post', true))
        {
            $db_post = $result['post'];

            $post_title    = $db_post['title'];
            $post_desc     = $db_post['short_desc'];
            $post_text     = $db_post['text'];
            $post_keywords = $db_post['keywords'];

            extract(self::parsePostData($this->input->post()));

            if($db_post['title'] != $post_title or $db_post['short_desc'] != $post_desc or $db_post['text'] != $post_text or $db_post['keywords'] != $post_keywords)
            {
                $res_up = $this->Blog_model->updateBlogPost($post_id, $post_title, $post_desc, $post_keywords, $post_text, $this->date);

                if ($res_up === true)
                {
                    // Сохранено
                    $this->session->set_tempdata('message', 10, 60);
                }
                else
                {
                    // Не сохранено
                    $this->session->set_tempdata('message', 127, 60);
                }
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
            $res_up = $this->Blog_model->approvalBlogPost($post_id, $this->date);

            if ($res_up === true)
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
            $res_up = $this->Blog_model->blockBlogPost($post_id, $this->date);

            if ($res_up === true)
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
        elseif ($this->input->post('bt_delete_post', true))
        {
            $res_up = $this->Blog_model->deleteBlogPost($post_id);

            if ($res_up === true)
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
        }
        
        // Объединенные данные страница
        $this->page_data['title']        = 'АП - Редактирование данных сообщения блога';
        $this->page_data['page_menu']    = 'a_blog';
        $this->page_data['page_submenu'] = 'blog_posts';


        $this->load->view('header/header_admin', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('blog/blog_post', $result);
        $this->load->view('footer/footer');
    }

    /**
     * АП. Комментарии блога
     *
     * Вывод списка комментариев блога для одобрения или блокирования администрацией
     *
     * @return void
     */
    public function blogComments()
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3 or $this->session->user['blocked'] == 1) {
            parent::pageNotFound($this->page_url);
        }

        // Объединенные данные страница
        $this->page_data['title']        = 'АП - Комментарии блога';
        $this->page_data['page_menu']    = 'a_blog';
        $this->page_data['page_submenu'] = 'blog_comments';
        
        $result = $this->Blog_model->getBlogsComments();

        $this->load->view('header/header_admin', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('blog/comments', $result);
        $this->load->view('footer/footer');
    }

    /**
     * АП. Комментарий блога.
     *
     * Одобрение или блокировка комментария администрацией
     *
     * @param $comment_id
     * @return void
     */
    public function blogComment($comment_id)
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3 or $this->session->user['blocked'] == 1) {
            parent::pageNotFound($this->page_url);
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
        $this->page_data['title']        = 'АП - Редактирование данных комментария блога';
        $this->page_data['page_menu']    = 'a_blog';
        $this->page_data['page_submenu'] = 'blog_comments';
        
        $result = $this->Blog_model->getBlogComment($comment_id);

        $this->load->view('header/header_admin', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('blog/comment', $result);
        $this->load->view('footer/footer');
    }


    /**
     * Записи блога тренера
     */
    public function getCoachPosts()
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 2 or $this->session->user['blocked'] == 1)
        {
            parent::pageNotFound($this->page_url);
        }

        $this->load->model('Coach_model');

        // Объединенные данные страница
        $this->page_data['title'] = 'Блог';
        $this->page_data['page_menu'] = 'blog';

        $c_data = $this->Coach_model->getCoach($this->user_id, $this->date);
        $posts  = $this->Blog_model->getCoachBlogPosts($this->user_id);
        $result = array_merge($posts, $c_data);

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/profile');
        $this->load->view('user/profile_line');
        $this->load->view('blog/user_posts', $result);
        $this->load->view('footer/footer');
    }

    /**
     * Запись блога тренера
     *
     * @param $post_id
     */
    public function getCoachPost($post_id)
    {
        if (empty($this->user_id) or $this->session->user['type'] != 2 or $this->session->user['blocked'] == 1)
        {
            parent::pageNotFound($this->page_url);
        }

        $result = $this->Blog_model->getCoachBlogPost($this->user_id, $post_id);

        if($this->input->post('bt_save_post', true))
        {
            $db_post = $result['post'];

            $post_title    = $db_post['title'];
            $post_desc     = $db_post['short_desc'];
            $post_text     = $db_post['text'];
            $post_keywords = $db_post['keywords'];

            extract(self::parsePostData($this->input->post()));

            if($db_post['title'] != $post_title or $db_post['short_desc'] != $post_desc or $db_post['text'] != $post_text or $db_post['keywords'] != $post_keywords)
            {
                $result = $this->Blog_model->updateCoachBlogPost($this->user_id, $post_id, $post_title, $post_desc, $post_keywords, $post_text, $this->date);

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

        // Объединенные данные страница
        $this->page_data['title'] = 'Блог тренера';
        $this->page_data['page_menu'] = 'blog';

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/profile');
        $this->load->view('user/profile_line');
        $this->load->view('blog/user_post', $result);
        $this->load->view('footer/footer');
    }

    /**
     * Форма добавления записи блога тренером
     */
    public function newCoachPost()
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 2 or $this->session->user['blocked'] == 1)
        {
            parent::pageNotFound($this->page_url);
        }

        if ($this->input->post('bt_save_post', true))
        {
            $post_title = '';
            $post_desc  = '';
            $post_text  = '';

            extract(self::parsePostData($this->input->post()));

            if(!empty($post_title) and !empty($post_text))
            {
                $result = $this->Blog_model->setBlogPost($this->user_id, $post_title, $post_desc, $post_text, $this->date);

                if ($result !== false)
                {
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
            else
            {
                header('Location: /post/new');
            }
        }

        // Объединенные данные страница
        $this->page_data['title'] = 'Добавление записи блога';
        $this->page_data['page_menu'] = 'blog';

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/profile');
        $this->load->view('user/profile_line');
        $this->load->view('blog/new_post');
        $this->load->view('footer/footer');
    }

    /**
     * AJAX Загрузка изображений статьи
     */
    public function postUploadImage()
    {
        reset ($_FILES);
        $temp = current($_FILES);
        $_FILES['post_file'] = $temp;
        //log_message('debug', print_r($temp, true));
        // Загрузка изображения на сервер
        if(is_uploaded_file($_FILES['post_file']['tmp_name']))
        {
            $path = './post_images/';
            $this->load->helper('file');

            $path_image = parent::uploadImage('post_file', $temp['type'], $path);
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

    public function getPublicPosts()
    {
        $this->load->model('Coach_model');

        $result = $this->Blog_model->getPublicBlogPosts();

        // Объединенные данные страница
        $this->page_data['title']     = 'Блог';
        $this->page_data['page_menu'] = 'blog';

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/profile');
        $this->load->view('user/profile_line');
        $this->load->view('blog/posts', $result);
        $this->load->view('footer/footer');
    }

    /**
     * Общедоступная запись блога
     *
     * @param $post_id
     */
    public function getPublicPost($post_id)
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

        $this->load->model('Coach_model');

        $post   = $this->Blog_model->getPublicBlogPost($post_id);
        $user   = $this->Coach_model->getCoach($post['post']['user']['id'], $this->date);
        $result = array_merge($post, $user);

        // Объединенные данные страница
        $this->page_data['title']       = (!empty($post['post']['title'])) ? $post['post']['title'] : 'Блог тренера';
        $this->page_data['description'] = (!empty($post['post']['short_desc'])) ? $post['post']['short_desc'] : '';
        $this->page_data['keywords']    = (!empty($post['post']['keywords'])) ? $post['post']['keywords'] : '';
        $this->page_data['page_menu']   = 'blog';

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/profile');
        $this->load->view('user/profile_line');
        $this->load->view('blog/post', $result);
        $this->load->view('footer/footer');
    }

    /**
     * Обработка данных формы блога тренера
     *
     * @param $form
     * @return mixed
     */
    protected function parsePostData($form)
    {
        $result['post_title']    = mb_substr(strip_tags($form['post_title']), 0, 100);
        $result['post_desc']     = mb_substr(strip_tags($form['post_short_desc']), 0, 255);
        $result['post_keywords'] = mb_substr(strip_tags($form['post_keywords']), 0, 1000);
        $post_text = mb_substr(strip_tags($form['post_text'], '<b><div><i><p><br/><strong><em><img><span><a><ol><ul><li>'), 0, 1000000);
        $post_text = preg_replace("/<p[^>]*>[\s|&nbsp;]*<\/p>/", '', $post_text);
        $post_text = preg_replace('/ {2,}/',' ', $post_text);
        $post_text = trim(preg_replace('~(?:\r?\n)+~','', $post_text));
        $result['post_text']  = parent::closetags($post_text);

        return $result;
    }
}