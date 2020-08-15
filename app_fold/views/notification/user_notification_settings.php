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
                            <h3>Редактирование уведомления для пользователя</h3>
                            <?php if ($page_submenu == 'notif_users'): ?>
                                <div class="content_block_h_ref">
                                    <a href="/administration/notification/users/new" class="add_tab_but">Добавить уведомление</a>
                                </div>
                            <?php endif; ?>
                        </div>
                        <ul class="anketa_block_nav parent">
                            <li>
                                <a href="/administration/notifications/users">
                                    <span <?php if ($page_submenu == 'notif_users'): ?> class="anketa_active" <?php endif;?>>Для пользователей</span>
                                </a>
                            </li>
                            <li>
                                <a href="/administration/notifications/system">
                                    <span <?php if ($page_submenu == 'notif_system'): ?> class="anketa_active" <?php endif;?>>Системные</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="kurs_block_val">
                    <form action="" method="post">
                        <div class="admin_form_buts_wrap_container">
                            <div class="admin_form_buts_wrap parent">
                                <input type="submit" name="bt_save_user_notification" value="Сохранить" class="video_admin_form_send defaultActionButton" />
                            </div>
                        </div>
                        <?php include_once('./app_fold/views/notification/user_notification_settings_item.php'); ?>
                    </form>
                </div>
            </div>
        </div><!-- content_col -->
    </div>
</div><!-- content -->