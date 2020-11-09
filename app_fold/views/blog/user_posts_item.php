<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="content_block new_content_block">
    <div class="content_block_h parent">
        <h3>Блог</h3>
        <?php $path = '/blog/';
        if (empty($outsider) and $user_data['user_blocked'] == 0):
            $path = '/post/';?>
            <div class="content_block_h_ref">
                <a href="/post/new" class="add_tab_but">Добавить</a>
            </div>
        <?php endif;?>
        <div class="content_block_h_buts">
            <div class="content_block_h_slide kurs_slide"></div>
            <div class="content_block_h_close"></div>
        </div>
    </div>
    <div class="kurs_block_val">
        <?php if (!empty($posts)): ?>
            <div class="posts_block_row">
                <?php foreach ($posts as $post):
                    $post_path = $path; ?>
                    <?php include('./app_fold/views/blog/posts_item.php'); ?>
                <?php endforeach;
                unset($post);?>
            </div><!-- posts_block_row -->
            <?php include_once('./app_fold/views/pagination.php'); ?>
        <?php else: ?>
            <h3 class="info">Информация не найдена</h3>
        <?php endif;?>
    </div>
</div>