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
                        <?php if(!empty($user_data)):?>
                            <form action="" method="post" enctype="multipart/form-data">
                                <div class="admin_form_buts_wrap_container">
                                    <div class="admin_form_buts_wrap parent">
                                        <?php if($user_data['user_restoring_account'] === false): ?>
                                            <input type="submit" name="bt_restore_user" class="video_admin_form_send" value="Восстановить"/>
                                        <?php endif; ?>
                                        <input type="submit" name="bt_delete_user" class="video_admin_form_block" value="Удалить"/>
                                    </div>
                                </div>
                                <?php if($user_data['user_restoring_account'] === true): ?>
                                    <h3 class="tip">Восстановление аккаунта ожидает подтверждение пользователем.</h3>
                                <?php endif; ?>
                                <?php if($user_data['user_deleted'] == 1): ?>
                                    <h3 class="info">Удаление: <?php echo $user_data['user_delete_date']; ?></h3>
                                <?php endif; ?>
                                <div class="video_admin_form">
                                    <div class="anketa_block_item_h">Настройки</div>
                                    <div class="anketa_form_line parent">
                                        <div class="anketa_form_h"><div class="anketa_form_h_cell">Польное имя:</div></div>
                                        <span class="anketa_form_in"><?php if (!empty($user_data['user_name'])) { echo $user_data['user_name']; } ?></span>
                                    </div>
                                    <div class="anketa_form_line parent">
                                        <div class="anketa_form_h"><div class="anketa_form_h_cell">Email:</div></div>
                                        <span class="anketa_form_in"><?php if (!empty($user_data['user_email'])) { echo $user_data['user_email']; } ?></span>
                                    </div>
                                    <?php if (!empty($user_data['user_image']) or !empty($user_data['user_soc_image'])) : ?>
                                        <div class="anketa_form_line parent">
                                            <div class="anketa_form_h"><div class="anketa_form_h_cell">Фото:</div></div>
                                            <?php if (!empty($user_data['user_image'])) : ?>
                                                <div class="tren_set_form_img settings_img">
                                                    <img src="<?php echo $user_data['user_image'];?>" alt="">
                                                </div>
                                            <?php endif;?>
                                            <?php if (!empty($user_data['user_soc_image'])) : ?>
                                                <div class="tren_set_form_img settings_img">
                                                    <img src="<?php echo $user_data['user_soc_image'];?>" alt="">
                                                </div>
                                            <?php endif;?>
                                        </div>
                                    <?php endif;?>
                                </div>

                                <div class="video_admin_form">
                                    <div class="anketa_block_item_h">Личные данные</div>
                                    <?php
                                    defined('BASEPATH') OR exit('No direct script access allowed');
                                    ?>
                                    <div class="anketa_form_line parent">
                                        <div class="anketa_form_h"><div class="anketa_form_h_cell">Пол:</div></div>
                                        <span class="anketa_form_in"><?php if(!empty($user_data['user_gender_rus'])){echo $user_data['user_gender_rus'];}?></span>
                                    </div>
                                    <div class="anketa_form_line parent">
                                        <div class="anketa_form_h"><div class="anketa_form_h_cell">Дата рождения:</div></div>
                                        <span class="anketa_form_in"><?php if(!empty($user_data['user_birthday'])){echo $user_data['user_birthday'];}?></span>
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

