<?php

/*
* get course id from template pages 
* accepts - NA
* returns - course_id / false
*/
function tg_get_course_id_from_template(){
	global $post;
	if($post->post_type == 'tg_course'){
		return $post->ID;
	} else if($post->post_type == 'tg_lesson'){
		$course_id = tg_get_probable_course_id_from_lesson_id( $post->ID );
		return $course_id;
	} else {
		return false;
	}
}

/*
* get lesson id from template pages 
* accepts - NA
* returns - lesson_id / false
*/
function tg_get_lesson_id_from_template(){
	global $post;
	if($post->post_type == 'tg_lesson'){
		return $post->ID;
	} else {
		return false;
	}
}

/*
* check if access management exists 
* accepts - am id
* returns - true / false
*/
function tg_is_am_exists( $am_id = '' ){
	if( empty( $am_id ) ){
		return false;
	}
	$is_exists = 'tg_access_mgmt' === get_post_type( $am_id ) ? true : false; 
	if ( false === $is_exists ) {
	  return false;
	} else {
	  return true;
	}
}

/*
* get courses assigned to access management
* accepts - am id
* returns - false / array
*/
function tg_get_courses_from_am_id( $am_id = '' ){
	global $wpdb;
	if( empty( $am_id ) ){
		return false;
	}
	$cids = [];
	$course_ids = $wpdb->get_results( $wpdb->prepare( "SELECT c_id FROM ".$wpdb->prefix."tg_course_mapping WHERE am_id = %d", $am_id ), ARRAY_A );
	if( !$course_ids ){
		return false;
	} else {
		if( is_array($course_ids) ){
			foreach( $course_ids as $key => $value ){
				 $cids[] = $value['c_id'];
			}
			return $cids;
		}
	}
	return false;
}

/*
* check if course exists 
* accepts - course id
* returns - true / false
*/
function tg_is_course_exists( $course_id = '' ){
	if( empty( $course_id ) ){
		return false;
	}
	$is_exists = 'tg_course' === get_post_type( $course_id ) ? true : false; 
	if ( false === $is_exists ) {
	  return false;
	} else {
	  return true;
	}
}

/*
* check if course progress is disabled 
* accepts - lesson id / blank
* returns - true / false
*/
function is_course_progress_disabled( $lesson_id = '' ){
	if( $lesson_id == ''){
		global $post;
		if ( is_singular( 'tg_course' ) ) {
			$course_id = $post->ID;
		} elseif( is_singular( 'tg_lesson' ) ){
			$lesson_id = $post->ID;
			$course_id = tg_get_probable_course_id_from_lesson_id( $lesson_id );
		} else {
			return false;
		}
	} else {
		$course_id = tg_get_probable_course_id_from_lesson_id( $lesson_id );
	}
	$is_disabled = get_post_meta($course_id, 'disable_course_progress', true) == 'Yes'?true:false; 
	return $is_disabled;
}

/*
* check if course is free 
* accepts - course id
* returns - true / false
*/
function is_course_free( $course_id = '' ){
	global $wpdb;
	if( $course_id == ''){
		return false;
	}
	$is_free = (get_post_meta($course_id, 'course_is_free', true) == 'Yes'?true:false);
	return $is_free;
}

/*
* check if lesson is free 
* accepts - lesson id
* returns - true / false
*/
function is_lesson_free( $lesson_id = '' ){
	global $wpdb;
	if( $lesson_id == ''){
		return false;
	}
	$lesson_free_data = $wpdb->get_row( $wpdb->prepare( "SELECT l_free FROM ".$wpdb->prefix."tg_lesson_mapping WHERE l_id = %d", $lesson_id ), ARRAY_A );
	$is_free = ($lesson_free_data['l_free'] == 'Yes'?true:false);
	return $is_free;
}

/*
* check if current user is assigned to the course
* accepts - course id
* returns - array
*/
function tg_is_current_user_assigned_to_course( $course_id = '' ){
	global $wpdb, $post;

	if( !is_user_logged_in() ){
		return array( 'status' => false, 'msg' => __( 'Please login to view course!', 'teachground' ) );
	}
	if( empty( $course_id ) ){
		$course_id = tg_get_course_id_from_template();
		if(!$course_id){
			return array( 'status' => false, 'msg' => __( 'Course not found!', 'teachground' ) );
		}
	}

	$status = $wpdb->get_var( $wpdb->prepare( "SELECT count(*) FROM ".$wpdb->prefix."tg_user_mapping WHERE c_id = %d AND user_id = %d AND m_status	= %s", $course_id, get_current_user_id(), 'Active' ) );
	if( $status != 1 ){
		return array( 'status' => false, 'msg' => __( 'You are not assigned to the course!', 'teachground' ) );
	}
	// if here then user is assigned to the course
	$rule_status = tg_check_course_rules( $course_id );
	if( $rule_status['status'] == true ){
		return array( 'status' => true ); 
	} else {
		return array( 'status' => false, 'msg' => $rule_status['msg'] ); 
	}
}


/*
* check if current user is assigned to the course
* accepts - course id
* returns - true/ false
*/
function tg_is_current_user_assigned_to_am( $am_id = '' ){
	global $wpdb, $post;
	if( !is_user_logged_in() ){
		return false;
	}
	if( empty( $am_id ) ){
		return false;
	}
	$status = $wpdb->get_var( $wpdb->prepare( "SELECT count(*) FROM ".$wpdb->prefix."tg_am_user_mapping WHERE am_id = %d AND user_id = %d AND m_status	= %s", $am_id, get_current_user_id(), 'Active' ) );
	if( $status != 1 ){
		return false;
	}
	// if here then user is assigned to the access management
	return true;
}

/*
* check if course has rules
* accepts - course id
* returns - array
*/
function tg_does_course_has_rules( $course = '' ){
	global $post;
	if(!$course){
		return array( 'status' => false, 'msg' => __( 'Course id not found!', 'teachground' ) ); 
	}
	$rule_status = tg_check_course_rules( $course->ID );
	if( $rule_status['status'] == true ){
		return array( 'status' => true ); 
	} else {
		return array( 'status' => false, 'msg' => $rule_status['msg'] ); 
	}
}

/*
* check other mark as completed validations 
* accepts - user id, lesson id
* returns - array
*/
function tg_other_lesson_marked_as_completed_validations( $user_id = '', $lesson_id = '' ){
	global $wpdb;
	if( !$user_id ){
		return array( 'status' => false, 'msg' => __( 'User id not found!', 'teachground' ) );
	}
	if( !$lesson_id ){
		return array( 'status' => false, 'msg' => __( 'Lesson id not found!', 'teachground' ) );
	}
	$enable_forminator = get_post_meta( $lesson_id, 'enable_forminator', true );
	$video_url = get_post_meta( $lesson_id, 'video_url', true );
	$video_minimum_percentage = (int)get_post_meta( $lesson_id, 'video_minimum_percentage', true );
	
	if($enable_forminator == 'yes'){
		return forminator_tg_validation( $user_id, $lesson_id );
	}
	
	if($video_url != '' and $video_minimum_percentage > 0){
		return videos_tg_validation( $user_id, $lesson_id );
	}
	
	return apply_filters( 'tg_other_lesson_marked_as_completed_validations', array( 'status' => true, 'msg' => __( 'No need to check.', 'teachground' ) ), $user_id, $lesson_id );
	
}

/*
* check if lesson can be marked as completed if videos is enabled
* accepts - user id, lesson id
* returns - array
*/
function videos_tg_validation( $user_id = '', $lesson_id = '' ){
	global $wpdb;
	if( !$user_id ){
		return array( 'status' => false, 'msg' => __( 'User id not found!', 'teachground' ) );
	}
	if( !$lesson_id ){
		return array( 'status' => false, 'msg' => __( 'Lesson id not found!', 'teachground' ) );
	}
	
	$video_url = get_post_meta( $lesson_id, 'video_url', true );
	$video_minimum_percentage = (int)get_post_meta( $lesson_id, 'video_minimum_percentage', true );
	if($video_url == '' or $video_minimum_percentage == 0){
		return array( 'status' => true, 'msg' => __( 'No need to check.', 'teachground' ) );
	}
	
	$video_type = tg_video_type( $video_url );
	if($video_type == 'youtube'){
		return youtube_tg_validation($user_id, $lesson_id);
	} elseif($video_type == 'vimeo'){
		return vimeo_tg_validation($user_id, $lesson_id);
	} else {
		return array( 'status' => false, 'msg' => __( 'Unexpected error!', 'teachground' ) );
	}
}

/*
* check if lesson can be marked as completed if videos youtube is enabled
* accepts - user id, lesson id
* returns - array
*/
function youtube_tg_validation( $user_id = '', $lesson_id = '' ){
	global $wpdb;
	if( !$user_id ){
		return array( 'status' => false, 'msg' => __( 'User id not found!', 'teachground' ) );
	}
	if( !$lesson_id ){
		return array( 'status' => false, 'msg' => __( 'Lesson id not found!', 'teachground' ) );
	}
	
	$video_url = get_post_meta( $lesson_id, 'video_url', true );
	$video_minimum_percentage = (int)get_post_meta( $lesson_id, 'video_minimum_percentage', true );
	if($video_url == '' or $video_minimum_percentage == 0){
		return array( 'status' => true, 'msg' => __( 'No need to check.', 'teachground' ) );
	}
	
	// get entry data 
	$entry_id = $wpdb->get_var( $wpdb->prepare( "SELECT log_id FROM ".$wpdb->prefix."tg_youtube_data WHERE user_id = %d AND l_id = %d ORDER BY log_id DESC LIMIT 1", $user_id, $lesson_id ) );
	if( $entry_id ){
		return array( 'status' => true, 'msg' => __( 'Video threshold reached.', 'teachground' ) );
	} else {
		return array( 'status' => false, 'msg' => sprintf( __( '%s video must be watched', 'teachground' ), $video_minimum_percentage . '%' ) );
	}
}

/*
* check if lesson can be marked as completed if videos vimeo is enabled
* accepts - user id, lesson id
* returns - array
*/
function vimeo_tg_validation( $user_id = '', $lesson_id = '' ){
	global $wpdb;
	if( !$user_id ){
		return array( 'status' => false, 'msg' => __( 'User id not found!', 'teachground' ) );
	}
	if( !$lesson_id ){
		return array( 'status' => false, 'msg' => __( 'Lesson id not found!', 'teachground' ) );
	}
	
	$video_url = get_post_meta( $lesson_id, 'video_url', true );
	$video_minimum_percentage = (int)get_post_meta( $lesson_id, 'video_minimum_percentage', true );
	if($video_url == '' or $video_minimum_percentage == 0){
		return array( 'status' => true, 'msg' => __( 'No need to check.', 'teachground' ) );
	}
	
	// get entry data 
	$entry_id = $wpdb->get_var( $wpdb->prepare( "SELECT log_id FROM ".$wpdb->prefix."tg_vimeo_data WHERE user_id = %d AND l_id = %d ORDER BY log_id DESC LIMIT 1", $user_id, $lesson_id ) );
	if( $entry_id ){
		return array( 'status' => true, 'msg' => __( 'Video threshold reached.', 'teachground' ) );
	} else {
		return array( 'status' => false, 'msg' => sprintf( __( '%s video must be watched', 'teachground' ), $video_minimum_percentage . '%' ) );
	}
}

/*
* check if lesson can be marked as completed if formanitor is enabled
* accepts - user id, lesson id
* returns - array
*/
function forminator_tg_validation_pre_submit( $user_id = '', $lesson_id = '' ){
	global $wpdb;
	if( !$user_id ){
		return array( 'status' => false, 'msg' => __( 'User id not found!', 'teachground' ) );
	}
	if( !$lesson_id ){
		return array( 'status' => false, 'msg' => __( 'Lesson id not found!', 'teachground' ) );
	}
	$enable_forminator = get_post_meta( $lesson_id, 'enable_forminator', true );
	
	if($enable_forminator != 'yes'){
		return array( 'status' => true, 'msg' => __( 'No need to check. User can submit the form', 'teachground' ) );
	}
	
	$forminator_frm_type = get_post_meta( $lesson_id, 'forminator_frm_type', true );
	if($forminator_frm_type == 'quiz'){
		$entry_id = $wpdb->get_var( $wpdb->prepare( "SELECT entry_id FROM ".$wpdb->prefix."tg_frmt_quiz_data WHERE user_id = %d AND l_id = %d ORDER BY log_id DESC", $user_id, $lesson_id ) );
		if( !$entry_id ){
			return array( 'status' => false, 'msg' => __( 'You need to complete the quiz in order to mark this lesson complete.', 'teachground' ) );
		} else {
			return array( 'status' => true, 'msg' => __( 'User can submit the form', 'teachground' ) );
		}
	} elseif($forminator_frm_type == 'form'){
		$entry_id = $wpdb->get_var( $wpdb->prepare( "SELECT entry_id FROM ".$wpdb->prefix."tg_frmt_form_data WHERE user_id = %d AND l_id = %d ORDER BY log_id DESC", $user_id, $lesson_id ) );
		if( !$entry_id ){
			return array( 'status' => false, 'msg' => __( 'You need to submit the form in order to mark this lesson complete', 'teachground' ) );
		}else {
			return array( 'status' => true, 'msg' => __( 'User can submit the form', 'teachground' ) );
		}
	} else {
		return array( 'status' => false, 'msg' => __( 'Unexpected error!', 'teachground' ) );
	}
}

/*
* check if lesson can be marked as completed if formanitor is enabled
* accepts - user id, lesson id
* returns - array
*/
function forminator_tg_validation( $user_id = '', $lesson_id = '' ){
	global $wpdb;
	if( !$user_id ){
		return array( 'status' => false, 'msg' => __( 'User id not found!', 'teachground' ) );
	}
	if( !$lesson_id ){
		return array( 'status' => false, 'msg' => __( 'Lesson id not found!', 'teachground' ) );
	}
	$enable_forminator = get_post_meta( $lesson_id, 'enable_forminator', true );
	
	if($enable_forminator != 'yes'){
		return array( 'status' => true, 'msg' => __( 'No need to check.', 'teachground' ) );
	}
	
	$forminator_frm_type = get_post_meta( $lesson_id, 'forminator_frm_type', true );
	if($forminator_frm_type == 'quiz'){
		return forminator_tg_quiz_validation($user_id,$lesson_id);
	} elseif($forminator_frm_type == 'form'){
		return forminator_tg_form_validation($user_id,$lesson_id);
	} else {
		return array( 'status' => false, 'msg' => __( 'Unexpected error!', 'teachground' ) );
	}
}

/*
* check if lesson can be marked as completed if formanitor quiz is enabled
* accepts - user id, lesson id
* returns - array
*/
function forminator_tg_quiz_validation( $user_id = '', $lesson_id = '' ){
	global $wpdb;
	if( !$user_id ){
		return array( 'status' => false, 'msg' => __( 'User id not found!', 'teachground' ) );
	}
	if( !$lesson_id ){
		return array( 'status' => false, 'msg' => __( 'Lesson id not found!', 'teachground' ) );
	}
	$enable_forminator = get_post_meta( $lesson_id, 'enable_forminator', true );
	
	if($enable_forminator != 'yes'){
		return array( 'status' => true, 'msg' => __( 'No need to check.', 'teachground' ) );
	}
	
	// get last entry id 
	$entry_id = $wpdb->get_var( $wpdb->prepare( "SELECT entry_id FROM ".$wpdb->prefix."tg_frmt_quiz_data WHERE user_id = %d AND l_id = %d ORDER BY log_id DESC", $user_id, $lesson_id ) );
	if( !$entry_id ){
		return array( 'status' => false, 'msg' => __( 'You need to complete the quiz in order to mark this lesson complete.', 'teachground' ) );
	}	
	
	// get last submit data 
	$quiz_result_data = $wpdb->get_var( $wpdb->prepare( "SELECT meta_value FROM ".$wpdb->prefix."frmt_form_entry_meta WHERE entry_id = %d", $entry_id ) );
	if( !$quiz_result_data ){
		return array( 'status' => false, 'msg' => __( 'You need to complete the quiz in order to mark this lesson complete.', 'teachground' ) );
	}
	
	$quiz_result_data_array = unserialize($quiz_result_data);
	
	if(!$quiz_result_data_array){
		return array( 'status' => false, 'msg' => __( 'You need to complete the quiz in order to mark this lesson complete.', 'teachground' ) );
	}
	
	$correct = 0;
	$questions = count( $quiz_result_data_array );
	
	if( is_array($quiz_result_data_array) ){
		foreach( $quiz_result_data_array as $key => $value ){
			if( $value['isCorrect'] == 1 ){
				$correct++;
			}
		}
	}
	
	$forminator_quiz_minimum_percentage = (int)get_post_meta( $lesson_id, 'forminator_quiz_minimum_percentage', true );
	
	if( $correct == 0 ){
		return array( 'status' => false, 'msg' => sprintf( __( '%s completed at least %s required!', 'teachground' ), '0%', $forminator_quiz_minimum_percentage . '%' ) );
	}
	
	$correct_percentage = round( ( $correct / $questions ) * 100 );
	if( $correct_percentage < $forminator_quiz_minimum_percentage ){
		return array( 'status' => false, 'msg' => sprintf( __( '%s completed at least %s required!', 'teachground' ), $correct_percentage . '%', $forminator_quiz_minimum_percentage . '%' ) );
	}

	return array( 'status' => true, 'msg' => __( 'Quiz completed successfully', 'teachground' ) );
}

/*
* check if lesson can be marked as completed if formanitor form is enabled
* accepts - user id, lesson id
* returns - array
*/
function forminator_tg_form_validation( $user_id = '', $lesson_id = '' ){
	global $wpdb;
	if( !$user_id ){
		return array( 'status' => false, 'msg' => __( 'User id not found!', 'teachground' ) );
	}
	if( !$lesson_id ){
		return array( 'status' => false, 'msg' => __( 'Lesson id not found!', 'teachground' ) );
	}
	$enable_forminator = get_post_meta( $lesson_id, 'enable_forminator', true );
	
	if($enable_forminator != 'yes'){
		return array( 'status' => true, 'msg' => __( 'No need to check.', 'teachground' ) );
	}
	
	// get last entry id 
	$entry_id = $wpdb->get_var( $wpdb->prepare( "SELECT entry_id FROM ".$wpdb->prefix."tg_frmt_form_data WHERE user_id = %d AND l_id = %d ORDER BY log_id DESC", $user_id, $lesson_id ) );
	if( !$entry_id ){
		return array( 'status' => false, 'msg' => __( 'You need to submit the form in order to mark this lesson complete', 'teachground' ) );
	}	
	
	return array( 'status' => true, 'msg' => __( 'Form submitted successfully', 'teachground' ) );
}

/*
* get courses assigned to user
* accepts - none
* returns - array
*/
function tg_get_user_courses(){
	global $wpdb;
	if( !is_user_logged_in() ){
		return array( 'status' => false, 'msg' => __( 'Please login to view course!', 'teachground' ) );
	}
	$results = $wpdb->get_results( $wpdb->prepare( "SELECT c_id FROM ".$wpdb->prefix."tg_user_mapping WHERE user_id = %d AND m_status = %s", get_current_user_id(), 'Active' ) );
	if( $results ){
		$course_ids = [];
		if( is_array( $results ) ){
			foreach( $results as $key => $value ){
				$course_ids[] = $value->c_id;
			}
		}
		return array( 'status' => true, 'data' => $course_ids, 'msg' => __( 'Courses found for the user', 'teachground' ) );
	} else {
		return array( 'status' => false, 'msg' => __( 'No courses assigned to you!', 'teachground' ) );
	}
}

/*
* check if admins global access is enabled
* accepts - NA
* returns - true/ false
*/
function tg_is_global_admin_access_enabled(){
	if(!is_user_logged_in()){
		return false;
	}
	if( current_user_can('administrator') and get_option('tg_global_admin_access') == 'Yes') {
		return true;
	} else{
		return false;
	}
}


/*
* check if current user is assigned to the lesson
* accepts - lesson id
* returns - array
*/
function tg_is_current_user_assigned_to_lesson( $lesson_id = '' ){
	global $wpdb, $post;
	if( empty( $lesson_id ) ){
		$lesson_id = $post->ID;
	}
	$courses = tg_get_courses_which_has_this_lesson( $lesson_id );
	if( !$courses ){
		return array( 'status' => false, 'msg' => __( 'Lesson not assigned to any course!', 'teachground' ) );
	}

	if(tg_is_global_admin_access_enabled()){
		return array( 'status' => true ); 
	}
	
	if(is_course_free($courses[0])){
		return array( 'status' => true ); 
	}

	if(is_lesson_free($lesson_id)){
		return array( 'status' => true ); 
	}

	if( !is_user_logged_in() ){
		return array( 'status' => false, 'msg' => __( 'Please login to view lesson!', 'teachground' ) );
	}

	$am_status = false;
	if( is_array( $courses ) ){
		foreach( $courses as $key => $value ){
			$am_ids = tg_get_ams_which_has_this_course( $value );
			if(is_array($am_ids)){
				foreach( $am_ids as $key => $value ){
					$status = tg_is_current_user_assigned_to_am( $value );
					if( $status == true ){
						$am_status = true;
					}
				}
			}
		}
	}
	
	if( $am_status == false ){
		return array( 'status' => false, 'msg' => __( 'You are not assigned!', 'teachground' ) );
	}

	if( is_array( $courses ) ){
		foreach( $courses as $key => $value ){
			$status = tg_is_current_user_assigned_to_course( $value );
			if( $status['status'] == true ){ // we got a course that this user has permission 
				$rule_status = tg_check_current_user_lesson_rules( $lesson_id );
				if( $rule_status['status'] == true ){
					$delay_status = tg_check_current_user_lesson_delay( $lesson_id );
					if( $delay_status['status'] == true ){
						return array( 'status' => true ); 
					} else {
						return array( 'status' => false, 'msg' => $delay_status['msg'] ); 
					}
				} else {
					return array( 'status' => false, 'msg' => $rule_status['msg'] ); 
				}
			} else {
				return array( 'status' => false, 'msg' => $status['msg'] ); 
			}
		}
	}
	
	return array( 'status' => false, 'msg' => __( 'You are not assigned to the lesson!', 'teachground' ) ); 
}

/*
* check if current user is assigned to the post
* accepts - post id
* returns - array
*/
function tg_is_current_user_assigned_to_post( $post_id = '' ){
	global $wpdb, $post;
	$am_status = false;

	$am_ids = tg_get_ams_which_has_this_post( $post_id );
	if( is_array($am_ids) and count($am_ids) ){
		foreach( $am_ids as $key => $value ){
			$status = tg_is_current_user_assigned_to_am( $value );
			if( $status == true ){
				$am_status = true;
			}
		}
	} else {
		return array( 'status' => true, 'msg' => __( 'You are assigned to the post!', 'teachground' ) ); 
	}

	if( $am_status == false ){
		return array( 'status' => false, 'msg' => __( 'You are not assigned!', 'teachground' ) );
	}
	
	return array( 'status' => true, 'msg' => __( 'You are assigned to the post!', 'teachground' ) ); 
}

/*
* check if there is delay in lesson display for current user
* accepts - lesson id
* returns - array
*/
function tg_check_current_user_lesson_delay( $lesson_id = '' ){
	global $wpdb;
	if( !is_user_logged_in() ){
		return array( 'status' => false, 'msg' => __( 'Please login!', 'teachground' ) );
	}
	if( empty( $lesson_id ) ){
		return array( 'status' => false, 'msg' => __( 'Lesson not found!', 'teachground' ) ); 
	}
	$course_id = tg_get_probable_course_id_from_lesson_id( $lesson_id );
	if( !$course_id ){
		return array( 'status' => false, 'msg' => __( 'Lesson not mapped to any course!', 'teachground' ) ); 
	}

	$delay_type = tg_get_lesson_delay_type( $course_id, $lesson_id );
	if($delay_type === false){
		return array( 'status' => false, 'msg' => __( 'Unexpected error!', 'teachground' ) ); 
	}

	if($delay_type == 'days'){
		$delay = tg_get_lesson_delay( $course_id, $lesson_id );
		if( $delay === false ){
			return array( 'status' => false, 'msg' => __( 'Error!', 'teachground' ) ); 
		}
		if( $delay == 0 ){
			return array( 'status' => true, 'msg' => __( 'Lesson has no delay', 'teachground' ) ); 
		} else {
			$added_on = tg_get_user_assign_date( $course_id, get_current_user_id() );
			if( $added_on === false ){
				return array( 'status' => false, 'msg' => __( 'Error!', 'teachground' ) ); 
			}
			$current_time_in_sec = strtotime( date("Y-m-d H:i:s") );
			$added_on = date( "Y-m-d 12:00:00", strtotime( $added_on ) ); // 12 am
			$added_on_in_sec = strtotime( $added_on );
			$add_in_sec = $delay * 60 * 60 * 24;
			$total_wait_time_in_sec = $added_on_in_sec + $add_in_sec;
			if( $total_wait_time_in_sec > $current_time_in_sec ){ // wait
				$time_data = tg_time_remain( date("Y-m-d H:i:s"), date("Y-m-d H:i:s",$total_wait_time_in_sec ) );
				$time_remain = sprintf( __( 'Lesson will be available %s Days %s Hours %s Minutes later', 'teachground' ), $time_data['days'], $time_data['hours'], $time_data['minutes'] );
				return array( 'status' => false, 'msg' => $time_remain, 'delay_in_days' => $time_data['days'] ); 
			} else {
				return array( 'status' => true, 'msg' => __( 'Lesson is available.', 'teachground' ) ); 
			}
		}
	} else if($delay_type == 'date'){
		$delay_date = tg_get_lesson_delay_date( $course_id, $lesson_id );
		if( $delay_date === false ){
			return array( 'status' => false, 'msg' => __( 'Error!', 'teachground' ) ); 
		}
		if($delay_date == ''){
			return array( 'status' => true, 'msg' => __( 'Lesson has no delay', 'teachground' ) );
		} else {
			$current_time_in_sec = strtotime( date("Y-m-d H:i:s") );
			$delay_date = date( "Y-m-d 12:00:00", strtotime( $delay_date ) ); // 12 am
			$delay_date_in_sec = strtotime( $delay_date );
			
			if( $delay_date_in_sec > $current_time_in_sec ){ // wait
				$time_data = tg_time_remain( date("Y-m-d H:i:s"), date("Y-m-d H:i:s",$delay_date_in_sec ) );
				//$time_remain = sprintf( __( 'Lesson will be available %s Days %s Hours %s Minutes later', 'teachground' ), $time_data['days'], $time_data['hours'], $time_data['minutes'] );
				$time_remain = sprintf( __( 'Lesson will be available on %s', 'teachground' ), $delay_date );
				return array( 'status' => false, 'msg' => $time_remain, 'delay_in_days' => $time_data['days'] ); 
			} else {
				return array( 'status' => true, 'msg' => __( 'Lesson is available.', 'teachground' ) ); 
			}
		}
	} else {
		return array( 'status' => true, 'msg' => __( 'Lesson has no delay', 'teachground' ) );	
	}
}

/*
* get lesson delay based on current user
* accepts - lesson id
* returns - array
*/
function tg_get_current_user_lesson_delay( $lesson_id = '' ){
	global $wpdb;
	if( !is_user_logged_in() ){
		return array( 'status' => false );
	}
	if( empty( $lesson_id ) ){
		return array( 'status' => false );
	}
	$course_id = tg_get_probable_course_id_from_lesson_id( $lesson_id );
	if( !$course_id ){
		return array( 'status' => false );
	}

	$delay_type = tg_get_lesson_delay_type( $course_id, $lesson_id );
	if($delay_type === false){
		return array( 'status' => false );
	}

	if($delay_type == 'days'){
		$delay = tg_get_lesson_delay( $course_id, $lesson_id );
		if( $delay === false ){
			return array( 'status' => false );
		}
		if( $delay == 0 ){
			return array( 'status' => false );
		} else {
			$added_on = tg_get_user_assign_date( $course_id, get_current_user_id() );
			if( $added_on === false ){
				return array( 'status' => false );
			}
			$current_time_in_sec = strtotime( date("Y-m-d H:i:s") );
			$added_on = date( "Y-m-d 12:00:00", strtotime( $added_on ) ); // 12 am
			$added_on_in_sec = strtotime( $added_on );
			$add_in_sec = $delay * 60 * 60 * 24;
			$total_wait_time_in_sec = $added_on_in_sec + $add_in_sec;
			if( $total_wait_time_in_sec > $current_time_in_sec ){ // wait
				$time_data = tg_time_remain( date("Y-m-d H:i:s"), date("Y-m-d H:i:s",$total_wait_time_in_sec ) );
				$time_remain = $time_data['days'];
				return array( 'status' => true, 'msg' => $time_remain ); 
			} else {
				return;
			}
		}
	} else if($delay_type == 'date'){
		$delay_date = tg_get_lesson_delay_date( $course_id, $lesson_id );
		
		if($delay_date == ''){
			return array( 'status' => false );
		} else {
			$current_time_in_sec = strtotime( date("Y-m-d H:i:s") );
			$delay_date = date( "Y-m-d 12:00:00", strtotime( $delay_date ) ); // 12 am
			$delay_date_in_sec = strtotime( $delay_date );
			
			if( $delay_date_in_sec > $current_time_in_sec ){ // wait
				$time_data = tg_time_remain( date("Y-m-d H:i:s"), date("Y-m-d H:i:s",$delay_date_in_sec ) );
				$time_remain = $time_data['days'];
				return array( 'status' => true, 'msg' => $time_remain ); 
			} else {
				return array( 'status' => false );
			}
		}
	
	} else {
		return array( 'status' => false );
	}
}

/*
* get lesson delay type
* accepts - course id, lesson id
* returns - day / date
*/
function tg_get_lesson_delay_type( $course_id = '', $lesson_id = ''){
	global $wpdb;
	if( empty( $lesson_id ) or empty( $course_id ) ){
		return false;
	}
	$delay_type = $wpdb->get_var( $wpdb->prepare( "SELECT l_delay_type FROM ".$wpdb->prefix."tg_lesson_mapping WHERE c_id = %d AND l_id = %d AND m_type = %s ORDER BY m_order", $course_id, $lesson_id, 'lesson' ) );
	return $delay_type;
}

/*
* get lesson delay in days
* accepts - course id, lesson id
* returns - false / int
*/
function tg_get_lesson_delay( $course_id = '', $lesson_id = ''){
	global $wpdb;
	if( empty( $lesson_id ) or empty( $course_id ) ){
		return false;
	}
	$delay = $wpdb->get_var( $wpdb->prepare( "SELECT l_delay FROM ".$wpdb->prefix."tg_lesson_mapping WHERE c_id = %d AND l_id = %d AND m_type = %s ORDER BY m_order", $course_id, $lesson_id, 'lesson' ) );
	$delay = (int)$delay;
	return $delay;
}

/*
* get lesson delay in date
* accepts - course id, lesson id
* returns - false / date
*/
function tg_get_lesson_delay_date( $course_id = '', $lesson_id = ''){
	global $wpdb;
	if( empty( $lesson_id ) or empty( $course_id ) ){
		return false;
	}
	$delay_date = $wpdb->get_var( $wpdb->prepare( "SELECT l_delay_date FROM ".$wpdb->prefix."tg_lesson_mapping WHERE c_id = %d AND l_id = %d AND m_type = %s ORDER BY m_order", $course_id, $lesson_id, 'lesson' ) );
	return $delay_date;
}

/*
* get user assigned date of a course days
* accepts - course id, user id
* returns - false / date
*/
function tg_get_user_assign_date( $course_id = '', $user_id = ''){
	global $wpdb;
	if( empty( $course_id ) or empty( $user_id ) ){
		return false;
	}
	$added_on = $wpdb->get_var( $wpdb->prepare( "SELECT added_on FROM ".$wpdb->prefix."tg_user_mapping WHERE c_id = %d AND user_id = %d AND m_status = %s", $course_id, $user_id, 'Active' ) );
	if( $added_on ){
		return $added_on;
	} else {
		return false;
	}
}

/*
* restrict lesson based on assigned rules for current user
* accepts - lesson id
* returns - array
*/
function tg_check_current_user_lesson_rules( $lesson_id = '' ){
	global $wpdb;
	if( !is_user_logged_in() ){
		return array( 'status' => false, 'msg' => __( 'Please login!', 'teachground' ) );
	}
	if( empty( $lesson_id ) ){
		return array( 'status' => false, 'msg' => __( 'Lesson not found!', 'teachground' ) ); 
	}
	$course_id = tg_get_probable_course_id_from_lesson_id( $lesson_id );
	if( !$course_id ){
		return array( 'status' => false, 'msg' => __( 'Lesson not mapped to any course!', 'teachground' ) ); 
	}

	// check if course progress is disabled
	if ( is_course_progress_disabled( $lesson_id ) ) {
		return array( 'status' => true, 'msg' => __( 'Course progress is disabled.', 'teachground' ) ); 
	}
	
	// check if global rule is disabled 
	if( tg_is_lesson_start_global_rule_exists( $course_id ) ){
		return array( 'status' => true, 'msg' => __( 'Rules are disabled in access management level.', 'teachground' ) ); 
	}
	
	$lesson_one_by_one = get_post_meta($course_id, 'lesson_one_by_one', true);
	if( $lesson_one_by_one == 'Yes' ){
		$prev_lesson_id = tg_get_prev_lesson_id();
		if( $prev_lesson_id == false ){
			return array( 'status' => true, 'msg' => __( 'This is the first lesson.', 'teachground' ) ); 
		} else {
			if( tg_is_lesson_marked_as_completed( get_current_user_id(), $prev_lesson_id ) ){
				return array( 'status' => true, 'msg' => __( 'Previous lesson is completed.', 'teachground' ) ); 
			} else {
				$prev_lesson = tg_get_prev_lesson_link();
				return array( 'status' => false, 'msg' => sprintf( __( 'Please complete <a href="%s">%s</a> to start this lesson!', 'teachground' ), $prev_lesson['link'], $prev_lesson['title'] ) ); 
			}
		}
	} else {
		$results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM ".$wpdb->prefix."tg_lesson_start_rules WHERE c_id = %d AND s_l_id = %d", $course_id, $lesson_id ), OBJECT );
		if( !$results ){
			return array( 'status' => true, 'msg' => __( 'No rules are assigned!', 'teachground' ) ); 
		}
		$lessons_to_be_completed = [];
		if(is_array($results)){
			foreach($results as $key => $value){
				$lessons_to_be_completed[] = $value->f_l_id;
			}
		}
		if( count($lessons_to_be_completed) == 0 ){
			return array( 'status' => true, 'msg' => __( 'No rules are assigned!', 'teachground' ) ); 
		}
		$lesson_titles = [];
		$status = true;
		if( count($lessons_to_be_completed) != 0 ){
			if( is_array($lessons_to_be_completed) ){
				foreach( $lessons_to_be_completed as $key => $value ){
					if( !tg_is_lesson_marked_as_completed( get_current_user_id(), $value ) ){
						$lesson_titles[] = '<a href="'.get_permalink( $value ).'">'.get_the_title( $value ).'</a>';
						$status = false;
					}
				}
			}
		}
		if( $status ){
			return array( 'status' => true, 'msg' => __( 'Rules are verified', 'teachground' ) ); 
		} else {
			return array( 'status' => false, 'msg' => __('Please complete', 'teachground') . ' ' . implode(", ", $lesson_titles ) . ' ' . __('to start this lesson!','teachground')); 
		}
	}
}

/*
* restrict course based on assigned rules
* accepts - course id
* returns - array
*/
function tg_check_course_rules( $course_id = '' ){
	global $wpdb;
	if( empty( $course_id ) ){
		return array( 'status' => false, 'msg' => __( 'Course not found!', 'teachground' ) ); 
	}
	if( is_course_free($course_id) ){
		return array( 'status' => true );
	}
	if( !is_user_logged_in() ){
		return array( 'status' => false, 'msg' => __( 'Please login!', 'teachground' ) );
	}

	$results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM ".$wpdb->prefix."tg_course_start_rules WHERE s_c_id = %d", $course_id ), OBJECT );
	if( !$results ){
		return array( 'status' => true, 'msg' => __( 'No rules are assigned!', 'teachground' ) ); 
	}
	$courses_to_be_completed = [];
	if(is_array($results)){
		foreach($results as $key => $value){
			$courses_to_be_completed[] = $value->f_c_id;
		}
	}
	if( count($courses_to_be_completed) == 0 ){
		return array( 'status' => true, 'msg' => __( 'No rules are assigned!', 'teachground' ) ); 
	}
	$course_titles = [];
	$status = true;
	if( count($courses_to_be_completed) != 0 ){
		if( is_array($courses_to_be_completed) ){
			foreach( $courses_to_be_completed as $key => $value ){
				if( !tg_is_course_marked_as_completed( get_current_user_id(), $value ) ){
					$course_titles[] = '<a href="'.get_permalink( $value ).'">'.get_the_title( $value ).'</a>';
					$status = false;
				}
			}
		}
	}
	if( $status ){
		return array( 'status' => true, 'msg' => __( 'Rules are verified', 'teachground' ) ); 
	} else {
		return array( 'status' => false, 'msg' => __('Please complete','teachground') . ' ' . implode(", ", $course_titles ) . ' ' . __('to start this course!','teachground')); 
	}
}

/*
* get courses ids which has this lesson
* accepts - lesson id
* returns - false / course ids
*/
function tg_get_courses_which_has_this_lesson( $lesson_id = '' ){
	global $wpdb;
	if( empty( $lesson_id ) ){
		return false;
	}
	$cids = [];
	$course_ids = $wpdb->get_results( $wpdb->prepare( "SELECT c_id FROM ".$wpdb->prefix."tg_lesson_mapping WHERE l_id = %d AND m_type = %s GROUP BY c_id", $lesson_id, 'lesson' ), ARRAY_A );
	if( !$course_ids ){
		return false;
	} else {
		if( is_array($course_ids) ){
			foreach( $course_ids as $key => $value ){
				 $cids[] = $value['c_id'];
			}
			return $cids;
		}
	}
	return false;
}

/*
* get course id which has this lesson
* accepts - lesson id
* returns - false / course id
*/
function tg_get_probable_course_id_which_has_this_lesson( $lesson_id = '' ){
	global $wpdb;
	if( empty( $lesson_id ) ){
		return false;
	}
	$cids = [];
	$course_ids = $wpdb->get_results( $wpdb->prepare( "SELECT c_id FROM ".$wpdb->prefix."tg_lesson_mapping WHERE l_id = %d AND m_type = %s GROUP BY c_id", $lesson_id, 'lesson' ), ARRAY_A );
	if( !$course_ids ){
		return false;
	} else {
		if( is_array($course_ids) ){
			foreach( $course_ids as $key => $value ){
				 $cids[] = $value['c_id'];
			}
			return $cids[0];
		}
	}
	return false;
}

/*
* get access management ids which has this course
* accepts - course id
* returns - false / am ids
*/
function tg_get_ams_which_has_this_course( $course_id = '' ){
	global $wpdb;
	if( empty( $course_id ) ){
		return false;
	}
	$amids = [];
	$am_ids = $wpdb->get_results( $wpdb->prepare( "SELECT am_id FROM ".$wpdb->prefix."tg_course_mapping WHERE c_id = %d GROUP BY am_id", $course_id ), ARRAY_A );
	if( !$am_ids ){
		return false;
	} else {
		if( is_array($am_ids) ){
			foreach( $am_ids as $key => $value ){
				 $amids[] = $value['am_id'];
			}
			return $amids;
		}
	}
	return false;
}

/*
* get access management ids which has this post
* accepts - post id
* returns - false / am ids
*/
function tg_get_ams_which_has_this_post( $post_id = '' ){
	global $wpdb;
	if( empty( $post_id ) ){
		return false;
	}
	$amids = [];
	$am_ids = $wpdb->get_results( $wpdb->prepare( "SELECT am_id FROM ".$wpdb->prefix."tg_post_mapping WHERE p_id = %d GROUP BY am_id", $post_id ), ARRAY_A );
	if( !$am_ids ){
		return false;
	} else {
		if( is_array($am_ids) ){
			foreach( $am_ids as $key => $value ){
				 $amids[] = $value['am_id'];
			}
			return $amids;
		}
	}
	return false;
}

/*
* check if this access management already has this course
* accepts - am id, course id
* returns - true / false
*/
function tg_is_course_already_assigned_to_am( $am_id, $c_id ){
	global $wpdb;
	$m_id = $wpdb->get_var( $wpdb->prepare( "SELECT m_id FROM ".$wpdb->prefix."tg_course_mapping WHERE am_id = %d AND c_id = %d", $am_id, $c_id ) );
	if( $m_id ){
		return true;
	} else {
		return false;
	}
}

/*
* check if this access management already has this post
* accepts - am id, post id
* returns - true / false
*/
function tg_is_post_already_assigned_to_am( $am_id, $p_id ){
	global $wpdb;
	$m_id = $wpdb->get_var( $wpdb->prepare( "SELECT m_id FROM ".$wpdb->prefix."tg_post_mapping WHERE am_id = %d AND p_id = %d", $am_id, $p_id ) );
	if( $m_id ){
		return true;
	} else {
		return false;
	}
}

/*
* get lesson ids from course id
* accepts - course id
* returns - false / lesson ids
*/
function tg_get_lesson_ids_from_course_id( $course_id ){
	global $wpdb;
	if( empty( $course_id ) ){
		return false;
	}
	$lids = [];
	$lesson_ids = $wpdb->get_results( $wpdb->prepare( "SELECT l_id FROM ".$wpdb->prefix."tg_lesson_mapping WHERE c_id = %d AND m_type = %s GROUP BY l_id ORDER BY m_order", $course_id, 'lesson' ), ARRAY_A );
	if( !$lesson_ids ){
		return false;
	} else {
		if( is_array($lesson_ids) ){
			foreach( $lesson_ids as $key => $value ){
				 $lids[] = $value['l_id'];
			}
			return $lids;
		}
	}
	return false;
}

/*
* check if lesson is marked as completed 
* accepts - user id, lesson id
* returns - true / false
*/
function tg_is_lesson_marked_as_completed( $user_id = '', $lesson_id = '' ){
	global $wpdb;
	if( empty( $user_id ) or empty( $lesson_id ) ){
		return false;
	}
	$is_mapping_exists = $wpdb->get_var( $wpdb->prepare( "SELECT count(*) FROM ".$wpdb->prefix."tg_user_lesson_complete_mapping WHERE user_id = %d AND l_id = %d", $user_id, $lesson_id ) );
	if( $is_mapping_exists == 1 ){
		return true;
	} else {
		return false;
	}
}

/*
* check if course is completed 
* accepts - user id, course id
* returns - true / false
*/
function tg_is_course_marked_as_completed( $user_id = '', $course_id = '' ){
	global $wpdb;
	if( empty( $user_id ) or empty( $course_id ) ){
		return false;
	}
	$lesson_ids = tg_get_lesson_ids_from_course_id( $course_id );
	if( is_array( $lesson_ids ) ){
		foreach( $lesson_ids as $key => $value ){
			$status = tg_is_lesson_marked_as_completed( $user_id, $value );
			if( $status == false ){
				return false;
			}
		}
	} else {
		return false;
	}
	
	// if here then all lessons are completed by the user
	return true;
}

/*
* check if global lesson start rule is enabled
* accepts - course id
* returns - true / false
*/
function tg_is_lesson_start_global_rule_exists( $course_id = '' ){
	global $wpdb;
	if( empty( $course_id ) ){
		return false;
	}
	$is_exists = $wpdb->get_var( $wpdb->prepare( "SELECT count(*) FROM ".$wpdb->prefix."tg_lesson_start_rules_disabled WHERE c_id = %d", $course_id ) );
	if( $is_exists == 1 ){
		return true;
	} else {
		return false;
	}
}

/*
* check if global lesson start rule exists with access management id
* accepts - course id
* returns - true / false
*/
function tg_is_lesson_start_global_rule_exists_on_am( $course_id = '', $am_id = '' ){
	global $wpdb;
	if( empty( $course_id ) or empty($am_id) ){
		return false;
	}
	$is_exists = $wpdb->get_var( $wpdb->prepare( "SELECT count(*) FROM ".$wpdb->prefix."tg_lesson_start_rules_disabled WHERE c_id = %d AND am_id = %d", $course_id, $am_id ) );
	if( $is_exists == 1 ){
		return true;
	} else {
		return false;
	}
}

/*
* get probable course id from lesson id
* accepts - lesson id
* returns - false / course id
*/
function tg_get_probable_course_id_from_lesson_id( $lesson_id = '' ){
	global $wpdb, $post;
	if( empty( $lesson_id ) ){
		$lesson_id = $post->ID;
	}
	$current_user_course_ids = tg_get_courses_of_user();
	$courses = tg_get_courses_which_has_this_lesson( $lesson_id );
	$course_id = '';
	
	if( !$courses ){
		return false;
	} else {
		if( is_array( $courses ) ){
			foreach( $courses as $key => $value ){
				
				if( is_array($current_user_course_ids) and in_array($value, $current_user_course_ids) ){
					// we got a course id which has this lesson_id and assigned to current user
					$course_id = $value; 
					break;
				}
			}
		}
	}
	if( empty($course_id) ){
		return false;
	}

	return $course_id;
}

/*
* get next lesson id
* accepts - lesson id
* returns - false / next lesson id
*/
function tg_get_next_lesson_id( $lesson_id = '' ){
	global $wpdb, $post;
	if( empty( $lesson_id ) ){
		$lesson_id = $post->ID;
	}
	$current_user_course_ids = tg_get_courses_of_user();
	$courses = tg_get_courses_which_has_this_lesson( $lesson_id );
	$course_id = '';
	
	if( !$courses ){
		return false;
	} else {
		if( is_array( $courses ) ){
			foreach( $courses as $key => $value ){
				
				if( is_array($current_user_course_ids) and in_array($value, $current_user_course_ids) ){
					// we got a course id which has this lesson_id and assigned to current user
					$course_id = $value; 
					break;
				}
			}
		}
	}
	if( empty($course_id) ){
		return false;
	}
	$all_lessons = tg_get_lesson_ids_from_course_id( $course_id );
	$total_lessons = count( $all_lessons );
	$max_key = $total_lessons - 1;
	$current_lesson_key = array_search ( $lesson_id, $all_lessons );
	$next_lesson_id = '';
	
	if( $current_lesson_key == $max_key ){
		// this is the last lesson 
		// do nothing 
	} else {
		$next_lesson_id = $all_lessons[ $current_lesson_key + 1 ];
	}
	if( empty( $next_lesson_id )){
		return false;
	}
	
	return $next_lesson_id;
}

/*
* get next course id
* accepts - course id
* returns - false / next course id
*/
function tg_get_next_course_id( $course_id = '' ){
	global $wpdb, $post;
	if( empty( $course_id ) ){
		$course_id = $post->ID;
	}
	$current_user_access_ids = tg_get_accesses_of_user();
	$accesses = tg_get_ams_which_has_this_course( $course_id );
	$am_id = '';
	
	if( !$accesses ){
		return false;
	} else {
		if( is_array( $accesses ) ){
			foreach( $accesses as $key => $value ){
				
				if( is_array($current_user_access_ids) and in_array($value, $current_user_access_ids) ){
					// we got a access id which has this course id and assigned to current user
					$am_id = $value; 
					break;
				}
			}
		}
	}
	if( empty($am_id) ){
		return false;
	}

	$all_courses = tg_get_courses_from_am_id( $am_id );
	$total_courses = count( $all_courses );
	$max_key = $total_courses - 1;
	$current_course_key = array_search ( $course_id, $all_courses );
	$next_course_id = '';
	
	if( $current_course_key == $max_key ){
		// this is the last course
		// do nothing 
		return false;
	} else {
		$next_course_id = $all_courses[ $current_course_key + 1 ];
	}
	if( empty( $next_course_id )){
		return false;
	}
	
	return $next_course_id;
}

/*
* get prev lesson id
* accepts - lesson id
* returns - false / next lesson id
*/
function tg_get_prev_lesson_id( $lesson_id = '' ){
	global $wpdb, $post;
	if( empty( $lesson_id ) ){
		$lesson_id = $post->ID;
	}
	$current_user_course_ids = tg_get_courses_of_user();
	$courses = tg_get_courses_which_has_this_lesson( $lesson_id );
	$course_id = '';
	
	if( !$courses ){
		return false;
	} else {
		if( is_array( $courses ) ){
			foreach( $courses as $key => $value ){
				
				if( is_array($current_user_course_ids) and in_array($value, $current_user_course_ids) ){
					// we got a course id which has this lesson_id and assigned to current user
					$course_id = $value; 
					break;
				}
			}
		}
	}
	if( empty($course_id) ){
		return false;
	}
	$all_lessons = tg_get_lesson_ids_from_course_id( $course_id );
	$total_lessons = count( $all_lessons );
	$min_key = 0;
	$current_lesson_key = array_search ( $lesson_id, $all_lessons );
	$prev_lesson_id = '';
	
	if( $current_lesson_key == $min_key ){
		// this is the first lesson 
		// do nothing 
	} else {
		$prev_lesson_id = $all_lessons[ $current_lesson_key - 1 ];
	}
	if( empty( $prev_lesson_id )){
		return false;
	}
	
	return $prev_lesson_id;
}

/*
* get section name from lesson id
* accepts - lesson id
* returns - false / section name
*/
function tg_get_section_name_from_lesson_id( $lesson_id = '' ){
	global $wpdb;
	if( empty( $lesson_id )){
		return false;
	}
	$s_id = $wpdb->get_var( $wpdb->prepare( "SELECT s_id FROM ".$wpdb->prefix."tg_lesson_mapping WHERE l_id = %d", $lesson_id ) );
	if( $s_id ){
		return tg_get_section_name($s_id);
	} else {
		return false;
	}
}

/*
* get section name from section id
* accepts - section id
* returns - false / section name
*/
function tg_get_section_name( $s_id = '' ){
	global $wpdb;
	if( empty( $s_id )){
		return false;
	}
	$s_name = $wpdb->get_var( $wpdb->prepare( "SELECT s_name FROM ".$wpdb->prefix."tg_section WHERE s_id = %d", $s_id ) );
	if( $s_name ){
		return tg_removeslashes($s_name);
	} else {
		return false;
	}
}

/*
* get sections & lessons from course id
* accepts - course id
* returns - array
*/
function tg_get_lessons_from_course( $course_id = '' ){
	global $wpdb, $post;
	if( empty( $course_id ) ){
		$course_id = $post->ID;
	}
	$lessons = array();
	$results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM ".$wpdb->prefix."tg_lesson_mapping WHERE c_id = %d AND m_type = %s ORDER BY m_order", $course_id, 'section' ), OBJECT );
	
	$counter = 0;
	if(is_array($results)){
		foreach($results as $key => $value){
			$lessons[$counter] = array( 's_id' => array( 'id' => $value->s_id ) );
			
			$results1 = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM ".$wpdb->prefix."tg_lesson_mapping WHERE c_id = %d AND s_id = %d AND m_type = %s ORDER BY m_order", $course_id, $value->s_id, 'lesson' ), OBJECT );
			if(is_array($results1)){
				foreach($results1 as $key1 => $value1){
					$lessons[$counter]['s_id']['lessons'][] = $value1->l_id;
				}
			}
			$counter++;
		}
	}
	return $lessons; 
}

/*
* get lessons from course id
* accepts - course id
* returns - array
*/
function tg_get_only_lessons_from_course( $course_id = '' ){
	global $wpdb, $post;
	if( empty( $course_id ) ){
		$course_id = $post->ID;
	}
	$lessons = array();
	$results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM ".$wpdb->prefix."tg_lesson_mapping WHERE c_id = %d AND m_type = %s ORDER BY m_order", $course_id, 'lesson' ), OBJECT );
	if(is_array($results)){
		foreach($results as $key => $value){
			$lessons[] = $value->l_id;
		}
	}
	return $lessons; 
}

/*
* get section & lessons from section id
* accepts - section id
* returns - array
*/
function tg_get_lessons_from_section( $section_id = '' ){
	global $wpdb, $post;
	if( empty( $section_id ) ){
		return;
	}
	$lessons = array();
	$counter = 0;

	$lessons[$counter] = array( 's_id' => array( 'id' => $section_id ) );
			
	$results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM ".$wpdb->prefix."tg_lesson_mapping WHERE s_id = %d AND m_type = %s ORDER BY m_order", $section_id, 'lesson' ), OBJECT );
	if(is_array($results)){
		foreach($results as $key => $value){
			$lessons[$counter]['s_id']['lessons'][] = $value->l_id;
		}
	}
	return $lessons; 
}

/*
* get lesson completion data for current user ( % of course is completed )
* accepts - course id
* returns - array
*/
function tg_get_current_user_lesson_completion_data( $course_id = '' ){
	global $wpdb, $post;
	if( empty( $course_id ) ){
		$course_id = $post->ID;
	}
	$total_lessons = $lesson_complete_count = $course_complete_percent = 0;
	$lesson_ids = tg_get_lesson_ids_from_course_id( $course_id );
	if( $lesson_ids ){
		$l_ids = $qps = array();
		$qps[] = get_current_user_id();
		if( is_array( $lesson_ids ) ){
			foreach(  $lesson_ids as $key => $value ){
				$l_ids[] = $value;
				$qps[] 	 = $value;
			}
		}
		$total_lessons = count( $l_ids );
		$lesson_ids_in = implode( ',', $l_ids );
		$string_placeholders = array_fill(0, $total_lessons, '%s');
		$placeholders_for_lids = implode(', ', $string_placeholders);
		$query = "SELECT COUNT(*) FROM ".$wpdb->prefix."tg_user_lesson_complete_mapping WHERE user_id = %d AND l_id IN ($placeholders_for_lids)";
		$lesson_complete_count = $wpdb->get_var( $wpdb->prepare( $query, $qps ) );
	}
	if( $total_lessons ){
		$course_complete_percent = round( ( $lesson_complete_count / $total_lessons ) * 100 );
	}
	$return = array(
		'total_lessons' => $total_lessons,
		'total_lessons_completed' => $lesson_complete_count,
		'percentage' => $course_complete_percent,
	);
	return $return;
}

/*
* get lesson completion data from user ID ( % of course is completed )
* accepts - course id, user id
* returns - array
*/
function tg_get_user_lesson_completion_data( $course_id = '', $user_id = '' ){
	global $wpdb, $post;
	if( empty( $course_id ) ){
		$course_id = $post->ID;
	}
	if( empty( $user_id ) ){
		$user_id = get_current_user_id();
	}
	$total_lessons = $lesson_complete_count = $course_complete_percent = 0;
	$lesson_ids = tg_get_lesson_ids_from_course_id( $course_id );
	if( $lesson_ids ){
		$l_ids = $qps = array();
		$qps[] = $user_id;
		if( is_array( $lesson_ids ) ){
			foreach(  $lesson_ids as $key => $value ){
				$l_ids[] = $value;
				$qps[] 	 = $value;
			}
		}
		$total_lessons = count( $l_ids );
		$lesson_ids_in = implode( ',', $l_ids );
		$string_placeholders = array_fill(0, $total_lessons, '%s');
		$placeholders_for_lids = implode(', ', $string_placeholders);
		$query = "SELECT COUNT(*) FROM ".$wpdb->prefix."tg_user_lesson_complete_mapping WHERE user_id = %d AND l_id IN ($placeholders_for_lids)";
		$lesson_complete_count = $wpdb->get_var( $wpdb->prepare( $query, $qps ) );
	}
	if( $total_lessons ){
		$course_complete_percent = round( ( $lesson_complete_count / $total_lessons ) * 100 );
	}
	$return = array(
		'total_lessons' => $total_lessons,
		'total_lessons_completed' => $lesson_complete_count,
		'percentage' => $course_complete_percent,
	);
	return $return;
}

/*
* get course ids assigned to a particular user 
* accepts - user id
* returns - false / array
*/
function tg_get_courses_of_user( $user_id = '' ){
	global $wpdb;
	if( empty($user_id) ){
		if( is_user_logged_in() ){
			$user_id = get_current_user_id();
		} else {
			return false;
		}
	}
	$course_ids = [];
	$results = $wpdb->get_results( $wpdb->prepare( "SELECT c_id FROM ".$wpdb->prefix."tg_user_mapping WHERE user_id = %d AND m_status = %s", $user_id, 'Active' ), OBJECT );
	if(is_array($results)){
		foreach($results as $key => $value){
			$course_ids[] = $value->c_id;
		}
		return $course_ids;
	}
	return false;
}

/*
* get access ids assigned to a particular user 
* accepts - user id
* returns - false / array
*/
function tg_get_accesses_of_user( $user_id = '' ){
	global $wpdb;
	if( empty($user_id) ){
		if( is_user_logged_in() ){
			$user_id = get_current_user_id();
		} else {
			return false;
		}
	}
	$am_ids = [];
	$results = $wpdb->get_results( $wpdb->prepare( "SELECT am_id FROM ".$wpdb->prefix."tg_am_user_mapping WHERE user_id = %d AND m_status = %s", $user_id, 'Active' ), OBJECT );
	if(is_array($results)){
		foreach($results as $key => $value){
			$am_ids[] = $value->am_id;
		}
		return $am_ids;
	}
	return false;
}

/*
* get next lesson link 
* accepts - empty
* returns - false / array
*/
function tg_get_next_lesson_link(){
	$lesson_id = tg_get_next_lesson_id();
	if( $lesson_id ){
		return array( 'title' => get_the_title( $lesson_id ), 'link' => get_permalink( $lesson_id ) );
	} else {
		return false;
	}
}

/*
* get prev lesson link / course link  
* accepts - empty
* returns - false / array
*/
function tg_get_prev_lesson_link(){
	$lesson_id = tg_get_prev_lesson_id();
	if( $lesson_id ){
		return array( 'title' => get_the_title( $lesson_id ), 'link' => get_permalink( $lesson_id ) );
	} else {
		$course_id = tg_get_probable_course_id_from_lesson_id( $lesson_id );
		if( $course_id ){
			return array( 'title' => __( 'Go back to', 'teachground' ) . ' ' . get_the_title( $course_id ), 'link' => get_permalink( $course_id ) );
		} else {
			return false;
		}
	}
}

/*
* get lesson resource 
* accepts - lesson id 
* returns - false / array
*/
function tg_get_resource_data( $lesson_id = '' ){
	if( empty($lesson_id) ){
		return false;
	}
	global $wpdb;
	$results = [];
	$resources = $wpdb->get_results( $wpdb->prepare( "SELECT r_id, r_title, r_highlight FROM ".$wpdb->prefix."tg_resource_mapping WHERE l_id = %d", $lesson_id ), OBJECT );
	if(is_array($resources)){
		foreach($resources as $key => $value){
			if( $value->r_id == 0 ){
				$results[] = (object) array( 'r_id' => $value->r_id, 'title' => stripslashes( $value->r_title ), 'highlight' => $value->r_highlight );
			} else {
			
				// now check if this is a single resource 
				if(get_post_meta($value->r_id,'link_url',true) != ''){

					$results[] = (object) array( 'r_id' => $value->r_id, 'title' => get_the_title( $value->r_id ), 'link_url' => get_post_meta( $value->r_id, 'link_url', true ), 'link_open_in_new_tab' => get_post_meta( $value->r_id, 'link_open_in_new_tab', true ), 'link_nofollow' => get_post_meta( $value->r_id, 'link_nofollow', true ) );
				} else {
					$results[] = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM ".$wpdb->prefix."tg_resource WHERE post_id = %d", $value->r_id  ), OBJECT );
				}

			}
		}
	}
	if( !$results ){
		return false;
	}

	return $results;
}

/*
* get lesson ids from resource id 
* accepts - resource id 
* returns - false / array
*/
function tg_get_lesson_ids_from_resource_id( $resource_id = '' ){
	if( empty($resource_id) ){
		return false;
	}
	global $wpdb;
	$results = $wpdb->get_results( $wpdb->prepare( "SELECT l_id FROM ".$wpdb->prefix."tg_resource_mapping WHERE r_id = %d", $resource_id ), OBJECT );
	
	if( !$results ){
		return false;
	}

	$lesson_ids = array();
	if(is_array($results)){
		foreach($results as $value){
			$lesson_ids[] = $value->l_id;
		}
	}
	return $lesson_ids;
}

/*
* check if access assigned mail sent to user 
* accepts - access id, user id 
* returns - true / false
*/
function tg_is_am_assigned_mail_sent( $am_id = '', $user_id = '' ){
	if( empty($am_id) or empty($user_id) ){
		return false;
	}
	global $wpdb;
	$email_status = $wpdb->get_var( $wpdb->prepare( "SELECT ua_mail_status FROM ".$wpdb->prefix."tg_am_user_mapping WHERE am_id = %d AND user_id = %d", $am_id, $user_id ) );
	if($email_status == 'Sent'){
		return true;
	} else {
		return false;
	}
}

/*
* update access assigned mail sent status
* accepts - access id, user id, staus ( Sent/ Unsent )
* returns - true / false
*/
function tg_update_am_assigned_mail_sent_status( $am_id = '', $user_id = '', $status = 'Sent' ){
	if( empty($am_id) or empty($user_id) ){
		return false;
	}
	global $wpdb;
	$email_status = $wpdb->update( $wpdb->prefix."tg_am_user_mapping", array( 'ua_mail_status' => $status ), array( 'am_id' => $am_id, 'user_id' => $user_id ) );
	return true;
}

/*
* check if access unassigned mail sent to user 
* accepts - access id, user id 
* returns - true / false
*/
function tg_is_am_unassigned_mail_sent( $am_id = '', $user_id = '' ){
	if( empty($am_id) or empty($user_id) ){
		return false;
	}
	global $wpdb;
	$email_status = $wpdb->get_var( $wpdb->prepare( "SELECT uua_mail_status FROM ".$wpdb->prefix."tg_am_user_mapping WHERE am_id = %d AND user_id = %d", $am_id, $user_id ) );
	if($email_status == 'Sent'){
		return true;
	} else {
		return false;
	}
}

/*
* update access unassigned mail sent status
* accepts - access id, user id, staus ( Sent/ Unsent )
* returns - true / false
*/
function tg_update_am_unassigned_mail_sent_status( $am_id = '', $user_id = '', $status = 'Sent' ){
	if( empty($am_id) or empty($user_id) ){
		return false;
	}
	global $wpdb;
	$email_status = $wpdb->update( $wpdb->prefix."tg_am_user_mapping", array( 'uua_mail_status' => $status ), array( 'am_id' => $am_id, 'user_id' => $user_id ) );
	return true;
}

/*
* get resource icon URL
* accepts - url
* returns - icon URL
*/
function get_resource_icon( $url = '' ){
		global $tg_resource_icons;
		$ext = substr(strrchr($url,'.'),1);
		switch ($ext) {
			case 'jpg':
				$src = $tg_resource_icons['img']['small'];
				break;
			case 'jpeg':
				$src = $tg_resource_icons['img']['small'];
				break;
			case 'png':
				$src = $tg_resource_icons['img']['small'];
				break;
			case 'bmp':
				$src = $tg_resource_icons['img']['small'];
				break;
			case 'gif':
				$src = $tg_resource_icons['img']['small'];
				break;
			case 'doc':
				$src = $tg_resource_icons['doc']['small'];
				break;
			case 'docx':
				$src = $tg_resource_icons['doc']['small'];
				break;
			case 'xls':
				$src = $tg_resource_icons['xls']['small'];
				break;
			case 'xlsx':
				$src = $tg_resource_icons['xls']['small'];
				break;
			case 'ppt':
				$src = $tg_resource_icons['ppt']['small'];
				break;
			case 'pptx':
				$src = $tg_resource_icons['ppt']['small'];
				break;
			case 'csv':
				$src = $tg_resource_icons['csv']['small'];
				break;
			case 'zip':
				$src = $tg_resource_icons['zip']['small'];
				break;
			case 'txt':
				$src = $tg_resource_icons['txt']['small'];
				break;
			case 'htm':
				$src = $tg_resource_icons['html']['small'];
				break;
			case 'html':
				$src = $tg_resource_icons['html']['small'];
				break;	
			case 'pdf':
				$src = $tg_resource_icons['pdf']['small'];
				break;
			case 'link':
				$src = $tg_resource_icons['lnk']['small'];
				break;
			case 'mp4':
				$src = $tg_resource_icons['mp4']['small'];
				break;
			default:
				$src = $tg_resource_icons['oth']['small'];
		} 
		return $src;
	}

/*
* get resource icon Font Awsome
* accepts - url
* returns - icon HTML
*/	
function get_resource_icon_fa( $url = '' ){
	global $tg_resource_icons;
	$ext = substr(strrchr($url,'.'),1);
	switch ($ext) {
		case 'jpg':
			$fa_icon = $tg_resource_icons['img']['fa-icon'];
			break;
		case 'jpeg':
			$fa_icon = $tg_resource_icons['img']['fa-icon'];
			break;
		case 'png':
			$fa_icon = $tg_resource_icons['img']['fa-icon'];
			break;
		case 'bmp':
			$fa_icon = $tg_resource_icons['img']['fa-icon'];
			break;
		case 'gif':
			$fa_icon = $tg_resource_icons['img']['fa-icon'];
			break;
		case 'doc':
			$fa_icon = $tg_resource_icons['doc']['fa-icon'];
			break;
		case 'docx':
			$fa_icon = $tg_resource_icons['doc']['fa-icon'];
			break;
		case 'xls':
			$fa_icon = $tg_resource_icons['xls']['fa-icon'];
			break;
		case 'xlsx':
			$fa_icon = $tg_resource_icons['xls']['fa-icon'];
			break;
		case 'ppt':
			$fa_icon = $tg_resource_icons['ppt']['fa-icon'];
			break;
		case 'pptx':
			$fa_icon = $tg_resource_icons['ppt']['fa-icon'];
			break;
		case 'csv':
			$fa_icon = $tg_resource_icons['csv']['fa-icon'];
			break;
		case 'zip':
			$fa_icon = $tg_resource_icons['zip']['fa-icon'];
			break;
		case 'txt':
			$fa_icon = $tg_resource_icons['txt']['fa-icon'];
			break;
		case 'htm':
			$fa_icon = $tg_resource_icons['html']['fa-icon'];
			break;
		case 'html':
			$fa_icon = $tg_resource_icons['html']['fa-icon'];
			break;	
		case 'pdf':
			$fa_icon = $tg_resource_icons['pdf']['fa-icon'];
			break;
		case 'link':
			$fa_icon = $tg_resource_icons['lnk']['fa-icon'];
			break;
		case 'ext_link':
			$fa_icon = $tg_resource_icons['ext_lnk']['fa-icon'];
			break;
		case 'mp4':
			$fa_icon = $tg_resource_icons['mp4']['fa-icon'];
			break;
		default:
			$fa_icon = $tg_resource_icons['oth']['fa-icon'];
	} 
	return $fa_icon;
}	

/*
* send access assigned email to user 
* accepts - array
* returns - NA
*/	
function send_am_assigned_mail( $data ){
	
	$tg_from_email = get_option( 'tg_from_email' );
	$tg_from_name 	= get_option( 'tg_from_name' );
	
	$subject 	= get_post_meta($data['am_id'], 'tg_access_assign_subject', true);
	$body 		= get_post_meta($data['am_id'], 'tg_access_assign_body', true);
	
	$user_info = get_userdata($data['user_id']);
	
	$subject = str_replace( array( '#access_name#'), array( get_the_title($data['am_id'] ) ), $subject );

	$body = stripslashes($body);
	$body = html_entity_decode($body);
	$body = nl2br($body);
	$body = str_replace( array( '#display_name#', '#first_name#', '#last_name#', '#access_name#', '#user_email#', '#site_url#', '#reset_pass_url#', '#login_url#' ), array( $user_info->display_name, $user_info->first_name, $user_info->last_name, get_the_title($data['am_id'] ), $user_info->user_email, site_url(), tg_get_reset_password_url(), get_option('tg_login_url') ), $body );

	$body = tg_get_email_body( 'user_assigned.php', array( 'body' => $body ) );
	
	if( empty($tg_from_email) ){
		$tg_from_email = 'no-reply@wordpress.com';
	}
	if( empty($tg_from_name) ){
		$tg_from_name = 'TeachGround';
	}
	if( empty($subject) ){
		$subject = __( 'TeachGround - Access Assigned', 'teachground' );
	}
	$headers[] = "From: {$tg_from_name} <{$tg_from_email}>";
	
	$subject = apply_filters( 'tg_user_assign_email_subject', $subject );
	$to[] = $user_info->user_email;
	
	add_filter( 'wp_mail_content_type', 'tg_set_html_content_type' );
	
	if( get_post_meta($data['am_id'], 'enrolled_send_to_user', true) == 'yes' ){
		wp_mail( $to, $subject, $body, $headers );
	}
	
	// send email to admin //
	/*$subject_admin = get_option( 'tg_access_assign_subject_admin' );
	$to = get_option( 'tg_admin_email' );
	$body = get_post_meta($data['am_id'], 'tg_access_assign_body_admin', true); 
	
	if( empty($subject_admin) ){
		$subject_admin = __( 'TeachGround - Access Assigned', 'teachground' );
	}
	
	$body = stripslashes($body);
	$body = html_entity_decode($body);
	$body = nl2br($body);
	$body = str_replace( array( '#display_name#', '#access_name#', '#user_email#', '#site_url#', '#reset_pass_url#' ), array( $user_info->display_name, get_the_title($data['am_id'] ), $user_info->user_email, site_url(), tg_get_reset_password_url() ), $body );

	$body = tg_get_email_body( 'user_assigned_admin.php', array( 'body' => $body ) );
	
	if( get_post_meta($data['am_id'], 'enrolled_send_to_admin', true) == 'yes' ){
		wp_mail( $to, $subject_admin, $body, $headers );
	}*/
	// send email to admin //

	remove_filter( 'wp_mail_content_type', 'tg_set_html_content_type' );
	return;
	
}

/*
* send access unassigned email to user 
* accepts - array
* returns - NA
*/	
function send_am_unassigned_mail( $data ){
	
	$tg_from_email = get_option( 'tg_from_email' );
	$tg_from_name 	= get_option( 'tg_from_name' );
	
	$subject 	= get_post_meta($data['am_id'], 'tg_access_unassign_subject', true);
	$body 		= get_post_meta($data['am_id'], 'tg_access_unassign_body', true);

	$user_info = get_userdata($data['user_id']);
	
	$subject = str_replace( array( '#access_name#'), array( get_the_title($data['am_id'] ) ), $subject );
	
	$body = stripslashes($body);
	$body = html_entity_decode($body);
	$body = nl2br($body);
	$body = str_replace( array( '#display_name#', '#first_name#', '#last_name#', '#access_name#', '#user_email#', '#site_url#', '#reset_pass_url#', '#login_url#' ), array( $user_info->display_name, $user_info->first_name, $user_info->last_name, get_the_title($data['am_id'] ), $user_info->user_email, site_url(), tg_get_reset_password_url(), get_option('tg_login_url') ), $body );
	
	$body = tg_get_email_body( 'user_unassigned.php', array( 'body' => $body ) );
	
	if( empty($tg_from_email) ){
		$tg_from_email = 'no-reply@wordpress.com';
	}
	if( empty($tg_from_name) ){
		$tg_from_name = 'TeachGround';
	}
	if( empty($subject) ){
		$subject = __( 'TeachGround - Access Unassigned', 'teachground' );
	}
	$headers[] = "From: {$tg_from_name} <{$tg_from_email}>";

	$subject = apply_filters( 'tg_user_unassign_email_subject', $subject );
	$to[] = $user_info->user_email;
	
	add_filter( 'wp_mail_content_type', 'tg_set_html_content_type' );
	
	if( get_post_meta($data['am_id'], 'unenrolled_send_to_user', true) == 'yes' ){
		wp_mail( $to, $subject, $body, $headers );
	}
	
	// send email to admin //
	/*$subject_admin = get_option( 'tg_access_unassign_subject_admin' );
	$to = get_option( 'tg_admin_email' );
	$body = get_post_meta($data['am_id'], 'tg_access_unassign_body', true);
	
	if( empty($subject_admin) ){
		$subject_admin = __( 'TeachGround - Access Unassigned', 'teachground' );
	}
	
	$body = stripslashes($body);
	$body = html_entity_decode($body);
	$body = nl2br($body);
	$body = str_replace( array( '#display_name#', '#access_name#', '#user_email#', '#site_url#', '#reset_pass_url#' ), array( $user_info->display_name, get_the_title($data['am_id'] ), $user_info->user_email, site_url(), tg_get_reset_password_url() ), $body );
	
	$body = tg_get_email_body( 'user_unassigned_admin.php', array( 'body' => $body ) );
	
	if( get_post_meta($data['am_id'], 'unenrolled_send_to_admin', true) == 'yes' ){
		wp_mail( $to, $subject_admin, $body, $headers );
	}*/
	// send email to admin //
	
	remove_filter( 'wp_mail_content_type', 'tg_set_html_content_type' );
	return;
}

/*
* send account created email to user 
* accepts - user id
* returns - NA
*/	
function send_user_account_created_mail( $user_id ){
	
	$tg_from_email = get_option( 'tg_from_email' );
	$tg_from_name 	= get_option( 'tg_from_name' );
	$subject 		= get_option( 'tg_new_user_inserted_subject' );
	$body 			= get_option( 'tg_new_user_inserted_body' );

	$user_info = get_userdata($user_id);
	$temp_password_data = get_option( 'tg_temp_pass_'.$user_info->user_email );
	$password = base64_decode( $temp_password_data['password'] );
	
	$body = stripslashes($body);
	$body = html_entity_decode($body);
	$body = nl2br($body);
	$body = str_replace( array( '#display_name#', '#first_name#', '#last_name#', '#user_email#', '#user_password#', '#site_url#', '#reset_pass_url#', '#login_url#' ), array( $user_info->display_name, $user_info->first_name, $user_info->last_name, $user_info->user_email, $password, site_url(), tg_get_reset_password_url(), get_option('tg_login_url') ), $body );
	
	$body = tg_get_email_body( 'user_inserted.php', array( 'body' => $body ) );
	if( empty($tg_from_email) ){
		$tg_from_email = 'no-reply@wordpress.com';
	}
	if( empty($tg_from_name) ){
		$tg_from_name = 'TeachGround';
	}
	if( empty($subject) ){
		$subject = __( 'TeachGround - Registration Successful', 'teachground' );
	}
	$headers[] = "From: {$tg_from_name} <{$tg_from_email}>";

	$subject = apply_filters( 'tg_user_inserted_email_subject', $subject );
	$to[] = $user_info->user_email;
	
	add_filter( 'wp_mail_content_type', 'tg_set_html_content_type' );
	
	wp_mail( $to, $subject, $body, $headers );
	
	// send email to admin //
	/* $subject_admin = get_option( 'tg_new_user_inserted_subject_admin' );
	$to = get_option( 'tg_admin_email' );
	$body = get_option( 'tg_new_user_inserted_body_admin' );
	
	if( empty($subject_admin) ){
		$subject_admin = __( 'TeachGround - Registration Successful', 'teachground' );
	}
	
	$body = stripslashes($body);
	$body = html_entity_decode($body);
	$body = nl2br($body);
	$body = str_replace( array( '#display_name#', '#user_email#', '#user_password#', '#site_url#', '#reset_pass_url#' ), array( $user_info->display_name, $user_info->user_email, $password, site_url(), tg_get_reset_password_url() ), $body );

	$body = tg_get_email_body( 'user_inserted_admin.php', array( 'body' => $body ) );
	
	if( tg_is_checked( get_option( 'tg_enable_new_user_created_email_admin' ) ) == 'checked' ){
		wp_mail( $to, $subject_admin, $body, $headers );
	} */
	// send email to admin //
	
	remove_filter( 'wp_mail_content_type', 'tg_set_html_content_type' );
	return;
}

/*
* check if user assigned to access manually
* accepts - user_id, am_id
* returns - true/ false
*/
function is_user_assigned_manually( $user_id = '', $am_id = ''){
	global $wpdb;
	if( !$user_id ){
		return false;
	}
	if( !$am_id ){
		return false;
	}
	$status = $wpdb->get_var( $wpdb->prepare( "SELECT count(*) FROM ".$wpdb->prefix."tg_orders WHERE user_id = %d AND payment_gateway = %s AND payment_gateway_order_id = %s", $user_id, 'manual', $am_id) );
	if( $status == 1 ){
		return true;
	} else {
		return false;
	}
}

/*
* add data to orders table
* accepts - array
* returns - NA
*/	
function tg_add_order( $data ){
	global $wpdb;
	$status = $wpdb->get_var( $wpdb->prepare( "SELECT count(*) FROM ".$wpdb->prefix."tg_orders WHERE user_id = %d AND payment_gateway = %s AND payment_gateway_order_id = %s", $data['user_id'], $data['payment_gateway'], $data['payment_gateway_order_id'] ) );
	if( $status != 1 ){
		$order_data['user_id'] = $data['user_id'];
		$order_data['payment_gateway'] = $data['payment_gateway'];
		$order_data['payment_gateway_order_id'] = $data['payment_gateway_order_id'];
		$order_data['added_on'] = date("Y-m-d H:i:s");
		$wpdb->insert( $wpdb->prefix."tg_orders", $order_data );
	}
	return;
}

/*
* delete data from orders table
* accepts - array
* returns - NA
*/	
function tg_delete_order( $data ){
	global $wpdb;
	$wpdb->delete( $wpdb->prefix.'tg_orders', array( 'user_id' => $data['user_id'], 'payment_gateway' => $data['payment_gateway'], 'payment_gateway_order_id' => $data['payment_gateway_order_id'] ) );
	return;
}


/*
* get sections from course id
* accepts - course id
* returns - false/ array
*/	
function tg_get_sections_from_course_id( $course_id = '' ){
	global $wpdb;
	if( !$course_id ){
		return false;
	}
	$sections = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM ".$wpdb->prefix."tg_lesson_mapping WHERE c_id = %d AND m_type = %s ORDER BY m_order", $course_id, 'section' ), OBJECT );
	return $sections;
}

/*
* get lessons from secton id
* accepts - course id
* returns - false/ array
*/	
function tg_get_lessons_from_section_id( $section_id = '' ){
	global $wpdb;
	if( !$section_id ){
		return false;
	}
	$lessons = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM ".$wpdb->prefix."tg_lesson_mapping WHERE s_id = %d AND m_type = %s ORDER BY m_order", $section_id, 'lesson' ), OBJECT );
	return $lessons;
}

/*
* do lesson complete / course complete actions 
* accepts - user id, lesson id
* returns - false/ redirect
*/	

function tg_do_course_complete_actions( $user_id = '', $l_id = '' ){
	if( !$user_id ){
		return;
	}
	if( !$l_id ){
		return;
	}
	$next_lesson = tg_get_next_lesson_id($l_id);
	if( $next_lesson ){
		wp_redirect( get_permalink( $next_lesson ) );
		exit;
	}

	// if here then next lesson is not available 

	$action_after_course_complete = get_post_meta($course_id, 'action_after_course_complete', true);
	if($action_after_course_complete != 'Yes'){ // no need to take any action
		return;	
	}

	$course_id = tg_get_probable_course_id_from_lesson_id($l_id);
	if(tg_is_course_marked_as_completed( $user_id, $course_id )){
		$course_complete_action = get_post_meta( $course_id, 'course_complete_action', true );
		
		if( $course_complete_action == 'rdtnc' ){ // go to next course 
			$next_course_id = tg_get_next_course_id($course_id);
			if($next_course_id){
				wp_redirect( get_permalink( $next_course_id ) );
				exit;
			} else {
				return;
			}
		} else if( $course_complete_action == 'rdtp' ){ // go to page 
			$cc_redirect_to_page_id = get_post_meta( $course_id, 'cc_redirect_to_page_id', true );
			wp_redirect( get_permalink( $cc_redirect_to_page_id ) );
			exit;
		} else if( $course_complete_action == 'rdtu' ){ // go to url
			$cc_redirect_to_page_url = get_post_meta( $course_id, 'cc_redirect_to_page_url', true );
			wp_redirect( $cc_redirect_to_page_url );
			exit;
		} else if( $course_complete_action == 'smipup' ){ // show popup
			$cc_popup_message = get_post_meta( $course_id, 'cc_popup_message', true );
			if($cc_popup_message){
				$message = $cc_popup_message;
			} else {
				$message = __('You have successfully completed this course.','teachground');
			}
			include( TG_DIR_PATH . '/view/front/course-complete-popup.php' );
			return;
		} else { // do nothing 
			return;	
		}
		
	} else {
		return;
	}
}

function tg_do_course_complete_actions_old( $user_id = '', $l_id = '' ){
	if( !$user_id ){
		return;
	}
	if( !$l_id ){
		return;
	}
	$next_lesson = tg_get_next_lesson_id($l_id);
	if( $next_lesson ){
		wp_redirect( get_permalink( $next_lesson ) );
		exit;
	}

	// if here then next lesson is not available 

	$course_id = tg_get_probable_course_id_from_lesson_id($l_id);
	if(tg_is_course_marked_as_completed( $user_id, $course_id )){
		$course_complete_action = get_post_meta( $course_id, 'course_complete_action', true );
		$display_course_complete_success_message = get_post_meta( $course_id, 'display_course_complete_success_message', true );

		if( $display_course_complete_success_message == 'Yes'){ // show popup 
			$redirect = '';
			if( $course_complete_action == 'rdtnc' ){ // go to next course 
				$next_course_id = tg_get_next_course_id($course_id);
				if($next_course_id){
					$redirect = get_permalink( $next_course_id );
				} else { 
					// next course not found so do nothing
				}
			} else if( $course_complete_action == 'rdtp' ){ // go to page 
				$cc_redirect_to_page_id = get_post_meta( $course_id, 'cc_redirect_to_page_id', true );
				$redirect = get_permalink( $cc_redirect_to_page_id );
			} else if( $course_complete_action == 'rdtu' ){ // go to url
				$cc_redirect_to_page_url = get_post_meta( $course_id, 'cc_redirect_to_page_url', true );
				$redirect = $cc_redirect_to_page_url;
			} else { 
				// do nothing 
			}

			$cc_popup_message = get_post_meta( $course_id, 'cc_popup_message', true );
			if($cc_popup_message){
				$message = $cc_popup_message;
			} else {
				$message = __('You have successfully completed this course.','teachground');
			}
			include( TG_DIR_PATH . '/view/front/course-complete-popup.php' );
			return;
		} else {
			if( $course_complete_action == 'rdtnc' ){ // go to next course 
				$next_course_id = tg_get_next_course_id($course_id);
				if($next_course_id){
					wp_redirect( get_permalink( $next_course_id ) );
					exit;
				} else {
					return;
				}
			} else if( $course_complete_action == 'rdtp' ){ // go to page 
				$cc_redirect_to_page_id = get_post_meta( $course_id, 'cc_redirect_to_page_id', true );
				wp_redirect( get_permalink( $cc_redirect_to_page_id ) );
				exit;
			} else if( $course_complete_action == 'rdtu' ){ // go to url
				$cc_redirect_to_page_url = get_post_meta( $course_id, 'cc_redirect_to_page_url', true );
				wp_redirect( $cc_redirect_to_page_url );
				exit;
			} else { // do nothing 
				return;	
			}
		}
	} else {
		return;
	}
}

/*
* get all assigned lessons of current user
* accepts - blank
* returns - array
*/	
function get_all_lessons_of_current_user(){
	$all_user_lessons = array();
	$am_ids = tg_get_accesses_of_user();
	if(is_array($am_ids)){
		foreach($am_ids as $am_id){
			$course_ids = tg_get_courses_from_am_id($am_id);	
			if(is_array($course_ids)){
				foreach($course_ids as $course_id){
					$lesson_ids = tg_get_lesson_ids_from_course_id($course_id);
					if(is_array($lesson_ids)){
						foreach($lesson_ids as $lesson_id){
							$all_user_lessons[$course_id][] = array(
								'lesson_id' => $lesson_id,
								'am_id' => $am_id,
								'is_completed' => tg_is_lesson_marked_as_completed(get_current_user_id(),$lesson_id),
							);
						}
					}
				}
			}
		}
		if(is_array($all_user_lessons)){
			return array('status' => true, 'all_user_lessons' => $all_user_lessons);
		} else{
			return array('status' => false, 'msg' => __('No courses / lessons are added to accesses.','teachground'));
		}
	} else {
		return array('status' => false, 'msg' => __('You are not assigned to any accesses.','teachground'));
	}
}

/*
* get next lesson link globally for current user
* accepts - array as shortcode arguments 
* returns - array
*/	
function get_global_next_lesson_link($atts = array()){

	if($atts['courses']){
		$supplied_course_ids = explode(',',$atts['courses']);
		if(is_array($supplied_course_ids)){
			foreach($supplied_course_ids as $supplied_course_id){
				// check if user is assigned to this course
				$res = tg_is_current_user_assigned_to_course($supplied_course_id);
				if($res['status'] == false){
					continue;
				} elseif($res['status'] == true){
					// now we know this course is assigned to the user
					$lesson_ids = tg_get_lesson_ids_from_course_id( $supplied_course_id );
					if( is_array( $lesson_ids ) ){
						foreach( $lesson_ids as $lesson_id ){
							$status = tg_is_lesson_marked_as_completed(get_current_user_id(), $lesson_id);
							if( $status == true ){
								continue;
							} else {
								return array('status' => true, 'lesson_id' => $lesson_id);
							}
						}
					}
				}
			}
		}
	}

	// check for default next lesson
	$data = get_all_lessons_of_current_user();
	if($data['status'] == true){
		$all_user_lessons = $data['all_user_lessons'];
		if(is_array($all_user_lessons)){
			foreach($all_user_lessons as $key => $value){
				if(is_array($value)){
					foreach($value as $key1 => $value1){
						if($value1['is_completed'] == false){
							return array('status' => true, 'lesson_id' => $value1['lesson_id']);
						}
					}
				}
			}
		}
	} else {
		return array('status' => false, 'msg' => $data['msg']);
	}
}