<script>
$tg = jQuery.noConflict();

var player;
var percent = <?php echo $percent;?>;
var timer;

function onYouTubeIframeAPIReady() {
	player = new YT.Player('tg-yt-player', {
	  width: '100%',
	  //height: '100%',
	  videoId: '<?php echo $video_id;?>',
	  events: {
		'onStateChange': onPlayerStateChange
	  }
	});
}

function onPlayerStateChange(event) {
	switch (event.data) {
		case YT.PlayerState.PLAYING:
			yt_playing_callback();
			break;
	};
};

function yt_threshold_reached() {
   store_yt_data();
}

function yt_playing_callback() {
	clearTimeout(timer);
	current_time = Math.round( player.getCurrentTime() );
	total_time = Math.round( player.getDuration() );
	minimum_time = Math.round( ( total_time * percent ) / 100 );
	remaining_time = minimum_time - current_time;
	if (remaining_time > 0) {
		timer = setTimeout(yt_threshold_reached, remaining_time * 1000);
	} else {
		yt_threshold_reached();
	}
}

function store_yt_data(){
	$tg.ajax({
		method: "POST",
		dataType:"json",
		data: { option: 'storeYTData', l_id: <?php echo $lesson_id;?> }
	})
	.done(function( res ) {
		if( res.status == 'success' ){
			//data stored
		} else {
			alert(res.msg);
		}
	});
}
</script>
