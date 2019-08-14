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
                        <h3>Администраторы</h3>
                    <div class="content_block_h_ref"><a href="/administration/admin/new" class="add_tab_but">Добавить</a>
                    <a href="/administration/admin/new/users" class="add_tab_but">Выбрать</a>
                    </div></div>
                </div>
                <div class="kurs_block_val">
                    <?php include_once('./app_fold/views/admin/users_submenu.php'); ?>
                    <div class="admin_list">
                        <?php if (!empty($admins)) :
                            foreach ($admins as $admin) : ?>
                                <div class="admin_item parent">
                                    <?php if(!empty($admin['user_image'])): ?>
                                        <div class="admin_ava"><img src="<?php echo $admin['user_image']; ?>" alt=""></div>
                                    <?php endif; ?>
                                    <div class="admin_cont">
                                        <div class="admin_name">
                                            <?php $u_name = (!empty($admin['user_name'])) ? $admin['user_name'] : 'Пользователь №' . $admin['user_id']; ?>
                                            <a href="/profile/<?php echo $admin['user_id']; ?>"><?php echo $u_name; ?></a>
                                        </div>
                                        <div class="admin_set">
                                            <a href="/administration/admin/<?php echo $admin['user_id']; ?>">Редактировать</a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach;
                            unset($admin);
                        endif;?>
                    </div>
                    <?php include_once('./app_fold/views/pagination.php'); ?>
                </div>
            </div>
        </div><!-- content_col -->
    </div>
</div><!-- content -->
