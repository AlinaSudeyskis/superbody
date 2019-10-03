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
                <div class="content_block_container_wrap">
                    <div class="content_block_container">
                        <div class="content_block_h new_content_block_h parent">
                            <h3>Редактировать тип курса</h3>
                        </div>
                    </div>
                </div>
                <div class="kurs_block_val">
                    <form action="" class="video_admin_form" method="post">
                        <div class="parent kurs_cur_wrap">
                            <div class="kurs_block_h">Наименование:</div>
                            <input type="text" name="name" class="admin_form_txt admin_form_txt_middle" value="<?php echo $type_name;?>" maxlength="255" required="required" />
                        </div>
                        <div class="video_admin_form_buts parent">
                            <input type="submit" name="bt_save_type_settings" value="Сохранить" id="defaultActionButton"  class="video_admin_form_send" />
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- content_col -->
    </div>
</div><!-- content -->
