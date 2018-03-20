$(document).ready(function(){
    $('.lp_slider').slick({
	  dots: true,
	  infinite: true,
	  autoplaySpeed: 5000,
	  speed: 500,
	  autoplay: true,
	  arrows: false
	});

    if($("#purchase_pop-up").length > 0){
        $(".lp_block_but").on('click', function(){
            event.preventDefault();
            var popup = $("#purchase_pop-up"),
                shadow = $("#shadow");

            if (shadow.length == 0)
            {
                $("body").append("<div id='shadow'></div>");
                shadow = $("#shadow");
            }

            popup.css({marginLeft:-popup.width()/2,marginTop:-popup.height()/2}).fadeIn(600);
            $("#shadow, .purchase_pop-up_close").fadeTo(600,0.8).click(function() {
                shadow.fadeOut(600);
                popup.fadeOut(600);
            });
        });
    }

    $('.anketa_form_select').styler();

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

});