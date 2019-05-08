<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php if(!empty($qa_articles)): ?>
    <div class="admin_list">
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
    </div>
<?php else: ?>
    <h3 class="info">Информация не найдена</h3>
<?php endif; ?>