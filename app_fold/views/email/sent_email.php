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
                            <h3>Отправленное письмо пользователям</h3>
                            <?php include_once('./app_fold/views/email/email_menu_links.php'); ?>
                        </div>
                        <?php include_once('./app_fold/views/email/emails_menu.php');?>
                    </div>
                </div>
                <div class="kurs_block_val">
                    <div class="anketa_block_cont">
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="anketa_form video_admin_form" style="padding: 0 0 30px;">
                                <div class="anketa_block_item_h"></div>
                                <div class="anketa_form_line parent kurs_cur_wrap">
                                    <div class="anketa_form_h"><div class="anketa_form_h_cell">Отправитель:</div></div>
                                    <span><?php echo $address['name'] . " [" . $address['email'] . "]"; ?></span>
                                </div>
                                <div class="anketa_form_line parent kurs_cur_wrap">
                                    <div class="anketa_form_h"><div class="anketa_form_h_cell">Получатель:</div></div>
                                    <span><?php if($sent_email['whom_type'] == 'all'): ?>Все пользователи (не удаленные, не отменившие подписку)
                                    <?php elseif($sent_email['whom_type'] == 'several'): ?>Выбранные пользователи
                                    <?php endif;?></span>
                                </div>
                                <div class="anketa_form_line parent kurs_cur_wrap">
                                    <div class="anketa_form_h"><div class="anketa_form_h_cell"></div></div>
                                    <?php if(!empty($sent_email['users'])): ?>
                                        <?php foreach ($sent_email['users'] as $user):?>
                                            <a href="/profile/<?php echo $user['id']; ?>"><?php if(!empty($user['name'])): echo $user['name']; else: echo $user['email']; endif; ?></a>
                                        <?php endforeach;
                                        unset($user); ?>
                                    <?php endif;?>
                                </div>
                                <div class="anketa_form_line parent">
                                    <div class="anketa_form_h"><div class="anketa_form_h_cell">Тема:</div></div>
                                    <span><?php echo $sent_email['subject']; ?></span>
                                </div>
                                <div class="anketa_form_line parent">
                                    <div class="anketa_form_h"><div class="anketa_form_h_cell">Текст:</div></div>
                                    <span><?php echo $sent_email['text']; ?></span>
                                </div>
                                <div class="anketa_form_line parent">
                                    <div class="anketa_form_h"><div class="anketa_form_h_cell">Дата:</div></div>
                                    <span><?php echo $sent_email['date']; ?></span>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div><!-- content_col -->
    </div>
</div><!-- content -->