<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<ul class="anketa_block_nav parent">
    <li>
        <a href="/administration/users">
            <span <?php if ($page_submenu == 'a_users') { echo 'class="anketa_active"'; } ?>>Пользователи</span>
        </a>
    </li>
    <li>
        <a href="/administration/couches">
            <span <?php if ($page_submenu == 'a_couches') { echo 'class="anketa_active"'; } ?>>Тренеры</span>
        </a>
    </li>
    <li>
        <a href="/administration/admins">
            <span <?php if ($page_submenu == 'a_admins') { echo 'class="anketa_active"'; } ?>>Администраторы</span>
        </a>
    </li>
</ul>