<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="parent kurs_cur_wrap">
    <div class="kurs_block_h">Стоимость курса:</div>
    <?php if ($course['new_price'] == 0 and $course['price'] == 0):?>
        <div class="kurs_block_h">Бесплатно</div>
    <?php else:
        if (empty($course['new_price'])): ?>
            <div class="kurs_block_h"><?php echo $course['price']; ?></div>
        <?php elseif (!empty($course['new_price'])): ?>
            <div class="kurs_cur strikeout" id="course-price"><?php echo $course['price'];?></div>
            <div class="kurs_cur" id="course-new-price"><?php echo $course['new_price'];?></div>
        <?php endif;?>
        <div class="kurs_cur"> руб.</div>
    <?php endif;?>
</div>
<?php if ($course['price'] != 0 and $course['recurrent'] === true):?>
    <div class="parent kurs_cur_wrap">
        <div class="kurs_block_h"><label for="payment-options">Вариант оплаты:</label></div>
        <select name="s_payment_options" class="journal_form_select" required="required" id="payment-options">
            <option value="">Выберите вариант</option>
            <option value="full_payment">Полная оплата стоимости</option>
            <option value="installments">Разделить оплату на <?php echo $course['recur_months']; ?> мес.</option>
        </select>
    </div>
    <div class="line_parent" id="recurrent-block">
        <div class="parent kurs_cur_wrap">
            <div class="kurs_block_h"></div>
            <div class="kurs_block_h">Первый платеж:</div>
            <div class="kurs_cur"><?php echo $course['recur_first']; ?></div>
            <div class="kurs_cur"> руб.</div>
        </div>
        <div class="parent kurs_cur_wrap">
            <div class="kurs_block_h"></div>
            <div class="kurs_block_h">Последующие платежи:</div>
            <div class="kurs_cur"><?php echo $course['recur_subsequent']; ?></div>
            <div class="kurs_cur"> руб.</div>
        </div>
    </div>
<?php endif;
if($course['new_price'] != 0 or $course['price'] != 0):?>
    <div class="parent kurs_cur_wrap">
        <div class="kurs_block_h"><label for="payment-methods">Способ оплаты:</label></div>
        <select name="s_payment_method" class="journal_form_select" required="required" id="payment-methods">
            <option value="bank_card">Банковская карта</option>
            <option value="yandex_money">Яндекс.Деньги</option>
            <option value="sberbank">Сбербанк Онлайн</option>
            <option value="qiwi">QIWI Wallet</option>
            <option value="webmoney">Webmoney</option>
            <option value="alfabank">Альфа-Клик</option>
        </select>
    </div>
    <div class="parent kurs_cur_wrap" id="method-phone">
        <div class="kurs_block_h">Телефон:
            <div class="h_subtitle">(Прим. 79000000000)</div>
        </div>
        <input type="text" name="i_phone" value="" class="admin_form_txt admin_form_txt_short" />
    </div>
    <div class="parent kurs_cur_wrap" id="method-login">
        <div class="kurs_block_h">Логин:
            <div class="h_subtitle">(пользователя в Альфа-Клике)</div>
        </div>
        <input type="text" name="i_login" value="" class="admin_form_txt admin_form_txt_short" />
    </div>
<?php endif;?>
<div class="anketa_form_buts_wrap parent">
    <?php if (!empty($courses_id) and in_array($course['id'], $courses_id)): ?>
        <input type="submit" name="bought" value="Куплен" class="anketa_form_but disabled"/>
    <?php elseif ($course['new_price'] != 0 or $course['price'] != 0): ?>
        <input type="submit" name="bt_buy_course" value="Купить" class="anketa_form_but"/>
    <?php else: ?>
        <input type="submit" name="bt_buy_course" value='Добавить в "Мои курсы"' class="anketa_form_but"/>
    <?php endif; ?>
</div>

<?php if ($course['recurrent'] === true):?>
    <div class="h_subtitle">* Выбирая разделенние платежа на несколько частей, Вы соглашаетесь на сохранение данных оплаты. Последующие платежи будут проходить автоматически. Прервать оплату Вы можете написав администрации сайта.</div>
<?php endif?>
