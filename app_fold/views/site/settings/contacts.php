<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<form action="" method="post" enctype="multipart/form-data">
    <div class="admin_form_buts_wrap_container">
        <div class="admin_form_buts_wrap parent">
            <input type="submit" name="bt_save_contacts" value="Сохранить" class="video_admin_form_send defaultActionButton">
        </div>
    </div>

    <div class="video_admin_form site_info">
        <div class="anketa_form_line parent">
            <div class="anketa_form_h">
                <div class="anketa_form_h_cell">Фоновое изображение</div>
                <div class="h_subtitle">(1900х650)</div>
            </div>
            <div class="video_down_line parent">
                <div class="parent kurs_cur_wrap">
                    <div class="video_down_line_but_wrap">
                        <label for="video_down_line_but1cs" class="video_down_line_but">
                            <input type="hidden" name="MAX_FILE_SIZE" value="2097152">
                            <input type="file" name="contact_file" class="admin_form_videofile" id="video_down_line_but1cs" accept="image/jpeg,image/png">
                            <span>Выберите файл</span>
                        </label>
                    </div>
                    <div class="video_down_line_name" style="width:45% !important;">Файл не выбран</div>
                </div>
            </div>
        </div>
        <?php if (!empty($contacts_bg)) : ?>
            <div class="anketa_form_line parent">
                <div class="anketa_form_h"><div class="anketa_form_h_cell"></div></div>
                <div class="anketa_form_info_cont"><img src="<?php echo $contacts_bg;?>" alt=""></div>
            </div>
        <?php endif;?>
        <div class="anketa_form_line parent">
            <div class="anketa_form_h"><div class="anketa_form_h_cell">Email</div></div>
            <input type="text" class="anketa_form_in anketa_form_in_long valid_email" name="email" value="<?php if (!empty($email)) { echo $email; }?>" maxlength="255"/>
        </div>
        <div class="anketa_form_line parent">
            <div class="anketa_form_h"><div class="anketa_form_h_cell">Телефон</div></div>
            <input type="text" class="anketa_form_in anketa_form_in_long" name="phone" value="<?php if (!empty($phone)) { echo $phone; }?>" maxlength="255"/>
        </div>

        <div class="anketa_form_line parent">
            <div class="anketa_form_h"><div class="anketa_form_h_cell">Messengers:</div></div>
        </div>
        <div class="anketa_form_line parent">
            <div class="anketa_form_h"><div class="anketa_form_h_cell"><i class="fab fa-telegram-plane" aria-hidden="true" title="Telegram"></i></div></div>
            <input type="text" class="anketa_form_in anketa_form_in_long" name="mes_telegram" value="<?php if (!empty($mes_telegram)) { echo $mes_telegram; }?>" maxlength="255"/>
        </div>
        <div class="anketa_form_line parent">
            <div class="anketa_form_h"><div class="anketa_form_h_cell"><i class="fab fa-whatsapp" aria-hidden="true" title="WhatsApp"></i></div></div>
            <input type="text" class="anketa_form_in anketa_form_in_long" name="mes_whatsapp" value="<?php if (!empty($mes_whatsapp)) { echo $mes_whatsapp; }?>" maxlength="255"/>
        </div>
        <div class="anketa_form_line parent">
            <div class="anketa_form_h"><div class="anketa_form_h_cell"><i class="fab fa-viber" aria-hidden="true" title="Viber"></i></div></div>
            <input type="text" class="anketa_form_in anketa_form_in_long" name="mes_viber" value="<?php if (!empty($mes_viber)) { echo $mes_viber; }?>" maxlength="255"/>
        </div>
        <div class="anketa_form_line parent">
            <div class="anketa_form_h"><div class="anketa_form_h_cell"></div></div>
        </div>

        <div class="anketa_form_line parent">
            <div class="anketa_form_h"><div class="anketa_form_h_cell">Контакты (текст 1)</div></div>
            <textarea name="contacts_text1" class="journal_form_textarea admin_form_txt_middle" maxlength="300"><?php if (!empty($contacts_text1)) { echo $contacts_text1; }?></textarea>
        </div>

        <div class="anketa_form_line parent">
            <div class="anketa_form_h"><div class="anketa_form_h_cell">Контакты (текст 2)</div></div>
            <textarea name="contacts_text2" class="journal_form_textarea admin_form_txt_middle" maxlength="300"><?php if (!empty($contacts_text2)) { echo $contacts_text2; }?></textarea>
        </div>
    </div>
</form>