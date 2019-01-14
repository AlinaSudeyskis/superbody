<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if (!empty($user_session)) :
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
            <a href="/profile/<?php echo $user_session['id'];?>" <?php if ($page_menu == 'profile') { echo 'class="active"'; } ?>>
                <span><img src="/img/menu_ico1.png" alt=""></span><span>Моя страница</span>
            </a>
        </li>
        <li>
            <a href="/settings" <?php if ($page_menu == 'settings') { echo 'class="active"'; } ?>>
                <span><img src="/img/menu_ico2.png" alt=""></span><span>Настройки</span>
            </a>
        </li>
        <?php $user_blocked = ($user_session['blocked'] == 1) ? 'class="disabled"' : '';?>
        <li <?php echo $user_blocked; ?> >
            <a href="/questionnaire" <?php if ($page_menu == 'questionnaire') { echo 'class="active"'; } ?>>
                <span><img src="/img/menu_ico3.png" alt=""></span><span>Анкета</span>
            </a>
        </li>
        <li <?php echo $user_blocked; ?> >
            <a href="/calendar" <?php if ($page_menu == 'calendar') { echo 'class="active"'; } ?>>
                <span><img src="/img/menu_ico5.png" alt=""></span><span>Календарь</span>
            </a>
        </li>
        <li>
            <a href="/messages" <?php if ($page_menu == 'messages') { echo 'class="active"'; } ?>>
                <span><img src="/img/menu_ico4.png" alt=""></span><span>Сообщения</span>
            </a>
        </li>
        <li <?php echo $user_blocked; ?> >
            <a href="/profile/courses" <?php if ($page_menu == 'u_courses') { echo 'class="active"'; } ?>>
                <span><img src="/img/menu_ico6.png" alt=""></span><span>Мои курсы</span>
            </a>
        </li>
        <?php if($user_session['type'] == 3): ?>
            <li <?php echo $user_blocked; ?> >
                <a href="/profile/meals" <?php if ($page_menu == 'u_meals') { echo 'class="active"'; } ?>>
                    <span><img src="/img/menu_ico24.png" alt=""></span><span>Питание</span>
                </a>
            </li>
        <?php endif; ?>
        <li <?php echo $user_blocked; ?> >
            <a href="/progress" <?php if ($page_menu == 'progress') { echo 'class="active"'; } ?>>
                <span><img src="/img/menu_ico7.png" alt=""></span><span>Прогресс</span>
            </a>
        </li>
        <?php if($user_session['type'] == 3): ?>
            <li>
                <a href="/cart" <?php if ($page_menu == 'cart') { echo 'class="active"'; } ?>>
                    <span><img src="/img/menu_ico9.png" alt=""></span><span>Корзина</span>
                </a>
            </li>
        <?php endif; ?>
        <li><a href="/orders" <?php if ($page_menu == 'orders') { echo 'class="active"'; } ?>>
                <span><img src="/img/menu_ico10.png" alt=""></span><span>Покупки</span></a>
        </li>
        <?php if($user_session['type'] == 3): ?>
            <li><a href="/administration">
                    <span><img src="/img/menu_ico25.png" alt=""></span><span>Админ. панель</span></a>
            </li>
        <?php endif; ?>
        <!--<li><a href="#"><span><img src="/img/menu_ico11.png" alt=""></span><span>FitCoin</span></a></li>-->
    </ul>
<?php endif;?>