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
                    <h3>Анкета</h3>
                    <div class="content_block_h_buts">
                        <div class="content_block_h_slide kurs_slide"></div>
                        <div class="content_block_h_close"></div>
                    </div>
                </div>
                <div class="kurs_block_val">
                    <div class="anketa_block">
                        <ul class="anketa_block_nav parent">
                            <li><a href="/questionnaire/anthropometric"><span <?php if($page_submenu == 'anthropometric'): ?> class="anketa_active" <?php endif;?>>Антропометрические данные</span></a></li>
                            <li><a href="/questionnaire/progress"><span <?php if($page_submenu == 'progress'): ?> class="anketa_active" <?php endif;?>>Прогресс</span></a></li>
                            <li><a href="/questionnaire/parameters"><span <?php if($page_submenu == 'parameters'): ?> class="anketa_active" <?php endif;?>>Физические параметры</span></a></li>
                            <li><a href="/questionnaire/condition"><span <?php if($page_submenu == 'condition'): ?> class="anketa_active" <?php endif;?>>Физическое состояние</span></a></li>
                            <li><a href="/questionnaire/regime"><span <?php if($page_submenu == 'regime'): ?> class="anketa_active" <?php endif;?>>Режим дня</span></a></li>
                        </ul>
                        <div class="anketa_block_cont">
                            <?php if($page_submenu == 'anthropometric'): ?>
                                <div class="anketa_block_item">
                                    <div class="anketa_block_item_h">Антропометрические данные</div>
                                    <div class="anketa_block_item_cont">
                                        <?php $user_anthrop_data = $user_data['user_anthrop_data']; ?>
                                        <?php include_once('./app_fold/views/user/questionnaire/anthropometric_form.php');?>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <?php if($page_submenu == 'progress'): ?>
                                <div class="anketa_block_item">
                                    <div class="anketa_block_item_h">Прогресс</div>
                                    <div class="anketa_block_item_cont">
                                        <?php $anthropometric = $user_data['anthropometric']; ?>
                                        <?php include_once('./app_fold/views/user/questionnaire/charts.php');?>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <?php if($page_submenu == 'parameters'): ?>
                                <div class="anketa_block_item">
                                    <div class="anketa_block_item_h">Физические параметры</div>
                                    <div class="anketa_block_item_cont">
                                        <form action="" class="anketa_form" method="post">
                                            <?php include_once('./app_fold/views/user/settings/settings_bg_item.php'); ?>

                                            <div class="anketa_form_line parent">
                                                <div class="anketa_form_h"><div class="anketa_form_h_cell">Рост</div></div>
                                                <input type="number" class="anketa_form_in anketa_form_in_long" placeholder="Рост" name="height" value="<?php echo $user_data['user_height']?>" maxlength="3" id="height"/>
                                                <div class="anketa_form_desk">см</div>
                                            </div>
                                            <div class="anketa_form_line parent">
                                                <div class="anketa_form_h"><div class="anketa_form_h_cell">Вес</div></div>
                                                <input type="text" class="anketa_form_in anketa_form_in_long" placeholder="Вес" name="weight" value="<?php echo $user_data['user_weight']?>" maxlength="5" id="weight"/>
                                                <div class="anketa_form_desk">кг</div>
                                            </div>
                                            <div class="anketa_form_info parent">
                                                <div class="anketa_form_info_h">результаты</div>
                                                <div class="anketa_form_info_cont">
                                                    <div class="anketa_form_info_line">
                                                        <span class="anketa_form_info_line_h">Индекс массы тела:</span>
                                                        <span class="anketa_form_info_txt">
                                                            <input type="hidden" name="bmi" value="<?php echo $user_data['user_bmi']?>" id="bmi" maxlength="5"/>
                                                            <span class="anketa_form_info_val" id="span_bmi"><?php echo $user_data['user_bmi']?></span>
                                                            <span class="anketa_form_info_desk" id="span_bmi_txt"><?php echo $user_data['user_bmi_txt']?></span>
                                                        </span>
                                                    </div>
                                                    <div class="anketa_form_info_line">
                                                        <span class="anketa_form_info_line_h">Базальная скорость метаболизма:</span>
                                                        <span class="anketa_form_info_txt">
                                                            <input type="hidden" name="bmr" value="<?php echo $user_data['user_bmr']?>" id="bmr"/>
                                                            <span class="anketa_form_info_val" id="span_bmr"><?php echo $user_data['user_bmr']?></span>
                                                            <span class="anketa_form_info_desk" id="span_bmr_txt"> Ккал/день</span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="anketa_form_buts_wrap parent">
                                                <!--<input type="reset" value="Отмена" class="anketa_form_reset">-->
                                                <input type="submit" name="bt_save_physical_param" value="Сохранить" class="anketa_form_but defaultActionButton">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <?php if($page_submenu == 'condition'): ?>
                                <div class="anketa_block_item">
                                    <div class="anketa_block_item_h">Физическое состояние</div>
                                    <div class="anketa_block_item_cont">
                                        <form action="" class="anketa_form" method="post">
                                            <div class="anketa_form_line parent">
                                                <div class="anketa_form_h"><div class="anketa_form_h_cell">Оценка физического состояния:</div></div>
                                                <div class="anketa_form_one_wrap anketa_form_three_wrap">
                                                    <select name="physical_condition" class="anketa_form_select">
                                                        <option>Выберите уровень</option>
                                                        <option value="1"
                                                            <?php if (!empty($user_data['user_physical_condition']) and $user_data['user_physical_condition'] == 1) :?> selected="selected" <?php endif;?>>Хорошее</option>
                                                        <option value="2"
                                                            <?php if (!empty($user_data['user_physical_condition']) and $user_data['user_physical_condition'] == 2) :?> selected="selected" <?php endif;?>>Среднее</option>
                                                        <option value="3"
                                                            <?php if (!empty($user_data['user_physical_condition']) and $user_data['user_physical_condition'] == 3) :?> selected="selected" <?php endif;?>>Плохое</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="anketa_form_line parent">
                                                <div class="anketa_form_h"><div class="anketa_form_h_cell">Пульс в покое:</div></div>
                                                <input type="text" name="pulse" value="<?php echo $user_data['user_pulse'];?>" class="anketa_form_in anketa_form_in_long" placeholder="Введите свой пульс">
                                            </div>
                                            <div class="anketa_form_line parent">
                                                <div class="anketa_form_h"><div class="anketa_form_h_cell">Цель занятий:</div></div>
                                                <div class="anketa_form_one_wrap anketa_form_three_wrap">
                                                    <select name="training_goal" class="anketa_form_select">
                                                        <option>Выберите цель</option>
                                                        <option value="1"
                                                            <?php if (!empty($user_data['user_training_goal']) and $user_data['user_training_goal'] == 1) :?> selected="selected" <?php endif;?>>Сбросить лишний вес</option>
                                                        <option value="2"
                                                            <?php if (!empty($user_data['user_training_goal']) and $user_data['user_training_goal'] == 2) :?> selected="selected" <?php endif;?>>Набор мышечной массы</option>
                                                        <option value="3"
                                                            <?php if (!empty($user_data['user_training_goal']) and $user_data['user_training_goal'] == 3) :?> selected="selected" <?php endif;?>>Общий тонус</option>
                                                        <option value="4"
                                                            <?php if (!empty($user_data['user_training_goal']) and $user_data['user_training_goal'] == 4) :?> selected="selected" <?php endif;?>>Общее оздоровление</option>
                                                        <option value="5"
                                                            <?php if (!empty($user_data['user_training_goal']) and $user_data['user_training_goal'] == 5) :?> selected="selected" <?php endif;?>>Развить выносливость</option>
                                                        <option value="6"
                                                            <?php if (!empty($user_data['user_training_goal']) and $user_data['user_training_goal'] == 6) :?> selected="selected" <?php endif;?>>Развить силу</option>
                                                        <option value="7"
                                                            <?php if (!empty($user_data['user_training_goal']) and $user_data['user_training_goal'] == 7) :?> selected="selected" <?php endif;?>>Развить гибкость</option>
                                                        <option value="8"
                                                            <?php if (!empty($user_data['user_training_goal']) and $user_data['user_training_goal'] == 8) :?> selected="selected" <?php endif;?>>Укрепить сердце</option>
                                                        <option value="9"
                                                            <?php if (!empty($user_data['user_training_goal']) and $user_data['user_training_goal'] == 9) :?> selected="selected" <?php endif;?>>Накачать ягодицы</option>
                                                        <option value="10"
                                                            <?php if (!empty($user_data['user_training_goal']) and $user_data['user_training_goal'] == 10) :?> selected="selected" <?php endif;?>>Накачать пресс</option>
                                                        <option value="11"
                                                            <?php if (!empty($user_data['user_training_goal']) and $user_data['user_training_goal'] == 11) :?> selected="selected" <?php endif;?>>Реабилитация после родов</option>
                                                        <option value="12"
                                                            <?php if (!empty($user_data['user_training_goal']) and $user_data['user_training_goal'] == 12) :?> selected="selected" <?php endif;?>>Курс омоложения</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="anketa_form_line parent">
                                                <div class="anketa_form_h"><div class="anketa_form_h_cell">История тренировок или занятий спортом:</div></div>
                                                <textarea name="sports_history" class="anketa_form_in anketa_form_in_long" placeholder="Введите историю"><?php if (!empty($user_data['user_sports_history'])) {echo $user_data['user_sports_history'];}?></textarea>
                                            </div>
                                            <div class="anketa_form_line parent">
                                                <div class="anketa_form_h"><div class="anketa_form_h_cell">Перечень травм или заболеваний:</div></div>
                                                <textarea name="injuries_diseases" class="anketa_form_in anketa_form_in_long" placeholder="Введите перечень травм"><?php if (!empty($user_data['user_injuries_diseases'])) {echo $user_data['user_injuries_diseases'];}?></textarea>
                                            </div>
                                            <div class="anketa_form_line parent">
                                                <div class="anketa_form_h"><div class="anketa_form_h_cell">Вредные привычки:</div></div>
                                                <textarea name="bad_habits" class="anketa_form_in anketa_form_in_long" placeholder="Введите вредные привычки"><?php if (!empty($user_data['user_bad_habits'])) {echo $user_data['user_bad_habits'];}?></textarea>
                                            </div>
                                            <div class="anketa_form_buts_wrap parent">
                                                <!--<input type="reset" value="Отмена" class="anketa_form_reset">-->
                                                <input type="submit" name="bt_save_physical_condition" value="Сохранить" class="anketa_form_but defaultActionButton">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <?php if($page_submenu == 'regime'): ?>
                                <div class="anketa_block_item">
                                    <div class="anketa_block_item_h">Режим дня</div>
                                    <div class="anketa_block_item_cont">
                                        <form action="" class="anketa_form" method="post">
                                            <div class="anketa_form_line parent">
                                                <div class="anketa_form_h"><div class="anketa_form_h_cell">Время бодрствования:</div></div>
                                                <div class="anketa_form_two_all parent">
                                                    <div class="anketa_form_two_wrap parent">
                                                        <div class="anketa_form_pre">c</div>
                                                        <input type="text" name="waking_from" value="<?php echo $user_data['user_waking_from'];?>" class="anketa_form_in time" placeholder="чч:мм" maxlength="5"/>
                                                    </div>
                                                    <div class="anketa_form_two_wrap parent">
                                                        <div class="anketa_form_pre">до</div>
                                                        <input type="text" name="waking_to" value="<?php echo $user_data['user_waking_to'];?>" class="anketa_form_in time" placeholder="чч:мм" maxlength="5"/>
                                                    </div>
                                                </div>
                                                <div class="anketa_form_desk">часов</div>
                                            </div>
                                            <div class="anketa_form_line parent">
                                                <div class="anketa_form_h"><div class="anketa_form_h_cell">Предпочтительное время тренировки:</div></div>
                                                <div class="anketa_form_two_all parent">
                                                    <div class="anketa_form_two_wrap parent">
                                                        <div class="anketa_form_pre">c</div>
                                                        <input type="text" name="training_time_from" value="<?php echo $user_data['user_training_time_from'];?>" class="anketa_form_in time" placeholder="чч:мм" maxlength="5"/>
                                                    </div>
                                                    <div class="anketa_form_two_wrap parent">
                                                        <div class="anketa_form_pre">до</div>
                                                        <input type="text" name="training_time_to" value="<?php echo $user_data['user_training_time_to'];?>" class="anketa_form_in time" placeholder="чч:мм" maxlength="5"/>
                                                    </div>
                                                </div>
                                                <div class="anketa_form_desk">часов</div>
                                            </div>
                                            <div class="anketa_form_line parent">
                                                <div class="anketa_form_h"><div class="anketa_form_h_cell">Количество основных приемов пищи:</div></div>
                                                <input type="text"  name="num_main_meals" value="<?php echo $user_data['user_num_main_meals']?>" class="anketa_form_in" placeholder=""/>
                                                <div class="anketa_form_desk">шт</div>
                                            </div>
                                            <div class="anketa_form_line parent">
                                                <div class="anketa_form_h"><div class="anketa_form_h_cell">Количество перекусов:</div></div>
                                                <input type="text" name="num_snacks" value="<?php echo $user_data['user_num_snacks']?>" class="anketa_form_in" placeholder="">
                                                <div class="anketa_form_desk">шт</div>
                                            </div>
                                            <div class="anketa_form_line parent">
                                                <div class="anketa_form_h"><div class="anketa_form_h_cell">Количество потребляемой воды:</div></div>
                                                <input type="text" name="amount_water_consumed" value="<?php echo $user_data['user_water_consumed']?>" class="anketa_form_in" placeholder=""/>
                                                <div class="anketa_form_desk">л</div>
                                            </div>
                                            <div class="anketa_form_line parent">
                                                <div class="anketa_form_h"><div class="anketa_form_h_cell">Количество потребляемой жидкости:<span>суп, чай, кофе, соки</span></div></div>
                                                <input type="text" name="amount_fluid_intake" value="<?php echo $user_data['user_fluid_intake']?>" class="anketa_form_in" placeholder=""/>
                                                <div class="anketa_form_desk">л</div>
                                            </div>
                                            <div class="anketa_form_buts_wrap parent">
                                                <!--<input type="reset" value="Отмена" class="anketa_form_reset">-->
                                                <input type="submit" name="bt_save_daily_regime" value="Сохранить" class="anketa_form_but defaultActionButton">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- content_col -->
    </div>
</div><!-- content -->