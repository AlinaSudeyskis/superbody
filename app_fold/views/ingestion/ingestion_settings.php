<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="content" class="container">
    <div class="row">
        <div class="col-lg-2 left_sidebar">
            <?php include_once('./app_fold/views/admin/admin_menu.php');?>
        </div><!-- left_sidebar -->
        <div class="col-lg-10 content_col">
            <div class="content_block new_content_block">
                <div class="content_block_h new_content_block_h parent">
                    <h3>Курсы питания</h3>
                    <?php include_once('./app_fold/views/course/nutritions/courses_buts.php'); ?>
                    <div class="content_block_h_buts">
                        <div class="content_block_h_slide kurs_slide"></div>
                        <div class="content_block_h_close"></div>
                    </div>
                </div>
                <div class="kurs_block_val">
                    <?php include_once('./app_fold/views/course/nutritions/menu.php');?>
                    <div class="anketa_block_cont">
                        <div class="anketa_block_item">
                            <?php if(!empty($ingestion)):?>
                                <div class="anketa_block_item_h">Редактирование данных приема пищи</div>
                                <div class="anketa_block_item_cont">
                                    <form action="" class="anketa_form" method="post">
                                        <?php include_once('./app_fold/views/ingestion/settings_item.php'); ?>
                                        <div class="anketa_form_buts_wrap parent">
                                            <input type="submit" name="bt_save_ingestion_settings" value="Сохранить" class="video_admin_form_send" />
                                            <?php if ($ingestion['blocked'] == 0) :?>
                                                <input type="submit" name="bt_block_ingestion" value="Блокировать" class="video_admin_form_block"/>
                                            <?php elseif ($ingestion['blocked'] == 1) :?>
                                                <input type="submit" name="bt_unblock_ingestion" value="Разблокировать" class="video_admin_form_block"/>
                                            <?php endif;?>
                                        </div>
                                    </form>
                                </div>
                            <?php else: ?>
                                <h3 class="info">Информация не найдена</h3>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- content_col -->
    </div>
</div><!-- content -->
