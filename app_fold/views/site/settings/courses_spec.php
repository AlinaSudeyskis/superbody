<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="anketa_block_item">
    <div class="anketa_block_item_cont">
        <form action="" method="post" class="anketa_form site_info">
            <div class="tren_form_block_check_wrap"></div>
            <div class="tren_form_block_check_wrap">
                <input type="checkbox" name="cb_spec_display" <?php if(!empty($spec_display)): ?>checked="checked"<?php endif; ?> class="tren_form_block_check" id="tren_form_block_check1bg">
                <label for="tren_form_block_check1bg">Отобразить блок "Новые курсы/Спец. предложение"</label>
            </div>

            <div class="anketa_form_buts_wrap parent">
                <input type="submit" name="bt_save_spec" value="Сохранить" class="admin_form_submit">
            </div>
        </form>
    </div>
</div>