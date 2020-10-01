<?php

class tg_login_form{
	
	public function __construct() {}
	 
	public function add_remember_me(){
		include( TG_DIR_PATH . '/login/view/frontend/remember_me_input.php');
	}
	
	public function add_extra_links(){
		$tg_lost_password_page_link = apply_filters( 'tg_lost_password_page_link', get_option('tg_forgot_password_url') );
		$tg_register_page_link = apply_filters( 'tg_register_page_link', get_option('tg_register_url') );
		if( $tg_lost_password_page_link ){
			echo '<a href="' . $tg_lost_password_page_link . '">'.__('Lost Password?','teachground').'</a>';
		}
		if( $tg_register_page_link ){
			echo '<a href="' . $tg_register_page_link . '">'.__('Register','teachground').'</a>';
		}
	}
	
	public static function curPageURL() {
		$pageURL = 'http';
		if (isset($_SERVER["HTTPS"]) and $_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
		$pageURL .= "://";
		if (isset($_SERVER["SERVER_PORT"]) and $_SERVER["SERVER_PORT"] != "80") {
			$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
		} else {
			$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		}
		return $pageURL;
	}

	public function gen_redirect_url(){
		$tg_login_redirect_url = get_option( 'tg_login_redirect_url' );
		if($tg_login_redirect_url){
			return esc_url( $tg_login_redirect_url );
		}
		if(isset($_REQUEST['redirect'])){
			$redirect = sanitize_text_field($_REQUEST['redirect']);
		} else {
			$redirect = $this->curPageURL();
		}
		return esc_url( $redirect );
	}
	
	public function login_form( $wid_id = '' ){
		$this->load_script();
		if(!is_user_logged_in()){		
			include( TG_DIR_PATH . '/login/view/frontend/login.php');
		} else {
			$logout_redirect_page = $this->curPageURL();
			$current_user = wp_get_current_user();
			$link_with_username = apply_filters( 'lwws_welcome_text', __('Howdy,','teachground') ) . ' ' . $current_user->display_name;
			include( TG_DIR_PATH . '/login/view/frontend/after_login.php');
		}
	}
	
	public function error_message(){
		global $aperror;
		if ( is_wp_error( $aperror ) ) {
			$errors = $aperror->get_error_messages();
			echo '<div class="'.$errors[0].'">'.$errors[1].'</div>';
		}
	}
		
	public function load_script(){?>
		<script>
			jQuery(document).ready(function () {
				jQuery('#login').validate({ errorClass: "lw-error" });
			});
		</script>
	<?php }
}