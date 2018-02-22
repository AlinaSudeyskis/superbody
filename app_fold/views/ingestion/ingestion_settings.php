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
                    <h3>Редактировать тип курса</h3>
                    <div class="content_block_h_buts">
                        <div class="content_block_h_slide kurs_slide"></div>
                        <div class="content_block_h_close"></div>
                    </div>
                </div>
                <div class="kurs_block_val">
                    <form action="" class="video_admin_form" method="post">
                        <input type="text" name="name" class="admin_form_txt" placeholder="Наименование" value="<?php echo $ing_name;?>" maxlength="255" required="required" />
                        <select name="s_ing_type" class="journal_form_select">
                            <?php if (!empty($types)) :
                                foreach ($types as $type) :?>
                                    <option value="<?php echo $type['id']; ?>"
                                        <?php if (!empty($ing_type_id) and $ing_type_id == $type['id']) : ?> selected="selected"<?php endif;?>
                                    ><?php echo $type['name']; ?></option>
                                <?php endforeach;
                                unset($type);
                            endif;?>
                        </select>
                        <select name="s_time_additives" class="journal_form_select">
                            <option value=""
                                <?php if (empty($before_after)) : ?> selected="selected"<?php endif;?>
                            >На протяжении дня</option>
                            <option value="before"
                                <?php if (!empty($before_after) and $before_after == 'before') : ?> selected="selected"<?php endif;?>
                            >До тренировки</option>
                            <option value="after"
                                <?php if (!empty($before_after) and $before_after == 'after') : ?> selected="selected"<?php endif;?>
                            >После тренировки тренировки</option>
                        </select>
                        <input type="text" name="time_additives" value="<?php if (!empty($time_additives)) { echo $time_additives; } ?>" id="time_additives" class="admin_form_txt admin_form_txt_short"/>
                        <div class="video_admin_form_buts parent">
                            <input type="submit" name="bt_save_ingestion_settings" value="Сохранить" class="video_admin_form_send" />
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- content_col -->
    </div>
</div><!-- content -->
