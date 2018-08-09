<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php if(!empty($course) and !empty($course['count_days'] and !empty($course['count_weeks']))):
    $i = 1;
    for($tr_week = 1; $tr_week <= $course['count_weeks']; $tr_week++) :?>
        <div class="nutrition_weeks">
            <div class="nutrition_week"><span>Неделя</span> <?php echo $tr_week; ?></div>
            <div class="nutrition_days">
                <?php for($tr_day = 1; $tr_day <= 7; $tr_day++) :
                    $filled = '';
                    if(!empty($course['workouts']) and !empty($course['workouts'][$i]['video_id'])):
                        $filled = 'filled';
                    endif;?>
                    <input type="checkbox" name="cb_nutrition_days[<?php echo $i; ?>]" class="anketa_form_radio"
                           value="<?php echo $i; ?>" id="nutrition<?php echo $i; ?>cb"/>
                    <label for="nutrition<?php echo $i; ?>cb" class="nutrition_day <?php echo $filled; ?>" id="nutrition<?php echo $i; ?>" short="Д<?php echo $tr_day; ?>">День <?php echo $tr_day; ?></label>
                    <!--<div class="nutrition_day <?php /*echo $filled; */?>" id="nutrition<?php /*echo $i; */?>" short="Д<?php /*echo $tr_day; */?>">День <?php /*echo $tr_day; */?></div>-->
                    <?php $i++;
                endfor;
                unset($tr_day);?>
            </div>
        </div>
    <?php endfor;
    unset($tr_week);
else:?>
    <span class="h_subtitle">Выберите приемы пищи и введите длительность курса</span>
<?php endif;?>