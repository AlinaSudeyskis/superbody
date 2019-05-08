<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="anketa_form_radio_all parent week_days <?php if(!empty($days_disabled)): echo $days_disabled; endif;?>">
    <input type="hidden" name="count_weeks" id="count_weeks" value="<?php if (!empty($course['count_weeks'])) { echo $course['count_weeks']; }?>" />
    <input type="hidden" name="count_days" id="count_days" value="<?php if (!empty($course['count_days'])) { echo $course['count_days']; }?>" />
    <input type="hidden" name="count_rest" id="count_rest" value="<?php if (!empty($course['count_rest'])) { echo $course['count_rest']; }?>" />
    <div class="anketa_form_radio_wrap cb_week_day">
        <?php
        // Является ли текущий день предыдущим выбранным днем.
        $prev_wo = (!empty($course['days']) and in_array(1, $course['days']) and !empty($grey_current_days) and $grey_current_days === true)
            ? true : false;
        // Остался один день для выбора
        $one_next_wo = ($prev_wo === true and $course['count_days'] == 1) ? true : false;
        // Классы предыдущей тренировки (предыдущий выбранный день тренировки, выполнена, пропущена, запрещена для выбора)
        $prev_wo_cl = ($prev_wo === true) ? 'prev_workout' : '';
        $prev_wo_cl .= (!empty($week_wo) and $week_wo[1]['status'] == 'done') ? ' done' : '';
        $prev_wo_cl .= (!empty($week_wo) and $week_wo[1]['status'] == 'missed') ? ' missed' : '';
        $prev_wo_cl .= ((!empty($current_num_day) and 1 < $current_num_day) or $one_next_wo === true) ? ' wo_dis' : '';
        ?>
        <input type="checkbox" name="cb_day[<?php echo $crs_id; ?>][]" value="1" id="cb_monday<?php echo $crs_id; ?>" class="anketa_form_radio <?php echo $prev_wo_cl; ?>"
               <?php if (!empty($course['days']) and in_array(1, $course['days']) and empty($grey_current_days)) :?>checked="checked"
               <?php elseif((!empty($course['days']) and empty($grey_current_days)) or 1 < $current_num_day or $one_next_wo === true) :?>disabled<?php endif;?>
        /><label for="cb_monday<?php echo $crs_id; ?>">Пн.</label>
    </div>
    <div class="anketa_form_radio_wrap cb_week_day">
        <?php $prev_wo = (!empty($course['days']) and in_array(2, $course['days']) and !empty($grey_current_days) and $grey_current_days === true)
            ? true : false;
        $one_next_wo = ($prev_wo === true and $course['count_days'] == 1) ? true : false;
        $prev_wo_cl = ($prev_wo === true) ? 'prev_workout' : '';
        $prev_wo_cl .= (!empty($week_wo) and $week_wo[2]['status'] == 'done') ? ' done' : '';
        $prev_wo_cl .= (!empty($week_wo) and $week_wo[2]['status'] == 'missed') ? ' missed' : '';
        $prev_wo_cl .= (((!empty($current_num_day) and 2 < $current_num_day) or $one_next_wo === true)) ? ' wo_dis' : '';
        ?>
        <input type="checkbox" name="cb_day[<?php echo $crs_id; ?>][]" value="2" id="cb_tuesday<?php echo $crs_id; ?>" class="anketa_form_radio <?php echo $prev_wo_cl; ?>"
               <?php if (!empty($course['days']) and in_array(2, $course['days']) and empty($grey_current_days)) :?>checked="checked"
               <?php elseif((!empty($course['days']) and empty($grey_current_days)) or 2 < $current_num_day or $one_next_wo === true) :?>disabled<?php endif;?>
        /><label for="cb_tuesday<?php echo $crs_id; ?>">Вт.</label>
    </div>
    <div class="anketa_form_radio_wrap cb_week_day">
        <?php $prev_wo = (!empty($course['days']) and in_array(3, $course['days']) and !empty($grey_current_days) and $grey_current_days === true)
            ? true : false;
        $one_next_wo = ($prev_wo === true and $course['count_days'] == 1) ? true : false;
        $prev_wo_cl = ($prev_wo === true) ? 'prev_workout' : '';
        $prev_wo_cl .= (!empty($week_wo) and $week_wo[3]['status'] == 'done') ? ' done' : '';
        $prev_wo_cl .= (!empty($week_wo) and $week_wo[3]['status'] == 'missed') ? ' missed' : '';
        $prev_wo_cl .= (((!empty($current_num_day) and 3 < $current_num_day) or $one_next_wo === true)) ? ' wo_dis' : '';
        ?>
        <input type="checkbox" name="cb_day[<?php echo $crs_id; ?>][]" value="3" id="cb_wednesday<?php echo $crs_id; ?>" class="anketa_form_radio <?php echo $prev_wo_cl; ?>"
               <?php if (!empty($course['days']) and in_array(3, $course['days']) and empty($grey_current_days)) :?>checked="checked"
               <?php elseif((!empty($course['days']) and empty($grey_current_days)) or 3 < $current_num_day or $one_next_wo === true) :?>disabled<?php endif;?>
        /><label for="cb_wednesday<?php echo $crs_id; ?>">Ср.</label>
    </div>
    <div class="anketa_form_radio_wrap cb_week_day">
        <?php $prev_wo = (!empty($course['days']) and in_array(4, $course['days']) and !empty($grey_current_days) and $grey_current_days === true)
            ? true : false;
        $one_next_wo = ($prev_wo === true and $course['count_days'] == 1) ? true : false;
        $prev_wo_cl = ($prev_wo === true) ? 'prev_workout' : '';
        $prev_wo_cl .= (!empty($week_wo) and $week_wo[4]['status'] == 'done') ? ' done' : '';
        $prev_wo_cl .= (!empty($week_wo) and $week_wo[4]['status'] == 'missed') ? ' missed' : '';
        $prev_wo_cl .= (((!empty($current_num_day) and 4 < $current_num_day) or $one_next_wo === true)) ? ' wo_dis' : '';
        ?>
        <input type="checkbox" name="cb_day[<?php echo $crs_id; ?>][]" value="4" id="cb_thursday<?php echo $crs_id; ?>" class="anketa_form_radio <?php echo $prev_wo_cl; ?>"
               <?php if (!empty($course['days']) and in_array(4, $course['days']) and empty($grey_current_days)) :?>checked="checked"
               <?php elseif((!empty($course['days']) and empty($grey_current_days)) or 4 < $current_num_day or $one_next_wo === true) :?>disabled<?php endif;?>
        /><label for="cb_thursday<?php echo $crs_id; ?>">Чт.</label>
    </div>
    <div class="anketa_form_radio_wrap cb_week_day">
        <?php $prev_wo = (!empty($course['days']) and in_array(5, $course['days']) and !empty($grey_current_days) and $grey_current_days === true)
            ? true : false;
        $one_next_wo = ($prev_wo === true and $course['count_days'] == 1) ? true : false;
        $prev_wo_cl = ($prev_wo === true) ? 'prev_workout' : '';
        $prev_wo_cl .= (!empty($week_wo) and $week_wo[5]['status'] == 'done') ? ' done' : '';
        $prev_wo_cl .= (!empty($week_wo) and $week_wo[5]['status'] == 'missed') ? ' missed' : '';
        $prev_wo_cl .= (((!empty($current_num_day) and 5 < $current_num_day) or $one_next_wo === true)) ? ' wo_dis' : '';
        ?>
        <input type="checkbox" name="cb_day[<?php echo $crs_id; ?>][]" value="5" id="cb_friday<?php echo $crs_id; ?>" class="anketa_form_radio <?php echo $prev_wo_cl; ?>"
               <?php if (!empty($course['days']) and in_array(5, $course['days']) and empty($grey_current_days)) :?>checked="checked"
               <?php elseif((!empty($course['days']) and empty($grey_current_days)) or 5 < $current_num_day or $one_next_wo === true) :?>disabled<?php endif;?>
        /><label for="cb_friday<?php echo $crs_id; ?>">Пт.</label>
    </div>
    <div class="anketa_form_radio_wrap cb_week_day">
        <?php $prev_wo = (!empty($course['days']) and in_array(6, $course['days']) and !empty($grey_current_days) and $grey_current_days === true)
            ? true : false;
        $one_next_wo = ($prev_wo === true and $course['count_days'] == 1) ? true : false;
        $prev_wo_cl = ($prev_wo === true) ? 'prev_workout' : '';
        $prev_wo_cl .= (!empty($week_wo) and $week_wo[6]['status'] == 'done') ? ' done' : '';
        $prev_wo_cl .= (!empty($week_wo) and $week_wo[6]['status'] == 'missed') ? ' missed' : '';
        $prev_wo_cl .= (((!empty($current_num_day) and 6 < $current_num_day) or $one_next_wo === true)) ? ' wo_dis' : '';
        ?>
        <input type="checkbox" name="cb_day[<?php echo $crs_id; ?>][]" value="6" id="cb_saturday<?php echo $crs_id; ?>" class="anketa_form_radio <?php echo $prev_wo_cl; ?>"
               <?php if (!empty($course['days']) and in_array(6, $course['days']) and empty($grey_current_days)) :?>checked="checked"
               <?php elseif((!empty($course['days']) and empty($grey_current_days)) or 6 < $current_num_day or $one_next_wo === true) :?>disabled<?php endif;?>
        /><label for="cb_saturday<?php echo $crs_id; ?>">Сб.</label>
    </div>
    <div class="anketa_form_radio_wrap cb_week_day">
        <?php $prev_wo = (!empty($course['days']) and in_array(7, $course['days']) and !empty($grey_current_days) and $grey_current_days === true)
            ? true : false;
        $one_next_wo = ($prev_wo === true and $course['count_days'] == 1) ? true : false;
        $prev_wo_cl = ($prev_wo === true) ? 'prev_workout' : '';
        $prev_wo_cl .= (!empty($week_wo) and $week_wo[7]['status'] == 'done') ? ' done' : '';
        $prev_wo_cl .= (!empty($week_wo) and $week_wo[7]['status'] == 'missed') ? ' missed' : '';
        $prev_wo_cl .= (((!empty($current_num_day) and 7 < $current_num_day) or $one_next_wo === true)) ? ' wo_dis' : '';
        ?>
        <input type="checkbox" name="cb_day[<?php echo $crs_id; ?>][]" value="7" id="cb_sunday<?php echo $crs_id; ?>" class="anketa_form_radio <?php echo $prev_wo_cl; ?>"
               <?php if (!empty($course['days']) and in_array(7, $course['days']) and empty($grey_current_days)) :?>checked="checked"
               <?php elseif((!empty($course['days']) and empty($grey_current_days)) or 7 < $current_num_day or $one_next_wo === true) :?>disabled<?php endif;?>
        /><label for="cb_sunday<?php echo $crs_id; ?>">Вс.</label>
    </div>
</div>