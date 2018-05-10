<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="content" class="container">
    <div class="row">
    <div class="col-lg-2 left_sidebar">
        <?php include_once('./app_fold/views/user/user_menu.php'); ?>
    </div><!-- left_sidebar -->
    <div class="col-lg-10 content_col">
        <?php // Уведомления
        include_once('./app_fold/views/notification/user_profile_notifications.php'); ?>
        <div class="content_block new_content_block">
        <div class="content_block_h parent">
            <h3>Курс - <?php echo $course['name'];
                if($course['finished'] === true): echo '(Завершен)'; endif;?></h3>
            <div class="content_block_h_buts">
                <div class="content_block_h_slide kurs_slide"></div>
                <div class="content_block_h_close"></div>
            </div>
        </div>
        <div class="kurs_block_val">
            <?php include_once('./app_fold/views/course/user_course/menu.php');?>