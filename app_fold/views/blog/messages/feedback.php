<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="body">
    <div style="margin-top: 20px;">
        <form action="" method="post">
            <p><input type="text" name="i_name" placeholder="Ваше имя" maxlength="255" required="required"/></p>
            <p><input type="text" name="i_email" placeholder="E-mail" maxlength="255" required="required"/></p>
            <p><textarea name="ta_message_text" placeholder="Текст сообщения" required="required"></textarea></p>
            <p><input type="submit" name="bt_send_message" value="Отправить"/></p>
        </form>
    </div>
</div>
