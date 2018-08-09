<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="content" class="container">
    <div class="row">
        <div class="col-lg-2 left_sidebar">
            <?php include_once('./app_fold/views/admin/admin_menu.php');?>
        </div><!-- left_sidebar -->
        <div class="col-lg-10 content_col">
            <div class="content_block">
                <div class="content_block_container_wrap">
                    <div class="content_block_container">
                        <div class="content_block_h new_content_block_h parent">
                            <h3>Тип приема пищи</h3>
                            <a href="/administration/ingestion/type/new" class="add_tab_but">Добавить</a>
                        </div>
                    </div>
                </div>
                <div class="kurs_block_val">
                    <div class="admin_list">
                        <?php if (!empty($types)) :
                            foreach ($types as $type) :?>
                                <div class="admin_item parent">
                                    <div class="admin_ava"></div>
                                    <div class="admin_cont">
                                        <div class="admin_name">
                                            <a href="/administration/ingestion/type/<?php echo $type['id']?>"><?php echo $type['name']?></a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach;
                            unset($type);
                        endif;?>
                    </div>
                    <?php include_once('./app_fold/views/pagination.php'); ?>
                </div>
            </div>
        </div><!-- content_col -->
    </div>
</div><!-- content -->
