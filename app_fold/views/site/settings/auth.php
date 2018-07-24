<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="anketa_block_item">
    <div class="anketa_block_item_cont">
        <form action="" method="post" class="anketa_form site_info">
            <div class="tren_form_block_check_wrap"></div>
            <div class="tren_form_block_check_wrap">
                <input type="checkbox" name="cb_auth_display" <?php if(!empty($auth_display)): ?>checked="checked"<?php endif; ?> class="tren_form_block_check" id="tren_form_block_check1bg">
                <label for="tren_form_block_check1bg">Отобразить блок "Авторизация/Регистрация"</label>
            </div>
            <div class="anketa_block_item_h">Блок регистрации</div>
            <div class="anketa_form_line parent">
                <div class="anketa_form_h"><div class="anketa_form_h_cell">Заголовок</div></div>
                <input type="text" name="i_title_1" value="<?php if (!empty($auth_title1)) { echo $auth_title1; }?>" class="anketa_form_in anketa_form_in_long" maxlength="30"/>
            </div>
            <div class="anketa_form_line parent">
                <div class="anketa_form_h"><div class="anketa_form_h_cell">Подзаголовок</div></div>
                <input type="text" name="i_subtitle_1" value="<?php if (!empty($auth_subtitle1)) { echo $auth_subtitle1; }?>" class="anketa_form_in anketa_form_in_long" maxlength="30"/>
            </div>
            <div class="anketa_form_line parent">
                <div class="anketa_form_h"><div class="anketa_form_h_cell">Текст</div></div>
                <textarea name="ta_text_1" class="journal_form_textarea admin_form_txt_middle" maxlength="150"><?php if (!empty($auth_text1)) { echo $auth_text1; }?></textarea>
            </div>
            <div class="anketa_form_line parent">
                <div class="anketa_form_h"><div class="anketa_form_h_cell">URL</div></div>
                <input type="text" name="i_url_1" value="<?php if (!empty($auth_url1)) { echo $auth_url1; }?>" class="anketa_form_in anketa_form_in_long" maxlength="255"/>
            </div>
            <div class="anketa_form_line parent">
                <div class="anketa_form_h"><div class="anketa_form_h_cell">Текст URL</div></div>
                <input type="text" name="i_url_name_1" value="<?php if (!empty($auth_url_name1)) { echo $auth_url_name1; }?>" class="anketa_form_in anketa_form_in_long" maxlength="30"/>
            </div>

            <div class="anketa_block_item_h">Блок авторизации</div>
            <div class="anketa_form_line parent">
                <div class="anketa_form_h"><div class="anketa_form_h_cell">Заголовок</div></div>
                <input type="text" name="i_title_2" value="<?php if (!empty($auth_title2)) { echo $auth_title2; }?>" class="anketa_form_in anketa_form_in_long" maxlength="30"/>
            </div>
            <div class="anketa_form_line parent">
                <div class="anketa_form_h"><div class="anketa_form_h_cell">Подзаголовок</div></div>
                <input type="text" name="i_subtitle_2" value="<?php if (!empty($auth_subtitle2)) { echo $auth_subtitle2; }?>" class="anketa_form_in anketa_form_in_long" maxlength="30"/>
            </div>
            <div class="anketa_form_line parent">
                <div class="anketa_form_h"><div class="anketa_form_h_cell">Текст</div></div>
                <textarea name="ta_text_2" class="journal_form_textarea admin_form_txt_middle" maxlength="150"><?php if (!empty($auth_text2)) { echo $auth_text2; }?></textarea>
            </div>
            <div class="anketa_form_line parent">
                <div class="anketa_form_h"><div class="anketa_form_h_cell">URL</div></div>
                <input type="text" name="i_url_2" value="<?php if (!empty($auth_url2)) { echo $auth_url2; }?>" class="anketa_form_in anketa_form_in_long" maxlength="255"/>
            </div>
            <div class="anketa_form_line parent">
                <div class="anketa_form_h"><div class="anketa_form_h_cell">Текст URL</div></div>
                <input type="text" name="i_url_name_2" value="<?php if (!empty($auth_url_name2)) { echo $auth_url_name2; }?>" class="anketa_form_in anketa_form_in_long" maxlength="15"/>
            </div>

            <div class="anketa_form_buts_wrap parent">
                <input type="submit" name="bt_save_auth" value="Сохранить" class="admin_form_submit">
            </div>
        </form>
    </div>
</div>