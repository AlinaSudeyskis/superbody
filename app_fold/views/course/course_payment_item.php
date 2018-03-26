<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="anketa_form_line parent">
    <div class="anketa_form_h">
        <div class="anketa_form_h_cell">Стоимость курса:</div>
    </div>
    <?php if ($course['new_price'] == 0 and $course['price'] == 0):?>
        <div class="anketa_form_h"><div class="anketa_form_h_cell">Бесплатно</div></div>
    <?php else:
        if (empty($course['new_price'])): ?>
            <div class="anketa_form_h"><div class="anketa_form_h_cell"><?php echo $course['price']; ?></div></div>
        <?php elseif (!empty($course['new_price'])): ?>
            <div class="anketa_form_h" id="course-price"><div class="anketa_form_h_cell strikeout"><?php echo $course['price'];?></div></div>
            <div class="anketa_form_desk" id="course-new-price"><?php echo $course['new_price'];?></div>
        <?php endif;?>
        <div class="anketa_form_desk"> руб.</div>
    <?php endif;?>
</div>
<?php if ($course['price'] != 0 and $course['recurrent'] === true):?>
    <div class="anketa_form_line parent">
        <div class="anketa_form_h">
            <div class="anketa_form_h_cell"><label for="payment-options">Вариант оплаты:</label></div>
        </div>
        <div class="anketa_form_h">
            <div class="anketa_form_h_cell">
                <select name="s_payment_options" class="journal_form_select long" required="required" id="payment-options">
                    <option value="">Выберите вариант</option>
                    <option value="full_payment">Полная оплата стоимости</option>
                    <option value="installments">Разделить оплату на <?php echo $course['recur_months']; ?> мес.</option>
                </select>
            </div>
        </div>
    </div>
    <div class="line_parent" id="recurrent-block">
        <!--<div class="anketa_form_line parent">
                <div class="anketa_form_h">
                    <div class="anketa_form_h_cell">Стоимость курса:</div>
                    <div class="h_subtitle">(разделить оплату на <?php /*echo $course['recur_months']; */?> мес.*)</div>
                </div>
                <div class="anketa_form_h"><div class="anketa_form_h_cell"><?php /*echo $course['recur_price'];*/ ?></div></div>
                <div class="anketa_form_desk"> руб.</div>
            </div>-->
        <div class="anketa_form_line parent">
            <div class="anketa_form_h"><div class="anketa_form_h_cell"></div></div>
            <div class="anketa_form_h"><div class="anketa_form_h_cell">Первый платеж:</div></div>
            <div class="anketa_form_desk"><?php echo $course['recur_first']; ?></div>
            <div class="anketa_form_desk"> руб.</div>
        </div>
        <div class="anketa_form_line parent">
            <div class="anketa_form_h"><div class="anketa_form_h_cell"></div></div>
            <div class="anketa_form_h"><div class="anketa_form_h_cell">Последующие платежи:</div></div>
            <div class="anketa_form_desk"><?php echo $course['recur_subsequent']; ?></div>
            <div class="anketa_form_desk"> руб.</div>
        </div>
    </div>
<?php endif;
if($course['new_price'] != 0 or $course['price'] != 0):?>
    <div class="anketa_form_line parent">
        <div class="anketa_form_h">
            <div class="anketa_form_h_cell"><label for="payment-methods">Способ оплаты:</label></div>
        </div>
        <div class="anketa_form_h">
            <div class="anketa_form_h_cell">
                <select name="s_payment_method" class="journal_form_select long" required="required" id="payment-methods">
                    <option value="bank_card">Банковская карта</option>
                    <option value="yandex_money">Яндекс.Деньги</option>
                    <option value="sberbank">Сбербанк Онлайн</option>
                    <option value="qiwi">QIWI Wallet</option>
                    <option value="webmoney">Webmoney</option>
                    <option value="alfabank">Альфа-Клик</option>
                </select>
            </div>
        </div>
    </div>
    <div class="anketa_form_line parent" id="method-phone">
        <div class="anketa_form_h">
            <div class="anketa_form_h_cell">Телефон:</div>
            <div class="h_subtitle">(Прим. 79000000000)</div>
        </div>
        <div class="anketa_form_h">
            <div class="anketa_form_h_cell">
                <input type="text" name="i_phone" value="" class="admin_form_txt admin_form_txt_short full" required="required" />
            </div>
        </div>
    </div>
    <div class="anketa_form_line parent" id="method-login">
        <div class="anketa_form_h">
            <div class="anketa_form_h_cell">Логин:</div>
            <div class="h_subtitle">(Логин пользователя в Альфа-Клике)</div>
        </div>
        <div class="anketa_form_h">
            <div class="anketa_form_h_cell">
                <input type="text" name="i_login" value="" class="admin_form_txt admin_form_txt_short full" required="required" />
            </div>
        </div>
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
