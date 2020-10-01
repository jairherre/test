<?php

if ( ! defined( 'ABSPATH' ) ) { exit; }

class TG_digistore24_AccessMgmt_Cdata {
	
	public function __construct(){
		if(get_option('tg_digistore24_api_key')){
			add_action( 'add_meta_boxes_tg_access_mgmt', array( $this, 'digistore24_access_mgmt_cdata' ) );
		}
		add_action( 'save_post', array( $this, 'digistore24_save_access_mgmt_cdata' ) );
	}
	
	public function digistore24_save_access_mgmt_cdata( $post_id ) {
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
		
		if( isset($_REQUEST['digistore24_access_mgmt_id_product']) ){
			$digistore24_access_mgmt_id_product = (int)sanitize_text_field($_REQUEST['digistore24_access_mgmt_id_product']);
			update_post_meta( $post_id, 'digistore24_access_mgmt_id_product', $digistore24_access_mgmt_id_product );
		} else {
			delete_post_meta( $post_id, 'digistore24_access_mgmt_id_product' );
		}
		
	}
	
	public function digistore24_access_mgmt_cdata( $post ) {
		add_meta_box(
			'digistore24_access_mgmt_cdata',
			__( 'Digistore24' ),
			array( $this, 'digistore24_access_mgmt_cdata_callback' ) , $post->post_type, 'side' );
	}

	public function digistore24_access_mgmt_cdata_callback( $post ) {
		wp_nonce_field( 'attachment_meta_box', 'attachment_meta_box_nonce' );
		$digistore24_access_mgmt_id_product = get_post_meta( $post->ID, 'digistore24_access_mgmt_id_product', true );
			
		echo '<p><strong>'.__('Digistore24 Product ID').'</strong></p>';
		echo '<p><input type="text" name="digistore24_access_mgmt_id_product" value="'.$digistore24_access_mgmt_id_product.'" class="widefat"><br><i>Enter Product ID from <a href="https://digistore24.com/" target="_blank">digistore24.com</a></i></p>';
		
	}
	
}

return new TG_digistore24_AccessMgmt_Cdata();
