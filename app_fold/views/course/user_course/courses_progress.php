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
    <div class="tren_prof_page_block parent">
        <?php //$courses_percent_done = true;
        if(!empty($courses_percent_done) and (!empty($courses) or !empty($blocked_courses))): ?>
            <?php if(!empty($courses)):
                foreach($courses as $course): ?>
                    <?php if(is_numeric($course['percent_done'])):
                        $crs_percent_done = round($course['percent_done']); ?>
                        <div class="calendar_prof_item">
                            <div class="calendar_prof_end">
                                <span class="calendar_prof_end_line" style="width: <?php echo $crs_percent_done; ?>%; background-color: rgb(<?php echo $course['color_done']; ?>);"></span>
                                <span class="calendar_prof_end_val"><?php echo $crs_percent_done; ?>%</span>
                            </div>
                        </div>
                    <?php endif;?>
                <?php endforeach;
                unset($course);
            endif;?>

            <?php if(!empty($blocked_courses)):
                foreach($blocked_courses as $course): ?>
                    <?php if(is_numeric($course['percent_done'])):
                        $crs_percent_done = round($course['percent_done']); ?>
                        <div class="calendar_prof_item">
                            <div class="calendar_prof_end">
                                <span class="calendar_prof_end_line" style="width: <?php echo $crs_percent_done; ?>%; background-color: rgb(<?php echo $course['color_done']; ?>);"></span>
                                <span class="calendar_prof_end_val"><?php echo $crs_percent_done; ?>%</span>
                            </div>
                        </div>
                    <?php endif;?>
                <?php endforeach;
                unset($course);
            endif;?>
            <?php
/*            $percent = 11.6666667;
            $round_percent_done = (is_integer($percent)) ? $percent : round($percent, 1);
            $crs_percent_done = (is_integer($round_percent_done)) ? $round_percent_done : number_format($round_percent_done, 1, '.', '');*/?><!--
            <div class="calendar_prof_item">
                <div class="calendar_prof_end">
                    <span class="calendar_prof_end_line" style="width: <?php /*echo $crs_percent_done; */?>%; background-color: #00bfee;"></span>
                    <span class="calendar_prof_end_val"><?php /*echo $crs_percent_done; */?>%</span>
                </div>
            </div>
            <?php
/*            $percent = 10;
            $round_percent_done = (is_integer($percent)) ? $percent : round($percent, 1);
            $crs_percent_done = (is_integer($round_percent_done)) ? $round_percent_done : number_format($round_percent_done, 1, '.', ''); */?>
            <div class="calendar_prof_item">
                <div class="calendar_prof_end">
                    <span class="calendar_prof_end_line" style="width: <?php /*echo $crs_percent_done; */?>%; background-color: #4acbea;"></span>
                    <span class="calendar_prof_end_val"><?php /*echo $crs_percent_done; */?>%</span>
                </div>
            </div>-->

            <div class="calendar_info_desk_cont parent">
                <?php if(!empty($courses)):
                    foreach($courses as $course): ?>
                        <?php if(is_numeric($course['percent_done'])): ?>
                            <div class="calendar_info_desk_item parent">
                                <div class="calendar_info_desk_val">
                                    <span style="background-color: rgb(<?php echo $course['color_done']; ?>);"></span>
                                </div>
                                <div class="calendar_info_desk_txt"><?php echo $course['name']; ?></div>
                            </div>
                        <?php endif;?>
                    <?php endforeach;
                    unset($course);
                endif;?>
                <?php if(!empty($blocked_courses)):
                    foreach($blocked_courses as $course): ?>
                        <?php if(is_numeric($course['percent_done'])): ?>
                            <div class="calendar_info_desk_item parent">
                                <div class="calendar_info_desk_val">
                                    <span style="background-color: rgb(<?php echo $course['color_done']; ?>);"></span>
                                </div>
                                <div class="calendar_info_desk_txt"><?php echo $course['name']; ?></div>
                            </div>
                        <?php endif;?>
                    <?php endforeach;
                    unset($course);
                endif;?>
                <!--<div class="calendar_info_desk_item parent">
                    <div class="calendar_info_desk_val">
                        <span style="background-color: #00bfee;"></span>
                    </div>
                    <div class="calendar_info_desk_txt">Супер фигура за 12 недель</div>
                </div>
                <div class="calendar_info_desk_item parent">
                    <div class="calendar_info_desk_val">
                        <span style="background-color: #4acbea;"></span>
                    </div>
                    <div class="calendar_info_desk_txt">Гибкость</div>
                </div>-->
            </div>
        <?php else: ?>
            <h3 class="info">Нет активных курсов</h3>
        <?php endif; ?>
    </div>
</div>