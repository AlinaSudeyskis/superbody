<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<form action="" method="post">
    <div class="admin_form_buts_wrap_container">
        <div class="admin_form_buts_wrap parent">
            <input type="submit" name="bt_save_meta" value="Сохранить" class="video_admin_form_send defaultActionButton">
        </div>
    </div>
    <div class="video_admin_form site_info">
        <?php if(!empty($meta)): ?>
            <?php foreach($meta as $mt): ?>
                <div class="content_block new_content_block ovv content_block_internal metadata">
                    <div class="content_block_h parent">
                        <h3><?php echo $mt['page']; ?></h3>
                        <div class="content_block_h_buts">
                            <div class="content_block_h_slide meta_slide hide_chart"></div>
                        </div>
                    </div>
                    <div class="kurs_block_val">
                        <div class="anketa_block_cont">
                            <div class="parent kurs_cur_wrap">
                                <div class="kurs_block_h">Title:</div>
                                <textarea name="ta_meta_title[<?php echo $mt['id']; ?>]" class="journal_form_textarea admin_form_txt_middle" placeholder=""><?php echo $mt['title']; ?></textarea>
                            </div>
                            <?php if($mt['id'] > 1): ?>
                                <div class="parent kurs_cur_wrap">
                                    <div class="kurs_block_h">Keywords:</div>
                                    <textarea name="ta_meta_keywords[<?php echo $mt['id']; ?>]" class="journal_form_textarea admin_form_txt_middle" placeholder=""><?php echo $mt['keywords']; ?></textarea>
                                </div>
                                <div class="parent kurs_cur_wrap">
                                    <div class="kurs_block_h">Description:</div>
                                    <textarea name="ta_meta_description[<?php echo $mt['id']; ?>]" class="journal_form_textarea admin_form_txt_middle" placeholder=""><?php echo $mt['description']; ?></textarea>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach;
            unset($mt); ?>
        <?php endif; ?>
        <!--<div class="anketa_form_line parent">
            <div class="anketa_form_h"><div class="anketa_form_h_cell">Заголовок</div></div>
            <input type="text" class="anketa_form_in anketa_form_in_long" name="i_title" value="<?php /*if (!empty($index_title)) { echo $index_title; }*/?>" maxlength="40"/>
        </div>
        <div class="anketa_form_line parent">
            <div class="anketa_form_h"><div class="anketa_form_h_cell">Текст</div></div>
            <textarea name="i_text" class="journal_form_textarea admin_form_txt_middle" maxlength="300"><?php /*if (!empty($index_text)) { echo $index_text; }*/?></textarea>
        </div>-->
    </div>
</form>
