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
                            <h3>Информация о сайте</h3>
                            <div class="content_block_h_ref"><a href="/administration/site/banner/new" class="add_tab_but">Добавить баннер</a></div>
                        </div>
                        <?php include_once('./app_fold/views/site/menu.php');?>
                    </div>
                </div>
                <div class="kurs_block_val">
                    <div class="anketa_block_cont">
                        <?php if ($page_submenu == 'index'):
                            include_once('./app_fold/views/site/settings/index.php');
                        elseif ($page_submenu == 'header'):
                            include_once('./app_fold/views/site/settings/header_footer.php');
                        elseif ($page_submenu == 'banner') :
                            include_once('./app_fold/views/site/banner/banners.php');
                        elseif ($page_submenu == 'a_about') :
                            include_once('./app_fold/views/site/settings/about.php');
                        elseif ($page_submenu == 'a_contacts') :
                            include_once('./app_fold/views/site/settings/contacts.php');
                        elseif ($page_submenu == 'a_auth') :
                            include_once('./app_fold/views/site/settings/auth.php');
                        elseif ($page_submenu == 'a_spec') :
                            include_once('./app_fold/views/site/settings/courses_spec.php');
                        elseif ($page_submenu == 'a_meta') :
                            include_once('./app_fold/views/site/settings/meta_data.php');
                        elseif ($page_submenu == 'a_cookies') :
                            include_once('./app_fold/views/site/settings/cookies.php');
                        elseif ($page_submenu == 'a_advertising') :
                            include_once('./app_fold/views/site/settings/advertising.php');
                        else:?>
                            <h3 class="info">Информация не найдена</h3>
                        <?php endif;?>
                    </div>
                </div>
            </div>
        </div><!-- content_col -->
    </div>
</div><!-- content -->
