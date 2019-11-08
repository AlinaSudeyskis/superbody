<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="content" class="container">
    <div class="row">
        <div class="col-lg-2 left_sidebar">
            <?php if ($user_session['type'] == 2) :
                include_once('./app_fold/views/coach/coach_menu.php');
            else :
                include_once('./app_fold/views/user/user_menu.php');
            endif;?>
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
                            <li><span class="anketa_active" >Антропометрические данные</span></li>
                            <li><span>Физические параметры</span></li>
                            <li><span>Физическое состояние</span></li>
                            <li><span>Режим дня</span></li>
                        </ul>
                        <div class="anketa_block_cont">
                            <div class="anketa_block_item">
                                <div class="anketa_block_item_h">Антропометрические данные</div>
                                <div class="anketa_block_item_cont">
                                    <?php include_once('./app_fold/views/user/questionnaire/anthropometric_form.php');?>
                                </div>
                            </div>
                            <div class="anketa_block_item">
                                <div class="anketa_block_item_h">Физические параметры</div>
                                <div class="anketa_block_item_cont">
                                    <form action="" class="anketa_form" method="post">
                                        <div class="anketa_form_line parent">
                                            <div class="anketa_form_h"><div class="anketa_form_h_cell">Пол</div></div>
                                            <div class="anketa_form_radio_all parent">
                                                <div class="anketa_form_radio_wrap">
                                                    <input type="radio" name="gender" class="anketa_form_radio" value="0"
                                                        <?php if($user_gender == 'male'):?> checked="checked" <?php endif;?> id="gender_male">
                                                    <label for="gender_male">Мужской</label>
                                                </div>
                                                <div class="anketa_form_radio_wrap">
                                                    <input type="radio" name="gender" class="anketa_form_radio" value="1"
                                                        <?php if($user_gender == 'female'):?> checked="checked" <?php endif;?> id="gender_female">
                                                    <label for="gender_female">Женский</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="anketa_form_line parent">
                                            <div class="anketa_form_h"><div class="anketa_form_h_cell">Дата рождения</div></div>
                                            <div class="anketa_form_three_all parent">
                                                <div class="anketa_form_three_wrap">
                                                    <input type="hidden" name="birthday" id="birthday" value="<?php if(!empty($user_birthday)){echo $user_birthday;}?>"/>
                                                    <select name="b_day" class="anketa_form_select">
                                                        <option value="">День</option>
                                                        <option value="01"
                                                            <?php if ($user_b_day == 1) :?> selected="selected" <?php endif;?>>1</option>
                                                        <option value="02"
                                                            <?php if ($user_b_day == 2) :?> selected="selected" <?php endif;?>>2</option>
                                                        <option value="03"
                                                            <?php if ($user_b_day == 3) :?> selected="selected" <?php endif;?>>3</option>
                                                        <option value="04"
                                                            <?php if ($user_b_day == 4) :?> selected="selected" <?php endif;?>>4</option>
                                                        <option value="05"
                                                            <?php if ($user_b_day == 5) :?> selected="selected" <?php endif;?>>5</option>
                                                        <option value="06"
                                                            <?php if ($user_b_day == 6) :?> selected="selected" <?php endif;?>>6</option>
                                                        <option value="07"
                                                            <?php if ($user_b_day == 7) :?> selected="selected" <?php endif;?>>7</option>
                                                        <option value="08"
                                                            <?php if ($user_b_day == 8) :?> selected="selected" <?php endif;?>>8</option>
                                                        <option value="09"
                                                            <?php if ($user_b_day == 9) :?> selected="selected" <?php endif;?>>9</option>
                                                        <option value="10"
                                                            <?php if ($user_b_day == 10) :?> selected="selected" <?php endif;?>>10</option>
                                                        <option value="11"
                                                            <?php if ($user_b_day == 11) :?> selected="selected" <?php endif;?>>11</option>
                                                        <option value="12"
                                                            <?php if ($user_b_day == 12) :?> selected="selected" <?php endif;?>>12</option>
                                                        <option value="13"
                                                            <?php if ($user_b_day == 13) :?> selected="selected" <?php endif;?>>13</option>
                                                        <option value="14"
                                                            <?php if ($user_b_day == 14) :?> selected="selected" <?php endif;?>>14</option>
                                                        <option value="15"
                                                            <?php if ($user_b_day == 15) :?> selected="selected" <?php endif;?>>15</option>
                                                        <option value="16"
                                                            <?php if ($user_b_day == 16) :?> selected="selected" <?php endif;?>>16</option>
                                                        <option value="17"
                                                            <?php if ($user_b_day == 17) :?> selected="selected" <?php endif;?>>17</option>
                                                        <option value="18"
                                                            <?php if ($user_b_day == 18) :?> selected="selected" <?php endif;?>>18</option>
                                                        <option value="19"
                                                            <?php if ($user_b_day == 19) :?> selected="selected" <?php endif;?>>19</option>
                                                        <option value="20"
                                                            <?php if ($user_b_day == 20) :?> selected="selected" <?php endif;?>>20</option>
                                                        <option value="21"
                                                            <?php if ($user_b_day == 21) :?> selected="selected" <?php endif;?>>21</option>
                                                        <option value="22"
                                                            <?php if ($user_b_day == 22) :?> selected="selected" <?php endif;?>>22</option>
                                                        <option value="23"
                                                            <?php if ($user_b_day == 23) :?> selected="selected" <?php endif;?>>23</option>
                                                        <option value="24"
                                                            <?php if ($user_b_day == 24) :?> selected="selected" <?php endif;?>>24</option>
                                                        <option value="25"
                                                            <?php if ($user_b_day == 25) :?> selected="selected" <?php endif;?>>25</option>
                                                        <option value="26"
                                                            <?php if ($user_b_day == 26) :?> selected="selected" <?php endif;?>>26</option>
                                                        <option value="27"
                                                            <?php if ($user_b_day == 27) :?> selected="selected" <?php endif;?>>27</option>
                                                        <option value="28"
                                                            <?php if ($user_b_day == 28) :?> selected="selected" <?php endif;?>>28</option>
                                                        <option value="29"
                                                            <?php if ($user_b_day == 29) :?> selected="selected" <?php endif;?>>29</option>
                                                        <option value="30"
                                                            <?php if ($user_b_day == 30) :?> selected="selected" <?php endif;?>>30</option>
                                                        <option value="31"
                                                            <?php if ($user_b_day == 31) :?> selected="selected" <?php endif;?>>31</option>
                                                    </select>
                                                </div>
                                                <div class="anketa_form_three_wrap">
                                                    <select name="b_mon" class="anketa_form_select">
                                                        <option value="">Месяц</option>
                                                        <option value="01"
                                                            <?php if ($user_b_mon == 1) :?> selected="selected" <?php endif;?>>Январь</option>
                                                        <option value="02"
                                                            <?php if ($user_b_mon == 2) :?> selected="selected" <?php endif;?>>Февраль</option>
                                                        <option value="03"
                                                            <?php if ($user_b_mon == 3) :?> selected="selected" <?php endif;?>>Март</option>
                                                        <option value="04"
                                                            <?php if ($user_b_mon == 4) :?> selected="selected" <?php endif;?>>Апрель</option>
                                                        <option value="05"
                                                            <?php if ($user_b_mon == 5) :?> selected="selected" <?php endif;?>>Май</option>
                                                        <option value="06"
                                                            <?php if ($user_b_mon == 6) :?> selected="selected" <?php endif;?>>Июнь</option>
                                                        <option value="07"
                                                            <?php if ($user_b_mon == 7) :?> selected="selected" <?php endif;?>>Июль</option>
                                                        <option value="08"
                                                            <?php if ($user_b_mon == 8) :?> selected="selected" <?php endif;?>>Август</option>
                                                        <option value="09"
                                                            <?php if ($user_b_mon == 9) :?> selected="selected" <?php endif;?>>Сентябрь</option>
                                                        <option value="10"
                                                            <?php if ($user_b_mon == 10) :?> selected="selected" <?php endif;?>>Октябрь</option>
                                                        <option value="11"
                                                            <?php if ($user_b_mon == 11) :?> selected="selected" <?php endif;?>>Ноябрь</option>
                                                        <option value="12"
                                                            <?php if ($user_b_mon == 12) :?> selected="selected" <?php endif;?>>Декабрь</option>
                                                    </select>
                                                </div>
                                                <div class="anketa_form_three_wrap">
                                                    <select name="b_year" class="anketa_form_select">
                                                        <option value="">Год</option>
                                                        <option value="1980"
                                                            <?php if ($user_b_year == 1980) :?> selected="selected" <?php endif;?>>1980</option>
                                                        <option value="1981"
                                                            <?php if ($user_b_year == 1981) :?> selected="selected" <?php endif;?>>1981</option>
                                                        <option value="1982"
                                                            <?php if ($user_b_year == 1982) :?> selected="selected" <?php endif;?>>1982</option>
                                                        <option value="1983"
                                                            <?php if ($user_b_year == 1983) :?> selected="selected" <?php endif;?>>1983</option>
                                                        <option value="1984"
                                                            <?php if ($user_b_year == 1984) :?> selected="selected" <?php endif;?>>1984</option>
                                                        <option value="1985"
                                                            <?php if ($user_b_year == 1985) :?> selected="selected" <?php endif;?>>1985</option>
                                                        <option value="1986"
                                                            <?php if ($user_b_year == 1986) :?> selected="selected" <?php endif;?>>1986</option>
                                                        <option value="1987"
                                                            <?php if ($user_b_year == 1987) :?> selected="selected" <?php endif;?>>1987</option>
                                                        <option value="1988"
                                                            <?php if ($user_b_year == 1988) :?> selected="selected" <?php endif;?>>1988</option>
                                                        <option value="1989"
                                                            <?php if ($user_b_year == 1989) :?> selected="selected" <?php endif;?>>1989</option>
                                                        <option value="1990"
                                                            <?php if ($user_b_year == 1990) :?> selected="selected" <?php endif;?>>1990</option>
                                                        <option value="1991"
                                                            <?php if ($user_b_year == 1991) :?> selected="selected" <?php endif;?>>1991</option>
                                                        <option value="1992"
                                                            <?php if ($user_b_year == 1992) :?> selected="selected" <?php endif;?>>1992</option>
                                                        <option value="1993"
                                                            <?php if ($user_b_year == 1993) :?> selected="selected" <?php endif;?>>1993</option>
                                                        <option value="1994"
                                                            <?php if ($user_b_year == 1994) :?> selected="selected" <?php endif;?>>1994</option>
                                                        <option value="1995"
                                                            <?php if ($user_b_year == 1995) :?> selected="selected" <?php endif;?>>1995</option>
                                                        <option value="1996"
                                                            <?php if ($user_b_year == 1996) :?> selected="selected" <?php endif;?>>1996</option>
                                                        <option value="1997"
                                                            <?php if ($user_b_year == 1997) :?> selected="selected" <?php endif;?>>1997</option>
                                                        <option value="1998"
                                                            <?php if ($user_b_year == 1998) :?> selected="selected" <?php endif;?>>1998</option>
                                                        <option value="1998"
                                                            <?php if ($user_b_year == 1999) :?> selected="selected" <?php endif;?>>1999</option>
                                                        <option value="2000"
                                                            <?php if ($user_b_year == 2000) :?> selected="selected" <?php endif;?>>2000</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="anketa_form_line parent">
                                            <div class="anketa_form_h"><div class="anketa_form_h_cell">Рост</div></div>
                                            <input type="text" class="anketa_form_in anketa_form_in_long" placeholder="Рост" name="height" value="<?php echo $user_height?>" maxlength="3" id="height"/>
                                            <div class="anketa_form_desk">см</div>
                                        </div>
                                        <div class="anketa_form_line parent">
                                            <div class="anketa_form_h"><div class="anketa_form_h_cell">Вес</div></div>
                                            <input type="text" class="anketa_form_in anketa_form_in_long" placeholder="Вес" name="weight" value="<?php echo $user_weight?>" maxlength="5" id="weight"/>
                                            <div class="anketa_form_desk">кг</div>
                                        </div>
                                        <div class="anketa_form_info parent">
                                            <div class="anketa_form_info_h">результаты</div>
                                            <div class="anketa_form_info_cont">
                                                <div class="anketa_form_info_line">
                                                    <span class="anketa_form_info_line_h">Индекс массы тела:</span>
                                                    <span class="anketa_form_info_txt">
                                                        <input type="hidden" name="bmi" value="<?php echo $user_bmi?>" id="bmi" maxlength="5"/>
														<span class="anketa_form_info_val" id="span_bmi"><?php echo $user_bmi?></span>
														<span class="anketa_form_info_desk" id="span_bmi_txt"><?php echo $user_bmi_txt?></span>
													</span>
                                                </div>
                                                <div class="anketa_form_info_line">
                                                    <span class="anketa_form_info_line_h">Базальная скорость метаболизма:</span>
                                                    <span class="anketa_form_info_txt">
                                                        <input type="hidden" name="bmr" value="<?php echo $user_bmr?>" id="bmr"/>
														<span class="anketa_form_info_val" id="span_bmr"><?php echo $user_bmr?></span>
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
                            <div class="anketa_block_item">
                                <div class="anketa_block_item_h">Физическое состояние</div>
                                <div class="anketa_block_item_cont">
                                    <form action="" class="anketa_form" method="post">
                                        <div class="anketa_form_line parent">
                                            <div class="anketa_form_h"><div class="anketa_form_h_cell">Оценка физического состояния</div></div>
                                            <div class="anketa_form_one_wrap anketa_form_three_wrap">
                                                <select name="physical_condition" class="anketa_form_select">
                                                    <option>Выберите уровень</option>
                                                    <option value="0"
                                                        <?php if ($user_physical_condition == 0) :?> selected="selected" <?php endif;?>>Хорошее</option>
                                                    <option value="1"
                                                        <?php if ($user_physical_condition == 1) :?> selected="selected" <?php endif;?>>Среднее</option>
                                                    <option value="2"
                                                        <?php if ($user_physical_condition == 2) :?> selected="selected" <?php endif;?>>Плохое</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="anketa_form_line parent">
                                            <div class="anketa_form_h"><div class="anketa_form_h_cell">Пульс в покое</div></div>
                                            <input type="text"  name="pulse" value="<?php echo $user_pulse;?>" class="anketa_form_in anketa_form_in_long" placeholder="60">
                                        </div>
                                        <div class="anketa_form_line parent">
                                            <div class="anketa_form_h"><div class="anketa_form_h_cell">Цель занятий</div></div>
                                            <div class="anketa_form_one_wrap anketa_form_three_wrap">
                                                <select name="training_goal" class="anketa_form_select">
                                                    <option>Выберите цель</option>
                                                    <option value="1"
                                                        <?php if ($user_training_goal == 1) :?> selected="selected" <?php endif;?>>Сбросить лишний вес</option>
                                                    <option value="1"
                                                        <?php if ($user_training_goal == 2) :?> selected="selected" <?php endif;?>>Набор мышечной массы</option>
                                                    <option value="1"
                                                        <?php if ($user_training_goal == 3) :?> selected="selected" <?php endif;?>>Общий тонус</option>
                                                    <option value="1"
                                                        <?php if ($user_training_goal == 4) :?> selected="selected" <?php endif;?>>Общее оздоровление</option>
                                                    <option value="1"
                                                        <?php if ($user_training_goal == 5) :?> selected="selected" <?php endif;?>>Развить выносливость</option>
                                                    <option value="1"
                                                        <?php if ($user_training_goal == 6) :?> selected="selected" <?php endif;?>>Развить силу</option>
                                                    <option value="1"
                                                        <?php if ($user_training_goal == 7) :?> selected="selected" <?php endif;?>>Развить гибкость</option>
                                                    <option value="1"
                                                        <?php if ($user_training_goal == 8) :?> selected="selected" <?php endif;?>>Укрепить сердце</option>
                                                    <option value="1"
                                                        <?php if ($user_training_goal == 9) :?> selected="selected" <?php endif;?>>Накачать ягодицы</option>
                                                    <option value="1"
                                                        <?php if ($user_training_goal == 10) :?> selected="selected" <?php endif;?>>Накачать пресс</option>
                                                    <option value="1"
                                                        <?php if ($user_training_goal == 11) :?> selected="selected" <?php endif;?>>Реабилитация после родов</option>
                                                    <option value="1"
                                                        <?php if ($user_training_goal == 12) :?> selected="selected" <?php endif;?>>Курс омоложения</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="anketa_form_line parent">
                                            <div class="anketa_form_h"><div class="anketa_form_h_cell">История тренировок или занятий спортом</div></div>
                                            <textarea name="sports_history" class="anketa_form_in anketa_form_in_long" placeholder="Введите историю"><?php echo $user_sports_history?></textarea>
                                        </div>
                                        <div class="anketa_form_line parent">
                                            <div class="anketa_form_h"><div class="anketa_form_h_cell">Перечень травм или заболеваний</div></div>
                                            <textarea name="injuries_diseases" class="anketa_form_in anketa_form_in_long" placeholder="Введите перечень"><?php echo $user_injuries_diseases?></textarea>
                                        </div>
                                        <div class="anketa_form_line parent">
                                            <div class="anketa_form_h"><div class="anketa_form_h_cell">Вредные привычки</div></div>
                                            <textarea name="bad_habits" class="anketa_form_in anketa_form_in_long" placeholder="Введите привычки"><?php echo $user_bad_habits?></textarea>
                                        </div>
                                        <div class="anketa_form_buts_wrap parent">
                                            <!--<input type="reset" value="Отмена" class="anketa_form_reset">-->
                                            <input type="submit" name="bt_save_physical_condition" value="Сохранить" class="anketa_form_but defaultActionButton">
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="anketa_block_item">
                                <div class="anketa_block_item_h">Режим дня</div>
                                <div class="anketa_block_item_cont">
                                    <form action="" class="anketa_form" method="post">
                                        <div class="anketa_form_line parent">
                                            <div class="anketa_form_h"><div class="anketa_form_h_cell">Время бодрствования</div></div>
                                            <div class="anketa_form_two_all parent">
                                                <div class="anketa_form_two_wrap parent">
                                                    <div class="anketa_form_pre">c</div>
                                                    <input type="text" name="waking_from" value="<?php echo $user_waking_from;?>" class="anketa_form_in" placeholder="10:00"/>
                                                </div>
                                                <div class="anketa_form_two_wrap parent">
                                                    <div class="anketa_form_pre">до</div>
                                                    <input type="text" name="waking_to" value="<?php echo $user_waking_to;?>" class="anketa_form_in" placeholder="10:00"/>
                                                </div>
                                            </div>
                                            <div class="anketa_form_desk">часов</div>
                                        </div>
                                        <div class="anketa_form_line parent">
                                            <div class="anketa_form_h"><div class="anketa_form_h_cell">Предпочтительное время тренировки</div></div>
                                            <div class="anketa_form_two_all parent">
                                                <div class="anketa_form_two_wrap parent">
                                                    <div class="anketa_form_pre">c</div>
                                                    <input type="text" name="training_time_from" value="<?php echo $user_training_time_from;?>" class="anketa_form_in" placeholder="10:00"/>
                                                </div>
                                                <div class="anketa_form_two_wrap parent">
                                                    <div class="anketa_form_pre">до</div>
                                                    <input type="text" name="training_time_to" value="<?php echo $user_training_time_to;?>" class="anketa_form_in" placeholder="10:00"/>
                                                </div>
                                            </div>
                                            <div class="anketa_form_desk">часов</div>
                                        </div>
                                        <div class="anketa_form_line parent">
                                            <div class="anketa_form_h"><div class="anketa_form_h_cell">Количество основных приемов пищи</div></div>
                                            <input type="text"  name="num_main_meals" value="<?php echo $user_num_main_meals?>" class="anketa_form_in" placeholder="3"/>
                                            <div class="anketa_form_desk">шт</div>
                                        </div>
                                        <div class="anketa_form_line parent">
                                            <div class="anketa_form_h"><div class="anketa_form_h_cell">Количество перекусов</div></div>
                                            <input type="text" name="num_snacks" value="<?php echo $user_num_snacks?>" class="anketa_form_in" placeholder="2">
                                            <div class="anketa_form_desk">шт</div>
                                        </div>
                                        <div class="anketa_form_line parent">
                                            <div class="anketa_form_h"><div class="anketa_form_h_cell">Количество потребляемой воды</div></div>
                                            <input type="text" name="amount_water_consumed" value="<?php echo $user_water_consumed?>" class="anketa_form_in" placeholder="2"/>
                                            <div class="anketa_form_desk">л</div>
                                        </div>
                                        <div class="anketa_form_line parent">
                                            <div class="anketa_form_h"><div class="anketa_form_h_cell">Количество потребляемой жидкости<span>суп, чай, кофе, соки</span></div></div>
                                            <input type="text" name="amount_fluid_intake" value="<?php echo $user_fluid_intake?>" class="anketa_form_in" placeholder="1"/>
                                            <div class="anketa_form_desk">л</div>
                                        </div>
                                        <div class="anketa_form_buts_wrap parent">
                                            <!--<input type="reset" value="Отмена" class="anketa_form_reset">-->
                                            <input type="submit" name="bt_save_daily_regime" value="Сохранить" class="anketa_form_but defaultActionButton">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- content_col -->
    </div>
</div><!-- content -->