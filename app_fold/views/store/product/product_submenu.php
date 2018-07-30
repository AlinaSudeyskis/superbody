<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<ul class="anketa_block_nav parent">
    <li>
        <a href="/administration/store">
            <span <?php if ($page_submenu == 'products') { echo 'class="anketa_active"'; } ?>>Товары</span>
        </a>
    </li>
    <li>
        <a href="/administration/categories">
            <span <?php if ($page_submenu == 'categories') { echo 'class="anketa_active"'; } ?>>Категории товаров</span>
        </a>
    </li>
</ul>