<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="lp_dark_footer_wrap">
    <div class="lp_dark_footer container parent">
        <?php if(empty($user_session) or !array_key_exists('subscribed', $user_session) or $user_session['subscribed'] === false):?>
            <div class="lp_dark_footer_cont">
                <div class="lp_dark_footer_h">ПОДПИСКА НА НОВОСТИ</div>
                <div class="lp_dark_footer_txt">Подпишитесь на новости нашего портала и будьте в курсе всех событий</div>
                <div class="lp_dark_footer_txt">Получите базовый курс стоимостью 1990 за подписку <span>бесплатно</span></div>
            </div>
            <form action="/" id="subscribe_dark_form" class="parent" method="post">
                <div class="subscribe_dark_form_in_wrap parent">
                    <input type="text" name="subscribe_email" class="subscribe_dark_form_in valid_email" placeholder="Укажите email" maxlength="255"/>
                    <input type="text" name="subscribe_name" class="subscribe_dark_form_in" placeholder="Ваше имя" maxlength="255"/>
                    <div class="sing-in_h tren_form_block_check_wrap" style="clear:both; padding-top:15px;">
                        <input type="checkbox" name="cb_politics" class="tren_form_block_check" id="cb-politics-2" required="required" />
                        <label for="cb-politics-2">согласие на
                            <a href="#" class="reg_in_link policy">обработку персональных данных</a>
                        </label>
                    </div>
                </div>
                <div class="subscribe_dark_form_but_wrap">
                    <input type="submit" value="Подписаться" name="bt_subscribe" class="subscribe_dark_form_but"/>
                </div>
            </form>
        <?php endif; ?>
        <div class="dark_agreement">
            <?php include('./app_fold/views/footer/policy_agreement.php'); ?>
        </div>
    </div>
</div><!-- lp_dark_footer_wrap -->

<div class="dark_footer_copy_wrap">
    <div class="container">
        <div class="dark_footer_copy"><?php if (!empty($site_info['footer'])): echo $site_info['footer']; endif;?></div>
    </div>
</div><!-- dark_footer_copy_wrap -->

<script src="/js/lightbox.js"></script>

</body>
</html>