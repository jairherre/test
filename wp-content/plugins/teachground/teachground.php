<?php
/*
Plugin Name: TeachGround
Plugin URI: https://www.aviplugins.com/
Description: TeachGround plugin.
Version: 1.0.0
Text Domain: teachground
Domain Path: /languages
Author: aviplugins.com
Author URI: https://www.aviplugins.com/
*/

/**
	  |||||   
	<(`0_0`)> 	
	()(afo)()
	  ()-()
**/

define( 'TG_DIR_NAME', 'teachground' );
define( 'TG_DIR_PATH', dirname( __FILE__ ) );
define( 'TG_TEMPLATE_DIR_NAME', 'teachground' );

//define( 'TG_DEFAULT_VIDEO_WIDTH', '1280' );
//define( 'TG_DEFAULT_VIDEO_HEIGHT', '720' );

function tg_plug_install(){
	global $clf;
	include_once TG_DIR_PATH . '/autoload.php';
	new tg_autoload;
	new tg_settings;
	new class_cposts;
	new tg_scripts;
	$clf = new class_tg_functions;
}

//add_action( 'widgets_init', 'tg_register_sidebars' ); 
add_action( 'widgets_init', function(){ register_widget( 'course_complete_percentage_widget' ); } );
add_action( 'widgets_init', function(){ register_widget( 'lessons_list_widget' ); } );

class tg_plugin_init {
	function __construct() {
		tg_plug_install();
	}
}
new tg_plugin_init;

register_activation_hook( __FILE__, 'tg_plugin_activation' );

function tg_plugin_activation(){

	global $wpdb, 
	$tg_access_assign_body_default, 
	$tg_access_assign_body_admin_default,
	$tg_access_unassign_body_default,
	$tg_access_unassign_body_admin_default,
	$tg_new_user_inserted_subject_default,
	$tg_new_user_inserted_body_default,
	$tg_new_user_inserted_body_admin_default,
	$tg_forgot_password_link_mail_subject_default,
	$tg_forgot_password_link_mail_body_default,
	$tg_new_password_mail_body_default,
	$tg_new_password_mail_subject_default
	;
	
	/* Delete tables for reset
	$wpdb->query("DROP TABLE IF EXISTS `".$wpdb->base_prefix."tg_am_user_mapping`");
	$wpdb->query("DROP TABLE IF EXISTS `".$wpdb->base_prefix."tg_lesson_mapping`");
	$wpdb->query("DROP TABLE IF EXISTS `".$wpdb->base_prefix."tg_lesson_start_rules`");
	$wpdb->query("DROP TABLE IF EXISTS `".$wpdb->base_prefix."tg_section`");
	$wpdb->query("DROP TABLE IF EXISTS `".$wpdb->base_prefix."tg_user_lesson_complete_mapping`");
	$wpdb->query("DROP TABLE IF EXISTS `".$wpdb->base_prefix."tg_user_mapping`");
	$wpdb->query("DROP TABLE IF EXISTS `".$wpdb->base_prefix."tg_resource_mapping`");
	*/
	
	$wpdb->query("CREATE TABLE IF NOT EXISTS `".$wpdb->base_prefix."tg_course_mapping` (
	 `m_id` int(11) NOT NULL AUTO_INCREMENT,
	 `am_id` int(11) NOT NULL,
	 `c_id` int(11) NOT NULL,
	 `m_order` int(5) NOT NULL,
	  PRIMARY KEY (`m_id`)
	)");	

	$wpdb->query("CREATE TABLE IF NOT EXISTS `".$wpdb->base_prefix."tg_post_mapping` (
	 `m_id` int(11) NOT NULL AUTO_INCREMENT,
	 `am_id` int(11) NOT NULL,
	 `p_id` int(11) NOT NULL,
	 `m_order` int(5) NOT NULL,
	 PRIMARY KEY (`m_id`)
    )");
	
	$wpdb->query("CREATE TABLE IF NOT EXISTS `".$wpdb->base_prefix."tg_am_user_mapping` (
	  `m_id` int(11) NOT NULL AUTO_INCREMENT,
	  `am_id` int(11) NOT NULL,
	  `user_id` int(11) NOT NULL,
	  `added_on` datetime NOT NULL,
	  `m_status` enum('Active','Inactive') NOT NULL DEFAULT 'Inactive',
	  `ua_mail_status` enum('Unsent','Sent') NOT NULL DEFAULT 'Unsent',
	  `uua_mail_status` enum('Unsent','Sent') NOT NULL DEFAULT 'Unsent',
	  PRIMARY KEY (`m_id`)
	)");
	
	$wpdb->query("CREATE TABLE IF NOT EXISTS `".$wpdb->base_prefix."tg_lesson_mapping` (
	  `m_id` int(11) NOT NULL AUTO_INCREMENT,
	  `c_id` int(11) NOT NULL,
	  `l_id` int(11) NOT NULL,
	  `m_type` enum('lesson','section') NOT NULL,
	  `s_id` int(11) NOT NULL,
	  `m_order` int(5) NOT NULL,
	  `l_delay_type` varchar(10) NOT NULL,
	  `l_delay` int(3) NOT NULL,
	  `l_delay_date` varchar(50) NOT NULL,
	  `l_free` enum('No','Yes') NOT NULL,
	  PRIMARY KEY (`m_id`)
	)");	
	
	$wpdb->query("CREATE TABLE IF NOT EXISTS `".$wpdb->base_prefix."tg_lesson_start_rules` (
	  `r_id` int(11) NOT NULL AUTO_INCREMENT,
	  `c_id` int(11) NOT NULL,
	  `f_l_id` int(11) NOT NULL,
	  `s_l_id` int(11) NOT NULL,
	  PRIMARY KEY (`r_id`)
	)");
	
	$wpdb->query("CREATE TABLE IF NOT EXISTS `".$wpdb->base_prefix."tg_section` (
	  `s_id` int(11) NOT NULL AUTO_INCREMENT,
	  `c_id` int(11) NOT NULL,
	  `s_name` varchar(255) NOT NULL,
	   PRIMARY KEY (`s_id`)
	)");
	
	$wpdb->query("CREATE TABLE IF NOT EXISTS `".$wpdb->base_prefix."tg_user_lesson_complete_mapping` (
	  `m_id` int(11) NOT NULL AUTO_INCREMENT,
	  `user_id` int(11) NOT NULL,
	  `l_id` int(11) NOT NULL,
	  PRIMARY KEY (`m_id`)
	)");
	
	$wpdb->query("CREATE TABLE IF NOT EXISTS `".$wpdb->base_prefix."tg_user_mapping` (
	  `m_id` int(11) NOT NULL AUTO_INCREMENT,
	  `c_id` int(11) NOT NULL,
	  `user_id` int(11) NOT NULL,
	  `added_on` datetime NOT NULL,
	  `m_status` enum('Active','Inactive') NOT NULL DEFAULT 'Inactive',
	  PRIMARY KEY (`m_id`)
	)");
	
	$wpdb->query("CREATE TABLE IF NOT EXISTS `".$wpdb->base_prefix."tg_course_start_rules` (
	  `r_id` int(11) NOT NULL AUTO_INCREMENT,
	  `f_c_id` int(11) NOT NULL,
	  `s_c_id` int(11) NOT NULL,
	  PRIMARY KEY (`r_id`)
	)");
	
	$wpdb->query("CREATE TABLE IF NOT EXISTS `".$wpdb->base_prefix."tg_resource` (
		`r_id` int(11) NOT NULL AUTO_INCREMENT,
		`post_id` int(11) NOT NULL,
		`att_id` int(11) NOT NULL,
		`r_link` TEXT NOT NULL,
		PRIMARY KEY (`r_id`)
	)");
	
	$wpdb->query("CREATE TABLE IF NOT EXISTS `".$wpdb->base_prefix."tg_resource_mapping` (
	  `m_id` int(11) NOT NULL AUTO_INCREMENT,
	  `l_id` int(11) NOT NULL,
	  `r_id` int(11) NOT NULL,
	  `r_title` varchar(255) NOT NULL,
	  `r_highlight` ENUM('no','yes') NOT NULL DEFAULT 'no',
	  PRIMARY KEY (`m_id`)
	)");
	
	$wpdb->query("CREATE TABLE IF NOT EXISTS `".$wpdb->base_prefix."tg_frmt_quiz_data` (
		`log_id` int(11) NOT NULL AUTO_INCREMENT,
		`entry_id` int(11) NOT NULL,
		`l_id` int(11) NOT NULL,
		`user_id` int(11) NOT NULL,
		PRIMARY KEY (`log_id`)
	)");
	
	$wpdb->query("CREATE TABLE IF NOT EXISTS `".$wpdb->base_prefix."tg_frmt_form_data` (
		`log_id` int(11) NOT NULL AUTO_INCREMENT,
		`entry_id` int(11) NOT NULL,
		`l_id` int(11) NOT NULL,
		`user_id` int(11) NOT NULL,
		PRIMARY KEY (`log_id`)
	)");
	
	$wpdb->query("CREATE TABLE IF NOT EXISTS `".$wpdb->base_prefix."tg_youtube_data` (
		`log_id` int(11) NOT NULL AUTO_INCREMENT,
		`user_id` int(11) NOT NULL,
		`l_id` int(11) NOT NULL,
		PRIMARY KEY (`log_id`)
	)");
	
	$wpdb->query("CREATE TABLE IF NOT EXISTS `".$wpdb->base_prefix."tg_vimeo_data` (
		`log_id` int(11) NOT NULL AUTO_INCREMENT,
		`user_id` int(11) NOT NULL,
		`l_id` int(11) NOT NULL,
		PRIMARY KEY (`log_id`)
	)");
	
	$wpdb->query("CREATE TABLE IF NOT EXISTS `".$wpdb->base_prefix."tg_lesson_start_rules_disabled` (
		`d_id` int(11) NOT NULL AUTO_INCREMENT,
		`am_id` int(11) NOT NULL,
		`c_id` int(11) NOT NULL,
		PRIMARY KEY (`d_id`)
	)");

	$wpdb->query("CREATE TABLE IF NOT EXISTS `".$wpdb->base_prefix."tg_orders` (
		`order_id` int(11) NOT NULL AUTO_INCREMENT,
		`user_id` int(11) NOT NULL,
		`payment_gateway` varchar(255) NOT NULL,
		`payment_gateway_order_id` varchar(255) NOT NULL,
		`added_on` datetime NOT NULL,
		PRIMARY KEY (`order_id`)
	)");

	$wpdb->query("CREATE TABLE IF NOT EXISTS `".$wpdb->base_prefix."tg_login_log` (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`ip` varchar(50) NOT NULL,
		`user_id` int(11) NOT NULL,
		`msg` varchar(255) NOT NULL,
		`l_added` datetime NOT NULL,
		`l_status` enum('success','failed') NOT NULL,
		PRIMARY KEY (`id`)
	)");

	// create new role for students
	add_role( 'tg_student', 'Student', array( 'read' => true ) );
	
	// default email body 
	if( get_option( 'tg_access_assign_body' ) == '' ){
		update_option( 'tg_access_assign_body', $tg_access_assign_body_default );
	}
	if( get_option( 'tg_access_assign_body_admin' ) == '' ){
		update_option( 'tg_access_assign_body_admin', $tg_access_assign_body_admin_default );
	}
	if( get_option( 'tg_access_unassign_body' ) == '' ){
		update_option( 'tg_access_unassign_body', $tg_access_unassign_body_default );
	}
	if( get_option( 'tg_access_unassign_body_admin' ) == '' ){
		update_option( 'tg_access_unassign_body_admin', $tg_access_unassign_body_admin_default );
	}
	if( get_option( 'tg_new_user_inserted_subject' ) == '' ){
		update_option( 'tg_new_user_inserted_subject', $tg_new_user_inserted_subject_default );
	}
	if( get_option( 'tg_new_user_inserted_body' ) == '' ){
		update_option( 'tg_new_user_inserted_body', $tg_new_user_inserted_body_default );
	}
	if( get_option( 'tg_new_user_inserted_body_admin' ) == '' ){
		update_option( 'tg_new_user_inserted_body_admin', $tg_new_user_inserted_body_admin_default );
	}
	if( get_option( 'tg_reset_password_subject' ) == '' ){
		update_option( 'tg_reset_password_subject', $tg_forgot_password_link_mail_subject_default );
	}
	if( get_option( 'tg_reset_password_body' ) == '' ){
		update_option( 'tg_reset_password_body', $tg_forgot_password_link_mail_body_default );
	}
	if( get_option( 'tg_new_password_subject' ) == '' ){
		update_option( 'tg_new_password_subject', $tg_new_password_mail_subject_default );
	}
	if( get_option( 'tg_new_password_body' ) == '' ){
		update_option( 'tg_new_password_body', $tg_new_password_mail_body_default );
	}
	// default email body 
	
	update_option( 'tg_enable_access_assigned_email_user', 'Yes' );
	update_option( 'tg_enable_access_unassign_email_user', 'Yes' );
	update_option( 'tg_enable_new_user_created_email_user', 'Yes' );
	
	// create a reset password page //
	if ( null === $wpdb->get_row( "SELECT post_name FROM {$wpdb->prefix}posts WHERE post_name = 'forgot-password'", 'ARRAY_A' ) ) {
		$current_user = wp_get_current_user();
		$page = array(
		'post_title'  => __( 'Forgot Password', 'teachground' ),
		'post_content' => '[tg_forgot_password]',
		'post_status' => 'publish',
		'post_author' => $current_user->ID,
		'post_type'   => 'page',
		);
		wp_insert_post( $page );
	}
	// create a reset password page //
	
	// create upload dir //
	$upload_dir = wp_upload_dir();
	if ( !file_exists($upload_dir['basedir'] . '/' . 'teachground') ) {
		mkdir($upload_dir['basedir'] . '/' . 'teachground', 0755, true);
	}
	// create upload dir //
}

add_action( 'plugins_loaded', 'tg_text_domain' );

if (!did_action('elementor/loaded')) {
	add_filter( 'single_template', 'tg_custom_template' );
}

function tg_custom_template( $single ) {

    global $post;

    if ( $post->post_type == 'tg_course' ) {
		$template_file = 'single-tg_course.php';
		if ( file_exists( TEMPLATEPATH . '/' . TG_TEMPLATE_DIR_NAME . '/' . $template_file ) ) {
             return TEMPLATEPATH . '/' . TG_TEMPLATE_DIR_NAME . '/' . $template_file;
        } else {
			if ( file_exists( TG_DIR_PATH . '/templates/' . $template_file ) ) {
				return TG_DIR_PATH . '/templates/' . $template_file;
			}
		}
    }
	
	if ( $post->post_type == 'tg_lesson' ) {
		$template_file = 'single-tg_lesson.php';
		if ( file_exists( TEMPLATEPATH . '/' . TG_TEMPLATE_DIR_NAME . '/' . $template_file ) ) {
             return TEMPLATEPATH . '/' . TG_TEMPLATE_DIR_NAME . '/' . $template_file;
        } else {
			if ( file_exists( TG_DIR_PATH . '/templates/' . $template_file ) ) {
				return TG_DIR_PATH . '/templates/' . $template_file;
			}
		}
    }
	
    return $single;
}

add_filter( 'taxonomy_template', 'tg_custom_tax_template');

function tg_custom_tax_template( $tax_template ) {
	if (is_tax('tg_course_category')) {
		$template_file = 'archive-tg_course.php';
		if ( file_exists( TEMPLATEPATH . '/' . TG_TEMPLATE_DIR_NAME . '/' . $template_file ) ) {
			return TEMPLATEPATH . '/' . TG_TEMPLATE_DIR_NAME . '/' . $template_file;
		} else {
			if ( file_exists( TG_DIR_PATH . '/templates/' . $template_file ) ) {
				return TG_DIR_PATH . '/templates/' . $template_file;
			}
		}
	}

	return $tax_template;
}

function tg_get_email_body( $template_file, $data ){
	if ( ! is_array( $data ) ) return FALSE;
    extract($data);
    ob_start();
	if ( file_exists( TEMPLATEPATH . '/' . TG_TEMPLATE_DIR_NAME . '/emails/' . $template_file ) ) {
		 include_once( TEMPLATEPATH . '/' . TG_TEMPLATE_DIR_NAME . '/emails/' . $template_file );
	} else {
		include_once( TG_DIR_PATH . '/templates/emails/' . $template_file );
	}
    $html = ob_get_contents();
    ob_end_clean();
    return $html;
}

function tg_course_page_redirect(){
	global $wp_query, $post;
    if( $wp_query->query_vars['post_type'] === 'tg_course' ){
       $course_id = $post->ID;
	   $user_not_assigned_to_do = get_post_meta($course_id, 'user_not_assigned_to_do', true );
	   if( $user_not_assigned_to_do == 'redirect_to_page' || $user_not_assigned_to_do == 'redirect_to_url' ){
		  $status = tg_is_current_user_assigned_to_course( $course_id );
		  if( $status['status'] != true ){
			  if( $user_not_assigned_to_do == 'redirect_to_page' ){
			  	$redirect_to_page_id = get_post_meta($course_id, 'redirect_to_page_id', true );
				if( $redirect_to_page_id ){
					wp_redirect(get_permalink($redirect_to_page_id));
					exit;
				}
			  } else if( $user_not_assigned_to_do == 'redirect_to_url' ){
			  	$redirect_to_page_url = get_post_meta($course_id, 'redirect_to_page_url', true );
				if( $redirect_to_page_url ){
					wp_redirect($redirect_to_page_url);
					exit;
				}
			  }
		  }
	   }
    }
}
add_action( 'template_redirect', 'tg_course_page_redirect' );
