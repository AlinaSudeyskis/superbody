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
                            <h3>Уведомления</h3>
                        </div>
                    </div>
                </div>
                <div class="kurs_block_val notif_block">
                    <?php if (!empty($notifications['text'])): ?>
                        <div class="admin_list">
                            <?php foreach ($notifications['text'] as $key => $notification) :
                                if(!empty($notification)): ?>
                                    <div class="admin_item parent">
                                        <div class="admin_ava"></div>
                                        <div class="admin_cont">
                                            <div class="admin_name">
                                                <a href="/administration/notification/<?php echo $key; ?>">[<?php echo $key; ?>] <?php echo $notification; ?></a>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif;
                            endforeach;
                            unset($notification); ?>
                        </div>
                        <?php include('./app_fold/views/pagination.php');?>
                    <?php endif; ?>
                </div>
            </div>
        </div><!-- content_col -->
    </div>
</div><!-- content -->