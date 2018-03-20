<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="anketa_block_item">
    <div class="anketa_block_item_cont">
        <input type="hidden" name="course_id" value="<?php echo $course['id']; ?>" id="c-id"/>
        <?php if (!empty($course['image'])) : ?>
            <img src="<?php echo $course['image']; ?>" alt=""/>
        <?php endif;?>
        <div class="add_foto_block_wrap">
            <div class="add_foto_block">
                <div class="video_down_line parent">
                    <div class="video_down_line_h">Изображение:</div>
                    <div class="video_down_line_but_wrap">
                        <label for="video_down_line_but1cs" class="video_down_line_but">
                            <input type="file" name="course_image" class="admin_form_videofile" id="video_down_line_but1cs" accept="image/jpeg,image/png" />
                            <span>Выберите файл</span>
                        </label>
                    </div>
                    <div class="video_down_line_name">Файл не выбран</div>
                    <div class="progressbar_wrap">
                        <progress class="progressbar" id="progressbar1" value="50" max="100"></progress>
                    </div>
                </div>
            </div>
        </div>
        <input type="text" name="name" class="admin_form_txt" placeholder="Введите наименование" value="<?php if (!empty($course['name'])) : echo $course['name']; endif;?>" required="required"/>
        <input type="text" name="description" class="admin_form_txt" placeholder="Введите описание" value="<?php if (!empty($course['description'])) : echo $course['description']; endif;?>" required="required" />
        <div class="parent kurs_cur_wrap">
            <div class="practice_block_h">Стоимость курса</div>
            <input type="text" name="price" class="admin_form_txt admin_form_txt_short" placeholder="Стоимость курса" value="<?php if (!empty($course['price'])) : echo $course['price']; endif;?>" required="required" />
            <div class="kurs_cur">Руб.</div>
        </div>

        <div class="content_block new_content_block ovv content_block_internal">
            <div class="content_block_h parent">
                <h3>Рекуррентный платеж</h3>
                <div class="content_block_h_buts">
                    <div class="content_block_h_slide price_slide"></div>
                </div>
            </div>
            <div class="kurs_block_val">
                <div class="anketa_block_cont">
                    <div class="admin_form_h">Стоимость курса по рекуррентной схеме</div>
                    <div class="parent kurs_cur_wrap">
                        <input type="text" name="i_recurrent_price" class="admin_form_txt admin_form_txt_short"
                               placeholder="Стоимость курса по рекуррентной схеме" id="recurrent-price"
                               value="<?php if (!empty($course['recur_price'])) : echo $course['recur_price']; endif;?>" />
                        <div class="kurs_cur">Руб.</div>
                    </div>
                    <div class="admin_form_h">Количество месяцев, на которое разбивается платеж</div>
                    <select name="s_recurrent_months" class="journal_form_select" id="recurrent-months">
                        <option value="">Выберите количество месяцев</option>
                        <?php for ($i = 1; $i <= 12; $i++) :?>
                            <option value="<?php echo $i;?>"
                                <?php if (!empty($course['recur_months']) and $course['recur_months'] == $i) :?>selected="selected"<?php endif;?>
                            ><?php echo $i;?> мес.</option>
                        <?php endfor;?>
                    </select>
                    <div class="admin_form_h">Стоимость первого платежа</div>
                    <div class="parent kurs_cur_wrap">
                        <input type="text" name="i_recurrent_first" class="admin_form_txt admin_form_txt_short"
                               placeholder="Стоимость первого платежа" id="recurrent-first"
                               value="<?php if (!empty($course['recur_first'])) : echo $course['recur_first']; endif;?>" />
                        <div class="kurs_cur">Руб.</div>
                    </div>
                    <div class="admin_form_h">Стоимость последующих платежей</div>
                    <div class="parent kurs_cur_wrap">
                        <input type="text" name="i_subsequent_payments" class="admin_form_txt admin_form_txt_short"
                               placeholder="Стоимость последующих платежей" id="recurrent-subsequent" disabled="disabled"
                               value="<?php if (!empty($course['recur_subsequent'])) : echo $course['recur_subsequent']; endif;?>" />
                        <div class="kurs_cur">Руб.</div>
                    </div>
                </div>
            </div>
        </div>
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
        <div class="add_tov_in_total">
            <div class="add_tov_in couches">
                <input type="text" name="tren" class="admin_form_txt admin_form_txt_short" placeholder="Введите имя или ID тренера" />
                <div class="add_tov_list"></div>
            </div>
            <div class="add_tov_val">
                <?php if (!empty($course['couches'])) :
                    foreach($course['couches'] as $key => $couch) :?>
                        <div id="<?php echo $couch['id']; ?>tov" class="add_tov_val_item parent">
                            <a href="/profile/<?php echo $couch['id']; ?>" class="add_tov_val_cont parent"><span class="add_tov_val_h"><?php echo $couch['name']; ?></span></a>
                            <div class="add_tov_val_sale">
                                <div class="admin_form_h">Процент, %</div>
                                <input type="hidden" name="couches[<?php echo $couch['id']; ?>]" value="<?php echo $couch['id']?>"/>
                                <input type="text" name="couches_percent[<?php echo $couch['id']; ?>]" class="admin_form_txt" placeholder="20" value="<?php echo $couch['percent']; ?>"/>
                            </div>
                            <div class="del_tov"></div>
                        </div>
                    <?php endforeach;
                    unset($couch);
                endif;?>
            </div>
        </div>
        <div class="parent kurs_cur_wrap">
            <input type="text" name="count_weeks" class="admin_form_txt kurs_time_in admin_form_txt_short" placeholder="Введите длительность курса" value="<?php if (!empty($course['count_weeks'])) : echo $course['count_weeks']; endif;?>" />
            <div class="kurs_cur">(нед.)</div>
        </div>
        <div class="parent kurs_cur_wrap">
            <select name="count_days" class="journal_form_select kurs_length_in">
                <?php if (!empty($course['count_days'])) :?>
                    <option value="">Выберите количество тренировок</option>
                    <option value="1"
                            <?php if ($course['count_days'] == 1) :?>selected="selected"<?php endif;?>
                    >1 тренировка (по-умолчанию)</option>
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
                    <option value="1">1 тренировка (по-умолчанию)</option>
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
            <select name="s_count_rest" id="count_rest" class="journal_form_select">
                <?php if (!empty($course['count_rest']) and 0 <= $course['count_rest']) :?>
                    <option value="">Минимальный отдых между тренировками</option>
                    <option value="0" <?php if (0 == $course['count_rest']) :?>selected="selected"<?php endif;?>>
                        Без отдыха (по-умолчанию)</option>
                    <option value="1" <?php if (1 == $course['count_rest']) :?>selected="selected"<?php endif;?>>
                        Один день</option>
                    <option value="2" <?php if (2 == $course['count_rest']) :?>selected="selected"<?php endif;?>>
                        Два дня</option>
                    <option value="3" <?php if (3 == $course['count_rest']) :?>selected="selected"<?php endif;?>>
                        Три дня</option>
                <?php else:?>
                    <option value="" selected="selected">Минимальный отдых между тренировками</option>
                    <option value="0">Без отдыха (по-умолчанию)</option>
                    <option value="1">Один день</option>
                    <option value="2">Два дня</option>
                    <option value="3">Три дня</option>
                <?php endif;?>
            </select>
            <div class="kurs_cur">(дн.)</div>
        </div>
        <div class="parent instruction_block">
            <div class="practice_block_h">Инструктаж курса</div>
            <div class="add_tov_in_total">
                <div class="add_tov_in video">
                    <input type="text" name="video_instruction" class="admin_form_txt admin_form_txt_short" placeholder="Введите наименование или ID видео" autocomplete="off" />
                    <div class="add_tov_list"></div>
                </div>
                <div class="add_tov_val">
                    <div class="add_tov_val_item parent">
                        <?php if (!empty($course['instruction']['video_id'])) : ?>
                            <div id="<?php echo $course['instruction']['video_id']; ?>video" class="add_tov_val_item parent">
                                <div class="add_kurs_val_video_wrap parent">
                                    <a href="/administration/video/<?php echo $course['instruction']['video_id']; ?>" class="add_tov_val_cont parent"><span class="add_tov_val_h"><?php echo $course['instruction']['video_name']; ?></span></a>
                                    <div class="del_tov"></div>
                                </div>
                            </div>
                        <?php endif;?>
                    </div>
                </div>
                <input type="hidden" name="video_instruction" value="<?php echo $course['instruction']['video_id'];?>" id="id-video-instruction"/>
            </div>
        </div>

        <div class="parent block_wrap">
            <div class="practice_block_h">Тренировки курса</div>
            <div class="practice_block_table">
                <?php if (!empty($course['count_days'] and !empty($course['count_weeks']))) :
                    $i = 1;
                    for($tr_week = 1; $tr_week <= $course['count_weeks']; $tr_week++) :?>
                        <div class="practice_weeks">
                            <div class="practice_week"><span>Неделя</span> <?php echo $tr_week; ?></div>
                            <div class="practice_days">
                                <?php for($tr_day = 1; $tr_day <= $course['count_days']; $tr_day++) :?>
                                    <div class="practice_day" id="practice<?php echo $i; ?>">Т <?php echo $tr_day; ?></div>
                                <?php $i++;
                                endfor;
                                unset($tr_day);?>
                            </div>
                        </div>
                    <?php endfor;
                    unset($tr_week);
                else:?>
                    <span class="kurs_cur">Выберите длительность курса и количество тренировок в неделю</span>
                <?php endif;?>
            </div>
        </div>

        <div class="practice_block_wrap">
            <?php if (!empty($course['workouts'])) :
                foreach ($course['workouts'] as $num_workout => $workout) :
                    $workout2 = 1;?>
                    <div class="practice_block" id="practice<?php echo $num_workout; ?>_block">
                        <div class="practice_block_h">Тренировка №<?php echo $num_workout; ?></div>
                        <div class="add_tov_in_total">
                            <div class="add_tov_in video">
                                <input type="text" name="name_video[<?php echo $num_workout; ?>]" class="admin_form_txt admin_form_txt_short" placeholder="Введите наименование или ID видео" autocomplete="off" />
                                <div class="add_tov_list"></div>
                            </div>
                            <div class="add_tov_val">
                                <?php if ($workout['video_id'] > 0 and $workout['repeat_workout'] == 0) : ?>
                                    <div id="<?php echo $num_workout; ?>video" class="add_tov_val_item parent">
                                        <div class="add_kurs_val_video_wrap parent">
                                            <a href="/administration/video/<?php echo $workout['video_id']; ?>" class="add_tov_val_cont parent"><span class="add_tov_val_h"><?php echo $workout['video_name']; ?></span></a>
                                            <div class="del_tov"></div>
                                        </div>
                                    </div>
                                <?php endif;?>
                            </div>
                            <input type="hidden" name="id_video[<?php echo $num_workout;?>]" value="<?php echo $workout['video_id'];?>" id="id-video<?php echo $num_workout;?>"/>
                        </div>
                        <textarea name="ta_workout_desc[<?php echo $num_workout; ?>]" class="tov_form_textarea" placeholder="Введите описание тренировки"><?php echo $workout['description'];?></textarea>
                        <?php if ($num_workout > 1) :?>
                            <div class="tren_repeat_total">
                                <div class="tren_form_block_check_wrap">
                                    <input type="checkbox" name="cb_repeat_workout[<?php echo $num_workout; ?>]" class="tren_form_block_check" id="tren_form_block_check<?php echo $num_workout; ?>e"
                                           <?php if (0 < $workout['repeat_workout']) : ?>checked="checked"<?php endif; ?>
                                           value="<?php echo $num_workout; ?>" />
                                    <label for="tren_form_block_check<?php echo $num_workout; ?>e">Повтор тренировок</label>
                                </div>
                                <select name="s_repeat_workout[<?php echo $num_workout; ?>]" class="journal_form_select">
                                    <?php for ($w = 0; $w < $num_workout-1; $w++) :?>
                                        <option value="<?php echo $workout2; ?>"
                                                <?php if ($workout['repeat_workout'] == $workout2) :?>selected="selected"<?php endif; ?>
                                        >Тренировка №<?php echo $workout2; ?></option>
                                        <?php $workout2++;
                                    endfor;?>
                                </select>
                            </div>
                        <?php endif;?>
                    </div>
                <?php endforeach;
                unset($workout);
            endif;?>
        </div>
    </div>
</div>