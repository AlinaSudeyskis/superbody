<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$breadcrumbs = array('/contacts' => 'Контакты');
include_once('./app_fold/views/breadcrumb.php');
?>
<div class="container" id="content">
    <div class="row" style="background: url(/img/contacts.jpg) top no-repeat; background-size: cover; margin-bottom: 20px;">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 contact_wrap">
            <div class="contact_h"><?php if (!empty($site_info['contacts_text1'])): echo $site_info['contacts_text1']; endif;?></div>
            <div class="contact_desk">
                <div class="contact_desc"><?php if (!empty($site_info['contacts_text2'])): echo $site_info['contacts_text2']; endif; ?></div>
                <div class="contact_tel">
                    <?php include('./app_fold/views/header/messengers.php'); ?>
                    <?php if (!empty($site_info['phone'])) :?>
                        <span><?php echo $site_info['phone']; ?></span>
                    <?php endif;?>
                </div>
                <?php if (!empty($site_info['email'])):?>
                    <div class="contact_mail"><i class="fa fa-envelope"></i><span><?php echo $site_info['email']; ?></span></div>
                <?php endif;?>
                <?php $pm_contacts = true;
                include('./app_fold/views/header/header_soc.php');
                $pm_contacts = false;?>
            </div>
            <div>
                <form action="" method="post" class="contact_form">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"><input type="text" name="email" placeholder="Укажите Email" class="contact_in valid_email" maxlength="255" /></div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"><input type="text" name="name" placeholder="Ваше имя" class="contact_in" maxlength="255" /></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="contact_textarea_wrap">
                                <textarea name="message" placeholder="Ваше сообщение" class="contact_textarea" maxlength="1000"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="contact_but_desk">
                                <div class="sing-in_h tren_form_block_check_wrap" style="position: relative;">
                                    <input type="checkbox" name="cb_politics" class="tren_form_block_check" id="cb-politics" required="required" checked="checked"/>
                                    <label for="cb-politics">согласие на
                                        <a href="#" class="reg_in_link policy">обработку персональных данных</a>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-7">
                            <div class="g-recaptcha" data-sitekey="6LdyBmYUAAAAANOua7WQ-8GHQlw9TWGnnHf7rPeB"></div>
                        </div>
                        <div class="col-lg-6 col-md-5 col-sm-12 col-xs-12" style="text-align: center; margin-bottom: 10px;">
                            <input type="submit" name="bt_send_message" value="отправить сообщение" class="contact_but">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php include_once('./app_fold/views/site/content/coaches_reviews_block.php'); ?>
    <?php include_once('./app_fold/views/site/content/gallery.php'); ?>
</div><!-- content -->
