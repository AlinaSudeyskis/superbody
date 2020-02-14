<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="parent kurs_cur_wrap">
    <div class="kurs_block_h">Наименование:</div>
    <input type="text" name="name" class="admin_form_txt kurs_form_txt_short" value="<?php echo $type['name'];?>" maxlength="255" required="required" autofocus="autofocus"/>
</div>
<div class="practice_block_h">Метаданные</div>
<div class="parent kurs_cur_wrap">
    <div class="kurs_block_h">Title:</div>
    <textarea name="ta_meta_title" class="journal_form_textarea admin_form_txt_middle" placeholder="" maxlength="255"><?php echo $type['meta_title'];?></textarea>
</div>
<div class="parent kurs_cur_wrap">
    <div class="kurs_block_h">Description:</div>
    <textarea name="ta_meta_description" class="journal_form_textarea admin_form_txt_middle" placeholder="" maxlength="255"><?php echo $type['meta_description'];?></textarea>
</div>
<div class="parent kurs_cur_wrap">
    <div class="kurs_block_h">Keywords:</div>
    <textarea name="ta_meta_keywords" class="journal_form_textarea admin_form_txt_middle" placeholder="" maxlength="1000"><?php echo $type['meta_keywords'];?></textarea>
</div>
