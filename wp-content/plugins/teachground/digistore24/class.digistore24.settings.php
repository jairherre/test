<?php

if ( ! defined( 'ABSPATH' ) ) { exit; }

add_action( 'tg_custom_settings_tab', 'digistore24_tg_tab' );
add_action( 'tg_custom_settings_tab_content', 'digistore24_tg_tab_content' );

add_filter( 'tg_default_options_data', 'tg_digistore24_data', 10, 1 );

function tg_digistore24_data( $data ){
	$data['tg_digistore24_api_key'] = array( 'sanitization' => 'sanitize_text_field' );
	return $data;
}

function digistore24_tg_tab(){
	include( TG_DIR_PATH . '/digistore24/view/admin/tab.php' );
}

function digistore24_tg_tab_content(){
	$tg_digistore24_api_key = get_option('tg_digistore24_api_key');
	include( TG_DIR_PATH . '/digistore24/view/admin/settings.php' );
}