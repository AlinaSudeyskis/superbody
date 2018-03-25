<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="parent kurs_cur_wrap">
    <div class="kurs_block_h">Категория:</div>
    <select name="s_type" class="journal_form_select">
        <option value="0" <?php if (!empty($video['type']) and $video['type'] == 0) { echo 'selected="selected"'; } ?>>Без категории</option>
        <option value="1" <?php if (!empty($video['type']) and $video['type'] == 1) { echo 'selected="selected"'; } ?>>Промо</option>
        <option value="2" <?php if (!empty($video['type']) and $video['type'] == 2) { echo 'selected="selected"'; } ?>>Тренировка</option>
        <option value="3" <?php if (!empty($video['type']) and $video['type'] == 3) { echo 'selected="selected"'; } ?>>Инструктаж</option>
    </select>
</div>
<div class="parent kurs_cur_wrap">
    <div class="kurs_block_h">Курс:</div>
    <?php if (!empty($courses)):?>
        <select name="s_courses" class="journal_form_select">
            <option value="">Выберите курс</option>
            <?php foreach($courses as $course):?>
                <option value="<?php echo $course['id']; ?>"
                    <?php if(!empty($video['course_id']) and $course['id'] == $video['course_id']):?>selected="selected"<?php endif;?>
                ><?php echo $course['name']; ?></option>
            <?php endforeach;
            unset($course);?>
        </select>
    <?php endif;?>
</div>
<div class="parent kurs_cur_wrap">
    <div class="kurs_block_h">Наименование:</div>
    <input type="text" name="file_name" class="admin_form_txt admin_form_txt_short" placeholder="Наименование" value="<?php if (!empty($video['name'])) { echo $video['name']; }?>" />
</div>
<div class="parent kurs_cur_wrap">
    <div class="kurs_block_h">Vimeo URL:</div>
    <input type="text" name="remove_url" class="admin_form_txt admin_form_txt_short" placeholder="Полная URL ссылка на видео с сайта Vimeo.com" value="<?php if (!empty($video['name'])) { echo $video['remove_url']; }?>" />
</div>
<div class="video_down_line parent">
    <div class="video_down_line_h">Постер видео:</div>
    <div class="video_down_line_but_wrap">
        <label for="poster_file" class="video_down_line_but">
            <input type="file" name="poster_file" class="admin_form_videofile" id="poster_file" />
            <input type="hidden" value="" name="poster_path" id="poster_path"/>
            <span>Выберите файл</span>
        </label>
    </div>
    <div class="video_down_line_name">Файл не выбран</div>
    <div class="progressbar_wrap">
        <progress class="progressbar" id="poster_progressbar" value="0" max="100"></progress>
    </div>
</div>
<?php if (!empty($video['poster'])) : ?>
    <div class="admin_form_file_line">
        <img src="<?php echo $video['poster'];?>" alt="">
    </div>
<?php endif; ?>
<div class="video_down_line parent">
    <div class="video_down_line_h">Файл видео:</div>
    <div class="video_down_line_but_wrap">
        <label for="video_down_line_but2" class="video_down_line_but">
            <input type="file" name="upload_file" class="admin_form_videofile" id="video_down_line_but2">
            <input type="hidden" value="" name="video_path" id="video_path"/>
            <span>Выберите файл</span>
        </label>
    </div>
    <div class="video_down_line_name">Файл не выбран</div>
    <div class="progressbar_wrap">
        <progress class="progressbar" id="progressbar2" value="0" max="100"></progress>
    </div>
</div>
<?php if (!empty($video['video'])) : ?>
    <div class="admin_form_file_line">
        <div class="leanback-player-video">
            <!--poster="/video/poster1.jpg" autoplay-->
            <video width="640" height="360" preload="metadata" controls >
                <source src="<?php echo $video['video']?>" type='video/mp4; codecs="avc1.42E01E, mp4a.40.2"' />
                <!--<source src="http://leanbackplayer.com/videos/360p/elephants_dream_640x360_2.30.webm" type='video/webm; codecs="vp8, vorbis"' />
                <source src="http://leanbackplayer.com/videos/360p/elephants_dream_640x360_2.30.ogv" type='video/ogg; codecs="theora, vorbis"' />-->
            </video>
        </div>
    </div>
<?php endif;?>
<!--<div class="admin_form_file_line parent">
            <div class="admin_form_file_line_h">Видео с YouTube.com:</div>
        </div>
        <div class="admin_form_file_line">
            <?php /*if (!empty($video['remove_url'])) :*/?>
                <iframe id="player" type="text/html" width="640" height="360"
                        src="http://www.youtube.com/embed/<?php /*echo $video['remove_url'];*/?>?enablejsapi=1&origin=http://sb.theoutlines.ru"
                        frameborder="0"></iframe>
            <?php /*endif;*/?>
        </div>-->
<?php if (!empty($video['remove_url'])) :?>
    <div class="admin_form_file_line parent">
        <div class="admin_form_file_line_h">Видео с Vimeo.com:</div>
    </div>
    <div class="admin_form_file_line">
        <?php $remove_url = $video['remove_url'];
        $key = 0;
        include('./app_fold/views/video/player/vimeo_player_item.php');?>
    </div>
<?php endif;?>