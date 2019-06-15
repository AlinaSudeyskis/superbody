<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once('./app_fold/views/course/user_course/page_part/header.php');?>
<?php if(!empty($course_menu)):?>
    <div class="anketa_block">
        <div class="anketa_block_cont">
            <div class="anketa_block_item">
                <div class="anketa_block_item_cont">
                    <?php $days = array(1 => 'Понедельник', 2 => 'Вторник', 3 => 'Среда', 4 => 'Четверг', 5 => 'Пятница', 6 => 'Суббота', 7 => 'Воскресенье');
                    foreach($course_menu as $cm_date => $cm):
                        $weight = 0;
                        $proteins = 0;
                        $fats = 0;
                        $carbohydrates = 0;
                        $calories = 0;
                        $meal_image = '';
                        $meal_images = '';

                        $tmp_date = new DateTime($cm_date);
                        $num_day = ($tmp_date !== false) ? $tmp_date->format('N') : false;
                        $day = ($num_day !== false and array_key_exists($num_day, $days)) ? $days[$num_day] : false;
                        $date = $tmp_date->format('d.m.Y');?>
                        <div class="anketa_block_item_h" style="display: flex; clear: both;">
                            <?php echo $day; ?>
                            <span style="color: #b3b3b3; font-size: 10px; font-weight: normal; line-height: 35px; margin-left: 7px;"><?php echo '('.$date.')'; ?></span>
                        </div>
                        <?php if(!empty($cm)):?>
                            <div style="clear: both; overflow: hidden; padding-bottom: 20px;">
                                <div style="float: left;width:calc(100% - 300px);">
                                    <?php foreach($cm as $cm_ingestion): ?>
                                        <div class="anketa_form_line parent">
                                            <div class="anketa_form_h"><div class="anketa_form_h_cell"><?php echo $cm_ingestion['name']; ?></div></div>
                                            <div style="float:left; width: calc(100% - 205px); padding-top:5px;">
                                                <?php if(!empty($cm_ingestion['meal_category'])):
                                                    foreach($cm_ingestion['meal_category'] as $ml_type):
                                                        $meal = $ml_type['meal'];
                                                        $meal_image = (!empty($meal['image']) and empty($meal_image)) ? $meal['image'] : $meal_image;
                                                        $meal_images = (!empty($meal['images']) and empty($meal_images)) ? $meal['images_path'] . '/' .current($meal['images']) : $meal_images;
                                                        ?>
                                                        <div>
                                                            <b><?php echo $meal['name']; ?></b>
                                                        </div>
                                                        <?php if(!empty($meal['description'])): ?>
                                                            <div><?php echo $meal['description']; ?></div>
                                                        <?php endif;?>
                                                        <br/>
                                                        <?php
                                                        $weight += $meal['weight'];
                                                        $proteins += $meal['proteins'];
                                                        $fats += $meal['fats'];
                                                        $carbohydrates += $meal['carbohydrates'];
                                                        $calories += $meal['calories'];
                                                        ?>
                                                    <?php endforeach;
                                                    unset($ml_type);
                                                endif;?>
                                            </div>
                                        </div>
                                    <?php endforeach;
                                    unset($cm_ingestion);?>
                                    <div class="meal_wpfcc_wrap">
                                        <div class="meal_wpfcc">
                                            <div class="meal_wpfcc_title" short="В">Вес</div>
                                            <div class="meal_wpfcc_val"><?php echo $weight; ?></div>
                                        </div>
                                        <div class="meal_wpfcc">
                                            <div class="meal_wpfcc_title" short="Б">Белки</div>
                                            <div class="meal_wpfcc_val"><?php echo $proteins; ?></div>
                                        </div>
                                        <div class="meal_wpfcc">
                                            <div class="meal_wpfcc_title" short="Ж">Жиры</div>
                                            <div class="meal_wpfcc_val"><?php echo $fats; ?></div>
                                        </div>
                                        <div class="meal_wpfcc">
                                            <div class="meal_wpfcc_title" short="У">Углеводы</div>
                                            <div class="meal_wpfcc_val"><?php echo $carbohydrates; ?></div>
                                        </div>
                                        <div class="meal_wpfcc">
                                            <div class="meal_wpfcc_title" short="К">Калории</div>
                                            <div class="meal_wpfcc_val"><?php echo $calories; ?></div>
                                        </div>
                                    </div>
                                </div>
                                <div style="float:left; width: 300px; padding-top:5px;">
                                    <?php if(!empty($meal_image)):?>
                                        <img src="<?php echo $meal_image; ?>" alt="" border="0" width="100%" />
                                    <?php elseif(!empty($meal_images)): ?>
                                        <img src="<?php echo $meal_images; ?>" alt="" border="0" width="100%" />
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endif;
                    endforeach;
                    unset($cm);?>
                </div>
            </div>
        </div>
    </div>
<?php else: ?>
    <h3 class="info">Информация не найдена</h3>
<?php endif; ?>
<?php include_once('./app_fold/views/course/user_course/page_part/footer.php');?>