<?php

if ( ! defined( 'ABSPATH' ) ) { exit; }

add_action( 'tg_custom_settings_tab', 'woocommerce_tg_tab' );
add_action( 'tg_custom_settings_tab_content', 'woocommerce_tg_tab_content' );

add_filter( 'tg_default_options_data', 'tg_woocommerce_data', 10, 1 );

function tg_woocommerce_data( $data ){
	$data['tg_woocommerce_enabled'] = array( 'sanitization' => 'sanitize_text_field' );
	return $data;
}

function woocommerce_tg_tab(){
	include( TG_DIR_PATH . '/woocommerce/view/admin/tab.php' );
}

function woocommerce_tg_tab_content(){
	$tg_woocommerce_enabled = get_option('tg_woocommerce_enabled');
	include( TG_DIR_PATH . '/woocommerce/view/admin/settings.php' );
}