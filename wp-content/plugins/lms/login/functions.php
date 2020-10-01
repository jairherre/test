<?php

if(!function_exists('get_login_error_message_text')){
	function get_login_error_message_text( $user ){	
		$code = $user->get_error_code();
		$lafo_invalid_username = get_option('lafo_invalid_username');
		$lafo_invalid_email = get_option('lafo_invalid_email');
		$lafo_invalid_password = get_option('lafo_invalid_password');
		
		if($code == 'invalid_username'){
			if($lafo_invalid_username){
				$error = $lafo_invalid_username;
			} else {
				$error = $user->get_error_message();
			}
		} else if($code == 'invalid_email'){
			if($lafo_invalid_email){
				$error = $lafo_invalid_email;
			} else {
				$error = $user->get_error_message();
			}
		} else if($code == 'incorrect_password'){
			if($lafo_invalid_password){
				$error = $lafo_invalid_password;
			} else {
				$error = $user->get_error_message();
			}
		} else {
			$error = $user->get_error_message();
		}
		
		return $error;
	}
}

