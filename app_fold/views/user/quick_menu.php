<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="row cat_item_block">
    <!--<div class="cat_item_wrap">
        <a href="" class="cat_item">
            <div class="cat_img"><img src="/img/cat1.png" alt=""></div>
            <div class="cat_desk">
                <div class="cat_desk_name">FitCoin</div>
                <div class="cat_desk_val">3,352</div>
            </div>
        </a>
    </div>-->
    <div class="cat_item_wrap disabled">
        <a href="" class="cat_item">
            <div class="cat_img"><img src="/img/cat2.png" alt=""></div>
            <div class="cat_desk">Выбор личного эксперта</div>
        </a>
    </div>
    <?php $disabled = (!empty($available_workout) and $available_workout === true) ? '' : 'disabled';?>
    <div class="cat_item_wrap <?php echo $disabled; ?>" id="s-t-wo">
        <div class="cat_item">
            <div class="cat_img"><img src="/img/cat3.png" alt=""></div>
            <div class="cat_desk">Тренировка
                <?php if(!empty($next_training)):?>
                    <span>Сл. тренировка: <?php echo $next_training; ?></span>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="cat_item_wrap" id="s-adding-meal">
        <div class="cat_item">
            <div class="cat_img"></div>
            <div class="cat_desk">Питание</div>
        </div>
    </div>
    <div class="cat_item_wrap">
        <a href="/anthropometric" class="cat_item">
            <div class="cat_img"><img src="/img/cat4.png" alt=""></div>
            <div class="cat_desk">Ввести параметры тела</div>
        </a>
    </div>
    <div class="cat_item_wrap">
        <a href="/orders" class="cat_item">
            <div class="cat_img"><img src="/img/cat5.png" alt=""></div>
            <div class="cat_desk">Финансы Покупки</div>
        </a>
    </div>
</div>
