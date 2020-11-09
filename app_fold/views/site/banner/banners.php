<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="admin_list">
    <?php if (!empty($banners)) :
        foreach ($banners as $banner) :?>
            <?php if($banner['id'] > 1): ?>
                <div class="admin_item parent">
                    <?php if(!empty($banner['image'])): ?>
                        <div class="admin_video"><img src="<?php echo $banner['image']?>" alt=""></div>
                    <?php endif; ?>
                    <div class="admin_video_cont">
                        <div class="admin_name">
                            <?php if($banner['id'] > 1): ?>
                                <a href="/administration/site/banner/<?php echo $banner['id']?>">Баннер №<?php echo $banner['id']?></a>
                            <?php else: ?>
                                <a href="/administration/site/banner/<?php echo $banner['id']?>">Баннер рекламы</a>
                            <?php endif; ?>
                        </div>
                        <div class="admin_set">
                            <a href="/administration/site/banner/<?php echo $banner['id']?>">Редактировать</a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach;
        unset($banner);
    endif;?>
</div>
<?php include_once('./app_fold/views/pagination.php'); ?>
