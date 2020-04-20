<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<style>
    .embed-container { position: relative; padding-bottom: 56.25%; overflow: hidden; max-width: 100%; height: auto; }
    .embed-container iframe, .embed-container object, .embed-container embed { position: absolute; top: 0; left: 0; width: 100%; height: 100%; }
</style>
<div class='embed-container'>
    <div data-vimeo-url="<?php echo $remote_url; ?>" id="vimeo-player-<?php echo $key; ?>" class="vimeo_players" data-vimeo-width="640" data-vimeo-loop="false" data-vimeo-allow="autoplay; encrypted-media"></div>
</div>

