<?php
$title = 'Страница не найдена';
$page_menu = '';
$message = '';
?>
    <!DOCTYPE html>
    <html lang="ru">
    <head>
        <meta charset="UTF-8">
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <title><?php echo $title; ?> - Super Body</title>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i&amp;subset=cyrillic">
        <link rel="stylesheet" href="/css/grid.css">
        <link rel="stylesheet" href="/css/fullcalendar.css">
        <link rel="stylesheet" href="/css/px-video.css">
        <link rel="stylesheet" href="/css/slick.css">
        <link rel="stylesheet" href="/css/lightbox.css">
        <link rel="stylesheet" href="/css/jquery.formstyler.css">
        <link rel="stylesheet" href="/css/font-awesome.min.css">
        <link rel="stylesheet" href="/css/colorpicker/colorpicker.css">
        <link rel="stylesheet" href="/css/colorpicker/page.css">

        <link rel="stylesheet" href="/css/style.css">
        <link rel="stylesheet" href="/css/styles.css">

        <script src="/js/moment.min.js"></script>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script src="https://player.vimeo.com/api/player.js"></script>
        <script src="/js/amcharts/amcharts.js"></script>
        <script src="/js/amcharts/serial.js"></script>
        <script src="/js/amcharts/amstock.js"></script>
        <script src="/js/fullcalendar.min.js"></script>
        <script src="/js/locale-all.js"></script>
        <script src="/js/strings.js"></script>
        <script src="/js/px-video.js"></script>
        <script src="/js/slick.min.js"></script>
        <script src="/js/jquery.formstyler.js"></script>
        <script src="/js/autoresize-textarea.js"></script>
        <script src="/js/masonry.pkgd.min.js"></script>
        <script src="/js/jquery.mask.min.js" type="text/javascript"></script>
        <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>

        <script src="/js/script.js"></script>
        <script src="/js/scripts.js"></script>

        <script src="/js/colorpicker/colorpicker.min.js"></script>
        <!--<script src="/js/colorpicker/eye.js"></script>
        <script src="/js/colorpicker/utils.js"></script>
        <script src="/js/colorpicker/layout.js"></script>-->
    </head>
<body>
<div id="header">
    <div class="hid_header">
        <div class="header_soc_wrap parent">
            <div class="header_tel">+7 495 456 45 56</div>
            <ul class="header_soc">
                <li><a href=""><img src="/img/soc_ico1.png" alt=""></a></li>
                <li><a href=""><img src="/img/soc_ico2.png" alt=""></a></li>
                <li><a href=""><img src="/img/soc_ico3.png" alt=""></a></li>
                <li><a href=""><img src="/img/soc_ico4.png" alt=""></a></li>
                <li><a href=""><img src="/img/soc_ico5.png" alt=""></a></li>
                <li><a href=""><img src="/img/soc_ico6.png" alt=""></a></li>
                <li><a href=""><img src="/img/soc_ico7.png" alt=""></a></li>
            </ul>
        </div>
        <div class="header_mid header_mid_profile parent">
            <div class="header_logo"><a href="/"><img src="/img/logo.png" alt=""></a></div>
            <nav class="header_menu">
                <ul class="menu">
                    <li><a href="/" <?php if ($page_menu == 'index') { echo 'class="active"'; } ?>>ГЛАВНАЯ</a></li>
                    <li><a href="/about" <?php if ($page_menu == 'about') { echo 'class="active"'; } ?>>О НАС</a></li>
                    <li><a href="/journal/articles" <?php if ($page_menu == 'articles') { echo 'class="active"'; } ?>>ЖУРНАЛ</a></li>
                    <li><a href="/couches" <?php if ($page_menu == 'couches') { echo 'class="active"'; } ?>>ТРЕНЕРЫ</a></li>
                    <li <?php if (!empty($menu_courses['courses'])) :?> class="submenu_li" <?php endif;?>>
                        <a href="/courses" <?php if ($page_menu == 'courses') { echo 'class="active"'; } ?>>КУРСЫ</a>
                        <?php if (!empty($menu_courses['courses'])) :?>
                            <ul class="submenu">
                                <?php foreach ($menu_courses['courses'] as $m_course) :?>
                                    <li><a href="/course/<?php echo $m_course['id']; ?>"><?php echo $m_course['name']; ?></a></li>
                                <?php endforeach;
                                unset($m_course);?>
                            </ul>
                        <?php endif;?>
                    </li>
                    <?php if (!empty($user)) :?>
                        <li><a href="<?php echo '/profile/' . $user['id']; ?>" <?php if ($page_menu == 'profile') { echo 'class="active"'; } ?>>ПРОФИЛЬ</a></li>
                        <li><a href="/store" <?php if ($page_menu == 'store') { echo 'class="active"'; } ?>>МАГАЗИН</a></li>
                    <?php endif;?>
                    <li><a href="/contacts" <?php if ($page_menu == 'contacts') { echo 'class="active"'; } ?>>КОНТАКТЫ</a></li>
                </ul>
            </nav>
            <?php if ($page_menu == 'index'):?>
                <div class="up_but up_but_main"></div>
            <?php endif;?>
            <div class="mob_menu_but">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </div>
</div><!-- header -->

<div id="content" class="container">
    <div class="content_block no_content_block">
        <div class="no_content_block_cont">
            <div class="no_content_val">404</div>
            <div class="no_content_desk">
                <div class="no_content_desk_line">страницы не существует или она была удалена</div>
                <div class="no_content_desk_line">вы можете перейти <a href="/">на главную</a></div>
            </div>
        </div>
    </div>
</div><!-- content -->

<div id="footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 footer_subscribe_wrap">
                <div class="footer_h">ПОДПИСКА НА НОВОСТИ</div>
                <div class="footer_desk">ПОДПИШИТЕСЬ НА НОВОСТИ НАШЕГО ПОРТАЛА И БУДЬТЕ В КУРСЕ ВСЕХ СОБЫТИЙ</div>
                <form action="/" id="subscribe_form" method="post">
                    <div class="subscribe_form_in_wrap">
                        <input type="text" name="subscribe_email" class="subscribe_form_in" placeholder="Ваше имя" required="required" maxlength="255" />
                        <input type="text" name="subscribe_name" class="subscribe_form_in" placeholder="Укажите email" required="required" maxlength="255" />
                    </div>
                    <div class="subscribe_form_but_wrap">
                        <input type="submit" name="bt_subscribe" value="Подписаться" class="subscribe_form_but">
                    </div>
                </form>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <a href="" class="f_logo"><img src="/img/logo.png" alt=""></a>
                <div class="f_logo_desk">Все права защищены. Правообладателем всех материалов данного ресурса является ООО “Супербоди”. Копирование и распространение материалов запрещено.</div>
                <div class="f_contact">
                    <div class="f_contact_line">
                        <div class="f_contact_name">Phone:</div>
                        <div class="f_contact_val">8-800-333-9876</div>
                    </div>
                    <div class="f_contact_line">
                        <div class="f_contact_name">e-mail:</div>
                        <div class="f_contact_val">info@superbody.pro</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 footer_menu_wrap">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <div class="footer_h">МЕНЮ</div>
                        <ul class="footer_menu">
                            <li><a href="/about">О нас</a></li>
                            <li><a href="/couches">Наши тренеры</a></li>
                            <li><a href="/courses">Курсы</a></li>
                            <li><a href="/store">Магазин</a></li>
                            <li><a href="/contacts">Контакты</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <div class="footer_h">СООБЩЕСТВО</div>
                        <ul class="footer_menu">
                            <li class="disabled"><a href="#">Блог</a></li>
                            <li class="disabled"><a href="#">Форум</a></li>
                            <li class="disabled"><a href="#">Поддержка</a></li>
                            <li><a href="/journal">Журнал</a></li>
                        </ul>
                        <a href="#" class="agreement disabled">Пользовательское соглашение</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!-- footer -->


<div class="header_soc_wrap footer_soc_wrap parent">
    <div class="footer_copy">© ООО «Супербоди» все права защищены 2016</div>
    <ul class="header_soc">
        <li><a href=""><img src="/img/soc_ico1.png" alt=""></a></li>
        <li><a href=""><img src="/img/soc_ico2.png" alt=""></a></li>
        <li><a href=""><img src="/img/soc_ico3.png" alt=""></a></li>
        <li><a href=""><img src="/img/soc_ico4.png" alt=""></a></li>
        <li><a href=""><img src="/img/soc_ico5.png" alt=""></a></li>
        <li><a href=""><img src="/img/soc_ico6.png" alt=""></a></li>
        <li><a href=""><img src="/img/soc_ico7.png" alt=""></a></li>
    </ul>
</div>

<div id="shadow"></div>

<div id="pop-up_video">
    <div class="close_video"></div>
</div><!-- pop-up_video -->

<script src="/js/lightbox.js"></script>

</body>
</html>