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
                <div class="content_block_container_wrap">
                    <div class="content_block_container">
                        <div class="content_block_h new_content_block_h parent">
                            <?php $order_id = (!empty($order['id'])) ? '№'.$order['id'] : '';?>
                            <h3>Заказ <?php echo $order_id;?></h3>
                        </div>
                    </div>
                </div>
                <div class="ordering_block ordering_block3 parent admin">
                    <?php if(!empty($order)): ?>
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
                                    if(!empty($order['products'])):
                                        foreach ($order['products'] as $product):
                                            $price = !empty($product['discount_price']) ? $product['discount_price'] : $product['cart_products_price'];
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
                                                    $price = !empty($attached['discount_price']) ? $attached['discount_price'] : $attached['price'];
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
                                        unset($product);
                                    endif;?>
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
                                            <span class="info_ordering_t_name"><?php /*echo $order['o_user_surname']; */?></span>
                                            <span class="info_ordering_name"><?php /*echo $order['o_user_name']; */?></span>
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
                        <?php if(!empty($order['payments'])): ?>
                            <div class="ordering_block_bottom">
                                <div class="ordering_block_side_head">Данные о платеже</div>
                                <?php foreach($order['payments'] as $payment): ?>
                                    <div class="ordering_block_side_info">
                                        <div class="ordering_block_side_info_h_wrap parent">
                                            <div class="ordering_block_side_info_h">
                                                <?php if(!empty($payment['id'])):?>
                                                    ID: <?php echo $payment['id'];?>
                                                <?php elseif(!empty($payment['following_date'])): ?>
                                                    Предстоящий платеж <span>(<?php echo $payment['following_date']; ?>)</span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <div class="ordering_block_side_cont">
                                            <div class="ordering_block_side_cont_h info_ordering_pay"><?php echo $payment['payment_type']; ?></div>
                                            <div class="ordering_block_side_cont_txt">Сумма: <?php echo $payment['amount'] . ' ' . $payment['currency'];?></div>
                                            <?php if(!empty($payment['status'])): ?>
                                                <div class="ordering_block_side_cont_txt">Статус: <span class="<?php echo $payment['status_code']; ?>"><?php echo $payment['status'];?></span></div>
                                            <?php endif; ?>
                                            <?php if(!empty($payment['status'])): ?>
                                                <!--<div class="ordering_block_side_cont_txt">Оплата: <?php /*echo $payment['paid'];*/?></div>-->
                                            <?php endif; ?>
                                            <?php if(empty($payment['captured_at'])):
                                                if (!empty($payment['created_at'])): ?>
                                                    <div class="ordering_block_side_cont_txt">Создан: <?php echo $payment['created_at'];?></div>
                                                <?php endif;
                                                if (!empty($payment['expires_at'])): ?>
                                                    <div class="ordering_block_side_cont_txt">Истекает: <?php echo $payment['expires_at'];?></div>
                                                <?php endif;
                                            else:?>
                                                <div class="ordering_block_side_cont_txt">Подтвержден: <?php echo $payment['captured_at'];?></div>
                                            <?php endif;
                                            if ($payment['status_code'] == 'waiting_for_capture'):?>
                                                <form action="" class="edit_kurs_form" id="1kurs_form" method="post">
                                                    <div class="video_admin_form_buts parent">
                                                        <input type="hidden" name="i_payment_id" value="<?php echo $payment['id'];?>" />
                                                        <input type="submit" name="bt_capture" value="Подтвердить платеж" class="anketa_form_but" />
                                                        <input type="submit" name="bt_cancel" value="Отменить платеж" class="anketa_form_but red" />
                                                    </div>
                                                </form>
                                            <?php endif;?>
                                        </div>
                                        <?php if($payment['status_code'] == 'succeeded'):?>
                                            <?php $refund_info = 'Сумма возврата и остаток должны быть больше 1 рубля.';
                                            $passed_price = 0;
                                            if(!empty($courses)):
                                                foreach($courses as $course):
                                                    $passed_price += $course['passed_price'];?>
                                                    <div class="ordering_block_side_cont_txt"><?php echo $course['name'] . ' (выполнено тренировок): ' .$course['workouts_passed'];?></div>
                                                <?php endforeach;
                                                unset($course);
                                            endif;
                                            $amount = $payment['amount'] - $payment['refunds_amount'];
                                            $refund_amount  = number_format((($amount / 2) - $passed_price), 2, '.', '');
                                            $max_refund     = number_format(($amount - 1.01), 2, '.', '');

                                            if ($max_refund < 1.01 and $refund_amount < 1.01) :
                                                $refund_info = 'Возврат платежа не возможен. ' . $refund_info;
                                            endif;?>
                                            <?php if ($amount > 0) :?>
                                                <div class="ordering_block_side_info_h_wrap parent"></div>
                                                <div class="ordering_block_side_info_h_wrap parent">
                                                    <div class="ordering_block_side_info_h">
                                                        Возврат платежа
                                                        <div class="ordering_block_side_cont payment_info"><!--(<?php /*echo $refund_info; */?>)--></div>
                                                    </div>
                                                </div>
                                                <div class="ordering_block_side_cont">
                                                    <div class="ordering_block_side_cont_h info_ordering_pay"></div>
                                                    <div class="ordering_block_side_cont_txt">*Сумма частичного возврата и остаток должны быть больше 1 рубля.</div>
                                                    <div class="ordering_block_side_cont_h info_ordering_pay"></div>
                                                    <form action="" class="edit_kurs_form" id="1kurs_form" method="post">
                                                        <div class="anketa_block_item_cont">
                                                            <?php if(!empty($courses)):
                                                                foreach($courses as $course):?>
                                                                    <div class="ordering_block_side_cont_txt"><?php echo $course['name'] . ' (выполнено тренировок): ' .$course['workouts_passed'];?></div>
                                                                <?php endforeach;
                                                                unset($course);
                                                            endif;
                                                            $current_refund = ($refund_amount < 1.01) ? 1.01 : $refund_amount;?>
                                                            <input type="hidden" name="i_payment_id" value="<?php echo $payment['id'];?>" />
                                                            <div class="parent kurs_cur_wrap">
                                                                <!--min="1.01" max="<?php /*echo $max_refund; */?>" value="<?php /*echo $current_refund; */?>"-->
                                                                <input type="number" name="i_refund_amount" class="admin_form_txt admin_form_txt_short" step="0.01"
                                                                       min="0" max="<?php echo $amount; ?>" placeholder="Сумма возврата" required="required"/>
                                                                <div class="kurs_cur">Руб.</div>
                                                            </div>
                                                            <input type="text" name="i_description" class="admin_form_txt admin_form_txt_short" value="" placeholder="Причина возврата" />
                                                            <div class="video_admin_form_buts parent">
                                                                <input type="submit" name="bt_refund" value="Вернуть платеж" class="anketa_form_but" />
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            <?php endif;
                                        endif;
                                        if(!empty($payment['refunds'])):?>
                                            <div class="ordering_block_side_info_h_wrap parent"></div>
                                            <div class="ordering_block_side_info_h_wrap parent">
                                                <div class="ordering_block_side_info_h">Возвраты</div>
                                            </div>
                                            <div class="ordering_block_side_cont">
                                                <div class="ordering_block_bottom">
                                                    <?php foreach($payment['refunds'] as $refund): ?>
                                                        <?php include('./app_fold/views/store/cart/order_refund_item.php'); ?>
                                                    <?php endforeach;
                                                    unset($refund);?>
                                                </div>
                                            </div>
                                        <?php endif;?>
                                    </div>
                                <?php endforeach;
                                unset($payment);?>
                            </div>
                        <?php endif;?>
                    <?php else: ?>
                        <h3 class="info">Информация не найдена</h3>
                    <?php endif;?>
                </div>
            </div>
        </div>
    </div>
</div>