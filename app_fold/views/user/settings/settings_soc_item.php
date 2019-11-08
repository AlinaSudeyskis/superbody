<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="anketa_block_item_cont site_info">
    <div class="anketa_form_line parent">
        <div class="anketa_form_h"><div class="anketa_form_h_cell"><i class="fab fa-facebook-f" aria-hidden="true"></i></div></div>
        <?php if (!empty($user_social) and $user_social['facebook']['connect'] === true):?>
            <div class="anketa_form_but social_connect">Подключено</div>
        <?php else:?>
            <form action="/facebook_login" method="post" class="anketa_form">
                <input type="hidden" name="hi_return" value="/settings" />
                <input type="submit" name="bt_connect_facebook" value="Подключить" class="anketa_form_but"/>
            </form>
        <?php endif;?>
    </div>
    <div class="anketa_form_line parent">
        <div class="anketa_form_h"><div class="anketa_form_h_cell"><i class="fab fa-vk" aria-hidden="true"></i></div></div>
        <?php if (!empty($user_social) and $user_social['vk']['connect'] === true):?>
            <div class="anketa_form_but social_connect">Подключено</div>
        <?php else:?>
            <form action="/vk_login" method="post" class="anketa_form">
                <input type="hidden" name="hi_return" value="/settings" />
                <input type="submit" name="bt_connect_vk" value="Подключить" class="anketa_form_but"/>
            </form>
        <?php endif;?>
    </div>
    <div class="anketa_form_line parent">
        <div class="anketa_form_h"><div class="anketa_form_h_cell"><i class="fab fa-odnoklassniki" aria-hidden="true"></i></div></div>
        <?php if (!empty($user_social) and $user_social['ok']['connect'] === true):?>
            <div class="anketa_form_but social_connect">Подключено</div>
        <?php else:?>
            <form action="/ok_login" method="post" class="anketa_form">
                <input type="hidden" name="hi_return" value="/settings" />
                <input type="submit" name="bt_connect_ok" value="Подключить" class="anketa_form_but"/>
            </form>
        <?php endif;?>
    </div>
    <div class="anketa_form_line parent">
        <div class="anketa_form_h"><div class="anketa_form_h_cell"><i class="fab fa-instagram" aria-hidden="true"></i></div></div>
        <?php if (!empty($user_social) and $user_social['instagram']['connect'] === true):?>
            <div class="anketa_form_but social_connect">Подключено</div>
        <?php else:?>
            <form action="/instagram_login" method="post" class="anketa_form">
                <input type="hidden" name="hi_return" value="/settings" />
                <input type="submit" name="bt_connect_instagram" value="Подключить" class="anketa_form_but"/>
            </form>
        <?php endif;?>
    </div>
</div>
<form action="" method="post">
    <div class="anketa_block_item_cont site_info">
        <div class="anketa_form_line parent">
            <?php if (!empty($user_social) and $user_social['facebook']['connect'] === true):?>
                <div class="anketa_form_info_cont soc_block_check_wrap">
                    <input type="checkbox" name="cb_facebook_available" id="cb-facebook-available" class="tren_form_block_check"
                        <?php if (!empty($user_social) and $user_social['facebook']['available'] == 1):?> checked="checked" <?php endif;?>/>
                    <label for="cb-facebook-available">Доступно всем</label>
                </div>
            <?php endif;?>
        </div>
        <div class="anketa_form_line parent">
            <?php if (!empty($user_social) and $user_social['vk']['connect'] === true):?>
                <div class="anketa_form_info_cont soc_block_check_wrap">
                    <input type="checkbox" name="cb_vk_available" id="cb-vk-available" class="tren_form_block_check"
                        <?php if (!empty($user_social) and $user_social['vk']['available'] == 1):?> checked="checked" <?php endif;?>/>
                    <label for="cb-vk-available">Доступно всем</label>
                </div>
            <?php endif;?>
        </div>
        <div class="anketa_form_line parent">
            <?php if (!empty($user_social) and $user_social['ok']['connect'] === true):?>
                <div class="anketa_form_info_cont soc_block_check_wrap">
                    <input type="checkbox" name="cb_ok_available" id="cb-ok-available" class="tren_form_block_check"
                        <?php if (!empty($user_social) and $user_social['ok']['available'] == 1):?> checked="checked" <?php endif;?>/>
                    <label for="cb-ok-available">Доступно всем</label>
                </div>
            <?php endif;?>
        </div>
        <div class="anketa_form_line parent">
            <?php if (!empty($user_social) and $user_social['instagram']['connect'] === true):?>
                <div class="anketa_form_info_cont soc_block_check_wrap">
                    <input type="checkbox" name="cb_instagram_available" id="cb-insta-available" class="tren_form_block_check"
                        <?php if (!empty($user_social) and $user_social['instagram']['available'] == 1):?> checked="checked" <?php endif;?>/>
                    <label for="cb-insta-available">Доступно всем</label>
                </div>
            <?php endif;?>
        </div>
    </div>
    <div class="anketa_block_item_cont" style="clear: both;">
        <div class="anketa_form_line parent">
            <div class="video_admin_form_buts parent">
                <input type="submit" name="bt_save_soc_available" value="Сохранить" class="video_admin_form_send defaultActionButton" />
            </div>
        </div>
    </div>
</form>