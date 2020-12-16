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
        toolbar: "undo redo | bold italic | forecolor",
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
            <div class="content_block new_content_block">
                <div class="content_block_container_wrap">
                    <div class="content_block_container">
                        <div class="content_block_h new_content_block_h parent">
                            <h3>Форма отправки письма пользователям</h3>
                            <?php include_once('./app_fold/views/email/email_menu_links.php'); ?>
                        </div>
                        <?php include_once('./app_fold/views/email/emails_menu.php');?>
                    </div>
                </div>
                <div class="kurs_block_val">
                    <div class="anketa_block_cont">
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="admin_form_buts_wrap_container">
                                <div class="admin_form_buts_wrap parent">
                                    <input type="submit" name="bt_send_emails" value="Отправить" class="video_admin_form_send defaultActionButton" />
                                </div>
                            </div>

                            <div class="anketa_form video_admin_form" style="padding: 0 0 30px;">
                                <div class="anketa_block_item_h"></div>
                                <div class="anketa_form_line parent kurs_cur_wrap">
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
                                <div class="anketa_form_line parent kurs_cur_wrap">
                                    <div class="anketa_form_h"><div class="anketa_form_h_cell">Получатель:</div></div>
                                    <select name="s_recipient" class="journal_form_select" id="select-email-recipient">
                                        <option value="all">Все пользователи</option>
                                        <option value="several">Выбранные пользователи</option>
                                    </select>
                                </div>
                                <div class="anketa_form_line parent" id="e-users-search" style="display: none;">
                                    <div class="anketa_form_h"><div class="anketa_form_h_cell"></div></div>
                                    <div class="add_tov_in_total" style="margin-left: 180px;">
                                        <div class="add_tov_in users">
                                            <input type="text" name="tren" class="admin_form_txt admin_form_txt_short" placeholder="Введите имя или ID пользователя">
                                            <div class="add_tov_list"></div>
                                        </div>
                                        <div class="add_tov_val"></div>
                                    </div>
                                </div>
                                <div class="anketa_form_line parent">
                                    <div class="anketa_form_h"><div class="anketa_form_h_cell">Тема:</div></div>
                                    <input type="text" name="email_subject" class="anketa_form_in anketa_form_in_long" value="" required="required"/>
                                </div>
                                <div class="anketa_form_line parent">
                                    <div class="anketa_form_h"><div class="anketa_form_h_cell">Текст:</div></div>
                                    <div class="journal_form_textarea_wrap journal_form_textarea_small" style="width:600px; margin-left:180px; margin-bottom: 0;">
                                        <textarea name="email_text" maxlength="2000" class="journal_form_textarea formatted_textarea"></textarea>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div><!-- content_col -->
    </div>
</div><!-- content -->