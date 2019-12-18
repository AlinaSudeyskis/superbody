<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<form action="" class="anketa_form user_meal_form" method="post" onsubmit="return false">
    <h3 class="landing">Прием пищи</h3>
    <div class="anketa_form_line parent user_meal_time">
        <div class="anketa_form_one_wrap anketa_form_three_wrap">
            <select name="s_meal_time" class="anketa_form_select" id="u-meal-time">
                <option value="now">Сейчас</option>
                <option value="select">Указать дату и время</option>
            </select>
            <input name="i_um_datetime" id="um-datetimepicker" type="text" value="" placeholder="Выберите дату и время">
        </div>
    </div>
    <div class="anketa_form_line parent user_meals">
        <div class="add_tov_in_total">
            <div class="add_tov_in user_meal">
                <input type="text" name="name_user_meal" class="anketa_form_in anketa_form_in_long" placeholder="Поиск продукта/ингредиента/блюда" autocomplete="off" autofocus>
                <div class="add_tov_list"></div>
            </div>
            <div class="add_tov_val">
                <?php /*$input_readonly = false;
                if(!empty($user_meal_data['user_meal'])):
                    $input_readonly = true;
                    $i = 0;
                    foreach($user_meal_data['user_meal'] as $ml_id => $meal): */?><!--
                        <div id="user-meal-<?php /*echo $ml_id; */?>" class="add_tov_val_item parent user_meals_data">
                            <div class="add_kurs_val_video_wrap parent">
                                <div class="add_tov_val_cont meal_cont parent">
                                    <div class="add_tov_val_h"><?php /*echo $meal['name']; */?></div>
                                    <div class="add_tov_val_sh">
                                        <div class="meal_wpfcc_wrap">
                                            <div class="meal_wpfcc">
                                                <div class="meal_wpfcc_title" short="В">Вес</div>
                                                <div class="meal_wpfcc_val">
                                                    <input type="number" name="i_ingredient_weight[<?php /*echo $ml_id; */?>]"
                                                           value="<?php /*echo $meal['weight']; */?>" placeholder="0.00"
                                                           class="anketa_form_in in_fill ingr_weight" required="required"/>
                                                </div>
                                            </div>
                                            <div class="meal_wpfcc">
                                                <div class="meal_wpfcc_title" short="К">Калории</div>
                                                <div class="meal_wpfcc_val ingr_calories"><?php /*echo $meal['calories']; */?></div>
                                            </div>
                                            <div class="meal_wpfcc">
                                                <div class="meal_wpfcc_title" short="Б">Белки</div>
                                                <div class="meal_wpfcc_val ingr_proteins"><?php /*echo $meal['proteins']; */?></div>
                                            </div>
                                            <div class="meal_wpfcc">
                                                <div class="meal_wpfcc_title" short="Ж">Жиры</div>
                                                <div class="meal_wpfcc_val ingr_fats"><?php /*echo $meal['fats']; */?></div>
                                            </div>
                                            <div class="meal_wpfcc">
                                                <div class="meal_wpfcc_title" short="У">Углеводы</div>
                                                <div class="meal_wpfcc_val ingr_carbohydrates"><?php /*echo $meal['carbohydrates']; */?></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="del_tov"></div>
                            </div>
                        </div>
                        <?php /*$i++;
                    endforeach;
                    unset($meal);*/?>
                --><?php /*endif; */?>
            </div>
        </div>
    </div>
    <div class="anketa_form_line parent current_meal">
        <div class="wpfcc_title">Текущий прием пищи</div>
        <div class="meal_wpfcc_wrap">
            <div class="meal_wpfcc">
                <div class="meal_wpfcc_title" short="К">Калории</div>
                <div class="meal_wpfcc_val" id="current-meal-calories">0.00</div>
            </div>
            <div class="meal_wpfcc">
                <div class="meal_wpfcc_title" short="Б">Белки</div>
                <div class="meal_wpfcc_val" id="current-meal-proteins">0.00</div>
            </div>
            <div class="meal_wpfcc">
                <div class="meal_wpfcc_title" short="Ж">Жиры</div>
                <div class="meal_wpfcc_val" id="current-meal-fats">0.00</div>
            </div>
            <div class="meal_wpfcc">
                <div class="meal_wpfcc_title" short="У">Углеводы</div>
                <div class="meal_wpfcc_val" id="current-meal-carbohydrates">0.00</div>
            </div>
        </div>
    </div>
    <div class="anketa_form_buts_wrap parent">
        <input type="submit" name="bt_save_user_meal" value="Сохранить" class="video_admin_form_send defaultActionButton" id="bt-save-user-meal" />
    </div>
    <div class="anketa_form_line parent current_meal_day">
        <div class="wpfcc_title">Сегодня</div>
        <input type="hidden" value="<?php echo $user_bmr['user_bmr']; ?>" id="u-bmr">
        <?php
            $today_calories = (is_numeric($user_meal_data['today_meal_calories'])) ? $user_meal_data['today_meal_calories'] : '0.00';
            $today_proteins = (is_numeric($user_meal_data['today_meal_proteins'])) ? $user_meal_data['today_meal_proteins'] : '0.00';
            $today_fats = (is_numeric($user_meal_data['today_meal_fats'])) ? $user_meal_data['today_meal_fats'] : '0.00';
            $today_carbohydrates = (is_numeric($user_meal_data['today_meal_carbohydrates'])) ? $user_meal_data['today_meal_carbohydrates'] : '0.00';

            $display = 'none';
            if($today_calories > 0)
            {
                $cal_percent = round(((100 * $today_calories) / $user_bmr['user_bmr']));
                $background = '#dcfbcd';
                if($cal_percent > 0 && $cal_percent <= 100)
                {
                    $width = $cal_percent.'%';
                }
                elseif($cal_percent > 100)
                {
                    $cal_percent = 100 - ($cal_percent - 100);
                    $width = $cal_percent.'%';
                    $display = 'block';
                }
            }
        ?>
        <div class="meal_wpfcc_wrap">
            <div class="meal_wpfcc">
                <div class="meal_wpfcc_title" short="К">Калории</div>
                <div class="meal_wpfcc_val" id="today-meal-calories" data-today-meal-calories="<?php echo $today_calories; ?>"><?php echo $today_calories; ?></div>
                <div class="meal_wpfcc_progress" style="width: <?php echo $width; ?>; background-color: <?php echo $background; ?>"></div>
                <div class="meal_wpfcc_progress right" style="display: <?php echo $display; ?>"></div>
            </div>
            <div class="meal_wpfcc">
                <div class="meal_wpfcc_title" short="Б">Белки</div>
                <div class="meal_wpfcc_val" id="today-meal-proteins" data-today-meal-proteins="<?php echo $today_proteins; ?>"><?php echo $today_proteins; ?></div>
            </div>
            <div class="meal_wpfcc">
                <div class="meal_wpfcc_title" short="Ж">Жиры</div>
                <div class="meal_wpfcc_val" id="today-meal-fats" data-today-meal-fats="<?php echo $today_fats; ?>"><?php echo $today_fats; ?></div>
            </div>
            <div class="meal_wpfcc">
                <div class="meal_wpfcc_title" short="У">Углеводы</div>
                <div class="meal_wpfcc_val" id="today-meal-carbohydrates" data-today-meal-carbohydrates="<?php echo $today_carbohydrates; ?>"><?php echo $today_carbohydrates; ?></div>
            </div>
        </div>
    </div>
</form>
