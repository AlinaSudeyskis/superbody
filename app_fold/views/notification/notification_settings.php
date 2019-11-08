<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
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
                            <h3>Редактировать уведомление</h3>
                        </div>
                    </div>
                </div>
                <div class="kurs_block_val">
                    <form action="" method="post">
                        <div class="admin_form_buts_wrap_container">
                            <div class="admin_form_buts_wrap parent">
                                <input type="submit" name="bt_save_notification" value="Сохранить" class="video_admin_form_send defaultActionButton" />
                            </div>
                        </div>
                        <div class="video_admin_form">
                            <?php if($notification['name'] != $notification['text']): ?>
                                <div class="parent kurs_cur_wrap">
                                    <div class="kurs_block_h">Исходное уведомление:</div>
                                    <div class="info"><?php echo $notification['name']; ?></div>
                                </div>
                            <?php endif; ?>
                            <div class="parent kurs_cur_wrap">
                                <div class="kurs_block_h">Тип уведомления:</div>
                                <select class="journal_form_select" name="s_type">
                                    <option value="error" <?php if($notification['type'] == 'error'): ?>selected="selected"<?php endif; ?>>Ошибка</option>
                                    <option value="info" <?php if($notification['type'] == 'info'): ?>selected="selected"<?php endif; ?>>Уведомление</option>
                                </select>
                            </div>
                            <div class="parent kurs_cur_wrap">
                                <div class="kurs_block_h">Текст уведомления:</div>
                                <textarea name="ta_description" class="journal_form_textarea admin_form_txt_middle" maxlength="255"><?php echo $notification['text']; ?></textarea>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- content_col -->
    </div>
</div><!-- content -->