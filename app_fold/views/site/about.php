<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$breadcrumbs = array('/about' => 'О нас');
include_once('./app_fold/views/breadcrumb.php');
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
        <?php if (!empty($coaches)):
            foreach($coaches as $coach):?>
                <?php include('./app_fold/views/coach/coach_item.php');?>
            <?php endforeach;
            unset($coach);
        endif;?>
    </div>
</div><!-- content -->
