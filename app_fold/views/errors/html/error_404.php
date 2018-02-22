<?php $title = 'Error 404';
$page_menu = '';
$message = '';
include_once('./app_fold/views/header/header.php');
include_once('./app_fold/views/header/profile.php');
?>

<div id="content" class="container">
    <div class="content_block no_content_block">
        <div class="no_content_block_cont">
            <div class="no_content_val">404</div>
            <div class="no_content_desk">
                <div class="no_content_desk_line">страницы не существует или она была удалена</div>
                <div class="no_content_desk_line">вы можете перейти <a href="/">на главную</a></div>
            </div>
        </div>
    </div>
</div><!-- content -->


<?php include_once('./app_fold/views/footer/footer.php');?>
