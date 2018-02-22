<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="admin_item parent">
    <div class="tov_img"><img src="<?php echo $product['image'];?>" alt=""></div>
    <div class="admin_cont">
        <div class="journal_block_item_h"><a href="/product/<?php echo $product['id'];?>"><?php echo $product['name'];?></a></div>
        <div class="tob_block_item_price parent">
            <div class="tob_block_item_price_val"><?php echo $product['price'];?> руб.</div>
            <div class="tob_block_item_price_dop"><?php echo $label; ?></div>
        </div>
        <div class="journal_block_item_edit"><a href="/administration/store/product/<?php echo $product['id'];?>">Редактировать</a></div>
    </div>
</div>