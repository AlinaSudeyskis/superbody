<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="col-lg-4 col-md-6 col-sm-6 col-xs-6">
    <div class="kurs_page_block parent">
        <div class="kurs_page_block_cont">
            <div class="kurs_page_block_h"><?php echo $course['name']; ?></div>
            <div class="kurs_page_block_desk"><?php echo $course['description']; ?></div>
            <div class="kurs_page_block_slider">
                <?php if (!empty($course['couches'])) :
                    foreach ($course['couches'] as $course_couch) :?>
                        <div class="kurs_page_block_slide parent">
                            <div class="kurs_page_block_slide_img">
                                <?php if (!empty($course_couch['image'])):?>
                                    <img src="<?php echo $course_couch['image'];?>" alt="">
                                <?php endif;?>
                            </div>
                            <div class="kurs_page_block_slide_cont">
                                <div class="kurs_page_block_slide_stat">тренер</div>
                                <div class="kurs_page_block_slide_name"><a href="/profile/<?php echo $course_couch['id'];?>"><?php echo $course_couch['name'];?></a></div>
                                <div class="kurs_page_block_slide_desk"><?php echo $course_couch['special'];?></div>
                            </div>
                        </div>
                    <?php endforeach;
                    unset($course_couch);
                endif;?>
            </div>
            <div class="kurs_page_block_but parent">
                <a href="/course/<?php echo $course['id'];?>" class="kurs_page_block_more">узнать больше</a>
                <a href="#" class="kurs_page_block_tab">расписание</a>
            </div>
        </div>
        <div class="kurs_page_block_img">
            <?php if (!empty($course['image'])):?>
                <img src="<?php echo $course['image'];?>" alt="">
            <?php endif;?>
        </div>
    </div>
</div>
