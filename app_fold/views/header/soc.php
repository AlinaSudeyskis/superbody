<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="header_soc_wrap parent">
    <?php if (!empty($site_info['phone'])):?>
        <div class="header_tel">
            <i class="fab fa-telegram-plane" aria-hidden="true"></i>
            <i class="fab fa-whatsapp" aria-hidden="true"></i>
            <i class="fab fa-viber" aria-hidden="true"></i>
            <span><?php echo $site_info['phone']; ?></span>
        </div>
    <?php endif;?>
    <?php include('./app_fold/views/header/header_soc.php'); ?>
</div>
