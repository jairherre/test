<?php

if ( ! defined( 'ABSPATH' ) ) { exit; }

function thrivecart_lms_post_api_process(){
	
	if( isset( $_REQUEST['thlmsapi'] ) and $_REQUEST['thlmsapi'] == 'true' ){
		
		$enable_log = true;
		$log_file = dirname( __FILE__ ) . '/thrive.log';
		$log = time();
		
		$response = $_POST;
		/*$response = json_decode('{"event":"order.success","mode":"test","mode_int":"1","thrivecart_account":"engaging","thrivecart_secret":"IT1S18GZCBU6","base_product":"2","order_id":"1007038","invoice_id":"000000004","order_date":"2018-10-15 10:04:38","order_timestamp":"1539597878","currency":"EUR","customer_id":"4244502","customer_identifier":"null","customer":{"id":"4244502","email":"demoforafo@gmail.com","address":{"country":"IN","zip":"ew"},"ip_address":"122.176.96.42","name":" ","checkbox_confirmation":"false","first_name":"demo","last_name":"afo"},"order":{"tax":"null","tax_type":"in","processor":"paypal","total":"3000","total_str":"30.00","charges":[{"name":"HostingBuddy Starter Paket","reference":"2","amount":"3000","amount_str":"30.00","type":"single","quantity":"1","payment_plan_id":"78572","payment_plan_name":"Monatlich (30 \u20ac\/Monat)"},{"name":"HostingBuddy Starter Paket","reference":"2","amount":"3000","amount_str":"30.00","type":"recurring","quantity":"1","frequency":"month","payment_plan_id":"78572","payment_plan_name":"Monatlich (30 \u20ac\/Monat)"}],"date":"2018-10-15 10:04:39","date_unix":"1539597879"},"transactions":{"product-2":"false"},"subscriptions":{"product-2":"false"},"purchases":["HostingBuddy Starter Paket"],"purchase_map":["product-2"],"purchase_map_flat":"product-2","fulfillment":{"url":"https:\/\/engaging.thrivecart.com\/hostingbuddy-starter-paket\/confirm\/\/"}}', true);*/
		
		$action = sanitize_text_field( @$response['event'] );
		$thrivecart_secret = sanitize_text_field( @$response['thrivecart_secret'] );
		$lms_thrivecart_secret = get_option( 'lms_thrivecart_api_key' );
		
		if( $thrivecart_secret == $lms_thrivecart_secret ){
			
			switch ($action) {
				case 'order.success':
					$lms_access_mgmt_data_ids = array();
					$lms_course_data_ids = array();
					$base_product = sanitize_text_field( $response['base_product'] );
					$user_email   = sanitize_text_field( $response['customer']['email'] );
					$first_name   = sanitize_text_field( $response['customer']['first_name'] );
					$last_name    = sanitize_text_field( $response['customer']['last_name'] );
					$password 	  = wp_generate_password();
					$purchase_map = $response['purchase_map'];
					
					if ( !email_exists( $user_email ) ) {
						$userdata = array(
							'user_login' 	 		=> $user_email,
							'user_email'  			=> $user_email,
							'user_pass' 		 	=> $password,
						);
						
						if( !empty($first_name) ){
							$userdata['first_name'] = $first_name;
						}
						if( !empty($last_name) ){
							$userdata['last_name'] = $last_name;
						}
						
						$temp_data = array( 'email' => $user_email, 'password' => base64_encode( $password ) );
						update_option( 'lms_temp_pass_' . $user_email, $temp_data );
						//$user_id = wp_insert_user( $userdata ) ;
						$user_id = lms_register_user( $userdata );
						$log .= ', new user created with user_id ' . $user_id;
					} else {
						$user = get_user_by( 'email', $user_email );
						$user_id = $user->ID;
						$log .= ', user already exists with user_id ' . $user_id;
					}
					
					// no of purchases 
					
					$product_count = count( $purchase_map );
					if( $product_count == 2 ){ // double purchase ( product + upsell / downsell )
						
						$second_product = $purchase_map[1];
						if (strpos($second_product, 'upsell') !== false) {
							$second_product_type = 'upsell';
						} else if(strpos($second_product, 'downsell') !== false){
							$second_product_type = 'downsell';
						}
						$second_product_data_array = explode('-',$second_product);
						$second_product_id = $second_product_data_array[1];
						
					}
						
					// get mapped AM from lms for product //
					$args = array(
					  'numberposts' => -1,
					  'post_type'   => array( 'lms_access_mgmt' ),
					  'meta_query' => array(
							array(
								'key' => 'thrivecart_access_mgmt_id_product',
								'value' => $base_product,
								'type' => 'numeric',
								'compare' => '='
							)
						)
					);
					
					$lms_access_mgmt_datas = get_posts( $args );
					
					if ( $lms_access_mgmt_datas ) {
						foreach ( $lms_access_mgmt_datas as $lms_access_mgmt_data ) :
							setup_postdata( $lms_access_mgmt_data ); 
							$lms_access_mgmt_data_ids[] = $lms_access_mgmt_data->ID;
						endforeach; 
						wp_reset_postdata();
					}
					// get mapped AM from lms for product //
					
					// get mapped AM from lms for upsell / downsell //
					if( $product_count == 2 ){
						
						if( $second_product_type == 'upsell' ){
							$meta_key = 'thrivecart_access_mgmt_id_upsell';
						} elseif( $second_product_type == 'downsell' ){
							$meta_key = 'thrivecart_access_mgmt_id_downsell';
						}
						
						$args = array(
						  'numberposts' => -1,
						  'post_type'   => array( 'lms_access_mgmt' ),
						  'meta_query' => array(
								array(
									'key' => $meta_key,
									'value' => $second_product_id,
									'type' => 'numeric',
									'compare' => '='
								)
							)
						);
						
						$lms_access_mgmt_datas = get_posts( $args );
						
						if ( $lms_access_mgmt_datas ) {
							foreach ( $lms_access_mgmt_datas as $lms_access_mgmt_data ) :
								setup_postdata( $lms_access_mgmt_data ); 
								$lms_access_mgmt_data_ids[] = $lms_access_mgmt_data->ID;
							endforeach; 
							wp_reset_postdata();
						}
					}
					// get mapped AM from lms for upsell / downsell //
					
					 // get mapped courses //
					/*if( is_array( $lms_access_mgmt_data_ids ) and count($lms_access_mgmt_data_ids) ){
						foreach( $lms_access_mgmt_data_ids as $value ){
							$course_ids = lms_get_courses_from_am_id($value);
							if(is_array($course_ids)){
								foreach( $course_ids as $cid ){
									$lms_course_data_ids[] = $cid;
								}
							}
						}
					}*/
					
					// get mapped courses //
					/*if( !empty($user_id) ){
						if( is_array( $lms_course_data_ids ) and count($lms_course_data_ids) ){
							foreach( $lms_course_data_ids as $value ){
								//llms_enroll_student( $user_id, $value, 'api' );
								lms_assign_user_to_course( array('user_id' => $user_id, 'course_id' => $value, 'status' => 'Active' ) );
								$log .= ', user enrolled to course ' . $value;
							}
						} else {
							$log .= ', courses not found';
						}
					} else {
						$log .= ', user not found';
					}*/
					 
					// assign user to acccess management //
					if( !empty($user_id) ){
						if( is_array( $lms_access_mgmt_data_ids ) and count($lms_access_mgmt_data_ids) ){
							foreach( $lms_access_mgmt_data_ids as $value ){
								lms_assign_user_to_am( array( 'am_id' => $value, 'user_id' => $user_id, 'added_on' => date( "Y-m-d H:i:s" ), 'status' => 'Active' ) );
								$log .= ', user added to access management ' . $value;
							}
						}
					} else {
						$log .= ', user not found';
					}
					// assign user to acccess management //

					// add order log //
						lms_add_order( array( 'user_id' => $user_id, 'payment_gateway' => 'thrivecart', 'payment_gateway_order_id' => $response['order_id'] ) );
					// add order log //

					break;
				case 'order.refund':
					$lms_access_mgmt_data_ids = array();
					$lms_course_data_ids = array();
					$user_email   = sanitize_text_field( $response['customer']['email'] );
					$first_name   = sanitize_text_field( $response['customer']['first_name'] );
					$last_name    = sanitize_text_field( $response['customer']['last_name'] );
					$refund_data  = $response['refund'];
					$product_type = $refund_data['type'];
					$product_id = $refund_data['id'];
					
					if( $product_type == 'product' ){
						$meta_key = 'thrivecart_access_mgmt_id_product';
					} elseif( $product_type == 'upsell' ){
						$meta_key = 'thrivecart_access_mgmt_id_upsell';
					} elseif( $product_type == 'downsell' ){
						$meta_key = 'thrivecart_access_mgmt_id_downsell';
					}
					
					if ( email_exists( $user_email ) ) {
						$user = get_user_by( 'email', $user_email );
						$user_id = $user->ID;
						$log .= ', user found with user_id ' . $user_id;
						
						// get mapped AM from lms
						$args = array(
						  'numberposts' => -1,
						  'post_type'   => array( 'lms_access_mgmt' ),
						  'meta_query' => array(
								array(
									'key' => $meta_key,
									'value' => $product_id,
									'type' => 'numeric',
									'compare' => '='
								)
							)
						);
						$lms_access_mgmt_datas = get_posts( $args );
						
						if ( $lms_access_mgmt_datas ) {
							foreach ( $lms_access_mgmt_datas as $lms_access_mgmt_data ) :
								setup_postdata( $lms_access_mgmt_data ); 
								$lms_access_mgmt_data_ids[] = $lms_access_mgmt_data->ID;
							endforeach; 
							wp_reset_postdata();
						}
						
						// get mapped courses //
						/* if( is_array( $lms_access_mgmt_data_ids ) and count($lms_access_mgmt_data_ids) ){
							foreach( $lms_access_mgmt_data_ids as $value ){
								$course_ids = lms_get_courses_from_am_id($value);
								if(is_array($course_ids)){
									foreach( $course_ids as $cid ){
										$lms_course_data_ids[] = $cid;
									}
								}
							}
						} */
						// get mapped courses //
					
						/* if ( $lms_course_data_ids ) {
							foreach ( $lms_course_data_ids as $value ) :
								unmap_user_from_course( array('user_id' => $user_id, 'course_id' => $value ) );
								//llms_unenroll_student( $user_id, $value, 'api' );
								$log .= ', user unenrolled from course ' . $value;
							endforeach; 
							wp_reset_postdata();
						} else {
							$log .= ', courses not found';
						} */

						// unassign user from acccess management //
						if( is_array( $lms_access_mgmt_data_ids ) and count($lms_access_mgmt_data_ids) ){
							foreach( $lms_access_mgmt_data_ids as $value ){
								unmap_user_from_am( array( 'am_id' => $value, 'user_id' => $user_id ) );
								$log .= ', user removed from access management ' . $value;
							}
						}
						// unassign user from acccess management //
						
						// delete order log //
						lms_delete_order( array( 'user_id' => $user_id, 'payment_gateway' => 'thrivecart', 'payment_gateway_order_id' => $response['order_id'] ) );
						// delete order log //

					} else {
						$log .= ', user not found';
					}
					break;
				default:
					$log .= ', no event found';
			}
		} else {
			$log .= ', API key not matched';
		}
		
		if( $enable_log ){
			$handle = fopen( $log_file, 'a' ) or die( 'Cannot open file:  ' . $log_file );
			$data = json_encode($response);
			//$data = $log;
			$data .= "\n";
			fwrite( $handle, $data );
			fclose($handle);
		}
		
		echo json_encode( array('status' => 200, 'message' => $log ) );
		exit;
	}
	
}
