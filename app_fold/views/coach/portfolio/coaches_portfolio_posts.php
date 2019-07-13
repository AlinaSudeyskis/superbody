<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="content" class="container">
    <div class="row">
        <div class="col-lg-2 left_sidebar">
            <?php include_once('./app_fold/views/admin/admin_menu.php');?>
        </div><!-- left_sidebar -->
        <div class="col-lg-10 content_col">
            <div class="content_block new_content_block">
                <div class="content_block_container_wrap">
                    <div class="content_block_container">
                        <div class="content_block_h new_content_block_h parent">
                            <h3>Портфолио тренера</h3>
                        </div>
                    </div>
                </div>
                <div class="kurs_block_val">
                    <?php if (!empty($portfolio)):?>
                        <div class="tren_gal_row parent">
                            <?php foreach ($portfolio as $image) :?>
                                <div class="tren_gal_col">
                                    <div class="tren_gal_item">
                                        <div class="tren_gal_cont">
                                            <div class="tren_gal_img">
                                                <a href="/administration/coaches/portfolio/<?php echo $image['image_id'];?>"><img src="<?php echo $image['image_path'];?>" alt=""></a>
                                            </div>
                                            <div class="tren_gal_line">
                                                <!--<a href=""><i class="fa fa-heart-o" aria-hidden="true"></i></a>
                                                <a href=""><i class="fa fa-comment-o" aria-hidden="true"></i></a>-->
                                            </div>
                                            <div class="tren_gal_info">
                                                <div class="tren_gal_info_top">
                                                    <!--<div class="tren_gal_info_top_item"><i class="fa fa-heart" aria-hidden="true"></i><span>100</span></div>
                                                    <div class="tren_gal_info_top_item"><i class="fa fa-comment" aria-hidden="true"></i><span>100</span></div>-->
                                                </div>
                                                <div class="tren_gal_info_txt">
                                                    <span class="tren_gal_info_txt_val"><?php echo $image['image_desc'];?>...</span>
                                                    <a href="/administration/coaches/portfolio/<?php echo $image['image_id'];?>" class="tren_gal_info_txt_more">больше</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach;
                            unset($image);?>
                            <?php include_once('./app_fold/views/pagination.php');?>
                        </div>
                    <?php else: ?>
                        <h3 class="info">Информация не найдена</h3>
                    <?php endif; ?>
                </div>
            </div>
        </div><!-- content_col -->
    </div>
</div><!-- content -->