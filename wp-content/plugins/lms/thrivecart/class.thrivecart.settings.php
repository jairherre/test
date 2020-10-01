<?php

if ( ! defined( 'ABSPATH' ) ) { exit; }

add_action( 'lms_custom_settings_tab', 'thrivecart_lms_tab' );
add_action( 'lms_custom_settings_tab_content', 'thrivecart_lms_tab_content' );

add_filter( 'lms_default_options_data', 'lms_thrivecart_data', 10, 1 );

function lms_thrivecart_data( $data ){
	$data['lms_thrivecart_id'] = array( 'sanitization' => 'sanitize_text_field' );
	$data['lms_thrivecart_api_key'] = array( 'sanitization' => 'sanitize_text_field' );
	return $data;
}

function thrivecart_lms_tab(){
	include( LMS_DIR_PATH . '/thrivecart/view/admin/tab.php' );
}

function thrivecart_lms_tab_content(){
	$lms_thrivecart_id = get_option('lms_thrivecart_id');
	$lms_thrivecart_api_key = get_option('lms_thrivecart_api_key');
	include( LMS_DIR_PATH . '/thrivecart/view/admin/settings.php' );
}