<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php if(!empty($video) and empty($error)): ?>
<div class="video_page">
    <?php echo $video; ?>
</div>
<script>
    $(document).ready(function () {
        var pop_up_video = $('body'),
            viewed = false;
        pop_up_video.find('#wo-instruction').hide();

        pop_up_video.find('.instruction').on('click', function () {
            if ($(this).html() === 'Тренировка') {
                $(this).html('Инструктаж');
            } else {
                $(this).html('Тренировка');

                if ($('#vimeo-player-1').length === 1) {
                    instPlayer = new Vimeo.Player('vimeo-player-1', options);
                }
            }
            pop_up_video.find('#wo-video').toggle();
            pop_up_video.find('#wo-instruction').toggle();
        });

        pop_up_video.find('#wo-done').on('click', function () {
            var wo_but = $(this).find('#bt-workout-done'),
                wo_id = $(this).find('#wo-id').val();

            $.ajax({
                url: '/viewed/video',
                type: 'post',
                data: {
                    woid: wo_id
                },
                complete: function (result) {
                    if (result.responseText === 'true') {
                        viewed = true;
                        wo_but.addClass('done');
                        wo_but.val('Выполнено');
                    }
                }
            });
        });
    });
</script>
<?php else: ?>
    <?php echo $error; ?>
<?php endif;?>
