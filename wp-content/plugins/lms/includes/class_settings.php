<?php
class lms_settings {
	
	public $msg;
	
	public function __construct() {
		$this->load_settings();
		$this->msg = new class_lms_message;
	}
	
	public function save(){
		if( isset( $_POST['option'] ) and sanitize_text_field( $_POST['option'] ) == "lms_settings_save" ){
			global $lms_default_options_data;
			if ( ! isset( $_POST['lms_data_save_action_field'] ) || ! wp_verify_nonce( $_POST['lms_data_save_action_field'], 'lms_data_save_action' ) ) {
			   wp_die( 'Sorry, your nonce did not verify.');
			} 
			
			$lms_default_options_data = apply_filters( 'lms_default_options_data', $lms_default_options_data );
			if( is_array($lms_default_options_data) ){
				foreach( $lms_default_options_data as $key => $value ){
					if ( !empty( $_REQUEST[$key] ) ) {
						
						if( $value['sanitization'] == 'sanitize_text_field' ){
							update_option( $key, sanitize_text_field($_REQUEST[$key]) );
						} elseif( $value['sanitization'] == 'esc_html' ){
							update_option( $key, esc_html($_REQUEST[$key]) );
						} elseif( $value['sanitization'] == 'esc_textarea' ){
							update_option( $key, esc_textarea($_REQUEST[$key]) );
						} elseif( $value['sanitization'] == 'sanitize_text_field_array' ){
						 	update_option( $key, array_filter( $_REQUEST[$key], 'sanitize_text_field' ) );
						} else {
							update_option( $key, sanitize_text_field($_REQUEST[$key]) );
						}
					} else {
						delete_option( $key );
					}
				}
			}
			
			do_action('lms_settings_data_save', $this );
			
			$this->msg->add( 'Plugin data updated successfully.', 'updated' );
		}
	}
	
	public function save_ajax(){
	
		if( isset( $_REQUEST['option'] ) and $_REQUEST['option'] == 'assignRuleCourse' ){
			global $wpdb;
			
			$first_course_id = sanitize_text_field( $_REQUEST['first_course_id'] );
			$second_course_id = sanitize_text_field( $_REQUEST['second_course_id'] );
			
			if( !$first_course_id or !$second_course_id ){
				echo json_encode( array( 'status' => 'false', 'data' => __('Error!','lms') ) );
				exit;
			}
			
			if( $first_course_id == $second_course_id ){
				echo json_encode( array( 'status' => 'false', 'data' => __('Please choose different courses!','lms') ) );
				exit;
			}
			
			// we can now insert data 
			$rule_data = array( 'f_c_id' => $first_course_id, 's_c_id' => $second_course_id );
			$wpdb->insert( $wpdb->prefix.'lms_course_start_rules', $rule_data );
			echo json_encode( array( 'status' => 'true', 'data' => '<div class="rule-item"><strong>'.get_the_title($first_course_id).'</strong> '.__('must be completed before', 'lms').' <strong>'.get_the_title($second_course_id).'</strong> '.__('can be started','lms').' <a href="javascript:void(0)" onclick="removeRuleCourse(this, '.$wpdb->insert_id.')" class="lms-delete">'.LMS_DELETE_IMAGE.'</a></div>' ) );
			exit;
		}
		
		if( isset( $_REQUEST['option'] ) and $_REQUEST['option'] == 'removeRuleCourse' ){
			global $wpdb;
			$r_id = sanitize_text_field( $_REQUEST['r_id'] );
			$wpdb->delete( $wpdb->prefix.'lms_course_start_rules', array( 'r_id' => $r_id ) );
			echo 'removed';
			exit;
		}

		if( isset( $_REQUEST['option'] ) and $_REQUEST['option'] == 'sendAccountCreatedForceEmails' ){
			global $wpdb;
			$email_account_created_users = $_REQUEST['email_account_created_users'];
			if( is_array($email_account_created_users) and count($email_account_created_users)){
				foreach( $email_account_created_users as $key => $value ){
					send_user_account_created_mail( $value );
				}
				echo json_encode( array( 'status' => 'Email sent successfully.' ) );
			} else {
				echo json_encode( array( 'status' => 'Error: Users not found!' ) );
			}
			exit;
		}
		
	}
	
	public function get_courses_selected( $sel = '' ){
		global $wpdb;
		$ret = '';
		$args = array(
			'post_type' => 'lms_course',
			'posts_per_page' => -1,
		);
		$query_data = get_posts( $args );
		if ( $query_data ) {
			foreach ( $query_data as $data ) {
				if( $data->ID == $sel ){
					$ret .= '<option value="'.$data->ID.'" selected="selected">'.$data->post_title.'</option>';
				}else {
					$ret .= '<option value="'.$data->ID.'">'.$data->post_title.'</option>';
				}
			}
		}
		wp_reset_postdata();
		return $ret;
	}
	
	public function get_users_as_options(){
		$all_users = get_users();
		$opts = '';
		foreach ( $all_users as $user ) {
			$opts .= '<option value="' . $user->ID . '">' . $user->user_email . '</option>';
		}
		return $opts;
	}

	public function settings() {
		global $wpdb, $lms_default_options_data;
		if( is_array($lms_default_options_data) ){
			foreach( $lms_default_options_data as $key => $value ){
				$$key = get_option( $key );
			}
		}
		echo '<div class="wrap">';
		$this->msg->show();
		$results = $wpdb->get_results( "SELECT * FROM ".$wpdb->prefix."lms_course_start_rules", OBJECT );
		$rules = '';
		if(is_array($results)){
			foreach($results as $key => $value){
				$rules .= '<div class="rule-item"><strong>'.get_the_title($value->f_c_id).'</strong> '.__('must be completed before', 'lms').' <strong>'.get_the_title($value->s_c_id).'</strong> '.__('can be started','lms').' <a href="javascript:void(0)" onclick="removeRuleCourse(this, '.$value->r_id.')" class="lms-delete">'.LMS_DELETE_IMAGE.'</a></div>';
			}
		}
		form_class::form_open('lms_settings','lms_settings','post','','multipart/form-data');
		wp_nonce_field( 'lms_data_save_action', 'lms_data_save_action_field' );
		form_class::form_input('hidden','option','','lms_settings_save');
		include( LMS_DIR_PATH . '/view/admin/settings.php' );
		form_class::form_close();
		echo '</div>';
	}

	public function lms_analytics() {
		$lac = new lms_analytics_class;
		$lac->display_list();
	}
	
	public function menu() {
		add_menu_page( __('Courses','lms'), __('Courses','lms'), 'activate_plugins', 'edit.php?post_type=lms_course', NULL );
		add_submenu_page( 'edit.php?post_type=lms_course', __('Lessons','lms'), __('Lessons','lms'), 'activate_plugins', 'edit.php?post_type=lms_lesson', NULL );
		add_submenu_page( 'edit.php?post_type=lms_course', __('Resources','lms'), __('Resources','lms'), 'activate_plugins', 'edit.php?post_type=lms_resource', NULL );
		add_submenu_page( 'edit.php?post_type=lms_course', __('Access Management','lms'), __('Access Management','lms'), 'activate_plugins', 'edit.php?post_type=lms_access_mgmt', NULL );
		add_submenu_page( 'edit.php?post_type=lms_course', 'Analytics', 'Analytics', 'activate_plugins', 'lms_analytics', array( $this,'lms_analytics' ) );
		add_submenu_page( 'edit.php?post_type=lms_course', __('Settings','lms'), __('Settings','lms'), 'activate_plugins', 'lms_settings', array( $this,'settings' ) );
	}
	
	public function load_settings(){
		add_action( 'admin_menu' , array( $this, 'menu' ) );
		add_action( 'admin_init', array( $this, 'save' ) );
		add_action( 'admin_init', array( $this, 'save_ajax' ) );
	}	
}
