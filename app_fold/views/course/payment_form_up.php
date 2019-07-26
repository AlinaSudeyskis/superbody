<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$display = (!empty($purchase_up) and $purchase_up === true) ? 'class="ref_pop-up"' : '';
?>
<div id="purchase_pop-up" <?php echo $display; ?>>
    <div class="purchase_pop-up_close"></div>
    <span id="block-message" <?php if (!empty($message)){ echo 'style="display: block;"';}?>>
        <?php if (!empty($message)) :
            echo $message;
        endif;?>
    </span>
    <div class="purchase_pop-up_cont">
        <div class="purchase_pop-up_h purchase_form">
            <?php if(!empty($course)): ?>
                <div class="parent kurs_cur_wrap" style="justify-content: center; ">
                    <div class="kurs_cur_h"><?php if(!empty($course)): echo $course['name']; endif; ?></div>
                </div>
                <div class="parent kurs_cur_wrap separator"></div>
                <?php include_once('./app_fold/views/authorization/short_auth.php'); ?>
                <?php include_once('./app_fold/views/course/course_payment_item.php');?>
            <?php endif; ?>
        </div>
    </div>
</div><!-- purchase_pop-up -->
