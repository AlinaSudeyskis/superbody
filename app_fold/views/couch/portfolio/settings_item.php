<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php if(!empty($post) and $post['approval'] == 1): ?>
    <h3 class="info small">Изменение не доступно. Запись одобрена администратором.</h3>
<?php endif; ?>
<div class="tren_set_form_l">
    <div class="tren_set_form_img">
        <?php if(!empty($post['path'])): ?>
            <img src="<?php echo $post['path'];?>" alt="">
        <?php else: ?>
            <img src="/img/no_img.png" alt="">
        <?php endif; ?>
    </div>
    <?php if(!empty($post) and $post['approval'] == 0): ?>
        <div class="tren_set_form_add">
            <label for="tren_set_form_pop_up_upload">
                Выбрать фото
                <input type="hidden" name="MAX_FILE_SIZE" value="2097152" />
                <input type="file" name="portfolio_image" id="tren_set_form_pop_up_upload" class="tren_set_form_pop_up_upload" />
            </label>
        </div>
    <?php endif; ?>
</div>
<div class="tren_set_form_r">
    <div class="tren_set_form_h">Название</div>
    <input type="text" name="image_title" class="tren_set_form_in" placeholder="Введите название" value="<?php if(!empty($post['title'])): echo $post['title']; endif; ?>"/>
    <div class="tren_set_form_h">Описание</div>
    <textarea name="image_description" class="tren_set_form_txt" placeholder="Введите описание"><?php if(!empty($post['title'])): echo $post['desc']; endif; ?></textarea>
</div>