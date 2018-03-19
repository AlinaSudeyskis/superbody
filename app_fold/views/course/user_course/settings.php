<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php include_once('./app_fold/views/course/user_course/page_part/header.php');?>
    <div class="anketa_block">
        <div class="anketa_block_cont">
            <div class="anketa_block_item">
                <div class="anketa_block_item_h"><?php echo $course['description']; ?></div>
                <div class="anketa_block_item_cont">
                    <form action="" method="post" class="anketa_form">
                        <div class="anketa_form_line parent">
                            <div class="anketa_form_h"><div class="anketa_form_h_cell">Длительность курса:</div></div>
                            <div class="anketa_form_h"><div class="anketa_form_h_cell"><?php if (!empty($course['count_weeks'])) { echo $course['count_weeks']; }?></div></div>
                            <input type="hidden" name="count_weeks" id="count_weeks" value="<?php if (!empty($course['count_weeks'])) { echo $course['count_weeks']; }?>" />
                            <input type="hidden" name="count_days" id="count_days" value="<?php if (!empty($course['count_days'])) { echo $course['count_days']; }?>" />
                            <input type="hidden" name="count_rest" id="count_rest" value="<?php if (!empty($course['count_rest'])) { echo $course['count_rest']; }?>" />
                            <div class="anketa_form_desk">нед.</div>
                        </div>
                        <div class="anketa_form_line parent">
                            <div class="anketa_form_h"><div class="anketa_form_h_cell">Количество тренировок:</div></div>
                            <div class="anketa_form_h"><div class="anketa_form_h_cell"><?php if (!empty($course['count_days'])) { echo $course['count_days']; }?></div></div>
                            <div class="anketa_form_desk"> дн./нед.</div>
                        </div>
                        <div class="anketa_form_line parent">
                            <div class="anketa_form_h"><div class="anketa_form_h_cell">Старт курса:</div></div>
                            <div class="anketa_form_h">
                                <div class="anketa_form_h_cell">
                                    <?php if (!empty($course['date_start'])) :?>
                                        <?= $course['date_start'];?>
                                    <?php else :?>
                                        <div style="color:#b3b3b3;">Выберите тренировочные дни</div>
                                    <?php endif;?>
                                </div>
                            </div>
                        </div>
                        <?php if (!empty($course['date_end'])):?>
                            <div class="anketa_form_line parent">
                                <div class="anketa_form_h"><div class="anketa_form_h_cell">Окончание курса:</div></div>
                                <div class="anketa_form_h"><div class="anketa_form_h_cell"><?php echo $course['date_end']; ?></div></div>
                            </div>
                        <?php endif;
                        $days_disabled = !empty($course['days']) ? 'disabled' : '';?>
                        <div class="anketa_form_line parent">
                            <div class="anketa_form_h"><div class="anketa_form_h_cell">Тренировочные дни:</div></div>
                            <div class="anketa_form_radio_all parent <?php echo $days_disabled; ?>" id="week_days">
                                <div class="anketa_form_radio_wrap cb_week_day">
                                    <input type="checkbox" name="cb_day[]" value="1" id="cb_monday" class="anketa_form_radio"
                                           <?php if (!empty($course['days']) and in_array(1, $course['days'])) :?>checked="checked"
                                           <?php elseif(!empty($course['days'])) :?>disabled<?php endif;?>
                                    /><label for="cb_monday">Пн.</label>
                                </div>
                                <div class="anketa_form_radio_wrap cb_week_day">
                                    <input type="checkbox" name="cb_day[]" value="2" id="cb_tuesday" class="anketa_form_radio"
                                           <?php if (!empty($course['days']) and in_array(2, $course['days'])) :?>checked="checked"
                                           <?php elseif(!empty($course['days'])) :?>disabled<?php endif;?>
                                    /><label for="cb_tuesday">Вт.</label>
                                </div>
                                <div class="anketa_form_radio_wrap cb_week_day">
                                    <input type="checkbox" name="cb_day[]" value="3" id="cb_wednesday" class="anketa_form_radio"
                                           <?php if (!empty($course['days']) and in_array(3, $course['days'])) :?>checked="checked"
                                           <?php elseif(!empty($course['days'])) :?>disabled<?php endif;?>
                                    /><label for="cb_wednesday">Ср.</label>
                                </div>
                                <div class="anketa_form_radio_wrap cb_week_day">
                                    <input type="checkbox" name="cb_day[]" value="4" id="cb_thursday" class="anketa_form_radio"
                                           <?php if (!empty($course['days']) and !empty($course['days']) and in_array(4, $course['days'])) :?>checked="checked"
                                           <?php elseif(!empty($course['days'])) :?>disabled<?php endif;?>
                                    /><label for="cb_thursday">Чт.</label>
                                </div>
                                <div class="anketa_form_radio_wrap cb_week_day">
                                    <input type="checkbox" name="cb_day[]" value="5" id="cb_friday" class="anketa_form_radio"
                                           <?php if (!empty($course['days']) and in_array(5, $course['days'])) :?>checked="checked"
                                           <?php elseif(!empty($course['days'])) :?>disabled<?php endif;?>
                                    /><label for="cb_friday">Пт.</label>
                                </div>
                                <div class="anketa_form_radio_wrap cb_week_day">
                                    <input type="checkbox" name="cb_day[]" value="6" id="cb_saturday" class="anketa_form_radio"
                                           <?php if (!empty($course['days']) and in_array(6, $course['days'])) :?>checked="checked"
                                           <?php elseif(!empty($course['days'])) :?>disabled<?php endif;?>
                                    /><label for="cb_saturday">Сб.</label>
                                </div>
                                <div class="anketa_form_radio_wrap cb_week_day">
                                    <input type="checkbox" name="cb_day[]" value="7" id="cb_sunday" class="anketa_form_radio"
                                           <?php if (!empty($course['days']) and in_array(7, $course['days'])) :?>checked="checked"
                                           <?php elseif(!empty($course['days'])) :?>disabled<?php endif;?>
                                    /><label for="cb_sunday">Вс.</label>
                                </div>
                            </div>
                        </div>
                        <?php if (!empty($course['couches'])) :?>
                            <div class="anketa_form_line parent">
                                <div class="anketa_form_h"><div class="anketa_form_h_cell">Тренеры:</div></div>
                                <div class="anketa_form_radio_all parent">
                                    <!--<input type="hidden" name="user_couch" value="<?php /*echo $course['couch_id']*/?>" id="user-couch-id"/>-->
                                    <?php foreach($course['couches'] as $key => $couch) :?>
                                        <div class="anketa_form_radio_wrap">
                                            <input type="radio" name="user_couch" value="<?php echo $couch['id']; ?>" id="cb_couch<?php echo $course['couch_id']; ?>" class="anketa_form_radio long"
                                                   <?php if ($course['couch_id'] == $couch['id']) :?>checked="checked"<?php endif;?>
                                            /><label for="cb_couch<?php echo $course['couch_id']; ?>"><?php echo $couch['name']; ?></label>
                                        </div>
                                    <?php endforeach;
                                    unset($couch);?>
                                </div>
                            </div>
                        <?php endif;
                        if (!empty($course['days'])):
                            if ($course['paused'] == 0) :?>
                                <div class="anketa_form_line parent">
                                    <div class="anketa_form_h"><div class="anketa_form_h_cell">Заморозить курс до:</div></div>
                                    <div class="anketa_form_h"><div class="anketa_form_h_cell">
                                        <input type="date" name="date_pause_to" min="<?php echo $calendar_min_date;?>" max="<?php echo $calendar_max_date;?>"/>
                                    </div></div>
                                    <div class="anketa_form_desk">
                                        Минимальная заморозка курса 7 дней. Вы можете заморозить курс минимум до <?php echo $string_min_date;?>
                                    </div>
                                </div>
                            <?php endif;
                            if (!empty($course['date_last_missed'])) :?>
                                <div class="anketa_form_line parent">
                                    <div class="anketa_form_h"><div class="anketa_form_h_cell">Последнее пропущенное занятие:</div></div>
                                    <div class="anketa_form_h"><div class="anketa_form_h_cell"><?php echo $course['date_last_missed']; ?></div></div>
                                </div>
                            <?php endif;
                            if (!empty($course['workouts_missed'])) :?>
                                <div class="anketa_form_line parent">
                                    <div class="anketa_form_h"><div class="anketa_form_h_cell">Количество пропущенных занятий:</div></div>
                                    <div class="anketa_form_h"><div class="anketa_form_h_cell"><?php echo $course['workouts_missed']; ?></div></div>
                                </div>
                            <?php endif; ?>
                            <div class="anketa_form_line parent">
                                <div class="anketa_form_h"><div class="anketa_form_h_cell">Пройдено курса:</div></div>
                                <div class="anketa_form_h"><div class="anketa_form_h_cell">
                                    <?php if (!empty($course['workouts_passed'])) :
                                        echo round(($course['workouts_passed']*100)/($course['count_weeks']*$course['count_days'])).'%';
                                    else :
                                        echo '0%';
                                    endif; ?>
                                </div></div>
                            </div>
                        <?php endif;?>
                        <div class="anketa_form_buts_wrap parent">
                            <?php if ($course['paused'] == 1):?>
                                <input type="submit" name="bt_unblock_course" class="anketa_form_reset" value="Разморозить"/>
                            <?php endif;?>
                            <input type="submit" name="bt_save_course" value="Сохранить" class="anketa_form_but" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php include_once('./app_fold/views/course/user_course/page_part/footer.php');?>