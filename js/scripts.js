/**
 * @author Alina Sudeyskis <alina.sudeyskis@gmail.com>
 */
$(document).ready(function() {
    jQuery(
        function($) {
            $(".date").mask("00.00.0000", {placeholder: "дд.мм.гггг"});
            $(".height").mask("000");
            $('.money').mask('0000000.00', {reverse: true});
            $('.percent').mask('000.00', {reverse: true});
            $('.int').mask('0#');
            $('.time').mask('Hh:Mm', {
                translation: {
                    'H': {
                        pattern: /[0-2]/, optional: true
                    },
                    'h': {
                        pattern: /[0-9]/, optional: true
                    },
                    'M': {
                        pattern: /[0-5]/, optional: true
                    },
                    'm': {
                        pattern: /[0-9]/, optional: true
                    }
                }, placeholder: "чч:мм"
            });
            var fb_chat = $('.feedback_chat');
            if (fb_chat.length > 0) {
                fb_chat.scrollTop(fb_chat[0].scrollHeight);
            }
            var chat = $('.mess_block_line_wrap ');
            if (chat.length > 0) {
                chat.scrollTop(chat[0].scrollHeight);
            }/**/


            // Валидация email
            var email_error = $('.email_error'),
                timer;
            $('.valid_email').keyup(function() {
                var email_block = $(this),
                    e_p = email_block.position(),
                    email_error = email_block.next('.email_error');

                clearTimeout(timer);

                if(email_error.length == 0)
                {
                    $(this).after('<div class="email_error"></div>');
                    email_error = email_block.next('.email_error');
                    email_error.offset({top:e_p.top-20, left:(e_p.left+email_block.outerWidth(true)-30-parseInt(email_block.css('margin-right')))});
                }

                if($(this).val() != '')
                {
                    var pattern = /^([a-z0-9_\.-])+@[a-z0-9-]+\.([a-z]{2,4}\.)?[a-z]{2,4}$/i;

                    if(!pattern.test($(this).val()))
                    {
                        timer = setTimeout(function() {
                            email_error.text('Некорректный Email');
                            email_error.show();
                        }, 500);
                    }
                    else{email_error.hide();}
                }
                else
                {
                    timer = setTimeout(function() {
                        email_error.text('Поле Email не должно быть пустым');
                        email_error.show();
                    }, 500);
                }
            });

            // Генерация промокода
            $("#generate-code").on('click', function(){
                var result       = '',
                    words        = '0123456789QWERTYUIOPASDFGHJKLZXCVBNM',
                    max_position = words.length - 1,
                    position     = 0;
                for( var i = 0; i < 6; ++i ) {
                    position = Math.floor ( Math.random() * max_position );
                    result = result + words.substring(position, position + 1);
                }
                $("#generated-code").val(result);
            });

            // Блок информации
            var block_message = $('#block-message');
            if (block_message.length > 0 && block_message.hasClass('show')) {
                var parent = block_message.parent();
                block_message.css("left", ((parent.outerWidth() / 2) - (block_message.outerWidth() / 2)));
                setTimeout(function(){
                    block_message.show();
                    block_message.animate({"top": "+=40px"}, "slow");
                },500);
                setTimeout(function(){block_message.animate({"top": "-=40px"}, "slow")},10000);
                setTimeout(function(){block_message.hide()},10500);
            }

            $(document).on('input', '.add_tov_in.users input:text', function () {
                if($(this).val() != '' && $(this).val().length > 3 && $(this).val().length < 255){
                    var input_search = $(this).val(),
                        tov_in = $(this);
                    $.ajax({
                        url: '/searchUsers',
                        type: 'post',
                        data: {search_text: input_search},
                        complete: function (result) {
                            if (result != "") {
                                tov_in.parents(".add_tov_in").find(".add_tov_list").show();
                                tov_in.parents(".add_tov_in").find(".add_tov_list").html(result.responseText);
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
            $(document).on("click", ".user.add_tren_item", function() {
            if(!$(this).hasClass("disable")){
                var link = $(this).find(".add_tov_cont").attr("href"),
                    name = $(this).find(".add_tov_h").text(),
                    number = $(this).attr("id");

                $(this).parents(".add_tov_in_total").find(".add_tov_val")
                        .append('<div id="'+number+'tov" class="add_tov_val_item parent">' +
                            '<input type="hidden" name="users[]" value="' + number + '"/>' +
                            '<a href="'+link+'" class="add_tov_val_cont parent"><span class="add_tov_val_h">'+name+'</span></a>' +
                            '<div class="add_tov_val_sale user">' +
                            '<div class="del_tov"></div></div>');

                $(this).parents(".add_tov_list").hide();
                $(this).parents(".add_tov_list").parents('.add_tov_in.admins').find('input:text').val('');
                $(this).addClass("disable");
            }
            return false;
        });

            // Сложность пароля, подтверждение пароля
            var old_pass = $('#old-pass'),
                new_pass = $('#new-pass'),
                confirm_pass = $('#confirm-pass');

            new_pass.on('keyup', function () {
                var strongRegex = new RegExp("^(?=.{8,})(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*\\W).*$", "g"),
                    mediumRegex = new RegExp("^(?=.{8,})(((?=.*[A-Z])(?=.*[a-z]))|((?=.*[A-Z])(?=.*[0-9]))|((?=.*[a-z])(?=.*[0-9]))).*$", "g"),
                    enoughRegex = new RegExp("(?=.{8,}).*", "g"),
                    pass_info = $(this).parents('.new_pass').find('#pass-info');

                pass_info.hide();

                if (false == enoughRegex.test($(this).val())) {
                    pass_info.html('Пароль должен быть не менее 8 символов');
                    pass_info.show();
                } else if (strongRegex.test($(this).val())) {
                    pass_info.html('Надежный пароль');
                    pass_info.show();
                } else if (mediumRegex.test($(this).val())) {
                    pass_info.html('Пароль средней сложности');
                    pass_info.show();
                } else {
                    pass_info.html('');
                }
            });

            confirm_pass.on('keyup', function(){
            var pass_info = $(this).parents('.confirm_pass').find('#pass-info');

            pass_info.hide();

            if (new_pass.val() != '' && confirm_pass.val() != new_pass.val()) {
                pass_info.html('Не совпадает');
                pass_info.show();
            }
            else if (confirm_pass.val() == new_pass.val()) {
                pass_info.html('Совпадает');
                pass_info.show();
            }
        });

            // Вывод полей добавления тренировки курса
            /*$('#count_days').keyup(function () {
                show_weeks();
            });

            $('#count_weeks').keyup(function () {
                show_weeks();
            });*/

            // Скрыть/Показать checkboxes дней тренировок
            $('#week_days').on("click", "input[type=checkbox]", function () {
                var count_rest = parseInt($('#count_rest').val()),
                    count_days = parseInt($('#count_days').val()),
                    checkboxes = $('input:checkbox:checked'),
                    next_element = $(this).parent(),
                    prev_element = $(this).parent(),
                    element = $(this).parent();


                if (checkboxes.length <= count_days)
                {
                    if ($(this).is(":checked"))
                    {
                        blockWeekDays(count_rest, next_element, prev_element, element)
                    }
                    else
                    {
                        // Разблокировать предыдущий и следующий checkbox.
                        next_element.nextUntil('.cb_week_day > input:checkbox:checked').children('input:checkbox:not(:checked)').prop('disabled', false);
                        prev_element.prevUntil('.cb_week_day > input:checkbox:checked').children('input:checkbox:not(:checked)').prop('disabled', false);
                    }

                    $('#week_days input:checkbox:checked').each(function (indx, elm)
                    {
                        next_element = $(this).parent();
                        prev_element = $(this).parent();

                        // Блокировать все остальные checkbox
                        if (checkboxes.length == count_days) {
                            $(this).parent().nextUntil('.cb_week_day > input:checkbox:checked').children('input:checkbox:not(:checked)').prop('disabled', true);
                            $(this).parent().prevUntil('.cb_week_day > input:checkbox:checked').children('input:checkbox:not(:checked)').prop('disabled', true);
                        }
                        else if (checkboxes.length < count_days)
                        {
                            blockWeekDays(count_rest, next_element, prev_element, element);
                        }
                    });
                    // Разблокировать checkbox
                    if (checkboxes.length == 0) {
                        $(this).parent().nextAll('.cb_week_day').children('input[type=checkbox]').prop('disabled', false);
                        $(this).parent().prevAll('.cb_week_day').children('input[type=checkbox]').prop('disabled', false);
                    }
                }
                else if (checkboxes.length > count_days) {
                    if ($(this).is(":checked")) {
                        $(this).prop('checked', false);
                    }
                }
            });

            $("input[type=checkbox]").on("click", function () {
                if ($(this).is(':checked')) {
                    $(this).parent().parent().parent().children(".days").hide();
                } else {
                    $(this).parent().parent().parent().children(".days").show();
                }
            });

            /* Расчет BMI и BMR */
            $('#height').keyup(function () {
                calcBmiBmr();
            });
            $('#height').on('change', function () {
                calcBmiBmr();
            });
            $('#weight').keyup(function () {
                calcBmiBmr();
            });
            $('select[name=b_day], select[name=b_mon], select[name=b_year]').change(function () {
                var b_day = $('select[name=b_day]').val(),
                    b_mon = $('select[name=b_mon]').val(),
                    b_year = $('select[name=b_year]').val();
                if(b_day != '' && b_mon != '' && b_year != '')
                {
                    $('#birthday').val(b_day + '.' + b_mon + '.' + b_year);
                    calcBmiBmr();
                }
            });
            $('input[name=gender]').click(function () {
                if($(this).val() == 1) $('#gender_male').attr('checked', false);
                else $('#gender_female').attr('checked', false);

                $(this).attr('checked', 'checked');
                calcBmiBmr();
            });

            // Загрузка видео и поста к нему
            $(function () {
                var progressBar = $('#progressbar2');
                $('#upload_file').on('change', function (e) {
                    e.preventDefault();
                    var that = $(this),
                        parent = that.parents('.down_line'),
                        formData = new FormData,
                        video_path = $('#video_path');

                    formData.append('upload_file', this.files[0]);
                    $.ajax({
                        url: '/upload/video',
                        type: 'post',
                        dataType: 'json',
                        contentType: false,
                        processData: false,
                        data: formData,
                        xhr: function () {
                            var xhr = $.ajaxSettings.xhr(); // получаем объект XMLHttpRequest

                            $('#progressbar2').show();

                            xhr.upload.addEventListener('progress', function (evt) { // добавляем обработчик события progress (onprogress)
                                if (evt.lengthComputable) { // если известно количество байт
                                    // высчитываем процент загруженного
                                    var percentComplete = Math.ceil(evt.loaded / evt.total * 100);
                                    // устанавливаем значение в атрибут value тега <progress>
                                    // и это же значение альтернативным текстом для браузеров, не поддерживающих <progress>
                                    progressBar.val(percentComplete).text('Загружено ' + percentComplete + '%');
                                }
                            }, false);
                            return xhr;
                        },
                        complete: function (result) {
                            var data = result.responseJSON;
                            if (data.video != '')
                            {
                                if (video_path.val() != '')
                                {
                                    var file_path = video_path.val();
                                    $.ajax({
                                        url: '/delete/video',
                                        type: 'post',
                                        dataType: 'json',
                                        data: {video: file_path},
                                        complete: function (result) {
                                            var data2 = result.responseJSON;
                                            if (data2.result === true)
                                            {
                                                parent.next('.admin_form_file_line').remove();
                                                video_path.val(data.video);
                                                parent.after(data.video_block);
                                            }
                                        }
                                    });
                                }
                                else
                                {
                                    video_path.val(data.video);
                                    parent.after(data.video_block);
                                }
                            }
                            else if (data.error != '')
                            {
                                parent.after(data.error);
                            }
                            progressBar.hide();
                        }
                    });
                });
            });

            $(function () {
                var progressBar = $('#poster_progressbar');
                $('#poster_file').on('change', function (e) {
                    e.preventDefault();
                    var that = $(this),
                        parent = that.parents('.down_line'),
                        formData = new FormData,
                        poster_path = $('#poster_path');

                    formData.append('poster_file', this.files[0]);
                    $.ajax({
                        url: '/upload/poster',
                        type: 'post',
                        dataType: 'json',
                        contentType: false,
                        processData: false,
                        data: formData,
                        xhr: function () {
                            var xhr = $.ajaxSettings.xhr(); // получаем объект XMLHttpRequest

                            progressBar.show();

                            xhr.upload.addEventListener('progress', function (evt) { // добавляем обработчик события progress (onprogress)
                                if (evt.lengthComputable) { // если известно количество байт
                                    // высчитываем процент загруженного
                                    var percentComplete = Math.ceil(evt.loaded / evt.total * 100);
                                    // устанавливаем значение в атрибут value тега <progress>
                                    // и это же значение альтернативным текстом для браузеров, не поддерживающих <progress>
                                    progressBar.val(percentComplete).text('Загружено ' + percentComplete + '%');
                                }
                            }, false);
                            return xhr;
                        },
                        complete: function (result) {
                            var data = result.responseJSON;
                            if (data.poster != '')
                            {
                                if (poster_path.val() != '')
                                {
                                    var image_path = poster_path.val();
                                    $.ajax({
                                        url: '/delete/poster',
                                        type: 'post',
                                        dataType: 'json',
                                        data: {image: image_path},
                                        complete: function (result) {
                                            var data2 = result.responseJSON;
                                            if (data2.result === true)
                                            {
                                                parent.next('.admin_form_file_line').remove();
                                                poster_path.val(data.poster);
                                                parent.after(data.poster_block);
                                            }
                                        }
                                    });
                                }
                                else
                                {
                                    parent.next('.admin_form_file_line').remove();
                                    poster_path.val(data.poster);
                                    parent.after(data.poster_block);
                                }
                            }
                            else if (data.error != '')
                            {
                                parent.after(data.error);
                            }
                            progressBar.hide();
                        }
                    });
                });
            });

            // Загрузка изображений журнала
            $(function () {
                var progressBar = $('#journal_progressbar'),
                    journal_images = $('.tov_form_img.parent');
                $('#journal_images').on('change', function (e) {
                    e.preventDefault();
                    var formData = new FormData;

                    progressBar.val(0);

                    $.each( this.files, function( key, value ){
                        formData.append( key, value );
                    });

                    $.ajax({
                        url: '/upload/journal/images',
                        type: 'post',
                        contentType: false,
                        processData: false,
                        dataType: 'json',
                        data: formData,
                        xhr: function () {
                            var xhr = $.ajaxSettings.xhr(); // получаем объект XMLHttpRequest

                            progressBar.show();

                            xhr.upload.addEventListener('progress', function (evt) { // добавляем обработчик события progress (onprogress)
                                if (evt.lengthComputable) { // если известно количество байт
                                    // высчитываем процент загруженного
                                    var percentComplete = Math.ceil(evt.loaded / evt.total * 100);
                                    // устанавливаем значение в атрибут value тега <progress>
                                    // и это же значение альтернативным текстом для браузеров, не поддерживающих <progress>
                                    progressBar.val(percentComplete).text('Загружено ' + percentComplete + '%');
                                }
                            }, false);
                            return xhr;
                        },
                        complete: function (result) {
                            //$('#poster_path').val(result.responseText);
                            //$('#poster_file').remove();
                            var data = result.responseJSON;
                            journal_images.append(data.images);
                            progressBar.hide();
                            progressBar.val(0);
                            $('.video_down_line_name').text( 'Файл не выбран' );
                        }
                    });
                });
            });

            // Удаление изображения
            $('.tov_form_img.parent').on('click', '#journal_del_img', function (e) {
                e.preventDefault();
                var block = $(this).parents('.admin_form_buts').parents('.admin_form_foto_wrap'),
                    input = $(this).parents('.admin_form_buts').find('#img_path').val(),
                    post_id = $('#post_id').val();

                $.ajax({
                    url: '/deleteJournalImage',
                    type: 'post',
                    dataType: 'json',
                    data: {image: input,
                        post_id: post_id},
                    complete: function (result) {
                        var data = result.responseJSON;
                        if (data.image === true) {
                            block.remove();
                        }
                    }
                });
            });

            // Отображение и поиск приема пищи пользователя
            var pop_umeal = $('#pop-up_user_meal');
            $('#s-adding-meal').on('click', function(){
                if(pop_umeal.children('form').length === 1)
                {
                    pop_up_home(pop_umeal);
                }
                else
                {
                    $.ajax({
                        url: '/show/userMeal',
                        type: 'post',
                        dataType: 'json',
                        complete: function(result){
                            var data = jQuery.parseJSON(result.responseText);
                            if(!data.error)
                            {
                                pop_umeal.html(data.form);
                                pop_up_home(pop_umeal);

                                $(document).find('.anketa_form_select').styler();
                                $.datetimepicker.setLocale('ru');
                                $(document).find('#um-datetimepicker').datetimepicker({
                                    onSelectDate:function(ct,$i){
                                        calcUserMealsWCPFC();
                                    },
                                    format:'d.m.Y H:i',
                                    maxDate:'+1970/01/01',
                                    dayOfWeekStart:'1'
                                });
                            }
                        }
                    });
                }
            });
            $(document).on('change', '.user_meal_time #u-meal-time', function(){

                if($(this).val() === 'select')
                {
                    $(this).parent('.jq-selectbox').addClass('select');
                    $(document).find('#um-datetimepicker').show();
                }
                else{
                    $(this).parent('.jq-selectbox').removeClass('select');
                    $(document).find('#um-datetimepicker').hide();
                }
                calcUserMealsWCPFC();
            });
            $(document).on('input', '.add_tov_in.user_meal input:text', function () {
                if($(this).val().length > 3 && $(this).val().length < 255){
                    var input_search = $(this).val(),
                        tov_in = $(this);
                    $.ajax({
                        url: '/userSearchMeals',
                        type: 'post',
                        dataType: 'json',
                        data: {search_text: input_search},
                        complete: function (result) {
                            var data = jQuery.parseJSON(result.responseText);
                            if (data.meals !== "") {
                                tov_in.parents(".add_tov_in").find(".add_tov_list").show();
                                tov_in.parents(".add_tov_in").find(".add_tov_list").html(data.meals);
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
            $(document).on("click", ".user_meal .add_tren_item", function (event) {
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
                        ml_block_content = '<div id="user-meal-' + number + '" class="add_tov_val_item parent user_meals_data">' +
                                '<div class="add_kurs_val_video_wrap parent">' +
                                    '<div class="add_tov_val_cont meal_cont parent">' +
                                        '<div class="add_tov_val_h">' + name + '</div>' +
                                        '<div class="add_tov_val_sh">' +
                                            '<div class="meal_wpfcc_wrap">' +
                                                '<div class="meal_wpfcc">' +
                                                    '<div class="meal_wpfcc_title" short="В">Вес</div>' +
                                                    '<div class="meal_wpfcc_val"><input type="number" name="i_user_meal_weight[' + number + ']" value="" placeholder="0.00" class="anketa_form_in in_fill ingr_weight" required="required"/></div>' +
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

                    if(add_tov_val.length === 0)
                    {
                        this_meal.parents(".add_tov_in_total").append('<div class="add_tov_val"></div>');
                        add_tov_val = this_meal.parents(".add_tov_in_total").find('.add_tov_val');
                    }
                    if(add_tov_val.children('#user-meal-' + number).length === 0)
                    {
                        add_tov_val.append(ml_block_content);
                    }

                    //calcUserMealsWCPFC();

                    var meal_search = this_meal.parents(".add_tov_list").parents('.add_tov_in').find('input:text');

                    this_meal.parents(".add_tov_list").hide();
                    meal_search.val('');
                    this_meal.addClass("disable");
                    meal_search.focus();
                }
                return false;
            });
            $(document).on('keyup', ':input.ingr_weight', function(){
                calcUserMealsWCPFC();
            });
            $(document).on('click', '.del_tov', function () {
                var id = $(this).parents(".add_tov_val_item").attr("id"),
                    meal_block = $("#" + id);
                if(meal_block.length === 1) {
                    meal_block.remove();
                    // Пересчет ВКБЖУ
                    if($(this).parents('.user_meals_data').length === 1)
                    {
                        calcUserMealsWCPFC();
                    }
                }
            });
            $(document).on('click', '#bt-save-user-meal', function(event){
                //event.preventDefault();
                var um_block = $(this).parents('.user_meal_form'),
                    um_s_datetime = um_block.find('#u-meal-time').val(),
                    um_datetime = um_block.find('#um-datetimepicker').val(),
                    bl_ingr_weights = um_block.find('input.ingr_weight'),
                    ingr_weights = um_block.find('input.ingr_weight').serialize(),
                    empty_weight = false;

                bl_ingr_weights.each(function(){
                    if($(this).val() === '')
                    {
                        empty_weight = true;
                    }
                });

                if(empty_weight === false)
                {
                    $.ajax({
                        url: '/saveUserMeal',
                        type: 'post',
                        data: {s_datetime: um_s_datetime, i_datetime: um_datetime, ingr_weights: ingr_weights},
                        dataType: 'json',
                        complete: function(result){
                            var data = jQuery.parseJSON(result.responseText);
                            if(data === true)
                            {
                                $(document).find('.user_meals').find('.add_tov_val').html('');
                                $(document).find('#u-meal-time').val('now').change();
                            }
                        }
                    });
                }
            });
            function calcUserMealsWCPFC()
            {
                var total_weight = 0,
                    total_calories = 0,
                    total_proteins = 0,
                    total_fats = 0,
                    total_carbohydrates = 0,
                    calories_current = 0,
                    proteins_current = 0,
                    fats_current = 0,
                    carbohydrates_current = 0;

                var count_ingr = 0,
                    body = $('body'),
                    t_meal_proteins       = body.find("#today-meal-proteins"),
                    t_meal_fats           = body.find("#today-meal-fats"),
                    t_meal_carbohydrates  = body.find("#today-meal-carbohydrates"),
                    t_meal_calories       = body.find("#today-meal-calories"),
                    dt_meal_calories      = parseFloat(body.find("#today-meal-calories").data("today-meal-calories")),
                    dt_meal_proteins      = parseFloat(body.find("#today-meal-proteins").data("today-meal-proteins")),
                    dt_meal_fats          = parseFloat(body.find("#today-meal-fats").data("today-meal-fats")),
                    dt_meal_carbohydrates = parseFloat(body.find("#today-meal-carbohydrates").data("today-meal-carbohydrates")),
                    c_meal_proteins       = body.find("#current-meal-proteins"),
                    c_meal_fats           = body.find("#current-meal-fats"),
                    c_meal_carbohydrates  = body.find("#current-meal-carbohydrates"),
                    c_meal_calories       = body.find("#current-meal-calories"),
                    ingrs_data            = body.find(".user_meals_data");

                ingrs_data.each(function(){
                    var weight        = $(this).find(".ingr_weight").val(),
                        proteins      = $(this).find(".ingr_proteins").html(),
                        fats          = $(this).find(".ingr_fats").html(),
                        carbohydrates = $(this).find(".ingr_carbohydrates").html(),
                        calories      = $(this).find(".ingr_calories").html(),
                        koef = 0;

                    if(weight === "") weight = 0;
                    if(proteins === "") proteins = 0;
                    if(fats === "") fats = 0;
                    if(carbohydrates === "") carbohydrates = 0;
                    if(calories === "") calories = 0;

                    if(weight > 0)
                    {
                        koef = weight / 100;

                        total_weight = total_weight + parseFloat(weight);

                        calories_current      = calories_current + (parseFloat(calories)*koef);
                        proteins_current      = proteins_current + (parseFloat(proteins)*koef);
                        fats_current          = fats_current + (parseFloat(fats)*koef);
                        carbohydrates_current = carbohydrates_current + (parseFloat(carbohydrates)*koef);
                    }

                    count_ingr++;
                });

                total_calories      = dt_meal_calories + calories_current;
                total_proteins      = dt_meal_proteins + proteins_current;
                total_fats          = dt_meal_fats + fats_current;
                total_carbohydrates = dt_meal_carbohydrates + carbohydrates_current;

                var sel_um_date = $(document).find('.user_meal_time #u-meal-time'),
                    dp = $('#um-datetimepicker').val(),
                    dp_day = dp.substr(0, 2),
                    dp_month = dp.substr(3, 2),
                    dp_year = dp.substr(6, 4),
                    dp_date = new Date(dp_year + '-' + dp_month + '-' + dp_day),
                    today = new Date(),
                    ubmr = $(document).find('#u-bmr').val();

                if((sel_um_date.val() === 'now' || (dp_date.getFullYear() === today.getFullYear() && dp_date.getDay() === today.getDay() &&
                    dp_date.getMonth() === today.getMonth())) && total_calories > 0 && total_proteins > 0 &&
                    total_fats > 0 && total_carbohydrates > 0)
                {
                    t_meal_proteins.html(total_proteins.toFixed(2));
                    t_meal_fats.html(total_fats.toFixed(2));
                    t_meal_carbohydrates.html(total_carbohydrates.toFixed(2));
                    t_meal_calories.html(total_calories.toFixed(2));

                    if(ubmr !== '' && total_calories !== 0)
                    {
                        var cal_percent = (100 * total_calories) / ubmr,
                            wpfcc_progress = t_meal_calories.next('.meal_wpfcc_progress'),
                            n_wpfcc_progress = wpfcc_progress.next('.meal_wpfcc_progress.right');

                        if(cal_percent > 0 && cal_percent <= 100)
                        {
                            wpfcc_progress.css({'width': cal_percent + '%'});
                            wpfcc_progress.css({'background-color': '#dcfbcd'});
                            if(n_wpfcc_progress.length === 1)
                            {
                                n_wpfcc_progress.hide();
                            }
                        }
                        else if(cal_percent > 100)
                        {
                            cal_percent = 100 - (cal_percent - 100);
                            wpfcc_progress.css({'width': cal_percent + '%'});
                            wpfcc_progress.css({'background-color': '#dcfbcd'});
                            if(n_wpfcc_progress.length === 1)
                            {
                                n_wpfcc_progress.show();
                            }
                            else
                            {
                                wpfcc_progress.after('<div class="meal_wpfcc_progress right"></div>');
                            }
                        }
                    }
                }
                else
                {
                    t_meal_proteins.html(dt_meal_calories.toFixed(2));
                    t_meal_fats.html(dt_meal_fats.toFixed(2));
                    t_meal_carbohydrates.html(dt_meal_carbohydrates.toFixed(2));
                    t_meal_calories.html(dt_meal_calories.toFixed(2));
                }

                c_meal_proteins.html(proteins_current.toFixed(2));
                c_meal_fats.html(fats_current.toFixed(2));
                c_meal_carbohydrates.html(carbohydrates_current.toFixed(2));
                c_meal_calories.html(calories_current.toFixed(2));
            }
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

            // Поиск тренера курса
            $('#input-couch-search').keyup(function () {
                var input_search = $(this).val();
                if (input_search.length < 255 && input_search.length > 3) {
                    $.ajax({
                        url: '/searchCouches',
                        type: 'post',
                        data: {search_text: input_search},
                        complete: function (result) {
                            if (result != "") {
                                $("#search-result").fadeIn(); // Показываем блок с результатом.
                                $("#search-result #list-search-result").html(result.responseText); // Добавляем в список результат поиска.
                            }
                            else {
                                $("#search-result").hide();
                                $("#search-result #list-search-result").html('');
                            }
                        }
                    });
                } else {
                    $("#search-result").hide();
                    $("#search-result #list-search-result").html('');
                }
            });

            // Выбранный тренер
            $("#block-couch").on('click', '#search-result #list-search-result li', function () {
                var couch_id = $(this).find("#res-couch-id").val(),
                    couch_name = $(this).find("#res-couch-name").val(),
                    input = $(".select_couch .select_input input[type=hidden][value=" + couch_id + "]");

                if (input.length == 0) {
                    $("#select-couch .select_couch").append("<div class='select_input'>" +
                        "<input type='hidden' name='couches[]' value='" + couch_id + "'/>" +
                        "<div class='input_name selected'>" + couch_name + "</div>" +
                        "<div class='input_value'><input type='text' name='couches_percent[]' value='' placeholder='Процент' class='percent'/>%</div>" +
                        "</div>");

                    $('.percent').mask('000.00', {reverse: true});
                }

                $("#search-result #list-search-result").html("");
                $('#input-couch-search').val("");
                $("#search-result").hide();
            });

            // Удаление тренера
            $("#select-couch").on('click', '.select_input .selected', function () {
                $(this).remove();
            });


            // Поиск пользователя
            $('#input-user-search').keyup(function () {
                var input_search = $(this).val();
                if (input_search.length < 255 && input_search.length > 3) {
                    $.ajax({
                        url: '/searchUsers',
                        type: 'post',
                        data: {search_text: input_search},
                        complete: function (result) {
                            if (result != "") {
                                $("#search-result").fadeIn(); // Показываем блок с результатом.
                                $("#search-result #list-search-result").html(result.responseText); // Добавляем в список результат поиска.
                            }
                            else {
                                $("#search-result").hide();
                                $("#search-result #list-search-result").html('');
                            }
                        }
                    });
                } else {
                    $("#search-result").hide();
                    $("#search-result #list-search-result").html('');
                }
            });

            // Выбранный пользователь
            $("#block-user").on('click', '#search-result #list-search-result li', function () {
                var user_id = $(this).find("#res-user-id").val(),
                    user_name = $(this).find("#res-user-name").val(),
                    input = $(".select_user .select_input input[type=hidden][value=" + user_id + "]");

                if (input.length == 0) {
                    $("#select-user .select_user").append("<div class='select_input'>" +
                        "<input type='hidden' name='users[]' value='" + user_id + "'/>" +
                        "<div class='input_name selected'>" + user_name + "</div>" +
                        "</div>");
                }

                $("#search-result #list-search-result").html("");
                $('#input-user-search').val("");
                $("#search-result").hide();
            });

            // Удаление пользователя
            $("#select-user").on('click', '.select_input', function () {
                $(this).remove();
            });


            // Поиск видео
            var input_search_video;
            $("#schedule").on('keyup', '#input-video-search', function ()
            {
                input_search_video = $(this);
                var input_search = $(this).val(),
                    div_video_result = input_search_video.siblings("#video-search-result");
                $(".video_search_result").hide();
                if (input_search.length < 255 && input_search.length > 3)
                {
                    $.ajax({
                        url: '/searchVideo',
                        type: 'post',
                        data: {search_text: input_search},
                        complete: function (result) {
                            if (result.responseText != "")
                            {
                                div_video_result.fadeIn(); // Показываем блок с результатом.
                                div_video_result.children("#list-search-result").html(result.responseText); // Добавляем в список результат поиска.
                            }
                            else
                            {
                                div_video_result.fadeIn(); // Показываем блок с результатом.
                                div_video_result.children("#list-search-result").html('<li>Поиск не дал результатов.</li>'); // Добавляем в список результат поиска.
                            }
                        }
                    });
                }
                else
                {
                    div_video_result.hide();
                }
            });

            // Выбор видео
            $("#schedule").on('click', '#video-search-result #list-search-result li', function () {
                var video_id = $(this).find("#res-video-id").val(),
                    video_name = $(this).find("#res-video-name").val();

                input_search_video.val(video_name);
                input_search_video.siblings("#id-video").val(video_id);

                $("#video-search-result #list-search-result").html("");
                $("#video-search-result").hide();
            });

            // Выборка подкатегорий категории
            $('#id_category').change(function () {
                var id_cat = $('#id_category').val();
                var ids_subcat = $('#ids_subcat').val().split(',');
                if (id_cat > 0) {
                    $.post('/getSubcategories',
                        {
                            'id_category': id_cat,
                            'ids_subcat': ids_subcat
                        },

                        // когда Web-сервер отвечает на запрос
                        function (result) {
                            if (result != "") {
                                $('#sub_cat').html('');
                                $("#sub_cat").html(result); // Добавляем в список результат поиска.
                            }
                        }
                    );
                }
                //$('#id_td_height').height = $(subcategory_value).offsetHeight;
            });

            // Добавление товара в корзину
            $('.to_cart').on('click', function () {
                var parent_block = $(this).parents('.shop_tov_buts_col'),
                    p_id = $(this).children('#product_id').val(),
                    p_quantity = $(this).children('#product_quantity').val();
                $.ajax({
                    url: '/addProductToCart',
                    type: 'post',
                    dataType: 'json',
                    data: {
                        product_id: p_id,
                        product_quantity: p_quantity
                    },
                    complete: function (result) {
                        var data = result.responseJSON;
                        if (data.cart) {
                            parent_block.html(data.cart_info);

                            if (data.cart_count > 0)
                            {
                                $('.shop_basket span').html('Корзина [' + data.cart_count + ']');
                            }
                            else
                            {
                                $('.shop_basket span').html('Корзина');
                            }
                        }
                    }
                });
            });

            // Добавление товара в корзину
            $('.buy_course').on('click', function (event) {
                event.preventDefault();
                var cid = $(this).data('cid'),
                    butt = $(this);
                $.ajax({
                    url: '/addCourseToCart',
                    type: 'post',
                    dataType: 'json',
                    data: {
                        cid: cid
                    },
                    complete: function (result) {
                        var data = result.responseJSON;
                        if (data.cart) {
                            //butt.html(data.cart_info);

                            if (data.cart_count > 0)
                            {
                                $('.shop_basket span').html('Корзина [' + data.cart_count + ']');
                                window.location.href = "/cart";
                            }
                            else
                            {
                                $('.shop_basket span').html('Корзина');
                            }
                        }
                    }
                });
            });

            $('#delete_product').on('click', function (event) {
                event.preventDefault();

                var p_id     = $(this).siblings('input#c_id').val(),
                    block    = $(this).siblings('input#c_id').parent('.ordering_block_col_but').parent('.busket_block_col_param').parent('.ordering_block_col_cont.parent').parent('.busket_block_col').parent('.busket_block_tab_item'),
                    a_block  = $('#dtlp_' + p_id),
                    na_block = $('#dtl_' + p_id);

                $.ajax({
                    url: '/deleteCartProduct',
                    type: 'post',
                    dataType: 'json',
                    data: {product_id: p_id},
                    complete: function (result) {
                        var data = result.responseJSON;

                        if (data.cart === true) {
                            block.remove();
                            a_block.nextUntil('.dop_tov_line').andSelf().remove();
                            na_block.remove();

                            if ($('.busket_block_tab:empty'))
                            {
                                $('.busket_block_all').hide();
                                $('.ordering_block_wrap').removeClass('empty_cart');
                            }

                            if (data.cart_count > 0)
                            {
                                $('.shop_basket span').html('Корзина [' + data.cart_count + ']');
                            }
                            else
                            {
                                $('.shop_basket span').html('Корзина');
                            }
                        }
                    }
                });
            });

            $('#detach_products').on('click', function (event) {
                event.preventDefault();

                var p_id       = $(this).siblings('input#c_id').val(),
                    block      = $(this).parents('.dop_tov_line.parent'),
                    next_block = $('#dtl_' + p_id);

                $.ajax({
                    url: '/detachCartProducts',
                    type: 'post',
                    dataType: 'json',
                    data: {product_id: p_id},
                    complete: function (result) {
                        var data = result.responseJSON;

                        if (data.cart === true) {
                            block.nextUntil('.dop_tov_line').andSelf().remove();
                            next_block.remove();

                            if (data.cart_count > 0)
                            {
                                $('.shop_basket span').html('Корзина [' + data.cart_count + ']');
                            }
                            else
                            {
                                $('.shop_basket span').html('Корзина');
                            }
                        }
                    }
                });
            });

            // Поиск
            $('#s_sort').on('change', function () {
                var sort = $(this).val(),
                    category_id = $('#category_id').val(),
                    subcategory_id = $('#subcategory_id').val(),
                    search = $('#i_search').val(),
                    first_id = $('#i_first_id').val(),
                    first_price = $('#i_first_price').val(),
                    first_fc_price = $('#i_first_fc_price').val(),
                    first_discount = $('#i_first_discount').val(),
                    last_id = $('#i_last_id').val(),
                    last_price = $('#i_last_price').val(),
                    last_fc_price = $('#i_last_fc_price').val(),
                    last_discount = $('#i_last_discount').val();

                searchProducts(sort, category_id, subcategory_id, search, first_id, first_price, first_fc_price, first_discount,
                    last_id, last_price, last_fc_price, last_discount);
            });

            $('#i_search').on('keyup', function () {
                var sort = $('#s_sort').val(),
                    category_id = $('#category_id').val(),
                    subcategory_id = $('#subcategory_id').val(),
                    search = $(this).val();

                if (search.length >= 3 && search.length <= 255) {
                    setTimeout(searchProducts, 1000, sort, category_id, subcategory_id, search, null, null, null, null, null, null, null, null);
                }
            });

            $('.shop_block').on('click', '.shop_block_nav #prev_page', function (event) {
                event.preventDefault();

                var sort = $('#i_sort').val(),
                    category_id = $('#category_id').val(),
                    subcategory_id = $('#subcategory_id').val(),
                    search = $('#i_search').val(),
                    first_id = $('#i_first_id').val(),
                    first_price = $('#i_first_price').val(),
                    first_discount = $('#i_first_discount').val();

                searchProducts(sort, category_id, subcategory_id, search, first_id, first_price, first_discount, null, null, null);
            });
            $('.shop_block').on('click', '.shop_block_nav #next_page', function (event) {
                event.preventDefault();

                var sort = $('#i_sort').val(),
                    category_id = $('#category_id').val(),
                    subcategory_id = $('#subcategory_id').val(),
                    search = $('#i_search').val(),
                    last_id = $('#i_last_id').val(),
                    last_price = $('#i_last_price').val(),
                    last_discount = $('#i_last_discount').val();

                searchProducts(sort, category_id, subcategory_id, search, null, null, null, last_id, last_price, last_discount);
            });

            $('.tov').on('click', '.shop_block_nav #prev_page', function (event) {
                event.preventDefault();

                var first_id = $('#i_first_id').val(),
                    first_price = $('#i_first_price').val(),
                    first_discount = $('#i_first_discount').val();

                searchAProducts(first_id, first_price, first_discount, null, null, null);
            });
            $('.tov').on('click', '.shop_block_nav #next_page', function (event) {
                event.preventDefault();

                var last_id = $('#i_last_id').val(),
                    last_price = $('#i_last_price').val(),
                    last_discount = $('#i_last_discount').val();

                searchAProducts(null, null, null, last_id, last_price, last_discount);
            });

            // Поиск товара по ID
            $('#product-id').on('keyup', function () {
                var product_search = $(this).val();
                $.ajax({
                    url: '/searchProduct',
                    type: 'post',
                    data: {product: product_search},
                    complete: function (result) {
                        if (result.responseText != "error") {
                            $("#search-result").fadeIn(); // Показываем блок с результатом.
                            $("#search-result #list-search-result").html(result.responseText); // Добавляем в список результат поиска.
                        }
                        else {
                            $("#search-result").hide();
                            $("#search-result #list-search-result").html("");
                        }
                    }
                });
            });

            // Выбранный товара
            $("#block-product").on('click', '#search-result #list-search-result li', function () {
                var product_id = $(this).find("#res-product-id").val(),
                    product_name = $(this).find("#res-product-name").val(),
                    product_price = $(this).find("#res-product-price").val(),
                    input = $(".select_product .select_input input[type=hidden][value=" + product_id + "]");

                if (input.length == 0) {
                    $("#select-product .select_product").append("<div class='select_input'>" +
                        "<input type='hidden' name='attached_products[]' value='" + product_id + "'/>" +
                        "<div class='input_name selected'>" + product_name + " [ " + product_price + " руб. ]</div>" +
                        "<div class='input_value'><input type='text' name='products_discount[]' value='' placeholder='Скидка' class='percent'/>%</div>" +
                        "</div>");

                    $('.percent').mask('000.00', {reverse: true});
                }

                $("#search-result #list-search-result").html("");
                $('#product-id').val("");
                $("#search-result").hide();
            });

            // Удаление товара
            $("#select-product").on('click', '.select_input .selected', function () {
                $(this).remove();
            });

            // Корзина
            $("input[type=radio]").on('click', function () {
                var cp_id = $(this).parent('.ordering_tov_price').find('.cp_id').val(),
                    id_radio = this.id,
                    price_rub = 'price_rub[' + cp_id + ']',
                    price_fc = 'price_fc[' + cp_id + ']',
                    tov_number = $(this).parents(".ordering_block_tab_item").find("input.tov_number").val(),
                    currency = $(this).parents(".ordering_block_tab_item").find(".ordering_tov_summ #product_currency");

                if (tov_number != 0) {
                    $(this).parents(".ordering_block_tab_item").find(".ordering_tov_summ #product_sum").text($(this).val() * tov_number);

                    if (id_radio == price_rub) {
                        currency.text(' руб.');
                    }
                    else if (id_radio == price_fc) {
                        currency.text(' FitCoin');
                    }

                    totalCartPrice();
                }
            });

            /* Видеоплеер Vimeo */
            var options = {
                width: 640,
                loop: true
            },
                player, playerTwoPlayer;

            if ($(".vimeo_players").length > 0) {
                $(".vimeo_players").each(function() {
                    player = this.id;
                    playerTwoPlayer = new Vimeo.Player(player, options);
                });
            }

            $('#s-t-wo').on('click', function(){
                $.ajax({
                    url: '/show/workout',
                    type: 'post',
                    dataType: 'json',
                    complete: function (result) {
                        var data = jQuery.parseJSON(result.responseText);
                        if (!data.error) {
                            $.each(data.video, function(id, video){
                                $("#pop-up_video").html(video);
                                $("#pop-up_video").append(data.i_video[id]);
                                $("#pop-up_video").append(data.i_a[id]);
                                $("#pop-up_video").append(data.description[id]);
                                $("#pop-up_video").append(data.done[id]);
                                if(getInternetExplorerVersion()==-1) {
                                    if (data.player[id] == 1) {
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


                                    playerTwoPlayer.getPaused().then(function(paused) {
                                        // paused = whether or not the player is paused
                                        console.log('Video paused');
                                    }).catch(function(error) {
                                        // an error occurred
                                    });

                                    playerTwoPlayer.getCurrentTime().then(function(seconds) {
                                        // seconds = the current playback position
                                        console.log('Current time: ' + seconds);
                                    }).catch(function(error) {
                                        // an error occurred
                                    });

                                    playerTwoPlayer.getEnded().then(function(ended) {
                                        // ended = whether or not the video has ended
                                        console.log('Video ended');
                                    }).catch(function(error) {
                                        // an error occurred
                                    });

                                    playerTwoPlayer.on('seeked', function(data) {
                                        console.log(data);
                                    });
                                }
                                pop_up_def($("#pop-up_video"));
                            });

                            $('#bt-workout-done').on('click', function(){
                                var wo_id = $(this).parent('#wo-done').find('#wo-id').val();
                                $.ajax({
                                    url: '/viewed/video',
                                    type: 'post',
                                    data: {
                                        woid: wo_id
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
            });

            $('#pop-up_video').on('click', '#wo-i-but', function()
            {
                if ($(this).hasClass('video'))
                {
                    $('#wo-instruction').show();
                    $('#bt-workout-done').hide();
                    $('#wo-video').hide();
                    $(this).removeClass("video");
                    $(this).html("Тренировка");
                }
                else
                {
                    $('#wo-instruction').hide();
                    $('#bt-workout-done').show();
                    $('#wo-video').show();
                    $(this).addClass("video");
                    $(this).html("Инструктаж");
                }
            });

            if(playerTwoPlayer)
            {
                playerTwoPlayer.getPaused().then(function(paused) {
                    // paused = whether or not the player is paused
                    console.log('Video paused');
                }).catch(function(error) {
                    // an error occurred
                });

                playerTwoPlayer.getCurrentTime().then(function(seconds) {
                    // seconds = the current playback position
                    console.log('Current time: ' + seconds);
                }).catch(function(error) {
                    // an error occurred
                });

                playerTwoPlayer.getEnded().then(function(ended) {
                    // ended = whether or not the video has ended
                    console.log('Video ended');
                }).catch(function(error) {
                    // an error occurred
                });

                playerTwoPlayer.on('seeked', function(data) {
                    console.log(data);
                });
            }

            $('#logout').on('click', function(){
                FB.logout();
                VK.Auth.logout();
            });
            $('.fa-facebook').on('click', function(){
                FB.login(function(response) {
                    statusChangeCallback(response.status, 'fb');
                }, {scope: 'email'});
            });
            $('.fa-vk').on('click', function(){
                VK.Auth.login(function(response) {
                    statusChangeCallback(response.status, 'vk');
                });
            });

            $("#course-price, #recurrent-months, #recurrent-first").on('keyup change', function(){
                calc_recurrent();
            });

            $("#payment-options").on('change', function(){
                if ($(this).val() == 'installments')
                {
                    $("#recurrent-block").show();
                    if ($("#course-new-price").length == 1)
                    {
                        $("#course-new-price").hide();
                        $("#course-price").children(".anketa_form_h_cell").removeClass('strikeout');
                    }
                    $("#payment-methods option[value!='bank_card']").attr('disabled', true );
                    $("#payment-methods").parent().find("ul li[html!='Банковская карта']").addClass("disabled");

                    if($('.promo_block').length == 1)
                    {
                        $('.promo_info').show();
                        $('.promo_line').hide();
                        if($('#i-promocode').length == 1)
                        {
                            $('#i-promocode').hide();
                        }
                    }
                }
                else
                {
                    $("#recurrent-block").hide();
                    if ($("#course-new-price").length == 1)
                    {
                        $("#course-new-price").show();
                        $("#course-price").children(".anketa_form_h_cell").addClass('strikeout');
                    }
                    $("#payment-methods option[value!='bank_card']").attr('disabled', false );
                    $("#payment-methods").parent().find("ul li[html!='Банковская карта']").removeClass("disabled");

                    if($('.promo_block').length == 1)
                    {
                        $('.promo_info').hide();
                        if($('#i-promocode').length == 1 && $('#i-promocode').val() != '')
                        {
                            $('#i-promocode').show();
                        }
                        else
                        {
                            $('.promo_line').show();
                            $('.promo_block').find('.kurs_block_h').html('');
                        }
                    }
                }
            });

            $("#payment-methods").on('change', function(){
                if ($(this).val() == 'qiwi' || $(this).val() == 'sberbank')
                {
                    $("#method-phone").show();
                    $("#method-login").hide();
                }
                else if($(this).val() == 'alfabank')
                {
                    $("#method-phone").hide();
                    $("#method-login").show();
                }
                else
                {
                    $("#method-phone").hide();
                    $("#method-login").hide();
                }
            });
    }
    );

    /**
     * Подсчет рекуррентной стоимости
     */
    function calc_recurrent()
    {
        var price = $("#course-price").val(),
            num_month = $("#recurrent-months").val(),
            first = $("#recurrent-first").val(),
            subsequent = $("#recurrent-subsequent"),
            month_price = 0;

        if (price != '' && first != '' && num_month != '')
        {
            num_month = num_month - 1;
            month_price = (price - first) / num_month;
            subsequent.val(parseFloat(month_price.toFixed(2)));
        }
    }

    /**
     * Корректировка округления десятичных дробей.
     *
     * @param {String}  type  Тип корректировки.
     * @param {Number}  value Число.
     * @param {Number}  exp   Показатель степени (десятичный логарифм основания корректировки).
     * @returns {Number} Скорректированное значение.
     */
    function decimalAdjust(type, value, exp) {
        // Если степень не определена, либо равна нулю...
        if (typeof exp === 'undefined' || +exp === 0) {
            return Math[type](value);
        }
        value = +value;
        exp = +exp;
        // Если значение не является числом, либо степень не является целым числом...
        if (isNaN(value) || !(typeof exp === 'number' && exp % 1 === 0)) {
            return NaN;
        }
        // Сдвиг разрядов
        value = value.toString().split('e');
        value = Math[type](+(value[0] + 'e' + (value[1] ? (+value[1] - exp) : -exp)));
        // Обратный сдвиг
        value = value.toString().split('e');
        return +(value[0] + 'e' + (value[1] ? (+value[1] + exp) : exp));
    }

    /**
     * Поиск товаров
     * @param sort
     * @param category_id
     * @param subcategory_id
     * @param search
     * @param first_id
     * @param first_price
     * @param first_discount
     * @param last_id
     * @param last_price
     * @param last_discount
     */
    function searchProducts(sort, category_id, subcategory_id, search, first_id, first_price, first_discount, last_id, last_price, last_discount)
    {
        $.ajax({
            url: '/getSortProducts',
            type: 'post',
            dataType: 'json',
            data: {sort: sort,
                category_id: category_id,
                subcategory_id: subcategory_id,
                search: search,
                first_id: first_id,
                first_price: first_price,
                first_discount: first_discount,
                last_id: last_id,
                last_price: last_price,
                last_discount: last_discount},
            complete: function (result) {
                var data = jQuery.parseJSON(result.responseText);
                if (data.products != "false") {
                    $(".shop_block_tov.parent").html(data.products);
                    $(".shop_block_tov.parent").next("#pagination").remove();
                    $(".shop_block_tov.parent").after(data.pagination);
                }
                else {
                    $(".shop_block_tov.parent").html("<br/>К сожалению, по Вашему запросу ни чего не найдено.");
                }
            }
        });
    }

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
                if (data.products != "false") {
                    tov_block.html(data.products);
                    tov_block.next("#pagination").remove();
                    tov_block.after(data.pagination);
                }
                else {
                    tov_block.html("<br/>К сожалению, по Вашему запросу ни чего не найдено.");
                }
            }
        });
    }

    /**
     * Перевод даты рождения в возраст
     * @param birthDate
     * @returns {number}
     */
    function birthDateToAge(birthDate) {
        birthDate = new Date(birthDate[2], birthDate[1], birthDate[0]);

        var now = new Date(),
            age = now.getFullYear() - birthDate.getFullYear();

        return now.setFullYear(1972) < birthDate.setFullYear(1972) ? age - 1 : age;
    }

    /*function show_weeks(){
        var count_weeks         = parseInt($('#count_weeks').val()),
            count_days          = parseInt($('#count_days').val()),
            orig_count_weeks    = parseInt($('#orig_count_weeks').val()),
            orig_count_days     = parseInt($('#orig_count_days').val()),
            count_workouts      = count_weeks * count_days, // Количество тренировок
            orig_count_workouts = orig_count_weeks * orig_count_days, // Изначальное количество тренировок
            diff_workouts       = 0, // Разница между изначальным кол-вом тренировок и последующим изменением кол-ва недель и дней тренировок
            workout             = 1,
            workout2            = 1,
            workout_id          = '', // Объект элемента $("#workout" + workout)
            schedule            = $('#schedule'),
            text                = '';

        if (count_weeks > 0 && count_days > 0 && orig_count_weeks == 0 && orig_count_days == 0) {
            schedule.html('');
            for (w = 0; w < count_workouts; w++) {
                workout2 = 1;

                text += new_workout(workout, workout2);

                workout++;
            }
            schedule.append(text);
            $('#orig_count_weeks').val(count_weeks);
            $('#orig_count_days').val(count_days);
        }
        else if (count_weeks > 0 && count_days > 0) {
            /!* Количество тренировок стало больше/меньше *!/
            if (count_workouts > orig_count_workouts) {
                diff_workouts = count_workouts - orig_count_workouts;
                workout = orig_count_workouts + 1; // Продолжаем нумерацию тренировок
                for (w = 0; w < diff_workouts; w++) {
                    workout2 = 1;
                    workout_id = $("#workout" + workout);
                    /!* Если объект существует, показываем его. Иначе добавляем новый *!/
                    if ($('div').is(workout_id)) {
                        workout_id.show();
                    }
                    else {
                        text += new_workout(workout, workout2);
                    }

                    workout++;
                }

                schedule.append(text);
                $('#orig_count_weeks').val(count_weeks);
                $('#orig_count_days').val(count_days);
            }
            else if (count_workouts < orig_count_workouts) {
                $( '.workouts' ).slice( count_workouts ).hide();
                $('#orig_count_weeks').val(count_weeks);
                $('#orig_count_days').val(count_days);
            }
        }
    }*/

    /*function new_workout(workout, workout2) {
        var text = '';
        text += '<div class="workouts" id="workout' + workout + '">' +
            '<div class="line">' +
            '<div class="input_name workout"><b>Тренировка #' + workout + ':</b></div>' +
            '<div class="input_value">' +
            '<input type="text" name="name_video[' + workout + ']" value="" placeholder="Выберите видео.." id="input-video-search" autocomplete="off"/>' +
            '<div id="video-search-result" class="video_search_result">' +
            '<ul id="list-search-result"></ul>' +
            '</div>' +
            '<input type="hidden" name="id_video[' + workout + ']" value="" id="id-video"/>' +
            '</div>';

        if (workout > 1) {
            text += '<div class="input_name workout">' +
                '<input type="checkbox" name="cb_repeat_workout[' + workout + ']" value="' + workout + '" id="repeat_all[' + workout + ']"/>' +
                '<label for="repeat_all[' + workout + ']">Повтор тренировки:</label>' +
                '</div>' +
                '<div class="input_value">' +
                '<select name="s_repeat_workout[' + workout + ']">';
            for (rw = 0; rw < workout - 1; rw++) {
                text += '<option value="' + workout2 + '">Тренировка #' + workout2 + '</option>';

                workout2++;
            }
            text += '</select>' +
                '</div>';
        }

        text += '</div><!-- line -->' +
            '</div><!-- workouts -->';

        return text;
    }*/

    /**
     * Подсчет общей стоимости корзины
     */
    function totalCartPrice(){
        var sum_price = 0,
            sum_fc = 0;

        $(".ordering_tov_summ").each(function(){
            if ($(this).children('#product_currency').text() == " руб.") {
                sum_price += parseFloat($(this).children('#product_sum').text());
            }
            else if ($(this).children('#product_currency').text() == " FitCoin") {
                sum_fc += parseFloat($(this).children('#product_sum').text());
            }
        });

        if (sum_price == NaN || sum_price == 0) {
            $(".info_ordering_price").text("");
            $(".info_ordering_currency").text("");
        } else {
            $(".info_ordering_price").text(String(sum_price).replace(/(\d)(?=(\d\d\d)+([^\d]|$))/g, '$1 '));
            $(".info_ordering_currency").text(" руб.");
        }
        if (sum_fc == NaN || sum_fc == 0) {
            $(".info_ordering_fc_price").text("");
            $("#info_ordering_fc_currency").text("");
        } else {
            $(".info_ordering_fc_price").text(String(sum_fc).replace(/(\d)(?=(\d\d\d)+([^\d]|$))/g, '$1 '));
            $("#info_ordering_fc_currency").text(" FitCoin");
        }
    }

    /**
     * Блокировка дней недели тренировок курса
     * @param count_rest
     * @param next_element
     * @param prev_element
     * @param element
     */
    function blockWeekDays(count_rest, next_element, prev_element, element)
    {
        var n_e = next_element.next('.cb_week_day').children('input[type=checkbox]'),
            p_e = prev_element.prev('.cb_week_day').children('input[type=checkbox]'),
            diff_count_block, el,
            count_prev_block = 0,
            count_next_block = 0;

        // Блокировать предыдущий и следующий checkbox. в кол-ве дней отдыха
        for (i = 0; i < count_rest; i++)
        {
            if (n_e.length > 0 && !n_e.is(':checked'))
            {
                n_e.prop('disabled', true);
                n_e = n_e.parent().next('.cb_week_day').children('input[type=checkbox]');

                count_next_block++;
            }

            if (p_e.length > 0 && !p_e.is(':checked'))
            {
                p_e.prop('disabled', true);
                p_e = p_e.parent().prev('.cb_week_day').children('input[type=checkbox]');

                count_prev_block++;
            }
        }

        if (count_prev_block < count_rest)
        {
            diff_count_block = count_rest - count_prev_block;
            el = element.parent().children('.cb_week_day:last-child');
            // Блокировать последние checkbox. в кол-ве дней отдыха
            for (i = 0; i < diff_count_block; i++)
            {
                el.children('input[type=checkbox]').prop('disabled', true);
                el = el.prev('.cb_week_day');
            }
        }

        if (count_next_block < count_rest)
        {
            diff_count_block = count_rest - count_next_block;
            el = element.parent().children('.cb_week_day:first-child');
            // Блокировать последние checkbox. в кол-ве дней отдыха
            for (i = 0; i < diff_count_block; i++)
            {
                el.children('input[type=checkbox]').prop('disabled', true);
                el = el.next('.cb_week_day');
            }
        }
    }

    /**
     * Подсчет ИМТ и показателя базального метаболизма
     */
    function calcBmiBmr() {
        var e_weight = $('#weight'),
            e_height = $('#height'),
            e_birthday = $('#birthday');

        if(e_weight.length === 1 && e_height.length === 1 && e_birthday.length === 1)
        {
            var weight = e_weight.val().replace(",", "."),
                height = e_height.val().replace(",", "."),
                birthday = e_birthday.val().split('.');

            if (height.length === 3 && weight.length >= 2)
            {
                if (weight !== '' && height !== '')
                {
                    var bmi, round_bmi;
                    bmi = weight / Math.pow((height / 100), 2);
                    round_bmi = bmi.toFixed(2);
                    $('#bmi').val(round_bmi);
                    $('#span_bmi').html(round_bmi);

                    if (round_bmi <= 18.8)
                    {
                        $('#span_bmi_txt').html('(дефицит массы тела)');
                    }
                    else if (round_bmi <= 25)
                    {
                        $('#span_bmi_txt').html('(норма веса)');
                    }
                    else if (round_bmi <= 30)
                    {
                        $('#span_bmi_txt').html('(излишек массы тела)');
                    }
                    else if (round_bmi <= 34.5)
                    {
                        $('#span_bmi_txt').html('(начальная степень ожирения)');
                    }
                    else if (round_bmi <= 40)
                    {
                        $('#span_bmi_txt').html('(средняя степень ожирения)');
                    }
                    else if (round_bmi > 40)
                    {
                        $('#span_bmi_txt').html('(ожирение высокой степени)');
                    }
                }

                if (weight !== '' && height !== '' && birthday !== '')
                {
                    var bmr,
                        age = birthDateToAge(birthday);

                    if ($('input[id=gender_female]').is(':checked'))
                    {
                        if (round_bmi < 30)
                        {
                            bmr = 655 + 9.6 * weight + 1.8 * height - 4.7 * age;
                        }
                        else
                        {
                            bmr = 2.4 * weight + 9 * height - 4.7 * age - 65;
                        }
                    }
                    else
                    {
                        if (round_bmi < 30)
                        {
                            bmr = 66.5 + 13.7 * weight + 5 * height - 6.8 * age;
                        }
                        else
                        {
                            bmr = 3.4 * weight + 15.3 * height - 6.8 * age - 691;
                        }
                    }

                    $('#bmr').val(Math.round(bmr));
                    $('#span_bmr').html(Math.round(bmr));
                }
            }
        }
    }
});