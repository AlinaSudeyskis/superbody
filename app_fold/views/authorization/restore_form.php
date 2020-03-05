<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<form action="/restore" class="sing-in_form" method="post">
    <div class="sing-in_h">введите e-mail:</div>
    <input type="text" class="sing-in_in valid_email" placeholder="e-mail" name="email" value="" maxlength="255" required/>
    <input type="submit" value="Восстановить" class="sing-in_but" name="bt_restore"/>
    <div class="reg_in_link_wrap">
        <a href="/login" class="reg_in_link login_form_up">авторизация</a>
        <a href="/registry" class="reg_in_link login_form_up">регистрация</a>
    </div>
</form>
