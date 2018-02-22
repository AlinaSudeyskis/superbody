<?php
/**
 * Created by Alina Sudeyskis (alina.sudeyskis@gmail.com).
 * Date: 06.07.2017 15:02
 */
?>
<form action="" class="anketa_form" method="post">
    <div class="anketa_form_line parent">
        <div class="anketa_form_h"><div class="anketa_form_h_cell">Вес</div></div>
        <input type="text" name="weight" class="anketa_form_in" placeholder="60" maxlength="6"
               value="<?php if (!empty($user_weight)) {echo $user_weight;}?>"/>
        <div class="anketa_form_desk">кг</div>
    </div>
    <div class="anketa_form_line parent">
        <div class="anketa_form_h"><div class="anketa_form_h_cell">Окружность груди</div></div>
        <input type="text" name="chest" class="anketa_form_in" placeholder="80" maxlength="6"
               value="<?php if (!empty($user_chest)) {echo $user_chest;}?>"/>
        <div class="anketa_form_desk">см</div>
    </div>
    <div class="anketa_form_line parent">
        <div class="anketa_form_h"><div class="anketa_form_h_cell">Окружность талии</div></div>
        <input type="text" name="waist" class="anketa_form_in" placeholder="65" maxlength="6"
               value="<?php if (!empty($user_waist)) {echo $user_waist;}?>"/>
        <div class="anketa_form_desk">см</div>
    </div>
    <div class="anketa_form_line parent">
        <div class="anketa_form_h"><div class="anketa_form_h_cell">Окружность ягодиц</div></div>
        <input type="text" name="buttocks" class="anketa_form_in" placeholder="85" maxlength="6"
               value="<?php if (!empty($user_buttocks)) {echo $user_buttocks;}?>"/>
        <div class="anketa_form_desk">см</div>
    </div>
    <div class="anketa_form_line parent">
        <div class="anketa_form_h"><div class="anketa_form_h_cell">Окружность боков<span>ниже талии, но выше ягодиц</span></div></div>
        <input type="text" name="waist_sides" class="anketa_form_in" placeholder="75" maxlength="6"
               value="<?php if (!empty($user_waist_sides)) {echo $user_waist_sides;}?>"/>
        <div class="anketa_form_desk">см</div>
    </div>
    <div class="anketa_form_line parent">
        <div class="anketa_form_h"><div class="anketa_form_h_cell">Окружность бедра правой ноги</div></div>
        <input type="text" name="right_hip" class="anketa_form_in" placeholder="30" maxlength="6"
               value="<?php if (!empty($user_right_hip)) {echo $user_right_hip;}?>"/>
        <div class="anketa_form_desk">см</div>
    </div>
    <div class="anketa_form_line parent">
        <div class="anketa_form_h"><div class="anketa_form_h_cell">Окружность бедра левой ноги</div></div>
        <input type="text" name="left_hip" class="anketa_form_in" placeholder="30" maxlength="6"
               value="<?php if (!empty($user_left_hip)) {echo $user_left_hip;}?>"/>
        <div class="anketa_form_desk">см</div>
    </div>
    <div class="anketa_form_line parent">
        <div class="anketa_form_h"><div class="anketa_form_h_cell">Окружность бицепса правой руки</div></div>
        <input type="text" name="right_biceps" class="anketa_form_in" placeholder="20" maxlength="6"
               value="<?php if (!empty($user_right_biceps)) {echo $user_right_biceps;}?>"/>
        <div class="anketa_form_desk">см</div>
    </div>
    <div class="anketa_form_line parent">
        <div class="anketa_form_h"><div class="anketa_form_h_cell">Окружность бицепса левой руки</div></div>
        <input type="text" name="left_biceps" class="anketa_form_in" placeholder="20" maxlength="6"
               value="<?php if (!empty($user_left_biceps)) {echo $user_left_biceps;}?>"/>
        <div class="anketa_form_desk">см</div>
    </div>
    <div class="anketa_form_buts_wrap parent">
        <!--<input type="reset" value="Отмена" class="anketa_form_reset"/>-->
        <input type="submit" name="bt_save_anthrop" value="Сохранить" class="anketa_form_but"/>
    </div>
</form>
