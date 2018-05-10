<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<ul class="anketa_block_nav parent">
    <li>
        <a href="/administration/emails">
            <span <?php if ($page_submenu == 'emails'): ?> class="anketa_active" <?php endif;?>>Письма</span>
        </a>
    </li>
    <li>
        <a href="/administration/emails/addresses">
            <span <?php if ($page_submenu == 'emails_addresses'): ?> class="anketa_active" <?php endif; ?>>Email адреса</span>
        </a>
    </li>
</ul>