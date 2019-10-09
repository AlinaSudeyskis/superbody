<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<ul class="anketa_block_nav parent">
    <li>
        <a href="/profile/course/<?php echo $course['id']; ?>">
            <span <?php if ($page_submenu == 'settings'): ?> class="anketa_active" <?php endif;?>>Настройки</span>
        </a>
    </li>
    <li>
        <a href="/profile/course/<?php echo $course['id']; ?>/reviews">
            <span <?php if ($page_submenu == 'reviews'): ?> class="anketa_active" <?php endif;?>>Мои отзывы</span>
        </a>
    </li>
    <li>
        <a href="/profile/course/<?php echo $course['id']; ?>/order/<?php echo $course['order_id']; ?>">
            <span <?php if ($page_submenu == 'course_order'): ?> class="anketa_active" <?php endif;?>>О заказе</span>
        </a>
    </li>
    <?php if($course['category'] == 'nutrition'): ?>
        <li>
            <a href="/profile/course/<?php echo $course['id']; ?>/menu">
                <span <?php if ($page_submenu == 'menu'): ?> class="anketa_active" <?php endif;?>>Меню</span>
            </a>
        </li>
    <?php endif; ?>
</ul>