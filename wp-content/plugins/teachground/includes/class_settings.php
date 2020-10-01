<?php
class tg_settings {

	public $msg;

	public function __construct() {
		$this->register_actions();
		$this->msg = new class_tg_message;
	}

	public function save(){
		if( isset( $_POST['option'] ) and sanitize_text_field( $_POST['option'] ) == "tg_settings_save" ){
			global $tg_default_options_data;
			if ( ! isset( $_POST['tg_data_save_action_field'] ) || ! wp_verify_nonce( $_POST['tg_data_save_action_field'], 'tg_data_save_action' ) ) {
			   wp_die( 'Sorry, your nonce did not verify.');
			}

			$tg_default_options_data = apply_filters( 'tg_default_options_data', $tg_default_options_data );
			if( is_array($tg_default_options_data) ){
				foreach( $tg_default_options_data as $key => $value ){
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

			do_action('tg_settings_data_save', $this );

			$this->msg->add( 'Plugin data updated successfully.', 'updated' );
		}
	}

	public function save_ajax(){

		if( isset( $_REQUEST['option'] ) and $_REQUEST['option'] == 'assignRuleCourse' ){
			global $wpdb;

			$first_course_id = sanitize_text_field( $_REQUEST['first_course_id'] );
			$second_course_id = sanitize_text_field( $_REQUEST['second_course_id'] );

			if( !$first_course_id or !$second_course_id ){
				echo json_encode( array( 'status' => 'false', 'data' => __('Error!','teachground') ) );
				exit;
			}

			if( $first_course_id == $second_course_id ){
				echo json_encode( array( 'status' => 'false', 'data' => __('Please choose different courses!','teachground') ) );
				exit;
			}

			// we can now insert data
			$rule_data = array( 'f_c_id' => $first_course_id, 's_c_id' => $second_course_id );
			$wpdb->insert( $wpdb->prefix.'tg_course_start_rules', $rule_data );
			echo json_encode( array( 'status' => 'true', 'data' => '<div class="rule-item"><strong>'.get_the_title($first_course_id).'</strong> '.__('must be completed before', 'teachground').' <strong>'.get_the_title($second_course_id).'</strong> '.__('can be started','teachground').' <a href="javascript:void(0)" onclick="removeRuleCourse(this, '.$wpdb->insert_id.')" class="tg-delete">'.TG_DELETE_IMAGE.'</a></div>' ) );
			exit;
		}

		if( isset( $_REQUEST['option'] ) and $_REQUEST['option'] == 'removeRuleCourse' ){
			global $wpdb;
			$r_id = sanitize_text_field( $_REQUEST['r_id'] );
			$wpdb->delete( $wpdb->prefix.'tg_course_start_rules', array( 'r_id' => $r_id ) );
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
			'post_type' => 'tg_course',
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
		global $wpdb, $tg_default_options_data;
		if( is_array($tg_default_options_data) ){
			foreach( $tg_default_options_data as $key => $value ){
				$$key = get_option( $key );
			}
		}
		echo '<div class="wrap">';
		$this->msg->show();
		$results = $wpdb->get_results( "SELECT * FROM ".$wpdb->prefix."tg_course_start_rules", OBJECT );
		$rules = '';
		if(is_array($results)){
			foreach($results as $key => $value){
				$rules .= '<div class="rule-item"><strong>'.get_the_title($value->f_c_id).'</strong> '.__('must be completed before', 'teachground').' <strong>'.get_the_title($value->s_c_id).'</strong> '.__('can be started','teachground').' <a href="javascript:void(0)" onclick="removeRuleCourse(this, '.$value->r_id.')" class="tg-delete">'.TG_DELETE_IMAGE.'</a></div>';
			}
		}
		form_class::form_open('tg_settings','tg_settings','post','','multipart/form-data');
		wp_nonce_field( 'tg_data_save_action', 'tg_data_save_action_field' );
		form_class::form_input('hidden','option','','tg_settings_save');
		include( TG_DIR_PATH . '/view/admin/settings.php' );
		form_class::form_close();
		echo '</div>';
	}

	public function tg_analytics() {
		$lac = new tg_analytics_class;
		$lac->display_list();
	}

	public function add_menu_items() {
		add_menu_page(
			__( 'TeachGround Dashboard', 'teachground' ),
			__( 'TeachGround', 'teachground' ),
			'activate_plugins',
			'edit.php?post_type=tg_course',
			NULL,
			'dashicons-welcome-learn-more'
		);

		add_submenu_page(
			'edit.php?post_type=tg_course',
			__( 'TeachGround Courses', 'teachground' ),
			__( 'Courses', 'teachground' ),
			'activate_plugins',
			'edit.php?post_type=tg_course',
			NULL
		);

		add_submenu_page(
			'edit.php?post_type=tg_course',
			__( 'TeachGround Lessons', 'teachground' ),
			__( 'Lessons', 'teachground' ),
			'activate_plugins',
			'edit.php?post_type=tg_lesson',
			NULL
		);

		add_submenu_page(
			'edit.php?post_type=tg_course',
			__( 'TeachGround Resources', 'teachground' ),
			__( 'Resources', 'teachground' ),
			'activate_plugins',
			'edit.php?post_type=tg_resource',
			NULL
		);

		add_submenu_page(
			'edit.php?post_type=tg_course',
			__( 'TeachGround Access Management', 'teachground' ),
			__( 'Access', 'teachground' ),
			'activate_plugins',
			'edit.php?post_type=tg_access_mgmt',
			NULL
		);

		add_submenu_page(
			'edit.php?post_type=tg_course',
			__( 'TeachGround Analytics', 'teachground' ),
			__( 'Analytics', 'teachground' ),
			'activate_plugins',
			'tg_analytics',
			array( $this,'tg_analytics' )
		);

		add_submenu_page(
			'edit.php?post_type=tg_course',
			__( 'TeachGround Settings', 'teachground' ),
			__( 'Settings', 'teachground' ),
			'activate_plugins',
			'tg_settings',
			array( $this,'settings' )
		);
	}

	public function register_actions() {
		add_action( 'admin_menu' , array( $this, 'add_menu_items' ) );
		add_action( 'admin_init', array( $this, 'save' ) );
		add_action( 'admin_init', array( $this, 'save_ajax' ) );
	}
}
