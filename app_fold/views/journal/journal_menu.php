<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<ul class="journal_block_nav parent">
    <li><a href="/journal/articles" <?php if ($page_menu == 'articles' or $page_menu == 'article') { echo 'class="journal_active"'; } ?>>Статьи</a></li>
    <li><a href="/journal/interviews" <?php if ($page_menu == 'interviews' or $page_menu == 'interview') { echo 'class="journal_active"'; } ?>>Интервью</a></li>
    <li><a href="/journal/news" <?php if ($page_menu == 'news_list' or $page_menu == 'news') { echo 'class="journal_active"'; } ?>>Новости</a></li>
</ul>