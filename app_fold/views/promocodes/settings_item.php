<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php if($page_menu == 'a_courses_w'): ?>
    <div class="parent kurs_cur_wrap">
        <div class="kurs_block_h">Категория:</div>
        <select name="s_category" class="journal_form_select">
            <option value="course" <?php if(!empty($promocode['category']) and $promocode['category'] == 'course'):?>selected="selected"<?php endif; ?>>Курс</option>
            <option value="extend" <?php if(!empty($promocode['category']) and $promocode['category'] == 'extend'):?>selected="selected"<?php endif; ?>>Курс продления</option>
        </select>
    </div>
<?php endif; ?>
<div class="parent kurs_cur_wrap">
    <div class="kurs_block_h">Наименование:</div>
    <input type="text" name="i_code_name" class="anketa_form_in anketa_form_in_long" value="<?php if(!empty($promocode['name'])): echo $promocode['name']; endif; ?>" maxlength="255"/>
</div>
<div class="parent kurs_cur_wrap">
    <div class="kurs_block_h">Описание:</div>
    <input type="text" name="i_code_desc" class="anketa_form_in anketa_form_in_long" value="<?php if(!empty($promocode['description'])): echo $promocode['description']; endif; ?>" maxlength="255"/>
</div>
<div class="parent kurs_cur_wrap">
    <div class="kurs_block_h">Скидка:</div>
    <input type="number" name="i_code_discount" step="0.01" min="0.01" max="100" class="anketa_form_in anketa_form_in_long" value="<?php if(!empty($promocode['discount'])): echo $promocode['discount']; endif; ?>" required="required"/>
    <div class="kurs_cur">%</div>
</div>
<div class="parent kurs_cur_wrap">
    <div class="kurs_block_h">Тип периода действия:</div>
    <select name="s_pv_type" class="journal_form_select">
        <option value="unlimited" <?php if(!empty($promocode['validity_type']) and $promocode['validity_type'] == 'unlimited'):?>selected="selected"<?php endif; ?>>Не ограничен</option>
        <option value="date_range" <?php if(!empty($promocode['validity_type']) and $promocode['validity_type'] == 'date_range'):?>selected="selected"<?php endif; ?>>Диапазон дат</option>
    </select>
</div>
<div class="parent kurs_cur_wrap">
    <div class="kurs_block_h">Период действия:</div>
</div>
<div class="parent kurs_cur_wrap">
    <div class="kurs_block_h" style="text-align: right;">с:</div>
    <input type="date" name="i_validity_date_start" class="anketa_form_in anketa_form_in_long" value="<?php if(!empty($promocode['pv_date_start'])): echo $promocode['pv_date_start']; endif; ?>"/>
</div>
<div class="parent kurs_cur_wrap">
    <div class="kurs_block_h" style="text-align: right;">до:</div>
    <input type="date" name="i_validity_date_end" class="anketa_form_in anketa_form_in_long" value="<?php if(!empty($promocode['pv_date_end'])): echo $promocode['pv_date_end']; endif; ?>"/>
</div>
<div class="parent kurs_cur_wrap">
    <div class="kurs_block_h">Кол-во использований:</div>
    <select name="s_ua_type" class="journal_form_select">
        <option value="unlimited" <?php if(!empty($promocode['use_type']) and $promocode['user_type'] == 'unlimited'):?>selected="selected"<?php endif; ?>>Не ограничено</option>
        <option value="number" <?php if(!empty($promocode['use_type']) and $promocode['use_type'] == 'number'):?>selected="selected"<?php endif; ?>>Число</option>
    </select>
</div>
<div class="parent kurs_cur_wrap">
    <div class="kurs_block_h">Число использований:</div>
    <input type="number" name="i_ua_number" step="1" min="0" class="anketa_form_in anketa_form_in_long" value="<?php if(!empty($promocode['ua_number'])): echo $promocode['ua_number']; endif; ?>"/>
</div>
<div class="parent kurs_cur_wrap">
    <div class="kurs_block_h">Промокод:</div>
    <input type="text" name="i_promocode" class="anketa_form_in anketa_form_in_long" value="<?php if(!empty($promocode['code'])): echo $promocode['code']; endif; ?>" maxlength="25" id="generated-code" required="required"/>
    <input type="button" value="Сгенерировать" class="full_photo_comm_reset" id="generate-code"/>
</div>
<?php if(!empty($used_amount)): ?>
    <div class="parent kurs_cur_wrap">
        <div class="kurs_block_h">Кол-во использования:</div>
        <div class="kurs_block_h"><?php echo $used_amount; ?> раз</div>
    </div>
<?php endif; ?>
