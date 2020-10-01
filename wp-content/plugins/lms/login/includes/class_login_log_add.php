<?php

class lms_login_log_add{
	
	public function log_add( $ip = '', $msg = '', $l_added = '', $l_status = '', $user_id = 0 ){
		global $wpdb;
		if($ip == ''){
			return;
		}
		$log_data = array( 'ip' => $ip, 'user_id' => $user_id, 'msg' => $msg,  'l_added' => $l_added, 'l_status' => $l_status );
		$log_data_format = array( '%s', '%d', '%s', '%s', '%s' );
		$wpdb->insert( $wpdb->base_prefix."lms_login_log", $log_data, $log_data_format );
		return;
	}

}