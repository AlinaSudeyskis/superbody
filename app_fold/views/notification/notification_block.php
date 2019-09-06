<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="notification_block">
    <?php // Ссылка
    if(!empty($notif_block_h)): ?>
        <div class="notification_block_h"><?php echo $notif_block_h; ?></div>
    <?php endif;

    // Уведомление
    if(!empty($h3_info)): ?>
        <h3 class="info"><?php echo $h3_info; ?></h3>
    <?php else:
        if($course_blocked === true and !empty($course_blocked_info)):?>
            <h3 class="info"><?php echo $course_blocked_info; ?></h3>
        <?php endif;
        if($course_ends === true and !empty($course_ends_info)):?>
            <h3 class="info"><?php echo $course_ends_info; ?></h3>
        <?php endif;
        if($course_finished === true and !empty($course_finished_info)):?>
            <h3 class="info"><?php echo $course_finished_info; ?></h3>
            <a href="#" class="add_tab_but fix_width buy_course" data-cid="<?php echo $notif['course_id']; ?>">Купить снова</a>
        <?php endif;
        if($workout_missed === true and !empty($workout_missed_info)):?>
            <h3 class="info"><?php echo $workout_missed_info; ?></h3>
        <?php endif;
        if($non_started === true and !empty($non_started_info)): // and !empty($non_started_courses)?>
            <h3 class="info"><?php echo $non_started_info; ?></h3>
        <?php endif;
        if($free_weeks_over === true and !empty($free_weeks_over_info)): ?>
            <h3 class="info"><?php echo $free_weeks_over_info; ?></h3>
            <a href="#" class="add_tab_but fix_width buy_course" data-cid="<?php echo $notif['course_id']; ?>" data-oid="<?php echo $notif['free_weeks_over']['order_id']; ?>">Оплатить</a>
        <?php endif;
    endif;

    // Отсчет времени окончания курса
    if($course_ends === true and $count_ends_down === true and !empty($course_ends_countdown)):?>
        <div class="countdown_wrap">
            <input type="hidden" value="<?php echo $course_ends_countdown; ?>" class="date_countdown"/>
            <div class="countdown"></div>
        </div>
    <?php endif;

    // Курсы продления
    if($course_finished === true and !empty($course_finished_extends)):?>
        <div class="notification_block_ext_wrap_h">Продлите курс или купите новый:</div>
        <div class="notification_block_ext_wrap">
            <?php foreach($course_finished_extends as $extend):?>
                <div class="notification_block_ext">
                    <div class="notification_block_ext_h"><a href="/course/<?php echo $extend['course_id']; ?>"><?php echo $extend['course_name']; ?></a></div>
                    <div class="notification_block_ext_title"><?php echo $extend['promocode']; ?></div>
                    <div class="notification_block_ext_title">
                        <?php if(!empty($extend['new_price'])): ?>
                            <s><?php echo $extend['price']; ?> руб.</s> <?php echo $extend['new_price']; ?> руб.
                        <?php else: ?>
                            <?php echo $extend['price']; ?> руб.
                        <?php endif; ?>
                    </div>
                    <div class="notification_block_ext_countdown">
                        <input type="hidden" value="<?php echo $extend['date_countdown']; ?>" class="date_countdown"/>
                        <div class="countdown"></div>
                    </div>
                </div>
            <?php endforeach;
            unset($extend);?>
        </div>
    <?php endif;

    // Курсы продления
    if($course_ends === true and !empty($course_ends_extends)):?>
        <div class="notification_block_ext_wrap_h">Продлите курс или купите новый:</div>
        <div class="notification_block_ext_wrap">
            <?php foreach($course_ends_extends as $extend):?>
                <div class="notification_block_ext">
                    <div class="notification_block_ext_h"><a href="/course/<?php echo $extend['course_id']; ?>"><?php echo $extend['course_name']; ?></a></div>
                    <div class="notification_block_ext_title"><?php echo $extend['promocode']; ?></div>
                    <div class="notification_block_ext_title">
                        <?php if(!empty($extend['new_price'])): ?>
                            <s><?php echo $extend['price']; ?> руб.</s> <?php echo $extend['new_price']; ?> руб.
                        <?php else: ?>
                            <?php echo $extend['price']; ?> руб.
                        <?php endif; ?>
                    </div>
                    <div class="notification_block_ext_countdown">
                        <input type="hidden" value="<?php echo $extend['date_countdown']; ?>" class="date_countdown"/>
                        <div class="countdown"></div>
                    </div>
                </div>
            <?php endforeach;
            unset($extend);?>
        </div>
    <?php endif;

    // Неначатые курсы
    if($non_started === true and !empty($non_started_course)): ?>
        <form action="" method="post">
            <?php
            $course['count_weeks'] = $non_started_course['course_weeks'];
            $course['count_days']  = $non_started_course['course_days'];
            $course['count_rest']  = $non_started_course['course_rest'];
            $crs_id = $non_started_course['uc_id'];
            ?>

            <div class="anketa_form_line parent">
                <div class="anketa_form_h"><div class="anketa_form_h_cell">Тренировочные дни:</div></div>
                <?php include('./app_fold/views/course/week_days_item.php'); ?>
            </div>
            <?php $time_disabled = (!empty($course['training_time']) or $course['blocked'] == 1) ? 'disabled' : ''; ?>
            <div class="anketa_form_line parent">
                <div class="anketa_form_h"><div class="anketa_form_h_cell">Время тренировок:</div></div>
                <?php include('./app_fold/views/course/week_days_time_item.php'); ?>
            </div>
            <div class="anketa_form_line parent">
                <div class="video_admin_form_buts parent">
                    <input type="submit" name="bt_save_start_courses" value="Сохранить" class="video_admin_form_send">
                </div>
            </div>
        </form>
    <?php endif; ?>
</div>