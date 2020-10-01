<?php

if ( ! class_exists( 'WPMUDEV_Forminator_LMS_Lesson_Post_Type_Rule' ) ) {

	class WPMUDEV_Forminator_LMS_Lesson_Post_Type_Rule {
		public function __construct() {
			add_action( 'init', array( $this, 'custom_post_type_rule' ) );
		}
		public function custom_post_type_rule() {
			add_rewrite_rule( '^lektion/([^/]*)/entries/?([0-9]{1,})/?$', 'index.php?post_type=lms_lesson&name=$matches[1]&entries=$matches[2]', 'top' );
		}
	}

	new WPMUDEV_Forminator_LMS_Lesson_Post_Type_Rule();
}
