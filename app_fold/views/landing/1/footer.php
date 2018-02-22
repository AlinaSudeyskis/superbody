<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
        <div class="lp_footer_wrap">
            <div class="lp_footer container parent">
                <div class="lp_footer_cont">
                    <div class="lp_footer_h">ПОДПИСКА НА НОВОСТИ</div>
                    <div class="lp_footer_txt">ПОДПИШИТЕСЬ НА НОВОСТИ НАШЕГО ПОРТАЛА И БУДЬТЕ В КУРСЕ ВСЕХ СОБЫТИЙ</div>
                    <div class="lp_footer_txt">Получите базовый курс стоимостью 1990 за подписку <span>бесплатно</span></div>
                </div>
                <form action="/" id="subscribe_form" method="post">
                    <div class="subscribe_form_in_wrap">
                        <input type="text" name="subscribe_email" class="subscribe_form_in" placeholder="Ваше имя"/>
                        <input type="text" name="subscribe_name" class="subscribe_form_in" placeholder="Укажите email"/>
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