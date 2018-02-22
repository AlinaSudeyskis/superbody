<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="line">
    <div class="input_name">Вес:</div>
    <div class="input_value"><?php if (!empty($user_weight)) { echo $user_weight.' кг'; }?></div>
</div>
<div class="line">
    <div class="input_name">Обхват груди:</div>
    <div class="input_value"><?php if (!empty($user_chest)) { echo $user_chest.' см'; }?></div>
</div>
<div class="line">
    <div class="input_name">Обхват талии:</div>
    <div class="input_value"><?php if (!empty($user_waist)) { echo $user_waist.' см'; }?></div>
</div>
<div class="line">
    <div class="input_name">Обхват ягодиц:</div>
    <div class="input_value"><?php if (!empty($user_buttocks)) { echo $user_buttocks.' см'; }?></div>
</div>
<div class="line">
    <div class="input_name">Обхват боков:</div>
    <div class="input_value"><?php if (!empty($user_waist_sides)) { echo $user_waist_sides.' см'; }?></div>
</div>
<div class="line">
    <div class="input_name">Обхват правого бедра:</div>
    <div class="input_value"><?php if (!empty($user_right_hip)) { echo $user_right_hip.' см'; }?></div>
</div>
<div class="line">
    <div class="input_name">Обхват левого бедра:</div>
    <div class="input_value"><?php if (!empty($user_left_hip)) { echo $user_left_hip.' см'; }?></div>
</div>
<div class="line">
    <div class="input_name">Обхват правого бицепса:</div>
    <div class="input_value"><?php if (!empty($user_right_biceps)) { echo $user_right_biceps.' см'; }?></div>
</div>
<div class="line">
    <div class="input_name">Обхват левого бицепса:</div>
    <div class="input_value"><?php if (!empty($user_left_biceps)) { echo $user_left_biceps.' см'; }?></div>
</div>
