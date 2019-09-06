$(document).ready(function(){
    tinymce.init({
        selector: "textarea.formatted_textarea",
        menubar: false,
        statusbar: false,
        theme: 'silver',
        language_url : '/js/tinymce/langs/ru.js',
        plugins: "textcolor colorpicker bbcode",
        toolbar: "undo redo | bold italic | forecolor",
        max_chars_indicator: "pageLength"
    });
    if($('.kurs_block_val').length > 0 && $('.content_block_container').length > 0)
    {
        $(function(){
            var winHeight = $(window).height(),
                fxTopCont = $('.content_block_container'),
                fxTopContWrap = $('.content_block_container_wrap'),
                parTopContWidth = fxTopContWrap.outerWidth(),
                parTopContHeight = fxTopContWrap.outerHeight(),
                fxButCont = $('.admin_form_buts_wrap'),
                fxButContWrap = $('.admin_form_buts_wrap_container'),
                fxButContHeight = fxButCont.outerHeight(),
                parButContWidth = fxButContWrap.outerWidth(),
                topPos = fxTopCont.offset().top,
                butTopHeight = fxTopCont.outerHeight() + fxButContHeight;
            $(window).scroll(function() {
                var top = $(document).scrollTop();

                if (top > topPos && winHeight > 500 && butTopHeight < 250)
                {
                    fxTopCont.addClass('fixed');
                    fxTopCont.width(parTopContWidth);
                    fxTopContWrap.height(parTopContHeight);
                    if(fxButCont.length === 1)
                    {
                        fxButCont.addClass('fixed');
                        fxButContWrap.height(fxButContHeight);
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
    }

    // Скрыть/отобразить блок добавления промокода
    $('#extends-promocode').on('change', function(){
        var bl_pc_sett = $('#bl-pc-sett');
        if($(this).val() === 'new')
        {
            bl_pc_sett.show();
        }
        else {
            bl_pc_sett.hide();
        }
    });

    /* Добавление опции */

    $(".add_new_options_but.add_form_advantage").click(function() {
        $(this).parents(".lend_form_options_wrap").find(".lend_form_options")
            .append('<div class="parent kurs_cur_wrap">' +
                '<div class="kurs_block_h">Преимущество:</div>' +
                '<input type="text" name="i_advantages_block6[]" class="admin_form_txt admin_form_txt_middle" value="" maxlength="70"/>' +
                '</div>');
        addInfoOfRemainingCharacters();
    });

    $(".add_new_options_but.add_form_plan").click(function() {
        var num = $(this).parents(".lend_form_options_wrap").find(".lend_form_option").length + 1;

        $(this).parents(".lend_form_options_wrap").find(".lend_form_options")
            .append('<div class="lend_form_option">' +
                '<div class="tren_set_form_l">' +
                    '<div class="tren_set_form_img"><img src="/img/no_img.png" alt=""></div>' +
                '</div>' +
                '<div class="tren_set_form_r">' +
                    '<div class="tren_form_block_check_wrap">' +
                        '<input type="checkbox" name="cb_images_block7[]" checked="checked" class="tren_form_block_check" id="tren_form_block_check15e'+num+'" />' +
                        '<label for="tren_form_block_check15e'+num+'">Изображение по умолчанию</label>' +
                    '</div>' +
                    '<div class="parent kurs_cur_wrap" style="max-height: 72px">' +
                    '<div class="kurs_block_h">' +
                        'Изображение:' +
                        '<div class="h_subtitle">(285х285)</div>' +
                    '</div>' +
                    '<div class="video_down_line parent">' +
                    '<div class="video_down_line_but_wrap">' +
                    '<label for="video_down_line_but'+num+'p" class="video_down_line_but">' +
                    '<input type="file" name="files_block7[]" class="admin_form_videofile" id="video_down_line_but'+num+'p">' +
                    '<span>Выберите файл</span>' +
                    '</label>' +
                    '</div>' +
                    '<div class="video_down_line_name">Файл не выбран</div>' +
                    '</div></div>' +
                    '<div class="parent kurs_cur_wrap">' +
                    '<div class="kurs_block_h">Текст плана:</div>' +
                    '<input type="text" name="i_text_block7[]" class="admin_form_txt admin_form_txt_middle" maxlength="160" />' +
                    '</div>' +
                    '</div>' +
                '</div>');
        addInfoOfRemainingCharacters();
        if(num === 4)
        {
            $(".add_new_options_but.add_form_plan").hide();
        }
    });

    /* Добавление информации об остаточном кол-ве символов для ввода */
    if($('form.landing_admin_form').length === 1)
    {
        addInfoOfRemainingCharacters();
    }

    // Значение прозрачности landing блока
    $('.land_block_opacity').on('input change', function(){
        var i_this = $(this),
            val_span = i_this.next('.land_block_opacity_val');
        if(val_span.length === 1)
        {
            var value_length = i_this.val();
            val_span.val(value_length);
        }
    });

    // Выбор фонового цвета блока landing page
    var colorselector = $('.colorselector');
    if (colorselector.length > 0) {
        var widt = true;
        colorselector.on('click', function () {
            var parent = $(this).parent('#customWidget'),
                parent_child = parent.find('.colorpickerholder2'),
                color = parent.parent('.bg_color').find('#block_bg_color').val();

            if (color === '' || color.substr(1, 1) !== '#') {
                color = '#00bff0';
            }

            if (parent_child.is(':visible')) {
                parent_child.hide();
            } else {
                $('.colorpickerholder2').hide();
                parent_child.show();
                widt = !widt;
            }

            parent_child.ColorPicker({
                flat: true,
                color: color,
                onChange: function (hsb, hex, rgb) {
                    if ($(this).is(':visible')){
                        var color_selector = $(this).parent('.colorpickerholder2').parent('#customWidget').find('.colorselector div'),
                            input_bg = $(this).parent('.colorpickerholder2').parent('#customWidget').parent('.bg_color').find('#block_bg_color');

                        color_selector.css('backgroundColor', '#' + hex);
                        input_bg.val('#' + hex);
                        $(this).ColorPickerSetColor('#' + hex);
                    }
                },
                onSubmit: function (hsb, hex, rgb, el) {
                    var color_selector = $(el).parent('#customWidget').find('.colorselector div');

                    color_selector.css('backgroundColor', 'transparent');
                }
            });
        });
    }

    // Добавление информции о доступном кол-ве символов для ввода
    function addInfoOfRemainingCharacters()
    {
        var input_text = $('input[type=text]');

        input_text.each(function(){
            if($(this).prop('name') !== 'i_old_price_block8' && $(this).prop('name') !== 'i_new_price_block8' &&
                $(this).parent('.subscribe_form_in_wrap').length === 0)
            {
                var i_this = $(this),
                    max_length = i_this.attr('maxLength'),
                    value_length = i_this.val().length,
                    remaining_length = max_length - value_length;
                if(max_length > 0 && remaining_length >= 0 && i_this.next('.remaining_characters').length === 0)
                {
                    i_this.after('<span class="remaining_characters">' + remaining_length + '</span>');
                }
            }
        });

        input_text.on('keyup', function(){
            var i_this = $(this),
                rmc_span = i_this.next('.remaining_characters');
            if(rmc_span.length === 1)
            {
                var max_length = i_this.attr('maxLength'),
                    value_length = i_this.val().length,
                    remaining_length = max_length - value_length;
                if(max_length > 0 && remaining_length >= 0)
                {
                    rmc_span.html(remaining_length);
                }
            }
        });
    }

    /* Отображение и скрытие полей блюда и продукта соответственно */
    var meal_category = $('#meal-category');
    if(meal_category.length == 1)
    {
        meal_category.on('change', function(){
            var ingr_desc = $('#meal-ingredients-desc'),
                ingrs = $('.ingredients'),
                add_ingr = $('#meal-add-ingredient'),
                video_block = $('.ml_videos_block'),
                add_video = $('#meal-add-video'),
                videos = $('#meal-videos');
            if($(this).val() == 2)
            {
                ingr_desc.hide();
                ingrs.hide();
                add_ingr.hide();
                video_block.hide();
                add_video.hide();
                videos.hide();
            }
            else
            {
                ingr_desc.show();
                ingrs.show();
                add_ingr.show();
                video_block.show();
                add_video.show();
                videos.show();
            }
        });
    }

    /* Расчет итоговых КБЖУ блюда/продукта */
    /*$(".anketa_form .ingredients :input").on('keyup mouseup', function(){
        var total_weight        = 0,
            total_proteins      = 0,
            total_fats          = 0,
            total_carbohydrates = 0,
            total_calories      = 0,
            meal_weight         = $("#meal-weight"),
            meal_proteins       = $("#meal-proteins"),
            meal_fats           = $("#meal-fats"),
            meal_carbohydrates  = $("#meal-carbohydrates"),
            meal_calories       = $("#meal-calories");

        $(".ingredients").each(function(){
            var weight        = $(this).children(".ingr_weight").val(),
                proteins      = $(this).children(".ingr_proteins").val(),
                fats          = $(this).children(".ingr_fats").val(),
                carbohydrates = $(this).children(".ingr_carbohydrates").val(),
                calories      = $(this).children(".ingr_calories").val();

            if(weight == "") weight = 0;
            if(proteins == "") proteins = 0;
            if(fats == "") fats = 0;
            if(carbohydrates == "") carbohydrates = 0;
            if(calories == "") calories = 0;

            total_weight        = total_weight + parseFloat(weight);
            total_proteins      = total_proteins + parseFloat(proteins);
            total_fats          = total_fats + parseFloat(fats);
            total_carbohydrates = total_carbohydrates + parseFloat(carbohydrates);
            total_calories      = total_calories + parseFloat(calories);
        });

        if(meal_weight.val() < total_weight) meal_weight.val(total_weight);
        if(meal_proteins.val() < total_proteins) meal_proteins.val(total_proteins);
        if(meal_fats.val() < total_fats) meal_fats.val(total_fats);
        if(meal_carbohydrates.val() < total_carbohydrates) meal_carbohydrates.val(total_carbohydrates);
        if(meal_calories.val() < total_calories) meal_calories.val(total_calories);
    });*/

    /* Подсчет итоговых значений ВКБЖУ */
    $(".meal_wpfcc_val :input").on('keyup', function(){
        var meal_calories_100      = $("#meal-calories-100"),
            meal_proteins_100      = $("#meal-proteins-100"),
            meal_fats_100          = $("#meal-fats-100"),
            meal_carbohydrates_100 = $("#meal-carbohydrates-100"),
            total_proteins      = 0,
            total_fats          = 0,
            total_carbohydrates = 0,
            total_calories      = 0,
            total_weight        = 0,
            meal_weight            = $("#meal-weight"),
            meal_proteins          = $("#meal-proteins"),
            meal_fats              = $("#meal-fats"),
            meal_carbohydrates     = $("#meal-carbohydrates"),
            meal_calories          = $("#meal-calories");

        if(meal_category.val() == 2 && meal_weight.val() > 0)
        {
            var koef = 1;
            koef = meal_weight.val() / 100;
            total_proteins      = parseFloat(koef) * parseFloat(meal_proteins_100.val());
            total_fats          = parseFloat(koef) * parseFloat(meal_fats_100.val());
            total_carbohydrates = parseFloat(koef) * parseFloat(meal_carbohydrates_100.val());
            total_calories      = parseFloat(koef) * parseFloat(meal_calories_100.val());

            meal_proteins.val(total_proteins.toFixed(2));
            meal_fats.val(total_fats.toFixed(2));
            meal_carbohydrates.val(total_carbohydrates.toFixed(2));
            meal_calories.val(total_calories.toFixed(2));
        }
        else if(meal_category.val() == 1)
        {
            calcWCPFC();
        }
    });
    $('.ingredients').on('keyup', ':input.ingr_weight', function()
    {
        if(meal_category.val() == 1)
        {
            calcWCPFC();
            $('#meal-calories-100').prop('readonly', true);
            $('#meal-proteins-100').prop('readonly', true);
            $('#meal-fats-100').prop('readonly', true);
            $('#meal-carbohydrates-100').prop('readonly', true);
            $('#meal-weight').prop('readonly', true);
        }
    });

    function calcWCPFC(total_weight, total_calories, total_proteins, total_fats, total_carbohydrates, calories_100,
                       proteins_100, fats_100, carbohydrates_100)
    {
        total_weight = total_weight || 0;
        total_calories = total_calories || 0;
        total_proteins = total_proteins || 0;
        total_fats = total_fats || 0;
        total_carbohydrates = total_carbohydrates || 0;
        calories_100 = calories_100 || 0;
        proteins_100 = proteins_100 || 0;
        fats_100 = fats_100 || 0;
        carbohydrates_100 = carbohydrates_100 || 0;

        var count_ingr = 0,
            meal_weight        = $("#meal-weight"),
            meal_proteins      = $("#meal-proteins"),
            meal_fats          = $("#meal-fats"),
            meal_carbohydrates = $("#meal-carbohydrates"),
            meal_calories      = $("#meal-calories"),
            ingrs_data         = $(".ingredients_data");

        ingrs_data.each(function(){
            var weight        = $(this).find(".ingr_weight").val(),
                proteins      = $(this).find(".ingr_proteins").html(),
                fats          = $(this).find(".ingr_fats").html(),
                carbohydrates = $(this).find(".ingr_carbohydrates").html(),
                calories      = $(this).find(".ingr_calories").html(),
                koef = 0;

            if(weight == "") weight = 0;
            if(proteins == "") proteins = 0;
            if(fats == "") fats = 0;
            if(carbohydrates == "") carbohydrates = 0;
            if(calories == "") calories = 0;

            if(weight > 0)
            {
                koef = weight / 100;

                total_weight        = total_weight + parseFloat(weight);

                total_proteins      = total_proteins + (parseFloat(proteins)*koef);
                total_fats          = total_fats + (parseFloat(fats)*koef);
                total_carbohydrates = total_carbohydrates + (parseFloat(carbohydrates)*koef);
                total_calories      = total_calories + (parseFloat(calories)*koef);
            }

            count_ingr++;
        });

        if(total_weight == 0 && count_ingr > 0)
        {
            total_weight = 100 * count_ingr;

            ingrs_data.each(function(){
                var proteins      = $(this).find(".ingr_proteins").html(),
                    fats          = $(this).find(".ingr_fats").html(),
                    carbohydrates = $(this).find(".ingr_carbohydrates").html(),
                    calories      = $(this).find(".ingr_calories").html();

                if(proteins == "") proteins = 0;
                if(fats == "") fats = 0;
                if(carbohydrates == "") carbohydrates = 0;
                if(calories == "") calories = 0;


                total_proteins      = total_proteins + parseFloat(proteins);
                total_fats          = total_fats + parseFloat(fats);
                total_carbohydrates = total_carbohydrates + parseFloat(carbohydrates);
                total_calories      = total_calories + parseFloat(calories);
            });
        }

        var koef_100 = 1;

        if(total_weight < 100)
        {
            koef_100 = 100 / total_weight;

            calories_100      = total_calories * koef_100;
            proteins_100      = total_proteins * koef_100;
            fats_100          = total_fats * koef_100;
            carbohydrates_100 = total_carbohydrates * koef_100;
        }
        else
        {
            koef_100 = total_weight / 100;

            calories_100      = total_calories / koef_100;
            proteins_100      = total_proteins / koef_100;
            fats_100          = total_fats / koef_100;
            carbohydrates_100 = total_carbohydrates / koef_100;
        }

        meal_weight.val(total_weight.toFixed(2));
        meal_proteins.val(total_proteins.toFixed(2));
        meal_fats.val(total_fats.toFixed(2));
        meal_carbohydrates.val(total_carbohydrates.toFixed(2));
        meal_calories.val(total_calories.toFixed(2));

        $("#meal-proteins-100").val(proteins_100.toFixed(2));
        $("#meal-fats-100").val(fats_100.toFixed(2));
        $("#meal-carbohydrates-100").val(carbohydrates_100.toFixed(2));
        $("#meal-calories-100").val(calories_100.toFixed(2));


        var return_array = {
            r_total_weight: total_weight,
            r_total_calories: total_calories,
            r_total_proteins: total_proteins,
            r_total_fats: total_fats,
            r_total_carbohydrates: total_carbohydrates,
            r_calories_100: calories_100,
            r_proteins_100: proteins_100,
            r_fats_100: fats_100,
            r_carbohydrates_100: carbohydrates_100
        };

        return(return_array);
    }

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
        var pr_bl_w   = $('.practice_block_wrap'),
            pr_bl     = $('.practice_block'),
            pr_d      = $('.practice_day'),
            this_pr_d = $(this),
            pr_id     = $(this).attr('id').substr(8),
            pr_block  = $('#' + $(this).attr('id') + '_block');

        if ($(this).hasClass("active"))
        {
            $(this).removeClass('active');
            if(pr_bl_w.length === 1)
            {
                pr_bl.hide();
            }
        }
        else
        {
            pr_d.removeClass("active");
            $(this).addClass("active");

            if(pr_bl_w.length === 1)
            {
                pr_bl.hide();
                pr_bl.css("margin-top", $(this).position().top+'px');
                //pr_block.show();
                pr_block.fadeIn(200);
            }
        }
    });

    // Формирование расписания питания
    $(".nutrition_block_table").on('click', '.nutrition_day', function(event){
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

    /*$(".landing_block_table").on('click', '.landing_blocks', function(){
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
    });*/

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

    /* выпадающий список продуктов/ингредиентов */
    $(document).on('input', '.add_tov_in.ingredient input:text', function () {
        var tov_in = $(this),
            input_search = tov_in.val();
        if(input_search != '' && input_search.length >= 3 && input_search.length < 255){
            $.ajax({
                url: '/searchIngredients',
                type: 'post',
                dataType: 'json',
                data: {search_text: input_search},
                complete: function (result) {
                    var data = result.responseJSON;
                    if(data)
                    {
                        tov_in.parents(".add_tov_in.ingredient").find(".add_tov_list").html(data.ingredients);
                        tov_in.parents(".add_tov_in.ingredient").find(".add_tov_list").show();
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
    $(document).on('input', '.add_tov_in.coaches input:text', function () {
        if($(this).val() != '' && $(this).val().length < 255){
            var input_search = $(this).val(),
                tov_in = $(this);
            $.ajax({
                url: '/searchCoaches',
                type: 'post',
                dataType: 'json',
                data: {search_text: input_search},
                complete: function (result) {
                    var data = result.responseJSON;
                    tov_in.parents(".add_tov_in").find(".add_tov_list").html(data.coaches);
                    tov_in.parents(".add_tov_in").find(".add_tov_list").show();
                }
            });
        } else{
            $(this).parents(".add_tov_in").find(".add_tov_list").hide();
        }
    });

    /* выпадающий список курсов */
    $(document).on('input', '.add_tov_in.pc_course input:text', function () {
        if($(this).val() !== '' && $(this).val().length < 255){
            var input_search = $(this).val(),
                tov_in = $(this);
            $.ajax({
                url: '/searchCourses',
                type: 'post',
                dataType: 'json',
                data: {search_text: input_search},
                complete: function (result) {
                    var data = result.responseJSON;
                    tov_in.parents(".add_tov_in").find(".add_tov_list").html(data.courses);
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
                        '<input type="hidden" name="coaches['+number+']" value="'+number+'" />' +
                        '<input type="text" name="coaches_percent['+number+']" class="admin_form_txt coaches_percent" placeholder="0" value=""/>' +
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

    $(document).on('input', '.coaches_percent', function(){
        var coaches_percent = $('.coaches_percent'),
            site_info = $('#site-percent'),
            sum_percent = 0, site_percent = 0;

        coaches_percent.each(function(){
            if((sum_percent + parseFloat($(this).val())) > 100)
            {
                $(this).val(100 - sum_percent);
                sum_percent = 100;
                return false;
            }

            sum_percent = sum_percent + parseFloat($(this).val());
        });
        if(!sum_percent)
        {
            sum_percent = 0;
        }
        site_percent = 100 - parseFloat(sum_percent);
        if(site_percent > 0)
        {
            site_percent = site_percent + '%';
        }
        else
        {
            site_percent = 'Заработок отсутствует!';
        }
        if(site_info.length == 0)
        {
            coaches_percent.parents('.add_tov_in_total').after('<div class="parent kurs_cur_wrap">' +
            '<div class="kurs_block_h">Процент сайта:</div>' +
            '<div id="site-percent"></div>' +
            '</div>');
            site_info = $('#site-percent');
        }
        site_info.html(site_percent);
    });

    $(document).on('click', '.del_tov', function () {
        var id = $(this).parents(".add_tov_val_item").attr("id"),
            video_id = $(this).parents(".add_tov_in_total").children("#id-video"+parseFloat(id)),
            inst_id = $(this).parents(".add_tov_in_total").children("#id-video-instruction"),
            ml_type_block = $(this).parents(".add_tov_val_item").parent(),
            meal_block = $("#" + id),
            course_block = $("#" + id + ".pc_course");

        if (video_id.length == 1 || inst_id.length == 1)
        {
            $(this).parents(".add_tov_in_total").find("#"+id).removeClass("disable");
            $(this).parents(".add_tov_val_item").remove();
            video_id.val('');
            inst_id.val('');
        }
        else if(course_block.length === 1)
        {
            course_block.remove();
        }
        // Удалить блок блюда
        else if(meal_block.length == 1)
        {
            meal_block.remove();

            // Удалить блок категории блюда
            if(ml_type_block.find('.add_tov_val_item').length == 0)
            {
                ml_type_block.remove();
            }
        }
        // Пересчет ВКБЖУ
        else if($(this).parents('.ingredients_data').length == 1)
        {
            calcWCPFC();
            if($(".add_tov_in_total").children('.add_tov_val').length == 0)
            {
                $('#meal-calories-100').prop('readonly', false);
                $('#meal-proteins-100').prop('readonly', false);
                $('#meal-fats-100').prop('readonly', false);
                $('#meal-carbohydrates-100').prop('readonly', false);
                $('#meal-weight').prop('readonly', false);
            }
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

    $(document).on('click', '.add_tren_item.meal', function (event) {
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

    $(document).on('click', '.add_tren_item.ingredient', function (event) {
        event.preventDefault();
        if(!$(this).hasClass("disable")){
            var this_meal = $(this),
                link = this_meal.find(".add_tov_cont").attr("href"),
                name = this_meal.data('meal-name'),
                number = this_meal.data('meal-id'),
                weight = this_meal.data('weight'),
                proteins = this_meal.data('proteins'),
                fats = this_meal.data('fats'),
                carbohydrates = this_meal.data('carbohydrates'),
                calories = this_meal.data('calories'),
                add_tov_val = this_meal.parents(".add_tov_in_total").find('.add_tov_val'),
                ml_block_content = '<div id="ingredient-' + number + '" class="add_tov_val_item parent ingredients_data">' +
                    '<div class="add_kurs_val_video_wrap parent">' +
                        '<div class="add_tov_val_cont meal_cont parent">' +
                            '<div class="add_tov_val_h"><a href="/administration/meal/' + number + '">' + name + '</a></div>' +
                            '<div class="add_tov_val_sh">' +
                            '   <div class="meal_wpfcc_wrap">' +
                                    '<div class="meal_wpfcc">' +
                                        '<div class="meal_wpfcc_title" short="В">Вес</div>' +
                                        '<div class="meal_wpfcc_val"><input type="number" name="i_ingredient_weight[' + number + ']" value="" placeholder="0.00" class="anketa_form_in in_fill ingr_weight" required="required"/></div>' +
                                    '</div>' +
                                    '<div class="meal_wpfcc">' +
                                        '<div class="meal_wpfcc_title" short="К">Калории</div>' +
                                        '<div class="meal_wpfcc_val ingr_calories">' + calories + '</div>' +
                                    '</div>' +
                                    '<div class="meal_wpfcc">' +
                                        '<div class="meal_wpfcc_title" short="Б">Белки</div>' +
                                        '<div class="meal_wpfcc_val ingr_proteins">' + proteins + '</div>' +
                                    '</div>' +
                                    '<div class="meal_wpfcc">' +
                                        '<div class="meal_wpfcc_title" short="Ж">Жиры</div>' +
                                        '<div class="meal_wpfcc_val ingr_fats">' + fats + '</div>' +
                                    '</div>' +
                                    '<div class="meal_wpfcc">' +
                                        '<div class="meal_wpfcc_title" short="У">Углеводы</div>' +
                                        '<div class="meal_wpfcc_val ingr_carbohydrates">' + carbohydrates + '</div>' +
                                    '</div>' +
                                '</div>' +
                            '</div>' +
                        '</div>' +
                        '<div class="del_tov"></div>' +
                    '</div>' +
                '</div>';

            if(add_tov_val.length == 0)
            {
                this_meal.parents(".add_tov_in_total").append('<div class="add_tov_val"></div>');
                add_tov_val = this_meal.parents(".add_tov_in_total").find('.add_tov_val');
            }
            if(add_tov_val.children('#ingredient-' + number).length == 0)
            {
                add_tov_val.append(ml_block_content);
            }

            calcWCPFC();

            this_meal.parents(".add_tov_list").hide();
            this_meal.parents(".add_tov_list").parents('.add_tov_in').find('input:text').val('');
            this_meal.addClass("disable");
        }
        return false;
    });

    $(document).on('click', '.add_tren_item.pc_course', function () {
        if(!$(this).hasClass("disable")){
            var link = $(this).find(".add_tov_cont").attr("href"),
                name = $(this).find(".add_tov_h").text(),
                number = $(this).attr("id"),
                parent_block = $(this).parents(".add_tov_in_total").find(".add_tov_val"),
                crsid = $(this).data('crsid');

            if(parent_block.find('#'+number+'course').length === 0)
            {
                parent_block.append('<div id="'+number+'course" class="add_tov_val_item pc_course parent">' +
                    '<div class="add_kurs_val_video_wrap parent">' +
                        '<a href="'+link+'" class="add_tov_val_cont parent"><span class="add_tov_val_h">'+name+'</span></a>' +
                        '<input type="hidden" name="pc_courses[]" value="'+crsid+'" >' +
                        '<div class="del_tov"></div>' +
                    '</div>' +
                    '</div>');
            }
            $(this).parents(".add_tov_list").hide();
            $(this).parents(".add_tov_list").parents('.add_tov_in').find('input:text').val('');
            $(this).addClass("disable");
        }
        return false;
    });

    $('select[name=s_discount_type]').on('change', function(){
        var type = $(this).val(),
            pcrp = $('#pc-relative-percent');

        if(type === 'currency')
        {
            pcrp.show();
        }
        else
        {
            pcrp.hide();
        }
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


    var tov = $('.tov');
    tov.on('click', '.shop_block_nav #prev_page', function (event) {
        event.preventDefault();

        var first_id = $('#i_first_id').val(),
            first_price = $('#i_first_price').val(),
            first_discount = $('#i_first_discount').val();

        searchAProducts(first_id, first_price, first_discount, null, null, null);
    });
    tov.on('click', '.shop_block_nav #next_page', function (event) {
        event.preventDefault();

        var last_id = $('#i_last_id').val(),
            last_price = $('#i_last_price').val(),
            last_discount = $('#i_last_discount').val();

        searchAProducts(null, null, null, last_id, last_price, last_discount);
    });

    var notif_block = $('.notif_block');
    notif_block.on('click', '.shop_block_nav #prev_page', function (event)
    {
        event.preventDefault();

        var first_id = $('#i_first_id').val();

        searchNotifications(first_id, null);
    });
    notif_block.on('click', '.shop_block_nav #next_page', function (event)
    {
        event.preventDefault();

        var last_id = $('#i_last_id').val();

        searchNotifications(null, last_id);
    });

    $('select[name=s_section]').on('change', function(){
        var section_id  = $(this).val(),
            subsection  = $('#subsection-' + section_id),
            subsections = $('.subsections');

        subsections.hide();
        if(subsection.length === 1)
        {
            subsections.hide();
            subsection.show();
        }
    });

    /**
     * Поиск товаров
     * @param first_id
     * @param first_price
     * @param first_discount
     * @param last_id
     * @param last_price
     * @param last_discount
     */
    function searchAProducts(first_id, first_price, first_discount, last_id, last_price, last_discount)
    {
        var tov_block = $(".admin_list.tov_list");
        $.ajax({
            url: '/getSearchProducts',
            type: 'post',
            dataType: 'json',
            data: {
                first_id: first_id,
                first_price: first_price,
                first_discount: first_discount,
                last_id: last_id,
                last_price: last_price,
                last_discount: last_discount},
            complete: function (result) {
                var data = result.responseJSON;
                if (data.products != "false")
                {
                    tov_block.html(data.products);
                    tov_block.next("#pagination").remove();
                    tov_block.after(data.pagination);
                }
                else
                {
                    tov_block.html("<br/>К сожалению, по Вашему запросу ни чего не найдено.");
                }
            }
        });
    }

    /**
     * Поиск уведомлений
     * @param first_id
     * @param first_price
     * @param first_discount
     * @param last_id
     * @param last_price
     * @param last_discount
     */
    function searchNotifications(first_id, last_id)
    {
        var notif_block = notif_block.find(".admin_list");
        $.ajax({
            url: '/getSearchNotifications',
            type: 'post',
            dataType: 'json',
            data: {
                first_id: first_id,
                last_id: last_id},
            complete: function (result) {
                var data = result.responseJSON;
                if (data.notif != "false")
                {
                    notif_block.html(data.notif);
                    notif_block.next("#pagination").remove();
                    notif_block.after(data.pagination);
                }
                else {
                    notif_block.html("<br/>К сожалению, по Вашему запросу ни чего не найдено.");
                }
            }
        });
    }
});
