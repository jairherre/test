<?php
class lms_scripts {

	public function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'front_scripts' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );
	}

	public function admin_scripts(){
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'jquery-ui-sortable' );
		wp_enqueue_script( 'jquery-ui-dialog' );
		wp_enqueue_script( 'jquery-ui-tooltip' );
		wp_enqueue_script( 'jquery.cookie', plugins_url( LMS_DIR_NAME . '/js/jquery.cookie.js' ) );
		wp_enqueue_script( 'ap-tabs', plugins_url( LMS_DIR_NAME . '/js/ap-tabs.js' ) );
		wp_enqueue_script( 'lms-script-admin', plugins_url( LMS_DIR_NAME . '/js/lms-script-admin.js' ) );
		wp_enqueue_style( 'lms-admin', plugins_url( LMS_DIR_NAME . '/css/lms-admin.css' ) );
		wp_enqueue_style( 'jquery-ui', plugins_url( LMS_DIR_NAME . '/css/jquery-ui.css' ) );

		// select 2
		wp_enqueue_style( 'select2.min', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css' );
		wp_enqueue_script( 'select2.min', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js' );
	}

	public function front_scripts() {
		wp_enqueue_style( 'lms', plugins_url( LMS_DIR_NAME . '/css/lms.css' ) );
		wp_enqueue_style( 'lms-front', plugins_url( LMS_DIR_NAME . '/css/lms-front.css' ) );
		wp_enqueue_style( 'lms-frontend', plugins_url( LMS_DIR_NAME . '/assets/css/frontend.css' ) );
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'jquery-ui-tooltip' );
		wp_enqueue_script( 'jquery-color' );
		wp_enqueue_script( 'jquery-ui-dialog' );
		wp_enqueue_script( 'lms-script', plugins_url( LMS_DIR_NAME . '/js/lms-script.js' ) );

		wp_enqueue_script( 'youtube-lms-api', 'https://www.youtube.com/iframe_api' );
		wp_enqueue_script( 'vimeo-lms-api', 'https://player.vimeo.com/api/player.js' );

		// Font Awesome
		wp_enqueue_style( 'font-awesome', 'https://use.fontawesome.com/releases/v5.6.3/css/all.css' );
		wp_enqueue_style( 'jquery-ui', plugins_url( LMS_DIR_NAME . '/css/jquery-ui.css' ) );
	}

}
