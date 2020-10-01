<?php

function tg_login_validate(){
	if( isset($_POST['option']) and $_POST['option'] == "tg_user_login"){
		
		if ( ! isset( $_POST['tg_form_field'] )  || ! wp_verify_nonce( $_POST['tg_form_field'], 'tg_form_action' ) ) {
		   wp_die( 'Sorry, your nonce did not verify.' );
		   exit;
		} 
			
		global $aperror;
		$aperror = new WP_Error;
		$llla = new tg_login_log_add;
		
		if($_POST['userusername'] != "" and $_POST['userpassword'] != ""){
			$creds = array();
			$creds['user_login'] = sanitize_text_field($_POST['userusername']);
			$creds['user_password'] = $_POST['userpassword'];
			
			if(isset($_POST['remember']) and $_POST['remember'] == "Yes"){
				$remember = true;
			} else {
				$remember = false;
			}
			$creds['remember'] = $remember;
			$user = wp_signon( $creds, true );
			if(isset($user->ID) and $user->ID != ''){
				wp_set_auth_cookie($user->ID, $remember);
				$llla->log_add( apply_filters( 'tg_log_ip', $_SERVER['REMOTE_ADDR'] ), __('Login successful.', 'teachground'), date("Y-m-d H:i:s"), 'success', $user->ID);
				wp_redirect( apply_filters( 'tg_login_redirect', sanitize_text_field($_POST['redirect']), $user->ID ) );
				exit;
			} else{
				$llla->log_add( apply_filters( 'tg_log_ip', $_SERVER['REMOTE_ADDR'] ), __('User not found.', 'teachground'), date("Y-m-d H:i:s"), 'failed');
				$aperror->add( "msg_class", "tg-error" );
				$aperror->add( "msg", __(get_login_error_message_text($user),'teachground') );								
			}
		} else {
			$llla->log_add( apply_filters( 'tg_log_ip', $_SERVER['REMOTE_ADDR'] ), __('Username or password is empty!', 'teachground'), date("Y-m-d H:i:s"), 'failed');
			$aperror->add( "msg_class", "tg-error" );
			$aperror->add( "msg", __('Username or password is empty!','teachground') );
		}
	}
}

function tg_forgot_pass_validate(){
	
	// step 1
	if(isset($_POST['option']) and sanitize_text_field($_POST['option']) == "tg_forgot_pass"){
		
		if ( ! isset( $_POST['tg_form_field'] )  || ! wp_verify_nonce( $_POST['tg_form_field'], 'tg_form_action' ) ) {
		   wp_die( 'Sorry, your nonce did not verify.' );
		   exit;
		} 
		
		global $aperror,$wpdb;

		$aperror = new WP_Error;
		
		$user_login = '';
		$user_email = '';
		$msg = '';
		
		if(empty($_POST['userusername'])) {
			$msg .= __('Email is empty!','teachground');
		}
		
		$user_username = esc_sql(trim(sanitize_text_field($_POST['userusername'])));
		
		$user_data = get_user_by('email', $user_username);
		if(empty($user_data)) { 
			$msg .= __('Invalid E-mail address!','teachground');
		}
		
		if( isset($user_data->data->user_login) and isset($user_data->data->user_email) ){
			$user_login = $user_data->data->user_login;
			$user_email = $user_data->data->user_email;
		}
		
		if($user_email){
			$key = $wpdb->get_var($wpdb->prepare("SELECT user_activation_key FROM $wpdb->users WHERE user_login = %s", $user_login));
			if(empty($key)) {
				$key = wp_generate_password(10, false);
				$wpdb->update($wpdb->users, array('user_activation_key' => $key), array('user_login' => $user_login));	
			}
			
			$tg_from_email = get_option( 'tg_from_email' );
			$tg_from_name 	= get_option( 'tg_from_name' );
			$subject 		= get_option( 'tg_reset_password_subject' );
			$body 			= get_option( 'tg_reset_password_body' );
			
			$body = stripslashes($body);
			$body = html_entity_decode($body);
			$body = nl2br($body);
			
			$resetlink = site_url() . "?action=tg_reset_pass&key=$key&login=" . rawurlencode($user_login);
			
			$body = str_replace( array( '#site_url#', '#user_name#', '#display_name#', '#first_name#', '#last_name#', '#resetlink#' ), array( site_url(), $user_login, $user_data->data->display_name, $user_data->data->first_name, $user_data->data->last_name, $resetlink ), $body );
	
			$body = tg_get_email_body( 'user_reset_password.php', array( 'body' => $body ) );
	
			if( empty($tg_from_email) ){
				$tg_from_email = 'no-reply@wordpress.com';
			}
			if( empty($tg_from_name) ){
				$tg_from_name = 'TeachGround';
			}
			if( empty($subject) ){
				$subject = __( 'Reset Password Link', 'teachground' );
			}
			
			$headers[] = "From: {$tg_from_name} <{$tg_from_email}>";
			$to = $user_email;
			
			add_filter( 'wp_mail_content_type', 'tg_set_html_content_type' );
			
			if ( !wp_mail( $to, $subject, $body, $headers ) ) {
				$aperror->add( "reg_msg_class", "tg-error" );
				$aperror->add( "reg_error_msg", __('Email failed to send for some unknown reason.','teachground') );	
			}
			else {
				$aperror->add( "reg_msg_class", "tg-success" );
				$aperror->add( "reg_error_msg", __('We have just sent you an email with Password reset instructions.','teachground') );	
			}
			remove_filter( 'wp_mail_content_type', 'tg_set_html_content_type' );
		} else {
			$aperror->add( "reg_msg_class", "tg-error" );
			$aperror->add( "reg_error_msg", $msg );	
		}
	}
	
	// step 2
	if(isset($_GET['key']) && isset($_GET['action']) && sanitize_text_field($_GET['action']) == "tg_reset_pass") {
		global $wpdb;
		$reset_key = sanitize_text_field($_GET['key']);
		$user_login = sanitize_text_field($_GET['login']);
		$user_data = $wpdb->get_row($wpdb->prepare("SELECT ID, user_login, user_email FROM $wpdb->users WHERE user_activation_key = %s AND user_login = %s", $reset_key, $user_login));
				
		$tg_from_email = get_option( 'tg_from_email' );
		$tg_from_name 	= get_option( 'tg_from_name' );
		$subject 		= get_option( 'tg_new_password_subject' );
		$body 			= get_option( 'tg_new_password_body' );
		
		if( empty($tg_from_email) ){
			$tg_from_email = 'no-reply@wordpress.com';
		}
		if( empty($tg_from_name) ){
			$tg_from_name = 'TeachGround';
		}
		if( empty($subject) ){
			$subject = __( 'New Password', 'teachground' );
		}
			
		if(!empty($reset_key) && !empty($user_data)) {
			$user_login = $user_data->user_login;
			$user_email = $user_data->user_email;

			$new_password = wp_generate_password(7, false);
			wp_set_password( $new_password, $user_data->ID );
			
			$body = stripslashes($body);
			$body = html_entity_decode($body);
			$body = nl2br($body);
			
			$body = str_replace( array( '#site_url#', '#user_name#', '#display_name#', '#first_name#', '#last_name#', '#user_password#' ), array( site_url(), $user_login, $user_data->display_name, $user_data->first_name, $user_data->last_name, $new_password ), $body );
			$body = tg_get_email_body( 'user_new_password.php', array( 'body' => $body ) );
			
			add_filter( 'wp_mail_content_type', 'tg_set_html_content_type' );
			
			if ( !wp_mail( $user_email, $subject, $body, $headers ) ) {
				wp_die(__('Email failed to send for some unknown reason.','teachground'));
				exit;
			}
			else {
				wp_die(__('New Password successfully sent to your mail address.','teachground'));
				exit;
			}
			remove_filter( 'wp_mail_content_type', 'tg_set_html_content_type' );
		} 
		else {
			wp_die(__('Not a Valid Key.','teachground'));
			exit;
		}
	}
}