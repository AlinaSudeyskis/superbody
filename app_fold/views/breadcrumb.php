<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="breadcrumb">
    <a href="/">Главная</a>
    <span class="separator">/</span>
    <?php if(!empty($breadcrumbs)):
        $count_bc = count($breadcrumbs);
        $i = 1;
        foreach($breadcrumbs as $url => $bc_name):
            if($count_bc == 1 or $i == $count_bc): ?>
                <span><?php echo $bc_name; ?></span>
            <?php else: ?>
                <a href="<?php echo $url; ?>"><?php echo $bc_name; ?></a>
                <span class="separator">/</span>
            <?php endif;
            $i++;
        endforeach;
        unset($bc_name); ?>
    <?php endif; ?>
</div>
