<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="row user_prof_wrap">
    <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12 user_prof">
        <div class="content_block new_content_block">
            <div class="content_block_h parent">
                <h3>Профиль</h3>
                <div class="content_block_h_buts">
                    <div class="content_block_h_slide kurs_slide"></div>
                    <div class="content_block_h_close"></div>
                </div>
            </div>
            <div class="kurs_block_val">
                <div class="tren_prof_page_block parent">
                    <div class="tren_prof_page_img_wrap">
                        <div class="tren_prof_page_img" id="prof_page_img">
                            <?php if (!empty($user_data['image']) or !empty($user_data['user_image'])) :
                                $user_image = (!empty($user_data['image'])) ? $user_data['image'] : $user_data['user_image'] ; ?>
                                <img src="<?php echo $user_image;?>" alt="">
                            <?php else: ?>
                                <img src="/img/no_img.png" alt="">
                            <?php endif;?>
                        </div>
                        <div id="pop-up_user_photo">
                            <div class="close_user_photo"></div>
                            <form action="" method="post" enctype="multipart/form-data">
                                <div class="anketa_form_line parent">
                                    <div class="video_down_line parent">
                                        <div class="parent kurs_cur_wrap">
                                            <div class="video_down_line_but_wrap">
                                                <label for="video_down_line_but1cs" class="video_down_line_but">
                                                    <input type="hidden" name="MAX_FILE_SIZE" value="2097152">
                                                    <input type="file" name="avatar_file" class="admin_form_videofile" id="video_down_line_but1cs" accept="image/jpeg,image/png">
                                                    <span>Выберите файл</span>
                                                </label>
                                            </div>
                                            <div class="video_down_line_name">Файл не выбран</div>
                                        </div>
                                        <input type="submit" name="bt_save_avatar" value="Сохранить" class="video_admin_form_block defaultActionButton">
                                    </div>
                                </div>
                            </form>
                        </div><!-- pop-up_user_photo -->
                        <div class="tren_prof_page_name"><?php echo $user_data['split_name']['name'];?></div>
                        <div class="tren_prof_page_surname"><?php if (!empty($user_data['split_name']['surname'])) { echo $user_data['split_name']['surname']; }?></div>
                        <div class="tren_prof_page_soc">
                            <?php include_once('./app_fold/views/user/profile/user_soc.php'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content_block new_content_block">
            <div class="notification_block_h"><a href="/messages/<?php echo $user_data['user_id'];?>">Написать тренеру</a></div>
        </div>
    </div>
    <div class="col-lg-9 col-md-9 col-sm-8 col-xs-12 user_prog">
        <div class="content_block new_content_block">
            <div class="content_block_h parent">
                <h3>О тренере</h3>
                <div class="content_block_h_buts">
                    <div class="content_block_h_slide kurs_slide"></div>
                    <div class="content_block_h_close"></div>
                </div>
            </div>
            <div class="kurs_block_val">
                <div class="tren_prof_page_block parent">
                    <div class="tren_prof_page_cont">
                        <div class="tren_prof_page_stat"><?php if (!empty($user_data['user_specialization'])) { echo $user_data['user_specialization']; }?></div>
                        <div class="tren_prof_page_txt"><?php if (!empty($user_data['user_bbc_about'])) : echo $user_data['user_bbc_about']; else: echo 'Тренер еще не добавил информацию о себе'; endif; ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>