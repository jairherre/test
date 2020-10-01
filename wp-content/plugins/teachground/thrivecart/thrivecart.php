<?php

include_once TG_DIR_PATH . '/thrivecart/config.php';
include_once TG_DIR_PATH . '/thrivecart/class.thrivecart.settings.php';
include_once TG_DIR_PATH . '/thrivecart/class.thrivecart.tg_access_mgmt.cdata.php';
include_once TG_DIR_PATH . '/thrivecart/api.php';

add_action( 'init', 'thrivecart_tg_post_api_process' );

add_filter('tg_is_pg_added', 'tg_is_thrivecart_pg_added', 10, 1 );
function tg_is_thrivecart_pg_added( $enabled ){
    $is_thrivecart_integrated = ( get_option( 'tg_thrivecart_api_key' ) == '' ? false : true );
    if($is_thrivecart_integrated){
        return true;
    } else {
        return $enabled;
    }
}

add_action('tg_other_pg_integrated_message', 'tg_thrivecart_pg_integrated_message' );
function tg_thrivecart_pg_integrated_message(){
    $is_thrivecart_integrated = ( get_option( 'tg_thrivecart_api_key' ) == '' ? false : true );
    if($is_thrivecart_integrated){
        echo '<p>' . __( 'Thrivecart payment integrated', 'teachground' ) . '</p>';
    } 
}

add_action('tg_accss_mgmt_integrations_list', 'tg_accss_mgmt_thrivecart_integrations_list', 10, 1);
function tg_accss_mgmt_thrivecart_integrations_list( $post_id ){
    $thrivecart_access_mgmt_id_product = get_post_meta( $post_id, 'thrivecart_access_mgmt_id_product', true );
    $thrivecart_access_mgmt_id_upsell = get_post_meta( $post_id, 'thrivecart_access_mgmt_id_upsell', true );
    $thrivecart_access_mgmt_id_downsell = get_post_meta( $post_id, 'thrivecart_access_mgmt_id_downsell', true );
    if ( $thrivecart_access_mgmt_id_product or $thrivecart_access_mgmt_id_upsell or $thrivecart_access_mgmt_id_downsell ) {
        echo '<strong>'.__( 'Thrivecart', 'teachground' ).'</strong>';
        echo '<br>';
        if ( $thrivecart_access_mgmt_id_product ) {
            echo __( 'Product ID', 'teachground' ) . ' ' . $thrivecart_access_mgmt_id_product;
            echo '<br>';
        }
        if ( $thrivecart_access_mgmt_id_upsell ) {
            echo __( 'Upsell ID', 'teachground' ) . ' ' . $thrivecart_access_mgmt_id_upsell;
            echo '<br>';
        }
        if ( $thrivecart_access_mgmt_id_downsell ) {
            echo __( 'Downsell ID', 'teachground' ) . ' ' . $thrivecart_access_mgmt_id_downsell;
            echo '<br>';
        }
    }
}