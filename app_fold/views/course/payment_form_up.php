<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="purchase_pop-up">
    <div class="purchase_pop-up_cont">
        <div class="purchase_pop-up_close"></div>
        <div class="purchase_pop-up_h">
            <form action="" method="post" class="anketa_form video_admin_form purchase_form">
                <div class="anketa_form_line parent">
                    <div class="anketa_form_h">
                        <div class="anketa_form_h_cell">Стоимость курса:</div>
                        <?php if($course['recurrent'] === true):?>
                            <div class="h_subtitle">(оплата единым платежом)</div>
                        <?php endif;?>
                    </div>
                    <?php if ($course['new_price'] != 0 or $course['price'] != 0):?>
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
                <?php if ($course['price'] != 0 and $course['recurrent'] === true):?>
                    <div class="line_parent">
                        <div class="anketa_form_line parent">
                            <div class="anketa_form_h">
                                <div class="anketa_form_h_cell">Стоимость курса:</div>
                                <div class="h_subtitle">(разделить оплату на <?php echo $course['recur_months']; ?> мес.*)</div>
                            </div>
                            <div class="anketa_form_h"><div class="anketa_form_h_cell"><?php echo $course['recur_price']; ?></div></div>
                            <div class="anketa_form_desk"> руб.</div>
                        </div>
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
                    <div class="anketa_form_line parent">
                        <div class="anketa_form_h">
                            <div class="anketa_form_h_cell"><label for="payment-options">Вариант оплаты:</label></div>
                        </div>
                        <div class="anketa_form_h">
                            <div class="anketa_form_h_cell">
                                <select name="s_payment_options" class="journal_form_select" required="required" id="payment-options">
                                    <option value="">Выберите вариант</option>
                                    <option value="full_payment">Полная оплата стоимости</option>
                                    <option value="installments">Разделить оплату на <?php echo $course['recur_months']; ?> мес.</option>
                                </select>
                            </div>
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
                                <select name="s_payment_method" class="journal_form_select" required="required" id="payment-methods">
                                    <option value="bank_card">Банковская карта</option>
                                </select>
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
            </form>
        </div>
    </div>
</div><!-- purchase_pop-up -->
