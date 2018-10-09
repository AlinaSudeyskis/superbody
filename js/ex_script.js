$(document).ready(function(){
    $(function(){
        var kursBlockValHeight = $('.kurs_block_val').height(),
            fxTopCont = $('.content_block_container'),
            fxTopContWrap = $('.content_block_container_wrap'),
            parTopContWidth = fxTopContWrap.outerWidth(),
            parTopContHeight = fxTopContWrap.outerHeight(),
            fxButCont = $('.admin_form_buts_wrap'),
            parButContWidth = $('.admin_form_buts_wrap_container').outerWidth(),
            topPos = fxTopCont.offset().top;
        $(window).scroll(function() {
            var top = $(document).scrollTop();

            if (top > topPos && kursBlockValHeight > 500)
            {
                fxTopCont.addClass('fixed');
                fxTopCont.width(parTopContWidth);
                fxTopContWrap.height(parTopContHeight);
                if(fxButCont.length == 1)
                {
                    fxButCont.addClass('fixed');
                    fxButCont.css({ top: parTopContHeight + 'px' });
                    fxButCont.css({ width: parButContWidth + 'px' });
                }
            }
            else
            {
                fxTopCont.removeClass('fixed');
                if(fxButCont.length == 1) {
                    fxButCont.removeClass('fixed');
                }
            }
        });
    });

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
            pr_id    = $(this).attr('id').substr(8),
            pr_block = $('#' + $(this).attr('id') + '_block');

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
                pr_block.show();
            }
        }
    });

    // Формирование расписания питания
    $(".nutrition_block_table").on('click', '.nutrition_day', function(){
        event.preventDefault();
        var pr_bl_w  = $('.nutrition_block_wrap'),
            pr_bl    = $('.nutrition_block'),
            pr_d     = $('.nutrition_day'),
            pr_id    = $(this).attr('id').substr(8),
            pr_block = $('#' + $(this).attr('id') + '_block'),
            pr_d_act = $('.nutrition_day.active'),
            ingestions = $(".ingestion");

        if ($(this).hasClass("active"))
        {
            $(this).removeClass('active');
            pr_d_act = $('.nutrition_day.active');
            if(pr_bl_w.length == 1)
            {
                if(pr_d_act.length == 0)
                {
                    pr_bl.hide();
                }
                else if(pr_d_act.length == 1)
                {
                    pr_bl.hide();
                    $('#' + pr_d_act.attr('id') + '_block').show();
                }
            }
        }
        else
        {
            //pr_d.removeClass("active");
            $(this).addClass("active");
            pr_d_act = $('.nutrition_day.active');

            if(pr_bl_w.length == 1)
            {
                var h_info = pr_bl_w.children('.h_subtitle');
                pr_bl.hide();
                if(pr_d_act.length == 1)
                {
                    pr_block.show();
                }
                else if(pr_d_act.length > 1)
                {
                    var nut_bl_multi = $('.nutrition_block.multiple'),
                        add_tov_val = nut_bl_multi.find('.add_tov_val');

                    add_tov_val.empty();
                    nut_bl_multi.show();
                }

                if (pr_bl_w.children(".nutrition_block:visible").length == 0)
                {
                    if(h_info.length == 0)
                    {
                        pr_bl_w.append('<span class="h_subtitle">Выберите приемы пищи</span>');
                    }
                    else
                    {
                        h_info.show();
                    }
                }
                else if(h_info.length == 1)
                {
                    h_info.hide();
                }
            }
        }
    });

    /* Формирование меню питания */
    $(".nutr_time_in").on('keyup', function() {
        var kurs_time_in = $(this).parents("form").find("input.nutr_time_in").val(),
            kurs_length_in = 7,
            kurs_length_out = $(this).parents("form").find(".nutrition_block").length,
            active_practice_block = $('.nutrition_day.active').attr('id'),
            video_list = $(".form_video_list").html(),
            index = 'e', rez, html_table = '', html = '', option, num,
            i = 1, tr_week = 1, tr_day = 1,
            block_id, active_class = "",
            ingestions = $(".ingestion");

        if(kurs_time_in != 0 && kurs_length_in != 0)
        {
            rez = kurs_time_in * kurs_length_in;
            while (tr_week <= kurs_time_in) {
                html_table = html_table + '<div class="nutrition_weeks"><div class="nutrition_week"><span>Неделя</span> '+tr_week+'</div>' +
                    '<div class="nutrition_days">';
                tr_day = 1;
                while(tr_day <= kurs_length_in){
                    block_id = 'practice' + i;
                    active_class = "";
                    if (active_practice_block == block_id)
                    {
                        active_class = "active";
                    }
                    html_table = html_table + '<div class="nutrition_day '+active_class+'" id="nutrition'+i+'">Т '+tr_day+'</div>';
                    tr_day++;
                    i++;
                }
                html_table = html_table + '</div></div>';
                tr_week++;
            }
            $(".nutrition_block_table").html(html_table);
        }

        if(kurs_time_in != 0 && kurs_length_in != 0 && kurs_length_out < 1){
            rez = kurs_time_in * kurs_length_in;
            i = 1;
            html = '';
            while (i < rez) {
                html = html + '<div class="nutrition_block" id="nutrition'+i+'_block" data-id="'+i+'">';

                ingestions.each(function(index, value){
                    $(this).children("input:checkbox:checked").each(function(index2, value2)
                    {
                        html = html + '<div class="parent kurs_cur_wrap" id="crs-ingestion-'+i+'-'+$(this).val()+'">' +
                            '<div class="kurs_block_h">' + $(this).next("label").html() + '</div>' +
                            '<div class="add_tov_in_total">' +
                            '<div class="add_tov_in meal">' +
                            '<input type="text" name="name_meal['+i+']" data-day="'+i+'" data-ingestion="'+$(this).val()+'" class="admin_form_txt admin_form_txt_middle" placeholder="Введите наименование блюда">' +
                            '<div class="add_tov_list">'+video_list+'</div>' +
                            '</div>' +
                            '<div class="add_tov_val"></div>' +
                            '</div>' +
                            '</div>';
                    });
                });

                html = html + '</div>';
                i++;
            }
            $(this).parents("form").find(".nutrition_block_wrap").html(html);
            $(this).parents("form").find(".nutrition_block_wrap").find(".journal_form_select").styler();
        }
        else if(kurs_time_in != 0 && kurs_length_in != 0 && kurs_length_out >= 1){
            rez = kurs_time_in * kurs_length_in - kurs_length_out;
            //$(this).parents("form").find(".practice_block").show();
            if(rez>0){
                num = kurs_length_out + 1;
                i = 0;
                a = 1;
                html = '';
                while (i < rez) {

                    html = html + '<div class="nutrition_block" id="nutrition'+num+'_block" data-id="'+i+'">';

                    ingestions.each(function(index, value){
                        $(this).children("input:checkbox:checked").each(function(index2, value2)
                        {
                            html = html + '<div class="parent kurs_cur_wrap" id="crs-ingestion-'+i+'-'+$(this).val()+'">' +
                                '<div class="kurs_block_h">' + $(this).next("label").html() + '</div>' +
                                '<div class="add_tov_in_total">' +
                                '<div class="add_tov_in meal">' +
                                '<input type="text" name="name_meal['+num+']" data-day="'+num+'" data-ingestion="'+$(this).val()+'" class="admin_form_txt admin_form_txt_middle" placeholder="Введите наименование блюда">' +
                                '<div class="add_tov_list">'+video_list+'</div>' +
                                '</div>' +
                                '<div class="add_tov_val"></div>' +
                                '</div>' +
                                '</div>';
                        });
                    });

                    html = html + '</div>';
                    i++;
                    num++;
                }
                $(this).parents("form").find(".nutrition_block_wrap").append(html);
                $(this).parents("form").find(".nutrition_block_wrap").find(".journal_form_select").styler();
                $('#' + active_practice_block + '_block').show();
            }
            else if(rez<0){
                i = 0;
                while (i > rez) {
                    $(this).parents("form").find(".nutrition_block:nth-of-type("+(kurs_length_out + i)+")").hide();
                    i--;
                }
            }
        }
        $('.nutrition_block_table').children('.h_subtitle').hide();
    });

    // Изменение кол-ва приемов пищи
    $(".ingestion input:checkbox").on('click', function(){
        var ing_after = $(this).data('after'),
            ing_name = $(this).data("name"),
            ing_cb = $(this),
            ing_id = $(this).val(),
            html = '';

        $(".nutrition_block").each(function(i, v){
            var pb = $(this),
                pb_id = pb.data("id"),
                bl_after = 'crs-ingestion-' + pb_id + '-' + ing_after,
                ing_block = $('#crs-ingestion-' + pb_id + '-' + ing_id);

            html = '<div class="parent kurs_cur_wrap" id="crs-ingestion-' + pb_id + '-' + ing_id + '">' +
                '<div class="kurs_block_h">' + ing_name + '</div>' +
                '<div class="add_tov_in_total">' +
                '<div class="add_tov_in meal">' +
                '<input type="text" name="name_meal['+pb_id+']" data-day="'+pb_id+'" data-ingestion="'+ing_id+'" class="admin_form_txt admin_form_txt_middle" placeholder="Введите наименование блюда">' +
                '<div class="add_tov_list"></div>' +
                '</div>' +
                '<div class="add_tov_val"></div>' +
                '</div>' +
                '</div>';

            if(ing_cb.is(':checked'))
            {
                if(ing_after == 'first')
                {
                    if(ing_block.length == 0)
                    {
                        pb.prepend(html);
                    }
                    else
                    {
                        ing_block.show();
                    }
                }
                else if(ing_after == 'last')
                {
                    if(ing_block.length == 0)
                    {
                        pb.append(html);
                    }
                    else
                    {
                        ing_block.show();
                    }
                }
                else
                {
                    pb.children(".kurs_cur_wrap").each(function(){
                        if($(this).attr('id') == bl_after)
                        {
                            if(ing_block.length == 0)
                            {
                                $(this).after(html);
                            }
                            else
                            {
                                ing_block.show();
                            }
                        }
                    });
                }
            }
            else
            {
                ing_block.hide();
            }
        });

        $('.nutrition_block_wrap').children('.h_subtitle').hide();
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

    /* выпадающий список товаров */
    $(document).on('input', '.add_tov_in.product input:text', function () {
        if($(this).val() != '' && $(this).val().length < 255){
            var input_search = $(this).val(),
                tov_in = $(this);

            $.ajax({
                url: '/searchProduct',
                type: 'post',
                dataType: 'json',
                data: {product: input_search},
                complete: function (result) {
                    var data = result.responseJSON;
                    if (data.products !== false) {
                        tov_in.parents(".add_tov_in").find(".add_tov_list").show();
                        tov_in.parents(".add_tov_in").find(".add_tov_list").html(data.products);
                    }
                    else {
                        tov_in.parents(".add_tov_in").find(".add_tov_list").hide();
                    }
                }
            });
        } else{
            $(this).parents(".add_tov_in").find(".add_tov_list").hide();
        }
    });
    $(document).on("click", ".add_tov_in.product .add_tov_item", function() {
        if(!$(this).hasClass("disable")){
            var link = $(this).find(".add_tov_cont").attr("href"),
                name = $(this).find(".add_tov_h").text(),
                price = $(this).find(".add_tov_price").text(),
                number = $(this).attr("id");
            if ($('#'+number+'tov').length == 0) {
                $(this).parents(".add_tov_in_total").find(".add_tov_val")
                    .append('<div id="'+number+'tov" class="add_tov_val_item parent">' +
                        '<a href="'+link+'" class="add_tov_val_cont parent"><span class="add_tov_val_h">'+name+'</span>' +
                        '<span class="add_tov_val_price">'+price+'</span></a>' +
                        '<div class="add_tov_val_sale">' +
                        '<div class="admin_form_h">Скидка, %</div>' +
                        '<input type="hidden" name="attached_products[]" value="'+number+'" />' +
                        '<input type="text" name="attached_discount[]" class="admin_form_txt" placeholder="20" /></div>' +
                        '<div class="del_tov"></div></div>');
                $(this).parents(".add_tov_list").hide();
                $(this).parents(".add_tov_list").parents('.add_tov_in').find('input:text').val('');
                $(this).addClass("disable");
            }
        }
        return false;
    });

    /* выпадающий список видео */
    $(document).on('input', '.add_tov_in.video input:text', function () {
        if($(this).val() != '' && $(this).val().length < 255){
            var input_search = $(this).val(),
                c_id = $('#c-id').val(),
                tov_in = $(this);
            $.ajax({
                url: '/searchVideo',
                type: 'post',
                dataType: 'json',
                data: {search_text: input_search, c_id: c_id},
                complete: function (result) {
                    var data = result.responseJSON;
                    tov_in.parents(".add_tov_in.video").find(".add_tov_list").html(data.video);
                    tov_in.parents(".add_tov_in.video").find(".add_tov_list").show();
                }
            });
        } else{
            $(this).parents(".add_tov_in").find(".add_tov_list").hide();
        }
    });

    /* выпадающий список блюд */
    $(document).on('input', '.add_tov_in.meal input:text', function () {
        var tov_in = $(this),
            input_search = tov_in.val();
        if(input_search != '' && input_search.length >= 3 && input_search.length < 255){
            var crs_day = tov_in.data('day'),
                crs_ingestion = tov_in.data('ingestion');
            $.ajax({
                url: '/searchMeals',
                type: 'post',
                dataType: 'json',
                data: {search_text: input_search, crs_day: crs_day, crs_ingestion: crs_ingestion},
                complete: function (result) {
                    var data = result.responseJSON;
                    if(data)
                    {
                        tov_in.parents(".add_tov_in.meal").find(".add_tov_list").html(data.meals);
                        tov_in.parents(".add_tov_in.meal").find(".add_tov_list").show();
                    }
                    else{
                        tov_in.parents(".add_tov_in").find(".add_tov_list").hide();
                    }
                }
            });
        }
        else{
            tov_in.parents(".add_tov_in").find(".add_tov_list").hide();
        }
    });

    /* выпадающий список тренеров */
    $(document).on('input', '.add_tov_in.couches input:text', function () {
        if($(this).val() != '' && $(this).val().length < 255){
            var input_search = $(this).val(),
                tov_in = $(this);
            $.ajax({
                url: '/searchCouches',
                type: 'post',
                dataType: 'json',
                data: {search_text: input_search},
                complete: function (result) {
                    var data = result.responseJSON;
                    tov_in.parents(".add_tov_in").find(".add_tov_list").html(data.couches);
                    tov_in.parents(".add_tov_in").find(".add_tov_list").show();
                }
            });
        } else{
            $(this).parents(".add_tov_in").find(".add_tov_list").hide();
        }
    });

    $(document).on("click", ".add_tov_item", function() {
        if(!$(this).hasClass("disable")){
            var link = $(this).find(".add_tov_cont").attr("href"),
                name = $(this).find(".add_tov_h").text(),
                price = $(this).find(".add_tov_price").text(),
                number = $(this).attr("id");
            if($(this).parents("form").hasClass("edit_kurs_form") || $(this).parents("form").hasClass("add_kurs_form")){
                $(this).parents(".add_tov_in_total").find(".add_tov_val")
                    .append('<div id="'+number+'tov" class="add_tov_val_item parent">' +
                        '<a href="'+link+'" class="add_tov_val_cont parent"><span class="add_tov_val_h">'+name+'</span></a>' +
                        '<div class="add_tov_val_sale">' +
                        '<div class="admin_form_h">Процент, %</div>' +
                        '<input type="hidden" name="couches['+number+']" value="'+number+'" />' +
                        '<input type="text" name="couches_percent['+number+']" class="admin_form_txt" placeholder="20" />' +
                        '</div>' +
                        '<div class="del_tov"></div></div>');
            } else if($(this).parents("form").hasClass("landing_admin_form")){
                $(this).parents(".add_tov_in_total").find(".add_tov_val")
                    .append('<div id="'+number+'tov" class="add_tov_val_item parent">' +
                        '<a href="'+link+'" class="add_tov_val_cont parent"><span class="add_tov_val_h">'+name+'</span></a>' +
                        '<div class="del_tov"></div></div>');
            }
            $(this).parents(".add_tov_list").hide();
            $(this).parents(".add_tov_list").parents('.add_tov_in').find('input:text').val('');
            $(this).addClass("disable");
        }
        return false;
    });

    $(document).on('click', '.del_tov', function () {
        var id = $(this).parents(".add_tov_val_item").attr("id"),
            video_id = $(this).parents(".add_tov_in_total").children("#id-video"+parseFloat(id)),
            inst_id = $(this).parents(".add_tov_in_total").children("#id-video-instruction"),
            ml_type_block = $(this).parents(".add_tov_val_item").parent(),
            meal_block = $("#" + id);

        if (video_id.length == 1 || inst_id.length == 1)
        {
            $(this).parents(".add_tov_in_total").find("#"+id).removeClass("disable");
            $(this).parents(".add_tov_val_item").remove();
            video_id.val('');
            inst_id.val('');
        }
        // Удалить блок блюда
        if(meal_block.length == 1)
        {
            meal_block.remove();
        }
        // Удалить блок категории блюда
        if(ml_type_block.find('.add_tov_val_item').length == 0)
        {
            ml_type_block.remove();
        }
    });

    $(document).on('click', '.add_tren_item.video', function () {
        if(!$(this).hasClass("disable")){
            var link = $(this).find(".add_tov_cont").attr("href"),
                name = $(this).find(".add_tov_h").text(),
                number = $(this).attr("id"),
                video_link = $(this).data("video-link"),
                poster_link = $(this).data("poster-link"),
                format = video_link.split('.'),
                format = format[format.length-1],
                desk = $(this).data("video-desk"),
                block_id = parseFloat($(this).parents(".practice_block").attr("id")),
                form_id = parseFloat($(this).parents("form").attr("id")),
                video_id = 'myVideo'+form_id+'_'+block_id+'_'+number,
                time_id = 'video_time'+form_id+'_'+block_id+'_'+number;

            $(this).parents(".add_tov_in_total").find(".add_tov_val")
                .html('<div id="'+block_id+'video" class="add_tov_val_item parent">' +
                    '<div class="add_kurs_val_video_wrap parent">' +
                    '<a href="'+link+'" class="add_tov_val_cont parent"><span class="add_tov_val_h">'+name+'</span></a>' +
                    '<div class="del_tov"></div>' +
                    '</div>' +
                    '</div>');
            $(this).parents(".add_tov_in_total").find("#id-video" + block_id).val(number);
            $(this).parents(".add_tov_in_total").find("#id-video-instruction").val(number);
            $(this).parents(".add_tov_list").hide();
            $(this).parents(".add_tov_list").parents('.add_tov_in').find('input:text').val('');
            $(this).addClass("disable");
        }
        //getVideoTime(video_id, time_id);
        return false;
    });

    $(document).on('click', '.add_tren_item.meal', function () {
        event.preventDefault();
        if(!$(this).hasClass("disable")){
            var this_meal = $(this),
                link = this_meal.find(".add_tov_cont").attr("href"),
                name = this_meal.data('meal-name'),
                number = this_meal.data('meal-id'),
                crs_day = this_meal.data('day'),
                crs_ingestion = this_meal.data('ingestion'),
                ml_type = this_meal.data('ml-type'),
                ml_name = this_meal.data('ml-name'),
                weight = this_meal.data('weight'),
                proteins = this_meal.data('proteins'),
                fats = this_meal.data('fats'),
                carbohydrates = this_meal.data('carbohydrates'),
                calories = this_meal.data('calories'),
                add_tov_val = this_meal.parents(".add_tov_in_total").find('.add_tov_val'),
                ml_type_block = add_tov_val.children('#ml-type-' + crs_day + '-' + crs_ingestion + '-' + ml_type),
                ml_block_wrap = ml_type_block.children('.add_tov_val_item_wrap'),
                ml_block = ml_block_wrap.find('#meal-' + crs_day + '-' + crs_ingestion + '-' + ml_type + '-' + number),
                ml_block_content = '<div id="meal-' + crs_day + '-' + crs_ingestion + '-' + ml_type + '-' + number + '" class="add_tov_val_item parent">' +
                    '<div class="add_kurs_val_video_wrap parent">' +
                        '<a href="/administration/meal/' + number + '" class="add_tov_val_cont meal_cont parent">' +
                            '<div class="add_tov_val_h">' + name + '</div>' +
                            '<div class="add_tov_val_sh">' +
                            '   <div class="meal_wpfcc_wrap">' +
                                    '<div class="meal_wpfcc">' +
                                        '<div class="meal_wpfcc_title" short="В">Вес</div>' +
                                        '<div class="meal_wpfcc_val">' + weight + '</div>' +
                                    '</div>' +
                                    '<div class="meal_wpfcc">' +
                                        '<div class="meal_wpfcc_title" short="Б">Белки</div>' +
                                        '<div class="meal_wpfcc_val">' + proteins + '</div>' +
                                    '</div>' +
                                    '<div class="meal_wpfcc">' +
                                        '<div class="meal_wpfcc_title" short="Ж">Жиры</div>' +
                                        '<div class="meal_wpfcc_val">' + fats + '</div>' +
                                    '</div>' +
                                    '<div class="meal_wpfcc">' +
                                        '<div class="meal_wpfcc_title" short="У">Углеводы</div>' +
                                        '<div class="meal_wpfcc_val">' + carbohydrates + '</div>' +
                                    '</div>' +
                                    '<div class="meal_wpfcc">' +
                                        '<div class="meal_wpfcc_title" short="К">Калории</div>' +
                                        '<div class="meal_wpfcc_val">' + calories + '</div>' +
                                    '</div>' +
                                '</div>' +
                            '</div>' +
                        '</a>' +
                        '<div class="del_tov"></div>' +
                    '</div>' +
                    '<input type="hidden" name="id_meal[' + crs_day + '][' + crs_ingestion + '][]" value="' + number + '" id="id-meal-' + crs_day + '-' + crs_ingestion + '-' + number + '"/>' +
                '</div>';

            if(ml_type_block.length == 0)
            {
                add_tov_val.append('<div id="ml-type-' + crs_day + '-' + crs_ingestion + '-' + ml_type + '">' +
                    '<div class="kurs_block_h">' + ml_name + '</div>' +
                    '<div class="add_tov_val_item_wrap"></div>' +
                    '</div>');
                ml_type_block = add_tov_val.children('#ml-type-' + crs_day + '-' + crs_ingestion + '-' + ml_type);
                ml_block_wrap = ml_type_block.children('.add_tov_val_item_wrap');
            }
            if(ml_block.length == 0)
            {
                ml_block_wrap.append(ml_block_content);
            }

            var pr_d_act = $('.nutrition_day.active');
            if(pr_d_act.length > 1)
            {
                pr_d_act.each(function(index, value){
                    var pr_block = $('#' + value.id + '_block'),
                        crs_day = pr_block.data('id'),
                        add_tov_val = pr_block.children('#crs-ingestion-' + crs_day + '-' + crs_ingestion).find('.add_tov_val'),
                        ml_type_block = add_tov_val.children('#ml-type-' + crs_day + '-' + crs_ingestion + '-' + ml_type),
                        ml_block_wrap = ml_type_block.children('.add_tov_val_item_wrap'),
                        ml_block = ml_block_wrap.find('#meal-' + crs_day + '-' + crs_ingestion + '-' + ml_type + '-' + number),
                        ml_block_content = '<div id="meal-' + crs_day + '-' + crs_ingestion + '-' + ml_type + '-' + number + '" class="add_tov_val_item parent">' +
                            '<div class="add_kurs_val_video_wrap parent">' +
                            '<a href="/administration/meal/' + number + '" class="add_tov_val_cont meal_cont parent">' +
                            '<div class="add_tov_val_h">' + name + '</div>' +
                            '<div class="add_tov_val_sh">' +
                            '   <div class="meal_wpfcc_wrap">' +
                            '<div class="meal_wpfcc">' +
                            '<div class="meal_wpfcc_title" short="В">Вес</div>' +
                            '<div class="meal_wpfcc_val">' + weight + '</div>' +
                            '</div>' +
                            '<div class="meal_wpfcc">' +
                            '<div class="meal_wpfcc_title" short="Б">Белки</div>' +
                            '<div class="meal_wpfcc_val">' + proteins + '</div>' +
                            '</div>' +
                            '<div class="meal_wpfcc">' +
                            '<div class="meal_wpfcc_title" short="Ж">Жиры</div>' +
                            '<div class="meal_wpfcc_val">' + fats + '</div>' +
                            '</div>' +
                            '<div class="meal_wpfcc">' +
                            '<div class="meal_wpfcc_title" short="У">Углеводы</div>' +
                            '<div class="meal_wpfcc_val">' + carbohydrates + '</div>' +
                            '</div>' +
                            '<div class="meal_wpfcc">' +
                            '<div class="meal_wpfcc_title" short="К">Калории</div>' +
                            '<div class="meal_wpfcc_val">' + calories + '</div>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</a>' +
                            '<div class="del_tov"></div>' +
                            '</div>' +
                            '<input type="hidden" name="id_meal[' + crs_day + '][' + crs_ingestion + '][]" value="' + number + '" id="id-meal-' + crs_day + '-' + crs_ingestion + '-' + number + '"/>' +
                            '</div>';

                    if(ml_type_block.length == 0)
                    {
                        add_tov_val.append('<div id="ml-type-' + crs_day + '-' + crs_ingestion + '-' + ml_type + '">' +
                            '<div class="kurs_block_h">' + ml_name + '</div>' +
                            '<div class="add_tov_val_item_wrap"></div>' +
                            '</div>');
                        ml_type_block = add_tov_val.children('#ml-type-' + crs_day + '-' + crs_ingestion + '-' + ml_type);
                        ml_block_wrap = ml_type_block.children('.add_tov_val_item_wrap');
                    }
                    if(ml_block.length == 0)
                    {
                        ml_block_wrap.append(ml_block_content);
                    }
                });
            }

            this_meal.parents(".add_tov_list").hide();
            this_meal.parents(".add_tov_list").parents('.add_tov_in').find('input:text').val('');
            this_meal.addClass("disable");
        }
        return false;
    });


    /* Добавление фото */
    $(".add_new_foto_but").click(function() {
        var num = $(this).parents(".add_foto_block_wrap").find(".video_down_line").length + 1;
        if (num <= 7) {
            $(this).parents(".add_foto_block_wrap").find(".add_foto_block")
                .append('<div class="parent kurs_cur_wrap">' +
                    '<div class="kurs_block_h">Изображение № ' + num + ':</div>' +
                    '<div class="video_down_line parent">' +
                    '<div class="video_down_line_but_wrap">' +
                    '<label for="video_down_line_but' + num + 's" class="video_down_line_but">' +
                    '<input type="file" name="slider_files[]" class="admin_form_videofile" id="video_down_line_but' + num + 's" accept="image/jpeg,image/png" />' +
                    '<span>Выберите файл</span>' +
                    '</label>' +
                    '</div>' +
                    '<div class="video_down_line_name">Файл не выбран</div>' +
                    '<div class="progressbar_wrap"><progress class="progressbar" id="progressbar1" value="50" max="100"></progress></div>' +
                    '</div></div>');
        }
        if (num == 7) {
            $(this).hide();
        }
    });

    /* Добавление ингредиента */
    $(".add_new_ingredient").click(function() {
        var this_block = $(this).parents(".anketa_form_line");
        this_block.before('<div class="anketa_form_line parent ingredients">' +
            '<div class="anketa_form_h"><div class="anketa_form_h_cell"></div></div>' +
            '<input type="text" name="i_ingredient_name[]" value="" placeholder="Наименование" class="anketa_form_in" maxlength="255" style="width:180px;"/>' +
            '<input type="number" name="i_ingredient_weight[]" value="" placeholder="Вес" class="anketa_form_in in_tiny ingr_weight" maxlength="5" />' +
            '<input type="number" name="i_ingredient_proteins[]" value="" placeholder="Белки" class="anketa_form_in in_tiny ingr_proteins" maxlength="5" />' +
            '<input type="number" name="i_ingredient_fats[]" value="" placeholder="Жиры" class="anketa_form_in in_tiny ingr_fats" maxlength="5" />' +
            '<input type="number" name="i_ingredient_carbohydrates[]" value="" placeholder="Углеводы" class="anketa_form_in in_tiny ingr_carbohydrates" maxlength="5" />' +
            '<input type="number" name="i_ingredient_calories[]" value="" placeholder="Калории" class="anketa_form_in in_tiny ingr_calories" maxlength="5" />' +
            '</div>');
    });

    /* Добавление видео блока */
    $(".add_new_ml_videos_block").click(function() {
        var this_block = $(this).parents(".anketa_form_line");
        this_block.before('<div class="anketa_form_line parent ml_videos_block">' +
            '<div class="anketa_form_h"><div class="anketa_form_h_cell"></div></div>' +
            '<input name="ta_videos_block[]" class="anketa_form_in anketa_form_in_long" placeholder="URL видео" />' +
            '</div>');
    });
});
