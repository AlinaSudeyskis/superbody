<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<ul class="anketa_block_nav parent">
    <li>
        <a href="/administration/sent/emails">
            <span <?php if ($page_submenu == 'sent_emails'): ?> class="anketa_active" <?php endif;?>>Письма пользователям</span>
        </a>
    </li>
    <li>
        <a href="/administration/system/emails">
            <span <?php if ($page_submenu == 'system_emails'): ?> class="anketa_active" <?php endif;?>>Системные письма</span>
        </a>
    </li>
    <li>
        <a href="/administration/emails/addresses">
            <span <?php if ($page_submenu == 'emails_addresses'): ?> class="anketa_active" <?php endif; ?>>Email адреса отправителя</span>
        </a>
    </li>
</ul>