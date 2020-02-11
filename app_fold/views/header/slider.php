<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php if (!empty($site_info['banners'])):
    foreach($site_info['banners'] as $si_banner):
        if (!empty($si_banner['url'])):?>
            <a href="<?php echo $si_banner['url'];?>">
        <?php endif;?>

        <div class="sing-in_bg">
            <?php if(!empty($si_banner['video_url'])):
                $remove_url = $si_banner['video_url'];
                $key = 0; ?>
                <?php //include('./app_fold/views/video/player/vimeo_player_item.php'); ?>
                <div data-vimeo-url="<?php echo $remove_url; ?>?autoplay=1&background=1" id="banner-vimeo-player-<?php echo $key; ?>" class="vimeo_players" data-vimeo-width="1900" data-vimeo-loop="true" data-vimeo-autoplay="true" data-vimeo-allow="autoplay; encrypted-media"></div>
                <?php $key++; ?>
            <?php else: ?>
                <img src="<?php echo $si_banner['image'];?>" alt="">
            <?php endif; ?>
        </div>

        <?php if (!empty($si_banner['url'])):?>
            </a>
        <?php endif;?>
    <?php endforeach;
    unset($si_banner); ?>
<?php endif;?>
<!--<div class="sing-in_bg">
    <video class="g-section-video" autoplay="" loop="" muted="">
        <source id="xVideoMp4" src="/banners/de7cca5d89.mp4" type="video/mp4">
    </video>
</div>
<div class="sing-in_bg">
    <?php /*$remove_url = 'https://vimeo.com/248651771';
    $key = 0;
    include('./app_fold/views/video/player/vimeo_player_item.php');*/?>
</div>-->
