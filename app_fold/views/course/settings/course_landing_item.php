<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$lend_block_id = (is_numeric($lend_block_id)) ? $lend_block_id : 1;
?>
<form action="" class="edit_lend_form landing_admin_form" method="post" enctype="multipart/form-data">
    <div class="admin_form_buts_wrap_container">
        <div class="admin_form_buts_wrap parent">
            <?php if ($course['landing']['activated'] === 'activate'): ?>
                <input type="submit" name="bt_deactivate_landing" value="Блокировать" class="video_admin_form_block"/>
            <?php else: ?>
                <input type="submit" name="bt_activate_landing" value="Активировать" class="video_admin_form_block"/>
            <?php endif;?>

            <?php if($lend_block_id == 1): ?>
                <input type="submit" name="bt_save_block_1" value="Сохранить блок 1" class="video_admin_form_send" />
            <?php elseif($lend_block_id == 2): ?>
                <input type="submit" name="bt_save_block_2" value="Сохранить блок 2" class="video_admin_form_send" />
            <?php elseif($lend_block_id == 3): ?>
                <input type="submit" name="bt_save_block_3" value="Сохранить блок 3" class="video_admin_form_send" />
            <?php elseif($lend_block_id == 4): ?>
                <input type="submit" name="bt_save_block_4" value="Сохранить блок 4" class="video_admin_form_send" />
            <?php elseif($lend_block_id == 5): ?>
                <input type="submit" name="bt_save_block_5" value="Сохранить блок 5" class="video_admin_form_send" />
            <?php elseif($lend_block_id == 6): ?>
                <input type="submit" name="bt_save_block_6" value="Сохранить блок 6" class="video_admin_form_send" />
            <?php elseif($lend_block_id == 7): ?>
                <input type="submit" name="bt_save_block_7" value="Сохранить блок 7" class="video_admin_form_send" />
            <?php elseif($lend_block_id == 8): ?>
                <input type="submit" name="bt_save_block_8" value="Сохранить блок 8" class="video_admin_form_send" />
            <?php endif; ?>
        </div>
    </div>
    <div class="video_admin_form">
        <div class="anketa_block_item_cont">
            <div class="landing_block_table">
                <?php $course_type = ($page_menu == 'a_courses_n') ? 'nutrition' : 'course';
                for($i = 1; $i <= 8; $i++) :
                    $active = ($i == $lend_block_id) ? 'active' : '';?>
                    <a href="/administration/<?php echo $course_type; ?>/<?php echo $course_id; ?>/landing/<?php echo $i; ?>" class="landing_blocks <?php echo $active; ?>" id="block-<?php echo $i; ?>">Блок <?php echo $i; ?></a>
                <?php endfor;
                unset($i);?>
            </div>
            <div class="landing_block_wrap">
                <?php if($lend_block_id == 1): ?>
                    <div class="landing_block" style="display:block;" id="l-block-1">
                        <div class="landing_title">
                            <span>Блок №1</span>
                            <div class="tren_form_block_check_wrap">
                                <input type="checkbox" name="cb_hide_block1"
			                        <?php if ($landing['hide'] === true) : ?> checked="checked" <?php endif ; ?>
                                       class="tren_form_block_check" id="tren_form_block_check1hb" />
                                <label for="tren_form_block_check1hb">Скрыть блок</label>
                            </div>
                        </div>
                        <img src="/img/landing parts/1.PNG" alt="" class="land_template"/>
                        <div class="parent kurs_cur_wrap"><div class="kurs_block_h"></div></div>
                        <?php if (!empty($landings_list)) : ?>
                            <div class="parent kurs_cur_wrap">
                                <div class="kurs_block_h">Стиль:</div>
                                <select name="s_land_type" class="journal_form_select">
                                    <option value="">Стиль</option>
                                    <?php foreach ($landings_list as $ls) :
                                        $default = $ls['id'] == 1 ? ' (по умолчанию)' : '';?>
                                        <option value="<?php echo $ls['id']; ?>"
                                            <?php if ($landing['lp_id'] == $ls['id']) : ?> selected="selected"<?php endif; ?>
                                        ><?php echo $ls['name'] . $default; ?></option>
                                    <?php endforeach;
                                    unset($ls);?>
                                </select>
                            </div>
                        <?php endif; ?>
                        <div class="parent kurs_cur_wrap">
                            <div class="kurs_block_h">Цвет блока:</div>
                            <div class="bg_color">
                                <?php $h_color = (mb_substr($landing['bg_color_orig'], 0, 1) == '#') ? $landing['bg_color_orig'] : '';
                                $v_color = (mb_substr($landing['bg_color_orig'], 0, 1) == '#') ? $landing['bg_color_orig'] : '';?>
                                <input type="hidden" name="i_bg_color_block1" value="<?php echo $h_color;?>" id="block_bg_color"/>
                                <div id="customWidget">
                                    <div class="colorselector"><div style="background-color: <?php echo $v_color;?>"></div></div>
                                    <div class="colorpickerholder2"></div>
                                </div>
                            </div>
                        </div>
                        <div class="parent kurs_cur_wrap">
                            <div class="kurs_block_h">Прозрачность:</div>
                            <?php $b1_opacity = (is_numeric($landing['slider_opacity'])) ? $landing['slider_opacity'] : ''; ?>
                            <input type="range" min="0" max="1" step="0.05" value="<?php echo $b1_opacity; ?>" class="land_block_opacity">
                            <input type="text" name="r_opacity_block1" value="<?php echo $b1_opacity; ?>" class="land_block_opacity_val" readonly>
                        </div>
                        <div class="lend_form_h">Слайдер (максимум 7 изображений; 1920х600)</div>
                        <div class="tren_form_block_check_wrap">
                            <input type="checkbox" name="cb_slider_block1"
                                <?php if ($landing['slider_images_default'] === true) : ?> checked="checked" <?php endif ; ?>
                                   class="tren_form_block_check" id="tren_form_block_check1bg" />
                            <label for="tren_form_block_check1bg">Изображения слайдера по умолчанию</label>
                        </div>
                        <div class="parent kurs_cur_wrap">
                            <div class="kurs_block_h">Изображения:</div>
                            <div class="video_down_line parent">
                                <div class="video_down_line_but_wrap">
                                    <label for="video_down_line_but1s" class="video_down_line_but">
                                        <input type="file" name="slider_files[]" class="admin_form_videofile" id="video_down_line_but1s" accept="image/jpeg,image/png" multiple="multiple"/>
                                        <span>Выберите файл</span>
                                    </label>
                                </div>
                                <div class="video_down_line_name">Файл не выбран</div>
                            </div>
                        </div>
                        <?php if ($landing['slider_images_default'] === false): ?>
                            <div class="landing_images">
                                <?php foreach ($landing['slider_images'] as $key => $s_image): ?>
                                    <div class="landing_image">
                                        <img src="<?php echo $s_image; ?>" alt=""/>
                                        <div class="admin_form_buts parent">
                                            <input type="hidden" name="img_path_1_3_<?php echo $key; ?>" value="<?php echo $s_image; ?>">
                                            <input type="submit" name="bt_delete_landing_img[1][3][<?php echo $key; ?>]" class="admin_form_del" value="Удалить">
                                        </div>
                                    </div>
                                <?php endforeach;
                                unset($s_image); ?>
                            </div>
                        <?php endif; ?>
                        <div class="lend_form_h">Заголовок страницы</div>
                        <div class="journal_form_textarea_wrap journal_form_textarea_small">
                            <textarea id="area3" name="ta_main_title" class="journal_form_textarea formatted_textarea" placeholder="Заголовок страницы" maxlength="50"><?php echo $landing['main_title']; ?></textarea>
                        </div>
                        <div class="parent kurs_cur_wrap">
                            <div class="kurs_block_h">Vimeo URL:</div>
                            <input type="text" name="i_main_video_url" class="admin_form_txt admin_form_txt_middle" maxlength="255" value="<?php echo $landing['main_video_url']; ?>" />
                        </div>
                        <div class="parent kurs_cur_wrap">
                            <div class="kurs_block_h">Текст кнопки:</div>
                            <input type="text" name="i_main_button_text" class="admin_form_txt admin_form_txt_middle" maxlength="26" value="<?php echo $landing['main_button']; ?>" />
                        </div>
                        <div class="lend_form_h">Описание:</div>
                        <div class="journal_form_textarea_wrap journal_form_textarea_small">
                            <textarea id="area4" name="ta_main_description" class="journal_form_textarea formatted_textarea1" placeholder="Описание" maxlength="50"><?php echo $landing['main_description']; ?></textarea>
                        </div>
                        <script>
                            tinymce.init({
                                selector: "textarea.formatted_textarea1",
                                menubar: false,
                                statusbar: false,
                                theme: 'silver',
                                language_url : '/js/tinymce/langs/ru.js',
                                plugins: "bbcode",
                                toolbar: "undo redo | bold italic | forecolor | alignleft aligncenter alignright alignjustify",
                                max_chars_indicator: "pageLength"
                            });
                        </script>
                    </div>
                <?php
                elseif($lend_block_id == 2): ?>
                    <div class="landing_block" style="display:block;" id="l-block-2">
                        <div class="landing_title">
                            <span>Блок №2</span>
                            <div class="tren_form_block_check_wrap">
                                <input type="checkbox" name="cb_hide_block2"
				                    <?php if ($landing['block2']['hide'] === true) : ?> checked="checked" <?php endif ; ?>
                                       class="tren_form_block_check" id="tren_form_block_check2hb" />
                                <label for="tren_form_block_check2hb">Скрыть блок</label>
                            </div>
                        </div>
                        <img src="/img/landing parts/2.PNG" alt="" class="land_template"/>
                        <div class="lend_form_h">Шапка фона</div>
                        <div class="lend_form_option">
                            <div class="tren_set_form_l">
                                <div class="tren_set_form_img">
                                    <?php if ($landing['block2']['bg_top_default'] === false and is_file($landing['block2']['bg_top_orig'])) :?>
                                        <img src="<?php echo mb_substr($landing['block2']['bg_top_orig'], 1); ?>" alt=""/>
                                        <div class="admin_form_buts parent">
                                            <input type="hidden" name="img_path_2_1" value="<?php echo mb_substr($landing['block2']['bg_top_orig'], 1); ?>">
                                            <input type="submit" name="bt_delete_landing_img[2][1]" class="admin_form_del" value="Удалить">
                                        </div>
                                    <?php else: ?>
                                        <img src="/img/no_img.png" alt="">
                                    <?php endif;?>
                                </div>
                            </div>
                            <div class="tren_set_form_r">
                                <div class="tren_form_block_check_wrap">
                                    <input type="checkbox" name="cb_default_bg_top_block2"
                                        <?php if ($landing['block2']['bg_default'] === true) : ?> checked="checked" <?php endif ; ?>
                                           class="tren_form_block_check" id="tren_form_block_check2tbg">
                                    <label for="tren_form_block_check2tbg">Шапка фона по умолчанию</label>
                                </div>
                                <div class="parent kurs_cur_wrap">
                                    <div class="kurs_block_h">Файл шапки фона:
                                        <div class="h_subtitle">(1920х55)</div>
                                    </div>
                                    <div class="video_down_line parent">
                                        <div class="video_down_line_but_wrap">
                                            <label for="video_down_line_but2ftbg" class="video_down_line_but">
                                                <input type="file" name="bg_top_file_block2" class="admin_form_videofile" id="video_down_line_but2ftbg" accept="image/jpeg,image/png" />
                                                <span>Выберите файл</span>
                                            </label>
                                        </div>
                                        <div class="video_down_line_name">Файл не выбран</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="lend_form_h">Фон</div>
                        <div class="lend_form_option">
                            <div class="tren_set_form_l">
                                <div class="tren_set_form_img">
                                    <?php if ($landing['block2']['bg_default'] === false and is_file($landing['block2']['bg_orig'])) :?>
                                        <img src="<?php echo mb_substr($landing['block2']['bg_orig'], 1); ?>" alt=""/>
                                        <div class="admin_form_buts parent">
                                            <input type="hidden" name="img_path_2_0" value="<?php echo mb_substr($landing['block2']['bg_orig'], 1); ?>">
                                            <input type="submit" name="bt_delete_landing_img[2][0]" class="admin_form_del" value="Удалить">
                                        </div>
                                    <?php else: ?>
                                        <img src="/img/no_img.png" alt="">
                                    <?php endif;?>
                                </div>
                            </div>
                            <div class="tren_set_form_r">
                                <div class="parent kurs_cur_wrap">
                                    <div class="kurs_block_h">Цвет блока:</div>
                                    <div class="bg_color">
                                        <?php $b2_color = $landing['block2']['bg_color_orig'];?>
                                        <input type="hidden" name="i_bg_color_block2" value="<?php echo $b2_color;?>" id="block_bg_color"/>
                                        <div id="customWidget">
                                            <div class="colorselector"><div style="background-color: <?php echo $b2_color;?>"></div></div>
                                            <div class="colorpickerholder2"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="parent kurs_cur_wrap">
                                    <div class="kurs_block_h">Прозрачность:</div>
                                    <?php $b2_opacity = $landing['block2']['bg_opacity']; ?>
                                    <input type="range" min="0.05" max="1" step="0.05" value="<?php echo $b2_opacity; ?>" class="land_block_opacity">
                                    <input type="text" name="r_opacity_block2" value="<?php echo $b2_opacity; ?>" class="land_block_opacity_val" readonly>
                                </div>
                                <div class="tren_form_block_check_wrap">
                                    <input type="checkbox" name="cb_default_bg_block2"
                                        <?php if ($landing['block2']['bg_default'] === true) : ?> checked="checked" <?php endif ; ?>
                                           class="tren_form_block_check" id="tren_form_block_check2bg">
                                    <label for="tren_form_block_check2bg">Фон по умолчанию</label>
                                </div>
                                <div class="parent kurs_cur_wrap">
                                    <div class="kurs_block_h">Файл фона:
                                        <div class="h_subtitle">(1920х1)</div>
                                    </div>
                                    <div class="video_down_line parent">
                                        <div class="video_down_line_but_wrap">
                                            <label for="video_down_line_but2fbg" class="video_down_line_but">
                                                <input type="file" name="bg_file_block2" class="admin_form_videofile" id="video_down_line_but2fbg" accept="image/jpeg,image/png" />
                                                <span>Выберите файл</span>
                                            </label>
                                        </div>
                                        <div class="video_down_line_name">Файл не выбран</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="lend_form_h">Информация</div>
                        <div class="parent kurs_cur_wrap">
                            <div class="kurs_block_h">Заголовок:</div>
                            <input type="text" name="i_title_block2" class="admin_form_txt admin_form_txt_middle" maxlength="60" value="<?php echo $landing['block2']['title']; ?>" />
                        </div>
                        <div class="parent kurs_cur_wrap">
                            <div class="kurs_block_h">Подзаголовок:</div>
                            <input type="text" name="i_subtitle_block2" class="admin_form_txt admin_form_txt_middle" maxlength="80" value="<?php echo $landing['block2']['subtitle']; ?>" />
                        </div>
                        <div class="parent kurs_cur_wrap">
                            <div class="kurs_block_h">Текст:</div>
                            <input type="text" name="i_text_block2" class="admin_form_txt admin_form_txt_middle" maxlength="60" value="<?php echo $landing['block2']['text']; ?>" />
                        </div>
                        <div class="lend_form_h">Кнопка</div>
                        <div class="parent kurs_cur_wrap">
                            <div class="kurs_block_h">Текст кнопки:</div>
                            <input type="text" name="i_button_block2" class="admin_form_txt admin_form_txt_middle" placeholder="Текст кнопки" maxlength="26" value="<?php echo $landing['block2']['button']; ?>" />
                        </div>
                        <div class="lend_form_h">Изображение тренера слева</div>
                        <div class="lend_form_option">
                            <div class="tren_set_form_l">
                                <div class="tren_set_form_img">
                                    <?php if ($landing['block2']['image_default'] === false and is_file($landing['block2']['image_orig'])) :?>
                                        <img src="<?php echo mb_substr($landing['block2']['image_orig'], 1); ?>" alt=""/>
                                        <div class="admin_form_buts parent">
                                            <input type="hidden" name="img_path_2_2" value="<?php echo mb_substr($landing['block2']['image_orig'], 1); ?>">
                                            <input type="submit" name="bt_delete_landing_img[2][2]" class="admin_form_del" value="Удалить">
                                        </div>
                                    <?php else: ?>
                                        <img src="/img/no_img.png" alt="">
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="tren_set_form_r">
                                <div class="tren_form_block_check_wrap">
                                    <input type="checkbox" name="cb_coach_image_block2"
                                        <?php if ($landing['block2']['image_default'] === true) : ?> checked="checked" <?php endif ; ?>
                                           class="tren_form_block_check" id="tren_form_block_check1bi" />
                                    <label for="tren_form_block_check1bi">Изображение по умолчанию</label>
                                </div>
                                <div class="parent kurs_cur_wrap">
                                    <div class="kurs_block_h">Изображение тренера:
                                        <div class="h_subtitle">(354х430)</div></div>
                                    <div class="video_down_line parent">
                                        <div class="video_down_line_but_wrap">
                                            <label for="video_down_line_but1fbi" class="video_down_line_but">
                                                <input type="file" name="coach_file_block2" class="admin_form_videofile" id="video_down_line_but1fbi" accept="image/jpeg,image/png" />
                                                <span>Выберите файл</span>
                                            </label>
                                        </div>
                                        <div class="video_down_line_name">Файл не выбран</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                elseif($lend_block_id == 3): ?>
                    <div class="landing_block" style="display:block;" id="l-block-3">
                        <div class="landing_title">
                            <span>Блок №3</span>
                            <div class="tren_form_block_check_wrap">
                                <input type="checkbox" name="cb_hide_block3"
				                    <?php if ($landing['block3']['hide'] === true) : ?> checked="checked" <?php endif ; ?>
                                       class="tren_form_block_check" id="tren_form_block_check3hb" />
                                <label for="tren_form_block_check3hb">Скрыть блок</label>
                            </div>
                        </div>
                        <img src="/img/landing parts/3.PNG" alt="" class="land_template"/>
                        <div class="lend_form_h">Фон</div>
                        <div class="lend_form_option">
                            <div class="tren_set_form_l">
                                <div class="tren_set_form_img">
                                    <?php if ($landing['block3']['bg_default'] === false and is_file($landing['block3']['bg_orig'])) :
                                        $b3_bg = mb_substr($landing['block3']['bg_orig'], 1); ?>
                                        <img src="<?php echo $b3_bg; ?>" alt=""/>
                                        <div class="admin_form_buts parent">
                                            <input type="hidden" name="img_path_3_0" value="<?php echo $b3_bg; ?>">
                                            <input type="submit" name="bt_delete_landing_img[3][0]" class="admin_form_del" value="Удалить">
                                        </div>
                                    <?php else: ?>
                                        <img src="/img/no_img.png" alt="">
                                    <?php endif;?>
                                </div>
                            </div>
                            <div class="tren_set_form_r">
                                <div class="parent kurs_cur_wrap">
                                    <div class="kurs_block_h">Цвет блока:</div>
                                    <div class="bg_color">
                                        <?php $b3_color = $landing['block3']['bg_color_orig'];?>
                                        <input type="hidden" name="i_bg_color_block3" value="<?php echo $b3_color;?>" id="block_bg_color"/>
                                        <div id="customWidget">
                                            <div class="colorselector"><div style="background-color: <?php echo $b3_color;?>"></div></div>
                                            <div class="colorpickerholder2"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="parent kurs_cur_wrap">
                                    <div class="kurs_block_h">Прозрачность:</div>
                                    <?php $b3_opacity = $landing['block3']['bg_opacity']; ?>
                                    <input type="range" min="0.05" max="1" step="0.05" value="<?php echo $b3_opacity; ?>" class="land_block_opacity">
                                    <input type="text" name="r_opacity_block3" value="<?php echo $b3_opacity; ?>" class="land_block_opacity_val" readonly>
                                </div>
                                <div class="tren_form_block_check_wrap">
                                    <input type="checkbox" name="cb_default_bg_block3"
                                        <?php if ($landing['block3']['bg_default'] === true) : ?> checked="checked" <?php endif ; ?>
                                           class="tren_form_block_check" id="tren_form_block_check3bg">
                                    <label for="tren_form_block_check3bg">Фон по умолчанию</label>
                                </div>
                                <div class="parent kurs_cur_wrap">
                                    <div class="kurs_block_h">Файл фона:
                                        <div class="h_subtitle">(1920х1280)</div></div>
                                    <div class="video_down_line parent">
                                        <div class="video_down_line_but_wrap">
                                            <label for="video_down_line_but3fbg" class="video_down_line_but">
                                                <input type="file" name="bg_file_block3" class="admin_form_videofile" id="video_down_line_but3fbg" accept="image/jpeg,image/png" />
                                                <span>Выберите файл</span>
                                            </label>
                                        </div>
                                        <div class="video_down_line_name">Файл не выбран</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="lend_form_h">Информация</div>
                        <div class="lend_form_h">Заголовок</div>
                        <div class="journal_form_textarea_wrap journal_form_textarea_small">
                            <textarea name="i_title_block3" class="journal_form_textarea formatted_textarea" placeholder="Заголовок" maxlength="60"><?php echo $landing['block3']['bbc_title']; ?></textarea>
                        </div>
                        <div class="lend_form_h">Подзаголовок</div>
                        <div class="journal_form_textarea_wrap journal_form_textarea_small">
                            <textarea name="i_subtitle_block3" class="journal_form_textarea formatted_textarea" placeholder="Подзаголовок" maxlength="60"><?php echo $landing['block3']['bbc_subtitle']; ?></textarea>
                        </div>
                        <!--<div class="parent kurs_cur_wrap">
                            <div class="kurs_block_h">Заголовок:</div>
                            <input type="text" name="i_title_block3" class="admin_form_txt admin_form_txt_middle" maxlength="60" value="<?php /*echo $landing['block3']['title']; */?>" />
                        </div>
                        <div class="parent kurs_cur_wrap">
                            <div class="kurs_block_h">Подзаголовок:</div>
                            <input type="text" name="i_subtitle_block3" class="admin_form_txt admin_form_txt_middle" maxlength="60" value="<?php /*echo $landing['block3']['subtitle']; */?>" />
                        </div>-->
                        <div class="lend_form_h">Результаты</div>
                        <div class="lend_form_options">
                            <div class="lend_form_option">
                                <div class="tren_set_form_l">
                                    <div class="tren_set_form_img">
                                        <?php if ($landing['block3']['image1_default'] === false and is_file($landing['block3']['image1_orig'])) :
                                            $bl3_img1 = mb_substr($landing['block3']['image1_orig'], 1); ?>
                                            <img src="<?php echo $bl3_img1; ?>" alt=""/>
                                            <div class="admin_form_buts parent">
                                                <input type="hidden" name="img_path_3_2_1" value="<?php echo $bl3_img1; ?>">
                                                <input type="submit" name="bt_delete_landing_img[3][2][1]" class="admin_form_del" value="Удалить">
                                            </div>
                                        <?php else: ?>
                                            <img src="/img/no_img.png" alt="">
                                        <?php endif;?>
                                    </div>
                                </div>
                                <div class="tren_set_form_r">
                                    <div class="tren_form_block_check_wrap">
                                        <input type="checkbox" name="cb_photo1_block3"
                                            <?php if ($landing['block3']['image1_default'] === true) : ?> checked="checked" <?php endif ; ?>
                                               class="tren_form_block_check" id="tren_form_block_check2bi" />
                                        <label for="tren_form_block_check2bi">Фото №1 по умолчанию</label>
                                    </div>
                                    <div class="parent kurs_cur_wrap">
                                        <div class="kurs_block_h">Фото №1:
                                            <div class="h_subtitle">(360х400)</div></div>
                                        <div class="video_down_line parent">
                                            <div class="video_down_line_but_wrap">
                                                <label for="video_down_line_but2fbi" class="video_down_line_but">
                                                    <input type="file" name="result_file1_block3" class="admin_form_videofile" id="video_down_line_but2fbi" accept="image/jpeg,image/png" />
                                                    <span>Выберите файл</span>
                                                </label>
                                            </div>
                                            <div class="video_down_line_name">Файл не выбран</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="lend_form_option">
                                <div class="tren_set_form_l">
                                    <div class="tren_set_form_img">
                                        <?php if ($landing['block3']['image2_default'] === false and is_file($landing['block3']['image2_orig'])) :
                                            $bl3_img2 = mb_substr($landing['block3']['image2_orig'], 1); ?>
                                            <img src="<?php echo $bl3_img2; ?>" alt=""/>
                                            <div class="admin_form_buts parent">
                                                <input type="hidden" name="img_path_3_2_2" value="<?php echo $bl3_img2; ?>">
                                                <input type="submit" name="bt_delete_landing_img[3][2][2]" class="admin_form_del" value="Удалить">
                                            </div>
                                        <?php else: ?>
                                            <img src="/img/no_img.png" alt="">
                                        <?php endif;?>
                                    </div>
                                </div>
                                <div class="tren_set_form_r">
                                    <div class="tren_form_block_check_wrap">
                                        <input type="checkbox" name="cb_photo2_block3"
                                            <?php if ($landing['block3']['image2_default'] === true) : ?> checked="checked" <?php endif ; ?>
                                               class="tren_form_block_check" id="tren_form_block_check3bi" />
                                        <label for="tren_form_block_check3bi">Фото №2 по умолчанию</label>
                                    </div>
                                    <div class="parent kurs_cur_wrap">
                                        <div class="kurs_block_h">Фото №2:
                                            <div class="h_subtitle">(360х400)</div></div>
                                        <div class="video_down_line parent">
                                            <div class="video_down_line_but_wrap">
                                                <label for="video_down_line_but3fbi" class="video_down_line_but">
                                                    <input type="file" name="result_file2_block3" class="admin_form_videofile" id="video_down_line_but3fbi" accept="image/jpeg,image/png" />
                                                    <span>Выберите файл</span>
                                                </label>
                                            </div>
                                            <div class="video_down_line_name">Файл не выбран</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="lend_form_h">Заголовок</div>
                        <div class="journal_form_textarea_wrap journal_form_textarea_small">
                            <textarea name="i_result_title_block3" class="journal_form_textarea formatted_textarea" maxlength="60"><?php echo $landing['block3']['bbc_r_title']; ?></textarea>
                        </div>
                        <!--<div class="parent kurs_cur_wrap">
                            <div class="kurs_block_h">Заголовок:</div>
                            <input type="text" name="i_result_title_block3" class="admin_form_txt admin_form_txt_middle" maxlength="60" value="<?php /*echo $landing['block3']['r_title']; */?>" />
                        </div>-->
                        <div class="lend_form_h">Подзаголовок</div>
                        <div class="journal_form_textarea_wrap journal_form_textarea_small">
                            <textarea name="i_result_subtitle_block3" class="journal_form_textarea formatted_textarea" maxlength="60"><?php echo $landing['block3']['bbc_r_subtitle']; ?></textarea>
                        </div>
                        <!--<div class="parent kurs_cur_wrap">
                            <div class="kurs_block_h">Подзаголовок:</div>
                            <input type="text" name="i_result_subtitle_block3" class="admin_form_txt admin_form_txt_middle" maxlength="60" value="<?php /*echo $landing['block3']['r_subtitle']; */?>" />
                        </div>-->
                        <div class="lend_form_h">Отзыв пользователя:</div>
                        <div class="journal_form_textarea_wrap journal_form_textarea_small">
                            <textarea name="i_result_reviews_block3" class="journal_form_textarea formatted_textarea" maxlength="80"><?php echo $landing['block3']['bbc_r_reviews']; ?></textarea>
                        </div>
                        <!--<div class="parent kurs_cur_wrap">
                            <div class="kurs_block_h">Отзыв пользователя:</div>
                            <input type="text" name="i_result_reviews_block3" class="admin_form_txt admin_form_txt_middle" maxlength="80" value="<?php /*echo $landing['block3']['r_reviews']; */?>" />
                        </div>-->
                    </div>
                <?php
                elseif($lend_block_id == 4): ?>
                    <div class="landing_block" style="display:block;" id="l-block-4">
                        <div class="landing_title">
                            <span>Блок №4</span>
                            <div class="tren_form_block_check_wrap">
                                <input type="checkbox" name="cb_hide_block4"
				                    <?php if ($landing['block4']['hide'] === true) : ?> checked="checked" <?php endif ; ?>
                                       class="tren_form_block_check" id="tren_form_block_check4hb" />
                                <label for="tren_form_block_check4hb">Скрыть блок</label>
                            </div>
                        </div>
                        <img src="/img/landing parts/4.PNG" alt="" class="land_template"/>
                        <div class="lend_form_h">Фон</div>
                        <div class="lend_form_option">
                            <div class="tren_set_form_l">
                                <div class="tren_set_form_img">
                                    <?php if ($landing['block4']['bg_default'] === false and is_file($landing['block4']['bg_orig'])) :?>
                                        <img src="<?php echo mb_substr($landing['block4']['bg_orig'], 1); ?>" alt=""/>
                                            <div class="admin_form_buts parent">
                                                <input type="hidden" name="img_path_4_0" value="<?php echo mb_substr($landing['block4']['bg_orig'], 1); ?>">
                                                <input type="submit" name="bt_delete_landing_img[4][0]" class="admin_form_del" value="Удалить">
                                            </div>
                                    <?php else: ?>
                                        <img src="/img/no_img.png" alt="">
                                    <?php endif;?>
                                </div>
                            </div>
                            <div class="tren_set_form_r">
                                <div class="parent kurs_cur_wrap">
                                    <div class="kurs_block_h">Цвет блока:</div>
                                    <div class="bg_color">
                                        <?php $b4_color = $landing['block4']['bg_color_orig'];?>
                                        <input type="hidden" name="i_bg_color_block4" value="<?php echo $b4_color;?>" id="block_bg_color"/>
                                        <div id="customWidget">
                                            <div class="colorselector"><div style="background-color: <?php echo $b4_color;?>"></div></div>
                                            <div class="colorpickerholder2"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="parent kurs_cur_wrap">
                                    <div class="kurs_block_h">Прозрачность:</div>
                                    <?php $b4_opacity = $landing['block4']['bg_opacity']; ?>
                                    <input type="range" min="0.05" max="1" step="0.05" value="<?php echo $b4_opacity; ?>" class="land_block_opacity">
                                    <input type="text" name="r_opacity_block4" value="<?php echo $b4_opacity; ?>" class="land_block_opacity_val" readonly>
                                </div>
                                <div class="tren_form_block_check_wrap">
                                    <input type="checkbox" name="cb_default_bg_block4"
                                        <?php if ($landing['block4']['bg_default'] === true) : ?> checked="checked" <?php endif ; ?>
                                           class="tren_form_block_check" id="tren_form_block_check4bg">
                                    <label for="tren_form_block_check4bg">Фон по умолчанию</label>
                                </div>
                                <div class="parent kurs_cur_wrap">
                                    <div class="kurs_block_h">Файл фона:
                                        <div class="h_subtitle">(1920х525)</div></div>
                                    <div class="video_down_line parent">
                                        <div class="video_down_line_but_wrap">
                                            <label for="video_down_line_but4fbg" class="video_down_line_but">
                                                <input type="file" name="bg_file_block4" class="admin_form_videofile" id="video_down_line_but4fbg" accept="image/jpeg,image/png" />
                                                <span>Выберите файл</span>
                                            </label>
                                        </div>
                                        <div class="video_down_line_name">Файл не выбран</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="lend_form_h">Информация</div>
                        <!--<div class="parent kurs_cur_wrap">
                            <div class="kurs_block_h">Заголовок:</div>
                            <input type="text" name="i_title_block4" class="admin_form_txt admin_form_txt_middle" maxlength="60" value="<?php /*echo $landing['block4']['title']; */?>" />
                        </div>-->
                        <div class="lend_form_h">Заголовок</div>
                        <div class="journal_form_textarea_wrap journal_form_textarea_small">
                            <textarea name="i_title_block4" class="journal_form_textarea formatted_textarea" maxlength="60"><?php echo $landing['block4']['bbc_title']; ?></textarea>
                        </div>
                        <!--<div class="parent kurs_cur_wrap">
                            <div class="kurs_block_h">Подзаголовок:</div>
                            <input type="text" name="i_subtitle_block4" class="admin_form_txt admin_form_txt_middle" maxlength="80" value="<?php /*echo $landing['block4']['subtitle']; */?>" />
                        </div>-->
                        <div class="lend_form_h">Подзаголовок</div>
                        <div class="journal_form_textarea_wrap journal_form_textarea_small">
                            <textarea name="i_subtitle_block4" class="journal_form_textarea formatted_textarea" maxlength="80"><?php echo $landing['block4']['bbc_subtitle']; ?></textarea>
                        </div>
                        <div class="lend_form_h">Изображение справа</div>
                        <div class="lend_form_option">
                            <div class="tren_set_form_l">
                                <div class="tren_set_form_img">
                                    <?php if ($landing['block4']['image_default'] === false and is_file($landing['block4']['image_orig'])) :?>
                                        <img src="<?php echo mb_substr($landing['block4']['image_orig'], 1); ?>" alt=""/>
                                            <div class="admin_form_buts parent">
                                                <input type="hidden" name="img_path_4_2" value="<?php echo mb_substr($landing['block4']['image_orig'], 1); ?>">
                                                <input type="submit" name="bt_delete_landing_img[4][2]" class="admin_form_del" value="Удалить">
                                            </div>
                                    <?php else: ?>
                                        <img src="/img/no_img.png" alt="">
                                    <?php endif;?>
                                </div>
                            </div>
                            <div class="tren_set_form_r">
                                <div class="tren_form_block_check_wrap">
                                    <input type="checkbox" name="cb_photo_block4"
                                        <?php if ($landing['block4']['image_default'] === true) : ?> checked="checked" <?php endif ; ?>
                                           class="tren_form_block_check" id="tren_form_block_check4bi" />
                                    <label for="tren_form_block_check4bi">Изображение по умолчанию</label>
                                </div>
                                <div class="parent kurs_cur_wrap">
                                    <div class="kurs_block_h">Изображение:
                                        <div class="h_subtitle">(570х435)</div></div>
                                    <div class="video_down_line parent">
                                        <div class="video_down_line_but_wrap">
                                            <label for="video_down_line_but4fbi" class="video_down_line_but">
                                                <input type="file" name="result_file_block4" class="admin_form_videofile" id="video_down_line_but4fbi" accept="image/jpeg,image/png" />
                                                <span>Выберите файл</span>
                                            </label>
                                        </div>
                                        <div class="video_down_line_name">Файл не выбран</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--<div class="parent kurs_cur_wrap">
                            <div class="kurs_block_h">Заголовок:</div>
                            <input type="text" name="i_result_title_block4" class="admin_form_txt admin_form_txt_middle" maxlength="60" value="<?php /*echo $landing['block4']['r_title']; */?>" />
                        </div>-->
                        <div class="lend_form_h">Заголовок</div>
                        <div class="journal_form_textarea_wrap journal_form_textarea_small">
                            <textarea name="i_result_title_block4" class="journal_form_textarea formatted_textarea" maxlength="60"><?php echo $landing['block4']['bbc_r_title']; ?></textarea>
                        </div>
                        <!--<div class="parent kurs_cur_wrap">
                            <div class="kurs_block_h">Описание:</div>
                            <input type="text" name="i_result_desc_block4" class="admin_form_txt admin_form_txt_middle" maxlength="60" value="<?php /*echo $landing['block4']['r_subtitle']; */?>" />
                        </div>-->
                        <div class="lend_form_h">Описание</div>
                        <div class="journal_form_textarea_wrap journal_form_textarea_small">
                            <textarea name="i_result_desc_block4" class="journal_form_textarea formatted_textarea" maxlength="60"><?php echo $landing['block4']['bbc_r_subtitle']; ?></textarea>
                        </div>
                        <div class="lend_form_h">Кнопка</div>
                        <div class="parent kurs_cur_wrap">
                            <div class="kurs_block_h">Текст кнопки:</div>
                            <input type="text" name="i_button_block4" class="admin_form_txt admin_form_txt_middle" maxlength="26" value="<?php echo $landing['block4']['button']; ?>" />
                        </div>
                    </div>
                <?php
                elseif($lend_block_id == 5): ?>
                    <div class="landing_block" style="display:block;" id="l-block-5">
                        <div class="landing_title">
                            <span>Блок №5</span>
                            <div class="tren_form_block_check_wrap">
                                <input type="checkbox" name="cb_hide_block5"
				                    <?php if ($landing['block5']['hide'] === true) : ?> checked="checked" <?php endif ; ?>
                                       class="tren_form_block_check" id="tren_form_block_check5hb" />
                                <label for="tren_form_block_check5hb">Скрыть блок</label>
                            </div>
                        </div>
                        <img src="/img/landing parts/5.PNG" alt="" class="land_template"/>
                        <div class="lend_form_h">Фон</div>
                        <div class="lend_form_option">
                            <div class="tren_set_form_l">
                                <div class="tren_set_form_img">
                                    <?php if ($landing['block5']['bg_default'] === false and is_file($landing['block5']['bg_orig'])) :?>
                                        <img src="<?php echo mb_substr($landing['block5']['bg_orig'], 1); ?>" alt=""/>
                                        <div class="admin_form_buts parent">
                                            <input type="hidden" name="img_path_5_0" value="<?php echo mb_substr($landing['block5']['bg_orig'], 1); ?>">
                                            <input type="submit" name="bt_delete_landing_img[5][0]" class="admin_form_del" value="Удалить">
                                        </div>
                                    <?php else:?>
                                        <img src="/img/no_img.png" alt="">
                                    <?php endif;?>
                                </div>
                            </div>
                            <div class="tren_set_form_r">
                                <div class="parent kurs_cur_wrap">
                                    <div class="kurs_block_h">Цвет блока:</div>
                                    <div class="bg_color">
                                        <?php $b5_color = $landing['block5']['bg_color_orig'];?>
                                        <input type="hidden" name="i_bg_color_block5" value="<?php echo $b5_color;?>" id="block_bg_color"/>
                                        <div id="customWidget">
                                            <div class="colorselector"><div style="background-color: <?php echo $b5_color;?>"></div></div>
                                            <div class="colorpickerholder2"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="parent kurs_cur_wrap">
                                    <div class="kurs_block_h">Прозрачность:</div>
                                    <?php $b5_opacity = $landing['block5']['bg_opacity']; ?>
                                    <input type="range" min="0.05" max="1" step="0.05" value="<?php echo $b5_opacity; ?>" class="land_block_opacity">
                                    <input type="text" name="r_opacity_block5" value="<?php echo $b5_opacity; ?>" class="land_block_opacity_val" readonly>
                                </div>
                                <div class="tren_form_block_check_wrap">
                                    <input type="checkbox" name="cb_default_bg_block5"
                                        <?php if ($landing['block5']['bg_default'] === true) : ?> checked="checked" <?php endif ; ?>
                                           class="tren_form_block_check" id="tren_form_block_check5bg">
                                    <label for="tren_form_block_check5bg">Фон по умолчанию</label>
                                </div>
                                <div class="parent kurs_cur_wrap">
                                    <div class="kurs_block_h">Файл фона:</div>
                                    <div class="video_down_line parent">
                                        <div class="video_down_line_but_wrap">
                                            <label for="video_down_line_but5fbg" class="video_down_line_but">
                                                <input type="file" name="bg_file_block5" class="admin_form_videofile" id="video_down_line_but5fbg" accept="image/jpeg,image/png" />
                                                <span>Выберите файл</span>
                                            </label>
                                        </div>
                                        <div class="video_down_line_name">Файл не выбран</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="lend_form_h">Информация</div>
                        <div class="parent kurs_cur_wrap">
                            <div class="kurs_block_h">Имя тренера:</div>
                            <input type="text" name="i_title_block5" class="admin_form_txt admin_form_txt_middle" maxlength="60" value="<?php echo $landing['block5']['title']; ?>" />
                        </div>
                        <div class="parent kurs_cur_wrap">
                            <div class="kurs_block_h">Специализация:</div>
                            <input type="text" name="i_subtitle_block5" class="admin_form_txt admin_form_txt_middle" maxlength="60" value="<?php echo $landing['block5']['subtitle']; ?>" />
                        </div>
                        <div class="parent kurs_cur_wrap">
                            <div class="kurs_block_h">Текст:</div>
                            <input type="text" name="i_text_block5" class="admin_form_txt admin_form_txt_middle" maxlength="255" value="<?php echo $landing['block5']['text']; ?>" />
                        </div>
                        <div class="lend_form_h">Изображения тренера</div>
                        <div class="lend_form_options">
                            <div class="lend_form_option">
                                <div class="tren_set_form_l">
                                    <div class="tren_set_form_img">
                                        <?php if ($landing['block5']['image1_default'] === false and is_file($landing['block5']['image1_orig'])) :
                                            $bl5_img1 = mb_substr($landing['block5']['image1_orig'], 1);?>
                                            <img src="<?php echo $bl5_img1; ?>" alt=""/>
                                            <div class="admin_form_buts parent">
                                                <input type="hidden" name="img_path_5_2_1" value="<?php echo $bl5_img1; ?>">
                                                <input type="submit" name="bt_delete_landing_img[5][2][1]" class="admin_form_del" value="Удалить">
                                            </div>
                                        <?php else: ?>
                                            <img src="/img/no_img.png" alt="">
                                        <?php endif;?>
                                    </div>
                                </div>
                                <div class="tren_set_form_r">
                                    <div class="tren_form_block_check_wrap">
                                        <input type="checkbox" name="cb_photo1_block5"
                                            <?php if ($landing['block5']['image1_default'] === true) : ?> checked="checked" <?php endif ; ?>
                                               class="tren_form_block_check" id="tren_form_block_check5bi" />
                                        <label for="tren_form_block_check5bi">Боковое фото №1 по умолчанию</label>
                                    </div>
                                    <div class="parent kurs_cur_wrap">
                                        <div class="kurs_block_h">Боковое фото №1:
                                            <div class="h_subtitle">(293х390)</div>
                                        </div>
                                        <div class="video_down_line parent">
                                            <div class="video_down_line_but_wrap">
                                                <label for="video_down_line_but5fbi" class="video_down_line_but">
                                                    <input type="file" name="coach_file1_block5" class="admin_form_videofile" id="video_down_line_but5fbi" accept="image/jpeg,image/png" />
                                                    <span>Выберите файл</span>
                                                </label>
                                            </div>
                                            <div class="video_down_line_name">Файл не выбран</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="lend_form_option">
                                <div class="tren_set_form_l">
                                    <div class="tren_set_form_img">
                                        <?php if ($landing['block5']['image2_default'] === false and is_file($landing['block5']['image2_orig'])) :
                                            $bl5_img2 = mb_substr($landing['block5']['image2_orig'], 1);?>
                                            <img src="<?php echo $bl5_img2 ?>" alt=""/>
                                            <div class="admin_form_buts parent">
                                                <input type="hidden" name="img_path_5_2_2" value="<?php echo $bl5_img2; ?>">
                                                <input type="submit" name="bt_delete_landing_img[5][2][2]" class="admin_form_del" value="Удалить">
                                            </div>
                                        <?php else: ?>
                                            <img src="/img/no_img.png" alt="">
                                        <?php endif;?>
                                    </div>
                                </div>
                                <div class="tren_set_form_r">
                                    <div class="tren_form_block_check_wrap">
                                        <input type="checkbox" name="cb_photo2_block5"
                                            <?php if ($landing['block5']['image2_default'] === true) : ?> checked="checked" <?php endif ; ?>
                                               class="tren_form_block_check" id="tren_form_block_check6bi" />
                                        <label for="tren_form_block_check6bi">Боковое фото №2 по умолчанию</label>
                                    </div>
                                    <div class="parent kurs_cur_wrap">
                                        <div class="kurs_block_h">Боковое фото №2:
                                            <div class="h_subtitle">(293х390)</div></div>
                                        <div class="video_down_line parent">
                                            <div class="video_down_line_but_wrap">
                                                <label for="video_down_line_but6fbi" class="video_down_line_but">
                                                    <input type="file" name="coach_file2_block5" class="admin_form_videofile" id="video_down_line_but6fbi" accept="image/jpeg,image/png" />
                                                    <span>Выберите файл</span>
                                                </label>
                                            </div>
                                            <div class="video_down_line_name">Файл не выбран</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="lend_form_option">
                                <div class="tren_set_form_l">
                                    <div class="tren_set_form_img">
                                        <?php if ($landing['block5']['image3_default'] === false and is_file($landing['block5']['image3_orig'])) :
                                            $bl5_img3 = mb_substr($landing['block5']['image3_orig'], 1);?>
                                            <img src="<?php echo $bl5_img3; ?>" alt="" style="height:120px;"/>
                                            <div class="admin_form_buts parent">
                                                <input type="hidden" name="img_path_5_2_3" value="<?php echo $bl5_img3; ?>">
                                                <input type="submit" name="bt_delete_landing_img[5][2][3]" class="admin_form_del" value="Удалить">
                                            </div>
                                        <?php else: ?>
                                            <img src="/img/no_img.png" alt="">
                                        <?php endif;?>
                                    </div>
                                </div>
                                <div class="tren_set_form_r">
                                    <div class="tren_form_block_check_wrap">
                                        <input type="checkbox" name="cb_photo3_block5"
                                            <?php if ($landing['block5']['image3_default'] === true) : ?> checked="checked" <?php endif ; ?>
                                               class="tren_form_block_check" id="tren_form_block_check7bi" />
                                        <label for="tren_form_block_check7bi">Аватар по умолчанию</label>
                                    </div>
                                    <div class="parent kurs_cur_wrap">
                                        <div class="kurs_block_h">Аватар:
                                            <div class="h_subtitle">(120х120)</div>
                                        </div>
                                        <div class="video_down_line parent">
                                            <div class="video_down_line_but_wrap">
                                                <label for="video_down_line_but7fbi" class="video_down_line_but">
                                                    <input type="file" name="coach_avatar_block5" class="admin_form_videofile" id="video_down_line_but7fbi" accept="image/jpeg,image/png" />
                                                    <span>Выберите файл</span>
                                                </label>
                                            </div>
                                            <div class="video_down_line_name">Файл не выбран</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="lend_form_h">Слова тренера о программе</div>
                        <div class="parent kurs_cur_wrap">
                            <div class="kurs_block_h">Заголовок:</div>
                            <input type="text" name="i_coach_title_block5" class="admin_form_txt admin_form_txt_middle" maxlength="50" value="<?php echo $landing['block5']['r_title']; ?>" />
                        </div>
                        <div class="parent kurs_cur_wrap">
                            <div class="kurs_block_h">Подзаголовок:</div>
                            <input type="text" name="i_coach_subtitle_block5" class="admin_form_txt admin_form_txt_middle" maxlength="50" value="<?php echo $landing['block5']['r_subtitle']; ?>" />
                        </div>
                        <div class="parent kurs_cur_wrap">
                            <div class="kurs_block_h">Текст:</div>
                            <input type="text" name="i_coach_text_block5" class="admin_form_txt admin_form_txt_middle" maxlength="120" value="<?php echo $landing['block5']['r_text']; ?>" />
                        </div>
                        <div class="lend_form_h">Кнопка</div>
                        <div class="parent kurs_cur_wrap">
                            <div class="kurs_block_h">Текст кнопки:</div>
                            <input type="text" name="i_button_block5" class="admin_form_txt admin_form_txt_middle" maxlength="26" value="<?php echo $landing['block5']['button']; ?>" />
                        </div>
                    </div>
                <?php
                elseif($lend_block_id == 6): ?>
                    <div class="landing_block" style="display:block;" id="l-block-6">
                        <div class="landing_title">
                            <span>Блок №6</span>
                            <div class="tren_form_block_check_wrap">
                                <input type="checkbox" name="cb_hide_block6"
				                    <?php if ($landing['block6']['hide'] === true) : ?> checked="checked" <?php endif ; ?>
                                       class="tren_form_block_check" id="tren_form_block_check6hb" />
                                <label for="tren_form_block_check6hb">Скрыть блок</label>
                            </div>
                        </div>
                        <img src="/img/landing parts/6.PNG" alt="" class="land_template"/>
                        <div class="lend_form_h">Фон</div>
                        <div class="lend_form_option">
                            <div class="tren_set_form_l">
                                <div class="tren_set_form_img">
                                    <?php if ($landing['block6']['bg_default'] === false and is_file($landing['block6']['bg_orig'])) :?>
                                        <img src="<?php echo mb_substr($landing['block6']['bg_orig'], 1); ?>" alt=""/>
                                        <div class="admin_form_buts parent">
                                            <input type="hidden" name="img_path_6_0" value="<?php echo mb_substr($landing['block6']['bg_orig'], 1); ?>">
                                            <input type="submit" name="bt_delete_landing_img[6][0]" class="admin_form_del" value="Удалить">
                                        </div>
                                    <?php else: ?>
                                        <img src="/img/no_img.png" alt="">
                                    <?php endif;?>
                                </div>
                            </div>
                            <div class="tren_set_form_r">
                                <div class="parent kurs_cur_wrap">
                                    <div class="kurs_block_h">Цвет блока:</div>
                                    <div class="bg_color">
                                        <?php $b6_color = $landing['block6']['bg_color_orig'];?>
                                        <input type="hidden" name="i_bg_color_block6" value="<?php echo $b6_color;?>" id="block_bg_color"/>
                                        <div id="customWidget">
                                            <div class="colorselector"><div style="background-color: <?php echo $b6_color;?>"></div></div>
                                            <div class="colorpickerholder2"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="parent kurs_cur_wrap">
                                    <div class="kurs_block_h">Прозрачность:</div>
                                    <?php $b6_opacity = $landing['block6']['bg_opacity']; ?>
                                    <input type="range" min="0.05" max="1" step="0.05" value="<?php echo $b6_opacity; ?>" class="land_block_opacity">
                                    <input type="text" name="r_opacity_block6" value="<?php echo $b6_opacity; ?>" class="land_block_opacity_val" readonly>
                                </div>
                                <div class="tren_form_block_check_wrap">
                                    <input type="checkbox" name="cb_default_bg_block6"
                                        <?php if ($landing['block6']['bg_default'] === true) : ?> checked="checked" <?php endif ; ?>
                                           class="tren_form_block_check" id="tren_form_block_check6bg">
                                    <label for="tren_form_block_check6bg">Фон по умолчанию</label>
                                </div>
                                <div class="parent kurs_cur_wrap">
                                    <div class="kurs_block_h">Файл фона:
                                        <div class="h_subtitle">(1920х1080)</div></div>
                                    <div class="video_down_line parent">
                                        <div class="video_down_line_but_wrap">
                                            <label for="video_down_line_but6fbg" class="video_down_line_but">
                                                <input type="file" name="bg_file_block6" class="admin_form_videofile" id="video_down_line_but6fbg" accept="image/jpeg,image/png" />
                                                <span>Выберите файл</span>
                                            </label>
                                        </div>
                                        <div class="video_down_line_name">Файл не выбран</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="lend_form_h">Информация</div>
                        <div class="parent kurs_cur_wrap">
                            <div class="kurs_block_h">Заголовок:</div>
                            <input type="text" name="i_title_block6" class="admin_form_txt admin_form_txt_middle" maxlength="60" value="<?php echo $landing['block6']['title']; ?>" />
                        </div>
                        <div class="parent kurs_cur_wrap">
                            <div class="kurs_block_h">Описание:</div>
                            <textarea name="ta_desc_block6" class="journal_form_textarea admin_form_txt_middle" maxlength="130"><?php echo $landing['block6']['desc']; ?></textarea>
                        </div>
                        <div class="parent kurs_cur_wrap">
                            <div class="kurs_block_h">Подзаголовок:</div>
                            <input type="text" name="i_subtitle_block6" class="admin_form_txt admin_form_txt_middle" maxlength="60" value="<?php echo $landing['block6']['subtitle']; ?>" />
                        </div>
                        <div class="lend_form_h">Изображение слева</div>
                        <div class="lend_form_option">
                            <div class="tren_set_form_l">
                                <div class="tren_set_form_img">
                                    <?php if ($landing['block6']['image_default'] === false and is_file($landing['block6']['image_orig'])) :?>
                                        <img src="<?php echo mb_substr($landing['block6']['image_orig'], 1); ?>" alt=""/>
                                        <div class="admin_form_buts parent">
                                            <input type="hidden" name="img_path_6_2" value="<?php echo mb_substr($landing['block6']['image_orig'], 1); ?>">
                                            <input type="submit" name="bt_delete_landing_img[6][2]" class="admin_form_del" value="Удалить">
                                        </div>
                                    <?php else: ?>
                                        <img src="/img/no_img.png" alt="">
                                    <?php endif;?>
                                </div>
                            </div>
                            <div class="tren_set_form_r">
                                <div class="tren_form_block_check_wrap">
                                    <input type="checkbox" name="cb_photo_block6"
                                        <?php if ($landing['block6']['image_default'] === true) : ?> checked="checked" <?php endif ; ?>
                                           class="tren_form_block_check" id="tren_form_block_check8bi" />
                                    <label for="tren_form_block_check8bi">Изображение по умолчанию</label>
                                </div>
                                <div class="parent kurs_cur_wrap">
                                    <div class="kurs_block_h">Изображение:
                                        <div class="h_subtitle">(252х441)</div></div>
                                    <div class="video_down_line parent">
                                        <div class="video_down_line_but_wrap">
                                            <label for="video_down_line_but8fbi" class="video_down_line_but">
                                                <input type="file" name="file_block6" class="admin_form_videofile" id="video_down_line_but8fbi" accept="image/jpeg,image/png" />
                                                <span>Выберите файл</span>
                                            </label>
                                        </div>
                                        <div class="video_down_line_name">Файл не выбран</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="lend_form_h">Преимущества (рекомендация: 2 преимущества)</div>
                        <div class="lend_form_options_wrap">
                            <div class="lend_form_options">
                                <?php if (!empty($landing['block6']['advantages'])) :
                                    foreach ($landing['block6']['advantages'] as $advantage) : ?>
                                        <div class="parent kurs_cur_wrap">
                                            <div class="kurs_block_h">Преимущество:</div>
                                            <input type="text" name="i_advantages_block6[]" class="admin_form_txt admin_form_txt_middle" value="<?php echo $advantage; ?>" maxlength="70"/>
                                        </div>
                                    <?php endforeach;
                                    unset($advantage);
                                else :?>
                                    <div class="parent kurs_cur_wrap">
                                        <div class="kurs_block_h">Преимущество:</div>
                                        <input type="text" name="i_advantages_block6[]" class="admin_form_txt admin_form_txt_middle" value="" maxlength="70"/>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="add_new_options_but add_form_advantage">+ добавить преимущество</div>
                        </div>
                        <div class="lend_form_h">Кнопка</div>
                        <div class="parent kurs_cur_wrap">
                            <div class="kurs_block_h">Текст кнопки:</div>
                            <input type="text" name="i_button_block6" class="admin_form_txt admin_form_txt_middle" maxlength="26" value="<?php echo $landing['block6']['button']; ?>" />
                        </div>
                    </div>
                <?php
                elseif($lend_block_id == 7): ?>
                    <div class="landing_block" style="display:block;" id="l-block-7">
                        <div class="landing_title">
                            <span>Блок №7</span>
                            <div class="tren_form_block_check_wrap">
                                <input type="checkbox" name="cb_hide_block7"
				                    <?php if ($landing['block7']['hide'] === true) : ?> checked="checked" <?php endif ; ?>
                                       class="tren_form_block_check" id="tren_form_block_check7hb" />
                                <label for="tren_form_block_check7hb">Скрыть блок</label>
                            </div>
                        </div>
                        <img src="/img/landing parts/7.PNG" alt="" class="land_template"/>
                        <div class="lend_form_h">Фон</div>
                        <div class="lend_form_option">
                            <div class="tren_set_form_l">
                                <div class="tren_set_form_img">
                                    <?php if ($landing['block7']['bg_default'] === false and is_file($landing['block7']['bg_orig'])) :?>
                                        <img src="<?php echo mb_substr($landing['block7']['bg_orig'], 1); ?>" alt=""/>
                                        <div class="admin_form_buts parent">
                                            <input type="hidden" name="img_path_7_0" value="<?php echo mb_substr($landing['block7']['bg_orig'], 1); ?>">
                                            <input type="submit" name="bt_delete_landing_img[7][0]" class="admin_form_del" value="Удалить">
                                        </div>
                                    <?php else: ?>
                                        <img src="/img/no_img.png" alt="">
                                    <?php endif;?>
                                </div>
                            </div>
                            <div class="tren_set_form_r">
                                <div class="parent kurs_cur_wrap">
                                    <div class="kurs_block_h">Цвет блока:</div>
                                    <div class="bg_color">
                                        <?php $b7_color = $landing['block7']['bg_color_orig'];?>
                                        <input type="hidden" name="i_bg_color_block7" value="<?php echo $b7_color;?>" id="block_bg_color"/>
                                        <div id="customWidget">
                                            <div class="colorselector"><div style="background-color: <?php echo $b7_color;?>"></div></div>
                                            <div class="colorpickerholder2"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="parent kurs_cur_wrap">
                                    <div class="kurs_block_h">Прозрачность:</div>
                                    <?php $b7_opacity = $landing['block7']['bg_opacity']; ?>
                                    <input type="range" min="0.05" max="1" step="0.05" value="<?php echo $b7_opacity; ?>" class="land_block_opacity">
                                    <input type="text" name="r_opacity_block7" value="<?php echo $b7_opacity; ?>" class="land_block_opacity_val" readonly>
                                </div>
                                <div class="tren_form_block_check_wrap">
                                    <input type="checkbox" name="cb_default_bg_block7"
                                        <?php if ($landing['block7']['bg_default'] === true) : ?> checked="checked" <?php endif ; ?>
                                           class="tren_form_block_check" id="tren_form_block_check7bg">
                                    <label for="tren_form_block_check7bg">Фон по умолчанию</label>
                                </div>
                                <div class="parent kurs_cur_wrap">
                                    <div class="kurs_block_h">Файл фона:</div>
                                    <div class="video_down_line parent">
                                        <div class="video_down_line_but_wrap">
                                            <label for="video_down_line_but7fbg" class="video_down_line_but">
                                                <input type="file" name="bg_file_block7" class="admin_form_videofile" id="video_down_line_but7fbg" accept="image/jpeg,image/png" />
                                                <span>Выберите файл</span>
                                            </label>
                                        </div>
                                        <div class="video_down_line_name">Файл не выбран</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="lend_form_h">Информация</div>
                        <div class="parent kurs_cur_wrap">
                            <div class="kurs_block_h">Заголовок:</div>
                            <input type="text" name="i_title_block7" class="admin_form_txt admin_form_txt_middle" maxlength="50" value="<?php echo $landing['block7']['title']; ?>" />
                        </div>
                        <div class="lend_form_h">Изображения и текст</div>
                        <div class="lend_form_options_wrap">
                            <div class="lend_form_options">
                                <div class="lend_form_option">
                                    <div class="tren_set_form_l">
                                        <div class="tren_set_form_img">
                                            <?php if ($landing['block7']['image1_default'] === false and is_file($landing['block7']['image1_orig'])) :
                                                $bl7_img1 = mb_substr($landing['block7']['image1_orig'], 1);?>
                                                <img src="<?php echo $bl7_img1; ?>" alt=""/>
                                                <div class="admin_form_buts parent">
                                                    <input type="hidden" name="img_path_7_2_1" value="<?php echo $bl7_img1; ?>">
                                                    <input type="submit" name="bt_delete_landing_img[7][2][1]" class="admin_form_del" value="Удалить">
                                                </div>
                                            <?php else: ?>
                                                <img src="/img/no_img.png" alt="">
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="tren_set_form_r">
                                        <div class="tren_form_block_check_wrap">
                                            <input type="checkbox" name="cb_image1_block7"
                                                <?php if ($landing['block7']['image1_default'] === true) : ?> checked="checked" <?php endif ; ?>
                                                   class="tren_form_block_check" id="tren_form_block_check15e1" />
                                            <label for="tren_form_block_check15e1">Изображение по умолчанию</label>
                                        </div>
                                        <div class="parent kurs_cur_wrap" style="max-height: 72px;">
                                            <div class="kurs_block_h">
                                                Изображение:
                                                <div class="h_subtitle">(285х285)</div>
                                            </div>
                                            <div class="video_down_line parent">
                                                <div class="video_down_line_but_wrap">
                                                    <label for="video_down_line_but1p" class="video_down_line_but">
                                                        <input type="file" name="file1_block7" class="admin_form_videofile" id="video_down_line_but1p" accept="image/jpeg,image/png" />
                                                        <span>Выберите файл</span>
                                                    </label>
                                                </div>
                                                <div class="video_down_line_name">Файл не выбран</div>
                                            </div>
                                        </div>
                                        <div class="parent kurs_cur_wrap">
                                            <div class="kurs_block_h">Текст плана:</div>
                                            <input type="text" name="i_text_block7[1]" class="admin_form_txt admin_form_txt_middle" value="<?php echo $landing['block7']['texts'][1];?>" maxlength="160"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="lend_form_option">
                                    <div class="tren_set_form_l">
                                        <div class="tren_set_form_img">
                                            <?php if ($landing['block7']['image2_default'] === false and is_file($landing['block7']['image2_orig'])) :
                                                $bl7_img2 = mb_substr($landing['block7']['image2_orig'], 1);?>
                                                <img src="<?php echo $bl7_img2; ?>" alt=""/>
                                                <div class="admin_form_buts parent">
                                                    <input type="hidden" name="img_path_7_2_2" value="<?php echo $bl7_img2; ?>">
                                                    <input type="submit" name="bt_delete_landing_img[7][2][2]" class="admin_form_del" value="Удалить">
                                                </div>
                                            <?php else: ?>
                                                <img src="/img/no_img.png" alt="">
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="tren_set_form_r">
                                        <div class="tren_form_block_check_wrap">
                                            <input type="checkbox" name="cb_image2_block7"
                                                <?php if ($landing['block7']['image2_default'] === true) : ?> checked="checked" <?php endif ; ?>
                                                   class="tren_form_block_check" id="tren_form_block_check15e2" />
                                            <label for="tren_form_block_check15e2">Изображение по умолчанию</label>
                                        </div>
                                        <div class="parent kurs_cur_wrap" style="max-height: 72px;">
                                            <div class="kurs_block_h">
                                                Изображение:
                                                <div class="h_subtitle">(285х285)</div>
                                            </div>
                                            <div class="video_down_line parent">
                                                <div class="video_down_line_but_wrap">
                                                    <label for="video_down_line_but2p" class="video_down_line_but">
                                                        <input type="file" name="file2_block7" class="admin_form_videofile" id="video_down_line_but2p" accept="image/jpeg,image/png" />
                                                        <span>Выберите файл</span>
                                                    </label>
                                                </div>
                                                <div class="video_down_line_name">Файл не выбран</div>
                                            </div>
                                        </div>
                                        <div class="parent kurs_cur_wrap">
                                            <div class="kurs_block_h">Текст плана:</div>
                                            <input type="text" name="i_text_block7[2]" class="admin_form_txt admin_form_txt_middle" value="<?php echo $landing['block7']['texts'][2];?>" maxlength="160"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="lend_form_option">
                                    <div class="tren_set_form_l">
                                        <div class="tren_set_form_img">
                                            <?php if ($landing['block7']['image3_default'] === false and is_file($landing['block7']['image3_orig'])) :
                                                $bl7_img3 = mb_substr($landing['block7']['image3_orig'], 1);?>
                                                <img src="<?php echo $bl7_img3; ?>" alt=""/>
                                                <div class="admin_form_buts parent">
                                                    <input type="hidden" name="img_path_7_2_3" value="<?php echo $bl7_img3; ?>">
                                                    <input type="submit" name="bt_delete_landing_img[7][2][3]" class="admin_form_del" value="Удалить">
                                                </div>
                                            <?php else: ?>
                                                <img src="/img/no_img.png" alt="">
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="tren_set_form_r">
                                        <div class="tren_form_block_check_wrap">
                                            <input type="checkbox" name="cb_image3_block7"
                                                <?php if ($landing['block7']['image3_default'] === true) : ?> checked="checked" <?php endif ; ?>
                                                   class="tren_form_block_check" id="tren_form_block_check15e3" />
                                            <label for="tren_form_block_check15e3">Изображение по умолчанию</label>
                                        </div>
                                        <div class="parent kurs_cur_wrap" style="max-height: 72px;">
                                            <div class="kurs_block_h">
                                                Изображение:
                                                <div class="h_subtitle">(285х285)</div>
                                            </div>
                                            <div class="video_down_line parent">
                                                <div class="video_down_line_but_wrap">
                                                    <label for="video_down_line_but3p" class="video_down_line_but">
                                                        <input type="file" name="file3_block7" class="admin_form_videofile" id="video_down_line_but3p" accept="image/jpeg,image/png" />
                                                        <span>Выберите файл</span>
                                                    </label>
                                                </div>
                                                <div class="video_down_line_name">Файл не выбран</div>
                                            </div>
                                        </div>
                                        <div class="parent kurs_cur_wrap">
                                            <div class="kurs_block_h">Текст плана:</div>
                                            <input type="text" name="i_text_block7[3]" class="admin_form_txt admin_form_txt_middle" value="<?php echo $landing['block7']['texts'][3];?>" maxlength="160"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="lend_form_option">
                                    <div class="tren_set_form_l">
                                        <div class="tren_set_form_img">
                                            <?php if ($landing['block7']['image4_default'] === false and is_file($landing['block7']['image4_orig'])) :
                                                $bl7_img4 = mb_substr($landing['block7']['image4_orig'], 1);?>
                                                <img src="<?php echo $bl7_img4; ?>" alt=""/>
                                                <div class="admin_form_buts parent">
                                                    <input type="hidden" name="img_path_7_2_4" value="<?php echo $bl7_img4; ?>">
                                                    <input type="submit" name="bt_delete_landing_img[7][2][4]" class="admin_form_del" value="Удалить">
                                                </div>
                                            <?php else: ?>
                                                <img src="/img/no_img.png" alt="">
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="tren_set_form_r">
                                        <div class="tren_form_block_check_wrap">
                                            <input type="checkbox" name="cb_image4_block7"
                                                <?php if ($landing['block7']['image4_default'] === true) : ?> checked="checked" <?php endif ; ?>
                                                   class="tren_form_block_check" id="tren_form_block_check15e4" />
                                            <label for="tren_form_block_check15e4">Изображение по умолчанию</label>
                                        </div>
                                        <div class="parent kurs_cur_wrap" style="max-height: 72px;">
                                            <div class="kurs_block_h">
                                                Изображение:
                                                <div class="h_subtitle">(285х285)</div>
                                            </div>
                                            <div class="video_down_line parent">
                                                <div class="video_down_line_but_wrap">
                                                    <label for="video_down_line_but4p" class="video_down_line_but">
                                                        <input type="file" name="file4_block7" class="admin_form_videofile" id="video_down_line_but4p" accept="image/jpeg,image/png" />
                                                        <span>Выберите файл</span>
                                                    </label>
                                                </div>
                                                <div class="video_down_line_name">Файл не выбран</div>
                                            </div>
                                        </div>
                                        <div class="parent kurs_cur_wrap">
                                            <div class="kurs_block_h">Текст плана:</div>
                                            <input type="text" name="i_text_block7[4]" class="admin_form_txt admin_form_txt_middle" value="<?php echo $landing['block7']['texts'][4];?>" maxlength="160"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--<div class="add_new_options_but add_form_plan">+ добавить план (изображение и текст)</div>-->
                        </div>
                        <div class="lend_form_h">Кнопка</div>
                        <div class="parent kurs_cur_wrap">
                            <div class="kurs_block_h">Текст кнопки:</div>
                            <input type="text" name="i_button_block7" class="admin_form_txt admin_form_txt_middle" maxlength="26" value="<?php echo $landing['block7']['button']; ?>" />
                        </div>
                    </div>
                <?php
                elseif($lend_block_id == 8): ?>
                    <div class="landing_block" style="display:block;" id="l-block-8">
                        <div class="landing_title">
                            <span>Блок №8</span>
                            <div class="tren_form_block_check_wrap">
                                <input type="checkbox" name="cb_hide_block8"
				                    <?php if ($landing['block8']['hide'] === true) : ?> checked="checked" <?php endif ; ?>
                                       class="tren_form_block_check" id="tren_form_block_check8hb" />
                                <label for="tren_form_block_check8hb">Скрыть блок</label>
                            </div>
                        </div>
                        <img src="/img/landing parts/8.PNG" alt="" class="land_template"/>
                        <div class="lend_form_h">Фон</div>
                        <div class="lend_form_option">
                            <div class="tren_set_form_l">
                                <div class="tren_set_form_img">
                                    <?php if ($landing['block8']['bg_default'] === false and is_file($landing['block8']['bg_orig'])) :?>
                                        <img src="<?php echo mb_substr($landing['block8']['bg_orig'], 1); ?>" alt=""/>
                                        <div class="admin_form_buts parent">
                                            <input type="hidden" name="img_path_8_0" value="<?php echo mb_substr($landing['block8']['bg_orig'], 1); ?>">
                                            <input type="submit" name="bt_delete_landing_img[8][0]" class="admin_form_del" value="Удалить">
                                        </div>
                                    <?php else: ?>
                                        <img src="/img/no_img.png" alt="">
                                    <?php endif;?>
                                </div>
                            </div>
                            <div class="tren_set_form_r">
                                <div class="parent kurs_cur_wrap">
                                    <div class="kurs_block_h">Цвет блока:</div>
                                    <div class="bg_color">
                                        <?php $b8_color = $landing['block8']['bg_color_orig'];?>
                                        <input type="hidden" name="i_bg_color_block8" value="<?php echo $b8_color;?>" id="block_bg_color"/>
                                        <div id="customWidget">
                                            <div class="colorselector"><div style="background-color: <?php echo $b8_color;?>"></div></div>
                                            <div class="colorpickerholder2"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="parent kurs_cur_wrap">
                                    <div class="kurs_block_h">Прозрачность:</div>
                                    <?php $b8_opacity = $landing['block8']['bg_opacity']; ?>
                                    <input type="range" min="0.05" max="1" step="0.05" value="<?php echo $b8_opacity; ?>" class="land_block_opacity">
                                    <input type="text" name="r_opacity_block8" value="<?php echo $b8_opacity; ?>" class="land_block_opacity_val" readonly>
                                </div>
                                <div class="tren_form_block_check_wrap">
                                    <input type="checkbox" name="cb_default_bg_block8"
                                        <?php if ($landing['block8']['bg_default'] === true) : ?> checked="checked" <?php endif ; ?>
                                           class="tren_form_block_check" id="tren_form_block_check8bg">
                                    <label for="tren_form_block_check8bg">Фон по умолчанию</label>
                                </div>
                                <div class="parent kurs_cur_wrap">
                                    <div class="kurs_block_h">Файл фона:
                                        <div class="h_subtitle">(1920х1080)</div>
                                    </div>
                                    <div class="video_down_line parent">
                                        <div class="video_down_line_but_wrap">
                                            <label for="video_down_line_but8fbg" class="video_down_line_but">
                                                <input type="file" name="bg_file_block8" class="admin_form_videofile" id="video_down_line_but8fbg" accept="image/jpeg,image/png" />
                                                <span>Выберите файл</span>
                                            </label>
                                        </div>
                                        <div class="video_down_line_name">Файл не выбран</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="lend_form_h">Информация</div>
                        <div class="parent kurs_cur_wrap">
                            <div class="kurs_block_h">Заголовок:</div>
                            <input type="text" name="i_title_block8" class="admin_form_txt admin_form_txt_middle" maxlength="60" value="<?php echo $landing['block8']['title']; ?>" />
                        </div>
                        <div class="parent kurs_cur_wrap">
                            <div class="kurs_block_h">Описание:</div>
                            <input type="text" name="i_desc1_block8" class="admin_form_txt admin_form_txt_middle" maxlength="160" value="<?php echo $landing['block8']['desc1']; ?>" />
                        </div>
                        <div class="parent kurs_cur_wrap">
                            <div class="kurs_block_h">Подзаголовок:</div>
                            <input type="text" name="i_subtitle_block8" class="admin_form_txt admin_form_txt_middle" maxlength="60" value="<?php echo $landing['block8']['subtitle']; ?>" />
                        </div>
                        <div class="parent kurs_cur_wrap">
                            <div class="kurs_block_h">Текст:</div>
                            <input type="text" name="i_desc2_block8" class="admin_form_txt admin_form_txt_middle" maxlength="100" value="<?php echo $landing['block8']['desc2']; ?>" />
                        </div>
                        <div class="lend_form_h">Цена</div>
                        <div class="parent kurs_cur_wrap">
                            <div class="kurs_block_h">Старая цена:</div>
                            <input type="text" name="i_old_price_block8" class="admin_form_txt admin_form_txt_short" maxlength="8" value="<?php echo $landing['block8']['old_price']; ?>" />
                            <div class="kurs_cur">Руб.</div>
                        </div>
                        <div class="parent kurs_cur_wrap">
                            <div class="kurs_block_h">Новая цена:</div>
                            <input type="text" name="i_new_price_block8" class="admin_form_txt admin_form_txt_short" maxlength="8" value="<?php echo $course['price']; ?>" disabled="disabled"/>
                            <div class="kurs_cur">Руб.</div>
                        </div>
                        <div class="lend_form_h">Кнопка</div>
                        <div class="parent kurs_cur_wrap">
                            <div class="kurs_block_h">Текст кнопки:</div>
                            <input type="text" name="i_button_block8" class="admin_form_txt admin_form_txt_middle" maxlength="30" value="<?php echo $landing['block8']['button']; ?>" />
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</form>