<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<form action="/login" class="sing-in_form" method="post">
    <div class="sing-in_h">через социальную сеть:</div>
    <?php include('./app_fold/views/authorization/auth_soc_item.php'); ?>
    <div class="sing-in_h" style="margin-top: 10px;">или авторизуйтесь:</div>
    <input type="text" class="sing-in_in valid_email" placeholder="e-mail" name="email" value="<?php if(!empty($email)): echo $email; endif;?>" maxlength="255"/>
    <input type="password" class="sing-in_in" placeholder="пароль" name="password" value="" maxlength="255" minlength="8"/>
    <div class="sing-in_h tren_form_block_check_wrap">
        <input type="checkbox" name="cb_politics" class="tren_form_block_check" id="cb-politics<?php if(!empty($af_id)): echo $af_id; endif;?>" required="required" checked="checked"/>
        <label for="cb-politics<?php if(!empty($af_id)): echo $af_id; endif;?>">согласие на
            <a href="#" class="reg_in_link policy">обработку персональных данных</a>
        </label>
    </div>
    <input type="hidden" name="hi_return" value="/profile/" />
    <input type="submit" value="войти" class="sing-in_but defaultActionButton" name="bt_login"/>
    <div class="reg_in_link_wrap">
        <a href="/registry" class="reg_in_link login_form_up">регистрация</a>
        <a href="/restore" class="reg_in_link login_form_up">восстановление пароля</a>
    </div>
</form>
