<?php

if ( ! defined( 'ABSPATH' ) ) { exit; }

function copecart_tg_post_api_process(){
	
	if( isset( $_REQUEST['cctgapi'] ) and $_REQUEST['cctgapi'] == 'true' ){
		
		$enable_log = true;
		$log_file = dirname( __FILE__ ) . '/copecart.log';
		$log = time();

		// $copecart_signature = $_SERVER['X-Copecart-Signature']; 
		// $generated_signature = base64_encode(hash_hmac('sha256', $message, $shared_secret, TRUE)); 
		// if($copecart_signature == $generated_signature) { 
		// // IPN message is varified 
		// }

		$ipn_data = file_get_contents('php://input');
		/* $ipn_data = '{"affiliate":null,"buyer_address":null,"buyer_city":null,"buyer_company_name":"","buyer_country":"Indien","buyer_email":"test@test.com","buyer_firstname":"test","buyer_id":"9d16ac484f87950c","buyer_lastname":"test","buyer_phone_number":null,"buyer_vat_number":"","buyer_zipcode":null,"category_name":null,"category_option_name":null,"earned_amount":"0","first_payment":"100.0","frequency":null,"is_cancelled_for":null,"next_payment_at":null,"next_payments":null,"order_date":"2020-01-14","order_id":"sN5viYq0","order_time":"2020-01-14T11:57:00.000+00:00","order_source_identifier":null,"payment_method":"test","payment_plan":"one_time_payment","payment_status":"test_paid","product_id":"e232d769","product_name":"TG Test","product_type":"digital","quantity":1,"rate_number":1,"shipping_price":"0.0","tags":[],"test_payment":true,"total_number_of_payments":null,"transaction_amount":"100.0","transaction_currency":"EUR","transaction_date":"2020-01-14T11:57:27.631+01:00","transaction_id":"dda4378643f3115d","transaction_processed_at":"2020-01-14T11:57:27.631+01:00","transaction_type":"sale","event_type":"payment.made"}'; */
		$ipn_data = json_decode($ipn_data);

		$event = $ipn_data->event_type;

		 switch ($event){

			case 'payment.made':{

				$order_id = $ipn_data->order_id;
				$product_id   = $ipn_data->product_id;
				$product_name = $ipn_data->product_name;

				$tg_access_mgmt_data_ids 	= array();
				$tg_course_data_ids 		= array();
				$user_email             	= $ipn_data->buyer_email;
				$first_name             	= $ipn_data->buyer_firstname;
				$last_name              	= $ipn_data->buyer_lastname;
				$password 	  				= wp_generate_password();
				
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
                    update_option( 'tg_temp_pass_' . $user_email, $temp_data );
                    //$user_id = wp_insert_user( $userdata ) ;
                    $user_id = tg_register_user( $userdata );
                    $log .= ', new user created with user_id ' . $user_id;
                } else {
                    $user = get_user_by( 'email', $user_email );
                    $user_id = $user->ID;
                    $log .= ', user already exists with user_id ' . $user_id;
                }
                
                // get mapped AM from tg for product //
					$args = array(
                        'numberposts' => -1,
                        'post_type'   => array( 'tg_access_mgmt' ),
                        'meta_query' => array(
                              array(
                                  'key' => 'copecart_access_mgmt_id_product',
                                  'value' => $product_id,
                                  'type' => 'numeric',
                                  'compare' => '='
                              )
                          )
                      );
                      
                      $tg_access_mgmt_datas = get_posts( $args );
                      
                      if ( $tg_access_mgmt_datas ) {
                          foreach ( $tg_access_mgmt_datas as $tg_access_mgmt_data ) :
                              setup_postdata( $tg_access_mgmt_data ); 
                              $tg_access_mgmt_data_ids[] = $tg_access_mgmt_data->ID;
                          endforeach; 
                          wp_reset_postdata();
                      }
                // get mapped AM from tg for product //
                    
				// assign user to acccess management //
				if( !empty($user_id) ){
					if( is_array( $tg_access_mgmt_data_ids ) and count($tg_access_mgmt_data_ids) ){
						foreach( $tg_access_mgmt_data_ids as $value ){
							tg_assign_user_to_am( array( 'am_id' => $value, 'user_id' => $user_id, 'added_on' => date( "Y-m-d H:i:s" ), 'status' => 'Active' ) );
							$log .= ', user added to access management ' . $value;
						}
					}
				} else {
					$log .= ', user not found';
				}
				// assign user to acccess management //

				// add order log //
				tg_add_order( array( 'user_id' => $user_id, 'payment_gateway' => 'copecart', 'payment_gateway_order_id' => $order_id ) );
				// add order log //

				break;
			}
			case 'payment.refunded':{
				$order_id = $ipn_data->order_id;
				$product_id   = $ipn_data->product_id;
				$product_name = $ipn_data->product_name;

				$tg_access_mgmt_data_ids 	= array();
				$tg_course_data_ids 		= array();
				$user_email             	= $ipn_data->buyer_email;
				
				if ( email_exists( $user_email ) ) {
					$user = get_user_by( 'email', $user_email );
					$user_id = $user->ID;
					$log .= ', user found with user_id ' . $user_id;
					
					// get mapped AM from tg for product //
						$args = array(
						'numberposts' => -1,
						'post_type'   => array( 'tg_access_mgmt' ),
						'meta_query' => array(
								array(
									'key' => 'copecart_access_mgmt_id_product',
									'value' => $product_id,
									'type' => 'numeric',
									'compare' => '='
								)
							)
						);
						
						$tg_access_mgmt_datas = get_posts( $args );
						
						if ( $tg_access_mgmt_datas ) {
							foreach ( $tg_access_mgmt_datas as $tg_access_mgmt_data ) :
								setup_postdata( $tg_access_mgmt_data ); 
								$tg_access_mgmt_data_ids[] = $tg_access_mgmt_data->ID;
							endforeach; 
							wp_reset_postdata();
						}
					// get mapped AM from tg for product //
					
					// unassign user from acccess management //
					if( is_array( $tg_access_mgmt_data_ids ) and count($tg_access_mgmt_data_ids) ){
						foreach( $tg_access_mgmt_data_ids as $value ){
							unmap_user_from_am( array( 'am_id' => $value, 'user_id' => $user_id ) );
							$log .= ', user removed from access management ' . $value;
						}
					}
					// unassign user from acccess management //
					
					// delete order log //
					tg_delete_order( array( 'user_id' => $user_id, 'payment_gateway' => 'copecart', 'payment_gateway_order_id' => $order_id ) );
					// delete order log //

				} else {
					$log .= ', user not found';
				}

				break;
			}
		}

		if( $enable_log ){
			$handle = fopen( $log_file, 'a' ) or die( 'Cannot open file:  ' . $log_file );
			//$data = json_encode($ipn_data);
			$data = $log;
			$data .= "\n";
			fwrite( $handle, $data );
			fclose($handle);
		}
		
		die('OK');
		exit;
	}
	
}
