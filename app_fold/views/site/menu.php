<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<ul class="anketa_block_nav parent">
    <li>
        <a href="/administration/site">
            <span <?php if ($page_submenu == 'index'): ?> class="anketa_active" <?php endif;?>>Главная</span>
        </a>
    </li>
    <li>
        <a href="/administration/site/header">
            <span <?php if ($page_submenu == 'header'): ?> class="anketa_active" <?php endif;?>>Шапка и футер</span>
        </a>
    </li>
    <li>
        <a href="/administration/site/banner">
            <span <?php if ($page_submenu == 'banner'): ?> class="anketa_active" <?php endif;?>>Баннер</span>
        </a>
    </li>
    <li>
        <a href="/administration/site/about">
            <span <?php if ($page_submenu == 'a_about'): ?> class="anketa_active" <?php endif;?>>О нас</span>
        </a>
    </li>
    <li>
        <a href="/administration/site/contacts">
            <span <?php if ($page_submenu == 'a_contacts'): ?> class="anketa_active" <?php endif;?>>Контакты</span>
        </a>
    </li>
    <li>
        <a href="/administration/site/auth">
            <span <?php if ($page_submenu == 'a_auth'): ?> class="anketa_active" <?php endif;?>>Авторизация</span>
        </a>
    </li>
    <li>
        <a href="/administration/site/spec">
            <span <?php if ($page_submenu == 'a_spec'): ?> class="anketa_active" <?php endif;?>>Курсы/Спец.</span>
        </a>
    </li>
    <li>
        <a href="/administration/site/meta">
            <span <?php if ($page_submenu == 'a_meta'): ?> class="anketa_active" <?php endif;?>>Метаданные</span>
        </a>
    </li>
    <li>
        <a href="/administration/site/cookies">
            <span <?php if ($page_submenu == 'a_cookies'): ?> class="anketa_active" <?php endif;?>>Cookies</span>
        </a>
    </li>
</ul>