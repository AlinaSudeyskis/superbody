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
                <div class="content_block_h parent">
                    <h3>Диалог с пользователем</h3>
                    <div class="content_block_h_buts">
                        <div class="content_block_h_slide kurs_slide"></div>
                        <div class="content_block_h_close"></div>
                    </div>
                </div>
                <div class="kurs_block_val">
                    <div class="video_admin_form">
                        <div class="feedback_chat">
                            <?php if (!empty($fb_user_messages)) :
                                $last_element = count($fb_user_messages)-1;
                                foreach ($fb_user_messages as $message) :?>
                                    <div class="admin_feedback_post_line">
                                        <?php if ($message['admin_id'] == 0) : ?>
                                            <span class="admin_feedback_post_mail">
                                                <?php if (!empty($message['user_name'])) {
                                                    echo $message['user_name'];
                                                    if (!empty($message['user_email'])) {
                                                        echo  ' [' . $message['user_email'] . ']';
                                                    }
                                                }
                                                else {
                                                    echo $message['user_email'];
                                                }?>
                                            </span>
                                        <?php else : ?>
                                            <span class="admin_feedback_post_mail admin"><?php echo $message['user_name']; ?></span>
                                        <?php endif; ?>
                                        <span class="admin_feedback_post_date"><?php echo $message['date']; ?></span>
                                        <span class="admin_feedback_post_time"><?php echo $message['time']; ?></span>
                                    </div>
                                    <div class="admin_feedback_post_txt"><?php echo $message['text']; ?></div>
                                <?php endforeach;
                                unset($message);?>
                            <?php endif;?>
                        </div>
                        <form action="" class="mess_block_form" method="post">
                            <input type="hidden" name="i_conv_id" value="<?php echo $fb_conv_id;?>"/>
                            <textarea name="ta_message_text" class="mess_block_in" placeholder="Текст сообщения"></textarea>
                            <input type="submit" name="bt_send_message" value="Отправить" class="mess_block_but">
                        </form>
                    </div>
                </div>
            </div>
        </div><!-- content_col -->
    </div>
</div><!-- content -->
