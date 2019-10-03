<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="content" class="container">
    <div class="row">
        <div class="col-lg-2 left_sidebar">
            <?php include_once('./app_fold/views/admin/admin_menu.php');?>
        </div><!-- left_sidebar -->
        <div class="col-lg-10 content_col">
            <form action="" method="post">
                <div class="line">
                    <div class="input_name">Наименование:</div>
                    <div class="input_value"><input type="text" name="name" value="" maxlength="255" required="required"/></div>
                </div>
                <p><input type="submit" name="bt_save_new_subcategory" value="Сохранить" id="defaultActionButton" /></p>
            </form>
        </div><!-- content_col -->
    </div>
</div><!-- content -->