<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="purchase_pop-up">
    <div class="purchase_pop-up_cont">
        <div class="purchase_pop-up_close"></div>
        <div class="purchase_pop-up_h">
            <?php if(empty($user_session)): ?>
                <div class="sing-in page_form">
                    <form action="" class="sing-in_form" method="post">
                        <div class="sing-in_h">через социальную сеть:</div>
                        <?php include_once('./app_fold/views/authorization/auth_soc_item.php'); ?>
                        <div class="sing-in_h">или авторизуйтесь:</div>
                        <input type="text" class="sing-in_in" placeholder="e-mail" name="email" value="" maxlength="255"/>
                        <input type="password" class="sing-in_in" placeholder="пароль" name="password" value="" maxlength="255" minlength="8"/>
                        <div class="sing-in_h tren_form_block_check_wrap">
                            <input type="checkbox" name="cb_politics" class="tren_form_block_check" id="cb-politics" required="required" />
                            <label for="cb-politics">согласие на
                                <a href="#" class="reg_in_link policy">обработку персональных данных</a>
                            </label>
                        </div>
                        <input type="submit" value="войти" class="sing-in_but" name="bt_login"/>
                    </form>
                    <div class="reg_in_link_wrap">
                        <a href="/registry" class="reg_in_link">регистрация</a>
                        <a href="/restore" class="reg_in_link">восстановление пароля</a>
                    </div>
                </div>
            <?php endif; ?>
            <form action="" method="post" class="anketa_form video_admin_form purchase_form">
                <?php if(empty($user_session)): ?>
                    <div class="anketa_form_line parent">
                        <div class="anketa_form_h"><div class="anketa_form_h_cell">Email:</div></div>
                        <input type="text" name="email" required="required" value="" class="anketa_form_in" autocomplete="off"/>
                    </div>
                <?php endif; ?>
                <?php include_once('./app_fold/views/course/course_payment_item.php');?>
            </form>
        </div>
    </div>
</div><!-- purchase_pop-up -->
