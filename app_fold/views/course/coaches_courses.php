<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="content_block new_content_block">
    <div class="content_block_h new_content_block_h parent">
        <h3>Курсы тренера</h3>
        <div class="content_block_h_buts">
            <div class="content_block_h_slide kurs_slide"></div>
            <div class="content_block_h_close"></div>
        </div>
    </div>
    <div class="kurs_block_val">
        <?php if (!empty($courses)) :?>
            <div class="admin_list">
                <?php foreach ($courses as $course): ?>
                    <div class="admin_item parent">
                        <div class="admin_cont">
                            <div class="admin_name">
                                <a href="/course/<?php echo $course['course_id']; ?>"><?php echo $course['name']; ?></a>
                            </div>
                        </div>
                    </div>
                <?php endforeach;
                unset($course);?>
            </div>
            <?php include_once('./app_fold/views/pagination.php');?>
        <?php else: ?>
            <h3 class="info">Информация не найдена</h3>
        <?php endif; ?>
    </div>
</div>