<?php

if ( ! defined( 'ABSPATH' ) ) { exit; }

class LMS_copecart_AccessMgmt_Cdata {
	
	public function __construct(){
		if(get_option('lms_copecart_api_key')){
			add_action( 'add_meta_boxes_lms_access_mgmt', array( $this, 'copecart_access_mgmt_cdata' ) );
		}
		add_action( 'save_post', array( $this, 'copecart_save_access_mgmt_cdata' ) );
	}
	
	public function copecart_save_access_mgmt_cdata( $post_id ) {
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
		
		if( isset($_REQUEST['copecart_access_mgmt_id_product']) ){
			$copecart_access_mgmt_id_product = sanitize_text_field($_REQUEST['copecart_access_mgmt_id_product']);
			update_post_meta( $post_id, 'copecart_access_mgmt_id_product', $copecart_access_mgmt_id_product );
		} else {
			delete_post_meta( $post_id, 'copecart_access_mgmt_id_product' );
		}
		
	}
	
	public function copecart_access_mgmt_cdata( $post ) {
		add_meta_box(
			'copecart_access_mgmt_cdata',
			__( 'CopeCart' ),
			array( $this, 'copecart_access_mgmt_cdata_callback' ) , $post->post_type, 'side' );
	}

	public function copecart_access_mgmt_cdata_callback( $post ) {
		wp_nonce_field( 'attachment_meta_box', 'attachment_meta_box_nonce' );
		$copecart_access_mgmt_id_product = get_post_meta( $post->ID, 'copecart_access_mgmt_id_product', true );
			
		echo '<p><strong>'.__('CopeCart Product ID').'</strong></p>';
		echo '<p><input type="text" name="copecart_access_mgmt_id_product" value="'.$copecart_access_mgmt_id_product.'" class="widefat"><br><i>Enter Product ID from <a href="https://copecart.com/" target="_blank">copecart.com</a></i></p>';
		
	}
	
}

return new LMS_copecart_AccessMgmt_Cdata();
