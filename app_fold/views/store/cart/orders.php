<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="content" class="container">
    <div class="row">
        <div class="col-lg-2 left_sidebar">
            <?php include_once('./app_fold/views/admin/admin_menu.php');?>
        </div><!-- left_sidebar -->
        <div class="col-lg-10 content_col">
            <div class="content_block new_content_block">
                <div class="content_block_container_wrap">
                    <div class="content_block_container">
                        <div class="content_block_h new_content_block_h parent">
                            <h3>Заказы</h3>
                        </div>
                        <?php include_once('./app_fold/views/store/cart/orders_menu.php'); ?>
                    </div>
                </div>
                <div class="kurs_block_val">
                    <div class="shop_line">
                        <form action="/administration/orders" class="shop_sort_form parent" method="post">
                            <div class="shop_sort parent">
                                <div class="shop_sort_h">Поиск:</div>
                                <div class="shop_sort_in_wrap parent">
                                    <input type="radio" name="search_by" value="1" id="search_order" class="shop_sort_in"<?php if(empty($page_search_by) or $page_search_by == 1):?> checked="checked"<?php endif;?>>
                                    <label for="search_order">по заказам</label>
                                    <input type="radio" name="search_by" value="2" id="search_user" class="shop_sort_in"<?php if(!empty($page_search_by) and $page_search_by == 2):?> checked="checked"<?php endif;?>>
                                    <label for="search_user">по пользователям</label>
                                </div>
                            </div>
                            <div class="search_form">
                                <input type="text" name="search" class="search_in" placeholder="Введите ID зазказа или ID, Email пользователя" value="<?php if(!empty($page_search)): echo $page_search; endif; ?>">
                                <input type="submit" name="bt_orders_search" class="search_but defaultActionButton" value="Отправить">
                            </div>
                        </form>
                    </div>
                    <div class="admin_orders_list admin_list">
                        <?php if (!empty($orders)) :
                            foreach ($orders as $order) :
                                $waiting_status = ($order['waiting_status'] === true) ? 'bg_gray' : '';
                            ?>
                                <div class="admin_order_item <?php echo $waiting_status; ?>">
                                    <div class="journal_block_item_h"><a href="/administration/order/<?php echo $order['id']; ?>">Заказ №<?php echo $order['id']; ?></a></div>
                                    <div class="journal_block_item_data">Дата заказа: <?php echo $order['date']; ?></div>
                                    <div class="journal_block_item_data">Сумма заказа: <?php echo $order['order_amount']; ?> руб.</div>
                                    <?php if(!empty($order['address'])): ?>
                                        <div class="journal_block_item_data">Адрес доставки: <?php echo $order['address']; ?></div>
                                    <?php endif; ?>
                                    <?php $order_user_name = (!empty($order['user_name'])) ? $order['user_name'] : $order['user_email']; ?>
                                    <div class="journal_block_item_edit">
                                        <?php if(!empty($order['user_id'])): ?>
                                            <a href="/administration/<?php echo $order['user_type']; ?>/<?php echo $order['user_id']; ?>"><?php echo $order_user_name; ?></a>
                                        <?php else: ?>
                                            <?php echo $order_user_name; ?>
                                        <?php endif; ?>
                                    </div>
                                    <div class="journal_block_item_edit"><a href="/administration/order/<?php echo $order['id']; ?>">Подробнее</a></div>
                                </div>
                            <?php endforeach;
                            unset($order);
                        elseif(empty($orders) and !empty($page_submenu) and $page_submenu == 'search'): ?>
                            <h3 class="info">По Вашему запросу ничего не найдено</h3>
                        <?php endif;?>
                    </div>
                    <?php include_once('./app_fold/views/pagination.php'); ?>
                </div>
            </div>
        </div><!-- content_col -->
    </div>
</div><!-- content -->