<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once('./app_fold/views/course/user_course/page_part/header.php');?>
<div class="anketa_block">
    <div class="anketa_block_cont">
        <div class="anketa_block_item">
            <div class="anketa_block_item_cont">
                <?php if(!empty($course_menu)):
                    foreach($course_menu as $cm_date => $cm):?>
                        <div class="anketa_block_item_h"><?php echo $cm_date; ?></div>
                        <?php if(!empty($cm)):
                            foreach($cm as $cm_ingestion): ?>
                                <div class="anketa_form_line parent">
                                    <div class="anketa_form_h"><div class="anketa_form_h_cell"><?php echo $cm_ingestion['name']; ?></div></div>
                                    <div style="float:left;">
                                        <?php if(!empty($cm_ingestion['meal'])):
                                            $meal = $cm_ingestion['meal'];
                                            //foreach($cm_ingestion['meal'] as $meal):?>
                                                <div>
                                                    <b><?php echo $meal['name']; ?></b> (БЖУК - <?php echo $meal['proteins'] . ' '
                                                        . $meal['fats'] . ' ' . $meal['carbohydrates'] . ' ' . $meal['calories'] ?>)
                                                </div>
                                                <?php if(!empty($meal['description'])): ?>
                                                    <div><?php echo $meal['description']; ?></div>
                                                <?php endif;?>
                                                <?php if(!empty($meal['ingredients'])):
                                                    foreach($meal['ingredients'] as $ingredient):?>
                                                        <div><?php echo $ingredient['name']; ?> (БЖУК - <?php echo $ingredient['proteins'] . ' '
                                                                . $ingredient['fats'] . ' ' . $ingredient['carbohydrates'] . ' ' . $ingredient['calories'] ?>)
                                                        </div>
                                                    <?php endforeach;
                                                    unset($ingredient);
                                                endif;
                                            //endforeach;
                                            //unset($meal);
                                        endif;?>
                                    </div>
                                </div>
                            <?php endforeach;
                            unset($cm_ingestion);
                        endif;
                    endforeach;
                    unset($cm);
                else: ?>
                    <h3 class="info">Информация не найдена</h3>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php include_once('./app_fold/views/course/user_course/page_part/footer.php');?>