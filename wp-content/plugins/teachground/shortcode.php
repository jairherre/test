<?php
/**
 * Shortcode functions and definations
 *
 * @package TeachGround
 */
defined( 'ABSPATH' ) || exit;

/**
 * Render lesson list
 *
 * @param array $atts
 * @return string
 */
function tg_lesson_list_shortcode( $atts ) {
	$atts = shortcode_atts( array(
		'section' => '',
	), $atts );

	ob_start();

	if(is_admin()){
		include(TG_DIR_PATH . '/view/admin/shortcode/lesson-list.php');
	} else {
		$course_id = tg_get_course_id_from_template();
		$status = tg_check_course_rules($course_id);
		if( $status['status'] == true ){
			$status = tg_is_current_user_assigned_to_course();
			if( $status['status'] == true ){
				if($atts['section'] == ''){
					the_lessons();
				} else {
					$section_ids = wp_parse_id_list( $atts['section'] );
					foreach ( $section_ids as $section_id ) {
						the_lessons_on_section( $section_id );
					}
				}
			} else {
				echo $status['msg'];
			}
		} else {
			echo $status['msg'];
		}
	}

	$data = ob_get_clean();
	return $data;
}

add_shortcode( 'tg_lesson_list', 'tg_lesson_list_shortcode' );

/**
 * Render course progressbar
 *
 * @return string
 */
function tg_course_progressbar_shortcode(){
	ob_start();

	$status = tg_is_current_user_assigned_to_course();

	if ( $status['status'] == true ) {
		$course_id = tg_get_course_id_from_template();
		the_course_complete_percent_bar( $course_id );
	} else {
		printf( '<div class="tg-CourseProgressbar__msg">%s</div>', esc_html( $status['msg'] ) );
	}

	$data = ob_get_clean();
	return $data;
}

add_shortcode( 'tg_course_progressbar', 'tg_course_progressbar_shortcode' );

/**
 * Render users course list
 *
 * @param array $atts
 * @return string
 */
function tg_user_courses_sc( $atts = [] ) {
	$atts = shortcode_atts(array(
		'orderby'        => 'date',
		'order'          => 'desc',
		'categories'     => '',
		
		'show_image'       => 'yes',
		'show_title'       => 'yes',
		'show_excerpt'     => 'yes',
		'show_progressbar' => 'yes',
		'show_author'      => 'yes',
		'show_completed'   => 'yes',
	), $atts);
	
	ob_start();
	courses_assigned_to_user( $atts );
	return ob_get_clean();
}

add_shortcode( 'tg_user_courses', 'tg_user_courses_sc' );

/**
 * Render course list shortcode output
 *
 * @param array $atts
 * @return string
 */
function tg_course_list_shortcode( $atts = [] ) {
	$atts = shortcode_atts( array(
		'orderby'        => 'date',
		'order'          => 'desc',
		'id'             => '',
		'categories'     => '',
		'assigned_first' => 'no',

		'show_image'       => 'yes',
		'show_title'       => 'yes',
		'show_excerpt'     => 'yes',
		'show_progressbar' => 'yes',
		'show_author'      => 'yes',
		'show_completed'   => 'yes',
	), $atts );

	ob_start();
	tg_course_list( $atts );
	$data = ob_get_clean();
	return $data;
}

add_shortcode( 'tg_course_list', 'tg_course_list_shortcode' );

/**
 * Render lesson video
 *
 * @return string
 */
function tg_lesson_video_shortcode() {
	ob_start();

	if(is_admin()){
		include(TG_DIR_PATH . '/view/admin/shortcode/lesson-video.php');
	} else {
		$status = tg_is_current_user_assigned_to_lesson();
		if ($status['status'] == true) {
			$lesson_id = tg_get_lesson_id_from_template();
			if($lesson_id){
				$video_url = get_post_meta($lesson_id, 'video_url', true);
				$video_type = tg_video_type($video_url);
				if ($video_type == 'youtube') {
					tg_youtube_video_player(array('post_id' => $lesson_id));
				} elseif ($video_type == 'vimeo') {
					tg_vimeo_video_player(array('post_id' => $lesson_id));
				}
			}
		} else {
			echo $status['msg'];
		}
	}

	$data = ob_get_clean();
	return $data;
}

add_shortcode( 'tg_lesson_video', 'tg_lesson_video_shortcode' );

/*
display lesson excerpt
parameters - post_id
shortcode [tg_lesson_excerpt post_id="2"]
*/
add_shortcode('tg_lesson_excerpt', 'tg_lesson_excerpt_sc');

// display lesson excerpt
function tg_lesson_excerpt_sc($atts){
	$atts = shortcode_atts(array(
		'color' => '#000',
		'font' => 'sans-serif',
		'font-size' => '15',
		'font-weight' => 'normal',
	), $atts);

	ob_start();
	if(is_admin()){
		include(TG_DIR_PATH . '/view/admin/shortcode/lesson-excerpt.php');
	} else {
		$lesson_id = tg_get_lesson_id_from_template();
		if($lesson_id){
			echo '<span style="font-size: ' . $atts['font-size'] . 'px; font-family: ' . $atts['font'] . '; color:' . $atts['color'] . '; font-weight:' . $atts['font-weight'] . '">' . get_the_excerpt($lesson_id) . '</span>';
		} else {
			echo '<span style="font-size: ' . $atts['font-size'] . 'px; font-family: ' . $atts['font'] . '; color:' . $atts['color'] . '; font-weight:' . $atts['font-weight'] . '">' . get_the_excerpt() . '</span>';
		}
	}
	$data = ob_get_clean();
	return $data;
}

/*
display lesson content
parameters - post_id
shortcode [tg_lesson_content post_id="2"]
*/
add_shortcode('tg_lesson_content', 'tg_lesson_content_sc');

// display lesson content
function tg_lesson_content_sc($atts){
	$atts = shortcode_atts(array(
		'color' => '#000',
		'font' => 'sans-serif',
		'font-size' => '15',
		'font-weight' => 'normal',
		'align' => 'left',
	), $atts);

	ob_start();
	if(is_admin()){
		include(TG_DIR_PATH . '/view/admin/shortcode/lesson-content.php');
	} else {
		$status = tg_is_current_user_assigned_to_lesson();
		if( $status['status'] == true ){
			$lesson_id = tg_get_lesson_id_from_template();
			if($lesson_id){
				echo '<span style="display: block; text-align: ' . $atts['align'] . '; font-size: ' . $atts['font-size'] . 'px; font-family: ' . $atts['font'] . '; color:' . $atts['color'] . '; font-weight:' . $atts['font-weight'] . '">' . get_the_content($lesson_id) . '</span>';
			} else {
				echo '<span style="display: block; text-align: ' . $atts['align'] . '; font-size: ' . $atts['font-size'] . 'px; font-family: ' . $atts['font'] . '; color:' . $atts['color'] . '; font-weight:' . $atts['font-weight'] . '">' . get_the_content() . '</span>';
			}
		} else {
			echo $status['msg'];
		}
	}
	$data = ob_get_clean();
	return $data;
}

/*
display lesson title
parameters - post_id
shortcode [tg_lesson_title post_id="2"]
*/
add_shortcode('tg_lesson_title', 'tg_lesson_title_sc');

// display lesson title
function tg_lesson_title_sc($atts){
	$atts = shortcode_atts(array(
		'color' => '#000',
		'font' => 'sans-serif',
		'font-size' => '20',
		'font-weight' => 'normal',
		'align' => 'left',
	), $atts);

	ob_start();
	if(is_admin()){
		include(TG_DIR_PATH . '/view/admin/shortcode/lesson-title.php');
	} else {
		$lesson_id = tg_get_lesson_id_from_template();
		if($lesson_id){
			echo '<span style="display: block; text-align: ' . $atts['align'] . '; font-size: ' . $atts['font-size'] . 'px; font-family: ' . $atts['font'] . '; color:' . $atts['color'] . '; font-weight:' . $atts['font-weight'] . '">' . get_the_title($lesson_id) . '</span>';
		} else {
			echo '<span style="display: block; text-align: ' . $atts['align'] . '; font-size: ' . $atts['font-size'] . 'px; font-family: ' . $atts['font'] . '; color:' . $atts['color'] . '; font-weight:' . $atts['font-weight'] . '">' . get_the_title() . '</span>';
		}
	}
	$data = ob_get_clean();
	return $data;

}

/*
display course content
parameters - post_id
shortcode [tg_course_content post_id="2"]
*/
add_shortcode('tg_course_content', 'tg_course_content_sc');

// display course content
function tg_course_content_sc($atts){
	$atts = shortcode_atts(array(
		'color' => '#000',
		'font' => 'sans-serif',
		'font-size' => '20',
		'font-weight' => 'normal',
		'align' => 'left',
	), $atts);

	ob_start();
	if(is_admin()){
		include(TG_DIR_PATH . '/view/admin/shortcode/course-content.php');
	} else {
		$course_id = tg_get_course_id_from_template();
		$status = tg_check_course_rules($course_id);
		if( $status['status'] == true ){
			echo '<span style="display: block; text-align: ' . $atts['align'] . '; font-size: ' . $atts['font-size'] . 'px; font-family: ' . $atts['font'] . '; color:' . $atts['color'] . '; font-weight:' . $atts['font-weight'] . '">' . get_the_content($course_id) . '</span>';
		} else {
			echo $status['msg'];
		}
	}

	$data = ob_get_clean();
	return $data;
}

/*
display course title
parameters - post_id
shortcode [tg_course_title post_id="2"]
*/
add_shortcode('tg_course_title', 'tg_course_title_sc');

// display course title
function tg_course_title_sc($atts){
	$atts = shortcode_atts(array(
		'color' => '#000',
		'font' => 'sans-serif',
		'font-size' => '20',
		'font-weight' => 'normal',
		'align' => 'left',
	), $atts);

	ob_start();
	if(is_admin()){
		include(TG_DIR_PATH . '/view/admin/shortcode/course-title.php');
	} else {
		$course_id = tg_get_course_id_from_template();
		if($course_id){
			return  '<span style="display: block; text-align: ' . $atts['align'] . '; font-size: ' . $atts['font-size'] . 'px; font-family: ' . $atts['font'] . '; color:' . $atts['color'] . '; font-weight:' . $atts['font-weight'] . '">' . get_the_title($course_id) . '</span>';
		} else{
			return  '<span style="display: block; text-align: ' . $atts['align'] . '; font-size: ' . $atts['font-size'] . 'px; font-family: ' . $atts['font'] . '; color:' . $atts['color'] . '; font-weight:' . $atts['font-weight'] . '">' . get_the_title() . '</span>';
		}
	}

	$data = ob_get_clean();
	return $data;
}

/**
 * Render lesson resources
 *
 * @return string
 */
function tg_lesson_resources_shortcode( $atts = [] ) {
	ob_start();
	$lesson_id = tg_get_lesson_id_from_template();

	if ( $lesson_id ) {
		the_tg_resources( $lesson_id) ;
	}

	$data = ob_get_clean();
	return $data;
}

add_shortcode( 'tg_lesson_resources', 'tg_lesson_resources_shortcode' );

/**
 * Render mark complete button
 *
 * @param array $atts {
 * 					$complete_text Button text
 * 					$uncomplete_text Lesson complete message
 * 					}
 * @return string
 */
function tg_lesson_complete_button_shortcode( $atts = array() ) {
	$atts = shortcode_atts(array(
		'complete_text'   => '',
		'uncomplete_text' => ''
	), $atts);

	ob_start();
	$status = tg_is_current_user_assigned_to_lesson();
	if ($status['status'] == true) {
		$lesson_id = tg_get_lesson_id_from_template();
		if($lesson_id){
			$lesson = get_post($lesson_id);
			the_mark_lesson_as_complete_from($lesson, $atts['complete_text'], $atts['uncomplete_text']);
		} else{
			the_mark_lesson_as_complete_from(null, $atts['complete_text'], $atts['uncomplete_text']);
		}
	} else {
		echo $status['msg'];
	}

	$data = ob_get_clean();
	return $data;
}

add_shortcode( 'tg_lesson_complete_button', 'tg_lesson_complete_button_shortcode' );

/**
 * Render lesson index html
 *
 * @param array $atts
 * @return string
 */
function tg_lesson_index_shortcode( $atts ) {
	$atts = shortcode_atts( [
		'enable_collapsable_outlines' => '',
		'enable_open_close_all'       => ''
	], $atts );

	if ( ! is_user_logged_in() ) {
		return;
	}

	if ( ! is_singular( 'tg_course' ) && ! is_singular( 'tg_lesson' ) ) {
		return;
	}

	ob_start();

	$instance = [
		'wid_enable_collapsable_outlines' => $atts['enable_collapsable_outlines'],
		'wid_enable_open_close_all' => $atts['enable_open_close_all']
	];

	the_lessons_widget( $instance );

	$data = ob_get_clean();
	return $data;
}

add_shortcode( 'tg_lesson_index', 'tg_lesson_index_shortcode' );
add_shortcode( 'tg_navigation_widget', 'tg_lesson_index_shortcode' );

/*
display next lesson link
parameters - course_ids, link_text, not_found_text
shortcode [tg_next_lesson_link courses="2,5" link_text="Go to next lesson" not_found_text="All are done :)"]
*/
add_shortcode( 'tg_next_lesson_link', 'tg_next_lesson_link_sc' );

// display next lesson link
function tg_next_lesson_link_sc( $atts ){
	$atts = shortcode_atts( array(
		'courses' => '',
		'link_text' => '',
		'not_found_text' => __('All are completed','teachground')
	), $atts );
	ob_start();

	if(is_user_logged_in()){
		$ret = get_global_next_lesson_link($atts);
		if($ret['status'] == true){
			$lesson_id = $ret['lesson_id'];
			echo '<a href="'.get_permalink($lesson_id).'" class="next-lesson-global-link">'.
			($atts['link_text']!=''?$atts['link_text']:get_the_title($lesson_id))
			.'</a>';
		} else{
			echo $atts['not_found_text'];
		}
	}

	$data = ob_get_clean();
	return $data;
}


/*
display forminator form or quiz
parameters - post_id
shortcode [tg_forminator post_id="45"]
*/
add_shortcode( 'tg_forminator', 'tg_forminator_sc' );

// display next lesson link
function tg_forminator_sc(){
	ob_start();
	$lesson_id = tg_get_lesson_id_from_template();
	$enable_forminator = get_post_meta( $lesson_id, 'enable_forminator', true );
	$forminator_frm_type = get_post_meta( $lesson_id, 'forminator_frm_type', true );
	$forminator_frm_id = get_post_meta( $lesson_id, 'forminator_frm_id', true );
	$forminator_quiz_id = get_post_meta( $lesson_id, 'forminator_quiz_id', true );
	if($enable_forminator == 'yes'){
		if($forminator_frm_type == 'form'){
			echo do_shortcode('[forminator_form id="'.$forminator_frm_id.'"]');
		} else if($forminator_frm_type == 'quiz'){
			echo do_shortcode('[forminator_quiz id="'.$forminator_quiz_id.'"]');
		}
	}

	$data = ob_get_clean();
	return $data;
}
