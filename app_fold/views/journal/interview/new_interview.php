<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<script>
    tinymce.init({
        selector: "textarea.formatted_textarea",
        menubar:false,
        theme: "modern",
        language_url : '/js/tinymce/langs/ru.js',
        plugins: "image link imagetools",
        toolbar: "undo redo | styleselect | fontselect fontsizeselect | bold italic | alignleft aligncenter alignright alignjustify | outdent indent | link image | forecolor",
        fontsize_formats: "8px 10px 12px 14px 18px 24px 36px 42px 50px"
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
                    <div class="input_value"><input type="text" name="name" value="" maxlength="255" required="required"/></div>
                </div>
                <div class="line">
                    <div class="input_name">Изображение:</div>
                    <div class="input_value"><input type="file" name="image" required="required"/></div>
                </div>
                <div class="line">
                    <div class="input_name">Краткое описание:</div>
                    <div class="input_value"><input type="text" name="short_desc" value="" maxlength="255" required="required"/></div>
                </div>
                <div class="line">
                    <div class="input_name">Полное описание:</div>
                </div>
                <textarea class="formatted_textarea" name="full_desc"></textarea>
                <div class="line">
                    <div class="input_name">Автор:</div>
                    <div class="input_value"><input type="text" name="author" value="" maxlength="255"/></div>
                </div>
                <div class="line">
                    <div class="input_name">Источник:</div>
                    <div class="input_value"><input type="text" name="source" value="" maxlength="255"/></div>
                </div>
                <p><input type="submit" name="bt_save_new_interview" value="Сохранить" id="defaultActionButton" /></p>
            </form>
        </div><!-- content_col -->
    </div>
</div><!-- content -->