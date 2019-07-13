<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php $breadcrumbs = array('/coaches' => 'Тренеры');
include_once('./app_fold/views/breadcrumb.php');?>
<div class="container"><h2 class="block_h">Наши тренеры</h2></div>

<div id="content" class="container">
    <div class="trainers_row row">
        <?php if (!empty($coaches)):
            foreach($coaches as $coach):
                include('./app_fold/views/coach/coach_item.php');
            endforeach;
            unset($coach);
        endif;?>
    </div>
</div><!-- content -->

<?php include('./app_fold/views/pagination.php');?>
