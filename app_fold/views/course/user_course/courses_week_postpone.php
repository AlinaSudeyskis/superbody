<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*$result['uc_days']  = $wo_data['days'];
$result['av_days']  = $wo_data['available_days'];
$result['recom_rd'] = $course['count_rest'];
$course['count_days'] = count($wo_data['available_days']);*/
?>
<form action="" method="post" class="postpone">
    <!--<div class="postpone_next_wo">Следующая тренировка: <?php /*echo $next_workout['next_workout']; */?></div>-->
    <?php if(!empty($courses_week_wo)): ?>
        <div class="content_block_h parent">
            <h3><?php if(!empty($next_workout['next_workout'])): ?>Следующая тренировка: <?php echo $next_workout['next_workout']; endif;?></h3>
        </div>
        <div class="kurs_block_val">
            <div class="anketa_block">
                <!--<ul class="anketa_block_nav parent">
                    <?php /*$i = 0;
                    foreach($courses_week_wo as $crs_id => $crs): */?>
                        <li><span <?php /*if($i == 0): echo 'class="anketa_active"'; endif;*/?>><?php /*echo $crs['crs_name']; */?></span></li>
                        <?php /*$i++;
                    endforeach;
                    unset($crs);*/?>
                </ul>-->
                <!--<div class="anketa_block_cont">-->
                    <?php /*foreach($courses_week_wo as $crs_id => $crs):
                        $week_wo = $crs['wos'];
                        $course['count_weeks'] = $crs['count_weeks'];
                        $course['count_days']  = count($crs['available_days']);
                        $course['count_rest']  = $crs['count_rest'];
                        $course['days']        = $crs['days'];
                        $course['training_time'] = $week_wo['time'];
                        */?>
                <!--
                        <div class="anketa_block_item">
                            <div class="anketa_block_item_h">Перенести тренировки недели</div>
                            <div class="anketa_block_item_cont">
                                <div class="postpone_title lend_form_h"></div>
                                <?php
/*                                ob_start();
                                    include('./app_fold/views/course/week_days_item.php');
                                    $week_days = ob_get_contents();
                                ob_end_clean();
                                */?>
                                <?php /*if(!empty($week_dates) and !empty($week_dates_today)): */?>
                                    <div class="anketa_form_radio_all parent cal_date">
                                        <?php /*foreach($week_dates as $wd):*/?>
                                            <div class="anketa_form_radio_wrap">
                                                <label class="<?php /*if($wd == $week_dates_today): */?>bold<?php /*endif; */?>"><?php /*echo $wd; */?></label>
                                            </div>
                                        <?php /*endforeach;
                                        unset($wd);*/?>
                                    </div>
                                <?php /*endif;*/?>
                                <div class="anketa_form_line parent">
                                    <?php /*echo $week_days; */?>
                                    <?php /*include('./app_fold/views/course/week_days_time_item.php'); */?>
                                </div>
                            </div>
                        </div>
                    --><?php /*endforeach;
                    unset($crs);*/?>
                <!--</div>-->
                <div class="anketa_block_item">
                    <div class="anketa_block_item_h">Перенести тренировки недели</div>
                    <div class="anketa_block_cont calendar_content_block">
                        <div id="calendar2" class="calendar" data-events="<?php echo $events; ?>"></div>
                        <div class="h_subtitle" style="line-height: 15px;margin-top: 15px; text-align: left; font-size: 12px;">
                            <div>- Перенести можно <span class="text_upper">пропущенную</span> или <span class="text_upper">новую</span> тренировки.</div>
                            <div>- Перенос возможен на <span class="text_upper">текущую</span> или <span class="text_upper">будущую</span> даты.</div>
                            <div>- <span class="text_upper">Не возможно</span> перенести тренировку на день с уже существующей тренировкой одного и того же курса.</div>
                            <div>- В один день может быть две тренировки одного и того же курса, если одна из тренировок <span class="text_upper">пропущена</span>.</div>
                        </div>
                    </div>
                </div>
                <script>
                    /* календарь */
                    var changed_events = {};
                    calendar2 = new FullCalendar.Calendar(document.getElementById('calendar2'), {
                        plugins: [ 'interaction', 'dayGrid', 'timeGrid', 'list' ],
                        defaultView: 'dayGridWeek',
                        firstDay: 1,
                        locale: 'ru',
                        displayEventTime: false,
                        eventTimeFormat: { hour: '2-digit', minute: '2-digit', meridiem: false },
                        columnHeaderFormat: { weekday: 'short', day: 'numeric', month: 'numeric' },
                        height: 130,
                        header: false,
                        editable: true,
                        disableDragging: false,
                        eventLimit: 8, // allow "more" link when too many events
                        eventSources:[{
                            id: 'postpone',
                            events: [ <?php echo $events; ?> ]
                        }],
                        eventMouseEnter: function(calEvent, jsEvent) {
                            if(calEvent.event.extendedProps.ev_bl === 'true')
                            {
                                var tooltip = '<div class="calendar_info">Курс заблокирован</div>';
                                tooltip = $(tooltip).appendTo('body');

                                tooltip.css('z-index', 10000);
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
                        eventDrop: function(calEvent){
                            calendar2.setOption('height', 175);
                            let o_event = calEvent.oldEvent.extendedProps,
                                event_id = o_event.endParam,
                                ev_uc = o_event.ev_uc,
                                sev_date = o_event.ev_date,
                                sev_d = new Date(sev_date),
                                ev_month = (calEvent.event.start.getMonth() + 1), sev_month = (sev_d.getMonth() + 1),
                                ev_day = (calEvent.event.start.getDate()), sev_day = (sev_d.getDate()),
                                ev_hours = (calEvent.event.start.getHours()),
                                ev_minutes = (calEvent.event.start.getMinutes()),
                                all_events = calendar2.getEvents(),
                                fl_deny = false, countPostpone = 0;

                            ev_month  = (String(ev_month).length === 1) ? ('0' + ev_month).slice(-2) : ev_month;
                            sev_month = (String(sev_month).length === 1) ? ('0' + sev_month).slice(-2) : sev_month;

                            ev_day  = (String(ev_day).length === 1) ? ('0' + ev_day).slice(-2) : ev_day;
                            sev_day = (String(sev_day).length === 1) ? ('0' + sev_day).slice(-2) : sev_day;

                            ev_hours  = (String(ev_hours).length === 1) ? ('0' + ev_hours).slice(-2) : ev_hours;
                            ev_minutes = (String(ev_minutes).length === 1) ? ('0' + ev_minutes).slice(-2) : ev_minutes;

                            let ev_date = calEvent.event.start.getFullYear() +'-'+ ev_month +'-'+ ev_day,
                                sev = sev_d.getFullYear() +'-'+ sev_month +'-'+ sev_day,
                                today = '<?php echo $today; ?>';

                            if(o_event.ev_st !== 'done' && o_event.ev_st !== 'in_progress' && ev_date >= today)
                            {
                                all_events.forEach(checkOrderWo);
                            }

                            if(0 === countPostpone)
                            {
                                fl_deny = all_events.some(checkWo);
                            }

                            if(ev_date < today || o_event.ev_st === 'done' || o_event.ev_st === 'in_progress'
                                || (fl_deny === true && o_event.ev_st !== 'missed') || o_event.ev_bl === 'true')
                            {
                                calEvent.revert();
                            }
                            else if(0 === countPostpone)
                            {
                                if(sev !== ev_date)
                                {
                                    calEvent.event.setProp( 'borderColor', '#000000' );
                                    if(!changed_events[ev_uc])
                                    {
                                        changed_events = { [ev_uc]: { [event_id] : ev_date} };
                                    }
                                    else
                                    {
                                        changed_events[ev_uc][event_id] = ev_date;
                                    }
                                }
                                else
                                {
                                    calEvent.event.setProp( 'borderColor', o_event.ev_bc );
                                    delete changed_events[ev_uc][event_id];
                                }
                            }

                            if (Object.keys(changed_events).length > 0)
                            {
                                $('#i-changed-events').val(JSON.stringify(changed_events));
                                $('#bt-save-postpone').prop('disabled', false);
                            }
                            else
                            {
                                $('#i-changed-events').val('');
                                $('#bt-save-postpone').prop('disabled', true);
                            }

                            function checkWo(currentE, index, array)
                            {
                                let cev_month = (currentE.start.getMonth() + 1),
                                    cev_day = (currentE.start.getDate()),
                                    cev_date;

                                cev_month = (String(cev_month).length === 1) ? ('0' + cev_month).slice(-2) : cev_month;
                                cev_day   = (String(cev_day).length === 1) ? ('0' + cev_day).slice(-2) : cev_day;
                                cev_date  = currentE.start.getFullYear() +'-'+ cev_month +'-'+ cev_day;

                                /*console.log(currentE.extendedProps.endParam + ' ' + (calEvent.event.extendedProps.ev_uc === currentE.extendedProps.ev_uc) + ' ' + (ev_date === cev_date) + ' '
                                    + (calEvent.event.extendedProps.endParam !== currentE.extendedProps.endParam) + ' ' + ((currentE.extendedProps.ev_st !== 'missed' && calEvent.event.extendedProps.ev_st !== 'missed')
                                        || (currentE.extendedProps.ev_st === 'missed' && calEvent.event.extendedProps.ev_st === 'missed')));*/

                                return (calEvent.event.extendedProps.ev_uc === currentE.extendedProps.ev_uc && ev_date === cev_date
                                    && calEvent.event.extendedProps.endParam !== currentE.extendedProps.endParam &&
                                    ((currentE.extendedProps.ev_st !== 'missed' && calEvent.event.extendedProps.ev_st !== 'missed')
                                        || (currentE.extendedProps.ev_st === 'missed' && calEvent.event.extendedProps.ev_st === 'missed')));
                            }

                            function checkOrderWo(currentE, index, array)
                            {
                                let cev_month = (currentE.start.getMonth() + 1),
                                    cev_day = (currentE.start.getDate()),
                                    cev_hours = (currentE.start.getHours()),
                                    cev_minutes = (currentE.start.getMinutes()),
                                    cev_date;
                                let pev_month = (calEvent.event.start.getMonth() + 1),
                                    pev_day = (calEvent.event.start.getDate()),
                                    pev_hours = (calEvent.event.start.getHours()),
                                    pev_minutes = (calEvent.event.start.getMinutes()),
                                    pev_date;

                                cev_month   = (String(cev_month).length === 1) ? ('0' + cev_month).slice(-2) : cev_month;
                                cev_day     = (String(cev_day).length === 1) ? ('0' + cev_day).slice(-2) : cev_day;
                                cev_hours   = (String(cev_hours).length === 1) ? ('0' + cev_hours).slice(-2) : cev_hours;
                                cev_minutes = (String(cev_minutes).length === 1) ? ('0' + cev_minutes).slice(-2) : cev_minutes;
                                cev_date    = currentE.start.getFullYear() +'-'+ cev_month +'-'+ cev_day;

                                pev_month   = (String(pev_month).length === 1) ? ('0' + pev_month).slice(-2) : pev_month;
                                pev_day     = (String(pev_day).length === 1) ? ('0' + pev_day).slice(-2) : pev_day;
                                pev_hours   = (String(pev_hours).length === 1) ? ('0' + pev_hours).slice(-2) : pev_hours;
                                pev_minutes = (String(pev_minutes).length === 1) ? ('0' + pev_minutes).slice(-2) : pev_minutes;
                                pev_date    = calEvent.event.start.getFullYear() +'-'+ pev_month +'-'+ pev_day;

                                const ce_hours = cev_hours + 1, pe_hours = pev_hours + 1;
                                let c_start =  cev_date + 'T' + cev_hours + ':' + cev_minutes,
                                    c_end =  cev_date + 'T' + ce_hours + ':' + cev_minutes,
                                    e_start =  pev_date + 'T' + pev_hours + ':' + pev_minutes,
                                    e_end =  pev_date + 'T' + pe_hours + ':' + pev_minutes;

                                const ffl_deny = all_events.some(checkWo);

                                if(calEvent.event.extendedProps.ev_uc === currentE.extendedProps.ev_uc && ffl_deny === false &&
                                    ((calEvent.event.extendedProps.ev_st !== 'missed' && currentE.extendedProps.ev_st !== 'missed')
                                        || (calEvent.event.extendedProps.ev_st === 'missed' && currentE.extendedProps.ev_st === 'missed')) &&
                                    ((currentE.extendedProps.endParam > calEvent.event.extendedProps.endParam && cev_date < pev_date)
                                        || (currentE.extendedProps.endParam < calEvent.event.extendedProps.endParam && cev_date > pev_date)) && cev_date >= today)
                                {
                                    calEvent.event.setDates( c_start, c_end );
                                    currentE.setDates( e_start, e_end );

                                    if(!changed_events[calEvent.event.extendedProps.ev_uc])
                                    {
                                        changed_events = { [calEvent.event.extendedProps.ev_uc]: { [calEvent.event.extendedProps.endParam] : cev_date} };
                                    }
                                    else
                                    {
                                        changed_events[calEvent.event.extendedProps.ev_uc][calEvent.event.extendedProps.endParam] = cev_date;
                                    }

                                    if(!changed_events[currentE.extendedProps.ev_uc])
                                    {
                                        changed_events = { [currentE.extendedProps.ev_uc]: { [currentE.extendedProps.endParam] : pev_date} };
                                    }
                                    else
                                    {
                                        changed_events[currentE.extendedProps.ev_uc][currentE.extendedProps.endParam] = pev_date;
                                    }

                                    if(cev_date !== calEvent.event.extendedProps.ev_date)
                                    {
                                        calEvent.event.setProp( 'borderColor', '#000000' );
                                    }
                                    else
                                    {
                                        calEvent.event.setProp( 'borderColor', calEvent.event.extendedProps.ev_bc );
                                        delete changed_events[calEvent.event.extendedProps.ev_uc][calEvent.event.extendedProps.endParam];
                                    }

                                    if(pev_date !== currentE.extendedProps.ev_date)
                                    {
                                        currentE.setProp( 'borderColor', '#000000' );
                                    }
                                    else
                                    {
                                        currentE.setProp( 'borderColor', currentE.extendedProps.ev_bc );
                                        delete changed_events[currentE.extendedProps.ev_uc][currentE.extendedProps.endParam];
                                    }

                                    calEvent.event = (cev_date > pev_date) ? calEvent.event : currentE;
                                    ev_date = cev_date;

                                    countPostpone++;
                                }
                            }
                        }
                    });

                    calendar2.render();

                    $('#bt-reset-postpone').on('click', function(){
                        calendar2.setOption('height', 175);
                        const eventSource = calendar2.getEventSourceById('postpone');
                        eventSource.refetch();
                        $('#bt-save-postpone').prop('disabled', true);
                        $.each(changed_events, function(i){
                            delete changed_events[i];
                        });
                        $('#i-changed-events').val('');
                        console.clear();
                    });
                </script>
            </div>
        </div>
    <?php endif;?>

    <div class="anketa_form_line parent">
        <div class="video_admin_form_buts parent">
            <input type="hidden" name="i_changed_events" value="" id="i-changed-events">
            <input type="button" name="bt_reset" value="Сброс" class="admin_form_reset" id="bt-reset-postpone">
            <input type="submit" name="bt_save_postpone" value="Сохранить" class="video_admin_form_send" id="bt-save-postpone" disabled>
        </div>
    </div>
</form>
