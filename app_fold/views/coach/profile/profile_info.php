<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="content_block new_content_block">
    <div class="content_block_h parent">
        <h3>Профиль</h3>
        <div class="content_block_h_buts">
            <div class="content_block_h_slide kurs_slide"></div>
            <div class="content_block_h_close"></div>
        </div>
    </div>
    <div class="kurs_block_val">
        <div class="tren_prof_page_block parent">
            <div class="tren_prof_page_img_wrap">
                <?php if (!empty($user_data['user_image'])) :?>
                    <div class="tren_prof_page_img"><img src="<?php echo $user_data['user_image'];?>" alt=""></div>
                <?php endif;?>
                <div class="tren_prof_page_name"><?php echo $user_data['split_name']['name'];?></div>
                <div class="tren_prof_page_surname"><?php if (!empty($user_data['split_name']['surname'])) { echo $user_data['split_name']['surname']; }?></div>
                <div class="tren_prof_page_soc">
                    <?php if(!empty($user_social)):
                        if($user_social['facebook']['connect'] === true and $user_social['facebook']['available'] == 1):?>
                            <a href="<?php echo $user_social['facebook']['profile_url']; ?>"><i class="fa fa-facebook" aria-hidden="true"></i></a><!-- https://www.facebook.com/profile.php?id=<?php //echo $user_social['facebook']['id']; ?> -->
                        <?php endif;
                        if($user_social['vk']['connect'] === true and $user_social['vk']['available'] == 1):?>
                            <a href="https://vk.com/id<?php echo $user_social['vk']['id']; ?>"><i class="fa fa-vk" aria-hidden="true"></i></a>
                        <?php endif;
                        if($user_social['ok']['connect'] === true and $user_social['ok']['available'] == 1):?>
                            <a href="https://ok.ru/profile/<?php echo $user_social['ok']['id']; ?>"><i class="fa fa-odnoklassniki" aria-hidden="true"></i></a>
                        <?php endif;
                        if($user_social['instagram']['connect'] === true and $user_social['instagram']['available'] == 1):?>
                            <a href="<?php echo $user_social['instagram']['profile_url']; ?>">
                                <i class="fa fa-instagram" aria-hidden="true"></i>
                            </a><!--https://www.instagram.com/<?php //echo $user_social['instagram']['id']; ?> -->
                        <?php endif;
                    endif;?>
                </div>
            </div>
            <div class="tren_prof_page_cont">
                <div class="tren_prof_page_stat"><?php if (!empty($user_data['user_specialization'])) { echo $user_data['user_specialization']; }?></div>
                <div class="tren_prof_page_txt"><?php if (!empty($user_data['user_about'])) : echo nl2br($user_data['user_about']); else: echo 'Тренер еще не добавил информацию о себе'; endif; ?></div>
            </div>
        </div>
    </div>
</div>