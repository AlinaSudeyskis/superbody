<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<a href="<?php if (!empty($site_info['agreement'])): echo $site_info['agreement']; endif;?>" class="agreement <?php if (empty($site_info['agreement'])): echo 'disabled'; endif;?>">Пользовательское соглашение</a>
<a href="<?php if (!empty($site_info['private_policy'])): echo $site_info['private_policy']; endif;?>" class="agreement <?php if (empty($site_info['private_policy'])): echo 'disabled'; endif;?>">Политика конфиденциальности</a>
