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
                    <div class="content_block_h new_content_block_h parent">
                        <h3>Тренеры</h3>
                    <a href="/administration/coach/new" class="add_tab_but">Добавить</a>
                    <a href="/administration/coach/new/users" class="add_tab_but">Выбрать</a>
                    </div>
                </div>
                <div class="kurs_block_val">
                    <?php include_once('./app_fold/views/admin/users_submenu.php'); ?>
                    <div class="admin_list">
                        <?php if (!empty($coaches)) :
                            foreach ($coaches as $coach) : ?>
                                <div class="admin_item parent">
                                    <?php if(!empty($coach['image'])): ?>
                                        <div class="admin_ava"><img src="<?php echo $coach['image']; ?>" alt=""></div>
                                    <?php endif; ?>
                                    <div class="admin_cont">
                                        <div class="admin_name">
                                            <?php $u_name = (!empty($coach['f_name'])) ? $coach['f_name'] : 'Пользователь №' . $coach['id']; ?>
                                            <a href="/profile/<?php echo $coach['id']; ?>"><?php echo $u_name; ?></a>
                                        </div>
                                        <div class="admin_set">
                                            <a href="/administration/coach/<?php echo $coach['id']; ?>">Редактировать</a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach;
                            unset($coach);
                        endif;?>
                    </div>
                    <?php include_once('./app_fold/views/pagination.php'); ?>
                </div>
            </div>
        </div><!-- content_col -->
    </div>
</div><!-- content -->
