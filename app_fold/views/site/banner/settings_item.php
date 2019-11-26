<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="video_admin_form site_info">
    <div class="anketa_form_line parent">
        <div class="anketa_form_h">
            <div class="anketa_form_h_cell">Изображение баннера:</div>
            <div class="h_subtitle">(1920х350)</div>
        </div>
        <div class="video_down_line parent">
            <div class="parent kurs_cur_wrap">
                <div class="video_down_line_but_wrap">
                    <label for="video_down_line_but1cs" class="video_down_line_but">
                        <input type="hidden" name="MAX_FILE_SIZE" value="31457280" />
                        <input type="file" name="banner_file" class="admin_form_videofile" id="video_down_line_but1cs" accept="image/jpeg,image/png,image/gif" />
                        <span>Выберите файл</span>
                    </label>
                </div>
                <div class="video_down_line_name" style="width:45% !important;">Файл не выбран</div>
            </div>
        </div>
    </div>
    <?php if (!empty($banner['image'])) : ?>
        <div class="anketa_form_line parent">
            <div class="anketa_form_h"><div class="anketa_form_h_cell"></div></div>
            <div class="tren_set_form_img banner">
                <img src="<?php echo $banner['image'];?>" alt="">
            </div>
        </div>
    <?php endif;?>
    <div class="anketa_form_line parent">
        <div class="anketa_form_h">
            <div class="anketa_form_h_cell">Vimeo URL:</div>
            <div class="h_subtitle">(1920х350)</div>
        </div>
        <input type="text" name="banner_video_url" value="<?php if (!empty($banner['video_url'])) { echo $banner['video_url']; }?>" maxlength="255" class="anketa_form_in anketa_form_in_long"/>
    </div>
    <?php if (!empty($banner['video_url'])) : ?>
        <div class="anketa_form_line parent">
            <div class="anketa_form_h"><div class="anketa_form_h_cell"></div></div>
            <div class="tren_set_form_img banner">
                <?php $remove_url = $banner['video_url'];
                $key = 0;
                include('./app_fold/views/video/player/vimeo_player_item.php');?>
            </div>
        </div>
    <?php endif;?>
    <div class="anketa_form_line parent">
        <div class="anketa_form_h"><div class="anketa_form_h_cell">Ссылка</div></div>
        <input type="text" class="anketa_form_in anketa_form_in_long" name="banner_url" value="<?php if (!empty($banner['url'])) { echo $banner['url']; }?>" maxlength="255"/>
    </div>
</div>
