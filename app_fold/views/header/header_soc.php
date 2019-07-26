<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<ul class="header_soc">
    <?php if (!empty($site_info['soc_facebook'])):?>
        <li><a href="<?php echo $site_info['soc_facebook']; ?>"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
    <?php endif;
    if (!empty($site_info['soc_twitter'])):?>
        <li><a href="<?php echo $site_info['soc_twitter']; ?>"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
    <?php endif;
    if (!empty($site_info['soc_pinterest'])):?>
        <li><a href="<?php echo $site_info['soc_pinterest']; ?>"><i class="fa fa-pinterest" aria-hidden="true"></i></a></li>
    <?php endif;
    if (!empty($site_info['soc_google_p'])):?>
        <li><a href="<?php echo $site_info['soc_google_p']; ?>"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
    <?php endif;
    if (!empty($site_info['soc_tumblr'])):?>
        <li><a href="<?php echo $site_info['soc_tumblr']; ?>"><i class="fa fa-tumblr" aria-hidden="true"></i></a></li>
    <?php endif;
    if (!empty($site_info['soc_instagram'])):?>
        <li><a href="<?php echo $site_info['soc_instagram']; ?>"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
    <?php endif;
    if (!empty($site_info['soc_ok'])):?>
        <li><a href="<?php echo $site_info['soc_ok']; ?>"><i class="fa fa-odnoklassniki" aria-hidden="true"></i></a></li>
    <?php endif;
    if (!empty($site_info['soc_vk'])):?>
        <li><a href="<?php echo $site_info['soc_vk']; ?>"><i class="fa fa-vk" aria-hidden="true"></i></a></li>
    <?php endif;
    if (!empty($site_info['soc_youtube'])):?>
        <li><a href="<?php echo $site_info['soc_youtube']; ?>"><i class="fa fa-youtube-play" aria-hidden="true"></i></a></li>
    <?php endif;
    if (!empty($user_session['id']) and empty($pm_contacts)) : ?>
        <li><a href="/logout" id="logout"><img src="/img/but_in.png" alt=""></a></li>
    <?php endif;?>
</ul>