<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="content" class="container">
    <div class="row">
        <div class="col-lg-2 left_sidebar">
            <?php include_once('./app_fold/views/user/user_menu.php'); ?>
        </div><!-- left_sidebar -->
        <div class="col-lg-10 content_col">
            <div class="content_block new_content_block">
                <div class="content_block_h parent">
                    <h3>Мои курсы</h3>
                    <div class="content_block_h_buts">
                        <div class="content_block_h_slide kurs_slide"></div>
                        <div class="content_block_h_close"></div>
                    </div>
                </div>
                <div class="kurs_block_val">
                    <ul class="anketa_block_nav parent">
                        <li>
                            <a href="/profile/courses">
                                <span <?php if ($page_submenu == 'active'): ?> class="anketa_active" <?php endif;?>>Активные</span>
                            </a>
                        </li>
                        <li>
                            <a href="/profile/courses/finished">
                                <span <?php if ($page_submenu == 'finished'): ?> class="anketa_active" <?php endif;?>>Завершенные</span>
                            </a>
                        </li>
                    </ul>
                    <div class="orders_container_wrap">
                        <?php if(!empty($courses) or !empty($blocked_courses) or !empty($premium_order)):
                            if (!empty($premium_order)) :
                                $course['order'] = $premium_order;
                                $fl_premium_order = true;
                                include('./app_fold/views/course/user_course/course_item.php');
                                $fl_premium_order = false;
                            endif;
                            if (!empty($courses)) :
                                foreach ($courses as $course) :
                                    $blocked = '';
                                    include('./app_fold/views/course/user_course/course_item.php');
                                endforeach;
                                unset($course);
                            endif;
                            if (!empty($blocked_courses)) :
                                foreach ($blocked_courses as $course) :
                                    $blocked = '(Заблокирован)';
                                    include('./app_fold/views/course/user_course/course_item.php');
                                endforeach;
                                unset($course);
                            endif;
                        else:?>
                            <h3 class="info">Информация не найдена</h3>
                        <?php endif;?>
                    </div>

                    <script>
                        $('.tren_block.tren_order').slick({
                            dots: false,
                            infinite: true,
                            arrows: false,
                            speed: 300,
                            autoplay: true,
                            slidesToShow: 1,
                            slidesToScroll: 1
                        });
                    </script>
                    <?php include_once('./app_fold/views/pagination.php');?>
                </div>
            </div>
        </div><!-- content_col -->
    </div>
</div><!-- content -->
