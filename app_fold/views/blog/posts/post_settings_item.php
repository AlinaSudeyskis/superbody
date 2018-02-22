<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="anketa_form_line parent">
    <input type="text" name="post_title" value="<?php if(!empty($post['title'])): echo $post['title']; endif;?>" class="anketa_form_in anketa_form_in_long" placeholder="Заголовок" maxlength="100" />
</div>
<div class="anketa_form_line parent">
    <input type="text" name="post_short_desc" value="<?php if(!empty($post['short_desc'])): echo $post['short_desc']; endif;?>" class="anketa_form_in anketa_form_in_long" placeholder="Краткое описание" maxlength="255" />
</div>
<div class="anketa_form_line parent">
    <textarea name="post_text" class="full_photo_comm_in ta_dark" maxlength="1000" placeholder="Полный текст"><?php if(!empty($post['text'])): echo $post['text']; endif;?></textarea>
</div>