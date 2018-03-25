<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php include_once('./app_fold/views/store/product/sort_form.php');?>

<div id="content" class="container shop_page">
    <?php if (!empty($products)) :
        if ((empty($category_id) or $category_id == 'courses') and !empty($products[0])) :
            $path = '/course/';?>
            <div class="shop_block">
                <div class="shop_block_h">Курсы</div>
                <div class="shop_block_txt">Вы знаете, что тренироваться нужно регулярно, но сбалансировать свое расписание бывает трудно. Наши простые в использовании устройства и сообщество могут повысить уровень вашей текущей активности и помочь вам сделать фитнес частью своего образа жизни.</div>
                <div class="shop_block_tov parent">
                    <?php foreach ($products[0] as $product) :
                        $discount = (!empty($product['discount_price']) or !empty($product['discount_fc_price'])) ? 'shop_tov_promo' : '';
                        $bonus    = (!empty($product['attached']) or !empty($product['attached'])) ? 'shop_tov_bonus' : '';?>
                        <div class="shop_tovs_wrap">
                            <?php include('./app_fold/views/store/product/store_product_item.php');?>
                        </div>
                    <?php endforeach;?>
                </div>
                <?php include('./app_fold/views/pagination.php');?>
            </div>
        <?php endif;
        foreach ($categories as $category) :
            if (!empty($products[$category['id']])) :
                $path = '/store/'.$category['id'].'/product/';?>
                <div class="shop_block">
                    <div class="shop_block_h"><?php echo $category['name'];?></div>
                    <div class="shop_block_txt"><?php echo $category['desc'];?></div>
                    <div class="shop_block_tov parent">
                        <?php foreach ($products[$category['id']] as $product) :
                            $discount = (!empty($product['discount_price']) or !empty($product['discount_fc_price'])) ? 'shop_tov_promo' : '';
                            $bonus    = (!empty($product['attached']) or !empty($product['attached'])) ? 'shop_tov_bonus' : '';?>
                            <div class="shop_tovs_wrap">
                                <?php include('./app_fold/views/store/product/store_product_item.php');?>
                            </div>
                        <?php endforeach;?>
                    </div>
                    <?php include('./app_fold/views/pagination.php');?>
                </div>
            <?php endif;
        endforeach;
    else:?>
        <div class="container"><h2 class="shop_block_title">Товары не найдены</h2></div>
    <?php endif;?>
</div>