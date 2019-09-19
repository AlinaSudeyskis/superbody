<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php
$page_url     = '/courses/';
$crs_categories = array('Курсы тренировок' => 'workouts', 'Курсы питания' => 'nutritions');
$page_categories    = array('Курсы промокода' => 'promocode', 'Тренеры курсов' => 'crs_coaches');
$search_crs_cat     = (!empty($course_category)) ? array_search($course_category, $crs_categories) : false;
$course_category    = ($search_crs_cat !== false) ? $search_crs_cat : null;
$category_name        = (!empty($category_id) and is_numeric($category_id) and !empty($courses_categories) and !empty($course_category))
    ? $courses_categories[$category_id]['name'] : null;
$search_page_cat    = (!empty($page_category)) ? array_search($page_category, $page_categories) : false;
$page_category      = ($search_page_cat !== false) ? $search_page_cat : null;

/*echo $course_category .' '. $category_id.'<br/>';
echo $page_category .' '. $page_cat_string.'<br/>';*/

if(empty($page_category) and !empty($category_name) and $course_category == 'Курсы тренировок')
{
    $breadcrumbs = array('/courses' => 'Курсы', '/courses/workouts' => $course_category, '/type' => $category_name);
}
elseif(!empty($page_category) and $page_category == 'Тренеры курсов')
{
    if(!empty($page_cat_string) and is_numeric($page_cat_string) and !empty($coach) and !empty($course_category) and !empty($category_name))
    {
        $breadcrumbs = array('/courses' => 'Курсы', '/courses/coaches' => $page_category, '/courses/coaches/'.$coach['id'] => $coach['name'], '/' => $category_name);
    }
    elseif(!empty($page_cat_string) and is_numeric($page_cat_string) and !empty($coach))
    {
        $breadcrumbs = array('/courses' => 'Курсы', '/courses/coaches' => $page_category, '/courses/coaches/'.$coach['id'] => $coach['name']);
    }
    else
    {
        $breadcrumbs = array('/courses' => 'Курсы', '/courses/coaches' => $page_category);
    }
    $page_url = (!empty($coach)) ? '/courses/coaches/'.$coach['id'].'/' : $page_url;
}
elseif(!empty($page_category) and !empty($page_cat_string) and $page_category == 'Курсы промокода')
{
    if(!empty($course_category) and !empty($category_name))
    {
        $breadcrumbs = array('/courses' => 'Курсы', '/courses/promocode/'.$page_cat_string => $page_category, '/' => $category_name );
    }
    else
    {
        $breadcrumbs = array('/courses' => 'Курсы', '/courses/promocode/'.$page_cat_string => $page_category);
    }
    $page_url = '/courses/promocode/'.$page_cat_string.'/';
}
elseif(!empty($course_category))
{
    $breadcrumbs = array('/courses' => 'Курсы', '/courses/category' => $course_category);
}
else
{
    $breadcrumbs = array('/courses' => 'Курсы');
}
include_once('./app_fold/views/breadcrumb.php');?>
<div class="shop_line">
    <div class="parent">
        <div class="shop_sort_h">Фильтр:</div>
        <div class="shop_sort_in_wrap parent">
            <a href="/courses/workouts" <?php if($page_filter == 'workouts'): ?>class="checked"<?php endif; ?>>Тренировки</a>
            <?php if(!empty($user_session) and $user_session['type'] == 3): ?>
                <a href="/courses/nutritions" <?php if($page_filter == 'nutritions'): ?>class="checked"<?php endif; ?>>Питание</a>
            <?php endif; ?>
            <a href="/courses/coaches" <?php if($page_filter == 'crs_coaches'): ?>class="checked"<?php endif; ?>>Тренеры</a>
            <?php if($page_filter == 'promocode'): ?>
                <a href="/courses/promocode" class="checked" disabled style="cursor: default; pointer-events: none;">Промокод: <?php echo $page_cat_string; ?></a>
                <input type="hidden" name="pc_string" value="<?php echo $page_cat_string; ?>" id="pc-string">
            <?php endif; ?>
        </div>
    </div>
</div>
<div id="content" class="container kurs_page">
    <?php if((!empty($courses['workouts']) or !empty(!empty($courses['nutritions']))) and !empty($courses_categories)): ?>
        <?php if(!empty($courses['workouts'])): ?>
            <?php foreach($courses['workouts'] as $cat_id => $workouts):?>
                <?php $kurs_slider = ''; ?>
                <h2 class="block_h">
                    <?php echo $courses_categories[$cat_id]['name']; ?>
                    <?php if(empty($page_filter) or ($page_filter == 'workouts' and empty($category_id)) or
                        ($page_filter == 'workouts' and is_numeric($category_id) and $category_id != $cat_id) or
                        ($page_filter == 'promocode' and !empty($pc_type) and ($pc_type == 'categories' or $pc_type == 'workouts') and empty($course_category)) or
                        ($page_filter == 'crs_coaches' and empty($course_category))): ?>
                        <span><a href="<?php echo $page_url; ?>workouts/<?php echo $cat_id; ?>">Посмотреть все курсы категории</a></span>
                        <?php $kurs_slider = 'kurs_page_row_slider'; ?>
                    <?php endif; ?>
                </h2>
                <div class="kurs_page_row row <?php echo $kurs_slider; ?>">
                    <?php foreach($workouts as $course):
                        include('./app_fold/views/course/course_item.php');
                    endforeach;
                    unset($course);?>
                </div>
                <?php if(!empty($type) and !empty($category) and $category == 'Курсы тренировок'):
                    $category_id = 'workouts';
                    $subcategory_id = $category_id;
                    include_once('./app_fold/views/pagination.php');
                endif; ?>
            <?php endforeach;
            unset($workouts);?>
        <?php elseif($page_filter == 'workouts' and is_numeric($category_id)): ?>
            <h2 class="block_h"><?php echo $courses_categories[$category_id]['name']; ?></h2>
            <h3 class="info">Информация не найдена</h3>
        <?php endif; ?>

        <?php if(!empty($courses['nutritions'])): ?>
            <h2 class="block_h">
                Курсы питания
                <?php if(empty($page_filter)): ?>
                    <span><a href="<?php echo $page_url; ?>nutritions">Посмотреть все курсы категории</a></span>
                <?php endif; ?>
            </h2>
            <div class="kurs_page_row row kurs_page_row_slider">
                <?php foreach($courses['nutritions'] as $course):
                    include('./app_fold/views/course/course_item.php');
                endforeach;
                unset($course);?>
            </div>
        <?php elseif($page_filter == 'nutritions'): ?>
            <h2 class="block_h">Курсы питания</h2>
            <h3 class="info">Информация не найдена</h3>
        <?php endif; ?>

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
            $('.kurs_page_row_slider').slick({
                dots: false,
                infinite: true,
                speed: 500,
                autoplay: false,
                arrows: true,
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
                        breakpoint: 650,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }
                    }
                ]
            });
        </script>
    <?php elseif(!empty($coaches)): ?>
        <h2 class="block_h">Тренеры курсов</h2>
        <div class="trainers_row row">
            <?php $crs_coaches = true;
            foreach($coaches as $coach):
                include('./app_fold/views/coach/coach_item.php');
            endforeach;
            unset($coach); ?>
        </div>
    <?php else: ?>
        <h3 class="info">Информация не найдена</h3>
    <?php endif; ?>
    <?php
        include_once('./app_fold/views/site/content/reviews.php');
        include_once('./app_fold/views/site/content/auth_info_block.php');
        include_once('./app_fold/views/site/content/gallery.php');
    ?>
</div>