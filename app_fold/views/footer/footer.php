<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

</div><!-- content -->


<div id="footer">
    <div class="container">
        <div class="row">
            <?php $block2 = (!empty($user_session) and is_array($user_session) and
                array_key_exists('subscribed', $user_session) and $user_session['subscribed'] === true)
                ? 'col-lg-9 col-md-9 col-sm-12 col-xs-12'
                : 'col-lg-5 col-md-5 col-sm-6 col-xs-12';
            ?>
            <?php if(empty($user_session['subscribed']) or (is_array($user_session) and array_key_exists('subscribed', $user_session) and $user_session['subscribed'] === false)): ?>
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 footer_subscribe_wrap">
                    <div class="footer_h">ПОДПИСКА НА НОВОСТИ</div>
                    <div class="footer_desk">ПОДПИШИТЕСЬ НА НОВОСТИ НАШЕГО ПОРТАЛА И БУДЬТЕ В КУРСЕ ВСЕХ СОБЫТИЙ</div>
                    <form action="/" id="subscribe_form" method="post">
                        <div class="subscribe_form_in_wrap">
                            <input type="text" name="subscribe_email" class="subscribe_form_in valid_email" placeholder="УКАЖИТЕ EMAIL" required="required" maxlength="255" />
                            <input type="text" name="subscribe_name" class="subscribe_form_in" placeholder="ВАШЕ ИМЯ" required="required" maxlength="255" />
                            <div class="sing-in_h tren_form_block_check_wrap">
                                <input type="checkbox" name="cb_politics" class="tren_form_block_check" id="cb-politics-2" required="required" checked="checked" />
                                <label for="cb-politics-2">согласие на
                                    <a href="#" class="reg_in_link policy">обработку персональных данных</a>
                                </label>
                            </div>
                        </div>
                        <div class="subscribe_form_but_wrap">
                            <input type="submit" name="bt_subscribe" value="Подписаться" class="subscribe_form_but">
                        </div>
                    </form>
                </div>
            <?php endif; ?>
            <div class="<?php echo $block2; ?>">
                <a href="" class="f_logo"><img src="/img/logo.png" alt=""></a>
                <div class="f_logo_desk"><?php if (!empty($site_info['rights'])): echo $site_info['rights']; endif;?></div>
                <div class="f_contact">
                    <div class="f_contact_line">
                        <div class="f_contact_name">
                            <?php include('./app_fold/views/header/messengers.php'); ?>
                        </div>
                        <div class="f_contact_val"><?php if (!empty($site_info['phone'])): echo $site_info['phone']; endif;?></div>
                    </div>
                    <div class="f_contact_line">
                        <div class="f_contact_name"><i class="fa fa-envelope"></i></div>
                        <div class="f_contact_val"><?php if (!empty($site_info['email'])): echo $site_info['email']; endif;?></div>
                    </div>
                </div>
                <div class="f_policy">
                    <?php include('./app_fold/views/footer/policy_agreement.php'); ?>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12 footer_menu_wrap">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-6 col-xs-6">
                        <div class="footer_h">МЕНЮ</div>
                        <ul class="footer_menu">
                            <li><a href="/about">О нас</a></li>
                            <li><a href="/coaches">Наши тренеры</a></li>
                            <li><a href="/courses">Курсы</a></li>
                            <li><a href="/blog">Блог</a></li>
                            <?php if (!empty($user_session)):?>
                                <li><a href="/profile/<?php echo $user_session['id']; ?>">Профиль</a></li>
                                <!--<li><a href="/store">Магазин</a></li>-->
                            <?php endif;?>
                            <li><a href="/contacts">Контакты</a></li>
                            <li><a href="/support">Инструкции</a></li>
                        </ul>
                        <a href="#" class="agreement" id="show-check-promocode">У меня есть промокод</a>
                    </div>
                    <!--<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <div class="footer_h">СООБЩЕСТВО</div>
                        <ul class="footer_menu">
                            <li class="disabled"><a href="#">Блог</a></li>
                            <li class="disabled"><a href="#">Форум</a></li>
                            <li class="disabled"><a href="#">Поддержка</a></li>
                            <li><a href="/journal">Журнал</a></li>
                        </ul>
                    </div>-->
                </div>
            </div>
        </div>
    </div>
</div><!-- footer -->

<?php include_once('./app_fold/views/footer/last_line.php'); ?>

<div id="shadow"></div>
<div id="shadow2"></div>

<div id="pop-ups">
    <div id="pop-up_video">
        <div class="close_video"></div>
    </div><!-- pop-up_video -->

    <div id="pop-up_review">
        <div class="close_video"></div>
    </div><!-- pop-up_review -->

    <div id="pop-up_postpone">
        <div class="close_video"></div>
    </div><!-- pop-up_video -->

    <div id="pop-up_meal">
        <div class="close_meal"></div>
    </div><!-- pop-up_meal -->

    <div id="pop-up_user_meal">
        <div class="close_user_meal"></div>
    </div><!-- pop-up_user_meal -->

    <div id="pop-up_premium">
        <div class="premium_wrap">
            <div class="premium_h">
                <div><i class="fas fa-crown"></i></div>
                <div class="premium_h_text">Премиум доступ</div>
                <div><i class="fas fa-crown"></i></div>
            </div>
            <div class="premium_content">
                <form action="" method="post" class="anketa_form video_admin_form premium_form">
                    <div class="premium_popup_text"><?php if(!empty($site_info['advertising_popup'])): echo $site_info['advertising_popup']; endif; ?></div>
                    <div class="anketa_form_buts_wrap parent premium_price"><?php if(!empty($site_info['advertising_month_price'])): echo $site_info['advertising_month_price']; ?><span>рублей в месяц</span><?php endif; ?></div>
                    <div class="parent kurs_cur_wrap">
                        <div class="sing-in_h tren_form_block_check_wrap">
                            <input type="checkbox" name="cb_offer" class="tren_form_block_check" id="cb-politics-3" required="required" checked="checked">
                            <label for="cb-politics-3">согласие с
                                <a href="<?php if(!empty($site_info['agreement'])): echo $site_info['agreement']; endif; ?>" class="reg_in_link" target="_blank">пользовательским соглашением</a>
                            </label>
                        </div>
                    </div>
                    <div class="anketa_form_buts_wrap parent">
                        <input type="hidden" name="ord_id" value="<?php if(!empty($user_session['premium_order'])): echo $user_session['premium_order']; endif; ?>">
                        <input type="submit" name="bt_pay_premium" value="Оплатить" data-def-val="Оплатить" class="anketa_form_but red">
                    </div>
                    <div class="h_subtitle">* Нажав на кнопку "Оплатить", Вы соглашаетесь на сохранение данных оплаты. Последующие платежи будут проходить автоматически. Прервать оплату Вы можете написав администрации сайта.</div>
                    <div class="purchase_policy">
                        <?php include('./app_fold/views/footer/policy_agreement.php'); ?>
                    </div>
                </form>
            </div>
            <div class="premium_pop-up_close" style="opacity: 0.6;"></div>
        </div>
    </div><!-- pop-up_user_meal -->

    <div id="check-promocode-form">
    <div class="parent kurs_cur_wrap promo_block">
        <div class="kurs_block_h">Промокод:</div>
        <input type="text" name="promocode" value="" maxlength="25" class="admin_form_txt admin_form_txt_short" autofocus="autofocus" id="i-promocode">
        <div class="video_admin_form_buts parent">
            <input type="button" name="bt_check_promocode" id="check-promocode" value="Проверить" class="video_admin_form_send">
        </div>
    </div>
</div><!-- check-promocode-form -->
</div>

<?php include_once('./app_fold/views/course/payment_form_up.php'); ?>

<?php if (!isset($_COOKIE["disclaimer"])): ?>
    <div id="cookie_disclaimer">
        <?php echo $site_info['cookies_text']; ?>
        <span id="cookie_stop">Ok</span>
    </div>
<?php endif; ?>

<?php if (!empty($site_info['advertising_mobile']) and empty($site_info['advertising_mobile_hide']) and !empty($user_session) and $user_session['advertising'] == 1 and $user_session['type'] == 3):?>
    <div class="advertising mobile"><?php echo $site_info['advertising_mobile']; ?></div>
<?php endif; ?>

<script src="/js/lightbox.js"></script>
<script src="/js/vimeo_player.js"></script>
<?php include_once('./app_fold/views/footer/jivo_script.php'); ?>
</body>
</html>