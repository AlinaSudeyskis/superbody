<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="header">
    <?php include_once('./app_fold/views/header/soc.php');?>
    <div class="header_mid parent">
        <?php include_once('./app_fold/views/header/menu.php');?>
    </div>
    <!--<div id="map">
        <script type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?sid=rsT6lMZP575RlUWVAlnrOXyXLe4jZqEj&amp;width=100%&amp;height=500&amp;lang=ru_RU&amp;sourceType=constructor&amp;scroll=true"></script>
    </div>-->
    <div class="header_bg_wrap in_bg_wrap" style="display: none;">
        <div class="header_bg">
            <?php include_once('./app_fold/views/header/slider.php'); ?>
        </div>
        <?php include_once('./app_fold/views/header/banner_js.php');?>
    </div>
</div><!-- header -->
