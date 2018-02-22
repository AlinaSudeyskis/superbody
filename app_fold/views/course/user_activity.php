<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="content" class="container">
    <div class="row">
        <div class="col-lg-2 left_sidebar">
            <?php include_once('./app_fold/views/admin/admin_menu.php');?>
        </div><!-- left_sidebar -->
        <div class="col-lg-10 content_col">
            <a href="/administration/course/new">Добавить</a><br/>
            <a href="/administration/course/<?php echo $course_id;?>/clients" class="menu_border">Активность клиентов</a><br/><br/>
            <a href="/profile/<?php echo $user_data['id'];?>"><?php if (!empty($user_data['name'])) { echo $user_data['name']; } else { echo $user_data['email']; }?></a>
            <?php if (!empty($user_weight) or !empty($user_chest) or !empty($user_waist) or !empty($user_buttocks) or !empty($user_waist_sides)
                or !empty($user_right_hip) or !empty($user_left_hip) or !empty($user_right_biceps) or !empty($user_left_biceps)) :
                include_once('./app_fold/views/user/questionnaire/anthropometric_info.php');
            endif;
            if (!empty($data)) :
                include_once('./app_fold/views/user/questionnaire/charts.php');
            endif;?>
        </div><!-- content_col -->
    </div>
</div><!-- content -->

