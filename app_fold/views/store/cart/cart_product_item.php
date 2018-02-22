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
            <div class="busket_block_col_param">
                <div class="ordering_block_col_name"><a href="/store/product/<?php echo $product_item['id'];?>"><?php echo $product_item['name'];?></a></div>
                <?php if (empty($product_item['attached_id'])): ?>
                    <div class="ordering_block_col_but">
                        <input type="submit" name="bt_delete_product[<?php echo $product_item['c_id']; ?>]" id="delete_product" value="Удалить товар"  class="busket_block_col_but"/>
                        <input type="hidden" name="product_id[]" value="<?php echo $product_item['c_id']; ?>" id="c_id"/>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="busket_block_col">
        <div class="ordering_block_col_h">Цена</div>
        <div class="ordering_block_col_cont">

            <div class="ordering_block_col_val ordering_tov_price">
                <?php if (!empty($product_item['price'])) :
                    $price = !empty($product_item['discount_price']) ? $product_item['discount_price'] : $product_item['price'];
                    if ($price != '0.00'):?>
                        <input type="radio" name="price[<?php echo $product_item['c_id'];?>]" value="<?php echo $price;?>" id="price_rub[<?php echo $product_item['c_id'];?>]" class="form_radio" checked="checked" />
                        <label for="price_rub[<?php echo $product_item['c_id'];?>]"><?php echo $price .' руб.';?></label>
                    <?php else:?>
                        <label>Бесплатно</label>
                    <?php endif;?>
                <?php endif;?>
                <input type="hidden" name="cp_id" value="<?php echo $product_item['c_id']; ?>" class="cp_id"/>
            </div>
        </div>
    </div>
    <div class="busket_block_col">
        <div class="ordering_block_col_h">Кол-во</div>
        <div class="ordering_block_col_cont">
            <?php if ($product_item['quantity'] > 0 and $product_item['course_id'] == 0) :
                $quantity = $product_item['quantity'];?>
                <input type="number" name="product_quantity[<?php echo $product_item['c_id'];?>]" class="tov_number" value="<?php echo $product_item['cart_quantity']; ?>" max="<?php echo $quantity; ?>" min="1"/>
                <input type="hidden" name="c_id" value="<?php echo $product_item['c_id']; ?>" id="c_id"/>
            <?php elseif ($product_item['course_id'] > 0) :
                $quantity = 1;?>
                <input type="hidden" name="course_quantity" value="1" />
                <input type="hidden" name="product_quantity[<?php echo $product_item['c_id'];?>]" value="1"/>
                <input type="hidden" class="tov_number" value="1"/>
                <div class="ordering_block_col_val">1</div>
            <?php else:
                $quantity = null;?>
                <div class="ordering_block_col_val">
                    Нет в наличии
                    <input type="hidden" name="product_quantity[]" value="<?php echo $product_item['cart_quantity']; ?>"/>
                    <input type="hidden" class="tov_number" value="0"/>
                </div>
            <?php endif;?>

            <!--<input type="number" name="tov_number" class="tov_number" value="1" min="1">-->
        </div>
    </div>
    <div class="busket_block_col">
        <div class="ordering_block_col_h">Итого</div>
        <div class="ordering_block_col_cont">
            <div class="ordering_block_col_val ordering_tov_summ">
                <?php if (!empty($product_item['price']) and $product_item['quantity'] > 0 and $product_item['course_id'] == 0) :
                    $product_item_sum = $price * $product_item['cart_quantity'];
                    $product_item_currency = ' руб.';
                    // Общая итоговая сумма корзины
                    $price_sum += $product_item_sum;
                elseif (!empty($product_item['price']) and $product_item['course_id'] > 0) :
                    $product_item_sum = $price;
                    $product_item_currency = ' руб.';
                    // Общая итоговая сумма корзины
                    $price_sum += $product_item_sum;
                else :
                    $product_item_sum = '';
                    $product_item_currency = '';
                endif;?>
                <span id="product_sum"><?php echo $product_item_sum;?></span>
                <span id="product_currency"><?php echo $product_item_currency;?></span>
            </div>
        </div>
    </div>
</div>
