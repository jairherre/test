<?php

if ( ! defined( 'ABSPATH' ) ) { exit; }

add_action( 'tg_custom_settings_tab', 'thrivecart_tg_tab' );
add_action( 'tg_custom_settings_tab_content', 'thrivecart_tg_tab_content' );

add_filter( 'tg_default_options_data', 'tg_thrivecart_data', 10, 1 );

function tg_thrivecart_data( $data ){
	$data['tg_thrivecart_id'] = array( 'sanitization' => 'sanitize_text_field' );
	$data['tg_thrivecart_api_key'] = array( 'sanitization' => 'sanitize_text_field' );
	return $data;
}

function thrivecart_tg_tab(){
	include( TG_DIR_PATH . '/thrivecart/view/admin/tab.php' );
}

function thrivecart_tg_tab_content(){
	$tg_thrivecart_id = get_option('tg_thrivecart_id');
	$tg_thrivecart_api_key = get_option('tg_thrivecart_api_key');
	include( TG_DIR_PATH . '/thrivecart/view/admin/settings.php' );
}