<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if (!empty($user_data)):
    $breadcrumbs_name = (!empty($user_data['user_name'])) ? $user_data['user_name'] : 'Пользователь №'.$user_data['user_id'];
    $breadcrumbs = array('/administration' => 'Админ. панель', '/administration/users' => 'Пользователи', '/user' => $breadcrumbs_name);
else:
    $breadcrumbs = array();
endif;
$margin_0 = 'style="margin:0;"';
include_once('./app_fold/views/breadcrumb.php');
$outsider = true;?>
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
            <?php if(!empty($user_data)): ?>
                <?php include_once('./app_fold/views/user/outsider_profile_item.php'); ?>
            <?php else: ?>
                <h3 class="info">Пользователь не найден</h3>
            <?php endif; ?>
        </div><!-- content_col -->
    </div>
</div><!-- content -->