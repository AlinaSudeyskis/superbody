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
                        <?php if (!empty($addresses)) :
                            foreach ($addresses as $address) :
                                if(!empty($address)): ?>
                                    <div class="admin_item parent">
                                        <div class="admin_ava"></div>
                                        <div class="admin_cont">
                                            <div class="admin_name">
                                                <a href="/administration/email/address/<?php echo $address['id']; ?>">
                                                    <?php echo $address['name']; ?> [<?php echo $address['email']; ?>]
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif;
                            endforeach;
                            unset($address);
                        endif;?>
                    </div>
                </div>
            </div>
        </div><!-- content_col -->
    </div>
</div><!-- content -->