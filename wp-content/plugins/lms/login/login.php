<?php

function lms_login_module_load(){
	include_once LMS_DIR_PATH . '/login/includes/class_scripts.php';
	include_once LMS_DIR_PATH . '/login/includes/class_forgot_password.php';
	include_once LMS_DIR_PATH . '/login/includes/class_login_form.php';
	include_once LMS_DIR_PATH . '/login/includes/class_login_log_add.php';
	include_once LMS_DIR_PATH . '/login/includes/class_security.php';
	include_once LMS_DIR_PATH . '/login/login_widget.php';
	include_once LMS_DIR_PATH . '/login/process.php';
	include_once LMS_DIR_PATH . '/login/login_widget_shortcode.php';
	include_once LMS_DIR_PATH . '/login/functions.php';
	
	new lms_login_scripts;
	new lms_login_form;
}

class lms_login_load {
	function __construct() {
		lms_login_module_load();
	}
}

new lms_login_load;

add_action( 'widgets_init', function(){ register_widget( 'lms_login_widget' ); } );

add_action( 'init', 'lms_login_validate' );
add_action( 'init', 'lms_forgot_pass_validate' );

add_action( 'plugins_loaded', 'lms_security_init' );

add_shortcode( 'lms_login', 'lms_login_widget_shortcode' );
add_shortcode( 'lms_forgot_password', 'lms_forgot_password_shortcode' );


