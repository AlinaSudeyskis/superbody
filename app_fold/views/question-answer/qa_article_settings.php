<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php if(!empty($qa_article)): ?>
    <div class="anketa_block">
        <div class="anketa_block_cont">
            <form action="" method="post" enctype="multipart/form-data">
                <div class="admin_form_buts_wrap_container">
                    <div class="admin_form_buts_wrap parent">
                        <?php if($qa_article['blocked'] == 0) :?>
                            <input type="submit" name="bt_block_article" class="video_admin_form_block" value="Блокировать"/>
                        <?php else :?>
                            <input type="submit" name="bt_unblock_article" class="video_admin_form_block" value="Разблокировать"/>
                        <?php endif;?>
                        <input type="submit" name="bt_save_article" value="Сохранить" class="video_admin_form_send defaultActionButton" />
                    </div>
                </div>
                <div class="video_admin_form">
                    <div class="anketa_block_item_h">Редактирование статьи</div>
                    <?php include_once('./app_fold/views/question-answer/qa_article_settings_item.php'); ?>
                </div>
            </form>
        </div>
    </div>
<?php else: ?>
    <h3 class="info">Информация не найдена</h3>
<?php endif; ?>