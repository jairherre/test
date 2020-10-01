<?php

if ( ! defined( 'ABSPATH' ) ) { exit; }

class LMS_Thrivecart_AccessMgmt_Cdata {
	
	public function __construct(){
		if(get_option('lms_thrivecart_id')){
			add_action( 'add_meta_boxes_lms_access_mgmt', array( $this, 'thrivecart_access_mgmt_cdata' ) );
		}
		add_action( 'save_post', array( $this, 'thrivecart_save_access_mgmt_cdata' ) );
	}
	
	public function thrivecart_save_access_mgmt_cdata( $post_id ) {
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
		
		if( isset($_REQUEST['thrivecart_access_mgmt_id_product']) ){
			$thrivecart_access_mgmt_id_product = (int)sanitize_text_field($_REQUEST['thrivecart_access_mgmt_id_product']);
			update_post_meta( $post_id, 'thrivecart_access_mgmt_id_product', $thrivecart_access_mgmt_id_product );
		} else {
			delete_post_meta( $post_id, 'thrivecart_access_mgmt_id_product' );
		}
		
		if( isset($_REQUEST['thrivecart_access_mgmt_id_upsell']) ){
			$thrivecart_access_mgmt_id_upsell = (int)sanitize_text_field($_REQUEST['thrivecart_access_mgmt_id_upsell']);
			update_post_meta( $post_id, 'thrivecart_access_mgmt_id_upsell', abs($thrivecart_access_mgmt_id_upsell) );
		} else {
			delete_post_meta( $post_id, 'thrivecart_access_mgmt_id_upsell' );
		}
		
		if( isset($_REQUEST['thrivecart_access_mgmt_id_downsell']) ){
			$thrivecart_access_mgmt_id_downsell = (int)sanitize_text_field($_REQUEST['thrivecart_access_mgmt_id_downsell']);
			update_post_meta( $post_id, 'thrivecart_access_mgmt_id_downsell', abs($thrivecart_access_mgmt_id_downsell) );
		} else {
			delete_post_meta( $post_id, 'thrivecart_access_mgmt_id_downsell' );
		}
		
	}
	
	public function thrivecart_access_mgmt_cdata( $post ) {
		add_meta_box(
			'thrivecart_access_mgmt_cdata',
			__( 'Thrivecart' ),
			array( $this, 'thrivecart_access_mgmt_cdata_callback' ) , $post->post_type, 'side' );
	}

	public function thrivecart_access_mgmt_cdata_callback( $post ) {
		wp_nonce_field( 'attachment_meta_box', 'attachment_meta_box_nonce' );
		$thrivecart_access_mgmt_id_product = get_post_meta( $post->ID, 'thrivecart_access_mgmt_id_product', true );
		$thrivecart_access_mgmt_id_upsell = get_post_meta( $post->ID, 'thrivecart_access_mgmt_id_upsell', true );
		$thrivecart_access_mgmt_id_downsell = get_post_meta( $post->ID, 'thrivecart_access_mgmt_id_downsell', true );
			
		echo '<p><strong>'.__('Thrivecart Product ID').'</strong></p>';
		echo '<p><input type="text" name="thrivecart_access_mgmt_id_product" value="'.$thrivecart_access_mgmt_id_product.'" class="widefat"><br><i>Enter Product ID from <a href="https://thrivecart.com/" target="_blank">thrivecart.com</a></i></p>';
		
		echo '<p><strong>'.__('Thrivecart Upsell ID').'</strong></p>';
		echo '<p><input type="text" name="thrivecart_access_mgmt_id_upsell" value="'.$thrivecart_access_mgmt_id_upsell.'" class="widefat"><br><i>Enter Upsell ID from <a href="https://thrivecart.com/" target="_blank">thrivecart.com</a></i></p>';

		echo '<p><strong>'.__('Thrivecart Downsell ID').'</strong></p>';
		echo '<p><input type="text" name="thrivecart_access_mgmt_id_downsell" value="'.$thrivecart_access_mgmt_id_downsell.'" class="widefat"><br><i>Enter Downsell ID from <a href="https://thrivecart.com/" target="_blank">thrivecart.com</a></i></p>';
		
	}
	
}

return new LMS_Thrivecart_AccessMgmt_Cdata();
