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
                            <h3>Новый курс тренировок</h3>
                            <div class="content_block_h_ref"><a href="/administration/course/new" class="add_tab_but">Новый курс</a>
                            <a href="/administration/courses/type/new" class="add_tab_but">Новая категорию</a>
                        </div></div>
                        <?php include_once('./app_fold/views/course/courses_menu.php');?>
                    </div>
                </div>
                <div class="kurs_block_val">
                    <div class="anketa_block_cont">
                        <form action="" class="edit_kurs_form" id="1kurs_form" method="post" enctype="multipart/form-data">
                            <div class="admin_form_buts_wrap_container">
                                <div class="admin_form_buts_wrap parent">
                                    <input type="submit" name="bt_save_course" value="Сохранить" id="defaultActionButton"  class="video_admin_form_send" />
                                </div>
                            </div>
                            <div class="video_admin_form">
                                <?php include_once('./app_fold/views/course/settings/course_settings_item.php');?>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div><!-- content_col -->
    </div>
</div><!-- content -->
