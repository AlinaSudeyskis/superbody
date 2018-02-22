<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="shop_line">
    <form action="" class="shop_sort_form parent" method="post">
        <div class="shop_sort parent">
            <div class="shop_sort_h">Сортировать:</div>
            <div class="shop_sort_in_wrap parent">
                <input type="radio" name="sort" value="1" id="sort_price_up" class="shop_sort_in" <?php if ($sort_checked == 1) {echo 'checked="checked"';}?>>
                <label for="sort_price_up">Цена по возрастанию</label>
                <input type="radio" name="sort" value="2" id="sort_price_down" class="shop_sort_in" <?php if ($sort_checked == 2) {echo 'checked="checked"';}?>>
                <label for="sort_price_down">Цена по убыванию</label><!--
                <input type="radio" name="sort" value="3" id="sort_popular" class="shop_sort_in" <?php //if ($sort_checked == 3) {echo 'checked="checked"';}?>>
                <label for="sort_popular">Популярное</label>-->
                <input type="radio" name="sort" value="4" id="sort_promo" class="shop_sort_in" <?php if ($sort_checked == 4) {echo 'checked="checked"';}?>>
                <label for="sort_promo">Скидки</label>
            </div>
        </div>
        <input type="submit" name="bt_sort_result" value="Показать результат фильтра" class="shop_sort_but">
    </form>
</div>