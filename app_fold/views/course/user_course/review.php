<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php include_once('./app_fold/views/course/user_course/page_part/header.php');?>
    <div class="anketa_block_cont">
        <div class="anketa_block_item">
            <div class="anketa_block_item_cont">
                <?php if (!empty($review)) :
                    if ($review['approval'] == 1): ?>
                        <div class="comment_page_block">
                            <div class="parent">
                                <div class="comment_page_cont">
                                    <div class="comment_page_cont_txt comment_page_cont_note">*Отзыв одобрен (функции редактирования или удаления не доступны)</div>
                                    <div class="comment_page_cont_h"><?php echo $review['text'];?></div>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="video_admin_form">
                            <form action="" class="mess_block_form" method="post">
                                <textarea name="ta_review_text" class="tov_form_textarea" placeholder="Оставить отзыв" required="required"><?php echo $review['text'];?></textarea>

                                <div class="video_admin_form_buts parent">
                                    <input type="submit" name="bt_save_review" value="Сохранить" class="video_admin_form_send" />
                                    <input type="submit" name="bt_delete_review" value="Удалить" class="video_admin_form_block" />
                                </div>
                            </form>
                        </div>
                    <?php endif;
                endif;?>
            </div>
        </div>
    </div>
<?php include_once('./app_fold/views/course/user_course/page_part/footer.php');?>