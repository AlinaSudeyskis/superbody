<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="parent kurs_cur_wrap">
    <div class="kurs_block_h">Заголовок:</div>
    <input type="text" name="post_title" value="<?php if(!empty($post['title'])): echo $post['title']; endif;?>" class="admin_form_txt admin_form_txt_middle" maxlength="100" />
</div>
<div class="parent kurs_cur_wrap">
    <div class="kurs_block_h">Краткое описание:</div>
    <input type="text" name="post_short_desc" value="<?php if(!empty($post['short_desc'])): echo $post['short_desc']; endif;?>" class="admin_form_txt admin_form_txt_middle" maxlength="255" />
</div>
<div class="parent kurs_cur_wrap">
    <div class="kurs_block_h">Ключевые слова:</div>
    <input type="text" name="post_keywords" value="<?php if(!empty($post['keywords'])): echo $post['keywords']; endif;?>" class="admin_form_txt admin_form_txt_middle" maxlength="255" />
</div>
<div class="parent kurs_cur_wrap">
    <div class="kurs_block_h">Полный текст:</div>
</div>
<div class="journal_form_textarea_wrap journal_form_textarea_small">
    <textarea name="post_text" class="full_photo_comm_in ta_dark formatted_textarea" maxlength="1000000" style="height: 250px;"><?php if(!empty($post['text'])): echo $post['text']; endif;?></textarea>
</div>
<script>
    tinymce.init({
        selector: "textarea.formatted_textarea",
        images_upload_url: '/upload_post_images',
        images_upload_base_path: '/post_images',
        images_upload_credentials: true,
        menubar: false,
        statusbar: false,
        theme: 'silver',
        language_url : '/js/tinymce/langs/ru.js',
        plugins: "image imagetools autoresize link paste lists charmap",
        toolbar: "undo redo | bold italic underline | fontsizeselect forecolor | alignleft aligncenter alignright alignjustify | numlist bullist indent outdent | charmap | image link",
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