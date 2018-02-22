<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container txt_wrap">
    <h2 class="block_h">несколько слов о нашем проекте</h2>
    <div class="txt_block parent">
        <div class="parent"><img class="img_l" src="/img/content_img.jpg" alt=""><?php if (!empty($site_info['about'])): echo $site_info['about']; endif;?></div><br>
        <div class="txt_block_col"></div>
    </div>
</div><!-- txt_wrap -->

<?php include_once('./app_fold/views/site/content/auth_info_block.php'); ?>

<div class="container"><h2 class="block_h">Наши тренера</h2></div>
<div id="content" class="container">
    <div class="trainers_row row">
        <?php if (!empty($couches)):
            foreach($couches as $couch):?>
                <?php include('./app_fold/views/couch/couch_item.php');?>
            <?php endforeach;
            unset($couch);
        endif;?>
    </div>
</div><!-- content -->
