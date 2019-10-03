<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
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
                            <h3>Редактирование данных эл. адреса</h3>
                            <div class="content_block_h_ref"><a href="/administration/emails/addresses/new" class="add_tab_but">Добавить эл. адрес</a></div>
                        </div>
                        <?php include_once('./app_fold/views/email/emails_menu.php') ?>
                    </div>
                </div>
                <div class="kurs_block_val">
                    <?php if(!empty($address)): ?>
                        <form action="" method="post">
                            <div class="admin_form_buts_wrap_container">
                                <div class="admin_form_buts_wrap parent">
                                    <input type="submit" name="bt_save_address" value="Сохранить" id="defaultActionButton"  class="video_admin_form_send" />
                                </div>
                            </div>
                            <div class="video_admin_form">
                                <div class="parent kurs_cur_wrap">
                                    <div class="kurs_block_h">Наименование:</div>
                                    <input type="text" name="i_email_name" value="<?php echo $address['name']; ?>" maxlength="255" class="anketa_form_in anketa_form_in_long"/>
                                </div>
                                <div class="parent kurs_cur_wrap">
                                    <div class="kurs_block_h">Email:</div>
                                    <input type="text" name="email" value="<?php echo $address['email']; ?>" maxlength="255" class="anketa_form_in anketa_form_in_long valid_email"/>
                                </div>
                                <div class="parent kurs_cur_wrap">
                                    <div class="kurs_block_h"></div>
                                    <div class="tren_form_block_check_wrap">
                                        <input type="checkbox" name="cb_default" class="tren_form_block_check" id="default" <?php if($address['default'] == 1):?>checked="checked"<?php endif;?> value="1" />
                                        <label for="default">По умолчанию</label>
                                    </div>
                                </div>
                            </div>
                        </form>
                    <?php else: ?>
                        <h3 class="info">Информация не найдена</h3>
                    <?php endif; ?>
                </div>
            </div>
        </div><!-- content_col -->
    </div>
</div><!-- content -->