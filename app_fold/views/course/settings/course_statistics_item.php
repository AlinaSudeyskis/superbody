<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="statistics_container">
    <?php if(!empty($statistics)): ?>
        <div class="stat_content sc_general" style="background: url(<?php echo $course['image']; ?>) top no-repeat; background-size: cover;">
            <div class="stat_h">Статистика</div>
            <?php if(!empty($statistics['first_date'])):?>
                <div class="stat_subh">по курсу с <?php echo $statistics['first_date']; ?></div>
            <?php endif; ?>
            <div class="stat_general_data">
                <div class="sgd_item">
                    <div class="sgd_icon"><i class="fas fa-users"></i></div>
                    <div class="sgd_data"><?php echo $statistics['count_users']; ?></div>
                    <div class="sgd_caption">участников</div>
                </div>
                <div class="sgd_item">
                    <div class="sgd_icon"><i class="fas fa-check"></i></div>
                    <div class="sgd_data"><?php echo $statistics['course_completion']; ?></div>
                    <div class="sgd_caption">пройденно</div>
                </div>
                <div class="sgd_item">
                    <div class="sgd_icon"><i class="fas fa-percent"></i></div>
                    <div class="sgd_data"><?php echo $statistics['pass_percentage']; ?></div>
                    <div class="sgd_caption">прохождения</div>
                </div>
                <div class="sgd_item">
                    <div class="sgd_icon"><i class="far fa-clock"></i></div>
                    <div class="sgd_data"><?php echo $statistics['progress_time']; ?></div>
                    <div class="sgd_caption"><?php echo $statistics['progress_time_val']; ?></div>
                </div>
                <div class="sgd_item">
                    <div class="sgd_icon"><i class="fas fa-coins"></i><!--<i class="fas fa-money-bill"></i>--></div>
                    <div class="sgd_data"><?php echo $statistics['count_price']; ?></div>
                    <div class="sgd_caption">рублей</div>
                </div>
            </div>
        </div>
        <div class="stat_content sc_users">
            <div class="stat_h">Последние купившие</div>
            <div class="admin_page">
                <?php if(!empty($statistics['bought_users'])): ?>
                    <?php foreach($statistics['bought_users'] as $bought_user_data): ?>
                        <div class="tren_prof_page_img_wrap">
                            <div class="tren_prof_page_img">
                                <?php $image = (!empty($bought_user_data['user_image']))
                                    ? $bought_user_data['user_image']
                                    : $bought_user_data['user_soc_image'];
                                $image = (empty($image)) ? '/img/no_img.png' : $image;
                                if($bought_user_data['user_type'] == 1){
                                    $user_type = 'user';
                                }
                                elseif($bought_user_data['user_type'] == 2){
                                    $user_type = 'coach';
                                }
                                elseif($bought_user_data['user_type'] == 3){
                                    $user_type = 'admin';
                                }
                                ?>
                                <a href="/administration/<?php echo $user_type; ?>/<?php echo $bought_user_data['user_id']; ?>"><img src="<?php echo $image; ?>" alt=""></a>
                            </div>
                            <div class="tren_prof_page_name"><?php echo $bought_user_data['split_name']['name']; ?></div>
                            <div class="tren_prof_page_surname"><?php echo $bought_user_data['split_name']['surname']; ?></div>
                            <div class="tren_prof_page_soc"></div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
        <div class="stat_content sc_data"></div>
    <?php endif; ?>
</div>