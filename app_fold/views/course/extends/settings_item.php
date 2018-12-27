<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="parent kurs_cur_wrap">
    <div class="kurs_block_h">Курс:</div>
    <?php if(empty($extend)):?>
        <select name="s_extend_course" class="journal_form_select">
            <?php foreach($potentially_extends as $pe): ?>
                <option value="<?php echo $pe['id']; ?>"><?php echo $pe['name']; ?></option>
            <?php endforeach;
            unset($pe);?>
        </select>
    <?php else: ?>
        <div class="anketa_block_item_h"><?php echo $extend['extend_name']; ?></div>
    <?php endif; ?>
</div>
<div class="parent kurs_cur_wrap">
    <div class="kurs_block_h">Кол-во недель:
        <div class="h_subtitle">(после окончания курса)</div>
    </div>
    <input type="number" name="i_weeks_after" step="1" min="1" class="anketa_form_in anketa_form_in_long"
           value="<?php if(!empty($extend)): echo $extend['weeks_after']; endif; ?>" required="required"/>
</div>
<div class="parent kurs_cur_wrap">
    <div class="kurs_block_h">Промокод:</div>
        <select name="s_promocode" class="journal_form_select" id="extends-promocode">
            <option value="0">Без промокода</option>
            <option value="new">Добавить промокод</option>
            <?php  if(!empty($promocodes)):
                foreach($promocodes as $code): ?>
                    <option value="<?php echo $code['id']; ?>"
                        <?php if(!empty($extend) and $extend['promocode_id'] == $code['id']): ?>selected="selected"<?php endif; ?>>
                        <?php echo '[' . $code['code'] . '] ' . $code['discount']. '% ' . $code['name'] . ' (' . $code['active_string'] . ')'; ?>
                    </option>
                <?php endforeach;
                unset($code);
            endif; ?>
        </select>
    <?php if(empty($promocodes)): ?>
        <div class="subscription_block_link"><a href="/administration/course/<?php echo $course_id; ?>/promocode/new" >Добавить промокод</a></div>
    <?php endif; ?>
</div>
<div id="bl-pc-sett">
    <?php $extend_new_promocode = true;
    include_once('./app_fold/views/promocodes/settings_item.php');
    ?>
</div>
