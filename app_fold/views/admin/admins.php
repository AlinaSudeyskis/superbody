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
                        <div class="content_block_h_ref">
                            <a href="/administration/admin/new" class="add_tab_but">Добавить</a>
                            <a href="/administration/admin/new/users" class="add_tab_but">Выбрать</a>
                        </div>
                    </div>
                    <?php include_once('./app_fold/views/admin/users_submenu.php'); ?>
                </div>
                <div class="kurs_block_val">
                    <div class="admin_page">
                        <?php if (!empty($admins)) :
                            //print_r($admins);
                            foreach ($admins as $u) :
                                $user_type = 'admin';
                                $split_name = explode(' ', $u['user_name']);
                                $u['split_name']['name'] = (!empty($split_name[0])) ? $split_name[0] : '';
                                $u['split_name']['surname'] = (!empty($split_name[1])) ? $split_name[1] : '';
                                ?>
                                <?php include('./app_fold/views/user/users_item.php'); ?>
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
