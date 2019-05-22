<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php if(!empty($workout_data['workouts']) and !empty($count_courses)): ?>
    <div class="tc_container">
        <?php foreach ($workout_data['workouts'] as $key => $workout): ?>
            <div class="tc_item" data-woid="<?php echo $workout['id']; ?>">
                <div class="tc_item_title"><?php echo $workout['course']['name']; ?></div>
                <div class="tc_item_img"><img src="<?php echo $workout['course']['image']; ?>"></div>
            </div>
        <?php endforeach;
        unset($workout); ?>
    </div>
<?php endif; ?>