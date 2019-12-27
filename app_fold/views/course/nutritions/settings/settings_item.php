<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="anketa_block_item">
    <div class="anketa_block_item_cont">
        <input type="hidden" name="course_id" value="<?php echo $course['id']; ?>" id="c-id"/>
        <div class="parent kurs_cur_wrap" style="margin-bottom: 18px;">
            <div class="tren_set_form_l">
                <div class="tren_set_form_img">
                    <?php if (!empty($course['image'])): ?>
                        <img src="<?php echo $course['image']; ?>" alt=""/>
                    <?php else: ?>
                        <img src="/img/no_img.png" alt="">
                    <?php endif; ?>
                </div>
            </div>
            <div class="tren_set_form_r">
                <div class="parent kurs_cur_wrap">
                    <div class="kurs_block_h">Изображение:</div>
                    <div class="video_down_line parent">
                        <div class="video_down_line_but_wrap">
                            <label for="video_down_line_but1cs" class="video_down_line_but">
                                <input type="file" name="course_image" class="admin_form_videofile" id="video_down_line_but1cs" accept="image/jpeg,image/png" />
                                <span>Выберите файл</span>
                            </label>
                        </div>
                        <div class="video_down_line_name" style="width:calc(100% - 120px);">Файл не выбран</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="parent kurs_cur_wrap">
            <div class="kurs_block_h">Наименование:</div>
            <textarea name="name" class="journal_form_textarea admin_form_txt_middle" placeholder="Введите наименование" r
                      equired="required"><?php if (!empty($course['name'])) : echo $course['name']; endif;?></textarea>
        </div>
        <div class="parent kurs_cur_wrap">
            <div class="kurs_block_h">Описание:</div>
            <textarea name="description" class="journal_form_textarea admin_form_txt_middle" placeholder="Введите описание"
                      required="required"><?php if (!empty($course['description'])) : echo $course['description']; endif;?></textarea>
        </div>
        <div class="content_block new_content_block ovv content_block_internal meta">
            <div class="content_block_h parent">
                <h3>Метаданные</h3>
                <div class="content_block_h_buts">
                    <div class="content_block_h_slide meta_slide hide_chart"></div>
                </div>
            </div>
            <div class="kurs_block_val">
                <div class="anketa_block_cont">
                    <div class="parent kurs_cur_wrap">
                        <div class="kurs_block_h">Keywords:</div>
                        <textarea name="ta_meta_keywords" class="journal_form_textarea admin_form_txt_middle"
                                  placeholder=""><?php echo $course['meta_keywords']; ?></textarea>
                    </div>
                    <div class="parent kurs_cur_wrap">
                        <div class="kurs_block_h">Description:</div>
                        <textarea name="ta_meta_description" class="journal_form_textarea admin_form_txt_middle"
                                  placeholder=""><?php echo $course['meta_description']; ?></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="parent kurs_cur_wrap">
            <div class="kurs_block_h">Длительность курса:</div>
            <input type="text" name="count_weeks" class="admin_form_txt nutr_time_in kurs_form_txt_short"
                   placeholder="Введите длительность курса" value="<?php if (!empty($course['count_weeks'])) : echo $course['count_weeks']; endif;?>" />
            <div class="kurs_cur">(нед.)</div>
        </div>
        <div class="parent kurs_cur_wrap">
            <div class="kurs_block_h">Стоимость курса:</div>
            <input type="text" name="price" class="admin_form_txt kurs_form_txt_short" placeholder="Стоимость курса"
                   value="<?php if (!empty($course['db_price'])) : echo $course['db_price']; endif;?>" required="required" id="course-price"/>
            <div class="kurs_cur">Руб.</div>
        </div>
        <div class="content_block new_content_block ovv content_block_internal" style="max-width: 600px;">
            <div class="content_block_h parent">
                <h3>Рекуррентный платеж</h3>
                <div class="content_block_h_buts">
                    <div class="content_block_h_slide price_slide hide_chart"></div>
                </div>
            </div>
            <div class="kurs_block_val">
                <div class="anketa_block_cont">
                    <div class="parent kurs_cur_wrap">
                        <div class="kurs_block_h">Количество месяцев:</div>
                        <select name="s_recurrent_months" class="journal_form_select" id="recurrent-months">
                            <option value="">Выберите количество месяцев</option>
                            <?php for ($i = 1; $i <= 12; $i++) :?>
                                <option value="<?php echo $i;?>"
                                        <?php if (!empty($course['recur_months']) and $course['recur_months'] == $i) :?>selected="selected"<?php endif;?>
                                ><?php echo $i;?> мес.</option>
                            <?php endfor;?>
                        </select>
                    </div>
                    <div class="parent kurs_cur_wrap">
                        <div class="kurs_block_h">Первый платеж:</div>
                        <input type="text" name="i_recurrent_first" class="admin_form_txt kurs_form_txt_short"
                               placeholder="Стоимость первого платежа" id="recurrent-first"
                               value="<?php if (!empty($course['db_recur_first'])) : echo $course['db_recur_first']; endif;?>" />
                        <div class="kurs_cur">Руб.</div>
                    </div>
                    <div class="parent kurs_cur_wrap">
                        <div class="kurs_block_h">Последующие платежи:</div>
                        <input type="text" name="i_subsequent_payments" class="admin_form_txt kurs_form_txt_short"
                               placeholder="Стоимость последующих платежей" id="recurrent-subsequent" disabled="disabled"
                               value="<?php if (!empty($course['db_recur_subsequent'])) : echo $course['db_recur_subsequent']; endif;?>" />
                        <div class="kurs_cur">Руб.</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="parent kurs_cur_wrap">
            <div class="kurs_block_h">Приемы пищи:</div>
            <?php if(!empty($ingestions)):
                $prev_el = '';
                $count_ingestions = count($ingestions);?>
                <div class="tren_form_block_check_wrap ingestions">
                    <?php foreach($ingestions as $key => $ingestion):
                        $id_checked_ingestion = (!empty($course_ingestions_id)) ? array_search($ingestion['id'], $course_ingestions_id) : false;
                        $ci_time_from  = ($id_checked_ingestion !== false) ? $course_ingestions[$id_checked_ingestion]['time_from'] : '';
                        $ci_time_to    = ($id_checked_ingestion !== false) ? $course_ingestions[$id_checked_ingestion]['time_to'] : '';
                        $after = (empty($prev_el)) ? 'first' : $prev_el;
                        $after = ($key == ($count_ingestions-1)) ? 'last' : $after;
                        ?>
                        <div class="tren_form_block_check_wrap ingestion">
                            <input type="checkbox" name="cb_ingestions[<?php echo $ingestion['id']; ?>]" class="tren_form_block_check"
                                   id="tren_form_block_check_ing<?php echo $key;?>" value="<?php echo $ingestion['id']; ?>"
                                   data-after="<?php echo $after; ?>" data-name="<?php echo $ingestion['name']; ?>"
                                   <?php if(!empty($course_ingestions_id) and in_array($ingestion['id'], $course_ingestions_id)): ?>checked="checked"<?php endif; ?>
                            >
                            <label for="tren_form_block_check_ing<?php echo $key;?>"><?php echo $ingestion['name']; ?></label>
                            <div class="anketa_form_two_all parent">
                                <div class="anketa_form_two_wrap">
                                    <select name="s_ing_time_from[<?php echo $ingestion['id']; ?>]" class="anketa_form_select">
                                        <?php for($i = 6; $i <= 22; $i++):
                                            $ing_time_from = (!empty($ci_time_from)) ? $ci_time_from : $ingestion['time_from'];?>
                                            <option value="<?php echo $i; ?>:00"
                                                <?php if(!empty($ing_time_from) and $ing_time_from == $i):?>selected="selected"<?php endif; ?>
                                            ><?php echo $i; ?>:00</option>
                                        <?php endfor;
                                        unset($i);?>
                                    </select>
                                </div>
                                <div class="anketa_form_two_wrap">
                                    <select name="s_ing_time_to[<?php echo $ingestion['id']; ?>]" class="anketa_form_select">
                                        <?php for($i = 7; $i <= 23; $i++):
                                            $ing_time_to = (!empty($ci_time_to)) ? $ci_time_to : $ingestion['time_to'];?>
                                            <option value="<?php echo $i; ?>:00"
                                                    <?php if(!empty($ing_time_to) and $ing_time_to == $i):?>selected="selected"<?php endif; ?>
                                            ><?php echo $i; ?>:00</option>
                                        <?php endfor;
                                        unset($i);?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <?php $prev_el = $ingestion['id'];
                    endforeach;
                    unset($ingestion);?>
                </div>
            <?php endif; ?>
        </div>

        <div class="parent block_wrap">
            <div class="practice_block_h">Инструкция:</div>
            <div class="h_subtitle" style="margin-bottom: 15px;">
                <ul>
                    <li>Выберите приемы пищи.</li>
                    <li>Введите длительность курса.</li>
                    <li>Выберите один день, что бы отобразить информацию и добавить/изменить блюда приемов пищи на текущий день.</li>
                    <li>Выберите несколько дней, что бы отобразить пустые поля для добавления/изменения блюд приемов пищи выбранных дней. Новые блюда заменят добавленные до этого блюда.</li>
                </ul>
            </div>
        </div>
        <div class="parent block_wrap">
            <div class="nutrition_block_h">Меню:</div>
            <div class="nutrition_block_table">
                <?php include_once('./app_fold/views/course/nutritions/settings/course_length_item.php'); ?>
            </div>
        </div>
        <div class="nutrition_block_wrap">
            <?php if(is_numeric($course['count_weeks'])):
                for($day = 1; $day <= ($course['count_weeks']*7); $day++): ?>
                    <div class="nutrition_block" id="nutrition<?php echo $day; ?>_block" data-id="<?php echo $day; ?>">
                        <?php if(!empty($course_ingestions) and !empty($ingestions_id) and !empty($ingestions)):
                            foreach($course_ingestions as $ci):
                                $ing_id   = array_search($ci['id'], $ingestions_id);
                                $ing_name = $ingestions[$ing_id]['name'];?>
                                <div class="parent kurs_cur_wrap" id="crs-ingestion-<?php echo $day; ?>-<?php echo $ci['id']; ?>">
                                    <div class="kurs_block_h"><?php echo $ing_name; ?></div>
                                    <div class="add_tov_in_total">
                                        <div class="add_tov_in meal">
                                            <input type="text" name="name_meal[<?php echo $day; ?>]" data-day="<?php echo $day; ?>"
                                                   data-ingestion="<?php echo $ci['id']; ?>" class="admin_form_txt" placeholder="Введите наименование блюда" autocomplete="off" />
                                            <div class="add_tov_list"></div>
                                        </div>
                                        <div class="add_tov_val">
                                            <?php if(!empty($course_ml_types)):
                                                foreach($course_ml_types as $ml_type): ?>
                                                    <?php if(!empty($course_schedule[$day][$ci['id']][$ml_type['id']])):?>
                                                        <div id="ml-type-<?php echo $day; ?>-<?php echo $ci['id']; ?>-<?php echo $ml_type['id']; ?>">
                                                            <div class="kurs_block_h"><?php echo $ml_type['name']; ?></div>
                                                            <div class="add_tov_val_item_wrap">
                                                                <?php foreach($course_schedule[$day][$ci['id']][$ml_type['id']] as $key => $meal):
                                                                    if($meal['id'] != 0): ?>
                                                                        <div id="meal-<?php echo $day; ?>-<?php echo $ci['id']; ?>-<?php echo $ml_type['id']; ?>-<?php echo $meal['id']; ?>" class="add_tov_val_item parent">
                                                                            <div class="add_kurs_val_video_wrap parent">
                                                                                <a href="/administration/meal/<?php echo $meal['id']; ?>" class="add_tov_val_cont meal_cont parent">
                                                                                    <div class="add_tov_val_h"><?php echo $meal['name']; ?></div>
                                                                                    <div class="add_tov_val_sh">
                                                                                        <div class="meal_wpfcc_wrap">
                                                                                            <div class="meal_wpfcc">
                                                                                                <div class="meal_wpfcc_title" short="В">Вес</div>
                                                                                                <div class="meal_wpfcc_val"><?php echo $meal['weight']; ?></div>
                                                                                            </div>
                                                                                            <div class="meal_wpfcc">
                                                                                                <div class="meal_wpfcc_title" short="Б">Белки</div>
                                                                                                <div class="meal_wpfcc_val"><?php echo $meal['proteins']; ?></div>
                                                                                            </div>
                                                                                            <div class="meal_wpfcc">
                                                                                                <div class="meal_wpfcc_title" short="Ж">Жиры</div>
                                                                                                <div class="meal_wpfcc_val"><?php echo $meal['fats']; ?></div>
                                                                                            </div>
                                                                                            <div class="meal_wpfcc">
                                                                                                <div class="meal_wpfcc_title" short="У">Углеводы</div>
                                                                                                <div class="meal_wpfcc_val"><?php echo $meal['carbohydrates']; ?></div>
                                                                                            </div>
                                                                                            <div class="meal_wpfcc">
                                                                                                <div class="meal_wpfcc_title" short="К">Калории</div>
                                                                                                <div class="meal_wpfcc_val"><?php echo $meal['calories']; ?></div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </a>
                                                                                <div class="del_tov"></div>
                                                                            </div>
                                                                            <input type="hidden" name="id_meal[<?php echo $day; ?>][<?php echo $ci['id']; ?>][]" value="<?php echo $meal['id']; ?>"
                                                                                   id="id-meal-<?php echo $day; ?>-<?php echo $ci['id']; ?>-<?php echo $meal['id']; ?>"/>
                                                                        </div>
                                                                    <?php endif;
                                                                endforeach;
                                                                unset($meal);?>
                                                            </div>
                                                        </div>
                                                    <?php endif;?>
                                                <?php endforeach;
                                                unset($ml_type);
                                            endif;?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach;
                            unset($ci);
                        endif;?>
                    </div>
                <?php endfor;?>
                <div class="nutrition_block multiple" id="nutrition_multiple_block" data-id="multiple">
                    <?php if(!empty($course_ingestions) and !empty($ingestions_id) and !empty($ingestions)):
                        foreach($course_ingestions as $ci):
                            $ing_id   = array_search($ci['id'], $ingestions_id);
                            $ing_name = $ingestions[$ing_id]['name'];?>
                            <div class="parent kurs_cur_wrap" id="crs-ingestion-multiple-<?php echo $ci['id']; ?>">
                                <div class="kurs_block_h"><?php echo $ing_name; ?></div>
                                <div class="add_tov_in_total">
                                    <div class="add_tov_in meal">
                                        <input type="text" name="name_meal[multiple]" data-day="multiple"
                                               data-ingestion="<?php echo $ci['id']; ?>" class="admin_form_txt" placeholder="Введите наименование блюда" autocomplete="off" />
                                        <div class="add_tov_list"></div>
                                    </div>
                                    <div class="add_tov_val"></div>
                                </div>
                            </div>
                        <?php endforeach;
                        unset($ci);
                    endif;?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>