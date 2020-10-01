<?php

class class_lms_functions extends class_resource_data{
	
	public function __construct(){
		parent::__construct();
		add_action( 'save_post', array( $this, 'save_post_data' ) );
		add_action( 'admin_init', array( $this, 'save_post_data_ajax' ) );
	}
	
	public function is_user_assigned_to_am( $user_id = '', $am_id = '' ){
		global $wpdb;
		if( empty( $user_id ) ){
			return array( 'status' => false, 'msg' => __( 'User ID is empty!', 'lms' ) );
		}
		if( empty( $am_id ) ){
			return array( 'status' => false, 'msg' => __( 'Access Management ID is empty!', 'lms' ) );
		}
		$status = $wpdb->get_var( $wpdb->prepare( "SELECT count(*) FROM ".$wpdb->prefix."lms_am_user_mapping WHERE am_id = %d AND user_id = %d", $am_id, $user_id ) );
		if( $status != 1 ){
			return array( 'status' => 0, 'msg' => __( 'Access Management not assigned to user!', 'lms' ) );
		}
		// if here then user is assigned to the am
		return array( 'status' => true );
	}
	
	public function map_user_to_am( $data = array() ){
		global $wpdb;
		if(!is_array($data) and empty($data)){
			return array( 'status' => 'error', 'msg' => __('Empty data','lms') );
		}
		if(!count($data)){
			return array( 'status' => 'error', 'msg' => __('Empty data','lms') );
		}
		if( empty($data['user_id']) ){
			return array( 'status' => 'error', 'msg' => __('User ID not specified','lms') );
		}
		if( empty($data['am_id']) ){
			return array( 'status' => 'error', 'msg' => __('Access Management ID not specified','lms') );
		}
		if( !empty($data['status']) && $data['status'] == 'Active' ){
			$status = 'Active';
		} else {
			$status = 'Inactive';
		}
		if( empty($data['added_on']) ){
			$added_on = date('Y-m-d H:i:s');
		} else{
			$added_on = $data['added_on'];
		}
		$user_id = $data['user_id'];
		$am_id = $data['am_id'];
		
		// check if user exists
		$is_user_exists = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM {$wpdb->users} WHERE ID = %d", $user_id));
		if($is_user_exists == 0){ 
			return array( 'status' => 'error', 'msg' => __('User not found','lms') );
		}
		// check if access management exists
		$is_am_exists = lms_is_am_exists( $am_id );
		if($is_am_exists === false){ 
			return array( 'status' => 'error', 'msg' => __('Access Management not found','lms') );
		}
		// check if user is already assigned to am
		$user_assign_status = $this->is_user_assigned_to_am( $user_id, $am_id );
		if($user_assign_status['status'] === true){ 
			return array( 'status' => 'error', 'msg' => __('Access Management already assigned to user.','lms') );
		}
		// if here then we can assign access management to user 
		$map_data = array( 'am_id' => $am_id, 'user_id' => $user_id, 'added_on' => $added_on, 'm_status' => $status );
		$action_data = array( 'am_id' => $am_id, 'user_id' => $user_id, 'added_on' => $added_on, 'status' => $status );
		$wpdb->insert( $wpdb->prefix.'lms_am_user_mapping', $map_data );
		if($status == 'Active'){
			do_action( 'lms_am_user_assigned', $action_data );
			return array( 'status' => 'success', 'msg' => __('User assigned successfully','lms'), 'insert_id' => $wpdb->insert_id );
		} else {
			do_action( 'lms_am_user_unassigned', $action_data );
			return array( 'status' => 'success', 'msg' => __('User unassigned successfully','lms'), 'insert_id' => $wpdb->insert_id );
		}
	}

	public function unmap_user_from_am( $data = array() ){
		global $wpdb;
		if(!is_array($data) and empty($data)){
			return array( 'status' => 'error', 'msg' => __('Empty data','lms') );
		}
		if(!count($data)){
			return array( 'status' => 'error', 'msg' => __('Empty data','lms') );
		}
		if( empty($data['user_id']) ){
			return array( 'status' => 'error', 'msg' => __('User ID not specified','lms') );
		}
		if( empty($data['am_id']) ){
			return array( 'status' => 'error', 'msg' => __('Access Management ID not specified','lms') );
		}
		
		$am_id 		= (int)$data['am_id'];
		$user_id 	= (int)$data['user_id'];
		
		$del = $wpdb->delete( $wpdb->prefix.'lms_am_user_mapping', array( 'am_id' => $am_id, 'user_id' => $user_id ) );
		if( $del == false ){
			return array( 'status' => 'error', 'msg' => __('Error in delete','lms') );
		} else {
			$action_data = array( 'am_id' => $am_id, 'user_id' => $user_id );
			do_action( 'lms_am_user_unassigned', $action_data );
			return array( 'status' => 'success', 'msg' => __('User unassigned successfully','lms') );
		}
	}
	
	public function is_user_assigned_to_course( $user_id = '', $course_id = '' ){
		global $wpdb;
		if( empty( $user_id ) ){
			return array( 'status' => false, 'msg' => __( 'User ID is empty!', 'lms' ) );
		}
		if( empty( $course_id ) ){
			return array( 'status' => false, 'msg' => __( 'Course ID is empty!', 'lms' ) );
		}
		$status = $wpdb->get_var( $wpdb->prepare( "SELECT count(*) FROM ".$wpdb->prefix."lms_user_mapping WHERE c_id = %d AND user_id = %d", $course_id, $user_id ) );
		if( $status != 1 ){
			return array( 'status' => 0, 'msg' => __( 'Course not assigned to user!', 'lms' ) );
		}
		// if here then user is assigned to the course
		return array( 'status' => true );
	}
	
	public function map_user_to_course( $data = array() ){
		global $wpdb;
		if(!is_array($data) and empty($data)){
			return array( 'status' => 'error', 'msg' => __('Empty data','lms') );
		}
		if(!count($data)){
			return array( 'status' => 'error', 'msg' => __('Empty data','lms') );
		}
		if( empty($data['user_id']) ){
			return array( 'status' => 'error', 'msg' => __('User ID not specified','lms') );
		}
		if( empty($data['course_id']) ){
			return array( 'status' => 'error', 'msg' => __('Course ID not specified','lms') );
		}
		if( !empty($data['status']) && $data['status'] == 'Active' ){
			$status = 'Active';
		} else {
			$status = 'Inactive';
		}
		if( empty($data['added_on']) ){
			$added_on = date('Y-m-d H:i:s');
		} else{
			$added_on = $data['added_on'];
		}
		$user_id = $data['user_id'];
		$course_id = $data['course_id'];
		
		// check if user exists
		$is_user_exists = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM {$wpdb->users} WHERE ID = %d", $user_id));
		if($is_user_exists == 0){ 
			return array( 'status' => 'error', 'msg' => __('User not found','lms') );
		}
		// check if course exists
		$is_course_exists = lms_is_course_exists( $course_id );
		if($is_course_exists === false){ 
			return array( 'status' => 'error', 'msg' => __('Course not found','lms') );
		}
		// check if user is already assigned to course
		$user_assign_status = $this->is_user_assigned_to_course( $user_id, $course_id );
		if($user_assign_status['status'] === true){ 
			return array( 'status' => 'error', 'msg' => __('Course already assigned to user.','lms') );
		}
		// if here then we can assign course to user 
		$map_data = array( 'c_id' => $course_id, 'user_id' => $user_id, 'added_on' => $added_on, 'm_status' => $status );
		$action_data = array( 'course_id' => $course_id, 'user_id' => $user_id, 'added_on' => $added_on, 'status' => $status );
		$wpdb->insert( $wpdb->prefix.'lms_user_mapping', $map_data );
		if($status == 'Active'){
			do_action( 'lms_user_assigned', $action_data );
			return array( 'status' => 'success', 'msg' => __('User assigned successfully','lms'), 'insert_id' => $wpdb->insert_id );
		} else {
			do_action( 'lms_user_unassigned', $action_data );
			return array( 'status' => 'success', 'msg' => __('User unassigned successfully','lms'), 'insert_id' => $wpdb->insert_id );
		}
	}
	
	public function unmap_user_from_course( $data = array() ){
		global $wpdb;
		if(!is_array($data) and empty($data)){
			return array( 'status' => 'error', 'msg' => __('Empty data','lms') );
		}
		if(!count($data)){
			return array( 'status' => 'error', 'msg' => __('Empty data','lms') );
		}
		if( empty($data['user_id']) ){
			return array( 'status' => 'error', 'msg' => __('User ID not specified','lms') );
		}
		if( empty($data['course_id']) ){
			return array( 'status' => 'error', 'msg' => __('Course ID not specified','lms') );
		}
		
		$course_id 		= (int)$data['course_id'];
		$user_id 	= (int)$data['user_id'];
		$del = $wpdb->delete( $wpdb->prefix.'lms_user_mapping', array( 'c_id' => $course_id, 'user_id' => $user_id ) );
		if( $del == false ){
			return array( 'status' => 'error', 'msg' => __('Error in delete','lms') );
		} else {
			$action_data = array( 'course_id' => $course_id, 'user_id' => $user_id );
			do_action( 'lms_user_unassigned', $action_data );
			return array( 'status' => 'success', 'msg' => __('User unassigned successfully','lms') );
		}
	}
	
	public function save_post_data_ajax(){
		
		if( isset( $_REQUEST['option'] ) and $_REQUEST['option'] == 'assignCourse' ){
			global $wpdb;
			$am_id = sanitize_text_field( $_REQUEST['am_id'] );
			$course_id = sanitize_text_field( $_REQUEST['course_id'] );
			
			if( !$course_id ){
				echo json_encode( array( 'status' => 'false', 'data' => __('Please select course!','lms') ) );
				exit;
			}
			
			if( $course_id and $am_id ){				
				echo json_encode( array( 'status' => 'true', 'data' => '<div class="course-item" data-id="'.$course_id.'"><strong>'.__('Course','lms').'</strong> <input type="hidden" name="course_ids[]" id="course_ids" value="'.$course_id.'"> '.get_the_title($course_id).' <label><input type="checkbox" name="disable_lesson_rules[]" value="'.$course_id.'">'.__('Disable all lesson start rules','lms').'</label> <a href="post.php?post='.$course_id.'&action=edit" target="_blank" class="lms-edit">'.LMS_EDIT_IMAGE.'</a> <a href="javascript:void(0)" onclick="removeCourse(this)" class="lms-delete">'.LMS_DELETE_IMAGE.'</a></div>' ) );
				
			} else {
				echo json_encode( array( 'status' => 'false', 'data' => __('Error!','lms') ) );
			}
			exit;
		}
		
		if( isset( $_REQUEST['option'] ) and $_REQUEST['option'] == 'CourseSearch' ){
			global $wpdb;
			$ret = '';
			$course_search = sanitize_text_field( $_REQUEST['course_search'] );
			
			if( empty( $course_search ) ){
				$ret = '';
			} else {
				$args = array(
					'post_type' => 'lms_course',
					'posts_per_page' => -1,
					's' => $course_search,
				);
				$query_data = get_posts( $args );
				if ( $query_data ) {
					$ret .= '<ul>';
					foreach ( $query_data as $data ) {
						$ret .= '<li><a class="button" href="javascript:void(0)" onclick="courseSelectionFromSearch('.$data->ID.', \''.$data->post_title.'\');">'.$data->post_title.'</a></li>';
					}
					$ret .= '</ul>';
				}
				wp_reset_postdata();
			}
			
			echo $ret;
			exit;
		}

		if( isset( $_REQUEST['option'] ) and $_REQUEST['option'] == 'assignPost' ){
			global $wpdb;
			$am_id = sanitize_text_field( $_REQUEST['am_id'] );
			$post_id = sanitize_text_field( $_REQUEST['post_id'] );
			
			if( !$post_id ){
				echo json_encode( array( 'status' => 'false', 'data' => __('Please select post!','lms') ) );
				exit;
			}
			
			if( $post_id and $am_id ){				
				echo json_encode( array( 'status' => 'true', 'data' => '<div class="post-item" data-id="'.$post_id.'"><strong>'.__('Post','lms').'</strong> <input type="hidden" name="post_ids[]" id="post_ids" value="'.$post_id.'"> '.get_the_title($post_id).' <a href="post.php?post='.$post_id.'&action=edit" target="_blank" class="lms-edit">'.LMS_EDIT_IMAGE.'</a> <a href="javascript:void(0)" onclick="removePost(this)" class="lms-delete">'.LMS_DELETE_IMAGE.'</a></div>' ) );
				
			} else {
				echo json_encode( array( 'status' => 'false', 'data' => __('Error!','lms') ) );
			}
			exit;
		}
		
		if( isset( $_REQUEST['option'] ) and $_REQUEST['option'] == 'PostSearch' ){
			global $wpdb;
			$ret = '';
			$post_search = sanitize_text_field( $_REQUEST['post_search'] );
			
			if( empty( $post_search ) ){
				$ret = '';
			} else {
				$args = array(
					'post_type' => array( 'post', 'page' ),
					'posts_per_page' => -1,
					's' => $post_search,
				);
				$query_data = get_posts( $args );
				if ( $query_data ) {
					$ret .= '<ul>';
					foreach ( $query_data as $data ) {
						$ret .= '<li><a class="button" href="javascript:void(0)" onclick="postSelectionFromSearch('.$data->ID.', \''.$data->post_title.'\');">'.$data->post_title.'</a></li>';
					}
					$ret .= '</ul>';
				}
				wp_reset_postdata();
			}
			
			echo $ret;
			exit;
		}
		
		if( isset( $_REQUEST['option'] ) and $_REQUEST['option'] == 'AssignUser' ){
			global $wpdb;
			
			$c_id = sanitize_text_field( $_REQUEST['c_id'] );
			$user_id = sanitize_text_field( $_REQUEST['user_id'] );
			$status = sanitize_text_field( $_REQUEST['status'] );
			
			if( !$user_id ){
				echo json_encode( array( 'status' => 'false', 'data' => __('Please select user!','lms') ) );
				exit;
			}
			$is_exists = $this->is_user_assigned_to_course( $user_id, $c_id );
			if( $is_exists['status'] === 0 ){
				$ins_status = $this->map_user_to_course( array( 'course_id' => $c_id, 'user_id' => $user_id, 'added_on' => date( "Y-m-d H:i:s" ), 'status' => $status ) );
				if( $ins_status['status'] == 'success' ){
					$user_info = get_userdata( $user_id );
					echo json_encode( array( 'status' => 'true', 'data' => '<div class="user-item" id="ua-'.$ins_status['insert_id'].'"><strong>'.__('User','lms').'</strong> '.$user_info->user_email.' <input type="hidden" name="user_ids[]" value="'.$user_id.'"> <strong>'.__('Status','lms').'</strong> <select name="user_statuses[]">'.$this->get_user_status_selected( $status ).'</select><input type="hidden" name="m_ids[]" value="'.$ins_status['insert_id'].'"> <strong>'.__('Added On','lms').'</strong> '. lms_date_format( date( "Y-m-d H:i:s" ), 'jS M, Y \a\t g:i a' ).' <a href="javascript:removeAssignedUser('.$ins_status['insert_id'].')" class="lms-delete">'.LMS_DELETE_IMAGE.'</a></div>' ) );
				} else {
					echo json_encode( array( 'status' => 'false', 'data' => $ins_status['msg'] ) );
				}
			} else {
				echo json_encode( array( 'status' => 'false', 'data' => __('This user already exists!','lms') ) );
			}
			exit;
		}
		
		if( isset( $_REQUEST['option'] ) and $_REQUEST['option'] == 'assignAmUser' ){
			global $wpdb;
			
			$am_id = sanitize_text_field( $_REQUEST['am_id'] );
			$user_id = sanitize_text_field( $_REQUEST['user_id'] );
			$status = sanitize_text_field( $_REQUEST['status'] );
			
			if( !$user_id ){
				echo json_encode( array( 'status' => 'false', 'data' => __('Please select user!','lms') ) );
				exit;
			}
			$is_exists = $this->is_user_assigned_to_am( $user_id, $am_id );
			if( $is_exists['status'] === 0 ){
				$ins_status = $this->map_user_to_am( array( 'am_id' => $am_id, 'user_id' => $user_id, 'added_on' => date( "Y-m-d H:i:s" ), 'status' => $status ) );
				if( $ins_status['status'] == 'success' ){
					$user_info = get_userdata( $user_id );
					
					$action_data = array( 'user_id' => $user_id, 'am_id' => $am_id, 'status' => $status );
					if($status == 'Active'){

						// add order log //
						lms_add_order( array( 'user_id' => $user_id, 'payment_gateway' => 'manual', 'payment_gateway_order_id' => $am_id ) );
						// add order log //

						do_action( 'lms_am_user_assigned', $action_data );
					} else {

						// delete order log //
						lms_delete_order( array( 'user_id' => $user_id, 'payment_gateway' => 'manual', 'payment_gateway_order_id' => $am_id ) );
						// delete order log //

						do_action( 'lms_am_user_unassigned', $action_data );
					}

					echo json_encode( array( 'status' => 'true', 'data' => '<div class="user-item" id="ua-'.$ins_status['insert_id'].'"><strong>'.__('User','lms').'</strong> '.$user_info->user_email.' <input type="hidden" name="user_ids[]" value="'.$user_id.'"> <strong>'.__('Status','lms').'</strong> <select name="user_statuses[]">'.$this->get_user_status_selected( $status ).'</select><input type="hidden" name="m_ids[]" value="'.$ins_status['insert_id'].'"> <strong>'.__('Added On','lms').'</strong> '. lms_date_format( date( "Y-m-d H:i:s" ), 'jS M, Y \a\t g:i a' ).' <a href="javascript:void(0)" onclick="removeAssignedAmUser(this,'.$ins_status['insert_id'].')" data-manual="'.(is_user_assigned_manually($user_id,$am_id)==true?1:0).'" class="lms-delete">'.LMS_DELETE_IMAGE.'</a></div>' ) );

				} else {
					echo json_encode( array( 'status' => 'false', 'data' => $ins_status['msg'] ) );
				}
			} else {
				echo json_encode( array( 'status' => 'false', 'data' => __('This user already exists!','lms') ) );
			}
			exit;
		}
		
		if( isset( $_REQUEST['option'] ) and $_REQUEST['option'] == 'assignSection' ){
			global $wpdb;
			$c_id = sanitize_text_field( $_REQUEST['c_id'] );
			$section_name = sanitize_text_field( $_REQUEST['section_name'] );
			$old_section_id = sanitize_text_field( $_REQUEST['old_section_id'] );
			if( empty($section_name) and empty($old_section_id) ){
				echo json_encode( array( 'status' => 'false', 'data' => __('Please enter section name or choose one.','lms') ) );
				exit;
			}
			if($old_section_id){
				echo json_encode( array( 'status' => 'true', 'data' => '<div class="section-item"><strong>#'.$old_section_id.' '.__('Section Name','lms').'</strong> <input type="text" name="section_name_'.$old_section_id.'" value="'.lms_get_section_name($old_section_id).'"> <input type="hidden" name="section_ids[]" value="'.$old_section_id.'"><div id="sec-'.$old_section_id.'" class="sec" data-id="'.$old_section_id.'"></div></div>', 'form_update' => '<div class="lms-popup-form-inner"><input type="hidden" name="lesson_id" id="lesson_id"><p>'.__('Section','lms').' <select name="section_id" id="section_id" required class="widefat">'.class_course_data::get_section_selected('',$c_id).'</select></p><p>'.__('Add New Lesson','lms').' <input type="text" name="lesson_title" id="lesson_title" class="widefat" value="" placeholder="'.__('Enter lesson title','lms').'"></p><p>'.__('Search Lesson','lms').' <input type="text" name="lesson_search" id="lesson_search" value="" class="widefat" placeholder="'.__('Search by lesson title','lms').'"></p><div id="lesson_search_result"></div><div id="lesson_selected"></div><div class="lms-loader" id="lesson-assign-form-loader"></div></div>' ) );
			} else {
				if($section_name){
					$ins_data = array( 'c_id' => $c_id, 's_name' => $section_name );
					$wpdb->insert( $wpdb->prefix.'lms_section', $ins_data );
					echo json_encode( array( 'status' => 'true', 'data' => '<div class="section-item"><strong>#'.$wpdb->insert_id.' '.__('Section Name','lms').'</strong> <input type="text" name="section_name_'.$wpdb->insert_id.'" value="'.lms_removeslashes($section_name).'"> <input type="hidden" name="section_ids[]" value="'.$wpdb->insert_id.'"><div id="sec-'.$wpdb->insert_id.'" class="sec" data-id="'.$wpdb->insert_id.'"></div></div>', 'form_update' => '<div class="lms-popup-form-inner"><input type="hidden" name="lesson_id" id="lesson_id"><p>'.__('Section','lms').' <select name="section_id" id="section_id" required class="widefat">'.$this->get_section_selected('',$c_id).'</select></p><p>'.__('Add New Lesson','lms').' <input type="text" name="lesson_title" id="lesson_title" class="widefat" value="" placeholder="'.__('Enter lesson title','lms').'"></p><p>'.__('Search Lesson','lms').' <input type="text" name="lesson_search" id="lesson_search" value="" class="widefat" placeholder="'.__('Search by lesson title','lms').'"></p><div id="lesson_search_result"></div><div id="lesson_selected"></div><div class="lms-loader" id="lesson-assign-form-loader"></div></div>' ) );
				} else {
					echo json_encode( array( 'status' => 'false', 'data' => __('Please enter section name','lms') ) );
				}
			}
			exit;
		}
		
		if( isset( $_REQUEST['option'] ) and $_REQUEST['option'] == 'assignLesson' ){
			global $wpdb;
			$c_id = (int)sanitize_text_field( $_REQUEST['c_id'] );
			$section_id = (int)sanitize_text_field( $_REQUEST['section_id'] );
			$lesson_id = (int)sanitize_text_field( $_REQUEST['lesson_id'] );
			$lesson_title = sanitize_text_field( $_REQUEST['lesson_title'] );
			
			if( !$lesson_id && !$lesson_title ){
				echo json_encode( array( 'status' => 'false', 'data' => __('Please select lesson or create new one!','lms') ) );
				exit;
			}
			
			if( $lesson_id ){
				$course_ids = lms_get_courses_which_has_this_lesson( $lesson_id );
				if( $course_ids ){
					echo json_encode( array( 'status' => 'false', 'data' => sprintf( __( 'This lesson is already assigned to %s please choose a different one!', 'lms' ), get_the_title( $course_ids[0]) ) ) );
					exit;
				}
				
				echo json_encode( array( 'status' => 'true', 'data' => '<div class="lesson-item" data-id="'.$lesson_id.'"><strong>'.__('Lesson','lms').'</strong> <input type="hidden" name="lesson_ids_'.$section_id.'[]" id="lesson_ids_'.$lesson_id.'" value="'.$lesson_id.'"> '.get_the_title($lesson_id).' <strong>'.__('Delay','lms').'</strong> <input type="text" name="lesson_delay_'.$lesson_id.'" value="" size="2"> <strong>'.__('Set lesson to free','lms').'</strong> <input type="checkbox" name="lesson_free_'.$lesson_id.'" value="Yes"> <a href="post.php?post='.$lesson_id.'&action=edit" target="_blank" class="lms-edit">'.LMS_EDIT_IMAGE.'</a> <a href="javascript:void(0)" onclick="removeLesson(this)" class="lms-delete">'.LMS_DELETE_IMAGE.'</a></div>' ) );
				
			} elseif( $lesson_title ){
				$lesson_post = array(
					'post_title'    => $lesson_title,
					'post_status'   => 'publish',
					'post_author'   => get_current_user_id(),
					'post_type' => 'lms_lesson',
				);
				
				//$video_width = (int)get_post_meta( $c_id, 'video_width', true );
				//$video_height = (int)get_post_meta( $c_id, 'video_height', true );
				$video_minimum_percentage = (int)get_post_meta( $c_id, 'video_minimum_percentage', true );				
				
				$lesson_post['meta_input'] = array(
					//'video_width' => $video_width,
					//'video_height' => $video_height,
					'video_minimum_percentage' => $video_minimum_percentage,
					'video_add_automatically_below_title' => 'yes'
				);
				
				$new_post_id = wp_insert_post( $lesson_post );
				echo json_encode( array( 'status' => 'true', 'data' => '<div class="lesson-item" data-id="'.$new_post_id.'"><strong>'.__('Lesson','lms').'</strong> <input type="hidden" name="lesson_ids_'.$section_id.'[]" id="lesson_ids_'.$new_post_id.'" value="'.$new_post_id.'"> '.get_the_title($new_post_id).' <strong>'.__('Delay','lms').'</strong> <input type="text" name="lesson_delay_'.$new_post_id.'" value="" size="2"><strong>'.__('Set lesson to free','lms').'</strong> <input type="checkbox" name="lesson_free_'.$new_post_id.'" value="Yes"> <a href="post.php?post='.$new_post_id.'&action=edit" target="_blank" class="lms-edit">'.LMS_EDIT_IMAGE.'</a> <a href="javascript:void(0)" onclick="removeLesson(this)" class="lms-delete">'.LMS_DELETE_IMAGE.'</a></div>' ) );
			} else {
				echo json_encode( array( 'status' => 'false', 'data' => __('Error!','lms') ) );
			}
			exit;
		}
		
		if( isset( $_REQUEST['option'] ) and $_REQUEST['option'] == 'assignRule' ){
			global $wpdb;
			
			$c_id = sanitize_text_field( $_REQUEST['c_id'] );
			$first_lesson_id = sanitize_text_field( $_REQUEST['first_lesson_id'] );
			$second_lesson_id = sanitize_text_field( $_REQUEST['second_lesson_id'] );
			
			if( !$c_id or !$first_lesson_id or !$second_lesson_id ){
				echo json_encode( array( 'status' => 'false', 'data' => __('Error!','lms') ) );
				exit;
			}
			
			if( $first_lesson_id == $second_lesson_id ){
				echo json_encode( array( 'status' => 'false', 'data' => __('Please choose different lessons!','lms') ) );
				exit;
			}
			
			// we can now insert data 
			$rule_data = array( 'c_id' => $c_id, 'f_l_id' => $first_lesson_id, 's_l_id' => $second_lesson_id );
			$wpdb->insert( $wpdb->prefix.'lms_lesson_start_rules', $rule_data );
			echo json_encode( array( 'status' => 'true', 'data' => '<div class="rule-item"><strong>'.get_the_title($first_lesson_id).'</strong> '.__('must be completed before', 'lms').' <strong>'.get_the_title($second_lesson_id).'</strong> '.__('can be started','lms').' <a href="javascript:void(0)" onclick="removeRule(this, '.$wpdb->insert_id.')" class="lms-delete">'.LMS_DELETE_IMAGE.'</a></div>' ) );
			exit;
		}
		
		if( isset( $_REQUEST['option'] ) and $_REQUEST['option'] == 'removeAssignedUser' ){
			global $wpdb;
			$m_id = sanitize_text_field( $_REQUEST['m_id'] );
			$data = $wpdb->get_row($wpdb->prepare("SELECT * FROM ".$wpdb->prefix."lms_user_mapping WHERE m_id = %d", $m_id));
			if( $data ){
				$action_data = array( 'course_id' => $data->c_id, 'user_id' => $data->user_id );
			}
			$wpdb->delete( $wpdb->prefix.'lms_user_mapping', array( 'm_id' => $m_id ) );
			do_action( 'lms_user_unassigned', $action_data );
			echo 'removed';
			exit;
		}
		
		if( isset( $_REQUEST['option'] ) and $_REQUEST['option'] == 'removeAssignedAmUser' ){
			global $wpdb;
			$m_id = sanitize_text_field( $_REQUEST['m_id'] );
			$data = $wpdb->get_row($wpdb->prepare("SELECT * FROM ".$wpdb->prefix."lms_am_user_mapping WHERE m_id = %d", $m_id));
			if( $data ){
				$action_data = array( 'am_id' => $data->am_id, 'user_id' => $data->user_id );
			}
			$wpdb->delete( $wpdb->prefix.'lms_am_user_mapping', array( 'm_id' => $m_id ) );

			// delete order log //
			lms_delete_order( array( 'user_id' => $data->user_id, 'payment_gateway' => 'manual', 'payment_gateway_order_id' => $data->am_id ) );
			// delete order log //

			do_action( 'lms_am_user_unassigned', $action_data );
			echo 'removed';
			exit;
		}
		
		if( isset( $_REQUEST['option'] ) and $_REQUEST['option'] == 'removeSection' ){
			global $wpdb;
			$s_id = sanitize_text_field( $_REQUEST['s_id'] );
			$wpdb->delete( $wpdb->prefix.'lms_lesson_mapping', array( 's_id' => $s_id ) );
			$wpdb->delete( $wpdb->prefix.'lms_section', array( 's_id' => $s_id ) );
			echo 'removed';
			exit;
		}
		
		if( isset( $_REQUEST['option'] ) and $_REQUEST['option'] == 'removeRule' ){
			global $wpdb;
			$r_id = sanitize_text_field( $_REQUEST['r_id'] );
			$wpdb->delete( $wpdb->prefix.'lms_lesson_start_rules', array( 'r_id' => $r_id ) );
			echo 'removed';
			exit;
		}
		
		if( isset( $_REQUEST['option'] ) and $_REQUEST['option'] == 'LessonSearch' ){
			global $wpdb;
			$ret = '';
			$lesson_search = sanitize_text_field( $_REQUEST['lesson_search'] );
			
			if( empty( $lesson_search ) ){
				$ret = '';
			} else {
				$args = array(
					'post_type' => 'lms_lesson',
					'posts_per_page' => -1,
					's' => $lesson_search,
				);
				$query_data = get_posts( $args );
				if ( $query_data ) {
					$ret .= '<ul>';
					foreach ( $query_data as $data ) {
						$ret .= '<li><a class="button" href="javascript:void(0)" onclick="lessonSelectionFromSearch('.$data->ID.', \''.$data->post_title.'\');">'.$data->post_title.'</a></li>';
					}
					$ret .= '</ul>';
				}
				wp_reset_postdata();
			}
			
			echo $ret;
			exit;
		}
		
		if( isset( $_REQUEST['option'] ) and $_REQUEST['option'] == 'UserSearch' ){
			global $wpdb;
			$ret = '';
			$user_search = sanitize_text_field( $_REQUEST['user_search'] );
			
			if( empty( $user_search ) ){
				$ret = '';
			} else {
				$users = new WP_User_Query( array(
					'search'         => '*'.esc_attr( $user_search ).'*',
					'search_columns' => array(
						'user_login',
						'user_nicename',
						'user_email',
					),
				) );
				$query_data_user = $users->get_results();
				
				if ( $query_data_user ) {
					$ret .= '<ul>';
					foreach ( $query_data_user as $data ) {
						$ret .= '<li><a class="button" href="javascript:void(0)" onclick="userSelectionFromSearch('.$data->ID.', \''.$data->user_email.'\');">'.$data->user_email.'</a></li>';
					}
					$ret .= '</ul>';
				}
			}
			
			echo $ret;
			exit;
		}
		
		if( isset( $_REQUEST['option'] ) and $_REQUEST['option'] == 'assignResource' ){
			global $wpdb;
			$l_id = sanitize_text_field( $_REQUEST['l_id'] );
			$r_id = sanitize_text_field( $_REQUEST['resource_id'] );
			
			$link_title = sanitize_text_field( $_REQUEST['link_title'] );
			$link_internal_title = sanitize_text_field( $_REQUEST['link_internal_title'] );
			$link_url = sanitize_text_field( $_REQUEST['link_url'] );
			$link_open_in_new_tab = sanitize_text_field( $_REQUEST['link_open_in_new_tab'] );
			$link_nofollow = sanitize_text_field( $_REQUEST['link_nofollow'] );
			
			if( !$r_id and !$link_title){
				echo json_encode( array( 'status' => 'false', 'data' => __('Please select resource or add a new one!','lms') ) );
				exit;
			}

			if($r_id){ // resorce selected 
				echo json_encode( array( 'status' => 'true', 'data' => '<div class="resource-item"><strong>'.__('Resource','lms').'</strong> <input type="hidden" name="resource_ids[]" value="'.$r_id.'"><input type="hidden" name="resource_titles[]" value=""> <input type="hidden" name="resource_hts[]" value="no"> ' . get_the_title($r_id) . '</div>' ) );
				exit;
			}

			if($link_title){ // new resource needs to be added

				$resource_post = array(
					'post_title'    => $link_title,
					'post_status'   => 'publish',
					'post_author'   => get_current_user_id(),
					'post_type' => 'lms_resource',
				);
				$resource_post['meta_input'] = array(
					'link_internal_title' => $link_internal_title,
					'link_url' => $link_url,
					'link_open_in_new_tab' => $link_open_in_new_tab,
					'link_nofollow' => $link_nofollow,
				);
				
				$new_post_id = wp_insert_post( $resource_post );

				echo json_encode( array( 'status' => 'true', 'data' => '<div class="resource-item"><strong>'.__('Resource','lms').'</strong> <input type="hidden" name="resource_ids[]" value="'.$new_post_id.'"><input type="hidden" name="resource_titles[]" value=""> <input type="hidden" name="resource_hts[]" value="no"> ' . get_the_title($new_post_id) . '</div>' ) );
				exit;

			}
			
			echo json_encode( array( 'status' => 'false' ) );
			exit;
		}
		
		if( isset( $_REQUEST['option'] ) and $_REQUEST['option'] == 'assignResourceTitle' ){
			global $wpdb;
			$l_id = sanitize_text_field( $_REQUEST['l_id'] );
			$resource_title = sanitize_text_field( $_REQUEST['resource_title'] );
			
			if( !$l_id ){
				echo json_encode( array( 'status' => 'false', 'data' => __('Unexpected error!','lms') ) );
				exit;
			}
			
			if( !$resource_title ){
				echo json_encode( array( 'status' => 'false', 'data' => __('Please enter resource title!','lms') ) );
				exit;
			}
			
			echo json_encode( array( 'status' => 'true', 'data' => '<div class="resource-item resource-item-title"><strong>'.__('Title','lms').'</strong> <input type="hidden" name="resource_ids[]" value="0"><input type="hidden" name="resource_titles[]" value="' . stripslashes($resource_title) . '"> <input type="hidden" name="resource_hts[]" value="no"> ' . stripslashes( $resource_title ) . ' ' . __('Highlight', 'lms') . ' <input type="checkbox" onclick="resourceHT(this)"></div>' ) );
			exit;
		}
		
		if( isset( $_REQUEST['option'] ) and $_REQUEST['option'] == 'ResourceSearch' ){
			global $wpdb;
			$ret = '';
			$resource_search = sanitize_text_field( $_REQUEST['resource_search'] );
			
			if( empty( $resource_search ) ){
				$ret = '';
			} else {
				$args = array(
					'post_type' => 'lms_resource',
					'posts_per_page' => -1,
					's' => $resource_search,
				);
				$query_data = get_posts( $args );
				if ( $query_data ) {
					$ret .= '<ul>';
					foreach ( $query_data as $data ) {
						$ret .= '<li><a class="button" href="javascript:void(0)" onclick="resourceSelectionFromSearch('.$data->ID.', \''.$data->post_title.'\');">'.$data->post_title.'</a></li>';
					}
					$ret .= '</ul>';
				}
				wp_reset_postdata();
			}
			
			echo $ret;
			exit;
		}
		
		if( isset( $_REQUEST['option'] ) and $_REQUEST['option'] == 'sendAmAssignedForceEmails' ){
			global $wpdb;
			$am_id = sanitize_text_field( $_REQUEST['am_id'] );
			$email_a_users = $_REQUEST['email_a_users'];
			
			if( is_array($email_a_users) and count($email_a_users)){
				foreach( $email_a_users as $key => $value ){
					$data = array('am_id' => $am_id, 'user_id' => $value);
					send_am_assigned_mail( $data );
				}
				echo json_encode( array( 'status' => 'Email sent successfully.' ) );
			} else {
				echo json_encode( array( 'status' => 'Error: Users not found!' ) );
			}
			exit;
		}
		
		if( isset( $_REQUEST['option'] ) and $_REQUEST['option'] == 'sendAmUnassignedForceEmails' ){
			global $wpdb;
			$am_id = sanitize_text_field( $_REQUEST['am_id'] );
			$email_un_users = $_REQUEST['email_un_users'];
			
			if( is_array($email_un_users) and count($email_un_users)){
				foreach( $email_un_users as $key => $value ){
					$data = array('am_id' => $am_id, 'user_id' => $value);
					send_am_unassigned_mail( $data );
				}
				echo json_encode( array( 'status' => 'Email sent successfully.' ) );
			} else {
				echo json_encode( array( 'status' => 'Error: Users not found!' ) );
			}
			exit;
		}
		
	}
	
	public function save_post_data( $post_id ) {
		global $wpdb;
		
		if ( ! isset( $_POST['attachment_meta_box_nonce'] ) ) {
			return;
		}
	
		if ( ! wp_verify_nonce( $_POST['attachment_meta_box_nonce'], 'attachment_meta_box' ) ) {
			return;
		}
	
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {
	
			if ( ! current_user_can( 'edit_page', $post_id ) ) {
				return;
			}
	
		} else {
	
			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return;
			}
		}
		
		
		/* 
		Course mapping  
		*/
		if( isset($_POST['post_type']) && ($_POST['post_type'] == 'lms_access_mgmt') ){
			$this->lms_course_mapping_data_update( $post_id );
		}
		/* 
		Course mapping  
		*/

		/* 
		Post mapping  
		*/
		if( isset($_POST['post_type']) && ($_POST['post_type'] == 'lms_access_mgmt') ){
			$this->lms_post_mapping_data_update( $post_id );
		}
		/* 
		Post mapping  
		*/
		
		/* 
		User access mapping update 
		*/
		if( isset($_POST['post_type']) && ($_POST['post_type'] == 'lms_access_mgmt') ){
			$this->lms_am_user_mapping_data_update( $post_id );
		}
		/* 
		User access mapping update 
		*/
		
		/* 
		Other data for access management
		*/
		if( isset($_POST['post_type']) && ($_POST['post_type'] == 'lms_access_mgmt') ){
			$this->lms_am_other_data_update( $post_id );
		}
		/* 
		Other data for access management
		*/
		
		/* 
		Lesson & Section mapping  
		*/
		if( isset($_POST['post_type']) && ($_POST['post_type'] == 'lms_course') ){
			$this->lms_lesson_section_mapping_data_update( $post_id );
		}
		/* 
		Lesson & Section mapping  
		*/
		
		/* 
		User mapping update 
		*/
		if( isset($_POST['post_type']) && ($_POST['post_type'] == 'lms_course') ){
			$this->lms_user_mapping_data_update( $post_id );
		}
		/* 
		User mapping update 
		*/
		
		/* 
		Resources data update
		*/
		if( isset($_POST['post_type']) && ($_POST['post_type'] == 'lms_resource') ){
			$this->lms_resources_data_update_v1( $post_id );
			$this->lms_resources_data_update( $post_id );	
		}
		/* 
		Resources data update
		*/
		
		/* 
		Resource mapping  
		*/
		if( isset($_POST['post_type']) && ($_POST['post_type'] == 'lms_lesson') ){
			$this->lms_resource_mapping_data_update( $post_id );
		}
		/* 
		Resource mapping  
		*/
		
		// other settings course //
		if( isset($_POST['post_type']) && ( $_POST['post_type'] == 'lms_course' ) ){
			$this->lms_other_course_data_update( $post_id );	
		}
		
		// other settings lesson //
		if( isset($_POST['post_type']) && ( $_POST['post_type'] == 'lms_lesson' ) ){
			$this->lms_other_lesson_data_update( $post_id );	
		}
		
	}
	
	public function lms_am_other_data_update( $post_id ){
		if(!$post_id){
			return false;
		}
		
		if( isset($_REQUEST['internal_name']) ){
			update_post_meta($post_id, 'internal_name', sanitize_text_field($_REQUEST['internal_name']));
		} else {
			delete_post_meta($post_id, 'internal_name');
		}
		
		// assign 
		if( isset($_REQUEST['enrolled_send_to_user']) and $_REQUEST['enrolled_send_to_user'] == 'yes'){
			update_post_meta($post_id, 'enrolled_send_to_user', 'yes');
		} else {
			update_post_meta($post_id, 'enrolled_send_to_user', 'no');
		}
		
		if( isset($_REQUEST['enrolled_send_to_admin']) ){
			update_post_meta($post_id, 'enrolled_send_to_admin', 'yes');
		} else {
			delete_post_meta($post_id, 'enrolled_send_to_admin');
		}
		
		if( isset($_REQUEST['lms_access_assign_subject']) ){
			update_post_meta($post_id, 'lms_access_assign_subject', esc_html($_REQUEST['lms_access_assign_subject']));
		} else {
			delete_post_meta($post_id, 'lms_access_assign_subject');
		}
		
		if( isset($_REQUEST['lms_access_assign_body']) ){
			update_post_meta($post_id, 'lms_access_assign_body', esc_html($_REQUEST['lms_access_assign_body']));
		} else {
			delete_post_meta($post_id, 'lms_access_assign_body');
		}
		
		// unassign
		if( isset($_REQUEST['unenrolled_send_to_user']) and $_REQUEST['unenrolled_send_to_user'] == 'yes'){
			update_post_meta($post_id, 'unenrolled_send_to_user', 'yes');
		} else {
			update_post_meta($post_id, 'unenrolled_send_to_user', 'no');
		}
		
		if( isset($_REQUEST['unenrolled_send_to_admin']) ){
			update_post_meta($post_id, 'unenrolled_send_to_admin', 'yes');
		} else {
			delete_post_meta($post_id, 'unenrolled_send_to_admin');
		}
		
		if( isset($_REQUEST['lms_access_unassign_subject']) ){
			update_post_meta($post_id, 'lms_access_unassign_subject', esc_html($_REQUEST['lms_access_unassign_subject']));
		} else {
			delete_post_meta($post_id, 'lms_access_unassign_subject');
		}
		
		if( isset($_REQUEST['lms_access_unassign_body']) ){
			update_post_meta($post_id, 'lms_access_unassign_body', esc_html($_REQUEST['lms_access_unassign_body']));
		} else {
			delete_post_meta($post_id, 'lms_access_unassign_body');
		}
		
	}
	
	public function lms_other_course_data_update( $post_id ){
		if(!$post_id){
			return false;
		}
		
		if( isset($_REQUEST['lesson_one_by_one']) ){
			update_post_meta($post_id, 'lesson_one_by_one', sanitize_text_field($_REQUEST['lesson_one_by_one']));
		} else {
			delete_post_meta($post_id, 'lesson_one_by_one');
		}
		
		if( isset($_REQUEST['user_not_assigned_to_do']) ){
			update_post_meta($post_id, 'user_not_assigned_to_do', sanitize_text_field($_REQUEST['user_not_assigned_to_do']));
		} else {
			delete_post_meta($post_id, 'user_not_assigned_to_do');
		}
		
		if( isset($_REQUEST['redirect_to_page_id']) ){
			update_post_meta($post_id, 'redirect_to_page_id', sanitize_text_field($_REQUEST['redirect_to_page_id']));
		} else {
			delete_post_meta($post_id, 'redirect_to_page_id');
		}
		
		if( isset($_REQUEST['redirect_to_page_url']) ){
			update_post_meta($post_id, 'redirect_to_page_url', sanitize_text_field($_REQUEST['redirect_to_page_url']));
		} else {
			delete_post_meta($post_id, 'redirect_to_page_url');
		}
		
		// videos integration
		/*if( isset($_REQUEST['video_width']) ){
			update_post_meta($post_id, 'video_width', (int)sanitize_text_field($_REQUEST['video_width']));
		} else {
			delete_post_meta($post_id, 'video_width');
		}
		if( isset($_REQUEST['video_height']) ){
			update_post_meta($post_id, 'video_height', (int)sanitize_text_field($_REQUEST['video_height']));
		} else {
			delete_post_meta($post_id, 'video_height');
		}*/
		if( isset($_REQUEST['video_minimum_percentage']) ){
			update_post_meta($post_id, 'video_minimum_percentage', (int)sanitize_text_field($_REQUEST['video_minimum_percentage']));
		} else {
			delete_post_meta($post_id, 'video_minimum_percentage');
		}
		// videos integration

		if( isset($_REQUEST['disable_course_progress']) ){
			update_post_meta($post_id, 'disable_course_progress', sanitize_text_field($_REQUEST['disable_course_progress']));
		} else {
			delete_post_meta($post_id, 'disable_course_progress');
		}

		if( isset($_REQUEST['course_is_free']) ){
			update_post_meta($post_id, 'course_is_free', sanitize_text_field($_REQUEST['course_is_free']));
		} else {
			delete_post_meta($post_id, 'course_is_free');
		}

		if( isset($_REQUEST['watching_video_mandatory']) ){
			update_post_meta($post_id, 'watching_video_mandatory', sanitize_text_field($_REQUEST['watching_video_mandatory']));
		} else {
			delete_post_meta($post_id, 'watching_video_mandatory');
		}

		if( isset($_REQUEST['action_after_course_complete']) ){
			update_post_meta($post_id, 'action_after_course_complete', sanitize_text_field($_REQUEST['action_after_course_complete']));
		} else {
			delete_post_meta($post_id, 'action_after_course_complete');
		}

		if( isset($_REQUEST['course_complete_action']) ){
			update_post_meta($post_id, 'course_complete_action', sanitize_text_field($_REQUEST['course_complete_action']));
		} else {
			delete_post_meta($post_id, 'course_complete_action');
		}

		if( isset($_REQUEST['cc_redirect_to_page_id']) ){
			update_post_meta($post_id, 'cc_redirect_to_page_id', sanitize_text_field($_REQUEST['cc_redirect_to_page_id']));
		} else {
			delete_post_meta($post_id, 'cc_redirect_to_page_id');
		}

		if( isset($_REQUEST['cc_redirect_to_page_url']) ){
			update_post_meta($post_id, 'cc_redirect_to_page_url', sanitize_text_field($_REQUEST['cc_redirect_to_page_url']));
		} else {
			delete_post_meta($post_id, 'cc_redirect_to_page_url');
		}

		if( isset($_REQUEST['cc_popup_message']) ){
			update_post_meta($post_id, 'cc_popup_message', sanitize_text_field($_REQUEST['cc_popup_message']));
		} else {
			delete_post_meta($post_id, 'cc_popup_message');
		}

	}
	
	public function lms_other_lesson_data_update( $post_id ){
		if(!$post_id){
			return false;
		}
		
		// forminator integration 
		if( isset($_REQUEST['enable_forminator']) ){
			update_post_meta($post_id, 'enable_forminator', sanitize_text_field($_REQUEST['enable_forminator']));
		} else {
			delete_post_meta($post_id, 'enable_forminator');
		}
		if( isset($_REQUEST['forminator_frm_type']) ){
			update_post_meta($post_id, 'forminator_frm_type', sanitize_text_field($_REQUEST['forminator_frm_type']));
		} else {
			delete_post_meta($post_id, 'forminator_frm_type');
		}
		if( isset($_REQUEST['forminator_quiz_minimum_percentage']) ){
			update_post_meta($post_id, 'forminator_quiz_minimum_percentage', (int)sanitize_text_field($_REQUEST['forminator_quiz_minimum_percentage']));
		} else {
			delete_post_meta($post_id, 'forminator_quiz_minimum_percentage');
		}
		// forminator integration 
		
		// videos integration
		/*if( isset($_REQUEST['video_width']) ){
			update_post_meta($post_id, 'video_width', (int)sanitize_text_field($_REQUEST['video_width']));
		} else {
			delete_post_meta($post_id, 'video_width');
		}
		if( isset($_REQUEST['video_height']) ){
			update_post_meta($post_id, 'video_height', (int)sanitize_text_field($_REQUEST['video_height']));
		} else {
			delete_post_meta($post_id, 'video_height');
		}*/
		if( isset($_REQUEST['video_url']) ){
			update_post_meta($post_id, 'video_url', sanitize_text_field($_REQUEST['video_url']));
		} else {
			delete_post_meta($post_id, 'video_url');
		}

		if( isset($_REQUEST['video_watching_is_mandatory']) ){
			update_post_meta($post_id, 'video_watching_is_mandatory', sanitize_text_field($_REQUEST['video_watching_is_mandatory']));
		} else {
			delete_post_meta($post_id, 'video_watching_is_mandatory');
		}

		if( isset($_REQUEST['video_minimum_percentage_by_lesson']) ){
			update_post_meta($post_id, 'video_minimum_percentage_by_lesson', sanitize_text_field($_REQUEST['video_minimum_percentage_by_lesson']));
		} else {
			delete_post_meta($post_id, 'video_minimum_percentage_by_lesson');
		}
		
		if( isset($_REQUEST['video_minimum_percentage']) ){
			update_post_meta($post_id, 'video_minimum_percentage', (int)sanitize_text_field($_REQUEST['video_minimum_percentage']));
		} else {
			delete_post_meta($post_id, 'video_minimum_percentage');
		}
		if( isset($_REQUEST['video_add_automatically_below_title']) ){
			update_post_meta($post_id, 'video_add_automatically_below_title', sanitize_text_field($_REQUEST['video_add_automatically_below_title']));
		} else {
			delete_post_meta($post_id, 'video_add_automatically_below_title');
		}
		if( isset($_REQUEST['video_insert_manually']) ){
			update_post_meta($post_id, 'video_insert_manually', sanitize_text_field($_REQUEST['video_insert_manually']));
		} else {
			delete_post_meta($post_id, 'video_insert_manually');
		}
		// videos integration
		  
	}
	
	public function lms_resources_data_update_v1( $post_id ){
		if(!$post_id){
			return false;
		}
		global $wpdb;

		// remove old data first //
			$where = array( 'post_id' => $post_id );
			$wpdb->delete( $wpdb->prefix.'lms_resource', $where );
		// remove old data first //
				
		$lmsr_atts = $_REQUEST['lmsr_atts'];
		if( is_array( $lmsr_atts ) ){
			foreach( $lmsr_atts as $key => $value ){
				if( $value != '' ){
					if( $value == 0 ){
						$r_link = array( 'name' => sanitize_text_field( $_REQUEST['link_names'][$key] ), 'url' => sanitize_text_field( $_REQUEST['link_urls'][$key] ), 'open_in_new_tab' => sanitize_text_field( $_REQUEST['link_open_in_new_tabs'][$key] ) );
						$data = array( 'att_id' => $value, 'post_id' => $post_id, 'r_link' => json_encode($r_link) );
					} else {
						$data = array( 'att_id' => $value, 'post_id' => $post_id );
					}
					$wpdb->insert( $wpdb->prefix."lms_resource", $data );
				}
			}
		}
	}
	
	public function lms_resources_data_update( $post_id ){
		if(!$post_id){
			return false;
		}

		if( isset($_REQUEST['link_internal_title']) ){
			update_post_meta($post_id, 'link_internal_title', sanitize_text_field($_REQUEST['link_internal_title']));
		} else {
			delete_post_meta($post_id, 'link_internal_title');
		}

		if( isset($_REQUEST['link_url']) ){
			update_post_meta($post_id, 'link_url', sanitize_text_field($_REQUEST['link_url']));
		} else {
			delete_post_meta($post_id, 'link_url');
		}

		if( isset($_REQUEST['link_open_in_new_tab']) ){
			update_post_meta($post_id, 'link_open_in_new_tab', 'yes');
		} else {
			update_post_meta($post_id, 'link_open_in_new_tab', 'no');
		}

		if( isset($_REQUEST['link_nofollow']) ){
			update_post_meta($post_id, 'link_nofollow', sanitize_text_field($_REQUEST['link_nofollow']));
		} else {
			delete_post_meta($post_id, 'link_nofollow');
		}
		
	}
	
	public function lms_am_user_mapping_data_update( $post_id ){
		if(!$post_id){
			return false;
		}
		global $wpdb;
		
		$m_ids = $_POST['m_ids'];
		$user_ids = $_POST['user_ids'];
		$user_statuses = $_POST['user_statuses'];
		
		// update
		if(is_array($m_ids)){
			foreach($m_ids as $key => $value){
				if($value){
					$map_data = array( 'user_id' => sanitize_text_field( $user_ids[$key] ), 'm_status' => sanitize_text_field( $user_statuses[$key] ) );
					$action_data = array( 'user_id' => sanitize_text_field( $user_ids[$key] ), 'am_id' => $post_id, 'status' => sanitize_text_field( $user_statuses[$key] ) );
					$update = $wpdb->update( $wpdb->prefix.'lms_am_user_mapping', $map_data, array( 'm_id' => $value ) );
					//if($update != false ){
					if(sanitize_text_field( $user_statuses[$key] ) == 'Active'){
						do_action( 'lms_am_user_assigned', $action_data );
					} else {
						do_action( 'lms_am_user_unassigned', $action_data );
					}
					//}
				}
			}
		}
	}
	
	public function lms_user_mapping_data_update( $post_id ){
		if(!$post_id){
			return false;
		}
		global $wpdb;
		
		$m_ids = $_POST['m_ids'];
		$user_ids = $_POST['user_ids'];
		$user_statuses = $_POST['user_statuses'];
		
		// update
		if(is_array($m_ids)){
			foreach($m_ids as $key => $value){
				if($value){
					$map_data = array( 'user_id' => sanitize_text_field( $user_ids[$key] ), 'm_status' => sanitize_text_field( $user_statuses[$key] ) );
					$action_data = array( 'user_id' => sanitize_text_field( $user_ids[$key] ), 'course_id' => $post_id, 'status' => sanitize_text_field( $user_statuses[$key] ) );
					$update = $wpdb->update( $wpdb->prefix.'lms_user_mapping', $map_data, array( 'm_id' => $value ) );
					if($update != false ){
						if(sanitize_text_field( $user_statuses[$key] ) == 'Active'){
							do_action( 'lms_user_assigned', $action_data );
						} else {
							do_action( 'lms_user_unassigned', $action_data );
						}
					}
				}
			}
		}
	}
	
	public function lms_course_mapping_data_update( $post_id ){
		if(!$post_id){
			return false;
		}
		global $wpdb;
		
		// remove old data 
		$where = array( 'am_id' => $post_id );
		$wpdb->delete( $wpdb->prefix.'lms_course_mapping', $where );
		
		$order = 1;
		$course_ids = $_POST['course_ids'];
		// new data insert
		if(is_array($course_ids)){
			foreach($course_ids as $key => $value){
				if($value){
					$c_id = sanitize_text_field( $value );
					$map_data_course = array( 'am_id' => $post_id, 'c_id' => $c_id, 'm_order' => $order );
					$is_assigned = lms_is_course_already_assigned_to_am( $post_id, $c_id );
					if( $is_assigned === false ){
						$wpdb->insert( $wpdb->prefix.'lms_course_mapping', $map_data_course );
						$order++;
					}
				}
			}
		}
		
		// apply global rules
		
		// remove old data 
		$where = array( 'am_id' => $post_id );
		$wpdb->delete( $wpdb->prefix.'lms_lesson_start_rules_disabled', $where );
		
		$disable_lesson_rules = $_POST['disable_lesson_rules'];
		if(is_array($disable_lesson_rules)){
			foreach($disable_lesson_rules as $key => $value){
				if($value){
					$c_id = sanitize_text_field( $value );
					// check if rule exists 
					if( !lms_is_lesson_start_global_rule_exists_on_am( $c_id, $post_id ) ){
						$rule_data = array( 'am_id' => $post_id, 'c_id' => $c_id );
						$wpdb->insert( $wpdb->prefix.'lms_lesson_start_rules_disabled', $rule_data );
					}
				}
			}
		}
		
	}
	
	public function lms_post_mapping_data_update( $post_id ){
		if(!$post_id){
			return false;
		}
		global $wpdb;
		
		// remove old data 
		$where = array( 'am_id' => $post_id );
		$wpdb->delete( $wpdb->prefix.'lms_post_mapping', $where );
		
		$order = 1;
		$post_ids = $_POST['post_ids'];
		// new data insert
		if(is_array($post_ids)){
			foreach($post_ids as $key => $value){
				if($value){
					$p_id = sanitize_text_field( $value );
					$map_data_post = array( 'am_id' => $post_id, 'p_id' => $p_id, 'm_order' => $order );
					$is_assigned = lms_is_post_already_assigned_to_am( $post_id, $p_id );
					if( $is_assigned === false ){
						$wpdb->insert( $wpdb->prefix.'lms_post_mapping', $map_data_post );
						$order++;
					}
				}
			}
		}
		
	}

	public function lms_lesson_section_mapping_data_update( $post_id ){
		if(!$post_id){
			return false;
		}
		global $wpdb;
		
		// remove old section data 
		$where = array( 'c_id' => $post_id, 'm_type' => 'section' );
		$wpdb->delete( $wpdb->prefix.'lms_lesson_mapping', $where );
		
		// remove old data 
		$where = array( 'c_id' => $post_id, 'm_type' => 'lesson' );
		$wpdb->delete( $wpdb->prefix.'lms_lesson_mapping', $where );
		
		$order = 1;
		$section_ids = $_POST['section_ids'];
		if( is_array( $section_ids ) ){
			foreach( $section_ids as $section_id ){
				
				// update section data 
				$s_name = sanitize_text_field( $_REQUEST['section_name_'.$section_id] );
				if( $s_name ){
					$update_section = array( 's_name' => $s_name );
					$update_section_where = array( 's_id' => $section_id );
					$wpdb->update( $wpdb->prefix.'lms_section', $update_section, $update_section_where );
				}
				
				// section data insert 
				$map_data_section = array( 'c_id' => $post_id, 'm_type' => 'section', 's_id' => $section_id, 'm_order' => $order );
				$wpdb->insert( $wpdb->prefix.'lms_lesson_mapping', $map_data_section );
									
				$lesson_ids = $_POST['lesson_ids_'.$section_id];
				// new data insert
				if(is_array($lesson_ids)){
					foreach($lesson_ids as $key => $value){
						if($value){
							$l_id = sanitize_text_field( $value );
							$l_delay = (int)sanitize_text_field( $_POST['lesson_delay_'.$l_id] );
							$lesson_free = sanitize_text_field( $_POST['lesson_free_'.$l_id] );
							$l_free = ($lesson_free == ''?'No':'Yes');
							$map_data_lesson = array( 'c_id' => $post_id, 'l_id' => $l_id, 's_id' => $section_id, 'm_type' => 'lesson', 'm_order' => $order, 'l_delay' => $l_delay, 'l_free' => $l_free );
							$is_assigned = lms_get_courses_which_has_this_lesson( $l_id );
							if( $is_assigned === false ){
								$wpdb->insert( $wpdb->prefix.'lms_lesson_mapping', $map_data_lesson );
								$order++;
							}
						}
					}
				}
			}
		}
	}
	
	public function lms_resource_mapping_data_update( $post_id ){
		if(!$post_id){
			return false;
		}
		global $wpdb;
		
		// remove old section data 
		$where = array( 'l_id' => $post_id );
		$wpdb->delete( $wpdb->prefix.'lms_resource_mapping', $where );
		
		$resource_ids = $_POST['resource_ids'];
		$resource_titles = $_POST['resource_titles'];
		$resource_hts = $_POST['resource_hts'];
		
		if( is_array( $resource_ids ) ){
			foreach( $resource_ids as $key => $resource_id ){
				// resource data insert 
				$map_data_resource = array( 'l_id' => $post_id, 'r_id' => sanitize_text_field($resource_id), 'r_title' => sanitize_text_field($resource_titles[$key]), 'r_highlight' => sanitize_text_field($resource_hts[$key]) );
				$wpdb->insert( $wpdb->prefix.'lms_resource_mapping', $map_data_resource );
			}
		}
	}

}