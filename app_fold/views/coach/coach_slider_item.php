<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="tren_item">
    <div class="tren_ava">
        <a href="/profile/<?php echo $coach['id']?>">
            <img src="<?php if (!empty($coach['image'])): echo $coach['image']; endif;?>" alt="">
        </a>
    </div>
    <a href="/profile/<?php echo $coach['id']?>" class="tren_link">
        <span class="tren_name"><?php echo $coach['name']?></span>
        <span class="tren_surname"><?php echo $coach['surname']?></span>
    </a>
    <div class="tren_desk"><?php echo $coach['special']?></div>
    <div class="tren_buts parent">
        <!--<div class="tren_buts_l">
            <button class="love_but"></button>
            <button class="like_but"></button>
        </div>
        <div class="tren_buts_r">
            <a href="" class="f_but"></a>
            <a href="" class="tw_but"></a>
        </div>-->
        <?php $user_social = $coach['user_social']; ?>
        <?php include('./app_fold/views/user/profile/user_soc.php'); ?>
        <a href="/messages/<?php echo $coach['id']?>" class="tren_mess_link" title="Написать тренеру">
            <i class="fas fa-envelope" aria-hidden="true"></i>
        </a>
    </div>
</div>