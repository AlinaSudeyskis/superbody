<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//$user_notification = null;
if(!empty($course_notification)):?>
    <div class="content_block new_content_block notifications_block_wrap">
        <div class="content_block_h parent">
            <h3>Уведомление</h3>
            <div class="content_block_h_buts">
                <div class="content_block_h_slide kurs_slide"></div>
                <div class="content_block_h_close"></div>
            </div>
        </div>
        <div class="kurs_block_val">
            <?php
            $notif_block_h    = '';
            $h3_info          = '';
            $course_blocked   = false;

            // Уведомления курсов
            if(!empty($course_notification)):
                $h3_info         = '';
                $course_blocked  = false;

                foreach($course_notification as $user_course_id => $notif):
                    if(is_numeric($user_course_id) and (!empty($notif['course_blocked']) or !empty($notif['course_ends']))):
                        // Курс заморожен (оплата не прошла)
                        if(!empty($notif['course_blocked'])):
                            $course_blocked      = true;
                            $course_blocked_info = $notif['course_blocked']['text'];
                            $course_blocked_reason = $notif['course_blocked']['addition_text'];
                            include('notification_block.php');
                            $course_blocked      = false;
                        endif;
                    endif;
                endforeach;
                unset($notif);
                unset($user_course_id);
            endif;?>
        </div>
    </div>
<?php endif; ?>
