<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="content" class="container">
    <div class="row">
        <div class="col-lg-2 left_sidebar">
            <?php if ($user_session['type'] == 2) :
                include_once('./app_fold/views/couch/couch_menu.php');
            else :
                include_once('./app_fold/views/user/user_menu.php');
            endif;?>
        </div><!-- left_sidebar -->
        <div class="col-lg-10 content_col">
            <?php if (!empty($attached_couches)) :
                foreach ($attached_couches as $couch) :?>
                    <a href="/messages/<?php echo $couch['id']?>"><span><?php echo $couch['name']?></span></a><br/>
                <?php endforeach;
                unset($couch);
            elseif (!empty($attached_users)) :
                foreach ($attached_users as $us) :?>
                    <a href="/messages/<?php echo $us['id']?>"><span><?php echo $us['name']?></span></a><br/>
                <?php endforeach;
                unset($us);
            elseif ($user_session['type'] == 2) :?>
                <div>Нет прикрепленных пользователей</div>
            <?php else:?>
                <div>Нет прикрепленных тренеров</div>
            <?php endif;?>
            
            <?php if (!empty($user_messages)) :
                foreach ($user_messages as $mess) :?>
                    <div class="message_box">
                        <div class="message_line">
                            <a href="/profile/<?php echo $mess['user_from']['id']; ?>"><?php echo $mess['user_from']['name']; ?></a>
                        </div>
                        <div class="small_text"><?php echo $mess['date']; ?></div>
                        <div style="margin: 10px 0 0 20px;">
                            <?php echo nl2br($mess['text']); ?>
                        </div>
                    </div>
                <?php endforeach;
                unset($mess);
            else:?>
                <div>У Вас нет сообщений</div>
            <?php endif;?>
            <div style="margin-top: 20px;">
                <form action="" method="post">
                    <textarea name="ta_message_text" placeholder="Текст сообщения" class="text_message"></textarea>
                    <input type="submit" name="bt_send_message" value="Отправить" class="bt_message"/>
                </form>
            </div>
        </div><!-- content_col -->
    </div>
</div><!-- content -->
