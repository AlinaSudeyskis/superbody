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
                    <h3>Курсы питания</h3>
                    <?php include_once('./app_fold/views/course/nutritions/courses_buts.php'); ?>
                    <div class="content_block_h_buts">
                        <div class="content_block_h_slide kurs_slide"></div>
                        <div class="content_block_h_close"></div>
                    </div>
                </div>
                <div class="kurs_block_val">
                    <?php include_once('./app_fold/views/course/nutritions/menu.php'); ?>
                    <div class="anketa_block_cont">
                        <div class="anketa_block_item">
                            <div class="anketa_block_item_h">Новое блюдо</div>
                            <form class="anketa_block_item_cont">
                                <form action="" class="anketa_form" method="post" enctype="multipart/form-data">
                                    <?php include_once('./app_fold/views/meals/settings_item.php'); ?>

                                    <div class="anketa_form_buts_wrap parent">
                                        <input type="submit" name="bt_save_new_meal" value="Сохранить" class="video_admin_form_send" />
                                    </div>
                                </form>
                                <form action="" class="anketa_form" method="post" enctype="multipart/form-data">
                                    <div class="anketa_form_line parent">
                                        <div class="anketa_form_h"><div class="anketa_form_h_cell">Файл Excel:</div></div>
                                        <div class="video_down_line parent">
                                            <div class="video_down_line_but_wrap">
                                                <label for="video_down_line_but2cs" class="video_down_line_but">
                                                    <input type="file" name="xls" class="admin_form_videofile" id="video_down_line_but2cs" accept="application/excel,application/vnd.ms-excel,application/x-excel,application/x-msexcel" required="required"/>
                                                    <span>Выберите файл</span>
                                                </label>
                                            </div>
                                            <div class="video_down_line_name">Файл не выбран</div>
                                        </div>
                                    </div>
                                    <div class="anketa_form_buts_wrap parent">
                                        <input type="submit" name="bt_load_excel" value="Загрузить и сохранить" class="video_admin_form_send" />
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- content_col -->
    </div>
</div><!-- content -->
