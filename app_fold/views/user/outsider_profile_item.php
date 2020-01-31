<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="row user_prof_wrap">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 user_prof">
        <?php
        // Уведомления
        include_once('./app_fold/views/notification/outsider_profile_notifications.php');?>
    </div>
</div>
<div class="row user_prof_wrap">
    <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12 user_prof">
        <?php $profile_title = $title;
        include_once('./app_fold/views/user/profile/profile_info.php'); ?>
        <div class="content_block new_content_block">
            <div class="notification_block_h"></div>
        </div>
    </div>
    <div class="col-lg-9 col-md-9 col-sm-8 col-xs-12 user_prog">
        <?php include_once('./app_fold/views/course/user_course/courses_progress.php'); ?>
    </div>
</div>
<div class="content_block new_content_block">
    <div class="content_block_h parent">
        <h3>Курсы пользователя</h3>
        <div class="content_block_h_buts">
            <div class="content_block_h_slide kurs_slide"></div>
            <div class="content_block_h_close"></div>
        </div>
    </div>
    <div class="kurs_block_val">
        <div class="orders_container_wrap">
            <?php if(!empty($courses) or !empty($blocked_courses)):
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
<div class="content_block new_content_block">
    <div class="content_block_h parent">
        <h3>Использованные промокоды</h3>
        <div class="content_block_h_buts">
            <div class="content_block_h_slide kurs_slide"></div>
            <div class="content_block_h_close"></div>
        </div>
    </div>
    <div class="kurs_block_val">
        <div class="used_pc_container_wrap">
            <?php if(!empty($used_promocodes)):
                foreach ($used_promocodes as $u_p) : ?>
                    <div class="used_pc_wrap">
                        <div class="used_pc_h"><a href="/administration/promocode/<?php echo $u_p['id']; ?>"><?php echo $u_p['code']; ?></a></div>
                        <div class="used_pc_subh"><?php echo $u_p['discount'].$u_p['discount_type']; ?></div>
                        <div class="used_pc_desc"><a href="/administration/order/<?php echo $u_p['order_id']; ?>">Заказ №<?php echo $u_p['order_id']; ?></a></div>
                    </div>
                <?php endforeach;
                unset($course);
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
