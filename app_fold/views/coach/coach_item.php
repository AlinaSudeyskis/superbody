<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12"
     <?php if(!empty($crs_coaches) and $crs_coaches === true): ?>
         onclick="location.href='/courses/coaches/<?php echo $coach['id'] ?>'"
         style="cursor:pointer;"
     <?php endif; ?>>
    <div class="trainers_block parent">
        <div class="tren_item">
            <div class="tren_ava">
                <?php if (!empty($coach['image'])):?>
                    <img src="<?php echo $coach['image']?>" alt="">
                <?php endif;?>
            </div>
            <?php $profile_link = !empty($coach['id']) ? '/profile/'.$coach['id'] : '';?>
            <a href="<?php echo $profile_link; ?>" class="tren_link">
                <span class="tren_name"><?php if (!empty($coach['name'])) { echo $coach['name']; }?></span>
                <span class="tren_surname"><?php if (!empty($coach['surname'])) { echo $coach['surname']; }?></span>
            </a>
            <div class="tren_desk"><?php if (!empty($coach['special'])) { echo $coach['special']; }?></div>
            <div class="tren_buts parent">
                <!--<div class="tren_buts_l">
                    <button class="love_but"></button>
                    <button class="like_but"></button>
                </div>
                <div class="tren_buts_r">
                    <a href="" class="f_but"></a>
                    <a href="" class="tw_but"></a>
                </div>-->
                <?php if(!empty($coach['user_social'])):
                    if($coach['user_social']['facebook']['connect'] === true and $coach['user_social']['facebook']['available'] == 1):
                        $soc_profile_url = (!empty($coach['user_social']['facebook']['profile_url'])) ? $coach['user_social']['facebook']['profile_url'] : 'https://www.facebook.com/profile.php?id='.$coach['user_social']['facebook']['id']; ?>
                        <a href="<?php echo $soc_profile_url; ?>"><i class="fab fa-facebook-f" aria-hidden="true"></i></a><!-- https://www.facebook.com/profile.php?id=<?php //echo $user_social['facebook']['id']; ?> -->
                    <?php endif;
                    if($coach['user_social']['vk']['connect'] === true and $coach['user_social']['vk']['available'] == 1): ?>
                        <a href="https://vk.com/id<?php echo $coach['user_social']['vk']['id']; ?>"><i class="fab fa-vk" aria-hidden="true"></i></a>
                    <?php endif;
                    if($coach['user_social']['ok']['connect'] === true and $coach['user_social']['ok']['available'] == 1):  ?>
                        <a href="https://ok.ru/profile/<?php echo $coach['user_social']['ok']['id']; ?>"><i class="fab fa-odnoklassniki" aria-hidden="true"></i></a>
                    <?php endif;
                    if($coach['user_social']['instagram']['connect'] === true and $coach['user_social']['instagram']['available'] == 1):?>
                        <a href="<?php echo $coach['user_social']['instagram']['profile_url']; ?>">
                            <i class="fab fa-instagram" aria-hidden="true"></i>
                        </a><!--https://www.instagram.com/<?php //echo $user_social['instagram']['id']; ?> -->
                    <?php endif;
                endif;?>
                <a href="/messages/<?php echo $coach['id']; ?>" class="tren_mess_link" title="Написать тренеру">
                    <i class="fas fa-envelope" aria-hidden="true"></i>
                </a>
            </div>
        </div>
        <div class="trainers_cont">
            <div class="trainers_h">Титулы и награды</div>
            <div class="trainers_txt">
                <?php if (!empty($coach['titles_awards'])):
                    echo $coach['titles_awards'];
                else:?>
                    Нет информации
                <?php endif; ?>
            </div>
            <div class="trainers_h">О себе</div>
            <div class="trainers_txt">
                <?php if (!empty($coach['bbc_about'])):
                    $temp = (mb_strlen($coach['bbc_about']) > 130) ? mb_substr($coach['bbc_about'], 0, 130) : null ;
                    $coach_about = (!empty($temp))
                        ? '<a href="/profile/'.$coach['id'].'">' . mb_substr($temp, 0, mb_strrpos($temp, ' ')) . '...</a>'
                        : $coach['bbc_about'];
                    echo $coach_about;
                else: ?>
                    Тренер еще не добавил информацию о себе
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>