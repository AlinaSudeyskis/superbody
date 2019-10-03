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
                            <h3>Редактирование страниц журнала</h3>
                        </div>
                    </div>
                </div>
                <div class="kurs_block_val">
                    <form action="" class="video_admin_form" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="post_id" value="<?php echo $post['id'];?>" id="post_id"/>
                        <select name="journal_cat" class="journal_form_select">
                            <option value="">Выберите категорию</option>
                            <option value="1" <?php if ($post['type'] == 1) :?>selected="selected"<?php endif;?>>Статьи (по умолчанию)</option>
                            <option value="2" <?php if ($post['type'] == 2) :?>selected="selected"<?php endif;?>>Интервью</option>
                            <option value="3" <?php if ($post['type'] == 3) :?>selected="selected"<?php endif;?>>Новости</option>
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
                        <div class="tov_form_img parent">
                            <?php if (!empty($post['images'])) :
                                foreach ($post['images'] as $key => $image) : ?>
                                    <div class="admin_form_foto_wrap h210">
                                        <div class="admin_form_foto">
                                            <img src="<?php echo $image;?>" alt="">
                                        </div>
                                        <div class="admin_form_buts parent">
                                            <!--<label for="admin_edit_file1" class="admin_edit_file">
                                                <input type="file" name="img1" class="admin_form_file" id="admin_edit_file1" />
                                            </label>-->
                                            <input type="hidden" name="img_path_<?php echo $key;?>" value=".<?php echo $image;?>" id="img_path"/>
                                            <input type="hidden" name="images[]" value=".<?php echo $image;?>"/>
                                            <input type="submit" name="bt_delete_img[]" id="journal_del_img" class="admin_form_del" value="Удалить" />
                                        </div>
                                        <div class="img_path"><?php echo $image;?></div>
                                    </div>
                                <?php endforeach;
                                unset($image);
                            endif;?>
                        </div>
                        <input type="text" name="name" class="admin_form_txt" placeholder="Наименование" maxlength="255" required="required" value="<?php echo $post['name'];?>" />
                        <input type="text" name="short_desc" class="admin_form_txt" placeholder="Краткое описание" maxlength="255" required="required" value="<?php echo $post['short_desc'];?>" />
                        <div class="journal_form_textarea_wrap">
                            <textarea id="area1" name="full_desc" class="formatted_textarea" placeholder="Текст страницы"><?php echo $post['full_desc'];?>"</textarea>
                        </div>
                        <input type="text" name="author" class="admin_form_txt" placeholder="Автор" maxlength="255" value="<?php echo $post['author'];?>" />
                        <input type="text" name="source" class="admin_form_txt" placeholder="Источник" maxlength="255" value="<?php echo $post['source'];?>" />
                        <div class="video_admin_form_buts parent">
                            <input type="submit" name="bt_save_post" value="Сохранить" id="defaultActionButton"  class="video_admin_form_send" />
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- content_col -->
    </div>
</div><!-- content -->
