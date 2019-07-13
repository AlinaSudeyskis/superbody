<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="content" class="container">
    <?php
    $parse_url = parse_url($_SERVER['HTTP_REFERER']);
    if(empty($_SERVER['HTTP_REFERER']) or $parse_url['path'] == '/'):
        $breadcrumbs = array('/portfolio' => 'Галерея');
    else:
        $user_name = (!empty($user_data['user_name'])) ? $user_data['user_name'] : 'Страница тренера';
        $breadcrumbs = array('/coaches' => 'Тренеры', '/profile/'.$user_data['user_id'] => $user_name, '/portfolio' => 'Портфолио');
    endif;
    include_once('./app_fold/views/breadcrumb.php');?>
    <div class="row">
        <div class="col-lg-2 left_sidebar">
            <?php if (!empty($user_session)):
                if ($user_session['type'] == 2):
                    include_once('./app_fold/views/coach/coach_menu.php');
                else:
                    include_once('./app_fold/views/user/user_menu.php');
                endif;
            endif;?>
        </div><!-- left_sidebar -->
        <div class="col-lg-10 content_col">
            <div class="content_block new_content_block no_over">
                <div class="content_block_h new_content_block_h parent">
                    <h3>
                        <?php if (!empty($post['title'])) {
                            echo $post['title'];
                        }
                        else {
                            echo 'Портфолио';
                        }?>
                    </h3>
                    <div class="content_block_h_buts">
                        <div class="content_block_h_slide kurs_slide"></div>
                        <div class="content_block_h_close"></div>
                    </div>
                </div>
                <div class="kurs_block_val full_photo_block_val">
                    <?php if(!empty($post)):?>
                        <div class="parent">
                            <div class="full_photo_block_img_wrap">
                                <div class="full_photo_block_img"><img src="<?php echo $post['path'];?>" alt=""></div>
                                <div class="full_photo_block_img_but">
                                    <!--<a href=""><i class="fa fa-heart-o" aria-hidden="true"></i></a>
                                    <a href=""><i class="fa fa-comment-o" aria-hidden="true"></i></a>-->
                                </div>
                            </div>
                        </div>
                        <div class="full_photo_block_cont">
                            <div class="full_photo_block_cont_info">
                                <!--<div class="full_photo_block_cont_info_item"><i class="fa fa-heart" aria-hidden="true"></i><span>100</span></div>
                                <div class="full_photo_block_cont_info_item"><i class="fa fa-comment" aria-hidden="true"></i><span>100</span></div>-->
                            </div>
                            <div class="full_photo_block_cont_txt"><?php echo $post['desc'];?></div>
                            <!--<div class="full_photo_block_cont_link"><a href="">Смотреть все 100 комменатариев</a></div>
                            <div class="full_photo_block_comm_wrap">
                                <div class="full_photo_block_comm parent">
                                    <div class="full_photo_block_comm_img"><img src="/img/ava8.png" alt=""></div>
                                    <div class="full_photo_block_comm_cont">
                                        <div class="full_photo_block_comm_name">Каролина</div>
                                        <div class="full_photo_block_comm_txt">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</div>
                                        <div class="full_photo_block_comm_info">
                                            <div class="full_photo_block_comm_info_item"><a href=""><i class="fa fa-heart-o" aria-hidden="true"></i></a><span>100</span></div>
                                            <div class="full_photo_block_comm_info_item"><a href=""><i class="fa fa-comment-o" aria-hidden="true"></i></a><span>100</span></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="full_photo_block_comm parent">
                                    <div class="full_photo_block_comm_img"><img src="/img/ava8.png" alt=""></div>
                                    <div class="full_photo_block_comm_cont">
                                        <div class="full_photo_block_comm_name">Каролина</div>
                                        <div class="full_photo_block_comm_txt">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</div>
                                        <div class="full_photo_block_comm_info">
                                            <div class="full_photo_block_comm_info_item"><a href=""><i class="fa fa-heart-o" aria-hidden="true"></i></a><span>100</span></div>
                                            <div class="full_photo_block_comm_info_item"><a href=""><i class="fa fa-comment-o" aria-hidden="true"></i></a><span>100</span></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <form action="#" class="full_photo_comm_form">
                                <textarea name="full_photo_comm" placeholder="Оставить комментарий" class="full_photo_comm_in"></textarea>
                                <div class="full_photo_comm_but_wrap parent">
                                    <input type="reset" value="Отмена" class="full_photo_comm_reset">
                                    <input type="submit" value="Добавить" class="full_photo_comm_but">
                                </div>
                            </form>-->
                        </div>
                    <?php else: ?>
                        <h3 class="info">Информация не найдена</h3>
                    <?php endif;?>
                </div>
            </div>
        </div><!-- content_col -->
    </div>
</div><!-- content -->
