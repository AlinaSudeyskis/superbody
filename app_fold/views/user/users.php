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
                            <h3>Пользователи</h3>
                        </div>
                        <?php include_once('./app_fold/views/admin/users_submenu.php'); ?>
                    </div>
                </div>
                <div class="kurs_block_val users_page">
                    <div class="search_form_wrap">
                        <div class="open_search_form"></div>
                        <?php $pages = array('auth' => 'eu_auth', 'bought' => 'eu_bought', 'archive' => 'archive');
                        $url_page = (!empty($page_2submenu) and array_search($page_2submenu, $pages)) ? array_search($page_2submenu, $pages) : ''; ?>
                        <form action="/administration/users/<?php echo $url_page; ?>" class="search_form parent" method="post">
                            <input type="text" name="search" class="search_in" placeholder="Поиск" value="<?php if(!empty($search_text)): echo $search_text; endif; ?>">
                            <input type="submit" name="bt_users_search" class="search_but" value="Отправить">
                        </form>
                    </div>
                    <?php if (!empty($users)):?>
                        <div class="admin_list users">
                            <?php foreach ($users as $u): ?>
                                <?php include('./app_fold/views/user/users_item.php'); ?>
                            <?php endforeach;
                            unset($u);?>
                            <!--<div class="admin_item parent">
                                <div class="admin_ava">
                                    <?php /*if(!empty($u['user_image'])):
                                        $user_img = $u['user_image'];
                                    elseif(!empty($u['user_soc_image'])):
                                        $user_img = $u['user_soc_image'];
                                    else:
                                        $user_img = "/img/no_img.png";
                                    endif; */?>
                                    <img src="<?php /*echo $user_img; */?>" alt="">
                                </div>
                                <div class="admin_cont">
                                    <div class="admin_name">
                                        <?php /*$u_name = (!empty($u['user_name'])) ? $u['user_name'] : 'Пользователь №' . $u['user_id'];
                                        $profile_link = ($page_submenu == 'a_users_archive') ? '/administration/users/archive/' . $u['user_id'] : '/profile/' . $u['user_id']; */?>
                                        <a href="<?php /*echo $profile_link; */?>"><?php /*echo $u_name; */?></a>
                                    </div>
                                    <?php /*if($u['user_deleted'] == 1): */?>
                                        <div class="admin_info">
                                            <?php /*echo $u['user_delete_date']; */?>
                                        </div>
                                    <?php /*endif; */?>
                                    <?php /*if($page_submenu != 'a_users_archive'): */?>
                                        <div class="admin_set">
                                            <?php /*$path = ($page_submenu == 'a_users_archive') ? '/administration/users/archive/' : '/administration/user/'; */?>
                                            <a href="<?php /*echo $path.$u['user_id']; */?>">Редактировать</a>
                                        </div>
                                    <?php /*endif; */?>
                                </div>
                            </div>-->
                        </div>
                        <?php
                            $category_id = 'users';
                            $subcategory_id = $url_page;
                        ?>
                        <?php include_once('./app_fold/views/pagination.php'); ?>
                    <?php else: ?>
                        <h3 class="info">Информация не найдена</h3>
                    <?php endif; ?>
                </div>
            </div>
        </div><!-- content_col -->
    </div>
</div><!-- content -->
