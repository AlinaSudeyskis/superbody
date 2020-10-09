<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="busket_block_tab_item">
    <div class="busket_block_col">
        <div class="ordering_block_col_h">Наименование</div>
        <div class="ordering_block_col_cont parent">
            <?php if (!empty($product_item['image'])): ?>
                <div class="busket_block_col_img"><img src="<?php echo $product_item['image']; ?>" alt=""></div>
            <?php endif;?>
            <div class="busket_block_col_param" <?php if(empty($product_item['image'])):?>style="margin-left:0;"<?php endif;?>>
                <div class="ordering_block_col_name"><?php echo $product_item['name'];?></div>
            </div>
        </div>
    </div>
    <div class="busket_block_col">
        <div class="ordering_block_col_h">Цена</div>
        <div class="ordering_block_col_cont">
            <div class="ordering_block_col_val ordering_tov_price"><?php echo $price .' руб.';?></div>
        </div>
    </div>
    <div class="busket_block_col">
        <div class="ordering_block_col_h">Кол-во</div>
        <div class="ordering_block_col_cont tov_number">
            <?php if ($product_item['quantity'] > 0 and $product_item['course_id'] == 0) :?>
                <?php echo $product_item['cart_quantity']; ?>
            <?php else :
                $quantity = 1;
                echo 1;
            endif;?>
        </div>
    </div>
    <div class="busket_block_col">
        <div class="ordering_block_col_h">Итого</div>
        <div class="ordering_block_col_cont">
            <div class="ordering_block_col_val ordering_tov_summ">
                <?php $product_item_sum = $price * $product_item['cart_quantity'];
                    $product_item_currency = ' руб.'; ?>
                <span id="product_sum"><?php echo $product_item_sum;?></span>
                <span id="product_currency"><?php echo $product_item_currency;?></span>
            </div>
        </div>
    </div>
</div>