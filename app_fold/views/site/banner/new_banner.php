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
                            <h3>Информация о сайте</h3>
                            <a href="/administration/site/banner/new" class="add_tab_but">Добавить баннер</a>
                        </div>
                        <?php include_once('./app_fold/views/site/menu.php');?>
                    </div>
                </div>
                <div class="kurs_block_val">
                    <div class="anketa_block">
                        <div class="anketa_block_cont">
                            <form action="" method="post" enctype="multipart/form-data">
                                <div class="admin_form_buts_wrap_container">
                                    <div class="admin_form_buts_wrap parent">
                                        <input type="submit" name="bt_save_banner" value="Сохранить" class="video_admin_form_send" />
                                    </div>
                                </div>
                                <div class="video_admin_form site_info">
                                    <div class="anketa_form_line parent">
                                        <div class="anketa_form_h">
                                            <div class="anketa_form_h_cell">Файл баннера:</div>
                                            <div class="h_subtitle">(1920х350)</div>
                                        </div>
                                        <div class="video_down_line parent">
                                            <div class="parent kurs_cur_wrap">
                                                <div class="video_down_line_but_wrap">
                                                    <label for="video_down_line_but1cs" class="video_down_line_but">
                                                        <input type="hidden" name="MAX_FILE_SIZE" value="2097152" />
                                                        <input type="file" name="banner_file" class="admin_form_videofile" id="video_down_line_but1cs" accept="image/jpeg,image/png" />
                                                        <span>Выберите файл</span>
                                                    </label>
                                                </div>
                                                <div class="video_down_line_name" style="width:45% !important;">Файл не выбран</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="anketa_form_line parent">
                                        <div class="anketa_form_h"><div class="anketa_form_h_cell">Ссылка</div></div>
                                        <input type="text" class="anketa_form_in anketa_form_in_long" name="banner_url" value="" maxlength="255"/>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- content_col -->
    </div>
</div><!-- content -->
