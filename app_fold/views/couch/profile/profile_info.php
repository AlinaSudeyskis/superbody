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
                <div class="tren_prof_page_img"><?php if (!empty($data['user_image'])) :?><img src="<?php echo $data['user_image'];?>" alt=""><?php endif;?></div>
                <div class="tren_prof_page_name"><?php echo $data['split_name']['name'];?></div>
                <div class="tren_prof_page_surname"><?php if (!empty($data['split_name']['surname'])) { echo $data['split_name']['surname']; }?></div>
                <div class="tren_prof_page_soc disabled">
                    <a href=""><i class="fa fa-vk" aria-hidden="true"></i></a>
                    <a href=""><i class="fa fa-facebook" aria-hidden="true"></i></a>
                    <a href=""><i class="fa fa-instagram" aria-hidden="true"></i></a>
                </div>
            </div>
            <div class="tren_prof_page_cont">
                <div class="tren_prof_page_stat"><?php if (!empty($data['user_specialization'])) { echo $data['user_specialization']; }?></div>
                <div class="tren_prof_page_txt"><?php if (!empty($data['user_about'])) : echo nl2br($data['user_about']); else: echo 'Тренер еще не добавил информацию о себе'; endif; ?></div>
            </div>
        </div>
    </div>
</div>