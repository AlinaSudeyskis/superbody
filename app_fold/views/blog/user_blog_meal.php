<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="qa_container">
    <div class="qa_menu">
        <div class="qa_item">
            <?php if(!empty($blog_categories)):
                foreach($blog_categories as $category): ?>
                    <div class="qa_item_cont<?php if(!empty($subsection) and $subsection['id'] == $subsec_id): ?> active<?php endif;?>">
                        <a href="<?php echo $url_path; ?><?php echo $category['id']; ?>"><?php echo $category['name']; ?></a>
                    </div>
                <?php endforeach;
                unset($category);
            endif;?>
        </div>
    </div><!-- qa_menu -->
    <div class="qa_content">
        <?php if(!empty($posts)): ?>
            <div class="posts_block_row">
                <?php foreach ($posts as $post):
                    $post_path = '/blog/'; ?>
                    <?php include('./app_fold/views/blog/posts_item.php'); ?>
                <?php endforeach;
                unset($post);?>
            </div><!-- posts_block_row -->
            <?php include_once('./app_fold/views/pagination.php'); ?>
        <?php elseif(empty($posts) and !empty($page_section)): ?>
            <h3 class="info">Информация не найдена</h3>
        <?php else: ?>
            <h3 class="info">Выберите статью</h3>
        <?php endif;?>
    </div><!-- qa_content -->
</div>