<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="header">
    <?php include_once('./app_fold/views/header/soc.php');?>
    <div class="header_mid parent">
        <?php include_once('./app_fold/views/header/menu.php');?>
    </div>
    <div class="header_bg_wrap in_bg_wrap">
        <?php include_once('./app_fold/views/header/slider.php'); ?>
    </div>
</div><!-- header -->
<div class="prezent_head <?php if(empty($advertising_banner) and empty($standard_banner)):?>hide_chart<?php endif;?>">
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
    <?php if(!empty($advertising_banner) or !empty($standard_banner)):?>
        <div class="up_but up_but_bot"></div>
    <?php endif;?>
</div><!-- prezent_head -->
