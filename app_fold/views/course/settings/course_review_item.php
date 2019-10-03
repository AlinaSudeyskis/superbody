<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!empty($review)) :?>
    <form action="" method="post">
        <div class="admin_form_buts_wrap_container">
            <div class="admin_form_buts_wrap parent">
                <input type="submit" name="bt_save_review" value="Сохранить" id="defaultActionButton"  class="video_admin_form_send" />
                <input type="submit" name="bt_delete_review" value="Удалить" class="video_admin_form_block" />
                <?php if ($review['approval'] == 0):?>
                    <input type="submit" name="bt_approval_review" value="Одобрить" class="video_admin_form_block" />
                <?php else: ?>
                    <input type="submit" name="bt_reject_review" value="Отклонить" class="video_admin_form_block" />
                <?php endif;?>
            </div>
        </div>

        <div class="video_admin_form">
            <div class="lend_form_h">Текст отзыва:</div>
            <textarea name="ta_review_text" class="tov_form_textarea" required="required"><?php echo $review['text'];?></textarea>
            <div class="comment_page_cont_link"><a href="/profile/<?php echo $review['user']['id'];?>"><?php echo $review['user']['name'];?></a></div>
        </div>
    </form>
<?php endif;?>