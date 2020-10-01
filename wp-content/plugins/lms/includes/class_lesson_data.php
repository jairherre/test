<?php

class class_lesson_data extends class_course_data{
	
	public function __construct(){
		parent::__construct();
		add_action( 'add_meta_boxes_lms_lesson', array( $this, 'lesson_options' ) );

		// course name
		add_filter( 'manage_lms_lesson_posts_columns', array( $this, 'set_custom_lms_lesson_columns_for_course_name' ) );
		add_action( 'manage_lms_lesson_posts_custom_column', array( $this, 'custom_lms_lesson_columns_for_course_name' ), 10, 2 );

		// section name
		add_filter( 'manage_lms_lesson_posts_columns', array( $this, 'set_custom_lms_lesson_columns_for_section_name' ) );
		add_action( 'manage_lms_lesson_posts_custom_column', array( $this, 'custom_lms_lesson_columns_for_section_name' ), 10, 2 );

		// by course filter
		add_action( 'restrict_manage_posts', array( $this, 'lms_filter_lessons_by_course' ), 10 ); 
		add_filter( 'parse_query', array( $this, 'prefix_lms_filter_lessons_by_course' ) );
	}
	
	public function prefix_lms_filter_lessons_by_course( $query ) {
		global $pagenow;

		$current_page = isset( $_GET['post_type'] ) ? $_GET['post_type'] : '';
		if ( is_admin() && 'lms_lesson' == $current_page && 'edit.php' == $pagenow && isset( $_GET['course_id'] ) && $_GET['course_id'] != '') {
			$course_id = sanitize_text_field($_GET['course_id']);
			$lessons = lms_get_only_lessons_from_course($course_id);
			$query->query_vars['post__in'] = $lessons;
		}

		return $query;
	}

	public function lms_filter_lessons_by_course( $post_type ) {
		global $wpdb;
		if('lms_lesson' !== $post_type){
			return;
		}
		$results = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."posts WHERE post_status = 'publish' AND post_type = 'lms_course' ORDER BY post_date DESC", OBJECT);
		if(is_array($results)){
			echo '<select name="course_id" id="course_id" class="postform">';
			echo '<option value="">'.__('All Lessons','lms').'</option>';
			foreach($results as $key => $value){
				if($value->ID == sanitize_text_field($_GET['course_id'])){
					echo '<option value="'.$value->ID.'" selected>'.get_the_title($value->ID).'</option>';
				}else {
					echo '<option value="'.$value->ID.'">'.get_the_title($value->ID).'</option>';
				}
			}
			echo '</select>';
		}
	}

	public function mapping_resource_js( $post_id ){
	?>
    <script>
		jQuery( function() {
			var dialog;
			function assignResource() {
			  var resource_id = jQuery('#resource_id').val();
			  var link_title = jQuery('#link_title').val();
			  var link_internal_title = jQuery('#link_internal_title').val();
			  var link_url = jQuery('#link_url').val();
			  
			  var link_open_in_new_tab = '';
			  if (jQuery('#link_open_in_new_tab').is(':checked')) {
			  	link_open_in_new_tab = 'yes';
              }

			  var link_nofollow = '';
			  if (jQuery('#link_nofollow').is(':checked')) {
				link_nofollow = 'yes';
              }

			  jQuery.ajax({
				  method: "POST",
				  dataType:"json",
				  data: { 
					  option: 'assignResource', 
					  l_id: <?php echo $post_id;?>, 
					  resource_id: resource_id,
					  link_title: link_title,
					  link_internal_title: link_internal_title,
					  link_url: link_url,
					  link_open_in_new_tab: link_open_in_new_tab,
					  link_nofollow: link_nofollow
					  }
			  })
			  .done(function( res ) {
				if( res.status == 'true' ){
					jQuery(res.data).appendTo( jQuery('#resource_list' ) );
					dialog.dialog( "close" );
				} else {
					alert(res.data);
				}
				return true;
			  });
			}
		 
			dialog = jQuery( "#resource-assign-form" ).dialog({
			  autoOpen: false,
			  modal: true,
			  width: 500,
			  buttons: {
				"Assign Resource": assignResource,
				Cancel: function() {
				  dialog.dialog( "close" );
				}
			  }
			});
		 
			jQuery( "#add_resource" ).live( "click", function() {
			  dialog.dialog( "open" );
			});
			
			jQuery("#resource_search").keyup(function(){
				jQuery.ajax({
				type: "POST",
				data: { option: 'ResourceSearch', resource_search: jQuery('#resource_search').val() },
				beforeSend: function(){
					jQuery("#resource_search").css( "background", "#FFF url(<?php echo plugins_url( LMS_DIR_NAME . '/images/input_loader.gif' )?>) no-repeat scroll right" );
				},
				success: function(data){
					jQuery("#resource_search_result").show();
					jQuery("#resource_search_result").html(data);
					jQuery("#resource_search").css( "background", "#FFF" );
				}
				});
			});
		});
	
		function resourceSelectionFromSearch( r_id, r_title ){
			jQuery('#resource_id').val( r_id );
			jQuery('#resource_selected').html( 'Selected Resource : ' + r_title );
			jQuery('#resource_search').val('');
			jQuery('#resource_search_result').html('');
			jQuery('#resource_search_result').hide();
		}
	
		function removeResource( rm ){
			jQuery(rm).parent().remove();
		}
		
		jQuery(function() {
			jQuery("#resource_list").sortable();
        });
		
		jQuery( function() {
			var dialog;
			function assignResourceTitle() {
			  var resource_title = jQuery('#resource_title').val();
			  jQuery.ajax({
				  method: "POST",
				  dataType:"json",
				  data: { option: 'assignResourceTitle', l_id: <?php echo $post_id;?>, resource_title: resource_title }
			  })
			  .done(function( res ) {
				if( res.status == 'true' ){
					jQuery(res.data).appendTo( jQuery('#resource_list' ) );
					dialog.dialog( "close" );
				} else {
					alert(res.data);
				}
				return true;
			  });
			}
		 
			dialog = jQuery( "#resource-title-assign-form" ).dialog({
			  autoOpen: false,
			  modal: true,
			  width: 500,
			  buttons: {
				"Assign Resource Title": assignResourceTitle,
				Cancel: function() {
				  dialog.dialog( "close" );
				}
			  }
			});
		 
			jQuery( "#add_resource_title" ).live( "click", function() {
			  dialog.dialog( "open" );
			});
			
		});
	</script>
    <?php
	}
	
	public function video_integration_js( $post_id ){
	?>
    <script>
	function toggle_video_shortcode_display(v){
		if (jQuery('#video_insert_manually').is(':checked')) {
			jQuery('#video_shortcode').show();
		} else {
			jQuery('#video_shortcode').hide();
		}
	}
	toggle_video_shortcode_display('<?php echo get_post_meta($post_id, 'video_insert_manually', true);?>')
	</script>
    <?php
	}

	public function lesson_options( $post ) {
		add_meta_box(
			'lesson_options',
			__( 'Lesson Options', 'lms' ),
			array( $this, 'lesson_options_callback' ), $post->post_type, 'advanced' 
		);
	}
	
	public function lesson_options_callback( $post ) {
		global $wpdb;
		wp_nonce_field( 'attachment_meta_box', 'attachment_meta_box_nonce' );
		?>

		<!-- video settings -->
		<?php
		/*if(get_post_meta( $post->ID, 'video_width', true )){
			$video_width = (int)get_post_meta( $post->ID, 'video_width', true );
		} else {
			$video_width = LMS_DEFAULT_VIDEO_WIDTH;
		}
		if(get_post_meta( $post->ID, 'video_height', true )){
			$video_height = (int)get_post_meta( $post->ID, 'video_height', true );
		} else {
			$video_height = LMS_DEFAULT_VIDEO_HEIGHT;
		}*/	

		// check for defaults 
		$default_enabled = 'false';	
		$course_id = lms_get_probable_course_id_which_has_this_lesson($post->ID);
		$default_video_enabled = get_post_meta($course_id, 'watching_video_mandatory', true);
		$default_video_minimum_percentage = (int)get_post_meta($course_id,'video_minimum_percentage', true );
		if( $default_video_enabled == 'Yes' and $default_video_minimum_percentage != 0){
			$default_enabled = 'true';
		}
		// check for defaults 

		$video_url = get_post_meta( $post->ID, 'video_url', true );
		$video_minimum_percentage = (int)get_post_meta( $post->ID, 'video_minimum_percentage', true );
		?>
        
        <?php /*?><strong><?php _e('Video Width', 'lms');?></strong>
        <p><input type="text" name="video_width" value="<?php echo $video_width;?>" class="widefat"></p>
        
        <strong><?php _e('Vimeo Height', 'lms');?></strong>
        <p><input type="text" name="video_height" value="<?php echo $video_height;?>" class="widefat"></p><?php */?>

        <strong><?php _e('Video URL', 'lms');?></strong>
        <p><input type="text" name="video_url" value="<?php echo $video_url;?>" class="widefat"></p>
        
        <!--<p>
        <label><input type="checkbox" name="video_add_automatically_below_title" value="yes" <?php echo get_post_meta($post->ID, 'video_add_automatically_below_title', true) == 'yes'?'checked':'';?>><?php _e('Automatically add video below title', 'lms');?></label>
        </p>-->
        
        <!--<p>
        <label><input type="checkbox" name="video_insert_manually" id="video_insert_manually" value="yes" onClick="toggle_video_shortcode_display(this.value)" <?php echo get_post_meta($post->ID, 'video_insert_manually', true) == 'yes'?'checked':'';?>><?php _e('Insert video manually with shortcode', 'lms');?></label>
        </p>
        <div id="video_shortcode" style="display:none;">
        [lms_video post_id="<?php echo $post->ID;?>"<?php /*?>width="<?php echo $video_width;?>" height="<?php echo $video_height;?>"<?php */?>]
        </div>-->
       
		<p style="display:<?php echo $default_enabled == 'true'?'none':'block'?>;">
        <label><input type="checkbox" name="video_watching_is_mandatory" id="video_watching_is_mandatory" value="yes" <?php echo (get_post_meta($post->ID, 'video_watching_is_mandatory', true) == 'yes' or $default_enabled == 'true')?'checked':'';?> onClick="toggle_video_percent_display(this, '<?php echo $default_enabled;?>')"><?php _e('Make watching this lesson mandatory', 'lms');?></label>
        </p>

		<div id="video_percent_by_lesson">
        	<p><input type="number" name="video_minimum_percentage" id="video_minimum_percentage_1" value="<?php echo $video_minimum_percentage;?>" placeholder="100">
			<?php _e('Minimum % (0 to 100) required to watch to mark this lesson complete', 'lms');?>
			</p>
		</div>

		<div id="video_percent_by_course">
			<p><?php echo sprintf( __( 'Your settings for this course require the students to watch %s of this video, before they can mark this lesson complete.', 'lms' ), $default_video_minimum_percentage . '%' );?></p>

			<label><input type="checkbox" name="video_minimum_percentage_by_lesson" id="video_minimum_percentage_by_lesson" value="yes" <?php echo get_post_meta($post->ID, 'video_minimum_percentage_by_lesson', true) == 'yes'?'checked':'';?> onClick="lmsToggleView(this,'video_percent_by_lesson_2')"><?php _e('Use custom settings for this video', 'lms');?></label>

			<div id="video_percent_by_lesson_2_settings">
        	<p><input type="number" name="video_minimum_percentage" id="video_minimum_percentage_2" value="<?php echo $video_minimum_percentage;?>" placeholder="100">
			<?php _e('Minimum % (0 to 100) required to watch to mark this lesson complete', 'lms');?>
			</p>
			</div>

		</div>
       
        <div style="clear:both;"></div>
		<?php $this->video_integration_js( $post->ID );	?>
		<script>
		toggle_video_percent_display(jQuery('#video_watching_is_mandatory'), '<?php echo $default_enabled;?>');
		lmsToggleView(jQuery('#video_minimum_percentage_by_lesson'), 'video_percent_by_lesson_2');
		</script>
		<!-- video settings -->

		<!-- forminator integration -->
		<strong><?php _e('Quiz/Form', 'lms');?></strong>
		<?php
		$enable_forminator = get_post_meta( $post->ID, 'enable_forminator', true );
		$forminator_frm_type = get_post_meta( $post->ID, 'forminator_frm_type', true );
		$forminator_quiz_minimum_percentage = (int)get_post_meta( $post->ID, 'forminator_quiz_minimum_percentage', true );
		?>
        <p><label><input type="checkbox" name="enable_forminator" id="enable_forminator" value="yes" <?php echo ($enable_forminator == 'yes'?'checked':'');?> onClick="lmsToggleView(this,'forminator')"><?php _e('Check to enable');?></label></p>
		
		<div id="forminator_settings">
			<p><select name="forminator_frm_type" id="forminator_frm_type" onchange="forminatorTypeToggle(this)"><option value="form" <?php echo $forminator_frm_type == 'form'?'selected':'';?>><?php _e('Form', 'lms');?></option><option value="quiz" <?php echo $forminator_frm_type == 'quiz'?'selected':'';?>><?php _e('Quiz', 'lms');?></option></select></p>

			<div id="forminator_form_settings">
				<p><?php _e('For this user must submit the form to mark this lesson completed', 'lms');?></p>
			</div>

			<div id="forminator_quiz_settings">
				<p><input type="number" name="forminator_quiz_minimum_percentage" value="<?php echo $forminator_quiz_minimum_percentage;?>"  placeholder="100"> <?php _e('Minimum % required to mark this lesson completed', 'lms');?></p>
			</div>
		</div>

		<script>
		lmsToggleView(jQuery('#enable_forminator'), 'forminator');
		forminatorTypeToggle(jQuery('#forminator_frm_type'));
		</script>
        
		<!-- forminator integration -->

		<!-- resources -->
		<strong><?php _e('Resources', 'lms');?></strong>
		<?php 
		$this->mapping_resource_js( $post->ID );
		
		$results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM ".$wpdb->prefix."lms_resource_mapping WHERE l_id = %d", $post->ID ), OBJECT );
		
		$lists = '';
		if(is_array($results)){
			foreach($results as $key => $value){
				if( $value->r_id == 0 ){
					$lists .= '<div class="resource-item resource-item-title"><strong>'.__('Title','lms').'</strong> <input type="hidden" name="resource_ids[]" value="'.$value->r_id.'"> <input type="hidden" name="resource_titles[]" value="'.stripslashes($value->r_title).'"> <input type="hidden" name="resource_hts[]" id="resource_ht_'.$value->m_id.'" value="'.$value->r_highlight.'"> ' . stripslashes($value->r_title) . ' ' . __('Highlight', 'lms') . ' <input type="checkbox" '.($value->r_highlight == 'yes'?'checked':'').' onclick="resourceHT(this)"> <a href="javascript:void(0)" onclick="removeResource(this)" class="lms-delete">'.LMS_DELETE_IMAGE.'</a></div>';	
				} else {
					$lists .= '<div class="resource-item"><strong>'.__('Resource','lms').'</strong> <input type="hidden" name="resource_ids[]" value="'.$value->r_id.'"> <input type="hidden" name="resource_titles[]" value="'.stripslashes($value->r_title).'"> <input type="hidden" name="resource_hts[]" value="'.$value->r_highlight.'"> '.get_the_title( $value->r_id ).' <a href="javascript:void(0)" onclick="removeResource(this)" class="lms-delete">'.LMS_DELETE_IMAGE.'</a></div>';
				}
			}
		}
		?>
    
        <div>
			<div style="float:right; margin-left:5px;"><a href="javascript:void(0)" id="add_resource" class="preview button"><?php _e('Add Resource','lms');?></a></div>
            <div style="float:right; margin-left:5px;"><a href="javascript:void(0)" id="add_resource_title" class="preview button"><?php _e('Add Resource Title','lms');?></a></div>
        </div>	
        
        <div id="resource_list" style="clear:both; width:100%; float:left; margin-top:5px;"><?php echo $lists;?></div>
        
        <div id="resource-title-assign-form" title="<?php _e('Assign Resource Title','lms');?>">
             <div class="lms-popup-form-inner">
                <p><?php _e('Add Title','lms');?> <input type="text" name="resource_title" id="resource_title" class="widefat" value="" placeholder="<?php _e('Enter resource title','lms');?>"></p>
             </div>
        </div>
        
        <div id="resource-assign-form" title="<?php _e('Assign Resource','lms');?>">
             <div class="lms-popup-form-inner">
             	<input type="hidden" name="resource_id" id="resource_id"> 
                <p><?php _e('Search Resource','lms');?> <input type="text" name="resource_search" id="resource_search" value="" class="widefat" placeholder="<?php _e('Search by resource title','lms');?>"></p>
                <div id="resource_search_result"></div>
				<div id="resource_selected"></div>
				
				<p>Or Add New Resource</p>

				<p><?php _e('Title','lms');?> <input type="text" name="link_title" id="link_title" class="widefat" value="" placeholder="<?php _e('Title','lms');?>"></p>

				<p><?php _e('Internal Title (Optional)','lms');?> <input type="text" name="link_internal_title" id="link_internal_title" class="widefat" value="" placeholder="<?php _e('Internal Title','lms');?>"></p>
		
				<p><?php _e('URL','lms');?> <input type="text" name="link_url" id="link_url" class="widefat" value="" placeholder="<?php _e('Enter URL','lms');?>"></p>

				<p><label><?php _e('Link Open in new Tab','lms');?> <input type="checkbox" name="link_open_in_new_tab" id="link_open_in_new_tab" value="yes" checked></label></p>

				<p><label><?php _e('Nofollow','lms');?> <input type="checkbox" name="link_nofollow" id="link_nofollow" value="yes"></label></p>

			 </div>
        </div>
		<!-- resources -->

        <div style="clear:both;"></div>
		<?php
	}
	
	public function get_resource_selected( $sel = '' ){
		$args = array(
			'post_type' => 'lms_resource',
			'posts_per_page' => -1,
		);
		
		$ret = '<option value="">-</option>';
		$query_data = get_posts( $args );
		if ( $query_data ) {
			foreach ( $query_data as $data ) {
				if( $data->ID == $sel ){
					$ret .= '<option value="'.$data->ID.'" selected="selected">'.$data->post_title.'</option>';
				}else {
					$ret .= '<option value="'.$data->ID.'">'.$data->post_title.'</option>';
				}
			}
		}
		wp_reset_postdata();
		return $ret;
	}

	// course name column //
	public function set_custom_lms_lesson_columns_for_course_name( $columns ) {
		$columns[ 'course' ] = __( 'Course', 'lms' );
		return $columns;
	}

	public function custom_lms_lesson_columns_for_course_name( $column, $post_id ) {
		switch ( $column ) {
			case 'course':
				$course_ids = lms_get_courses_which_has_this_lesson( $post_id );
				if($course_ids){
					echo get_the_title($course_ids[0]);
				} else {
					_e( '-', 'lms' );
				}
			break;
		}
	}
	// course name column //

	// section name column //
	public function set_custom_lms_lesson_columns_for_section_name( $columns ) {
		$columns[ 'section' ] = __( 'Section', 'lms' );
		return $columns;
	}

	public function custom_lms_lesson_columns_for_section_name( $column, $post_id ) {
		switch ( $column ) {
			case 'section':
				$section_name = lms_get_section_name_from_lesson_id($post_id);
				if($section_name){
					echo $section_name;
				} else {
					_e( '-', 'lms' );
				}
			break;
		}
	}
	// section name column //

}
