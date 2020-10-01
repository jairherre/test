<?php

class class_access_mgmt_data {

	public function __construct() {
		add_action( 'add_meta_boxes_tg_access_mgmt', array( $this, 'access_internal_name' ), 1 );
		add_action( 'add_meta_boxes_tg_access_mgmt', array( $this, 'course_mapping' ), 2 );
		add_action( 'add_meta_boxes_tg_access_mgmt', array( $this, 'post_mapping' ), 3 );
		add_action( 'add_meta_boxes_tg_access_mgmt', array( $this, 'email_settings' ), 4 );
		add_action( 'add_meta_boxes_tg_access_mgmt', array( $this, 'am_user_mapping' ), 5 );
		add_action( 'add_meta_boxes_tg_access_mgmt', array( $this, 'pg_integration_info' ), 6 );

		add_filter( 'manage_tg_access_mgmt_posts_columns', array( $this, 'set_custom_tg_access_columns_for_course_list' ) );
		add_action( 'manage_tg_access_mgmt_posts_custom_column', array( $this, 'custom_tg_access_columns_for_course_list' ), 10, 2 );

		add_filter( 'manage_tg_access_mgmt_posts_columns', array( $this, 'set_custom_tg_access_columns_for_members_enrolled' ) );
		add_action( 'manage_tg_access_mgmt_posts_custom_column', array( $this, 'custom_tg_access_columns_for_members_enrolled' ), 10, 2 );

		add_filter( 'manage_tg_access_mgmt_posts_columns', array( $this, 'set_custom_tg_access_columns_for_members_unenrolled' ) );
		add_action( 'manage_tg_access_mgmt_posts_custom_column', array( $this, 'custom_tg_access_columns_for_members_unenrolled' ), 10, 2 );

		add_filter( 'manage_tg_access_mgmt_posts_columns', array( $this, 'set_custom_tg_access_columns_for_integrations' ) );
		add_action( 'manage_tg_access_mgmt_posts_custom_column', array( $this, 'custom_tg_access_columns_for_integrations' ), 10, 2 );

		add_filter( 'manage_tg_access_mgmt_posts_columns', array( $this, 'set_custom_tg_access_columns_for_internal_name' ) );
		add_action( 'manage_tg_access_mgmt_posts_custom_column', array( $this, 'custom_tg_access_columns_for_internal_name' ), 10, 2 );

		add_filter( 'views_edit-tg_access_mgmt', function ( $views ) {
			echo '<p>' . __( 'On this page you can create and manage course access and/or memberships for your students, and integrate your favorite payment solutions.', 'teachground' ) . '</p>';
			return $views;
		} );
	}

	public function course_mapping_js( $post_id ) {
		?>
		<script>
			jQuery( function () {
				var dialog;

				function assignCourse() {
					var course_id = jQuery( '#course_id' ).val();
					var button = jQuery( ".ui-dialog-buttonpane button:contains('Assign Course')" );
					var loader = jQuery( "#course-assign-form-loader" );
					jQuery.ajax( {
							method: "POST",
							dataType: "json",
							beforeSend: function () {
								button.attr( "disabled", true );
								loader.show();
							},
							data: {
								option: 'assignCourse',
								am_id: <?php echo $post_id;?>,
								course_id: course_id
							}
						} )
						.done( function ( res ) {
							button.attr( "disabled", false );
							loader.hide();
							if ( res.status == 'true' ) {
								jQuery( res.data ).appendTo( jQuery( '#course_list' ) );
								dialog.dialog( "close" );
							} else {
								alert( res.data );
							}
							return true;
						} );
				}

				dialog = jQuery( "#course-assign-form" ).dialog( {
					autoOpen: false,
					modal: true,
					width: 500,
					buttons: {
						"Assign Course": assignCourse,
						Cancel: function () {
							jQuery( '#course_id' ).val( '' );
							jQuery( "#course_selected" ).html( '' );
							dialog.dialog( "close" );
						}
					}
				} );

				jQuery( "#add_course" ).on( "click", function () {
					dialog.dialog( "open" );
				} );

				jQuery( "#course_search" ).keyup( function () {
					jQuery.ajax( {
						type: "POST",
						data: {
							option: 'CourseSearch',
							course_search: jQuery( '#course_search' ).val()
						},
						beforeSend: function () {
							jQuery( "#course_search" ).css( "background", "#FFF url(<?php echo plugins_url( TG_DIR_NAME . '/images/input_loader.gif' )?>) no-repeat scroll right" );
						},
						success: function ( data ) {
							jQuery( "#course_search_result" ).show();
							jQuery( "#course_search_result" ).html( data );
							jQuery( "#course_search" ).css( "background", "#FFF" );
						}
					} );
				} );
			} );

			function courseSelectionFromSearch( c_id, c_title ) {
				jQuery( '#course_id' ).val( c_id );
				jQuery( '#course_selected' ).html( 'Selected Course : ' + c_title );
				jQuery( '#course_search' ).val( '' );
				jQuery( '#course_search_result' ).html( '' );
				jQuery( '#course_search_result' ).hide();
			}

			function removeCourse( rm ) {
				jQuery( rm ).parent().remove();
			}
		</script>
		<?php
	}

	public function post_mapping_js( $post_id ) {
		?>
		<script>
			jQuery( function () {
				var dialog;

				function assignPost() {
					var post_id = jQuery( '#post_id' ).val();
					var button = jQuery( ".ui-dialog-buttonpane button:contains('Assign Post')" );
					var loader = jQuery( "#post-assign-form-loader" );
					jQuery.ajax( {
							method: "POST",
							dataType: "json",
							beforeSend: function () {
								button.attr( "disabled", true );
								loader.show();
							},
							data: {
								option: 'assignPost',
								am_id: <?php echo $post_id;?>,
								post_id: post_id
							}
						} )
						.done( function ( res ) {
							button.attr( "disabled", false );
							loader.hide();
							if ( res.status == 'true' ) {
								jQuery( res.data ).appendTo( jQuery( '#post_list' ) );
								dialog.dialog( "close" );
							} else {
								alert( res.data );
							}
							return true;
						} );
				}

				dialog = jQuery( "#post-assign-form" ).dialog( {
					autoOpen: false,
					modal: true,
					width: 500,
					buttons: {
						"Assign Post": assignPost,
						Cancel: function () {
							jQuery( '#post_id' ).val( '' );
							jQuery( "#post_selected" ).html( '' );
							dialog.dialog( "close" );
						}
					}
				} );

				jQuery( "#add_post" ).on( "click", function () {
					dialog.dialog( "open" );
				} );

				jQuery( "#post_search" ).keyup( function () {
					jQuery.ajax( {
						type: "POST",
						data: {
							option: 'PostSearch',
							post_search: jQuery( '#post_search' ).val()
						},
						beforeSend: function () {
							jQuery( "#post_search" ).css( "background", "#FFF url(<?php echo plugins_url( TG_DIR_NAME . '/images/input_loader.gif' )?>) no-repeat scroll right" );
						},
						success: function ( data ) {
							jQuery( "#post_search_result" ).show();
							jQuery( "#post_search_result" ).html( data );
							jQuery( "#post_search" ).css( "background", "#FFF" );
						}
					} );
				} );
			} );

			function postSelectionFromSearch( p_id, p_title ) {
				jQuery( '#post_id' ).val( p_id );
				jQuery( '#post_selected' ).html( 'Selected Post : ' + p_title );
				jQuery( '#post_search' ).val( '' );
				jQuery( '#post_search_result' ).html( '' );
				jQuery( '#post_search_result' ).hide();
			}

			function removePost( rm ) {
				jQuery( rm ).parent().remove();
			}
		</script>
		<?php
	}

	public function mapping_js_am_user( $post_id ) {
		?>
		<script>
			jQuery( function () {
				var dialog;
				var scntDiv = jQuery( '#user_list' );

				function assignAmUser() {
					var user_id = jQuery( '#user_id' ).val();
					var status = jQuery( '#user_status' ).val();
					var button = jQuery( ".ui-dialog-buttonpane button:contains('Assign User')" );
					var loader = jQuery( "#user-assign-form-loader" );

					jQuery.ajax( {
							method: "POST",
							dataType: "json",
							beforeSend: function () {
								button.attr( "disabled", true );
								loader.show();
							},
							data: {
								option: 'assignAmUser',
								am_id: <?php echo $post_id;?>,
								user_id: user_id,
								status: status
							}
						} )
						.done( function ( res ) {
							button.attr( "disabled", false );
							loader.hide();
							if ( res.status == 'true' ) {
								jQuery( res.data ).prependTo( scntDiv );
								dialog.dialog( "close" );
							} else {
								alert( res.data );
							}
							return true;
						} );
				}

				dialog = jQuery( "#am-user-assign-form" ).dialog( {
					autoOpen: false,
					modal: true,
					buttons: {
						"Assign User": assignAmUser,
						Cancel: function () {
							dialog.dialog( "close" );
						}
					}
				} );

				jQuery( "#add_user" ).on( "click", function () {
					dialog.dialog( "open" );
				} );

				jQuery( "#user_search" ).keyup( function () {
					jQuery.ajax( {
						type: "POST",
						data: {
							option: 'UserSearch',
							user_search: jQuery( '#user_search' ).val()
						},
						beforeSend: function () {
							jQuery( "#user_search" ).css( "background", "#FFF url(<?php echo plugins_url( TG_DIR_NAME . '/images/input_loader.gif' )?>) no-repeat scroll right" );
						},
						success: function ( data ) {
							jQuery( "#user_search_result" ).show();
							jQuery( "#user_search_result" ).html( data );
							jQuery( "#user_search" ).css( "background", "#FFF" );
						}
					} );
				} );

			} );

			function userSelectionFromSearch( u_id, u_email ) {
				jQuery( '#user_id' ).val( u_id );
				jQuery( '#user_selected' ).html( 'Selected User : ' + u_email );
				jQuery( '#user_search' ).val( '' );
				jQuery( '#user_search_result' ).html( '' );
				jQuery( '#user_search_result' ).hide();
			}

			function removeAssignedAmUser( th, m_id ) {
				
				if(jQuery(th).attr('data-manual') == 0){
					con = confirm('<?php _e('This user is not added manually are you sure to remove this user?','teachground');?>');
					if(!con){
						return false;
					}
				} else {
					con = confirm('<?php _e('Are you sure to remove this user?','teachground');?>');
					if(!con){
						return false;
					}
				}
				
				jQuery.ajax( {
					method: "POST",
					data: {
						option: 'removeAssignedAmUser',
						m_id: m_id
					}
				} )
				.done( function ( data ) {
					if ( data == 'removed' ) {
						jQuery( '#ua-' + m_id ).remove();
					}
				} );
			}
		</script>
		<?php
	}
	
	public function send_email_js( $post_id ) {
		?>
		<script>
		jQuery(document).ready(function() {
			jQuery('.tg-assign-email').select2();
			jQuery('.tg-unassign-email').select2();
		});
			
		function sendAmAssignedForceEmails(){
			var email_a_users = jQuery('select[name="email_a_users[]"]').val(); 
			if( email_a_users != null ){
				jQuery.ajax( {
					method: "POST",
					dataType: "json",
					beforeSend: function () {},
					data: {
						option: 'sendAmAssignedForceEmails',
						am_id: <?php echo $post_id;?>,
						email_a_users: email_a_users,
					}
				} )
				.done( function ( res ) {
					jQuery('select[name="email_a_users[]"]').val(null).trigger('change');
					alert(res.status);
				} );
			} else {
				alert('Please select users');
			}
		}
			
		function sendAmUnassignedForceEmails(){
			var email_un_users = jQuery('select[name="email_un_users[]"]').val(); 
			if( email_un_users != null ){
				jQuery.ajax( {
					method: "POST",
					dataType: "json",
					beforeSend: function () {},
					data: {
						option: 'sendAmUnassignedForceEmails',
						am_id: <?php echo $post_id;?>,
						email_un_users: email_un_users,
					}
				} )
				.done( function ( res ) {
					jQuery('select[name="email_un_users[]"]').val(null).trigger('change');
					alert(res.status);
				} );
			} else {
				alert('Please select users');
			}
		}	
			
		</script>
		<?php
	}

	public function pg_integration_info( $post ) {
		add_meta_box(
			'pg_integration_info',
			__( 'Payment Gateway Integration', 'teachground' ),
			array( $this, 'pg_integration_info_callback' ), $post->post_type, 'side'
		);
	}

	public function pg_integration_info_callback( $post ) {
		global $wpdb;
		$is_pg_integrated = apply_filters( 'tg_is_pg_added', false );
		if ( !$is_pg_integrated ) {
			echo '<p>' . __( 'You haven’t integrated any payment option yet. Go to > TG > Settings > Integrations to connect with your favorite payment platform', 'teachground' ) . '</p>';
		} else {
			do_action( 'tg_other_pg_integrated_message' );
		}
	}

	public function access_internal_name( $post ) {
		add_meta_box(
			'access_internal_name',
			__( 'Internal Name', 'teachground' ),
			array( $this, 'access_internal_name_callback' ), $post->post_type, 'advanced'
		);
	}

	public function access_internal_name_callback( $post ) {
		global $wpdb;
		wp_nonce_field( 'attachment_meta_box', 'attachment_meta_box_nonce' );
		?>
		<input type="text" name="internal_name" value="<?php echo get_post_meta($post->ID, 'internal_name', true);?>" class="widefat">
		<?php
	}

	public function course_mapping( $post ) {
		add_meta_box(
			'course_mapping',
			__( 'Course Access', 'teachground' ),
			array( $this, 'course_mapping_callback' ), $post->post_type, 'advanced'
		);
	}

	public function course_mapping_callback( $post ) {
		global $wpdb;
		wp_nonce_field( 'attachment_meta_box', 'attachment_meta_box_nonce' );
		$this->course_mapping_js( $post->ID );

		$lists = '';
		$results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM " . $wpdb->prefix . "tg_course_mapping WHERE am_id = %d ORDER BY m_order", $post->ID ), OBJECT );
		if ( is_array( $results ) ) {
			foreach ( $results as $key => $value ) {
				$is_checked = ( tg_is_lesson_start_global_rule_exists_on_am( $value->c_id, $post->ID ) == true ? 'checked' : '' );
				$lists .= '<div class="course-item" data-id="' . $value->c_id . '"><strong>' . __( 'Course', 'teachground' ) . '</strong> <input type="hidden" name="course_ids[]" id="course_ids" value="' . $value->c_id . '"> ' . get_the_title( $value->c_id ) . ' <label><input type="checkbox" name="disable_lesson_rules[]" value="' . $value->c_id . '" ' . $is_checked . '>' . __( 'Disable all lesson start rules', 'teachground' ) . '</label> <a href="post.php?post=' . $value->c_id . '&action=edit" target="_blank" class="tg-edit">' . TG_EDIT_IMAGE . '</a> <a href="javascript:void(0)" onclick="removeCourse(this)" class="tg-delete">' . TG_DELETE_IMAGE . '</a></div>';
			}
		}
		?>

		<div>
			<div style="float:right; margin-left:5px;">
				<a href="javascript:void(0)" id="add_course" class="preview button">
					<?php _e('Add Course','teachground');?>
				</a>
			</div>
		</div>

		<div id="course_list" style="clear:both; width:100%; float:left; margin-top:5px;">
			<?php echo $lists;?>
		</div>

		<div id="course-assign-form" title="<?php _e('Assign Course','teachground');?>">
			<div class="tg-popup-form-inner">
				<input type="hidden" name="course_id" id="course_id">
				<p>
					<?php _e('Search Courses','teachground');?> <input type="text" name="course_search" id="course_search" value="" class="widefat" placeholder="<?php _e('Search by course title','teachground');?>">
				</p>
				<div id="course_search_result"></div>
				<div id="course_selected"></div>
				<div class="tg-loader" id="course-assign-form-loader"></div>
			</div>
		</div>
		<?php /*?>
		<script>
			jQuery( function () {
				jQuery( "#course_list" ).sortable();
			} );
		</script>
		<?php */?>
		<div style="clear:both;"></div>
		<?php
	}

	public function post_mapping( $post ) {
		add_meta_box(
			'post_mapping',
			__( 'Post & Page Access', 'teachground' ),
			array( $this, 'post_mapping_callback' ), $post->post_type, 'advanced'
		);
	}

	public function post_mapping_callback( $post ) {
		global $wpdb;
		wp_nonce_field( 'attachment_meta_box', 'attachment_meta_box_nonce' );
		$this->post_mapping_js( $post->ID );

		$lists = '';
		$results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM " . $wpdb->prefix . "tg_post_mapping WHERE am_id = %d ORDER BY m_order", $post->ID ), OBJECT );
		if ( is_array( $results ) ) {
			foreach ( $results as $key => $value ) {
				$lists .= '<div class="post-item" data-id="' . $value->p_id . '"><strong>' . __( 'Post', 'teachground' ) . '</strong> <input type="hidden" name="post_ids[]" id="post_ids" value="' . $value->p_id . '"> ' . get_the_title( $value->p_id ) . ' <a href="post.php?post=' . $value->p_id . '&action=edit" target="_blank" class="tg-edit">' . TG_EDIT_IMAGE . '</a> <a href="javascript:void(0)" onclick="removePost(this)" class="tg-delete">' . TG_DELETE_IMAGE . '</a></div>';
			}
		}
		?>

		<div>
			<div style="float:right; margin-left:5px;">
				<a href="javascript:void(0)" id="add_post" class="preview button">
					<?php _e('Add Post','teachground');?>
				</a>
			</div>
		</div>

		<div id="post_list" style="clear:both; width:100%; float:left; margin-top:5px;">
			<?php echo $lists;?>
		</div>

		<div id="post-assign-form" title="<?php _e('Assign Post','teachground');?>">
			<div class="tg-popup-form-inner">
				<input type="hidden" name="post_id" id="post_id">
				<p>
					<?php _e('Search Posts','teachground');?> <input type="text" name="post_search" id="post_search" value="" class="widefat" placeholder="<?php _e('Search by post title','teachground');?>">
				</p>
				<div id="post_search_result"></div>
				<div id="post_selected"></div>
				<div class="tg-loader" id="post-assign-form-loader"></div>
			</div>
		</div>
		<?php /*?>
		<script>
			jQuery( function () {
				jQuery( "#post_list" ).sortable();
			} );
		</script>
		<?php */?>
		<div style="clear:both;"></div>
		<?php
	}

	public function email_settings( $post ) {
		add_meta_box(
			'email_settings',
			__( 'Emails', 'teachground' ),
			array( $this, 'email_settings_callback' ), $post->post_type, 'advanced'
		);
	}

	public function email_settings_callback( $post ) {
		global $wpdb, $tg_access_assign_subject_default, $tg_access_assign_body_default, $tg_access_unassign_subject_default, $tg_access_unassign_body_default;

		wp_nonce_field( 'attachment_meta_box', 'attachment_meta_box_nonce' );
		
		// assigned 
		$checked = '';
		$enrolled_send_to_user = get_post_meta($post->ID, 'enrolled_send_to_user', true);
		if(empty($enrolled_send_to_user) or $enrolled_send_to_user == 'yes'){
			if(empty($enrolled_send_to_user)){
				update_post_meta($post->ID, 'enrolled_send_to_user', 'yes');
			}
			$checked = 'checked';
		}
		
		$tg_access_assign_subject = get_post_meta($post->ID, 'tg_access_assign_subject', true);
		$tg_access_assign_body = get_post_meta($post->ID, 'tg_access_assign_body', true);
		
		if(empty($tg_access_assign_subject)){
			$tg_access_assign_subject = $tg_access_assign_subject_default; 
		}
		if(empty($tg_access_assign_body)){
			$tg_access_assign_body = $tg_access_assign_body_default; 
		}
		
		// unassigned
		$checked2 = '';
		$unenrolled_send_to_user = get_post_meta($post->ID, 'unenrolled_send_to_user', true);
		if(empty($unenrolled_send_to_user) or $unenrolled_send_to_user == 'yes'){
			if(empty($unenrolled_send_to_user)){
				update_post_meta($post->ID, 'unenrolled_send_to_user', 'yes');
			}
			$checked2 = 'checked';
		}
		
		$tg_access_unassign_subject = get_post_meta($post->ID, 'tg_access_unassign_subject', true);
		$tg_access_unassign_body = get_post_meta($post->ID, 'tg_access_unassign_body', true);
		
		if(empty($tg_unaccess_assign_subject)){
			$tg_access_unassign_subject = $tg_access_unassign_subject_default; 
		}
		if(empty($tg_access_unassign_body)){
			$tg_access_unassign_body = $tg_access_unassign_body_default; 
		}
		
		$this->send_email_js($post->ID);
		?>
		<table width="100%" border="0">
			<!-- enrollment email -->
			<tr>
				<td colspan="2">
					<h3>
						<?php _e('Enrollment Email','teachground');?>
					</h3>
					<p><?php _e('This email will be sent each time a new user is enrolled to this access.','teachground');?></p>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<label><input type="checkbox" name="enrolled_send_to_user" value="yes" <?php echo $checked;?>> <?php _e('Enable','teachground');?></label>
				</td>
			</tr>
			<tr>
				<td width="200">
					<strong><?php _e('Email Subject','teachground');?></strong>
				</td>
				<td>
					<input type="text" name="tg_access_assign_subject" value="<?php echo stripslashes($tg_access_assign_subject);?>" class="widefat">
				</td>
			</tr>
			<tr>
				<td width="200" valign="top">
					<strong><?php _e('Email Content','teachground');?></strong>
				</td>
				<td>
					<textarea name="tg_access_assign_body" class="widefat" rows="10"><?php echo stripslashes($tg_access_assign_body);?></textarea>
                      <i><?php _e('Email template can be found at','teachground');?> <?php echo TG_DIR_NAME;?>/templates/emails/user_assigned.php</i><br>
                      <strong><?php _e('Available Codes','teachground');?></strong> #display_name#, #first_name#, #last_name#, #user_email#, #access_name#, #site_url#, #reset_pass_url#, #login_url#
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<hr>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<?php _e('Use the following option if you want to manually resend this email to selected users','teachground');?>
				</td>
			</tr>
			<tr>
				<td valign="top">
					<strong><?php _e('Search User','teachground');?></strong>
				</td>
				<td>
					<select class="tg-assign-email widefat" name="email_a_users[]" multiple="multiple">
					  <?php echo $this->get_am_users_for_sending_emails($post->ID, 'Active');?>
					</select>
				</td>
			</tr>
			<tr>
				<td>&nbsp;
					
				</td>
				<td>
					<input type="button" name="send_assing_mail" value="<?php _e('Resend Email','teachground');?>" class="button" onClick="sendAmAssignedForceEmails();">
				</td>
			</tr>
			
			<!-- unenrollment email -->
			<tr>
				<td colspan="2">
					<h3>
						<?php _e('Unenrollment Email','teachground');?>
					</h3>
					<p><?php _e('This email will be sent each time a user is unenrolled from this access.','teachground');?></p>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<label><input type="checkbox" name="unenrolled_send_to_user" value="yes" <?php echo $checked2;?>> <?php _e('Enable','teachground');?></label>
				</td>
			</tr>
			<tr>
				<td width="200">
					<strong><?php _e('Email Subject','teachground');?></strong>
				</td>
				<td>
					<input type="text" name="tg_access_unassign_subject" value="<?php echo stripslashes($tg_access_unassign_subject);?>" class="widefat">
				</td>
			</tr>
			<tr>
				<td width="200" valign="top">
					<strong><?php _e('Email Content','teachground');?></strong>
				</td>
				<td>
					<textarea name="tg_access_unassign_body" class="widefat" rows="10"><?php echo stripslashes($tg_access_unassign_body);?></textarea>
                      <i><?php _e('Email template can be found at','teachground');?> <?php echo TG_DIR_NAME;?>/templates/emails/user_assigned.php</i><br>
                      <strong><?php _e('Available Codes','teachground');?></strong> #display_name#, #first_name#, #last_name#, #user_email#, #access_name#, #site_url#, #reset_pass_url#, #login_url#
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<hr>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<?php _e('Use the following option if you want to manually resend this email to selected users','teachground');?>
				</td>
			</tr>
			<tr>
				<td valign="top">
					<strong><?php _e('Search User','teachground');?></strong>
				</td>
				<td>
					<select class="tg-unassign-email widefat" name="email_un_users[]" multiple="multiple">
					  <?php echo $this->get_am_users_for_sending_emails($post->ID, 'Inactive');?>
					</select>
				</td>
			</tr>
			<tr>
				<td>&nbsp;
					
				</td>
				<td>
					<input type="button" name="send_unassing_mail" value="<?php _e('Resend Email','teachground');?>" class="button" onClick="sendAmUnassignedForceEmails();">
				</td>
			</tr>
		</table>
		<div style="clear:both;"></div>
		<?php
	}

	public function am_user_mapping( $post ) {
		add_meta_box(
			'am_user_mapping',
			__( 'User Mapping', 'teachground' ),
			array( $this, 'am_user_mapping_callback' ), $post->post_type, 'advanced'
		);
	}

	public function am_user_mapping_callback( $post ) {
		global $wpdb;
		wp_nonce_field( 'attachment_meta_box', 'attachment_meta_box_nonce' );
		$this->mapping_js_am_user( $post->ID );

		$results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM " . $wpdb->prefix . "tg_am_user_mapping WHERE am_id = %d ORDER BY added_on DESC", $post->ID ), OBJECT );

		$lists = '';
		if ( is_array( $results ) ) {
			foreach ( $results as $key => $value ) {
				$user_info = get_userdata( $value->user_id );
				$lists .= '<div class="user-item" id="ua-' . $value->m_id . '"><strong>' . __( 'User', 'teachground' ) . '</strong> ' . $user_info->user_email . ' <input type="hidden" name="user_ids[]" value="' . $value->user_id . '"> <strong>' . __( 'Status', 'teachground' ) . '</strong> <select name="user_statuses[]">' . $this->get_user_status_selected( $value->m_status ) . '</select><input type="hidden" name="m_ids[]" value="' . $value->m_id . '"> <strong>' . __( 'Added On', 'teachground' ) . '</strong> ' . tg_date_format( $value->added_on, 'jS M, Y \a\t g:i a' ) . ' <a href="javascript:void(0)" onclick="removeAssignedAmUser(this, ' . $value->m_id . ')" data-manual="'.(is_user_assigned_manually( $value->user_id,$post->ID)==true?1:0).'" class="tg-delete">' . TG_DELETE_IMAGE . '</a></div>';
			}
		}
		?>

		<div>
			<div>
				<a href="javascript:void(0)" id="add_user" class="preview button">
					<?php _e('Enroll User','teachground');?>
				</a>
			</div>
		</div>

		<div id="user_list" style="clear:both; width:100%; float:left; margin-top:5px;">
			<?php echo $lists;?>
		</div>

		<div id="am-user-assign-form" title="<?php _e('Assign User','teachground');?>">
			<div class="tg-popup-form-inner">
				<input type="hidden" name="user_id" id="user_id">
				<p>
					<?php _e('Search User','teachground');?> <input type="text" name="user_search" id="user_search" value="" class="widefat" placeholder="<?php _e('Search by name / email','teachground');?>">
				</p>
				<p>
					<?php _e('Status','teachground');?>
					<select name="user_status" id="user_status" class="widefat">
						<?php echo $this->get_user_status_selected();?>
					</select>
				</p>
				<div id="user_search_result"></div>
				<div id="user_selected"></div>
				<div class="tg-loader" id="user-assign-form-loader"></div>
			</div>
		</div>

		<div style="clear:both;"></div>
		<?php
	}

	public function get_user_selected( $sel = '' ) {
		$ret = '';
		$query_data = get_users();
		if ( $query_data ) {
			foreach ( $query_data as $data ) {
				if ( $data->ID == $sel ) {
					$ret .= '<option value="' . $data->ID . '" selected="selected">' . $data->user_email . '</option>';
				} else {
					$ret .= '<option value="' . $data->ID . '">' . $data->user_email . '</option>';
				}
			}
		}
		return $ret;
	}

	public function get_user_status_selected( $sel = '' ) {
		$ret = '';
		$query_data = array( 'Active' => __( 'Active', 'teachground' ), 'Inactive' => __( 'Inactive', 'teachground' ) );
		if ( is_array( $query_data ) ) {
			foreach ( $query_data as $key => $value ) {
				if ( $key == $sel ) {
					$ret .= '<option value="' . $key . '" selected="selected">' . $value . '</option>';
				} else {
					$ret .= '<option value="' . $key . '">' . $value . '</option>';
				}
			}
		}
		return $ret;
	}
	
	public function get_am_users_for_sending_emails( $am_id = '', $status = 'Active' ){ 
		global $wpdb;
		$results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM " . $wpdb->prefix . "tg_am_user_mapping WHERE am_id = %d AND m_status = %s ORDER BY added_on DESC", $am_id, $status ), OBJECT );
		$opts = '';
		if ( is_array( $results ) ) {
			foreach ( $results as $key => $value ) {
				$user_info = get_userdata( $value->user_id );
				$opts .= '<option value="' . $value->user_id . '">' . $user_info->user_email . '</option>';
			}
		}
		return $opts;
	}

	// course list column //
	public function set_custom_tg_access_columns_for_course_list( $columns ) {
		$columns[ 'courses' ] = __( 'Courses', 'teachground' );
		return $columns;
	}

	public function custom_tg_access_columns_for_course_list( $column, $post_id ) {
		switch ( $column ) {
			case 'courses':
				global $wpdb;
				$results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM " . $wpdb->prefix . "tg_course_mapping WHERE am_id = %d ORDER BY m_order", $post_id ), OBJECT );
				$lists = '';
				if ( is_array( $results )and count( $results ) ) {
					foreach ( $results as $key => $value ) {
						$lists .= get_the_title( $value->c_id );
						$lists .= '<br>';
					}
					echo $lists;
				} else {
					_e( 'No course assigned', 'teachground' );
				}
				break;
		}
	}
	// course list column //

	// user enrolled column //
	public function set_custom_tg_access_columns_for_members_enrolled( $columns ) {
		$columns[ 'members_enrolled' ] = __( 'Members Enrolled', 'teachground' );
		return $columns;
	}

	public function custom_tg_access_columns_for_members_enrolled( $column, $post_id ) {
		switch ( $column ) {
			case 'members_enrolled':
				global $wpdb;
				$enrolled_users = array();
				$results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM " . $wpdb->prefix . "tg_am_user_mapping WHERE am_id = %d AND m_status = %s ORDER BY added_on DESC", $post_id, 'Active' ), OBJECT );
				$lists = '';
				if ( is_array( $results )and count( $results ) ) {
					foreach ( $results as $key => $value ) {
						$user_info = get_userdata( $value->user_id );
						$enrolled_users[] = $user_info->user_email;
						//$lists .= $user_info->user_email;
						//$lists .= '<br>';
					}
					echo sprintf( __("%d members are assigned", 'teachground'), count($enrolled_users));
				} else {
					_e( 'No members are assigned', 'teachground' );
				}
				break;
		}
	}
	// user enrolled column //

	// user unenrolled column //
	public function set_custom_tg_access_columns_for_members_unenrolled( $columns ) {
		$columns[ 'members_unenrolled' ] = __( 'Members Unenrolled', 'teachground' );
		return $columns;
	}

	public function custom_tg_access_columns_for_members_unenrolled( $column, $post_id ) {
		switch ( $column ) {
			case 'members_unenrolled':
				global $wpdb;
				$results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM " . $wpdb->prefix . "tg_am_user_mapping WHERE am_id = %d AND m_status = %s ORDER BY added_on DESC", $post_id, 'Inactive' ), OBJECT );
				$lists = '';
				if ( is_array( $results )and count( $results ) ) {
					foreach ( $results as $key => $value ) {
						$user_info = get_userdata( $value->user_id );
						$lists .= $user_info->user_email;
						$lists .= '<br>';
					}
					echo $lists;
				} else {
					_e( 'No members are unassigned', 'teachground' );
				}
				break;
		}
	}
	// user unenrolled column //

	// integrations column //
	public function set_custom_tg_access_columns_for_integrations( $columns ) {
		$columns[ 'integrations' ] = __( 'Integrations', 'teachground' );
		return $columns;
	}

	public function custom_tg_access_columns_for_integrations( $column, $post_id ) {
		switch ( $column ) {
			case 'integrations':
				do_action( 'tg_accss_mgmt_integrations_list', $post_id );
				break;
		}
	}
	// integrations column //

	// internal name column //
	public function set_custom_tg_access_columns_for_internal_name( $columns ) {
		$new = array();
		foreach($columns as $key => $title) {
			if ( $key == 'author' ) {
				$new['internal_name'] = __( 'Internal Name', 'teachground' );
			}
			$new[$key] = $title;
		}
  		return $new;
	}

	public function custom_tg_access_columns_for_internal_name( $column, $post_id ) {
		switch ( $column ) {
			case 'internal_name':
				echo get_post_meta( $post_id, 'internal_name', true );
				break;
		}
	}
	// internal name column //

}