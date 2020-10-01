<?php

function tg_login_module_load(){
	include_once TG_DIR_PATH . '/login/includes/class_scripts.php';
	include_once TG_DIR_PATH . '/login/includes/class_forgot_password.php';
	include_once TG_DIR_PATH . '/login/includes/class_login_form.php';
	include_once TG_DIR_PATH . '/login/includes/class_login_log_add.php';
	include_once TG_DIR_PATH . '/login/includes/class_security.php';
	include_once TG_DIR_PATH . '/login/login_widget.php';
	include_once TG_DIR_PATH . '/login/process.php';
	include_once TG_DIR_PATH . '/login/login_widget_shortcode.php';
	include_once TG_DIR_PATH . '/login/functions.php';
	
	new tg_login_scripts;
	new tg_login_form;
}

class tg_login_load {
	function __construct() {
		tg_login_module_load();
	}
}

new tg_login_load;

add_action( 'widgets_init', function(){ register_widget( 'tg_login_widget' ); } );

add_action( 'init', 'tg_login_validate' );
add_action( 'init', 'tg_forgot_pass_validate' );

add_action( 'plugins_loaded', 'tg_security_init' );

add_shortcode( 'tg_login', 'tg_login_widget_shortcode' );
add_shortcode( 'tg_forgot_password', 'tg_forgot_password_shortcode' );


