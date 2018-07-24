<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<form action="" method="post" class="anketa_form" enctype="multipart/form-data">
    <div class="anketa_form_line parent">
        <div class="anketa_form_h"><div class="anketa_form_h_cell">Польное имя</div></div>
        <input type="text" class="anketa_form_in anketa_form_in_long" placeholder="Полное имя" name="name" value="<?php if (!empty($user_data['user_name'])) { echo $user_data['user_name']; }?>" maxlength="255"/>
    </div>
    <div class="anketa_form_line parent">
        <div class="anketa_form_h"><div class="anketa_form_h_cell">Email</div></div>
        <input type="text" class="anketa_form_in anketa_form_in_long valid_email" placeholder="Email" name="email" value="<?php if (!empty($user_data['user_email'])) { echo $user_data['user_email']; }?>" maxlength="255"/>
    </div>
    <div class="anketa_form_line parent">
        <div class="anketa_form_h"><div class="anketa_form_h_cell">Фото</div></div>
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
            <div class="tren_set_form_img" id="settings_img">
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

    <div class="admin_form_bats parent">
        <input type="submit" name="bt_save_user_settings" class="admin_form_submit" value="Сохранить">
        <input type="submit" name="bt_reset_password" class="admin_form_reset" value="Сбос пароля"/>
        <?php if ($user_blocked == 0) :?>
            <input type="submit" name="bt_block_user" class="admin_form_block" value="Блокировать"/>
        <?php else :?>
            <input type="submit" name="bt_unblock_user" class="admin_form_block" value="Разблокировать"/>
        <?php endif;?>
        <input type="submit" name="bt_delete_user" class="admin_form_block" value="Удалить"/>
    </div>
</form>