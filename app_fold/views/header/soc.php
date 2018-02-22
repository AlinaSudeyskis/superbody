<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="header_soc_wrap parent">
    <div class="header_tel"><?php if (!empty($site_info['phone'])): echo $site_info['phone']; endif;?></div>
    <?php include('./app_fold/views/header/header_soc.php'); ?>
</div>
