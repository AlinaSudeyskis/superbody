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
        fontsize_formats: "8px 10px 12px 14px 18px 24px 36px 42px 50px"
    });
</script>
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
                            <h3>Добавление страниц журнала</h3>
                        </div>
                    </div>
                </div>
                <div class="kurs_block_val">
                    <form action="" class="video_admin_form" method="post" enctype="multipart/form-data">
                        <select name="journal_cat" class="journal_form_select">
                            <option value="">Выберите категорию</option>
                            <option value="1">Статьи (по умолчанию)</option>
                            <option value="2">Интервью</option>
                            <option value="3">Новости</option>
                        </select>
                        <div class="video_down_line parent">
                            <div class="video_down_line_h">Изображение:</div>
                            <div class="video_down_line_but_wrap">
                                <label for="journal_images" class="video_down_line_but">
                                    <input type="file" name="journal_images[]" multiple="multiple" class="admin_form_videofile" id="journal_images" accept="image/jpeg,image/png" />
                                    <span>Выберите файл</span>
                                </label>
                            </div>
                            <div class="video_down_line_name">Файл не выбран</div>
                            <div class="progressbar_wrap">
                                <progress class="progressbar" id="journal_progressbar" value="0" max="100"></progress>
                            </div>
                        </div>
                        <div class="tov_form_img parent"></div>
                        <input type="text" name="name" class="admin_form_txt" placeholder="Наименование" maxlength="255" required="required" />
                        <input type="text" name="short_desc" class="admin_form_txt" placeholder="Краткое описание" maxlength="255" required="required" />
                        <div class="journal_form_textarea_wrap">
                            <textarea id="area1" name="full_desc" class="formatted_textarea" placeholder="Текст страницы"></textarea>
                        </div>
                        <input type="text" name="author" class="admin_form_txt" placeholder="Автор" maxlength="255" />
                        <input type="text" name="source" class="admin_form_txt" placeholder="Источник" maxlength="255" />
                        <div class="video_admin_form_buts parent">
                            <input type="submit" name="bt_save_new_post" value="Сохранить" id="defaultActionButton"  class="video_admin_form_send" />
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- content_col -->
    </div>
</div><!-- content -->
