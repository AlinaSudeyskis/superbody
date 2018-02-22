<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="content" class="container">
    <div class="row">
        <div class="col-lg-2 left_sidebar">
            <?php include_once('./app_fold/views/admin/admin_menu.php');?>
        </div><!-- left_sidebar -->
        <div class="col-lg-10 content_col">
            <div class="content_block">
                <div class="content_block_h parent">
                    <h3>Добавить тренера</h3>
                    <a href="/administration/couch/new/users" class="add_tab_but">Выбрать</a>
                    <div class="content_block_h_buts">
                        <div class="content_block_h_slide kurs_slide"></div>
                        <div class="content_block_h_close"></div>
                    </div>
                </div>
                <div class="kurs_block_val">
                    <form action="" class="set_admin_form" method="post" enctype="multipart/form-data">
                        <div class="parent">
                            <div class="admin_form_l">
                                <div class="admin_form_h">Фото</div>
                                <div class="admin_form_foto_wrap">
                                    <div class="admin_form_foto"></div>
                                </div>
                                <label for="admin_add_file" class="admin_add_file">
                                    <input type="file" name="avatar_file" class="admin_form_file_but" id="admin_add_file" />
                                    <span>Добавить фото</span>
                                </label>
                            </div>
                            <div class="admin_form_r">
                                <div class="admin_form_h">ФИО</div>
                                <input type="text" name="name" class="admin_form_txt" placeholder="Полное имя" value="" maxlength="255" required="required"/>
                                <div class="admin_form_h">E-mail</div>
                                <input type="text" name="email" class="admin_form_txt" placeholder="e-mail" value="" maxlength="255" required="required"/>
                            </div>
                        </div>
                        <div class="admin_form_bats parent">
                            <input type="submit" name="bt_save_new_couch" class="admin_form_submit" value="Сохранить">
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- content_col -->
    </div>
</div><!-- content -->
