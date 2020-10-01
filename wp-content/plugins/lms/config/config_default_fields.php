<?php
global $lms_default_options_data, $lms_resource_icons;

$lms_default_options_data = array( 
	// General settings
	'lms_login_url' => array( 'sanitization' => 'sanitize_text_field' ),
	'lms_login_redirect_url' => array( 'sanitization' => 'sanitize_text_field' ),
	'lms_forgot_password_url' => array( 'sanitization' => 'sanitize_text_field' ),
	'lms_register_url' => array( 'sanitization' => 'sanitize_text_field' ),

	// Email settings
	'lms_admin_email' => array( 'sanitization' => 'sanitize_text_field' ),
	'lms_from_email' => array( 'sanitization' => 'sanitize_text_field' ),
	'lms_from_name' => array( 'sanitization' => 'sanitize_text_field' ),
	
	// user assigned
	'lms_enable_access_assigned_email_user' => array( 'sanitization' => 'sanitize_text_field' ),
	'lms_access_assign_subject' => array( 'sanitization' => 'sanitize_text_field' ),
	'lms_access_assign_body' => array( 'sanitization' => 'esc_html' ),
	'lms_enable_access_assigned_email_admin' => array( 'sanitization' => 'esc_html' ),
	'lms_access_assign_subject_admin' => array( 'sanitization' => 'esc_html' ),
	'lms_access_assign_body_admin' => array( 'sanitization' => 'esc_html' ),
	
	// user unassigned
	'lms_enable_access_unassign_email_user' => array( 'sanitization' => 'sanitize_text_field' ),
	'lms_access_unassign_subject' => array( 'sanitization' => 'sanitize_text_field' ),
	'lms_access_unassign_body' => array( 'sanitization' => 'esc_html' ),
	'lms_enable_access_unassigned_email_admin' => array( 'sanitization' => 'esc_html' ),
	'lms_access_unassign_subject_admin' => array( 'sanitization' => 'esc_html' ),
	'lms_access_unassign_body_admin' => array( 'sanitization' => 'esc_html' ),
	
	// user inserted
	'lms_enable_new_user_created_email_user' => array( 'sanitization' => 'sanitize_text_field' ),
	'lms_new_user_inserted_subject' => array( 'sanitization' => 'sanitize_text_field' ),
	'lms_new_user_inserted_body' => array( 'sanitization' => 'esc_html' ),
	'lms_enable_new_user_created_email_admin' => array( 'sanitization' => 'esc_html' ),
	'lms_new_user_inserted_subject_admin' => array( 'sanitization' => 'esc_html' ),
	'lms_new_user_inserted_body_admin' => array( 'sanitization' => 'esc_html' ),
	
	// reset password
	'lms_reset_password_subject' => array( 'sanitization' => 'sanitize_text_field' ),
	'lms_reset_password_body' => array( 'sanitization' => 'esc_html' ),
	'lms_new_password_subject' => array( 'sanitization' => 'sanitize_text_field' ),
	'lms_new_password_body' => array( 'sanitization' => 'esc_html' ),
	
	// Display settings 
	'lms_co_hide_feature_image' => array( 'sanitization' => 'sanitize_text_field' ),
	'lms_co_hide_course_title' => array( 'sanitization' => 'sanitize_text_field' ),
	'lms_co_hide_course_desc' => array( 'sanitization' => 'sanitize_text_field' ),
	'lms_co_hide_progress_bar' => array( 'sanitization' => 'sanitize_text_field' ),
	'lms_co_hide_author' => array( 'sanitization' => 'sanitize_text_field' ),
	'lms_co_hide_progress_percentage' => array( 'sanitization' => 'sanitize_text_field' ),
	'lms_cp_hide_feature_image' => array( 'sanitization' => 'sanitize_text_field' ),
	'lms_cp_hide_course_title' => array( 'sanitization' => 'sanitize_text_field' ),
	'lms_cp_hide_course_desc' => array( 'sanitization' => 'sanitize_text_field' ),
	'lms_cp_hide_lesson_list' => array( 'sanitization' => 'sanitize_text_field' ),
	'lms_lp_hide_feature_image' => array( 'sanitization' => 'sanitize_text_field' ),
	'lms_lp_hide_lesson_title' => array( 'sanitization' => 'sanitize_text_field' ),
	'lms_lp_hide_lesson_desc' => array( 'sanitization' => 'sanitize_text_field' ),
	'lms_lp_hide_lesson_resource' => array( 'sanitization' => 'sanitize_text_field' ),
	'lms_lp_hide_lesson_prev_next_nav' => array( 'sanitization' => 'sanitize_text_field' ),	

	// Translations
	'lms_course_name' => array( 'sanitization' => 'sanitize_text_field' ),	
	'lms_course_name_plural' => array( 'sanitization' => 'sanitize_text_field' ),	
	'lms_lesson_name' => array( 'sanitization' => 'sanitize_text_field' ),	
	'lms_lesson_name_plural' => array( 'sanitization' => 'sanitize_text_field' ),	

);

$lms_resource_icons = array(
	'doc'  		=> array( 
		'big' => plugins_url( LMS_DIR_NAME . '/images/icons/doc.png' ), 
		'small' => plugins_url( LMS_DIR_NAME . '/images/icons/small/doc.png' ), 
		'fa-icon' => '<i class="far fa-file"></i>' 
	),
	'xls'  		=> array( 
		'big' => plugins_url( LMS_DIR_NAME . '/images/icons/xls.png' ), 
		'small' => plugins_url( LMS_DIR_NAME . '/images/icons/small/xls.png' ), 
		'fa-icon' => '<i class="far fa-file"></i>' 
	),
	'ppt' 		=> array( 
		'big' => plugins_url( LMS_DIR_NAME . '/images/icons/ppt.png' ), 
		'small' => plugins_url( LMS_DIR_NAME . '/images/icons/small/ppt.png' ), 
		'fa-icon' => '<i class="far fa-file"></i>' 
	),
	'pptx' 		=> array( 
		'big' => plugins_url( LMS_DIR_NAME . '/images/icons/ppt.png' ), 
		'small' => plugins_url( LMS_DIR_NAME . '/images/icons/small/ppt.png' ), 
		'fa-icon' => '<i class="far fa-file"></i>' 
	),
	'zip'  		=> array( 
		'big' => plugins_url( LMS_DIR_NAME . '/images/icons/zip.png' ), 
		'small' => plugins_url( LMS_DIR_NAME . '/images/icons/small/zip.png' ), 
		'fa-icon' => '<i class="far fa-file-archive"></i>' 
	),
	'pdf'  		=> array( 
		'big' => plugins_url( LMS_DIR_NAME . '/images/icons/pdf.png' ), 
		'small' => plugins_url( LMS_DIR_NAME . '/images/icons/small/pdf.png' ), 
		'fa-icon' => '<i class="far fa-file-pdf"></i>' 
	),
	'csv'  		=> array( 
		'big' => plugins_url( LMS_DIR_NAME . '/images/icons/csv.png' ), 
		'small' => plugins_url( LMS_DIR_NAME . '/images/icons/small/csv.png' ), 
		'fa-icon' => '<i class="far fa-file"></i>' 
	),
	'txt' 		=> array( 
		'big' => plugins_url( LMS_DIR_NAME . '/images/icons/txt.png' ), 
		'small' => plugins_url( LMS_DIR_NAME . '/images/icons/small/txt.png' ), 
		'fa-icon' => '<i class="far fa-file"></i>' 
	),
	'html' 		=> array( 
		'big' => plugins_url( LMS_DIR_NAME . '/images/icons/html.png' ), 
		'small' => plugins_url( LMS_DIR_NAME . '/images/icons/small/html.png' ), 
		'fa-icon' => '<i class="far fa-html5"></i>' 
	),
	'htm'  		=> array( 
		'big' => plugins_url( LMS_DIR_NAME . '/images/icons/html.png' ), 
		'small' => plugins_url( LMS_DIR_NAME . '/images/icons/small/html.png' ), 
		'fa-icon' => '<i class="far fa-html5"></i>' 
	),
	'lnk'  		=> array( 
		'big' => plugins_url( LMS_DIR_NAME . '/images/icons/link.png' ), 
		'small' => plugins_url( LMS_DIR_NAME . '/images/icons/small/link.png' ), 
		'fa-icon' => '<i class="fas fa-link"></i>' 
	),
	'ext_lnk'  	=> array( 
		'big' => plugins_url( LMS_DIR_NAME . '/images/icons/link.png' ), 
		'small' => plugins_url( LMS_DIR_NAME . '/images/icons/small/link.png' ), 
		'fa-icon' => '<i class="fas fa-external-link-alt"></i>' 
	),
	'img'  		=> array( 
		'big' => '', 'small' => plugins_url( LMS_DIR_NAME . '/images/icons/small/img.png' ), 
		'fa-icon' => '<i class="far fa-image"></i>' 
	),
	'mp4'  		=> array( 
		'big' => plugins_url( LMS_DIR_NAME . '/images/icons/video.png' ), 
		'small' => plugins_url( LMS_DIR_NAME . '/images/icons/small/video.png' ), 
		'fa-icon' => '<i class="far fa-file-video"></i>' 
	),
	'oth'  		=> array( 
		'big' => plugins_url( LMS_DIR_NAME . '/images/icons/other.png' ), 
		'small' => plugins_url( LMS_DIR_NAME . '/images/icons/small/other.png' ), 
		'fa-icon' => '<i class="far fa-file"></i>' 
	),
);