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
     * @throws Exception
     */
    public function profile($user_id = null)
    {
        $user_id = (empty($user_id)) ? $this->user_id : $user_id;

        if (!is_numeric($user_id))
        {
            parent::pageNotFound($this->page_url);
        }

        //log_message('debug', print_r($this->session, true));

        // Страница пользователя или администратора
        if (!empty($this->user_id) and $this->user_id == $user_id and $this->session->user['type'] != 2)
        {
            self::userProfile($user_id);
        }
        // Страница тренера
        elseif (!empty($this->user_id) and $this->user_id == $user_id and $this->session->user['type'] == 2)
        {
            self::coachProfile($user_id);
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
     * @throws Exception
     */
    private function userProfile($user_id)
    {
        // Исходная страница
        $return_url = '/profile/'.$user_id;

        $this->load->model('Coach_model');
        $this->load->model('Blog_model');
        $this->load->model('Course_model');
        $this->load->model('Payment_model');
        $this->load->model('Store_model');

        $title = !empty($this->session->user['name']) ? $this->session->user['name'] . ' - пользователь' : 'Страница пользователя' ;

        $u_training_time  = $this->User_model->getUserTrainingTime($user_id); // Тренировочное время пользователя
        $user_courses     = $this->Course_model->getUserCourses($user_id, $this->date, 'active', $u_training_time); // Выборка курсов пользователя
        $courses_data     = $this->Store_model->getUserCoursesOrder($this->user_id, $user_courses);
        $course_notifs    = $this->Course_model->getUserCoursesNotifications($user_id, $this->date); // Выборка уведомлений курсов пользователя
        $payment_notifs   = $this->Payment_model->getUserWaitingPayments($user_id); // Выборка неподтверженных платежей
        $anthrop_data     = $this->User_model->getAnthropometricData($user_id, $this->date); // Антропометрические данные пользователя
        $user_social      = $this->User_model->getUserSocial($user_id);
        $u_data           = $this->User_model->getUserSettingsData($user_id);
        $friend_promocode = $this->Course_model->getPromocodeForFriend($user_id);

        // Проверка активации аккаунта
        if(empty($u_data['user_data']['user_activated']))
        {
            $this->load->model('Authorization_model');
            $activate_check = $this->Authorization_model->checkActivateEmail($this->user_id, $this->date);

            if($activate_check['availability_send_email'] === true)
            {
                $u_data['user_data']['activate_email']['availability_send_email'] = true;
            }
            $u_data['user_data']['activate_email']['availability_send_email_date'] = $activate_check['availability_send_email_date'];
        }

        //$courses[0]['id'] = 6;
        //$this->Course_model->unblockUserOrderCourses(80, 4, $courses, 'payment_succeeded', $this->date);

        $result = array_merge($user_courses, $courses_data, $anthrop_data, $user_social, $u_data, $friend_promocode);

        if ($this->input->post('bt_buy_course', true) and $this->input->post('cb_offer', true) and
            (!empty($this->user_id) or (empty($this->user_id) and $this->input->post('cb_politics', true))))
        {
            $course_id = (is_numeric($this->input->post('crs_id', true))) ? $this->input->post('crs_id', true) : null;
            $order_id  = (is_numeric($this->input->post('ord_id', true))) ? $this->input->post('ord_id', true) : null;

            if(!empty($course_id))
            {
                // Данные курса
                $course = $this->Course_model->getAvailableCourse($course_id, $this->date);
                $course_coaches = $this->Course_model->getCourseCoachesId($course_id);
                $db_data = $course['course'];
                // Выбранный тренер
                $id_coach = $this->input->post('user_coach', true);
                // Вариант оплаты (полный, разделить на месяцы)
                $s_payment_options = $this->input->post('s_payment_options', true);
                // Способ оплаты
                $s_payment_method = $this->input->post('s_payment_method', true);
                // Данные для способа оплаты
                $i_phone = $this->input->post('i_phone', true);
                $i_login = $this->input->post('i_login', true);
                $i_email = $this->input->post('email', true);
                $i_name  = $this->input->post('name', true);
                // Введенный промокод
                $i_promocode = $this->input->post('promocode', true);

                parent::buyCourse($course_id, $db_data, $course_coaches, $id_coach, $s_payment_options,
                    $s_payment_method, $i_phone, $i_login, $i_email, $i_name, $i_promocode, $return_url, $order_id);
            }
        }
        elseif ($this->input->post('bt_pay_premium', true) and $this->input->post('cb_offer', true) and
            (!empty($this->user_id) or (empty($this->user_id) and $this->input->post('cb_politics', true))))
        {
            $order_id  = (is_numeric($this->input->post('ord_id', true))) ? $this->input->post('ord_id', true) : null;

            // Вариант оплаты (полный, разделить на месяцы)
            $s_payment_options = 'partial_payment';
            // Способ оплаты
            $s_payment_method = 'bank_card';
            // Данные для способа оплаты
            $i_phone = $this->input->post('i_phone', true);
            $i_login = $this->input->post('i_login', true);
            $i_email = $this->input->post('email', true);
            $i_name  = $this->input->post('name', true);

            parent::buyPremium($s_payment_options, $s_payment_method, $i_phone, $i_login, $i_email, $i_name, $return_url, $order_id);
        }
        elseif($this->input->post('bt_save_postpone', true))
        {
            $tmp_date = new DateTime($this->date);
            $today    = ($tmp_date !== false) ? $tmp_date->format('Y-m-d') : null;

            $wo_data = $this->Course_model->getUserCoursesWeekWorkouts($this->user_id, $today);
            $wo_data = $wo_data['tw_wo'];

            $update_workouts = array();

            $postpone_courses      = json_decode($this->input->post('i_changed_events', true), true);
            $postpone_time_courses = $this->input->post('i_days_time', true);
            $new_postpone_courses  = array();
            //$postpone_courses = json_decode($postpone_courses, true);
            //asort($postpone_workouts);
            //$last_date = end($postpone_workouts);
            //$crs_wo_id = '';

            if(!empty($wo_data) and !empty($postpone_courses))
            {
                foreach($wo_data as $uc_id => $week_workouts)
                {
                    if(array_key_exists($uc_id, $postpone_courses))
                    {
                        foreach($week_workouts as $wo_id => $wo)
                        {
                            $wo_date = mb_substr($wo['start'], 0, 10);
                            $new_wo_date = (is_array($postpone_courses[$uc_id]) and array_key_exists($wo_id, $postpone_courses[$uc_id])) ? $postpone_courses[$uc_id][$wo_id] : null;
                            $wo_date = (!empty($new_wo_date) and $new_wo_date != $wo_date and $new_wo_date >= $today) ? $new_wo_date : $wo_date;

                            $new_postpone_courses[$uc_id][$wo_date][$wo_id] = $wo_data[$uc_id][$wo_id]['crs_wo_id'];
                        }
                        unset($wo);
                        unset($wo_date);

                        ksort($new_postpone_courses[$uc_id]);

                        // Изменение (смещение) номера тренировки курса, в соотв. с последовательностью тренировок
                        $crs_wo_id = 0;
                        $fl_missed = false;
                        foreach ($new_postpone_courses[$uc_id] as $wo_date => $wos_by_date)
                        {
                            foreach($wos_by_date as $wo_id => $wo)
                            {
                                if($fl_missed === true or (!empty($crs_wo_id) and $crs_wo_id >= $wo))
                                {
                                    $crs_wo_id++;
                                    $fl_missed = true;
                                }
                                else
                                {
                                    $crs_wo_id = $wo;
                                }

                                $new_postpone_courses[$uc_id][$wo_date][$wo_id] = $crs_wo_id;
                            }
                            unset($wo);
                        }
                        unset($wos_by_date);
                    }
                }
            }
            else
            {
                // Изменения не сохранены
                $this->session->set_tempdata('message', 196, 60);
            }

            if(!empty($postpone_time_courses))
            {
                $result = $this->Course_model->postponeUserCourseWeekWorkoutsTime($this->user_id, $postpone_time_courses, $this->date);
            }

            if(!empty($new_postpone_courses))
            {
                $result = $this->Course_model->postponeUserCourseWeekWorkouts($this->user_id, $new_postpone_courses, $this->date);
            }

            if($result === true)
            {
                // Изменения сохранены
                $this->session->set_tempdata('message', 10, 60);
            }
            else
            {
                // Изменения не сохранены
                $this->session->set_tempdata('message', 196, 60);
            }

            /*$current_num_day = date("N", strtotime($this->date));

            $postpone_courses = $this->input->post('cb_day', true);
            $pc_times = $this->input->post('i_days_time', true);
            if(!empty($postpone_courses))
            {
                // Данные тренировок недели пользователя
                $wo_data = $this->Course_model->getUserCoursesWeekWorkouts($this->user_id, $today);

                //print_r($wo_data['tw_wo']); echo '<br/><br/>';

                foreach ($postpone_courses as $pc_uc_id => $choose_days)
                {
                    if(!empty($wo_data['tw_wo'][$pc_uc_id]))
                    {
                        $crs_wo_data = $wo_data['tw_wo'][$pc_uc_id];

                        $count_choose_days = count($choose_days); // Кол-во выбранных дней
                        $count_crs_days    = count($crs_wo_data['days']); // Текущие дни недели тренировок курса

                        // Дни недели в обратном порядке
                        rsort($crs_wo_data['days']);

                        // Данные тренировок курса недели
                        $update_days = $crs_wo_data['wos'];

                        // Смещение дней тренировок
                        // Если кол-во выбранных дней = 1, то проверка номера дня недели на больше, меньше.
                        // Иначе перенос всех тренировок недели
                        if($count_choose_days == 1)
                        {
                            $choose_day  = $choose_days[0];
                            $fl_postpone = false;

                            foreach($crs_wo_data['days'] as $key => $crs_day)
                            {
                                // Смещаем предыдущую тренировку вперед
                                if($crs_day < $choose_day)
                                {
                                    // Обновляем данные тренировки
                                    $update_days[$crs_day]['num_day'] = $choose_day;

                                    // New date
                                    $diff_day = $choose_day - $crs_day;
                                    $tmp_date = new DateTime($update_days[$crs_day]['date']);
                                    $new_date = ($tmp_date !== false) ? $tmp_date->add(new DateInterval('P'.$diff_day.'D'))->format('Y-m-d') : $update_days[$crs_day]['date'];
                                    $update_days[$crs_day]['date'] = $new_date;
                                    $num_date = date("N", strtotime($new_date));

                                    // New time
                                    $update_days[$crs_day]['time'] = (!empty($pc_times[$pc_uc_id][$choose_day]) and $update_days[$crs_day]['time'] != $pc_times[$pc_uc_id][$choose_day])
                                        ? $pc_times[$pc_uc_id][$choose_day] : $update_days[$crs_day]['time'];

                                    // New status
                                    $status = $update_days[$crs_day]['status'];
                                    $update_days[$crs_day]['status'] = ($current_num_day <= $num_date) ? '' : $status;

                                    // New course number workout
                                    if($status == '')
                                    {
                                        $update_days[$crs_day]['crs_wo_id']++;
                                    }

                                    // Смещаем номер недели тренировки на предыдущю тренировку.
                                    $choose_day  = $crs_day;
                                    $fl_postpone = true;
                                    $update_days[$crs_day]['update'] = true;

                                    break;
                                }
                                // Смещение отсутствует
                                elseif($crs_day == $choose_day)
                                {
                                    // Проверка изменения времени тренировки
                                    if(!empty($pc_times[$pc_uc_id][$choose_day]) and $update_days[$crs_day]['time'] != $pc_times[$pc_uc_id][$choose_day])
                                    {
                                        // New time
                                        $update_days[$crs_day]['time']   = $pc_times[$pc_uc_id][$choose_day];
                                        $update_days[$crs_day]['update'] = true;
                                        $fl_postpone = true;
                                        break;
                                    }
                                    else
                                    {
                                        $fl_postpone = true;
                                        break;
                                    }
                                }
                            }
                            unset($crs_day);

                            // Если перенос не произошел, то переносим первую тренировку из списка
                            if($fl_postpone === false)
                            {
                                sort($crs_wo_data['days']);
                                $crs_day = $crs_wo_data['days'][0];

                                // Обновляем данные тренировки
                                $update_days[$crs_day]['num_day'] = $choose_day;

                                // New date
                                $diff_day = $crs_day - $choose_day;
                                $tmp_date = new DateTime($update_days[$crs_day]['date']);
                                $new_date = ($tmp_date !== false) ? $tmp_date->sub(new DateInterval('P'.$diff_day.'D'))->format('Y-m-d') : $update_days[$crs_day]['date'];
                                $update_days[$crs_day]['date'] = $new_date;
                                $num_date = date("N", strtotime($new_date));

                                // New time
                                $update_days[$crs_day]['time'] = (!empty($pc_times[$pc_uc_id][$choose_day]) and $update_days[$crs_day]['time'] != $pc_times[$pc_uc_id][$choose_day])
                                    ? $pc_times[$pc_uc_id][$choose_day] : $update_days[$crs_day]['time'];

                                // New status
                                $status = $update_days[$crs_day]['status'];
                                $update_days[$crs_day]['status'] = ($current_num_day <= $num_date) ? '' : $status;

                                $update_days[$crs_day]['update'] = true;
                            }
                        }
                        elseif($count_choose_days == $count_crs_days)
                        {
                            rsort($choose_days);

                            foreach($crs_wo_data['days'] as $key => $crs_day)
                            {
                                // Обновляем данные тренировки
                                $update_days[$crs_day]['num_day'] = $choose_days[$key];

                                // New date
                                $new_date = $update_days[$crs_day]['date'];
                                if($choose_days[$key] > $crs_day)
                                {
                                    $diff_day = $choose_days[$key] - $crs_day;
                                    $tmp_date = new DateTime($update_days[$crs_day]['date']);
                                    $new_date = ($tmp_date !== false) ? $tmp_date->add(new DateInterval('P'.$diff_day.'D'))->format('Y-m-d') : $new_date;
                                }
                                elseif($choose_days[$key] < $crs_day)
                                {
                                    $diff_day = $crs_day - $choose_days[$key];
                                    $tmp_date = new DateTime($update_days[$crs_day]['date']);
                                    $new_date = ($tmp_date !== false) ? $tmp_date->sub(new DateInterval('P'.$diff_day.'D'))->format('Y-m-d') : $new_date;
                                }
                                $update_days[$crs_day]['date'] = $new_date;
                                $num_date = date("N", strtotime($new_date));

                                // New time
                                $update_days[$crs_day]['time'] = (!empty($pc_times[$pc_uc_id][$choose_days[$key]]) and $update_days[$crs_day]['time'] != $pc_times[$pc_uc_id][$choose_days[$key]])
                                    ? $pc_times[$pc_uc_id][$choose_days[$key]] : $update_days[$crs_day]['time'];

                                // New status
                                $status = $update_days[$crs_day]['status'];
                                $update_days[$crs_day]['status'] = ($current_num_day <= $num_date) ? '' : $status;

                                // New course number workout
                                if($status == '')
                                {
                                    $update_days[$crs_day]['crs_wo_id']++;
                                }

                                $update_days[$crs_day]['update'] = true;
                            }
                            unset($crs_day);
                        }

                        $wo_data['tw_wo'][$pc_uc_id]['wos'] = $update_days;
                    }
                }
                unset($pc);
                unset($pc_uc_id);

                $result = $this->Course_model->postponeUserCourseWeekWorkouts($this->user_id, $wo_data, $this->date);
                //$result = false;
                //print_r($wo_data['tw_wo']); echo '<br/>';

                if($result === true)
                {
                    // Изменения сохранены
                    $this->session->set_tempdata('message', 10, 60);
                }
                else
                {
                    // Изменения не сохранены
                    $this->session->set_tempdata('message', 196, 60);
                }
            }
            else
            {
                // Изменения не сохранены
                $this->session->set_tempdata('message', 196, 60);
            }*/

            header('Location: /profile/'.$this->user_id);
        }
        elseif($this->input->post('bt_save_start_courses', true))
        {
            $cb_days = $this->input->post('cb_day', true);
            $i_times = $this->input->post('i_days_time', true);

            $crs_count_weeks = $this->input->post('crs_count_weeks', true);
            $crs_count_days  = $this->input->post('crs_count_days', true);

            if(!empty($cb_days))
            {
                $training_days        = array();
                $training_times       = array();
                $new_course_start     = array();
                $new_course_end       = array();
                $array_training_times = array();

                foreach ($cb_days as $uc_id => $days)
                {
                    $course_weeks = $crs_count_weeks[$uc_id];
                    $course_days  = $crs_count_days[$uc_id];
                    $array_training_times[$uc_id] = array();

                    $i = 1;
                    if(!empty($days))
                    {
                        foreach ($days as $key => $day)
                        {
                            // Если кол-во выбранных дней не превышает кол-во дней курса
                            if ($i <= $course_days)
                            {
                                $training_days[$uc_id] .= $day;

                                $i_time = $i_times[$uc_id][$day];
                                $time_date = DateTime::createFromFormat('H:i', $i_time);
                                $array_training_times[$uc_id][$day] = ($time_date !== false) ? $i_time : '';

                                $i++;
                            }
                        }
                        unset($day);
                        // Массив новых дней тренировок
                        $array_training_days = !empty($training_days[$uc_id]) ? str_split($training_days[$uc_id]) : null;

                        // Вычисление старта и окончания курса
                        if (!empty($array_training_days))
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
                                        $new_course_start[$uc_id] = ($tmp_date !== false) ? $tmp_date->format('Y-m-d') : '';

                                        break;
                                    }
                                }
                                unset($training_day);

                                // Если дата начала курса не вычислилась на предыдущем этапе, выбираем первый день недели тренировки
                                // пользователя и вычисляем её дату
                                if (empty($new_course_start[$uc_id]))
                                {
                                    // От 7 дней недели отнимаем день недели предыдущей тренировки и прибавляем день недели первой тренировки на неделе
                                    $diff_days = 7 - $current_num_day + $array_training_days[0];
                                    // Временная дата предыдущей тренивроки
                                    $tem_date = new DateTime($today);
                                    // Дата текущей тренировки, с учетом разницы между тренировками ( + $diff_days дней )
                                    $tem_date->add(new DateInterval('P' . $diff_days . 'D'));

                                    $new_course_start[$uc_id] = ($tem_date !== false) ? $tem_date->format('Y-m-d') : $this->date;
                                }
                            }
                            else
                            {
                                $new_course_start[$uc_id] = $today;
                            }

                            // Изначальная дата окончания курса
                            if (!empty($new_course_start[$uc_id]))
                            {
                                $count_days = ($course_weeks*7) - 1;
                                $tmp_date = new DateTime($new_course_start[$uc_id]);
                                $tmp_date->add(new DateInterval('P' . $count_days . 'D'));
                                $new_course_end[$uc_id] = ($tmp_date !== false) ? $tmp_date->format('Y-m-d') : '';
                            }
                        }
                    }
                }
                unset($days);

                // Сохранение данных
                if(!empty($training_days))
                {
                    // Сохранение дней и времени тренировок пользователя
                    /*log_message('debug', 'Training days: ' . print_r($training_days, true));
                    log_message('debug', 'Training times: ' . print_r($training_times, true));
                    log_message('debug', 'Courses starts: ' . print_r($new_course_start, true));
                    log_message('debug', 'Courses ends: ' . print_r($new_course_end, true));*/
                    $result_td = $this->Course_model->setUserCoursesTrainingDays($user_id, $training_days, $array_training_times,
                        $new_course_start, $new_course_end, $crs_count_weeks, $crs_count_days, $this->date);
                    if ($result_td === true)
                    {
                        // Изменения сохранены
                        $this->session->set_tempdata('message', 10, 60);
                    }
                    else
                    {
                        // Изменения не сохранены
                        $this->session->set_tempdata('message', 79, 60);
                    }
                }
            }

            header('Location: /profile/'.$user_id);
        }
        elseif($this->input->post('bt_save_email', true))
        {
            // Валидация E-mail
            $email = ($u_data['user_data']['user_email_empty'] === true and filter_var($this->input->post('email', true), FILTER_VALIDATE_EMAIL))
                ? $this->input->post('email', true)
                : null;

            if(!empty($email))
            {
                $this->load->model('Authorization_model');

                $res_check = $this->Authorization_model->checkEmail($email);
                if($res_check === false)
                {
                    $email_hash = (!empty($email)) ? password_hash($email, PASSWORD_DEFAULT) : null;

                    // Сохранение данных по смене email в БД
                    $set_change = $this->Authorization_model->fillUserEmptyEmail($this->user_id, $email, $email_hash, $this->date);

                    if($set_change === true)
                    {
                        self::sendEActivateEmail($email, $email_hash);

                        // Данные о смене были сохранены
                        $this->session->set_tempdata('message', 206, 60);
                    }
                    else
                    {
                        // Данные о смене не были сохранены
                        $this->session->set_tempdata('message', 190, 60);
                    }
                }
                else
                {
                    // Пользователь с таким email уже зарегистрирован
                    $this->session->set_tempdata('message', 1, 60);
                }
            }
            else
            {
                // Пользователь с таким email уже зарегистрирован
                $this->session->set_tempdata('message', 221, 60);
            }

            header('Location: /profile/'.$user_id);
        }
        elseif($this->input->post('bt_e_activate_send_again', true))
        {
            $this->load->model('Authorization_model');

            $res_check = $this->Authorization_model->checkActivateEmail($this->user_id, $this->date);

            if(is_array($res_check))
            {
                if($res_check['availability_send_email'] === true)
                {
                    self::sendEActivateEmail($res_check['user_email'], $res_check['activate_code']);
                    /*log_message('debug', print_r($res_check, true));*/

                    $this->Authorization_model->setResendingActivateEmailDate($this->user_id, $this->date);

                    // Данные о смене были сохранены
                    $this->session->set_tempdata('message', 202, 60);
                }
            }
            header('Location: /profile/' . $user_id);
        }
        elseif($this->input->post('bt_save_avatar', true))
        {
            // Загрузка изображения на сервер
            $db_path_avatar = '.' . $u_data['user_data']['user_image'];
            $db_avatar      = $u_data['user_data']['user_image'];
            if(is_uploaded_file($_FILES['avatar_file']['tmp_name']))
            {
                $path = './user_files/'.$this->user_id.'/avatar/';

                if(!file_exists($path)){
                    chdir('user_files');
                    if(!is_dir($this->user_id))
                    {
                        mkdir($this->user_id);
                    }
                    chmod($this->user_id, 0777);
                    chdir($this->user_id);
                    if(!is_dir('avatar'))
                    {
                        mkdir('avatar');
                    }
                    chmod('avatar', 0777);
                    chdir('avatar');
                    chdir('../../../');
                }
                $this->load->helper('file');

                $path_image = parent::uploadImage('avatar_file',$_FILES['avatar_file']['type'], $path);
                if(file_exists($path.$path_image))
                {
                    if ($this->security->xss_clean($path.$path_image, TRUE) !== FALSE)
                    {
                        // файл прошел XSS тест
                        $path_avatar = $path.$path_image;
                        $avatar = '/user_files/'.$this->user_id.'/avatar/'.$path_image;

                        if (!empty($user_data['user_image']) and is_file($user_data['user_image']))
                        {
                            unlink('.' . $user_data['user_image']);
                        }
                    }
                    else
                    {
                        unlink($path);
                    }
                }
            }

            if(!empty($path_avatar) and !empty($avatar) and is_file($path_avatar) and $path_avatar != $db_path_avatar)
            {
                $result = $this->User_model->updateUserAvatar($this->user_id, $path_avatar, $this->date);

                if ($result === false)
                {
                    // Изменения не были сохранены
                    $this->session->set_tempdata('message', 222, 60);
                }
                else
                {
                    // Обновление данных сессии
                    $user_data = array('user' => $this->session->user);

                    $user_data['user']['image'] = $avatar;
                    $user_data['user']['date']  = $this->date;

                    $this->session->set_userdata($user_data);

                    // Изменения сохранены
                    $this->session->set_tempdata('message', 10, 60);
                }
            }

            header('Location: /profile/'.$this->user_id);
        }

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

                        /*if($notif['send_email'] === true)
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
                        }*/
                    }
                    // Курс завершен
                    elseif(is_numeric($code) and $code == 154)
                    {
                        $notification = $this->Notification_model->getNotification($code);

                        $this->page_data['course_notification'][$user_course_id]['course_finished']['text']    = $notification['notification']['text'];
                        $this->page_data['course_notification'][$user_course_id]['course_finished']['extends'] = $notif['extends'];
                    }

                    // Пропущена тренировка на этой неделе
                    if(is_numeric($code) and $code == 197)
                    {
                        $notification = $this->Notification_model->getNotification($code);

                        $this->page_data['course_notification'][$user_course_id]['workout_missed']['text'] = $notification['notification']['text'];
                    }

                    // Неначатые курсы
                    if(is_numeric($code) and $code == 203)
                    {
                        $notification = $this->Notification_model->getNotification($code);

                        $this->page_data['course_notification'][$user_course_id]['non_started']['text'] = $notification['notification']['text'];
                        $this->page_data['course_notification'][$user_course_id]['non_started']['course_name']  = $notif['course_name'];
                        $this->page_data['course_notification'][$user_course_id]['non_started']['uc_id']        = $notif['uc_id'];
                        $this->page_data['course_notification'][$user_course_id]['non_started']['course_id']    = $notif['course_id'];
                        $this->page_data['course_notification'][$user_course_id]['non_started']['course_weeks'] = $notif['course_weeks'];
                        $this->page_data['course_notification'][$user_course_id]['non_started']['course_days']  = $notif['course_days'];
                        $this->page_data['course_notification'][$user_course_id]['non_started']['course_rest']  = $notif['course_rest'];
                    }

                    // Закончились бесплатные недели
                    if(is_numeric($code) and $code == 204)
                    {
                        $notification = $this->Notification_model->getNotification($code);

                        $this->page_data['course_notification'][$user_course_id]['free_weeks_over']['text']        = $notification['notification']['text'];
                        $this->page_data['course_notification'][$user_course_id]['free_weeks_over']['course_name'] = $notif['course_name'];
                        $this->page_data['course_notification'][$user_course_id]['free_weeks_over']['uc_id']       = $notif['uc_id'];
                        $this->page_data['course_notification'][$user_course_id]['free_weeks_over']['course_id']   = $notif['course_id'];
                        $this->page_data['course_notification'][$user_course_id]['free_weeks_over']['order_id']    = $notif['order_id'];
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
        // Не указан email
        if($u_data['user_data']['user_email_empty'] === true)
        {
            $notification = $this->Notification_model->getNotification(205);

            $this->page_data['user_notification']['empty_email']['text'] = $notification['notification']['text'];
        }
        // Есть неподтвержденные платежи
        if($u_data['user_data']['user_activated'] == 0 and !empty($payment_notifs['waiting_payments']))
        {
            $notification = $this->Notification_model->getNotification(213);

            $this->page_data['user_notification']['waiting_payments']['text'] = $notification['notification']['text'];
        }
        // Неактивирован аккаунт
        if($u_data['user_data']['user_activated'] == 0)
        {
            $notification = $this->Notification_model->getNotification(218);

            $this->page_data['user_notification']['not_activated']['text'] = $notification['notification']['text'];
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
     * @param $coach_id
     * @return void
     */
    private function coachProfile($coach_id)
    {
        $this->load->model('Coach_model');
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

        $portfolio   = $this->Coach_model->getCoachPortfolioData($coach_id);
        $posts       = $this->Blog_model->getCoachBlogPosts($coach_id);
        $clients     = $this->Coach_model->getCoachClientsActivity($coach_id);
        $c_data      = $this->Coach_model->getCoach($coach_id, $this->date);
        $user_social = $this->User_model->getUserSocial($this->user_id);
        $coach_crss  = $this->Course_model->getCoachCourses($this->user_id);

        $result = array_merge($portfolio, $posts, $clients, $c_data, $user_social, $coach_crss);

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
        $this->load->view('coach/profile', $result);
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
        $user_data   = $this->User_model->getAvailableUser($user_id);
        $user_social = $this->User_model->getUserSocial($this->user_id);
        $result = array_merge($user_data, $user_social);

        // Страница тренера
        if ($result['user_data']['user_type'] == 2)
        {
            self::outsiderCoachProfile($user_id);
        }
        // Страница администратора
        /*elseif ($result['user_data']['user_type'] == 3)
        {
            self::outsiderAdminProfile($user_id);
        }*/
        // Страница пользователя
        elseif ($result['user_data']['user_type'] == 1 and $this->session->user['type'] == 3)
        {
            self::outsiderUserProfile($user_id);
        }
        else
        {
            // Объединенные данные страница
            $this->page_data['title']     = 'Страница пользователя';
            $this->page_data['page_menu'] = 'user_page';
            $this->page_data['outsider']  = true;

            $this->load->view('header/header', $this->page_data);
            $this->load->view('header/profile');
            $this->load->view('user/profile_line');
            $this->load->view('user/outsider_profile');
            $this->load->view('footer/footer');
        }

    }

    /**
     * Страница пользователя для других пользователей
     *
     * @param $user_id
     */
    public function outsiderUserProfile($user_id)
    {
        $this->load->model('Course_model');

        // Данные пользователя
        $user_data    = $this->User_model->getUser($user_id);
        $user_courses = $this->Course_model->getUserCourses($user_id, $this->date, 'active'); // Выборка курсов пользователя
        $courses_data = $this->Store_model->getUserCoursesOrder($user_id, $user_courses);

        $result = array_merge($user_courses, $user_data, $courses_data);

        // Уведомления пользователя
        // Пользователь заблокирован
        if($result['user_data']['user_blocked'] == 1)
        {
            $notification = $this->Notification_model->getNotification(16);

            $this->page_data['user_notification']['blocked']['text'] = $notification['notification']['text'];
        }
        // Не указан email
        if($result['user_data']['user_email_empty'] === true)
        {
            $notification = $this->Notification_model->getNotification(205);

            $this->page_data['user_notification']['empty_email']['text'] = $notification['notification']['text'];
        }
        // Неактивирован аккаунт
        if($result['user_data']['user_activated'] == 0)
        {
            $notification = $this->Notification_model->getNotification(218);

            $this->page_data['user_notification']['not_activated']['text'] = $notification['notification']['text'];
        }

        $title = !empty($result['user_data']['name']) ? $result['user_data']['name'] . ' - пользователь' : $result['user_data']['default_name'] ;
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
     * Страница тренера для других пользователей
     *
     * @param $coach_id
     */
    public function outsiderCoachProfile($coach_id)
    {
        $this->load->model('Coach_model');
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

        $portfolio  = $this->Coach_model->getPublicCoachPortfolioData($coach_id);
        $posts      = $this->Blog_model->getPublicCoachBlogPosts($coach_id);
        $user       = $this->Coach_model->getCoach($coach_id, $this->date);
        $coach_crss = $this->Course_model->getCoachCourses($coach_id);
        $result     = array_merge($portfolio, $posts, $user, $coach_crss);

        // Уведомления пользователя
        if($user['user_data']['user_blocked'] == 1)
        {
            $this->load->model('Notification_model');
            $notification = $this->Notification_model->getNotification(16);

            $this->page_data['user_notification']['blocked']['text'] = $notification['notification']['text'];
        }

        $title = !empty($result['user_data']['user_name']) ? $result['user_data']['user_name'] . ' - тренер' : $result['user_data']['default_name'] ;
        // Объединенные данные страница
        $this->page_data['title']     = $title;
        $this->page_data['page_menu'] = 'user_page';
        $this->page_data['outsider']  = true;

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/profile');
        $this->load->view('user/profile_line');
        $this->load->view('coach/outsider_profile', $result);
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

        $title = !empty($result['user_data']['name']) ? $result['user_data']['name'] . ' - администратор' : $result['user_data']['default_name'] ;
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
     * @throws Exception
     */
    public function settings()
    {
        if (!is_numeric($this->user_id)) {
            parent::pageNotFound($this->page_url);
        }

        // Исходная страница
        $return_url = '/settings';

        $user = array();

        // Получение данных пользователя из БД
        // Страница пользователя или администратора
        if (!empty($this->user_id) and $this->session->user['type'] != 2)
        {
            $user = $this->User_model->getUserSettingsData($this->user_id);
        }
        // Страница тренера
        elseif (!empty($this->user_id) and $this->session->user['type'] == 2)
        {
            $this->load->model('Coach_model');

            // Получение данных тренера из БД
            $user = $this->Coach_model->getCoach($this->user_id);
        }

        // Возможность отправить повторно письмо с подтверждением активации или смены email
        if($user['user_data']['user_changing_email'] === true)
        {
            $this->load->model('Authorization_model');
            $email_check    = $this->Authorization_model->checkChangingEmail($this->user_id, $this->date);
            
            if($email_check['availability_send_email'] === true)
            {
                $user['user_data']['changing_email']['availability_send_email'] = true;
            }
            $user['user_data']['changing_email']['availability_send_email_date'] = $email_check['availability_send_email_date'];
        }
        if(empty($user['user_data']['user_activated']))
        {
            $this->load->model('Authorization_model');
            $activate_check = $this->Authorization_model->checkActivateEmail($this->user_id, $this->date);

            if($activate_check['availability_send_email'] === true)
            {
                $user['user_data']['activate_email']['availability_send_email'] = true;
            }
            $user['user_data']['activate_email']['availability_send_email_date'] = $activate_check['availability_send_email_date'];
        }

        // Получение данных пользователя из БД
        $user_social = $this->User_model->getUserSocial($this->user_id);
        $result = array_merge($user, $user_social);

        $user_data = (!empty($user)) ? $user['user_data'] : null;

        // Сохранение изменений данных
        if ($this->input->post('bt_save_settings', true))
        {
            // Валидация E-mail
            $new_email = ($user_data['user_activated'] == 1 and filter_var($this->input->post('email', true), FILTER_VALIDATE_EMAIL))
                    ? $this->input->post('email', true)
                    : null;
            // Смена email
            if(!empty($new_email) and $new_email != $user_data['user_email'])
            {
                $this->load->model('Authorization_model');

                $idempotent = password_hash($this->date, PASSWORD_DEFAULT);

                $res_check = $this->Authorization_model->checkEmail($new_email);
                if($res_check === false)
                {
                    // Сохранение данных по смене email в БД
                    $set_change = $this->Authorization_model->setUserChangeEmailData($this->user_id, $new_email, $idempotent, $this->date);

                    if($set_change === true)
                    {
                        self::sendEChangeEmail($user_data['user_email'], $user_data['user_activate_code'], $idempotent);

                        // Данные о смене были сохранены
                        $this->session->set_tempdata('message', 191, 60);
                    }
                    else
                    {
                        // Данные о смене не были сохранены
                        $this->session->set_tempdata('message', 190, 60);
                    }
                }
                else
                {
                    // Пользователь с таким email уже зарегистрирован
                    $this->session->set_tempdata('message', 1, 60);
                }
            }

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

            // Часовой пояс
            $timezone = strip_tags($this->input->post('timezone', true));

            // Телефон
            $code  = mb_substr(strip_tags($this->input->post('country', true)), 0, 2);
            $code  = (array_key_exists($code, $this->countries_codes)) ? $this->countries_codes[$code] : '';
            $phone = is_numeric($this->input->post('phone', true)) ? $this->input->post('phone', true) : '';

            // Загрузка изображения на сервер
            $path_avatar = '.' . $user_data['user_image'];
            $avatar      = $user_data['user_image'];
            if(is_uploaded_file($_FILES['avatar_file']['tmp_name']))
            {
                $path = './user_files/'.$this->user_id.'/avatar/';

                if(!file_exists($path)){
                    chdir('user_files');
                    if(!is_dir($this->user_id))
                    {
                        mkdir($this->user_id);
                    }
                    chmod($this->user_id, 0777);
                    chdir($this->user_id);
                    if(!is_dir('avatar'))
                    {
                        mkdir('avatar');
                    }
                    chmod('avatar', 0777);
                    chdir('avatar');
                    chdir('../../../');
                }
                $this->load->helper('file');

                $path_image = parent::uploadImage('avatar_file',$_FILES['avatar_file']['type'], $path);
                if(file_exists($path.$path_image))
                {
                    if ($this->security->xss_clean($path.$path_image, TRUE) !== FALSE)
                    {
                        // файл прошел XSS тест
                        $path_avatar = $path.$path_image;
                        $avatar = '/user_files/'.$this->user_id.'/avatar/'.$path_image;

                        if (!empty($user_data['user_image']) and is_file($user_data['user_image']))
                        {
                            unlink('.' . $user_data['user_image']);
                        }
                    }
                    else
                    {
                        unlink($path);
                    }
                }
            }

            // Сохранение данных в БД
            if (!empty($user_data['user_email']) and ($name != $user_data['user_name'] or $phone != $user_data['user_phone']
                or $code != $user_data['user_country_code'] or $timezone != $user_data['user_timezone']
                or $password_hash != $user_data['user_password_hash'] or $avatar != $user_data['user_image']))
            {
                $result = $this->User_model->setUserSettingsData($this->user_id, $name, $password_hash, $timezone, $code, $phone, $path_avatar, $this->date);

                if ($result === false)
                {
                    // Изменения не были сохранены
                    $this->session->set_tempdata('message', 9, 60);
                }
                else
                {
                    // Обновление данных сессии
                    $user_data = array('user' => $this->session->user);

                    $user_data['user']['name']  = $name;
                    $user_data['user']['phone'] = $phone;
                    $user_data['user']['image'] = $avatar;
                    $user_data['user']['date']  = $this->date;
                    $user_data['user_timezone'] = $timezone;

                    $this->session->set_userdata($user_data);

                    // Изменения сохранены
                    $this->session->set_tempdata('message', 10, 60);
                }
            }

            header('Location: /settings');
        }
        elseif ($this->input->post('bt_save_data', true))
        {
            $res_gb = false;
            $res_cd = false;

            // Пол
            $genders = array('male', 'female');
            $gender = (in_array($this->input->post('gender', true), $genders)) ? $this->input->post('gender', true) : '';

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
                    $res_cd = $this->Coach_model->setCoachData($this->user_id, $special, $experience, $title_awards, $about, $this->date);
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
        elseif ($this->input->post('bt_delete_account', true))
        {
            $tmp_date = new DateTime($this->date);
            $in_a_month = ($tmp_date !== false) ? $tmp_date->add(new DateInterval('P30D')) : false;
            $delete_date = ($in_a_month !== false) ? $in_a_month->format('Y-m-d') : '';

            $up_d = $this->User_model->temporarilyDeleteUser($this->user_id, $this->user_id, $delete_date);

            if ($up_d['result'] === true)
            {
                // Отправка уведомления на почту пользователя
                parent::sendEmail(13, $up_d['user_email']);

                // Пользователь удален
                $this->session->set_tempdata('message', 179, 60);

                header('Location: /logout');
            }
            else
            {
                // Пользователь не удален
                $this->session->set_tempdata('message', 180, 60);

                header('Location: /settings');
            }
        }
        elseif ($this->input->post('bt_e_activate_send_again', true))
        {
            $this->load->model('Authorization_model');

            $res_check = $this->Authorization_model->checkActivateEmail($this->user_id, $this->date);

            if(is_array($res_check))
            {
                if($res_check['availability_send_email'] === true)
                {
                    self::sendEActivateEmail($res_check['user_email'], $res_check['activate_code']);

                    $this->Authorization_model->setResendingActivateEmailDate($this->user_id, $this->date);

                    // Данные о смене были сохранены
                    $this->session->set_tempdata('message', 202, 60);
                }
            }
            header('Location: /settings');

        }
        elseif ($this->input->post('bt_e_change_email_send_again', true))
        {
            $this->load->model('Authorization_model');

            $res_check = $this->Authorization_model->checkChangingEmail($this->user_id, $this->date);

            if(is_array($res_check))
            {
                if($res_check['availability_send_email'] === true)
                {
                    self::sendEChangeEmail($res_check['user_email'], $res_check['activate_code'], $res_check['idempotent']);

                    $this->Authorization_model->setResendingChangeEmailDate($this->user_id, $this->date);

                    // Данные о смене были сохранены
                    $this->session->set_tempdata('message', 198, 60);
                }
            }
            header('Location: /settings');
        }
        elseif ($this->input->post('bt_pay_premium', true) and $this->input->post('cb_offer', true) and
            (!empty($this->user_id) or (empty($this->user_id) and $this->input->post('cb_politics', true))))
        {
            $order_id  = (is_numeric($this->input->post('ord_id', true))) ? $this->input->post('ord_id', true) : null;

            // Вариант оплаты (полный, разделить на месяцы)
            $s_payment_options = 'partial_payment';
            // Способ оплаты
            $s_payment_method = 'bank_card';
            // Данные для способа оплаты
            $i_phone = $this->input->post('i_phone', true);
            $i_login = $this->input->post('i_login', true);
            $i_email = $this->input->post('email', true);
            $i_name  = $this->input->post('name', true);

            parent::buyPremium($s_payment_options, $s_payment_method, $i_phone, $i_login, $i_email, $i_name, $return_url, $order_id);
        }


        // Страница пользователя или администратора
        if (!empty($this->user_id) and $this->session->user['type'] != 2)
        {
            self::userSettings($result);
        }
        // Страница тренера
        elseif (!empty($this->user_id)  and $this->session->user['type'] == 2)
        {
            self::coachSettings($result);
        }
    }

    /**
     * Страница редактирования регистрационных данных пользователя
     *
     * @param $result
     * @return void
     */
    public function userSettings($result)
    {
        // Объединенные данные страница
        $this->page_data['title']        = 'Настройки';
        $this->page_data['page_menu']    = 'settings';

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/profile');
        $this->load->view('user/profile_line');

        if ($result['user_data'] !== false)
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
     * @param $result
     * @return void
     */
    public function coachSettings($result)
    {
        // Объединенные данные страница
        $this->page_data['title']        = 'Настройки';
        $this->page_data['page_menu']    = 'settings';

        $this->load->view('header/header', $this->page_data);
        $this->load->view('header/profile');
        $this->load->view('user/profile_line');

        if ($result['user_data'] !== false)
        {
            // Вывод страницы настроек пользователя
            $this->load->view('coach/settings/settings', $result);
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
     * @throws Exception
     */
    public function progress()
    {
        if (!is_numeric($this->user_id))
        {
            parent::pageNotFound($this->page_url);
        }

        // Получение данных анкеты из БД
        $user_all_anthrop  = $this->User_model->getAnthropometricData($this->user_id, $this->date);
        $user_last_anthrop = $this->User_model->getLastAnthropometricData($this->user_id);
        $result = array_merge($user_all_anthrop, $user_last_anthrop);

        if ($this->input->post('bt_save_anthrop', true))
        {
            // Антропометрические данные
            // Вес
            $weight = (is_numeric($this->input->post('weight', true))) ? $this->input->post('weight', true) : '';

            // Расчет и сохранение ИМТ и БСО
            parent::calcBmiBmr($this->user_id, $weight);

            // Обхват груди
            $chest = (is_numeric($this->input->post('chest', true))) ? $this->input->post('chest', true) : '';

            // Обхват талии
            $waist = (is_numeric($this->input->post('waist', true))) ? $this->input->post('waist', true) : '';

            // Обхвать ягодиц
            $buttocks = (is_numeric($this->input->post('buttocks', true))) ? $this->input->post('buttocks', true) : '';

            // Обхвать боков
            $waist_sides = (is_numeric($this->input->post('waist_sides', true))) ? $this->input->post('waist_sides', true) : '';

            // Обхвать левого бедра
            $left_hip = (is_numeric($this->input->post('left_hip', true))) ? $this->input->post('left_hip', true) : '';

            // Обхвать правого бедра
            $right_hip = (is_numeric($this->input->post('right_hip', true))) ? $this->input->post('right_hip', true) : '';

            // Обхвать левого бицепса
            $left_biceps = (is_numeric($this->input->post('left_biceps', true))) ? $this->input->post('left_biceps', true) : '';

            // Обхвать правого бицепса
            $right_biceps = (is_numeric($this->input->post('right_biceps', true))) ? $this->input->post('right_biceps', true) : '';

            $tmp_date = new DateTime($this->date);
            $today = $tmp_date->format('Y-m-d');

            if(!empty($weight) and !empty($chest) and !empty($waist) and !empty($buttocks) and !empty($waist_sides)
                and !empty($left_hip) and !empty($right_hip) and !empty($left_biceps) and !empty($right_biceps))
            {
                $result_anthrop = $this->User_model->setAnthropometricData($this->user_id, $weight, $chest, $waist, $buttocks,
                    $waist_sides, $left_hip, $right_hip, $left_biceps, $right_biceps, $today);

                //$this->session->set_userdata('type_questionnaire', 0);

                if ($result_anthrop === false)
                {
                    // Не удалось сохранить
                    $this->session->set_tempdata('message', 12, 60);
                }
                else
                {
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
            }

            header('Location: /progress');
        }

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
     * @param string $page_tab
     * @return void
     * @throws Exception
     */
    public function userQuestionnaire($page_tab)
    {
        // Если пользователь не авторизован, переход на страницу авторизации
        if (empty($this->user_id))
        {
            parent::pageNotFound($this->page_url);
        }

        $page_tabs = array('anthropometric', 'progress', 'parameters', 'condition', 'regime');
        $page_tab = (in_array($page_tab, $page_tabs)) ? $page_tab : 'anthropometric';

        // Исходная страница
        $return_url = '/questionnaire/'.$page_tab;

        // Валидация и сохранение данных анкеты в БД
        if ($this->input->post('bt_save_anthrop', true))
        {
            // Антропометрические данные
            // Вес
            $weight = (is_numeric($this->input->post('weight', true))) ? $this->input->post('weight', true) : '';

            // Расчет и сохранение ИМТ и БСО
            parent::calcBmiBmr($this->user_id, $weight);

            // Обхват груди
            $chest = (is_numeric($this->input->post('chest', true))) ? $this->input->post('chest', true) : '';

            // Обхват талии
            $waist = (is_numeric($this->input->post('waist', true))) ? $this->input->post('waist', true) : '';

            // Обхвать ягодиц
            $buttocks = (is_numeric($this->input->post('buttocks', true))) ? $this->input->post('buttocks', true) : '';

            // Обхвать боков
            $waist_sides = (is_numeric($this->input->post('waist_sides', true))) ? $this->input->post('waist_sides', true) : '';

            // Обхвать левого бедра
            $left_hip = (is_numeric($this->input->post('left_hip', true))) ? $this->input->post('left_hip', true) : '';

            // Обхвать правого бедра
            $right_hip = (is_numeric($this->input->post('right_hip', true))) ? $this->input->post('right_hip', true) : '';

            // Обхвать левого бицепса
            $left_biceps = (is_numeric($this->input->post('left_biceps', true))) ? $this->input->post('left_biceps', true) : '';

            // Обхвать правого бицепса
            $right_biceps = (is_numeric($this->input->post('right_biceps', true))) ? $this->input->post('right_biceps', true) : '';

            $tmp_date = new DateTime($this->date);
            $today = $tmp_date->format('Y-m-d');

            if(!empty($weight) and !empty($chest) and !empty($waist) and !empty($buttocks) and !empty($waist_sides)
                and !empty($left_hip) and !empty($right_hip) and !empty($left_biceps) and !empty($right_biceps))
            {
                $result_anthrop = $this->User_model->setAnthropometricData($this->user_id, $weight, $chest, $waist, $buttocks,
                    $waist_sides, $left_hip, $right_hip, $left_biceps, $right_biceps, $today);

                //$this->session->set_userdata('type_questionnaire', 0);

                if ($result_anthrop === false)
                {
                    // Не удалось сохранить
                    $this->session->set_tempdata('message', 12, 60);
                }
                else
                {
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
            }

            header('Location: /questionnaire/anthropometric');
        }
        elseif ($this->input->post('bt_save_physical_param', true))
        {
            // Пол
            $genders = array('male', 'female');
            $gender = (in_array($this->input->post('gender', true), $genders)) ? $this->input->post('gender', true) : '';

            // Дата рождения
            $b_day       = (is_numeric($this->input->post('b_day', true))) ? $this->input->post('b_day', true) : '';
            $b_mon       = (is_numeric($this->input->post('b_mon', true))) ? $this->input->post('b_mon', true) : '';
            $b_year      = (is_numeric($this->input->post('b_year', true))) ? $this->input->post('b_year', true) : '';
            $birthday    = $b_day . '.' . $b_mon . '.' . $b_year;
            $date        = DateTime::createFromFormat('d.m.Y', $birthday);
            $birthday    = ($date !== false) ? $birthday : '';
            $db_birthday = ($date !== false) ? $date->format('Y-m-d') : '';

            // Рост
            $height = (is_numeric($this->input->post('height', true))) ? $this->input->post('height', true) : '';

            // Вес
            $weight = (is_numeric($this->input->post('weight', true))) ? $this->input->post('weight', true) : '';

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

            header('Location: /questionnaire/parameters');
        }
        elseif ($this->input->post('bt_save_physical_condition', true))
        {
            // Физическое состояние
            $physical_condition = (is_numeric($this->input->post('physical_condition', true))) ? $this->input->post('physical_condition', true) : '';

            // Пульс в покое
            $pulse = (is_numeric($this->input->post('pulse', true))) ? $this->input->post('pulse', true) : '';

            // Цель занятий
            $training_goal = (is_numeric($this->input->post('training_goal', true))) ? $this->input->post('training_goal', true) : '';

            // История тренировок
            $sports_history = mb_substr(strip_tags($this->input->post('sports_history', true)), 0, 1000);

            // Перечень травм и заболеваний
            $injuries_diseases = mb_substr(strip_tags($this->input->post('injuries_diseases', true)), 0, 1000);

            // Вредные привычки
            $bad_habits = mb_substr(strip_tags($this->input->post('bad_habits', true)), 0, 255);

            // Сохранение данных в БД
            $result_quest = $this->User_model->setPhysicalCondition($this->user_id, $physical_condition, $pulse,
                $sports_history, $injuries_diseases, $training_goal, $bad_habits, $this->date);

            //$this->session->set_userdata('type_questionnaire', 2);

            if ($result_quest === false) {
                // Не удалось сохранить
                $this->session->set_tempdata('message', 12, 60);
            }
            else {
                // Сохрано
                $this->session->set_tempdata('message', 10, 60);
            }

            header('Location: /questionnaire/condition');
        }
        elseif ($this->input->post('bt_save_daily_regime', true))
        {
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

            header('Location: /questionnaire/regime');
        }
        elseif ($this->input->post('bt_pay_premium', true) and $this->input->post('cb_offer', true) and
            (!empty($this->user_id) or (empty($this->user_id) and $this->input->post('cb_politics', true))))
        {
            $order_id  = (is_numeric($this->input->post('ord_id', true))) ? $this->input->post('ord_id', true) : null;

            // Вариант оплаты (полный, разделить на месяцы)
            $s_payment_options = 'partial_payment';
            // Способ оплаты
            $s_payment_method = 'bank_card';
            // Данные для способа оплаты
            $i_phone = $this->input->post('i_phone', true);
            $i_login = $this->input->post('i_login', true);
            $i_email = $this->input->post('email', true);
            $i_name  = $this->input->post('name', true);

            parent::buyPremium($s_payment_options, $s_payment_method, $i_phone, $i_login, $i_email, $i_name, $return_url, $order_id);
        }

        // Получение данных анкеты из БД
        $user_quest_data     = $this->User_model->getQuestionnaireData($this->user_id);
        $user_anthrop_data   = $this->User_model->getLastAnthropometricData($this->user_id);
        $user_all_anthrop    = $this->User_model->getAnthropometricData($this->user_id, $this->date);
        $result['user_data'] = array_merge($user_quest_data['user_data'], $user_anthrop_data, $user_all_anthrop);
        $result['user_name'] = $this->session->user['name'];

        // Объединенные данные страница
        $this->page_data['title']        = 'Анкета';
        $this->page_data['page_menu']    = 'questionnaire';
        $this->page_data['page_submenu'] = $page_tab;

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
            $genders = array('male', 'female');
            $gender = (in_array($this->input->post('gender', true), $genders)) ? $this->input->post('gender', true) : '';

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
     * @param null $user_id
     */
    public function getAnthropometricData($user_id = null)
    {
        $user_id = (!empty($user_id) and is_numeric($user_id)) ? $user_id : $this->user_id;

        $result = $this->User_model->getAnthropometricData($user_id, $this->date);

        echo json_encode($result, JSON_NUMERIC_CHECK);
    }

    /**
     * АП. Вывод списка пользователей
     *
     * @param string $users_category
     * @return void
     */
    public function users($users_category = 'auth')
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3 or $this->session->user['blocked'] == 1) {
            parent::pageNotFound($this->page_url);
        }

        $search_text = null;
        $users_categories = array('auth', 'bought');
        $users_category = (in_array($users_category, $users_categories)) ? $users_category : 'auth';

        if($this->input->post('bt_users_search', true))
        {
            $search_text = mb_substr(strip_tags($this->input->post('search', true)), 0, 255);
        }

        $result = $this->User_model->getUsersData($users_category, $search_text);

        // Объединенные данные страница
        $this->page_data['title']         = 'АП - Пользователи';
        $this->page_data['page_menu']     = 'users';
        $this->page_data['page_submenu']  = 'a_users';
        $this->page_data['page_2submenu'] = ($users_category == 'bought') ? 'eu_bought' : 'eu_auth';
        $this->page_data['search_text']   = $search_text;

        $this->load->view('header/header_admin', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('user/users', $result);
        $this->load->view('footer/footer');
    }

    /**
     * AJAX. Пагинация пользователей
     */
    public function getSearchUsers()
    {
        $categories = array('users', 'admins', 'coaches', 'archive');
        $subcategories = array('auth', 'bought');

        $users_category = ($this->input->post('category', true) and in_array($this->input->post('category', true), $categories))
            ? $this->input->post('category', true)
            : null;
        $subcategory = ($this->input->post('subcategory', true) and in_array($this->input->post('subcategory', true), $subcategories))
            ? $this->input->post('subcategory', true)
            : null;
        $search_text = $this->input->post('search', true) ? mb_substr(strip_tags($this->input->post('search', true)), 0, 255) : null;
        $first_id = ($this->input->post('first_id', true) and is_numeric($this->input->post('first_id', true)))
            ? $this->input->post('first_id', true)
            : null;
        $last_id = ($this->input->post('last_id', true) and is_numeric($this->input->post('last_id', true)))
            ? $this->input->post('last_id', true)
            : null;

        $result['users']      = '';
        $result['pagination'] = '';
        $result['sql']        = '';
        $result['sql_result'] = '';

        if($users_category == 'users')
        {
            $result_users = $this->User_model->getUsersData($subcategory, $search_text, $first_id, $last_id);
        }
        elseif($users_category == 'archive')
        {
            $result_users = $this->User_model->getUsersArchive($search_text, $first_id, $last_id);
        }

        if (!empty($result_users['users']))
        {
            foreach ($result_users['users'] as $u)
            {
                ob_start();
                include('./app_fold/views/user/users_item.php');
                $user_item = ob_get_contents();
                ob_end_clean();
                $result['users'] .= $user_item;

            }
            unset($product);

            $first_id = !empty($result_users['first_id']) ? $result_users['first_id'] : '';
            $last_id  = !empty($result_users['last_id']) ? $result_users['last_id'] : '';
            $category_id = $users_category;
            $subcategory_id = $subcategory;

            ob_start();
            include_once('./app_fold/views/pagination.php');
            $pagination = ob_get_contents();
            ob_end_clean();

            $result['pagination'] = $pagination;
        }
        else
        {
            $result['users'] = "false";
        }

        //echo $result;
        echo json_encode($result, JSON_NUMERIC_CHECK);
    }

    /**
     * АП. Форма редактирования и сохранение изменений настроек тренера
     *
     * @param $user_id
     * @param $page_type
     * @return void
     * @throws Exception
     */
    public function userASettings($user_id, $page_type = 'settings')
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3 or $this->session->user['blocked'] == 1) {
            parent::pageNotFound($this->page_url);
        }

        $page_types = array('settings', 'personal', 'add_course');

        $this->load->model('Notification_model');
        $this->load->model('Course_model');
        $this->load->model('Store_model');

        $user = $this->User_model->getUserSettingsData($user_id);
        $user_courses = array();
        $courses_data = array();
        $auth_data = array();
        if (!empty($user['user_data']) and $user['user_data']['user_deleted'] == 0)
        {
            $user_courses    = $this->Course_model->getUserCourses($user_id, $this->date, 'active'); // Выборка курсов пользователя
            $courses_data    = $this->Store_model->getUserCoursesOrder($user_id, $user_courses);

            $this->load->model('Authorization_model');
            $auth_data = $this->Authorization_model->getUserAuthorizationData($user_id);
        }
        elseif(!empty($user['user_data']) and $user['user_data']['user_deleted'] == 1)
        {
            header('Location: /administration/user/archive/'.$user_id);
        }

        $result = array_merge($user_courses, $user, $courses_data, $auth_data);
        $user_data = $result['user_data'];

        if ($this->input->post('bt_save_user_settings', true) and is_numeric($user_id))
        {
            // Валидация E-mail
            if (!empty($this->input->post('email', true))
                && filter_var($this->input->post('email', true), FILTER_VALIDATE_EMAIL))
            {
                $email = $this->input->post('email', true);
            }
            else {
                $email = $user_data['user_email'];
            }

            // Имя пользователя
            $name = mb_substr(strip_tags($this->input->post('name', true)), 0, 255);

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
            $res_up = $this->User_model->setAUserSettingsData($user_id, $email, $name, $path_avatar, $this->date);

            if ($res_up === true) {
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
            $res_up = $this->User_model->blockUser($user_id, $this->date);

            if ($res_up === true) {
                // Сохранено
                $this->session->set_tempdata('message', 16, 60);
            } else {
                // Не сохранено
                $this->session->set_tempdata('message', 17, 60);
            }

            header('Location: /administration/user/'.$user_id);
        }
        elseif ($this->input->post('bt_unblock_user', true) and is_numeric($user_id))
        {
            $res_up = $this->User_model->unblockUser($user_id, $this->date);

            if ($res_up === true) {
                // Сохранено
                $this->session->set_tempdata('message', 18, 60);
            } else {
                // Не сохранено
                $this->session->set_tempdata('message', 19, 60);
            }

            header('Location: /administration/user/'.$user_id);
        }
        elseif ($this->input->post('bt_delete_avatar', true) and is_numeric($user_id))
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
        elseif ($this->input->post('bt_save_data', true) and is_numeric($user_id))
        {
            $res_gb = false;
            $res_cd = false;

            // Пол
            $genders = array('male', 'female');
            $gender = (in_array($this->input->post('gender', true), $genders)) ? $this->input->post('gender', true) : '';

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
        elseif ($this->input->post('bt_reset_password', true) and is_numeric($user_id))
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

                    $send_res = parent::sendEmail(3, $email, $system_message);

                    if($send_res === true)
                    {
                        // Письмо отправлено
                        $this->session->set_tempdata('message', 46, 60);
                    }

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
        elseif ($this->input->post('bt_delete_user', true) and is_numeric($user_id))
        {
            $tmp_date = new DateTime($this->date);
            $in_a_month = ($tmp_date !== false) ? $tmp_date->add(new DateInterval('P30D')) : false;
            $delete_date = ($in_a_month !== false) ? $in_a_month->format('Y-m-d') : '';

            $up_d = $this->User_model->temporarilyDeleteUser($user_id, $this->user_id, $delete_date);

            if ($up_d['result'] === true)
            {
                // Отправка уведомления на почту пользователя
                parent::sendEmail(13, $up_d['user_email']);

                // Пользователь удален
                $this->session->set_tempdata('message', 179, 60);

                header('Location: /administration/user/archive/'.$user_id);
            }
            else
            {
                // Пользователь не удален
                $this->session->set_tempdata('message', 180, 60);

                header('Location: /administration/user/'.$user_id);
            }
        }
        elseif ($this->input->post('bt_on_behalf_login', true) and is_numeric($user_id))
        {
            $this->load->model('Authorization_model');
            // Поиск пользователя в БД
            $search_user = $this->Authorization_model->authorizationOnBehalfUser($user_id);

            if ($search_user !== false and is_array($search_user))
            {
                $login_from = $this->session->user['id'];

                // Завершение текущей сессии
                if ($this->session->user['auth_via'] == 'native')
                {
                    $this->Authorization_model->userLogout($this->session->user['id'], $this->date);
                }
                else
                {
                    $this->Authorization_model->userSocialLogout($this->session->user['auth_via'], $this->session->user['social_id'], $this->date);
                }

                // Создание новой сессии
                $search_user['user_images'] = (!empty($search_user['user_image'])) ? $search_user['user_image'] : $search_user['user_soc_image'];

                parent::updateSession($search_user, '', 'native', 0, $this->date, $login_from);

                // После успешной авторизации переход на страницу тренера
                header('Location: /profile/'.$search_user['user_id']);
            }
            else
            {
                header('Location: /administration/user/'.$user_id);
            }
        }
        elseif ($this->input->post('bt_e_activate_send_again', true) and is_numeric($user_id))
        {
            $this->load->model('Authorization_model');

            $res_check = $this->Authorization_model->checkActivateEmail($user_id, $this->date);

            if(is_array($res_check))
            {
                if($res_check['availability_send_email'] === true)
                {
                    self::sendEActivateEmail($res_check['user_email'], $res_check['activate_code']);

                    $this->Authorization_model->setResendingActivateEmailDate($user_id, $this->date);

                    // Данные о смене были сохранены
                    $this->session->set_tempdata('message', 202, 60);
                }
            }
            header('Location: /administration/user/'.$user_id);

        }
        elseif ($this->input->post('bt_e_change_email_send_again', true) and is_numeric($user_id))
        {
            $this->load->model('Authorization_model');

            $res_check = $this->Authorization_model->checkChangingEmail($user_id, $this->date);

            if(is_array($res_check))
            {
                if($res_check['availability_send_email'] === true)
                {
                    self::sendEChangeEmail($res_check['user_email'], $res_check['activate_code'], $res_check['idempotent']);

                    $this->Authorization_model->setResendingChangeEmailDate($user_id, $this->date);

                    // Данные о смене были сохранены
                    $this->session->set_tempdata('message', 198, 60);
                }
            }
            header('Location: /administration/user/'.$user_id);
        }
        elseif ($this->input->post('bt_activate_account', true) and is_numeric($user_id))
        {
            $this->load->model('Authorization_model');
            $res_up = $this->Authorization_model->activateAccount($user_id, $this->date);

            if ($res_up === true) {
                // Сохранено
                $this->session->set_tempdata('message', 10, 60);
            } else {
                // Не сохранено
                $this->session->set_tempdata('message', 3, 60);
            }

            header('Location: /administration/user/'.$user_id);
        }
        elseif ($this->input->post('bt_buy_course', true) and $this->input->post('cb_offer', true))
        {
            $course_id = (is_numeric($this->input->post('crs_id', true))) ? $this->input->post('crs_id', true) : null;
            $order_id  = (is_numeric($this->input->post('ord_id', true))) ? $this->input->post('ord_id', true) : null;
            $return_url = '/administration/user/'.$user_id.'/add_course';

            if(!empty($course_id))
            {
                // Данные курса
                $course = $this->Course_model->getAvailableCourse($course_id, $this->date);
                $course_coaches = $this->Course_model->getCourseCoachesId($course_id);
                $db_data = $course['course'];
                // Выбранный тренер
                $id_coach = $this->input->post('user_coach', true);
                // Вариант оплаты (полный, разделить на месяцы)
                $s_payment_options = $this->input->post('s_payment_options', true);
                // Способ оплаты
                $s_payment_method = $this->input->post('s_payment_method', true);
                // Данные для способа оплаты
                $i_phone = $this->input->post('i_phone', true);
                $i_login = $this->input->post('i_login', true);
                $i_email = $this->input->post('email', true);
                $i_name  = $this->input->post('name', true);
                // Введенный промокод
                $i_promocode = $this->input->post('promocode', true);

                $user_email = $user_data['user_email'];

                parent::buyCourse($course_id, $db_data, $course_coaches, $id_coach, $s_payment_options,
                    $s_payment_method, $i_phone, $i_login, $i_email, $i_name, $i_promocode, $return_url, $order_id, $user_id, $user_email);
            }
        }

        // Уведомления пользователя
        // Пользователь заблокирован
        if($result['user_data']['user_blocked'] == 1)
        {
            $notification = $this->Notification_model->getNotification(16);

            $this->page_data['user_notification']['blocked']['text'] = $notification['notification']['text'];
        }
        // Не указан email
        if($result['user_data']['user_email_empty'] === true)
        {
            $notification = $this->Notification_model->getNotification(205);

            $this->page_data['user_notification']['empty_email']['text'] = $notification['notification']['text'];
        }
        // Неактивирован аккаунт
        if($result['user_data']['user_activated'] == 0)
        {
            $notification = $this->Notification_model->getNotification(218);

            $this->page_data['user_notification']['not_activated']['text'] = $notification['notification']['text'];
        }

        // Объединенные данные страница
        $this->page_data['title']         = 'АП - Редактирование данных пользователя';
        $this->page_data['page_menu']     = 'users';
        $this->page_data['page_submenu']  = 'a_users';
        $this->page_data['page_2submenu'] = (in_array($page_type, $page_types)) ? $page_type : '';
        $this->page_data['outsider']      = true;

        $this->load->view('header/header_admin', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('user/settings/user_settings', $result);
        $this->load->view('footer/footer');
    }

    /**
     * Архив удаленных пользователей.
     *
     * @param null $user_id
     */
    public function archive($user_id = null)
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 3 or $this->session->user['blocked'] == 1) {
            parent::pageNotFound($this->page_url);
        }

        if(empty($user_id) or !is_numeric($user_id))
        {
            self::usersArchive();
        }
        elseif(is_numeric($user_id))
        {
            self::userArchive($user_id);
        }
    }

    /**
     * Список удаленных пользователей
     */
    protected function usersArchive()
    {
        $search_text = null;

        if($this->input->post('bt_users_search', true))
        {
            $search_text = mb_substr(strip_tags($this->input->post('search', true)), 0, 255);
        }

        $result = $this->User_model->getUsersArchive($search_text);

        // Объединенные данные страница
        $this->page_data['title']         = 'АП - Удаленные пользователи';
        $this->page_data['page_menu']     = 'users';
        $this->page_data['page_submenu']  = 'a_users_archive';
        $this->page_data['page_2submenu'] = 'archive';

        $this->load->view('header/header_admin', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('user/users', $result);
        $this->load->view('footer/footer');
    }

    /**
     * Просмотр данных, удаленных пользователей
     *
     * @param $user_id
     * @throws Exception
     */
    protected function userArchive($user_id)
    {
        $user = $this->User_model->getUserSettingsData($user_id, 1);
        $user_data = (!empty($user['user_data'])) ? $user['user_data'] : null;

        if ($this->input->post('bt_restore_user', true))
        {
            $idempotent = password_hash($this->date, PASSWORD_DEFAULT);

            $set_restore = $this->User_model->setRestoreUserAccount($user_id, $idempotent);

            if ($set_restore === true)
            {
                // Отправка уведомления на почту пользователя
                $system_message['text']  = '<b><a href="https://superbody.pro/account/restore?e=' . $user_data['user_email'] . '&ac=' . $user_data['user_activate_code'] . '&i=' . $idempotent
                    . '" style="display: inline-block; width:100%; text-align:center; padding:0; margin:0">';
                $system_message['text']  .= 'Восстановить аккаунт';
                $system_message['text']  .= '</a></b>';

                parent::sendEmail(18, $user_data['user_email'], $system_message);

                // Письмо отправлено
                $this->session->set_tempdata('message', 194, 60);

                // Пользователь восстановлен
                //$this->session->set_tempdata('message', 185, 60);

                $user_types    = array('user' => 1, 'coach' => 2, 'admin' => 3);
                $user_type     = array_search($user_data['user_type'], $user_types);

                header('Location: /administration/user/archive/'.$user_id);
            }
            else
            {
                // Пользователь не восстановлен
                $this->session->set_tempdata('message', 186, 60);

                header('Location: /administration/user/archive/'.$user_id);
            }
        }
        elseif($this->input->post('bt_delete_user', true))
        {
            $tmp_date = new DateTime($this->date);
            $today = ($tmp_date !== false) ? $tmp_date->format('Y-m-d') : null;

            $del_user = $this->User_model->deleteUser($user_id, $today);

            if ($del_user === true)
            {
                // Отправка уведомления на почту пользователя
                parent::sendEmail(19, $user_data['user_email']);

                // Письмо отправлено
                $this->session->set_tempdata('message', 179, 60);
            }

            header('Location: /administration/users/archive');
        }

        // Объединенные данные страница
        $this->page_data['title']         = 'АП - Редактирование данных пользователя';
        $this->page_data['page_menu']     = 'users';
        $this->page_data['page_submenu']  = 'a_users_archive';

        $this->load->view('header/header_admin', $this->page_data);
        $this->load->view('header/admin');
        $this->load->view('user/settings/user_settings_view', $user);
        $this->load->view('footer/footer');
    }

    /**
     * Удаление пользователей и их данных из БД
     * @throws Exception
     */
    public function deleteUsers()
    {
        log_message('debug', __METHOD__.':'.__LINE__.' Script execution!');

        $tmp_date = new DateTime($this->date);
        $today = ($tmp_date !== false) ? $tmp_date->format('Y-m-d') : '';

        if(!empty($today))
        {
            $this->User_model->deleteUsers($today);
        }
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
        $search_text = (!is_numeric($this->input->post('search_text', true)) and !empty(mb_substr(strip_tags($this->input->post('search_text', true)), 0, 255)))
            ? ('*'.mb_substr(strip_tags($this->input->post('search_text', true)), 0, 255).'*')
            : null;
        $search_id = (is_numeric($this->input->post('search_text', true))) ? $this->input->post('search_text', true) : null;

        if (!empty($search_text) or !empty($search_id)) {
            $result = $this->User_model->searchUsers($search_text, $search_id);
        }

        echo $result;
    }

    /**
     * AJAX поиск пользователей
     *
     * @return void
     */
    public function searchCoachUsers()
    {
        // Если пользователь не авторизован, вывод страницы 404
        if (empty($this->user_id) or $this->session->user['type'] != 2 or $this->session->user['blocked'] == 1) {
            parent::pageNotFound($this->page_url);
        }

        $result      = '';
        $search_text = (!is_numeric($this->input->post('search_text', true)) and !empty(mb_substr(strip_tags($this->input->post('search_text', true)), 0, 255)))
            ? ('*'.mb_substr(strip_tags($this->input->post('search_text', true)), 0, 255).'*')
            : null;
        $search_id = (is_numeric($this->input->post('search_text', true))) ? $this->input->post('search_text', true) : null;

        if (!empty($search_text) or !empty($search_id)) {
            $result = $this->User_model->searchUsers($search_text, $search_id);
        }

        echo $result;
    }

    /**
     * Отправка эл. письма по смене email пользователю
     *
     * @param $user_email
     * @param $activate_code
     * @param $idempotent
     */
    protected function sendEChangeEmail($user_email, $activate_code, $idempotent)
    {
        $system_message['text']  = '<b><a href="https://superbody.pro/email/change?e=' . $user_email . '&ac=' . $activate_code . '&i=' . $idempotent
            . '" style="display: inline-block; width:100%; text-align:center; padding:0; margin:0">';
        $system_message['text']  .= 'Сменить email';
        $system_message['text']  .= '</a></b>';

        // Отправка письма с подтверждением смены email на текущий email.
        parent::sendEmail(15, $user_email, $system_message);
    }

    /**
     * Отправка эл. письма по смене email пользователю
     *
     * @param $user_email
     * @param $activate_code
     */
    protected function sendEActivateEmail($user_email, $activate_code)
    {
        $system_message['text'] = '<b><a href="https://superbody.pro/activate?e=' . $user_email . '&ac=' . $activate_code
            . '" style="display: inline-block; width:100%; text-align:center; padding:0; margin:0">';
        $system_message['text'] .= 'Активировать';
        $system_message['text'] .= '</a></b>';

        parent::sendEmail(17, $user_email, $system_message);
    }

    /**
     * Cron. Проверка завершения действия премиум аккаунта.
     * @throws Exception
     */
    public function checkExpiredPremiumAccount()
    {
        log_message('debug', __METHOD__.':'.__LINE__.' Script execution!');

        $tmp_date = new DateTime($this->date);
        $today = ($tmp_date !== false) ? $tmp_date->format('Y-m-d') : '';

        if(!empty($today))
        {
            $this->User_model->checkExpiredPremiumAccount($today);
        }
    }
}