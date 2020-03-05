<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php if(!empty($reviews)):?>
    <div class="reviews_row row">
        <h2 class="block_h">ОТЗЫВЫ</h2>
        <?php foreach($reviews as $review): ?>
            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                <?php include('./app_fold/views/site/content/review_item.php'); ?>
            </div>
        <?php endforeach;
        unset($review);?>
    </div><!-- reviews_row -->
<?php endif;?>