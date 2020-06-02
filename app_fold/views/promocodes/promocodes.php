<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="content" class="container">
    <div class="row">
        <div class="col-lg-2 left_sidebar">
            <?php include_once('./app_fold/views/admin/admin_menu.php');?>
        </div><!-- left_sidebar -->
        <div class="col-lg-10 content_col">
            <div class="content_block new_content_block ovv">
                <div class="content_block_container_wrap">
                    <div class="content_block_container">
                        <div class="content_block_h new_content_block_h parent">
                            <h3>Промокоды</h3>
                            <div class="content_block_h_ref"><a href="/administration/promocode/new" class="add_tab_but" short="">Доб. промокод</a></div>
                        </div>
                    </div>
                </div>
                <div class="kurs_block_val">
                    <ul class="anketa_block_nav parent">
                        <li>
                            <a href="/administration/promocodes">
                                <span <?php if ($page_submenu == 'promocodes') { echo 'class="anketa_active"'; } ?>>Промокоды сайта</span>
                            </a>
                        </li>
                        <li>
                            <a href="/administration/coaches/promocodes">
                                <span <?php if ($page_submenu == 'coach_promocodes') { echo 'class="anketa_active"'; } ?>>Промокоды тренеров</span>
                            </a>
                        </li>
                    </ul>
                    <div class="anketa_block_cont">
                        <?php if(!empty($promocodes)): ?>
                            <div class="admin_list">
                                <?php foreach ($promocodes as $code) : ?>
                                    <div class="admin_item promocodes">
                                        <a class="admin_feedback_link parent" href="/administration/promocode/<?php echo $code['id']; ?>">
                                            <span class="admin_feedback_cont parent">
                                                <?php $code_name = (!empty($code['group_name'])) ? $code['group_name'] : $code['code']; ?>
                                                <span class="admin_feedback_info parent"><?php echo $code_name; ?></span>
                                                <span class="admin_feedback_txt"><?php echo $code['discount'] .' '. $code['dt_unit']; ?></span>
                                                <span class="admin_feedback_txt" style="text-decoration: none;"><?php echo $code['name']; ?></span>
                                            </span>
                                            <span class="admin_feedback_time_wrap parent">
                                                <span class="admin_feedback_time"><?php echo $code['active_string']; ?></span>
                                            </span>
                                        </a>
                                    </div>
                                <?php endforeach;
                                unset($code);?>
                            </div>
                        <?php else: ?>
                            <h3 class="info">Информация не найдена</h3>
                        <?php endif;?>
                    </div>
                </div>
            </div>
        </div><!-- content_col -->
    </div>
</div><!-- content -->
