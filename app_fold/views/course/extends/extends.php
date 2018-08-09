<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="admin_list">
    <?php foreach ($extends as $extend_course): ?>
        <div class="admin_item parent">
            <div class="admin_ava"></div>
            <div class="admin_cont">
                <div class="admin_name">
                    <a href="/administration/course/<?php echo $course_id; ?>/extend/<?php echo $extend_course['extend_id']; ?>">
                        <?php echo $extend_course['extend_name']; ?>
                    </a>
                </div>
            </div>
        </div>
    <?php endforeach;
    unset($extend_course);?>
</div>
