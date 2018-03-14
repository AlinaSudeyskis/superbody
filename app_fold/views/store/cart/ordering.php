<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include_once('./app_fold/views/store/category/categories_menu.php');?>
<div class="container"><h2 class="shop_block_title ordering_block_title">Оформление заказа</h2></div>

<div id="content" class="container ordering_page">
    <div class="ordering_block_wrap">
        <?php if (!empty($products)): ?>
            <form action="" class="ordering_form" method="post">
                <div class="ordering_block ordering_block1 parent">
                    <div class="ordering_block_cont">
                        <div class="ordering_block_head parent">
                            <div class="ordering_block_head_item ordering_block_head_item_active">
                                <div class="ordering_block_head_num">1</div>
                                <div class="ordering_block_head_name">Адресс и доставка</div>
                            </div>
                            <div class="ordering_block_head_item">
                                <div class="ordering_block_head_num">2</div>
                                <div class="ordering_block_head_name">оплата</div>
                            </div>
                            <div class="ordering_block_head_item">
                                <div class="ordering_block_head_num">3</div>
                                <div class="ordering_block_head_name">подтверждение заказа</div>
                            </div>
                        </div>
                        <div class="ordering_block_info">
                            <div class="ordering_block_hide_h">Адресс и доставка</div>
                            <div class="ordering_block_info_h">Введите ваши данные</div>
                            <input type="text" class="ordering_in" name="i_o_name" placeholder="Ваше имя" value="<?php if(!empty($user_session)) : echo $user_session['s_name']; endif; ?>" />
                            <input type="text" class="ordering_in" name="i_o_surname" placeholder="Ваша фамилия" value="<?php if(!empty($user_session)) : echo $user_session['s_surname']; endif; ?>" maxlength="255"/>
                            <input type="text" class="ordering_in" name="i_o_phone" placeholder="Телефон" maxlength="255"/>
                            <input type="text" class="ordering_in" name="i_o_email" placeholder="E-mail" value="<?php if(!empty($user_session)) : echo $user_session['email']; endif; ?>" maxlength="255"/>
                            <?php if (!empty($addresses)):?>
                                <div class="ordering_check_wrap">
                                    <div class="anketa_form_one_wrap anketa_form_three_wrap">
                                        <select name="s_o_address" class="anketa_form_select">
                                            <option value="">Использовать ранее введенный адрес</option>
                                            <?php foreach ($addresses as $address):?>
                                                <option value="<?php echo $address['id']?>">
                                                    <?php echo $address['postcode'].' '.$address['country'].', '.$address['city'].', '.$address['street'].', '.$address['building'].' '.$address['house'];?>
                                                </option>
                                            <?php endforeach;
                                            unset($address);?>
                                        </select>
                                    </div>
                                </div>
                            <?php endif;?>
                            <input type="text" class="ordering_in" name="i_o_country" placeholder="Страна" value="" maxlength="255"/>
                            <input type="text" class="ordering_in" name="i_o_city" placeholder="Город" value="" maxlength="255"/>
                            <input type="text" class="ordering_in" name="i_o_street" placeholder="Улица" value="" maxlength="255"/>
                            <div class="parent ordering_two_in">
                                <input type="text" class="ordering_in" name="i_o_building" placeholder="Корпус" value="" maxlength="50"/>
                                <input type="text" class="ordering_in" name="i_o_house" placeholder="Дом" value="" maxlength="50"/>
                            </div>
                            <div class="parent ordering_two_in">
                                <input type="text" class="ordering_in" name="i_o_postcode" placeholder="Индекс" value="" maxlength="10"/>
                            </div>
                            <div class="ordering_block_info_h ordering_block_info_line">Выберите способ доставки</div>
                            <div class="ordering_radio_wrap">
                                <input type="radio" name="i_o_delivery" id="ordering_radio1" checked value="Курьер" />
                                <label for="ordering_radio1">Курьер</label>
                            </div>
                            <div class="ordering_radio_wrap">
                                <input type="radio" name="i_o_delivery" id="ordering_radio2" value="Почта" />
                                <label for="ordering_radio2">Почта</label>
                            </div>
                            <div class="ordering_radio_wrap">
                                <input type="radio" name="i_o_delivery" id="ordering_radio3" value="Самовывоз" />
                                <label for="ordering_radio3">Самовывоз</label>
                            </div>
                            <div class="ordering_buts parent">
                                <div class="ordering_next ordering_next1">Продолжить</div>
                            </div>
                        </div>
                    </div>
                    <div class="ordering_block_side">
                        <div class="ordering_block_side_head">Заказ</div>
                        <div class="ordering_block_side_info">
                            <div class="ordering_block_tov_slider ordering_block_tov_slider1">
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
                                                <div class="ordering_block_tov_info_line">Стоимость: <?php echo $product_sum; ?> руб.</div>
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
                                                        <div class="ordering_block_tov_info_line">Стоимость: <?php echo $product_sum; ?> руб.</div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach;
                                        unset($attached);
                                    endif;
                                endforeach;
                                unset($product);?>
                            </div>
                            <div class="ordering_block_price parent">
                                <div class="ordering_block_price_h">Итого</div>
                                <div class="ordering_block_price_val"><?php echo $price_sum;?> руб.</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ordering_block ordering_block2 parent">
                    <div class="ordering_block_cont">
                        <div class="ordering_block_head parent">
                            <div class="ordering_block_head_item">
                                <div class="ordering_block_head_num">1</div>
                                <div class="ordering_block_head_name">Адресс и доставка</div>
                            </div>
                            <div class="ordering_block_head_item ordering_block_head_item_active">
                                <div class="ordering_block_head_num">2</div>
                                <div class="ordering_block_head_name">Оплата</div>
                            </div>
                            <div class="ordering_block_head_item">
                                <div class="ordering_block_head_num">3</div>
                                <div class="ordering_block_head_name">Подтверждение заказа</div>
                            </div>
                        </div>
                        <div class="ordering_block_info ordering_block_info2">
                            <div class="ordering_block_hide_h">Оплата</div>
                            <div class="ordering_block_info_h">Введите способы оплаты</div>
                            <div class="ordering_radio_wrap">
                                <input type="radio" name="i_o_payment" id="ordering_radio4" value="Оплата наличными при получении" />
                                <label for="ordering_radio4">Оплата наличными при получении</label>
                                <span class="ordering_radio_desk">Оплата заказа осуществляется непосредственно при доставке заказа.</span>
                            </div>
                            <div class="ordering_radio_wrap">
                                <input type="radio" name="i_o_payment" id="ordering_radio5" checked="checked" value="Онлайн оплата" />
                                <label for="ordering_radio5">Онлайн оплата</label>
                                <span class="ordering_radio_desk">Вы будете перенаправлены на страницу платежной системы для совершения оплаты.</span>
                            </div>
                            <div class="ordering_radio_wrap">
                                <input type="radio" name="i_o_payment" id="ordering_radio6" value="Банковский перевод" />
                                <label for="ordering_radio6">Банковский перевод</label>
                                <span class="ordering_radio_desk">Вы будете перенаправлены на страницу платежной системы для совершения оплаты.</span>
                            </div>
                            <div class="ordering_buts parent">
                                <div class="ordering_prev ordering_prev1">Вернуться</div>
                                <div class="ordering_next ordering_next2">Продолжить</div>
                            </div>
                        </div>
                    </div>
                    <div class="ordering_block_side">
                        <div class="ordering_block_side_head">Заказ</div>
                        <div class="ordering_block_side_info">
                            <div class="ordering_block_tov_slider ordering_block_tov_slider2">

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
                                                <div class="ordering_block_tov_info_line">Стоимость: <?php echo $product_sum; ?> руб.</div>
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
                                                    <div class="ordering_block_tov_info_line">Стоимость: <?php echo $product_sum; ?> руб.</div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach;
                                    unset($attached);
                                endif;
                                endforeach;
                                unset($product);?>
                            </div>
                            <div class="ordering_block_price parent">
                                <div class="ordering_block_price_h">Итого</div>
                                <div class="ordering_block_price_val"><?php echo $price_sum;?> руб.</div>
                            </div>
                        </div>
                        <div class="ordering_block_side_info">
                            <div class="ordering_block_side_info_h_wrap parent">
                                <div class="ordering_block_side_info_h">Адрес и способ доставки</div>
                                <div class="ordering_block_side_info_edit">Редактировать</div>
                            </div>
                            <div class="ordering_block_side_cont">
                                <div class="ordering_block_side_cont_h">Адрес доставки</div>
                                <div class="ordering_block_side_cont_txt">
                                    <div class="ordering_block_side_cont_line">
                                        <span class="info_ordering_t_name"></span>
                                        <span class="info_ordering_name"></span>
                                        <span class="info_ordering_s_name"></span>
                                    </div>
                                    <span class="info_ordering_street"></span>
                                    <span class="info_ordering_house"></span>
                                    <span class="info_ordering_building"></span><br>
                                    <span class="info_ordering_index"></span>
                                    <span class="info_ordering_city"></span><br>
                                    <span class="info_ordering_country"></span>
                                </div>
                                <div class="ordering_block_side_cont_h">Способ доставки</div>
                                <div class="ordering_block_side_cont_txt">
                                    <span class="info_ordering_type"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ordering_block ordering_block3 parent">
                    <div class="ordering_block_cont">
                        <div class="ordering_block_head parent">
                            <div class="ordering_block_head_item">
                                <div class="ordering_block_head_num">1</div>
                                <div class="ordering_block_head_name">Адресс и доставка</div>
                            </div>
                            <div class="ordering_block_head_item">
                                <div class="ordering_block_head_num">2</div>
                                <div class="ordering_block_head_name">оплата</div>
                            </div>
                            <div class="ordering_block_head_item ordering_block_head_item_active">
                                <div class="ordering_block_head_num">3</div>
                                <div class="ordering_block_head_name">подтверждение заказа</div>
                            </div>
                        </div>
                        <div class="ordering_block_info ordering_block_info3">
                            <div class="ordering_block_hide_h">Подтверждение заказа</div>
                            <div class="ordering_block_info_h">ПРОВЕРИТЬ И ПОДТВЕРДИТЬ ЗАКАЗ</div>
                            <div class="ordering_block_tab">

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
                                    endif;

                                    $product_item = $product;
                                    include('./app_fold/views/store/cart/cart_product_item.php');

                                    // Прикрепленные товары
                                    if (!empty($product['attached'])):?>

                                        <div class="dop_tov_line parent" id="dtlp_<?php echo $product['c_id']; ?>">
                                            <div class="dop_tov_line_h">Прикрепленные товары</div>
                                            <input type="submit" name="bt_detach_products[<?php echo $product['c_id']; ?>]" value="Открепить" class="dop_tov_line_but" id="detach_products"/>
                                            <input type="hidden" name="product_id[]" value="<?php echo $product['c_id']; ?>" id="c_id"/>
                                        </div>

                                        <?php foreach ($product['attached'] as $attached):
                                            $price = !empty($attached['discount_price']) ? $attached['discount_price'] : $attached['price'];
                                            $product_sum = $price;
                                            // Общая итоговая сумма корзины
                                            if (!empty($attached['price']) and $attached['quantity'] > 0 and $attached['course_id'] == 0) :
                                                $product_sum = $price * $attached['cart_quantity'];
                                                $price_sum += $product_sum;
                                            elseif (!empty($attached['price']) and $attached['course_id'] > 0) :
                                                $price_sum += $product_sum;
                                            endif;

                                            $product_item = $attached;
                                            include('./app_fold/views/store/cart/cart_product_item.php');

                                        endforeach;
                                        unset($attached);

                                        // Разделитель окончания прикрепленных товаров?>
                                        <div class="dop_tov_line" id="dtl_<?php echo $product['c_id']; ?>"></div>
                                    <?php endif;
                                endforeach;
                                unset($product);?>
                            </div>
                            <div class="ordering_buts parent">
                                <div class="ordering_prev ordering_prev2">Вернуться</div>
                                <input type="submit" name="bt_to_order" class="ordering_next" value="КУПИТЬ" />
                            </div>
                        </div>
                    </div>
                    <div class="ordering_block_side">
                        <div class="ordering_block_side_head">Детали Заказа</div>
                        <div class="ordering_block_side_info">
                            <div class="ordering_block_side_info_h_wrap parent">
                                <div class="ordering_block_side_info_h">адрес и способ доставки</div>
                                <div class="ordering_block_side_info_edit">Редактировать</div>
                            </div>
                            <div class="ordering_block_side_cont">
                                <div class="ordering_block_side_cont_h">адрес доставки</div>
                                <div class="ordering_block_side_cont_txt">
                                    <div class="ordering_block_side_cont_line">
                                        <span class="info_ordering_t_name"></span>
                                        <span class="info_ordering_name"></span>
                                        <span class="info_ordering_s_name"></span>
                                    </div>
                                    <span class="info_ordering_street"></span>
                                    <span class="info_ordering_house"></span>
                                    <span class="info_ordering_building"></span><br>
                                    <span class="info_ordering_index"></span>
                                    <span class="info_ordering_city"></span><br>
                                    <span class="info_ordering_country"></span>
                                </div>
                                <div class="ordering_block_side_cont_h">способ доставки</div>
                                <div class="ordering_block_side_cont_txt">
                                    <span class="info_ordering_type"></span>
                                </div>
                            </div>
                        </div>
                        <div class="ordering_block_side_info">
                            <div class="ordering_block_side_info_h_wrap parent">
                                <div class="ordering_block_side_info_h">Способ оплаты</div>
                            </div>
                            <div class="ordering_block_side_cont">
                                <div class="ordering_block_side_cont_h info_ordering_pay"></div>
                                <div class="ordering_block_side_cont_txt">Сумма: <span class="info_ordering_price"></span> p.</div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        <?php else:?>
            <h2 class="shop_block_title">Нет товаров для оформления заказа</h2>
        <?php endif;?>
    </div>
</div>