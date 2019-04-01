<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$notif_block_h   = '';
$h3_info         = '';
$course_blocked  = false;
$course_ends     = false;
$course_finished = false;
$count_ends_down = false;
$workout_missed  = false;
$extends         = array();

// Аккаунт пользователя заблокирован
if(!empty($user_notification['blocked'])):
    $h3_info = $user_notification['blocked']['text'];
    include('notification_block.php');
endif;
// Пользователь вводил антропометрические данные более двух недель назад
if(!empty($user_notification['anthrop'])):
    $notif_block_h = '<a href="/anthropometric">Ввести параметры тела</a>';
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
    $h3_info = '';

    foreach($course_notification as $user_course_id => $notif):
        if(!empty($notif['course_blocked']) or !empty($notif['course_ends'])
            or (!empty($notif['course_finished']) and !empty($notif['course_finished']['extends']))
            or !empty($notif['workout_missed'])):
            $course_blocked  = false;
            $course_ends     = false;
            $course_finished = false;
            $workout_missed  = false;
            $notif_block_h   = '<a href="/profile/course/' . $user_course_id . '">' . $notif['course_name'] . '</a>';

            // Курс заморожен (оплата не прошла)
            if(!empty($notif['course_blocked'])):
                $course_blocked      = true;
                $course_blocked_info = $notif['course_blocked']['text'];
            endif;

            // Курс заканчивается (обратный отсчет) + курсы продления
            if(!empty($notif['course_ends'])):
                $course_ends           = true;
                $count_ends_down       = true;
                $course_ends_info      = $notif['course_ends']['text'];
                $course_ends_extends   = $notif['course_ends']['extends'];
                $course_ends_countdown = $notif['course_ends']['date_countdown'];
            endif;

            // Курс закончился + курсы продления
            if(!empty($notif['course_finished']) and !empty($notif['course_finished']['extends'])):
                $course_finished         = true;
                $course_finished_info    = $notif['course_finished']['text'];
                $course_finished_extends = $notif['course_finished']['extends'];
            endif;

            // Пропущена тренировка на этой неделе
            if(!empty($notif['workout_missed'])):
                $workout_missed      = true;
                $notif_block_h       = '<a href="#" id="wo-m">Перенести тренировку</a>';
                $workout_missed_info = $notif['workout_missed']['text'];
            endif;
            include('notification_block.php');
        endif;
    endforeach;
    unset($notif);
    unset($user_course_id);
endif;