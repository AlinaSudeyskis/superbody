<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<form action="" method="post" class="anketa_form video_admin_form">
    <?php if(!empty($executive) and $executive === true): ?>
        <input type="hidden" name="crs_id" id="crs-id" value="" />
        <input type="hidden" name="ord_id" id="ord-id" value="" />
        <input type="hidden" name="user_id" value="<?php if (!empty($user_data['user_id'])) { echo $user_data['user_id']; }?>" id="user-id">
        <div class="parent kurs_cur_wrap" id="cg-few-search">
            <div class="kurs_block_h">Поиск курса:</div>
            <div class="add_tov_in_total anketa_form_in_long" style="float: left;">
                <div class="add_tov_in pc_course one_course">
                    <input type="text" name="name_course" class="admin_form_txt" placeholder="Введите наименование или ID курса" autocomplete="off">
                    <div class="add_tov_list"></div>
                </div>
                <div class="add_tov_val"></div>
            </div>
        </div>
    <?php else: ?>
        <input type="hidden" name="crs_id" id="crs-id" value="<?php if (!empty($course['id'])) { echo $course['id']; }?>" />
        <input type="hidden" name="ord_id" id="ord-id" value="<?php if (!empty($course['order_id'])) { echo $course['order_id']; }?>" />
        <input type="hidden" name="user_id" value="<?php if (!empty($user_session)) { echo $user_session['id']; }?>" id="user-id">
    <?php endif; ?>
    <?php if(empty($user_session) or empty($user_session['email'])): ?>
        <div class="parent kurs_cur_wrap">
            <div class="kurs_block_h">Email:</div>
            <input type="text" name="email" required="required" value="" class="admin_form_txt admin_form_txt_short valid_email" autocomplete="off"/>
        </div>
    <?php endif; ?>
    <?php if(empty($user_session) or empty($user_session['name'])): ?>
        <div class="parent kurs_cur_wrap">
            <div class="kurs_block_h">ФИО:</div>
            <input type="text" name="name" required="required" value="" class="admin_form_txt admin_form_txt_short" autocomplete="off"/>
        </div>
    <?php endif; ?>
    <?php if (($course['price'] != 0 and $course['recurrent'] === true) or (!empty($executive) and $executive === true)):?>
        <div class="parent kurs_cur_wrap">
            <div class="kurs_block_h"><label for="payment-options">Вариант оплаты:</label></div>
            <select name="s_payment_options" class="journal_form_select" required="required" id="payment-options">
                <option value="full_payment">Полная оплата стоимости</option>
                <option value="partial_payment">Разделить оплату на <?php echo $course['recur_months']; ?> мес.</option>
            </select>
        </div>
        <div class="line_parent" id="recurrent-block">
            <div class="parent kurs_cur_wrap">
                <div class="kurs_block_h">Первый платеж:</div>
                <div class="pf_price_wrap">
                    <div class="kurs_block_h" id="recb-rf"><?php echo $course['recur_first']; ?></div>
                    <div class="kurs_cur"> руб.</div>
                </div>
            </div>
            <div class="parent kurs_cur_wrap">
                <div class="kurs_block_h" style="line-height: 17px;">Последующие платежи:</div>
                <div class="pf_price_wrap">
                    <div class="kurs_block_h" id="recb-rs"><?php echo $course['recur_subsequent']; ?></div>
                    <div class="kurs_cur"> руб.</div>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <div class="parent kurs_cur_wrap" id="price-block">
        <div class="kurs_block_h">Стоимость курса:</div>
        <div class="pf_price_wrap">
            <?php if ($course['new_price'] == 0 and $course['price'] == 0 and empty($course['balance_amount'])):?>
                <div class="kurs_block_h">Бесплатно</div>
            <?php else:
                if (empty($course['new_price']) and empty($course['balance_amount'])): ?>
                    <div class="kurs_block_h" id="course-price"><?php echo $course['price']; ?></div>
                <?php elseif (!empty($course['new_price']) and empty($course['balance_amount'])): ?>
                    <div class="kurs_block_h strikeout" id="course-price"><?php echo $course['price'];?></div>
                    <div class="kurs_cur" id="course-new-price"><?php echo $course['new_price'];?></div>
                <?php elseif (!empty($course['balance_amount'])): ?>
                    <div class="kurs_block_h" id="course-price"><?php echo $course['balance_amount']; ?></div>
                <?php endif;?>
                <div class="kurs_cur"> руб.</div>
            <?php endif;?>
        </div>
    </div>
    <?php if($course['new_price'] != 0 or $course['price'] != 0 or (!empty($executive) and $executive === true)):?>
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
                <div class="h_subtitle" style="line-height: 13px; margin-top: -7px;">(пользователя в Альфа-Клике)</div>
            </div>
            <input type="text" name="i_login" value="" class="admin_form_txt admin_form_txt_short" />
        </div>
    <?php endif;?>
    <?php if($course['promocode_availability'] === true or (!empty($executive) and $executive === true)): // and empty($course['balance_amount']) ?>
        <div class="parent kurs_cur_wrap promo_block">
            <div class="kurs_block_h"></div>
            <div class="promo_line">У меня есть промокод</div>
            <div class="promo_info">Промокод не доступен</div>
        </div>
    <?php endif; ?>
    <div class="parent kurs_cur_wrap">
        <div class="kurs_block_h"></div>
        <div class="sing-in_h tren_form_block_check_wrap">
            <input type="checkbox" name="cb_offer" class="tren_form_block_check" id="cb-politics-3" required="required" checked="checked">
            <label for="cb-politics-3">согласие с
                <a href="<?php if(!empty($site_info)): echo $site_info['agreement']; endif; ?>" class="reg_in_link" target="_blank">пользовательским соглашением</a>
            </label>
        </div>
    </div>
    <?php if(empty($user_session) or empty($user_session['email'])): ?>
        <div class="parent kurs_cur_wrap">
            <div class="kurs_block_h"></div>
            <div class="sing-in_h tren_form_block_check_wrap">
                <input type="checkbox" name="cb_politics" class="tren_form_block_check" id="cb-politics-4" required="required" checked="checked"/>
                <label for="cb-politics-4">согласие на
                    <a href="#" class="reg_in_link policy">обработку персональных данных</a>
                </label>
            </div>
        </div>
    <?php endif; ?>
    <div class="anketa_form_buts_wrap parent">
        <?php if (!empty($courses_id) and in_array($course['id'], $courses_id) and empty($course['balance_amount'])): ?>
            <input type="submit" name="bought" value="Куплен" class="anketa_form_but disabled"/>
        <?php else: ?>
            <?php
            $but_text = ((!empty($executive) and $executive === true) or $course['new_price'] != 0 or $course['price'] != 0) ? 'Купить' : 'Добавить в "Мои курсы"';
            $but_text = (!empty($course['balance_amount'])) ? 'Оплатить' : $but_text;
            ?>
            <input type="submit" name="bt_buy_course" value='<?php echo $but_text; ?>' data-def-val='<?php echo $but_text; ?>' class="anketa_form_but red"/>
        <?php endif; ?>
    </div>

    <?php if ($course['recurrent'] === true):?>
        <div class="h_subtitle">* Выбирая разделенние платежа на несколько частей, Вы соглашаетесь на сохранение данных оплаты. Последующие платежи будут проходить автоматически. Прервать оплату Вы можете написав администрации сайта.</div>
    <?php endif?>
    <div class="purchase_policy">
        <?php include('./app_fold/views/footer/policy_agreement.php'); ?>
    </div>
</form>
<?php if(empty($user_session)): ?>
    <a href="#" class="turn_auth">Авторизация</a>
<?php endif; ?>
