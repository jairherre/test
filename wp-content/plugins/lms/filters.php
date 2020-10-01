<?php

add_filter( 'the_content', 'lms_post_restrict' );

function lms_post_restrict( $content = null ){
	global $post;
	$has_access = lms_is_current_user_assigned_to_post( $post->ID );
	if( $has_access['status'] ){
		return $content;
	} else {
		return $has_access['msg'];
	}
}

add_filter('default_hidden_meta_boxes','lms_hide_meta_boxes',10,2);

function lms_hide_meta_boxes($hidden, $screen) {
	
	if ( ('post' == $screen->base) && ('lms_access_mgmt' == $screen->id) ){
	  $hidden[] = 'authordiv';
	}
	
	if ( ('post' == $screen->base) && ('lms_resource' == $screen->id) ){
		$hidden[] = 'authordiv';
	}

    return $hidden;
  }