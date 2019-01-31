<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="content_block new_content_block">
    <div class="content_block_h parent">
        <h3>Активность клиентов</h3>
        <div class="content_block_h_buts">
            <div class="content_block_h_slide kurs_slide"></div>
            <div class="content_block_h_close"></div>
        </div>
    </div>
    <div class="kurs_block_val">
        <div class="tren_client_row parent">
            <?php if (!empty($clients)) :
                foreach ($clients as $client) :?>
                    <div class="tren_client_col">
                        <div class="tren_client_wrap parent">
                            <div class="tren_client_img_wrap">
                                <div class="tren_client_img">
                                    <?php if (!empty($client['image'])):?>
                                        <a href="/profile/<?php echo $client['id'];?>"><img src="<?php echo $client['image'];?>" alt=""></a>
                                    <?php endif;?>
                                </div>
                                <div class="tren_client_name_all">
                                    <a href="/profile/<?php echo $client['id'];?>" class="tren_client_neme_wrap">
                                        <div class="tren_client_neme"><?php echo $client['split_name']['name'];?></div>
                                        <div class="tren_client_surname"><?php echo $client['split_name']['surname'];?></div>
                                    </a>
                                </div>
                                <div class="tren_client_but"><!--
                                                <a href=""><i class="fa fa-eye" aria-hidden="true"></i></a>
                                                <a href=""><i class="fa fa-reply" aria-hidden="true"></i></a>-->
                                </div>
                            </div>
                            <div class="tren_client_cont">
                                <div class="tren_client_graf"><a href="/client/activity/<?php echo $client['id'];?>">Графики веса и антропометрических данных</a></div>
                                <div class="tren_client_info">
                                    <div class="tren_client_line"><span><?php echo $client['missed_workouts'];?></div>
                                    <div class="tren_client_line">Последнее пропущенное занятие <span><?php echo $client['missed_date'];?></span></div>
                                    <div class="tren_client_line"><span><?php echo $client['workouts_done'];?>%</span> прохождения курса.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach;
                unset($client);?>
            <?php else: ?>
                <h3 class="info">Информация не найдена</h3>
            <?php endif;?>
        </div>
        <?php if(!empty($number_clients)):?>
            <div class="tren_client_count"><?php echo $number_clients;?></div>
        <?php endif; ?>
    </div>
</div>