<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php include_once('./app_fold/views/video/page_part/header.php');?>
    <form action="" class="video_admin_form" method="post" enctype="multipart/form-data">
        <?php include_once('./app_fold/views/video/video_settings_item.php'); ?>
        <div class="video_admin_form_buts parent">
            <input type="submit" value="Добавить" class="video_admin_form_send" name="bt_save_video" />
        </div>
    </form>
<?php include_once('./app_fold/views/video/page_part/footer.php');?>
