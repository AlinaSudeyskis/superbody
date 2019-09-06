<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div id="policy_pop-up">
    <div class="policy_pop-up_cont">
        <div class="policy_pop-up_close"></div>
        <div class="policy_pop-up_h"><?php if (!empty($site_info['personal_data_text'])): echo $site_info['personal_data_text']; endif;?>
            <a href="<?php if (!empty($site_info['personal_data'])): echo $site_info['personal_data']; endif;?>" class="agreement" target="_blank">Политикой обработки персональных данных</a>
        </div>
    </div>
</div><!-- policy_pop-up -->
