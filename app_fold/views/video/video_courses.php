<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php include_once('./app_fold/views/video/page_part/header.php');
    if (!empty($courses)) :?>
        <div class="admin_list">
            <?php foreach ($courses as $course) :?>
                <div class="admin_item parent">
                    <div class="admin_ava">
                        <?php if (!empty($course['image'])):?>
                            <img src="<?php echo $course['image'];?>" alt="" />
                        <?php endif;?>
                    </div>
                    <div class="admin_cont">
                        <div class="admin_name">
                            <a href="/administration/video/course/<?php echo $course['id'];?>" class="admin_name"><?php echo $course['name'];?></a>
                        </div>
                    </div>
                </div>
            <?php endforeach;
            unset($course);?>
        </div>
        <?php include_once('./app_fold/views/pagination.php');
    else:?>
        <h3 class="info">Информация не найдена</h3>
    <?php endif;
include_once('./app_fold/views/video/page_part/footer.php');?>
