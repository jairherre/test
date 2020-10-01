<?php
/*
* start session if not started yet
*/
function lms_start_session_if_not_started(){
	if(!session_id()){
		@session_start();
	}
}

/*
* is checked
*/
function lms_is_checked( $value = '' ){
	if( $value == 'Yes'){
		return 'checked';
	} else {
		return false;
	}
}

/*
* set email content to HTML
*/
function lms_set_html_content_type() {
	return 'text/html';
}

/*
* LMS text domain
*/
function lms_text_domain(){
	load_plugin_textdomain('lms', FALSE, basename( dirname( __FILE__ ) ) .'/languages');
}

/*
* remove slashes
*/
function lms_removeslashes( $string ){
	$string = implode( "", explode( "\\", $string ) );
	return stripslashes( trim( $string ) );
}

/*
* LMS date format
*/
function lms_date_format( $date = '', $format = 'Y-m-d H:i:s' ){
	if( $date == '' ){
		return false;
	}
	return date( $format, strtotime($date) );
}

/*
* LMS remaining time
*/
function lms_time_remain( $start_time = '', $end_time = '' ){
	if($start_time == ''){
		$start_time = date("Y-m-d H:i:s");
	}
	if($end_time == ''){
		$end_time = date("Y-m-d H:i:s");
	}
	$start_time = strtotime( $start_time );
	$end_time = strtotime( $end_time );
	$time_diff = $end_time - $start_time; 
	if( $time_diff < 1 ){
		return false;
	}
	$days = floor($time_diff / (60 * 60 * 24));
	$remainder = $time_diff % (60 * 60 * 24);
	$hours = floor($remainder / (60 * 60));
	$remainder = $remainder % (60 * 60);
	$minutes = floor($remainder / 60);
	$seconds = $remainder % 60;
	return array( 'days' => $days, 'hours' => $hours, 'minutes' => $minutes, 'seconds' => $seconds );
}

/*
* get course complete percentage number
*/
function get_course_complete_percent_text( $course_id = '' ){
	global $post;
	if( empty( $course_id ) ){
		$course_id = $post->ID;
	}
	$course_complete_data = lms_get_current_user_lesson_completion_data( $course_id );
	if( !empty($course_complete_data)){
		return $course_complete_data['percentage'];
	} else {
		return false;
	}
}

/*
* Assign user to a course 
$data = array(
	'user_id',
	'course_id',
	'status',
	'added_on',
);
*/
function lms_assign_user_to_course( $data = array() ){
	global $clf;
	return $clf->map_user_to_course( $data );
}

/*
* Unassign user from course 
$data = array(
	'user_id',
	'course_id',
);
*/
function unmap_user_from_course( $data = array() ){
	global $clf;
	return $clf->unmap_user_from_course( $data );
}

/*
* Assign user to an access management 
$data = array(
	'user_id',
	'am_id',
	'status',
	'added_on',
);
*/
function lms_assign_user_to_am( $data = array() ){
	global $clf;
	return $clf->map_user_to_am( $data );
}

/*
* Unassign user from access management  
$data = array(
	'user_id',
	'am_id',
);
*/
function unmap_user_from_am( $data = array() ){
	global $clf;
	return $clf->unmap_user_from_am( $data );
}

/*
* Accepts all params as wp_insert_user does
*/
function lms_register_user( $userdata = array() ){
	$user_id = wp_insert_user( $userdata ) ;
	if ( ! is_wp_error( $user_id ) ) {
		do_action( 'lms_user_inserted', $user_id );
		return $user_id;
	} else {
		return false;
	}
}

/*
* trim excerpt
*/
function lms_the_excerpt( $post_id = '', $charlength = 500 ){
	$the_post = get_post( $post_id );
    $excerpt = $the_post->post_excerpt; 
	
	$charlength++;
	if ( mb_strlen( $excerpt ) > $charlength ) {
		$subex = mb_substr( $excerpt, 0, $charlength - 5 );
		$exwords = explode( ' ', $subex );
		$excut = - ( mb_strlen( $exwords[ count( $exwords ) - 1 ] ) );
		if ( $excut < 0 ) {
			echo mb_substr( $subex, 0, $excut );
		} else {
			echo $subex;
		}
		echo '[...]';
	} else {
		echo $excerpt;
	}
}

/*
* trim text
*/
function lms_limit_text( $text, $charlength ){
	$charlength++;
	if ( mb_strlen( $text ) > $charlength ) {
		$subex = mb_substr( $text, 0, $charlength - 2 );
		$exwords = explode( ' ', $subex );
		$excut = - ( mb_strlen( $exwords[ count( $exwords ) - 1 ] ) );
		if ( $excut < 0 ) {
			echo mb_substr( $subex, 0, $excut );
		} else {
			echo $subex;
		}
		echo '..';
	} else {
		echo $text;
	}
}

function lms_get_reset_password_url(){
	return site_url('/') . 'forgot-password' . '/';
}

function lms_youtube_video_id( $url = '' ){
	if( empty( $url ) ){
		return;
	}
	preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match);
	$video_id = $match[1];
	return $video_id;
}

function lms_vimeo_video_id( $url = '' ){
	if( empty( $url ) ){
		return;
	}
	return (int)substr(parse_url($url, PHP_URL_PATH), 1);
}

function lms_video_type( $url = '' ) {
   	if( empty( $url ) ){
		return false;
	}
    if (strpos($url, 'youtube') > 0) {
        return 'youtube';
    } elseif (strpos($url, 'youtu') > 0) {
        return 'youtube';
    } elseif (strpos($url, 'vimeo') > 0) {
        return 'vimeo';
    } else {
        return false;
    }
}