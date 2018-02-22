<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="content" class="container">
    <div class="row">
        <div class="col-lg-2 left_sidebar">
            <?php include_once('./app_fold/views/admin/admin_menu.php');?>
        </div><!-- left_sidebar -->
        <div class="col-lg-10 content_col">
            <div class="content_block">
                <div class="content_block_h new_content_block_h parent">
                    <h3>Товар</h3>
                    <a href="/administration/store/product/new" class="add_tab_but">Добавить</a>
                    <div class="content_block_h_buts">
                        <div class="content_block_h_slide kurs_slide"></div>
                        <div class="content_block_h_close"></div>
                    </div>
                </div>
                <div class="kurs_block_val tov">
                    <div class="admin_list tov_list">
                        <?php if (!empty($products)) :
                            foreach ($products as $product) :
                                $discount = (!empty($product['discount_price']) or !empty($product['discount_fc_price'])) ? 'Скидка' : '';
                                $bonus    = (!empty($product['attached']) or !empty($product['attached'])) ? 'Акция' : '';
                                $label    = (empty($bonus)) ? $discount: $bonus;
                                include('./app_fold/views/store/product/product_item.php');
                            endforeach;
                            unset($product);
                        endif;?>
                    </div>
                    <?php include('./app_fold/views/pagination.php');?>
                </div>
            </div>
        </div><!-- content_col -->
    </div>
</div><!-- content -->