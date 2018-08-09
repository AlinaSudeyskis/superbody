<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<form action="" method="post" enctype="multipart/form-data">
    <div class="admin_form_buts_wrap_container">
        <div class="admin_form_buts_wrap parent">
            <input type="submit" name="bt_attach_new_course" value="Сохранить" class="video_admin_form_send">
        </div>
    </div>
    <div class="video_admin_form">
        <?php if(!empty($attach_courses)):?>
            <div class="parent kurs_cur_wrap">
                <div class="kurs_block_h">Курс:</div>
                <select name="s_attach_course" class="journal_form_select">
                    <?php foreach($attach_courses as $ac): ?>
                        <option value="<?php echo $ac['id']; ?>"><?php echo $ac['name']; ?></option>
                    <?php endforeach;
                    unset($ac);?>
                </select>
            </div>
        <?php endif;?>
    </div>
</form>