<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Блок видео тренировки
if (empty($v_remove_url) and !empty($v_poster) and !empty($v_video))
{
    $w_video = "<div class='px-video-container' id='myvid' style='width:360px'><div class='px-video-img-captions-container'><div class='px-video-captions hide'></div><video poster='" . $v_poster . "' controls autoplay id='workout-video' ><source src='" . $v_video . "' type='video/mp4'><div><a href='" . $v_video . "'><img src='" . $v_poster . "' alt='download video'></a></div></video></div><div class='px-video-controls'></div></div>";
    $v_player = 1;
}
elseif(!empty($v_remove_url))
{
    //$video = "<iframe id='player' type='text/html' src='http://www.youtube.com/embed/".$video_data['video']['remove_url']."?autoplay=1&enablejsapi=1&origin=http://sb.theoutlines.ru' frameborder='0'></iframe>";
    $v_player = 2;
    $remove_url = $v_remove_url;
    $key = 0;

    ob_start();
    include('./app_fold/views/video/player/vimeo_player_item.php');
    $w_video = ob_get_contents();
    ob_end_clean();
}
$workout_video = !empty($w_video) ? '<div id="wo-video">' . $w_video . '</div>' : '';

// Блок видео инструктажа
if (empty($i_remove_url) and !empty($i_poster) and !empty($i_video))
{
    $i_video = "<div class='px-video-container' id='ivid' style='width:360px'><div class='px-video-img-captions-container'><div class='px-video-captions hide'></div><video poster='" . $i_poster . "' controls autoplay id='workout-video' ><source src='" . $i_video . "' type='video/mp4'><div><a href='" . $i_video . "'><img src='" . $i_poster . "' alt='download video'></a></div></video></div><div class='px-video-controls'></div></div>";
    $i_player = 1;
}
elseif(!empty($i_remove_url))
{
    //$video = "<iframe id='player' type='text/html' src='http://www.youtube.com/embed/".$video_data['video']['remove_url']."?autoplay=1&enablejsapi=1&origin=http://sb.theoutlines.ru' frameborder='0'></iframe>";
    $i_player = 2;
    $remove_url = $i_remove_url;
    $key = 1;

    ob_start();
    include('./app_fold/views/video/player/vimeo_player_item.php');
    $i_video = ob_get_contents();
    ob_end_clean();
}
$workout_instruction = !empty($i_video) ? '<div id="wo-instruction">' . $i_video . '</div>' : '';
$workout_instruction_a = !empty($i_video) ? '<div id="wo-i-but" class="wo_instruction video">Инструктаж</div>' : '';

// Блок кнопки "Выполнено" (активная или не активная)
if ($w_done == 1)
{
    $workout_done = "<div id='wo-done'><div class='workout_form_but done'>Выполнено</div></div>";
}
else {
    $workout_done = "<div id='wo-done'><input type='button' name='bt_workout_done' id='bt-workout-done' value='Выполнено' class='workout_form_but'/><input type='hidden' name='woid' value='".$workout_id."' id='wo-id'/></div>";
}

// Блок описания тренировки
$workout_description = '<div id="wo-description">' . $w_description . '</div>';