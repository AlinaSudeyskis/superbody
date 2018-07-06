<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="content" class="container">
    <div class="row">
        <div class="col-lg-2 left_sidebar">
            <?php include_once('./app_fold/views/couch/couch_menu.php');?>
        </div><!-- left_sidebar -->
        <div class="col-lg-10 content_col">
            <div class="content_block new_content_block">
                <div class="content_block_h parent">
                    <h3>Настройка портфолио</h3>
                    <div class="content_block_h_buts">
                        <div class="content_block_h_slide kurs_slide"></div>
                        <div class="content_block_h_close"></div>
                    </div>
                </div>
                <div class="kurs_block_val">
                    <form action="" class="tren_set_form" method="post" enctype="multipart/form-data">
                        <div class="parent">
                            <?php include_once('./app_fold/views/couch/portfolio/settings_item.php');?>
                            <div class="anketa_form_buts_wrap parent">
                                <?php if($post['approval'] == 0): ?>
                                    <input type="submit" name="bt_save_image" value="Сохранить" class="video_admin_form_send" />
                                <?php endif; ?>
                                <input type="submit" name="bt_del_post" value="Удалить" class="video_admin_form_block" />
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- content_col -->
    </div>
</div><!-- content -->