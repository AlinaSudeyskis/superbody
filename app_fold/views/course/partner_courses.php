<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="content" class="container">
    <div class="row">
        <div class="col-lg-2 left_sidebar">
            <?php include_once('./app_fold/views/coach/coach_menu.php'); ?>
        </div><!-- left_sidebar -->
        <div class="col-lg-10 content_col">
            <div class="content_block new_content_block">
                <div class="content_block_h parent">
                    <h3>Курсы</h3>
                    <div class="content_block_h_buts">
                        <div class="content_block_h_slide kurs_slide"></div>
                        <div class="content_block_h_close"></div>
                    </div>
                </div>
                <div class="kurs_block_val">
                    <div class="statistics_container">
                        <?php if(!empty($coach_courses_statistics)): ?>
                            <div class="stat_content sc_general" <?php if(!empty($course['image'])): ?> style="background: url(<?php echo $course['image']; ?>) top no-repeat; background-size: cover;"<?php endif;?>>
                                <div class="stat_h">Статистика</div>
                                <div class="stat_subh">по курсам с <?php echo $coach_courses_statistics['first_date']; ?></div>
                                <div class="stat_general_data">
                                    <div class="sgd_item">
                                        <div class="sgd_icon"><i class="fas fa-users"></i></div>
                                        <div class="sgd_data"><?php echo $coach_courses_statistics['count_users']; ?></div>
                                        <div class="sgd_caption">участников</div>
                                    </div>
                                    <div class="sgd_item">
                                        <div class="sgd_icon"><i class="fas fa-check"></i></div>
                                        <div class="sgd_data"><?php echo $coach_courses_statistics['courses_completion']; ?></div>
                                        <div class="sgd_caption">пройденно</div>
                                    </div>
                                    <div class="sgd_item">
                                        <div class="sgd_icon"><i class="fas fa-percent"></i></div>
                                        <div class="sgd_data"><?php echo $coach_courses_statistics['pass_percentage']; ?></div>
                                        <div class="sgd_caption">прохождения</div>
                                    </div>
                                    <!--<div class="sgd_item">
                                        <div class="sgd_icon"><i class="far fa-clock"></i></div>
                                        <div class="sgd_data">625</div>
                                        <div class="sgd_caption">часов</div>
                                    </div>-->
                                    <div class="sgd_item">
                                        <div class="sgd_icon"><i class="fas fa-coins"></i><!--<i class="fas fa-money-bill"></i>--></div>
                                        <div class="sgd_data"><?php echo $coach_courses_statistics['count_earnings']; ?></div>
                                        <div class="sgd_caption">рублей</div>
                                    </div>
                                </div>
                            </div>
                            <div class="stat_content sc_courses">
                                <div class="stat_h">Курсы</div>
                                <div class="orders_container_wrap">
                                    <?php if(!empty($courses) and !empty($coach_courses_statistics['courses'])):
                                        $courses_stat = $coach_courses_statistics['courses']; ?>
                                        <?php foreach($courses as $key => $course): ?>
                                            <div class="orders_container">
                                                <?php if(!empty($course['image'])): ?>
                                                    <div class="order_image"><img src="<?php echo $course['image']; ?>" alt="" /></div>
                                                <?php endif; ?>
                                                <div class="order_info_wrap">
                                                    <div class="stat_content sc_general">
                                                        <div class="stat_h"><a href="/partner/course/<?php echo $course['id']?>"><?php echo $course['name']; ?></a></div>
                                                        <div class="stat_subh">
                                                            <?php if(!empty($courses_stat[$course['id']]['first_date'])):?>
                                                                с <?php echo $courses_stat[$course['id']]['first_date']; ?>
                                                            <?php endif;?>
                                                        </div>
                                                        <div class="stat_general_data">
                                                            <div class="sgd_item">
                                                                <div class="sgd_icon"><i class="fas fa-users"></i></div>
                                                                <div class="sgd_data"><?php echo $courses_stat[$course['id']]['count_users']; ?></div>
                                                                <div class="sgd_caption">участников</div>
                                                            </div>
                                                            <div class="sgd_item">
                                                                <div class="sgd_icon"><i class="fas fa-check"></i></div>
                                                                <div class="sgd_data"><?php echo $courses_stat[$course['id']]['course_completion']; ?></div>
                                                                <div class="sgd_caption">пройденно</div>
                                                            </div>
                                                            <div class="sgd_item">
                                                                <div class="sgd_icon"><i class="fas fa-percent"></i></div>
                                                                <div class="sgd_data"><?php echo $courses_stat[$course['id']]['pass_percentage']; ?></div>
                                                                <div class="sgd_caption">прохождения</div>
                                                            </div>
                                                            <div class="sgd_item">
                                                                <div class="sgd_icon"><i class="far fa-clock"></i></div>
                                                                <div class="sgd_data"><?php echo $courses_stat[$course['id']]['progress_time']; ?></div>
                                                                <div class="sgd_caption">часов</div>
                                                            </div>
                                                            <div class="sgd_item">
                                                                <div class="sgd_icon"><i class="fas fa-coins"></i><!--<i class="fas fa-money-bill"></i>--></div>
                                                                <div class="sgd_data"><?php echo $courses_stat[$course['id']]['count_earnings']; ?></div>
                                                                <div class="sgd_caption">рублей</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php if(!empty($courses_stat[$course['id']]['bought_users'])): ?>
                                                        <div class="stat_content sc_users">
                                                            <div class="stat_h">Последние купившие</div>
                                                            <div class="admin_page">
                                                                <?php foreach($courses_stat[$course['id']]['bought_users'] as $bought_user_data): ?>
                                                                    <div class="tren_prof_page_img_wrap">
                                                                        <div class="tren_prof_page_img">
                                                                            <?php $image = (!empty($bought_user_data['user_image']))
                                                                                ? $bought_user_data['user_image']
                                                                                : $bought_user_data['user_soc_image'];
                                                                            $image = (empty($image)) ? '/img/no_img.png' : $image;
                                                                            if($bought_user_data['user_type'] == 1){
                                                                                $user_type = 'user';
                                                                            }
                                                                            elseif($bought_user_data['user_type'] == 2){
                                                                                $user_type = 'coach';
                                                                            }
                                                                            elseif($bought_user_data['user_type'] == 3){
                                                                                $user_type = 'admin';
                                                                            }
                                                                            ?>
                                                                            <a href="/administration/<?php echo $user_type; ?>/<?php echo $bought_user_data['user_id']; ?>"><img src="<?php echo $image; ?>" alt=""></a>
                                                                        </div>
                                                                        <div class="tren_prof_page_name"><?php echo $bought_user_data['split_name']['name']; ?></div>
                                                                        <div class="tren_prof_page_surname"><?php echo $bought_user_data['split_name']['surname']; ?></div>
                                                                        <div class="tren_prof_page_soc"></div>
                                                                    </div>
                                                                <?php endforeach; ?>
                                                            </div>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <h3 class="info">Информация не найдена</h3>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="stat_content sc_data"></div>
                        <?php endif; ?>
                    </div>
                    <?php /*if (!empty($courses)) :*/?><!--
                        <div class="my_kurs_block">
                            <?php /*foreach ($courses as $course) :*/?>
                                <div class="my_kurs_item parent">
                                    <div class="my_kurs_img">
                                        <a href="">
                                            <?php /*if (!empty($course['image'])) :*/?>
                                                <img src="<?php /*echo $course['image'];*/?>" alt=""/>
                                            <?php /*endif;*/?>
                                        </a>
                                    </div>
                                    <div class="my_kurs_cont">
                                        <div class="my_kurs_top parent">
                                            <div class="my_kurs_name"><a href="/partner/course/<?php /*echo $course['course_id']*/?>"><?php /*echo $course['name'];*/?></a></div>
                                            <div class="my_kurs_but parent">
                                                <a href="/course/<?php /*echo $course['course_id']*/?>" class="my_kurs_link">Узнать больше</a>
                                                <a href="#" class="my_kurs_link disabled">Расписание</a>
                                            </div>
                                        </div>
                                        <div class="my_kurs_mid"><?php /*echo $course['description']; */?></div>
                                        <div class="my_kurs_bot parent">
                                            <?php /*if ($course['coaches']) :*/?>
                                                <div class="my_kurs_tren_h">Тренер</div>
                                                <div class="my_kurs_tren_names">
                                                    <?php /*$last_coach = count($course['coaches']);
                                                    foreach ($course['coaches'] as $key => $coach) :*/?>
                                                        <a href="/profile/<?php /*echo $coach['id'];*/?>"><?php /*echo $coach['name'];*/?></a>
                                                        <?php /*if ($last_coach != ($key + 1)): echo ','; endif;*/?>
                                                    <?php /*endforeach;
                                                    unset($coach);*/?>
                                                </div>
                                            <?php /*endif;*/?>
                                        </div>
                                    </div>
                                </div>
                            <?php /*endforeach;
                            unset($course);*/?>
                        </div>
                        <?php /*include_once('./app_fold/views/pagination.php');*/?>
                    <?php /*else: */?>
                        <h3 class="info">Информация не найдена</h3>
                    --><?php /*endif;*/?>
                </div>
            </div>
        </div><!-- content_col -->
    </div>
</div><!-- content -->
