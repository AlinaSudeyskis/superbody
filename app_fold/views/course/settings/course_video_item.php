<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include_once('./app_fold/views/course/settings/course_video_menu.php');
?>
<input type="hidden" name="i_course_id" value="<?php echo $course_id; ?>" />
<input type="hidden" name="i_video_type" value="<?php echo $video_menu; ?>" />
<?php if (!empty($video)) :?>
    <div class="admin_list">
        <?php foreach ($video as $vd) :?>
            <div class="admin_item parent">
                <div class="admin_video"><img src="<?php echo $vd['poster']?>" alt=""></div>
                <div class="admin_video_cont">
                    <div class="admin_name">
                        <a href="/administration/course/<?php echo $course_id; ?>/video/<?php echo $vd['id']; ?>"><?php echo $vd['name']; ?></a>
                    </div>
                    <div class="admin_set">
                        <a href="/administration/course/<?php echo $course_id; ?>/video/<?php echo $vd['id']; ?>">Редактировать</a>
                    </div>
                </div>
                <?php if($video_menu == 'promo' or $video_menu == 'instructions'): ?>
                    <div class="admin_cont f_right">
                        <div class="admin_set">
                            <div class="my_kurs_radio_wrap">
                                <input type="hidden" name="i_video_active" value="<?php echo $vd['active']; ?>" id="i-video-active-<?php echo $vd['id']; ?>"/>
                                <?php if ($vd['active'] == 1): ?>
                                    <input type="radio" name="ir_active_video" class="anketa_form_radio" value="<?php echo $vd['id']; ?>" id="video_active<?php echo $vd['id']; ?>" checked="checked"/>
                                    <label for="video_active<?php echo $vd['id']; ?>" class="label_video_active">Активно</label>
                                <?php else: ?>
                                    <input type="radio" name="ir_active_video" class="anketa_form_radio" value="<?php echo $vd['id']; ?>" id="video_active<?php echo $vd['id']; ?>"/>
                                    <label for="video_active<?php echo $vd['id']; ?>" class="label_video_active">Выбрать</label>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach;
        unset($vd);?>
    </div>
    <?php include_once('./app_fold/views/pagination.php');
else:?>
    <h3 class="info">Информация не найдена</h3>
<?php endif;
include_once('./app_fold/views/pagination.php');