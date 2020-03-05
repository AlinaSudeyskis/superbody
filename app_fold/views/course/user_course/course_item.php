<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php
/*<div class="my_kurs_item parent">
    <div class="my_kurs_img">
        <a href="">
            <?php if (!empty($course['image'])) :?>
                <img src="<?php echo $course['image'];?>" alt=""/>
            <?php endif;?>
        </a>
    </div>
    <div class="my_kurs_cont">
        <div class="my_kurs_top parent">
            <div class="my_kurs_name"><a href="/profile/course/<?php echo $course['id']?>"><?php echo $course['name'];?></a></div>
            <div class="my_kurs_but parent">
                <a href="/course/<?php echo $course['course_id']?>" class="my_kurs_link">Узнать больше</a>
                //<a href="#" class="my_kurs_link disabled">Расписание</a>
                <?php if($course['category'] == 'workout' and $page_submenu != 'finished'): ?>
                    <div class="my_kurs_radio_wrap">
                        <input type="checkbox" name="cb_calendar_workout[]" class="anketa_form_radio calendar_course" value="<?php echo $course['id']; ?>" id="calendar_workout<?php echo $course['id']; ?>" <?php if($course['display'] == 1):?>checked="checked"<?php endif;?>>
                        <label for="calendar_workout<?php echo $course['id']; ?>">Календарь</label>
                    </div>
                <?php elseif($course['category'] == 'nutrition' and $page_submenu != 'finished'): ?>
                    <div class="my_kurs_radio_wrap">
                        <input type="radio" name="r_calendar_nutrition" class="anketa_form_radio" value="<?php echo $course['id']; ?>" id="calendar_nutrition<?php echo $course['id']; ?>" <?php if($course['display'] == 1):?>checked="checked"<?php endif;?>>
                        <label for="calendar_nutrition<?php echo $course['id']; ?>">Календарь</label>
                    </div>
                <?php endif;?>
            </div>
        </div>
        <div class="my_kurs_bot parent">
            <div class="my_kurs_tren_h"><?php echo $blocked; ?></div>
        </div>
        <div class="my_kurs_mid"><?php echo $course['description']; ?></div>
        <div class="my_kurs_bot parent">
            <?php if ($course['coaches']) :?>
                <div class="my_kurs_tren_h">Тренер</div>
                <div class="my_kurs_tren_names">
                    <?php $last_coach = count($course['coaches']);
                    foreach ($course['coaches'] as $key => $coach) :?>
                        <a href="/profile/<?php echo $coach['id'];?>"><?php echo $coach['name'];?></a>
                        <?php if ($last_coach != ($key + 1)): echo ','; endif;?>
                    <?php endforeach;
                    unset($coach);?>
                </div>
            <?php endif;?>
        </div>
    </div>
</div>*/
?>


<div class="orders_container">
    <?php if(!empty($course['image'])): ?>
        <div class="order_image"><img src="<?php echo $course['image']; ?>" alt="" /></div>
    <?php endif; ?>
    <div class="order_info_wrap">
        <div class="oi_title"><?php echo $course['name']; ?></div>
        <div class="oi_subtitle"><?php echo $course['description']; ?></div>
        <div class="oi_info">
            <?php if (!empty($course['coaches'])): ?>
                <div class="oi_i_coach">
                    <div class="oi_i_title">Тренер</div>
                    <div class="tren_block tren_order">
                        <?php $coach = $course['coaches'][0]; ?>
                        <div class="tren_item">
                            <div class="tren_ava">
                                <a href="/profile/<?php echo $coach['id']?>">
                                    <img src="<?php if (!empty($coach['image'])): echo $coach['image']; endif;?>" alt="">
                                </a>
                            </div>
                            <a href="/profile/<?php echo $coach['id']?>" class="tren_link">
                                <span class="tren_name"><?php echo $coach['name']?></span>
                                <span class="tren_surname"><?php echo $coach['surname']?></span>
                            </a>
                            <div class="tren_desk"><?php echo $coach['special']?></div>
                        </div>
                        <?php unset($coach); ?>
                    </div>
                </div>
            <?php endif;?>
            <div class="oi_i_details">
                <div class="oi_i_title">Информация о заказе</div>
                <div class="oi_i_s_details_wrap">
                    <div class="oi_i_s_details"><i class="fa fa-chevron-right" aria-hidden="true"></i>№ <?php echo $course['order']['id']; ?></div>
                    <div class="oi_i_s_details"><i class="fa fa-chevron-right" aria-hidden="true"></i><?php echo $course['order']['date']; ?></div>
                    <div class="oi_i_s_details"><i class="fa fa-chevron-right" aria-hidden="true"></i>Сумма: <?php echo $course['order']['total_amount']; ?> руб.</div>
                    <?php if(!empty($course['order']['discount'])): ?>
                        <div class="oi_i_s_details"><i class="fa fa-chevron-right" aria-hidden="true"></i>Скидка: <?php echo $course['order']['discount']; ?></div>
                    <?php endif; ?>
                    <?php if($course['order']['payment_status_eng'] != 'free'): ?>
                        <div class="oi_i_s_details"><i class="fa fa-chevron-right" aria-hidden="true"></i><?php echo $course['order']['payment']; ?></div>
                    <?php endif; ?>
                    <div class="oi_i_s_details"><i class="fa fa-chevron-right" aria-hidden="true"></i><?php echo $course['order']['user_email']; ?></div>
                </div>
            </div>
            <div class="oi_i_status">
                <div class="oi_i_title">Статус</div>
                <div class="oi_i_details_wrap">
                    <?php $s_active = ($course['order']['payment_status_eng'] == 'succeeded' or $course['order']['payment_status_eng'] == 'free') ? 'active' : ''; ?>
                    <div class="oi_d_status <?php echo $s_active; ?>"><?php echo $course['order']['payment_status']; ?></div>
                    <?php if(empty($outsider)): ?>
                        <div class="oi_d_buy">
                            <?php if(empty($course['order']['payment_status_eng']) or $course['order']['payment_status_eng'] == 'pending' or $course['order']['payment_status_eng'] == 'not_paid' or
                                $course['order']['payment_status_eng'] == 'canceled' or $course['order']['payment_status_eng'] == 'revoke_permission'): ?>
                                <a href="#" class="buy_course" data-cid="<?php echo $course['course_id']; ?>" data-oid="<?php echo $course['order']['id']; ?>" data-ucid="<?php echo $course['id']; ?>">Оплатить</a>
                            <?php else: ?>
                                <span>Оплатить</span>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                    <div class="oi_d_prog">
                        <div class="calendar_prof_item">
                            <div class="calendar_prof_end">
                                <span class="calendar_prof_end_line" style="width: <?php echo $course['percent_done']; ?>%; background-color: rgb(67,227,267);"></span>
                                <span class="calendar_prof_end_val"><?php echo $course['percent_done']; ?>%</span>
                            </div>
                        </div>
                    </div>
                    <?php if(empty($outsider)): ?>
                        <div class="oi_d_link">
                            <?php $calendar_active = ($course['display'] == 0) ? 'active' : ''; ?>
                            <?php if(($course['category'] == 'workout' or $course['category'] == 'nutrition') and $page_submenu != 'finished'): ?>
                                <a href="#" class="calendar_course <?php echo $calendar_active; ?>" data-crsid="<?php echo $course['id']; ?>">
                                    <?php if($course['display'] == 0): ?>
                                        Добавить в календарь
                                    <?php else: ?>
                                        Удалить из календаря
                                    <?php endif; ?>
                                </a>
                            <?php endif;?>
                        </div>
                    <?php endif; ?>
                    <div class="oi_d_link">
                        <?php if(!empty($course['id']) and empty($outsider)): ?>
                            <a href="/profile/course/<?php echo $course['id']; ?>">Подробнее</a>
                        <?php elseif(!empty($outsider)): ?>
                            <a href="/administration/order/<?php echo $course['order']['id']; ?>">Подробнее</a>
                        <?php else: ?>
                            <span>Продолжить</span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
