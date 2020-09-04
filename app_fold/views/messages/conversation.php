<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="content" class="container">
    <div class="row">
        <div class="col-lg-2 left_sidebar">
            <?php include_once('./app_fold/views/admin/admin_menu.php');?>
        </div><!-- left_sidebar -->
        <div class="col-lg-10 content_col">
            <div class="chat_content_block_wrap parent one_col">
                <div class="chat_mess_block_wrap">
                    <div class="chat_mess_block">
                        <div class="chat_mess_block_h parent">
                            <div class="chat_mess_block_name parent">
                                <?php if (!empty($conv_with)): ?>
                                    <h3 style="cursor:pointer;" onclick="location.href='/profile/<?php echo $conv_with['id']; ?>'"><?php echo $conv_with['name']; ?> - <?php echo $coach_name; ?></h3>
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
                            <?php if(!empty($user_notification['blocked'])): ?>
                                <div class="mess_info"><?php echo $user_notification['blocked']['text']; ?></div>
                            <?php endif;?>
                            <div class="mess_block_line_wrap">
                                <?php if (!empty($user_messages)) :
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
                                else:?>
                                    <div class="no_mess_block">Нет сообщений</div>
                                <?php endif;?>
                            </div>
                            <div class="mess_form">
                                <form action="" class="mess_block_form" method="post">
                                    <textarea name="ta_message_text" class="mess_block_in" placeholder="Написать сообщение" autofocus="autofocus"></textarea>
                                    <input type="submit" value="Отправить" name="bt_send_message" class="mess_block_but" />
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- content_col -->
    </div>
</div><!-- content -->
