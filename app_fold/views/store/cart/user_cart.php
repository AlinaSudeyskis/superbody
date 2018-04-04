<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include_once('./app_fold/views/store/category/categories_menu.php');?>
<div class="container"><h2 class="shop_block_title ordering_block_title">Корзина</h2></div>

<div id="content" class="container ordering_page">
    <?php $empty_cart = '';
    if (!empty($products)) :
        $empty_cart = 'empty_cart'?>
        <div class="busket_block_all">
            <div class="busket_block_wrap">
                <form action="" method="post">
                    <div class="busket_top_buts_wrap">
                        <a href="" class="busket_back_link disabled"><i class="fa fa-angle-left" aria-hidden="true"></i> Продолжить покупку</a>
                        <a href="/ordering" class="busket_bay_but">Оформить заказ</a>
                    </div>

                    <div class="busket_block_tab">
                        <?php $price_sum = 0;
                        $fc_price_sum = 0;
                        foreach ($products as $product) :

                            $product_item = $product;
                            // Блок товара
                            include('./app_fold/views/store/cart/cart_product_item.php');

                            // Прикрепленные товары
                            if (!empty($product['attached'])) :?>

                                <div class="dop_tov_line parent" id="dtlp_<?php echo $product['c_id']; ?>">
                                    <div class="dop_tov_line_h">Прикрепленные товары</div>
                                    <input type="submit" name="bt_detach_products[<?php echo $product['c_id']; ?>]" value="Открепить" class="dop_tov_line_but" id="detach_products" />
                                    <input type="hidden" name="product_id[]" value="<?php echo $product['c_id']; ?>" id="c_id"/>
                                </div>

                                <?php foreach ($product['attached'] as $attached) :

                                    $product_item = $attached;
                                    // Блок товара
                                    include('./app_fold/views/store/cart/cart_product_item.php');

                                endforeach;
                                unset($attached);

                                // Разделитель окончания прикрепленных товаров?>
                                <div class="dop_tov_line" id="dtl_<?php echo $product['c_id']; ?>"></div>

                            <?php endif;
                        endforeach;
                        unset($product);?>
                    </div>

                    <div class="busket_bottom_block">
                        <div class="busket_bottom_cont parent">
                            <div class="busket_bottom_cont_h">Итого</div>
                            <div class="busket_bottom_cont_val">
                                <span class="info_ordering_price"><?php echo money_format('%!.2n', $price_sum); ?></span>
                                <span id="info_ordering_currency"> руб.</span><br/>
                                <?php if (!empty($fc_price_sum)) :?>
                                    <span class="info_ordering_fc_price"><?php echo $fc_price_sum; ?></span>
                                    <span id="info_ordering_fc_currency"> FitCoin</span><br/>
                                <?php endif;?>
                            </div>
                        </div>
                        <a href="/ordering" class="busket_bottom_but">Оформить заказ</a>
                    </div>
                </form>
            </div>
        </div>
    <?php else:?>
        <div class="ordering_block_wrap <?php echo $empty_cart; ?>"><h2 class="shop_block_title">Корзина пуста</h2></div>
    <?php endif;?>
</div>