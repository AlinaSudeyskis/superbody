<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<script>
    $('.header_bg').slick({
        dots: true,
        infinite: true,
        autoplaySpeed: 5000,
        speed: 500,
        autoplay: false,
        arrows: false
    });

    if ($('.header_bg_wrap').is(':visible') || $('.main_bg_wrap').is(':visible')) {
        $('.header_bg').slick("slickPlay");
    }
</script>
