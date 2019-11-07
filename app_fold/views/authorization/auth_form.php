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
        <input type="checkbox" name="cb_politics" class="tren_form_block_check" id="cb-politics<?php echo $af_id; ?>" required="required" checked="checked"/>
        <label for="cb-politics<?php echo $af_id; ?>">согласие на
            <a href="#" class="reg_in_link policy">обработку персональных данных</a>
        </label>
    </div>
    <input type="hidden" name="hi_return" value="/profile/" />
    <input type="submit" value="войти" class="sing-in_but" name="bt_login" id="defaultActionButton<?php echo $af_id; ?>"/>
    <div class="reg_in_link_wrap">
        <a href="/registry" class="reg_in_link">регистрация</a>
        <a href="/restore" class="reg_in_link">восстановление пароля</a>
    </div>
</form>
