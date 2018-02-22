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
                                    <?php endif;?>
                                    <div class="anketa_form_line parent">
                                        <div class="anketa_form_h"><div class="anketa_form_h_cell">Стоимость курса:</div></div>
                                        <?php if ($course['new_price'] != 0  or $course['price'] != 0):?>
                                            <div class="anketa_form_h"><div class="anketa_form_h_cell">
                                                <?php if (!empty($course['new_price']))
                                                {
                                                    echo '<s>' . $course['price'].'</s> ' . $course['new_price'].'<br/>';
                                                }
                                                else
                                                {
                                                    echo $course['price'].'<br/>';
                                                }?>
                                            </div></div>
                                            <div class="anketa_form_desk"> руб.</div>
                                        <?php else:?>
                                            <div class="anketa_form_h"><div class="anketa_form_h_cell">Бесплатно</div></div>
                                        <?php endif;?>
                                    </div>
                                    <div class="anketa_form_buts_wrap parent">
                                        <?php if (!empty($courses_id) and in_array($course['id'], $courses_id)): ?>
                                            <input type="submit" name="bought" value="Куплен" class="anketa_form_but disabled"/>
                                        <?php elseif ($course['new_price'] != 0  or $course['price'] != 0): ?>
                                            <input type="submit" name="bt_buy_course" value="Купить" class="anketa_form_but"/>
                                        <?php else: ?>
                                            <input type="submit" name="bt_buy_course" value='Добавить в "Мои курсы"' class="anketa_form_but"/>
                                        <?php endif; ?>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- content_col -->

<!--<div id="body">
    <form action="" method="post">
        <div class="line">
            <h3><?php /*if (!empty($course['name'])) { echo $course['name']; }*/?></h3>
        </div>
        <div class="line">
            <b><?php /*if (!empty($course['description'])) { echo $course['description']; }*/?></b>
        </div>
        <div class="line">
            <div class="input_name">Длительность курса:</div>
            <div class="input_value">
                <input type="hidden" name="count_weeks" id="count_weeks" value="<?php /*if (!empty($course['count_weeks'])) { echo $course['count_weeks']; }*/?>" />
                <input type="hidden" name="count_days" id="count_days" value="<?php /*if (!empty($course['count_days'])) { echo $course['count_days']; }*/?>" />
                <input type="hidden" name="count_rest" id="count_rest" value="<?php /*if (!empty($course['count_rest'])) { echo $course['count_rest']; }*/?>" />
                <?php /*if (!empty($course['count_weeks'])) { echo $course['count_weeks'].' нед.'; }*/?>
            </div>
        </div>
        <div class="line">
            <div class="input_name">Количество тренировок:</div>
            <div class="input_value">
                <?php /*if (!empty($course['count_days'])) { echo $course['count_days'].' дн./нед.'; }*/?>
            </div>
        </div>
        <?php /*if (!empty($course['couches'])) :*/?>
            <div class="line" id="user-couch">
                <div class="input_name">Тренеры:</div>
                <div class="input_value select_couch">
                    <input type="hidden" name="user_couch" value="" id="user-couch-id"/>
                    <?php /*foreach($course['couches'] as $key => $couch) :*/?>
                        <div class="select_input">
                            <?php /*echo $couch['name']; */?>
                            <input type="hidden" name="couch_id" value="<?php /*echo $couch['id']*/?>" id="couch-id"/>
                        </div>
                    <?php /*endforeach;
                    unset($couch);*/?>
                </div>
            </div>
        <?php /*endif; */?>
        <div class="line">
            <div class="input_name">Стоимость курса:</div>
            <div class="input_value">
                <?php /*if (!empty($course['price'])) {
                    if (!empty($course['new_price'])) {
                        echo '<s>' . $course['price'].' руб.</s> ' . $course['new_price'].' руб.<br/>';
                    } else {
                        echo $course['price'].' руб. <br/>';
                    }
                }
                if (!empty($course['fc_price'])) {
                    if (!empty($course['new_fc_price'])) {
                        echo '<s>' . $course['fc_price'].' FC</s> ' . $course['new_fc_price'].' FC<br/>';
                    } else {
                        echo $course['fc_price'].' руб. <br/>';
                    }
                }*/?>
            </div>
        </div>
        <?php /*if (!empty($user_session['id'])) :*/?>
            <div id="week_days">
                <div class="line" id="training_days">
                    <div class="input_name">Дни недели тренировок:</div>
                    <div class="input_value long week_day">
                        <div class="cb_week_day">
                            <input type="checkbox" name="cb_day[]" value="1" id="cb_monday"/><label for="cb_monday">Пн.</label>
                        </div>
                        <div class="cb_week_day">
                            <input type="checkbox" name="cb_day[]" value="2" id="cb_tuesday"/><label for="cb_tuesday">Вт.</label>
                        </div>
                        <div class="cb_week_day">
                            <input type="checkbox" name="cb_day[]" value="3" id="cb_wednesday"/><label for="cb_wednesday">Ср.</label>
                        </div>
                        <div class="cb_week_day">
                            <input type="checkbox" name="cb_day[]" value="4" id="cb_thursday"/><label for="cb_thursday">Чт.</label>
                        </div>
                        <div class="cb_week_day">
                            <input type="checkbox" name="cb_day[]" value="5" id="cb_friday"/><label for="cb_friday">Пт.</label>
                        </div>
                        <div class="cb_week_day">
                            <input type="checkbox" name="cb_day[]" value="6" id="cb_saturday"/><label for="cb_saturday">Сб.</label>
                        </div>
                        <div class="cb_week_day">
                            <input type="checkbox" name="cb_day[]" value="7" id="cb_sunday"/><label for="cb_sunday">Вс.</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="line">
                <?php /*if (!empty($courses_id) and in_array($course['id'], $courses_id)) : */?>
                    <input type="submit" name="bt_buy_course" value="Куплено" class="bought"/>
                <?php /*else : */?>
                    <input type="submit" name="bt_buy_course" value="Купить"/>
                <?php /*endif; */?>
            </div>
        <?php /*endif; */?>
    </form>
</div>-->
