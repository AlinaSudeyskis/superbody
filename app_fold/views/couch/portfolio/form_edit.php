<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="content" class="container">
    <div class="row">
        <div class="col-lg-2 left_sidebar">
            <?php include_once('./app_fold/views/couch/couch_menu.php');?>
        </div><!-- left_sidebar -->
        <div class="col-lg-10 content_col">
            <div class="content_block new_content_block">
                <div class="content_block_h parent">
                    <h3>Настройка портфолио</h3>
                    <div class="content_block_h_buts">
                        <div class="content_block_h_slide kurs_slide"></div>
                        <div class="content_block_h_close"></div>
                    </div>
                </div>
                <div class="kurs_block_val">
                    <form action="" class="tren_set_form" method="post" enctype="multipart/form-data">
                        <div class="parent">
                            <div class="tren_set_form_l">
                                <div class="tren_set_form_img"><img src="<?php echo $post['path'];?>" alt=""></div>
                                <div class="tren_set_form_add">
                                    <label for="tren_set_form_pop_up_upload">
                                        Выбрать фото
                                        <input type="hidden" name="MAX_FILE_SIZE" value="2097152" />
                                        <input type="file" name="portfolio_image" id="tren_set_form_pop_up_upload" class="tren_set_form_pop_up_upload" />
                                    </label>
                                </div>
                            </div>
                            <div class="tren_set_form_r">
                                <div class="tren_set_form_h">Название</div>
                                <input type="text" name="image_title" class="tren_set_form_in" placeholder="Введите название" value="<?php echo $post['title'];?>" />
                                <div class="tren_set_form_h">Описание</div>
                                <textarea name="image_description" class="tren_set_form_txt" placeholder="Введите описание"><?php echo $post['desc'];?></textarea>
                                <div class="tren_set_form_buts_wrap full_photo_comm_but_wrap parent">
                                    <input type="submit" name="bt_del_post" value="Удалить" class="full_photo_comm_reset" />
                                    <input type="submit" name="bt_save_image" value="Сохранить" class="full_photo_comm_but" />
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- content_col -->
    </div>
</div><!-- content -->