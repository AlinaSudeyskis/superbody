<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php include_once('./app_fold/views/course/user_course/page_part/header.php');?>
<?php if(!empty($course)):?>
    <div class="anketa_block">
        <div class="anketa_block_cont">
            <div class="anketa_block_item">
                <div class="anketa_block_item_h"><?php echo $course['description']; ?></div>
                <div class="anketa_block_item_cont">
                    <form action="" method="post" class="anketa_form">
                        <div class="anketa_form_line parent">
                            <div class="anketa_form_h"><div class="anketa_form_h_cell">Длительность курса:</div></div>
                            <div class="anketa_form_h"><div class="anketa_form_h_cell"><?php if (!empty($course['count_weeks'])) { echo $course['count_weeks']; }?></div></div>
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
                        if($course['paused'] == 1): ?>
                            <div class="anketa_form_line parent">
                                <div class="anketa_form_h"><div class="anketa_form_h_cell">Курс заморожен:</div></div>
                                <div class="anketa_form_h"><div class="anketa_form_h_cell">до <b><?php echo $course['pause_end'];?></b></div></div>
                                <?php if ($course['blocked'] == 0 and $course['finished'] === false):?>
                                    <div class="anketa_form_desk"><input type="submit" name="bt_unblock_course" class="admin_form_reset" value="Разморозить" style="margin-left:0;"/></div>
                                <?php endif; ?>
                            </div>
                        <?php endif;
                        $days_disabled = ($course['blocked'] == 1 or $course['paused'] == 1) ? 'disabled' : '';
                        if($course['category'] == 'workout'):?>
                            <div class="anketa_form_line parent">
                                <div class="anketa_form_h"><div class="anketa_form_h_cell">Тренировочные дни:</div></div>
                                <?php include('./app_fold/views/course/week_days_item.php'); ?>
                            </div>
                            <?php if($course['paused'] == 1): ?>
                                <h3 class="info info_week_days">* Изменить выбранные тренировочные дни можно будет по окончанию заморозки курса.</h3>
                            <?php endif; ?>
                            <?php //$time_disabled = (!empty($course['training_time']) or $course['blocked'] == 1) ? 'disabled' : '';
                            $uc_set = true; ?>
                            <div class="anketa_form_line parent">
                                <div class="anketa_form_h"><div class="anketa_form_h_cell">Время тренировок:</div></div>
                                <?php include('./app_fold/views/course/week_days_time_item.php'); ?>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($course['coaches'])) :?>
                            <div class="anketa_form_line parent">
                                <div class="anketa_form_h"><div class="anketa_form_h_cell">Тренеры:</div></div>
                                <div class="anketa_form_radio_all parent <?php echo $days_disabled; ?>">
                                    <!--<input type="hidden" name="user_coach" value="<?php /*echo $course['coach_id']*/?>" id="user-coach-id"/>-->
                                    <?php foreach($course['coaches'] as $key => $coach) :?>
                                        <div class="anketa_form_radio_wrap">
                                            <input type="radio" name="user_coach" value="<?php echo $coach['id']; ?>" id="cb_coach<?php echo $course['coach_id']; ?>" class="anketa_form_radio long"
                                                   <?php if ($course['coach_id'] == $coach['id']) :?>checked="checked"<?php endif;?>
                                            /><label for="cb_coach<?php echo $course['coach_id']; ?>"><?php echo $coach['name']; ?></label>
                                        </div>
                                    <?php endforeach;
                                    unset($coach);?>
                                </div>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($course['days'])):
                            if ($course['paused'] == 0 and $course['blocked'] == 0 and $course['finished'] === false) :?>
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
                                        echo ceil(($course['workouts_passed']*100)/($course['count_weeks']*$course['count_days'])).'%';
                                    else :
                                        echo '0%';
                                    endif; ?>
                                </div></div>
                            </div>
                        <?php endif;
                        if($course['blocked'] == 1 and $course['blocked_buy'] === true and $course['residual_value'] > 0): ?>
                            <div class="anketa_form_line parent">
                                <div class="anketa_form_h"><div class="anketa_form_h_cell">Остаточная стоимость:</div></div>
                                <div class="anketa_form_h"><div class="anketa_form_h_cell"><?php if (!empty($course['residual_value'])) { echo $course['residual_value']; }?></div></div>
                                <div class="anketa_form_desk"> руб.</div>
                            </div>
                            <div class="anketa_form_line parent">
                                <div class="anketa_form_h"><div class="anketa_form_h_cell"></div></div>
                                <div class="anketa_form_h"><div class="anketa_form_h_cell">
                                        <input type="submit" name="bt_buy_residual_course" value="Оплатить" class="anketa_form_but" />
                                </div></div>
                            </div>
                        <?php endif;
                        if(!empty($course['attached_courses']) and $course['blocked'] == 0):?>
                            <div class="notification_block_ext_wrap_h">Выберите курс:</div>
                            <div class="notification_block_ext_wrap">
                                <?php foreach($course['attached_courses'] as $attached):?>
                                    <div class="notification_block_ext">
                                        <div class="notification_block_ext_h"><a href="/course/<?php echo $attached['course_id']; ?>"><?php echo $attached['name']; ?></a></div>
                                        <div class="notification_block_ext_title">
                                            <input type="submit" name="bt_choose_attach[<?php echo $attached['course_id']; ?>]" value="Выбрать" class="video_admin_form_send" />
                                        </div>
                                    </div>
                                <?php endforeach;
                                unset($attached);?>
                            </div>
                        <?php endif; ?>
                        <div class="anketa_form_line parent">
                            <div class="video_admin_form_buts parent">
                                <?php if ($course['blocked'] == 0 and $course['finished'] === false):?>
                                    <input type="submit" name="bt_save_course" value="Сохранить" class="video_admin_form_send defaultActionButton" />
                                <?php endif;?>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php else: ?>
    <h3 class="info">Информация не найдена</h3>
<?php endif; ?>
<?php include_once('./app_fold/views/course/user_course/page_part/footer.php');?>