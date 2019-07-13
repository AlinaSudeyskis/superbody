<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="content" class="container">
    <div class="row">
        <div class="col-lg-2 left_sidebar">
            <?php include_once('./app_fold/views/coach/coach_menu.php'); ?>
        </div><!-- left_sidebar -->
        <div class="col-lg-10 content_col">
            <div class="content_block new_content_block ovv">
                <div class="content_block_container_wrap">
                    <div class="content_block_container">
                        <div class="content_block_h new_content_block_h parent">
                            <h3>Промокоды</h3>
                            <a href="/profile/promocode/new" class="add_tab_but" short="">Доб. промокод</a>
                        </div>
                    </div>
                </div>
                <div class="kurs_block_val">
                    <div class="anketa_block_cont">
                        <?php if(!empty($promocodes)): ?>
                            <div class="admin_list">
                                <?php foreach ($promocodes as $code) : ?>
                                    <div class="admin_item emails">
                                        <a class="admin_feedback_link parent" href="/profile/promocode/<?php echo $code['id']; ?>">
                                            <span class="admin_feedback_time_wrap parent">
                                                <span class="admin_feedback_time"><?php echo $code['active_string']; ?></span>
                                                <span class="admin_feedback_date"></span>
                                            </span>
                                            <span class="admin_feedback_cont parent">
                                                <span class="admin_feedback_info parent">
                                                    <span class="admin_feedback_info_mail"><?php echo $code['code']; ?></span>
                                                </span>
                                                <span class="admin_feedback_txt"><?php echo $code['name']; ?></span>
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
