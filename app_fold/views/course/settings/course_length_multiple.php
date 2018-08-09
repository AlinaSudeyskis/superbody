<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php if(!empty($course) and !empty($course['count_days'] and !empty($course['count_weeks']))) :
    $i = 1;
    for($tr_week = 1; $tr_week <= $course['count_weeks']; $tr_week++) :?>
        <div class="practice_weeks">
            <div class="practice_week"><span>Неделя</span> <?php echo $tr_week; ?></div>
            <div class="practice_days">
                <?php for($tr_day = 1; $tr_day <= $course['count_days']; $tr_day++) :
                    $filled = '';
                    if(!empty($course['workouts']) and !empty($course['workouts'][$i]['video_id']) and $video['id'] != $course['workouts'][$i]['video_id']):
                        $filled = 'filled';
                    endif;?>
                    <input type="checkbox" name="cb_practice_days[<?php echo $i; ?>]" class="anketa_form_radio" value="<?php echo $video['id']; ?>"
                           id="practice<?php echo $i; ?>" <?php if(!empty($course['workouts'][$i]['video_id']) and $video['id'] == $course['workouts'][$i]['video_id']): ?>checked="checked"<?php endif; ?>/>
                    <label for="practice<?php echo $i; ?>" class="practice_day <?php echo $filled; ?>" id="practice<?php /*echo $i; */?>">Т <?php echo $tr_day; ?></label>
                    <!--<div class="practice_day <?php /*echo $filled; */?>" id="practice<?php /*echo $i; */?>">Т <?php /*echo $tr_day; */?></div>-->
                    <?php $i++;
                endfor;
                unset($tr_day);?>
            </div>
        </div>
    <?php endfor;
    unset($tr_week);
else:?>
    <span class="h_subtitle">Выберите длительность курса и количество тренировок в неделю</span>
<?php endif;?>