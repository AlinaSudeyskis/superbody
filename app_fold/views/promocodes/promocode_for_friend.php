<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php if(!empty($pc_for_friend) and $pc_for_friend['blocked'] == 0):?>
    <div class="content_block new_content_block notification_block">
        <div class="content_block_h parent">
            <h3><?php echo $pc_for_friend['name']; ?></h3>
            <div class="content_block_h_buts">
                <div class="content_block_h_slide kurs_slide"></div>
                <div class="content_block_h_close"></div>
            </div>
        </div>
        <h3 class="info"><?php echo $pc_for_friend['description']; ?> <?php echo $pc_for_friend['discount']; ?><?php echo $pc_for_friend['dt_unit']; ?></h3>
        <div class="kurs_block_val">
            <form action="" method="post" style="text-align: center;">
                <input type="button" value="Создать" class="full_photo_comm_reset" id="generate-friend-code" style="float: none; margin-bottom: 20px;"/>
                <div class="generated_code"></div>
            </form>
        </div>
    </div>
<?php endif; ?>