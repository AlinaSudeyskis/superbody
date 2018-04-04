<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="content_block new_content_block no_over">
    <div class="content_block_h new_content_block_h parent">
        <h3>Портфолио</h3>
        <?php $path = '/portfolio/post/';
        if (empty($outsider) and $user_data['user_blocked'] == 0):
            $path = '/portfolio/';?>
            <a href="/portfolio/post/new" class="add_tab_but">Добавить</a>
        <?php endif;?>
        <div class="content_block_h_buts">
            <div class="content_block_h_slide kurs_slide"></div>
            <div class="content_block_h_close"></div>
        </div>
    </div>
    <div class="kurs_block_val tren_gal_block_val">
        <?php if (!empty($portfolio)):?>
            <div class="tren_gal_row parent">
                <?php foreach ($portfolio as $image) :?>
                    <div class="tren_gal_col">
                        <div class="tren_gal_item">
                            <div class="tren_gal_cont">
                                <div class="tren_gal_img">
                                    <a href="<?php echo $path.$image['image_id'];?>"><img src="<?php echo $image['image_path'];?>" alt=""></a>
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
                                        <a href="/portfolio/<?php echo $image['image_id'];?>" class="tren_gal_info_txt_more">больше</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach;
                unset($image);?>
            </div>
        <?php else: ?>
            <div class="center_txt">Нет записей</div>
        <?php endif; ?>
        <?php include_once('./app_fold/views/pagination.php');?>
    </div>
</div>