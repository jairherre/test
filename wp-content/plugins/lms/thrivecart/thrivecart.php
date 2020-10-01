<?php

include_once LMS_DIR_PATH . '/thrivecart/config.php';
include_once LMS_DIR_PATH . '/thrivecart/class.thrivecart.settings.php';
include_once LMS_DIR_PATH . '/thrivecart/class.thrivecart.lms_access_mgmt.cdata.php';
include_once LMS_DIR_PATH . '/thrivecart/api.php';

add_action( 'init', 'thrivecart_lms_post_api_process' );

add_filter('lms_is_pg_added', 'lms_is_thrivecart_pg_added', 10, 1 );
function lms_is_thrivecart_pg_added( $enabled ){
    $is_thrivecart_integrated = ( get_option( 'lms_thrivecart_api_key' ) == '' ? false : true );
    if($is_thrivecart_integrated){
        return true;
    } else {
        return $enabled;
    }
}

add_action('lms_other_pg_integrated_message', 'lms_thrivecart_pg_integrated_message' );
function lms_thrivecart_pg_integrated_message(){
    $is_thrivecart_integrated = ( get_option( 'lms_thrivecart_api_key' ) == '' ? false : true );
    if($is_thrivecart_integrated){
        echo '<p>' . __( 'Thrivecart payment integrated', 'lms' ) . '</p>';
    } 
}

add_action('lms_accss_mgmt_integrations_list', 'lms_accss_mgmt_thrivecart_integrations_list', 10, 1);
function lms_accss_mgmt_thrivecart_integrations_list( $post_id ){
    $thrivecart_access_mgmt_id_product = get_post_meta( $post_id, 'thrivecart_access_mgmt_id_product', true );
    $thrivecart_access_mgmt_id_upsell = get_post_meta( $post_id, 'thrivecart_access_mgmt_id_upsell', true );
    $thrivecart_access_mgmt_id_downsell = get_post_meta( $post_id, 'thrivecart_access_mgmt_id_downsell', true );
    if ( $thrivecart_access_mgmt_id_product or $thrivecart_access_mgmt_id_upsell or $thrivecart_access_mgmt_id_downsell ) {
        echo '<strong>'.__( 'Thrivecart', 'lms' ).'</strong>';
        echo '<br>';
        if ( $thrivecart_access_mgmt_id_product ) {
            echo __( 'Product ID', 'lms' ) . ' ' . $thrivecart_access_mgmt_id_product;
            echo '<br>';
        }
        if ( $thrivecart_access_mgmt_id_upsell ) {
            echo __( 'Upsell ID', 'lms' ) . ' ' . $thrivecart_access_mgmt_id_upsell;
            echo '<br>';
        }
        if ( $thrivecart_access_mgmt_id_downsell ) {
            echo __( 'Downsell ID', 'lms' ) . ' ' . $thrivecart_access_mgmt_id_downsell;
            echo '<br>';
        }
    }
}