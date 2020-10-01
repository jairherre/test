<?php

add_filter( 'brizy_providers', 'lms_brizy_placeholders', 10, 2 );

function lms_brizy_placeholders( $providers, $context ){
	if ( class_exists( 'lms_autoload' ) and class_exists( 'BrizyPro_Content_Providers_LMS' ) and class_exists( 'BrizyPro_Content_Providers_LMS_Course_Complete_Percentage' ) ) {
		$providers[] = new BrizyPro_Content_Providers_LMS( $context);
		$providers[] = new BrizyPro_Content_Providers_LMS_Course_Complete_Percentage( $context);
	}
	return $providers;
}


include_once( ABSPATH . 'wp-admin/includes/plugin.php' ); 
if ( is_plugin_active( 'brizy-pro/brizy-pro.php' ) and class_exists( 'Brizy_Content_Providers_AbstractProvider' ) ) {

class BrizyPro_Content_Providers_LMS extends Brizy_Content_Providers_AbstractProvider {

	const PROVIDER_CONFIG_NAME = 'lms';

	public function getGroupedPlaceholders( ) {
		$placeholders[ 'richText' ][] = call_user_func( array( $this, "get_lessons_placeholders" ) );		
		return array( self::PROVIDER_CONFIG_NAME => array_map( 'array_filter', $placeholders ) );
	}

	private function get_lessons_placeholders( $field = '' ) {
		return new BrizyPro_Content_Placeholders_SimplePostAware( 'LMS Lessons', "lms_lessons_sc", function ( $context ) use ( $field ) {
			return do_shortcode('[lms_lessons]');
		} );
	}
}

class BrizyPro_Content_Providers_LMS_Course_Complete_Percentage extends Brizy_Content_Providers_AbstractProvider {

	const PROVIDER_CONFIG_NAME = 'lms_cc';

	public function getGroupedPlaceholders() {
		$placeholders[ 'richText' ][] = call_user_func( array( $this, "get_course_complete_percentage_placeholders" ) );		
		return array( self::PROVIDER_CONFIG_NAME => array_map( 'array_filter', $placeholders ) );
	}
	
	private function get_course_complete_percentage_placeholders( $field = '' ) {
		return new BrizyPro_Content_Placeholders_SimplePostAware( 'LMS Course Complete %', "lms_course_complete_percentage_sc", function ( $context ) use ( $field ) {
			return do_shortcode('[lms_course_complete_percentage]');
		} );
	}
}

}