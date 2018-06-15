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
                    <h3>Добавить администратора</h3>
                    <a href="/administration/admin/new/users" class="add_tab_but">Выбрать</a>
                    <div class="content_block_h_buts">
                        <div class="content_block_h_slide kurs_slide"></div>
                        <div class="content_block_h_close"></div>
                    </div>
                </div>
                <div class="kurs_block_val">
                    <form action="" class="set_admin_form" method="post" enctype="multipart/form-data">
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
                            <div class="anketa_form_info_cont">
                                <div style="width: 330px;">
                                    <div class="video_down_line parent">
                                        <div class="parent kurs_cur_wrap">
                                            <div class="video_down_line_but_wrap">
                                                <label for="video_down_line_but1cs" class="video_down_line_but">
                                                    <input type="hidden" name="MAX_FILE_SIZE" value="2097152" />
                                                    <input type="file" name="avatar_file" class="admin_form_videofile" id="video_down_line_but1cs" accept="image/jpeg,image/png" />
                                                    <span>Выберите файл</span>
                                                </label>
                                            </div>
                                            <div class="video_down_line_name" style="width:45% !important;">Файл не выбран</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="anketa_form_buts_wrap parent">
                            <input type="submit" name="bt_save_new_admin" value="Сохранить" class="anketa_form_but" />
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- content_col -->
    </div>
</div><!-- content -->
