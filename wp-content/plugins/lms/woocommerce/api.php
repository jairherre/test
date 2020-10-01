<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

add_action('woocommerce_thankyou', 'woocommerce_lms_api_process', 10, 1);
function woocommerce_lms_api_process( $order_id ) {
    if ( ! $order_id )
        return;

    if( ! get_post_meta( $order_id, '_lms_woo_thankyou_action_done', true ) ) {

        $enable_log = true;
		$log_file = dirname( __FILE__ ) . '/woocommerce.log';
        $log = time();
        
        $order = wc_get_order( $order_id );
        $user_email   = $order->get_billing_email();
        $first_name   = $order->get_shipping_first_name();
        $last_name    = $order->get_shipping_last_name();
        $password 	  = wp_generate_password();

        if($order->is_paid()){
            foreach ( $order->get_items() as $item_id => $item ) {
                $lms_access_mgmt_data_ids = array();
				$lms_course_data_ids = array();
                $product = $item->get_product();
                $product_id = $product->get_id();

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
                
                // get mapped AM from lms for product //
					$args = array(
                        'numberposts' => -1,
                        'post_type'   => array( 'lms_access_mgmt' ),
                        'meta_query' => array(
                              array(
                                  'key' => 'woocommerce_access_mgmt_id_product',
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
                // get mapped AM from lms for product //
                    
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
                
                    if( $enable_log ){
                        $handle = fopen( $log_file, 'a' ) or die( 'Cannot open file:  ' . $log_file );
                        $data = $log;
                        $data .= "\n";
                        fwrite( $handle, $data );
                        fclose($handle);
                    }
            }

            $order->update_meta_data( '_lms_woo_thankyou_action_done', true );
            $order->save();

            // add order log //
            lms_add_order( array( 'user_id' => $user_id, 'payment_gateway' => 'woocommerce', 'payment_gateway_order_id' => $order_id ) );
            // add order log //

        }
    }
}

add_action( 'woocommerce_order_refunded', 'woocommerce_lms_order_refunded_api_process', 10, 2 ); 
function woocommerce_lms_order_refunded_api_process( $order_id, $refund_id ) { 
    
    if ( ! $order_id )
    return;

    $enable_log = true;
    $log_file = dirname( __FILE__ ) . '/woocommerce.log';
    $log = time();

    $order = wc_get_order( $order_id );
    $user_email   = $order->get_billing_email();

    foreach ( $order->get_items() as $item_id => $item ) {
        $lms_access_mgmt_data_ids = array();
        $lms_course_data_ids = array();
        $product = $item->get_product();
        $product_id = $product->get_id();

        if ( email_exists( $user_email ) ) {
            $user = get_user_by( 'email', $user_email );
            $user_id = $user->ID;
            $log .= ', user found with user_id ' . $user_id;
            
            // get mapped AM from lms for product //
                $args = array(
                'numberposts' => -1,
                'post_type'   => array( 'lms_access_mgmt' ),
                'meta_query' => array(
                        array(
                            'key' => 'woocommerce_access_mgmt_id_product',
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
            // get mapped AM from lms for product //
            
            // unassign user from acccess management //
            if( is_array( $lms_access_mgmt_data_ids ) and count($lms_access_mgmt_data_ids) ){
                foreach( $lms_access_mgmt_data_ids as $value ){
                    unmap_user_from_am( array( 'am_id' => $value, 'user_id' => $user_id ) );
                    $log .= ', user removed from access management ' . $value;
                }
            }
            // unassign user from acccess management //
            
            // delete order log //
            lms_delete_order( array( 'user_id' => $user_id, 'payment_gateway' => 'woocommerce', 'payment_gateway_order_id' => $order_id ) );
            // delete order log //

        } else {
            $log .= ', user not found';
        }
        
        if( $enable_log ){
            $handle = fopen( $log_file, 'a' ) or die( 'Cannot open file:  ' . $log_file );
            $data = $log;
            $data .= "\n";
            fwrite( $handle, $data );
            fclose($handle);
        }
    }
}