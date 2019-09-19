<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="col-lg-4 col-md-6 col-sm-6 col-xs-6">
    <div class="kurs_page_block parent">
        <div class="kurs_page_block_cont">
            <div class="kurs_page_block_h"><?php echo $course['name']; ?></div>
            <div class="kurs_page_block_desk"><?php echo $course['description']; ?></div>
            <div class="kurs_page_block_slider">
                <?php if (!empty($course['coaches'])) :
                    foreach ($course['coaches'] as $course_coach) :?>
                        <div class="kurs_page_block_slide parent">
                            <div class="kurs_page_block_slide_img">
                                <?php if (!empty($course_coach['image'])):?>
                                    <img src="<?php echo $course_coach['image'];?>" alt="">
                                <?php endif;?>
                            </div>
                            <div class="kurs_page_block_slide_cont">
                                <div class="kurs_page_block_slide_stat">тренер</div>
                                <div class="kurs_page_block_slide_name"><a href="/profile/<?php echo $course_coach['id'];?>"><?php echo $course_coach['name'];?></a></div>
                                <div class="kurs_page_block_slide_desk"><?php echo $course_coach['special'];?></div>
                            </div>
                        </div>
                    <?php endforeach;
                    unset($course_coach);
                endif;?>
            </div>
            <div class="kurs_page_block_but parent">
                <a href="/course/<?php echo $course['id'];?>" class="kurs_page_block_more">Узнать больше</a>
                <div class="kurs_page_block_tabs">
                    <?php if(!empty($course['recur_first']) or !empty($course['price'])): ?>
                        <a href="#" class="kurs_page_block_tab red_tab buy_course" data-cid="<?php echo $course['id']; ?>" data-po="full"><?php echo $course['price']; ?> РУБ / КУРС</a>
                        <?php if(!empty($course['recur_first'])): ?>
                            <a href="#" class="kurs_page_block_tab red_tab">ИЛИ</a>
                            <a href="#" class="kurs_page_block_tab red_tab buy_course" data-cid="<?php echo $course['id']; ?>" data-po="rec"><?php echo $course['recur_first']; ?> РУБ / МЕС</a>
                        <?php endif; ?>
                    <?php else: ?>
                        <a href="#" class="kurs_page_block_tab red_tab buy_course" data-cid="<?php echo $course['id']; ?>" data-po="full">Добавить в "Мои курсы"</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="kurs_page_block_img">
            <?php if (!empty($course['image'])):?>
                <img src="<?php echo $course['image'];?>" alt="">
            <?php endif;?>
        </div>
    </div>
</div>
