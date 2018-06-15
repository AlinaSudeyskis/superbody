<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="anketa_form_line parent">
    <div class="anketa_form_h"><div class="anketa_form_h_cell">Наименование:</div></div>
    <input type="text" name="i_name" value="<?php if(!empty($ingestion['name'])): echo $ingestion['name']; endif; ?>" class="anketa_form_in anketa_form_in_long" maxlength="255" />
</div>
<div class="anketa_form_line parent">
    <div class="anketa_form_h"><div class="anketa_form_h_cell">Диапазон времени:</div></div>
    <div class="anketa_form_three_all parent">
        <div class="anketa_form_three_wrap">
            <select name="s_ing_time_from" class="anketa_form_select">
                <?php for($i = 6; $i <= 22; $i++): ?>
                    <option value="<?php echo $i; ?>:00"
                        <?php if(!empty($ingestion['time_from']) and $ingestion['time_from'] == $i):?>selected="selected"<?php endif; ?>
                    ><?php echo $i; ?>:00</option>
                <?php endfor;
                unset($i);?>
            </select>
        </div>
        <div class="anketa_form_three_wrap">
            <select name="s_ing_time_to" class="anketa_form_select">
                <?php for($i = 7; $i <= 23; $i++): ?>
                    <option value="<?php echo $i; ?>:00"
                        <?php if(!empty($ingestion['time_to']) and $ingestion['time_to'] == $i):?>selected="selected"<?php endif; ?>
                    ><?php echo $i; ?>:00</option>
                <?php endfor;
                unset($i);?>
            </select>
        </div>
    </div>
</div>

<!--<div class="parent kurs_cur_wrap">
    <div class="kurs_block_h">Наименование:</div>
    <input type="text" name="name" class="admin_form_txt admin_form_txt_middle" value="" maxlength="255" required="required" />
</div>
<div class="parent kurs_cur_wrap">
    <div class="kurs_block_h">Тип приема пищи:</div>
    <select name="s_ing_type" class="journal_form_select">
        <?php /*if (!empty($types)) :
            foreach ($types as $type) :*/?>
                <option value="<?php /*echo $type['id']; */?>"><?php /*echo $type['name']; */?></option>
            <?php /*endforeach;
            unset($type);
        endif;*/?>
    </select>
</div>
<div class="parent kurs_cur_wrap">
    <div class="kurs_block_h">Время приема:</div>
    <select name="s_time_additives" class="journal_form_select">
        <option value="" selected="selected">На протяжении дня</option>
        <option value="before">До тренировки</option>
        <option value="after">После тренировки</option>
    </select>
</div>
<div class="parent kurs_cur_wrap">
    <div class="kurs_block_h">
        Часы приема:
        <div class="h_subtitle">(Прим.: за 3 часа до тренировки)</div>
    </div>
    <input type="text" name="time_additives" value="" id="time_additives" class="admin_form_txt admin_form_txt_short"/>
</div>-->
