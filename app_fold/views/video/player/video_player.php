<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Блок видео тренировки
if (empty($v_remote_url) and !empty($v_poster) and !empty($v_video))
{
    $w_video = "<div class='px-video-container' id='myvid' data-video-url=".$v_video." style='width:360px'><div class='px-video-img-captions-container'><div class='px-video-captions hide'></div><video poster='" . $v_poster . "' controls autoplay id='workout-video' ><source src='" . $v_video . "' type='video/mp4'><div><a href='" . $v_video . "'><img src='" . $v_poster . "' alt='download video'></a></div></video></div><div class='px-video-controls'></div></div>";
    $v_player = 1;
    $v_source = $v_video;
}
elseif(!empty($v_remote_url) and !empty($v_remote_type) and $v_remote_type == 'vimeo')
{
    //$video = "<iframe id='player' type='text/html' src='http://www.youtube.com/embed/".$video_data['video']['remote_url']."?autoplay=1&enablejsapi=1&origin=http://sb.theoutlines.ru' frameborder='0'></iframe>";
    $v_player = 2;
    $remote_url = $v_remote_url;
    $v_source = $v_remote_url;
    $key = 0;

    ob_start();
    include('./app_fold/views/video/player/vimeo_player_item.php');
    $w_video = ob_get_contents();
    ob_end_clean();
}
elseif(!empty($v_remote_url) and !empty($v_remote_type) and $v_remote_type == 'youtube')
{
    //$video = "<iframe id='player' type='text/html' src='http://www.youtube.com/embed/".$video_data['video']['remote_url']."?autoplay=1&enablejsapi=1&origin=http://sb.theoutlines.ru' frameborder='0'></iframe>";
    $v_player = 2;
    $remote_url = $v_remote_url;
    $v_source = $v_remote_url;
    $key = 0;

    ob_start();
    include('./app_fold/views/video/player/youtube_player_item.php');
    $w_video = ob_get_contents();
    ob_end_clean();
}
// Блок кнопки "Выполнено" (активная или не активная)
if ($w_done == 1)
{
    $workout_done = "<div id='wo-done'><div class='workout_form_but done'>Выполнено</div></div>";
}
else {
    $workout_done = "<div id='wo-done'><input type='button' name='bt_workout_done' id='bt-workout-done' value='Сохранить как выполненное' class='workout_form_but'/><input type='hidden' name='woid' value='".$workout_id."' id='wo-id'/></div>";
}

$workout_description = !empty($w_description) ? $w_description : '';


// Блок видео инструктажа
if (empty($i_remote_url) and !empty($i_poster) and !empty($i_video))
{
    $inst_video = "<div class='px-video-container' id='ivid' data-video-url=".$i_video." style='width:360px'><div class='px-video-img-captions-container'><div class='px-video-captions hide'></div><video poster='" . $i_poster . "' controls autoplay id='workout-video' ><source src='" . $i_video . "' type='video/mp4'><div><a href='" . $i_video . "'><img src='" . $i_poster . "' alt='download video'></a></div></video></div><div class='px-video-controls'></div></div>";
    $i_player = 1;
    $i_source = $i_video;
}
elseif(!empty($i_remote_url) and !empty($i_remote_type) and $i_remote_type == 'vimeo')
{
    $i_player = 2;
    $remote_url = $i_remote_url;
    $i_source = $i_remote_url;
    $key = 1;

    ob_start();
    include('./app_fold/views/video/player/vimeo_player_item.php');
    $inst_video = ob_get_contents();
    ob_end_clean();
}
elseif(!empty($i_remote_url) and !empty($i_remote_type) and $i_remote_type == 'youtube')
{
    $v_player = 2;
    $remote_url = $i_remote_url;
    $v_source = $i_remote_url;
    $key = 1;

    ob_start();
    include('./app_fold/views/video/player/youtube_player_item.php');
    $w_video = ob_get_contents();
    ob_end_clean();
}
$workout_instruction = (!empty($inst_video)) ? '<div id="wo-instruction">' . $inst_video . '</div>' : '';
$workout_inst_but = (!empty($inst_video)) ? "<div class='workout_form_but instruction'>Инструктаж</div>" : '';
$workout_video = (!empty($w_video)) ? '<div id="wo-video">' . $w_video . '</div>' . $workout_instruction . '<div id="wo-description">' . $workout_description . '</div>' . $workout_done . $workout_inst_but : '';