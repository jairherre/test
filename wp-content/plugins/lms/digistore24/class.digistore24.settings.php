<?php

if ( ! defined( 'ABSPATH' ) ) { exit; }

add_action( 'lms_custom_settings_tab', 'digistore24_lms_tab' );
add_action( 'lms_custom_settings_tab_content', 'digistore24_lms_tab_content' );

add_filter( 'lms_default_options_data', 'lms_digistore24_data', 10, 1 );

function lms_digistore24_data( $data ){
	$data['lms_digistore24_api_key'] = array( 'sanitization' => 'sanitize_text_field' );
	return $data;
}

function digistore24_lms_tab(){
	include( LMS_DIR_PATH . '/digistore24/view/admin/tab.php' );
}

function digistore24_lms_tab_content(){
	$lms_digistore24_api_key = get_option('lms_digistore24_api_key');
	include( LMS_DIR_PATH . '/digistore24/view/admin/settings.php' );
}