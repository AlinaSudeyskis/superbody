<?php $price_sum = 0;
$fc_price_sum = 0;
foreach ($products as $product):
    $price = !empty($product['discount_price']) ? $product['discount_price'] : $product['price'];
    $product_sum = $price;
    // Общая итоговая сумма корзины
    if (!empty($product['price']) and $product['quantity'] > 0 and $product['course_id'] == 0) :
        $product_sum = $price * $product['cart_quantity'];
        $price_sum += $product_sum;
    elseif (!empty($product['price']) and $product['course_id'] > 0) :
        $price_sum += $product_sum;
    endif;?>
    <div class="ordering_block_tov_item parent">
        <div class="ordering_block_tov_img"><img src="<?php echo $product['image']; ?>" alt=""></div>
        <div class="ordering_block_tov_cont">
            <div class="ordering_block_tov_name"><?php echo $product['name']; ?></div>
            <div class="ordering_block_tov_info">
                <div class="ordering_block_tov_info_line">Количество: <?php echo $product['cart_quantity']; ?> шт.</div>
                <div class="ordering_block_tov_info_line">Стоимость: <?php echo money_format('%!.2n', $product_sum); ?> руб.</div>
            </div>
        </div>
    </div>
    <?php if (!empty($product['attached'])):
        foreach ($product['attached'] as $attached):
            $price = !empty($attached['discount_price']) ? $attached['discount_price'] : $attached['price'];
            $product_sum = $price;
            // Общая итоговая сумма корзины
            if (!empty($product['price']) and $product['quantity'] > 0 and $product['course_id'] == 0) :
                $product_sum = $price * $attached['cart_quantity'];
                $price_sum += $product_sum;
            elseif (!empty($attached['price']) and $attached['course_id'] > 0) :
                $price_sum += $product_sum;
            endif;?>
            <div class="ordering_block_tov_item parent">
                <div class="ordering_block_tov_img"><img src="<?php echo $attached['image']; ?>" alt=""></div>
                <div class="ordering_block_tov_cont">
                    <div class="ordering_block_tov_name"><?php echo $attached['name']; ?></div>
                    <div class="ordering_block_tov_info">
                        <div class="ordering_block_tov_info_line">Количество: <?php echo $attached['cart_quantity']; ?> шт.</div>
                        <div class="ordering_block_tov_info_line">Стоимость: <?php echo money_format('%!.2n', $product_sum); ?> руб.</div>
                    </div>
                </div>
            </div>
        <?php endforeach;
        unset($attached);
    endif;
endforeach;
unset($product);?>