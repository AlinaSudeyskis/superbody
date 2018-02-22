<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="content" class="container">
    <div class="row">
        <div class="col-lg-2 left_sidebar">
            <?php include_once('./app_fold/views/admin/admin_menu.php');?>
        </div><!-- left_sidebar -->
        <div class="col-lg-10 content_col">
            <div class="content_block">
                <div class="content_block_h new_content_block_h parent">
                    <h3>Курсы</h3>
                    <a href="/administration/course/new" class="add_tab_but">Добавить</a>
                    <div class="content_block_h_buts">
                        <div class="content_block_h_slide kurs_slide"></div>
                        <div class="content_block_h_close"></div>
                    </div>
                </div>
                <div class="kurs_block_val">
                    <?php
                        // TODO Перенос пунтка меню "Категория курса" на страницу списка курсов в АП
                        // TODO Изменить вывод отображения курсов и категорий
                        // TODO Добавить "Архив"
                    ?>
                    <ul class="anketa_block_nav parent">
                        <li>
                            <a href="/administration/courses">
                                <span <?php if ($page_submenu == 'a_courses'): ?> class="anketa_active" <?php endif;?>>Курсы</span>
                            </a>
                        </li>
                        <li>
                            <a href="/administration/courses/type">
                                <span <?php if ($page_submenu == 'course_type') { echo 'class="active"'; } ?>>Категория курса</span>
                            </a>
                        </li>
                    </ul>
                    <div class="admin_list kurs_list">
                        <?php if (!empty($courses)) :
                            foreach ($courses as $course) :?>
                                <div class="admin_item parent">
                                    <div class="admin_ava">
                                        <?php if (!empty($course['image'])):?>
                                            <img src="<?php echo $course['image'];?>" alt="" />
                                        <?php endif;?>
                                    </div>
                                    <div class="admin_cont">
                                        <div class="admin_name">
                                            <a href="/administration/course/<?php echo $course['id'];?>/statistics" class="admin_name"><?php echo $course['name'];?></a>
                                        </div>
                                        <div class="admin_set">
                                            <a href="/administration/course/<?php echo $course['id']?>" class="admin_set">Редактировать</a>
                                        </div>
                                    </div>
                                    <?php if ($course['landing']['activated'] !== false) : ?>
                                        <form action="" method="post">
                                            <div class="admin_cont f_right">
                                                <div class="admin_name">
                                                    <a href="/course/<?php echo $course['id']?>">Landing page</a>
                                                </div>
                                                <div class="admin_set">
                                                    <input type="hidden" name="i_course_id" value="<?php echo $course['id']?>" />
                                                    <?php if ($course['landing']['activated'] == 'activate') : ?>
                                                        <input type="submit" name="bt_deactivate_landing" value="Деактивировать" class="video_admin_form_send" />
                                                    <?php else : ?>
                                                        <input type="submit" name="bt_activate_landing" value="Активировать" class="video_admin_form_send" />
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach;
                            unset($course);
                        endif;?>
                    </div>
                    <?php include_once('./app_fold/views/pagination.php');?>
                </div>
            </div>
        </div><!-- content_col -->
    </div>
</div><!-- content -->
