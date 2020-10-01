<?php

if ( ! defined( 'ABSPATH' ) ) { exit; }

add_action( 'lms_custom_settings_tab', 'copecart_lms_tab' );
add_action( 'lms_custom_settings_tab_content', 'copecart_lms_tab_content' );

add_filter( 'lms_default_options_data', 'lms_copecart_data', 10, 1 );

function lms_copecart_data( $data ){
	$data['lms_copecart_api_key'] = array( 'sanitization' => 'sanitize_text_field' );
	return $data;
}

function copecart_lms_tab(){
	include( LMS_DIR_PATH . '/copecart/view/admin/tab.php' );
}

function copecart_lms_tab_content(){
	$lms_copecart_api_key = get_option('lms_copecart_api_key');
	include( LMS_DIR_PATH . '/copecart/view/admin/settings.php' );
}