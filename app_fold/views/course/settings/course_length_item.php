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
                    elseif(!empty($course['workouts'][$i]['video_id']) and $video['id'] != $course['workouts'][$i]['video_id']):
                        $filled = 'active';
                    endif;?>
                    <div class="practice_day <?php echo $filled; ?>" id="practice<?php echo $i; ?>">Т <?php echo $tr_day; ?></div>
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