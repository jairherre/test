<?php

add_action( 'tg_am_user_assigned', 'tg_send_user_assigned_email', 10, 1 );
function tg_send_user_assigned_email( $data ){
	
	// check if email is already sent 
	if( tg_is_am_assigned_mail_sent( $data['am_id'], $data['user_id'] ) ){
		return; // email is already sent
	}
	tg_update_am_assigned_mail_sent_status( $data['am_id'], $data['user_id'], 'Sent' );
	
	send_am_assigned_mail( $data );
	return;
}

add_action( 'tg_am_user_unassigned', 'tg_send_user_unassigned_email', 10, 1 );
function tg_send_user_unassigned_email( $data ){
	
	// check if email is already sent 
	if( tg_is_am_unassigned_mail_sent( $data['am_id'], $data['user_id'] ) ){
		return; // email is already sent
	}
	tg_update_am_unassigned_mail_sent_status( $data['am_id'], $data['user_id'], 'Sent' );
	
	send_am_unassigned_mail( $data );
	return;
}

add_action( 'tg_user_inserted', 'tg_user_inserted_email', 10, 1 );
function tg_user_inserted_email( $user_id ){
	if( tg_is_checked( get_option( 'tg_enable_new_user_created_email_user' ) ) != 'checked' ){
		return; // email is not required
	}
	send_user_account_created_mail( $user_id );
	return;
}

add_action( 'forminator_quizzes_submit_before_set_fields', 'forminator_quizzes_submit_before_set_fields_tg', 10, 3 );
function forminator_quizzes_submit_before_set_fields_tg( $entry, $form_id, $field_data ){
	global $wpdb;
	$l_id = sanitize_text_field($_REQUEST['page_id']);
	if( get_post_type( $l_id ) == 'tg_lesson' ){
		$map_data['entry_id'] = $entry->entry_id;
		$map_data['l_id'] = $l_id;
		$map_data['user_id'] = get_current_user_id();
		$wpdb->insert( $wpdb->prefix."tg_frmt_quiz_data", $map_data );
	}
}

add_action( 'forminator_custom_form_submit_before_set_fields', 'forminator_custom_form_submit_before_set_fields_tg', 10, 3 );
function forminator_custom_form_submit_before_set_fields_tg( $entry, $form_id, $field_data ){
	global $wpdb;
	$l_id = sanitize_text_field($_REQUEST['page_id']);
	if( get_post_type( $l_id ) == 'tg_lesson' ){
		$map_data['entry_id'] = $entry->entry_id;
		$map_data['l_id'] = $l_id;
		$map_data['user_id'] = get_current_user_id();
		$wpdb->insert( $wpdb->prefix."tg_frmt_form_data", $map_data );
	}
}

add_action( 'the_lesson_single_title_top', 'tg_message_on_top', 10, 1 );
function tg_message_on_top( $lesson = '' ){
	$lmc = new class_tg_message;
	$lmc->show(false);
}

add_action( 'tg_settings_data_save', 'tg_import_data', 10, 1 );
function tg_import_data( $cls ){
	$import = new class_tg_data_import($cls);
}

add_action( 'tg_am_user_assigned', 'tg_am_user_assign_to_course', 10, 1 );
function tg_am_user_assign_to_course( $data ){	
	$am_id = $data['am_id'];
	// get the courses assigned to this am
	$cids = tg_get_courses_from_am_id($am_id);	
	if( $cids == false ){
		return false;
	} else {
		if(is_array($cids)){
			foreach($cids as $key => $value){
				// assign user to the course 
				tg_assign_user_to_course( array('user_id' => $data['user_id'], 'course_id' => $value, 'status' => $data['status'] ) );
			}
		}
	}
}

//add_action( 'tg_am_user_unassigned', 'tg_am_user_unassign_to_course', 10, 1 );
function tg_am_user_unassign_to_course( $data ){	
	$am_id = $data['am_id'];
	// get the courses assigned to this am
	$cids = tg_get_courses_from_am_id($am_id);
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

add_action( 'template_redirect', 'tg_redirect_to_login' );
function tg_redirect_to_login() {

    if ( is_single() && 'tg_course' == get_post_type() ) {
        if(!is_user_logged_in()){
			if(get_option('tg_login_url')){
				wp_redirect( get_option('tg_login_url') );
        		die;
			}
		}
	}

	if ( is_single() && 'post' == get_post_type() ) {
        if(!is_user_logged_in()){
			$has_access = tg_is_current_user_assigned_to_post( get_the_ID() );
			if( !$has_access['status'] && get_option('tg_login_url') != ''){
				wp_redirect( get_option('tg_login_url') );
        		die;
			}
		}
	}
	
	if ( is_page() ) {
        if(!is_user_logged_in()){
			$has_access = tg_is_current_user_assigned_to_post( get_the_ID() );
			if( !$has_access['status'] && get_option('tg_login_url') != ''){
				wp_redirect( get_option('tg_login_url') );
        		die;
			}
		}
	}
	
}