<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<form action="" method="post">
    <div class="admin_form_buts_wrap_container">
        <div class="admin_form_buts_wrap parent">
            <input type="submit" name="bt_save_spec" value="Сохранить" id="defaultActionButton"  class="video_admin_form_send">
        </div>
    </div>
    <div class="video_admin_form site_info">
        <div class="tren_form_block_check_wrap">
            <input type="checkbox" name="cb_spec_display" <?php if(!empty($spec_display)): ?>checked="checked"<?php endif; ?> class="tren_form_block_check" id="tren_form_block_check1bg">
            <label for="tren_form_block_check1bg">Отобразить блок "Новые курсы/Спец. предложение"</label>
        </div>
    </div>
</form>