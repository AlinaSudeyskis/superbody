<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<script>
    tinymce.init({
        selector: "textarea.formatted_textarea",
        height: 300,
        menubar:false,
        theme: "silver",
        language_url : '/js/tinymce/langs/ru.js',
        plugins: "bbcode",
        toolbar: "undo redo | bold italic | forecolor"
    });
</script>
<div id="content" class="container">
    <div class="row">
        <div class="col-lg-2 left_sidebar">
            <?php include_once('./app_fold/views/admin/admin_menu.php');?>
        </div><!-- left_sidebar -->
        <div class="col-lg-10 content_col">
            <div class="content_block new_content_block">
                <div class="content_block_container_wrap">
                    <div class="content_block_container">
                        <div class="content_block_h new_content_block_h parent">
                            <h3>Редактирование данных эл. письма</h3>
                            <div class="content_block_h_ref"><a href="/administration/emails/addresses/new" class="add_tab_but">Добавить эл. адрес</a></div>
                        </div>
                        <?php include_once('./app_fold/views/email/emails_menu.php');?>
                    </div>
                </div>
                <div class="kurs_block_val">
                    <div class="anketa_block_cont">
                        <?php if(!empty($email)): ?>
                            <form action="" method="post" enctype="multipart/form-data">
                                <div class="admin_form_buts_wrap_container">
                                    <div class="admin_form_buts_wrap parent">
                                        <a href="/administration/email_sample/<?php echo $email['id']; ?>" target="_blank" class="full_photo_comm_reset">Предварительный просмотр</a>
                                        <input type="submit" name="bt_save_email" value="Сохранить" id="defaultActionButton"  class="video_admin_form_send" />
                                    </div>
                                </div>

                                <div class="anketa_form video_admin_form" style="padding: 0 0 30px;">
                                    <div class="anketa_block_item_h"><?php echo $email['name']; ?></div>
                                    <div class="anketa_form_line parent kurs_cur_wrap" style="margin-bottom: 0;">
                                        <div class="anketa_form_h"><div class="anketa_form_h_cell">Отправитель:</div></div>
                                        <select name="s_email_address" class="journal_form_select">
                                            <?php if (!empty($addresses)) :
                                                foreach ($addresses as $address) :?>
                                                    <option value="<?php echo $address['id'];?>"
                                                        <?php if ((empty($email['ea_id']) and $address['default'] == 1) or (!empty($email['ea_id']) and $email['ea_id'] == $address['id'])) :?>
                                                            selected="selected"
                                                        <?php endif;?>
                                                    >
                                                        <?php echo  $address['name'] . ' [' . $address['email'] . ']'; ?>
                                                    </option>
                                                <?php endforeach;
                                                unset($address);
                                            endif;?>
                                        </select>
                                    </div>
                                    <div class="anketa_form_line parent">
                                        <div class="anketa_form_h"><div class="anketa_form_h_cell">Тема:</div></div>
                                        <input type="text" name="email_subject" class="anketa_form_in anketa_form_in_long" value="<?php echo $email['subject']; ?>" required="required"/>
                                    </div>
                                    <div class="anketa_form_line parent">
                                        <div class="anketa_form_h"><div class="anketa_form_h_cell">Текст:</div></div>
                                        <div class="journal_form_textarea_wrap journal_form_textarea_small" style="width:600px; margin-left:180px; margin-bottom: 0;">
                                            <textarea name="email_text" maxlength="2000" class="journal_form_textarea formatted_textarea"><?php echo $email['text']; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="anketa_form_line parent">
                                        <div class="anketa_form_h"><div class="anketa_form_h_cell">Изображение:</div></div>
                                        <div class="video_down_line parent">
                                            <div class="video_down_line_but_wrap">
                                                <label for="video_down_line_but1cs" class="video_down_line_but">
                                                    <input type="hidden" name="MAX_FILE_SIZE" value="2097152" />
                                                    <input type="file" name="email_image" class="admin_form_videofile" id="video_down_line_but1cs" accept="image/jpeg,image/png" />
                                                    <span>Выберите файл</span>
                                                </label>
                                            </div>
                                            <div class="video_down_line_name">Файл не выбран</div>
                                        </div>
                                    </div>
                                    <?php if(!empty($email['image'])): ?>
                                        <div class="anketa_form_line parent">
                                            <div class="anketa_form_h"><div class="anketa_form_h_cell"></div></div>
                                            <img src="<?php echo $email['image']; ?>" style="width:600px;"/>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </form>
                        <?php else: ?>
                            <h3 class="info">Информация не найдена</h3>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div><!-- content_col -->
    </div>
</div><!-- content -->