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
                            <h3>Сообщения пользователей</h3>
                        </div>
                    </div>
                </div>
                <div class="kurs_block_val">
                    <div class="admin_list">
                        <div class="full_photo_block_comm_wrap">
                            <?php if (!empty($messages)) :
                                foreach ($messages as $message) : ?>
                                    <div class="full_photo_block_comm parent">
                                        <!--<div class="full_photo_block_comm_img">
                                            <?php /*if (!empty($message['user']['image'])) : */?>
                                                <img src="<?php /*echo $message['user']['image']; */?>" alt="" />
                                            <?php /*endif;*/?>
                                        </div>-->
                                        <div class="full_photo_block_comm_cont">
                                            <div class="full_photo_block_comm_name">
                                                <?php if($message['user_from']['type'] == 2): ?><u><?php endif; ?><?php echo $message['user_from']['name']; ?><?php if($message['user_from']['type'] == 2): ?></u><?php endif; ?>
                                                -
                                                <?php if($message['user_whom']['type'] == 2): ?><u><?php endif; ?><?php echo $message['user_whom']['name']; ?><?php if($message['user_whom']['type'] == 2): ?></u><?php endif; ?>
                                            </div>
                                            <div class="full_photo_block_comm_txt"><?php echo $message['date']; ?>: <i><?php echo $message['text']; ?></i></div>

                                            <div class="admin_set">
                                                <a href="/administration/message/<?php echo $message['conv_id']; ?>">Подробнее</a>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach;
                                unset($message);
                            endif;?>
                        </div>
                    </div>
                    <?php include_once('./app_fold/views/pagination.php'); ?>
                </div>
            </div>
        </div><!-- content_col -->
    </div>
</div><!-- content -->
