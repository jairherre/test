<?php

if ( ! defined( 'ABSPATH' ) ) { exit; }

function digistore_signature( $sha_passphrase, $parameters, $convert_keys_to_uppercase = false, $do_html_decode=false )
{
    $algorythm           = 'sha512';
    $sort_case_sensitive = true;

    if (!$sha_passphrase)
    {
        return 'no_signature_passphrase_provided';
    }

    unset( $parameters[ 'sha_sign' ] );
    unset( $parameters[ 'SHASIGN' ] );

    if ($convert_keys_to_uppercase)
    {
        $sort_case_sensitive = false;
    }

    $keys = array_keys($parameters);
    $keys_to_sort = array();
    foreach ($keys as $key)
    {
        $keys_to_sort[] = $sort_case_sensitive
            ? $key
            : strtoupper( $key );
    }

    array_multisort( $keys_to_sort, SORT_STRING, $keys );

    $sha_string = "";
    foreach ($keys as $key)
    {
        $value = $parameters[$key];

        if ($do_html_decode) {
            $value = html_entity_decode( $value );
        }

        $is_empty = !isset($value) || $value === "" || $value === false;
        if ($is_empty)
        {
            continue;
        }

        $upperkey = $convert_keys_to_uppercase
            ? strtoupper( $key )
            : $key;

        $sha_string .= "$upperkey=$value$sha_passphrase";
	}

    $sha_sign = strtoupper( hash( $algorythm, $sha_string) );

   return $sha_sign;
}



function posted_value($varname){
    return empty($_POST[ $varname ]) ? '' : $_POST[ $varname ];
}

function digistore24_tg_post_api_process(){
	
	if( isset( $_REQUEST['ds24tgapi'] ) and $_REQUEST['ds24tgapi'] == 'true' ){
		
		$enable_log = true;
		$log_file = dirname( __FILE__ ) . '/digistore24.log';
		$log = time();

		$ipn_data = $_POST;
		//$ipn_data = json_decode('{"add_url":"https:\/\/www.digistore24.com\/order\/add\/SKMULAE2\/5JZTZEQ7","address_city":"","address_company":"","address_country":"IT","address_country_name":"Italy","address_first_name":"asdasd","address_id":"14678299","address_last_name":"fsdfsdf","address_mobile_no":"","address_phone_no":"","address_salutation":"","address_salutation_name":"","address_state":"","address_street":"","address_street2":"","address_street_name":"","address_street_number":"","address_tax_id":"","address_title":"","address_zipcode":"","affiliate_id":"","affiliate_name":"","amount":"37.00","amount_affiliate":"0.00","amount_brutto":"37.00","amount_credited":"0.00","amount_fee":"0.00","amount_netto":"30.33","amount_partner":"0.00","amount_payout":"26.41","amount_provider":"3.92","amount_vat":"6.67","amount_vendor":"26.41","api_mode":"test","billing_status":"completed","billing_type":"single_payment","buyer_address_city":"","buyer_address_company":"","buyer_address_country":"IT","buyer_address_id":"14678299","buyer_address_mobile_no":"","buyer_address_phone_no":"","buyer_address_state":"","buyer_address_street":"","buyer_address_street2":"","buyer_address_tax_id":"","buyer_address_zipcode":"","buyer_email":"mail2jul+7898@gmail.com","buyer_first_name":"asdasd","buyer_id":"12508373","buyer_language":"en","buyer_last_name":"fsdfsdf","campaignkey":"","click_id":"","country":"IT","currency":"EUR","custom":"","custom_key":"12508373-JqFFU5fnR6Gh","customer_affiliate_name":"user12508373","customer_affiliate_promo_url":"https:\/\/www.digistore24.com\/redir\/237460\/user12508373\/","email":"mail2jul+7898@gmail.com","first_amount":"37.00","first_vat_amount":"6.67","invoice_url":"https:\/\/www.digistore24.com\/invoice\/SKMULAE2\/0\/5JZTZEQ7.pdf","ipn_config_id":"125180","ipn_config_product_ids":"237460","ipn_version":"1.6","is_payment_planned":"N","item_count":"1","language":"en","license_accessdata_keys":"","merchant_id":"213199","merchant_name":"dotcom","monthly_amount":"0.00","monthly_vat_amount":"0.00","newsletter_choice":"none","newsletter_choice_msg":"Keine Angabe","number_of_installments":"0","order_date":"2020-08-28","order_date_time":"2020-08-28 09:31:24","order_details_url":"https:\/\/www.digistore24-app.com\/vendor\/reports\/transactions\/order\/SKMULAE2","order_id":"SKMULAE2","order_item_id":"21073560","order_time":"09:31:24","orderform_id":"52981","other_amounts":"0.00","other_vat_amounts":"0.00","parent_transaction_id":"","pay_method":"test","pay_sequence_no":"0","payment_id":"PAYID-10-T31967101","payplan_id":"430452","product_amount":"37","product_delivery_type":"digital","product_id":"237460","product_language":"en","product_name":"Test","product_name_intern":"Test","product_netto_amount":"30.33","product_shipping_amount":"0","product_txn_amount":"37","product_txn_netto_amount":"30.33","product_txn_shipping":"0","product_txn_vat_amount":"6.67","product_vat_amount":"6.67","purchase_key":"5JZTZEQ7","quantity":"1","rebill_stop_noted_at":"","rebilling_stop_url":"","receipt_url":"https:\/\/www.digistore24.com\/receipt\/237460\/SKMULAE2\/5JZTZEQ7","refund_days":"14","renew_url":"https:\/\/www.digistore24.com\/renew\/SKMULAE2\/5JZTZEQ7","request_refund_url":"https:\/\/www.digistore24.com\/order\/cancel\/SKMULAE2\/S3JW7E4Y","salesteam_id":"","salesteam_name":"","support_url":"https:\/\/www.digistore24.com\/support\/SKMULAE2\/5JZTZEQ7","switch_pay_interval_url":"https:\/\/www.digistore24.com\/order\/switch\/SKMULAE2\/5JZTZEQ7","tags":"","trackingkey":"","transaction_amount":"37.00","transaction_currency":"EUR","transaction_date":"2020-08-28","transaction_id":"31967101","transaction_type":"payment","transaction_vat_amount":"6.67","upgrade_key":"w77cf8abk4B8","upsell_no":"0","upsell_path":"","vat_amount":"6.67","vat_rate":"0.00","voucher_code":"","function_call":"on_payment","event":"on_payment","event_label":"Zahlung","sha_sign":"B05F56D7EF72967B5ABC7A4C24B96E2ED0B293386792923D520B6B4B85DA60E9B976123DE80EA995EB6D784106E100806F9C652FB12E6BBD95827B76BDDEEDE8"}', true);
		//$_POST = $ipn_data;

		$event    = posted_value('event');
		$api_mode = posted_value('api_mode'); // 'live' or 'test'

		if(get_option( 'tg_digistore24_api_key' )){
			$received_signature = posted_value('sha_sign');
			$expected_signature = digistore_signature( get_option( 'tg_digistore24_api_key' ), $ipn_data);

			$sha_sign_valid = $received_signature == $expected_signature;
			if (!$sha_sign_valid){
				$log .= ' ERROR: invalid sha signature';

				if( $enable_log ){
					$handle = fopen( $log_file, 'a' ) or die( 'Cannot open file:  ' . $log_file );
					$data = json_encode($ipn_data);
					$data .= $log;
					$data .= "\n";
					fwrite( $handle, $data );
					fclose($handle);
				}
				
				die('OK');
				exit;
			}
		}

		switch ($event){

			case 'on_payment':{

				$order_id = posted_value('order_id');

				// note: An order has one order_id and may consist of multiple order items.
				// For each order item, an ipn call is performed.

				$product_id   = posted_value('product_id');
				$product_name = posted_value('product_name');
				$billing_type = posted_value( 'billing_type' );

				switch ($billing_type){
					case 'single_payment':
						$number_payments = 0;
						$pay_sequence_no = 0;
						break;

					case 'installment':
						$number_payments = posted_value( 'order_item_number_of_installments' );
						$pay_sequence_no = posted_value( 'pay_sequence_no' );
						break;

					case 'subscription':
						$number_payments = 0;
						$pay_sequence_no = posted_value( 'pay_sequence_no' );
						break;
				}

				$tg_access_mgmt_data_ids 	= array();
				$tg_course_data_ids 		= array();
				$user_email             	= posted_value('email');
				$first_name             	= posted_value('address_first_name');
				$last_name              	= posted_value('address_last_name');
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
                                  'key' => 'digistore24_access_mgmt_id_product',
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
				tg_add_order( array( 'user_id' => $user_id, 'payment_gateway' => 'digistore24', 'payment_gateway_order_id' => $order_id ) );
				// add order log //

				break;
			}
			case 'on_payment_missed':{	
				$log .= 'Error: payment missed';
				break;
			}
			case 'on_refund':{
				$order_id = posted_value('order_id');

				// note: An order has one order_id and may consist of multiple order items.
				// For each order item, an ipn call is performed.

				$product_id   = posted_value('product_id');
				$product_name = posted_value('product_name');
				$billing_type = posted_value( 'billing_type' );

				$tg_access_mgmt_data_ids 	= array();
				$tg_course_data_ids 		= array();
				$user_email             	= posted_value('email');
				
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
									'key' => 'digistore24_access_mgmt_id_product',
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
					tg_delete_order( array( 'user_id' => $user_id, 'payment_gateway' => 'digistore24', 'payment_gateway_order_id' => $order_id ) );
					// delete order log //

				} else {
					$log .= ', user not found';
				}

				break;
			}
			case 'on_chargeback':{
				$order_id = posted_value('order_id');
				break;
			}
			case 'on_rebill_resumed':{
				$order_id = posted_value('order_id');
				break;
			}
			case 'on_rebill_cancelled':{
				$order_id = posted_value('order_id');
				break;
			}

			case 'on_affiliation':{
				$email             = posted_value('email');
				$digistore_id      = posted_value('affiliate_name');
				$promolink         = posted_value('affiliate_link');
				$language          = posted_value('language');

				$first_name        = posted_value('address_first_name');
				$last_name         = posted_value('address_last_name');

				$address_street    = posted_value('address_street_name');
				$address_street_no = posted_value('address_street_number');
				$address_city      = posted_value('address_city');
				$address_state     = posted_value('address_state');
				$address_zipcode   = posted_value('address_zipcode');
				$address_phone_no  = posted_value('address_phone_no');

				$product_id        = posted_value('product_id');
				$product_name      = posted_value('product_name');
				$merchant_id       = posted_value('merchant_id');

				break;
			}
		}

		if( $enable_log ){
			$handle = fopen( $log_file, 'a' ) or die( 'Cannot open file:  ' . $log_file );
			$data = json_encode($ipn_data);
			$data .= $log;
			$data .= "\n";
			fwrite( $handle, $data );
			fclose($handle);
		}
		
		die('OK');
		exit;
	}
	
}
