<?php
function tg_login_widget_shortcode( $atts ) {
     global $post;
	 extract( shortcode_atts( array(
	      'title' => '',
     ), $atts ) );
     
	ob_start();
	$tglf = new tg_login_form;
	if($title){
		echo '<h2>'. esc_html( $title ) .'</h2>';
	}
	$tglf->login_form();
	$ret = ob_get_contents();	
	ob_end_clean();
	return $ret;
}

function tg_forgot_password_shortcode( $atts ) {
     global $post;
	 extract( shortcode_atts( array(
	      'title' => '',
     ), $atts ) );
     
	ob_start();
	$tgfpc = new tg_forgot_pass_class;
	if($title){
		echo '<h2>'. esc_html( $title ) .'</h2>';
	}
	$tgfpc->forgot_pass_form();
	$ret = ob_get_contents();	
	ob_end_clean();
	return $ret;
}
