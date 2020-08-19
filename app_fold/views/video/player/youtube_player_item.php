<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<style>
    .embed-container { position: relative; padding-bottom: 56.25%; overflow: hidden; max-width: 100%; height: auto; }
    .embed-container iframe, .embed-container object, .embed-container embed { position: absolute; top: 0; left: 0; width: 100%; height: 100%; }
</style>
<div class='embed-container'>
    <?php $url_video_id = mb_substr($remote_url, (strpos($remote_url, 'embed/')+6)); ?>
    <iframe id="player" type="text/html" width="640" height="360" src="<?php echo $remote_url; ?>?enablejsapi=1&loop=1&modestbranding=1&showinfo=0&playlist=<?php echo $url_video_id; ?>&origin=https://superbody.pro&rel=0" frameborder="0"></iframe>
</div>