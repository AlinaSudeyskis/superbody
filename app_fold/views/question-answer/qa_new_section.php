<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="anketa_block">
    <div class="anketa_block_cont">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="admin_form_buts_wrap_container">
                <div class="admin_form_buts_wrap parent">
                    <input type="submit" name="bt_save_new_section" value="Сохранить" id="defaultActionButton"  class="video_admin_form_send" />
                </div>
            </div>
            <div class="video_admin_form">
                <div class="anketa_block_item_h">Новый раздел</div>
                <div class="anketa_form_line parent">
                    <div class="anketa_form_h"><div class="anketa_form_h_cell">Наименование:</div></div>
                    <input type="text" class="anketa_form_in anketa_form_in_long" name="section_name" value="" maxlength="255"/>
                </div>
            </div>
        </form>
    </div>
</div>