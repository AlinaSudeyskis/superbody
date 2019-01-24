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
    }


    /* БЛОК ФУНКЦИЙ КАТЕГОРИИ КУРСА */

    /**
     * Вывод последних сохраненных категории курса
     *
     * @return void
     */
    public function courseTypes()
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3 or $this->session->user['blocked'] == 1) {
            parent::pageNotFound($this->page_url);
        }

        // Получение данных о типах курсов
        $result = $this->Course_model->getCourseTypes();

        // Объединенные данные страница
        $this->page_data['title']        = 'АП - Категории курсов';
        $this->page_data['page_menu']    = 'a_courses_w';
        $this->page_data['page_submenu'] = 'courses_types';

        $this->load->view('header/header_admin', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('course/types/types', $result);
        $this->load->view('footer/footer');
    }

    /**
     * Вывод формы и валидация введенных данных нового категории курса
     *
     * @return void
     */
    public function newCourseTypes()
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3 or $this->session->user['blocked'] == 1) {
            parent::pageNotFound($this->page_url);
        }

        // Сохранение нового типа курса
        if ($this->input->post('bt_save_new_type', true))
        {
            // Имя пользователя
            $name = mb_substr(strip_tags($this->input->post('name', true)), 0, 255);

            if (!empty($name))
            {
                $result = $this->Course_model->setNewCourseType($name, $this->date);

                if (is_numeric($result))
                {
                    // Изменения сохранены
                    $this->session->set_tempdata('message', 10, 60);
                    header('Location: /administration/courses/type/'.$result);
                }
                else
                {
                    // Изменения не сохранены
                    $this->session->set_tempdata('message', 25, 60);
                    header('Location: /administration/courses/type/new');
                }
            }
        }

        // Объединенные данные страница
        $this->page_data['title']        = 'АП - Добавление новой категории курса';
        $this->page_data['page_menu']    = 'a_courses_w';
        $this->page_data['page_submenu'] = 'courses_types';

        $this->load->view('header/header_admin', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('course/types/new_type');
        $this->load->view('footer/footer');
    }

    /**
     * Вывод формы и валидация изменных данных категории курса
     *
     * @param $type_id
     * @return void
     */
    public function courseType($type_id)
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3 or $this->session->user['blocked'] == 1)
        {
            parent::pageNotFound($this->page_url);
        }

        // Сохранение изменений типа курса
        if ($this->input->post('bt_save_type_settings', true) and is_numeric($type_id))
        {
            // Имя пользователя
            $name = mb_substr(strip_tags($this->input->post('name', true)), 0, 255);

            if (!empty($name))
            {
                $result = $this->Course_model->setCourseTypeSettings($type_id, $name, $this->date);

                if ($result === true)
                {
                    // Изменения сохранены
                    $this->session->set_tempdata('message', 10, 60);
                }
                else
                {
                    // Изменения не сохранены
                    $this->session->set_tempdata('message', 25, 60);
                }
            }
            header('Location: /administration/courses/type/'.$type_id);
        }

        $result = $this->Course_model->getCourseType($type_id);

        // Объединенные данные страница
        $this->page_data['title']        = 'АП - Изменение данных категории курса';
        $this->page_data['page_menu']    = 'a_courses_w';
        $this->page_data['page_submenu'] = 'courses_types';

        $this->load->view('header/header_admin', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('course/types/type_settings', $result);
        $this->load->view('footer/footer');
    }

    /* КОНЕЦ БЛОКА ФУНКЦИЙ КАТЕГОРИИ КУРСА */


    /**
     * Вывод последних сохраненных типов приемов пищи
     *
     * @return void
     */
    public function ingestionTypes()
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3 or $this->session->user['blocked'] == 1) {
            parent::pageNotFound($this->page_url);
        }

        // Получение данных о типах курсов
        $result = $this->Course_model->getIngestionTypes();

        // Объединенные данные страница
        $this->page_data['title'] = 'АП - Типы приемов пищи';
        $this->page_data['page_menu'] = 'ingestion_type';

        $this->load->view('header/header_admin', $this->page_data);
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
        if (empty($this->user_id) or $this->session->user['type'] != 3 or $this->session->user['blocked'] == 1) {
            parent::pageNotFound($this->page_url);
        }

        // Сохранение нового типа приемов пищи
        if ($this->input->post('bt_save_new_type', true)) {
            // Имя пользователя
            $name = mb_substr(strip_tags($this->input->post('name', true)), 0, 255);

            if (!empty($name))
            {
                $result = $this->Course_model->setNewIngestionType($name, $this->date);

                if (is_numeric($result))
                {
                    // Изменения сохранены
                    $this->session->set_tempdata('message', 10, 60);
                    header('Location: /administration/ingestion/type/'.$result);
                }
                else
                {
                    // Изменения не сохранены
                    $this->session->set_tempdata('message', 27, 60);
                    header('Location: /administration/ingestion/type/new');
                }
            }
        }

        // Объединенные данные страница
        $this->page_data['title'] = 'АП - Добавление нового типа приемов пищи';
        $this->page_data['page_menu'] = 'ingestion_type';

        $this->load->view('header/header_admin', $this->page_data);
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
        if (empty($this->user_id) or $this->session->user['type'] != 3 or $this->session->user['blocked'] == 1) {
            parent::pageNotFound($this->page_url);
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

        $this->load->view('header/header_admin', $this->page_data);
        $this->load->view('header/admin');

        if (is_numeric($type_id)) {
            $result = $this->Course_model->getIngestionType($type_id);

            $this->load->view('ingestion/type_settings', $result);
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
        if (empty($this->user_id) or $this->session->user['type'] != 3 or $this->session->user['blocked'] == 1) {
            parent::pageNotFound($this->page_url);
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
        if (empty($this->user_id) or $this->session->user['type'] != 3 or $this->session->user['blocked'] == 1)
        {
            parent::pageNotFound($this->page_url);
        }

        $result = $this->Course_model->getPromoVideo();
        
        // Объединенные данные страница
        $this->page_data['title'] = 'АП - Видео';
        $this->page_data['page_menu'] = 'video';
        $this->page_data['page_submenu'] = 'promo';

        $this->load->view('header/header_admin', $this->page_data);
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
        if (empty($this->user_id) or $this->session->user['type'] != 3 or $this->session->user['blocked'] == 1)
        {
            parent::pageNotFound($this->page_url);
        }

        $result = $this->Course_model->getVideoCourses();

        // Объединенные данные страница
        $this->page_data['title'] = 'АП - Видео';
        $this->page_data['page_menu'] = 'video';
        $this->page_data['page_submenu'] = 'courses';

        $this->load->view('header/header_admin', $this->page_data);
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
        if (empty($this->user_id) or $this->session->user['type'] != 3 or $this->session->user['blocked'] == 1)
        {
            parent::pageNotFound($this->page_url);
        }

        $result = $this->Course_model->getUncategorizedVideo();

        // Объединенные данные страница
        $this->page_data['title'] = 'АП - Видео';
        $this->page_data['page_menu'] = 'video';
        $this->page_data['page_submenu'] = 'uncategorized';

        $this->load->view('header/header_admin', $this->page_data);
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
        if (empty($this->user_id) or $this->session->user['type'] != 3 or $this->session->user['blocked'] == 1)
        {
            parent::pageNotFound($this->page_url);
        }

        $result = $this->Course_model->getInstructionsVideo();

        // Объединенные данные страница
        $this->page_data['title'] = 'АП - Видео';
        $this->page_data['page_menu'] = 'video';
        $this->page_data['page_submenu'] = 'instructions';

        $this->load->view('header/header_admin', $this->page_data);
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
        if (empty($this->user_id) or $this->session->user['type'] != 3 or $this->session->user['blocked'] == 1)
        {
            parent::pageNotFound($this->page_url);
        }

        $result = $this->Course_model->getCourseVideo($course_id);

        // Объединенные данные страница
        $this->page_data['title'] = 'АП - Видео';
        $this->page_data['page_menu'] = 'video';
        $this->page_data['page_submenu'] = 'courses';

        $this->load->view('header/header_admin', $this->page_data);
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
        if (empty($this->user_id) or $this->session->user['type'] != 3 or $this->session->user['blocked'] == 1) {
            parent::pageNotFound($this->page_url);
        }

        $courses = $this->Course_model->getWorkoutCourses();

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

            // Id тренировки курса
            $workout_num = (is_numeric($this->input->post('hi_ctw', true))) ? $this->input->post('hi_ctw', true) : null;
            
            if (!empty($video_path) or !empty($remove_url))
            {
                $result = $this->Course_model->setNewVideo($type, $course_id, $name, $video_path, $poster_path, $remove_url, $this->user_id, $this->date);

                //echo 'T '.$type.' N '.$name.' RU '.$remove_url.' PP '.$poster_path.' VP '.$video_path.'<br/>';

                if (is_numeric($result) and $result !== false)
                {
                    $video_id = $result;

                    // Прикрепление видео к тренировке
                    if(!empty($workout_num) and !empty($course_id))
                    {
                        $this->Course_model->attachVideoToWorkout($course_id, $workout_num, $video_id, $this->date);
                    }

                    // Изменения сохранены
                    $this->session->set_tempdata('message', 10, 60);

                    header('Location: /administration/video/' . $video_id);
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

        $this->load->view('header/header_admin', $this->page_data);
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
        if (empty($this->user_id) or $this->session->user['type'] != 3 or $this->session->user['blocked'] == 1) {
            parent::pageNotFound($this->page_url);
        }

        $video_id = (is_numeric($video_id)) ? $video_id : '';

        $video   = $this->Course_model->getVideo($video_id);
        $courses = $this->Course_model->getWorkoutCourses();
        $result  = array_merge($video, $courses);

        if ($this->input->post('bt_save_video', true) and !empty($video_id))
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

            // Id тренировки курса
            $workout_num = (is_numeric($this->input->post('hi_ctw', true))) ? $this->input->post('hi_ctw', true) : null;

            // Прикрепление видео к тренировке
            if(!empty($workout_num) and !empty($course_id))
            {
                $this->Course_model->attachVideoToWorkout($course_id, $workout_num, $video_id, $this->date);
            }

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
        elseif ($this->input->post('bt_block_video', true) and !empty($video_id)) {
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
        elseif ($this->input->post('bt_unblock_video', true) and !empty($video_id)) {
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
        elseif ($this->input->post('bt_delete_video', true) and !empty($video_id)) {
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

        $this->load->view('header/header_admin', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('video/video_settings', $result);
        $this->load->view('footer/footer');
    }

    /* КОНЕЦ БЛОКА ФУНКЦИЙ ДЛЯ РАБОТЫ С ВИДЕО */

    /* БЛОК ФУНКЦИЙ КУРСОВ ТРЕНИРОВОК */

    /**
     * Вывод списка курсов в админ. панели
     *
     * @param $courses_category
     * @param $archive
     */
    public function courses($courses_category = 'workout', $archive = 0)
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3 or $this->session->user['blocked'] == 1)
        {
            parent::pageNotFound($this->page_url);
        }

        $courses_page = ($courses_category == 'nutrition') ? 'nutritions' : 'courses';

        if ($this->input->post('bt_deactivate_landing', true))
        {
            $course_id = is_numeric($this->input->post('i_course_id', true)) ? $this->input->post('i_course_id', true) : null;

            if (!empty($course_id))
            {
                $result = $this->Course_model->deactivateCourseLandingPage($course_id, $this->date);

                if ($result === true) {
                    // Изменения сохранены
                    $this->session->set_tempdata('message', 10, 60);
                } else {
                    // Не удалось деактивировать
                    $this->session->set_tempdata('message', 100, 60);
                }
            }
            else
            {
                // Не удалось деактивировать
                $this->session->set_tempdata('message', 100, 60);
            }

            header('Location: /administration/' . $courses_page);
        }
        elseif ($this->input->post('bt_activate_landing', true))
        {
            $course_id = is_numeric($this->input->post('i_course_id', true)) ? $this->input->post('i_course_id', true) : null;

            if (!empty($course_id))
            {
                $result = $this->Course_model->activateCourseLandingPage($course_id, $this->date);

                if ($result === true)
                {
                    // Изменения сохранены
                    $this->session->set_tempdata('message', 10, 60);
                }
                else
                {
                    // Не удалось активировать
                    $this->session->set_tempdata('message', 99, 60);
                }
            }
            else
            {
                // Не удалось активировать
                $this->session->set_tempdata('message', 99, 60);
            }

            header('Location: /administration/' . $courses_page);
        }

        // Курсы тренировок
        if($courses_category == 'workout' and $archive == 0)
        {
            self::workoutCourses();
        }
        // Курсы питания
        elseif($courses_category == 'nutrition' and $archive == 0)
        {
            self::nutritionCourses();
        }
        // Архив курсов тренировок
        elseif($courses_category == 'workout' and $archive == 1)
        {
            self::workoutCoursesArchive();
        }
        // Архив курсов питания
        elseif($courses_category == 'nutrition' and $archive == 1)
        {
            self::nutritionCoursesArchive();
        }
        else
        {
            parent::pageNotFound($this->page_url);
        }
    }

    /**
     * Список курсов тренировок
     */
    protected function workoutCourses()
    {
        // Получение списка добавленных курсов
        $result = $this->Course_model->getCourses('workout', 0);

        // Объединенные данные страница
        $this->page_data['title']        = 'АП - Курсы тренировок';
        $this->page_data['page_menu']    = 'a_courses_w';
        $this->page_data['page_submenu'] = 'a_courses_w';

        $this->load->view('header/header_admin', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('course/settings/courses', $result);
        $this->load->view('footer/footer');
    }

    /**
     * Архив курсов тренировок
     */
    protected function workoutCoursesArchive()
    {
        // Получение списка курсов
        $result = $this->Course_model->getCourses('workout', 1);

        // Объединенные данные страница
        $this->page_data['title']        = 'АП - Архив курсов тренировок';
        $this->page_data['page_menu']    = 'a_courses_w';
        $this->page_data['page_submenu'] = 'courses_archive';

        $this->load->view('header/header_admin', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('course/settings/courses', $result);
        $this->load->view('footer/footer');
    }

    /**
     * Форма добавления и обработка данных нового курса тренировок
     */
    public function newCourse()
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3 or $this->session->user['blocked'] == 1) {
            parent::pageNotFound($this->page_url);
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

            // Metadata
            $meta_description = mb_substr(strip_tags($this->input->post('ta_meta_description', true)), 0, 255);
            $meta_keywords = mb_substr(strip_tags($this->input->post('ta_meta_keywords', true)), 0, 1000);

            // Стоиомсть курса
            $price = is_numeric($this->input->post('price', true)) ? $this->input->post('price', true) : '';
            $fc_price = is_numeric($this->input->post('fc_price', true)) ? $this->input->post('fc_price', true) : '';

            // Рекуррентная стоимость
            $recur_price      = $price;
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
            $course_type = is_numeric($type) and in_array($type, $course_types['types_id']) ? $type : 1;

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

            for ($w = 0; $w < $count_workouts; $w++)
            {
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

            if (!empty($name) and !empty($description) and !empty($price))
            {
                $course_category = 'workout';

                $course_id = $this->Course_model->setNewCourse($course_category, $name, $description, $meta_description,
                    $meta_keywords, $price, $fc_price, $course_type, $count_weeks, $count_days, $count_rest,
                    $this->user_id, $this->date);
            }

            if (!empty($course_id) and is_numeric($course_id))
            {
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
                // Сохранение даынных о рекуррентном платеже
                $result_recurrent = $this->Course_model->setCourseRecurrentPrice($course_id, $recur_price, $recur_months, $recur_first, $recur_subsequent, $this->user_id, $this->date);

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
        $this->page_data['title']        = 'АП - Добавление нового курса';
        $this->page_data['page_menu']    = 'a_courses_w';
        $this->page_data['page_submenu'] = 'a_courses_w';
        
        $this->load->view('header/header_admin', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('course/settings/new_course', $course_types);
        $this->load->view('footer/footer');
    }

    /**
     * Вывод данных и сохраненение изменений курса
     *
     * @param $course_id
     * @param string $page_type (settings, landing, statistics, reviews, review)
     * @param int|null $page_id
     * @return void
     */
    public function course($course_id, $page_type = 'settings', $page_id = null)
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3 or $this->session->user['blocked'] == 1) {
            parent::pageNotFound($this->page_url);
        }

        if ($page_type == 'settings')
        {
            self::courseSettings($course_id);
        }
        elseif ($page_type == 'landing')
        {
            $block_id = is_numeric($page_id) ? $page_id : 1;
            self::courseLanding($course_id, $block_id);
        }
        elseif ($page_type == 'statistics')
        {
            self::courseStatistics($course_id);
        }
        elseif ($page_type == 'reviews')
        {
            self::courseReviews($course_id);
        }
        elseif ($page_type == 'review' and is_numeric($page_id))
        {
            self::courseReview($course_id, $page_id);
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
        elseif($page_type == 'promocodes')
        {
            self::coursePromocodes($course_id);
        }
        elseif($page_type == 'promocode_new')
        {
            self::newCoursePromocode($course_id);
        }
        elseif($page_type == 'promocode' and is_numeric($page_id))
        {
            self::coursePromocode($course_id, $page_id);
        }
        elseif($page_type == 'extends')
        {
            self::courseExtends($course_id);
        }
        elseif($page_type == 'extend_new')
        {
            self::newCourseExtend($course_id);
        }
        elseif($page_type == 'extend' and is_numeric($page_id))
        {
            self::courseExtend($course_id, $page_id);
        }
        elseif($page_type == 'attached' and empty($page_id))
        {
            self::courseAttachedCourses($course_id);
        }
        elseif($page_type == 'attach_new')
        {
            self::newCourseAttach($course_id);
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

            // Metadata
            $meta_description = mb_substr(strip_tags($this->input->post('ta_meta_description', true)), 0, 255);
            $meta_keywords = mb_substr(strip_tags($this->input->post('ta_meta_keywords', true)), 0, 1000);

            // Стоиомсть курса
            $price    = is_numeric($this->input->post('price', true)) ? $this->input->post('price', true) : '';
            $fc_price = is_numeric($this->input->post('fc_price', true)) ? $this->input->post('fc_price', true) : '';

            // Рекуррентная стоимость
            $recur_price      = $price;
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
            $course_type = (is_numeric($type) and in_array($type, $course_types['types_id'])) ? $type : '';

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
            $id_video          = $this->input->post('id_video', true);
            $cb_repeat_workout = $this->input->post('cb_repeat_workout', true);
            $s_repeat_workout  = $this->input->post('s_repeat_workout', true);
            $ta_workout_desc   = $this->input->post('ta_workout_desc', true);

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
            if ($name != $course['name'] or $description != $course['description'] or $price != $course['price']
                or $course_type != $course['type'] or $meta_description != $course['meta_description']
                or $meta_keywords != $course['meta_keywords'] or $count_weeks != $course['count_weeks']
                or $count_days != $course['count_days'] or $count_rest != $course['count_rest']
                or $course_image != ('.' . $course['image'])) {

                $result_settings = $this->Course_model->setCourseSettings($course_id, $course_image, $name, $description,
                    $meta_description, $meta_keywords, $price, $fc_price, $course_type, $count_weeks, $count_days,
                    $count_rest, $this->date);
            }

            // Сохранение данных рекуррентной цены
            if ($recur_months != $course['recur_months'] or $recur_first != $course['recur_first']
                or $recur_subsequent != $course['recur_subsequent'])
            {
                $result_recurrent = $this->Course_model->setCourseRecurrentPrice($course_id, $recur_price, $recur_months, $recur_first, $recur_subsequent, $this->user_id, $this->date);
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
            /*elseif($result_settings === false or $result_schedule === false or $result_recurrent === false
                or $result_couches === false)
            {
                // Основные данные не сохранены
                $this->session->set_tempdata('message', 130, 60);
                log_message('debug', 'Не все данные курса сохранены. POST data: ' . print_r($this->input->post(), true));
            }*/

            header('Location: /administration/course/'.$course_id);
        }
        elseif ($this->input->post('bt_block_course', true))
        {
            $result = $this->Course_model->blockCourse($course_id, $this->date);

            if ($result === true)
            {
                // Изменения сохранены
                $this->session->set_tempdata('message', 10, 60);
            }
            else
            {
                // Изменения не сохранены
                $this->session->set_tempdata('message', 33, 60);
            }

            header('Location: /administration/course/' . $course_id);
        }
        elseif ($this->input->post('bt_unblock_course', true))
        {
            $result = $this->Course_model->unblockCourse($course_id, $this->date);

            if ($result === true)
            {
                // Изменения сохранены
                $this->session->set_tempdata('message', 10, 60);
            }
            else
            {
                // Изменения не сохранены
                $this->session->set_tempdata('message', 34, 60);
            }

            header('Location: /administration/course/' . $course_id);
        }
        elseif ($this->input->post('bt_delete_course', true))
        {
            if ($course['course']['bought'] === false)
            {
                // Удалить курс
                $del_course = $this->Course_model->deleteCourse($course_id);

                if ($del_course === true)
                {
                    // Курс удален
                    $this->session->set_tempdata('message', 108, 60);
                    header('Location: /administration/courses/');
                }
                else
                {
                    // Не удалось удалить курс
                    $this->session->set_tempdata('message', 107, 60);
                    header('Location: /administration/course/' . $course_id);
                }
            }
            else
            {
                // Не возможно удалить курс (куплен пользователем)
                $this->session->set_tempdata('message', 106, 60);
                header('Location: /administration/course/' . $course_id);
            }
        }
        elseif ($this->input->post('bt_archive_course', true))
        {
            $res_data = $this->Course_model->archiveCourse($course_id, 1, $this->user_id, $this->date);

            if ($res_data === true)
            {
                // Курс добавлен в архив
                $this->session->set_tempdata('message', 181, 60);
            }
            else
            {
                // Не удалось добавить курс в архив
                $this->session->set_tempdata('message', 182, 60);
            }

            header('Location: /administration/course/' . $course_id);
        }
        elseif ($this->input->post('bt_from_archive_course', true))
        {
            $res_data = $this->Course_model->archiveCourse($course_id, 0, $this->user_id, $this->date);

            if ($res_data === true)
            {
                // Курс добавлен в архив
                $this->session->set_tempdata('message', 183, 60);
            }
            else
            {
                // Не удалось добавить курс в архив
                $this->session->set_tempdata('message', 184, 60);
            }

            header('Location: /administration/course/' . $course_id);
        }

        $result = array_merge($course_types, $course);

        // Объединенные данные страница
        $this->page_data['title'] = 'АП - Редактирование данных курса';
        $this->page_data['page_menu'] = 'a_courses_w';
        $this->page_data['page_submenu'] = 'settings';
        $this->page_data['course_id'] = $course_id;

        $this->load->view('header/header_admin', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('course/settings/course', $result);
        $this->load->view('footer/footer');
    }

    /**
     * Редактирование и сохранение Landing page курса
     *
     * @param $course_id
     * @param $block_id
     */
    protected function courseLanding($course_id, $block_id = 1)
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

        if ($this->input->post('bt_save_block_1', true))
        {
        	// Скрыть блок со страницы просмотра
	        $hide_block = (!empty($this->input->post('cb_hide_block1', true))) ? 1 : 0;

            // Стиль
            $landing_style = in_array($this->input->post('s_land_type', true), $landing_list['landings_id'])
                ? $this->input->post('s_land_type', true) : 1;

            // Цвет фона блока
            $color = $this->input->post('i_bg_color_block1', true);
            $b1_bg_color = (!empty($color) and preg_match($regexp_color, $color)) ? $color : '';

            // Прозрачность фонового изображения блока
            $b1_bg_opacity = is_numeric($this->input->post('r_opacity_block1', true)) ? $this->input->post('r_opacity_block1', true) : 0;

            // Слайдер (max 7 images)
            $slider_images = (!empty($landing['full_slider_images'])) ? explode(';', $landing['full_slider_images']) : array();
            $input_files   = $_FILES;
            if(is_uploaded_file($input_files['slider_files']['tmp_name'][0]))
            {
                $count_images           = count($slider_images);
                $available_count_images = ((7 - $count_images) < 0) ? 0 : (7 - $count_images);

                if($available_count_images > 0)
                {
                    $i   = 0;
                    $imi = $count_images + 1;
                    foreach ($input_files['slider_files']['name'] as $name)
                    {
                        $slider_image = '';

                        $_FILES['slider_files'] = array(
                            'name' => $input_files['slider_files']['name'][$i],
                            'type' => $input_files['slider_files']['type'][$i],
                            'tmp_name' => $input_files['slider_files']['tmp_name'][$i],
                            'error' => $input_files['slider_files']['error'][$i],
                            'size' => $input_files['slider_files']['size'][$i]);

                        if (!empty($_FILES['slider_files']) and is_uploaded_file($_FILES['slider_files']['tmp_name']))
                        {
                            $image = parent::uploadImage('slider_files', $_FILES['slider_files']['type'], $img_path);
                            $full_path_img = $img_path . $image;
                            if (file_exists($full_path_img))
                            {
                                if ($this->security->xss_clean($full_path_img, TRUE) !== FALSE)
                                {
                                    $slider_image = $full_path_img;
                                }
                                else
                                {
                                    unlink($full_path_img);
                                }
                            }
                        }


                        if(!empty($slider_image))
                        {
                            $slider_images[$imi] = $slider_image;

                            $imi++;
                        }

                        $i++;

                        if ($i == $available_count_images) {
                            break;
                        }
                    }
                }
            }
            elseif ($this->input->post('cb_slider_block1', true))
            {
                // Удаление изображений
                if(!empty($slider_images))
                {
                    foreach($slider_images as $s_image)
                    {
                        if(is_file($s_image))
                        {
                            unlink($s_image);
                        }
                    }
                    unset($s_image);
                }
                $slider_images = 'default';
            }
            elseif(empty($slider_images) and !$this->input->post('cb_slider_block1', true))
            {
                $slider_images = 'not_default';
            }

            $slider_images = (empty($slider_images)) ? 'default' : implode(';', $slider_images);

            // Заголовк страницы
            $main_title_bbcode = mb_substr(strip_tags($this->input->post('ta_main_title'), '<span><br/><b><i><p>'), 0, 255);

            $up_res = $this->Course_model->setCourseLandingBlock1($course_id, $hide_block, $landing_style,
                $b1_bg_color, $b1_bg_opacity, $slider_images, $main_title_bbcode, $this->date);

            if ($up_res === true) {
                // Изменения сохранены
                $this->session->set_tempdata('message', 10, 60);
            }
            else {
                // Изменения не сохранены
                $this->session->set_tempdata('message', 112, 60);
            }

            header('Location: /administration/course/'.$course_id.'/landing/1');
        }
        elseif ($this->input->post('bt_save_block_2', true))
        {
	        // БЛОК 2
	        // Скрыть блок со страницы просмотра
	        $hide_block = (!empty($this->input->post('cb_hide_block2', true))) ? 1 : 0;

            // Шапка фона
            $b2_bg_top = (!empty($landing['block2']['bg_top_orig']) and is_file($landing['block2']['bg_top_orig']))
                ? $landing['block2']['bg_top_orig']
                : 'not_default';
            if (is_uploaded_file($_FILES['bg_top_file_block2']['tmp_name']))
            {
                $image = parent::uploadImage('bg_top_file_block2', $_FILES['bg_top_file_block2']['type'], $img_path);
                $full_path_img = $img_path . $image;
                if (file_exists($full_path_img))
                {
                    if ($this->security->xss_clean($full_path_img, TRUE) !== FALSE)
                    {
                        if(is_file($b2_bg_top))
                        {
                            unlink($b2_bg_top);
                        }
                        $b2_bg_top = $full_path_img;
                    }
                    else
                    {
                        unlink($full_path_img);
                    }
                }
            }
            elseif($this->input->post('cb_default_bg_top_block2', true))
            {
                if(is_file($b2_bg_top))
                {
                    unlink($b2_bg_top);
                }
                $b2_bg_top = 'default';
            }

            // Фон
            $b2_bg = (!empty($landing['block2']['bg_orig']) and is_file($landing['block2']['bg_orig']))
                ? $landing['block2']['bg_orig']
                : 'not_default';
            // Файл фона
            if (is_uploaded_file($_FILES['bg_file_block2']['tmp_name']))
            {
                $image = parent::uploadImage('bg_file_block2', $_FILES['bg_file_block2']['type'], $img_path);
                $full_path_img = $img_path . $image;
                if (file_exists($full_path_img))
                {
                    if ($this->security->xss_clean($full_path_img, TRUE) !== FALSE)
                    {
                        if(is_file($b2_bg))
                        {
                            unlink($b2_bg);
                        }
                        $b2_bg = $full_path_img;
                    }
                    else
                    {
                        unlink($full_path_img);
                    }
                }
            }
            elseif($this->input->post('cb_default_bg_block2', true))
            {
                if(is_file($b2_bg))
                {
                    unlink($b2_bg);
                }
                $b2_bg = 'default';
            }

            // Цвет фона блока
            $color = $this->input->post('i_bg_color_block2', true);
            $b2_bg_color = (!empty($color) and preg_match($regexp_color, $color)) ? $color : '';

            // Прозрачность фонового изображения блока
            $b2_bg_opacity = is_numeric($this->input->post('r_opacity_block2', true)) ? $this->input->post('r_opacity_block2', true) : 0;

            // Изображение тренера
            $b2_image = (!empty($landing['block2']['image_orig']) and is_file($landing['block2']['image_orig']))
                ? $landing['block2']['image_orig']
                : 'not_default';
            if (is_uploaded_file($_FILES['couch_file_block2']['tmp_name']))
            {
                $image = parent::uploadImage('couch_file_block2', $_FILES['couch_file_block2']['type'], $img_path);
                $full_path_img = $img_path . $image;
                if (file_exists($full_path_img))
                {
                    if ($this->security->xss_clean($full_path_img, TRUE) !== FALSE)
                    {
                        if(is_file($b2_image))
                        {
                            unlink($b2_image);
                        }
                        $b2_image = $full_path_img;
                    }
                    else
                    {
                        unlink($full_path_img);
                    }
                }
            }
            elseif ($this->input->post('cb_couch_image_block2', true))
            {
                if(is_file($b2_image))
                {
                    unlink($b2_image);
                }
                $b2_image = 'default';
            }

            // Информация
            $b2_title    = mb_substr(strip_tags($this->input->post('i_title_block2', true)), 0, 60);
            $b2_subtitle = mb_substr(strip_tags($this->input->post('i_subtitle_block2', true)), 0, 70);
            $b2_text     = mb_substr(strip_tags($this->input->post('i_text_block2', true)), 0, 60);
            $b2_button   = mb_substr(strip_tags($this->input->post('i_button_block2', true)), 0, 40);

            $up_res = $this->Course_model->setCourseLandingBlock2($course_id, $hide_block, $b2_bg_top, $b2_bg_color,
                $b2_bg_opacity, $b2_bg, $b2_image, $b2_title, $b2_subtitle, $b2_text, $b2_button, $this->date);


            if ($up_res === true) {
                // Изменения сохранены
                $this->session->set_tempdata('message', 10, 60);
            } else {
                // Изменения не сохранены
                $this->session->set_tempdata('message', 112, 60);
            }

            header('Location: /administration/course/'.$course_id.'/landing/2');
        }
        elseif ($this->input->post('bt_save_block_3', true))
        {
            // БЛОК 3
	        // Скрыть блок со страницы просмотра
	        $hide_block = (!empty($this->input->post('cb_hide_block3', true))) ? 1 : 0;

            // Фон
            $b3_bg = (!empty($landing['block3']['bg_orig']) and is_file($landing['block3']['bg_orig']))
                ? $landing['block3']['bg_orig']
                : 'not_default';
            // Файл фона
            if (is_uploaded_file($_FILES['bg_file_block3']['tmp_name']))
            {
                $image = parent::uploadImage('bg_file_block3', $_FILES['bg_file_block3']['type'], $img_path);
                $full_path_img = $img_path . $image;
                if (file_exists($full_path_img))
                {
                    if ($this->security->xss_clean($full_path_img, TRUE) !== FALSE)
                    {
                        if(is_file($b3_bg))
                        {
                            unlink($b3_bg);
                        }
                        $b3_bg = $full_path_img;
                    }
                    else
                    {
                        unlink($full_path_img);
                    }
                }
            }
            elseif ($this->input->post('cb_default_bg_block3', true))
            {
                if(is_file($b3_bg))
                {
                    unlink($b3_bg);
                }
                $b3_bg = 'default';
            }

            // Цвет фона блока
            $color = $this->input->post('i_bg_color_block3', true);
            $b3_bg_color = (!empty($color) and preg_match($regexp_color, $color)) ? $color : '';

            // Прозрачность фонового изображения блока
            $b3_bg_opacity = is_numeric($this->input->post('r_opacity_block3', true)) ? $this->input->post('r_opacity_block3', true) : 0;

            // Изображение 1
            $b3_image1 = (!empty($landing['block3']['image1_orig']) and is_file($landing['block3']['image1_orig']))
                ? $landing['block3']['image1_orig']
                : 'not_default';
            // Изображение 1
            if (is_uploaded_file($_FILES['result_file1_block3']['tmp_name']))
            {
                $image = parent::uploadImage('result_file1_block3', $_FILES['result_file1_block3']['type'], $img_path);
                $full_path_img = $img_path . $image;
                if (file_exists($full_path_img))
                {
                    if ($this->security->xss_clean($full_path_img, TRUE) !== FALSE)
                    {
                        if(is_file($b3_image1))
                        {
                            unlink($b3_image1);
                        }
                        $b3_image1 = $full_path_img;
                    }
                    else
                    {
                        unlink($full_path_img);
                    }
                }
            }
            elseif ($this->input->post('cb_photo1_block3', true))
            {
                if(is_file($b3_image1))
                {
                    unlink($b3_image1);
                }
                $b3_image1 = 'default';
            }

            // Изображение 2
            $b3_image2 = (!empty($landing['block3']['image2_orig']) and is_file($landing['block3']['image2_orig']))
                ? $landing['block3']['image2_orig']
                : 'not_default';
            if (is_uploaded_file($_FILES['result_file2_block3']['tmp_name']))
            {
                $image = parent::uploadImage('result_file2_block3', $_FILES['result_file2_block3']['type'], $img_path);
                $full_path_img = $img_path . $image;
                if (file_exists($full_path_img))
                {
                    if ($this->security->xss_clean($full_path_img, TRUE) !== FALSE)
                    {
                        if(is_file($b3_image2))
                        {
                            unlink($b3_image2);
                        }
                        $b3_image2 = $full_path_img;
                    }
                    else
                    {
                        unlink($full_path_img);
                    }
                }
            }
            elseif ($this->input->post('cb_photo2_block3', true))
            {
                if(is_file($b3_image2))
                {
                    unlink($b3_image2);
                }
                $b3_image2 = 'default';
            }

            // Информация
            //$b3_title    = mb_substr(strip_tags($this->input->post('i_title_block3', true)), 0, 60);
            $b3_title = mb_substr(strip_tags($this->input->post('i_title_block3'), '<span><br/><b><i><p>'), 0, 255);

            //$b3_subtitle = mb_substr(strip_tags($this->input->post('i_subtitle_block3', true)), 0, 60);
            $b3_subtitle = mb_substr(strip_tags($this->input->post('i_subtitle_block3'), '<span><br/><b><i><p>'), 0, 255);

            // Результаты
            //$b3_r_title    = mb_substr(strip_tags($this->input->post('i_result_title_block3', true)), 0, 60);
            $b3_r_title = mb_substr(strip_tags($this->input->post('i_result_title_block3'), '<span><br/><b><i><p>'), 0, 255);
            //$b3_r_subtitle = mb_substr(strip_tags($this->input->post('i_result_subtitle_block3', true)), 0, 60);
            $b3_r_subtitle = mb_substr(strip_tags($this->input->post('i_result_subtitle_block3'), '<span><br/><b><i><p>'), 0, 255);
            //$b3_r_reviews  = mb_substr(strip_tags($this->input->post('i_result_reviews_block3', true)), 0, 80);
            $b3_r_reviews = mb_substr(strip_tags($this->input->post('i_result_reviews_block3'), '<span><br/><b><i><p>'), 0, 255);

            $up_res = $this->Course_model->setCourseLandingBlock3($course_id, $hide_block, $b3_bg_color, $b3_bg_opacity,
                $b3_bg, $b3_image1, $b3_image2, $b3_title, $b3_subtitle, $b3_r_title, $b3_r_subtitle, $b3_r_reviews, $this->date);

            if ($up_res === true) {
                // Изменения сохранены
                $this->session->set_tempdata('message', 10, 60);
            } else {
                // Изменения не сохранены
                $this->session->set_tempdata('message', 112, 60);
            }

            header('Location: /administration/course/'.$course_id.'/landing/3');
        }
        elseif ($this->input->post('bt_save_block_4', true))
        {
            // БЛОК 4
	        // Скрыть блок со страницы просмотра
	        $hide_block = (!empty($this->input->post('cb_hide_block4', true))) ? 1 : 0;

            // Фон
            $b4_bg = (!empty($landing['block4']['bg_orig']) and is_file($landing['block4']['bg_orig']))
                ? $landing['block4']['bg_orig']
                : 'not_default';

            // Файл изображения
            if (is_uploaded_file($_FILES['bg_file_block4']['tmp_name']))
            {
                $image = parent::uploadImage('bg_file_block4', $_FILES['bg_file_block4']['type'], $img_path);
                $full_path_img = $img_path . $image;
                if (file_exists($full_path_img))
                {
                    if ($this->security->xss_clean($full_path_img, TRUE) !== FALSE)
                    {
                        if(is_file($b4_bg))
                        {
                            unlink($b4_bg);
                        }
                        $b4_bg = $full_path_img;
                    }
                    else
                    {
                        unlink($full_path_img);
                    }
                }
            }
            elseif ($this->input->post('cb_default_bg_block4', true))
            {
                if(is_file($b4_bg))
                {
                    unlink($b4_bg);
                }
                $b4_bg = 'default';
            }

            // Цвет фона блока
            $color = $this->input->post('i_bg_color_block4', true);
            $b4_bg_color = (!empty($color) and preg_match($regexp_color, $color)) ? $color : '';

            // Прозрачность фонового изображения блока
            $b4_bg_opacity = is_numeric($this->input->post('r_opacity_block4', true)) ? $this->input->post('r_opacity_block4', true) : 0;

            // Изображение
            $b4_image = (!empty($landing['block4']['image_orig']) and is_file($landing['block4']['image_orig']))
                ? $landing['block4']['image_orig']
                : 'not_default';
            if (is_uploaded_file($_FILES['result_file_block4']['tmp_name'])) {
                $image = parent::uploadImage('result_file_block4', $_FILES['result_file_block4']['type'], $img_path);
                $full_path_img = $img_path . $image;
                if (file_exists($full_path_img))
                {
                    if ($this->security->xss_clean($full_path_img, TRUE) !== FALSE)
                    {
                        if(is_file($b4_image))
                        {
                            unlink($b4_image);
                        }
                        $b4_image = $full_path_img;
                    }
                    else
                    {
                        unlink($full_path_img);
                    }
                }
            }
            elseif ($this->input->post('cb_photo_block4', true))
            {
                if(is_file($b4_image))
                {
                    unlink($b4_image);
                }
                $b4_image = 'default';
            }

            // Информация
            //$b4_title    = mb_substr(strip_tags($this->input->post('i_title_block4', true)), 0, 60);
            $b4_title = mb_substr(strip_tags($this->input->post('i_title_block4'), '<span><br/><b><i><p>'), 0, 255);
            //$b4_subtitle = mb_substr(strip_tags($this->input->post('i_subtitle_block4', true)), 0, 80);
            $b4_subtitle = mb_substr(strip_tags($this->input->post('i_subtitle_block4'), '<span><br/><b><i><p>'), 0, 255);
            $b4_button   = mb_substr(strip_tags($this->input->post('i_button_block4', true)), 0, 40);

            // Результат
            //$b4_r_title = mb_substr(strip_tags($this->input->post('i_result_title_block4', true)), 0, 60);
            $b4_r_title = mb_substr(strip_tags($this->input->post('i_result_title_block4'), '<span><br/><b><i><p>'), 0, 255);
            //$b4_r_desc  = mb_substr(strip_tags($this->input->post('i_result_desc_block4', true)), 0, 60);
            $b4_r_desc = mb_substr(strip_tags($this->input->post('i_result_desc_block4'), '<span><br/><b><i><p>'), 0, 255);

            $up_res = $this->Course_model->setCourseLandingBlock4($course_id, $hide_block, $b4_bg_color, $b4_bg_opacity,
                $b4_bg, $b4_image, $b4_title, $b4_subtitle, $b4_r_title, $b4_r_desc, $b4_button, $this->date);

            if ($up_res === true) {
                // Изменения сохранены
                $this->session->set_tempdata('message', 10, 60);
            } else {
                // Изменения не сохранены
                $this->session->set_tempdata('message', 112, 60);
            }

            header('Location: /administration/course/'.$course_id.'/landing/4');
        }
        elseif ($this->input->post('bt_save_block_5', true))
        {
            // БЛОК 5
	        // Скрыть блок со страницы просмотра
	        $hide_block = (!empty($this->input->post('cb_hide_block5', true))) ? 1 : 0;

            // Фон
            $b5_bg = (!empty($landing['block5']['bg_orig']) and is_file($landing['block5']['bg_orig']))
                ? $landing['block5']['bg_orig']
                : 'not_default'; // Фон по умолчанию

            // Файл изображения
            if (is_uploaded_file($_FILES['bg_file_block5']['tmp_name']))
            {
                $image = parent::uploadImage('bg_file_block5', $_FILES['bg_file_block5']['type'], $img_path);
                $full_path_img = $img_path . $image;
                if (file_exists($full_path_img))
                {
                    if ($this->security->xss_clean($full_path_img, TRUE) !== FALSE)
                    {
                        if(is_file($b5_bg))
                        {
                            unlink($b5_bg);
                        }
                        $b5_bg = $full_path_img;
                    }
                    else
                    {
                        unlink($full_path_img);
                    }
                }
            }
            elseif ($this->input->post('cb_default_bg_block5', true))
            {
                if(is_file($b5_bg))
                {
                    unlink($b5_bg);
                }
                $b5_bg = 'default';
            }

            // Цвет фона блока
            $color = $this->input->post('i_bg_color_block5', true);
            $b5_bg_color = (!empty($color) and preg_match($regexp_color, $color)) ? $color : '';

            // Прозрачность фонового изображения блока
            $b5_bg_opacity = is_numeric($this->input->post('r_opacity_block5', true)) ? $this->input->post('r_opacity_block5', true) : 0;

            // Боковое фото 1
            $b5_image1 = (!empty($landing['block5']['image1_orig']) and is_file($landing['block5']['image1_orig']))
                ? $landing['block5']['image1_orig']
                : 'not_default';
            if (is_uploaded_file($_FILES['couch_file1_block5']['tmp_name']))
            {
                $image = parent::uploadImage('couch_file1_block5', $_FILES['couch_file1_block5']['type'], $img_path);
                $full_path_img = $img_path . $image;
                if (file_exists($full_path_img))
                {
                    if ($this->security->xss_clean($full_path_img, TRUE) !== FALSE)
                    {
                        if(is_file($b5_image1))
                        {
                            unlink($b5_image1);
                        }
                        $b5_image1 = $full_path_img;
                    }
                    else
                    {
                        unlink($full_path_img);
                    }
                }
            }
            elseif ($this->input->post('cb_photo1_block5', true))
            {
                if(is_file($b5_image1))
                {
                    unlink($b5_image1);
                }
                $b5_image1 = 'default';
            }

            // Боковое фото 2
            $b5_image2 = (!empty($landing['block5']['image2_orig']) and is_file($landing['block5']['image2_orig']))
                ? $landing['block5']['image2_orig']
                : 'not_default';
            if (is_uploaded_file($_FILES['couch_file2_block5']['tmp_name']))
            {
                $image = parent::uploadImage('couch_file2_block5', $_FILES['couch_file2_block5']['type'], $img_path);
                $full_path_img = $img_path . $image;
                if (file_exists($full_path_img))
                {
                    if ($this->security->xss_clean($full_path_img, TRUE) !== FALSE)
                    {
                        if(is_file($b5_image2))
                        {
                            unlink($b5_image2);
                        }
                        $b5_image2 = $full_path_img;
                    }
                    else
                    {
                        unlink($full_path_img);
                    }
                }
            }
            elseif ($this->input->post('cb_photo2_block5', true))
            {
                if($b5_image2)
                {
                    unlink($b5_image2);
                }
                $b5_image2 = 'default';
            }

            // Аватар
            $b5_image3 = (!empty($landing['block5']['image3_orig']) and is_file($landing['block5']['image3_orig']))
                ? $landing['block5']['image3_orig']
                : 'not_default';
            if (is_uploaded_file($_FILES['couch_avatar_block5']['tmp_name']))
            {
                $image = parent::uploadImage('couch_avatar_block5', $_FILES['couch_avatar_block5']['type'], $img_path);
                $full_path_img = $img_path . $image;
                if (file_exists($full_path_img))
                {
                    if ($this->security->xss_clean($full_path_img, TRUE) !== FALSE)
                    {
                        if(is_file($b5_image3))
                        {
                            unlink($b5_image3);
                        }
                        $b5_image3 = $full_path_img;
                    }
                    else
                    {
                        unlink($full_path_img);
                    }
                }
            }
            elseif ($this->input->post('cb_photo3_block5', true))
            {
                if(is_file($b5_image3))
                {
                    unlink($b5_image3);
                }
                $b5_image3 = 'default';
            }

            // Информация
            $b5_title    = mb_substr(strip_tags($this->input->post('i_title_block5', true)), 0, 60);
            $b5_subtitle = mb_substr(strip_tags($this->input->post('i_subtitle_block5', true)), 0, 60);
            $b5_text     = mb_substr(strip_tags($this->input->post('i_text_block5', true)), 0, 255);
            $b5_button   = mb_substr(strip_tags($this->input->post('i_button_block5', true)), 0, 40);

            // Слова тренера о программе
            $b5_r_title    = mb_substr(strip_tags($this->input->post('i_couch_title_block5', true)), 0, 50);
            $b5_r_subtitle = mb_substr(strip_tags($this->input->post('i_couch_subtitle_block5', true)), 0, 50);
            $b5_r_text     = mb_substr(strip_tags($this->input->post('i_couch_text_block5', true)), 0, 120);

            $up_res = $this->Course_model->setCourseLandingBlock5($course_id, $hide_block, $b5_bg_color, $b5_bg_opacity,
                $b5_bg, $b5_image1, $b5_image2, $b5_image3, $b5_title, $b5_subtitle, $b5_text, $b5_r_title, $b5_r_subtitle,
                $b5_r_text, $b5_button, $this->date);

            if ($up_res === true) {
                // Изменения сохранены
                $this->session->set_tempdata('message', 10, 60);
            } else {
                // Изменения не сохранены
                $this->session->set_tempdata('message', 112, 60);
            }

            header('Location: /administration/course/'.$course_id.'/landing/5');
        }
        elseif ($this->input->post('bt_save_block_6', true))
        {
            // БЛОК 6
	        // Скрыть блок со страницы просмотра
	        $hide_block = (!empty($this->input->post('cb_hide_block6', true))) ? 1 : 0;

            // Фон
            $b6_bg = (!empty($landing['block6']['bg_orig']) and is_file($landing['block6']['bg_orig']))
                ? $landing['block6']['bg_orig']
                : 'not_default';
            // Файл изображения
            if (is_uploaded_file($_FILES['bg_file_block6']['tmp_name']))
            {
                $image = parent::uploadImage('bg_file_block6', $_FILES['bg_file_block6']['type'], $img_path);
                $full_path_img = $img_path . $image;
                if (file_exists($full_path_img))
                {
                    if ($this->security->xss_clean($full_path_img, TRUE) !== FALSE)
                    {
                        if(is_file($b6_bg))
                        {
                            unlink($b6_bg);
                        }
                        $b6_bg = $full_path_img;
                    }
                    else
                    {
                        unlink($full_path_img);
                    }
                }
            }
            elseif ($this->input->post('cb_default_bg_block6', true))
            {
                if(is_file($b6_bg))
                {
                    unlink($b6_bg);
                }
                $b6_bg = 'default';
            }

            // Цвет фона блока
            $color = $this->input->post('i_bg_color_block6', true);
            $b6_bg_color = (!empty($color) and preg_match($regexp_color, $color)) ? $color : '';

            // Прозрачность фонового изображения блока
            $b6_bg_opacity = is_numeric($this->input->post('r_opacity_block6', true)) ? $this->input->post('r_opacity_block6', true) : 0;

            // Боковое фото
            $b6_image = (!empty($landing['block6']['image_orig']) and is_file($landing['block6']['image_orig']))
                ? $landing['block6']['image_orig']
                : 'not_default';
            if (is_uploaded_file($_FILES['file_block6']['tmp_name']))
            {
                $image = parent::uploadImage('file_block6', $_FILES['file_block6']['type'], $img_path);
                $full_path_img = $img_path . $image;
                if (file_exists($full_path_img))
                {
                    if ($this->security->xss_clean($full_path_img, TRUE) !== FALSE)
                    {
                        if(is_file($b6_image))
                        {
                            unlink($b6_image);
                        }
                        $b6_image = $full_path_img;
                    }
                    else
                    {
                        unlink($full_path_img);
                    }
                }
            }
            elseif ($this->input->post('cb_photo_block6', true))
            {
                if(is_file($b6_image))
                {
                    unlink($b6_image);
                }
                $b6_image = 'default';
            }

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

            $up_res = $this->Course_model->setCourseLandingBlock6($course_id, $hide_block, $b6_bg_color, $b6_bg_opacity,
                $b6_bg, $b6_image, $b6_title, $b6_desc, $b6_subtitle, $b6_advantages, $b6_button, $this->date);

            if ($up_res === true) {
                // Изменения сохранены
                $this->session->set_tempdata('message', 10, 60);
            } else {
                // Изменения не сохранены
                $this->session->set_tempdata('message', 112, 60);
            }

            header('Location: /administration/course/'.$course_id.'/landing/6');
        }
        elseif ($this->input->post('bt_save_block_7', true))
        {
            // БЛОК 7
	        // Скрыть блок со страницы просмотра
	        $hide_block = (!empty($this->input->post('cb_hide_block7', true))) ? 1 : 0;

            // Фон
            $b7_bg = (!empty($landing['block7']['bg_orig']) and is_file($landing['block7']['bg_orig']))
                ? $landing['block7']['bg_orig']
                : 'not_default';

            // Файл изображения
            if (is_uploaded_file($_FILES['bg_file_block7']['tmp_name']))
            {
                $image = parent::uploadImage('bg_file_block7', $_FILES['bg_file_block7']['type'], $img_path);
                $full_path_img = $img_path . $image;
                if (file_exists($full_path_img))
                {
                    if ($this->security->xss_clean($full_path_img, TRUE) !== FALSE)
                    {
                        if(is_file($b7_bg))
                        {
                            unlink($b7_bg);
                        }
                        $b7_bg = $full_path_img;
                    }
                    else
                    {
                        unlink($full_path_img);
                    }
                }
            }
            elseif ($this->input->post('cb_default_bg_block7', true))
            {
                if(is_file($b7_bg))
                {
                    unlink($b7_bg);
                }
                $b7_bg = 'default';
            }

            // Цвет фона блока
            $color = $this->input->post('i_bg_color_block7', true);
            $b7_bg_color = (!empty($color) and preg_match($regexp_color, $color)) ? $color : '';

            // Прозрачность фонового изображения блока
            $b7_bg_opacity = is_numeric($this->input->post('r_opacity_block7', true)) ? $this->input->post('r_opacity_block7', true) : 0;

            // Информация
            $b7_title  = mb_substr(strip_tags($this->input->post('i_title_block7', true)), 0, 50);
            $b7_button = mb_substr(strip_tags($this->input->post('i_button_block7', true)), 0, 40);

            // Изображение 1
            $b7_image1 = (!empty($landing['block7']['image1_orig']) and is_file($landing['block7']['image1_orig']))
                ? $landing['block7']['image1_orig']
                : 'not_default';
            if (is_uploaded_file($_FILES['file1_block7']['tmp_name']))
            {
                $image = parent::uploadImage('file1_block7', $_FILES['file1_block7']['type'], $img_path);
                $full_path_img = $img_path . $image;
                if (file_exists($full_path_img))
                {
                    if ($this->security->xss_clean($full_path_img, TRUE) !== FALSE)
                    {
                        if(is_file($b7_image1))
                        {
                            unlink($b7_image1);
                        }
                        $b7_image1 = $full_path_img;
                    }
                    else
                    {
                        unlink($full_path_img);
                    }
                }
            }
            elseif ($this->input->post('cb_image1_block7', true))
            {
                if(is_file($b7_image1))
                {
                    unlink($b7_image1);
                }
                $b7_image1 = 'default';
            }

            // Изображение 2
            $b7_image2 = (!empty($landing['block7']['image2_orig']) and is_file($landing['block7']['image2_orig']))
                ? $landing['block7']['image2_orig']
                : 'not_default';
            if (is_uploaded_file($_FILES['file2_block7']['tmp_name']))
            {
                $image = parent::uploadImage('file2_block7', $_FILES['file2_block7']['type'], $img_path);
                $full_path_img = $img_path . $image;
                if (file_exists($full_path_img))
                {
                    if ($this->security->xss_clean($full_path_img, TRUE) !== FALSE)
                    {
                        if(is_file($b7_image2))
                        {
                            unlink($b7_image2);
                        }
                        $b7_image2 = $full_path_img;
                    }
                    else
                    {
                        unlink($full_path_img);
                    }
                }
            }
            elseif ($this->input->post('cb_image2_block7', true))
            {
                if(is_file($b7_image2))
                {
                    unlink($b7_image2);
                }
                $b7_image2 = 'default';
            }

            // Изображение 3
            $b7_image3 = (!empty($landing['block7']['image3_orig']) and is_file($landing['block7']['image3_orig']))
                ? $landing['block7']['image3_orig']
                : 'not_default';
            if (is_uploaded_file($_FILES['file3_block7']['tmp_name']))
            {
                $image = parent::uploadImage('file3_block7', $_FILES['file3_block7']['type'], $img_path);
                $full_path_img = $img_path . $image;
                if (file_exists($full_path_img))
                {
                    if ($this->security->xss_clean($full_path_img, TRUE) !== FALSE)
                    {
                        if(is_file($b7_image3))
                        {
                            unlink($b7_image3);
                        }
                        $b7_image3 = $full_path_img;
                    }
                    else
                    {
                        unlink($full_path_img);
                    }
                }
            }
            elseif ($this->input->post('cb_image3_block7', true))
            {
                if(is_file($b7_image3))
                {
                    unlink($b7_image3);
                }
                $b7_image3 = 'default';
            }

            // Изображение 4
            $b7_image4 = (!empty($landing['block7']['image4_orig']) and is_file($landing['block7']['image4_orig']))
                ? $landing['block7']['image4_orig']
                : 'not_default';
            if (is_uploaded_file($_FILES['file4_block7']['tmp_name']))
            {
                $image = parent::uploadImage('file4_block7', $_FILES['file4_block7']['type'], $img_path);
                $full_path_img = $img_path . $image;
                if (file_exists($full_path_img))
                {
                    if ($this->security->xss_clean($full_path_img, TRUE) !== FALSE)
                    {
                        if(is_file($b7_image4))
                        {
                            unlink($b7_image4);
                        }
                        $b7_image4 = $full_path_img;
                    }
                    else
                    {
                        unlink($full_path_img);
                    }
                }
            }
            elseif ($this->input->post('cb_image4_block7', true))
            {
                if(is_file($b7_image4))
                {
                    unlink($b7_image4);
                }
                $b7_image4 = 'default';
            }

            // Тексты планов
            $b7_texts     = '';
            $input_texts  = $this->input->post('i_text_block7', TRUE);
            foreach ($input_texts as $text)
            {
                $text = mb_substr(strip_tags($text), 0, 160);

                $b7_texts  .= $text . ';';
            }
            unset($text);

            $up_res = $this->Course_model->setCourseLandingBlock7($course_id, $hide_block, $b7_bg_color, $b7_bg_opacity,
                $b7_bg, $b7_title, $b7_image1, $b7_image2, $b7_image3, $b7_image4, $b7_texts, $b7_button, $this->date);

            if ($up_res === true) {
                // Изменения сохранены
                $this->session->set_tempdata('message', 10, 60);
            } else {
                // Изменения не сохранены
                $this->session->set_tempdata('message', 112, 60);
            }

            header('Location: /administration/course/'.$course_id.'/landing/7');
        }
        elseif ($this->input->post('bt_save_block_8', true))
        {
            // БЛОК 8
	        // Скрыть блок со страницы просмотра
	        $hide_block = (!empty($this->input->post('cb_hide_block8', true))) ? 1 : 0;

            // Фон
            $b8_bg = (!empty($landing['block8']['bg_orig']) and is_file($landing['block8']['bg_orig']))
                ? $landing['block8']['bg_orig']
                : 'not_default';
            // Файл изображения
            if (is_uploaded_file($_FILES['bg_file_block8']['tmp_name']))
            {
                $image = parent::uploadImage('bg_file_block8', $_FILES['bg_file_block8']['type'], $img_path);
                $full_path_img = $img_path . $image;
                if(file_exists($full_path_img))
                {
                    if ($this->security->xss_clean($full_path_img, TRUE) !== FALSE)
                    {
                        if(is_file($b8_bg))
                        {
                            unlink($b8_bg);
                        }
                        $b8_bg = $full_path_img;
                    }
                    else
                    {
                        unlink($full_path_img);
                    }
                }
            }
            elseif ($this->input->post('cb_default_bg_block8', true))
            {
                if(is_file($b8_bg))
                {
                    unlink($b8_bg);
                }
                $b8_bg = 'default';
            }

            // Цвет фона блока
            $color = $this->input->post('i_bg_color_block8', true);
            $b8_bg_color = (!empty($color) and preg_match($regexp_color, $color)) ? $color : '';

            // Прозрачность фонового изображения блока
            $b8_bg_opacity = is_numeric($this->input->post('r_opacity_block8', true)) ? $this->input->post('r_opacity_block8', true) : 0;

            // Информация
            $b8_title    = mb_substr(strip_tags($this->input->post('i_title_block8', true)), 0, 60);
            $b8_desc1    = mb_substr(strip_tags($this->input->post('i_desc1_block8', true)), 0, 160);
            $b8_subtitle = mb_substr(strip_tags($this->input->post('i_subtitle_block8', true)), 0, 60);
            $b8_desc2    = mb_substr(strip_tags($this->input->post('i_desc2_block8', true)), 0, 100);
            $b8_button   = mb_substr(strip_tags($this->input->post('i_button_block8', true)), 0, 40);

            // Информация
            $b8_old_price = is_numeric($this->input->post('i_old_price_block8', true)) ? $this->input->post('i_old_price_block8', true) : '';
            $b8_new_price = is_numeric($this->input->post('i_new_price_block8', true)) ? $this->input->post('i_new_price_block8', true) : '';

            $up_res = $this->Course_model->setCourseLandingBlock8($course_id, $hide_block, $b8_bg_color, $b8_bg_opacity,
                $b8_bg, $b8_title, $b8_desc1, $b8_subtitle, $b8_desc2, $b8_old_price, $b8_new_price, $b8_button, $this->date);

            if ($up_res === true) {
                // Изменения сохранены
                $this->session->set_tempdata('message', 10, 60);
            } else {
                // Изменения не сохранены
                $this->session->set_tempdata('message', 112, 60);
            }

            header('Location: /administration/course/'.$course_id.'/landing/8');
        }
        elseif ($this->input->post('bt_delete_landing_img', true))
        {
            $img_types = array('background', 'background_top', 'image', 'slider');

            $bt = $this->input->post('bt_delete_landing_img', true);
            reset($bt);
            $img_block_id = (is_numeric(key($bt))) ? key($bt) : null;
            reset($bt[$img_block_id]);
            $img_type_id = (is_numeric(key($bt[$img_block_id]))) ? key($bt[$img_block_id]) : null;
            $img_type = (array_key_exists($img_type_id, $img_types)) ? $img_types[$img_type_id] : null;
            reset($bt[$img_block_id][$img_type_id]);
            $img_id = (is_numeric(key($bt[$img_block_id][$img_type_id]))) ? '_'.key($bt[$img_block_id][$img_type_id]) : null;
            $img_path = (!empty($this->input->post('img_path_'.$img_block_id.'_'.$img_type_id.$img_id, true)))
                ? '.'.$this->input->post('img_path_'.$img_block_id.'_'.$img_type_id.$img_id, true) : null;

            // Удаление изображения и сохранение данных в БД
            if(is_file($img_path) and !empty($img_type))
            {
                $res_del = unlink($img_path);

                if($res_del === true)
                {
                    $del_img = $this->Course_model->deleteLandingImage($course_id, $img_block_id, $img_type, $img_id, $img_path);
                }
            }

            if (!empty($del_img) and $del_img === true)
            {
                // Изменения сохранены
                $this->session->set_tempdata('message', 10, 60);
            }

            header('Location: /administration/course/'.$course_id.'/landing/'.$img_block_id);
        }

        $result = array_merge($course_landing, $landing_list, $course);

        // Объединенные данные страница
        $this->page_data['title']         = 'АП - Редактирование данных Landing page курса';
        $this->page_data['page_menu']     = 'a_courses_w';
        $this->page_data['page_submenu']  = 'landing';
        $this->page_data['course_id']     = $course_id;
        $this->page_data['lend_block_id'] = $block_id;

        $this->load->view('header/header_admin', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('course/settings/course', $result);
        $this->load->view('footer/footer');
    }

    /**
     * Вывод статистики курса
     *
     * @param $course_id
     * @param $course_type
     */
    protected function courseStatistics($course_id, $course_type = 'workout')
    {
        $statis = $this->Course_model->getStatistics($course_id);
        $course = $this->Course_model->getShortCourse($course_id);

        $result = array_merge($statis, $course);

        $page_menu = ($course_type == 'workout') ? 'a_courses_w' : 'a_courses_n';

        // Объединенные данные страница
        $this->page_data['title']        = 'АП - Статистика курса';
        $this->page_data['page_menu']    = $page_menu;
        $this->page_data['page_submenu'] = 'statistics';
        $this->page_data['course_id']    = $course_id;

        $this->load->view('header/header_admin', $this->page_data);
        $this->load->view('header/admin');
        if($course_type == 'workout')
        {
            $this->load->view('course/settings/course', $result);
        }
        elseif($course_type == 'nutrition')
        {
            $this->load->view('course/nutritions/settings/course', $result);
        }
        $this->load->view('footer/footer');
    }

    /**
     * Страница предварительного просмотра курса.
     *
     * @param $course_id
     * @return void
     */
    public function coursePreview($course_id)
    {
        // Выборка данных курса
        $course         = $this->Course_model->getCourse($course_id);
        $course_couches = $this->Course_model->getCourseCouchesId($course_id);
        $user_courses   = !empty($this->user_id) ? $this->Course_model->getUserCoursesId($this->user_id, $this->date) : array();
        $landing        = array();

        if (!empty($course['course']) and !empty($course['course']['landing']['id']))
        {
            $landing = $this->Course_model->getLandingPage($course_id);
        }

        // Объединенные данные страница
        $this->page_data['title']       = (!empty($course['course']['name'])) ? $course['course']['name'] : 'Курс №' . $course_id;
        $this->page_data['description'] = $course['course']['meta_description'];
        $this->page_data['keywords']    = $course['course']['meta_keywords'];
        $this->page_data['page_menu']   = 'courses';
        $this->page_data['course_id']   = $course_id;
        $this->page_data['purchase_up'] = ($this->input->get('ref', true)) ? true : false;

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


    /* БЛОК ФУНКЦИЙ ОТЗЫВОВ КУРСА */

    /**
     * Вывод отзывов курса
     *
     * @param $course_id
     * @param $course_type
     */
    protected function courseReviews($course_id, $course_type = 'workout')
    {
        $reviews = $this->Course_model->getCourseReviews($course_id);
        $course  = $this->Course_model->getShortCourse($course_id);

        $result = array_merge($reviews, $course);

        $page_menu = ($course_type == 'workout') ? 'a_courses_w' : 'a_courses_n';

        // Объединенные данные страница
        $this->page_data['title']        = 'АП - Отзывы курса';
        $this->page_data['page_menu']    = $page_menu;
        $this->page_data['page_submenu'] = 'reviews';
        $this->page_data['course_id']    = $course_id;

        $this->load->view('header/header_admin', $this->page_data);
        $this->load->view('header/admin');
        if($course_type == 'workout')
        {
            $this->load->view('course/settings/course', $result);
        }
        elseif($course_type == 'nutrition')
        {
            $this->load->view('course/nutritions/settings/course', $result);
        }
        $this->load->view('footer/footer');
    }

    /**
     * Вывод формы редактирования отзыва курса
     *
     * @param $course_id
     * @param $review_id
     * @param $course_type
     */
    protected function courseReview($course_id, $review_id, $course_type = 'workout')
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

        $page_menu = ($course_type == 'workout') ? 'a_courses_w' : 'a_courses_n';

        // Объединенные данные страница
        $this->page_data['title']        = 'АП - Отзыв курса';
        $this->page_data['page_menu']    = $page_menu;
        $this->page_data['page_submenu'] = 'reviews';
        $this->page_data['course_id']    = $course_id;

        $this->load->view('header/header_admin', $this->page_data);
        $this->load->view('header/admin');
        if($course_type == 'workout')
        {
            $this->load->view('course/settings/course', $result);
        }
        elseif($course_type == 'nutrition')
        {
            $this->load->view('course/nutritions/settings/course', $result);
        }
        $this->load->view('footer/footer');
    }


    /* БЛОК ФУНКЦИЙ ВИДЕО КУРСА */

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
        $this->page_data['page_menu']    = 'a_courses_w';
        $this->page_data['page_submenu'] = 'video';
        $this->page_data['video_menu']   = 'promo';
        $this->page_data['course_id']    = $course_id;

        $this->load->view('header/header_admin', $this->page_data);
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
        $this->page_data['page_menu']    = 'a_courses_w';
        $this->page_data['page_submenu'] = 'video';
        $this->page_data['video_menu']   = 'workouts';
        $this->page_data['course_id']    = $course_id;

        $this->load->view('header/header_admin', $this->page_data);
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
        $this->page_data['page_menu']    = 'a_courses_w';
        $this->page_data['page_submenu'] = 'video';
        $this->page_data['video_menu']   = 'instructions';
        $this->page_data['course_id']    = $course_id;

        $this->load->view('header/header_admin', $this->page_data);
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
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3 or $this->session->user['blocked'] == 1) {
            parent::pageNotFound($this->page_url);
        }

        $course_id = (is_numeric($course_id)) ? $course_id : '';
        $result    = $this->Course_model->getShortCourse($course_id);

        if ($this->input->post('bt_save_video', true))
        {
            $type        = (is_numeric($this->input->post('s_type', true))) ? $this->input->post('s_type', true) : 0;
            $name        = !empty($this->input->post('file_name', true))
                ? mb_substr(strip_tags($this->input->post('file_name', true)), 0, 255) : '';
            $remove_url  = !empty($this->input->post('remove_url', true))
                ? mb_substr(strip_tags($this->input->post('remove_url', true)), 0, 255) : '';
            $poster_path = is_file('./video/' . $this->input->post('poster_path', true))
                ? './video/' . $this->input->post('poster_path', true) : '';
            $video_path  = is_file('./video/' . $this->input->post('video_path', true))
                ? './video/' . $this->input->post('video_path', true) : '';
            $workout_num = (is_numeric($this->input->post('hi_ctw', true))) ? $this->input->post('hi_ctw', true) : null;

            if (!empty($video_path) or !empty($remove_url))
            {
                $result = $this->Course_model->setNewVideo($type, $course_id, $name, $video_path, $poster_path, $remove_url, $this->user_id, $this->date);

                //echo 'T '.$type.' N '.$name.' RU '.$remove_url.' PP '.$poster_path.' VP '.$video_path.'<br/>';

                if (is_numeric($result) and $result !== false)
                {
                    $video_id = $result;

                    // Прикрепление видео к тренировке
                    if(!empty($workout_num) and !empty($course_id))
                    {
                        $this->Course_model->attachVideoToWorkout($course_id, $workout_num, $video_id, $this->date);
                    }

                    // Изменения сохранены
                    $this->session->set_tempdata('message', 10, 60);

                    header('Location: /administration/course/' . $course_id . '/video/' . $video_id);
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
        $this->page_data['page_menu']    = 'a_courses_w';
        $this->page_data['page_submenu'] = 'video';
        $this->page_data['course_id']    = $course_id;

        $this->load->view('header/header_admin', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('course/settings/course_video_new', $result);
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
        if (empty($this->user_id) or $this->session->user['type'] != 3 or $this->session->user['blocked'] == 1) {
            parent::pageNotFound($this->page_url);
        }

        $course_id = (is_numeric($course_id)) ? $course_id : '';
        $video_id  = (is_numeric($video_id)) ? $video_id : '';

        $video    = $this->Course_model->getCourseVideoData($course_id, $video_id);
        $courses  = $this->Course_model->getWorkoutCourses();
        $course   = $this->Course_model->getShortCourse($course_id);
        $schedule = $this->Course_model->getCourseSchedules($course_id);
        $result   = array_merge($video, $courses, $course, $schedule);

        if ($this->input->post('bt_save_video', true) and !empty($course_id) and !empty($video_id))
        {
            // Введенные данные
            $type          = is_numeric($this->input->post('s_type', true)) ? $this->input->post('s_type', true) : 0;
            $new_course_id = is_numeric($this->input->post('s_courses', true)) ? $this->input->post('s_courses', true) : null;
            $poster_path   = (!empty($this->input->post('poster_path', true)) and is_file('./video/' . $this->input->post('poster_path', true)))
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
            $poster_path = (!empty($poster_path) and $poster_path != $result['video']['poster'])
                ? $poster_path
                : '.' . $result['video']['poster'];
            $video_path  = (!empty($video_path) and $video_path != $result['video']['video'])
                ? $video_path
                : '.' . $result['video']['video'];
            //$video_id = $result;
            // Выборка информации о тренировках нового выбранного курса
            $schedule  = (!empty($new_course_id) and $new_course_id != $course_id) ? $this->Course_model->getCourseSchedules($new_course_id) : $schedule;

            // Id тренировок курса
            $workouts_num = (!empty($this->input->post('cb_practice_days', true))) ? $this->input->post('cb_practice_days', true) : null;
            $selected_trainings = array('update' => array(), 'delete' => array());
            $i = 0;
            $search_w = array_flip(array_keys($schedule['workouts_id'], $video_id));
            // Обновление id видео дней тренировок
            if(!empty($workouts_num))
            {
                foreach($workouts_num as $w_id => $w_vd_id)
                {
                    if(is_numeric($w_id) and !array_key_exists($w_id, $search_w))
                    {
                        $selected_trainings['update'][$i] = $w_id;
                        $i++;
                    }
                }
                unset($w_vd_id);

                // Удаление id видео из дней тренировок курса
                $selected_trainings['delete'] = array_diff_key($search_w, $workouts_num);
            }

            // Обновление видео тренировке
            if((!empty($selected_trainings['update']) or !empty($selected_trainings['delete'])) and !empty($course_id))
            {
                $this->Course_model->attachVideoToWorkouts($course_id, $selected_trainings, $video_id, $this->date);
            }

            if(!empty($video_id) and !empty($course_id) and ((!empty($poster_path) and $poster_path != $result['video']['poster'])
                    or (!empty($video_path) and $video_path != $result['video']['video']) or $name != $result['video']['name']
                    or $remove_url != $result['video']['remove_url'] or $type != $result['video']['type'] or $new_course_id != $course_id))
            {
                $course_id = (!empty($new_course_id) and $new_course_id != $course_id) ? $new_course_id : $course_id;

                $update = $this->Course_model->setVideoSettings($video_id, $type, $course_id, $video_path, $name, $poster_path, $remove_url, $this->user_id, $this->date);

                if ($update === true)
                {
                    if ($video_path != $result['video']['video'] and is_file($result['video']['video']) and is_file($video_path))
                    {
                        unlink($result['video']['video']);
                    }

                    if ($poster_path != $result['video']['poster'] and is_file($result['video']['poster']) and is_file($poster_path))
                    {
                        unlink($result['video']['poster']);
                    }

                    // Изменения сохранены
                    $this->session->set_tempdata('message', 10, 60);
                }
                else
                {
                    // Изменения не сохранены
                    $this->session->set_tempdata('message', 41, 60);
                }
            }

            header('Location: /administration/course/' . $course_id . '/video/' . $video_id);
        }
        elseif ($this->input->post('bt_block_video', true) and !empty($video_id))
        {
            $blocked = $this->Course_model->blockVideo($video_id, $this->date);

            if ($blocked === true)
            {
                // Сохранено
                $this->session->set_tempdata('message', 42, 60);
            }
            else
            {
                // Не сохранено
                $this->session->set_tempdata('message', 43, 60);
            }
            header('Location: /administration/course/' . $course_id . '/video/' . $video_id);
        }
        elseif ($this->input->post('bt_unblock_video', true) and !empty($video_id))
        {
            $unblocked = $this->Course_model->unblockVideo($video_id, $this->date);

            if ($unblocked === true)
            {
                // Сохранено
                $this->session->set_tempdata('message', 44, 60);
            }
            else
            {
                // Не сохранено
                $this->session->set_tempdata('message', 45, 60);
            }
            header('Location: /administration/course/' . $course_id . '/video/' . $video_id);
        }
        elseif ($this->input->post('bt_delete_video', true) and !empty($video_id))
        {
            $deleted = $this->Course_model->deleteVideo($video_id);

            if ($deleted === true)
            {
                // Удалено
                $this->session->set_tempdata('message', 104, 60);

                header('Location: /administration/course/' . $course_id . '/video/');
            }
            else
            {
                // Не удалено
                $this->session->set_tempdata('message', 105, 60);

                header('Location: /administration/course/' . $course_id . '/video/' . $video_id);
            }
        }

        $video_types = array('promo' => 1, 'workouts' => 2, 'instructions' => 3);
        $type_key    = (!empty($video['video']['type'])) ? array_search($video['video']['type'], $video_types) : '';

        // Объединенные данные страница
        $this->page_data['title']        = 'АП - Редактирование данных видео курса';
        $this->page_data['page_menu']    = 'a_courses_w';
        $this->page_data['page_submenu'] = 'video';
        $this->page_data['video_menu']   = (!empty($video['video']['type']) and in_array($video['video']['type'], $video_types)) ? $type_key : '';
        $this->page_data['video_page']   = 'video_settings';
        $this->page_data['course_id']    = $course_id;

        $this->load->view('header/header_admin', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('course/settings/course', $result);
        $this->load->view('footer/footer');
    }

    /**
     * AJAX. Активация видео
     */
    public function activateCourseVideo()
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3 or $this->session->user['blocked'] == 1) {
            parent::pageNotFound($this->page_url);
        }

        $video_id   = is_numeric($this->input->post('vd_id', true)) ? $this->input->post('vd_id', true) : null;
        $video_type = strip_tags($this->input->post('vd_t', true));
        $course_id  = is_numeric($this->input->post('crs_id', true)) ? $this->input->post('crs_id', true) : null;
        $display    = is_numeric($this->input->post('display', true)) ? $this->input->post('display', true) : null;

        if (!empty($video_id) and !empty($course_id) and !empty($video_type) and !empty($display))
        {
            // Изменение активного видео
            $res_up = $this->Course_model->activateCourseVideos($course_id, $video_id, $video_type, $this->date);

            if($res_up === false)
            {
                $display_result['error'] = 'Select error';
            }
            else
            {
                $display_result = true;
            }
        }
        else
        {
            $display_result['error'] = 'vd_id, vd_t, crs_id and|or display are empty';
        }

        echo json_encode($display_result, JSON_NUMERIC_CHECK);
    }


    /* БЛОК ФУНКЦИЙ КУРСОВ ПИТАНИЯ */

    /**
     * Список курсов питания
     */
    protected function nutritionCourses()
    {
        // Получение списка добавленных курсов
        $result = $this->Course_model->getCourses('nutrition', 0);

        // Объединенные данные страница
        $this->page_data['title']        = 'АП - Курсы питания';
        $this->page_data['page_menu']    = 'a_courses_n';
        $this->page_data['page_submenu'] = 'a_courses_n';

        $this->load->view('header/header_admin', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('course/nutritions/courses', $result);
        $this->load->view('footer/footer');
    }

    /**
     * Архив курсов питания
     */
    protected function nutritionCoursesArchive()
    {
        // Получение списка курсов
        $result = $this->Course_model->getCourses('nutrition', 1);

        // Объединенные данные страница
        $this->page_data['title']        = 'АП - Архив курсов питания';
        $this->page_data['page_menu']    = 'a_courses_n';
        $this->page_data['page_submenu'] = 'courses_archive';

        $this->load->view('header/header_admin', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('course/nutritions/courses', $result);
        $this->load->view('footer/footer');
    }

    /**
     * Форма добавления и обработка данных нового курса питания
     */
    public function newNutrition()
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3 or $this->session->user['blocked'] == 1) {
            parent::pageNotFound($this->page_url);
        }

        $ingestions = $this->Course_model->getIngestions();

        $result = array_merge($ingestions);

        // Валидация и сохранение данных
        if($this->input->post('bt_save_new_course', true))
        {
            $schedule['insert'] = array();
            $schedule_days      = array();

            // Наименование
            $name = mb_substr(strip_tags($this->input->post('name', true)), 0, 255);

            // Описание
            $description = mb_substr(strip_tags($this->input->post('description', true)), 0, 1000);

            // Стоимость курса
            $price = is_numeric($this->input->post('price', true)) ? $this->input->post('price', true) : '';
            $fc_price = is_numeric($this->input->post('fc_price', true)) ? $this->input->post('fc_price', true) : '';

            // Рекуррентная стоимость
            $recur_price      = $price;
            $recur_months     = is_numeric($this->input->post('s_recurrent_months', true)) ? $this->input->post('s_recurrent_months', true) : '';
            $recur_first      = is_numeric($this->input->post('i_recurrent_first', true)) ? $this->input->post('i_recurrent_first', true) : '';
            $recur_subsequent = '';
            if (!empty($recur_price) and !empty($recur_months) and !empty($recur_first))
            {
                $num_month = $recur_months - 1;
                $month_price = ($recur_price - $recur_first) / $num_month;
                $recur_subsequent = number_format($month_price, 2, '.', '');
            }

            // Длительность курса
            $count_weeks = (is_numeric($this->input->post('count_weeks', true)) and 52 >= $this->input->post('count_weeks', true))
                ? $this->input->post('count_weeks', true) : 1;

            // Приемы пищи
            $cb_ingestions     = $this->input->post('cb_ingestions', true);
            $s_ings_time_from  = $this->input->post('s_ing_time_from', true);
            $s_ings_time_to    = $this->input->post('s_ing_time_to', true);

            if(!empty($cb_ingestions) and is_array($cb_ingestions))
            {
                $tmp_ingestions = array();
                $tmp_time_from  = array();
                $tmp_time_to    = array();

                foreach($cb_ingestions as $key => $ingestion)
                {
                    if(is_numeric($ingestion) and is_numeric($key))
                    {
                        // Диапазон времени
                        // Проверка данных. Если не корректные, присвоить данные по умолчанию
                        $tmp_from  = DateTime::createFromFormat('H:i', $s_ings_time_from[$key]);
                        $time_from = ($tmp_from !== false) ? $s_ings_time_from[$key] : $ingestions['ingestions_from'][$key];
                        $tmp_to    = DateTime::createFromFormat('H:i', $s_ings_time_to[$key]);
                        $time_to   = ($tmp_to !== false) ? $s_ings_time_to[$key] : $ingestions['ingestions_to'][$key];

                        $tmp_ingestions[$key] = $ingestion;
                        $tmp_time_from[$key]  = $time_from;
                        $tmp_time_to[$key]    = $time_to;
                    }
                }
                unset($ingestion);

                $cb_ingestions     = $tmp_ingestions;
                $s_ings_time_from  = $tmp_time_from;
                $s_ings_time_to    = $tmp_time_to;
            }

            // Расписание курса
            $schedule_day   = 1;
            $count_days     = $count_weeks * 7;
            $id_meal        = $this->input->post('id_meal', true);

            // Цикл дней курса
            for($sd = 0; $sd < $count_days; $sd++)
            {
                // Цикл приемов пищи
                foreach($cb_ingestions as $ingestion)
                {
                    // Цикл блюд
                    $i = 0;
                    if(!empty($id_meal[$schedule_day][$ingestion]))
                    {
                        foreach($id_meal[$schedule_day][$ingestion] as $meal)
                        {
                            $schedule_days[$schedule_day][$ingestion][$i] = $meal;

                            $i++;
                        }
                        unset($i);
                        unset($meal);
                    }
                }
                unset($ingestion);

                $schedule_day++;
            }
            unset($sd);
            $schedule['insert'] = $schedule_days;

            if (!empty($name) and !empty($description) and !empty($price))
            {
                $course_category = 'nutrition';

                $course_id = $this->Course_model->setNewCourse($course_category, $name, $description, $price, $fc_price,
                    0, $count_weeks, 7, 0, $this->user_id, $this->date);
            }

            if (!empty($course_id) and is_numeric($course_id))
            {
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

                // Добавление, изменени и/или удаление расписания курса
                $result_schedule  = $this->Course_model->setNutritionSchedule($course_id, $schedule, $this->user_id, $this->date);
                // Сохранение даынных о рекуррентном платеже
                $result_recurrent = $this->Course_model->setCourseRecurrentPrice($course_id, $recur_price, $recur_months, $recur_first, $recur_subsequent, $this->user_id, $this->date);
                $result_crs_inges = $this->Course_model->setNutritionIngestions($course_id, $cb_ingestions, $s_ings_time_from, $s_ings_time_to, $this->user_id, $this->date);

                // Курс сохранен
                $this->session->set_tempdata('message', 10, 60);

                header('Location: /administration/nutrition/'.$course_id);
            }
            else {
                // Курс не сохранен
                $this->session->set_tempdata('message', 30, 60);
                header('Location: /administration/nutrition/new');
            }
        }

        // Объединенные данные страница
        $this->page_data['title']        = 'АП - Добавление нового курса питания';
        $this->page_data['page_menu']    = 'a_courses_n';
        $this->page_data['page_submenu'] = 'a_courses_n';

        $this->load->view('header/header_admin', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('course/nutritions/settings/new_course', $result);
        $this->load->view('footer/footer');
    }

    /**
     * Вывод данных и сохраненение изменений курса питания
     *
     * @param $course_id
     * @param string $page_type (settings, landing, statistics, reviews, review)
     * @param int|null $page_id
     * @return void
     */
    public function nutrition($course_id, $page_type = 'settings', $page_id = null)
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3 or $this->session->user['blocked'] == 1) {
            parent::pageNotFound($this->page_url);
        }

        if ($page_type == 'settings')
        {
            self::nutritionSettings($course_id);
        }
        elseif ($page_type == 'landing')
        {
            $block_id = is_numeric($page_id) ? $page_id : 1;
            self::nutritionLanding($course_id, $block_id);
        }
        elseif ($page_type == 'statistics')
        {
            self::courseStatistics($course_id, 'nutrition');
        }
        elseif ($page_type == 'reviews')
        {
            self::courseReviews($course_id, 'nutrition');
        }
        elseif ($page_type == 'review' and is_numeric($page_id))
        {
            self::courseReview($course_id, $page_id, 'nutrition');
        }
        elseif($page_type == 'promocodes')
        {
            self::coursePromocodes($course_id, 'nutrition');
        }
        elseif($page_type == 'promocode_new')
        {
            self::newCoursePromocode($course_id, 'nutrition');
        }
        elseif($page_type == 'promocode' and is_numeric($page_id))
        {
            self::coursePromocode($course_id, $page_id, 'nutrition');
        }
    }

    /**
     * Редактирование и сохранение настроек курса
     *
     * @param $course_id
     */
    protected function nutritionSettings($course_id)
    {
        $ingestions = $this->Course_model->getIngestions();
        $course     = $this->Course_model->getCourse($course_id);

        $course_ingestions = $this->Course_model->getNutritionIngestions($course_id);
        $course_ml_types   = $this->Course_model->getNutritionMealsTypes($course_id);
        $course_schedule   = $this->Course_model->getNutritionSchedule($course_id);

        // Валидация и сохранение данных
        if ($this->input->post('bt_save_course', true))
        {
            $schedule      = array('insert' => array(), 'delete' => array());
            $delete        = array();
            $schedule_days = array();

            $course = $course['course'];
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
            $price    = is_numeric($this->input->post('price', true)) ? $this->input->post('price', true) : '';
            $fc_price = is_numeric($this->input->post('fc_price', true)) ? $this->input->post('fc_price', true) : '';

            // Рекуррентная стоимость
            $recur_price      = $price;
            $recur_months     = is_numeric($this->input->post('s_recurrent_months', true)) ? $this->input->post('s_recurrent_months', true) : '';
            $recur_first      = is_numeric($this->input->post('i_recurrent_first', true)) ? $this->input->post('i_recurrent_first', true) : '';
            $recur_subsequent = '';
            if (!empty($recur_price) and !empty($recur_months) and !empty($recur_first))
            {
                $num_month = $recur_months - 1;
                $month_price = ($recur_price - $recur_first) / $num_month;
                $recur_subsequent = number_format($month_price, 2, '.', '');
            }

            // Длительность курса
            $count_weeks = (is_numeric($this->input->post('count_weeks', true)) and 52 >= $this->input->post('count_weeks', true))
                ? $this->input->post('count_weeks', true) : '';

            // Приемы пищи
            $cb_ingestions     = $this->input->post('cb_ingestions', true);
            $s_ings_time_from  = $this->input->post('s_ing_time_from', true);
            $s_ings_time_to    = $this->input->post('s_ing_time_to', true);
            $update_ingestions = array('insert' => array(), 'update' => array(), 'delete' => array());

            if(!empty($cb_ingestions) and is_array($cb_ingestions))
            {
                $tmp_ingestions = array();
                $tmp_time_from  = array();
                $tmp_time_to    = array();

                foreach($cb_ingestions as $key => $ingestion)
                {
                    if(is_numeric($ingestion) and is_numeric($key))
                    {
                        // Диапазон времени
                        // Проверка данных. Если не корректные, присвоить данные по умолчанию
                        $tmp_from  = DateTime::createFromFormat('H:i', $s_ings_time_from[$key]);
                        $time_from = ($tmp_from !== false) ? $s_ings_time_from[$key] : $ingestions['ingestions_from'][$key];
                        $tmp_to    = DateTime::createFromFormat('H:i', $s_ings_time_to[$key]);
                        $time_to   = ($tmp_to !== false) ? $s_ings_time_to[$key] : $ingestions['ingestions_to'][$key];

                        $tmp_ingestions[$key] = $ingestion;
                        $tmp_time_from[$key]  = $time_from;
                        $tmp_time_to[$key]    = $time_to;

                        if($time_from != $course_ingestions['course_ingestion'][$key]['time_from']
                            or $time_to != $course_ingestions['course_ingestion'][$key]['time_to'])
                        {
                            $update_ingestions['update'][$key] = $ingestion;
                        }
                    }

                    if(!in_array($ingestion, $course_ingestions['course_ingestions_id']))
                    {
                        $update_ingestions['insert'][$key] = $ingestion;
                    }
                }
                unset($ingestion);

                $cb_ingestions     = $tmp_ingestions;
                $s_ings_time_from  = $tmp_time_from;
                $s_ings_time_to    = $tmp_time_to;

                if(is_array($cb_ingestions))
                {
                    $diff = array_diff($course_ingestions['course_ingestions_id'], $cb_ingestions);

                    if(!empty($diff))
                    {
                        $update_ingestions['delete'] = array_merge($update_ingestions['delete'], $diff);
                    }
                }
            }

            // Расписание курса
            $schedule_day   = 1;
            $count_days     = $count_weeks * 7;
            $id_meals       = $this->input->post('id_meal', true);
            $i = 0;

            // Цикл дней курса
            for($sd = 1; $sd <= $count_days; $sd++)
            {
                // Цикл приемов пищи
                foreach($cb_ingestions as $ingestion)
                {
                    if(!empty($id_meals[$schedule_day][$ingestion]))
                    {
                        // Цикл блюд
                        foreach($id_meals[$schedule_day][$ingestion] as $meal)
                        {
                            $schedule_days[$schedule_day][$ingestion][$i] = $meal;

                            if(!empty($course_schedule['course_schedule']) and !in_array($meal, $course_schedule['schedule_days'][$schedule_day][$ingestion]))
                            {
                                $schedule['insert'][$schedule_day][$ingestion][$i] = $meal;
                            }

                            $i++;
                        }
                        unset($meal);
                    }
                }
                unset($ingestion);

                $schedule_day++;
            }
            // Удаление данных
            foreach($course_schedule['schedule_days'] as $day => $days)
            {
                foreach($days as $ing_id => $ingestion)
                {
                    if(!empty($schedule_days[$day]) and !empty($schedule_days[$day][$ing_id]))
                    {
                        $diff = (is_array($ingestion)) ? array_diff($ingestion, $schedule_days[$day][$ing_id]) : null;

                        if(!empty($diff))
                        {
                            $delete[$day][$ing_id] = array();
                            $delete[$day][$ing_id] = array_merge($delete[$day][$ing_id], $diff);
                        }
                    }
                    elseif(empty($schedule_days[$day][$ing_id]))
                    {
                        $delete[$day][$ing_id] = array();
                        $delete[$day][$ing_id] = array_merge($delete[$day][$ing_id], $course_schedule['schedule_days'][$day][$ing_id]);
                    }
                }
            }
            $schedule['delete'] = $delete;

            /* СОХРАНЕНИЕ ИЗМНЕНИЙ */
            $result_settings  = null;
            $result_recurrent = null;
            $result_schedule  = null;
            $result_couches   = null;

            // Сохранение основных данных курса
            if ($name != $course['name'] or $description != $course['description'] or $price != $course['price']
                or $count_weeks != $course['count_weeks'] or $course_image != ('.' . $course['image'])) {

                $result_settings = $this->Course_model->setCourseSettings($course_id, $course_image, $name, $description, $price, $fc_price,
                    0, $count_weeks, $count_days, 0, $this->date);
            }

            // Сохранение данных рекуррентной цены
            if ($recur_months != $course['recur_months'] or $recur_first != $course['recur_first']
                or $recur_subsequent != $course['recur_subsequent'])
            {
                $result_recurrent = $this->Course_model->setCourseRecurrentPrice($course_id, $recur_price, $recur_months, $recur_first, $recur_subsequent, $this->user_id, $this->date);
            }

            // Добавление и/или удаление расписание курса
            if (!empty($schedule['insert']) or !empty($schedule['delete']))
            {
                $result_schedule = $this->Course_model->setNutritionSchedule($course_id, $schedule, $this->user_id, $this->date);
            }

            // Изменение кол-ва приемов пищи
            $result_ingestions = $this->Course_model->updateNutritionIngestions($course_id, $update_ingestions, $cb_ingestions, $s_ings_time_from, $s_ings_time_to, $this->user_id, $this->date);

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

            header('Location: /administration/nutrition/'.$course_id);
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
            header('Location: /administration/nutrition/' . $course_id);
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
            header('Location: /administration/nutrition/' . $course_id);
        }
        elseif ($this->input->post('bt_delete_course', true)) {
            if ($course['course']['bought'] === false) {
                // Удалить курс
                $del_course = $this->Course_model->deleteCourse($course_id);

                if ($del_course === true) {
                    // Курс удален
                    $this->session->set_tempdata('message', 108, 60);
                    header('Location: /administration/nutritions/');
                }
                else {
                    // Не удалось удалить курс
                    $this->session->set_tempdata('message', 107, 60);
                    header('Location: /administration/nutrition/' . $course_id);
                }
            }
            else {
                // Не возможно удалить курс (куплен пользователем)
                $this->session->set_tempdata('message', 106, 60);
                header('Location: /administration/nutrition/' . $course_id);
            }
        }
        elseif ($this->input->post('bt_archive_course', true))
        {
            $res_data = $this->Course_model->archiveCourse($course_id, 1, $this->user_id, $this->date);

            if ($res_data === true)
            {
                // Курс добавлен в архив
                $this->session->set_tempdata('message', 181, 60);
            }
            else
            {
                // Не удалось добавить курс в архив
                $this->session->set_tempdata('message', 182, 60);
            }

            header('Location: /administration/nutrition/' . $course_id);
        }
        elseif ($this->input->post('bt_from_archive_course', true))
        {
            $res_data = $this->Course_model->archiveCourse($course_id, 0, $this->user_id, $this->date);

            if ($res_data === true)
            {
                // Курс добавлен в архив
                $this->session->set_tempdata('message', 183, 60);
            }
            else
            {
                // Не удалось добавить курс в архив
                $this->session->set_tempdata('message', 184, 60);
            }

            header('Location: /administration/nutrition/' . $course_id);
        }

        $result = array_merge($ingestions, $course, $course_ingestions, $course_ml_types, $course_schedule);

        // Объединенные данные страница
        $this->page_data['title'] = 'АП - Редактирование данных курса';
        $this->page_data['page_menu'] = 'a_courses_n';
        $this->page_data['page_submenu'] = 'settings';
        $this->page_data['course_id'] = $course_id;

        $this->load->view('header/header_admin', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('course/nutritions/settings/course', $result);
        $this->load->view('footer/footer');
    }

    /**
     * Редактирование и сохранение Landing page курса
     *
     * @param $course_id
     * @param $block_id
     */
    protected function nutritionLanding($course_id, $block_id = 1)
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

        if ($this->input->post('bt_save_block_1', true))
        {
            // Скрыть блок со страницы просмотра
            $hide_block = (!empty($this->input->post('cb_hide_block1', true))) ? 1 : 0;

            // Стиль
            $landing_style = in_array($this->input->post('s_land_type', true), $landing_list['landings_id'])
                ? $this->input->post('s_land_type', true) : 1;

            // Цвет фона блока
            $color = $this->input->post('i_bg_color_block1', true);
            $b1_bg_color = (!empty($color) and preg_match($regexp_color, $color)) ? $color : '';

            // Прозрачность фонового изображения блока
            $b1_bg_opacity = is_numeric($this->input->post('r_opacity_block1', true)) ? $this->input->post('r_opacity_block1', true) : 0;

            // Слайдер (max 7 images)
            $slider_images = (!empty($landing['full_slider_images'])) ? explode(';', $landing['full_slider_images']) : array();
            $input_files   = $_FILES;
            if(is_uploaded_file($input_files['slider_files']['tmp_name'][0]))
            {
                $count_images           = count($slider_images);
                $available_count_images = ((7 - $count_images) < 0) ? 0 : (7 - $count_images);

                if($available_count_images > 0)
                {
                    $i   = 0;
                    $imi = $count_images + 1;
                    foreach ($input_files['slider_files']['name'] as $name)
                    {
                        $slider_image = '';

                        $_FILES['slider_files'] = array(
                            'name' => $input_files['slider_files']['name'][$i],
                            'type' => $input_files['slider_files']['type'][$i],
                            'tmp_name' => $input_files['slider_files']['tmp_name'][$i],
                            'error' => $input_files['slider_files']['error'][$i],
                            'size' => $input_files['slider_files']['size'][$i]);

                        if (!empty($_FILES['slider_files']) and is_uploaded_file($_FILES['slider_files']['tmp_name']))
                        {
                            $image = parent::uploadImage('slider_files', $_FILES['slider_files']['type'], $img_path);
                            $full_path_img = $img_path . $image;
                            if (file_exists($full_path_img))
                            {
                                if ($this->security->xss_clean($full_path_img, TRUE) !== FALSE)
                                {
                                    $slider_image = $full_path_img;
                                }
                                else
                                {
                                    unlink($full_path_img);
                                }
                            }
                        }


                        if(!empty($slider_image))
                        {
                            $slider_images[$imi] = $slider_image;

                            $imi++;
                        }

                        $i++;

                        if ($i == $available_count_images) {
                            break;
                        }
                    }
                }
            }
            elseif ($this->input->post('cb_slider_block1', true))
            {
                // Удаление изображений
                if(!empty($slider_images))
                {
                    foreach($slider_images as $s_image)
                    {
                        if(is_file($s_image))
                        {
                            unlink($s_image);
                        }
                    }
                    unset($s_image);
                }
                $slider_images = 'default';
            }
            elseif(empty($slider_images) and !$this->input->post('cb_slider_block1', true))
            {
                $slider_images = 'not_default';
            }

            $slider_images = (empty($slider_images)) ? 'default' : implode(';', $slider_images);

            // Заголовк страницы
            $main_title_bbcode = mb_substr(strip_tags($this->input->post('ta_main_title'), '<span><br/><b><i><p>'), 0, 255);

            $up_res = $this->Course_model->setCourseLandingBlock1($course_id, $hide_block, $landing_style,
                $b1_bg_color, $b1_bg_opacity, $slider_images, $main_title_bbcode, $this->date);

            if ($up_res === true) {
                // Изменения сохранены
                $this->session->set_tempdata('message', 10, 60);
            }
            else {
                // Изменения не сохранены
                $this->session->set_tempdata('message', 112, 60);
            }

            header('Location: /administration/nutrition/'.$course_id.'/landing/1');
        }
        elseif ($this->input->post('bt_save_block_2', true))
        {
            // БЛОК 2
            // Скрыть блок со страницы просмотра
            $hide_block = (!empty($this->input->post('cb_hide_block2', true))) ? 1 : 0;

            // Шапка фона
            $b2_bg_top = (!empty($landing['block2']['bg_top_orig']) and is_file($landing['block2']['bg_top_orig']))
                ? $landing['block2']['bg_top_orig']
                : 'not_default';
            if (is_uploaded_file($_FILES['bg_top_file_block2']['tmp_name']))
            {
                $image = parent::uploadImage('bg_top_file_block2', $_FILES['bg_top_file_block2']['type'], $img_path);
                $full_path_img = $img_path . $image;
                if (file_exists($full_path_img))
                {
                    if ($this->security->xss_clean($full_path_img, TRUE) !== FALSE)
                    {
                        if(is_file($b2_bg_top))
                        {
                            unlink($b2_bg_top);
                        }
                        $b2_bg_top = $full_path_img;
                    }
                    else
                    {
                        unlink($full_path_img);
                    }
                }
            }
            elseif($this->input->post('cb_default_bg_top_block2', true))
            {
                if(is_file($b2_bg_top))
                {
                    unlink($b2_bg_top);
                }
                $b2_bg_top = 'default';
            }

            // Фон
            $b2_bg = (!empty($landing['block2']['bg_orig']) and is_file($landing['block2']['bg_orig']))
                ? $landing['block2']['bg_orig']
                : 'not_default';
            // Файл фона
            if (is_uploaded_file($_FILES['bg_file_block2']['tmp_name']))
            {
                $image = parent::uploadImage('bg_file_block2', $_FILES['bg_file_block2']['type'], $img_path);
                $full_path_img = $img_path . $image;
                if (file_exists($full_path_img))
                {
                    if ($this->security->xss_clean($full_path_img, TRUE) !== FALSE)
                    {
                        if(is_file($b2_bg))
                        {
                            unlink($b2_bg);
                        }
                        $b2_bg = $full_path_img;
                    }
                    else
                    {
                        unlink($full_path_img);
                    }
                }
            }
            elseif($this->input->post('cb_default_bg_block2', true))
            {
                if(is_file($b2_bg))
                {
                    unlink($b2_bg);
                }
                $b2_bg = 'default';
            }

            // Цвет фона блока
            $color = $this->input->post('i_bg_color_block2', true);
            $b2_bg_color = (!empty($color) and preg_match($regexp_color, $color)) ? $color : '';

            // Прозрачность фонового изображения блока
            $b2_bg_opacity = is_numeric($this->input->post('r_opacity_block2', true)) ? $this->input->post('r_opacity_block2', true) : 0;

            // Изображение тренера
            $b2_image = (!empty($landing['block2']['image_orig']) and is_file($landing['block2']['image_orig']))
                ? $landing['block2']['image_orig']
                : 'not_default';
            if (is_uploaded_file($_FILES['couch_file_block2']['tmp_name']))
            {
                $image = parent::uploadImage('couch_file_block2', $_FILES['couch_file_block2']['type'], $img_path);
                $full_path_img = $img_path . $image;
                if (file_exists($full_path_img))
                {
                    if ($this->security->xss_clean($full_path_img, TRUE) !== FALSE)
                    {
                        if(is_file($b2_image))
                        {
                            unlink($b2_image);
                        }
                        $b2_image = $full_path_img;
                    }
                    else
                    {
                        unlink($full_path_img);
                    }
                }
            }
            elseif ($this->input->post('cb_couch_image_block2', true))
            {
                if(is_file($b2_image))
                {
                    unlink($b2_image);
                }
                $b2_image = 'default';
            }

            // Информация
            $b2_title    = mb_substr(strip_tags($this->input->post('i_title_block2', true)), 0, 60);
            $b2_subtitle = mb_substr(strip_tags($this->input->post('i_subtitle_block2', true)), 0, 70);
            $b2_text     = mb_substr(strip_tags($this->input->post('i_text_block2', true)), 0, 60);
            $b2_button   = mb_substr(strip_tags($this->input->post('i_button_block2', true)), 0, 40);

            $up_res = $this->Course_model->setCourseLandingBlock2($course_id, $hide_block, $b2_bg_top, $b2_bg_color,
                $b2_bg_opacity, $b2_bg, $b2_image, $b2_title, $b2_subtitle, $b2_text, $b2_button, $this->date);


            if ($up_res === true) {
                // Изменения сохранены
                $this->session->set_tempdata('message', 10, 60);
            } else {
                // Изменения не сохранены
                $this->session->set_tempdata('message', 112, 60);
            }

            header('Location: /administration/nutrition/'.$course_id.'/landing/2');
        }
        elseif ($this->input->post('bt_save_block_3', true))
        {
            // БЛОК 3
            // Скрыть блок со страницы просмотра
            $hide_block = (!empty($this->input->post('cb_hide_block3', true))) ? 1 : 0;

            // Фон
            $b3_bg = (!empty($landing['block3']['bg_orig']) and is_file($landing['block3']['bg_orig']))
                ? $landing['block3']['bg_orig']
                : 'not_default';
            // Файл фона
            if (is_uploaded_file($_FILES['bg_file_block3']['tmp_name']))
            {
                $image = parent::uploadImage('bg_file_block3', $_FILES['bg_file_block3']['type'], $img_path);
                $full_path_img = $img_path . $image;
                if (file_exists($full_path_img))
                {
                    if ($this->security->xss_clean($full_path_img, TRUE) !== FALSE)
                    {
                        if(is_file($b3_bg))
                        {
                            unlink($b3_bg);
                        }
                        $b3_bg = $full_path_img;
                    }
                    else
                    {
                        unlink($full_path_img);
                    }
                }
            }
            elseif ($this->input->post('cb_default_bg_block3', true))
            {
                if(is_file($b3_bg))
                {
                    unlink($b3_bg);
                }
                $b3_bg = 'default';
            }

            // Цвет фона блока
            $color = $this->input->post('i_bg_color_block3', true);
            $b3_bg_color = (!empty($color) and preg_match($regexp_color, $color)) ? $color : '';

            // Прозрачность фонового изображения блока
            $b3_bg_opacity = is_numeric($this->input->post('r_opacity_block3', true)) ? $this->input->post('r_opacity_block3', true) : 0;

            // Изображение 1
            $b3_image1 = (!empty($landing['block3']['image1_orig']) and is_file($landing['block3']['image1_orig']))
                ? $landing['block3']['image1_orig']
                : 'not_default';
            // Изображение 1
            if (is_uploaded_file($_FILES['result_file1_block3']['tmp_name']))
            {
                $image = parent::uploadImage('result_file1_block3', $_FILES['result_file1_block3']['type'], $img_path);
                $full_path_img = $img_path . $image;
                if (file_exists($full_path_img))
                {
                    if ($this->security->xss_clean($full_path_img, TRUE) !== FALSE)
                    {
                        if(is_file($b3_image1))
                        {
                            unlink($b3_image1);
                        }
                        $b3_image1 = $full_path_img;
                    }
                    else
                    {
                        unlink($full_path_img);
                    }
                }
            }
            elseif ($this->input->post('cb_photo1_block3', true))
            {
                if(is_file($b3_image1))
                {
                    unlink($b3_image1);
                }
                $b3_image1 = 'default';
            }

            // Изображение 2
            $b3_image2 = (!empty($landing['block3']['image2_orig']) and is_file($landing['block3']['image2_orig']))
                ? $landing['block3']['image2_orig']
                : 'not_default';
            if (is_uploaded_file($_FILES['result_file2_block3']['tmp_name']))
            {
                $image = parent::uploadImage('result_file2_block3', $_FILES['result_file2_block3']['type'], $img_path);
                $full_path_img = $img_path . $image;
                if (file_exists($full_path_img))
                {
                    if ($this->security->xss_clean($full_path_img, TRUE) !== FALSE)
                    {
                        if(is_file($b3_image2))
                        {
                            unlink($b3_image2);
                        }
                        $b3_image2 = $full_path_img;
                    }
                    else
                    {
                        unlink($full_path_img);
                    }
                }
            }
            elseif ($this->input->post('cb_photo2_block3', true))
            {
                if(is_file($b3_image2))
                {
                    unlink($b3_image2);
                }
                $b3_image2 = 'default';
            }

            // Информация
            //$b3_title    = mb_substr(strip_tags($this->input->post('i_title_block3', true)), 0, 60);
            $b3_title = mb_substr(strip_tags($this->input->post('i_title_block3'), '<span><br/><b><i><p>'), 0, 255);

            //$b3_subtitle = mb_substr(strip_tags($this->input->post('i_subtitle_block3', true)), 0, 60);
            $b3_subtitle = mb_substr(strip_tags($this->input->post('i_subtitle_block3'), '<span><br/><b><i><p>'), 0, 255);

            // Результаты
            //$b3_r_title    = mb_substr(strip_tags($this->input->post('i_result_title_block3', true)), 0, 60);
            $b3_r_title = mb_substr(strip_tags($this->input->post('i_result_title_block3'), '<span><br/><b><i><p>'), 0, 255);
            //$b3_r_subtitle = mb_substr(strip_tags($this->input->post('i_result_subtitle_block3', true)), 0, 60);
            $b3_r_subtitle = mb_substr(strip_tags($this->input->post('i_result_subtitle_block3'), '<span><br/><b><i><p>'), 0, 255);
            //$b3_r_reviews  = mb_substr(strip_tags($this->input->post('i_result_reviews_block3', true)), 0, 80);
            $b3_r_reviews = mb_substr(strip_tags($this->input->post('i_result_reviews_block3'), '<span><br/><b><i><p>'), 0, 255);

            $up_res = $this->Course_model->setCourseLandingBlock3($course_id, $hide_block, $b3_bg_color, $b3_bg_opacity,
                $b3_bg, $b3_image1, $b3_image2, $b3_title, $b3_subtitle, $b3_r_title, $b3_r_subtitle, $b3_r_reviews, $this->date);

            if ($up_res === true) {
                // Изменения сохранены
                $this->session->set_tempdata('message', 10, 60);
            } else {
                // Изменения не сохранены
                $this->session->set_tempdata('message', 112, 60);
            }

            header('Location: /administration/nutrition/'.$course_id.'/landing/3');
        }
        elseif ($this->input->post('bt_save_block_4', true))
        {
            // БЛОК 4
            // Скрыть блок со страницы просмотра
            $hide_block = (!empty($this->input->post('cb_hide_block4', true))) ? 1 : 0;

            // Фон
            $b4_bg = (!empty($landing['block4']['bg_orig']) and is_file($landing['block4']['bg_orig']))
                ? $landing['block4']['bg_orig']
                : 'not_default';

            // Файл изображения
            if (is_uploaded_file($_FILES['bg_file_block4']['tmp_name']))
            {
                $image = parent::uploadImage('bg_file_block4', $_FILES['bg_file_block4']['type'], $img_path);
                $full_path_img = $img_path . $image;
                if (file_exists($full_path_img))
                {
                    if ($this->security->xss_clean($full_path_img, TRUE) !== FALSE)
                    {
                        if(is_file($b4_bg))
                        {
                            unlink($b4_bg);
                        }
                        $b4_bg = $full_path_img;
                    }
                    else
                    {
                        unlink($full_path_img);
                    }
                }
            }
            elseif ($this->input->post('cb_default_bg_block4', true))
            {
                if(is_file($b4_bg))
                {
                    unlink($b4_bg);
                }
                $b4_bg = 'default';
            }

            // Цвет фона блока
            $color = $this->input->post('i_bg_color_block4', true);
            $b4_bg_color = (!empty($color) and preg_match($regexp_color, $color)) ? $color : '';

            // Прозрачность фонового изображения блока
            $b4_bg_opacity = is_numeric($this->input->post('r_opacity_block4', true)) ? $this->input->post('r_opacity_block4', true) : 0;

            // Изображение
            $b4_image = (!empty($landing['block4']['image_orig']) and is_file($landing['block4']['image_orig']))
                ? $landing['block4']['image_orig']
                : 'not_default';
            if (is_uploaded_file($_FILES['result_file_block4']['tmp_name'])) {
                $image = parent::uploadImage('result_file_block4', $_FILES['result_file_block4']['type'], $img_path);
                $full_path_img = $img_path . $image;
                if (file_exists($full_path_img))
                {
                    if ($this->security->xss_clean($full_path_img, TRUE) !== FALSE)
                    {
                        if(is_file($b4_image))
                        {
                            unlink($b4_image);
                        }
                        $b4_image = $full_path_img;
                    }
                    else
                    {
                        unlink($full_path_img);
                    }
                }
            }
            elseif ($this->input->post('cb_photo_block4', true))
            {
                if(is_file($b4_image))
                {
                    unlink($b4_image);
                }
                $b4_image = 'default';
            }

            // Информация
            //$b4_title    = mb_substr(strip_tags($this->input->post('i_title_block4', true)), 0, 60);
            $b4_title = mb_substr(strip_tags($this->input->post('i_title_block4'), '<span><br/><b><i><p>'), 0, 255);
            //$b4_subtitle = mb_substr(strip_tags($this->input->post('i_subtitle_block4', true)), 0, 80);
            $b4_subtitle = mb_substr(strip_tags($this->input->post('i_subtitle_block4'), '<span><br/><b><i><p>'), 0, 255);
            $b4_button   = mb_substr(strip_tags($this->input->post('i_button_block4', true)), 0, 40);

            // Результат
            //$b4_r_title = mb_substr(strip_tags($this->input->post('i_result_title_block4', true)), 0, 60);
            $b4_r_title = mb_substr(strip_tags($this->input->post('i_result_title_block4'), '<span><br/><b><i><p>'), 0, 255);
            //$b4_r_desc  = mb_substr(strip_tags($this->input->post('i_result_desc_block4', true)), 0, 60);
            $b4_r_desc = mb_substr(strip_tags($this->input->post('i_result_desc_block4'), '<span><br/><b><i><p>'), 0, 255);

            $up_res = $this->Course_model->setCourseLandingBlock4($course_id, $hide_block, $b4_bg_color, $b4_bg_opacity,
                $b4_bg, $b4_image, $b4_title, $b4_subtitle, $b4_r_title, $b4_r_desc, $b4_button, $this->date);

            if ($up_res === true) {
                // Изменения сохранены
                $this->session->set_tempdata('message', 10, 60);
            } else {
                // Изменения не сохранены
                $this->session->set_tempdata('message', 112, 60);
            }

            header('Location: /administration/nutrition/'.$course_id.'/landing/4');
        }
        elseif ($this->input->post('bt_save_block_5', true))
        {
            // БЛОК 5
            // Скрыть блок со страницы просмотра
            $hide_block = (!empty($this->input->post('cb_hide_block5', true))) ? 1 : 0;

            // Фон
            $b5_bg = (!empty($landing['block5']['bg_orig']) and is_file($landing['block5']['bg_orig']))
                ? $landing['block5']['bg_orig']
                : 'not_default'; // Фон по умолчанию

            // Файл изображения
            if (is_uploaded_file($_FILES['bg_file_block5']['tmp_name']))
            {
                $image = parent::uploadImage('bg_file_block5', $_FILES['bg_file_block5']['type'], $img_path);
                $full_path_img = $img_path . $image;
                if (file_exists($full_path_img))
                {
                    if ($this->security->xss_clean($full_path_img, TRUE) !== FALSE)
                    {
                        if(is_file($b5_bg))
                        {
                            unlink($b5_bg);
                        }
                        $b5_bg = $full_path_img;
                    }
                    else
                    {
                        unlink($full_path_img);
                    }
                }
            }
            elseif ($this->input->post('cb_default_bg_block5', true))
            {
                if(is_file($b5_bg))
                {
                    unlink($b5_bg);
                }
                $b5_bg = 'default';
            }

            // Цвет фона блока
            $color = $this->input->post('i_bg_color_block5', true);
            $b5_bg_color = (!empty($color) and preg_match($regexp_color, $color)) ? $color : '';

            // Прозрачность фонового изображения блока
            $b5_bg_opacity = is_numeric($this->input->post('r_opacity_block5', true)) ? $this->input->post('r_opacity_block5', true) : 0;

            // Боковое фото 1
            $b5_image1 = (!empty($landing['block5']['image1_orig']) and is_file($landing['block5']['image1_orig']))
                ? $landing['block5']['image1_orig']
                : 'not_default';
            if (is_uploaded_file($_FILES['couch_file1_block5']['tmp_name']))
            {
                $image = parent::uploadImage('couch_file1_block5', $_FILES['couch_file1_block5']['type'], $img_path);
                $full_path_img = $img_path . $image;
                if (file_exists($full_path_img))
                {
                    if ($this->security->xss_clean($full_path_img, TRUE) !== FALSE)
                    {
                        if(is_file($b5_image1))
                        {
                            unlink($b5_image1);
                        }
                        $b5_image1 = $full_path_img;
                    }
                    else
                    {
                        unlink($full_path_img);
                    }
                }
            }
            elseif ($this->input->post('cb_photo1_block5', true))
            {
                if(is_file($b5_image1))
                {
                    unlink($b5_image1);
                }
                $b5_image1 = 'default';
            }

            // Боковое фото 2
            $b5_image2 = (!empty($landing['block5']['image2_orig']) and is_file($landing['block5']['image2_orig']))
                ? $landing['block5']['image2_orig']
                : 'not_default';
            if (is_uploaded_file($_FILES['couch_file2_block5']['tmp_name']))
            {
                $image = parent::uploadImage('couch_file2_block5', $_FILES['couch_file2_block5']['type'], $img_path);
                $full_path_img = $img_path . $image;
                if (file_exists($full_path_img))
                {
                    if ($this->security->xss_clean($full_path_img, TRUE) !== FALSE)
                    {
                        if(is_file($b5_image2))
                        {
                            unlink($b5_image2);
                        }
                        $b5_image2 = $full_path_img;
                    }
                    else
                    {
                        unlink($full_path_img);
                    }
                }
            }
            elseif ($this->input->post('cb_photo2_block5', true))
            {
                if($b5_image2)
                {
                    unlink($b5_image2);
                }
                $b5_image2 = 'default';
            }

            // Аватар
            $b5_image3 = (!empty($landing['block5']['image3_orig']) and is_file($landing['block5']['image3_orig']))
                ? $landing['block5']['image3_orig']
                : 'not_default';
            if (is_uploaded_file($_FILES['couch_avatar_block5']['tmp_name']))
            {
                $image = parent::uploadImage('couch_avatar_block5', $_FILES['couch_avatar_block5']['type'], $img_path);
                $full_path_img = $img_path . $image;
                if (file_exists($full_path_img))
                {
                    if ($this->security->xss_clean($full_path_img, TRUE) !== FALSE)
                    {
                        if(is_file($b5_image3))
                        {
                            unlink($b5_image3);
                        }
                        $b5_image3 = $full_path_img;
                    }
                    else
                    {
                        unlink($full_path_img);
                    }
                }
            }
            elseif ($this->input->post('cb_photo3_block5', true))
            {
                if(is_file($b5_image3))
                {
                    unlink($b5_image3);
                }
                $b5_image3 = 'default';
            }

            // Информация
            $b5_title    = mb_substr(strip_tags($this->input->post('i_title_block5', true)), 0, 60);
            $b5_subtitle = mb_substr(strip_tags($this->input->post('i_subtitle_block5', true)), 0, 60);
            $b5_text     = mb_substr(strip_tags($this->input->post('i_text_block5', true)), 0, 255);
            $b5_button   = mb_substr(strip_tags($this->input->post('i_button_block5', true)), 0, 40);

            // Слова тренера о программе
            $b5_r_title    = mb_substr(strip_tags($this->input->post('i_couch_title_block5', true)), 0, 50);
            $b5_r_subtitle = mb_substr(strip_tags($this->input->post('i_couch_subtitle_block5', true)), 0, 50);
            $b5_r_text     = mb_substr(strip_tags($this->input->post('i_couch_text_block5', true)), 0, 120);

            $up_res = $this->Course_model->setCourseLandingBlock5($course_id, $hide_block, $b5_bg_color, $b5_bg_opacity,
                $b5_bg, $b5_image1, $b5_image2, $b5_image3, $b5_title, $b5_subtitle, $b5_text, $b5_r_title, $b5_r_subtitle,
                $b5_r_text, $b5_button, $this->date);

            if ($up_res === true) {
                // Изменения сохранены
                $this->session->set_tempdata('message', 10, 60);
            } else {
                // Изменения не сохранены
                $this->session->set_tempdata('message', 112, 60);
            }

            header('Location: /administration/nutrition/'.$course_id.'/landing/5');
        }
        elseif ($this->input->post('bt_save_block_6', true))
        {
            // БЛОК 6
            // Скрыть блок со страницы просмотра
            $hide_block = (!empty($this->input->post('cb_hide_block6', true))) ? 1 : 0;

            // Фон
            $b6_bg = (!empty($landing['block6']['bg_orig']) and is_file($landing['block6']['bg_orig']))
                ? $landing['block6']['bg_orig']
                : 'not_default';
            // Файл изображения
            if (is_uploaded_file($_FILES['bg_file_block6']['tmp_name']))
            {
                $image = parent::uploadImage('bg_file_block6', $_FILES['bg_file_block6']['type'], $img_path);
                $full_path_img = $img_path . $image;
                if (file_exists($full_path_img))
                {
                    if ($this->security->xss_clean($full_path_img, TRUE) !== FALSE)
                    {
                        if(is_file($b6_bg))
                        {
                            unlink($b6_bg);
                        }
                        $b6_bg = $full_path_img;
                    }
                    else
                    {
                        unlink($full_path_img);
                    }
                }
            }
            elseif ($this->input->post('cb_default_bg_block6', true))
            {
                if(is_file($b6_bg))
                {
                    unlink($b6_bg);
                }
                $b6_bg = 'default';
            }

            // Цвет фона блока
            $color = $this->input->post('i_bg_color_block6', true);
            $b6_bg_color = (!empty($color) and preg_match($regexp_color, $color)) ? $color : '';

            // Прозрачность фонового изображения блока
            $b6_bg_opacity = is_numeric($this->input->post('r_opacity_block6', true)) ? $this->input->post('r_opacity_block6', true) : 0;

            // Боковое фото
            $b6_image = (!empty($landing['block6']['image_orig']) and is_file($landing['block6']['image_orig']))
                ? $landing['block6']['image_orig']
                : 'not_default';
            if (is_uploaded_file($_FILES['file_block6']['tmp_name']))
            {
                $image = parent::uploadImage('file_block6', $_FILES['file_block6']['type'], $img_path);
                $full_path_img = $img_path . $image;
                if (file_exists($full_path_img))
                {
                    if ($this->security->xss_clean($full_path_img, TRUE) !== FALSE)
                    {
                        if(is_file($b6_image))
                        {
                            unlink($b6_image);
                        }
                        $b6_image = $full_path_img;
                    }
                    else
                    {
                        unlink($full_path_img);
                    }
                }
            }
            elseif ($this->input->post('cb_photo_block6', true))
            {
                if(is_file($b6_image))
                {
                    unlink($b6_image);
                }
                $b6_image = 'default';
            }

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

            $up_res = $this->Course_model->setCourseLandingBlock6($course_id, $hide_block, $b6_bg_color, $b6_bg_opacity,
                $b6_bg, $b6_image, $b6_title, $b6_desc, $b6_subtitle, $b6_advantages, $b6_button, $this->date);

            if ($up_res === true) {
                // Изменения сохранены
                $this->session->set_tempdata('message', 10, 60);
            } else {
                // Изменения не сохранены
                $this->session->set_tempdata('message', 112, 60);
            }

            header('Location: /administration/nutrition/'.$course_id.'/landing/6');
        }
        elseif ($this->input->post('bt_save_block_7', true))
        {
            // БЛОК 7
            // Скрыть блок со страницы просмотра
            $hide_block = (!empty($this->input->post('cb_hide_block7', true))) ? 1 : 0;

            // Фон
            $b7_bg = (!empty($landing['block7']['bg_orig']) and is_file($landing['block7']['bg_orig']))
                ? $landing['block7']['bg_orig']
                : 'not_default';

            // Файл изображения
            if (is_uploaded_file($_FILES['bg_file_block7']['tmp_name']))
            {
                $image = parent::uploadImage('bg_file_block7', $_FILES['bg_file_block7']['type'], $img_path);
                $full_path_img = $img_path . $image;
                if (file_exists($full_path_img))
                {
                    if ($this->security->xss_clean($full_path_img, TRUE) !== FALSE)
                    {
                        if(is_file($b7_bg))
                        {
                            unlink($b7_bg);
                        }
                        $b7_bg = $full_path_img;
                    }
                    else
                    {
                        unlink($full_path_img);
                    }
                }
            }
            elseif ($this->input->post('cb_default_bg_block7', true))
            {
                if(is_file($b7_bg))
                {
                    unlink($b7_bg);
                }
                $b7_bg = 'default';
            }

            // Цвет фона блока
            $color = $this->input->post('i_bg_color_block7', true);
            $b7_bg_color = (!empty($color) and preg_match($regexp_color, $color)) ? $color : '';

            // Прозрачность фонового изображения блока
            $b7_bg_opacity = is_numeric($this->input->post('r_opacity_block7', true)) ? $this->input->post('r_opacity_block7', true) : 0;

            // Информация
            $b7_title  = mb_substr(strip_tags($this->input->post('i_title_block7', true)), 0, 50);
            $b7_button = mb_substr(strip_tags($this->input->post('i_button_block7', true)), 0, 40);

            // Изображение 1
            $b7_image1 = (!empty($landing['block7']['image1_orig']) and is_file($landing['block7']['image1_orig']))
                ? $landing['block7']['image1_orig']
                : 'not_default';
            if (is_uploaded_file($_FILES['file1_block7']['tmp_name']))
            {
                $image = parent::uploadImage('file1_block7', $_FILES['file1_block7']['type'], $img_path);
                $full_path_img = $img_path . $image;
                if (file_exists($full_path_img))
                {
                    if ($this->security->xss_clean($full_path_img, TRUE) !== FALSE)
                    {
                        if(is_file($b7_image1))
                        {
                            unlink($b7_image1);
                        }
                        $b7_image1 = $full_path_img;
                    }
                    else
                    {
                        unlink($full_path_img);
                    }
                }
            }
            elseif ($this->input->post('cb_image1_block7', true))
            {
                if(is_file($b7_image1))
                {
                    unlink($b7_image1);
                }
                $b7_image1 = 'default';
            }

            // Изображение 2
            $b7_image2 = (!empty($landing['block7']['image2_orig']) and is_file($landing['block7']['image2_orig']))
                ? $landing['block7']['image2_orig']
                : 'not_default';
            if (is_uploaded_file($_FILES['file2_block7']['tmp_name']))
            {
                $image = parent::uploadImage('file2_block7', $_FILES['file2_block7']['type'], $img_path);
                $full_path_img = $img_path . $image;
                if (file_exists($full_path_img))
                {
                    if ($this->security->xss_clean($full_path_img, TRUE) !== FALSE)
                    {
                        if(is_file($b7_image2))
                        {
                            unlink($b7_image2);
                        }
                        $b7_image2 = $full_path_img;
                    }
                    else
                    {
                        unlink($full_path_img);
                    }
                }
            }
            elseif ($this->input->post('cb_image2_block7', true))
            {
                if(is_file($b7_image2))
                {
                    unlink($b7_image2);
                }
                $b7_image2 = 'default';
            }

            // Изображение 3
            $b7_image3 = (!empty($landing['block7']['image3_orig']) and is_file($landing['block7']['image3_orig']))
                ? $landing['block7']['image3_orig']
                : 'not_default';
            if (is_uploaded_file($_FILES['file3_block7']['tmp_name']))
            {
                $image = parent::uploadImage('file3_block7', $_FILES['file3_block7']['type'], $img_path);
                $full_path_img = $img_path . $image;
                if (file_exists($full_path_img))
                {
                    if ($this->security->xss_clean($full_path_img, TRUE) !== FALSE)
                    {
                        if(is_file($b7_image3))
                        {
                            unlink($b7_image3);
                        }
                        $b7_image3 = $full_path_img;
                    }
                    else
                    {
                        unlink($full_path_img);
                    }
                }
            }
            elseif ($this->input->post('cb_image3_block7', true))
            {
                if(is_file($b7_image3))
                {
                    unlink($b7_image3);
                }
                $b7_image3 = 'default';
            }

            // Изображение 4
            $b7_image4 = (!empty($landing['block7']['image4_orig']) and is_file($landing['block7']['image4_orig']))
                ? $landing['block7']['image4_orig']
                : 'not_default';
            if (is_uploaded_file($_FILES['file4_block7']['tmp_name']))
            {
                $image = parent::uploadImage('file4_block7', $_FILES['file4_block7']['type'], $img_path);
                $full_path_img = $img_path . $image;
                if (file_exists($full_path_img))
                {
                    if ($this->security->xss_clean($full_path_img, TRUE) !== FALSE)
                    {
                        if(is_file($b7_image4))
                        {
                            unlink($b7_image4);
                        }
                        $b7_image4 = $full_path_img;
                    }
                    else
                    {
                        unlink($full_path_img);
                    }
                }
            }
            elseif ($this->input->post('cb_image4_block7', true))
            {
                if(is_file($b7_image4))
                {
                    unlink($b7_image4);
                }
                $b7_image4 = 'default';
            }

            // Тексты планов
            $b7_texts     = '';
            $input_texts  = $this->input->post('i_text_block7', TRUE);
            foreach ($input_texts as $text)
            {
                $text = mb_substr(strip_tags($text), 0, 160);

                $b7_texts  .= $text . ';';
            }
            unset($text);

            $up_res = $this->Course_model->setCourseLandingBlock7($course_id, $hide_block, $b7_bg_color, $b7_bg_opacity,
                $b7_bg, $b7_title, $b7_image1, $b7_image2, $b7_image3, $b7_image4, $b7_texts, $b7_button, $this->date);

            if ($up_res === true) {
                // Изменения сохранены
                $this->session->set_tempdata('message', 10, 60);
            } else {
                // Изменения не сохранены
                $this->session->set_tempdata('message', 112, 60);
            }

            header('Location: /administration/nutrition/'.$course_id.'/landing/7');
        }
        elseif ($this->input->post('bt_save_block_8', true))
        {
            // БЛОК 8
            // Скрыть блок со страницы просмотра
            $hide_block = (!empty($this->input->post('cb_hide_block8', true))) ? 1 : 0;

            // Фон
            $b8_bg = (!empty($landing['block8']['bg_orig']) and is_file($landing['block8']['bg_orig']))
                ? $landing['block8']['bg_orig']
                : 'not_default';
            // Файл изображения
            if (is_uploaded_file($_FILES['bg_file_block8']['tmp_name']))
            {
                $image = parent::uploadImage('bg_file_block8', $_FILES['bg_file_block8']['type'], $img_path);
                $full_path_img = $img_path . $image;
                if(file_exists($full_path_img))
                {
                    if ($this->security->xss_clean($full_path_img, TRUE) !== FALSE)
                    {
                        if(is_file($b8_bg))
                        {
                            unlink($b8_bg);
                        }
                        $b8_bg = $full_path_img;
                    }
                    else
                    {
                        unlink($full_path_img);
                    }
                }
            }
            elseif ($this->input->post('cb_default_bg_block8', true))
            {
                if(is_file($b8_bg))
                {
                    unlink($b8_bg);
                }
                $b8_bg = 'default';
            }

            // Цвет фона блока
            $color = $this->input->post('i_bg_color_block8', true);
            $b8_bg_color = (!empty($color) and preg_match($regexp_color, $color)) ? $color : '';

            // Прозрачность фонового изображения блока
            $b8_bg_opacity = is_numeric($this->input->post('r_opacity_block8', true)) ? $this->input->post('r_opacity_block8', true) : 0;

            // Информация
            $b8_title    = mb_substr(strip_tags($this->input->post('i_title_block8', true)), 0, 60);
            $b8_desc1    = mb_substr(strip_tags($this->input->post('i_desc1_block8', true)), 0, 160);
            $b8_subtitle = mb_substr(strip_tags($this->input->post('i_subtitle_block8', true)), 0, 60);
            $b8_desc2    = mb_substr(strip_tags($this->input->post('i_desc2_block8', true)), 0, 100);
            $b8_button   = mb_substr(strip_tags($this->input->post('i_button_block8', true)), 0, 40);

            // Информация
            $b8_old_price = is_numeric($this->input->post('i_old_price_block8', true)) ? $this->input->post('i_old_price_block8', true) : '';
            $b8_new_price = is_numeric($this->input->post('i_new_price_block8', true)) ? $this->input->post('i_new_price_block8', true) : '';

            $up_res = $this->Course_model->setCourseLandingBlock8($course_id, $hide_block, $b8_bg_color, $b8_bg_opacity,
                $b8_bg, $b8_title, $b8_desc1, $b8_subtitle, $b8_desc2, $b8_old_price, $b8_new_price, $b8_button, $this->date);

            if ($up_res === true) {
                // Изменения сохранены
                $this->session->set_tempdata('message', 10, 60);
            } else {
                // Изменения не сохранены
                $this->session->set_tempdata('message', 112, 60);
            }

            header('Location: /administration/nutrition/'.$course_id.'/landing/8');
        }
        elseif ($this->input->post('bt_delete_landing_img', true))
        {
            $img_types = array('background', 'background_top', 'image', 'slider');

            $bt = $this->input->post('bt_delete_landing_img', true);
            reset($bt);
            $img_block_id = (is_numeric(key($bt))) ? key($bt) : null;
            reset($bt[$img_block_id]);
            $img_type_id = (is_numeric(key($bt[$img_block_id]))) ? key($bt[$img_block_id]) : null;
            $img_type = (array_key_exists($img_type_id, $img_types)) ? $img_types[$img_type_id] : null;
            reset($bt[$img_block_id][$img_type_id]);
            $img_id = (is_numeric(key($bt[$img_block_id][$img_type_id]))) ? '_'.key($bt[$img_block_id][$img_type_id]) : null;
            $img_path = (!empty($this->input->post('img_path_'.$img_block_id.'_'.$img_type_id.$img_id, true)))
                ? '.'.$this->input->post('img_path_'.$img_block_id.'_'.$img_type_id.$img_id, true) : null;

            // Удаление изображения и сохранение данных в БД
            if(is_file($img_path) and !empty($img_type))
            {
                $res_del = unlink($img_path);

                if($res_del === true)
                {
                    $del_img = $this->Course_model->deleteLandingImage($course_id, $img_block_id, $img_type, $img_id, $img_path);
                }
            }

            if (!empty($del_img) and $del_img === true)
            {
                // Изменения сохранены
                $this->session->set_tempdata('message', 10, 60);
            }

            header('Location: /administration/nutrition/'.$course_id.'/landing/'.$img_block_id);
        }

        $result = array_merge($course_landing, $landing_list, $course);

        // Объединенные данные страница
        $this->page_data['title']         = 'АП - Редактирование данных Landing page курса';
        $this->page_data['page_menu']     = 'a_courses_n';
        $this->page_data['page_submenu']  = 'landing';
        $this->page_data['course_id']     = $course_id;
        $this->page_data['lend_block_id'] = $block_id;

        $this->load->view('header/header_admin', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('course/nutritions/settings/course', $result);
        $this->load->view('footer/footer');
    }


    /* БЛОК ФУНКЦИЙ БЛЮДА */

    /**
     * Список блюд
     */
    public function meals()
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3 or $this->session->user['blocked'] == 1)
        {
            parent::pageNotFound($this->page_url);
        }

        $result = $this->Course_model->getMeals();

        // Объединенные данные страница
        $this->page_data['title'] = 'АП - Блюда';
        $this->page_data['page_menu']    = 'a_courses_n';
        $this->page_data['page_submenu'] = 'meals';

        $this->load->view('header/header_admin', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('meals/meals', $result);
        $this->load->view('footer/footer');
    }

    /**
     * Добавление нового блюда
     */
    public function newMeal()
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3 or $this->session->user['blocked'] == 1)
        {
            parent::pageNotFound($this->page_url);
        }

        if($this->input->post('bt_save_new_meal', true))
        {
            $category         = is_numeric($this->input->post('s_category', true)) ? $this->input->post('s_category', true) : 1;
            $type             = is_numeric($this->input->post('s_meal_type', true)) ? $this->input->post('s_meal_type', true) : 1;
            $name             = mb_substr(strip_tags($this->input->post('i_name')), 0, 255);
            $description      = mb_substr(strip_tags($this->input->post('ta_desc')), 0, 2000);
            $ingredients_text = mb_substr(strip_tags($this->input->post('ta_ingredients')), 0, 2000);

            // Ингредиенты
            $ingredients         = array();
            $total_weight        = 0;
            $total_proteins      = 0;
            $total_fats          = 0;
            $total_carbohydrates = 0;
            $total_calories      = 0;

            $ingr_names         = $this->input->post('i_ingredient_name', true);
            $ingr_weights       = $this->input->post('i_ingredient_weight', true);
            $ingr_proteins      = $this->input->post('i_ingredient_proteins', true);
            $ingr_fats          = $this->input->post('i_ingredient_fats', true);
            $ingr_carbohydrates = $this->input->post('i_ingredient_carbohydrates', true);
            $ingr_calories      = $this->input->post('i_ingredient_calories', true);

            if(is_array($ingr_names))
            {
                $i = 0;
                foreach($ingr_names as $ingr_id => $ingr_name)
                {
                    $ingr_name = mb_substr(strip_tags($ingr_name), 0, 255);

                    if(!empty($ingr_name))
                    {
                        $ingredients[$i]['name']          = $ingr_name;
                        $ingredients[$i]['weight']        = is_numeric($ingr_weights[$ingr_id]) ? $ingr_weights[$ingr_id] : 0;
                        $ingredients[$i]['proteins']      = is_numeric($ingr_proteins[$ingr_id]) ? $ingr_proteins[$ingr_id] : 0;
                        $ingredients[$i]['fats']          = is_numeric($ingr_fats[$ingr_id]) ? $ingr_fats[$ingr_id] : 0;
                        $ingredients[$i]['carbohydrates'] = is_numeric($ingr_carbohydrates[$ingr_id]) ? $ingr_carbohydrates[$ingr_id] : 0;
                        $ingredients[$i]['calories']      = is_numeric($ingr_calories[$ingr_id]) ? $ingr_calories[$ingr_id] : 0;

                        $total_weight        += $ingredients[$i]['weight'];
                        $total_proteins      += $ingredients[$i]['proteins'];
                        $total_fats          += $ingredients[$i]['fats'];
                        $total_carbohydrates += $ingredients[$i]['carbohydrates'];
                        $total_calories      += $ingredients[$i]['calories'];

                        $i++;
                    }
                }
                unset($ingr_name);
            }

            $i_total_weights       = is_numeric($this->input->post('i_meal_weight', true)) ? $this->input->post('i_meal_weight', true) : null;
            $i_total_proteins      = is_numeric($this->input->post('i_meal_proteins', true)) ? $this->input->post('i_meal_proteins', true) : null;
            $i_total_fats          = is_numeric($this->input->post('i_meal_fats', true)) ? $this->input->post('i_meal_fats', true) : null;
            $i_total_carbohydrates = is_numeric($this->input->post('i_meal_carbohydrates', true)) ? $this->input->post('i_meal_carbohydrates', true) : null;
            $i_total_calories      = is_numeric($this->input->post('i_meal_calories', true)) ? $this->input->post('i_meal_calories', true) : null;

            $total_weight        = ($i_total_weights > $total_weight) ? $i_total_weights : $total_weight;
            $total_proteins      = ($i_total_proteins > $total_proteins) ? $i_total_proteins : $total_proteins;
            $total_fats          = ($i_total_fats > $total_fats) ? $i_total_fats : $total_fats;
            $total_carbohydrates = ($i_total_carbohydrates > $total_carbohydrates) ? $i_total_carbohydrates : $total_carbohydrates;
            $total_calories      = ($i_total_calories > $total_calories) ? $i_total_calories : $total_calories;

            // Видео блюда
            $ta_videos = $this->input->post('ta_videos_block', true);
            $insert_videos = array();
            if(is_array($ta_videos))
            {
                $i = 0;
                foreach($ta_videos as $video)
                {
                    $insert_videos[$i] = htmlspecialchars($video, ENT_QUOTES);

                    $i++;
                }
                unset($ingr_name);
            }

            $res_ins = $this->Course_model->setNewMeal($category, $name, $description, $type, $insert_videos, $ingredients,
                $ingredients_text, $total_weight, $total_proteins, $total_fats, $total_carbohydrates, $total_calories,
                $this->user_id, $this->date);

            if (is_numeric($res_ins))
            {
                $meal_id = $res_ins;
                $img_path = './meals_files/' . $meal_id . '/';

                if (!file_exists($img_path))
                {
                    chdir('meals_files');
                    if (!is_dir($meal_id)) {
                        mkdir($meal_id);
                        chmod($meal_id, 0777);
                    }
                    chdir('../');
                }

                // Загрузка изображений на сервер
                if(!empty($_FILES['meals_images']))
                {
                    $input_files = $_FILES;
                    $i = 0;
                    foreach ($input_files['meals_images']['name'] as $name)
                    {
                        $_FILES['meals_images'] = array(
                            'name' => $input_files['meals_images']['name'][$i],
                            'type' => $input_files['meals_images']['type'][$i],
                            'tmp_name' => $input_files['meals_images']['tmp_name'][$i],
                            'error' => $input_files['meals_images']['error'][$i],
                            'size' => $input_files['meals_images']['size'][$i]);

                        if (!empty($_FILES['meals_images']) and is_uploaded_file($_FILES['meals_images']['tmp_name']))
                        {
                            $image = parent::uploadImage('meals_images', $_FILES['meals_images']['type'], $img_path);
                            $full_path_img = $img_path . $image;
                            if (file_exists($full_path_img))
                            {
                                if ($this->security->xss_clean($full_path_img, TRUE) === FALSE)
                                {
                                    unlink($full_path_img);
                                }
                            }
                        }

                        $i++;
                    }
                }

                // Изменения сохранены
                $this->session->set_tempdata('message', 10, 60);
                header('Location: /administration/meal/' . $res_ins);
            }
            else
            {
                // Изменения не сохранены
                $this->session->set_tempdata('message', 158, 60);
                header('Location: /administration/meal/new');
            }
        }

        $meals_types = $this->Course_model->getMealsTypes();

        // Объединенные данные страница
        $this->page_data['title'] = 'АП - Новое блюдо';
        $this->page_data['page_menu']    = 'a_courses_n';
        $this->page_data['page_submenu'] = 'meals';

        $this->load->view('header/header_admin', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('meals/new_meal', $meals_types);
        $this->load->view('footer/footer');
    }

    /**
     * Импорт блюд из файла Excel
     */
    public function importMeals()
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3 or $this->session->user['blocked'] == 1)
        {
            parent::pageNotFound($this->page_url);
        }

        if($this->input->post('bt_load_excel', true))
        {
            // Загрузка файла на сервер
            $path = './xls/';

            if (!empty($_FILES['xls']) and is_uploaded_file($_FILES['xls']['tmp_name']))
            {
                $file = parent::uploadFile('xls', $_FILES['xls']['type'], $path);
                $full_path_file = $path . $file;
                if (file_exists($full_path_file))
                {
                    if ($this->security->xss_clean($full_path_file, TRUE) === FALSE)
                    {
                        unlink($full_path_file);
                        // Файл Excel не прошел проверку
                        $this->session->set_tempdata('message', 167, 60);
                        header('Location: /administration/meal/import');
                    }
                    else
                    {
                        $result = self::saveMealsFromXLS($path, $file);
                        if(!empty($result['meals']))
                        {
                            $ins_meals = $this->Course_model->setNewMeals($result, $this->user_id, $this->date);
                            if($ins_meals === true)
                            {
                                // Данные из файла Excel сохранены
                                $this->session->set_tempdata('message', 10, 60);
                            }
                            else
                            {
                                // Часть/Все данные из файла Excel не сохранены
                                $this->session->set_tempdata('message', 168, 60);
                            }

                            header('Location: /administration/meals');
                        }
                        else
                        {
                            // Данные из файла Excel не прочитаны
                            $this->session->set_tempdata('message', 169, 60);
                            header('Location: /administration/meal/import');
                        }
                    }
                }
                else
                {
                    // Файл Excel не загружен
                    $this->session->set_tempdata('message', 170, 60);
                    header('Location: /administration/meal/import');
                }
            }
            else
            {
                // Файл Excel не загружен
                $this->session->set_tempdata('message', 170, 60);
                header('Location: /administration/meal/import');
            }
        }

        $meals_types = $this->Course_model->getMealsTypes();

        // Объединенные данные страница
        $this->page_data['title'] = 'АП - Импотр блюд';
        $this->page_data['page_menu']    = 'a_courses_n';
        $this->page_data['page_submenu'] = 'meals';

        $this->load->view('header/header_admin', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('meals/import_meals', $meals_types);
        $this->load->view('footer/footer');
    }

    /**
     * Форма редактирования данных блюда
     *
     * @param $meal_id
     */
    public function meal($meal_id)
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3 or $this->session->user['blocked'] == 1)
        {
            parent::pageNotFound($this->page_url);
        }

        $meal  = $this->Course_model->getMeal($meal_id);
        $types = $this->Course_model->getMealsTypes();

        if($this->input->post('bt_save_meal', true))
        {
            $db_data = $meal['meal'];

            $category         = is_numeric($this->input->post('s_category', true)) ? $this->input->post('s_category', true) : 1;
            $type             = in_array($this->input->post('s_meal_type', true), $types['meals_types_id']) ? $this->input->post('s_meal_type', true) : 1;
            $name             = mb_substr(strip_tags($this->input->post('i_name')), 0, 255);
            $description      = mb_substr(strip_tags($this->input->post('ta_desc')), 0, 2000);
            $ingredients_text = mb_substr(strip_tags($this->input->post('ta_ingredients')), 0, 2000);

            // Ингредиенты, их КБЖУ и общее КБЖУ
            $ingredients         = array();
            $insert_ingredients  = array();
            $update_ingredients  = array();
            $delete_ingredients  = array();
            $total_weight        = 0;

            $ingredients_weights = $this->input->post('i_ingredient_weight', true);

            if(is_array($ingredients_weights))
            {
                $i = 0;
                foreach($ingredients_weights as $ingr_id => $ingr_weight)
                {
                    $ingredients[$ingr_id] = $ingr_id;
                    $ingr_weight = is_numeric($ingr_weight) ? $ingr_weight : 0;

                    $total_weight += $ingr_weight;

                    // Обновление данных ингредиента
                    if(!empty($db_data['ingredients_id']) and in_array($ingr_id, $db_data['ingredients_id'])
                        and $ingr_weight != $db_data['ingredients'][$ingr_id]['weight'])
                    {
                        $update_ingredients[$ingr_id] = $ingr_weight;
                    }
                    // Добавление ингредиента
                    elseif(empty($db_data['ingredients_id']) or !in_array($ingr_id, $db_data['ingredients_id']))
                    {
                        $insert_ingredients[$ingr_id] = $ingr_weight;
                    }

                    $i++;
                }
                unset($ingr_weight);
            }
            else
            {
                // Удаление всех ингредиентов
                if(!empty($db_data['ingredients']))
                {
                    $delete_ingredients = $db_data['ingredients'];
                }
            }
            // Удаление ингредиентов
            $delete_ingredients = (!empty($db_data['ingredients_id'])) ? array_diff($db_data['ingredients_id'], $ingredients) : $delete_ingredients;

            $i_total_weights = is_numeric($this->input->post('i_meal_weight', true)) ? $this->input->post('i_meal_weight', true) : 0;
            $i_proteins      = is_numeric($this->input->post('i_meal_proteins_100', true)) ? $this->input->post('i_meal_proteins_100', true) : 0;
            $i_fats          = is_numeric($this->input->post('i_meal_fats_100', true)) ? $this->input->post('i_meal_fats_100', true) : 0;
            $i_carbohydrates = is_numeric($this->input->post('i_meal_carbohydrates_100', true)) ? $this->input->post('i_meal_carbohydrates_100', true) : 0;
            $i_calories      = is_numeric($this->input->post('i_meal_calories_100', true)) ? $this->input->post('i_meal_calories_100', true) : 0;

            $total_weight = ($total_weight == 0 and $i_total_weights > 0) ? $i_total_weights : $total_weight;
            //log_message('debug', 'WPFCC: W=' . $total_weight . ' P=' . $i_proteins . ' F=' . $i_fats . ' C=' . $i_carbohydrates . ' C=' . $i_calories );

            // Загрузка изображений на сервер
            $img_path = './meals_files/' . $meal_id . '/';
            if(!empty($_FILES['meals_images']))
            {
                $input_files = $_FILES;
                $i = 0;
                foreach ($input_files['meals_images']['name'] as $img_name)
                {
                    $_FILES['meals_images'] = array(
                        'name' => $input_files['meals_images']['name'][$i],
                        'type' => $input_files['meals_images']['type'][$i],
                        'tmp_name' => $input_files['meals_images']['tmp_name'][$i],
                        'error' => $input_files['meals_images']['error'][$i],
                        'size' => $input_files['meals_images']['size'][$i]);

                    if (!empty($_FILES['meals_images']) and is_uploaded_file($_FILES['meals_images']['tmp_name']))
                    {
                        $image = parent::uploadImage('meals_images', $_FILES['meals_images']['type'], $img_path);
                        $full_path_img = $img_path . $image;
                        if (file_exists($full_path_img))
                        {
                            if ($this->security->xss_clean($full_path_img, TRUE) === FALSE)
                            {
                                unlink($full_path_img);
                            }
                        }
                    }

                    $i++;
                }
            }

            // Видео блюда
            $ta_videos     = $this->input->post('ta_videos_block', true);
            $insert_videos = array();
            if(is_array($ta_videos))
            {
                $i = 0;
                foreach($ta_videos as $video)
                {
                    $cl_video = filter_var($video, FILTER_VALIDATE_URL, FILTER_FLAG_PATH_REQUIRED);
                    if($cl_video and !in_array($cl_video, $db_data['meal_videos']))
                    {
                        $insert_videos[$i] = $cl_video;

                        $i++;
                    }
                }
                unset($ingr_name);
            }

            // Сохранить данные в БД
            if((!empty($name) and $name != $db_data['name']) or $description != $db_data['description'] or
                $type != $db_data['type_id'] or $category != $db_data['category_id'] or
                $ingredients_text != $db_data['ingredients_text'] or $total_weight != $db_data['weight'] or
                $i_proteins != $db_data['proteins'] or $i_fats != $db_data['fats'] or
                $i_carbohydrates != $db_data['carbohydrates'] or $i_calories != $db_data['calories'] or
                !empty($insert_ingredients) or !empty($update_ingredients) or !empty($delete_ingredients) or
                !empty($insert_videos))
            {
                $res_up = $this->Course_model->updateMealSettings($meal_id, $category, $name, $description, $type,
                    $insert_videos, $insert_ingredients, $update_ingredients, $delete_ingredients, $ingredients_text,
                    $total_weight, $i_proteins, $i_fats, $i_carbohydrates, $i_calories, $this->user_id, $this->date);

                if ($res_up === true)
                {
                    // Изменения сохранены
                    $this->session->set_tempdata('message', 10, 60);
                }
                else
                {
                    // Изменения не сохранены
                    $this->session->set_tempdata('message', 158, 60);
                }
            }

            header('Location: /administration/meal/' . $meal_id);
        }
        elseif($this->input->post('bt_block_meal', true))
        {
            $res_up = $this->Course_model->blockMeal($meal_id, 1, $this->user_id, $this->date);

            if ($res_up === true)
            {
                // Изменения сохранены
                $this->session->set_tempdata('message', 10, 60);
            }
            else
            {
                // Изменения не сохранены
                $this->session->set_tempdata('message', 158, 60);
            }

            header('Location: /administration/meal/' . $meal_id);
        }
        elseif($this->input->post('bt_unblock_meal', true))
        {
            $res_up = $this->Course_model->blockMeal($meal_id, 0, $this->user_id, $this->date);

            if ($res_up === true)
            {
                // Изменения сохранены
                $this->session->set_tempdata('message', 10, 60);
            }
            else
            {
                // Изменения не сохранены
                $this->session->set_tempdata('message', 158, 60);
            }

            header('Location: /administration/meal/' . $meal_id);
        }
        elseif($this->input->post('bt_delete_img', true))
        {
            $img_id     = key($this->input->post('bt_delete_img', true));
            $path_image = '.' . $this->input->post('img_path_'.$img_id, true);
            $path       = './meals_files/' . $meal_id;

            if(file_exists($path_image) and dirname($path_image) == $path)
            {
                unlink($path_image);
            }

            header('Location: /administration/meal/' . $meal_id);
        }
        elseif($this->input->post('bt_del_img', true))
        {
            $path_image = '.' . $this->input->post('img_path', true);

            if(file_exists($path_image))
            {
                unlink($path_image);
            }

            header('Location: /administration/meal/' . $meal_id);
        }
        elseif($this->input->post('bt_delete_ml_video', true))
        {
            $video_id = key($this->input->post('bt_delete_ml_video', true));

            $res_up = $this->Course_model->deleteMealVideo($meal_id, $video_id);

            if ($res_up === true)
            {
                // Изменения сохранены
                $this->session->set_tempdata('message', 10, 60);
            }
            else
            {
                // Изменения не сохранены
                $this->session->set_tempdata('message', 158, 60);
            }

            header('Location: /administration/meal/' . $meal_id);
        }

        $result = array_merge($meal, $types);

        // Объединенные данные страница
        $this->page_data['title'] = 'АП - Редактирование данных блюда';
        $this->page_data['page_menu']    = 'a_courses_n';
        $this->page_data['page_submenu'] = 'meals';

        $this->load->view('header/header_admin', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('meals/meal_settings', $result);
        $this->load->view('footer/footer');
    }

    /**
     * Список типов блюд
     */
    public function mealsTypes()
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3 or $this->session->user['blocked'] == 1)
        {
            parent::pageNotFound($this->page_url);
        }

        $result = $this->Course_model->getMealsTypes();

        // Объединенные данные страница
        $this->page_data['title'] = 'АП - Типы блюд';
        $this->page_data['page_menu']    = 'a_courses_n';
        $this->page_data['page_submenu'] = 'meals_types';

        $this->load->view('header/header_admin', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('meals/meals_types', $result);
        $this->load->view('footer/footer');
    }

    /**
     * Добавление нового типа блюда
     */
    public function newMealsType()
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3 or $this->session->user['blocked'] == 1)
        {
            parent::pageNotFound($this->page_url);
        }

        if($this->input->post('bt_save_new_meal_type', true))
        {
            $name = mb_substr(strip_tags($this->input->post('i_name', true)), 0, 255);

            if(!empty($name))
            {
                $res_ins = $this->Course_model->setNewMealsType($name, $this->user_id, $this->date);

                if (is_numeric($res_ins))
                {
                    // Изменения сохранены
                    $this->session->set_tempdata('message', 10, 60);

                    header('Location: /administration/meals/type/' . $res_ins);
                }
                else
                {
                    // Изменения не сохранены
                    $this->session->set_tempdata('message', 157, 60);

                    header('Location: /administration/meals/type/new');
                }
            }
            else
            {
                // Изменения не сохранены
                $this->session->set_tempdata('message', 157, 60);

                header('Location: /administration/meals/type/new');
            }
        }

        // Объединенные данные страница
        $this->page_data['title'] = 'АП - Новый тип блюда';
        $this->page_data['page_menu']    = 'a_courses_n';
        $this->page_data['page_submenu'] = 'meals_types';

        $this->load->view('header/header_admin', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('meals/new_meals_type');
        $this->load->view('footer/footer');
    }

    /**
     * Форма редактирования данных типа блюда
     *
     * @param $type_id
     */
    public function mealsType($type_id)
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3 or $this->session->user['blocked'] == 1)
        {
            parent::pageNotFound($this->page_url);
        }

        if($this->input->post('bt_save_meals_type', true) and is_numeric($type_id))
        {
            $name = mb_substr(strip_tags($this->input->post('i_name', true)), 0, 255);

            if(!empty($name))
            {
                $res_up = $this->Course_model->updateMealsType($type_id, $name, $this->user_id, $this->date);

                if ($res_up === true)
                {
                    // Изменения сохранены
                    $this->session->set_tempdata('message', 10, 60);
                }
                else
                {
                    // Изменения не сохранены
                    $this->session->set_tempdata('message', 157, 60);
                }
            }
            else
            {
                // Изменения не сохранены
                $this->session->set_tempdata('message', 157, 60);
            }

            header('Location: /administration/meals/type/' . $type_id);
        }
        elseif($this->input->post('bt_block_meals_type', true) and is_numeric($type_id))
        {
            $res_up = $this->Course_model->blockMealsType($type_id, 1, $this->user_id, $this->date);

            if ($res_up === true)
            {
                // Изменения сохранены
                $this->session->set_tempdata('message', 10, 60);
            }
            else
            {
                // Изменения не сохранены
                $this->session->set_tempdata('message', 157, 60);
            }

            header('Location: /administration/meals/type/' . $type_id);
        }
        elseif($this->input->post('bt_unblock_meals_type', true) and is_numeric($type_id))
        {
            $res_up = $this->Course_model->blockMealsType($type_id, 0, $this->user_id, $this->date);

            if ($res_up === true)
            {
                // Изменения сохранены
                $this->session->set_tempdata('message', 10, 60);
            }
            else
            {
                // Изменения не сохранены
                $this->session->set_tempdata('message', 157, 60);
            }

            header('Location: /administration/meals/type/' . $type_id);
        }

        $result = $this->Course_model->getMealsType($type_id);

        // Объединенные данные страница
        $this->page_data['title'] = 'АП - Настройки типа блюда';
        $this->page_data['page_menu']    = 'a_courses_n';
        $this->page_data['page_submenu'] = 'meals_types';

        $this->load->view('header/header_admin', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('meals/meals_type_settings', $result);
        $this->load->view('footer/footer');
    }

    /**
     * Обработка данные из файла Excel
     *
     * @param $path
     * @param $file
     * @return mixed
     */
    protected function saveMealsFromXLS($path, $file)
    {
        $xlsData = self::getXLS($path.$file); // Извлекаем данные из XLS
        $count_rows = count($xlsData);

        if($count_rows > 500){
            $count_rows = 500;
        }

        $result['count_rows'] = $count_rows;
        //print_r($xlsData); echo '<br/>';
        for($i = 1; $i <= $count_rows-1; $i++)
        {
            //echo '<tr><td>'.$xlsData[$i][0].'</td><td>'.$xlsData[$i][1].'</td><td>'.$xlsData[$i][2].'</td><td>'.$xlsData[$i][3].'</td><td>'.$xlsData[$i][4].'</td></tr>';
            $name =  mb_substr(stripslashes(strip_tags($xlsData[$i][2])), 0, 255);
            if(!empty($name))
            {
                // Номер изображения
                $result['meals'][$i]['image'] = is_numeric($xlsData[$i][0]) ? $xlsData[$i][0] : '';
                // Тип
                $result['meals'][$i]['type'] = mb_substr(stripslashes(strip_tags($xlsData[$i][1])), 0, 255);
                // Наименование
                $result['meals'][$i]['name'] = $name;
                // Описание
                $result['meals'][$i]['description'] = mb_substr(stripslashes(strip_tags($xlsData[$i][4])), 0, 2000);
                // Игредиенты
                $result['meals'][$i]['ingredients'] = mb_substr(stripslashes(strip_tags($xlsData[$i][5])), 0, 2000);
                // Вес
                $result['meals'][$i]['weight'] = is_numeric($xlsData[$i][6]) ? $xlsData[$i][6] : 0;
                // Калорийность
                $result['meals'][$i]['calories'] = is_numeric($xlsData[$i][7]) ? $xlsData[$i][7] : 0;
                // Белки
                $result['meals'][$i]['proteins'] = is_numeric($xlsData[$i][8]) ? $xlsData[$i][8] : 0;
                // Жиры
                $result['meals'][$i]['fats'] = is_numeric($xlsData[$i][9]) ? $xlsData[$i][9] : 0;
                // Углеводы
                $result['meals'][$i]['carbohydrates'] = is_numeric($xlsData[$i][10]) ? $xlsData[$i][10] : 0;
            }
        }
        //print_r($result); echo '<br/>';
        return $result;
    }

    /**
     * Загрузка данные из файла Excel
     *
     * @param $xls
     * @return array
     */
    protected function getXLS($xls)
    {
        $this->load->library("excel");
        $this->excel->load($xls);

        $this->excel->setActiveSheetIndex(0);
        $aSheet = $this->excel->getActiveSheet();

        //этот массив будет содержать массивы содержащие в себе значения ячеек каждой строки
        $array = array();
        //получим итератор строки и пройдемся по нему циклом
        foreach($aSheet->getRowIterator() as $row){
            //получим итератор ячеек текущей строки
            $cellIterator = $row->getCellIterator();
            //пройдемся циклом по ячейкам строки
            //этот массив будет содержать значения каждой отдельной строки
            $item = array();
            foreach($cellIterator as $cell){
                //заносим значения ячеек одной строки в отдельный массив
                //array_push($item, iconv('cp1251', 'utf-8', $cell->getCalculatedValue()));
                array_push($item, $cell->getCalculatedValue());
            }
            //заносим массив со значениями ячеек отдельной строки в "общий массв строк"
            array_push($array, $item);
        }
        return $array;
    }

    /* БЛОК ФУНКЦИЙ КАТЕГОРИЙ ПРИЕМОВ ПИЩИ */

    /**
     * Вывод последних сохраненных приемов пищи
     *
     * @return void
     */
    public function ingestions()
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3 or $this->session->user['blocked'] == 1) {
            parent::pageNotFound($this->page_url);
        }

        // Получение данных о типах курсов
        $result = $this->Course_model->getIngestions();

        // Объединенные данные страница
        $this->page_data['title'] = 'АП - Приемы пищи';
        $this->page_data['page_menu']    = 'a_courses_n';
        $this->page_data['page_submenu'] = 'ingestions';

        $this->load->view('header/header_admin', $this->page_data);
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
        if (empty($this->user_id) or $this->session->user['type'] != 3 or $this->session->user['blocked'] == 1) {
            parent::pageNotFound($this->page_url);
        }

        // Сохранение нового типа приемов пищи
        if ($this->input->post('bt_save_new_ingestion', true))
        {
            $name = mb_substr(strip_tags($this->input->post('i_name', true)), 0, 255);

            // Диапазон времени
            $tmp_from  = DateTime::createFromFormat('H:i', $this->input->post('s_ing_time_from', true));
            $time_from = ($tmp_from !== false) ? $this->input->post('s_ing_time_from', true) : '';
            $tmp_to    = DateTime::createFromFormat('H:i', $this->input->post('s_ing_time_to', true));
            $time_to   = ($tmp_to !== false) ? $this->input->post('s_ing_time_to', true) : '';

            if (!empty($name))
            {
                $res_ins = $this->Course_model->setNewIngestion($name, $time_from, $time_to, $this->user_id, $this->date);

                if (is_numeric($res_ins))
                {
                    // Изменения сохранены
                    $this->session->set_tempdata('message', 10, 60);
                    header('Location: /administration/ingestion/'.$res_ins);
                }
                else
                {
                    // Изменения не сохранены
                    $this->session->set_tempdata('message', 26, 60);
                    header('Location: /administration/ingestion/new');
                }
            }
        }

        // Объединенные данные страница
        $this->page_data['title']        = 'АП - Добавление нового приема пищи';
        $this->page_data['page_menu']    = 'a_courses_n';
        $this->page_data['page_submenu'] = 'ingestions';

        $result = $this->Course_model->getIngestionTypes();

        $this->load->view('header/header_admin', $this->page_data);
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
        if (empty($this->user_id) or $this->session->user['type'] != 3 or $this->session->user['blocked'] == 1)
        {
            parent::pageNotFound($this->page_url);
        }

        // Сохранение изменений типа курса
        if ($this->input->post('bt_save_ingestion_settings', true) and is_numeric($ing_id))
        {
            $name = mb_substr(strip_tags($this->input->post('i_name', true)), 0, 255);

            // Диапазон времени
            $tmp_from  = DateTime::createFromFormat('H:i', $this->input->post('s_ing_time_from', true));
            $time_from = ($tmp_from !== false) ? $this->input->post('s_ing_time_from', true) : '';
            $tmp_to    = DateTime::createFromFormat('H:i', $this->input->post('s_ing_time_to', true));
            $time_to   = ($tmp_to !== false) ? $this->input->post('s_ing_time_to', true) : '';

            if (!empty($name))
            {
                $res_up = $this->Course_model->setIngestionSettings($ing_id, $name, $time_from, $time_to, $this->user_id, $this->date);

                if ($res_up === true)
                {
                    // Изменения сохранены
                    $this->session->set_tempdata('message', 10, 60);
                }
                else
                {
                    // Изменения не сохранены
                    $this->session->set_tempdata('message', 26, 60);
                }
            }

            header('Location: /administration/ingestion/' . $ing_id);
        }
        elseif($this->input->post('bt_block_ingestion', true) and is_numeric($ing_id))
        {
            $res_up = $this->Course_model->blockIngestion($ing_id, 1, $this->user_id, $this->date);

            if ($res_up === true)
            {
                // Изменения сохранены
                $this->session->set_tempdata('message', 10, 60);
            }
            else
            {
                // Изменения не сохранены
                $this->session->set_tempdata('message', 155, 60);
            }

            header('Location: /administration/ingestion/' . $ing_id);
        }
        elseif($this->input->post('bt_unblock_ingestion', true) and is_numeric($ing_id))
        {
            $res_up = $this->Course_model->blockIngestion($ing_id, 0, $this->user_id, $this->date);

            if ($res_up === true)
            {
                // Изменения сохранены
                $this->session->set_tempdata('message', 10, 60);
            }
            else
            {
                // Изменения не сохранены
                $this->session->set_tempdata('message', 156, 60);
            }

            header('Location: /administration/ingestion/' . $ing_id);
        }

        $ingestion = $this->Course_model->getIngestion($ing_id);

        // Объединенные данные страница
        $this->page_data['title']        = 'АП - Изменение данных приема пищи';
        $this->page_data['page_menu']    = 'a_courses_n';
        $this->page_data['page_submenu'] = 'ingestions';

        $this->load->view('header/header_admin', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('ingestion/ingestion_settings', $ingestion);
        $this->load->view('footer/footer');
    }


    /* БЛОК ФУНКЦИЙ ПРОМОКОДОВ */

    /**
     * Вывод списка промокодов курса
     *
     * @param $course_id
     * @param $course_type
     */
    protected function coursePromocodes($course_id, $course_type = 'workout')
    {
        $promocodes = $this->Course_model->getCoursePromocodes($course_id, $this->date);
        $course     = $this->Course_model->getShortCourse($course_id);

        $result = array_merge($promocodes, $course);

        $page_menu = ($course_type == 'workout') ? 'a_courses_w' : 'a_courses_n';

        // Объединенные данные страница
        $this->page_data['title']        = 'АП - Промокоды курса';
        $this->page_data['page_menu']    = $page_menu;
        $this->page_data['page_submenu'] = 'promocodes';
        $this->page_data['course_id']    = $course_id;

        $this->load->view('header/header_admin', $this->page_data);
        $this->load->view('header/admin');
        if($course_type == 'workout')
        {
            $this->load->view('course/settings/course', $result);
        }
        elseif($course_type == 'nutrition')
        {
            $this->load->view('course/nutritions/settings/course', $result);
        }
        $this->load->view('footer/footer');
    }

    /**
     * Форма добавления промокода курса
     *
     * @param $course_id
     * @param $course_type
     */
    protected function newCoursePromocode($course_id, $course_type = 'workout')
    {
        $course = $this->Course_model->getShortCourse($course_id);

        if($this->input->post('bt_save_new_promocode', true))
        {
            $path = ($course_type == 'workout') ? 'course' : 'nutrition';

            $category      = $this->input->post('s_category', true);
            $name          = $this->input->post('i_code_name', true);
            $desc          = $this->input->post('i_code_desc', true);
            $discount      = $this->input->post('i_code_discount', true);
            $validity_type = $this->input->post('s_pv_type', true);
            $date_start    = $this->input->post('i_validity_date_start', true);
            $date_end      = $this->input->post('i_validity_date_end', true);
            $use_type      = $this->input->post('s_ua_type', true);
            $ua_number     = $this->input->post('i_ua_number', true);
            $promocode     = $this->input->post('i_promocode', true);

            $res_ins = self::saveNewCoursePromocode($course_id, $category, $name, $desc, $discount, $validity_type,
                $date_start, $date_end, $use_type, $ua_number, $promocode);

            if (is_numeric($res_ins['promocode_id']) and $res_ins['error'] === false)
            {
                // Изменения сохранены
                $this->session->set_tempdata('message', 10, 60);
                header('Location: /administration/' . $path . '/' . $course_id . '/promocode/' . $res_ins['promocode_id']);
            }
            else
            {
                // Изменения не сохранены
                $this->session->set_tempdata('message', $res_ins['error'], 60);
                header('Location: /administration/' . $path . '/' . $course_id . '/promocode/new');
            }
        }

        $page_menu = ($course_type == 'workout') ? 'a_courses_w' : 'a_courses_n';

        // Объединенные данные страница
        $this->page_data['title']         = 'АП - Добавление промокода';
        $this->page_data['page_menu']     = $page_menu;
        $this->page_data['page_submenu']  = 'promocodes';
        $this->page_data['promocode_new'] = true;
        $this->page_data['course_id']     = $course_id;

        $this->load->view('header/header_admin', $this->page_data);
        $this->load->view('header/admin');
        if($course_type == 'workout')
        {
            $this->load->view('course/settings/course', $course);
        }
        elseif($course_type == 'nutrition')
        {
            $this->load->view('course/nutritions/settings/course', $course);
        }
        $this->load->view('footer/footer');
    }

    /**
     * Форма редактирования промокода курса
     *
     * @param $course_id
     * @param $promocode_id
     * @param $course_type
     */
    protected function coursePromocode($course_id, $promocode_id, $course_type = 'workout')
    {
        $promocode   = $this->Course_model->getCoursePromocode($course_id, $promocode_id, $this->date);
        $used_amount = $this->Course_model->getPromocodeUsedAmount($promocode_id);
        $course      = $this->Course_model->getShortCourse($course_id);

        $path    = ($course_type == 'workout') ? 'course' : 'nutrition';
        if($this->input->post('bt_save_promocode', true))
        {
            $db_data = $promocode['promocode'];

            $category = ($this->input->post('s_category', true) == 'extend') ? 'extend' : 'course';
            $name     = mb_substr(strip_tags($this->input->post('i_code_name', true)), 0, 255);
            $desc     = mb_substr(strip_tags($this->input->post('i_code_desc', true)), 0, 255);
            $discount = (is_numeric($this->input->post('i_code_discount', true))) ? $this->input->post('i_code_discount', true) : null;

            $validity_type = ($this->input->post('s_pv_type', true) == 'unlimited') ? 'unlimited' : 'date_range';
            $tmp_ds        = new DateTime($this->input->post('i_validity_date_start', true));
            $tmp_de        = new DateTime($this->input->post('i_validity_date_end', true));
            $pv_date_start = ($tmp_ds !== false and $validity_type == 'date_range') ? $tmp_ds->format('Y-m-d') : '';
            $pv_date_end   = ($tmp_de !== false and $validity_type == 'date_range') ? $tmp_de->format('Y-m-d') : '';

            $use_type  = ($this->input->post('s_ua_type', true) == 'unlimited') ? 'unlimited' : 'number';
            $ua_number = (is_numeric($this->input->post('i_ua_number', true)) and $use_type == 'number')
                ? $this->input->post('i_ua_number', true) : '';

            $generated_code = strtoupper(mb_substr(strip_tags($this->input->post('i_promocode', true)), 0, 25));

            if($category != $db_data['category'] or (!empty($discount) and $discount != $db_data['discount'])
                or (!empty($generated_code) and $generated_code != $db_data['code']) or $name != $db_data['name']
                or $desc != $db_data['description'] or $validity_type != $db_data['validity_type']
                or $pv_date_start != $db_data['pv_date_start'] or $pv_date_end != $db_data['pv_date_end']
                or $use_type != $db_data['use_type'] or $ua_number != $db_data['ua_number'])
            {
                $res_up = $this->Course_model->updatePromocode($promocode_id, $course_id, $category, $name, $desc, $discount,
                    $validity_type, $pv_date_start, $pv_date_end, $use_type, $ua_number, $generated_code, $this->user_id, $this->date);

                if ($res_up === true)
                {
                    // Изменения сохранены
                    $this->session->set_tempdata('message', 10, 60);
                }
                else
                {
                    // Изменения не сохранены
                    $this->session->set_tempdata('message', 145, 60);
                }
            }

            header('Location: /administration/' . $path . '/' . $course_id . '/promocode/' . $promocode_id);
        }
        elseif($this->input->post('bt_block_promocode', true))
        {
            $up_data = $this->Course_model->blockPromocode($promocode_id, $course_id, 1, $this->user_id, $this->date);

            if ($up_data === true)
            {
                // Изменения сохранены
                $this->session->set_tempdata('message', 147, 60);
            }
            else
            {
                // Изменения не сохранены
                $this->session->set_tempdata('message', 145, 60);
            }
            header('Location: /administration/' . $path . '/' . $course_id . '/promocode/' . $promocode_id);
        }
        elseif($this->input->post('bt_unblock_promocode', true))
        {
            $up_data = $this->Course_model->blockPromocode($promocode_id, $course_id, 0, $this->user_id, $this->date);

            if ($up_data === true)
            {
                // Изменения сохранены
                $this->session->set_tempdata('message', 148, 60);
            }
            else
            {
                // Изменения не сохранены
                $this->session->set_tempdata('message', 145, 60);
            }
            header('Location: /administration/' . $path . '/' . $course_id . '/promocode/' . $promocode_id);
        }

        $result = array_merge($promocode, $course, $used_amount);

        $page_menu = ($course_type == 'workout') ? 'a_courses_w' : 'a_courses_n';

        // Объединенные данные страница
        $this->page_data['title']        = 'АП - Редактирование промокода';
        $this->page_data['page_menu']    = $page_menu;
        $this->page_data['page_submenu'] = 'promocodes';
        $this->page_data['course_id']    = $course_id;

        $this->load->view('header/header_admin', $this->page_data);
        $this->load->view('header/admin');
        if($course_type == 'workout')
        {
            $this->load->view('course/settings/course', $result);
        }
        elseif($course_type == 'nutrition')
        {
            $this->load->view('course/nutritions/settings/course', $result);
        }
        $this->load->view('footer/footer');
    }

    /**
     * Сохранение нового промокода
     *
     * @param $course_id
     * @param $s_category
     * @param $i_code_name
     * @param $i_code_desc
     * @param $i_code_discount
     * @param $s_pv_type
     * @param $i_validity_date_start
     * @param $i_validity_date_end
     * @param $s_ua_type
     * @param $i_ua_number
     * @param $i_promocode
     * @return array
     */
    protected function saveNewCoursePromocode($course_id, $s_category, $i_code_name, $i_code_desc, $i_code_discount,
                                           $s_pv_type, $i_validity_date_start, $i_validity_date_end, $s_ua_type,
                                           $i_ua_number, $i_promocode)
    {
        $result = array('error' => false, 'promocode_id' => null);

        $category = ($s_category == 'extend') ? 'extend' : 'course';
        $name     = mb_substr(strip_tags($i_code_name), 0, 255);
        $desc     = mb_substr(strip_tags($i_code_desc), 0, 255);
        $discount = (is_numeric($i_code_discount)) ? $i_code_discount : null;

        $validity_type = ($s_pv_type == 'unlimited') ? 'unlimited' : 'date_range';
        $tmp_ds        = new DateTime($i_validity_date_start);
        $tmp_de        = new DateTime($i_validity_date_end);
        $pv_date_start = ($tmp_ds !== false and $validity_type == 'date_range') ? $tmp_ds->format('Y-m-d') : '';
        $pv_date_end   = ($tmp_de !== false and $validity_type == 'date_range') ? $tmp_de->format('Y-m-d') : '';

        $use_type  = ($s_ua_type == 'unlimited') ? 'unlimited' : 'number';
        $ua_number = (is_numeric($i_ua_number) and $use_type == 'number') ? $i_ua_number : '';

        $promocode = strtoupper(mb_substr(strip_tags($i_promocode), 0, 25));

        if(!empty($discount) and !empty($promocode))
        {
            $res_ins = $this->Course_model->setNewPromocode($course_id, $category, $name, $desc, $discount, $validity_type,
                $pv_date_start, $pv_date_end, $use_type, $ua_number, $promocode, $this->user_id, $this->date);

            if (is_numeric($res_ins))
            {
                $result['promocode_id'] = $res_ins;
            }
            else
            {
                $result['error'] = 145;
            }
        }
        else
        {
            $result['error'] = 146;
        }

        return $result;
    }


    /* БЛОК ФУНКЦИЙ КУРСОВ ПРОДЛЕНИЯ */

    /**
     * Вывод списка промокодов курса
     *
     * @param $course_id
     */
    protected function courseExtends($course_id)
    {
        $extends = $this->Course_model->getCourseExtends($course_id, $this->date);
        $course  = $this->Course_model->getShortCourse($course_id);
        $result = array_merge($extends, $course);

        // Объединенные данные страница
        $this->page_data['title']        = 'АП - Продление курса';
        $this->page_data['page_menu']    = 'a_courses_w';
        $this->page_data['page_submenu'] = 'extends';
        $this->page_data['course_id']    = $course_id;

        $this->load->view('header/header_admin', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('course/settings/course', $result);
        $this->load->view('footer/footer');
    }

    /**
     * Форма добавления промокода курса
     *
     * @param $course_id
     */
    protected function newCourseExtend($course_id)
    {
        $course         = $this->Course_model->getShortCourse($course_id);
        $courses_list   = $this->Course_model->getPotentiallyExtendCourses($course_id);
        $promocode_list = $this->Course_model->getCourseExtendPromocodes($course_id, $this->date);

        if($this->input->post('bt_save_new_extend', true))
        {
            $extend_crs_id = (is_numeric($this->input->post('s_extend_course', true))) ? $this->input->post('s_extend_course', true) : null;
            $weeks_after   = (is_numeric($this->input->post('i_weeks_after', true))) ? $this->input->post('i_weeks_after', true) : null;
            $promocode_id  = 0;

            $s_promocode = $this->input->post('s_promocode', true);
            if($s_promocode > 0)
            {
                $promocode_id  = $s_promocode;
            }
            elseif($s_promocode == 'new')
            {
                $category      = 'extend';
                $name          = $this->input->post('i_code_name', true);
                $desc          = $this->input->post('i_code_desc', true);
                $discount      = $this->input->post('i_code_discount', true);
                $validity_type = $this->input->post('s_pv_type', true);
                $date_start    = $this->input->post('i_validity_date_start', true);
                $date_end      = $this->input->post('i_validity_date_end', true);
                $use_type      = $this->input->post('s_ua_type', true);
                $ua_number     = $this->input->post('i_ua_number', true);
                $promocode     = $this->input->post('i_promocode', true);

                $res_ins = self::saveNewCoursePromocode($course_id, $category, $name, $desc, $discount, $validity_type,
                    $date_start, $date_end, $use_type, $ua_number, $promocode);

                if (is_numeric($res_ins['promocode_id']) and $res_ins['error'] === false)
                {
                    $promocode_id = $res_ins['promocode_id'];
                }
            }

            if(is_numeric($course_id) and !empty($extend_crs_id) and !empty($weeks_after))
            {
                $res_ins = $this->Course_model->setNewExtendCourse($course_id, $extend_crs_id, $promocode_id, $weeks_after,
                    $this->user_id, $this->date);

                if ($res_ins === true)
                {
                    // Изменения сохранены
                    $this->session->set_tempdata('message', 10, 60);
                    header('Location: /administration/course/' . $course_id . '/extend/' . $extend_crs_id);
                }
                else
                {
                    // Изменения не сохранены
                    $this->session->set_tempdata('message', 149, 60);
                    header('Location: /administration/course/' . $course_id . '/extend/new');
                }
            }
            else
            {
                // Изменения не сохранены
                $this->session->set_tempdata('message', 150, 60);
                header('Location: /administration/course/' . $course_id . '/extend/new');
            }
        }

        $result = array_merge($course, $courses_list, $promocode_list);

        // Объединенные данные страница
        $this->page_data['title']        = 'АП - Прикрепление курса продления';
        $this->page_data['page_menu']    = 'a_courses_w';
        $this->page_data['page_submenu'] = 'extends';
        $this->page_data['extend_new']   = true;
        $this->page_data['course_id']    = $course_id;

        $this->load->view('header/header_admin', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('course/settings/course', $result);
        $this->load->view('footer/footer');
    }

    /**
     * Форма редактирования промокода курса
     *
     * @param $course_id
     * @param $extend_id
     */
    protected function courseExtend($course_id, $extend_id)
    {
        $extend         = $this->Course_model->getCourseExtend($course_id, $extend_id, $this->date);
        $course         = $this->Course_model->getShortCourse($course_id);
        $courses_list   = $this->Course_model->getPotentiallyExtendCourses($course_id);
        $promocode_list = $this->Course_model->getCoursePromocodes($course_id, $this->date);

        if($this->input->post('bt_save_extend', true))
        {
            $db_data = $extend['extend'];

            $weeks_after   = is_numeric($this->input->post('i_weeks_after', true)) ? $this->input->post('i_weeks_after', true) : $db_data['weeks_after'];
            $promocode_id  = $db_data['promocode_id'];

            $s_promocode = $this->input->post('s_promocode', true);
            if($s_promocode > 0)
            {
                $promocode_id  = $s_promocode;
            }
            elseif($s_promocode == 'new')
            {
                $category      = 'extend';
                $name          = $this->input->post('i_code_name', true);
                $desc          = $this->input->post('i_code_desc', true);
                $discount      = $this->input->post('i_code_discount', true);
                $validity_type = $this->input->post('s_pv_type', true);
                $date_start    = $this->input->post('i_validity_date_start', true);
                $date_end      = $this->input->post('i_validity_date_end', true);
                $use_type      = $this->input->post('s_ua_type', true);
                $ua_number     = $this->input->post('i_ua_number', true);
                $promocode     = $this->input->post('i_promocode', true);

                $res_ins = self::saveNewCoursePromocode($course_id, $category, $name, $desc, $discount, $validity_type,
                    $date_start, $date_end, $use_type, $ua_number, $promocode);

                if (is_numeric($res_ins['promocode_id']) and $res_ins['error'] === false)
                {
                    $promocode_id = $res_ins['promocode_id'];
                }
            }

            if(is_numeric($course_id) and is_numeric($extend_id) and (($promocode_id != $db_data['promocode_id'])
                or (!empty($weeks_after) and $weeks_after != $db_data['weeks_after'])))
            {
                $res_up = $this->Course_model->updateExtendCourse($course_id, $extend_id, $promocode_id, $weeks_after,
                    $this->user_id, $this->date);

                if ($res_up === true)
                {
                    // Изменения сохранены
                    $this->session->set_tempdata('message', 10, 60);
                }
                else
                {
                    // Изменения не сохранены
                    $this->session->set_tempdata('message', 149, 60);
                }
            }
            else
            {
                // Изменения не сохранены
                $this->session->set_tempdata('message', 150, 60);
            }
            header('Location: /administration/course/' . $course_id . '/extend/' . $extend_id);
        }
        elseif($this->input->post('bt_block_extend', true))
        {
            $up_data = $this->Course_model->blockExtend($course_id, $extend_id, 1, $this->user_id, $this->date);

            if ($up_data === true)
            {
                // Изменения сохранены
                $this->session->set_tempdata('message', 151, 60);
            }
            else
            {
                // Изменения не сохранены
                $this->session->set_tempdata('message', 149, 60);
            }
            header('Location: /administration/course/' . $course_id . '/extend/' . $extend_id);
        }
        elseif($this->input->post('bt_unblock_extend', true))
        {
            $up_data = $this->Course_model->blockExtend($course_id, $extend_id, 0, $this->user_id, $this->date);

            if ($up_data === true)
            {
                // Изменения сохранены
                $this->session->set_tempdata('message', 152, 60);
            }
            else
            {
                // Изменения не сохранены
                $this->session->set_tempdata('message', 149, 60);
            }
            header('Location: /administration/course/' . $course_id . '/extend/' . $extend_id);
        }

        $result = array_merge($extend, $course, $courses_list, $promocode_list);

        // Объединенные данные страница
        $this->page_data['title']        = 'АП - Редактирование прикрепленного курса продления';
        $this->page_data['page_menu']    = 'a_courses_w';
        $this->page_data['page_submenu'] = 'extends';
        $this->page_data['course_id']    = $course_id;

        $this->load->view('header/header_admin', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('course/settings/course', $result);
        $this->load->view('footer/footer');
    }


    /* БЛОК ФУНКЦИЙ ПРИКРЕПЛЕННЫХ КУРСОВ ПИТАНИЯ */

    /**
     * Вывод списка промокодов курса
     *
     * @param $course_id
     */
    protected function courseAttachedCourses($course_id)
    {
        $extends = $this->Course_model->getCourseAttachedCourses($course_id, $this->date);
        $course  = $this->Course_model->getShortCourse($course_id);
        $result = array_merge($extends, $course);

        if($this->input->post('bt_block_attached', true))
        {
            $attached_id = is_numeric($this->input->post('i_course_id', true)) ? $this->input->post('i_course_id', true) : null;

            if(is_numeric($course_id) and !empty($attached_id))
            {
                $res_up = $this->Course_model->blockAttachedCourse($course_id, $attached_id, 1, $this->user_id, $this->date);

                if ($res_up === true)
                {
                    // Изменения сохранены
                    $this->session->set_tempdata('message', 10, 60);
                }
                else
                {
                    // Изменения не сохранены
                    $this->session->set_tempdata('message', 161, 60);
                }
            }
            header('Location: /administration/course/' . $course_id . '/attached');
        }
        elseif($this->input->post('bt_unblock_attached', true))
        {
            $attached_id = is_numeric($this->input->post('i_course_id', true)) ? $this->input->post('i_course_id', true) : null;

            if(is_numeric($course_id) and !empty($attached_id))
            {
                $res_up = $this->Course_model->blockAttachedCourse($course_id, $attached_id, 0, $this->user_id, $this->date);

                if ($res_up === true)
                {
                    // Изменения сохранены
                    $this->session->set_tempdata('message', 10, 60);
                }
                else
                {
                    // Изменения не сохранены
                    $this->session->set_tempdata('message', 162, 60);
                }
            }
            header('Location: /administration/course/' . $course_id . '/attached');
        }

        // Объединенные данные страница
        $this->page_data['title']        = 'АП - Прикрепленные курсы';
        $this->page_data['page_menu']    = 'a_courses_w';
        $this->page_data['page_submenu'] = 'attached';
        $this->page_data['course_id']    = $course_id;

        $this->load->view('header/header_admin', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('course/settings/course', $result);
        $this->load->view('footer/footer');
    }

    /**
     * Форма добавления промокода курса
     *
     * @param $course_id
     */
    protected function newCourseAttach($course_id)
    {
        $course         = $this->Course_model->getShortCourse($course_id);
        $courses_list   = $this->Course_model->getPotentiallyAttachedCourses($course_id);

        if($this->input->post('bt_attach_new_course', true))
        {
            $attach_crs_id = is_numeric($this->input->post('s_attach_course', true)) ? $this->input->post('s_attach_course', true) : null;

            if(is_numeric($course_id) and !empty($attach_crs_id))
            {
                $res_ins = $this->Course_model->attachNewCourse($course_id, $attach_crs_id, $this->user_id, $this->date);

                if ($res_ins === true)
                {
                    // Изменения сохранены
                    $this->session->set_tempdata('message', 10, 60);
                }
                else
                {
                    // Изменения не сохранены
                    $this->session->set_tempdata('message', 160, 60);
                }
            }
            else
            {
                // Изменения не сохранены
                $this->session->set_tempdata('message', 159, 60);
            }
            header('Location: /administration/course/' . $course_id . '/attach/new');
        }

        $result = array_merge($course, $courses_list);

        // Объединенные данные страница
        $this->page_data['title']        = 'АП - Прикрепление курса';
        $this->page_data['page_menu']    = 'a_courses_w';
        $this->page_data['page_submenu'] = 'attached';
        $this->page_data['attach_new']   = true;
        $this->page_data['course_id']    = $course_id;

        $this->load->view('header/header_admin', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('course/settings/course', $result);
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
        $this->page_data['title']       = $this->page_data['metadata'][5]['title'];
        $this->page_data['keywords']    = $this->page_data['metadata'][5]['keywords'];
        $this->page_data['description'] = $this->page_data['metadata'][5]['description'];
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
     * @param string $courses_type Активные или завершенные курсы (active|finished)
     * @return void
     */
    public function usersCourses($courses_type = 'active')
    {
        if (!is_numeric($this->user_id)) {
            parent::pageNotFound($this->page_url);
        }

        // Страница пользователя или администратора
        if ($this->session->user['type'] != 2 and $this->session->user['blocked'] == 0)
        {
            self::userCourses($courses_type);
        }
        // Страница тренера
        elseif ($this->session->user['type'] == 2 and $this->session->user['blocked'] == 0)
        {
            self::couchCourses();
        }
        else
        {
            parent::pageNotFound($this->page_url);
        }
    }

    /**
     * Курсы пользователя
     *
     * @param string $courses_type Активные или завершенные курсы (active|finished)
     * @return void
     */
    protected function userCourses($courses_type)
    {
        $courses_type = ($courses_type == 'finished') ? 'finished' : 'active';
        $course_data = $this->Course_model->getUserCourses($this->user_id, $this->date, $courses_type);

        //$this->Course_model->setNewUserCourse(25, 12, 4, '', '', '', '', $this->date);
        //$this->Course_model->setUserNutritionSchedule(12, 34, '2018-07-12', $this->date);
        //$csch = $this->Course_model->getFillNutritionSchedule(12);

        // Даты начала и окончания курса
        // Количество тренировок за курс
        /*$count_workouts = 2 * 7;

        $start_date = $this->date;

        $tmp_date = new DateTime($this->date);
        $tmp_date->add(new DateInterval("P" . $count_workouts . "D"));
        $end_date = ($tmp_date !== false) ? $tmp_date->format('Y-m-d') : '';

        $this->Course_model->setNewUserCourse(24, 14, 4, $start_date, $end_date, '', '', $this->date);*/

        // Объединенные данные страница
        $this->page_data['title']        = 'Мои курсы';
        $this->page_data['page_menu']    = 'u_courses';
        $this->page_data['page_submenu'] = $courses_type;

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
     *
     * @return void
     * @throws Exception
     */
    public function usersCourse($course_id)
    {
        if (!is_numeric($this->user_id)) {
            parent::pageNotFound($this->page_url);
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
     *
     * @return void
     * @throws Exception
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

        // Данные курса пользователя
        $course_data   = $this->Course_model->getUserCourseSettings($course_id, $this->user_id, $this->date);

        // Остаточная стоимость курса
        if($course_data['course']['blocked_buy'] === true)
        {
            $this->load->model('Payment_model');
            $this->load->model('Store_model');
            // Стоимость покупки курса
            $bought_price = $this->Store_model->getOrderCoursePrice($course_data['course']['order_id'], $course_id, $this->user_id);

            // Остаточная стоимость курса
            $value = $this->Payment_model->getCourseResidualValue($course_data['course']['order_id'], $course_id, $this->user_id, $bought_price, $this->date);

            $course_data['course']['residual_value'] = $value;
        }
        //$course_data = '';
        // Выборка уведомлений курса пользователя
        $course_notifs = $this->Course_model->getUserCourseNotifications($course_id, $this->user_id, $this->date);
        if (empty($course_data))
        {
            parent::pageNotFound($this->page_url);
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

                            break;
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
                $update_all_workouts = false; // Во всех ли тренировках обновлять дату (по умолчанию: нет)
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
            if (!empty($array_training_days) and empty($db_training_days) and !empty($new_course_start) and !empty($new_course_end))
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

            if ($result_td === true and $result_sp === true)
            {
                // Изменения сохранены
                $this->session->set_tempdata('message', 10, 60);
            }
            else
            {
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
        elseif ($this->input->post('bt_buy_residual_course', true) and $course_data['course']['blocked_buy'] === true
            and $course_data['course']['residual_value'] > 0)
        {
            // Вариант оплаты (полный)
            $payment_option = 'full_payment';

            // Способ оплаты
            $methods      = array('bank_card', 'yandex_money', 'sberbank', 'qiwi', 'webmoney', 'alfabank');
            $payment_type = (in_array($this->input->post('s_payment_method', true), $methods) and $payment_option == 'full_payment')
                ? $this->input->post('s_payment_method', true)
                : 'bank_card';

            $phone_methods = array('qiwi', 'sberbank');
            $login_methods = array('alfabank');
            // Данные для способа оплаты
            $phone        = is_numeric($this->input->post('i_phone', true)) ? $this->input->post('i_phone', true) : null;
            $method_phone = (in_array($payment_type, $phone_methods)) ? $phone : null;
            $login        = strip_tags($this->input->post('i_login', true));
            $method_login = (in_array($payment_type, $login_methods)) ? $login : null;

            // Остаточная стоимость курса
            $course_price = $course_data['course']['residual_value'];

            if (is_numeric($course_data['course']['order_id']))
            {
                $payment_data = array(
                    'oid' => $course_data['course']['order_id'],
                    'amount' => $course_price,
                    'type' => $payment_type,
                    'option' => $payment_option,
                    'phone' => $method_phone,
                    'login' => $method_login,
                );

                header('Location: /payment?' .http_build_query($payment_data));

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
                header('Location: /course/' . $course_id . '?ref=1');
            }

            /*// Курс куплен (добавлен)
            $this->session->set_tempdata('message', 109, 60);
            header('Location: /profile/course/'.$course_id);*/

        }
        elseif($this->input->post('bt_choose_attach'))
        {
            $id_choosen_course = key($this->input->post('bt_choose_attach'));

            $res_attach = $this->Course_model->attachUserCourse($course_id, $id_choosen_course, $this->user_id, $this->date);

            if($res_attach === true)
            {
                // Изменения сохранены
                $this->session->set_tempdata('message', 10, 60);
            }
            else
            {
                // Изменения не сохранены
                $this->session->set_tempdata('message', 56, 60);
            }

            header('Location: /profile/course/' . $course_id);
        }

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
                        $this->load->model('Notification_model');
                        $notification = $this->Notification_model->getNotification($code);
                        $pattern = '/\[date_attempts\]/';
                        $replacement = $notif['date_attempts'];

                        $this->page_data['course_notification'][$user_course_id]['course_blocked']['text'] = preg_replace($pattern, $replacement, $notification['notification']['text']);
                    }

                    // Завершение курса
                    if(is_numeric($code) and $code == 143)
                    {
                        $this->load->model('Notification_model');
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
                        $this->load->model('Notification_model');
                        $notification = $this->Notification_model->getNotification($code);

                        $this->page_data['course_notification'][$user_course_id]['course_finished']['text']    = $notification['notification']['text'];
                        $this->page_data['course_notification'][$user_course_id]['course_finished']['extends'] = $notif['extends'];
                    }
                }
            }
            unset($course_notif);
        }

        // Объединенные данные страница
        $this->page_data['title']             = 'Курс';
        $this->page_data['page_menu']         = 'u_courses';
        $this->page_data['page_submenu']      = 'settings';
        $this->page_data['calendar_min_date'] = $calendar_min_date;
        $this->page_data['calendar_max_date'] = $calendar_max_date;
        $this->page_data['string_min_date']   = $string_min_date;
        $this->page_data['string_max_date']   = $string_max_date;

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
     * @param $user_course_id
     */
    public function userCourseReviews($user_course_id)
    {
        if (!is_numeric($this->user_id))
        {
            parent::pageNotFound($this->page_url);
        }

        // Данные курса
        $course_data = $this->Course_model->getUserCourseSettings($user_course_id, $this->user_id);
        $reviews     = $this->Course_model->getUserCourseReviews($user_course_id, $this->user_id);

        // Сохранение отзыва
        if ($this->input->post('bt_save_review', true))
        {
            $review_text = mb_substr(strip_tags($this->input->post('ta_review_text', true)), 0, 1000);

            if (!empty($review_text))
            {
                $res_review = $this->Course_model->setUserCourseReview($course_data['course']['course_id'], $this->user_id, $review_text, $this->date);

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

            header('Location: /profile/course/' . $user_course_id . '/reviews');
        }

        $result      = array_merge($course_data, $reviews);

        // Объединенные данные страница
        $this->page_data['title']        = 'Мои курсы';
        $this->page_data['page_menu']    = 'u_courses';
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
            parent::pageNotFound($this->page_url);
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
     * Страница меню курса питания на неделю
     *
     * @param $user_course_id
     */
    public function userNutritionMenu($user_course_id)
    {
        if (!is_numeric($this->user_id)) {
            parent::pageNotFound($this->page_url);
        }

        $course_data = $this->Course_model->getUserCourseSettings($user_course_id, $this->user_id);
        $menu        = $this->Course_model->getUserNutritionMenu($user_course_id, $this->user_id, $this->date);
        $result      = array_merge($course_data, $menu);

        // Объединенные данные страница
        $this->page_data['title']        = 'Меню курса';
        $this->page_data['page_menu']    = 'u_courses';
        $this->page_data['page_submenu'] = 'menu';

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/profile');
        $this->load->view('user/profile_line');
        $this->load->view('course/user_course/user_week_menu', $result);
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
        if (empty($this->user_id) or $this->session->user['type'] != 3 or $this->session->user['blocked'] == 1) {
            parent::pageNotFound($this->page_url);
        }

        $this->load->model('User_model');

        $result['course_id']    = $course_id;
        $result['course_users'] = $this->Course_model->getCourseUsers($course_id);

        // Объединенные данные страница
        $this->page_data['title'] = 'АП - Активность клиентов';
        $this->page_data['page_menu'] = 'courses';
        $this->page_data['page_submenu'] = 'activity';

        $this->load->view('header/header_admin', $this->page_data);
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
        if (empty($this->user_id) or $this->session->user['type'] != 3 or $this->session->user['blocked'] == 1) {
            parent::pageNotFound($this->page_url);
        }

        $this->load->model('User_model');

        $result['course_id']       = $course_id;
        $result['course_users']    = $this->Course_model->getCourseUsers($course_id);
        $result['course_users_id'] = $this->Course_model->getCourseUsersId($course_id);

        if (!empty($user_id) and in_array($user_id, $result['course_users_id']['id']))
        {
            $user_data        = $this->User_model->getUser($user_id);
            $last_anthop_data = $this->User_model->getLastAnthropometricData($user_id);
            $all_anthop_data  = $this->User_model->getAnthropometricData($user_id);
            
            $result = array_merge($result, $last_anthop_data, $all_anthop_data, $user_data);
        }

        // Объединенные данные страница
        $this->page_data['title'] = 'АП - Активность клиентов';
        $this->page_data['page_menu'] = 'courses';
        $this->page_data['page_submenu'] = 'activity';

        $this->load->view('header/header_admin', $this->page_data);
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
     * @throws Exception
     */
    public function publicCourse($course_id)
    {
        // Выборка данных курса
        $course         = $this->Course_model->getAvailableCourse($course_id, $this->date);
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
            $db_data = $course['course'];

            // Количество тренировок за курс
            $count_workouts = $db_data['count_weeks'] * $db_data['count_days'];

            // Выбранный тренер
            $id_couch   = $this->input->post('user_couch', true);
            $user_couch = (is_numeric($id_couch) and in_array($id_couch, $course_couches['id'])) ? $id_couch : '';

            // Тренировочные дни
            $training_days = '';
            /*if (!empty($this->input->post('cb_day'))) {
                $days = $this->input->post('cb_day');
                $i = 1;
                foreach ($days as $day) {
                    if ($i <= $db_data['count_days']) {
                        $training_days .= $day;
                    }

                    $i++;
                }
                unset($day);
            }*/

            // Даты начала и окончания курса
            $start_date = '';
            $end_date   = '';
            if($db_data['category'] == 'nutrition')
            {
                $start_date = $this->date;

                $tmp_date = new DateTime($this->date);
                $tmp_date->add(new DateInterval("P" . $count_workouts . "D"));
                $end_date = ($tmp_date !== false) ? $tmp_date->format('Y-m-d') : '';
            }
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
            $payment_option = (in_array($this->input->post('s_payment_options', true), $options))
                ? $this->input->post('s_payment_options', true)
                : 'full_payment';

            // Способ оплаты
            $methods      = array('bank_card', 'yandex_money', 'sberbank', 'qiwi', 'webmoney', 'alfabank');
            $payment_type = (in_array($this->input->post('s_payment_method', true), $methods) and $payment_option == 'full_payment')
                ? $this->input->post('s_payment_method', true)
                : 'bank_card';

            // Данные для способа оплаты
            $phone_methods = array('qiwi', 'sberbank');
            $login_methods = array('alfabank');
            $phone        = is_numeric($this->input->post('i_phone', true)) ? $this->input->post('i_phone', true) : null;
            $method_phone = (in_array($payment_type, $phone_methods)) ? $phone : null;
            $login        = strip_tags($this->input->post('i_login', true));
            $method_login = (in_array($payment_type, $login_methods)) ? $login : null;

            // Стоимость курса в зависимости от варианта оплаты и доступности такой оплаты в настройка курса
            if($payment_option == 'installments' and $db_data['recurrent'] === true)
            {
                $course_price = $db_data['db_recur_first'];
            }
            else
            {
                $course_price = $db_data['db_price'];
            }

            // Проверка данных пользователя
            $user_id = null;
            $email   = null;
            if(is_numeric($this->user_id))
            {
                $user_id = $this->user_id;
                $email   = $this->session->user['email'];
            }
            else
            {
                $email = (filter_var($this->input->post('email', true), FILTER_VALIDATE_EMAIL)) ? $this->input->post('email', true) : null;
            }

            // Если пользователь не авторизован, проверяем введенный им email (нет в БД - регистрация)
            if (empty($user_id) and !empty($email))
            {
                $user_id = parent::checkEmail($email);
            }
            elseif(empty($user_id) and empty($email))
            {
                // Некорректный email
                $this->session->set_tempdata('message', 6, 60);
            }

            if(!empty($user_id))
            {
                // Введенный промокод
                $i_promocode  = mb_substr(strip_tags($this->input->post('promocode', true)), 0, 25);
                $promocode_id = '';
                // Проверка промокода
                if(!empty($i_promocode) and $payment_option == 'full_payment')
                {
                    $promocode = $this->Course_model->getAvailableCoursePromocode($course_id, $i_promocode, $user_id, $this->date);

                    // Вычислеие цены со скидкой
                    if($promocode['discount'] !== false and !empty($promocode['id']))
                    {
                        $course_price = $db_data['db_price'] - ($db_data['db_price']*$promocode['discount']/100);
                        $promocode_id = $promocode['id'];
                    }
                }

                // Добавление товара в заказы пользователя
                $this->load->model('Store_model');

                $products['products'] = array( 0 => array(
                    'id' => $db_data['p_id'],
                    'cart_quantity' => 1,
                    'price' => $course_price,
                    'fc_price' => '',
                    'discount_price' => '',
                    'discount_fc_price' => '',
                    'promo_id' => $promocode_id,
                    'promo_code' => $i_promocode)
                );

                $prev_address = '';
                $name = '';
                $surname = '';
                $code = '';
                $phone = '';
                $country = '';
                $city = '';
                $street = '';
                $building = '';
                $house = '';
                $postcode = '';
                $delivery = '';

                $res_order = $this->Store_model->setOrder($user_id, $prev_address, $name, $surname, $email, $code, $phone,
                    $country, $city, $street, $building, $house, $postcode, $delivery, $products, $this->date);

                if ($res_order !== false and is_numeric($res_order['order_id']))
                {
                    // Кол-во товаров в корзине
                    parent::updateSessionCart(0);

                    $payment_data = array(
                        'oid' => $res_order['order_id'],
                        'amount' => $res_order['total_amount'],
                        'type' => $payment_type,
                        'option' => $payment_option,
                        'phone' => $method_phone,
                        'login' => $method_login,
                    );

                    header('Location: /payment?' .http_build_query($payment_data));

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
                    header('Location: /course/' . $course_id . '?ref=1');
                }

            }
            else
            {
                // Пользователь не авторизован
                $this->session->set_tempdata('message', 5, 60);
                header('Location: /course/' . $course_id . '?ref=1');
            }

            /*// Курс куплен (добавлен)
            $this->session->set_tempdata('message', 109, 60);
            header('Location: /profile/course/'.$course_id);*/

        }
        elseif($this->input->post('bt_facebook_login', true) and $this->input->post('cb_politics', true))
        {
            $email = (filter_var($this->input->post('email', true), FILTER_VALIDATE_EMAIL)) ? $this->input->post('email', true) : '';
            $return = $this->input->post('hi_return', true);

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, "https://superbody.pro/facebook_login");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, array(
                'bt_facebook_login' => $this->input->post('bt_facebook_login', true),
                'email' => $email,
                'hi_return' => $return));

            //curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_exec ($ch);
            curl_close ($ch);
        }
        elseif($this->input->post('bt_ok_login', true) and $this->input->post('cb_politics', true))
        {
            $email = (filter_var($this->input->post('email', true), FILTER_VALIDATE_EMAIL)) ? $this->input->post('email', true) : '';
            $return = $this->input->post('hi_return', true);

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, "https://superbody.pro/ok_login");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, array(
                'bt_ok_login' => $this->input->post('bt_ok_login', true),
                'email' => $email,
                'hi_return' => $return));

            //curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_exec ($ch);
            curl_close ($ch);
        }
        elseif($this->input->post('bt_vk_login', true) and $this->input->post('cb_politics', true))
        {
            $email = (filter_var($this->input->post('email', true), FILTER_VALIDATE_EMAIL)) ? $this->input->post('email', true) : '';
            $return = $this->input->post('hi_return', true);

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, "https://superbody.pro/vk_login");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, array(
                'bt_vk_login' => $this->input->post('bt_vk_login', true),
                'email' => $email,
                'hi_return' => $return));

            //curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_exec ($ch);
            curl_close ($ch);
        }
        elseif($this->input->post('bt_insta_login', true) and $this->input->post('cb_politics', true))
        {
            $email = (filter_var($this->input->post('email', true), FILTER_VALIDATE_EMAIL)) ? $this->input->post('email', true) : '';
            $return = $this->input->post('hi_return', true);

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, "https://superbody.pro/instagram_login");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, array(
                'bt_insta_login' => $this->input->post('bt_insta_login', true),
                'email' => $email,
                'hi_return' => $return));

            //curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_exec ($ch);
            curl_close ($ch);
        }

        // Объединенные данные страница
        $this->page_data['title']       = (!empty($course['course']['name'])) ? $course['course']['name'] : 'Курс №' . $course_id;
        $this->page_data['description'] = $course['course']['meta_description'];
        $this->page_data['keywords']    = $course['course']['meta_keywords'];
        $this->page_data['page_menu']   = 'courses';
        $this->page_data['course_id']   = $course_id;
        $this->page_data['purchase_up'] = ($this->input->get('ref', true)) ? true : false;

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
        if (empty($this->user_id) or $this->session->user['type'] != 3 or $this->session->user['blocked'] == 1) {
            parent::pageNotFound($this->page_url);
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

    /* БЛОК ФУНКЦИЙ ПРИЕМОВ ПИЩИ ПОЛЬЗОВАТЕЛЕЙ */

    public function userMeals()
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3 or $this->session->user['blocked'] == 1) {
            parent::pageNotFound($this->page_url);
        }

        $user_bmr = $this->User_model->getUserBMR($this->user_id);
        $meals_last_week = $this->Course_model->getLastWeekMeals($this->user_id, $this->date);
        $result = array_merge($user_bmr, $meals_last_week);

        // Объединенные данные страница
        $this->page_data['title']             = 'Питание';
        $this->page_data['page_menu']         = 'u_meals';
        $this->page_data['page_submenu']      = '';

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/profile');
        $this->load->view('user/profile_line');
        $this->load->view('meals/user/user_meals', $result);
        $this->load->view('footer/footer');
    }

    /* КОНЕЦ БЛОКА ФУНКЦИЙ ПРИЕМОВ ПИЩИ ПОЛЬЗОВАТЕЛЕЙ */

    /* КОНЕЦ БЛОКА ФУНКЦИЙ КУРСОВ */


    /**
     * Загрузка видео
     *
     * @return void
     */
    public function uploadVideo()
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3 or $this->session->user['blocked'] == 1) {
            parent::pageNotFound($this->page_url);
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
        if (empty($this->user_id) or $this->session->user['type'] != 3 or $this->session->user['blocked'] == 1)
        {
            parent::pageNotFound($this->page_url);
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
        if (empty($this->user_id) or $this->session->user['type'] != 3 or $this->session->user['blocked'] == 1)
        {
            parent::pageNotFound($this->page_url);
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
        if (empty($this->user_id) or $this->session->user['type'] != 3 or $this->session->user['blocked'] == 1)
        {
            parent::pageNotFound($this->page_url);
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
        if (empty($this->user_id) or $this->session->user['type'] != 3 or $this->session->user['blocked'] == 1)
        {
            parent::pageNotFound($this->page_url);
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

                    $display_result = array(
                        "done" => $workout_done,
                        "description" => $workout_description,
                        "video" => $workout_video,
                        "player" => $v_player,
                        "i_a" => $workout_instruction_a,
                        "i_video" => $workout_instruction,
                        "i_player" => $i_player
                    );

                    echo json_encode($display_result, JSON_NUMERIC_CHECK);
                }
                else
                {
                    $display_result['error'] = 'Video data error';
                    echo json_encode($display_result, JSON_NUMERIC_CHECK);
                }
            }
            else
            {
                $display_result['error'] = 'User course data error';
                echo json_encode($display_result, JSON_NUMERIC_CHECK);
            }
        }
        else
        {
            $display_result['error'] = 'Video ID empty';
            echo json_encode($display_result, JSON_NUMERIC_CHECK);
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
            parent::pageNotFound($this->page_url);
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

    /**
     * AJAX Выборка таблицы тренировок курса
     */
    public function showCourseWeeks()
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3 or $this->session->user['blocked'] == 1)
        {
            parent::pageNotFound($this->page_url);
        }

        $result['crs_sch'] = false;
        $course_id         = (is_numeric($this->input->post('crs_id', true))) ? $this->input->post('crs_id', true) : null;
        $video_id          = (is_numeric($this->input->post('vd_id', true))) ? $this->input->post('vd_id', true) : null;

        if(!empty($course_id))
        {
            $schedules = $this->Course_model->getCourseSchedules($course_id);

            if(!empty($schedules))
            {
                $course = $schedules['course_length'];
                $course['workouts'] = $schedules['workouts'];
                $video['id'] = $video_id;

                ob_start();
                    include_once('./app_fold/views/course/settings/course_length_multiple.php');
                    $weeks = ob_get_contents();
                ob_end_clean();

                $result['crs_sch'] = $weeks;
            }
        }

        echo json_encode($result, JSON_NUMERIC_CHECK);
    }

    /**
     * AJAX Поиск промокода курса
     */
    public function searchCoursePromocode()
    {
        $result['discount'] = false;

        $promocode = mb_substr(strip_tags($this->input->post('input_search', true)), 0, 25);
        $course_id = is_numeric($this->input->post('crs_id', true)) ? $this->input->post('crs_id', true) : null;

        if(!empty($course_id) and !empty($promocode) and strlen($promocode) >=6 and is_numeric($this->user_id))
        {
            $result = $this->Course_model->getAvailableCoursePromocode($course_id, $promocode, $this->user_id, $this->date);
        }

        echo json_encode($result, JSON_NUMERIC_CHECK);
    }

    /**
     * AJAX. Поиск блюд
     */
    public function searchMeals()
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3 or $this->session->user['blocked'] == 1)
        {
            parent::pageNotFound($this->page_url);
        }

        $result['meals'] = false;

        $search_text   = mb_substr(strip_tags($this->input->post('search_text', true)), 0, 255);
        $crs_day       = is_numeric($this->input->post('crs_day', true)) ? $this->input->post('crs_day', true) : null;
        $crs_ingestion = is_numeric($this->input->post('crs_ingestion', true)) ? $this->input->post('crs_ingestion', true) : null;

        if(empty($crs_day))
        {
            $crs_day = ($this->input->post('crs_day', true) == 'multiple') ? 'multiple' : null;
        }

        if (!empty($search_text) and !empty($crs_day) and !empty($crs_ingestion))
        {
            $result['meals'] = $this->Course_model->searchMeals($search_text, $crs_day, $crs_ingestion);
        }

        echo json_encode($result, JSON_NUMERIC_CHECK);
    }

    /**
     * AJAX. Поиск продуктов/ингредиентов
     */
    public function searchIngredients()
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3 or $this->session->user['blocked'] == 1)
        {
            parent::pageNotFound($this->page_url);
        }

        $result['ingredients'] = false;

        $search_text   = mb_substr(strip_tags($this->input->post('search_text', true)), 0, 255);

        if (!empty($search_text))
        {
            $result['ingredients'] = $this->Course_model->searchIngredients($search_text);
        }

        echo json_encode($result, JSON_NUMERIC_CHECK);
    }

    /**
     * AJAX. Вывод блюда
     *
     * @param string $day
     * @param string $ingestion
     * @param string $un_id
     * @param string $meal_id
     */
    public function showMeal($day = '', $ingestion = '', $un_id = '', $meal_id = '')
    {
        $un_id     = is_numeric($this->input->post('unid', true)) ? $this->input->post('unid', true) : null;
        $meal_id   = is_numeric($this->input->post('mlid', true)) ? $this->input->post('mlid', true) : null;
        $day       = is_numeric($this->input->post('did', true)) ? $this->input->post('did', true) : null;
        $ingestion = is_numeric($this->input->post('iid', true)) ? $this->input->post('iid', true) : null;
        $meal_date = !empty($this->input->post('start', true)) ? $this->input->post('start', true) : null;

        if (!empty($un_id) and !empty($day) and !empty($ingestion))
        {
            // Данные блюда
            $meal_data = $this->Course_model->getUserNutritionMeal($this->user_id, $day, $ingestion, $un_id, $meal_id);

            if (!empty($meal_data['meal']))
            {
                // Данные приема пищи
                $ingestion_data = $this->Course_model->getUserIngestionMeals($this->user_id, $un_id, $meal_data['duplicate_day'], $meal_data['duplicate_ing']);

                // Время приема пищи
                $tmp_date = new DateTime($meal_date);
                $meal_time = ($tmp_date !== false) ? $tmp_date->format('H:i') : '';

                $display_result['meal'] = '';

                ob_start();
                include_once('./app_fold/views/meals/calendar_meal.php');
                $meal_item = ob_get_contents();
                ob_end_clean();

                $display_result['meal'] .= $meal_item;
            }
            else
            {
                $display_result['error'] = 'Meal data error';
            }
        }
        else
        {
            $display_result['error'] = 'startParam, day or ingestion empty';
        }

        echo json_encode($display_result, JSON_NUMERIC_CHECK);
    }

    /**
     * AJAX. Вывод блюд по категориям приема пищи
     *
     * @param string $day
     * @param string $ingestion
     * @param string $un_id
     * @param string $meal_id
     */
    public function showMeals($day = '', $ingestion = '', $un_id = '', $meal_id = '')
    {
        $un_id     = (empty($un_id) and is_numeric($this->input->post('start_param', true))) ? $this->input->post('start_param', true) : $un_id;
        $meal_id   = (empty($meal_id) and is_numeric($this->input->post('ml_id', true))) ? $this->input->post('ml_id', true) : $meal_id;
        $day       = (empty($day) and is_numeric($this->input->post('day', true))) ? $this->input->post('day', true) : $day;
        $ingestion = (empty($ingestion) and is_numeric($this->input->post('ingestion', true))) ? $this->input->post('ingestion', true) : $ingestion;
        $meal_date = (!empty($this->input->post('start', true))) ? $this->input->post('start', true) : null;

        if (!empty($day) and !empty($ingestion))
        {
            // Данные блюда
            $meals_data = $this->Course_model->getUserNutritionMeals($this->user_id, $day, $ingestion, $un_id);

            if (!empty($meals_data['meals']))
            {
                // Данные приема пищи
                $ingestion_data = $this->Course_model->getUserIngestionMeals($this->user_id, $un_id, $meals_data['duplicate_day'], $meals_data['duplicate_ing']);

                // Время приема пищи
                $tmp_date = new DateTime($meal_date);
                $meal_time = ($tmp_date !== false) ? $tmp_date->format('H:i') : '';

                $display_result['meals'] = '';

                ob_start();
                include_once('./app_fold/views/meals/calendar_meals.php');
                $meals_item = ob_get_contents();
                ob_end_clean();

                $display_result['meals'] .= $meals_item;
            }
            else
            {
                $display_result['error'] = 'Meal data error';
            }
        }
        else
        {
            $display_result['error'] = 'startParam, day or ingestion empty';
        }

        echo json_encode($display_result, JSON_NUMERIC_CHECK);
    }

    /**
     * AJAX. Выбор блюда
     */
    public function selectMeal()
    {
        $un_id     = is_numeric($this->input->post('unid', true)) ? $this->input->post('unid', true) : null;
        $meal_id   = is_numeric($this->input->post('mlid', true)) ? $this->input->post('mlid', true) : null;
        $day       = is_numeric($this->input->post('did', true)) ? $this->input->post('did', true) : null;
        $ingestion = is_numeric($this->input->post('iid', true)) ? $this->input->post('iid', true) : null;

        if (!empty($meal_id) and !empty($un_id) and !empty($day) and !empty($ingestion))
        {
            // Данные блюда
            $res_up = $this->Course_model->updateUserNutritionMeal($this->user_id, $day, $ingestion, $un_id, $meal_id, $this->date);

            if($res_up === true)
            {
                self::showMeal($day, $ingestion, $un_id, $meal_id);
            }
            else
            {
                $display_result['error'] = 'Select error';

                echo json_encode($display_result, JSON_NUMERIC_CHECK);
            }
        }
        else
        {
            $display_result['error'] = 'mlId, startParam, day or ingestion empty';

            echo json_encode($display_result, JSON_NUMERIC_CHECK);
        }
    }

    /**
     * AJAX. Выбор курса тренировок для отображения в календарь
     */
    public function displayUserCourse()
    {
        $result = false;

        $user_course_id = is_numeric($this->input->post('crs_id', true)) ? $this->input->post('crs_id', true) : null;
        $display        = ($this->input->post('display', true) == 1) ? 1 : 0;

        if(!empty($user_course_id))
        {
            $result = $this->Course_model->displayUserCourse($user_course_id, $display, $this->user_id, $this->date);
        }

        echo json_encode($result, JSON_NUMERIC_CHECK);
    }

    /**
     * AJAX. Выбор курса тренировок для отображения в календарь
     */
    public function displayUserNutrition()
    {
        $result = false;

        $user_course_id = is_numeric($this->input->post('crs_id', true)) ? $this->input->post('crs_id', true) : null;
        $display        = ($this->input->post('display', true) == 1) ? 1 : 0;

        if(!empty($user_course_id))
        {
            $result = $this->Course_model->displayUserNutrition($user_course_id, $display, $this->user_id, $this->date);
        }

        echo json_encode($result, JSON_NUMERIC_CHECK);
    }

    /**
     * AJAX. Отображение блока добавления приемам пищи пользователя
     */
    public function showUserMeal()
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id)) {
            parent::pageNotFound($this->page_url);
        }

        $result = array('form' => '', 'error' => '');

        $user_meal_data = $this->Course_model->getTodayUserMeal($this->user_id, $this->date);
        $user_bmr = $this->User_model->getUserBMR($this->user_id);

        ob_start();
            include_once('./app_fold/views/meals/user/user_add_meal_form.php');
            $form = ob_get_contents();
        ob_end_clean();

        $result['form'] = $form;

        echo json_encode($result, JSON_NUMERIC_CHECK);
    }

    /**
     * AJAX. Поиск блюд/продуктов/ингредиентов для добавления в прием пищи пользователя
     */
    public function userSearchMeals()
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id)) {
            parent::pageNotFound($this->page_url);
        }

        $result['meals'] = false;

        $search_text = mb_substr(strip_tags($this->input->post('search_text', true)), 0, 255);

        if (!empty($search_text))
        {
            $result['meals'] = $this->Course_model->userSearchMeals($search_text);
        }
        else
        {
            $result['meals'] = '<div class="not_found">Продукт/ингредиент/блюдо не найдены</div>';
        }

        echo json_encode($result, JSON_NUMERIC_CHECK);
    }

    /**
     * AJAX. Сохранение данных о добавляемом приеме пищи
     */
    public function saveUserMeal()
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id))
        {
            parent::pageNotFound($this->page_url);
        }

        $result = false;

        $s_datetime   = ($this->input->post('s_datetime', true) === 'select') ? 'select' : 'now';
        $i_datetime   = $this->input->post('i_datetime', true);
        $ingr_weights = $this->input->post('ingr_weights', true);

        if(!empty($ingr_weights))
        {
            parse_str($ingr_weights, $weights);
        }

        if(is_array($weights['i_user_meal_weight']))
        {
            foreach($weights['i_user_meal_weight'] as $ml_id => $weight)
            {
                if(!is_numeric($ml_id))
                {
                    unset($weights['i_user_meal_weight'][$ml_id]);
                }
            }
            unset($weight);
            unset($ml_id);

            if(!empty($weights['i_user_meal_weight']))
            {
                $meals_weight  = $weights['i_user_meal_weight'];
                $meal_datetime = $this->date;
                if($s_datetime === 'select')
                {
                    $tmp_datetime  = new DateTime($i_datetime);
                    $meal_datetime = ($tmp_datetime !== false) ? $tmp_datetime->format('Y-m-d H:i:s') : $meal_datetime;
                }

                $res_ins = $this->Course_model->addNewUserMeal($this->user_id, $meals_weight, $meal_datetime, $this->date);
                if($res_ins === true)
                {
                    $result = true;
                }
            }
        }

        echo json_encode($result, JSON_NUMERIC_CHECK);
    }

    /**
     * Отправка эл. писем с меню курса питания пользователям
     */
    public function sendNutritionWeekMenuEmails()
    {
        $tmp_date = new DateTime($this->date);
        $num_day  = ($tmp_date !== false) ? $tmp_date->format('N') : null;

        // Отправка уведомлений в понедельник
        if($num_day == 1)
        {
            $users_week_menu = $this->Course_model->getUsersNutritionWeekMenu($this->date);

            // Отправка писем
            if(!empty($users_week_menu['users_week_menu']))
            {
                foreach($users_week_menu['users_week_menu'] as $user_wm)
                {
                    $system_message['course_menu'] = $user_wm['course_menu'];
                    $system_message['course']      = $user_wm['course'];

                    parent::sendEmail(12, $user_wm['user_email'], $system_message);
                }
                unset($user_wm);
            }
        }
    }
}