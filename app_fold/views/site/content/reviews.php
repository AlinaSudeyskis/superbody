<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php if(!empty($reviews)):?>
    <div class="reviews_row row">
        <h2 class="block_h">ОТЗЫВЫ</h2>
        <?php foreach($reviews as $review):?>
            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-6">
                <div class="revive_item parent">
                    <div class="revive_ava"><?php if(!empty($review['user']['image'])):?> <img src="<?php echo $review['user']['image']; ?>" alt=""><?php endif;?></div>
                    <div class="revive_cont">
                        <div class="revive_desk"><?php echo $review['text']; ?></div>
                        <div class="revive_data"><?php echo $review['date_add']; ?></div>
                    </div>
                </div>
            </div>
        <?php endforeach;
        unset($review);?>
    </div><!-- reviews_row -->
<?php endif;?>