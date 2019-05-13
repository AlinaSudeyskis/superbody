<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php
$categories = array('Курсы тренировок' => 'workouts', 'Курсы питания' => 'nutritions');
$category   = (!empty($page_submenu) and array_search($page_submenu, $categories) !== false) ? array_search($page_submenu, $categories) : null;
$type       = (!empty($courses_type) and is_numeric($courses_type) and !empty($courses_categories)) ? $courses_categories[$courses_type]['name'] : null;
if(!empty($type) and !empty($category) and $category == 'Курсы тренировок')
{
    $breadcrumbs = array('/courses' => 'Курсы', '/courses/workouts' => $category, '/type' => $type);
}
elseif(!empty($category))
{
    $breadcrumbs = array('/courses' => 'Курсы', '/courses/category' => $category);
}
else
{
    $breadcrumbs = array('/courses' => 'Курсы');
}
include_once('./app_fold/views/breadcrumb.php');?>
<div class="shop_line">
    <div class="parent">
        <div class="shop_sort_h">Сортировать:</div>
        <div class="shop_sort_in_wrap parent">
            <a href="/courses/workouts" <?php if($page_submenu == 'workouts'): ?>class="checked"<?php endif; ?>>Тренировки</a>
            <a href="/courses/nutritions" <?php if($page_submenu == 'nutritions'): ?>class="checked"<?php endif; ?>>Питание</a>
        </div>
    </div>
</div>
<div id="content" class="container kurs_page">
    <?php if(!empty($courses['workouts'])): ?>
        <?php foreach($courses['workouts'] as $cat_id => $workouts):?>
            <h2 class="block_h">
                <?php if(empty($page_submenu) or ($page_submenu == 'workouts' and empty($courses_type)) or ($page_submenu == 'workouts' and is_numeric($courses_type) and $courses_type != $cat_id)): ?>
                    <a href="/courses/workouts/<?php echo $cat_id; ?>"><?php echo $courses_categories[$cat_id]['name']; ?></a>
                <?php else: ?>
                    <?php echo $courses_categories[$cat_id]['name']; ?>
                <?php endif; ?>
            </h2>
            <div class="kurs_page_row row">
                <?php foreach($workouts as $course):
                    include('./app_fold/views/course/course_item.php');
                endforeach;
                unset($course);?>
            </div>
            <?php if(!empty($type) and !empty($category) and $category == 'Курсы тренировок'):
                $category_id = 'workouts';
                $subcategory_id = $courses_type;
                include_once('./app_fold/views/pagination.php');
            endif; ?>
        <?php endforeach;
        unset($workouts);?>
    <?php elseif($page_submenu == 'workouts' and is_numeric($courses_type)): ?>
        <h2 class="block_h"><?php echo $courses_categories[$courses_type]['name']; ?></h2>
        <h3 class="info">Информация не найдена</h3>
    <?php endif; ?>

    <?php if(!empty($courses['nutritions'])): ?>
        <h2 class="block_h">
            <?php if(empty($page_submenu)): ?>
                <a href="/courses/nutritions">Курсы питания</a>
            <?php else: ?>
                Курсы питания
            <?php endif; ?>
        </h2>
        <div class="kurs_page_row row">
            <?php foreach($courses['nutritions'] as $course):
                include('./app_fold/views/course/course_item.php');
            endforeach;
            unset($course);?>
        </div>
    <?php elseif($page_submenu == 'nutritions'): ?>
        <h2 class="block_h">Курсы питания</h2>
        <h3 class="info">Информация не найдена</h3>
    <?php endif; ?>

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
    <?php
        include_once('./app_fold/views/site/content/reviews.php');
        include_once('./app_fold/views/site/content/auth_info_block.php');
        include_once('./app_fold/views/site/content/gallery.php');
    ?>
</div>