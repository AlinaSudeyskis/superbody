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
                <div class="content_block_h new_content_block_h parent">
                    <h3>Блог тренера</h3>
                    <div class="content_block_h_buts">
                        <div class="content_block_h_slide kurs_slide"></div>
                        <div class="content_block_h_close"></div>
                    </div>
                </div>
                <div class="kurs_block_val">
                    <?php include_once('./app_fold/views/blog/posts/menu.php'); ?>
                    <div class="admin_list">
                        <?php if (!empty($posts)) :
                            foreach ($posts as $post) :?>
                                <div class="subscription_block_item">
                                    <div class="subscription_block_h"><a href="/administration/blog/post/<?php echo $post['id'];?>"><?php echo $post['title'];?></a></div>
                                    <div class="subscription_block_txt">Краткое описание: <?php echo $post['short_desc'];?>...</div>
                                    <div class="subscription_block_link">
                                        <a href="/profile/<?php echo $post['user_id']?>"><?php echo $post['user_name']?></a>
                                    </div>
                                </div>
                            <?php endforeach;
                            unset($article);
                        endif;?>
                    </div>
                    <?php include_once('./app_fold/views/pagination.php'); ?>
                </div>
            </div>
        </div><!-- content_col -->
    </div>
</div><!-- content -->
