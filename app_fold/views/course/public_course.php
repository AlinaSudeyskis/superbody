<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
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
                        <div class="anketa_block_item_cont">
                            <form action="" method="post" class="anketa_form video_admin_form">
                                <div class="anketa_form_line parent">
                                    <div class="anketa_form_h"><div class="anketa_form_h_cell">Длительность курса:</div></div>
                                    <div class="anketa_form_h"><div class="anketa_form_h_cell"><?php if (!empty($course['count_weeks'])) { echo $course['count_weeks']; }?></div></div>
                                    <input type="hidden" name="count_weeks" id="count_weeks" value="<?php if (!empty($course['count_weeks'])) { echo $course['count_weeks']; }?>" />
                                    <input type="hidden" name="count_days" id="count_days" value="<?php if (!empty($course['count_days'])) { echo $course['count_days']; }?>" />
                                    <input type="hidden" name="count_rest" id="count_rest" value="<?php if (!empty($course['count_rest'])) { echo $course['count_rest']; }?>" />
                                    <div class="anketa_form_desk">нед.</div>
                                </div>
                                <div class="anketa_form_line parent">
                                    <div class="anketa_form_h"><div class="anketa_form_h_cell">Количество тренировок:</div></div>
                                    <div class="anketa_form_h"><div class="anketa_form_h_cell"><?php if (!empty($course['count_days'])) { echo $course['count_days']; }?></div></div>
                                    <div class="anketa_form_desk"> дн./нед.</div>
                                </div>
                                <?php if (!empty($course['couches'])) :?>
                                    <div class="anketa_form_line parent">
                                        <div class="anketa_form_h"><div class="anketa_form_h_cell">Тренеры:</div></div>
                                        <div class="anketa_form_radio_all parent">
                                            <!--<input type="hidden" name="user_couch" value="<?php /*echo $course['couch_id']*/?>" id="user-couch-id"/>-->
                                            <?php foreach($course['couches'] as $key => $couch) :?>
                                                <div class="anketa_form_radio_wrap">
                                                    <input type="radio" name="user_couch" value="<?php echo $couch['id']; ?>" id="cb_couch<?php echo $course['couch_id']; ?>" class="anketa_form_radio long"
                                                           <?php if ($course['couch_id'] == $couch['id']) :?>checked="checked"<?php endif;?>
                                                    /><label for="cb_couch<?php echo $course['couch_id']; ?>"><?php echo $couch['name']; ?></label>
                                                </div>
                                            <?php endforeach;
                                            unset($couch);?>
                                        </div>
                                    </div>
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
