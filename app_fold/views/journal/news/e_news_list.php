<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="content" class="container">
    <div class="row">
        <div class="col-lg-2 left_sidebar">
            <?php include_once('./app_fold/views/admin/admin_menu.php');?>
        </div><!-- left_sidebar -->
        <div class="col-lg-10 content_col">
            <div class="content_block">
                <div class="content_block_container_wrap">
                    <div class="content_block_container">
                        <div class="content_block_h new_content_block_h parent">
                            <h3>Журнал</h3>
                            <div class="content_block_h_ref"><a href="/administration/journal/new" class="add_tab_but">Добавить</a></div>
                        </div>
                    </div>
                </div>
                <div class="kurs_block_val">
                    <div class="admin_journal">
                        <ul class="journal_block_nav parent">
                            <li><a href="/administration/journal/articles">Статьи</a></li>
                            <li><a href="/administration/journal/interviews">Интервью</a></li>
                            <li><a class="journal_active" href="/administration/journal/news">Новости</a></li>
                        </ul>
                        <div class="admin_list">
                            <?php if (!empty($posts)) :
                                foreach ($posts as $ns) :?>
                                    <div class="admin_item">
                                        <div class="journal_block_item_h"><a href="/journal/news/<?php echo $ns['id']; ?>"><?php echo $ns['name']; ?></a></div>
                                        <div class="journal_block_item_data">Дата публикации <?php echo $ns['date']; ?></div>
                                        <div class="journal_block_item_edit"><a href="/administration/journal/<?php echo $ns['id']; ?>">Редактировать</a></div>
                                    </div>
                                <?php endforeach;
                                unset($ns);
                            endif;?>
                        </div>
                    </div>
                    <?php include_once('./app_fold/views/pagination.php'); ?>
                </div>
            </div>
        </div><!-- content_col -->
    </div>
</div><!-- content -->
