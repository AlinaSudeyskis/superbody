<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="shop_cat_wrap parent">
    <div class="shop_cat_kont parent">
        <ul class="shop_cat parent">
            <li><a href="/store/courses" <?php if (!empty($category_id) and $category_id == 'courses') { echo 'class="active"'; } ?>>курсы</a></li>
            <?php if (!empty($categories['categories'])) :
                foreach ($categories['categories'] as $category) :
                    $bg = (!empty($category_id) and $category['id'] == $category_id) ? 'class="active"' : '';?>
                    <li><a href="/store/<?php echo $category['id'];?>" <?php echo $bg;?>><?php echo $category['name'];?></a></li>
                <?php endforeach;
                unset($category);
            endif;?>
        </ul>
        <div class="shop_search_form_wrap">
            <div class="open_search_form"></div>
            <form action="" class="shop_search_form parent" method="post">
                <input type="text" name="search" class="shop_search_in" placeholder="Введите наименование" value="<?php if (!empty($search)) { echo $search;}?>">
                <input type="submit" name="bt_search" class="shop_search_but" value="">
            </form>
        </div>
    </div>
    <a href="/cart" class="shop_basket parent">
        <span>Корзина
            <?php if (!empty($cart_count) and $cart_count > 0): echo '['.$cart_count.']'; endif;?>
        </span>
        <img src="/img/basket.png" alt="">
    </a>
</div>
