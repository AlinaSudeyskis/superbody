<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="admin_list">
    <?php if(!empty($qa_articles)): ?>
        <?php foreach ($qa_articles as $article): ?>
            <div class="admin_item parent">
                <div class="admin_cont">
                    <div class="admin_name">
                        <a href="/administration/question-answer/<?php echo $article['id']; ?>"><?php echo $article['name']; ?></a>
                    </div>
                </div>
            </div>
        <?php endforeach;
        unset($article);?>
    <?php endif; ?>
</div>