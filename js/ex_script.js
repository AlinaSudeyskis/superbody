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
        if(!$(this).hasClass("disable")){
            var link = $(this).find(".add_tov_cont").attr("href"),
                name = $(this).data('meal-name'),
                number = $(this).data('meal-id'),
                crs_day = $(this).data('day'),
                crs_ingestion = $(this).data('ingestion'),
                ml_type = $(this).data('ml-type'),
                ml_name = $(this).data('ml-name'),
                weight = $(this).data('weight'),
                proteins = $(this).data('proteins'),
                fats = $(this).data('fats'),
                carbohydrates = $(this).data('carbohydrates'),
                calories = $(this).data('calories'),
                add_tov_val = $(this).parents(".add_tov_in_total").find('.add_tov_val'),
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
            $(this).parents(".add_tov_list").hide();
            $(this).parents(".add_tov_list").parents('.add_tov_in').find('input:text').val('');
            $(this).addClass("disable");
        }
        return false;
    });
});
