<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$country_code = (!empty($country_code)) ? $country_code : '';
?>
<select name="country" id="country" class="anketa_form_select" tabindex="0">
    <option value="AU" <?php if($country_code == 'AU'): ?>selected="selected"<?php endif; ?>>Австралия (+61)</option>
    <option value="AT" <?php if($country_code == 'AT'): ?>selected="selected"<?php endif; ?>>Австрия (+43)</option>
    <option value="AZ" <?php if($country_code == 'AZ'): ?>selected="selected"<?php endif; ?>>Азербайджан (+994)</option>
    <option value="AL" <?php if($country_code == 'AL'): ?>selected="selected"<?php endif; ?>>Албания (+355)</option>
    <option value="DZ" <?php if($country_code == 'DZ'): ?>selected="selected"<?php endif; ?>>Алжир (+213)</option>
    <option value="VI" <?php if($country_code == 'VI'): ?>selected="selected"<?php endif; ?>>Американские Виргинские острова (+1)</option>
    <option value="AI" <?php if($country_code == 'AI'): ?>selected="selected"<?php endif; ?>>Ангилья (+1)</option>
    <option value="AO" <?php if($country_code == 'AO'): ?>selected="selected"<?php endif; ?>>Ангола (+244)</option>
    <option value="AD" <?php if($country_code == 'AD'): ?>selected="selected"<?php endif; ?>>Андорра (+376)</option>
    <option value="AG" <?php if($country_code == 'AG'): ?>selected="selected"<?php endif; ?>>Антигуа (+1)</option>
    <option value="AR" <?php if($country_code == 'AR'): ?>selected="selected"<?php endif; ?>>Аргентина (+54)</option>
    <option value="AM" <?php if($country_code == 'AM'): ?>selected="selected"<?php endif; ?>>Армения (+374)</option>
    <option value="AW" <?php if($country_code == 'AW'): ?>selected="selected"<?php endif; ?>>Аруба (+297)</option>
    <option value="AF" <?php if($country_code == 'AF'): ?>selected="selected"<?php endif; ?>>Афганистан (+93)</option>
    <option value="BS" <?php if($country_code == 'BS'): ?>selected="selected"<?php endif; ?>>Багамские острова (+1)</option>
    <option value="BD" <?php if($country_code == 'BD'): ?>selected="selected"<?php endif; ?>>Бангладеш (+880)</option>
    <option value="BB" <?php if($country_code == 'BB'): ?>selected="selected"<?php endif; ?>>Барбадос (+1)</option>
    <option value="BH" <?php if($country_code == 'BH'): ?>selected="selected"<?php endif; ?>>Бахрейн (+973)</option>
    <option value="BY" <?php if($country_code == 'BY'): ?>selected="selected"<?php endif; ?>>Беларусь (+375)</option>
    <option value="BZ" <?php if($country_code == 'BZ'): ?>selected="selected"<?php endif; ?>>Белиз (+501)</option>
    <option value="BE" <?php if($country_code == 'BE'): ?>selected="selected"<?php endif; ?>>Бельгия (+32)</option>
    <option value="BJ" <?php if($country_code == 'BJ'): ?>selected="selected"<?php endif; ?>>Бенин (+229)</option>
    <option value="BM" <?php if($country_code == 'BM'): ?>selected="selected"<?php endif; ?>>Бермудские Острова (+1)</option>
    <option value="BG" <?php if($country_code == 'BG'): ?>selected="selected"<?php endif; ?>>Болгария (+359)</option>
    <option value="BO" <?php if($country_code == 'BO'): ?>selected="selected"<?php endif; ?>>Боливия (+591)</option>
    <option value="BQ" <?php if($country_code == 'BQ'): ?>selected="selected"<?php endif; ?>>Бонайре, Синт-Эстатиус и Саба (+599)</option>
    <option value="BA" <?php if($country_code == 'BA'): ?>selected="selected"<?php endif; ?>>Босния и Герцеговина (+387)</option>
    <option value="BW" <?php if($country_code == 'BW'): ?>selected="selected"<?php endif; ?>>Ботсвана (+267)</option>
    <option value="BR" <?php if($country_code == 'BR'): ?>selected="selected"<?php endif; ?>>Бразилия (+55)</option>
    <option value="IO" <?php if($country_code == 'IO'): ?>selected="selected"<?php endif; ?>>Британская территория в Индийском океане. (+246)</option>
    <option value="VG" <?php if($country_code == 'VG'): ?>selected="selected"<?php endif; ?>>Британские Виргинские острова (+1)</option>
    <option value="BN" <?php if($country_code == 'BN'): ?>selected="selected"<?php endif; ?>>Бруней (+673)</option>
    <option value="BF" <?php if($country_code == 'BF'): ?>selected="selected"<?php endif; ?>>Буркина-Фасо (+226)</option>
    <option value="BI" <?php if($country_code == 'BI'): ?>selected="selected"<?php endif; ?>>Бурунди (+257)</option>
    <option value="BT" <?php if($country_code == 'BT'): ?>selected="selected"<?php endif; ?>>Бутан (+975)</option>
    <option value="VU" <?php if($country_code == 'VU'): ?>selected="selected"<?php endif; ?>>Вануату (+678)</option>
    <option value="HU" <?php if($country_code == 'HU'): ?>selected="selected"<?php endif; ?>>Венгрия (+36)</option>
    <option value="VE" <?php if($country_code == 'VE'): ?>selected="selected"<?php endif; ?>>Венесуэла (+58)</option>
    <option value="AS" <?php if($country_code == 'AS'): ?>selected="selected"<?php endif; ?>>Восточное Самоа (+1)</option>
    <option value="TL" <?php if($country_code == 'TL'): ?>selected="selected"<?php endif; ?>>Восточный Тимор (+670)</option>
    <option value="VN" <?php if($country_code == 'VN'): ?>selected="selected"<?php endif; ?>>Вьетнам (+84)</option>
    <option value="GA" <?php if($country_code == 'GA'): ?>selected="selected"<?php endif; ?>>Габон (+241)</option>
    <option value="HT" <?php if($country_code == 'HT'): ?>selected="selected"<?php endif; ?>>Гаити (+509)</option>
    <option value="GY" <?php if($country_code == 'GY'): ?>selected="selected"<?php endif; ?>>Гайана (+592)</option>
    <option value="GM" <?php if($country_code == 'GM'): ?>selected="selected"<?php endif; ?>>Гамбия (+220)</option>
    <option value="GH" <?php if($country_code == 'GH'): ?>selected="selected"<?php endif; ?>>Гана (+233)</option>
    <option value="GP" <?php if($country_code == 'GP'): ?>selected="selected"<?php endif; ?>>Гваделупа (+590)</option>
    <option value="GT" <?php if($country_code == 'GT'): ?>selected="selected"<?php endif; ?>>Гватемала (+502)</option>
    <option value="GN" <?php if($country_code == 'GN'): ?>selected="selected"<?php endif; ?>>Гвинея (+224)</option>
    <option value="GW" <?php if($country_code == 'GW'): ?>selected="selected"<?php endif; ?>>Гвинея-Бисау (+245)</option>
    <option value="DE" <?php if($country_code == 'DE'): ?>selected="selected"<?php endif; ?>>Германия (+49)</option>
    <option value="GG" <?php if($country_code == 'GG'): ?>selected="selected"<?php endif; ?>>Гернси (+44)</option>
    <option value="GI" <?php if($country_code == 'GI'): ?>selected="selected"<?php endif; ?>>Гибралтар (+350)</option>
    <option value="HN" <?php if($country_code == 'HN'): ?>selected="selected"<?php endif; ?>>Гондурас (+504)</option>
    <option value="HK" <?php if($country_code == 'HK'): ?>selected="selected"<?php endif; ?>>Гонконг (+852)</option>
    <option value="VA" <?php if($country_code == 'VA'): ?>selected="selected"<?php endif; ?>>Государство Ватикан (+39)</option>
    <option value="GD" <?php if($country_code == 'GD'): ?>selected="selected"<?php endif; ?>>Гренада (+1)</option>
    <option value="GL" <?php if($country_code == 'GL'): ?>selected="selected"<?php endif; ?>>Гренландия (+299)</option>
    <option value="GR" <?php if($country_code == 'GR'): ?>selected="selected"<?php endif; ?>>Греция (+30)</option>
    <option value="GE" <?php if($country_code == 'GE'): ?>selected="selected"<?php endif; ?>>Грузия (+995)</option>
    <option value="GU" <?php if($country_code == 'GU'): ?>selected="selected"<?php endif; ?>>Гуам (+1)</option>
    <option value="DK" <?php if($country_code == 'DK'): ?>selected="selected"<?php endif; ?>>Дания (+45)</option>
    <option value="CD" <?php if($country_code == 'CD'): ?>selected="selected"<?php endif; ?>>Демократическая Республика Конго (+243)</option>
    <option value="JE" <?php if($country_code == 'JE'): ?>selected="selected"<?php endif; ?>>Джерси (+44)</option>
    <option value="DJ" <?php if($country_code == 'DJ'): ?>selected="selected"<?php endif; ?>>Джибути (+253)</option>
    <option value="DO" <?php if($country_code == 'DO'): ?>selected="selected"<?php endif; ?>>Доминиаканская Республика (+1)</option>
    <option value="DM" <?php if($country_code == 'DM'): ?>selected="selected"<?php endif; ?>>Доминика (+1)</option>
    <option value="EG" <?php if($country_code == 'EG'): ?>selected="selected"<?php endif; ?>>Египет (+20)</option>
    <option value="ZM" <?php if($country_code == 'ZM'): ?>selected="selected"<?php endif; ?>>Замбия (+260)</option>
    <option value="EH" <?php if($country_code == 'EH'): ?>selected="selected"<?php endif; ?>>Западная Сахара (+212)</option>
    <option value="ZW" <?php if($country_code == 'ZW'): ?>selected="selected"<?php endif; ?>>Зимбабве (+263)</option>
    <option value="IL" <?php if($country_code == 'IL'): ?>selected="selected"<?php endif; ?>>Израиль (+972)</option>
    <option value="IN" <?php if($country_code == 'IN'): ?>selected="selected"<?php endif; ?>>Индия (+91)</option>
    <option value="ID" <?php if($country_code == 'ID'): ?>selected="selected"<?php endif; ?>>Индонезия (+62)</option>
    <option value="JO" <?php if($country_code == 'JO'): ?>selected="selected"<?php endif; ?>>Иордания (+962)</option>
    <option value="IQ" <?php if($country_code == 'IQ'): ?>selected="selected"<?php endif; ?>>Ирак (+964)</option>
    <option value="IR" <?php if($country_code == 'IR'): ?>selected="selected"<?php endif; ?>>Иран (+98)</option>
    <option value="IE" <?php if($country_code == 'IE'): ?>selected="selected"<?php endif; ?>>Ирландия (+353)</option>
    <option value="IS" <?php if($country_code == 'IS'): ?>selected="selected"<?php endif; ?>>Исландия (+354)</option>
    <option value="ES" <?php if($country_code == 'ES'): ?>selected="selected"<?php endif; ?>>Испания (+34)</option>
    <option value="IT" <?php if($country_code == 'IT'): ?>selected="selected"<?php endif; ?>>Италия (+39)</option>
    <option value="YE" <?php if($country_code == 'YE'): ?>selected="selected"<?php endif; ?>>Йемен (+967)</option>
    <option value="CV" <?php if($country_code == 'CV'): ?>selected="selected"<?php endif; ?>>Кабо-Верде (+238)</option>
    <option value="KZ" <?php if($country_code == 'KZ'): ?>selected="selected"<?php endif; ?>>Казахстан (+7)</option>
    <option value="KY" <?php if($country_code == 'KY'): ?>selected="selected"<?php endif; ?>>Каймановы острова (+1)</option>
    <option value="KH" <?php if($country_code == 'KH'): ?>selected="selected"<?php endif; ?>>Камбоджа (+855)</option>
    <option value="CM" <?php if($country_code == 'CM'): ?>selected="selected"<?php endif; ?>>Камерун (+237)</option>
    <option value="CA" <?php if($country_code == 'CA'): ?>selected="selected"<?php endif; ?>>Канада (+1)</option>
    <option value="QA" <?php if($country_code == 'QA'): ?>selected="selected"<?php endif; ?>>Катар (+974)</option>
    <option value="KE" <?php if($country_code == 'KE'): ?>selected="selected"<?php endif; ?>>Кения (+254)</option>
    <option value="CY" <?php if($country_code == 'CY'): ?>selected="selected"<?php endif; ?>>Кипр (+357)</option>
    <option value="KG" <?php if($country_code == 'KG'): ?>selected="selected"<?php endif; ?>>Киргизия (+996)</option>
    <option value="KI" <?php if($country_code == 'KI'): ?>selected="selected"<?php endif; ?>>Кирибати (+686)</option>
    <option value="CN" <?php if($country_code == 'CN'): ?>selected="selected"<?php endif; ?>>Китай (+86)</option>
    <option value="CO" <?php if($country_code == 'CO'): ?>selected="selected"<?php endif; ?>>Колумбия (+57)</option>
    <option value="KM" <?php if($country_code == 'KM'): ?>selected="selected"<?php endif; ?>>Коморские острова (+269)</option>
    <option value="XK" <?php if($country_code == 'XK'): ?>selected="selected"<?php endif; ?>>Косово (+381)</option>
    <option value="CR" <?php if($country_code == 'CR'): ?>selected="selected"<?php endif; ?>>Коста-Рика (+506)</option>
    <option value="CI" <?php if($country_code == 'CI'): ?>selected="selected"<?php endif; ?>>Кот д'Ивуар (+225)</option>
    <option value="CU" <?php if($country_code == 'CU'): ?>selected="selected"<?php endif; ?>>Куба (+53)</option>
    <option value="KW" <?php if($country_code == 'KW'): ?>selected="selected"<?php endif; ?>>Кувейт (+965)</option>
    <option value="CW" <?php if($country_code == 'CW'): ?>selected="selected"<?php endif; ?>>Кюрасао (+599)</option>
    <option value="LA" <?php if($country_code == 'LA'): ?>selected="selected"<?php endif; ?>>Лаос (+856)</option>
    <option value="LV" <?php if($country_code == 'LV'): ?>selected="selected"<?php endif; ?>>Латвия (+371)</option>
    <option value="LS" <?php if($country_code == 'LS'): ?>selected="selected"<?php endif; ?>>Лесото (+266)</option>
    <option value="LR" <?php if($country_code == 'LR'): ?>selected="selected"<?php endif; ?>>Либерия (+231)</option>
    <option value="LB" <?php if($country_code == 'LB'): ?>selected="selected"<?php endif; ?>>Ливан (+961)</option>
    <option value="LY" <?php if($country_code == 'LY'): ?>selected="selected"<?php endif; ?>>Ливия (+218)</option>
    <option value="LT" <?php if($country_code == 'LT'): ?>selected="selected"<?php endif; ?>>Литва (+370)</option>
    <option value="LI" <?php if($country_code == 'LI'): ?>selected="selected"<?php endif; ?>>Лихтеншетйн (+423)</option>
    <option value="LU" <?php if($country_code == 'LU'): ?>selected="selected"<?php endif; ?>>Люксембург (+352)</option>
    <option value="MU" <?php if($country_code == 'MU'): ?>selected="selected"<?php endif; ?>>Маврикий (+230)</option>
    <option value="MR" <?php if($country_code == 'MR'): ?>selected="selected"<?php endif; ?>>Мавритания (+222)</option>
    <option value="MG" <?php if($country_code == 'MG'): ?>selected="selected"<?php endif; ?>>Мадагаскар (+261)</option>
    <option value="YT" <?php if($country_code == 'YT'): ?>selected="selected"<?php endif; ?>>Майотта (+262)</option>
    <option value="MO" <?php if($country_code == 'MO'): ?>selected="selected"<?php endif; ?>>Макао (+853)</option>
    <option value="MK" <?php if($country_code == 'MK'): ?>selected="selected"<?php endif; ?>>Македония (+389)</option>
    <option value="MW" <?php if($country_code == 'MW'): ?>selected="selected"<?php endif; ?>>Малави (+265)</option>
    <option value="MY" <?php if($country_code == 'MY'): ?>selected="selected"<?php endif; ?>>Малайзия (+60)</option>
    <option value="ML" <?php if($country_code == 'ML'): ?>selected="selected"<?php endif; ?>>Мали (+223)</option>
    <option value="MV" <?php if($country_code == 'MV'): ?>selected="selected"<?php endif; ?>>Мальдивы (+960)</option>
    <option value="MT" <?php if($country_code == 'MT'): ?>selected="selected"<?php endif; ?>>Мальта (+356)</option>
    <option value="MQ" <?php if($country_code == 'MQ'): ?>selected="selected"<?php endif; ?>>Мартиника (+596)</option>
    <option value="MH" <?php if($country_code == 'MH'): ?>selected="selected"<?php endif; ?>>Маршалловы острова (+692)</option>
    <option value="MX" <?php if($country_code == 'MX'): ?>selected="selected"<?php endif; ?>>Мексика (+52)</option>
    <option value="MZ" <?php if($country_code == 'MZ'): ?>selected="selected"<?php endif; ?>>Мозамбик (+258)</option>
    <option value="MD" <?php if($country_code == 'MD'): ?>selected="selected"<?php endif; ?>>Молдавия (+373)</option>
    <option value="MC" <?php if($country_code == 'MC'): ?>selected="selected"<?php endif; ?>>Монако (+377)</option>
    <option value="MN" <?php if($country_code == 'MN'): ?>selected="selected"<?php endif; ?>>Монголия (+976)</option>
    <option value="MS" <?php if($country_code == 'MS'): ?>selected="selected"<?php endif; ?>>Монтсеррат (+1)</option>
    <option value="MA" <?php if($country_code == 'MA'): ?>selected="selected"<?php endif; ?>>Морокко (+212)</option>
    <option value="MM" <?php if($country_code == 'MM'): ?>selected="selected"<?php endif; ?>>Мьянма (+95)</option>
    <option value="NA" <?php if($country_code == 'NA'): ?>selected="selected"<?php endif; ?>>Намибия (+264)</option>
    <option value="NR" <?php if($country_code == 'NR'): ?>selected="selected"<?php endif; ?>>Науру (+674)</option>
    <option value="NP" <?php if($country_code == 'NP'): ?>selected="selected"<?php endif; ?>>Непал (+977)</option>
    <option value="NE" <?php if($country_code == 'NE'): ?>selected="selected"<?php endif; ?>>Нигер (+227)</option>
    <option value="NG" <?php if($country_code == 'NG'): ?>selected="selected"<?php endif; ?>>Нигерия (+234)</option>
    <option value="NL" <?php if($country_code == 'NL'): ?>selected="selected"<?php endif; ?>>Нидерланды (+31)</option>
    <option value="NI" <?php if($country_code == 'NI'): ?>selected="selected"<?php endif; ?>>Никарагуа (+505)</option>
    <option value="NU" <?php if($country_code == 'NU'): ?>selected="selected"<?php endif; ?>>Ниуэ (+683)</option>
    <option value="NZ" <?php if($country_code == 'NZ'): ?>selected="selected"<?php endif; ?>>Новая Зеландия (+64)</option>
    <option value="NC" <?php if($country_code == 'NC'): ?>selected="selected"<?php endif; ?>>Новая Каледония (+687)</option>
    <option value="NO" <?php if($country_code == 'NO'): ?>selected="selected"<?php endif; ?>>Норвегия (+47)</option>
    <option value="AE" <?php if($country_code == 'AE'): ?>selected="selected"<?php endif; ?>>Объединенные Арабские Эмираты (+971)</option>
    <option value="OM" <?php if($country_code == 'OM'): ?>selected="selected"<?php endif; ?>>Оман (+968)</option>
    <option value="IM" <?php if($country_code == 'IM'): ?>selected="selected"<?php endif; ?>>Остров Мэн (+44)</option>
    <option value="NF" <?php if($country_code == 'NF'): ?>selected="selected"<?php endif; ?>>Остров Норфолк (+672)</option>
    <option value="SH" <?php if($country_code == 'SH'): ?>selected="selected"<?php endif; ?>>Остров Святой Елены (+290)</option>
    <option value="CK" <?php if($country_code == 'CK'): ?>selected="selected"<?php endif; ?>>Острова Кука (+682)</option>
    <option value="TC" <?php if($country_code == 'TC'): ?>selected="selected"<?php endif; ?>>Острова Теркс и Кайкос (+1)</option>
    <option value="PK" <?php if($country_code == 'PK'): ?>selected="selected"<?php endif; ?>>Пакистан (+92)</option>
    <option value="PW" <?php if($country_code == 'PW'): ?>selected="selected"<?php endif; ?>>Палау (+680)</option>
    <option value="PS" <?php if($country_code == 'PS'): ?>selected="selected"<?php endif; ?>>Палестина (+970)</option>
    <option value="PA" <?php if($country_code == 'PA'): ?>selected="selected"<?php endif; ?>>Панама (+507)</option>
    <option value="PG" <?php if($country_code == 'PG'): ?>selected="selected"<?php endif; ?>>Папуа – Новая Гвинея (+675)</option>
    <option value="PY" <?php if($country_code == 'PY'): ?>selected="selected"<?php endif; ?>>Парагвай (+595)</option>
    <option value="PE" <?php if($country_code == 'PE'): ?>selected="selected"<?php endif; ?>>Перу (+51)</option>
    <option value="PL" <?php if($country_code == 'PL'): ?>selected="selected"<?php endif; ?>>Польша (+48)</option>
    <option value="PT" <?php if($country_code == 'PT'): ?>selected="selected"<?php endif; ?>>Португалия (+351)</option>
    <option value="PR" <?php if($country_code == 'PR'): ?>selected="selected"<?php endif; ?>>Пуэрто-Рико (+1)</option>
    <option value="CG" <?php if($country_code == 'CG'): ?>selected="selected"<?php endif; ?>>Республика Конго (+242)</option>
    <option value="RE" <?php if($country_code == 'RE'): ?>selected="selected"<?php endif; ?>>Реюньон (+262)</option>
    <option value="RU" <?php if($country_code == 'RU'): ?>selected="selected"<?php endif; ?>>Россия (+7)</option>
    <option value="RW" <?php if($country_code == 'RW'): ?>selected="selected"<?php endif; ?>>Руанда (+250)</option>
    <option value="RO" <?php if($country_code == 'RO'): ?>selected="selected"<?php endif; ?>>Румыния (+40)</option>
    <option value="SV" <?php if($country_code == 'SV'): ?>selected="selected"<?php endif; ?>>Сальвадор (+503)</option>
    <option value="WS" <?php if($country_code == 'WS'): ?>selected="selected"<?php endif; ?>>Самоа (+685)</option>
    <option value="SM" <?php if($country_code == 'SM'): ?>selected="selected"<?php endif; ?>>Сан-Марино (+378)</option>
    <option value="ST" <?php if($country_code == 'ST'): ?>selected="selected"<?php endif; ?>>Сан-Томе и Принсипи (+239)</option>
    <option value="SA" <?php if($country_code == 'SA'): ?>selected="selected"<?php endif; ?>>Саудовская Аравия (+966)</option>
    <option value="SZ" <?php if($country_code == 'SZ'): ?>selected="selected"<?php endif; ?>>Свазиленд (+268)</option>
    <option value="KP" <?php if($country_code == 'KP'): ?>selected="selected"<?php endif; ?>>Северная Корея (+850)</option>
    <option value="MP" <?php if($country_code == 'MP'): ?>selected="selected"<?php endif; ?>>Северные Марианские острова (+1)</option>
    <option value="SC" <?php if($country_code == 'SC'): ?>selected="selected"<?php endif; ?>>Сейшелы (+248)</option>
    <option value="BL" <?php if($country_code == 'BL'): ?>selected="selected"<?php endif; ?>>Сен-Бартельми (+590)</option>
    <option value="VC" <?php if($country_code == 'VC'): ?>selected="selected"<?php endif; ?>>Сен-Винсент и Гренадины (+1)</option>
    <option value="MF" <?php if($country_code == 'MF'): ?>selected="selected"<?php endif; ?>>Сен-Мартен (+590)</option>
    <option value="PM" <?php if($country_code == 'PM'): ?>selected="selected"<?php endif; ?>>Сен-Пьер и Микелон (+508)</option>
    <option value="SN" <?php if($country_code == 'SN'): ?>selected="selected"<?php endif; ?>>Сенегал (+221)</option>
    <option value="KN" <?php if($country_code == 'KN'): ?>selected="selected"<?php endif; ?>>Сент-Китс и Невис (+1)</option>
    <option value="LC" <?php if($country_code == 'LC'): ?>selected="selected"<?php endif; ?>>Сент-Люсия (+1)</option>
    <option value="SX" <?php if($country_code == 'SX'): ?>selected="selected"<?php endif; ?>>Сент-Маартен (+599)</option>
    <option value="RS" <?php if($country_code == 'RS'): ?>selected="selected"<?php endif; ?>>Сербия (+381)</option>
    <option value="SG" <?php if($country_code == 'SG'): ?>selected="selected"<?php endif; ?>>Сингапур (+65)</option>
    <option value="SY" <?php if($country_code == 'SY'): ?>selected="selected"<?php endif; ?>>Сирия (+963)</option>
    <option value="SK" <?php if($country_code == 'SK'): ?>selected="selected"<?php endif; ?>>Словакия (+421)</option>
    <option value="SI" <?php if($country_code == 'SI'): ?>selected="selected"<?php endif; ?>>Словения (+386)</option>
    <option value="GB" <?php if($country_code == 'GB'): ?>selected="selected"<?php endif; ?>>Соединенное Королевство (+44)</option>
    <option value="SB" <?php if($country_code == 'SB'): ?>selected="selected"<?php endif; ?>>Соломоновы острова (+677)</option>
    <option value="SO" <?php if($country_code == 'SO'): ?>selected="selected"<?php endif; ?>>Сомали (+252)</option>
    <option value="SD" <?php if($country_code == 'SD'): ?>selected="selected"<?php endif; ?>>Судан (+249)</option>
    <option value="SR" <?php if($country_code == 'SR'): ?>selected="selected"<?php endif; ?>>Суринам (+597)</option>
    <option value="US" <?php if($country_code == 'US'): ?>selected="selected"<?php endif; ?>>США (+1)</option>
    <option value="SL" <?php if($country_code == 'SL'): ?>selected="selected"<?php endif; ?>>Сьерра-Леоне (+232)</option>
    <option value="TJ" <?php if($country_code == 'TJ'): ?>selected="selected"<?php endif; ?>>Таджикистан (+992)</option>
    <option value="TH" <?php if($country_code == 'TH'): ?>selected="selected"<?php endif; ?>>Таиланд (+66)</option>
    <option value="TW" <?php if($country_code == 'TW'): ?>selected="selected"<?php endif; ?>>Тайвань (+886)</option>
    <option value="TZ" <?php if($country_code == 'TZ'): ?>selected="selected"<?php endif; ?>>Танзания (+255)</option>
    <option value="TG" <?php if($country_code == 'TG'): ?>selected="selected"<?php endif; ?>>Того (+228)</option>
    <option value="TK" <?php if($country_code == 'TK'): ?>selected="selected"<?php endif; ?>>Токелау (+690)</option>
    <option value="TO" <?php if($country_code == 'TO'): ?>selected="selected"<?php endif; ?>>Тонга (+676)</option>
    <option value="TT" <?php if($country_code == 'TT'): ?>selected="selected"<?php endif; ?>>Тринидад и Тобаго (+1)</option>
    <option value="TV" <?php if($country_code == 'TV'): ?>selected="selected"<?php endif; ?>>Тувалу (+688)</option>
    <option value="TN" <?php if($country_code == 'TN'): ?>selected="selected"<?php endif; ?>>Тунис (+216)</option>
    <option value="TM" <?php if($country_code == 'TM'): ?>selected="selected"<?php endif; ?>>Туркмения (+993)</option>
    <option value="TR" <?php if($country_code == 'TR'): ?>selected="selected"<?php endif; ?>>Турция (+90)</option>
    <option value="UG" <?php if($country_code == 'UG'): ?>selected="selected"<?php endif; ?>>Уганда (+256)</option>
    <option value="UZ" <?php if($country_code == 'UZ'): ?>selected="selected"<?php endif; ?>>Узбекистан (+998)</option>
    <option value="UA" <?php if($country_code == 'UA'): ?>selected="selected"<?php endif; ?>>Украина (+380)</option>
    <option value="WF" <?php if($country_code == 'WF'): ?>selected="selected"<?php endif; ?>>Уоллис и Футуна (+681)</option>
    <option value="UY" <?php if($country_code == 'UY'): ?>selected="selected"<?php endif; ?>>Уругвай (+598)</option>
    <option value="FO" <?php if($country_code == 'FO'): ?>selected="selected"<?php endif; ?>>Фарерские острова (+298)</option>
    <option value="FM" <?php if($country_code == 'FM'): ?>selected="selected"<?php endif; ?>>Федеративные Штаты Микронезии (+691)</option>
    <option value="FJ" <?php if($country_code == 'FJ'): ?>selected="selected"<?php endif; ?>>Фиджи (+679)</option>
    <option value="PH" <?php if($country_code == 'PH'): ?>selected="selected"<?php endif; ?>>Филиппины (+63)</option>
    <option value="FI" <?php if($country_code == 'FI'): ?>selected="selected"<?php endif; ?>>Финляндия (+358)</option>
    <option value="FK" <?php if($country_code == 'FK'): ?>selected="selected"<?php endif; ?>>Фолклендские острова (+500)</option>
    <option value="FR" <?php if($country_code == 'FR'): ?>selected="selected"<?php endif; ?>>Франция (+33)</option>
    <option value="GF" <?php if($country_code == 'GF'): ?>selected="selected"<?php endif; ?>>Французская Гвиана (+594)</option>
    <option value="PF" <?php if($country_code == 'PF'): ?>selected="selected"<?php endif; ?>>Французская Полинезия (+689)</option>
    <option value="HR" <?php if($country_code == 'HR'): ?>selected="selected"<?php endif; ?>>Хорватия (+385)</option>
    <option value="CF" <?php if($country_code == 'CF'): ?>selected="selected"<?php endif; ?>>ЦАР (+236)</option>
    <option value="TD" <?php if($country_code == 'TD'): ?>selected="selected"<?php endif; ?>>Чад (+235)</option>
    <option value="ME" <?php if($country_code == 'ME'): ?>selected="selected"<?php endif; ?>>Черногория (+382)</option>
    <option value="CZ" <?php if($country_code == 'CZ'): ?>selected="selected"<?php endif; ?>>Чешская Республика (+420)</option>
    <option value="CL" <?php if($country_code == 'CL'): ?>selected="selected"<?php endif; ?>>Чили (+56)</option>
    <option value="CH" <?php if($country_code == 'CH'): ?>selected="selected"<?php endif; ?>>Швейцария (+41)</option>
    <option value="SE" <?php if($country_code == 'SE'): ?>selected="selected"<?php endif; ?>>Швеция (+46)</option>
    <option value="LK" <?php if($country_code == 'LK'): ?>selected="selected"<?php endif; ?>>Шри-Ланка (+94)</option>
    <option value="EC" <?php if($country_code == 'EC'): ?>selected="selected"<?php endif; ?>>Эквадор (+593)</option>
    <option value="GQ" <?php if($country_code == 'GQ'): ?>selected="selected"<?php endif; ?>>Экваториальная Гвинея (+240)</option>
    <option value="ER" <?php if($country_code == 'ER'): ?>selected="selected"<?php endif; ?>>Эритрея (+291)</option>
    <option value="EE" <?php if($country_code == 'EE'): ?>selected="selected"<?php endif; ?>>Эстония (+372)</option>
    <option value="ET" <?php if($country_code == 'ET'): ?>selected="selected"<?php endif; ?>>Эфиопия (+251)</option>
    <option value="ZA" <?php if($country_code == 'ZA'): ?>selected="selected"<?php endif; ?>>ЮАР (+27)</option>
    <option value="KR" <?php if($country_code == 'KR'): ?>selected="selected"<?php endif; ?>>Южная Корея (+82)</option>
    <option value="SS" <?php if($country_code == 'SS'): ?>selected="selected"<?php endif; ?>>Южный Судан (+211)</option>
    <option value="JM" <?php if($country_code == 'JM'): ?>selected="selected"<?php endif; ?>>Ямайка (+1)</option>
    <option value="JP" <?php if($country_code == 'JP'): ?>selected="selected"<?php endif; ?>>Япония (+81)</option>
</select>