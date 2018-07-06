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
     * Записи блога
     *
     * Вывод списка комментариев блога для одобрения или блокирования администрацией
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
        $this->page_data['title']        = 'АП - Сообщения блогов';
        $this->page_data['page_menu']    = 'blog';
        $this->page_data['page_submenu'] = 'blog_posts';

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
        if (empty($this->user_id) or $this->session->user['type'] != 3 or $this->session->user['blocked'] == 1) {
            parent::pageNotFound($this->page_url);
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
        $this->page_data['title']        = 'АП - Редактирование данных сообщения блога';
        $this->page_data['page_menu']    = 'blog';
        $this->page_data['page_submenu'] = 'blog_posts';
        
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
        if (empty($this->user_id) or $this->session->user['type'] != 3 or $this->session->user['blocked'] == 1) {
            parent::pageNotFound($this->page_url);
        }

        // Объединенные данные страница
        $this->page_data['title']        = 'АП - Комментарии блогов';
        $this->page_data['page_menu']    = 'blog';
        $this->page_data['page_submenu'] = 'blog_comments';
        
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
        $this->page_data['page_menu']    = 'blog';
        $this->page_data['page_submenu'] = 'blog_comments';
        
        $result = $this->Blog_model->getBlogComment($comment_id);

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('blog/posts/comment', $result);
        $this->load->view('footer/footer');
    }


    /**
     * Записи блога тренера
     */
    public function getCouchPosts()
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 2 or $this->session->user['blocked'] == 1)
        {
            parent::pageNotFound($this->page_url);
        }

        $this->load->model('Couch_model');

        // Объединенные данные страница
        $this->page_data['title'] = 'Блог';
        $this->page_data['page_menu'] = 'blog';

        $c_data = $this->Couch_model->getCouch($this->user_id, $this->date);
        $posts  = $this->Blog_model->getCouchBlogPosts($this->user_id);
        $result = array_merge($posts, $c_data);

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
        if (empty($this->user_id) or $this->session->user['type'] != 2 or $this->session->user['blocked'] == 1)
        {
            parent::pageNotFound($this->page_url);
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
        if (empty($this->user_id) or $this->session->user['type'] != 2 or $this->session->user['blocked'] == 1)
        {
            parent::pageNotFound($this->page_url);
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