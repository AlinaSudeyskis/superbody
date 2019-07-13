<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*$result['uc_days']  = $wo_data['days'];
$result['av_days']  = $wo_data['available_days'];
$result['recom_rd'] = $course['count_rest'];
$course['count_days'] = count($wo_data['available_days']);*/
?>
<form action="" method="post" class="postpone">
    <!--<div class="postpone_next_wo">Следующая тренировка: <?php /*echo $next_workout['next_workout']; */?></div>-->
    <?php if(!empty($courses_week_wo)): ?>
        <div class="content_block_h parent">
            <h3><?php if(!empty($next_workout['next_workout'])): ?>Следующая тренировка: <?php echo $next_workout['next_workout']; endif;?></h3>
        </div>
        <div class="kurs_block_val">
            <div class="anketa_block">
                <ul class="anketa_block_nav parent">
                    <?php $i = 0;
                    foreach($courses_week_wo as $crs_id => $crs): ?>
                        <li><span <?php if($i == 0): echo 'class="anketa_active"'; endif;?>><?php echo $crs['crs_name']; ?></span></li>
                        <?php $i++;
                    endforeach;
                    unset($crs);?>
                </ul>
                <div class="anketa_block_cont">
                    <?php foreach($courses_week_wo as $crs_id => $crs):
                        $week_wo = $crs['wos'];
                        $course['count_weeks'] = $crs['count_weeks'];
                        $course['count_days']  = count($crs['available_days']);
                        $course['count_rest']  = $crs['count_rest'];
                        $course['days']        = $crs['days'];
                        $course['training_time'] = $week_wo['time'];
                        ?>
                        <div class="anketa_block_item">
                            <div class="anketa_block_item_h">Перенести тренировки недели</div>
                            <div class="anketa_block_item_cont">
                                <div class="postpone_title lend_form_h"></div>
                                <?php
                                ob_start();
                                    include('./app_fold/views/course/week_days_item.php');
                                    $week_days = ob_get_contents();
                                ob_end_clean();
                                ?>
                                <?php if(!empty($week_dates) and !empty($week_dates_today)): ?>
                                    <div class="anketa_form_radio_all parent cal_date">
                                        <?php foreach($week_dates as $wd):?>
                                            <div class="anketa_form_radio_wrap">
                                                <label class="<?php if($wd == $week_dates_today): ?>bold<?php endif; ?>"><?php echo $wd; ?></label>
                                            </div>
                                        <?php endforeach;
                                        unset($wd);?>
                                    </div>
                                <?php endif;?>
                                <div class="anketa_form_line parent">
                                    <?php echo $week_days; ?>
                                    <?php include('./app_fold/views/course/week_days_time_item.php'); ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach;
                    unset($crs);?>
                </div>
            </div>
        </div>
    <?php endif;?>

    <div class="anketa_form_line parent">
        <div class="video_admin_form_buts parent">
            <input type="submit" name="bt_save_postpone" value="Сохранить" class="video_admin_form_send" id="bt-save-postpone" disabled>
        </div>
    </div>
</form>
