<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<script>
    tinymce.init({
        selector: "textarea.formatted_textarea",
        height: 300,
        menubar:false,
        theme: "modern",
        language_url : '/js/tinymce/langs/ru.js',
        plugins: "textcolor colorpicker bbcode",
        toolbar: "undo redo | bold italic | forecolor"
    });
</script>
<form action="" method="post">
    <div class="admin_form_buts_wrap_container">
        <div class="admin_form_buts_wrap parent">
            <input type="submit" name="bt_save_about" value="Сохранить" class="video_admin_form_send">
        </div>
    </div>
    <div class="video_admin_form site_info">
        <div class="anketa_form_line parent">
            <div class="anketa_form_h"><div class="anketa_form_h_cell">О нашем проекте</div></div>
        </div>
        <div class="anketa_form_line parent">
            <div class="journal_form_textarea_wrap journal_form_textarea_small">
                <textarea name="about_us" maxlength="5000" class="journal_form_textarea formatted_textarea"><?php if (!empty($about)) { echo $about; }?></textarea>
            </div>
        </div>
    </div>
</form>