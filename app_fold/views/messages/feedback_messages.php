<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="content" class="container">
    <div class="row">
        <div class="col-lg-2 left_sidebar">
            <?php include_once('./app_fold/views/admin/admin_menu.php'); ?>
        </div><!-- left_sidebar -->
        <div class="col-lg-10 content_col">
            <div class="content_block">
                <div class="content_block_container_wrap">
                    <div class="content_block_container">
                        <div class="content_block_h new_content_block_h parent">
                            <h3>Обратная связь</h3>
                        </div>
                    </div>
                </div>
                <div class="kurs_block_val">
                    <div class="admin_list">
                        <?php if (!empty($fb_messages)) :
                            foreach ($fb_messages as $conv) : ?>
                                <div class="admin_item">
                                    <a class="admin_feedback_link parent" href="/administration/feedback/<?php echo $conv['url']; ?>">
                                        <span class="admin_feedback_time_wrap parent">
                                            <span class="admin_feedback_time"><?php echo $conv['time']; ?></span>
                                            <span class="admin_feedback_date"><?php echo $conv['date']; ?></span>
                                        </span>
                                        <span class="admin_feedback_cont parent">
                                            <span class="admin_feedback_info parent">
                                                <span class="admin_feedback_info_dialog"><?php echo $conv['fb_new']; ?></span>
                                                <span class="admin_feedback_info_mail"><?php echo $conv['user_name']; ?></span>
                                            </span>
                                            <?php if(!empty($conv['admin_name'])):?>
                                                <span class="admin_feedback_answer">Ответ: </span>
                                            <?php endif;?>
                                            <span class="admin_feedback_txt"><?php echo $conv['text']; ?></span>
                                        </span>
                                    </a>
                                </div>
                            <?php endforeach;
                            unset($conv);
                        endif;?>
                    </div>
                    <?php include_once('./app_fold/views/pagination.php'); ?>
                </div>
            </div>
        </div><!-- content_col -->
    </div>
</div><!-- content -->
