<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="lp_footer_wrap">
    <div class="lp_footer container parent">
        <div class="lp_footer_cont">
            <div class="lp_footer_h">ПОДПИСКА НА НОВОСТИ</div>
            <div class="lp_footer_txt">ПОДПИШИТЕСЬ НА НОВОСТИ НАШЕГО ПОРТАЛА И БУДЬТЕ В КУРСЕ ВСЕХ СОБЫТИЙ</div>
            <div class="lp_footer_txt">Получите базовый курс стоимостью 1990 за подписку <span>бесплатно</span></div>
            <a href="<?php if (!empty($site_info['agreement'])): echo $site_info['agreement']; endif;?>" class="agreement <?php if (empty($site_info['agreement'])): echo 'disabled'; endif;?>">Пользовательское соглашение</a>
            <a href="<?php if (!empty($site_info['private_policy'])): echo $site_info['private_policy']; endif;?>" class="agreement <?php if (empty($site_info['private_policy'])): echo 'disabled'; endif;?>">Политика конфиденциальности</a>
        </div>
        <form action="/" id="subscribe_form" method="post">
            <div class="subscribe_form_in_wrap">
                <input type="text" name="subscribe_email" class="subscribe_form_in valid_email" placeholder="Укажите email" maxlength="255"/>
                <input type="text" name="subscribe_name" class="subscribe_form_in" placeholder="Ваше имя" maxlength="255"/>
                <div class="sing-in_h tren_form_block_check_wrap">
                    <input type="checkbox" name="cb_politics" class="tren_form_block_check" id="cb-politics-2" required="required" />
                    <label for="cb-politics-2">согласие на
                        <a href="#" class="reg_in_link policy">обработку персональных данных</a>
                    </label>
                </div>
            </div>
            <div class="subscribe_form_but_wrap">
                <input type="submit" name="bt_subscribe" value="Подписаться" class="subscribe_form_but"/>
            </div>
        </form>
    </div>
</div><!-- lp_footer_wrap -->

<div class="header_soc_wrap footer_soc_wrap parent">
    <div class="footer_copy"><?php if (!empty($site_info['footer'])): echo $site_info['footer']; endif;?></div>
    <?php include('./app_fold/views/header/header_soc.php'); ?>
</div>

<script src="/js/lightbox.js"></script>

</body>
</html>