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
                            <h3>Пользователи</h3>
                        </div>
                        <?php include_once('./app_fold/views/admin/users_submenu.php'); ?>
                    </div>
                </div>
                <div class="kurs_block_val">
                    <div class="admin_list">
                        <?php if (!empty($users)):
                            foreach ($users as $u): ?>
                                <div class="admin_item parent">
                                    <?php if(!empty($u['user_image'])): ?>
                                        <div class="admin_ava"><img src="<?php echo $u['user_image']; ?>" alt=""></div>
                                    <?php elseif(!empty($u['user_soc_image'])): ?>
                                        <div class="admin_ava"><img src="<?php echo $u['user_soc_image']; ?>" alt=""></div>
                                    <?php endif; ?>
                                    <div class="admin_cont">
                                        <div class="admin_name">
                                            <?php $u_name = (!empty($u['user_name'])) ? $u['user_name'] : 'Пользователь №' . $u['user_id']; ?>
                                            <a href="/profile/<?php echo $u['user_id']; ?>"><?php echo $u_name; ?></a>
                                        </div>
                                        <div class="admin_set">
                                            <a href="/administration/user/<?php echo $u['user_id']; ?>">Редактировать</a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach;
                            unset($u);
                        endif; ?>
                    </div>
                    <?php include_once('./app_fold/views/pagination.php'); ?>
                </div>
            </div>
        </div><!-- content_col -->
    </div>
</div><!-- content -->
