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
                    <?php if (!empty($posts)): ?>
                        <div class="admin_list posts_page">
                            <?php foreach ($posts as $post):
                                $post_path = '/administration/blog/post/'; ?>
                                <?php include('./app_fold/views/blog/posts_item.php'); ?>
                            <?php endforeach;
                            unset($article); ?>
                        </div>
                        <?php include_once('./app_fold/views/pagination.php'); ?>
                    <?php else: ?>
                        <h3 class="info">Информация не найдена</h3>
                    <?php endif;?>
                </div>
            </div>
        </div><!-- content_col -->
    </div>
</div><!-- content -->
