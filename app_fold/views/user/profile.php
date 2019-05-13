<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="content" class="container">
    <div class="row">
        <div class="col-lg-2 left_sidebar">
            <?php include_once('./app_fold/views/user/user_menu.php');?>
        </div><!-- left_sidebar -->
        <div class="col-lg-10 content_col">
            <?php
            // Уведомления
            include_once('./app_fold/views/notification/user_profile_notifications.php');
            // Быстрое сеню профиля
            include_once('./app_fold/views/user/quick_menu.php');
            $user_data = !empty($user_session) ? $user_session : null;
            $profile_title = 'Профиль';
            include_once('./app_fold/views/user/profile/profile_info.php');
            include_once('./app_fold/views/promocodes/promocode_for_friend.php');
            include_once('./app_fold/views/calendar/calendar.php'); ?>
            <!--<div class="content_block">
                <div class="content_block_h parent">
                    <h3>Предлагаемые курсы</h3>
                    <div class="content_block_h_buts">
                        <div class="content_block_h_slide kurs_slide"></div>
                        <div class="content_block_h_close"></div>
                    </div>
                </div>
                <div class="kurs_block_val">
                    <div class="kurs_head">
                        <div class="kurs_h_row">
                            <div class="kurs_h_col">Название</div>
                            <div class="kurs_h_col">Контакты</div>
                            <div class="kurs_h_col">Цена</div>
                            <div class="kurs_h_col">Статус</div>
                            <div class="kurs_h_col"><a href="" class="kurs_all_but">Все курсы</a></div>
                        </div>
                    </div>
                    <div class="kurs_body">
                        <div class="kurs_row">
                            <div class="kurs_col">Lion KC</div>
                            <div class="kurs_col"><a href="">+7 (777) 777-77-77</a></div>
                            <div class="kurs_col">11 999 руб.</div>
                            <div class="kurs_col"><button class="kurs_bay_but">Купить</button></div>
                            <div class="kurs_col"><a href="" class="kurs_more_but">Подробнее</a></div>
                        </div>
                        <div class="kurs_row">
                            <div class="kurs_col">ABC Lounge</div>
                            <div class="kurs_col"><a href="">+7 (777) 777-77-77</a></div>
                            <div class="kurs_col">11 999 руб.</div>
                            <div class="kurs_col"><button class="kurs_bay_but">Купить</button></div>
                            <div class="kurs_col"><a href="" class="kurs_more_but">Подробнее</a></div>
                        </div>
                        <div class="kurs_row">
                            <div class="kurs_col">Lion KC</div>
                            <div class="kurs_col"><a href="">+7 (777) 777-77-77</a></div>
                            <div class="kurs_col">11 999 руб.</div>
                            <div class="kurs_col"><span class="kurs_bay_but">Куплено</span></div>
                            <div class="kurs_col"><a href="" class="kurs_more_but">Подробнее</a></div>
                        </div>
                        <div class="kurs_row">
                            <div class="kurs_col">ABC Lounge</div>
                            <div class="kurs_col"><a href="">+7 (777) 777-77-77</a></div>
                            <div class="kurs_col">11 999 руб.</div>
                            <div class="kurs_col"><button class="kurs_bay_but">Купить</button></div>
                            <div class="kurs_col"><a href="" class="kurs_more_but">Подробнее</a></div>
                        </div>
                        <div class="kurs_row">
                            <div class="kurs_col">Lion KC</div>
                            <div class="kurs_col"><a href="">+7 (777) 777-77-77</a></div>
                            <div class="kurs_col">11 999 руб.</div>
                            <div class="kurs_col"><button class="kurs_bay_but">Купить</button></div>
                            <div class="kurs_col"><a href="" class="kurs_more_but">Подробнее</a></div>
                        </div>
                    </div>
                </div>
            </div>-->
        </div><!-- content_col -->
    </div>
</div><!-- content -->