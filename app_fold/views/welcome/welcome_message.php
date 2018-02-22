<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="content" class="container">
    <div class="cont_txt">
        <h1 class="main_h"><?php if (!empty($site_info['index_title'])) { echo $site_info['index_title']; } ?></h1>
        <div class="cont_val"><?php if (!empty($site_info['index_text'])) { echo $site_info['index_text']; } ?></div>
    </div>
    <div class="video_row row video_block">
        <?php if (!empty($video)) :
            foreach ($video as $key => $vd) :?>
                <div class="video_col">
                    <div class="video_col_h"><span class="video_title"><?php echo $vd['course_name']; ?></span></div>
                    <?php if (empty($vd['remove_url'])) : ?>
                        <div class="video_kurs def_video">
                            <div class="px-video-img-captions-container">
                                <div class="px-video-captions hide"></div>
                                <video poster="<?php echo $vd['poster']; ?>" controls>
                                    <source src="<?php echo $vd['path']; ?>" type="video/mp4">
                                    <div><a href="<?php echo $vd['path']; ?>"><img src="<?php echo $vd['poster']; ?>" alt="download video"></a></div>
                                </video>
                            </div>
                            <div class="px-video-controls"></div>
                        </div>
                    <?php else:
                        /*<iframe id="player" type="text/html"
                            src="http://www.youtube.com/embed/<?php echo $vd['remove'];?>?enablejsapi=1&origin=http://sb.theoutlines.ru"
                            frameborder="0"></iframe>*/ ?>
                        <div class="video_kurs">
                            <?php $remove_url = $vd['remove_url'];
                            include('./app_fold/views/video/player/vimeo_player_item.php'); ?>
                        </div>
                    <?php endif;?>
                </div>
            <?php endforeach;
            unset($vd);
        endif;?>        
    </div><!-- video_row -->
    <div class="new_kurs_row row">
        <div class="col-lg-9 col-md-8 col-sm-12 col-xs-12 new_kurs_wrap">
            <h2 class="block_h">НОВЫЕ КУРСЫ</h2>
            <div class="new_kurs_block parent"data-info="Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.">
                <?php if (!empty($courses)) :
                    $count_courses = count($courses);
                    foreach ($courses as $key => $course) :?>
                        <div class="new_kurs_block_item">
                            <div class="new_kurs_buts">
                                <button class="add_kurs_but"><img src="/img/new_kurs_ico1.png" alt=""></button>
                                <a href="" class="qw_but"><img src="/img/new_kurs_ico2.png" alt=""></a>
                                <button class="favor_but"><img src="/img/new_kurs_ico3.png" alt=""></button>
                                <button class="share_but"><img src="/img/new_kurs_ico4.png" alt=""></button>
                            </div>
                            <a href="/course/<?php echo $course['id']?>" class="new_kurs_name"><?php echo $course['name']?></a>
                        </div>
                    <?php endforeach;
                    unset($course);
                endif;?>
            </div>
        </div>
        <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12">
            <h2 class="block_h">СПЕЦ. ПРЕДЛОЖЕНИЕ</h2>
            <div class="spec_block" data-info="Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.">
                <div class="spec_block_h">25%  СКИДКА ДЛЯ ВСЕХ</div>
                <div class="spec_block_desk">Всем пользователям предоставляется скидка на вторую и последующую покупку курса</div>
                <a href="" class="spec_block_but">ДЕТАЛИ</a>
            </div>
        </div>
    </div><!-- new_kurs_row -->
    <?php include_once('./app_fold/views/site/content/couches_reviews_block.php'); ?>
    <?php include_once('./app_fold/views/site/content/gallery.php'); ?>
</div><!-- content -->
