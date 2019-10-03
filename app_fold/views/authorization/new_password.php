<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="content" class="container">
    <?php if (!empty($login_mess)) :
        echo $login_mess;
    else:?>
        <div class="sing-in page_form">
            <form action="" class="sing-in_form" method="post">
                <div class="sing-in_h">введите пароль:</div>
                <input type="password" name="i_password" class="sing-in_in" value="" maxlength="255" minlength="8" required/>
                <div class="sing-in_h">подтвердите пароль:</div>
                <input type="password" name="i_confirm_password" class="sing-in_in" value="" maxlength="255" minlength="8" required/>
                <input type="submit" name="bt_restore_password" value="Сохранить" id="defaultActionButton"  class="sing-in_but"/>
            </form>
        </div>
    <?php endif;?>
</div><!-- content -->
