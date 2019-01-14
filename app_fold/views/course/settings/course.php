<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="content" class="container">
    <div class="row">
        <div class="col-lg-2 left_sidebar">
            <?php include_once('./app_fold/views/admin/admin_menu.php');?>
        </div><!-- left_sidebar -->
        <div class="col-lg-10 content_col">
            <div class="content_block new_content_block ovv">
                <div class="content_block_container_wrap">
                    <div class="content_block_container">
                        <div class="content_block_h new_content_block_h parent">
                            <h3><?php echo $course['name']?></h3>
                            <?php include_once('./app_fold/views/course/settings/course_buts.php');?>
                        </div>
                        <?php include_once('./app_fold/views/course/settings/course_menu.php');
                        if ($page_submenu == 'video'):
                            include_once('./app_fold/views/course/settings/course_video_menu.php');
                        endif;?>
                    </div>
                </div>
                <div class="kurs_block_val">
                    <div class="anketa_block_cont">
                        <?php if ($page_submenu == 'settings' and !empty($course)):?>
                            <form action="" class="edit_kurs_form" id="1kurs_form" method="post" enctype="multipart/form-data">
                                <div class="admin_form_buts_wrap_container">
                                    <div class="admin_form_buts_wrap parent">
                                        <?php if ($course['blocked'] == 0) :?>
                                            <input type="submit" name="bt_block_course" value="Блокировать" class="video_admin_form_block"/>
                                        <?php elseif ($course['blocked'] == 1) :?>
                                            <input type="submit" name="bt_unblock_course" value="Разблокировать" class="video_admin_form_block"/>
                                        <?php endif;?>
                                        <input type="submit" name="bt_delete_course" value="Удалить" class="video_admin_form_block<?php if ($course['bought'] === true):?> disabled<?php endif;?>"/>
                                        <?php if ($course['archive'] == 0) :?>
                                            <input type="submit" name="bt_archive_course" value="В архив" class="admin_form_reset"/>
                                        <?php elseif ($course['archive'] == 1) :?>
                                            <input type="submit" name="bt_from_archive_course" value="Из архива" class="admin_form_reset"/>
                                        <?php endif;?>
                                        <input type="submit" name="bt_save_course" value="Сохранить" class="video_admin_form_send" />
                                    </div>
                                </div>
                                <div class="video_admin_form">
                                    <?php include_once('./app_fold/views/course/settings/course_settings_item.php');?>
                                </div>
                            </form>
                        <?php elseif ($page_submenu == 'landing' and !empty($landing)) :
                            include_once('./app_fold/views/course/settings/course_landing_item.php');
                        elseif ($page_submenu == 'statistics' and !empty($statistics)) :
                            include_once('./app_fold/views/course/settings/course_statistics_item.php');
                        elseif ($page_submenu == 'reviews' and !empty($reviews)) :
                            include_once('./app_fold/views/course/settings/course_reviews_item.php');
                        elseif ($page_submenu == 'reviews' and !empty($review)) :
                            include_once('./app_fold/views/course/settings/course_review_item.php');
                        elseif ($page_submenu == 'video' and $video_page == 'video_settings') :?>
                            <form action="" method="post" enctype="multipart/form-data">
                                <div class="admin_form_buts_wrap_container">
                                    <div class="admin_form_buts_wrap parent">
                                        <?php $dis_delete = (!empty($video['course_id']) and $video['course_id'] > 0) ? 'disabled' : '';?>
                                        <?php if ($video['blocked'] == 0) :?>
                                            <input type="submit" name="bt_block_video" value="Заблокировать" class="video_admin_form_block"/>
                                        <?php else :?>
                                            <input type="submit" name="bt_unblock_video" value="Разблокировать" class="video_admin_form_block"/>
                                        <?php endif;?>
                                        <input type="submit" name="bt_delete_video" value="Удалить" class="video_admin_form_block <?php echo $dis_delete; ?>"/>
                                        <input type="submit" name="bt_save_video" value="Сохранить" class="video_admin_form_send">
                                    </div>
                                </div>

                                <div class="video_admin_form">
                                    <?php include_once('./app_fold/views/video/video_settings_item.php');?>
                                </div>
                            </form>
                        <?php elseif ($page_submenu == 'video' and ($video_menu == 'promo' or $video_menu == 'workouts' or $video_menu == 'instructions')):
                            include_once('./app_fold/views/course/settings/course_video_item.php');
                        elseif ($page_submenu == 'promocodes' and !empty($promocodes)) :
                            include_once('./app_fold/views/promocodes/promocodes.php');
                        elseif ($page_submenu == 'promocodes' and !empty($promocode)) :
                            include_once('./app_fold/views/promocodes/promocode_settings.php');
                        elseif ($page_submenu == 'promocodes' and $promocode_new === true) :
                            include_once('./app_fold/views/promocodes/new_promocode.php');
                        elseif ($page_submenu == 'extends' and !empty($extends)) :
                            include_once('./app_fold/views/course/extends/extends.php');
                        elseif ($page_submenu == 'extends' and !empty($extend)) :
                            include_once('./app_fold/views/course/extends/extend_settings.php');
                        elseif ($page_submenu == 'extends' and $extend_new === true and !empty($potentially_extends)) :
                            include_once('./app_fold/views/course/extends/new_extend.php');
                        elseif ($page_submenu == 'attached' and !empty($attached_courses)) :
                            include_once('./app_fold/views/course/attach/attached_courses.php');
                        elseif ($page_submenu == 'attached' and $attach_new === true and !empty($attach_courses)) :
                            include_once('./app_fold/views/course/attach/new_attach.php');
                        else: ?>
                            <h3 class="info">Информация не найдена</h3>
                        <?php endif;?>
                    </div>
                </div>
            </div>
        </div><!-- content_col -->
    </div>
</div><!-- content -->
