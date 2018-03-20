<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="lp_dark_footer_wrap">
    <div class="lp_dark_footer container parent">
        <div class="lp_dark_footer_cont">
            <div class="lp_dark_footer_h">ПОДПИСКА НА НОВОСТИ</div>
            <div class="lp_dark_footer_txt">Подпишитесь на новости нашего портала и будьте в курсе всех событий</div>
            <div class="lp_dark_footer_txt">Получите базовый курс стоимостью 1990 за подписку <span>бесплатно</span></div>
            <a href="<?php if (!empty($site_info['agreement'])): echo $site_info['agreement']; endif;?>" class="agreement <?php if (empty($site_info['agreement'])): echo 'disabled'; endif;?>">Пользовательское соглашение</a>
            <a href="<?php if (!empty($site_info['private_policy'])): echo $site_info['private_policy']; endif;?>" class="agreement <?php if (empty($site_info['private_policy'])): echo 'disabled'; endif;?>">Политика конфиденциальности</a>
        </div>
        <form action="/" id="subscribe_dark_form" class="parent" method="post">
            <div class="subscribe_dark_form_in_wrap parent">
                <input type="text" name="subscribe_email" class="subscribe_dark_form_in" placeholder="Укажите email"/>
                <input type="text" name="subscribe_name" class="subscribe_dark_form_in" placeholder="Ваше имя"/>
                <div class="sing-in_h tren_form_block_check_wrap">
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