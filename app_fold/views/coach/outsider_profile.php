<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$user_name = (!empty($user_data['user_name'])) ? $user_data['user_name'] : 'Страница тренера';
$breadcrumbs = array('/coaches' => 'Тренеры', '/coach' => $user_name);
$margin_0 = 'style="margin:0;"';
include_once('./app_fold/views/breadcrumb.php');?>
<div id="content" class="container">
    <div class="row">
        <div class="col-lg-2 left_sidebar">
            <?php if (!empty($user_session)):
                if ($user_session['type'] == 2):
                    include_once('./app_fold/views/coach/coach_menu.php');
                else:
                    include_once('./app_fold/views/user/user_menu.php');
                endif;
            endif;?>
        </div><!-- left_sidebar -->
        <div class="col-lg-10 content_col">
            <?php
            // Уведомления
            include_once('./app_fold/views/notification/user_profile_notifications.php');
            // Краткая информация
            include_once('./app_fold/views/coach/profile/short_info.php');
            // Информация профиля
            include_once('./app_fold/views/coach/profile/profile_info.php');
            // Блог тренера
            if (!empty($posts)) :
                include_once('./app_fold/views/blog/posts/user_posts_item.php');
            endif;
            // Портфолио
            if (!empty($portfolio)) :
                include_once('./app_fold/views/coach/portfolio/portfolio_item.php');
            endif;
            // Курсы тренера
            include_once('./app_fold/views/course/coaches_courses.php');?>
        </div><!-- content_col -->
    </div>
</div><!-- content -->