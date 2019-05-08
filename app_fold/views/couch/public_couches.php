<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php $breadcrumbs = array('/couches' => 'Тренеры');
include_once('./app_fold/views/breadcrumb.php');?>
<div class="container"><h2 class="block_h">Наши тренеры</h2></div>

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
