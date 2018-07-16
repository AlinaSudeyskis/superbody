<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if(!empty($system_message['course_menu']) and !empty($system_message['course'])):
    $course_menu = $system_message['course_menu'];
    $course      = $system_message['course'];?>
    <tr style="margin:0; padding:0">
        <td style="width:100%; margin:0; padding-top:10px; padding-right:10px; padding-bottom:10px; padding-left:10px;">
            <table border="0" cellpadding="0" cellspacing="0" style="width:100%; background-color:#ffffff; border-bottom: 3px solid #cdcdcd;">
                <tr style="width:100%; margin:0; padding:0;">
                    <td style="width:100%; margin:0; padding:0;" colspan="2">
                        <table border="0" cellpadding="0" cellspacing="0" style="width:100%; margin:0; padding:0; border-bottom: 3px solid #cdcdcd; padding-right: 70px;">
                            <tr style="width:100%; margin:0; padding:0;">
                                <td style="width:100%; margin:0; padding-top:10px; padding-right:15px; padding-bottom:10px; padding-left:15px;">
                                    <?php echo $course['name']; ?>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr style="margin:0; padding:0; width: 100%;">
                    <td style="margin:0; padding:0; padding-top:10px; width: 39%; text-align: center; border-bottom: 1px solid #cdcdcd;">
                        <table border="0" cellpadding="0" cellspacing="0" style="width:100%; margin:0; padding:0; text-align: center">
                            <?php if(!empty($course['image'])): ?>
                                <tr style="margin:0; padding:0; width: 100%;">
                                    <td style="margin:0; padding-top:10px; padding-right:10px; padding-bottom:10px; padding-left:10px; width: 100%;">
                                        <img src="https://superbody.pro<?php echo $course['image']; ?>" alt="" style="border:none; width: 100%;"/></td></tr>
                            <?php endif; ?>
                            <tr style="margin:0; padding:0; width: 100%;">
                                <td style="margin:0; padding:0; height: 50px;">
                                    <a href="https://superbody.pro/profile/course/<?php echo $course['id']; ?>"
                                       style="width:100%; text-decoration: none; text-align:center; text-transform: uppercase;
                                                            background-color: #2acaf2; border-radius: 5px; padding: 10px 15px; font-size: 11px; color: #FFFFFF; font-weight: 600;"
                                    >Перейти к курсу</a>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td style="margin:0; padding-top:10px; padding-right:10px; padding-bottom:10px; padding-left:10px; width:60%; vertical-align: top; border-bottom: 1px solid #cdcdcd;">
                        <table border="0" cellpadding="0" cellspacing="0" style="width:100%; margin:0; padding:0;">
                            <tr style="margin:0; padding:0; width: 100%;">
                                <td style="margin:0; padding:0; padding-top:10px; text-transform: uppercase; font-size:12px;"><?php echo $course['description']; ?></td>
                            </tr>
                            <tr style="margin:0; padding:0; width: 100%;">
                                <td style="margin:0; padding:0; width: 100%; padding-top:15px; font-size: 14px;">
                                    <span style="color: #595959;">Начало курса: </span><?php echo $course['date_start']; ?></td>
                            </tr>
                            <tr style="margin:0; padding:0; width: 100%;">
                                <td style="margin:0; padding:0; width: 100%; padding-top:5px; font-size: 14px;">
                                    <span style="color: #595959;">Окончание курса: </span><?php echo $course['date_end']; ?></td>
                            </tr>
                            <tr style="margin:0; padding:0; width: 100%;">
                                <td style="margin:0; padding:0; width: 100%; padding-top:5px; font-size: 14px;">
                                    <span style="color: #595959;">Пройдено курса: </span><?php echo $course['workouts_passed']; ?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr style="margin:0; padding:0;">
                    <td style="margin:0; padding:0;" colspan="2">
                        <?php if(!empty($course_menu)):
                            $days = array(1 => 'Понедельник', 2 => 'Вторник', 3 => 'Среда', 4 => 'Четверг', 5 => 'Пятница', 6 => 'Суббота', 7 => 'Воскресенье');
                            ?>
                            <table border="0" cellpadding="0" cellspacing="0" style="width:100%; margin:0; padding:0;">
                                <?php foreach($course_menu as $cm_date => $cm):?>
                                    <tr>
                                        <td style="vertical-align: top; width: 60%; border-bottom: 1px solid #cdcdcd; padding-left: 30px; padding-right: 0; padding-top: 15px; padding-bottom: 15px;">
                                            <table border="0" cellpadding="0" cellspacing="0" style="width:100%; margin:0; padding:0;">
                                                <tr>
                                                    <td style="font-weight: 600; padding-top:15px; font-size: 14px;" colspan="5">
                                                        <?php $tmp_date = new DateTime($cm_date);
                                                        $num_day = ($tmp_date !== false) ? $tmp_date->format('N') : false;
                                                        $day = ($num_day !== false and array_key_exists($num_day, $days)) ? $days[$num_day] : false;
                                                        $date = $tmp_date->format('d.m.Y');
                                                        echo $day; ?>
                                                        <span style="color: #595959; font-size: 11px; font-weight: normal;"><?php echo '('.$date.')'; ?></span>
                                                    </td>
                                                </tr>
                                                <?php $weight = 0;
                                                $proteins = 0;
                                                $fats = 0;
                                                $carbohydrates = 0;
                                                $calories = 0;
                                                $meal_image = '';
                                                $meal_images = '';
                                                if(!empty($cm)):
                                                    foreach($cm as $cm_ingestion): ?>
                                                        <tr>
                                                            <td colspan="5" style="padding-top: 10px;">
                                                                <table border="0" cellpadding="0" cellspacing="0" style="width:100%; margin:0; padding:0; font-size: 13px;">
                                                                    <tr>
                                                                        <td style="vertical-align: top; width:25%;"><?php echo $cm_ingestion['name']; ?></td>
                                                                        <td style="width:74%;">
                                                                            <?php if(!empty($cm_ingestion['meal_category'])):
                                                                                foreach($cm_ingestion['meal_category'] as $ml_type):?>
                                                                                    <?php if(!empty($ml_type['meal'])):
                                                                                        $meal = $ml_type['meal'];
                                                                                        $meal_image = (!empty($meal['image']) and empty($meal_image)) ? $meal['image'] : $meal_image;
                                                                                        $meal_images = (!empty($meal['images']) and empty($meal_images)) ? $meal['images_path'] . '/' .current($meal['images']) : $meal_images;
                                                                                        ?>
                                                                                        <table border="0" cellpadding="0" cellspacing="0" style="width:100%; margin:0; padding:0; font-size: 13px; padding-bottom: 10px;">
                                                                                            <tr>
                                                                                                <td><b><?php echo $meal['name']; ?></b></td>
                                                                                            </tr>

                                                                                            <?php if(!empty($meal['description'])): ?>
                                                                                                <tr><td><?php echo $meal['description']; ?></td></tr>
                                                                                            <?php endif;?>
                                                                                        </table>
                                                                                        <?php  $weight += $meal['weight'];
                                                                                        $proteins += $meal['proteins'];
                                                                                        $fats += $meal['fats'];
                                                                                        $carbohydrates += $meal['carbohydrates'];
                                                                                        $calories += $meal['calories'];
                                                                                    endif;?>
                                                                                <?php endforeach;
                                                                                unset($ml_type);
                                                                            endif;?>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach;
                                                    unset($cm_ingestion);
                                                endif;?>
                                                <tr>
                                                    <td style="width:20%; padding-top: 10px;">
                                                        <table border="0" cellpadding="0" cellspacing="0" style="width:100%; margin:0; padding:0; text-align: center; font-size: 13px;">
                                                            <tr><td style="color: #ffffff; background-color: #72d0f4; border-right: 1px solid #ffffff; padding: 4px 10px;">Вес</td></tr>
                                                            <tr><td style="color: #696969; font-weight: 300;"><?php echo $weight; ?></td></tr>
                                                        </table>
                                                    </td>
                                                    <td style="width:20%; padding-top: 10px;">
                                                        <table border="0" cellpadding="0" cellspacing="0" style="width:100%; margin:0; padding:0; text-align: center; font-size: 13px;">
                                                            <tr><td style="color: #ffffff; background-color: #72d0f4; border-right: 1px solid #ffffff; padding: 4px 10px;">Белки</td></tr>
                                                            <tr><td style="color: #696969; font-weight: 300;"><?php echo $proteins; ?></td></tr>
                                                        </table>
                                                    </td>
                                                    <td style="width:20%; padding-top: 10px;">
                                                        <table border="0" cellpadding="0" cellspacing="0" style="width:100%; margin:0; padding:0; text-align: center; font-size: 13px;">
                                                            <tr><td style="color: #ffffff; background-color: #72d0f4; border-right: 1px solid #ffffff; padding: 4px 10px;">Жиры</td></tr>
                                                            <tr><td style="color: #696969; font-weight: 300;"><?php echo $fats; ?></td></tr>
                                                        </table>
                                                    </td>
                                                    <td style="width:20%; padding-top: 10px;">
                                                        <table border="0" cellpadding="0" cellspacing="0" style="width:100%; margin:0; padding:0; text-align: center; font-size: 13px;">
                                                            <tr><td style="color: #ffffff; background-color: #72d0f4; border-right: 1px solid #ffffff; padding: 4px 10px;">Углеводы</td></tr>
                                                            <tr><td style="color: #696969; font-weight: 300;"><?php echo $carbohydrates; ?></td></tr>
                                                        </table>
                                                    </td>
                                                    <td style="width:20%; padding-top: 10px;">
                                                        <table border="0" cellpadding="0" cellspacing="0" style="width:100%; margin:0; padding:0; text-align: center; font-size: 13px;">
                                                            <tr><td style="color: #ffffff; background-color: #72d0f4; border-right: 1px solid #ffffff; padding: 4px 10px;">Калории</td></tr>
                                                            <tr><td style="color: #696969; font-weight: 300;"><?php echo $calories; ?></td></tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                        <td style="vertical-align: top; padding: 15px; border-bottom: 1px solid #cdcdcd; padding-right:30px; padding-top:30px;">
                                            <table border="0" cellpadding="0" cellspacing="0" style="width:100%; margin:0; padding:0; text-align: center;">
                                                <tr>
                                                    <td>
                                                        <?php if(!empty($meal_image)):?>
                                                            <img src="http://superbody.pro<?php echo $meal_image; ?>" alt="" border="0" width="100%" />
                                                        <?php elseif(!empty($meal_images)): ?>
                                                            <img src="http://superbody.pro<?php echo $meal_images; ?>" alt="" border="0" width="100%" />
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                                <tr style="margin:0; padding:0; width: 100%;">
                                                    <td style="margin:0; padding:0; height: 50px;">
                                                        <a href="https://superbody.pro/profile/course/<?php echo $course['id']; ?>/menu"
                                                           style="width:100%; text-decoration: none; text-align:center; text-transform: uppercase;
                                                                            background-color: #2acaf2; border-radius: 5px; padding: 10px 15px; font-size: 11px; color: #FFFFFF; font-weight: 600;"
                                                        >Перейти к меню</a>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                <?php endforeach;
                                unset($cm);?>
                            </table>
                        <?php endif; ?>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
<?php endif;