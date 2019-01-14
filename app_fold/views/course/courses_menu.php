<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<ul class="anketa_block_nav parent">
    <li>
        <a href="/administration/courses">
            <span <?php if ($page_submenu == 'a_courses_w'): ?> class="anketa_active" <?php endif;?>>Курсы</span>
        </a>
    </li>
    <li>
        <a href="/administration/courses/type">
            <span <?php if ($page_submenu == 'courses_types'): ?> class="anketa_active" <?php endif; ?>>Категория курса</span>
        </a>
    </li>
    <li>
        <a href="/administration/courses/archive">
            <span <?php if ($page_submenu == 'courses_archive'): ?> class="anketa_active" <?php endif; ?>>Архив</span>
        </a>
    </li>
</ul>