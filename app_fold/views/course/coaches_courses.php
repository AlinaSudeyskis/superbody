<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="content_block new_content_block">
    <div class="content_block_h new_content_block_h parent">
        <h3>Курсы тренера</h3>
        <div class="content_block_h_buts">
            <div class="content_block_h_slide kurs_slide"></div>
            <div class="content_block_h_close"></div>
        </div>
    </div>
    <div class="kurs_block_val">
        <?php if (!empty($courses)) :?>
            <div class="kurs_page_row row" style="padding: 15px;">
                <?php foreach ($courses as $course):
                    include('./app_fold/views/course/course_item.php');
                endforeach;
                unset($course);?>

                <script>
                    $('.kurs_page_block_slider').slick({
                        dots: false,
                        infinite: true,
                        autoplaySpeed: 5000,
                        speed: 500,
                        autoplay: true,
                        arrows: false,
                        pauseOnFocus: false
                    });
                </script>
            </div>
            <?php include_once('./app_fold/views/pagination.php');?>
        <?php else: ?>
            <h3 class="info">Информация не найдена</h3>
        <?php endif; ?>
    </div>
</div>