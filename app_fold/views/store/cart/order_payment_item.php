<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="ordering_block_side_info">
    <div class="ordering_block_side_info_h_wrap parent">
        <div class="ordering_block_side_info_h">
            <?php if(!empty($payment['id'])):?>
                ID: <?php echo $payment['id'];?>
            <?php elseif(!empty($payment['following_date'])): ?>
                Предстоящий платеж <span>(<?php echo $payment['following_date']; ?>)</span>
            <?php endif; ?>
        </div>
    </div>
    <div class="ordering_block_side_cont">
        <div class="ordering_block_side_cont_h info_ordering_pay"><?php echo $payment['payment_type']; ?></div>
        <div class="ordering_block_side_cont_txt">Сумма: <?php echo $payment['amount'] . ' ' . $payment['currency'];?></div>
        <?php if(!empty($payment['status'])): ?>
            <div class="ordering_block_side_cont_txt">Статус: <span class="<?php echo $payment['status_code']; ?>"><?php echo $payment['status'];?></span></div>
        <?php endif; ?>
        <?php if(!empty($payment['status'])): ?>
            <div class="ordering_block_side_cont_txt">Оплата: <?php echo $payment['paid'];?></div>
        <?php endif; ?>
        <?php if(!empty($order['payments'][0]['captured_at'])): ?>
            <div class="ordering_block_side_cont_txt">Подтвержден: <?php echo $payment['captured_at'];?></div>
        <?php endif;

        if ($order['payments'][0]['status_code'] == 'pending' and !empty($payment['confirm_url'])):?>
            <form action="" class="edit_kurs_form" id="1kurs_form" method="post">
                <div class="video_admin_form_buts parent">
                    <a href="<?php echo $payment['confirm_url']; ?>" class="video_admin_form_send">Подтвердить платеж</a>
                </div>
            </form>
        <?php endif;?>
        <?php //print_r($order['payments'][0]); ?>
        <?php if($payment['method_saved'] == 1): ?>
            <div class="ordering_block_side_cont_h"></div>
            <?php if(!empty($payment['revoke']) and $payment['revoke'] == 1): ?>
                <div class="ordering_block_side_cont_h">Автоматический повтор платежей: <span class="canceled">Отменено</span></div>
            <?php else: ?>
                <div class="ordering_block_side_cont_h">Автоматический повтор платежей: <span class="succeeded">Разрешено</span></div>
                <div class="ordering_block_side_cont_txt">* При отмене автоматических платежей, Вам необходимо будет оплатить остаточную стоимость одним платежом.</div>
                <form action="" class="edit_kurs_form" id="1kurs_form" method="post">
                    <div class="video_admin_form_buts parent">
                        <input type="submit" name="bt_payment_revoke_permission" value="Отозвать разрешение на повторы платежей" class="anketa_form_but red" />
                    </div>
                </form>
            <?php endif; ?>
        <?php endif; ?>
    </div>
    <?php if(!empty($payment['refunds'])):?>
        <div class="ordering_block_side_info_h_wrap parent"></div>
        <div class="ordering_block_side_info_h_wrap parent">
            <div class="ordering_block_side_info_h">Возвраты</div>
        </div>
        <div class="ordering_block_side_cont">
            <div class="ordering_block_bottom">
                <?php foreach($payment['refunds'] as $refund): ?>
                    <?php include('./app_fold/views/store/cart/order_refund_item.php'); ?>
                <?php endforeach;
                unset($refund);?>
            </div>
        </div>
    <?php endif;?>
</div>
