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
                            <h3>Добавить категорию курса</h3>
                            <div class="content_block_h_ref"><a href="/administration/course/new" class="add_tab_but">Новый курс</a>
                            <a href="/administration/courses/type/new" class="add_tab_but">Новая категория</a>
                        </div></div>
                        <?php include_once('./app_fold/views/course/courses_menu.php'); ?>
                    </div>
                </div>
                <div class="kurs_block_val">
                    <form action="" method="post">
                        <div class="admin_form_buts_wrap_container">
                            <div class="admin_form_buts_wrap parent">
                                <input type="submit" name="bt_save_type_settings" value="Сохранить" class="video_admin_form_send defaultActionButton" />
                            </div>
                        </div>
                        <div class="video_admin_form">
                            <div class="parent kurs_cur_wrap">
                                <div class="kurs_block_h">Наименование:</div>
                                <input type="text" name="name" class="admin_form_txt kurs_form_txt_short" value="<?php echo $type_name;?>" maxlength="255" required="required" autofocus="autofocus"/>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- content_col -->
    </div>
</div><!-- content -->
