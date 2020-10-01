<?php

add_filter( 'brizy_providers', 'tg_brizy_placeholders', 10, 2 );

function tg_brizy_placeholders( $providers, $context ){
	if ( class_exists( 'tg_autoload' ) and class_exists( 'BrizyPro_Content_Providers_TG' ) and class_exists( 'BrizyPro_Content_Providers_TG_Course_Complete_Percentage' ) ) {
		$providers[] = new BrizyPro_Content_Providers_TG( $context);
		$providers[] = new BrizyPro_Content_Providers_TG_Course_Complete_Percentage( $context);
	}
	return $providers;
}


include_once( ABSPATH . 'wp-admin/includes/plugin.php' ); 
if ( is_plugin_active( 'brizy-pro/brizy-pro.php' ) and class_exists( 'Brizy_Content_Providers_AbstractProvider' ) ) {

class BrizyPro_Content_Providers_TG extends Brizy_Content_Providers_AbstractProvider {

	const PROVIDER_CONFIG_NAME = 'teachground';

	public function getGroupedPlaceholders( ) {
		$placeholders[ 'richText' ][] = call_user_func( array( $this, "get_lessons_placeholders" ) );		
		return array( self::PROVIDER_CONFIG_NAME => array_map( 'array_filter', $placeholders ) );
	}

	private function get_lessons_placeholders( $field = '' ) {
		return new BrizyPro_Content_Placeholders_SimplePostAware( 'TeachGround Lessons', "tg_lessons_sc", function ( $context ) use ( $field ) {
			return do_shortcode('[tg_lessons]');
		} );
	}
}

class BrizyPro_Content_Providers_TG_Course_Complete_Percentage extends Brizy_Content_Providers_AbstractProvider {

	const PROVIDER_CONFIG_NAME = 'tg_cc';

	public function getGroupedPlaceholders() {
		$placeholders[ 'richText' ][] = call_user_func( array( $this, "get_course_complete_percentage_placeholders" ) );		
		return array( self::PROVIDER_CONFIG_NAME => array_map( 'array_filter', $placeholders ) );
	}
	
	private function get_course_complete_percentage_placeholders( $field = '' ) {
		return new BrizyPro_Content_Placeholders_SimplePostAware( 'TeachGround Course Complete %', "tg_course_complete_percentage_sc", function ( $context ) use ( $field ) {
			return do_shortcode('[tg_course_complete_percentage]');
		} );
	}
}

}