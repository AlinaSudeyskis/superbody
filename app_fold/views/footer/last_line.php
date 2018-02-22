<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="header_soc_wrap footer_soc_wrap parent">
    <div class="footer_copy"><?php if (!empty($site_info['footer'])): echo $site_info['footer']; endif;?></div>
    <?php include('./app_fold/views/header/header_soc.php'); ?>
</div>