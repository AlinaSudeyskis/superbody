<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="row user_prof_wrap">
    <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12 user_prof">
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
                            <?php include_once('./app_fold/views/user/profile/user_soc.php'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content_block new_content_block">
            <div class="notification_block_h"><a href="/messages/<?php echo $user_data['user_id'];?>">Написать тренеру</a></div>
        </div>
    </div>
    <div class="col-lg-9 col-md-9 col-sm-8 col-xs-12 user_prog">
        <div class="content_block new_content_block">
            <div class="content_block_h parent">
                <h3>О тренере</h3>
                <div class="content_block_h_buts">
                    <div class="content_block_h_slide kurs_slide"></div>
                    <div class="content_block_h_close"></div>
                </div>
            </div>
            <div class="kurs_block_val">
                <div class="tren_prof_page_block parent">
                    <div class="tren_prof_page_cont">
                        <div class="tren_prof_page_stat"><?php if (!empty($user_data['user_specialization'])) { echo $user_data['user_specialization']; }?></div>
                        <div class="tren_prof_page_txt"><?php if (!empty($user_data['user_bbc_about'])) : echo $user_data['user_bbc_about']; else: echo 'Тренер еще не добавил информацию о себе'; endif; ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>