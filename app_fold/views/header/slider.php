<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$display_none  = (empty($site_info) or $site_info['advertising_display'] == 0) ? true : false;
$display_all   = (!empty($site_info) and $site_info['advertising_display'] == 1 and !empty($user_session) and $user_session['advertising'] == 1) ? true : false;
$display_admin = (!empty($site_info) and $site_info['advertising_display'] == 2 and !empty($user_session) and $user_session['type'] == 3) ? true : false;
?>
<div class="header_bg <?php if($main_banner === true):?>header_bg_main<?php endif;?>">
    <?php if(!empty($site_info) and ($display_none !== false or $display_all or $display_admin) and
        ((!empty($site_info['advertising_horizontal']) and empty($site_info['advertising_horizontal_hide'])) or
            (!empty($site_info['advertising_horizontal_mobile']) and empty($site_info['advertising_horizontal_mobile_hide'])))): ?>
        <?php if(!empty($site_info['advertising_horizontal']) and empty($site_info['advertising_horizontal_hide'])): ?>
            <div class="advertising">
                <?php echo $site_info['advertising_horizontal']; ?>
            </div>
        <?php endif; ?>
        <?php if(!empty($site_info['advertising_horizontal_mobile']) and empty($site_info['advertising_horizontal_mobile_hide'])): ?>
            <div class="advertising mobile">
                <?php echo $site_info['advertising_horizontal_mobile']; ?>
            </div>
        <?php endif; ?>
        <?php $advertising_banner = true; ?>
    <?php elseif (!empty($site_info['banners'])):?>
        <?php foreach($site_info['banners'] as $si_banner): ?>
            <?php if(!empty($si_banner['video_url']) or !empty($si_banner['image'])):
                if (!empty($si_banner['url'])):?>
                    <a href="<?php echo $si_banner['url'];?>">
                <?php endif;?>

                <div class="sing-in_bg">
                    <?php if(!empty($si_banner['video_url'])):
                        $remove_url = $si_banner['video_url'];
                        $key = 0; ?>
                        <?php //include('./app_fold/views/video/player/vimeo_player_item.php'); ?>
                        <div data-vimeo-url="<?php echo $remove_url; ?>?autoplay=1" id="banner-vimeo-player-<?php echo $key; ?>" class="vimeo_players" data-vimeo-width="1903" data-vimeo-height="350" data-vimeo-loop="true" data-vimeo-autoplay="true" data-vimeo-background="true" data-vimeo-allow="autoplay; encrypted-media"></div>
                        <?php $key++; ?>
                    <?php else: ?>
                        <img src="<?php echo $si_banner['image'];?>" alt="">
                    <?php endif; ?>
                </div>

                <?php if (!empty($si_banner['url'])):?>
                    </a>
                <?php endif;?>
            <?php endif;?>
        <?php endforeach;
        unset($si_banner); ?>
        <?php $standard_banner = true; ?>
    <?php endif;?>
</div>
<?php if(empty($advertising_banner)): include_once('./app_fold/views/header/banner_js.php'); endif;?>
