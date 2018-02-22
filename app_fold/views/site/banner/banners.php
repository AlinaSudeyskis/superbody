<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="admin_list">
    <?php if (!empty($banners)) :
        foreach ($banners as $banner) :?>
            <div class="admin_item parent">
                <div class="admin_video"><img src="<?php echo $banner['image']?>" alt=""></div>
                <div class="admin_video_cont">
                    <div class="admin_name">
                        <a href="/administration/site/banner/<?php echo $banner['id']?>" class="admin_name">Баннер №<?php echo $banner['id']?></a>
                    </div>
                    <div class="admin_set">
                        <a href="/administration/site/banner/<?php echo $banner['id']?>" class="admin_set">Редактировать</a>
                    </div>
                </div>
            </div>
        <?php endforeach;
        unset($banner);
    endif;?>
</div>
<?php include_once('./app_fold/views/pagination.php'); ?>
