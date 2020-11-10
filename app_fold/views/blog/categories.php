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
                            <h3>Блог тренера</h3>
                            <div class="content_block_h_ref"><a href="/administration/blog/category/new" class="add_tab_but">Добавить категорию</a></div>
                        </div>
                        <?php include_once('./app_fold/views/blog/menu.php'); ?>
                    </div>
                </div>
                <div class="kurs_block_val">
                    <?php if (!empty($blog_categories)) :?>
                        <div class="admin_list">
                            <?php foreach ($blog_categories as $type) :?>
                                <div class="admin_item parent">
                                    <div class="admin_ava"></div>
                                    <div class="admin_cont">
                                        <div class="admin_name">
                                            <a href="/administration/blog/category/<?php echo $type['id']?>"><?php echo $type['name']?></a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach;
                            unset($type); ?>
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
