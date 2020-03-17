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

    $(document).ready(function()
    {
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
            eventLimit: 3, // allow "more" link when too many events
            events: [
                <?php if (!empty($events)) :
                $last_element = count($events);
                foreach ($events as $key => $event) :?>
                    {
                        start      : '<?php echo $event['start'];?>',
                        end        : '<?php echo $event['end'];?>',
                        constraint : '<?php echo $event['constraint'];?>',
                        ev_bl      : <?php if($event['blocked'] == 'true') : echo 'true'; else: echo 'false'; endif; ?>,
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

                    <?php /*if($event['missed'] == 'not_missed' and $event['done'] == 'not_done' and !empty($event['instruction_id'])): //*/?>/*
                        {
                            start      : '<?php /*echo $event['start'];*/?>',
                            end        : '<?php /*echo $event['end'];*/?>',
                            constraint : 'instruction',
                            title      : 'Инструктаж',
                            startParam : '<?php /*echo $event['instruction_id']; */?>',
                            endParam   : '<?php /*echo $event['workout_id']; */?>',
                            color      : 'rgba(187, 187, 187, .7)'
                        }<?php /*if ($last_element != $key) :*/?>,<?php /*endif; */?>
                    */<?php /*endif; */?>
                <?php endforeach;
                endif;?>
            ],
            eventAfterRender:function(calEvent, element, view ) {
                element.find('.fc-content').attr("id", "event-" + calEvent.endParam);
            },
            eventClick: function(calEvent, jsEvent, view) {
                if (calEvent.constraint === "workout" && calEvent.startParam !== "")
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
                                var pop_up_video = $("#pop-up_video"),
                                    pop_up_desc = pop_up_video.find('#wo-description'),
                                    viewed = false;
                                if(pop_up_video.is(':empty')
                                    || (pop_up_video.find('#vimeo-player-0').length === 0 && pop_up_video.find('#myvid').length === 0)
                                    || (pop_up_video.find('#vimeo-player-0').length === 1 && (pop_up_video.find('#vimeo-player-0').data('vimeo-url') !== data.source || pop_up_desc.html() !== data.description))
                                    || (pop_up_video.find('#myvid').length === 1 && (pop_up_video.find('#myvid').data('video-url') !== data.source || pop_up_desc.html() !== data.description)))
                                {
                                    pop_up_video.html(data.video);
                                    pop_up_video.find('#wo-instruction').hide();

                                    pop_up_video.find('.instruction').on('click', function(){
                                        if($(this).html() === 'Тренировка')
                                        {
                                            $(this).html('Инструктаж');
                                        }
                                        else
                                        {
                                            $(this).html('Тренировка');


                                            if ($('#vimeo-player-1').length === 1)
                                            {
                                                if (data.i_player === 1) {
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
                                                instPlayer = new Vimeo.Player('vimeo-player-1', options);
                                            }
                                        }
                                        pop_up_video.find('#wo-video').toggle();
                                        pop_up_video.find('#wo-instruction').toggle();
                                    });

                                    pop_up_video.find('#wo-done').on('click', function(){
                                        var wo_but = $(this).find('#bt-workout-done'),
                                            wo_id = $(this).find('#wo-id').val();

                                        $.ajax({
                                            url: '/viewed/video',
                                            type: 'post',
                                            data: {
                                                woid: wo_id
                                            },
                                            complete: function(result){
                                                if (result.responseText === 'true')
                                                {
                                                    calEvent.backgroundColor = 'rgb(153, 230, 0)';
                                                    $('#calendar').fullCalendar('updateEvent', calEvent);
                                                    viewed = true;
                                                    wo_but.addClass('done');
                                                    wo_but.val('Выполнено');
                                                }
                                            }
                                        });
                                    });
                                }
                                pop_up_home(pop_up_video);
                                if(getInternetExplorerVersion()===-1) {
                                    if (data.player === 1) {
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
                                }

                                playerTwoPlayer = new Vimeo.Player('vimeo-player-0', options);

                                playerTwoPlayer.on('play', function(data) {});

                                playerTwoPlayer.on('seeked', function(data) {});

                                playerTwoPlayer.on('pause', function(pause) {
                                    playerTwoPlayer.getCurrentTime().then(function(seconds) {});
                                });

                                playerTwoPlayer.on('ended', function(data) {
                                    playerTwoPlayer.getVideoTitle().then(function(title) {
                                        if(data.percent === 100)
                                        {
                                            $.ajax({
                                                url: '/viewing/video',
                                                type: 'post',
                                                data: {
                                                    woid: calEvent.endParam,
                                                    ved_time: data.seconds,
                                                    ved_percent: data.percent
                                                },
                                                complete: function(result){
                                                    if (result.responseText === 'true')
                                                    {
                                                    }
                                                }
                                            });
                                        }
                                    });
                                });

                                playerTwoPlayer.on('timeupdate', function(data){
                                    playerTwoPlayer.getVideoTitle().then(function(title) {
                                        var seconds = Math.floor(data.seconds),
                                            prev_seconds = Math.floor(data.seconds);
                                        if((seconds % 10) === 0 && seconds !== prev_seconds)
                                        {
                                            $.ajax({
                                                url: '/viewing/video',
                                                type: 'post',
                                                data: {
                                                    woid: calEvent.endParam,
                                                    ved_time: data.seconds,
                                                    ved_percent: data.percent
                                                },
                                                complete: function(result){
                                                    if (result.responseText === 'true')
                                                    {
                                                        prev_seconds = seconds;
                                                    }
                                                }
                                            });
                                        }
                                        if (data.percent > 0.75 && viewed === false) {
                                            $.ajax({
                                                url: '/viewed/video',
                                                type: 'post',
                                                data: {
                                                    woid: calEvent.endParam
                                                },
                                                complete: function(result){
                                                    if (result.responseText === 'true')
                                                    {
                                                        calEvent.backgroundColor = 'rgb(153, 230, 0)';
                                                        $('#calendar').fullCalendar('updateEvent', calEvent);
                                                        viewed = true;
                                                    }
                                                }
                                            });
                                        }
                                    });
                                });
                            }
                        }
                    });
                }
                else if(calEvent.constraint === "nutrition")
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
                else if(calEvent.constraint === "instruction")
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
                                var pop_up_video = $("#pop-up_video"),
                                    pop_up_desc = pop_up_video.find('#wo-description').html();
                                if(pop_up_video.is(':empty')
                                    || (pop_up_video.find('#vimeo-player-1').length == 0 && pop_up_video.find('#ivid').length == 0)
                                    || (pop_up_video.find('#vimeo-player-1').length == 1 && (pop_up_video.find('#vimeo-player-1').data('vimeo-url') !== data.source || pop_up_desc !== data.description))
                                    || (pop_up_video.find('#ivid').length == 1 && (pop_up_video.find('#ivid').data('video-url') !== data.source || pop_up_desc !== data.description)))
                                {
                                    pop_up_video.html(data.video);
                                }
                                pop_up_home(pop_up_video);
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
                                }

                                playerTwoPlayer = new Vimeo.Player('vimeo-player-1', options);
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
