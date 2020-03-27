<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="header_soc_wrap parent"<?php if(!empty($user_session) and $user_session['activated'] == 0):?> style="background-color: #e25050;"<?php endif;?>>
        <div class="header_tel">
            <?php include('./app_fold/views/header/messengers.php'); ?>
            <?php if(!empty($site_info['phone'])):?>
                <span><?php echo $site_info['phone']; ?></span>
            <?php endif;?>
        </div>
        <span class="header_notification">
            <?php if(!empty($user_session) and $user_session['activated'] == 0 and empty($user_session['login_from'])):?>
                <?php echo $this->list_errors['text'][218]; ?>
            <?php elseif(!empty($user_session) and is_numeric($user_session['login_from'])): ?>
                <form action="/login" method="post">
                    <input type="hidden" name="return_url" value="<?php echo $_SERVER['REQUEST_URI']; ?>">
                    <input type="hidden" name="login_from" value="<?php echo $user_session['login_from']; ?>">
                    <input type="submit" name="bt_login_back" value="Вернуться в профиль администратора" class="login_back">
                </form>
            <?php endif;?>
        </span>
    <?php include('./app_fold/views/header/header_soc.php'); ?>
</div>
