<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<ul class="anketa_block_nav parent">
    <li>
        <a href="/administration/course/<?php echo $course_id;?>/video/promo">
            <span <?php if ($video_menu == 'promo'): ?> class="anketa_active" <?php endif;?>>Промо</span>
        </a>
    </li>
    <li>
        <a href="/administration/course/<?php echo $course_id;?>/video/workouts">
            <span <?php if ($video_menu == 'workouts'): ?> class="anketa_active" <?php endif;?>>Тренировки</span>
        </a>
    </li>
    <li>
        <a href="/administration/course/<?php echo $course_id;?>/video/instructions">
            <span <?php if ($video_menu == 'instructions'): ?> class="anketa_active" <?php endif;?>>Инструктажи</span>
        </a>
    </li>
    <li>
        <a href="/administration/course/<?php echo $course_id;?>/video/uncategorized">
            <span <?php if ($video_menu == 'uncategorized'): ?> class="anketa_active" <?php endif;?>>Без категории</span>
        </a>
    </li>
</ul>