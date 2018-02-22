<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="content" class="container">
    <div class="row">
        <div class="col-lg-2 left_sidebar">
            <?php if (!empty($user_session)):
                if ($user_session['type'] == 2):
                    include_once('./app_fold/views/couch/couch_menu.php');
                else:
                    include_once('./app_fold/views/user/user_menu.php');
                endif;
            endif;?>
        </div><!-- left_sidebar -->
        <div class="col-lg-10 content_col">
            <?php
            // Краткая информация
            include_once('./app_fold/views/couch/profile/short_info.php');
            // Информация профиля
            include_once('./app_fold/views/couch/profile/profile_info.php');
            ?>
            <div class="content_block new_content_block">
                <div class="content_block_h new_content_block_h parent">
                    <h3>Блог</h3>
                    <div class="content_block_h_buts">
                        <div class="content_block_h_slide kurs_slide"></div>
                        <div class="content_block_h_close"></div>
                    </div>
                </div>
                <div class="kurs_block_val">
                    <div class="subscription_block">
                        <div class="subscription_block_cont">
                            <?php if (!empty($posts)) :
                                foreach ($posts as $post) :?>
                                    <div class="subscription_block_item">
                                        <div class="subscription_block_h"><a href="/blog/<?php echo $post['id'];?>"><?php echo $post['title'];?></a></div>
                                        <div class="subscription_block_txt">Краткое описание: <?php echo $post['short_desc'];?>...</div>
                                        <div class="subscription_block_link">
                                            <!--<a href="">http://if.com.au/2013/09/02/article/</a>-->
                                        </div>
                                    </div>
                                <?php endforeach;
                                unset($post);
                            endif;?>
                        </div>
                    </div>
                    <?php include_once('./app_fold/views/pagination.php'); ?>
                </div>
            </div>
            <?php // Портфолио
            if (!empty($portfolio)) :
                include_once('./app_fold/views/couch/portfolio/portfolio_item.php');
            endif;
            ?>

        </div><!-- content_col -->
    </div>
</div><!-- content -->