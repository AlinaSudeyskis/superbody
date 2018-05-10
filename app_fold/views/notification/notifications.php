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
                    <h3>Уведомления</h3>
                    <div class="content_block_h_buts">
                        <div class="content_block_h_slide kurs_slide"></div>
                        <div class="content_block_h_close"></div>
                    </div>
                </div>
                <div class="kurs_block_val">
                    <div class="admin_list">
                        <?php if (!empty($notifications)) :
                            foreach ($notifications as $key => $notification) :
                                if(!empty($notification)): ?>
                                    <div class="admin_item parent">
                                        <div class="admin_ava"></div>
                                        <div class="admin_cont">
                                            <div class="admin_name">
                                                <a href="/administration/notification/<?php echo $key; ?>" class="admin_name">[<?php echo $key; ?>] <?php echo $notification; ?></a>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif;
                            endforeach;
                            unset($notification);
                        endif;?>
                    </div>
                </div>
            </div>
        </div><!-- content_col -->
    </div>
</div><!-- content -->