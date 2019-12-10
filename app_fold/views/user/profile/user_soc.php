<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php if(!empty($user_social)):
    if($user_social['facebook']['connect'] === true and $user_social['facebook']['available'] == 1):
        $soc_profile_url = (!empty($user_social['facebook']['profile_url'])) ? $user_social['facebook']['profile_url'] : 'https://www.facebook.com/profile.php?id='.$user_social['facebook']['id']; ?>
        <a href="<?php echo $soc_profile_url; ?>"><i class="fab fa-facebook-f" aria-hidden="true"></i></a><!-- https://www.facebook.com/profile.php?id=<?php //echo $user_social['facebook']['id']; ?> -->
    <?php endif;
    if($user_social['vk']['connect'] === true and $user_social['vk']['available'] == 1): ?>
        <a href="https://vk.com/id<?php echo $user_social['vk']['id']; ?>"><i class="fab fa-vk" aria-hidden="true"></i></a>
    <?php endif;
    if($user_social['ok']['connect'] === true and $user_social['ok']['available'] == 1):  ?>
        <a href="https://ok.ru/profile/<?php echo $user_social['ok']['id']; ?>"><i class="fab fa-odnoklassniki" aria-hidden="true"></i></a>
    <?php endif;
    if($user_social['instagram']['connect'] === true and $user_social['instagram']['available'] == 1):?>
        <a href="<?php echo $user_social['instagram']['profile_url']; ?>">
            <i class="fab fa-instagram" aria-hidden="true"></i>
        </a><!--https://www.instagram.com/<?php //echo $user_social['instagram']['id']; ?> -->
    <?php endif;
endif;?>
