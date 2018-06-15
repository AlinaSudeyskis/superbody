<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="anketa_block_item">
    <div class="anketa_block_item_cont">
        <div class="admin_list">
            <?php if (!empty($reviews)) :
                $path = ($page_menu == 'a_courses_w') ? 'course' : 'nutrition';
                foreach ($reviews as $review) : ?>
                    <div class="admin_item">
                        <a class="admin_feedback_link parent" href="/administration/<?php echo $path;?>/<?php echo $course_id;?>/review/<?php echo $review['id'];?>">
                            <span class="admin_feedback_time_wrap parent">
                                <span class="admin_feedback_time"><?php echo $review['time']; ?></span>
                                <span class="admin_feedback_date"><?php echo $review['date']; ?></span>
                            </span>
                            <span class="admin_feedback_cont parent">
                                <span class="admin_review_info parent">
                                    <span class="admin_review_info_dialog" title="<?php echo $review['user']['name']; ?>"><?php echo $review['user']['name']; ?></span>
                                </span>
                                <span class="admin_review_txt" title="<?php echo $review['text']; ?>"><?php echo $review['text']; ?></span>
                            </span>
                        </a>
                    </div>
                <?php endforeach;
                unset($review);
            endif;?>
        </div>
        <?php include_once('./app_fold/views/pagination.php'); ?>
    </div>
</div>