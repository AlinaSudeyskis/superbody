<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="content" class="container">
    <div class="row">
        <div class="col-lg-2 left_sidebar">
            <?php include_once('./app_fold/views/admin/admin_menu.php');?>
        </div><!-- left_sidebar -->
        <div class="col-lg-10 content_col">
            <div class="content_block new_content_block">
                <div class="content_block_h new_content_block_h parent">
                    <h3>Добавить тренера</h3>
                    <a href="/administration/couch/new" class="add_tab_but">Добавить</a>
                    <div class="content_block_h_buts">
                        <div class="content_block_h_slide kurs_slide"></div>
                        <div class="content_block_h_close"></div>
                    </div>
                </div>
                <div class="kurs_block_val">
                    <div class="anketa_block_cont">
                        <form action="" class="video_admin_form edit_kurs_form" method="post" enctype="multipart/form-data">
                            <div class="parent">
                                <div class="add_tov_in_total">
                                    <div class="add_tov_in users">
                                        <div class="practice_block_h">Пользователи:</div>
                                        <input type="text" name="tren" class="admin_form_txt admin_form_txt_short" placeholder="Введите имя пользователя">
                                        <div class="add_tov_list"></div>
                                    </div>
                                    <div class="add_tov_val"></div>
                                </div>
                            </div>
                            <div class="video_admin_form_buts parent">
                                <input type="submit" name="bt_save_new_couches" class="admin_form_submit" value="Сохранить">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div><!-- content_col -->
    </div>
</div><!-- content -->
