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
</div><!-- header -->
<?php if(!empty($user_session) and $user_session['id'] == 4): ?>
    <p id="page-info">UTC time <strong><?php echo date('U'); ?></strong>. Page rendered in <strong>{elapsed_time}</strong> seconds. Memory usage <strong>{memory_usage}</strong>. <?php echo  (ENVIRONMENT === 'development') ?  'PHP Version <strong>' . phpversion() . '</strong>' : '' ?></p>
<?php endif; ?>
