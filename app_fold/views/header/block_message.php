<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<span id="block-message" <?php if (!empty($message) and !empty($message_type)){ echo 'class="show '.$message_type.'"';}?>>
    <?php if (!empty($message)) :
        echo $message;
    endif;?>
</span>
