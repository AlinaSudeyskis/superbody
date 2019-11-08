<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="anketa_block">
    <div class="anketa_block_cont">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="admin_form_buts_wrap_container">
                <div class="admin_form_buts_wrap parent">
                    <input type="submit" name="bt_save_new_subsection" value="Сохранить" class="video_admin_form_send defaultActionButton" />
                </div>
            </div>
            <div class="video_admin_form">
                <div class="anketa_block_item_h">Новый подраздел</div>
                <div class="anketa_form_line parent">
                    <div class="anketa_form_h"><div class="anketa_form_h_cell">Раздел:</div></div>
                    <div class="anketa_form_one_wrap anketa_form_three_wrap">
                        <?php $disabled = (empty($sections)) ? 'disabled' : ''; ?>
                        <select name="s_section" class="anketa_form_select" <?php echo $disabled; ?>>
                            <?php if(!empty($sections)): ?>
                                <option value="">Выберите раздел</option>
                                <?php foreach($sections as $section): ?>
                                    <option value="<?php echo $section['id']; ?>"><?php echo $section['name']; ?></option>
                                <?php endforeach;
                                unset($section); ?>
                            <?php else: ?>
                                <option>Добавьте раздел</option>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>
                <div class="anketa_form_line parent">
                    <div class="anketa_form_h"><div class="anketa_form_h_cell">Наименование:</div></div>
                    <input type="text" class="anketa_form_in anketa_form_in_long" name="subsection_name" value="" maxlength="255"/>
                </div>
            </div>
        </form>
    </div>
</div>