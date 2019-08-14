<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="prezent_head">
    <h1 class="prezent_h1">контактные данные</h1>
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12" style="font-size: 20px;"><?php if (!empty($site_info['contacts_text1'])): echo $site_info['contacts_text1']; endif;?></div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-7 col-sm-7 col-xs-12">
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
                            <div class="col-lg-12">
                                <div class="g-recaptcha" data-sitekey="6LdyBmYUAAAAANOua7WQ-8GHQlw9TWGnnHf7rPeB"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" style="margin: 0 auto; float: unset;">
                            <input type="submit" name="bt_send_message" value="отправить сообщение" class="contact_but">
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-lg-6 col-md-5 col-sm-5 col-xs-12 contact_desk">
                <?php if (!empty($site_info['contacts_text2'])): echo $site_info['contacts_text2']; endif;
                if (!empty($site_info['phone'])) :?>
                    <div class="contact_tel"><i class="fa fa-mobile"></i><span><?php echo $site_info['phone']; ?></span></div>
                <?php endif;
                if (!empty($site_info['email'])):?>
                    <div class="contact_mail"><i class="fa fa-envelope"></i><span><?php echo $site_info['email']; ?></span></div>
                <?php endif;?>
                <?php $pm_contacts = true;
                include('./app_fold/views/header/header_soc.php');
                $pm_contacts = false;?>
            </div>
        </div>
    </div>
    <div class="up_but up_but_bot"></div>
</div><!-- prezent_head -->
<div id="content" class="container">
    <?php include_once('./app_fold/views/site/content/coaches_reviews_block.php'); ?>
    <?php include_once('./app_fold/views/site/content/gallery.php'); ?>
</div><!-- content -->
