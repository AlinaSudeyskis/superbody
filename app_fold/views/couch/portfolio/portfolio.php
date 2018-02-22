<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="content" class="container">
    <div class="row">
        <div class="col-lg-2 left_sidebar">
            <?php include_once('./app_fold/views/couch/couch_menu.php');?>
        </div><!-- left_sidebar -->
        <div class="col-lg-10 content_col">
            <?php /*if (!empty($portfolio)) :
                foreach ($portfolio as $image) :*/?><!--
                    <form action="" method="post">
                        <div><img src="<?php /*echo $image['image_path'];*/?>" width="200"/></div>
                        <div><input type="submit" name="bt_delete_portfolio_img" value="Удалить"/></div>
                        <div><input type="hidden" name="img_id" value="<?php /*echo $image['image_id'];*/?>"/></div>
                        <div><input type="hidden" name="img_path" value="<?php /*echo $image['image_path'];*/?>"/></div>
                    </form>
                --><?php /*endforeach;
                unset($image);
            endif;*/?>
            <?php include_once('./app_fold/views/couch/portfolio/portfolio_item.php');?>
        </div><!-- content_col -->
    </div>
</div><!-- content -->
