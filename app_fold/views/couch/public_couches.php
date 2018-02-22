<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container"><h2 class="block_h">Наши тренера</h2></div>

<!--<div class="filtr_wrap disabled">
    <form action="#" class="filtr_form">
        <input type="number" class="filtr_num" placeholder="0">
        <input type="number" class="filtr_num" placeholder="0">
        <input type="text" class="filtr_in" placeholder="Поле для ввода">
        <input type="text" class="filtr_in" placeholder="Поле для ввода">
        <input type="text" class="filtr_in" placeholder="Поле для ввода">
        <input type="text" class="filtr_in" placeholder="Поле для ввода">
        <input type="text" class="filtr_in" placeholder="Поле для ввода">
        <input type="text" class="filtr_in" placeholder="Поле для ввода">
        <input type="submit" class="filtr_but" value="Показать результат фильтра">
    </form>
</div>--><!-- filtr_wrap -->

<div id="content" class="container">
    <div class="trainers_row row">
        <?php if (!empty($couches)):
            foreach($couches as $couch):
                include('./app_fold/views/couch/couch_item.php');
            endforeach;
            unset($couch);
        endif;?>
    </div>
</div><!-- content -->

<?php include('./app_fold/views/pagination.php');?>
