<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php if(!empty($user_session)): ?>
    <div id="profile_line" class="parent">
        <div class="profile_info parent">
            <?php if (!empty($user_session['image'])) : ?>
                <div class="profile_line_ava">
                    <img src="<?php echo $user_session['image'];?>" alt="">
                </div>
            <?php endif;?>
            <div class="profile_line_name">Здравствуйте<?php if (!empty($user_session['name'])) { echo ', ' . $user_session['name']; }?>!</div>
            <a href="/logout" class="profile_line_in"></a>
        </div>
        <div class="profile_mess parent">
            <!--<div class="profile_mess_item disabled">
                <a href="" class="parent">
                    <div class="profile_mess_val">0</div>
                    <div class="profile_mess_name">Уведомления</div>
                </a>
            </div>-->
            <div class="profile_mess_item parent">
                <a href="/messages" class="parent">
                    <div class="profile_mess_val"><?php echo ($new_messages+$new_fb_messages); ?></div>
                    <div class="profile_mess_name">Сообщения</div>
                </a>
            </div>
            <!--<div class="profile_mess_item parent disabled">
                <a href="" class="parent">
                    <div class="profile_mess_val">0</div>
                    <div class="profile_mess_name">Задачи</div>
                </a>
            </div>-->
        </div>
        <div class="up_but up_but_bot hide_chart"></div>
    </div><!-- profile_line -->
<?php endif;?>
