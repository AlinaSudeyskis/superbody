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
                    <?php if(!empty($post)): ?>
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="admin_form_buts_wrap_container">
                                <div class="admin_form_buts_wrap parent">
                                    <?php if ($post['approval'] == 0) :?>
                                        <input type="submit" name="bt_approval_post" class="video_admin_form_block" value="Одобрить" />
                                    <?php else :?>
                                        <input type="submit" name="bt_block_post" class="video_admin_form_block" value="Заблокировать" />
                                    <?php endif;?>
                                    <input type="submit" name="bt_delete_post" class="video_admin_form_block" value="Удалить" />
                                    <input type="submit" name="bt_save_post" class="video_admin_form_send defaultActionButton" value="Сохранить"   />
                                </div>
                            </div>
                            <div class="comment_page_block">
                                <div class="comment_page_cont">
                                    <div class="video_admin_form">
                                        <?php include_once('./app_fold/views/blog/post_settings_item.php');?>

                                        <div class="comment_page_cont_link"><a href="/profile/<?php echo $post['user_id'];?>"><?php echo $post['user_name'];?></a></div>
                                    </div>
                                </div>
                                <div class="full_photo_block_comm_wrap">
                                    <?php if (!empty($post['comments'])) :
                                        foreach ($post['comments'] as $comment) : ?>
                                            <div class="full_photo_block_comm parent">
                                                <div class="full_photo_block_comm_img">
                                                    <?php if (!empty($comment['user_image'])) : ?>
                                                        <img src="<?php echo $comment['user_image']; ?>" alt="" />
                                                    <?php endif;?>
                                                </div>
                                                <div class="full_photo_block_comm_cont">
                                                    <div class="full_photo_block_comm_name"><?php echo $comment['user_name']; ?></div>
                                                    <div class="full_photo_block_comm_txt"><?php echo $comment['text']; ?></div>
                                                    <div class="full_photo_block_comm_info disabled">
                                                        <div class="full_photo_block_comm_info_item"><a href=""><i class="fa fa-heart-o" aria-hidden="true"></i></a><span>100</span></div>
                                                        <div class="full_photo_block_comm_info_item"><a href=""><i class="fa fa-comment-o" aria-hidden="true"></i></a><span>100</span></div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach;
                                        unset($comment);
                                    endif;?>
                                </div>
                            </div>
                        </form>
                    <?php else: ?>
                        <h3 class="info">Информация не найдена</h3>
                    <?php endif;?>
                </div>
            </div>
        </div><!-- content_col -->
    </div>
</div><!-- content -->
