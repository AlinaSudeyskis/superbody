<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Класс Journal
 *
 * Класс вывода данных статей, интервью, новостей
 *
 * @author Alina Sudeyskis <alina.sudeyskis@gmail.com>
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Journal extends CI_Controller
{
    public $journal_menu;

    /**
     * Journal constructor.
     */
    public function __construct()
    {
        parent::__construct();

        parent::pageNotFound($this->page_url);

        $this->load->model('Journal_model');
        $this->journal_menu = array('articles', 'interviews', 'news_list');
    }

    /**
     * Форма добавления и сохранение статей, интервью или новостей
     */
    public function journalNew()
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3 or $this->session->user['blocked'] == 1) {
            parent::pageNotFound($this->page_url);
        }

        if ($this->input->post('bt_save_new_post', true)) {
            $type       = is_numeric($this->input->post('journal_cat', true)) ? $this->input->post('journal_cat', true) : 1;
            $name       = mb_substr(strip_tags($this->input->post('name')), 0, 255);
            $short_desc = mb_substr(strip_tags($this->input->post('short_desc')), 0, 255);
            $full_desc  = mb_substr(strip_tags($this->input->post('full_desc')), 0, 15000);
            $author     = mb_substr(strip_tags($this->input->post('author')), 0, 255);
            $source     = mb_substr(strip_tags($this->input->post('source')), 0, 255);
            $images     = !empty($this->input->post('images', true)) ? implode(';', $this->input->post('images', true)) : '';

            if (!empty($name) and !empty($short_desc) and !empty($full_desc)) {
                $result = $this->Journal_model->setNewJournalPost($type, $name, $images, $short_desc, $full_desc, $author,
                    $source, $this->date, $this->user_id);

                if ($result === true) {
                    // Сохранено
                    $this->session->set_tempdata('message', 10, 60);
                } else {
                    // Не сохранено
                    $this->session->set_tempdata('message', 58, 60);
                }
            } else {
                // Не все поля заполнены
                $this->session->set_tempdata('message', 61, 60);
            }

            header('Location: /administration/journal/new');
        }

        // Объединенные данные страница
        $this->page_data['title'] = 'АП - Журнал - Новая запись';
        $this->page_data['page_menu'] = 'a_journal';

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('journal/new_post');
        $this->load->view('footer/footer');
    }

    /**
     * Форма редактирования и сохранение записей журнала
     *
     * @param $post_id
     */
    public function journalPost($post_id)
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3 or $this->session->user['blocked'] == 1) {
            parent::pageNotFound($this->page_url);
        }

        $result = $this->Journal_model->getJournalPost($post_id);

        if ($this->input->post('bt_save_post', true)) {
            $category   = $this->input->post('journal_cat', true == '');
            $type       = (is_numeric($category)) ? $category : 1;
            $name       = mb_substr(strip_tags($this->input->post('name')), 0, 255);
            $short_desc = mb_substr(strip_tags($this->input->post('short_desc')), 0, 255);
            $full_desc  = mb_substr(strip_tags($this->input->post('full_desc'), '<p><br/>'), 0, 15000);
            $author     = mb_substr(strip_tags($this->input->post('author')), 0, 255);
            $source     = mb_substr(strip_tags($this->input->post('source')), 0, 255);
            $images     = !empty($this->input->post('images', true)) ? implode(';', $this->input->post('images', true)) : '';

            //echo $full_desc.'<br/>';
            if (!empty($name) and !empty($short_desc) and !empty($full_desc)) {
                $result = $this->Journal_model->setJournalPost($post_id, $type, $name, $images, $short_desc, $full_desc, $author,
                    $source, $this->date, $this->user_id);

                if ($result === true) {
                    // Сохранено
                    $this->session->set_tempdata('message', 10, 60);
                } else {
                    // Не сохранено
                    $this->session->set_tempdata('message', 58, 60);
                }
            } else {
                // Не все поля заполнены
                $this->session->set_tempdata('message', 61, 60);
            }

            header('Location: /administration/journal/'.$post_id);
        }

        // Объединенные данные страница
        $this->page_data['title'] = 'АП - Журнал - Редактировать запись';
        $this->page_data['page_menu'] = 'a_journal';

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('journal/post_settings', $result);
        $this->load->view('footer/footer');
    }

    /**
     * Вывод последних статей
     *
     * @param string $type
     * @return void
     */
    public function journalPosts($type = 'articles')
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3 or $this->session->user['blocked'] == 1) {
            parent::pageNotFound($this->page_url);
        }

        if ($type == 'articles') {
            $type_id = 1;
        }
        elseif ($type == 'interviews') {
            $type_id = 2;
        }
        elseif ($type == 'news') {
            $type_id = 3;
        }
        else {
            $type_id = 1;
        }

        $result = $this->Journal_model->getJournalPosts($type_id);

        // Объединенные данные страница
        $this->page_data['title'] = 'АП - Журнал - Статьи';
        $this->page_data['page_menu'] = 'a_journal';
        $this->page_data['page_submenu'] = 'articles';

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/admin');

        if ($type_id == 1) {
            $this->load->view('journal/article/e_articles', $result);
        }
        elseif ($type_id == 2) {
            $this->load->view('journal/interview/e_interviews', $result);
        }
        elseif ($type_id == 3) {
            $this->load->view('journal/news/e_news_list', $result);
        }

        $this->load->view('footer/footer');
    }

    /**
     * Вывод последних статей
     *
     * @return void
     */
    public function journalArticles()
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3 or $this->session->user['blocked'] == 1) {
            parent::pageNotFound($this->page_url);
        }

        $result = $this->Journal_model->getEArticlesList();

        // Объединенные данные страница
        $this->page_data['title'] = 'АП - Журнал - Статьи';
        $this->page_data['page_menu'] = 'a_journal';
        $this->page_data['page_submenu'] = 'articles';

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('journal/article/e_articles', $result);
        $this->load->view('footer/footer');
    }

    /**
     * Форма добавления новой статьи
     *
     * @return void
     */
    public function journalNewArticle()
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3 or $this->session->user['blocked'] == 1) {
            parent::pageNotFound($this->page_url);
        }

        if ($this->input->post('bt_save_new_article', true)) {
            $name       = mb_substr(strip_tags($this->input->post('name')), 0, 255);
            $short_desc = mb_substr(strip_tags($this->input->post('short_desc')), 0, 255);
            $full_desc  = mb_substr($this->input->post('full_desc'), 0, 15000);
            $author     = mb_substr(strip_tags($this->input->post('author')), 0, 255);
            $source     = mb_substr(strip_tags($this->input->post('source')), 0, 255);

            // Загрузка изображения на сервер
            $image_path = '';
            if(is_uploaded_file($_FILES['image']['tmp_name'])){
                $path = './journal/';

                $image_path = parent::uploadImage('image', $_FILES['image']['type'], $path);
                if(file_exists('./journal/'.$image_path)){
                    if ($this->security->xss_clean('./journal/'.$image_path, TRUE) !== FALSE) {
                        // файл прошел XSS тест
                        $image_path = './journal/'.$image_path;
                    } else{
                        unlink('./journal/'.$image_path);
                    }
                }
            }
            
            if (!empty($name) and !empty($short_desc) and !empty($full_desc)) {
                $result = $this->Journal_model->setNewArticle($name, $image_path, $short_desc, $full_desc, $author,
                    $source, $this->date, $this->user_id);

                if ($result === true) {
                    // Сохранено
                    $this->session->set_tempdata('message', 10, 60);
                } else {
                    // Не сохранено
                    $this->session->set_tempdata('message', 58, 60);
                }
            } else {
                // Не все поля заполнены
                $this->session->set_tempdata('message', 61, 60);
            }

            header('Location: /administration/journal/article/new');
        }
        
        // Объединенные данные страница
        $this->page_data['title'] = 'АП - Журнал - Новая статья';
        $this->page_data['page_menu'] = 'a_journal';
        $this->page_data['page_submenu'] = 'articles';

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('journal/article/new_article');
        $this->load->view('footer/footer');
    }

    /**
     * Вывод данных для редактирования статьи
     *
     * @param $article_id
     * @return void
     */
    public function journalArticle($article_id)
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3 or $this->session->user['blocked'] == 1) {
            parent::pageNotFound($this->page_url);
        }

        $article_data = $this->Journal_model->getEArticle($article_id);

        if ($this->input->post('bt_save_article', true)) {
            $name       = mb_substr(strip_tags($this->input->post('name', true)), 0, 255);
            $short_desc = mb_substr(strip_tags($this->input->post('short_desc', true)), 0, 255);
            $full_desc  = mb_substr($this->input->post('full_desc'), 0, 15000);
            $author     = mb_substr(strip_tags($this->input->post('author', true)), 0, 255);
            $source     = mb_substr(strip_tags($this->input->post('source', true)), 0, 255);

            // Загрузка изображения на сервер
            $image_path = '';
            if(is_uploaded_file($_FILES['image']['tmp_name'])){
                $path = './journal/';

                $image_path = parent::uploadImage('image', $_FILES['image']['type'], $path);
                if(file_exists('./journal/'.$image_path)){
                    if ($this->security->xss_clean('./journal/'.$image_path, TRUE) !== FALSE) {
                        // файл прошел XSS тест
                        $image_path = './journal/'.$image_path;

                        // Удаление предыдущего изображения
                        if (!empty($article_data['article']['image']) and file_exists('.'.$article_data['article']['image'])) {
                            unlink('.'.$article_data['article']['image']);
                        }
                    } else{
                        unlink('./journal/'.$image_path);
                    }
                }
            }

            if (!empty($name) and !empty($short_desc) and !empty($full_desc)) {
                $result = $this->Journal_model->updateSettingsArticle($article_id, $name, $image_path, $short_desc, $full_desc, $author, $source, $this->date);

                if ($result === true) {
                    // Сохранено
                    $this->session->set_tempdata('message', 10, 60);
                } else {
                    // Не сохранено
                    $this->session->set_tempdata('message', 58, 60);
                }
            } else {
                // Не все поля заполнены
                $this->session->set_tempdata('message', 61, 60);
            }

            header('Location: /administration/journal/article/'.$article_id);
        }
        elseif ($this->input->post('bt_block_article', true)) {
            $result = $this->Journal_model->blockArticle($article_id, $this->date);

            if ($result === true) {
                // Сохранено
                $this->session->set_tempdata('message', 10, 60);
            } else {
                // Не сохранено
                $this->session->set_tempdata('message', 58, 60);
            }
        }
        elseif ($this->input->post('bt_unblock_article', true)) {
            $result = $this->Journal_model->unblockArticle($article_id, $this->date);

            if ($result === true) {
                // Сохранено
                $this->session->set_tempdata('message', 10, 60);
            } else {
                // Не сохранено
                $this->session->set_tempdata('message', 58, 60);
            }
        }
        
        $result = $this->Journal_model->getEArticle($article_id);

        // Объединенные данные страница
        $this->page_data['title'] = 'АП - Журнал - Статья';
        $this->page_data['page_menu'] = 'a_journal';
        $this->page_data['page_submenu'] = 'articles';

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('journal/article/article_settings', $result);
        $this->load->view('footer/footer');
    }

    /**
     * Вывод последних интервью
     *
     * @return void
     */
    public function journalInterviews()
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3 or $this->session->user['blocked'] == 1) {
            parent::pageNotFound($this->page_url);
        }

        $result = $this->Journal_model->getEInterviewsList();

        // Объединенные данные страница
        $this->page_data['title'] = 'АП - Журнал - Интервью';
        $this->page_data['page_menu'] = 'a_journal';
        $this->page_data['page_submenu'] = 'interviews';

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('journal/interview/e_interviews', $result);
        $this->load->view('footer/footer');
    }

    /**
     * Вывод данных для редактирования интервью
     *
     * @param null $interview_id
     * @return void
     */
    public function journalInterview($interview_id = null)
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3 or $this->session->user['blocked'] == 1) {
            parent::pageNotFound($this->page_url);
        }

        $interview_data = $this->Journal_model->getEInterview($interview_id);

        if ($this->input->post('bt_save_interview', true)) {
            $name       = mb_substr(strip_tags($this->input->post('name', true)), 0, 255);
            $short_desc = mb_substr(strip_tags($this->input->post('short_desc', true)), 0, 255);
            $full_desc  = mb_substr($this->input->post('full_desc'), 0, 15000);
            $author     = mb_substr(strip_tags($this->input->post('author', true)), 0, 255);
            $source     = mb_substr(strip_tags($this->input->post('source', true)), 0, 255);

            // Загрузка изображения на сервер
            $image_path = '';
            if(is_uploaded_file($_FILES['image']['tmp_name'])){
                $path = './journal/';

                $image_path = parent::uploadImage('image', $_FILES['image']['type'], $path);
                if(file_exists('./journal/'.$image_path)){
                    if ($this->security->xss_clean('./journal/'.$image_path, TRUE) !== FALSE) {
                        // файл прошел XSS тест
                        $image_path = './journal/'.$image_path;

                        // Удаление предыдущего изображения
                        if (!empty($interview_data['interview']['image']) and file_exists('.'.$interview_data['interview']['image'])) {
                            unlink('.'.$interview_data['interview']['image']);
                        }
                    } else{
                        unlink('./journal/'.$image_path);
                    }
                }
            }

            if (!empty($name) and !empty($short_desc) and !empty($full_desc)) {
                $result = $this->Journal_model->updateSettingsInterview($interview_id, $name, $image_path, $short_desc,
                    $full_desc, $author, $source, $this->date);

                if ($result === true) {
                    // Сохранено
                    $this->session->set_tempdata('message', 10, 60);
                } else {
                    // Не сохранено
                    $this->session->set_tempdata('message', 59, 60);
                }
            } else {
                // Не все поля заполнены
                $this->session->set_tempdata('message', 61, 60);
            }

            header('Location: /administration/journal/interview/'.$interview_id);
        }
        elseif ($this->input->post('bt_block_interview', true)) {
            $result = $this->Journal_model->blockInterview($interview_id, $this->date);

            if ($result === true) {
                // Сохранено
                $this->session->set_tempdata('message', 10, 60);
            } else {
                // Не сохранено
                $this->session->set_tempdata('message', 59, 60);
            }
        }
        elseif ($this->input->post('bt_unblock_interview', true)) {
            $result = $this->Journal_model->unblockInterview($interview_id, $this->date);

            if ($result === true) {
                // Сохранено
                $this->session->set_tempdata('message', 10, 60);
            } else {
                // Не сохранено
                $this->session->set_tempdata('message', 59, 60);
            }
        }
        
        $result = $this->Journal_model->getEInterview($interview_id);

        // Объединенные данные страница
        $this->page_data['title'] = 'АП - Журнал - Интервью';
        $this->page_data['page_menu'] = 'a_journal';
        $this->page_data['page_submenu'] = 'interviews';

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('journal/interview/interview_settings', $result);
        $this->load->view('footer/footer');
    }

    /**
     * Форма добавления нового интервью
     *
     * @return void
     */
    public function journalNewInterview()
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3 or $this->session->user['blocked'] == 1) {
            parent::pageNotFound($this->page_url);
        }

        if ($this->input->post('bt_save_new_interview', true)) {
            $name       = mb_substr(strip_tags($this->input->post('name', true)), 0, 255);
            $short_desc = mb_substr(strip_tags($this->input->post('short_desc', true)), 0, 255);
            $full_desc  = mb_substr($this->input->post('full_desc'), 0, 15000);
            $author     = mb_substr(strip_tags($this->input->post('author', true)), 0, 255);
            $source     = mb_substr(strip_tags($this->input->post('source', true)), 0, 255);

            // Загрузка изображения на сервер
            $image_path = '';
            if(is_uploaded_file($_FILES['image']['tmp_name'])){
                $path = './journal/';

                $image_path = parent::uploadImage('image', $_FILES['image']['type'], $path);
                if(file_exists('./journal/'.$image_path)){
                    if ($this->security->xss_clean('./journal/'.$image_path, TRUE) !== FALSE) {
                        // файл прошел XSS тест
                        $image_path = './journal/'.$image_path;
                    } else{
                        unlink('./journal/'.$image_path);
                    }
                }
            }

            if (!empty($name) and !empty($short_desc) and !empty($full_desc)) {
                $result = $this->Journal_model->setNewInterview($name, $image_path, $short_desc, $full_desc, $author,
                    $source, $this->date, $this->user_id);

                if ($result === true) {
                    // Сохранено
                    $this->session->set_tempdata('message', 10, 60);
                } else {
                    // Не сохранено
                    $this->session->set_tempdata('message', 59, 60);
                }
            } else {
                // Не все поля заполнены
                $this->session->set_tempdata('message', 61, 60);
            }

            header('Location: /administration/journal/interview/new');
        }
        // Объединенные данные страница
        $this->page_data['title'] = 'АП - Журнал - Новое интервью';
        $this->page_data['page_menu'] = 'a_journal';
        $this->page_data['page_submenu'] = 'interviews';

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('journal/interview/new_interview');
        $this->load->view('footer/footer');
    }

    /**
     * Вывод списка новостей / данных для редактирования новости
     *
     * @param null $news_id
     * @return void
     */
    public function journalNews($news_id = null)
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3 or $this->session->user['blocked'] == 1) {
            parent::pageNotFound($this->page_url);
        }

        if (!empty($news_id)) {
            $news_data = $this->Journal_model->getENews($news_id);
        }

        if ($this->input->post('bt_save_news', true)) {
            $name       = mb_substr(strip_tags($this->input->post('name', true)), 0, 255);
            $short_desc = mb_substr(strip_tags($this->input->post('short_desc', true)), 0, 255);
            $full_desc  = mb_substr($this->input->post('full_desc'), 0, 15000);
            $author     = mb_substr(strip_tags($this->input->post('author', true)), 0, 255);
            $source     = mb_substr(strip_tags($this->input->post('source', true)), 0, 255);

            // Загрузка изображения на сервер
            $image_path = '';
            if(is_uploaded_file($_FILES['image']['tmp_name'])){
                $path = './journal/';

                $image_path = parent::uploadImage('image', $_FILES['image']['type'], $path);
                if(file_exists('./journal/'.$image_path)){
                    if ($this->security->xss_clean('./journal/'.$image_path, TRUE) !== FALSE) {
                        // файл прошел XSS тест
                        $image_path = './journal/'.$image_path;

                        // Удаление предыдущего изображения
                        if (!empty($news_data['news']['image']) and file_exists('.'.$news_data['news']['image'])) {
                            unlink('.'.$news_data['news']['image']);
                        }
                    } else{
                        unlink('./journal/'.$image_path);
                    }
                }
            }

            if (!empty($name) and !empty($short_desc) and !empty($full_desc)) {
                $result = $this->Journal_model->updateSettingsNews($news_id, $name, $image_path, $short_desc, $full_desc,
                    $author, $source, $this->date);

                if ($result === true) {
                    // Сохранено
                    $this->session->set_tempdata('message', 10, 60);
                } else {
                    // Не сохранено
                    $this->session->set_tempdata('message', 60, 60);
                }
            } else {
                // Не все поля заполнены
                $this->session->set_tempdata('message', 61, 60);
            }

            header('Location: /administration/journal/news/'.$news_id);
        }
        elseif ($this->input->post('bt_block_news', true)) {
            $result = $this->Journal_model->blockNews($news_id, $this->date);

            if ($result === true) {
                // Сохранено
                $this->session->set_tempdata('message', 10, 60);
            } else {
                // Не сохранено
                $this->session->set_tempdata('message', 60, 60);
            }
        }
        elseif ($this->input->post('bt_unblock_news', true)) {
            $result = $this->Journal_model->unblockNews($news_id, $this->date);

            if ($result === true) {
                // Сохранено
                $this->session->set_tempdata('message', 10, 60);
            } else {
                // Не сохранено
                $this->session->set_tempdata('message', 60, 60);
            }
        }
        
        if (empty($news_id)) {
            $result = $this->Journal_model->getENewsList();
        } else {
            $result = $this->Journal_model->getENews($news_id);
        }

        // Объединенные данные страница
        $this->page_data['title'] = 'АП - Журнал - Новости';
        $this->page_data['page_menu'] = 'a_journal';
        $this->page_data['page_submenu'] = 'news';

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/admin');

        if (empty($news_id)) {
            $this->load->view('journal/news/e_news_list', $result);
        } else {
            $this->load->view('journal/news/news_settings', $result);
        }

        $this->load->view('footer/footer');
    }

    /**
     * Форма добавления новости
     *
     * @return void
     */
    public function journalNewNews()
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3 or $this->session->user['blocked'] == 1) {
            parent::pageNotFound($this->page_url);
        }

        if ($this->input->post('bt_save_new_news', true)) {
            $name       = mb_substr(strip_tags($this->input->post('name', true)), 0, 255);
            $short_desc = mb_substr(strip_tags($this->input->post('short_desc', true)), 0, 255);
            $full_desc  = mb_substr($this->input->post('full_desc'), 0, 15000);
            $author     = mb_substr(strip_tags($this->input->post('author', true)), 0, 255);
            $source     = mb_substr(strip_tags($this->input->post('source', true)), 0, 255);

            // Загрузка изображения на сервер
            $image_path = '';
            if(is_uploaded_file($_FILES['image']['tmp_name'])){
                $path = './journal/';

                $image_path = parent::uploadImage('image', $_FILES['image']['type'], $path);
                if(file_exists('./journal/'.$image_path)){
                    if ($this->security->xss_clean('./journal/'.$image_path, TRUE) !== FALSE) {
                        // файл прошел XSS тест
                        $image_path = './journal/'.$image_path;
                    } else{
                        unlink('/journal/'.$image_path);
                    }
                }
            }

            if (!empty($name) and !empty($short_desc) and !empty($full_desc)) {
                $result = $this->Journal_model->setNewNews($name, $image_path, $short_desc, $full_desc, $author,
                    $source, $this->date, $this->user_id);

                if ($result === true) {
                    // Сохранено
                    $this->session->set_tempdata('message', 10, 60);
                } else {
                    // Не сохранено
                    $this->session->set_tempdata('message', 60, 60);
                }
            } else {
                // Не все поля заполнены
                $this->session->set_tempdata('message', 61, 60);
            }

            header('Location: /administration/journal/news/new');
        }

        // Объединенные данные страница
        $this->page_data['title'] = 'АП - Журнал - Новая новость';
        $this->page_data['page_menu'] = 'a_journal';
        $this->page_data['page_submenu'] = 'news';

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('journal/news/new_news');
        $this->load->view('footer/footer');
    }


    /**
     * Вывод списка категорий (статьи, интервью, новости) с количеством содержимого для пользователя
     *
     * @return void
     */
    /*public function journal()
    {
        $articles  = $this->Journal_model->getCountArticles();
        $interview = $this->Journal_model->getCountInterviews();
        $news      = $this->Journal_model->getCountNews();

        $result = array_merge($articles, $interview, $news);

        // Объединенные данные страница
        $this->page_data['title'] = 'Журнал';
        $this->page_data['page_menu'] = 'journal';

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/profile');
        $this->load->view('user/profile_line');
        $this->load->view('journal/list', $result);
        $this->load->view('footer/footer');
    }*/

    /**
     * Вывод списка статей для пользователя
     *
     * @return void
     */
    public function articles()
    {
        $result = $this->Journal_model->getArticlesList();

        // Объединенные данные страница
        $this->page_data['title'] = 'Журнал - Статьи';
        $this->page_data['page_menu'] = 'articles';
        $this->page_data['journal_menu'] = $this->journal_menu;

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/profile');
        $this->load->view('user/profile_line');
        $this->load->view('journal/journal_header');

        $this->load->view('journal/article/articles', $result);

        $this->load->view('journal/journal_footer');
        $this->load->view('footer/footer');
    }

    /**
     * Вывод статьи для пользователя
     *
     * @param $article_id
     * @return void
     */
    public function article($article_id)
    {
        $result = $this->Journal_model->getArticle($article_id);

        // Объединенные данные страница
        $this->page_data['title'] = 'Журнал - Статья';
        $this->page_data['page_menu'] = 'article';
        $this->page_data['journal_menu'] = $this->journal_menu;

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/profile');
        $this->load->view('user/profile_line');
        $this->load->view('journal/journal_header');

        $this->load->view('journal/article/article', $result);

        $this->load->view('journal/journal_footer');
        $this->load->view('footer/footer');
    }

    /**
     * Вывод списка интервью для пользователя
     *
     * @return void
     */
    public function interviews()
    {
        $result = $this->Journal_model->getInterviewsList();

        // Объединенные данные страница
        $this->page_data['title'] = 'Журнал - Интервью';
        $this->page_data['page_menu'] = 'interviews';
        $this->page_data['journal_menu'] = $this->journal_menu;

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/profile');
        $this->load->view('user/profile_line');
        $this->load->view('journal/journal_header');

        $this->load->view('journal/interview/interviews', $result);

        $this->load->view('journal/journal_footer');
        $this->load->view('footer/footer');
    }

    /**
     * Вывод интервью для пользователя
     *
     * @param null $interview_id
     * @return void
     */
    public function interview($interview_id = null)
    {
        $result = $this->Journal_model->getInterview($interview_id);

        // Объединенные данные страница
        $this->page_data['title'] = 'Журнал - Интервью';
        $this->page_data['page_menu'] = 'interview';
        $this->page_data['journal_menu'] = $this->journal_menu;

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/profile');
        $this->load->view('user/profile_line');
        $this->load->view('journal/journal_header');

        $this->load->view('journal/interview/interview', $result);

        $this->load->view('journal/journal_footer');
        $this->load->view('footer/footer');
    }

    /**
     * Вывод списка новостей / страницы новости для пользователя
     *
     * @param null $news_id
     * @return void
     */
    public function news($news_id = null)
    {
        if (empty($news_id)) {
            $result = $this->Journal_model->getNewsList();
            $page_menu = 'news_list';
        } else {
            $result = $this->Journal_model->getNews($news_id);
            $page_menu = 'news';
        }

        // Объединенные данные страница
        $this->page_data['title'] = 'Журнал - Новости';
        $this->page_data['page_menu'] = $page_menu;
        $this->page_data['journal_menu'] = $this->journal_menu;

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/profile');
        $this->load->view('user/profile_line');
        $this->load->view('journal/journal_header');

        if (empty($news_id)) {
            $this->load->view('journal/news/news_list', $result);
        } else {
            $this->load->view('journal/news/news', $result);
        }

        $this->load->view('journal/journal_footer');
        $this->load->view('footer/footer');
    }


    /**
     * AJAX. Загрузка изображений (не более 5)
     *
     * @return void
     */
    public function uploadImages()
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3 or $this->session->user['blocked'] == 1) {
            parent::pageNotFound($this->page_url);
        }

        $this->load->helper('file');

        $path   = './journal/';
        $result = array('images' => '', 'error' => '', 'input' => '');

        $result['input'] = $_FILES;

        if (is_uploaded_file($_FILES[0]['tmp_name'])) {
            $temp_files = $_FILES;

            $i = 0;
            foreach ($temp_files as $temp_file){
                if ($i == 5) {
                    break;
                }

                $_FILES['journal_images'] = array (
                    'name'=>$temp_file['name'],
                    'type'=>$temp_file['type'],
                    'tmp_name'=>$temp_file['tmp_name'],
                    'error'=>$temp_file['error'],
                    'size'=>$temp_file['size']);

                if (is_uploaded_file($_FILES['journal_images']['tmp_name'])) {
                    $path_image = parent::uploadImage('journal_images', $_FILES['journal_images']['type'], $path);

                    if(file_exists($path . $path_image)){
                        if ($this->security->xss_clean($path . $path_image, TRUE) !== FALSE) {
                            // файл прошел XSS тест
                            //$files_data .= $path . $path_image . ';';

                            $result['images'] .= '
                                    <div class="admin_form_foto_wrap h210">
                                        <div class="admin_form_foto">
                                            <img src="' . mb_substr($path, 1) . $path_image . '" alt="">
                                        </div>
                                        <div class="admin_form_buts parent">
                                            <!--<label for="admin_edit_file1" class="admin_edit_file">
                                                <input type="file" name="img1" class="admin_form_file" id="admin_edit_file1" />
                                            </label>-->
                                            <input type="hidden" name="img_path_' . $i . '" value="' . $path . $path_image . '" id="img_path"/>
                                            <input type="hidden" name="images[]" value="' . $path . $path_image . '"/>
                                            <input type="submit" name="bt_delete_img[]" id="journal_del_img" class="admin_form_del" value="Удалить" />
                                        </div>
                                        <div class="img_path">' . mb_substr($path, 1) . $path_image . '</div>
                                    </div>';

                        } else{
                            unlink($path . $path_image);

                            $result['error'] .= 'Изображение №' . $i . ' не прошло проверку. Пожалуйста, повторите попытку. ';
                        }
                    }
                }
                else {
                    $result['error'] .= 'К сожалению, не удалось загрузить изображение №' . $i . '. Пожалуйста, повторите попытку. ';
                }
                $i++;
            }
            unset($name);
        }
        else {
            $result['error'] = 'К сожалению, не удалось загрузить изображения. Пожалуйста, повторите попытку.';
        }

        echo json_encode($result, JSON_NUMERIC_CHECK);
    }

    /**
     * AJAX. Удаление изображения
     */
    public function deleteImage()
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3 or $this->session->user['blocked'] == 1) {
            parent::pageNotFound($this->page_url);
        }

        $image   = file_exists($this->input->post('image', true)) ? $this->input->post('image', true) : null;
        $post_id = is_numeric($this->input->post('post_id', true)) ? $this->input->post('post_id', true) : null;

        $result = array('image' => false, 'error' => false);

        if (!empty($image) and !empty($post_id)) {
            $del_image = $this->Journal_model->deleteImage($post_id, $image);

            if ($del_image === true) {
                $result['image'] = true;
            }
            elseif ($del_image == 'not_found_image') {
                $result['image'] = true;
            }
            elseif ($del_image == 'not_found_post') {
                $result['error'] = true;
            }
        }
        elseif (!empty($image)) {
            unlink($image);
            $result['image'] = true;
        }
        else {
            $result['error'] = true;
        }

        echo json_encode($result, JSON_NUMERIC_CHECK);
    }
}