<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="content_block new_content_block disabled">
    <div class="content_block_h new_content_block_h parent">
        <h3>Предлагаемые курсы</h3>
        <?php if (empty($outsider)):?>
            <a href="" class="add_tab_but">Добавить</a>
        <?php endif;?>
        <div class="content_block_h_buts">
            <div class="content_block_h_slide kurs_slide"></div>
            <div class="content_block_h_close"></div>
        </div>
    </div>
    <div class="kurs_block_val tren_kurs_block_val">
        <div class="kurs_head">
            <div class="kurs_h_row">
                <div class="kurs_h_col">Название</div>
                <div class="kurs_h_col">Цена</div>
                <div class="kurs_h_col">Продано</div>
                <div class="kurs_h_col">Действие</div>
            </div>
        </div>
        <div class="kurs_body">
            <div class="kurs_row">
                <div class="kurs_col">Lion KC</div>
                <div class="kurs_col">11 999 руб.</div>
                <div class="kurs_col">39</div>
                <div class="kurs_col"><a href="" class="kurs_more_but tren_set_but">Редактировать</a></div>
            </div>
            <div class="kurs_row">
                <div class="kurs_col">ABC Lounge</div>
                <div class="kurs_col">11 999 руб.</div>
                <div class="kurs_col">40</div>
                <div class="kurs_col"><a href="" class="kurs_more_but tren_set_but">Редактировать</a></div>
            </div>
            <div class="kurs_row">
                <div class="kurs_col">Lion KC</div>
                <div class="kurs_col">11 999 руб.</div>
                <div class="kurs_col">66</div>
                <div class="kurs_col"><a href="" class="kurs_more_but tren_set_but">Редактировать</a></div>
            </div>
            <div class="kurs_row">
                <div class="kurs_col">ABC Lounge</div>
                <div class="kurs_col">11 999 руб.</div>
                <div class="kurs_col">52</div>
                <div class="kurs_col"><a href="" class="kurs_more_but tren_set_but">Редактировать</a></div>
            </div>
            <div class="kurs_row">
                <div class="kurs_col">ABC Lounge</div>
                <div class="kurs_col">11 999 руб.</div>
                <div class="kurs_col">52</div>
                <div class="kurs_col"><a href="" class="kurs_more_but tren_set_but">Редактировать</a></div>
            </div>
        </div>
    </div>
</div>