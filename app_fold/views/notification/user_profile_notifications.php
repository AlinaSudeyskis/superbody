<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$notif_block_h   = '';
$h3_info         = '';
$course_blocked  = false;
$course_ends     = false;
$course_finished = false;
$count_ends_down = false;
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
if(!empty($course_notification)):
    $h3_info = '';

    foreach($course_notification as $user_course_id => $notif):
        if(!empty($notif['course_blocked']) or !empty($notif['course_ends']) or (!empty($notif['course_finished']) and !empty($notif['course_finished']['extends']))):
            $course_blocked  = false;
            $course_ends     = false;
            $course_finished = false;
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
            include('notification_block.php');
        endif;
    endforeach;
    unset($notif);
    unset($user_course_id);
endif;