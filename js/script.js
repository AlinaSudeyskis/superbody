function getInternetExplorerVersion() {
    var rv = -1, ua, re;
    if (navigator.appName === 'Microsoft Internet Explorer')
    {
        ua = navigator.userAgent;
        re = new RegExp("MSIE ([0-9]+[\.0-9]*)");
        if (re.exec(ua) !== null)
            rv = parseFloat( RegExp.$1 );
    }
    else if (navigator.appName === 'Netscape')
    {
        ua = navigator.userAgent;
        re = new RegExp("Trident/.*rv:([0-9]+[\.0-9]*)");
        if (re.exec(ua) !== null)
            rv = parseFloat( RegExp.$1 );
    }
    return rv;
}
$(document).ready(function () {
    tinymce.init({
        selector: "textarea.formatted_textarea",
        menubar: false,
        statusbar: false,
        theme: 'silver',
        language_url: '/js/tinymce/langs/ru.js',
        plugins: "textcolor colorpicker bbcode",
        toolbar: "undo redo | bold italic | forecolor",
        max_chars_indicator: "pageLength"
    });

    /* Видео превью */
    function secondsToTime(time) {
        var h = Math.floor(time / (60 * 60)),
            dm = time % (60 * 60),
            m = Math.floor(dm / 60),
            ds = dm % 60,
            s = Math.ceil(ds),
            full_time;
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
            full_time = m + ':' + s;
        } else {
            full_time = h + ':' + m + ':' + s;
        }
        return full_time;
    }

    function getVideoTime(vid_id, time_block_id) {
        var vid = document.getElementById(vid_id),
            time_block = document.getElementById(time_block_id);
        if (!!vid && !!time_block) {
            vid.addEventListener('loadedmetadata', function () {
                time_block.innerHTML = secondsToTime(vid.duration);
            }, false);
        }
    }

    var pr_bl_add_tov_val_item = $(".practice_block .add_tov_val_item");
    if (pr_bl_add_tov_val_item.length > 0) {
        pr_bl_add_tov_val_item.each(function () {
            var video_id = $(this).find("video").attr("id"),
                time_id = $(this).find(".add_kurs_val_video").find("div").attr("id");
            if (!!video_id && !!time_id) {
                getVideoTime(video_id, time_id);
            }
        });
    }

    // Форма оплаты
    var opacity = 0.8,
        purchase = $("#purchase_pop-up"),
        shadow2 = $("#shadow2");

    if (purchase.length > 0) {
        if (purchase.hasClass("ref_pop-up")) {
            purchase_up();
        }

        $(".lp_block_but, .lp_block_but_crs").on('click', function (event) {
            event.preventDefault();
            purchase_up();
        });
        $(".lp_block_but_crs").on('click', function (event) {
            event.preventDefault();
            purchase_up('full');
        });
        $(".lp_block_but_rec_crs").on('click', function (event) {
            event.preventDefault();
            purchase_up('rec');
        });

        if (purchase.hasClass("ref_pop-up")) {
            purchase_up();
        }

        $(".buy_course").on('click', function (event) {
            event.preventDefault();
            var cid  = $(this).data('cid'),
                oid  = $(this).data('oid'),
                po   = $(this).data('po'),
                pc_s = $('#pc-string').val();
            purchase_form = $('.purchase_form');

            $.ajax({
                url: '/dataCourse',
                type: 'post',
                dataType: 'json',
                data: {
                    cid: cid,
                    oid: oid,
                    pc_s: pc_s
                },
                complete: function (result) {
                    var data = result.responseJSON;
                    if (data.crs) {
                        purchase_form.html(data.crsd);

                        var auth_form = purchase_form.next('.purchase_pop-up_h.auth_form');
                        auth_form.toggle();

                        purchase_up(po);
                        $('.anketa_form_select, .journal_form_select').styler();

                        purchase_form.find(".promo_line").on('click', function () {
                            promo_line_func($(this));
                        });

                        purchase_form.find("a.policy").on('click', function (event) {
                            event.preventDefault();
                            show_policy();
                        });

                        purchase_form.find("input[name='bt_buy_course']").on('click', function (event) {
                            event.preventDefault();
                            var this_form = $(this).parents('form'),
                                user_id = this_form.find('#user-id').val(),
                                user_email = this_form.find('input[name="email"]').val();

                            if(!$.isNumeric(user_id) && !user_email)
                            {
                                purchase_form.toggle();
                                auth_form.toggle();
                                purchase.css({marginLeft: -purchase.width() / 2, marginTop: -purchase.height() / 2});
                            }
                            else
                            {
                                this_form.submit();
                            }
                        });

                        purchase_form.find('.turn_auth').on('click', function(e){
                            e.preventDefault();
                            purchase_form.toggle();
                            auth_form.toggle();
                            purchase.css({marginLeft: -purchase.width() / 2, marginTop: -purchase.height() / 2});
                        });

                        purchase.find('.return_purchase').on('click', function(e){
                            e.preventDefault();
                            purchase_form.toggle();
                            auth_form.toggle();
                            purchase.css({marginLeft: -purchase.width() / 2, marginTop: -purchase.height() / 2});
                        });

                        /*purchase_form.on('paste', ' #i-promocode', function () {
                            var pc_input = $(this);
                            searchPromo(pc_input);
                        });
                        purchase_form.on('keyup', ' #i-promocode', function () {
                            var pc_input = $(this);
                            searchPromo(pc_input);
                        });*/

                        purchase_form.on('change', '#payment-options', function () {
                            payment_options_func($(this));
                        });

                        purchase_form.on('change', '#payment-methods', function () {
                            payment_methods_func($(this));
                        });
                    }
                }
            });
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

    // Обратный отсчет
    var x = setInterval(function () {
        $('.countdown').each(function (i, obj) {
            var countDownDateBlock = $(this).parent().find('.date_countdown'),
                countDownDate = countDownDateBlock.val();

            if (countDownDateBlock.val() !== "") {
                // Get todays date and time
                var now = new Date().getTime();

                // Find the distance between now an the count down date
                var distance = countDownDate - now;

                // Time calculations for days, hours, minutes and seconds
                var days = Math.floor(distance / (1000 * 60 * 60 * 24)),
                    hours = String(Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60))),
                    minutes = String(Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60))),
                    seconds = String(Math.floor((distance % (1000 * 60)) / 1000));

                if (hours.length === 1) {
                    hours = "0" + hours;
                }
                if (minutes.length === 1) {
                    minutes = "0" + minutes;
                }
                if (seconds.length === 1) {
                    seconds = "0" + seconds;
                }

                // Display the result in the element with id="countdown"
                $(this).html(days + "<span>дн.</span> " + hours + "<span>ч.</span> "
                    + minutes + "<span>мин.</span> " + seconds + "<span>сек.</span>");

                // If the count down is finished, write some text
                if (distance < 0) {
                    clearInterval(x);
                    $(this).html('');
                    countDownDateBlock.val("");
                }
            } else {
                clearInterval(x);
                $(this).html('');
            }
        });
    }, 1000);


    /* Добавление опции */

    $(".add_new_options_but").on('click', function () {
        $(this).parents(".lend_form_options_wrap").find(".new_form_option_wrap").show();
    });
    $(".add_form_option").on('click', function () {
        var val = $(this).parents(".new_form_option_wrap").find(".new_form_option").val(),
            num = $(this).parents(".lend_form_options_wrap").find(".tren_form_block_radio_wrap").length + 1,
            param = "";
        if ($(this).parents("form").hasClass("edit_lend_form")) {
            param = "e";
        }
        if (val !== '') {
            $(this).parents(".lend_form_options_wrap").find(".lend_form_options").append('<div class="tren_form_block_radio_wrap"><input type="radio" name="radio1a' + param + '" class="tren_form_block_radio" id="tren_form_block_radio' + num + 'a' + param + '" value="' + val + '"><label for="tren_form_block_radio' + num + 'a' + param + '">' + val + '</label></div>');
            $(this).parents(".new_form_option_wrap").find(".new_form_option").val('');
            $(this).parents(".new_form_option_wrap").hide();
        }
    });


    /* Формирование тренировок */

    $(".kurs_time_in, .kurs_length_in").on('change keyup', function () {
        var kurs_time_in = $(this).parents("form").find("input.kurs_time_in").val(),
            kurs_length_in = $(this).parents("form").find("select.kurs_length_in").val(),
            kurs_length_out = $(this).parents("form").find(".practice_block").length,
            kurs_length_weeks = $(this).parents("form").find(".practice_weeks").length,
            kurs_length_days = $(this).parents("form").find(".practice_day").length,
            active_practice_block = $('.practice_day.active').attr('id'),
            video_list = $(".form_video_list").html(),
            index, rez_w, rez_d, rez, html_table = '', html = '', option, num,
            i = 1, tr_week = 1, tr_day = 1,
            block_id, active_class = "", a;

        if ($(this).parents("form").hasClass("edit_kurs_form")) {
            index = "e";
        } else if ($(this).parents("form").hasClass("add_kurs_form")) {
            index = "a";
        } else {
            index = "o";
        }
        if (kurs_time_in !== 0 && kurs_length_in !== 0 && kurs_length_weeks < 1) {
            rez = kurs_time_in * kurs_length_in;
            while (tr_week <= kurs_time_in) {
                html_table = html_table + '<div class="practice_weeks"><div class="practice_week"><span>Неделя</span> ' + tr_week + '</div>' +
                    '<div class="practice_days">';
                tr_day = 1;
                while (tr_day <= kurs_length_in) {
                    block_id = 'practice' + i;
                    active_class = "";
                    if (active_practice_block === block_id) {
                        active_class = "active";
                    }
                    html_table = html_table + '<div class="practice_day ' + active_class + '" id="practice' + i + '">Т ' + tr_day + '</div>';
                    tr_day++;
                    i++;
                }
                html_table = html_table + '</div></div>';
                tr_week++;
            }
            $(".practice_block_table").html(html_table);

            i = 1;
            html = '<div class="practice_block" id="practice' + i + '_block"><div class="practice_block_h">Тренировка №' + i + '</div><div class="add_tov_in_total"><div class="add_tov_in video"><input type="text" name="name_video[' + i + ']" class="admin_form_txt" placeholder="Введите наименование или ID видео"><div class="add_tov_list">' + video_list + '</div></div><div class="add_tov_val"></div><input type="hidden" name="id_video[' + i + ']" value="" id="id-video' + i + '"/></div><textarea name="ta_workout_desc[' + i + ']" class="tov_form_textarea" placeholder="Введите описание тренировки"></textarea></div>';
            option = '<option value="' + i + '">Тренировка №' + i + '</option>';
            while (i < rez) {
                i++;
                html = html + '<div class="practice_block" id="practice' + i + '_block"><div class="practice_block_h">Тренировка №' + i + '</div><div class="add_tov_in_total"><div class="add_tov_in video"><input type="text" name="name_video[' + i + ']" class="admin_form_txt" placeholder="Введите наименование или ID видео"><div class="add_tov_list">' + video_list + '</div></div><div class="add_tov_val"></div><input type="hidden" name="id_video[' + i + ']" value="" id="id-video' + i + '"/></div><textarea name="ta_workout_desc[' + i + ']" class="tov_form_textarea" placeholder="Введите описание тренировки"></textarea><div class="tren_repeat_total"><div class="tren_form_block_check_wrap"><input type="checkbox" name="cb_repeat_workout[' + i + ']" class="tren_form_block_check" id="tren_form_block_check' + i + index + '"><label for="tren_form_block_check' + i + index + '">Повтор тренировок</label></div><select name="s_repeat_workout[' + i + ']" class="journal_form_select">' + option + '</select></div></div>';
                option = option + '<option value="' + i + '">Тренировка №' + i + '</option>';
            }
            $(this).parents("form").find(".practice_block_wrap").html(html);
            $(this).parents("form").find(".practice_block_wrap").find(".journal_form_select").styler();
        } else if (kurs_time_in !== 0 && kurs_length_in !== 0 && kurs_length_weeks >= 1) {
            rez_w = kurs_time_in - kurs_length_weeks;
            rez_d = kurs_time_in * kurs_length_in - kurs_length_days;
            if (rez_w > 0) {
                tr_week = kurs_length_weeks + 1;
                i = kurs_length_weeks * kurs_length_in + 1;
                while (tr_week <= kurs_time_in) {
                    html_table = html_table + '<div class="practice_weeks"><div class="practice_week"><span>Неделя</span> ' + tr_week + '</div>' +
                        '<div class="practice_days">';
                    tr_day = 1;
                    while (tr_day <= kurs_length_in) {
                        html_table = html_table + '<div class="practice_day" id="practice' + i + '">Т ' + tr_day + '</div>';
                        tr_day++;
                        i++;
                    }
                    html_table = html_table + '</div></div>';
                    tr_week++;
                }
                $(".practice_block_table").append(html_table);
            } else if (rez_w < 0) {
                i = 0;
                while (i > rez_w) {
                    $(this).parents("form").find(".practice_weeks:nth-of-type(" + (kurs_length_weeks + i) + ")").remove();
                    i--;
                }
            }

            if (rez_d !== 0 && rez_w === 0) {
                var tr_week_d = 1;
                $(this).parents("form").find(".practice_weeks").each(function () {
                    var this_week = $(this), html_table = '', i = 1;

                    tr_day = 1;
                    while (tr_day <= kurs_length_in) {
                        html_table = html_table + '<div class="practice_day" id="practice' + i + '">Т ' + tr_day + '</div>';
                        tr_day++;
                        i++;
                    }
                    this_week.children('.practice_days').html(html_table);
                });
            }

            rez = kurs_time_in * kurs_length_in - kurs_length_out;
            //$(this).parents("form").find(".practice_block").show();
            if (rez_d > 0) {
                num = kurs_length_out + 1;
                i = 0;
                a = 1;
                html = '';
                option = '';
                while (a <= kurs_length_out) {
                    option = option + '<option value="' + a + '">Тренировка №' + a + '</option>';
                    a++;
                }
                while (i < rez) {
                    html = '<div class="practice_block" id="practice' + num + '_block"><div class="practice_block_h">Тренировка №' + num + '</div><div class="add_tov_in_total"><div class="add_tov_in video"><input type="text" name="name_video[' + num + ']" class="admin_form_txt" placeholder="Введите наименование или ID видео"><div class="add_tov_list">' + video_list + '</div></div><div class="add_tov_val"></div><input type="hidden" name="id_video[' + num + ']" value="" id="id-video' + num + '"/></div><textarea name="ta_workout_desc[' + num + ']" class="tov_form_textarea" placeholder="Введите описание тренировки"></textarea><div class="tren_repeat_total"><div class="tren_form_block_check_wrap"><input type="checkbox" name="cb_repeat_workout[' + num + ']" class="tren_form_block_check" id="tren_form_block_check' + num + index + '"><label for="tren_form_block_check' + num + index + '">Повтор тренировок</label></div><select name="s_repeat_workout[' + num + ']" class="journal_form_select">' + option + '</select></div></div>';
                    $(this).parents("form").find(".practice_block_wrap").append(html);
                    option = option + '<option value="' + num + '">Тренировка №' + num + '</option>';
                    i++;
                    num++;
                }
                //$(this).parents("form").find(".practice_block_wrap").append(html);
                $(this).parents("form").find(".practice_block_wrap").find(".journal_form_select").styler();
                $('#' + active_practice_block + '_block').show();
            } else if (rez_d < 0) {
                i = 0;
                while (i > rez) {
                    $(this).parents("form").find(".practice_block:nth-of-type(" + (kurs_length_out + i) + ")").hide();
                    i--;
                }
            }
        }
    });
    $(".practice_block_wrap").on('click', '.tren_form_block_check', function () {
        var practice_block_id = $(this).val();

        if ($(this).is(':checked')) {
            $(".journal_form_select option[value='" + practice_block_id + "']").hide();
            $(".jq-selectbox__dropdown").each(function () {
                var ul = $(this).find('ul');
                ul.find('li:contains("Тренировка №' + practice_block_id + '")').hide();
            });
        } else {
            $(".journal_form_select option[value='" + practice_block_id + "']").show();
            $(".jq-selectbox__dropdown").each(function () {
                var ul = $(this).find('ul');
                ul.find('li:contains("Тренировка №' + practice_block_id + '")').show();
            });
        }
    });

    /* Выбор курсов тренировок для отображения в календаре */
    $("input:checkbox.calendar_course").on('click', function () {
        if ($.isNumeric($(this).val())) {
            var crs_id = $(this).val(),
                display = 0;

            if ($(this).is(':checked')) display = 1;

            $.ajax({
                url: '/displayCourse',
                type: 'post',
                dataType: 'json',
                data: {crs_id: crs_id, display: display},
                complete: function (result) {
                    var data = result.responseJSON;
                }
            });
        }
    });

    /* Выбор курсов питания для отображения в календаре */
    $("input[name=r_calendar_nutrition]:radio").on('click', function () {
        if ($.isNumeric($(this).val())) {
            var crs_id = $(this).val(),
                display = 0;

            if ($(this).is(':checked')) display = 1;

            $.ajax({
                url: '/displayNutrition',
                type: 'post',
                dataType: 'json',
                data: {crs_id: crs_id, display: display},
                complete: function (result) {
                    var data = result.responseJSON;
                }
            });
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

    /*$(document).on('click', function(event) {
        if ($(event.target).closest(".add_tov_in input:text").length) return;
        $(".add_tov_list").hide();
        event.stopPropagation();
    });*/


    /* видео */

    if (getInternetExplorerVersion() === -1) {
        var video_cont = $('.video_cont');
        if (video_cont.length > 0) {
            video_cont.each(function () {
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

    $(".px-video-controls button").on('click', function () {
        return false;
    });


    /* оформление input file */

    var file_api = !!(window.File && window.FileReader && window.FileList && window.Blob);
    $(document).on('change', '.admin_form_videofile', function () {
        var inp = $(this);
        var lbl = inp.parents(".video_down_line").find(".video_down_line_name");
        var file_name;

        if (file_api)
            $.each(inp[0].files, function (index, value) {
                if (index === 0) {
                    file_name = value.name;
                } else {
                    file_name = file_name + ', ' + value.name;
                }
            });
        //file_name = inp[ 0 ].files[ 0 ].name;
        else
            file_name = inp.val().replace("C:\\fakepath\\", '');

        if (!file_name.length)
            return;

        lbl.text(file_name);
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

    $(".mob_menu_but").on('click', function () {
        if ($(this).hasClass("mob_open")) {
            $(this).removeClass("mob_open");
            $(".header_menu").fadeOut(200);
            $("body").removeClass("mob_body");
        } else {
            $(this).addClass("mob_open");
            $(".header_menu").fadeIn(200);
            $("body").addClass("mob_body");
        }
    });

    $(".mob_side_menu_but").on('click', function () {
        $(".profile_menu, .mob_side_menu_close").fadeIn(200);
        $("body").addClass("side_mob_body");
    });
    $(".mob_side_menu_close span").on('click', function () {
        $(".profile_menu, .mob_side_menu_close").fadeOut(200);
        $("body").removeClass("side_mob_body");
    });

    if ($(window).width() <= 991) {
        $(document).on('click', function (event) {
            if ($(event.target).closest(".header_mid").length) return;
            $(".mob_menu_but").removeClass("mob_open");
            $("body").removeClass("mob_body");
            $(".header_menu").fadeOut(200);
            event.stopPropagation();
        });
    }
    if ($(window).width() < 480) {
        $(document).on('click', function (event) {
            if ($(event.target).closest(".left_sidebar").length) return;
            $(".mob_side_menu_but").removeClass("mob_open");
            $("body").removeClass("side_mob_body");
            $(".profile_menu, .mob_side_menu_close").fadeOut(200);
            event.stopPropagation();
        });
    }
    $('.more_submenu').on('click', function(){
        $(this).parents('.submenu_li').children('.submenu').toggle();
    });

    /* скрытие блоков */

    $(".up_but_main").on('click', function () {
        if ($(this).hasClass("hide_chart")) {
            $(this).removeClass("hide_chart");
            $('.header_bg').slick("slickPlay");
            $(".main_bg_wrap").slideDown(200);
        } else {
            $(this).addClass("hide_chart");
            $(".main_bg_wrap").slideUp(200);
            $('.header_bg').slick("slickPause");
        }
    });

    /* скрытие и удаление блоков в профиле */

    $(".up_but_bot").on('click', function () {
        if ($(this).hasClass("hide_chart")) {
            $(this).removeClass("hide_chart");
            $('.prezent_head').removeClass("hide_chart");
            $('.header_bg').slick("slickPlay");
            $(".header_bg_wrap").slideDown(200);
        } else {
            $(this).addClass("hide_chart");
            $('.prezent_head').addClass("hide_chart");
            $(".header_bg_wrap").slideUp(200);
            $('.header_bg').slick("slickPause");
        }
    });

    $(".up_but_top").on('click', function () {
        if ($(this).hasClass("hide_chart")) {
            $(this).removeClass("hide_chart");
            $(".hid_header").slideDown(200);
        } else {
            $(this).addClass("hide_chart");
            $(".hid_header").slideUp(200);
        }
    });

    $(".kurs_slide").on('click', function () {
        var block_h_buts = $(this).parent('.content_block_h_buts'),
            content_block_h = block_h_buts.parent('.content_block_h'),
            content_block = content_block_h.parent(".content_block"),
            block = content_block.find(".kurs_block_val");
        if ($(this).hasClass("hide_chart")) {
            $(this).removeClass("hide_chart");
            block.slideDown(200);
        } else {
            $(this).addClass("hide_chart");
            block.slideUp(200);
        }
    });

    $(".meta_slide, .price_slide").on('click', function () {
        if ($(this).hasClass("hide_chart")) {
            $(".meta_slide").addClass("hide_chart");
            $(".price_slide").addClass("hide_chart");
            $(".content_block_internal").find(".kurs_block_val").slideUp(200);
            $(this).removeClass("hide_chart");
            $(this).parents(".content_block_internal").find(".kurs_block_val").slideDown(200);
        } else {
            $(this).addClass("hide_chart");
            $(this).parents(".content_block_internal").find(".kurs_block_val").slideUp(200);
        }
    });

    $(".content_block_h_close").on('click', function () {
        $(this).parents(".content_block").slideUp(200);
    });

    /* Анкета */
    /*var a_id = $('.anketa_block_nav').find('li span.anketa_active').parent().index();
	$('.anketa_block_item').hide();
	$('.anketa_block_item:nth-child(' + (a_id + 1) + ')').show();*/

    $('.anketa_block_nav li:first-child').on('click', function () {
        $('.anketa_block_nav li span').removeClass('anketa_active');
        $(this).find('span').addClass('anketa_active');
        $('.anketa_block_item').hide();
        $('.anketa_block_item:first-child').show();
    });
    $('.anketa_block_nav li:nth-child(2)').on('click', function () {
        $('.anketa_block_nav li span').removeClass('anketa_active');
        $(this).find('span').addClass('anketa_active');
        $('.anketa_block_item').hide();
        $('.anketa_block_item:nth-child(2)').show();
    });
    $('.anketa_block_nav li:nth-child(3)').on('click', function () {
        $('.anketa_block_nav li span').removeClass('anketa_active');
        $(this).find('span').addClass('anketa_active');
        $('.anketa_block_item').hide();
        $('.anketa_block_item:nth-child(3)').show();
    });
    $('.anketa_block_nav li:nth-child(4)').on('click', function () {
        $('.anketa_block_nav li span').removeClass('anketa_active');
        $(this).find('span').addClass('anketa_active');
        $('.anketa_block_item').hide();
        $('.anketa_block_item:nth-child(4)').show();
    });
    $(document).on('click', '.anketa_block_nav li', function () {
        var parent = $(this).parents('.anketa_block'),
            a_id = $(this).index();

        parent.find('.anketa_block_nav li span').removeClass('anketa_active');
        $(this).find('span').addClass('anketa_active');
        parent.find('.anketa_block_item').hide();
        parent.find('.anketa_block_item:nth-child(' + (a_id + 1) + ')').show();
        //parent.find('.anketa_block_item:nth-child(' + (a_id + 1) + ')').animate({width:'toggle'}, 100);
    });


    /* tren set */

    /*$(".tren_set_form_add").on('click', function(){
        $(".tren_set_form_pop_up").fadeIn(200);
    });
    $(".tren_set_form_pop_up_close").on('click', function(){
        $(".tren_set_form_pop_up").fadeOut(200);
    });*/


    /* чат */

    /*$(".chat_contact").on('click', function(){
        $(".chat_contact").removeClass("chat_contact_active");
        $(this).addClass("chat_contact_active");
        $(".chat_prof_block").hide();
        $(".chat_mess_block").show();
    });
    $(".chat_contact_img").on('click', function(event){
        if($(".chat_contact_cont").css("display") !== "none"){
            event.stopPropagation();
            $(".chat_mess_block").hide();
            $(".chat_prof_block").show();
        }
    });*/
    $(".chat_block_h_slide").on('click', function () {
        if ($(".chat_contact_block_h .chat_block_h_buts").css("display") === "none") {
            if ($(this).hasClass("hide_chat")) {
                $(this).removeClass("hide_chat");
                $(this).parents(".chat_content_block_wrap").find(".chat_block_val, .chat_prof_block_val, .mess_block_val").slideDown(200);
            } else {
                $(this).addClass("hide_chat");
                $(this).parents(".chat_content_block_wrap").find(".chat_block_val, .chat_prof_block_val, .mess_block_val").slideUp(200);
            }
        } else {
            if ($(this).hasClass("hide_chat")) {
                if ($(this).parents(".chat_contact_block").length > 0) {
                    $(this).removeClass("hide_chat");
                    $(this).parents(".chat_contact_block").find(".chat_block_val").slideDown(200);
                } else {
                    $(this).parents(".chat_mess_block_wrap").find(".chat_block_h_slide").removeClass("hide_chat");
                    $(this).parents(".chat_mess_block_wrap").find(".chat_prof_block_val, .mess_block_val").slideDown(200);
                }
            } else {
                if ($(this).parents(".chat_contact_block").length > 0) {
                    $(this).addClass("hide_chat");
                    $(this).parents(".chat_contact_block").find(".chat_block_val").slideUp(200);
                } else {
                    $(this).parents(".chat_mess_block_wrap").find(".chat_block_h_slide").addClass("hide_chat");
                    $(this).parents(".chat_mess_block_wrap").find(".chat_prof_block_val, .mess_block_val").slideUp(200);
                }
            }
        }
    });
    $(".chat_block_h_close").on('click', function () {
        if ($(".chat_contact_block_h .chat_block_h_buts").css("display") === "none") {
            $(this).parents(".chat_content_block_wrap").slideUp(200);
        } else {
            if ($(this).parents(".chat_contact_block").length > 0) {
                $(this).parents(".chat_contact_block").slideUp(200);
            } else {
                $(this).parents(".chat_mess_block_wrap").slideUp(200);
            }
        }
    });
    $(".chat_mob_but").on('click', function () {
        if ($(this).hasClass("chat_mob_act")) {
            $(this).removeClass("chat_mob_act");
            $(this).parents(".chat_content_block_wrap").removeClass("chat_content_block_wrap_active");
        } else {
            $(this).addClass("chat_mob_act");
            $(this).parents(".chat_content_block_wrap").addClass("chat_content_block_wrap_active");
        }
    });
    $(".chat_search_mob_but").on('click', function () {
        $(this).parents(".chat_content_block_wrap").find(".chat_mob_but").addClass("chat_mob_act");
        $(this).parents(".chat_content_block_wrap").addClass("chat_content_block_wrap_active");
        $(this).parents(".chat_content_block_wrap").find(".chat_search_in").focus();
    });


    /* поп-ап */

    /*if($("#home_pop-up").length > 0){
        $("body").append("<div id='shadow2'></div>");
        setTimeout(function(){pop_up_home($("#home_pop-up"))}, 10000);
    }*/


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

    $(".ordering_next1").on('click', function () {
        $(".ordering_block1").css('display', 'none');
        $(".ordering_block2").css('display', 'block');

        $(".info_ordering_t_name").text($("input[name=i_o_surname]").val());
        $(".info_ordering_name").text($("input[name=i_o_name]").val());
        $(".info_ordering_email").text($("input[name=i_o_email]").val());
        $(".edit_email input[name=e_email]").val($("input[name=i_o_email]").val());
        $(".info_ordering_type").text($("input[name=i_o_delivery]:checked").val());

        if ($("input[name=i_o_email]").val() === '') {
            $(".info_ordering_email").text('Введите Email');
        }

        if ($("select[name=s_o_address] option:selected").val() !== '') {
            $(".info_ordering_country").text($("select[name=s_o_address] option:selected").text());
        } else {
            $(".info_ordering_street").text($("input[name=i_o_street]").val());
            $(".info_ordering_house").text($("input[name=i_o_house]").val());
            $(".info_ordering_building").text($("input[name=i_o_building]").val());
            $(".info_ordering_index").text($("input[name=i_o_postcode]").val());
            $(".info_ordering_city").text($("input[name=i_o_city]").val());
            $(".info_ordering_country").text($("input[name=i_o_country]").val());
        }

        if (!$(".ordering_block_tov_slider2").hasClass("slick-initialized")) {
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
        $("html, body").animate({scrollTop: destination}, "slow");
    });
    $(".ordering_next2").on('click', function () {
        $(".ordering_block2").css('display', 'none');
        $(".ordering_block3").css('display', 'block');
        $(".info_ordering_pay").text($("input[name=i_o_payment]:checked").val());
        var summ = 0;
        $(".ordering_tov_summ").each(function () {
            summ += parseFloat($(this).text().replace(/\s/g, ""));
        });
        $(".info_ordering_price").text(String(parseFloat(summ).toFixed(2)).replace(/(\d)(?=(\d\d\d)+([^\d]|$))/g, '$1 '));

        var destination = $("h2.ordering_block_title").offset().top;
        $("html, body").animate({scrollTop: destination}, "slow");
    });
    $(".ordering_prev1").on('click', function () {
        $(".ordering_block2").css('display', 'none');
        $(".ordering_block1").css('display', 'block');

        var destination = $("h2.ordering_block_title").offset().top;
        $("html, body").animate({scrollTop: destination}, "slow");
    });
    $(".ordering_prev2").on('click', function () {
        $(".ordering_block3").css('display', 'none');
        $(".ordering_block2").css('display', 'block');

        var destination = $("h2.ordering_block_title").offset().top;
        $("html, body").animate({scrollTop: destination}, "slow");
    });
    $(".ordering_block_side_info_edit").on('click', function () {
        $(".ordering_block").css('display', 'none');
        $(".ordering_block1").css('display', 'block');

        var destination = $("h2.ordering_block_title").offset().top;
        $("html, body").animate({scrollTop: destination}, "slow");
    });
    $(".ordering_block_side_email_edit").on('click', function () {
        $(".info_edit_email").toggle();
        $(".info_ordering_email").toggle();
        $(".email_errors").hide();
    });
    $(".edit_email_save").on('click', function () {
        var edit_email = $(".edit_email input[name=e_email]").val(),
            confirm = $(".edit_email_confirm input[name=e_email_confirm]"),
            info_order = $(".info_ordering_email"),
            errors_block = $(".email_errors");
        if (edit_email !== '') {
            if (edit_email === confirm.val()) {
                info_order.text(edit_email);
                $("input[name=i_o_email]").val(edit_email);
                confirm.val('');

                $(".info_edit_email").css('display', 'none');
                info_order.css('display', 'block');
            } else {
                errors_block.text('Email не совпадают');
                errors_block.show();
            }
        } else {
            errors_block.text('Введите Email');
            errors_block.show();
        }
    });
    $("input.tov_number").change(function () {
        var b_p = $(this),
            p_id = b_p.parents('.ordering_block_col_cont').children('input#c_id').val(),
            c_ap_id = b_p.parents('.ordering_block_col_cont').children('input#c_ap_id').val(),
            p_q = b_p.val(),
            b_p_sum = b_p.parents(".busket_block_tab_item").find(".ordering_tov_summ #product_sum"),
            p_p = b_p.parents(".busket_block_tab_item").find(".ordering_tov_price"),
            p_sum = 0;

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

    function totalCartPrice() {
        var sum_price = 0,
            sum_fc = 0;

        $(".ordering_tov_summ").each(function () {
            if ($(this).children('#product_currency').text() === " руб.") {
                sum_price += parseFloat($(this).children('#product_sum').text());
            } else if ($(this).children('#product_currency').text() === " FitCoin") {
                sum_fc += parseFloat($(this).children('#product_sum').text());
            }
        });

        if (sum_price === NaN || sum_price === 0) {
            $(".info_ordering_price").text("");
            $(".info_ordering_currency").text("");
        } else {
            $(".info_ordering_price").text(String(parseFloat(sum_price).toFixed(2)).replace(/(\d)(?=(\d\d\d)+([^\d]|$))/g, '$1 '));
            $(".info_ordering_currency").text(" руб.");
        }
        if (sum_fc === NaN || sum_fc === 0) {
            $(".info_ordering_fc_price").text("");
            $("#info_ordering_fc_currency").text("");
        } else {
            $(".info_ordering_fc_price").text(String(parseFloat(sum_fc).toFixed(2)).replace(/(\d)(?=(\d\d\d)+([^\d]|$))/g, '$1 '));
            $("#info_ordering_fc_currency").text(" FitCoin");
        }
    }

    $('.graf_block_grafik_item').each(function () {
        $(this).css('height', $(this).text()).text(' ');
    });
    $('.graf_procent_val').each(function () {
        $(this).find('.graf_procent_val_line').css('width', $(this).find('.graf_procent_val_txt').text());
    });

    /* выравнивание блоков */

//$(".spec_block").height($(".new_kurs_block").height());


    /* автоувеличение textarea */

    $('.contact_textarea, .mess_block_in').autoResize();


    /* оформление формы */

    $('.filtr_form input, .one_tov_num, #one_tov_dop_in, #ordering_check, .ordering_radio_wrap input, .tov_number, .anketa_form_select, .journal_form_select').styler();


    /* Цвет */

    $('.one_tov_color_item').each(function () {
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

    if (getInternetExplorerVersion() == -1) {

        if ($(".video_kurs.def_video").length > 0) {
            $(".video_kurs.def_video").each(function () {
                new InitPxVideo({
                    "videoId": this,
                    "captionsOnDefault": false,
                    "seekInterval": 20,
                    "videoTitle": "Promo",
                    "debug": true
                });
            });
        }

        if ($(".video_cont.def_video").length > 0) {
            $(".video_cont.def_video").each(function () {
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

    $(".open_search_form").on('click', function () {
        if ($(this).hasClass("open_search")) {
            $(this).removeClass("open_search");
            $(".shop_search_form").slideUp(200);
        } else {
            $(this).addClass("open_search");
            $(".shop_search_form").slideDown(200);
        }
    });


    /* поп-ап с видеоплеером */

    /*$( "#calendar" ).on( "click", ".fc-event-container a", function() {
        video_url = $(this).attr("href");
        $("#myvid").html('<div class="px-video-img-captions-container"><div class="px-video-captions hide"></div><video poster="/img/video_img.png" controls><source src="'+video_url+'" type="video/mp4"><div><a href="'+video_url+'"><img src="/img/video_img.png" alt="download video"></a></div></video></div><div class="px-video-controls"></div>')
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

    $(".chart_wrap_slide").on('click', function () {
        if ($(this).hasClass("hide_chart")) {
            $(this).removeClass("hide_chart");
            $(".chart_wrap").slideDown(200);
        } else {
            $(this).addClass("hide_chart");
            $(".chart_wrap").slideUp(200);
        }
    });

    $(".calendar_slide").on('click', function () {
        if ($(this).hasClass("hide_chart")) {
            $(this).removeClass("hide_chart");
            $(".fc-view-container").slideDown(200);
        } else {
            $(this).addClass("hide_chart");
            $(".fc-view-container").slideUp(200);
        }
    });

    $(".close_video, #shadow").on('click', function () {
        setTimeout(function () {
            $(".px-video-img-captions-container, .px-video-controls").remove();
        }, 200);
    });


    $('.lp_slider').slick({
        dots: true,
        infinite: true,
        autoplaySpeed: 5000,
        speed: 500,
        autoplay: true,
        arrows: false
    });

    if (purchase.length > 0) {
    }

    $(".promo_line").on('click', function () {
        promo_line_func($(this));
    });


    var purchase_form = $('.purchase_form');
    purchase_form.on('paste', ' #i-promocode', function () {
        var pc_input = $(this);
        searchPromo(pc_input);
    });
    purchase_form.on('keyup', ' #i-promocode', function () {
        var pc_input = $(this);
        searchPromo(pc_input);
    });

    $(".policy").on('click', function (event) {
        event.preventDefault();
        show_policy();
    });

    function show_policy()
    {
        var popup = $("#policy_pop-up"),
            shadow = $("#shadow");

        if (shadow.length === 0) {
            $("body").append("<div id='shadow'></div>");
            shadow = $("#shadow");
        }

        if ($("#shadow2").is(':visible')) {
            opacity = 0.6;
        }

        popup.css({marginLeft: -popup.width() / 2, marginTop: -popup.height() / 2}).fadeIn(600);
        $("#shadow, .policy_pop-up_close").fadeTo(600, opacity).click(function () {
            shadow.fadeOut(600);
            popup.fadeOut(600);
        });
    }

    var payment_options = '';
    $("#payment-options").on('change', function () {
        payment_options_func($(this));
    });

    $("#payment-methods").on('change', function () {
        payment_methods_func($(this));
    });

    function payment_options_func(this_el) {
        var i_promocode = $('#i-promocode'),
            course_price = $("#course-price"),
            course_new_price = $("#course-new-price");
        payment_options = $("#payment-options");

        if (this_el.val() === 'partial_payment') {
            $("#recurrent-block").show();
            course_price.parents('.kurs_cur_wrap').hide();
            if (course_new_price.length === 1) {
                course_new_price.hide();
                course_price.children(".anketa_form_h_cell").removeClass('strikeout');
            }
            $("#payment-methods").val('bank_card');
            $("#payment-methods").change();
            $("#payment-methods option[value!='bank_card']").attr('disabled', true);
            $("#payment-methods").parent().find("ul li[html!='Банковская карта']").addClass("disabled");

            if ($('.promo_block').length === 1) {
                $('.promo_info').show();
                $('.promo_line').hide();
                if (i_promocode.length === 1) {
                    i_promocode.hide();
                }
            }
        } else {
            $("#recurrent-block").hide();
            course_price.parents('.kurs_cur_wrap').show();
            if (course_new_price.length === 1) {
                course_new_price.show();
                course_price.children(".anketa_form_h_cell").addClass('strikeout');
            }
            $("#payment-methods option[value!='bank_card']").attr('disabled', false);
            $("#payment-methods").parent().find("ul li[html!='Банковская карта']").removeClass("disabled");

            if ($('.promo_block').length === 1) {
                $('.promo_info').hide();
                if (i_promocode.length === 1 && i_promocode.val() !== '') {
                    i_promocode.show();
                } else {
                    $('.promo_line').show();
                    $('.promo_block').find('.kurs_block_h').html('');
                }
            }
        }
        purchase.css({marginLeft: -purchase.width() / 2, marginTop: -purchase.height() / 2});
    }

    function payment_methods_func(this_el) {
        if (this_el.val() === 'qiwi' || this_el.val() === 'sberbank') {
            $("#method-phone").show();
            $("#method-login").hide();
        } else if (this_el.val() === 'alfabank') {
            $("#method-phone").hide();
            $("#method-login").show();
        } else {
            $("#method-phone").hide();
            $("#method-login").hide();
        }
        purchase.css({marginLeft: -purchase.width() / 2, marginTop: -purchase.height() / 2});
    }

    function promo_line_func(this_el) {
        var this_par = this_el.parent('.promo_block'),
            i_promocode = this_par.find('#i-promocode');
        this_el.hide();
        this_par.find('.kurs_block_h').html('Промокод:');
        if (i_promocode.length === 1) {
            i_promocode.show();
        } else {
            this_par.find('.kurs_block_h').after('<input type="text" name="promocode" value="" maxlength="25" class="admin_form_txt admin_form_txt_short" autofocus="autofocus" id="i-promocode"/>');
        }
        purchase.css({marginLeft: -purchase.width() / 2, marginTop: -purchase.height() / 2});
    }

    function purchase_up(pm_op) {
        var payment_options = $('#payment-options');
        if (shadow2.length === 0) {
            $("body").append("<div id='shadow2'></div>");
            shadow2 = $("#shadow2");
        }

        purchase.css({marginLeft: -purchase.width() / 2, marginTop: -purchase.height() / 2}).fadeIn(600);
        $("#shadow2, .purchase_pop-up_close").fadeTo(600, opacity).click(function () {
            shadow2.fadeOut(600);
            purchase.fadeOut(600);
        });

        if (pm_op) {
            payment_options.val('full_payment');
            if (pm_op === 'rec') {
                var promo_info = $('.promo_info');
                payment_options.val('partial_payment');
                $('#course-price').parents('.kurs_cur_wrap').hide();
                $('.promo_line').hide();
                promo_info.html('Промокод не доступен');
                promo_info.show();
                $('#recurrent-block').show();
            }
            payment_options.change();
            payment_options.parents('.kurs_cur_wrap').hide();
        }

        var user_id = $('#user-id').val(),
            pc_s = $('#pc-string').val(),
            i_pc = purchase.find('input#i-promocode');
        if (user_id) {
            //$('input[name="cb_politics"]').prop('checked', true);
            if (i_pc.length === 0 && pc_s) {
                purchase.find('.promo_block').children('.kurs_block_h').after('<input type="text" name="promocode" value="" maxlength="25" class="admin_form_txt admin_form_txt_short" autofocus="autofocus" id="i-promocode"/>');
                i_pc = purchase.find('input#i-promocode');
            }
            if (i_pc.length === 1 && pc_s) {
                i_pc.val(pc_s);
            }
            //$('input[name="bt_buy_course"]').click();
        }
    }

    var dots = 0, search_dots;
    /*function throttle(func, milliseconds) {
        var lastCall = 0;
        return function () {
            var now = Date.now();
            if (lastCall + milliseconds < now) {
                lastCall = now;
                return func.apply(this, arguments);
            }
        };
    }*/
    var isEvent = false;
    function searchPromo(pc_input) {
        setTimeout(function(){
            var this_form = pc_input.parents('.purchase_form'),
                input_search = pc_input.val(),
                crs_id = this_form.find('#crs-id').val(),
                price_block = this_form.find('#course-price'),
                new_price_block = this_form.find('#course-new-price'),
                promo_block = this_form.find('.promo_block'),
                course_price = parseFloat(price_block.html()),
                promo_block_info = promo_block.next('.promo_block_info'), promo_info = '',
                bt_buy = this_form.find('input[name=bt_buy_course]');

            if ( !isEvent ) {
                if (input_search.length >= 1 && input_search.length <= 25) {
                    $.ajax({
                        url: '/searchPromo',
                        type: 'post',
                        dataType: 'json',
                        data: {input_search: input_search, crs_id: crs_id},
                        complete: function (result) {
                            clearInterval(search_dots);
                            var data = result.responseJSON;

                            bt_buy.val('Купить');

                            if(data && data.discount)
                            {
                                var new_price,
                                    discount_type = 'руб.',
                                    rel_per_block = '';

                                if (data.discount_type === 'percent') {
                                    new_price = course_price - (course_price * data.discount / 100);
                                    discount_type = '%';
                                } else if (data.discount_type === 'currency') {
                                    new_price = course_price - data.discount;
                                } else if (data.discount_type === 'free_week') {
                                    discount_type = ' беспл. нед.';
                                    bt_buy.val('Добавить в "Мои курсы"');
                                }

                                if (data.rel_percent) {
                                    new_price = course_price - (course_price * data.rel_percent / 100);
                                    rel_per_block = '<div class="parent kurs_cur_wrap">' +
                                        '<div class="kurs_block_h">Ограничение:</div>' +
                                        '<div class="pbi_h">' + data.rel_percent + '%</div>' +
                                        '</div>';
                                }

                                if (new_price < 1 && !data.rel_percent && data.discount < 100 && data.discount_type === 'percent') {
                                    new_price = 1;
                                    rel_per_block = '<div class="parent kurs_cur_wrap">' +
                                        '<div class="kurs_block_h">Ограничение:</div>' +
                                        '<div class="pbi_h">Минимальная сумма к оплате 1 руб.</div>' +
                                        '</div>';
                                }
                                promo_info = '<div class="parent kurs_cur_wrap">' +
                                    '<div class="kurs_block_h">Скидка:</div>' +
                                    '<div class="pbi_h">' + data.discount + discount_type + '</div>' +
                                    '</div>' + rel_per_block;


                                if (new_price) {
                                    new_price = parseFloat(new_price).toFixed(2);
                                    price_block.addClass('strikeout');
                                    if (price_block.next('#course-new-price').length === 0) {
                                        price_block.after('<div class="kurs_cur" id="course-new-price">' + new_price + '</div>');
                                        new_price_block = $('#course-new-price');
                                    } else {
                                        new_price_block.html(new_price);
                                        new_price_block.show();
                                    }
                                }
                                else if(new_price === 0)
                                {
                                    bt_buy.val('Добавить в "Мои курсы"');
                                }
                            }
                            else
                            {
                                price_block.removeClass('strikeout');
                                new_price_block.hide();
                                promo_info = '<div class="parent kurs_cur_wrap">' +
                                    '<div class="kurs_block_h"></div>' +
                                    '<div class="pbi_h">Промокод не найден</div>' +
                                    '</div>';
                            }

                            if (promo_block.next('.promo_block_info').length === 0) {
                                promo_block.after('<div class="promo_block_info"></div>');
                                promo_block_info = promo_block.next('.promo_block_info');
                            }
                            promo_block_info.html(promo_info);
                            promo_block_info.show();
                        }
                    });
                }
                else
                {
                    price_block.removeClass('strikeout');
                    new_price_block.hide();
                    promo_block_info.hide();
                    bt_buy.val('Купить');
                }

                isEvent = true;
                setTimeout( function() {
                    isEvent = false;
                }, 1000 );
            }
            /*else
            {
                if (promo_block_info.length === 0) {
                    promo_block.after('<div class="promo_block_info"></div>');
                    promo_block_info = promo_block.next('.promo_block_info');
                }

                search_dots = setInterval (function(){
                    var promo_info = '<div class="parent kurs_cur_wrap">' +
                        '<div class="kurs_block_h"></div>' +
                        '<div class="pbi_h">Поиск</div>' +
                        '</div>';

                    promo_block_info.html(promo_info);
                    if (dots < 3) {
                        promo_block_info.find('.pbi_h').append('.');
                        dots++;
                    }
                    else {
                        promo_block_info.find('.pbi_h').html('Поиск');
                        dots = 0;
                    }
                }, 600);
            }*/
        }, 50);
    }

    $(window).resize(function() {
        purchase.css({marginLeft: -purchase.width() / 2, marginTop: -purchase.height() / 2});
    });


    $('.otziv_row').masonry({
        itemSelector: '.otziv_col'
    });
    $('.qa_row').masonry({
        itemSelector: '.qa_col'
    });


    /* Слайдер */
    $('.notifications_block').slick({
        dots: true,
        infinite: true,
        arrows: true,
        speed: 300,
        autoplay: false,
        slidesToShow: 1,
        slidesToScroll: 1,
        adaptiveHeight: false
    });

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

    $('.tov_slider_bot a').on('click', function () {
        $('.tov_slider_active').removeClass('scale1_5').removeClass('scale2').removeClass('scale2_5').removeClass('scale3');
        tov_slider_scale = 0;
        var val = $(this).attr('href');
        $('.tov_slider_top a').each(function () {
            if ($(this).attr('href') === val) {
                $('.tov_slider_top a').removeClass('tov_slider_active');
                $(this).addClass('tov_slider_active');
                return false;
            }
        });
        return false;
    });

    $('.tov_slider_full').on('click', function () {
        $('.tov_slider_active').trigger('click');
    });

    function slide_scale(tov_slider_scale) {
        if (tov_slider_scale < 1) {
            $('.tov_slider_active').removeClass('scale1_5').removeClass('scale2').removeClass('scale2_5').removeClass('scale3');
        } else if (tov_slider_scale === 1) {
            $('.tov_slider_active').removeClass('scale2').removeClass('scale2_5').removeClass('scale3').addClass('scale1_5');
        } else if (tov_slider_scale === 2) {
            $('.tov_slider_active').removeClass('scale1_5').removeClass('scale2_5').removeClass('scale3').addClass('scale2');
        } else if (tov_slider_scale === 3) {
            $('.tov_slider_active').removeClass('scale1_5').removeClass('scale2').removeClass('scale3').addClass('scale2_5');
        } else {
            $('.tov_slider_active').removeClass('scale1_5').removeClass('scale2').removeClass('scale2_5').addClass('scale3');
        }
    }

    $('.tov_slider_plus').on('click', function () {
        if (tov_slider_scale < 4) {
            tov_slider_scale++;
            slide_scale(tov_slider_scale);
        }
    });

    $('.tov_slider_minus').on('click', function () {
        if (tov_slider_scale > 0) {
            tov_slider_scale--;
            slide_scale(tov_slider_scale);
        }
    });


    // Скрыть/отобразить блоки периода действия и число использований промокода
    $('#s-pv-type').on('change', function () {
        var bl_pv = $('#bl-pv'),
            pv_type = $(this).val();
        if (pv_type === 'date_range') {
            bl_pv.show();
        } else {
            bl_pv.hide();
        }
    });
    $('#s-ua-type').on('change', function () {
        var ua_number = $('#bl-ua-number'),
            ua_type = $(this).val();
        if (ua_type === 'number') {
            ua_number.show();
        } else {
            ua_number.hide();
        }
    });
    $('.cg').on('click', function () {
        var this_id = $(this).attr('id'),
            cats = $('#cg-cats'),
            crs_search = $('#cg-few-search');
        if (this_id === 'cg-categories') {
            cats.show();
            cats.find('.journal_form_select').trigger('refresh');
        } else {
            cats.hide();
        }
        if(this_id === 'cg-few'){
            crs_search.show();
        } else {
            crs_search.hide();
        }
    });
});
var options, playerTwoPlayer;
options = {
    width: 640,
    loop: false
};
playerTwoPlayer = undefined;

/* pop_up */

function pop_up_def(popup) {
    var shadow = $("#shadow");

    popup.css({marginLeft:-popup.width()/2-15,marginTop:-popup.height()/2-15}).fadeIn(600); /*+$(window).scrollTop()*/

    $("#shadow, .close_video").fadeTo(600,0.8).on('click', function() {
        shadow.fadeOut(600);
        //shadow2.fadeOut(600);
        popup.fadeOut(600);
        //popup.empty();
        if(playerTwoPlayer)
        {
            playerTwoPlayer.pause().then(function() {
                // The video is paused
            }).catch(function(error) {
                switch (error.name) {
                    case 'PasswordError':
                        // The video is password-protected
                        break;

                    case 'PrivacyError':
                        // The video is private
                        break;

                    default:
                        // Some other error occurred
                        break;
                }
            });
        }
        //enableScroll();
    });
    //disableScroll();
}
function pop_up_home(popup) {
    var shadow = $("#shadow2");
    popup.css({marginLeft:-(popup.width()/2),marginTop:-(popup.height()/2)}).fadeIn(600);

    // если необходимо делегирование событий, замените на mouseenter и mouseleave соответственно
    $(popup).hover(function() {
        preventScroll(popup);
    }, function() {
        returnScroll();
    });

    $("#shadow2, .home_pop-up_close, .close_meal, .close_user_meal").fadeTo(600,0.8).on('click', function() {
        shadow.fadeOut(600);
        popup.fadeOut(600);
        //popup.empty();
        if(playerTwoPlayer)
        {
            playerTwoPlayer.pause().then(function() {
                // The video is paused
            }).catch(function(error) {
                switch (error.name) {
                    case 'PasswordError':
                        // The video is password-protected
                        break;

                    case 'PrivacyError':
                        // The video is private
                        break;

                    default:
                        // Some other error occurred
                        break;
                }
            });
        }
    });
}

var scrollKeys = [33,34,35,36,38,40];

function preventScroll(popUp) {
    $(document).on("mousewheel DOMMouseScroll", "body", function(e) {
        var $np = $(popUp)[0];
        var st = $np.scrollTop;
        if (e.originalEvent.wheelDelta > 0 || e.originalEvent.detail < 0) {
            if ($(e.target).closest(popUp).length &&
                st > 0) return;
        } else {
            if ($(e.target).closest(popUp).length &&
                st + $np.offsetHeight < $np.scrollHeight) return;
        }
        e.preventDefault();
        e.stopPropagation();
    });

    $(document).on("keydown", function(e) {
        if (scrollKeys.indexOf(e.which) > -1) {
            e.preventDefault();
        }
    });
}

function returnScroll() {
    $(document).off("mousewheel DOMMouseScroll keydown");
}

/*var keys = {37: 1, 38: 1, 39: 1, 40: 1};

function preventDefault(e) {
    e = e || window.event;
    if (e.preventDefault)
        e.preventDefault();
    e.returnValue = false;
}

function preventDefaultForScrollKeys(e) {
    if (keys[e.keyCode]) {
        preventDefault(e);
        return false;
    }
}

function disableScroll() {
    if (window.addEventListener) // older FF
        window.addEventListener('DOMMouseScroll', preventDefault, false);
    window.onwheel = preventDefault; // modern standard
    window.onmousewheel = document.onmousewheel = preventDefault; // older browsers, IE
    window.ontouchmove  = preventDefault; // mobile
    document.onkeydown  = preventDefaultForScrollKeys;
}

function enableScroll() {
    if (window.removeEventListener)
        window.removeEventListener('DOMMouseScroll', preventDefault, false);
    window.onmousewheel = document.onmousewheel = null;
    //window.onwheel = null;
    document.onwheel = null;
    window.ontouchmove = null;
    document.onkeydown = null;
}*/

function meal_slider(meal_up)
{
    var meal_block_img = $('.meal_block_img');
    meal_block_img.slick({
        dots: true,
        infinite: true,
        autoplaySpeed: 5000,
        speed: 500,
        autoplay: true,
        arrows: false
    });
    meal_block_img.on('afterChange',function(e,o){
        //on change slide = do action
        $('iframe').each(function(){
            $(this)[0].contentWindow.postMessage('{"event":"command","func":"' + 'stopVideo' + '","args":""}', '*');
        });
    });
    meal_block_img.on('beforeChange',function(event, slick, currentSlide, nextSlide){
        $('.yt-player').each(function(){
            this.contentWindow.postMessage('{"event":"command","func":"' + 'pauseVideo' + '","args":""}', '*')
        });
    });
    meal_block_img.find('img').each(function(){$(this).css('height','auto')});
    onYouTubeIframeAPIReady();
}

// Работа с youtube видео
var tag = document.createElement('script');
tag.id = 'iframe-demo';
tag.src = 'https://www.youtube.com/iframe_api';
var firstScriptTag = document.getElementsByTagName('script')[0];
firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

var player;
function onYouTubeIframeAPIReady() {
    var elems1 = $('.yt-player');
    for(var i = 0; i < elems1.length; i++) {

        player = new YT.Player(elems1[i], {
            events: {
                //'onReady': onPlayerReady,
                'onStateChange': onPlayerStateChange
            }
        });
    }
}
function handleVideo(playerStatus) {
    if (playerStatus === -1) {
        // unstarted
        $('.meal_block_img').slick('slickPlay');
    } else if (playerStatus === 0) {
        // ended
        $('.meal_block_img').slick('slickPlay');
    } else if (playerStatus === 1) {
        // playing = green
        $('.meal_block_img').slick('slickPause');
    } else if (playerStatus === 2) {
        // paused = red
        $('.meal_block_img').slick('slickPlay');
    } else if (playerStatus === 3) {
        // buffering = purple
    } else if (playerStatus === 5) {
        // video cued
    }
}
function onPlayerStateChange(event) {
    handleVideo(event.data);
}



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

	/*$('#calendar_prof').fullCalendar({
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
				title: '<div class="calendar_prof_item"><div class="parent"><div class="calendar_prof_img"><img src="/img/sport_ico1.png" alt=""></div><div class="calendar_prof_cont"><div class="calendar_prof_time">00.30.00</div><div class="calendar_prof_load parent"><span></span><span></span><span></span><span></span><span></span></div></div></div><div class="calendar_prof_end"><span class="calendar_prof_end_line"></span><span class="calendar_prof_end_val">65%</span></div></div>',
				start: '2016-08-29'
			},
			{
				title: '<div class="calendar_prof_item"><div class="parent"><div class="calendar_prof_img"><img src="/img/sport_ico2.png" alt=""></div><div class="calendar_prof_cont"><div class="calendar_prof_time">00.30.00</div><div class="calendar_prof_load parent calendar_prof_load_1"><span></span><span></span><span></span><span></span><span></span></div></div></div><div class="calendar_prof_end"><span class="calendar_prof_end_line"></span><span class="calendar_prof_end_val">35%</span></div></div>',
				start: '2016-08-30'
			},
			{
				title: '<div class="calendar_prof_item"><div class="parent"><div class="calendar_prof_img"><img src="/img/sport_ico3.png" alt=""></div><div class="calendar_prof_cont"><div class="calendar_prof_time">00.30.00</div><div class="calendar_prof_load parent calendar_prof_load_2"><span></span><span></span><span></span><span></span><span></span></div></div></div><div class="calendar_prof_end"><span class="calendar_prof_end_line"></span><span class="calendar_prof_end_val">85%</span></div></div>',
				start: '2016-08-31'
			},
			{
				title: '<div class="calendar_prof_item"><div class="parent"><div class="calendar_prof_img"><img src="/img/sport_ico4.png" alt=""></div><div class="calendar_prof_cont"><div class="calendar_prof_time">00.30.00</div><div class="calendar_prof_load parent calendar_prof_load_3"><span></span><span></span><span></span><span></span><span></span></div></div></div><div class="calendar_prof_end"><span class="calendar_prof_end_line"></span><span class="calendar_prof_end_val">60%</span></div></div>',
				start: '2016-09-01'
			},
			{
				title: '<div class="calendar_prof_item"><div class="parent"><div class="calendar_prof_img"><img src="/img/sport_ico5.png" alt=""></div><div class="calendar_prof_cont"><div class="calendar_prof_time">00.30.00</div><div class="calendar_prof_load parent calendar_prof_load_4"><span></span><span></span><span></span><span></span><span></span></div></div></div><div class="calendar_prof_end"><span class="calendar_prof_end_line"></span><span class="calendar_prof_end_val">40%</span></div></div>',
				start: '2016-09-02'
			},
			{
				title: '<div class="calendar_prof_item"><div class="parent"><div class="calendar_prof_img"><img src="/img/sport_ico6.png" alt=""></div><div class="calendar_prof_cont"><div class="calendar_prof_time">00.30.00</div><div class="calendar_prof_load parent calendar_prof_load_5"><span></span><span></span><span></span><span></span><span></span></div></div></div><div class="calendar_prof_end"><span class="calendar_prof_end_line"></span><span class="calendar_prof_end_val">25%</span></div></div>',
				start: '2016-09-03'
			},
			{
				title: '<div class="calendar_prof_item"><div class="parent"><div class="calendar_prof_img"><img src="/img/sport_ico7.png" alt=""></div><div class="calendar_prof_cont"><div class="calendar_prof_time">00.30.00</div><div class="calendar_prof_load parent calendar_prof_load_4"><span></span><span></span><span></span><span></span><span></span></div></div></div><div class="calendar_prof_end"><span class="calendar_prof_end_line"></span><span class="calendar_prof_end_val">75%</span></div></div>',
				start: '2016-09-04'
			},
			{
				title: '<div class="calendar_prof_item"><div class="parent"><div class="calendar_prof_img"><img src="/img/sport_ico1.png" alt=""></div><div class="calendar_prof_cont"><div class="calendar_prof_time">00.30.00</div><div class="calendar_prof_load parent"><span></span><span></span><span></span><span></span><span></span></div></div></div><div class="calendar_prof_end"><span class="calendar_prof_end_line"></span><span class="calendar_prof_end_val">85%</span></div></div>',
				start: '2016-09-05'
			},
			{
				title: '<div class="calendar_prof_item"><div class="parent"><div class="calendar_prof_img"><img src="/img/sport_ico2.png" alt=""></div><div class="calendar_prof_cont"><div class="calendar_prof_time">00.30.00</div><div class="calendar_prof_load parent calendar_prof_load_1"><span></span><span></span><span></span><span></span><span></span></div></div></div><div class="calendar_prof_end"><span class="calendar_prof_end_line"></span><span class="calendar_prof_end_val">40%</span></div></div>',
				start: '2016-09-06'
			},
			{
				title: '<div class="calendar_prof_item"><div class="parent"><div class="calendar_prof_img"><img src="/img/sport_ico3.png" alt=""></div><div class="calendar_prof_cont"><div class="calendar_prof_time">00.30.00</div><div class="calendar_prof_load parent calendar_prof_load_2"><span></span><span></span><span></span><span></span><span></span></div></div></div><div class="calendar_prof_end"><span class="calendar_prof_end_line"></span><span class="calendar_prof_end_val">65%</span></div></div>',
				start: '2016-09-07'
			},
			{
				title: '<div class="calendar_prof_item"><div class="parent"><div class="calendar_prof_img"><img src="/img/sport_ico4.png" alt=""></div><div class="calendar_prof_cont"><div class="calendar_prof_time">00.30.00</div><div class="calendar_prof_load parent calendar_prof_load_3"><span></span><span></span><span></span><span></span><span></span></div></div></div><div class="calendar_prof_end"><span class="calendar_prof_end_line"></span><span class="calendar_prof_end_val">85%</span></div></div>',
				start: '2016-09-08'
			},
			{
				title: '<div class="calendar_prof_item"><div class="parent"><div class="calendar_prof_img"><img src="/img/sport_ico5.png" alt=""></div><div class="calendar_prof_cont"><div class="calendar_prof_time">00.30.00</div><div class="calendar_prof_load parent calendar_prof_load_4"><span></span><span></span><span></span><span></span><span></span></div></div></div><div class="calendar_prof_end"><span class="calendar_prof_end_line"></span><span class="calendar_prof_end_val">30%</span></div></div>',
				start: '2016-09-09'
			},
			{
				title: '<div class="calendar_prof_item"><div class="parent"><div class="calendar_prof_img"><img src="/img/sport_ico6.png" alt=""></div><div class="calendar_prof_cont"><div class="calendar_prof_time">00.30.00</div><div class="calendar_prof_load parent calendar_prof_load_5"><span></span><span></span><span></span><span></span><span></span></div></div></div><div class="calendar_prof_end"><span class="calendar_prof_end_line"></span><span class="calendar_prof_end_val">40%</span></div></div>',
				start: '2016-09-10'
			},
			{
				title: '<div class="calendar_prof_item"><div class="parent"><div class="calendar_prof_img"><img src="/img/sport_ico7.png" alt=""></div><div class="calendar_prof_cont"><div class="calendar_prof_time">00.30.00</div><div class="calendar_prof_load parent calendar_prof_load_4"><span></span><span></span><span></span><span></span><span></span></div></div></div><div class="calendar_prof_end"><span class="calendar_prof_end_line"></span><span class="calendar_prof_end_val">65%</span></div></div>',
				start: '2016-09-11'
			},
			{
				title: '<div class="calendar_prof_item"><div class="parent"><div class="calendar_prof_img"><img src="/img/sport_ico1.png" alt=""></div><div class="calendar_prof_cont"><div class="calendar_prof_time">00.30.00</div><div class="calendar_prof_load parent"><span></span><span></span><span></span><span></span><span></span></div></div></div><div class="calendar_prof_end"><span class="calendar_prof_end_line"></span><span class="calendar_prof_end_val">65%</span></div></div>',
				start: '2016-09-12'
			},
			{
				title: '<div class="calendar_prof_item"><div class="parent"><div class="calendar_prof_img"><img src="/img/sport_ico2.png" alt=""></div><div class="calendar_prof_cont"><div class="calendar_prof_time">00.30.00</div><div class="calendar_prof_load parent calendar_prof_load_1"><span></span><span></span><span></span><span></span><span></span></div></div></div><div class="calendar_prof_end"><span class="calendar_prof_end_line"></span><span class="calendar_prof_end_val">35%</span></div></div>',
				start: '2016-09-13'
			},
			{
				title: '<div class="calendar_prof_item"><div class="parent"><div class="calendar_prof_img"><img src="/img/sport_ico3.png" alt=""></div><div class="calendar_prof_cont"><div class="calendar_prof_time">00.30.00</div><div class="calendar_prof_load parent calendar_prof_load_2"><span></span><span></span><span></span><span></span><span></span></div></div></div><div class="calendar_prof_end"><span class="calendar_prof_end_line"></span><span class="calendar_prof_end_val">85%</span></div></div>',
				start: '2016-09-14'
			},
			{
				title: '<div class="calendar_prof_item"><div class="parent"><div class="calendar_prof_img"><img src="/img/sport_ico4.png" alt=""></div><div class="calendar_prof_cont"><div class="calendar_prof_time">00.30.00</div><div class="calendar_prof_load parent calendar_prof_load_3"><span></span><span></span><span></span><span></span><span></span></div></div></div><div class="calendar_prof_end"><span class="calendar_prof_end_line"></span><span class="calendar_prof_end_val">60%</span></div></div>',
				start: '2016-09-15'
			},
			{
				title: '<div class="calendar_prof_item"><div class="parent"><div class="calendar_prof_img"><img src="/img/sport_ico5.png" alt=""></div><div class="calendar_prof_cont"><div class="calendar_prof_time">00.30.00</div><div class="calendar_prof_load parent calendar_prof_load_4"><span></span><span></span><span></span><span></span><span></span></div></div></div><div class="calendar_prof_end"><span class="calendar_prof_end_line"></span><span class="calendar_prof_end_val">40%</span></div></div>',
				start: '2016-09-16'
			},
			{
				title: '<div class="calendar_prof_item"><div class="parent"><div class="calendar_prof_img"><img src="/img/sport_ico6.png" alt=""></div><div class="calendar_prof_cont"><div class="calendar_prof_time">00.30.00</div><div class="calendar_prof_load parent calendar_prof_load_5"><span></span><span></span><span></span><span></span><span></span></div></div></div><div class="calendar_prof_end"><span class="calendar_prof_end_line"></span><span class="calendar_prof_end_val">25%</span></div></div>',
				start: '2016-09-17'
			},
			{
				title: '<div class="calendar_prof_item"><div class="parent"><div class="calendar_prof_img"><img src="/img/sport_ico7.png" alt=""></div><div class="calendar_prof_cont"><div class="calendar_prof_time">00.30.00</div><div class="calendar_prof_load parent calendar_prof_load_4"><span></span><span></span><span></span><span></span><span></span></div></div></div><div class="calendar_prof_end"><span class="calendar_prof_end_line"></span><span class="calendar_prof_end_val">75%</span></div></div>',
				start: '2016-09-18'
			},
			{
				title: '<div class="calendar_prof_item"><div class="parent"><div class="calendar_prof_img"><img src="/img/sport_ico1.png" alt=""></div><div class="calendar_prof_cont"><div class="calendar_prof_time">00.30.00</div><div class="calendar_prof_load parent"><span></span><span></span><span></span><span></span><span></span></div></div></div><div class="calendar_prof_end"><span class="calendar_prof_end_line"></span><span class="calendar_prof_end_val">85%</span></div></div>',
				start: '2016-09-19'
			},
			{
				title: '<div class="calendar_prof_item"><div class="parent"><div class="calendar_prof_img"><img src="/img/sport_ico2.png" alt=""></div><div class="calendar_prof_cont"><div class="calendar_prof_time">00.30.00</div><div class="calendar_prof_load parent calendar_prof_load_1"><span></span><span></span><span></span><span></span><span></span></div></div></div><div class="calendar_prof_end"><span class="calendar_prof_end_line"></span><span class="calendar_prof_end_val">40%</span></div></div>',
				start: '2016-09-20'
			},
			{
				title: '<div class="calendar_prof_item"><div class="parent"><div class="calendar_prof_img"><img src="/img/sport_ico3.png" alt=""></div><div class="calendar_prof_cont"><div class="calendar_prof_time">00.30.00</div><div class="calendar_prof_load parent calendar_prof_load_2"><span></span><span></span><span></span><span></span><span></span></div></div></div><div class="calendar_prof_end"><span class="calendar_prof_end_line"></span><span class="calendar_prof_end_val">65%</span></div></div>',
				start: '2016-09-21'
			},
			{
				title: '<div class="calendar_prof_item"><div class="parent"><div class="calendar_prof_img"><img src="/img/sport_ico4.png" alt=""></div><div class="calendar_prof_cont"><div class="calendar_prof_time">00.30.00</div><div class="calendar_prof_load parent calendar_prof_load_3"><span></span><span></span><span></span><span></span><span></span></div></div></div><div class="calendar_prof_end"><span class="calendar_prof_end_line"></span><span class="calendar_prof_end_val">85%</span></div></div>',
				start: '2016-09-22'
			},
			{
				title: '<div class="calendar_prof_item"><div class="parent"><div class="calendar_prof_img"><img src="/img/sport_ico5.png" alt=""></div><div class="calendar_prof_cont"><div class="calendar_prof_time">00.30.00</div><div class="calendar_prof_load parent calendar_prof_load_4"><span></span><span></span><span></span><span></span><span></span></div></div></div><div class="calendar_prof_end"><span class="calendar_prof_end_line"></span><span class="calendar_prof_end_val">30%</span></div></div>',
				start: '2016-09-23'
			},
			{
				title: '<div class="calendar_prof_item"><div class="parent"><div class="calendar_prof_img"><img src="/img/sport_ico6.png" alt=""></div><div class="calendar_prof_cont"><div class="calendar_prof_time">00.30.00</div><div class="calendar_prof_load parent calendar_prof_load_5"><span></span><span></span><span></span><span></span><span></span></div></div></div><div class="calendar_prof_end"><span class="calendar_prof_end_line"></span><span class="calendar_prof_end_val">40%</span></div></div>',
				start: '2016-09-24'
			},
			{
				title: '<div class="calendar_prof_item"><div class="parent"><div class="calendar_prof_img"><img src="/img/sport_ico7.png" alt=""></div><div class="calendar_prof_cont"><div class="calendar_prof_time">00.30.00</div><div class="calendar_prof_load parent calendar_prof_load_4"><span></span><span></span><span></span><span></span><span></span></div></div></div><div class="calendar_prof_end"><span class="calendar_prof_end_line"></span><span class="calendar_prof_end_val">65%</span></div></div>',
				start: '2016-09-25'
			},
			{
				title: '<div class="calendar_prof_item"><div class="parent"><div class="calendar_prof_img"><img src="/img/sport_ico1.png" alt=""></div><div class="calendar_prof_cont"><div class="calendar_prof_time">00.30.00</div><div class="calendar_prof_load parent"><span></span><span></span><span></span><span></span><span></span></div></div></div><div class="calendar_prof_end"><span class="calendar_prof_end_line"></span><span class="calendar_prof_end_val">65%</span></div></div>',
				start: '2016-09-26'
			},
			{
				title: '<div class="calendar_prof_item"><div class="parent"><div class="calendar_prof_img"><img src="/img/sport_ico2.png" alt=""></div><div class="calendar_prof_cont"><div class="calendar_prof_time">00.30.00</div><div class="calendar_prof_load parent calendar_prof_load_1"><span></span><span></span><span></span><span></span><span></span></div></div></div><div class="calendar_prof_end"><span class="calendar_prof_end_line"></span><span class="calendar_prof_end_val">35%</span></div></div>',
				start: '2016-09-27'
			},
			{
				title: '<div class="calendar_prof_item"><div class="parent"><div class="calendar_prof_img"><img src="/img/sport_ico3.png" alt=""></div><div class="calendar_prof_cont"><div class="calendar_prof_time">00.30.00</div><div class="calendar_prof_load parent calendar_prof_load_2"><span></span><span></span><span></span><span></span><span></span></div></div></div><div class="calendar_prof_end"><span class="calendar_prof_end_line"></span><span class="calendar_prof_end_val">85%</span></div></div>',
				start: '2016-09-28'
			},
			{
				title: '<div class="calendar_prof_item"><div class="parent"><div class="calendar_prof_img"><img src="/img/sport_ico4.png" alt=""></div><div class="calendar_prof_cont"><div class="calendar_prof_time">00.30.00</div><div class="calendar_prof_load parent calendar_prof_load_3"><span></span><span></span><span></span><span></span><span></span></div></div></div><div class="calendar_prof_end"><span class="calendar_prof_end_line"></span><span class="calendar_prof_end_val">60%</span></div></div>',
				start: '2016-09-29'
			},
			{
				title: '<div class="calendar_prof_item"><div class="parent"><div class="calendar_prof_img"><img src="/img/sport_ico5.png" alt=""></div><div class="calendar_prof_cont"><div class="calendar_prof_time">00.30.00</div><div class="calendar_prof_load parent calendar_prof_load_4"><span></span><span></span><span></span><span></span><span></span></div></div></div><div class="calendar_prof_end"><span class="calendar_prof_end_line"></span><span class="calendar_prof_end_val">40%</span></div></div>',
				start: '2016-09-30'
			},
			{
				title: '<div class="calendar_prof_item"><div class="parent"><div class="calendar_prof_img"><img src="/img/sport_ico6.png" alt=""></div><div class="calendar_prof_cont"><div class="calendar_prof_time">00.30.00</div><div class="calendar_prof_load parent calendar_prof_load_5"><span></span><span></span><span></span><span></span><span></span></div></div></div><div class="calendar_prof_end"><span class="calendar_prof_end_line"></span><span class="calendar_prof_end_val">25%</span></div></div>',
				start: '2016-10-01'
			},
			{
				title: '<div class="calendar_prof_item"><div class="parent"><div class="calendar_prof_img"><img src="/img/sport_ico7.png" alt=""></div><div class="calendar_prof_cont"><div class="calendar_prof_time">00.30.00</div><div class="calendar_prof_load parent calendar_prof_load_4"><span></span><span></span><span></span><span></span><span></span></div></div></div><div class="calendar_prof_end"><span class="calendar_prof_end_line"></span><span class="calendar_prof_end_val">75%</span></div></div>',
				start: '2016-10-02'
			}
		],
	    eventAfterAllRender: function( view ) {
	        $('.calendar_prof_end').each(function(){
	        	$(this).find('.calendar_prof_end_line').css('width', $(this).find('.calendar_prof_end_val').text());
	        });
	    }
	});*/
	
});