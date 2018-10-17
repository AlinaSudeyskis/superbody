<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="anketa_form_line parent">
    <div class="anketa_form_h"><div class="anketa_form_h_cell">Категория:</div></div>
    <div class="anketa_form_one_wrap anketa_form_three_wrap">
        <select name="s_category" class="anketa_form_select" id="meal-category">
            <option value="1" <?php if($meal['category_id'] == 1):?>selected="selected"<?php endif; ?>>Блюдо</option>
            <option value="2" <?php if($meal['category_id'] == 2):?>selected="selected"<?php endif; ?>>Продукт/Ингредиент</option>
        </select>
    </div>
</div>
<div class="anketa_form_line parent">
    <div class="anketa_form_h"><div class="anketa_form_h_cell">Тип блюда:</div></div>
    <div class="anketa_form_one_wrap anketa_form_three_wrap">
        <select name="s_meal_type" class="anketa_form_select">
            <?php foreach($meals_types as $type): ?>
                <option value="<?php echo $type['id']; ?>"
                        <?php if(!empty($meal['type_id']) and $meal['type_id'] == $type['id']):?>selected="selected"<?php endif; ?>
                ><?php echo $type['name']; ?></option>
            <?php endforeach;
            unset($type);?>
        </select>
    </div>
</div>
<div class="anketa_form_line parent">
    <div class="anketa_form_h"><div class="anketa_form_h_cell">Наименование:</div></div>
    <input type="text" name="i_name" value="<?php if(!empty($meal['name'])): echo $meal['name']; endif; ?>" class="anketa_form_in anketa_form_in_long" maxlength="255" required="required" />
</div>
<div class="anketa_form_line parent">
    <div class="anketa_form_h"><div class="anketa_form_h_cell">Описание:</div></div>
    <textarea name="ta_desc" class="journal_form_textarea admin_form_txt_middle" maxlength="2000"><?php if(!empty($meal['description'])): echo $meal['description']; endif; ?></textarea>
</div>
<div class="anketa_form_line parent" id="meal-ingredients-desc" <?php if($meal['category_id'] == 2):?>style="display:none;"<?php endif;?>>
    <div class="anketa_form_h"><div class="anketa_form_h_cell">Игредиенты:</div></div>
    <textarea name="ta_ingredients" class="journal_form_textarea admin_form_txt_middle" maxlength="2000"><?php if(!empty($meal['ingredients_text'])): echo $meal['ingredients_text']; endif; ?></textarea>
</div>
<div class="anketa_form_line parent">
    <div class="anketa_form_h"><div class="anketa_form_h_cell">Изображения:</div></div>
    <div class="video_down_line parent">
        <div class="video_down_line_but_wrap">
            <label for="video_down_line_but1cs" class="video_down_line_but">
                <input type="file" name="meals_images[]" class="admin_form_videofile" id="video_down_line_but1cs" accept="image/jpeg,image/png,image/gif" multiple="multiple">
                <span>Выберите файл</span>
            </label>
        </div>
        <div class="video_down_line_name">Файл не выбран</div>
    </div>
</div>
<?php if(!empty($meal['images']) or !empty($meal['image'])): ?>
    <div class="anketa_form_line parent">
        <div class="anketa_form_h"><div class="anketa_form_h_cell"></div></div>
        <div class="tov_form_img parent">
            <?php if(!empty($meal['images'])):
                foreach($meal['images'] as $key => $m_i): ?>
                    <div class="admin_form_foto_wrap">
                        <div class="admin_form_foto">
                            <img src="/meals_files/<?php echo $meal['id'] . '/' . $m_i; ?>" alt="" />
                        </div>
                        <div class="admin_form_buts parent">
                            <input type="hidden" name="img_path_<?php echo $key; ?>" value="/meals_files/<?php echo $meal['id'] . '/' . $m_i; ?>">
                            <input type="submit" name="bt_delete_img[<?php echo $key; ?>]" class="admin_form_del" value="Удалить">
                        </div>
                    </div>
                <?php endforeach;
                unset($m_i);
            endif;
            if(!empty($meal['image'])):?>
                <div class="admin_form_foto_wrap">
                    <div class="admin_form_foto">
                        <img src="<?php echo $meal['image']; ?>" alt="" />
                    </div>
                    <div class="admin_form_buts parent">
                        <input type="hidden" name="img_path" value="<?php echo $meal['image']; ?>">
                        <input type="submit" name="bt_del_img" class="admin_form_del" value="Удалить">
                    </div>
                    <?php $image_info = pathinfo($meal['image'], PATHINFO_FILENAME); ?>
                    <div class="admin_img_info"><?php echo $image_info; ?></div>
                </div>
            <?php endif;?>
        </div>
    </div>
<?php endif;?>
<div class="anketa_form_line parent ml_videos_block" <?php if($meal['category_id'] == 2):?>style="display:none;"<?php endif;?>>
    <div class="anketa_form_h"><div class="anketa_form_h_cell">URL видео: </div></div>
    <input name="ta_videos_block[]" class="anketa_form_in anketa_form_in_long" placeholder="URL видео" />
</div>
<div class="anketa_form_line parent" id="meal-add-video" <?php if($meal['category_id'] == 2):?>style="display:none;"<?php endif;?>>
    <div class="anketa_form_h"><div class="anketa_form_h_cell"></div></div>
    <div class="anketa_form_h"><div class="add_new_ml_videos_block">+ добавить блок видео</div></div>
</div>
<?php if(!empty($meal['meal_videos'])):?>
    <div class="anketa_form_line parent" id="meal-videos" <?php if($meal['category_id'] == 2):?>style="display:none;"<?php endif;?>>
        <div class="anketa_form_h"><div class="anketa_form_h_cell"></div></div>
        <div class="tov_form_img parent">
            <?php foreach($meal['meal_videos'] as $key => $v_data):?>
                <div class="admin_form_foto_wrap">
                    <div class="admin_form_foto">
                        <iframe width="180" height="108" src="<?php echo $v_data; ?>" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                    </div>
                    <div class="admin_form_buts parent">
                        <input type="submit" name="bt_delete_ml_video[<?php echo $key; ?>]" class="admin_form_del" value="Удалить">
                    </div>
                </div>
            <?php endforeach;
            unset($v_data); ?>
        </div>
    </div>
<?php endif; ?>
<div class="anketa_form_line parent ingredients" <?php if($meal['category_id'] == 2):?>style="display:none;"<?php endif;?>>
    <div class="anketa_form_h"><div class="anketa_form_h_cell">Ингредиенты:</div></div>
    <div class="add_tov_in_total">
        <div class="add_tov_in ingredient">
            <input type="text" name="name_ingredient" class="anketa_form_in anketa_form_in_long" placeholder="Введите наименование продукта/ингредиента" autocomplete="off">
            <div class="add_tov_list"></div>
        </div>
        <div class="add_tov_val">
            <?php $input_readonly = false;
            if(!empty($meal['ingredients'])):
                $input_readonly = true;
                $i = 0;
                foreach($meal['ingredients'] as $ingr_id => $ingr): ?>
                    <div id="ingredient-<?php echo $ingr_id; ?>" class="add_tov_val_item parent ingredients_data">
                        <div class="add_kurs_val_video_wrap parent">
                            <div class="add_tov_val_cont meal_cont parent">
                                <div class="add_tov_val_h"><a href="/administration/meal/<?php echo $ingr_id ?>"><?php echo $ingr['name']; ?></a></div>
                                <div class="add_tov_val_sh">
                                    <div class="meal_wpfcc_wrap">
                                        <div class="meal_wpfcc">
                                            <div class="meal_wpfcc_title" short="В">Вес</div>
                                            <div class="meal_wpfcc_val"><input type="number" name="i_ingredient_weight[<?php echo $ingr_id; ?>]" value="<?php echo $ingr['weight']; ?>" placeholder="0.00" class="anketa_form_in in_fill ingr_weight" required="required"/></div>
                                        </div>
                                        <div class="meal_wpfcc">
                                            <div class="meal_wpfcc_title" short="К">Калории</div>
                                            <div class="meal_wpfcc_val ingr_calories"><?php echo $ingr['calories']; ?></div>
                                        </div>
                                        <div class="meal_wpfcc">
                                            <div class="meal_wpfcc_title" short="Б">Белки</div>
                                            <div class="meal_wpfcc_val ingr_proteins"><?php echo $ingr['proteins']; ?></div>
                                        </div>
                                        <div class="meal_wpfcc">
                                            <div class="meal_wpfcc_title" short="Ж">Жиры</div>
                                            <div class="meal_wpfcc_val ingr_fats"><?php echo $ingr['fats']; ?></div>
                                        </div>
                                        <div class="meal_wpfcc">
                                            <div class="meal_wpfcc_title" short="У">Углеводы</div>
                                            <div class="meal_wpfcc_val ingr_carbohydrates"><?php echo $ingr['carbohydrates']; ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="del_tov"></div>
                        </div>
                    </div>
                    <?php $i++;
                endforeach;
                unset($ingr);?>
            <?php endif; ?>
        </div>
    </div>
</div>
<div class="anketa_form_line parent">
    <div class="anketa_form_h"><div class="anketa_form_h_cell">КБЖУ на 100г:</div></div>
    <div class="meal_wpfcc_wrap">
        <div class="meal_wpfcc">
            <div class="meal_wpfcc_title" short="В">Вес</div>
            <div class="meal_wpfcc_val">
                <input type="number" name="i_meal_weight_100" value="100" class="anketa_form_in in_fill" disabled="disabled"/>
            </div>
        </div>
        <div class="meal_wpfcc">
            <div class="meal_wpfcc_title" short="К">Калории</div>
            <div class="meal_wpfcc_val">
                <input type="number" name="i_meal_calories_100" value="<?php if(!empty($meal)): echo $meal['calories']; endif; ?>"
                   placeholder="0.00" class="anketa_form_in in_fill" maxlength="5" id="meal-calories-100"
                   <?php if($input_readonly): ?>readonly<?php endif;?>/>
            </div>
        </div>
        <div class="meal_wpfcc">
            <div class="meal_wpfcc_title" short="Б">Белки</div>
            <div class="meal_wpfcc_val">
                <input type="number" name="i_meal_proteins_100" value="<?php if(!empty($meal)): echo $meal['proteins']; endif; ?>"
                   placeholder="0.00" class="anketa_form_in in_fill" maxlength="5" id="meal-proteins-100"
                   <?php if($input_readonly): ?>readonly<?php endif;?> />
            </div>
        </div>
        <div class="meal_wpfcc">
            <div class="meal_wpfcc_title" short="Ж">Жиры</div>
            <div class="meal_wpfcc_val">
                <input type="number" name="i_meal_fats_100" value="<?php if(!empty($meal)): echo $meal['fats']; endif; ?>"
                   placeholder="0.00" class="anketa_form_in in_fill" maxlength="5" id="meal-fats-100"
                   <?php if($input_readonly): ?>readonly<?php endif;?> />
            </div>
        </div>
        <div class="meal_wpfcc">
            <div class="meal_wpfcc_title" short="У">Углеводы</div>
            <div class="meal_wpfcc_val">
                <input type="number" name="i_meal_carbohydrates_100" value="<?php if(!empty($meal)): echo $meal['carbohydrates']; endif; ?>"
                   placeholder="0.00" class="anketa_form_in in_fill" maxlength="5" id="meal-carbohydrates-100"
                   <?php if($input_readonly): ?>readonly<?php endif;?> />
            </div>
        </div>
    </div>
</div>
<?php
$koef = ($meal['weight'] > 0) ? ($meal['weight'] / 100) : 0;
$calories = ($koef > 0) ? ($meal['calories'] * $koef) : '';
$proteins = ($koef > 0) ? ($meal['proteins'] * $koef) : 0;
$fats = ($koef > 0) ? ($meal['fats'] * $koef) : 0;
$carbohydrates = ($koef > 0) ? ($meal['carbohydrates'] * $koef) : 0;
?>
<div class="anketa_form_line parent">
    <div class="anketa_form_h"><div class="anketa_form_h_cell">Итоговое КБЖУ:</div></div>
    <div class="meal_wpfcc_wrap">
        <div class="meal_wpfcc">
            <div class="meal_wpfcc_title" short="В">Вес</div>
            <div class="meal_wpfcc_val">
                <input type="number" name="i_meal_weight" value="<?php if(!empty($meal)): echo $meal['weight']; endif; ?>"
                   placeholder="0.00" class="anketa_form_in in_fill" maxlength="5" id="meal-weight"
                   <?php if($input_readonly): ?>readonly<?php endif;?> />
            </div>
        </div>
        <div class="meal_wpfcc">
            <div class="meal_wpfcc_title" short="К">Калории</div>
            <div class="meal_wpfcc_val">
                <input type="number" name="i_meal_calories" value="<?php echo $calories; ?>"
                       placeholder="0.00" class="anketa_form_in in_fill" maxlength="5" id="meal-calories" disabled="disabled"/>
            </div>
        </div>
        <div class="meal_wpfcc">
            <div class="meal_wpfcc_title" short="Б">Белки</div>
            <div class="meal_wpfcc_val">
                <input type="number" name="i_meal_proteins" value="<?php echo $proteins; ?>"
                       placeholder="0.00" class="anketa_form_in in_fill" maxlength="5" id="meal-proteins" disabled="disabled"/>
            </div>
        </div>
        <div class="meal_wpfcc">
            <div class="meal_wpfcc_title" short="Ж">Жиры</div>
            <div class="meal_wpfcc_val">
                <input type="number" name="i_meal_fats" value="<?php echo $fats; ?>"
                       placeholder="0.00" class="anketa_form_in in_fill" maxlength="5" id="meal-fats" disabled="disabled"/>
            </div>
        </div>
        <div class="meal_wpfcc">
            <div class="meal_wpfcc_title" short="У">Углеводы</div>
            <div class="meal_wpfcc_val">
                <input type="number" name="i_meal_carbohydrates" value="<?php echo $carbohydrates; ?>"
                       placeholder="0.00" class="anketa_form_in in_fill" maxlength="5" id="meal-carbohydrates" disabled="disabled"/>
            </div>
        </div>
    </div>
</div>