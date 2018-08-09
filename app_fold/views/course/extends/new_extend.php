<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<form action="" method="post" enctype="multipart/form-data">
    <div class="admin_form_buts_wrap_container">
        <div class="admin_form_buts_wrap parent">
            <input type="submit" name="bt_save_new_extend" value="Сохранить" class="video_admin_form_send">
        </div>
    </div>
    <div class="video_admin_form">
        <?php include_once('./app_fold/views/course/extends/settings_item.php');?>
    </div>
</form>