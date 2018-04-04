<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<script>
    tinymce.init({
        selector: "textarea.formatted_textarea",
        menubar:false,
        theme: "modern",
        language_url : '/js/tinymce/langs/ru.js',
        plugins: "textcolor colorpicker bbcode",
        toolbar: "undo redo | bold italic | forecolor",
        min_height : 200
    });
</script>
<div class="anketa_form_line parent">
    <div class="anketa_form_h"><div class="anketa_form_h_cell">Специализация</div></div>
    <input type="text" name="special" value="<?php echo $user_data['user_special'];?>" class="anketa_form_in anketa_form_in_long" maxlength="255">
</div>
<div class="anketa_form_line parent">
    <div class="anketa_form_h"><div class="anketa_form_h_cell">Стаж</div></div>
    <input type="text" name="experience" value="<?php echo $user_data['user_experience_y'];?>" class="anketa_form_in anketa_form_in_long" maxlength="2">
    <div class="anketa_form_desk">(в годах)</div>
</div>
<div class="anketa_form_line parent">
    <div class="anketa_form_h"><div class="anketa_form_h_cell">Титулы и награды</div></div>
    <input type="text" name="titles_awards" value="<?php echo $user_data['user_titles_awards'];?>" class="anketa_form_in anketa_form_in_long" maxlength="255">
</div>
<div class="anketa_form_line parent">
    <div class="anketa_form_h"><div class="anketa_form_h_cell">О себе</div></div>
</div>
<textarea class="formatted_textarea" name="about"><?php echo $user_data['user_about'];?></textarea>
