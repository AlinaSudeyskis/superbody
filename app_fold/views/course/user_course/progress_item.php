<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="calendar_prof_item">
    <div class="calendar_prog_title">
        <?php if(!empty($outsider)): ?>
            <span><?php echo $course['name']; ?></span>
        <?php else: ?>
            <a href="/profile/course/<?php echo $course['id']; ?>"><?php echo $course['name']; ?></a>
        <?php endif; ?>
    </div>
    <div class="progress-pie-chart" data-percent="57">
        <div class="ppc-progress">
            <div class="ppc-progress-fill" style="transform: rotate(<?php echo $deg; ?>deg); background-color: rgb(<?php echo $course['color_done']; ?>);"></div>
        </div>
        <div class="ppc-percents">
            <div class="pcc-percents-wrapper">
                <span><?php echo $crs_percent_done; ?>%</span>
            </div>
        </div>
    </div>
    <?php if(empty($outsider)): ?>
        <div class="oi_d_link">
            <?php if(empty($course['order']['payment_status_eng']) or $course['order']['payment_status_eng'] == 'pending' or $course['order']['payment_status_eng'] == 'not_paid' or
                $course['order']['payment_status_eng'] == 'canceled' or $course['order']['payment_status_eng'] == 'revoke_permission'): ?>
                <a href="#" class="buy_course" data-cid="<?php echo $course['course_id']; ?>" data-oid="<?php echo $course['order']['id']; ?>" data-ucid="<?php echo $course['id']; ?>">Оплатить</a>
            <?php else: ?>
                <?php $calendar_active = ($course['display'] == 0) ? 'active' : ''; ?>
                <?php if($course['category'] == 'workout' or $course['category'] == 'nutrition'): ?>
                    <a href="#" class="calendar_course <?php echo $calendar_active; ?>" data-crsid="<?php echo $course['id']; ?>"><?php if($course['display'] == 0): ?>Добавить в календарь<?php else: ?>Удалить из календаря<?php endif; ?></a>
                <?php endif;?>
            <?php endif;?>
        </div>
    <?php endif; ?>
</div>
