<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php $breadcrumbs = array('/courses' => 'Курсы', '/course/' => $course['name']);
include_once('./app_fold/views/breadcrumb.php');?>
<div class="container"><h2 class="block_h"><?php echo $course['name']; ?></h2></div>
<div class="content_col">
    <div class="content_block new_content_block">
        <div class="content_block_h parent">
            <h3>Курс - <?php echo $course['name']; ?></h3>
            <div class="content_block_h_buts">
                <div class="content_block_h_slide kurs_slide"></div>
                <div class="content_block_h_close"></div>
            </div>
        </div>
        <div class="kurs_block_val">
            <div class="anketa_block">
                <div class="anketa_block_cont">
                    <div class="anketa_block_item">
                        <div class="anketa_block_item_h"><?php echo $course['description']; ?></div>
                        <div class="anketa_block_item_cont video_admin_form">
                            <?php include_once('./app_fold/views/authorization/short_auth.php'); ?>
                            <form action="" method="post" class="anketa_form purchase_form">
                                <div class="parent kurs_cur_wrap">
                                    <div class="kurs_block_h">Длительность курса:</div>
                                    <div class="kurs_block_h"><?php if (!empty($course['count_weeks'])) { echo $course['count_weeks']; }?></div>
                                    <input type="hidden" name="count_weeks" id="count_weeks" value="<?php if (!empty($course['count_weeks'])) { echo $course['count_weeks']; }?>" />
                                    <input type="hidden" name="count_days" id="count_days" value="<?php if (!empty($course['count_days'])) { echo $course['count_days']; }?>" />
                                    <input type="hidden" name="count_rest" id="count_rest" value="<?php if (!empty($course['count_rest'])) { echo $course['count_rest']; }?>" />
                                    <div class="kurs_cur">нед.</div>
                                </div>
                                <div class="parent kurs_cur_wrap">
                                    <div class="kurs_block_h">Количество тренировок:</div>
                                    <div class="kurs_block_h"><?php if (!empty($course['count_days'])) { echo $course['count_days']; }?></div>
                                    <div class="kurs_cur"> дн./нед.</div>
                                </div>
                                <?php if (!empty($course['coaches'])) :?>
                                    <!--<div class="anketa_form_line parent">
                                        <div class="anketa_form_h"><div class="anketa_form_h_cell">Тренеры:</div></div>
                                        <div class="anketa_form_radio_all parent">
                                            <?php /* <!--<input type="hidden" name="user_coach" value="echo $course['coach_id']; " id="user-coach-id"/> --> */?>
                                            <?php /*foreach($course['coaches'] as $key => $coach) :*/?>
                                                <div class="anketa_form_radio_wrap">
                                                    <input type="radio" name="user_coach" value="<?php /*echo $coach['id']; */?>" id="cb_coach<?php /*echo $course['coach_id']; */?>" class="anketa_form_radio long"
                                                           <?php /*if ($course['coach_id'] == $coach['id']) :*/?>checked="checked"<?php /*endif;*/?>
                                                    /><label for="cb_coach<?php /*echo $course['coach_id']; */?>"><?php /*echo $coach['name']; */?></label>
                                                </div>
                                            <?php /*endforeach;
                                            unset($coach);*/?>
                                        </div>
                                    </div>-->
                                <?php endif;
                                include_once('./app_fold/views/course/course_payment_item.php');?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!-- content_col -->
