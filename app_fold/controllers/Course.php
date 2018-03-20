<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Класс Course
 * 
 * Класс для работы с данными курса
 *
 * @author Alina Sudeyskis <alina.sudeyskis@gmail.com>
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Course extends CI_Controller
{
    /**
     * Course constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Course_model');
    }

    /**
     * Вывод последних сохраненных типов курса
     *
     * @return void
     */
    public function courseTypes()
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3) {
            show_404($this->page_url);
        }

        // Получение данных о типах курсов
        $result = $this->Course_model->getCourseTypes();

        // Объединенные данные страница
        $this->page_data['title'] = 'АП - Типы курсов';
        $this->page_data['page_menu'] = 'course_type';

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('course/types', $result);
        $this->load->view('footer/footer');
    }

    /**
     * Вывод формы и валидация введенных данных нового типа курса
     *
     * @return void
     */
    public function newCourseTypes()
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3) {
            show_404($this->page_url);
        }

        // Сохранение нового типа курса
        if ($this->input->post('bt_save_new_type', true)) {
            // Имя пользователя
            $name = mb_substr(strip_tags($this->input->post('name', true)), 0, 255);

            if (!empty($name)) {
                $result = $this->Course_model->setNewCourseType($name, $this->date);

                if (is_numeric($result)) {
                    // Изменения сохранены
                    $this->session->set_tempdata('message', 10, 60);
                    header('Location: /administration/course/type/'.$result);
                } else {
                    // Изменения не сохранены
                    $this->session->set_tempdata('message', 25, 60);
                    header('Location: /administration/course/type/new');
                }
            }
        }

        // Объединенные данные страница
        $this->page_data['title'] = 'АП - Добавление нового типа курса';
        $this->page_data['page_menu'] = 'course_type';

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('course/new_type');
        $this->load->view('footer/footer');
    }

    /**
     * Вывод формы и валидация изменных данных типа курса
     *
     * @param $type_id
     * @return void
     */
    public function courseType($type_id)
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3) {
            show_404($this->page_url);
        }

        // Сохранение изменений типа курса
        if ($this->input->post('bt_save_type_settings', true) and is_numeric($type_id)) {
            // Имя пользователя
            $name = mb_substr(strip_tags($this->input->post('name', true)), 0, 255);

            if (!empty($name)) {
                $result = $this->Course_model->setCourseTypeSettings($type_id, $name, $this->date);

                if ($result === true) {
                    // Изменения сохранены
                    $this->session->set_tempdata('message', 10, 60);
                } else {
                    // Изменения не сохранены
                    $this->session->set_tempdata('message', 25, 60);
                }
            }
            header('Location: /administration/course/type/'.$type_id);
        }

        // Объединенные данные страница
        $this->page_data['title'] = 'АП - Изменение данных типа курса';
        $this->page_data['page_menu'] = 'course_type';

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/admin');

        if (is_numeric($type_id)) {
            $result = $this->Course_model->getCourseType($type_id);

            $this->load->view('course/type_settings', $result);
        }

        $this->load->view('footer/footer');
    }

    /**
     * Вывод последних сохраненных типов приемов пищи
     *
     * @return void
     */
    public function ingestionTypes()
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3) {
            show_404($this->page_url);
        }

        // Получение данных о типах курсов
        $result = $this->Course_model->getIngestionTypes();

        // Объединенные данные страница
        $this->page_data['title'] = 'АП - Типы приемов пищи';
        $this->page_data['page_menu'] = 'ingestion_type';

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('ingestion/types', $result);
        $this->load->view('footer/footer');
    }

    /**
     * Вывод формы и валидация введенных данных нового типа приемов пищи
     *
     * @return void
     */
    public function newIngestionTypes()
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3) {
            show_404($this->page_url);
        }

        // Сохранение нового типа приемов пищи
        if ($this->input->post('bt_save_new_type', true)) {
            // Имя пользователя
            $name = mb_substr(strip_tags($this->input->post('name', true)), 0, 255);

            if (!empty($name)) {
                $result = $this->Course_model->setNewIngestionType($name, $this->date);

                if (is_numeric($result)) {
                    // Изменения сохранены
                    $this->session->set_tempdata('message', 10, 60);
                    header('Location: /administration/ingestion/type/'.$result);
                } else {
                    // Изменения не сохранены
                    $this->session->set_tempdata('message', 27, 60);
                    header('Location: /administration/ingestion/type/new');
                }
            }
        }

        // Объединенные данные страница
        $this->page_data['title'] = 'АП - Добавление нового типа приемов пищи';
        $this->page_data['page_menu'] = 'ingestion_type';

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('ingestion/new_type');
        $this->load->view('footer/footer');
    }

    /**
     * Вывод формы и валидация изменных данных типа приемов пищи
     *
     * @param $type_id
     * @return void
     */
    public function ingestionType($type_id)
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3) {
            show_404($this->page_url);
        }

        // Сохранение изменений типа курса
        if ($this->input->post('bt_save_type_settings', true) and is_numeric($type_id)) {
            // Имя пользователя
            $name = mb_substr(strip_tags($this->input->post('name', true)), 0, 255);

            if (!empty($name)) {
                $result = $this->Course_model->setIngestionTypeSettings($type_id, $name, $this->date);

                if ($result === true) {
                    // Изменения сохранены
                    $this->session->set_tempdata('message', 10, 60);
                } else {
                    // Изменения не сохранены
                    $this->session->set_tempdata('message', 27, 60);
                }
            }
            header('Location: /administration/ingestion/type/'.$type_id);
        }

        // Объединенные данные страница
        $this->page_data['title'] = 'АП - Изменение данных типа приемов пищи';
        $this->page_data['page_menu'] = 'ingestion_type';

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/admin');

        if (is_numeric($type_id)) {
            $result = $this->Course_model->getIngestionType($type_id);

            $this->load->view('ingestion/type_settings', $result);
        }

        $this->load->view('footer/footer');
    }

    /**
     * Вывод последних сохраненных приемов пищи
     *
     * @return void
     */
    public function ingestions()
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3) {
            show_404($this->page_url);
        }

        // Получение данных о типах курсов
        $result = $this->Course_model->getIngestions();

        // Объединенные данные страница
        $this->page_data['title'] = 'АП - Приемы пищи';
        $this->page_data['page_menu'] = 'ingestion';

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('ingestion/ingestions', $result);
        $this->load->view('footer/footer');
    }

    /**
     * Вывод формы и валидация введенных данных нового приема пищи
     *
     * @return void
     */
    public function newIngestion()
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3) {
            show_404($this->page_url);
        }

        // Сохранение нового типа приемов пищи
        if ($this->input->post('bt_save_new_ingestion', true)) {
            // Имя пользователя
            $name = mb_substr(strip_tags($this->input->post('name', true)), 0, 255);

            // Тип приема пищи
            $type_id = is_numeric($this->input->post('s_ing_type')) ? $this->input->post('s_ing_type') : '' ;

            // Время приема добавки
            $d = DateTime::createFromFormat('H:i', $this->input->post('time_additives', true));
            $time = ($d !== false) ? $this->input->post('time_additives', true) : '';

            if ('' == $this->input->post('s_time_additives', true)) {
                $time_additives = '';
            }
            else {
                if ('before' == $this->input->post('s_time_additives', true)) {
                    if (!empty($time) and '00:00' != $time) {
                        $time_additives = '-' . $time;
                    } else {
                        $time_additives = '-00:00:01';
                    }
                }
                elseif ('after' == $this->input->post('s_time_additives', true)) {
                    if (!empty($time) and '00:00' != $time) {
                        $time_additives = $time;
                    } else {
                        $time_additives = '00:00:01';
                    }
                } else {
                    $time_additives = '';
                }
            }

            if (!empty($name)) {
                $result = $this->Course_model->setNewIngestion($name, $type_id, $time_additives, $this->date);

                if (is_numeric($result)) {
                    // Изменения сохранены
                    $this->session->set_tempdata('message', 10, 60);
                    header('Location: /administration/ingestion/'.$result);
                } else {
                    // Изменения не сохранены
                    $this->session->set_tempdata('message', 26, 60);
                    header('Location: /administration/ingestion/new');
                }
            }
        }


        // Объединенные данные страница
        $this->page_data['title'] = 'АП - Добавление нового приема пищи';
        $this->page_data['page_menu'] = 'ingestion';

        $result = $this->Course_model->getIngestionTypes();

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('ingestion/new_ingestion', $result);
        $this->load->view('footer/footer');
    }

    /**
     * Вывод формы и валидация изменных данных типа приемов пищи
     *
     * @param $ing_id
     * @return void
     */
    public function ingestion($ing_id)
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3) {
            show_404($this->page_url);
        }

        // Сохранение изменений типа курса
        if ($this->input->post('bt_save_ingestion_settings', true) and is_numeric($ing_id)) {
            // Имя пользователя
            $name = mb_substr(strip_tags($this->input->post('name', true)), 0, 255);

            // Тип приема пищи
            $type_id = is_numeric($this->input->post('s_ing_type')) ? $this->input->post('s_ing_type') : '' ;

            // Время приема добавки
            $d = DateTime::createFromFormat('H:i', $this->input->post('time_additives', true));
            $time = ($d !== false) ? $this->input->post('time_additives', true) : '';

            if ('' == $this->input->post('s_time_additives', true)) {
                $time_additives = '';
            }
            else {
                if ('before' == $this->input->post('s_time_additives', true)) {
                    if (!empty($time) and '00:00' != $time) {
                        $time_additives = '-' . $time;
                    } else {
                        $time_additives = '-00:00:01';
                    }
                }
                elseif ('after' == $this->input->post('s_time_additives', true)) {
                    if (!empty($time) and '00:00' != $time) {
                        $time_additives = $time;
                    } else {
                        $time_additives = '00:00:01';
                    }
                } else {
                    $time_additives = '';
                }
            }

            if (!empty($name)) {
                $result = $this->Course_model->setIngestionSettings($ing_id, $name, $type_id, $time_additives, $this->date);

                if ($result === true) {
                    // Изменения сохранены
                    $this->session->set_tempdata('message', 10, 60);
                } else {
                    // Изменения не сохранены
                    $this->session->set_tempdata('message', 26, 60);
                }
            }
            header('Location: /administration/ingestion/'.$ing_id);
        }

        // Объединенные данные страница
        $this->page_data['title'] = 'АП - Изменение данных приема пищи';
        $this->page_data['page_menu'] = 'ingestion';

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/admin');

        if (is_numeric($ing_id)) {
            $ingestion = $this->Course_model->getIngestion($ing_id);
            $ing_type = $this->Course_model->getIngestionTypes();
            $result = array_merge($ingestion, $ing_type);

            $this->load->view('ingestion/ingestion_settings', $result);
        }

        $this->load->view('footer/footer');
    }

    /* БЛОК ФУНКЦИЙ ВЫВОДА И ВАЛИДАЦИИ ДАННЫХ ВИДЕО */

    /**
     * Вывод данных видео
     *
     * @param string $video_type
     */
    public function video($video_type = 'promo')
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3) {
            show_404($this->page_url);
        }

        if ($video_type == 'promo')
        {
            self::videoPromo();
        }
        elseif ($video_type == 'courses')
        {
            self::videoCourses();
        }
        elseif ($video_type == 'instructions')
        {
            self::videoInstructions();
        }
        elseif ($video_type == 'uncategorized')
        {
            self::videoUncategorized();
        }
    }

    /**
     * Вывод списка промо видео
     *
     * @return void
     */
    protected function videoPromo()
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3)
        {
            show_404($this->page_url);
        }

        $result = $this->Course_model->getPromoVideo();
        
        // Объединенные данные страница
        $this->page_data['title'] = 'АП - Видео';
        $this->page_data['page_menu'] = 'video';
        $this->page_data['page_submenu'] = 'promo';

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('video/video', $result);
        $this->load->view('footer/footer');
    }

    /**
     * Вывод списка курсы видео
     *
     * @return void
     */
    protected function videoCourses()
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3)
        {
            show_404($this->page_url);
        }

        $result = $this->Course_model->getVideoCourses();

        // Объединенные данные страница
        $this->page_data['title'] = 'АП - Видео';
        $this->page_data['page_menu'] = 'video';
        $this->page_data['page_submenu'] = 'courses';

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('video/video_courses', $result);
        $this->load->view('footer/footer');
    }

    /**
     * Вывод списка видео без категории
     *
     * @return void
     */
    protected function videoUncategorized()
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3)
        {
            show_404($this->page_url);
        }

        $result = $this->Course_model->getUncategorizedVideo();

        // Объединенные данные страница
        $this->page_data['title'] = 'АП - Видео';
        $this->page_data['page_menu'] = 'video';
        $this->page_data['page_submenu'] = 'uncategorized';

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('video/video', $result);
        $this->load->view('footer/footer');
    }

    /**
     * Вывод списка видео категории "Инструктажи"
     *
     * @return void
     */
    protected function videoInstructions()
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3)
        {
            show_404($this->page_url);
        }

        $result = $this->Course_model->getInstructionsVideo();

        // Объединенные данные страница
        $this->page_data['title'] = 'АП - Видео';
        $this->page_data['page_menu'] = 'video';
        $this->page_data['page_submenu'] = 'instructions';

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('video/video', $result);
        $this->load->view('footer/footer');
    }

    /**
     * Вывод списка видео курса
     *
     * @param $course_id
     * @return void
     */
    public function courseVideo($course_id)
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3)
        {
            show_404($this->page_url);
        }

        $result = $this->Course_model->getCourseVideo($course_id);

        // Объединенные данные страница
        $this->page_data['title'] = 'АП - Видео';
        $this->page_data['page_menu'] = 'video';
        $this->page_data['page_submenu'] = 'courses';

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('video/video', $result);
        $this->load->view('footer/footer');
    }

    /**
     * Вывод формы и валидация данных нового видео
     *
     * @return void
     */
    public function newVideo()
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3) {
            show_404($this->page_url);
        }

        $courses = $this->Course_model->getCourses();

        if ($this->input->post('bt_save_video', true))
        {
            $type        = is_numeric($this->input->post('s_type', true)) ? $this->input->post('s_type', true) : 0;
            $course_id   = is_numeric($this->input->post('s_courses', true)) ? $this->input->post('s_courses', true) : 0;
            $name        = !empty($this->input->post('file_name', true)) 
                ? mb_substr(strip_tags($this->input->post('file_name', true)), 0, 255) : '';
            $remove_url  = !empty($this->input->post('remove_url', true)) 
                ? mb_substr(strip_tags($this->input->post('remove_url', true)), 0, 255) : '';
            $poster_path = is_file('./video/' . $this->input->post('poster_path', true))
                ? './video/' . $this->input->post('poster_path', true) : '';
            $video_path  = is_file('./video/' . $this->input->post('video_path', true))
                ? './video/' . $this->input->post('video_path', true) : '';
            
            if (!empty($video_path) or !empty($remove_url))
            {
                $result = $this->Course_model->setNewVideo($type, $course_id, $name, $video_path, $poster_path, $remove_url, $this->user_id, $this->date);

                //echo 'T '.$type.' N '.$name.' RU '.$remove_url.' PP '.$poster_path.' VP '.$video_path.'<br/>';

                if (is_numeric($result) and $result !== false)
                {
                    // Изменения сохранены
                    $this->session->set_tempdata('message', 10, 60);

                    header('Location: /administration/video/'.$result);
                }
                else
                {
                    // Изменения не сохранены
                    $this->session->set_tempdata('message', 39, 60);

                    // Удаление загруженных файлов
                    if (is_file($poster_path)) {
                        unlink($poster_path);
                    }
                    if (is_file($video_path)) {
                        unlink($video_path);
                    }
                    header('Location: /administration/video/upload');
                }
            }
            else
            {
                // Изменения не сохранены
                $this->session->set_tempdata('message', 40, 60);

                // Удаление загруженных файлов
                if (is_file($poster_path))
                {
                    unlink($poster_path);
                }
                if (is_file($video_path))
                {
                    unlink($video_path);
                }
                header('Location: /administration/video/upload');
            }
        }
        
        // Объединенные данные страница
        $this->page_data['title'] = 'АП - Добавление видео';
        $this->page_data['page_menu'] = 'video';

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('video/new_video', $courses);
        $this->load->view('footer/footer');
    }

    /**
     * Вывод формы и валидация данных видео
     *
     * @param $video_id
     * @return void
     */
    public function videoSettings($video_id)
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3) {
            show_404($this->page_url);
        }

        $video   = $this->Course_model->getVideo($video_id);
        $courses = $this->Course_model->getCourses();
        $result  = array_merge($video, $courses);

        if ($this->input->post('bt_save_video', true))
        {
            // Введенные данные
            $type        = is_numeric($this->input->post('s_type', true)) ? $this->input->post('s_type', true) : 0;
            $course_id   = is_numeric($this->input->post('s_courses', true)) ? $this->input->post('s_courses', true) : 0;
            $poster_path = (!empty($this->input->post('poster_path', true)) and is_file('./video/' . $this->input->post('poster_path', true)))
                ? './video/' . $this->input->post('poster_path', true)
                : null;
            $video_path  = (!empty($this->input->post('video_path', true)) and is_file('./video/' . $this->input->post('video_path', true)))
                ? './video/' . $this->input->post('video_path', true)
                : null;

            $name = !empty($this->input->post('file_name', true))
                ? mb_substr(strip_tags($this->input->post('file_name', true)), 0, 255)
                : '';

            $remove_url = !empty($this->input->post('remove_url', true))
                ? mb_substr(strip_tags($this->input->post('remove_url', true)), 0, 255)
                : '';
            $remove_id  = mb_substr($remove_url, -11);

            // Сравненение с БД
            $poster = (!empty($poster_path) and $poster_path != $result['video']['poster'])
                ? $poster_path
                : '.' . $result['video']['poster'];
            $video  = (!empty($video_path) and $video_path != $result['video']['video'])
                ? $video_path
                : '.' . $result['video']['video'];

            $update = $this->Course_model->setVideoSettings($video_id, $type, $course_id, $video, $name, $poster, $remove_url, $this->user_id,
                $this->date);

            if ($update === true) {
                if ($video != $result['video']['video'] and is_file($result['video']['video']) and is_file($video)) {
                    unlink($result['video']['video']);
                }

                if ($poster != $result['video']['poster'] and is_file($result['video']['poster']) and is_file($poster)) {
                    unlink($result['video']['poster']);
                }

                // Изменения сохранены
                $this->session->set_tempdata('message', 10, 60);
            } else {
                // Изменения не сохранены
                $this->session->set_tempdata('message', 41, 60);
            }

            header('Location: /administration/video/' . $video_id);
        }
        elseif ($this->input->post('bt_block_video', true) and is_numeric($video_id)) {
            $blocked = $this->Course_model->blockVideo($video_id, $this->date);

            if ($blocked === true) {
                // Сохранено
                $this->session->set_tempdata('message', 42, 60);
            } else {
                // Не сохранено
                $this->session->set_tempdata('message', 43, 60);
            }
            header('Location: /administration/video/' . $video_id);
        }
        elseif ($this->input->post('bt_unblock_video', true) and is_numeric($video_id)) {
            $unblocked = $this->Course_model->unblockVideo($video_id, $this->date);

            if ($unblocked === true) {
                // Сохранено
                $this->session->set_tempdata('message', 44, 60);
            } else {
                // Не сохранено
                $this->session->set_tempdata('message', 45, 60);
            }
            header('Location: /administration/video/' . $video_id);
        }
        elseif ($this->input->post('bt_delete_video', true) and is_numeric($video_id)) {
            $deleted = $this->Course_model->deleteVideo($video_id);

            if ($deleted === true) {
                // Удалено
                $this->session->set_tempdata('message', 104, 60);

                header('Location: /administration/video');
            } else {
                // Не удалено
                $this->session->set_tempdata('message', 105, 60);

                header('Location: /administration/video/' . $video_id);
            }
        }

        // Объединенные данные страница
        $this->page_data['title'] = 'АП - Редактирование данных видео';
        $this->page_data['page_menu'] = 'video';

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('video/video_settings', $result);
        $this->load->view('footer/footer');
    }

    /**
     * Вывод формы и валидация данных видео курса
     *
     * @param $course_id
     * @param $video_id
     * @return void
     */
    public function courseVideoSettings($course_id, $video_id)
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3) {
            show_404($this->page_url);
        }

        $video   = $this->Course_model->getCourseVideoData($course_id, $video_id);
        $courses = $this->Course_model->getCourses();
        $course  = $this->Course_model->getShortCourse($course_id);
        $result  = array_merge($video, $courses, $course);

        if ($this->input->post('bt_save_video', true))
        {
            // Введенные данные
            $type        = is_numeric($this->input->post('s_type', true)) ? $this->input->post('s_type', true) : 0;
            $course_id   = is_numeric($this->input->post('s_courses', true)) ? $this->input->post('s_courses', true) : 0;
            $poster_path = (!empty($this->input->post('poster_path', true)) and is_file('./video/' . $this->input->post('poster_path', true)))
                ? './video/' . $this->input->post('poster_path', true)
                : null;
            $video_path  = (!empty($this->input->post('video_path', true)) and is_file('./video/' . $this->input->post('video_path', true)))
                ? './video/' . $this->input->post('video_path', true)
                : null;

            $name = !empty($this->input->post('file_name', true))
                ? mb_substr(strip_tags($this->input->post('file_name', true)), 0, 255)
                : '';

            $remove_url = !empty($this->input->post('remove_url', true))
                ? mb_substr(strip_tags($this->input->post('remove_url', true)), 0, 255)
                : '';
            $remove_id  = mb_substr($remove_url, -11);

            // Сравненение с БД
            $poster = (!empty($poster_path) and $poster_path != $result['video']['poster'])
                ? $poster_path
                : '.' . $result['video']['poster'];
            $video  = (!empty($video_path) and $video_path != $result['video']['video'])
                ? $video_path
                : '.' . $result['video']['video'];

            $update = $this->Course_model->setVideoSettings($video_id, $type, $course_id, $video, $name, $poster, $remove_url, $this->user_id,
                $this->date);

            if ($update === true) {
                if ($video != $result['video']['video'] and is_file($result['video']['video']) and is_file($video)) {
                    unlink($result['video']['video']);
                }

                if ($poster != $result['video']['poster'] and is_file($result['video']['poster']) and is_file($poster)) {
                    unlink($result['video']['poster']);
                }

                // Изменения сохранены
                $this->session->set_tempdata('message', 10, 60);
            } else {
                // Изменения не сохранены
                $this->session->set_tempdata('message', 41, 60);
            }

            header('Location: /administration/video/' . $video_id);
        }
        elseif ($this->input->post('bt_block_video', true) and is_numeric($video_id)) {
            $blocked = $this->Course_model->blockVideo($video_id, $this->date);

            if ($blocked === true) {
                // Сохранено
                $this->session->set_tempdata('message', 42, 60);
            } else {
                // Не сохранено
                $this->session->set_tempdata('message', 43, 60);
            }
            header('Location: /administration/video/' . $video_id);
        }
        elseif ($this->input->post('bt_unblock_video', true) and is_numeric($video_id)) {
            $unblocked = $this->Course_model->unblockVideo($video_id, $this->date);

            if ($unblocked === true) {
                // Сохранено
                $this->session->set_tempdata('message', 44, 60);
            } else {
                // Не сохранено
                $this->session->set_tempdata('message', 45, 60);
            }
            header('Location: /administration/video/' . $video_id);
        }
        elseif ($this->input->post('bt_delete_video', true) and is_numeric($video_id)) {
            $deleted = $this->Course_model->deleteVideo($video_id);

            if ($deleted === true) {
                // Удалено
                $this->session->set_tempdata('message', 104, 60);

                header('Location: /administration/video');
            } else {
                // Не удалено
                $this->session->set_tempdata('message', 105, 60);

                header('Location: /administration/video/' . $video_id);
            }
        }

        // Объединенные данные страница
        $this->page_data['title']        = 'АП - Редактирование данных видео курса';
        $this->page_data['page_menu']    = 'a_courses';
        $this->page_data['page_submenu'] = 'video';
        $this->page_data['video_menu']   = 'video_settings';
        $this->page_data['course_id']    = $course_id;

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('course/settings/course', $result);
        $this->load->view('footer/footer');
    }

    /* КОНЕЦ БЛОКА ФУНКЦИЙ ДЛЯ РАБОТЫ С ВИДЕО */

    /* БЛОК ФУНКЦИЙ КУРСОВ */

    /**
     * Вывод списка курсов в админ. панели
     */
    public function courses()
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3) {
            show_404($this->page_url);
        }

        if ($this->input->post('bt_deactivate_landing', true)) {
            $course_id = is_numeric($this->input->post('i_course_id', true)) ? $this->input->post('i_course_id', true) : null;

            if (!empty($course_id)) {
                $result = $this->Course_model->deactivateCourseLandingPage($course_id, $this->date);

                if ($result === true) {
                    // Изменения сохранены
                    $this->session->set_tempdata('message', 10, 60);
                } else {
                    // Не удалось деактивировать
                    $this->session->set_tempdata('message', 100, 60);
                }
            } else {
                // Не удалось деактивировать
                $this->session->set_tempdata('message', 100, 60);
            }

            header('Location: /administration/courses');
        }
        elseif ($this->input->post('bt_activate_landing', true)) {
            $course_id = is_numeric($this->input->post('i_course_id', true)) ? $this->input->post('i_course_id', true) : null;

            if (!empty($course_id)) {
                $result = $this->Course_model->activateCourseLandingPage($course_id, $this->date);

                if ($result === true) {
                    // Изменения сохранены
                    $this->session->set_tempdata('message', 10, 60);
                } else {
                    // Не удалось активировать
                    $this->session->set_tempdata('message', 99, 60);
                }
            } else {
                // Не удалось активировать
                $this->session->set_tempdata('message', 99, 60);
            }

            header('Location: /administration/courses');
        }

        // Получение списка добавленных курсов
        $result = $this->Course_model->getCourses();

        // Объединенные данные страница
        $this->page_data['title'] = 'АП - Курсы';
        $this->page_data['page_menu'] = 'a_courses';

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('course/settings/courses', $result);
        $this->load->view('footer/footer');
    }

    /**
     * Форма добавления и обработка данных нового курса
     */
    public function newCourse()
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3) {
            show_404($this->page_url);
        }

        $course_types    = $this->Course_model->getCourseTypes();
        $course_schedule = array();

        // Валидация и сохранение данных
        if ($this->input->post('bt_save_course', true))
        {
            $schedule['workouts'] = array();
            $schedule['update']   = array();
            $schedule['insert']   = array();
            $schedule_workouts    = array();

            // Наименование
            $name = mb_substr(strip_tags($this->input->post('name', true)), 0, 255);

            // Описание
            $description = mb_substr(strip_tags($this->input->post('description', true)), 0, 1000);

            // Стоиомсть курса
            $price = is_numeric($this->input->post('price', true)) ? $this->input->post('price', true) : '';
            $fc_price = is_numeric($this->input->post('fc_price', true)) ? $this->input->post('fc_price', true) : '';

            // Тип курса
            $type = $this->input->post('s_course_type', true);
            $course_type = is_numeric($type) and in_array($type, $course_types['types_id']) ? $type : '';

            // Длительность курса
            $count_weeks = (is_numeric($this->input->post('count_weeks', true)) and 52 >= $this->input->post('count_weeks', true))
                ? $this->input->post('count_weeks', true) : 1;

            // Количество тренировок в неделю
            $count_days = (is_numeric($this->input->post('count_days', true)) and 7 >= $this->input->post('count_days', true))
                ? $this->input->post('count_days', true) : 1;

            // Отдых между тренировками
            $count_rest = (is_numeric($this->input->post('s_count_rest', true)) and 3 >= $this->input->post('s_count_rest', true))
                ? $this->input->post('s_count_rest', true) : 0;

            // Тренеры курса
            $couches = array();
            if (!empty($this->input->post('couches', true))) {
                $input_couches = $this->input->post('couches', true);
                $percent       = $this->input->post('couches_percent', true);

                // Добавление или изменение данных тренера
                foreach ($input_couches as $key => $couch) {
                    if (is_numeric($couch)) {
                        // Поиск в массиве сохраненных тренеров
                        $search_key = !empty($course_couches) ? array_search($couch, $course_couches['id']) : false;
                        // Если нашел тренера и значения процента отличаются, обновить данные
                        if (is_numeric($search_key) and $course_couches['percent'][$search_key] != $percent[$key]) {
                            $couches['update'][$couch] = $percent[$key];
                        }
                        // Если не нашел тренера, добавить данные
                        elseif ($search_key === false) {
                            $couches['insert'][$couch] = $percent[$key];
                        }
                    }
                }
                unset($couch);

                // Удаление тренеров
                $couches['delete'] = !empty($course_couches['id']) ? array_diff($course_couches['id'], $input_couches) : '';
            }
            else {
                // Удаление тренеров
                $couches['delete'] = !empty($course_couches['id']) ? $course_couches['id'] : '';
            }

            // Инструктаж
            $instruction = is_numeric($this->input->post('video_instruction', true)) ? $this->input->post('video_instruction', true) : 0;
            $schedule['workouts'][0]['video_id'] = $instruction;
            $schedule['workouts'][0]['repeat_workout'] = 0;
            $schedule['workouts'][0]['description'] = '';
            // Обновляем или добавляем видео инструктажа курса, как нулевая тренировка
            if (!empty($course_schedule['video_id'][0]) and $course_schedule['video_id'][0] != $schedule['workouts'][0]['video_id'])
            {
                $schedule['update'][0] = $schedule['workouts'][0];
            }
            elseif (empty($course_schedule['video_id'][0]))
            {
                $schedule['insert'][0] = $schedule['workouts'][0];
            }

            // Заполнение занятий
            $workout = 1;
            $count_workouts    = $count_weeks * $count_days;
            $id_video          = $this->input->post('id_video');
            $cb_repeat_workout = $this->input->post('cb_repeat_workout');
            $s_repeat_workout  = $this->input->post('s_repeat_workout');
            $ta_workout_desc   = $this->input->post('ta_workout_desc');

            for ($w = 0; $w < $count_workouts; $w++) {
                $repeat_workout = (!empty($cb_repeat_workout[$workout]) and is_numeric($s_repeat_workout[$workout]))
                    ? $s_repeat_workout[$workout] : 0;


                if ($repeat_workout != 0) {
                    $schedule['workouts'][$workout]['repeat_workout'] = $repeat_workout;
                    $schedule['workouts'][$workout]['video_id'] = 0;
                }
                else {
                    $schedule['workouts'][$workout]['repeat_workout'] = 0;
                    $schedule['workouts'][$workout]['video_id'] = (!empty($id_video[$workout]) and is_numeric($id_video[$workout]))
                        ? $id_video[$workout]
                        : 0;
                }

                $schedule['workouts'][$workout]['description'] = !empty($ta_workout_desc[$workout])
                    ? mb_substr(strip_tags($ta_workout_desc[$workout]), 0, 255)
                    : '';

                $sw = $schedule['workouts'][$workout];

                // Поиск в массиве сохраненных тренировок
                $search_key = !empty($course_schedule) ? array_search($workout, $course_schedule['num_workout']) : false;
                // Если нашел тренировку и хотя бы одно значение данных отличается, обновить данные
                if (is_numeric($search_key) and ($course_schedule['repeat_workout'][$search_key] != $sw['repeat_workout']
                        or $course_schedule['description'][$search_key] != $sw['description']
                        or $course_schedule['video_id'][$search_key] != $sw['video_id'])) {

                    $schedule['update'][$workout] = $sw;
                }
                // Если не нашел тренировку, добавить данные
                elseif ($search_key === false) {
                    $schedule['insert'][$workout] = $sw;
                }

                $schedule_workouts[$workout] = $workout;

                $workout++;
            }
            // Удаление тренировок
            $schedule['delete'] = !empty($course_schedule['num_workout']) ? array_diff($course_schedule['num_workout'], $schedule_workouts) : '';

            if (!empty($name) and !empty($description) and !empty($price) and !empty($course_type)) {
                $course_id = $this->Course_model->setNewCourse($name, $description, $price, $fc_price, $course_type, $count_weeks,
                    $count_days, $count_rest, $this->user_id, $this->date);
            }

            if (!empty($course_id) and is_numeric($course_id)) {
                // Сохранение изображения курса
                $img_path = './course_files/' . $course_id . '/';

                if (!file_exists($img_path)) {
                    chdir('course_files');
                    if (!is_dir($course_id)) {
                        mkdir($course_id);
                    }
                    chmod($course_id, 0777);
                    chdir($course_id);
                    chdir('../../');
                }

                $course_image = '';
                if (is_uploaded_file($_FILES['course_image']['tmp_name'])) {
                    $image = parent::uploadImage('course_image', $_FILES['course_image']['type'], $img_path);
                    $full_path_img = $img_path . $image;
                    if (file_exists($full_path_img)) {
                        if ($this->security->xss_clean($full_path_img, TRUE) !== FALSE) {
                            $course_image = $full_path_img;
                        } else {
                            unlink($full_path_img);
                        }
                    }
                }
                $this->Course_model->setCourseImage($course_id, $course_image);

                // Добавление, изменени и/или удаление тренировок курса
                $result_schedule = $this->Course_model->setCourseSchedule($course_id, $schedule, $this->user_id, $this->date);
                // Добавление, изменение и/или удаление тренеров курса
                $result_couches  = $this->Course_model->setCourseCouches($course_id, $couches, $this->date);

                // Курс сохранен
                $this->session->set_tempdata('message', 10, 60);

                header('Location: /administration/course/'.$course_id);
            }
            else {
                // Курс не сохранены
                $this->session->set_tempdata('message', 30, 60);
                header('Location: /administration/course/new');
            }
            /*if ($result_settings === true and $result_schedule === true) {
                // Изменения сохранены
                $this->session->set_tempdata('message', 10, 60);
            }
            elseif ($result_settings === false and $result_schedule === true) {
                // Изменения не сохранены
                $this->session->set_tempdata('message', 30, 60);
            }
            elseif ($result_schedule === false and $result_settings === true) {
                    // Изменения не сохранены
                    $this->session->set_tempdata('message', 31, 60);
                } else {
                    // Изменения не сохранены
                    $this->session->set_tempdata('message', 32, 60);
                }*/
        }

        // Объединенные данные страница
        $this->page_data['title'] = 'АП - Добавление нового курса';
        $this->page_data['page_menu'] = 'a_courses';
        
        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('course/settings/new_course', $course_types);
        $this->load->view('footer/footer');
    }

    /**
     * Вывод данных и сохраненение изменений курса
     *
     * @param $course_id
     * @param string $page_type (settings, landing, statistics, reviews, review)
     * @param int|null $review_id
     * @return void
     */
    public function course($course_id, $page_type = 'settings', $review_id = null)
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3) {
            show_404($this->page_url);
        }

        if ($page_type == 'settings')
        {
            self::courseSettings($course_id);
        }
        elseif ($page_type == 'landing')
        {
            self::courseLanding($course_id);
        }
        elseif ($page_type == 'statistics')
        {
            self::courseStatistics($course_id);
        }
        elseif ($page_type == 'reviews')
        {
            self::courseReviews($course_id);
        }
        elseif ($page_type == 'review' and is_numeric($review_id))
        {
            self::courseReview($course_id, $review_id);
        }
        elseif($page_type == 'video_promo')
        {
            self::coursePromoVideo($course_id);
        }
        elseif($page_type == 'video_workouts')
        {
            self::courseWorkoutVideo($course_id);
        }
        elseif($page_type == 'video_instructions')
        {
            self::courseInstructionsVideo($course_id);
        }
        elseif($page_type == 'video_new')
        {
            self::newCourseVideo($course_id);
        }
    }

    /**
     * Редактирование и сохранение настроек курса
     *
     * @param $course_id
     */
    protected function courseSettings($course_id)
    {
        $course_types    = $this->Course_model->getCourseTypes();
        $course          = $this->Course_model->getCourse($course_id);

        $course_couches  = $this->Course_model->getCourseCouchesId($course_id);
        $course_schedule = $this->Course_model->getCourseSchedule($course_id);

        // Валидация и сохранение данных
        if ($this->input->post('bt_save_course', true))
        {
            $course = $course['course'];
            $img_path = './course_files/' . $course_id . '/';
            $schedule['workouts'] = array();
            $schedule['update']   = array();
            $schedule['insert']   = array();
            $schedule_workouts    = array();

            if (!file_exists($img_path)) {
                chdir('course_files');
                if (!is_dir($course_id)) {
                    mkdir($course_id);
                }
                chmod($course_id, 0777);
                chdir($course_id);
                chdir('../../');
            }

            $course_image = '.' . $course['image'];
            if (is_uploaded_file($_FILES['course_image']['tmp_name'])) {
                $image = parent::uploadImage('course_image', $_FILES['course_image']['type'], $img_path);
                $full_path_img = $img_path . $image;
                if (file_exists($full_path_img)) {
                    if ($this->security->xss_clean($full_path_img, TRUE) !== FALSE) {
                        $course_image = $full_path_img;
                    } else {
                        unlink($full_path_img);
                    }
                }
            }

            // Наименование
            $name = mb_substr(strip_tags($this->input->post('name', true)), 0, 255);

            // Описание
            $description = mb_substr(strip_tags($this->input->post('description', true)), 0, 1000);

            // Стоиомсть курса
            $price = is_numeric($this->input->post('price', true)) ? $this->input->post('price', true) : '';
            $fc_price = is_numeric($this->input->post('fc_price', true)) ? $this->input->post('fc_price', true) : '';

            // Рекуррентная стоимость
            $recur_price      = is_numeric($this->input->post('i_recurrent_price', true)) ? $this->input->post('i_recurrent_price', true) : '';
            $recur_months     = is_numeric($this->input->post('s_recurrent_months', true)) ? $this->input->post('s_recurrent_months', true) : '';
            $recur_first      = is_numeric($this->input->post('i_recurrent_first', true)) ? $this->input->post('i_recurrent_first', true) : '';
            $recur_subsequent = '';
            if (!empty($recur_price) and !empty($recur_months) and !empty($recur_first))
            {
                $num_month = $recur_months - 1;
                $month_price = ($recur_price - $recur_first) / $num_month;
                $recur_subsequent = number_format($month_price, 2, '.', '');
            }

            // Тип курса
            $type = $this->input->post('s_course_type', true);
            $course_type = is_numeric($type) and in_array($type, $course_types['types_id']) ? $type : '';

            // Длительность курса
            $count_weeks = (is_numeric($this->input->post('count_weeks', true)) and 52 >= $this->input->post('count_weeks', true))
                ? $this->input->post('count_weeks', true) : '';

            // Количество тренировок в неделю
            $count_days = (is_numeric($this->input->post('count_days', true)) and 7 >= $this->input->post('count_days', true))
                ? $this->input->post('count_days', true) : '';

            // Отдых между тренировками
            $count_rest = (is_numeric($this->input->post('s_count_rest', true)) and 3 >= $this->input->post('s_count_rest', true))
                ? $this->input->post('s_count_rest', true) : 0;

            // Тренеры курса
            $couches = array();
            if (!empty($this->input->post('couches', true))) {
                $input_couches = $this->input->post('couches', true);
                $percent       = $this->input->post('couches_percent', true);

                // Добавление или изменение данных тренера
                foreach ($input_couches as $key => $couch) {
                    if (is_numeric($couch)) {
                        // Поиск в массиве сохраненных тренеров
                        $search_key = !empty($course_couches) ? array_search($couch, $course_couches['id']) : false;
                        // Если нашел тренера и значения процента отличаются, обновить данные
                        if (is_numeric($search_key) and $course_couches['percent'][$search_key] != $percent[$key]) {
                            $couches['update'][$couch] = $percent[$key];
                        }
                        // Если не нашел тренера, добавить данные
                        elseif ($search_key === false) {
                            $couches['insert'][$couch] = $percent[$key];
                        }
                    }
                }
                unset($couch);

                // Удаление тренеров
                $couches['delete'] = !empty($course_couches['id']) ? array_diff($course_couches['id'], $input_couches) : '';
            }
            else {
                // Удаление тренеров
                $couches['delete'] = !empty($course_couches['id']) ? $course_couches['id'] : '';
            }

            // Инструктаж
            $db_instruction = (!empty($course['instruction']) and $course['instruction']['video_id'] > 0) ? $course['instruction']['video_id'] : false;
            $instruction = is_numeric($this->input->post('video_instruction', true)) ? $this->input->post('video_instruction', true) : 0;
            $schedule['workouts'][0]['video_id'] = $instruction;
            $schedule['workouts'][0]['repeat_workout'] = 0;
            $schedule['workouts'][0]['description'] = '';
            $schedule_workouts[0] = 0;
            // Обновляем или добавляем видео инструктажа курса, как нулевая тренировка
            if ($db_instruction !== false and $db_instruction != $instruction)
            {
                $schedule['update'][0] = $schedule['workouts'][0];
            }
            elseif ($db_instruction === false and $instruction != 0)
            {
                $schedule['insert'][0] = $schedule['workouts'][0];
            }

            // Заполнение занятий
            $workout = 1;
            $count_workouts    = $count_weeks * $count_days;
            $id_video          = $this->input->post('id_video');
            $cb_repeat_workout = $this->input->post('cb_repeat_workout');
            $s_repeat_workout  = $this->input->post('s_repeat_workout');
            $ta_workout_desc   = $this->input->post('ta_workout_desc');

            for ($w = 0; $w < $count_workouts; $w++)
            {
                $repeat_workout = (!empty($cb_repeat_workout[$workout]) and is_numeric($s_repeat_workout[$workout]))
                    ? $s_repeat_workout[$workout] : 0;

                if ($repeat_workout != 0)
                {
                    $schedule['workouts'][$workout]['repeat_workout'] = $repeat_workout;
                    $schedule['workouts'][$workout]['video_id'] = 0;
                }
                else
                {
                    $schedule['workouts'][$workout]['repeat_workout'] = 0;
                    $schedule['workouts'][$workout]['video_id'] = is_numeric($id_video[$workout]) ? $id_video[$workout] : 0;
                }

                $schedule['workouts'][$workout]['description'] = mb_substr(strip_tags($ta_workout_desc[$workout]), 0, 255);

                $sw = $schedule['workouts'][$workout];

                // Поиск в массиве сохраненных тренировок
                $search_key = !empty($course_schedule) ? array_search($workout, $course_schedule['num_workout']) : false;

                // Если нашел тренировку и хотя бы одно значение данных отличается, обновить данные
                if (is_numeric($search_key) and ($course_schedule['repeat_workout'][$search_key] != $sw['repeat_workout']
                        or $course_schedule['description'][$search_key] != $sw['description']
                        or $course_schedule['video_id'][$search_key] != $sw['video_id']))
                {

                    $schedule['update'][$workout] = $sw;
                }
                // Если не нашел тренировку, добавить данные
                elseif ($search_key === false)
                {
                    $schedule['insert'][$workout] = $sw;
                }

                $schedule_workouts[$workout] = $workout;

                $workout++;
            }
            // Удаление тренировок
            $schedule['delete'] = !empty($course_schedule['num_workout']) ? array_diff($course_schedule['num_workout'], $schedule_workouts) : '';


            /* СОХРАНЕНИЕ ИЗМНЕНИЙ */
            $result_settings  = null;
            $result_recurrent = null;
            $result_schedule  = null;
            $result_couches   = null;

            // Сохранение основных данных курса
            if ($name != $course['name'] or $description != $course['description'] or $price != $course['price'] or $course_type != $course['type']
                or $count_weeks != $course['count_weeks'] or $count_days != $course['count_days'] or $count_rest != $course['count_rest']
                or $course_image != ('.' . $course['image'])) {

                $result_settings = $this->Course_model->setCourseSettings($course_id, $course_image, $name, $description, $price, $fc_price,
                    $course_type, $count_weeks, $count_days, $count_rest, $this->date);
            }

            // Сохранение данных рекуррентной цены
            if ($recur_price != $course['recur_price'] or $recur_months != $course['recur_months']
                or $recur_first != $course['recur_first'] or $recur_subsequent != $course['recur_subsequent'])
            {
                $result_recurrent = $this->Course_model->setCourseRecurrentPrice($course_id, $recur_price, $recur_months, $recur_first, $recur_subsequent, $this->date);
            }

            // Добавление, изменени и/или удаление тренировок курса
            if (!empty($schedule['insert']) or !empty($schedule['update']) or !empty($schedule['delete']))
            {
                $result_schedule = $this->Course_model->setCourseSchedule($course_id, $schedule, $this->user_id, $this->date);
            }

            // Добавление, изменение и/или удаление тренеров курса
            if (!empty($couches['insert']) or !empty($couches['update']) or !empty($couches['delete']))
            {
                $result_couches = $this->Course_model->setCourseCouches($course_id, $couches, $this->date);
            }

            /* ВЫВОД ИНФОРМАЦИИ О СОХРАНЕНИИ ИЗМЕНЕНИЙ */
            if ($result_settings === true and $result_schedule === true and $result_recurrent === true
                and $result_couches === true)
            {
                // Изменения сохранены
                $this->session->set_tempdata('message', 10, 60);
            }
            elseif($result_settings === false and $result_schedule === false and $result_recurrent === false
                and $result_couches === false)
            {
                // Изменения не сохранены
                $this->session->set_tempdata('message', 73, 60);
            }
            elseif($result_settings === false or $result_schedule === false or $result_recurrent === false
                or $result_couches === false)
            {
                // Основные данные не сохранены
                $this->session->set_tempdata('message', 130, 60);
                log_message('debug', 'Не все данные курса сохранены. POST data: ' . print_r($this->input->post(), true));
            }

            header('Location: /administration/course/'.$course_id);
        }
        elseif ($this->input->post('bt_block_course', true)) {
            $result = $this->Course_model->blockCourse($course_id, $this->date);

            if ($result === true) {
                // Изменения сохранены
                $this->session->set_tempdata('message', 10, 60);
            } else {
                // Изменения не сохранены
                $this->session->set_tempdata('message', 33, 60);
            }
            header('Location: /administration/course/' . $course_id);
        }
        elseif ($this->input->post('bt_unblock_course', true)) {
            $result = $this->Course_model->unblockCourse($course_id, $this->date);

            if ($result === true) {
                // Изменения сохранены
                $this->session->set_tempdata('message', 10, 60);
            } else {
                // Изменения не сохранены
                $this->session->set_tempdata('message', 34, 60);
            }
            header('Location: /administration/course/' . $course_id);
        }
        elseif ($this->input->post('bt_delete_course', true)) {
            if ($course['course']['bought'] === false) {
                // Удалить курс
                $del_course = $this->Course_model->deleteCourse($course_id);

                if ($del_course === true) {
                    // Курс удален
                    $this->session->set_tempdata('message', 108, 60);
                    header('Location: /administration/courses/');
                }
                else {
                    // Не удалось удалить курс
                    $this->session->set_tempdata('message', 107, 60);
                    header('Location: /administration/course/' . $course_id);
                }
            }
            else {
                // Не возможно удалить курс (куплен пользователем)
                $this->session->set_tempdata('message', 106, 60);
                header('Location: /administration/course/' . $course_id);
            }
        }

        $result = array_merge($course_types, $course);

        // Объединенные данные страница
        $this->page_data['title'] = 'АП - Редактирование данных курса';
        $this->page_data['page_menu'] = 'a_courses';
        $this->page_data['page_submenu'] = 'settings';
        $this->page_data['course_id'] = $course_id;

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('course/settings/course', $result);
        $this->load->view('footer/footer');
    }

    /**
     * Редактирование и сохранение Landing page курса
     *
     * @param $course_id
     */
    protected function courseLanding($course_id)
    {
        $course_landing  = $this->Course_model->getCourseLandingPage($course_id);
        $landing_list    = $this->Course_model->getLandingPagesList();
        $course          = $this->Course_model->getShortCourse($course_id);

        $landing = $course_landing['landing'];

        // Регулярное выражения для проверки корректности значения hex цвета
        $regexp_color = '/^\#([a-f0-9]){3}(([a-f0-9]){3})?$/i';
        $img_path     = './landing/' . $course_id . '/';
        if (!file_exists($img_path)) {
            chdir('landing');
            if (!is_dir($course_id)) {
                mkdir($course_id);
            }
            chmod($course_id, 0777);
            chdir($course_id);
            chdir('../../');
        }

        if ($this->input->post('bt_save_landing', true))
        {
            // Стиль
            $landing_style = in_array($this->input->post('s_land_type', true), $landing_list['landings_id'])
                ? $this->input->post('s_land_type', true) : 1;

            // Слайдер (max 7 images)
            $slider_images = '';
            if ($this->input->post('cb_slider_block1', true)) {
                $slider_images = 'default';
            }
            else {
                $input_files = $_FILES;
                $i = 0;
                foreach ($input_files['slider_files']['name'] as $name) {

                    $_FILES['slider_files'] = array(
                        'name' => $input_files['slider_files']['name'][$i],
                        'type' => $input_files['slider_files']['type'][$i],
                        'tmp_name' => $input_files['slider_files']['tmp_name'][$i],
                        'error' => $input_files['slider_files']['error'][$i],
                        'size' => $input_files['slider_files']['size'][$i]);

                    if (!empty($_FILES['slider_files']) and is_uploaded_file($_FILES['slider_files']['tmp_name'])) {
                        $image = parent::uploadImage('slider_files', $_FILES['slider_files']['type'], $img_path);
                        $full_path_img = $img_path . $image;
                        if (file_exists($full_path_img)) {
                            if ($this->security->xss_clean($full_path_img, TRUE) !== FALSE) {
                                $slider_image = $full_path_img . ';';
                            } else {
                                unlink($full_path_img);
                            }
                        }
                    }

                    $slider_images .= !empty($slider_image) ? $slider_image : '';

                    $i++;

                    if ($i == 7) {
                        break;
                    }
                }
            }
            if (empty($slider_images)) {
                $slider_images = (!empty($landing['slider_images']) and $landing['slider_images'] != 'default')
                    ? implode(";", array_walk($landing['slider_images'], 'add_dot'))
                    : 'default';
            }

            // Заголовк страницы
            $main_title_bbcode = mb_substr(strip_tags($this->input->post('ta_main_title'), '<span><br/><b><i>'), 0, 255);

            // БЛОК 2
            // Фон
            $b2_bg = (!empty($landing['block2']['bg_orig']) and $landing['block2']['bg_default'] != 'default')
                ? $landing['block2']['bg_orig']
                : 'default'; // Фон по-умолчанию
            if (empty($this->input->post('cb_default_bg_block2', true))) {
                // Фон либо цвет, либо файл изображения
                $color = $this->input->post('i_bg_color_block2', true);
                if (!empty($color) and preg_match($regexp_color, $color)) {
                    $b2_bg = $color;
                }
                elseif (is_uploaded_file($_FILES['bg_file_block2']['tmp_name'])) {
                    $image = parent::uploadImage('bg_file_block2', $_FILES['bg_file_block2']['type'], $img_path);
                    $full_path_img = $img_path . $image;
                    if (file_exists($full_path_img)) {
                        if ($this->security->xss_clean($full_path_img, TRUE) !== FALSE) {
                            $b2_bg = $full_path_img;
                        } else {
                            unlink($full_path_img);
                        }
                    }
                }
            }
            else { $b2_bg = 'default'; }

            // Изображение тренера
            $b2_image = (!empty($landing['block2']['image']) and $landing['block2']['image'] != 'default')
                ? '.' . $landing['block2']['image']
                : 'default';
            if (empty($this->input->post('cb_couch_image_block2', true))) {
                if (is_uploaded_file($_FILES['couch_file_block2']['tmp_name'])) {
                    $image = parent::uploadImage('couch_file_block2', $_FILES['couch_file_block2']['type'], $img_path);
                    $full_path_img = $img_path . $image;
                    if (file_exists($full_path_img)) {
                        if ($this->security->xss_clean($full_path_img, TRUE) !== FALSE) {
                            $b2_image = $full_path_img;
                        } else {
                            unlink($full_path_img);
                        }
                    }
                }
            }
            else { $b2_image = 'default'; }

            // Информация
            $b2_title    = mb_substr(strip_tags($this->input->post('i_title_block2', true)), 0, 60);
            $b2_subtitle = mb_substr(strip_tags($this->input->post('i_subtitle_block2', true)), 0, 70);
            $b2_text     = mb_substr(strip_tags($this->input->post('i_text_block2', true)), 0, 60);
            $b2_button   = mb_substr(strip_tags($this->input->post('i_button_block2', true)), 0, 40);

            // БЛОК 3
            // Фон
            $b3_bg = (!empty($landing['block3']['bg_orig']) and $landing['block3']['bg_default'] != 'default')
                ? $landing['block3']['bg_orig']
                : 'default'; // Фон по-умолчанию
            if (empty($this->input->post('cb_default_bg_block3', true))) {
                // Фон либо цвет, либо файл изображения
                $color = $this->input->post('i_bg_color_block3', true);
                if (!empty($color) and preg_match($regexp_color, $color)) {
                    $b3_bg = $color;
                } elseif (is_uploaded_file($_FILES['bg_file_block3']['tmp_name'])) {
                    $image = parent::uploadImage('bg_file_block3', $_FILES['bg_file_block3']['type'], $img_path);
                    $full_path_img = $img_path . $image;
                    if (file_exists($full_path_img)) {
                        if ($this->security->xss_clean($full_path_img, TRUE) !== FALSE) {
                            $b3_bg = $full_path_img;
                        } else {
                            unlink($full_path_img);
                        }
                    }
                }
            }
            else { $b3_bg = 'default'; }

            $b3_images = (!empty($landing['block3']['images'][0]) and $landing['block3']['images'][0] != 'default')
                ? '.' . $landing['block3']['images'][0] . ';'
                : 'default;';
            // Изображение 1
            if (empty($this->input->post('cb_photo1_block3', true))){
                if (is_uploaded_file($_FILES['result_file1_block3']['tmp_name'])) {
                    $image = parent::uploadImage('result_file1_block3', $_FILES['result_file1_block3']['type'], $img_path);
                    $full_path_img = $img_path . $image;
                    if (file_exists($full_path_img)) {
                        if ($this->security->xss_clean($full_path_img, TRUE) !== FALSE) {
                            $b3_images = $full_path_img . ';';
                        } else {
                            unlink($full_path_img);
                        }
                    }
                }
            }
            else { $b3_images = 'default;'; }

            // Изображение 2
            if (empty($this->input->post('cb_photo2_block3', true))) {
                $img1 = (!empty($landing['block3']['images'][1]) and $landing['block3']['images'][1] != 'default')
                    ? '.' . $landing['block3']['images'][1] . ';'
                    : 'default;';
                if (is_uploaded_file($_FILES['result_file2_block3']['tmp_name'])) {
                    $image = parent::uploadImage('result_file2_block3', $_FILES['result_file2_block3']['type'], $img_path);
                    $full_path_img = $img_path . $image;
                    if (file_exists($full_path_img)) {
                        if ($this->security->xss_clean($full_path_img, TRUE) !== FALSE) {
                            $full_path_img = $full_path_img . ';';
                        } else {
                            unlink($full_path_img);
                            $full_path_img = $img1;
                        }
                    } else {
                        $full_path_img = $img1;
                    }
                } else {
                    $full_path_img = $img1;
                }
                $b3_images .= $full_path_img;
            }
            else { $b3_images .= 'default;'; }

            // Информация
            $b3_title    = mb_substr(strip_tags($this->input->post('i_title_block3', true)), 0, 60);
            $b3_subtitle = mb_substr(strip_tags($this->input->post('i_subtitle_block3', true)), 0, 60);

            // Результаты
            $b3_r_title    = mb_substr(strip_tags($this->input->post('i_result_title_block3', true)), 0, 60);
            $b3_r_subtitle = mb_substr(strip_tags($this->input->post('i_result_subtitle_block3', true)), 0, 60);
            $b3_r_reviews  = mb_substr(strip_tags($this->input->post('i_result_reviews_block3', true)), 0, 80);

            // БЛОК 4
            // Фон
            $b4_bg = (!empty($landing['block4']['bg_orig']) and $landing['block4']['bg_default'] != 'default')
                ? $landing['block4']['bg_orig']
                : 'default'; // Фон по-умолчанию
            if (empty($this->input->post('cb_default_bg_block4', true))) {
                // Фон либо цвет, либо файл изображения
                $color = $this->input->post('i_bg_color_block4', true);
                if (!empty($color) and preg_match($regexp_color, $color)) {
                    $b4_bg = $color;
                } elseif (is_uploaded_file($_FILES['bg_file_block4']['tmp_name'])) {
                    $image = parent::uploadImage('bg_file_block4', $_FILES['bg_file_block4']['type'], $img_path);
                    $full_path_img = $img_path . $image;
                    if (file_exists($full_path_img)) {
                        if ($this->security->xss_clean($full_path_img, TRUE) !== FALSE) {
                            $b4_bg = $full_path_img;
                        } else {
                            unlink($full_path_img);
                        }
                    }
                }
            }
            else { $b4_bg = 'default'; }

            // Изображение
            $b4_image = (!empty($landing['block4']['image']) and $landing['block4']['image'] != 'default')
                ? '.' . $landing['block4']['image']
                : 'default';
            if (empty($this->input->post('cb_photo_block4', true))) {
                if (is_uploaded_file($_FILES['result_file_block4']['tmp_name'])) {
                    $image = parent::uploadImage('result_file_block4', $_FILES['result_file_block4']['type'], $img_path);
                    $full_path_img = $img_path . $image;
                    if (file_exists($full_path_img)) {
                        if ($this->security->xss_clean($full_path_img, TRUE) !== FALSE) {
                            $b4_image = $full_path_img;
                        } else {
                            unlink($full_path_img);
                        }
                    }
                }
            }
            else { $b4_image = 'default'; }

            // Информация
            $b4_title    = mb_substr(strip_tags($this->input->post('i_title_block4', true)), 0, 60);
            $b4_subtitle = mb_substr(strip_tags($this->input->post('i_subtitle_block4', true)), 0, 80);
            $b4_button   = mb_substr(strip_tags($this->input->post('i_button_block4', true)), 0, 40);

            // Результат
            $b4_r_title = mb_substr(strip_tags($this->input->post('i_result_title_block4', true)), 0, 60);
            $b4_r_desc  = mb_substr(strip_tags($this->input->post('i_result_desc_block4', true)), 0, 60);

            // БЛОК 5
            // Фон
            $b5_bg = (!empty($landing['block5']['bg_orig']) and $landing['block5']['bg_default'] != 'default')
                ? $landing['block5']['bg_orig']
                : 'default'; // Фон по-умолчанию
            if (empty($this->input->post('cb_default_bg_block5', true))) {
                // Фон либо цвет, либо файл изображения
                $color = $this->input->post('i_bg_color_block5', true);
                if (!empty($color) and preg_match($regexp_color, $color)) {
                    $b5_bg = $color;
                } elseif (is_uploaded_file($_FILES['bg_file_block5']['tmp_name'])) {
                    $image = parent::uploadImage('bg_file_block5', $_FILES['bg_file_block5']['type'], $img_path);
                    $full_path_img = $img_path . $image;
                    if (file_exists($full_path_img)) {
                        if ($this->security->xss_clean($full_path_img, TRUE) !== FALSE) {
                            $b5_bg = $full_path_img;
                        } else {
                            unlink($full_path_img);
                        }
                    }
                }
            }
            else { $b5_bg = 'default'; }

            $b5_images = (!empty($landing['block5']['images'][0]) and $landing['block5']['images'][0] != 'default')
                ? '.' . $landing['block5']['images'][0] . ';'
                : 'default;';
            // Боковое фото 1
            if (empty($this->input->post('cb_photo1_block5', true))) {
                if (is_uploaded_file($_FILES['couch_file1_block5']['tmp_name'])) {
                    $image = parent::uploadImage('couch_file1_block5', $_FILES['couch_file1_block5']['type'], $img_path);
                    $full_path_img = $img_path . $image;
                    if (file_exists($full_path_img)) {
                        if ($this->security->xss_clean($full_path_img, TRUE) !== FALSE) {
                            $b5_images = $full_path_img . ';';
                        } else {
                            unlink($full_path_img);
                        }
                    }
                }
            }
            else { $b5_images = 'default;'; }

            // Боковое фото 2
            if (empty($this->input->post('cb_photo2_block5', true))) {
                $img1 = !empty($landing['block5']['images'][1]) and $landing['block5']['images'][1] != 'default'
                    ? '.' . $landing['block5']['images'][1] . ';'
                    : 'default;';
                if (is_uploaded_file($_FILES['couch_file2_block5']['tmp_name'])) {
                    $image = parent::uploadImage('couch_file2_block5', $_FILES['couch_file2_block5']['type'], $img_path);
                    $full_path_img = $img_path . $image;
                    if (file_exists($full_path_img)) {
                        if ($this->security->xss_clean($full_path_img, TRUE) !== FALSE) {
                            $full_path_img = $full_path_img . ';';
                        } else {
                            unlink($full_path_img);
                            $full_path_img = $img1;
                        }
                    } else {
                        $full_path_img = $img1;
                    }
                } else {
                    $full_path_img = $img1;
                }
                $b5_images .= $full_path_img;
            }
            else { $b5_images .= 'default;'; }

            // Аватар
            if (empty($this->input->post('cb_photo3_block5', true))) {
                $img2 = !empty($landing['block5']['images'][2]) and $landing['block5']['images'][2] != 'default'
                    ? '.' . $landing['block5']['images'][2] . ';'
                    : 'default;';
                if (is_uploaded_file($_FILES['couch_avatar_block5']['tmp_name'])) {
                    $image = parent::uploadImage('couch_avatar_block5', $_FILES['couch_avatar_block5']['type'], $img_path);
                    $full_path_img = $img_path . $image;
                    if (file_exists($full_path_img)) {
                        if ($this->security->xss_clean($full_path_img, TRUE) !== FALSE) {
                            $full_path_img = $full_path_img . ';';
                        } else {
                            unlink($full_path_img);
                            $full_path_img = $img2;
                        }
                    } else {
                        $full_path_img = $img2;
                    }
                } else {
                    $full_path_img = $img2;
                }
                $b5_images .= $full_path_img;
            }
            else { $b5_images .= 'default;'; }

            // Информация
            $b5_title    = mb_substr(strip_tags($this->input->post('i_title_block5', true)), 0, 60);
            $b5_subtitle = mb_substr(strip_tags($this->input->post('i_subtitle_block5', true)), 0, 60);
            $b5_text     = mb_substr(strip_tags($this->input->post('i_text_block5', true)), 0, 255);
            $b5_button   = mb_substr(strip_tags($this->input->post('i_button_block5', true)), 0, 40);

            // Слова тренера о программе
            $b5_r_title    = mb_substr(strip_tags($this->input->post('i_couch_title_block5', true)), 0, 50);
            $b5_r_subtitle = mb_substr(strip_tags($this->input->post('i_couch_subtitle_block5', true)), 0, 50);
            $b5_r_text     = mb_substr(strip_tags($this->input->post('i_couch_text_block5', true)), 0, 120);

            // БЛОК 6
            // Фон
            $b6_bg = (!empty($landing['block6']['bg_orig']) and $landing['block6']['bg_default'] != 'default')
                ? $landing['block6']['bg_orig']
                : 'default'; // Фон по-умолчанию
            if (empty($this->input->post('cb_default_bg_block6', true))) {
                // Фон либо цвет, либо файл изображения
                $color = $this->input->post('i_bg_color_block6', true);
                if (!empty($color) and preg_match($regexp_color, $color)) {
                    $b6_bg = $color;
                } elseif (is_uploaded_file($_FILES['bg_file_block6']['tmp_name'])) {
                    $image = parent::uploadImage('bg_file_block6', $_FILES['bg_file_block6']['type'], $img_path);
                    $full_path_img = $img_path . $image;
                    if (file_exists($full_path_img)) {
                        if ($this->security->xss_clean($full_path_img, TRUE) !== FALSE) {
                            $b6_bg = $full_path_img;
                        } else {
                            unlink($full_path_img);
                        }
                    }
                }
            }
            else { $b6_bg = 'default'; }

            // Боковое фото
            $b6_image = (!empty($landing['block6']['image']) and $landing['block6']['image'] != 'default')
                ? '.' . $landing['block6']['image']
                : 'default';
            if (empty($this->input->post('cb_photo_block6', true))) {
                if (is_uploaded_file($_FILES['file_block6']['tmp_name'])) {
                    $image = parent::uploadImage('file_block6', $_FILES['file_block6']['type'], $img_path);
                    $full_path_img = $img_path . $image;
                    if (file_exists($full_path_img)) {
                        if ($this->security->xss_clean($full_path_img, TRUE) !== FALSE) {
                            $b6_image = $full_path_img;
                        } else {
                            unlink($full_path_img);
                        }
                    }
                }
            }
            else { $b6_image = 'default'; }

            // Информация
            $b6_title    = mb_substr(strip_tags($this->input->post('i_title_block6', true)), 0, 60);
            $b6_desc     = mb_substr(strip_tags($this->input->post('ta_desc_block6', true)), 0, 130);
            $b6_subtitle = mb_substr(strip_tags($this->input->post('i_subtitle_block6', true)), 0, 60);
            $b6_button   = mb_substr(strip_tags($this->input->post('i_button_block6', true)), 0, 40);

            // Преимущества
            $b6_advantages = '';
            foreach ($this->input->post('i_advantages_block6', true) as $advantage)
            {
                $b6_advantages .= strip_tags($advantage) . ';';
            }
            unset($advantage);

            // БЛОК 7
            // Фон
            $b7_bg = (!empty($landing['block7']['bg_orig']) and $landing['block7']['bg_default'] != 'default')
                ? $landing['block7']['bg_orig']
                : 'default'; // Фон по-умолчанию
            if (empty($this->input->post('cb_default_bg_block7', true))) {
                // Фон либо цвет, либо файл изображения
                $color = $this->input->post('i_bg_color_block7', true);
                if (!empty($color) and preg_match($regexp_color, $color)) {
                    $b7_bg = $color;
                } elseif (is_uploaded_file($_FILES['bg_file_block7']['tmp_name'])) {
                    $image = parent::uploadImage('bg_file_block7', $_FILES['bg_file_block7']['type'], $img_path);
                    $full_path_img = $img_path . $image;
                    if (file_exists($full_path_img)) {
                        if ($this->security->xss_clean($full_path_img, TRUE) !== FALSE) {
                            $b7_bg = $full_path_img;
                        } else {
                            unlink($full_path_img);
                        }
                    }
                }
            }
            else { $b7_bg = 'default'; }

            // Информация
            $b7_title  = mb_substr(strip_tags($this->input->post('i_title_block7', true)), 0, 50);
            $b7_button = mb_substr(strip_tags($this->input->post('i_button_block7', true)), 0, 40);

            // Изображения и текст блока
            $b7_images = '';
            $b7_texts = '';

            $input_files = $_FILES;
            $input_titles = $this->input->post('i_text_block7', TRUE);

            $b7_images_default = false;
            if ($this->input->post('cb_images_block7', TRUE))
            {
                $b7_images_default = true;
            }
            $i = 0;
            foreach ($input_titles as $text)
            {
                $text = mb_substr(strip_tags($text), 0, 160);

                if ($b7_images_default and $i <= 3)
                {
                    $b7_images .= 'default;';
                    $b7_texts  .= $text . ';';
                }
                else
                {
                    $img = !empty($landing['block7']['images'][$i]) and $landing['block7']['images'][$i] != 'default'
                        ? '.' . $landing['block7']['images'][$i] . ';'
                        : 'default;';

                    $_FILES['files_block7'] = array(
                        'name' => $input_files['files_block7']['name'][$i],
                        'type' => $input_files['files_block7']['type'][$i],
                        'tmp_name' => $input_files['files_block7']['tmp_name'][$i],
                        'error' => $input_files['files_block7']['error'][$i],
                        'size' => $input_files['files_block7']['size'][$i]);

                    if (!empty($_FILES['files_block7']) and is_uploaded_file($_FILES['files_block7']['tmp_name']))
                    {
                        $image = parent::uploadImage('files_block7', $_FILES['files_block7']['type'], $img_path);
                        $full_path_img = $img_path . $image;
                        if (file_exists($full_path_img)) {
                            if ($this->security->xss_clean($full_path_img, TRUE) !== FALSE) {
                                $b7_image = $full_path_img . ';';
                            } else {
                                unlink($full_path_img);
                                $b7_image = $img;
                            }
                        } else {
                            $b7_image = $img;
                        }
                    }
                    else
                    {
                        $b7_image = $img;
                    }

                    $b7_images .= $b7_image;
                    $b7_texts  .= $text . ';';
                }

                $i++;
            }
            unset($text);


            // БЛОК 8
            // Фон
            $b8_bg = (!empty($landing['block8']['bg_orig']) and $landing['block8']['bg_default'] != 'default')
                ? $landing['block8']['bg_orig']
                : 'default'; // Фон по-умолчанию
            if (empty($this->input->post('cb_default_bg_block8', true))) {
                // Фон либо цвет, либо файл изображения
                $color = $this->input->post('i_bg_color_block8', true);
                if (!empty($color) and preg_match($regexp_color, $color)) {
                    $b8_bg = $color;
                }
                elseif (is_uploaded_file($_FILES['bg_file_block8']['tmp_name'])) {
                    $image = parent::uploadImage('bg_file_block8', $_FILES['bg_file_block8']['type'], $img_path);
                    $full_path_img = $img_path . $image;
                    if(file_exists($full_path_img)){
                        if ($this->security->xss_clean($full_path_img, TRUE) !== FALSE) {
                            $b8_bg = $full_path_img;
                        } else{
                            unlink($full_path_img);
                        }
                    }
                }
            }
            else { $b8_bg = 'default'; }

            // Информация
            $b8_title    = mb_substr(strip_tags($this->input->post('i_title_block8', true)), 0, 60);
            $b8_desc1    = mb_substr(strip_tags($this->input->post('i_desc1_block8', true)), 0, 160);
            $b8_subtitle = mb_substr(strip_tags($this->input->post('i_subtitle_block8', true)), 0, 60);
            $b8_desc2    = mb_substr(strip_tags($this->input->post('i_desc2_block8', true)), 0, 100);
            $b8_button   = mb_substr(strip_tags($this->input->post('i_button_block8', true)), 0, 40);

            // Информация
            $b8_old_price = is_numeric($this->input->post('i_old_price_block8', true)) ? $this->input->post('i_old_price_block8', true) : '';
            $b8_new_price = is_numeric($this->input->post('i_new_price_block8', true)) ? $this->input->post('i_new_price_block8', true) : '';

            //print_r(get_defined_vars());
            $up_res = $this->Course_model->setCourseLandingPage($course_id, $landing_style, $slider_images, $main_title_bbcode,
                $b2_bg, $b2_image, $b2_title, $b2_subtitle, $b2_text, $b2_button,
                $b3_bg, $b3_images, $b3_title, $b3_subtitle, $b3_r_title, $b3_r_subtitle, $b3_r_reviews,
                $b4_bg, $b4_image, $b4_title, $b4_subtitle, $b4_r_title, $b4_r_desc, $b4_button,
                $b5_bg, $b5_images, $b5_title, $b5_subtitle, $b5_text, $b5_r_title, $b5_r_subtitle, $b5_r_text, $b5_button,
                $b6_bg, $b6_image, $b6_title, $b6_desc, $b6_subtitle, $b6_advantages, $b6_button,
                $b7_bg, $b7_title, $b7_images, $b7_texts, $b7_button,
                $b8_bg, $b8_title, $b8_desc1, $b8_subtitle, $b8_desc2, $b8_old_price, $b8_new_price, $b8_button, $this->date);


            if ($up_res === true) {
                // Изменения сохранены
                $this->session->set_tempdata('message', 10, 60);
            } else {
                // Изменения не сохранены
                $this->session->set_tempdata('message', 112, 60);
            }

            header('Location: /administration/course/'.$course_id.'/landing');
        }
        elseif ($this->input->post('bt_save_block_1', true))
        {
            // Стиль
            $landing_style = in_array($this->input->post('s_land_type', true), $landing_list['landings_id'])
                ? $this->input->post('s_land_type', true) : 1;

            // Слайдер (max 7 images)
            $slider_images = '';
            if ($this->input->post('cb_slider_block1', true)) {
                $slider_images = 'default';
            }
            else {
                $input_files = $_FILES;
                $i = 0;
                foreach ($input_files['slider_files']['name'] as $name) {

                    $_FILES['slider_files'] = array(
                        'name' => $input_files['slider_files']['name'][$i],
                        'type' => $input_files['slider_files']['type'][$i],
                        'tmp_name' => $input_files['slider_files']['tmp_name'][$i],
                        'error' => $input_files['slider_files']['error'][$i],
                        'size' => $input_files['slider_files']['size'][$i]);

                    if (!empty($_FILES['slider_files']) and is_uploaded_file($_FILES['slider_files']['tmp_name'])) {
                        $image = parent::uploadImage('slider_files', $_FILES['slider_files']['type'], $img_path);
                        $full_path_img = $img_path . $image;
                        if (file_exists($full_path_img)) {
                            if ($this->security->xss_clean($full_path_img, TRUE) !== FALSE) {
                                $slider_image = $full_path_img . ';';
                            } else {
                                unlink($full_path_img);
                            }
                        }
                    }

                    $slider_images .= !empty($slider_image) ? $slider_image : '';

                    $i++;

                    if ($i == 7) {
                        break;
                    }
                }
            }
            if (empty($slider_images)) {
                $slider_images = (!empty($landing['slider_images']) and $landing['slider_images'] != 'default')
                    ? implode(";", array_walk($landing['slider_images'], 'add_dot'))
                    : 'default';
            }

            // Заголовк страницы
            $main_title_bbcode = mb_substr(strip_tags($this->input->post('ta_main_title'), '<span><br/><b><i><p>'), 0, 255);

            $up_res = $this->Course_model->setCourseLandingBlock1($course_id, $landing_style, $slider_images, $main_title_bbcode, $this->date);

            if ($up_res === true) {
                // Изменения сохранены
                $this->session->set_tempdata('message', 10, 60);
            } else {
                // Изменения не сохранены
                $this->session->set_tempdata('message', 112, 60);
            }

            header('Location: /administration/course/'.$course_id.'/landing');
        }
        elseif ($this->input->post('bt_save_block_2', true))
        {
            // Стиль
            $landing_style = in_array($this->input->post('s_land_type', true), $landing_list['landings_id'])
                ? $this->input->post('s_land_type', true) : 1;

            //log_message('debug', print_r($_FILES, true));
            // БЛОК 2
            // Фон
            $b2_bg = (!empty($landing['block2']['bg_orig']) and $landing['block2']['bg_default'] != 'default')
                ? $landing['block2']['bg_orig']
                : 'default'; // Фон по-умолчанию
            if (empty($this->input->post('cb_default_bg_block2', true))) {
                // Фон либо цвет, либо файл изображения
                $color = $this->input->post('i_bg_color_block2', true);
                if (!empty($color) and preg_match($regexp_color, $color)) {
                    $b2_bg = $color;
                }
                elseif (is_uploaded_file($_FILES['bg_file_block2']['tmp_name'])) {
                    $image = parent::uploadImage('bg_file_block2', $_FILES['bg_file_block2']['type'], $img_path);
                    $full_path_img = $img_path . $image;
                    if (file_exists($full_path_img)) {
                        if ($this->security->xss_clean($full_path_img, TRUE) !== FALSE) {
                            $b2_bg = $full_path_img;
                        } else {
                            unlink($full_path_img);
                        }
                    }
                }
            }
            else { $b2_bg = 'default'; }

            // Изображение тренера
            $b2_image = (!empty($landing['block2']['image']) and $landing['block2']['image'] != 'default')
                ? '.' . $landing['block2']['image']
                : 'default';
            if (empty($this->input->post('cb_couch_image_block2', true)))
            {
                if (is_uploaded_file($_FILES['couch_file_block2']['tmp_name']))
                {
                    $image = parent::uploadImage('couch_file_block2', $_FILES['couch_file_block2']['type'], $img_path);
                    $full_path_img = $img_path . $image;
                    if (file_exists($full_path_img))
                    {
                        if ($this->security->xss_clean($full_path_img, TRUE) !== FALSE)
                        {
                            $b2_image = $full_path_img;
                        }
                        else
                        {
                            unlink($full_path_img);
                        }
                    }
                }
            }
            else { $b2_image = 'default'; }

            // Информация
            $b2_title    = mb_substr(strip_tags($this->input->post('i_title_block2', true)), 0, 60);
            $b2_subtitle = mb_substr(strip_tags($this->input->post('i_subtitle_block2', true)), 0, 70);
            $b2_text     = mb_substr(strip_tags($this->input->post('i_text_block2', true)), 0, 60);
            $b2_button   = mb_substr(strip_tags($this->input->post('i_button_block2', true)), 0, 40);

            $up_res = $this->Course_model->setCourseLandingBlock2($course_id, $landing_style,
                $b2_bg, $b2_image, $b2_title, $b2_subtitle, $b2_text, $b2_button, $this->date);


            if ($up_res === true) {
                // Изменения сохранены
                $this->session->set_tempdata('message', 10, 60);
            } else {
                // Изменения не сохранены
                $this->session->set_tempdata('message', 112, 60);
            }

            header('Location: /administration/course/'.$course_id.'/landing');
        }
        elseif ($this->input->post('bt_save_block_3', true))
        {
            // Стиль
            $landing_style = in_array($this->input->post('s_land_type', true), $landing_list['landings_id'])
                ? $this->input->post('s_land_type', true) : 1;

            // БЛОК 3
            // Фон
            $b3_bg = (!empty($landing['block3']['bg_orig']) and $landing['block3']['bg_default'] != 'default')
                ? $landing['block3']['bg_orig']
                : 'default'; // Фон по-умолчанию
            if (empty($this->input->post('cb_default_bg_block3', true))) {
                // Фон либо цвет, либо файл изображения
                $color = $this->input->post('i_bg_color_block3', true);
                if (!empty($color) and preg_match($regexp_color, $color)) {
                    $b3_bg = $color;
                } elseif (is_uploaded_file($_FILES['bg_file_block3']['tmp_name'])) {
                    $image = parent::uploadImage('bg_file_block3', $_FILES['bg_file_block3']['type'], $img_path);
                    $full_path_img = $img_path . $image;
                    if (file_exists($full_path_img)) {
                        if ($this->security->xss_clean($full_path_img, TRUE) !== FALSE) {
                            $b3_bg = $full_path_img;
                        } else {
                            unlink($full_path_img);
                        }
                    }
                }
            }
            else { $b3_bg = 'default'; }

            $b3_images = (!empty($landing['block3']['images'][0]) and $landing['block3']['images'][0] != 'default')
                ? '.' . $landing['block3']['images'][0] . ';'
                : 'default;';
            // Изображение 1
            if (empty($this->input->post('cb_photo1_block3', true))){
                if (is_uploaded_file($_FILES['result_file1_block3']['tmp_name'])) {
                    $image = parent::uploadImage('result_file1_block3', $_FILES['result_file1_block3']['type'], $img_path);
                    $full_path_img = $img_path . $image;
                    if (file_exists($full_path_img)) {
                        if ($this->security->xss_clean($full_path_img, TRUE) !== FALSE) {
                            $b3_images = $full_path_img . ';';
                        } else {
                            unlink($full_path_img);
                        }
                    }
                }
            }
            else { $b3_images = 'default;'; }

            // Изображение 2
            if (empty($this->input->post('cb_photo2_block3', true))) {
                $img1 = (!empty($landing['block3']['images'][1]) and $landing['block3']['images'][1] != 'default')
                    ? '.' . $landing['block3']['images'][1] . ';'
                    : 'default;';
                if (is_uploaded_file($_FILES['result_file2_block3']['tmp_name'])) {
                    $image = parent::uploadImage('result_file2_block3', $_FILES['result_file2_block3']['type'], $img_path);
                    $full_path_img = $img_path . $image;
                    if (file_exists($full_path_img)) {
                        if ($this->security->xss_clean($full_path_img, TRUE) !== FALSE) {
                            $full_path_img = $full_path_img . ';';
                        } else {
                            unlink($full_path_img);
                            $full_path_img = $img1;
                        }
                    } else {
                        $full_path_img = $img1;
                    }
                } else {
                    $full_path_img = $img1;
                }
                $b3_images .= $full_path_img;
            }
            else { $b3_images .= 'default;'; }

            // Информация
            $b3_title    = mb_substr(strip_tags($this->input->post('i_title_block3', true)), 0, 60);
            $b3_subtitle = mb_substr(strip_tags($this->input->post('i_subtitle_block3', true)), 0, 60);

            // Результаты
            $b3_r_title    = mb_substr(strip_tags($this->input->post('i_result_title_block3', true)), 0, 60);
            $b3_r_subtitle = mb_substr(strip_tags($this->input->post('i_result_subtitle_block3', true)), 0, 60);
            $b3_r_reviews  = mb_substr(strip_tags($this->input->post('i_result_reviews_block3', true)), 0, 80);

            $up_res = $this->Course_model->setCourseLandingBlock3($course_id, $landing_style,
                $b3_bg, $b3_images, $b3_title, $b3_subtitle, $b3_r_title, $b3_r_subtitle, $b3_r_reviews, $this->date);

            if ($up_res === true) {
                // Изменения сохранены
                $this->session->set_tempdata('message', 10, 60);
            } else {
                // Изменения не сохранены
                $this->session->set_tempdata('message', 112, 60);
            }

            header('Location: /administration/course/'.$course_id.'/landing');
        }
        elseif ($this->input->post('bt_save_block_4', true))
        {
            // Стиль
            $landing_style = in_array($this->input->post('s_land_type', true), $landing_list['landings_id'])
                ? $this->input->post('s_land_type', true) : 1;

            // БЛОК 4
            // Фон
            $b4_bg = (!empty($landing['block4']['bg_orig']) and $landing['block4']['bg_default'] != 'default')
                ? $landing['block4']['bg_orig']
                : 'default'; // Фон по-умолчанию
            if (empty($this->input->post('cb_default_bg_block4', true))) {
                // Фон либо цвет, либо файл изображения
                $color = $this->input->post('i_bg_color_block4', true);
                if (!empty($color) and preg_match($regexp_color, $color)) {
                    $b4_bg = $color;
                } elseif (is_uploaded_file($_FILES['bg_file_block4']['tmp_name'])) {
                    $image = parent::uploadImage('bg_file_block4', $_FILES['bg_file_block4']['type'], $img_path);
                    $full_path_img = $img_path . $image;
                    if (file_exists($full_path_img)) {
                        if ($this->security->xss_clean($full_path_img, TRUE) !== FALSE) {
                            $b4_bg = $full_path_img;
                        } else {
                            unlink($full_path_img);
                        }
                    }
                }
            }
            else { $b4_bg = 'default'; }

            // Изображение
            $b4_image = (!empty($landing['block4']['image']) and $landing['block4']['image'] != 'default')
                ? '.' . $landing['block4']['image']
                : 'default';
            if (empty($this->input->post('cb_photo_block4', true))) {
                if (is_uploaded_file($_FILES['result_file_block4']['tmp_name'])) {
                    $image = parent::uploadImage('result_file_block4', $_FILES['result_file_block4']['type'], $img_path);
                    $full_path_img = $img_path . $image;
                    if (file_exists($full_path_img)) {
                        if ($this->security->xss_clean($full_path_img, TRUE) !== FALSE) {
                            $b4_image = $full_path_img;
                        } else {
                            unlink($full_path_img);
                        }
                    }
                }
            }
            else { $b4_image = 'default'; }

            // Информация
            $b4_title    = mb_substr(strip_tags($this->input->post('i_title_block4', true)), 0, 60);
            $b4_subtitle = mb_substr(strip_tags($this->input->post('i_subtitle_block4', true)), 0, 80);
            $b4_button   = mb_substr(strip_tags($this->input->post('i_button_block4', true)), 0, 40);

            // Результат
            $b4_r_title = mb_substr(strip_tags($this->input->post('i_result_title_block4', true)), 0, 60);
            $b4_r_desc  = mb_substr(strip_tags($this->input->post('i_result_desc_block4', true)), 0, 60);

            $up_res = $this->Course_model->setCourseLandingBlock4($course_id, $landing_style,
                $b4_bg, $b4_image, $b4_title, $b4_subtitle, $b4_r_title, $b4_r_desc, $b4_button, $this->date);

            if ($up_res === true) {
                // Изменения сохранены
                $this->session->set_tempdata('message', 10, 60);
            } else {
                // Изменения не сохранены
                $this->session->set_tempdata('message', 112, 60);
            }

            header('Location: /administration/course/'.$course_id.'/landing');
        }
        elseif ($this->input->post('bt_save_block_5', true))
        {
            // Стиль
            $landing_style = in_array($this->input->post('s_land_type', true), $landing_list['landings_id'])
                ? $this->input->post('s_land_type', true) : 1;

            // БЛОК 5
            // Фон
            $b5_bg = (!empty($landing['block5']['bg_orig']) and $landing['block5']['bg_default'] === false)
                ? $landing['block5']['bg_orig']
                : 'default'; // Фон по-умолчанию
            if (empty($this->input->post('cb_default_bg_block5', true)))
            {
                // Фон либо цвет, либо файл изображения
                $color = $this->input->post('i_bg_color_block5', true);
                if (!empty($color) and preg_match($regexp_color, $color))
                {
                    $b5_bg = $color;
                }
                elseif (is_uploaded_file($_FILES['bg_file_block5']['tmp_name']))
                {
                    $image = parent::uploadImage('bg_file_block5', $_FILES['bg_file_block5']['type'], $img_path);
                    $full_path_img = $img_path . $image;
                    if (file_exists($full_path_img))
                    {
                        if ($this->security->xss_clean($full_path_img, TRUE) !== FALSE)
                        {
                            $b5_bg = $full_path_img;
                        }
                        else
                        {
                            unlink($full_path_img);
                        }
                    }
                }
            }
            else { $b5_bg = 'default'; }

            $b5_images = (!empty($landing['block5']['images'][0]) and $landing['block5']['images_0_default'] != 'default')
                ? '.' . $landing['block5']['images'][0] . ';'
                : 'default;';
            // Боковое фото 1
            if (empty($this->input->post('cb_photo1_block5', true))) {
                if (is_uploaded_file($_FILES['couch_file1_block5']['tmp_name'])) {
                    $image = parent::uploadImage('couch_file1_block5', $_FILES['couch_file1_block5']['type'], $img_path);
                    $full_path_img = $img_path . $image;
                    if (file_exists($full_path_img)) {
                        if ($this->security->xss_clean($full_path_img, TRUE) !== FALSE) {
                            $b5_images = $full_path_img . ';';
                        } else {
                            unlink($full_path_img);
                        }
                    }
                }
            }
            else { $b5_images = 'default;'; }

            // Боковое фото 2
            if (empty($this->input->post('cb_photo2_block5', true))) {
                $img1 = !empty($landing['block5']['images'][1]) and $landing['block5']['images'][1] != 'default'
                    ? '.' . $landing['block5']['images'][1] . ';'
                    : 'default;';
                if (is_uploaded_file($_FILES['couch_file2_block5']['tmp_name'])) {
                    $image = parent::uploadImage('couch_file2_block5', $_FILES['couch_file2_block5']['type'], $img_path);
                    $full_path_img = $img_path . $image;
                    if (file_exists($full_path_img)) {
                        if ($this->security->xss_clean($full_path_img, TRUE) !== FALSE) {
                            $full_path_img = $full_path_img . ';';
                        } else {
                            unlink($full_path_img);
                            $full_path_img = $img1;
                        }
                    } else {
                        $full_path_img = $img1;
                    }
                } else {
                    $full_path_img = $img1;
                }
                $b5_images .= $full_path_img;
            }
            else { $b5_images .= 'default;'; }

            // Аватар
            if (empty($this->input->post('cb_photo3_block5', true))) {
                $img2 = !empty($landing['block5']['images'][2]) and $landing['block5']['images'][2] != 'default'
                    ? '.' . $landing['block5']['images'][2] . ';'
                    : 'default;';
                if (is_uploaded_file($_FILES['couch_avatar_block5']['tmp_name'])) {
                    $image = parent::uploadImage('couch_avatar_block5', $_FILES['couch_avatar_block5']['type'], $img_path);
                    $full_path_img = $img_path . $image;
                    if (file_exists($full_path_img)) {
                        if ($this->security->xss_clean($full_path_img, TRUE) !== FALSE) {
                            $full_path_img = $full_path_img . ';';
                        } else {
                            unlink($full_path_img);
                            $full_path_img = $img2;
                        }
                    } else {
                        $full_path_img = $img2;
                    }
                } else {
                    $full_path_img = $img2;
                }
                $b5_images .= $full_path_img;
            }
            else { $b5_images .= 'default;'; }

            // Информация
            $b5_title    = mb_substr(strip_tags($this->input->post('i_title_block5', true)), 0, 60);
            $b5_subtitle = mb_substr(strip_tags($this->input->post('i_subtitle_block5', true)), 0, 60);
            $b5_text     = mb_substr(strip_tags($this->input->post('i_text_block5', true)), 0, 255);
            $b5_button   = mb_substr(strip_tags($this->input->post('i_button_block5', true)), 0, 40);

            // Слова тренера о программе
            $b5_r_title    = mb_substr(strip_tags($this->input->post('i_couch_title_block5', true)), 0, 50);
            $b5_r_subtitle = mb_substr(strip_tags($this->input->post('i_couch_subtitle_block5', true)), 0, 50);
            $b5_r_text     = mb_substr(strip_tags($this->input->post('i_couch_text_block5', true)), 0, 120);

            $up_res = $this->Course_model->setCourseLandingBlock5($course_id, $landing_style,
                $b5_bg, $b5_images, $b5_title, $b5_subtitle, $b5_text, $b5_r_title, $b5_r_subtitle, $b5_r_text, $b5_button,
                $this->date);

            if ($up_res === true) {
                // Изменения сохранены
                $this->session->set_tempdata('message', 10, 60);
            } else {
                // Изменения не сохранены
                $this->session->set_tempdata('message', 112, 60);
            }

            header('Location: /administration/course/'.$course_id.'/landing');
        }
        elseif ($this->input->post('bt_save_block_6', true))
        {
            // Стиль
            $landing_style = in_array($this->input->post('s_land_type', true), $landing_list['landings_id'])
                ? $this->input->post('s_land_type', true) : 1;

            // БЛОК 6
            // Фон
            $b6_bg = (!empty($landing['block6']['bg_orig']) and $landing['block6']['bg_default'] != 'default')
                ? $landing['block6']['bg_orig']
                : 'default'; // Фон по-умолчанию
            if (empty($this->input->post('cb_default_bg_block6', true))) {
                // Фон либо цвет, либо файл изображения
                $color = $this->input->post('i_bg_color_block6', true);
                if (!empty($color) and preg_match($regexp_color, $color)) {
                    $b6_bg = $color;
                } elseif (is_uploaded_file($_FILES['bg_file_block6']['tmp_name'])) {
                    $image = parent::uploadImage('bg_file_block6', $_FILES['bg_file_block6']['type'], $img_path);
                    $full_path_img = $img_path . $image;
                    if (file_exists($full_path_img)) {
                        if ($this->security->xss_clean($full_path_img, TRUE) !== FALSE) {
                            $b6_bg = $full_path_img;
                        } else {
                            unlink($full_path_img);
                        }
                    }
                }
            }
            else { $b6_bg = 'default'; }

            // Боковое фото
            $b6_image = (!empty($landing['block6']['image']) and $landing['block6']['image'] != 'default')
                ? '.' . $landing['block6']['image']
                : 'default';
            if (empty($this->input->post('cb_photo_block6', true))) {
                if (is_uploaded_file($_FILES['file_block6']['tmp_name'])) {
                    $image = parent::uploadImage('file_block6', $_FILES['file_block6']['type'], $img_path);
                    $full_path_img = $img_path . $image;
                    if (file_exists($full_path_img)) {
                        if ($this->security->xss_clean($full_path_img, TRUE) !== FALSE) {
                            $b6_image = $full_path_img;
                        } else {
                            unlink($full_path_img);
                        }
                    }
                }
            }
            else { $b6_image = 'default'; }

            // Информация
            $b6_title    = mb_substr(strip_tags($this->input->post('i_title_block6', true)), 0, 60);
            $b6_desc     = mb_substr(strip_tags($this->input->post('ta_desc_block6', true)), 0, 130);
            $b6_subtitle = mb_substr(strip_tags($this->input->post('i_subtitle_block6', true)), 0, 60);
            $b6_button   = mb_substr(strip_tags($this->input->post('i_button_block6', true)), 0, 40);

            // Преимущества
            $b6_advantages = '';
            foreach ($this->input->post('i_advantages_block6', true) as $advantage)
            {
                $b6_advantages .= strip_tags($advantage) . ';';
            }
            unset($advantage);

            $up_res = $this->Course_model->setCourseLandingBlock6($course_id, $landing_style,
                $b6_bg, $b6_image, $b6_title, $b6_desc, $b6_subtitle, $b6_advantages, $b6_button, $this->date);

            if ($up_res === true) {
                // Изменения сохранены
                $this->session->set_tempdata('message', 10, 60);
            } else {
                // Изменения не сохранены
                $this->session->set_tempdata('message', 112, 60);
            }

            header('Location: /administration/course/'.$course_id.'/landing');
        }
        elseif ($this->input->post('bt_save_block_7', true))
        {
            // Стиль
            $landing_style = in_array($this->input->post('s_land_type', true), $landing_list['landings_id'])
                ? $this->input->post('s_land_type', true) : 1;

            // БЛОК 7
            // Фон
            $b7_bg = (!empty($landing['block7']['bg_orig']) and $landing['block7']['bg_default'] != 'default')
                ? $landing['block7']['bg_orig']
                : 'default'; // Фон по-умолчанию
            if (empty($this->input->post('cb_default_bg_block7', true))) {
                // Фон либо цвет, либо файл изображения
                $color = $this->input->post('i_bg_color_block7', true);
                if (!empty($color) and preg_match($regexp_color, $color)) {
                    $b7_bg = $color;
                } elseif (is_uploaded_file($_FILES['bg_file_block7']['tmp_name'])) {
                    $image = parent::uploadImage('bg_file_block7', $_FILES['bg_file_block7']['type'], $img_path);
                    $full_path_img = $img_path . $image;
                    if (file_exists($full_path_img)) {
                        if ($this->security->xss_clean($full_path_img, TRUE) !== FALSE) {
                            $b7_bg = $full_path_img;
                        } else {
                            unlink($full_path_img);
                        }
                    }
                }
            }
            else { $b7_bg = 'default'; }

            // Информация
            $b7_title  = mb_substr(strip_tags($this->input->post('i_title_block7', true)), 0, 50);
            $b7_button = mb_substr(strip_tags($this->input->post('i_button_block7', true)), 0, 40);

            // Изображения и текст блока
            $b7_images = '';
            $b7_texts = '';

            $input_files = $_FILES;
            $input_titles = $this->input->post('i_text_block7', TRUE);

            $b7_images_default = false;
            if ($this->input->post('cb_images_block7', TRUE))
            {
                $b7_images_default = true;
            }
            $i = 0;
            foreach ($input_titles as $text)
            {
                $text = mb_substr(strip_tags($text), 0, 160);

                if ($b7_images_default and $i <= 3)
                {
                    $b7_images .= 'default;';
                    $b7_texts  .= $text . ';';
                }
                else
                {
                    $img = !empty($landing['block7']['images'][$i]) and $landing['block7']['images'][$i] != 'default'
                        ? '.' . $landing['block7']['images'][$i] . ';'
                        : 'default;';

                    $_FILES['files_block7'] = array(
                        'name' => $input_files['files_block7']['name'][$i],
                        'type' => $input_files['files_block7']['type'][$i],
                        'tmp_name' => $input_files['files_block7']['tmp_name'][$i],
                        'error' => $input_files['files_block7']['error'][$i],
                        'size' => $input_files['files_block7']['size'][$i]);

                    if (!empty($_FILES['files_block7']) and is_uploaded_file($_FILES['files_block7']['tmp_name']))
                    {
                        $image = parent::uploadImage('files_block7', $_FILES['files_block7']['type'], $img_path);
                        $full_path_img = $img_path . $image;
                        if (file_exists($full_path_img)) {
                            if ($this->security->xss_clean($full_path_img, TRUE) !== FALSE) {
                                $b7_image = $full_path_img . ';';
                            } else {
                                unlink($full_path_img);
                                $b7_image = $img;
                            }
                        } else {
                            $b7_image = $img;
                        }
                    }
                    else
                    {
                        $b7_image = $img;
                    }

                    $b7_images .= $b7_image;
                    $b7_texts  .= $text . ';';
                }

                $i++;
            }
            unset($text);

            $up_res = $this->Course_model->setCourseLandingBlock7($course_id, $landing_style,
                $b7_bg, $b7_title, $b7_images, $b7_texts, $b7_button, $this->date);

            if ($up_res === true) {
                // Изменения сохранены
                $this->session->set_tempdata('message', 10, 60);
            } else {
                // Изменения не сохранены
                $this->session->set_tempdata('message', 112, 60);
            }

            header('Location: /administration/course/'.$course_id.'/landing');
        }
        elseif ($this->input->post('bt_save_block_8', true))
        {
            // Стиль
            $landing_style = in_array($this->input->post('s_land_type', true), $landing_list['landings_id'])
                ? $this->input->post('s_land_type', true) : 1;

            // БЛОК 8
            // Фон
            $b8_bg = (!empty($landing['block8']['bg_orig']) and $landing['block8']['bg_default'] != 'default')
                ? $landing['block8']['bg_orig']
                : 'default'; // Фон по-умолчанию
            if (empty($this->input->post('cb_default_bg_block8', true))) {
                // Фон либо цвет, либо файл изображения
                $color = $this->input->post('i_bg_color_block8', true);
                if (!empty($color) and preg_match($regexp_color, $color)) {
                    $b8_bg = $color;
                }
                elseif (is_uploaded_file($_FILES['bg_file_block8']['tmp_name'])) {
                    $image = parent::uploadImage('bg_file_block8', $_FILES['bg_file_block8']['type'], $img_path);
                    $full_path_img = $img_path . $image;
                    if(file_exists($full_path_img)){
                        if ($this->security->xss_clean($full_path_img, TRUE) !== FALSE) {
                            $b8_bg = $full_path_img;
                        } else{
                            unlink($full_path_img);
                        }
                    }
                }
            }
            else { $b8_bg = 'default'; }

            // Информация
            $b8_title    = mb_substr(strip_tags($this->input->post('i_title_block8', true)), 0, 60);
            $b8_desc1    = mb_substr(strip_tags($this->input->post('i_desc1_block8', true)), 0, 160);
            $b8_subtitle = mb_substr(strip_tags($this->input->post('i_subtitle_block8', true)), 0, 60);
            $b8_desc2    = mb_substr(strip_tags($this->input->post('i_desc2_block8', true)), 0, 100);
            $b8_button   = mb_substr(strip_tags($this->input->post('i_button_block8', true)), 0, 40);

            // Информация
            $b8_old_price = is_numeric($this->input->post('i_old_price_block8', true)) ? $this->input->post('i_old_price_block8', true) : '';
            $b8_new_price = is_numeric($this->input->post('i_new_price_block8', true)) ? $this->input->post('i_new_price_block8', true) : '';

            $up_res = $this->Course_model->setCourseLandingBlock8($course_id, $landing_style,
                $b8_bg, $b8_title, $b8_desc1, $b8_subtitle, $b8_desc2, $b8_old_price, $b8_new_price, $b8_button, $this->date);

            if ($up_res === true) {
                // Изменения сохранены
                $this->session->set_tempdata('message', 10, 60);
            } else {
                // Изменения не сохранены
                $this->session->set_tempdata('message', 112, 60);
            }

            header('Location: /administration/course/'.$course_id.'/landing');
        }

        $result = array_merge($course_landing, $landing_list, $course);

        // Объединенные данные страница
        $this->page_data['title']         = 'АП - Редактирование данных Landing page курса';
        $this->page_data['page_menu']     = 'a_courses';
        $this->page_data['page_submenu']  = 'landing';
        $this->page_data['course_id']     = $course_id;

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('course/settings/course', $result);
        $this->load->view('footer/footer');
    }

    /**
     * Функция добавления к началу пути файла точки
     *
     * @param string $item Элемент массива
     * @param string $key Ключ элеменита массива
     */
    function add_dot(&$item, $key)
    {
        $item = '.' . $item;
    }

    /**
     * Вывод статистики курса
     *
     * @param $course_id
     */
    protected function courseStatistics($course_id)
    {
        $statis = $this->Course_model->getStatistics($course_id);
        $course = $this->Course_model->getShortCourse($course_id);

        $result = array_merge($statis, $course);

        // Объединенные данные страница
        $this->page_data['title'] = 'АП - Статистика курса';
        $this->page_data['page_menu'] = 'a_courses';
        $this->page_data['page_submenu'] = 'statistics';
        $this->page_data['course_id'] = $course_id;

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('course/settings/course', $result);
        $this->load->view('footer/footer');
    }

    /**
     * Вывод отзывов курса
     *
     * @param $course_id
     */
    protected function courseReviews($course_id)
    {
        $reviews = $this->Course_model->getCourseReviews($course_id);
        $course  = $this->Course_model->getShortCourse($course_id);

        $result = array_merge($reviews, $course);

        // Объединенные данные страница
        $this->page_data['title'] = 'АП - Отзывы курса';
        $this->page_data['page_menu'] = 'a_courses';
        $this->page_data['page_submenu'] = 'reviews';
        $this->page_data['course_id'] = $course_id;

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('course/settings/course', $result);
        $this->load->view('footer/footer');
    }

    /**
     * Вывод формы редактирования отзыва курса
     *
     * @param $course_id
     * @param $review_id
     */
    protected function courseReview($course_id, $review_id)
    {
        $review = $this->Course_model->getCourseReview($course_id, $review_id);
        $course = $this->Course_model->getShortCourse($course_id);

        $result = array_merge($review, $course);

        if ($this->input->post('bt_save_review', true))
        {
            $review_text = mb_substr(strip_tags($this->input->post('ta_review_text', true)), 0, 1000);

            if (!empty($review_text) and $review_text != $result['review']['text'])
            {
                $res_review = $this->Course_model->updateCourseReview($course_id, $review_id, $review_text, $this->date);

                if ($res_review === true)
                {
                    // Изменения сохранены
                    $this->session->set_tempdata('message', 10, 60);
                }
                else
                {
                    // Изменения не сохранены
                    $this->session->set_tempdata('message', 121, 60);
                }
            }

            header('Location: /administration/course/' . $course_id . '/review/' . $review_id);
        }
        elseif ($this->input->post('bt_approval_review', true))
        {
            $res_review = $this->Course_model->approvalCourseReview($course_id, $review_id, $this->date);

            if ($res_review === true)
            {
                // Изменения сохранены
                $this->session->set_tempdata('message', 10, 60);
            }
            else
            {
                // Изменения не сохранены
                $this->session->set_tempdata('message', 124, 60);
            }

            header('Location: /administration/course/' . $course_id . '/review/' . $review_id);
        }
        elseif ($this->input->post('bt_reject_review', true))
        {
            $res_review = $this->Course_model->rejectCourseReview($course_id, $review_id, $this->date);

            if ($res_review === true)
            {
                // Изменения сохранены
                $this->session->set_tempdata('message', 10, 60);
            }
            else
            {
                // Изменения не сохранены
                $this->session->set_tempdata('message', 125, 60);
            }

            header('Location: /administration/course/' . $course_id . '/review/' . $review_id);
        }
        elseif ($this->input->post('bt_delete_review', true))
        {
            $res_review = $this->Course_model->deleteCourseReview($course_id, $review_id);

            if ($res_review === true)
            {
                // Изменения сохранены
                $this->session->set_tempdata('message', 10, 60);

                header('Location: /administration/course/' . $course_id . '/reviews');
            }
            else
            {
                // Изменения не сохранены
                $this->session->set_tempdata('message', 123, 60);

                header('Location: /administration/course/' . $course_id . '/review/' . $review_id);
            }
        }

        // Объединенные данные страница
        $this->page_data['title'] = 'АП - Отзыв курса';
        $this->page_data['page_menu'] = 'a_courses';
        $this->page_data['page_submenu'] = 'reviews';
        $this->page_data['course_id'] = $course_id;

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('course/settings/course', $result);
        $this->load->view('footer/footer');
    }

    /**
     * Вывод списка видео категории "Промо"
     *
     * @param $course_id
     */
    protected function coursePromoVideo($course_id)
    {
        $promo  = $this->Course_model->getCoursePromoVideo($course_id);
        $course = $this->Course_model->getShortCourse($course_id);

        $result = array_merge($promo, $course);

        // Объединенные данные страница
        $this->page_data['title']        = 'АП - Промо-видео курса';
        $this->page_data['page_menu']    = 'a_courses';
        $this->page_data['page_submenu'] = 'video';
        $this->page_data['video_menu']   = 'promo';
        $this->page_data['course_id']    = $course_id;

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('course/settings/course', $result);
        $this->load->view('footer/footer');
    }

    /**
     * Вывод списка видео категории "Тренировка"
     *
     * @param $course_id
     */
    protected function courseWorkoutVideo($course_id)
    {
        $workouts = $this->Course_model->getCourseWorkoutVideo($course_id);
        $course   = $this->Course_model->getShortCourse($course_id);

        $result = array_merge($workouts, $course);

        // Объединенные данные страница
        $this->page_data['title']        = 'АП - Видео тренировок курса';
        $this->page_data['page_menu']    = 'a_courses';
        $this->page_data['page_submenu'] = 'video';
        $this->page_data['video_menu']   = 'workouts';
        $this->page_data['course_id']    = $course_id;

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('course/settings/course', $result);
        $this->load->view('footer/footer');
    }

    /**
     * Вывод списка видео категории "Инструктажи"
     *
     * @param $course_id
     */
    protected function courseInstructionsVideo($course_id)
    {
        $instruction = $this->Course_model->getCourseInstructionsVideo($course_id);
        $course      = $this->Course_model->getShortCourse($course_id);

        $result = array_merge($instruction, $course);

        // Объединенные данные страница
        $this->page_data['title']        = 'АП - Видео инструктажей курса';
        $this->page_data['page_menu']    = 'a_courses';
        $this->page_data['page_submenu'] = 'video';
        $this->page_data['video_menu']   = 'instructions';
        $this->page_data['course_id']    = $course_id;

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('course/settings/course', $result);
        $this->load->view('footer/footer');
    }

    /**
     * Вывод формы и валидация данных нового видео курса
     *
     * @param $course_id
     * @return void
     */
    protected function newCourseVideo($course_id)
    {
        $result = $this->Course_model->getShortCourse($course_id);

        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3) {
            show_404($this->page_url);
        }

        if ($this->input->post('bt_save_video', true))
        {
            $type        = is_numeric($this->input->post('s_type', true)) ? $this->input->post('s_type', true) : 0;
            $name        = !empty($this->input->post('file_name', true))
                ? mb_substr(strip_tags($this->input->post('file_name', true)), 0, 255) : '';
            $remove_url  = !empty($this->input->post('remove_url', true))
                ? mb_substr(strip_tags($this->input->post('remove_url', true)), 0, 255) : '';
            $poster_path = is_file('./video/' . $this->input->post('poster_path', true))
                ? './video/' . $this->input->post('poster_path', true) : '';
            $video_path  = is_file('./video/' . $this->input->post('video_path', true))
                ? './video/' . $this->input->post('video_path', true) : '';

            if (!empty($video_path) or !empty($remove_url))
            {
                $result = $this->Course_model->setNewVideo($type, $course_id, $name, $video_path, $poster_path, $remove_url, $this->user_id, $this->date);

                //echo 'T '.$type.' N '.$name.' RU '.$remove_url.' PP '.$poster_path.' VP '.$video_path.'<br/>';

                if (is_numeric($result) and $result !== false)
                {
                    // Изменения сохранены
                    $this->session->set_tempdata('message', 10, 60);

                    header('Location: /administration/course/' . $course_id . '/video/'.$result);
                }
                else
                {
                    // Изменения не сохранены
                    $this->session->set_tempdata('message', 39, 60);

                    // Удаление загруженных файлов
                    if (is_file($poster_path)) {
                        unlink($poster_path);
                    }
                    if (is_file($video_path)) {
                        unlink($video_path);
                    }
                    header('Location: /administration/course/' . $course_id . '/video/new');
                }
            }
            else
            {
                // Изменения не сохранены
                $this->session->set_tempdata('message', 40, 60);

                // Удаление загруженных файлов
                if (is_file($poster_path))
                {
                    unlink($poster_path);
                }
                if (is_file($video_path))
                {
                    unlink($video_path);
                }
                header('Location: /administration/course/' . $course_id . '/video/new');
            }
        }

        // Объединенные данные страница
        $this->page_data['title']        = 'АП - Добавление видео курса';
        $this->page_data['page_menu']    = 'a_courses';
        $this->page_data['page_submenu'] = 'video';
        $this->page_data['course_id']    = $course_id;

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('course/settings/course_video_new', $result);
        $this->load->view('footer/footer');
    }

    /* БЛОК ФУНКЦИЙ ПУБЛИЧНЫХ КУРСОВ */

    /**
     * Вывод списка курсов, доступных всем пользователям
     */
    public function publicCourses()
    {
        $this->load->model('Couch_model');

        // Получение списка добавленных курсов
        $courses = $this->Course_model->getAvailableCourses();
        $gallery = $this->Couch_model->getGallery();
        $reviews = $this->Course_model->getAvaliableReviews();

        $result = array_merge($courses, $gallery, $reviews);

        // Объединенные данные страница
        $this->page_data['title'] = 'Курсы';
        $this->page_data['page_menu'] = 'courses';

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/secondary');
        $this->load->view('course/public_courses', $result);
        $this->load->view('footer/footer');
    }

    /**
     * Курсы пользователей.
     * Переход на определенную категорию пользователей
     *
     * @return void
     */
    public function usersCourses()
    {
        if (!is_numeric($this->user_id)) {
            show_404($this->page_url);
        }

        // Страница пользователя или администратора
        if ($this->session->user['type'] != 2) {
            self::userCourses();
        }
        // Страница тренера
        elseif ($this->session->user['type'] == 2) {
            self::couchCourses();
        }
    }

    /**
     * Курсы пользователя
     *
     * @return void
     */
    protected function userCourses()
    {
        /**
         * @var array Данные курса
         */
        $course_data = array();

        $course_data = $this->Course_model->getUserCourses($this->user_id, $this->date);

        // Объединенные данные страница
        $this->page_data['title'] = 'Мои курсы';
        $this->page_data['page_menu'] = 'u_courses';

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/profile');
        $this->load->view('user/profile_line');
        $this->load->view('course/user_course/courses', $course_data);
        $this->load->view('footer/footer');
    }

    /**
     * Курсы тренера
     *
     * @return void
     */
    protected function couchCourses()
    {
        /**
         * @var array Данные курса
         */
        $course_data = array();

        $course_data = $this->Course_model->getCouchCourses($this->user_id);

        // Объединенные данные страница
        $this->page_data['title'] = 'Курсы';
        $this->page_data['page_menu'] = 'u_courses';

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/profile');
        $this->load->view('user/profile_line');
        $this->load->view('course/partner_courses', $course_data);
        $this->load->view('footer/footer');
    }

    /**
     * Курс пользователя, тренера
     *
     * @param $course_id
     * @return void
     */
    public function usersCourse($course_id)
    {
        if (!is_numeric($this->user_id)) {
            show_404($this->page_url);
        }

        // Страница пользователя или администратора
        if ($this->session->user['type'] != 2) {
            self::userCourse($course_id);
        }
        // Страница тренера
        elseif ($this->session->user['type'] == 2) {
            self::couchCourse($course_id);
        }
    }

    /**
     * Курс пользователя
     *
     * @param $course_id
     * @return void
     */
    protected function userCourse($course_id)
    {
        /**
         * @var array Данные курса
         * @var bool Результат сохранения данных
         */
        $course_data = array();
        $result = true;

        // Ограничение календаря
        $date              = DateTime::createFromFormat('Y-m-d H:i:s', $this->date);
        $min_date          = $date->add(new DateInterval('P7D'));
        $calendar_min_date = $min_date->format('Y-m-d');
        $string_min_date   = $min_date->format('d.m.Y');
        $max_date          = $date->add(new DateInterval('P30D'));
        $calendar_max_date = $max_date->format('Y-m-d');
        $string_max_date   = $max_date->format('d.m.Y');

        $course_data = $this->Course_model->getUserCourseSettings($course_id, $this->user_id);
        if (empty($course_data)) {
            show_404($this->page_url);
        }
        $db_course = $course_data['course'];

        // Данные курса (используется для сохранения изменений)
        $uc_id            = $db_course['id']; // ID курса и пользователя (Уникальное ID купленного курса в таблице users_courses)
        $course_weeks     = $db_course['count_weeks'];
        $course_days      = $db_course['count_days'];
        $course_rest      = $db_course['count_rest'];
        $course_start     = $db_course['db_date_start'];
        $course_end       = $db_course['db_date_end'];
        $workouts_missed  = $db_course['workouts_missed'];
        $workouts_passed  = $db_course['workouts_passed'];
        $db_workouts      = $db_course['workouts'];
        $db_training_days = $db_course['training_days'];
        $db_pause_days    = $db_course['pause_days'];// Кол-во дней прошлой заморозки
        $pause_days       = $db_pause_days;

        if ($this->input->post('bt_save_course', true))
        {
            $result_td = true; // Результат сохранения изменения дней тренировок
            $result_uw = true; // Результат сохранения обновленных дат тренировок
            $result_sp = true; // Результат заморозки курса

            // Выбранный тренер
            $couch_id = is_numeric($this->input->post('user_couch', true)) ? $this->input->post('user_couch', true) : 0;

            // Дни недели тренировок
            $training_days = '';
            if (!empty($this->input->post('cb_day')) and empty($db_training_days))
            {
                $days = $this->input->post('cb_day');
                $prev_key = 0;
                $total = count($days);
                $i = 1;
                foreach ($days as $key => $day)
                {
                    // Если кол-во выбранных дней не превышает кол-во дней курса
                    if ($i < $course_days)
                    {
                        // Разница между днями. Если не меньше установленной курсом, добавляем как день тренировки
                        if ($i == 1)
                        {
                            $training_days .= $day;
                        }
                        else
                        {
                            $training_days .= (($key - $prev_key) >= $course_rest) ? $day : '';
                        }

                        $prev_key = $key;
                    }
                    elseif($i == $total)
                    {
                        $training_days .= ((6 - $key) >= $course_rest) ? $day : '';
                    }

                    $i++;
                }
                unset($day);
            }
            // Массив новых дней тренировок
            $array_training_days = !empty($training_days) ? str_split($training_days) : null;

            // Вычисление старта и окончания курса
            if (empty($db_training_days) and !empty($array_training_days))
            {
                // Номер дня недели сегодня
                $current_num_day = date("N", strtotime($this->date));
                $tem_date = new DateTime($this->date);
                $today    = $tem_date->format('Y-m-d');
                unset($tem_date);
                // Вычисление даты начала курса
                if (!in_array($current_num_day, $array_training_days))
                {
                    // Поиск большего номера дня недели и вычисление его даты
                    foreach ($array_training_days as $key => $training_day)
                    {
                        if ($training_day > $current_num_day)
                        {
                            $diff_days = $training_day - $current_num_day;

                            $tmp_date = new DateTime($today);
                            $tmp_date->add(new DateInterval('P' . $diff_days . 'D'));
                            $new_course_start = ($tmp_date !== false) ? $tmp_date->format('Y-m-d') : '';
                        }
                    }
                    unset($training_day);

                    // Если дата начала курса не вычислилась на предыдущем этапе, выбираем первый день недели тренировки
                    // пользователя и вычисляем её дату
                    if (empty($new_course_start))
                    {
                        // От 7 дней недели отнимаем день недели предыдущей тренировки и прибавляем день недели первой тренировки на неделе
                        $diff_days = 7 - $current_num_day + $array_training_days[0];
                        // Временная дата предыдущей тренивроки
                        $tem_date = new DateTime($today);
                        // Дата текущей тренировки, с учетом разницы между тренировками ( + $diff_days дней )
                        $tem_date->add(new DateInterval('P' . $diff_days . 'D'));

                        $new_course_start = ($tem_date !== false) ? $tem_date->format('Y-m-d') : $this->date;
                    }
                }
                else
                {
                    $new_course_start = $today;
                }

                // Изначальная дата окончания курса
                if (!empty($new_course_start))
                {
                    $count_days = ($course_weeks*7) - 1;
                    $tmp_date = new DateTime($new_course_start);
                    $tmp_date->add(new DateInterval('P' . $count_days . 'D'));
                    $new_course_end = ($tmp_date !== false) ? $tmp_date->format('Y-m-d') : '';
                }
            }

            // Сохранение изменений выбранного тренера
            if ($couch_id != $db_course['couch_id']) {
                $result = $this->Course_model->setUserCourseCouch($course_id, $this->user_id, $couch_id, $this->date);
            }

            /*// Сохранение изменений дней тренировок
            if (!empty($array_training_days) and $training_days != $db_training_days and empty($db_training_days)) {
                $update_workouts     = array(); // Тренировки, у которых необходимо обновить дату
                $all_workouts        = array(); // Все тренировки (и обновленные и не обновленные)
                $update_all_workouts = false; // Во всех ли тренировках обновлять дату (по-умолчанию: нет)
                $set_start_date      = true; // Флаг начала отсчета дат после заморозки

                // Если ни одна из тренировок не явл. пропущенной или выполненной, то смещаем начальную и конечную даты курса
                if ($workouts_missed == 0 and $workouts_passed == 0) {
                    // Дата начала курса
                    $tem_date = new DateTime($this->date);
                    $start_date = $tem_date->format('Y-m-d');
                    $end_date = null;
                    // Текущий номер дня недели
                    $current_num_day = date("N");
                    // Вычисление даты начала курса
                    // Если текущий номер дня недели не присутствует в массиве выбранных тренировочных дней неделе,
                    // то вычисляем дату следующего дня недели тренировки.
                    if (!in_array($current_num_day, $array_training_days)) {
                        // Поиск большего номера дня недели
                        foreach ($array_training_days as $key => $training_day) {
                            if ($training_day > $current_num_day and $set_start_date === true) {
                                $diff_days = $training_day - $current_num_day;

                                $date = DateTime::createFromFormat('Y-m-d H:i:s', $this->date);
                                $date->add(new DateInterval('P' . $diff_days . 'D'));
                                $start_date = $date !== false ? $date->format('Y-m-d') : null;

                                $set_start_date = false;
                            }
                        }
                        unset($training_day);

                        // Если дата начала курса не изменилась, то берем первый выбранный номер дня недели тренировки
                        if ($start_date == $this->date) {
                            $diff_days = 7 - $current_num_day + $array_training_days[0];

                            $date = DateTime::createFromFormat('Y-m-d H:i:s', $this->date);
                            $date->add(new DateInterval('P' . $diff_days . 'D'));
                            $start_date = $date !== false ? $date->format('Y-m-d') : null;
                        }
                    }

                    // Изначальная дата окончания курса
                    if (!empty($start_date)) {
                        $count_days = ($course_weeks*7) - 1;
                        $date = DateTime::createFromFormat('Y-m-d', $start_date);
                        $date->add(new DateInterval('P' . $count_days . 'D'));
                        $end_date = $date !== false ? $date->format('Y-m-d') : null;
                    }

                    // Если дата изменилась, то изменяем даты тренировок
                    if ($start_date !== null and $end_date !== null) {
                        $course_start = $start_date;
                        $course_end = $end_date;

                        $update_all_workouts = true;
                    }
                }

                // Вычисление новых дат тренировок
                $training_date = $course_start;

                $tem_date = new DateTime($this->date);
                $today    = $tem_date->format('Y-m-d');
                unset($tem_date);

                foreach ($db_workouts as $num_workout => $workout) {
                    // Если флаг отмечен false, то не все тренировки обновлять, а только те, которые еще не выполнены
                    // Иначе пропустить текущую тренировку и перейти к следующей
                    if ($update_all_workouts === false and $workout['done'] == 1) {
                        $all_workouts[$num_workout]['date'] = $workout['date'];
                        $all_workouts[$num_workout]['done'] = $workout['done'];
                        continue;
                    }

                    // Первой тренировки присваиваем начальную дату курса
                    // Для остальных проводим вычисление
                    if ($num_workout > 1) {
                        // Номер дня недели предыдущей тренировки
                        $prev_num_day = date('N', strtotime($training_date));
                        $key_num_day  = array_search($prev_num_day, $array_training_days);

                        if ($key_num_day !== false) {
                            // Вычисление разницы между номерами дней недели
                            // Если предыдущий день недели тренировки последний день недели, то
                            if ($key_num_day == $course_days-1) {
                                // От 7 дней недели отнимаем день недели предыдущей тренировки и прибавляем день недели первой тренировки на неделе
                                $diff_days = 7 - $array_training_days[$key_num_day] + $array_training_days[0];
                            } else {
                                // Разница между текущим номером недели тренировки и предыдущем.
                                $diff_days = $array_training_days[$key_num_day+1] - $array_training_days[$key_num_day];
                            }

                            // Временная дата предыдущей тренивроки
                            $tem_date = new DateTime($training_date);

                            // Дата текущей тренировки, с учетом разницы между тренировками ( + $diff_days дней )
                            $tem_date->add(new DateInterval('P' . $diff_days . 'D'));

                            $training_date = $tem_date->format('Y-m-d');

                            unset($tem_date);
                        }
                        // Если не найден предыдущий день недели в новом списке, то проверяем дату текущей тренировки.
                        // Если дата тек. тренировки >= "сегодня" и тренировка не выполнена, то пересчитываем на новую дату.
                        else {
                            if ($workout['date'] >= $today and $workout['done'] == 0) {
                                // Номер недели текущего дня
                                $today_num_day = date('N', strtotime($today));
                                // Новый номер недели тренировки
                                $new_num_day_workout = $array_training_days[0];

                                // Если текущий день недели = новому деню недели, то новая дата = "сегодня"
                                if ($new_num_day_workout == $today_num_day) {
                                    $training_date = $today;
                                }
                                else {
                                    // Вычисление разницы между номерами дней недели
                                    if ($today_num_day >= $new_num_day_workout) {
                                        $diff_days = 7 - $today_num_day + $new_num_day_workout;
                                    } else {
                                        $diff_days = $new_num_day_workout - $today_num_day;
                                    }

                                    // Временная дата "сегодня"
                                    $tem_date = new DateTime($today);

                                    // Дата текущей тренировки, с учетом разницы между днями ( + $diff_days дней )
                                    $tem_date->add(new DateInterval('P' . $diff_days . 'D'));

                                    $training_date = $tem_date->format('Y-m-d');

                                    unset($tem_date);
                                }
                            }
                        }
                    }

                    $all_workouts[$num_workout]['date']    = $training_date;
                    $all_workouts[$num_workout]['done']    = $workout['done'];
                    $update_workouts[$num_workout]['date'] = $training_date;
                }
                unset($workout);

                // Если дата последней тренировки больше конечной даты курса, то обновляем конечную дату.
                if ($training_date > $course_end) {
                    $course_end = $training_date;
                }
            }*/

            /* Заморозка курса */
            $input_date      = $this->input->post('date_pause_to', true); // Введенная дата
            $tm_date_to      = DateTime::createFromFormat('Y-m-d', $input_date);
            $date_pause_to   = ($input_date != '' and $tm_date_to !== false) ? $tm_date_to->format('Y-m-d') : '';
            $curr_pause_days = 0; // Кол-во дней заморозки
            // Заморозка курса (изменение дат тренировок, даты окончания курса)
            if (!empty($date_pause_to) and !empty($db_training_days))
            {
                $temp_date_today = DateTime::createFromFormat("Y-m-d H:i:s", $this->date);
                $today           = $temp_date_today->format('Y-m-d');

                // Кол-во дней текущей заморозки
                $interval        = $temp_date_today->diff($tm_date_to);
                $curr_pause_days = $interval->format('%a');
                unset($tm_date_to);
                unset($temp_date_today);

                if ($curr_pause_days >= 7) {
                    // Суммарное кол-во дней заморозки
                    $pause_days = $db_pause_days + (int)$curr_pause_days;

                    // Если суммарное кол-во дней превышает 30, то уменьшая дату заморозки до уровня 30 дней
                    if ($pause_days > 30) {
                        $diff_days = $pause_days - 30;
                        $tm_date_to = DateTime::createFromFormat('Y-m-d', $date_pause_to);
                        $new_date_pause_to = $tm_date_to->sub(new DateInterval('P' . $diff_days . 'D'));
                        $date_pause_to = $new_date_pause_to->format('Y-m-d');
                        unset($tm_date_to);
                        $pause_days = 30;
                    }

                    // Следующее число после окончания заморозки
                    $temp_date     = DateTime::createFromFormat('Y-m-d', $date_pause_to);
                    $temp_date     = $temp_date->add(new DateInterval("P1D"));
                    $first_date    = $temp_date->format('Y-m-d'); // Первый день после разморозки курса
                    $training_date = $temp_date->format('Y-m-d');
                    unset($temp_date);

                    $set_start_date = true; // Флаг начала отсчета дат после заморозки
                    $next_workout   = false; // Флаг продолжения вычисления новых дат тренировок

                    // Изменени дат тренировок
                    if (empty($all_workouts)) {
                        $all_workouts = $db_workouts;
                    }
                    foreach ($all_workouts as $num_workout => $workout) {
                        // Если дата тренировки попала в диапозон дат заморозки, то смещаем дату тренировки
                        if ($workout['date'] >= $today and $workout['done'] == 0) {
                            // Сравнения номера дня недели с днями недели тренировок
                            $current_num_day = date("N", strtotime($training_date));

                            // Если текущий день = первому деню после разморозки и проверка первой попавшей в диапозон тренировки.
                            // Изменение даты первой тренировки, попавшей в диапозон.
                            if ($training_date == $first_date and $next_workout === false) {
                                // Если текущий номер дня недели не присутствует в массиве выбранных тренировочных дней неделе,
                                // то вычисляем дату следующего дня недели тренировки.
                                if (!in_array($current_num_day, $db_training_days)) {
                                    // Поиск большего номера дня недели
                                    foreach ($db_training_days as $key => $training_day) {
                                        if ($training_day > $current_num_day and $set_start_date === true) {
                                            $diff_days = $training_day - $current_num_day;

                                            $date = DateTime::createFromFormat('Y-m-d', $training_date);
                                            $date->add(new DateInterval('P' . $diff_days . 'D'));
                                            $training_date = ($date !== false) ? $date->format('Y-m-d') : $training_date;

                                            $set_start_date = false;
                                        }
                                    }
                                    unset($training_day);
                                }

                                $next_workout = true;
                            }
                            // Изменение дат остальных тренировок
                            else {
                                // Номер дня недели предыдущей тренировки
                                $prev_num_day = date('N', strtotime($training_date));
                                $key_num_day  = array_search($prev_num_day, $db_training_days);

                                if ($key_num_day !== false) {
                                    // Вычисление разницы между номерами дней недели
                                    // Если предыдущий день недели тренировки последний день недели, то
                                    if ($key_num_day == $course_days-1) {
                                        // От 7 дней недели отнимаем день недели предыдущей тренировки и прибавляем день недели первой тренировки на неделе
                                        $diff_days = 7 - $db_training_days[$key_num_day] + $db_training_days[0];
                                    } else {
                                        // Разница между текущим номером недели тренировки и предыдущем.
                                        $diff_days = $db_training_days[$key_num_day+1] - $db_training_days[$key_num_day];
                                    }

                                    // Временная дата предыдущей тренивроки
                                    $tem_date = new DateTime($training_date);

                                    // Дата текущей тренировки, с учетом разницы между тренировками ( + $diff_days дней )
                                    $tem_date->add(new DateInterval('P' . $diff_days . 'D'));

                                    $training_date = $tem_date->format('Y-m-d');

                                    unset($tem_date);
                                }
                            }

                            $update_workouts[$num_workout]['date'] = $training_date;
                        }
                    }
                    unset($workout);

                    // Если дата последней тренировки больше конечной даты курса, то обновляем конечную дату.
                    if ($training_date > $course_end) {
                        $course_end = $training_date;
                    }
                }
            }


            /* СОХРАНЕНИЕ ИЗМЕНЕНИЙ */
            // Сохранение изменения дней тренировок
            if (!empty($array_training_days) and empty($db_training_days))
            {
                // Сохранение дней тренировок пользователя
                $result_td = $this->Course_model->setUserTrainingDays($uc_id, $training_days, $new_course_start, $new_course_end, $this->date);

                // Добавление тренировок пользователя в БД
                $count_workouts = $course_weeks * $course_days;
                $this->Course_model->setUserTrainingWeeks($uc_id, $new_course_start, $training_days, $count_workouts, $course_days, $this->date);

            }

            // Сохранение заморозки курса
            if (!empty($date_pause_to) and $curr_pause_days >= 7) {
                $result_sp = $this->Course_model->setUserCoursePause($uc_id, $date_pause_to, $course_end, $this->date);
            }

            if ($result_td === true and $result_sp === true) {
                // Изменения сохранены
                $this->session->set_tempdata('message', 10, 60);
            } else {
                $error_code = 30;
                if ($result_td === false and $result_sp === true) {
                    $error_code = 79;
                }
                elseif ($result_td === true and $result_sp === false) {
                    $error_code = 80;
                }
                elseif ($result_td === false and $result_sp === false) {
                    $error_code = 81;
                }
                // Изменения не сохранены
                $this->session->set_tempdata('message', $error_code, 60);
            }

            header('Location: /profile/course/'.$course_id);

            //print_r(get_defined_vars());
        }
        elseif ($this->input->post('bt_unblock_course', true))
        {
            $temp_date_today = DateTime::createFromFormat("Y-m-d H:i:s", $this->date);
            $today           = $temp_date_today->format('Y-m-d');
            // Количество дней прошедшей заморозки
            $pause_start = new DateTime($db_course['pause_start']);
            $pause_end   = new DateTime($this->date);
            $diff_days   = $pause_start->diff($pause_end);
            $pause_days  = (int)$db_course['pause_days'] + (int)$diff_days->format('%a');

            $training_date  = $today;
            $set_start_date = true; // Флаг начала отсчета дат после заморозки
            $next_workout   = false; // Флаг продолжения вычисления новых дат тренировок

            $array_training_days = str_split($db_training_days);
            $update_workouts     = array();

            // Изменение дат тренировок
            foreach ($db_workouts as $num_workout => $workout) {
                // Если дата тренировки попала в диапозон дат заморозки, то смещаем дату тренировки
                if ($workout['date'] >= $today and $workout['done'] == 0) {
                    // Сравнения номера дня недели с днями недели тренировок
                    $current_num_day = date("N", strtotime($training_date));

                    // Если текущий день = первому деню после разморозки и проверка первой попавшей в диапозон тренировки.
                    // Изменение даты первой тренировки, попавшей в диапозон.
                    if ($training_date == $today and $next_workout === false) {
                        // Если текущий номер дня недели не присутствует в массиве выбранных тренировочных дней неделе,
                        // то вычисляем дату следующего дня недели тренировки.
                        if (!in_array($current_num_day, $array_training_days)) {
                            // Поиск большего номера дня недели
                            foreach ($array_training_days as $key => $training_day) {
                                if ($training_day > $current_num_day and $set_start_date === true) {
                                    $diff_days = $training_day - $current_num_day;

                                    $date = DateTime::createFromFormat('Y-m-d', $training_date);
                                    $date->add(new DateInterval('P' . $diff_days . 'D'));
                                    $training_date = ($date !== false) ? $date->format('Y-m-d') : $training_date;

                                    $set_start_date = false;
                                }
                            }
                            unset($training_day);

                            // Если дата тренировки осталась не измененной, выбираем первый день недели тренировки
                            // пользователя и вычисляем её дату
                            if ($training_date == $today) {
                                // От 7 дней недели отнимаем день недели предыдущей тренировки и прибавляем день недели первой тренировки на неделе
                                $diff_days = 7 - $current_num_day + $array_training_days[0];

                                // Временная дата предыдущей тренивроки
                                $tem_date = new DateTime($training_date);

                                // Дата текущей тренировки, с учетом разницы между тренировками ( + $diff_days дней )
                                $tem_date->add(new DateInterval('P' . $diff_days . 'D'));

                                $training_date = $tem_date->format('Y-m-d');
                            }
                        }

                        $next_workout = true;
                    }
                    // Изменение дат остальных тренировок
                    else {
                        // Номер дня недели предыдущей тренировки
                        $prev_num_day = date('N', strtotime($training_date));
                        $key_num_day  = array_search($prev_num_day, $array_training_days);

                        if ($key_num_day !== false) {
                            // Вычисление разницы между номерами дней недели
                            // Если предыдущий день недели тренировки последний день недели, то
                            if ($key_num_day == $course_days-1) {
                                // От 7 дней недели отнимаем день недели предыдущей тренировки и прибавляем день недели первой тренировки на неделе
                                $diff_days = 7 - $array_training_days[$key_num_day] + $array_training_days[0];
                            } else {
                                // Разница между текущим номером недели тренировки и предыдущем.
                                $diff_days = $array_training_days[$key_num_day+1] - $array_training_days[$key_num_day];
                            }

                            // Временная дата предыдущей тренивроки
                            $tem_date = new DateTime($training_date);

                            // Дата текущей тренировки, с учетом разницы между тренировками ( + $diff_days дней )
                            $tem_date->add(new DateInterval('P' . $diff_days . 'D'));

                            $training_date = $tem_date->format('Y-m-d');

                            unset($tem_date);
                        }
                    }

                    $update_workouts[$num_workout]['date'] = $training_date;
                }
            }
            unset($workout);

            // Если дата последней тренировки больше конечной даты курса, то обновляем конечную дату.
            $course_end = $training_date;

            // Разморозка курса
            $result = $this->Course_model->unsetUserCoursePause($uc_id, $pause_days, $course_end, $this->date);

            if ($result === true and !empty($update_workouts)) {
                $this->Course_model->updateDatesUserWorkouts($uc_id, $update_workouts, $this->date);
            }

            header('Location: /profile/course/'.$course_id);
        }

        // Объединенные данные страница
        $this->page_data['title'] = 'Курс';
        $this->page_data['page_menu'] = 'u_courses';
        $this->page_data['page_submenu'] = 'settings';
        $this->page_data['calendar_min_date'] = $calendar_min_date;
        $this->page_data['calendar_max_date'] = $calendar_max_date;
        $this->page_data['string_min_date'] = $string_min_date;
        $this->page_data['string_max_date'] = $string_max_date;

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/profile');
        $this->load->view('user/profile_line');
        $this->load->view('course/user_course/settings', $course_data);
        $this->load->view('footer/footer');
    }

    /**
     * Курс тренера
     *
     * @param $course_id
     * @return void
     */
    protected function couchCourse($course_id)
    {
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

            header('Location: /profile/course/'.$course_id);
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

    /**
     * Отзывы пользователя о курсе
     *
     * @param $course_id
     */
    public function userCourseReviews($course_id)
    {
        if (!is_numeric($this->user_id))
        {
            show_404($this->page_url);
        }

        // Сохранение отзыва
        if ($this->input->post('bt_save_review', true))
        {
            $review_text = mb_substr(strip_tags($this->input->post('ta_review_text', true)), 0, 1000);

            if (!empty($review_text))
            {
                $res_review = $this->Course_model->setUserCourseReview($course_id, $this->user_id, $review_text, $this->date);

                if ($res_review === true)
                {
                    // Изменения сохранены
                    $this->session->set_tempdata('message', 10, 60);
                }
                else
                {
                    // Изменения не сохранены
                    $this->session->set_tempdata('message', 121, 60);
                }
            }
            else
            {
                // Изменения не сохранены
                $this->session->set_tempdata('message', 122, 60);
            }

            header('Location: /profile/course/' . $course_id . '/reviews');
        }

        $course_data = $this->Course_model->getUserCourseSettings($course_id, $this->user_id);
        $reviews     = $this->Course_model->getUserCourseReviews($course_id, $this->user_id);
        $result      = array_merge($course_data, $reviews);

        // Объединенные данные страница
        $this->page_data['title'] = 'Мои курсы';
        $this->page_data['page_menu'] = 'u_courses';
        $this->page_data['page_submenu'] = 'reviews';

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/profile');
        $this->load->view('user/profile_line');
        $this->load->view('course/user_course/reviews', $result);
        $this->load->view('footer/footer');
    }

    /**
     * Форма редактирования отзыва пользователя о курсе
     *
     * @param $course_id
     * @param $review_id
     */
    public function userCourseReview($course_id, $review_id)
    {
        if (!is_numeric($this->user_id))
        {
            show_404($this->page_url);
        }

        $course_data = $this->Course_model->getUserCourseSettings($course_id, $this->user_id);
        $review      = $this->Course_model->getUserCourseReview($course_id, $this->user_id, $review_id);
        $result      = array_merge($course_data, $review);

        // Сохранение отзыва
        if ($this->input->post('bt_save_review', true))
        {
            $review_text = mb_substr(strip_tags($this->input->post('ta_review_text', true)), 0, 1000);

            if (!empty($review_text) and $review_text != $review['review']['text'])
            {
                $res_review = $this->Course_model->updateUserCourseReview($course_id, $this->user_id, $review_id, $review_text, $this->date);

                if ($res_review === true)
                {
                    // Изменения сохранены
                    $this->session->set_tempdata('message', 10, 60);
                }
                else
                {
                    // Изменения не сохранены
                    $this->session->set_tempdata('message', 121, 60);
                }
            }

            header('Location: /profile/course/' . $course_id . '/review/' . $review_id);
        }
        elseif($this->input->post('bt_delete_review', true))
        {
            $res_review = $this->Course_model->deleteUserCourseReview($course_id, $this->user_id, $review_id);

            if ($res_review === true)
            {
                // Изменения сохранены
                $this->session->set_tempdata('message', 10, 60);

                header('Location: /profile/course/' . $course_id . '/reviews');
            }
            else
            {
                // Изменения не сохранены
                $this->session->set_tempdata('message', 123, 60);

                header('Location: /profile/course/' . $course_id . '/review/' . $review_id);
            }
        }

        // Объединенные данные страница
        $this->page_data['title'] = 'Мои курсы';
        $this->page_data['page_menu'] = 'u_courses';
        $this->page_data['page_submenu'] = 'reviews';

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/profile');
        $this->load->view('user/profile_line');
        $this->load->view('course/user_course/review', $result);
        $this->load->view('footer/footer');
    }

    /**
     * Список пользователей курса
     *
     * @param $course_id
     * @return void
     */
    public function courseUsersActivity($course_id)
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3) {
            show_404($this->page_url);
        }

        $this->load->model('User_model');

        $result['course_id']    = $course_id;
        $result['course_users'] = $this->Course_model->getCourseUsers($course_id);

        // Объединенные данные страница
        $this->page_data['title'] = 'АП - Активность клиентов';
        $this->page_data['page_menu'] = 'courses';
        $this->page_data['page_submenu'] = 'activity';

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('course/users_activity', $result);
        $this->load->view('footer/footer');
    }

    /**
     * Антропометрические данные пользователя курса и график
     *
     * @param $course_id
     * @param $user_id
     * @return void
     */
    public function courseUserActivity($course_id, $user_id)
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3) {
            show_404($this->page_url);
        }

        $this->load->model('User_model');

        $result['course_id']       = $course_id;
        $result['course_users']    = $this->Course_model->getCourseUsers($course_id);
        $result['course_users_id'] = $this->Course_model->getCourseUsersId($course_id);

        if (!empty($user_id) and in_array($user_id, $result['course_users_id']['id'])) {
            $user_data        = $this->User_model->getUser($user_id);
            $last_anthop_data = $this->User_model->getLastAnthropometricData($user_id);
            $all_anthop_data  = $this->User_model->getAnthropometricData($user_id);
            
            $result = array_merge($result, $last_anthop_data, $all_anthop_data, $user_data);
        }

        // Объединенные данные страница
        $this->page_data['title'] = 'АП - Активность клиентов';
        $this->page_data['page_menu'] = 'courses';
        $this->page_data['page_submenu'] = 'activity';

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('course/user_activity', $result);
        $this->load->view('footer/footer');
    }

    /**
     * Страница курса.
     *
     * Просмотр данных курса, возможность купить курс.
     *
     * @param $course_id
     * @return void
     */
    public function publicCourse($course_id)
    {
        // Выборка данных курса
        $course         = $this->Course_model->getAvailableCourse($course_id);
        $course_couches = $this->Course_model->getCourseCouchesId($course_id);
        $user_courses   = !empty($this->user_id) ? $this->Course_model->getUserCoursesId($this->user_id, $this->date) : array();
        $landing        = array();

        if (!empty($course['course']) and !empty($course['course']['landing']['id']))
        {
            $landing = $this->Course_model->getLandingPage($course_id);
        }

        // Сохранение купленного курса пользователем в БД
        if ($this->input->post('bt_buy_course', true))
        {
            // Данные курса
            $course = $course['course'];
            // Количество тренировок за курс
            $count_workouts = $course['count_weeks'] * $course['count_days'];
            // Выбранный тренер
            $id_couch = $this->input->post('user_couch', true);
            $user_couch = (is_numeric($id_couch) and in_array($id_couch, $course_couches['id'])) ? $id_couch : '';

            // Тренировочные дни
            $training_days = '';
            /*if (!empty($this->input->post('cb_day'))) {
                $days = $this->input->post('cb_day');
                $i = 1;
                foreach ($days as $day) {
                    if ($i <= $course['count_days']) {
                        $training_days .= $day;
                    }

                    $i++;
                }
                unset($day);
            }*/

            // Дата начала курса
            $start_date = '';
            $end_date   = '';
            /*$array_training_days = str_split($training_days);
            $tem_date            = new DateTime($this->date);
            $start_date          = $tem_date->format('Y-m-d');
            $end_date            = null;
            $set_start_date      = true; // Флаг начала отсчета дат

            // Текущий номер дня недели
            $current_num_day = date("N", strtotime($this->date));
            // Вычисление даты начала курса
            // Если текущий номер дня недели не присутствует в массиве выбранных тренировочных дней неделе,
            // то вычисляем дату следующего дня недели тренировки.
            if (!in_array($current_num_day, $array_training_days)) {
                // Поиск большего номера дня недели
                foreach ($array_training_days as $key => $training_day) {
                    if ($training_day > $current_num_day and $set_start_date === true) {
                        $diff_days = $training_day - $current_num_day;

                        $date = DateTime::createFromFormat('Y-m-d H:i:s', $this->date);
                        $date->add(new DateInterval('P' . $diff_days . 'D'));
                        $start_date = ($date !== false) ? $date->format('Y-m-d') : $start_date;

                        $set_start_date = false;
                    }
                }
                unset($training_day);

                // Если дата начала курса не изменилась, то берем первый выбранный номер дня недели тренировки
                if ($start_date == $this->date) {
                    $diff_days = 7 - $current_num_day + $array_training_days[0];

                    $date = DateTime::createFromFormat('Y-m-d H:i:s', $this->date);
                    $date->add(new DateInterval('P' . $diff_days . 'D'));
                    $start_date = $date !== false ? $date->format('Y-m-d') : null;
                }
            }

            // Изначальная дата окончания курса
            if (!empty($start_date)) {
                $count_days = ($course['count_weeks']*7) - 1;
                $date = DateTime::createFromFormat('Y-m-d', $start_date);
                $date->add(new DateInterval('P' . $count_days . 'D'));
                $end_date = $date !== false ? $date->format('Y-m-d') : null;
            }*/

            // Вариант оплаты (полный, разделить на месяцы)
            $options = array('full_payment', 'installments');
            $payment_option = in_array($this->input->post('s_payment_options', true), $options) ? $this->input->post('s_payment_options', true) : null;

            // Стоимость курса в зависимости от варианта оплаты и доступности такой оплаты в настройка курса
            if($payment_option == 'installments' and $course['recurrent'] === true)
            {
                $course_price = $course['recur_first'];
            }
            else
            {
                $course_price = $course['price'];
            }

            // Добавление товара в заказы пользователя
            $this->load->model('Store_model');

            $products['products'] = array( 0 => array(
                'id' => $course['p_id'],
                'cart_quantity' => 1,
                'price' => $course_price,
                'fc_price' => '',
                'discount_price' => '',
                'discount_fc_price' => '')
            );

            $res_order = $this->Store_model->setOrder($this->user_id, null, $this->session->user['name'], '', $this->session->user['email'], '',
                '', '', '', '', '', '', 0, 0, $products, $this->date);

            if ($res_order !== false and is_numeric($res_order['order_id']))
            {
                // Кол-во товаров в корзине
                parent::updateSessionCart(0);

                $payment_type = 'bank_card';

                if (!empty($payment_option))
                {
                    header('Location: /payment?oid=' . $res_order['order_id'] . '&amount=' . $res_order['total_amount']
                        . '&type=' . $payment_type. '&option=' . $payment_option);
                }

                /*$res_buy = $this->Course_model->setNewUserCourse($course_id, $this->user_id, $start_date, $end_date, $training_days, $user_couch, $this->date);

                if (is_numeric($res_buy))
                {
                    $uc_id = $res_buy;

                    if (!empty($training_days)) {
                        $this->Course_model->setUserTrainingWeeks($uc_id, $start_date, $training_days, $count_workouts, $course['count_days'], $this->date);
                    }
                }

                // Сохранено
                $this->session->set_tempdata('message', 10, 60);*/
            }
            else
            {
                // Не сохранено
                $this->session->set_tempdata('message', 101, 60);
                header('Location: /course/' . $course_id);
            }

            /*// Курс куплен (добавлен)
            $this->session->set_tempdata('message', 109, 60);
            header('Location: /profile/course/'.$course_id);*/

        }

        // Объединенные данные страница
        $this->page_data['title']     = (!empty($course['course']['name'])) ? $course['course']['name'] : 'Курс №' . $course_id;
        $this->page_data['page_menu'] = 'courses';

        $result = array_merge($course, $course_couches, $user_courses, $landing, $this->page_data);

        if (!empty($landing['landing']['html_page']))
        {
            $this->load->view($landing['landing']['html_page'].'header', $result);
            $this->load->view($landing['landing']['html_page'].'content');
            $this->load->view($landing['landing']['html_page'].'footer');
        }
        elseif (!empty($course['course']))
        {
            $this->load->view('header/header', $this->page_data);
            $this->load->view('header/secondary');
            $this->load->view('course/public_course', $result);
            $this->load->view('footer/footer');
        }
        else
        {
            $this->load->view('errors/html/error_404', $this->page_data);
        }
    }

    /**
     * Landing page со стандартным заполнением
     * @param $lp_id
     */
    public function defaultLanding($lp_id)
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3) {
            show_404($this->page_url);
        }

        $landing = $this->Course_model->getDefaultLandingPage($lp_id);

        // Объединенные данные страница
        $this->page_data['title'] = 'Default Landing page #' . $lp_id;
        $this->page_data['page_menu'] = '';

        $result = array_merge($landing, $this->page_data);

        if (!empty($result['landing']['html_page'])) {
            $this->load->view($result['landing']['html_page'].'header', $result);
            $this->load->view($result['landing']['html_page'].'content');
            $this->load->view($result['landing']['html_page'].'footer');
        }
        else {
            $this->load->view('errors/html/error_404', $this->page_data);
        }
    }

    /**
     * Landing page курса
     * @param $lp_id
     */
    public function landing($lp_id)
    {
        $landing = $this->Course_model->getLandingPage($lp_id);

        // Объединенные данные страница
        $this->page_data['title']     = 'Landing page';
        $this->page_data['page_menu'] = '';

        $result = array_merge($landing, $this->page_data);

        if (!empty($result['landing']['html_page'])) {
            $this->load->view($result['landing']['html_page'].'header', $result);
            $this->load->view($result['landing']['html_page'].'content');
            $this->load->view($result['landing']['html_page'].'footer');
        } else {
            $this->load->view('errors/html/error_404', $this->page_data);
        }
    }

    /* КОНЕЦ БЛОКА ФУНКЦИЙ КУРСОВ */


    /**
     * Загрузка видео
     *
     * @return void
     */
    public function uploadVideo()
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3) {
            show_404($this->page_url);
        }

        $this->load->helper('file');

        $result = array('video' => '', 'video_block' => '', 'error' => '');
        $path = './video/';

        // Загрузка видео на сервер
        if(is_uploaded_file($_FILES['upload_file']['tmp_name'])){

            $path_video = parent::uploadVideoFile('upload_file', $_FILES['upload_file']['type'], $path);
            if(file_exists('./video/'.$path_video)){
                if ($this->security->xss_clean('./video/'.$path_video, TRUE) !== FALSE) {
                    $result['video_block'] = 'Видео загружено.';
                    $result['video'] = $path_video;
                } else{
                    unlink('./video/'.$path_video);
                    $result['error'] = 'Видео не прошло проверку. Пожалуйста, повторите попытку.';
                }
            } else {
                $result['error'] = 'К сожалению, не удалось загрузить видео. Пожалуйста, повторите попытку.';
            }
        }
    }

    /**
     * Загрузка постера
     *
     * @return void
     */
    public function uploadPoster()
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3)
        {
            show_404($this->page_url);
        }

        $this->load->helper('file');

        $result = array('poster' => '', 'poster_block' => '', 'error' => '');
        $path   = './video/';
        // Загрузка постера на сервер
        if (is_uploaded_file($_FILES['poster_file']['tmp_name']))
        {
            $path_image = parent::uploadImage('poster_file', $_FILES['poster_file']['type'], $path);
            if(file_exists($path.$path_image))
            {
                if ($this->security->xss_clean($path.$path_image, TRUE) !== FALSE)
                {
                    $result['poster_block'] = '<div class="admin_form_file_line"> <img src="/video/' . $path_image . '" alt=""> </div>';
                    $result['poster'] = $path_image;
                }
                else
                {
                    unlink($path.$path_image);

                    $result['error'] = 'Постер не прошел проверку. Пожалуйста, повторите попытку.';
                }
            }
            else
            {
                $result['error'] = 'К сожалению, не удалось загрузить постер. Пожалуйста, повторите попытку.';
            }
        }

        echo json_encode($result, JSON_NUMERIC_CHECK);
    }

    /**
     * AJAX Удаление видео файла
     */
    public function deleteVideo()
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3)
        {
            show_404($this->page_url);
        }

        $result = array('result' => false);
        $video_path = is_file('./video/' . $this->input->post('video', true)) ? './video/' . $this->input->post('video', true) : '';

        if (!empty($video_path))
        {
            unlink($video_path);

            $result['result'] = true;
        }

        echo json_encode($result, JSON_NUMERIC_CHECK);
    }

    /**
     * AJAX Удаление файла постера
     */
    public function deletePoster()
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3)
        {
            show_404($this->page_url);
        }

        $result = array('result' => false);
        $poster_path = is_file('./video/' . $this->input->post('image', true)) ? './video/' . $this->input->post('image', true) : '';

        if (!empty($poster_path))
        {
            unlink($poster_path);

            $result['result'] = true;
        }

        echo json_encode($result, JSON_NUMERIC_CHECK);
    }

    /**
     * AJAX Поиск видео
     *
     * @return void
     */
    public function searchVideo()
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3)
        {
            show_404($this->page_url);
        }

        $result['video'] = false;

        $search_text = mb_substr(strip_tags($this->input->post('search_text', true)), 0, 255);
        $course_id   = is_numeric($this->input->post('c_id', true)) ? $this->input->post('c_id', true) : null;

        if (!empty($search_text) and !empty($course_id))
        {
            $result['video'] = $this->Course_model->searchVideo($course_id, $search_text);
        }

        echo json_encode($result, JSON_NUMERIC_CHECK);
    }

    /**
     * AJAX Сохранение просмотра видео
     *
     * @return void
     */
    public function viewedVideo()
    {
        // Если пользователь не авторизован, переход на страницу авторизации
        if (empty($this->user_id)) {
            header('Location: /login');
        }

        $workout_id = is_numeric($this->input->post('woid')) ? $this->input->post('woid') : null;

        $date = DateTime::createFromFormat('Y-m-d H:i:s', $this->date);
        $today = $date !== false ? $date->format('Y-m-d') : null;
        
        if (!empty($workout_id) and !empty($this->user_id)) {
            $result = $this->Course_model->setWorkoutDone($this->user_id, $workout_id, $today);
            
            if ($result === true) {
                echo "true";
            } else {
                echo "false";
            }
        } else {
            echo "false";
        }
    }

    /**
     * AJAX Отображение видео тренировки поверх календаря
     *
     * @return void
     */
    public function showVideo()
    {
        $video_id   = is_numeric($this->input->post('start_param', true)) ? $this->input->post('start_param', true) : null;
        $workout_id = is_numeric($this->input->post('end_param', true)) ? $this->input->post('end_param', true) : null;

        if (!empty($video_id))
        {
            // Проверка соответствия номера видео тренировке, курсу и пользователя
            $result = $this->Course_model->matchWorkoutVideo($this->user_id, $workout_id, $video_id);

            if ($result !== false)
            {
                // Данные видео
                $video_data = $this->Course_model->getVideo($video_id);
                $instruction_data = $this->Course_model->getVideo($result['workout']['instruction']);

                if ($video_data !== false)
                {
                    $workout_done = '';
                    $workout_description = '';
                    $workout_video = '';
                    $v_player = '';
                    $workout_instruction_a = '';
                    $workout_instruction = '';
                    $i_player = '';

                    $v_remove_url = $video_data['video']['remove_url'];
                    $v_poster = $video_data["video"]["poster"];
                    $v_video = $video_data["video"]["video"];
                    $i_remove_url = $instruction_data['video']['remove_url'];
                    $i_poster = $instruction_data["video"]["poster"];
                    $i_video = $instruction_data["video"]["video"];
                    $w_done = $result['workout']['done'];
                    $w_description = $result['workout']['description'];

                    include_once('./app_fold/views/video/player/video_player.php');

                    $result = array(
                        "done" => $workout_done,
                        "description" => $workout_description,
                        "video" => $workout_video,
                        "player" => $v_player,
                        "i_a" => $workout_instruction_a,
                        "i_video" => $workout_instruction,
                        "i_player" => $i_player
                    );

                    echo json_encode($result, JSON_NUMERIC_CHECK);
                }
                else
                {
                    $result['error'] = 'Video data error';
                    echo json_encode($result, JSON_NUMERIC_CHECK);
                }
            }
            else
            {
                $result['error'] = 'User course data error';
                echo json_encode($result, JSON_NUMERIC_CHECK);
            }
        }
        else
        {
            $result['error'] = 'Video ID empty';
            echo json_encode($result, JSON_NUMERIC_CHECK);
        }
    }

    /**
     * AJAX Отображение видео тренировки поверх календаря
     *
     * @return void
     */
    public function showWorkout()
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id)) {
            show_404($this->page_url);
        }

        $result = array('video' => array(), 'player' => array(), 'description' => array(), 'done' => array(), 'error' => '');

        // Данные тренировки
        $workout_data = $this->Course_model->getWorkoutVideo($this->user_id, $this->date);

        if ($workout_data !== false)
        {
            $i = 0;
            foreach ($workout_data['workouts'] as $workout)
            {
                if (!empty($workout['video_id']))
                {
                    // Данные видео
                    $video_data = $this->Course_model->getVideo($workout['video_id']);
                    $instruction_data = $this->Course_model->getVideo($workout['instruction']);

                    if ($video_data !== false)
                    {
                        $workout_done = '';
                        $workout_description = '';
                        $workout_video = '';
                        $v_player = '';
                        $workout_instruction_a = '';
                        $workout_instruction = '';
                        $i_player = '';

                        $v_remove_url = $video_data['video']['remove_url'];
                        $v_poster = $video_data["video"]["poster"];
                        $v_video = $video_data["video"]["video"];
                        $i_remove_url = $instruction_data['video']['remove_url'];
                        $i_poster = $instruction_data["video"]["poster"];
                        $i_video = $instruction_data["video"]["video"];
                        $w_done = $workout['done'];
                        $w_description = $workout['description'];

                        include_once('./app_fold/views/video/player/video_player.php');

                        $result['video'][$i]  = $workout_video;
                        $result['player'][$i] = $v_player;
                        $result['i_a'][$i]  = $workout_instruction_a;
                        $result['i_video'][$i]  = $workout_instruction;
                        $result['i_player'][$i] = $i_player;
                        $result['description'][$i] = $workout_description;
                        $result['done'][$i] = $workout_done;
                    }
                    else
                    {
                        $result['error'] = 'Video data error';
                    }
                }
                else
                {
                    $result['error'] = 'Workout data error';
                }

                $i++;
            }
            unset($workout);

            echo json_encode($result, JSON_NUMERIC_CHECK);
        }
        else
        {
            $result['error'] = 'Not found today workout';
            echo json_encode($result, JSON_NUMERIC_CHECK);
        }
    }
}