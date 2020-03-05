<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="revive_item parent">
    <div class="revive_ava">
        <?php if(!empty($review['user']['image'])):?>
            <img src="<?php echo $review['user']['image']; ?>" alt="">
        <?php else: ?>
            <img src="/img/no_img.png" alt="">
        <?php endif;?>
    </div>
    <div class="revive_cont">
        <div class="revive_desk"><?php echo $review['text']; ?></div>
        <div class="revive_data"><?php echo $review['date_add']; ?></div>
    </div>
</div>
