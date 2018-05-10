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
                    <h3>Подписчики [<?php echo $count_users; ?>]</h3>
                    <div class="content_block_h_buts">
                        <div class="content_block_h_slide kurs_slide"></div>
                        <div class="content_block_h_close"></div>
                    </div>
                </div>
                <div class="kurs_block_val">
                    <div class="admin_list">
                        <?php if (!empty($users)) :
                            foreach ($users as $u) : ?>
                                <div class="admin_item parent">
                                    <div class="admin_cont">
                                        <div class="admin_name">
                                            <b><?php echo $u['email']; ?></b>
                                            <?php if(!empty($u['name'])):?>
                                                [<?php echo $u['name'];?>]
                                            <?php endif;?>
                                            <?php if(!empty($u['unsubscribe'] == 1)):?>
                                                <div class="unsubscribe">Отписался</div>
                                            <?php endif;?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach;
                            unset($u);
                        endif;?>
                    </div>
                    <?php include_once('./app_fold/views/pagination.php'); ?>
                </div>
            </div>
        </div><!-- content_col -->
    </div>
</div><!-- content -->
