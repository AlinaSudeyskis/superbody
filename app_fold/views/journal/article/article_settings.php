<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<script>
    tinymce.init({
        selector: "textarea.formatted_textarea",
        menubar:false,
        theme: "modern",
        language_url : '/js/tinymce/langs/ru.js',
        plugins: "image link imagetools bbcode",
        toolbar: "undo redo | fontsizeselect | bold italic | alignleft aligncenter alignright alignjustify | image | forecolor",
        fontsize_formats: "8px 10px 12px 14px 18px 24px 36px 42px 50px",
        contextmenu_never_use_native: true,
        contextmenu: "copy cut paste"
    });
</script>
<div id="content" class="container">
    <div class="row">
        <div class="col-lg-2 left_sidebar">
            <?php include_once('./app_fold/views/admin/admin_menu.php');?>
        </div><!-- left_sidebar -->
        <div class="col-lg-10 content_col">
            <form action="" method="post" enctype="multipart/form-data">
                <div class="line">
                    <div class="input_name">Наименование:</div>
                    <div class="input_value"><input type="text" name="name" value="<?php echo $article['name']?>" maxlength="255" required="required"/></div>
                </div>
                <div class="line">
                    <div class="input_name">Изображение:</div>
                    <div class="input_value"><input type="file" name="image" required="required"/></div>
                </div>
                <?php if (!empty($article['image'])):?>
                    <div class="line">
                        <div class="input_value"><img src="<?php echo $article['image'];?>"/></div>
                    </div>
                <?php endif;?>
                <div class="line">
                    <div class="input_name">Краткое описание:</div>
                    <div class="input_value"><input type="text" name="short_desc" value="<?php echo $article['short_desc']?>" maxlength="255" required="required"/></div>
                </div>
                <div class="line">
                    <div class="input_name">Полное описание:</div>
                </div>
                <textarea class="formatted_textarea" name="full_desc"><?php echo $article['full_desc']?></textarea>
                <div class="line">
                    <div class="input_name">Автор:</div>
                    <div class="input_value"><input type="text" name="author" value="<?php echo $article['author']?>" maxlength="255"/></div>
                </div>
                <div class="line">
                    <div class="input_name">Источник:</div>
                    <div class="input_value"><input type="text" name="source" value="<?php echo $article['source']?>" maxlength="255"/></div>
                </div>
                <div class="line">
                    <div class="input_name">Добавленно:</div>
                    <div class="input_value"><?php echo $article['date']?></div>
                </div>
                <p>
                    <input type="submit" name="bt_save_article" value="Сохранить" class="defaultActionButton' />
                    <?php if ($article['blocked'] == 0) : ?>
                        <input type="submit" name="bt_block_article" value="Заблокировать"/>
                    <?php else: ?>
                        <input type="submit" name="bt_unblock_article" value="Разблокировать"/>
                    <?php endif;?>
                </p>
            </form>
        </div><!-- content_col -->
    </div>
</div><!-- content -->
