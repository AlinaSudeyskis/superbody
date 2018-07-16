<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="content_block pop-up_content_block">
    <div class="content_block_h parent">
        <h3><?php if(!empty($meal_time)) : echo $meal_time; endif; ?></h3>
    </div>
    <div class="meal_block_val" style="display: inline-block;">
        <div class="col-lg-6">
            <div class="selected_meals">
                <?php $weight = 0;
                $proteins = 0;
                $fats = 0;
                $carbohydrates = 0;
                $calories = 0;

                foreach($meals_data['meals'] as $type_id => $ml_info): ?>
                    <div class="meal_type"><?php echo $meals_data['meals_types'][$type_id]; ?></div>
                    <?php foreach($ml_info as $meal): ?>
                        <div class="meal_title show_meal" data-unid="<?php echo $meal['un_id']; ?>" data-did="<?php echo $day; ?>"
                             data-iid="<?php echo $ingestion; ?>" data-mlid="<?php echo $meal['id']; ?>" data-time="<?php echo $meal_time; ?>"><?php echo $meal['name']; ?></div>

                        <?php $weight += $meal['weight'];
                        $proteins += $meal['proteins'];
                        $fats += $meal['fats'];
                        $carbohydrates += $meal['carbohydrates'];
                        $calories += $meal['calories'];
                    endforeach;
                    unset($m);
                endforeach;
                unset($ml_info);?>
                <div class="">
                    <div class="meal_wpfcc_wrap">
                        <div class="meal_wpfcc">
                            <div class="meal_wpfcc_title">Вес</div>
                            <div class="meal_wpfcc_val"><?php echo $weight; ?></div>
                        </div>
                        <div class="meal_wpfcc">
                            <div class="meal_wpfcc_title">Белки</div>
                            <div class="meal_wpfcc_val"><?php echo $proteins; ?></div>
                        </div>
                        <div class="meal_wpfcc">
                            <div class="meal_wpfcc_title">Жиры</div>
                            <div class="meal_wpfcc_val"><?php echo $fats; ?></div>
                        </div>
                        <div class="meal_wpfcc">
                            <div class="meal_wpfcc_title">Углеводы</div>
                            <div class="meal_wpfcc_val"><?php echo $carbohydrates; ?></div>
                        </div>
                        <div class="meal_wpfcc">
                            <div class="meal_wpfcc_title">Калории</div>
                            <div class="meal_wpfcc_val"><?php echo $calories; ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="meal_block_img">
                <?php if(!empty($meals_data['image'])): ?>
                    <img src="<?php echo $meals_data['image']; ?>" alt="" style="width:100%;" />
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>