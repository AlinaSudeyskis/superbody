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
                <div class="parent kurs_cur_wrap">
                    <div class="kurs_block_h">Категория:</div>
                    <select name="s_course_type" class="journal_form_select">
                        <?php if (!empty($types)) :
                            foreach ($types as $type) :?>
                                <option value="<?php echo $type['id'];?>"
                                        <?php if (!empty($course['type']) and $course['type'] == $type['id']) :?>selected="selected"<?php endif;?>
                                ><?php echo $type['name'];?></option>
                            <?php endforeach;
                            unset($type);
                        endif;?>
                    </select>
                </div>
            </div>
        </div>
        <div class="parent kurs_cur_wrap">
            <div class="kurs_block_h">Наименование:</div>
            <textarea name="name" class="journal_form_textarea admin_form_txt_middle" placeholder="Введите наименование"
                      required="required"><?php if (!empty($course['name'])) : echo $course['name']; endif;?></textarea>
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
            <input type="text" name="count_weeks" class="admin_form_txt kurs_time_in kurs_form_txt_short" placeholder="Введите длительность курса"
                   value="<?php if (!empty($course['count_weeks'])) : echo $course['count_weeks']; endif;?>" />
            <div class="kurs_cur">(нед.)</div>
        </div>
        <div class="parent kurs_cur_wrap">
            <div class="kurs_block_h">Количество тренировок:</div>
            <select name="count_days" class="journal_form_select kurs_length_in">
                <?php if (!empty($course['count_days'])) :?>
                    <option value="">Выберите количество тренировок</option>
                    <option value="1"
                            <?php if ($course['count_days'] == 1) :?>selected="selected"<?php endif;?>
                    >1 тренировка (по умолчанию)</option>
                    <option value="2"
                            <?php if ($course['count_days'] == 2) :?>selected="selected"<?php endif;?>
                    >2 тренировки</option>
                    <option value="3"
                            <?php if ($course['count_days'] == 3) :?>selected="selected"<?php endif;?>
                    >3 тренировки</option>
                    <option value="4"
                            <?php if ($course['count_days'] == 4) :?>selected="selected"<?php endif;?>
                    >4 тренировки</option>
                    <option value="5"
                            <?php if ($course['count_days'] == 5) :?>selected="selected"<?php endif;?>
                    >5 тренировок</option>
                    <option value="6"
                            <?php if ($course['count_days'] == 6) :?>selected="selected"<?php endif;?>
                    >6 тренировок</option>
                    <option value="7"
                            <?php if ($course['count_days'] == 7) :?>selected="selected"<?php endif;?>
                    >7 тренировок</option>
                <?php else:?>
                    <option value="" selected="selected">Выберите количество тренировок</option>
                    <option value="1">1 тренировка (по умолчанию)</option>
                    <option value="2">2 тренировки</option>
                    <option value="3">3 тренировки</option>
                    <option value="4">4 тренировки</option>
                    <option value="5">5 тренировок</option>
                    <option value="6">6 тренировок</option>
                    <option value="7">7 тренировок</option>
                <?php endif;?>
            </select>
            <div class="kurs_cur">(дн./нед.)</div>
        </div>
        <div class="parent kurs_cur_wrap">
            <div class="kurs_block_h">Отдых:</div>
            <select name="s_count_rest" id="count_rest" class="journal_form_select">
                <?php if (!empty($course['count_rest']) and 0 <= $course['count_rest']) :?>
                    <option value="">Минимальный отдых между тренировками</option>
                    <option value="0" <?php if (0 == $course['count_rest']) :?>selected="selected"<?php endif;?>>
                        Без отдыха (по умолчанию)</option>
                    <option value="1" <?php if (1 == $course['count_rest']) :?>selected="selected"<?php endif;?>>
                        Один день</option>
                    <option value="2" <?php if (2 == $course['count_rest']) :?>selected="selected"<?php endif;?>>
                        Два дня</option>
                    <option value="3" <?php if (3 == $course['count_rest']) :?>selected="selected"<?php endif;?>>
                        Три дня</option>
                <?php else:?>
                    <option value="" selected="selected">Минимальный отдых между тренировками</option>
                    <option value="0">Без отдыха (по умолчанию)</option>
                    <option value="1">Один день</option>
                    <option value="2">Два дня</option>
                    <option value="3">Три дня</option>
                <?php endif;?>
            </select>
            <div class="kurs_cur">(дн.)</div>
        </div>
        <div class="parent kurs_cur_wrap">
            <div class="kurs_block_h">Стоимость курса:</div>
            <input type="text" name="price" class="admin_form_txt kurs_form_txt_short" placeholder="Стоимость курса" value="<?php if (!empty($course['db_price'])) : echo $course['db_price']; endif;?>" required="required" id="course-price"/>
            <div class="kurs_cur">Руб.</div>
        </div>
        <div class="content_block new_content_block ovv content_block_internal">
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
            <div class="kurs_block_h">Описание бесплатного курса:</div>
            <textarea name="ta_description_free" class="journal_form_textarea admin_form_txt_middle"
                      placeholder="" maxlength="15000"><?php echo $course['description_free']; ?></textarea>
        </div>
        <div class="add_tov_in_total">
            <div class="add_tov_in coaches">
                <div class="practice_block_h">Тренеры:</div>
                <input type="text" name="tren" class="admin_form_txt admin_form_txt_short" placeholder="Введите имя или ID тренера" />
                <div class="add_tov_list"></div>
            </div>
            <div class="add_tov_val">
                <?php $coaches_percent = 0;
                if (!empty($course['coaches'])) :
                    foreach($course['coaches'] as $key => $coach) :
                        $coaches_percent += $coach['percent']; ?>
                        <div id="<?php echo $coach['id']; ?>tov" class="add_tov_val_item parent">
                            <a href="/profile/<?php echo $coach['id']; ?>" class="add_tov_val_cont parent">
                                <span class="add_tov_val_h"><?php echo $coach['name']; ?></span>
                                <div class="del_tov"></div>
                            </a>
                            <div class="add_tov_val_sale">
                                <div class="admin_form_h">Процент, %</div>
                                <input type="hidden" name="coaches[<?php echo $coach['id']; ?>]" value="<?php echo $coach['id']?>"/>
                                <input type="text" name="coaches_percent[<?php echo $coach['id']; ?>]" class="admin_form_txt coaches_percent"
                                       placeholder="0" value="<?php echo $coach['percent']; ?>"/>
                            </div>
                        </div>
                    <?php endforeach;
                    unset($coach);
                endif;?>
            </div>
        </div>
        <?php if(!empty($course['coaches']) and $coaches_percent > 0): ?>
            <div class="parent kurs_cur_wrap">
                <div class="kurs_block_h">Процент сайта:</div>
                <?php $site_percent = 100 - $coaches_percent;
                $site_percent = ($site_percent > 0) ? $site_percent . '%' : 'Заработок отсутствует!'; ?>
                <div id="site-percent"><?php echo $site_percent; ?></div>
            </div>
        <?php endif; ?>
        <div class="practice_block_container">
            <div class="block_wrap">
                <div class="practice_block_h">Тренировки:</div>
                <div class="practice_block_table">
                    <?php include_once('./app_fold/views/course/settings/course_length_item.php'); ?>
                </div>
            </div>
            <div class="practice_block_wrap">
                <?php $count_workouts = $course['count_weeks'] * $course['count_days'];
                $allow_repeat_workouts = array();
                for ($num_workout = 1; $num_workout <= $count_workouts; $num_workout++) :
                    $workout2 = 1; ?>
                    <div class="practice_block" id="practice<?php echo $num_workout; ?>_block">
                        <div class="purchase_pop-up_close" style="opacity: 0.6;"></div>
                        <div class="practice_block_h">Тренировка №<?php echo $num_workout; ?></div>
                        <div class="add_tov_in_total">
                            <div class="add_tov_in video">
                                <input type="text" name="name_video[<?php echo $num_workout; ?>]" class="admin_form_txt"
                                       placeholder="Введите наименование или ID видео" autocomplete="off" />
                                <div class="add_tov_list"></div>
                            </div>
                            <div class="add_tov_val">
                                <?php if ($course['workouts'][$num_workout]['video_id'] > 0 and $course['workouts'][$num_workout]['repeat_workout'] == 0) : ?>
                                    <div id="<?php echo $num_workout; ?>video" class="add_tov_val_item parent">
                                        <div class="add_kurs_val_video_wrap parent">
                                            <a href="/administration/course/<?php echo $course['id']; ?>/video/<?php echo $course['workouts'][$num_workout]['video_id']; ?>" class="add_tov_val_cont parent">
                                                <span class="add_tov_val_h"><?php echo $course['workouts'][$num_workout]['video_name']; ?></span>
                                            </a>
                                            <div class="del_tov"></div>
                                        </div>
                                    </div>
                                <?php endif;?>
                            </div>
                            <input type="hidden" name="id_video[<?php echo $num_workout;?>]" value="<?php echo $course['workouts'][$num_workout]['video_id'];?>" id="id-video<?php echo $num_workout;?>"/>
                        </div>
                        <textarea name="ta_workout_desc[<?php echo $num_workout; ?>]" class="tov_form_textarea" placeholder="Введите описание тренировки"><?php echo $course['workouts'][$num_workout]['description'];?></textarea>
                        <?php /*if ($num_workout > 1) :*/?>
                            <!--<div class="tren_repeat_total">
                                <div class="tren_form_block_check_wrap">
                                    <input type="checkbox" name="cb_repeat_workout[<?php /*echo $num_workout; */?>]" class="tren_form_block_check" id="tren_form_block_check<?php /*echo $num_workout; */?>e"
                                           <?php /*if (0 < $course['workouts'][$num_workout]['repeat_workout']) : */?>checked="checked"<?php /*endif; */?>
                                           value="<?php /*echo $num_workout; */?>" />
                                    <label for="tren_form_block_check<?php /*echo $num_workout; */?>e">Повтор тренировок</label>
                                </div>
                                <select name="s_repeat_workout[<?php /*echo $num_workout; */?>]" class="journal_form_select">-->
                                    <?php /*for ($w = 0; $w < $num_workout-1; $w++) :*/?><!--
                                        <option value="<?php /*echo $workout2; */?>"
                                                <?php /*if ($course['workouts'][$num_workout]['repeat_workout'] == $workout2) :*/?>selected="selected"<?php /*endif; */?>
                                        >Тренировка №<?php /*echo $workout2; */?></option>
                                        --><?php /*$workout2++;
                                    endfor;*/?>
                                    <?php /*foreach ($allow_repeat_workouts as $arw) :*/?><!--
                                        <option value="<?php /*echo $arw; */?>"
                                                <?php /*if ($course['workouts'][$num_workout]['repeat_workout'] == $arw) :*/?>selected="selected"<?php /*endif; */?>
                                        >Тренировка №<?php /*echo $arw; */?></option>
                                    --><?php /*endforeach;
                                    unset($arw);*/ ?>
                                <!--</select>
                            </div>-->
                        <?php /*endif;*/?>
                        <?php if ($course['workouts'][$num_workout]['video_id'] > 0 and $course['workouts'][$num_workout]['repeat_workout'] == 0):
                            $allow_repeat_workouts[$num_workout] = $num_workout;
                        endif; ?>
                    </div>
                <?php endfor;?>
            </div>
        </div>
    </div>
</div>