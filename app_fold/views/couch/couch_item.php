<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
    <div class="trainers_block parent">
        <div class="tren_item">
            <div class="tren_ava">
                <?php if (!empty($couch['image'])):?>
                    <img src="<?php echo $couch['image']?>" alt="">
                <?php endif;?>
            </div>
            <?php $profile_link = !empty($couch['id']) ? '/profile/'.$couch['id'] : '';?>
            <a href="<?php echo $profile_link; ?>" class="tren_link">
                <span class="tren_name"><?php if (!empty($couch['name'])) { echo $couch['name']; }?></span>
                <span class="tren_surname"><?php if (!empty($couch['surname'])) { echo $couch['surname']; }?></span>
            </a>
            <div class="tren_desk"><?php if (!empty($couch['special'])) { echo $couch['special']; }?></div>
            <div class="tren_buts parent disabled">
                <div class="tren_buts_l">
                    <button class="love_but"></button>
                    <button class="like_but"></button>
                </div>
                <div class="tren_buts_r">
                    <a href="" class="f_but"></a>
                    <a href="" class="tw_but"></a>
                </div>
            </div>
        </div>
        <div class="trainers_cont">
            <div class="trainers_h">Титулы и награды</div>
            <div class="trainers_txt">
                <?php if (!empty($couch['titles_awards'])):
                    echo $couch['titles_awards'];
                else:?>
                    Нет информации
                <?php endif; ?>
            </div>
            <div class="trainers_h">О себе</div>
            <div class="trainers_txt">
                <?php if (!empty($couch['about'])):
                    echo $couch['about'];
                else: ?>
                    Тренер еще не добавил информацию о себе
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>