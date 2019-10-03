<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php include_once('./app_fold/views/video/page_part/header.php');
    if (!empty($video)):?>
        <form action="" class="video_admin_form" method="post" enctype="multipart/form-data">
            <?php include_once('./app_fold/views/video/video_settings_item.php');?>
            <div class="video_admin_form_buts parent">
                <input type="submit" name="bt_save_video" value="Сохранить" id="defaultActionButton"  class="video_admin_form_send">
                <?php $dis_delete = (!empty($video['course_id']) and $video['course_id'] > 0) ? 'disabled' : '';?>
                <input type="submit" name="bt_delete_video" value="Удалить" class="video_admin_form_block <?php echo $dis_delete; ?>"/>
                <?php if ($video['blocked'] == 0) :?>
                    <input type="submit" name="bt_block_video" value="Заблокировать" class="video_admin_form_block"/>
                <?php else :?>
                    <input type="submit" name="bt_unblock_video" value="Разблокировать" class="video_admin_form_block"/>
                <?php endif;?>
            </div>
        </form>
    <?php else:?>
        <h3>Видео не найдено</h3>
    <?php endif;
include_once('./app_fold/views/video/page_part/footer.php');?>
