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
                            <h3>Добавить тренера</h3>
                            <div class="content_block_h_ref"><a href="/administration/coach/new/users" class="add_tab_but">Выбрать</a></div>
                        </div>
                        <?php include_once('./app_fold/views/admin/users_submenu.php'); ?>
                    </div>
                </div>
                <div class="kurs_block_val">
                    <div class="anketa_block_cont">
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="admin_form_buts_wrap_container">
                                <div class="admin_form_buts_wrap parent">
                                    <input type="submit" name="bt_save_new_coach" value="Сохранить" class="video_admin_form_send">
                                </div>
                            </div>

                            <div class="video_admin_form edit_kurs_form">
                                <div class="anketa_form_line parent">
                                    <div class="anketa_form_h"><div class="anketa_form_h_cell">Польное имя</div></div>
                                    <input type="text" name="name" class="anketa_form_in anketa_form_in_long" placeholder="Полное имя" value="<?php if (!empty($user_name)) { echo $user_name; }?>" maxlength="255"/>
                                </div>
                                <div class="anketa_form_line parent">
                                    <div class="anketa_form_h"><div class="anketa_form_h_cell">Email</div></div>
                                    <input type="text" name="email" class="anketa_form_in anketa_form_in_long valid_email" placeholder="Email" value="<?php if (!empty($user_email)) { echo $user_email; }?>" maxlength="255"/>
                                </div>
                                <div class="anketa_form_line parent">
                                    <div class="anketa_form_h"><div class="anketa_form_h_cell">Фото</div></div>
                                    <div class="video_down_line parent">
                                        <div class="video_down_line_but_wrap">
                                            <label for="video_down_line_but1cs" class="video_down_line_but">
                                                <input type="hidden" name="MAX_FILE_SIZE" value="2097152" />
                                                <input type="file" name="avatar_file" class="admin_form_videofile" id="video_down_line_but1cs" accept="image/jpeg,image/png">
                                                <span>Выберите файл</span>
                                            </label>
                                        </div>
                                        <div class="video_down_line_name">Файл не выбран</div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div><!-- content_col -->
    </div>
</div><!-- content -->
