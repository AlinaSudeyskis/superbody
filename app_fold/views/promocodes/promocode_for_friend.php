<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php if(!empty($pc_for_friend) and $pc_for_friend['blocked'] == 0 and !empty($pc_for_friend['user_code'])):?>
    <div class="content_block new_content_block notification_block" style="height: 99%;">
        <div class="content_block_h parent">
            <h3><?php echo $pc_for_friend['name']; ?></h3>
            <div class="content_block_h_buts">
                <div class="content_block_h_slide kurs_slide"></div>
                <div class="content_block_h_close"></div>
            </div>
        </div>
        <div class="ff_promocode">
            <div class="generated_code" id="ff-promocode"><?php echo $pc_for_friend['user_code']; ?></div>
            <h3 class="info"><?php echo $pc_for_friend['description']; ?> <?php echo $pc_for_friend['discount']; ?><?php echo $pc_for_friend['dt_unit']; ?></h3>
            <div class="kurs_block_val">
                <input type="button" id="bt-copy" value="Скопировать" class="full_photo_comm_reset" style="float: none;" onclick="copyToClipboard('#ff-promocode', '#bt-copy')"/>
            </div>
        </div>
    </div>
    <script>
        function copyToClipboard(element, but) {
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val($(element).html()).select();
            document.execCommand("copy");
            $temp.remove();
            // Блок информации
            var block_message = $('#block-message');
            block_message.html('Промокод скопирован.');
            block_message.addClass('show');
            if (block_message.length > 0 && block_message.hasClass('show')) {
                var parent = block_message.parent();
                block_message.css("left", ((parent.outerWidth() / 2) - (block_message.outerWidth() / 2)));
                setTimeout(function(){
                    block_message.show();
                    block_message.animate({"top": "+=40px"}, "slow");
                },500);
                setTimeout(function(){block_message.animate({"top": "-=40px"}, "slow")},10000);
                setTimeout(function(){block_message.hide()},10500);
            }
        }
    </script>
<?php endif; ?>