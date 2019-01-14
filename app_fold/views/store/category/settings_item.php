<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="parent kurs_cur_wrap">
    <div class="kurs_block_h">Наименование:</div>
    <?php $disabled = '';
    if($category['id'] == 1 or $category['id'] == 2 or $category['id'] == 6): $disabled = 'disabled'; endif;?>
    <input type="text" name="name" class="admin_form_txt admin_form_txt_middle <?php echo $disabled; ?>" value="<?php if(!empty($category['name'])) : echo $category['name']; endif;?>" maxlength="255" required="required" />
</div>
<div class="parent kurs_cur_wrap">
    <div class="kurs_block_h">Описание:</div>
    <textarea name="ta_description" class="journal_form_textarea admin_form_txt_middle" maxlength="255"><?php if(!empty($category['desc'])) : echo $category['desc']; endif;?></textarea>
</div>