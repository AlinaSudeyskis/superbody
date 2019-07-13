<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="my_kurs_item parent">
    <div class="my_kurs_img">
        <a href="">
            <?php if (!empty($course['image'])) :?>
                <img src="<?php echo $course['image'];?>" alt=""/>
            <?php endif;?>
        </a>
    </div>
    <div class="my_kurs_cont">
        <div class="my_kurs_top parent">
            <div class="my_kurs_name"><a href="/profile/course/<?php echo $course['id']?>"><?php echo $course['name'];?></a></div>
            <div class="my_kurs_but parent">
                <a href="/course/<?php echo $course['course_id']?>" class="my_kurs_link">Узнать больше</a>
                <!--<a href="#" class="my_kurs_link disabled">Расписание</a>-->
                <?php if($course['category'] == 'workout' and $page_submenu != 'finished'): ?>
                    <div class="my_kurs_radio_wrap">
                        <input type="checkbox" name="cb_calendar_workout[]" class="anketa_form_radio calendar_course" value="<?php echo $course['id']; ?>" id="calendar_workout<?php echo $course['id']; ?>" <?php if($course['display'] == 1):?>checked="checked"<?php endif;?>>
                        <label for="calendar_workout<?php echo $course['id']; ?>">Календарь</label>
                    </div>
                <?php elseif($course['category'] == 'nutrition' and $page_submenu != 'finished'): ?>
                    <div class="my_kurs_radio_wrap">
                        <input type="radio" name="r_calendar_nutrition" class="anketa_form_radio" value="<?php echo $course['id']; ?>" id="calendar_nutrition<?php echo $course['id']; ?>" <?php if($course['display'] == 1):?>checked="checked"<?php endif;?>>
                        <label for="calendar_nutrition<?php echo $course['id']; ?>">Календарь</label>
                    </div>
                <?php endif;?>
            </div>
        </div>
        <div class="my_kurs_bot parent">
            <div class="my_kurs_tren_h"><?php echo $blocked; ?></div>
        </div>
        <div class="my_kurs_mid"><?php echo $course['description']; ?></div>
        <div class="my_kurs_bot parent">
            <?php if ($course['coaches']) :?>
                <div class="my_kurs_tren_h">Тренер</div>
                <div class="my_kurs_tren_names">
                    <?php $last_coach = count($course['coaches']);
                    foreach ($course['coaches'] as $key => $coach) :?>
                        <a href="/profile/<?php echo $coach['id'];?>"><?php echo $coach['name'];?></a>
                        <?php if ($last_coach != ($key + 1)): echo ','; endif;?>
                    <?php endforeach;
                    unset($coach);?>
                </div>
            <?php endif;?>
        </div>
    </div>
</div>
