<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<ul class="anketa_block_nav parent">
    <li>
        <a href="/administration/course/<?php echo $course_id; ?>">
            <span <?php if ($page_submenu == 'settings'): ?> class="anketa_active" <?php endif;?>>Настройки</span>
        </a>
    </li>
    <li>
        <a href="/administration/course/<?php echo $course_id; ?>/landing">
            <span <?php if ($page_submenu == 'landing'): ?> class="anketa_active" <?php endif;?>>Landing</span>
        </a>
    </li>
    <li>
        <a href="/administration/course/<?php echo $course_id; ?>/statistics">
            <span <?php if ($page_submenu == 'statistics'): ?> class="anketa_active" <?php endif;?>>Статистика</span>
        </a>
    </li>
    <li>
        <a href="/administration/course/<?php echo $course_id; ?>/reviews">
            <span <?php if ($page_submenu == 'reviews'): ?> class="anketa_active" <?php endif;?>>Отзывы</span>
        </a>
    </li>
    <li>
        <a href="/administration/course/<?php echo $course_id; ?>/video">
            <span <?php if ($page_submenu == 'video'): ?> class="anketa_active" <?php endif;?>>Видео</span>
        </a>
    </li>
    <li>
        <a href="/administration/course/<?php echo $course_id; ?>/extends">
            <span <?php if ($page_submenu == 'extends'): ?> class="anketa_active" <?php endif;?>>Продление</span>
        </a>
    </li>
    <li>
        <a href="/administration/course/<?php echo $course_id; ?>/attached">
            <span <?php if ($page_submenu == 'attached'): ?> class="anketa_active" <?php endif;?>>Питание</span>
        </a>
    </li>
</ul>