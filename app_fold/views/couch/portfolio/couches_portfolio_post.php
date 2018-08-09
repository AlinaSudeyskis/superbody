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
                            <h3>Портфолио тренера</h3>
                        </div>
                    </div>
                </div>
                <div class="kurs_block_val">
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="admin_form_buts_wrap_container">
                            <div class="admin_form_buts_wrap parent">
                                <?php if($post['approval'] == 0): ?>
                                    <input type="submit" name="bt_approval_post" value="Одобрить" class="video_admin_form_block" />
                                <?php else: ?>
                                    <input type="submit" name="bt_block_post" value="Блокировать" class="video_admin_form_block" />
                                <?php endif; ?>
                                <input type="submit" name="bt_save_image" value="Сохранить" class="video_admin_form_send" />
                            </div>
                        </div>
                        <div class="tren_set_form">
                            <div class="tren_set_form_l">
                                <div class="tren_set_form_img">
                                    <?php if(!empty($post['path'])): ?>
                                        <img src="<?php echo $post['path'];?>" alt="">
                                    <?php else: ?>
                                        <img src="/img/no_img.png" alt="">
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="tren_set_form_r">
                                <div class="tren_set_form_h">Название</div>
                                <input type="text" name="image_title" class="tren_set_form_in" placeholder="Введите название" value="<?php if(!empty($post['title'])): echo $post['title']; endif; ?>"/>
                                <div class="tren_set_form_h">Описание</div>
                                <textarea name="image_description" class="tren_set_form_txt" placeholder="Введите описание"><?php if(!empty($post['title'])): echo $post['desc']; endif; ?></textarea>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- content_col -->
    </div>
</div><!-- content -->