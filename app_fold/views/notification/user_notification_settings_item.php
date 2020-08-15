<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="video_admin_form">
    <div class="parent kurs_cur_wrap">
        <div class="kurs_block_h">Текст уведомления:</div>
        <textarea name="ta_text" class="journal_form_textarea admin_form_txt_middle" required="required"><?php if(!empty($notification['text'])): echo $notification['text']; endif; ?></textarea>
    </div>
    <div class="parent kurs_cur_wrap">
        <div class="kurs_block_h">Дата:</div>
        <input type="date" name="i_date" value="<?php if(!empty($notification['date'])): echo $notification['date']; endif; ?>"/>
    </div>
    <div class="parent kurs_cur_wrap">
        <div class="kurs_block_h">Время:</div>
        <input type="text" name="i_time" value="<?php if(!empty($notification['time'])): echo $notification['time']; endif; ?>" class="anketa_form_in time" placeholder="чч:мм" maxlength="5" style="width:70px;text-align: center"/>
    </div>
    <div class="parent kurs_cur_wrap">
        <div class="kurs_block_h">Получатели:</div>
        <select name="s_users_group" class="journal_form_select" id="s-notif-users-group">
            <option value="all" <?php if(!empty($notification['users_group']) and $notification['users_group'] == 'all'):?>selected<?php endif;?>>Все пользователи</option>
            <option value="group" <?php if(!empty($notification['users_group']) and $notification['users_group'] == 'group'):?>selected<?php endif;?>>Выбранные пользователи</option>
        </select>
    </div>
    <div class="parent kurs_cur_wrap" id="notif-users-group-search" <?php if(empty($notification['users_group']) or $notification['users_group'] == 'all'):?>style="display: none;"<?php endif;?>>
        <div class="kurs_block_h"></div>
        <div class="add_tov_in_total anketa_form_in_long" style="margin-top: 10px; float: left;">
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
