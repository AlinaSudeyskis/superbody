<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="shop_tov <?php if (empty($bonus)) { echo $discount;} else { echo $bonus;}?>">
    <?php $p_id = ($product['course_id'] > 0) ? $product['course_id'] : $product['id']; ?>

    <div class="shop_tov_img"><img src="<?php echo $product['image'];?>" alt=""></div>
    <div class="shop_tov_name"><a href="<?php echo $path . $p_id?>" title="<?php echo $product['name'];?>"><?php echo $product['name'];?></a></div>
    <div class="shop_tov_txt" title="<?php echo $product['short_desc'];?>"><?php echo $product['short_desc'];?></div>
    <div class="shop_tov_price">
        <?php // Если указана цена в рублях или FitCoin и не указаны скидки
        /*if (((!empty($product['price']) and empty($product['fc_price'])) or
                (empty($product['price']) and !empty($product['fc_price']))) and
            empty($product['discount_price']) and empty($product['discount_fc_price'])) :
            $currency = !empty($product['price']) ? 'руб.' : 'FitCoin';
            $price    = !empty($product['price']) ? $product['price'] : $product['fc_price'];?>

            <div class="shop_tov_price_def"><span><?php echo $price;?></span><?php echo $currency;?></div>

        <?php // Если указана цена в рублях или FitCoin и указана скидка
        elseif((!empty($product['price']) and empty($product['fc_price']) and !empty($product['discount_price'])) or
            (empty($product['price']) and !empty($product['fc_price']) and !empty($product['discount_fc_price']))) :
            $currency  = !empty($product['price']) ? 'руб.' : 'FitCoin';
            $old_price = !empty($product['price']) ? $product['price'] : $product['fc_price'];
            $new_price = !empty($product['price']) ? $product['discount_price'] : $product['discount_fc_price'];?>

            <div class="shop_tov_price_one_new">
                <div class="shop_tov_price_old"><span><?php echo $old_price;?></span><?php echo $currency;?></div>
                <div class="shop_tov_price_new"><span><?php echo $new_price;?></span><?php echo $currency;?></div>
            </div>

        <?php // Если указана цена в рублях и FitCoin и не указаны скидки
        elseif (!empty($product['price']) and !empty($product['fc_price']) and
            empty($product['discount_price']) and empty($product['discount_fc_price'])) :?>

            <div class="shop_tov_price_two_new">
                <div class="shop_tov_price_l">
                    <div class="shop_tov_price_def"><span><?php echo $product['fc_price'];?></span>FitCoin</div>
                </div>
                <div class="shop_tov_price_r">
                    <div class="shop_tov_price_def"><span><?php echo $product['price'];?></span>руб.</div>
                </div>
            </div>

        <?php //  Если указана цена в рублях и FitCoin и указаны скидки
        elseif (!empty($product['price']) and !empty($product['fc_price']) and
            !empty($product['discount_price']) and !empty($product['discount_fc_price'])) :?>

            <div class="shop_tov_price_two_new">
                <div class="shop_tov_price_l">
                    <div class="shop_tov_price_old"><?php echo $product['fc_price'];?></div>
                    <div class="shop_tov_price_new"><span><?php echo $product['discount_fc_price'];?></span>FC</div>
                </div>
                <div class="shop_tov_price_r">
                    <div class="shop_tov_price_old"><?php echo $product['price'];?></div>
                    <div class="shop_tov_price_new"><span><?php echo $product['discount_price'];?></span>руб.</div>
                </div>
            </div>

        <?php endif;*/?>
        <?php // Если указана цена в рублях и не указаны скидки
        if (!empty($product['price']) and $product['price'] > 0 and empty($product['discount_price']) and empty($product['discount_fc_price'])) :
            $currency = 'руб.';
            $price    = $product['price'];?>

            <div class="shop_tov_price_def"><span><?php echo $price;?></span><?php echo $currency;?></div>

        <?php // Если указана цена в рублях  и указана скидка
        elseif (!empty($product['price']) and $product['price'] > 0 and !empty($product['discount_price'])) :
            $currency  = 'руб.';
            $old_price = $product['price'];
            $new_price = $product['discount_price'];?>

            <div class="shop_tov_price_one_new">
                <div class="shop_tov_price_old"><span><?php echo $old_price;?></span><?php echo $currency;?></div>
                <div class="shop_tov_price_new"><span><?php echo $new_price;?></span><?php echo $currency;?></div>
            </div>
        <?php elseif ($product['price'] == '0.00') : ?>
            <div class="shop_tov_price_def">Бесплатно</div>
        <?php endif;?>
    </div>
    <div class="shop_tov_buts parent">
        <div class="shop_tov_buts_col">
            <a href="<?php echo $path . $p_id?>" class="shop_tov_more">Подробнее</a>
        </div>
        <div class="shop_tov_buts_col">
            <?php $cart_match = false;
            $bought_match = false;
            if (!empty($products_id)) //  and $product['course_id'] == 0
            {
                $cart_match = in_array($product['id'], $products_id);
            }
            if (!empty($courses_id) and $product['course_id'] > 0)
            {
                $bought_match = in_array($product['course_id'], $courses_id);
            }
            if (($product['quantity'] > 0 or $product['course_id'] > 0) and $cart_match === false and $bought_match === false): ?>
                <div class="shop_tov_bay to_cart">В корзину
                    <input type="hidden" name="product_id" id="product_id" value="<?php echo $product['id'];?>"/>
                    <input type="hidden" name="product_quantity" id="product_quantity" value="1"/>
                </div>
            <?php elseif ($product['quantity'] == 0 and $product['course_id'] == 0): ?>
                <div class="not_available">Нет в наличии</div>
            <?php elseif ($cart_match === true): ?>
                <div class="not_available">В корзине</div>
            <?php elseif ($bought_match === true): ?>
                <div class="not_available">Куплен</div>
            <?php endif; ?>
        </div>
    </div>
</div>