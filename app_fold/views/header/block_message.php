<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<span id="block-message" <?php if (!empty($message)){ echo 'class="show"';}?>>
    <?php if (!empty($message)) :
        echo $message;
    endif;?>
</span>
