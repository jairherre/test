<?php

if ( ! defined( 'ABSPATH' ) ) { exit; }

add_action( 'tg_custom_settings_tab', 'copecart_tg_tab' );
add_action( 'tg_custom_settings_tab_content', 'copecart_tg_tab_content' );

add_filter( 'tg_default_options_data', 'tg_copecart_data', 10, 1 );

function tg_copecart_data( $data ){
	$data['tg_copecart_api_key'] = array( 'sanitization' => 'sanitize_text_field' );
	return $data;
}

function copecart_tg_tab(){
	include( TG_DIR_PATH . '/copecart/view/admin/tab.php' );
}

function copecart_tg_tab_content(){
	$tg_copecart_api_key = get_option('tg_copecart_api_key');
	include( TG_DIR_PATH . '/copecart/view/admin/settings.php' );
}