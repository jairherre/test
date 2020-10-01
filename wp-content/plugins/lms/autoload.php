<?php
class lms_autoload
{
	public $load = array(
		// configs 
		'/config/config_emails.php',
		'/config/config_default_fields.php',
		'/config/config_status_images.php',
		// includes 
		'/includes/class_message.php',
		'/includes/class_settings.php',
		'/includes/class_scripts.php',
		'/includes/class_form.php',
		'/includes/class_cposts.php',
		'/includes/class_access_mgmt_data.php',
		'/includes/class_course_data.php',
		'/includes/class_lesson_data.php',
		'/includes/class_resource_data.php',
		'/includes/class_lms_functions.php',
		'/includes/class_front_form_process.php',
		'/includes/class_ccp_widget.php',
		'/includes/class_ll_widget.php',
		'/includes/class_data_import.php',
		'/includes/class_analytics.php',
		'/includes/class_login_log.php',
		'/includes/class_access_log.php',
		'/includes/class_paginate.php',
		'/elementor-ext.class.php',
		// widgets
		'/widgets/course_complete_percentage_widget.php',
		'/widgets/lessons_list_widget.php',
		// others 
		'/shortcode.php',
		'/general_functions.php',
		'/core_functions.php',
		'/template_functions.php',
		'/sidebars.php',
		'/actions.php',
		'/filters.php',
		// modules 
		'/thrivecart/thrivecart.php',
		'/woocommerce/woocommerce.php',
		'/digistore24/digistore24.php',
		'/copecart/copecart.php',
		'/brizy/brizy.php',
		'/login/login.php',
		'/forminator/rules.php'
	);

	public function __construct()
	{
		if (is_array($this->load)) {
			foreach ($this->load as $value) {
				include_once LMS_DIR_PATH . $value;
			}
		}
	}
}
