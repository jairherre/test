<?php
function lms_login_widget_shortcode( $atts ) {
     global $post;
	 extract( shortcode_atts( array(
	      'title' => '',
     ), $atts ) );
     
	ob_start();
	$lmslf = new lms_login_form;
	if($title){
		echo '<h2>'. esc_html( $title ) .'</h2>';
	}
	$lmslf->login_form();
	$ret = ob_get_contents();	
	ob_end_clean();
	return $ret;
}

function lms_forgot_password_shortcode( $atts ) {
     global $post;
	 extract( shortcode_atts( array(
	      'title' => '',
     ), $atts ) );
     
	ob_start();
	$lmsfpc = new lms_forgot_pass_class;
	if($title){
		echo '<h2>'. esc_html( $title ) .'</h2>';
	}
	$lmsfpc->forgot_pass_form();
	$ret = ob_get_contents();	
	ob_end_clean();
	return $ret;
}
