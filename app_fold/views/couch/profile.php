<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="content" class="container">
    <div class="row">
        <div class="col-lg-2 left_sidebar">
            <?php include_once('./app_fold/views/couch/couch_menu.php');?>
        </div><!-- left_sidebar -->
        <div class="col-lg-10 content_col">
            <?php
            // Уведомления
            include_once('./app_fold/views/notification/user_profile_notifications.php');
            // Краткая информация
            include_once('./app_fold/views/couch/profile/short_info.php');
            // Информация профиля
            include_once('./app_fold/views/couch/profile/profile_info.php');
            // Блог
            include_once('./app_fold/views/blog/posts/user_posts_item.php');
            // Портфолио
            include_once('./app_fold/views/couch/portfolio/portfolio_item.php');
            // Предлагаемые курсы
            include_once('./app_fold/views/course/offered_courses.php');
            // Активность клиентов
            include_once('./app_fold/views/couch/users_activity_item.php');?>

        </div><!-- content_col -->
    </div>
</div><!-- content -->