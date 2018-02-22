<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="header">
    <?php include_once('./app_fold/views/header/soc.php');?>
    <div class="header_mid parent">
        <?php include_once('./app_fold/views/header/menu.php');?>
    </div>
    <div class="header_bg_wrap in_bg_wrap" style="display: none;">
        <div class="header_bg">
            <?php include_once('./app_fold/views/header/slider.php'); ?>
        </div>
        <?php include_once('./app_fold/views/header/banner_js.php');?>
    </div>
</div><!-- header -->
<div class="prezent_head hide_chart">
    <h1 class="prezent_h1"><?php echo $title;?></h1>
    <div class="prezent_cont parent">
        <div class="prezent_l">
            <div class="video_cont">
                <div class="px-video-img-captions-container">
                    <div class="px-video-captions hide"></div>
                    <video poster="/img/video_kurs.jpg" controls>
                        <source src="https://www.paypalobjects.com/webstatic/mktg/videos/PayPal_AustinSMB_baseline.mp4" type="video/mp4">
                        <div><a href="https://www.paypalobjects.com/webstatic/mktg/videos/PayPal_AustinSMB_baseline.mp4"><img src="/img/video_kurs.jpg" alt="download video"></a></div>
                    </video>
                </div>
                <div class="px-video-controls"></div>
            </div>
        </div>
        <div class="prezent_r">
            <div class="prezent_h">Приветствуем вас!</div>
            <div class="prezent_desk">Ознакомьтесь с доступными курсами. Любой курс содержит программу питания и синхронизируется с вашим календарем. Возможность задать вопрос лично тренеру. Ведение статистике в личном кабинете. Конкурсы, призы и подарки. Спешите стать участником нашего клуба.</div>
        </div>
    </div>
    <div class="up_but up_but_bot hide_chart"></div>
</div><!-- prezent_head -->
