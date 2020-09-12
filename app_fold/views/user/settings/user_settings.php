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
                            <h3>Настройки пользователя</h3>
                        </div>
                        <?php include_once('./app_fold/views/admin/users_submenu.php'); ?>
                    </div>
                </div>
                <div class="kurs_block_val">
                    <div class="anketa_block_cont">
                        <?php $executive = true; ?>
                        <?php if(!empty($user_data) and !empty($page_2submenu) and ($page_2submenu == 'settings' or $page_2submenu == 'personal' or $page_2submenu == 'add_course')):?>
                            <?php if($page_2submenu == 'settings'):?>
                                <form action="" method="post" enctype="multipart/form-data">
                                    <div class="admin_form_buts_wrap_container">
                                        <div class="admin_form_buts_wrap parent">
                                            <input type="submit" name="bt_on_behalf_login" class="admin_form_reset" value="Авторизация"/>
                                            <?php if ($user_data['user_blocked'] == 0) :?>
                                                <input type="submit" name="bt_block_user" class="video_admin_form_block" value="Блокировать"/>
                                            <?php else :?>
                                                <input type="submit" name="bt_unblock_user" class="video_admin_form_block" value="Разблокировать"/>
                                            <?php endif;?>
                                            <input type="submit" name="bt_delete_user" class="video_admin_form_block" value="Удалить"/>
                                            <input type="submit" name="bt_reset_password" class="admin_form_reset" value="Сбос пароля"/>
                                            <input type="submit" name="bt_save_user_settings" class="video_admin_form_send defaultActionButton" value="Сохранить"  >
                                        </div>
                                    </div>
                                    <div class="video_admin_form">
                                        <div class="anketa_block_item_h">Настройки</div>
                                        <?php include_once('./app_fold/views/admin/user_settings_item.php'); ?>
                                    </div>
                                </form>
                            <?php elseif($page_2submenu == 'personal'):?>
                                <form action="" method="post">
                                    <div class="admin_form_buts_wrap_container">
                                        <div class="admin_form_buts_wrap parent">
                                            <input type="submit" name="bt_save_data" class="admin_form_submit defaultActionButton" value="Сохранить"  >
                                        </div>
                                    </div>
                                    <div class="video_admin_form">
                                        <div class="anketa_block_item_h">Личные данные</div>
                                        <?php include_once('./app_fold/views/user/settings/settings_bg_item.php'); ?>
                                    </div>
                                </form>
                            <?php elseif($page_2submenu == 'add_course'):?>
                                <form action="" method="post">
                                    <div class="video_admin_form">
                                        <div class="anketa_block_item_h">Покупка курса</div>
                                        <div class="purchase_pop-up_h purchase_form">
                                            <?php include_once('./app_fold/views/course/purchase_form.php');?>
                                        </div>
                                    </div>
                                </form>
                            <?php endif; ?>
                        <?php else: ?>
                            <h3 class="info">Информация не найдена</h3>
                        <?php endif; ?>
                    </div>
                </div>
            </div><!-- content_col -->
            <?php if(!empty($user_data) and !empty($page_2submenu) and ($page_2submenu == 'settings' or $page_2submenu == 'personal')):?>
                <?php include_once('./app_fold/views/user/outsider_profile_item.php'); ?>
            <?php endif; ?>
            <?php include_once('./app_fold/views/authorization/user_auth_data.php'); ?>
        </div>
    </div><!-- content -->
