<?php

add_filter( 'the_content', 'tg_post_restrict' );

function tg_post_restrict( $content = null ){
	global $post;

	ob_start();
	if($post->post_type == 'tg_course'){
		if(is_admin()){
			include(TG_DIR_PATH . '/view/admin/shortcode/course-content.php');
		} else {
			$course_id = tg_get_course_id_from_template();
			$status = tg_check_course_rules($course_id);
			if( $status['status'] == true ){
				echo $content;
			} else {
				echo $status['msg'];
			}
		}
	} else if($post->post_type == 'tg_lesson'){
		
		if(is_admin()){
			include(TG_DIR_PATH . '/view/admin/shortcode/lesson-content.php');
		} else {
			$status = tg_is_current_user_assigned_to_lesson();
			if( $status['status'] == true ){
				echo $content;
			} else {
				echo $status['msg'];
			}
		}
	} else {
		return $content;
	}
	$data = ob_get_clean();
	return $data;
}

add_filter('default_hidden_meta_boxes','tg_hide_meta_boxes',10,2);

function tg_hide_meta_boxes($hidden, $screen) {
	
	if ( ('post' == $screen->base) && ('tg_access_mgmt' == $screen->id) ){
	  $hidden[] = 'authordiv';
	}
	
	if ( ('post' == $screen->base) && ('tg_resource' == $screen->id) ){
		$hidden[] = 'authordiv';
	}

    return $hidden;
  }