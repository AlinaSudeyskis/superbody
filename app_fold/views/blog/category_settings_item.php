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
<div class="parent kurs_cur_wrap down_line">
    <div class="kurs_block_h">Изображение (640x360):</div>
    <div class="video_down_line parent">
        <div class="video_down_line_but_wrap">
            <label for="blog_category_image" class="video_down_line_but">
                <input type="file" name="i_blog_category_image" class="admin_form_videofile" id="blog_category_image" accept="image/jpeg,image/png"/>
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
<?php if(!empty($blog_category['image'])): ?>
<div class="parent kurs_cur_wrap">
    <img src="<?php echo $blog_category['image'];?>" alt="">
</div>
<?php endif; ?>
