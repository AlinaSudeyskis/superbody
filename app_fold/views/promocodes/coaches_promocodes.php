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
                        <?php if(!empty($coaches)): ?>
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
                                                    <a href="/administration/coach/promocodes/<?php echo $coach['id']; ?>"><?php echo $u_name; ?></a>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach;
                                    unset($coach);
                                endif;?>
                            </div>
                            <?php include_once('./app_fold/views/pagination.php'); ?>
                        <?php else: ?>
                            <h3 class="info">Информация не найдена</h3>
                        <?php endif;?>
                    </div>
                </div>
            </div>
        </div><!-- content_col -->
    </div>
</div><!-- content -->
