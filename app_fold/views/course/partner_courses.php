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
                    <h3>Мои курсы</h3>
                    <div class="content_block_h_buts">
                        <div class="content_block_h_slide kurs_slide"></div>
                        <div class="content_block_h_close"></div>
                    </div>
                </div>
                <div class="kurs_block_val">
                    <?php if (!empty($courses)) :?>
                        <div class="my_kurs_block">
                            <?php foreach ($courses as $course) :?>
                                <div class="my_kurs_item parent">
                                    <div class="my_kurs_img">
                                        <a href="">
                                            <?php if (!empty($course['image'])) :?>
                                                <img src="<?php echo $course['image'];?>" alt=""/>
                                            <?php endif;?>
                                        </a>
                                    </div>
                                    <div class="my_kurs_cont">
                                        <div class="my_kurs_top parent">
                                            <div class="my_kurs_name"><a href="/partner/course/<?php echo $course['course_id']?>"><?php echo $course['name'];?></a></div>
                                            <div class="my_kurs_but parent">
                                                <a href="/course/<?php echo $course['course_id']?>" class="my_kurs_link">Узнать больше</a>
                                                <a href="#" class="my_kurs_link disabled">Расписание</a>
                                            </div>
                                        </div>
                                        <div class="my_kurs_mid"><?php echo $course['description']; ?></div>
                                        <div class="my_kurs_bot parent">
                                            <?php if ($course['coaches']) :?>
                                                <div class="my_kurs_tren_h">Тренер</div>
                                                <div class="my_kurs_tren_names">
                                                    <?php $last_coach = count($course['coaches']);
                                                    foreach ($course['coaches'] as $key => $coach) :?>
                                                        <a href="/profile/<?php echo $coach['id'];?>"><?php echo $coach['name'];?></a>
                                                        <?php if ($last_coach != ($key + 1)): echo ','; endif;?>
                                                    <?php endforeach;
                                                    unset($coach);?>
                                                </div>
                                            <?php endif;?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach;
                            unset($course);?>
                        </div>
                        <?php include_once('./app_fold/views/pagination.php');?>
                    <?php else: ?>
                        <h3 class="info">Информация не найдена</h3>
                    <?php endif;?>
                </div>
            </div>
        </div><!-- content_col -->
    </div>
</div><!-- content -->
