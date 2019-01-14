<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="content" class="container">
    <div class="row">
        <div class="col-lg-2 left_sidebar">
            <?php /** @noinspection PhpIncludeInspection */
            include_once('./app_fold/views/admin/admin_menu.php');?>
        </div><!-- left_sidebar -->
        <div class="col-lg-10 content_col">
            <div class="content_block new_content_block ovv">
                <div class="content_block_container_wrap">
                    <div class="content_block_container">
                        <div class="content_block_h new_content_block_h parent">
                            <h3><?php if(!empty($course['name'])) : echo $course['name']; endif; ?></h3>
                            <?php /** @noinspection PhpIncludeInspection */
                            include_once('./app_fold/views/course/nutritions/settings/course_buts.php');?>
                        </div>
                        <?php /** @noinspection PhpIncludeInspection */
                        include_once('./app_fold/views/course/nutritions/settings/course_menu.php');?>
                    </div>
                </div>
                <div class="kurs_block_val">
                    <div class="anketa_block_cont">
                        <?php if (!empty($page_submenu)):?>
                            <?php if ($page_submenu == 'settings' and !empty($course)):?>
                                <form action="" class="edit_kurs_form" method="post" enctype="multipart/form-data">
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
                                        <?php /** @noinspection PhpIncludeInspection */
                                        include_once('./app_fold/views/course/nutritions/settings/settings_item.php');?>
                                    </div>
                                </form>
                            <?php elseif ($page_submenu == 'landing' and !empty($landing)): ?>
                                <?php /** @noinspection PhpIncludeInspection */
                                include_once('./app_fold/views/course/settings/course_landing_item.php');?>
                            <?php elseif ($page_submenu == 'statistics' and !empty($statistics)): ?>
                                <?php /** @noinspection PhpIncludeInspection */
                                include_once('./app_fold/views/course/settings/course_statistics_item.php');?>
                            <?php elseif ($page_submenu == 'reviews' and !empty($reviews)): ?>
                                <?php /** @noinspection PhpIncludeInspection */
                                include_once('./app_fold/views/course/settings/course_reviews_item.php');?>
                            <?php elseif ($page_submenu == 'reviews' and !empty($review)): ?>
                                <?php /** @noinspection PhpIncludeInspection */
                                include_once('./app_fold/views/course/settings/course_review_item.php');?>
                            <?php elseif ($page_submenu == 'promocodes' and !empty($promocodes)): ?>
                                <?php /** @noinspection PhpIncludeInspection */
                                include_once('./app_fold/views/promocodes/promocodes.php');?>
                            <?php elseif ($page_submenu == 'promocodes' and !empty($promocode)): ?>
                                <?php /** @noinspection PhpIncludeInspection */
                                include_once('./app_fold/views/promocodes/promocode_settings.php');?>
                            <?php elseif ($page_submenu == 'promocodes' and !empty($promocode_new) and $promocode_new === true): ?>
                                <?php /** @noinspection PhpIncludeInspection */
                                include_once('./app_fold/views/promocodes/new_promocode.php'); ?>
                            <?php else: ?>
                                <h3 class="info">Информация не найдена</h3>
                            <?php endif;?>
                        <?php else: ?>
                            <h3 class="info">Информация не найдена</h3>
                        <?php endif;?>
                    </div>
                </div>
            </div>
        </div><!-- content_col -->
    </div>
</div><!-- content -->
