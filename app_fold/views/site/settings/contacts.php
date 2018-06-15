<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="anketa_block_item">
    <div class="anketa_block_item_h"></div>
    <div class="anketa_block_item_cont">
        <form action="" method="post" class="anketa_form site_info">
            <div class="anketa_form_line parent">
                <div class="anketa_form_h"><div class="anketa_form_h_cell">Email</div></div>
                <input type="text" class="anketa_form_in anketa_form_in_long valid_email" name="email" value="<?php if (!empty($email)) { echo $email; }?>" maxlength="255"/>
            </div>
            <div class="anketa_form_line parent">
                <div class="anketa_form_h"><div class="anketa_form_h_cell">Телефон</div></div>
                <input type="text" class="anketa_form_in anketa_form_in_long" name="phone" value="<?php if (!empty($phone)) { echo $phone; }?>" maxlength="255"/>
            </div>

            <div class="anketa_form_line parent">
                <div class="anketa_form_h"><div class="anketa_form_h_cell">Контакты (текст 1)</div></div>
                <textarea name="contacts_text1" class="journal_form_textarea admin_form_txt_middle" maxlength="300"><?php if (!empty($contacts_text1)) { echo $contacts_text1; }?></textarea>
            </div>

            <div class="anketa_form_line parent">
                <div class="anketa_form_h"><div class="anketa_form_h_cell">Контакты (текст 2)</div></div>
                <textarea name="contacts_text2" class="journal_form_textarea admin_form_txt_middle" maxlength="300"><?php if (!empty($contacts_text2)) { echo $contacts_text2; }?></textarea>
            </div>

            <div class="anketa_form_buts_wrap parent">
                <input type="submit" name="bt_save_contacts" value="Сохранить" class="admin_form_submit">
            </div>
        </form>
    </div>
</div>