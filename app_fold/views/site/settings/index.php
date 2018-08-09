<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<form action="" method="post">
    <div class="admin_form_buts_wrap_container">
        <div class="admin_form_buts_wrap parent">
            <input type="submit" name="bt_save_index" value="Сохранить" class="video_admin_form_send">
        </div>
    </div>
    <div class="video_admin_form site_info">
        <div class="anketa_form_line parent">
            <div class="anketa_form_h"><div class="anketa_form_h_cell">Заголовок</div></div>
            <input type="text" class="anketa_form_in anketa_form_in_long" name="i_title" value="<?php if (!empty($index_title)) { echo $index_title; }?>" maxlength="40"/>
        </div>
        <div class="anketa_form_line parent">
            <div class="anketa_form_h"><div class="anketa_form_h_cell">Текст</div></div>
            <textarea name="i_text" class="journal_form_textarea admin_form_txt_middle" maxlength="300"><?php if (!empty($index_text)) { echo $index_text; }?></textarea>
        </div>
    </div>
</form>