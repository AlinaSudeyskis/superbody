<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="content" class="container">
    <?php if (!empty($login_mess)) :
        echo $login_mess;
    else:?>
        <div class="sing-in page_form">
            <div class="sing-in_h">введите e-mail:</div>
            <form action="" class="sing-in_form" method="post">
                <input type="text" class="sing-in_in" placeholder="e-mail" name="email" value="" maxlength="255"/>
                <input type="submit" value="Восставновить" class="sing-in_but" name="bt_restore"/>
            </form>
            <div class="reg_in_link_wrap">
                <a href="/login" class="reg_in_link">авторизация</a>
                <a href="/registry" class="reg_in_link">регистрация</a>
            </div>
        </div>
    <?php endif;?>
</div><!-- content -->
