<?php

class class_resource_data extends class_lesson_data{
	
	public function __construct(){
		parent::__construct();
		//add_action( 'add_meta_boxes_lms_resource', array( $this, 'resources_v1' ) );
		add_action( 'add_meta_boxes_lms_resource', array( $this, 'resources' ) );
		add_action( 'add_meta_boxes_lms_resource', array( $this, 'internal_title' ) );
		
		add_filter( 'manage_lms_resource_posts_columns', array( $this, 'set_custom_lms_resource_columns' ) );
		add_action( 'manage_lms_resource_posts_custom_column' , array( $this, 'custom_lms_resource_columns' ), 10, 2 );
	}
		
	public function resources_v1( $post ) {
		add_meta_box(
			'resources_v1',
			__( 'Resources V1', 'lms' ),
			array( $this, 'resources_callback_v1' ), $post->post_type, 'advanced' 
		);
	}

	public function resources_callback_v1( $post ) {
		global $wpdb;
		$results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM ".$wpdb->prefix."lms_resource WHERE post_id = %d", $post->ID ), OBJECT );
		
		$attaches = '';
		if(is_array($results)){
			foreach($results as $key => $value){
				
				if( $value->att_id == 0 ){
					$r_link = json_decode( $value->r_link, true );
					$inp = '<input type="hidden" name="lmsr_atts[]" value="0"><input type="hidden" name="link_names[]" value="'.$r_link['name'].'"><input type="hidden" name="link_urls[]" value="'.$r_link['url'].'"><input type="hidden" name="link_open_in_new_tabs[]" value="'.$r_link['open_in_new_tab'].'">';
					
					$link_open_in = '';
					if( $r_link['open_in_new_tab'] == 'yes' ){
						$link_open_in = __('Open in new tab','lms');
					}
					
					$lnk = '<strong>Link Name</strong> ' . $r_link['name'] . '<br><strong>Link URL</strong> ' . $r_link['url'] . '<br><strong>' . $link_open_in . '</strong>';
					$rem = '<div class="ru-links"><a href="javascript:void(0);" onclick="remove_lms_resource_attachment('.$value->r_id.');" class="lms-delete">'.LMS_DELETE_IMAGE.'</a></div>';
					$attaches .= '<div class="rbox" id="lmsr-'.$value->r_id.'">'.$inp.$lnk.$rem.'</div>';
				} else {
					$inp = '<input type="hidden" name="lmsr_atts[]" value="'.$value->att_id.'"><input type="hidden" name="link_names[]" value=""><input type="hidden" name="link_urls[]" value=""><input type="hidden" name="link_open_in_new_tabs[]" value="">';
					$img = '<div class="resource-file"><img src="'. $this->get_attachment_icon( wp_get_attachment_url( $value->att_id ) ).'">';
					$fd = basename( wp_get_attachment_url( $value->att_id ) ) . '</div>';
					$down = '<div class="ru-links"><a href="'.wp_get_attachment_url( $value->att_id ).'" target="_blank" class="down lms-download">'.LMS_DOWNLOAD_IMAGE.'</a>';
					$rem = '<a href="javascript:void(0);" onclick="remove_lms_resource_attachment('.$value->r_id.');" class="lms-delete">'.LMS_DELETE_IMAGE.'</a></div>';
					$attaches .= '<div class="rbox" id="lmsr-'.$value->r_id.'">'.$inp.$img.$fd.$down.$rem.'</div>';
				}
				
			}
		}
		
		wp_nonce_field( 'attachment_meta_box', 'attachment_meta_box_nonce' );
		$this->resource_js( $post->ID );
		?>
        <div style="width:100%; padding:10px 0px; float:left;">
			<div style="width:100%; margin-bottom:10px; float:left;">
            	<div style="float:right; margin-left:5px;"><a href="javascript:lms_resource_attachment()" class="preview button">Add File</a></div>
            	<div><a href="javascript:void()" id="add_resource_link" class="preview button">Add Link</a></div>
            </div>	
			<div id="lms_resources"><?php echo $attaches;?></div>
		</div>
        
        <div id="resource-link-form" title="<?php _e('Resource Link','lms');?>">
         <div class="lms-popup-form-inner">
            <p><?php _e('Link Name','lms');?> <input type="text" name="link_name" id="link_name" class="widefat" value="" placeholder="<?php _e('Enter link name','lms');?>" required></p>
         </div>
         <div class="lms-popup-form-inner">
            <p><?php _e('Link URL','lms');?> <input type="text" name="link_url" id="link_url" class="widefat" value="" placeholder="<?php _e('Enter link URL','lms');?>" required></p>
         </div>
         <div class="lms-popup-form-inner">
            <p><label><?php _e('Link Open in new Tab','lms');?> <input type="checkbox" name="link_open_in_new_tab" id="link_open_in_new_tab" value="yes"></label></p>
         </div>
        </div>
        
        <div style="clear:both;"></div>
        <?php
	}

	public function resources( $post ) {
		add_meta_box(
			'resource',
			__( 'Resource Data', 'lms' ),
			array( $this, 'resources_callback' ), $post->post_type, 'advanced' 
		);
	}

	public function resources_callback( $post ) {
		$link_url = get_post_meta( $post->ID, 'link_url', true );
		$link_open_in_new_tab = get_post_meta( $post->ID, 'link_open_in_new_tab', true );
		$link_nofollow = get_post_meta( $post->ID, 'link_nofollow', true );

		wp_nonce_field( 'attachment_meta_box', 'attachment_meta_box_nonce' );
		?>
		
		<p><?php _e('URL','lms');?> <input type="text" name="link_url" class="widefat" value="<?php echo $link_url;?>" placeholder="<?php _e('Enter URL','lms');?>"></p>

		<p><label><?php _e('Link Open in new Tab','lms');?> <input type="checkbox" name="link_open_in_new_tab" value="yes" <?php echo ($link_open_in_new_tab == 'yes' or !metadata_exists('post',$post->ID,'link_open_in_new_tab'))?'checked':'';?>></label></p>

		<p><label><?php _e('Nofollow','lms');?> <input type="checkbox" name="link_nofollow" value="yes" <?php echo $link_nofollow == 'yes'?'checked':'';?>></label></p>

        <div style="clear:both;"></div>
        <?php
	}
	
	public function internal_title( $post ) {
		add_meta_box(
			'internal_title',
			__( 'Internal Title (Optional)', 'lms' ),
			array( $this, 'internal_title_callback' ), $post->post_type, 'advanced' 
		);
	}

	public function internal_title_callback( $post ) {
		$link_internal_title = get_post_meta( $post->ID, 'link_internal_title', true );
		wp_nonce_field( 'attachment_meta_box', 'attachment_meta_box_nonce' );
		?>

        <p><input type="text" name="link_internal_title" class="widefat" value="<?php echo $link_internal_title;?>" placeholder="<?php _e('Internal Title','lms');?>"></p>
        <div style="clear:both;"></div>

        <?php
	}

	
	public function resource_js( $post_id ){
	wp_enqueue_media();
	global $lms_resource_icons;
	?>
    <script>
	function get_attachment_icon(url){
		var ext = url.split('.').pop();
		switch (ext) {
			case 'jpg':
				src = url;
				break;
			case 'jpeg':
				src = url;
				break;
			case 'png':
				src = url;
				break;
			case 'bmp':
				src = url;
				break;
			case 'gif':
				src = url;
				break;
			case 'doc':
				src = '<?php echo $lms_resource_icons['doc']['big'];?>';
				break;
			case 'docx':
				src = '<?php echo $lms_resource_icons['doc']['big'];?>';
				break;
			case 'xls':
				src = '<?php echo $lms_resource_icons['xls']['big'];?>';
				break;
			case 'xlsx':
				src = '<?php echo $lms_resource_icons['xls']['big'];?>';
				break;
			case 'ppt':
				src = '<?php echo $lms_resource_icons['ppt']['big'];?>';
				break;
			case 'pptx':
				src = '<?php echo $lms_resource_icons['pptx']['big'];?>';
				break;
			case 'csv':
				src = '<?php echo $lms_resource_icons['csv']['big'];?>';
				break;
			case 'zip':
				src = '<?php echo $lms_resource_icons['zip']['big'];?>';
				break;
			case 'txt':
				src = '<?php echo $lms_resource_icons['txt']['big'];?>';
				break;
			case 'htm':
				src = '<?php echo $lms_resource_icons['html']['big'];?>';
				break;
			case 'html':
				src = '<?php echo $lms_resource_icons['html']['big'];?>';
				break;
			case 'pdf':
				src = '<?php echo $lms_resource_icons['pdf']['big'];?>';
				break;
			case 'mp4':
				src = '<?php echo $lms_resource_icons['mp4']['big'];?>';
				break;
			default:
				src = '<?php echo $lms_resource_icons['oth']['big'];?>';
		} 
		return(src);
	}
	  
	function lms_resource_attachment(){
		var file_frame;
		if ( file_frame ) {
		  file_frame.open();
		  return;
		}
		file_frame = wp.media.frames.file_frame = wp.media({
		  title: jQuery( this ).data( 'uploader_title' ),
		  button: {
			text: jQuery( this ).data( 'uploader_button_text' ),
		  },
		  multiple: true 
		});
		file_frame.on( 'select', function() {
		var selection = file_frame.state().get('selection');
		selection.map( function( attachment ) {
			attachment = attachment.toJSON();
			var inp = '<input type="hidden" name="lmsr_atts[]" value="'+attachment.id+'">';
			var img = '<img src="'+get_attachment_icon(attachment.url)+'" width="100">';
			var rem = '<div class="ru-links"><a href="javascript:void(0);" class="rem lms-delete"><?php echo LMS_DELETE_IMAGE;?></a></div>';
			jQuery('#lms_resources').append('<div class="rbox">'+inp+img+rem+'</div>');
		});
		});
		file_frame.open();  
	}
	
	function remove_lms_resource_attachment(a_id){
		jQuery('#lmsr-'+a_id).remove();
	}
	
	jQuery('.rem').live('click', function( event ){
		jQuery(this).parent().parent('div').remove();  
	});
	
	jQuery( function() {
		var dialog;
		
		function validateRegexp( o, regexp ) {
			if ( !( regexp.test( o.val() ) ) ) {
				return false;
			} else {
				return true;
			}
		}
	
		function addResourceLink() {
			var link_name = jQuery('#link_name');
			var link_url = jQuery('#link_url');
			var link_open_in_new_tab = jQuery('#link_open_in_new_tab');
			var link_open_in_new_tab_val = '';
			
			if( link_open_in_new_tab.attr('checked')){
				link_open_in_new_tab_val = 'yes';
			}
			
			valid_link_name = validateRegexp( link_name, /^[a-zA-Z0-9][a-zA-Z0-9\s]*/i );
			valid_link_url = validateRegexp( link_url, /(http(s)?:\/\/.)?(www\.)?[-a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_\+.~#?&//=]*)/g );
			
			if( !valid_link_name ){
				alert('Please enter link name!');
				return false;
			}
			
			if( !valid_link_url ){
				alert('Please enter link URL!');
				return false;
			}
			
			var inp = '<input type="hidden" name="lmsr_atts[]" value="0"><input type="hidden" name="link_names[]" value="'+link_name.val()+'"><input type="hidden" name="link_urls[]" value="'+link_url.val()+'"><input type="hidden" name="link_open_in_new_tabs[]" value="'+link_open_in_new_tab_val+'">';
			
			var link_open_in = '';
			if( link_open_in_new_tab_val == 'yes' ){
				link_open_in = 'Open in new tab';
			}
					
			var lnk = '<strong>Link Name</strong>' + link_name.val() + '<br><strong>Link URL</strong> ' + link_url.val() + '<br><strong>' + link_open_in + '</strong>';
			var rem = '<div class="ru-links"><a href="javascript:void(0);" class="rem lms-delete"><?php echo LMS_DELETE_IMAGE;?></a></div>';
			jQuery('#lms_resources').append('<div class="rbox">'+inp+lnk+rem+'</div>');
			
			// reset 
			link_name.val('');
			link_url.val('');
			link_open_in_new_tab.attr('checked', false);
			
			// close
			dialog.dialog( "close" );
		}
	 
		dialog = jQuery( "#resource-link-form" ).dialog({
		  autoOpen: false,
		  modal: true,
		  buttons: {
			"Add Link": addResourceLink,
			Cancel: function() {
			  dialog.dialog( "close" );
			}
		  }
		});
	 
		jQuery( "#add_resource_link" ).live( "click", function() {
		  dialog.dialog( "open" );
		});
	});
	
	jQuery(function() {
		jQuery("#lms_resources").sortable();
    });
		
	</script>
    <?php
	}
	
	public function get_attachment_icon( $url ){
		global $lms_resource_icons;
		$ext = substr(strrchr($url,'.'),1);
		switch ($ext) {
			case 'jpg':
				$src = $url;
				break;
			case 'jpeg':
				$src = $url;
				break;
			case 'png':
				$src = $url;
				break;
			case 'bmp':
				$src = $url;
				break;
			case 'gif':
				$src = $url;
				break;
			case 'doc':
				$src = $lms_resource_icons['doc']['big'];
				break;
			case 'docx':
				$src = $lms_resource_icons['doc']['big'];
				break;
			case 'xls':
				$src = $lms_resource_icons['xls']['big'];
				break;
			case 'xlsx':
				$src = $lms_resource_icons['xls']['big'];
				break;
			case 'ppt':
				$src = $lms_resource_icons['ppt']['big'];
				break;
			case 'pptx':
				$src = $lms_resource_icons['ppt']['big'];
				break;
			case 'csv':
				$src = $lms_resource_icons['csv']['big'];
				break;
			case 'zip':
				$src = $lms_resource_icons['zip']['big'];
				break;
			case 'txt':
				$src = $lms_resource_icons['txt']['big'];
				break;
			case 'htm':
				$src = $lms_resource_icons['html']['big'];
				break;
			case 'html':
				$src = $lms_resource_icons['html']['big'];
				break;	
			case 'pdf':
				$src = $lms_resource_icons['pdf']['big'];
				break;
			case 'mp4':
				$src = $lms_resource_icons['mp4']['big'];
				break;
			default:
				$src = $lms_resource_icons['oth']['big'];
		} 
		return $src;
	}
	
	// resource type column //
	public function set_custom_lms_resource_columns($columns) {
		//$columns['resource_type'] = __( 'Type', 'lms' );
		$columns['internal_title'] = __( 'Internal Title', 'lms' );
		$columns['url'] = __( 'URL', 'lms' );
		$columns['lesson_name'] = __( 'Lesson Name', 'lms' );
		return $columns;
	}
	
	public function custom_lms_resource_columns( $column, $post_id ) {
		switch ( $column ) {
			case 'resource_type' :
				$types = $this->get_resource_types( $post_id );
				echo implode(", ", $types);
			break;
			case 'internal_title' :
				echo get_post_meta( $post_id, 'link_internal_title', true );
			break;
			case 'url' :
				echo get_post_meta( $post_id, 'link_url', true );
			break;
			case 'lesson_name' :
				$lesson_ids = lms_get_lesson_ids_from_resource_id($post_id);
				if(is_array($lesson_ids)){
					$lesson_names = array();
					foreach($lesson_ids as $lesson_id){
						$lesson_names[] = '<a href="post.php?post='.$lesson_id.'&action=edit">'.get_the_title($lesson_id).'</a>';
					}
					echo implode("<br>",$lesson_names);
				} else {
					_e('Not yet assigned to any course!','lms');
				}
			break;
		}
	}
	
	public function get_resource_types( $post_id ){
		global $wpdb;
		$type = array();
		$results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM ".$wpdb->prefix."lms_resource WHERE post_id = %d", $post_id  ), OBJECT );
		foreach( $results as $key => $value ){
			if( $value->att_id == 0 ){
				$type[] = __('Link', 'lms');
			} else {
				$type[] = __('File', 'lms');
			}
		}
		return $type;
	}
	// resource type column //
	
}
