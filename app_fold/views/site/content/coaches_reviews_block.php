<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="tren_row row">
    <?php include_once('./app_fold/views/coach/coach_slider.php');
    /*<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
        <h2 class="block_h">МЕРОПРИЯТИЯ</h2>
        <div class="event_block" data-info="Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.">
            <div class="event_item parent">
                <div class="event_l_item">
                    <div class="event_data">26 Gen, 2014</div>
                    <div class="event_img"></div>
                </div>
                <div class="event_r_item">
                    <div class="event_time">h.12.00 - h.13.00</div>
                    <div class="event_name">AEROBICS</div>
                    <div class="event_desk">Lorem ipsum dolor sit amet, consectetur adipiscing elit</div>
                    <a href="" class="event_but">booking</a>
                </div>
            </div>
            <div class="event_item parent">
                <div class="event_l_item">
                    <div class="event_data">26 Gen, 2014</div>
                    <div class="event_img"></div>
                </div>
                <div class="event_r_item">
                    <div class="event_time">h.12.00 - h.13.00</div>
                    <div class="event_name">AEROBICS</div>
                    <div class="event_desk">Lorem ipsum dolor sit amet, consectetur adipiscing elit</div>
                    <a href="" class="event_but">booking</a>
                </div>
            </div>
        </div>
    </div>*/?>
    <?php if(!empty($reviews)):?>
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <h2 class="block_h">ОТЗЫВЫ</h2>
            <div class="revive_block" data-info="Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.">
                <?php foreach($reviews as $review):?>
                    <?php include('./app_fold/views/site/content/review_item.php'); ?>
                <?php endforeach;
                unset($review);?>
            </div>
        </div>
    <?php endif;?>
</div><!-- tren_row -->