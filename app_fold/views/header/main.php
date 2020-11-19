<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php if (empty($user_session)):?>
    <div id="home_pop-up">
        <div class="home_pop-up_cont">
            <div class="home_pop-up_close"></div>
            <div class="home_pop-up_h">Подписаться на рассылку</div>
            <div class="home_pop-up_desk">Будь в курсе всех новостей, новинок и акций!</div>
            <form action="" class="home_pop-up_form" id="up-subscribe_form" method="post">
                <input type="text" class="home_pop-up_in" placeholder="Имя" name="subscribe_name" required="required" maxlength="255" />
                <input type="text" class="home_pop-up_in valid_email" placeholder="E-mail" name="subscribe_email" required="required" maxlength="255" />
                <input type="submit" value="Подписаться" class="home_pop-up_but" name="bt_subscribe"/>
            </form>
        </div>
    </div><!-- home_pop-up -->
<?php endif;?>

<div id="header">
    <div class="main_bg_wrap <?php if(!empty($user_session)): ?>mob_hide<?php endif; ?>">
        <?php $main_banner = true;
        include_once('./app_fold/views/header/slider.php'); ?>
        <?php if (empty($user_session) and empty($advertising_banner)) :
            $af_id = 0; ?>
            <div class="sing-in">
                <?php include('./app_fold/views/authorization/auth_form.php'); ?>
            </div>
        <?php endif;?>
    </div>
    <?php include_once('./app_fold/views/header/soc.php');?>
    <div class="header_mid header_mid_profile parent">
        <?php include_once('./app_fold/views/header/menu.php');?>
    </div>
</div><!-- header -->
