<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php if(!empty($pagination)):?>
    <div class="shop_block_nav" id="pagination">
        <?php if (!empty($pagination['first_id']) or !empty($pagination['last_id'])):?>
            <input type="hidden" name="i_first_id" id="i_first_id" value="<?php if (!empty($pagination['first_id'])) { echo $pagination['first_id']; } ?>" />
            <input type="hidden" name="i_first_price" id="i_first_price" value="<?php if (!empty($pagination['first_price'])) { echo $pagination['first_price']; } ?>" />
            <!--<input type="hidden" name="i_first_fc_price" id="i_first_fc_price" value="<?php /*if (!empty($first_fc_price)) { echo $first_fc_price; } */?>" />-->
            <input type="hidden" name="i_first_discount" id="i_first_discount" value="<?php if (!empty($pagination['first_discount'])) { echo $pagination['first_discount']; } ?>" />
            <input type="hidden" name="i_last_id" id="i_last_id" value="<?php if (!empty($pagination['last_id'])) { echo $pagination['last_id']; } ?>" />
            <input type="hidden" name="i_last_price" id="i_last_price" value="<?php if (!empty($pagination['last_price'])) { echo $pagination['last_price']; } ?>" />
            <!--<input type="hidden" name="i_last_fc_price" id="i_last_fc_price" value="<?php /*if (!empty($last_fc_price)) { echo $last_fc_price; } */?>" />-->
            <input type="hidden" name="i_last_discount" id="i_last_discount" value="<?php if (!empty($pagination['last_discount'])) { echo $pagination['last_discount']; } ?>" />
            <input type="hidden" name="category_id" value="<?php if (!empty($category_id)) { echo $category_id; }?>" id="category_id" />
            <input type="hidden" name="subcategory_id" value="<?php if (!empty($subcategory_id)) { echo $subcategory_id; }?>" id="subcategory_id" />

            <ul class="nav_ul">
                <li>
                    <?php if (!empty($pagination['first_id'])) : ?>
                        <a href="#" id="prev_page">Назад</a>
                    <?php else : ?>
                        <label title="Предыдущая" class="pag_but">Назад</label>
                    <?php endif;?>
                </li>
                <li>
                    <?php if (!empty($pagination['last_id'])) : ?>
                        <a href="#" id="next_page">Вперед</a>
                    <?php else : ?>
                        <label title="Следующая" class="pag_but">Вперед</label>
                    <?php endif; ?>
                </li>
            </ul>
        <?php endif;?>
    </div>
<?php elseif (empty($pagination)):?>
    <div class="shop_block_nav" id="pagination">
        <?php if (!empty($first_id) or !empty($last_id)):?>
            <input type="hidden" name="i_first_id" id="i_first_id" value="<?php if (!empty($first_id)) { echo $first_id; } ?>" />
            <input type="hidden" name="i_first_price" id="i_first_price" value="<?php if (!empty($first_price)) { echo $first_price; } ?>" />
            <!--<input type="hidden" name="i_first_fc_price" id="i_first_fc_price" value="<?php /*if (!empty($first_fc_price)) { echo $first_fc_price; } */?>" />-->
            <input type="hidden" name="i_first_discount" id="i_first_discount" value="<?php if (!empty($first_discount)) { echo $first_discount; } ?>" />
            <input type="hidden" name="i_last_id" id="i_last_id" value="<?php if (!empty($last_id)) { echo $last_id; } ?>" />
            <input type="hidden" name="i_last_price" id="i_last_price" value="<?php if (!empty($last_price)) { echo $last_price; } ?>" />
            <!--<input type="hidden" name="i_last_fc_price" id="i_last_fc_price" value="<?php /*if (!empty($last_fc_price)) { echo $last_fc_price; } */?>" />-->
            <input type="hidden" name="i_last_discount" id="i_last_discount" value="<?php if (!empty($last_discount)) { echo $last_discount; } ?>" />
            <input type="hidden" name="category_id" value="<?php if (!empty($category_id)) { echo $category_id; }?>" id="category_id" />
            <input type="hidden" name="subcategory_id" value="<?php if (!empty($subcategory_id)) { echo $subcategory_id; }?>" id="subcategory_id" />

            <ul class="nav_ul">
                <li>
                    <?php if (!empty($first_id)) : ?>
                        <a href="#" id="prev_page">Назад</a>
                    <?php else : ?>
                        <label title="Предыдущая" class="pag_but">Назад</label>
                    <?php endif;?>
                </li>
                <li>
                    <?php if (!empty($last_id)) : ?>
                        <a href="#" id="next_page">Вперед</a>
                    <?php else : ?>
                        <label title="Следующая" class="pag_but">Вперед</label>
                    <?php endif; ?>
                </li>
            </ul>
        <?php endif;?>
    </div>
<?php endif;?>