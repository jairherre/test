<?php

class class_course_data extends class_access_mgmt_data{
	
	public $course_complete_actions_array = array(
		'' 			=> 'Nothing',
		'rdtnc' 	=> 'Redirect to next course',
		'rdtp' 		=> 'Redirect to Page',
		'rdtu' 		=> 'Redirect to URL',
		'smipup' 	=> 'Display success message in a popup',
	);
	
	public $redirect_to_do_array = array(
		'display_course_page' 	=> 'Display Course Page',
		'redirect_to_page' 		=> 'Redirect to Page',
		'redirect_to_url' 		=> 'Redirect to URL',
	);

	public $user_status_array = array(
		'Active' 	=> 'Active',
		'Inactive' 	=> 'Inactive',
	);

	public function __construct(){
		parent::__construct();

		//add_action( 'add_meta_boxes_tg_course', array( $this, 'course_if_not_assigned' ), 3 );
		//add_action( 'add_meta_boxes_tg_course', array( $this, 'user_mapping' ), 4 );
		//add_action( 'add_meta_boxes_tg_course', array( $this, 'user_mapped' ), 4 );

		add_action( 'add_meta_boxes_tg_course', array( $this, 'course_options' ) );
		add_action( 'add_meta_boxes_tg_course', array( $this, 'course_builder' ) );

		add_filter( 'manage_tg_course_posts_columns', array( $this, 'set_custom_tg_course_columns' ) );
		add_action( 'manage_tg_course_posts_custom_column' , array( $this, 'custom_tg_course_columns' ), 10, 2 );
	}
	
	public function user_not_assigned_js( $post_id ){
	?>
    <script>
		function UserNotAssignedSelect( s ){
			if( s == 'redirect_to_page' ){
				jQuery('#redirect-to-page').show();
				jQuery('#redirect-to-url').hide();
			} else if( s == 'redirect_to_url' ){
				jQuery('#redirect-to-page').hide();
				jQuery('#redirect-to-url').show();
			} else {
				jQuery('#redirect-to-page').hide();
				jQuery('#redirect-to-url').hide();
			}
		}
	</script>
    <?php
	}

	public function course_complete_action_js( $post_id ){
	?>
    <script>
		function CourseCompleteSelect( s ){
			if( s == 'rdtp' ){
				jQuery('#cc-redirect-to-page').show();
				jQuery('#cc-redirect-to-url').hide();
				jQuery('#cc-display-popup').hide();
			} else if( s == 'rdtu' ){
				jQuery('#cc-redirect-to-url').show();
				jQuery('#cc-redirect-to-page').hide();
				jQuery('#cc-display-popup').hide();
			} else if( s == 'smipup' ) {
				jQuery('#cc-display-popup').show();
				jQuery('#cc-redirect-to-url').hide();
				jQuery('#cc-redirect-to-page').hide();
			} else{
				jQuery('#cc-display-popup').hide();
				jQuery('#cc-redirect-to-url').hide();
				jQuery('#cc-redirect-to-page').hide();
			}
		}
	</script>
    <?php
	}
	
	public function mapping_js( $post_id ){
	?>
    <script>
		jQuery( function() {
			var dialog;
			function assignLesson() {
			  var section_id = jQuery('#section_id').val();
			  var lesson_id = jQuery('#lesson_id').val();
			  var lesson_title = jQuery('#lesson_title').val();
			  var button =  jQuery(".ui-dialog-buttonpane button:contains('Assign Lesson')");
			  var loader = jQuery("#lesson-assign-form-loader");
			  jQuery.ajax({
				  method: "POST",
				  dataType:"json",
				  beforeSend: function(){
				  	button.attr("disabled", true);
					loader.show();
				  },
				  data: { option: 'assignLesson', c_id: <?php echo $post_id;?>, section_id: section_id, lesson_id: lesson_id, lesson_title: lesson_title }
			  })
			  .done(function( res ) {
				button.attr("disabled", false);
				loader.hide();
				if( res.status == 'true' ){
					jQuery('#lesson_title').val('');
					var is_section = jQuery('#sec-'+section_id ).length;
					if( is_section ) {
						jQuery(res.data).appendTo( jQuery('#sec-'+section_id ) );
						dialog.dialog( "close" );
					} else {
						jQuery(res.data).appendTo( jQuery('#sec-0' ) );
						dialog.dialog( "close" );
					}
					jQuery( ".date-field" ).datepicker({"dateFormat":"yy-mm-dd"});
				} else {
					alert(res.data);
				}
				return true;
			  });
			}
		 
			dialog = jQuery( "#lesson-assign-form" ).dialog({
			  autoOpen: false,
			  modal: true,
			  width: 500,
			  buttons: {
				"Assign Lesson": assignLesson,
				Cancel: function() {
				  jQuery('#lesson_id').val('');
				  jQuery("#lesson_selected").html('');
				  dialog.dialog( "close" );
				}
			  }
			});
		 
			jQuery( "#add_lesson" ).on( "click", function() {
			  dialog.dialog( "open" );
			});
			
			jQuery("#lesson_search").keyup(function(){
				jQuery.ajax({
				type: "POST",
				data: { option: 'LessonSearch', lesson_search: jQuery('#lesson_search').val() },
				beforeSend: function(){
					jQuery("#lesson_search").css( "background", "#FFF url(<?php echo plugins_url( TG_DIR_NAME . '/images/input_loader.gif' )?>) no-repeat scroll right" );
				},
				success: function(data){
					jQuery("#lesson_search_result").show();
					jQuery("#lesson_search_result").html(data);
					jQuery("#lesson_search").css( "background", "#FFF" );
				}
				});
			});
		});
	
		function lessonSelectionFromSearch( l_id, l_title ){
			jQuery('#lesson_id').val( l_id );
			jQuery('#lesson_selected').html( 'Selected Lesson : ' + l_title );
			jQuery('#lesson_search').val('');
			jQuery('#lesson_search_result').html('');
			jQuery('#lesson_search_result').hide();
		}
	
		jQuery( function() {
			var dialog;
			var scntDiv = jQuery('#lesson_list');
			function assignSection() {
			  var section_name = jQuery('#section_name').val();
			  var old_section_id = jQuery('#old_section_id').val();
			  var button =  jQuery(".ui-dialog-buttonpane button:contains('Assign Section')");
			  var loader = jQuery("#section-assign-form-loader");

			  jQuery.ajax({
				  method: "POST",
				  dataType:"json",
				  beforeSend: function(){
				  	button.attr("disabled", true);
					loader.show();
				  },
				  data: { option: 'assignSection', c_id: <?php echo $post_id;?>, section_name: section_name, old_section_id: old_section_id  }
			  })
			  .done(function( res ) {
				button.attr("disabled", false);
				loader.hide();
				if( res.status == 'true' ){
					var is_section = jQuery('#sec-'+old_section_id ).length;
					if(is_section){
						alert( '<?php _e('Section already exists!', 'teachground');?>' );
					} else {
						jQuery(res.data).appendTo(scntDiv);
						jQuery('#lesson-assign-form').html(res.form_update);
						jQuery('#section_name').val('');
						dialog.dialog( "close" );
						jQuery("#lesson_search").keyup(function(){
						jQuery.ajax({
						type: "POST",
						data: { option: 'LessonSearch', lesson_search: jQuery('#lesson_search').val() },
						beforeSend: function(){
							jQuery("#lesson_search").css( "background", "#FFF url(<?php echo plugins_url( TG_DIR_NAME . '/images/input_loader.gif' )?>) no-repeat scroll right" );
						},
						success: function(data){
							jQuery("#lesson_search_result").show();
							jQuery("#lesson_search_result").html(data);
							jQuery("#lesson_search").css( "background", "#FFF" );
						}
						});
					});
					}
				} else {
					alert(res.data);
				}
				return true;
			  });
			}
		 
			dialog = jQuery( "#section-assign-form" ).dialog({
			  autoOpen: false,
			  modal: true,
			  buttons: {
				"Assign Section": assignSection,
				Cancel: function() {
				  dialog.dialog( "close" );
				}
			  }
			});
		 
			jQuery( "#add_section" ).on( "click", function() {
			  dialog.dialog( "open" );
			});
		});
	
		function removeLesson( rm ){
			jQuery(rm).parent().remove();
		}
	
		function removeSection( rm, s_id ){
			jQuery.ajax({
				method: "POST",
				data: { option: 'removeSection', s_id: s_id }
			})
			.done(function( data ) {
				if( data == 'removed' ){
					jQuery(rm).parent().remove();
				}
			});
		}

		function delayOptionToggle(l_id){
			var rb = jQuery('input[name="lesson_delay_type_'+l_id+'"]:checked').val();
			if(rb == 'days'){
				jQuery('#days_delay_'+l_id).show();
				jQuery('#date_delay_'+l_id).hide();
			} else{
				jQuery('#days_delay_'+l_id).hide();
				jQuery('#date_delay_'+l_id).show();
			}
		}

		jQuery( function() {
			jQuery( ".date-field" ).datepicker({"dateFormat":"yy-mm-dd"});
		});
		
	</script>
    <?php
	}
	
	public function rules_js( $post_id ){
	?>
    <script>
		jQuery( function() {
			var dialog;
			function assignRule() {
			  var first_lesson_id = jQuery('#first_lesson_id').val();
			  var second_lesson_id = jQuery('#second_lesson_id').val();
			  var button =  jQuery(".ui-dialog-buttonpane button:contains('Assign Rule')");
			  var loader = jQuery("#rules-assign-form-loader");

			  jQuery.ajax({
				  method: "POST",
				  dataType:"json",
				  beforeSend: function(){
				  	button.attr("disabled", true);
					loader.show();
				  },
				  data: { option: 'assignRule', c_id: <?php echo $post_id;?>, first_lesson_id: first_lesson_id, second_lesson_id: second_lesson_id }
			  })
			  .done(function( res ) {
				button.attr("disabled", false);
				loader.hide();
				if( res.status == 'true' ){
					jQuery(res.data).appendTo( jQuery('#rules_list' ) );
					dialog.dialog( "close" );
				} else {
					alert(res.data);
				}
				return true;
			  });
			}
		 
			dialog = jQuery( "#rules-assign-form" ).dialog({
			  autoOpen: false,
			  modal: true,
			  width: 500,
			  buttons: {
				"Assign Rule": assignRule,
				Cancel: function() {
				  dialog.dialog( "close" );
				}
			  }
			});
		 
			jQuery( "#add_rules" ).on( "click", function() {
			  dialog.dialog( "open" );
			});
			
		});
		
		function removeRule( rm, r_id ){
			jQuery.ajax({
				  method: "POST",
				  data: { option: 'removeRule', r_id: r_id }
			  })
			  .done(function( data ) {
				if( data == 'removed' ){
					jQuery(rm).parent().remove();
				}
			  });
		}
	
	</script>
    <?php
	}
	
	public function mapping_js_user( $post_id ){
	?>
    <script>		
	jQuery( function() {
		var dialog;
		var scntDiv = jQuery('#user_list');
		function assignUser() {
		  var user_id = jQuery('#user_id').val();
		  var status = jQuery('#user_status').val();
		  var button =  jQuery(".ui-dialog-buttonpane button:contains('Assign User')");
		  var loader = jQuery("#user-assign-form-loader");

		  jQuery.ajax({
			  method: "POST",
			  dataType:"json",
			  beforeSend: function(){
				button.attr("disabled", true);
				loader.show();
			  },
			  data: { option: 'AssignUser', c_id: <?php echo $post_id;?>, user_id: user_id, status: status }
		  })
		  .done(function( res ) {
			button.attr("disabled", false);
			loader.hide();
			if( res.status == 'true' ){
				jQuery(res.data).prependTo(scntDiv);
				dialog.dialog( "close" );
			} else {
				alert(res.data);
			}
			return true;
		  });
		}
	 
		dialog = jQuery( "#user-assign-form" ).dialog({
		  autoOpen: false,
		  modal: true,
		  buttons: {
			"Assign User": assignUser,
			Cancel: function() {
			  dialog.dialog( "close" );
			}
		  }
		});
	 
		jQuery( "#add_user" ).on( "click", function() {
		  dialog.dialog( "open" );
		});
		
		jQuery("#user_search").keyup(function(){
			jQuery.ajax({
			type: "POST",
			data: { option: 'UserSearch', user_search: jQuery('#user_search').val() },
			beforeSend: function(){
				jQuery("#user_search").css( "background", "#FFF url(<?php echo plugins_url( TG_DIR_NAME . '/images/input_loader.gif' )?>) no-repeat scroll right" );
			},
			success: function(data){
				jQuery("#user_search_result").show();
				jQuery("#user_search_result").html(data);
				jQuery("#user_search").css( "background", "#FFF" );
			}
			});
		});
	
	});
	
	function userSelectionFromSearch( u_id, u_email ){
		jQuery('#user_id').val( u_id );
		jQuery('#user_selected').html( 'Selected User : ' + u_email );
		jQuery('#user_search').val('');
		jQuery('#user_search_result').html('');
		jQuery('#user_search_result').hide();
	}
		
	function removeAssignedUser( m_id ){
		jQuery.ajax({
			  method: "POST",
			  data: { option: 'removeAssignedUser', m_id: m_id }
		  })
		  .done(function( data ) {
			if( data == 'removed' ){
				jQuery('#ua-'+m_id).remove();
			}
		  });
	}
	
	</script>
    <?php
	}
	
	public function course_options( $post ) {
		add_meta_box(
			'course_options',
			__( 'Course Options', 'teachground' ),
			array( $this, 'course_options_callback' ), $post->post_type, 'advanced' 
		);
	}
	
	public function course_options_callback( $post ) {
		global $wpdb;

		wp_nonce_field( 'attachment_meta_box', 'attachment_meta_box_nonce' );
		?>

		<!-- course options -->

		<p><label><input type="checkbox" name="course_is_free" value="Yes" <?php echo get_post_meta($post->ID, 'course_is_free', true) == 'Yes'?'checked':'';?>> <strong><?php _e('Set course to free', 'teachground');?></strong> </label> <a title="<?php _e('Activate this option if you want to make this course available for free (no login required).', 'teachground');?>" href="javascript:void()"><?php echo TG_TOOLTIP_INFO_IMAGE;?></a><br>
		
		<p><label><input type="checkbox" name="disable_course_progress" value="Yes" <?php echo get_post_meta($post->ID, 'disable_course_progress', true) == 'Yes'?'checked':'';?>> <strong><?php _e('Disable progress tracking', 'teachground');?></strong> </label> <a title="<?php _e('If this option is activated, course progress will not be tracked for the students, and eventual &quot;course rules/prerequisits&quot; will not work.', 'teachground');?>" href="javascript:void()"><?php echo TG_TOOLTIP_INFO_IMAGE;?></a><br>
		
		<!-- course options -->

		<!-- lesson start rules -->

		<?php
		$this->rules_js( $post->ID );
		
		$results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM ".$wpdb->prefix."tg_lesson_start_rules WHERE c_id = %d", $post->ID ), OBJECT );
		
		$rules = '';
		if(is_array($results)){
			foreach($results as $key => $value){
				$rules .= '<div class="rule-item"><strong>'.get_the_title($value->f_l_id).'</strong> '.__('must be completed before', 'teachground').' <strong>'.get_the_title($value->s_l_id).'</strong> '.__('can be started','teachground').' <a href="javascript:void(0)" onclick="removeRule(this, '.$value->r_id.')" class="tg-delete">'.TG_DELETE_IMAGE.'</a></div>';
			}
		}
		?>
        <div style="clear:both; width:100%; float:left; margin-top:5px;">
        <p><label><input type="checkbox" name="lesson_one_by_one" value="Yes" <?php echo get_post_meta($post->ID, 'lesson_one_by_one', true) == 'Yes'?'checked':'';?>> <strong><?php _e('Make lessons available one by one', 'teachground');?></strong> </label> <a title="<?php _e('If this option is activated, students must mark complete each lesson before moving to the next one. (rules set below will not work in this case)', 'teachground');?>" href="javascript:void()"><?php echo TG_TOOLTIP_INFO_IMAGE;?></a> <br>
        </div>
        
        <div>
			<div style="float:right; margin-left:5px;"><a href="javascript:void(0)" id="add_rules" class="preview button"><?php _e('Add Rules','teachground');?></a></div>
        </div>	
        
        <div id="rules_list" style="clear:both; width:100%; float:left; margin-top:5px;"><?php echo $rules;?></div>
        
        <div id="rules-assign-form" title="<?php _e('Assign Rules','teachground');?>">
             <div class="tg-popup-form-inner">
             	<p><select name="first_lesson_id" id="first_lesson_id" class="widefat">
                	<?php echo $this->get_lesson_selected_from_course( '', $post->ID);?>
                </select></p>
                <p> <?php _e('Must be completed before starting');?> </p>
                <p><select name="second_lesson_id" id="second_lesson_id" class="widefat">
                	<?php echo $this->get_lesson_selected_from_course( '', $post->ID);?>
                </select></p>
                <div class="tg-loader" id="rules-assign-form-loader"></div>
             </div>
        </div>

		<!-- lesson start rules -->

		<!-- video settings -->

		<p><label><input type="checkbox" name="watching_video_mandatory" id="watching_video_mandatory" value="Yes" <?php echo get_post_meta($post->ID, 'watching_video_mandatory', true) == 'Yes'?'checked':'';?> onclick="tgToggleView(this,'watching_video_mandatory')"> <strong><?php _e('Make watching lessons mandatory', 'teachground');?></strong></label> <a title="<?php _e('If this option is activated, students must watch a minimum % of each video to be able to mark lesson as completed.', 'teachground');?>" href="javascript:void()"><?php echo TG_TOOLTIP_INFO_IMAGE;?></a> </p>

		<div id="watching_video_mandatory_settings" style="<?php echo get_post_meta($post->ID, 'watching_video_mandatory', true) == 'Yes'?'display:block;':'display:none;';?>">
			<?php
			/*if(get_post_meta( $post->ID, 'video_width', true )){
				$video_width = (int)get_post_meta( $post->ID, 'video_width', true );
			} else {
				$video_width = TG_DEFAULT_VIDEO_WIDTH;
			}
			if(get_post_meta( $post->ID, 'video_height', true )){
				$video_height = (int)get_post_meta( $post->ID, 'video_height', true );
			} else {
				$video_height = TG_DEFAULT_VIDEO_HEIGHT;
			}*/
			$video_minimum_percentage = (int)get_post_meta( $post->ID, 'video_minimum_percentage', true );
			?>
			
			<?php /*?><strong><?php _e('Video Width', 'teachground');?></strong>
			<p><input type="text" name="video_width" value="<?php echo $video_width;?>" class="widefat"></p>
			
			<strong><?php _e('Vimeo Height', 'teachground');?></strong>
			<p><input type="text" name="video_height" value="<?php echo $video_height;?>" class="widefat"></p><?php */?>
			
			<p><input type="number" name="video_minimum_percentage" value="<?php echo $video_minimum_percentage;?>" placeholder="100"> <?php _e('Minimum % of video required to view to mark lesson as completed', 'teachground');?></p>
		</div>

		<!-- video settings -->

		<!-- course complete actions -->

		<p><label><input type="checkbox" name="action_after_course_complete" id="action_after_course_complete" value="Yes" <?php echo get_post_meta($post->ID, 'action_after_course_complete', true) == 'Yes'?'checked':'';?> onclick="tgToggleView(this,'action_after_course_complete')"> <strong><?php _e('Add action after course completion', 'teachground');?></strong></label> <a title="<?php _e('Activate this option to define what happens when a student finishes this course.', 'teachground');?>" href="javascript:void()"><?php echo TG_TOOLTIP_INFO_IMAGE;?></a></p>

		<div id="action_after_course_complete_settings" style="<?php echo get_post_meta($post->ID, 'action_after_course_complete', true) == 'Yes'?'display:block;':'display:none;';?>">
		<?php
		$course_complete_action = get_post_meta( $post->ID, 'course_complete_action', true );
		$cc_redirect_to_page_id = get_post_meta( $post->ID, 'cc_redirect_to_page_id', true );
		$cc_redirect_to_page_url = get_post_meta( $post->ID, 'cc_redirect_to_page_url', true );
		$cc_popup_message = get_post_meta( $post->ID, 'cc_popup_message', true );

		$this->course_complete_action_js($post->ID);
		?>
		<p>
		<select name="course_complete_action" class="widefat" onChange="CourseCompleteSelect(this.value)">
			<?php echo $this->get_course_complete_action_selected($course_complete_action);?>
		</select>
		</p>

		<div id="cc-redirect-to-page">
        	<p>
            	<?php
					$args = array(
					'depth'            => 0,
					'selected'         => $cc_redirect_to_page_id,
					'echo'             => 1,
					'show_option_none' => '-',
					'class'			   => 'widefat',
					'id' 			   => 'cc_redirect_to_page_id',
					'name'             => 'cc_redirect_to_page_id'
					);
					wp_dropdown_pages( $args ); 
				?>
            </p>        	
        </div>
        
        <div id="cc-redirect-to-url">
        	<p>
            	<input type="text" name="cc_redirect_to_page_url" class="widefat" value="<?php echo $cc_redirect_to_page_url;?>" placeholder="<?php _e('Enter URL');?>">
            </p>        	
		</div>
		
		<div id="cc-display-popup">
        	<p>
				<textarea name="cc_popup_message" class="widefat" placeholder="<?php _e('Enter popup message');?>"><?php echo $cc_popup_message;?></textarea>
            </p>        	
        </div>
        
        <div style="clear:both;"></div>
		<script>CourseCompleteSelect('<?php echo $course_complete_action;?>');</script>
		</div>

		<!-- course complete actions -->

		<div style="clear:both;"></div>
        <?php
	}

	public function course_builder( $post ) {
		add_meta_box(
			'course_builder',
			__( 'Course Builder', 'teachground' ),
			array( $this, 'course_builder_callback' ), $post->post_type, 'advanced' 
		);
	}
	
	public function course_builder_callback( $post ) {
		global $wpdb;
		wp_nonce_field( 'attachment_meta_box', 'attachment_meta_box_nonce' );
		?>

		<!-- course builder -->
		<?php
		$this->mapping_js( $post->ID );
		$list_data = $this->get_lesson_mapping_lists($post->ID);
		$sec_ids = $list_data[1];
		?>
    
        <div>
			<div style="float:right; margin-left:5px;"><a href="javascript:void(0)" id="add_lesson" class="preview button"><?php _e('Add Lesson','teachground');?></a></div>
            <div><a href="javascript:void(0)" id="add_section" class="preview button"><?php _e('Add Section','teachground');?></a></div>
        </div>	
        
        <div id="lesson_list" style="clear:both; width:100%; float:left; margin-top:5px;"><?php echo $list_data[0];?></div>
         
        <div id="section-assign-form" title="<?php _e('Assign Section','teachground');?>">
             <div class="tg-popup-form-inner">
                <p><?php _e('Add New Section','teachground');?> <input type="text" name="section_name" id="section_name" class="widefat" value="" placeholder="<?php _e('Enter section name','teachground');?>"></p>
                <p><?php _e('Select From Old','teachground');?> <select name="old_section_id" id="old_section_id" class="widefat"><?php echo $this->get_section_selected('',$post->ID,true);?></select></p>
                <div class="tg-loader" id="section-assign-form-loader"></div>
             </div>
        </div>
        
        <div id="lesson-assign-form" title="<?php _e('Assign Lesson','teachground');?>">
             <div class="tg-popup-form-inner">
             	<input type="hidden" name="lesson_id" id="lesson_id"> 
                <p><?php _e('Section','teachground');?> <select name="section_id" id="section_id" class="widefat" required><?php echo $this->get_section_selected('',$post->ID,true);?></select></p>
                <p><?php _e('Add New Lesson','teachground');?> <input type="text" name="lesson_title" id="lesson_title" class="widefat" value="" placeholder="<?php _e('Enter lesson title','teachground');?>"></p>
                <p><?php _e('Search From Old Lessons','teachground');?> <input type="text" name="lesson_search" id="lesson_search" value="" class="widefat" placeholder="<?php _e('Search by lesson title','teachground');?>"></p>
                <div id="lesson_search_result"></div>
                <div id="lesson_selected"></div>
                <div class="tg-loader" id="lesson-assign-form-loader"></div>
             </div>
        </div>
        <script>
		jQuery(function() {
			<?php
			if( is_array( $sec_ids ) ){
				foreach( $sec_ids as $value ){
					?>
					jQuery("#sec-<?php echo $value;?>").sortable({
						connectWith: ".sec", 
						receive: function( event, ui ) {
							var receive_s_id = jQuery(this).attr('data-id');
							var dropped_l_id = ui.item.attr('data-id');
							jQuery('#lesson_ids_'+dropped_l_id).attr('name','lesson_ids_'+receive_s_id+'[]');
						}
					});
					<?php
				}
			}
			?>
        });
        </script>
		<!-- course builder -->

		<div style="clear:both;"></div>
        <?php
	}


	public function get_lesson_mapping_lists( $post_id ){
		global $wpdb;

		$sec_ids = array();
		$lists = '';
		
		$lists .= '<div class="no-section-item unsortable"><input type="hidden" name="section_ids[]" value="0"><div id="sec-0" class="sec" data-id="0">';

		// no section
		$results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM ".$wpdb->prefix."tg_lesson_mapping WHERE c_id = %d AND s_id = %d AND m_type = %s ORDER BY m_order", $post_id, 0, 'lesson' ), OBJECT );
		if(is_array($results)){
			$sec_ids[] = 0;
			foreach($results as $key => $value){
				$lists .= '<div class="lesson-item" data-id="'.$value->l_id.'">';
				$lists .= '<strong>'.__('Lesson','teachground').'</strong>';
				$lists .= ' ';
				$lists .= '<input type="hidden" name="lesson_ids_0[]" id="lesson_ids_'.$value->l_id.'" value="'.$value->l_id.'">';
				$lists .= get_the_title( $value->l_id );
				$lists .= ' ';
				$lists .= '<strong>'.__('Delay by','teachground').'</strong>';
				$lists .= ' ';
				$lists .= __('Days','teachground').' <input name="lesson_delay_type_'.$value->l_id.'" type="radio" value="days" onclick="delayOptionToggle('.$value->l_id.')" '.($value->l_delay_type == 'days'?'checked':'').'>';
				$lists .= __('Date','teachground').' <input name="lesson_delay_type_'.$value->l_id.'" onclick="delayOptionToggle('.$value->l_id.')" type="radio" value="date" '.($value->l_delay_type == 'date'?'checked':'').'>';
				$lists .= '<span id="days_delay_'.$value->l_id.'"><input type="number" min="0" name="lesson_delay_'.$value->l_id.'" value="'.$value->l_delay.'" size="2"></span>';
				$lists .= '<span id="date_delay_'.$value->l_id.'"><input type="text" name="lesson_delay_date_'.$value->l_id.'" class="date-field" value="'.$value->l_delay_date.'" size="10"></span>';
				$lists .= ' ';
				$lists .= '<strong>'.__('Set lesson to free','teachground').'</strong>';
				$lists .= ' ';
				$lists .= '<input type="checkbox" name="lesson_free_'.$value->l_id.'" value="Yes" '.($value->l_free == 'Yes'?'checked':'').'>';
				$lists .= ' ';
				$lists .= '<a href="post.php?post='.$value->l_id.'&action=edit" target="_blank" class="tg-edit">'.TG_EDIT_IMAGE.'</a>';
				$lists .= ' ';
				$lists .= '<a href="javascript:void(0)" onclick="removeLesson(this)" class="tg-delete">'.TG_DELETE_IMAGE.'</a>';
				$lists .= '<script>delayOptionToggle('.$value->l_id.')</script>';
				$lists .= '</div>';
			}
		}
		$lists .= '</div></div>';
		// no section

		// with section
		$results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM ".$wpdb->prefix."tg_lesson_mapping WHERE c_id = %d AND m_type = %s AND s_id <> %d ORDER BY m_order", $post_id, 'section', 0 ), OBJECT );
		
		if(is_array($results)){
			foreach($results as $key => $value){
				$sec_ids[] = $value->s_id;
				$lists .= '<div class="section-item"><strong>#'.$value->s_id.' '.__('Section Name','teachground').'</strong> <input type="text" name="section_name_'.$value->s_id.'" value="'.tg_get_section_name($value->s_id).'"><input type="hidden" name="section_ids[]" value="'.$value->s_id.'"> <a href="javascript:void(0)" onclick="removeSection(this, '.$value->s_id.')" class="tg-delete">'.TG_DELETE_IMAGE.'</a><div id="sec-'.$value->s_id.'" class="sec" data-id="'.$value->s_id.'">';
				
				$results1 = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM ".$wpdb->prefix."tg_lesson_mapping WHERE s_id = %d AND m_type = %s ORDER BY m_order", $value->s_id, 'lesson' ), OBJECT );
				if(is_array($results1)){
					foreach($results1 as $key1 => $value1){
						$lists .= '<div class="lesson-item" data-id="'.$value1->l_id.'">';
						$lists .= '<strong>'.__('Lesson','teachground').'</strong>';
						$lists .= ' ';
						$lists .= '<input type="hidden" name="lesson_ids_'.$value->s_id.'[]" id="lesson_ids_'.$value1->l_id.'" value="'.$value1->l_id.'">';
						$lists .= get_the_title( $value1->l_id );
						$lists .= ' ';
						$lists .= '<strong>'.__('Delay by','teachground').'</strong>';
						$lists .= ' ';
						$lists .= __('Days','teachground').' <input name="lesson_delay_type_'.$value1->l_id.'" type="radio" value="days" onclick="delayOptionToggle('.$value1->l_id.')" '.($value1->l_delay_type == 'days'?'checked':'').'>';
						$lists .= __('Date','teachground').' <input name="lesson_delay_type_'.$value1->l_id.'" onclick="delayOptionToggle('.$value1->l_id.')" type="radio" value="date" '.($value1->l_delay_type == 'date'?'checked':'').'>';
						$lists .= '<span id="days_delay_'.$value1->l_id.'"><input type="number" min="0" name="lesson_delay_'.$value1->l_id.'" value="'.$value1->l_delay.'" size="2"></span>';
						$lists .= '<span id="date_delay_'.$value1->l_id.'"><input type="text" name="lesson_delay_date_'.$value1->l_id.'" class="date-field" value="'.$value1->l_delay_date.'" size="10"></span>';
						$lists .= ' ';
						$lists .= '<strong>'.__('Set lesson to free','teachground').'</strong>';
						$lists .= ' ';
						$lists .= '<input type="checkbox" name="lesson_free_'.$value1->l_id.'" value="Yes" '.($value1->l_free == 'Yes'?'checked':'').'>';
						$lists .= ' ';
						$lists .= '<a href="post.php?post='.$value1->l_id.'&action=edit" target="_blank" class="tg-edit">'.TG_EDIT_IMAGE.'</a>';
						$lists .= ' ';
						$lists .= '<a href="javascript:void(0)" onclick="removeLesson(this)" class="tg-delete">'.TG_DELETE_IMAGE.'</a>';
						$lists .= '<script>delayOptionToggle('.$value1->l_id.')</script>';
						$lists .= '</div>';
					}
				}
				$lists .= '</div></div>';
			}
		}
		// with section

		return array($lists,$sec_ids);
	}
	
	public function user_mapping( $post ) {
		add_meta_box(
			'user_mapping',
			__( 'User Mapping', 'teachground' ),
			array( $this, 'user_mapping_callback' ), $post->post_type, 'advanced' 
		);
	}
	
	public function user_mapping_callback( $post ) {
		global $wpdb;
		wp_nonce_field( 'attachment_meta_box', 'attachment_meta_box_nonce' );
		$this->mapping_js_user( $post->ID );
		
		$results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM ".$wpdb->prefix."tg_user_mapping WHERE c_id = %d ORDER BY added_on DESC", $post->ID ), OBJECT );
		
		$lists = '';
		if(is_array($results)){
			foreach($results as $key => $value){
				$user_info = get_userdata( $value->user_id );
				$lists .= '<div class="user-item" id="ua-'.$value->m_id.'"><strong>'.__('User','teachground').'</strong> '.$user_info->user_email.' <input type="hidden" name="user_ids[]" value="'.$value->user_id.'"> <strong>'.__('Status','teachground').'</strong> <select name="user_statuses[]">'.$this->get_user_status_selected( $value->m_status ).'</select><input type="hidden" name="m_ids[]" value="'.$value->m_id.'"> <strong>'.__('Added On','teachground').'</strong> ' . tg_date_format( $value->added_on, 'jS M, Y \a\t g:i a' ) . ' <a href="javascript:removeAssignedUser('.$value->m_id.')" class="tg-delete">'.TG_DELETE_IMAGE.'</a></div>';
			}
		}
		?>
    
        <div>
			<div><a href="javascript:void(0)" id="add_user" class="preview button"><?php _e('Enroll User','teachground');?></a></div>	
		</div>
        
        <div id="user_list" style="clear:both; width:100%; float:left; margin-top:5px;"><?php echo $lists;?></div>
        
        <div id="user-assign-form" title="<?php _e('Assign User','teachground');?>">
             <div class="tg-popup-form-inner">
                <input type="hidden" name="user_id" id="user_id">
                <p><?php _e('Search User','teachground');?> <input type="text" name="user_search" id="user_search" value="" class="widefat" placeholder="<?php _e('Search by name / email','teachground');?>"></p>
             	<p><?php _e('Status','teachground');?> <select name="user_status" id="user_status" class="widefat"><?php echo $this->get_user_status_selected();?></select></p>
                <div id="user_search_result"></div>
                <div id="user_selected"></div>
                <div class="tg-loader" id="user-assign-form-loader"></div>
             </div>
        </div>
        
        <div style="clear:both;"></div>
        <?php
	}
	
	public function user_mapped( $post ) {
		add_meta_box(
			'user_mapped',
			__( 'Mapped Users', 'teachground' ),
			array( $this, 'user_mapped_callback' ), $post->post_type, 'advanced' 
		);
	}
	
	public function user_mapped_callback( $post ) {
		global $wpdb;
		wp_nonce_field( 'attachment_meta_box', 'attachment_meta_box_nonce' );
		
		$results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM ".$wpdb->prefix."tg_user_mapping WHERE c_id = %d ORDER BY added_on DESC", $post->ID ), OBJECT );
		
		$lists = '';
		if(is_array($results)){
			foreach($results as $key => $value){
				$user_info = get_userdata( $value->user_id );
				$lists .= '<div class="user-item"><strong>'.__('User','teachground').'</strong> '.$user_info->user_email.' <strong>'.__('Status','teachground').'</strong> '.$value->m_status.' <strong>'.__('Added On','teachground').'</strong> ' . tg_date_format( $value->added_on, 'jS M, Y \a\t g:i a' ) . '</div>';
			}
		}
		?>
        <div id="user_list" style="clear:both; width:100%; float:left; margin-top:5px;"><?php echo $lists;?></div>
        <div style="clear:both;"></div>
        <?php
	}
	
	public function course_if_not_assigned( $post ) {
		add_meta_box(
			'course_if_not_assigned',
			__( 'If User not Assigned', 'teachground' ),
			array( $this, 'course_if_not_assigned_callback' ), $post->post_type, 'side' 
		);
	}
	
	public function course_if_not_assigned_callback( $post ) {
		global $wpdb;
		wp_nonce_field( 'attachment_meta_box', 'attachment_meta_box_nonce' );
		$user_not_assigned_to_do = get_post_meta($post->ID, 'user_not_assigned_to_do', true );
		$redirect_to_page_id = get_post_meta($post->ID, 'redirect_to_page_id', true );
		$redirect_to_page_url = get_post_meta($post->ID, 'redirect_to_page_url', true );
		$this->user_not_assigned_js( $post->ID );
		?>
    	<select name="user_not_assigned_to_do" class="widefat" onChange="UserNotAssignedSelect(this.value)">
        	<?php echo $this->get_redirect_to_do_selected( $user_not_assigned_to_do );?>
        </select>
        
        <div id="redirect-to-page">
        	<p>
            	<?php
					$args = array(
					'depth'            => 0,
					'selected'         => $redirect_to_page_id,
					'echo'             => 1,
					'show_option_none' => '-',
					'class'			   => 'widefat',
					'id' 			   => 'redirect_to_page_id',
					'name'             => 'redirect_to_page_id'
					);
					wp_dropdown_pages( $args ); 
				?>
            </p>        	
        </div>
        
        <div id="redirect-to-url">
        	<p>
            	<input type="text" name="redirect_to_page_url" class="widefat" value="<?php echo $redirect_to_page_url;?>" placeholder="<?php _e('Enter URL');?>">
            </p>        	
        </div>
        
        <div style="clear:both;"></div>
        <script>UserNotAssignedSelect('<?php echo $user_not_assigned_to_do;?>');</script>
        <?php
	}

	public function get_course_complete_action_selected( $sel = '' ){
		$query_data = $this->course_complete_actions_array;
		$ret = '';
		if ( is_array( $query_data ) ) {
			foreach ( $query_data as $key => $value ) {
				if( $key == $sel ){
					$ret .= '<option value="'.$key.'" selected="selected">'.__($value,'teachground').'</option>';
				}else {
					$ret .= '<option value="'.$key.'">'.__($value,'teachground').'</option>';
				}
			}
		}
		return $ret;
	}
	
	public function get_redirect_to_do_selected( $sel = '' ){
		$ret = '';
		$query_data = $this->redirect_to_do_array;
		if ( is_array( $query_data ) ) {
			foreach ( $query_data as $key => $value ) {
				if( $key == $sel ){
					$ret .= '<option value="'.$key.'" selected="selected">'.__($value,'teachground').'</option>';
				}else {
					$ret .= '<option value="'.$key.'">'.__($value,'teachground').'</option>';
				}
			}
		}
		return $ret;
	}
	
	public function get_lesson_selected( $sel = '' ){
		$ret = '';
		$args = array(
			'post_type' => 'tg_lesson',
			'posts_per_page' => -1
		);
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
	
	public function get_lesson_selected_from_course( $sel = '', $c_id = '' ){
		global $wpdb;
		$l_ids = [];
		$results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM ".$wpdb->prefix."tg_lesson_mapping WHERE c_id = %d AND m_type = %s ORDER BY m_order", $c_id, 'lesson' ), OBJECT );
		if(is_array($results)){
			foreach($results as $key => $value){
				$l_ids[] = $value->l_id;
			}
		}
		
		$ret = '';
		$args = array(
			'post_type' => 'tg_lesson',
			'posts_per_page' => -1,
			'orderby' => 'post__in', 
			'post__in' => $l_ids
		);
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
	
	public function get_user_selected( $sel = '' ){
		$ret = '';
		$query_data = get_users();
		if ( $query_data ) {
			foreach ( $query_data as $data ) {
				if( $data->ID == $sel ){
					$ret .= '<option value="'.$data->ID.'" selected="selected">'.$data->user_email.'</option>';
				}else {
					$ret .= '<option value="'.$data->ID.'">'.$data->user_email.'</option>';
				}
			}
		}
		return $ret;
	}
	
	public function get_user_status_selected( $sel = '' ){
		$ret = '';
		$query_data = $this->user_status_array;
		if ( is_array( $query_data ) ) {
			foreach ( $query_data as $key => $value ) {
				if( $key == $sel ){
					$ret .= '<option value="'.$key.'" selected="selected">'.__($value,'teachground').'</option>';
				}else {
					$ret .= '<option value="'.$key.'">'.__($value,'teachground').'</option>';
				}
			}
		}
		return $ret;
	}
	
	public static function get_section_selected( $sel = '', $c_id = '', $add_empty = false ){
		global $wpdb;
		$ret = '';
		if( $add_empty ){
			$ret .= '<option value="">-</option>';
		}
		$results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM ".$wpdb->prefix."tg_section WHERE c_id = %d", $c_id ), OBJECT );
		if(is_array($results)){
			foreach($results as $key => $value){
				if( $value->s_id == $sel ){
					$ret .= '<option value="'.$value->s_id.'" selected="selected">'.tg_removeslashes($value->s_name).'</option>';
				}else {
					$ret .= '<option value="'.$value->s_id.'">'.tg_removeslashes($value->s_name).'</option>';
				}
			}
		}
		return $ret;
	}
	
	// order column //
	public function set_custom_tg_course_columns($columns) {
		$columns['order'] = __( 'Order', 'teachground' );
		return $columns;
	}
	
	public function custom_tg_course_columns( $column, $post_id ) {
		switch ( $column ) {
			case 'order' :
				echo get_post_field( 'menu_order', $post_id );
			break;
		}
	}
	// order column //
	
}
