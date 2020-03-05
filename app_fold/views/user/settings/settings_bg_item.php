<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="anketa_form_line parent">
    <div class="anketa_form_h"><div class="anketa_form_h_cell">Пол:</div></div>
    <?php $gender_disabled = (!empty($user_data['user_gender_eng'])) ? 'disabled' : ''; ?>
    <div class="anketa_form_radio_all parent <?php echo $gender_disabled; ?>">
        <div class="anketa_form_radio_wrap">
            <input type="radio" name="gender" class="anketa_form_radio" value="male" id="gender_male"
                <?php if(!empty($user_data['user_gender_eng']) and $user_data['user_gender_eng'] == 'male'):?> checked="checked" <?php endif;?>>
            <label for="gender_male">Мужской</label>
        </div>
        <div class="anketa_form_radio_wrap">
            <input type="radio" name="gender" class="anketa_form_radio" value="female" id="gender_female"
                <?php if(!empty($user_data['user_gender_eng']) and $user_data['user_gender_eng'] == 'female'):?> checked="checked" <?php endif;?>>
            <label for="gender_female">Женский</label>
        </div>
    </div>
</div>
<div class="anketa_form_line parent">
    <div class="anketa_form_h"><div class="anketa_form_h_cell">Дата рождения:</div></div>
    <div class="anketa_form_three_all parent">
        <div class="anketa_form_three_wrap">
            <input type="hidden" name="birthday" id="birthday" value="<?php if(!empty($user_data['user_birthday'])){echo $user_data['user_birthday'];}?>"/>
            <select name="b_day" class="anketa_form_select">
                <option value="">День</option>
                <?php for($i = 1; $i <= 31; $i++): ?>
                    <option value="<?php echo $i; ?>"
                        <?php if (!empty($user_data['user_b_day']) and $user_data['user_b_day'] == $i) :?> selected="selected" <?php endif;?>><?php echo $i; ?></option>
                <?php endfor;
                unset($i); ?>
            </select>
        </div>
        <div class="anketa_form_three_wrap">
            <select name="b_mon" class="anketa_form_select">
                <option value="">Месяц</option>
                <option value="01"
                    <?php if (!empty($user_data['user_b_mon']) and $user_data['user_b_mon'] == 1) :?> selected="selected" <?php endif;?>>Январь</option>
                <option value="02"
                    <?php if (!empty($user_data['user_b_mon']) and $user_data['user_b_mon'] == 2) :?> selected="selected" <?php endif;?>>Февраль</option>
                <option value="03"
                    <?php if (!empty($user_data['user_b_mon']) and $user_data['user_b_mon'] == 3) :?> selected="selected" <?php endif;?>>Март</option>
                <option value="04"
                    <?php if (!empty($user_data['user_b_mon']) and $user_data['user_b_mon'] == 4) :?> selected="selected" <?php endif;?>>Апрель</option>
                <option value="05"
                    <?php if (!empty($user_data['user_b_mon']) and $user_data['user_b_mon'] == 5) :?> selected="selected" <?php endif;?>>Май</option>
                <option value="06"
                    <?php if (!empty($user_data['user_b_mon']) and $user_data['user_b_mon'] == 6) :?> selected="selected" <?php endif;?>>Июнь</option>
                <option value="07"
                    <?php if (!empty($user_data['user_b_mon']) and $user_data['user_b_mon'] == 7) :?> selected="selected" <?php endif;?>>Июль</option>
                <option value="08"
                    <?php if (!empty($user_data['user_b_mon']) and $user_data['user_b_mon'] == 8) :?> selected="selected" <?php endif;?>>Август</option>
                <option value="09"
                    <?php if (!empty($user_data['user_b_mon']) and $user_data['user_b_mon'] == 9) :?> selected="selected" <?php endif;?>>Сентябрь</option>
                <option value="10"
                    <?php if (!empty($user_data['user_b_mon']) and $user_data['user_b_mon'] == 10) :?> selected="selected" <?php endif;?>>Октябрь</option>
                <option value="11"
                    <?php if (!empty($user_data['user_b_mon']) and $user_data['user_b_mon'] == 11) :?> selected="selected" <?php endif;?>>Ноябрь</option>
                <option value="12"
                    <?php if (!empty($user_data['user_b_mon']) and $user_data['user_b_mon'] == 12) :?> selected="selected" <?php endif;?>>Декабрь</option>
            </select>
        </div>
        <div class="anketa_form_three_wrap">
            <select name="b_year" class="anketa_form_select">
                <option value="">Год</option>
                <?php $this_year = date('Y');
                $age_limit = $this_year - 10;
                for ($i = 1940; $i <= $age_limit; $i++) : ?>
                    <option value="<?php echo $i; ?>"
                        <?php if (!empty($user_data['user_b_year']) and $user_data['user_b_year'] == $i) :?> selected="selected" <?php endif;?>><?php echo $i; ?></option>
                <?php endfor;?>
            </select>
        </div>
    </div>
</div>
