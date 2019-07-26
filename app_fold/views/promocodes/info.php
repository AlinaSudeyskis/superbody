<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="promo_block_info">
    <div class="pcbi_h"><?php echo $pc_info['name']; ?></div>
    <div class="pcbi_sh"><?php echo $pc_info['desc']; ?></div>
    <div class="pcbi_details_wrap">
        <div class="pcbi_details">
            <div class="pcbi_detail_h">Скидка</div>
            <div class="pcbi_detail_sh"><?php echo $pc_info['disc_type']; ?></div>
            <div class="pcbi_detail_val"><?php echo $pc_info['discount']; ?></div>
        </div>
        <?php if($pc_info['rel_percent'] > 0): ?>
            <div class="pcbi_details">
                <div class="pcbi_detail_h">MAX</div>
                <div class="pcbi_detail_sh">%</div>
                <div class="pcbi_detail_val"><?php echo $pc_info['rel_percent']; ?></div>
            </div>
        <?php endif; ?>
        <div class="pcbi_details">
            <div class="pcbi_detail_h">Период</div>
            <div class="pcbi_detail_sh">действия</div>
            <div class="pcbi_detail_val"><?php echo $pc_info['period']; ?></div>
        </div>
        <div class="pcbi_details">
            <div class="pcbi_detail_h">Количество</div>
            <div class="pcbi_detail_sh">использований</div>
            <div class="pcbi_detail_val"><?php echo $pc_info['use_amount']; ?></div>
        </div>
        <div class="pcbi_details">
            <div class="pcbi_detail_h">Действует</div>
            <div class="pcbi_detail_sh">на</div>
            <div class="pcbi_detail_val"><?php echo $pc_info['type']; ?></div>
        </div>
    </div>
</div>
