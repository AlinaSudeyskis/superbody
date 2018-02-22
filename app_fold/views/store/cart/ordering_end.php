<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include_once('./app_fold/views/store/category/categories_menu.php');?>
<div class="container"><h2 class="shop_block_title ordering_block_title">Оформление заказа</h2></div>

<div id="content" class="container ordering_page">
    <div class="ordering_block_wrap">
        <div class="ordering_end">
            <?php if (!empty($order['id'])): ?>
                <div class="ordering_end_h">ЗАКАЗ СФОРМИРОВАН</div>
                <div class="ordering_end_txt">Ваш заказ <span>№<?php echo $order['id'];?></span> успешно создан.<br>Вы можете следить за выполнением  своего заказа в Персональном разделе сайта. Обратите внимание, что для входа в этот раздел вам необходимо будет ввести логин  и пароль пользователя сайта.</div>
                <div class="ordering_end_h">Ждите звонка оператора</div>
                <div class="ordering_end_txt">Ваш заказ отправлен<br>В течении 5 минут с Вами свяжется наш оператор для поддтверждения вашего заказа<br>Убедитесь, что Ваш телефон  включен и находится в зоне действия сети</div>
            <?php else: ?>
                <div class="ordering_end_h">К сожалению, заказ не был создан. Повторите, пожалуйста, попытку.</div>
            <?php endif; ?>
        </div>
    </div>
</div>