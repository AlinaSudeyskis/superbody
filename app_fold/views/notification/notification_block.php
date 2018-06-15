<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="content_block new_content_block notification_block">
    <div class="content_block_h parent">
        <h3>Уведомление</h3>
        <div class="content_block_h_buts">
            <div class="content_block_h_slide kurs_slide"></div>
            <div class="content_block_h_close"></div>
        </div>
    </div>
    <div class="kurs_block_val">
        <?php // Ссылка
        if(!empty($notif_block_h)): ?>
            <div class="notification_block_h"><?php echo $notif_block_h; ?></div>
        <?php endif;

        // Уведомление
        if(!empty($h3_info)): ?>
            <h3 class="info"><?php echo $h3_info; ?></h3>
        <?php else:
            if($course_blocked === true and !empty($course_blocked_info)):?>
                <h3 class="info"><?php echo $course_blocked_info; ?></h3>
            <?php endif;
            if($course_ends === true and !empty($course_ends_info)):?>
                <h3 class="info"><?php echo $course_ends_info; ?></h3>
            <?php endif;
            if($course_finished === true and !empty($course_finished_info)):?>
                <h3 class="info"><?php echo $course_finished_info; ?></h3>
            <?php endif;
        endif;

        // Отсчет времени окончания курса
        if($course_ends === true and $count_ends_down === true and !empty($course_ends_countdown)):?>
            <div class="countdown_wrap">
                <input type="hidden" value="<?php echo $course_ends_countdown; ?>" class="date_countdown"/>
                <div class="countdown"></div>
            </div>
        <?php endif;

        // Курсы продления
        if($course_finished === true and !empty($course_finished_extends)):?>
            <div class="notification_block_ext_wrap_h">Продлите курс или купите новый:</div>
            <div class="notification_block_ext_wrap">
                <?php foreach($course_finished_extends as $extend):?>
                    <div class="notification_block_ext">
                        <div class="notification_block_ext_h"><a href="/course/<?php echo $extend['course_id']; ?>"><?php echo $extend['course_name']; ?></a></div>
                        <div class="notification_block_ext_title"><?php echo $extend['promocode']; ?></div>
                        <div class="notification_block_ext_title">
                            <?php if(!empty($extend['new_price'])): ?>
                                <s><?php echo $extend['price']; ?> руб.</s> <?php echo $extend['new_price']; ?> руб.
                            <?php else: ?>
                                <?php echo $extend['price']; ?> руб.
                            <?php endif; ?>
                        </div>
                        <div class="notification_block_ext_countdown">
                            <input type="hidden" value="<?php echo $extend['date_countdown']; ?>" class="date_countdown"/>
                            <div class="countdown"></div>
                        </div>
                    </div>
                <?php endforeach;
                unset($extend);?>
            </div>
        <?php endif;

        // Курсы продления
        if($course_ends === true and !empty($course_ends_extends)):?>
            <div class="notification_block_ext_wrap_h">Продлите курс или купите новый:</div>
            <div class="notification_block_ext_wrap">
                <?php foreach($course_ends_extends as $extend):?>
                    <div class="notification_block_ext">
                        <div class="notification_block_ext_h"><a href="/course/<?php echo $extend['course_id']; ?>"><?php echo $extend['course_name']; ?></a></div>
                        <div class="notification_block_ext_title"><?php echo $extend['promocode']; ?></div>
                        <div class="notification_block_ext_title">
                            <?php if(!empty($extend['new_price'])): ?>
                                <s><?php echo $extend['price']; ?> руб.</s> <?php echo $extend['new_price']; ?> руб.
                            <?php else: ?>
                                <?php echo $extend['price']; ?> руб.
                            <?php endif; ?>
                        </div>
                        <div class="notification_block_ext_countdown">
                            <input type="hidden" value="<?php echo $extend['date_countdown']; ?>" class="date_countdown"/>
                            <div class="countdown"></div>
                        </div>
                    </div>
                <?php endforeach;
                unset($extend);?>
            </div>
        <?php endif;?>
    </div>
</div>