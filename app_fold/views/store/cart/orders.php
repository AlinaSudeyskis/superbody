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
                            <h3>Заказы</h3>
                        </div>
                        <?php include_once('./app_fold/views/store/cart/orders_menu.php'); ?>
                    </div>
                </div>
                <div class="kurs_block_val">
                    <div class="admin_journal">
                        <div class="admin_list">
                            <?php if (!empty($orders)) :
                                foreach ($orders as $order) :
                                    $waiting_status = ($order['waiting_status'] === true) ? 'bg_gray' : '';
                                ?>
                                    <div class="admin_item <?php echo $waiting_status; ?>">
                                        <div class="journal_block_item_h"><a href="/administration/order/<?php echo $order['id']; ?>">Заказ №<?php echo $order['id']; ?></a></div>
                                        <div class="journal_block_item_data">Дата заказа: <?php echo $order['date']; ?></div>
                                        <div class="journal_block_item_data">Сумма заказа: <?php echo $order['order_amount']; ?> руб.</div>
                                        <?php if(!empty($order['address'])): ?>
                                            <div class="journal_block_item_data">Адрес доставки: <?php echo $order['address']; ?></div>
                                        <?php endif; ?>
                                        <?php $order_user_name = (!empty($order['user_name'])) ? $order['user_name'] : $order['user_email']; ?>
                                        <div class="journal_block_item_edit">
                                            <?php if(!empty($order['user_id'])): ?>
                                                <a href="/profile/<?php echo $order['user_id']; ?>"><?php echo $order_user_name; ?></a>
                                            <?php else: ?>
                                                <?php echo $order_user_name; ?>
                                            <?php endif; ?>
                                        </div>
                                        <div class="journal_block_item_edit"><a href="/administration/order/<?php echo $order['id']; ?>">Подробнее</a></div>
                                    </div>
                                <?php endforeach;
                                unset($order);
                            endif;?>
                        </div>
                    </div>
                    <?php include_once('./app_fold/views/pagination.php'); ?>
                </div>
            </div>
        </div><!-- content_col -->
    </div>
</div><!-- content -->