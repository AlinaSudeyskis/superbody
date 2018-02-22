<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="content" class="container">
    <div class="row">
        <div class="col-lg-2 left_sidebar">
            <?php if (!empty($user_session)):
                if ($user_session['type'] == 2):
                    include_once('./app_fold/views/couch/couch_menu.php');
                else:
                    include_once('./app_fold/views/user/user_menu.php');
                endif;
            endif;?>
        </div><!-- left_sidebar -->
        <div class="col-lg-10 content_col">
            <div class="content_block new_content_block">
                <div class="content_block_h parent">
                    <h3>Блог тренера</h3>
                    <a href="/post/new" class="add_tab_but">Добавить</a>
                    <div class="content_block_h_buts">
                        <div class="content_block_h_slide kurs_slide"></div>
                        <div class="content_block_h_close"></div>
                    </div>
                </div>
                <div class="kurs_block_val">
                    <?php if (!empty($post)): ?>
                        <div class="comment_page_block">
                            <div class="parent">
                                <div class="comment_page_cont">
                                    <?php if ($post['approval'] == 1):?>
                                        <div class="comment_page_cont_h"><?php echo $post['title'];?></div>
                                        <div class="comment_page_cont_txt"><?php echo $post['text'];?></div>
                                        <div class="comment_page_cont_link"></div>
                                    <?php else:?>
                                        <form action="" method="post">
                                            <?php include_once('./app_fold/views/blog/posts/post_settings_item.php');?>

                                            <div class="admin_form_bats parent">
                                                <input type="submit" name="bt_save_post" class="admin_form_submit" value="Сохранить" />
                                            </div>
                                        </form>
                                    <?php endif;?>
                                </div>
                            </div>
                            <?php if (!empty($post['comments'])) :?>
                                <div class="full_photo_block_comm_wrap">
                                    <?php foreach ($post['comments'] as $comment) :?>
                                        <div class="full_photo_block_comm parent">
                                            <div class="full_photo_block_comm_img">
                                                <?php if (!empty($comment['u_image'])):?><img src="<?php echo $comment['u_image'];?>" alt=""><?php endif;?>
                                            </div>
                                            <div class="full_photo_block_comm_cont">
                                                <div class="full_photo_block_comm_name"><?php echo $comment['u_name'];?></div>
                                                <div class="full_photo_block_comm_txt"><?php echo $comment['text'];?></div>
                                                <div class="full_photo_block_comm_info"></div>
                                            </div>
                                        </div>
                                    <?php endforeach;
                                    unset($comment);?>
                                </div>
                            <?php endif;?>
                            <?php if (!empty($user_session['id'])) : ?>
                                <form action="" class="full_photo_comm_form" method="post">
                                    <!--<input type="text" name="name" class="comment_page_form_in" placeholder="Имя">
                                    <input type="text" name="mail" class="comment_page_form_in" placeholder="E-mail">-->
                                    <textarea name="post_comment" placeholder="Оставить комментарий" class="full_photo_comm_in"></textarea>
                                    <div class="full_photo_comm_but_wrap parent">
                                        <input type="submit" name="bt_send_comment" value="Добавить" class="full_photo_comm_but">
                                    </div>
                                </form>
                            <?php endif;?>
                        </div>
                    <?php else: ?>
                        <div class="comment_page_block">
                            <div class="parent">
                                <div class="comment_page_cont">
                                    <div class="comment_page_cont_txt">Запись блога не найдена</div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div><!-- content_col -->
    </div>
</div><!-- content -->