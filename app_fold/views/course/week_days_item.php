<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="anketa_form_radio_all parent week_days <?php /*if(!empty($days_disabled)): echo $days_disabled; endif;*/ ?>">
    <input type="hidden" name="count_weeks" id="count_weeks" value="<?php if (!empty($course['count_weeks'])) { echo $course['count_weeks']; }?>" />
    <input type="hidden" name="count_days" id="count_days" value="<?php if (!empty($course['count_days'])) { echo $course['count_days']; }?>" />
    <input type="hidden" name="count_rest" id="count_rest" value="<?php if (!empty($course['count_rest'])) { echo $course['count_rest']; }?>" />
    <input type="hidden" name="crs_count_weeks[<?php echo $crs_id; ?>]" value="<?php if (!empty($course['count_weeks'])) { echo $course['count_weeks']; }?>" />
    <input type="hidden" name="crs_count_days[<?php echo $crs_id; ?>]" value="<?php if (!empty($course['count_days'])) { echo $course['count_days']; }?>" />
    <input type="hidden" name="crs_count_rest[<?php echo $crs_id; ?>]" value="<?php if (!empty($course['count_rest'])) { echo $course['count_rest']; }?>" />
    <?php $week_days = array(1 => 'Пн.', 2 => 'Вт.', 3 => 'Ср.', 4 => 'Чт.', 5 => 'Пт.', 6 => 'Сб.', 7 => 'Вс.'); ?>
    <?php for($nwd = 1; $nwd <= 7; $nwd++): ?>
        <div class="anketa_form_radio_wrap cb_week_day">
            <?php
            // Является ли текущий день предыдущим выбранным днем.
            $prev_wo = (!empty($course['days']) and in_array($nwd, $course['days']) and !empty($grey_current_days) and $grey_current_days === true)
                ? true : false;
            // Остался один день для выбора
            $one_next_wo = ($prev_wo === true and $course['count_days'] == 1) ? true : false;
            // Классы предыдущей тренировки (предыдущий выбранный день тренировки, выполнена, пропущена, запрещена для выбора)
            $prev_wo_cl = ($prev_wo === true) ? 'prev_workout' : '';
            $prev_wo_cl .= (!empty($week_wo) and $week_wo[$nwd]['status'] == 'done') ? ' done' : '';
            $prev_wo_cl .= (!empty($week_wo) and $week_wo[$nwd]['status'] == 'missed') ? ' missed' : '';
            $prev_wo_cl .= ((!empty($current_num_day) and $nwd < $current_num_day) or $one_next_wo === true) ? ' wo_dis' : '';
            $prev_wo_cl .= ((!empty($current_num_day) and $nwd < $current_num_day) or $one_next_wo === true or (!empty($course['days']) and empty($grey_current_days))) ? ' wo_dis disabled' : '';
            ?>
            <input type="checkbox" name="cb_day[<?php echo $crs_id; ?>][]" value="<?php echo $nwd; ?>" id="cb_<?php echo $nwd; ?>_<?php echo $crs_id; ?>" class="anketa_form_radio <?php echo $prev_wo_cl; ?>"
                   <?php if (!empty($course['days']) and in_array($nwd, $course['days']) and empty($grey_current_days)) :?>checked="checked"<?php endif; ?>
            /><label for="cb_<?php echo $nwd; ?>_<?php echo $crs_id; ?>"><?php echo $week_days[$nwd]; ?></label>
        </div>
    <?php endfor;
    unset($nwd); ?>
    <?php /*elseif((!empty($course['days']) and empty($grey_current_days)) or $nwd < $current_num_day or $one_next_wo === true) :*/?><!--disabled-->
</div>