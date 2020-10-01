<?php

include_once TG_DIR_PATH . '/copecart/class.copecart.settings.php';
include_once TG_DIR_PATH . '/copecart/class.copecart.tg_access_mgmt.cdata.php';
include_once TG_DIR_PATH . '/copecart/api.php';

add_action( 'init', 'copecart_tg_post_api_process' );

add_filter('tg_is_pg_added', 'tg_is_copecart_pg_added', 10, 1 );
function tg_is_copecart_pg_added( $enabled ){
    $is_copecart_integrated = ( get_option( 'tg_copecart_api_key' ) == '' ? false : true );
    if($is_copecart_integrated){
        return true;
    } else {
        return $enabled;
    }
}

add_action('tg_other_pg_integrated_message', 'tg_copecart_pg_integrated_message' );
function tg_copecart_pg_integrated_message(){
    $is_copecart_integrated = ( get_option( 'tg_copecart_api_key' ) == '' ? false : true );
    if($is_copecart_integrated){
        echo '<p>' . __( 'CopeCart payment integrated', 'teachground' ) . '</p>';
    } 
}

add_action('tg_accss_mgmt_integrations_list', 'tg_accss_mgmt_copecart_integrations_list', 10, 1);
function tg_accss_mgmt_copecart_integrations_list( $post_id ){
    $copecart_access_mgmt_id_product = get_post_meta( $post_id, 'copecart_access_mgmt_id_product', true );
    if ( $copecart_access_mgmt_id_product ) {
        echo '<strong>'.__( 'CopeCart', 'teachground' ).'</strong>';
        echo '<br>';
        if ( $copecart_access_mgmt_id_product ) {
            echo __( 'Product ID', 'teachground' ) . ' ' . $copecart_access_mgmt_id_product;
            echo '<br>';
        }
    }
}