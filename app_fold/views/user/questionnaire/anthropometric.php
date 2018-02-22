<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="content" class="container">
    <div class="row">
        <div class="col-lg-2 left_sidebar">
            <?php include_once('./app_fold/views/user/user_menu.php');?>
        </div><!-- left_sidebar -->
        <div class="col-lg-10 content_col">
            <div class="content_block new_content_block no_over">
                <div class="content_block_h parent">
                    <h3>Антропометрические данные</h3>
                    <div class="content_block_h_buts">
                        <div class="content_block_h_slide kurs_slide"></div>
                        <div class="content_block_h_close"></div>
                    </div>
                </div>
                <div class="kurs_block_val">
                    <div class="anketa_block">
                        <div class="anketa_block_cont">
                            <div class="anketa_block_item">
                                <div class="anketa_block_item_h"></div>
                                <div class="anketa_block_item_cont">
                                    <?php include_once('./app_fold/views/user/questionnaire/anthropometric_form.php');?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- content_col -->
    </div>
</div><!-- content -->