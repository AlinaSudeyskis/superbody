<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$user_name     = (!empty($user_data['user_name'])) ? $user_data['user_name'] : 'Страница тренера';
$category_name = (!empty($category_id) and is_numeric($category_id) and !empty($blog_categories))
    ? $blog_categories[$category_id]['name'] : null;

$breadcrumbs = array('/blog' => 'Блог');
if(!empty($category_name))
{
    $breadcrumbs = array('/blog' => 'Блог', '/type' => $category_name);
}
include_once('./app_fold/views/breadcrumb.php');
?>
<div id="content" class="container posts_page">
    <?php if (!empty($posts) and !empty($blog_categories)): ?>
        <?php foreach ($posts as $cat_id => $b_posts):
            $post_path = '/blog/post/';
            $posts_slider = ''; ?>
            <h2 class="block_h">
                <?php $category_name = ($cat_id > 0 and !empty($blog_categories[$cat_id]['name'])) ? $blog_categories[$cat_id]['name'] : 'Статьи без категории'; ?>
                <?php echo $category_name; ?>
                <?php if(empty($category_id)): ?>
                    <span><a href="blog/<?php echo $cat_id; ?>">Посмотреть все статьи категории</a></span>
                    <?php $posts_slider = 'kurs_page_row_slider'; ?>
                <?php endif; ?>
            </h2>
            <div class="kurs_page_row row <?php echo $posts_slider; ?>">
                <?php foreach($b_posts as $post): ?>
                    <?php include('./app_fold/views/blog/posts_item.php'); ?>
                <?php endforeach;
                unset($post);?>
            </div><!-- kurs_page_row -->
            <?php if(!empty($category_id)):
                include_once('./app_fold/views/pagination.php');
            endif; ?>
        <?php endforeach;
        unset($b_posts);?>

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
                slidesToShow: 5,
                slidesToScroll: 1,
                responsive: [
                    {
                        breakpoint: 1930,
                        settings: {
                            slidesToShow: 4,
                            slidesToScroll: 1
                        }
                    },
                    {
                        breakpoint: 1420,
                        settings: {
                            slidesToShow: 3,
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
                        breakpoint: 750,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }
                    }
                ]
            });
        </script>
    <?php else: ?>
        <h3 class="info">Информация не найдена</h3>
    <?php endif;?>
</div><!-- content -->
