<?php

class front_form_process {
	
	public $msg;
	
	public function __construct() {
		add_action( 'init', array( $this, 'save' ) );
		add_action( 'init', array( $this, 'save_ajax' ) );
		$this->msg = new class_lms_message;
	}
	
	public function save(){

		if( isset( $_POST['option'] ) and sanitize_text_field( $_POST['option'] ) == "mark_lesson_complete" ){
			global $wpdb;
			
			if ( ! isset( $_POST['lms_front_data_field'] ) || ! wp_verify_nonce( $_POST['lms_front_data_field'], 'lms_front_data_action' ) ) {
			   wp_die( 'Sorry, your nonce did not verify.');
			} 
			
			if( !is_user_logged_in() ){
				wp_die( 'You are not logged in!');
			}
			
			$user_id 		= get_current_user_id();
			$l_id 			= (int)sanitize_text_field( $_REQUEST['l_id'] );
			$mark_complete 	= sanitize_text_field( @$_REQUEST['mark_complete'] );
			
			$status = lms_is_current_user_assigned_to_lesson( $l_id );
			if( !$status['status'] ){
				wp_die( 'You are not permitted to do this!');
			}
			
			if( $mark_complete == 'Yes' ){
				if( $status['status'] ){
					// if here then this user can mark this lesson complete
					if( lms_is_lesson_marked_as_completed( $user_id, $l_id ) ){
						$this->msg->add( 'You have already marked this lesson as completed.', 'lms-error' );
					} else {
						// additional validations
						$oth_status = lms_other_lesson_marked_as_completed_validations( $user_id, $l_id );
						if( $oth_status['status'] ){
							// if here then we have to insert data in mapping table
							$map_data['user_id'] = get_current_user_id();
							$map_data['l_id'] = $l_id;
							$wpdb->insert( $wpdb->prefix."lms_user_lesson_complete_mapping", $map_data );
							
							lms_do_course_complete_actions($user_id,$l_id);
						} else {
							$this->msg->add( $oth_status['msg'], 'lms-error' );
						}
					}
				}
			}

			wp_redirect(get_permalink($l_id));
			exit;
		}

		if( isset( $_POST['option'] ) and sanitize_text_field( $_POST['option'] ) == "mark_lesson_uncomplete" ){
			global $wpdb;
			
			if ( ! isset( $_POST['lms_front_data_field'] ) || ! wp_verify_nonce( $_POST['lms_front_data_field'], 'lms_front_data_action' ) ) {
			   wp_die( 'Sorry, your nonce did not verify.');
			} 
			
			if( !is_user_logged_in() ){
				wp_die( 'You are not logged in!');
			}
			
			$user_id 			= get_current_user_id();
			$l_id 				= (int)sanitize_text_field( $_REQUEST['l_id'] );
			$mark_uncomplete 	= sanitize_text_field( @$_REQUEST['mark_uncomplete'] );
			
			$status = lms_is_current_user_assigned_to_lesson( $l_id );
			if( !$status['status'] ){
				wp_die( 'You are not permitted to do this!');
			}
			
			if( $mark_uncomplete == 'Yes' ){
				if( $status['status'] ){
					// if here then this user can mark this lesson uncomplete
					$map_data['user_id'] = get_current_user_id();
					$map_data['l_id'] = $l_id;
					$wpdb->delete( $wpdb->prefix."lms_user_lesson_complete_mapping", $map_data );
				} else{
					$this->msg->add( 'Please try again', 'lms-error' );
				}
			} else {
				$this->msg->add( 'Please try again', 'lms-error' );
			}

			wp_redirect(get_permalink($l_id));
			exit;
		}
	}
	
	public function save_ajax(){

		if( isset( $_POST['option'] ) and sanitize_text_field( $_POST['option'] ) == "markCompletePreSubmit" ){
			global $wpdb;
			$user_id 		= get_current_user_id();
			$l_id 			= (int)sanitize_text_field( $_REQUEST['l_id'] );
			
			if( !is_user_logged_in() ){
				echo json_encode( array( 'status' => 'error', 'msg' => __('You are not logged in!','lms') ) );
				exit;
			}
			
			$status = lms_is_current_user_assigned_to_lesson( $l_id );
			if( !$status['status'] ){
				echo json_encode( array( 'status' => 'error', 'msg' => __('You are not permitted to do this!','lms') ) );
				exit;
			}
			
			if( lms_is_lesson_marked_as_completed( $user_id, $l_id ) ){
				echo json_encode( array( 'status' => 'error', 'msg' => __('You have already marked this lesson as completed.','lms') ) );
				exit;
			} else {
				$frm_status = forminator_lms_validation_pre_submit( $user_id, $l_id );
				if( $frm_status['status'] ){
					echo json_encode( array( 'status' => 'success', 'msg' => __('Proceed to submit the form!','lms') ) );
					exit;
				} else {
					echo json_encode( array( 'status' => 'error', 'msg' => $frm_status['msg'] ) );
					exit;
				}
			}
		}

		if( isset( $_POST['option'] ) and sanitize_text_field( $_POST['option'] ) == "markUncompletePreSubmit" ){
			global $wpdb;
			$user_id 		= get_current_user_id();
			$l_id 			= (int)sanitize_text_field( $_REQUEST['l_id'] );
			
			if( !is_user_logged_in() ){
				echo json_encode( array( 'status' => 'error', 'msg' => __('You are not logged in!','lms') ) );
				exit;
			}
			
			$status = lms_is_current_user_assigned_to_lesson( $l_id );
			if( !$status['status'] ){
				echo json_encode( array( 'status' => 'error', 'msg' => __('You are not permitted to do this!','lms') ) );
				exit;
			}
			
			echo json_encode( array( 'status' => 'success', 'msg' => __('Proceed to submit the form!','lms') ) );
			exit;
		}
		
		
		if( isset( $_POST['option'] ) and sanitize_text_field( $_POST['option'] ) == "storeYTData" ){
			global $wpdb;
			$user_id 			= get_current_user_id();
			$l_id 				= (int)sanitize_text_field( $_REQUEST['l_id'] );
			
			if( !is_user_logged_in() ){
				echo json_encode( array( 'status' => 'error', 'msg' => __('You are not logged in!','lms') ) );
				exit;
			}
			
			$status = lms_is_current_user_assigned_to_lesson( $l_id );
			if( !$status['status'] ){
				echo json_encode( array( 'status' => 'error', 'msg' => __('You are not permitted to do this!','lms') ) );
				exit;
			}
			
			if( lms_is_lesson_marked_as_completed( $user_id, $l_id ) ){
				echo json_encode( array( 'status' => 'error', 'msg' => __('You have already marked this lesson as completed.','lms') ) );
				exit;
			} else {
				$entry_id = $wpdb->get_var( $wpdb->prepare( "SELECT log_id FROM ".$wpdb->prefix."lms_youtube_data WHERE user_id = %d AND l_id = %d ORDER BY log_id DESC LIMIT 1", get_current_user_id(), $l_id ) );
				if( !$entry_id ){
					$map_data['user_id'] = get_current_user_id();
					$map_data['l_id'] = $l_id;
					$wpdb->insert( $wpdb->prefix."lms_youtube_data", $map_data );
					echo json_encode( array( 'status' => 'success', 'msg' => __('Threshold reached','lms') ) );
					exit;
				} else {
					echo json_encode( array( 'status' => 'success', 'msg' => __('Threshold already reached','lms') ) );
					exit;
				}
			}
		}
		
		if( isset( $_POST['option'] ) and sanitize_text_field( $_POST['option'] ) == "storeVimeoData" ){
			global $wpdb;
			$user_id 			= get_current_user_id();
			$l_id 				= (int)sanitize_text_field( $_REQUEST['l_id'] );
			
			if( !is_user_logged_in() ){
				echo json_encode( array( 'status' => 'error', 'msg' => __('You are not logged in!','lms') ) );
				exit;
			}
			
			$status = lms_is_current_user_assigned_to_lesson( $l_id );
			if( !$status['status'] ){
				echo json_encode( array( 'status' => 'error', 'msg' => __('You are not permitted to do this!','lms') ) );
				exit;
			}
			
			if( lms_is_lesson_marked_as_completed( $user_id, $l_id ) ){
				echo json_encode( array( 'status' => 'error', 'msg' => __('You have already marked this lesson as completed.','lms') ) );
				exit;
			} else {
				$entry_id = $wpdb->get_var( $wpdb->prepare( "SELECT log_id FROM ".$wpdb->prefix."lms_vimeo_data WHERE user_id = %d AND l_id = %d ORDER BY log_id DESC LIMIT 1", get_current_user_id(), $l_id ) );
				if( !$entry_id ){
					$map_data['user_id'] = get_current_user_id();
					$map_data['l_id'] = $l_id;
					$wpdb->insert( $wpdb->prefix."lms_vimeo_data", $map_data );
					echo json_encode( array( 'status' => 'success', 'msg' => __('Threshold reached','lms') ) );
					exit;
				} else{
					echo json_encode( array( 'status' => 'success', 'msg' => __('Threshold already reached','lms') ) );
					exit;
				}
			}
		}
	}
}

new front_form_process;