<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php if(!empty($user_anthrop_data)): ?>
    <div class="line">
        <div class="input_name">Вес:</div>
        <div class="input_value"><?php echo $user_anthrop_data['user_weight'].' кг'; ?></div>
    </div>
    <div class="line">
        <div class="input_name">Обхват груди:</div>
        <div class="input_value"><?php echo $user_anthrop_data['user_chest'].' см'; ?></div>
    </div>
    <div class="line">
        <div class="input_name">Обхват талии:</div>
        <div class="input_value"><?php echo $user_anthrop_data['user_waist'].' см'; ?></div>
    </div>
    <div class="line">
        <div class="input_name">Обхват ягодиц:</div>
        <div class="input_value"><?php echo $user_anthrop_data['user_buttocks'].' см'; ?></div>
    </div>
    <div class="line">
        <div class="input_name">Обхват боков:</div>
        <div class="input_value"><?php echo $user_anthrop_data['user_waist_sides'].' см'; ?></div>
    </div>
    <div class="line">
        <div class="input_name">Обхват правого бедра:</div>
        <div class="input_value"><?php echo $user_anthrop_data['user_right_hip'].' см'; ?></div>
    </div>
    <div class="line">
        <div class="input_name">Обхват левого бедра:</div>
        <div class="input_value"><?php echo $user_anthrop_data['user_left_hip'].' см'; ?></div>
    </div>
    <div class="line">
        <div class="input_name">Обхват правого бицепса:</div>
        <div class="input_value"><?php echo $user_anthrop_data['user_right_biceps'].' см'; ?></div>
    </div>
    <div class="line">
        <div class="input_name">Обхват левого бицепса:</div>
        <div class="input_value"><?php echo $user_anthrop_data['user_left_biceps'].' см'; ?></div>
    </div>
<?php else: ?>
    <h3 class="info">Пользователь не ввёл информацию</h3>
<?php endif; ?>
