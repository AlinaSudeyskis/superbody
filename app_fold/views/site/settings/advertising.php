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
        <div class="anketa_form_line parent">
            <div class="anketa_form_h"><div class="anketa_form_h_cell">Всплывающий блок</div></div>
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
                            plugins: "image imagetools autoresize link paste",
                            toolbar: "undo redo | bold italic underline | fontsizeselect forecolor | alignleft aligncenter alignright alignjustify | link",
                            fontsize_formats: '8px 9px 10px 11px 12px 14px 16px 18px 24px 36px 48px',
                            max_chars_indicator: "pageLength",
                            relative_urls : false,
                            paste_auto_cleanup_on_paste: true,
                            force_br_newlines : true,
                            force_p_newlines : false,
                            forced_root_block : 'div',
                            invalid_elements : 'br',
                            fix_list_elements : true
                        });
                    </script>
                </div>
            </div>
        </div>
        <div class="anketa_form_line parent">
            <div class="anketa_form_h"><div class="anketa_form_h_cell">Стоимость, руб.:</div></div>
            <input type="text" name="i_premium_month" class="admin_form_txt kurs_form_txt_short" placeholder='Стоимость месяца "Без рекламы"' value="<?php if (!empty($advertising_month_price)) { echo $advertising_month_price; }?>">
        </div>
    </div>
</form>
