<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<ul class="anketa_block_nav parent">
    <li>
        <a href="/profile/course/<?php echo $course['course_id']; ?>">
            <span <?php if ($page_submenu == 'settings'): ?> class="anketa_active" <?php endif;?>>Настройки</span>
        </a>
    </li>
    <li>
        <a href="/profile/course/<?php echo $course['course_id']; ?>/reviews">
            <span <?php if ($page_submenu == 'reviews'): ?> class="anketa_active" <?php endif;?>>Отзывы</span>
        </a>
    </li>
</ul>