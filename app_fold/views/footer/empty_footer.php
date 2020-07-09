<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<?php if (!isset($_COOKIE["disclaimer"])): ?>
    <div id="cookie_disclaimer">
        <?php echo $site_info['cookies_text']; ?>
        <span id="cookie_stop">Ok</span>
    </div>
<?php endif; ?>

<script src="/js/lightbox.js"></script>
<script src="/js/vimeo_player.js"></script>
<?php include_once('./app_fold/views/footer/jivo_script.php'); ?>
</body>
</html>
