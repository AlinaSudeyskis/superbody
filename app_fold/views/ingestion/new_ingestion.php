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
                            <div class="content_block_h_ref"><a href="/administration/ingestion/new" class="add_tab_but">Новый прием пищи</a></div>
                        </div>
                        <?php include_once('./app_fold/views/course/nutritions/menu.php'); ?>
                    </div>
                </div>
                <div class="kurs_block_val">
                    <div class="anketa_block_cont">
                        <div class="anketa_block_item">
                            <div class="anketa_block_item_h">Новый прием пищи</div>
                            <div class="anketa_block_item_cont">
                                <form action="" class="anketa_form" method="post">

                                    <?php include_once('./app_fold/views/ingestion/settings_item.php'); ?>

                                    <div class="video_admin_form_buts parent">
                                        <input type="submit" name="bt_save_new_ingestion" value="Сохранить" class="video_admin_form_send defaultActionButton" />
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
