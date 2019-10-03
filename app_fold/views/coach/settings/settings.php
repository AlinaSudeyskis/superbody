<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="content" class="container">
    <div class="row">
        <div class="col-lg-2 left_sidebar">
            <?php include_once('./app_fold/views/coach/coach_menu.php');?>
        </div><!-- left_sidebar -->
        <div class="col-lg-10 content_col">
            <div class="content_block new_content_block no_over">
                <div class="content_block_h parent">
                    <h3>Настройки</h3>
                    <div class="content_block_h_buts">
                        <div class="content_block_h_slide kurs_slide"></div>
                        <div class="content_block_h_close"></div>
                    </div>
                </div>
                <div class="kurs_block_val">
                    <div class="anketa_block">
                        <ul class="anketa_block_nav parent">
                            <li><span class="anketa_active">Настройки</span></li>
                            <li><span>Личные данные</span></li>
                            <li><span>Соц. сети</span></li>
                        </ul>
                        <div class="anketa_block_cont">
                            <div class="anketa_block_item">
                                <div class="anketa_block_item_h">Настройки</div>
                                <div class="anketa_block_item_cont">
                                    <?php include_once('./app_fold/views/user/settings/settings_item.php');?>
                                </div>
                            </div>
                            <div class="anketa_block_item">
                                <div class="anketa_block_item_h">Личные данные</div>
                                <div class="anketa_block_item_cont">
                                    <form action="" class="anketa_form" method="post">
                                        <?php include_once('./app_fold/views/user/settings/settings_bg_item.php');?>
                                        <?php include_once('./app_fold/views/coach/settings/coach_data_item.php');?>
                                        <div class="anketa_form_line parent">
                                            <div class="anketa_form_h"><div class="anketa_form_h_cell"></div></div>
                                        </div>
                                        <div class="anketa_form_line parent">
                                            <div class="video_admin_form_buts parent">
                                                <input type="submit" name="bt_save_data" value="Сохранить" id="defaultActionButton"  class="video_admin_form_send">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="anketa_block_item">
                                <div class="anketa_block_item_h">Привязать соц. сети к аккаунту</div>
                                <?php include_once('./app_fold/views/user/settings/settings_soc_item.php');?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- content_col -->
    </div>
</div><!-- content -->
