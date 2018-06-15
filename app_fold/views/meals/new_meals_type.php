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
                            <div class="anketa_block_item_h">Новый тип блюда</div>
                            <div class="anketa_block_item_cont">
                                <form action="" class="anketa_form" method="post">
                                    <div class="anketa_form_line parent">
                                        <div class="anketa_form_h"><div class="anketa_form_h_cell">Наименование:</div></div>
                                        <input type="text" name="i_name" value="" class="anketa_form_in anketa_form_in_long" maxlength="255" />
                                    </div>

                                    <div class="anketa_form_buts_wrap parent">
                                        <input type="submit" name="bt_save_new_meal_type" value="Сохранить" class="video_admin_form_send" />
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
