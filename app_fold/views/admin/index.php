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
                            <h3>Админ. панель</h3>
                        </div>
                    </div>
                </div>
                <div class="kurs_block_val">
                    <div class="admin_list">
                        <?php if(!empty($table_data)):
                            foreach($table_data as $table):
                                $not_null = ($table->Null == 'NO') ? 'Not Null' : 'Null';
                                echo $table->Field . ' ' . $table->Type . ' ' . $not_null . ' Key: ' . $table->Key
                                    . ' Default: ' . $table->Default. ' Extra: ' . $table->Extra . '<br/>';
                            endforeach;
                            unset($table);
                        endif; ?>
                        <?php if(!empty($table_info)):
                            foreach($table_info as $t_i):
                                print_r($t_i); echo '<br/>';
                            endforeach;
                            unset($table);
                        endif; ?>
                        <?php if(!empty($update_result)):
                            echo $update_result;
                        endif; ?>
                        <?php if(!empty($tables_data)):
                            $count_tables = count($tables_data);
                            echo $count_tables.'<br/>';
                            foreach($tables_data as $table):
                                echo $table.'<br/>';
                            endforeach;
                            unset($table);
                        endif; ?>
                        <?php if(!empty($update_dates)):
                            foreach($update_dates as $up_date):
                                echo $up_date->db_date.'<br/>';
                            endforeach;
                            unset($table);
                        endif; ?>
                    </div>
                </div>
            </div>
        </div><!-- content_col -->
    </div>
</div><!-- content -->
