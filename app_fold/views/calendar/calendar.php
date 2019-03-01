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
                    constraint  : '<?php echo $event['constraint'];?>',
                    ev_bl       : <?php if($event['blocked'] == 'true') : echo 'true'; else: echo 'false'; endif; ?>,
                    <?php if (!empty($event['title'])) :?>
                        title  : '<?php echo $event['title'];?>',
                    <?php endif;
                    if (!empty($event['id'])) :?>
                        startParam  : '<?php echo $event['id'];?>',
                    <?php endif;
                    if (!empty($event['ml_id'])) :?>
                        ml_id  : '<?php echo $event['ml_id'];?>',
                    <?php endif;
                    if (!empty($event['day'])) :?>
                        day  : '<?php echo $event['day'];?>',
                    <?php endif;
                    if (!empty($event['ingestion'])) :?>
                        ingestion  : '<?php echo $event['ingestion'];?>',
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
                }<?php if ($last_element != $key) :?>,<?php endif; ?>
                <?php if($event['missed'] == 'not_missed'): // and !empty($event['instruction_id'])?>
                {
                    start      : '<?php echo $event['start'];?>',
                    end        : '<?php echo $event['end'];?>',
                    constraint : 'instruction',
                    title      : 'Инструктаж',
                    startParam : '<?php echo $event['instruction_id']; ?>',
                    endParam   : '<?php echo $event['workout_id']; ?>',
                    color      : 'rgba(187, 187, 187, .7)'
                }<?php if ($last_element != $key) :?>,<?php endif; ?>
                <?php endif; ?>
                <?php endforeach;
                endif;?>
            ],
            eventClick: function(calEvent, jsEvent, view) {
                if (calEvent.constraint == "workout" && calEvent.startParam != "")
                {
                    $.ajax({
                        url: '/show/video',
                        type: 'post',
                        dataType: 'json',
                        data: {
                            start_param: calEvent.startParam,
                            end_param: calEvent.endParam
                        },
                        complete: function (result)
                        {
                            var data = jQuery.parseJSON(result.responseText);
                            if (!data.error)
                            {
                                $("#pop-up_video").html(data.video);
                                $("#pop-up_video").append(data.i_video);
                                //$("#pop-up_video").append(data.i_a);
                                $("#pop-up_video").append(data.description);
                                //$("#pop-up_video").append(data.done);
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
                                            loop: false
                                        },
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

                                    playerTwoPlayer.ready().then(function() {
                                        console.log('Ready');

                                        playerTwoPlayer.on('play', function(data){
                                            console.log('Play ' + data);

                                            playerTwoPlayer.getCurrentTime().then(function(seconds) {
                                                console.log('Current time (seconds): ' + seconds);
                                            }).catch(function(error) {
                                                console.log('Current time error: ' + error);
                                            });

                                        });
                                        playerTwoPlayer.on('pause', function(data){
                                            console.log('Pause ' + data);
                                        });
                                        playerTwoPlayer.on('ended', function(data){
                                            console.log('Video ended ' + data);
                                        });

                                        playerTwoPlayer.setCurrentTime(15.456).then(function(seconds) {
                                            // seconds = the actual time that the player seeked to
                                            console.log('Current time (seconds): ' + seconds);
                                        }).catch(function(error) {
                                            switch (error.name) {
                                                case 'RangeError':
                                                    // the time was less than 0 or greater than the video’s duration
                                                    break;

                                                default:
                                                    // some other error occurred
                                                    break;
                                            }
                                        });
                                    });

                                }
                                pop_up_home($("#pop-up_video"));
                                $.ajax({
                                    url: '/viewed/video',
                                    type: 'post',
                                    data: {
                                        woid: calEvent.endParam
                                    },
                                    complete: function(result){
                                        if (result.responseText == 'true')
                                        {
                                             calEvent.backgroundColor = 'rgba(159, 220, 39, .7)';
                                             $('#calendar').fullCalendar('updateEvent', calEvent);
                                        }
                                    }
                                });

                                /*$('#bt-workout-done').on('click', function()
                                {
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
                                });*/
                            }
                        }
                    });
                }
                else if(calEvent.constraint == "nutrition")
                {
                    var start = calEvent.start._i;
                    $.ajax({
                        url: '/showMeals',
                        type: 'post',
                        dataType: 'json',
                        data: {
                            start: start,
                            start_param: calEvent.startParam,
                            ml_id: calEvent.ml_id,
                            day: calEvent.day,
                            ingestion: calEvent.ingestion
                        },
                        complete: function (result) {
                            var up_meal = $("#pop-up_meal"),
                                data = result.responseJSON;
                            if (data && !data.error) {
                                up_meal.html(data.meals);
                                pop_up_home(up_meal);
                                //meal_slider(up_meal);
                            }

                            up_meal.on('click', '.show_meal', function(){
                                var mlid = $(this).data('mlid'),
                                    unid = $(this).data('unid'),
                                    did  = $(this).data('did'),
                                    iid  = $(this).data('iid');
                                $.ajax({
                                    url: '/showMeal',
                                    type: 'post',
                                    dataType: 'json',
                                    data: {
                                        start: start,
                                        mlid: mlid,
                                        unid: unid,
                                        did: did,
                                        iid: iid
                                    },
                                    complete: function (result) {
                                        var data = result.responseJSON;
                                        if (data && !data.error) {
                                            calEvent.ml_id = mlid;
                                            up_meal.html(data.meal);
                                            meal_slider(up_meal);
                                            pop_up_home(up_meal);
                                            up_meal.css('height','auto');
                                        }
                                    }
                                });
                            });

                            up_meal.on('click', '.return_back', function(){
                                var unid = $(this).data('unid'),
                                    did  = $(this).data('did'),
                                    iid  = $(this).data('iid'),
                                    date = $(this).data('date');
                                $.ajax({
                                    url: '/showMeals',
                                    type: 'post',
                                    dataType: 'json',
                                    data: {
                                        start: date,
                                        start_param: unid,
                                        day: did,
                                        ingestion: iid
                                    },
                                    complete: function (result) {
                                        var up_meal = $("#pop-up_meal"),
                                            data = result.responseJSON;
                                        if (data && !data.error) {
                                            up_meal.html(data.meals);
                                            pop_up_home(up_meal);
                                            //meal_slider(up_meal);
                                            up_meal.css('height','auto');
                                        }
                                    }
                                });
                            });

                            up_meal.on('click', '#change-meal', function(){
                                var meal_other = up_meal.find('.meal_other_wrap');
                                if(meal_other.is(':hidden'))
                                {
                                    up_meal.height(up_meal.height() + meal_other.height());
                                    meal_other.show();
                                }
                                else
                                {
                                    up_meal.height(up_meal.height() - meal_other.height());
                                    meal_other.hide();
                                }
                            });

                            up_meal.on('click', '.meal_other_link', function(){
                                var mlid = $(this).data('mlid'),
                                    unid = $(this).data('unid'),
                                    did  = $(this).data('did'),
                                    iid  = $(this).data('iid');
                                $.ajax({
                                    url: '/selectMeal',
                                    type: 'post',
                                    dataType: 'json',
                                    data: {
                                        start: start,
                                        mlid: mlid,
                                        unid: unid,
                                        did: did,
                                        iid: iid
                                    },
                                    complete: function (result) {
                                        var data = result.responseJSON;
                                        if (data && !data.error) {
                                            calEvent.ml_id = mlid;
                                            up_meal.html(data.meal);
                                            pop_up_home(up_meal);
                                            meal_slider(up_meal);
                                            up_meal.css('height','auto');
                                        }
                                    }
                                });
                            });

                            up_meal.on('click', '.show_ml_img', function(){
                                event.preventDefault();
                                var popup   = $("#ml_img_pop-up"),
                                    shadow  = $("#shadow"),
                                    opacity = 0.8,
                                    ml_img = $(this).attr('src');

                                if (shadow.length == 0)
                                {
                                    $("body").append("<div id='shadow'></div>");
                                    shadow = $("#shadow");
                                }

                                popup.find('.ml_img_pop-up_h').html('<img src="'+ ml_img +'" alt=""/>');

                                if($("#shadow2").is(':visible'))
                                {
                                    opacity = 0.6;
                                }
                                up_meal.hide();
                                popup.css({marginLeft:-popup.width()/2,marginTop:-popup.height()/2}).fadeIn(600);
                                $("#shadow, .ml_img_pop-up_close").fadeTo(600, opacity).click(function() {
                                    shadow.fadeOut(600);
                                    up_meal.fadeIn(600);
                                    popup.fadeOut(600);
                                });
                            });
                        }
                    });
                }
                else if(calEvent.constraint == "instruction")
                {
                    $.ajax({
                        url: '/show/instruction',
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
                                //$("#pop-up_video").append(data.i_a);
                                $("#pop-up_video").append(data.description);
                                //$("#pop-up_video").append(data.done);
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
                                            loop: false
                                        },
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

                                    playerTwoPlayer.ready().then(function() {
                                        console.log('Ready');

                                        playerTwoPlayer.on('play', function(data){
                                            console.log('Play ' + data);

                                            playerTwoPlayer.getCurrentTime().then(function(seconds) {
                                                console.log('Current time (seconds): ' + seconds);
                                            }).catch(function(error) {
                                                console.log('Current time error: ' + error);
                                            });

                                        });
                                        playerTwoPlayer.on('pause', function(data){
                                            console.log('Pause ' + data);
                                        });
                                        playerTwoPlayer.on('ended', function(data){
                                            console.log('Video ended ' + data);
                                        });

                                        playerTwoPlayer.setCurrentTime(15.456).then(function(seconds) {
                                            // seconds = the actual time that the player seeked to
                                            console.log('Current time (seconds): ' + seconds);
                                        }).catch(function(error) {
                                            switch (error.name) {
                                                case 'RangeError':
                                                    // the time was less than 0 or greater than the video’s duration
                                                    break;

                                                default:
                                                    // some other error occurred
                                                    break;
                                            }
                                        });
                                    });

                                }
                                pop_up_home($("#pop-up_video"));

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
            },
            eventMouseover: function(calEvent, jsEvent) {
                if(calEvent.ev_bl === true)
                {
                    var tooltip = '<div class="calendar_info">Курс заблокирован</div>';
                    var $tooltip = $(tooltip).appendTo('body');

                    $(this).mouseover(function(e) {
                        $(this).css('z-index', 10000);
                        $tooltip.fadeIn('500');
                        $tooltip.fadeTo('10', 1.9);
                    }).mousemove(function(e) {
                        $tooltip.css('top', e.pageY);
                        $tooltip.css('left', e.pageX + 20);
                    });
                }
            },
            eventMouseout: function(calEvent, jsEvent) {
                $(this).css('z-index', 8);
                $('.calendar_info').remove();
            }
        });
    });
</script>
