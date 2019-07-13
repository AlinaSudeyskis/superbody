<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="anketa_form_radio_all parent week_times <?php/* if(!empty($time_disabled)): echo $time_disabled; endif;*/?>">
    <?php for($nwd = 1; $nwd <= 7; $nwd++): ?>
        <div class="anketa_form_radio_wrap cb_week_time">
            <?php $prev_wo = (!empty($course['days']) and in_array($nwd, $course['days']) and !empty($grey_current_days) and $grey_current_days === true)
                ? true : false;
            $one_next_wo = ($prev_wo === true and $course['count_days'] == 1) ? true : false;
            $prev_wo_cl = ($prev_wo === true) ? 'prev_workout' : '';
            $prev_wo_cl .= (((!empty($current_num_day) and $nwd < $current_num_day) or $one_next_wo === true)) ? ' wo_dis' : '';
            ?>
            <input type="text" name="i_days_time[<?php echo $crs_id; ?>][<?php echo $nwd; ?>]" value="<?php echo $week_wo[$nwd]['time']; ?>"
                   class="anketa_form_in time <?php echo $prev_wo_cl; ?> disabled" placeholder="чч:мм" maxlength="5" minlength="5"
                   id="cb_<?php echo $nwd; ?>_<?php echo $crs_id; ?>_time" disabled="disabled">
        </div>
    <?php endfor;
    unset($nwd); ?>
</div>