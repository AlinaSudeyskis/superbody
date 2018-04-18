<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php if(empty($user_session)): ?>
    <?php include_once('./app_fold/views/authorization/auth_soc_item.php'); ?>
    <div class="sing-in_h tren_form_block_check_wrap">
        <input type="checkbox" name="cb_politics" class="tren_form_block_check" id="cb-politics" required="required" />
        <label for="cb-politics">согласие на
            <a href="#" class="reg_in_link policy">обработку персональных данных</a>
        </label>
    </div>
    <div class="parent kurs_cur_wrap">
        <div class="kurs_block_h">Email:</div>
        <input type="text" name="email" required="required" value="" class="admin_form_txt admin_form_txt_short" autocomplete="off"/>
    </div>
    <div class="parent kurs_cur_wrap separator"></div>
    <input type="hidden" name="hi_return" value="/course/<?php echo $course_id; ?>" />
<?php endif; ?>