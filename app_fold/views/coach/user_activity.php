<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="content" class="container">
    <div class="row">
        <div class="col-lg-2 left_sidebar">
            <?php include_once('./app_fold/views/coach/coach_menu.php');?>
        </div><!-- left_sidebar -->
        <div class="col-lg-10 content_col">
            <div class="content_block new_content_block">
                <div class="content_block_h parent">
                    <h3>Профиль</h3>
                    <div class="content_block_h_buts">
                        <div class="content_block_h_slide kurs_slide"></div>
                        <div class="content_block_h_close"></div>
                    </div>
                </div>
                <div class="kurs_block_val">
                    <?php if(!empty($user_data)):?>
                        <div class="tren_prof_page_block parent">
                            <div class="tren_prof_page_img_wrap">
                                <div class="tren_prof_page_img"><?php if (!empty($user_data['user_image'])) :?><img src="<?php echo $user_data['user_image'];?>" alt=""><?php endif;?></div>
                                <div class="tren_prof_page_name"><?php echo $user_data['split_name']['name'];?></div>
                                <div class="tren_prof_page_surname"><?php echo $user_data['split_name']['surname'];?></div>
                                <div class="tren_prof_page_soc">
                                    <a href=""><i class="fa fa-vk" aria-hidden="true"></i></a>
                                    <a href=""><i class="fa fa-facebook" aria-hidden="true"></i></a>
                                    <a href=""><i class="fa fa-instagram" aria-hidden="true"></i></a>
                                </div>
                            </div>
                            <div class="tren_prof_page_cont">
                                <div class="tren_prof_page_stat">Антропометрические данные</div>
                                <div class="tren_prof_page_txt"><?php include_once('./app_fold/views/user/questionnaire/anthropometric_info.php'); ?></div>
                            </div>
                        </div>
                    <?php else: ?>
                        <h3 class="info">Информация не найдена</h3>
                    <?php endif;?>

                    <?php if (!empty($anthropometric)): ?>
                        <div class="anketa_block_item" style="display: block;">
                            <div class="anketa_block_item_h">Прогресс</div>
                            <div class="anketa_block_item_cont">
                                <?php include_once('./app_fold/views/user/questionnaire/charts.php'); ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div><!-- content_col -->
    </div>
</div><!-- content -->

