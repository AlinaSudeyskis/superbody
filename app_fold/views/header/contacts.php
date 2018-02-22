<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="header">
    <?php include_once('./app_fold/views/header/soc.php');?>
    <div class="header_mid parent">
        <?php include_once('./app_fold/views/header/menu.php');?>
    </div>
    <!--<div id="map">
        <script type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?sid=rsT6lMZP575RlUWVAlnrOXyXLe4jZqEj&amp;width=100%&amp;height=500&amp;lang=ru_RU&amp;sourceType=constructor&amp;scroll=true"></script>
    </div>-->
    <div class="header_bg_wrap in_bg_wrap" style="display: none;">
        <div class="header_bg">
            <?php include_once('./app_fold/views/header/slider.php'); ?>
        </div>
        <?php include_once('./app_fold/views/header/banner_js.php');?>
    </div>
</div><!-- header -->

<div class="prezent_head hide_chart">
    <h1 class="prezent_h1">контактные данные</h1>
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12"><?php if (!empty($site_info['contacts_text1'])): echo $site_info['contacts_text1']; endif;?></div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-7 col-sm-7 col-xs-12">
                <form action="#" class="contact_form">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"><input class="contact_in" type="text" placeholder="Ваше имя"></div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"><input class="contact_in" type="text" placeholder="Ваш телефон"></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="contact_textarea_wrap">
                                <textarea class="contact_textarea" placeholder="Ваше сообщение"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"><input class="contact_but" type="submit" value="отправить сообщение"></div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 contact_but_desk">убедитесь в правильности введенных данных</div>
                    </div>
                </form>
            </div>
            <div class="col-lg-6 col-md-5 col-sm-5 col-xs-12 contact_desk">
                <?php if (!empty($site_info['contacts_text2'])): echo $site_info['contacts_text2']; endif;
                if (!empty($site_info['phone'])) :?>
                    <div class="contact_tel"><?php echo $site_info['phone']; ?></div>
                <?php endif;
                if (!empty($site_info['email'])):?>
                    <div class="contact_mail"><?php echo $site_info['email']; ?></div>
                <?php endif;?>
            </div>
        </div>
    </div>
    <div class="up_but up_but_bot hide_chart"></div>
</div><!-- prezent_head -->
