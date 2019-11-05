<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="content" class="container">
    <?php if (!empty($login_mess)) { echo $login_mess; } ?>
    <div class="sing-in page_form">
        <?php include_once('./app_fold/views/authorization/reg_form.php'); ?>
    </div>
</div><!-- content -->
