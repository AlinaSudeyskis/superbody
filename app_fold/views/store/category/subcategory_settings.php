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
                    <div class="input_name">Категория:</div>
                    <div class="input_value">
                        <select name="s_categories">
                            <?php foreach ($categories as $category) :?>
                                <option value="<?php echo $category['id'];?>"
                                        <?php if ($category['id'] == $subcategory['cat_id']) :?>selected="selected"<?php endif;?>
                                ><?php echo $category['name'];?></option>
                                <?php unset($category);
                            endforeach;?>
                        </select>
                    </div>
                </div>
                <div class="line">
                    <div class="input_name">Наименование:</div>
                    <div class="input_value"><input type="text" name="name" value="<?php echo $subcategory['name'];?>" maxlength="255" required="required"/></div>
                </div>
                <p>
                    <input type="submit" name="bt_save_subcategory" value="Сохранить"/>
                    <?php if ($subcategory['blocked'] == 0) : ?>
                        <input type="submit" name="bt_block_subcategory" value="Заблокировать"/>
                    <?php else: ?>
                        <input type="submit" name="bt_unblock_subcategory" value="Разблокировать"/>
                    <?php endif;?>
                </p>
            </form>
        </div><!-- content_col -->
    </div>
</div><!-- content -->