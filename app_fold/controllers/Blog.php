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

        $post = $this->Blog_model->getBlogPost($post_id);
        $categories = $this->Blog_model->getBlogsCategories();
        $result = array_merge($post, $categories);

        if($this->input->post('bt_save_post', true))
        {
            $db_post = $result['post'];

            self::parsePostFormData($post_id, $db_post);

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
     * АП. Категории блога
     *
     * Вывод списка категорий блога
     *
     * @return void
     */
    public function blogCategories()
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3 or $this->session->user['blocked'] == 1) {
            parent::pageNotFound($this->page_url);
        }

        // Объединенные данные страница
        $this->page_data['title']        = 'АП - Категории блога';
        $this->page_data['page_menu']    = 'a_blog';
        $this->page_data['page_submenu'] = 'blog_categories';

        $result = $this->Blog_model->getBlogsCategories();

        $this->load->view('header/header_admin', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('blog/categories', $result);
        $this->load->view('footer/footer');
    }

    /**
     * АП. Категория блога.
     *
     * @param $category_id
     * @return void
     */
    public function blogCategory($category_id)
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3 or $this->session->user['blocked'] == 1) {
            parent::pageNotFound($this->page_url);
        }

        $result = $this->Blog_model->getBlogCategory($category_id);

        if($this->input->post('bt_save_category_settings', true))
        {
            $name = mb_substr($this->input->post('name', true), 0, 255);
            $category_image = '';

            // Сохранение изображения
            $img_path = './post_images/';

            if (is_uploaded_file($_FILES['i_blog_category_image']['tmp_name'])) {
                $image = parent::uploadImage('i_blog_category_image', $_FILES['i_blog_category_image']['type'], $img_path);
                $full_path_img = $img_path . $image;
                if (file_exists($full_path_img)) {
                    if ($this->security->xss_clean($full_path_img, TRUE) !== FALSE) {
                        $category_image = $full_path_img;
                    } else {
                        unlink($full_path_img);
                    }
                }
            }

            if(!empty($name) and ($name != $result['blog_category']['name'] or $category_image != $result['blog_category']['image']))
            {
                $res_up = $this->Blog_model->updateBlogCategory($category_id, $name, $category_image, $this->user_id, $this->date);

                if($res_up === true)
                {
                    $this->session->set_tempdata('message', 10, 60);
                }
                else
                {
                    $this->session->set_tempdata('message', 63, 60);
                }
            }

            header('Location: /administration/blog/category/'.$category_id);
        }

        // Объединенные данные страница
        $this->page_data['title']        = 'АП - Редактирование данных категории блога';
        $this->page_data['page_menu']    = 'a_blog';
        $this->page_data['page_submenu'] = 'blog_categories';


        $this->load->view('header/header_admin', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('blog/category_settings', $result);
        $this->load->view('footer/footer');
    }

    /**
     * АП. Форма добавления категории блога.
     *
     * @return void
     */
    public function newBlogCategory()
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3 or $this->session->user['blocked'] == 1) {
            parent::pageNotFound($this->page_url);
        }

        if($this->input->post('bt_save_new_category', true))
        {
            $name = mb_substr($this->input->post('name', true), 0, 255);
            $category_image = '';

            // Сохранение изображения
            $img_path = './post_images/';

            if (is_uploaded_file($_FILES['i_blog_category_image']['tmp_name'])) {
                $image = parent::uploadImage('i_blog_category_image', $_FILES['i_blog_category_image']['type'], $img_path);
                $full_path_img = $img_path . $image;
                if (file_exists($full_path_img)) {
                    if ($this->security->xss_clean($full_path_img, TRUE) !== FALSE) {
                        $category_image = $full_path_img;
                    } else {
                        unlink($full_path_img);
                    }
                }
            }

            if(!empty($name))
            {
                $res_ins = $this->Blog_model->setNewBlogCategory($name, $category_image, $this->user_id, $this->date);

                if($res_ins !== false and is_numeric($res_ins))
                {
                    $this->session->set_tempdata('message', 10, 60);

                    header('Location: /administration/blog/category/'.$res_ins);
                }
                else
                {
                    $this->session->set_tempdata('message', 63, 60);

                    header('Location: /administration/blog/category/new');
                }
            }
            else
            {
                $this->session->set_tempdata('message', 62, 60);

                header('Location: /administration/blog/category/new');
            }
        }

        // Объединенные данные страница
        $this->page_data['title']        = 'АП - Форма добавления категории блога';
        $this->page_data['page_menu']    = 'a_blog';
        $this->page_data['page_submenu'] = 'blog_categories';

        $this->load->view('header/header_admin', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('blog/category_new');
        $this->load->view('footer/footer');
    }

    /**
     * АП. Сохранение данных кода "Поделиться в соцсетях"
     */
    public function blogShare()
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3 or $this->session->user['blocked'] == 1) {
            parent::pageNotFound($this->page_url);
        }

        $result = $this->Blog_model->getBlogShare();

        if($this->input->post('bt_save_share', true))
        {
            $share_top = mb_substr($this->input->post('ta_share_top'), 0, 2000);
            $share_bottom = mb_substr($this->input->post('ta_share_bottom'), 0, 2000);

            if($share_top !== $result['blog_share_top'] or $share_bottom !== $result['blog_share_bottom'])
            {
                $res_up = $this->Blog_model->updateBlogShare($share_top, $share_bottom, $this->user_id, $this->date);

                if($res_up === true)
                {
                    $this->session->set_tempdata('message', 10, 60);
                }
                else
                {
                    $this->session->set_tempdata('message', 9, 60);
                }
            }

            header('Location: /administration/blog/share');
        }

        // Объединенные данные страница
        $this->page_data['title']        = 'АП - Форма редактирования кода "Поделиться в соц сетях"';
        $this->page_data['page_menu']    = 'a_blog';
        $this->page_data['page_submenu'] = 'blog_share';

        $this->load->view('header/header_admin', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('blog/share', $result);
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
        $this->page_data['title']     = 'Блог';
        $this->page_data['page_menu'] = 'c_blog';

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

        $post = $this->Blog_model->getCoachBlogPost($this->user_id, $post_id);
        $categories = $this->Blog_model->getBlogsCategories();
        $result = array_merge($post, $categories);

        if($this->input->post('bt_save_post', true))
        {
            $db_post = $result['post'];

            self::parsePostFormData($post_id, $db_post);

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
        $this->page_data['title']     = 'Блог тренера';
        $this->page_data['page_menu'] = 'c_blog';

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/profile');
        $this->load->view('user/profile_line');
        $this->load->view('blog/user_post', $result);
        $this->load->view('footer/footer');
    }

    /**
     * Обработка сохранения данных записи блога
     *
     * @param $post_id
     * @param $db_post
     */
    protected function parsePostFormData($post_id, $db_post)
    {
        $post_title       = $db_post['title'];
        $post_desc        = $db_post['short_desc'];
        $post_video_type  = $db_post['video_type'];
        $post_video       = $db_post['video'];
        $post_text        = $db_post['text'];
        $post_keywords    = $db_post['keywords'];
        $post_category_id = $db_post['category_id'];
        $post_poster_type = $db_post['poster_type'];
        $post_poster      = $db_post['poster'];
        $post_courses     = $db_post['attached_courses'];

        extract(self::parsePostData($this->input->post()));

        $delete_courses = (is_array($db_post['attached_courses']) and is_array($post_courses)) ? array_diff($db_post['attached_courses'], $post_courses) : array();
        $insert_courses = array();
        if(!empty($db_post['attached_courses']) and is_array($db_post['attached_courses']) and is_array($post_courses))
        {
            $insert_courses = array_diff($post_courses, $db_post['attached_courses']);
        }
        elseif(empty($db_post['attached_courses']) and !empty($post_courses) and is_array($post_courses))
        {
            $insert_courses = $post_courses;
        }

        if($db_post['title'] != $post_title or $db_post['short_desc'] != $post_desc or $db_post['text'] != $post_text
            or $db_post['keywords'] != $post_keywords or $db_post['category_id'] != $post_category_id
            or $db_post['poster_type'] != $post_poster_type or $db_post['poster'] != $post_poster
            or $db_post['video_type'] != $post_video_type or $db_post['video'] != $post_video
            or !empty($delete_courses) or !empty($insert_courses))
        {
            $res_up = $this->Blog_model->updateBlogPost($post_id, $post_category_id, $post_poster_type, $post_poster,
                $post_video_type, $post_video, $post_title, $post_desc, $post_keywords, $post_text, $delete_courses, $insert_courses, $this->date);

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

        $result = $this->Blog_model->getBlogsCategories();

        if ($this->input->post('bt_save_post', true))
        {
            $post_title       = '';
            $post_desc        = '';
            $post_text        = '';
            $post_keywords    = '';
            $post_category_id = '';
            $post_poster_type = '';
            $post_poster      = '';
            $delete_courses   = array();
            $insert_courses   = array();
            $post_video_type  = '';
            $post_video       = '';

            extract(self::parsePostData($this->input->post()));

            $insert_courses = $post_courses;

            if(!empty($post_title) and !empty($post_text))
            {
                $result = $this->Blog_model->setBlogPost($post_category_id, $this->user_id, $post_poster_type, $post_poster,
                    $post_video_type, $post_video, $post_title, $post_desc, $post_keywords, $post_text, $delete_courses, $insert_courses, $this->date);

                if ($result !== false and is_numeric($result))
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
        $this->page_data['title']     = 'Добавление записи блога';
        $this->page_data['page_menu'] = 'c_blog';

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/profile');
        $this->load->view('user/profile_line');
        $this->load->view('blog/new_post', $result);
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

    /**
     * Записи блога сгруппированные по категориям
     */
    public function getPublicPosts()
    {
        $this->load->model('Coach_model');

        $categories = $this->Blog_model->getBlogsCategories();
        $posts = $this->Blog_model->getPublicBlogPosts();
        $result = array_merge($categories, $posts);

        // Объединенные данные страница
        $this->page_data['title']       = $this->page_data['metadata'][14]['title'];
        $this->page_data['keywords']    = $this->page_data['metadata'][14]['keywords'];
        $this->page_data['description'] = $this->page_data['metadata'][14]['description'];
        $this->page_data['page_menu']   = 'blog';

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/secondary');
        $this->load->view('blog/posts', $result);
        $this->load->view('footer/footer');
    }

    /**
     * Записи блога определенной категории
     *
     * @param $category_id
     */
    public function getPublicCategoryPosts($category_id)
    {
        $this->load->model('Coach_model');

        $category_id = (is_numeric($category_id)) ? $category_id : null;

        $categories = $this->Blog_model->getBlogsCategories();
        $posts = $this->Blog_model->getPublicBlogPosts($category_id);
        $result = array_merge($categories, $posts);

        // Объединенные данные страница
        $this->page_data['title']       = $this->page_data['metadata'][14]['title'];
        $this->page_data['keywords']    = $this->page_data['metadata'][14]['keywords'];
        $this->page_data['description'] = $this->page_data['metadata'][14]['description'];
        $this->page_data['page_menu']   = 'blog';
        $this->page_data['category_id'] = $category_id;

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/secondary');
        $this->load->view('blog/posts', $result);
        $this->load->view('footer/footer');
    }

    /**
     * AJAX Вывод записей блога
     */
    public function getSortPosts()
    {
        $posts_category = (is_numeric($this->input->post('category_id', true))) ? $this->input->post('category_id', true) : null;

        $first_id = ($this->input->post('first_id', true) and is_numeric($this->input->post('first_id', true)))
            ? $this->input->post('first_id', true)
            : null;
        $last_id = ($this->input->post('last_id', true) and is_numeric($this->input->post('last_id', true)))
            ? $this->input->post('last_id', true)
            : null;

        $result['posts']      = '';
        $result['pagination'] = '';
        $result['sql']        = '';
        $result['sql_result'] = '';

        $result_posts = $this->Blog_model->getPublicBlogPosts($posts_category, $first_id, $last_id);

        if (!empty($result_posts['posts'][$posts_category]))
        {
            foreach ($result_posts['posts'][$posts_category] as $post)
            {
                ob_start();
                include('./app_fold/views/blog/posts_item.php');
                $post_item = ob_get_contents();
                ob_end_clean();
                $result['posts'] .= $post_item;
            }
            unset($post);

            $category_id = $posts_category;
            $pagination = $result_posts['pagination'];
            ob_start();
            include_once('./app_fold/views/pagination.php');
            $pagination = ob_get_contents();
            ob_end_clean();

            $result['pagination'] = $pagination;
        }
        else
        {
            $result['posts'] = "false";
        }

        //echo $result;
        echo json_encode($result, JSON_NUMERIC_CHECK);
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
        $attached_courses = (!empty($post['post']['attached_courses_id'])) ? $this->Course_model->getPublicCoursesByIds($post['post']['attached_courses_id']) : array();
        $post['post']['attached_courses'] = $attached_courses['courses'];
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
        $result['post_text'] = parent::closetags($post_text);
        $result['post_video_type'] = $form['s_blog_video_type'];
        $result['post_video']      = mb_substr(strip_tags($form['video_remote_url']), 0, 255);

        $result['post_category_id'] = (is_numeric($form['s_post_category'])) ? $form['s_post_category'] : 0;

        if($form['s_blog_poster_type'] == 'vimeo' or $form['s_blog_poster_type'] == 'youtube')
        {
            $result['post_poster_type'] = $form['s_blog_poster_type'];
            $result['post_poster']      = mb_substr(strip_tags($form['remote_url']), 0, 255);
        }
        elseif($form['s_blog_poster_type'] == 'image')
        {
            $result['post_poster_type'] = $form['s_blog_poster_type'];

            // Сохранение изображения
            $img_path = './post_images/';

            if (is_uploaded_file($_FILES['poster_file']['tmp_name'])) {
                $image = parent::uploadImage('poster_file', $_FILES['poster_file']['type'], $img_path);
                $full_path_img = $img_path . $image;
                if (file_exists($full_path_img)) {
                    if ($this->security->xss_clean($full_path_img, TRUE) !== FALSE) {
                        $result['post_poster'] = $full_path_img;
                    } else {
                        unlink($full_path_img);
                    }
                }
            }
        }

        if(!empty($form['pc_courses']))
        {
            $i = 0;
            foreach($form['pc_courses'] as $crs_id)
            {
                if(is_numeric($crs_id))
                {
                    $result['post_courses'][$i] = $crs_id;

                    $i++;
                }
            }
        }

        return $result;
    }
}