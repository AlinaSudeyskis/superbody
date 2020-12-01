<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$advertising_display_none  = (empty($site_info) or $site_info['advertising_display'] == 0) ? true : false;
$advertising_display_all   = (!empty($site_info) and $site_info['advertising_display'] == 1 and !empty($user_session) and ($user_session['advertising'] == 0 or $user_session['advertising'] == 1)) ? true : false;
$advertising_display_admin = (!empty($site_info) and $site_info['advertising_display'] == 2 and !empty($user_session) and $user_session['type'] == 3) ? true : false;

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
                <span><i class="far fa-user"></i></span><span>Моя страница</span>
            </a>
        </li>
        <?php $user_blocked = ($user_session['blocked'] == 1) ? 'class="disabled"' : '';?>
        <li>
            <a href="/profile/<?php echo $user_session['id'];?>" class="scroll_to" data-id="calendar" <?php echo $user_blocked; ?> >
                <span><i class="far fa-calendar-alt"></i></span><span>Мои тренировки</span>
            </a>
        </li>
        <li>
            <a href="/profile/meals" <?php if ($page_menu == 'u_meals') { echo 'class="active"'; } ?> <?php echo $user_blocked; ?>>
                <span><i class="fas fa-apple-alt"></i></span><span>Моё питание</span>
            </a>
        </li>
        <li>
            <a href="/questionnaire" <?php if ($page_menu == 'questionnaire') { echo 'class="active"'; } ?> <?php echo $user_blocked; ?> >
                <span><i class="fas fa-clipboard-list"></i></span><span>Анкета</span>
            </a>
        </li>
        <li>
            <a href="/profile/courses" <?php if ($page_menu == 'u_courses') { echo 'class="active"'; } ?> <?php echo $user_blocked; ?> >
                <span><img src="/img/menu_ico6.png" alt=""></span><span>Мои курсы</span>
            </a>
        </li>
        <li>
            <a href="/messages" <?php if ($page_menu == 'messages') { echo 'class="active"'; } ?>>
                <span><i class="far fa-comment"></i></span><span>Сообщения</span>
            </a>
        </li>
        <!--<li>
            <a href="/orders" <?php /*if ($page_menu == 'orders') { echo 'class="active"'; } */?>>
                <span><img src="/img/menu_ico10.png" alt=""></span><span>Покупки</span>
            </a>
        </li>-->
        <li>
            <a href="/settings" <?php if ($page_menu == 'settings') { echo 'class="active"'; } ?>>
                <span><i class="fas fa-sliders-h"></i></span><span>Настройки</span>
            </a>
        </li>
        <?php if($user_session['type'] == 3): ?>
            <!--<li>
                <a href="/cart" <?php /*if ($page_menu == 'cart') { echo 'class="active"'; } */?>>
                    <span><i class="fas fa-shopping-basket"></i></span><span>Корзина</span>
                </a>
            </li>-->
            <li>
                <a href="/profile/e_meals" <?php if ($page_menu == 'e_meals') { echo 'class="active"'; } ?>>
                    <span><i class="fas fa-apple-alt"></i></span><span>Питание (админ.)</span>
                </a>
            </li>
            <li>
                <a href="/administration">
                    <span><i class="fas fa-cogs"></i></span><span>Админ. панель</span>
                </a>
            </li>
        <?php endif; ?>
        <li>
            <a href="https://play.google.com/store/apps/details?id=com.Globalmediaserviceltd.SUPERBODY.PRO">
                <span><i class="fab fa-google-play"></i></span><span class="app">Скачать приложение</span><span class="follow_app">Google play</span>
            </a>
        </li>
        <?php if(!empty($site_info) and $site_info['advertising_premium_display'] == 1 and ($advertising_display_none !== false or $advertising_display_all or $advertising_display_admin)): ?>
            <li class="pm_golden_black">
                <a href="#" class="m_pop-up_premium" style="padding-left: 8px;">
                    <span><i class="fas fa-crown"></i></span><span>Премиум аккаунт</span>
                </a>
            </li>
        <?php endif; ?>
        <!--<li><a href="#"><span><img src="/img/menu_ico11.png" alt=""></span><span>FitCoin</span></a></li>-->
    </ul>
    <?php if (!empty($site_info) and ($advertising_display_none !== false or $advertising_display_all or $advertising_display_admin)): ?>
        <?php if(!empty($site_info['advertising_vertical']) and empty($site_info['advertising_vertical_hide'])): ?>
            <div class="advertising side">
                <?php echo $site_info['advertising_vertical']; ?>
            </div>
        <?php endif; ?>
        <?php if(!empty($site_info['advertising_vertical_mobile']) and empty($site_info['advertising_vertical_mobile_hide'])): ?>
            <div class="advertising side mobile">
                <?php echo $site_info['advertising_vertical_mobile']; ?>
            </div>
        <?php endif; ?>
    <?php endif; ?>
<?php endif;?>