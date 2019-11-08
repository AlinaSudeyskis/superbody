<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="content" class="container">
    <div class="row">
        <div class="col-lg-2 left_sidebar">
            <?php include_once('./app_fold/views/admin/admin_menu.php');?>
        </div><!-- left_sidebar -->
        <div class="col-lg-10 content_col">
            <div class="content_block new_content_block">
                <div class="content_block_container_wrap">
                    <div class="content_block_container">
                        <div class="content_block_h new_content_block_h parent">
                            <h3>Курсы питания</h3>
                            <div class="content_block_h_ref"><a href="/administration/meals/type/new" class="add_tab_but">Новый тип блюда</a></div>
                        </div>
                        <?php include_once('./app_fold/views/course/nutritions/menu.php'); ?>
                    </div>
                </div>
                <div class="kurs_block_val">
                    <div class="anketa_block_cont">
                        <div class="anketa_block_item">
                            <?php if(!empty($meals_type)):?>
                                <div class="anketa_block_item_h">Редактирование данных типа блюда</div>
                                <div class="anketa_block_item_cont">
                                    <form action="" class="anketa_form" method="post">
                                        <div class="anketa_form_line parent">
                                            <div class="anketa_form_h"><div class="anketa_form_h_cell">Наименование:</div></div>
                                            <input type="text" name="i_name" value="<?php echo $meals_type['name']; ?>" class="anketa_form_in anketa_form_in_long" maxlength="255" />
                                        </div>

                                        <div class="anketa_form_buts_wrap parent">
                                            <input type="submit" name="bt_save_meals_type" value="Сохранить" class="video_admin_form_send defaultActionButton" />
                                            <?php if ($meals_type['blocked'] == 0) :?>
                                                <input type="submit" name="bt_block_meals_type" value="Блокировать" class="video_admin_form_block"/>
                                            <?php elseif ($meals_type['blocked'] == 1) :?>
                                                <input type="submit" name="bt_unblock_meals_type" value="Разблокировать" class="video_admin_form_block"/>
                                            <?php endif;?>
                                        </div>
                                    </form>
                                </div>
                            <?php else: ?>
                                <h3 class="info">Информация не найдена</h3>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- content_col -->
    </div>
</div><!-- content -->
