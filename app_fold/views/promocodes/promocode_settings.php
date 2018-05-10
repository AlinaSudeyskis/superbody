<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="anketa_block_item">
    <div class="anketa_block_item_cont">
        <form action="" method="post" class="anketa_form video_admin_form" enctype="multipart/form-data">
            <?php include_once('./app_fold/views/promocodes/settings_item.php');?>

            <div class="video_admin_form_buts parent">
                <input type="submit" name="bt_save_promocode" value="Сохранить" class="video_admin_form_send">
                <?php if ($promocode['blocked'] == 0) :?>
                    <input type="submit" name="bt_block_promocode" value="Заблокировать" class="video_admin_form_block"/>
                <?php else :?>
                    <input type="submit" name="bt_unblock_promocode" value="Разблокировать" class="video_admin_form_block"/>
                <?php endif;?>
            </div>
        </form>
    </div>
</div>