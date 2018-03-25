<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="content" class="container">
    <div class="row">
        <div class="col-lg-2 left_sidebar">
            <?php include_once('./app_fold/views/couch/couch_menu.php');?>
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
                    <div class="tren_prof_page_block parent">
                        <div class="tren_prof_page_img_wrap">
                            <div class="tren_prof_page_img"><?php if (!empty($user_data['image'])) :?><img src="<?php echo $user_data['image'];?>" alt=""><?php endif;?></div>
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
                </div>
            </div>

            <?php
            if (!empty($anthropometric)) :
                include_once('./app_fold/views/user/questionnaire/charts.php');
            endif;?>
        </div><!-- content_col -->
    </div>
</div><!-- content -->

