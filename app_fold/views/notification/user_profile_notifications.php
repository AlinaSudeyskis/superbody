<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//$user_notification = null;
if(!empty($user_notification) or !empty($course_notification)):?>
    <div class="content_block new_content_block notifications_block_wrap">
        <div class="content_block_h parent">
            <h3>Уведомления</h3>
            <div class="content_block_h_buts">
                <div class="content_block_h_slide kurs_slide"></div>
                <div class="content_block_h_close"></div>
            </div>
        </div>
        <div class="kurs_block_val notifications_block">
            <?php
            $notif_block_h    = '';
            $h3_info          = '';
            $course_blocked   = false;
            $course_ends      = false;
            $course_finished  = false;
            $count_ends_down  = false;
            $workout_missed   = false;
            $free_weeks_over  = false;
            $empty_email      = false;
            $waiting_payments = false;
            $extends          = array();

            // Не указан email
            if(!empty($user_notification['empty_email'])):
                $empty_email = true;
                $notif_block_h = '<a href="/settings">Настройки</a>';
                $h3_info = $user_notification['empty_email']['text'];
                include('notification_block.php');
                $empty_email = false;
            endif;
            // Не активирован аккаунт и есть непотвержденные платежи
            if(!empty($user_notification['waiting_payments'])):
                $waiting_payments = true;
                $notif_block_h = '<a href="/settings">Настройки</a>';
                $h3_info = $user_notification['waiting_payments']['text'];
                include('notification_block.php');
                $waiting_payments = false;
            endif;
            // Аккаунт пользователя заблокирован
            if(!empty($user_notification['blocked'])):
                $h3_info = $user_notification['blocked']['text'];
                include('notification_block.php');
            endif;
            // Пользователь вводил антропометрические данные более двух недель назад
            if(!empty($user_notification['anthrop'])):
                $notif_block_h = '<a href="/questionnaire">Ввести параметры тела</a>';
                $h3_info       = $user_notification['anthrop']['text'];
                include('notification_block.php');
            endif;
            // Уведомления вывода курсов в календаре
            if(!empty($display_courses)):
                $notif_block_h = '<a href="/profile/courses">Мои курсы</a>';
                $h3_info       = $display_courses['text'];
                include('notification_block.php');
            endif;
            // Уведомления курсов
            if(!empty($course_notification)):
                $h3_info         = '';
                $non_started     = false;
                $course_blocked  = false;
                $course_ends     = false;
                $course_finished = false;
                $workout_missed  = false;

                foreach($course_notification as $user_course_id => $notif):
                    if(is_numeric($user_course_id) and (!empty($notif['course_blocked']) or !empty($notif['course_ends'])
                        or (!empty($notif['course_finished']) and !empty($notif['course_finished']['extends']))
                        or !empty($notif['workout_missed']) or !empty($notif['non_started']) or !empty($notif['free_weeks_over']))):
                        $notif_block_h   = '<a href="/profile/course/' . $user_course_id . '">' . $notif['course_name'] . '</a>';

                        // Курс заморожен (оплата не прошла)
                        if(!empty($notif['course_blocked'])):
                            $course_blocked      = true;
                            $course_blocked_info = $notif['course_blocked']['text'];
                            include('notification_block.php');
                            $course_blocked      = false;
                        endif;

                        // Курс заканчивается (обратный отсчет) + курсы продления
                        if(!empty($notif['course_ends'])):
                            $course_ends           = true;
                            $count_ends_down       = true;
                            $course_ends_info      = $notif['course_ends']['text'];
                            $course_ends_extends   = $notif['course_ends']['extends'];
                            $course_ends_countdown = $notif['course_ends']['date_countdown'];
                            include('notification_block.php');
                            $course_ends           = false;
                            $count_ends_down       = false;
                        endif;

                        // Курс закончился + курсы продления
                        if(!empty($notif['course_finished']) and !empty($notif['course_finished']['extends'])):
                            $course_finished         = true;
                            $course_finished_info    = $notif['course_finished']['text'];
                            $course_finished_extends = $notif['course_finished']['extends'];
                            include('notification_block.php');
                            $course_finished         = false;
                        endif;

                        // Пропущена тренировка на этой неделе
                        if(!empty($notif['workout_missed'])):
                            $workout_missed      = true;
                            $notif_block_h       = '<a href="#" id="wo-m">Перенести тренировку</a>';
                            $workout_missed_info = $notif['workout_missed']['text'];
                            include('notification_block.php');
                            $workout_missed      = false;
                        endif;

                        // Неначатые курсы
                        if(!empty($notif['non_started'])):
                            $non_started        = true;
                            $non_started_course = $notif['non_started'];
                            $non_started_info   = $notif['non_started']['text'];
                            include('notification_block.php');
                            $non_started = false;
                        endif;

                        // Закончились бесплатные недели
                        if(!empty($notif['free_weeks_over'])):
                            $free_weeks_over        = true;
                            $free_weeks_over_course = $notif['free_weeks_over'];
                            $free_weeks_over_info   = $notif['free_weeks_over']['text'];
                            include('notification_block.php');
                            $free_weeks_over = false;
                        endif;
                    endif;
                endforeach;
                unset($notif);
                unset($user_course_id);

                // Неначатые курсы
                /*foreach($course_notification as $key => $notif):
                    $h3_info = '';
                    $notif_block_h = '';
                    if($key == 'non_started' and !empty($key)) :
                        $non_started_info = '';
                        $non_started      = true;
                        $non_started_courses = array();

                        foreach($notif as $uc_id => $notif_course):
                            $non_started_courses[$uc_id] = $notif_course;
                            if(empty($non_started_info)):
                                $non_started_info = $notif_course['text'];
                            endif;
                        endforeach;
                        unset($notif_course);

                        include('notification_block.php');
                        $non_started = false;
                    endif;
                endforeach;
                unset($notif);
                unset($user_course_id);*/
            endif;?>
        </div>
    </div>
<?php endif; ?>
