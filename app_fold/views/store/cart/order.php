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
                    <h3>Заказ №<?php echo $order['id'];?></h3>
                    <div class="content_block_h_buts">
                        <div class="content_block_h_slide kurs_slide"></div>
                        <div class="content_block_h_close"></div>
                    </div>
                </div>
                <div class="ordering_block ordering_block3 parent admin">
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
                                    $price = !empty($product['discount_price']) ? $product['discount_price'] : $product['price'];
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
                                unset($product);?>
                            </div>
                        </div>
                    </div>
                    <div class="ordering_block_side">
                        <div class="ordering_block_side_head">Детали Заказа</div>
                        <div class="ordering_block_side_info">
                            <div class="ordering_block_side_info_h_wrap parent">
                                <div class="ordering_block_side_info_h">адрес и способ доставки</div>
                            </div>
                            <div class="ordering_block_side_cont">
                                <div class="ordering_block_side_cont_h">адрес доставки</div>
                                <div class="ordering_block_side_cont_txt">
                                    <div class="ordering_block_side_cont_line">
                                        <span class="info_ordering_t_name"><?php echo $order['user_surname']; ?></span>
                                        <span class="info_ordering_name"><?php echo $order['user_name']; ?></span>
                                        <span class="info_ordering_s_name"></span>
                                    </div>
                                    <div class="ordering_block_side_cont_line">
                                        <span class="info_ordering_t_name"><?php echo $order['user_phone']; ?></span>
                                    </div>
                                    <div class="ordering_block_side_cont_line">
                                        <span class="info_ordering_t_name"><?php echo $order['user_email']; ?></span>
                                    </div>
                                    <span class="info_ordering_street"><?php echo $order['street']; ?></span>
                                    <span class="info_ordering_house"><?php echo $order['house']; ?></span>
                                    <span class="info_ordering_building"><?php echo $order['building']; ?></span><br>
                                    <span class="info_ordering_index"><?php echo $order['postcode']; ?></span>
                                    <span class="info_ordering_city"><?php echo $order['city']; ?></span><br>
                                    <span class="info_ordering_country"><?php echo $order['country']; ?></span>
                                </div>
                                <div class="ordering_block_side_cont_h">способ доставки</div>
                                <div class="ordering_block_side_cont_txt">
                                    <span class="info_ordering_type"><?php echo $order['delivery']; ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="ordering_block_side_info">
                            <div class="ordering_block_side_info_h_wrap parent">
                                <div class="ordering_block_side_info_h">Способ оплаты</div>
                            </div>
                            <div class="ordering_block_side_cont">
                                <div class="ordering_block_side_cont_h info_ordering_pay"><?php echo $order['payment']; ?></div>
                                <div class="ordering_block_side_cont_txt">[<?php echo $order['payments'][0]['paid'];?>]</div>
                                <div class="ordering_block_side_cont_txt">Сумма: <span class="info_ordering_price"><?php echo $price_sum;?></span> p.</div>
                            </div>
                        </div>
                        <div class="ordering_block_side_info">
                            <div class="ordering_block_side_info_h_wrap parent">
                                <div class="ordering_block_side_info_h">Статус заказа</div>
                            </div>
                            <div class="ordering_block_side_cont">
                                <div class="ordering_block_side_cont_h info_ordering_pay"><?php echo $order['status']; ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="ordering_block_bottom">
                        <div class="ordering_block_side_head">Данные о платеже</div>
                        <div class="ordering_block_side_info">
                            <div class="ordering_block_side_info_h_wrap parent">
                                <div class="ordering_block_side_info_h">ID: <?php echo $order['payments'][0]['id'];?></div>
                            </div>
                            <div class="ordering_block_side_cont">
                                <div class="ordering_block_side_cont_h info_ordering_pay"><?php echo $order['payment']; ?></div>
                                <div class="ordering_block_side_cont_txt">Сумма: <?php echo $order['payments'][0]['amount'] . ' ' . $order['payments'][0]['currency'];?></div>
                                <div class="ordering_block_side_cont_txt">Статус: <?php echo $order['payments'][0]['status'];?></div>
                                <div class="ordering_block_side_cont_txt">Оплата: <?php echo $order['payments'][0]['paid'];?></div>
                                <div class="ordering_block_side_cont_txt">Создан: <?php echo $order['payments'][0]['created_at'] . ' (' . $order['payments'][0]['created_at_orig'] . ')';?></div>
                                <div class="ordering_block_side_cont_txt">Истекает: <?php echo $order['payments'][0]['expires_at'];?></div>

                                <form action="" class="edit_kurs_form" id="1kurs_form" method="post" enctype="multipart/form-data">
                                    <div class="video_admin_form_buts parent">
                                        <?php if ($order['payments'][0]['status_code'] == 'waiting_for_capture'):?>
                                            <input type="submit" name="bt_capture" value="Подтвердить" class="video_admin_form_send" />
                                        <?php endif;?>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>