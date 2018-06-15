<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="content" class="container">
    <div class="row">
        <div class="col-lg-2 left_sidebar">
            <?php include_once('./app_fold/views/admin/admin_menu.php');?>
        </div><!-- left_sidebar -->
        <div class="col-lg-10 content_col">
            <div class="content_block ovv">
                <div class="content_block_h parent">
                    <h3>Редактировать товар</h3>
                    <div class="content_block_h_buts">
                        <div class="content_block_h_slide kurs_slide"></div>
                        <div class="content_block_h_close"></div>
                    </div>
                </div>
                <div class="kurs_block_val">
                    <form action="" class="video_admin_form" method="post" enctype="multipart/form-data">
                        <div class="parent kurs_cur_wrap">
                            <div class="kurs_block_h">Изображения:</div>
                            <?php if ($product['count_images'] < 6) : ?>
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
                        <div class="tov_form_img parent">
                            <?php if (!empty($product['images'])):
                                foreach($product['images'] as $key => $image) : ?>
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
                                unset($image);
                            endif;?>
                        </div>
                        <div class="admin_form_h">Категория</div>
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
                        <div class="admin_form_h">Наименование</div>
                        <input type="text"  name="name" value="<?php echo $product['name'];?>" maxlength="255" required="required" class="admin_form_txt" placeholder="Введите наименование" />
                        <div class="admin_form_h">Краткое описание</div>
                        <input type="text"  name="short_desc" value="<?php echo $product['short_desc'];?>" maxlength="255" required="required" class="admin_form_txt" placeholder="Введите описание" />
                        <div class="admin_form_h">Полное описание</div>
                        <textarea name="full_desc" class="tov_form_textarea" placeholder="Введите описание"><?php echo $product['full_desc'];?></textarea>
                        <div class="admin_form_h">Цена</div>
                        <div class="parent kurs_cur_wrap">
                            <input type="text" name="price" class="admin_form_txt admin_form_txt_short" placeholder="20 000.00" value="<?php echo $product['price'];?>" />
                            <div class="kurs_cur">Руб</div>
                        </div>
                        <div class="admin_form_h">Доступное количество</div>
                        <input type="text" name="quantity" class="admin_form_txt admin_form_txt_short" placeholder="20" value="<?php echo $product['quantity'];?>"/>
                        <div class="admin_form_h">Акция (скидка), %</div>
                        <input type="text" name="discount" class="admin_form_txt admin_form_txt_short" placeholder="20" value="<?php echo $product['discount'];?>"/>
                        <div class="admin_form_h">Прикрепить товар</div>
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
                                                <div class="admin_form_h">Скидка, %</div>
                                                <input type="hidden" name="attached_products[]" value="<?php echo $pr['id'];?>"/>
                                                <input type="text" name="attached_discount[]" class="admin_form_txt" placeholder="20" value="<?php echo $pr['discount'];?>"/></div>
                                            <div class="del_tov"></div>
                                        </div>
                                    <?php endforeach;
                                    unset($pr);
                                endif;?>
                            </div>
                        </div>
                        <div class="video_admin_form_buts parent">
                            <input type="submit" name="bt_save_product" value="Сохранить" class="video_admin_form_send" />
                            <?php if ($product['blocked'] == 0) : ?>
                                <input type="submit" name="bt_block_product" class="admin_form_block" value="Заблокировать"/>
                            <?php else: ?>
                                <input type="submit" name="bt_unblock_product" class="admin_form_block" value="Разблокировать"/>
                            <?php endif;?>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- content_col -->
    </div>
</div><!-- content -->