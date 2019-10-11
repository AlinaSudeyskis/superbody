<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$breadcrumbs = array('/admin' => $user_data['user_name']);
$margin_0 = 'style="margin:0;"';
include_once('./app_fold/views/breadcrumb.php');?>
<div id="content" class="container">
    <div class="row">
        <div class="col-lg-2 left_sidebar">
            <?php if ($user_session['type'] == 2):
                include_once('./app_fold/views/coach/coach_menu.php');
            else:
                include_once('./app_fold/views/user/user_menu.php');
            endif;?>
        </div><!-- left_sidebar -->
        <div class="col-lg-10 content_col">
            <?php
            // Уведомления
            include_once('./app_fold/views/notification/user_profile_notifications.php');?>
            <div class="content_block new_content_block">
                <div class="content_block_container_wrap">
                    <div class="content_block_h parent">
                        <h3><?php echo $title; ?></h3>
                    </div>
                </div>
                <div class="kurs_block_val">
                    <div class="tren_prof_page_block parent">
                        <div class="tren_prof_page_img_wrap">
                            <div class="tren_prof_page_img"><?php if (!empty($user_data['image'])) :?><img src="<?php echo $user_data['image'];?>" alt=""><?php endif;?></div>
                            <?php
                            $split_name['name']    = '';
                            $split_name['surname'] = '';
                            if (!empty($user_data['name'])):
                                $split = explode(" ", $user_data['name']);
                                $split_name['name']    = !empty($split[0]) ? $split[0] : $user_data['email'];
                                $split_name['surname'] = !empty($split[1]) ? $split[1] : '';
                            endif;?>
                            <div class="tren_prof_page_name"><?php echo $split_name['name'];?></div>
                            <div class="tren_prof_page_surname"><?php if (!empty($split_name['surname'])) { echo $split_name['surname']; }?></div>
                            <div class="tren_prof_page_soc disabled">
                                <a href=""><i class="fab fa-vk" aria-hidden="true"></i></a>
                                <a href=""><i class="fab fa-facebook-f" aria-hidden="true"></i></a>
                                <a href=""><i class="fab fa-instagram" aria-hidden="true"></i></a>
                            </div>
                        </div>
                        <div class="tren_prof_page_cont">
                            <div class="tren_prof_page_stat"></div>
                            <div class="tren_prof_page_txt"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- content_col -->
    </div>
</div><!-- content -->