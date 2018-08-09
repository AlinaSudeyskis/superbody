<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="content" class="container">
    <div class="row">
        <div class="col-lg-2 left_sidebar">
            <?php include_once('./app_fold/views/admin/admin_menu.php');?>
        </div><!-- left_sidebar -->
        <div class="col-lg-10 content_col">
            <div class="content_block new_content_block no_over">
                <div class="content_block_container_wrap">
                    <div class="content_block_container">
                        <div class="content_block_h new_content_block_h parent">
                            <h3>Настройки тренера</h3>
                        </div>
                        <?php include_once('./app_fold/views/admin/users_submenu.php'); ?>
                        <ul class="anketa_block_nav parent">
                            <li>
                                <a href="/administration/couch/<?php echo $user_data['user_id']; ?>">
                                    <span <?php if($page_2submenu == 'settings'): ?>class="anketa_active"<?php endif;?>>Настройки</span>
                                </a>
                            </li>
                            <li>
                                <a href="/administration/couch/<?php echo $user_data['user_id']; ?>/personal">
                                    <span <?php if($page_2submenu == 'personal_data'): ?>class="anketa_active"<?php endif;?>>Личные данные</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="kurs_block_val">
                    <div class="anketa_block_cont">
                        <?php if($page_2submenu == 'settings'): ?>
                            <form action="" method="post" enctype="multipart/form-data">
                                <div class="admin_form_buts_wrap_container">
                                    <div class="admin_form_buts_wrap parent">
                                        <input type="submit" name="bt_on_behalf_login" class="admin_form_reset" value="Авторизация"/>
                                        <?php if ($user_blocked == 0) :?>
                                            <input type="submit" name="bt_block_user" class="video_admin_form_block" value="Блокировать"/>
                                        <?php else :?>
                                            <input type="submit" name="bt_unblock_user" class="video_admin_form_block" value="Разблокировать"/>
                                        <?php endif;?>
                                        <input type="submit" name="bt_delete_user" class="video_admin_form_block" value="Удалить"/>
                                        <input type="submit" name="bt_reset_password" class="admin_form_reset" value="Сбос пароля"/>
                                        <input type="submit" name="bt_save_user_settings" class="video_admin_form_send" value="Сохранить">
                                    </div>
                                </div>

                                <div class="video_admin_form">
                                    <div class="anketa_block_item_h">Настройки</div>
                                    <?php include_once('./app_fold/views/admin/user_settings_item.php'); ?>
                                </div>
                            </form>
                        <?php elseif($page_2submenu == 'personal_data'): ?>
                            <form action="" method="post">
                                <div class="admin_form_buts_wrap_container">
                                    <div class="admin_form_buts_wrap parent">
                                        <input type="submit" name="bt_save_data" class="video_admin_form_send" value="Сохранить">
                                    </div>
                                </div>

                                <div class="video_admin_form">
                                    <div class="anketa_block_item_h">Личные данные</div>
                                    <?php include_once('./app_fold/views/user/settings/settings_bg_item.php'); ?>
                                    <?php include_once('./app_fold/views/couch/settings/couch_data_item.php'); ?>
                                </div>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div><!-- content_col -->
    </div>
</div><!-- content -->
