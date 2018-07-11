<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="content_block pop-up_content_block">
    <div class="content_block_h parent">
        <h3><?php if(!empty($meal_time)) : echo $meal_time; endif; ?></h3>
    </div>
    <div class="meal_block_val" style="display: block;">
        <div class="col-lg-6">
            <div class="meal_block_img">
                <?php if(!empty($meal_data['meal']['meal_videos'])):
                    foreach($meal_data['meal']['meal_videos'] as $ml_video): ?>
                        <iframe src="<?php echo $ml_video; ?>?enablejsapi=1&origin=http://sb.theoutlines.ru" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen class="yt-player"></iframe>
                    <?php endforeach;
                    unset($ml_video);
                endif;
                if(!empty($meal_data['meal']['images'])):
                    foreach($meal_data['meal']['images'] as $img):?>
                        <img src="<?php echo $meal_data['meal']['images_path']; ?>/<?php echo $img; ?>" alt="" style="width:100%;" />
                    <?php endforeach;
                    unset($img);
                endif; ?>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="selected_meal">
                <div class="meal_title"><?php echo $meal_data['meal']['name']; ?></div>
                <div class="meal_subtitle"><?php echo $meal_data['meal']['description']; ?></div>
                <div class="meal_text_wrap">
                    <div class="meal_text_title">Ингредиенты:</div>
                    <div class="meal_text"><?php echo $meal_data['meal']['ingredients_text']; ?></div>
                </div>
                <div class="meal_wpfcc_wrap">
                    <div class="meal_wpfcc">
                        <div class="meal_wpfcc_title">Вес</div>
                        <div class="meal_wpfcc_val"><?php echo $meal_data['meal']['weight']; ?></div>
                    </div>
                    <div class="meal_wpfcc">
                        <div class="meal_wpfcc_title">Белки</div>
                        <div class="meal_wpfcc_val"><?php echo $meal_data['meal']['proteins']; ?></div>
                    </div>
                    <div class="meal_wpfcc">
                        <div class="meal_wpfcc_title">Жиры</div>
                        <div class="meal_wpfcc_val"><?php echo $meal_data['meal']['fats']; ?></div>
                    </div>
                    <div class="meal_wpfcc">
                        <div class="meal_wpfcc_title">Углеводы</div>
                        <div class="meal_wpfcc_val"><?php echo $meal_data['meal']['carbohydrates']; ?></div>
                    </div>
                    <div class="meal_wpfcc">
                        <div class="meal_wpfcc_title">Калории</div>
                        <div class="meal_wpfcc_val"><?php echo $meal_data['meal']['calories']; ?></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="meal_other_block_wrap">
            <?php // Выбор другого блюда
            $tmp_date = new DateTime($this->date);
            $today    = ($tmp_date !== false) ? $tmp_date->format('Y-m-d') : '';
            $tmp_date->add(new DateInterval("P30D"));
            $in_a_month = ($tmp_date !== false) ? $tmp_date->format('Y-m-d') : '';

            if(!empty($ingestion_data['meals']) and $meal_data['un_date'] >= $today and $meal_data['un_date'] < $in_a_month):?>
                <div class="meal_other_block">
                    <div class="meal_other_block_h" id="change-meal" data-day="<?php echo $day; ?>" data-ingestion="<?php echo $ingestion; ?>">Выбрать другое блюдо</div>
                    <div class="meal_other_wrap">
                        <?php foreach($ingestion_data['meals'] as $meal):
                            if($meal['id'] != $meal_data['meal']['id']):?>
                                <div class="meal_other_link" data-mlid="<?php echo $meal['id']; ?>" data-did="<?php echo $day; ?>" data-iid="<?php echo $ingestion; ?>" data-unid="<?php echo $un_id; ?>">
                                    <?php echo $meal['name'] . ' 
                            [ Вес: ' . $meal['weight'] . '; БЖУК: ' . $meal['proteins'] . ' ' .
                                        $meal['fats'] . ' ' .
                                        $meal['carbohydrates'] . ' ' .
                                        $meal['calories'] . ']'; ?>
                                </div>
                            <?php endif;
                        endforeach;
                        unset($meal);?>
                    </div>
                </div>
            <?php endif;?>
        </div>
    </div>
</div>
