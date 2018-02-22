<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="anketa_block_item">
    <div class="anketa_block_item_cont">
        <div class="anketa_block_item_h"></div>
        <div class="anketa_form_line parent">
            <div class="anketa_form_h"><div class="anketa_form_h_cell">Кол-во пользователей:</div></div>
            <div class="anketa_form_h"><div class="anketa_form_h_cell"><b><?php echo $statistics['count_users']; ?></b></div></div>
            <div class="anketa_form_desk"> чел.</div>
        </div>
        <div class="anketa_form_line parent">
            <div class="anketa_form_h"><div class="anketa_form_h_cell">Сумма:</div></div>
            <div class="anketa_form_h"><div class="anketa_form_h_cell"><b><?php echo $statistics['count_price']; ?></b></div></div>
            <div class="anketa_form_desk"> руб.</div>
        </div>
    </div>
</div>