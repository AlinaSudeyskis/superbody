<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="content" class="container">
    <div class="row">
        <div class="col-lg-2 left_sidebar">
            <?php if (!empty($user_session) and $user_session['type'] == 2):
                include_once('./app_fold/views/couch/couch_menu.php');
            elseif(!empty($user_session)) :
                include_once('./app_fold/views/user/user_menu.php');
            endif;?>
        </div><!-- left_sidebar -->
        <div class="col-lg-10 content_col">
            <div class="chat_content_block_wrap parent">
                <div class="chat_contact_block">
                    <div class="chat_contact_block_h parent">
                        <h3>Сообщения</h3>
                        <div class="chat_mob_but">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                        <div class="chat_block_h_buts parent">
                            <div class="chat_block_h_slide"></div>
                            <div class="chat_block_h_close"></div>
                        </div>
                    </div>
                    <div class="chat_block_val">
                        <div class="chat_search_mob_but"><img src="/img/search_ico2.png" alt=""></div>
                        <form action="#" class="chat_search_form parent disabled">
                            <input type="text" class="chat_search_in" placeholder="Поиск">
                            <input type="submit" value="" class="chat_search_but">
                        </form>
                        <div class="chat_contacts_wrap">
                            <?php if (!empty($user_conversations)):
                                foreach ($user_conversations as $conv) :
                                    // Удаление из массива прикрепленных тренеров или пользователей соответствующего пользователя,
                                    // если он присутствует в списке диалогов
                                    if ($user_session['type'] == 2) :
                                        if (array_key_exists($conv['user_with']['id'], $attached_users)) :
                                            unset($attached_users[$conv['user_with']['id']]);
                                        endif;
                                    else :
                                        if (array_key_exists($conv['user_with']['id'], $attached_couches)) :
                                            unset($attached_couches[$conv['user_with']['id']]);
                                        endif;
                                    endif;?>
                                    <div class="chat_contact parent <?php if ($user_with == $conv['user_with']['id']) { echo 'chat_contact_active';}?>"
                                         onclick="location.href='/messages/<?php echo $conv['user_with']['id'];?>';">
                                        <div class="chat_contact_img_wrap">
                                            <div class="chat_contact_img"><img src="<?php echo $conv['user_with']['image'];?>" alt=""></div>
                                            <!--<div class="chat_contact_status chat_contact_status_b"></div>-->
                                            <?php if ($conv['total_new'] > 0) :?>
                                                <div class="chat_contact_mess_val"><?php echo $conv['total_new'];?></div>
                                            <?php endif;?>
                                        </div>
                                        <div class="chat_contact_cont">
                                            <div class="chat_contact_cont_top parent">
                                                <div class="chat_contact_time"><?php echo $conv['date'];?></div>
                                                <div class="chat_contact_name"><?php echo $conv['user_with']['name'];?></div>
                                            </div>
                                            <div class="chat_contact_short_mess">
                                                <?php if ($conv['from'] == $user_session['id']) { echo '<span class="mess_from">Вы: </span>'; } ?>
                                                <?php echo $conv['text']?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach;
                                unset($conv);
                            endif;?>
                            <div class="chat_contact parent <?php if ($user_with == 'feedback') { echo 'chat_contact_active';}?>"
                                 onclick="location.href='/messages/feedback';">
                                <div class="chat_contact_img_wrap">
                                    <div class="chat_contact_img"><img src="/img/menu_ico4.png" alt="" style="width:25px; height: auto; margin: 5px 4px;"></div>
                                    <!--<div class="chat_contact_status chat_contact_status_b"></div>-->
                                    <?php if (!empty($new_fb_messages) and $new_fb_messages > 0) :?>
                                        <div class="chat_contact_mess_val"><?php echo $new_fb_messages;?></div>
                                    <?php endif;?>
                                </div>
                                <div class="chat_contact_cont" style="height: 35px;">
                                    <div class="chat_contact_name" style="margin-top:5px;">Обратная связь</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="chat_mess_block_wrap">
                    <div class="chat_mess_block">
                        <div class="chat_mess_block_h parent">
                            <div class="chat_mess_block_name parent">
                                <?php if (!empty($conv_with)): ?>
                                    <h3 style="cursor:pointer;" onclick="location.href='/profile/'<?php echo $user_with; ?>"><?php echo $conv_with['name']; ?></h3>
                                <?php elseif ($user_with == 'feedback'): ?>
                                    <h3>Обратная связь</h3>
                                <?php endif;?>
                            </div>
                            <div class="chat_mess_control_wrap parent">
                                <div class="chat_block_h_buts parent">
                                    <div class="chat_block_h_slide"></div>
                                    <div class="chat_block_h_close"></div>
                                </div>
                                <div class="chat_mess_control parent">
                                    <?php if (!empty($conv_with)) :?>
                                        <div class="chat_mess_control_del"></div>
                                    <?php endif;?>
                                </div>
                            </div>
                        </div>
                        <div class="mess_block_val">
                            <div class="mess_block_line_wrap">
                                <?php if (!empty($user_with)) :
                                    if (!empty($user_messages)) :
                                        foreach ($user_messages as $mess) :
                                            $class = $mess['user_from']['id'] == $user_session['id'] ? 'mess_block_line_g' : ''; ?>
                                            <div class="mess_block_line <?php echo $class; ?> parent">
                                                <div class="mess_block_line_ava"><a href="/profile/<?php echo $mess['user_from']['id'];?>"><img src="<?php echo $mess['user_from']['image'];?>" alt=""></a></div>
                                                <div class="mess_block_line_txt">
                                                    <div class="mess_block_line_val"><?php echo $mess['text'];?></div>
                                                    <div class="mess_block_line_time">
                                                        <span class="mess_block_full_time">
                                                            <?php if ($mess['fl_date'] == 1) :?>
                                                                <span class="mess_block_short_time"><?php echo $mess['date'];?></span>
                                                            <?php else:?>
                                                                <?php echo $mess['date'];?>
                                                            <?php endif;?>
                                                            <?php echo $mess['time'];?>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach;
                                        unset($mess);
                                    elseif (!empty($fb_user_messages)):
                                        foreach ($fb_user_messages as $fb_mess) :
                                            $fb_class = $fb_mess['admin_id'] == 0 ? 'mess_block_line_g' : ''; ?>
                                            <div class="mess_block_line <?php echo $fb_class; ?> parent no_ava">
                                                <div class="mess_block_line_txt">
                                                    <div class="mess_block_line_val"><?php echo $fb_mess['text'];?></div>
                                                    <div class="mess_block_line_time">
                                                        <span class="mess_block_full_time">
                                                            <?php echo $fb_mess['user_name']; ?>
                                                            <?php if(!empty($fb_mess['user_email'])):?>
                                                                [<?php echo $fb_mess['user_email']; ?>]
                                                            <?php endif;?>
                                                        </span>
                                                    </div>
                                                    <div class="mess_block_line_time">
                                                        <span class="mess_block_full_time">
                                                            <?php if ($fb_mess['fl_date'] == 1) :?>
                                                                <span class="mess_block_short_time"><?php echo $fb_mess['date'];?></span>
                                                            <?php else:?>
                                                                <?php echo $fb_mess['date'];?>
                                                            <?php endif;?>
                                                            <?php echo $fb_mess['time'];?>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach;
                                        unset($fb_mess);
                                    else:?>
                                        <div class="no_mess_block">Нет сообщений</div>
                                    <?php endif;
                                else:?>
                                    <div class="no_mess_block">Выберите диалог из списка</div>
                                <?php endif;?>
                            </div>
                            <?php if (!empty($user_with)) :?>
                                <div class="mess_form">
                                    <form action="" class="mess_block_form" method="post">
                                        <textarea name="ta_message_text" class="mess_block_in" placeholder="Написать сообщение" autofocus="autofocus"></textarea>
                                        <input type="submit" value="Отправить" name="bt_send_message" class="mess_block_but" />
                                    </form>
                                </div>
                            <?php endif;?>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- content_col -->
    </div>
</div><!-- content -->
