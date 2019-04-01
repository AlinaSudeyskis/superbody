<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<form action="" method="post" class="anketa_form" enctype="multipart/form-data">
    <div class="anketa_form_line parent">
        <div class="anketa_form_h"><div class="anketa_form_h_cell">Польное имя:</div></div>
        <input type="text" name="name" class="anketa_form_in anketa_form_in_long" placeholder="Полное имя" value="<?php if (!empty($user_data['user_name'])) { echo $user_data['user_name']; }?>" maxlength="255"/>
    </div>
    <div class="anketa_form_line parent">
        <div class="anketa_form_h"><div class="anketa_form_h_cell">Email:</div></div>
        <?php $activate = (empty($user_data['user_activated'])) ? 'disabled' : ''; ?>
        <input type="text" name="email" class="anketa_form_in anketa_form_in_long valid_email <?php echo $activate; ?>" placeholder="Email" value="<?php if (!empty($user_data['user_email'])) { echo $user_data['user_email']; }?>" maxlength="255" required="required" autocomplete="off"/>
        <?php if(!empty($activate)): ?>
            <span class="tip">* Активируйте email. Письмо с активацией отправлено Вам на почту (<input type="submit" name="bt_ne_activate_send_again" value="Отправить снова" class="bt_link">)</span>
        <?php endif; ?>
        <?php if($user_data['user_changing_email'] === true): ?>
            <span class="tip">* Письмо с подтверждением изменения email отправлено Вам на текущую почту (<input type="submit" name="bt_e_change_email_send_again" value="Отправить снова" class="bt_link">)</span>
        <?php endif; ?>
    </div>
    <?php if (!empty($user_session) and $user_session['auth_via'] == 'native') :?>
        <div class="anketa_form_line parent">
            <div class="anketa_form_h"><div class="anketa_form_h_cell">Пароль:</div></div>
            <div class="anketa_form_info_cont">
                <div class="">
                    <span class="anketa_form_info_txt">
                        <input type="password" name="old_password" class="anketa_form_in anketa_form_in_long pass" placeholder="Старый пароль" id="old-pass" value="" maxlength="255" minlength="8" autocomplete="off"/>
                    </span>
                </div>
                <div class="new_pass">
                    <span class="anketa_form_info_txt">
                        <input type="password" name="new_password" class="anketa_form_in anketa_form_in_long pass" placeholder="Новый пароль" id="new-pass" value="" maxlength="255" minlength="8" autocomplete="off"/>
                    </span>
                    <span class="anketa_form_info_txt">
                        <span id="pass-info" class="field_info"></span>
                    </span>
                </div>
                <div class="confirm_pass">
                    <span class="anketa_form_info_txt">
                        <input type="password" name="confirm_new_password" class="anketa_form_in anketa_form_in_long pass" placeholder="Подтвердите новый пароль" id="confirm-pass" value="" maxlength="255" minlength="8" autocomplete="off"/>
                    </span>
                    <span class="anketa_form_info_txt">
                        <span id="pass-info" class="field_info"></span>
                    </span>
                </div>
            </div>
        </div>
    <?php endif;?>
    <div class="anketa_form_line parent country_code">
        <div class="anketa_form_h"><div class="anketa_form_h_cell">Код страны:</div></div>
        <div class="anketa_form_one_wrap anketa_form_three_wrap">
            <?php include_once('./app_fold/views/user/settings/country_code.php'); ?>
        </div>
    </div>
    <div class="anketa_form_line parent">
        <div class="anketa_form_h"><div class="anketa_form_h_cell">Номер телефона:</div></div>
        <input type="text" name="phone" class="anketa_form_in anketa_form_in_long" placeholder="Телефон" value="<?php if (!empty($user_data['user_phone'])) { echo $user_data['user_phone']; }?>" maxlength="50"/>
    </div>
    <div class="anketa_form_line parent">
        <div class="anketa_form_h"><div class="anketa_form_h_cell">Фото:</div></div>
        <div class="video_down_line parent">
            <div class="parent kurs_cur_wrap">
                <div class="video_down_line_but_wrap">
                    <label for="video_down_line_but1cs" class="video_down_line_but">
                        <input type="hidden" name="MAX_FILE_SIZE" value="2097152" />
                        <input type="file" name="avatar_file" class="admin_form_videofile" id="video_down_line_but1cs" accept="image/jpeg,image/png" />
                        <span>Выберите файл</span>
                    </label>
                </div>
                <div class="video_down_line_name" style="width:45% !important;">Файл не выбран</div>
            </div>
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

    <div class="anketa_form_line parent">
        <div class="video_admin_form_buts parent">
            <input type="submit" name="bt_save_settings" value="Сохранить" class="video_admin_form_send">
            <input type="submit" name="bt_delete_account" value="Удалить аккаунт" class="video_admin_form_block">
        </div>
    </div>
</form>
