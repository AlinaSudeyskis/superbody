<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<form action="" method="post" enctype="multipart/form-data">
    <div class="admin_form_buts_wrap_container">
        <div class="admin_form_buts_wrap parent">
            <?php if ($extend['blocked'] == 0) :?>
                <input type="submit" name="bt_block_extend" value="Заблокировать" class="video_admin_form_block"/>
            <?php else :?>
                <input type="submit" name="bt_unblock_extend" value="Разблокировать" class="video_admin_form_block"/>
            <?php endif;?>
            <input type="submit" name="bt_save_extend" value="Сохранить" id="defaultActionButton"  class="video_admin_form_send">
        </div>
    </div>
    <div class="video_admin_form">
        <?php include_once('./app_fold/views/course/extends/settings_item.php');?>
    </div>
</form>