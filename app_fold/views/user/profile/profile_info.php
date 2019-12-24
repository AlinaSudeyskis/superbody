<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="content_block new_content_block">
    <div class="content_block_h parent">
        <h3><?php echo $profile_title; ?></h3>
        <div class="content_block_h_buts">
            <div class="content_block_h_slide kurs_slide"></div>
            <div class="content_block_h_close"></div>
        </div>
    </div>
    <div class="kurs_block_val">
        <div class="tren_prof_page_block parent">
            <?php if(!empty($user_data)): ?>
                <div class="tren_prof_page_img_wrap">
                    <?php if (!empty($user_data['image'])) :?>
                        <div class="tren_prof_page_img"><img src="<?php echo $user_data['image'];?>" alt=""></div>
                    <?php endif;?>
                    <div class="tren_prof_page_name"><?php echo $user_data['split_name']['name'];?></div>
                    <div class="tren_prof_page_surname"><?php if (!empty($user_data['split_name']['surname'])) { echo $user_data['split_name']['surname']; }?></div>
                    <div class="tren_prof_page_soc">
                        <?php include_once('./app_fold/views/user/profile/user_soc.php'); ?>
                    </div>
                </div>
                <!--<div class="tren_prof_page_cont">
                    <div class="tren_prof_page_stat"></div>
                    <div class="tren_prof_page_txt"></div>
                </div>-->
            <?php else: ?>
                <h3 class="info">Пользователь не найден</h3>
            <?php endif; ?>
        </div>
    </div>
</div>