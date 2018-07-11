$(document).ready(function(){

    /* Выбор активного видео */
    $("input[name=ir_active_video]:radio").change(function(){
        if ($.isNumeric($(this).val()))
        {
            var vd_block = $(this),
                vd_id = vd_block.val(),
                vd_block_id = vd_block.attr('id'),
                crs_id = $('input[name=i_course_id]').val(),
                vd_t = $('input[name=i_video_type]').val(),
                vd_acts = $('input[name=i_video_active]'),
                vd_act = $('#i-video-active-' + vd_id),
                display = 0;

            if(vd_block.is(':checked')) display = 1;

            if(vd_act.val() == 0)
            {
                $.ajax({
                    url: '/activateVideo',
                    type: 'post',
                    dataType: 'json',
                    data: {
                        vd_id: vd_id,
                        vd_t: vd_t,
                        crs_id: crs_id,
                        display: display
                    },
                    complete: function (result) {
                        var data = result.responseJSON;
                        if (data === true) {
                            vd_acts.each(function(){$(this).val(0)});
                            vd_act.val(1);
                            $('.label_video_active').html('Выбрать');
                            $('label[for='+vd_block_id+']').html('Активно');
                        }
                        else {
                            $('.label_video_active').html('Выбрать');
                            vd_block.prop('checked', false);
                        }
                    }
                });
            }
        }
    });

    // Формирование блока тренировок
    $(".practice_block_table").on('click', '.practice_day', function(){
        event.preventDefault();
        var pr_bl_w  = $('.practice_block_wrap'),
            pr_bl    = $('.practice_block'),
            pr_d     = $('.practice_day'),
            pr_id    = $(this).attr('id').substr(8);

        if ($(this).hasClass("active"))
        {
            $(this).removeClass('active');
            if(pr_bl_w.length == 1)
            {
                pr_bl.hide();
            }
        }
        else
        {
            pr_d.removeClass("active");
            $(this).addClass("active");

            if(pr_bl_w.length == 1)
            {
                pr_bl.hide();
                $('#' + $(this).attr('id') + '_block').show();
            }
        }
    });

    $(".landing_block_table").on('click', '.landing_blocks', function(){
        if ($(this).hasClass("active"))
        {
            $(this).removeClass('active');
            $('.landing_block').hide();
        }
        else
        {
            $('.landing_blocks').removeClass("active");
            $('.landing_block').hide();
            $(this).addClass("active");
            $('#l-' + $(this).attr('id')).show();
        }
    });

    $("#video-course").on('change', function(){
        var crs_block = $('.course_length');
        if ($.isNumeric($(this).val()))
        {
            var crs_id = $(this).val(),
                vd_id = $('#vd-id').val();

            $.ajax({
                url: '/show/weeks',
                type: 'post',
                dataType: 'json',
                data: {crs_id: crs_id, vd_id: vd_id},
                complete: function (result) {
                    var data = result.responseJSON;
                    if (data.crs_sch !== false) {
                        crs_block.show();
                        crs_block.children(".block_table").html(data.crs_sch);
                    }
                    else {
                        crs_block.hide();
                    }
                }
            });
        }
        else
        {
            crs_block.hide();
        }
    });
    $("#video-type").on('change', function(){
        var crs_block = $('.course_length');
        if ($.isNumeric($(this).val()) && $(this).val() == 2)
        {
            crs_block.show();
        }
        else
        {
            crs_block.hide();
        }
    });
});
