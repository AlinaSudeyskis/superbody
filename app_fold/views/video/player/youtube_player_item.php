<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<style>
    .embed-container { position: relative; padding-bottom: 56.25%; overflow: hidden; max-width: 100%; height: auto; }
    .embed-container iframe, .embed-container object, .embed-container embed { position: absolute; top: 0; left: 0; width: 100%; height: 100%; }
</style>
<div class='embed-container'>
    <iframe id="player" type="text/html" width="640" height="360" src="<?php echo $remote_url; ?>?enablejsapi=1&origin=http://sb.theoutlines.ru&rel=0" frameborder="0"></iframe>
</div>