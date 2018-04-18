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
                    <h3>Редактировать категорию товара</h3>
                    <div class="content_block_h_buts">
                        <div class="content_block_h_slide kurs_slide"></div>
                        <div class="content_block_h_close"></div>
                    </div>
                </div>
                <div class="kurs_block_val">
                    <form action="" class="video_admin_form" method="post">
                        <?php include_once('./app_fold/views/store/category/settings_item.php'); ?>
                        <div class="video_admin_form_buts parent">
                            <input type="submit" name="bt_save_category" value="Сохранить" class="video_admin_form_send" />
                            <?php if ($category['blocked'] == 0) : ?>
                                <input type="submit" name="bt_block_category" value="Заблокировать" class="admin_form_block"/>
                            <?php else: ?>
                                <input type="submit" name="bt_unblock_category" value="Разблокировать" class="admin_form_block"/>
                            <?php endif;?>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- content_col -->
    </div>
</div><!-- content -->