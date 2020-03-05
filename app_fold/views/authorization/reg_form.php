<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<form action="/registry" class="sing-in_form" method="post">
    <div class="sing-in_h">через социальную сеть:</div>
    <?php include_once('./app_fold/views/authorization/auth_soc_item.php'); ?>
    <div class="sing-in_h">или введите данные:</div>
    <input type="text" name="email" placeholder="e-mail" value="<?php if(!empty($email)): echo $email; endif;?>" maxlength="255" autocomplete="off" class="sing-in_in valid_email"/>
    <input type="password" name="password" placeholder="пароль" value="" maxlength="255" minlength="8" autocomplete="off" class="sing-in_in"/>
    <input type="password" name="password_confirm" placeholder="подтвердить пароль" value="" maxlength="255" minlength="8" autocomplete="off" class="sing-in_in"/>
    <div class="sing-in_h tren_form_block_check_wrap">
        <input type="checkbox" name="cb_politics" class="tren_form_block_check" id="cb-politics" required="required" checked="checked" />
        <label for="cb-politics">согласие на
            <a href="#" class="reg_in_link policy">обработку персональных данных</a>
        </label>
    </div>
    <input type="hidden" name="hi_return" value="/profile/" />
    <input type="submit" value="Зарегистрироваться" class="sing-in_but defaultActionButton" name="bt_registry"/>
    <div class="reg_in_link_wrap">
        <a href="/login" class="reg_in_link login_form_up">авторизация</a>
        <a href="/restore" class="reg_in_link login_form_up">восстановление пароля</a>
    </div>
</form>
