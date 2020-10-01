<script>
$lms = jQuery.noConflict();

var vimeo_opt1 = {
  id: <?php echo $video_id;?>,
  <?php /*?>width: <?php echo $width;?>,
  height: <?php echo $height;?><?php */?>
  responsive: true
};
var percent = <?php echo $percent;?>;
var player = new Vimeo.Player('lms-vimeo-player', vimeo_opt1);

player.on('timeupdate', function( data ) {
   var currentPercent = Math.ceil(data.percent * 100); 
   if( currentPercent >= percent ){
	   store_vimeo_data();
   }
});

function store_vimeo_data(){
	$lms.ajax({
		method: "POST",
		dataType:"json",
		data: { option: 'storeVimeoData', l_id: <?php echo $post_id;?> }
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


