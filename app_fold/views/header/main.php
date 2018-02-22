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
                <input type="text" class="home_pop-up_in" placeholder="E-mail" name="subscribe_email" required="required" maxlength="255" />
                <input type="submit" value="Подписаться" class="home_pop-up_but" name="bt_subscribe"/>
            </form>
        </div>
    </div><!-- home_pop-up -->
<?php endif;?>

<div id="header">
    <div class="main_bg_wrap">
        <?php if (empty($user_session)) :?>
            <div class="sing-in">
                <form action="/login" class="sing-in_form" method="post">
                    <div class="sing-in_h">через социальную сеть:</div>
                    <?php include_once('./app_fold/views/authorization/auth_soc_item.php'); ?>
                    <div class="sing-in_h">или авторизуйтесь:</div>
                    <input type="text" class="sing-in_in" placeholder="e-mail" name="email" value="" maxlength="255"/>
                    <input type="password" class="sing-in_in" placeholder="пароль" name="password" value="" maxlength="255" minlength="8"/>
                    <div class="sing-in_h tren_form_block_check_wrap">
                        <input type="checkbox" name="cb_politics" class="tren_form_block_check" id="cb-politics" required="required" />
                        <label for="cb-politics">согласие на
                            <a href="#" class="reg_in_link policy">обработку персональных данных</a>
                        </label>
                    </div>
                    <input type="submit" value="войти" class="sing-in_but" name="bt_login"/>
                    <div class="reg_in_link_wrap">
                        <a href="/registry" class="reg_in_link">регистрация</a>
                        <a href="/restore" class="reg_in_link">восстановление пароля</a>
                    </div>
                </form>
            </div>
        <?php endif;?>
        <div class="header_bg header_bg_main">
            <?php include_once('./app_fold/views/header/slider.php'); ?>
        </div>
        <?php include_once('./app_fold/views/header/banner_js.php');?>
    </div>
    <?php include_once('./app_fold/views/header/soc.php');?>
    <div class="header_mid header_mid_profile parent">
        <?php include_once('./app_fold/views/header/menu.php');?>
    </div>
</div><!-- header -->
