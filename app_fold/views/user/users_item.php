<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="tren_prof_page_img_wrap">
    <div class="tren_prof_page_img">
        <?php if(!empty($u['user_image'])):
            $user_img = $u['user_image'];
        elseif(!empty($u['user_soc_image'])):
            $user_img = $u['user_soc_image'];
        else:
            $user_img = "/img/no_img.png";
        endif; ?>
        <?php $user_type = (!empty($user_type)) ? $user_type : 'user';?>
        <?php $path = ($page_submenu == 'a_users_archive') ? '/administration/'.$user_type.'/archive/' : '/administration/'.$user_type.'/'; ?>
        <a href="<?php echo $path.$u['user_id']; ?>"><img src="<?php echo $user_img; ?>" alt=""></a>
    </div>
    <div class="tren_prof_page_name">
        <?php $u_name = (!empty($u['split_name']['name']) and $u['split_name']['name'] != 'Пользователь') ? $u['split_name']['name'] : '№' . $u['user_id']; ?>
        <?php echo $u_name; ?>
    </div>
    <div class="tren_prof_page_surname">
        <?php $u_surname = (!empty($u['split_name']['surname'])) ? $u['split_name']['surname'] : '';
        $u_surname = (empty($u['split_name']['name']) or $u['split_name']['name'] == 'Пользователь') ? 'пользователь' : $u_surname;?>
        <?php echo $u_surname; ?>
    </div>
    <?php if($u['user_deleted'] == 1): ?>
        <div class="admin_info">
            <?php echo $u['user_delete_date']; ?>
        </div>
    <?php endif; ?>
    <div class="tren_prof_page_soc">
        <?php include('./app_fold/views/user/profile/user_soc.php'); ?>
    </div>
</div>
