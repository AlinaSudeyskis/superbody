<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="content" class="container">
    <div class="cont_txt">
        <h1 class="main_h"><?php if (!empty($site_info['index_title'])) { echo $site_info['index_title']; } ?></h1>
        <div class="cont_val"><?php if (!empty($site_info['index_text'])) { echo $site_info['index_text']; } ?></div>
    </div>
    <div class="video_row row video_block">
        <?php if (!empty($video)) :
            foreach ($video as $key => $vd): ?>
                <div class="video_col">
                    <div class="video_col_h">
                        <a href="/course/<?php echo $vd['course_id']; ?>" class="video_title">
                                <?php echo $vd['course_name']; ?>
                        </a>
                    </div>
                    <?php if (empty($vd['remote_url'])) : ?>
                        <div class="video_kurs def_video">
                            <div class="px-video-img-captions-container">
                                <div class="px-video-captions hide"></div>
                                <video poster="<?php echo $vd['poster']; ?>" controls>
                                    <source src="<?php echo $vd['path']; ?>" type="video/mp4">
                                    <div><a href="<?php echo $vd['path']; ?>"><img src="<?php echo $vd['poster']; ?>" alt="download video"></a></div>
                                </video>
                            </div>
                            <div class="px-video-controls"></div>
                        </div>
                    <?php else: ?>
                        <div class="video_kurs">
                            <?php if($vd['remote_type'] == 'vimeo'):?>
                                <?php $remote_url = $vd['remote_url'];
                                include('./app_fold/views/video/player/vimeo_player_item.php'); ?>
                            <?php elseif($vd['remote_type'] == 'youtube'):?>
                                <?php $remote_url = $vd['remote_url'];
                                include('./app_fold/views/video/player/youtube_player_item.php'); ?>
                            <?php endif; ?>
                        </div>
                    <?php endif;?>
                    <div class="video_col_but">
                        <div class="video_col_but_left">
                            <a href="/course/<?php echo $vd['course_id']; ?>">Подробнее</a>
                        </div>
                        <div class="video_col_but_right">
                            <a href="#" class="buy_course" data-cid="<?php echo $vd['course_id']; ?>">
                                <?php if($vd['course_price'] > 0): ?>Купить<?php else:?>Добавить в "Мои курсы"<?php endif; ?>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach;
            unset($vd);
        endif;?>
    </div><!-- video_row -->
    <span class="cont_ref"><a href="/courses">Посмотреть все курсы</a></span>

    <h2 class="main_subh">Бесплатные тренировки дома</h2>
    <div class="main_subh_text" style="padding-bottom: 20px;">Просто включайте видео и повторяйте за тренером – подготовка не нужна</div>
    <div class="main_text">Создайте фигуру мечты и улучшите состояние здоровья с нашими программами фитнес-тренировок – гарантируем эффективность каждого курса при соблюдении рекомендаций по технике выполнения упражнений и правильному питанию. Если возникнут вопросы, обратитесь к онлайн-консультанту или своему тренеру – всегда готовы дать бесплатные профессиональные советы для достижения вашей цели.</div>
    <div class="main_block_wrap">
        <div class="main_bw_item">
            <div class="item_icon"><i class="fas fa-long-arrow-alt-up"></i><i class="fas fa-long-arrow-alt-down" style="font-size: 27px;"></i></div>
            <div class="item_title">Тренировки для разных целей</div>
            <div class="item_text">Выберите нужный вариант – предлагаем различные эффективные программы тренировок и питания для снижения веса и создания нужных форм фигуры</div>
        </div>
        <div class="main_bw_item">
            <div class="item_icon"><i class="fas fa-user-tie"></i><i class="fas fa-dumbbell" style="font-size: 27px;"></i></div>
            <div class="item_title">Инструктаж от профессионалов</div>
            <div class="item_text">Ознакомьтесь с техникой выполнения упражнений, чтобы занятия по фитнес-программам принесли пользу. К каждому курсу есть подробный инструктаж и рекомендации тренера</div>
        </div>
        <div class="main_bw_item">
            <div class="item_icon"><i class="fas fa-calendar-alt"></i><i class="far fa-clock" style="font-size: 27px;"></i></div>
            <div class="item_title">Расписание занятий и отдыха</div>
            <div class="item_text">Соблюдайте предложенное расписание и следите за своим прогрессом. Мы рассчитали идеальный баланс нагрузок и отдыха для достижения лучших результатов</div>
        </div>
        <div class="main_bw_item">
            <div class="item_icon"><i class="fas fa-desktop"></i><i class="fas fa-mobile-alt" style="font-size: 27px;"></i></div>
            <div class="item_title">Программы всегда под рукой</div>
            <div class="item_text">Тренируйтесь там, где вам удобно – дома, на даче, на улице или в гостинице. Понадобится только интернет, программы фитнес-тренировок будут доступны в вашем личном кабинете</div>
        </div>
    </div>

    <?php include_once('./app_fold/views/site/content/auth_info_block.php'); ?>

    <h2 class="main_subh">Достигайте желаемых результатов с помощью программ тренировок и питания</h2>
    <div class="main_subh_text">Курсы разработаны профессионалами</div>

    <?php if(!empty($site_info['spec_display']) and $site_info['spec_display'] == 1): ?>
        <div class="new_kurs_row row">
            <div class="col-lg-9 col-md-8 col-sm-12 col-xs-12 new_kurs_wrap">
                <h2 class="block_h">НОВЫЕ КУРСЫ</h2>
                <div class="new_kurs_block parent" data-info="Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.">
                    <?php if (!empty($courses)) :
                        $count_courses = count($courses);
                        foreach ($courses as $key => $course) :?>
                            <div class="new_kurs_block_item">
                                <div class="new_kurs_buts">
                                    <button class="add_kurs_but"><img src="/img/new_kurs_ico1.png" alt=""></button>
                                    <a href="" class="qw_but"><img src="/img/new_kurs_ico2.png" alt=""></a>
                                    <button class="favor_but"><img src="/img/new_kurs_ico3.png" alt=""></button>
                                    <button class="share_but"><img src="/img/new_kurs_ico4.png" alt=""></button>
                                </div>
                                <a href="/course/<?php echo $course['id']?>" class="new_kurs_name"><?php echo $course['name']?></a>
                            </div>
                        <?php endforeach;
                        unset($course);
                    endif;?>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12">
                <h2 class="block_h">СПЕЦ. ПРЕДЛОЖЕНИЕ</h2>
                <div class="spec_block" data-info="Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.">
                    <div class="spec_block_h">25%  СКИДКА ДЛЯ ВСЕХ</div>
                    <div class="spec_block_desk">Всем пользователям предоставляется скидка на вторую и последующую покупку курса</div>
                    <a href="" class="spec_block_but">ДЕТАЛИ</a>
                </div>
            </div>
        </div><!-- new_kurs_row -->
    <?php endif;?>
    <?php include_once('./app_fold/views/site/content/coaches_reviews_block.php'); ?>
    <?php include_once('./app_fold/views/site/content/gallery.php'); ?>

    <h2 class="main_subh">Сделайте первый шаг к мечте – зарегистрируйтесь на нашем сайте</h2>
    <div class="main_subh_text">Бесплатно рассчитаем индекс массы тела</div>
</div><!-- content -->
