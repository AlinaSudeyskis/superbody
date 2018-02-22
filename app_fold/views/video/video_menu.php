<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<ul class="anketa_block_nav parent">
    <li>
        <a href="/administration/video/promo">
            <span <?php if ($page_submenu == 'promo'): ?> class="anketa_active" <?php endif;?>>Промо</span>
        </a>
    </li>
    <li>
        <a href="/administration/video/courses">
            <span <?php if ($page_submenu == 'courses'): ?> class="anketa_active" <?php endif;?>>Тренировки</span>
        </a>
    </li>
    <li>
        <a href="/administration/video/instructions">
            <span <?php if ($page_submenu == 'instructions'): ?> class="anketa_active" <?php endif;?>>Инструктажи</span>
        </a>
    </li>
    <li>
        <a href="/administration/video/uncategorized">
            <span <?php if ($page_submenu == 'uncategorized'): ?> class="anketa_active" <?php endif;?>>Без категории</span>
        </a>
    </li>
</ul>