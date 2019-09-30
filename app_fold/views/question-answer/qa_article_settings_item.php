<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="anketa_form_line parent">
    <div class="anketa_form_h"><div class="anketa_form_h_cell">Раздел:</div></div>
    <div class="anketa_form_one_wrap anketa_form_three_wrap">
        <?php $disabled = (empty($sections)) ? 'disabled' : ''; ?>
        <select name="s_section" class="anketa_form_select" <?php echo $disabled; ?>>
            <?php if(!empty($sections)):
                $selected_section = ''; ?>
                <?php foreach($sections as $section): ?>
                    <option value="<?php echo $section['id']; ?>" <?php if(!empty($qa_article['section_id']) and $section['id'] == $qa_article['section_id']): ?>selected<?php endif; ?>><?php echo $section['name']; ?></option>
                    <?php if((empty($qa_article['section_id']) and empty($selected_section)) or $section['id'] == $qa_article['section_id']):
                        $selected_section = $section['id'];
                    endif; ?>
                <?php endforeach;
                unset($section); ?>
            <?php else: ?>
                <option>Добавьте раздел</option>
            <?php endif; ?>
        </select>
    </div>
</div>
<?php if(!empty($subsections) and !empty($sections)): ?>
    <?php foreach($sections as $section):
        $style = ($section['id'] == $selected_section or $section['id'] == $qa_article['section_id']) ? 'style="display:block;"' : ''; ?>
        <div class="anketa_form_line parent subsections" id="subsection-<?php echo $section['id']; ?>" <?php echo $style; ?>>
            <div class="anketa_form_h"><div class="anketa_form_h_cell">Подраздел:</div></div>
            <div class="anketa_form_one_wrap anketa_form_three_wrap">
                <select name="s_subsection[<?php echo $section['id']; ?>]" class="anketa_form_select">
                    <option value="">Выберите подраздел</option>
                    <?php if(!empty($subsections[$section['id']])):
                        foreach($subsections[$section['id']] as $subsection): ?>
                            <option value="<?php echo $subsection['id']; ?>" <?php if(!empty($qa_article['subsection_id']) and $subsection['id'] == $qa_article['subsection_id']): ?>selected<?php endif; ?>><?php echo $subsection['name']; ?></option>
                        <?php endforeach;
                        unset($subsection);
                    endif;?>
                </select>
            </div>
        </div>
    <?php endforeach;
    unset($sections);
endif; ?>
<div class="anketa_form_line parent">
    <div class="anketa_form_h"><div class="anketa_form_h_cell">Граппа пользователей:</div></div>
    <div class="anketa_form_one_wrap anketa_form_three_wrap">
        <?php if(!empty($users_group)): ?>
            <?php foreach($users_group as $ug): ?>
                <div class="tren_form_block_check_wrap">
                    <input type="checkbox" name="cb_users_group[<?php echo $ug['id'];?>]" class="tren_form_block_check" value="<?php echo $ug['id'];?>" id="ug_check<?php echo $ug['id'];?>"
                        <?php if(!empty($qa_article['users_group']) and in_array($ug['id'], $qa_article['users_group'])):?>checked="checked"<?php endif;?>>
                    <label for="ug_check<?php echo $ug['id'];?>"><?php echo $ug['name'];?></label>
                </div>
            <?php endforeach;
            unset($ug);?>
        <?php endif; ?>
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
            plugins: "image imagetools autoresize link paste lists charmap",
            toolbar: "undo redo | bold italic underline | fontsizeselect forecolor | alignleft aligncenter alignright alignjustify | numlist bullist indent outdent | charmap | image link",
            fontsize_formats: '8px 9px 10px 11px 12px 14px 16px 18px 24px 36px 48px',
            max_chars_indicator: "pageLength",
            relative_urls : false,
            paste_auto_cleanup_on_paste: true
        });
    </script>
</div>