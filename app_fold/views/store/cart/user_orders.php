<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="content" class="container">
    <div class="row">
        <div class="col-lg-2 left_sidebar">
            <?php include_once('./app_fold/views/user/user_menu.php');?>
        </div><!-- left_sidebar -->
        <div class="col-lg-10 content_col">
            <div class="content_block">
                <div class="content_block_h new_content_block_h parent">
                    <h3>Покупки</h3>
                    <div class="content_block_h_buts">
                        <div class="content_block_h_slide kurs_slide"></div>
                        <div class="content_block_h_close"></div>
                    </div>
                </div>
                <div class="kurs_block_val">
                    <?php if (!empty($orders)): ?>
                        <div class="orders_container_wrap">
                            <?php foreach ($orders as $order): ?>
                                <div class="orders_container">
                                    <div class="order_image"><img src="<?php echo $order['crs_image']; ?>" alt="" /></div>
                                    <div class="order_info_wrap">
                                        <div class="oi_title"><?php echo $order['crs_name']; ?></div>
                                        <div class="oi_subtitle"><?php echo $order['crs_desc']; ?></div>
                                        <div class="oi_info">
                                            <?php if (!empty($order['coaches'])): ?>
                                                <div class="oi_i_coach">
                                                    <div class="oi_i_title">Тренер</div>
                                                    <div class="tren_block tren_order">
                                                        <?php $coach = $order['coaches'][0]; ?>
                                                        <div class="tren_item">
                                                            <div class="tren_ava"><img src="<?php echo $coach['image']?>" alt=""></div>
                                                            <a href="/profile/<?php echo $coach['id']?>" class="tren_link">
                                                                <span class="tren_name"><?php echo $coach['name']?></span>
                                                                <span class="tren_surname"><?php echo $coach['surname']?></span>
                                                            </a>
                                                            <div class="tren_desk"><?php echo $coach['special']?></div>
                                                        </div>
                                                        <?php unset($coach); ?>
                                                    </div>
                                                </div>
                                            <?php endif;?>
                                            <div class="oi_i_details">
                                                <div class="oi_i_title">Информация о заказе</div>
                                                <div class="oi_i_s_details_wrap">
                                                    <div class="oi_i_s_details"><i class="fa fa-chevron-right" aria-hidden="true"></i>№ <?php echo $order['id']; ?></div>
                                                    <div class="oi_i_s_details"><i class="fa fa-chevron-right" aria-hidden="true"></i><?php echo $order['date']; ?></div>
                                                    <div class="oi_i_s_details"><i class="fa fa-chevron-right" aria-hidden="true"></i><?php echo $order['price']; ?> руб.</div>
                                                    <div class="oi_i_s_details"><i class="fa fa-chevron-right" aria-hidden="true"></i><?php echo $order['payment']; ?></div>
                                                    <div class="oi_i_s_details"><i class="fa fa-chevron-right" aria-hidden="true"></i><?php echo $order['user_email']; ?></div>
                                                </div>
                                            </div>
                                            <div class="oi_i_status">
                                                <div class="oi_i_title">Статус</div>
                                                <div class="oi_i_details_wrap">
                                                    <?php $s_active = ($order['payment_status'] == 'Оплачено') ? 'active' : ''; ?>
                                                    <div class="oi_d_status <?php echo $s_active; ?>"><?php echo $order['payment_status']; ?></div>
                                                    <div class="oi_d_buy">
                                                        <?php if($order['payment_status'] == 'Не оплачено'): ?>
                                                            <a href="#" class="buy_course" data-cid="<?php echo $order['crs_id']; ?>" data-oid="<?php echo $order['id']; ?>">Оплатить</a>
                                                        <?php else: ?>
                                                            <span>Оплатить</span>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="oi_d_prog">
                                                        <div class="calendar_prof_item">
                                                            <div class="calendar_prof_end">
                                                                <span class="calendar_prof_end_line" style="width: <?php echo $order['percent_workouts_done']; ?>%; background-color: rgb(67,227,267);"></span>
                                                                <span class="calendar_prof_end_val"><?php echo $order['percent_workouts_done']; ?>%</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="oi_d_link">
                                                        <?php if(!empty($order['uc_id'])): ?>
                                                            <a href="/profile/course/<?php echo $order['uc_id']; ?>">Продолжить</a>
                                                        <?php else: ?>
                                                            <span>Продолжить</span>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach;
                            unset($order);?>
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
                            <?php include_once('./app_fold/views/pagination.php'); ?>
                        </div>
                    <?php else: ?>
                        <h3 class="info">Информация не найдена</h3>
                    <?php endif;?>
                </div>
            </div>
        </div><!-- content_col -->
    </div>
</div><!-- content -->