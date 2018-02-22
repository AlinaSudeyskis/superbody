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
                <div class="content_block_h parent">
                    <h3>Информация о сайте</h3>
                    <a href="/administration/site/banner/new" class="add_tab_but">Добавить баннер</a>
                    <div class="content_block_h_buts">
                        <div class="content_block_h_slide kurs_slide"></div>
                        <div class="content_block_h_close"></div>
                    </div>
                </div>
                <div class="kurs_block_val">
                    <?php include_once('./app_fold/views/site/menu.php');?>
                    <div class="anketa_block">
                        <div class="anketa_block_cont">
                            <div class="anketa_block_item">
                                <div class="anketa_block_item_h"></div>
                                <div class="anketa_block_item_cont">
                                    <form action="" method="post" class="anketa_form site_info" enctype="multipart/form-data">
                                        <div class="anketa_form_line parent">
                                            <div class="anketa_form_h"><div class="anketa_form_h_cell">Файл баннера:</div></div>
                                            <div class="anketa_form_info_cont">
                                                <div style="width: 330px;">
                                                    <div class="video_down_line parent">
                                                        <div class="parent kurs_cur_wrap">
                                                            <div class="video_down_line_but_wrap">
                                                                <label for="video_down_line_but1cs" class="video_down_line_but">
                                                                    <input type="hidden" name="MAX_FILE_SIZE" value="2097152" />
                                                                    <input type="file" name="banner_file" class="admin_form_videofile" id="video_down_line_but1cs" accept="image/jpeg,image/png" />
                                                                    <span>Выберите файл</span>
                                                                </label>
                                                            </div>
                                                            <div class="video_down_line_name" style="width:45% !important;">Файл не выбран</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php if (!empty($banner['image'])) : ?>
                                            <div class="anketa_form_line parent">
                                                <div class="anketa_form_h"><div class="anketa_form_h_cell"></div></div>
                                                <div class="tren_set_form_img banner" id="settings_img">
                                                    <img src="<?php echo $banner['image'];?>" alt="">
                                                </div>
                                            </div>
                                        <?php endif;?>
                                        <div class="anketa_form_line parent">
                                            <div class="anketa_form_h"><div class="anketa_form_h_cell">Ссылка</div></div>
                                            <input type="text" class="anketa_form_in anketa_form_in_long" name="banner_url" value="<?php if (!empty($banner['url'])) { echo $banner['url']; }?>" maxlength="255"/>
                                        </div>

                                        <div class="anketa_form_buts_wrap parent">
                                            <input type="submit" name="bt_save_banner" value="Сохранить" class="admin_form_submit" />
                                            <?php if ($banner['blocked'] == 0) :?>
                                                <input type="submit" name="bt_block_banner" class="admin_form_block" value="Блокировать"/>
                                            <?php else :?>
                                                <input type="submit" name="bt_unblock_banner" class="admin_form_block" value="Разблокировать"/>
                                            <?php endif;?>
                                            <input type="submit" name="bt_delete_banner" class="admin_form_block" value="Удалить"/>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- content_col -->
    </div>
</div><!-- content -->
