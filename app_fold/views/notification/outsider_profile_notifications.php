<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//$user_notification = null;
if(!empty($user_notification) or !empty($course_notification)):?>
    <div class="content_block new_content_block notifications_block_wrap">
        <div class="content_block_h parent">
            <h3>Уведомления</h3>
            <div class="content_block_h_buts">
                <div class="content_block_h_slide kurs_slide"></div>
                <div class="content_block_h_close"></div>
            </div>
        </div>
        <div class="kurs_block_val notifications_block">
            <?php
            $h3_info = '';

            // Не указан email
            if(!empty($user_notification['empty_email'])):
                $h3_info = $user_notification['empty_email']['text'];
                include('notification_block.php');
            endif;
            // Не активирован аккаунт
            if(!empty($user_notification['not_activated'])):
                $h3_info = $user_notification['not_activated']['text'];
                include('notification_block.php');
            endif;
            // Аккаунт пользователя заблокирован
            if(!empty($user_notification['blocked'])):
                $h3_info = $user_notification['blocked']['text'];
                include('notification_block.php');
            endif;?>
        </div>
    </div>
<?php endif; ?>
