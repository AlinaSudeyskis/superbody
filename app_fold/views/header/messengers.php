<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php if(!empty($site_info['mes_telegram'])):?>
    <a href="tg://resolve?domain=<?php echo $site_info['mes_telegram']; ?>"><i class="fab fa-telegram-plane" aria-hidden="true"></i></a>
<?php endif;?>
<?php if(!empty($site_info['mes_whatsapp'])):?>
    <a href="whatsapp://send?phone=<?php echo $site_info['mes_whatsapp']; ?>"><i class="fab fa-whatsapp" aria-hidden="true"></i></a>
<?php endif;?>
<?php if(!empty($site_info['mes_viber'])):?>
    <a href="viber://chat?number=<?php echo $site_info['mes_viber']; ?>"><i class="fab fa-viber" aria-hidden="true"></i></a>
<?php endif;?>
