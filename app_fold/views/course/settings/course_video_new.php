<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="content" class="container">
    <div class="row">
        <div class="col-lg-2 left_sidebar">
            <?php include_once('./app_fold/views/admin/admin_menu.php');?>
        </div><!-- left_sidebar -->
        <div class="col-lg-10 content_col">
            <div class="content_block new_content_block ovv">
                <div class="content_block_container_wrap">
                    <div class="content_block_container">
                        <div class="content_block_h new_content_block_h parent">
                            <h3><?php echo $course['name']?></h3>
                            <?php include_once('./app_fold/views/course/settings/course_buts.php');?>
                        </div>
                        <?php include_once('./app_fold/views/course/settings/course_menu.php');?>
                        <?php include_once('./app_fold/views/course/settings/course_video_menu.php');?>
                    </div>
                </div>
                <div class="kurs_block_val">
                    <div class="anketa_block_cont">
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="admin_form_buts_wrap_container">
                                <div class="admin_form_buts_wrap parent">
                                    <input type="submit" value="Сохранить" id="defaultActionButton"  class="video_admin_form_send" name="bt_save_video" />
                                </div>
                            </div>
                            <div class="video_admin_form">
                                <select name="s_type" class="journal_form_select">
                                    <option value="1">Промо</option>
                                    <option value="2">Тренировка</option>
                                    <option value="3">Инструктаж</option>
                                </select>
                                <input type="text" name="file_name" class="admin_form_txt" placeholder="Наименование" value="" />
                                <input type="text" name="remove_url" class="admin_form_txt" placeholder="Полная URL ссылка на видео с сайта Vimeo.com" value="" />
                                <div class="parent kurs_cur_wrap">
                                    <div class="kurs_block_h">Постер видео:</div>
                                    <div class="video_down_line parent">
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
                                </div>
                                <div class="parent kurs_cur_wrap">
                                    <div class="kurs_block_h">Файл видео:</div>
                                    <div class="video_down_line parent">
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
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div><!-- content_col -->
    </div>
</div><!-- content -->