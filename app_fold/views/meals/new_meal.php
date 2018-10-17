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
                            <h3>Курсы питания</h3>
                            <?php include_once('./app_fold/views/meals/meals_buts.php'); ?>
                        </div>
                        <?php include_once('./app_fold/views/course/nutritions/menu.php'); ?>
                    </div>
                </div>
                <div class="kurs_block_val">
                    <div class="anketa_block_cont">
                        <div class="anketa_block_item">
                            <div class="anketa_block_item_h">Новое блюдо/продукт</div>
                            <div class="anketa_block_item_cont">
                                <form action="" class="anketa_form" method="post" enctype="multipart/form-data">
                                    <?php include_once('./app_fold/views/meals/settings_item.php'); ?>

                                    <div class="anketa_form_buts_wrap parent">
                                        <input type="submit" name="bt_save_new_meal" value="Сохранить" class="video_admin_form_send" />
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
