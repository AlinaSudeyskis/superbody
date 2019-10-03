<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="anketa_block">
    <div class="anketa_block_cont">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="admin_form_buts_wrap_container">
                <div class="admin_form_buts_wrap parent">
                    <input type="submit" name="bt_save_new_article" value="Сохранить" id="defaultActionButton"  class="video_admin_form_send" />
                </div>
            </div>
            <div class="video_admin_form">
                <div class="anketa_block_item_h">Новая статья</div>
                <?php include_once('./app_fold/views/question-answer/qa_article_settings_item.php'); ?>
            </div>
        </form>
    </div>
</div>