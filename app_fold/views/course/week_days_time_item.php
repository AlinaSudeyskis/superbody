<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="anketa_form_radio_all parent week_times <?php/* if(!empty($time_disabled)): echo $time_disabled; endif;*/?>">
    <?php for($nwd = 1; $nwd <= 7; $nwd++): ?>
        <div class="anketa_form_radio_wrap cb_week_time">
            <?php
            $prev_wo      = (!empty($course['days']) and in_array($nwd, $course['days']) and !empty($grey_current_days) and $grey_current_days === true)
                ? true : false;
            $one_next_wo  = ($prev_wo === true and $course['count_days'] == 1) ? true : false;
            $prev_wo_cl   = ($prev_wo === true) ? 'prev_workout' : '';
            $prev_wo_cl  .= (((!empty($current_num_day) and $nwd < $current_num_day) or $one_next_wo === true)) ? ' wo_dis' : '';
            $week_dt      = (!empty($week_wo[$nwd]['time'])) ? $week_wo[$nwd]['time'] : null;
            $crs_dt       = (!empty($course['training_time'][$nwd])) ? $course['training_time'][$nwd] : null;
            $day_time_val = (!empty($week_dt)) ? $week_dt : $crs_dt;
            $fl_dt        = (!empty($course['days']) and in_array($nwd, $course['days'])) ? true : false;
            ?>
            <input type="text" name="i_days_time[<?php echo $crs_id; ?>][<?php echo $nwd; ?>]" value="<?php echo $day_time_val; ?>"
                   class="anketa_form_in time <?php echo $prev_wo_cl; ?><?php if(empty($uc_set) or empty($fl_dt)): ?> disabled <?php endif; ?>" placeholder="чч:мм" maxlength="5" minlength="5"
                   id="cb_<?php echo $nwd; ?>_<?php echo $crs_id; ?>_time" <?php if(empty($uc_set) or empty($fl_dt)): ?> disabled="disabled" <?php endif; ?>>
        </div>
    <?php endfor;
    unset($nwd); ?>
</div>