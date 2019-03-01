<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="content" class="container">
    <div class="row">
        <div class="col-lg-2 left_sidebar">
            <?php include_once('./app_fold/views/user/user_menu.php');?>
        </div><!-- left_sidebar -->
        <div class="col-lg-10 content_col">
            <div class="content_block">
                <?php //print_r($anthropometric['weight']);?>
                <div class="content_block_h parent">
                    <h3>График изменения параметров тела</h3>
                    <div class="content_block_h_buts">
                        <div class="content_block_h_slide chart_wrap_slide"></div>
                        <div class="content_block_h_close"></div>
                    </div>
                </div>
                <div class="video_admin_form">
                    <?php include_once('./app_fold/views/user/questionnaire/charts.php');?>
                    <div class="anketa_block_item_h">Антропометрические данные</div>
                    <?php include_once('./app_fold/views/user/questionnaire/anthropometric_form.php');?>
                </div>
            </div>
        </div>
    </div>
</div>