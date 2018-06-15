<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="admin_list">
    <?php
    $path = ($page_menu == 'a_courses_w') ? 'course' : 'nutrition';
    foreach ($promocodes as $code) : ?>
        <div class="admin_item emails">
            <a class="admin_feedback_link parent" href="/administration/<?php echo $path; ?>/<?php echo $course_id; ?>/promocode/<?php echo $code['id']; ?>">
                <span class="admin_feedback_time_wrap parent">
                    <span class="admin_feedback_time"><?php echo $code['active_string']; ?></span>
                    <span class="admin_feedback_date"></span>
                </span>
                <span class="admin_feedback_cont parent">
                    <span class="admin_feedback_info parent">
                        <span class="admin_feedback_info_mail"><?php echo $code['code']; ?></span>
                    </span>
                    <span class="admin_feedback_txt"><?php echo $code['name']; ?></span>
                </span>
            </a>
        </div>
    <?php endforeach;
    unset($code);?>
</div>
