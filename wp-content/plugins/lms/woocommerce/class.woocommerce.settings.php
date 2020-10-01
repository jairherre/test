<?php

if ( ! defined( 'ABSPATH' ) ) { exit; }

add_action( 'lms_custom_settings_tab', 'woocommerce_lms_tab' );
add_action( 'lms_custom_settings_tab_content', 'woocommerce_lms_tab_content' );

add_filter( 'lms_default_options_data', 'lms_woocommerce_data', 10, 1 );

function lms_woocommerce_data( $data ){
	$data['lms_woocommerce_enabled'] = array( 'sanitization' => 'sanitize_text_field' );
	return $data;
}

function woocommerce_lms_tab(){
	include( LMS_DIR_PATH . '/woocommerce/view/admin/tab.php' );
}

function woocommerce_lms_tab_content(){
	$lms_woocommerce_enabled = get_option('lms_woocommerce_enabled');
	include( LMS_DIR_PATH . '/woocommerce/view/admin/settings.php' );
}