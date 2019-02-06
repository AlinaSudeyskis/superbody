<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="content" class="container">
    <form action="" method="post" class="confirm_form">
        <h2 class="shop_block_title ordering_block_title">Текущий email</h2>
        <div class="block_subtitle"><?php echo $current_email; ?></div>
        <h2 class="shop_block_title ordering_block_title">Новый email</h2>
        <div class="block_subtitle"><?php echo $new_email; ?></div>
        <span class="tip">* Письмо с активацией email будет отправлено на новую почту.</span>
        <input type="submit" name="bt_confirm_change_email" value="Изменить email" class="form_send_big_but">
    </form>
</div>