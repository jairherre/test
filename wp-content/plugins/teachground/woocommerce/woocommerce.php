<?php
include_once TG_DIR_PATH . '/woocommerce/class.woocommerce.settings.php';
include_once TG_DIR_PATH . '/woocommerce/class.woocommerce.tg_access_mgmt.cdata.php';
include_once TG_DIR_PATH . '/woocommerce/api.php';

add_filter('tg_is_pg_added', 'tg_is_woocommerce_pg_added', 10, 1 );
function tg_is_woocommerce_pg_added( $enabled ){
    if(get_option('tg_woocommerce_enabled') == 'yes'){
        return true;
    } else {
        return $enabled;
    }
}

add_action('tg_other_pg_integrated_message', 'tg_woocommerce_pg_integrated_message' );
function tg_woocommerce_pg_integrated_message(){
    if(get_option('tg_woocommerce_enabled') == 'yes'){
        echo '<p>' . __( 'Woocommerce payment integrated', 'teachground' ) . '</p>';
    } 
}

add_action('tg_accss_mgmt_integrations_list', 'tg_accss_mgmt_woocommerce_integrations_list', 10, 1);
function tg_accss_mgmt_woocommerce_integrations_list( $post_id ){
    $woocommerce_access_mgmt_id_product = get_post_meta( $post_id, 'woocommerce_access_mgmt_id_product', true );
    if ( $woocommerce_access_mgmt_id_product ) {
        echo '<strong>'.__( 'Woocommerce', 'teachground' ).'</strong>';
        echo '<br>';
        if ( $woocommerce_access_mgmt_id_product ) {
            echo __( 'Product ID', 'teachground' ) . ' ' . $woocommerce_access_mgmt_id_product;
            echo '<br>';
        }
    }
}