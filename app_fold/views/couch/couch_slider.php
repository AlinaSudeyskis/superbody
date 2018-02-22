<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
    <h2 class="block_h">НАШИ ТРЕНЕРЫ</h2>
    <div class="tren_block" data-info="Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.">
        <?php if (!empty($couches)) :
            foreach ($couches as $couch) :
                include('./app_fold/views/couch/couch_slider_item.php');
            endforeach;
            unset($couch);
        endif;?>
    </div>
</div>