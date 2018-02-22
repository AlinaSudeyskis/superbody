<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php include_once('./app_fold/views/course/user_course/page_part/header.php');?>
    <div class="anketa_block_cont">
        <div class="anketa_block_item">
            <div class="anketa_block_item_cont">
                <div class="video_admin_form">
                    <form action="" class="mess_block_form" method="post">
                        <textarea name="ta_review_text" class="mess_block_in" placeholder="Оставить отзыв" required="required"></textarea>
                        <input type="submit" name="bt_save_review" value="Отправить" class="mess_block_but" />
                    </form>
                </div>
                <?php if (!empty($reviews)) :?>
                    <div class="admin_list">
                        <?php foreach ($reviews as $review) : ?>
                            <div class="admin_item">
                                <a class="admin_feedback_link parent" href="/profile/course/<?php echo $course['course_id'];?>/review/<?php echo $review['id'];?>">
                                    <span class="admin_feedback_time_wrap parent">
                                        <span class="admin_feedback_time"><?php echo $review['time']; ?></span>
                                        <span class="admin_feedback_date"><?php echo $review['date']; ?></span>
                                    </span>
                                    <span class="admin_feedback_cont parent">
                                        <span class="admin_review_info parent">
                                            <span class="admin_review_info_dialog"><?php echo $course['name']; ?></span>
                                        </span>
                                        <span class="admin_review_txt"><?php echo $review['text']; ?></span>
                                    </span>
                                </a>
                            </div>
                        <?php endforeach;
                        unset($review);?>
                        <?php include_once('./app_fold/views/pagination.php'); ?>
                    </div>
                <?php endif;?>
            </div>
        </div>
    </div>
<?php include_once('./app_fold/views/course/user_course/page_part/footer.php');?>