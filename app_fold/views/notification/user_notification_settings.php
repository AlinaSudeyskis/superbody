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
                        <div class="video_admin_form">
                            <div class="parent kurs_cur_wrap">
                                <div class="kurs_block_h">Текст уведомления:</div>
                                <textarea name="ta_text" class="journal_form_textarea admin_form_txt_middle" required="required"><?php echo $notification['text']; ?></textarea>
                            </div>
                            <div class="parent kurs_cur_wrap">
                                <div class="kurs_block_h">Дата:</div>
                                <input type="date" name="i_date" value="<?php echo $notification['date']; ?>"/>
                            </div>
                            <div class="parent kurs_cur_wrap">
                                <div class="kurs_block_h">Время:</div>
                                <input type="text" name="i_time" value="<?php echo $notification['time']; ?>" class="anketa_form_in time" placeholder="чч:мм" maxlength="5" style="width:70px;text-align: center"/>
                            </div>
                            <div class="parent kurs_cur_wrap">
                                <div class="kurs_block_h">Получатели:</div>
                                <select name="s_users_group" class="journal_form_select" id="s-notif-users-group">
                                    <option value="all" <?php if($notification['users_group'] == 'all'):?>selected<?php endif;?>>Все пользователи</option>
                                    <option value="group" <?php if($notification['users_group'] == 'group'):?>selected<?php endif;?>>Выбранные пользователи</option>
                                </select>
                            </div>
                            <div class="parent kurs_cur_wrap" id="notif-users-group-search" <?php if($notification['users_group'] == 'all'):?>style="display: none;"<?php endif;?>>
                                <div class="kurs_block_h"></div>
                                <div class="add_tov_in_total anketa_form_in_long" style="float: left;">
                                    <div class="add_tov_in pc_users">
                                        <input type="text" name="user_id" class="anketa_form_in anketa_form_in_long promocodes" placeholder="Введите ID пользователя" autocomplete="off">
                                        <div class="add_tov_list"></div>
                                    </div>
                                    <div class="add_tov_val">
                                        <?php if(!empty($notification['users'])): ?>
                                            <?php foreach($notification['users'] as $n_user) : ?>
                                                <div id="<?php echo $n_user['id']; ?>tov" class="add_tov_val_item pc_users parent">
                                                    <input type="hidden" name="users[]" value="<?php echo $n_user['id']; ?>">
                                                    <a href="/profile/<?php echo $n_user['id']; ?>" class="add_tov_val_cont parent">
                                                        <span class="add_tov_val_h"><?php if(!empty($n_user['name'])): echo $n_user['name']; elseif(!empty($n_user['email'])): echo $n_user['email']; else: echo 'Пользователь №'.$n_user['id']; endif;?></span>
                                                    </a>
                                                    <div class="del_tov"></div>
                                                </div>
                                            <?php endforeach;?>
                                        <?php endif;?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- content_col -->
    </div>
</div><!-- content -->