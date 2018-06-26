<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
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
<div class="anketa_form_line parent">
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
                </div>
            <?php endif;?>
        </div>
    </div>
<?php endif;?>
<div class="anketa_form_line parent ml_videos_block">
    <div class="anketa_form_h"><div class="anketa_form_h_cell">URL видео: </div></div>
    <input name="ta_videos_block[]" class="anketa_form_in anketa_form_in_long" placeholder="URL видео" />
</div>
<div class="anketa_form_line parent">
    <div class="anketa_form_h"><div class="anketa_form_h_cell"></div></div>
    <div class="anketa_form_h"><div class="add_new_ml_videos_block">+ добавить блок видео</div></div>
</div>
<?php if(!empty($meal['meal_videos'])):?>
    <div class="anketa_form_line parent">
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
<?php endif;
if(!empty($meal['ingredients'])):
    $i = 0;
    foreach($meal['ingredients'] as $ingr):
        $bl_title = ($i == 0) ? 'Ингредиенты:' : ''; ?>
        <div class="anketa_form_line parent ingredients">
            <div class="anketa_form_h"><div class="anketa_form_h_cell"><?php echo $bl_title; ?></div></div>
            <input type="text" name="i_ingredient_name[<?php echo $ingr['id']; ?>]" value="<?php echo $ingr['name']; ?>" placeholder="Наименование" class="anketa_form_in" maxlength="255" style="width:180px;"/>
            <input type="number" name="i_ingredient_weight[<?php echo $ingr['id']; ?>]" value="<?php echo $ingr['weight']; ?>" placeholder="Вес" class="anketa_form_in in_tiny ingr_weight" maxlength="5" />
            <input type="number" name="i_ingredient_proteins[<?php echo $ingr['id']; ?>]" value="<?php echo $ingr['proteins']; ?>" placeholder="Белки" class="anketa_form_in in_tiny ingr_proteins" maxlength="5" />
            <input type="number" name="i_ingredient_fats[<?php echo $ingr['id']; ?>]" value="<?php echo $ingr['fats']; ?>" placeholder="Жиры" class="anketa_form_in in_tiny ingr_fats" maxlength="5" />
            <input type="number" name="i_ingredient_carbohydrates[<?php echo $ingr['id']; ?>]" value="<?php echo $ingr['carbohydrates']; ?>" placeholder="Углеводы" class="anketa_form_in in_tiny ingr_carbohydrates" maxlength="5" />
            <input type="number" name="i_ingredient_calories[<?php echo $ingr['id']; ?>]" value="<?php echo $ingr['calories']; ?>" placeholder="Калории" class="anketa_form_in in_tiny ingr_calories" maxlength="5" />
        </div>
        <?php $i++;
    endforeach;
    unset($ingr);?>
<?php endif;
$bl_title = (empty($meal['ingredients'])) ? 'Ингредиенты:' : ''; ?>
<div class="anketa_form_line parent ingredients">
    <div class="anketa_form_h"><div class="anketa_form_h_cell"><?php echo $bl_title; ?></div></div>
    <input type="text" name="i_ingredient_name[]" value="" placeholder="Наименование" class="anketa_form_in" maxlength="255" style="width:180px;"/>
    <input type="number" name="i_ingredient_weight[]" value="" placeholder="Вес" class="anketa_form_in in_tiny ingr_weight" maxlength="5" />
    <input type="number" name="i_ingredient_proteins[]" value="" placeholder="Белки" class="anketa_form_in in_tiny ingr_proteins" maxlength="5" />
    <input type="number" name="i_ingredient_fats[]" value="" placeholder="Жиры" class="anketa_form_in in_tiny ingr_fats" maxlength="5" />
    <input type="number" name="i_ingredient_carbohydrates[]" value="" placeholder="Углеводы" class="anketa_form_in in_tiny ingr_carbohydrates" maxlength="5" />
    <input type="number" name="i_ingredient_calories[]" value="" placeholder="Калории" class="anketa_form_in in_tiny ingr_calories" maxlength="5" />
</div>
<div class="anketa_form_line parent">
    <div class="anketa_form_h"><div class="anketa_form_h_cell"></div></div>
    <div class="anketa_form_h"><div class="add_new_ingredient">+ добавить ингредиент</div></div>
</div>
<div class="anketa_form_line parent">
    <div class="anketa_form_h"><div class="anketa_form_h_cell">Итого:</div></div>
    <input type="number" name="i_meal_weight" value="<?php if(!empty($meal)): echo $meal['weight']; endif; ?>" placeholder="Вес" class="anketa_form_in in_tiny" maxlength="5" id="meal-weight" />
    <input type="number" name="i_meal_proteins" value="<?php if(!empty($meal)): echo $meal['proteins']; endif; ?>" placeholder="Белки" class="anketa_form_in in_tiny" maxlength="5" id="meal-proteins" />
    <input type="number" name="i_meal_fats" value="<?php if(!empty($meal)): echo $meal['fats']; endif; ?>" placeholder="Жиры" class="anketa_form_in in_tiny" maxlength="5" id="meal-fats" />
    <input type="number" name="i_meal_carbohydrates" value="<?php if(!empty($meal)): echo $meal['carbohydrates']; endif; ?>" placeholder="Углеводы" class="anketa_form_in in_tiny" maxlength="5" id="meal-carbohydrates" />
    <input type="number" name="i_meal_calories" value="<?php if(!empty($meal)): echo $meal['calories']; endif; ?>" placeholder="Калории" class="anketa_form_in in_tiny" maxlength="5" id="meal-calories" />
</div>