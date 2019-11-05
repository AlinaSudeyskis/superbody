<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php if(!empty($order)):?>
    <div class="ordering_block_cont">
        <div class="ordering_block_head parent">
            <div class="ordering_block_head_item ordering_block_head_item_active">
                <div class="ordering_block_head_name">Товары</div>
            </div>
        </div>
        <div class="ordering_block_info ordering_block_info3">
            <div class="ordering_block_tab">
                <?php $price_sum = 0;
                $fc_price_sum = 0;
                foreach ($order['products'] as $product):
                    $price = (!empty($product['price'])) ? $product['price'] : $product['rec_first'];
                    $product_sum = $price;
                    // Общая итоговая сумма корзины
                    if (!empty($product['price']) and $product['quantity'] > 0 and $product['course_id'] == 0) :
                        $product_sum = $price * $product['cart_quantity'];
                    endif;

                    $price_sum += $product_sum;

                    $product_item = $product;
                    include('./app_fold/views/store/cart/order_product_item.php');

                    // Прикрепленные товары
                    if (!empty($product['attached'])):?>

                        <div class="dop_tov_line parent">
                            <div class="dop_tov_line_h">Прикрепленные товары</div>
                        </div>

                        <?php foreach ($product['attached'] as $attached):
                            $price = !empty($attached['price']) ? $attached['price'] : $attached['rec_first'];
                            $product_sum = $price;
                            // Общая итоговая сумма корзины
                            if (!empty($attached['price']) and $attached['quantity'] > 0 and $attached['course_id'] == 0) :
                                $product_sum = $price * $attached['cart_quantity'];
                            endif;

                            $price_sum += $product_sum;

                            $product_item = $attached;
                            include('./app_fold/views/store/cart/order_product_item.php');

                        endforeach;
                        unset($attached);

                        // Разделитель окончания прикрепленных товаров?>
                        <div class="dop_tov_line"></div>
                    <?php endif;
                endforeach;
                unset($product);?>
            </div>
        </div>
    </div>
    <div class="ordering_block_side">
        <div class="ordering_block_side_head">Детали Заказа</div>
        <!--<div class="ordering_block_side_info">
            <div class="ordering_block_side_info_h_wrap parent">
                <div class="ordering_block_side_info_h">адрес и способ доставки</div>
            </div>
            <div class="ordering_block_side_cont">
                <div class="ordering_block_side_cont_h">адрес доставки</div>
                <div class="ordering_block_side_cont_txt">
                    <div class="ordering_block_side_cont_line">
                        <span class="info_ordering_t_name"><?php /*echo $order['user_surname']; */?></span>
                        <span class="info_ordering_name"><?php /*echo $order['user_name']; */?></span>
                        <span class="info_ordering_s_name"></span>
                    </div>
                    <div class="ordering_block_side_cont_line">
                        <span class="info_ordering_t_name"><?php /*echo $order['user_phone']; */?></span>
                    </div>
                    <div class="ordering_block_side_cont_line">
                        <span class="info_ordering_t_name"><?php /*echo $order['user_email']; */?></span>
                    </div>
                    <span class="info_ordering_street"><?php /*echo $order['street']; */?></span>
                    <span class="info_ordering_house"><?php /*echo $order['house']; */?></span>
                    <span class="info_ordering_building"><?php /*echo $order['building']; */?></span><br>
                    <span class="info_ordering_index"><?php /*echo $order['postcode']; */?></span>
                    <span class="info_ordering_city"><?php /*echo $order['city']; */?></span><br>
                    <span class="info_ordering_country"><?php /*echo $order['country']; */?></span>
                </div>
                <div class="ordering_block_side_cont_h">способ доставки</div>
                <div class="ordering_block_side_cont_txt">
                    <span class="info_ordering_type"><?php /*echo $order['delivery']; */?></span>
                </div>
            </div>
        </div>-->
        <!--<div class="ordering_block_side_info">
            <div class="ordering_block_side_info_h_wrap parent">
                <div class="ordering_block_side_info_h">Способ оплаты</div>
            </div>
            <div class="ordering_block_side_cont">
                <div class="ordering_block_side_cont_h info_ordering_pay"><?php /*echo $order['payment']; */?></div>
                <div class="ordering_block_side_cont_txt">Сумма: <span class="info_ordering_price"><?php /*echo sprintf("%.2f", $price_sum);*/?></span> pуб.</div>
            </div>
        </div>-->
        <!--<div class="ordering_block_side_info">
            <div class="ordering_block_side_info_h_wrap parent">
                <div class="ordering_block_side_info_h">Статус заказа</div>
            </div>
            <div class="ordering_block_side_cont">
                <div class="ordering_block_side_cont_h info_ordering_pay"><?php /*echo $order['status']; */?></div>
            </div>
        </div>-->
        <div class="ordering_block_side_info">
            <div class="ordering_block_side_info_h_wrap parent">
                <div class="ordering_block_side_info_h">Информация</div>
            </div>
            <div class="ordering_block_side_cont">
                <div class="ordering_block_side_cont_h info_ordering_pay">№ <?php echo $order['id']; ?></div>
                <div class="ordering_block_side_cont_txt">Дата заказа: <?php echo $order['date']; ?></div>
                <div class="ordering_block_side_cont_txt"><?php echo $order['user_email']; ?></div>
            </div>
        </div>
        <div class="ordering_block_side_info">
            <div class="ordering_block_side_info_h_wrap parent">
                <div class="ordering_block_side_info_h">Оплата</div>
            </div>
            <div class="ordering_block_side_cont">
                <?php if($order['payment_status_eng'] == 'free'): ?>
                    <div class="ordering_block_side_cont_h info_ordering_pay">Без оплаты</div>
                <?php endif; ?>
                <div class="ordering_block_side_cont_h info_ordering_pay">Сумма: <span class="info_ordering_price"><?php echo $order['total_amount']; ?></span> pуб.</div>
                <?php if(!empty($order['discount'])): ?>
                    <div class="ordering_block_side_cont_txt">Промокод: <span class="info_ordering_price"><?php echo $order['promocode']; ?></span></div>
                    <div class="ordering_block_side_cont_txt">Скидка: <span class="info_ordering_price"><?php echo $order['discount']; ?></span></div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php if(!empty($order['payments']) and $order['payment_status_eng'] != 'free'): ?>
        <div class="ordering_block_bottom">
            <div class="ordering_block_side_head">Данные о платеже</div>
            <?php foreach($order['payments'] as $payment): ?>
                <?php include('./app_fold/views/store/cart/order_payment_item.php');?>
            <?php endforeach;
            unset($payment); ?>
        </div>
    <?php endif;?>
<?php else: ?>
    <h3 class="info">Информация не найдена</h3>
<?php endif; ?>
