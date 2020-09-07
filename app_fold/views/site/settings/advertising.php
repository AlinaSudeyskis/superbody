<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<form action="" method="post">
    <div class="admin_form_buts_wrap_container">
        <div class="admin_form_buts_wrap parent">
            <input type="submit" name="bt_save_advertising" value="Сохранить" class="video_admin_form_send defaultActionButton">
        </div>
    </div>
    <div class="video_admin_form site_info">
        <div class="anketa_form_line parent">
            <div class="anketa_form_h"><div class="anketa_form_h_cell">Мобильная:</div></div>
            <textarea name="ta_advertising_mobile" class="journal_form_textarea admin_form_txt_middle"><?php if (!empty($advertising_mobile)) { echo $advertising_mobile; }?></textarea>
        </div>
        <div class="anketa_form_line parent">
            <div class="anketa_form_h"><div class="anketa_form_h_cell">Вертикальная:</div></div>
            <textarea name="ta_advertising_vertical" class="journal_form_textarea admin_form_txt_middle"><?php if (!empty($advertising_vertical)) { echo $advertising_vertical; }?></textarea>
        </div>
        <div class="anketa_form_line parent">
            <div class="anketa_form_h"><div class="anketa_form_h_cell">Горизонтальная:</div></div>
            <textarea name="ta_advertising_horizontal" class="journal_form_textarea admin_form_txt_middle"><?php if (!empty($advertising_horizontal)) { echo $advertising_horizontal; }?></textarea>
        </div>
    </div>
</form>
