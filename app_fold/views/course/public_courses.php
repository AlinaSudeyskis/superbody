<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container"><h2 class="block_h">курсы</h2></div>
<div id="content" class="container kurs_page">

    <div class="kurs_page_row row">
        <?php if (!empty($courses)):
            foreach($courses as $course):
                include('./app_fold/views/course/course_item.php');
            endforeach;
            unset($course);
        endif;?>

        <script>
            $('.kurs_page_block_slider').slick({
                dots: true,
                infinite: true,
                autoplaySpeed: 5000,
                speed: 500,
                autoplay: true,
                arrows: false,
                pauseOnFocus: false
            });
        </script>
    </div>


    <?php
        include_once('./app_fold/views/site/content/reviews.php');
        include_once('./app_fold/views/site/content/auth_info_block.php');
        include_once('./app_fold/views/site/content/gallery.php');
    ?>
</div>