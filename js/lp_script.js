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

        $(".lp_block_but").on('click', function(){
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