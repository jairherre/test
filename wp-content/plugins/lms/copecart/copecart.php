<?php

include_once LMS_DIR_PATH . '/copecart/class.copecart.settings.php';
include_once LMS_DIR_PATH . '/copecart/class.copecart.lms_access_mgmt.cdata.php';
include_once LMS_DIR_PATH . '/copecart/api.php';

add_action( 'init', 'copecart_lms_post_api_process' );

add_filter('lms_is_pg_added', 'lms_is_copecart_pg_added', 10, 1 );
function lms_is_copecart_pg_added( $enabled ){
    $is_copecart_integrated = ( get_option( 'lms_copecart_api_key' ) == '' ? false : true );
    if($is_copecart_integrated){
        return true;
    } else {
        return $enabled;
    }
}

add_action('lms_other_pg_integrated_message', 'lms_copecart_pg_integrated_message' );
function lms_copecart_pg_integrated_message(){
    $is_copecart_integrated = ( get_option( 'lms_copecart_api_key' ) == '' ? false : true );
    if($is_copecart_integrated){
        echo '<p>' . __( 'CopeCart payment integrated', 'lms' ) . '</p>';
    } 
}

add_action('lms_accss_mgmt_integrations_list', 'lms_accss_mgmt_copecart_integrations_list', 10, 1);
function lms_accss_mgmt_copecart_integrations_list( $post_id ){
    $copecart_access_mgmt_id_product = get_post_meta( $post_id, 'copecart_access_mgmt_id_product', true );
    if ( $copecart_access_mgmt_id_product ) {
        echo '<strong>'.__( 'CopeCart', 'lms' ).'</strong>';
        echo '<br>';
        if ( $copecart_access_mgmt_id_product ) {
            echo __( 'Product ID', 'lms' ) . ' ' . $copecart_access_mgmt_id_product;
            echo '<br>';
        }
    }
}