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
                <div class="row user_prof_wrap">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 user_prof">
                        <?php
                        // Уведомления
                        include_once('./app_fold/views/notification/outsider_profile_notifications.php');?>
                    </div>
                </div>
                <div class="row user_prof_wrap">
                    <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12 user_prof">
                        <?php $profile_title = $title;
                        include_once('./app_fold/views/user/profile/profile_info.php'); ?>
                        <div class="content_block new_content_block">
                            <div class="notification_block_h"></div>
                        </div>
                    </div>
                    <div class="col-lg-9 col-md-9 col-sm-8 col-xs-12 user_prog">
                        <?php include_once('./app_fold/views/course/user_course/courses_progress.php'); ?>
                    </div>
                </div>
                <div class="content_block new_content_block">
                    <div class="content_block_h parent">
                        <h3>Курсы пользователя</h3>
                        <div class="content_block_h_buts">
                            <div class="content_block_h_slide kurs_slide"></div>
                            <div class="content_block_h_close"></div>
                        </div>
                    </div>
                    <div class="kurs_block_val">
                        <div class="orders_container_wrap">
                            <?php if(!empty($courses) or !empty($blocked_courses)):
                                if (!empty($courses)) :
                                    foreach ($courses as $course) :
                                        $blocked = '';
                                        include('./app_fold/views/course/user_course/course_item.php');
                                    endforeach;
                                    unset($course);
                                endif;
                                if (!empty($blocked_courses)) :
                                    foreach ($blocked_courses as $course) :
                                        $blocked = '(Заблокирован)';
                                        include('./app_fold/views/course/user_course/course_item.php');
                                    endforeach;
                                    unset($course);
                                endif;
                            else:?>
                                <h3 class="info">Информация не найдена</h3>
                            <?php endif;?>
                        </div>

                        <script>
                            $('.tren_block.tren_order').slick({
                                dots: false,
                                infinite: true,
                                arrows: false,
                                speed: 300,
                                autoplay: true,
                                slidesToShow: 1,
                                slidesToScroll: 1
                            });
                        </script>
                        <?php include_once('./app_fold/views/pagination.php');?>
                    </div>
                </div>
            <?php else: ?>
                <h3 class="info">Пользователь не найден</h3>
            <?php endif; ?>
        </div><!-- content_col -->
    </div>
</div><!-- content -->