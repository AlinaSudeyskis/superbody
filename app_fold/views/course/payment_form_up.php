<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$display = (!empty($purchase_up) and $purchase_up === true) ? 'style="display: block;"' : '';
?>
<div id="purchase_pop-up" <?php echo $display; ?>>
    <div class="purchase_pop-up_cont">
        <div class="purchase_pop-up_close"></div>
        <div class="purchase_pop-up_h">
            <?php include_once('./app_fold/views/authorization/short_auth.php'); ?>
            <form action="" method="post" class="anketa_form video_admin_form purchase_form">
                <?php include_once('./app_fold/views/course/course_payment_item.php');?>
            </form>
        </div>
    </div>
</div><!-- purchase_pop-up -->
