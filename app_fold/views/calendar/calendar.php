<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="content_block calendar_content_block">
    <div class="content_block_h_buts">
        <div class="content_block_h_slide calendar_slide"></div>
        <div class="content_block_h_close"></div>
    </div>
    <div id="calendar" class="calendar"></div>
</div>

<script>
    /* календарь */

    $(document).ready(function() {

        $('#calendar').fullCalendar({
            locale: 'ru',
            timeFormat: 'H:mm',
            height: 620,
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,basicWeek,basicDay'
            },
            navLinks: true, // can click day/week names to navigate views
            editable: true,
            eventLimit: true, // allow "more" link when too many events
            events: [
                <?php if (!empty($events)) :
                $last_element = count($events);
                foreach ($events as $key => $event) :?>
                {
                    start       : '<?php echo $event['start'];?>',
                    end         : '<?php echo $event['end'];?>',
                    <?php if (!empty($event['title'])) :?>
                        title  : '<?php echo $event['title'];?>',
                    <?php endif;
                    if (!empty($event['id'])) :?>
                        startParam  : '<?php echo $event['id'];?>',
                    <?php endif;
                    if (!empty($event['workout_id'])) :?>
                        endParam  : '<?php echo $event['workout_id'];?>',
                    <?php endif;
                    if (!empty($event['pause']) and $event['pause'] === true): ?>
                        overlap   : false,
                        rendering : 'background',
                        color     : 'rgba(255, 159, 137, 0.5)'
                    <?php else: ?>
                        color: '<?php echo $event['color']; ?>'
                    <?php endif; ?>
                }
                <?php if ($last_element != $key) :?>
                ,
                <?php endif;
                endforeach;
                endif;?>
            ],
            eventClick: function(calEvent, jsEvent, view) {
                if (calEvent.startParam != "") {
                    $.ajax({
                        url: '/show/video',
                        type: 'post',
                        dataType: 'json',
                        data: {
                            start_param: calEvent.startParam,
                            end_param: calEvent.endParam
                        },
                        complete: function (result) {
                            var data = jQuery.parseJSON(result.responseText);
                            if (!data.error) {
                                $("#pop-up_video").html(data.video);
                                $("#pop-up_video").append(data.i_video);
                                $("#pop-up_video").append(data.i_a);
                                $("#pop-up_video").append(data.description);
                                $("#pop-up_video").append(data.done);
                                if(getInternetExplorerVersion()==-1) {
                                    if (data.player == 1) {
                                        $("#myvid").each(function () {
                                            new InitPxVideo({
                                                "videoId": this,
                                                "captionsOnDefault": false,
                                                "seekInterval": 20,
                                                "videoTitle": "Promo",
                                                "debug": true,
                                                "woid": $("#wo-id").val()
                                            });
                                        });
                                    }
                                    var options = {
                                        width: 640,
                                        loop: true
                                    };
                                    playerTwoPlayer = new Vimeo.Player('vimeo-player-0', options);

                                    if ($('#vimeo-player-1').length == 1)
                                    {
                                        if (data.i_player == 1) {
                                            $("#ivid").each(function () {
                                                new InitPxVideo({
                                                    "videoId": this,
                                                    "captionsOnDefault": false,
                                                    "seekInterval": 20,
                                                    "videoTitle": "Promo",
                                                    "debug": true,
                                                    "woid": $("#wo-id").val()
                                                });
                                            });
                                        }
                                        playerTwoPlayer = new Vimeo.Player('vimeo-player-1', options);
                                    }
                                }
                                pop_up_def($("#pop-up_video"));

                                $('#bt-workout-done').on('click', function(){
                                    $.ajax({
                                        url: '/viewed/video',
                                        type: 'post',
                                        data: {
                                            woid: calEvent.endParam
                                        },
                                        complete: function (result) {
                                            if (result.responseText == 'true') {
                                                $('#wo-done').html("<div id='wo-done'><div class='workout_form_but done'>Выполнено</div></div>");
                                            }
                                        }
                                    });
                                });
                            }
                        }
                    });
                }
            }
        });

    });
</script>
