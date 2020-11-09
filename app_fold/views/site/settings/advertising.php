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
            <div class="anketa_form_h"><div class="anketa_form_h_cell">Кто видит рекламу:</div></div>
            <div class="anketa_form_one_wrap anketa_form_three_wrap">
                <select name="s_advertising_display" class="anketa_form_select">
                    <option value="0" <?php if(!empty($advertising_display) and $advertising_display == 0):?>selected="selected"<?php endif;?>>Никто</option>
                    <option value="1" <?php if(!empty($advertising_display) and $advertising_display == 1):?>selected="selected"<?php endif;?>>Все</option>
                    <option value="2" <?php if(!empty($advertising_display) and $advertising_display == 2):?>selected="selected"<?php endif;?>>Администраторы</option>
                </select>
            </div>
        </div>
        <div class="anketa_form_line parent">
            <div class="anketa_form_h">
                <div class="anketa_form_h_cell">Мобильная:</div>
                <div class="anketa_form_info_cont soc_block_check_wrap" style="float: none;">
                    <input type="checkbox" name="cb_hide_mobile" id="cb-hide-mobile" class="tren_form_block_check"
                           <?php if(!empty($advertising_mobile_hide) and $advertising_mobile_hide == 1): ?>checked="checked"<?php endif;?>>
                    <label for="cb-hide-mobile">Отключить</label>
                </div>
            </div>
            <textarea name="ta_advertising_mobile" class="journal_form_textarea admin_form_txt_middle"><?php if (!empty($advertising_mobile)) { echo $advertising_mobile; }?></textarea>
        </div>
        <div class="anketa_form_line parent">
            <div class="anketa_form_h">
                <div class="anketa_form_h_cell">Вертикальная:</div>
                <div class="anketa_form_info_cont soc_block_check_wrap" style="float: none;">
                    <input type="checkbox" name="cb_hide_vertical" id="cb-hide-vertical" class="tren_form_block_check"
                           <?php if(!empty($advertising_vertical_hide) and $advertising_vertical_hide == 1): ?>checked="checked"<?php endif;?>>
                    <label for="cb-hide-vertical">Отключить</label>
                </div>
            </div>
            <textarea name="ta_advertising_vertical" class="journal_form_textarea admin_form_txt_middle"><?php if (!empty($advertising_vertical)) { echo $advertising_vertical; }?></textarea>
        </div>
        <div class="anketa_form_line parent">
            <div class="anketa_form_h">
                <div class="anketa_form_h_cell">Вертикальная (мобильная):</div>
                <div class="anketa_form_info_cont soc_block_check_wrap" style="float: none;">
                    <input type="checkbox" name="cb_hide_vertical_mobile" id="cb-hide-vertical-mobile" class="tren_form_block_check"
                           <?php if(!empty($advertising_vertical_mobile_hide) and $advertising_vertical_mobile_hide == 1): ?>checked="checked"<?php endif;?>>
                    <label for="cb-hide-vertical-mobile">Отключить</label>
                </div>
            </div>
            <textarea name="ta_advertising_vertical_mobile" class="journal_form_textarea admin_form_txt_middle"><?php if (!empty($advertising_vertical_mobile)) { echo $advertising_vertical_mobile; }?></textarea>
        </div>
        <div class="anketa_form_line parent">
            <div class="anketa_form_h">
                <div class="anketa_form_h_cell">Горизонтальная:</div>
                <div class="anketa_form_info_cont soc_block_check_wrap" style="float: none;">
                    <input type="checkbox" name="cb_hide_horizontal" id="cb-hide-horizontal" class="tren_form_block_check"
                           <?php if(!empty($advertising_horizontal_hide) and $advertising_horizontal_hide == 1): ?>checked="checked"<?php endif;?>>
                    <label for="cb-hide-horizontal">Отключить</label>
                </div>
            </div>
            <textarea name="ta_advertising_horizontal" class="journal_form_textarea admin_form_txt_middle"><?php if (!empty($advertising_horizontal)) { echo $advertising_horizontal; }?></textarea>
        </div>
        <div class="anketa_form_line parent">
            <div class="anketa_form_h">
                <div class="anketa_form_h_cell">Горизонтальная (мобильная):</div>
                <div class="anketa_form_info_cont soc_block_check_wrap" style="float: none;">
                    <input type="checkbox" name="cb_hide_horizontal_mobile" id="cb-hide-horizontal-mobile" class="tren_form_block_check"
                           <?php if(!empty($advertising_horizontal_mobile_hide) and $advertising_horizontal_mobile_hide == 1): ?>checked="checked"<?php endif;?>>
                    <label for="cb-hide-horizontal-mobile">Отключить</label>
                </div>
            </div>
            <textarea name="ta_advertising_horizontal_mobile" class="journal_form_textarea admin_form_txt_middle"><?php if (!empty($advertising_horizontal_mobile)) { echo $advertising_horizontal_mobile; }?></textarea>
        </div>
        <div class="anketa_form_line parent">
            <div class="anketa_form_h">
                <div class="anketa_form_h_cell">Перед тренировкой:</div>
                <div class="anketa_form_info_cont soc_block_check_wrap" style="float: none;">
                    <input type="checkbox" name="cb_hide_before_workout" id="cb-hide-before-workout" class="tren_form_block_check"
                           <?php if(!empty($advertising_before_workout_hide) and $advertising_before_workout_hide == 1): ?>checked="checked"<?php endif;?>>
                    <label for="cb-hide-before-workout">Отключить</label>
                </div>
            </div>
            <textarea name="ta_advertising_before_workout" class="journal_form_textarea admin_form_txt_middle"><?php if (!empty($advertising_before_workout)) { echo $advertising_before_workout; }?></textarea>
        </div>
        <div class="practice_block_h">Всплывающий блок "Премиум аккаунт"</div>
        <div class="tren_form_block_check_wrap">
            <input type="checkbox" name="cb_premium_display_hide" <?php if(empty($advertising_premium_display) or $advertising_premium_display == 0): ?>checked="checked"<?php endif;?> class="tren_form_block_check" id="tren_form_block_check1bg">
            <label for="tren_form_block_check1bg">Отключить кнопку "Примиум аккаунт"</label>
        </div>
        <div class="anketa_form_line parent">
            <div class="anketa_form_h"><div class="anketa_form_h_cell">Текст блока:</div></div>
            <div class="anketa_form_line parent">
                <div class="journal_form_textarea_wrap journal_form_textarea_small">
                    <textarea name="ta_advertising_popup" maxlength="15000" class="journal_form_textarea formatted_textarea"><?php if (!empty($advertising_popup)) { echo $advertising_popup; }?></textarea>

                    <script>
                        tinymce.init({
                            selector: "textarea.formatted_textarea",
                            menubar: false,
                            statusbar: false,
                            theme: 'silver',
                            language_url : '/js/tinymce/langs/ru.js',
                            plugins: "image imagetools autoresize lists link paste",
                            toolbar: "undo redo | bold italic underline | fontsizeselect forecolor | alignleft aligncenter alignright alignjustify | numlist bullist indent outdent | link",
                            fontsize_formats: '8px 9px 10px 11px 12px 14px 16px 18px 24px 36px 48px',
                            max_chars_indicator: "pageLength",
                            relative_urls : false,
                            paste_auto_cleanup_on_paste: true,
                            force_br_newlines : true,
                            force_p_newlines : false,
                            forced_root_block : 'div',
                            invalid_elements : 'br',
                            fix_list_elements : true,
                            contextmenu_never_use_native: true,
                            contextmenu: "copy cut paste"
                        });
                    </script>
                </div>
            </div>
        </div>
        <div class="anketa_form_line parent">
            <div class="anketa_form_h"><div class="anketa_form_h_cell">Стоимость, руб/мес:</div></div>
            <input type="text" name="i_premium_month" class="admin_form_txt kurs_form_txt_short" placeholder='Стоимость месяца "Без рекламы"' value="<?php if (!empty($advertising_month_price)) { echo $advertising_month_price; }?>">
        </div>
    </div>
</form>
