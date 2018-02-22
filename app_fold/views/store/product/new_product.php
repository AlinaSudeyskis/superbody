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
                    <h3>Добавить товар</h3>
                    <div class="content_block_h_buts">
                        <div class="content_block_h_slide kurs_slide"></div>
                        <div class="content_block_h_close"></div>
                    </div>
                </div>
                <div class="kurs_block_val">
                    <form action="" class="video_admin_form" method="post" enctype="multipart/form-data">
                        <div class="video_down_line parent">
                            <div class="admin_form_h">Изображение</div>
                            <div class="parent kurs_cur_wrap">
                                <div class="video_down_line_but_wrap">
                                    <label for="video_down_line_but1cs" class="video_down_line_but">
                                        <input type="file" name="images[]" multiple="multiple" class="admin_form_videofile" id="video_down_line_but1cs" accept="image/jpeg,image/png" />
                                        <span>Выберите файл</span>
                                    </label>
                                </div>
                                <div class="video_down_line_name">Файл не выбран</div>
                            </div>
                        </div>
                        <div class="admin_form_h">Категория</div>
                        <select name="sc_category_name" class="journal_form_select">
                            <option value="">Выберите</option>
                            <?php $i = 0;
                            foreach($categories as $category):?>
                                <option value="<?=$category['id']?>"><?=$category['name']?></option>
                                <?php $i++;
                            endforeach;
                            unset($category);?>
                        </select>
                        <div class="admin_form_h">Наименование</div>
                        <input type="text"  name="name" value="" maxlength="255" required="required" class="admin_form_txt" placeholder="Введите наименование" />
                        <div class="admin_form_h">Краткое описание</div>
                        <input type="text"  name="short_desc" value="" maxlength="255" required="required" class="admin_form_txt" placeholder="Введите описание" />
                        <div class="admin_form_h">Полное описание</div>
                        <textarea name="full_desc" class="tov_form_textarea" placeholder="Введите описание"></textarea>
                        <div class="admin_form_h">Цена</div>
                        <div class="parent kurs_cur_wrap">
                            <input type="text" name="price" class="admin_form_txt admin_form_txt_short" placeholder="20 000.00" value="" />
                            <div class="kurs_cur">Руб</div>
                        </div>
                        <div class="admin_form_h">Доступное количество</div>
                        <input type="text" name="quantity" class="admin_form_txt admin_form_txt_short" placeholder="20" />
                        <div class="admin_form_h">Акция (скидка), %</div>
                        <input type="text" name="discount" class="admin_form_txt admin_form_txt_short" placeholder="20"/>
                        <div class="admin_form_h">Прикрепить товар</div>
                        <div class="add_tov_in_total">
                            <div class="add_tov_in product">
                                <input type="text" name="id" class="admin_form_txt admin_form_txt_short" placeholder="ID товара" autocomplete="off" />
                                <div class="add_tov_list"> </div>
                            </div>
                            <div class="add_tov_val"></div>
                        </div>
                        <div class="video_admin_form_buts parent">
                            <input type="submit" name="bt_save_new_product" value="Сохранить" class="video_admin_form_send" />
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- content_col -->
    </div>
</div><!-- content -->