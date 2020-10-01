<?php

add_action( 'lms_am_user_assigned', 'lms_send_user_assigned_email', 10, 1 );
function lms_send_user_assigned_email( $data ){
	
	// check if email is already sent 
	if( lms_is_am_assigned_mail_sent( $data['am_id'], $data['user_id'] ) ){
		return; // email is already sent
	}
	lms_update_am_assigned_mail_sent_status( $data['am_id'], $data['user_id'], 'Sent' );
	
	send_am_assigned_mail( $data );
	return;
}

add_action( 'lms_am_user_unassigned', 'lms_send_user_unassigned_email', 10, 1 );
function lms_send_user_unassigned_email( $data ){
	
	// check if email is already sent 
	if( lms_is_am_unassigned_mail_sent( $data['am_id'], $data['user_id'] ) ){
		return; // email is already sent
	}
	lms_update_am_unassigned_mail_sent_status( $data['am_id'], $data['user_id'], 'Sent' );
	
	send_am_unassigned_mail( $data );
	return;
}

add_action( 'lms_user_inserted', 'lms_user_inserted_email', 10, 1 );
function lms_user_inserted_email( $user_id ){
	if( lms_is_checked( get_option( 'lms_enable_new_user_created_email_user' ) ) != 'checked' ){
		return; // email is not required
	}
	send_user_account_created_mail( $user_id );
	return;
}

add_action( 'forminator_quizzes_submit_before_set_fields', 'forminator_quizzes_submit_before_set_fields_lms', 10, 3 );
function forminator_quizzes_submit_before_set_fields_lms( $entry, $form_id, $field_data ){
	global $wpdb;
	$l_id = sanitize_text_field($_REQUEST['page_id']);
	if( get_post_type( $l_id ) == 'lms_lesson' ){
		$map_data['entry_id'] = $entry->entry_id;
		$map_data['l_id'] = $l_id;
		$map_data['user_id'] = get_current_user_id();
		$wpdb->insert( $wpdb->prefix."lms_frmt_quiz_data", $map_data );
	}
}

add_action( 'forminator_custom_form_submit_before_set_fields', 'forminator_custom_form_submit_before_set_fields_lms', 10, 3 );
function forminator_custom_form_submit_before_set_fields_lms( $entry, $form_id, $field_data ){
	global $wpdb;
	$l_id = sanitize_text_field($_REQUEST['page_id']);
	if( get_post_type( $l_id ) == 'lms_lesson' ){
		$map_data['entry_id'] = $entry->entry_id;
		$map_data['l_id'] = $l_id;
		$map_data['user_id'] = get_current_user_id();
		$wpdb->insert( $wpdb->prefix."lms_frmt_form_data", $map_data );
	}
}

add_action( 'the_lesson_single_title_top', 'lms_message_on_top', 10, 1 );
function lms_message_on_top( $lesson = '' ){
	$lmc = new class_lms_message;
	$lmc->show(false);
}

add_action( 'lms_settings_data_save', 'lms_import_data', 10, 1 );
function lms_import_data( $cls ){
	$import = new class_lms_data_import($cls);
}

add_action( 'lms_am_user_assigned', 'lms_am_user_assign_to_course', 10, 1 );
function lms_am_user_assign_to_course( $data ){	
	$am_id = $data['am_id'];
	// get the courses assigned to this am
	$cids = lms_get_courses_from_am_id($am_id);	
	if( $cids == false ){
		return false;
	} else {
		if(is_array($cids)){
			foreach($cids as $key => $value){
				// assign user to the course 
				lms_assign_user_to_course( array('user_id' => $data['user_id'], 'course_id' => $value, 'status' => $data['status'] ) );
			}
		}
	}
}

//add_action( 'lms_am_user_unassigned', 'lms_am_user_unassign_to_course', 10, 1 );
function lms_am_user_unassign_to_course( $data ){	
	$am_id = $data['am_id'];
	// get the courses assigned to this am
	$cids = lms_get_courses_from_am_id($am_id);
	if( $cids == false ){
		return false;
	} else {
		if(is_array($cids)){
			foreach($cids as $key => $value){
				// unassign user from the course 
				unmap_user_from_course( array('user_id' => $data['user_id'], 'course_id' => $value ) );
			}
		}
	}
}

add_action( 'template_redirect', 'lms_redirect_to_login' );
function lms_redirect_to_login() {

    if ( is_single() && 'lms_course' == get_post_type() ) {
        if(!is_user_logged_in()){
			if(get_option('lms_login_url')){
				wp_redirect( get_option('lms_login_url') );
        		die;
			}
		}
	}

	if ( is_single() && 'post' == get_post_type() ) {
        if(!is_user_logged_in()){
			$has_access = lms_is_current_user_assigned_to_post( get_the_ID() );
			if( !$has_access['status'] && get_option('lms_login_url') != ''){
				wp_redirect( get_option('lms_login_url') );
        		die;
			}
		}
	}
	
	if ( is_page() ) {
        if(!is_user_logged_in()){
			$has_access = lms_is_current_user_assigned_to_post( get_the_ID() );
			if( !$has_access['status'] && get_option('lms_login_url') != ''){
				wp_redirect( get_option('lms_login_url') );
        		die;
			}
		}
	}
	
}