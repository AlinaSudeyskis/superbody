<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="content_block new_content_block">
    <div class="content_block_h new_content_block_h parent">
        <h3>Данные входа</h3>
    </div>
    <div class="kurs_block_val">
        <div class="anketa_block_cont">
            <!--<div class="admin_list">-->
                <?php if(!empty($auth_data)): ?>
                    <?php foreach($auth_data as $ad): ?>
                        <div class="admin_item promocodes">
                            <span class="admin_feedback_link parent">
                                <span class="admin_feedback_cont parent">
                                    <span class="admin_feedback_info parent"><?php echo $ad['date']; ?></span>
                                    <span class="admin_feedback_txt"><?php echo $ad['ip']; ?></span>
                                    <span class="admin_feedback_txt" style="text-decoration: none;"><?php echo $ad['agent']; ?></span>
                                </span>
                                    <span class="admin_feedback_time_wrap parent">
                                    <span class="admin_feedback_time"><?php echo $ad['method']; ?> <?php echo $ad['region']; ?></span>
                                </span>
                            </span>
                        </div>
                    <?php endforeach;
                    unset($ad); ?>
                <?php endif; ?>
            <!--</div>-->
        </div>
    </div>
</div><!-- content_col -->
