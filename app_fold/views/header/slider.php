<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php if (!empty($site_info['banners'])):
    foreach($site_info['banners'] as $si_banner):
        if (!empty($si_banner['url'])):?>
            <a href="<?php echo $si_banner['url'];?>">
        <?php endif;?>

        <div class="sing-in_bg"><img src="<?php echo $si_banner['image'];?>" alt=""></div>

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
</div>-->
