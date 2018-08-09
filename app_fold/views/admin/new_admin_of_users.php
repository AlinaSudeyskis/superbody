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
                <div class="content_block_container_wrap">
                    <div class="content_block_container">
                        <div class="content_block_h new_content_block_h parent">
                            <h3>Добавить администратора</h3>
                            <a href="/administration/admin/new" class="add_tab_but">Добавить</a>
                        </div>
                        <?php include_once('./app_fold/views/admin/users_submenu.php'); ?>
                    </div>
                </div>
                <div class="kurs_block_val">
                    <div class="anketa_block_cont">
                        <form action="" class="" method="post" enctype="multipart/form-data">
                            <div class="admin_form_buts_wrap_container">
                                <div class="admin_form_buts_wrap parent">
                                    <input type="submit" name="bt_save_new_admins" class="video_admin_form_send" value="Сохранить">
                                </div>
                            </div>
                            <div class="video_admin_form edit_kurs_form">
                                <div class="add_tov_in_total">
                                    <div class="add_tov_in users">
                                        <div class="practice_block_h">Пользователи:</div>
                                        <input type="text" name="tren" class="admin_form_txt admin_form_txt_short" placeholder="Введите имя пользователя">
                                        <div class="add_tov_list"></div>
                                    </div>
                                    <div class="add_tov_val"></div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div><!-- content_col -->
    </div>
</div><!-- content -->
