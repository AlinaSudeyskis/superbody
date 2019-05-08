<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if($page_submenu == 'sections')
{
    $breadcrumbs = array('/about' => 'Вопрос - Ответ');
}
elseif($page_submenu == 'section')
{
    if(!empty($section) and empty($subsection))
    {
        $breadcrumbs = array('/support' => 'Вопрос - Ответ', '/support/'.$section['id'] => $section['name']);
    }
    elseif(!empty($section) and !empty($subsection))
    {
        $breadcrumbs = array('/support' => 'Вопрос - Ответ', '/support/'.$section['id'] => $section['name'], '/support/'.$section['id'].'/'.$subsection['id'] => $subsection['name']);
    }
    else
    {
        $breadcrumbs = array('/support' => 'Вопрос - Ответ');
    }
}
elseif($page_submenu == 'article')
{
    $breadcrumbs = array('/support' => 'Вопрос - Ответ', '/support/'.$section['id'] => $section['name'], '/support/'.$section['id'].'/'.$subsection['id'] => $subsection['name'], '/support/article' => $article['name']);
}

include_once('./app_fold/views/breadcrumb.php');
?>
<div id="content" class="container">
    <div class="search_form_wrap">
        <div class="open_search_form"></div>
        <form action="/support" class="search_form parent" method="post">
            <input type="text" name="search" class="search_in" placeholder="Поиск" value="<?php if(!empty($search)): echo $search; endif; ?>">
            <input type="submit" name="bt_support_search" class="search_but" value="Отправить">
        </form>
    </div>
    <?php if($page_submenu == 'sections'):
        include_once('./app_fold/views/question-answer/public_qa_sections.php');
    elseif($page_submenu == 'section'):
        include_once('./app_fold/views/question-answer/public_qa_section.php');
    elseif($page_submenu == 'article'):
        include_once('./app_fold/views/question-answer/public_qa_article.php');
    endif; ?>
</div><!-- content -->