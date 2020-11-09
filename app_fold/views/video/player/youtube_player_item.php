<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class='embed-container'>
    <?php $url_video_id = mb_substr($remote_url, (strpos($remote_url, 'embed/')+6)); ?>
    <iframe id="player" type="text/html" width="640" height="360" src="<?php echo $remote_url; ?>?enablejsapi=1&loop=1&modestbranding=1&showinfo=0&playlist=<?php echo $url_video_id; ?>&origin=https://superbody.pro&rel=0" frameborder="0"></iframe>
</div>
<script>
    var tag = document.createElement('script');

    tag.src = "https://www.youtube.com/iframe_api";
    var firstScriptTag = document.getElementsByTagName('script')[0];
    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

    var player;
    player = new YT.Player('player', {
        events: {
            'onReady': onPlayerReady,
            'onStateChange': onPlayerStateChange
        }
    });
    var done = false;
    var id, pl_duration, percent;
    function onPlayerStateChange(event) {
        if (event.data === YT.PlayerState.PLAYING) {
            pl_duration = player.getDuration();
            id = setInterval(check, 5000);
        }
        if(event.data === YT.PlayerState.PAUSED || event.data === YT.PlayerState.ENDED) {
            clearInterval(id);
        }
    }
    function check(){
        let curr_time = Math.floor(player.getCurrentTime());
        let curr_percent = Math.floor((100 * curr_time) / pl_duration);
        if(curr_percent > percent)
        {
            // percent = curr_percent;
            console.log(percent);

            $.ajax({
                url: '/viewing/video',
                type: 'post',
                data: {
                    woid: <?php echo $workout_id; ?>,
                    ved_time: curr_time,
                    ved_percent: curr_percent
                },
                complete: function(result){
                    if (result.responseText === 'true')
                    {
                        percent = curr_percent;
                    }
                }
            });
        }
    }
    function onPlayerReady()
    {
        $("#shadow2").on('click', function() {
            $("#shadow2").fadeOut(600);
            player.pauseVideo();
        });
    }
</script>