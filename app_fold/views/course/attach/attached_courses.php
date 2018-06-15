<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="admin_list">
    <?php foreach ($attached_courses as $attached_course): ?>
        <div class="admin_item parent">
            <div class="admin_ava"></div>
            <div class="admin_cont">
                <div class="admin_name" style="line-height: 35px;"><?php echo $attached_course['name']; ?></div>
            </div>
            <div class="admin_cont f_right">
                <form action="" method="post">
                    <input type="hidden" name="i_course_id" value="<?php echo $attached_course['attached_id']; ?>">
                    <?php if($attached_course['blocked'] == 0): ?>
                        <input type="submit" name="bt_block_attached" value="Блокировать" class="video_admin_form_send" />
                    <?php else: ?>
                        <input type="submit" name="bt_unblock_attached" value="Разблокировать" class="video_admin_form_send" />
                    <?php endif; ?>
                </form>
            </div>
        </div>
    <?php endforeach;
    unset($attached_course);?>
</div>
