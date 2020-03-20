<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="statistics_container">
    <?php if(!empty($courses_statistics) and !empty($users_statistics)): ?>
        <div class="stat_content sc_general" style="background: url(<?php echo $course['image']; ?>) top no-repeat; background-size: cover;">
            <div class="stat_h">Статистика</div>
            <div class="stat_subh">с <?php echo $courses_statistics['first_date']; ?></div>
            <div class="stat_general_data">
                <div class="sgd_item">
                    <div class="sgd_icon"><i class="fas fa-users"></i></div>
                    <div class="sgd_data"><?php echo $users_statistics['count_users']; ?></div>
                    <div class="sgd_caption">пользователей</div>
                </div>
                <div class="sgd_item">
                    <div class="sgd_icon"><i class="fas fa-running"></i></div>
                    <div class="sgd_data"><?php echo $courses_statistics['count_users']; ?></div>
                    <div class="sgd_caption">участников</div>
                </div>
                <div class="sgd_item">
                    <div class="sgd_icon"><i class="fas fa-check"></i></div>
                    <div class="sgd_data"><?php echo $courses_statistics['courses_completion']; ?></div>
                    <div class="sgd_caption">пройденно</div>
                </div>
                <div class="sgd_item">
                    <div class="sgd_icon"><i class="fas fa-percent"></i></div>
                    <div class="sgd_data"><?php echo $courses_statistics['pass_percentage']; ?></div>
                    <div class="sgd_caption">прохождения</div>
                </div>
                <div class="sgd_item">
                    <div class="sgd_icon"><i class="far fa-clock"></i></div>
                    <div class="sgd_data"><?php echo $courses_statistics['progress_time']; ?></div>
                    <div class="sgd_caption">часов</div>
                </div>
                <div class="sgd_item">
                    <div class="sgd_icon"><i class="fas fa-coins"></i><!--<i class="fas fa-money-bill"></i>--></div>
                    <div class="sgd_data"><?php echo $courses_statistics['count_price']; ?></div>
                    <div class="sgd_caption">рублей</div>
                </div>
            </div>
        </div>
        <div class="stat_content sc_users">
            <div class="stat_h">Последние зарегистрированные</div>
            <div class="admin_page">
                <?php if(!empty($users_statistics['last_users'])): ?>
                    <?php foreach($users_statistics['last_users'] as $key => $u):
                        if($u['user_type'] == 1){
                            $user_type = 'user';
                        }
                        elseif($u['user_type'] == 2){
                            $user_type = 'coach';
                        }
                        elseif($u['user_type'] == 3){
                            $user_type = 'admin';
                        }?>
                        <?php include('./app_fold/views/user/users_item.php'); ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
        <div class="stat_content sc_data"></div>
    <?php endif; ?>
</div>