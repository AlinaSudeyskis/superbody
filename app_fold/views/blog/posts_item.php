<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="col-lg-3 col-md-4 col-sm-6 col-xs-6">
    <div class="posts_block_col">
        <div class="posts_block_col_h">
            <a href="<?php echo $post_path.$post['id'];?>" class="posts_block_col_title">
                <?php echo $post['title']; ?>
            </a>
        </div>
        <div class="posts_block_col_poster">
            <?php if($post['poster_type'] == 'image' or empty($post['poster'])): ?>
                <?php $poster_img = (!empty($post['poster'])) ? $post['poster'] : '/img/video_img.png'; ?>
                <img src="<?php echo $poster_img; ?>" alt="">
            <?php elseif($post['poster_type'] == 'vimeo' and !empty($post['poster'])): ?>
                <?php $remote_url =$post['poster'];
                $key = 0;
                include('./app_fold/views/video/player/vimeo_player_item.php');?>
            <?php elseif($post['poster_type'] == 'youtube' and !empty($post['poster'])) : ?>
                <?php $remote_url = $post['poster'];
                $key = 0;
                include('./app_fold/views/video/player/youtube_player_item.php');?>
            <?php endif;?>
        </div>
        <div class="posts_block_col_but">
            <div class="posts_block_col_but_left">
                <a href="<?php echo $post_path.$post['id'];?>">Подробнее</a>
            </div>
        </div>
    </div>
</div>
