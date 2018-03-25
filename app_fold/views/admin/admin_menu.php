<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<ul class="profile_menu">
    <li>
        <a href="/administration/site" <?php if ($page_menu == 'site_info') { echo 'class="active"'; } ?>>
            <span><img src="/img/menu_ico14.png" alt=""></span><span>Сайт</span>
        </a>
    </li>
    <li>
        <a href="/administration/users" <?php if ($page_menu == 'users') { echo 'class="active"'; } ?>>
            <span><img src="/img/menu_ico1.png" alt=""></span><span>Пользователь</span>
        </a>
    </li>
    <li>
        <a href="/administration/couches" <?php if ($page_menu == 'a_couches') { echo 'class="active"'; } ?>>
            <span><img src="/img/menu_ico17.png" alt=""></span><span>Тренер</span>
        </a>
    </li>
    <li>
        <a href="/administration/admin" <?php if ($page_menu == 'admins') { echo 'class="active"'; } ?>>
            <span><img src="/img/menu_ico18.png" alt=""></span><span>Администратор</span>
        </a>
    </li>
    <li>
        <a href="/administration/video" <?php if ($page_menu == 'video') { echo 'class="active"'; } ?>>
            <span><img src="/img/menu_ico19.png" alt=""></span><span>Видео</span>
        </a>
    </li>
    <li>
        <a href="/administration/courses" <?php if ($page_menu == 'a_courses') { echo 'class="active"'; } ?>>
            <span><img src="/img/menu_ico3.png" alt=""></span><span>Курс</span>
        </a>
    </li>
    <li>
        <a href="/administration/ingestion/type" <?php if ($page_menu == 'ingestion_type') { echo 'class="active"'; } ?>>
            <span><img src="/img/menu_ico8.png" alt=""></span><span>Тип приема пищи</span>
        </a>
    </li>
    <li>
        <a href="/administration/ingestion" <?php if ($page_menu == 'ingestion') { echo 'class="active"'; } ?>>
            <span><img src="/img/menu_ico8.png" alt=""></span><span>Прием пищи</span>
        </a>
    </li>
    <li>
        <a href="/administration/categories" <?php if ($page_menu == 'categories') { echo 'class="active"'; } ?>>
            <span><img src="/img/menu_ico9.png" alt=""></span><span>Категория товара</span>
        </a>
    </li>
    <li>
        <a href="/administration/store" <?php if ($page_menu == 'a_store') { echo 'class="active"'; } ?>>
            <span><img src="/img/menu_ico9.png" alt=""></span><span>Товар</span>
        </a>
    </li>
    <li>
        <a href="/administration/orders" <?php if ($page_menu == 'a_orders') { echo 'class="active"'; } ?>>
            <span><img src="/img/menu_ico10.png" alt=""></span><span>Заказы</span>
        </a>
    </li>
    <?php
    /*<li>
        <a href="/administration/journal/articles" <?php if ($page_menu == 'a_journal') { echo 'class="active"'; } ?>>
            <span><img src="/img/menu_ico14.png" alt=""></span><span>Журнал</span>
        </a>
    </li>*/
    ?>
    <li>
        <a href="/administration/blog/posts" <?php if ($page_menu == 'blog_posts') { echo 'class="active"'; } ?>>
            <span><img src="/img/menu_ico14.png" alt=""></span><span>Записи блога</span>
        </a>
    </li>
    <li>
        <a href="/administration/blog/comments" <?php if ($page_menu == 'blog_comments') { echo 'class="active"'; } ?>>
            <span><img src="/img/menu_ico14.png" alt=""></span><span>Комментарии блога</span>
        </a>
    </li>
    <li>
        <a href="/administration/messages" <?php if ($page_menu == 'messages') { echo 'class="active"'; } ?>>
            <span><img src="/img/menu_ico4.png" alt=""></span><span>Сообщения пользователей</span>
        </a>
    </li>
    <li>
        <a href="/administration/feedback" <?php if ($page_menu == 'feedback') { echo 'class="active"'; } ?>>
            <span><img src="/img/menu_ico20.png" alt=""></span><span>Обратная связь</span>
        </a>
    </li> 
    <li>
        <a href="/administration/sublist" <?php if ($page_menu == 'sublist') { echo 'class="active"'; } ?>>
            <span><img src="/img/menu_ico1.png" alt=""></span><span>Подписчики</span>
        </a>
    </li>
</ul>
