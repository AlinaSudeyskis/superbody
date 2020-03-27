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
                            <h3>Блог тренера</h3>
                        </div>
                        <?php include_once('./app_fold/views/blog/menu.php'); ?>
                    </div>
                </div>
                <div class="kurs_block_val">
                    <div class="admin_list">
                        <div class="full_photo_block_comm_wrap">
                            <?php if (!empty($comments)) :
                                foreach ($comments as $comment) : ?>
                                    <div class="full_photo_block_comm parent">
                                        <div class="full_photo_block_comm_img">
                                            <?php if (!empty($comment['user_image'])) : ?>
                                                <img src="<?php echo $comment['user_image']; ?>" alt="" />
                                            <?php endif;?>
                                        </div>
                                        <div class="full_photo_block_comm_cont">
                                            <div class="full_photo_block_comm_name"><?php echo $comment['user_name']; ?></div>
                                            <div class="full_photo_block_comm_txt"><?php echo $comment['text']; ?></div>

                                            <div class="admin_set">
                                                <a href="/administration/blog/comment/<?php echo $comment['id']; ?>">Настройки</a>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach;
                                unset($comment);
                            endif;?>
                        </div>
                    </div>
                    <?php include_once('./app_fold/views/pagination.php'); ?>
                </div>
            </div>
        </div><!-- content_col -->
    </div>
</div><!-- content -->
