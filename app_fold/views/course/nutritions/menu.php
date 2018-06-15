<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<ul class="anketa_block_nav parent">
    <li>
        <a href="/administration/nutritions">
            <span <?php if ($page_submenu == 'a_courses'): ?> class="anketa_active" <?php endif;?>>Курсы</span>
        </a>
    </li>
    <li>
        <a href="/administration/meals">
            <span <?php if ($page_submenu == 'meals'): ?> class="anketa_active" <?php endif; ?>>Блюда</span>
        </a>
    </li>
    <li>
        <a href="/administration/meals/types">
            <span <?php if ($page_submenu == 'meals_types'): ?> class="anketa_active" <?php endif; ?>>Тип блюда</span>
        </a>
    </li>
    <li>
        <a href="/administration/ingestions">
            <span <?php if ($page_submenu == 'ingestions'): ?> class="anketa_active" <?php endif; ?>>Прием пищи</span>
        </a>
    </li>
</ul>