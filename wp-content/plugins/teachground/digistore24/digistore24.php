<?php

include_once TG_DIR_PATH . '/digistore24/class.digistore24.settings.php';
include_once TG_DIR_PATH . '/digistore24/class.digistore24.tg_access_mgmt.cdata.php';
include_once TG_DIR_PATH . '/digistore24/api.php';

add_action( 'init', 'digistore24_tg_post_api_process' );

add_filter('tg_is_pg_added', 'tg_is_digistore24_pg_added', 10, 1 );
function tg_is_digistore24_pg_added( $enabled ){
    $is_digistore24_integrated = ( get_option( 'tg_digistore24_api_key' ) == '' ? false : true );
    if($is_digistore24_integrated){
        return true;
    } else {
        return $enabled;
    }
}

add_action('tg_other_pg_integrated_message', 'tg_digistore24_pg_integrated_message' );
function tg_digistore24_pg_integrated_message(){
    $is_digistore24_integrated = ( get_option( 'tg_digistore24_api_key' ) == '' ? false : true );
    if($is_digistore24_integrated){
        echo '<p>' . __( 'Digistore24 payment integrated', 'teachground' ) . '</p>';
    } 
}

add_action('tg_accss_mgmt_integrations_list', 'tg_accss_mgmt_digistore24_integrations_list', 10, 1);
function tg_accss_mgmt_digistore24_integrations_list( $post_id ){
    $digistore24_access_mgmt_id_product = get_post_meta( $post_id, 'digistore24_access_mgmt_id_product', true );
    if ( $digistore24_access_mgmt_id_product ) {
        echo '<strong>'.__( 'Digistore24', 'teachground' ).'</strong>';
        echo '<br>';
        if ( $digistore24_access_mgmt_id_product ) {
            echo __( 'Product ID', 'teachground' ) . ' ' . $digistore24_access_mgmt_id_product;
            echo '<br>';
        }
    }
}