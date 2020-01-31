<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$col_x = (!empty($user_session) and $user_session['type'] == 3) ? 'col_4' : 'col_3'; // col_5
?>
<div class="row cat_item_block <?php echo $col_x; ?>">
    <!--<div class="cat_item_wrap">
        <a href="" class="cat_item">
            <div class="cat_img"><img src="/img/cat1.png" alt=""></div>
            <div class="cat_desk">
                <div class="cat_desk_name">FitCoin</div>
                <div class="cat_desk_val">3,352</div>
            </div>
        </a>
    </div>-->
    <div class="cat_item_wrap">
        <a href="" class="cat_item disabled">
            <div class="cat_img"><img src="/img/cat2.png" alt=""></div>
            <div class="cat_desk">Выбор личного эксперта</div>
        </a>
    </div>
    <?php $ci_disabled = (!empty($available_workout) and $available_workout === true) ? '' : 'disabled';
    $cd_height = (!empty($available_postpone) and $available_postpone === true) ? 56 : 80; ?>
    <div class="cat_item_wrap">
        <div class="cat_item <?php echo $ci_disabled; ?>" id="s-t-wo">
            <div class="cat_img"><img src="/img/cat3.png" alt=""></div>
            <div class="cat_desk" style="height: <?php echo $cd_height; ?>px;">
                <span>Тренировка</span>
                <?php if(!empty($next_training)):?>
                    <div class="cat_subdesk">Сл. тренировка: <?php echo $next_training; ?></div>
                <?php endif; ?>
            </div>
            <?php if(!empty($available_postpone) and $available_postpone === true):?>
                <div class="cat_but" id="wo-pp">Перенести</div>
            <?php endif; ?>
        </div>
    </div>
    <?php if(!empty($user_session) and $user_session['type'] == 3): ?>
        <div class="cat_item_wrap">
            <div class="cat_item" id="s-adding-meal">
                <div class="cat_img"><img src="/img/cat10.png" alt=""></div>
                <div class="cat_desk">Добавить прием пищи</div>
            </div>
        </div>
    <?php endif; ?>
    <div class="cat_item_wrap">
        <a href="/questionnaire" class="cat_item">
            <div class="cat_img"><img src="/img/cat4.png" alt=""></div>
            <div class="cat_desk">Ввести параметры тела</div>
        </a>
    </div>
    <!--<div class="cat_item_wrap">
        <a href="/orders" class="cat_item">
            <div class="cat_img"><img src="/img/cat5.png" alt=""></div>
            <div class="cat_desk">Финансы<br/>Покупки</div>
        </a>
    </div>-->
</div>
