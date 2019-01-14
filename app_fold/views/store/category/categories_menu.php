<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if(!empty($user_session) and $user_session['type'] == 3): ?>
    <div class="shop_cat_wrap parent">
        <div class="shop_cat_kont parent">
            <ul class="shop_cat parent">
                <li class="submenu_li">
                    <?php $bg = (!empty($category_id) and ($category_id == 1 or $category_id == 2)) ? 'class="active"' : ''; ?>
                    <a href="#" <?php echo $bg;?>>Курсы</a>
                    <ul class="submenu" style="display: none;">
                        <li><a href="/store/1">Курсы тренировок</a></li>
                        <li><a href="/store/2">Курсы питания</a></li>
                    </ul>
                </li>
                <?php if (!empty($categories['categories'])) :
                    foreach ($categories['categories'] as $category) :
                        if($category['id'] > 2 and $category['id'] != 6):
                            $bg = (!empty($category_id) and $category['id'] == $category_id) ? 'class="active"' : '';?>
                            <li><a href="/store/<?php echo $category['id'];?>" <?php echo $bg;?>><?php echo $category['name'];?></a></li>
                        <?php endif;
                    endforeach;
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
<?php endif; ?>
