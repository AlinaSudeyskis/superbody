<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="anketa_form_line parent">
    <div class="anketa_form_h"><div class="anketa_form_h_cell">Пол</div></div>
    <div class="anketa_form_radio_all parent">
        <div class="anketa_form_radio_wrap">
            <input type="radio" name="gender" class="anketa_form_radio" value="0"
                <?php if(!empty($user_data['user_gender_eng']) and $user_data['user_gender_eng'] == 'male'):?> checked="checked" <?php endif;?> id="gender_male">
            <label for="gender_male">Мужской</label>
        </div>
        <div class="anketa_form_radio_wrap">
            <input type="radio" name="gender" class="anketa_form_radio" value="1"
                <?php if(!empty($user_data['user_gender_eng']) and $user_data['user_gender_eng'] == 'female'):?> checked="checked" <?php endif;?> id="gender_female">
            <label for="gender_female">Женский</label>
        </div>
    </div>
</div>
<div class="anketa_form_line parent">
    <div class="anketa_form_h"><div class="anketa_form_h_cell">Дата рождения</div></div>
    <div class="anketa_form_three_all parent">
        <div class="anketa_form_three_wrap">
            <input type="hidden" name="birthday" id="birthday" value="<?php if(!empty($user_data['user_birthday'])){echo $user_data['user_birthday'];}?>"/>
            <select name="b_day" class="anketa_form_select">
                <option value="">День</option>
                <?php for($i = 1; $i <= 31; $i++): ?>
                    <option value="<?php echo $i; ?>"
                        <?php if (!empty($user_data['user_b_day']) and $user_data['user_b_day'] == $i) :?> selected="selected" <?php endif;?>><?php echo $i; ?></option>
                <?php endfor;?>
                <!--<option value="02"
                    <?php /*if (!empty($user_b_day) and $user_b_day == 2) :*/?> selected="selected" <?php /*endif;*/?>>2</option>
                <option value="03"
                    <?php /*if (!empty($user_b_day) and $user_b_day == 3) :*/?> selected="selected" <?php /*endif;*/?>>3</option>
                <option value="04"
                    <?php /*if (!empty($user_b_day) and $user_b_day == 4) :*/?> selected="selected" <?php /*endif;*/?>>4</option>
                <option value="05"
                    <?php /*if (!empty($user_b_day) and $user_b_day == 5) :*/?> selected="selected" <?php /*endif;*/?>>5</option>
                <option value="06"
                    <?php /*if (!empty($user_b_day) and $user_b_day == 6) :*/?> selected="selected" <?php /*endif;*/?>>6</option>
                <option value="07"
                    <?php /*if (!empty($user_b_day) and $user_b_day == 7) :*/?> selected="selected" <?php /*endif;*/?>>7</option>
                <option value="08"
                    <?php /*if (!empty($user_b_day) and $user_b_day == 8) :*/?> selected="selected" <?php /*endif;*/?>>8</option>
                <option value="09"
                    <?php /*if (!empty($user_b_day) and $user_b_day == 9) :*/?> selected="selected" <?php /*endif;*/?>>9</option>
                <option value="10"
                    <?php /*if (!empty($user_b_day) and $user_b_day == 10) :*/?> selected="selected" <?php /*endif;*/?>>10</option>
                <option value="11"
                    <?php /*if (!empty($user_b_day) and $user_b_day == 11) :*/?> selected="selected" <?php /*endif;*/?>>11</option>
                <option value="12"
                    <?php /*if (!empty($user_b_day) and $user_b_day == 12) :*/?> selected="selected" <?php /*endif;*/?>>12</option>
                <option value="13"
                    <?php /*if (!empty($user_b_day) and $user_b_day == 13) :*/?> selected="selected" <?php /*endif;*/?>>13</option>
                <option value="14"
                    <?php /*if (!empty($user_b_day) and $user_b_day == 14) :*/?> selected="selected" <?php /*endif;*/?>>14</option>
                <option value="15"
                    <?php /*if (!empty($user_b_day) and $user_b_day == 15) :*/?> selected="selected" <?php /*endif;*/?>>15</option>
                <option value="16"
                    <?php /*if (!empty($user_b_day) and $user_b_day == 16) :*/?> selected="selected" <?php /*endif;*/?>>16</option>
                <option value="17"
                    <?php /*if (!empty($user_b_day) and $user_b_day == 17) :*/?> selected="selected" <?php /*endif;*/?>>17</option>
                <option value="18"
                    <?php /*if (!empty($user_b_day) and $user_b_day == 18) :*/?> selected="selected" <?php /*endif;*/?>>18</option>
                <option value="19"
                    <?php /*if (!empty($user_b_day) and $user_b_day == 19) :*/?> selected="selected" <?php /*endif;*/?>>19</option>
                <option value="20"
                    <?php /*if (!empty($user_b_day) and $user_b_day == 20) :*/?> selected="selected" <?php /*endif;*/?>>20</option>
                <option value="21"
                    <?php /*if (!empty($user_b_day) and $user_b_day == 21) :*/?> selected="selected" <?php /*endif;*/?>>21</option>
                <option value="22"
                    <?php /*if (!empty($user_b_day) and $user_b_day == 22) :*/?> selected="selected" <?php /*endif;*/?>>22</option>
                <option value="23"
                    <?php /*if (!empty($user_b_day) and $user_b_day == 23) :*/?> selected="selected" <?php /*endif;*/?>>23</option>
                <option value="24"
                    <?php /*if (!empty($user_b_day) and $user_b_day == 24) :*/?> selected="selected" <?php /*endif;*/?>>24</option>
                <option value="25"
                    <?php /*if (!empty($user_b_day) and $user_b_day == 25) :*/?> selected="selected" <?php /*endif;*/?>>25</option>
                <option value="26"
                    <?php /*if (!empty($user_b_day) and $user_b_day == 26) :*/?> selected="selected" <?php /*endif;*/?>>26</option>
                <option value="27"
                    <?php /*if (!empty($user_b_day) and $user_b_day == 27) :*/?> selected="selected" <?php /*endif;*/?>>27</option>
                <option value="28"
                    <?php /*if (!empty($user_b_day) and $user_b_day == 28) :*/?> selected="selected" <?php /*endif;*/?>>28</option>
                <option value="29"
                    <?php /*if (!empty($user_b_day) and $user_b_day == 29) :*/?> selected="selected" <?php /*endif;*/?>>29</option>
                <option value="30"
                    <?php /*if (!empty($user_b_day) and $user_b_day == 30) :*/?> selected="selected" <?php /*endif;*/?>>30</option>
                <option value="31"
                    <?php /*if (!empty($user_b_day) and $user_b_day == 31) :*/?> selected="selected" <?php /*endif;*/?>>31</option>-->
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
                for ($i = 1960; $i <= $age_limit; $i++) : ?>
                    <option value="<?php echo $i; ?>"
                        <?php if (!empty($user_data['user_b_year']) and $user_data['user_b_year'] == $i) :?> selected="selected" <?php endif;?>><?php echo $i; ?></option>
                <?php endfor;?>
            </select>
        </div>
    </div>
</div>
