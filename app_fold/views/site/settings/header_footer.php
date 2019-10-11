<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<form action="" method="post" enctype="multipart/form-data">
    <div class="admin_form_buts_wrap_container">
        <div class="admin_form_buts_wrap parent">
            <input type="submit" name="bt_save_header" value="Сохранить" id="defaultActionButton"  class="video_admin_form_send">
        </div>
    </div>
    <div class="video_admin_form site_info">
        <div class="anketa_form_line parent">
            <div class="anketa_form_h">
                <div class="anketa_form_h_cell">Файл баннера:</div>
                <div class="h_subtitle">(282х54)</div>
            </div>
            <div class="video_down_line parent">
                <div class="parent kurs_cur_wrap">
                    <div class="video_down_line_but_wrap">
                        <label for="video_down_line_but1cs" class="video_down_line_but">
                            <input type="hidden" name="MAX_FILE_SIZE" value="2097152" />
                            <input type="file" name="logotype_file" class="admin_form_videofile" id="video_down_line_but1cs" accept="image/jpeg,image/png" />
                            <span>Выберите файл</span>
                        </label>
                    </div>
                    <div class="video_down_line_name" style="width:45% !important;">Файл не выбран</div>
                </div>
            </div>
        </div>
        <?php if (!empty($logotype)) : ?>
            <div class="anketa_form_line parent">
                <div class="anketa_form_h"><div class="anketa_form_h_cell"></div></div>
                <div class="anketa_form_info_cont logotype"><img src="<?php echo $logotype;?>" alt=""></div>
            </div>
        <?php endif;?>
        <div class="anketa_form_line parent">
            <div class="anketa_form_h"><div class="anketa_form_h_cell">Ссылка на файл пользовательского соглашения</div></div>
            <textarea name="agreement" class="journal_form_textarea admin_form_txt_middle" maxlength="255"><?php if (!empty($agreement)) { echo $agreement; }?></textarea>
        </div>
        <div class="anketa_form_line parent">
            <div class="anketa_form_h"><div class="anketa_form_h_cell">Ссылка на файл политики конфиденциальности</div></div>
            <textarea name="private_policy" class="journal_form_textarea admin_form_txt_middle" maxlength="255"><?php if (!empty($private_policy)) { echo $private_policy; }?></textarea>
        </div>
        <div class="anketa_form_line parent">
            <div class="anketa_form_h"><div class="anketa_form_h_cell">Политика обработки персональных данных</div></div>
            <textarea name="personal_data_text" class="journal_form_textarea admin_form_txt_middle" maxlength="255"><?php if (!empty($personal_data_text)) { echo $personal_data_text; }?></textarea>
        </div>
        <div class="anketa_form_line parent">
            <div class="anketa_form_h"><div class="anketa_form_h_cell">Ссылка на файл политики обработки персональных данных</div></div>
            <textarea name="personal_data" class="journal_form_textarea admin_form_txt_middle" maxlength="255"><?php if (!empty($personal_data)) { echo $personal_data; }?></textarea>
        </div>
        <div class="anketa_form_line parent">
            <div class="anketa_form_h"><div class="anketa_form_h_cell">Ссылка на файл договора оферты</div></div>
            <textarea name="offer_data" class="journal_form_textarea admin_form_txt_middle" maxlength="255"><?php if (!empty($offer_data)) { echo $offer_data; }?></textarea>
        </div>

        <div class="anketa_form_line parent">
            <div class="anketa_form_h"><div class="anketa_form_h_cell">Copyright</div></div>
            <textarea name="rights" class="journal_form_textarea admin_form_txt_middle" maxlength="255"><?php if (!empty($rights)) { echo $rights; }?></textarea>
        </div>
        <div class="anketa_form_line parent">
            <div class="anketa_form_h"><div class="anketa_form_h_cell">Copyright (краткое)</div></div>
            <textarea name="footer" class="journal_form_textarea admin_form_txt_middle" maxlength="255"><?php if (!empty($footer)) { echo $footer; }?></textarea>
        </div>

        <div class="anketa_form_line parent">
            <div class="anketa_form_h"><div class="anketa_form_h_cell">Соц. сети</div></div>
        </div>
        <div class="anketa_form_line parent">
            <div class="anketa_form_h"><div class="anketa_form_h_cell"><i class="fab fa-facebook-f" aria-hidden="true"></i></div></div>
            <input type="text" class="anketa_form_in anketa_form_in_long" name="soc_facebook" value="<?php if (!empty($soc_facebook)) { echo $soc_facebook; }?>" maxlength="255"/>
        </div>
        <div class="anketa_form_line parent">
            <div class="anketa_form_h"><div class="anketa_form_h_cell"><i class="fab fa-twitter" aria-hidden="true"></i></div></div>
            <input type="text" class="anketa_form_in anketa_form_in_long" name="soc_twitter" value="<?php if (!empty($soc_twitter)) { echo $soc_twitter; }?>" maxlength="255"/>
        </div>
        <div class="anketa_form_line parent">
            <div class="anketa_form_h"><div class="anketa_form_h_cell"><i class="fab fa-pinterest" aria-hidden="true"></i></div></div>
            <input type="text" class="anketa_form_in anketa_form_in_long" name="soc_pinterest" value="<?php if (!empty($soc_pinterest)) { echo $soc_pinterest; }?>" maxlength="255"/>
        </div>
        <div class="anketa_form_line parent">
            <div class="anketa_form_h"><div class="anketa_form_h_cell"><i class="fab fa-google-plus-g" aria-hidden="true"></i></div></div>
            <input type="text" class="anketa_form_in anketa_form_in_long" name="soc_google" value="<?php if (!empty($soc_google_p)) { echo $soc_google_p; }?>" maxlength="255"/>
        </div>
        <div class="anketa_form_line parent">
            <div class="anketa_form_h"><div class="anketa_form_h_cell"><i class="fab fa-tumblr" aria-hidden="true"></i></div></div>
            <input type="text" class="anketa_form_in anketa_form_in_long" name="soc_tumblr" value="<?php if (!empty($soc_tumblr)) { echo $soc_tumblr; }?>" maxlength="255"/>
        </div>
        <div class="anketa_form_line parent">
            <div class="anketa_form_h"><div class="anketa_form_h_cell"><i class="fab fa-instagram" aria-hidden="true"></i></div></div>
            <input type="text" class="anketa_form_in anketa_form_in_long" name="soc_instagram" value="<?php if (!empty($soc_instagram)) { echo $soc_instagram; }?>" maxlength="255"/>
        </div>
        <div class="anketa_form_line parent">
            <div class="anketa_form_h"><div class="anketa_form_h_cell"><i class="fab fa-odnoklassniki" aria-hidden="true"></i></div></div>
            <input type="text" class="anketa_form_in anketa_form_in_long" name="soc_ok" value="<?php if (!empty($soc_ok)) { echo $soc_ok; }?>" maxlength="255"/>
        </div>
        <div class="anketa_form_line parent">
            <div class="anketa_form_h"><div class="anketa_form_h_cell"><i class="fab fa-vk" aria-hidden="true"></i></div></div>
            <input type="text" class="anketa_form_in anketa_form_in_long" name="soc_vk" value="<?php if (!empty($soc_vk)) { echo $soc_vk; }?>" maxlength="255"/>
        </div>
        <div class="anketa_form_line parent">
            <div class="anketa_form_h"><div class="anketa_form_h_cell"><i class="fab fa-youtube" aria-hidden="true"></i></div></div>
            <input type="text" class="anketa_form_in anketa_form_in_long" name="soc_youtube" value="<?php if (!empty($soc_youtube)) { echo $soc_youtube; }?>" maxlength="255"/>
        </div>
    </div>
</form>