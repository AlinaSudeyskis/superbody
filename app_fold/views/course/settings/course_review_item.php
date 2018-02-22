<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="anketa_block_cont">
    <div class="anketa_block_item">
        <div class="anketa_block_item_cont">
            <?php if (!empty($review)) :?>
                <div class="video_admin_form">
                    <form action="" class="mess_block_form" method="post">
                        <textarea name="ta_review_text" class="tov_form_textarea" placeholder="Оставить отзыв" required="required"><?php echo $review['text'];?></textarea>
                        <div class="comment_page_cont_link"><a href="/profile/<?php echo $review['user']['id'];?>"><?php echo $review['user']['name'];?></a></div>

                        <div class="video_admin_form_buts parent">
                            <input type="submit" name="bt_save_review" value="Сохранить" class="video_admin_form_send" />
                            <input type="submit" name="bt_delete_review" value="Удалить" class="video_admin_form_block" />
                            <?php if ($review['approval'] == 0):?>
                                <input type="submit" name="bt_approval_review" value="Одобрить" class="video_admin_form_block" />
                            <?php else: ?>
                                <input type="submit" name="bt_reject_review" value="Отклонить" class="video_admin_form_block" />
                            <?php endif;?>
                        </div>
                    </form>
                </div>
            <?php endif;?>
        </div>
    </div>
</div>