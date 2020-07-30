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
                            <h3>Добавление нового уведомления для пользователя</h3>
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
                            <div class="parent kurs_cur_wrap">
                                <div class="kurs_block_h">Текст уведомления:</div>
                                <textarea name="ta_text" class="journal_form_textarea admin_form_txt_middle" required="required"></textarea>
                            </div>
                            <div class="parent kurs_cur_wrap">
                                <div class="kurs_block_h">Дата:</div>
                                <input type="date" name="i_date"/>
                            </div>
                            <div class="parent kurs_cur_wrap">
                                <div class="kurs_block_h">Время:</div>
                                <input type="text" name="i_time" value="" class="anketa_form_in time" placeholder="чч:мм" maxlength="5" style="width:70px;text-align: center"/>
                            </div>
                            <div class="parent kurs_cur_wrap">
                                <div class="kurs_block_h">Получатели:</div>
                                <select name="s_users_group" class="journal_form_select" id="s-notif-users-group">
                                    <option value="all">Все пользователи</option>
                                    <option value="group">Выбранные пользователи</option>
                                </select>
                            </div>
                            <div class="parent kurs_cur_wrap" id="notif-users-group-search" style="display: none;">
                                <div class="kurs_block_h"></div>
                                <div class="add_tov_in_total anketa_form_in_long" style="float: left;">
                                    <div class="add_tov_in pc_users">
                                        <input type="text" name="user_id" class="anketa_form_in anketa_form_in_long promocodes" placeholder="Введите ID пользователя" autocomplete="off">
                                        <div class="add_tov_list"></div>
                                    </div>
                                    <div class="add_tov_val"></div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- content_col -->
    </div>
</div><!-- content -->