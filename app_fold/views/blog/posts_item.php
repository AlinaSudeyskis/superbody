<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="subscription_block_item">
    <div class="subscription_block_h"><a href="<?php echo $post_path.$post['id'];?>"><?php echo $post['title'];?></a></div>
    <div class="subscription_block_txt"><?php echo $post['short_desc'];?></div>
    <div class="subscription_block_link">
        <a href="/profile/<?php echo $post['user']['id']?>"><?php echo $post['user']['name']?></a>
        <span><?php echo $post['date'];?></span>
    </div>
</div>
