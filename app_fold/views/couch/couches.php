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
                <div class="content_block_h new_content_block_h parent">
                    <h3>Тренер</h3>
                    <a href="/administration/couch/new" class="add_tab_but">Добавить</a>
                    <a href="/administration/couch/new/users" class="add_tab_but">Выбрать</a>
                    <div class="content_block_h_buts">
                        <div class="content_block_h_slide kurs_slide"></div>
                        <div class="content_block_h_close"></div>
                    </div>
                </div>
                <div class="kurs_block_val">
                    <div class="admin_list">
                        <?php if (!empty($couches)) :
                            foreach ($couches as $couch) : ?>
                                <div class="admin_item parent">
                                    <div class="admin_ava"><img src="<?php echo $couch['image']; ?>" alt=""></div>
                                    <div class="admin_cont">
                                        <div class="admin_name">
                                            <a href="/profile/<?php echo $couch['id']; ?>" class="admin_name"><?php echo $couch['f_name']; ?></a>
                                        </div>
                                        <div class="admin_set">
                                            <a href="/administration/couch/<?php echo $couch['id']; ?>" class="admin_set">Редактировать</a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach;
                            unset($couch);
                        endif;?>
                    </div>
                    <?php include_once('./app_fold/views/pagination.php'); ?>
                </div>
            </div>
        </div><!-- content_col -->
    </div>
</div><!-- content -->
