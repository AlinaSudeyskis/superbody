<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="content" class="container">
    <div class="row">
        <div class="col-lg-2 left_sidebar">
            <?php include_once('./app_fold/views/coach/coach_menu.php');?>
        </div><!-- left_sidebar -->
        <div class="col-lg-10 content_col">
            <div class="content_block new_content_block">
                <div class="content_block_h parent">
                    <h3>Портфолио</h3>
                    <a href="/portfolio/post/new" class="add_tab_but">Добавить</a>
                    <div class="content_block_h_buts">
                        <div class="content_block_h_slide kurs_slide"></div>
                        <div class="content_block_h_close"></div>
                    </div>
                </div>
                <div class="kurs_block_val">
                    <form action="" class="tren_set_form" method="post" enctype="multipart/form-data">
                        <?php include_once('./app_fold/views/coach/portfolio/settings_item.php'); ?>
                        <div class="anketa_form_line parent">
                            <div class="video_admin_form_buts parent">
                                <input type="submit" name="bt_save_post" value="Сохранить" class="full_photo_comm_but defaultActionButton" />
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- content_col -->
    </div>
</div><!-- content -->