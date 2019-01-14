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
                <div class="content_block_container_wrap">
                    <div class="content_block_container">
                        <div class="content_block_h new_content_block_h parent">
                            <h3>Редактировать категорию товара</h3>
                        </div>
                        <?php include_once('./app_fold/views/store/product/product_submenu.php'); ?>
                    </div>
                </div>
                <div class="kurs_block_val">
                    <form action="" method="post">
                        <div class="admin_form_buts_wrap_container">
                            <div class="admin_form_buts_wrap parent">
                                <input type="submit" name="bt_save_category" value="Сохранить" class="video_admin_form_send" />
                                <?php if ($category['blocked'] == 0) : ?>
                                    <input type="submit" name="bt_block_category" value="Заблокировать" class="video_admin_form_block"/>
                                <?php else: ?>
                                    <input type="submit" name="bt_unblock_category" value="Разблокировать" class="video_admin_form_block"/>
                                <?php endif;?>
                                <?php if ($category['id'] != 1 and $category['id'] != 2 and $category['id'] != 6) : ?>
                                    <input type="submit" name="bt_delete_category" value="Удалить" class="video_admin_form_block"/>
                                <?php endif;?>
                            </div>
                        </div>

                        <div class="video_admin_form">
                            <?php include_once('./app_fold/views/store/category/settings_item.php'); ?>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- content_col -->
    </div>
</div><!-- content -->