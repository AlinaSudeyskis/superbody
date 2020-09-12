<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="header">
    <div class="hid_header">
        <?php include_once('./app_fold/views/header/soc.php');?>
        <div class="header_mid header_mid_profile parent">
            <?php include_once('./app_fold/views/header/menu.php');?>
        </div>
    </div>
    <?php if (!empty($site_info['advertising_horizontal']) and !empty($user_session) and $user_session['advertising'] == 1): ?>
        <div class="header_bg_wrap">
            <?php echo $site_info['advertising_horizontal']; ?>
        </div>
    <?php endif; ?>
</div><!-- header -->
