<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="anketa_block_item">
    <div class="anketa_block_item_cont">
        <form action="" method="post" class="anketa_form video_admin_form" enctype="multipart/form-data">
            <?php include_once('./app_fold/views/promocodes/settings_item.php');?>

            <div class="video_admin_form_buts parent">
                <input type="submit" name="bt_save_new_promocode" value="Сохранить" class="video_admin_form_send">
            </div>
        </form>
    </div>
</div>