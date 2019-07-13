<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="content" class="container">
    <div class="row">
        <div class="col-lg-2 left_sidebar">
            <?php include_once('./app_fold/views/coach/coach_menu.php'); ?>
        </div><!-- left_sidebar -->
        <div class="col-lg-10 content_col">
            <div class="content_block new_content_block">
                <div class="content_block_h parent">
                    <?php $course_name = (!empty($course['name'])) ? ' - ' . $course['name'] : ''; ?>
                    <h3>Курс <?php echo $course_name; ?></h3>
                    <div class="content_block_h_buts">
                        <div class="content_block_h_slide kurs_slide"></div>
                        <div class="content_block_h_close"></div>
                    </div>
                </div>
                <div class="kurs_block_val">
                    <?php if(!empty($course)):?>
                        <div class="anketa_block">
                            <div class="anketa_block_cont">
                                <div class="anketa_block_item">
                                    <div class="anketa_block_item_h"><?php echo $course['description']; ?></div>
                                    <div class="anketa_block_item_cont">
                                        <form action="" method="post" class="anketa_form">
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
                                                <div class="anketa_form_desk">дн./нед.</div>
                                            </div>
                                            <div class="anketa_form_line parent">
                                                <div class="anketa_form_h"><div class="anketa_form_h_cell">Стоимость курса:</div></div>
                                                <div class="anketa_form_h"><div class="anketa_form_h_cell"><?php if (!empty($course['price'])) { echo $course['price']; }?></div></div>
                                                <div class="anketa_form_desk">руб.</div>
                                            </div>
                                            <div class="anketa_form_line parent">
                                                <div class="anketa_form_h"><div class="anketa_form_h_cell">Процент тренера:</div></div>
                                                <div class="anketa_form_h"><div class="anketa_form_h_cell"><?php if (!empty($course['coach_percent'])) { echo $course['coach_percent']; }?></div></div>
                                                <div class="anketa_form_desk">%</div>
                                            </div>
                                            <?php /*
                                            <div class="anketa_form_line parent">
                                                <div class="anketa_form_h"><div class="anketa_form_h_cell">Скидка тренера на курс:</div></div>
                                                <div class="anketa_form_h"><div class="anketa_form_h_cell">
                                                        <input type="number" name="coach_discount" class="tov_number" value="<?php echo $course['coach_discount']; ?>" min="0" max="<?php echo $course['coach_percent']; ?>" step="0.1"/>
                                                    </div></div>
                                                <div class="anketa_form_desk">%</div>
                                            </div>
                                            <div class="anketa_form_buts_wrap parent">
                                                <input type="submit" name="bt_save_course" value="Сохранить" class="anketa_form_but" />
                                            </div> */ ?>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <h3 class="info">Информация не найдена</h3>
                    <?php endif; ?>
                </div>
            </div>
        </div><!-- content_col -->
    </div>
</div><!-- content -->
