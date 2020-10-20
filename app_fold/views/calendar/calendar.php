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

    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            plugins: [ 'interaction', 'dayGrid', 'timeGrid', 'list' ],
            defaultView: ($(window).width() < 765) ? 'listWeek':'dayGridMonth',
            navLinks: true,
            firstDay: 1,
            locale: 'ru',
            eventTimeFormat: { // like '14:30:00'
                hour: '2-digit',
                minute: '2-digit',
                meridiem: false
            },
            height: 620,
            header: {
                left: 'prev,next today',
                center: 'title',
                right: ($(window).width() < 765) ? '':'dayGridMonth,dayGridWeek,timeGridDay'
            },
            views: {
                dayGridWeek: {
                    columnHeaderFormat: { weekday: 'short', day: 'numeric', month: 'numeric' }
                },
                timeGridDay:{
                    allDaySlot: false,
                    slotLabelFormat: { hour: 'numeric', minute: '2-digit' }
                }
            },
            buttonText: { today: 'Сегодня', month: 'Месяц', week: 'Неделя', day: 'День', list: 'Список' },
            editable: true,
            disableDragging: false,
            eventLimit: 3, // allow "more" link when too many events
            events: [
                <?php if (!empty($events)) :
                $last_element = count($events);
                foreach ($events as $key => $event) :
                $color = (!empty($event['blocked']) and $event['blocked'] == 'true') ? 'rgba(218, 218, 218, 1)' : $event['color'];
                $color = (!empty($event['pause']) and $event['pause'] === true) ? 'rgba(255, 159, 137, 0.5)' : $color; ?>
                {
                    start : '<?php echo $event['start'];?>',
                    end   : '<?php echo $event['end'];?>',
                    ev_gr : '<?php echo $event['constraint'];?>',
                    ev_bl : <?php if($event['blocked'] == 'true') : echo 'true'; else: echo 'false'; endif; ?>,
                    <?php if (!empty($event['title'])) :?>
                    title : '[<?php echo $event['wo_id'];?>] <?php echo $event['title'];?>',
                    <?php endif;
                    if (!empty($event['id'])) :?>
                    startParam : '<?php echo $event['id'];?>',
                    <?php endif;
                    if (!empty($event['ml_id'])) :?>
                    ml_id : '<?php echo $event['ml_id'];?>',
                    <?php endif;
                    if (!empty($event['day'])) :?>
                    day : '<?php echo $event['day'];?>',
                    <?php endif;
                    if (!empty($event['ingestion'])) :?>
                    ingestion : '<?php echo $event['ingestion'];?>',
                    <?php endif;
                    if (!empty($event['workout_id'])) :?>
                    endParam : '<?php echo $event['workout_id'];?>',
                    <?php endif;
                    if (!empty($event['pause']) and $event['pause'] === true): ?>
                    overlap : false,
                    rendering : 'background',
                    <?php endif; ?>
                    color: '<?php echo $color; ?>'
                }<?php if ($last_element != $key) :?>,<?php endif; ?>
                <?php endforeach;
                endif;?>
            ],
            eventPositioned:function(calEvent) {
                $(calEvent.el).find('.fc-content').attr("id", "event-" + calEvent.event.extendedProps.endParam);
            },
            eventClick: function(calEvent, jsEvent, view) {
                if (calEvent.event.extendedProps.ev_gr === "workout" && calEvent.event.extendedProps.startParam !== "" && calEvent.event.extendedProps.ev_bl === false)
                {
                    $.ajax({
                        url: '/show/video',
                        type: 'post',
                        dataType: 'json',
                        data: {
                            start_param: calEvent.event.extendedProps.startParam,
                            end_param: calEvent.event.extendedProps.endParam
                        },
                        complete: function (result)
                        {
                            var data = jQuery.parseJSON(result.responseText);
                            if (!data.error)
                            {
                                var pop_up_video = $("#pop-up_video"),
                                    pop_up_desc = pop_up_video.find('#wo-description'),
                                    viewed = false;
                                pop_up_video.removeClass('today_courses');
                                if(pop_up_video.is(':empty')
                                    || (pop_up_video.find('#vimeo-player-0').length === 0 && pop_up_video.find('#myvid').length === 0)
                                    || (pop_up_video.find('#vimeo-player-0').length === 1 && (pop_up_video.find('#vimeo-player-0').data('vimeo-url') !== data.source || pop_up_desc.html() !== data.description))
                                    || (pop_up_video.find('#myvid').length === 1 && (pop_up_video.find('#myvid').data('video-url') !== data.source || pop_up_desc.html() !== data.description)))
                                {
                                    pop_up_video.html(data.video);
                                    pop_up_video.append(data.workout_url);
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
                                                    calEvent.event.setProp( 'backgroundColor', 'rgb(153, 230, 0)' );
                                                    //$('#calendar').fullCalendar('updateEvent', calEvent);
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

                                if(data.player_type === 'vimeo')
                                {
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
                                                        woid: calEvent.event.extendedProps.endParam,
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

                                    var prev_seconds = null;
                                    playerTwoPlayer.on('timeupdate', function(data){
                                        playerTwoPlayer.getVideoTitle().then(function(title) {
                                            var seconds = Math.floor(data.seconds);
                                            if((seconds % 10) === 0 && seconds !== prev_seconds)
                                            {
                                                $.ajax({
                                                    url: '/viewing/video',
                                                    type: 'post',
                                                    data: {
                                                        woid: calEvent.event.extendedProps.endParam,
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
                                                        woid: calEvent.event.extendedProps.endParam
                                                    },
                                                    complete: function(result){
                                                        if (result.responseText === 'true')
                                                        {
                                                            calEvent.event.setProp( 'backgroundColor', 'rgb(153, 230, 0)' );
                                                            //$('#calendar').fullCalendar('updateEvent', calEvent);
                                                            viewed = true;
                                                        }
                                                    }
                                                });
                                            }
                                        });
                                    });
                                }
                            }
                        }
                    });
                }
                else if(calEvent.event.extendedProps.ev_gr === "nutrition")
                {
                    var start = calEvent.start._i;
                    $.ajax({
                        url: '/showMeals',
                        type: 'post',
                        dataType: 'json',
                        data: {
                            start: start,
                            start_param: calEvent.event.extendedProps.startParam,
                            ml_id: calEvent.event.extendedProps.ml_id,
                            day: calEvent.event.extendedProps.day,
                            ingestion: calEvent.event.extendedProps.ingestion
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
                                            calEvent.event.extendedProps.ml_id = mlid;
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
                                            calEvent.event.extendedProps.ml_id = mlid;
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

                                if (shadow.length === 0)
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
                else if(calEvent.event.extendedProps.ev_gr === "instruction")
                {
                    $.ajax({
                        url: '/show/instruction',
                        type: 'post',
                        dataType: 'json',
                        data: {
                            start_param: calEvent.event.extendedProps.startParam,
                            end_param: calEvent.event.extendedProps.endParam
                        },
                        complete: function (result) {
                            var data = jQuery.parseJSON(result.responseText);
                            if (!data.error) {
                                var pop_up_video = $("#pop-up_video"),
                                    pop_up_desc = pop_up_video.find('#wo-description').html();
                                pop_up_video.removeClass('today_courses');
                                if(pop_up_video.is(':empty')
                                    || (pop_up_video.find('#vimeo-player-1').length === 0 && pop_up_video.find('#ivid').length === 0)
                                    || (pop_up_video.find('#vimeo-player-1').length === 1 && (pop_up_video.find('#vimeo-player-1').data('vimeo-url') !== data.source || pop_up_desc !== data.description))
                                    || (pop_up_video.find('#ivid').length === 1 && (pop_up_video.find('#ivid').data('video-url') !== data.source || pop_up_desc !== data.description)))
                                {
                                    pop_up_video.html(data.video);
                                }
                                pop_up_home(pop_up_video);
                                if(getInternetExplorerVersion() === -1) {
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

                                playerTwoPlayer = new Vimeo.Player('vimeo-player-1', options);
                            }
                        }
                    });
                }
            },
            eventMouseEnter: function(calEvent, jsEvent) {
                if(calEvent.event.extendedProps.ev_bl === true)
                {
                    var tooltip = '<div class="calendar_info">Курс заблокирован</div>';
                    tooltip = $(tooltip).appendTo('body');

                    tooltip.fadeIn('500');
                    tooltip.fadeTo('10', 1.9);

                    $(calEvent.el).mouseover(function(e) {
                        $(this).css('z-index', 10000);
                    }).mousemove(function(e) {
                        tooltip.css('top', e.pageY);
                        tooltip.css('left', e.pageX + 20);
                    });
                }
            },
            eventMouseLeave: function(calEvent, jsEvent) {
                $(this).css('z-index', 8);
                $('.calendar_info').remove();
            },
            eventDragStart: function(){
                $('.calendar_info').remove();
            },
            eventDrop: function(event, dayDelta, minuteDelta, allDay, revertFunc){
                event.revert();
            }
        });

        calendar.render();
    });
</script>
