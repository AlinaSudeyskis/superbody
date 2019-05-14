<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="anketa_form_line parent">
    <div class="anketa_form_h"><div class="anketa_form_h_cell">Раздел:</div></div>
    <div class="anketa_form_one_wrap anketa_form_three_wrap">
        <?php $disabled = (empty($sections)) ? 'disabled' : ''; ?>
        <select name="s_section" class="anketa_form_select" <?php echo $disabled; ?>>
            <?php if(!empty($sections)): ?>
                <?php foreach($sections as $section): ?>
                    <option value="<?php echo $section['id']; ?>" <?php if(!empty($qa_article['section_id']) and $section['id'] == $qa_article['section_id']): ?>selected<?php endif; ?>><?php echo $section['name']; ?></option>
                <?php endforeach;
                unset($section); ?>
            <?php else: ?>
                <option>Добавьте раздел</option>
            <?php endif; ?>
        </select>
    </div>
</div>
<?php if(!empty($subsections)):
    $selected_section = array_shift($sections);?>
    <?php foreach($subsections as $section_id => $sections):
        $style = ($section_id == $selected_section['id']) ? 'style="display:block;"' : ''; ?>
        <div class="anketa_form_line parent subsections" id="subsection-<?php echo $section_id; ?>" <?php echo $style; ?>>
            <div class="anketa_form_h"><div class="anketa_form_h_cell">Подраздел:</div></div>
            <div class="anketa_form_one_wrap anketa_form_three_wrap">
                <select name="s_subsection[<?php echo $section_id; ?>]" class="anketa_form_select">
                    <option value="">Выберите подраздел</option>
                    <?php foreach($sections as $subsection): ?>
                        <option value="<?php echo $subsection['id']; ?>" <?php if(!empty($qa_article['subsection_id']) and $subsection['id'] == $qa_article['subsection_id']): ?>selected<?php endif; ?>><?php echo $subsection['name']; ?></option>
                    <?php endforeach;
                    unset($subsection); ?>
                </select>
            </div>
        </div>
    <?php endforeach;
    unset($sections);
    unset($section_id);
endif; ?>
<div class="anketa_form_line parent">
    <div class="anketa_form_h"><div class="anketa_form_h_cell">Граппа пользователей:</div></div>
    <div class="anketa_form_one_wrap anketa_form_three_wrap">
        <select name="s_user_group" class="anketa_form_select">
            <option value="general" <?php if(!empty($qa_article['user_group']) and $qa_article['user_group'] == 'general'): ?>selected<?php endif; ?>>Для всех</option>
            <option value="user" <?php if(!empty($qa_article['user_group']) and $qa_article['user_group'] == 'user'): ?>selected<?php endif; ?>>Авторизованные пользователи</option>
            <option value="couch" <?php if(!empty($qa_article['user_group']) and $qa_article['user_group'] == 'couch'): ?>selected<?php endif; ?>>Тренеры</option>
            <option value="admin" <?php if(!empty($qa_article['user_group']) and $qa_article['user_group'] == 'admin'): ?>selected<?php endif; ?>>Администраторы</option>
        </select>
    </div>
</div>
<div class="anketa_form_line parent">
    <div class="anketa_form_h"><div class="anketa_form_h_cell">Заголовок:</div></div>
    <input type="text" class="anketa_form_in anketa_form_in_long" name="qa_name" value="<?php if(!empty($qa_article['name'])): echo $qa_article['name']; endif;?>" maxlength="255"/>
</div>
<div class="anketa_form_line parent">
    <div class="anketa_form_h"><div class="anketa_form_h_cell">Текст:</div></div>
</div>
<div class="anketa_form_line parent">
    <textarea name="qa_article_text" class="journal_form_textarea formatted_textarea"><?php if(!empty($qa_article['text'])): echo $qa_article['text']; endif;?></textarea>
    <script>
        tinymce.init({
            selector: "textarea.formatted_textarea",
            images_upload_url: '/upload_qa_images',
            images_upload_base_path: '/qa_images',
            images_upload_credentials: true,
            menubar: false,
            statusbar: false,
            theme: 'silver',
            language_url : '/js/tinymce/langs/ru.js',
            plugins: "image imagetools autoresize",
            toolbar: "undo redo | bold italic | forecolor | alignleft aligncenter alignright alignjustify | image",
            max_chars_indicator: "pageLength",
            relative_urls : false
        });
    </script>
</div>