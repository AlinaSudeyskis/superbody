<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="content" class="container">
    <?php $breadcrumbs = array('/couches' => 'Тренеры', '/user' => $user_data['user_name']);
    include_once('./app_fold/views/breadcrumb.php');?>
    <div class="row">
        <div class="col-lg-2 left_sidebar">
            <?php if (!empty($user_session)):
                if ($user_session['type'] == 2):
                    include_once('./app_fold/views/couch/couch_menu.php');
                else:
                    include_once('./app_fold/views/user/user_menu.php');
                endif;
            endif;?>
        </div><!-- left_sidebar -->
        <div class="col-lg-10 content_col">
            <?php
            // Уведомления
            include_once('./app_fold/views/notification/user_profile_notifications.php');
            $profile_title = $title;
            include_once('./app_fold/views/user/profile/profile_info.php');?>
        </div><!-- content_col -->
    </div>
</div><!-- content -->