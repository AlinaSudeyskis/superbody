<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="content" class="container">
    <div class="row">
        <div class="col-lg-2 left_sidebar">
            <?php include_once('./app_fold/views/admin/admin_menu.php');?>
        </div><!-- left_sidebar -->
        <div class="col-lg-10 content_col">
            <a href="/administration/course/new">Добавить</a><br/>
            <a href="/administration/course/<?php echo $course_id;?>/clients" class="menu_border">Активность клиентов</a><br/>
            <?php if (!empty($course_users)) :
                foreach ($course_users as $us) :?>
                    <a href="/administration/course/<?php echo $course_id; ?>/client/<?php echo $us['id']?>"><?php echo $us['name']?></a><br/>
                <?php endforeach;
                unset($us);?>
            <?php else :?>
                <div>Нет прикрепленных пользователей</div>
            <?php endif;?>
        </div><!-- content_col -->
    </div>
</div><!-- content -->

