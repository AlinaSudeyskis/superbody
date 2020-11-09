<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php if($blog_category['id'] == 1 or $blog_category['id'] == 2): ?>
    <h3 class="info small">Будьте осторожны при редактировании!<br/>Эта категория выводиться на странице "Питание" в личном кабинете пользователя.</h3>
<?php endif; ?>
<div class="parent kurs_cur_wrap">
    <div class="kurs_block_h">Наименование:</div>
    <input type="text" name="name" class="admin_form_txt kurs_form_txt_short" value="<?php if(!empty($blog_category)): echo $blog_category['name']; endif;?>" maxlength="255" required="required" autofocus="autofocus"/>
</div>
