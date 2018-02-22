<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="content" class="container">
    <div class="row">
        <div class="col-lg-2 left_sidebar">
            <?php include_once('./app_fold/views/user/user_menu.php');?>
        </div><!-- left_sidebar -->
        <div class="col-lg-10 content_col">
            <div><?php echo $title;?></div>
            <?php if (!empty($user_data['image'])) :?>
                <img src="<?php echo $user_data['image']?>" width="300"/>
            <?php endif;?>
        </div><!-- content_col -->
    </div>
</div><!-- content -->
