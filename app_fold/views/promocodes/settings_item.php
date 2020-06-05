<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php
$coach_promocode = ($page_menu == 'c_promocodes') ? true : false;
$disabled = ((!empty($promocode) and $promocode['id'] == 1)) ? 'disabled' : '';
?>
<script type="text/javascript">
    var pcs = <?php if(!empty($promocodes)): echo json_encode($promocodes); endif; ?>;
</script>
<div class="parent kurs_cur_wrap">
    <div class="kurs_block_h">Тип промокода:</div>
    <select name="s_use_category" class="journal_form_select">
        <option value="primary" <?php if(!empty($promocode['use_category']) and $promocode['use_category'] == 'primary'):?>selected="selected"<?php endif; ?>>Первичный</option>
        <option value="secondary" <?php if(!empty($promocode['use_category']) and $promocode['use_category'] == 'secondary'):?>selected="selected"<?php endif; ?>>Вторичный</option>
    </select>
</div>
<div class="parent kurs_cur_wrap">
    <div class="kurs_block_h">Наименование:</div>
    <input type="text" name="i_code_name" class="anketa_form_in anketa_form_in_long <?php echo $disabled; ?>" value="<?php if(!empty($promocode['name'])): echo $promocode['name']; endif; ?>" maxlength="255"/>
</div>
<div class="parent kurs_cur_wrap">
    <div class="kurs_block_h">Описание:</div>
    <input type="text" name="i_code_desc" class="anketa_form_in anketa_form_in_long" value="<?php if(!empty($promocode['description'])): echo $promocode['description']; endif; ?>" maxlength="255"/>
</div>
<div class="parent kurs_cur_wrap">
    <div class="practice_block_h">Скидка</div>
    <div class="h_subtitle" style="line-height: 15px;margin-top: 5px;"><b>ПРОЦЕНТ</b> - введите процент скидки, действующий в целом на курс.</div>
    <div class="h_subtitle" style="line-height: 15px;margin-top: 1px;"><b>РУБ</b> - введите сумму скидки в рублях, действующую в целом на курс.*</div>
    <div class="h_subtitle" style="line-height: 15px;margin-top: 1px;"><b>БЕСПЛАТНЫЕ НЕДЕЛИ</b> - введите количество бесплатных недель, которые будут доступны пользователю.</div>
    <div class="h_subtitle" style="line-height: 15px;margin-top: 1px;"><b>* ОТНОСИТЕЛЬНЫЙ ПРОЦЕНТ</b> - введите процент скидки, ограничивающий скидку в рублях, т.е. скидка в рублях не может превышать указанный процент.</div>
    <div class="h_subtitle" style="line-height: 15px;margin: 0 0 15px;"></div>
</div>
<div class="parent kurs_cur_wrap" id="pc-discount">
    <div class="kurs_block_h">Размер скидки:</div>
    <div class="kurs_block_two_all parent">
        <div class="anketa_form_two_wrap">
            <input type="text" name="i_code_discount" class="anketa_form_in" value="<?php if(!empty($promocode['discount'])): echo $promocode['discount']; endif; ?>"/>
        </div>
        <div class="anketa_form_two_wrap">
            <select name="s_discount_type" class="anketa_form_select <?php if($coach_promocode === true): echo 'disabled'; endif; ?>">
                <option value="percent" <?php if(!empty($promocode['discount_type']) and $promocode['discount_type'] == 'percent'): ?>selected="selected"<?php endif; ?>>Процент</option>
                <option value="currency" <?php if(!empty($promocode['discount_type']) and $promocode['discount_type'] == 'currency'): ?>selected="selected"<?php endif; ?>>Руб.</option>
                <option value="free_week" <?php if(!empty($promocode['discount_type']) and $promocode['discount_type'] == 'free_week'): ?>selected="selected"<?php endif; ?>>Бесплатные недели</option>
            </select>
        </div>
    </div>
</div>
<?php if(!empty($promocode['coach_course_id'])): ?>
    <div class="parent kurs_cur_wrap" id="coach-discount">
        <div class="kurs_block_h">Заработок:</div>
        <div class="kurs_block_h" id="diff-percent"><?php echo $promocode['coach_course_diff']; ?>%</div>
    </div>
<?php endif; ?>
<?php $display = (!empty($promocode) and $promocode['discount_type'] == 'currency') ? 'block' : 'none'; ?>
<div class="parent kurs_cur_wrap" style="display: <?php echo $display; ?>;" id="pc-relative-percent">
    <div class="kurs_block_h">Относительный %:</div>
    <?php $relative_percent = (!empty($promocode['relative_percent']) and empty($max_coach_percent)) ? $promocode['relative_percent'] : '';?>
    <input type="number" name="i_relative_percent" step="1" min="1" max="100" class="anketa_form_in anketa_form_in_long" value="<?php echo $relative_percent; ?>"/>
</div>
<?php if(empty($disabled)):?>
    <?php if($coach_promocode === false):?>
        <div class="parent kurs_cur_wrap">
            <div class="practice_block_h">Промокод</div>
        </div>
        <div class="parent kurs_cur_wrap">
            <div class="kurs_block_h">Кол-во промокодов:</div>
            <select name="s_pc_group_type" class="journal_form_select" id="s-pc-group-type">
                <option value="one" <?php if($promocode['group_id'] == 0): ?>selected="selected"<?php endif; ?>>Один промокод</option>
                <option value="several" <?php if($promocode['group_id'] > 0): ?>selected="selected"<?php endif; ?>>Группа промокодов</option>
            </select>
        </div>
    <?php endif; ?>
    <div class="parent kurs_cur_wrap" id="i-one-pc" <?php if(!empty($promocode['group_id']) and $promocode['group_id'] > 0): ?>style="display: none;"<?php endif; ?>>
        <div class="kurs_block_h">Промокод:</div>
        <div class="pc_generate_code">
            <input type="text" name="i_promocodes[<?php echo $promocode['id']; ?>]" class="anketa_form_in anketa_form_in_long width_160 i_promocodes" value="<?php if(!empty($promocode['code']) and empty($promocode['group_promocodes'])): echo $promocode['code']; endif; ?>" maxlength="25" id="generated-code"/>
            <input type="button" value="Сгенерировать" class="full_photo_comm_reset generate_code"/>
        </div>
    </div>
    <div class="parent kurs_cur_wrap" id="i-several-pc" <?php if(!empty($promocode['group_id']) and $promocode['group_id'] > 0): ?>style="display: block;"<?php endif; ?>>
        <div class="kurs_block_h">Введите кол-во:</div>
        <div class="pc_generate_code">
            <input type="text" name="i_pc_count" class="anketa_form_in anketa_form_in_long width_160" value="" maxlength="3" id="generate-count-codes"/>
            <input type="button" value="Сгенерировать" class="full_photo_comm_reset generate_code"/>
        </div>
    </div>
    <div class="parent kurs_cur_wrap" id="i-generated-codes" <?php if(!empty($promocode['group_id']) and $promocode['group_id'] > 0 and !empty($promocode['group_promocodes'])): ?>style="display: block;"<?php endif; ?>>
        <?php if(!empty($promocode['group_promocodes'])): ?>
            <?php foreach ($promocode['group_promocodes'] as $key => $g_pc): ?>
                <input type="text" name="i_promocodes[<?php echo $key; ?>]" class="anketa_form_in anketa_form_in_long i_promocodes" value="<?php echo $g_pc; ?>" maxlength="25">
            <?php endforeach;
            unset($g_pc); ?>
        <?php endif; ?>
    </div>
    <div class="parent kurs_cur_wrap" style="width: 510px;">
        <input type="button" name="bt_copy_promocodes" class="full_photo_comm_reset" value="Копировать" style="float: right; margin-right: 0;" onclick="copyPromocodes();">
        <script>
            function copyPromocodes() {
                var i_pcs = $(".i_promocodes");
                if(i_pcs.length > 0)
                {
                    var $tmp = $("<input>"), pcs = '';
                    $("body").append($tmp);
                    i_pcs.each(function(){
                        pcs += $( this ).val() + ' ';
                    });
                    $tmp.val(pcs).select();
                    document.execCommand("copy");
                    $tmp.remove();
                    $('input[name=bt_copy_promocodes]').val('Скопировано');
                    setTimeout(function () {
                        $('input[name=bt_copy_promocodes]').val('Копировать');
                    }, 1500)
                }
            }
        </script>
    </div>
<?php endif;?>
<div class="parent kurs_cur_wrap"><div class="practice_block_h">Период возможности использования промокода</div></div>
<div class="parent kurs_cur_wrap">
    <div class="kurs_block_h">Период действия:</div>
    <select name="s_pv_type" class="journal_form_select <?php echo $disabled; ?>" id="s-pv-type">
        <option value="unlimited" <?php if(!empty($promocode['validity_type']) and $promocode['validity_type'] == 'unlimited'):?>selected="selected"<?php endif; ?>>Не ограничен</option>
        <option value="date_range" <?php if(!empty($promocode['validity_type']) and $promocode['validity_type'] == 'date_range'):?>selected="selected"<?php endif; ?>>Диапазон дат</option>
    </select>
</div>
<div id="bl-pv" <?php if($promocode['validity_type'] == 'date_range'): ?>style="display: block;"<?php endif;?>>
    <div class="parent kurs_cur_wrap">
        <div class="kurs_block_h text_right">с:</div>
        <input type="date" name="i_validity_date_start" class="anketa_form_in anketa_form_in_long" value="<?php if(!empty($promocode['pv_date_start'])): echo $promocode['pv_date_start']; endif; ?>"/>
    </div>
    <div class="parent kurs_cur_wrap">
        <div class="kurs_block_h text_right">до:</div>
        <input type="date" name="i_validity_date_end" class="anketa_form_in anketa_form_in_long" value="<?php if(!empty($promocode['pv_date_end'])): echo $promocode['pv_date_end']; endif; ?>"/>
    </div>
</div>
<div class="parent kurs_cur_wrap">
    <div class="practice_block_h"></div>
    <div class="practice_block_h">Общее число использований промокода</div>
</div>
<div class="parent kurs_cur_wrap">
    <div class="kurs_block_h">Кол-во использований:</div>
    <select name="s_ua_type" class="journal_form_select <?php echo $disabled; ?>" id="s-ua-type">
        <option value="unlimited" <?php if(!empty($promocode['use_type']) and $promocode['use_type'] == 'unlimited'):?>selected="selected"<?php endif; ?>>Не ограничено</option>
        <option value="number" <?php if(!empty($promocode['use_type']) and $promocode['use_type'] == 'number'):?>selected="selected"<?php endif; ?>>Ограниченное число</option>
    </select>
</div>
<div class="parent kurs_cur_wrap" id="bl-ua-number" <?php if($promocode['use_type'] == 'number'): ?>style="display: block;"<?php endif;?>>
    <div class="kurs_block_h">Число использований:</div>
    <input type="number" name="i_ua_number" step="1" min="0" class="anketa_form_in anketa_form_in_long" value="<?php if(!empty($promocode['ua_number'])): echo $promocode['ua_number']; endif; ?>"/>
</div>
<div class="parent kurs_cur_wrap">
    <div class="practice_block_h"></div>
    <div class="practice_block_h">Число использований промокода одним пользователем</div>
</div>
<?php if($coach_promocode === false):?>
    <div class="parent kurs_cur_wrap" id="attach-to-user-search">
        <div class="kurs_block_h">Прикрепить к пользов.:</div>
        <div class="add_tov_in_total anketa_form_in_long" style="float: left;">
            <div class="add_tov_in pc_users">
                <input type="text" name="user_id" class="anketa_form_in anketa_form_in_long <?php echo $page_menu; ?>" placeholder="Введите ID пользователя" autocomplete="off">
                <div class="add_tov_list"></div>
            </div>
            <div class="add_tov_val">
                <?php if(!empty($promocode['attached_users'])): ?>
                    <?php foreach ($promocode['attached_users'] as $a_users):?>
                        <div id="<?php echo $a_users['id']; ?>tov" class="add_tov_val_item pc_users parent">
                            <input type="hidden" name="users[]" value="<?php echo $a_users['id']; ?>">
                            <a href="/profile/<?php echo $a_users['id']; ?>" class="add_tov_val_cont parent">
                                <span class="add_tov_val_h"><?php if(!empty($a_users['name'])): echo $a_users['name']; else: echo $a_users['email']; endif; ?></span>
                            </a>
                            <div class="del_tov"></div>
                        </div>
                    <?php endforeach;
                    unset($course);?>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php endif;?>
<div class="parent kurs_cur_wrap">
    <div class="kurs_block_h">Кол-во использований:</div>
    <select name="s_user_ua_type" class="journal_form_select <?php echo $disabled; ?>" id="s-user-ua-type">
        <option value="unlimited" <?php if(!empty($promocode['user_use_type']) and $promocode['user_use_type'] == 'unlimited'):?>selected="selected"<?php endif; ?>>Не ограничено</option>
        <option value="number" <?php if(!empty($promocode['user_use_type']) and $promocode['user_use_type'] == 'number'):?>selected="selected"<?php endif; ?>>Ограниченное число</option>
    </select>
</div>
<div class="parent kurs_cur_wrap" id="bl-user-ua-number" <?php if($promocode['user_use_type'] == 'number'): ?>style="display: block;"<?php endif;?>>
    <div class="kurs_block_h">Число использований:</div>
    <input type="number" name="i_user_ua_number" step="1" min="1" class="anketa_form_in anketa_form_in_long" value="<?php if(!empty($promocode['user_ua_number'])): echo $promocode['user_ua_number']; endif; ?>"/>
</div>
<?php if(empty($disabled)):?>
    <?php if(empty($extend_new_promocode) and $coach_promocode === false): ?>
        <div class="parent kurs_cur_wrap">
            <div class="practice_block_h"></div>
            <div class="practice_block_h">Курсы</div>
        </div>
        <div class="parent kurs_cur_wrap">
            <div class="kurs_block_h">Группы курсов:</div>
            <div class="anketa_form_radio_all parent mx_width">
                <div class="anketa_form_radio_wrap">
                    <input type="radio" name="r_courses_group" class="anketa_form_radio cg" value="all" id="cg-all"
                           <?php if(empty($promocode['type']) or $promocode['type'] == 'all'): ?>checked="checked"<?php endif; ?>>
                    <label for="cg-all">Все курсы</label>
                </div>
                <div class="anketa_form_radio_wrap">
                    <input type="radio" name="r_courses_group" class="anketa_form_radio cg" value="courses" id="cg-few"
                           <?php if($promocode['type'] == 'course' or $promocode['type'] == 'courses'): ?>checked="checked"<?php endif; ?>>
                    <label for="cg-few">Некоторые курсы</label>
                </div>
                <div class="anketa_form_radio_wrap">
                    <input type="radio" name="r_courses_group" class="anketa_form_radio cg" value="workouts" id="cg-workouts"
                           <?php if($promocode['type'] == 'workouts'): ?>checked="checked"<?php endif; ?>>
                    <label for="cg-workouts">Курсы тренировок</label>
                </div>
                <div class="anketa_form_radio_wrap">
                    <input type="radio" name="r_courses_group" class="anketa_form_radio cg" value="nutritions" id="cg-nutr"
                           <?php if($promocode['type'] == 'nutritions'): ?>checked="checked"<?php endif; ?>>
                    <label for="cg-nutr">Курсы питания</label>
                </div>
                <?php if(!empty($types)):?>
                    <div class="anketa_form_radio_wrap">
                        <input type="radio" name="r_courses_group" class="anketa_form_radio cg" value="categories" id="cg-categories"
                               <?php if($promocode['type'] == 'categories'): ?>checked="checked"<?php endif; ?>>
                        <label for="cg-categories">Категории курсов</label>
                    </div>
                <?php endif;?>
            </div>
        </div>
        <?php if(!empty($types)):?>
            <div class="parent kurs_cur_wrap" id="cg-cats" <?php if($promocode['type'] != 'categories'): ?>style="display: none;"<?php endif; ?>>
                <div class="kurs_block_h">
                    Категории курсов:
                    <div class="h_subtitle" style="line-height: 15px;margin-top: 0;"><b>Ctrl + Левая кнопка мыши</b> - выбор нескольких категорий</div>
                </div>
                <select name="s_courses_categories[]" class="journal_form_select" multiple>
                    <?php foreach($types as $type):?>
                        <option value="<?php echo $type['id']; ?>" <?php if(!empty($promocode['courses_categories']) and in_array($type['id'], $promocode['courses_categories'])):?>selected="selected"<?php endif; ?>><?php echo $type['name']; ?></option>
                    <?php endforeach;
                    unset($type); ?>
                </select>
            </div>
        <?php endif; ?>
        <div class="parent kurs_cur_wrap" id="cg-few-search" <?php if($promocode['type'] != 'course' and $promocode['type'] != 'courses'): ?>style="display: none;"<?php endif; ?>>
            <div class="kurs_block_h">Поиск курсов:</div>
            <div class="add_tov_in_total anketa_form_in_long" style="float: left;">
                <div class="add_tov_in pc_course">
                    <input type="text" name="name_course" class="admin_form_txt <?php echo $page_menu; ?>" placeholder="Введите наименование или ID курса" autocomplete="off">
                    <div class="add_tov_list"></div>
                </div>
                <div class="add_tov_val">
                    <?php if(!empty($promocode['courses'])): ?>
                        <?php foreach ($promocode['courses'] as $course):?>
                            <div id="pc-course-<?php echo $course['id']; ?>course" class="add_tov_val_item pc_course parent">
                                <div class="add_kurs_val_video_wrap parent">
                                    <a href="/administration/course/<?php echo $course['id']; ?>" class="add_tov_val_cont parent"><span class="add_tov_val_h"><?php echo $course['name']; ?></span></a>
                                    <input type="hidden" name="pc_courses[]" value="<?php echo $course['id']; ?>" >
                                    <div class="del_tov"></div>
                                </div>
                            </div>
                        <?php endforeach;
                        unset($course);?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php elseif($coach_promocode === true and !empty($courses)): ?>
        <div class="parent kurs_cur_wrap">
            <div class="practice_block_h">Курсы</div>
        </div>
        <div class="block_radio_all parent coach_courses">
            <?php foreach($courses as $course): ?>
                <div class="block_radio_wrap">
                    <input type="hidden" name="coach_crs_per[<?php echo $course['id']; ?>]" id="c-crs-per<?php echo $course['id']; ?>" value="<?php echo $course['coach_percent']; ?>">
                    <input type="radio" name="promo_coach_course" class="block_radio" value="<?php echo $course['id']; ?>" id="promo_coach_course_<?php echo $course['id']; ?>"
                           <?php if(!empty($promocode['coach_course_id']) and $course['id'] == $promocode['coach_course_id']): ?>checked="checked"<?php endif; ?>>
                    <label for="promo_coach_course_<?php echo $course['id']; ?>"><?php echo $course['name']; ?></label>
                </div>
            <?php endforeach;
            unset($course); ?>
        </div>
    <?php endif;?>
    <div class="parent kurs_cur_wrap"><div class="practice_block_h"></div></div>
    <?php if(!empty($used_amount)): ?>
        <div class="parent kurs_cur_wrap">
            <div class="kurs_block_h">Использовано:</div>
            <div class="kurs_block_h"><?php echo $used_amount; ?> раз</div>
        </div>
    <?php elseif(!empty($promocode)): ?>
        <div class="parent kurs_cur_wrap">
            <div class="kurs_block_h">Использовано:</div>
            <div class="kurs_block_h">Не использовался</div>
        </div>
    <?php endif; ?>
<?php endif;?>