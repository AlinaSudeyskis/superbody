function getInternetExplorerVersion() {
    var rv = -1;
    if (navigator.appName == 'Microsoft Internet Explorer')
    {
        var ua = navigator.userAgent;
        var re  = new RegExp("MSIE ([0-9]{1,}[\.0-9]{0,})");
        if (re.exec(ua) != null)
            rv = parseFloat( RegExp.$1 );
    }
    else if (navigator.appName == 'Netscape')
    {
        var ua = navigator.userAgent;
        var re  = new RegExp("Trident/.*rv:([0-9]{1,}[\.0-9]{0,})");
        if (re.exec(ua) != null)
            rv = parseFloat( RegExp.$1 );
    }
    return rv;
}
$(document).ready(function() {

	/* Видео превью */

    function secondsToTime(time){
        var h = Math.floor(time / (60 * 60)),
            dm = time % (60 * 60),
            m = Math.floor(dm / 60),
            ds = dm % 60,
            s = Math.ceil(ds);
        if (s === 60) {
            s = 0;
            m = m + 1;
        }
        if (s < 10) {
            s = '0' + s;
        }
        if (m === 60) {
            m = 0;
            h = h + 1;
        }
        if (m < 10) {
            m = '0' + m;
        }
        if (h === 0) {
            fulltime = m + ':' + s;
        } else {
            fulltime = h + ':' + m + ':' + s;
        }
        return fulltime;
    }
    function getVideoTime(vid_id, time_block_id){
        var vid = document.getElementById(vid_id),
            time_block = document.getElementById(time_block_id);
        if(!!vid && !!time_block){
            vid.addEventListener('loadedmetadata', function () {
                time_block.innerHTML = secondsToTime(vid.duration);
            }, false);
        }
    }
    if($(".practice_block .add_tov_val_item").length > 0){
        $(".practice_block .add_tov_val_item").each(function() {
            var video_id = $(this).find("video").attr("id"),
                time_id  = $(this).find(".add_kurs_val_video").find("div").attr("id");
            if(!!video_id && !!time_id) {
                getVideoTime(video_id, time_id);
            }
        });
    }
      /*function setVideoList(){
        if($(".form_video_list").length > 0 && $(".practice_block .add_tov_list").length > 0){
            list = $(".form_video_list").html();
            $(".practice_block .add_tov_list").each(function() {
                $(this).html(list);
            });
        }
    }
    setVideoList();*/


	/* Добавление фото */

    $(".add_new_foto_but").click(function() {
        var num = $(this).parents(".add_foto_block_wrap").find(".video_down_line").length + 1;
        if (num <= 7) {
            $(this).parents(".add_foto_block_wrap").find(".add_foto_block")
                .append('<div class="video_down_line parent">' +
                    '<div class="video_down_line_h">Изображение №'+num+':</div>' +
                    '<div class="video_down_line_but_wrap">' +
                    '<label for="video_down_line_but'+num+'s" class="video_down_line_but">' +
                    '<input type="file" name="slider_files[]" class="admin_form_videofile" id="video_down_line_but'+num+'s">' +
                    '<span>Выберите файл</span></label>' +
                    '</div>' +
                    '<div class="video_down_line_name">Файл не выбран</div>' +
                    '<div class="progressbar_wrap"><progress class="progressbar" id="progressbar'+num+'s" value="50" max="100"></progress></div>' +
                    '</div>');
        }
        if (num == 7) {
            $(this).hide();
        }
    });


	/* Добавление опции */

    $(".add_new_options_but.add_form_advantage").click(function() {
        $(this).parents(".lend_form_options_wrap").find(".lend_form_options")
            .append('<input type="text" name="i_advantages_block6[]" class="admin_form_txt" value="" placeholder="Преимущество" />');
    });

    $(".add_new_options_but.add_form_plan").click(function() {
        var val = $(this).parents(".new_form_option_wrap").find(".new_form_option").val(),
            num = $(this).parents(".lend_form_options_wrap").find(".add_foto_block_wrap").length + 1;

        if(val != ''){
            $(this).parents(".lend_form_options_wrap").find(".lend_form_options")
                .append('<div class="add_foto_block_wrap">' +
                    '<div class="add_foto_block">' +
                        '<div class="video_down_line parent">' +
                            '<div class="video_down_line_h">Изображение:</div>' +
                                '<div class="video_down_line_but_wrap">' +
                                    '<label for="video_down_line_but'+num+'p" class="video_down_line_but">' +
                                        '<input type="file" name="files_block7[]" class="admin_form_videofile" id="video_down_line_but'+num+'p">' +
                                        '<span>Выберите файл</span>' +
                                    '</label>' +
                                '</div>' +
                                '<div class="video_down_line_name">Файл не выбран</div>' +
                                '<div class="progressbar_wrap"><progress class="progressbar" id="progressbar'+num+'p" value="50" max="100"></progress></div>' +
                            '</div>' +
                        '</div>' +
                    '</div>' +
                    '<div class="parent kurs_cur_wrap">' +
                        '<div class="kurs_block_h">Текст плана:</div>' +
                        '<input type="text" name="i_text_block7[]" class="admin_form_txt admin_form_txt_middle" maxlength="160" />' +
                    '</div>');
            $(this).parents(".new_form_option_wrap").find(".new_form_option").val('');
            $(this).parents(".new_form_option_wrap").hide();
        }
    });

    $(".add_new_options_but").click(function() {
        $(this).parents(".lend_form_options_wrap").find(".new_form_option_wrap").show();
    });
    $(".add_form_option").click(function() {
        var val = $(this).parents(".new_form_option_wrap").find(".new_form_option").val(),
            num = $(this).parents(".lend_form_options_wrap").find(".tren_form_block_radio_wrap").length + 1,
            param = "";
        if($(this).parents("form").hasClass("edit_lend_form")){
            param = "e";
        }
        if(val != ''){
            $(this).parents(".lend_form_options_wrap").find(".lend_form_options").append('<div class="tren_form_block_radio_wrap"><input type="radio" name="radio1a'+param+'" class="tren_form_block_radio" id="tren_form_block_radio'+num+'a'+param+'" value="'+val+'"><label for="tren_form_block_radio'+num+'a'+param+'">'+val+'</label></div>');
            $(this).parents(".new_form_option_wrap").find(".new_form_option").val('');
            $(this).parents(".new_form_option_wrap").hide();
        }
    });


	/* Формирование тренировок */

    $(".kurs_time_in, .kurs_length_in").on('change keyup', function() {
        var kurs_time_in = $(this).parents("form").find("input.kurs_time_in").val(),
            kurs_length_in = $(this).parents("form").find("select.kurs_length_in").val(),
            kurs_length_out = $(this).parents("form").find(".practice_block").length,
            active_practice_block = $('.practice_day.active').attr('id'),
            video_list = $(".form_video_list").html(),
            index, rez, html_table = '', html = '', option, num,
            i = 1, tr_week = 1, tr_day = 1,
            block_id, active_class = "";

        if($(this).parents("form").hasClass("edit_kurs_form")){
            index = "e";
        } else if($(this).parents("form").hasClass("add_kurs_form")){
            index = "a";
        } else{
            index = "o";
        }
        if(kurs_time_in != 0 && kurs_length_in != 0)
        {
            rez = kurs_time_in * kurs_length_in;
            while (tr_week <= kurs_time_in) {
                html_table = html_table + '<div class="practice_weeks"><div class="practice_week"><span>Неделя</span> '+tr_week+'</div>' +
                    '<div class="practice_days">';
                tr_day = 1;
                while(tr_day <= kurs_length_in){
                    block_id = 'practice' + i;
                    active_class = "";
                    if (active_practice_block == block_id)
                    {
                        active_class = "active";
                    }
                    html_table = html_table + '<div class="practice_day '+active_class+'" id="practice'+i+'">Т '+tr_day+'</div>';
                    tr_day++;
                    i++;
                }
                html_table = html_table + '</div></div>';
                tr_week++;
            }
            $(".practice_block_table").html(html_table);
        }

        if(kurs_time_in != 0 && kurs_length_in != 0 && kurs_length_out < 1){
            rez = kurs_time_in * kurs_length_in;
            i = 1;
            html = '<div class="practice_block" id="practice'+i+'_block"><div class="practice_block_h">Тренировка №'+i+'</div><div class="add_tov_in_total"><div class="add_tov_in video"><input type="text" name="name_video['+i+']" class="admin_form_txt admin_form_txt_short" placeholder="Введите наименование или ID видео"><div class="add_tov_list">'+video_list+'</div></div><div class="add_tov_val"></div><input type="hidden" name="id_video['+i+']" value="" id="id-video'+i+'"/></div><textarea name="ta_workout_desc['+i+']" class="tov_form_textarea" placeholder="Введите описание тренировки"></textarea></div>';
            option = '<option>Тренировка №'+i+'</option>';
            while (i < rez) {
                i++;
                html = html + '<div class="practice_block" id="practice'+i+'_block"><div class="practice_block_h">Тренировка №'+i+'</div><div class="add_tov_in_total"><div class="add_tov_in video"><input type="text" name="name_video['+i+']" class="admin_form_txt admin_form_txt_short" placeholder="Введите наименование или ID видео"><div class="add_tov_list">'+video_list+'</div></div><div class="add_tov_val"></div><input type="hidden" name="id_video['+i+']" value="" id="id-video'+i+'"/></div><textarea name="ta_workout_desc['+i+']" class="tov_form_textarea" placeholder="Введите описание тренировки"></textarea><div class="tren_repeat_total"><div class="tren_form_block_check_wrap"><input type="checkbox" name="cb_repeat_workout['+i+']" class="tren_form_block_check" id="tren_form_block_check'+i+index+'"><label for="tren_form_block_check'+i+index+'">Повтор тренировок</label></div><select name="s_repeat_workout['+i+']" class="journal_form_select">'+option+'</select></div></div>';
                option = option + '<option>Тренировка №'+i+'</option>';
            }
            $(this).parents("form").find(".practice_block_wrap").html(html);
            $(this).parents("form").find(".practice_block_wrap").find(".journal_form_select").styler();
        }
        else if(kurs_time_in != 0 && kurs_length_in != 0 && kurs_length_out >= 1){
            rez = kurs_time_in * kurs_length_in - kurs_length_out;
            //$(this).parents("form").find(".practice_block").show();
            if(rez>0){
                num = kurs_length_out + 1;
                i = 0;
                a = 1;
                html = '';
                option = '';
                while (a <= kurs_length_out) {
                    option = option + '<option>Тренировка №'+a+'</option>';
                    a++;
                }
                while (i < rez) {
                    html = html + '<div class="practice_block" id="practice'+num+'_block"><div class="practice_block_h">Тренировка №'+num+'</div><div class="add_tov_in_total"><div class="add_tov_in video"><input type="text" name="name_video['+num+']" class="admin_form_txt admin_form_txt_short" placeholder="Введите наименование или ID видео"><div class="add_tov_list">'+video_list+'</div></div><div class="add_tov_val"></div><input type="hidden" name="id_video['+num+']" value="" id="id-video'+num+'"/></div><textarea name="ta_workout_desc['+num+']" class="tov_form_textarea" placeholder="Введите описание тренировки"></textarea><div class="tren_repeat_total"><div class="tren_form_block_check_wrap"><input type="checkbox" name="cb_repeat_workout['+num+']" class="tren_form_block_check" id="tren_form_block_check'+num+index+'"><label for="tren_form_block_check'+num+index+'">Повтор тренировок</label></div><select name="s_repeat_workout['+num+']" class="journal_form_select">'+option+'</select></div></div>';
                    option = option + '<option>Тренировка №'+num+'</option>';
                    i++;
                    num++;
                }
                $(this).parents("form").find(".practice_block_wrap").append(html);
                $(this).parents("form").find(".practice_block_wrap").find(".journal_form_select").styler();
                $('#' + active_practice_block + '_block').show();
            } else if(rez<0){
                i = 0;
                while (i > rez) {
                    $(this).parents("form").find(".practice_block:nth-of-type("+(kurs_length_out + i)+")").hide();
                    i--;
                }
            }
        }
    });


	/* Оформление форм */

    /*$(".journal_form_select").styler();
    if($("#area1").length > 0){
        new nicEditor({iconsPath : 'img/nicEditorIcons.gif', fullPanel : true}).panelInstance('area1');
    }
    if($("#area2").length > 0){
        new nicEditor({iconsPath : 'img/nicEditorIcons.gif', fullPanel : true}).panelInstance('area2');
    }
    if($("#area3").length > 0){
        new nicEditor({iconsPath : 'img/nicEditorIcons.gif', fullPanel : true}).panelInstance('area3');
    }
    if($("#area4").length > 0){
        new nicEditor({iconsPath : 'img/nicEditorIcons.gif', fullPanel : true}).panelInstance('area4');
    }*/

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
    /*$(document).click(function(event) {
        if ($(event.target).closest(".add_tov_in input:text").length) return;
        $(".add_tov_list").hide();
        event.stopPropagation();
    });*/
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
        var id = parseFloat($(this).parents(".add_tov_val_item").attr("id")),
            video_id = $(this).parents(".add_tov_in_total").children("#id-video"+id),
            inst_id = $(this).parents(".add_tov_in_total").children("#id-video-instruction");
        if (video_id.length == 1 || inst_id.length == 1)
        {
            $(this).parents(".add_tov_in_total").find("#"+id).removeClass("disable");
            $(this).parents(".add_tov_val_item").remove();
            video_id.val('');
            inst_id.val('');
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
        getVideoTime(video_id, time_id);
        return false;
    });


	/* видео */

    if(getInternetExplorerVersion()==-1){

        if($(".video_cont").length > 0){
            $(".video_cont").each(function() {
                new InitPxVideo({
                    "videoId": this,
                    "captionsOnDefault": false,
                    "seekInterval": 20,
                    "videoTitle": "Promo",
                    "debug": true
                });
            });
        }

    }

    $(".px-video-controls button").click(function() {
        return false;
    });


	/* оформление input file */

    var file_api = ( window.File && window.FileReader && window.FileList && window.Blob ) ? true : false;
    $(document).on('change', '.admin_form_videofile', function () {
        var inp = $(this);
        var lbl = inp.parents(".video_down_line").find(".video_down_line_name");
        var file_name;

        if( file_api )
            $.each(inp[0].files, function(index, value){
                if (index == 0) {
                    file_name = value.name;
                }
                else {
                    file_name = file_name + ', ' + value.name;
                }
            });
            //file_name = inp[ 0 ].files[ 0 ].name;
        else
            file_name = inp.val().replace( "C:\\fakepath\\", '' );

        if( ! file_name.length )
            return;

        lbl.text( file_name );
    }).change();


	/* субменю */

    $(".submenu_li").hover(
        function () {
            $(this).find(".submenu").fadeIn(200);
        },
        function () {
            $(this).find(".submenu").stop(true, true);
            $(this).find(".submenu").fadeOut(200);
        }
    );


	/* моб. меню */

    $(".mob_menu_but").click(function() {
        if($(this).hasClass("mob_open")){
            $(this).removeClass("mob_open");
            $(".header_menu").fadeOut(200);
            $("body").removeClass("mob_body");
        } else{
            $(this).addClass("mob_open");
            $(".header_menu").fadeIn(200);
            $("body").addClass("mob_body");
        }
    });

    $(".mob_side_menu_but").click(function() {
        $(".profile_menu, .mob_side_menu_close").fadeIn(200);
        $("body").addClass("side_mob_body");
    });
    $(".mob_side_menu_close span").click(function() {
        $(".profile_menu, .mob_side_menu_close").fadeOut(200);
        $("body").removeClass("side_mob_body");
    });

    if ($(window).width() <= 991) {
        $(document).click(function(event) {
            if ($(event.target).closest(".header_mid").length) return;
            $(".mob_menu_but").removeClass("mob_open");
            $("body").removeClass("mob_body");
            $(".header_menu").fadeOut(200);
            event.stopPropagation();
        });
    }
    if ($(window).width() < 480) {
        $(document).click(function(event) {
            if ($(event.target).closest(".left_sidebar").length) return;
            $(".mob_side_menu_but").removeClass("mob_open");
            $("body").removeClass("side_mob_body");
            $(".profile_menu, .mob_side_menu_close").fadeOut(200);
            event.stopPropagation();
        });
    }

    /* скрытие блоков */

    $(".up_but_main").click(function() {
        if($(this).hasClass("hide_chart")){
            $(this).removeClass("hide_chart");
            $('.header_bg').slick("slickPlay");
            $(".main_bg_wrap").slideDown(200);
        } else{
            $(this).addClass("hide_chart");
            $(".main_bg_wrap").slideUp(200);
            $('.header_bg').slick("slickPause");
        }
    });

    /* скрытие и удаление блоков в профиле */

    $(".up_but_bot").click(function() {
        if($(this).hasClass("hide_chart")){
            $(this).removeClass("hide_chart");
            $('.prezent_head').removeClass("hide_chart");
            $('.header_bg').slick("slickPlay");
            $(".header_bg_wrap").slideDown(200);
        } else{
            $(this).addClass("hide_chart");
            $('.prezent_head').addClass("hide_chart");
            $(".header_bg_wrap").slideUp(200);
            $('.header_bg').slick("slickPause");
        }
    });

    $(".up_but_top").click(function() {
        if($(this).hasClass("hide_chart")){
            $(this).removeClass("hide_chart");
            $(".hid_header").slideDown(200);
        } else{
            $(this).addClass("hide_chart");
            $(".hid_header").slideUp(200);
        }
    });

    $(".kurs_slide").click(function() {
        if($(this).hasClass("hide_chart")){
            $(this).removeClass("hide_chart");
            $(this).parents(".content_block").find(".kurs_block_val").slideDown(200);
        } else{
            $(this).addClass("hide_chart");
            $(this).parents(".content_block").find(".kurs_block_val").slideUp(200);
        }
    });

    $(".price_slide").click(function() {
        if($(this).hasClass("hide_chart")){
            $(this).removeClass("hide_chart");
            $(this).parents(".content_block_internal").find(".kurs_block_val").slideDown(200);
        } else{
            $(this).addClass("hide_chart");
            $(this).parents(".content_block_internal").find(".kurs_block_val").slideUp(200);
        }
    });

    $(".content_block_h_close").click(function() {
        $(this).parents(".content_block").slideUp(200);
    });


});

/* pop_up */

function pop_up_def(popup) {
  var shadow = $("#shadow");
  popup.css({marginLeft:-popup.width()/2-15,marginTop:-popup.height()/2-15}).fadeIn(600); /*+$(window).scrollTop()*/
  $("#shadow, .close_video").fadeTo(600,0.8).click(function() {
    shadow.fadeOut(600);
    popup.fadeOut(600);
  });
}
function pop_up_home(popup) {
  var shadow = $("#shadow2");
  popup.css({marginLeft:-popup.width()/2,marginTop:-popup.height()/2}).fadeIn(600);
  $("#shadow2, .home_pop-up_close").fadeTo(600,0.8).click(function() {
    shadow.fadeOut(600);
    popup.fadeOut(600);
  });
}


function getInternetExplorerVersion() {
    var rv = -1;
    if (navigator.appName == 'Microsoft Internet Explorer')
    {
        var ua = navigator.userAgent;
        var re  = new RegExp("MSIE ([0-9]{1,}[\.0-9]{0,})");
        if (re.exec(ua) != null)
            rv = parseFloat( RegExp.$1 );
    }
    else if (navigator.appName == 'Netscape')
    {
        var ua = navigator.userAgent;
        var re  = new RegExp("Trident/.*rv:([0-9]{1,}[\.0-9]{0,})");
        if (re.exec(ua) != null)
            rv = parseFloat( RegExp.$1 );
    }
    return rv;
}



$(document).ready(function(){
    $('.otziv_row').masonry({
        itemSelector: '.otziv_col'
    });
});



/* Слайдер */

$(document).ready(function(){

	$('.tren_block').slick({
		dots: false,
		infinite: true,
		arrows: true,
		speed: 300,
        autoplay: true,
		slidesToShow: 3,
		slidesToScroll: 1,
		responsive: [
		{
		  breakpoint: 1420,
		  settings: {
		    slidesToShow: 2,
		    slidesToScroll: 1
		  }
		},
		{
		  breakpoint: 1140,
		  settings: {
		    slidesToShow: 2,
		    slidesToScroll: 1
		  }
		},
		{
		  breakpoint: 992,
		  settings: {
		    slidesToShow: 4,
		    slidesToScroll: 1
		  }
		},
		{
		  breakpoint: 767,
		  settings: {
		    slidesToShow: 3,
		    slidesToScroll: 1
		  }
		},
		{
		  breakpoint: 520,
		  settings: {
		    slidesToShow: 2,
		    slidesToScroll: 1
		  }
		},
		{
		  breakpoint: 480,
		  settings: {
		    slidesToShow: 1,
		    slidesToScroll: 1
		  }
		}
		]
	});

    $('.video_block').slick({
        dots: true,
        infinite: true,
        arrows: false,
        speed: 300,
        autoplay: false,
        slidesToShow: 4,
        slidesToScroll: 1,
        responsive: [
        {
          breakpoint: 1420,
          settings: {
            slidesToShow: 4,
            slidesToScroll: 1
          }
        },
        {
          breakpoint: 1140,
          settings: {
            slidesToShow: 3,
            slidesToScroll: 1
          }
        },
        {
          breakpoint: 992,
          settings: {
            slidesToShow: 3,
            slidesToScroll: 1
          }
        },
        {
          breakpoint: 767,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 1
          }
        },
        {
          breakpoint: 639,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1
          }
        },
        {
          breakpoint: 480,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1
          }
        }
        ]
    });

	$('.gal_block').slick({
		dots: false,
		infinite: true,
		arrows: true,
		autoplaySpeed: 5000,
		speed: 500,
		slidesToShow: 4,
		autoplay: true,
		slidesToScroll: 4,
		responsive: [
		{
		  breakpoint: 1399,
		  settings: {
		    slidesToShow: 3,
		    slidesToScroll: 3
		  }
		},
		{
		  breakpoint: 1023,
		  settings: {
		    slidesToShow: 2,
		    slidesToScroll: 2
		  }
		},
		{
		  breakpoint: 768,
		  settings: {
		    slidesToShow: 3,
		    slidesToScroll: 3
		  }
		},
		{
		  breakpoint: 640,
		  settings: {
		    slidesToShow: 2,
		    slidesToScroll: 2
		  }
		},
		{
		  breakpoint: 480,
		  settings: {
		    slidesToShow: 1,
		    slidesToScroll: 1
		  }
		}
		]
	});

	$('.comment_block').slick({
	  dots: true,
	  infinite: true,
	  autoplaySpeed: 5000,
	  speed: 500,
	  autoplay: true,
	  arrows: false
	});

	$('.tov_slider_bot').slick({
		dots: false,
		infinite: true,
		arrows: true,
		speed: 500,
		slidesToShow: 4,
		slidesToScroll: 1,
		responsive: [
		{
		  breakpoint: 992,
		  settings: {
		    slidesToShow: 3,
		    slidesToScroll: 1
		  }
		}
		]
	});

	$('.ordering_block_tov_slider1').slick({
		infinite: false,
		dots: false,
		arrows: true,
		speed: 500,
		slidesToShow: 5,
		slidesToScroll: 1,
		vertical: true,
		responsive: [
		{
		  breakpoint: 768,
		  settings: {
		    slidesToShow: 1,
		    slidesToScroll: 1
		  }
		}
		]
	});

	var tov_slider_scale = 0;

	$('.tov_slider_bot a').click(function() {
		$('.tov_slider_active').removeClass('scale1_5').removeClass('scale2').removeClass('scale2_5').removeClass('scale3');
		tov_slider_scale = 0;
		val = $(this).attr('href');
		$('.tov_slider_top a').each(function() {
			if($(this).attr('href') == val){
				$('.tov_slider_top a').removeClass('tov_slider_active');
				$(this).addClass('tov_slider_active');
				return false;
			}
		});
		return false;
	});

	$('.tov_slider_full').click(function() {
		$('.tov_slider_active').trigger('click');
	});

	function slide_scale(tov_slider_scale) {
		if(tov_slider_scale < 1){
			$('.tov_slider_active').removeClass('scale1_5').removeClass('scale2').removeClass('scale2_5').removeClass('scale3');
		} else if(tov_slider_scale == 1){
			$('.tov_slider_active').removeClass('scale2').removeClass('scale2_5').removeClass('scale3').addClass('scale1_5');
		}else if(tov_slider_scale == 2){
			$('.tov_slider_active').removeClass('scale1_5').removeClass('scale2_5').removeClass('scale3').addClass('scale2');
		}else if(tov_slider_scale == 3){
			$('.tov_slider_active').removeClass('scale1_5').removeClass('scale2').removeClass('scale3').addClass('scale2_5');
		}else{
			$('.tov_slider_active').removeClass('scale1_5').removeClass('scale2').removeClass('scale2_5').addClass('scale3');
		}
	}

	$('.tov_slider_plus').click(function() {
		if(tov_slider_scale < 4){
			tov_slider_scale ++;
			slide_scale(tov_slider_scale);
		}
	});

	$('.tov_slider_minus').click(function() {
		if(tov_slider_scale > 0){
			tov_slider_scale --;
			slide_scale(tov_slider_scale);
		}
	});

});


/* график */

/*$(document).ready(function(){

AmCharts.ready(function () {
				generateChartData();
				createStockChart();
			});

			var chartData1 = [];
			var chartData2 = [];
			var chartData3 = [];
			var chartData4 = [];

			function generateChartData() {
				var firstDate = new Date();
				firstDate.setDate(firstDate.getDate()-38);
				firstDate.setHours(0, 0, 0, 0);

				for (var i = 20; i < 55; i++) {
					var newDate = new Date(firstDate);
					newDate.setDate(newDate.getDate() + i);

					var a1 = Math.round(Math.random() * (100 - i) + i);
					var b1 = Math.round(a1 / 60 * 100)-100;
					if(b1>0){
						var c1 = "<span class='plas_chart'></span>";
					} else if(b1<0){
						var c1 = "<span class='minus_chart'></span>";
					} else{
						var c1 = "";
					}
					

					var a2 = Math.round(Math.random() * (100 - i) + i);
					var b2 = Math.round(a2 / 60 * 100)-100;
					if(b2>0){
						var c2 = "<span class='plas_chart'></span>";
					} else if(b2<0){
						var c2 = "<span class='minus_chart'></span>";
					} else{
						var c2 = "";
					}

					var a3 = Math.round(Math.random() * (100 - i) + i);
					var b3 = Math.round(a3 / 60 * 100)-100;
					if(b3>0){
						var c3 = "<span class='plas_chart'></span>";
					} else if(b3<0){
						var c3 = "<span class='minus_chart'></span>";
					} else{
						var c3 = "";
					}

					var a4 = Math.round(Math.random() * (100 - i) + i);
					var b4 = Math.round(a4 / 60 * 100)-100;
					if(b4>0){
						var c4 = "<span class='plas_chart'></span>";
					} else if(b4<0){
						var c4 = "<span class='minus_chart'></span>";
					} else{
						var c4 = "";
					}

					chartData1.push({
						date: newDate,
						value: a1,
						volume: b1,
						tender: c1
					});
					chartData2.push({
						date: newDate,
						value: a2,
						volume: b2,
						tender: c2
					});
					chartData3.push({
						date: newDate,
						value: a3,
						volume: b3,
						tender: c3
					});
					chartData4.push({
						date: newDate,
						value: a4,
						volume: b4,
						tender: c4
					});
				}
			}

			function createStockChart() {
				var chart = new AmCharts.AmStockChart();

				// DATASETS //////////////////////////////////////////
				// create data sets first
				var dataSet1 = new AmCharts.DataSet();
				dataSet1.title = "Вес";
				dataSet1.fieldMappings = [{
					fromField: "value",
					toField: "value"
				}, {
					fromField: "volume",
					toField: "volume"
				}];
				dataSet1.dataProvider = chartData1;
				dataSet1.categoryField = "date";

				var dataSet2 = new AmCharts.DataSet();
				dataSet2.title = "Обхват груди";
				dataSet2.compared = true;
				dataSet2.fieldMappings = [{
					fromField: "value",
					toField: "value"
				}, {
					fromField: "volume",
					toField: "volume"
				}];
				dataSet2.dataProvider = chartData2;
				dataSet2.categoryField = "date";

				var dataSet3 = new AmCharts.DataSet();
				dataSet3.title = "Обхват талии";
				dataSet3.compared = true;
				dataSet3.fieldMappings = [{
					fromField: "value",
					toField: "value"
				}, {
					fromField: "volume",
					toField: "volume"
				}];
				dataSet3.dataProvider = chartData3;
				dataSet3.categoryField = "date";

				var dataSet4 = new AmCharts.DataSet();
				dataSet4.title = "Обхват бедер";
				dataSet4.compared = true;
				dataSet4.fieldMappings = [{
					fromField: "value",
					toField: "value"
				}, {
					fromField: "volume",
					toField: "volume"
				}];
				dataSet4.dataProvider = chartData4;
				dataSet4.categoryField = "date";

				// set data sets to the chart
				chart.dataSets = [dataSet1, dataSet2, dataSet3, dataSet4];

				// PANELS ///////////////////////////////////////////
				// first stock panel
				var stockPanel1 = new AmCharts.StockPanel();
				stockPanel1.showCategoryAxis = true;
				stockPanel1.title = "Value";
				stockPanel1.percentHeight = 70;

				// graph of first stock panel
				var graph1 = new AmCharts.StockGraph();


				graph1.valueField = "value";
				graph1.comparable = true;
				graph1.compareField = "value";
				graph1.bullet = "round";
				graph1.bulletColor = "#FFFFFF";
				graph1.bulletBorderAlpha = 1;
				graph1.lineColor = "#00bff0";
				graph1.useDataSetColors = false;
				graph1.lineThickness = 1;
				graph1.bulletSize = 10;
				graph1.bulletBorderThickness = 1;
				graph1.bulletBorderColor = "#00bff0";
				graph1.fillAlphas = 0.2;
				graph1.balloonText = "<div class='graf_desk'>[[category]]<br>[[title]]: [[value]]</div><div class='graf_procent'>[[tender]][[volume]]%</div>";

				graph1.compareGraphBalloonText = "<div class='graf_desk'>[[category]]<br>[[title]]: [[value]]</div><div class='graf_procent'>[[tender]][[volume]]%</div>";
				graph1.compareGraphBullet = "round";
				graph1.compareGraphBulletBorderAlpha = 1;
				graph1.compareGraphBulletColor = "#FFFFFF";

				stockPanel1.addStockGraph(graph1);


				// set panels to the chart
				chart.panels = [stockPanel1];


				// OTHER SETTINGS ////////////////////////////////////
				var sbsettings = new AmCharts.ChartScrollbarSettings();
				sbsettings.enabled = false;
				chart.chartScrollbarSettings = sbsettings;

				// CURSOR
				var cursorSettings = new AmCharts.ChartCursorSettings();
				cursorSettings.enabled = false;
				chart.chartCursorSettings = cursorSettings;


				// PERIOD SELECTOR ///////////////////////////////////
				var periodSelector = new AmCharts.PeriodSelector();
				periodSelector.position = "top";
				periodSelector.inputFieldsEnabled = false;
				periodSelector.periodsText = "";
				periodSelector.periods = [{
					period: "DD",
			        count: 1,
			        label: "День"},
			        {
			        period: "DD",
			        count: 7,
			        label: "Неделя"},
			    	{
			        period: "MM",
			        selected: true,
			        count: 1,
			        label: "Месяц"
				}];
				chart.periodSelector = periodSelector;

				var amBalloon = chart.balloon;
				amBalloon.color = "#ffffff";
				amBalloon.borderAlpha = 0;
				amBalloon.cornerRadius = 0;
				amBalloon.fillColor = "#4c4c4c";
				amBalloon.fillAlpha = 1;
			    amBalloon.fontSize = 12;
			    amBalloon.shadowAlpha = 0;
			    amBalloon.horizontalPadding = 0;
			    amBalloon.verticalPadding = 0;

			    chart.colors = ["#FF6600", "#FCD202", "#B0DE09", "#de6115", "#2A0CD0", "#CD0D74", "#CC0000", "#00CC00", "#0000CC", "#DDDDDD", "#999999", "#333333", "#990000"];


				var categoryAxesSettings = new AmCharts.CategoryAxesSettings();
				categoryAxesSettings.gridColor = "#ffffff";
				chart.categoryAxesSettings = categoryAxesSettings;

				var valueAxesSettings = new AmCharts.ValueAxesSettings();
				valueAxesSettings.dashLength = 5;
				valueAxesSettings.labelsEnabled = false;
				chart.valueAxesSettings = valueAxesSettings;

				// create stock legend
				var stockLegend1 = new AmCharts.StockLegend();
				stockLegend1.markerSize = 9;
				stockLegend1.markerLabelGap = 10;
				stockLegend1.divId = 'legend';
				
				stockPanel1.stockLegend = stockLegend1;

				chart.write('chartdiv');
			}


});*/



/* календарь */

$(document).ready(function() {

 /*$('#calendar').fullCalendar({
		locale: 'ru',
		timeFormat: 'H:mm',
		height: 620,
		header: {
			left: 'prev,next today',
			center: 'title',
			right: 'month,basicWeek,basicDay'
		},
		defaultDate: '2016-09-12',
		navLinks: true, // can click day/week names to navigate views
		editable: true,
		eventLimit: true, // allow "more" link when too many events
		events: [
			{
				title: 'Repeating Event',
				url: 'https://www.paypalobjects.com/webstatic/mktg/videos/PayPal_AustinSMB_baseline.mp4',
				start: '2016-09-09T16:00:00'
			},
			{
				title: 'Repeating Event',
				url: 'https://www.paypalobjects.com/webstatic/mktg/videos/PayPal_AustinSMB_baseline.mp4',
				start: '2016-09-16T16:00:00'
			},
			{
				title: 'Lunch',
				url: 'https://www.paypalobjects.com/webstatic/mktg/videos/PayPal_AustinSMB_baseline.mp4',
				start: '2016-09-12T12:00:00'
			},
			{
				title: 'Birthday Party',
				url: 'https://www.paypalobjects.com/webstatic/mktg/videos/PayPal_AustinSMB_baseline.mp4',
				start: '2016-09-06T07:00:00'
			},
			{
				title: 'Click for Google',
				url: 'https://www.paypalobjects.com/webstatic/mktg/videos/PayPal_AustinSMB_baseline.mp4',
				start: '2016-09-28T08:30:00'
			}
		]
	});*/

	$('#calendar_prof').fullCalendar({
		locale: 'ru',
		timeFormat: 'H:mm',
		height: 620,
		header: {
			left: 'prev,next today',
			center: 'title',
			right: 'month,basicWeek,basicDay'
		},
		defaultDate: '2016-09-12',
		navLinks: true, // can click day/week names to navigate views
		editable: true,
		eventLimit: true, // allow "more" link when too many events
		events: [
			{
				title: '<div class="calendar_prof_item"><div class="parent"><div class="calendar_prof_img"><img src="img/sport_ico1.png" alt=""></div><div class="calendar_prof_cont"><div class="calendar_prof_time">00.30.00</div><div class="calendar_prof_load parent"><span></span><span></span><span></span><span></span><span></span></div></div></div><div class="calendar_prof_end"><span class="calendar_prof_end_line"></span><span class="calendar_prof_end_val">65%</span></div></div>',
				start: '2016-08-29'
			},
			{
				title: '<div class="calendar_prof_item"><div class="parent"><div class="calendar_prof_img"><img src="img/sport_ico2.png" alt=""></div><div class="calendar_prof_cont"><div class="calendar_prof_time">00.30.00</div><div class="calendar_prof_load parent calendar_prof_load_1"><span></span><span></span><span></span><span></span><span></span></div></div></div><div class="calendar_prof_end"><span class="calendar_prof_end_line"></span><span class="calendar_prof_end_val">35%</span></div></div>',
				start: '2016-08-30'
			},
			{
				title: '<div class="calendar_prof_item"><div class="parent"><div class="calendar_prof_img"><img src="img/sport_ico3.png" alt=""></div><div class="calendar_prof_cont"><div class="calendar_prof_time">00.30.00</div><div class="calendar_prof_load parent calendar_prof_load_2"><span></span><span></span><span></span><span></span><span></span></div></div></div><div class="calendar_prof_end"><span class="calendar_prof_end_line"></span><span class="calendar_prof_end_val">85%</span></div></div>',
				start: '2016-08-31'
			},
			{
				title: '<div class="calendar_prof_item"><div class="parent"><div class="calendar_prof_img"><img src="img/sport_ico4.png" alt=""></div><div class="calendar_prof_cont"><div class="calendar_prof_time">00.30.00</div><div class="calendar_prof_load parent calendar_prof_load_3"><span></span><span></span><span></span><span></span><span></span></div></div></div><div class="calendar_prof_end"><span class="calendar_prof_end_line"></span><span class="calendar_prof_end_val">60%</span></div></div>',
				start: '2016-09-01'
			},
			{
				title: '<div class="calendar_prof_item"><div class="parent"><div class="calendar_prof_img"><img src="img/sport_ico5.png" alt=""></div><div class="calendar_prof_cont"><div class="calendar_prof_time">00.30.00</div><div class="calendar_prof_load parent calendar_prof_load_4"><span></span><span></span><span></span><span></span><span></span></div></div></div><div class="calendar_prof_end"><span class="calendar_prof_end_line"></span><span class="calendar_prof_end_val">40%</span></div></div>',
				start: '2016-09-02'
			},
			{
				title: '<div class="calendar_prof_item"><div class="parent"><div class="calendar_prof_img"><img src="img/sport_ico6.png" alt=""></div><div class="calendar_prof_cont"><div class="calendar_prof_time">00.30.00</div><div class="calendar_prof_load parent calendar_prof_load_5"><span></span><span></span><span></span><span></span><span></span></div></div></div><div class="calendar_prof_end"><span class="calendar_prof_end_line"></span><span class="calendar_prof_end_val">25%</span></div></div>',
				start: '2016-09-03'
			},
			{
				title: '<div class="calendar_prof_item"><div class="parent"><div class="calendar_prof_img"><img src="img/sport_ico7.png" alt=""></div><div class="calendar_prof_cont"><div class="calendar_prof_time">00.30.00</div><div class="calendar_prof_load parent calendar_prof_load_4"><span></span><span></span><span></span><span></span><span></span></div></div></div><div class="calendar_prof_end"><span class="calendar_prof_end_line"></span><span class="calendar_prof_end_val">75%</span></div></div>',
				start: '2016-09-04'
			},
			{
				title: '<div class="calendar_prof_item"><div class="parent"><div class="calendar_prof_img"><img src="img/sport_ico1.png" alt=""></div><div class="calendar_prof_cont"><div class="calendar_prof_time">00.30.00</div><div class="calendar_prof_load parent"><span></span><span></span><span></span><span></span><span></span></div></div></div><div class="calendar_prof_end"><span class="calendar_prof_end_line"></span><span class="calendar_prof_end_val">85%</span></div></div>',
				start: '2016-09-05'
			},
			{
				title: '<div class="calendar_prof_item"><div class="parent"><div class="calendar_prof_img"><img src="img/sport_ico2.png" alt=""></div><div class="calendar_prof_cont"><div class="calendar_prof_time">00.30.00</div><div class="calendar_prof_load parent calendar_prof_load_1"><span></span><span></span><span></span><span></span><span></span></div></div></div><div class="calendar_prof_end"><span class="calendar_prof_end_line"></span><span class="calendar_prof_end_val">40%</span></div></div>',
				start: '2016-09-06'
			},
			{
				title: '<div class="calendar_prof_item"><div class="parent"><div class="calendar_prof_img"><img src="img/sport_ico3.png" alt=""></div><div class="calendar_prof_cont"><div class="calendar_prof_time">00.30.00</div><div class="calendar_prof_load parent calendar_prof_load_2"><span></span><span></span><span></span><span></span><span></span></div></div></div><div class="calendar_prof_end"><span class="calendar_prof_end_line"></span><span class="calendar_prof_end_val">65%</span></div></div>',
				start: '2016-09-07'
			},
			{
				title: '<div class="calendar_prof_item"><div class="parent"><div class="calendar_prof_img"><img src="img/sport_ico4.png" alt=""></div><div class="calendar_prof_cont"><div class="calendar_prof_time">00.30.00</div><div class="calendar_prof_load parent calendar_prof_load_3"><span></span><span></span><span></span><span></span><span></span></div></div></div><div class="calendar_prof_end"><span class="calendar_prof_end_line"></span><span class="calendar_prof_end_val">85%</span></div></div>',
				start: '2016-09-08'
			},
			{
				title: '<div class="calendar_prof_item"><div class="parent"><div class="calendar_prof_img"><img src="img/sport_ico5.png" alt=""></div><div class="calendar_prof_cont"><div class="calendar_prof_time">00.30.00</div><div class="calendar_prof_load parent calendar_prof_load_4"><span></span><span></span><span></span><span></span><span></span></div></div></div><div class="calendar_prof_end"><span class="calendar_prof_end_line"></span><span class="calendar_prof_end_val">30%</span></div></div>',
				start: '2016-09-09'
			},
			{
				title: '<div class="calendar_prof_item"><div class="parent"><div class="calendar_prof_img"><img src="img/sport_ico6.png" alt=""></div><div class="calendar_prof_cont"><div class="calendar_prof_time">00.30.00</div><div class="calendar_prof_load parent calendar_prof_load_5"><span></span><span></span><span></span><span></span><span></span></div></div></div><div class="calendar_prof_end"><span class="calendar_prof_end_line"></span><span class="calendar_prof_end_val">40%</span></div></div>',
				start: '2016-09-10'
			},
			{
				title: '<div class="calendar_prof_item"><div class="parent"><div class="calendar_prof_img"><img src="img/sport_ico7.png" alt=""></div><div class="calendar_prof_cont"><div class="calendar_prof_time">00.30.00</div><div class="calendar_prof_load parent calendar_prof_load_4"><span></span><span></span><span></span><span></span><span></span></div></div></div><div class="calendar_prof_end"><span class="calendar_prof_end_line"></span><span class="calendar_prof_end_val">65%</span></div></div>',
				start: '2016-09-11'
			},
			{
				title: '<div class="calendar_prof_item"><div class="parent"><div class="calendar_prof_img"><img src="img/sport_ico1.png" alt=""></div><div class="calendar_prof_cont"><div class="calendar_prof_time">00.30.00</div><div class="calendar_prof_load parent"><span></span><span></span><span></span><span></span><span></span></div></div></div><div class="calendar_prof_end"><span class="calendar_prof_end_line"></span><span class="calendar_prof_end_val">65%</span></div></div>',
				start: '2016-09-12'
			},
			{
				title: '<div class="calendar_prof_item"><div class="parent"><div class="calendar_prof_img"><img src="img/sport_ico2.png" alt=""></div><div class="calendar_prof_cont"><div class="calendar_prof_time">00.30.00</div><div class="calendar_prof_load parent calendar_prof_load_1"><span></span><span></span><span></span><span></span><span></span></div></div></div><div class="calendar_prof_end"><span class="calendar_prof_end_line"></span><span class="calendar_prof_end_val">35%</span></div></div>',
				start: '2016-09-13'
			},
			{
				title: '<div class="calendar_prof_item"><div class="parent"><div class="calendar_prof_img"><img src="img/sport_ico3.png" alt=""></div><div class="calendar_prof_cont"><div class="calendar_prof_time">00.30.00</div><div class="calendar_prof_load parent calendar_prof_load_2"><span></span><span></span><span></span><span></span><span></span></div></div></div><div class="calendar_prof_end"><span class="calendar_prof_end_line"></span><span class="calendar_prof_end_val">85%</span></div></div>',
				start: '2016-09-14'
			},
			{
				title: '<div class="calendar_prof_item"><div class="parent"><div class="calendar_prof_img"><img src="img/sport_ico4.png" alt=""></div><div class="calendar_prof_cont"><div class="calendar_prof_time">00.30.00</div><div class="calendar_prof_load parent calendar_prof_load_3"><span></span><span></span><span></span><span></span><span></span></div></div></div><div class="calendar_prof_end"><span class="calendar_prof_end_line"></span><span class="calendar_prof_end_val">60%</span></div></div>',
				start: '2016-09-15'
			},
			{
				title: '<div class="calendar_prof_item"><div class="parent"><div class="calendar_prof_img"><img src="img/sport_ico5.png" alt=""></div><div class="calendar_prof_cont"><div class="calendar_prof_time">00.30.00</div><div class="calendar_prof_load parent calendar_prof_load_4"><span></span><span></span><span></span><span></span><span></span></div></div></div><div class="calendar_prof_end"><span class="calendar_prof_end_line"></span><span class="calendar_prof_end_val">40%</span></div></div>',
				start: '2016-09-16'
			},
			{
				title: '<div class="calendar_prof_item"><div class="parent"><div class="calendar_prof_img"><img src="img/sport_ico6.png" alt=""></div><div class="calendar_prof_cont"><div class="calendar_prof_time">00.30.00</div><div class="calendar_prof_load parent calendar_prof_load_5"><span></span><span></span><span></span><span></span><span></span></div></div></div><div class="calendar_prof_end"><span class="calendar_prof_end_line"></span><span class="calendar_prof_end_val">25%</span></div></div>',
				start: '2016-09-17'
			},
			{
				title: '<div class="calendar_prof_item"><div class="parent"><div class="calendar_prof_img"><img src="img/sport_ico7.png" alt=""></div><div class="calendar_prof_cont"><div class="calendar_prof_time">00.30.00</div><div class="calendar_prof_load parent calendar_prof_load_4"><span></span><span></span><span></span><span></span><span></span></div></div></div><div class="calendar_prof_end"><span class="calendar_prof_end_line"></span><span class="calendar_prof_end_val">75%</span></div></div>',
				start: '2016-09-18'
			},
			{
				title: '<div class="calendar_prof_item"><div class="parent"><div class="calendar_prof_img"><img src="img/sport_ico1.png" alt=""></div><div class="calendar_prof_cont"><div class="calendar_prof_time">00.30.00</div><div class="calendar_prof_load parent"><span></span><span></span><span></span><span></span><span></span></div></div></div><div class="calendar_prof_end"><span class="calendar_prof_end_line"></span><span class="calendar_prof_end_val">85%</span></div></div>',
				start: '2016-09-19'
			},
			{
				title: '<div class="calendar_prof_item"><div class="parent"><div class="calendar_prof_img"><img src="img/sport_ico2.png" alt=""></div><div class="calendar_prof_cont"><div class="calendar_prof_time">00.30.00</div><div class="calendar_prof_load parent calendar_prof_load_1"><span></span><span></span><span></span><span></span><span></span></div></div></div><div class="calendar_prof_end"><span class="calendar_prof_end_line"></span><span class="calendar_prof_end_val">40%</span></div></div>',
				start: '2016-09-20'
			},
			{
				title: '<div class="calendar_prof_item"><div class="parent"><div class="calendar_prof_img"><img src="img/sport_ico3.png" alt=""></div><div class="calendar_prof_cont"><div class="calendar_prof_time">00.30.00</div><div class="calendar_prof_load parent calendar_prof_load_2"><span></span><span></span><span></span><span></span><span></span></div></div></div><div class="calendar_prof_end"><span class="calendar_prof_end_line"></span><span class="calendar_prof_end_val">65%</span></div></div>',
				start: '2016-09-21'
			},
			{
				title: '<div class="calendar_prof_item"><div class="parent"><div class="calendar_prof_img"><img src="img/sport_ico4.png" alt=""></div><div class="calendar_prof_cont"><div class="calendar_prof_time">00.30.00</div><div class="calendar_prof_load parent calendar_prof_load_3"><span></span><span></span><span></span><span></span><span></span></div></div></div><div class="calendar_prof_end"><span class="calendar_prof_end_line"></span><span class="calendar_prof_end_val">85%</span></div></div>',
				start: '2016-09-22'
			},
			{
				title: '<div class="calendar_prof_item"><div class="parent"><div class="calendar_prof_img"><img src="img/sport_ico5.png" alt=""></div><div class="calendar_prof_cont"><div class="calendar_prof_time">00.30.00</div><div class="calendar_prof_load parent calendar_prof_load_4"><span></span><span></span><span></span><span></span><span></span></div></div></div><div class="calendar_prof_end"><span class="calendar_prof_end_line"></span><span class="calendar_prof_end_val">30%</span></div></div>',
				start: '2016-09-23'
			},
			{
				title: '<div class="calendar_prof_item"><div class="parent"><div class="calendar_prof_img"><img src="img/sport_ico6.png" alt=""></div><div class="calendar_prof_cont"><div class="calendar_prof_time">00.30.00</div><div class="calendar_prof_load parent calendar_prof_load_5"><span></span><span></span><span></span><span></span><span></span></div></div></div><div class="calendar_prof_end"><span class="calendar_prof_end_line"></span><span class="calendar_prof_end_val">40%</span></div></div>',
				start: '2016-09-24'
			},
			{
				title: '<div class="calendar_prof_item"><div class="parent"><div class="calendar_prof_img"><img src="img/sport_ico7.png" alt=""></div><div class="calendar_prof_cont"><div class="calendar_prof_time">00.30.00</div><div class="calendar_prof_load parent calendar_prof_load_4"><span></span><span></span><span></span><span></span><span></span></div></div></div><div class="calendar_prof_end"><span class="calendar_prof_end_line"></span><span class="calendar_prof_end_val">65%</span></div></div>',
				start: '2016-09-25'
			},
			{
				title: '<div class="calendar_prof_item"><div class="parent"><div class="calendar_prof_img"><img src="img/sport_ico1.png" alt=""></div><div class="calendar_prof_cont"><div class="calendar_prof_time">00.30.00</div><div class="calendar_prof_load parent"><span></span><span></span><span></span><span></span><span></span></div></div></div><div class="calendar_prof_end"><span class="calendar_prof_end_line"></span><span class="calendar_prof_end_val">65%</span></div></div>',
				start: '2016-09-26'
			},
			{
				title: '<div class="calendar_prof_item"><div class="parent"><div class="calendar_prof_img"><img src="img/sport_ico2.png" alt=""></div><div class="calendar_prof_cont"><div class="calendar_prof_time">00.30.00</div><div class="calendar_prof_load parent calendar_prof_load_1"><span></span><span></span><span></span><span></span><span></span></div></div></div><div class="calendar_prof_end"><span class="calendar_prof_end_line"></span><span class="calendar_prof_end_val">35%</span></div></div>',
				start: '2016-09-27'
			},
			{
				title: '<div class="calendar_prof_item"><div class="parent"><div class="calendar_prof_img"><img src="img/sport_ico3.png" alt=""></div><div class="calendar_prof_cont"><div class="calendar_prof_time">00.30.00</div><div class="calendar_prof_load parent calendar_prof_load_2"><span></span><span></span><span></span><span></span><span></span></div></div></div><div class="calendar_prof_end"><span class="calendar_prof_end_line"></span><span class="calendar_prof_end_val">85%</span></div></div>',
				start: '2016-09-28'
			},
			{
				title: '<div class="calendar_prof_item"><div class="parent"><div class="calendar_prof_img"><img src="img/sport_ico4.png" alt=""></div><div class="calendar_prof_cont"><div class="calendar_prof_time">00.30.00</div><div class="calendar_prof_load parent calendar_prof_load_3"><span></span><span></span><span></span><span></span><span></span></div></div></div><div class="calendar_prof_end"><span class="calendar_prof_end_line"></span><span class="calendar_prof_end_val">60%</span></div></div>',
				start: '2016-09-29'
			},
			{
				title: '<div class="calendar_prof_item"><div class="parent"><div class="calendar_prof_img"><img src="img/sport_ico5.png" alt=""></div><div class="calendar_prof_cont"><div class="calendar_prof_time">00.30.00</div><div class="calendar_prof_load parent calendar_prof_load_4"><span></span><span></span><span></span><span></span><span></span></div></div></div><div class="calendar_prof_end"><span class="calendar_prof_end_line"></span><span class="calendar_prof_end_val">40%</span></div></div>',
				start: '2016-09-30'
			},
			{
				title: '<div class="calendar_prof_item"><div class="parent"><div class="calendar_prof_img"><img src="img/sport_ico6.png" alt=""></div><div class="calendar_prof_cont"><div class="calendar_prof_time">00.30.00</div><div class="calendar_prof_load parent calendar_prof_load_5"><span></span><span></span><span></span><span></span><span></span></div></div></div><div class="calendar_prof_end"><span class="calendar_prof_end_line"></span><span class="calendar_prof_end_val">25%</span></div></div>',
				start: '2016-10-01'
			},
			{
				title: '<div class="calendar_prof_item"><div class="parent"><div class="calendar_prof_img"><img src="img/sport_ico7.png" alt=""></div><div class="calendar_prof_cont"><div class="calendar_prof_time">00.30.00</div><div class="calendar_prof_load parent calendar_prof_load_4"><span></span><span></span><span></span><span></span><span></span></div></div></div><div class="calendar_prof_end"><span class="calendar_prof_end_line"></span><span class="calendar_prof_end_val">75%</span></div></div>',
				start: '2016-10-02'
			}
		],
	    eventAfterAllRender: function( view ) {
	        $('.calendar_prof_end').each(function(){
	        	$(this).find('.calendar_prof_end_line').css('width', $(this).find('.calendar_prof_end_val').text());
	        });
	    }
	});
	
});




$(document).ready(function() {

/* Анкета */
    /*var a_id = $('.anketa_block_nav').find('li span.anketa_active').parent().index();
	$('.anketa_block_item').hide();
	$('.anketa_block_item:nth-child(' + (a_id + 1) + ')').show();*/

$('.anketa_block_nav li:first-child').click(function(){
	$('.anketa_block_nav li span').removeClass('anketa_active');
	$(this).find('span').addClass('anketa_active');
	$('.anketa_block_item').hide();
	$('.anketa_block_item:first-child').show();
});
$('.anketa_block_nav li:nth-child(2)').click(function(){
	$('.anketa_block_nav li span').removeClass('anketa_active');
	$(this).find('span').addClass('anketa_active');
	$('.anketa_block_item').hide();
	$('.anketa_block_item:nth-child(2)').show();
});
$('.anketa_block_nav li:nth-child(3)').click(function(){
	$('.anketa_block_nav li span').removeClass('anketa_active');
	$(this).find('span').addClass('anketa_active');
	$('.anketa_block_item').hide();
	$('.anketa_block_item:nth-child(3)').show();
});
$('.anketa_block_nav li:nth-child(4)').click(function(){
	$('.anketa_block_nav li span').removeClass('anketa_active');
	$(this).find('span').addClass('anketa_active');
	$('.anketa_block_item').hide();
	$('.anketa_block_item:nth-child(4)').show();
});


/* tren set */

/*$(".tren_set_form_add").click(function(){
	$(".tren_set_form_pop_up").fadeIn(200);
});
$(".tren_set_form_pop_up_close").click(function(){
	$(".tren_set_form_pop_up").fadeOut(200);
});*/


/* чат */

/*$(".chat_contact").click(function(){
	$(".chat_contact").removeClass("chat_contact_active");
	$(this).addClass("chat_contact_active");
	$(".chat_prof_block").hide();
	$(".chat_mess_block").show();
});
$(".chat_contact_img").click(function(event){
	if($(".chat_contact_cont").css("display") != "none"){
		event.stopPropagation();
		$(".chat_mess_block").hide();
		$(".chat_prof_block").show();
	}
});*/
$(".chat_block_h_slide").click(function() {
	if($(".chat_contact_block_h .chat_block_h_buts").css("display") == "none"){
		if($(this).hasClass("hide_chat")){
			$(this).removeClass("hide_chat");
			$(this).parents(".chat_content_block_wrap").find(".chat_block_val, .chat_prof_block_val, .mess_block_val").slideDown(200);
		} else{
			$(this).addClass("hide_chat");
			$(this).parents(".chat_content_block_wrap").find(".chat_block_val, .chat_prof_block_val, .mess_block_val").slideUp(200);
		}
	} else{
		if($(this).hasClass("hide_chat")){
			if($(this).parents(".chat_contact_block").length > 0){
				$(this).removeClass("hide_chat");
				$(this).parents(".chat_contact_block").find(".chat_block_val").slideDown(200);
			} else{
				$(this).parents(".chat_mess_block_wrap").find(".chat_block_h_slide").removeClass("hide_chat");
				$(this).parents(".chat_mess_block_wrap").find(".chat_prof_block_val, .mess_block_val").slideDown(200);
			}
		} else{
			if($(this).parents(".chat_contact_block").length > 0){
				$(this).addClass("hide_chat");
				$(this).parents(".chat_contact_block").find(".chat_block_val").slideUp(200);
			} else{
				$(this).parents(".chat_mess_block_wrap").find(".chat_block_h_slide").addClass("hide_chat");
				$(this).parents(".chat_mess_block_wrap").find(".chat_prof_block_val, .mess_block_val").slideUp(200);
			}
		}
	}
});
$(".chat_block_h_close").click(function() {
	if($(".chat_contact_block_h .chat_block_h_buts").css("display") == "none"){
		$(this).parents(".chat_content_block_wrap").slideUp(200);
	} else{
		if($(this).parents(".chat_contact_block").length > 0){
			$(this).parents(".chat_contact_block").slideUp(200);
		} else{
			$(this).parents(".chat_mess_block_wrap").slideUp(200);
		}
	}
});
$(".chat_mob_but").click(function() {
	if($(this).hasClass("chat_mob_act")){
		$(this).removeClass("chat_mob_act");
		$(this).parents(".chat_content_block_wrap").removeClass("chat_content_block_wrap_active");
	} else{
		$(this).addClass("chat_mob_act");
		$(this).parents(".chat_content_block_wrap").addClass("chat_content_block_wrap_active");
	}
});
$(".chat_search_mob_but").click(function() {
	$(this).parents(".chat_content_block_wrap").find(".chat_mob_but").addClass("chat_mob_act");
	$(this).parents(".chat_content_block_wrap").addClass("chat_content_block_wrap_active");
	$(this).parents(".chat_content_block_wrap").find(".chat_search_in").focus();
});


/* поп-ап */

/*if($("#home_pop-up").length > 0){
	$("body").append("<div id='shadow2'></div>");
	setTimeout(function(){pop_up_home($("#home_pop-up"))}, 10000);
}*/

if($("#policy_pop-up").length > 0){
    $(".policy").on('click', function(){
        event.preventDefault();
        var popup = $("#policy_pop-up"),
            shadow = $("#shadow");

        if (shadow.length == 0)
        {
            $("body").append("<div id='shadow'></div>");
            shadow = $("#shadow");
        }

        popup.css({marginLeft:-popup.width()/2,marginTop:-popup.height()/2}).fadeIn(600);
        $("#shadow, .policy_pop-up_close").fadeTo(600,0.8).click(function() {
            shadow.fadeOut(600);
            popup.fadeOut(600);
        });
    });
}


/* подсказка */

/*if($("[data-info]").length > 0){
	$("[data-info]").each(function(){
		$(this).wrapAll("<div class='data_info_block_wrap'></div>");
		$(this).parents(".data_info_block_wrap").append("<div class='data_info_block'>"+$(this).data('info')+"</div>");
	});
}

$(".data_info_block_wrap").hover(
function(){
	if($(this).find(".data_info_block").length > 0){
		$(this).find(".data_info_block").stop(true, true).fadeIn(300);
	}
},
function(){
	$(".data_info_block").fadeOut(300);
}
);*/


/* оформление заказа */

$(".ordering_next1").click(function(){
	$(".ordering_block1").css('display','none');
	$(".ordering_block2").css('display','block');

    $(".info_ordering_t_name").text($("input[name=i_o_surname]").val());
    $(".info_ordering_name").text($("input[name=i_o_name]").val());
    $(".info_ordering_email").text($("input[name=i_o_email]").val());
    $(".edit_email input[name=e_email]").val($("input[name=i_o_email]").val());
    $(".info_ordering_type").text($("input[name=i_o_delivery]:checked").val());

	if ($("select[name=s_o_address] option:selected").val() != '') {
        $(".info_ordering_country").text($("select[name=s_o_address] option:selected").text());
    }
    else {
        $(".info_ordering_street").text($("input[name=i_o_street]").val());
        $(".info_ordering_house").text($("input[name=i_o_house]").val());
        $(".info_ordering_building").text($("input[name=i_o_building]").val());
        $(".info_ordering_index").text($("input[name=i_o_postcode]").val());
        $(".info_ordering_city").text($("input[name=i_o_city]").val());
        $(".info_ordering_country").text($("input[name=i_o_country]").val());
    }

	if(!$(".ordering_block_tov_slider2").hasClass("slick-initialized")){
		$('.ordering_block_tov_slider2').slick({
			infinite: false,
			dots: false,
			arrows: true,
			speed: 500,
			slidesToShow: 1,
			slidesToScroll: 1,
			vertical: true
		});
	}
    var destination = $("h2.ordering_block_title").offset().top;
    $("html, body").animate({scrollTop: destination },"slow");
});
$(".ordering_next2").click(function(){
	$(".ordering_block2").css('display','none');
	$(".ordering_block3").css('display','block');
	$(".info_ordering_pay").text($("input[name=i_o_payment]:checked").val());
	var summ = 0;
	$(".ordering_tov_summ").each(function(){
		summ += parseFloat($(this).text().replace(/\s/g, ""));
	});
	$(".info_ordering_price").text(String(parseFloat(summ).toFixed(2)).replace(/(\d)(?=(\d\d\d)+([^\d]|$))/g, '$1 '));

    var destination = $("h2.ordering_block_title").offset().top;
    $("html, body").animate({scrollTop: destination },"slow");
});
$(".ordering_prev1").click(function(){
	$(".ordering_block2").css('display','none');
	$(".ordering_block1").css('display','block');

    var destination = $("h2.ordering_block_title").offset().top;
    $("html, body").animate({scrollTop: destination },"slow");
});
$(".ordering_prev2").click(function(){
	$(".ordering_block3").css('display','none');
	$(".ordering_block2").css('display','block');

    var destination = $("h2.ordering_block_title").offset().top;
    $("html, body").animate({scrollTop: destination },"slow");
});
$(".ordering_block_side_info_edit").click(function(){
	$(".ordering_block").css('display','none');
	$(".ordering_block1").css('display','block');

    var destination = $("h2.ordering_block_title").offset().top;
    $("html, body").animate({scrollTop: destination },"slow");
});
$(".ordering_block_side_email_edit").click(function(){
    $(".info_edit_email").toggle();
    $(".info_ordering_email").toggle();
});
$(".edit_email_save").click(function(){
    var edit_email = $(".edit_email input[name=e_email]").val(),
        confirm = $(".edit_email_confirm input[name=e_email_confirm]").val();
    if(edit_email == confirm && edit_email != '')
    {
        $(".info_ordering_email").text(edit_email);
        $("input[name=i_o_email]").val(edit_email);
        $(".edit_email_confirm input[name=e_email_confirm]").val('');

        $(".info_edit_email").css('display','none');
        $(".info_ordering_email").css('display','block');
    }
});
$("input.tov_number").change(function(){
    var b_p     = $(this),
        p_id    = b_p.parents('.ordering_block_col_cont').children('input#c_id').val(),
        c_ap_id = b_p.parents('.ordering_block_col_cont').children('input#c_ap_id').val(),
        p_q     = b_p.val(),
        b_p_sum = b_p.parents(".busket_block_tab_item").find(".ordering_tov_summ #product_sum"),
        p_p     = b_p.parents(".busket_block_tab_item").find(".ordering_tov_price"),
        p_sum   = 0;

    $.ajax({
        url: '/updateCartProduct',
        type: 'post',
        dataType: 'json',
        data: {
            product_id: p_id,
            product_a_id: c_ap_id,
            product_quantity: p_q
        },
        complete: function (result) {
            var data = result.responseJSON;

            if ($.isNumeric(data.cart)) {
                p_sum = data.cart * parseFloat(p_p.text().replace(/\s/g, ""));
                b_p_sum.text(String(parseFloat(p_sum).toFixed(2)).replace(/(\d)(?=(\d\d\d)+([^\d]|$))/g, '$1 '));
                b_p.val(data.cart);

                totalCartPrice();
            }
        }
    });
});

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
            $(".info_ordering_price").text(String(parseFloat(sum_price).toFixed(2)).replace(/(\d)(?=(\d\d\d)+([^\d]|$))/g, '$1 '));
            $(".info_ordering_currency").text(" руб.");
        }
        if (sum_fc == NaN || sum_fc == 0) {
            $(".info_ordering_fc_price").text("");
            $("#info_ordering_fc_currency").text("");
        } else {
            $(".info_ordering_fc_price").text(String(parseFloat(sum_fc).toFixed(2)).replace(/(\d)(?=(\d\d\d)+([^\d]|$))/g, '$1 '));
            $("#info_ordering_fc_currency").text(" FitCoin");
        }
    }



$('.graf_block_grafik_item').each(function(){
	$(this).css('height', $(this).text()).text(' ');
});
$('.graf_procent_val').each(function(){
	$(this).find('.graf_procent_val_line').css('width', $(this).find('.graf_procent_val_txt').text());
});

/* выравнивание блоков */

//$(".spec_block").height($(".new_kurs_block").height());


/* автоувеличение textarea */

$('.contact_textarea, .mess_block_in').autoResize();


/* оформление формы */

$('.filtr_form input, .one_tov_num, #one_tov_dop_in, #ordering_check, .ordering_radio_wrap input, .tov_number, .anketa_form_select, .journal_form_select').styler();


/* Цвет */

$('.one_tov_color_item').each(function() {
	$(this).css('background', $(this).text()).text('');
});


/* субменю */

$(".submenu_li").hover(
	function () {
		$(this).find(".submenu").fadeIn(200);
	},
	function () {
		$(this).find(".submenu").stop(true, true);
		$(this).find(".submenu").fadeOut(200);
	}
);


/* видео */

if(getInternetExplorerVersion()==-1){

    if($(".video_kurs.def_video").length > 0){
		$(".video_kurs.def_video").each(function() {
			new InitPxVideo({
				"videoId": this,
				"captionsOnDefault": false,
				"seekInterval": 20,
				"videoTitle": "Promo",
				"debug": true
			});
		});
	}

	if($(".video_cont.def_video").length > 0){
		$(".video_cont.def_video").each(function() {
			new InitPxVideo({
				"videoId": this,
				"captionsOnDefault": false,
				"seekInterval": 20,
				"videoTitle": "Promo",
				"debug": true
			});
		});
	}

}



/* Поиск в магазине */

$(".open_search_form").click(function() {
	if($(this).hasClass("open_search")){
		$(this).removeClass("open_search");
		$(".shop_search_form").slideUp(200);
	} else{
		$(this).addClass("open_search");
		$(".shop_search_form").slideDown(200);
	}
});








/* поп-ап с видеоплеером */

/*$( "#calendar" ).on( "click", ".fc-event-container a", function() {
	video_url = $(this).attr("href");
	$("#myvid").html('<div class="px-video-img-captions-container"><div class="px-video-captions hide"></div><video poster="img/video_img.png" controls><source src="'+video_url+'" type="video/mp4"><div><a href="'+video_url+'"><img src="img/video_img.png" alt="download video"></a></div></video></div><div class="px-video-controls"></div>')
    if(getInternetExplorerVersion()==-1){
        $("#myvid").each(function() {
            new InitPxVideo({
                "videoId": this,
                "captionsOnDefault": false,
                "seekInterval": 20,
                "videoTitle": "Promo",
                "debug": true
            });
        });
	}
	pop_up_def($("#pop-up_video"));
	return false;
});*/


/* скрытие и удаление блоков в профиле */

$(".chart_wrap_slide").click(function() {
	if($(this).hasClass("hide_chart")){
		$(this).removeClass("hide_chart");
		$(".chart_wrap").slideDown(200);
	} else{
		$(this).addClass("hide_chart");
		$(".chart_wrap").slideUp(200);
	}
});

$(".calendar_slide").click(function() {
	if($(this).hasClass("hide_chart")){
		$(this).removeClass("hide_chart");
		$(".fc-view-container").slideDown(200);
	} else{
		$(this).addClass("hide_chart");
		$(".fc-view-container").slideUp(200);
	}
});

$(".close_video, #shadow").click(function() {
	setTimeout(function(){
		$(".px-video-img-captions-container, .px-video-controls").remove();
	},200);
});

});