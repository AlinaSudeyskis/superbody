<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include_once('./app_fold/views/course/settings/course_video_menu.php');
?>
<?php if (!empty($video)) :?>
    <div class="admin_list">
        <?php foreach ($video as $vd) :?>
            <div class="admin_item parent">
                <div class="admin_video"><img src="<?php echo $vd['poster']?>" alt=""></div>
                <div class="admin_video_cont">
                    <div class="admin_name">
                        <a href="/administration/course/<?php echo $course_id;?>/video/<?php echo $vd['id']?>" class="admin_name"><?php echo $vd['name']?></a>
                    </div>
                    <div class="admin_set">
                        <a href="/administration/course/<?php echo $course_id;?>/video/<?php echo $vd['id']?>" class="admin_set">Редактировать</a>
                    </div>
                </div>
            </div>
        <?php endforeach;
        unset($vd);?>
    </div>
    <?php include_once('./app_fold/views/pagination.php');
else:?>
    <h3 class="info">Информация не найдена</h3>
<?php endif;
include_once('./app_fold/views/pagination.php');