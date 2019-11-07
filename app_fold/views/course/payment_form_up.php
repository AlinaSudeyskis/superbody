<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$display = (!empty($purchase_up) and $purchase_up === true) ? 'class="ref_pop-up"' : '';
?>
<div id="purchase_pop-up" <?php echo $display; ?>>
    <div class="purchase_pop-up_close"></div>
    <span id="block-message" <?php if (empty($message)){ echo 'style="display: none;"';}?>>
        <?php if (!empty($message)) :
            echo $message;
        endif;?>
    </span>
    <div class="purchase_pop-up_cont">
        <div class="purchase_pop-up_h purchase_form">
            <?php if(!empty($course)): ?>
                <?php include_once('./app_fold/views/course/purchase_form.php');?>
            <?php endif; ?>
        </div>
        <div class="purchase_pop-up_h auth_form">
            <div class="parent kurs_cur_wrap" style="justify-content: center;  -webkit-justify-content: center;">
                <div class="kurs_cur_h">Авторизация</div>
            </div>
            <div class="parent kurs_cur_wrap separator"></div>
            <div class="sing-in page_form">
                <?php include('./app_fold/views/authorization/auth_form.php');?>
            </div>
            <a href="#" class="return_purchase">Назад на форму покупки</a>
        </div>
    </div>
</div><!-- purchase_pop-up -->
