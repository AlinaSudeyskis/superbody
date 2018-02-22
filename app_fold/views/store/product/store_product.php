<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php include_once('./app_fold/views/store/category/categories_menu.php');?>
<div id="content" class="container shop_page one_tov_page">
    <div class="one_tov_block_wrap">
        <div class="one_tov_block parent">
            <div class="one_tov_gal">
                <div class="tov_slider_top_wrap">
                    <div class="tov_slider_top">
                        <?php if (!empty($product['images'])) :
                            foreach ($product['images'] as $key => $image) :
                                $class = ($key == 0) ? 'tov_slider_active' : ''; ?>
                                <a class="<?php echo $class; ?>" data-lightbox="tov_gal" href="<?php echo $image['path']; ?>"><img src="<?php echo $image['path']; ?>" alt=""></a>
                             <?php endforeach;
                            unset($image);
                        endif;?>
                    </div>
                    <div class="tov_slider_control parent">
                        <div class="tov_slider_plus"></div>
                        <div class="tov_slider_minus"></div>
                        <div class="tov_slider_full"></div>
                    </div>
                </div>
                <div class="tov_slider_bot">
                    <?php if (!empty($product['images'])) :
                        foreach ($product['images'] as $key => $image) : ?>
                            <div class="tov_slider_item"><a href="<?php echo $image['path']; ?>"><img src="<?php echo $image['path']; ?>" alt=""></a></div>
                        <?php endforeach;
                        unset($image);
                    endif;?>
                </div>
            </div>
            <form action="" method="post">
                <div class="one_tov_cont">
                    <div class="one_tov_h"><?php echo $product['name']; ?></div>
                    <?php if (!empty($product['discount_price'])) : ?>
                        <div class="one_tov_price"><s><?php echo $product['price']; ?> руб.</s></div>
                        <div class="one_tov_price"><?php echo $product['discount_price']; ?> руб.</div>
                    <?php else:?>
                        <div class="one_tov_price"><?php echo $product['price']; ?> руб.</div>
                    <?php endif; ?>
                    <div class="one_tov_article disabled">Артикул: 20029938</div>
                    <?php if ($product['quantity'] > 0) : ?>
                        <div class="one_tov_color disabled">
                            <div class="one_tov_param_h">Цвет</div>
                            <div class="one_tov_color_desk parent">
                                <div class="one_tov_color_item">#82ca9c</div>
                                <div class="one_tov_color_item">#6dcff6</div>
                                <div class="one_tov_color_item">#8781bd</div>
                                <div class="one_tov_color_item">#f49ac1</div>
                            </div>
                        </div>
                        <div class="one_tov_in_wrap parent">
                            <div class="one_tov_size disabled">
                                <div class="one_tov_param_h">Размер</div>
                                <input type="number" class="one_tov_num" placeholder="0" />
                            </div>
                                <div class="one_tov_number">
                                    <div class="one_tov_param_h">Количество</div>
                                    <input type="number" name="product_quantity" class="one_tov_num" id="product_quantity" value="1" max="<?php echo $product['quantity']; ?>" min="1" />
                                </div>
                        </div>
                        <div class="one_tov_basket_wrap parent">
                            <div class="one_tov_stock">В наличии</div>
                            <input type="submit" name="bt_to_cart" value="В корзину" class="one_tov_basket"/>
                        </div>
                        <?php if (!empty($product['attached'])) :?>
                            <div class="one_tov_dop">
                                <input type="checkbox" name="cb_with_attached" id="one_tov_dop_in" value="1" />
                                <label for="one_tov_dop_in">Добавить вместе с прикрепленными товарами</label>
                            </div>
                            <div class="one_tov_info">Приобретайте данный товар вместе с прикрепленными и получайте скидку!</div>
                        <?php endif;?>
                    <?php else: ?>
                        <div class="one_tov_basket_wrap parent">
                            <div class="one_tov_param_h">Нет в наличии</div>
                        </div>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>
    <?php $full_desc = $product['full_desc']; ?>

    <?php if (!empty($product['attached'])) :
        $path = '/store/product/'; ?>
        <div class="shop_block">
            <h2 class="one_shop_block_title">Вместе дешевле</h2>
            <div class="shop_block_tov parent">
                <?php foreach($product['attached'] as $key => $product) :
                    $discount = '';
                    $bonus    = '';?>
                    <div class="shop_tov_wrap">
                        <?php include('./app_fold/views/store/product/store_product_item.php');?>
                    </div>
                <?php endforeach;
                unset($product)?>
            </div>
        </div>
    <?php endif; ?>

    <div class="one_tov_description">
        <div class="one_tov_description_h">Описание</div>
        <div class="one_tov_description_cont"><?php echo $full_desc; ?></div>
    </div>

    <div class="shop_block disabled">
        <h2 class="shop_block_title">похожие товары</h2>
        <div class="shop_block_tov parent">
            <div class="shop_tov_wrap">
                <div class="shop_tov">
                    <div class="shop_tov_img"><img src="/img/tov1.png" alt=""></div>
                    <div class="shop_tov_name"><a href="">Роликовые коньки</a></div>
                    <div class="shop_tov_txt">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</div>
                    <div class="shop_tov_price">
                        <div class="shop_tov_price_one_new">
                            <div class="shop_tov_price_old"><span>2499</span>руб.</div>
                            <div class="shop_tov_price_new"><span>2199</span>руб.</div>
                        </div>
                    </div>
                    <div class="shop_tov_buts parent">
                        <div class="shop_tov_buts_col">
                            <a href="" class="shop_tov_more">Подробнее</a>
                        </div>
                        <div class="shop_tov_buts_col">
                            <div class="shop_tov_bay">В корзину</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="shop_tov_wrap">
                <div class="shop_tov">
                    <div class="shop_tov_img"><img src="/img/tov1.png" alt=""></div>
                    <div class="shop_tov_name"><a href="">Роликовые коньки</a></div>
                    <div class="shop_tov_txt">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</div>
                    <div class="shop_tov_price"><div class="shop_tov_price_def"><span>2499</span>руб.</div></div>
                    <div class="shop_tov_buts parent">
                        <div class="shop_tov_buts_col">
                            <a href="" class="shop_tov_more">Подробнее</a>
                        </div>
                        <div class="shop_tov_buts_col">
                            <div class="shop_tov_bay">В корзину</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="shop_tov_wrap">
                <div class="shop_tov">
                    <div class="shop_tov_img"><img src="/img/tov1.png" alt=""></div>
                    <div class="shop_tov_name"><a href="">Роликовые коньки</a></div>
                    <div class="shop_tov_txt">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</div>
                    <div class="shop_tov_price">
                        <div class="shop_tov_price_one_new">
                            <div class="shop_tov_price_old"><span>2499</span>руб.</div>
                            <div class="shop_tov_price_new"><span>2199</span>руб.</div>
                        </div>
                    </div>
                    <div class="shop_tov_buts parent">
                        <div class="shop_tov_buts_col">
                            <a href="" class="shop_tov_more">Подробнее</a>
                        </div>
                        <div class="shop_tov_buts_col">
                            <div class="shop_tov_bay">В корзину</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="shop_tov_wrap">
                <div class="shop_tov">
                    <div class="shop_tov_img"><img src="/img/tov1.png" alt=""></div>
                    <div class="shop_tov_name"><a href="">Роликовые коньки</a></div>
                    <div class="shop_tov_txt">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</div>
                    <div class="shop_tov_price"><div class="shop_tov_price_def"><span>2499</span>руб.</div></div>
                    <div class="shop_tov_buts parent">
                        <div class="shop_tov_buts_col">
                            <a href="" class="shop_tov_more">Подробнее</a>
                        </div>
                        <div class="shop_tov_buts_col">
                            <div class="shop_tov_bay">В корзину</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="shop_tov_wrap">
                <div class="shop_tov">
                    <div class="shop_tov_img"><img src="/img/tov1.png" alt=""></div>
                    <div class="shop_tov_name"><a href="">Роликовые коньки</a></div>
                    <div class="shop_tov_txt">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</div>
                    <div class="shop_tov_price"><div class="shop_tov_price_def"><span>2499</span>руб.</div></div>
                    <div class="shop_tov_buts parent">
                        <div class="shop_tov_buts_col">
                            <a href="" class="shop_tov_more">Подробнее</a>
                        </div>
                        <div class="shop_tov_buts_col">
                            <div class="shop_tov_bay">В корзину</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>