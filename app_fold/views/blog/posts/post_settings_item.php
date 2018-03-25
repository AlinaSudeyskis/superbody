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
    <div class="kurs_block_h">Полный текст:</div>
    <textarea name="post_text" class="full_photo_comm_in ta_dark" maxlength="1000" style="height: 250px;"><?php if(!empty($post['text'])): echo $post['text']; endif;?></textarea>
</div>