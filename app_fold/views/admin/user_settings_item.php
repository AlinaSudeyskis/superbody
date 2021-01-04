<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="anketa_form_line parent">
    <div class="anketa_form_h"><div class="anketa_form_h_cell">Полное имя:</div></div>
    <input type="text" class="anketa_form_in anketa_form_in_long" placeholder="Полное имя" name="name" value="<?php if (!empty($user_data['user_name'])) { echo $user_data['user_name']; }?>" maxlength="255"/>
</div>
<div class="anketa_form_line parent">
    <div class="anketa_form_h"><div class="anketa_form_h_cell">Email:</div></div>
    <input type="text" class="anketa_form_in anketa_form_in_long valid_email" placeholder="Email" name="email" value="<?php if (!empty($user_data['user_email'])) { echo $user_data['user_email']; }?>" maxlength="255"/>
    <?php if($user_data['user_activated'] == 0): ?>
        <span class="tip">
            * Письмо с активацией отправлено на почту.
            <input type="submit" name="bt_e_activate_send_again" value="Отправить снова" class="bt_link">
            <input type="submit" name="bt_activate_account" value="Активировать аккаунт" class="bt_link">
        </span>
    <?php endif; ?>
    <?php if($user_data['user_changing_email'] === true): ?>
        <span class="tip">
            * Письмо с подтверждением изменения email отправлено на текущую почту.
            <input type="submit" name="bt_e_change_email_send_again" value="Отправить снова" class="bt_link">
        </span>
    <?php endif; ?>
</div>
<div class="anketa_form_line parent">
    <div class="anketa_form_h"><div class="anketa_form_h_cell">Фото:</div></div>
    <div class="video_down_line parent">
        <div class="video_down_line_but_wrap">
            <label for="video_down_line_but1cs" class="video_down_line_but">
                <input type="hidden" name="MAX_FILE_SIZE" value="2097152" />
                <input type="file" name="avatar_file" class="admin_form_videofile" id="video_down_line_but1cs" accept="image/jpeg,image/png">
                <span>Выберите файл</span>
            </label>
        </div>
        <div class="video_down_line_name">Файл не выбран</div>
    </div>
</div>
<?php if (!empty($user_data['user_image'])) : ?>
    <div class="anketa_form_line parent">
        <div class="anketa_form_h"><div class="anketa_form_h_cell"></div></div>
        <input type="submit" name="bt_delete_avatar" value="Удалить" class="full_photo_comm_reset settings"/>
        <div class="tren_set_form_img settings_img">
            <img src="<?php echo $user_data['user_image'];?>" alt="">
        </div>
    </div>
<?php endif;?>
<?php if (!empty($user_data['user_soc_image'])) : ?>
    <div class="anketa_form_line parent">
        <div class="anketa_form_h"><div class="anketa_form_h_cell"></div></div>
        <div class="tren_set_form_img" id="settings_img">
            <img src="<?php echo $user_data['user_soc_image'];?>" alt="">
        </div>
    </div>
<?php endif;?>
<div class="anketa_form_line parent">
    <div class="anketa_form_h"><div class="anketa_form_h_cell">Реклама:</div></div>
    <div style="font-size: 13px; line-height: 35px;">
        <?php if(empty($user_data['user_advertising']) or $user_data['user_advertising'] == 0): ?>
            Нет данных или у пользователя нет курсов
        <?php elseif(!empty($user_data['user_advertising']) and $user_data['user_advertising'] == 1): ?>
            Пользователь с наличием только бесплатных курсов
        <?php elseif(!empty($user_data['user_advertising']) and $user_data['user_advertising'] == 2): ?>
            Пользователь с наличием хотя бы одного оплаченного курса
        <?php elseif(!empty($user_data['user_advertising']) and $user_data['user_advertising'] == 3): ?>
            Пользователь с оплаченным премиум аккаунтом
        <?php elseif(!empty($user_data['user_advertising']) and $user_data['user_advertising'] == 4): ?>
            Пользователь с наличием пропущенной оплаты
        <?php endif; ?>
    </div>
</div>