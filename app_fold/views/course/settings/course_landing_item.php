<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="anketa_block_item">
    <div class="anketa_block_item_cont">
        <div class="tren_form_block_check_wrap example">
            ! Если не снять галочку
            <input type="checkbox" name="cb_example" checked="checked" class="tren_form_block_check" id="cb_example" disabled/>
            <label for="cb_example">По-умолчанию</label>
            , информация будет сохранена по-умолчанию.
        </div>
        <script>
            tinymce.init({
                selector: "textarea.formatted_textarea",
                menubar:false,
                theme: "modern",
                language_url : '/js/tinymce/langs/ru.js',
                plugins: "textcolor colorpicker bbcode",
                toolbar: "undo redo | bold italic | forecolor"
            });
        </script>
        <form action="" class="edit_lend_form video_admin_form landing_admin_form" method="post" enctype="multipart/form-data">
            <?php if (!empty($landings_list)) : ?>
                <select name="s_land_type" class="journal_form_select">
                    <option value="">Стиль</option>
                    <?php foreach ($landings_list as $ls) :
                        $default = $ls['id'] == 1 ? ' (по-умолчанию)' : '';?>
                        <option value="<?php echo $ls['id']; ?>"
                            <?php if ($landing['lp_id'] == $ls['id']) : ?> selected="selected"<?php endif; ?>
                        ><?php echo $ls['name'] . $default; ?></option>
                    <?php endforeach;
                    unset($ls);?>
                </select>
            <?php endif; ?>
            <div class="landing_block_table">
                <?php for($i = 1; $i <= 8; $i++) :
                    $active = ($i == 1) ? 'active' : '';?>
                    <div class="landing_blocks <?php echo $active; ?>" id="block-<?php echo $i; ?>">Блок <?php echo $i; ?></div>
                <?php endfor;
                unset($i);?>
            </div>

            <div class="landing_block_wrap">
                <div class="landing_block" id="l-block-1">
                    <h3 class="landing">Блок №1</h3>
                    <div class="lend_form_h">Слайдер (максимум 7 изображений)</div>
                    <div class="tren_form_block_check_wrap">
                        <input type="checkbox" name="cb_slider_block1"
                            <?php if ($landing['slider_images_default'] === true) : ?> checked="checked" <?php endif ; ?>
                               class="tren_form_block_check" id="tren_form_block_check1bg" />
                        <label for="tren_form_block_check1bg">Слайдер по-умолчанию</label>
                    </div>
                    <div class="add_foto_block_wrap">
                        <div class="add_foto_block">
                            <div class="parent kurs_cur_wrap">
                                <div class="kurs_block_h">Изображение №1:</div>
                                <div class="video_down_line parent">
                                    <div class="video_down_line_but_wrap">
                                        <label for="video_down_line_but1s" class="video_down_line_but">
                                            <input type="file" name="slider_files[]" class="admin_form_videofile" id="video_down_line_but1s" accept="image/jpeg,image/png" />
                                            <span>Выберите файл</span>
                                        </label>
                                    </div>
                                    <div class="video_down_line_name">Файл не выбран</div>
                                    <div class="progressbar_wrap">
                                        <progress class="progressbar" id="progressbar1" value="50" max="100"></progress>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="add_new_foto_but">+ добавить фото</div>
                    </div>
                    <?php if ($landing['slider_images_default'] === false) :
                        foreach ($landing['slider_images'] as $s_image) : ?>
                            <img src="<?php echo $s_image; ?>" alt=""/>
                        <?php endforeach;
                        unset($s_image);
                    endif;?>
                    <div class="lend_form_h">Заголовок страницы</div>
                    <div class="journal_form_textarea_wrap journal_form_textarea_small">
                        <textarea id="area3" name="ta_main_title" class="journal_form_textarea formatted_textarea" placeholder="Заголовок страницы" maxlength="50"><?php echo $landing['main_title']; ?></textarea>
                    </div>

                    <div class="video_admin_form_buts parent">
                        <input type="submit" name="bt_save_block_1" value="Сохранить блок 1" class="video_admin_form_send" />
                    </div>
                </div>

                <div class="landing_block" id="l-block-2">
                    <h3 class="landing">Блок №2</h3>
                    <div class="lend_form_h">Фон</div>
                    <div class="tren_form_block_check_wrap">
                        <input type="checkbox" name="cb_default_bg_block2"
                            <?php if ($landing['block2']['bg_default'] === true) : ?> checked="checked" <?php endif ; ?>
                               class="tren_form_block_check" id="tren_form_block_check2bg">
                        <label for="tren_form_block_check2bg">Фон по-умолчанию</label>
                    </div>
                    <div class="bg_color">
                        <?php $h_color = (mb_substr($landing['block2']['bg_orig'], 0, 1) == '#') ? $landing['block2']['bg_orig'] : '';
                        $v_color = (mb_substr($landing['block2']['bg_orig'], 0, 1) == '#') ? $landing['block2']['bg_orig'] : '';?>
                        <input type="hidden" name="i_bg_color_block2" value="<?php echo $h_color;?>" id="block_bg_color"/>
                        <div id="customWidget">
                            <div class="colorselector"><div style="background-color: <?php echo $v_color;?>"></div></div>
                            <div class="colorpickerholder2"></div>
                        </div>
                    </div>
                    <div class="parent kurs_cur_wrap">
                        <div class="kurs_block_h bg_color">Файл фона:</div>
                        <div class="video_down_line parent">
                            <div class="video_down_line_but_wrap">
                                <label for="video_down_line_but2fbg" class="video_down_line_but">
                                    <input type="file" name="bg_file_block2" class="admin_form_videofile" id="video_down_line_but2fbg" accept="image/jpeg,image/png" />
                                    <span>Выберите файл</span>
                                </label>
                            </div>
                            <div class="video_down_line_name">Файл не выбран</div>
                            <div class="progressbar_wrap">
                                <progress class="progressbar" id="progressbar2" value="50" max="100"></progress>
                            </div>
                        </div>
                    </div>
                    <?php if ($landing['block2']['bg_default'] === false and is_file($landing['block2']['bg_orig'])) :?>
                        <img src="<?php echo mb_substr($landing['block2']['bg_orig'], 1); ?>" alt=""/>
                    <?php endif;?>
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
                        <input type="text" name="i_button_block2" class="admin_form_txt admin_form_txt_middle" placeholder="Текст кнопки" maxlength="40" value="<?php echo $landing['block2']['button']; ?>" />
                    </div>
                    <div class="tren_form_block_check_wrap">
                        <input type="checkbox" name="cb_couch_image_block2"
                            <?php if ($landing['block2']['image_default'] === true) : ?> checked="checked" <?php endif ; ?>
                               class="tren_form_block_check" id="tren_form_block_check1bi" />
                        <label for="tren_form_block_check1bi">Изображение тренера (слева) по-умолчанию</label>
                    </div>
                    <div class="parent kurs_cur_wrap">
                        <div class="kurs_block_h">Изображение тренера:</div>
                        <div class="video_down_line parent">
                            <div class="video_down_line_but_wrap">
                                <label for="video_down_line_but1fbi" class="video_down_line_but">
                                    <input type="file" name="couch_file_block2" class="admin_form_videofile" id="video_down_line_but1fbi" accept="image/jpeg,image/png" />
                                    <span>Выберите файл</span>
                                </label>
                            </div>
                            <div class="video_down_line_name">Файл не выбран</div>
                            <div class="progressbar_wrap">
                                <progress class="progressbar" id="progressbar3" value="50" max="100"></progress>
                            </div>
                        </div>
                    </div>
                    <?php if ($landing['block2']['image_default'] === false and is_file($landing['block2']['image_orig'])) :?>
                        <img src="<?php echo mb_substr($landing['block2']['image_orig'], 1); ?>" alt=""/>
                    <?php endif;?>

                    <div class="video_admin_form_buts parent">
                        <input type="submit" name="bt_save_block_2" value="Сохранить блок 2" class="video_admin_form_send" />
                    </div>
                </div>

                <div class="landing_block" id="l-block-3">
                    <h3 class="landing">Блок №3 <span>(результаты №1)</span></h3>
                    <div class="lend_form_h">Фон</div>
                    <div class="tren_form_block_check_wrap">
                        <input type="checkbox" name="cb_default_bg_block3"
                            <?php if ($landing['block3']['bg_default'] === true) : ?> checked="checked" <?php endif ; ?>
                               class="tren_form_block_check" id="tren_form_block_check3bg">
                        <label for="tren_form_block_check3bg">Фон по-умолчанию</label>
                    </div>
                    <div class="bg_color">
                        <?php $h_color = (mb_substr($landing['block3']['bg_orig'], 0, 1) == '#') ? $landing['block3']['bg_orig'] : '';
                        $v_color = (mb_substr($landing['block3']['bg_orig'], 0, 1) == '#') ? $landing['block3']['bg_orig'] : '';?>
                        <input type="hidden" name="i_bg_color_block3" value="<?php echo $h_color;?>" id="block_bg_color"/>
                        <div id="customWidget">
                            <div class="colorselector"><div style="background-color: <?php echo $v_color;?>"></div></div>
                            <div class="colorpickerholder2"></div>
                        </div>
                    </div>
                    <div class="parent kurs_cur_wrap">
                        <div class="kurs_block_h bg_color">Файл фона:</div>
                        <div class="video_down_line parent">
                            <div class="video_down_line_but_wrap">
                                <label for="video_down_line_but3fbg" class="video_down_line_but">
                                    <input type="file" name="bg_file_block3" class="admin_form_videofile" id="video_down_line_but3fbg" accept="image/jpeg,image/png" />
                                    <span>Выберите файл</span>
                                </label>
                            </div>
                            <div class="video_down_line_name">Файл не выбран</div>
                            <div class="progressbar_wrap">
                                <progress class="progressbar" id="progressbar4" value="50" max="100"></progress>
                            </div>
                        </div>
                    </div>
                    <?php if ($landing['block3']['bg_default'] === false and is_file($landing['block3']['bg_orig'])) :?>
                        <img src="<?php echo mb_substr($landing['block3']['bg_orig'], 1); ?>" alt=""/>
                    <?php endif;?>
                    <div class="lend_form_h">Информация</div>
                    <div class="parent kurs_cur_wrap">
                        <div class="kurs_block_h">Заголовок:</div>
                        <input type="text" name="i_title_block3" class="admin_form_txt admin_form_txt_middle" maxlength="60" value="<?php echo $landing['block3']['title']; ?>" />
                    </div>
                    <div class="parent kurs_cur_wrap">
                        <div class="kurs_block_h">Подзаголовок:</div>
                        <input type="text" name="i_subtitle_block3" class="admin_form_txt admin_form_txt_middle" maxlength="60" value="<?php echo $landing['block3']['subtitle']; ?>" />
                    </div>
                    <div class="lend_form_h">Результаты</div>
                    <div class="tren_form_block_check_wrap">
                        <input type="checkbox" name="cb_photo1_block3"
                            <?php if ($landing['block3']['images_default'][0] === true) : ?> checked="checked" <?php endif ; ?>
                               class="tren_form_block_check" id="tren_form_block_check2bi" />
                        <label for="tren_form_block_check2bi">Фото №1 по-умолчанию</label>
                    </div>
                    <div class="parent kurs_cur_wrap">
                        <div class="kurs_block_h">Фото №1:</div>
                        <div class="video_down_line parent">
                            <div class="video_down_line_but_wrap">
                                <label for="video_down_line_but2fbi" class="video_down_line_but">
                                    <input type="file" name="result_file1_block3" class="admin_form_videofile" id="video_down_line_but2fbi" accept="image/jpeg,image/png" />
                                    <span>Выберите файл</span>
                                </label>
                            </div>
                            <div class="video_down_line_name">Файл не выбран</div>
                            <div class="progressbar_wrap">
                                <progress class="progressbar" id="progressbar5" value="50" max="100"></progress>
                            </div>
                        </div>
                    </div>
                    <?php if ($landing['block3']['images_default'][0] === false and is_file($landing['block3']['images_orig'][0])) :?>
                        <img src="<?php echo mb_substr($landing['block3']['images_orig'][0], 1); ?>" alt=""/>
                    <?php endif;?>
                    <div class="tren_form_block_check_wrap">
                        <input type="checkbox" name="cb_photo2_block3"
                            <?php if ($landing['block3']['images_default'][1] === true) : ?> checked="checked" <?php endif ; ?>
                               class="tren_form_block_check" id="tren_form_block_check3bi" />
                        <label for="tren_form_block_check3bi">Фото №2 по-умолчанию</label>
                    </div>
                    <div class="parent kurs_cur_wrap">
                        <div class="kurs_block_h">Фото №2:</div>
                        <div class="video_down_line parent">
                            <div class="video_down_line_but_wrap">
                                <label for="video_down_line_but3fbi" class="video_down_line_but">
                                    <input type="file" name="result_file2_block3" class="admin_form_videofile" id="video_down_line_but3fbi" accept="image/jpeg,image/png" />
                                    <span>Выберите файл</span>
                                </label>
                            </div>
                            <div class="video_down_line_name">Файл не выбран</div>
                            <div class="progressbar_wrap">
                                <progress class="progressbar" id="progressbar6" value="50" max="100"></progress>
                            </div>
                        </div>
                    </div>
                    <?php if ($landing['block3']['images_default'][1] === false and is_file($landing['block3']['images_orig'][1])) :?>
                        <img src="<?php echo mb_substr($landing['block3']['images_orig'][1], 1); ?>" alt=""/>
                    <?php endif;?>
                    <div class="parent kurs_cur_wrap">
                        <div class="kurs_block_h">Заголовок:</div>
                        <input type="text" name="i_result_title_block3" class="admin_form_txt admin_form_txt_middle" maxlength="60" value="<?php echo $landing['block3']['r_title']; ?>" />
                    </div>
                    <div class="parent kurs_cur_wrap">
                        <div class="kurs_block_h">Подзаголовок:</div>
                        <input type="text" name="i_result_subtitle_block3" class="admin_form_txt admin_form_txt_middle" maxlength="60" value="<?php echo $landing['block3']['r_subtitle']; ?>" />
                    </div>
                    <div class="parent kurs_cur_wrap">
                        <div class="kurs_block_h">Отзыв пользователя:</div>
                        <input type="text" name="i_result_reviews_block3" class="admin_form_txt admin_form_txt_middle" maxlength="80" value="<?php echo $landing['block3']['r_reviews']; ?>" />
                    </div>

                    <div class="video_admin_form_buts parent">
                        <input type="submit" name="bt_save_block_3" value="Сохранить блок 3" class="video_admin_form_send" />
                    </div>
                </div>

                <div class="landing_block" id="l-block-4">
                    <h3 class="landing">Блок №4 <span>(результаты №2)</span></h3>
                    <div class="lend_form_h">Фон</div>
                    <div class="tren_form_block_check_wrap">
                        <input type="checkbox" name="cb_default_bg_block4"
                            <?php if ($landing['block4']['bg_default'] === true) : ?> checked="checked" <?php endif ; ?>
                               class="tren_form_block_check" id="tren_form_block_check4bg">
                        <label for="tren_form_block_check4bg">Фон по-умолчанию</label>
                    </div>
                    <div class="bg_color">
                        <?php $h_color = (mb_substr($landing['block4']['bg_orig'], 0, 1) == '#') ? $landing['block4']['bg_orig'] : '';
                        $v_color = (mb_substr($landing['block4']['bg_orig'], 0, 1) == '#') ? $landing['block4']['bg_orig'] : '';?>
                        <input type="hidden" name="i_bg_color_block4" value="<?php echo $h_color;?>" id="block_bg_color"/>
                        <div id="customWidget">
                            <div class="colorselector"><div style="background-color: <?php echo $v_color;?>"></div></div>
                            <div class="colorpickerholder2"></div>
                        </div>
                    </div>
                    <div class="parent kurs_cur_wrap">
                        <div class="kurs_block_h bg_color">Файл фона:</div>
                        <div class="video_down_line parent">
                            <div class="video_down_line_but_wrap">
                                <label for="video_down_line_but4fbg" class="video_down_line_but">
                                    <input type="file" name="bg_file_block4" class="admin_form_videofile" id="video_down_line_but4fbg" accept="image/jpeg,image/png" />
                                    <span>Выберите файл</span>
                                </label>
                            </div>
                            <div class="video_down_line_name">Файл не выбран</div>
                            <div class="progressbar_wrap">
                                <progress class="progressbar" id="progressbar7" value="50" max="100"></progress>
                            </div>
                        </div>
                    </div>
                    <?php if ($landing['block4']['bg_default'] === false and is_file($landing['block4']['bg_orig'])) :?>
                        <img src="<?php echo mb_substr($landing['block4']['bg_orig'], 1); ?>" alt=""/>
                    <?php endif;?>
                    <div class="lend_form_h">Информация</div>
                    <div class="parent kurs_cur_wrap">
                        <div class="kurs_block_h">Заголовок:</div>
                        <input type="text" name="i_title_block4" class="admin_form_txt admin_form_txt_middle" maxlength="60" value="<?php echo $landing['block4']['title']; ?>" />
                    </div>
                    <div class="parent kurs_cur_wrap">
                        <div class="kurs_block_h">Подзаголовок:</div>
                        <input type="text" name="i_subtitle_block4" class="admin_form_txt admin_form_txt_middle" maxlength="80" value="<?php echo $landing['block4']['subtitle']; ?>" />
                    </div>
                    <div class="tren_form_block_check_wrap">
                        <input type="checkbox" name="cb_photo_block4"
                            <?php if ($landing['block4']['image_default'] === true) : ?> checked="checked" <?php endif ; ?>
                               class="tren_form_block_check" id="tren_form_block_check4bi" />
                        <label for="tren_form_block_check4bi">Фото по-умолчанию</label>
                    </div>
                    <div class="parent kurs_cur_wrap">
                        <div class="kurs_block_h">Фото:</div>
                        <div class="video_down_line parent">
                            <div class="video_down_line_but_wrap">
                                <label for="video_down_line_but4fbi" class="video_down_line_but">
                                    <input type="file" name="result_file_block4" class="admin_form_videofile" id="video_down_line_but4fbi" accept="image/jpeg,image/png" />
                                    <span>Выберите файл</span>
                                </label>
                            </div>
                            <div class="video_down_line_name">Файл не выбран</div>
                            <div class="progressbar_wrap">
                                <progress class="progressbar" id="progressbar8" value="50" max="100"></progress>
                            </div>
                        </div>
                    </div>
                    <?php if ($landing['block4']['image_default'] === false and is_file($landing['block4']['image_orig'])) :?>
                        <img src="<?php echo mb_substr($landing['block4']['image_orig'], 1); ?>" alt=""/>
                    <?php endif;?>
                    <div class="parent kurs_cur_wrap">
                        <div class="kurs_block_h">Заголовок:</div>
                        <input type="text" name="i_result_title_block4" class="admin_form_txt admin_form_txt_middle" maxlength="60" value="<?php echo $landing['block4']['r_title']; ?>" />
                    </div>
                    <div class="parent kurs_cur_wrap">
                        <div class="kurs_block_h">Описание:</div>
                        <input type="text" name="i_result_desc_block4" class="admin_form_txt admin_form_txt_middle" maxlength="60" value="<?php echo $landing['block4']['r_subtitle']; ?>" />
                    </div>
                    <div class="lend_form_h">Кнопка</div>
                    <div class="parent kurs_cur_wrap">
                        <div class="kurs_block_h">Текст кнопки:</div>
                        <input type="text" name="i_button_block4" class="admin_form_txt admin_form_txt_middle" maxlength="40" value="<?php echo $landing['block4']['button']; ?>" />
                    </div>


                    <div class="video_admin_form_buts parent">
                        <input type="submit" name="bt_save_block_4" value="Сохранить блок 4" class="video_admin_form_send" />
                    </div>
                </div>

                <div class="landing_block" id="l-block-5">
                    <h3 class="landing">Блок №5 <span>(тренер)</span></h3>
                    <div class="lend_form_h">Фон</div>
                    <div class="tren_form_block_check_wrap">
                        <input type="checkbox" name="cb_default_bg_block5"
                            <?php if ($landing['block5']['bg_default'] === true) : ?> checked="checked" <?php endif ; ?>
                               class="tren_form_block_check" id="tren_form_block_check5bg">
                        <label for="tren_form_block_check5bg">Фон по-умолчанию</label>
                    </div>
                    <div class="bg_color">
                        <?php $h_color = (mb_substr($landing['block5']['bg_orig'], 0, 1) == '#') ? $landing['block5']['bg_orig'] : '';
                        $v_color = (mb_substr($landing['block5']['bg_orig'], 0, 1) == '#') ? $landing['block5']['bg_orig'] : '';?>
                        <input type="hidden" name="i_bg_color_block5" value="<?php echo $h_color;?>" id="block_bg_color"/>
                        <div id="customWidget">
                            <div class="colorselector"><div style="background-color: <?php echo $v_color;?>"></div></div>
                            <div class="colorpickerholder2"></div>
                        </div>
                    </div>
                    <div class="parent kurs_cur_wrap">
                        <div class="kurs_block_h bg_color">Файл фона:</div>
                        <div class="video_down_line parent">
                            <div class="video_down_line_but_wrap">
                                <label for="video_down_line_but5fbg" class="video_down_line_but">
                                    <input type="file" name="bg_file_block5" class="admin_form_videofile" id="video_down_line_but5fbg" accept="image/jpeg,image/png" />
                                    <span>Выберите файл</span>
                                </label>
                            </div>
                            <div class="video_down_line_name">Файл не выбран</div>
                            <div class="progressbar_wrap">
                                <progress class="progressbar" id="progressbar15" value="50" max="100"></progress>
                            </div>
                        </div>
                    </div>
                    <?php if ($landing['block5']['bg_default'] === false and is_file($landing['block5']['bg_orig'])) :?>
                        <img src="<?php echo mb_substr($landing['block5']['bg_orig'], 1); ?>" alt=""/>
                    <?php endif;?>
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
                    <div class="tren_form_block_check_wrap">
                        <input type="checkbox" name="cb_photo1_block5"
                            <?php if ($landing['block5']['images_default'][0] === true) : ?> checked="checked" <?php endif ; ?>
                               class="tren_form_block_check" id="tren_form_block_check5bi" />
                        <label for="tren_form_block_check5bi">Боковое фото №1 по-умолчанию</label>
                    </div>
                    <div class="parent kurs_cur_wrap">
                        <div class="kurs_block_h">Боковое фото №1:</div>
                        <div class="video_down_line parent">
                            <div class="video_down_line_but_wrap">
                                <label for="video_down_line_but5fbi" class="video_down_line_but">
                                    <input type="file" name="couch_file1_block5" class="admin_form_videofile" id="video_down_line_but5fbi" accept="image/jpeg,image/png" />
                                    <span>Выберите файл</span>
                                </label>
                            </div>
                            <div class="video_down_line_name">Файл не выбран</div>
                            <div class="progressbar_wrap">
                                <progress class="progressbar" id="progressbar9" value="50" max="100"></progress>
                            </div>
                        </div>
                    </div>
                    <?php if ($landing['block5']['images_default'][0] === false and is_file($landing['block5']['images_orig'][0])) :?>
                        <img src="<?php echo mb_substr($landing['block5']['images_orig'][0], 1); ?>" alt=""/>
                    <?php endif;?>
                    <div class="tren_form_block_check_wrap">
                        <input type="checkbox" name="cb_photo2_block5"
                            <?php if ($landing['block5']['images_default'][1] === true) : ?> checked="checked" <?php endif ; ?>
                               class="tren_form_block_check" id="tren_form_block_check6bi" />
                        <label for="tren_form_block_check6bi">Боковое фото №2 по-умолчанию</label>
                    </div>
                    <div class="parent kurs_cur_wrap">
                        <div class="kurs_block_h">Боковое фото №2:</div>
                        <div class="video_down_line parent">
                            <div class="video_down_line_but_wrap">
                                <label for="video_down_line_but6fbi" class="video_down_line_but">
                                    <input type="file" name="couch_file2_block5" class="admin_form_videofile" id="video_down_line_but6fbi" accept="image/jpeg,image/png" />
                                    <span>Выберите файл</span>
                                </label>
                            </div>
                            <div class="video_down_line_name">Файл не выбран</div>
                            <div class="progressbar_wrap">
                                <progress class="progressbar" id="progressbar10" value="50" max="100"></progress>
                            </div>
                        </div>
                    </div>
                    <?php if ($landing['block5']['images_default'][1] === false and is_file($landing['block5']['images_orig'][1])) :?>
                        <img src="<?php echo mb_substr($landing['block5']['images_orig'][1], 1); ?>" alt=""/>
                    <?php endif;?>
                    <div class="tren_form_block_check_wrap">
                        <input type="checkbox" name="cb_photo3_block5"
                            <?php if ($landing['block5']['images_default'][2] === true) : ?> checked="checked" <?php endif ; ?>
                               class="tren_form_block_check" id="tren_form_block_check7bi" />
                        <label for="tren_form_block_check7bi">Аватар по-умолчанию</label>
                    </div>
                    <div class="parent kurs_cur_wrap">
                        <div class="kurs_block_h">Аватар:</div>
                        <div class="video_down_line parent">
                            <div class="video_down_line_but_wrap">
                                <label for="video_down_line_but7fbi" class="video_down_line_but">
                                    <input type="file" name="couch_avatar_block5" class="admin_form_videofile" id="video_down_line_but7fbi" accept="image/jpeg,image/png" />
                                    <span>Выберите файл</span>
                                </label>
                            </div>
                            <div class="video_down_line_name">Файл не выбран</div>
                            <div class="progressbar_wrap">
                                <progress class="progressbar" id="progressbar11" value="50" max="100"></progress>
                            </div>
                        </div>
                    </div>
                    <?php if ($landing['block5']['images_default'][2] === false and is_file($landing['block5']['images_orig'][2])) :?>
                        <img src="<?php echo mb_substr($landing['block5']['images_orig'][2], 1); ?>" alt=""/>
                    <?php endif;?>
                    <div class="lend_form_h">Слова тренера о программе</div>
                    <div class="parent kurs_cur_wrap">
                        <div class="kurs_block_h">Заголовок:</div>
                        <input type="text" name="i_couch_title_block5" class="admin_form_txt admin_form_txt_middle" maxlength="50" value="<?php echo $landing['block5']['r_title']; ?>" />
                    </div>
                    <div class="parent kurs_cur_wrap">
                        <div class="kurs_block_h">Подзаголовок:</div>
                        <input type="text" name="i_couch_subtitle_block5" class="admin_form_txt admin_form_txt_middle" maxlength="50" value="<?php echo $landing['block5']['r_subtitle']; ?>" />
                    </div>
                    <div class="parent kurs_cur_wrap">
                        <div class="kurs_block_h">Текст:</div>
                        <input type="text" name="i_couch_text_block5" class="admin_form_txt admin_form_txt_middle" maxlength="120" value="<?php echo $landing['block5']['r_text']; ?>" />
                    </div>
                    <div class="lend_form_h">Кнопка</div>
                    <div class="parent kurs_cur_wrap">
                        <div class="kurs_block_h">Текст кнопки:</div>
                        <input type="text" name="i_button_block5" class="admin_form_txt admin_form_txt_middle" maxlength="40" value="<?php echo $landing['block5']['button']; ?>" />
                    </div>


                    <div class="video_admin_form_buts parent">
                        <input type="submit" name="bt_save_block_5" value="Сохранить блок 5" class="video_admin_form_send" />
                    </div>
                </div>

                <div class="landing_block" id="l-block-6">
                    <h3 class="landing">Блок №6 <span>(описание курса)</span></h3>
                    <div class="lend_form_h">Фон</div>
                    <div class="tren_form_block_check_wrap">
                        <input type="checkbox" name="cb_default_bg_block6"
                            <?php if ($landing['block6']['bg_default'] === true) : ?> checked="checked" <?php endif ; ?>
                               class="tren_form_block_check" id="tren_form_block_check6bg">
                        <label for="tren_form_block_check6bg">Фон по-умолчанию</label>
                    </div>
                    <div class="bg_color">
                        <?php $h_color = (mb_substr($landing['block6']['bg_orig'], 0, 1) == '#') ? $landing['block6']['bg_orig'] : '';
                        $v_color = (mb_substr($landing['block6']['bg_orig'], 0, 1) == '#') ? $landing['block6']['bg_orig'] : '';?>
                        <input type="hidden" name="i_bg_color_block6" value="<?php echo $h_color;?>" id="block_bg_color"/>
                        <div id="customWidget">
                            <div class="colorselector"><div style="background-color: <?php echo $v_color;?>"></div></div>
                            <div class="colorpickerholder2"></div>
                        </div>
                    </div>
                    <div class="parent kurs_cur_wrap">
                        <div class="kurs_block_h bg_color">Файл фона:</div>
                        <div class="video_down_line parent">
                            <div class="video_down_line_but_wrap">
                                <label for="video_down_line_but6fbg" class="video_down_line_but">
                                    <input type="file" name="bg_file_block6" class="admin_form_videofile" id="video_down_line_but6fbg" accept="image/jpeg,image/png" />
                                    <span>Выберите файл</span>
                                </label>
                            </div>
                            <div class="video_down_line_name">Файл не выбран</div>
                            <div class="progressbar_wrap">
                                <progress class="progressbar" id="progressbar12" value="50" max="100"></progress>
                            </div>
                        </div>
                    </div>
                    <?php if ($landing['block6']['bg_default'] === false and is_file($landing['block6']['bg_orig'])) :?>
                        <img src="<?php echo mb_substr($landing['block6']['bg_orig'], 1); ?>" alt=""/>
                    <?php endif;?>
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
                    <div class="tren_form_block_check_wrap">
                        <input type="checkbox" name="cb_photo_block6"
                            <?php if ($landing['block6']['image_default'] === true) : ?> checked="checked" <?php endif ; ?>
                               class="tren_form_block_check" id="tren_form_block_check8bi" />
                        <label for="tren_form_block_check8bi">Боковое фото по-умолчанию</label>
                    </div>
                    <div class="parent kurs_cur_wrap">
                        <div class="kurs_block_h">Боковое фото:</div>
                        <div class="video_down_line parent">
                            <div class="video_down_line_but_wrap">
                                <label for="video_down_line_but8fbi" class="video_down_line_but">
                                    <input type="file" name="file_block6" class="admin_form_videofile" id="video_down_line_but8fbi" accept="image/jpeg,image/png" />
                                    <span>Выберите файл</span>
                                </label>
                            </div>
                            <div class="video_down_line_name">Файл не выбран</div>
                            <div class="progressbar_wrap">
                                <progress class="progressbar" id="progressbar13" value="50" max="100"></progress>
                            </div>
                        </div>
                    </div>
                    <?php if ($landing['block6']['image_default'] === false and is_file($landing['block6']['image_orig'])) :?>
                        <img src="<?php echo mb_substr($landing['block6']['image_orig'], 1); ?>" alt=""/>
                    <?php endif;?>
                    <div class="lend_form_h">Преимущества (рекомендация: 2 преимущества)</div>
                    <div class="lend_form_options_wrap">
                        <div class="lend_form_options">
                            <?php if (!empty($landing['block6']['advantages'])) :
                                foreach ($landing['block6']['advantages'] as $advantage) : ?>
                                    <div class="parent kurs_cur_wrap">
                                        <div class="kurs_block_h">Преимущество:</div>
                                        <input type="text" name="i_advantages_block6[]" class="admin_form_txt admin_form_txt_middle" value="<?php echo $advantage; ?>"/>
                                    </div>
                                <?php endforeach;
                                unset($advantage);
                            else :?>
                                <div class="parent kurs_cur_wrap">
                                    <div class="kurs_block_h">Преимущество:</div>
                                    <input type="text" name="i_advantages_block6[]" class="admin_form_txt admin_form_txt_middle" value=""/>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="add_new_options_but add_form_advantage">+ добавить преимущество</div>
                    </div>
                    <div class="lend_form_h">Кнопка</div>
                    <div class="parent kurs_cur_wrap">
                        <div class="kurs_block_h">Текст кнопки:</div>
                        <input type="text" name="i_button_block6" class="admin_form_txt admin_form_txt_middle" maxlength="40" value="<?php echo $landing['block6']['button']; ?>" />
                    </div>


                    <div class="video_admin_form_buts parent">
                        <input type="submit" name="bt_save_block_6" value="Сохранить блок 6" class="video_admin_form_send" />
                    </div>
                </div>

                <div class="landing_block" id="l-block-7">
                    <h3 class="landing">Блок №7</h3>
                    <div class="lend_form_h">Фон</div>
                    <div class="tren_form_block_check_wrap">
                        <input type="checkbox" name="cb_default_bg_block7"
                            <?php if ($landing['block7']['bg_default'] === true) : ?> checked="checked" <?php endif ; ?>
                               class="tren_form_block_check" id="tren_form_block_check7bg">
                        <label for="tren_form_block_check7bg">Фон по-умолчанию</label>
                    </div>
                    <div class="bg_color">
                        <?php $h_color = (mb_substr($landing['block7']['bg_orig'], 0, 1) == '#') ? $landing['block7']['bg_orig'] : '';
                        $v_color = (mb_substr($landing['block7']['bg_orig'], 0, 1) == '#') ? $landing['block7']['bg_orig'] : '';?>
                        <input type="hidden" name="i_bg_color_block7" value="<?php echo $h_color;?>" id="block_bg_color"/>
                        <div id="customWidget">
                            <div class="colorselector"><div style="background-color: <?php echo $v_color;?>"></div></div>
                            <div class="colorpickerholder2"></div>
                        </div>
                    </div>
                    <div class="parent kurs_cur_wrap">
                        <div class="kurs_block_h bg_color">Файл фона:</div>
                        <div class="video_down_line parent">
                            <div class="video_down_line_but_wrap">
                                <label for="video_down_line_but7fbg" class="video_down_line_but">
                                    <input type="file" name="bg_file_block7" class="admin_form_videofile" id="video_down_line_but7fbg" accept="image/jpeg,image/png" />
                                    <span>Выберите файл</span>
                                </label>
                            </div>
                            <div class="video_down_line_name">Файл не выбран</div>
                            <div class="progressbar_wrap">
                                <progress class="progressbar" id="progressbar17" value="50" max="100"></progress>
                            </div>
                        </div>
                    </div>
                    <?php if ($landing['block7']['bg_default'] === false and is_file($landing['block7']['bg_orig'])) :?>
                        <img src="<?php echo mb_substr($landing['block7']['bg_orig'], 1); ?>" alt=""/>
                    <?php endif;?>
                    <div class="parent kurs_cur_wrap">
                        <div class="kurs_block_h">Заголовок:</div>
                        <input type="text" name="i_title_block7" class="admin_form_txt admin_form_txt_middle" maxlength="50" value="<?php echo $landing['block7']['title']; ?>" />
                    </div>
                    <div class="lend_form_h">Изображения и текст (рекомендация: количество планов кратно 2)</div>
                    <div class="tren_form_block_check_wrap">
                        <input type="checkbox" name="cb_images_block7"
                            <?php if ($landing['block7']['images_default'] === true) : ?> checked="checked" <?php endif ; ?>
                               class="tren_form_block_check" id="tren_form_block_check15e" />
                        <label for="tren_form_block_check15e">Все изображения по-умолчанию (4 шт.)</label>
                    </div>
                    <div class="lend_form_options_wrap">
                        <div class="lend_form_options">
                            <?php if (!empty($landing['block7']['texts'])):
                                foreach ($landing['block7']['texts'] as $key => $b7_text) :?>
                                    <div class="parent kurs_cur_wrap">
                                        <div class="kurs_block_h">Изображение:</div>
                                        <div class="video_down_line parent">
                                            <div class="video_down_line_but_wrap">
                                                <label for="video_down_line_but<?php echo $key+1;?>p" class="video_down_line_but">
                                                    <input type="file" name="files_block7[]" class="admin_form_videofile" id="video_down_line_but<?php echo $key+1;?>p" accept="image/jpeg,image/png" />
                                                    <span>Выберите файл</span>
                                                </label>
                                            </div>
                                            <div class="video_down_line_name">Файл не выбран</div>
                                            <div class="progressbar_wrap">
                                                <progress class="progressbar" id="progressbar20p" value="50" max="100"></progress>
                                            </div>
                                            <?php if (($landing['block7']['images_default'] === false or $key > 3) and is_file($landing['block7']['images_orig'][$key])) :?>
                                                <img src="<?php echo mb_substr($landing['block7']['images_orig'][$key], 1); ?>" alt=""/>
                                            <?php endif;?>
                                        </div>
                                    </div>
                                    <div class="parent kurs_cur_wrap">
                                        <div class="kurs_block_h">Текст плана:</div>
                                        <input type="text" name="i_text_block7[]" class="admin_form_txt admin_form_txt_middle" value="<?php echo $b7_text;?>" maxlength="160"/>
                                    </div>
                                <?php endforeach;
                                unset($b7_text);
                            else: ?>
                                <div class="parent kurs_cur_wrap">
                                    <div class="kurs_block_h">Изображение:</div>
                                    <div class="video_down_line parent">
                                        <div class="video_down_line_but_wrap">
                                            <label for="video_down_line_but1p" class="video_down_line_but">
                                                <input type="file" name="files_block7[]" class="admin_form_videofile" id="video_down_line_but1p" accept="image/jpeg,image/png" />
                                                <span>Выберите файл</span>
                                            </label>
                                        </div>
                                        <div class="video_down_line_name">Файл не выбран</div>
                                        <div class="progressbar_wrap">
                                            <progress class="progressbar" id="progressbar20p" value="50" max="100"></progress>
                                        </div>
                                    </div>
                                </div>
                                <div class="parent kurs_cur_wrap">
                                    <div class="kurs_block_h">Текст плана:</div>
                                    <input type="text" name="i_text_block7[]" class="admin_form_txt admin_form_txt_middle" maxlength="160" value=""/>
                                </div>
                            <?php endif;?>
                        </div>
                        <div class="add_new_options_but add_form_plan">+ добавить план (изображение и текст)</div>
                    </div>
                    <div class="lend_form_h">Кнопка</div>
                    <div class="parent kurs_cur_wrap">
                        <div class="kurs_block_h">Текст кнопки:</div>
                        <input type="text" name="i_button_block7" class="admin_form_txt admin_form_txt_middle" maxlength="40" value="<?php echo $landing['block7']['button']; ?>" />
                    </div>


                    <div class="video_admin_form_buts parent">
                        <input type="submit" name="bt_save_block_7" value="Сохранить блок 7" class="video_admin_form_send" />
                    </div>
                </div>

                <div class="landing_block" id="l-block-8">
                    <h3 class="landing">Блок №8</h3>
                    <div class="lend_form_h">Фон</div>
                    <div class="tren_form_block_check_wrap">
                        <input type="checkbox" name="cb_default_bg_block8"
                            <?php if ($landing['block8']['bg_default'] === true) : ?> checked="checked" <?php endif ; ?>
                               class="tren_form_block_check" id="tren_form_block_check8bg">
                        <label for="tren_form_block_check8bg">Фон по-умолчанию</label>
                    </div>
                    <div class="bg_color">
                        <?php $h_color = (mb_substr($landing['block8']['bg_orig'], 0, 1) == '#') ? $landing['block8']['bg_orig'] : '';
                        $v_color = (mb_substr($landing['block8']['bg_orig'], 0, 1) == '#') ? $landing['block8']['bg_orig'] : '';?>
                        <input type="hidden" name="i_bg_color_block8" value="<?php echo $h_color;?>" id="block_bg_color"/>
                        <div id="customWidget">
                            <div class="colorselector"><div style="background-color: <?php echo $v_color;?>"></div></div>
                            <div class="colorpickerholder2"></div>
                        </div>
                    </div>
                    <div class="parent kurs_cur_wrap">
                        <div class="kurs_block_h bg_color">Файл фона:</div>
                        <div class="video_down_line parent">
                            <div class="video_down_line_but_wrap">
                                <label for="video_down_line_but8fbg" class="video_down_line_but">
                                    <input type="file" name="bg_file_block8" class="admin_form_videofile" id="video_down_line_but8fbg" accept="image/jpeg,image/png" />
                                    <span>Выберите файл</span>
                                </label>
                            </div>
                            <div class="video_down_line_name">Файл не выбран</div>
                            <div class="progressbar_wrap">
                                <progress class="progressbar" id="progressbar14" value="50" max="100"></progress>
                            </div>
                        </div>
                    </div>
                    <?php if ($landing['block8']['bg_default'] === false and is_file($landing['block8']['bg_orig'])) :?>
                        <img src="<?php echo mb_substr($landing['block8']['bg_orig'], 1); ?>" alt=""/>
                    <?php endif;?>
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
                        <input type="text" name="i_button_block8" class="admin_form_txt admin_form_txt_middle" maxlength="40" value="<?php echo $landing['block8']['button']; ?>" />
                    </div>


                    <div class="video_admin_form_buts parent">
                        <input type="submit" name="bt_save_block_8" value="Сохранить блок 8" class="video_admin_form_send" />
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>