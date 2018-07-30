<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="parent kurs_cur_wrap">
    <div class="kurs_block_h">Изображения:</div>
    <?php if (empty($product['count_images']) or $product['count_images'] < 6) : ?>
        <div class="video_down_line parent">
            <div class="video_down_line_but_wrap">
                <label for="video_down_line_but1cs" class="video_down_line_but">
                    <input type="file" name="images[]" multiple="multiple" class="admin_form_videofile" id="video_down_line_but1cs" accept="image/jpeg,image/png" />
                    <span>Выберите файл</span>
                </label>
            </div>
            <div class="video_down_line_name">Файл не выбран</div>
        </div>
    <?php endif;?>
</div>
<?php if (!empty($product['images'])):?>
    <div class="tov_form_img parent">
        <?php foreach($product['images'] as $key => $image) : ?>
            <div class="admin_form_foto_wrap">
                <div class="admin_form_foto">
                    <img src="<?php echo $image['path'];?>" alt="">
                </div>
                <div class="admin_form_buts parent">
                    <!--<label for="admin_edit_file1" class="admin_edit_file">
                        <input type="file" name="img1" class="admin_form_file" id="admin_edit_file1" />
                    </label>-->
                    <input type="hidden" name="img_path_<?php echo $key; ?>" value="<?php echo $image['path'];?>"/>
                    <input type="submit" name="bt_delete_product_img[<?php echo $key; ?>]" class="admin_form_del" value="Удалить" />
                </div>
            </div>
        <?php endforeach;
        unset($image);?>
    </div>
<?php endif;?>
<div class="parent kurs_cur_wrap">
    <div class="kurs_block_h">Категория:</div>
    <select name="sc_category_name" class="journal_form_select">
        <option value="">Выберите</option>
        <?php $i = 0;
        foreach($categories as $category):?>
            <option value="<?=$category['id']?>"
                    <?php if (!empty($product['category_id']) and $product['category_id'] == $category['id']) :?>selected="selected"<?php endif;?>>
                <?=$category['name']?></option>
            <?php $i++;
        endforeach;
        unset($category);?>
    </select>
</div>
<div class="parent kurs_cur_wrap">
    <div class="kurs_block_h">Наименование:</div>
    <input type="text"  name="name" value="<?php if(!empty($product['name'])): echo $product['name']; endif; ?>" maxlength="255" required="required" class="admin_form_txt admin_form_txt_short" placeholder="Введите наименование" />
</div>
<div class="parent kurs_cur_wrap">
    <div class="kurs_block_h">Краткое описание:</div>
    <input type="text"  name="short_desc" value="<?php if(!empty($product['short_desc'])): echo $product['short_desc']; endif; ?>" maxlength="255" required="required" class="admin_form_txt admin_form_txt_short" placeholder="Введите краткое описание" />
</div>
<div class="parent kurs_cur_wrap">
    <div class="kurs_block_h">Полное описание:</div>
    <textarea name="full_desc" class="journal_form_textarea admin_form_txt_middle" placeholder="Введите описание"><?php if(!empty($product['full_desc'])): echo $product['full_desc']; endif; ?></textarea>
</div>
<div class="parent kurs_cur_wrap">
    <div class="kurs_block_h">Цена:</div>
    <div class="parent kurs_cur_wrap">
        <input type="text" name="price" class="admin_form_txt admin_form_txt_short" placeholder="20 000.00" value="<?php if(!empty($product['price'])): echo $product['price']; endif; ?>" />
        <div class="kurs_cur">Руб</div>
    </div>
</div>
<div class="parent kurs_cur_wrap">
    <div class="kurs_block_h">Доступное количество:</div>
    <input type="text" name="quantity" class="admin_form_txt admin_form_txt_short" placeholder="20" value="<?php if(!empty($product['quantity'])): echo $product['quantity']; endif; ?>"/>
</div>
<div class="parent kurs_cur_wrap">
    <div class="kurs_block_h">Акция (скидка), %:</div>
    <input type="text" name="discount" class="admin_form_txt admin_form_txt_short" placeholder="20" value="<?php if(!empty($product['discount'])): echo $product['discount']; endif; ?>"/>
</div>
<div class="parent kurs_cur_wrap">
    <div class="kurs_block_h">Прикрепить товар:</div>
    <div class="add_tov_in_total">
        <div class="add_tov_in product">
            <input type="text" name="id" class="admin_form_txt admin_form_txt_short" placeholder="ID товара" autocomplete="off" />
            <div class="add_tov_list"> </div>
        </div>
        <div class="add_tov_val">
            <?php if (!empty($product['attached'])) :
                foreach($product['attached'] as $key => $pr) :?>
                    <div id="<?php echo $pr['id'];?>tov" class="add_tov_val_item parent">
                        <a href="/store/product/<?php echo $pr['id'];?>" class="add_tov_val_cont parent"><span class="add_tov_val_h"><?php echo $pr['name'];?></span>
                            <span class="add_tov_val_price"><?php echo $pr['price'];?> руб</span>
                        </a>
                        <div class="add_tov_val_sale">
                            <div class="kurs_block_h">Скидка, %</div>
                            <input type="hidden" name="attached_products[]" value="<?php echo $pr['id'];?>"/>
                            <input type="text" name="attached_discount[]" class="admin_form_txt" placeholder="20" value="<?php echo $pr['discount'];?>"/></div>
                        <div class="del_tov"></div>
                    </div>
                <?php endforeach;
                unset($pr);
            endif;?>
        </div>
    </div>
</div>
