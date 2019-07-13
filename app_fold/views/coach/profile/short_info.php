<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="row cat_item_block">
    <div class="tren_cat_item_tab">
        <?php if(!empty($user_data['user_age'])):?>
            <div class="tren_cat_item_cell">
                <a href="" class="tren_cat_item">
                    <div class="tren_cat_img"><img src="/img/cat6.png" alt=""></div>
                    <div class="tren_cat_desk">
                        <div class="tren_cat_desk_h"><?php echo $user_data['user_gender']; ?></div>
                        <div class="tren_cat_desk_txt"><?php echo $user_data['user_age']; ?></div>
                    </div>
                </a>
            </div>
        <?php endif;
        if (!empty($user_data['user_experience'])):?>
            <div class="tren_cat_item_cell">
                <a href="" class="tren_cat_item">
                    <div class="tren_cat_img"><img src="/img/cat7.png" alt=""></div>
                    <div class="tren_cat_desk">
                        <div class="tren_cat_desk_h">Тренерский стаж</div>
                        <div class="tren_cat_desk_txt"><?php echo $user_data['user_experience']; ?></div>
                    </div>
                </a>
            </div>
        <?php endif;
        if (!empty($user_data['user_titles_awards'])):?>
            <div class="tren_cat_item_cell">
                <a href="" class="tren_cat_item">
                    <div class="tren_cat_img"><img src="/img/cat8.png" alt=""></div>
                    <div class="tren_cat_desk">
                        <div class="tren_cat_desk_h">Титулы и награды</div>
                        <div class="tren_cat_desk_cont"><?php echo $user_data['user_titles_awards']; ?></div>
                    </div>
                </a>
            </div>
        <?php endif;?>
    </div>
</div>