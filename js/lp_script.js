$(document).ready(function(){
    $('.lp_slider').slick({
	  dots: true,
	  infinite: true,
	  autoplaySpeed: 5000,
	  speed: 500,
	  autoplay: true,
	  arrows: false
	});

    var opacity  = 0.8,
        purchase = $("#purchase_pop-up"),
        shadow2 = $("#shadow2");

    if(purchase.length > 0){
        if(purchase.hasClass("ref_pop-up")){
            purchase_up();
        }

        $(".lp_block_but").on('click', function(event){
            event.preventDefault();
            purchase_up();
        });
    }

    function purchase_up()
    {
        if (shadow2.length == 0)
        {
            $("body").append("<div id='shadow2'></div>");
            shadow2 = $("#shadow2");
        }

        purchase.css({marginLeft:-purchase.width()/2,marginTop:-purchase.height()/2}).fadeIn(600);
        $("#shadow2, .purchase_pop-up_close").fadeTo(600, opacity).click(function() {
            shadow2.fadeOut(600);
            purchase.fadeOut(600);
        });
    }

    $('.anketa_form_select, .journal_form_select').styler();

    $(".promo_line").on('click', function(){
        $(this).hide();
        $(this).parent('.promo_block').find('.kurs_block_h').html('Промокод:');
        if($('#i-promocode').length == 1)
        {
            $('#i-promocode').show();
        }
        else
        {
            $(this).parent('.promo_block').find('.kurs_block_h').after('<input type="text" name="promocode" value="" maxlength="25" class="admin_form_txt admin_form_txt_short" autofocus="autofocus" id="i-promocode"/>');
        }
    });


    $('.purchase_form').on('keyup', ' #i-promocode', function(){
        var input_search     = $(this).val(),
            crs_id           = $('.purchase_form').find('#crs-id').val(),
            price_block      = $('#course-price'),
            new_price_block  = $('#course-new-price'),
            course_price     = parseFloat(price_block.html());

        if(input_search.length >= 6 && input_search.length <= 25)
        {
            $.ajax({
                url: '/searchPromo',
                type: 'post',
                dataType: 'json',
                data: {input_search: input_search, crs_id: crs_id},
                complete: function (result) {
                    var data = result.responseJSON;

                    if (data.discount !== false)
                    {
                        var new_price;

                        if(data.discount_type === 'percent')
                        {
                            new_price = course_price - (course_price*data.discount/100);
                        }
                        else
                        {
                            new_price = course_price - data.discount;
                        }

                        if(data.rel_percent)
                        {
                            new_price = course_price - (course_price*data.rel_percent/100);
                        }

                        if(new_price < 1 && !data.rel_percent)
                        {
                            new_price = 1;
                        }

                        price_block.addClass('strikeout');
                        if(price_block.next('#course-new-price').length == 0)
                        {
                            price_block.after('<div class="kurs_cur" id="course-new-price">' + new_price + '</div>');
                            new_price_block = $('#course-new-price');
                        }
                        else
                        {
                            new_price_block.html(new_price);
                            new_price_block.show();
                        }
                    }
                    else
                    {
                        price_block.removeClass('strikeout');
                        new_price_block.hide();
                    }
                }
            });
        }
        else
        {
            price_block.removeClass('strikeout');
            new_price_block.hide();
        }
    });

    if($("#policy_pop-up").length > 0){
        $(".policy").on('click', function(event){
            event.preventDefault();
            var popup = $("#policy_pop-up"),
                shadow = $("#shadow");

            if (shadow.length == 0)
            {
                $("body").append("<div id='shadow'></div>");
                shadow = $("#shadow");
            }

            if($("#shadow2").is(':visible'))
            {
                opacity = 0.6;
            }

            popup.css({marginLeft:-popup.width()/2,marginTop:-popup.height()/2}).fadeIn(600);
            $("#shadow, .policy_pop-up_close").fadeTo(600, opacity).click(function() {
                shadow.fadeOut(600);
                popup.fadeOut(600);
            });
        });
    }

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
});