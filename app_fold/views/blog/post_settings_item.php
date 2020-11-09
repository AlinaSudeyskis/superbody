<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php if(!empty($blog_categories)):?>
    <div class="parent kurs_cur_wrap">
        <div class="kurs_block_h">Категория:</div>
        <select name="s_post_category" class="journal_form_select">
            <option value="">Выберите категорию</option>
            <?php foreach($blog_categories as $blog_category): ?>
                <option value="<?php echo $blog_category['id']; ?>" <?php if(!empty($post['category_id']) and $blog_category['id'] == $post['category_id']): ?>selected="selected"<?php endif;?>><?php echo $blog_category['name']; ?></option>
            <?php endforeach;
            unset($blog_category); ?>
        </select>
    </div>
<?php endif; ?>

<div class="parent kurs_cur_wrap">
    <div class="kurs_block_h">Тип постера:</div>
    <select name="s_blog_poster_type" class="journal_form_select">
        <option value="">Выберите тип постера</option>
        <option value="vimeo" <?php if (!empty($post['poster_type']) and $post['poster_type'] == 'vimeo') { echo 'selected="selected"'; } ?>>Vimeo видео-превью</option>
        <option value="youtube" <?php if (!empty($post['poster_type']) and $post['poster_type'] == 'youtube') { echo 'selected="selected"'; } ?>>YouTube видео-превью</option>
        <option value="image" <?php if (!empty($post['poster_type']) and $post['poster_type'] == 'image') { echo 'selected="selected"'; } ?>>Изображение</option>
    </select>
</div>
<div class="parent kurs_cur_wrap" id="blog-poster-video-url" <?php if(empty($post['poster_type']) or $post['poster_type'] == 'image'):?>style="display: none;"<?php endif; ?>>
    <div class="kurs_block_h">URL:</div>
    <input type="text" name="remote_url" class="admin_form_txt admin_form_txt_short" placeholder="Полная URL ссылка на видео" value="<?php if (!empty($post['poster'])) { echo $post['poster']; }?>" />
</div>
<div class="parent kurs_cur_wrap down_line" id="blog-poster-image" <?php if(empty($post['poster_type']) or $post['poster_type'] != 'image'):?>style="display: none;"<?php endif; ?>>
    <div class="kurs_block_h">Изображение (640x360):</div>
    <div class="video_down_line parent">
        <div class="video_down_line_but_wrap">
            <label for="blog_poster_file" class="video_down_line_but">
                <input type="file" name="poster_file" class="admin_form_videofile" id="blog_poster_file" accept="image/jpeg,image/png"/>
                <input type="hidden" value="" name="poster_path" id="poster_path"/>
                <span>Выберите файл</span>
            </label>
        </div>
        <div class="video_down_line_name">Файл не выбран</div>
        <div class="progressbar_wrap">
            <progress class="progressbar" id="poster_progressbar" value="0" max="100"></progress>
        </div>
    </div>
</div>
<?php if(!empty($post['poster_type']) and $post['poster_type'] == 'image' and !empty($post['poster'])): ?>
    <div class="parent kurs_cur_wrap">
        <img src="<?php echo $post['poster'];?>" alt="">
    </div>
<?php elseif(!empty($post['poster_type']) and $post['poster_type'] != 'image' and !empty($post['poster'])): ?>
    <?php if($post['poster_type'] == 'vimeo'): ?>
        <div class="parent kurs_cur_wrap">
            <div class="kurs_block_h">Видео с Vimeo.com:</div>
        </div>
        <div class="admin_form_file_line">
            <?php $remote_url =$post['poster'];
            $key = 0;
            include('./app_fold/views/video/player/vimeo_player_item.php');?>
        </div>
    <?php elseif($post['poster_type'] == 'youtube') : ?>
        <div class="parent kurs_cur_wrap">
            <div class="kurs_block_h">Видео с YouTube.com:</div>
        </div>
        <div class="admin_form_file_line">
            <?php $remote_url = $post['poster'];
            $key = 0;
            include('./app_fold/views/video/player/youtube_player_item.php');?>
        </div>
    <?php endif;?>
<?php endif; ?>

<div class="parent kurs_cur_wrap">
    <div class="kurs_block_h"></div>
</div>
<div class="parent kurs_cur_wrap">
    <div class="kurs_block_h">Заголовок:</div>
    <input type="text" name="post_title" value="<?php if(!empty($post['title'])): echo $post['title']; endif;?>" class="admin_form_txt admin_form_txt_middle" maxlength="100" required="required" />
</div>
<div class="parent kurs_cur_wrap">
    <div class="kurs_block_h">Краткое описание:</div>
    <input type="text" name="post_short_desc" value="<?php if(!empty($post['short_desc'])): echo $post['short_desc']; endif;?>" class="admin_form_txt admin_form_txt_middle" maxlength="255" required="required" />
</div>
<div class="parent kurs_cur_wrap">
    <div class="kurs_block_h">Ключевые слова:</div>
    <input type="text" name="post_keywords" value="<?php if(!empty($post['keywords'])): echo $post['keywords']; endif;?>" class="admin_form_txt admin_form_txt_middle" maxlength="255" required="required" />
</div>
<div class="parent kurs_cur_wrap">
    <div class="kurs_block_h"></div>
</div>
<div class="parent kurs_cur_wrap">
    <div class="kurs_block_h">Тип видео:</div>
    <select name="s_blog_video_type" class="journal_form_select">
        <option value="">Выберите тип видео</option>
        <option value="vimeo" <?php if (!empty($post['video_type']) and $post['video_type'] == 'vimeo') { echo 'selected="selected"'; } ?>>Vimeo</option>
        <option value="youtube" <?php if (!empty($post['video_type']) and $post['video_type'] == 'youtube') { echo 'selected="selected"'; } ?>>YouTube</option>
    </select>
</div>
<div class="parent kurs_cur_wrap">
    <div class="kurs_block_h">Видео URL:</div>
    <input type="text" name="video_remote_url" class="admin_form_txt admin_form_txt_short" placeholder="Полная URL ссылка на видео" value="<?php if (!empty($post['video'])) { echo $post['video']; }?>" />
</div>
<?php if(!empty($post['video']) and $post['video_type'] == 'vimeo'): ?>
    <div class="parent kurs_cur_wrap">
        <div class="kurs_block_h">Видео с Vimeo.com:</div>
    </div>
<div class="admin_form_file_line">
    <?php $remote_url = $post['video'];
    $key = 0;
    include('./app_fold/views/video/player/vimeo_player_item.php');?>
</div>
<?php elseif(!empty($post['video']) and $post['video_type'] == 'youtube') : ?>
    <div class="parent kurs_cur_wrap">
        <div class="kurs_block_h">Видео с YouTube.com:</div>
    </div>
<div class="admin_form_file_line">
    <?php $remote_url = $post['video'];
    $key = 0;
    include('./app_fold/views/video/player/youtube_player_item.php');?>
</div>
<?php endif;?>
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
        fix_list_elements : true,
        contextmenu_never_use_native: true,
        contextmenu: "copy cut paste"
    });
</script>
<div class="add_tov_in_total">
    <div class="add_tov_in pc_course">
        <div class="practice_block_h">Прикрепленные курсы:</div>
        <input type="text" name="tren" class="admin_form_txt admin_form_txt_short" placeholder="Введите наименование или ID курса" />
        <div class="add_tov_list"></div>
    </div>
    <div class="add_tov_val">
        <?php if (!empty($post['attached_courses'])) :
            foreach($post['attached_courses'] as $key => $course): ?>
                <div id="<?php echo $course['id']; ?>tov" class="add_tov_val_item parent">
                    <a href="/course/<?php echo $course['id']; ?>" class="add_tov_val_cont parent">
                        <span class="add_tov_val_h"><?php echo $course['name']; ?></span>
                        <div class="del_tov"></div>
                    </a>
                </div>
            <?php endforeach;
            unset($course);
        endif;?>
    </div>
</div>