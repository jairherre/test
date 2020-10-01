<?php
include_once LMS_DIR_PATH . '/woocommerce/class.woocommerce.settings.php';
include_once LMS_DIR_PATH . '/woocommerce/class.woocommerce.lms_access_mgmt.cdata.php';
include_once LMS_DIR_PATH . '/woocommerce/api.php';

add_filter('lms_is_pg_added', 'lms_is_woocommerce_pg_added', 10, 1 );
function lms_is_woocommerce_pg_added( $enabled ){
    if(get_option('lms_woocommerce_enabled') == 'yes'){
        return true;
    } else {
        return $enabled;
    }
}

add_action('lms_other_pg_integrated_message', 'lms_woocommerce_pg_integrated_message' );
function lms_woocommerce_pg_integrated_message(){
    if(get_option('lms_woocommerce_enabled') == 'yes'){
        echo '<p>' . __( 'Woocommerce payment integrated', 'lms' ) . '</p>';
    } 
}

add_action('lms_accss_mgmt_integrations_list', 'lms_accss_mgmt_woocommerce_integrations_list', 10, 1);
function lms_accss_mgmt_woocommerce_integrations_list( $post_id ){
    $woocommerce_access_mgmt_id_product = get_post_meta( $post_id, 'woocommerce_access_mgmt_id_product', true );
    if ( $woocommerce_access_mgmt_id_product ) {
        echo '<strong>'.__( 'Woocommerce', 'lms' ).'</strong>';
        echo '<br>';
        if ( $woocommerce_access_mgmt_id_product ) {
            echo __( 'Product ID', 'lms' ) . ' ' . $woocommerce_access_mgmt_id_product;
            echo '<br>';
        }
    }
}