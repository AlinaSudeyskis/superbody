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
                <div class="content_block_h parent">
                    <h3>Комментарии блога</h3>
                    <div class="content_block_h_buts">
                        <div class="content_block_h_slide kurs_slide"></div>
                        <div class="content_block_h_close"></div>
                    </div>
                </div>
                <div class="kurs_block_val">
                    <div class="admin_list">
                        <div class="full_photo_block_comm parent">
                            <div class="full_photo_block_comm_img">
                                <?php if (!empty($message['user']['image'])) : ?>
                                    <img src="<?php echo $message['user']['image']; ?>" alt="" />
                                <?php endif;?>
                            </div>
                            <div class="full_photo_block_comm_cont">
                                <div class="full_photo_block_comm_name"><?php echo $message['user']['name']; ?></div>
                                <div class="full_photo_block_comm_txt"><?php echo $message['text']; ?></div>
                            </div>
                            <form action="" method="post">
                                <?php if ($message['blocked'] == 1) :?>
                                    <input type="submit" name="bt_unblock_message" class="admin_form_block" value="Разблокировать"/>
                                <?php else :?>
                                    <input type="submit" name="bt_block_message" class="admin_form_block" value="Блокировать"/>
                                <?php endif;?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- content_col -->
    </div>
</div><!-- content -->
