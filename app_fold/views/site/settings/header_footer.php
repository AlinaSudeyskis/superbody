<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="anketa_block_item">
    <div class="anketa_block_item_h"></div>
    <div class="anketa_block_item_cont">
        <form action="" method="post" class="anketa_form site_info" enctype="multipart/form-data">
            <div class="anketa_form_line parent">
                <div class="anketa_form_h"><div class="anketa_form_h_cell">Файл баннера:</div></div>
                <div class="anketa_form_info_cont">
                    <div style="width: 330px;">
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
                </div>
            </div>
            <?php if (!empty($logotype)) : ?>
                <div class="anketa_form_line parent">
                    <div class="anketa_form_h"><div class="anketa_form_h_cell"></div></div>
                    <div class="anketa_form_info_cont logotype"><img src="<?php echo $logotype;?>" alt=""></div>
                </div>
            <?php endif;?>
            <div class="anketa_form_line parent">
                <div class="anketa_form_h"><div class="anketa_form_h_cell">Пользовательское соглашение</div></div>
                <input type="text" class="anketa_form_in anketa_form_in_long" name="agreement" value="<?php if (!empty($agreement)) { echo $agreement; }?>" maxlength="255"/>
            </div>
            <div class="anketa_form_line parent">
                <div class="anketa_form_h"><div class="anketa_form_h_cell">Политика конфиденциальности</div></div>
                <input type="text" class="anketa_form_in anketa_form_in_long" name="private_policy" value="<?php if (!empty($private_policy)) { echo $private_policy; }?>" maxlength="255"/>
            </div>
            <div class="anketa_form_line parent">
                <div class="anketa_form_h"><div class="anketa_form_h_cell">Политика обработки персональных данных</div></div>
                <input type="text" class="anketa_form_in anketa_form_in_long" name="personal_data" value="<?php if (!empty($personal_data)) { echo $personal_data; }?>" maxlength="255"/>
            </div>

            <div class="anketa_form_line parent">
                <div class="anketa_form_h"><div class="anketa_form_h_cell">Copyright</div></div>
                <input type="text" class="anketa_form_in anketa_form_in_long" name="rights" value="<?php if (!empty($rights)) { echo $rights; }?>" maxlength="255"/>
            </div>
            <div class="anketa_form_line parent">
                <div class="anketa_form_h"><div class="anketa_form_h_cell">Copyright (краткое)</div></div>
                <input type="text" class="anketa_form_in anketa_form_in_long" name="footer" value="<?php if (!empty($footer)) { echo $footer; }?>" maxlength="255"/>
            </div>

            <div class="anketa_form_line parent">
                <div class="anketa_form_h"><div class="anketa_form_h_cell"><i class="fa fa-facebook" aria-hidden="true"></i></div></div>
                <input type="text" class="anketa_form_in anketa_form_in_long" name="soc_facebook" value="<?php if (!empty($soc_facebook)) { echo $soc_facebook; }?>" maxlength="255"/>
            </div>
            <div class="anketa_form_line parent">
                <div class="anketa_form_h"><div class="anketa_form_h_cell"><i class="fa fa-twitter" aria-hidden="true"></i></div></div>
                <input type="text" class="anketa_form_in anketa_form_in_long" name="soc_twitter" value="<?php if (!empty($soc_twitter)) { echo $soc_twitter; }?>" maxlength="255"/>
            </div>
            <div class="anketa_form_line parent">
                <div class="anketa_form_h"><div class="anketa_form_h_cell"><i class="fa fa-pinterest" aria-hidden="true"></i></div></div>
                <input type="text" class="anketa_form_in anketa_form_in_long" name="soc_pinterest" value="<?php if (!empty($soc_pinterest)) { echo $soc_pinterest; }?>" maxlength="255"/>
            </div>
            <div class="anketa_form_line parent">
                <div class="anketa_form_h"><div class="anketa_form_h_cell"><i class="fa fa-google-plus" aria-hidden="true"></i></div></div>
                <input type="text" class="anketa_form_in anketa_form_in_long" name="soc_google" value="<?php if (!empty($soc_google_p)) { echo $soc_google_p; }?>" maxlength="255"/>
            </div>
            <div class="anketa_form_line parent">
                <div class="anketa_form_h"><div class="anketa_form_h_cell"><i class="fa fa-tumblr" aria-hidden="true"></i></div></div>
                <input type="text" class="anketa_form_in anketa_form_in_long" name="soc_tumblr" value="<?php if (!empty($soc_tumblr)) { echo $soc_tumblr; }?>" maxlength="255"/>
            </div>
            <div class="anketa_form_line parent">
                <div class="anketa_form_h"><div class="anketa_form_h_cell"><i class="fa fa-instagram" aria-hidden="true"></i></div></div>
                <input type="text" class="anketa_form_in anketa_form_in_long" name="soc_instagram" value="<?php if (!empty($soc_instagram)) { echo $soc_instagram; }?>" maxlength="255"/>
            </div>
            <div class="anketa_form_line parent">
                <div class="anketa_form_h"><div class="anketa_form_h_cell"><i class="fa fa-odnoklassniki" aria-hidden="true"></i></div></div>
                <input type="text" class="anketa_form_in anketa_form_in_long" name="soc_ok" value="<?php if (!empty($soc_ok)) { echo $soc_ok; }?>" maxlength="255"/>
            </div>
            <div class="anketa_form_line parent">
                <div class="anketa_form_h"><div class="anketa_form_h_cell"><i class="fa fa-vk" aria-hidden="true"></i></div></div>
                <input type="text" class="anketa_form_in anketa_form_in_long" name="soc_vk" value="<?php if (!empty($soc_vk)) { echo $soc_vk; }?>" maxlength="255"/>
            </div>
            <div class="anketa_form_line parent">
                <div class="anketa_form_h"><div class="anketa_form_h_cell"><i class="fa fa-youtube-play" aria-hidden="true"></i></div></div>
                <input type="text" class="anketa_form_in anketa_form_in_long" name="soc_youtube" value="<?php if (!empty($soc_youtube)) { echo $soc_youtube; }?>" maxlength="255"/>
            </div>

            <div class="anketa_form_buts_wrap parent">
                <input type="submit" name="bt_save_header" value="Сохранить" class="admin_form_submit">
            </div>
        </form>
    </div>
</div>