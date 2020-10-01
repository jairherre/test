<?php

if ( ! defined( 'ABSPATH' ) ) { exit; }

class TG_Woocommerce_AccessMgmt_Cdata {
	
	public function __construct(){
		if(get_option('tg_woocommerce_enabled')){
			add_action( 'add_meta_boxes_tg_access_mgmt', array( $this, 'woocommerce_access_mgmt_cdata' ) );
		}
		add_action( 'save_post', array( $this, 'woocommerce_save_access_mgmt_cdata' ) );
	}
	
	public function woocommerce_save_access_mgmt_cdata( $post_id ) {
		if ( ! isset( $_POST['attachment_meta_box_nonce'] ) ) {
			return;
		}
	
		if ( ! wp_verify_nonce( $_POST['attachment_meta_box_nonce'], 'attachment_meta_box' ) ) {
			return;
		}
	
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
	
		if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {
	
			if ( ! current_user_can( 'edit_page', $post_id ) ) {
				return;
			}
	
		} else {
	
			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return;
			}
		}
		
		if( isset($_REQUEST['woocommerce_access_mgmt_id_product']) ){
			$woocommerce_access_mgmt_id_product = (int)sanitize_text_field($_REQUEST['woocommerce_access_mgmt_id_product']);
			update_post_meta( $post_id, 'woocommerce_access_mgmt_id_product', $woocommerce_access_mgmt_id_product );
		} else {
			delete_post_meta( $post_id, 'woocommerce_access_mgmt_id_product' );
		}
		
	}
	
	public function woocommerce_access_mgmt_cdata( $post ) {
		add_meta_box(
			'woocommerce_access_mgmt_cdata',
			__( 'Woocommerce','teachground' ),
			array( $this, 'woocommerce_access_mgmt_cdata_callback' ) , $post->post_type, 'side' );
	}

	public function woocommerce_access_mgmt_cdata_callback( $post ) {
		wp_nonce_field( 'attachment_meta_box', 'attachment_meta_box_nonce' );
		$woocommerce_access_mgmt_id_product = get_post_meta( $post->ID, 'woocommerce_access_mgmt_id_product', true );
			
		echo '<p><strong>'.__('Woocommerce Product ID','teachground').'</strong></p>';
		echo '<p><input type="text" name="woocommerce_access_mgmt_id_product" value="'.$woocommerce_access_mgmt_id_product.'" class="widefat"><br><i>'.__('Enter Product ID from','teachground').' <a href="edit.php?post_type=product" target="_blank">'.__('Woocommerce Products','teachground').'</a></i></p>';

	}
	
}

return new TG_Woocommerce_AccessMgmt_Cdata();
