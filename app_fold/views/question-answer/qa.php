<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="content" class="container">
    <div class="row">
        <div class="col-lg-2 left_sidebar">
            <?php include_once('./app_fold/views/admin/admin_menu.php');?>
        </div><!-- left_sidebar -->
        <div class="col-lg-10 content_col">
            <div class="content_block new_content_block">
                <div class="content_block_container_wrap">
                    <div class="content_block_container">
                        <div class="content_block_h new_content_block_h parent">
                            <h3>Вопрос - Ответ</h3>
                            <a href="/administration/question-answer/new" class="add_tab_but">Добавить статью</a>
                            <a href="/administration/question-answer/section/new" class="add_tab_but">Добавить раздел</a>
                            <a href="/administration/question-answer/subsection/new" class="add_tab_but">Добавить подраздел</a>
                        </div>
                        <ul class="anketa_block_nav parent">
                            <li>
                                <a href="/administration/question-answer">
                                    <span <?php if ($page_submenu == 'qa_articles'): ?> class="anketa_active" <?php endif;?>>Статьи</span>
                                </a>
                            </li>
                            <li>
                                <a href="/administration/question-answer/sections">
                                    <span <?php if ($page_submenu == 'qa_sections'): ?> class="anketa_active" <?php endif;?>>Разделы</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="kurs_block_val">
                    <?php if($page_type == 'articles'):
                        include_once('./app_fold/views/question-answer/qa_list.php');?>
                    <?php elseif($page_type == 'article'):
                        include_once('./app_fold/views/question-answer/qa_article_settings.php');?>
                    <?php elseif($page_type == 'new_article'):
                        include_once('./app_fold/views/question-answer/qa_new_article.php');?>
                    <?php elseif($page_type == 'sections'):
                        include_once('./app_fold/views/question-answer/qa_sections.php');?>
                    <?php elseif($page_type == 'section'):
                        include_once('./app_fold/views/question-answer/qa_section_settings.php');?>
                    <?php elseif($page_type == 'new_section'):
                        include_once('./app_fold/views/question-answer/qa_new_section.php');?>
                    <?php elseif($page_type == 'new_subsection'):
                        include_once('./app_fold/views/question-answer/qa_new_subsection.php');?>
                    <?php elseif($page_type == 'subsection'):
                        include_once('./app_fold/views/question-answer/qa_subsection_settings.php');?>
                    <?php else: ?>
                        <h3 class="info">Информация не найдена</h3>
                    <?php endif; ?>
                </div>
            </div>
        </div><!-- content_col -->
    </div>
</div><!-- content -->