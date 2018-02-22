<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="content" class="container">
    <div class="row">
        <div class="col-lg-2 left_sidebar">
            <?php include_once('./app_fold/views/admin/admin_menu.php');?>
        </div><!-- left_sidebar -->
        <div class="col-lg-10 content_col">
            <?php if (!empty($subcategories)) :
                foreach ($subcategories as $subcategory) :?>
                    <div onclick="location.href='/administration/category/<?php echo $subcategory['id']; ?>'" style="cursor: pointer;">
                        <?php echo $subcategory['name']; ?>
                    </div>
                <?php endforeach;
                unset($subcategory);
            endif;?>
        </div><!-- content_col -->
    </div>
</div><!-- content -->
