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
            <a href="/profile/<?php echo $user_session['id'];?>" <?php if ($page_menu == 'profile') { echo 'class="active"'; } ?>>
                <span><img src="/img/menu_ico1.png" alt=""></span><span>Моя страница</span>
            </a>
        </li>
        <li>
            <a href="/settings" <?php if ($page_menu == 'settings') { echo 'class="active"'; } ?>>
                <span><img src="/img/menu_ico2.png" alt=""></span><span>Настройки</span>
            </a>
        </li>
        <li>
            <a href="/messages" <?php if ($page_menu == 'messages') { echo 'class="active"'; } ?>>
                <span><img src="/img/menu_ico4.png" alt=""></span><span>Сообщения</span>
            </a>
        </li>
        <li>
            <a href="/profile/courses" <?php if ($page_menu == 'u_courses') { echo 'class="active"'; } ?>>
                <span><img src="/img/menu_ico6.png" alt=""></span><span>Курсы</span>
            </a>
        </li>
        <li>
            <a href="/portfolio" <?php if ($page_menu == 'portfolio') { echo 'class="active"'; } ?>>
                <span><img src="/img/menu_ico12.png" alt=""></span><span>Портфолио</span>
            </a>
        </li>
        <li>
            <a href="/clients/activity" <?php if ($page_menu == 'activity') { echo 'class="active"'; } ?>>
                <span><img src="/img/menu_ico13.png" alt=""></span><span>Активность клиентов</span>
            </a>
        </li>
        <li>
            <a href="/posts" <?php if ($page_menu == 'blog') { echo 'class="active"'; } ?>>
                <span><img src="/img/menu_ico14.png" alt=""></span><span>Блог</span>
            </a>
        </li>
        <li>
            <a href="/partner" <?php if ($page_menu == 'partner') { echo 'class="active"'; } ?>>
                <span><img src="/img/menu_ico15.png" alt=""></span><span>Партнерка</span>
            </a>
        </li>
        <li>
            <a href="#" <?php if ($page_menu == 'wallet') { echo 'class="active"'; } ?>>
                <span><img src="/img/menu_ico16.png" alt=""></span><span>Кошелек</span>
            </a>
        </li>
    </ul>