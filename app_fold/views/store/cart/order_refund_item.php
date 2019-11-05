<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="ordering_block_side_info">
    <div class="ordering_block_side_info_h_wrap parent">
        <div class="ordering_block_side_info_h">ID: <?php echo $refund['id'];?></div>
    </div>
    <div class="ordering_block_side_cont">
        <div class="ordering_block_side_cont_h info_ordering_pay"></div>
        <div class="ordering_block_side_cont_txt">Сумма: <?php echo $refund['amount'] . ' ' . $refund['currency'];?></div>
        <div class="ordering_block_side_cont_txt">Статус: <span class="<?php echo $refund['status_code']; ?>"><?php echo $refund['status'];?></span></div>
        <?php if(!empty($refund['created_at'])): ?>
            <div class="ordering_block_side_cont_txt">Создан: <?php echo $refund['created_at'];?></div>
        <?php endif;?>
    </div>
</div>
