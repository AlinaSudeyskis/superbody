<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Super Body</title>
    <?php include_once('./app_fold/views/header/lp_styles_scripts.php'); ?>
</head>
<body class="dark_lp lp_page">

<div class="lp_header_wrap">
    <div class="lp_header_bg">
        <?php if (!empty($landing['slider_images'])) :
            foreach ($landing['slider_images'] as $slider_image) : ?>
                <div class="lp_header_slide"><img src="<?php echo $slider_image;?>" alt=""></div>
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
            <div class="lp_scroll_ico"><img src="/landing/default/1/lp_ico1.png" alt=""></div>
        </div>
    </div>
</div><!-- lp_header_wrap -->

<div class="lp_block1_wrap" style="<?php echo $landing['block2']['bg']; ?>">
    <div class="lp_block1 container">
        <div class="lp_block1_img"><img src="<?php echo $landing['block2']['image']; ?>" alt=""></div>
        <div class="lp_block1_cont">
            <h2 class="lp_block1_h"><?php echo $landing['block2']['title']; ?></h2>
            <div class="lp_block1_desk"><?php echo $landing['block2']['subtitle']; ?></div>
            <div class="lp_block1_txt"><?php echo $landing['block2']['text']; ?></div>
            <?php if (!empty($landing['block2']['button'])):?>
                <a href="" class="lp_block_but lp_block0_but parent"><?php echo $landing['block2']['button']; ?></a>
            <?php endif;?>
        </div>
    </div>
</div><!-- lp_block1_wrap -->

<div class="lp_block2_wrap">
    <div class="lp_block_bg" style="<?php echo $landing['block3']['bg']; ?>"></div>
    <div class="lp_block2 container">
        <h2 class="lp_block2_h"><?php echo $landing['block3']['title']; ?></h2>
        <div class="lp_block2_cont parent">
            <div class="lp_block2_cont_l">
                <div class="lp_block2_cont_h"><?php echo $landing['block3']['subtitle']; ?></div>
                <div class="lp_block2_cont_row parent">
                    <div class="lp_block2_cont_col"><img src="<?php echo $landing['block3']['images'][0]; ?>" alt=""><span>до</span></div>
                    <div class="lp_block2_cont_col"><img src="<?php echo $landing['block3']['images'][1]; ?>" alt=""><span>после</span></div>
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

<div class="lp_block3_wrap" style="<?php echo $landing['block4']['bg']; ?>">
    <div class="lp_block3 container parent">
        <div class="lp_block3_cont">
            <h2 class="lp_block3_h"><?php echo $landing['block4']['title']; ?></h2>
            <div class="lp_block3_desk"><?php echo $landing['block4']['subtitle']; ?></div>
            <?php if (!empty($landing['block4']['button'])):?>
                <a href="" class="lp_block_but lp_block3_but parent"><?php echo $landing['block4']['button']; ?></a>
            <?php endif;?>
        </div>
        <div class="lp_block3_img">
            <img src="<?php echo $landing['block4']['image']; ?>" alt="">
            <div class="lp_block3_txt">
                <span><?php echo $landing['block4']['r_title']; ?></span><?php echo $landing['block4']['r_subtitle']; ?>
            </div>
        </div>
    </div>
</div><!-- lp_block3_wrap -->

<div class="lp_block4_wrap">
    <div class="lp_block4 container">
        <div class="lp_block4_cont">
            <h2 class="lp_block4_h"><?php echo $landing['block5']['title']; ?></h2>
            <div class="lp_block4_desk"><?php echo $landing['block5']['subtitle']; ?></div>
            <div class="lp_block4_txt"><?php echo $landing['block5']['text']; ?></div>
            <div class="lp_block4_info parent">
                <div class="lp_block4_info_img"><img src="<?php echo $landing['block5']['images'][2]; ?>" alt=""></div>
                <div class="lp_block4_info_cont">
                    <div class="lp_block4_info_h"><?php echo $landing['block5']['r_title']; ?></div>
                    <div class="lp_block4_info_desk"><?php echo $landing['block5']['r_subtitle']; ?></div>
                    <div class="lp_block4_info_txt"><?php echo $landing['block5']['r_text']; ?></div>
                </div>
            </div>
            <?php if (!empty($landing['block5']['button'])):?>
                <a href="" class="lp_block4_but"><?php echo $landing['block5']['button']; ?></a>
            <?php endif;?>
        </div>
        <div class="lp_block4_img">
            <a href="<?php echo $landing['block5']['images'][0]; ?>" class="lp_block4_img_l" data-lightbox="gal"><img src="<?php echo $landing['block5']['images'][0]; ?>" alt=""></a>
            <a href="<?php echo $landing['block5']['images'][1]; ?>" class="lp_block4_img_r" data-lightbox="gal"><img src="<?php echo $landing['block5']['images'][1]; ?>" alt=""></a>
        </div>
    </div>
</div><!-- lp_block4_wrap -->

<div class="lp_block5_wrap">
    <div class="lp_block_bg" style="<?php echo $landing['block6']['bg']; ?>"></div>
    <div class="lp_block5 container">
        <h2 class="lp_block5_h"><?php echo $landing['block6']['title']; ?></h2>
        <div class="lp_block5_cont parent">
            <div class="lp_block5_img"><img src="/img/lp_img8.png" alt=""></div>
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
                    <a href="" class="lp_block_but lp_block5_but parent"><?php echo $landing['block6']['button']; ?></a>
                <?php endif;?>
            </div>
        </div>
    </div>
</div><!-- lp_block5_wrap -->

<div class="lp_block6_wrap">
    <div class="lp_block6 container">
        <h2 class="lp_block6_h"><?php echo $landing['block7']['title']; ?></h2>
        <div class="lp_block6_cont row">
            <?php if (!empty($landing['block7']['images'])) :
                foreach ($landing['block7']['images'] as $key => $image) : ?>
                    <div class="col-lg-6 col-md-6">
                        <div class="lp_block6_item parent">
                            <div class="lp_block6_img"><img src="<?php echo $image; ?>" alt=""></div>
                            <div class="lp_block6_txt">
                                <div class="lp_block6_txt_cell"><?php echo $landing['block7']['texts'][$key]; ?></div>
                            </div>
                        </div>
                    </div>
                <?php endforeach;
                unset($image);
            endif;?>
        </div>
        <?php if (!empty($landing['block7']['button'])):?>
            <a href="" class="lp_block_but lp_block6_but parent"><?php echo $landing['block7']['button']; ?></a>
        <?php endif;?>
    </div>
</div><!-- lp_block6_wrap -->

<div class="lp_block7_wrap">
    <div class="lp_block_bg" style="<?php echo $landing['block8']['bg']; ?>"></div>
    <div class="lp_block7 container">
        <h2 class="lp_block7_h"><?php echo $landing['block8']['title']; ?></h2>
        <div class="lp_block7_desk"><?php echo $landing['block8']['desc1']; ?></div>
        <div class="lp_block7_line"><?php echo $landing['block8']['subtitle']; ?></div>
        <div class="lp_block7_desk"><?php echo $landing['block8']['desc2']; ?></div>
        <div class="lp_block7_price">всего за
            <?php if (!empty($landing['block8']['old_price'])) : ?>
                <span><?php echo $landing['block8']['old_price']; ?></span> -
            <?php endif;?>
            <?php echo $landing['block8']['new_price']; ?> руб
        </div>
        <?php if (!empty($landing['block8']['button'])):?>
            <a href="" class="lp_block7_but"><?php echo $landing['block8']['button']; ?></a>
        <?php endif;?>
    </div>
</div><!-- lp_block7_wrap -->

<div class="lp_dark_footer_wrap">
    <div class="lp_dark_footer container parent">
        <div class="lp_dark_footer_cont">
            <div class="lp_dark_footer_h">ПОДПИСКА НА НОВОСТИ</div>
            <div class="lp_dark_footer_txt">Подпишитесь на новости нашего портала и будьте в курсе всех событий</div>
            <div class="lp_dark_footer_txt">Получите базовый курс стоимостью 1990 за подписку <span>бесплатно</span></div>
        </div>
        <form action="#" id="subscribe_dark_form" class="parent">
            <div class="subscribe_dark_form_in_wrap parent">
                <input type="text" class="subscribe_dark_form_in" placeholder="Ваше имя">
                <input type="text" class="subscribe_dark_form_in" placeholder="Укажите email">
            </div>
            <div class="subscribe_dark_form_but_wrap">
                <input type="submit" value="Подписаться" class="subscribe_dark_form_but">
            </div>
        </form>
    </div>
</div><!-- lp_dark_footer_wrap -->

<div class="dark_footer_copy_wrap">
    <div class="container">
        <div class="dark_footer_copy">© ООО «Супербоди» все права защищены 2016</div>
    </div>
</div><!-- dark_footer_copy_wrap -->

<script src="/js/lightbox.js"></script>

</body>
</html>