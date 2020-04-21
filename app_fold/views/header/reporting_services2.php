<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<?php if($_SERVER['SERVER_NAME'] != 'sb.theoutlines.ru' and mb_substr($_SERVER['REQUEST_URI'], 0, 15) != '/administration'): ?>
<meta name="yandex-verification" content="fbc35dfc3ef66ae0" />
<meta name='wmail-verification' content='c49202d54c0fb7f8e8847bfd048f81dd' />
<meta name="msvalidate.01" content="60DCFF887D5472AFA3314F542E53F876" />

<!-- Global Site Tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=GA_TRACKING_ID"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-136119880-1');
</script>
<?php endif; ?>
