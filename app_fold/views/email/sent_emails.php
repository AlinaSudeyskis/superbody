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
                            <h3>Эл. письма</h3>
                            <?php include_once('./app_fold/views/email/email_menu_links.php'); ?>
                        </div>
                        <?php include_once('./app_fold/views/email/emails_menu.php'); ?>
                    </div>
                </div>
                <div class="kurs_block_val">
                    <div class="admin_list">
                        <?php if (!empty($sent_emails)) :
                            foreach ($sent_emails as $email) : ?>
                                <div class="admin_item emails">
                                    <a class="admin_feedback_link parent" href="/administration/sent/email/<?php echo $email['id']; ?>">
                                        <span class="admin_feedback_cont parent">
                                            <span class="admin_feedback_info parent"><?php echo $email['subject']; ?></span>
                                            <span class="admin_feedback_txt"><?php echo $email['text']; ?></span>
                                        </span>
                                        <span class="admin_feedback_time_wrap parent">
                                            <span class="admin_feedback_time">
                                                <?php if($email['whom_type'] == 'select'):
                                                    echo $email['user_email'];
                                                elseif($email['whom_type'] == 'all'):
                                                    echo 'Всем';
                                                endif;?>
                                            </span>
                                        </span>
                                    </a>
                                </div>
                            <?php endforeach;
                            unset($email); ?>
                        <?php else: ?>
                            <h3 class="info">Информация не найдена</h3>
                        <?php endif;?>
                    </div>
                </div>
            </div>
        </div><!-- content_col -->
    </div>
</div><!-- content -->