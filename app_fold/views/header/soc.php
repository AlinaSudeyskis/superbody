<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="header_soc_wrap parent"<?php if(!empty($user_session) and $user_session['activated'] == 0):?> style="background-color: #e25050;"<?php endif;?>>
    <?php if (!empty($site_info['phone'])):?>
        <div class="header_tel">
            <?php include('./app_fold/views/header/messengers.php'); ?>
            <?php if($site_info['phone']):?>
                <span><?php echo $site_info['phone']; ?></span>
            <?php endif;?>
        </div>
    <?php endif;?>
        <span class="header_notification">
            <?php if(!empty($user_session) and $user_session['activated'] == 0):?>
                <?php echo $this->list_errors['text'][218]; ?>
            <?php endif;?>
        </span>
    <?php include('./app_fold/views/header/header_soc.php'); ?>
</div>
