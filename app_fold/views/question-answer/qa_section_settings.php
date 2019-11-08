<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php if(!empty($section)): ?>
    <?php $disable = ($section['id'] == 1) ? 'disabled' : '';?>
    <div class="anketa_block">
        <div class="anketa_block_cont">
            <form action="" method="post" enctype="multipart/form-data">
                <div class="admin_form_buts_wrap_container">
                    <div class="admin_form_buts_wrap parent">
                        <?php if ($section['blocked'] == 0) :?>
                            <input type="submit" name="bt_block_section" class="video_admin_form_block" value="Блокировать"/>
                        <?php else :?>
                            <input type="submit" name="bt_unblock_section" class="video_admin_form_block" value="Разблокировать"/>
                        <?php endif;?>
                        <input type="submit" name="bt_save_section" value="Сохранить" class="video_admin_form_send defaultActionButton" <?php echo $disable; ?> />
                    </div>
                </div>
                <div class="video_admin_form">
                    <div class="anketa_block_item_h">Редактирование раздела</div>
                    <div class="anketa_form_line parent">
                        <div class="anketa_form_h"><div class="anketa_form_h_cell">Наименование:</div></div>
                        <input type="text" class="anketa_form_in anketa_form_in_long" name="section_name" value="<?php echo $section['name'] ?>" maxlength="255" <?php echo $disable; ?> />
                    </div>

                    <?php if(!empty($subsections)): ?>
                        <div class="anketa_block_item_h">Подразделы</div>
                        <div class="admin_list">
                            <?php foreach ($subsections as $subsection): ?>
                                <div class="admin_item parent">
                                    <div class="admin_cont">
                                        <div class="admin_name">
                                            <a href="/administration/question-answer/subsection/<?php echo $subsection['id']; ?>"><?php echo $subsection['name']; ?></a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach;
                            unset($subsection);?>
                        </div>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>
<?php else: ?>
    <h3 class="info">Информация не найдена</h3>
<?php endif; ?>