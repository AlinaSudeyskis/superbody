<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="content" class="container">
    <div class="row">
        <div class="col-lg-2 left_sidebar">
            <?php include_once('./app_fold/views/admin/admin_menu.php');?>
        </div><!-- left_sidebar -->
        <div class="col-lg-10 content_col">
            <div class="content_block new_content_block ovv">
                <div class="content_block_container_wrap">
                    <div class="content_block_container">
                        <div class="content_block_h new_content_block_h parent">
                            <h3>Добавление нового промокода</h3>
                            <div class="content_block_h_ref"><a href="/administration/promocode/new" class="add_tab_but" short="">Доб. промокод</a></div>
                        </div>
                    </div>
                </div>
                <div class="kurs_block_val">
                    <div class="anketa_block_cont">
                        <form action="" method="post">
                            <div class="admin_form_buts_wrap_container">
                                <div class="admin_form_buts_wrap parent">
                                    <input type="submit" name="bt_save_new_promocode" value="Сохранить" id="defaultActionButton"  class="video_admin_form_send">
                                </div>
                            </div>
                            <div class="video_admin_form">
                                <?php include_once('./app_fold/views/promocodes/settings_item.php');?>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div><!-- content_col -->
    </div>
</div><!-- content -->