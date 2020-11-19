<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="content" class="container">
    <div class="row">
        <div class="col-lg-2 left_sidebar">
            <?php include_once('./app_fold/views/admin/admin_menu.php');?>
        </div><!-- left_sidebar -->
        <div class="col-lg-10 content_col">
            <div class="content_block new_content_block ovv">
                <div class="content_block_container_wrap">
                    <div class="content_block_container">
                        <div class="content_block_h new_content_block_h parent">
                            <h3>Блог тренера</h3>
                        </div>
                        <?php include_once('./app_fold/views/blog/menu.php'); ?>
                    </div>
                </div>
                <div class="kurs_block_val">
                    <form action="" method="post">
                        <div class="admin_form_buts_wrap_container">
                            <div class="admin_form_buts_wrap parent">
                                <input type="submit" name="bt_save_share" value="Сохранить" class="video_admin_form_send defaultActionButton" />
                            </div>
                        </div>
                        <div class="video_admin_form">
                            <h3 class="info small"><b>Пример кода "Поделиться в соцсетях":</b><br/><span style="font-style: italic;"> &lt;div class="ya-share2" data-curtain data-size="l" data-shape="round" data-services="collections,vkontakte,facebook,odnoklassniki,messenger"&gt;&lt;/div&gt;</span></h3>
                            <div class="video_admin_form site_info">
                                <div class="anketa_form_line parent">
                                    <div class="anketa_form_h"><div class="anketa_form_h_cell">До статьи:</div></div>
                                    <textarea name="ta_share_top" class="journal_form_textarea admin_form_txt_middle"><?php if (!empty($blog_share_top)) { echo $blog_share_top; }?></textarea>
                                </div>
                                <div class="anketa_form_line parent">
                                    <div class="anketa_form_h"><div class="anketa_form_h_cell">После статьи:</div></div>
                                    <textarea name="ta_share_bottom" class="journal_form_textarea admin_form_txt_middle"><?php if (!empty($blog_share_bottom)) { echo $blog_share_bottom; }?></textarea>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- content_col -->
    </div>
</div><!-- content -->
