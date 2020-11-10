<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div id="content" class="container">
    <div class="row">
        <div class="col-lg-2 left_sidebar">
            <?php include_once('./app_fold/views/user/user_menu.php');?>
        </div><!-- left_sidebar -->
        <div class="col-lg-10 content_col">
            <div class="content_block new_content_block no_over">
                <div class="content_block_h parent">
                    <h3>Питание</h3>
                </div>
                <div class="kurs_block_val">
                    <?php if(!empty($user_meals)):?>
                        <div class="anketa_block_item">
                            <div class="anketa_block_item_h">Добавленные приемы пищи</div>
                            <?php $count_meals = count($user_meals);
                                $meal_calories = 0;
                                $meal_proteins = 0;
                                $meal_fats = 0;
                                $meal_carbohydrates = 0;
                                $day_calories = 0;
                                $day_proteins = 0;
                                $day_fats = 0;
                                $day_carbohydrates = 0; ?>
                            <?php foreach($user_meals as $key => $um):
                                if($key == 0 or $um['meal_date'] != $user_meals[$key-1]['meal_date']):
                                    $day_calories = 0;
                                    $day_proteins = 0;
                                    $day_fats = 0;
                                    $day_carbohydrates = 0; ?>
                                    <div class="content_block new_content_block ovv content_block_internal">
                                        <div class="content_block_h parent">
                                            <h3><?php echo $um['meal_date_details']; ?></h3>
                                            <div class="content_block_h_buts">
                                                <div class="content_block_h_slide kurs_slide hide_chart"></div>
                                            </div>
                                        </div>
                                        <div class="kurs_block_val">
                                <?php endif;
                                if($key == 0 or $um['datetime'] != $user_meals[$key-1]['datetime']):
                                    $meal_calories = 0;
                                    $meal_proteins = 0;
                                    $meal_fats = 0;
                                    $meal_carbohydrates = 0; ?>
                                    <div class=""><?php echo $um['meal_time']; ?></div>
                                <?php endif;
                                $koef = $um['ml_weight'] / 100;

                                $meal_calories += $um['ml_calories']*$koef;
                                $meal_proteins += $um['ml_proteins']*$koef;
                                $meal_fats += $um['ml_fats']*$koef;
                                $meal_carbohydrates += $um['ml_carbohydrates']*$koef;
                                $day_calories += $um['ml_calories']*$koef;
                                $day_proteins += $um['ml_proteins']*$koef;
                                $day_fats += $um['ml_fats']*$koef;
                                $day_carbohydrates += $um['ml_carbohydrates']*$koef;
                                ?>
                                <div id="user-meal-<?php echo $um['ml_id']; ?>" class="add_tov_val_item parent user_meals_data">
                                    <div class="add_kurs_val_video_wrap parent">
                                        <div class="add_tov_val_cont meal_cont parent">
                                            <div class="add_tov_val_h"><?php echo $um['ml_name']; ?></div>
                                            <div class="add_tov_val_sh">
                                                <div class="meal_wpfcc_wrap">
                                                    <div class="meal_wpfcc">
                                                        <div class="meal_wpfcc_title" short="К">Вес</div>
                                                        <div class="meal_wpfcc_val ingr_weight"><?php echo $um['ml_weight']; ?></div>
                                                    </div>
                                                    <div class="meal_wpfcc">
                                                        <div class="meal_wpfcc_title" short="К">Калории</div>
                                                        <div class="meal_wpfcc_val ingr_calories"><?php echo $um['ml_calories']; ?></div>
                                                    </div>
                                                    <div class="meal_wpfcc">
                                                        <div class="meal_wpfcc_title" short="Б">Белки</div>
                                                        <div class="meal_wpfcc_val ingr_proteins"><?php echo $um['ml_proteins']; ?></div>
                                                    </div>
                                                    <div class="meal_wpfcc">
                                                        <div class="meal_wpfcc_title" short="Ж">Жиры</div>
                                                        <div class="meal_wpfcc_val ingr_fats"><?php echo $um['ml_fats']; ?></div>
                                                    </div>
                                                    <div class="meal_wpfcc">
                                                        <div class="meal_wpfcc_title" short="У">Углеводы</div>
                                                        <div class="meal_wpfcc_val ingr_carbohydrates"><?php echo $um['ml_carbohydrates']; ?></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php if($count_meals == ($key+1) or $um['datetime'] != $user_meals[$key+1]['datetime']): ?>
                                    <div class="add_tov_val_sh current_meal">
                                        <div class="wpfcc_title">Прием пищи</div>
                                        <div class="meal_wpfcc_wrap">
                                            <div class="meal_wpfcc">
                                                <div class="meal_wpfcc_title" short="К">Калории</div>
                                                <div class="meal_wpfcc_val ingr_calories"><?php echo number_format($meal_calories, 2, '.', ''); ?></div>
                                            </div>
                                            <div class="meal_wpfcc">
                                                <div class="meal_wpfcc_title" short="Б">Белки</div>
                                                <div class="meal_wpfcc_val ingr_proteins"><?php echo number_format($meal_proteins, 2, '.', ''); ?></div>
                                            </div>
                                            <div class="meal_wpfcc">
                                                <div class="meal_wpfcc_title" short="Ж">Жиры</div>
                                                <div class="meal_wpfcc_val ingr_fats"><?php echo number_format($meal_fats, 2, '.', ''); ?></div>
                                            </div>
                                            <div class="meal_wpfcc">
                                                <div class="meal_wpfcc_title" short="У">Углеводы</div>
                                                <div class="meal_wpfcc_val ingr_carbohydrates"><?php echo number_format($meal_carbohydrates, 2, '.', ''); ?></div>
                                            </div>
                                        </div>
                                    </div><br/>
                                <?php endif; ?>
                                <?php if($count_meals == ($key+1) or $um['meal_date'] != $user_meals[$key+1]['meal_date']):
                                    $cal_percent = round(((100 * $day_calories) / $user_bmr));
                                    $background = '#dcfbcd';
                                    $display = 'none';
                                    if($cal_percent > 0 && $cal_percent <= 100)
                                    {
                                        $width = $cal_percent.'%';
                                    }
                                    elseif($cal_percent > 100)
                                    {
                                        $cal_percent = 100 - ($cal_percent - 100);
                                        $width = $cal_percent.'%';
                                        $display = 'block';
                                    }?>
                                    <div class="anketa_form_line parent current_meal_day">
                                        <div class="wpfcc_title">Сегодня</div>
                                        <div class="meal_wpfcc_wrap">
                                            <div class="meal_wpfcc">
                                                <div class="meal_wpfcc_title" short="К">Калории</div>
                                                <div class="meal_wpfcc_val" id="today-meal-calories" data-today-meal-calories="<?php echo number_format($day_calories, 2, '.', ''); ?>"><?php echo number_format($day_calories, 2, '.', ''); ?></div>
                                                <div class="meal_wpfcc_progress" style="width: <?php echo $width; ?>; background-color: <?php echo $background; ?>"></div>
                                                <div class="meal_wpfcc_progress right" style="display: <?php echo $display; ?>"></div>
                                            </div>
                                            <div class="meal_wpfcc">
                                                <div class="meal_wpfcc_title" short="Б">Белки</div>
                                                <div class="meal_wpfcc_val" id="today-meal-proteins" data-today-meal-proteins="<?php echo number_format($day_proteins, 2, '.', ''); ?>"><?php echo number_format($day_proteins, 2, '.', ''); ?></div>
                                            </div>
                                            <div class="meal_wpfcc">
                                                <div class="meal_wpfcc_title" short="Ж">Жиры</div>
                                                <div class="meal_wpfcc_val" id="today-meal-fats" data-today-meal-fats="<?php echo number_format($day_fats, 2, '.', ''); ?>"><?php echo number_format($day_fats, 2, '.', ''); ?></div>
                                            </div>
                                            <div class="meal_wpfcc">
                                                <div class="meal_wpfcc_title" short="У">Углеводы</div>
                                                <div class="meal_wpfcc_val" id="today-meal-carbohydrates" data-today-meal-carbohydrates="<?php echo number_format($day_carbohydrates, 2, '.', ''); ?>"><?php echo number_format($day_carbohydrates, 2, '.', ''); ?></div>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach;
                            unset($um);?>
                        </div>
                    <?php elseif(!empty($section)):
                        $def_nutrition = true;
                        $url_path = '/profile/meals/';

                        if($page_submenu == 'section'):
                            include_once('./app_fold/views/question-answer/public_qa_section.php');
                        elseif($page_submenu == 'article'):
                            include_once('./app_fold/views/question-answer/public_qa_article.php');
                        endif; ?>
                    <?php elseif(!empty($blog_categories)):
                        $def_nutrition = true;
                        $url_path = '/profile/meals/';

                        include_once('./app_fold/views/blog/user_blog_meal.php'); ?>
                    <?php else: ?>
                        <h3 class="info">Информация не найдена</h3>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div><!-- content -->
