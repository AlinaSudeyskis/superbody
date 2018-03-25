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
                <div class="content_block_h parent">
                    <h3>Добавить категорию курса</h3>
                    <a href="/administration/course/new" class="add_tab_but">Добавить курс</a>
                    <a href="/administration/courses/type/new" class="tab_but">Добавить категорию</a>
                    <div class="content_block_h_buts">
                        <div class="content_block_h_slide kurs_slide"></div>
                        <div class="content_block_h_close"></div>
                    </div>
                </div>
                <div class="kurs_block_val">
                    <?php include_once('./app_fold/views/course/courses_menu.php'); ?>
                    <form action="" class="video_admin_form" method="post">
                        <div class="parent kurs_cur_wrap">
                            <div class="kurs_block_h">Наименование:</div>
                            <input type="text" name="name" class="admin_form_txt kurs_form_txt_short" value="" maxlength="255" required="required" autofocus="autofocus"/>
                        </div>
                        <div class="video_admin_form_buts parent">
                            <input type="submit" name="bt_save_new_type" value="Сохранить" class="video_admin_form_send" />
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- content_col -->
    </div>
</div><!-- content -->
