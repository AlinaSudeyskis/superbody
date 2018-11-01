<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<form action="" class="anketa_form" method="post" enctype="multipart/form-data">
    <div class="anketa_form_line parent">
        <div class="add_tov_in_total">
            <div class="add_tov_in user_meal">
                <input type="text" name="name_user_meal" class="anketa_form_in anketa_form_in_long" placeholder="Продукт/ингредиент/блюдо" autocomplete="off">
                <div class="add_tov_list"></div>
            </div>
            <div class="add_tov_val">
                <?php $input_readonly = false;
                if(!empty($user_meal_data['meals'])):
                    $input_readonly = true;
                    $i = 0;
                    foreach($user_meal_data['meals'] as $ml_id => $meal): ?>
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
                    unset($meal);?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="anketa_form_buts_wrap parent">
        <input type="submit" name="bt_save_user_meal" value="Сохранить" class="video_admin_form_send" />
    </div>
</form>
