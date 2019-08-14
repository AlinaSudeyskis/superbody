<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php if (!empty($posts)) :?>
    <div class="content_block new_content_block">
        <div class="content_block_h new_content_block_h parent">
            <h3>Блог</h3>
            <?php $path = '/blog/';
            if (empty($outsider) and $user_data['user_blocked'] == 0):
                $path = '/post/';?>
                <div class="content_block_h_ref">
                    <a href="/post/new" class="add_tab_but">Добавить</a>
                </div>
            <?php endif;?>
            <div class="content_block_h_buts">
                <div class="content_block_h_slide kurs_slide"></div>
                <div class="content_block_h_close"></div>
            </div>
        </div>
        <div class="kurs_block_val">
            <div class="subscription_block">
                <div class="subscription_block_cont">
                    <?php foreach ($posts as $post) :?>
                        <div class="subscription_block_item">
                            <div class="subscription_block_h"><a href="<?php echo $path . $post['id'];?>"><?php echo $post['title'];?></a></div>
                            <div class="subscription_block_txt">Краткое описание: <?php echo $post['short_desc'];?>...</div>
                            <div class="subscription_block_link">
                                <!--<a href="">http://if.com.au/2013/09/02/article/</a>-->
                            </div>
                        </div>
                    <?php endforeach;
                    unset($post); ?>
                </div>
            </div>
            <?php include_once('./app_fold/views/pagination.php');?>
        </div>
    </div>
<?php endif; ?>