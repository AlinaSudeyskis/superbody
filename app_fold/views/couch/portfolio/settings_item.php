<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php if(!empty($post) and $post['approval'] == 1): ?>
    <h3 class="info small">Изменение не доступно. Запись одобрена администратором.</h3>
<?php endif; ?>
<div class="tren_set_form_img">
    <?php if(!empty($post['path'])): ?>
        <img src="<?php echo $post['path'];?>" alt="">
    <?php elseif(!empty($post)): ?>
        <img src="/img/no_img.png" alt="">
    <?php endif; ?>
</div>
<?php if((!empty($post) and $post['approval'] == 0) or empty($post)): ?>
    <div class="anketa_form_line parent">
        <div class="anketa_form_h"><div class="anketa_form_h_cell">Изображение:</div></div>
        <div class="video_down_line parent">
            <div class="parent kurs_cur_wrap">
                <div class="video_down_line_but_wrap">
                    <label for="video_down_line_but1cs" class="video_down_line_but">
                        <input type="hidden" name="MAX_FILE_SIZE" value="2097152">
                        <input type="file" name="portfolio_image" class="admin_form_videofile" id="video_down_line_but1cs" accept="image/jpeg,image/png">
                        <span>Выберите файл</span>
                    </label>
                </div>
                <div class="video_down_line_name" style="width:45% !important;">Файл не выбран</div>
            </div>
        </div>
    </div>
<?php endif; ?>
<div class="anketa_form_line parent">
    <div class="anketa_form_h"><div class="anketa_form_h_cell">Название:</div></div>
    <input type="text" name="image_title" class="tren_set_form_in" placeholder="Введите название" value="<?php if(!empty($post['title'])): echo $post['title']; endif; ?>"/>
</div>
<div class="anketa_form_line parent">
    <div class="anketa_form_h"><div class="anketa_form_h_cell">Описание:</div></div>
    <textarea name="image_description" class="tren_set_form_txt" placeholder="Введите описание"><?php if(!empty($post['title'])): echo $post['desc']; endif; ?></textarea>
</div>
