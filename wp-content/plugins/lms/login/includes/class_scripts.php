<?php
class lms_login_scripts {

	public function __construct() {
		add_action( 'admin_enqueue_scripts', array( $this, 'load_login_admin_style' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'load_login_front_style' ) );
	}
	
	public function load_login_admin_style(){
		wp_register_style( 'style_login_admin', plugins_url( LMS_DIR_NAME. '/login/css/style_login_admin.css' ) );
		wp_enqueue_style( 'style_login_admin' );
		wp_enqueue_script( 'jquery' );
	}
	
	public function load_login_front_style() {
		wp_enqueue_style( 'style_login_widget', plugins_url( LMS_DIR_NAME . '/login/css/style_login_widget.css' ) );
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'jquery.validate.min', plugins_url( LMS_DIR_NAME . '/login/js/jquery.validate.min.js' ) );
		wp_enqueue_script( 'additional-methods', plugins_url( LMS_DIR_NAME . '/login/js/additional-methods.js' ) );
	}
	
}