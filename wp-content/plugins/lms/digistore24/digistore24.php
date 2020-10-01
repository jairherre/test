<?php

include_once LMS_DIR_PATH . '/digistore24/class.digistore24.settings.php';
include_once LMS_DIR_PATH . '/digistore24/class.digistore24.lms_access_mgmt.cdata.php';
include_once LMS_DIR_PATH . '/digistore24/api.php';

add_action( 'init', 'digistore24_lms_post_api_process' );

add_filter('lms_is_pg_added', 'lms_is_digistore24_pg_added', 10, 1 );
function lms_is_digistore24_pg_added( $enabled ){
    $is_digistore24_integrated = ( get_option( 'lms_digistore24_api_key' ) == '' ? false : true );
    if($is_digistore24_integrated){
        return true;
    } else {
        return $enabled;
    }
}

add_action('lms_other_pg_integrated_message', 'lms_digistore24_pg_integrated_message' );
function lms_digistore24_pg_integrated_message(){
    $is_digistore24_integrated = ( get_option( 'lms_digistore24_api_key' ) == '' ? false : true );
    if($is_digistore24_integrated){
        echo '<p>' . __( 'Digistore24 payment integrated', 'lms' ) . '</p>';
    } 
}

add_action('lms_accss_mgmt_integrations_list', 'lms_accss_mgmt_digistore24_integrations_list', 10, 1);
function lms_accss_mgmt_digistore24_integrations_list( $post_id ){
    $digistore24_access_mgmt_id_product = get_post_meta( $post_id, 'digistore24_access_mgmt_id_product', true );
    if ( $digistore24_access_mgmt_id_product ) {
        echo '<strong>'.__( 'Digistore24', 'lms' ).'</strong>';
        echo '<br>';
        if ( $digistore24_access_mgmt_id_product ) {
            echo __( 'Product ID', 'lms' ) . ' ' . $digistore24_access_mgmt_id_product;
            echo '<br>';
        }
    }
}