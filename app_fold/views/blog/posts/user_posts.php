<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="content" class="container">
    <div class="row">
        <div class="col-lg-2 left_sidebar">
            <?php include_once('./app_fold/views/couch/couch_menu.php');?>
        </div><!-- left_sidebar -->
        <div class="col-lg-10 content_col">
            <?php // Блог
            include_once('./app_fold/views/blog/posts/user_posts_item.php');?>
        </div><!-- content_col -->
    </div>
</div><!-- content -->