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
                            <a href="/administration/emails/addresses/new" class="add_tab_but">Добавить эл. адрес</a>
                        </div>
                        <?php include_once('./app_fold/views/email/emails_menu.php'); ?>
                    </div>
                </div>
                <div class="kurs_block_val">
                    <div class="admin_list">
                        <?php if (!empty($emails)) :
                            foreach ($emails as $email) : ?>
                                <div class="admin_item emails">
                                    <a class="admin_feedback_link parent" href="/administration/email/<?php echo $email['id']; ?>">
                                    <span class="admin_feedback_time_wrap parent">
                                        <span class="admin_feedback_time"><?php echo $email['email']; ?></span>
                                        <span class="admin_feedback_date"></span>
                                    </span>
                                    <span class="admin_feedback_cont parent">
                                        <span class="admin_feedback_info parent">
                                            <!--<span class="admin_feedback_info_dialog"><?php /*echo $email['fb_new']; */?></span>-->
                                            <span class="admin_feedback_info_mail"><?php echo $email['name']; ?></span>
                                        </span>
                                        <span class="admin_feedback_txt"><?php echo $email['subject']; ?></span>
                                    </span>
                                    </a>
                                </div>
                            <?php endforeach;
                            unset($email);
                        endif;?>
                        <!--<iframe src="/email_sample" width="100%" height="500"></iframe>-->
                    </div>
                </div>
            </div>
        </div><!-- content_col -->
    </div>
</div><!-- content -->