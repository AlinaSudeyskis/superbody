<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$user_name = (!empty($user_data['user_name'])) ? $user_data['user_name'] : 'Страница тренера';
$post_title = (!empty($post['title'])) ? $post['title'] : 'Пост тренера';
$breadcrumbs = array('/blog' => 'Блог', '/blog/post' => $post_title);
include_once('./app_fold/views/breadcrumb.php');?>
<div id="content" class="container">
    <div class="row">
        <div class="content_col">
            <div class="content_block new_content_block">
                <div class="content_block_h parent">
                    <h3>Блог тренера</h3>
                    <div class="content_block_h_buts">
                        <div class="content_block_h_slide kurs_slide"></div>
                        <div class="content_block_h_close"></div>
                    </div>
                </div>
                <div class="kurs_block_val">
                    <?php if (!empty($post)): ?>
                        <div class="comment_page_block">
                            <div class="parent">
                                <div class="comment_page_cont">
                                    <div class="comment_page_cont_h"><?php echo $post['title'];?></div>
                                    <div class="blog_share top"><?php if(!empty($site_info) and !empty($site_info['blog_share_top'])): echo $site_info['blog_share_top']; endif; ?></div>
                                    <?php if(!empty($post['video'])): ?>
                                        <?php if($post['video_type'] == 'vimeo'): ?>
                                            <?php $remote_url = $post['video'];
                                            $key = 0;
                                            include('./app_fold/views/video/player/vimeo_player_item.php');?>
                                        <?php elseif($post['video_type'] == 'youtube') : ?>
                                            <?php $remote_url = $post['video'];
                                            $key = 0;
                                            include('./app_fold/views/video/player/youtube_player_item.php');?>
                                        <?php endif;?>
                                    <?php endif; ?>
                                    <div class="comment_page_cont_txt"><?php echo $post['text'];?></div>
                                    <div class="comment_page_cont_link"><a href="/profile/<?php echo $post['user']['id'];?>"><?php echo $post['user']['name'];?></a></div>
                                    <?php if(!empty($site_info) and !empty($site_info['blog_share_bottom'])):?>
                                        <div class="blog_share bottom">
                                            <div class="blog_share_text">Поделиться:</div>
                                            <?php echo $site_info['blog_share_bottom']; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php if($post['attached_courses']):?>
                                <h2 class="block_h">Рекомендуемые курсы:</h2>
                                <div class="kurs_page_row row">
                                    <?php foreach($post['attached_courses'] as $course):
                                        include('./app_fold/views/course/course_item.php');
                                    endforeach;
                                    unset($course);?>
                                </div>

                                <script>
                                    $('.kurs_page_block_slider').slick({
                                        dots: false,
                                        infinite: true,
                                        autoplaySpeed: 5000,
                                        speed: 500,
                                        autoplay: true,
                                        arrows: false,
                                        pauseOnFocus: false
                                    });
                                    $('.kurs_page_row_slider').slick({
                                        dots: false,
                                        infinite: true,
                                        speed: 500,
                                        autoplay: false,
                                        arrows: true,
                                        slidesToShow: 3,
                                        slidesToScroll: 1,
                                        responsive: [
                                            {
                                                breakpoint: 1420,
                                                settings: {
                                                    slidesToShow: 2,
                                                    slidesToScroll: 1
                                                }
                                            },
                                            {
                                                breakpoint: 1140,
                                                settings: {
                                                    slidesToShow: 2,
                                                    slidesToScroll: 1
                                                }
                                            },
                                            {
                                                breakpoint: 650,
                                                settings: {
                                                    slidesToShow: 1,
                                                    slidesToScroll: 1
                                                }
                                            }
                                        ]
                                    });
                                </script>
                            <?php endif;?>
                            <?php if (!empty($post['comments'])) :?>
                                <div class="full_photo_block_comm_wrap">
                                    <?php foreach ($post['comments'] as $comment) :
                                        $user_removed = ($comment['u_name'] == 'Пользователь удален') ? 'translucent' : ''; ?>
                                        <div class="full_photo_block_comm parent <?php echo $user_removed; ?>">
                                            <div class="full_photo_block_comm_img">
                                                <?php $comment_u_image = (!empty($comment['u_image'])) ? $comment['u_image'] : '/img/no_img.png'; ?>
                                                <img src="<?php echo $comment_u_image;?>" alt="">
                                            </div>
                                            <div class="full_photo_block_comm_cont">
                                                <div class="full_photo_block_comm_name"><?php echo $comment['u_name'];?></div>
                                                <div class="full_photo_block_comm_txt"><?php echo $comment['text'];?></div>
                                                <div class="full_photo_block_comm_info"></div>
                                            </div>
                                        </div>
                                    <?php endforeach;
                                    unset($comment);?>
                                </div>
                            <?php endif;?>
                            <?php if (!empty($user_session['id'])) : ?>
                                <form action="" class="full_photo_comm_form" method="post">
                                    <!--<input type="text" name="name" class="comment_page_form_in" placeholder="Имя">
                                    <input type="text" name="mail" class="comment_page_form_in" placeholder="E-mail">-->
                                    <textarea name="post_comment" placeholder="Оставить комментарий" class="full_photo_comm_in"></textarea>
                                    <div class="full_photo_comm_but_wrap parent">
                                        <input type="submit" name="bt_send_comment" value="Добавить" class="full_photo_comm_but">
                                    </div>
                                </form>
                            <?php endif;?>
                        </div>
                    <?php else: ?>
                        <h3 class="info">Информация не найдена</h3>
                    <?php endif; ?>
                </div>
            </div>
        </div><!-- content_col -->
    </div>
</div><!-- content -->