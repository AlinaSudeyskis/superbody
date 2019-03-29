<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<input type="hidden" name="count_weeks" id="count_weeks" value="<?php if (!empty($course['count_weeks'])) { echo $course['count_weeks']; }?>" />
<input type="hidden" name="count_days" id="count_days" value="<?php if (!empty($course['count_days'])) { echo $course['count_days']; }?>" />
<input type="hidden" name="count_rest" id="count_rest" value="<?php if (!empty($course['count_rest'])) { echo $course['count_rest']; }?>" />
<div class="anketa_form_radio_all parent <?php if(!empty($days_disabled)): echo $days_disabled; endif;?>" id="week_days">
    <div class="anketa_form_radio_wrap cb_week_day">
        <?php $prev_wo_cl = (!empty($course['days']) and in_array(1, $course['days']) and !empty($grey_current_days) and $grey_current_days === true)
            ? 'prev_workout' : '';
            $day_dis_cl = (!empty($current_num_day) and 1 < $current_num_day) ? 'wo_dis' : '';
        ?>
        <input type="checkbox" name="cb_day[]" value="1" id="cb_monday" class="anketa_form_radio <?php echo $prev_wo_cl .' '.$day_dis_cl; ?>"
               <?php if (!empty($course['days']) and in_array(1, $course['days']) and empty($grey_current_days)) :?>checked="checked"
               <?php elseif((!empty($course['days']) and empty($grey_current_days)) or 1 < $current_num_day) :?>disabled<?php endif;?>
        /><label for="cb_monday">Пн.</label>
    </div>
    <div class="anketa_form_radio_wrap cb_week_day">
        <?php $prev_wo_cl = (!empty($course['days']) and in_array(2, $course['days']) and !empty($grey_current_days) and $grey_current_days === true)
            ? 'prev_workout' : '';
            $day_dis_cl = (!empty($current_num_day) and 2 < $current_num_day) ? 'wo_dis' : '';
        ?>
        <input type="checkbox" name="cb_day[]" value="2" id="cb_tuesday" class="anketa_form_radio <?php echo $prev_wo_cl .' '.$day_dis_cl; ?>"
               <?php if (!empty($course['days']) and in_array(2, $course['days']) and empty($grey_current_days)) :?>checked="checked"
               <?php elseif((!empty($course['days']) and empty($grey_current_days)) or 2 < $current_num_day) :?>disabled<?php endif;?>
        /><label for="cb_tuesday">Вт.</label>
    </div>
    <div class="anketa_form_radio_wrap cb_week_day">
        <?php $prev_wo_cl = (!empty($course['days']) and in_array(3, $course['days']) and !empty($grey_current_days) and $grey_current_days === true)
            ? 'prev_workout' : '';
            $day_dis_cl = (!empty($current_num_day) and 3 < $current_num_day) ? 'wo_dis' : '';
        ?>
        <input type="checkbox" name="cb_day[]" value="3" id="cb_wednesday" class="anketa_form_radio <?php echo $prev_wo_cl .' '.$day_dis_cl; ?>"
               <?php if (!empty($course['days']) and in_array(3, $course['days']) and empty($grey_current_days)) :?>checked="checked"
               <?php elseif((!empty($course['days']) and empty($grey_current_days)) or 3 < $current_num_day) :?>disabled<?php endif;?>
        /><label for="cb_wednesday">Ср.</label>
    </div>
    <div class="anketa_form_radio_wrap cb_week_day">
        <?php $prev_wo_cl = (!empty($course['days']) and in_array(4, $course['days']) and !empty($grey_current_days) and $grey_current_days === true)
            ? 'prev_workout' : '';
            $day_dis_cl = (!empty($current_num_day) and 4 < $current_num_day) ? 'wo_dis' : '';
        ?>
        <input type="checkbox" name="cb_day[]" value="4" id="cb_thursday" class="anketa_form_radio <?php echo $prev_wo_cl .' '.$day_dis_cl; ?>"
               <?php if (!empty($course['days']) and in_array(4, $course['days']) and empty($grey_current_days)) :?>checked="checked"
               <?php elseif((!empty($course['days']) and empty($grey_current_days)) or 4 < $current_num_day) :?>disabled<?php endif;?>
        /><label for="cb_thursday">Чт.</label>
    </div>
    <div class="anketa_form_radio_wrap cb_week_day">
        <?php $prev_wo_cl = (!empty($course['days']) and in_array(5, $course['days']) and !empty($grey_current_days) and $grey_current_days === true)
            ? 'prev_workout' : '';
            $day_dis_cl = (!empty($current_num_day) and 5 < $current_num_day) ? 'wo_dis' : '';
        ?>
        <input type="checkbox" name="cb_day[]" value="5" id="cb_friday" class="anketa_form_radio <?php echo $prev_wo_cl .' '.$day_dis_cl; ?>"
               <?php if (!empty($course['days']) and in_array(5, $course['days']) and empty($grey_current_days)) :?>checked="checked"
               <?php elseif((!empty($course['days']) and empty($grey_current_days)) or 5 < $current_num_day) :?>disabled<?php endif;?>
        /><label for="cb_friday">Пт.</label>
    </div>
    <div class="anketa_form_radio_wrap cb_week_day">
        <?php $prev_wo_cl = (!empty($course['days']) and in_array(6, $course['days']) and !empty($grey_current_days) and $grey_current_days === true)
            ? 'prev_workout' : '';
            $day_dis_cl = (!empty($current_num_day) and 6 < $current_num_day) ? 'wo_dis' : '';
        ?>
        <input type="checkbox" name="cb_day[]" value="6" id="cb_saturday" class="anketa_form_radio <?php echo $prev_wo_cl .' '.$day_dis_cl; ?>"
               <?php if (!empty($course['days']) and in_array(6, $course['days']) and empty($grey_current_days)) :?>checked="checked"
               <?php elseif((!empty($course['days']) and empty($grey_current_days)) or 6 < $current_num_day) :?>disabled<?php endif;?>
        /><label for="cb_saturday">Сб.</label>
    </div>
    <div class="anketa_form_radio_wrap cb_week_day">
        <?php $prev_wo_cl = (!empty($course['days']) and in_array(7, $course['days']) and !empty($grey_current_days) and $grey_current_days === true)
            ? 'prev_workout' : '';
            $day_dis_cl = (!empty($current_num_day) and 7 < $current_num_day) ? 'wo_dis' : '';
        ?>
        <input type="checkbox" name="cb_day[]" value="7" id="cb_sunday" class="anketa_form_radio <?php echo $prev_wo_cl .' '.$day_dis_cl; ?>"
               <?php if (!empty($course['days']) and in_array(7, $course['days']) and empty($grey_current_days)) :?>checked="checked"
               <?php elseif((!empty($course['days']) and empty($grey_current_days)) or 7 < $current_num_day) :?>disabled<?php endif;?>
        /><label for="cb_sunday">Вс.</label>
    </div>
</div>