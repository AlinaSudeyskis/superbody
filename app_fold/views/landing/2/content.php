<?php
defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php if($landing['hide'] === false):
    $bl1_bg_color = (!empty($landing['bg_color'])) ? 'background: ' . $landing['bg_color'] . ';' : '';?>
    <div class="lp_header_wrap" style="<?php echo $bl1_bg_color; ?>">
        <div class="lp_header_bg">
            <?php if (!empty($landing['slider_images'])) :
                $img_opacity = ($landing['slider_opacity'] > 0) ? 'opacity: '.$landing['slider_opacity'] : '';
                foreach ($landing['slider_images'] as $slider_image) : ?>
                    <div class="lp_header_slide"><img src="<?php echo $slider_image;?>" alt="" style="<?php echo $img_opacity; ?>"></div>
                <?php endforeach;
                unset($slider_image);
            endif;?>
        </div>
        <script>
            $('.lp_header_bg').slick({
                dots: true,
                infinite: true,
                autoplaySpeed: 5000,
                speed: 500,
                autoplay: true,
                arrows: false
            });
        </script>
        <div class="lp_top_head_wrap">
            <div class="lp_top_head container">
                <a href="/" class="lp_top_head_logo"><img src="/img/logo.png" alt=""></a>
            </div>
        </div>
        <div class="lp_header_cont">
            <div class="lp_header container">
                <h1 class="lp_h1"><?php echo $landing['main_title']; ?></h1>
                <?php if(!empty($landing['main_button'])): ?>
                    <span class="lp_block_desc lp_block1_but parent lp_desc" data-desc='<?php echo $landing['main_description']; ?>'><?php echo $landing['main_button']; ?></span>
                <?php endif; ?>
                <div class="lp_scroll_ico"><img src="/landing/default/1/lp_ico1.png" alt=""></div>
            </div>
        </div>
    </div><!-- lp_header_wrap -->
<?php endif;?>

<?php if($landing['block2']['hide'] === false):
    $bl2_bg_color = (!empty($landing['block2']['bg_color'])) ? 'background: ' . $landing['block2']['bg_color'] . ';' : '';
    $bl2_bg = (!empty($landing['block2']['bg'])) ? 'background: ' . $landing['block2']['bg'] . ';' : '';
    $bl2_bg_opacity = ($landing['block2']['bg_opacity'] > 0) ? 'opacity: ' . $landing['block2']['bg_opacity'] . ';' : '';
?>
    <div class="lp_block1_wrap" style="<?php echo $bl2_bg_color; ?>">
        <div class="lp_block_bg" style="<?php echo $bl2_bg; ?> <?php echo $bl2_bg_opacity; ?>"></div>
        <div class="lp_block1 container">
            <div class="lp_block1_img">
                <?php if(!empty($landing['main_video_url'])): ?>
                    <div class="video_col">
                        <?php $remote_url = $landing['main_video_url'];
                        $key = 0;
                        include('./app_fold/views/video/player/vimeo_player_item.php'); ?>
                        <script>
                            playerTwoPlayer = new Vimeo.Player('vimeo-player-0', options);
                        </script>
                    </div>
                <?php endif; ?>
            </div>
            <div class="lp_block1_cont">
                <h2 class="lp_block1_h"><?php echo $landing['block2']['title']; ?></h2>
                <div class="lp_block1_desk"><?php echo $landing['block2']['subtitle']; ?></div>
                <div class="lp_block1_txt"><?php echo $landing['block2']['text']; ?></div>
                <?php if (!empty($landing['block2']['button'])):?>
                    <div class="lp_block_buts_wrap">
                        <a href="#" class="lp_block_but lp_block0_but parent"><?php echo $landing['block2']['button']; ?></a>
                        <?php if(!empty($course['recur_first']) or !empty($course['price'])): ?>
                            <div class="video_col_but">
                                <div class="video_col_but_left">
                                    <a href="#" class="lp_block_but_crs"><?php echo $course['price']; ?> РУБ / КУРС</a>
                                </div>
                                <?php if(!empty($course['recur_first'])): ?>
                                    <div class="video_col_but_right">или</div>
                                    <div class="video_col_but_right">
                                        <a href="#" class="lp_block_but_rec_crs"><?php echo $course['recur_first']; ?> РУБ / МЕС</a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php elseif($course['price'] == 0): ?>
                            <div class="video_col_but">
                                <div class="video_col_but_right">
                                    <a href="#" class="lp_block_but_rec_crs">Добавить в "Мои курсы"</a>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif;?>
            </div>
        </div>
    </div><!-- lp_block1_wrap -->
<?php endif; ?>

<?php if($landing['block3']['hide'] === false):
    $bl3_bg_color = (!empty($landing['block3']['bg_color'])) ? 'background: ' . $landing['block3']['bg_color'] . ';' : '';
    $bl3_bg = (!empty($landing['block3']['bg'])) ? 'background-image: ' . $landing['block3']['bg'] . ';' : '';
    $bl3_bg_opacity = ($landing['block3']['bg_opacity'] > 0) ? 'opacity: ' . $landing['block3']['bg_opacity'] . ';' : '';
?>
    <div class="lp_block2_wrap" style="<?php echo $bl3_bg_color; ?>">
        <div class="lp_block_bg" style="<?php echo $bl3_bg; ?> <?php echo $bl3_bg_opacity; ?>"></div>
        <div class="lp_block2 container">
            <h2 class="lp_block2_h"><?php echo $landing['block3']['title']; ?></h2>
            <div class="lp_block2_cont parent">
                <div class="lp_block2_cont_l">
                    <div class="lp_block2_cont_h"><?php echo $landing['block3']['subtitle']; ?></div>
                    <div class="lp_block2_cont_row parent">
                        <div class="lp_block2_cont_col"><img src="<?php echo $landing['block3']['image1']; ?>" alt=""></div>
                        <div class="lp_block2_cont_col"><img src="<?php echo $landing['block3']['image2']; ?>" alt=""></div>
                    </div>
                </div>
                <div class="lp_block2_cont_r">
                    <div class="lp_block2_cont_name"><?php echo $landing['block3']['r_title']; ?></div>
                    <div class="lp_block2_cont_desk"><?php echo $landing['block3']['r_subtitle']; ?></div>
                    <div class="lp_block2_cont_txt"><?php echo $landing['block3']['r_reviews']; ?></div>
                </div>
            </div>
        </div>
    </div><!-- lp_block2_wrap -->
<?php endif; ?>

<?php if($landing['block4']['hide'] === false):
    $bl4_bg_color = (!empty($landing['block4']['bg_color'])) ? 'background: ' . $landing['block4']['bg_color'] . ';' : '';
    $bl4_bg = (!empty($landing['block4']['bg'])) ? 'background-image: ' . $landing['block4']['bg'] . ';' : '';
    $bl4_bg_opacity = ($landing['block4']['bg_opacity'] > 0) ? 'opacity: ' . $landing['block4']['bg_opacity'] . ';' : '';
?>
    <div class="lp_block3_wrap" style="<?php echo $bl4_bg_color; ?>">
        <div class="lp_block_bg" style="<?php echo $bl4_bg; ?> <?php echo $bl4_bg_opacity; ?>"></div>
        <div class="lp_block3 container parent">
            <div class="lp_block3_cont">
                <h2 class="lp_block3_h"><?php echo $landing['block4']['title']; ?></h2>
                <div class="lp_block3_desk"><?php echo $landing['block4']['subtitle']; ?></div>
                <div class="lp_block3_txt">
                    <span><?php echo $landing['block4']['r_title']; ?></span><?php echo $landing['block4']['r_subtitle']; ?>
                </div>
                <?php if (!empty($landing['block4']['button'])):?>
                    <div class="lp_block_buts_wrap">
                        <a href="#" class="lp_block_but lp_block3_but parent"><?php echo $landing['block4']['button']; ?></a>
                        <?php if(!empty($course['recur_first']) or !empty($course['price'])): ?>
                            <div class="video_col_but">
                                <div class="video_col_but_left">
                                    <a href="#" class="lp_block_but_crs"><?php echo $course['price']; ?> РУБ / КУРС</a>
                                </div>
                                <?php if(!empty($course['recur_first'])): ?>
                                    <div class="video_col_but_right">или</div>
                                    <div class="video_col_but_right">
                                        <a href="#" class="lp_block_but_rec_crs"><?php echo $course['recur_first']; ?> РУБ / МЕС</a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php elseif($course['price'] == 0): ?>
                            <div class="video_col_but">
                                <div class="video_col_but_right">
                                    <a href="#" class="lp_block_but_rec_crs">Добавить в "Мои курсы"</a>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif;?>
            </div>
            <div class="lp_block3_img">
                <img src="<?php echo $landing['block4']['image']; ?>" alt="">
            </div>
        </div>
    </div><!-- lp_block3_wrap -->

<?php endif; ?>

<?php if($landing['block5']['hide'] === false):
    $bl5_bg_color = (!empty($landing['block5']['bg_color'])) ? 'background: ' . $landing['block5']['bg_color'] . ';' : '';
    $bl5_bg = (!empty($landing['block5']['bg'])) ? 'background-image: ' . $landing['block5']['bg'] . ';' : '';
    $bl5_bg_opacity = ($landing['block5']['bg_opacity'] > 0) ? 'opacity: ' . $landing['block5']['bg_opacity'] . ';' : '';
?>
    <div class="lp_block4_wrap" style="<?php echo $bl5_bg_color; ?>">
        <div class="lp_block_bg" style="<?php echo $bl5_bg; ?> <?php echo $bl5_bg_opacity; ?>"></div>
        <div class="lp_block4 container">
            <div class="lp_block4_cont">
                <h2 class="lp_block4_h"><?php echo $landing['block5']['title']; ?></h2>
                <div class="lp_block4_desk"><?php echo $landing['block5']['subtitle']; ?></div>
                <div class="lp_block4_txt"><?php echo $landing['block5']['text']; ?></div>
                <div class="lp_block4_info parent">
                    <div class="lp_block4_info_img"><img src="<?php echo $landing['block5']['image3']; ?>" alt=""></div>
                    <div class="lp_block4_info_cont">
                        <div class="lp_block4_info_h"><?php echo $landing['block5']['r_title']; ?></div>
                        <div class="lp_block4_info_desk"><?php echo $landing['block5']['r_subtitle']; ?></div>
                        <div class="lp_block4_info_txt"><?php echo $landing['block5']['r_text']; ?></div>
                    </div>
                </div>
                <?php if (!empty($landing['block5']['button'])):?>
                    <div class="lp_block_buts_wrap">
                        <a href="#" class="lp_block_but lp_block4_but"><?php echo $landing['block5']['button']; ?></a>
                        <?php if(!empty($course['recur_first']) or !empty($course['price'])): ?>
                            <div class="video_col_but">
                                <div class="video_col_but_left">
                                    <a href="#" class="lp_block_but_crs"><?php echo $course['price']; ?> РУБ / КУРС</a>
                                </div>
                                <?php if(!empty($course['recur_first'])): ?>
                                    <div class="video_col_but_right">или</div>
                                    <div class="video_col_but_right">
                                        <a href="#" class="lp_block_but_rec_crs"><?php echo $course['recur_first']; ?> РУБ / МЕС</a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php elseif($course['price'] == 0): ?>
                            <div class="video_col_but">
                                <div class="video_col_but_right">
                                    <a href="#" class="lp_block_but_rec_crs">Добавить в "Мои курсы"</a>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif;?>
            </div>
            <div class="lp_block4_img">
                <a href="<?php echo $landing['block5']['image1']; ?>" class="lp_block4_img_l" data-lightbox="gal"><img src="<?php echo $landing['block5']['image1']; ?>" alt=""></a>
                <a href="<?php echo $landing['block5']['image2']; ?>" class="lp_block4_img_r" data-lightbox="gal"><img src="<?php echo $landing['block5']['image2']; ?>" alt=""></a>
            </div>
        </div>
    </div><!-- lp_block4_wrap -->

<?php endif; ?>

<?php if($landing['block6']['hide'] === false):
    $bl6_bg_color = (!empty($landing['block6']['bg_color'])) ? 'background: ' . $landing['block6']['bg_color'] . ';' : '';
    $bl6_bg = (!empty($landing['block6']['bg'])) ? 'background-image: ' . $landing['block6']['bg'] . ';' : '';
    $bl6_bg_opacity = ($landing['block6']['bg_opacity'] > 0) ? 'opacity: ' . $landing['block6']['bg_opacity'] . ';' : '';
?>
    <div class="lp_block5_wrap" style="<?php echo $bl6_bg_color; ?>">
        <div class="lp_block_bg" style="<?php echo $bl6_bg; ?> <?php echo $bl6_bg_opacity; ?>"></div>
        <div class="lp_block5 container">
            <h2 class="lp_block5_h"><?php echo $landing['block6']['title']; ?></h2>
            <div class="lp_block5_cont parent">
                <div class="lp_block5_img"><img src="<?php echo $landing['block6']['image']; ?>" alt=""></div>
                <div class="lp_block5_info">
                    <div class="lp_block5_desk"><?php echo $landing['block6']['desc']; ?></div>
                    <div class="lp_block5_line"><?php echo $landing['block6']['subtitle']; ?></div>
                    <ul class="lp_block5_ul">
                        <?php if (!empty($landing['block6']['advantages'])) :
                            foreach ($landing['block6']['advantages'] as $advantage) : ?>
                                <li><?php echo $advantage; ?></li>
                            <?php endforeach;
                            unset($advantage);
                        endif;?>
                    </ul>
                    <?php if (!empty($landing['block6']['button'])):?>
                        <div class="lp_block_buts_wrap">
                            <a href="#" class="lp_block_but lp_block5_but parent"><?php echo $landing['block6']['button']; ?></a>
                            <?php if(!empty($course['recur_first']) or !empty($course['price'])): ?>
                                <div class="video_col_but">
                                    <div class="video_col_but_left">
                                        <a href="#" class="lp_block_but_crs"><?php echo $course['price']; ?> РУБ / КУРС</a>
                                    </div>
                                    <?php if(!empty($course['recur_first'])): ?>
                                        <div class="video_col_but_right">или</div>
                                        <div class="video_col_but_right">
                                            <a href="#" class="lp_block_but_rec_crs"><?php echo $course['recur_first']; ?> РУБ / МЕС</a>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php elseif($course['price'] == 0): ?>
                                <div class="video_col_but">
                                    <div class="video_col_but_right">
                                        <a href="#" class="lp_block_but_rec_crs">Добавить в "Мои курсы"</a>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif;?>
                </div>
            </div>
        </div>
    </div><!-- lp_block5_wrap -->

<?php endif; ?>

<?php if($landing['block7']['hide'] === false):
    $bl7_bg_color = (!empty($landing['block7']['bg_color'])) ? 'background: ' . $landing['block7']['bg_color'] . ';' : '';
    $bl7_bg = (!empty($landing['block7']['bg'])) ? 'background: ' . $landing['block7']['bg'] . ';' : '';
    $bl7_bg_opacity = ($landing['block7']['bg_opacity'] > 0) ? 'opacity: ' . $landing['block7']['bg_opacity'] . ';' : '';
?>
    <div class="lp_block6_wrap" style="<?php echo $bl7_bg_color; ?>">
        <div class="lp_block_bg" style="<?php echo $bl7_bg; ?> <?php echo $bl7_bg_opacity; ?>"></div>
        <div class="lp_block6 container">
            <h2 class="lp_block6_h"><?php echo $landing['block7']['title']; ?></h2>
            <div class="lp_block6_cont row">
                <?php if(!empty($landing['block7']['image1']) and !empty($landing['block7']['texts'][1])): ?>
                    <div class="col-lg-6 col-md-6">
                        <div class="lp_block6_item parent">
                            <div class="lp_block6_img">
                                <img src="<?php echo $landing['block7']['image1']; ?>" alt="">
                            </div>
                            <div class="lp_block6_txt">
                                <div class="lp_block6_txt_cell"><?php echo $landing['block7']['texts'][1]; ?></div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if(!empty($landing['block7']['image2']) and !empty($landing['block7']['texts'][2])): ?>
                    <div class="col-lg-6 col-md-6">
                        <div class="lp_block6_item parent">
                            <div class="lp_block6_img">
                                <img src="<?php echo $landing['block7']['image2']; ?>" alt="">
                            </div>
                            <div class="lp_block6_txt">
                                <div class="lp_block6_txt_cell"><?php echo $landing['block7']['texts'][2]; ?></div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if(!empty($landing['block7']['image3']) and !empty($landing['block7']['texts'][3])): ?>
                    <div class="col-lg-6 col-md-6">
                        <div class="lp_block6_item parent">
                            <div class="lp_block6_img">
                                <img src="<?php echo $landing['block7']['image3']; ?>" alt="">
                            </div>
                            <div class="lp_block6_txt">
                                <div class="lp_block6_txt_cell"><?php echo $landing['block7']['texts'][3]; ?></div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if(!empty($landing['block7']['image4']) and !empty($landing['block7']['texts'][4])): ?>
                    <div class="col-lg-6 col-md-6">
                        <div class="lp_block6_item parent">
                            <div class="lp_block6_img">
                                <img src="<?php echo $landing['block7']['image4']; ?>" alt="">
                            </div>
                            <div class="lp_block6_txt">
                                <div class="lp_block6_txt_cell"><?php echo $landing['block7']['texts'][4]; ?></div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            <?php if (!empty($landing['block7']['button'])):?>
                <div class="lp_block_buts_wrap">
                    <a href="#" class="lp_block_but lp_block6_but parent"><?php echo $landing['block7']['button']; ?></a>
                    <?php if(!empty($course['recur_first']) or !empty($course['price'])): ?>
                        <div class="video_col_but">
                            <div class="video_col_but_left">
                                <a href="#" class="lp_block_but_crs"><?php echo $course['price']; ?> РУБ / КУРС</a>
                            </div>
                            <?php if(!empty($course['recur_first'])): ?>
                                <div class="video_col_but_right">или</div>
                                <div class="video_col_but_right">
                                    <a href="#" class="lp_block_but_rec_crs"><?php echo $course['recur_first']; ?> РУБ / МЕС</a>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php elseif($course['price'] == 0): ?>
                        <div class="video_col_but">
                            <div class="video_col_but_right">
                                <a href="#" class="lp_block_but_rec_crs">Добавить в "Мои курсы"</a>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif;?>
        </div>
    </div><!-- lp_block6_wrap -->

<?php endif; ?>

<?php if($landing['block8']['hide'] === false):
    $bl8_bg_color = (!empty($landing['block8']['bg_color'])) ? 'background: ' . $landing['block8']['bg_color'] . ';' : '';
    $bl8_bg = (!empty($landing['block8']['bg'])) ? 'background-image: ' . $landing['block8']['bg'] . ';' : '';
    $bl8_bg_opacity = ($landing['block8']['bg_opacity'] > 0) ? 'opacity: ' . $landing['block8']['bg_opacity'] . ';' : '';
?>
    <div class="lp_block7_wrap" style="<?php echo $bl8_bg_color; ?>">
        <div class="lp_block_bg" style="<?php echo $bl8_bg; ?> <?php echo $bl8_bg_opacity; ?>"></div>
        <div class="lp_block7 container">
            <h2 class="lp_block7_h"><?php echo $landing['block8']['title']; ?></h2>
            <div class="lp_block7_desk"><?php echo $landing['block8']['desc1']; ?></div>
            <div class="lp_block7_line"><?php echo $landing['block8']['subtitle']; ?></div>
            <div class="lp_block7_desk"><?php echo $landing['block8']['desc2']; ?></div>
            <div class="lp_block7_price">
                <?php if($course['price'] > 0): ?>
                    всего за
                    <?php if (!empty($landing['block8']['old_price'])): ?>
                        <span><?php echo $landing['block8']['old_price']; ?></span> -
                    <?php endif;?>
                    <?php echo $course['price']; ?> руб
                <?php elseif($course['price'] == 0): ?>
                    Бесплатно
                <?php endif; ?>
            </div>
            <?php if (!empty($landing['block8']['button'])):?>
                <div class="lp_block_buts_wrap">
                    <a href="#" class="lp_block_but lp_block6_but"><?php echo $landing['block8']['button']; ?></a>
                    <?php if(!empty($course['recur_first']) or !empty($course['price'])): ?>
                        <div class="video_col_but">
                            <div class="video_col_but_left">
                                <a href="#" class="lp_block_but_crs"><?php echo $course['price']; ?> РУБ / КУРС</a>
                            </div>
                            <?php if(!empty($course['recur_first'])): ?>
                                <div class="video_col_but_right">или</div>
                                <div class="video_col_but_right">
                                    <a href="#" class="lp_block_but_rec_crs"><?php echo $course['recur_first']; ?> РУБ / МЕС</a>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php elseif($course['price'] == 0): ?>
                        <div class="video_col_but">
                            <div class="video_col_but_right">
                                <a href="#" class="lp_block_but_rec_crs">Добавить в "Мои курсы"</a>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif;?>
        </div>
    </div><!-- lp_block7_wrap -->
<?php endif;
include_once('./app_fold/views/course/payment_form_up.php');
?>