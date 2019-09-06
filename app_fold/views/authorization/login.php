<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="content" class="container">
    <?php if (!empty($login_mess)) { echo $login_mess; } ?>
    <div class="sing-in page_form">
        <form action="" class="sing-in_form" method="post">
            <div class="sing-in_h">через социальную сеть:</div>
            <?php include_once('./app_fold/views/authorization/auth_soc_item.php'); ?>
            <div class="sing-in_h">или авторизуйтесь:</div>
            <input type="text" class="sing-in_in valid_email" placeholder="e-mail" name="email" value="" maxlength="255" required/>
            <input type="password" class="sing-in_in" placeholder="пароль" name="password" value="" maxlength="255" minlength="8"/>
            <div class="sing-in_h tren_form_block_check_wrap">
                <input type="checkbox" name="cb_politics" class="tren_form_block_check" id="cb-politics" required="required" />
                <label for="cb-politics">согласие на
                    <a href="#" class="reg_in_link policy">обработку персональных данных</a>
                </label>
            </div>
            <input type="hidden" name="hi_return" value="/profile/" />
            <input type="submit" value="войти" class="sing-in_but" name="bt_login"/>
        </form>
        <div class="reg_in_link_wrap">
            <a href="/registry" class="reg_in_link">регистрация</a>
            <a href="/restore" class="reg_in_link">восстановление пароля</a>
        </div>
    </div>
</div><!-- content -->
