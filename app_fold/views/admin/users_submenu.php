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
        <a href="/administration/coaches">
            <span <?php if ($page_submenu == 'a_coaches') { echo 'class="anketa_active"'; } ?>>Тренеры</span>
        </a>
    </li>
    <li>
        <a href="/administration/admins">
            <span <?php if ($page_submenu == 'a_admins') { echo 'class="anketa_active"'; } ?>>Администраторы</span>
        </a>
    </li>
    <li>
        <a href="/administration/users/archive">
            <span <?php if ($page_submenu == 'a_users_archive') { echo 'class="anketa_active"'; } ?>>Архив</span>
        </a>
    </li>
</ul>
<?php if($page_submenu == 'a_users'): ?>
    <ul class="anketa_block_nav parent">
        <li>
            <a href="/administration/users/sublist">
                <span <?php if($page_2submenu == 'eu_sublist'): ?>class="anketa_active"<?php endif;?>>Подписка</span>
            </a>
        </li>
        <li>
            <a href="/administration/users/auth">
                <span <?php if($page_2submenu == 'eu_auth'): ?>class="anketa_active"<?php endif;?>>Авторизованные</span>
            </a>
        </li>
        <li>
            <a href="/administration/users/bought">
                <span <?php if($page_2submenu == 'eu_bought'): ?>class="anketa_active"<?php endif;?>>Купили курс</span>
            </a>
        </li>
    </ul>
<?php endif; ?>
<?php if(!empty($user_data) and $page_submenu !== 'a_users_archive'):
    $user_types = array('user' => 1, 'coach' => 2, 'admin' => 3);
    $user_type  = array_search($user_data['user_type'], $user_types); ?>
    <ul class="anketa_block_nav parent">
        <li>
            <a href="/administration/<?php echo $user_type; ?>/<?php echo $user_data['user_id']; ?>">
                <span <?php if($page_2submenu == 'settings'): ?>class="anketa_active"<?php endif;?>>Настройки</span>
            </a>
        </li>
        <li>
            <a href="/administration/<?php echo $user_type; ?>/<?php echo $user_data['user_id']; ?>/personal">
                <span <?php if($page_2submenu == 'personal'): ?>class="anketa_active"<?php endif;?>>Личные данные</span>
            </a>
        </li>
        <?php if($user_type != 'coach' and $user_type != 'admin'): ?>
            <li>
                <a href="/administration/<?php echo $user_type; ?>/<?php echo $user_data['user_id']; ?>/add_course">
                    <span <?php if($page_2submenu == 'add_course'): ?>class="anketa_active"<?php endif;?>>Добавить курс</span>
                </a>
            </li>
        <?php endif; ?>
    </ul>
<?php endif; ?>