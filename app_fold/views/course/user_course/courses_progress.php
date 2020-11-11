<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="content_block new_content_block">
    <div class="content_block_h parent">
        <h3>Прогресс</h3>
        <div class="content_block_h_buts">
            <div class="content_block_h_slide kurs_slide"></div>
            <div class="content_block_h_close"></div>
        </div>
    </div>
    <div class="tren_prof_page_block parent courses_progress">
        <?php //$courses_percent_done = true;
        if(!empty($courses_percent_done) and (!empty($courses) or !empty($blocked_courses))): ?>
            <?php if(!empty($courses)):
                foreach($courses as $course): ?>
                    <?php if(is_numeric($course['percent_done'])):
                        $crs_percent_done = round($course['percent_done']);
                        $deg = round(360*$crs_percent_done/100); ?>
                        <?php include('./app_fold/views/course/user_course/progress_item.php'); ?>
                    <?php endif;?>
                <?php endforeach;
                unset($course);
            endif;?>

            <?php if(!empty($blocked_courses)):
                foreach($blocked_courses as $course): ?>
                    <?php if(is_numeric($course['percent_done'])):
                        $crs_percent_done = round($course['percent_done']);
                        $deg = round(360*$crs_percent_done/100); ?>
                        <?php include('./app_fold/views/course/user_course/progress_item.php'); ?>
                    <?php endif;?>
                <?php endforeach;
                unset($course);
            endif;?>
        <?php else: ?>
            <h3 class="info">Нет активных курсов</h3>
        <?php endif; ?>
    </div>
</div>