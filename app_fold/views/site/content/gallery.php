<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="gal_row row">
    <!--<div class="col-lg-9 col-md-8 col-sm-8 col-xs-12">-->
    <?php if (!empty($gallery)):?>
        <h2 class="block_h">ГАЛЕРЕЯ</h2>
        <div class="gal_block" data-info="Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.">
            <?php $count_images = count($gallery);
            foreach($gallery as $key => $image):
                if ($key != 0 and ($key-1) != 0 and ($key % 2) == 0):?>
                    </div>
                <?php endif;
                if ($key == 0 or ($key % 2) == 0):?>
                    <div class="gal_slide">
                <?php endif;?>

                <div class="gal_item">
                    <a href="/portfolio/<?php echo $image['post_id'];?>">
                        <img src="<?php echo $image['path']; ?>" alt="">
                    </a><!-- data-lightbox="gal"  -->
                </div>

                <?php if ($key == ($count_images-1)):?>
                    </div>
                <?php endif;?>
            <?php endforeach;
            unset($image);?>
        </div>
    <?php endif;?>
    <!--</div>-->

    <!--<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h2 class="block_h">ПАРТНЕРЫ</h2>
        <div class="partners_block parent" data-info="Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.">
            <div class="partners_item"><a href=""><img src="/img/part_logo1.png" alt=""></a></div>
            <div class="partners_item"><a href=""><img src="/img/part_logo2.png" alt=""></a></div>
            <div class="partners_item"><a href=""><img src="/img/part_logo3.png" alt=""></a></div>
            <div class="partners_item"><a href=""><img src="/img/part_logo4.png" alt=""></a></div>
            <div class="partners_item"><a href=""><img src="/img/part_logo5.png" alt=""></a></div>
            <div class="partners_item"><a href=""><img src="/img/part_logo6.png" alt=""></a></div>
        </div>
    </div>-->
</div><!-- gal_row -->