<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="content" class="container">
    <div class="row">
        <div class="col-lg-2 left_sidebar">
            <?php include_once('./app_fold/views/admin/admin_menu.php');?>
        </div><!-- left_sidebar -->
        <div class="col-lg-10 content_col">
            <div class="content_block new_content_block">
                <div class="content_block_container_wrap">
                    <div class="content_block_container">
                        <div class="content_block_h new_content_block_h parent">
                            <h3>Курсы питания</h3>
                            <a href="/administration/nutrition/new" class="add_tab_but">Новый курс</a>
                        </div>
                        <?php include_once('./app_fold/views/course/nutritions/menu.php'); ?>
                    </div>
                </div>
                <div class="kurs_block_val">
                    <?php if(!empty($courses)): ?>
                        <div class="admin_list kurs_list">
                            <?php foreach ($courses as $course): ?>
                                <div class="admin_item parent">
                                    <div class="admin_ava">
                                        <?php if (!empty($course['image'])):?>
                                            <img src="<?php echo $course['image'];?>" alt="" />
                                        <?php endif;?>
                                    </div>
                                    <div class="admin_cont">
                                        <div class="admin_name">
                                            <a href="/administration/nutrition/<?php echo $course['id'];?>"><?php echo $course['name'];?></a>
                                        </div>
                                        <div class="admin_set">
                                            <a href="/administration/nutrition/<?php echo $course['id']?>">Редактировать</a>
                                        </div>
                                        <div class="admin_set">
                                            <a href="/administration/nutrition/<?php echo $course['id']?>/preview">Предпросмотр</a>
                                        </div>
                                    </div>
                                    <?php if ($course['landing']['activated'] !== false) : ?>
                                        <div class="admin_cont f_right">
                                            <div class="admin_name">
                                                <a href="/course/<?php echo $course['id']?>">Landing page</a>
                                            </div>
                                            <div class="admin_name">
                                                <form action="" method="post">
                                                    <input type="hidden" name="i_course_id" value="<?php echo $course['id']?>" />
                                                    <?php if ($course['landing']['activated'] == 'activate') : ?>
                                                        <input type="submit" name="bt_deactivate_landing" value="Деактивировать" class="video_admin_form_send" />
                                                    <?php else : ?>
                                                        <input type="submit" name="bt_activate_landing" value="Активировать" class="video_admin_form_send" />
                                                    <?php endif; ?>
                                                </form>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach;
                            unset($course);?>
                        </div>
                    <?php else: ?>
                        <h3 class="info">Информация не найдена</h3>
                    <?php endif; ?>
                    <?php include_once('./app_fold/views/pagination.php');?>
                </div>
            </div>
        </div><!-- content_col -->
    </div>
</div><!-- content -->
