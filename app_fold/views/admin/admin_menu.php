<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="mob_side_menu_but_wrap">
    <div class="mob_side_menu_but">
        <span></span>
        <span></span>
        <span></span>
    </div>
    <div class="mob_side_menu_close"><span>Скрыть меню</span></div>
</div>
<ul class="profile_menu">
    <li>
        <a href="/administration" <?php if ($page_menu == '') { echo 'class="active"'; } ?>>
            <span><i class="far fa-chart-bar"></i></span><span>Статистика</span>
        </a>
    </li>
    <li>
        <a href="/administration/site" <?php if ($page_menu == 'site_info') { echo 'class="active"'; } ?>>
            <span><i class="fas fa-newspaper"></i></span><span>Контент сайта</span>
        </a>
    </li>
    <li>
        <a href="/administration/users" <?php if ($page_menu == 'users') { echo 'class="active"'; } ?>>
            <span><i class="fas fa-user-friends"></i></span><span>Пользователи</span>
        </a>
    </li>
    <!--<li>
        <a href="/administration/video" <?php /*if ($page_menu == 'video') { echo 'class="active"'; } */?>>
            <span><img src="/img/menu_ico19.png" alt=""></span><span>Видео</span>
        </a>
    </li>-->
    <li>
        <a href="/administration/courses" <?php if ($page_menu == 'a_courses_w') { echo 'class="active"'; } ?>>
            <span><i class="fas fa-dumbbell"></i></span><span>Курсы тренировок</span>
        </a>
    </li>
    <li>
        <a href="/administration/nutritions" <?php if ($page_menu == 'a_courses_n') { echo 'class="active"'; } ?>>
            <span><i class="fas fa-apple-alt"></i></span><span>Курсы питания</span>
        </a>
    </li>
    <li>
        <a href="/administration/promocodes" <?php if ($page_menu == 'promocodes') { echo 'class="active"'; } ?>>
            <span><i class="fas fa-percentage"></i></span><span>Промокоды</span>
        </a>
    </li>
    <!--<li>
        <a href="/administration/categories" <?php /*if ($page_menu == 'categories') { echo 'class="active"'; } */?>>
            <span><img src="/img/menu_ico9.png" alt=""></span><span>Категория товара</span>
        </a>
    </li>-->
    <li>
        <a href="/administration/store" <?php if ($page_menu == 'a_store') { echo 'class="active"'; } ?>>
            <span><img src="/img/menu_ico9.png" alt=""></span><span>Товары</span>
        </a>
    </li>
    <li>
        <a href="/administration/orders" <?php if ($page_menu == 'a_orders') { echo 'class="active"'; } ?>>
            <span><i class="fas fa-receipt"></i></span><span>Заказы<?php if(!empty($e_new_orders)): ?> [<?php echo $e_new_orders; ?>]<?php endif; ?></span>
        </a>
    </li>
    <!--<li>
        <a href="/administration/payments" <?php /*if ($page_menu == 'a_payments') { echo 'class="active"'; } */?>>
            <span><i class="far fa-credit-card"></i></span><span>Платежи<?php /*if(!empty($e_new_orders)): */?> [<?php /*echo $e_new_orders; */?>]<?php /*endif; */?></span>
        </a>
    </li>-->
    <?php
    /*<li>
        <a href="/administration/journal/articles" <?php if ($page_menu == 'a_journal') { echo 'class="active"'; } ?>>
            <span><img src="/img/menu_ico14.png" alt=""></span><span>Журнал</span>
        </a>
    </li>*/
    ?>
    <li>
        <a href="/administration/blog/posts" <?php if ($page_menu == 'a_blog') { echo 'class="active"'; } ?>>
            <span><i class="far fa-newspaper"></i></span><span>Блог тренера</span>
        </a>
    </li>
    <li>
        <a href="/administration/coaches/portfolio" <?php if ($page_menu == 'coach_portfolio') { echo 'class="active"'; } ?>>
            <span><i class="far fa-images"></i></span><span>Портфолио тренера</span>
        </a>
    </li>
    <li>
        <a href="/administration/messages" <?php if ($page_menu == 'messages') { echo 'class="active"'; } ?>>
            <span><i class="far fa-comment"></i></span><span>Сообщения пользователей</span>
        </a>
    </li>
    <li>
        <a href="/administration/feedback" <?php if ($page_menu == 'feedback') { echo 'class="active"'; } ?>>
            <span><i class="far fa-comments"></i></span><span>Обратная связь<?php if(!empty($e_new_messages)): ?> [<?php echo $e_new_messages; ?>]<?php endif; ?></span>
        </a>
    </li>
    <li>
        <a href="/administration/question-answer" <?php if ($page_menu == 'e-question-answer') { echo 'class="active"'; } ?>>
            <span><i class="fas fa-question"></i></span><span>Вопрос - Ответ</span>
        </a>
    </li>
    <!--<li>
        <a href="/administration/sublist" <?php /*if ($page_menu == 'sublist') { echo 'class="active"'; } */?>>
            <span><img src="/img/menu_ico1.png" alt=""></span><span>Подписчики</span>
        </a>
    </li>-->
    <li>
        <a href="/administration/notifications/users" <?php if ($page_menu == 'notifications') { echo 'class="active"'; } ?>>
            <span><i class="fas fa-exclamation"></i></span><span>Уведомления</span>
        </a>
    </li>
    <li>
        <a href="/administration/sent/emails" <?php if ($page_menu == 'emails') { echo 'class="active"'; } ?>>
            <span><i class="far fa-envelope"></i></span><span>Эл. письма</span>
        </a>
    </li>
</ul>
