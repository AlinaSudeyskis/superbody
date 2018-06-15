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
                <div class="content_block_h parent">
                    <h3><?php if(!empty($course['name'])) : echo $course['name']; endif; ?></h3>
                    <?php /** @noinspection PhpIncludeInspection */
                        include_once('./app_fold/views/course/nutritions/settings/course_buts.php');?>
                    <div class="content_block_h_buts">
                        <div class="content_block_h_slide kurs_slide"></div>
                        <div class="content_block_h_close"></div>
                    </div>
                </div>
                <div class="kurs_block_val">
                    <?php /** @noinspection PhpIncludeInspection */
                    include_once('./app_fold/views/course/nutritions/settings/course_menu.php');?>
                    <div class="anketa_block_cont">
                        <?php if (!empty($page_submenu)):?>
                            <?php if ($page_submenu == 'settings' and !empty($course)):?>
                                <div class="block_item_h">Редактирование данных курса питания</div>
                                <form action="" class="video_admin_form edit_kurs_form" method="post" enctype="multipart/form-data">
                                    <?php /** @noinspection PhpIncludeInspection */
                                    include_once('./app_fold/views/course/nutritions/settings/settings_item.php');?>

                                    <div class="anketa_form_buts_wrap parent">
                                        <input type="submit" name="bt_save_course" value="Сохранить" class="video_admin_form_send" />
                                        <input type="submit" name="bt_delete_course" value="Удалить" class="video_admin_form_block<?php if ($course['bought'] === true):?> disabled<?php endif;?>"/>
                                        <?php if ($course['blocked'] == 0) :?>
                                            <input type="submit" name="bt_block_course" value="Блокировать" class="video_admin_form_block"/>
                                        <?php elseif ($course['blocked'] == 1) :?>
                                            <input type="submit" name="bt_unblock_course" value="Разблокировать" class="video_admin_form_block"/>
                                        <?php endif;?>
                                    </div>
                                </form>
                            <?php elseif ($page_submenu == 'landing' and !empty($landing)) :
                                /** @noinspection PhpIncludeInspection */
                                include_once('./app_fold/views/course/settings/course_landing_item.php');
                            elseif ($page_submenu == 'statistics' and !empty($statistics)) :
                                /** @noinspection PhpIncludeInspection */
                                include_once('./app_fold/views/course/settings/course_statistics_item.php');
                            elseif ($page_submenu == 'reviews' and !empty($reviews)) :
                                /** @noinspection PhpIncludeInspection */
                                include_once('./app_fold/views/course/settings/course_reviews_item.php');
                            elseif ($page_submenu == 'reviews' and !empty($review)) :
                                /** @noinspection PhpIncludeInspection */
                                include_once('./app_fold/views/course/settings/course_review_item.php');
                            elseif ($page_submenu == 'promocodes' and !empty($promocodes)) :
                                /** @noinspection PhpIncludeInspection */
                                include_once('./app_fold/views/promocodes/promocodes.php');
                            elseif ($page_submenu == 'promocodes' and !empty($promocode)) :
                                /** @noinspection PhpIncludeInspection */
                                include_once('./app_fold/views/promocodes/promocode_settings.php');
                            elseif ($page_submenu == 'promocodes' and $promocode_new === true) :
                                /** @noinspection PhpIncludeInspection */
                                include_once('./app_fold/views/promocodes/new_promocode.php');
                            else: ?>
                                <h3 class="info">Информация не найдена</h3>
                            <?php endif;
                        else: ?>
                            <h3 class="info">Информация не найдена</h3>
                        <?php endif;?>
                    </div>
                </div>
            </div>
        </div><!-- content_col -->
    </div>
</div><!-- content -->
