<?php

/**
 * Plugin Name: Forminator - Custom post type Rule
 * Plugin URI: https://premium.wpmudev.org/
 * Description: mu-plugin for rewrite rule for custom post type.
 * Version: 1.0.0
 * Author: @WPMUDEV
 * Author URI: https://premium.wpmudev.org/
 * License: GPLv2 or later
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WPMUDEV_Forminator_Custom_Post_Type_Rule' ) ) {

	/**
	 * WPMUDEV_Forminator_Custom_Post_Type_Rule Class
	 */
	class WPMUDEV_Forminator_Custom_Post_Type_Rule {
		/**
		* Constructor.
		*/
		public function __construct() {

			add_action( 'init', array( $this, 'custom_post_type_rule' ) );
		}

		/**
		* Change the custom post rule
		*
		*/
		public function custom_post_type_rule() {

			add_rewrite_rule( '^lektion/([^/]*)/entries/?([0-9]{1,})/?$', 'index.php?post_type=lms_lesson&name=$matches[1]&entries=$matches[2]', 'top' );
		}
	}

	new WPMUDEV_Forminator_Custom_Post_Type_Rule();
}
