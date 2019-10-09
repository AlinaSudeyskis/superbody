<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="content" class="container">
    <div class="row">
        <div class="col-lg-2 left_sidebar">
            <?php include_once('./app_fold/views/user/user_menu.php');?>
        </div><!-- left_sidebar -->
        <div class="col-lg-10 content_col">
            <div class="content_block">
                <div class="content_block_container_wrap">
                    <div class="content_block_h new_content_block_h parent">
                        <?php $order_id = (!empty($order['id'])) ? '№' . $order['id']: ''; ?>
                        <h3>Заказ <?php echo $order_id;?></h3>
                    </div>
                </div>
                <div class="ordering_block ordering_block3 parent admin">
                    <?php include_once('./app_fold/views/store/cart/order_item.php'); ?>
                </div>
            </div>
        </div>
    </div>
</div>