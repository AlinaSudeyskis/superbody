<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<ul class="anketa_block_nav parent">
    <li>
        <a href="/administration/orders/capture">
            <span <?php if ($page_submenu == 'capture') { echo 'class="anketa_active"'; } ?>>Ожидают подтверждения магазином</span>
        </a>
    </li>
    <li>
        <a href="/administration/orders/succeeded">
            <span <?php if ($page_submenu == 'succeeded') { echo 'class="anketa_active"'; } ?>>Оплачены</span>
        </a>
    </li>
    <li>
        <a href="/administration/orders/canceled">
            <span <?php if ($page_submenu == 'canceled') { echo 'class="anketa_active"'; } ?>>Отменены</span>
        </a>
    </li>
    <li>
        <a href="/administration/orders/pending">
            <span <?php if ($page_submenu == 'pending') { echo 'class="anketa_active"'; } ?>>Ожидают оплаты пользователем</span>
        </a>
    </li>
</ul>
<?php if($page_submenu == 'succeeded'): ?>
    <ul class="anketa_block_nav parent">
        <li>
            <a href="/administration/orders/succeeded/uncompleted">
                <span <?php if ($page_submenu2 == 'uncompleted') { echo 'class="anketa_active"'; } ?>>Не выполнено</span>
            </a>
        </li>
        <li>
            <a href="/administration/orders/succeeded/done">
                <span <?php if ($page_submenu2 == 'done') { echo 'class="anketa_active"'; } ?>>Выполнено</span>
            </a>
        </li>
    </ul>
<?php endif; ?>