<?php

if(!class_exists('lms_login_widget_admin_security')){
	class lms_login_widget_admin_security {
		
		public function __construct(){
			if( in_array( $GLOBALS['pagenow'], array( 'wp-login.php' ) ) ){
				add_action('wp_login', array ( $this, 'check_ap_login_success' ), 10, 2 );
				add_filter('login_errors', array( $this, 'check_ap_login_failed' ) );
			}
		}
		
		public function check_ap_login_success( $user_login, $user ){
			$llla = new lms_login_log_add;
			$llla->log_add( apply_filters( 'lms_log_ip', $_SERVER['REMOTE_ADDR'] ), __('Login successful.', 'lms'), date("Y-m-d H:i:s"), 'success', $user->ID);
		}
		
		public function check_ap_login_failed( $error ){	
			global $errors;
			$llla = new lms_login_log_add;
			
			if(is_wp_error($errors)) {
				$err_codes = $errors->get_error_codes();
			} else {
				return $error;
			}
			
			if ( in_array( 'invalid_username', $err_codes ) or in_array( 'invalid_email', $err_codes ) or in_array( 'incorrect_password', $err_codes ) ) {
				$llla->log_add( apply_filters( 'lms_log_ip', $_SERVER['REMOTE_ADDR'] ), __('Error in login.', 'lms'), date("Y-m-d H:i:s"), 'failed');
			}
			
			return $error;
		}
		
	}
}

if(!function_exists('lms_security_init')){
	function lms_security_init(){
		new lms_login_widget_admin_security;
	}
}

