<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

    <meta name="keywords" content="<?php if(!empty($keywords)): echo $keywords; endif; ?>">
    <meta name="description" content="<?php if(!empty($description)): echo $description; endif; ?>">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="shortcut icon" href="/mobile-icons/favicon.ico" type="image/x-icon" />
    <link rel="apple-touch-icon" sizes="57x57" href="/mobile-icons/apple-touch-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/mobile-icons/apple-touch-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/mobile-icons/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/mobile-icons/apple-touch-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/mobile-icons/apple-touch-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/mobile-icons/apple-touch-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/mobile-icons/apple-touch-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/mobile-icons/apple-touch-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/mobile-icons/apple-touch-icon-180x180.png">
    <link rel="icon" type="image/png" href="/mobile-icons/favicon-16x16.png" sizes="16x16">
    <link rel="icon" type="image/png" href="/mobile-icons/favicon-32x32.png" sizes="32x32">
    <link rel="icon" type="image/png" href="/mobile-icons/favicon-96x96.png" sizes="96x96">
    <link rel="icon" type="image/png" href="/mobile-icons/android-chrome-192x192.png" sizes="192x192">
    <meta name="msapplication-square70x70logo" content="/mobile-icons/smalltile.png" />
    <meta name="msapplication-square150x150logo" content="/mobile-icons/mediumtile.png" />
    <meta name="msapplication-wide310x150logo" content="/mobile-icons/widetile.png" />
    <meta name="msapplication-square310x310logo" content="/mobile-icons/largetile.png" />

    <link rel="stylesheet" href="/css/google_fonts.css">
    <link rel="stylesheet" href="/css/grid.css">
    <link rel="stylesheet" href="/css/px-video.css">
    <link rel="stylesheet" href="/css/slick.css">
    <link rel="stylesheet" href="/css/lightbox.css">
    <link rel="stylesheet" href="/css/jquery.formstyler.css">
    <link rel="stylesheet" href="/css/font-awesome.min.css">
    <link rel="stylesheet" href="/css/font-awesome/all.css">

    <?php include_once('./app_fold/views/header/reporting_services2.php'); ?>

    <script src="/js/moment.min.js"></script>
    <script src="/js/jquery.min.js"></script>
    <script src="/js/amcharts/amcharts.js"></script>
    <script src="/js/amcharts/serial.js"></script>
    <script src="/js/amcharts/amstock.js"></script>
    <script src='/fullcalendar/core/main.js'></script>
    <script src='/fullcalendar/daygrid/main.js'></script>
    <script src='/fullcalendar/timegrid/main.js'></script>
    <script src='/fullcalendar/list/main.js'></script>
    <script src='/fullcalendar/interaction/main.js'></script>
    <script src="/js/strings.js"></script>
    <script src="/js/px-video.js"></script>
    <script src="/js/slick.min.js"></script>
    <script src="/js/jquery.formstyler.js"></script>
    <script src="/js/autoresize-textarea.js"></script>
    <script src="/js/masonry.pkgd.min.js"></script>
    <script src="/js/jquery.mask.min.js" type="text/javascript"></script>
    <script src="/js/tinymce/jquery.tinymce.min.js" type="text/javascript"></script>
    <script src="/js/tinymce/tinymce.min.js" type="text/javascript"></script>
    <script src="/js/js.cookie.js" type="text/javascript"></script>

    <?php include_once('./app_fold/views/header/styles_scripts.php'); ?>

    <script src="https://player.vimeo.com/api/player.js"></script>

<?php if($_SERVER['SERVER_NAME'] != 'sb.theoutlines.ru' and mb_substr($_SERVER['REQUEST_URI'], 0, 15) != '/administration'): ?>
    <script src="//static-login.sendpulse.com/apps/fc3/build/loader.js" sp-form-id="23a222fb3923d54bb39a6c7de5790b59d655651dc07e91e90adad86c6f323576"></script>
    <script charset="UTF-8" src="//web.webpushs.com/js/push/2b45b28120dd22639aa19427eabaedab_1.js" async></script>
<?php endif;?>
