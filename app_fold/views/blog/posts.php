<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$user_name = (!empty($user_data['user_name'])) ? $user_data['user_name'] : 'Страница тренера';
$breadcrumbs = array('/blog' => 'Блог');
include_once('./app_fold/views/breadcrumb.php');
?>
<div id="content" class="container">
    <div class="row">
        <div class="col-lg-2 left_sidebar">
            <?php if (!empty($user_session)):
                if ($user_session['type'] == 2):
                    include_once('./app_fold/views/coach/coach_menu.php');
                else:
                    include_once('./app_fold/views/user/user_menu.php');
                endif;
            else: ?>
                <div class="advertising">
                    <?php if (!empty($site_info['advertising_vertical']) and empty($site_info['advertising_vertical_hide'])):
                        echo $site_info['advertising_vertical'];
                    endif; ?>
                </div>
            <?php endif;?>
        </div><!-- left_sidebar -->
        <div class="col-lg-10 content_col">
            <div class="content_block">
                <div class="content_block_container_wrap">
                    <div class="content_block_container">
                        <div class="content_block_h new_content_block_h parent">
                            <h3>Блог</h3>
                        </div>
                    </div>
                </div>
                <div class="kurs_block_val">
                    <?php if (!empty($posts)): ?>
                        <div class="admin_list posts_page">
                            <?php foreach ($posts as $post):
                                $post_path = '/blog/'; ?>
                                <?php include('./app_fold/views/blog/posts_item.php'); ?>
                            <?php endforeach;
                            unset($article);
                            include_once('./app_fold/views/pagination.php'); ?>
                        </div>
                    <?php else: ?>
                        <h3 class="info">Информация не найдена</h3>
                    <?php endif;?>
                </div>
            </div>
        </div><!-- content_col -->
    </div>
</div><!-- content -->
