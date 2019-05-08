<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php if(!empty($subsection)): ?>
    <div class="anketa_block">
        <div class="anketa_block_cont">
            <form action="" method="post" enctype="multipart/form-data">
                <div class="admin_form_buts_wrap_container">
                    <div class="admin_form_buts_wrap parent">
                        <?php if ($subsection['blocked'] == 0) :?>
                            <input type="submit" name="bt_block_subsection" class="video_admin_form_block" value="Блокировать"/>
                        <?php else :?>
                            <input type="submit" name="bt_unblock_subsection" class="video_admin_form_block" value="Разблокировать"/>
                        <?php endif;?>
                        <input type="submit" name="bt_save_subsection" value="Сохранить" class="video_admin_form_send" />
                    </div>
                </div>
                <div class="video_admin_form">
                    <div class="anketa_block_item_h">Редактирование подраздела</div>
                    <div class="anketa_form_line parent">
                        <div class="anketa_form_h"><div class="anketa_form_h_cell">Раздел:</div></div>
                        <div class="anketa_form_one_wrap anketa_form_three_wrap">
                            <?php $disabled = (empty($sections)) ? 'disabled' : ''; ?>
                            <select name="s_section" class="anketa_form_select" <?php echo $disabled; ?>>
                                <?php if(!empty($sections)): ?>
                                    <option value="">Выберите раздел</option>
                                    <?php foreach($sections as $section): ?>
                                        <option value="<?php echo $section['id']; ?>" <?php if($subsection['section_id'] == $section['id']): ?>selected="selected"<?php endif; ?>><?php echo $section['name']; ?></option>
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
                        <input type="text" class="anketa_form_in anketa_form_in_long" name="subsection_name" value="<?php echo $subsection['name']; ?>" maxlength="255"/>
                    </div>
                </div>
            </form>
        </div>
    </div>
<?php else: ?>
    <h3 class="info">Информация не найдена</h3>
<?php endif; ?>