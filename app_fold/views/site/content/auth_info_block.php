<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<?php if (empty($user_session) and $site_info['auth_display'] == 1): ?>
    <div class="reg_wrap kurs_page_reg_wrap">
        <div class="reg_row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <h2 class="reg_h"><?php if(!empty($site_info['auth_title1'])): echo $site_info['auth_title1']; endif;?></h2>
                <div class="reg_desk"><?php if(!empty($site_info['auth_subtitle1'])): echo $site_info['auth_subtitle1']; endif;?></div>
                <div class="reg_txt"><?php if(!empty($site_info['auth_text1'])): echo $site_info['auth_text1']; endif;?></div>
                <a href="<?php if(!empty($site_info['auth_url1'])): echo $site_info['auth_url1']; endif;?>" class="reg_but login_form_up">
                    <?php if(!empty($site_info['auth_url_name1'])): echo $site_info['auth_url_name1']; endif;?>
                </a>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <h2 class="reg_h"><?php if(!empty($site_info['auth_title2'])): echo $site_info['auth_title2']; endif;?></h2>
                <div class="reg_desk"><?php if(!empty($site_info['auth_subtitle2'])): echo $site_info['auth_subtitle2']; endif;?></div>
                <div class="reg_txt"><?php if(!empty($site_info['auth_text2'])): echo $site_info['auth_text2']; endif;?></div>
                <a href="<?php if(!empty($site_info['auth_url2'])): echo $site_info['auth_url2']; endif;?>" class="reg_but login_form_up">
                    <?php if(!empty($site_info['auth_url_name2'])): echo $site_info['auth_url_name2']; endif;?>
                </a>
            </div>
        </div>
    </div><!-- reg_wrap -->
<?php endif;?>