<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<ul class="anketa_block_nav parent">
    <li>
        <a href="/administration/blog/posts">
            <span <?php if ($page_submenu == 'blog_posts'): ?> class="anketa_active" <?php endif;?>>Записи</span>
        </a>
    </li>
    <li>
        <a href="/administration/blog/comments">
            <span <?php if ($page_submenu == 'blog_comments'): ?> class="anketa_active" <?php endif; ?>>Комментарии</span>
        </a>
    </li>
    <li>
        <a href="/administration/blog/categories">
            <span <?php if ($page_submenu == 'blog_categories'): ?> class="anketa_active" <?php endif; ?>>Категории</span>
        </a>
    </li>
</ul>