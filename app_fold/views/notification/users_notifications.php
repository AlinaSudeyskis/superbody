<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="admin_item parent">
    <div class="admin_ava"></div>
    <div class="admin_cont">
        <div class="admin_name">
            <a href="/administration/notification/users/<?php echo $key; ?>"><?php echo $notification['text']; ?></a>
        </div>
        <div class="admin_set">
            <div class="journal_block_item_data"><?php echo $notification['date']; ?> <?php echo $notification['time']; ?></div>
        </div>
    </div>
</div>