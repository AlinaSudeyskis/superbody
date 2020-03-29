<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="header_logo">
    <?php if (!empty($site_info['logotype'])):?>
        <a href="/"><img src="<?php echo $site_info['logotype']; ?>" alt=""></a>
    <?php endif;?>
</div>

<nav class="header_menu">
    <ul class="menu">
        <?php if (empty($user_session)) :?>
            <li><a href="/login" class="menu_login <?php if ($page_menu == 'login') { echo 'active'; } ?>">ВХОД</a></li>
        <?php endif;?>
        <li><a href="/" <?php if ($page_menu == 'index') { echo 'class="active"'; } ?>>ГЛАВНАЯ</a></li>
        <?php /*<li><a href="/journal/articles" <?php if ($page_menu == 'articles') { echo 'class="active"'; } ?>>ЖУРНАЛ</a></li>*/?>
        <li><a href="/coaches" <?php if ($page_menu == 'coaches') { echo 'class="active"'; } ?>>ТРЕНЕРЫ</a></li>
        <li <?php if (!empty($menu_courses['course_types'])) :?> class="submenu_li" <?php endif;?>>
            <a href="/courses" <?php if ($page_menu == 'courses') { echo 'class="active"'; } ?>>КУРСЫ</a>
            <span class="more_submenu"></span>
            <?php if (!empty($menu_courses['course_types'])) :?>
                <ul class="submenu">
                    <?php foreach ($menu_courses['course_types'] as $m_course) :?>
                        <li><a href="/courses/workouts/<?php echo $m_course['id']; ?>"><?php echo $m_course['name']; ?></a></li>
                    <?php endforeach;
                    unset($m_course);?>
                </ul>
            <?php endif;?>
        </li>
        <li><a href="/blog" <?php if ($page_menu == 'blog') { echo 'class="active"'; } ?>>БЛОГ</a></li>
        <?php if (!empty($user_session)) :?>
            <li><a href="<?php echo '/profile/' . $user_session['id']; ?>" <?php if ($page_menu == 'profile') { echo 'class="active"'; } ?>>ПРОФИЛЬ</a></li>
        <?php endif;?>
        <?php if (!empty($user_session) and $user_session['type'] == 3) :?>
            <!--<li><a href="/store" <?php /*if ($page_menu == 'store') { echo 'class="active"'; }  */?>>МАГАЗИН</a></li>-->
        <?php endif;?>
        <li class="submenu_li">
            <a href="/about" <?php if ($page_menu == 'about') { echo 'class="active"'; } ?>>О НАС</a>
            <span class="more_submenu"></span>
            <ul class="submenu">
                <li><a href="/about" <?php if ($page_menu == 'about') { echo 'class="active"'; } ?>>О ПРОЕКТЕ</a></li>
                <li><a href="/contacts" <?php if ($page_menu == 'contacts') { echo 'class="active"'; } ?>>КОНТАКТЫ</a></li>
            </ul>
        </li>
        <li><a href="/support" <?php if ($page_menu == 'question-answer') { echo 'class="active"'; } ?>>ИНСТРУКЦИИ</a></li>
    </ul>
</nav>
<?php if ($page_menu == 'index'):?>
    <div class="up_but up_but_main"></div>
<?php endif;?>
<div class="mob_menu_but">
    <span></span>
    <span></span>
    <span></span>
</div>
